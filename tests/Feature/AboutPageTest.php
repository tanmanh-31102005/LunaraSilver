<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Services\SeoService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_about_page_returns_200_and_renders_successfully(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('CÂU CHUYỆN LUNARA');
        $response->assertSee('Một ánh sáng');
        $response->assertSee('của riêng bạn.');
        $response->assertSee('LUNARA SILVER');
        $response->assertSee('Shine with your own moonlight');
        $response->assertSee('Bạc 925');
        $response->assertSee('Chế Tác');
        $response->assertSee('Cảm Hứng');
    }

    public function test_about_page_has_correct_seo_title_description_and_canonical(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('<title>Câu chuyện Lunara | Lunara Silver</title>', false);

        $expectedCanonical = app(SeoService::class)->canonical('/about');
        $response->assertSee('<link rel="canonical" href="'.$expectedCanonical.'">', false);

        $response->assertSee('meta name="description" content="Lunara Silver ra đời từ tình yêu với ánh trăng', false);
    }

    public function test_about_page_contains_single_h1_and_semantic_hierarchy(): void
    {
        $response = $this->get(route('about'));
        $content = $response->getContent();

        // Count <h1> tags in response
        preg_match_all('/<h1[^>]*>(.*?)<\/h1>/si', $content, $h1Matches);
        $this->assertCount(1, $h1Matches[0], 'About page must contain exactly one <h1> heading.');
        $this->assertStringContainsString('Một ánh sáng', $h1Matches[1][0]);

        // Verify h2 headings exist for sections
        $this->assertStringContainsString('<h2 id="origin-heading"', $content);
        $this->assertStringContainsString('<h2 id="values-heading"', $content);
        $this->assertStringContainsString('<h2 class="about-statement__title">', $content);
        $this->assertStringContainsString('<h2 id="philosophy-heading"', $content);
        $this->assertStringContainsString('<h2 id="cta-heading"', $content);
    }

    public function test_about_page_hero_contains_video_with_required_attributes(): void
    {
        $response = $this->get(route('about'));
        $content = $response->getContent();

        // Must have video with autoplay, muted, loop, playsinline, preload="metadata"
        $this->assertStringContainsString('<video', $content);
        $this->assertStringContainsString('autoplay', $content);
        $this->assertStringContainsString('muted', $content);
        $this->assertStringContainsString('loop', $content);
        $this->assertStringContainsString('playsinline', $content);
        $this->assertStringContainsString('preload="metadata"', $content);
        $this->assertStringContainsString('Animationbanner.mp4', $content);
        $this->assertStringContainsString('aria-hidden="true"', $content);
    }

    public function test_about_page_gracefully_handles_missing_celestial_collection(): void
    {
        // When no celestial product exists in DB
        $this->assertDatabaseMissing('products', ['slug' => 'celestial-whispers']);

        $response = $this->get(route('about'));

        $response->assertStatus(200);
        // Section 07 should be hidden
        $response->assertDontSee('id="collection-heading"', false);
    }

    public function test_about_page_renders_celestial_collection_when_present(): void
    {
        $category = Category::where('slug', 'bo-trang-suc')->first() ?? Category::first();

        Product::create([
            'category_id' => $category->id,
            'name' => 'Celestial Whispers Collection',
            'sku' => 'LNS-COL-CELESTIAL',
            'slug' => 'celestial-whispers',
            'product_type' => 'collection',
            'regular_price' => 1500000,
            'stock_quantity' => 10,
            'short_description' => 'Bộ sưu tập trang sức bạc trăng sao huyền diệu.',
            'description' => 'Những thiết kế kết hợp mặt trăng và các chòm sao tinh vân.',
            'is_active' => true,
        ]);

        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('id="collection-heading"', false);
        $response->assertSee('Celestial Whispers Collection');
        $response->assertSee('Bộ sưu tập trang sức bạc trăng sao huyền diệu.');
        $response->assertSee(route('products.show', 'celestial-whispers'));
    }

    public function test_about_page_renders_jewelry_editorial_categories(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('ĐƯỢC TẠO NÊN ĐỂ ĐỒNG HÀNH CÙNG BẠN');
        $response->assertSee('Dây chuyền');
        $response->assertSee('Nhẫn');
        $response->assertSee('Vòng tay');
        $response->assertSee(route('products.category', 'day-chuyen'));
        $response->assertSee(route('products.category', 'nhan'));
        $response->assertSee(route('products.category', 'vong-tay'));
    }

    public function test_about_page_sitemap_entry_exists(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $base = app(SeoService::class)->baseUrl();
        $this->assertStringContainsString('<loc>'.$base.'/about</loc>', $response->getContent());
    }

    public function test_homepage_story_section_uses_cinematic_video(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('class="story-section story-section--cinematic"', $content);
        $this->assertStringContainsString('Animationbanner.mp4', $content);
        $this->assertStringContainsString('id="story"', $content);
        $this->assertStringContainsString('Bạc 925 Tuyển Chọn', $content);
        $this->assertStringContainsString('Chế Tác Tinh Xảo', $content);
        $this->assertStringContainsString('Cảm Hứng Thiên Văn', $content);
        $this->assertStringContainsString(route('about'), $content);
    }
}
