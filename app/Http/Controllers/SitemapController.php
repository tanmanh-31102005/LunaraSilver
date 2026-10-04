<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap with accurate lastmod and absolute HTTPS URLs.
     */
    public function index(): Response
    {
        $baseUrl = rtrim(config('app.url', 'https://lunarasilver.infinityfreeapp.com'), '/');
        $baseUrl = preg_replace('/^http:\/\//i', 'https://', $baseUrl);

        $urls = [];

        // 1. Homepage
        $urls[] = [
            'loc' => $baseUrl,
            'lastmod' => now()->toDateString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // 2. Products Catalog Root
        $urls[] = [
            'loc' => $baseUrl.'/products',
            'lastmod' => now()->toDateString(),
            'changefreq' => 'daily',
            'priority' => '0.8',
        ];

        // 3. Active Categories with products (18.45: exclude empty categories)
        $categories = Category::query()->where('is_active', true)
            ->whereHas('products', fn ($q) => $q->where('is_active', true))
            ->get();
        foreach ($categories as $cat) {
            $urls[] = [
                'loc' => $baseUrl.'/products/'.$cat->slug,
                'lastmod' => $cat->updated_at ? $cat->updated_at->toDateString() : now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 4. Active Products (18.46: exclude inactive products)
        $products = Product::query()->active()->get(['id', 'slug', 'updated_at']);
        foreach ($products as $prod) {
            $urls[] = [
                'loc' => $baseUrl.'/product/'.$prod->slug,
                'lastmod' => $prod->updated_at ? $prod->updated_at->toDateString() : now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 5. Blog Index
        $urls[] = [
            'loc' => $baseUrl.'/blog',
            'lastmod' => now()->toDateString(),
            'changefreq' => 'daily',
            'priority' => '0.7',
        ];

        // 6. Active Blog Categories with published posts
        $blogCategories = PostCategory::query()->active()
            ->whereHas('posts', fn ($q) => $q->published())
            ->get();
        foreach ($blogCategories as $bcat) {
            $urls[] = [
                'loc' => $baseUrl.'/blog/category/'.$bcat->slug,
                'lastmod' => $bcat->updated_at ? $bcat->updated_at->toDateString() : now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        // 7. Published Blog Posts (exclude drafts)
        $posts = Post::query()->published()->get(['id', 'slug', 'updated_at', 'published_at']);
        foreach ($posts as $post) {
            $lastmod = $post->updated_at ?: $post->published_at ?: now();
            $urls[] = [
                'loc' => $baseUrl.'/blog/'.$post->slug,
                'lastmod' => $lastmod->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        // 8. Support & FAQ
        $urls[] = [
            'loc' => $baseUrl.'/support/faq',
            'lastmod' => now()->toDateString(),
            'changefreq' => 'monthly',
            'priority' => '0.5',
        ];

        // 9. Contact
        $urls[] = [
            'loc' => $baseUrl.'/contact',
            'lastmod' => now()->toDateString(),
            'changefreq' => 'monthly',
            'priority' => '0.5',
        ];

        $xml = view('sitemap.xml', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }
}
