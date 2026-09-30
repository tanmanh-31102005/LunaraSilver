@extends('admin.layouts.app')

@section('title', 'Quản lý danh mục bài viết (Blog)')
@section('page_title', 'Danh mục bài viết')

@section('breadcrumb')
    <li class="active">Danh mục bài viết</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Danh mục bài viết (Blog Categories)</h2>
            <p class="text-muted small mb-0">Quản lý phân loại các bài viết trong hệ thống tạp chí & cẩm nang trang sức Lunara.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.post-categories.create') }}" class="admin-btn admin-btn--primary">
                <i class="bi bi-plus-lg"></i> Thêm danh mục mới
            </a>
            <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-journal-text"></i> Quản lý bài viết
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Tên danh mục</th>
                        <th>Đường dẫn (Slug)</th>
                        <th>Mô tả</th>
                        <th style="width: 120px;" class="text-center">Số bài viết</th>
                        <th style="width: 100px;" class="text-center">Thứ tự</th>
                        <th style="width: 130px;" class="text-center">Trạng thái</th>
                        <th style="width: 130px;" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="text-muted font-monospace">{{ $category->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $category->name }}</div>
                            </td>
                            <td>
                                <code class="small text-muted">{{ $category->slug }}</code>
                            </td>
                            <td>
                                <span class="small text-muted text-truncate d-inline-block" style="max-width: 250px;">
                                    {{ $category->description ?: '—' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">{{ $category->posts_count }} bài</span>
                            </td>
                            <td class="text-center font-monospace">{{ $category->sort_order }}</td>
                            <td class="text-center">
                                @if($category->is_active)
                                    <span class="badge bg-success bg-opacity-75">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Tạm ẩn</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex align-items-center justify-content-end gap-1">
                                    <a href="{{ route('admin.post-categories.edit', $category) }}" class="admin-btn admin-btn--secondary btn-sm" title="Chỉnh sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.post-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Các bài viết thuộc danh mục sẽ không bị xóa mà chuyển sang không phân loại.');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn--danger btn-sm" title="Xóa">
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
                                Chưa có danh mục bài viết nào. Hãy thêm danh mục đầu tiên!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="p-3 border-top d-flex justify-content-center">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
