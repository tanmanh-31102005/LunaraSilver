<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BundleCompositionTest extends TestCase
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

    public function test_admin_can_create_collection_with_components(): void
    {
        $category = Category::firstOrFail();
        $singles = Product::where('product_type', 'single')->take(2)->get();

        $payload = [
            'name' => 'Bộ Sưu Tập Trăng Sao Mới',
            'sku' => 'COL-MOON-NEW',
            'slug' => 'bo-suu-tap-trang-sao-moi',
            'category_id' => $category->id,
            'product_type' => 'collection',
            'regular_price' => 1500000,
            'is_active' => '1',
            'bundle_items' => [
                ['product_id' => $singles[0]->id, 'quantity' => 1],
                ['product_id' => $singles[1]->id, 'quantity' => 2],
            ],
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), $payload);

        $response->assertRedirect(route('admin.products.index'));

        $bundle = Product::where('sku', 'COL-MOON-NEW')->firstOrFail();
        $this->assertEquals('collection', $bundle->product_type);
        $this->assertCount(2, $bundle->bundleItems);
        $this->assertEquals($singles[0]->id, $bundle->bundleItems[0]->component_product_id);
        $this->assertEquals(1, $bundle->bundleItems[0]->quantity);
        $this->assertEquals($singles[1]->id, $bundle->bundleItems[1]->component_product_id);
        $this->assertEquals(2, $bundle->bundleItems[1]->quantity);
    }

    public function test_admin_can_create_gift_with_components(): void
    {
        $category = Category::firstOrFail();
        $singles = Product::where('product_type', 'single')->take(2)->get();

        $payload = [
            'name' => 'Hộp Quà Trao Duyên Mới',
            'sku' => 'GIFT-TRAO-DUYEN-NEW',
            'slug' => 'hop-qua-trao-duyen-moi',
            'category_id' => $category->id,
            'product_type' => 'gift',
            'regular_price' => 1200000,
            'is_active' => '1',
            'bundle_items' => [
                ['product_id' => $singles[0]->id, 'quantity' => 1],
                ['product_id' => $singles[1]->id, 'quantity' => 1],
            ],
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), $payload);

        $response->assertRedirect(route('admin.products.index'));

        $gift = Product::where('sku', 'GIFT-TRAO-DUYEN-NEW')->firstOrFail();
        $this->assertEquals('gift', $gift->product_type);
        $this->assertCount(2, $gift->bundleItems);
    }

    public function test_bundle_rejects_nested_bundle_components(): void
    {
        $category = Category::firstOrFail();
        $existingCollection = Product::where('product_type', 'collection')->firstOrFail();
        $single = Product::where('product_type', 'single')->firstOrFail();

        $payload = [
            'name' => 'Bộ Sưu Tập Lồng Sai Luật',
            'sku' => 'COL-NESTED-INVALID',
            'slug' => 'bo-suu-tap-long-sai-luat',
            'category_id' => $category->id,
            'product_type' => 'collection',
            'regular_price' => 2000000,
            'bundle_items' => [
                ['product_id' => $single->id, 'quantity' => 1],
                ['product_id' => $existingCollection->id, 'quantity' => 1],
            ],
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), $payload);

        $response->assertSessionHasErrors(['bundle_items']);
    }

    public function test_bundle_rejects_duplicate_component_ids(): void
    {
        $category = Category::firstOrFail();
        $single = Product::where('product_type', 'single')->firstOrFail();

        $payload = [
            'name' => 'Bộ Sưu Tập Trùng Thành Phần',
            'sku' => 'COL-DUP-INVALID',
            'slug' => 'bo-suu-tap-trung-thanh-phan',
            'category_id' => $category->id,
            'product_type' => 'collection',
            'regular_price' => 2000000,
            'bundle_items' => [
                ['product_id' => $single->id, 'quantity' => 1],
                ['product_id' => $single->id, 'quantity' => 2],
            ],
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), $payload);

        $response->assertSessionHasErrors(['bundle_items.0.product_id', 'bundle_items.1.product_id']);
    }

    public function test_bundle_rejects_invalid_quantity(): void
    {
        $category = Category::firstOrFail();
        $single = Product::where('product_type', 'single')->firstOrFail();

        $payload = [
            'name' => 'Bộ Sưu Tập Số Lượng Sai',
            'sku' => 'COL-QTY-INVALID',
            'slug' => 'bo-suu-tap-so-luong-sai',
            'category_id' => $category->id,
            'product_type' => 'collection',
            'regular_price' => 2000000,
            'bundle_items' => [
                ['product_id' => $single->id, 'quantity' => 0],
            ],
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), $payload);

        $response->assertSessionHasErrors(['bundle_items.0.quantity']);
    }

    public function test_bundle_availability_is_calculated_dynamically_from_components(): void
    {
        $bundle = Product::where('product_type', 'collection')->with('bundleItems.component')->firstOrFail();
        $component1 = $bundle->bundleItems[0]->component;
        $component1->update(['stock_quantity' => 4]);

        $qty1 = $bundle->bundleItems[0]->quantity; // e.g. 1 -> 4/1 = 4

        // If there's a second component
        if ($bundle->bundleItems->count() > 1) {
            $component2 = $bundle->bundleItems[1]->component;
            $component2->update(['stock_quantity' => 6]);
            $qty2 = $bundle->bundleItems[1]->quantity;
            $expected = min(intdiv(4, $qty1), intdiv(6, $qty2));
        } else {
            $expected = intdiv(4, $qty1);
        }

        $bundle->refresh();
        $this->assertEquals($expected, $bundle->availableQuantity());
    }

    public function test_bundle_stored_stock_is_not_authoritative(): void
    {
        $bundle = Product::where('product_type', 'collection')->firstOrFail();
        $bundle->stock_quantity = 0;
        $bundle->saveQuietly();

        // Components still have stock
        foreach ($bundle->bundleItems as $item) {
            $item->component->update(['stock_quantity' => 10]);
        }

        $bundle->refresh();
        $this->assertGreaterThan(0, $bundle->availableQuantity());
    }

    public function test_update_bundle_syncs_components_correctly(): void
    {
        $bundle = Product::where('product_type', 'collection')->firstOrFail();
        $newSingles = Product::where('product_type', 'single')->take(3)->get();

        $payload = [
            'name' => $bundle->name,
            'sku' => $bundle->sku,
            'slug' => $bundle->slug,
            'category_id' => $bundle->category_id,
            'product_type' => 'collection',
            'regular_price' => $bundle->regular_price,
            'bundle_items' => [
                ['product_id' => $newSingles[0]->id, 'quantity' => 1],
                ['product_id' => $newSingles[1]->id, 'quantity' => 3],
                ['product_id' => $newSingles[2]->id, 'quantity' => 2],
            ],
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $bundle), $payload);

        $response->assertRedirect(route('admin.products.index'));

        $bundle->refresh();
        $this->assertCount(3, $bundle->bundleItems);
        $this->assertEquals($newSingles[0]->id, $bundle->bundleItems[0]->component_product_id);
        $this->assertEquals(1, $bundle->bundleItems[0]->quantity);
        $this->assertEquals($newSingles[1]->id, $bundle->bundleItems[1]->component_product_id);
        $this->assertEquals(3, $bundle->bundleItems[1]->quantity);
    }
}
