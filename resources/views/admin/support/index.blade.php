@extends('admin.layouts.app')

@section('title', 'Hộp thư hỗ trợ khách hàng')
@section('page_title', 'Hỗ trợ khách hàng')

@section('breadcrumb')
    <li class="active">Hỗ trợ khách hàng</li>
@endsection

@section('content')
<div class="mb-4">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Trung tâm xử lý yêu cầu hỗ trợ</h2>
            <p class="text-muted small mb-0">Quản lý và phản hồi các yêu cầu liên hệ, khiếu nại và tư vấn từ khách hàng.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.support.chat') }}" class="admin-btn admin-btn--secondary position-relative">
                <i class="bi bi-chat-dots"></i>
                <span>Live Support (Chat)</span>
                @if($unreadChatCount > 0)
                    <span class="badge bg-danger rounded-pill ms-1">{{ $unreadChatCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.faqs.index') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-question-circle"></i>
                <span>Quản lý FAQ</span>
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.support.index', ['status' => 'new']) }}" class="text-decoration-none">
                <div class="admin-metric-card" style="{{ request('status') === 'new' ? 'border-color: #f59e0b;' : '' }}">
                    <div class="admin-metric-label">Mới tiếp nhận</div>
                    <div class="admin-metric-value text-warning">{{ number_format($stats['new']) }}</div>
                    <div class="admin-metric-desc">Cần phân công / tiếp nhận</div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.support.index', ['status' => 'in_progress']) }}" class="text-decoration-none">
                <div class="admin-metric-card" style="{{ request('status') === 'in_progress' ? 'border-color: #3b82f6;' : '' }}">
                    <div class="admin-metric-label">Đang xử lý</div>
                    <div class="admin-metric-value text-primary">{{ number_format($stats['in_progress']) }}</div>
                    <div class="admin-metric-desc">Đang trao đổi với khách</div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.support.index', ['status' => 'resolved']) }}" class="text-decoration-none">
                <div class="admin-metric-card" style="{{ request('status') === 'resolved' ? 'border-color: #10b981;' : '' }}">
                    <div class="admin-metric-label">Đã giải quyết</div>
                    <div class="admin-metric-value text-success">{{ number_format($stats['resolved']) }}</div>
                    <div class="admin-metric-desc">Đã xử lý thỏa đáng</div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.support.index') }}" class="text-decoration-none">
                <div class="admin-metric-card">
                    <div class="admin-metric-label">Tổng yêu cầu</div>
                    <div class="admin-metric-value">{{ number_format($stats['total']) }}</div>
                    <div class="admin-metric-desc">Tất cả thời gian</div>
                </div>
            </a>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="admin-card mb-4">
        <div class="p-3">
            <form action="{{ route('admin.support.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Tìm theo tên, email, chủ đề, mã..." aria-label="Tìm kiếm">
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">-- Tất cả trạng thái --</option>
                        @foreach(\App\Models\ContactMessage::STATUSES as $st)
                            <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>
                                {{ \App\Models\ContactMessage::STATUS_LABELS[$st] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="assigned_to" class="form-select form-select-sm">
                        <option value="">-- Người phụ trách --</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ request('assigned_to') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="has_order" class="form-select form-select-sm">
                        <option value="">-- Có đơn hàng? --</option>
                        <option value="1" {{ request('has_order') === '1' ? 'selected' : '' }}>Có đơn hàng</option>
                        <option value="0" {{ request('has_order') === '0' ? 'selected' : '' }}>Không có đơn</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="admin-btn admin-btn--primary btn-sm flex-grow-1">
                        <i class="bi bi-filter"></i> Lọc
                    </button>
                    @if(request()->hasAny(['q', 'status', 'assigned_to', 'has_order', 'date_from', 'date_to']))
                        <a href="{{ route('admin.support.index') }}" class="admin-btn admin-btn--secondary btn-sm" title="Xóa bộ lọc">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Support Inbox Table --}}
    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 140px;">Mã yêu cầu</th>
                        <th>Khách hàng</th>
                        <th>Chủ đề</th>
                        <th>Đơn liên quan</th>
                        <th>Trạng thái</th>
                        <th>Phụ trách</th>
                        <th>Ngày gửi</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                        <tr>
                            <td>
                                <a href="{{ route('admin.support.show', $msg->id) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $msg->reference }}
                                </a>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $msg->name }}</div>
                                <div class="small text-muted">{{ $msg->email }}</div>
                                @if($msg->phone)
                                    <div class="small text-muted">{{ $msg->phone }}</div>
                                @endif
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 250px;" title="{{ $msg->subject }}">
                                    {{ $msg->subject }}
                                </div>
                                <div class="small text-muted text-truncate" style="max-width: 250px;">
                                    {{ Str::limit($msg->message, 60) }}
                                </div>
                            </td>
                            <td>
                                @if($msg->order)
                                    <a href="{{ route('admin.orders.show', $msg->order->order_code) }}" class="badge bg-light text-dark border text-decoration-none" target="_blank">
                                        #{{ $msg->order->order_code }}
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($msg->status) {
                                        'new' => 'bg-warning text-dark',
                                        'in_progress' => 'bg-primary text-white',
                                        'resolved' => 'bg-success text-white',
                                        'closed' => 'bg-secondary text-white',
                                        default => 'bg-light text-dark',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ \App\Models\ContactMessage::STATUS_LABELS[$msg->status] ?? $msg->status }}
                                </span>
                            </td>
                            <td>
                                @if($msg->assignedUser)
                                    <span class="small fw-medium">{{ $msg->assignedUser->name }}</span>
                                @else
                                    <span class="text-muted small italic">Chưa giao</span>
                                @endif
                            </td>
                            <td>
                                <span class="small text-muted">{{ $msg->created_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.support.show', $msg->id) }}" class="admin-btn admin-btn--secondary btn-sm py-1 px-2" title="Xem chi tiết và xử lý">
                                    <i class="bi bi-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Không tìm thấy yêu cầu hỗ trợ nào phù hợp với điều kiện tìm kiếm.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-3 border-top">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
