<div class="admin-card mb-4">
    <div class="admin-card-header bg-white d-flex justify-content-between align-items-center py-2 px-3">
        <div>
            <h3 class="h6 mb-0 fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-images text-primary"></i>
                <span>Quản lý ảnh sản phẩm (Foundation Metadata)</span>
            </h3>
            <div class="text-muted small">Cấu hình vai trò hiển thị và thứ tự sắp xếp ảnh.</div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" id="btnAddImageRow">
            <i class="bi bi-plus-lg"></i>
            <span>Thêm ảnh</span>
        </button>
    </div>

    <div class="admin-card-body p-0">
        <div class="alert alert-info border-0 rounded-0 mb-0 py-2 px-3 small d-flex align-items-center gap-2">
            <i class="bi bi-info-circle-fill text-info"></i>
            <span><strong>Chế độ Metadata Foundation:</strong> Dùng nút <strong>&uarr; &darr;</strong> để điều chỉnh vị trí ảnh. Thao tác không xóa tệp tin gốc trong thư mục <code>media/</code>.</span>
        </div>

        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle" id="imagesTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">Ảnh</th>
                        <th style="min-width: 260px;">Đường dẫn ảnh (URL / File path) <span class="text-danger">*</span></th>
                        <th style="width: 140px;">Vai trò</th>
                        <th style="width: 80px;" class="text-center">Thứ tự</th>
                        <th style="min-width: 180px;">Mô tả SEO (Alt Text)</th>
                        <th style="width: 110px;" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="imagesContainer">
                    @php
                        $existingImages = old('images', isset($product) ? $product->images->map(fn($img) => [
                            'id' => $img->id,
                            'image_url' => $img->image_url,
                            'image_role' => $img->image_role,
                            'sort_order' => $img->sort_order,
                            'alt_text' => $img->alt_text,
                        ])->toArray() : []);
                    @endphp

                    @forelse ($existingImages as $idx => $img)
                        <tr class="image-row">
                            <td class="text-center">
                                @if (!empty($img['id']))
                                    <input type="hidden" name="images[{{ $idx }}][id]" value="{{ $img['id'] }}">
                                @endif
                                <div class="image-preview-box rounded border bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width: 44px; height: 44px;">
                                    @if (!empty($img['image_url']))
                                        <img src="{{ str_starts_with($img['image_url'], 'http') ? $img['image_url'] : route('media.show', ['path' => $img['image_url']]) }}" alt="Preview" style="object-fit: cover; width: 100%; height: 100%;" onerror="this.src='{{ route('media.show', ['path' => 'placeholder.png']) }}';">
                                    @else
                                        <i class="bi bi-image text-muted small"></i>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <input type="text" name="images[{{ $idx }}][image_url]" class="form-control form-control-sm image-url-input font-monospace" value="{{ $img['image_url'] ?? '' }}" placeholder="vd: products/nhan-bac-1.jpg" required>
                            </td>
                            <td>
                                <select name="images[{{ $idx }}][image_role]" class="form-select form-select-sm" required>
                                    <option value="primary" {{ ($img['image_role'] ?? '') === 'primary' ? 'selected' : '' }}>Primary (Chính)</option>
                                    <option value="hover" {{ ($img['image_role'] ?? '') === 'hover' ? 'selected' : '' }}>Hover (Lướt qua)</option>
                                    <option value="gallery" {{ ($img['image_role'] ?? '') === 'gallery' || empty($img['image_role']) ? 'selected' : '' }}>Gallery (Thư viện)</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="number" name="images[{{ $idx }}][sort_order]" class="form-control form-control-sm text-center font-monospace image-sort-order" value="{{ $img['sort_order'] ?? $idx }}" min="0">
                            </td>
                            <td>
                                <input type="text" name="images[{{ $idx }}][alt_text]" class="form-control form-control-sm" value="{{ $img['alt_text'] ?? '' }}" placeholder="Mô tả alt text...">
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary p-1 btn-move-img-up" title="Di chuyển lên">
                                        <i class="bi bi-arrow-up"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary p-1 btn-move-img-down" title="Di chuyển xuống">
                                        <i class="bi bi-arrow-down"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger p-1 btn-remove-image-row" title="Xóa ảnh">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyImagesRow">
                            <td colspan="6" class="text-center py-4 text-muted small">
                                <i class="bi bi-images me-1"></i> Chưa có ảnh nào được liên kết. Nhấn <strong>"Thêm ảnh"</strong> để bổ sung.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<template id="imageRowTemplate">
    <tr class="image-row">
        <td class="text-center">
            <div class="image-preview-box rounded border bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width: 44px; height: 44px;">
                <i class="bi bi-image text-muted small"></i>
            </div>
        </td>
        <td>
            <input type="text" name="images[__INDEX__][image_url]" class="form-control form-control-sm image-url-input font-monospace" placeholder="vd: products/day-chuyen-1.jpg" required>
        </td>
        <td>
            <select name="images[__INDEX__][image_role]" class="form-select form-select-sm" required>
                <option value="primary">Primary (Chính)</option>
                <option value="hover">Hover (Lướt qua)</option>
                <option value="gallery" selected>Gallery (Thư viện)</option>
            </select>
        </td>
        <td class="text-center">
            <input type="number" name="images[__INDEX__][sort_order]" class="form-control form-control-sm text-center font-monospace image-sort-order" value="__INDEX__" min="0">
        </td>
        <td>
            <input type="text" name="images[__INDEX__][alt_text]" class="form-control form-control-sm" placeholder="Mô tả alt text...">
        </td>
        <td class="text-end">
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary p-1 btn-move-img-up" title="Di chuyển lên">
                    <i class="bi bi-arrow-up"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary p-1 btn-move-img-down" title="Di chuyển xuống">
                    <i class="bi bi-arrow-down"></i>
                </button>
                <button type="button" class="btn btn-outline-danger p-1 btn-remove-image-row" title="Xóa ảnh">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </td>
    </tr>
</template>
