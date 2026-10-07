<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentRefund;
use App\Models\Product;
use App\Models\Review;
use App\Models\SupportMessage;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public const TIMEZONE = 'Asia/Ho_Chi_Minh';

    /**
     * Parse date range string into current and comparison previous Carbon periods.
     *
     * @return array{
     *     range: string,
     *     start: Carbon,
     *     end: Carbon,
     *     prev_start: Carbon,
     *     prev_end: Carbon,
     *     label: string
     * }
     */
    public function resolveDateRanges(?string $range = '30d', ?string $customFrom = null, ?string $customTo = null): array
    {
        $now = Carbon::now(self::TIMEZONE);
        $range = $range ?: '30d';

        switch ($range) {
            case 'today':
                $start = $now->copy()->startOfDay();
                $end = $now->copy()->endOfDay();
                $prevStart = $start->copy()->subDay();
                $prevEnd = $end->copy()->subDay();
                $label = 'Hôm nay';
                break;

            case '7d':
                $start = $now->copy()->subDays(6)->startOfDay();
                $end = $now->copy()->endOfDay();
                $diffDays = $start->diffInDays($end) + 1;
                $prevEnd = $start->copy()->subSecond();
                $prevStart = $prevEnd->copy()->subDays($diffDays - 1)->startOfDay();
                $label = '7 ngày qua';
                break;

            case '90d':
                $start = $now->copy()->subDays(89)->startOfDay();
                $end = $now->copy()->endOfDay();
                $diffDays = $start->diffInDays($end) + 1;
                $prevEnd = $start->copy()->subSecond();
                $prevStart = $prevEnd->copy()->subDays($diffDays - 1)->startOfDay();
                $label = '90 ngày qua';
                break;

            case 'custom':
                if ($customFrom && $customTo) {
                    $start = Carbon::parse($customFrom, self::TIMEZONE)->startOfDay();
                    $end = Carbon::parse($customTo, self::TIMEZONE)->endOfDay();
                    if ($start->gt($end)) {
                        [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
                    }
                } else {
                    $start = $now->copy()->subDays(29)->startOfDay();
                    $end = $now->copy()->endOfDay();
                }
                $diffDays = max(1, $start->diffInDays($end) + 1);
                $prevEnd = $start->copy()->subSecond();
                $prevStart = $prevEnd->copy()->subDays($diffDays - 1)->startOfDay();
                $label = $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y');
                break;

            case '30d':
            default:
                $range = '30d';
                $start = $now->copy()->subDays(29)->startOfDay();
                $end = $now->copy()->endOfDay();
                $diffDays = $start->diffInDays($end) + 1;
                $prevEnd = $start->copy()->subSecond();
                $prevStart = $prevEnd->copy()->subDays($diffDays - 1)->startOfDay();
                $label = '30 ngày qua';
                break;
        }

        return [
            'range' => $range,
            'start' => $start,
            'end' => $end,
            'prev_start' => $prevStart,
            'prev_end' => $prevEnd,
            'label' => $label,
        ];
    }

    /**
     * Calculate core primary & secondary KPI metrics for dashboard.
     */
    public function getDashboardMetrics(Carbon $start, Carbon $end, Carbon $prevStart, Carbon $prevEnd): array
    {
        $cacheKey = 'admin.dashboard.metrics.' . $start->timestamp . '.' . $end->timestamp;

        if (app()->environment('testing')) {
            Cache::forget($cacheKey);
        }

        return Cache::remember($cacheKey, 180, function () use ($start, $end, $prevStart, $prevEnd) {
            // Current period core metrics
            $currentGrossSales = (float) Order::query()
                ->where('order_status', Order::STATUS_COMPLETED)
                ->whereBetween('created_at', [$start, $end])
                ->sum('grand_total');

            $currentRefundAmount = (float) PaymentRefund::query()
                ->where('status', PaymentRefund::STATUS_SUCCEEDED)
                ->whereBetween('created_at', [$start, $end])
                ->sum('amount');

            $currentNetRevenue = max(0.0, round($currentGrossSales - $currentRefundAmount, 2));

            $currentCompletedOrders = Order::query()
                ->where('order_status', Order::STATUS_COMPLETED)
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $currentAOV = $currentCompletedOrders > 0
                ? round($currentGrossSales / $currentCompletedOrders, 2)
                : 0.0;

            $currentUnitsSold = (int) OrderItem::query()
                ->whereHas('order', function ($q) use ($start, $end) {
                    $q->where('order_status', Order::STATUS_COMPLETED)
                      ->whereBetween('created_at', [$start, $end]);
                })
                ->sum('quantity');

            // Previous period core metrics for comparison
            $prevGrossSales = (float) Order::query()
                ->where('order_status', Order::STATUS_COMPLETED)
                ->whereBetween('created_at', [$prevStart, $prevEnd])
                ->sum('grand_total');

            $prevRefundAmount = (float) PaymentRefund::query()
                ->where('status', PaymentRefund::STATUS_SUCCEEDED)
                ->whereBetween('created_at', [$prevStart, $prevEnd])
                ->sum('amount');

            $prevNetRevenue = max(0.0, round($prevGrossSales - $prevRefundAmount, 2));

            $prevCompletedOrders = Order::query()
                ->where('order_status', Order::STATUS_COMPLETED)
                ->whereBetween('created_at', [$prevStart, $prevEnd])
                ->count();

            $prevAOV = $prevCompletedOrders > 0
                ? round($prevGrossSales / $prevCompletedOrders, 2)
                : 0.0;

            $prevUnitsSold = (int) OrderItem::query()
                ->whereHas('order', function ($q) use ($prevStart, $prevEnd) {
                    $q->where('order_status', Order::STATUS_COMPLETED)
                      ->whereBetween('created_at', [$prevStart, $prevEnd]);
                })
                ->sum('quantity');

            // Secondary metrics
            $totalCustomers = User::where('role', User::ROLE_USER)->count();
            $newCustomers = User::where('role', User::ROLE_USER)
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $prevNewCustomers = User::where('role', User::ROLE_USER)
                ->whereBetween('created_at', [$prevStart, $prevEnd])
                ->count();

            $pendingOrders = Order::where('order_status', Order::STATUS_PENDING)->count();

            $lowStockThreshold = (int) config('lunara.low_stock_threshold', 5);
            $lowStockSingles = Product::query()
                ->where('product_type', 'single')
                ->where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->where('stock_quantity', '<=', $lowStockThreshold)
                ->count();

            $refundPendingCount = PaymentRefund::query()
                ->whereIn('status', [PaymentRefund::STATUS_REQUESTED, PaymentRefund::STATUS_PROCESSING])
                ->count();

            $unresolvedSupportCount = ContactMessage::query()
                ->whereIn('status', [ContactMessage::STATUS_NEW, ContactMessage::STATUS_IN_PROGRESS])
                ->count();

            $unreadChatMessagesCount = SupportMessage::query()
                ->where('sender_type', SupportMessage::SENDER_CUSTOMER)
                ->whereNull('read_at')
                ->count();

            $pendingReviewsCount = Review::query()
                ->where('status', 'pending')
                ->count();

            $approvedReviewsAvg = round((float) (Review::where('status', 'approved')->avg('rating') ?: 0), 1);

            return [
                'net_revenue' => [
                    'current' => $currentNetRevenue,
                    'previous' => $prevNetRevenue,
                    'change' => $this->calculatePercentageChange($currentNetRevenue, $prevNetRevenue),
                ],
                'gross_sales' => [
                    'current' => $currentGrossSales,
                    'previous' => $prevGrossSales,
                    'change' => $this->calculatePercentageChange($currentGrossSales, $prevGrossSales),
                ],
                'refund_amount' => [
                    'current' => $currentRefundAmount,
                    'previous' => $prevRefundAmount,
                    'change' => $this->calculatePercentageChange($currentRefundAmount, $prevRefundAmount),
                ],
                'completed_orders' => [
                    'current' => $currentCompletedOrders,
                    'previous' => $prevCompletedOrders,
                    'change' => $this->calculatePercentageChange($currentCompletedOrders, $prevCompletedOrders),
                ],
                'aov' => [
                    'current' => $currentAOV,
                    'previous' => $prevAOV,
                    'change' => $this->calculatePercentageChange($currentAOV, $prevAOV),
                ],
                'units_sold' => [
                    'current' => $currentUnitsSold,
                    'previous' => $prevUnitsSold,
                    'change' => $this->calculatePercentageChange($currentUnitsSold, $prevUnitsSold),
                ],
                'new_customers' => [
                    'current' => $newCustomers,
                    'previous' => $prevNewCustomers,
                    'change' => $this->calculatePercentageChange($newCustomers, $prevNewCustomers),
                ],
                'total_customers' => $totalCustomers,
                'total_products' => Product::count(),
                'total_categories' => Category::count(),
                'active_products' => Product::where('is_active', true)->count(),
                'total_orders' => Order::count(),
                'pending_orders' => $pendingOrders,
                'low_stock_singles' => $lowStockSingles,
                'refund_pending_count' => $refundPendingCount,
                'unresolved_support' => $unresolvedSupportCount + $unreadChatMessagesCount,
                'pending_reviews_count' => $pendingReviewsCount,
                'approved_reviews_avg' => $approvedReviewsAvg,
                'low_stock_threshold' => $lowStockThreshold,
            ];
        });
    }

    /**
     * Calculate percentage change with safe division by zero handling.
     */
    public function calculatePercentageChange(float $current, float $previous): ?float
    {
        if ($previous <= 0.0) {
            return null; // Return null so UI renders "—"
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Generate trend series data for Chart.js.
     * Granularity:
     * - 'today' -> by hour (0 to 23)
     * - 1 to 90 days -> by day
     * - > 90 days -> by week
     */
    public function getRevenueTrend(string $range, Carbon $start, Carbon $end): array
    {
        $cacheKey = 'admin.dashboard.trend.' . $range . '.' . $start->timestamp . '.' . $end->timestamp;

        if (app()->environment('testing')) {
            Cache::forget($cacheKey);
        }

        return Cache::remember($cacheKey, 180, function () use ($range, $start, $end) {
            $labels = [];
            $netRevenueData = [];
            $grossSalesData = [];

            if ($range === 'today') {
                for ($h = 0; $h < 24; $h++) {
                    $labels[] = sprintf('%02d:00', $h);
                    $hourStart = $start->copy()->hour($h)->minute(0)->second(0);
                    $hourEnd = $start->copy()->hour($h)->minute(59)->second(59);

                    $gross = (float) Order::query()
                        ->where('order_status', Order::STATUS_COMPLETED)
                        ->whereBetween('created_at', [$hourStart, $hourEnd])
                        ->sum('grand_total');

                    $refund = (float) PaymentRefund::query()
                        ->where('status', PaymentRefund::STATUS_SUCCEEDED)
                        ->whereBetween('created_at', [$hourStart, $hourEnd])
                        ->sum('amount');

                    $grossSalesData[] = round($gross, 2);
                    $netRevenueData[] = max(0.0, round($gross - $refund, 2));
                }
            } else {
                $days = $start->diffInDays($end) + 1;

                if ($days <= 90) {
                    $period = CarbonPeriod::create($start->copy()->startOfDay(), '1 day', $end->copy()->startOfDay());

                    // Bulk query completed orders in period grouped by date
                    $ordersByDate = Order::query()
                        ->selectRaw('DATE(created_at) as order_date, SUM(grand_total) as total')
                        ->where('order_status', Order::STATUS_COMPLETED)
                        ->whereBetween('created_at', [$start, $end])
                        ->groupBy('order_date')
                        ->pluck('total', 'order_date');

                    // Bulk query successful refunds in period grouped by date
                    $refundsByDate = PaymentRefund::query()
                        ->selectRaw('DATE(created_at) as refund_date, SUM(amount) as total')
                        ->where('status', PaymentRefund::STATUS_SUCCEEDED)
                        ->whereBetween('created_at', [$start, $end])
                        ->groupBy('refund_date')
                        ->pluck('total', 'refund_date');

                    foreach ($period as $date) {
                        $dateKey = $date->format('Y-m-d');
                        $labels[] = $date->format('d/m');
                        $gross = (float) ($ordersByDate[$dateKey] ?? 0.0);
                        $refund = (float) ($refundsByDate[$dateKey] ?? 0.0);

                        $grossSalesData[] = round($gross, 2);
                        $netRevenueData[] = max(0.0, round($gross - $refund, 2));
                    }
                } else {
                    // Weekly aggregation for large date ranges
                    $cur = $start->copy()->startOfWeek();
                    while ($cur->lte($end)) {
                        $weekEnd = $cur->copy()->endOfWeek();
                        $actualStart = $cur->lt($start) ? $start : $cur;
                        $actualEnd = $weekEnd->gt($end) ? $end : $weekEnd;

                        $labels[] = $actualStart->format('d/m') . ' - ' . $actualEnd->format('d/m');

                        $gross = (float) Order::query()
                            ->where('order_status', Order::STATUS_COMPLETED)
                            ->whereBetween('created_at', [$actualStart, $actualEnd])
                            ->sum('grand_total');

                        $refund = (float) PaymentRefund::query()
                            ->where('status', PaymentRefund::STATUS_SUCCEEDED)
                            ->whereBetween('created_at', [$actualStart, $actualEnd])
                            ->sum('amount');

                        $grossSalesData[] = round($gross, 2);
                        $netRevenueData[] = max(0.0, round($gross - $refund, 2));

                        $cur->addWeek();
                    }
                }
            }

            return [
                'labels' => $labels,
                'net_revenue' => $netRevenueData,
                'gross_sales' => $grossSalesData,
            ];
        });
    }

    /**
     * Orders distribution grouped by order status within the selected date range.
     */
    public function getOrdersByStatus(Carbon $start, Carbon $end): array
    {
        $counts = Order::query()
            ->selectRaw('order_status, COUNT(*) as count')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('order_status')
            ->pluck('count', 'order_status');

        $result = [];
        foreach (Order::STATUSES as $status) {
            $result[$status] = [
                'label' => Order::STATUS_LABELS[$status] ?? ucfirst($status),
                'count' => (int) ($counts[$status] ?? 0),
            ];
        }

        return $result;
    }

    /**
     * Payment method breakdown (COD, VNPay, Bank Transfer) within the selected date range.
     */
    public function getPaymentBreakdown(Carbon $start, Carbon $end): array
    {
        $data = Order::query()
            ->selectRaw('payment_method, COUNT(*) as total_orders, SUM(grand_total) as total_amount')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('payment_method')
            ->get()
            ->keyBy('payment_method');

        $result = [];
        $labels = [
            'cod' => 'Thanh toán COD',
            'vnpay' => 'VNPay Online',
            'bank_transfer' => 'Chuyển khoản ngân hàng',
        ];

        foreach (Order::PAYMENT_METHODS as $method) {
            $item = $data->get($method);
            $result[$method] = [
                'label' => $labels[$method] ?? strtoupper($method),
                'orders_count' => $item ? (int) $item->total_orders : 0,
                'total_amount' => $item ? (float) $item->total_amount : 0.0,
            ];
        }

        return $result;
    }

    /**
     * Top selling products by units sold or by revenue within the selected date range.
     * Only completed orders are counted. Inactive products are included if sold historically.
     */
    public function getTopProducts(Carbon $start, Carbon $end, string $sortBy = 'units', int $limit = 5): Collection
    {
        $query = OrderItem::query()
            ->select(
                'order_items.product_id',
                'order_items.product_name',
                'order_items.product_sku',
                DB::raw('SUM(order_items.quantity) as units_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as total_orders')
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.order_status', Order::STATUS_COMPLETED)
            ->whereBetween('orders.created_at', [$start, $end])
            ->groupBy('order_items.product_id', 'order_items.product_name', 'order_items.product_sku');

        if ($sortBy === 'revenue') {
            $query->orderByDesc('total_revenue');
        } else {
            $query->orderByDesc('units_sold');
        }

        $items = $query->take($limit)->get();

        // Attach current product instance (with soft-deleted / inactive support) for images & status
        $productIds = $items->pluck('product_id')->filter()->unique();
        $products = Product::withTrashed()->with('primaryImage')->whereIn('id', $productIds)->get()->keyBy('id');

        return $items->map(function ($item) use ($products) {
            $prod = $products->get($item->product_id);
            $item->product = $prod;
            $item->is_active = $prod ? $prod->is_active : false;
            $item->product_type = $prod ? $prod->product_type : 'single';
            return $item;
        });
    }

    /**
     * Inventory health assessment: Single products vs Bundles.
     * Evaluates available quantity and identifies the limiting component for collections/gifts.
     */
    public function getInventoryHealth(int $limit = 8): array
    {
        $threshold = (int) config('lunara.low_stock_threshold', 5);

        // Low stock singles
        $lowStockSingles = Product::query()
            ->where('product_type', 'single')
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', $threshold)
            ->with(['category', 'primaryImage'])
            ->orderBy('stock_quantity')
            ->take($limit)
            ->get()
            ->map(function (Product $p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'type' => 'single',
                    'available' => $p->stock_quantity,
                    'status' => 'low_stock',
                    'limiting_component' => null,
                    'url' => route('admin.products.edit', $p),
                ];
            });

        // Out of stock singles
        $outOfStockSingles = Product::query()
            ->where('product_type', 'single')
            ->where('stock_quantity', '<=', 0)
            ->with(['category', 'primaryImage'])
            ->orderBy('name')
            ->take($limit)
            ->get()
            ->map(function (Product $p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'type' => 'single',
                    'available' => 0,
                    'status' => 'out_of_stock',
                    'limiting_component' => null,
                    'url' => route('admin.products.edit', $p),
                ];
            });

        // Evaluate bundles (collections & gifts)
        $bundles = Product::query()
            ->whereIn('product_type', ['collection', 'gift'])
            ->with(['bundleItems.component'])
            ->get();

        $bundleHealth = [];
        foreach ($bundles as $bundle) {
            $avail = $bundle->availableQuantity();
            $limiting = $this->findLimitingComponent($bundle);

            $status = 'in_stock';
            if ($avail <= 0) {
                $status = 'out_of_stock';
            } elseif ($avail <= $threshold) {
                $status = 'low_stock';
            }

            if ($status !== 'in_stock') {
                $bundleHealth[] = [
                    'id' => $bundle->id,
                    'name' => $bundle->name,
                    'sku' => $bundle->sku,
                    'type' => $bundle->product_type,
                    'available' => $avail,
                    'status' => $status,
                    'limiting_component' => $limiting,
                    'url' => route('admin.products.edit', $bundle),
                ];
            }
        }

        return [
            'threshold' => $threshold,
            'low_stock_singles' => $lowStockSingles,
            'out_of_stock_singles' => $outOfStockSingles,
            'troubled_bundles' => array_slice($bundleHealth, 0, $limit),
        ];
    }

    /**
     * Identify the bottleneck/limiting component for a bundle product.
     * Returns component details and stock constraint.
     */
    public function findLimitingComponent(Product $bundle): ?array
    {
        if (! $bundle->isBundle()) {
            return null;
        }

        $items = $bundle->bundleItems;
        if ($items->isEmpty()) {
            return null;
        }

        $minRatio = PHP_INT_MAX;
        $limiting = null;

        foreach ($items as $item) {
            $comp = $item->component;
            if (! $comp) {
                continue;
            }

            $req = max(1, (int) $item->quantity);
            $stock = max(0, (int) $comp->stock_quantity);
            $ratio = intdiv($stock, $req);

            if ($ratio < $minRatio) {
                $minRatio = $ratio;
                $limiting = [
                    'id' => $comp->id,
                    'name' => $comp->name,
                    'sku' => $comp->sku,
                    'stock' => $stock,
                    'required' => $req,
                    'available_for_bundle' => $ratio,
                ];
            }
        }

        return $limiting;
    }
}
