<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use RuntimeException;

final class CatalogData
{
    public static function load(): array
    {
        $path = database_path('data/catalog.json');
        $data = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        self::validate($data);

        return $data;
    }

    private static function validate(array $data): void
    {
        $categories = [];
        foreach ($data['categories'] as $category) {
            $slug = $category['slug'];
            if (isset($categories[$slug]) || blank($category['name'])) {
                throw new RuntimeException("Category {$slug}: duplicate slug or empty name in database/data/catalog.json");
            }
            $categories[$slug] = true;
        }

        $products = [];
        $slugs = [];
        foreach ($data['products'] as $product) {
            $sku = $product['sku'];
            $source = $product['source'];
            if (isset($products[$sku]) || blank($sku) || blank($product['name'])) {
                throw new RuntimeException("{$sku} sku/name {$source}: duplicate SKU or empty value");
            }
            if (! isset($categories[$product['category_slug']])) {
                throw new RuntimeException("{$sku} category {$source}: unknown {$product['category_slug']}");
            }
            if (! in_array($product['product_type'], Product::TYPES, true)) {
                throw new RuntimeException("{$sku} product_type {$source}: invalid value");
            }
            foreach (['regular_price', 'sale_price'] as $field) {
                $price = $product[$field];
                if ($price !== null && (! is_string($price) || ! preg_match('/^\d+\.\d{2}$/', $price))) {
                    throw new RuntimeException("{$sku} {$field} {$source}: invalid decimal");
                }
            }
            if ($product['regular_price'] === null || ($product['sale_price'] !== null && (int) str_replace('.', '', $product['sale_price']) > (int) str_replace('.', '', $product['regular_price']))) {
                throw new RuntimeException("{$sku} sale_price {$source}: higher than regular_price or regular_price missing");
            }
            if (! is_int($product['stock_quantity']) || $product['stock_quantity'] < 0) {
                throw new RuntimeException("{$sku} stock_quantity {$source}: invalid value");
            }
            $slug = Str::slug($product['name']);
            if ($slug === '') {
                throw new RuntimeException("{$sku} slug {$source}: empty slug");
            }
            if (isset($slugs[$slug])) {
                $slug .= '-'.Str::lower($sku);
            }
            if (isset($slugs[$slug])) {
                throw new RuntimeException("{$sku} slug {$source}: duplicate slug");
            }
            $slugs[$slug] = true;
            $products[$sku] = $product;
        }

        $images = [];
        foreach ($data['images'] as $image) {
            $sku = $image['sku'];
            $role = $image['role'];
            $path = $image['path'];
            if (! isset($products[$sku]) || ! in_array($role, ['primary', 'hover'], true)) {
                throw new RuntimeException("{$sku} image_role database/data/catalog.json: unknown product or role {$role}");
            }
            if (isset($images[$sku][$role])) {
                throw new RuntimeException("{$sku} image_role database/data/catalog.json: duplicate {$role}");
            }
            if (! str_starts_with($path, 'media/') || str_contains($path, '..') || ! is_file(base_path($path))) {
                throw new RuntimeException("{$sku} image_url database/data/catalog.json: missing or invalid {$path}");
            }
            $images[$sku][$role] = true;
        }
        $missing = [];
        foreach ($data['missing_images'] as $image) {
            $sku = $image['sku'];
            $role = $image['role'];
            if (! isset($products[$sku]) || isset($images[$sku][$role]) || isset($missing[$sku][$role]) || ! str_starts_with($image['expected'], 'media/')) {
                throw new RuntimeException("{$sku} missing image {$role} database/data/catalog.json: invalid declaration");
            }
            $missing[$sku][$role] = true;
        }
        foreach ($products as $sku => $product) {
            if (! isset($images[$sku]['primary']) && ! isset($missing[$sku]['primary'])) {
                throw new RuntimeException("{$sku} primary image {$product['source']}: missing without source declaration");
            }
            if ($product['product_type'] === 'single' && ! isset($images[$sku]['primary'])) {
                throw new RuntimeException("{$sku} primary image {$product['source']}: missing");
            }
        }

        $bundles = [];
        foreach ($data['bundles'] as $bundle) {
            $sku = $bundle['sku'];
            if (! isset($products[$sku]) || $products[$sku]['product_type'] === 'single' || isset($bundles[$sku])) {
                throw new RuntimeException("{$sku} bundle {$bundle['source']}: invalid or duplicate bundle");
            }
            $seen = [];
            foreach ($bundle['components'] as $component) {
                $child = $component['sku'];
                if (! isset($products[$child]) || $products[$child]['product_type'] !== 'single' || $child === $sku || isset($seen[$child]) || ! is_int($component['quantity']) || $component['quantity'] < 1) {
                    throw new RuntimeException("{$sku} component {$bundle['source']}: invalid reference {$child}");
                }
                $seen[$child] = true;
            }
            if ($seen === []) {
                throw new RuntimeException("{$sku} components {$bundle['source']}: empty bundle");
            }
            $bundles[$sku] = true;
        }
        foreach ($products as $sku => $product) {
            if ($product['product_type'] !== 'single' && ! isset($bundles[$sku])) {
                throw new RuntimeException("{$sku} bundle {$product['source']}: missing bundle_items");
            }
        }
    }
}
