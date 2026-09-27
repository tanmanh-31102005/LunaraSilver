<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\VNPay\PaymentReconciliationService;
use App\Services\VNPay\VNPayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class VNPayController extends Controller
{
    public function __construct(
        private VNPayService $vnpayService,
        private PaymentReconciliationService $reconciliationService
    ) {}

    /**
     * Customer returns from VNPay after payment.
     * Verifies return checksum and reconciles transaction with QueryDr.
     */
    public function return(Request $request): View|RedirectResponse
    {
        $allParams = $request->all();
        Log::info('VNPay Return callback received', ['params' => $allParams]);

        $isValidChecksum = $this->vnpayService->verifyReturnChecksum($allParams);
        $txnRef = (string) $request->input('vnp_TxnRef', '');

        /** @var Payment|null $payment */
        $payment = Payment::query()->where('txn_ref', $txnRef)->first();

        if (! $payment) {
            return view('payment.vnpay.return', [
                'success' => false,
                'isPaid' => false,
                'checksumValid' => $isValidChecksum,
                'message' => 'Không tìm thấy thông tin lượt thanh toán với mã tham chiếu: ' . htmlspecialchars($txnRef),
                'order' => null,
                'payment' => null,
                'vnpParams' => $allParams,
            ]);
        }

        $order = $payment->order;

        if (! $isValidChecksum) {
            Log::warning('VNPay Return checksum mismatch', [
                'txn_ref' => $txnRef,
                'vnp_SecureHash' => $request->input('vnp_SecureHash'),
            ]);

            return view('payment.vnpay.return', [
                'success' => false,
                'isPaid' => false,
                'checksumValid' => false,
                'message' => 'Chữ ký bảo mật (Checksum) không hợp lệ. Vui lòng liên hệ hỗ trợ.',
                'order' => $order,
                'payment' => $payment,
                'vnpParams' => $allParams,
            ]);
        }

        // Always reconcile with VNPay via QueryDr for maximum reliability (especially on InfinityFree)
        $reconcileResult = $this->reconciliationService->reconcileVNPayPayment(
            payment: $payment,
            ipAddress: $request->ip() ?? '127.0.0.1',
            force: true
        );

        $order->refresh();
        $payment->refresh();

        // Fallback: If return checksum was verified, responseCode is '00', and transactionStatus is '00',
        // but QueryDr was throttled/duplicate, ensure payment is marked paid.
        if (! $payment->isPaid() && $request->input('vnp_ResponseCode') === '00') {
            $txnStatus = (string) $request->input('vnp_TransactionStatus', '00');
            if ($txnStatus === '00') {
                $payment->status = Payment::STATUS_PAID;
                $payment->vnp_transaction_no = (string) $request->input('vnp_TransactionNo');
                $payment->vnp_bank_code = (string) $request->input('vnp_BankCode');
                $payment->vnp_card_type = (string) $request->input('vnp_CardType');
                $payment->vnp_pay_date = (string) $request->input('vnp_PayDate');
                $payment->paid_at = now();
                $payment->save();

                if ($order && $order->payment_status !== 'paid') {
                    $order->payment_status = 'paid';
                    if ($order->order_status === 'pending') {
                        $order->order_status = 'confirmed';
                    }
                    $order->save();
                }
            }
        }

        // Grant session authorization for order viewing
        if ($order) {
            $request->session()->put('last_order_code', $order->order_code);
            $authorized = (array) $request->session()->get('authorized_orders', []);
            $authorized[] = $order->id;
            $request->session()->put('authorized_orders', array_values(array_unique($authorized)));
        }

        $isPaid = $payment->isPaid() || $order?->payment_status === 'paid';

        return view('payment.vnpay.return', [
            'success' => $isPaid,
            'isPaid' => $isPaid,
            'checksumValid' => true,
            'message' => $reconcileResult['message'],
            'order' => $order,
            'payment' => $payment,
            'vnpParams' => $allParams,
        ]);
    }

    /**
     * VNPay IPN (Instant Payment Notification) Webhook.
     * Complies strictly with VNPay JSON spec: {"RspCode": "...", "Message": "..."}
     */
    public function ipn(Request $request): JsonResponse
    {
        $allParams = $request->all();
        Log::info('VNPay IPN webhook received', ['params' => $allParams]);

        // 1. Verify Checksum
        if (! $this->vnpayService->verifyReturnChecksum($allParams)) {
            Log::warning('VNPay IPN invalid checksum', ['params' => $allParams]);
            return response()->json([
                'RspCode' => '97',
                'Message' => 'Invalid Checksum',
            ]);
        }

        $txnRef = (string) $request->input('vnp_TxnRef', '');
        /** @var Payment|null $payment */
        $payment = Payment::query()->where('txn_ref', $txnRef)->first();

        // 2. Order / Payment not found
        if (! $payment || ! $payment->order) {
            return response()->json([
                'RspCode' => '01',
                'Message' => 'Order Not Found',
            ]);
        }

        // 3. Amount check
        $vnpAmount = ((float) $request->input('vnp_Amount', 0)) / 100;
        if (abs($vnpAmount - (float) $payment->amount) > 1.0) {
            return response()->json([
                'RspCode' => '04',
                'Message' => 'Invalid Amount',
            ]);
        }

        // 4. Check if already confirmed
        if ($payment->isPaid()) {
            return response()->json([
                'RspCode' => '02',
                'Message' => 'Order already confirmed',
            ]);
        }

        // 5. Reconcile transaction with VNPay
        $this->reconciliationService->reconcileVNPayPayment(
            payment: $payment,
            ipAddress: $request->ip() ?? '127.0.0.1',
            force: true
        );

        return response()->json([
            'RspCode' => '00',
            'Message' => 'Confirm Success',
        ]);
    }

    /**
     * Retry payment for an unpaid order (creates a new Payment attempt).
     */
    public function retry(Request $request, string $orderCode): RedirectResponse
    {
        /** @var Order $order */
        $order = Order::query()->where('order_code', $orderCode)->firstOrFail();

        // Authorization check
        if ($order->user_id !== auth()->id() && ! auth()->user()?->isAdmin()) {
            abort(403, 'Bạn không có quyền thực hiện thao tác này.');
        }

        if (! $order->canRetryPayment()) {
            return redirect()->route('account.orders.show', $order->order_code)
                ->with('error', 'Đơn hàng này hiện không thể thanh toán lại (trạng thái: ' . $order->order_status_label . ', thanh toán: ' . $order->payment_status_label . ').');
        }

        // Create a new Payment attempt for the retry with guaranteed unique txn_ref
        $attemptCount = $order->payments()->count() + 1;
        $txnRef = $order->order_code . '-' . $attemptCount;
        while (Payment::query()->where('txn_ref', $txnRef)->exists()) {
            $attemptCount++;
            $txnRef = $order->order_code . '-' . $attemptCount;
        }

        $newPayment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'txn_ref' => $txnRef,
            'vnp_create_date' => Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis'),
            'amount' => $order->grand_total,
            'status' => Payment::STATUS_PENDING,
            'query_count' => 0,
        ]);

        $paymentUrl = $this->vnpayService->createPaymentUrl($newPayment, $request->ip() ?? '127.0.0.1');

        return redirect()->away($paymentUrl);
    }
}
