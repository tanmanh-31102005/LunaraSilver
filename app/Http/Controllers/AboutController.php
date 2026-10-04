<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    /**
     * Show the Lunara Silver Luxury Editorial Brand Story page.
     */
    public function index(): View
    {
        // 1. Featured Collection (Celestial Whispers lookup)
        $celestialCollection = Product::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('slug', 'like', '%celestial%')
                    ->orWhere('name', 'like', '%celestial%')
                    ->orWhere('name', 'like', '%Celestial Whispers%');
            })
            ->with(['images', 'category'])
            ->first();

        // 2. Featured Categories for Jewelry Editorial
        $featuredCategories = Category::query()
            ->where('is_active', true)
            ->whereIn('slug', ['day-chuyen', 'nhan', 'vong-tay'])
            ->orderBy('sort_order')
            ->get();

        $categoryIds = $featuredCategories->pluck('id');

        $products = Product::query()
            ->where('is_active', true)
            ->whereIn('category_id', $categoryIds)
            ->with(['images', 'category'])
            ->get();

        $categoryVisuals = $featuredCategories->map(function (Category $category) use ($products) {
            $product = $products->firstWhere('category_id', $category->id);
            $primaryImage = $product?->images->firstWhere('image_role', 'primary') ?? $product?->images->first();

            $imageUrl = $primaryImage?->displayUrl()
                ?? (is_file(public_path('media-previews/hero.webp'))
                    ? asset('media-previews/hero.webp')
                    : route('media.show', ['path' => 'banner.jpg']));

            return [
                'category' => $category,
                'name' => $category->name,
                'slug' => $category->slug,
                'url' => route('products.category', $category->slug),
                'image_url' => $imageUrl,
                'alt' => 'Bộ sưu tập '.$category->name.' — Lunara Silver',
            ];
        });

        return view('about', [
            'celestialCollection' => $celestialCollection,
            'categoryVisuals' => $categoryVisuals,
        ]);
    }
}
