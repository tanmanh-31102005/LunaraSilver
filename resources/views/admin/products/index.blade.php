@extends('admin.layouts.app')

@section('title', 'Quản lý Sản phẩm')
@section('page_title', 'Danh sách sản phẩm')

@section('breadcrumb')
    <li>/</li>
    <li class="text-dark">Sản phẩm</li>
@endsection

@section('content')
<div class="admin-card mb-4">
    {{-- Top Action Toolbar --}}
    <div class="admin-card-header flex-wrap gap-2 py-2">
        <div class="d-flex align-items-center gap-2">
            <h2 class="h6 mb-0 fw-bold">Kho sản phẩm</h2>
            <span class="badge bg-light text-dark border">{{ $products->total() }} sản phẩm</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-plus-lg"></i>
                <span>Thêm sản phẩm</span>
            </a>
        </div>
    </div>

    {{-- Filter & Search Toolbar --}}
    <div class="p-3 bg-light-subtle border-bottom">
        <form method="GET" action="{{ route('admin.products.index') }}" id="filterForm" class="row g-2 align-items-center">
            {{-- Search by name or SKU --}}
            <div class="col-md-3 col-sm-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Tìm tên hoặc SKU..." value="{{ request('q') }}">
                </div>
            </div>

            {{-- Category Filter --}}
            <div class="col-md-2 col-sm-6">
                <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Tất cả danh mục --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Product Type Filter --}}
            <div class="col-md-2 col-sm-6">
                <select name="product_type" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Loại sản phẩm --</option>
                    <option value="single" {{ request('product_type') === 'single' ? 'selected' : '' }}>Sản phẩm đơn (Single)</option>
                    <option value="collection" {{ request('product_type') === 'collection' ? 'selected' : '' }}>Bộ sưu tập (Collection)</option>
                    <option value="gift" {{ request('product_type') === 'gift' ? 'selected' : '' }}>Quà tặng (Gift)</option>
                </select>
            </div>

            {{-- Active Status Filter --}}
            <div class="col-md-2 col-sm-6">
                <select name="is_active" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Trạng thái --</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Đang mở bán</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Tạm ẩn</option>
                </select>
            </div>

            {{-- Stock Status Filter --}}
            <div class="col-md-1 col-sm-6">
                <select name="stock_status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Kho --</option>
                    <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>Còn</option>
                    <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>Hết</option>
                </select>
            </div>

            {{-- Sorting --}}
            <div class="col-md-2 col-sm-6">
                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="updated" {{ request('sort') === 'updated' ? 'selected' : '' }}>Cập nhật gần nhất</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Tên A-Z</option>
                    <option value="sku" {{ request('sort') === 'sku' ? 'selected' : '' }}>Mã SKU</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                </select>
            </div>
        </form>

        {{-- Active Filter Chips --}}
        @php
            $hasActiveFilters = request()->filled('q') || request()->filled('category_id') || request()->filled('product_type') || request()->filled('is_active') || request()->filled('stock_status') || (request()->filled('sort') && request('sort') !== 'newest');
        @endphp

        @if ($hasActiveFilters)
            <div class="d-flex align-items-center flex-wrap gap-2 mt-2 pt-2 border-top">
                <span class="text-muted small">Đang lọc theo:</span>

                @if (request()->filled('q'))
                    <span class="admin-filter-chip">
                        Từ khóa: "{{ request('q') }}"
                        <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" title="Bỏ lọc">&times;</a>
                    </span>
                @endif

                @if (request()->filled('category_id'))
                    @php $currentCat = $categories->firstWhere('id', request('category_id')); @endphp
                    @if ($currentCat)
                        <span class="admin-filter-chip">
                            Danh mục: {{ $currentCat->name }}
                            <a href="{{ request()->fullUrlWithQuery(['category_id' => null]) }}" title="Bỏ lọc">&times;</a>
                        </span>
                    @endif
                @endif

                @if (request()->filled('product_type'))
                    <span class="admin-filter-chip">
                        Loại: {{ ucfirst(request('product_type')) }}
                        <a href="{{ request()->fullUrlWithQuery(['product_type' => null]) }}" title="Bỏ lọc">&times;</a>
                    </span>
                @endif

                @if (request()->filled('is_active'))
                    <span class="admin-filter-chip">
                        Trạng thái: {{ request('is_active') === '1' ? 'Mở bán' : 'Tạm ẩn' }}
                        <a href="{{ request()->fullUrlWithQuery(['is_active' => null]) }}" title="Bỏ lọc">&times;</a>
                    </span>
                @endif

                @if (request()->filled('stock_status'))
                    <span class="admin-filter-chip">
                        Kho: {{ request('stock_status') === 'in_stock' ? 'Còn hàng' : 'Hết hàng' }}
                        <a href="{{ request()->fullUrlWithQuery(['stock_status' => null]) }}" title="Bỏ lọc">&times;</a>
                    </span>
                @endif

                @if (request()->filled('sort') && request('sort') !== 'newest')
                    <span class="admin-filter-chip">
                        Sắp xếp: {{ request('sort') }}
                        <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}" title="Bỏ lọc">&times;</a>
                    </span>
                @endif

                <a href="{{ route('admin.products.index') }}" class="btn btn-xs btn-link text-decoration-none p-0 small text-danger ms-auto">
                    Xóa tất cả bộ lọc
                </a>
            </div>
        @endif
    </div>

    {{-- Bulk Action Bar (Hidden by default, shown when items are checked) --}}
    <form method="POST" action="{{ route('admin.products.bulk-action') }}" id="bulkActionForm">
        @csrf
        <div id="bulkActionBar" class="p-2 bg-primary-subtle border-bottom d-none align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2 small">
                <i class="bi bi-check2-square text-primary fs-6"></i>
                <span class="fw-semibold text-primary" id="selectedCountText">Đã chọn 0 sản phẩm</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="submit" name="action" value="activate" class="btn btn-sm btn-success py-1 px-2" onclick="return confirmBulkAction('kích hoạt mở bán')">
                    <i class="bi bi-eye me-1"></i> Kích hoạt
                </button>
                <button type="submit" name="action" value="deactivate" class="btn btn-sm btn-warning py-1 px-2" onclick="return confirmBulkAction('tạm ẩn')">
                    <i class="bi bi-eye-slash me-1"></i> Tạm ẩn
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2" id="btnCancelBulk">
                    Bỏ chọn
                </button>
            </div>
        </div>

        {{-- Product Table --}}
        <div class="table-responsive">
            <table class="table admin-table align-middle table-hover">
                <thead>
                    <tr>
                        <th style="width: 36px;" class="text-center">
                            <input type="checkbox" class="form-check-input" id="selectAllCheckbox" title="Chọn tất cả">
                        </th>
                        <th style="width: 50px;">Ảnh</th>
                        <th>Mã SKU & Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th class="text-center">Loại</th>
                        <th class="text-end">Giá bán</th>
                        <th class="text-center">Tồn kho</th>
                        <th class="text-center">Trạng thái</th>
                        <th>Cập nhật</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            {{-- Checkbox --}}
                            <td class="text-center">
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="form-check-input product-select-checkbox">
                            </td>

                            {{-- Thumbnail --}}
                            <td>
                                @if ($product->primaryImage)
                                    <img src="{{ route('media.show', ['path' => $product->primaryImage->image_url]) }}" alt="{{ $product->name }}" class="rounded border" style="width: 44px; height: 44px; object-fit: cover;">
                                @else
                                    <div class="rounded border bg-light text-muted d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 0.75rem;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>

                            {{-- SKU & Name --}}
                            <td>
                                <div class="fw-semibold text-dark text-truncate" style="max-width: 240px;" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <span class="badge bg-light text-dark font-monospace border" style="font-size: 0.675rem;">{{ $product->sku }}</span>
                                    @if ($product->is_featured)
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size: 0.625rem;">Nổi bật</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Category --}}
                            <td>
                                <span class="text-secondary small">{{ $product->category?->name ?? '—' }}</span>
                            </td>

                            {{-- Type --}}
                            <td class="text-center">
                                @if ($product->product_type === 'single')
                                    <span class="admin-badge admin-badge-secondary">Single</span>
                                @elseif ($product->product_type === 'collection')
                                    <span class="admin-badge admin-badge-purple" title="{{ $product->bundleItems->count() }} thành phần">Collection</span>
                                @else
                                    <span class="admin-badge admin-badge-info" title="{{ $product->bundleItems->count() }} thành phần">Gift</span>
                                @endif
                            </td>

                            {{-- Price (Right-aligned) --}}
                            <td class="text-end font-monospace">
                                <div class="fw-semibold">{{ number_format($product->sale_price ?? $product->regular_price) }}đ</div>
                                @if ($product->sale_price)
                                    <div class="text-muted" style="font-size: 0.725rem; text-decoration: line-through;">{{ number_format($product->regular_price) }}đ</div>
                                @endif
                            </td>

                            {{-- Inventory (Center-aligned) --}}
                            <td class="text-center">
                                @if ($product->product_type === 'single')
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <span class="fw-semibold font-monospace {{ $product->stock_quantity <= (int)config('lunara.low_stock_threshold', 5) ? ($product->stock_quantity == 0 ? 'text-danger' : 'text-warning') : 'text-dark' }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                        <button type="button" class="btn btn-xs text-muted p-0" title="Cập nhật nhanh tồn kho" onclick="openQuickStockModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->stock_quantity }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                @else
                                    @php $bundleQty = $product->availableQuantity(); @endphp
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fw-semibold font-monospace {{ $bundleQty == 0 ? 'text-danger' : 'text-primary' }}">
                                            {{ $bundleQty }} bộ
                                        </span>
                                        <span class="text-muted" style="font-size: 0.65rem;">Tính từ thành phần</span>
                                    </div>
                                @endif
                            </td>

                            {{-- Status with Quick Toggle --}}
                            <td class="text-center">
                                <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-xs p-0 border-0 bg-transparent" title="Nhấn để đổi trạng thái">
                                        @if ($product->is_active)
                                            <span class="admin-badge admin-badge-success" style="cursor: pointer;">
                                                <i class="bi bi-check-circle-fill"></i> Active
                                            </span>
                                        @else
                                            <span class="admin-badge admin-badge-danger" style="cursor: pointer;">
                                                <i class="bi bi-dash-circle-fill"></i> Inactive
                                            </span>
                                        @endif
                                    </button>
                                </form>
                            </td>

                            {{-- Updated At --}}
                            <td class="small text-muted" style="font-size: 0.75rem;">
                                {{ $product->updated_at->format('d/m/Y H:i') }}
                            </td>

                            {{-- Actions --}}
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-secondary" title="Chỉnh sửa chi tiết">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    {{-- Duplicate --}}
                                    <button type="button" class="btn btn-outline-secondary" title="Nhân bản sản phẩm" onclick="confirmDuplicate({{ $product->id }}, '{{ addslashes($product->name) }}')">
                                        <i class="bi bi-copy"></i>
                                    </button>

                                    {{-- Delete (Soft delete) --}}
                                    <button type="button" class="btn btn-outline-danger" title="Xóa sản phẩm" onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="bi bi-gem fs-2 text-muted d-block mb-2"></i>
                                <div class="fw-semibold">Không tìm thấy sản phẩm phù hợp.</div>
                                <div class="small mb-3">Thử thay đổi từ khóa tìm kiếm hoặc các tùy chọn bộ lọc.</div>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                                    Xóa tất cả bộ lọc
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    {{-- Compact Pagination Footer --}}
    @if ($products->hasPages() || $products->total() > 0)
        <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Hiển thị <strong>{{ $products->firstItem() ?? 0 }}</strong> – <strong>{{ $products->lastItem() ?? 0 }}</strong> / <strong>{{ $products->total() }}</strong> sản phẩm
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </div>
    @endif
