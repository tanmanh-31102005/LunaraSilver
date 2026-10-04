<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewMedia;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class ReviewService
{
    public function __construct(
        protected ?CloudinaryService $cloudinary = null
    ) {
        $this->cloudinary = $cloudinary ?? app(CloudinaryService::class);
    }

    /**
     * Check if a user is eligible to review a given product.
     * Returns the earliest unreviewed completed OrderItem, or null.
     */
    public function getEligibleOrderItem(?User $user, Product|int $product, ?int $orderItemId = null): ?OrderItem
    {
        if (! $user) {
            return null;
        }

        $productId = $product instanceof Product ? $product->id : (int) $product;

        $query = OrderItem::query()
            ->whereHas('order', function (Builder $q) use ($user): void {
                $q->where('user_id', $user->id)
                    ->where('order_status', Order::STATUS_COMPLETED);
            })
            ->where('product_id', $productId)
            ->whereDoesntHave('review');

        if ($orderItemId !== null && $orderItemId > 0) {
            $query->whereKey($orderItemId);
        }

        return $query->first();
    }

    /**
     * Determine whether the user can review this product.
     */
    public function canUserReviewProduct(?User $user, Product $product): bool
    {
        return $this->getEligibleOrderItem($user, $product) !== null;
    }

    /**
     * Check if the user has already submitted a review for this product.
     */
    public function hasUserReviewedProduct(?User $user, Product $product): bool
    {
        if (! $user) {
            return false;
        }

        return Review::query()
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists();
    }

    /**
     * Get unreviewed order items for this user (Account Review Center: Chờ đánh giá).
     *
     * @return Collection<int, OrderItem>
     */
    public function getPendingReviewItems(User $user): Collection
    {
        return OrderItem::query()
            ->whereHas('order', function (Builder $q) use ($user): void {
                $q->where('user_id', $user->id)
                    ->where('order_status', Order::STATUS_COMPLETED);
            })
            ->whereDoesntHave('review')
            ->with(['product.images', 'order'])
            ->orderByDesc('id')
            ->get();
    }

    /**
     * Get reviews submitted by this user (Account Review Center: Đã đánh giá).
     */
    public function getUserReviews(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return Review::query()
            ->where('user_id', $user->id)
            ->with(['product.images', 'orderItem.order', 'media'])
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    /**
     * Create a verified review.
     *
     * @param  array{product_id: int, order_item_id?: int, rating: int, title?: ?string, content: string}  $data
     * @param  array<int, UploadedFile>  $images  (Up to 3 images)
     *
     * @throws ValidationException
     */
    public function createReview(User $user, array $data, array $images = []): Review
    {
        $productId = (int) $data['product_id'];
        $product = Product::query()->active()->findOrFail($productId);

        $specificOrderItemId = isset($data['order_item_id']) && (int) $data['order_item_id'] > 0
            ? (int) $data['order_item_id']
            : null;

        $orderItem = $this->getEligibleOrderItem($user, $product, $specificOrderItemId);

        if (! $orderItem) {
            throw ValidationException::withMessages([
                'product_id' => 'Bạn chỉ có thể đánh giá sản phẩm sau khi đơn hàng chứa sản phẩm này đã được hoàn thành.',
            ]);
        }

        $rating = (int) $data['rating'];
        if ($rating < 1 || $rating > 5) {
            throw ValidationException::withMessages([
                'rating' => 'Điểm đánh giá phải từ 1 đến 5 sao.',
            ]);
        }

        $title = ! empty($data['title']) ? mb_substr(strip_tags(trim($data['title'])), 0, 120) : null;
        $content = strip_tags(trim((string) ($data['content'] ?? '')));

        if ($content === '') {
            throw ValidationException::withMessages([
                'content' => 'Vui lòng nhập nội dung đánh giá.',
            ]);
        }

        if (mb_strlen($content) > 2000) {
            throw ValidationException::withMessages([
                'content' => 'Nội dung đánh giá không được vượt quá 2000 ký tự.',
            ]);
        }

        if (count($images) > 3) {
            throw ValidationException::withMessages([
                'images' => 'Chỉ được tải lên tối đa 3 hình ảnh cho mỗi đánh giá.',
            ]);
        }

        return DB::transaction(function () use ($user, $product, $orderItem, $rating, $title, $content, $images): Review {
            $review = Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'order_item_id' => $orderItem->id,
                'rating' => $rating,
                'title' => $title,
                'content' => $content,
                'comment' => $content,
                'status' => 'pending',
                'verified_purchase' => true,
            ]);

            $this->saveReviewImages($review, $images);

            return $review->fresh(['media', 'user', 'orderItem']);
        });
    }

    /**
     * Save up to 3 review images via Cloudinary.
     *
     * @param  array<int, UploadedFile>  $images
     */
    protected function saveReviewImages(Review $review, array $images): void
    {
        $order = 0;
        foreach ($images as $file) {
            if (! ($file instanceof UploadedFile) || ! $file->isValid()) {
                continue;
            }

            $extension = strtolower((string) ($file->getClientOriginalExtension() ?: $file->extension()));
            if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                throw ValidationException::withMessages([
                    'images' => 'Hình ảnh phải có định dạng JPG, JPEG, PNG hoặc WEBP.',
                ]);
            }

            if ($file->getSize() > 5 * 1024 * 1024) {
                throw ValidationException::withMessages([
                    'images' => 'Kích thước mỗi ảnh không được vượt quá 5MB.',
                ]);
            }

            $publicId = null;
            $imageUrl = null;

            if ($this->cloudinary && $this->cloudinary->isConfigured()) {
                try {
                    $folder = 'lunara/reviews';
                    $uploadResult = $this->cloudinary->uploadFile($file, $folder);
                    $publicId = $uploadResult['public_id'];
                    $imageUrl = $uploadResult['secure_url'];
                } catch (Throwable $e) {
                    Log::warning('Cloudinary review image upload failed, falling back to local storage', [
                        'review_id' => $review->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            if (! $imageUrl) {
                $path = $file->store('reviews', 'public');
                $imageUrl = asset('storage/'.$path);
            }

            ReviewMedia::create([
                'review_id' => $review->id,
                'public_id' => $publicId,
                'image_url' => $imageUrl,
                'sort_order' => $order++,
            ]);

            if ($order >= 3) {
                break;
            }
        }
    }

    /**
     * Query approved reviews for a product with optional star filter and sorting.
     */
    public function getApprovedReviewsForProduct(Product $product, ?int $ratingFilter = null, string $sort = 'newest', int $perPage = 10): LengthAwarePaginator
    {
        $query = Review::query()
            ->where('product_id', $product->id)
            ->where('status', 'approved')
            ->with(['user', 'media']);

        if ($ratingFilter !== null && $ratingFilter >= 1 && $ratingFilter <= 5) {
            $query->where('rating', $ratingFilter);
        }

        match ($sort) {
            'highest' => $query->orderByDesc('rating')->orderByDesc('created_at'),
            'lowest' => $query->orderBy('rating')->orderByDesc('created_at'),
            default => $query->orderByDesc('created_at')->orderByDesc('id'),
        };

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Get approved customer gallery media for a product (Requirement 20.25).
     *
     * @return Collection<int, ReviewMedia>
     */
    public function getCustomerMediaGallery(Product $product, int $limit = 8): Collection
    {
        return ReviewMedia::query()
            ->whereHas('review', function (Builder $q) use ($product): void {
                $q->where('product_id', $product->id)
                    ->where('status', 'approved');
            })
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    /**
     * Moderate a review (approve or reject).
     */
    public function moderateReview(Review $review, string $status, ?string $reason = null): Review
    {
        if (! in_array($status, ['approved', 'rejected'], true)) {
            throw new \InvalidArgumentException('Trạng thái kiểm duyệt không hợp lệ.');
        }

        $review->status = $status;
        $review->rejection_reason = $status === 'rejected' ? $reason : null;
        $review->save();

        return $review;
    }

    /**
     * Add or update merchant reply.
     */
    public function replyToReview(Review $review, string $reply, User $admin): Review
    {
        $cleanReply = strip_tags(trim($reply));
        if ($cleanReply === '') {
            throw ValidationException::withMessages([
                'admin_reply' => 'Vui lòng nhập nội dung phản hồi.',
            ]);
        }

        $review->admin_reply = mb_substr($cleanReply, 0, 2000);
        $review->admin_replied_at = now();
        $review->admin_replied_by = $admin->id;
        $review->save();

        return $review;
    }

    /**
     * Delete review and safely remove attached Cloudinary media assets (Requirement 20.24).
     */
    public function deleteReview(Review $review): void
    {
        $mediaList = $review->media;
        foreach ($mediaList as $media) {
            $this->deleteMediaAsset($media);
        }

        $review->delete();
    }

    /**
     * Safely delete Cloudinary media asset.
     */
    public function deleteMediaAsset(ReviewMedia $media): void
    {
        if (! empty($media->public_id) && $this->cloudinary && $this->cloudinary->isConfigured()) {
            try {
                $this->cloudinary->deleteFile($media->public_id);
            } catch (Throwable $e) {
                Log::warning('Failed to delete review media from Cloudinary', [
                    'media_id' => $media->id,
                    'public_id' => $media->public_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $media->delete();
    }
}
