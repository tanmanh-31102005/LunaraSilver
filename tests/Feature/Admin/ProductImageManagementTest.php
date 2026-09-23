<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Services\CloudinaryService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductImageManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $user;

    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->user = User::factory()->create(['role' => User::ROLE_USER]);

        $this->product = Product::firstOrFail();
    }

    protected function mockCloudinaryService(bool $uploadSuccess = true, bool $deleteSuccess = true): void
    {
        $mock = $this->createMock(CloudinaryService::class);
        $mock->method('isConfigured')->willReturn(true);
        $mock->method('generateFolder')->willReturnCallback(function ($type, $sku = null) {
            return "lunara/{$type}".($sku ? "/{$sku}" : '');
        });

        if ($uploadSuccess) {
            $mock->method('uploadFile')->willReturnCallback(function ($file, $folder) {
                $uniq = uniqid('img_');

                return [
                    'public_id' => "{$folder}/{$uniq}",
                    'secure_url' => "https://res.cloudinary.com/lunara-silver/image/upload/v12345/{$folder}/{$uniq}.jpg",
                    'format' => 'jpg',
                    'bytes' => 120000,
                ];
            });
        }

        $mock->method('deleteFile')->willReturn($deleteSuccess);

        $this->app->instance(CloudinaryService::class, $mock);
    }

    protected function createFakeImage(string $filename = 'test.jpg'): UploadedFile
    {
        $jpegBytes = base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=');

        return UploadedFile::fake()->createWithContent($filename, $jpegBytes);
    }

    public function test_guest_cannot_upload_product_images(): void
    {
        $file = $this->createFakeImage('test.jpg');
        $response = $this->post(route('admin.products.images.store', $this->product), [
            'images' => [$file],
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_normal_user_cannot_upload_product_images(): void
    {
        $file = $this->createFakeImage('test.jpg');
        $response = $this->actingAs($this->user)->post(route('admin.products.images.store', $this->product), [
            'images' => [$file],
        ]);

        $response->assertForbidden();
    }

    public function test_admin_can_upload_product_images(): void
    {
        $this->mockCloudinaryService();

        $file = $this->createFakeImage('ring_silver.jpg');
        $response = $this->actingAs($this->admin)->post(route('admin.products.images.store', $this->product), [
            'images' => [$file],
            'image_role' => 'gallery',
            'alt_text' => 'Nhẫn bạc ánh trăng góc nghiêng',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('product_images', [
            'product_id' => $this->product->id,
            'image_role' => 'gallery',
            'alt_text' => 'Nhẫn bạc ánh trăng góc nghiêng',
        ]);

        $created = ProductImage::where('product_id', $this->product->id)
            ->where('alt_text', 'Nhẫn bạc ánh trăng góc nghiêng')
            ->first();

        $this->assertNotNull($created);
        $this->assertTrue($created->isCloudinary());
        $this->assertNotNull($created->cloudinary_public_id);
        $this->assertStringStartsWith('https://res.cloudinary.com/', $created->image_url);
    }

    public function test_invalid_extension_is_rejected(): void
    {
        $file = UploadedFile::fake()->create('malicious.svg', 100, 'image/svg+xml');
        $response = $this->actingAs($this->admin)->post(route('admin.products.images.store', $this->product), [
            'images' => [$file],
        ]);

        $response->assertSessionHasErrors('images.0');
    }

    public function test_oversized_file_is_rejected(): void
    {
        // 6MB is greater than 5MB limit
        $file = UploadedFile::fake()->create('huge_photo.jpg', 6144, 'image/jpeg');
        $response = $this->actingAs($this->admin)->post(route('admin.products.images.store', $this->product), [
            'images' => [$file],
        ]);

        $response->assertSessionHasErrors('images.0');
    }

    public function test_invalid_role_is_rejected(): void
    {
        $file = $this->createFakeImage('test.jpg');
        $response = $this->actingAs($this->admin)->post(route('admin.products.images.store', $this->product), [
            'images' => [$file],
            'image_role' => 'super_primary',
        ]);

        $response->assertSessionHasErrors('image_role');
    }

    public function test_primary_role_upload_and_replacement_invariant(): void
    {
        $this->mockCloudinaryService();

        // 1. Upload first primary image
        $file1 = $this->createFakeImage('img1.jpg');
        $this->actingAs($this->admin)->post(route('admin.products.images.store', $this->product), [
            'images' => [$file1],
            'image_role' => 'primary',
            'alt_text' => 'Ảnh chính ban đầu',
        ]);

        $firstPrimary = $this->product->images()->where('alt_text', 'Ảnh chính ban đầu')->first();
        $this->assertNotNull($firstPrimary);
        $this->assertSame('primary', $firstPrimary->image_role);

        // 2. Upload second image as primary -> first must be demoted to gallery
        $file2 = $this->createFakeImage('img2.jpg');
        $this->actingAs($this->admin)->post(route('admin.products.images.store', $this->product), [
            'images' => [$file2],
            'image_role' => 'primary',
            'alt_text' => 'Ảnh chính mới',
        ]);

        $this->assertSame('gallery', $firstPrimary->fresh()->image_role);

        $secondPrimary = $this->product->images()->where('alt_text', 'Ảnh chính mới')->first();
        $this->assertSame('primary', $secondPrimary->image_role);

        // Verify only 1 primary exists for the product
        $this->assertSame(1, $this->product->images()->where('image_role', 'primary')->count());
    }

    public function test_hover_invariant_replaces_previous_hover(): void
    {
        $this->mockCloudinaryService();

        $img1 = $this->product->images()->create([
            'image_url' => 'https://res.cloudinary.com/test/hover1.jpg',
            'cloudinary_public_id' => 'lunara/products/test/h1',
            'image_role' => 'hover',
            'sort_order' => 1,
        ]);

        $img2 = $this->product->images()->create([
            'image_url' => 'https://res.cloudinary.com/test/hover2.jpg',
            'cloudinary_public_id' => 'lunara/products/test/h2',
            'image_role' => 'gallery',
            'sort_order' => 2,
        ]);

        // Promote img2 to hover
        $response = $this->actingAs($this->admin)->patch(route('admin.products.images.update', [$this->product, $img2]), [
            'image_role' => 'hover',
        ]);

        $response->assertRedirect();
        $this->assertSame('hover', $img2->fresh()->image_role);
        $this->assertSame('gallery', $img1->fresh()->image_role);
        $this->assertSame(1, $this->product->images()->where('image_role', 'hover')->count());
    }

    public function test_multiple_gallery_images_allowed_with_reordering(): void
    {
        $img1 = $this->product->images()->create([
            'image_url' => 'https://res.cloudinary.com/test/g1.jpg',
            'cloudinary_public_id' => 'lunara/products/test/g1',
            'image_role' => 'gallery',
            'sort_order' => 1,
        ]);

        $img2 = $this->product->images()->create([
            'image_url' => 'https://res.cloudinary.com/test/g2.jpg',
            'cloudinary_public_id' => 'lunara/products/test/g2',
            'image_role' => 'gallery',
            'sort_order' => 2,
        ]);

        $this->assertSame(2, $this->product->images()->where('image_role', 'gallery')->count());

        // Reorder images
        $response = $this->actingAs($this->admin)->patch(route('admin.products.images.reorder', $this->product), [
            'order' => [$img2->id, $img1->id],
        ]);

        $response->assertRedirect();
        $this->assertSame(1, $img2->fresh()->sort_order);
        $this->assertSame(2, $img1->fresh()->sort_order);
    }

    public function test_cloud_image_delete_removes_remote_and_database_record(): void
    {
        $mock = $this->createMock(CloudinaryService::class);
        $mock->method('isConfigured')->willReturn(true);
        $mock->expects($this->once())
            ->method('deleteFile')
            ->with($this->equalTo('lunara/products/test/delete_me'))
            ->willReturn(true);

        $this->app->instance(CloudinaryService::class, $mock);

        $cloudImg = $this->product->images()->create([
            'image_url' => 'https://res.cloudinary.com/test/delete_me.jpg',
            'cloudinary_public_id' => 'lunara/products/test/delete_me',
            'image_role' => 'gallery',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.products.images.destroy', [$this->product, $cloudImg]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('product_images', ['id' => $cloudImg->id]);
    }

    public function test_failed_remote_delete_does_not_silently_delete_database_record(): void
    {
        $mock = $this->createMock(CloudinaryService::class);
        $mock->method('isConfigured')->willReturn(true);
        $mock->expects($this->once())
            ->method('deleteFile')
            ->willReturn(false); // Cloudinary delete failed

        $this->app->instance(CloudinaryService::class, $mock);

        $cloudImg = $this->product->images()->create([
            'image_url' => 'https://res.cloudinary.com/test/failed_delete.jpg',
            'cloudinary_public_id' => 'lunara/products/test/failed_delete',
            'image_role' => 'gallery',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.products.images.destroy', [$this->product, $cloudImg]));

        $response->assertSessionHas('error');
        // Record must still exist in DB
        $this->assertDatabaseHas('product_images', ['id' => $cloudImg->id]);
    }

    public function test_local_legacy_image_delete_never_calls_cloudinary(): void
    {
        $mock = $this->createMock(CloudinaryService::class);
        $mock->method('isConfigured')->willReturn(true);
        $mock->expects($this->never())->method('deleteFile');

        $this->app->instance(CloudinaryService::class, $mock);

        $localImg = $this->product->images()->create([
            'image_url' => 'products/local_photo.jpg',
            'cloudinary_public_id' => null, // local legacy
            'image_role' => 'gallery',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.products.images.destroy', [$this->product, $localImg]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('product_images', ['id' => $localImg->id]);
    }

    public function test_wrong_product_image_ownership_is_rejected(): void
    {
        $otherProduct = Product::where('id', '!=', $this->product->id)->firstOrFail();

        $foreignImage = $otherProduct->images()->create([
            'image_url' => 'products/foreign.jpg',
            'cloudinary_public_id' => null,
            'image_role' => 'gallery',
        ]);

        // Attempting to delete foreign image through $this->product route
        $response = $this->actingAs($this->admin)->delete(route('admin.products.images.destroy', [$this->product, $foreignImage]));

        $response->assertNotFound();
    }
}