</div>

{{-- Hidden Form for Delete Action --}}
<form id="deleteProductForm" method="POST" action="" class="d-none">
    @csrf
    @method('DELETE')
</form>

{{-- Hidden Form for Duplicate Action --}}
<form id="duplicateProductForm" method="POST" action="" class="d-none">
    @csrf
</form>

{{-- Quick Stock Modal --}}
<div class="modal fade" id="quickStockModal" tabindex="-1" aria-labelledby="quickStockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form method="POST" action="" id="quickStockForm">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header py-2 px-3 border-bottom">
                    <h6 class="modal-title fw-bold" id="quickStockModalLabel">Chỉnh tồn kho nhanh</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body py-3 px-3">
                    <div class="small text-muted mb-2 text-truncate" id="quickStockProductName"></div>
                    <label for="modalStockQuantity" class="form-label small fw-semibold">Số lượng tồn kho mới:</label>
                    <input type="number" class="form-control form-control-sm font-monospace" id="modalStockQuantity" name="stock_quantity" min="0" required>
                    <div class="form-text small">Tồn kho = 0 sẽ đổi trạng thái thành Hết hàng.</div>
                </div>
                <div class="modal-footer py-2 px-3 border-top">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-sm btn-primary">Lưu tồn kho</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Checkbox selection for Bulk Actions
    const selectAll = document.getElementById('selectAllCheckbox');
    const itemCheckboxes = document.querySelectorAll('.product-select-checkbox');
    const bulkBar = document.getElementById('bulkActionBar');
    const countText = document.getElementById('selectedCountText');
    const btnCancelBulk = document.getElementById('btnCancelBulk');

    function updateBulkState() {
        const checkedCount = document.querySelectorAll('.product-select-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkBar.classList.remove('d-none');
            bulkBar.classList.add('d-flex');
            countText.textContent = 'Đã chọn ' + checkedCount + ' sản phẩm';
        } else {
            bulkBar.classList.add('d-none');
            bulkBar.classList.remove('d-flex');
        }

        if (selectAll) {
            selectAll.checked = (checkedCount === itemCheckboxes.length && itemCheckboxes.length > 0);
            selectAll.indeterminate = (checkedCount > 0 && checkedCount < itemCheckboxes.length);
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            itemCheckboxes.forEach(cb => { cb.checked = selectAll.checked; });
            updateBulkState();
        });
    }

    itemCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkState);
    });

    if (btnCancelBulk) {
        btnCancelBulk.addEventListener('click', function () {
            if (selectAll) selectAll.checked = false;
            itemCheckboxes.forEach(cb => { cb.checked = false; });
            updateBulkState();
        });
    }
});

