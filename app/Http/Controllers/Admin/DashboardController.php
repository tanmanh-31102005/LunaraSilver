<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\Admin\AnalyticsService;
use App\Services\Admin\AttentionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private AnalyticsService $analyticsService,
        private AttentionService $attentionService
    ) {}

    public function index(Request $request): View
    {
        $range = $request->input('range', '30d');
        $from = $request->input('from');
        $to = $request->input('to');
        $topSort = $request->input('top_sort', 'units');

        // Resolve active date window and previous comparison period
        $ranges = $this->analyticsService->resolveDateRanges($range, $from, $to);

        // Core & secondary metrics with percentage change
        $metrics = $this->analyticsService->getDashboardMetrics(
            $ranges['start'],
            $ranges['end'],
            $ranges['prev_start'],
            $ranges['prev_end']
        );

        // Visual trends & distributions
        $revenueTrend = $this->analyticsService->getRevenueTrend(
            $ranges['range'],
            $ranges['start'],
            $ranges['end']
        );

        $ordersByStatus = $this->analyticsService->getOrdersByStatus(
            $ranges['start'],
            $ranges['end']
        );

        $paymentBreakdown = $this->analyticsService->getPaymentBreakdown(
            $ranges['start'],
            $ranges['end']
        );

        $topProducts = $this->analyticsService->getTopProducts(
            $ranges['start'],
            $ranges['end'],
            $topSort,
            6
        );

        // Operational health & attention
        $inventoryHealth = $this->analyticsService->getInventoryHealth(6);
        $attentionItems = $this->attentionService->getAttentionItems();

        // Recent products & orders (capped at 5 for operational quick-views and backward compatibility)
        $recentOrders = Order::query()
            ->with(['latestPayment'])
            ->latest()
            ->take(5)
            ->get();

        $recentProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $lowStockProducts = Product::query()
            ->where('product_type', 'single')
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', $inventoryHealth['threshold'])
            ->with(['category', 'primaryImage'])
            ->orderBy('stock_quantity')
            ->take(8)
            ->get();

        return view('admin.dashboard', [
            'ranges' => $ranges,
            'metrics' => $metrics,
            'revenueTrend' => $revenueTrend,
            'ordersByStatus' => $ordersByStatus,
            'paymentBreakdown' => $paymentBreakdown,
            'topProducts' => $topProducts,
            'topSort' => $topSort,
            'inventoryHealth' => $inventoryHealth,
            'attentionItems' => $attentionItems,
            'recentOrders' => $recentOrders,
            'recentProducts' => $recentProducts,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}

