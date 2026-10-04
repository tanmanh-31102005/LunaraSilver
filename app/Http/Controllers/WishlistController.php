<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    private const GUEST_SESSION_KEY = 'guest_wishlist';

    public function __construct(
        protected WishlistService $wishlistService
    ) {}

    /**
     * Display the wishlist page.
     */
    public function index(Request $request): View
    {
        $sessionIds = $request->session()->get(self::GUEST_SESSION_KEY, []);
        $products = $this->wishlistService->getWishlistProducts($request->user(), $sessionIds);
        $count = $this->wishlistService->count($request->user(), $sessionIds);

        $view = $request->user() ? 'account.wishlist.index' : 'account.wishlist.guest';

        return view($view, [
            'products' => $products,
            'count' => $count,
            'isGuest' => $request->user() === null,
        ]);
    }

    /**
     * AJAX status endpoint returning current wishlist product IDs and count.
     */
    public function status(Request $request): JsonResponse
    {
        $sessionIds = $request->session()->get(self::GUEST_SESSION_KEY, []);
        $ids = $this->wishlistService->getWishlistIds($request->user(), $sessionIds);
        $count = $this->wishlistService->count($request->user(), $sessionIds);

        return response()->json([
            'success' => true,
            'count' => $count,
            'items' => $ids,
        ]);
    }

    /**
     * Toggle product wishlist status (AJAX).
     */
    public function toggle(Request $request, int $product): JsonResponse
    {
        $sessionIds = $request->session()->get(self::GUEST_SESSION_KEY, []);
        $result = $this->wishlistService->toggle($product, $request->user(), $sessionIds);

        if (! $request->user()) {
            $request->session()->put(self::GUEST_SESSION_KEY, $sessionIds);
        }

        return response()->json([
            'success' => true,
            'product_id' => $product,
            'added' => $result['added'],
            'count' => $result['count'],
            'message' => $result['message'],
        ]);
    }

    /**
     * Remove a product from wishlist explicitly.
     */
    public function destroy(Request $request, int $product): JsonResponse|RedirectResponse
    {
        $sessionIds = $request->session()->get(self::GUEST_SESSION_KEY, []);
        $result = $this->wishlistService->remove($product, $request->user(), $sessionIds);

        if (! $request->user()) {
            $request->session()->put(self::GUEST_SESSION_KEY, $sessionIds);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'product_id' => $product,
                'count' => $result['count'],
                'message' => $result['message'],
            ]);
        }

        return back()->with('success', $result['message']);
    }
}
