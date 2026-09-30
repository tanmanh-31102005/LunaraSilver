@extends('admin.layouts.app')

@section('title', 'Thêm danh mục bài viết mới')
@section('page_title', 'Thêm danh mục mới')

@section('breadcrumb')
    <li><a href="{{ route('admin.post-categories.index') }}">Danh mục bài viết</a></li>
    <li class="active">Thêm mới</li>
@endsection

@section('content')
<div class="mb-4" style="max-width: 760px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Thêm danh mục bài viết mới</h2>
            <p class="text-muted small mb-0">Tạo phân loại mới cho bài viết tạp chí và cẩm nang trang sức.</p>
        </div>
        <a href="{{ route('admin.post-categories.index') }}" class="admin-btn admin-btn--secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <form action="{{ route('admin.post-categories.store') }}" method="POST">
        @csrf

        <div class="admin-card p-4 mb-4">
            <div class="mb-3">
                <label for="name" class="form-label fw-bold text-dark">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="VD: Cẩm nang trang sức, Bảo quản bạc 925..." required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label fw-bold text-dark">Đường dẫn (Slug)</label>
                <input type="text" name="slug" id="slug" class="form-control font-monospace @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Tự động tạo từ tên nếu để trống">
                <div class="form-text small">Định danh URL thân thiện cho danh mục (VD: cam-nang-trang-suc).</div>
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-bold text-dark">Mô tả ngắn</label>
                <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Mô tả tóm tắt nội dung danh mục...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="sort_order" class="form-label fw-bold text-dark">Thứ tự hiển thị</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}" min="0">
                    <div class="form-text small">Số nhỏ hơn sẽ hiển thị trước.</div>
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6 d-flex align-items-center">
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium text-dark ms-2" for="is_active">Kích hoạt hiển thị</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="admin-btn admin-btn--primary">
                <i class="bi bi-check-lg"></i> Lưu danh mục
            </button>
            <a href="{{ route('admin.post-categories.index') }}" class="admin-btn admin-btn--secondary">
                Hủy bỏ
            </a>
        </div>
    </form>
</div>
@endsection
