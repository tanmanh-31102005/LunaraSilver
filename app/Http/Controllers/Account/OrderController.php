<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->withCount('items')
            ->latest('placed_at')
            ->latest('id')
            ->paginate(10);

        return view('account.orders.index', compact('orders'));
    }

    public function show(Request $request, string $orderCode): View
    {
        $order = Order::query()
            ->where('order_code', $orderCode)
            ->with(['items.product.images', 'payment'])
            ->firstOrFail();

        if ($order->user_id === null || $order->user_id !== $request->user()->id) {
            abort(403, 'Bạn không có quyền xem thông tin đơn hàng này.');
        }

        return view('account.orders.show', compact('order'));
    }
}
