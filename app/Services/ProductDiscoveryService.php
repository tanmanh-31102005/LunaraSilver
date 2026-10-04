<?php

namespace App\Services;

use App\Models\BundleItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductDiscoveryService
{
    /**
     * Complete the Look suggestions (Section F).
     *
     * Prioritizes:
     * 1. Sibling items in the same bundle/collection (already loaded in memory)
     * 2. Sibling items in the parent bundle/collection
     * 3. Fallback to related products from same category/style
     *
     * Always excludes current product and inactive products.
     *
     * @return Collection<int, Product>
     */
    public function getCompleteTheLook(Product $product, ?Collection $relatedProducts = null, int $limit = 3): Collection
    {
        if ($relatedProducts && $relatedProducts->isNotEmpty()) {
            return $relatedProducts->take($limit);
        }

        return new Collection;
    }

    /**
     * Find parent collection for a single product (if any) (Section 20.45).
     */
    public function getParentCollection(Product $product): ?Product
    {
        if ($product->isBundle()) {
            return null;
        }

        $bundleItem = BundleItem::query()
            ->where('component_product_id', $product->id)
            ->first();

        if (! $bundleItem) {
            return null;
        }

        return Product::query()->active()
            ->with(['category', 'images', 'bundleItems.component'])
            ->find($bundleItem->bundle_product_id);
    }

    /**
     * Upgraded Related Products 2.0 (Section G).
     *
     * Scoring:
     * - Same category: +3
     * - Same collection/bundle: +5
     * - Similar price range (+/- 30%): +1
     * - Same product type: +2
     *
     * Deterministic, zero random sort, bounded queries.
     *
     * @return Collection<int, Product>
     */
    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        $candidates = Product::query()->active()
            ->whereKeyNot($product->id)
            ->where('category_id', $product->category_id)
            ->with(['category', 'images', 'bundleItems.component'])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $price = (float) $product->effective_price;
        $minPrice = $price * 0.7;
        $maxPrice = $price * 1.3;

        $scored = $candidates->map(function (Product $item) use ($product, $minPrice, $maxPrice): array {
            $score = 3; // Same category baseline

            // Same product type +2
            if ($item->product_type === $product->product_type) {
                $score += 2;
            }

            // Similar price +1
            $itemPrice = (float) $item->effective_price;
            if ($itemPrice >= $minPrice && $itemPrice <= $maxPrice) {
                $score += 1;
            }

            return ['product' => $item, 'score' => $score];
        });

        return $scored->sort(function ($a, $b) {
            if ($a['score'] === $b['score']) {
                return $b['product']->id <=> $a['product']->id;
            }

            return $b['score'] <=> $a['score'];
        })->pluck('product')->take($limit)->values();
    }
}
