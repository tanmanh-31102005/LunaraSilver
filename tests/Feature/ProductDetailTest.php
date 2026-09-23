<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_active_single_detail_displays_identity_price_and_primary_image(): void
    {
        $product = Product::query()->where('product_type', 'single')->with('images')->firstOrFail();
        $primary = $product->images->firstWhere('image_role', 'primary');

        $this->get(route('products.show', $product->slug))->assertOk()
            ->assertSee($product->name)
            ->assertSee('SKU: '.$product->sku)
            ->assertSee($primary->displayUrl(), false)
            ->assertSee('product-price__current', false)
            ->assertSee(route('products.category', $product->category->slug), false)
            ->assertSee('rel="canonical"', false);
    }

    public function test_missing_and_inactive_products_return_404(): void
    {
        $this->get('/product/khong-co')->assertNotFound();
        $product = Product::query()->firstOrFail();
        $product->update(['is_active' => false]);
        $this->get(route('products.show', $product->slug))->assertNotFound();
    }

    public function test_single_availability_uses_model_api(): void
    {
        $product = Product::query()->where('product_type', 'single')->firstOrFail();
        $product->update(['stock_quantity' => 0]);
        $this->assertFalse($product->fresh()->isInStock());
        $this->get(route('products.show', $product->slug))->assertOk()->assertSee('Hết hàng');
    }

    public function test_collections_and_gifts_use_component_stock_and_show_contents(): void
    {
        foreach (['collection', 'gift'] as $type) {
            $bundle = Product::query()->where('product_type', $type)->where('stock_quantity', 0)
                ->with('bundleItems.component')->firstOrFail();
            $this->assertTrue($bundle->isInStock());
            $component = $bundle->bundleItems->first()->component;

            $this->get(route('products.show', $bundle->slug))->assertOk()
                ->assertSee('Bộ sản phẩm gồm')
                ->assertSee('Có thể đặt '.$bundle->availableQuantity().' bộ')
                ->assertSee($component->name)
                ->assertSee('SKU: '.$component->sku)
                ->assertSee(route('products.show', $component->slug), false);
        }
    }

    public function test_bundle_and_component_availability_change_with_component_stock(): void
    {
        $bundle = Product::query()->where('product_type', 'gift')->with('bundleItems.component')->firstOrFail();
        $component = $bundle->bundleItems->first()->component;
        $component->update(['stock_quantity' => 0]);

        $this->get(route('products.show', $bundle->slug))->assertOk()
            ->assertSee('Hết hàng')
            ->assertViewHas('product', fn ($loaded) => ! $loaded->isInStock()
                && ! $loaded->bundleItems->first()->component->isInStock());
    }

    public function test_collection_gallery_includes_primary_and_hover_images(): void
    {
        $collection = Product::query()->where('product_type', 'collection')->with('images')->firstOrFail();
        $primary = $collection->images->firstWhere('image_role', 'primary');
        $hover = $collection->images->firstWhere('image_role', 'hover');

        $this->get(route('products.show', $collection->slug))->assertOk()
            ->assertSee($primary->displayUrl(), false)
            ->assertSee($hover->displayUrl(), false)
            ->assertSee('data-bs-slide-to="1"', false);
    }

    public function test_gallery_falls_back_when_primary_or_all_images_are_missing(): void
    {
        $collection = Product::query()->where('product_type', 'collection')->with('images')->firstOrFail();
        $collection->images()->where('image_role', 'primary')->delete();
        $hover = $collection->images()->where('image_role', 'hover')->firstOrFail();
        $this->get(route('products.show', $collection->slug))->assertOk()
            ->assertSee($hover->displayUrl(), false);

        $collection->images()->delete();
        $this->get(route('products.show', $collection->slug))->assertOk()
            ->assertSee('Chưa có ảnh sản phẩm')
            ->assertDontSee('<img src=""', false);
    }

    public function test_invalid_sale_price_does_not_render_a_discount(): void
    {
        $product = Product::query()->where('product_type', 'single')->firstOrFail();
        $product->update(['regular_price' => '100000.00', 'sale_price' => '200000.00']);
        $this->assertFalse($product->fresh()->hasValidSalePrice());
        $this->get(route('products.show', $product->slug))->assertOk()
            ->assertDontSee('detail-discount', false)
            ->assertDontSee('<del class="product-price__regular">100.000 ₫</del>', false);
    }

    public function test_null_specifications_are_omitted_and_description_is_escaped(): void
    {
        $product = Product::query()->where('product_type', 'single')->firstOrFail();
        $product->update(['material' => null, 'stone' => null, 'weight' => null,
            'size_info' => null, 'description' => '<script>alert(1)</script>']);

        $this->get(route('products.show', $product->slug))->assertOk()
            ->assertDontSee('<dt>Chất liệu</dt>', false)
            ->assertDontSee('<dt>Đá</dt>', false)
            ->assertDontSee('<dt>Trọng lượng</dt>', false)
            ->assertDontSee('<dt>Kích thước</dt>', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    public function test_related_products_are_same_category_active_and_exclude_current(): void
    {
        $product = Product::query()->where('product_type', 'single')->firstOrFail();
        $inactive = Product::query()->where('category_id', $product->category_id)->whereKeyNot($product->id)->firstOrFail();
        $inactive->update(['is_active' => false]);

        $this->get(route('products.show', $product->slug))->assertOk()
            ->assertViewHas('relatedProducts', fn ($related) => $related->count() <= 4
                && $related->every(fn ($item) => $item->is_active
                    && $item->id !== $product->id && $item->id !== $inactive->id
                    && $item->category_id === $product->category_id
                    && $item->relationLoaded('images') && $item->relationLoaded('bundleItems')));
    }

    public function test_detail_queries_are_bounded_for_bundles(): void
    {
        $bundle = Product::query()->where('product_type', 'collection')->firstOrFail();
        $count = 0;
        DB::listen(function () use (&$count): void {
            $count++;
        });
        $this->get(route('products.show', $bundle->slug))->assertOk();
        $this->assertLessThanOrEqual(15, $count);
    }
}
