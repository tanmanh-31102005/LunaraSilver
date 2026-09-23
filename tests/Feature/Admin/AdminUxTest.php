<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUxTest extends TestCase
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

    public function test_quick_status_toggle_inverts_product_active_state(): void
    {
        $product = Product::where('is_active', true)->firstOrFail();

        $response = $this->actingAs($this->admin)->patch(route('admin.products.toggle-status', $product));

        $response->assertRedirect();
        $product->refresh();
        $this->assertFalse($product->is_active);

        // Toggle back to active
        $this->actingAs($this->admin)->patch(route('admin.products.toggle-status', $product));
        $product->refresh();
        $this->assertTrue($product->is_active);
    }

    public function test_quick_status_toggle_supports_json_response(): void
    {
        $product = Product::firstOrFail();
        $initialState = $product->is_active;

        $response = $this->actingAs($this->admin)->patchJson(route('admin.products.toggle-status', $product));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'is_active' => ! $initialState,
            ]);
    }

    public function test_quick_stock_updates_quantity_and_syncs_status_for_single_product(): void
    {
        $single = Product::where('product_type', 'single')->firstOrFail();

        $response = $this->actingAs($this->admin)->patch(route('admin.products.quick-stock', $single), [
            'stock_quantity' => 0,
        ]);

        $response->assertRedirect();
        $single->refresh();
        $this->assertEquals(0, $single->stock_quantity);
        $this->assertEquals('out_of_stock', $single->stock_status);

        // Update back to positive quantity
        $this->actingAs($this->admin)->patch(route('admin.products.quick-stock', $single), [
            'stock_quantity' => 25,
        ]);

        $single->refresh();
        $this->assertEquals(25, $single->stock_quantity);
        $this->assertEquals('in_stock', $single->stock_status);
    }

    public function test_quick_stock_is_rejected_for_bundle_product(): void
    {
        $bundle = Product::where('product_type', 'collection')->firstOrFail();

        $response = $this->actingAs($this->admin)->patchJson(route('admin.products.quick-stock', $bundle), [
            'stock_quantity' => 10,
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_duplicate_single_product_creates_inactive_copy_with_new_sku(): void
    {
        $product = Product::where('product_type', 'single')->firstOrFail();

        $response = $this->actingAs($this->admin)->post(route('admin.products.duplicate', $product));

        $copy = Product::where('sku', 'like', $product->sku.'-COPY-%')->first();
        $this->assertNotNull($copy);
        $this->assertFalse($copy->is_active);
        $this->assertStringContainsString('(Bản sao)', $copy->name);
        $this->assertNotEquals($product->id, $copy->id);

        $response->assertRedirect(route('admin.products.edit', $copy));
    }

    public function test_duplicate_bundle_product_copies_all_components(): void
    {
        $bundle = Product::where('product_type', 'collection')->with('bundleItems')->firstOrFail();
        $itemCount = $bundle->bundleItems->count();
        $this->assertGreaterThan(0, $itemCount);

        $response = $this->actingAs($this->admin)->post(route('admin.products.duplicate', $bundle));

        $copy = Product::where('sku', 'like', $bundle->sku.'-COPY-%')->with('bundleItems')->first();
        $this->assertNotNull($copy);
        $this->assertEquals($itemCount, $copy->bundleItems->count());
        $this->assertFalse($copy->is_active);

        $response->assertRedirect(route('admin.products.edit', $copy));
    }

    public function test_bulk_action_can_deactivate_and_activate_multiple_products(): void
    {
        $products = Product::where('is_active', true)->take(3)->get();
        $ids = $products->pluck('id')->toArray();

        // Bulk deactivate
        $response = $this->actingAs($this->admin)->post(route('admin.products.bulk-action'), [
            'action' => 'deactivate',
            'product_ids' => $ids,
        ]);

        $response->assertRedirect();
        foreach ($ids as $id) {
            $this->assertDatabaseHas('products', ['id' => $id, 'is_active' => false]);
        }

        // Bulk activate
        $response2 = $this->actingAs($this->admin)->post(route('admin.products.bulk-action'), [
            'action' => 'activate',
            'product_ids' => $ids,
        ]);

        $response2->assertRedirect();
        foreach ($ids as $id) {
            $this->assertDatabaseHas('products', ['id' => $id, 'is_active' => true]);
        }
    }

    public function test_product_sorting_handles_various_sort_keys(): void
    {
        $responseUpdated = $this->actingAs($this->admin)->get(route('admin.products.index', ['sort' => 'updated']));
        $responseUpdated->assertOk();

        $responseName = $this->actingAs($this->admin)->get(route('admin.products.index', ['sort' => 'name']));
        $responseName->assertOk();

        $responseSku = $this->actingAs($this->admin)->get(route('admin.products.index', ['sort' => 'sku']));
        $responseSku->assertOk();

        $responsePriceAsc = $this->actingAs($this->admin)->get(route('admin.products.index', ['sort' => 'price_asc']));
        $responsePriceAsc->assertOk();

        $responsePriceDesc = $this->actingAs($this->admin)->get(route('admin.products.index', ['sort' => 'price_desc']));
        $responsePriceDesc->assertOk();
    }

    public function test_dashboard_displays_low_stock_singles_and_attention_required_lists(): void
    {
        $single = Product::where('product_type', 'single')->firstOrFail();
        $single->update(['stock_quantity' => 2, 'stock_status' => 'in_stock']);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewHas('metrics', function (array $m): bool {
            return $m['low_stock_singles'] >= 1 && $m['low_stock_threshold'] === 5;
        });

        $lowStockProducts = $response->viewData('lowStockProducts');
        $this->assertTrue($lowStockProducts->contains('id', $single->id));
    }
}
