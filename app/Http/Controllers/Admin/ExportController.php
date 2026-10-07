<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ExportService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public const ALLOWED_TYPES = [
        'orders',
        'products',
        'inventory',
        'customers',
        'revenue',
        'coupons',
    ];

    public function __construct(
        private ExportService $exportService
    ) {}

    public function export(Request $request, string $type): StreamedResponse
    {
        if (! in_array($type, self::ALLOWED_TYPES, true)) {
            abort(404, 'Loại dữ liệu xuất không tồn tại.');
        }

        return $this->exportService->export($type, $request);
    }
}
