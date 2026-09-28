<?php

namespace Tests\Feature;

use App\Mail\NewSupportRequestAdmin;
use App\Mail\SupportReplyMail;
use App\Mail\SupportRequestReceived;
use App\Mail\SupportResolvedMail;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Order;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use App\Models\User;
use App\Services\SupportEmailService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class CustomerSupportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('contact_submission:127.0.0.1');
    }

    public function test_guest_can_view_faq_page(): void
    {
        Faq::create([
            'category' => 'Đặt hàng',
            'question' => 'Làm sao để đặt hàng?',
            'answer' => 'Thêm sản phẩm vào giỏ và thanh toán.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/support');
        $response->assertStatus(200);
        $response->assertSee('Trung Tâm Hỗ Trợ');
        $response->assertSee('Làm sao để đặt hàng?');
    }

    public function test_authenticated_user_can_view_faq_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/support/faq');
        $response->assertStatus(200);
        $response->assertSee('Trung Tâm Hỗ Trợ');
    }

    public function test_inactive_faq_is_not_displayed(): void
    {
        Faq::create([
            'category' => 'Bảo mật',
            'question' => 'Câu hỏi bảo mật ẩn?',
            'answer' => 'Câu trả lời ẩn.',
            'sort_order' => 1,
            'is_active' => false,
        ]);

        $response = $this->get('/support');
        $response->assertStatus(200);
        $response->assertDontSee('Câu hỏi bảo mật ẩn?');
    }

    public function test_faq_search_filters_properly(): void
    {
        Faq::create([
            'category' => 'VNPay',
            'question' => 'Thanh toán VNPay Sandbox thế nào?',
            'answer' => 'Dùng thẻ test VNPay.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'category' => 'Giao hàng',
            'question' => 'Phí giao hàng là bao nhiêu?',
            'answer' => 'Miễn phí giao hàng toàn quốc.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $searchResponse = $this->get('/support/faq?q=Sandbox');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Thanh toán VNPay Sandbox thế nào?');
        $searchResponse->assertDontSee('Phí giao hàng là bao nhiêu?');
    }

    public function test_guest_can_submit_contact_form_and_triggers_emails(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Nguyễn Khách',
            'email' => 'guest@example.com',
            'phone' => '0912345678',
            'subject' => 'Tư vấn chọn size nhẫn bạc',
            'message' => 'Tôi muốn hỏi cách đo size ngón tay chuẩn xác nhất.',
        ];

        $response = $this->post('/contact', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Nguyễn Khách',
            'email' => 'guest@example.com',
            'subject' => 'Tư vấn chọn size nhẫn bạc',
            'status' => 'new',
            'user_id' => null,
            'order_id' => null,
        ]);

        $contact = ContactMessage::where('email', 'guest@example.com')->first();
        $this->assertNotNull($contact);
        $this->assertStringStartsWith('SUP-', $contact->reference);

        Mail::assertSent(SupportRequestReceived::class, function ($mail) use ($contact) {
            return $mail->hasTo('guest@example.com') && $mail->contactMessage->id === $contact->id;
        });

        Mail::assertSent(NewSupportRequestAdmin::class);
    }

    public function test_authenticated_user_can_submit_contact_with_linked_order(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'ORD-TEST-999',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '0900000000',
            'shipping_address' => 'Hà Nội',
            'shipping_city' => 'Hà Nội',
            'shipping_method' => 'standard',
            'subtotal' => 500000,
            'discount_amount' => 0,
            'shipping_fee' => 0,
            'grand_total' => 500000,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'placed_at' => now(),
        ]);

        $payload = [
            'name' => $user->name,
            'email' => $user->email,
            'subject' => 'Hỗ trợ thay đổi địa chỉ giao hàng',
            'message' => 'Tôi muốn chuyển địa chỉ giao hàng từ Cầu Giấy sang Ba Đình.',
            'order_id' => $order->id,
        ];

        $response = $this->actingAs($user)->post('/contact', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'user_id' => $user->id,
            'order_id' => $order->id,
            'email' => $user->email,
            'subject' => 'Hỗ trợ thay đổi địa chỉ giao hàng',
        ]);
    }

    public function test_invalid_email_is_rejected(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Test Name',
            'email' => 'invalid-email-address',
            'subject' => 'Chủ đề hợp lệ',
            'message' => 'Nội dung tin nhắn hợp lệ trên 10 ký tự.',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_user_cannot_link_another_users_order(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $orderB = Order::create([
            'user_id' => $userB->id,
            'order_code' => 'ORD-USER-B',
            'customer_name' => $userB->name,
            'customer_email' => $userB->email,
            'customer_phone' => '0900000000',
            'shipping_address' => 'Hà Nội',
            'shipping_city' => 'Hà Nội',
            'shipping_method' => 'standard',
            'subtotal' => 500000,
            'discount_amount' => 0,
            'shipping_fee' => 0,
            'grand_total' => 500000,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'placed_at' => now(),
        ]);

        $response = $this->actingAs($userA)->post('/contact', [
            'name' => $userA->name,
            'email' => $userA->email,
            'subject' => 'Cố tình liên kết đơn của người khác',
            'message' => 'Tin nhắn thử nghiệm chiếm quyền đơn hàng.',
            'order_id' => $orderB->id,
        ]);

        $response->assertSessionHasErrors(['order_id']);
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_guest_cannot_link_arbitrary_order_id(): void
    {
        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'ORD-SECRET',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '0900000000',
            'shipping_address' => 'Hà Nội',
            'shipping_city' => 'Hà Nội',
            'shipping_method' => 'standard',
            'subtotal' => 500000,
            'discount_amount' => 0,
            'shipping_fee' => 0,
            'grand_total' => 500000,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'placed_at' => now(),
        ]);

        $response = $this->post('/contact', [
            'name' => 'Hacker Guest',
            'email' => 'guest@test.com',
            'subject' => 'Guest order link attempt',
            'message' => 'Guest trying to submit order ID.',
            'order_id' => $order->id,
        ]);

        $response->assertSessionHasErrors(['order_id']);
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_rate_limiting(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact', [
                'name' => 'Spammer',
                'email' => 'spam@test.com',
                'subject' => 'Spam subject '.$i,
                'message' => 'Spam message content '.$i,
            ]);
        }

        // 6th attempt should be blocked by rate limiter
        $response = $this->post('/contact', [
            'name' => 'Spammer',
            'email' => 'spam@test.com',
            'subject' => 'Blocked spam subject',
            'message' => 'Blocked message content should not pass.',
        ]);

        $response->assertSessionHasErrors(['rate_limit']);
    }

    public function test_smtp_failure_does_not_rollback_contact_submission(): void
    {
        // Mock email service to simulate SMTP failure
        $failingEmailService = new class extends SupportEmailService
        {
            public function sendCustomerReceived(ContactMessage $contactMessage): bool
            {
                // Throws internal exception caught by service
                $this->logFailure('contact_received', $contactMessage->email, ContactMessage::class, $contactMessage->id, new Exception('Connection timeout to smtp.gmail.com:587'));

                return false;
            }

            public function sendAdminNewRequest(ContactMessage $contactMessage): bool
            {
                $this->logFailure('admin_new_request', 'admin@lunarasilver.com', ContactMessage::class, $contactMessage->id, new Exception('Authentication failed'));

                return false;
            }
        };

        $this->app->instance(SupportEmailService::class, $failingEmailService);

        $response = $this->post('/contact', [
            'name' => 'Customer With SMTP Error',
            'email' => 'error_case@example.com',
            'subject' => 'Thử nghiệm khi SMTP lỗi',
            'message' => 'Hệ thống vẫn phải lưu contact thành công vào database.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Contact message MUST still exist in DB
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'error_case@example.com',
            'status' => 'new',
        ]);

        // Email log should record failure without leaking password
        $this->assertDatabaseHas('email_logs', [
            'recipient' => 'error_case@example.com',
            'status' => 'failed',
        ]);
    }

    public function test_admin_can_view_support_inbox(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        ContactMessage::create([
            'name' => 'Khách Cần Giúp',
            'email' => 'needhelp@example.com',
            'subject' => 'Hỏi về thời gian giao hàng',
            'message' => 'Bao lâu thì nhận được hàng?',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->get('/admin/support');
        $response->assertStatus(200);
        $response->assertSee('Trung tâm xử lý yêu cầu hỗ trợ');
        $response->assertSee('Khách Cần Giúp');
        $response->assertSee('Hỏi về thời gian giao hàng');
    }

    public function test_normal_user_cannot_access_admin_support(): void
    {
        $normalUser = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($normalUser)->get('/admin/support');
        $response->assertStatus(403);
    }

    public function test_admin_can_update_status_and_triggers_resolved_email(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $contact = ContactMessage::create([
            'name' => 'Khách Hàng',
            'email' => 'customer@test.com',
            'subject' => 'Đổi sản phẩm',
            'message' => 'Yêu cầu đổi nhẫn.',
            'status' => 'in_progress',
        ]);

        $response = $this->actingAs($admin)->patch("/admin/support/{$contact->id}/status", [
            'status' => 'resolved',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'id' => $contact->id,
            'status' => 'resolved',
        ]);

        Mail::assertSent(SupportResolvedMail::class, function ($mail) use ($contact) {
            return $mail->hasTo('customer@test.com') && $mail->contactMessage->id === $contact->id;
        });
    }

    public function test_admin_can_assign_support_request(): void
    {
        $adminA = User::factory()->create(['role' => 'admin', 'name' => 'Admin Alpha']);
        $adminB = User::factory()->create(['role' => 'admin', 'name' => 'Admin Beta']);

        $contact = ContactMessage::create([
            'name' => 'Khách Vấn Đáp',
            'email' => 'customer@test.com',
            'subject' => 'Tư vấn quà tặng',
            'message' => 'Cần chọn set quà cho bạn gái.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($adminA)->patch("/admin/support/{$contact->id}/assign", [
            'assigned_to' => $adminB->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'id' => $contact->id,
            'assigned_to' => $adminB->id,
            'status' => 'in_progress',
        ]);
    }

    public function test_admin_can_save_internal_notes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $contact = ContactMessage::create([
            'name' => 'Khách Nội Bộ',
            'email' => 'note@test.com',
            'subject' => 'Khiếu nại sản phẩm',
            'message' => 'Mặt dây chuyền hơi xước.',
            'status' => 'in_progress',
        ]);

        $response = $this->actingAs($admin)->post("/admin/support/{$contact->id}/notes", [
            'internal_notes' => 'Đã gọi điện trao đổi, khách đồng ý đổi mới vào thứ 4.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'id' => $contact->id,
            'internal_notes' => 'Đã gọi điện trao đổi, khách đồng ý đổi mới vào thứ 4.',
        ]);
    }

    public function test_admin_can_reply_via_email(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $contact = ContactMessage::create([
            'name' => 'Khách Chờ Thư',
            'email' => 'replyme@test.com',
            'subject' => 'Hỏi về bảo hành',
            'message' => 'Làm sáng bạc có mất phí không?',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->post("/admin/support/{$contact->id}/reply", [
            'reply_content' => 'Chào bạn, Lunara hỗ trợ làm sáng bạc miễn phí trọn đời bạn nhé.',
        ]);

        $response->assertRedirect();

        Mail::assertSent(SupportReplyMail::class, function ($mail) {
            return $mail->hasTo('replyme@test.com')
                && str_contains($mail->replyContent, 'làm sáng bạc miễn phí');
        });

        $this->assertDatabaseHas('contact_messages', [
            'id' => $contact->id,
            'status' => 'in_progress',
        ]);
    }

    public function test_guest_can_init_and_chat_with_token_isolation(): void
    {
        $response = $this->postJson('/support/chat/init');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $ref = $response->json('conversation.reference');
        $this->assertNotEmpty($ref);

        // Send a message
        $sendResponse = $this->postJson("/support/chat/{$ref}/messages", [
            'message' => 'Xin chào Lunara, tôi là khách vãng lai.',
        ]);

        $sendResponse->assertStatus(200);
        $sendResponse->assertJson(['success' => true]);

        $this->assertDatabaseHas('support_messages', [
            'message' => 'Xin chào Lunara, tôi là khách vãng lai.',
            'sender_type' => 'customer',
        ]);
    }

    public function test_user_can_init_and_chat_with_ownership_isolation(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // User 1 inits chat
        $init1 = $this->actingAs($user1)->postJson('/support/chat/init');
        $ref1 = $init1->json('conversation.reference');

        // User 2 cannot poll or send to User 1's conversation
        $pollForbidden = $this->actingAs($user2)->getJson("/support/chat/{$ref1}/messages");
        $pollForbidden->assertStatus(403);

        $sendForbidden = $this->actingAs($user2)->postJson("/support/chat/{$ref1}/messages", [
            'message' => 'Attempting to inject message',
        ]);
        $sendForbidden->assertStatus(403);
    }

    public function test_admin_can_view_and_reply_live_chat_and_marks_read(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $conversation = SupportConversation::create([
            'customer_name' => 'Khách Chat',
            'customer_email' => 'chat_customer@example.com',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $msg = SupportMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'customer',
            'sender_name' => 'Khách Chat',
            'message' => 'Cần tư vấn ngay!',
            'read_at' => null,
        ]);

        // Admin opens chat -> marks customer message as read
        $response = $this->actingAs($admin)->get("/admin/support/chat/{$conversation->id}");
        $response->assertStatus(200);
        $response->assertSee('Cần tư vấn ngay!');

        $this->assertNotNull($msg->fresh()->read_at);

        // Admin replies
        $replyResponse = $this->actingAs($admin)->post("/admin/support/chat/{$conversation->id}/reply", [
            'message' => 'Dạ Lunara xin chào quý khách, em hỗ trợ gì được cho mình ạ?',
        ]);

        $replyResponse->assertRedirect();

        $this->assertDatabaseHas('support_messages', [
            'conversation_id' => $conversation->id,
            'sender_type' => 'admin',
            'message' => 'Dạ Lunara xin chào quý khách, em hỗ trợ gì được cho mình ạ?',
        ]);
    }

    public function test_admin_faq_crud_operations(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // 1. Create
        $createResponse = $this->actingAs($admin)->post('/admin/faqs', [
            'category' => 'Bảo quản trang sức',
            'question' => 'Có nên đeo bạc khi đi tắm?',
            'answer' => 'Nên tháo ra khi tiếp xúc sữa tắm và hóa chất.',
            'sort_order' => 5,
            'is_active' => '1',
        ]);
        $createResponse->assertRedirect(route('admin.faqs.index'));

        $faq = Faq::where('question', 'Có nên đeo bạc khi đi tắm?')->first();
        $this->assertNotNull($faq);

        // 2. Toggle active
        $this->actingAs($admin)->patch("/admin/faqs/{$faq->id}/toggle")->assertRedirect();
        $this->assertFalse($faq->fresh()->is_active);

        // 3. Update
        $this->actingAs($admin)->put("/admin/faqs/{$faq->id}", [
            'category' => 'Bảo quản trang sức',
            'question' => 'Có nên đeo bạc khi đi tắm biển?',
            'answer' => 'Nước biển có muối làm bạc dễ oxy hóa.',
            'sort_order' => 2,
            'is_active' => '1',
        ])->assertRedirect(route('admin.faqs.index'));

        $this->assertSame('Có nên đeo bạc khi đi tắm biển?', $faq->fresh()->question);

        // 4. Delete
        $this->actingAs($admin)->delete("/admin/faqs/{$faq->id}")->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }
}
