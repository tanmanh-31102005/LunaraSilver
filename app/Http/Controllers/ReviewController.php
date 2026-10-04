<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService
    ) {}

    /**
     * Submit a customer review for a product.
     */
    public function store(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        if (! $user) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để gửi đánh giá sản phẩm.',
                ], 401);
            }

            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để đánh giá sản phẩm.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:120'],
            'content' => ['required', 'string', 'min:5', 'max:2000'],
            'order_item_id' => ['nullable', 'integer'],
            'images' => ['nullable', 'array', 'max:3'],
            'images.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá (1-5 sao).',
            'rating.min' => 'Điểm đánh giá tối thiểu là 1 sao.',
            'rating.max' => 'Điểm đánh giá tối đa là 5 sao.',
            'content.required' => 'Vui lòng nhập nội dung đánh giá của bạn.',
            'content.min' => 'Nội dung đánh giá cần ít nhất 5 ký tự.',
            'content.max' => 'Nội dung đánh giá không được vượt quá 2000 ký tự.',
            'title.max' => 'Tiêu đề đánh giá không được vượt quá 120 ký tự.',
            'images.max' => 'Bạn chỉ có thể tải lên tối đa 3 hình ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng JPG, JPEG, PNG hoặc WEBP.',
            'images.*.max' => 'Dung lượng mỗi ảnh không được vượt quá 5MB.',
        ]);

        $uploadedImages = $request->file('images', []);
        if (! is_array($uploadedImages)) {
            $uploadedImages = [$uploadedImages];
        }

        try {
            $review = $this->reviewService->createReview($user, [
                'product_id' => $product->id,
                'order_item_id' => $validated['order_item_id'] ?? null,
                'rating' => (int) $validated['rating'],
                'title' => $validated['title'] ?? null,
                'content' => $validated['content'],
            ], $uploadedImages);

            $message = 'Cảm ơn bạn đã đánh giá! Nhận xét của bạn đang được kiểm duyệt và sẽ hiển thị sớm.';

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'review_id' => $review->id,
                ]);
            }

            if ($request->input('return_to') === 'account' || str_contains($request->headers->get('referer', ''), 'account/reviews')) {
                return redirect()->route('account.reviews.index', ['tab' => 'reviewed'])->with('success', $message);
            }

            return redirect()->to(route('products.show', $product->slug).'#reviews')->with('success', $message);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể gửi đánh giá: '.$e->getMessage(),
                ], 422);
            }

            return redirect()->back()->withInput()->with('error', 'Không thể gửi đánh giá: '.$e->getMessage());
        }
    }
}
