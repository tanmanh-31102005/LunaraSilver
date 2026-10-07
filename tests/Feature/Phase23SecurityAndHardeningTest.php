<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\SupportConversation;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase23SecurityAndHardeningTest extends TestCase
{
    use RefreshDatabase;

    protected User $userA;

    protected User $userB;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->userA = User::factory()->create([
            'role' => User::ROLE_USER,
            'email' => 'usera@example.com',
        ]);

        $this->userB = User::factory()->create([
            'role' => User::ROLE_USER,
            'email' => 'userb@example.com',
        ]);

        $this->admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'email' => 'admin@lunara.com',
        ]);
    }

    private function createOrderForUser(?User $user, array $overrides = []): Order
    {
        $code = 'LNS-'.now()->format('Ymd').'-'.strtoupper(bin2hex(random_bytes(3)));

        return Order::create(array_merge([
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
    }

    public function test_security_headers_are_present_on_response(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $this->assertNotNull($response->headers->get('Content-Security-Policy'));
    }

    public function test_guest_cannot_access_account_routes(): void
    {
        $response = $this->get(route('account.dashboard'));
        $response->assertRedirect(route('login'));

        $ordersResponse = $this->get(route('account.orders.index'));
        $ordersResponse->assertRedirect(route('login'));

        $addressesResponse = $this->get(route('account.addresses.index'));
        $addressesResponse->assertRedirect(route('login'));
    }

    public function test_normal_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->userA)->get(route('admin.dashboard'));
        $response->assertForbidden();
    }

    public function test_user_cannot_view_another_users_order_idor_protection(): void
    {
        $orderA = $this->createOrderForUser($this->userA, [
            'order_status' => Order::STATUS_COMPLETED,
        ]);

        // User A can access own order
        $responseA = $this->actingAs($this->userA)->get(route('account.orders.show', $orderA->order_code));
        $responseA->assertOk();

        // User B attempting to view User A order receives 403 Forbidden
        $responseB = $this->actingAs($this->userB)->get(route('account.orders.show', $orderA->order_code));
        $responseB->assertForbidden();
    }

    public function test_user_cannot_update_or_delete_another_users_address_idor_protection(): void
    {
        $addressA = Address::create([
            'user_id' => $this->userA->id,
            'recipient_name' => 'User A',
            'phone' => '0901234567',
            'address_line' => '123 Test Street',
            'city' => 'TP. Hồ Chí Minh',
            'is_default' => true,
        ]);

        // User B attempts to update User A address
        $responseUpdate = $this->actingAs($this->userB)->patch(route('account.addresses.update', $addressA->id), [
            'recipient_name' => 'Hacked Name',
            'phone' => '0987654321',
            'address_line' => '456 Hack Street',
            'city' => 'Hà Nội',
        ]);
        $responseUpdate->assertForbidden();

        // User B attempts to delete User A address
        $responseDelete = $this->actingAs($this->userB)->delete(route('account.addresses.destroy', $addressA->id));
        $responseDelete->assertForbidden();
    }

    public function test_user_cannot_review_order_item_from_another_user(): void
    {
        $orderA = $this->createOrderForUser($this->userA, [
            'order_status' => Order::STATUS_COMPLETED,
        ]);

        $product = Product::query()->active()->firstOrFail();

        $itemA = OrderItem::create([
            'order_id' => $orderA->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'unit_price' => $product->regular_price,
            'quantity' => 1,
            'subtotal' => $product->regular_price,
        ]);

        // User B cannot access create review for User A item
        $responseB = $this->actingAs($this->userB)->get(route('account.reviews.create', $itemA->id));
        $responseB->assertForbidden();
    }

    public function test_user_cannot_access_another_users_support_chat(): void
    {
        $conversationA = SupportConversation::create([
            'user_id' => $this->userA->id,
            'customer_name' => $this->userA->name,
            'customer_email' => $this->userA->email,
            'status' => SupportConversation::STATUS_OPEN,
            'last_message_at' => now(),
        ]);

        // User B attempting to fetch messages receives 403 Forbidden
        $responseB = $this->actingAs($this->userB)->get(route('support.chat.messages', $conversationA->reference));
        $responseB->assertForbidden();
    }

    public function test_non_admin_cannot_change_order_status_or_refund(): void
    {
        $order = $this->createOrderForUser($this->userA);

        $responseStatus = $this->actingAs($this->userA)->patch(route('admin.orders.status', $order->order_code), [
            'status' => 'processing',
        ]);
        $responseStatus->assertForbidden();

        $responseRefund = $this->actingAs($this->userA)->post(route('admin.orders.refund', $order->order_code), [
            'amount' => 50000,
            'reason' => 'Unauthorized refund attempt',
        ]);
        $responseRefund->assertForbidden();
    }

    public function test_client_cannot_escalate_role_on_registration(): void
    {
        $response = $this->post('/register', [
            'name' => 'Sneaky User',
            'email' => 'sneaky@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
            'role' => 'admin',
        ]);

        $response->assertRedirect();

        $registered = User::where('email', 'sneaky@example.com')->firstOrFail();
        $this->assertSame(User::ROLE_USER, $registered->role);
        $this->assertFalse($registered->isAdmin());
    }

    public function test_search_query_xss_is_escaped(): void
    {
        $malicious = '<script>alert("xss")</script>';
        $response = $this->get('/search?q='.urlencode($malicious));

        $response->assertOk();
        $this->assertStringNotContainsString('<script>alert("xss")</script>', $response->getContent());
        $response->assertSee(e($malicious), false);
    }

    public function test_post_sanitization_strips_dangerous_tags_and_events(): void
    {
        $rawHtml = '<p>Normal text</p><script>alert("pwned")</script><img src="x" onerror="alert(1)"><a href="javascript:alert(1)">Click</a>';
        $cleaned = Post::sanitizeHtml($rawHtml);

        $this->assertStringNotContainsString('<script>', $cleaned);
        $this->assertStringNotContainsString('onerror', $cleaned);
        $this->assertStringNotContainsString('javascript:', $cleaned);
        $this->assertStringContainsString('<p>Normal text</p>', $cleaned);
    }

    public function test_custom_error_pages_render_without_stack_traces(): void
    {
        $response404 = $this->get('/non-existent-route-404-check');
        $response404->assertNotFound();
        $response404->assertSee('Không tìm thấy trang');
        $response404->assertSee('404');
        $this->assertStringNotContainsString('Stack trace:', $response404->getContent());
    }
}
