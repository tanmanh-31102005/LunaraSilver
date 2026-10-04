@php
    $isEdit = isset($product) && $product->exists;
    $cloudinaryConfigured = !empty(config('cloudinary.cloud_name')) && !empty(config('cloudinary.api_key'));
@endphp

@if (!$isEdit)
    <div class="admin-card mb-4" id="createProductImageCard">
        <div class="admin-card-header bg-white py-2 px-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h6 mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-images text-primary"></i>
                    <span>4. Hình ảnh sản phẩm (Cloudinary & Local Media)</span>
                    <span class="badge bg-secondary rounded-pill d-none" id="createImageCountBadge">0 ảnh</span>
                </h2>
                <div class="text-muted small">Tải lên ảnh sản phẩm ngay khi tạo mới. Tự động đồng bộ lên Cloudinary khi lưu.</div>
            </div>
            <div>
                @if ($cloudinaryConfigured)
                    <span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1">
                        <i class="bi bi-cloud-check-fill"></i> Cloudinary Sẵn sàng
                    </span>
                @else
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle d-inline-flex align-items-center gap-1" title="Chưa cấu hình Cloudinary trong .env. Ảnh sẽ lưu trữ nội bộ (Local Media).">
                        <i class="bi bi-hdd-fill"></i> Lưu trữ Local Media
                    </span>
                @endif
            </div>
        </div>

        <div class="admin-card-body p-3">
            {{-- Hidden Actual File Input --}}
            <input type="file" 
                   name="product_images[]" 
                   id="createProductFileInput" 
                   class="d-none" 
                   accept="image/jpeg,image/png,image/webp" 
                   multiple>
            <input type="hidden" name="primary_image_index" id="primaryImageIndex" value="0">
            <input type="hidden" name="hover_image_index" id="hoverImageIndex" value="1">

            {{-- Dropzone Area --}}
            <div class="p-4 bg-light rounded border border-2 border-dashed text-center" id="createDropzone" style="cursor: pointer; transition: all 0.2s ease;">
                <i class="bi bi-cloud-arrow-up text-primary fs-2 d-block mb-2"></i>
                <h6 class="fw-bold mb-1">Chọn ảnh sản phẩm hoặc kéo thả vào đây</h6>
                <p class="text-muted small mb-3">
                    Hỗ trợ chọn nhiều ảnh cùng lúc: JPG, PNG, WEBP (Tối đa 5MB/ảnh).<br>
                    <span class="text-secondary">Ảnh đầu tiên mặc định là <strong>Primary (Ảnh chính)</strong>, ảnh thứ hai là <strong>Hover (Ảnh lướt)</strong>. Bạn có thể đổi vai trò trực tiếp sau khi chọn.</span>
                </p>
                <button type="button" class="btn btn-sm btn-primary px-4 fw-semibold" id="btnBrowseCreateImages">
                    <i class="bi bi-folder2-open me-1"></i> Chọn tệp ảnh từ máy tính
                </button>
            </div>

            {{-- Selected Images Previews Container --}}
            <div id="createPreviewsWrapper" class="mt-3 d-none">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold small text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span>Danh sách ảnh đã chọn (<span id="createFileCountText">0</span> ảnh)</span>
                    </span>
                    <button type="button" class="btn btn-xs btn-outline-danger" id="btnClearAllCreateImages">
                        <i class="bi bi-trash me-1"></i> Xóa tất cả
                    </button>
                </div>

                <div class="row g-2" id="createPreviewsGrid"></div>
            </div>
        </div>
    </div>
