<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index(Request $request): View
    {
        $query = Coupon::query()->withCount('usages');

        if ($search = trim((string) $request->input('q', ''))) {
            $query->where('code', 'like', "%{$search}%");
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('is_active', $request->boolean('status'));
        }

        $coupons = $query->orderByDesc('id')->paginate(15)->withQueryString();

        $stats = [
            'total' => Coupon::count(),
            'active' => Coupon::where('is_active', true)->count(),
            'inactive' => Coupon::where('is_active', false)->count(),
        ];

        return view('admin.coupons.index', compact('coupons', 'stats'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $products = Product::active()->orderBy('name')->get();

        return view('admin.coupons.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created coupon.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'type' => ['required', 'string', Rule::in(Coupon::TYPES)],
            'value' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === Coupon::TYPE_PERCENTAGE && $value > 100) {
                        $fail('Mức giảm theo phần trăm không được vượt quá 100%.');
                    }
                },
            ],
            'minimum_order' => ['nullable', 'numeric', 'min:0'],
            'maximum_discount' => ['nullable', 'numeric', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'usage_limit_per_user' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
            'is_first_order_only' => ['nullable', 'boolean'],
            'applicable_categories' => ['nullable', 'array'],
            'applicable_products' => ['nullable', 'array'],
            'applicable_customer_emails' => ['nullable', 'string'],
        ], [
            'code.required' => 'Vui lòng nhập mã ưu đãi.',
            'code.unique' => 'Mã ưu đãi này đã tồn tại trong hệ thống.',
            'value.required' => 'Vui lòng nhập giá trị giảm giá.',
            'expires_at.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày bắt đầu.',
        ]);

        $emailsInput = trim((string) $request->input('applicable_customer_emails', ''));
        $customerEmails = null;
        if ($emailsInput !== '') {
            $raw = preg_split('/[\r\n,]+/', $emailsInput);
            $customerEmails = array_values(array_filter(array_unique(array_map('strtolower', array_map('trim', $raw)))));
        }

        $categories = array_filter(array_map('intval', (array) $request->input('applicable_categories', [])));
        $products = array_filter(array_map('intval', (array) $request->input('applicable_products', [])));

        Coupon::create([
            'code' => $validated['code'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'minimum_order' => $validated['minimum_order'] ?? null,
            'maximum_discount' => $validated['maximum_discount'] ?? null,
            'starts_at' => $validated['starts_at'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'usage_limit' => $validated['usage_limit'] ?? null,
            'usage_limit_per_user' => $validated['usage_limit_per_user'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'is_first_order_only' => $request->boolean('is_first_order_only'),
            'applicable_categories' => ! empty($categories) ? array_values($categories) : null,
            'applicable_products' => ! empty($products) ? array_values($products) : null,
            'applicable_customer_emails' => ! empty($customerEmails) ? $customerEmails : null,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Đã tạo mã giảm giá mới thành công.');
    }

    /**
     * Display the specified coupon details and usage history.
     */
    public function show(Coupon $coupon): View
    {
        $coupon->load(['usages.order', 'usages.user']);
        $usages = $coupon->usages()->with(['order', 'user'])->orderByDesc('id')->paginate(20);

        $restrictedCategories = ! empty($coupon->applicable_categories)
            ? Category::whereIn('id', $coupon->applicable_categories)->get()
            : collect();

        $restrictedProducts = ! empty($coupon->applicable_products)
            ? Product::whereIn('id', $coupon->applicable_products)->get()
            : collect();

        return view('admin.coupons.show', compact('coupon', 'usages', 'restrictedCategories', 'restrictedProducts'));
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit(Coupon $coupon): View
    {
        $categories = Category::orderBy('name')->get();
        $products = Product::active()->orderBy('name')->get();

        return view('admin.coupons.edit', compact('coupon', 'categories', 'products'));
    }

    /**
     * Update the specified coupon.
     */
    public function update(Request $request, Coupon $coupon): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore($coupon->id)],
            'type' => ['required', 'string', Rule::in(Coupon::TYPES)],
            'value' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === Coupon::TYPE_PERCENTAGE && $value > 100) {
                        $fail('Mức giảm theo phần trăm không được vượt quá 100%.');
                    }
                },
            ],
            'minimum_order' => ['nullable', 'numeric', 'min:0'],
            'maximum_discount' => ['nullable', 'numeric', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'usage_limit_per_user' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
            'is_first_order_only' => ['nullable', 'boolean'],
            'applicable_categories' => ['nullable', 'array'],
            'applicable_products' => ['nullable', 'array'],
            'applicable_customer_emails' => ['nullable', 'string'],
        ], [
            'code.required' => 'Vui lòng nhập mã ưu đãi.',
            'code.unique' => 'Mã ưu đãi này đã tồn tại trong hệ thống.',
            'value.required' => 'Vui lòng nhập giá trị giảm giá.',
            'expires_at.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày bắt đầu.',
        ]);

        $emailsInput = trim((string) $request->input('applicable_customer_emails', ''));
        $customerEmails = null;
        if ($emailsInput !== '') {
            $raw = preg_split('/[\r\n,]+/', $emailsInput);
            $customerEmails = array_values(array_filter(array_unique(array_map('strtolower', array_map('trim', $raw)))));
        }

        $categories = array_filter(array_map('intval', (array) $request->input('applicable_categories', [])));
        $products = array_filter(array_map('intval', (array) $request->input('applicable_products', [])));

        $coupon->update([
            'code' => $validated['code'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'minimum_order' => $validated['minimum_order'] ?? null,
            'maximum_discount' => $validated['maximum_discount'] ?? null,
            'starts_at' => $validated['starts_at'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'usage_limit' => $validated['usage_limit'] ?? null,
            'usage_limit_per_user' => $validated['usage_limit_per_user'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'is_first_order_only' => $request->boolean('is_first_order_only'),
            'applicable_categories' => ! empty($categories) ? array_values($categories) : null,
            'applicable_products' => ! empty($products) ? array_values($products) : null,
            'applicable_customer_emails' => ! empty($customerEmails) ? $customerEmails : null,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Đã cập nhật mã giảm giá thành công.');
    }

    /**
     * Remove the specified coupon or soft disable if used (Rule 15.22).
     */
    public function destroy(Coupon $coupon): RedirectResponse
    {
        if ($coupon->used_count > 0 || $coupon->usages()->exists()) {
            $coupon->update(['is_active' => false]);

            return redirect()->route('admin.coupons.index')
                ->with('warning', "Mã giảm giá {$coupon->code} đã có lượt sử dụng trong các đơn hàng nên được vô hiệu hóa (tắt kích hoạt) thay vì xóa hoàn toàn.");
        }

        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', "Đã xóa mã giảm giá {$coupon->code} thành công.");
    }

    /**
     * Toggle the active status of a coupon.
     */
    public function toggle(Coupon $coupon): RedirectResponse
    {
        $coupon->update(['is_active' => ! $coupon->is_active]);
        $statusText = $coupon->is_active ? 'Kích hoạt' : 'Tắt kích hoạt';

        return back()->with('success', "Đã {$statusText} mã {$coupon->code} thành công.");
    }
}
