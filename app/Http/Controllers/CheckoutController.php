<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    private const SESSION_KEY = 'lunara_cart_token';

    public function __construct(
        private CartService $cartService,
        private CheckoutService $checkoutService
    ) {}

    public function show(Request $request): View|RedirectResponse
    {
        $cart = $this->getCart($request);

        if (! $cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')->with('cart_warning', 'Giỏ hàng của bạn đang trống. Vui lòng chọn sản phẩm trước khi thanh toán.');
        }

        $this->cartService->refreshPrices($cart);

        try {
            $this->cartService->validateCartInventory($cart);
        } catch (ValidationException $exception) {
            $errors = $exception->errors();

            return redirect()->route('cart.index')->with('cart_warning', reset($errors)[0] ?? 'Sản phẩm trong giỏ hàng vượt tồn kho.');
        }

        $checkoutToken = Str::random(40);
        $request->session()->put('checkout_token', $checkoutToken);
        $cartSummary = $this->cartService->summary($cart);

        $user = $request->user();
        $defaultAddress = $user?->defaultAddress();
        $savedAddresses = $user ? $user->addresses()->orderByDesc('is_default')->orderByDesc('id')->get() : collect();

        return view('checkout.show', compact(
            'cart',
            'cartSummary',
            'checkoutToken',
            'defaultAddress',
            'savedAddresses'
        ));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $sessionToken = $request->session()->get('checkout_token');
        $submittedToken = $request->input('checkout_token');

        if (! $sessionToken || ! hash_equals($sessionToken, (string) $submittedToken)) {
            throw ValidationException::withMessages([
                'checkout_token' => 'Phiên thanh toán đã hết hạn hoặc đã được xử lý. Vui lòng tải lại trang.',
            ]);
        }

        $cart = $this->getCart($request);

        if (! $cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')->with('cart_warning', 'Giỏ hàng của bạn đang trống.');
        }

        // Invalidate token to protect against double submit
        $request->session()->forget('checkout_token');

        try {
            $order = $this->checkoutService->processCheckout(
                $cart,
                $request->user(),
                $request->validated()
            );
        } catch (ValidationException $exception) {
            // Re-generate token so user can fix their input and retry without full reload
            $request->session()->put('checkout_token', Str::random(40));

            throw $exception;
        }

        // Store session authorization for guest order viewing
        $request->session()->put('last_order_code', $order->order_code);
        $authorized = (array) $request->session()->get('authorized_orders', []);
        $authorized[] = $order->id;
        $request->session()->put('authorized_orders', array_values(array_unique($authorized)));

        return redirect()->route('orders.success', $order->order_code);
    }

    public function success(Request $request, string $orderCode): View
    {
        $order = Order::query()
            ->where('order_code', $orderCode)
            ->with(['items.product.images', 'payment'])
            ->firstOrFail();

        // Authorization check
        if ($order->user_id !== null) {
            if (! auth()->check() || auth()->id() !== $order->user_id) {
                abort(403, 'Bạn không có quyền xem thông tin đơn hàng này.');
            }
        } else {
            $sessionAuthorized = $request->session()->get('last_order_code') === $order->order_code
                || in_array($order->id, (array) $request->session()->get('authorized_orders', []), true);

            if (! $sessionAuthorized) {
                abort(403, 'Bạn không có quyền xem thông tin đơn hàng này.');
            }
        }

        return view('checkout.success', compact('order'));
    }

    private function getCart(Request $request): ?Cart
    {
        $user = $request->user();
        $token = $request->session()->get(self::SESSION_KEY);

        return $this->cartService->resolveCart($user, $token);
    }
}
