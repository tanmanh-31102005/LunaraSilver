<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        $product = $this->route('product');
        $slug = $this->filled('slug')
            ? Str::slug($this->input('slug'))
            : ($this->filled('name') ? Str::slug($this->input('name')) : ($product?->slug ?? ''));

        $this->merge([
            'sku' => $this->filled('sku') ? strtoupper(trim($this->input('sku'))) : null,
            'slug' => $slug,
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
            'stock_quantity' => $this->input('product_type') === 'single' ? (int) $this->input('stock_quantity', 0) : 0,
        ]);
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id ?? $this->route('product');

        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($productId)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($productId)],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'product_type' => ['required', 'string', 'in:'.implode(',', Product::TYPES)],
            'regular_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lte:regular_price'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'material' => ['nullable', 'string', 'max:255'],
            'stone' => ['nullable', 'string', 'max:255'],
            'weight' => ['nullable', 'string', 'max:255'],
            'size_info' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],

            // Bundle items validation
            'bundle_items' => ['nullable', 'array'],
            'bundle_items.*.product_id' => ['required_with:bundle_items', 'integer', 'exists:products,id', 'distinct', Rule::notIn([$productId])],
            'bundle_items.*.quantity' => ['required_with:bundle_items', 'integer', 'min:1'],

            // Image foundation validation
            'images' => ['nullable', 'array'],
            'images.*.id' => ['nullable', 'integer', 'exists:product_images,id'],
            'images.*.image_url' => ['required_with:images', 'string', 'max:500'],
            'images.*.image_role' => ['required_with:images', 'string', 'in:primary,hover,gallery'],
            'images.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'images.*.alt_text' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v): void {
            $type = $this->input('product_type');
            $bundleItems = $this->input('bundle_items', []);

            if (in_array($type, ['collection', 'gift'], true)) {
                if (empty($bundleItems) || ! is_array($bundleItems)) {
                    $v->errors()->add('bundle_items', 'Sản phẩm dạng bộ / quà tặng bắt buộc phải có ít nhất một sản phẩm thành phần.');

                    return;
                }

                $componentIds = array_filter(array_column($bundleItems, 'product_id'));
                if (! empty($componentIds)) {
                    $components = Product::query()->whereIn('id', $componentIds)->get(['id', 'product_type', 'name']);
                    foreach ($components as $component) {
                        if ($component->product_type !== 'single') {
                            $v->errors()->add('bundle_items', "Sản phẩm thành phần '{$component->name}' không phải là sản phẩm đơn lẻ (single). Không được phép lồng bộ sản phẩm vào nhau.");
                        }
                    }
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'sku.required' => 'Vui lòng nhập mã SKU.',
            'sku.unique' => 'Mã SKU này đã tồn tại trong hệ thống.',
            'slug.unique' => 'Đường dẫn (slug) này đã tồn tại, vui lòng chọn đường dẫn khác.',
            'category_id.required' => 'Vui lòng chọn danh mục cho sản phẩm.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',
            'regular_price.required' => 'Vui lòng nhập giá bán thông thường.',
            'regular_price.min' => 'Giá bán thông thường không được âm.',
            'sale_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá thông thường.',
            'sale_price.min' => 'Giá khuyến mãi không được âm.',
            'bundle_items.*.product_id.distinct' => 'Không được chọn trùng lặp cùng một sản phẩm thành phần.',
            'bundle_items.*.product_id.not_in' => 'Sản phẩm không thể chọn chính nó làm thành phần.',
            'bundle_items.*.quantity.min' => 'Số lượng thành phần phải lớn hơn hoặc bằng 1.',
        ];
    }
}
