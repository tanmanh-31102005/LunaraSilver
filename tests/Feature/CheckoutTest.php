<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use App\Services\CheckoutService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private ?User $defaultUser = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defaultUser = null;
        $this->seed(DatabaseSeeder::class);
    }

    private function product(string $sku): Product
    {
        return Product::query()->where('sku', $sku)->firstOrFail();
    }

    private function add(Product $product, int $quantity = 1)
    {
        return $this->postJson('/cart/items', ['product_id' => $product->id, 'quantity' => $quantity]);
    }

    private function getCheckoutToken(?User $user = null): string
    {
        $this->defaultUser = $user ?? $this->defaultUser ?? User::factory()->create();
        $guestToken = session('lunara_cart_token');
        if ($guestToken) {
            app(CartService::class)->mergeGuestCart($this->defaultUser, $guestToken);
        }
        $this->actingAs($this->defaultUser)->get('/checkout')->assertOk();

        return (string) session('checkout_token');
    }

    private function validFormData(string $token, array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Nguyễn Văn A',
            'customer_email' => 'nguyenvana@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Lê Lợi, Phường Bến Nghé',
            'shipping_city' => 'Hồ Chí Minh',
            'shipping_note' => 'Giao giờ hành chính',
            'customer_note' => 'Đóng gói cẩn thận giúp tôi',
            'payment_method' => 'cod',
            'checkout_token' => $token,
        ], $overrides);
    }

    // ==========================================
    // 1. Guest Restrictions & Checkout Flow Tests
    // ==========================================

    public function test_guest_can_view_storefront_categories_and_products(): void
    {
        $this->get('/')->assertOk();
        $this->get('/products')->assertOk();
        $this->get('/products/day-chuyen')->assertOk();
        $product = $this->product('LNS-NH001');
        $this->get('/product/'.$product->slug)->assertOk();
        $this->get('/products?q=trang')->assertOk();
    }

    public function test_guest_can_add_update_remove_and_clear_cart(): void
    {
        $product = $this->product('LNS-NH001');

        $this->add($product, 2)->assertOk();
        $this->assertDatabaseCount('cart_items', 1);

        $cartItem = CartItem::query()->firstOrFail();

        $this->patchJson('/cart/items/'.$cartItem->id, ['quantity' => 3])->assertOk();
        $this->assertSame(3, $cartItem->fresh()->quantity);

        $this->deleteJson('/cart/items/'.$cartItem->id)->assertOk();
        $this->assertDatabaseCount('cart_items', 0);

        $this->add($product, 1)->assertOk();
        $this->assertDatabaseCount('cart_items', 1);
        $this->deleteJson('/cart')->assertOk();
        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_guest_get_checkout_redirects_to_login_with_intended_destination(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product, 1)->assertOk();

        $response = $this->get('/checkout');
        $response->assertRedirect(route('login'));

        $this->assertTrue(str_contains(session('url.intended', ''), '/checkout'));

        // Visiting login shows notice
        $loginResponse = $this->get(route('login'));
        $loginResponse->assertOk();
        $loginResponse->assertSee('Vui lòng đăng nhập hoặc đăng ký để tiếp tục thanh toán. Giỏ hàng của bạn vẫn được giữ nguyên.');

        // Normal login visit without intended checkout does not show notice
        $this->flushSession();
        $normalLogin = $this->get(route('login'));
        $normalLogin->assertOk();
        $normalLogin->assertDontSee('Vui lòng đăng nhập hoặc đăng ký để tiếp tục thanh toán. Giỏ hàng của bạn vẫn được giữ nguyên.');
    }

    public function test_guest_post_checkout_is_redirected_to_login_and_creates_no_order(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product, 1)->assertOk();

        $response = $this->post('/checkout', $this->validFormData('any-token'));
        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_guest_cart_persists_after_login_redirect(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product, 2)->assertOk();

        $this->get('/checkout')->assertRedirect(route('login'));

        $this->assertDatabaseCount('cart_items', 1);
        $this->assertSame(2, CartItem::query()->firstOrFail()->quantity);
    }

    public function test_guest_login_from_checkout_merges_cart_and_redirects_to_checkout(): void
    {
        $user = User::factory()->create([
            'email' => 'returning@example.com',
            'password' => 'password123',
        ]);
        $product = $this->product('LNS-NH001');
        $this->add($product, 2)->assertOk();

        $this->get('/checkout')->assertRedirect(route('login'));

        $response = $this->post('/login', [
            'email' => 'returning@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/checkout');

        $userCart = Cart::query()->where('user_id', $user->id)->firstOrFail();
        $this->assertSame(2, $userCart->items()->firstOrFail()->quantity);
    }

    public function test_guest_register_from_checkout_merges_cart_and_redirects_to_checkout(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product, 3)->assertOk();

        $this->get('/checkout')->assertRedirect(route('login'));

        $response = $this->post('/register', [
            'name' => 'New Customer',
            'email' => 'newcustomer@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertRedirect('/checkout');

        $newUser = User::query()->where('email', 'newcustomer@example.com')->firstOrFail();
        $this->assertSame(User::ROLE_USER, $newUser->role);

        $userCart = Cart::query()->where('user_id', $newUser->id)->firstOrFail();
        $this->assertSame(3, $userCart->items()->firstOrFail()->quantity);
    }

    public function test_public_registration_cannot_set_admin_role(): void
    {
        $this->post('/register', [
            'name' => 'Hacker',
            'email' => 'hacker@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $user = User::query()->where('email', 'hacker@example.com')->firstOrFail();
        $this->assertSame(User::ROLE_USER, $user->role);
    }

    public function test_authenticated_checkout_success(): void
    {
        $user = User::factory()->create(['name' => 'Trần Thị B', 'email' => 'tranthib@example.com']);
        $product = $this->product('LNS-NH001');

        $this->actingAs($user)->add($product, 1)->assertOk();
        $token = $this->getCheckoutToken($user);

        $response = $this->actingAs($user)->post('/checkout', $this->validFormData($token, [
            'customer_name' => 'Trần Thị B',
            'customer_email' => 'tranthib@example.com',
        ]));

        $order = Order::query()->where('user_id', $user->id)->firstOrFail();
        $response->assertRedirect('/order-success/'.$order->order_code);
        $this->assertSame($user->id, $order->user_id);
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_empty_cart_checkout_rejected(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/checkout')->assertRedirect('/cart');

        $response = $this->actingAs($user)->post('/checkout', $this->validFormData('dummy-token'));
        $response->assertSessionHasErrors('checkout_token');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_invalid_checkout_form_rejected(): void
    {
        $user = User::factory()->create();
        $product = $this->product('LNS-NH001');
        $this->actingAs($user)->add($product)->assertOk();
        $token = $this->getCheckoutToken($user);

        $response = $this->actingAs($user)->post('/checkout', [
            'checkout_token' => $token,
            'customer_name' => '',
            'customer_email' => 'invalid-email',
            'customer_phone' => 'abc',
            'shipping_address' => '',
            'shipping_city' => '',
            'payment_method' => 'vnpay', // Only COD is allowed in Phase 8
        ]);

        $response->assertSessionHasErrors(['customer_name', 'customer_email', 'customer_phone', 'shipping_address', 'shipping_city', 'payment_method']);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_current_catalog_prices_used_and_snapshot_correctly(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product, 1)->assertOk();

        // Update product price in catalog after adding to cart
        $product->update(['regular_price' => '850000.00', 'sale_price' => '750000.00']);

        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        $order = Order::query()->firstOrFail();
        $this->assertSame('750000.00', $order->subtotal);
        $this->assertSame('750000.00', $order->grand_total);
        $this->assertSame('750000.00', $order->items->first()->unit_price);
        $this->assertSame('750000.00', $order->items->first()->subtotal);
    }

    public function test_totals_calculation_is_exact(): void
    {
        $product1 = $this->product('LNS-NH001'); // e.g. 520000
        $product2 = $this->product('LNS-DC001'); // e.g. 680000
        $this->add($product1, 2)->assertOk();
        $this->add($product2, 1)->assertOk();

        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        $order = Order::query()->firstOrFail();
        $price1 = $product1->hasValidSalePrice() ? $product1->sale_price : $product1->regular_price;
        $price2 = $product2->hasValidSalePrice() ? $product2->sale_price : $product2->regular_price;

        $cents1 = (int) str_replace('.', '', $price1);
        $cents2 = (int) str_replace('.', '', $price2);
        $expectedSubtotalCents = ($cents1 * 2) + ($cents2 * 1);
        $expectedSubtotal = intdiv($expectedSubtotalCents, 100).'.'.str_pad((string) ($expectedSubtotalCents % 100), 2, '0', STR_PAD_LEFT);

        $this->assertSame($expectedSubtotal, $order->subtotal);
        $this->assertSame('0.00', $order->shipping_fee);
        $this->assertSame('0.00', $order->discount_amount);
        $this->assertSame($expectedSubtotal, $order->grand_total);
    }

    public function test_order_code_is_unique_and_readable(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product)->assertOk();
        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        $order = Order::query()->firstOrFail();
        $today = date('Ymd');
        $this->assertMatchesRegularExpression('/^LNS-'.$today.'-[A-Z0-9]{6}$/', $order->order_code);
    }

    public function test_order_items_snapshot_preserves_product_details(): void
    {
        $bundle = $this->product('LNS-SET001');
        $this->add($bundle, 2)->assertOk();

        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        $order = Order::query()->firstOrFail();
        // Bundle is saved as ONE snapshot line item, not flattened
        $this->assertCount(1, $order->items);
        $item = $order->items->first();
        $this->assertSame($bundle->id, $item->product_id);
        $this->assertSame($bundle->name, $item->product_name);
        $this->assertSame($bundle->sku, $item->product_sku);
        $this->assertSame(2, $item->quantity);
    }

    public function test_cod_payment_record_created_with_pending_status(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product)->assertOk();
        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        $order = Order::query()->firstOrFail();
        $payment = Payment::query()->where('order_id', $order->id)->firstOrFail();
        $this->assertSame('cod', $payment->provider);
        $this->assertSame('pending', $payment->status);
        $this->assertNull($payment->paid_at);
        $this->assertNull($payment->transaction_id);
        $this->assertSame($order->grand_total, $payment->amount);
    }

    public function test_cart_items_cleared_after_successful_checkout_preserving_cart_record(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product)->assertOk();
        $this->assertDatabaseCount('cart_items', 1);
        $this->assertDatabaseCount('carts', 1);

        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        $this->assertDatabaseCount('cart_items', 0);
        $this->assertDatabaseCount('carts', 1);
    }

    // ==========================================
    // 2. Inventory Decrement Tests (Section 34)
    // ==========================================

    public function test_single_product_stock_decrements(): void
    {
        $product = $this->product('LNS-NH001');
        $initialStock = $product->stock_quantity;

        $this->add($product, 2)->assertOk();
        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        $this->assertSame($initialStock - 2, $product->fresh()->stock_quantity);
    }

    public function test_collection_bundle_decrements_component_stocks_not_bundle_stock(): void
    {
        $bundle = $this->product('LNS-SET001')->load('bundleItems.component');
        $components = $bundle->bundleItems->pluck('component');
        $initialStocks = $components->pluck('stock_quantity', 'id');

        $this->add($bundle, 1)->assertOk();
        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        // Bundle itself has stock_quantity = 0 and is virtual; it must remain 0
        $this->assertSame(0, $bundle->fresh()->stock_quantity);

        // Every component must decrement by 1 * bundle_item.quantity
        foreach ($bundle->bundleItems as $item) {
            $expected = $initialStocks[$item->component_product_id] - $item->quantity;
            $this->assertSame($expected, $item->component->fresh()->stock_quantity);
        }
    }

    public function test_gift_bundle_decrements_component_stocks_not_bundle_stock(): void
    {
        $gift = $this->product('LNS-GIFT001')->load('bundleItems.component');
        $components = $gift->bundleItems->pluck('component');
        $initialStocks = $components->pluck('stock_quantity', 'id');

        $this->add($gift, 1)->assertOk();
        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        $this->assertSame(0, $gift->fresh()->stock_quantity);
        foreach ($gift->bundleItems as $item) {
            $expected = $initialStocks[$item->component_product_id] - $item->quantity;
            $this->assertSame($expected, $item->component->fresh()->stock_quantity);
        }
    }

    public function test_single_plus_bundle_shared_component_stock_decrements_aggregate_quantity(): void
    {
        // Setup: Bundle SET001 contains component
        $bundle = $this->product('LNS-SET001')->load('bundleItems.component');
        $sharedComponent = $bundle->bundleItems->first()->component;
        $sharedComponent->update(['stock_quantity' => 10]);

        // Cart has single shared component x2 AND bundle x1 (which contains shared component x1)
        $this->add($sharedComponent, 2)->assertOk();
        $this->add($bundle, 1)->assertOk();

        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        // Total shared component decrement = 2 (single) + 1 (bundle) = 3
        $this->assertSame(7, $sharedComponent->fresh()->stock_quantity);
    }

    public function test_two_bundles_sharing_component_decrement_aggregate_quantity(): void
    {
        $first = $this->product('LNS-SET003');
        $second = $this->product('LNS-GIFT001');
        $shared = $this->product('LNS-NH005');
        $shared->update(['stock_quantity' => 10]);

        $this->add($first, 1)->assertOk();
        $this->add($second, 1)->assertOk();

        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        // Both bundles contain NH005 x1, so 10 - 2 = 8
        $this->assertSame(8, $shared->fresh()->stock_quantity);
    }

    public function test_bundle_quantity_multiplies_component_decrements(): void
    {
        $bundle = $this->product('LNS-SET001')->load('bundleItems.component');
        $component = $bundle->bundleItems->first()->component;
        $component->update(['stock_quantity' => 10]);

        $this->add($bundle, 3)->assertOk();
        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        // 3 * 1 = 3 decremented, remaining 7
        $this->assertSame(7, $component->fresh()->stock_quantity);
    }

    public function test_single_stock_status_updates_to_out_of_stock_when_zero(): void
    {
        $product = $this->product('LNS-NH001');
        $product->update(['stock_quantity' => 2, 'stock_status' => 'in_stock']);

        $this->add($product, 2)->assertOk();
        $token = $this->getCheckoutToken();
        $this->post('/checkout', $this->validFormData($token))->assertRedirect();

        $fresh = $product->fresh();
        $this->assertSame(0, $fresh->stock_quantity);
        $this->assertSame('out_of_stock', $fresh->stock_status);
    }

    // ==========================================
    // 3. Failed Checkout Tests (Section 35 & 38)
    // ==========================================

    public function test_checkout_fails_when_stock_decreased_after_add_to_cart(): void
    {
        $product = $this->product('LNS-NH001');
        $product->update(['stock_quantity' => 3]);

        $this->add($product, 3)->assertOk();
        $token = $this->getCheckoutToken();

        // Another purchase or admin reduces stock before this checkout completes
        $product->update(['stock_quantity' => 2]);

        $response = $this->post('/checkout', $this->validFormData($token));
        $response->assertSessionHasErrors('cart');

        // Verify no order or payment was created
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('payments', 0);

        // Verify stock was not partially decremented
        $this->assertSame(2, $product->fresh()->stock_quantity);

        // Cart items are preserved
        $this->assertDatabaseCount('cart_items', 1);
        $this->assertSame(3, CartItem::query()->firstOrFail()->quantity);
    }

    public function test_checkout_fails_when_bundle_component_insufficient(): void
    {
        $bundle = $this->product('LNS-SET001')->load('bundleItems.component');
        $component = $bundle->bundleItems->first()->component;
        $component->update(['stock_quantity' => 1]);

        $this->add($bundle, 1)->assertOk();
        $token = $this->getCheckoutToken();

        // Component runs out of stock before checkout
        $component->update(['stock_quantity' => 0]);

        $response = $this->post('/checkout', $this->validFormData($token));
        $response->assertSessionHasErrors('cart');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(0, $component->fresh()->stock_quantity);
        $this->assertDatabaseCount('cart_items', 1);
    }

    // ==========================================
    // 4. Security & Authorization (Section 36 & 31 & 32)
    // ==========================================

    public function test_client_supplied_prices_subtotals_and_user_id_are_ignored(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = $this->product('LNS-NH001');
        $realPrice = $product->hasValidSalePrice() ? $product->sale_price : $product->regular_price;
        $this->add($product, 1)->assertOk();

        $token = $this->getCheckoutToken($user);

        // Attacker attempts to forge price, subtotal, grand_total, and user_id
        $response = $this->post('/checkout', $this->validFormData($token, [
            'user_id' => 9999,
            'unit_price' => '1.00',
            'subtotal' => '1.00',
            'grand_total' => '1.00',
            'shipping_fee' => '0.00',
        ]));

        $response->assertRedirect();
        $order = Order::query()->firstOrFail();

        // User ID must strictly be authenticated user's ID, ignoring client input
        $this->assertSame($user->id, $order->user_id);
        // Prices must strictly be computed by backend
        $this->assertSame($realPrice, $order->subtotal);
        $this->assertSame($realPrice, $order->grand_total);
    }

    public function test_user_cannot_view_another_users_order_success_page(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $order = Order::create([
            'user_id' => $owner->id,
            'order_code' => 'LNS-20260920-TEST01',
            'customer_name' => 'Owner',
            'customer_email' => 'owner@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Test',
            'shipping_city' => 'Hanoi',
            'shipping_method' => 'standard',
            'subtotal' => '500000.00',
            'discount_amount' => '0.00',
            'shipping_fee' => '0.00',
            'grand_total' => '500000.00',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        // Owner can view
        $this->actingAs($owner)->get('/order-success/'.$order->order_code)->assertOk();

        // Other user cannot view (403 Forbidden)
        $this->actingAs($other)->get('/order-success/'.$order->order_code)->assertForbidden();

        // Guest cannot view authenticated order (403 Forbidden)
        auth()->logout();
        $this->get('/order-success/'.$order->order_code)->assertForbidden();
    }

    public function test_guest_cannot_view_another_guest_sessions_order_success_page(): void
    {
        // Compatibility test for historical guest orders (user_id = null)
        $order = Order::create([
            'user_id' => null,
            'order_code' => 'LNS-20260920-HISTORICAL-01',
            'customer_name' => 'Historical Guest',
            'customer_email' => 'guest@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Test',
            'shipping_city' => 'Hanoi',
            'shipping_method' => 'standard',
            'subtotal' => '500000.00',
            'discount_amount' => '0.00',
            'shipping_fee' => '0.00',
            'grand_total' => '500000.00',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        // Session A has the order authorized in its session and can view
        $this->withSession([
            'authorized_orders' => [$order->id],
            'last_order_code' => $order->order_code,
        ])->get('/order-success/'.$order->order_code)->assertOk();

        // Session B attempts to view Session A's order without session authorization
        $this->flushSession();
        $this->withSession(['lunara_cart_token' => 'guest-session-b']);
        $this->get('/order-success/'.$order->order_code)->assertForbidden();
    }

    // ==========================================
    // 5. Double Submit Protection (Section 37)
    // ==========================================

    public function test_same_checkout_token_cannot_submit_twice(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product)->assertOk();

        $token = $this->getCheckoutToken();
        $formData = $this->validFormData($token);

        // First submit succeeds
        $this->post('/checkout', $formData)->assertRedirect();
        $this->assertDatabaseCount('orders', 1);

        // Second submit with the same token is rejected
        $response = $this->post('/checkout', $formData);
        $response->assertSessionHasErrors('checkout_token');
        $this->assertDatabaseCount('orders', 1);
    }

    public function test_missing_or_tampered_checkout_token_is_rejected(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product)->assertOk();

        $this->getCheckoutToken(); // Sets session token

        $response = $this->post('/checkout', $this->validFormData('tampered-fake-token'));
        $response->assertSessionHasErrors('checkout_token');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_forced_transaction_exception_triggers_complete_rollback(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = $this->product('LNS-NH001');
        $initialStock = $product->stock_quantity;
        $this->add($product, 2)->assertOk();

        $cart = Cart::query()->firstOrFail();
        $this->assertSame(2, $cart->items()->firstOrFail()->quantity);

        // Force a controlled exception during checkout inside Payment creation
        Payment::saving(function () {
            throw new \RuntimeException('Simulated payment gateway failure');
        });

        $checkoutService = app(CheckoutService::class);

        try {
            $checkoutService->processCheckout($cart, $user, [
                'customer_name' => 'Rollback Test',
                'customer_email' => 'rollback@example.com',
                'customer_phone' => '0901234567',
                'shipping_address' => 'Test Address',
                'shipping_city' => 'HCMC',
                'payment_method' => 'cod',
            ]);
            $this->fail('Expected exception was not thrown');
        } catch (\RuntimeException $e) {
            $this->assertSame('Simulated payment gateway failure', $e->getMessage());
        }

        // Entire transaction must be rolled back:
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
        $this->assertDatabaseCount('payments', 0);
        $this->assertSame($initialStock, $product->fresh()->stock_quantity, 'Stock remains unchanged after rollback');
        $this->assertDatabaseCount('cart_items', 1);
    }
}
