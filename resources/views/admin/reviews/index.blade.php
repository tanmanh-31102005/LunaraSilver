@extends('admin.layouts.app')

@section('title', 'Quản lý đánh giá sản phẩm | Lunara Admin')
@section('page_title', 'Quản lý đánh giá sản phẩm')

@section('breadcrumb')
    <li class="active">Đánh giá sản phẩm</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Kiểm duyệt & Quản lý đánh giá khách hàng</h2>
            <p class="text-muted small mb-0">Xác thực giao dịch mua hàng, kiểm duyệt nội dung và gửi phản hồi đại diện từ thương hiệu Lunara Silver.</p>
        </div>
    </div>

    {{-- Stats Cards (Phase 20.83 - 20.84) --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary fs-4">
                    <i class="bi bi-chat-square-quote"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Tổng đánh giá</div>
                    <div class="fs-4 fw-bold text-dark">{{ number_format($stats['total']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="admin-card p-3 d-flex align-items-center gap-3 {{ $stats['pending'] > 0 ? 'border-warning' : '' }}">
                <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning-emphasis fs-4">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Chờ kiểm duyệt</div>
                    <div class="fs-4 fw-bold {{ $stats['pending'] > 0 ? 'text-warning-emphasis' : 'text-dark' }}">
                        {{ number_format($stats['pending']) }}
                        @if($stats['pending'] > 0)
                            <span class="badge bg-warning text-dark fs-7 ms-1">Cần xử lý</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success fs-4">
                    <i class="bi bi-patch-check"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Đã phê duyệt</div>
                    <div class="fs-4 fw-bold text-success">{{ number_format($stats['approved']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-secondary bg-opacity-10 text-dark fs-4">
                    <i class="bi bi-star-fill text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Điểm trung bình</div>
                    <div class="fs-4 fw-bold text-dark">{{ $stats['avg_rating'] }} <small class="text-muted fs-6">/ 5</small></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Toolbar (Phase 20.28) --}}
    <div class="admin-card p-3 mb-4">
        <form action="{{ route('admin.reviews.index') }}" method="get" class="row g-2 align-items-center">
            <div class="col-12 col-md-3">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Tìm khách hàng, email, SKU, nội dung..." value="{{ $q }}">
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Từ chối</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="rating" class="form-select form-select-sm">
                    <option value="">Tất cả số sao</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ (int) $rating === $i ? 'selected' : '' }}>{{ $i }} sao</option>
                    @endfor
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="verified" class="form-select form-select-sm">
                    <option value="">Mua hàng xác thực</option>
                    <option value="1" {{ $verified === '1' ? 'selected' : '' }}>Đã mua hàng</option>
                    <option value="0" {{ $verified === '0' ? 'selected' : '' }}>Chưa xác thực</option>
                </select>
            </div>
            <div class="col-6 col-md-3 d-flex gap-2">
                <button type="submit" class="admin-btn admin-btn--primary btn-sm flex-grow-1">
                    <i class="bi bi-search"></i> Lọc
                </button>
                @if($q || $status || $rating || $verified)
                    <a href="{{ route('admin.reviews.index') }}" class="admin-btn admin-btn--secondary btn-sm" title="Xóa bộ lọc">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Reviews Table (Phase 20.27) --}}
    <div class="admin-card overflow-hidden">
        <div class="table-responsive">
            <table class="admin-table w-100 mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#ID</th>
                        <th style="min-width: 170px;">Khách hàng</th>
                        <th style="min-width: 220px;">Sản phẩm</th>
                        <th style="min-width: 200px;">Đánh giá</th>
                        <th style="min-width: 140px;">Đơn hàng</th>
                        <th style="min-width: 120px;">Trạng thái</th>
                        <th style="width: 110px;">Ngày tạo</th>
                        <th style="min-width: 160px;" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $rev)
                        @php
                            $prod = $rev->product;
                            $primaryImg = $prod?->images->firstWhere('image_role', 'primary') ?: $prod?->images->first();
                        @endphp
                        <tr>
                            <td class="font-monospace text-muted small">#{{ $rev->id }}</td>
                            <td>
                                <div class="fw-semibold text-dark small">{{ $rev->user?->name ?? 'Vô danh' }}</div>
                                <div class="text-muted small" style="font-size: 0.75rem;">{{ $rev->user?->email }}</div>
                                <div class="badge bg-light text-secondary border mt-1" style="font-size: 0.7rem;">
                                    Tên hiển thị: {{ $rev->masked_user_name }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded border overflow-hidden flex-shrink-0" style="width: 42px; height: 42px;">
                                        @if($primaryImg)
                                            <img src="{{ $primaryImg->displayUrl() }}" alt="" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted small"><i class="bi bi-gem"></i></div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark small text-truncate" style="max-width: 180px;">
                                            @if($prod && $prod->is_active)
                                                <a href="{{ route('products.show', $prod->slug) }}" target="_blank" class="text-dark text-decoration-none hover-underline">{{ $prod->name }}</a>
                                            @else
                                                {{ $prod?->name ?? 'Sản phẩm ngừng bán' }}
                                            @endif
                                        </div>
                                        <div class="font-monospace text-muted small" style="font-size: 0.75rem;">{{ $prod?->sku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="review-stars text-warning small mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $rev->rating >= $i ? '-fill' : '' }}"></i>
                                    @endfor
                                    <span class="text-dark fw-bold ms-1" style="font-size: 0.75rem;">{{ $rev->rating }}/5</span>
                                </div>
                                @if($rev->title)
                                    <div class="fw-semibold text-dark small mb-1">{{ Str::limit($rev->title, 40) }}</div>
                                @endif
                                <div class="text-secondary small" style="font-size: 0.78rem; line-height: 1.4;">
                                    {{ Str::limit($rev->effective_content, 80) }}
                                </div>
                                @if($rev->media->isNotEmpty())
                                    <div class="d-flex gap-1 mt-1">
                                        @foreach($rev->media as $m)
                                            <a href="{{ $m->image_url }}" target="_blank" class="rounded overflow-hidden border" style="width: 24px; height: 24px;">
                                                <img src="{{ $m->image_url }}" alt="" class="w-100 h-100 object-fit-cover">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                @if($rev->admin_reply)
                                    <div class="text-success small mt-1" style="font-size: 0.72rem;">
                                        <i class="bi bi-reply-fill"></i> Đã phản hồi
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($rev->orderItem && $rev->orderItem->order)
                                    <a href="{{ route('admin.orders.show', $rev->orderItem->order->order_code) }}" class="text-dark fw-medium small font-monospace text-decoration-none hover-underline">
                                        #{{ $rev->orderItem->order->order_code }}
                                    </a>
                                    <div>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.68rem;">
                                            <i class="bi bi-patch-check-fill me-1"></i> Đã mua hàng
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted small">Không có đơn</span>
                                @endif
                            </td>
                            <td>
                                @if($rev->status === 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1">
                                        <i class="bi bi-check-circle-fill me-1"></i> Đã duyệt
                                    </span>
                                @elseif($rev->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-1">
                                        <i class="bi bi-clock-fill me-1"></i> Chờ duyệt
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1" title="{{ $rev->rejection_reason }}">
                                        <i class="bi bi-x-circle-fill me-1"></i> Từ chối
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $rev->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-1">
                                    {{-- Approve Button (20.30) --}}
                                    @if($rev->status !== 'approved')
                                        <form action="{{ route('admin.reviews.approve', $rev) }}" method="post" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success p-1 px-2" title="Duyệt đánh giá">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Reject Modal Trigger (20.31) --}}
                                    @if($rev->status !== 'rejected')
                                        <button type="button" class="btn btn-sm btn-outline-warning p-1 px-2 text-dark" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $rev->id }}" title="Từ chối đánh giá">
                                            <i class="bi bi-slash-circle"></i>
                                        </button>
                                    @endif

                                    {{-- Reply Modal Trigger (20.32) --}}
                                    <button type="button" class="btn btn-sm btn-outline-primary p-1 px-2" data-bs-toggle="modal" data-bs-target="#replyModal-{{ $rev->id }}" title="Phản hồi từ Lunara">
                                        <i class="bi bi-reply"></i>
                                    </button>

                                    {{-- View Details --}}
                                    <a href="{{ route('admin.reviews.show', $rev) }}" class="btn btn-sm btn-outline-secondary p-1 px-2" title="Xem chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Delete Review --}}
                                    <form action="{{ route('admin.reviews.destroy', $rev) }}" method="post" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này và các ảnh liên quan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Xóa vĩnh viễn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                {{-- Reject Modal --}}
                                <div class="modal fade" id="rejectModal-{{ $rev->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content text-start">
                                            <form action="{{ route('admin.reviews.reject', $rev) }}" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title h6 fw-bold">Từ chối đánh giá #{{ $rev->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="small text-muted mb-2">Đánh giá của <strong>{{ $rev->user?->name }}</strong> cho sản phẩm <strong>{{ $rev->product?->name }}</strong> sẽ bị chuyển sang trạng thái từ chối.</p>
                                                    <label class="form-label small fw-semibold text-dark mb-1">Lý do từ chối (Nội bộ):</label>
                                                    <textarea name="rejection_reason" class="form-control form-control-sm" rows="3" placeholder="Ví dụ: Nội dung chứa từ ngữ không phù hợp, spam quảng cáo..." required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-danger btn-sm">Xác nhận từ chối</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Reply Modal --}}
                                <div class="modal fade" id="replyModal-{{ $rev->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content text-start">
                                            <form action="{{ route('admin.reviews.reply', $rev) }}" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title h6 fw-bold">Phản hồi đại diện cho đánh giá #{{ $rev->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="p-2 bg-light rounded border mb-3 small">
                                                        <div class="fw-semibold text-dark">{{ $rev->user?->name }}:</div>
                                                        <div class="text-secondary fst-italic">“{{ $rev->effective_content }}”</div>
                                                    </div>
                                                    <label class="form-label small fw-semibold text-dark mb-1">Nội dung phản hồi từ Lunara Silver:</label>
                                                    <textarea name="admin_reply" class="form-control form-control-sm" rows="4" placeholder="Cảm ơn bạn đã tin chọn Lunara Silver..." required>{{ old('admin_reply', $rev->admin_reply) }}</textarea>
                                                    <small class="text-muted d-block mt-1">Phản hồi này sẽ được hiển thị công khai ngay dưới đánh giá của khách hàng.</small>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-primary btn-sm">Lưu phản hồi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-chat-square-text fs-2 d-block mb-2 text-muted"></i>
                                Không tìm thấy đánh giá nào phù hợp với bộ lọc.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
