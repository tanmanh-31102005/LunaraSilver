<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'image_role' => ['sometimes', 'required', 'string', 'in:primary,hover,gallery'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'image_role.required' => 'Vai trò hình ảnh là bắt buộc.',
            'image_role.in' => 'Vai trò hình ảnh không hợp lệ (chỉ chấp nhận: primary, hover, gallery).',
            'alt_text.max' => 'Văn bản thay thế (Alt text) không được vượt quá 255 ký tự.',
            'sort_order.integer' => 'Thứ tự hiển thị phải là số nguyên.',
            'sort_order.min' => 'Thứ tự hiển thị không được nhỏ hơn 0.',
        ];
    }
}
