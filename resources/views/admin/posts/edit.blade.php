@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa bài viết: ' . $post->title)
@section('page_title', 'Chỉnh sửa bài viết')

@section('breadcrumb')
    <li><a href="{{ route('admin.posts.index') }}">Bài viết</a></li>
    <li class="active">{{ Str::limit($post->title, 25) }}</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Chỉnh sửa bài viết</h2>
            <p class="text-muted small mb-0">Cập nhật nội dung, danh mục và tối ưu hóa bài viết.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('blog.show', $post->slug) }}" class="admin-btn admin-btn--secondary" target="_blank">
                <i class="bi bi-eye"></i> Xem bài viết
            </a>
            <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Main Content Column --}}
            <div class="col-12 col-lg-8">
                <div class="admin-card p-4 mb-4">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold text-dark">Tiêu đề bài viết <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required autofocus>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold text-dark">Đường dẫn bài viết (Slug)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted small">/blog/</span>
                            <input type="text" name="slug" id="slug" class="form-control font-monospace @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug) }}">
                        </div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label fw-bold text-dark">Đoạn trích tóm tắt (Excerpt)</label>
                        <textarea name="excerpt" id="excerpt" rows="3" class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold text-dark">Nội dung bài viết <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="18" class="form-control font-monospace @error('content') is-invalid @enderror" required>{{ old('content', $post->content) }}</textarea>
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
                        <input type="text" name="seo_title" id="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title', $post->seo_title) }}" placeholder="Nếu để trống sẽ dùng: {{ $post->title }} | Lunara Silver">
                        <div class="form-text small">Khuyến nghị dưới 60 ký tự.</div>
                        @error('seo_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="seo_description" class="form-label fw-medium text-dark">Mô tả SEO (Meta Description)</label>
                        <textarea name="seo_description" id="seo_description" rows="2" class="form-control @error('seo_description') is-invalid @enderror" placeholder="Tóm tắt nội dung bài viết dưới 160 ký tự...">{{ old('seo_description', $post->seo_description) }}</textarea>
                        <div class="form-text small">Khuyến nghị dưới 160 ký tự.</div>
                        @error('seo_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-admin.seo-preview 
                        titleInputId="seo_title" 
                        fallbackTitleInputId="title" 
                        descInputId="seo_description" 
                        fallbackDescInputId="excerpt" 
                        slugInputId="slug" 
                        defaultSlug="{{ $post->slug }}" 
                        urlPrefix="https://lunarasilver.infinityfreeapp.com/blog/" 
                        titleSuffix=" | Lunara Silver" 
                        previewId="postSerpPreview" 
                    />
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
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Bản nháp (Draft)</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Đã xuất bản (Published)</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium text-dark ms-2" for="is_featured">
                                <i class="bi bi-star-fill text-warning me-1"></i> Đánh dấu bài viết nổi bật
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reading_time_minutes" class="form-label fw-medium text-dark">Thời gian đọc (phút)</label>
                        <input type="number" name="reading_time_minutes" id="reading_time_minutes" class="form-control @error('reading_time_minutes') is-invalid @enderror" value="{{ old('reading_time_minutes', $post->reading_time_minutes) }}" min="1">
                        @error('reading_time_minutes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pt-3 border-top d-grid gap-2">
                        <button type="submit" class="admin-btn admin-btn--primary">
                            <i class="bi bi-check-lg"></i> Cập nhật bài viết
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
                                <option value="{{ $category->id }}" {{ old('post_category_id', $post->post_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('post_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Cover Image Upload --}}
                <div class="admin-card p-4">
                    <h3 class="h6 fw-bold text-dark mb-3">Ảnh bìa (Cover Image)</h3>
                    @if($post->cover_image)
                        <div class="mb-3 rounded overflow-hidden ratio ratio-16x9 border">
                            <img id="imagePreview" src="{{ $post->cover_image }}" alt="Ảnh bìa hiện tại" class="w-100 h-100 object-fit-cover">
                        </div>
                    @endif
                    <div class="mb-0">
                        <label for="image" class="form-label small text-muted">Thay đổi ảnh bìa:</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                        <div class="form-text small">Để trống nếu không muốn đổi ảnh bìa.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                if (preview) {
                    preview.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
