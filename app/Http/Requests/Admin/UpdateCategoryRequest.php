<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        $category = $this->route('category');
        $slug = $this->filled('slug')
            ? Str::slug($this->input('slug'))
            : ($this->filled('name') ? Str::slug($this->input('name')) : ($category?->slug ?? ''));

        $this->merge([
            'slug' => $slug,
            'is_active' => $this->boolean('is_active'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id ?? $this->route('category');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id', Rule::notIn([$categoryId])],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'slug.unique' => 'Đường dẫn (slug) này đã tồn tại, vui lòng chọn đường dẫn khác.',
            'parent_id.not_in' => 'Danh mục cha không thể là chính danh mục này.',
        ];
    }
}
