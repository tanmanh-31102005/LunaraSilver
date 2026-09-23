<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $data = CatalogData::load();
        $categoryIds = Category::query()->pluck('id', 'slug');
        $slugs = [];

        foreach ($data['products'] as $entry) {
            $slug = Str::slug($entry['name']);
            if (isset($slugs[$slug])) {
                $slug .= '-'.Str::lower($entry['sku']);
            }
            $slugs[$slug] = true;

            $attributes = [
                'category_id' => $categoryIds[$entry['category_slug']],
                'name' => $entry['name'],
                'slug' => $slug,
                'product_type' => $entry['product_type'],
                'regular_price' => $entry['regular_price'],
                'sale_price' => $entry['sale_price'],
                'stock_quantity' => $entry['stock_quantity'],
                'material' => $entry['material'],
                'stone' => $entry['stone'],
                'weight' => $entry['weight'],
                'size_info' => $entry['size_info'],
                'short_description' => $entry['short_description'],
                'description' => $entry['description'],
            ];

            // DatabaseSeeder disables model events; only single status is stored.
            if ($entry['product_type'] === 'single') {
                $attributes['stock_status'] = $entry['stock_quantity'] > 0 ? 'in_stock' : 'out_of_stock';
            }

            Product::updateOrCreate(['sku' => $entry['sku']], $attributes);
        }

        $productIds = Product::query()->whereIn('sku', array_column($data['products'], 'sku'))->pluck('id', 'sku');
        foreach ($data['images'] as $image) {
            ProductImage::updateOrCreate(
                ['product_id' => $productIds[$image['sku']], 'image_role' => $image['role']],
                ['image_url' => $image['path'], 'sort_order' => $image['sort_order'], 'cloudinary_public_id' => null],
            );
        }
    }
}
