<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService
    ) {}

    /**
     * Admin Review Management: List with filters & pagination (20.27 - 20.28).
     */
    public function index(Request $request): View
    {
        $query = Review::query()
            ->with(['user', 'product.images', 'orderItem.order', 'media', 'repliedBy']);

        // Filter: Status
        $status = $request->query('status');
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $status);
        }

        // Filter: Rating
        $rating = $request->query('rating');
        if ($rating && in_array((int) $rating, [1, 2, 3, 4, 5], true)) {
            $query->where('rating', (int) $rating);
        }

        // Filter: Verified Purchase
        $verified = $request->query('verified');
        if ($verified === '1' || $verified === 'true') {
            $query->where('verified_purchase', true);
        } elseif ($verified === '0' || $verified === 'false') {
            $query->where('verified_purchase', false);
        }

        // Filter: Product
        $productId = $request->query('product_id');
        if ($productId && (int) $productId > 0) {
            $query->where('product_id', (int) $productId);
        }

        // Filter: Search keyword
        $q = trim((string) $request->query('q', ''));
        if ($q !== '') {
            $query->where(function ($sub) use ($q): void {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%")
                    ->orWhere('comment', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q): void {
                        $u->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    })
                    ->orWhereHas('product', function ($p) use ($q): void {
                        $p->where('name', 'like', "%{$q}%")
                            ->orWhere('sku', 'like', "%{$q}%");
                    });
            });
        }

        // Stats summary
        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('status', 'pending')->count(),
            'approved' => Review::where('status', 'approved')->count(),
            'rejected' => Review::where('status', 'rejected')->count(),
            'avg_rating' => round((float) (Review::where('status', 'approved')->avg('rating') ?: 0), 1),
        ];

        $reviews = $query->orderByDesc('created_at')->orderByDesc('id')->paginate(15)->withQueryString();
        $products = Product::query()->orderBy('name')->get(['id', 'name', 'sku']);

        return view('admin.reviews.index', compact('reviews', 'stats', 'products', 'status', 'rating', 'verified', 'productId', 'q'));
    }

    /**
     * View review details (20.29).
     */
    public function show(Request $request, Review $review): View|JsonResponse
    {
        $review->load(['user', 'product.images', 'orderItem.order', 'media', 'repliedBy']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'review' => $review,
            ]);
        }

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve review (20.30).
     */
    public function approve(Review $review): RedirectResponse
    {
        $this->reviewService->moderateReview($review, 'approved');

        Log::info('Review approved', [
            'review_id' => $review->id,
            'product_id' => $review->product_id,
            'admin_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', "Đã duyệt đánh giá #{$review->id} thành công.");
    }

    /**
     * Reject review with reason (20.31).
     */
    public function reject(Request $request, Review $review): RedirectResponse
    {
        $reason = $request->input('rejection_reason');
        $this->reviewService->moderateReview($review, 'rejected', $reason);

        Log::info('Review rejected', [
            'review_id' => $review->id,
            'product_id' => $review->product_id,
            'admin_id' => auth()->id(),
            'reason' => $reason,
        ]);

        return redirect()->back()->with('success', "Đã từ chối đánh giá #{$review->id}.");
    }

    /**
     * Reply to review (Merchant Reply) (20.32 - 20.33).
     */
    public function reply(Request $request, Review $review): RedirectResponse
    {
        $request->validate([
            'admin_reply' => ['required', 'string', 'min:2', 'max:2000'],
        ], [
            'admin_reply.required' => 'Vui lòng nhập nội dung phản hồi.',
            'admin_reply.max' => 'Nội dung phản hồi không được quá 2000 ký tự.',
        ]);

        $this->reviewService->replyToReview($review, (string) $request->input('admin_reply'), $request->user());

        Log::info('Merchant reply added to review', [
            'review_id' => $review->id,
            'admin_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Đã lưu phản hồi của Lunara Silver cho đánh giá.');
    }

    /**
     * Delete review and its Cloudinary media assets safely (20.24).
     */
    public function destroy(Review $review): RedirectResponse
    {
        $reviewId = $review->id;
        $this->reviewService->deleteReview($review);

        Log::info('Review deleted', [
            'review_id' => $reviewId,
            'admin_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', "Đã xóa đánh giá #{$reviewId} và các hình ảnh liên quan.");
    }
}
