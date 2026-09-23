<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Create a new product and sync related bundle items and image metadata.
     */
    public function createProduct(array $data): Product
    {
        return DB::transaction(function () use ($data): Product {
            $bundleItems = $data['bundle_items'] ?? [];
            $images = $data['images'] ?? [];
            unset($data['bundle_items'], $data['images']);

            $product = Product::create($data);

            if (in_array($product->product_type, ['collection', 'gift'], true)) {
                $this->syncBundleItems($product, $bundleItems);
            }

            if (! empty($images)) {
                $this->syncImages($product, $images);
            }

            return $product->fresh(['category', 'bundleItems.component', 'images']);
        });
    }

    /**
     * Update an existing product and sync related bundle items and image metadata.
     */
    public function updateProduct(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data): Product {
            $bundleItems = $data['bundle_items'] ?? [];
            $hasImages = array_key_exists('images', $data);
            $images = $data['images'] ?? [];
            unset($data['bundle_items'], $data['images']);

            $product->update($data);

            if (in_array($product->product_type, ['collection', 'gift'], true)) {
                $this->syncBundleItems($product, $bundleItems);
            } else {
                // If type was changed to single, clean up any previous bundle components
                $product->bundleItems()->delete();
            }

            if ($hasImages) {
                $this->syncImages($product, $images);
            }

            return $product->fresh(['category', 'bundleItems.component', 'images']);
        });
    }

    /**
     * Sync bundle component items for a bundle product.
     */
    public function syncBundleItems(Product $product, array $bundleItems): void
    {
        $product->bundleItems()->delete();

        foreach ($bundleItems as $index => $item) {
            if (empty($item['product_id'])) {
                continue;
            }

            $product->bundleItems()->create([
                'component_product_id' => (int) $item['product_id'],
                'quantity' => max(1, (int) ($item['quantity'] ?? 1)),
                'sort_order' => (int) ($item['sort_order'] ?? $index),
            ]);
        }
    }

    /**
     * Sync image metadata foundation for a product.
     * Note: This only manipulates DB metadata records; source media files in media/ are never deleted.
     */
    public function syncImages(Product $product, array $images): void
    {
        $keptIds = [];

        foreach ($images as $index => $imgData) {
            if (empty($imgData['image_url'])) {
                continue;
            }

            $payload = [
                'image_url' => trim($imgData['image_url']),
                'image_role' => $imgData['image_role'] ?? 'gallery',
                'sort_order' => (int) ($imgData['sort_order'] ?? $index),
                'alt_text' => $imgData['alt_text'] ?? null,
            ];

            if (! empty($imgData['id'])) {
                $existing = $product->images()->find($imgData['id']);
                if ($existing) {
                    $existing->update($payload);
                    $keptIds[] = $existing->id;

                    continue;
                }
            }

            $newImage = $product->images()->create($payload);
            $keptIds[] = $newImage->id;
        }

        // Delete removed image records from database only
        $product->images()->whereNotIn('id', $keptIds)->delete();
    }

    /**
     * Duplicate an existing product with a unique SKU, slug, inactive status, and copy its bundle items and images.
     */
    public function duplicateProduct(Product $product): Product
    {
        return DB::transaction(function () use ($product): Product {
            $product->loadMissing(['bundleItems', 'images']);

            $suffix = strtoupper(Str::random(4));
            $newSku = $product->sku.'-COPY-'.$suffix;
            $newSlug = Str::slug($product->slug.'-copy-'.strtolower($suffix));

            $newProduct = $product->replicate([
                'sold_count',
                'view_count',
            ]);

            $newProduct->name = $product->name.' (Bản sao)';
            $newProduct->sku = $newSku;
            $newProduct->slug = $newSlug;
            $newProduct->is_active = false;
            $newProduct->save();

            // Duplicate bundle items if collection or gift
            if (in_array($product->product_type, ['collection', 'gift'], true)) {
                foreach ($product->bundleItems as $item) {
                    $newProduct->bundleItems()->create([
                        'component_product_id' => $item->component_product_id,
                        'quantity' => $item->quantity,
                        'sort_order' => $item->sort_order,
                    ]);
                }
            }

            // Duplicate images metadata
            foreach ($product->images as $img) {
                $newProduct->images()->create([
                    'image_url' => $img->image_url,
                    'image_role' => $img->image_role,
                    'sort_order' => $img->sort_order,
                    'alt_text' => $img->alt_text,
                ]);
            }

            return $newProduct->fresh(['category', 'bundleItems.component', 'images']);
        });
    }

    /**
     * Bulk update active status for multiple products.
     */
    public function bulkUpdateStatus(array $productIds, bool $isActive): int
    {
        if (empty($productIds)) {
            return 0;
        }

        return Product::whereIn('id', $productIds)->update(['is_active' => $isActive]);
    }
}
