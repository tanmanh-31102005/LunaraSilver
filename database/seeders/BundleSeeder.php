<?php

namespace Database\Seeders;

use App\Models\BundleItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class BundleSeeder extends Seeder
{
    public function run(): void
    {
        $data = CatalogData::load();
        $productIds = Product::query()->whereIn('sku', array_column($data['products'], 'sku'))->pluck('id', 'sku');

        foreach ($data['bundles'] as $bundle) {
            foreach ($bundle['components'] as $order => $component) {
                BundleItem::updateOrCreate(
                    ['bundle_product_id' => $productIds[$bundle['sku']], 'component_product_id' => $productIds[$component['sku']]],
                    ['quantity' => $component['quantity'], 'sort_order' => $order],
                );
            }
        }
    }
}
