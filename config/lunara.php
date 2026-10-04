<?php

return [
    'announcement' => env('LUNARA_ANNOUNCEMENT'),
    'low_stock_threshold' => (int) env('LUNARA_LOW_STOCK_THRESHOLD', 5),
    'contact_email' => env('LUNARA_CONTACT_EMAIL', 'lunaraslivertrangsuc@gmail.com'),
    'contact_phone' => env('LUNARA_CONTACT_PHONE', '0971 124 922'),
    'contact_address' => env('LUNARA_CONTACT_ADDRESS', '140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Ho Chi Minh City'),
    'opening_hours' => env('LUNARA_OPENING_HOURS', 'Thứ Hai — Thứ Bảy: 08:30 - 20:30 (Chủ Nhật: 09:00 - 18:00)'),
    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION', '4Gy0jMk2_McuovirJFJZl_h42XWvuNuoTCydAB2DqYI'),
];
