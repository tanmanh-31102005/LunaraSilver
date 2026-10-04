<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class RecentlyViewedService
{
    public const MAX_ITEMS = 12;

    public const SESSION_KEY = 'recently_viewed';

    /**
     * Record a product view in session.
     *
     * @param  array<int>  $sessionItems
     */
    public function record(int $productId, array &$sessionItems): void
    {
        $sessionItems = array_values(array_filter(array_map('intval', $sessionItems)));

        // Remove if previously viewed to move to front
        $key = array_search($productId, $sessionItems, true);
        if ($key !== false) {
            unset($sessionItems[$key]);
        }

        // Prepend current product
        array_unshift($sessionItems, $productId);

        // Cap at MAX_ITEMS
        $sessionItems = array_slice($sessionItems, 0, self::MAX_ITEMS);
    }

    /**
     * Fetch products that were recently viewed, excluding an optional product ID.
     *
     * @param  array<int>  $sessionItems
     * @return Collection<int, Product>
     */
    public function getProducts(array $sessionItems, ?int $excludeId = null, int $limit = 6): Collection
    {
        $ids = array_values(array_filter(array_map('intval', $sessionItems)));

        if ($excludeId !== null) {
            $ids = array_values(array_diff($ids, [$excludeId]));
        }

        if (empty($ids)) {
            return new Collection;
        }

        $idsToFetch = array_slice($ids, 0, $limit);

        $products = Product::query()
            ->active()
            ->with(['category', 'images', 'bundleItems.component.images'])
            ->whereIn('id', $idsToFetch)
            ->get();

        // Preserve recency order
        $order = array_flip($idsToFetch);

        return $products->sortBy(fn ($p) => $order[$p->id] ?? 999)->values();
    }
}
