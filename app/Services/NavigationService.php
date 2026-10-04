<?php

namespace App\Services;

use App\Models\Category;
use App\Models\PostCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class NavigationService
{
    public const CACHE_KEY = 'lunara.navigation_data';

    public const CACHE_TTL_SECONDS = 3600; // 60 minutes

    /**
     * In-memory static cache to avoid repeated queries within the same request/lifecycle.
     */
    public static ?array $staticCache = null;

    /**
     * Warm up and cache navigation payload.
     *
     * @return array{
     *     categories: array<int, array{id: int, name: string, slug: string, url: string, count: int}>,
     *     featuredProducts: array<int, array{id: int, name: string, slug: string, url: string, price_display: string, regular_price_display: ?string, is_on_sale: bool, image_url: ?string, category_name: string}>,
     *     collections: array<int, array{id: int, name: string, slug: string, url: string, price_display: string, image_url: ?string, summary: ?string}>,
     *     giftSets: array<int, array{id: int, name: string, slug: string, url: string, price_display: string, image_url: ?string, summary: ?string}>,
     *     blogCategories: array<int, array{id: int, name: string, slug: string, url: string, count: int}>
     * }
     */
    public function warmCache(): array
    {
        // 1. Categories (1 query with withCount - NO N+1)
        $categories = Category::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Category $cat) => [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'url' => route('products.category', $cat->slug),
                'count' => $cat->products_count ?? 0,
            ])
            ->all();

        // 2. Featured Single Products for Jewelry Mega Menu Preview (Limit 2)
        $featuredProducts = Product::query()
            ->active()
            ->where('product_type', 'single')
            ->with(['images', 'category'])
            ->orderByDesc('id')
            ->limit(2)
            ->get()
            ->map(function (Product $p) {
                $isOnSale = $p->sale_price !== null && $p->sale_price >= 0 && $p->sale_price < $p->regular_price;
                $primaryImg = $p->images->firstWhere('image_role', 'primary') ?: $p->images->first();

                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'url' => route('products.show', $p->slug),
                    'price_display' => $isOnSale
                        ? number_format($p->sale_price, 0, ',', '.').' ₫'
                        : number_format($p->regular_price, 0, ',', '.').' ₫',
                    'regular_price_display' => $isOnSale
                        ? number_format($p->regular_price, 0, ',', '.').' ₫'
                        : null,
                    'is_on_sale' => $isOnSale,
                    'image_url' => $primaryImg?->displayUrl(),
                    'category_name' => $p->category?->name ?? 'Trang sức',
                ];
            })
            ->all();

        // 3. Featured Collections from Database (Limit 3)
        $collections = Product::query()
            ->active()
            ->where(function ($q) {
                $q->where('product_type', 'collection')
                    ->orWhereHas('category', fn ($c) => $c->where('slug', 'bo-trang-suc'));
            })
            ->with(['images', 'category'])
            ->limit(3)
            ->get()
            ->map(function (Product $p) {
                $primaryImg = $p->images->firstWhere('image_role', 'primary') ?: $p->images->first();

                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'url' => route('products.show', $p->slug),
                    'price_display' => number_format($p->regular_price, 0, ',', '.').' ₫',
                    'image_url' => $primaryImg?->displayUrl(),
                    'summary' => $p->short_description ?: 'Bộ phối trang sức bạc 925 tinh tú.',
                ];
            })
            ->all();

        // 4. Featured Gift Sets from Database (Limit 3)
        $giftSets = Product::query()
            ->active()
            ->where(function ($q) {
                $q->where('product_type', 'gift')
                    ->orWhereHas('category', fn ($c) => $c->where('slug', 'set-qua-tang'));
            })
            ->with(['images', 'category'])
            ->limit(3)
            ->get()
            ->map(function (Product $p) {
                $primaryImg = $p->images->firstWhere('image_role', 'primary') ?: $p->images->first();

                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'url' => route('products.show', $p->slug),
                    'price_display' => number_format($p->regular_price, 0, ',', '.').' ₫',
                    'image_url' => $primaryImg?->displayUrl(),
                    'summary' => $p->short_description ?: 'Hộp nhung và thiệp Lunara sang trọng.',
                ];
            })
            ->all();

        // 5. Blog Categories (1 query with withCount - NO N+1)
        $blogCategories = PostCategory::query()
            ->where('is_active', true)
            ->withCount(['posts' => fn ($q) => $q->published()])
            ->orderBy('sort_order')
            ->get()
            ->map(fn (PostCategory $bc) => [
                'id' => $bc->id,
                'name' => $bc->name,
                'slug' => $bc->slug,
                'url' => route('blog.category', $bc->slug),
                'count' => $bc->posts_count ?? 0,
            ])
            ->all();

        $data = [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'collections' => $collections,
            'giftSets' => $giftSets,
            'blogCategories' => $blogCategories,
        ];

        Cache::put(self::CACHE_KEY, $data, self::CACHE_TTL_SECONDS);
        self::$staticCache = $data;

        return $data;
    }

    /**
     * Retrieve cached dynamic navigation payload for Mega Menu and Mobile Drawer.
     */
    public function getNavigationData(): array
    {
        if (self::$staticCache !== null) {
            return self::$staticCache;
        }

        $cached = Cache::get(self::CACHE_KEY);
        if ($cached !== null && is_array($cached)) {
            self::$staticCache = $cached;

            return $cached;
        }

        return $this->warmCache();
    }

    /**
     * Flush navigation cache.
     */
    public function clearCache(): void
    {
        self::$staticCache = null;
        Cache::forget(self::CACHE_KEY);
    }
}
