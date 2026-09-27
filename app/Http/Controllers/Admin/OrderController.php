<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderStatusService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function __construct(
        private OrderStatusService $statusService,
        private \App\Services\VNPay\PaymentReconciliationService $reconciliationService,
        private \App\Services\VNPay\RefundService $refundService
    ) {}

    public function index(Request $request): View
    {
        $query = Order::query()->with(['user'])->withCount('items');

        // Text Search
        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search): void {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($status = $request->input('order_status')) {
            if (in_array($status, Order::STATUSES, true)) {
                $query->where('order_status', $status);
            }
        }

        // Payment Status Filter
        if ($paymentStatus = $request->input('payment_status')) {
            if (in_array($paymentStatus, Order::PAYMENT_STATUSES, true)) {
                $query->where('payment_status', $paymentStatus);
            }
        }

        // Payment Method Filter
        if ($paymentMethod = $request->input('payment_method')) {
            if (in_array($paymentMethod, Order::PAYMENT_METHODS, true)) {
                $query->where('payment_method', $paymentMethod);
            }
        }

        // Date Range
        $from = $request->input('from');
        $to = $request->input('to');
        if ($from && $to && $from > $to) {
            // Normalize dates if inverted
            [$from, $to] = [$to, $from];
        }

        if ($from) {
            $query->whereDate('placed_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('placed_at', '<=', $to);
        }

        // Sorting
        match ($request->input('sort')) {
            'oldest' => $query->orderBy('placed_at', 'asc')->orderBy('id', 'asc'),
            'total_desc' => $query->orderBy('grand_total', 'desc'),
            'total_asc' => $query->orderBy('grand_total', 'asc'),
            default => $query->orderBy('placed_at', 'desc')->orderBy('id', 'desc'),
        };

        $orders = $query->paginate(15)->withQueryString();

        // Status Counts for fast tabs
        $counts = [
            'all' => Order::count(),
            'pending' => Order::where('order_status', 'pending')->count(),
            'confirmed' => Order::where('order_status', 'confirmed')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'shipping' => Order::where('order_status', 'shipping')->count(),
            'completed' => Order::where('order_status', 'completed')->count(),
            'cancelled' => Order::where('order_status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', [
            'orders' => $orders,
            'counts' => $counts,
            'currentStatus' => $status,
            'filters' => $request->only(['search', 'order_status', 'payment_status', 'payment_method', 'from', 'to', 'sort']),
        ]);
    }

    public function show(string $orderCode): View
    {
        $order = Order::query()
            ->where('order_code', $orderCode)
            ->with([
                'user',
                'items.product.primaryImage',
                'items.components.product.primaryImage',
                'payments.refunds',
                'refunds',
                'statusHistories.changedBy',
            ])
            ->firstOrFail();

        $allowedTransitions = $this->statusService->getAllowedTransitions($order->order_status);

        return view('admin.orders.show', [
            'order' => $order,
            'allowedTransitions' => $allowedTransitions,
        ]);
    }

    public function updateStatus(Request $request, string $orderCode): RedirectResponse
    {
        $validated = $request->validate([
            'order_status' => ['required', 'string', Rule::in(Order::STATUSES)],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $order = Order::query()->where('order_code', $orderCode)->firstOrFail();

        try {
            $updated = $this->statusService->updateStatus(
                $order,
                $validated['order_status'],
                $request->user(),
                $validated['note'] ?? null
            );

            return redirect()
                ->route('admin.orders.show', $orderCode)
                ->with('success', "Đã cập nhật trạng thái đơn hàng sang '{$updated->order_status_label}'.");
        } catch (ValidationException $e) {
            return redirect()
                ->route('admin.orders.show', $orderCode)
                ->withErrors($e->errors());
        }
    }

    public function cancel(Request $request, string $orderCode): RedirectResponse
    {
        $validated = $request->validate([
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $order = Order::query()->where('order_code', $orderCode)->firstOrFail();

        try {
            if ($order->payment_method === 'vnpay' && in_array($order->payment_status, ['paid', 'partially_refunded'], true)) {
                $result = $this->refundService->cancelOrderWithRefund(
                    $order,
                    $validated['note'] ?? 'Admin hủy đơn hàng.',
                    $request->user(),
                    $request->ip() ?? '127.0.0.1'
                );
            } else {
                $result = $this->statusService->cancelOrder(
                    $order,
                    $request->user(),
                    $validated['note'] ?? null
                );
            }

            $redirect = redirect()
                ->route('admin.orders.show', $orderCode)
                ->with('success', 'Đã hủy đơn hàng và hoàn lại tồn kho thành công.');

            if (! empty($result['warning'])) {
                $redirect->with('warning', $result['warning']);
            }

            return $redirect;
        } catch (ValidationException $e) {
            return redirect()
                ->route('admin.orders.show', $orderCode)
                ->withErrors($e->errors());
        }
    }

    /**
     * Manual QueryDr reconciliation for a specific payment attempt or latest payment.
     */
    public function reconcile(Request $request, string $orderCode): RedirectResponse
    {
        $order = Order::query()->where('order_code', $orderCode)->firstOrFail();

        $paymentId = $request->input('payment_id');
        $payment = $paymentId
            ? $order->payments()->where('id', $paymentId)->first()
            : ($order->latestPayment ?: $order->payments()->first());

        if (! $payment) {
            return redirect()
                ->route('admin.orders.show', $orderCode)
                ->with('error', 'Đơn hàng này chưa có dữ liệu lượt thanh toán nào.');
        }

        if (! $payment->isVNPay()) {
            return redirect()
                ->route('admin.orders.show', $orderCode)
                ->with('error', 'Đơn hàng này sử dụng phương thức ' . $order->payment_method_label . ', không phải VNPay.');
        }

        if (empty($payment->txn_ref)) {
            return redirect()
                ->route('admin.orders.show', $orderCode)
                ->with('error', 'Lượt thanh toán này thiếu mã tham chiếu (TxnRef) để đối soát sang VNPay.');
        }

        $result = $this->reconciliationService->reconcileVNPayPayment(
            payment: $payment,
            ipAddress: $request->ip() ?? '127.0.0.1',
            force: true
        );

        $msgType = $result['success'] ? 'success' : 'warning';
        return redirect()
            ->route('admin.orders.show', $orderCode)
            ->with($msgType, 'Kết quả đối soát VNPay QueryDr: ' . $result['message']);
    }

    /**
     * Process full or partial refund for a paid VNPay order.
     */
    public function refund(Request $request, string $orderCode): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1000'],
            'reason' => ['required', 'string', 'max:500'],
        ]);

        $order = Order::query()->where('order_code', $orderCode)->firstOrFail();

        if (! $order->canRefund()) {
            return redirect()
                ->route('admin.orders.show', $orderCode)
                ->with('error', 'Đơn hàng này không đủ điều kiện hoàn tiền (cần phương thức VNPay và trạng thái Đã thanh toán).');
        }

        try {
            $refund = $this->refundService->processRefund(
                order: $order,
                amount: (float) $validated['amount'],
                reason: $validated['reason'],
                requestedBy: $request->user()?->name ?? 'Admin',
                ipAddress: $request->ip() ?? '127.0.0.1'
            );

            if ($refund->isSuccessful()) {
                return redirect()
                    ->route('admin.orders.show', $orderCode)
                    ->with('success', 'Yêu cầu hoàn tiền đã được VNPay chấp nhận thành công (' . number_format($refund->amount) . ' đ).');
            }

            return redirect()
                ->route('admin.orders.show', $orderCode)
                ->with('error', 'Yêu cầu hoàn tiền thất bại từ phía VNPay: ' . ($refund->response_payload['vnp_Message'] ?? 'Lỗi không xác định'));
        } catch (ValidationException $e) {
            return redirect()
                ->route('admin.orders.show', $orderCode)
                ->withErrors($e->errors());
        }
    }
}
