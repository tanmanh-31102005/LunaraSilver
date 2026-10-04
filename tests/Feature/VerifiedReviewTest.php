<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\StructuredDataService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifiedReviewTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private User $admin;

    private Category $category;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Nguyễn Văn Mạnh',
            'email' => 'manh.customer@example.com',
            'role' => User::ROLE_USER,
        ]);

        $this->admin = User::factory()->create([
            'name' => 'Lunara Admin',
            'email' => 'admin@lunarasilver.test',
            'role' => User::ROLE_ADMIN,
        ]);

        $this->category = Category::create([
            'name' => 'Nhẫn Bạc Ý',
            'slug' => 'nhan-bac-y',
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'name' => 'Nhẫn Bạc Nữ Tinh Khôi S925',
            'slug' => 'nhan-bac-nu-tinh-khoi-s925',
            'sku' => 'LNR-RNG-VERIFIED-01',
            'product_type' => 'single',
            'category_id' => $this->category->id,
            'regular_price' => 450000,
            'sale_price' => 399000,
            'stock_quantity' => 15,
            'stock_status' => 'in_stock',
            'is_active' => true,
        ]);
    }

    private function createOrderWithProduct(User $user, Product $product, string $status = 'completed'): OrderItem
    {
        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'LNS-REV-'.uniqid(),
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '0987654321',
            'shipping_address' => '123 Đường Hoa Lan, P.2, Phú Nhuận',
            'shipping_city' => 'TP. Hồ Chí Minh',
            'shipping_method' => 'standard',
            'subtotal' => 399000,
            'discount_amount' => 0,
            'shipping_fee' => 0,
            'grand_total' => 399000,
            'payment_method' => 'cod',
            'payment_status' => $status === 'completed' ? 'paid' : 'pending',
            'order_status' => $status,
        ]);

        return OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'unit_price' => 399000,
            'quantity' => 1,
            'subtotal' => 399000,
        ]);
    }

    public function test_guest_redirected_to_login_when_submitting_review(): void
    {
        $response = $this->post(route('reviews.store', $this->product), [
            'rating' => 5,
            'content' => 'Sản phẩm rất đẹp và sáng bóng!',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_user_without_completed_order_cannot_submit_review(): void
    {
        // Authenticated user with no orders
        $response = $this->actingAs($this->user)->post(route('reviews.store', $this->product), [
            'rating' => 5,
            'title' => 'Rất hài lòng',
            'content' => 'Nhẫn rất đẹp, đóng gói cẩn thận!',
        ]);

        $response->assertSessionHasErrors(['product_id']);
        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_user_with_uncompleted_order_cannot_submit_review(): void
    {
        // Order exists but is still in 'processing' state
        $this->createOrderWithProduct($this->user, $this->product, 'processing');

        $response = $this->actingAs($this->user)->post(route('reviews.store', $this->product), [
            'rating' => 5,
            'title' => 'Chưa nhận được nhưng muốn đánh giá trước',
            'content' => 'Nhìn trên ảnh đẹp quá!',
        ]);

        $response->assertSessionHasErrors(['product_id']);
        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_verified_buyer_can_submit_review_successfully(): void
    {
        $orderItem = $this->createOrderWithProduct($this->user, $this->product, 'completed');

        $response = $this->actingAs($this->user)->post(route('reviews.store', $this->product), [
            'order_item_id' => $orderItem->id,
            'rating' => 5,
            'title' => 'Nhẫn sáng đẹp hoàn hảo',
            'content' => 'Nhẫn bạc S925 rất sáng, đeo vừa tay, hộp đựng sang trọng. Rất đáng tiền!',
            'return_to' => 'account',
        ]);

        $response->assertSessionHas('success');
        $response->assertRedirect(route('account.reviews.index', ['tab' => 'reviewed']));
        $this->assertDatabaseHas('reviews', [
            'product_id' => $this->product->id,
            'user_id' => $this->user->id,
            'order_item_id' => $orderItem->id,
            'rating' => 5,
            'title' => 'Nhẫn sáng đẹp hoàn hảo',
            'verified_purchase' => true,
            'status' => 'pending',
        ]);
    }

    public function test_user_cannot_review_same_order_item_twice(): void
    {
        $orderItem = $this->createOrderWithProduct($this->user, $this->product, 'completed');

        // First review
        $this->actingAs($this->user)->post(route('reviews.store', $this->product), [
            'order_item_id' => $orderItem->id,
            'rating' => 5,
            'content' => 'Đánh giá lần đầu tiên thành công!',
        ])->assertSessionHas('success');

        $this->assertDatabaseCount('reviews', 1);

        // Visiting create page for already reviewed item should redirect gracefully to reviewed tab (no 403)
        $this->actingAs($this->user)->get(route('account.reviews.create', $orderItem))
            ->assertRedirect(route('account.reviews.index', ['tab' => 'reviewed']))
            ->assertSessionHas('info');

        // Second review for the same purchase
        $response = $this->actingAs($this->user)->post(route('reviews.store', $this->product), [
            'order_item_id' => $orderItem->id,
            'rating' => 4,
            'content' => 'Cố tình gửi đánh giá lần thứ hai cho cùng đơn hàng.',
        ]);

        $response->assertSessionHasErrors(['product_id']);
        $this->assertDatabaseCount('reviews', 1);
    }

    public function test_review_validation_rules(): void
    {
        $orderItem = $this->createOrderWithProduct($this->user, $this->product, 'completed');

        // Missing rating and empty content
        $response = $this->actingAs($this->user)->post(route('reviews.store', $this->product), [
            'order_item_id' => $orderItem->id,
            'rating' => '',
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['rating', 'content']);

        // Rating out of bounds (6 stars)
        $response2 = $this->actingAs($this->user)->post(route('reviews.store', $this->product), [
            'order_item_id' => $orderItem->id,
            'rating' => 6,
            'content' => 'Nội dung hợp lệ nhưng số sao sai.',
        ]);

        $response2->assertSessionHasErrors(['rating']);
    }

    public function test_pending_review_not_visible_on_product_page_until_approved(): void
    {
        $orderItem = $this->createOrderWithProduct($this->user, $this->product, 'completed');

        $review = Review::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'order_item_id' => $orderItem->id,
            'rating' => 5,
            'title' => 'Chất lượng xuất sắc',
            'content' => 'Chiếc nhẫn bạc Lunara này vượt mong đợi của tôi!',
            'verified_purchase' => true,
            'status' => 'pending',
        ]);

        // Storefront product detail should not show pending review content
        $response = $this->get(route('products.show', $this->product));
        $response->assertOk();
        $response->assertSee('Chưa có đánh giá');
        $response->assertDontSee('Chiếc nhẫn bạc Lunara này vượt mong đợi của tôi!');

        // Admin approves review
        $this->actingAs($this->admin)->post(route('admin.reviews.approve', $review))
            ->assertRedirect();

        $this->assertEquals('approved', $review->fresh()->status);

        // Storefront product detail now shows review and masked name
        $responseAfterApproval = $this->get(route('products.show', $this->product));
        $responseAfterApproval->assertOk();
        $responseAfterApproval->assertSee('Chiếc nhẫn bạc Lunara này vượt mong đợi của tôi!');
        $responseAfterApproval->assertSee('5.0');
        $responseAfterApproval->assertSee('(1)');
        $responseAfterApproval->assertSee('đánh giá thực tế');
        // Masked name for 'Nguyễn Văn Mạnh' -> 'Nguyễn M.'
        $responseAfterApproval->assertSee('Nguyễn M.');
        // Never expose email
        $responseAfterApproval->assertDontSee('manh.customer@example.com');
    }

    public function test_customer_name_masking_privacy(): void
    {
        $review1 = new Review(['user_id' => $this->user->id]);
        $review1->setRelation('user', new User(['name' => 'Nguyễn Văn Mạnh', 'email' => 'test@test.com']));
        $this->assertEquals('Nguyễn M.', $review1->masked_user_name);

        $review2 = new Review(['user_id' => $this->user->id]);
        $review2->setRelation('user', new User(['name' => 'Trần Thị Thu Hà', 'email' => 'ha@test.com']));
        $this->assertEquals('Trần H.', $review2->masked_user_name);

        $review3 = new Review(['user_id' => $this->user->id]);
        $review3->setRelation('user', new User(['name' => 'Lan', 'email' => 'lan@test.com']));
        $this->assertEquals('L*n', $review3->masked_user_name);
    }

    public function test_merchant_reply_displays_on_product_detail(): void
    {
        $orderItem = $this->createOrderWithProduct($this->user, $this->product, 'completed');

        $review = Review::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'order_item_id' => $orderItem->id,
            'rating' => 5,
            'title' => 'Rất hài lòng',
            'content' => 'Dịch vụ giao hàng nhanh và chu đáo.',
            'verified_purchase' => true,
            'status' => 'approved',
        ]);

        // Admin replies to review
        $this->actingAs($this->admin)->post(route('admin.reviews.reply', $review), [
            'admin_reply' => 'Cảm ơn bạn Mạnh đã tin chọn Lunara Silver! Chúc bạn luôn rạng rỡ.',
        ])->assertRedirect();

        $freshReview = $review->fresh();
        $this->assertEquals('Cảm ơn bạn Mạnh đã tin chọn Lunara Silver! Chúc bạn luôn rạng rỡ.', $freshReview->admin_reply);
        $this->assertEquals($this->admin->id, $freshReview->admin_replied_by);

        // Storefront product detail displays merchant reply
        $response = $this->get(route('products.show', $this->product));
        $response->assertOk();
        $response->assertSee('Phản hồi từ Lunara Silver');
        $response->assertSee('Cảm ơn bạn Mạnh đã tin chọn Lunara Silver! Chúc bạn luôn rạng rỡ.');
    }

    public function test_product_card_shows_star_badge_only_when_approved_reviews_exist(): void
    {
        // 0 approved reviews -> product list should not show rating badge for this product
        $responseBefore = $this->get(route('products.index'));
        $responseBefore->assertOk();
        $responseBefore->assertDontSee('aria-label="Đánh giá:', false);

        // Add approved review
        $orderItem = $this->createOrderWithProduct($this->user, $this->product, 'completed');
        Review::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'order_item_id' => $orderItem->id,
            'rating' => 5,
            'content' => 'Tuyệt tác trang sức bạc S925!',
            'verified_purchase' => true,
            'status' => 'approved',
        ]);

        // Product list should now show rating badge
        $responseAfter = $this->get(route('products.index'));
        $responseAfter->assertOk();
        $responseAfter->assertSee('aria-label="Đánh giá: 5/5 sao (1 lượt)"', false);
        $responseAfter->assertSee('(1)');
    }

    public function test_account_review_center_tabs(): void
    {
        $orderItem = $this->createOrderWithProduct($this->user, $this->product, 'completed');

        // Initially in "Chờ đánh giá"
        $response = $this->actingAs($this->user)->get(route('account.reviews.index', ['tab' => 'pending']));
        $response->assertOk();
        $response->assertSee($this->product->name);
        $response->assertSee(route('account.reviews.create', $orderItem));

        // Submit review
        Review::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'order_item_id' => $orderItem->id,
            'rating' => 5,
            'content' => 'Đã đánh giá xong món trang sức này.',
            'verified_purchase' => true,
            'status' => 'pending',
        ]);

        // Now "Chờ đánh giá" should show empty state
        $responsePending = $this->actingAs($this->user)->get(route('account.reviews.index', ['tab' => 'pending']));
        $responsePending->assertOk();
        $responsePending->assertSee('Bạn không có sản phẩm nào chờ đánh giá');

        $responseReviewed = $this->actingAs($this->user)->get(route('account.reviews.index', ['tab' => 'reviewed']));
        $responseReviewed->assertOk();
        $responseReviewed->assertSee('Đã đánh giá xong món trang sức này.');
    }

    public function test_admin_can_moderate_and_delete_reviews(): void
    {
        $orderItem = $this->createOrderWithProduct($this->user, $this->product, 'completed');

        $review = Review::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'order_item_id' => $orderItem->id,
            'rating' => 2,
            'content' => 'Giao hàng hơi chậm so với dự kiến.',
            'verified_purchase' => true,
            'status' => 'pending',
        ]);

        // Admin index
        $response = $this->actingAs($this->admin)->get(route('admin.reviews.index'));
        $response->assertOk();
        $response->assertSee('Giao hàng hơi chậm so với dự kiến.');

        // Admin rejects review with reason
        $this->actingAs($this->admin)->post(route('admin.reviews.reject', $review), [
            'rejection_reason' => 'Nội dung phản ánh dịch vụ vận chuyển thay vì chất lượng sản phẩm.',
        ])->assertRedirect();

        $fresh = $review->fresh();
        $this->assertEquals('rejected', $fresh->status);
        $this->assertEquals('Nội dung phản ánh dịch vụ vận chuyển thay vì chất lượng sản phẩm.', $fresh->rejection_reason);

        // Admin deletes review
        $this->actingAs($this->admin)->delete(route('admin.reviews.destroy', $review))
            ->assertRedirect();

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    public function test_seo_aggregate_rating_conditional_in_product_schema(): void
    {
        $structuredDataService = app(StructuredDataService::class);

        // Case 1: 0 approved reviews -> no aggregateRating in schema
        $schemaWithoutReviews = $structuredDataService->productSchema($this->product);
        $this->assertArrayNotHasKey('aggregateRating', $schemaWithoutReviews);
        $this->assertArrayNotHasKey('review', $schemaWithoutReviews);

        // Case 2: 1 approved review -> includes aggregateRating and review
        $orderItem = $this->createOrderWithProduct($this->user, $this->product, 'completed');
        Review::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'order_item_id' => $orderItem->id,
            'rating' => 5,
            'title' => 'Rất hài lòng',
            'content' => 'Nhẫn bạc S925 tuyệt đẹp!',
            'verified_purchase' => true,
            'status' => 'approved',
        ]);

        $this->product->refresh();
        $schemaWithReviews = $structuredDataService->productSchema($this->product);

        $this->assertArrayHasKey('aggregateRating', $schemaWithReviews);
        $this->assertEquals(5, $schemaWithReviews['aggregateRating']['ratingValue']);
        $this->assertEquals(1, $schemaWithReviews['aggregateRating']['reviewCount']);
        $this->assertArrayHasKey('review', $schemaWithReviews);
        $this->assertCount(1, $schemaWithReviews['review']);
        $this->assertEquals('Nguyễn M.', $schemaWithReviews['review'][0]['author']['name']);
    }

    public function test_gift_experience_adds_gift_note_to_cart_and_snapshots_to_order_item(): void
    {
        $giftProduct = Product::create([
            'name' => 'Hộp Quà Trang Sức Sang Trọng',
            'slug' => 'hop-qua-trang-suc-sang-trong',
            'sku' => 'GIFT-BOX-01',
            'product_type' => 'gift',
            'category_id' => $this->category->id,
            'regular_price' => 150000,
            'stock_quantity' => 10,
            'stock_status' => 'in_stock',
            'is_active' => true,
        ]);

        $giftProduct->bundleItems()->create([
            'component_product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $cartService = app(CartService::class);
        $cart = $cartService->currentCart($this->user, null, true);
        $giftMessage = 'Chúc em gái sinh nhật vui vẻ và luôn tỏa sáng cùng Lunara!';

        // Add to cart with gift message
        $summary = $cartService->add($cart, $giftProduct->id, 1, $giftMessage);
        $this->assertEquals(1, $summary['cart_count']);

        // Cart summary contains gift message
        $this->assertNotEmpty($summary['items']);
        $this->assertEquals($giftMessage, $summary['items'][0]['gift_message']);

        // Checkout snapshots to order_items
        $checkoutService = app(CheckoutService::class);
        $order = $checkoutService->processCheckout($cart, $this->user, [
            'customer_name' => 'Nguyễn Văn Mạnh',
            'customer_email' => 'manh.customer@example.com',
            'customer_phone' => '0987654321',
            'shipping_address' => '123 Đường Hoa Lan, P.2, Phú Nhuận',
            'shipping_city' => 'TP. Hồ Chí Minh',
            'shipping_method' => 'standard',
            'payment_method' => 'cod',
        ]);

        $createdOrderItem = $order->items()->first();
        $this->assertNotNull($createdOrderItem);
        $this->assertEquals($giftMessage, $createdOrderItem->gift_message);
    }
}
