@php
    $isEdit = isset($product) && $product->exists;
    $cloudinaryConfigured = !empty(config('cloudinary.cloud_name')) && !empty(config('cloudinary.api_key'));
@endphp

@if (!$isEdit)
    <div class="admin-card mb-4">
        <div class="admin-card-header bg-white py-2 px-3">
            <h2 class="h6 mb-0 fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-images text-primary"></i>
                <span>5. Hình ảnh sản phẩm (Cloudinary & Local Media)</span>
            </h2>
        </div>
        <div class="admin-card-body p-4 text-center">
            <div class="p-3 bg-light rounded border border-dashed">
                <i class="bi bi-cloud-arrow-up text-primary fs-3 d-block mb-2"></i>
                <h6 class="fw-bold mb-1">Tải lên Cloudinary khả dụng sau khi lưu sản phẩm</h6>
                <p class="text-muted small mb-0">
                    Vui lòng điền các thông tin cần thiết và bấm <strong>"Lưu sản phẩm"</strong> trước. Sau đó bạn có thể tải lên nhiều ảnh trực tiếp lên Cloudinary, cấu hình vai trò <strong>Primary / Hover / Gallery</strong> và sắp xếp thứ tự hiển thị.
                </p>
            </div>
        </div>
    </div>
@else
    <div class="admin-card mb-4" id="productImageManagerCard">
        <div class="admin-card-header bg-white py-2 px-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h6 mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-images text-primary"></i>
                    <span>5. Hình ảnh sản phẩm</span>
                    <span class="badge bg-secondary rounded-pill" id="imageCountBadge">{{ $product->images->count() }} ảnh</span>
                </h2>
                <div class="text-muted small">Quản lý kho ảnh Cloudinary chính thức và ảnh nội bộ fallback.</div>
            </div>
            <div>
                @if ($cloudinaryConfigured)
                    <span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1">
                        <i class="bi bi-cloud-check-fill"></i> Cloudinary Kết nối
                    </span>
                @else
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle d-inline-flex align-items-center gap-1" title="Vui lòng cấu hình CLOUDINARY_* trong file .env">
                        <i class="bi bi-cloud-slash"></i> Cloudinary Chưa cấu hình .env
                    </span>
                @endif
            </div>
        </div>

        <div class="admin-card-body p-3">
            {{-- Alert messages box --}}
            <div id="imageManagerAlert" class="alert d-none py-2 px-3 small mb-3"></div>

            {{-- Upload Section --}}
            <div class="border rounded p-3 mb-4 bg-light">
                <h3 class="h6 fw-bold mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-cloud-upload text-primary"></i>
                    <span>Tải lên ảnh mới qua Cloudinary</span>
                </h3>
                <p class="text-muted small mb-3">
                    Thư mục lưu trữ: <code class="font-monospace text-primary">lunara/products/{{ $product->sku }}/</code>. Định dạng cho phép: <strong>JPG, JPEG, PNG, WEBP</strong>. Tối đa <strong>5MB/ảnh</strong>.
                </p>

                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="cloudinaryFileInput" class="form-label fw-semibold small mb-1">
                            Chọn tệp ảnh <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control form-control-sm" id="cloudinaryFileInput" accept="image/jpeg,image/png,image/webp" multiple>
                        <div class="form-text small" id="selectedFilesInfo">Có thể chọn nhiều ảnh cùng lúc.</div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <label for="uploadInitialRole" class="form-label fw-semibold small mb-1">Vai trò ảnh đầu</label>
                        <select class="form-select form-select-sm" id="uploadInitialRole">
                            <option value="gallery" selected>Gallery (Thư viện)</option>
                            <option value="primary">Primary (Ảnh chính)</option>
                            <option value="hover">Hover (Ảnh lướt)</option>
                        </select>
                        <div class="form-text small">Các ảnh tiếp theo sẽ là Gallery.</div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label for="uploadAltText" class="form-label fw-semibold small mb-1">Mô tả SEO (Alt Text)</label>
                        <input type="text" class="form-control form-control-sm" id="uploadAltText" placeholder="{{ $product->name }}" value="{{ $product->name }}">
                        <div class="form-text small">Mặc định dùng tên sản phẩm.</div>
                    </div>

                    <div class="col-12 text-end pt-2">
                        <button type="button" class="btn btn-sm btn-primary px-3 d-inline-flex align-items-center gap-2" id="btnUploadCloudinary">
                            <i class="bi bi-cloud-arrow-up-fill" id="btnUploadIcon"></i>
                            <span id="btnUploadText">Tải lên Cloudinary</span>
                            <span class="spinner-border spinner-border-sm d-none" id="btnUploadSpinner" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Existing Images Table --}}
            <div class="table-responsive">
                <table class="table admin-table align-middle mb-0" id="adminProductImagesTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">Ảnh</th>
                            <th style="width: 130px;">Nguồn</th>
                            <th style="width: 140px;">Vai trò</th>
                            <th style="min-width: 200px;">Mô tả SEO (Alt text)</th>
                            <th style="width: 110px;" class="text-center">Thứ tự</th>
                            <th style="width: 180px;" class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="productImagesList">
                        @forelse ($product->images->sortBy('sort_order') as $img)
                            <tr class="product-image-row" data-id="{{ $img->id }}" data-update-url="{{ route('admin.products.images.update', [$product, $img]) }}" data-delete-url="{{ route('admin.products.images.destroy', [$product, $img]) }}">
                                {{-- Thumbnail --}}
                                <td>
                                    <div class="position-relative d-inline-block">
                                        <a href="{{ $img->displayUrl() }}" target="_blank" title="Xem ảnh gốc">
                                            <img src="{{ $img->displayUrl() }}" alt="{{ $img->alt_text ?: $product->name }}" class="rounded border" style="width: 56px; height: 56px; object-fit: cover;">
                                        </a>
                                    </div>
                                </td>

                                {{-- Source --}}
                                <td>
                                    @if ($img->isCloudinary())
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle d-inline-flex align-items-center gap-1 font-monospace" style="font-size: 0.72rem;">
                                            <i class="bi bi-cloud-check"></i> Cloudinary
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle d-inline-flex align-items-center gap-1 font-monospace" style="font-size: 0.72rem;">
                                            <i class="bi bi-folder2"></i> Local
                                        </span>
                                    @endif
                                </td>

                                {{-- Role --}}
                                <td>
                                    <div class="image-role-badge-container">
                                        @if ($img->image_role === 'primary')
                                            <span class="badge bg-primary">Primary (Chính)</span>
                                        @elseif ($img->image_role === 'hover')
                                            <span class="badge bg-info text-dark">Hover (Lướt)</span>
                                        @else
                                            <span class="badge bg-light text-secondary border">Gallery</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Alt Text --}}
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control form-control-sm img-alt-input" value="{{ $img->alt_text }}" placeholder="{{ $product->name }}">
                                        <button class="btn btn-outline-secondary btn-save-alt" type="button" title="Lưu Alt Text">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </div>
                                </td>

                                {{-- Sort Order --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-secondary btn-sort-up" title="Di chuyển lên">
                                            <i class="bi bi-arrow-up"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sort-down" title="Di chuyển xuống">
                                            <i class="bi bi-arrow-down"></i>
                                        </button>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1 flex-wrap">
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Đổi vai trò
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <button class="dropdown-item small btn-set-role {{ $img->image_role === 'primary' ? 'disabled' : '' }}" type="button" data-role="primary">
                                                        <i class="bi bi-star-fill text-warning me-1"></i> Đặt làm Primary
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item small btn-set-role {{ $img->image_role === 'hover' ? 'disabled' : '' }}" type="button" data-role="hover">
                                                        <i class="bi bi-cursor-fill text-info me-1"></i> Đặt làm Hover
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item small btn-set-role {{ $img->image_role === 'gallery' ? 'disabled' : '' }}" type="button" data-role="gallery">
                                                        <i class="bi bi-images text-secondary me-1"></i> Chuyển thành Gallery
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <button type="button" class="btn btn-xs btn-outline-danger btn-delete-image" title="Xóa ảnh an toàn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyProductImageRow">
                                <td colspan="6" class="text-center py-4 text-muted small">
                                    <i class="bi bi-images text-secondary fs-4 d-block mb-1"></i>
                                    <span>Chưa có hình ảnh nào cho sản phẩm này. Hãy chọn tệp ảnh ở khung trên và tải lên!</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isEdit = {{ $isEdit ? 'true' : 'false' }};
    if (!isEdit) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const uploadUrl = @json($isEdit ? route('admin.products.images.store', $product) : '');
    const reorderUrl = @json($isEdit ? route('admin.products.images.reorder', $product) : '');

    const fileInput = document.getElementById('cloudinaryFileInput');
    const roleSelect = document.getElementById('uploadInitialRole');
    const altInput = document.getElementById('uploadAltText');
    const btnUpload = document.getElementById('btnUploadCloudinary');
    const btnUploadIcon = document.getElementById('btnUploadIcon');
    const btnUploadText = document.getElementById('btnUploadText');
    const btnUploadSpinner = document.getElementById('btnUploadSpinner');
    const alertBox = document.getElementById('imageManagerAlert');
    const imagesList = document.getElementById('productImagesList');

    function showAlert(message, type = 'success') {
        if (!alertBox) return;
        alertBox.className = `alert alert-${type} py-2 px-3 small mb-3`;
        alertBox.innerHTML = message;
        alertBox.classList.remove('d-none');
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideAlert() {
        if (alertBox) alertBox.classList.add('d-none');
    }

    // --- UPLOAD TO CLOUDINARY ---
    if (btnUpload && fileInput) {
        fileInput.addEventListener('change', function () {
            const count = this.files.length;
            const infoEl = document.getElementById('selectedFilesInfo');
            if (infoEl) {
                infoEl.textContent = count > 0 ? `Đã chọn ${count} tệp ảnh.` : 'Có thể chọn nhiều ảnh cùng lúc.';
            }
        });

        btnUpload.addEventListener('click', async function (e) {
            e.preventDefault();
            hideAlert();

            if (!fileInput.files || fileInput.files.length === 0) {
                showAlert('Vui lòng chọn ít nhất một hình ảnh để tải lên.', 'warning');
                return;
            }

            // Client-side file size check (5MB)
            for (let i = 0; i < fileInput.files.length; i++) {
                if (fileInput.files[i].size > 5 * 1024 * 1024) {
                    showAlert(`Tệp "${fileInput.files[i].name}" vượt quá 5MB. Vui lòng chọn ảnh dung lượng nhỏ hơn.`, 'danger');
                    return;
                }
            }

            const formData = new FormData();
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append('images[]', fileInput.files[i]);
            }
            formData.append('image_role', roleSelect.value);
            formData.append('alt_text', altInput.value.trim());

            // Loading state
            btnUpload.disabled = true;
            btnUploadIcon.classList.add('d-none');
            btnUploadSpinner.classList.remove('d-none');
            btnUploadText.textContent = 'Đang tải lên Cloudinary...';

            try {
                const response = await fetch(uploadUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showAlert(data.message, 'success');
                    // Reload to update complete table state and clean up form
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    showAlert(data.message || 'Lỗi khi tải ảnh lên.', 'danger');
                }
            } catch (err) {
                showAlert('Có lỗi kết nối đến máy chủ khi tải ảnh.', 'danger');
            } finally {
                btnUpload.disabled = false;
                btnUploadIcon.classList.remove('d-none');
                btnUploadSpinner.classList.add('d-none');
                btnUploadText.textContent = 'Tải lên Cloudinary';
            }
        });
    }

    // --- ROW ACTIONS: ROLE / ALT / SORT / DELETE ---
    if (imagesList) {
        imagesList.addEventListener('click', async function (e) {
            const row = e.target.closest('.product-image-row');
            if (!row) return;

            const updateUrl = row.getAttribute('data-update-url');
            const deleteUrl = row.getAttribute('data-delete-url');

            // 1. SET ROLE
            const roleBtn = e.target.closest('.btn-set-role');
            if (roleBtn) {
                const newRole = roleBtn.getAttribute('data-role');
                try {
                    const res = await fetch(updateUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ image_role: newRole }),
                    });
                    const data = await res.json();
                    if (res.ok && data.success) {
                        showAlert('Đã cập nhật vai trò ảnh thành công.', 'success');
                        setTimeout(() => window.location.reload(), 400);
                    } else {
                        showAlert(data.message || 'Không thể đổi vai trò ảnh.', 'danger');
                    }
                } catch (err) {
                    showAlert('Lỗi kết nối khi cập nhật vai trò.', 'danger');
                }
                return;
            }

            // 2. SAVE ALT TEXT
            const saveAltBtn = e.target.closest('.btn-save-alt');
            if (saveAltBtn) {
                const altVal = row.querySelector('.img-alt-input')?.value || '';
                try {
                    const res = await fetch(updateUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ alt_text: altVal }),
                    });
                    const data = await res.json();
                    if (res.ok && data.success) {
                        saveAltBtn.classList.remove('btn-outline-secondary');
                        saveAltBtn.classList.add('btn-success');
                        setTimeout(() => {
                            saveAltBtn.classList.remove('btn-success');
                            saveAltBtn.classList.add('btn-outline-secondary');
                        }, 1200);
                    } else {
                        showAlert(data.message || 'Không thể lưu alt text.', 'danger');
                    }
                } catch (err) {
                    showAlert('Lỗi kết nối khi lưu alt text.', 'danger');
                }
                return;
            }

            // 3. DELETE IMAGE
            const deleteBtn = e.target.closest('.btn-delete-image');
            if (deleteBtn) {
                if (!confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
                    return;
                }

                try {
                    const res = await fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                    });
                    const data = await res.json();
                    if (res.ok && data.success) {
                        row.remove();
                        showAlert('Đã xóa hình ảnh thành công.', 'success');
                        const remaining = imagesList.querySelectorAll('.product-image-row').length;
                        const badge = document.getElementById('imageCountBadge');
                        if (badge) badge.textContent = `${remaining} ảnh`;
                        if (remaining === 0) {
                            setTimeout(() => window.location.reload(), 400);
                        }
                    } else {
                        showAlert(data.message || 'Không thể xóa ảnh.', 'danger');
                    }
                } catch (err) {
                    showAlert('Lỗi kết nối khi xóa ảnh.', 'danger');
                }
                return;
            }

            // 4. SORT UP / DOWN
            const btnUp = e.target.closest('.btn-sort-up');
            const btnDown = e.target.closest('.btn-sort-down');
            if (btnUp || btnDown) {
                if (btnUp) {
                    const prev = row.previousElementSibling;
                    if (prev && prev.classList.contains('product-image-row')) {
                        imagesList.insertBefore(row, prev);
                    }
                } else if (btnDown) {
                    const next = row.nextElementSibling;
                    if (next && next.classList.contains('product-image-row')) {
                        imagesList.insertBefore(next, row);
                    }
                }

                // Send reorder request
                const rows = imagesList.querySelectorAll('.product-image-row');
                const order = Array.from(rows).map(r => parseInt(r.getAttribute('data-id'), 10));

                try {
                    const res = await fetch(reorderUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ order: order }),
                    });
                    const data = await res.json();
                    if (!res.ok || !data.success) {
                        showAlert(data.message || 'Không thể lưu thứ tự ảnh.', 'warning');
                    }
                } catch (err) {
                    showAlert('Lỗi kết nối khi sắp xếp ảnh.', 'danger');
                }
            }
        });
    }
});
</script>
@endpush
