<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Str;

class StructuredDataService
{
    /**
     * Build OnlineStore Schema for homepage / about.
     */
    public function organizationSchema(): array
    {
        $baseUrl = rtrim(config('app.url', 'https://lunarasilver.infinityfreeapp.com'), '/');
        // Ensure https
        $baseUrl = preg_replace('/^http:\/\//i', 'https://', $baseUrl);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'OnlineStore',
            'name' => config('lunara.brand_name', 'Lunara Silver'),
            'url' => $baseUrl.'/',
            'logo' => $baseUrl.'/media/lunara-logo-dark.svg',
            'description' => 'Trang sức bạc 925 cao cấp lấy cảm hứng từ vẻ đẹp huyền diệu của mặt trăng và các vì sao. Tinh tế, thanh lịch và tỏa sáng theo cách của riêng bạn.',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => config('lunara.contact_phone', '0971 124 922'),
                'contactType' => 'customer service',
                'email' => config('lunara.contact_email', 'lunaraslivertrangsuc@gmail.com'),
                'areaServed' => 'VN',
                'availableLanguage' => ['vi', 'en'],
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '140 Lê Trọng Tấn, Tây Thạnh, Tân Phú',
                'addressLocality' => 'Ho Chi Minh City',
                'addressRegion' => 'Ho Chi Minh',
                'addressCountry' => 'VN',
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    'opens' => '08:30',
                    'closes' => '20:30',
                ],
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Sunday'],
                    'opens' => '09:00',
                    'closes' => '18:00',
                ],
            ],
        ];
    }

    /**
     * Build Product + Offer Schema server-side for Product Detail.
     */
    public function productSchema(Product $product): array
    {
        $baseUrl = rtrim(config('app.url', 'https://lunarasilver.infinityfreeapp.com'), '/');
        $baseUrl = preg_replace('/^http:\/\//i', 'https://', $baseUrl);
        $productUrl = $baseUrl.'/product/'.$product->slug;

        // Collect all high quality images
        $images = [];
        if ($product->relationLoaded('images') || $product->images()->exists()) {
            foreach ($product->images as $img) {
                $images[] = $img->displayUrl();
            }
        }
        if (empty($images)) {
            $images[] = $product->primary_image_url ?: ($baseUrl.'/media/lunara-logo-dark.svg');
        }

        // Active selling price (server-side, never from client)
        $sellingPrice = (float) $product->effective_price;

        // CRITICAL (18.19): Availability determination
        // Bundle must check $product->availableQuantity(), single checks stock_quantity
        if ($product->product_type !== 'single') {
            $availableCount = $product->availableQuantity();
            $inStock = $availableCount > 0;
        } else {
            $inStock = (int) $product->stock_quantity > 0;
        }

        $availabilityUrl = $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';

        $description = $product->seo_description
            ?: Str::limit(strip_tags($product->short_description ?: $product->description ?: $product->name), 250);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $description,
            'sku' => $product->sku,
            'image' => $images,
            'url' => $productUrl,
            'brand' => [
                '@type' => 'Brand',
                'name' => config('lunara.brand_name', 'Lunara Silver'),
            ],
            'category' => $product->category?->name ?? 'Trang sức bạc 925',
            'offers' => [
                '@type' => 'Offer',
                'url' => $productUrl,
                'priceCurrency' => 'VND',
                'price' => $sellingPrice,
                'priceValidUntil' => now()->addMonths(6)->toDateString(),
                'itemCondition' => 'https://schema.org/NewCondition',
                'availability' => $availabilityUrl,
                'seller' => [
                    '@type' => 'Organization',
                    'name' => config('lunara.brand_name', 'Lunara Silver'),
                ],
            ],
        ];
    }

    /**
     * Build BreadcrumbList Schema.
     * Items format: [['label' => 'Trang chủ', 'url' => 'https://...'], ['label' => 'Nhẫn']]
     */
    public function breadcrumbSchema(array $items): array
    {
        $baseUrl = rtrim(config('app.url', 'https://lunarasilver.infinityfreeapp.com'), '/');
        $baseUrl = preg_replace('/^http:\/\//i', 'https://', $baseUrl);

        $elements = [];
        $position = 1;

        // Always prepend Home if not first item
        $hasHome = false;
        if (! empty($items) && isset($items[0]['url']) && ($items[0]['url'] === $baseUrl || $items[0]['url'] === $baseUrl.'/')) {
            $hasHome = true;
        }

        if (! $hasHome) {
            $elements[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Trang chủ',
                'item' => $baseUrl.'/',
            ];
        }

        foreach ($items as $item) {
            $itemUrl = $item['url'] ?? null;
            if ($itemUrl && ! str_starts_with($itemUrl, 'http')) {
                $itemUrl = $baseUrl.'/'.ltrim($itemUrl, '/');
            }
            if ($itemUrl) {
                $itemUrl = preg_replace('/^http:\/\//i', 'https://', $itemUrl);
            }

            $element = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $item['label'],
            ];

            if ($itemUrl) {
                $element['item'] = $itemUrl;
            }

            $elements[] = $element;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $elements,
        ];
    }

    /**
     * Build BlogPosting Schema for article detail.
     */
    public function blogPostingSchema(Post $post): array
    {
        $baseUrl = rtrim(config('app.url', 'https://lunarasilver.infinityfreeapp.com'), '/');
        $baseUrl = preg_replace('/^http:\/\//i', 'https://', $baseUrl);
        $postUrl = $baseUrl.'/blog/'.$post->slug;

        $coverImage = $post->cover_image;
        if (! str_starts_with($coverImage, 'http')) {
            $coverImage = $baseUrl.'/'.ltrim($coverImage, '/');
        }
        $coverImage = preg_replace('/^http:\/\//i', 'https://', $coverImage);

        $description = $post->seo_description
            ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 200));

        $publishedDate = $post->published_at ? $post->published_at->toIso8601String() : now()->toIso8601String();
        $modifiedDate = $post->updated_at ? $post->updated_at->toIso8601String() : $publishedDate;

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $description,
            'image' => [$coverImage],
            'datePublished' => $publishedDate,
            'dateModified' => $modifiedDate,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $postUrl,
            ],
            'author' => [
                '@type' => 'Person',
                'name' => $post->author?->name ?: 'Lunara Editorial',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('lunara.brand_name', 'Lunara Silver'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $baseUrl.'/media/lunara-logo-dark.svg',
                ],
            ],
        ];
    }
}
