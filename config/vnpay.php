<?php

return [
    /*
    |--------------------------------------------------------------------------
    | VNPay Configuration
    |--------------------------------------------------------------------------
    |
    | Credentials and endpoints for VNPay Sandbox / Production integration.
    |
    */

    'tmn_code' => env('VNPAY_TMN_CODE', '7OO2Y0S8'),

    'hash_secret' => env('VNPAY_HASH_SECRET', 'TRPSTTTYPHQWBATDQWCUWMANEWXLZMGE'),

    'url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),

    'api_url' => env('VNPAY_API_URL', 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction'),

    'return_url' => env('VNPAY_RETURN_URL'),

    'reconciliation_mode' => env('VNPAY_RECONCILIATION_MODE', 'query'),

    'query_cooldown_seconds' => (int) env('VNPAY_QUERY_COOLDOWN_SECONDS', 15),

    'version' => '2.1.0',

    'currency' => 'VND',

    'locale' => 'vn',
];
