<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    /**
     * Live search suggestions API endpoint for Search Overlay.
     *
     * GET /api/search/suggestions?q=
     */
    public function suggestions(Request $request): JsonResponse
    {
        $query = (string) $request->input('q', '');
        $data = $this->searchService->suggestions($query);

        return response()->json($data);
    }

    /**
     * Search results full page.
     *
     * GET /search?q=
     */
    public function index(Request $request): View
    {
        $query = (string) $request->input('q', '');
        $results = $this->searchService->searchResults($query);

        return view('search.index', [
            'query' => $results['query'],
            'products' => $results['products'],
            'posts' => $results['posts'],
            'categories' => $results['categories'],
            'totalProducts' => $results['total_products'],
        ]);
    }
}
