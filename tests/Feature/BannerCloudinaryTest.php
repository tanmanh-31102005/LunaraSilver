<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Services\BannerService;
use App\Services\CloudinaryService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BannerCloudinaryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    protected function createFakeImage(string $filename = 'test.jpg'): UploadedFile
    {
        $jpegBytes = base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=');

        return UploadedFile::fake()->createWithContent($filename, $jpegBytes);
    }

    public function test_banner_service_creates_banner_with_cloudinary_image(): void
    {
        $mock = $this->createMock(CloudinaryService::class);
        $mock->method('generateFolder')->with('banners')->willReturn('lunara/banners');
        $mock->expects($this->once())
            ->method('uploadFile')
            ->willReturn([
                'public_id' => 'lunara/banners/hero_summer_2026',
                'secure_url' => 'https://res.cloudinary.com/lunara-silver/image/upload/v12345/lunara/banners/hero_summer_2026.jpg',
            ]);

        $service = new BannerService($mock);

        $file = $this->createFakeImage('banner_hero.jpg');
        $banner = $service->createBanner([
            'title' => 'Mặt Trời Mùa Hạ',
            'subtitle' => 'Bộ Sưu Tập Giới Hạn',
            'button_text' => 'Mua Ngay',
            'link' => '/products',
            'image_file' => $file,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('banners', [
            'id' => $banner->id,
            'title' => 'Mặt Trời Mùa Hạ',
            'cloudinary_public_id' => 'lunara/banners/hero_summer_2026',
        ]);

        $this->assertTrue($banner->isCloudinary());
        $this->assertSame('https://res.cloudinary.com/lunara-silver/image/upload/v12345/lunara/banners/hero_summer_2026.jpg', $banner->displayUrl());
    }

    public function test_active_banners_ordered_properly(): void
    {
        Banner::create([
            'title' => 'Banner B',
            'image_url' => 'https://res.cloudinary.com/demo/b.jpg',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Banner A',
            'image_url' => 'https://res.cloudinary.com/demo/a.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Banner Inactive',
            'image_url' => 'https://res.cloudinary.com/demo/inactive.jpg',
            'sort_order' => 0,
            'is_active' => false,
        ]);

        $active = Banner::active()->ordered()->get();

        $this->assertCount(2, $active);
        $this->assertSame('Banner A', $active->first()->title);
        $this->assertSame('Banner B', $active->last()->title);
    }

    public function test_banner_delete_safely_removes_cloudinary_asset(): void
    {
        $mock = $this->createMock(CloudinaryService::class);
        $mock->expects($this->once())
            ->method('deleteFile')
            ->with($this->equalTo('lunara/banners/to_delete'))
            ->willReturn(true);

        $service = new BannerService($mock);

        $banner = Banner::create([
            'title' => 'Banner Cần Xóa',
            'image_url' => 'https://res.cloudinary.com/demo/del.jpg',
            'cloudinary_public_id' => 'lunara/banners/to_delete',
            'is_active' => true,
        ]);

        $deleted = $service->deleteBanner($banner);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('banners', ['id' => $banner->id]);
    }
}
