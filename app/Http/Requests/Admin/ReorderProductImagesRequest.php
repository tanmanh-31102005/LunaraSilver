<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReorderProductImagesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'order' => ['required', 'array', 'min:1'],
            'order.*' => ['required', 'integer', 'exists:product_images,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'order.required' => 'Danh sách thứ tự hình ảnh không được để trống.',
            'order.array' => 'Dữ liệu thứ tự không hợp lệ.',
            'order.*.exists' => 'Một trong các hình ảnh không tồn tại trong hệ thống.',
        ];
    }
}
