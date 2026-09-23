<div class="admin-card mb-4" id="bundleEditorCard" style="{{ in_array(old('product_type', $product->product_type ?? 'single'), ['collection', 'gift'], true) ? '' : 'display: none;' }}">
    <div class="admin-card-header bg-white d-flex justify-content-between align-items-center py-2 px-3">
        <div>
            <h3 class="h6 mb-0 fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-boxes text-primary"></i>
                <span>Thành phần bộ sản phẩm / Quà tặng (Bundle Composition)</span>
            </h3>
            <div class="text-muted small">Tồn kho của bộ được tính tự động từ tồn kho thành phần.</div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" id="btnAddBundleItem">
            <i class="bi bi-plus-lg"></i>
            <span>Thêm thành phần</span>
        </button>
    </div>

    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle" id="bundleItemsTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">Ảnh</th>
                        <th style="min-width: 280px;">Sản phẩm thành phần (Single active)</th>
                        <th style="width: 130px;" class="text-center">Tồn đơn lẻ</th>
                        <th style="width: 140px;" class="text-center">Số lượng / Bộ</th>
                        <th style="width: 60px;" class="text-end">Xóa</th>
                    </tr>
                </thead>
                <tbody id="bundleItemsContainer">
                    @php
                        $existingItems = old('bundle_items', isset($product) ? $product->bundleItems->map(fn($item) => [
                            'product_id' => $item->component_product_id,
                            'quantity' => $item->quantity,
                        ])->toArray() : []);
                    @endphp

                    @forelse ($existingItems as $idx => $item)
                        @php
                            $selectedSp = $singleProducts->firstWhere('id', (int)($item['product_id'] ?? 0));
                            $imgUrl = $selectedSp?->primaryImage?->displayUrl();
                        @endphp
                        <tr class="bundle-row">
                            <td class="text-center">
                                <div class="component-thumb-box rounded border bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width: 38px; height: 38px;">
                                    @if ($imgUrl)
                                        <img src="{{ $imgUrl }}" alt="Thumb" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="bi bi-image text-muted small"></i>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <select name="bundle_items[{{ $idx }}][product_id]" class="form-select form-select-sm bundle-component-select" required>
                                    <option value="">-- Chọn sản phẩm thành phần --</option>
                                    @foreach ($singleProducts as $sp)
                                        @php
                                            $spImg = $sp->primaryImage?->displayUrl() ?? '';
                                        @endphp
                                        <option value="{{ $sp->id }}" 
                                            data-stock="{{ $sp->stock_quantity }}" 
                                            data-sku="{{ $sp->sku }}"
                                            data-img="{{ $spImg }}"
                                            {{ (int)($item['product_id'] ?? 0) === $sp->id ? 'selected' : '' }}>
                                            {{ $sp->name }} ({{ $sp->sku }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border font-monospace component-stock-badge">
                                    {{ $selectedSp ? $selectedSp->stock_quantity : '—' }}
                                </span>
                            </td>
                            <td>
                                <input type="number" name="bundle_items[{{ $idx }}][quantity]" class="form-control form-control-sm text-center font-monospace bundle-quantity-input" value="{{ $item['quantity'] ?? 1 }}" min="1" required>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger p-1 btn-remove-bundle-row" title="Xóa thành phần này">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyBundleRow">
                            <td colspan="5" class="text-center py-4 text-muted small">
                                <i class="bi bi-boxes me-1"></i> Chưa có thành phần nào. Nhấn <strong>"Thêm thành phần"</strong> để chọn sản phẩm đơn lẻ.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 bg-light-subtle border-top d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted small">
            <div>
                <i class="bi bi-info-circle text-primary me-1"></i>
                Không chọn trùng thành phần. Tồn kho thành phần phải &ge; 1 để bộ khả dụng.
            </div>
            <div id="bundleComputedLive" class="fw-bold text-primary">
                {{-- Live dynamic availability text --}}
            </div>
        </div>
    </div>
</div>

<template id="bundleRowTemplate">
    <tr class="bundle-row">
        <td class="text-center">
            <div class="component-thumb-box rounded border bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width: 38px; height: 38px;">
                <i class="bi bi-image text-muted small"></i>
            </div>
        </td>
        <td>
            <select name="bundle_items[__INDEX__][product_id]" class="form-select form-select-sm bundle-component-select" required>
                <option value="">-- Chọn sản phẩm thành phần --</option>
                @foreach ($singleProducts as $sp)
                    @php
                        $spImg = $sp->primaryImage?->displayUrl() ?? '';
                    @endphp
                    <option value="{{ $sp->id }}" 
                        data-stock="{{ $sp->stock_quantity }}" 
                        data-sku="{{ $sp->sku }}"
                        data-img="{{ $spImg }}">
                        {{ $sp->name }} ({{ $sp->sku }})
                    </option>
                @endforeach
            </select>
        </td>
        <td class="text-center">
            <span class="badge bg-light text-dark border font-monospace component-stock-badge">—</span>
        </td>
        <td>
            <input type="number" name="bundle_items[__INDEX__][quantity]" class="form-control form-control-sm text-center font-monospace bundle-quantity-input" value="1" min="1" required>
        </td>
        <td class="text-end">
            <button type="button" class="btn btn-sm btn-outline-danger p-1 btn-remove-bundle-row" title="Xóa thành phần này">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
</template>
