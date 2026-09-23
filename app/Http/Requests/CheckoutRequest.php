<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s().-]{8,20}$/'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_note' => ['nullable', 'string', 'max:1000'],
            'customer_note' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cod'],
            'checkout_token' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Vui lòng nhập họ và tên người nhận.',
            'customer_email.required' => 'Vui lòng nhập email liên hệ.',
            'customer_email.email' => 'Địa chỉ email không đúng định dạng.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại nhận hàng.',
            'customer_phone.regex' => 'Số điện thoại không hợp lệ.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ giao hàng.',
            'shipping_city.required' => 'Vui lòng chọn hoặc nhập Tỉnh/Thành phố.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.in' => 'Phương thức thanh toán hiện tại chỉ hỗ trợ COD.',
            'checkout_token.required' => 'Phiên thanh toán không hợp lệ. Vui lòng tải lại trang.',
        ];
    }
}
