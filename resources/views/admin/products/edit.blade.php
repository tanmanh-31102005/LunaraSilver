@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa: ' . $product->name)
@section('page_title', 'Chỉnh sửa sản phẩm: ' . $product->sku)

@section('breadcrumb')
    <li>/</li>
    <li><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
    <li>/</li>
    <li class="text-dark">Sửa: {{ $product->sku }}</li>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.products.update', $product) }}" id="productForm">
    @csrf
    @method('PUT')

    <div class="row g-4 mb-5">
        {{-- Left Column: Main content --}}
        <div class="col-lg-8">
            {{-- Section 1: Basic Info --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header bg-white py-2 px-3 d-flex justify-content-between align-items-center">
                    <h2 class="h6 mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle text-primary"></i>
                        <span>1. Thông tin cơ bản</span>
                    </h2>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn btn-xs btn-outline-info d-flex align-items-center gap-1">
                            <i class="bi bi-box-arrow-up-right"></i>
                            <span>Xem storefront</span>
                        </a>
                    </div>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="sku" class="form-label fw-semibold small">Mã SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm font-monospace text-uppercase @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="slug" class="form-label fw-semibold small">Đường dẫn (Slug) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm font-monospace @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label fw-semibold small">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="product_type" class="form-label fw-semibold small">Loại sản phẩm <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm @error('product_type') is-invalid @enderror" id="product_type" name="product_type" required>
                                <option value="single" {{ old('product_type', $product->product_type) === 'single' ? 'selected' : '' }}>Sản phẩm đơn (Single)</option>
                                <option value="collection" {{ old('product_type', $product->product_type) === 'collection' ? 'selected' : '' }}>Bộ sưu tập (Collection)</option>
                                <option value="gift" {{ old('product_type', $product->product_type) === 'gift' ? 'selected' : '' }}>Quà tặng (Gift)</option>
                            </select>
                            @error('product_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Pricing & Inventory --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header bg-white py-2 px-3">
                    <h2 class="h6 mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="bi bi-tag text-primary"></i>
                        <span>2. Giá bán & Tồn kho</span>
                    </h2>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label for="regular_price" class="form-label fw-semibold small">Giá niêm yết (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm font-monospace @error('regular_price') is-invalid @enderror" id="regular_price" name="regular_price" value="{{ old('regular_price', (int)$product->regular_price) }}" min="0" step="1000" required>
                            @error('regular_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="sale_price" class="form-label fw-semibold small">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" class="form-control form-control-sm font-monospace @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price ? (int)$product->sale_price : '') }}" min="0" step="1000" placeholder="Để trống nếu không giảm">
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Live Pricing Preview --}}
                    <div id="pricingPreviewBox" class="p-2 rounded bg-light border mb-3 small d-flex align-items-center justify-content-between">
                        <span class="text-muted">Giá áp dụng thực tế:</span>
                        <span id="effectivePriceDisplay" class="fw-bold text-primary font-monospace">0 ₫</span>
                    </div>

                    <div class="row g-3" id="singleStockContainer">
                        <div class="col-md-6">
                            <label for="stock_quantity" class="form-label fw-semibold small">Số lượng tồn kho <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm font-monospace @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0">
                            <div class="form-text small">Tồn kho = 0 sẽ tự động đổi sang trạng thái Hết hàng.</div>
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-secondary border-0 mt-3 mb-0 small" id="bundleStockNotice" style="{{ in_array($product->product_type, ['collection', 'gift'], true) ? '' : 'display: none;' }}">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <i class="bi bi-info-circle-fill me-1 text-primary"></i>
                                <strong>Sản phẩm dạng bộ:</strong> Tồn kho được tính tự động từ các sản phẩm thành phần.
                            </div>
                            <div>
                                Khả dụng hiện tại: <strong class="badge bg-primary fs-6 font-monospace">{{ $product->availableQuantity() }}</strong> bộ
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 3: Bundle Components --}}
            @include('admin.products.partials.bundle-editor')

            {{-- Section 4: Image Management --}}
            @include('admin.products.partials.image-manager')

            {{-- Section 5: Descriptions & Specifications --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header bg-white py-2 px-3">
                    <h2 class="h6 mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="bi bi-file-text text-primary"></i>
                        <span>3. Mô tả & Thông số chế tác</span>
                    </h2>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label for="short_description" class="form-label fw-semibold small">Mô tả ngắn</label>
                        <textarea class="form-control form-control-sm" id="short_description" name="short_description" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold small">Nội dung chi tiết</label>
                        <textarea class="form-control form-control-sm" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="material" class="form-label fw-semibold small">Chất liệu</label>
                            <input type="text" class="form-control form-control-sm" id="material" name="material" value="{{ old('material', $product->material) }}">
                        </div>

                        <div class="col-sm-6">
                            <label for="stone" class="form-label fw-semibold small">Đá đính kèm</label>
                            <input type="text" class="form-control form-control-sm" id="stone" name="stone" value="{{ old('stone', $product->stone) }}">
                        </div>

                        <div class="col-sm-6">
                            <label for="weight" class="form-label fw-semibold small">Trọng lượng</label>
                            <input type="text" class="form-control form-control-sm" id="weight" name="weight" value="{{ old('weight', $product->weight) }}">
                        </div>

                        <div class="col-sm-6">
                            <label for="size_info" class="form-label fw-semibold small">Kích thước / Size</label>
                            <input type="text" class="form-control form-control-sm" id="size_info" name="size_info" value="{{ old('size_info', $product->size_info) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 5: Product Images (Cloudinary & Local Media) --}}
            @include('admin.products.partials.image-manager', ['product' => $product])
        </div>

        {{-- Right Column: Status & SEO --}}
        <div class="col-lg-4">
            {{-- Status & Visibility --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header bg-white py-2 px-3">
                    <h2 class="h6 mb-0 fw-bold">Trạng thái & Hiển thị</h2>
                </div>
                <div class="admin-card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold small" for="is_active">Kích hoạt mở bán (Active)</label>
                        <div class="form-text small">Nếu tắt, sản phẩm sẽ ẩn khỏi storefront và chi tiết trả về 404.</div>
                    </div>

                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ? '1' : '0') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold small" for="is_featured">Sản phẩm nổi bật (Featured)</label>
                        <div class="form-text small">Ưu tiên hiển thị tại trang chủ.</div>
                    </div>
                </div>
            </div>

            {{-- SEO Metadata --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header bg-white py-2 px-3">
                    <h2 class="h6 mb-0 fw-bold">Tối ưu hóa SEO</h2>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label for="seo_title" class="form-label fw-semibold small">Tiêu đề SEO</label>
                        <input type="text" class="form-control form-control-sm" id="seo_title" name="seo_title" value="{{ old('seo_title', $product->seo_title) }}">
                    </div>

                    <div class="mb-0">
                        <label for="seo_description" class="form-label fw-semibold small">Mô tả SEO</label>
                        <textarea class="form-control form-control-sm" id="seo_description" name="seo_description" rows="3">{{ old('seo_description', $product->seo_description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Audit Trail info --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header bg-white py-2 px-3">
                    <h2 class="h6 mb-0 fw-bold">Thông tin cập nhật</h2>
                </div>
                <div class="admin-card-body small text-muted">
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span>Ngày tạo:</span>
                        <span class="font-monospace text-dark">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span>Cập nhật lần cuối:</span>
                        <span class="font-monospace text-dark">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sticky Save Bar --}}
    <div class="admin-sticky-save-bar">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-x-lg me-1"></i> Hủy bỏ
            </a>
            <span class="text-muted small d-none d-sm-inline" id="unsavedChangesStatus">Chưa có thay đổi</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-sm btn-primary px-4 fw-semibold" id="btnSubmitForm">
                <i class="bi bi-check2 me-1"></i> Cập nhật sản phẩm
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('productForm');
    let isFormDirty = false;
    let isSubmitting = false;

    // --- Unsaved Changes Warning ---
    form.addEventListener('input', function () {
        isFormDirty = true;
        const statusEl = document.getElementById('unsavedChangesStatus');
        if (statusEl) {
            statusEl.textContent = 'Có thay đổi chưa lưu';
            statusEl.className = 'text-warning fw-medium small d-none d-sm-inline';
        }
    });

    form.addEventListener('submit', function () {
        isSubmitting = true;
    });

    window.addEventListener('beforeunload', function (e) {
        if (isFormDirty && !isSubmitting) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // --- Pricing Calculation Preview ---
    const regInput = document.getElementById('regular_price');
    const saleInput = document.getElementById('sale_price');
    const priceDisplay = document.getElementById('effectivePriceDisplay');

    function updatePricePreview() {
        const reg = parseFloat(regInput.value) || 0;
        const sale = parseFloat(saleInput.value);

        if (!isNaN(sale) && sale >= 0 && sale <= reg) {
            const discount = Math.round(((reg - sale) / reg) * 100);
            priceDisplay.innerHTML = new Intl.NumberFormat('vi-VN').format(sale) + ' ₫ <span class="badge bg-success-subtle text-success border border-success-subtle ms-1">Giảm ' + discount + '%</span>';
        } else if (!isNaN(sale) && sale > reg) {
            priceDisplay.innerHTML = '<span class="text-danger small">Giá KM phải &le; Giá niêm yết</span>';
        } else {
            priceDisplay.textContent = new Intl.NumberFormat('vi-VN').format(reg) + ' ₫';
        }
    }

    regInput.addEventListener('input', updatePricePreview);
    saleInput.addEventListener('input', updatePricePreview);
    updatePricePreview();

    // --- Product Type Toggle ---
    const typeSelect = document.getElementById('product_type');
    const bundleCard = document.getElementById('bundleEditorCard');
    const singleStockContainer = document.getElementById('singleStockContainer');
    const bundleStockNotice = document.getElementById('bundleStockNotice');
    const stockQuantityInput = document.getElementById('stock_quantity');

    function handleTypeChange() {
        const type = typeSelect.value;
        if (type === 'collection' || type === 'gift') {
            bundleCard.style.display = 'block';
            singleStockContainer.style.display = 'none';
            bundleStockNotice.style.display = 'block';
            if (stockQuantityInput) stockQuantityInput.disabled = true;
        } else {
            bundleCard.style.display = 'none';
            singleStockContainer.style.display = 'flex';
            bundleStockNotice.style.display = 'none';
            if (stockQuantityInput) stockQuantityInput.disabled = false;
        }
    }

    typeSelect.addEventListener('change', handleTypeChange);
    handleTypeChange();

    // --- Bundle Items Live Recalculation ---
    const btnAddBundle = document.getElementById('btnAddBundleItem');
    const bundleContainer = document.getElementById('bundleItemsContainer');
    const bundleTemplate = document.getElementById('bundleRowTemplate');
    const computedEl = document.getElementById('bundleComputedLive');
    let bundleIndex = {{ count(old('bundle_items', $product->bundleItems)) + 20 }};

    function recalculateBundleAvailability() {
        if (!bundleContainer || !computedEl) return;
        const rows = bundleContainer.querySelectorAll('.bundle-row');
        if (rows.length === 0) {
            computedEl.textContent = '';
            return;
        }

        let minAvailable = Infinity;
        rows.forEach(row => {
            const select = row.querySelector('.bundle-component-select');
            const qtyInput = row.querySelector('.bundle-quantity-input');
            const opt = select?.options[select.selectedIndex];
            const stock = parseInt(opt?.getAttribute('data-stock') || '0', 10);
            const reqQty = parseInt(qtyInput?.value || '1', 10);

            if (select?.value && reqQty > 0) {
                const canMake = Math.floor(stock / reqQty);
                minAvailable = Math.min(minAvailable, canMake);
            } else {
                minAvailable = 0;
            }
        });

        if (minAvailable === Infinity || isNaN(minAvailable)) minAvailable = 0;
        computedEl.innerHTML = 'Khả dụng dự kiến: <span class="badge bg-primary fs-6 font-monospace">' + minAvailable + ' bộ</span>';
    }

    if (btnAddBundle && bundleContainer && bundleTemplate) {
        btnAddBundle.addEventListener('click', function () {
            const emptyRow = document.getElementById('emptyBundleRow');
            if (emptyRow) emptyRow.remove();

            const html = bundleTemplate.innerHTML.replace(/__INDEX__/g, bundleIndex++);
            bundleContainer.insertAdjacentHTML('beforeend', html);
            recalculateBundleAvailability();
        });

        bundleContainer.addEventListener('click', function (e) {
            const btnRemove = e.target.closest('.btn-remove-bundle-row');
            if (btnRemove) {
                const row = btnRemove.closest('.bundle-row');
                if (row) row.remove();
                recalculateBundleAvailability();
            }
        });

        bundleContainer.addEventListener('change', function (e) {
            if (e.target.classList.contains('bundle-component-select')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const stock = selectedOption.getAttribute('data-stock');
                const img = selectedOption.getAttribute('data-img');
                const row = e.target.closest('.bundle-row');
                const badge = row.querySelector('.component-stock-badge');
                const thumb = row.querySelector('.component-thumb-box');

                if (badge) badge.textContent = stock !== null ? stock : '—';
                if (thumb) {
                    thumb.innerHTML = img ? '<img src="' + img + '" style="width: 100%; height: 100%; object-fit: cover;">' : '<i class="bi bi-image text-muted small"></i>';
                }

                // Check duplicate
                const selects = bundleContainer.querySelectorAll('.bundle-component-select');
                const chosen = [];
                selects.forEach(sel => {
                    if (sel.value) {
                        if (chosen.includes(sel.value)) {
                            alert('Cảnh báo: Sản phẩm này đã được chọn trong thành phần!');
                            sel.value = '';
                            if (badge) badge.textContent = '—';
                        } else {
                            chosen.push(sel.value);
                        }
                    }
                });
                recalculateBundleAvailability();
            }
        });

        bundleContainer.addEventListener('input', function (e) {
            if (e.target.classList.contains('bundle-quantity-input')) {
                recalculateBundleAvailability();
            }
        });

        recalculateBundleAvailability();
    }
});
</script>
@endpush
