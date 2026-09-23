<?php

namespace App\Services;

use App\Models\Banner;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BannerService
{
    public function __construct(
        protected CloudinaryService $cloudinary
    ) {}

    /**
     * Retrieve all active banners sorted by sort_order.
     */
    public function getActiveBanners(): Collection
    {
        return Banner::query()->active()->ordered()->get();
    }

    /**
     * Upload banner image to Cloudinary folder 'lunara/banners'.
     */
    public function uploadBannerImage(UploadedFile $file): array
    {
        $folder = $this->cloudinary->generateFolder('banners');

        return $this->cloudinary->uploadFile($file, $folder, null, [
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ],
        ]);
    }

    /**
     * Create a new banner record, optionally uploading image if provided as file.
     */
    public function createBanner(array $data): Banner
    {
        $file = $data['image_file'] ?? null;
        $publicId = null;
        $imageUrl = $data['image_url'] ?? null;

        if ($file instanceof UploadedFile) {
            $uploadResult = $this->uploadBannerImage($file);
            $publicId = $uploadResult['public_id'];
            $imageUrl = $uploadResult['secure_url'];
        }

        try {
            return DB::transaction(function () use ($data, $imageUrl, $publicId) {
                return Banner::create([
                    'title' => $data['title'] ?? null,
                    'subtitle' => $data['subtitle'] ?? null,
                    'image_url' => $imageUrl,
                    'cloudinary_public_id' => $publicId,
                    'button_text' => $data['button_text'] ?? null,
                    'link' => $data['link'] ?? null,
                    'sort_order' => (int) ($data['sort_order'] ?? 0),
                    'is_active' => (bool) ($data['is_active'] ?? true),
                ]);
            });
        } catch (Exception $e) {
            if ($publicId) {
                try {
                    $this->cloudinary->deleteFile($publicId);
                } catch (Exception $cleanupEx) {
                    Log::error('Banner image cleanup failed', ['public_id' => $publicId, 'error' => $cleanupEx->getMessage()]);
                }
            }
            throw $e;
        }
    }

    /**
     * Update an existing banner record.
     */
    public function updateBanner(Banner $banner, array $data): Banner
    {
        $file = $data['image_file'] ?? null;

        if ($file instanceof UploadedFile) {
            $oldPublicId = $banner->cloudinary_public_id;
            $uploadResult = $this->uploadBannerImage($file);
            $data['cloudinary_public_id'] = $uploadResult['public_id'];
            $data['image_url'] = $uploadResult['secure_url'];

            // Delete old Cloudinary image if replaced
            if ($oldPublicId) {
                try {
                    $this->cloudinary->deleteFile($oldPublicId);
                } catch (Exception $e) {
                    Log::warning('Old banner asset cleanup warning', ['public_id' => $oldPublicId, 'error' => $e->getMessage()]);
                }
            }
        }

        unset($data['image_file']);
        $banner->update($data);

        return $banner;
    }

    /**
     * Safely delete a banner, including its Cloudinary asset if hosted on Cloudinary.
     */
    public function deleteBanner(Banner $banner): bool
    {
        if ($banner->isCloudinary()) {
            $deleted = $this->cloudinary->deleteFile($banner->cloudinary_public_id);
            if (! $deleted) {
                Log::error('Cloudinary banner deletion failed', [
                    'banner_id' => $banner->id,
                    'public_id' => $banner->cloudinary_public_id,
                ]);

                throw new Exception('Không thể xóa ảnh banner trên Cloudinary.');
            }
        }

        return (bool) $banner->delete();
    }
}
