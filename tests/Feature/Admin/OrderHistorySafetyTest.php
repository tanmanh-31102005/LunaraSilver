<?php

namespace Tests\Feature\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderHistorySafetyTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->role = User::ROLE_ADMIN;
        $this->admin->save();

        $this->customer = User::factory()->create();
    }

    public function test_product_soft_delete_does_not_break_historical_order_detail(): void
    {
        $product = Product::firstOrFail();

        $order = Order::create([
            'order_code' => 'ORD-SAFETY-TEST-001',
            'user_id' => $this->customer->id,
            'customer_name' => 'Nguyen Van Test',
            'customer_email' => $this->customer->email,
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Le Loi, Quan 1, TP HCM',
            'shipping_city' => 'TP Hồ Chí Minh',
            'shipping_method' => 'standard',
            'subtotal' => $product->regular_price,
            'grand_total' => $product->regular_price,
            'payment_method' => 'cod',
            'order_status' => 'completed',
            'payment_status' => 'paid',
            'placed_at' => now(),
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'unit_price' => $product->regular_price,
            'quantity' => 1,
            'subtotal' => $product->regular_price,
        ]);

        // Verify initial render
        $this->actingAs($this->customer)->get(route('account.orders.show', $order->order_code))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($product->sku);

        // Admin soft-deletes the product
        $this->actingAs($this->admin)->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertSoftDeleted('products', ['id' => $product->id]);

        // Customer views order detail again - should still render snapshot details safely
        $response = $this->actingAs($this->customer)->get(route('account.orders.show', $order->order_code));
        $response->assertOk();
        $response->assertSee($orderItem->product_name);
        $response->assertSee($orderItem->product_sku);
        $response->assertSee(number_format($orderItem->unit_price, 0, ',', '.'));
    }

    public function test_product_deactivation_does_not_break_order_history(): void
    {
        $product = Product::firstOrFail();

        $order = Order::create([
            'order_code' => 'ORD-INACTIVE-TEST-002',
            'user_id' => $this->customer->id,
            'customer_name' => 'Tran Thi Test',
            'customer_email' => $this->customer->email,
            'customer_phone' => '0987654321',
            'shipping_address' => '456 Hai Ba Trung, Ha Noi',
            'shipping_city' => 'Hà Nội',
            'shipping_method' => 'standard',
            'subtotal' => $product->regular_price,
            'grand_total' => $product->regular_price,
            'payment_method' => 'cod',
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'placed_at' => now(),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'unit_price' => $product->regular_price,
            'quantity' => 2,
            'subtotal' => $product->regular_price * 2,
        ]);

        // Admin deactivates product
        $product->update(['is_active' => false]);

        $response = $this->actingAs($this->customer)->get(route('account.orders.show', $order->order_code));
        $response->assertOk();
        $response->assertSee($product->name);
        $response->assertSee($product->sku);
    }
}
