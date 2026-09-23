<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('layouts.app', function ($view): void {
            $request = request();
            $carts = app(CartService::class);
            $cart = $carts->resolveCart($request->user(), $request->session()->get('lunara_cart_token'));
            $view->with('headerCart', $carts->summary($cart));
        });
    }
}
