<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Services\CartService;
use App\Services\CouponService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{
    private const SESSION_KEY = 'lunara_cart_token';

    public function __construct(private CartService $carts) {}

    public function index(Request $request): View
    {
        return view('cart.index', ['cartSummary' => $this->carts->summary($this->getCart($request))]);
    }

    public function summary(Request $request): JsonResponse
    {
        return response()->json(['success' => true] + $this->carts->summary($this->getCart($request)));
    }

    public function store(Request $request): JsonResponse
    {
        return $this->respond($request, function () use ($request): array {
            $data = $request->validate([
                'product_id' => ['required', 'integer', 'min:1'],
                'quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            ]);

            $cart = $this->getCart($request, true);

            return $this->carts->add($cart, (int) $data['product_id'], (int) $data['quantity']);
        }, 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, int $item): JsonResponse
    {
        return $this->respond($request, function () use ($request, $item): array {
            $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:1000']]);

            $cart = $this->getCart($request);
            if (! $cart) {
                throw (new ModelNotFoundException)->setModel(CartItem::class, [$item]);
            }

            return $this->carts->update($cart, $item, (int) $data['quantity']);
        }, 'Đã cập nhật số lượng.');
    }

    public function destroy(Request $request, int $item): JsonResponse
    {
        return $this->respond($request, function () use ($request, $item): array {
            $cart = $this->getCart($request);
            if (! $cart) {
                throw (new ModelNotFoundException)->setModel(CartItem::class, [$item]);
            }

            return $this->carts->remove($cart, $item);
        }, 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function clear(Request $request): JsonResponse
    {
        $cart = $this->getCart($request);

        return response()->json(
            $this->carts->clear($cart)
        );
    }

    public function applyCoupon(Request $request, CouponService $couponService): JsonResponse|RedirectResponse
    {
        $code = trim((string) $request->input('code', ''));
        $cart = $this->getCart($request);

        if (! $cart || $cart->items()->count() === 0) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng của bạn đang trống.',
                ], 422);
            }

            return back()->withErrors(['coupon' => 'Giỏ hàng của bạn đang trống.']);
        }

        $summary = $this->carts->summary($cart);
        $subtotal = (float) $summary['subtotal'];

        try {
            $validation = $couponService->validate($code, $subtotal, $request->user());
            $request->session()->put('coupon_code', $validation['code']);

            $newSummary = $this->carts->summary($cart);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $validation['message'],
                ] + $newSummary);
            }

            return back()->with('coupon_success', $validation['message']);
        } catch (ValidationException $e) {
            $request->session()->forget('coupon_code');

            if ($request->wantsJson()) {
                $errors = $e->errors();

                return response()->json([
                    'success' => false,
                    'message' => reset($errors)[0] ?? 'Mã ưu đãi không hợp lệ.',
                    'errors' => $errors,
                ] + $this->carts->summary($cart), 422);
            }

            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function removeCoupon(Request $request): JsonResponse|RedirectResponse
    {
        $request->session()->forget('coupon_code');
        $cart = $this->getCart($request);
        $summary = $this->carts->summary($cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã gỡ bỏ mã ưu đãi.',
            ] + $summary);
        }

        return back()->with('coupon_success', 'Đã gỡ bỏ mã ưu đãi.');
    }

    private function getCart(Request $request, bool $create = false): ?Cart
    {
        $user = $request->user();
        $token = $request->session()->get(self::SESSION_KEY);

        if (! $user && ! $token && $create) {
            $token = Str::random(64);
            $request->session()->put(self::SESSION_KEY, $token);
        }

        return $this->carts->resolveCart($user, $token, $create);
    }

    private function respond(Request $request, callable $action, string $message): JsonResponse
    {
        try {
            return response()->json(['success' => true, 'message' => $message] + $action());
        } catch (ValidationException $exception) {
            $errors = $exception->errors();

            return response()->json([
                'success' => false,
                'message' => reset($errors)[0],
                'errors' => $errors,
            ] + $this->carts->summary($this->getCart($request)), 422);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không thuộc giỏ hàng này.',
            ] + $this->carts->summary($this->getCart($request)), 404);
        }
    }
}
