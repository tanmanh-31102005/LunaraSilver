@extends('admin.layouts.app')

@section('title', 'Quản lý câu hỏi thường gặp (FAQ)')
@section('page_title', 'Quản lý FAQ')

@section('breadcrumb')
    <li class="active">Quản lý FAQ</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Danh sách câu hỏi thường gặp (FAQ)</h2>
            <p class="text-muted small mb-0">Thiết lập và quản lý các câu hỏi trợ giúp hiển thị tại Storefront Trung tâm hỗ trợ.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.faqs.create') }}" class="admin-btn admin-btn--primary">
                <i class="bi bi-plus-lg"></i> Thêm câu hỏi mới
            </a>
            <a href="{{ route('support.faq') }}" class="admin-btn admin-btn--secondary" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> Xem trên Web
            </a>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="admin-card mb-4">
        <div class="p-3">
            <form action="{{ route('admin.faqs.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Tìm theo từ khóa câu hỏi hoặc nội dung trả lời..." aria-label="Tìm kiếm">
                </div>

                <div class="col-md-4">
                    <select name="category" class="form-select form-select-sm">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="admin-btn admin-btn--primary btn-sm flex-grow-1">
                        <i class="bi bi-filter"></i> Lọc
                    </button>
                    @if(request()->hasAny(['q', 'category']))
                        <a href="{{ route('admin.faqs.index') }}" class="admin-btn admin-btn--secondary btn-sm" title="Xóa bộ lọc">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- FAQ Table --}}
    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Thứ tự</th>
                        <th style="width: 160px;">Danh mục</th>
                        <th>Câu hỏi</th>
                        <th style="width: 120px;">Trạng thái</th>
                        <th class="text-end" style="width: 140px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                        <tr>
                            <td class="text-center fw-medium text-muted">
                                {{ $faq->sort_order }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $faq->category }}</span>
                            </td>
                            <td>
                                <div class="fw-medium text-dark mb-1">{{ $faq->question }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 450px;">
                                    {{ Str::limit($faq->answer, 100) }}
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.faqs.toggle', $faq->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Nhấp để đổi trạng thái">
                                        @if($faq->is_active)
                                            <span class="badge bg-success-subtle text-success">
                                                <i class="bi bi-check-circle me-1"></i> Hiển thị
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                <i class="bi bi-dash-circle me-1"></i> Đang ẩn
                                            </span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="admin-btn admin-btn--secondary btn-sm py-1 px-2" title="Chỉnh sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn--secondary btn-sm py-1 px-2 text-danger" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-question-circle fs-2 d-block mb-2"></i>
                                Chưa có câu hỏi nào trong danh mục này.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($faqs->hasPages())
            <div class="p-3 border-top">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
