<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'image_role' => ['nullable', 'string', 'in:primary,hover,gallery'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Vui lòng chọn ít nhất một hình ảnh để tải lên.',
            'images.array' => 'Dữ liệu tải lên không hợp lệ.',
            'images.min' => 'Vui lòng chọn ít nhất một hình ảnh để tải lên.',
            'images.*.required' => 'Tập tin tải lên không được để trống.',
            'images.*.file' => 'Tập tin tải lên không hợp lệ.',
            'images.*.image' => 'Tập tin phải là định dạng hình ảnh.',
            'images.*.mimes' => 'Chỉ chấp nhận các định dạng ảnh: JPG, JPEG, PNG, WEBP.',
            'images.*.max' => 'Dung lượng mỗi hình ảnh không được vượt quá 5MB.',
            'image_role.in' => 'Vai trò hình ảnh không hợp lệ (chỉ chấp nhận: primary, hover, gallery).',
            'alt_text.max' => 'Văn bản thay thế (Alt text) không được vượt quá 255 ký tự.',
        ];
    }
}
