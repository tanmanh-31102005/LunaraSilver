<?php

namespace App\Console\Commands;

use App\Models\ProductImage;
use App\Services\CloudinaryService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;

class MigrateImagesToCloudinary extends Command
{
    protected $signature = 'lunara:migrate-images-to-cloudinary {--dry-run : Simulate the migration without uploading or updating database} {--limit= : Limit the number of images to migrate}';

    protected $description = 'Safely migrate local product images to Cloudinary (preserves local files as fallback)';

    public function handle(CloudinaryService $cloudinary): int
    {
        $isDryRun = (bool) $this->option('dry-run');
        $limit = $this->option('limit') ? (int) $this->option('limit') : null;

        if (! $cloudinary->isConfigured()) {
            $this->error('Cloudinary credentials are not configured in .env (CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, CLOUDINARY_API_SECRET).');

            return self::FAILURE;
        }

        $query = ProductImage::query()
            ->whereNull('cloudinary_public_id')
            ->whereNotNull('image_url')
            ->with('product');

        if ($limit) {
            $query->limit($limit);
        }

        $images = $query->get();

        if ($images->isEmpty()) {
            $this->info('No local images pending migration.');

            return self::SUCCESS;
        }

        $this->info(($isDryRun ? '[DRY-RUN] ' : '')."Found {$images->count()} local image(s) to migrate.");

        $successCount = 0;
        $skipCount = 0;
        $failCount = 0;

        foreach ($images as $img) {
            $sku = $img->product?->sku ?? 'unassigned';
            $relativeUrl = ltrim($img->image_url, '/');

            // Find physical file on disk
            $candidatePaths = [
                base_path('media/'.$relativeUrl),
                base_path($relativeUrl),
                public_path($relativeUrl),
                public_path('media/'.$relativeUrl),
            ];

            $localPath = null;
            foreach ($candidatePaths as $path) {
                if (file_exists($path) && is_file($path)) {
                    $localPath = $path;
                    break;
                }
            }

            if (! $localPath) {
                $this->warn("  [SKIP] Local file not found for Image #{$img->id} ({$img->image_url})");
                $skipCount++;

                continue;
            }

            $folder = $cloudinary->generateFolder('products', $sku);

            if ($isDryRun) {
                $this->line("  [DRY-RUN] Would upload {$localPath} -> {$folder}");
                $successCount++;

                continue;
            }

            try {
                $uploadedFile = new UploadedFile($localPath, basename($localPath));
                $result = $cloudinary->uploadFile($uploadedFile, $folder, null, [
                    'transformation' => ['quality' => 'auto', 'fetch_format' => 'auto'],
                ]);

                $img->update([
                    'cloudinary_public_id' => $result['public_id'],
                    'image_url' => $result['secure_url'],
                ]);

                $this->info("  [SUCCESS] Migrated Image #{$img->id} (SKU: {$sku}) -> {$result['public_id']}");
                $successCount++;
            } catch (Exception $e) {
                $this->error("  [FAIL] Image #{$img->id}: {$e->getMessage()}");
                $failCount++;
            }
        }

        $this->newLine();
        $this->info("Migration summary: {$successCount} succeeded, {$skipCount} skipped, {$failCount} failed.");

        return self::SUCCESS;
    }
}
