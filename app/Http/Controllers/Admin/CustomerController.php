<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\CustomerInsightsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerInsightsService $customerInsightsService
    ) {}

    public function index(Request $request): View
    {
        $customers = $this->customerInsightsService->getCustomersList($request, 15);

        return view('admin.customers.index', [
            'customers' => $customers,
            'currentFilter' => $request->input('filter', 'all'),
            'search' => $request->input('search', ''),
            'sort' => $request->input('sort', 'latest'),
        ]);
    }

    public function show(User $user): View
    {
        $summary = $this->customerInsightsService->getCustomerSummary($user);

        // Preload first page of Orders (active tab) so initial paint is instant with zero empty state
        $orders = $this->customerInsightsService->getCustomerOrders($user, 10);

        return view('admin.customers.show', [
            'user' => $user,
            'summary' => $summary,
            'counts' => $summary['counts'],
            'orders' => $orders,
        ]);
    }

    /**
     * Lazy-load individual tab contents on click with server-side pagination.
     */
    public function tab(Request $request, User $user, string $tab)
    {
        return match ($tab) {
            'orders' => view('admin.customers.tabs.orders', [
                'orders' => $this->customerInsightsService->getCustomerOrders($user, 10),
                'user' => $user,
            ]),
            'reviews' => view('admin.customers.tabs.reviews', [
                'reviews' => $this->customerInsightsService->getCustomerReviews($user, 10),
                'user' => $user,
            ]),
            'support' => view('admin.customers.tabs.support', array_merge(
                $this->customerInsightsService->getCustomerSupport($user),
                ['user' => $user]
            )),
            'coupons' => view('admin.customers.tabs.coupons', [
                'coupon_usages' => $this->customerInsightsService->getCustomerCoupons($user, 10),
                'user' => $user,
            ]),
            'addresses' => view('admin.customers.tabs.addresses', [
                'addresses' => $this->customerInsightsService->getCustomerAddresses($user),
                'user' => $user,
            ]),
            default => abort(404),
        };
    }
}
