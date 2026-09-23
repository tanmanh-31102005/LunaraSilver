<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->whereIn('slug', ['day-chuyen', 'nhan', 'vong-tay', 'bo-trang-suc', 'set-qua-tang'])
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->where('is_active', true)
            ->where('product_type', 'single')
            ->with(['category', 'images'])
            ->orderBy('sku')
            ->get();

        $featured = $products->where('is_featured', true)->take(4);
        if ($featured->isEmpty()) {
            $featured = $products->take(4);
        }

        $collections = Product::query()
            ->where('is_active', true)
            ->where('product_type', 'collection')
            ->with(['category', 'images', 'bundleItems.component'])
            ->orderBy('sku')
            ->limit(4)
            ->get();

        $gifts = Product::query()
            ->where('is_active', true)
            ->where('product_type', 'gift')
            ->with(['category', 'images', 'bundleItems.component'])
            ->orderBy('sku')
            ->limit(4)
            ->get();

        $categories->each(function (Category $category) use ($products, $collections, $gifts): void {
            $image = match ($category->slug) {
                'day-chuyen', 'nhan', 'vong-tay' => $products->firstWhere('category.slug', $category->slug)?->images->firstWhere('image_role', 'primary') ?: $products->firstWhere('category.slug', $category->slug)?->images->first(),
                'bo-trang-suc' => $collections->first()?->images->firstWhere('image_role', 'primary') ?: $collections->first()?->images->first(),
                'set-qua-tang' => $gifts->first()?->images->firstWhere('image_role', 'primary') ?: $gifts->first()?->images->first(),
                default => null,
            };

            $category->preview_image = $image?->displayUrl();
        });

        return view('home', [
            'categories' => $categories,
            'featured' => $featured,
            'necklaces' => $products->where('category.slug', 'day-chuyen')->take(4),
            'rings' => $products->where('category.slug', 'nhan')->take(2),
            'bracelets' => $products->where('category.slug', 'vong-tay')->take(2),
            'collections' => $collections,
            'gifts' => $gifts,
        ]);
    }
}
