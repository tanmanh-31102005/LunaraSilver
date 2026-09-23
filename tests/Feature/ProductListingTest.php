<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductListingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_listing_and_five_categories_are_available(): void
    {
        $this->get('/products')->assertOk()->assertViewHas('products', fn ($page) => $page->perPage() === 12);

        foreach (['day-chuyen', 'nhan', 'vong-tay', 'bo-trang-suc', 'set-qua-tang'] as $slug) {
            $this->get('/products/'.$slug)->assertOk()
                ->assertViewHas('products', fn ($page) => $page->every(fn ($product) => $product->category->slug === $slug));
        }
        $this->get('/products/khong-co')->assertNotFound();
    }

    public function test_search_uses_name_sku_and_descriptions(): void
    {
        $product = Product::query()->firstOrFail();
        foreach ([$product->name, $product->sku, $product->short_description, $product->description] as $term) {
            if (! $term) {
                continue;
            }
            $this->get('/products?q='.urlencode(mb_substr($term, 0, 15)))->assertOk()
                ->assertViewHas('products', fn ($page) => $page->contains('id', $product->id));
        }
        $this->get('/products?q=%20%20')->assertOk()->assertViewHas('products', fn ($page) => $page->total() > 12);
    }

    public function test_price_filters_and_sort_use_effective_price(): void
    {
        $effective = static fn ($product) => $product->sale_price !== null && $product->sale_price >= 0 && $product->sale_price <= $product->regular_price
            ? (float) $product->sale_price : (float) $product->regular_price;

        $this->get('/products?min_price=500000')->assertOk()
            ->assertViewHas('products', fn ($page) => $page->every(fn ($product) => $effective($product) >= 500000));
        $this->get('/products?max_price=500000')->assertOk()
            ->assertViewHas('products', fn ($page) => $page->every(fn ($product) => $effective($product) <= 500000));

        foreach (['price_asc', 'price_desc'] as $sort) {
            $this->get('/products?sort='.$sort)->assertOk()->assertViewHas('products', function ($page) use ($sort, $effective) {
                $prices = $page->map($effective)->all();
                $sorted = $prices;
                $sort === 'price_asc' ? sort($sorted) : rsort($sorted);

                return $prices === $sorted;
            });
        }
    }

    public function test_name_sort_and_pagination_keep_query(): void
    {
        $this->get('/products?sort=name_asc')->assertOk()->assertViewHas('products', function ($page) {
            $names = $page->pluck('name')->all();
            $sorted = $names;
            sort($sorted);

            return $names === $sorted;
        });
        $this->get('/products?sort=price_asc&page=2')->assertOk()
            ->assertSee('sort=price_asc', false)
            ->assertViewHas('products', fn ($page) => $page->currentPage() === 2 && $page->count() > 0);
    }

    public function test_material_stone_and_type_filters_use_catalog_values(): void
    {
        $product = Product::query()->whereNotNull('material')->whereNotNull('stone')->firstOrFail();
        $this->get('/products?material='.urlencode($product->material).'&stone='.urlencode($product->stone).'&type='.$product->product_type)
            ->assertOk()->assertViewHas('products', fn ($page) => $page->contains('id', $product->id)
                && $page->every(fn ($item) => $item->material === $product->material && $item->stone === $product->stone && $item->product_type === $product->product_type));
    }

    public function test_invalid_parameters_fall_back_and_empty_state_is_rendered(): void
    {
        $this->get('/products?min_price=abc&max_price=-1&sort=bad&type=bad')->assertOk()
            ->assertViewHas('sort', 'newest');
        $this->get('/products?q=zzzz-not-a-product')->assertOk()
            ->assertSee('Không tìm thấy sản phẩm phù hợp.')
            ->assertSee('Xem tất cả sản phẩm');
    }

    public function test_inactive_products_are_hidden(): void
    {
        $product = Product::query()->firstOrFail();
        $product->update(['is_active' => false]);
        $this->get('/products?q='.$product->sku)->assertOk()->assertViewHas('products', fn ($page) => ! $page->contains('id', $product->id));
    }

    public function test_bundle_cards_use_components_and_relations_are_eager_loaded(): void
    {
        $gift = Product::query()->where('sku', 'LNS-GIFT001')->firstOrFail();
        $this->assertSame(0, $gift->stock_quantity);
        $this->get('/products/set-qua-tang')->assertOk()
            ->assertSee('data-sku="LNS-GIFT001" data-available="true"', false)
            ->assertViewHas('products', fn ($page) => $page->every(fn ($product) => $product->relationLoaded('images')
                && $product->relationLoaded('category') && $product->relationLoaded('bundleItems')
                && $product->bundleItems->every(fn ($item) => $item->relationLoaded('component'))));
    }

    public function test_listing_query_count_does_not_grow_per_card(): void
    {
        $count = 0;
        DB::listen(function () use (&$count): void {
            $count++;
        });
        $this->get('/products')->assertOk();
        $this->assertLessThanOrEqual(10, $count);
    }
}
