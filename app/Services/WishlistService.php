<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class WishlistService
{
    /**
     * Get an array of product IDs currently in the user's or guest's wishlist.
     *
     * @param  array<int>  $sessionIds
     * @return array<int>
     */
    public function getWishlistIds(?User $user, array $sessionIds = []): array
    {
        if ($user) {
            return Wishlist::query()
                ->where('user_id', $user->id)
                ->pluck('product_id')
                ->map(fn ($id) => (int) $id)
                ->all();
        }

        return array_values(array_unique(array_filter(array_map('intval', $sessionIds))));
    }

    /**
     * Check if a specific product is in the wishlist.
     */
    public function isWishlisted(int $productId, ?User $user, array $sessionIds = []): bool
    {
        $ids = $this->getWishlistIds($user, $sessionIds);

        return in_array($productId, $ids, true);
    }

    /**
     * Toggle product in wishlist (add if missing, remove if present).
     *
     * @param  array<int>  $sessionIds
     * @return array{added: bool, count: int, message: string}
     */
    public function toggle(int $productId, ?User $user, array &$sessionIds): array
    {
        $product = Product::query()->find($productId);
        if (! $product) {
            return [
                'added' => false,
                'count' => $this->count($user, $sessionIds),
                'message' => 'Sản phẩm không tồn tại.',
            ];
        }

        if ($user) {
            $existing = Wishlist::query()
                ->where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($existing) {
                $existing->delete();
                $added = false;
                $message = 'Đã xóa khỏi danh sách yêu thích.';
            } else {
                Wishlist::query()->create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                ]);
                $added = true;
                $message = 'Đã thêm vào danh sách yêu thích.';
            }

            return [
                'added' => $added,
                'count' => $this->count($user, $sessionIds),
                'message' => $message,
            ];
        }

        // Guest session wishlist
        $sessionIds = array_values(array_unique(array_filter(array_map('intval', $sessionIds))));
        $key = array_search($productId, $sessionIds, true);

        if ($key !== false) {
            unset($sessionIds[$key]);
            $sessionIds = array_values($sessionIds);
            $added = false;
            $message = 'Đã xóa khỏi danh sách yêu thích.';
        } else {
            $sessionIds[] = $productId;
            $added = true;
            $message = 'Đã thêm vào danh sách yêu thích.';
        }

        return [
            'added' => $added,
            'count' => count($sessionIds),
            'message' => $message,
        ];
    }

    /**
     * Remove a product from wishlist explicitly.
     *
     * @param  array<int>  $sessionIds
     * @return array{success: bool, count: int, message: string}
     */
    public function remove(int $productId, ?User $user, array &$sessionIds): array
    {
        if ($user) {
            Wishlist::query()
                ->where('user_id', $user->id)
                ->where('product_id', $productId)
                ->delete();
        } else {
            $sessionIds = array_values(array_diff(
                array_map('intval', $sessionIds),
                [$productId]
            ));
        }

        return [
            'success' => true,
            'count' => $this->count($user, $sessionIds),
            'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích.',
        ];
    }

    /**
     * Merge guest session wishlist into authenticated user's wishlist upon login/register.
     *
     * @param  array<int>  $guestIds
     * @return int Number of newly inserted items
     */
    public function mergeGuestWishlist(User $user, array $guestIds): int
    {
        if (empty($guestIds)) {
            return 0;
        }

        $validProductIds = Product::query()
            ->whereIn('id', $guestIds)
            ->pluck('id')
            ->all();

        $merged = 0;
        DB::transaction(function () use ($user, $validProductIds, &$merged) {
            foreach ($validProductIds as $productId) {
                $created = Wishlist::query()->firstOrCreate([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                ]);

                if ($created->wasRecentlyCreated) {
                    $merged++;
                }
            }
        });

        return $merged;
    }

    /**
     * Total count of wishlist items.
     *
     * @param  array<int>  $sessionIds
     */
    public function count(?User $user, array $sessionIds = []): int
    {
        if ($user) {
            return Wishlist::query()->where('user_id', $user->id)->count();
        }

        return count(array_unique(array_filter(array_map('intval', $sessionIds))));
    }

    /**
     * Get Collection of Products in the wishlist (with eager loaded relations).
     *
     * @param  array<int>  $sessionIds
     * @return Collection<int, Product>
     */
    public function getWishlistProducts(?User $user, array $sessionIds = []): Collection
    {
        $ids = $this->getWishlistIds($user, $sessionIds);
        if (empty($ids)) {
            return new Collection;
        }

        $products = Product::query()
            ->with(['category', 'images', 'bundleItems.component.images'])
            ->whereIn('id', $ids)
            ->get();

        // Maintain order of addition (reversed IDs)
        $idOrder = array_flip($ids);

        return $products->sortBy(fn ($p) => $idOrder[$p->id] ?? 9999)->values();
    }
}
