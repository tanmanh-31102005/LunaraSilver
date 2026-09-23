<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    private function createOrderForUser(?User $user, array $overrides = []): Order
    {
        $code = 'LNS-'.now()->format('Ymd').'-'.strtoupper(bin2hex(random_bytes(3)));

        $order = Order::create(array_merge([
            'user_id' => $user?->id,
            'order_code' => $code,
            'customer_name' => $user?->name ?? 'Khách Mua Hàng',
            'customer_email' => $user?->email ?? 'guest@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Đường Số 1, Phường 2',
            'shipping_city' => 'Hồ Chí Minh',
            'shipping_note' => null,
            'shipping_method' => 'standard',
            'subtotal' => 550000,
            'discount_amount' => 0,
            'shipping_fee' => 0,
            'grand_total' => 550000,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'customer_note' => null,
            'placed_at' => now(),
        ], $overrides));

        $product = Product::query()->where('sku', 'LNS-NH001')->first() ?? Product::first();

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product?->id,
            'product_name' => 'Nhẫn Bạc Lunara Classic',
            'product_sku' => 'LNS-NH001',
            'unit_price' => 550000,
            'quantity' => 1,
            'subtotal' => 550000,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'provider' => 'cod',
            'amount' => 550000,
            'status' => 'pending',
        ]);

        return $order;
    }

    // =========================================================================
    // 1. Account Access Tests (Section 39)
    // =========================================================================

    public function test_guest_cannot_access_account_dashboard_and_is_redirected(): void
    {
        $response = $this->get('/account');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create(['name' => 'Ngọc Linh']);

        $response = $this->actingAs($user)->get('/account');

        $response->assertOk();
        $response->assertSee('Ngọc Linh');
        $response->assertSee('Tổng quan tài khoản');
    }

    public function test_dashboard_shows_only_current_users_summary(): void
    {
        $user1 = User::factory()->create(['name' => 'User One']);
        $user2 = User::factory()->create(['name' => 'User Two']);

        $order1 = $this->createOrderForUser($user1);
        $order2 = $this->createOrderForUser($user2);

        $addr1 = Address::create([
            'user_id' => $user1->id,
            'recipient_name' => 'User One Recipient',
            'phone' => '0901111111',
            'address_line' => '111 Phố Một',
            'city' => 'Hà Nội',
            'is_default' => true,
        ]);

        $addr2 = Address::create([
            'user_id' => $user2->id,
            'recipient_name' => 'User Two Recipient',
            'phone' => '0902222222',
            'address_line' => '222 Phố Hai',
            'city' => 'Đà Nẵng',
            'is_default' => true,
        ]);

        $response = $this->actingAs($user1)->get('/account');

        $response->assertOk();
        $response->assertSee($order1->order_code);
        $response->assertDontSee($order2->order_code);
        $response->assertSee('111 Phố Một');
        $response->assertDontSee('222 Phố Hai');
    }

    // =========================================================================
    // 2. Profile Tests (Section 40)
    // =========================================================================

    public function test_user_can_update_name(): void
    {
        $user = User::factory()->create(['name' => 'Tên Cũ']);

        $response = $this->actingAs($user)->patch('/account/profile', [
            'name' => 'Tên Mới Cập Nhật',
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('account.profile.edit'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Tên Mới Cập Nhật',
        ]);
    }

    public function test_user_can_update_email(): void
    {
        $user = User::factory()->create(['email' => 'oldemail@example.com']);

        $response = $this->actingAs($user)->patch('/account/profile', [
            'name' => $user->name,
            'email' => 'newemail@example.com',
        ]);

        $response->assertRedirect(route('account.profile.edit'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'newemail@example.com',
        ]);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        $user1 = User::factory()->create(['email' => 'existing@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $response = $this->actingAs($user2)->patch('/account/profile', [
            'name' => 'User Two',
            'email' => 'existing@example.com',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseHas('users', [
            'id' => $user2->id,
            'email' => 'user2@example.com',
        ]);
    }

    public function test_user_cannot_modify_another_user_through_crafted_user_id(): void
    {
        $user1 = User::factory()->create(['name' => 'User One']);
        $user2 = User::factory()->create(['name' => 'User Two']);

        $response = $this->actingAs($user1)->patch('/account/profile', [
            'user_id' => $user2->id,
            'name' => 'Hacked Name',
            'email' => $user1->email,
        ]);

        $response->assertRedirect(route('account.profile.edit'));
        $this->assertDatabaseHas('users', [
            'id' => $user1->id,
            'name' => 'Hacked Name',
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $user2->id,
            'name' => 'User Two',
        ]);
    }

    // =========================================================================
    // 3. Password Tests (Section 41)
    // =========================================================================

    public function test_correct_current_password_changes_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword123'),
        ]);

        $response = $this->actingAs($user)->patch('/account/password', [
            'current_password' => 'oldpassword123',
            'password' => 'newpassword456',
            'password_confirmation' => 'newpassword456',
        ]);

        $response->assertRedirect(route('account.password.edit'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword456', $user->password));
    }

    public function test_wrong_current_password_is_rejected(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('correctpassword123'),
        ]);

        $response = $this->actingAs($user)->patch('/account/password', [
            'current_password' => 'wrongpassword123',
            'password' => 'newpassword456',
            'password_confirmation' => 'newpassword456',
        ]);

        $response->assertSessionHasErrors('current_password');

        $user->refresh();
        $this->assertTrue(Hash::check('correctpassword123', $user->password));
    }

    public function test_password_confirmation_required(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->patch('/account/password', [
            'current_password' => 'password123',
            'password' => 'newpassword456',
            'password_confirmation' => 'mismatch789',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_new_password_is_stored_hashed(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword123'),
        ]);

        $this->actingAs($user)->patch('/account/password', [
            'current_password' => 'oldpassword123',
            'password' => 'supersecurepassword',
            'password_confirmation' => 'supersecurepassword',
        ]);

        $user->refresh();
        $this->assertNotEquals('supersecurepassword', $user->password);
        $this->assertTrue(Hash::check('supersecurepassword', $user->password));
    }

    // =========================================================================
    // 4. Address Tests (Section 42)
    // =========================================================================

    public function test_user_can_create_address(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/account/addresses', [
            'recipient_name' => 'Nguyễn Văn Test',
            'phone' => '0908765432',
            'address_line' => '456 Hai Bà Trưng',
            'ward' => 'Tân Định',
            'district' => 'Quận 1',
            'city' => 'Hồ Chí Minh',
        ]);

        $response->assertRedirect(route('account.addresses.index'));
        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'recipient_name' => 'Nguyễn Văn Test',
            'city' => 'Hồ Chí Minh',
        ]);
    }

    public function test_first_address_automatically_becomes_default(): void
    {
        $user = User::factory()->create();
        $this->assertEquals(0, $user->addresses()->count());

        $this->actingAs($user)->post('/account/addresses', [
            'recipient_name' => 'Địa chỉ 1',
            'phone' => '0901234567',
            'address_line' => '100 Lê Duẩn',
            'city' => 'Hồ Chí Minh',
            'is_default' => 0, // Even if requested as not default
        ]);

        $address = $user->addresses()->first();
        $this->assertNotNull($address);
        $this->assertTrue($address->is_default);
    }

    public function test_user_can_update_own_address(): void
    {
        $user = User::factory()->create();
        $address = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Tên Ban Đầu',
            'phone' => '0901234567',
            'address_line' => '123 Đường',
            'city' => 'Hồ Chí Minh',
            'is_default' => true,
        ]);

        $response = $this->actingAs($user)->patch("/account/addresses/{$address->id}", [
            'recipient_name' => 'Tên Cập Nhật',
            'phone' => '0909999999',
            'address_line' => '999 Đường Mới',
            'city' => 'Hà Nội',
            'is_default' => 1,
        ]);

        $response->assertRedirect(route('account.addresses.index'));
        $address->refresh();
        $this->assertEquals('Tên Cập Nhật', $address->recipient_name);
        $this->assertEquals('Hà Nội', $address->city);
    }

    public function test_user_cannot_update_another_users_address(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $address = Address::create([
            'user_id' => $user1->id,
            'recipient_name' => 'User 1 Name',
            'phone' => '0901234567',
            'address_line' => '123 Đường',
            'city' => 'Hồ Chí Minh',
            'is_default' => true,
        ]);

        $response = $this->actingAs($user2)->patch("/account/addresses/{$address->id}", [
            'recipient_name' => 'Attacker Name',
            'phone' => '0909999999',
            'address_line' => 'Hacked Street',
            'city' => 'Hà Nội',
        ]);

        $response->assertForbidden();
        $address->refresh();
        $this->assertEquals('User 1 Name', $address->recipient_name);
    }

    public function test_user_can_set_another_address_as_default(): void
    {
        $user = User::factory()->create();

        $addr1 = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Address 1',
            'phone' => '0901111111',
            'address_line' => '111 Đường',
            'city' => 'Hồ Chí Minh',
            'is_default' => true,
        ]);

        $addr2 = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Address 2',
            'phone' => '0902222222',
            'address_line' => '222 Đường',
            'city' => 'Hà Nội',
            'is_default' => false,
        ]);

        $response = $this->actingAs($user)->patch("/account/addresses/{$addr2->id}/default");

        $response->assertRedirect(route('account.addresses.index'));

        $addr1->refresh();
        $addr2->refresh();

        $this->assertFalse($addr1->is_default);
        $this->assertTrue($addr2->is_default);
    }

    public function test_setting_default_clears_previous_default_maintaining_single_default_invariant(): void
    {
        $user = User::factory()->create();

        $addr1 = Address::create(['user_id' => $user->id, 'recipient_name' => 'A1', 'phone' => '0901', 'address_line' => 'L1', 'city' => 'C1', 'is_default' => true]);
        $addr2 = Address::create(['user_id' => $user->id, 'recipient_name' => 'A2', 'phone' => '0902', 'address_line' => 'L2', 'city' => 'C2', 'is_default' => false]);
        $addr3 = Address::create(['user_id' => $user->id, 'recipient_name' => 'A3', 'phone' => '0903', 'address_line' => 'L3', 'city' => 'C3', 'is_default' => false]);

        $this->actingAs($user)->patch("/account/addresses/{$addr3->id}/default");

        $this->assertEquals(1, $user->addresses()->where('is_default', true)->count());
        $this->assertTrue($addr3->fresh()->is_default);
        $this->assertFalse($addr1->fresh()->is_default);
        $this->assertFalse($addr2->fresh()->is_default);
    }

    public function test_user_can_delete_address(): void
    {
        $user = User::factory()->create();

        $addr1 = Address::create(['user_id' => $user->id, 'recipient_name' => 'A1', 'phone' => '0901', 'address_line' => 'L1', 'city' => 'C1', 'is_default' => true]);
        $addr2 = Address::create(['user_id' => $user->id, 'recipient_name' => 'A2', 'phone' => '0902', 'address_line' => 'L2', 'city' => 'C2', 'is_default' => false]);

        $response = $this->actingAs($user)->delete("/account/addresses/{$addr2->id}");

        $response->assertRedirect(route('account.addresses.index'));
        $this->assertDatabaseMissing('addresses', ['id' => $addr2->id]);
    }

    public function test_deleting_default_address_promotes_another_address_if_available(): void
    {
        $user = User::factory()->create();

        $addr1 = Address::create(['user_id' => $user->id, 'recipient_name' => 'A1', 'phone' => '0901', 'address_line' => 'L1', 'city' => 'C1', 'is_default' => true]);
        $addr2 = Address::create(['user_id' => $user->id, 'recipient_name' => 'A2', 'phone' => '0902', 'address_line' => 'L2', 'city' => 'C2', 'is_default' => false]);

        $this->actingAs($user)->delete("/account/addresses/{$addr1->id}");

        $this->assertDatabaseMissing('addresses', ['id' => $addr1->id]);
        $this->assertTrue($addr2->fresh()->is_default);
    }

    public function test_other_users_address_cannot_be_deleted(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $address = Address::create(['user_id' => $user1->id, 'recipient_name' => 'A1', 'phone' => '0901', 'address_line' => 'L1', 'city' => 'C1', 'is_default' => true]);

        $response = $this->actingAs($user2)->delete("/account/addresses/{$address->id}");

        $response->assertForbidden();
        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }

    // =========================================================================
    // 5. Checkout Integration Tests (Section 43)
    // =========================================================================

    public function test_default_address_prefills_checkout_for_logged_in_user(): void
    {
        $user = User::factory()->create(['name' => 'Linh Nguyễn', 'email' => 'linh@example.com']);
        $address = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Người Nhận Linh',
            'phone' => '0903334444',
            'address_line' => '789 Nam Kỳ Khởi Nghĩa',
            'city' => 'Hồ Chí Minh',
            'is_default' => true,
        ]);

        $product = Product::query()->where('sku', 'LNS-NH001')->firstOrFail();

        $this->actingAs($user)->postJson('/cart/items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ])->assertOk();

        $response = $this->actingAs($user)->get('/checkout');

        $response->assertOk();
        $response->assertSee('Người Nhận Linh');
        $response->assertSee('0903334444');
        $response->assertSee('789 Nam Kỳ Khởi Nghĩa');
        $response->assertSee('linh@example.com');
    }

    public function test_guest_checkout_redirects_to_login_and_preserves_cart(): void
    {
        $product = Product::query()->where('sku', 'LNS-NH001')->firstOrFail();

        $this->postJson('/cart/items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ])->assertOk();

        $response = $this->get('/checkout');

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('cart_items', 1);
    }

    public function test_checkout_order_continues_snapshotting_address_instead_of_linking_dynamically(): void
    {
        $user = User::factory()->create();
        $address = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Tên Gốc',
            'phone' => '0901234567',
            'address_line' => '123 Đường Gốc',
            'city' => 'Hồ Chí Minh',
            'is_default' => true,
        ]);

        $product = Product::query()->where('sku', 'LNS-NH001')->firstOrFail();

        $this->actingAs($user)->postJson('/cart/items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ])->assertOk();

        $this->actingAs($user)->get('/checkout')->assertOk();
        $token = (string) session('checkout_token');

        $response = $this->actingAs($user)->post('/checkout', [
            'customer_name' => 'Tên Gốc',
            'customer_email' => $user->email,
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Đường Gốc',
            'shipping_city' => 'Hồ Chí Minh',
            'payment_method' => 'cod',
            'checkout_token' => $token,
        ]);

        $response->assertRedirect();
        $order = Order::where('user_id', $user->id)->first();
        $this->assertNotNull($order);
        $this->assertEquals('123 Đường Gốc', $order->shipping_address);

        // Later, user updates their address
        $address->update(['address_line' => '999 Đường Đã Sửa']);

        // Historical order shipping_address MUST NOT change
        $this->assertEquals('123 Đường Gốc', $order->fresh()->shipping_address);
    }

    // =========================================================================
    // 6. Order History Tests (Section 44)
    // =========================================================================

    public function test_user_sees_only_own_orders_in_history(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $order1 = $this->createOrderForUser($user1);
        $order2 = $this->createOrderForUser($user2);

        $response = $this->actingAs($user1)->get('/account/orders');

        $response->assertOk();
        $response->assertSee($order1->order_code);
        $response->assertDontSee($order2->order_code);
    }

    public function test_guest_orders_do_not_appear_in_user_order_history(): void
    {
        $user = User::factory()->create();
        $guestOrder = $this->createOrderForUser(null);

        $response = $this->actingAs($user)->get('/account/orders');

        $response->assertOk();
        $response->assertDontSee($guestOrder->order_code);
    }

    public function test_orders_are_sorted_newest_first(): void
    {
        $user = User::factory()->create();

        $olderOrder = $this->createOrderForUser($user, [
            'placed_at' => now()->subDays(5),
            'created_at' => now()->subDays(5),
        ]);
        $newerOrder = $this->createOrderForUser($user, [
            'placed_at' => now(),
            'created_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/account/orders');

        $response->assertOk();
        $content = $response->getContent();
        $newerPos = strpos($content, $newerOrder->order_code);
        $olderPos = strpos($content, $olderOrder->order_code);

        $this->assertNotFalse($newerPos);
        $this->assertNotFalse($olderPos);
        $this->assertTrue($newerPos < $olderPos, 'Newer order should appear before older order');
    }

    public function test_order_history_pagination_works(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 12; $i++) {
            $this->createOrderForUser($user, [
                'placed_at' => now()->subHours(12 - $i),
            ]);
        }

        $response = $this->actingAs($user)->get('/account/orders');
        $response->assertOk();
        $response->assertSee('page=2');

        $page2Response = $this->actingAs($user)->get('/account/orders?page=2');
        $page2Response->assertOk();
    }

    // =========================================================================
    // 7. Order Detail Tests (Section 45)
    // =========================================================================

    public function test_user_can_view_own_order_detail(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrderForUser($user);

        $response = $this->actingAs($user)->get("/account/orders/{$order->order_code}");

        $response->assertOk();
        $response->assertSee($order->order_code);
        $response->assertSee($order->customer_name);
        $response->assertSee($order->shipping_address);
    }

    public function test_user_cannot_view_another_users_order_detail(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $order1 = $this->createOrderForUser($user1);

        $response = $this->actingAs($user2)->get("/account/orders/{$order1->order_code}");

        $response->assertForbidden();
    }

    public function test_snapshot_name_sku_price_render_correctly_on_order_detail(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrderForUser($user);

        $response = $this->actingAs($user)->get("/account/orders/{$order->order_code}");

        $response->assertOk();
        $response->assertSee('Nhẫn Bạc Lunara Classic');
        $response->assertSee('LNS-NH001');
        $response->assertSee('550.000 ₫');
    }

    public function test_product_deleted_or_null_relation_does_not_break_history(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrderForUser($user);

        // Disassociate or delete product relation
        $item = $order->items->first();
        $item->update(['product_id' => null]);

        $response = $this->actingAs($user)->get("/account/orders/{$order->order_code}");

        $response->assertOk();
        $response->assertSee('Nhẫn Bạc Lunara Classic');
        $response->assertSee('LNS-NH001');
    }

    public function test_payment_information_renders_correctly_on_order_detail(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrderForUser($user);

        $response = $this->actingAs($user)->get("/account/orders/{$order->order_code}");

        $response->assertOk();
        $response->assertSee('Thanh toán khi nhận hàng (COD)');
        $response->assertSee('Chờ thanh toán');
        $response->assertSee('550.000 ₫');
    }
}
