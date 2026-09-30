@extends('admin.layouts.app')

@section('title', 'Quản lý bài viết (Blog CMS)')
@section('page_title', 'Danh sách bài viết')

@section('breadcrumb')
    <li class="active">Bài viết</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Quản lý bài viết (Editorial Journal)</h2>
            <p class="text-muted small mb-0">Biên tập nội dung cẩm nang trang sức, mẹo bảo quản và bài viết phong cách Lunara Silver.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.posts.create') }}" class="admin-btn admin-btn--primary">
                <i class="bi bi-pencil-square"></i> Viết bài mới
            </a>
            <a href="{{ route('admin.post-categories.index') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-folder2-open"></i> Danh mục blog
            </a>
            <a href="{{ route('blog.index') }}" class="admin-btn admin-btn--secondary" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> Xem trên Web
            </a>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="admin-card mb-4">
        <div class="p-3">
            <form action="{{ route('admin.posts.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Tìm theo tiêu đề hoặc nội dung bài viết..." aria-label="Tìm kiếm bài viết">
                </div>

                <div class="col-md-3">
                    <select name="category_id" class="form-select form-select-sm">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">-- Trạng thái --</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="admin-btn admin-btn--primary btn-sm flex-grow-1">
                        <i class="bi bi-filter"></i> Lọc
                    </button>
                    @if(request()->hasAny(['search', 'category_id', 'status']))
                        <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn--secondary btn-sm" title="Xóa bộ lọc">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Posts Table --}}
    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Ảnh</th>
                        <th>Tiêu đề & Đường dẫn</th>
                        <th>Danh mục</th>
                        <th>Tác giả</th>
                        <th style="width: 100px;" class="text-center">Nổi bật</th>
                        <th style="width: 120px;" class="text-center">Trạng thái</th>
                        <th>Thời gian</th>
                        <th style="width: 140px;" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="rounded object-fit-cover" width="60" height="42">
                            </td>
                            <td>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 320px;">
                                    {{ $post->title }}
                                </div>
                                <code class="small text-muted text-truncate d-inline-block" style="max-width: 300px;">/blog/{{ $post->slug }}</code>
                            </td>
                            <td>
                                @if($post->category)
                                    <span class="badge bg-light text-dark border">{{ $post->category->name }}</span>
                                @else
                                    <span class="text-muted small">Không phân loại</span>
                                @endif
                            </td>
                            <td>
                                <span class="small text-dark">{{ $post->author->name ?? 'Quản trị viên' }}</span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.posts.toggle-feature', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent text-warning" title="{{ $post->is_featured ? 'Hủy nổi bật' : 'Đánh dấu nổi bật' }}">
                                        <i class="bi {{ $post->is_featured ? 'bi-star-fill' : 'bi-star text-muted' }} fs-5"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                @if($post->isPublished())
                                    <x-ui.status-badge status="published" label="Đã xuất bản" size="sm" />
                                @else
                                    <x-ui.status-badge status="draft" label="Bản nháp" size="sm" />
                                @endif
                            </td>
                            <td>
                                <div class="small text-dark">
                                    {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : ($post->created_at ? $post->created_at->format('d/m/Y H:i') : '—') }}
                                </div>
                                <div class="text-muted" style="font-size: 11px;">
                                    <i class="bi bi-clock me-1"></i>{{ $post->reading_time }} phút đọc
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="d-flex align-items-center justify-content-end gap-1">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="admin-btn admin-btn--secondary btn-sm" target="_blank" title="Xem trước / Xem bài viết">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="admin-btn admin-btn--secondary btn-sm" title="Chỉnh sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn--danger btn-sm" title="Xóa bài viết">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-1 text-secondary"></i>
                                Không có bài viết nào phù hợp với điều kiện tìm kiếm.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-3 border-top d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