@else
    <div class="admin-card mb-4" id="productImageManagerCard">
        <div class="admin-card-header bg-white py-2 px-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h6 mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-images text-primary"></i>
                    <span>4. Hình ảnh sản phẩm (Cloudinary & Local Media)</span>
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
    if (!isEdit) {
        initProductCreateImages();
        return;
    }

    function initProductCreateImages() {
        const fileInput = document.getElementById('createProductFileInput');
        const dropzone = document.getElementById('createDropzone');
        const btnBrowse = document.getElementById('btnBrowseCreateImages');
        const previewsWrapper = document.getElementById('createPreviewsWrapper');
        const previewsGrid = document.getElementById('createPreviewsGrid');
        const fileCountText = document.getElementById('createFileCountText');
        const countBadge = document.getElementById('createImageCountBadge');
        const btnClearAll = document.getElementById('btnClearAllCreateImages');
        const primaryIndexInput = document.getElementById('primaryImageIndex');
        const hoverIndexInput = document.getElementById('hoverImageIndex');

        if (!fileInput || !dropzone) return;

        let selectedFiles = [];
        let primaryIndex = 0;
        let hoverIndex = 1;

        function formatBytes(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }

        function syncFileInput() {
            try {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            } catch (err) {
                console.warn('DataTransfer not fully supported:', err);
            }

            if (selectedFiles.length === 0) {
                primaryIndex = 0;
                hoverIndex = 1;
            } else {
                if (primaryIndex >= selectedFiles.length) primaryIndex = 0;
                if (hoverIndex >= selectedFiles.length) hoverIndex = selectedFiles.length > 1 ? 1 : -1;
                if (primaryIndex === hoverIndex && selectedFiles.length > 1) {
                    hoverIndex = primaryIndex === 0 ? 1 : 0;
                }
            }

            if (primaryIndexInput) primaryIndexInput.value = primaryIndex;
            if (hoverIndexInput) hoverIndexInput.value = hoverIndex;
        }

        function renderPreviews() {
            previewsGrid.innerHTML = '';
            const count = selectedFiles.length;

            if (count === 0) {
                previewsWrapper.classList.add('d-none');
                countBadge.classList.add('d-none');
                countBadge.textContent = '0 ảnh';
                return;
            }

            previewsWrapper.classList.remove('d-none');
            countBadge.classList.remove('d-none');
            countBadge.textContent = `${count} ảnh`;
            if (fileCountText) fileCountText.textContent = count;

            selectedFiles.forEach((file, index) => {
                const objectUrl = URL.createObjectURL(file);
                const isPrimary = (index === primaryIndex);
                const isHover = (index === hoverIndex);

                let roleBadge = '<span class="badge bg-light text-secondary border">Gallery</span>';
                if (isPrimary) {
                    roleBadge = '<span class="badge bg-primary"><i class="bi bi-star-fill me-1"></i>Primary (Chính)</span>';
                } else if (isHover) {
                    roleBadge = '<span class="badge bg-info text-dark"><i class="bi bi-cursor-fill me-1"></i>Hover (Lướt)</span>';
                }

                const col = document.createElement('div');
                col.className = 'col-6 col-sm-4 col-md-3 col-lg-2';
                col.innerHTML = `
                    <div class="card h-100 shadow-sm border ${isPrimary ? 'border-primary border-2' : ''} ${isHover ? 'border-info border-2' : ''}">
                        <div class="position-relative bg-light rounded-top text-center overflow-hidden" style="height: 110px;">
                            <img src="${objectUrl}" class="w-100 h-100" style="object-fit: cover;" alt="${file.name}">
                            <div class="position-absolute top-0 start-0 m-1">
                                ${roleBadge}
                            </div>
                            <button type="button" class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1 rounded-circle p-0 d-flex align-items-center justify-content-center btn-remove-preview" data-index="${index}" title="Xóa ảnh này" style="width: 22px; height: 22px;">
                                <i class="bi bi-x-lg" style="font-size: 10px;"></i>
                            </button>
                        </div>
                        <div class="card-body p-2 d-flex flex-column justify-content-between">
                            <div class="mb-2">
                                <div class="text-truncate fw-semibold text-dark small" title="${file.name}" style="font-size: 0.76rem;">${file.name}</div>
                                <div class="text-muted" style="font-size: 0.68rem;">${formatBytes(file.size)}</div>
                            </div>
                            <div class="d-flex align-items-center gap-1 w-100">
                                <div class="btn-group btn-group-sm flex-grow-1" role="group">
                                    <button type="button" class="btn btn-xs ${isPrimary ? 'btn-primary' : 'btn-outline-secondary'} py-1 px-1 btn-set-primary" data-index="${index}" title="Đặt làm ảnh chính" style="font-size: 0.7rem;">
                                        Chính
                                    </button>
                                    <button type="button" class="btn btn-xs ${isHover ? 'btn-info text-dark' : 'btn-outline-secondary'} py-1 px-1 btn-set-hover" data-index="${index}" title="Đặt làm ảnh lướt (hover)" style="font-size: 0.7rem;">
                                        Lướt
                                    </button>
                                </div>
                                <button type="button" class="btn btn-xs btn-outline-danger py-1 px-2 btn-remove-preview" data-index="${index}" title="Xóa ảnh này">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                previewsGrid.appendChild(col);
            });
        }

        function addFiles(newFiles) {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSizeBytes = 5 * 1024 * 1024;
            let rejectedCount = 0;
            let sizeError = false;

            Array.from(newFiles).forEach(file => {
                if (!allowedTypes.includes(file.type)) {
                    rejectedCount++;
                    return;
                }
                if (file.size > maxSizeBytes) {
                    sizeError = true;
                    return;
                }
                const exists = selectedFiles.some(f => f.name === file.name && f.size === file.size);
                if (!exists) {
                    selectedFiles.push(file);
                }
            });

            if (rejectedCount > 0) {
                alert(`Có ${rejectedCount} tệp không đúng định dạng JPG, PNG hoặc WEBP bị bỏ qua.`);
            }
            if (sizeError) {
                alert('Một số tệp có dung lượng vượt quá 5MB đã bị bỏ qua.');
            }

            syncFileInput();
            renderPreviews();
        }

        if (btnBrowse) {
            btnBrowse.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.click();
            });
        }

        dropzone.addEventListener('click', function (e) {
            if (e.target !== btnBrowse && !btnBrowse.contains(e.target)) {
                fileInput.click();
            }
        });

        fileInput.addEventListener('change', function () {
            if (fileInput.files && fileInput.files.length > 0) {
                addFiles(fileInput.files);
            }
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-primary', 'bg-light');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-primary', 'bg-light');
            });
        });

        dropzone.addEventListener('drop', function (e) {
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                addFiles(e.dataTransfer.files);
            }
        });

        if (btnClearAll) {
            btnClearAll.addEventListener('click', function () {
                selectedFiles = [];
                primaryIndex = 0;
                hoverIndex = 1;
                syncFileInput();
                renderPreviews();
            });
        }

        previewsGrid.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.btn-remove-preview');
            if (removeBtn) {
                const idx = parseInt(removeBtn.getAttribute('data-index'), 10);
                selectedFiles.splice(idx, 1);
                if (primaryIndex === idx) {
                    primaryIndex = 0;
                } else if (primaryIndex > idx) {
                    primaryIndex--;
                }
                if (hoverIndex === idx) {
                    hoverIndex = selectedFiles.length > 1 ? (primaryIndex === 0 ? 1 : 0) : -1;
                } else if (hoverIndex > idx) {
                    hoverIndex--;
                }
                syncFileInput();
                renderPreviews();
                return;
            }

            const primaryBtn = e.target.closest('.btn-set-primary');
            if (primaryBtn) {
                const idx = parseInt(primaryBtn.getAttribute('data-index'), 10);
                primaryIndex = idx;
                if (hoverIndex === primaryIndex) {
                    hoverIndex = selectedFiles.length > 1 ? (primaryIndex === 0 ? 1 : 0) : -1;
                }
                syncFileInput();
                renderPreviews();
                return;
            }

            const hoverBtn = e.target.closest('.btn-set-hover');
            if (hoverBtn) {
                const idx = parseInt(hoverBtn.getAttribute('data-index'), 10);
                hoverIndex = idx;
                if (primaryIndex === hoverIndex) {
                    primaryIndex = (hoverIndex === 0 ? 1 : 0);
                }
                syncFileInput();
                renderPreviews();
                return;
            }
        });
    }

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
