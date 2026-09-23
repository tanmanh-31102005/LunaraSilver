<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::create(['name' => 'Test', 'slug' => 'test']);
    }

    public function test_single_uses_its_own_stock(): void
    {
        $single = $this->product('DC', 'single', 8);

        $this->assertSame(8, $single->availableQuantity());
        $this->assertTrue($single->isInStock());
        $this->assertSame('in_stock', $single->stock_status);
    }

    public function test_single_with_zero_stock_is_unavailable(): void
    {
        $single = $this->product('DC', 'single', 0);

        $this->assertSame(0, $single->availableQuantity());
        $this->assertFalse($single->isInStock());
        $this->assertSame('out_of_stock', $single->stock_status);
    }

    public function test_collection_is_limited_by_lowest_component_stock(): void
    {
        $bundle = $this->product('SET', 'collection');
        $this->addComponent($bundle, $this->product('DC', 'single', 8));
        $this->addComponent($bundle, $this->product('NH', 'single', 5));
        $this->addComponent($bundle, $this->product('VT', 'single', 12));

        $this->assertSame(5, $bundle->availableQuantity());
    }

    public function test_component_quantity_greater_than_one_uses_integer_division(): void
    {
        $bundle = $this->product('GIFT', 'gift');
        $this->addComponent($bundle, $this->product('NH', 'single', 7), 2);
        $this->addComponent($bundle, $this->product('VT', 'single', 10));

        $this->assertSame(3, $bundle->availableQuantity());
    }

    public function test_one_unavailable_component_makes_bundle_unavailable(): void
    {
        $bundle = $this->product('SET', 'collection');
        $this->addComponent($bundle, $this->product('DC', 'single', 10));
        $this->addComponent($bundle, $this->product('NH', 'single', 0));
        $this->addComponent($bundle, $this->product('VT', 'single', 10));

        $this->assertSame(0, $bundle->availableQuantity());
        $this->assertFalse($bundle->isInStock());
    }

    public function test_empty_bundle_cannot_be_sold(): void
    {
        $bundle = $this->product('SET', 'collection');

        $this->assertSame(0, $bundle->availableQuantity());
        $this->assertFalse($bundle->isInStock());
    }

    public function test_collection_with_zero_own_stock_can_be_available(): void
    {
        $bundle = $this->product('SET', 'collection', 0);
        $this->addComponent($bundle, $this->product('DC', 'single', 5));
        $this->addComponent($bundle, $this->product('NH', 'single', 5));
        $this->addComponent($bundle, $this->product('VT', 'single', 5));

        $this->assertSame(0, $bundle->stock_quantity);
        $this->assertSame(5, $bundle->availableQuantity());
        $this->assertTrue($bundle->isInStock());
    }

    public function test_gift_uses_component_stock_and_reflects_changes(): void
    {
        $bundle = $this->product('GIFT', 'gift', 0);
        $ring = $this->product('NH', 'single', 7);
        $this->addComponent($bundle, $ring, 2);

        $this->assertSame(3, $bundle->availableQuantity());
        $this->assertTrue($bundle->isInStock());

        $ring->update(['stock_quantity' => 1]);
        $this->assertSame(0, $bundle->availableQuantity());
        $this->assertFalse($bundle->isInStock());

        $ring->update(['stock_quantity' => 0]);
        $this->assertSame('out_of_stock', $ring->stock_status);
    }

    public function test_eager_loaded_bundle_items_can_be_used_for_a_list(): void
    {
        $bundle = $this->product('SET', 'collection');
        $this->addComponent($bundle, $this->product('DC', 'single', 4));

        $loaded = Product::query()->with('bundleItems.component')->findOrFail($bundle->id);

        $this->assertTrue($loaded->relationLoaded('bundleItems'));
        $this->assertTrue($loaded->bundleItems->first()->relationLoaded('component'));
        $this->assertSame(4, $loaded->availableQuantity());
    }

    private function product(string $sku, string $type, int $stock = 0): Product
    {
        return $this->category->products()->create([
            'sku' => $sku,
            'name' => $sku,
            'slug' => strtolower($sku),
            'product_type' => $type,
            'regular_price' => '100.00',
            'stock_quantity' => $stock,
        ]);
    }

    private function addComponent(Product $bundle, Product $component, int $quantity = 1): void
    {
        $bundle->bundleItems()->create([
            'component_product_id' => $component->id,
            'quantity' => $quantity,
        ]);
    }
}
