<?php

namespace App\Services\Admin;

use App\Models\ContactMessage;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\SupportConversation;
use App\Models\User;

class AdminSearchService
{
    /**
     * Search across orders, products, customers, support tickets, and coupons.
     * Capped at 5 results per group for instant autocomplete overlay.
     *
     * @return array<int, array{
     *     group: string,
     *     icon: string,
     *     items: array<int, array{
     *         title: string,
     *         subtitle: string,
     *         url: string,
     *         badge: ?string,
     *         badge_class: ?string
     *     }>
     * }>
     */
    public function search(string $keyword): array
    {
        $term = trim($keyword);
        if ($term === '' || mb_strlen($term) < 2) {
            return [];
        }

        $results = [];

        // 1. ORDERS
        $orders = Order::query()
            ->where(function ($q) use ($term) {
                $q->where('order_code', 'like', "%{$term}%")
                  ->orWhere('customer_name', 'like', "%{$term}%")
                  ->orWhere('customer_email', 'like', "%{$term}%")
                  ->orWhere('customer_phone', 'like', "%{$term}%");
            })
            ->latest()
            ->take(5)
            ->get();

        if ($orders->isNotEmpty()) {
            $items = $orders->map(function (Order $order) {
                return [
                    'title' => '#' . $order->order_code . ' — ' . $order->customer_name,
                    'subtitle' => number_format((float) $order->grand_total, 0, ',', '.') . '₫ • ' . $order->created_at->format('d/m/Y H:i'),
                    'url' => route('admin.orders.show', $order->order_code),
                    'badge' => Order::STATUS_LABELS[$order->order_status] ?? $order->order_status,
                    'badge_class' => match ($order->order_status) {
                        'completed' => 'bg-success text-white',
                        'pending' => 'bg-warning text-dark',
                        'cancelled' => 'bg-danger text-white',
                        default => 'bg-secondary text-white',
                    },
                ];
            })->all();

            $results[] = [
                'group' => 'Đơn hàng',
                'icon' => 'bi-receipt',
                'items' => $items,
            ];
        }

        // 2. PRODUCTS
        $products = Product::withTrashed()
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%");
            })
            ->with(['category', 'primaryImage'])
            ->take(5)
            ->get();

        if ($products->isNotEmpty()) {
            $items = $products->map(function (Product $prod) {
                $avail = $prod->availableQuantity();
                return [
                    'title' => $prod->name,
                    'subtitle' => 'SKU: ' . $prod->sku . ' • Giá: ' . number_format((float) $prod->effective_price, 0, ',', '.') . '₫',
                    'url' => route('admin.products.edit', $prod->id),
                    'badge' => $prod->trashed() ? 'Đã xóa' : ($prod->is_active ? "Tồn: {$avail}" : 'Ẩn'),
                    'badge_class' => $prod->trashed() ? 'bg-danger text-white' : ($prod->is_active ? 'bg-light text-dark border' : 'bg-secondary text-white'),
                ];
            })->all();

            $results[] = [
                'group' => 'Sản phẩm',
                'icon' => 'bi-box-seam',
                'items' => $items,
            ];
        }

        // 3. CUSTOMERS
        $customers = User::query()
            ->where('role', User::ROLE_USER)
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhereHas('orders', function ($oq) use ($term) {
                      $oq->where('customer_phone', 'like', "%{$term}%");
                  });
            })
            ->take(5)
            ->get();

        if ($customers->isNotEmpty()) {
            $items = $customers->map(function (User $cust) {
                return [
                    'title' => $cust->name,
                    'subtitle' => $cust->email . ' • Tham gia: ' . ($cust->created_at ? $cust->created_at->format('d/m/Y') : '—'),
                    'url' => route('admin.customers.show', $cust->id),
                    'badge' => 'Khách hàng',
                    'badge_class' => 'bg-primary-subtle text-primary border',
                ];
            })->all();

            $results[] = [
                'group' => 'Khách hàng',
                'icon' => 'bi-people',
                'items' => $items,
            ];
        }

        // 4. SUPPORT (Tickets & Chats)
        $tickets = ContactMessage::query()
            ->where(function ($q) use ($term) {
                $q->where('reference', 'like', "%{$term}%")
                  ->orWhere('subject', 'like', "%{$term}%")
                  ->orWhere('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            })
            ->latest()
            ->take(5)
            ->get();

        if ($tickets->isNotEmpty()) {
            $items = $tickets->map(function (ContactMessage $ticket) {
                return [
                    'title' => '#' . $ticket->reference . ' — ' . $ticket->subject,
                    'subtitle' => $ticket->name . ' (' . $ticket->email . ')',
                    'url' => route('admin.support.show', $ticket->id),
                    'badge' => ContactMessage::STATUS_LABELS[$ticket->status] ?? $ticket->status,
                    'badge_class' => match ($ticket->status) {
                        ContactMessage::STATUS_NEW => 'bg-danger text-white',
                        ContactMessage::STATUS_IN_PROGRESS => 'bg-warning text-dark',
                        ContactMessage::STATUS_RESOLVED => 'bg-success text-white',
                        default => 'bg-secondary text-white',
                    },
                ];
            })->all();

            $results[] = [
                'group' => 'Hỗ trợ khách hàng',
                'icon' => 'bi-headset',
                'items' => $items,
            ];
        }

        // 5. COUPONS
        $coupons = Coupon::query()
            ->where('code', 'like', "%{$term}%")
            ->take(5)
            ->get();

        if ($coupons->isNotEmpty()) {
            $items = $coupons->map(function (Coupon $cp) {
                return [
                    'title' => 'Mã: ' . $cp->code,
                    'subtitle' => ($cp->type === 'percentage' ? $cp->value . '%' : number_format((float) $cp->value, 0, ',', '.') . '₫') . ' • Đã dùng: ' . $cp->used_count . ' lần',
                    'url' => route('admin.coupons.edit', $cp->id),
                    'badge' => $cp->is_active ? 'Hoạt động' : 'Tạm tắt',
                    'badge_class' => $cp->is_active ? 'bg-success text-white' : 'bg-secondary text-white',
                ];
            })->all();

            $results[] = [
                'group' => 'Mã giảm giá',
                'icon' => 'bi-ticket-perforated',
                'items' => $items,
            ];
        }

        return $results;
    }
}
