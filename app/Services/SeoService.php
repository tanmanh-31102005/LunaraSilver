<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeoService
{
    protected StructuredDataService $structuredData;

    public function __construct(StructuredDataService $structuredData)
    {
        $this->structuredData = $structuredData;
    }

    /**
     * Get the base HTTPS URL from config.
     */
    public function baseUrl(): string
    {
        $url = rtrim(config('app.url', 'https://lunarasilver.infinityfreeapp.com'), '/');

        // Always ensure HTTPS for canonicals and SEO URLs
        return preg_replace('/^http:\/\//i', 'https://', $url);
    }

    /**
     * Generate HTTPS canonical URL with query normalization.
     */
    public function canonical(?string $pathOrUrl = null, ?Request $request = null): string
    {
        $request = $request ?? request();
        $baseUrl = $this->baseUrl();

        if ($pathOrUrl) {
            if (str_starts_with($pathOrUrl, 'http://') || str_starts_with($pathOrUrl, 'https://')) {
                $parsed = parse_url($pathOrUrl);
                $path = $parsed['path'] ?? '/';
                $query = $parsed['query'] ?? null;
            } else {
                $path = '/'.ltrim($pathOrUrl, '/');
                $query = null;
            }
        } else {
            $path = $request ? $request->getPathInfo() : '/';
            $query = $request ? $request->getQueryString() : null;
        }

        $cleanPath = '/'.ltrim(rtrim($path, '/'), '/');
        if ($cleanPath === '') {
            $cleanPath = '/';
        }

        // Handle pagination canonical rules (18.42 - 18.43)
        // Self-canonical for page 2, 3... but normalize page 1 to base URL
        $pageParam = null;
        if ($request && $request->has('page')) {
            $pageNum = (int) $request->query('page');
            if ($pageNum > 1) {
                $pageParam = 'page='.$pageNum;
            }
        } elseif ($query) {
            parse_str($query, $parsedParams);
            if (isset($parsedParams['page'])) {
                $pageNum = (int) $parsedParams['page'];
                if ($pageNum > 1) {
                    $pageParam = 'page='.$pageNum;
                }
            }
        }

        $fullUrl = $baseUrl.($cleanPath === '/' ? '' : $cleanPath);

        if ($pageParam) {
            $fullUrl .= '?'.$pageParam;
        }

        return $fullUrl;
    }

    /**
     * Determine robots meta directive (18.34 - 18.41).
     */
    public function robots(?Request $request = null, array $options = []): string
    {
        if (! empty($options['robots'])) {
            return $options['robots'];
        }

        if (! empty($options['is_empty_category'])) {
            return 'noindex,follow';
        }

        $request = $request ?? request();
        if (! $request) {
            return 'index,follow';
        }

        $path = ltrim($request->getPathInfo(), '/');

        // 1. Private and utility routes
        $noindexPatterns = [
            'login',
            'register',
            'forgot-password',
            'reset-password*',
            'cart*',
            'checkout*',
            'order-success*',
            'account*',
            'payment/vnpay*',
            'admin*',
        ];

        foreach ($noindexPatterns as $pattern) {
            if (Str::is($pattern, $path)) {
                if (Str::is('admin*', $path) || Str::is('payment/vnpay*', $path)) {
                    return 'noindex,nofollow';
                }

                return 'noindex,follow';
            }
        }

        // 2. Internal Search URLs (18.39): ?q=...
        if ($request->filled('q')) {
            return 'noindex,follow';
        }

        // 3. Filter and Sort URLs (18.40 - 18.41): ?min_price=, ?max_price=, ?type=, ?material=, ?stone=, ?sort=
        $filterParams = ['min_price', 'max_price', 'type', 'material', 'stone', 'sort'];
        foreach ($filterParams as $param) {
            if ($request->filled($param)) {
                return 'noindex,follow';
            }
        }

        // If filtering by category via query string (?category=...) on /products
        if ($request->filled('category') && ! Str::startsWith($path, 'products/')) {
            return 'noindex,follow';
        }

        return 'index,follow';
    }

    /**
     * Default title with fallback.
     */
    public function title(?string $customTitle = null): string
    {
        if (filled($customTitle)) {
            return $customTitle;
        }

        return 'Trang Sức Bạc Top 1 | Lunara Silver — Trang Sức Bạc 925 Cao Cấp';
    }

    /**
     * Default meta description with fallback.
     */
    public function description(?string $customDescription = null): string
    {
        if (filled($customDescription)) {
            return Str::limit(strip_tags($customDescription), 160);
        }

        return 'Khám phá thương hiệu trang sức bạc top 1 Lunara Silver: bạc 925 cao cấp, dây chuyền bạc nữ, nhẫn bạc đôi, vòng tay bạc và lắc chân bạc nữ tinh tế, sáng bóng bền lâu.';
    }

    /**
     * Default SEO keywords with comprehensive target terms from market research.
     */
    public function keywords(?string $customKeywords = null): string
    {
        if (filled($customKeywords)) {
            return $customKeywords;
        }

        return implode(', ', [
            'trang sức bạc top 1',
            'bạc 925',
            'vòng tay bạc',
            'dây chuyền bạc',
            'nhẫn bạc',
            'dây chuyền bạc nữ',
            'nhẫn bạc nam',
            'dây chuyền bạc nam',
            'lắc tay bạc',
            'nhẫn bạc nữ',
            'nhẫn bạc đôi',
            'lắc chân bạc',
            'nhẫn đôi bạc',
            'vòng tay bạc nữ',
            'vòng bạc',
            'vòng bạc nam',
            'vòng tay bạc nam',
            'nhẫn cặp bạc',
            'vòng cổ bạc',
            'vòng cổ bạc nam',
            'vòng cổ bạc nữ',
            'nhẫn bạc cặp',
            'lắc tay nam bạc',
            'trang sức bạc nam',
            'bông tai bạc 925',
            'vòng tay nữ bạc',
            'dây chuyền nam bạc',
            'vòng tay nam bạc',
            'vòng bạc đôi',
            'dây chuyền nữ bạc',
            'vòng tay bạc nữ đẹp',
            'vòng bạc nữ đẹp',
            'bông tai bạc nam',
            'nhẫn bạc 925',
            'dây chuyền bạc nam sợi to',
            'lắc chân bạc nữ',
            'giá dây chuyền bạc nữ',
            'nhẫn nam bạc',
            'day chuyen bac',
            'nhẫn bạc đôi nam nữ',
            'trang sức bạc nữ',
            'trang suc bac',
            'vòng tay bạc đôi',
            'dây chuyền bạc nữ sợi nhỏ',
            'Lunara Silver',
        ]);
    }

    /**
     * Product SEO Title.
     */
    public function productTitle(Product $product): string
    {
        if (filled($product->seo_title)) {
            return $product->seo_title;
        }

        return $product->name.' | Lunara Silver';
    }

    /**
     * Product SEO Description.
     */
    public function productDescription(Product $product): string
    {
        if (filled($product->seo_description)) {
            return Str::limit(strip_tags($product->seo_description), 160);
        }

        $source = $product->short_description ?: $product->description ?: $product->name.' trang sức bạc 925 cao cấp từ Lunara Silver.';

        return Str::limit(strip_tags($source), 160);
    }

    /**
     * Category SEO Title.
     */
    public function categoryTitle(Category $category): string
    {
        if (filled($category->seo_title)) {
            return $category->seo_title;
        }

        return $category->name.' | Lunara Silver';
    }

    /**
     * Category SEO Description.
     */
    public function categoryDescription(Category $category): string
    {
        if (filled($category->seo_description)) {
            return Str::limit(strip_tags($category->seo_description), 160);
        }

        if (filled($category->description)) {
            return Str::limit(strip_tags($category->description), 160);
        }

        return "Bộ sưu tập {$category->name} bạc 925 cao cấp tuyển chọn từ Lunara Silver — Tinh tế, sáng bóng bền lâu và an toàn cho da.";
    }

    /**
     * Blog Index SEO Title.
     */
    public function blogIndexTitle(?Category $currentCategory = null): string
    {
        if ($currentCategory) {
            return $currentCategory->name.' — Lunara Journal | Cẩm nang & cảm hứng trang sức';
        }

        return 'Lunara Journal | Cẩm nang & cảm hứng trang sức';
    }

    /**
     * Blog Post SEO Title.
     */
    public function blogPostTitle(Post $post): string
    {
        if (filled($post->seo_title)) {
            return $post->seo_title;
        }

        return $post->title.' | Lunara Journal';
    }

    /**
     * Blog Post SEO Description.
     */
    public function blogPostDescription(Post $post): string
    {
        if (filled($post->seo_description)) {
            return Str::limit(strip_tags($post->seo_description), 160);
        }

        $source = $post->excerpt ?: strip_tags($post->content);

        return Str::limit($source, 160);
    }

    /**
     * Build OpenGraph payload.
     */
    public function openGraph(array $custom = []): array
    {
        $baseUrl = $this->baseUrl();
        $defaultImage = $baseUrl.'/media/lunara-logo-dark.svg';

        $image = $custom['image'] ?? $defaultImage;
        if (! str_starts_with($image, 'http')) {
            $image = $baseUrl.'/'.ltrim($image, '/');
        }
        $image = preg_replace('/^http:\/\//i', 'https://', $image);

        $url = $custom['url'] ?? $this->canonical();

        return [
            'title' => $custom['title'] ?? $this->title(),
            'description' => $custom['description'] ?? $this->description(),
            'url' => $url,
            'image' => $image,
            'type' => $custom['type'] ?? 'website',
            'site_name' => config('lunara.brand_name', 'Lunara Silver'),
        ];
    }

    /**
     * Build Twitter Card payload.
     */
    public function twitterCard(array $custom = []): array
    {
        $og = $this->openGraph($custom);

        return [
            'card' => 'summary_large_image',
            'title' => $og['title'],
            'description' => $og['description'],
            'image' => $og['image'],
        ];
    }

    /**
     * Access StructuredDataService.
     */
    public function structuredData(): StructuredDataService
    {
        return $this->structuredData;
    }
}
