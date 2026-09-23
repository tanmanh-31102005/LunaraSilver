<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $ordersCount = $user->orders()->count();
        $latestOrder = $user->orders()->latest('placed_at')->latest('id')->first();
        $addressesCount = $user->addresses()->count();
        $defaultAddress = $user->defaultAddress();

        return view('account.dashboard', compact(
            'user',
            'ordersCount',
            'latestOrder',
            'addressesCount',
            'defaultAddress'
        ));
    }
}
