@extends('admin.layouts.app')

@section('title', 'Tạo bài viết mới | Lunara Blog CMS')
@section('page_title', 'Viết bài mới')

@section('breadcrumb')
    <li><a href="{{ route('admin.posts.index') }}">Bài viết</a></li>
    <li class="active">Thêm mới</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Viết bài mới</h2>
            <p class="text-muted small mb-0">Biên soạn bài viết mới cho Lunara Journal và hệ thống kiến thức trang sức.</p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn--secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            {{-- Main Content Column --}}
            <div class="col-12 col-lg-8">
                <div class="admin-card p-4 mb-4">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold text-dark">Tiêu đề bài viết <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="VD: Bí Quyết Bảo Quản Trang Sức Bạc 925 Sáng Bóng Tại Nhà..." required autofocus>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold text-dark">Đường dẫn bài viết (Slug)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted small">/blog/</span>
                            <input type="text" name="slug" id="slug" class="form-control font-monospace @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="tu-dong-tao-tu-tieu-de">
                        </div>
                        <div class="form-text small">Để trống để hệ thống tự động sinh ra từ tiêu đề bài viết.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label fw-bold text-dark">Đoạn trích tóm tắt (Excerpt)</label>
                        <textarea name="excerpt" id="excerpt" rows="3" class="form-control @error('excerpt') is-invalid @enderror" placeholder="Đoạn văn ngắn giới thiệu nội dung hiển thị ở danh sách bài viết...">{{ old('excerpt') }}</textarea>
                        <div class="form-text small">Nên từ 120-180 ký tự để hiển thị đẹp nhất.</div>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold text-dark">Nội dung bài viết <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="18" class="form-control font-monospace @error('content') is-invalid @enderror" placeholder="Nhập nội dung bài viết dạng văn bản hoặc HTML..." required>{{ old('content') }}</textarea>
                        <div class="form-text small">Hỗ trợ các thẻ HTML an toàn: &lt;p&gt;, &lt;h2&gt;, &lt;h3&gt;, &lt;blockquote&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;img&gt;...</div>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- SEO Metadata Box --}}
                <div class="admin-card p-4">
                    <h3 class="h6 fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-search text-primary"></i> Tối ưu hóa tìm kiếm (SEO)
                    </h3>
                    <div class="mb-3">
                        <label for="seo_title" class="form-label fw-medium text-dark">Tiêu đề SEO (Meta Title)</label>
                        <input type="text" name="seo_title" id="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title') }}" placeholder="Nếu để trống sẽ sử dụng tiêu đề bài viết">
                        @error('seo_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label for="seo_description" class="form-label fw-medium text-dark">Mô tả SEO (Meta Description)</label>
                        <textarea name="seo_description" id="seo_description" rows="2" class="form-control @error('seo_description') is-invalid @enderror" placeholder="Mô tả xuất hiện trên kết quả tìm kiếm Google...">{{ old('seo_description') }}</textarea>
                        @error('seo_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Sidebar Column --}}
            <div class="col-12 col-lg-4">
                {{-- Publish Settings --}}
                <div class="admin-card p-4 mb-4">
                    <h3 class="h6 fw-bold text-dark mb-3">Xuất bản</h3>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-medium text-dark">Trạng thái bài viết</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Bản nháp (Draft)</option>
                            <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Xuất bản ngay (Published)</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium text-dark ms-2" for="is_featured">
                                <i class="bi bi-star-fill text-warning me-1"></i> Đánh dấu bài viết nổi bật
                            </label>
                        </div>
                        <div class="form-text small">Bài viết nổi bật sẽ hiển thị dạng Hero Card tại đầu trang Blog.</div>
                    </div>

                    <div class="mb-3">
                        <label for="reading_time_minutes" class="form-label fw-medium text-dark">Thời gian đọc (phút)</label>
                        <input type="number" name="reading_time_minutes" id="reading_time_minutes" class="form-control @error('reading_time_minutes') is-invalid @enderror" value="{{ old('reading_time_minutes') }}" min="1" placeholder="Tự động tính theo số từ nếu để trống">
                        @error('reading_time_minutes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pt-3 border-top d-grid gap-2">
                        <button type="submit" class="admin-btn admin-btn--primary">
                            <i class="bi bi-check-lg"></i> Lưu & Xuất bản bài viết
                        </button>
                    </div>
                </div>

                {{-- Category Selection --}}
                <div class="admin-card p-4 mb-4">
                    <h3 class="h6 fw-bold text-dark mb-3">Danh mục</h3>
                    <div class="mb-2">
                        <select name="post_category_id" id="post_category_id" class="form-select @error('post_category_id') is-invalid @enderror">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('post_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('post_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.post-categories.create') }}" class="small text-primary text-decoration-none" target="_blank">
                            <i class="bi bi-plus"></i> Thêm danh mục mới
                        </a>
                    </div>
                </div>

                {{-- Cover Image Upload --}}
                <div class="admin-card p-4">
                    <h3 class="h6 fw-bold text-dark mb-3">Ảnh bìa (Cover Image)</h3>
                    <div class="mb-3">
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                        <div class="form-text small">Tải lên ảnh bìa đẹp (tỷ lệ 16:9, tối đa 5MB). Lưu trữ tự động trên Cloudinary.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="imagePreviewContainer" class="d-none mt-3 rounded overflow-hidden ratio ratio-16x9 border">
                        <img id="imagePreview" src="" alt="Xem trước ảnh bìa" class="w-100 h-100 object-fit-cover">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('imagePreview');
                var container = document.getElementById('imagePreviewContainer');
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
