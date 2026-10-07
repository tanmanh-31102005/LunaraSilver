<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\PaymentRefund;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerInsightsService
{
    public const SEGMENT_NEW = 'NEW';
    public const SEGMENT_REPEAT = 'REPEAT';
    public const SEGMENT_HIGH_VALUE = 'HIGH_VALUE';
    public const SEGMENT_STANDARD = 'STANDARD';

    public const HIGH_VALUE_THRESHOLD = 5000000.0; // 5M VND

    /**
     * Get paginated customer list with eager statistics and zero N+1 queries.
     */
    public function getCustomersList(Request $request, int $perPage = 15): LengthAwarePaginator
    {
        $query = User::query()
            ->where('role', User::ROLE_USER)
            ->withCount('orders')
            ->withCount([
                'orders as completed_orders_count' => function (Builder $q) {
                    $q->where('order_status', Order::STATUS_COMPLETED);
                },
            ])
            ->withSum([
                'orders as gross_spent' => function (Builder $q) {
                    $q->where('order_status', Order::STATUS_COMPLETED);
                },
            ], 'grand_total')
            ->selectSub(function ($sub) {
                $sub->from('payment_refunds')
                    ->join('orders', 'payment_refunds.order_id', '=', 'orders.id')
                    ->whereColumn('orders.user_id', 'users.id')
                    ->where('payment_refunds.status', PaymentRefund::STATUS_SUCCEEDED)
                    ->selectRaw('COALESCE(SUM(payment_refunds.amount), 0)');
            }, 'refunded_amount')
            ->withMax('orders as last_order_at', 'created_at');

        // Search by name, email, or phone
        if ($search = trim((string) $request->input('search'))) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('orders', function (Builder $oq) use ($search) {
                      $oq->where('customer_phone', 'like', "%{$search}%");
                  })
                  ->orWhereHas('addresses', function (Builder $aq) use ($search) {
                      $aq->where('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Segment / Behavior filters
        $filter = $request->input('filter', 'all');
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        switch ($filter) {
            case 'new':
                $query->where('created_at', '>=', $thirtyDaysAgo);
                break;

            case 'has_orders':
                $query->has('orders');
                break;

            case 'repeat':
                $query->has('orders', '>=', 2, 'and', function (Builder $q) {
                    $q->where('order_status', Order::STATUS_COMPLETED);
                });
                break;

            case 'no_orders':
                $query->doesntHave('orders');
                break;

            case 'high_value':
                $query->havingRaw('(COALESCE(gross_spent, 0) - COALESCE(refunded_amount, 0)) >= ?', [self::HIGH_VALUE_THRESHOLD]);
                break;

            case 'all':
            default:
                break;
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'orders' => $query->orderByDesc('completed_orders_count'),
            'spent' => $query->orderByRaw('(COALESCE(gross_spent, 0) - COALESCE(refunded_amount, 0)) DESC'),
            default => $query->orderByDesc('created_at'),
        };

        $paginator = $query->paginate($perPage)->withQueryString();

        // Calculate calculated fields for each user
        $paginator->getCollection()->transform(function (User $user) {
            $gross = (float) ($user->gross_spent ?? 0.0);
            $refunded = (float) ($user->refunded_amount ?? 0.0);
            $user->lifetime_spend = max(0.0, round($gross - $refunded, 2));
            $user->segment = $this->determineSegment($user);
            return $user;
        });

        return $paginator;
    }

    /**
     * Determine segment without AI based on deterministic business rules.
     */
    public function determineSegment(User $user): string
    {
        $lifetimeSpend = $user->lifetime_spend ?? max(0.0, (float) ($user->gross_spent ?? 0.0) - (float) ($user->refunded_amount ?? 0.0));
        $completedCount = (int) ($user->completed_orders_count ?? 0);

        if ($lifetimeSpend >= self::HIGH_VALUE_THRESHOLD) {
            return self::SEGMENT_HIGH_VALUE;
        }

        if ($completedCount >= 2) {
            return self::SEGMENT_REPEAT;
        }

        if ($user->created_at && $user->created_at->gte(Carbon::now()->subDays(30))) {
            return self::SEGMENT_NEW;
        }

        return self::SEGMENT_STANDARD;
    }

    /**
     * Build Customer 360 data packet for a single user.
     * Absolutely never exposes password, tokens, or security hashes.
     */
    public function getCustomer360(User $user): array
    {
        // 1. Orders
        $orders = $user->orders()
            ->with(['items.product', 'latestPayment'])
            ->withCount('items')
            ->latest()
            ->get();

        $completedOrders = $orders->where('order_status', Order::STATUS_COMPLETED);
        $grossSpent = (float) $completedOrders->sum('grand_total');

        $successfulRefunds = (float) PaymentRefund::query()
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('status', PaymentRefund::STATUS_SUCCEEDED)
            ->sum('amount');

        $lifetimeSpend = max(0.0, round($grossSpent - $successfulRefunds, 2));
        $completedCount = $completedOrders->count();

        $aov = $completedCount > 0 ? round($grossSpent / $completedCount, 2) : 0.0;
        $lastOrder = $orders->first();

        // Attach lifetime spend & segment
        $user->lifetime_spend = $lifetimeSpend;
        $user->completed_orders_count = $completedCount;
        $user->segment = $this->determineSegment($user);

        // 2. Reviews
        $reviews = $user->reviews()
            ->with('product')
            ->latest()
            ->get();

        // 3. Support Tickets (Contact Messages) & Live Chats
        $contactMessages = $user->contactMessages()
            ->with('order')
            ->latest()
            ->get();

        $chatConversations = $user->supportConversations()
            ->latest('last_message_at')
            ->get();

        // 4. Coupon History
        $couponUsages = $user->couponUsages()
            ->with(['coupon', 'order'])
            ->latest('used_at')
            ->get();

        // 5. Addresses
        $addresses = $user->addresses()
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return [
            'user' => $user,
            'summary' => [
                'lifetime_spend' => $lifetimeSpend,
                'total_orders' => $orders->count(),
                'completed_orders' => $completedCount,
                'aov' => $aov,
                'last_order' => $lastOrder,
                'segment' => $user->segment,
                'joined_at' => $user->created_at,
            ],
            'orders' => $orders,
            'reviews' => $reviews,
            'contact_messages' => $contactMessages,
            'chat_conversations' => $chatConversations,
            'coupon_usages' => $couponUsages,
            'addresses' => $addresses,
        ];
    }
}
