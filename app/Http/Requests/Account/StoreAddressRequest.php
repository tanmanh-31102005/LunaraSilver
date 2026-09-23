<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{9,20}$/'],
            'address_line' => ['required', 'string', 'max:500'],
            'ward' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'is_default' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'recipient_name.required' => 'Họ và tên người nhận là bắt buộc.',
            'recipient_name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'phone.required' => 'Số điện thoại nhận hàng là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ (phải từ 9 - 20 số).',
            'address_line.required' => 'Địa chỉ chi tiết là bắt buộc.',
            'city.required' => 'Tỉnh / Thành phố là bắt buộc.',
        ];
    }
}
