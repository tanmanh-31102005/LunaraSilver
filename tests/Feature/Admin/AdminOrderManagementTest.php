<?php

namespace Tests\Feature\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemComponent;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $this->customer = User::factory()->create([
            'role' => User::ROLE_USER,
        ]);
    }

    /**
     * Helper to create a test order with payment and items.
     */
    protected function createOrder(array $attributes = [], array $itemData = []): Order
    {
        $order = Order::create(array_merge([
            'order_code' => 'LNS-TEST-'.uniqid(),
            'user_id' => $this->customer->id,
            'customer_name' => 'Nguyen Van Test',
            'customer_email' => $this->customer->email,
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Le Loi, Quan 1, TP HCM',
            'shipping_city' => 'TP Hồ Chí Minh',
            'shipping_method' => 'standard',
            'shipping_fee' => 0,
            'subtotal' => 500000,
            'discount_total' => 0,
            'grand_total' => 500000,
            'payment_method' => 'cod',
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'placed_at' => now(),
        ], $attributes));

        Payment::create([
            'order_id' => $order->id,
            'provider' => 'cod',
            'status' => $order->payment_status,
            'amount' => $order->grand_total,
            'currency' => 'VND',
        ]);

        if (empty($itemData)) {
            $product = Product::where('product_type', 'single')->firstOrFail();
            $item = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'unit_price' => 500000,
                'quantity' => 1,
                'subtotal' => 500000,
            ]);

            OrderItemComponent::create([
                'order_item_id' => $item->id,
                'product_id' => $product->id,
                'product_sku' => $product->sku,
                'product_name' => $product->name,
                'quantity_per_item' => 1,
                'total_quantity' => 1,
            ]);
        }

        return $order;
    }

    // =========================================================================
    // 1. ACCESS CONTROL TESTS
    // =========================================================================

    public function test_guest_cannot_access_admin_orders_and_is_redirected(): void
    {
        $order = $this->createOrder();

        $this->get(route('admin.orders.index'))->assertRedirect(route('login'));
        $this->get(route('admin.orders.show', $order->order_code))->assertRedirect(route('login'));
        $this->patch(route('admin.orders.status', $order->order_code), ['order_status' => 'confirmed'])->assertRedirect(route('login'));
        $this->post(route('admin.orders.cancel', $order->order_code))->assertRedirect(route('login'));
    }

    public function test_normal_user_cannot_access_admin_orders_and_receives_403(): void
    {
        $order = $this->createOrder();

        $this->actingAs($this->customer)->get(route('admin.orders.index'))->assertForbidden();
        $this->actingAs($this->customer)->get(route('admin.orders.show', $order->order_code))->assertForbidden();
        $this->actingAs($this->customer)->patch(route('admin.orders.status', $order->order_code), ['order_status' => 'confirmed'])->assertForbidden();
        $this->actingAs($this->customer)->post(route('admin.orders.cancel', $order->order_code))->assertForbidden();
    }

    public function test_admin_can_access_orders_index_and_detail(): void
    {
        $order = $this->createOrder();

        $responseIndex = $this->actingAs($this->admin)->get(route('admin.orders.index'));
        $responseIndex->assertOk();
        $responseIndex->assertSee('Quản lý đơn hàng');
        $responseIndex->assertSee($order->order_code);

        $responseShow = $this->actingAs($this->admin)->get(route('admin.orders.show', $order->order_code));
        $responseShow->assertOk();
        $responseShow->assertSee($order->order_code);
        $responseShow->assertSee($order->customer_name);
    }

    // =========================================================================
    // 2. LISTING, SEARCH & FILTER TESTS
    // =========================================================================

    public function test_search_by_order_code_and_customer_name(): void
    {
        $order1 = $this->createOrder([
            'order_code' => 'LNS-SEARCH-001',
            'customer_name' => 'Nguyen Thao',
            'customer_email' => 'thao@example.com',
        ]);
        $order2 = $this->createOrder([
            'order_code' => 'LNS-SEARCH-002',
            'customer_name' => 'Tran Binh',
            'customer_email' => 'binh@example.com',
        ]);

        // Search code
        $resCode = $this->actingAs($this->admin)->get(route('admin.orders.index', ['search' => 'SEARCH-001']));
        $resCode->assertOk();
        $resCode->assertSee($order1->order_code);
        $resCode->assertDontSee($order2->order_code);

        // Search name
        $resName = $this->actingAs($this->admin)->get(route('admin.orders.index', ['search' => 'Tran Binh']));
        $resName->assertOk();
        $resName->assertSee($order2->order_code);
        $resName->assertDontSee($order1->order_code);
    }

    public function test_filter_by_order_status_and_payment_status(): void
    {
        $pendingOrder = $this->createOrder([
            'order_code' => 'LNS-STATUS-PENDING',
            'order_status' => 'pending',
            'payment_status' => 'pending',
        ]);
        $completedOrder = $this->createOrder([
            'order_code' => 'LNS-STATUS-COMPLETED',
            'order_status' => 'completed',
            'payment_status' => 'paid',
        ]);

        $resStatus = $this->actingAs($this->admin)->get(route('admin.orders.index', ['order_status' => 'pending']));
        $resStatus->assertOk();
        $resStatus->assertSee($pendingOrder->order_code);
        $resStatus->assertDontSee($completedOrder->order_code);

        $resPayment = $this->actingAs($this->admin)->get(route('admin.orders.index', ['payment_status' => 'paid']));
        $resPayment->assertOk();
        $resPayment->assertSee($completedOrder->order_code);
        $resPayment->assertDontSee($pendingOrder->order_code);
    }

    public function test_filter_by_date_range(): void
    {
        $oldOrder = $this->createOrder([
            'order_code' => 'LNS-DATE-OLD',
            'placed_at' => now()->subDays(10),
        ]);
        $recentOrder = $this->createOrder([
            'order_code' => 'LNS-DATE-RECENT',
            'placed_at' => now(),
        ]);

        $res = $this->actingAs($this->admin)->get(route('admin.orders.index', [
            'from' => now()->subDays(2)->format('Y-m-d'),
            'to' => now()->addDay()->format('Y-m-d'),
        ]));

        $res->assertOk();
        $res->assertSee($recentOrder->order_code);
        $res->assertDontSee($oldOrder->order_code);
    }

    // =========================================================================
    // 3. VALID TRANSITIONS & COD PAYMENT SYNC
    // =========================================================================

    public function test_valid_forward_transitions_flow(): void
    {
        $order = $this->createOrder(['order_status' => 'pending']);

        // pending -> confirmed
        $this->actingAs($this->admin)
            ->patch(route('admin.orders.status', $order->order_code), [
                'order_status' => 'confirmed',
                'note' => 'Xác nhận qua điện thoại',
            ])
            ->assertRedirect(route('admin.orders.show', $order->order_code));

        $order->refresh();
        $this->assertEquals('confirmed', $order->order_status);

        // confirmed -> processing
        $this->actingAs($this->admin)
            ->patch(route('admin.orders.status', $order->order_code), [
                'order_status' => 'processing',
            ]);
        $order->refresh();
        $this->assertEquals('processing', $order->order_status);

        // processing -> shipping
        $this->actingAs($this->admin)
            ->patch(route('admin.orders.status', $order->order_code), [
                'order_status' => 'shipping',
            ]);
        $order->refresh();
        $this->assertEquals('shipping', $order->order_status);

        // shipping -> completed (triggers COD paid sync)
        $this->actingAs($this->admin)
            ->patch(route('admin.orders.status', $order->order_code), [
                'order_status' => 'completed',
            ]);
        $order->refresh();
        $this->assertEquals('completed', $order->order_status);
        $this->assertEquals('paid', $order->payment_status);

        $payment = $order->payment;
        $this->assertEquals('paid', $payment->status);
        $this->assertNotNull($payment->paid_at);
    }

    // =========================================================================
    // 4. INVALID TRANSITIONS REJECTION
    // =========================================================================

    public function test_invalid_transitions_are_rejected(): void
    {
        $order = $this->createOrder(['order_status' => 'completed', 'payment_status' => 'paid']);

        // completed -> pending
        $this->actingAs($this->admin)
            ->patch(route('admin.orders.status', $order->order_code), [
                'order_status' => 'pending',
            ])
            ->assertSessionHasErrors('order_status');

        $order->refresh();
        $this->assertEquals('completed', $order->order_status);

        // completed -> cancelled
        $this->actingAs($this->admin)
            ->post(route('admin.orders.cancel', $order->order_code))
            ->assertSessionHasErrors('order_status');

        $order->refresh();
        $this->assertEquals('completed', $order->order_status);

        // shipping -> confirmed
        $shippingOrder = $this->createOrder(['order_status' => 'shipping']);
        $this->actingAs($this->admin)
            ->patch(route('admin.orders.status', $shippingOrder->order_code), [
                'order_status' => 'confirmed',
            ])
            ->assertSessionHasErrors('order_status');

        // shipping -> cancelled
        $this->actingAs($this->admin)
            ->post(route('admin.orders.cancel', $shippingOrder->order_code))
            ->assertSessionHasErrors('order_status');

        // processing -> pending
        $processingOrder = $this->createOrder(['order_status' => 'processing']);
        $this->actingAs($this->admin)
            ->patch(route('admin.orders.status', $processingOrder->order_code), [
                'order_status' => 'pending',
            ])
            ->assertSessionHasErrors('order_status');
    }

    // =========================================================================
    // 5. CANCELLATION & SAFE INVENTORY RESTORE
    // =========================================================================

    public function test_pending_confirmed_processing_can_be_cancelled(): void
    {
        // 1. Pending can cancel
        $order1 = $this->createOrder(['order_status' => 'pending']);
        $this->actingAs($this->admin)->post(route('admin.orders.cancel', $order1->order_code))->assertRedirect();
        $order1->refresh();
        $this->assertEquals('cancelled', $order1->order_status);
        $this->assertEquals('cancelled', $order1->payment_status);

        // 2. Confirmed can cancel
        $order2 = $this->createOrder(['order_status' => 'confirmed']);
        $this->actingAs($this->admin)->post(route('admin.orders.cancel', $order2->order_code))->assertRedirect();
        $order2->refresh();
        $this->assertEquals('cancelled', $order2->order_status);

        // 3. Processing can cancel
        $order3 = $this->createOrder(['order_status' => 'processing']);
        $this->actingAs($this->admin)->post(route('admin.orders.cancel', $order3->order_code))->assertRedirect();
        $order3->refresh();
        $this->assertEquals('cancelled', $order3->order_status);
    }

    public function test_cancel_restores_single_product_inventory_and_updates_stock_status(): void
    {
        $single = Product::where('product_type', 'single')->firstOrFail();
        $single->update([
            'stock_quantity' => 0,
            'stock_status' => 'out_of_stock',
        ]);

        $order = Order::create([
            'order_code' => 'LNS-RESTORE-SINGLE',
            'user_id' => $this->customer->id,
            'customer_name' => 'Single Restorer',
            'customer_email' => 'restore@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 ABC',
            'shipping_city' => 'TP HCM',
            'shipping_method' => 'standard',
            'shipping_fee' => 0,
            'subtotal' => 200000,
            'discount_total' => 0,
            'grand_total' => 200000,
            'payment_method' => 'cod',
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'placed_at' => now(),
        ]);

        $item = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $single->id,
            'product_name' => $single->name,
            'product_sku' => $single->sku,
            'unit_price' => 100000,
            'quantity' => 2,
            'subtotal' => 200000,
        ]);

        OrderItemComponent::create([
            'order_item_id' => $item->id,
            'product_id' => $single->id,
            'product_sku' => $single->sku,
            'product_name' => $single->name,
            'quantity_per_item' => 1,
            'total_quantity' => 2,
        ]);

        $this->actingAs($this->admin)->post(route('admin.orders.cancel', $order->order_code))->assertRedirect();

        $single->refresh();
        $order->refresh();

        $this->assertEquals('cancelled', $order->order_status);
        $this->assertNotNull($order->inventory_restored_at);
        $this->assertEquals(2, $single->stock_quantity);
        $this->assertEquals('in_stock', $single->stock_status);
    }

    public function test_cancel_restores_bundle_components_from_snapshot_without_altering_bundle_stock(): void
    {
        $comp1 = Product::where('product_type', 'single')->firstOrFail();
        $comp2 = Product::where('product_type', 'single')->where('id', '!=', $comp1->id)->firstOrFail();
        $bundle = Product::where('product_type', 'collection')->firstOrFail();

        $initialComp1Stock = 10;
        $initialComp2Stock = 15;
        $initialBundleStock = 0; // Virtual stock remains 0

        $comp1->update(['stock_quantity' => $initialComp1Stock]);
        $comp2->update(['stock_quantity' => $initialComp2Stock]);
        $bundle->update(['stock_quantity' => $initialBundleStock]);

        $order = Order::create([
            'order_code' => 'LNS-BUNDLE-CANCEL-TEST',
            'user_id' => $this->customer->id,
            'customer_name' => 'Bundle Restorer',
            'customer_email' => 'bundle@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '456 XYZ',
            'shipping_city' => 'TP HCM',
            'shipping_method' => 'standard',
            'shipping_fee' => 0,
            'subtotal' => 1000000,
            'discount_total' => 0,
            'grand_total' => 1000000,
            'payment_method' => 'cod',
            'order_status' => 'processing',
            'payment_status' => 'pending',
            'placed_at' => now(),
        ]);

        // Order contains 2x bundle
        $item = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $bundle->id,
            'product_name' => $bundle->name,
            'product_sku' => $bundle->sku,
            'unit_price' => 500000,
            'quantity' => 2,
            'subtotal' => 1000000,
        ]);

        // Snapshot at checkout: 1x bundle contains 1x comp1, 2x comp2.
        // For 2x bundle: comp1 total = 2, comp2 total = 4
        OrderItemComponent::create([
            'order_item_id' => $item->id,
            'product_id' => $comp1->id,
            'product_sku' => $comp1->sku,
            'product_name' => $comp1->name,
            'quantity_per_item' => 1,
            'total_quantity' => 2,
        ]);

        OrderItemComponent::create([
            'order_item_id' => $item->id,
            'product_id' => $comp2->id,
            'product_sku' => $comp2->sku,
            'product_name' => $comp2->name,
            'quantity_per_item' => 2,
            'total_quantity' => 4,
        ]);

        $this->actingAs($this->admin)->post(route('admin.orders.cancel', $order->order_code))->assertRedirect();

        $comp1->refresh();
        $comp2->refresh();
        $bundle->refresh();
        $order->refresh();

        $this->assertEquals('cancelled', $order->order_status);
        $this->assertEquals($initialComp1Stock + 2, $comp1->stock_quantity);
        $this->assertEquals($initialComp2Stock + 4, $comp2->stock_quantity);
        $this->assertEquals($initialBundleStock, $bundle->stock_quantity); // Virtual stock unchanged!
    }

    public function test_double_restore_prevention(): void
    {
        $single = Product::where('product_type', 'single')->firstOrFail();
        $single->update(['stock_quantity' => 10]);

        $order = $this->createOrder();
        $firstItem = $order->items()->first();
        $firstItem->components()->delete();
        $firstItem->components()->create([
            'product_id' => $single->id,
            'product_sku' => $single->sku,
            'product_name' => $single->name,
            'quantity_per_item' => 1,
            'total_quantity' => 3,
        ]);

        // First cancel
        $this->actingAs($this->admin)->post(route('admin.orders.cancel', $order->order_code));
        $single->refresh();
        $this->assertEquals(13, $single->stock_quantity);

        // Attempt second cancel on already cancelled order
        $this->actingAs($this->admin)->post(route('admin.orders.cancel', $order->order_code));
        $single->refresh();
        $this->assertEquals(13, $single->stock_quantity); // Does not increment again!
    }

    public function test_changing_bundle_composition_after_checkout_does_not_affect_restore_snapshot(): void
    {
        $comp1 = Product::where('product_type', 'single')->firstOrFail();
        $comp2 = Product::where('product_type', 'single')->where('id', '!=', $comp1->id)->firstOrFail();
        $bundle = Product::where('product_type', 'collection')->firstOrFail();

        $comp1->update(['stock_quantity' => 20]);
        $comp2->update(['stock_quantity' => 20]);

        $order = Order::create([
            'order_code' => 'LNS-SNAPSHOT-INTEGRITY',
            'user_id' => $this->customer->id,
            'customer_name' => 'Snapshot Test',
            'customer_email' => 'snap@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '789 ABC',
            'shipping_city' => 'TP HCM',
            'shipping_method' => 'standard',
            'shipping_fee' => 0,
            'subtotal' => 500000,
            'discount_total' => 0,
            'grand_total' => 500000,
            'payment_method' => 'cod',
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'placed_at' => now(),
        ]);

        $item = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $bundle->id,
            'product_name' => $bundle->name,
            'product_sku' => $bundle->sku,
            'unit_price' => 500000,
            'quantity' => 1,
            'subtotal' => 500000,
        ]);

        // Snapshot recorded at checkout: comp1 x5
        OrderItemComponent::create([
            'order_item_id' => $item->id,
            'product_id' => $comp1->id,
            'product_sku' => $comp1->sku,
            'product_name' => $comp1->name,
            'quantity_per_item' => 5,
            'total_quantity' => 5,
        ]);

        // Now simulate admin editing the bundle composition in catalog to use comp2 instead
        $bundle->bundleItems()->delete();
        $bundle->bundleItems()->create([
            'component_product_id' => $comp2->id,
            'quantity' => 10,
        ]);

        // Cancel order: must restore according to checkout snapshot (comp1 +5), not current catalog (comp2)
        $this->actingAs($this->admin)->post(route('admin.orders.cancel', $order->order_code));

        $comp1->refresh();
        $comp2->refresh();

        $this->assertEquals(25, $comp1->stock_quantity);
        $this->assertEquals(20, $comp2->stock_quantity); // comp2 was untouched!
    }

    // =========================================================================
    // 6. STATUS HISTORY & AUDIT LOGGING
    // =========================================================================

    public function test_audit_history_records_are_properly_created(): void
    {
        $order = $this->createOrder(['order_status' => 'pending']);

        // Update to confirmed with note
        $this->actingAs($this->admin)->patch(route('admin.orders.status', $order->order_code), [
            'order_status' => 'confirmed',
            'note' => 'Khách xác nhận lấy hộp quà kèm theo.',
        ]);

        $this->assertDatabaseHas('order_status_histories', [
            'order_id' => $order->id,
            'from_status' => 'pending',
            'to_status' => 'confirmed',
            'changed_by' => $this->admin->id,
            'note' => 'Khách xác nhận lấy hộp quà kèm theo.',
        ]);

        // Cancel with note
        $this->actingAs($this->admin)->post(route('admin.orders.cancel', $order->order_code), [
            'note' => 'Khách đổi ý muốn đặt mẫu khác.',
        ]);

        $this->assertDatabaseHas('order_status_histories', [
            'order_id' => $order->id,
            'from_status' => 'confirmed',
            'to_status' => 'cancelled',
            'changed_by' => $this->admin->id,
            'note' => 'Khách đổi ý muốn đặt mẫu khác.',
        ]);
    }

    // =========================================================================
    // 7. ADMIN LOGIN REDIRECT
    // =========================================================================

    public function test_admin_user_is_redirected_to_admin_dashboard_upon_login(): void
    {
        $response = $this->post('/login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_normal_user_is_redirected_to_storefront_upon_login(): void
    {
        $response = $this->post('/login', [
            'email' => $this->customer->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
    }
}
