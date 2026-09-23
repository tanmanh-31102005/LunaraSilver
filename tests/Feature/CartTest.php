<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
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

    public function test_guest_can_add_update_and_remove_without_stock_deduction(): void
    {
        $product = $this->product('LNS-NH001');
        $stock = $product->stock_quantity;
        $this->add($product)->assertOk()->assertJsonPath('cart_count', 1);
        $this->add($product, 2)->assertOk()->assertJsonPath('cart_count', 3);
        $item = CartItem::query()->firstOrFail();
        $this->assertSame(3, $item->quantity);
        $this->assertSame($stock, $product->fresh()->stock_quantity);

        $this->patchJson('/cart/items/'.$item->id, ['quantity' => 2])->assertOk()->assertJsonPath('cart_count', 2);
        $this->get('/cart')->assertOk()->assertSee($product->name)->assertSee('Tạm tính');
        $this->getJson('/cart/summary')->assertOk()->assertJsonPath('cart_count', 2);
        $this->deleteJson('/cart/items/'.$item->id)->assertOk()->assertJsonPath('cart_count', 0)
            ->assertJsonPath('subtotal', '0.00');
        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_logged_in_user_cart_and_price_snapshot_are_server_owned(): void
    {
        $user = User::factory()->create();
        $product = $this->product('LNS-NH001');
        $this->actingAs($user)->postJson('/cart/items', [
            'product_id' => $product->id, 'quantity' => 2, 'unit_price' => '1.00',
        ])->assertOk()->assertJsonPath('cart_count', 2);

        $cart = Cart::query()->where('user_id', $user->id)->firstOrFail();
        $this->assertNull($cart->session_id);
        $price = $product->hasValidSalePrice() ? $product->sale_price : $product->regular_price;
        $this->assertSame($price, $cart->items()->firstOrFail()->unit_price);
        $this->getJson('/cart/summary')->assertJsonPath('subtotal', $this->decimal($this->cents($price) * 2));
    }

    public function test_current_price_refreshes_on_update(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product)->assertOk();
        $item = CartItem::query()->firstOrFail();
        $product->update(['regular_price' => '123456.00', 'sale_price' => null]);
        $this->patchJson('/cart/items/'.$item->id, ['quantity' => 2])->assertOk()
            ->assertJsonPath('subtotal', '246912.00');
        $this->assertSame('123456.00', $item->fresh()->unit_price);
    }

    public function test_invalid_quantity_missing_and_inactive_products_are_rejected(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product, 0)->assertUnprocessable()->assertJsonPath('success', false);
        $this->postJson('/cart/items', ['product_id' => 999999, 'quantity' => 1])->assertUnprocessable()
            ->assertJsonPath('success', false);
        $product->update(['is_active' => false]);
        $this->add($product)->assertUnprocessable()->assertJsonPath('success', false);
        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_single_cannot_exceed_its_stock(): void
    {
        $product = $this->product('LNS-NH001');
        $product->update(['stock_quantity' => 2]);
        $response = $this->add($product, 3)->assertUnprocessable();
        $this->assertStringContainsString('Không đủ tồn kho', $response->json('message'));
        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_collection_and_gift_with_zero_stored_stock_can_be_added(): void
    {
        foreach (['LNS-SET001', 'LNS-GIFT001'] as $sku) {
            $bundle = $this->product($sku);
            $this->assertSame(0, $bundle->stock_quantity);
            $this->add($bundle)->assertOk()->assertJsonPath('success', true);
        }
        $this->getJson('/cart/summary')->assertJsonPath('cart_count', 2);
    }

    public function test_bundle_rejects_insufficient_component_inventory(): void
    {
        foreach (['LNS-SET001', 'LNS-GIFT001'] as $sku) {
            $bundle = $this->product($sku)->load('bundleItems.component');
            $component = $bundle->bundleItems->first()->component;
            $component->update(['stock_quantity' => 0]);
            $this->add($bundle)->assertUnprocessable()->assertSee($component->sku);
        }
    }

    public function test_single_plus_bundle_aggregates_shared_component_demand(): void
    {
        $bundle = $this->product('LNS-SET001')->load('bundleItems.component');
        $component = $bundle->bundleItems->first()->component;
        $component->update(['stock_quantity' => 3]);
        $this->add($component, 2)->assertOk();
        $this->add($bundle, 2)->assertUnprocessable()->assertSee($component->sku);
        $this->assertDatabaseCount('cart_items', 1);
        $this->assertSame(2, CartItem::query()->firstOrFail()->quantity);
    }

    public function test_two_bundles_aggregate_shared_component_demand(): void
    {
        $first = $this->product('LNS-SET003');
        $second = $this->product('LNS-GIFT001');
        $shared = $this->product('LNS-NH005');
        $shared->update(['stock_quantity' => 1]);
        $this->add($first)->assertOk();
        $this->add($second)->assertUnprocessable()->assertSee($shared->sku);
    }

    public function test_bundle_quantity_multiplies_component_requirement(): void
    {
        $bundle = $this->product('LNS-SET001')->load('bundleItems.component');
        $component = $bundle->bundleItems->first()->component;
        $component->update(['stock_quantity' => 1]);
        $this->add($bundle, 2)->assertUnprocessable()->assertSee($component->sku);
    }

    public function test_update_validates_whole_cart_and_keeps_previous_quantity(): void
    {
        $bundle = $this->product('LNS-SET001')->load('bundleItems.component');
        $component = $bundle->bundleItems->first()->component;
        $component->update(['stock_quantity' => 2]);
        $this->add($component)->assertOk();
        $this->add($bundle)->assertOk();
        $item = CartItem::query()->where('product_id', $bundle->id)->firstOrFail();
        $this->patchJson('/cart/items/'.$item->id, ['quantity' => 2])->assertUnprocessable();
        $this->assertSame(1, $item->fresh()->quantity);
    }

    public function test_nested_bundle_component_is_rejected(): void
    {
        $bundle = $this->product('LNS-SET001');
        $bundle->bundleItems()->firstOrFail()->update(['component_product_id' => $this->product('LNS-GIFT001')->id]);
        $response = $this->add($bundle)->assertUnprocessable();
        $this->assertStringContainsString('Thành phần', $response->json('message'));
    }

    public function test_user_cannot_modify_another_users_item(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $this->actingAs($owner);
        $this->add($this->product('LNS-NH001'))->assertOk();
        $item = CartItem::query()->firstOrFail();
        $this->actingAs($other)->patchJson('/cart/items/'.$item->id, ['quantity' => 2])->assertNotFound();
        $this->deleteJson('/cart/items/'.$item->id)->assertNotFound();
        $this->assertSame(1, $item->fresh()->quantity);
    }

    public function test_guest_sessions_are_isolated(): void
    {
        $this->withSession(['lunara_cart_token' => 'guest-session-a']);
        $this->add($this->product('LNS-NH001'))->assertOk();
        $item = CartItem::query()->firstOrFail();
        $this->withSession(['lunara_cart_token' => 'guest-session-b']);
        $this->patchJson('/cart/items/'.$item->id, ['quantity' => 2])->assertNotFound();
        $this->deleteJson('/cart/items/'.$item->id)->assertNotFound();
        $this->assertSame(1, $item->fresh()->quantity);
    }

    public function test_guest_cart_merges_on_login_and_combines_duplicate_items(): void
    {
        $user = User::factory()->create(['email' => 'buyer@example.com', 'password' => 'password123']);
        $product = $this->product('LNS-NH001');
        $userCart = Cart::create(['user_id' => $user->id]);
        $userCart->items()->create(['product_id' => $product->id, 'quantity' => 1, 'unit_price' => $product->regular_price]);
        $this->add($product, 2)->assertOk();
        $this->post('/login', ['email' => 'buyer@example.com', 'password' => 'password123'])->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
        $this->assertSame(3, $userCart->items()->firstOrFail()->quantity);
        $this->assertDatabaseCount('carts', 1);
    }

    public function test_merge_preserves_items_and_warns_when_stock_changed(): void
    {
        $user = User::factory()->create(['email' => 'buyer@example.com', 'password' => 'password123']);
        $product = $this->product('LNS-NH001');
        $cart = Cart::create(['user_id' => $user->id]);
        $cart->items()->create(['product_id' => $product->id, 'quantity' => 2, 'unit_price' => $product->regular_price]);
        $this->add($product, 2)->assertOk();
        $product->update(['stock_quantity' => 3]);

        $this->post('/login', ['email' => 'buyer@example.com', 'password' => 'password123'])->assertRedirect('/');
        $this->assertSame(4, $cart->items()->firstOrFail()->quantity);
        $this->get('/cart')->assertOk()->assertSee('vượt tồn kho');
    }

    public function test_guest_cart_merges_after_registration(): void
    {
        $product = $this->product('LNS-NH001');
        $this->add($product)->assertOk();
        $this->post('/register', [
            'name' => 'Cart Customer', 'email' => 'cart@example.com',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertRedirect('/');

        $this->assertAuthenticated();
        $this->assertSame(1, Cart::query()->where('user_id', auth()->id())->firstOrFail()->items()->firstOrFail()->quantity);
        $this->assertDatabaseCount('carts', 1);
    }

    public function test_guest_clear_cart_removes_all_items_while_preserving_cart_record(): void
    {
        $product1 = $this->product('LNS-NH001');
        $product2 = $this->product('LNS-DC001');

        $this->add($product1, 1)->assertOk();
        $this->add($product2, 2)->assertOk();
        $this->assertDatabaseCount('carts', 1);
        $this->assertDatabaseCount('cart_items', 2);
        $cart = Cart::query()->firstOrFail();
        $this->assertNotNull($cart->session_id);
        $this->assertNull($cart->user_id);
        $this->getJson('/cart/summary')->assertJsonPath('cart_count', 3);

        $response = $this->deleteJson('/cart');
        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('cart_count', 0)
            ->assertJsonPath('subtotal', '0.00')
            ->assertJsonPath('items', []);

        // cart_items are removed, but the carts record remains for session reuse
        $this->assertDatabaseCount('cart_items', 0);
        $this->assertDatabaseCount('carts', 1);
        $this->assertSame(0, $cart->fresh()->items()->count());
        $this->assertNotNull($cart->fresh()->session_id);
    }

    public function test_authenticated_user_clear_cart_removes_all_items_while_preserving_cart_record(): void
    {
        $user = User::factory()->create();
        $product1 = $this->product('LNS-NH001');
        $product2 = $this->product('LNS-DC001');

        $this->actingAs($user)->add($product1, 1)->assertOk();
        $this->actingAs($user)->add($product2, 2)->assertOk();
        $this->assertDatabaseCount('carts', 1);
        $this->assertDatabaseCount('cart_items', 2);
        $cart = Cart::query()->where('user_id', $user->id)->firstOrFail();
        $this->assertSame(3, $cart->items()->sum('quantity'));

        $response = $this->actingAs($user)->deleteJson('/cart');
        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('cart_count', 0)
            ->assertJsonPath('subtotal', '0.00')
            ->assertJsonPath('items', []);

        // cart_items are removed, but the user's carts record remains
        $this->assertDatabaseCount('cart_items', 0);
        $this->assertDatabaseCount('carts', 1);
        $this->assertSame(0, $cart->fresh()->items()->count());
        $this->assertSame($user->id, $cart->fresh()->user_id);
    }

    public function test_critical_scenario_single_plus_bundle_shared_component_demand_overflow(): void
    {
        // Setup per Section 37:
        // NH001 stock = 3
        // SET001 contains NH001 x1
        // Cart ban đầu: NH001 x2
        // Request: Add SET001 x2
        // Demand mới: 2 + (2 × 1) = 4
        // Expected:
        // - HTTP 422
        // - NH001 vẫn x2
        // - SET001 không được thêm
        // - stock NH001 vẫn = 3
        // - giỏ cũ không thay đổi sau khi request 422
        $component = $this->product('LNS-NH001');
        $component->update(['stock_quantity' => 3]);

        $bundle = $this->product('LNS-SET001');
        $bundle->bundleItems()->updateOrCreate(
            ['component_product_id' => $component->id],
            ['quantity' => 1, 'sort_order' => 99]
        );

        // Cart ban đầu: NH001 x2
        $this->add($component, 2)->assertOk()->assertJsonPath('cart_count', 2);
        $this->assertSame(3, $component->fresh()->stock_quantity, 'Stock must not decrement upon add to cart');

        // Attempt to add SET001 x2: demand = 2 + (2 * 1) = 4 > stock 3
        $response = $this->add($bundle, 2);
        $response->assertUnprocessable()
            ->assertJsonPath('success', false);
        $this->assertStringContainsString($component->sku, $response->json('message'));

        // Assert giỏ cũ hoàn toàn không thay đổi sau request 422:
        $this->assertDatabaseCount('cart_items', 1);
        $this->assertDatabaseMissing('cart_items', ['product_id' => $bundle->id]);
        $item = CartItem::query()->firstOrFail();
        $this->assertSame($component->id, $item->product_id);
        $this->assertSame(2, $item->quantity, 'NH001 vẫn x2');
        $this->assertSame(3, $component->fresh()->stock_quantity, 'stock NH001 vẫn = 3');

        // Summary vẫn nguyên vẹn 2 items
        $this->getJson('/cart/summary')
            ->assertOk()
            ->assertJsonPath('cart_count', 2);
    }

    public function test_build_inventory_requirements_and_validate_cart_inventory_apis(): void
    {
        /** @var CartService $cartService */
        $cartService = app(CartService::class);

        $single = $this->product('LNS-NH001');
        $bundle = $this->product('LNS-SET001')->load('bundleItems.component');
        $component = $bundle->bundleItems->first()->component;

        $user = User::factory()->create();
        $cart = Cart::create(['user_id' => $user->id]);
        $cart->items()->create(['product_id' => $single->id, 'quantity' => 2, 'unit_price' => $single->regular_price]);
        $cart->items()->create(['product_id' => $bundle->id, 'quantity' => 1, 'unit_price' => $bundle->regular_price]);

        $requirements = $cartService->buildInventoryRequirements($cart);

        $this->assertArrayHasKey($single->id, $requirements);
        $this->assertArrayHasKey($component->id, $requirements);
        $this->assertSame(2, $requirements[$single->id]['required']);
        $this->assertInstanceOf(Product::class, $requirements[$single->id]['component']);

        // Calling validateCartInventory on cart object directly
        $cartService->validateCartInventory($cart);

        // If component stock drops below requirement, validateCartInventory throws ValidationException
        $component->update(['stock_quantity' => 0]);
        $this->expectException(ValidationException::class);
        $cartService->validateCartInventory($cart);
    }

    private function cents(string $price): int
    {
        return (int) str_replace('.', '', $price);
    }

    private function decimal(int $cents): string
    {
        return intdiv($cents, 100).'.'.str_pad((string) ($cents % 100), 2, '0', STR_PAD_LEFT);
    }
}
