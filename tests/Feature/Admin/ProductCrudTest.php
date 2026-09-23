<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->role = User::ROLE_ADMIN;
        $this->admin->save();

        $this->user = User::factory()->create();
    }

    public function test_admin_can_list_products(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.products.index'));

        $response->assertOk();
        $response->assertSee('Danh sách sản phẩm');
        $response->assertViewHas('products');
    }

    public function test_admin_can_search_products_by_sku(): void
    {
        $target = Product::firstOrFail();

        $response = $this->actingAs($this->admin)->get(route('admin.products.index', ['q' => $target->sku]));

        $response->assertOk();
        $response->assertSee($target->name);
    }

    public function test_admin_can_search_products_by_name(): void
    {
        $target = Product::firstOrFail();
        $keyword = mb_substr($target->name, 0, 8);

        $response = $this->actingAs($this->admin)->get(route('admin.products.index', ['q' => $keyword]));

        $response->assertOk();
        $response->assertSee($target->sku);
    }

    public function test_admin_can_filter_products_by_category(): void
    {
        $category = Category::whereHas('products')->firstOrFail();
        $expectedProduct = $category->products()->first();

        $response = $this->actingAs($this->admin)->get(route('admin.products.index', ['category_id' => $category->id]));

        $response->assertOk();
        $response->assertSee($expectedProduct->name);
    }

    public function test_admin_can_filter_products_by_product_type(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.products.index', ['product_type' => 'single']));

        $response->assertOk();
        $products = $response->viewData('products');
        foreach ($products as $p) {
            $this->assertEquals('single', $p->product_type);
        }
    }

    public function test_admin_can_create_single_product(): void
    {
        $category = Category::firstOrFail();

        $payload = [
            'name' => 'Nhẫn Bạc Luna Test 1',
            'sku' => 'LNR-RING-TEST-1',
            'slug' => 'nhan-bac-luna-test-1',
            'category_id' => $category->id,
            'product_type' => 'single',
            'regular_price' => 500000,
            'sale_price' => 450000,
            'stock_quantity' => 20,
            'material' => 'Bạc Ý 925',
            'is_active' => '1',
            'is_featured' => '1',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), $payload);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'sku' => 'LNR-RING-TEST-1',
            'name' => 'Nhẫn Bạc Luna Test 1',
            'stock_quantity' => 20,
            'stock_status' => 'in_stock',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_single_product(): void
    {
        $product = Product::where('product_type', 'single')->firstOrFail();

        $payload = [
            'name' => 'Tên Sản Phẩm Mới Đã Sửa',
            'sku' => $product->sku,
            'slug' => $product->slug,
            'category_id' => $product->category_id,
            'product_type' => 'single',
            'regular_price' => 990000,
            'sale_price' => 880000,
            'stock_quantity' => 15,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product), $payload);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Tên Sản Phẩm Mới Đã Sửa',
            'regular_price' => 990000,
            'sale_price' => 880000,
        ]);
    }

    public function test_inactive_product_disappears_from_storefront(): void
    {
        $product = Product::where('product_type', 'single')->where('is_active', true)->firstOrFail();

        // Initially active and accessible
        $this->get(route('products.show', $product->slug))->assertOk();

        // Admin deactivates it
        $this->actingAs($this->admin)->put(route('admin.products.update', $product), [
            'name' => $product->name,
            'sku' => $product->sku,
            'slug' => $product->slug,
            'category_id' => $product->category_id,
            'product_type' => $product->product_type,
            'regular_price' => $product->regular_price,
            'stock_quantity' => $product->stock_quantity,
            'is_active' => '0',
        ]);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'is_active' => false]);

        // Detail page returns 404
        $this->get(route('products.show', $product->slug))->assertNotFound();
    }

    public function test_duplicate_sku_is_rejected(): void
    {
        $existing = Product::firstOrFail();
        $category = Category::firstOrFail();

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'name' => 'Sản phẩm mới trùng SKU',
            'sku' => $existing->sku,
            'category_id' => $category->id,
            'product_type' => 'single',
            'regular_price' => 100000,
            'stock_quantity' => 10,
        ]);

        $response->assertSessionHasErrors(['sku']);
    }

    public function test_duplicate_slug_is_rejected(): void
    {
        $existing = Product::firstOrFail();
        $category = Category::firstOrFail();

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'name' => 'Sản phẩm mới trùng Slug',
            'sku' => 'SKU-UNIQUE-NEW-123',
            'slug' => $existing->slug,
            'category_id' => $category->id,
            'product_type' => 'single',
            'regular_price' => 100000,
            'stock_quantity' => 10,
        ]);

        $response->assertSessionHasErrors(['slug']);
    }

    public function test_invalid_prices_are_rejected(): void
    {
        $category = Category::firstOrFail();

        // Negative price
        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'name' => 'Sản phẩm giá âm',
            'sku' => 'SKU-NEG-PRICE',
            'category_id' => $category->id,
            'product_type' => 'single',
            'regular_price' => -100,
            'stock_quantity' => 10,
        ]);
        $response->assertSessionHasErrors(['regular_price']);

        // Sale price higher than regular price
        $response2 = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'name' => 'Sản phẩm giá sale cao hơn',
            'sku' => 'SKU-SALE-HIGH',
            'category_id' => $category->id,
            'product_type' => 'single',
            'regular_price' => 100000,
            'sale_price' => 150000,
            'stock_quantity' => 10,
        ]);
        $response2->assertSessionHasErrors(['sale_price']);
    }

    public function test_normal_user_cannot_crud_product(): void
    {
        $this->actingAs($this->user)->post(route('admin.products.store'), ['name' => 'Test'])->assertForbidden();
        $product = Product::firstOrFail();
        $this->actingAs($this->user)->put(route('admin.products.update', $product), ['name' => 'Update'])->assertForbidden();
        $this->actingAs($this->user)->delete(route('admin.products.destroy', $product))->assertForbidden();
    }
}
