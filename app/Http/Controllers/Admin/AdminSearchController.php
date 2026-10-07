<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminSearchController extends Controller
{
    public function __construct(
        private AdminSearchService $searchService
    ) {}

    public function search(Request $request): JsonResponse
    {
        $keyword = trim((string) $request->input('q', ''));

        if (mb_strlen($keyword) > 100) {
            $keyword = mb_substr($keyword, 0, 100);
        }

        $results = $this->searchService->search($keyword);

        return response()->json([
            'query' => $keyword,
            'groups' => $results,
        ]);
    }
}
