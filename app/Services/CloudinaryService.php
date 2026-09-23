<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class CloudinaryService
{
    protected ?Cloudinary $cloudinary;

    public function __construct(?Cloudinary $cloudinary = null)
    {
        if ($cloudinary !== null) {
            $this->cloudinary = $cloudinary;
        } elseif ($this->isConfigured()) {
            $this->cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => (string) config('cloudinary.cloud_name'),
                    'api_key' => (string) config('cloudinary.api_key'),
                    'api_secret' => (string) config('cloudinary.api_secret'),
                ],
                'url' => [
                    'secure' => (bool) config('cloudinary.secure', true),
                ],
            ]);
        } else {
            $this->cloudinary = null;
        }
    }

    /**
     * Check if Cloudinary credentials are fully configured.
     */
    public function isConfigured(): bool
    {
        return ! empty(config('cloudinary.cloud_name'))
            && ! empty(config('cloudinary.api_key'))
            && ! empty(config('cloudinary.api_secret'));
    }

    /**
     * Generate structured Cloudinary folder path.
     */
    public function generateFolder(string $type, ?string $sku = null): string
    {
        $prefix = trim((string) config('cloudinary.folder_prefix', 'lunara'), '/');
        $cleanType = trim(strtolower($type), '/');

        // Normalize plural types
        $folderType = match ($cleanType) {
            'product', 'products' => 'products',
            'collection', 'collections' => 'collections',
            'gift', 'gifts' => 'gifts',
            'banner', 'banners' => 'banners',
            default => $cleanType,
        };

        if ($sku !== null && trim($sku) !== '') {
            $cleanSku = preg_replace('/[^A-Za-z0-9_-]/', '-', trim($sku));

            return "{$prefix}/{$folderType}/{$cleanSku}";
        }

        return "{$prefix}/{$folderType}";
    }

    /**
     * Upload an image file to Cloudinary.
     *
     * @param  UploadedFile|string  $file
     * @return array{public_id: string, secure_url: string, url: string, width: ?int, height: ?int, format: ?string, bytes: ?int}
     *
     * @throws RuntimeException
     */
    public function uploadFile(mixed $file, string $folder, ?string $publicId = null, array $options = []): array
    {
        if ($this->cloudinary === null) {
            throw new RuntimeException('Cấu hình Cloudinary chưa đầy đủ (thiếu CLOUDINARY_CLOUD_NAME, API_KEY, hoặc API_SECRET).');
        }

        $filePath = $file instanceof UploadedFile ? $file->getRealPath() : (string) $file;

        if (empty($filePath) || ! file_exists($filePath)) {
            throw new RuntimeException('Tệp tin ảnh tải lên không hợp lệ hoặc không tồn tại.');
        }

        $params = array_merge([
            'folder' => trim($folder, '/'),
            'resource_type' => 'image',
            'overwrite' => true,
        ], $options);

        if (! empty($publicId)) {
            $params['public_id'] = $publicId;
        }

        try {
            $response = $this->cloudinary->uploadApi()->upload($filePath, $params);

            return [
                'public_id' => (string) ($response['public_id'] ?? ''),
                'secure_url' => (string) ($response['secure_url'] ?? $response['url'] ?? ''),
                'url' => (string) ($response['url'] ?? ''),
                'width' => isset($response['width']) ? (int) $response['width'] : null,
                'height' => isset($response['height']) ? (int) $response['height'] : null,
                'format' => isset($response['format']) ? (string) $response['format'] : null,
                'bytes' => isset($response['bytes']) ? (int) $response['bytes'] : null,
            ];
        } catch (Throwable $e) {
            Log::error('Cloudinary upload error', [
                'folder' => $folder,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Không thể tải ảnh lên Cloudinary: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Delete an asset from Cloudinary.
     *
     *
     * @throws RuntimeException
     */
    public function deleteFile(string $publicId, array $options = []): bool
    {
        if ($this->cloudinary === null) {
            throw new RuntimeException('Cấu hình Cloudinary chưa đầy đủ.');
        }

        if (trim($publicId) === '') {
            return false;
        }

        try {
            $response = $this->cloudinary->uploadApi()->destroy($publicId, $options);
            $result = (string) ($response['result'] ?? '');

            if ($result === 'ok' || $result === 'not found') {
                return true;
            }

            Log::warning('Cloudinary delete returned non-ok result', [
                'public_id' => $publicId,
                'result' => $result,
            ]);

            throw new RuntimeException("Xóa ảnh từ Cloudinary không thành công (kết quả: {$result}).");
        } catch (Throwable $e) {
            Log::error('Cloudinary delete error', [
                'public_id' => $publicId,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Lỗi khi xóa ảnh trên Cloudinary: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Generate an optimized secure URL for a Cloudinary public ID.
     */
    public function getUrl(string $publicId, array $transformations = []): string
    {
        $cloudName = config('cloudinary.cloud_name', '');
        $secure = config('cloudinary.secure', true) ? 'https' : 'http';

        if (empty($cloudName) || empty($publicId)) {
            return '';
        }

        $transStr = '';
        if (! empty($transformations)) {
            $parts = [];
            foreach ($transformations as $key => $val) {
                $parts[] = "{$key}_{$val}";
            }
            $transStr = implode(',', $parts).'/';
        }

        return "{$secure}://res.cloudinary.com/{$cloudName}/image/upload/{$transStr}".ltrim($publicId, '/');
    }

    /**
     * Get underlying Cloudinary SDK instance.
     */
    public function getCloudinary(): ?Cloudinary
    {
        return $this->cloudinary;
    }
}
