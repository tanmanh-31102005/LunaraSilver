<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\SupportMessage;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $threshold = (int) config('lunara.low_stock_threshold', 5);

        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $activeProducts = Product::where('is_active', true)->count();

        // Single stock calculations
        $lowStockSingles = Product::query()
            ->where('product_type', 'single')
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', $threshold)
            ->count();

        $singleOutOfStock = Product::query()
            ->where('product_type', 'single')
            ->where(function ($q): void {
                $q->where('stock_quantity', '<=', 0)
                    ->orWhere('stock_status', 'out_of_stock');
            })
            ->count();

        // Bundle availability
        $bundleOutOfStock = 0;
        $bundles = Product::query()
            ->whereIn('product_type', ['collection', 'gift'])
            ->with(['bundleItems.component'])
            ->get();
        foreach ($bundles as $bundle) {
            if ($bundle->availableQuantity() <= 0) {
                $bundleOutOfStock++;
            }
        }

        $outOfStockCount = $singleOutOfStock + $bundleOutOfStock;

        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();

        // Attention Required queries
        $lowStockProducts = Product::query()
            ->where('product_type', 'single')
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', $threshold)
            ->with(['category', 'primaryImage'])
            ->orderBy('stock_quantity')
            ->take(8)
            ->get();

        $outOfStockProducts = Product::query()
            ->where('product_type', 'single')
            ->where('stock_quantity', '<=', 0)
            ->with(['category', 'primaryImage'])
            ->orderBy('name')
            ->take(8)
            ->get();

        $inactiveProducts = Product::query()
            ->where('is_active', false)
            ->with(['category', 'primaryImage'])
            ->latest('updated_at')
            ->take(8)
            ->get();

        $pendingOrderItems = Order::query()
            ->where('order_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Recent Activity
        $recentProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $recentOrders = Order::query()
            ->latest()
            ->take(5)
            ->get();

        $unresolvedSupport = ContactMessage::whereIn('status', [ContactMessage::STATUS_NEW, ContactMessage::STATUS_IN_PROGRESS])->count();
        $unreadChatMessages = SupportMessage::where('sender_type', SupportMessage::SENDER_CUSTOMER)->whereNull('read_at')->count();
        $pendingReviewsCount = \App\Models\Review::where('status', 'pending')->count();
        $approvedReviewsAvg = round((float) (\App\Models\Review::where('status', 'approved')->avg('rating') ?: 0), 1);

        return view('admin.dashboard', [
            'metrics' => [
                'total_products' => $totalProducts,
                'total_categories' => $totalCategories,
                'active_products' => $activeProducts,
                'low_stock_singles' => $lowStockSingles,
                'out_of_stock_singles' => $singleOutOfStock,
                'out_of_stock_products' => $outOfStockCount,
                'total_orders' => $totalOrders,
                'pending_orders' => $pendingOrders,
                'unresolved_support' => $unresolvedSupport,
                'unread_chat_messages' => $unreadChatMessages,
                'pending_reviews_count' => $pendingReviewsCount,
                'approved_reviews_avg' => $approvedReviewsAvg,
                'low_stock_threshold' => $threshold,
            ],
            'lowStockProducts' => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'inactiveProducts' => $inactiveProducts,
            'pendingOrderItems' => $pendingOrderItems,
            'recentProducts' => $recentProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
