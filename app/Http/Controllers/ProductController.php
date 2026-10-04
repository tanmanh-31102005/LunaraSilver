<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductDiscoveryService;
use App\Services\RecentlyViewedService;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product, Request $request): View
    {
        abort_unless($product->is_active, 404);

        $recentService = app(RecentlyViewedService::class);
        $recentSession = (array) $request->session()->get(RecentlyViewedService::SESSION_KEY, []);
        $recentlyViewed = $recentService->getProducts($recentSession, $product->id, 4);

        $recentService->record($product->id, $recentSession);
        $request->session()->put(RecentlyViewedService::SESSION_KEY, $recentSession);

        $product->load([
            'category',
            'images',
            'bundleItems.component.category',
            'bundleItems.component.images',
        ]);

        $reviewService = app(ReviewService::class);
        $discoveryService = app(ProductDiscoveryService::class);

        $ratingSummary = $product->ratingSummary();
        $hasApprovedReviews = $ratingSummary['total'] > 0;

        $ratingFilter = $request->query('rating') ? (int) $request->query('rating') : null;
        $sort = (string) $request->query('sort', 'newest');

        $reviews = $hasApprovedReviews
            ? $reviewService->getApprovedReviewsForProduct($product, $ratingFilter, $sort, 10)
            : new LengthAwarePaginator([], 0, 10, 1, ['path' => $request->url(), 'query' => $request->query()]);

        $customerGallery = $hasApprovedReviews
            ? $reviewService->getCustomerMediaGallery($product, 8)
            : collect();

        $user = $request->user();
        $eligibleOrderItem = $user ? $reviewService->getEligibleOrderItem($user, $product) : null;
        $hasReviewed = $user ? $reviewService->hasUserReviewedProduct($user, $product) : false;

        $relatedProducts = Product::query()->active()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->withCount('approvedReviews as approved_reviews_count')
            ->withAvg('approvedReviews as approved_reviews_avg_rating', 'rating')
            ->with(['category', 'images', 'bundleItems.component'])
            ->orderByDesc('created_at')->orderByDesc('id')->limit(4)->get();

        $completeTheLook = $discoveryService->getCompleteTheLook($product, $relatedProducts, 3);
        $parentCollection = $discoveryService->getParentCollection($product);

        $images = $product->images->sortBy(
            fn ($image) => (match ($image->image_role) {
                'primary' => 0,
                'hover' => 1,
                default => 2,
            }) * 10000 + $image->sort_order
        )->values();

        $specifications = array_filter([
            'SKU' => $product->sku,
            'Danh mục' => $product->category->name,
            'Chất liệu' => $product->material,
            'Đá' => $product->stone === '-' ? null : $product->stone,
            'Trọng lượng' => $product->weight,
            'Kích thước' => $product->size_info,
            'Loại sản phẩm' => match ($product->product_type) {
                'collection' => 'Bộ trang sức',
                'gift' => 'Set quà tặng',
                default => 'Sản phẩm lẻ',
            },
        ], fn ($value) => $value !== null && trim((string) $value) !== '');

        $metaDescription = Str::limit(strip_tags($product->short_description ?: $product->description ?: ''), 160, '');

        return view('products.show', compact(
            'product',
            'images',
            'specifications',
            'relatedProducts',
            'recentlyViewed',
            'metaDescription',
            'reviews',
            'ratingSummary',
            'customerGallery',
            'completeTheLook',
            'parentCollection',
            'eligibleOrderItem',
            'hasReviewed',
            'ratingFilter',
            'sort'
        ));
    }

    public function index(Request $request, ?Category $category = null): View
    {
        abort_if($category && ! $category->is_active, 404);

        $string = static function (mixed $value): ?string {
            if (! is_string($value)) {
                return null;
            }

            $value = trim($value);

            return $value === '' ? null : mb_substr($value, 0, 255);
        };
        $price = static function (mixed $value): ?string {
            return is_string($value) && preg_match('/^\d{1,13}(?:\.\d{1,2})?$/', trim($value))
                ? trim($value) : null;
        };

        $filters = [
            'q' => $string($request->query('q')),
            'min_price' => $price($request->query('min_price')),
            'max_price' => $price($request->query('max_price')),
            'type' => $string($request->query('type')),
            'material' => $string($request->query('material')),
            'stone' => $string($request->query('stone')),
        ];
        if (! in_array($filters['type'], Product::TYPES, true)) {
            $filters['type'] = null;
        }

        $sort = $request->query('sort');
        $sort = is_string($sort) && in_array($sort, ['newest', 'price_asc', 'price_desc', 'name_asc'], true)
            ? $sort : 'newest';

        $categories = Category::query()->where('is_active', true)->orderBy('sort_order')->get();
        $options = Product::query()->active()->category($category);
        $materials = (clone $options)->whereNotNull('material')->where('material', '<>', '')
            ->distinct()->orderBy('material')->pluck('material');
        $stones = (clone $options)->whereNotNull('stone')->where('stone', '<>', '')
            ->where('stone', '<>', '-')->distinct()->orderBy('stone')->pluck('stone');

        $products = Product::query()->active()->category($category)
            ->search($filters['q'])->priceRange($filters['min_price'], $filters['max_price'])
            ->productType($filters['type'])->material($filters['material'])->stone($filters['stone'])
            ->withCount('approvedReviews as approved_reviews_count')
            ->withAvg('approvedReviews as approved_reviews_avg_rating', 'rating')
            ->with(['category', 'images', 'bundleItems.component'])->sort($sort)
            ->paginate(12)->withQueryString();

        $baseRoute = $category
            ? route('products.category', ['category' => $category->slug])
            : route('products.index');
        $activeFilters = array_filter($filters, static fn ($value) => $value !== null);
        $removeUrls = [];
        foreach (array_keys($activeFilters) as $key) {
            $query = array_filter(array_diff_key($filters, [$key => true]), static fn ($value) => $value !== null);
            if ($sort !== 'newest') {
                $query['sort'] = $sort;
            }
            $removeUrls[$key] = $baseRoute.($query ? '?'.http_build_query($query) : '');
        }

        $pageTitle = $filters['q'] ? 'Tìm kiếm: '.$filters['q'] : ($category?->name ?? 'Sản phẩm');

        return view('products.index', compact(
            'category', 'categories', 'materials', 'stones', 'products',
            'filters', 'sort', 'baseRoute', 'activeFilters', 'removeUrls', 'pageTitle'
        ));
    }
}
