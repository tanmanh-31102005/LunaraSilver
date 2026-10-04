<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Get live suggestions for search overlay (products, categories, blog).
     *
     * @return array{
     *     query: string,
     *     products: array<int, array{id: int, name: string, sku: string, slug: string, url: string, image_url: ?string, price_display: string, in_stock: bool, category_name: string}>,
     *     categories: array<int, array{id: int, name: string, slug: string, url: string, count: int}>,
     *     posts: array<int, array{id: int, title: string, slug: string, url: string, excerpt: string, image_url: ?string}>,
     *     total_matches: int
     * }
     */
    public function suggestions(string $rawQuery): array
    {
        $q = trim(mb_substr($rawQuery, 0, 100));

        if (mb_strlen($q) < 2) {
            return [
                'query' => $q,
                'products' => [],
                'categories' => [],
                'posts' => [],
                'total_matches' => 0,
            ];
        }

        // 1. Search Products (max 6, ordered by relevance)
        $products = $this->searchProductsQuery($q)
            ->with(['category', 'images'])
            ->take(6)
            ->get()
            ->map(function (Product $product) {
                $image = $product->images->firstWhere('image_role', 'primary') ?: $product->images->first();

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'slug' => $product->slug,
                    'url' => route('products.show', $product->slug),
                    'image_url' => $image?->displayUrl(),
                    'price_display' => $product->sale_price !== null && $product->sale_price >= 0 && $product->sale_price < $product->regular_price
                        ? number_format($product->sale_price, 0, ',', '.').' ₫'
                        : number_format($product->regular_price, 0, ',', '.').' ₫',
                    'in_stock' => $product->isInStock(),
                    'category_name' => $product->category?->name ?? 'Trang sức',
                ];
            })
            ->all();

        // 2. Search Categories (max 3)
        $categories = Category::query()
            ->where('is_active', true)
            ->where('name', 'like', '%'.$q.'%')
            ->take(3)
            ->get()
            ->map(function (Category $category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'url' => route('products.category', $category->slug),
                    'count' => $category->products()->where('is_active', true)->count(),
                ];
            })
            ->all();

        // 3. Search Blog Posts (max 3)
        $posts = Post::query()
            ->published()
            ->where(function (Builder $builder) use ($q) {
                $builder->where('title', 'like', '%'.$q.'%')
                    ->orWhere('excerpt', 'like', '%'.$q.'%');
            })
            ->take(3)
            ->get()
            ->map(function (Post $post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'url' => route('blog.show', $post->slug),
                    'excerpt' => mb_strimwidth($post->excerpt ?: strip_tags($post->body ?? ''), 0, 90, '...'),
                    'image_url' => $post->cover_image_url ? asset($post->cover_image_url) : null,
                ];
            })
            ->all();

        $totalMatches = count($products) + count($categories) + count($posts);

        return [
            'query' => $q,
            'products' => $products,
            'categories' => $categories,
            'posts' => $posts,
            'total_matches' => $totalMatches,
        ];
    }

    /**
     * Full Search Results Query for the /search page.
     *
     * @return array{
     *     query: string,
     *     products: LengthAwarePaginator,
     *     posts: Collection<int, Post>,
     *     categories: Collection<int, Category>,
     *     total_products: int
     * }
     */
    public function searchResults(string $rawQuery, int $perPage = 12): array
    {
        $q = trim(mb_substr($rawQuery, 0, 100));

        if (mb_strlen($q) < 2) {
            return [
                'query' => $q,
                'products' => Product::query()->whereRaw('1 = 0')->paginate($perPage),
                'posts' => collect(),
                'categories' => collect(),
                'total_products' => 0,
            ];
        }

        $products = $this->searchProductsQuery($q)
            ->with(['category', 'images', 'bundleItems.component.images'])
            ->paginate($perPage)
            ->withQueryString();

        $posts = Post::query()
            ->published()
            ->where(function (Builder $builder) use ($q) {
                $builder->where('title', 'like', '%'.$q.'%')
                    ->orWhere('excerpt', 'like', '%'.$q.'%');
            })
            ->take(6)
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->where('name', 'like', '%'.$q.'%')
            ->take(5)
            ->get();

        return [
            'query' => $q,
            'products' => $products,
            'posts' => $posts,
            'categories' => $categories,
            'total_products' => $products->total(),
        ];
    }

    /**
     * Build scoped query with relevance ordering.
     */
    protected function searchProductsQuery(string $q): Builder
    {
        $pattern = '%'.$q.'%';

        return Product::query()
            ->where('is_active', true)
            ->where(function (Builder $query) use ($pattern) {
                $query->where('name', 'like', $pattern)
                    ->orWhere('sku', 'like', $pattern)
                    ->orWhere('material', 'like', $pattern)
                    ->orWhere('stone', 'like', $pattern)
                    ->orWhere('short_description', 'like', $pattern)
                    ->orWhereHas('category', function (Builder $catQuery) use ($pattern) {
                        $catQuery->where('name', 'like', $pattern);
                    });
            })
            ->orderByRaw('
                CASE
                    WHEN name = ? THEN 1
                    WHEN sku = ? THEN 2
                    WHEN name LIKE ? THEN 3
                    WHEN sku LIKE ? THEN 4
                    ELSE 5
                END ASC
            ', [$q, $q, $q.'%', $q.'%'])
            ->orderByDesc('is_featured')
            ->orderByDesc('id');
    }
}
