@extends('admin.layouts.app')

@section('title', 'Thêm danh mục mới')
@section('page_title', 'Thêm danh mục mới')

@section('breadcrumb')
    <li>/</li>
    <li><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
    <li>/</li>
    <li class="text-dark">Thêm mới</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="h6 mb-0 fw-bold">Thông tin danh mục</h2>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Ví dụ: Dây chuyền bạc, Nhẫn kim cương..." required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-semibold">Đường dẫn (Slug)</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Để trống hệ thống sẽ tự động tạo từ tên">
                        <div class="form-text small">Nếu để trống, hệ thống sẽ tự động tạo đường dẫn chuẩn URL (vd: `day-chuyen-bac`).</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="parent_id" class="form-label fw-semibold">Danh mục cha</label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                            <option value="">-- Danh mục gốc (Cấp cao nhất) --</option>
                            @foreach ($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Mô tả ngắn</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Mô tả về phong cách, chất liệu hoặc điểm nổi bật của dòng sản phẩm...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label for="sort_order" class="form-label fw-semibold">Thứ tự hiển thị</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            <div class="form-text small">Số nhỏ hơn sẽ hiển thị trước.</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 d-flex align-items-center pt-sm-4">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Kích hoạt hiển thị</label>
                            </div>
                        </div>
                    {{-- SEO Section --}}
                    <div class="border-top pt-3 mt-4">
                        <h3 class="h6 fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-search text-primary"></i>
                            <span>Tối ưu hóa tìm kiếm (SEO)</span>
                        </h3>

                        <div class="mb-3">
                            <label for="seo_title" class="form-label fw-semibold small">Tiêu đề SEO (Meta Title)</label>
                            <input type="text" class="form-control form-control-sm @error('seo_title') is-invalid @enderror" id="seo_title" name="seo_title" value="{{ old('seo_title') }}" placeholder="Nếu để trống sẽ dùng: {Tên danh mục} | Lunara Silver">
                            <div class="form-text small">Khuyến nghị dưới 60 ký tự để hiển thị tốt nhất trên kết quả tìm kiếm Google.</div>
                            @error('seo_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="seo_description" class="form-label fw-semibold small">Mô tả SEO (Meta Description)</label>
                            <textarea class="form-control form-control-sm @error('seo_description') is-invalid @enderror" id="seo_description" name="seo_description" rows="2" placeholder="Tóm tắt nội dung danh mục xuất hiện trên Google...">{{ old('seo_description') }}</textarea>
                            <div class="form-text small">Khuyến nghị dưới 160 ký tự.</div>
                            @error('seo_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="seo_intro" class="form-label fw-semibold small">Đoạn giới thiệu biên tập (Editorial Intro)</label>
                            <textarea class="form-control form-control-sm @error('seo_intro') is-invalid @enderror" id="seo_intro" name="seo_intro" rows="3" placeholder="Đoạn văn giới thiệu hữu ích 1-2 câu hiển thị ở đầu trang danh mục Storefront...">{{ old('seo_intro') }}</textarea>
                            <div class="form-text small">Nội dung giá trị giúp khách hàng hiểu rõ về bộ sưu tập và nâng cao chất lượng content on-page.</div>
                            @error('seo_intro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <x-admin.seo-preview 
                            titleInputId="seo_title" 
                            fallbackTitleInputId="name" 
                            descInputId="seo_description" 
                            fallbackDescInputId="description" 
                            slugInputId="slug" 
                            urlPrefix="https://lunarasilver.infinityfreeapp.com/products/" 
                            titleSuffix=" | Lunara Silver" 
                            previewId="categoryCreateSerpPreview" 
                        />
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-4">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Lưu danh mục
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
