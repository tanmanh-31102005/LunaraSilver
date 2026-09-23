<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CatalogSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_matches_source_and_all_references_are_valid(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('categories', 5);
        $this->assertDatabaseCount('products', 45);
        $this->assertDatabaseCount('product_images', 55);
        $this->assertDatabaseCount('bundle_items', 39);
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('settings', 0);
        $this->assertSame(30, Product::query()->where('product_type', 'single')->count());
        $this->assertSame(10, Product::query()->where('product_type', 'collection')->count());
        $this->assertSame(5, Product::query()->where('product_type', 'gift')->count());

        $this->assertSame(0, DB::table('products')->whereNull('category_id')->count());
        $this->assertSame(45, DB::table('products')->distinct()->count('sku'));
        $this->assertSame(45, DB::table('products')->distinct()->count('slug'));
        $this->assertSame(0, DB::table('products')->whereColumn('sale_price', '>', 'regular_price')->count());
        $this->assertSame(0, DB::table('bundle_items')->whereColumn('bundle_product_id', 'component_product_id')->count());

        $this->assertSame(30, DB::table('product_images')->join('products', 'products.id', '=', 'product_images.product_id')->where('products.product_type', 'single')->where('product_images.image_role', 'primary')->count());
        $this->assertSame(10, DB::table('product_images')->join('products', 'products.id', '=', 'product_images.product_id')->where('products.product_type', 'collection')->where('product_images.image_role', 'primary')->count());
        $this->assertSame(10, DB::table('product_images')->join('products', 'products.id', '=', 'product_images.product_id')->where('products.product_type', 'collection')->where('product_images.image_role', 'hover')->count());
        $this->assertSame(5, DB::table('product_images')->join('products', 'products.id', '=', 'product_images.product_id')->where('products.product_type', 'gift')->where('product_images.image_role', 'primary')->count());
        $this->assertSame(39, DB::table('bundle_items')->join('products as component', 'component.id', '=', 'bundle_items.component_product_id')->where('component.product_type', 'single')->count());

        foreach (DB::table('product_images')->pluck('image_url') as $path) {
            $this->assertFileExists(base_path($path));
        }

        $this->assertDatabaseHas('products', ['sku' => 'LNS-DC001', 'name' => 'Dây chuyền Lunara Thái Dương Lam', 'regular_price' => '450000.00', 'sale_price' => '390000.00', 'stock_quantity' => 20]);
        $this->assertDatabaseHas('product_images', ['image_url' => 'media/Product/dc0010.jpg', 'image_role' => 'primary']);
        $this->assertDatabaseHas('product_images', ['image_url' => 'media/Collection/set 1(2).png', 'image_role' => 'hover']);
        $this->assertSame('media/Collection/set 6(1).jpg.png', Product::query()->where('sku', 'LNS-SET006')->firstOrFail()->images()->where('image_role', 'primary')->firstOrFail()->image_url);
        $this->assertSame(2, DB::table('bundle_items')->join('products as bundle', 'bundle.id', '=', 'bundle_items.bundle_product_id')->where('bundle.sku', 'LNS-GIFT005')->value('bundle_items.quantity'));
        $this->assertSame(18, Product::query()->where('sku', 'LNS-SET001')->firstOrFail()->availableQuantity());
        $this->assertSame(17, Product::query()->where('sku', 'LNS-GIFT005')->firstOrFail()->availableQuantity());
        $this->assertTrue(Product::query()->where('sku', 'LNS-GIFT005')->firstOrFail()->isInStock());
    }

    public function test_reseeding_keeps_same_catalog_counts(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('categories', 5);
        $this->assertDatabaseCount('products', 45);
        $this->assertDatabaseCount('product_images', 55);
        $this->assertDatabaseCount('bundle_items', 39);
    }
}
