<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\PaymentRefund;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CustomerInsightsService
{
    public const SEGMENT_NEW = 'NEW';

    public const SEGMENT_REPEAT = 'REPEAT';

    public const SEGMENT_HIGH_VALUE = 'HIGH_VALUE';

    public const SEGMENT_STANDARD = 'STANDARD';

    public const HIGH_VALUE_THRESHOLD = 5000000.0; // 5M VND

    /**
     * Get paginated customer list with aggregated subquery joins,
     * tight column selection, and zero correlated subqueries per row.
     */
    public function getCustomersList(Request $request, int $perPage = 15): LengthAwarePaginator
    {
        // 1. Aggregated order stats subquery grouped by user_id
        $orderStatsSub = Order::query()
            ->selectRaw('user_id')
            ->selectRaw('COUNT(*) as orders_count')
            ->selectRaw("SUM(CASE WHEN order_status = '".Order::STATUS_COMPLETED."' THEN 1 ELSE 0 END) as completed_orders_count")
            ->selectRaw("SUM(CASE WHEN order_status = '".Order::STATUS_COMPLETED."' THEN grand_total ELSE 0 END) as gross_spent")
            ->selectRaw('MAX(created_at) as last_order_at')
            ->whereNotNull('user_id')
            ->groupBy('user_id');

        // 2. Aggregated refund stats subquery grouped by user_id
        $refundStatsSub = PaymentRefund::query()
            ->join('orders', 'payment_refunds.order_id', '=', 'orders.id')
            ->where('payment_refunds.status', PaymentRefund::STATUS_SUCCEEDED)
            ->whereNotNull('orders.user_id')
            ->selectRaw('orders.user_id')
            ->selectRaw('SUM(payment_refunds.amount) as refunded_amount')
            ->groupBy('orders.user_id');

        // 3. Main user query with explicit lightweight column selection
        $query = User::query()
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.role',
                'users.created_at',
                DB::raw('COALESCE(order_stats.orders_count, 0) as orders_count'),
                DB::raw('COALESCE(order_stats.completed_orders_count, 0) as completed_orders_count'),
                DB::raw('COALESCE(order_stats.gross_spent, 0) as gross_spent'),
                DB::raw('COALESCE(refund_stats.refunded_amount, 0) as refunded_amount'),
                DB::raw('order_stats.last_order_at as last_order_at'),
            ])
            ->leftJoinSub($orderStatsSub, 'order_stats', 'users.id', '=', 'order_stats.user_id')
            ->leftJoinSub($refundStatsSub, 'refund_stats', 'users.id', '=', 'refund_stats.user_id')
            ->where('users.role', User::ROLE_USER);

        // Search by name, email, or phone
        if ($search = trim((string) $request->input('search'))) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhereExists(function ($sq) use ($search) {
                        $sq->select(DB::raw(1))
                            ->from('orders')
                            ->whereColumn('orders.user_id', 'users.id')
                            ->where('orders.customer_phone', 'like', "%{$search}%");
                    })
                    ->orWhereExists(function ($sq) use ($search) {
                        $sq->select(DB::raw(1))
                            ->from('addresses')
                            ->whereColumn('addresses.user_id', 'users.id')
                            ->where('addresses.phone', 'like', "%{$search}%");
                    });
            });
        }

        // Segment / Behavior filters
        $filter = $request->input('filter', 'all');
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        switch ($filter) {
            case 'new':
                $query->where('users.created_at', '>=', $thirtyDaysAgo);
                break;

            case 'has_orders':
                $query->where('order_stats.orders_count', '>', 0);
                break;

            case 'repeat':
                $query->where('order_stats.completed_orders_count', '>=', 2);
                break;

            case 'no_orders':
                $query->where(function ($q) {
                    $q->whereNull('order_stats.orders_count')
                        ->orWhere('order_stats.orders_count', 0);
                });
                break;

            case 'high_value':
                $query->whereRaw('(COALESCE(order_stats.gross_spent, 0) - COALESCE(refund_stats.refunded_amount, 0)) >= ?', [self::HIGH_VALUE_THRESHOLD]);
                break;

            case 'all':
            default:
                break;
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'oldest' => $query->orderBy('users.created_at', 'asc'),
            'orders' => $query->orderByDesc('completed_orders_count'),
            'spent' => $query->orderByRaw('(COALESCE(order_stats.gross_spent, 0) - COALESCE(refund_stats.refunded_amount, 0)) DESC'),
            default => $query->orderByDesc('users.created_at'),
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
     * Lightweight summary metrics for initial Customer 360 view.
     * Computes totals via fast SQL aggregates without preloading entire relationship trees.
     */
    public function getCustomerSummary(User $user): array
    {
        $completedOrdersQuery = $user->orders()->where('order_status', Order::STATUS_COMPLETED);
        $grossSpent = (float) $completedOrdersQuery->sum('grand_total');

        $successfulRefunds = (float) PaymentRefund::query()
            ->join('orders', 'payment_refunds.order_id', '=', 'orders.id')
            ->where('orders.user_id', $user->id)
            ->where('payment_refunds.status', PaymentRefund::STATUS_SUCCEEDED)
            ->sum('payment_refunds.amount');

        $lifetimeSpend = max(0.0, round($grossSpent - $successfulRefunds, 2));
        $completedCount = (int) $completedOrdersQuery->count();
        $totalOrders = (int) $user->orders()->count();

        $aov = $completedCount > 0 ? round($grossSpent / $completedCount, 2) : 0.0;
        $lastOrder = $user->orders()->latest()->select(['id', 'order_code', 'created_at', 'grand_total', 'order_status'])->first();

        $user->lifetime_spend = $lifetimeSpend;
        $user->completed_orders_count = $completedCount;
        $user->segment = $this->determineSegment($user);

        $counts = [
            'orders' => $totalOrders,
            'reviews' => (int) $user->reviews()->count(),
            'support' => (int) ($user->contactMessages()->count() + $user->supportConversations()->count()),
            'coupons' => (int) $user->couponUsages()->count(),
            'addresses' => (int) $user->addresses()->count(),
        ];

        return [
            'lifetime_spend' => $lifetimeSpend,
            'total_orders' => $totalOrders,
            'completed_orders' => $completedCount,
            'aov' => $aov,
            'last_order' => $lastOrder,
            'segment' => $user->segment,
            'joined_at' => $user->created_at,
            'counts' => $counts,
        ];
    }

    /**
     * Paginated customer orders tab data.
     */
    public function getCustomerOrders(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $user->orders()
            ->select(['id', 'order_code', 'user_id', 'grand_total', 'payment_method', 'payment_status', 'order_status', 'created_at'])
            ->with(['items.product:id,name,sku', 'latestPayment'])
            ->withCount('items')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Paginated customer reviews tab data.
     */
    public function getCustomerReviews(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $user->reviews()
            ->with('product:id,name,slug')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Customer support messages & conversations tab data.
     */
    public function getCustomerSupport(User $user): array
    {
        return [
            'contact_messages' => $user->contactMessages()->with('order:id,order_code')->latest()->paginate(10, ['*'], 'contact_page'),
            'chat_conversations' => $user->supportConversations()->latest('last_message_at')->paginate(10, ['*'], 'chat_page'),
        ];
    }

    /**
     * Paginated customer coupon usages tab data.
     */
    public function getCustomerCoupons(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $user->couponUsages()
            ->with(['coupon:id,code,type,value', 'order:id,order_code,grand_total'])
            ->latest('used_at')
            ->paginate($perPage);
    }

    /**
     * Customer addresses tab data.
     */
    public function getCustomerAddresses(User $user): Collection
    {
        return $user->addresses()
            ->orderByDesc('is_default')
            ->latest()
            ->get();
    }

    /**
     * Build Customer 360 data packet for a single user.
     * Absolutely never exposes password, tokens, or security hashes.
     */
    public function getCustomer360(User $user, bool $full = true): array
    {
        if (! $full) {
            $summary = $this->getCustomerSummary($user);

            return [
                'user' => $user,
                'summary' => $summary,
                'counts' => $summary['counts'],
            ];
        }

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
