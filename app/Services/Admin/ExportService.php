<?php

namespace App\Services\Admin;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentRefund;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    /**
     * Generate streamed CSV download with UTF-8 BOM to prevent Excel encoding corruptions.
     */
    public function export(string $type, Request $request): StreamedResponse
    {
        $filename = "lunara-export-{$type}-" . Carbon::now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($type, $request) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM so Excel opens Vietnamese characters correctly
            fwrite($handle, "\xEF\xBB\xBF");

            match ($type) {
                'orders' => $this->streamOrders($handle, $request),
                'products' => $this->streamProducts($handle, $request),
                'inventory' => $this->streamInventory($handle, $request),
                'customers' => $this->streamCustomers($handle, $request),
                'revenue' => $this->streamRevenue($handle, $request),
                'coupons' => $this->streamCoupons($handle, $request),
                default => fputcsv($handle, ['Error', 'Loại dữ liệu xuất không hợp lệ']),
            };

            fclose($handle);
        }, 200, $headers);
    }

    private function streamOrders($handle, Request $request): void
    {
        fputcsv($handle, [
            'Mã đơn hàng',
            'Tên khách hàng',
            'Email',
            'Số điện thoại',
            'Địa chỉ giao hàng',
            'Thành phố / Tỉnh',
            'Tổng tiền (VNĐ)',
            'Mã giảm giá',
            'Số tiền giảm',
            'Phương thức thanh toán',
            'Trạng thái thanh toán',
            'Trạng thái đơn hàng',
            'Ngày đặt hàng',
        ]);

        $query = Order::query()->latest();

        // Respect filters
        if ($status = $request->input('order_status')) {
            $query->where('order_status', $status);
        }
        if ($paymentStatus = $request->input('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }
        if ($from = $request->input('from')) {
            $query->where('created_at', '>=', Carbon::parse($from)->startOfDay());
        }
        if ($to = $request->input('to')) {
            $query->where('created_at', '<=', Carbon::parse($to)->endOfDay());
        }

        $query->chunk(100, function ($orders) use ($handle) {
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_code,
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->shipping_address,
                    $order->shipping_city,
                    (float) $order->grand_total,
                    $order->coupon_code ?? '—',
                    (float) ($order->discount_amount ?? 0),
                    strtoupper($order->payment_method),
                    Order::PAYMENT_STATUS_LABELS[$order->payment_status] ?? $order->payment_status,
                    Order::STATUS_LABELS[$order->order_status] ?? $order->order_status,
                    $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }
        });
    }

    private function streamProducts($handle, Request $request): void
    {
        fputcsv($handle, [
            'ID',
            'Mã SKU',
            'Tên sản phẩm',
            'Loại sản phẩm',
            'Danh mục',
            'Giá gốc (VNĐ)',
            'Giá khuyến mãi (VNĐ)',
            'Tồn kho (Single)',
            'Trạng thái kho',
            'Đang mở bán',
            'Số lượng đã bán',
            'Ngày tạo',
        ]);

        $query = Product::withTrashed()->with('category')->latest('id');

        $query->chunk(100, function ($products) use ($handle) {
            foreach ($products as $p) {
                fputcsv($handle, [
                    $p->id,
                    $p->sku,
                    $p->name,
                    $p->product_type,
                    $p->category ? $p->category->name : '—',
                    (float) $p->regular_price,
                    $p->sale_price ? (float) $p->sale_price : '',
                    $p->stock_quantity,
                    $p->stock_status,
                    $p->is_active ? 'Có' : 'Không',
                    $p->sold_count ?? 0,
                    $p->created_at ? $p->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }
        });
    }

    private function streamInventory($handle, Request $request): void
    {
        fputcsv($handle, [
            'Mã SKU',
            'Tên sản phẩm',
            'Loại',
            'Tồn kho đơn (Stock Qty)',
            'Tồn thực tế khả dụng (Available)',
            'Trạng thái tồn',
            'Linh kiện giới hạn (nếu combo/gift)',
        ]);

        $threshold = (int) config('lunara.low_stock_threshold', 5);
        $products = Product::where('is_active', true)->with(['bundleItems.component'])->get();

        foreach ($products as $p) {
            $avail = $p->availableQuantity();
            $limitingInfo = '—';

            if ($p->isBundle()) {
                $analytics = app(AnalyticsService::class);
                $lim = $analytics->findLimitingComponent($p);
                if ($lim) {
                    $limitingInfo = "{$lim['sku']} - {$lim['name']} (Tồn: {$lim['stock']}, Cần: {$lim['required']})";
                }
            }

            $status = 'Bình thường';
            if ($avail <= 0) {
                $status = 'Hết hàng';
            } elseif ($avail <= $threshold) {
                $status = 'Sắp hết hàng';
            }

            fputcsv($handle, [
                $p->sku,
                $p->name,
                $p->product_type,
                $p->product_type === 'single' ? $p->stock_quantity : '—',
                $avail,
                $status,
                $limitingInfo,
            ]);
        }
    }

    private function streamCustomers($handle, Request $request): void
    {
        fputcsv($handle, [
            'ID',
            'Tên khách hàng',
            'Email',
            'Ngày đăng ký',
            'Tổng số đơn',
            'Đơn hoàn thành',
            'Tổng chi tiêu thực tế (Net Spend VNĐ)',
            'Phân khúc khách hàng',
        ]);

        $insightsService = app(CustomerInsightsService::class);
        $customers = User::where('role', User::ROLE_USER)
            ->withCount('orders')
            ->withCount(['orders as completed_orders_count' => function ($q) {
                $q->where('order_status', Order::STATUS_COMPLETED);
            }])
            ->withSum(['orders as gross_spent' => function ($q) {
                $q->where('order_status', Order::STATUS_COMPLETED);
            }], 'grand_total')
            ->selectSub(function ($sub) {
                $sub->from('payment_refunds')
                    ->join('orders', 'payment_refunds.order_id', '=', 'orders.id')
                    ->whereColumn('orders.user_id', 'users.id')
                    ->where('payment_refunds.status', PaymentRefund::STATUS_SUCCEEDED)
                    ->selectRaw('COALESCE(SUM(payment_refunds.amount), 0)');
            }, 'refunded_amount')
            ->get();

        foreach ($customers as $c) {
            $gross = (float) ($c->gross_spent ?? 0.0);
            $refunded = (float) ($c->refunded_amount ?? 0.0);
            $netSpend = max(0.0, round($gross - $refunded, 2));
            $c->lifetime_spend = $netSpend;
            $segment = $insightsService->determineSegment($c);

            fputcsv($handle, [
                $c->id,
                $c->name,
                $c->email,
                $c->created_at ? $c->created_at->format('Y-m-d H:i:s') : '',
                $c->orders_count,
                $c->completed_orders_count,
                $netSpend,
                $segment,
            ]);
        }
    }

    private function streamRevenue($handle, Request $request): void
    {
        fputcsv($handle, [
            'Ngày',
            'Doanh số gộp (Gross Sales VNĐ)',
            'Tiền hoàn thành công (Refunds VNĐ)',
            'Doanh thu thuần (Net Revenue VNĐ)',
            'Số đơn hoàn thành',
            'Giá trị trung bình đơn (AOV VNĐ)',
            'Số sản phẩm bán ra (Units Sold)',
        ]);

        $analytics = app(AnalyticsService::class);
        $range = $analytics->resolveDateRanges(
            $request->input('range', '30d'),
            $request->input('from'),
            $request->input('to')
        );

        $period = CarbonPeriod::create($range['start']->copy()->startOfDay(), '1 day', $range['end']->copy()->startOfDay());

        foreach ($period as $day) {
            $dayStart = $day->copy()->startOfDay();
            $dayEnd = $day->copy()->endOfDay();

            $gross = (float) Order::query()
                ->where('order_status', Order::STATUS_COMPLETED)
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->sum('grand_total');

            $refund = (float) PaymentRefund::query()
                ->where('status', PaymentRefund::STATUS_SUCCEEDED)
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->sum('amount');

            $net = max(0.0, round($gross - $refund, 2));

            $ordersCount = Order::query()
                ->where('order_status', Order::STATUS_COMPLETED)
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->count();

            $aov = $ordersCount > 0 ? round($gross / $ordersCount, 2) : 0.0;

            $units = (int) Order::query()
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.order_status', Order::STATUS_COMPLETED)
                ->whereBetween('orders.created_at', [$dayStart, $dayEnd])
                ->sum('order_items.quantity');

            fputcsv($handle, [
                $day->format('Y-m-d'),
                $gross,
                $refund,
                $net,
                $ordersCount,
                $aov,
                $units,
            ]);
        }
    }

    private function streamCoupons($handle, Request $request): void
    {
        fputcsv($handle, [
            'Mã giảm giá',
            'Loại giảm giá',
            'Giá trị',
            'Đơn hàng tối thiểu (VNĐ)',
            'Giảm tối đa (VNĐ)',
            'Giới hạn sử dụng',
            'Đã sử dụng',
            'Trạng thái hoạt động',
            'Hiệu lực từ',
            'Hết hạn lúc',
        ]);

        $coupons = Coupon::latest()->get();

        foreach ($coupons as $cp) {
            fputcsv($handle, [
                $cp->code,
                $cp->type === 'percentage' ? 'Phần trăm' : 'Số tiền cố định',
                $cp->type === 'percentage' ? $cp->value . '%' : (float) $cp->value,
                (float) ($cp->minimum_order ?? 0),
                $cp->maximum_discount ? (float) $cp->maximum_discount : 'Không giới hạn',
                $cp->usage_limit ?: 'Không giới hạn',
                $cp->used_count ?? 0,
                $cp->is_active ? 'Hoạt động' : 'Tạm dừng',
                $cp->starts_at ? $cp->starts_at->format('Y-m-d H:i') : '—',
                $cp->expires_at ? $cp->expires_at->format('Y-m-d H:i') : '—',
            ]);
        }
    }
}
