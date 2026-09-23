<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request, CartService $carts): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $data['role'] = User::ROLE_USER;
        $user = User::create($data);
        Auth::login($user);
        $request->session()->regenerate();
        $this->mergeGuestCart($request, $carts);

        return redirect()->intended(route('home'));
    }

    public function login(Request $request, CartService $carts): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        $this->mergeGuestCart($request, $carts);

        if ($request->user()?->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function mergeGuestCart(Request $request, CartService $carts): void
    {
        $token = $request->session()->get('lunara_cart_token');
        $warning = $carts->mergeGuestCart($request->user(), $token);
        $request->session()->forget('lunara_cart_token');
        if ($warning) {
            $request->session()->flash('cart_warning', $warning);
        }
    }
}
