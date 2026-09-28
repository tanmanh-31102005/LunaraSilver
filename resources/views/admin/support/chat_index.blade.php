@extends('admin.layouts.app')

@section('title', 'Live Support — Quản lý trò chuyện')
@section('page_title', 'Live Support (Trò chuyện trực tuyến)')

@section('breadcrumb')
    <li><a href="{{ route('admin.support.index') }}">Hỗ trợ</a></li>
    <li class="active">Live Support</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Các phiên hỗ trợ trực tuyến</h2>
            <p class="text-muted small mb-0">Hội thoại Live Chat giữa chuyên viên tư vấn và khách hàng.</p>
        </div>
        <div>
            <a href="{{ route('admin.support.index') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-inbox"></i> Hộp thư yêu cầu
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã phiên</th>
                        <th>Khách hàng</th>
                        <th>Loại tài khoản</th>
                        <th>Trạng thái</th>
                        <th>Tin chưa đọc</th>
                        <th>Phụ trách</th>
                        <th>Tin cuối</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($conversations as $conv)
                        <tr>
                            <td>
                                <a href="{{ route('admin.support.chat.show', $conv->id) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $conv->reference }}
                                </a>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $conv->customer_name ?? $conv->user?->name ?? 'Khách vãng lai' }}</div>
                                <div class="small text-muted">{{ $conv->customer_email ?? $conv->user?->email ?? '—' }}</div>
                            </td>
                            <td>
                                @if($conv->user)
                                    <span class="badge bg-light text-dark border">Thành viên #{{ $conv->user_id }}</span>
                                @else
                                    <span class="badge bg-light text-muted border">Khách vãng lai</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = match($conv->status) {
                                        'open' => 'bg-warning text-dark',
                                        'assigned' => 'bg-primary text-white',
                                        'resolved' => 'bg-success text-white',
                                        'closed' => 'bg-secondary text-white',
                                        default => 'bg-light text-dark',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    {{ \App\Models\SupportConversation::STATUS_LABELS[$conv->status] ?? $conv->status }}
                                </span>
                            </td>
                            <td>
                                @if($conv->unread_count > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $conv->unread_count }}</span>
                                @else
                                    <span class="text-muted small">0</span>
                                @endif
                            </td>
                            <td>
                                @if($conv->assignedUser)
                                    <span class="small fw-medium">{{ $conv->assignedUser->name }}</span>
                                @else
                                    <span class="text-muted small italic">Chưa nhận</span>
                                @endif
                            </td>
                            <td>
                                <span class="small text-muted">{{ $conv->last_message_at ? $conv->last_message_at->diffForHumans() : '—' }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.support.chat.show', $conv->id) }}" class="admin-btn admin-btn--primary btn-sm py-1 px-3">
                                    <i class="bi bi-chat-text"></i> Mở chat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-chat-square-dots fs-2 d-block mb-2"></i>
                                Chưa có phiên trò chuyện trực tuyến nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($conversations->hasPages())
            <div class="p-3 border-top">
                {{ $conversations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
