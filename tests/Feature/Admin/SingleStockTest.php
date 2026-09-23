<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SingleStockTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->role = User::ROLE_ADMIN;
        $this->admin->save();
    }

    public function test_setting_quantity_to_zero_updates_stock_status_to_out_of_stock(): void
    {
        $product = Product::where('product_type', 'single')->where('stock_quantity', '>', 0)->firstOrFail();

        $payload = [
            'name' => $product->name,
            'sku' => $product->sku,
            'slug' => $product->slug,
            'category_id' => $product->category_id,
            'product_type' => 'single',
            'regular_price' => $product->regular_price,
            'stock_quantity' => 0,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product), $payload);

        $response->assertRedirect(route('admin.products.index'));

        $product->refresh();
        $this->assertEquals(0, $product->stock_quantity);
        $this->assertEquals('out_of_stock', $product->stock_status);
        $this->assertFalse($product->isInStock());
    }

    public function test_setting_quantity_greater_than_zero_updates_stock_status_to_in_stock(): void
    {
        $product = Product::where('product_type', 'single')->firstOrFail();
        $product->update(['stock_quantity' => 0, 'stock_status' => 'out_of_stock']);

        $payload = [
            'name' => $product->name,
            'sku' => $product->sku,
            'slug' => $product->slug,
            'category_id' => $product->category_id,
            'product_type' => 'single',
            'regular_price' => $product->regular_price,
            'stock_quantity' => 50,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product), $payload);

        $response->assertRedirect(route('admin.products.index'));

        $product->refresh();
        $this->assertEquals(50, $product->stock_quantity);
        $this->assertEquals('in_stock', $product->stock_status);
        $this->assertTrue($product->isInStock());
    }
}
