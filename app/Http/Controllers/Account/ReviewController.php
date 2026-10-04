<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService
    ) {}

    /**
     * Account Review Center: Chờ đánh giá & Đã đánh giá (Requirement 20.11).
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $tab = $request->query('tab', 'pending');

        $pendingItems = $this->reviewService->getPendingReviewItems($user);
        $userReviews = $this->reviewService->getUserReviews($user, 10);

        return view('account.reviews.index', compact('user', 'tab', 'pendingItems', 'userReviews'));
    }

    /**
     * Dedicated review submission form for a purchased order item.
     */
    public function create(Request $request, OrderItem $item): View|RedirectResponse
    {
        $user = $request->user();

        abort_unless(
            $item->order->user_id === $user->id
            && $item->order->order_status === Order::STATUS_COMPLETED,
            403,
            'Sản phẩm này không thuộc đơn hàng hoàn tất của bạn.'
        );

        if ($item->review) {
            return redirect()->route('account.reviews.index', ['tab' => 'reviewed'])
                ->with('info', 'Sản phẩm này đã được bạn gửi đánh giá trước đó.');
        }

        $item->load(['product.images', 'order']);

        return view('account.reviews.create', compact('item', 'user'));
    }
}
