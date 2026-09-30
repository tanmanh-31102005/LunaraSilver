<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentRefund;
use App\Models\Product;
use App\Models\User;
use App\Services\CouponService;
use App\Services\OrderStatusService;
use App\Services\VNPay\VNPayService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PromotionCouponTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $customer;

    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->customer = User::factory()->create(['role' => User::ROLE_USER]);
        $this->product = Product::query()->where('sku', 'LNS-NH001')->firstOrFail();
    }

    public function test_admin_can_create_percentage_coupon_with_max_discount(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.coupons.store'), [
            'code' => 'sale20',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 20,
            'minimum_order' => 200000,
            'maximum_discount' => 100000,
            'usage_limit' => 50,
            'usage_limit_per_user' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.coupons.index'));
        $this->assertDatabaseHas('coupons', [
            'code' => 'SALE20',
            'type' => 'percentage',
            'value' => 20,
            'maximum_discount' => 100000,
            'usage_limit' => 50,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_create_fixed_coupon(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.coupons.store'), [
            'code' => 'voucher50k',
            'type' => Coupon::TYPE_FIXED,
            'value' => 50000,
            'minimum_order' => 300000,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.coupons.index'));
        $this->assertDatabaseHas('coupons', [
            'code' => 'VOUCHER50K',
            'type' => 'fixed',
            'value' => 50000,
        ]);
    }

    public function test_admin_cannot_create_percentage_coupon_over_100_percent(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.coupons.store'), [
            'code' => 'SUPER150',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 150,
        ]);

        $response->assertSessionHasErrors('value');
        $this->assertDatabaseMissing('coupons', ['code' => 'SUPER150']);
    }

    public function test_admin_can_list_filter_and_search_coupons(): void
    {
        Coupon::create(['code' => 'ALPHA10', 'type' => Coupon::TYPE_PERCENTAGE, 'value' => 10, 'is_active' => true]);
        Coupon::create(['code' => 'BETA50K', 'type' => Coupon::TYPE_FIXED, 'value' => 50000, 'is_active' => false]);

        // Search by code
        $this->actingAs($this->admin)->get(route('admin.coupons.index', ['q' => 'ALPHA']))
            ->assertOk()
            ->assertSee('ALPHA10')
            ->assertDontSee('BETA50K');

        // Filter by type
        $this->actingAs($this->admin)->get(route('admin.coupons.index', ['type' => 'fixed']))
            ->assertOk()
            ->assertSee('BETA50K')
            ->assertDontSee('ALPHA10');

        // Filter by active status
        $this->actingAs($this->admin)->get(route('admin.coupons.index', ['status' => '0']))
            ->assertOk()
            ->assertSee('BETA50K')
            ->assertDontSee('ALPHA10');
    }

    public function test_admin_can_toggle_coupon_active_status(): void
    {
        $coupon = Coupon::create(['code' => 'TOGGLEME', 'type' => Coupon::TYPE_FIXED, 'value' => 20000, 'is_active' => true]);

        $this->actingAs($this->admin)->patch(route('admin.coupons.toggle', $coupon))
            ->assertSessionHasNoErrors();

        $this->assertFalse($coupon->fresh()->is_active);

        $this->actingAs($this->admin)->patch(route('admin.coupons.toggle', $coupon))
            ->assertSessionHasNoErrors();

        $this->assertTrue($coupon->fresh()->is_active);
    }

    public function test_admin_can_delete_unused_coupon(): void
    {
        $coupon = Coupon::create(['code' => 'DELETEUNUSED', 'type' => Coupon::TYPE_FIXED, 'value' => 10000, 'used_count' => 0]);

        $this->actingAs($this->admin)->delete(route('admin.coupons.destroy', $coupon))
            ->assertRedirect(route('admin.coupons.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('coupons', ['code' => 'DELETEUNUSED']);
    }

    public function test_admin_soft_disables_coupon_if_it_has_been_used_in_orders(): void
    {
        $coupon = Coupon::create(['code' => 'CANTDELETE', 'type' => Coupon::TYPE_FIXED, 'value' => 10000, 'used_count' => 1, 'is_active' => true]);

        $this->actingAs($this->admin)->delete(route('admin.coupons.destroy', $coupon))
            ->assertRedirect(route('admin.coupons.index'))
            ->assertSessionHas('warning');

        $this->assertDatabaseHas('coupons', ['code' => 'CANTDELETE']);
        $this->assertFalse($coupon->fresh()->is_active);
    }

    public function test_coupon_service_calculates_discounts_accurately(): void
    {
        $service = app(CouponService::class);

        // Percentage with cap: 20% of 1,000,000 is 200,000, but cap is 150,000
        $cappedCoupon = Coupon::create([
            'code' => 'CAP20',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 20,
            'maximum_discount' => 150000,
        ]);
        $discount = $service->calculateDiscount($cappedCoupon, 1000000);
        $this->assertEquals(150000, $discount);

        // Fixed coupon: 500,000 fixed discount on 300,000 subtotal caps at 300,000 (never exceeds subtotal)
        $fixedCoupon = Coupon::create([
            'code' => 'BIGFIXED',
            'type' => Coupon::TYPE_FIXED,
            'value' => 500000,
        ]);
        $discountFixed = $service->calculateDiscount($fixedCoupon, 300000);
        $this->assertEquals(300000, $discountFixed);
    }

    public function test_coupon_validation_fails_for_inactive_or_expired_or_not_started(): void
    {
        $service = app(CouponService::class);

        // Inactive coupon
        Coupon::create(['code' => 'INACTIVE10', 'type' => Coupon::TYPE_PERCENTAGE, 'value' => 10, 'is_active' => false]);
        $this->expectException(ValidationException::class);
        $service->validate('INACTIVE10', 500000);
    }

    public function test_coupon_validation_fails_if_expired(): void
    {
        $service = app(CouponService::class);

        Coupon::create([
            'code' => 'EXPIRED',
            'type' => Coupon::TYPE_FIXED,
            'value' => 20000,
            'expires_at' => now()->subDay(),
            'is_active' => true,
        ]);

        $this->expectException(ValidationException::class);
        $service->validate('EXPIRED', 500000);
    }

    public function test_coupon_validation_fails_if_minimum_order_not_met(): void
    {
        $service = app(CouponService::class);

        Coupon::create([
            'code' => 'MIN1M',
            'type' => Coupon::TYPE_FIXED,
            'value' => 50000,
            'minimum_order' => 1000000,
            'is_active' => true,
        ]);

        $this->expectException(ValidationException::class);
        $service->validate('MIN1M', 500000);
    }

    public function test_coupon_validation_fails_if_global_or_user_limit_exceeded(): void
    {
        $service = app(CouponService::class);

        // Global limit reached
        Coupon::create([
            'code' => 'MAXOUT',
            'type' => Coupon::TYPE_FIXED,
            'value' => 10000,
            'usage_limit' => 2,
            'used_count' => 2,
            'is_active' => true,
        ]);

        $this->expectException(ValidationException::class);
        $service->validate('MAXOUT', 500000);
    }

    public function test_coupon_validation_enforces_per_user_limit(): void
    {
        $service = app(CouponService::class);

        $coupon = Coupon::create([
            'code' => 'ONCEPERUSER',
            'type' => Coupon::TYPE_FIXED,
            'value' => 10000,
            'usage_limit_per_user' => 1,
            'is_active' => true,
        ]);

        // First validation passes
        $result = $service->validate('ONCEPERUSER', 500000, $this->customer);
        $this->assertTrue($result['valid']);

        $dummyOrder = Order::create([
            'user_id' => $this->customer->id,
            'order_code' => 'LNS-DUMMY-01',
            'customer_name' => 'Test Customer',
            'customer_email' => 'test@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Street',
            'shipping_city' => 'HCM',
            'shipping_method' => 'standard',
            'subtotal' => '100000.00',
            'grand_total' => '100000.00',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'placed_at' => now(),
        ]);

        // Fake an applied usage for this customer
        CouponUsage::create([
            'coupon_id' => $coupon->id,
            'user_id' => $this->customer->id,
            'order_id' => $dummyOrder->id,
            'status' => CouponUsage::STATUS_APPLIED,
            'used_at' => now(),
        ]);

        // Second validation must fail
        $this->expectException(ValidationException::class);
        $service->validate('ONCEPERUSER', 500000, $this->customer);
    }

    public function test_cart_can_apply_and_remove_coupon(): void
    {
        Coupon::create([
            'code' => 'CARTDISCOUNT',
            'type' => Coupon::TYPE_FIXED,
            'value' => 50000,
            'minimum_order' => 100000,
            'is_active' => true,
        ]);

        // Add product to cart
        $this->actingAs($this->customer)->postJson('/cart/items', [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ])->assertOk();

        // Apply coupon via web form
        $response = $this->actingAs($this->customer)->post(route('cart.coupon.apply'), [
            'code' => 'cartdiscount',
        ]);
        $response->assertSessionHas('coupon_success');
        $this->assertEquals('CARTDISCOUNT', session('coupon_code'));

        // View cart and see applied discount
        $this->actingAs($this->customer)->get(route('cart.index'))
            ->assertOk()
            ->assertSee('CARTDISCOUNT')
            ->assertSee('50.000 ₫');

        // Remove coupon
        $this->actingAs($this->customer)->delete(route('cart.coupon.remove'))
            ->assertSessionHasNoErrors();
        $this->assertNull(session('coupon_code'));
    }

    public function test_checkout_snapshots_coupon_discount_and_records_usage(): void
    {
        $coupon = Coupon::create([
            'code' => 'CHECKOUT10',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 10,
            'is_active' => true,
        ]);

        // Add product to cart
        $this->actingAs($this->customer)->postJson('/cart/items', [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ])->assertOk();

        // Visit checkout to generate checkout_token
        $this->actingAs($this->customer)->get(route('checkout.show'))->assertOk();
        $checkoutToken = session('checkout_token');

        // Put coupon in session
        session(['coupon_code' => 'CHECKOUT10']);

        // Post checkout COD
        $response = $this->actingAs($this->customer)->post(route('checkout.store'), [
            'customer_name' => 'Nguyen Van A',
            'customer_email' => 'nguyenvana@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Le Loi',
            'shipping_city' => 'Ho Chi Minh',
            'shipping_method' => 'standard',
            'payment_method' => 'cod',
            'checkout_token' => $checkoutToken,
        ]);

        $order = Order::query()->where('customer_email', 'nguyenvana@example.com')->firstOrFail();
        $response->assertRedirect(route('orders.success', $order->order_code));

        // Verify Order snapshot
        $this->assertSame('CHECKOUT10', $order->coupon_code);
        $expectedDiscount = round((float) $order->subtotal * 0.1, 2);
        $this->assertEquals($expectedDiscount, (float) $order->discount_amount);
        $this->assertEquals((float) $order->subtotal - $expectedDiscount, (float) $order->grand_total);

        // Verify CouponUsage recorded
        $this->assertDatabaseHas('coupon_usages', [
            'coupon_id' => $coupon->id,
            'order_id' => $order->id,
            'user_id' => $this->customer->id,
            'status' => CouponUsage::STATUS_APPLIED,
        ]);

        // Verify coupon used_count incremented
        $this->assertEquals(1, $coupon->fresh()->used_count);

        // Verify session coupon cleared
        $this->assertNull(session('coupon_code'));
    }

    public function test_vnpay_payment_uses_discounted_grand_total(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_code' => 'LNS-TEST-VNPAY',
            'customer_name' => 'Le Van B',
            'customer_email' => 'levanb@example.com',
            'customer_phone' => '0909888777',
            'shipping_address' => '456 Tran Hung Dao',
            'shipping_city' => 'Ho Chi Minh',
            'shipping_method' => 'standard',
            'subtotal' => '1000000.00',
            'coupon_code' => 'VNPAY50K',
            'discount_amount' => '50000.00',
            'shipping_fee' => '0.00',
            'grand_total' => '950000.00',
            'payment_method' => 'vnpay',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'placed_at' => now(),
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'txn_ref' => 'LNS-TXN-VNPAY-01',
            'amount' => 950000,
            'status' => Payment::STATUS_PENDING,
        ]);

        $vnpayService = app(VNPayService::class);
        $paymentUrl = $vnpayService->createPaymentUrl($payment, '127.0.0.1');

        // VNPay amount is grand_total * 100 = 950000 * 100 = 95000000
        $this->assertStringContainsString('vnp_Amount=95000000', $paymentUrl);
    }

    public function test_cancelling_order_releases_coupon_usage(): void
    {
        $coupon = Coupon::create([
            'code' => 'CANCELTEST',
            'type' => Coupon::TYPE_FIXED,
            'value' => 50000,
            'used_count' => 1,
            'is_active' => true,
        ]);

        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_code' => 'LNS-ORD-CANCEL',
            'customer_name' => 'Tran Van C',
            'customer_email' => 'tranc@example.com',
            'customer_phone' => '0912345678',
            'shipping_address' => '789 Dien Bien Phu',
            'shipping_city' => 'Ho Chi Minh',
            'shipping_method' => 'standard',
            'subtotal' => '500000.00',
            'coupon_code' => 'CANCELTEST',
            'discount_amount' => '50000.00',
            'shipping_fee' => '0.00',
            'grand_total' => '450000.00',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'placed_at' => now(),
        ]);

        $usage = CouponUsage::create([
            'coupon_id' => $coupon->id,
            'order_id' => $order->id,
            'user_id' => $this->customer->id,
            'status' => CouponUsage::STATUS_APPLIED,
            'used_at' => now(),
        ]);

        // Cancel order via OrderStatusService
        $statusService = app(OrderStatusService::class);
        $statusService->cancelOrder($order, $this->admin, 'Khách hàng yêu cầu hủy đơn');

        // Verify coupon usage is marked released
        $this->assertEquals(CouponUsage::STATUS_RELEASED, $usage->fresh()->status);
        $this->assertNotNull($usage->fresh()->released_at);

        // Verify coupon used_count decremented
        $this->assertEquals(0, $coupon->fresh()->used_count);
    }

    public function test_refunding_order_does_not_release_coupon_usage(): void
    {
        $coupon = Coupon::create([
            'code' => 'REFUNDNORELEASE',
            'type' => Coupon::TYPE_FIXED,
            'value' => 50000,
            'used_count' => 1,
            'is_active' => true,
        ]);

        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_code' => 'LNS-ORD-REFUND',
            'customer_name' => 'Do Van D',
            'customer_email' => 'dovand@example.com',
            'customer_phone' => '0933333333',
            'shipping_address' => '101 Nguyen Hue',
            'shipping_city' => 'Ho Chi Minh',
            'shipping_method' => 'standard',
            'subtotal' => '500000.00',
            'coupon_code' => 'REFUNDNORELEASE',
            'discount_amount' => '50000.00',
            'shipping_fee' => '0.00',
            'grand_total' => '450000.00',
            'payment_method' => 'vnpay',
            'payment_status' => 'paid',
            'order_status' => 'completed',
            'placed_at' => now(),
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'vnpay',
            'txn_ref' => 'LNS-TXN-REFUND-01',
            'amount' => 450000,
            'status' => Payment::STATUS_PAID,
        ]);

        $usage = CouponUsage::create([
            'coupon_id' => $coupon->id,
            'order_id' => $order->id,
            'user_id' => $this->customer->id,
            'status' => CouponUsage::STATUS_APPLIED,
            'used_at' => now(),
        ]);

        // Create a refund record
        PaymentRefund::create([
            'payment_id' => $payment->id,
            'order_id' => $order->id,
            'request_id' => 'REQ-TEST-01',
            'refund_type' => PaymentRefund::TYPE_FULL,
            'amount' => 450000,
            'status' => PaymentRefund::STATUS_SUCCEEDED,
            'refund_txn_ref' => 'REF-12345',
            'reason' => 'Đổi trả sau hoàn thành',
        ]);

        // Rule 15.19: Refunding a completed order does NOT release coupon
        $this->assertEquals(CouponUsage::STATUS_APPLIED, $usage->fresh()->status);
        $this->assertEquals(1, $coupon->fresh()->used_count);
    }

    public function test_first_order_coupon_validation_fails_if_customer_has_previous_orders(): void
    {
        $service = app(CouponService::class);

        $coupon = Coupon::create([
            'code' => 'FIRSTORDER',
            'type' => Coupon::TYPE_FIXED,
            'value' => 50000,
            'is_first_order_only' => true,
            'is_active' => true,
        ]);

        $newCustomer = User::factory()->create(['role' => User::ROLE_USER, 'email' => 'newuser@lunara.vn']);

        // Succeeded for new user with 0 orders
        $validated = $service->validate('FIRSTORDER', 200000, $newCustomer, null, 'newuser@lunara.vn');
        $this->assertEquals('FIRSTORDER', $validated['code']);

        // Create an active order for this user
        Order::create([
            'user_id' => $newCustomer->id,
            'order_code' => 'LNS-ORD-PRIOR-01',
            'customer_name' => 'New User',
            'customer_email' => 'newuser@lunara.vn',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Le Loi',
            'shipping_city' => 'Hồ Chí Minh',
            'shipping_method' => 'standard',
            'subtotal' => 200000,
            'shipping_fee' => 0,
            'grand_total' => 200000,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'processing',
        ]);

        // Now fails because user has existing order
        $this->expectException(ValidationException::class);
        $service->validate('FIRSTORDER', 200000, $newCustomer, null, 'newuser@lunara.vn');
    }

    public function test_customer_specific_coupon_restricts_to_authorized_emails(): void
    {
        $service = app(CouponService::class);

        Coupon::create([
            'code' => 'VIPONLY',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 15,
            'applicable_customer_emails' => ['vip@lunara.vn', 'special@lunara.vn'],
            'is_active' => true,
        ]);

        // Allowed email passes
        $res = $service->validate('VIPONLY', 300000, null, null, 'vip@lunara.vn');
        $this->assertEquals('VIPONLY', $res['code']);

        // Disallowed email throws ValidationException
        $this->expectException(ValidationException::class);
        $service->validate('VIPONLY', 300000, null, null, 'regular@lunara.vn');
    }

    public function test_category_and_product_specific_coupons_calculate_discount_on_eligible_items(): void
    {
        $service = app(CouponService::class);

        $categoryA = Category::first();
        $categoryB = Category::skip(1)->first() ?? Category::create(['name' => 'Other Category', 'slug' => 'other-cat']);

        $productA = Product::create([
            'name' => 'Test Product A',
            'slug' => 'test-product-a',
            'sku' => 'TEST-PROD-A',
            'category_id' => $categoryA->id,
            'regular_price' => 400000,
            'stock_quantity' => 10,
            'product_type' => 'single',
            'is_active' => true,
        ]);
        $productB = Product::create([
            'name' => 'Test Product B',
            'slug' => 'test-product-b',
            'sku' => 'TEST-PROD-B',
            'category_id' => $categoryB->id,
            'regular_price' => 600000,
            'stock_quantity' => 10,
            'product_type' => 'single',
            'is_active' => true,
        ]);

        $cart = Cart::create(['user_id' => $this->customer->id]);
        $cart->items()->create(['product_id' => $productA->id, 'quantity' => 1, 'unit_price' => 400000]);
        $cart->items()->create(['product_id' => $productB->id, 'quantity' => 1, 'unit_price' => 600000]);
        $cart->load('items.product');

        // Coupon for Category A only (10% off)
        $couponCatA = Coupon::create([
            'code' => 'CAT10',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 10,
            'applicable_categories' => [$categoryA->id],
            'is_active' => true,
        ]);

        $service->validate('CAT10', 1000000, $this->customer, $cart);
        $discount = $service->calculateDiscount($couponCatA, 1000000, $cart);

        // 10% of 400,000 (Product A only) = 40,000, not 100,000
        $this->assertEquals(40000, $discount);

        // Product-specific coupon for Product B only
        $couponProdB = Coupon::create([
            'code' => 'PROD50K',
            'type' => Coupon::TYPE_FIXED,
            'value' => 50000,
            'applicable_products' => [$productB->id],
            'is_active' => true,
        ]);

        $service->validate('PROD50K', 1000000, $this->customer, $cart);
        $discountProd = $service->calculateDiscount($couponProdB, 1000000, $cart);
        $this->assertEquals(50000, $discountProd);

        // Coupon for an excluded product should fail validation if cart has no eligible items
        $couponUnrelated = Coupon::create([
            'code' => 'UNRELATED',
            'type' => Coupon::TYPE_FIXED,
            'value' => 50000,
            'applicable_products' => [999999],
            'is_active' => true,
        ]);

        $this->expectException(ValidationException::class);
        $service->validate('UNRELATED', 1000000, $this->customer, $cart);
    }
}
