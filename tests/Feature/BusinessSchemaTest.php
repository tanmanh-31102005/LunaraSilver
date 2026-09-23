<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class BusinessSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_images_and_bundle_relationships(): void
    {
        $parent = Category::create(['name' => 'Parent', 'slug' => 'parent']);
        $category = Category::create(['parent_id' => $parent->id, 'name' => 'Child', 'slug' => 'child']);
        $component = $this->product($category, 'TEST-1', 'single');
        $bundle = $this->product($category, 'TEST-2', 'collection');

        $component->images()->create(['image_url' => '/test.jpg', 'image_role' => 'primary']);
        $bundle->bundleItems()->create(['component_product_id' => $component->id, 'quantity' => 2]);

        $this->assertTrue($category->parent->is($parent));
        $this->assertTrue($parent->children->first()->is($category));
        $this->assertCount(2, $category->products);
        $this->assertTrue($component->images->first()->product->is($component));
        $this->assertTrue($bundle->bundleItems->first()->component->is($component));
        $this->assertTrue($bundle->bundleComponents->first()->is($component));
        $this->assertSame(2, $bundle->bundleComponents->first()->pivot->quantity);

        $this->expectException(InvalidArgumentException::class);
        $bundle->bundleComponents()->attach($bundle->id);
    }

    public function test_order_items_keep_snapshot_after_product_is_deleted(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test', 'slug' => 'test']);
        $product = $this->product($category, 'TEST-3', 'single');

        $order = $user->orders()->create([
            'order_code' => 'TEST-ORDER-1',
            'customer_name' => 'Test Customer',
            'customer_email' => 'customer@example.com',
            'customer_phone' => '0000000000',
            'shipping_address' => 'Test address',
            'shipping_city' => 'Test city',
            'shipping_method' => 'standard',
            'subtotal' => '100.00',
            'grand_total' => '100.00',
            'payment_method' => 'cod',
        ]);
        $item = $order->items()->create([
            'product_id' => $product->id,
            'product_name' => 'Historical name',
            'product_sku' => $product->sku,
            'unit_price' => '100.00',
            'quantity' => 1,
            'subtotal' => '100.00',
        ]);
        $order->payment()->create([
            'provider' => 'cod',
            'amount' => '100.00',
            'request_data' => ['source' => 'test'],
        ]);

        $this->assertTrue($user->orders->first()->is($order));
        $this->assertTrue($order->items->first()->is($item));
        $this->assertSame('100.00', $order->payment->amount);
        $this->assertSame(['source' => 'test'], $order->payment->request_data);

        $product->delete();
        $this->assertTrue($item->product->is($product));

        $product->forceDelete();
        $this->assertNull($item->fresh()->product_id);
        $this->assertSame('Historical name', OrderItem::findOrFail($item->id)->product_name);
        $this->assertSame('100.00', OrderItem::findOrFail($item->id)->unit_price);

        $user->delete();
        $this->assertNull($order->fresh()->user_id);
        $this->assertSame('Test Customer', $order->fresh()->customer_name);
    }

    private function product(Category $category, string $sku, string $type): Product
    {
        return $category->products()->create([
            'sku' => $sku,
            'name' => $sku,
            'slug' => strtolower($sku),
            'product_type' => $type,
            'regular_price' => '100.00',
        ]);
    }
}
