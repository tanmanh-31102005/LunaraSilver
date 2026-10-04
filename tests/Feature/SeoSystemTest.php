<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\SeoRedirect;
use App\Models\User;
use App\Services\SeoService;
use Database\Seeders\BlogSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->seed(BlogSeeder::class);
    }

    public function test_sitemap_returns_valid_xml_and_includes_active_content(): void
    {
        $category = Category::where('slug', 'day-chuyen')->firstOrFail();
        $activeProduct = Product::where('is_active', true)->firstOrFail();
        $publishedPost = Post::where('status', 'published')->firstOrFail();
        $draftPost = Post::where('status', 'draft')->first();

        // Create an inactive product to verify exclusion
        $inactiveProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Sản Phẩm Tạm Khóa',
            'sku' => 'TEST-INACTIVE-01',
            'slug' => 'san-pham-tam-khoa',
            'product_type' => 'single',
            'regular_price' => 500000,
            'stock_quantity' => 5,
            'is_active' => false,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $content = $response->getContent();
        $base = app(SeoService::class)->baseUrl();

        // Must include homepage, active category, active product, blog, published post, faq, contact
        $this->assertStringContainsString('<loc>'.$base.'</loc>', $content);
        $this->assertStringContainsString('<loc>'.$base.'/products/'.$category->slug.'</loc>', $content);
        $this->assertStringContainsString('<loc>'.$base.'/product/'.$activeProduct->slug.'</loc>', $content);
        $this->assertStringContainsString('<loc>'.$base.'/blog</loc>', $content);
        $this->assertStringContainsString('<loc>'.$base.'/blog/'.$publishedPost->slug.'</loc>', $content);
        $this->assertStringContainsString('<loc>'.$base.'/support/faq</loc>', $content);
        $this->assertStringContainsString('<loc>'.$base.'/contact</loc>', $content);

        // Must NOT include inactive product or draft post
        $this->assertStringNotContainsString('/product/'.$inactiveProduct->slug, $content);
        if ($draftPost) {
            $this->assertStringNotContainsString('/blog/'.$draftPost->slug, $content);
        }
    }

    public function test_robots_txt_is_served_and_disallows_admin(): void
    {
        $robotsContent = file_get_contents(public_path('robots.txt'));

        $this->assertStringContainsString('User-agent: *', $robotsContent);
        $this->assertStringContainsString('Disallow: /admin/', $robotsContent);
        $this->assertStringContainsString('Sitemap: https://lunarasilver.infinityfreeapp.com/sitemap.xml', $robotsContent);
    }

    public function test_homepage_renders_online_store_schema_and_canonical(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $canonicalBase = app(SeoService::class)->baseUrl();
        $response->assertSee('<link rel="canonical" href="'.$canonicalBase.'">', false);
        $response->assertSee('OnlineStore', false);
        $response->assertSee('lunaraslivertrangsuc@gmail.com', false);
        $response->assertSee('140 Lê Trọng Tấn', false);
        $response->assertSee('<meta name="google-site-verification" content="4Gy0jMk2_McuovirJFJZl_h42XWvuNuoTCydAB2DqYI">', false);
    }

    public function test_product_detail_renders_product_schema_and_canonical(): void
    {
        $product = Product::where('is_active', true)->where('product_type', 'single')->firstOrFail();

        $response = $this->get('/product/'.$product->slug);

        $response->assertStatus(200);
        $canonicalUrl = app(SeoService::class)->canonical('/product/'.$product->slug);
        $response->assertSee('<link rel="canonical" href="'.$canonicalUrl.'">', false);
        $response->assertSee('"@type": "Product"', false);
        $response->assertSee('"@type": "Offer"', false);
        $response->assertSee('"price": '.(int) $product->effective_price, false);
    }

    public function test_search_and_query_parameters_trigger_noindex(): void
    {
        $category = Category::where('slug', 'day-chuyen')->firstOrFail();

        // Clean category should be indexable
        $response = $this->get('/products/'.$category->slug);
        $response->assertStatus(200);
        $response->assertSee('<meta name="robots" content="index,follow">', false);

        // Filtered search on category should be noindex,follow
        $responseWithSort = $this->get('/products/'.$category->slug.'?sort=price_asc');
        $responseWithSort->assertStatus(200);
        $responseWithSort->assertSee('<meta name="robots" content="noindex,follow">', false);

        // Search on FAQ should be noindex,follow
        $responseFaq = $this->get('/support/faq?q=doi-tra');
        $responseFaq->assertStatus(200);
        $responseFaq->assertSee('<meta name="robots" content="noindex,follow">', false);
    }

    public function test_seo_redirect_middleware_intercepts_old_paths(): void
    {
        SeoRedirect::create([
            'old_path' => '/san-pham-cu-123',
            'new_path' => '/products',
            'status_code' => 301,
        ]);

        $response = $this->get('/san-pham-cu-123');

        $response->assertStatus(301);
        $response->assertRedirect('/products');
    }

    public function test_seo_redirect_collapses_chains_automatically(): void
    {
        SeoRedirect::registerRedirect('/path-a', '/path-b');
        SeoRedirect::registerRedirect('/path-b', '/path-c');

        $this->assertEquals('/path-c', SeoRedirect::where('old_path', '/path-a')->value('new_path'));
        $this->assertEquals('/path-c', SeoRedirect::where('old_path', '/path-b')->value('new_path'));
    }

    public function test_account_pages_are_protected_with_noindex(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/account');

        $response->assertStatus(200);
        $response->assertSee('<meta name="robots" content="noindex,follow">', false);
    }
}
