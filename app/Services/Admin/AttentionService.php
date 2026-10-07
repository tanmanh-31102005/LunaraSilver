<?php

namespace App\Services\Admin;

use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentRefund;
use App\Models\Product;
use App\Models\Review;
use App\Models\SupportConversation;
use App\Models\SupportMessage;

class AttentionService
{
    /**
     * Priority levels
     */
    public const LEVEL_CRITICAL = 'critical';
    public const LEVEL_WARNING = 'warning';
    public const LEVEL_NORMAL = 'normal';

    /**
     * Gather actionable issues across orders, payments, refunds, inventory, reviews, and support.
     *
     * @return array<int, array{
     *     id: string,
     *     level: string,
     *     title: string,
     *     count: int,
     *     description: string,
     *     url: string,
     *     icon: string,
     *     badge_class: string
     * }>
     */
    public function getAttentionItems(): array
    {
        $items = [];
        $lowStockThreshold = (int) config('lunara.low_stock_threshold', 5);

        // 1. CRITICAL: Failed or rejected refunds
        $failedRefunds = PaymentRefund::query()
            ->whereIn('status', [PaymentRefund::STATUS_FAILED, PaymentRefund::STATUS_REJECTED])
            ->count();

        if ($failedRefunds > 0) {
            $items[] = [
                'id' => 'failed_refunds',
                'level' => self::LEVEL_CRITICAL,
                'title' => 'Hoàn tiền thất bại hoặc bị từ chối',
                'count' => $failedRefunds,
                'description' => "Có {$failedRefunds} yêu cầu hoàn tiền cần kiểm tra lại với ngân hàng / cổng thanh toán",
                'url' => route('admin.orders.index', ['payment_status' => 'failed']),
                'icon' => 'bi-exclamation-octagon-fill',
                'badge_class' => 'bg-danger text-white',
            ];
        }

        // 2. CRITICAL: VNPay payment failed on pending orders
        $vnpayFailed = Order::query()
            ->where('payment_method', 'vnpay')
            ->where('payment_status', 'failed')
            ->whereNotIn('order_status', [Order::STATUS_CANCELLED, Order::STATUS_COMPLETED])
            ->count();

        if ($vnpayFailed > 0) {
            $items[] = [
                'id' => 'vnpay_failed',
                'level' => self::LEVEL_CRITICAL,
                'title' => 'Giao dịch VNPay thất bại',
                'count' => $vnpayFailed,
                'description' => "Có {$vnpayFailed} đơn hàng thanh toán VNPay không thành công cần đối soát",
                'url' => route('admin.orders.index', ['payment_method' => 'vnpay', 'payment_status' => 'failed']),
                'icon' => 'bi-shield-slash-fill',
                'badge_class' => 'bg-danger text-white',
            ];
        }

        // 3. WARNING: Pending orders waiting for confirmation
        $pendingOrders = Order::query()
            ->where('order_status', Order::STATUS_PENDING)
            ->count();

        if ($pendingOrders > 0) {
            $items[] = [
                'id' => 'pending_orders',
                'level' => self::LEVEL_WARNING,
                'title' => 'Đơn hàng mới chờ xác nhận',
                'count' => $pendingOrders,
                'description' => "Có {$pendingOrders} đơn hàng đang chờ duyệt xuất kho & xử lý đóng gói",
                'url' => route('admin.orders.index', ['order_status' => Order::STATUS_PENDING]),
                'icon' => 'bi-clock-history',
                'badge_class' => 'bg-warning text-dark',
            ];
        }

        // 4. WARNING: Refunds pending / processing
        $pendingRefunds = PaymentRefund::query()
            ->whereIn('status', [PaymentRefund::STATUS_REQUESTED, PaymentRefund::STATUS_PROCESSING])
            ->count();

        if ($pendingRefunds > 0) {
            $items[] = [
                'id' => 'pending_refunds',
                'level' => self::LEVEL_WARNING,
                'title' => 'Yêu cầu hoàn tiền đang xử lý',
                'count' => $pendingRefunds,
                'description' => "Có {$pendingRefunds} hoàn tiền đang chờ kết quả xác nhận từ cổng VNPay",
                'url' => route('admin.orders.index', ['payment_status' => 'refund_pending']),
                'icon' => 'bi-arrow-counterclockwise',
                'badge_class' => 'bg-warning text-dark',
            ];
        }

        // 5. WARNING: Low stock products
        $lowStockCount = Product::query()
            ->where('product_type', 'single')
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', $lowStockThreshold)
            ->count();

        if ($lowStockCount > 0) {
            $items[] = [
                'id' => 'low_stock',
                'level' => self::LEVEL_WARNING,
                'title' => 'Sản phẩm sắp hết hàng',
                'count' => $lowStockCount,
                'description' => "Có {$lowStockCount} sản phẩm còn tồn kho ≤ {$lowStockThreshold} chiếc, cần nhập hàng",
                'url' => route('admin.products.index', ['product_type' => 'single', 'stock_status' => 'low_stock']),
                'icon' => 'bi-box-seam',
                'badge_class' => 'bg-warning text-dark',
            ];
        }

        // 6. NORMAL: Customer reviews pending moderation
        $pendingReviews = Review::query()
            ->where('status', 'pending')
            ->count();

        if ($pendingReviews > 0) {
            $items[] = [
                'id' => 'pending_reviews',
                'level' => self::LEVEL_NORMAL,
                'title' => 'Đánh giá sản phẩm chờ duyệt',
                'count' => $pendingReviews,
                'description' => "Có {$pendingReviews} phản hồi của khách hàng cần kiểm duyệt & phản hồi",
                'url' => route('admin.reviews.index', ['status' => 'pending']),
                'icon' => 'bi-star-half',
                'badge_class' => 'bg-info text-dark',
            ];
        }

        // 7. NORMAL: Unresolved customer support tickets & unread chats
        $unresolvedTickets = ContactMessage::query()
            ->whereIn('status', [ContactMessage::STATUS_NEW, ContactMessage::STATUS_IN_PROGRESS])
            ->count();

        $openChatConversations = SupportConversation::query()
            ->whereIn('status', [SupportConversation::STATUS_OPEN, SupportConversation::STATUS_ASSIGNED])
            ->count();

        $totalSupport = $unresolvedTickets + $openChatConversations;
        if ($totalSupport > 0) {
            $items[] = [
                'id' => 'unresolved_support',
                'level' => self::LEVEL_NORMAL,
                'title' => 'Hỗ trợ khách hàng chưa xử lý',
                'count' => $totalSupport,
                'description' => "Có {$unresolvedTickets} ticket liên hệ và {$openChatConversations} phiên live chat đang mở",
                'url' => route('admin.support.index'),
                'icon' => 'bi-headset',
                'badge_class' => 'bg-info text-dark',
            ];
        }

        return $items;
    }
}
