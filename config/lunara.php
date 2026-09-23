<?php

return [
    'announcement' => env('LUNARA_ANNOUNCEMENT'),
    'low_stock_threshold' => (int) env('LUNARA_LOW_STOCK_THRESHOLD', 5),
];
