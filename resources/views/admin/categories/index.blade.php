@extends('admin.layouts.app')

@section('title', 'Quản lý Danh mục')
@section('page_title', 'Danh mục sản phẩm')

@section('breadcrumb')
    <li>/</li>
    <li class="text-dark">Danh mục</li>
@endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header py-2 px-3">
        <div>
            <h2 class="h6 mb-0 fw-bold">Danh sách phân loại catalog</h2>
            <div class="text-muted small">Cây danh mục và số lượng sản phẩm liên kết</div>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-plus-lg"></i>
            <span>Thêm danh mục</span>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table admin-table align-middle table-hover">
            <thead>
                <tr>
                    <th style="width: 60px;" class="text-center">Thứ tự</th>
                    <th>Tên danh mục</th>
                    <th>Đường dẫn (Slug)</th>
                    <th>Danh mục cha</th>
                    <th class="text-center">Số sản phẩm</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Cập nhật</th>
                    <th class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="text-center font-monospace small">{{ $category->sort_order }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $category->name }}</div>
                            @if ($category->description)
                                <div class="small text-muted text-truncate" style="max-width: 250px;">{{ $category->description }}</div>
                            @endif
                        </td>
                        <td>
                            <code class="text-muted small">{{ $category->slug }}</code>
                        </td>
                        <td>
                            @if ($category->parent)
                                <span class="badge bg-light text-dark border">{{ $category->parent->name }}</span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($category->products_count > 0)
                                <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}" class="badge bg-primary-subtle text-primary border border-primary-subtle text-decoration-none px-2 py-1" title="Xem sản phẩm thuộc danh mục">
                                    {{ $category->products_count }} sản phẩm
                                </a>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1">0</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($category->is_active)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="small text-muted" style="font-size: 0.75rem;">
                            {{ $category->updated_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-secondary" title="Sửa danh mục">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" title="Xóa danh mục" onclick="confirmDeleteCategory({{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->products_count }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-tags fs-3 d-block mb-2"></i>
                            Chưa có danh mục nào được tạo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($categories->hasPages() || $categories->total() > 0)
        <div class="admin-card-footer px-3 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2 text-muted small">
                <i class="bi bi-tags text-secondary"></i>
                <span>Hiển thị <strong class="text-dark fw-semibold">{{ $categories->firstItem() ?? 0 }} – {{ $categories->lastItem() ?? 0 }}</strong> trên tổng số <strong class="text-dark fw-semibold">{{ $categories->total() }}</strong> danh mục</span>
            </div>
            <div>
                {{ $categories->links() }}
            </div>
        </div>
    @endif
</div>

{{-- Hidden Form for Delete Action --}}
<form id="deleteCategoryForm" method="POST" action="" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function confirmDeleteCategory(id, name, productsCount) {
    if (productsCount > 0) {
        window.adminConfirm({
            title: 'Không thể xóa danh mục',
            message: 'Danh mục "' + name + '" hiện đang có ' + productsCount + ' sản phẩm liên kết. Bạn cần chuyển hoặc xóa các sản phẩm này sang danh mục khác trước.',
            confirmText: 'Đã hiểu',
            confirmClass: 'btn-secondary',
            onConfirm: function () {}
        });
        return;
    }

    window.adminConfirm({
        title: 'Xóa danh mục',
        message: 'Bạn có chắc chắn muốn xóa danh mục "' + name + '" không?',
        confirmText: 'Xóa danh mục',
        confirmClass: 'btn-danger',
        onConfirm: function () {
            const form = document.getElementById('deleteCategoryForm');
            form.action = '/admin/categories/' + id;
            form.submit();
        }
    });
}
</script>
@endpush