// Modal Confirmation for Bulk Action
function confirmBulkAction(actionName) {
    const count = document.querySelectorAll('.product-select-checkbox:checked').length;
    if (count === 0) {
        alert('Vui lòng chọn ít nhất một sản phẩm!');
        return false;
    }
    return confirm('Bạn có chắc chắn muốn ' + actionName + ' cho ' + count + ' sản phẩm đã chọn?');
}

// Modal Confirmation for Delete
function confirmDelete(id, name) {
    window.adminConfirm({
        title: 'Chuyển vào thùng rác',
        message: 'Bạn có chắc chắn muốn xóa sản phẩm "' + name + '"? Sản phẩm sẽ được chuyển vào thùng rác (xóa mềm).',
        confirmText: 'Xóa sản phẩm',
        confirmClass: 'btn-danger',
        onConfirm: function () {
            const form = document.getElementById('deleteProductForm');
            form.action = '/admin/products/' + id;
            form.submit();
        }
    });
}

// Modal Confirmation for Duplicate
function confirmDuplicate(id, name) {
    window.adminConfirm({
        title: 'Nhân bản sản phẩm',
        message: 'Tạo bản sao mới cho sản phẩm "' + name + '"? Bản sao sẽ có mã SKU mới và ở trạng thái Tạm ẩn.',
        confirmText: 'Nhân bản ngay',
        confirmClass: 'btn-primary',
        onConfirm: function () {
            const form = document.getElementById('duplicateProductForm');
            form.action = '/admin/products/' + id + '/duplicate';
            form.submit();
        }
    });
}

// Quick Stock Modal
function openQuickStockModal(id, name, currentStock) {
    const modalEl = document.getElementById('quickStockModal');
    const form = document.getElementById('quickStockForm');
    const nameEl = document.getElementById('quickStockProductName');
    const input = document.getElementById('modalStockQuantity');

    form.action = '/admin/products/' + id + '/quick-stock';
    nameEl.textContent = name;
    input.value = currentStock;

    const modal = new bootstrap.Modal(modalEl);
    modal.show();
    setTimeout(() => { input.focus(); input.select(); }, 400);
}
</script>
@endpush
