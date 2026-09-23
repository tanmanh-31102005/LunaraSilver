<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductImage;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_home_uses_real_catalog_and_preloads_bundle_data(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertGuest();

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Lunara Silver')
            ->assertSee('Dây chuyền Lunara Thái Dương Lam')
            ->assertSee('Bản Giao Hưởng Vũ Trụ')
            ->assertSee('Lunara Gift Box')
            ->assertSee('product-card__image--hover', false)
            ->assertSee('media-previews/'.sha1('media/Collection/set 1(1).jpg.png').'.webp', false)
            ->assertSee('media-previews/'.sha1('media/Collection/set 1(2).png').'.webp', false)
            ->assertSee('data-sku="LNS-SET001" data-available="true"', false)
            ->assertViewHas('collections', fn ($products) => $products->every(fn ($product) => $product->relationLoaded('images') && $product->relationLoaded('category') && $product->relationLoaded('bundleItems') && $product->bundleItems->every(fn ($item) => $item->relationLoaded('component')) && $product->images->contains('image_role', 'primary') && $product->images->contains('image_role', 'hover')));
    }

    public function test_media_route_serves_real_files_and_rejects_missing_file(): void
    {
        $this->get('/media/Product/dc001.jpg')->assertOk();
        $this->get('/media/Collection/set%201(1).jpg.png')->assertOk();
        $this->get('/media/Product/missing.jpg')->assertNotFound();
    }

    public function test_image_url_resolver_keeps_external_urls(): void
    {
        $image = new ProductImage(['image_url' => 'https://example.com/product.jpg', 'image_role' => 'primary']);

        $this->assertSame('https://example.com/product.jpg', $image->displayUrl());
    }

    public function test_local_image_uses_generated_preview(): void
    {
        $image = new ProductImage(['image_url' => 'media/Collection/set 1(1).jpg.png', 'image_role' => 'primary']);

        $this->assertFileExists(public_path('media-previews/'.sha1($image->image_url).'.webp'));
        $this->assertFileExists(public_path('media-previews/hero.webp'));
        $this->assertStringContainsString('/media-previews/', $image->displayUrl());
    }

    public function test_local_image_without_preview_uses_read_only_media_route(): void
    {
        $image = new ProductImage(['image_url' => 'media/banner.jpg', 'image_role' => 'primary']);

        $this->assertSame(route('media.show', ['path' => 'banner.jpg']), $image->displayUrl());
    }

    public function test_homepage_query_count_is_bounded_and_has_no_n_plus_one(): void
    {
        $this->seed(DatabaseSeeder::class);

        $queryCount = 0;
        DB::listen(function () use (&$queryCount): void {
            $queryCount++;
        });

        $response = $this->get('/');

        $response->assertOk();
        // 1 category query, 3 single product queries, 5 collection queries, 5 gift queries = 14 total queries
        $this->assertLessThanOrEqual(15, $queryCount);
    }

    public function test_homepage_renders_design_system_and_brand_assets(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('lunara-logo-dark.svg')
            ->assertSee('lunara-logo-light.svg')
            ->assertSee('skip-link')
            ->assertSee('mobileNavigation')
            ->assertSee('Shine with your own moonlight')
            ->assertDontSee('Thông tin liên hệ và chính sách sẽ được hiển thị')
            ->assertSee('₫');
    }

    public function test_gift_card_uses_component_availability_instead_of_its_stored_stock(): void
    {
        $this->seed(DatabaseSeeder::class);

        $gift = Product::query()->where('sku', 'LNS-GIFT001')->firstOrFail();
        $this->assertSame(0, $gift->stock_quantity);
        $this->get('/')->assertOk()->assertSee('data-sku="LNS-GIFT001" data-available="true"', false);

        Product::query()->where('sku', 'LNS-NH005')->firstOrFail()->update(['stock_quantity' => 0]);
        $this->get('/')->assertOk()->assertSee('data-sku="LNS-GIFT001" data-available="false"', false);
    }

    public function test_announcement_bar_is_hidden_by_default_and_renders_when_configured(): void
    {
        config(['lunara.announcement' => null]);
        $this->get('/')->assertOk()->assertDontSee('announcement-bar');

        config(['lunara.announcement' => 'Thông báo demo']);
        $this->get('/')->assertOk()->assertSee('announcement-bar')->assertSee('Thông báo demo');
    }
}
