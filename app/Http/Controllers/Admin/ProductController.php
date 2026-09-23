<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Display a paginated listing of products with search, filters, and sorting.
     */
    public function index(Request $request): View
    {
        $query = Product::query()->with(['category', 'primaryImage', 'bundleItems.component']);

        // Search by name or SKU
        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter by Product Type
        if ($request->filled('product_type')) {
            $query->where('product_type', $request->input('product_type'));
        }

        // Filter by Active Status
        if ($request->filled('is_active')) {
            $query->where('is_active', (bool) $request->input('is_active'));
        }

        // Filter by Stock Status (for single products)
        if ($request->filled('stock_status')) {
            $status = $request->input('stock_status');
            if ($status === 'in_stock') {
                $query->where(function ($q): void {
                    $q->where('product_type', 'single')->where('stock_quantity', '>', 0)
                        ->orWhereIn('product_type', ['collection', 'gift']);
                });
            } elseif ($status === 'out_of_stock') {
                $query->where(function ($q): void {
                    $q->where('product_type', 'single')->where('stock_quantity', '<=', 0);
                });
            }
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        match ($sort) {
            'updated' => $query->orderByDesc('updated_at')->orderByDesc('id'),
            'name' => $query->orderBy('name')->orderBy('id'),
            'sku' => $query->orderBy('sku')->orderBy('id'),
            'price_asc' => $query->orderByRaw('CAST(CASE WHEN sale_price IS NOT NULL AND sale_price >= 0 AND sale_price <= regular_price THEN sale_price ELSE regular_price END AS DECIMAL(18,2)) ASC')->orderBy('id'),
            'price_desc' => $query->orderByRaw('CAST(CASE WHEN sale_price IS NOT NULL AND sale_price >= 0 AND sale_price <= regular_price THEN sale_price ELSE regular_price END AS DECIMAL(18,2)) DESC')->orderByDesc('id'),
            default => $query->latest('id'),
        };

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['q', 'category_id', 'product_type', 'is_active', 'stock_status', 'sort']),
        ]);
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();
        $singleProducts = Product::query()
            ->where('product_type', 'single')
            ->where('is_active', true)
            ->with('primaryImage')
            ->orderBy('name')
            ->get(['id', 'name', 'sku', 'regular_price', 'stock_quantity']);

        return view('admin.products.create', [
            'categories' => $categories,
            'singleProducts' => $singleProducts,
        ]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = $this->productService->createProduct($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Đã tạo thành công sản phẩm '{$product->name}' (SKU: {$product->sku}).");
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $product->load(['category', 'bundleItems.component.primaryImage', 'images']);
        $categories = Category::query()->orderBy('name')->get();
        $singleProducts = Product::query()
            ->where('product_type', 'single')
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->with('primaryImage')
            ->orderBy('name')
            ->get(['id', 'name', 'sku', 'regular_price', 'stock_quantity']);

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'singleProducts' => $singleProducts,
        ]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $updatedProduct = $this->productService->updateProduct($product, $request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Đã cập nhật thành công sản phẩm '{$updatedProduct->name}'.");
    }

    /**
     * Remove the specified product from storage (soft delete).
     */
    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Đã chuyển sản phẩm '{$name}' vào thùng rác.");
    }

    /**
     * Quick toggle is_active status.
     */
    public function toggleStatus(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        $statusLabel = $product->is_active ? 'Kích hoạt mở bán' : 'Tạm ẩn';
        $message = "Đã chuyển trạng thái sản phẩm '{$product->name}' sang {$statusLabel}.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $product->is_active,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Quick update stock quantity for single products.
     */
    public function quickStock(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        if ($product->product_type !== 'single') {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể chỉnh số lượng tồn kho trực tiếp cho sản phẩm dạng bộ.',
                ], 422);
            }

            return redirect()->back()->with('error', 'Không thể chỉnh số lượng tồn kho trực tiếp cho sản phẩm dạng bộ.');
        }

        $validated = $request->validate([
            'stock_quantity' => ['required', 'integer', 'min:0'],
        ]);

        $product->update(['stock_quantity' => $validated['stock_quantity']]);

        $message = "Đã cập nhật tồn kho cho '{$product->name}': {$product->stock_quantity} sản phẩm ({$product->stock_status}).";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'stock_quantity' => $product->stock_quantity,
                'stock_status' => $product->stock_status,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Duplicate an existing product.
     */
    public function duplicate(Product $product): RedirectResponse
    {
        $cloned = $this->productService->duplicateProduct($product);

        return redirect()
            ->route('admin.products.edit', $cloned)
            ->with('success', "Đã nhân bản sản phẩm thành công thành '{$cloned->name}' (SKU: {$cloned->sku}). Sản phẩm đang ở trạng thái Tạm ẩn để bạn kiểm tra thông tin.");
    }

    /**
     * Bulk actions on selected products.
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'string', 'in:activate,deactivate'],
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['integer', 'exists:products,id'],
        ]);

        $isActive = $validated['action'] === 'activate';
        $count = $this->productService->bulkUpdateStatus($validated['product_ids'], $isActive);

        $actionText = $isActive ? 'Kích hoạt mở bán' : 'Tạm ẩn';

        return redirect()->back()->with('success', "Đã {$actionText} thành công {$count} sản phẩm được chọn.");
    }
}
