<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontCloudinaryCompatibilityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_cloudinary_primary_displayed_on_product_card_and_detail(): void
    {
        $product = Product::where('is_active', true)->where('product_type', 'single')->firstOrFail();

        // Clear existing primary and assign Cloudinary primary
        $product->images()->where('image_role', 'primary')->update(['image_role' => 'gallery']);

        $cloudPrimary = $product->images()->create([
            'cloudinary_public_id' => 'lunara/products/test/primary_ring',
            'image_url' => 'https://res.cloudinary.com/lunara-silver/image/upload/v12345/lunara/products/test/primary_ring.jpg',
            'image_role' => 'primary',
            'sort_order' => 0,
            'alt_text' => 'Nhẫn Cloudinary Chính Thức',
        ]);

        // 1. Check Product Listing
        $listingResponse = $this->get(route('products.index', ['q' => $product->sku]));
        $listingResponse->assertOk();
        $listingResponse->assertSee($cloudPrimary->image_url);

        // 2. Check Product Detail
        $detailResponse = $this->get(route('products.show', $product->slug));
        $detailResponse->assertOk();
        $detailResponse->assertSee($cloudPrimary->image_url);
    }

    public function test_cloudinary_hover_displayed_on_product_card(): void
    {
        $product = Product::where('is_active', true)->where('product_type', 'single')->firstOrFail();

        $product->images()->where('image_role', 'hover')->delete();

        $cloudHover = $product->images()->create([
            'cloudinary_public_id' => 'lunara/products/test/hover_ring',
            'image_url' => 'https://res.cloudinary.com/lunara-silver/image/upload/v12345/lunara/products/test/hover_ring.jpg',
            'image_role' => 'hover',
            'sort_order' => 1,
        ]);

        $listingResponse = $this->get(route('products.index', ['q' => $product->sku]));
        $listingResponse->assertOk();
        $listingResponse->assertSee($cloudHover->image_url);
        $listingResponse->assertSee('product-card__image--hover');
    }

    public function test_local_fallback_still_works_when_not_cloudinary(): void
    {
        $product = Product::where('is_active', true)->where('product_type', 'single')->firstOrFail();
        $primary = $product->images->firstWhere('image_role', 'primary');

        $this->assertNotNull($primary);
        $this->assertNull($primary->cloudinary_public_id);

        $url = $primary->displayUrl();
        $this->assertNotEmpty($url);
        // Either preview asset or media.show route
        $this->assertTrue(str_contains($url, 'media-previews') || str_contains($url, '/media/'));
    }

    public function test_placeholder_used_when_no_image_exists(): void
    {
        $img = new ProductImage([
            'image_url' => '',
            'cloudinary_public_id' => null,
            'image_role' => 'gallery',
        ]);

        $this->assertSame(route('media.show', ['path' => 'placeholder.png']), $img->displayUrl());
    }

    public function test_inactive_and_soft_deleted_product_retains_images(): void
    {
        $product = Product::firstOrFail();
        $initialImageCount = $product->images()->count();

        // 1. Inactive product keeps images
        $product->update(['is_active' => false]);
        $this->assertSame($initialImageCount, $product->fresh()->images()->count());

        // 2. Soft deleted product keeps images
        $product->delete();
        $this->assertSoftDeleted('products', ['id' => $product->id]);
        $this->assertSame($initialImageCount, ProductImage::where('product_id', $product->id)->count());

        // 3. Restored product still has images
        $product->restore();
        $this->assertSame($initialImageCount, $product->fresh()->images()->count());
    }

    public function test_historical_order_snapshot_is_unaffected(): void
    {
        $product = Product::firstOrFail();
        $category = Category::firstOrFail();

        $order = Order::create([
            'order_code' => 'ORD-TEST-SNAPSHOT',
            'order_status' => 'pending',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'subtotal' => 500000,
            'discount_amount' => 0,
            'shipping_fee' => 30000,
            'grand_total' => 530000,
            'customer_name' => 'Nguyen Van A',
            'customer_email' => 'vana@example.com',
            'customer_phone' => '0901234567',
            'shipping_address' => '123 Le Loi, Q1, HCMC',
            'shipping_city' => 'TP Hồ Chí Minh',
            'shipping_method' => 'standard',
            'placed_at' => now(),
        ]);

        $item = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'unit_price' => 500000,
            'quantity' => 1,
            'subtotal' => 500000,
        ]);

        // Upload new Cloudinary image for product
        $product->images()->create([
            'cloudinary_public_id' => 'lunara/products/test/new_img',
            'image_url' => 'https://res.cloudinary.com/test/new.jpg',
            'image_role' => 'primary',
            'sort_order' => 99,
        ]);

        // Verify order item data remains frozen
        $freshItem = OrderItem::find($item->id);
        $this->assertSame($product->sku, $freshItem->product_sku);
        $this->assertSame(500000, (int) $freshItem->unit_price);
        $this->assertSame($order->id, $freshItem->order_id);
    }
}
