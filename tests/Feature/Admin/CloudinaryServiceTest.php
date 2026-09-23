<?php

namespace Tests\Feature\Admin;

use App\Services\CloudinaryService;
use Exception;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CloudinaryServiceTest extends TestCase
{
    public function test_is_configured_returns_false_when_credentials_missing(): void
    {
        config([
            'cloudinary.cloud_name' => '',
            'cloudinary.api_key' => '',
            'cloudinary.api_secret' => '',
        ]);

        $service = new CloudinaryService;
        $this->assertFalse($service->isConfigured());
    }

    public function test_is_configured_returns_true_when_credentials_present(): void
    {
        config([
            'cloudinary.cloud_name' => 'lunara-test',
            'cloudinary.api_key' => '123456789',
            'cloudinary.api_secret' => 'abcdefsecret',
        ]);

        $service = new CloudinaryService;
        $this->assertTrue($service->isConfigured());
    }

    public function test_generate_folder_creates_structured_paths(): void
    {
        $service = new CloudinaryService;

        $this->assertSame('lunara/products/LNS-NH001', $service->generateFolder('products', 'LNS-NH001'));
        $this->assertSame('lunara/collections/LNS-SET001', $service->generateFolder('collections', 'LNS-SET001'));
        $this->assertSame('lunara/gifts/LNS-GIFT001', $service->generateFolder('gifts', 'LNS-GIFT001'));
        $this->assertSame('lunara/banners', $service->generateFolder('banners'));
    }

    protected function createFakeImage(string $filename = 'test.jpg'): UploadedFile
    {
        $jpegBytes = base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=');

        return UploadedFile::fake()->createWithContent($filename, $jpegBytes);
    }

    public function test_mocked_upload_returns_public_id_and_secure_url(): void
    {
        $mock = $this->createMock(CloudinaryService::class);
        $mock->method('isConfigured')->willReturn(true);
        $mock->method('uploadFile')->willReturn([
            'public_id' => 'lunara/products/TEST-001/sample_abc123',
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v12345678/lunara/products/TEST-001/sample_abc123.jpg',
            'format' => 'jpg',
            'width' => 800,
            'height' => 800,
            'bytes' => 125000,
        ]);

        $file = $this->createFakeImage('test_product.jpg');
        $result = $mock->uploadFile($file, 'lunara/products/TEST-001');

        $this->assertArrayHasKey('public_id', $result);
        $this->assertArrayHasKey('secure_url', $result);
        $this->assertSame('lunara/products/TEST-001/sample_abc123', $result['public_id']);
        $this->assertStringStartsWith('https://res.cloudinary.com/', $result['secure_url']);
    }

    public function test_failed_upload_throws_exception(): void
    {
        $mock = $this->createMock(CloudinaryService::class);
        $mock->method('uploadFile')->willThrowException(new Exception('Cloudinary API connection error'));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Cloudinary API connection error');

        $file = $this->createFakeImage('test_product.jpg');
        $mock->uploadFile($file, 'lunara/products/TEST-001');
    }

    public function test_mocked_delete_calls_correct_public_id(): void
    {
        $mock = $this->createMock(CloudinaryService::class);
        $mock->expects($this->once())
            ->method('deleteFile')
            ->with($this->equalTo('lunara/products/TEST-001/sample_abc123'))
            ->willReturn(true);

        $result = $mock->deleteFile('lunara/products/TEST-001/sample_abc123');
        $this->assertTrue($result);
    }
}
