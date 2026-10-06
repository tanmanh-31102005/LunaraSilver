<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeroCarouselTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_three_slide_premium_hero_carousel(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/');

        $response->assertOk();

        // 1. Hero Carousel Container & Accessibility Attributes
        $response->assertSee('id="heroSlider"', false)
            ->assertSee('aria-roledescription="carousel"', false)
            ->assertSee('data-autoplay="true"', false)
            ->assertSee('data-interval="5500"', false);

        // 2. Slide 1 Assertions (SEO Top 1 Banner Title)
        $response->assertSee('LUNARA SILVER · THƯƠNG HIỆU UY TÍN')
            ->assertSee('Trang Sức Bạc Top 1')
            ->assertSee('Khám phá ngay')
            ->assertSee('media-previews/hero.webp')
            ->assertSee('fetchpriority="high"', false);

        // 3. Slide 2 Assertions (Category & Silver 925 terms)
        $response->assertSee('BỘ SƯU TẬP BẠC 925 TINH TUYỂN')
            ->assertSee('Dây Chuyền Bạc Nữ &amp; Nhẫn Bạc 925', false)
            ->assertSee('Xem dây chuyền &amp; nhẫn bạc', false)
            ->assertSee('media-previews/hero-2.webp');

        // 4. Slide 3 Assertions (Rings & Gift terms)
        $response->assertSee('KỶ NIỆM &amp; QUÀ TẶNG Ý NGHĨA', false)
            ->assertSee('Nhẫn Bạc Đôi &amp; Vòng Tay Bạc Cao Cấp', false)
            ->assertSee('Khám phá quà tặng')
            ->assertSee('media-previews/hero-3.webp');

        // 5. Performance Check: Only 1 fetchpriority="high" image for hero
        $content = $response->getContent();
        $this->assertSame(1, substr_count($content, 'fetchpriority="high"'));

        // 6. Navigation Controls & Indicators
        $response->assertSee('hero-indicator--active')
            ->assertSee('data-slide-target="0"', false)
            ->assertSee('data-slide-target="1"', false)
            ->assertSee('data-slide-target="2"', false)
            ->assertSee('id="heroSliderPrev"', false)
            ->assertSee('id="heroSliderNext"', false)
            ->assertSee('id="heroSliderPauseBtn"', false);

        // 7. Visual Separation & Hierarchy (Section after hero is categories-section with white background)
        $heroPos = strpos($content, 'id="heroSlider"');
        $catPos = strpos($content, 'class="home-section categories-section"');
        $storyPos = strpos($content, 'id="story"');
        $giftsPos = strpos($content, 'id="gifts"');

        $this->assertNotFalse($heroPos);
        $this->assertNotFalse($catPos);
        $this->assertNotFalse($storyPos);
        $this->assertNotFalse($giftsPos);

        // Hero is first, categories is immediately after, story is after gifts
        $this->assertLessThan($catPos, $heroPos);
        $this->assertLessThan($storyPos, $giftsPos);
    }

    public function test_all_three_hero_webp_images_exist_and_are_optimized(): void
    {
        $hero1 = public_path('media-previews/hero.webp');
        $hero2 = public_path('media-previews/hero-2.webp');
        $hero3 = public_path('media-previews/hero-3.webp');

        $this->assertFileExists($hero1);
        $this->assertFileExists($hero2);
        $this->assertFileExists($hero3);

        // Each image should be webp and under 350KB (down from 2.4MB)
        $this->assertLessThan(350 * 1024, filesize($hero1));
        $this->assertLessThan(350 * 1024, filesize($hero2));
        $this->assertLessThan(350 * 1024, filesize($hero3));
    }
}
