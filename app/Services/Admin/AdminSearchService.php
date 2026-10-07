<?php

namespace App\Services\Admin;

use App\Models\ContactMessage;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminSearchService
{
    /**
     * Search across orders, products, customers, support tickets, and coupons
     * with intent-based intelligent routing and tight column projections.
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

        $clean = ltrim($term, '#');
        $upper = strtoupper($clean);

        // Detect intent
        $isOrderIntent = str_starts_with($upper, 'LNS');
        $isSupportIntent = str_starts_with($upper, 'SUP');
        $isEmailIntent = str_contains($term, '@');
        $isSkuIntent = (bool) preg_match('/^(?:NH|DC|VT|SP|KT|BUNDLE|SET)[\d\-_A-Z]*/i', $clean);

        $results = [];

        // 1. ORDERS SEARCH (Run if Order intent, Email intent, or broad search)
        if ($isOrderIntent || (! $isSupportIntent && ! $isSkuIntent)) {
            $orders = Order::query()
                ->select(['id', 'order_code', 'customer_name', 'customer_email', 'grand_total', 'order_status', 'created_at'])
                ->where(function ($q) use ($clean, $term) {
                    $q->where('order_code', 'like', "%{$clean}%")
                        ->orWhere('customer_name', 'like', "%{$term}%")
                        ->orWhere('customer_email', 'like', "%{$term}%")
                        ->orWhere('customer_phone', 'like', "%{$clean}%");
                })
                ->latest()
                ->take(5)
                ->get();

            if ($orders->isNotEmpty()) {
                $items = $orders->map(function (Order $order) {
                    return [
                        'title' => '#'.$order->order_code.' — '.$order->customer_name,
                        'subtitle' => number_format((float) $order->grand_total, 0, ',', '.').'₫ • '.($order->created_at ? $order->created_at->format('d/m/Y H:i') : ''),
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

            // If query is specifically an order code prefix, return early to save queries
            if ($isOrderIntent && count($results) > 0) {
                return $results;
            }
        }

        // 2. PRODUCTS SEARCH (Run if SKU intent or broad search)
        if ($isSkuIntent || (! $isOrderIntent && ! $isSupportIntent && ! $isEmailIntent)) {
            $products = Product::withTrashed()
                ->select(['id', 'name', 'sku', 'regular_price', 'sale_price', 'stock_quantity', 'is_active', 'deleted_at', 'product_type'])
                ->where(function ($q) use ($clean, $term) {
                    $q->where('sku', 'like', "%{$clean}%")
                        ->orWhere('name', 'like', "%{$term}%");
                })
                ->take(5)
                ->get();

            if ($products->isNotEmpty()) {
                $items = $products->map(function (Product $prod) {
                    $avail = $prod->product_type === 'single' ? max(0, (int) $prod->stock_quantity) : 'Combo';

                    return [
                        'title' => $prod->name,
                        'subtitle' => 'SKU: '.$prod->sku.' • Giá: '.number_format((float) $prod->effective_price, 0, ',', '.').'₫',
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

            // If specifically SKU intent and results found, return early
            if ($isSkuIntent && count($results) > 0) {
                return $results;
            }
        }

        // 3. CUSTOMERS SEARCH (Run if Email intent or broad search)
        if ($isEmailIntent || (! $isOrderIntent && ! $isSupportIntent && ! $isSkuIntent)) {
            $customers = User::query()
                ->select(['id', 'name', 'email', 'created_at'])
                ->where('role', User::ROLE_USER)
                ->where(function ($q) use ($term) {
                    $q->where('email', 'like', "%{$term}%")
                        ->orWhere('name', 'like', "%{$term}%");
                })
                ->take(5)
                ->get();

            if ($customers->isNotEmpty()) {
                $items = $customers->map(function (User $cust) {
                    return [
                        'title' => $cust->name,
                        'subtitle' => $cust->email.' • Tham gia: '.($cust->created_at ? $cust->created_at->format('d/m/Y') : '—'),
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

            if ($isEmailIntent && count($results) > 0) {
                return $results;
            }
        }

        // 4. SUPPORT SEARCH (Run if Support intent or broad search)
        if ($isSupportIntent || (! $isOrderIntent && ! $isSkuIntent && ! $isEmailIntent)) {
            $tickets = ContactMessage::query()
                ->select(['id', 'reference', 'subject', 'name', 'email', 'status'])
                ->where(function ($q) use ($clean, $term) {
                    $q->where('reference', 'like', "%{$clean}%")
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
                        'title' => '#'.$ticket->reference.' — '.$ticket->subject,
                        'subtitle' => $ticket->name.' ('.$ticket->email.')',
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

            if ($isSupportIntent && count($results) > 0) {
                return $results;
            }
        }

        // 5. COUPONS SEARCH (Only in broad search or coupon-like tokens)
        if (! $isOrderIntent && ! $isSupportIntent && ! $isEmailIntent) {
            $coupons = Coupon::query()
                ->select(['id', 'code', 'type', 'value', 'used_count', 'is_active'])
                ->where('code', 'like', "%{$clean}%")
                ->take(5)
                ->get();

            if ($coupons->isNotEmpty()) {
                $items = $coupons->map(function (Coupon $cp) {
                    return [
                        'title' => 'Mã: '.$cp->code,
                        'subtitle' => ($cp->type === 'percentage' ? $cp->value.'%' : number_format((float) $cp->value, 0, ',', '.').'₫').' • Đã dùng: '.$cp->used_count.' lần',
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
        }

        return $results;
    }
}
