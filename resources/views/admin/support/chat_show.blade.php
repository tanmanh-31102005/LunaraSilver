@extends('admin.layouts.app')

@section('title', 'Phiên trò chuyện #' . $conversation->reference)
@section('page_title', 'Live Chat #' . $conversation->reference)

@section('breadcrumb')
    <li><a href="{{ route('admin.support.index') }}">Hỗ trợ</a></li>
    <li><a href="{{ route('admin.support.chat') }}">Live Support</a></li>
    <li class="active">{{ $conversation->reference }}</li>
@endsection

@section('content')
<div class="mb-4">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="h5 mb-0 fw-bold text-dark">
                    Trò chuyện với: {{ $conversation->customer_name ?? $conversation->user?->name ?? 'Khách vãng lai' }}
                </h2>
                @php
                    $statusClass = match($conversation->status) {
                        'open' => 'bg-warning text-dark',
                        'assigned' => 'bg-primary text-white',
                        'resolved' => 'bg-success text-white',
                        'closed' => 'bg-secondary text-white',
                        default => 'bg-light text-dark',
                    };
                @endphp
                <span class="badge {{ $statusClass }}">
                    {{ \App\Models\SupportConversation::STATUS_LABELS[$conversation->status] ?? $conversation->status }}
                </span>
            </div>
            <p class="text-muted small mb-0">Mã phiên: <strong class="text-dark">{{ $conversation->reference }}</strong> &bull; Email: {{ $conversation->customer_email ?? $conversation->user?->email ?? 'Không có email' }}</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if($conversation->status !== \App\Models\SupportConversation::STATUS_CLOSED)
                <form action="{{ route('admin.support.chat.close', $conversation->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn đóng phiên trò chuyện này?')">
                    @csrf
                    <button type="submit" class="admin-btn admin-btn--secondary text-danger">
                        <i class="bi bi-x-circle"></i> Đóng phiên
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.support.chat') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-arrow-left"></i> Danh sách chat
            </a>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="admin-card overflow-hidden">
                {{-- Messages Thread Container --}}
                <div class="p-4 overflow-y-auto d-flex flex-column gap-3" style="max-height: 520px; min-height: 380px; background-color: #faf9f6;">
                    @forelse($messages as $msg)
                        @php $isAdmin = $msg->sender_type === 'admin'; @endphp
                        <div class="d-flex {{ $isAdmin ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="p-3 rounded-2 shadow-sm {{ $isAdmin ? 'text-white' : 'text-dark border bg-white' }}"
                                 style="max-width: 80%; line-height: 1.5; font-size: 0.925rem; {{ $isAdmin ? 'background-color: #1a1a1a;' : 'border-color: #ebe7e0 !important;' }}">
                                <div class="d-flex align-items-center justify-content-between gap-3 mb-1 small {{ $isAdmin ? 'text-white-50' : 'text-muted' }}" style="font-size: 0.75rem;">
                                    <strong>{{ $msg->sender_name ?? ($isAdmin ? 'Chuyên viên' : 'Khách hàng') }}</strong>
                                    <span>{{ $msg->created_at->format('H:i, d/m/Y') }}</span>
                                </div>
                                <div style="white-space: pre-wrap;">{{ $msg->message }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-chat-dots fs-3 d-block mb-2"></i>
                            Chưa có tin nhắn nào trong cuộc trò chuyện này.
                        </div>
                    @endforelse
                </div>

                {{-- Reply Box --}}
                <div class="p-3 p-md-4 border-top bg-white">
                    <form action="{{ route('admin.support.chat.reply', $conversation->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="adminReplyMsg" class="form-label small fw-medium text-dark">Nhập tin nhắn phản hồi:</label>
                            <textarea id="adminReplyMsg" name="message" class="form-control" rows="3" placeholder="Nhập câu trả lời cho khách hàng..." required></textarea>
                            @error('message')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        @php
                            $targetEmail = $conversation->customer_email ?? $conversation->user?->email;
                        @endphp

                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                            <div>
                                @if($targetEmail)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="send_email" value="1" id="sendEmailCopy">
                                        <label class="form-check-label small text-muted" for="sendEmailCopy">
                                            Gửi bản sao qua email tới <strong>{{ $targetEmail }}</strong>
                                        </label>
                                    </div>
                                @else
                                    <small class="text-muted italic">Khách vãng lai không có email, chỉ nhận trực tiếp qua cửa sổ chat.</small>
                                @endif
                            </div>

                            <button type="submit" class="admin-btn admin-btn--primary">
                                <i class="bi bi-send me-1"></i> Gửi tin nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
