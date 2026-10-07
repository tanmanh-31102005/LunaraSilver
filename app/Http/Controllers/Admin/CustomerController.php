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
        $customer360 = $this->customerInsightsService->getCustomer360($user);

        return view('admin.customers.show', $customer360);
    }
}
