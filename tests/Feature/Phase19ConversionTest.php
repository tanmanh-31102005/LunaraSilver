<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Database\Seeders\BlogSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase19ConversionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->seed(BlogSeeder::class);
    }

    public function test_search_suggestions_returns_expected_structure(): void
    {
        $category = Category::where('slug', 'nhan')->firstOrFail();
        $product = Product::create([
            'name' => 'Nhẫn Bạc Ánh Trăng S925 Độc Quyền',
            'sku' => 'LNR-RNG-PHASE19',
            'slug' => 'nhan-bac-anh-trang-s925-doc-quyen',
            'category_id' => $category->id,
            'product_type' => 'single',
            'regular_price' => 750000,
            'is_active' => true,
            'stock_quantity' => 10,
        ]);

        $post = Post::create([
            'title' => 'Bí quyết chọn nhẫn bạc S925 tỏa sáng',
            'slug' => 'bi-quyet-chon-nhan-bac-s925-toa-sang',
            'status' => 'published',
            'published_at' => now()->subDay(),
            'content' => 'Nội dung bài viết về nhẫn bạc S925...',
        ]);

        // Inactive product should NOT appear
        Product::create([
            'name' => 'Nhẫn Bạc Khóa Ẩn Không Bán',
            'sku' => 'LNR-RNG-OLD',
            'slug' => 'nhan-bac-khoa-an-khong-ban',
            'category_id' => $category->id,
            'product_type' => 'single',
            'regular_price' => 500000,
            'is_active' => false,
            'stock_quantity' => 5,
        ]);

        // Draft post should NOT appear
        Post::create([
            'title' => 'Bản nháp bí mật về nhẫn bạc',
            'slug' => 'ban-nhap-bi-mat-ve-nhan-bac',
            'status' => 'draft',
            'content' => 'Draft content...',
        ]);

        $response = $this->getJson('/api/search/suggestions?q=nhẫn');

        $response->assertOk()
            ->assertJsonPath('query', 'nhẫn')
            ->assertJsonStructure([
                'query',
                'products',
                'categories',
                'posts',
                'total_matches',
            ]);

        $data = $response->json();
        $this->assertNotEmpty($data['products']);
        $this->assertNotEmpty($data['categories']);

        // Assert inactive is not in products
        $productNames = collect($data['products'])->pluck('name')->all();
        $this->assertNotContains('Nhẫn Bạc Khóa Ẩn Không Bán', $productNames);

        // Assert draft post is not in posts
        $postTitles = collect($data['posts'])->pluck('title')->all();
        $this->assertNotContains('Bản nháp bí mật về nhẫn bạc', $postTitles);
    }

    public function test_search_suggestions_requires_at_least_two_characters(): void
    {
        $response = $this->getJson('/api/search/suggestions?q=a');

        $response->assertOk()
            ->assertJson([
                'query' => 'a',
                'products' => [],
                'categories' => [],
                'posts' => [],
                'total_matches' => 0,
            ]);
    }

    public function test_search_results_page_has_noindex_and_renders_results(): void
    {
        $response = $this->get('/search?q=chuyền');

        $response->assertOk();
        // Phase 19.10: /search?q= must have noindex,follow
        $response->assertSee('<meta name="robots" content="noindex,follow">', false);
    }

    public function test_search_results_page_empty_state_shows_helpful_categories(): void
    {
        $response = $this->get('/search?q=tukhoakhongtontai123456');

        $response->assertOk();
        $response->assertSee('Không tìm thấy kết quả phù hợp cho');
        $response->assertSee('Dây chuyền');
        $response->assertSee('Nhẫn ánh trăng');
    }

    public function test_guest_can_toggle_wishlist_via_session(): void
    {
        $product = Product::where('is_active', true)->firstOrFail();

        // 1. Add to wishlist
        $res1 = $this->postJson("/wishlist/{$product->id}");
        $res1->assertOk()
            ->assertJson([
                'success' => true,
                'product_id' => $product->id,
                'added' => true,
                'count' => 1,
            ]);
        $this->assertEquals([$product->id], session('guest_wishlist'));

        // 2. Toggle off
        $res2 = $this->postJson("/wishlist/{$product->id}");
        $res2->assertOk()
            ->assertJson([
                'success' => true,
                'product_id' => $product->id,
                'added' => false,
                'count' => 0,
            ]);
        $this->assertEquals([], session('guest_wishlist'));
    }

    public function test_authenticated_user_persists_wishlist_in_database(): void
    {
        $user = User::factory()->create();
        $product = Product::where('is_active', true)->firstOrFail();

        $response = $this->actingAs($user)->postJson("/wishlist/{$product->id}");
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'added' => true,
                'count' => 1,
            ]);

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // Toggle removes
        $resToggle = $this->actingAs($user)->postJson("/wishlist/{$product->id}");
        $resToggle->assertOk()->assertJson(['added' => false, 'count' => 0]);

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_guest_wishlist_merges_into_user_wishlist_on_login(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);
        $products = Product::where('is_active', true)->take(2)->get();
        $product1 = $products[0];
        $product2 = $products[1];

        // User already has product1 in DB
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product1->id,
        ]);

        // Guest session has product1 (duplicate) and product2 (new)
        session(['guest_wishlist' => [$product1->id, $product2->id]]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        // Verify merge: user now has both product1 and product2 in DB without duplication
        $this->assertDatabaseCount('wishlists', 2);
        $this->assertDatabaseHas('wishlists', ['user_id' => $user->id, 'product_id' => $product1->id]);
        $this->assertDatabaseHas('wishlists', ['user_id' => $user->id, 'product_id' => $product2->id]);

        // Guest session wishlist cleared
        $this->assertNull(session('guest_wishlist'));
    }

    public function test_wishlist_page_renders_for_both_guest_and_authenticated_users(): void
    {
        $product = Product::where('is_active', true)->firstOrFail();

        // Guest view
        session(['guest_wishlist' => [$product->id]]);
        $guestRes = $this->get('/account/wishlist');
        $guestRes->assertOk();
        $guestRes->assertSee($product->name);
        $guestRes->assertSee('Đăng nhập');

        // Auth view
        $user = User::factory()->create();
        Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);

        $authRes = $this->actingAs($user)->get('/account/wishlist');
        $authRes->assertOk();
        $authRes->assertSee($product->name);
        $authRes->assertSee('Tài khoản của tôi');
    }

    public function test_out_of_stock_product_shows_stock_badge_in_wishlist(): void
    {
        $category = Category::firstOrFail();
        $product = Product::create([
            'name' => 'Nhẫn Tạm Hết Hàng Phase 19',
            'sku' => 'TEST-OOS-19',
            'slug' => 'nhan-tam-het-hang-phase-19',
            'category_id' => $category->id,
            'product_type' => 'single',
            'regular_price' => 550000,
            'is_active' => true,
            'stock_quantity' => 0,
        ]);

        session(['guest_wishlist' => [$product->id]]);
        $response = $this->get('/account/wishlist');

        $response->assertOk();
        $response->assertSee('Nhẫn Tạm Hết Hàng Phase 19');
        $response->assertSee('Tạm hết hàng');
    }

    public function test_recently_viewed_records_session_and_renders_on_product_and_home(): void
    {
        $products = Product::where('is_active', true)->take(3)->get();
        $p1 = $products[0];
        $p2 = $products[1];
        $p3 = $products[2];

        // 1. Visit p1
        $this->get("/product/{$p1->slug}")->assertOk();
        $recently = session('recently_viewed', []);
        $this->assertContains($p1->id, $recently);

        // 2. Visit p2 with session from previous step
        $this->withSession(['recently_viewed' => $recently])->get("/product/{$p2->slug}")->assertOk();
        $recently = session('recently_viewed', []);
        $this->assertContains($p2->id, $recently);
        $this->assertContains($p1->id, $recently);

        // 3. Visit p3: recently viewed section should show p2 and p1, but EXCLUDE p3 (current)
        $res3 = $this->withSession(['recently_viewed' => $recently])->get("/product/{$p3->slug}");
        $res3->assertOk();
        $res3->assertSee('Bạn Vừa Xem');
        $res3->assertSee($p2->name);
        $res3->assertSee($p1->name);

        // 4. Homepage now displays "Tiếp tục khám phá" because user has viewed products
        $allViewed = session('recently_viewed', []);
        $homeRes = $this->withSession(['recently_viewed' => $allViewed])->get('/');
        $homeRes->assertOk();
        $homeRes->assertSee('Tiếp tục khám phá');
    }

    public function test_cart_drawer_summary_endpoint_and_ajax_mutations(): void
    {
        $product = Product::where('is_active', true)->where('stock_quantity', '>', 5)->firstOrFail();

        // Add item via AJAX
        $addRes = $this->postJson('/cart/items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $addRes->assertOk()
            ->assertJson([
                'success' => true,
                'cart_count' => 2,
            ]);

        $items = $addRes->json('items');
        $this->assertCount(1, $items);
        $itemId = $items[0]['id'];

        // Update quantity via AJAX
        $updateRes = $this->patchJson("/cart/items/{$itemId}", [
            'quantity' => 3,
        ]);

        $updateRes->assertOk()
            ->assertJson([
                'success' => true,
                'cart_count' => 3,
            ]);

        // Delete item via AJAX
        $deleteRes = $this->deleteJson("/cart/items/{$itemId}");
        $deleteRes->assertOk()
            ->assertJson([
                'success' => true,
                'cart_count' => 0,
                'subtotal' => 0,
            ]);
    }

    public function test_coupon_remains_intact_and_recalculates_on_cart_update(): void
    {
        $category = Category::firstOrFail();
        $product = Product::create([
            'name' => 'Sản phẩm thử mã ưu đãi',
            'sku' => 'TEST-COUPON-PRD',
            'slug' => 'san-pham-thu-ma-uu-dai',
            'category_id' => $category->id,
            'product_type' => 'single',
            'regular_price' => 500000,
            'stock_quantity' => 20,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'LUNARA10PHASE19',
            'name' => 'Giảm 10%',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 10,
            'minimum_order' => 300000,
            'is_active' => true,
        ]);

        // Add item
        $this->postJson('/cart/items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // Apply coupon
        $couponRes = $this->postJson('/cart/coupon', ['code' => 'LUNARA10PHASE19']);
        $couponRes->assertOk()
            ->assertJson([
                'success' => true,
                'coupon_applied' => true,
                'coupon_code' => 'LUNARA10PHASE19',
            ]);
        $this->assertEquals(50000, (float) $couponRes->json('discount_amount'));
        $this->assertEquals(450000, (float) $couponRes->json('grand_total'));

        // Update quantity to 2 -> discount recalculates automatically to 100.000₫
        $items = $couponRes->json('items');
        $itemId = $items[0]['id'];

        $updateRes = $this->patchJson("/cart/items/{$itemId}", ['quantity' => 2]);
        $updateRes->assertOk()
            ->assertJson([
                'success' => true,
                'coupon_applied' => true,
                'coupon_code' => 'LUNARA10PHASE19',
            ]);
        $this->assertEquals(100000, (float) $updateRes->json('discount_amount'));
        $this->assertEquals(900000, (float) $updateRes->json('grand_total'));
    }

    public function test_guest_checkout_redirects_to_login_preserving_cart(): void
    {
        $product = Product::where('is_active', true)->where('stock_quantity', '>', 5)->firstOrFail();

        $this->postJson('/cart/items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // Unauthenticated access to /checkout redirects to /login
        $response = $this->get('/checkout');
        $response->assertRedirect('/login');

        // Cart is preserved
        $summaryRes = $this->getJson('/cart/summary');
        $summaryRes->assertOk()->assertJson(['cart_count' => 1]);
    }
}
