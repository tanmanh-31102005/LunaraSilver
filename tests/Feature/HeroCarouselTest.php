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

        // 2. Slide 1 Assertions
        $response->assertSee('BỘ SƯU TẬP ÁNH TRĂNG')
            ->assertSee('Tỏa sáng cùng nhịp điệu riêng của bạn')
            ->assertSee('Khám phá những thiết kế bạc lấy cảm hứng từ bầu trời đêm.')
            ->assertSee('Khám phá bộ sưu tập')
            ->assertSee(route('products.category', 'bo-trang-suc'))
            ->assertSee('media-previews/hero.webp')
            ->assertSee('fetchpriority="high"', false);

        // 3. Slide 2 Assertions
        $response->assertSee('LUNARA SILVER')
            ->assertSee('Trang sức cho những khoảnh khắc đáng nhớ')
            ->assertSee('Những đường nét tinh tế, thanh lịch và hiện đại.')
            ->assertSee('Xem sản phẩm')
            ->assertSee(route('products.index'))
            ->assertSee('media-previews/hero-2.webp');

        // 4. Slide 3 Assertions
        $response->assertSee('QUÀ TẶNG TỪ ÁNH TRĂNG')
            ->assertSee('Một món quà nhỏ, một dấu ấn thật lâu')
            ->assertSee('Khám phá những lựa chọn quà tặng tinh tế từ Lunara.')
            ->assertSee('Khám phá quà tặng')
            ->assertSee(route('products.category', 'set-qua-tang'))
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
