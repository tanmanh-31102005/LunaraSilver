@extends('admin.layouts.app')

@section('title', 'Chi tiết yêu cầu hỗ trợ #' . $contact->reference)
@section('page_title', 'Yêu cầu hỗ trợ #' . $contact->reference)

@section('breadcrumb')
    <li><a href="{{ route('admin.support.index') }}">Hỗ trợ</a></li>
    <li class="active">{{ $contact->reference }}</li>
@endsection

@section('content')
<div class="mb-4">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="h5 mb-0 fw-bold text-dark">{{ $contact->subject }}</h2>
                @php
                    $badgeClass = match($contact->status) {
                        'new' => 'bg-warning text-dark',
                        'in_progress' => 'bg-primary text-white',
                        'resolved' => 'bg-success text-white',
                        'closed' => 'bg-secondary text-white',
                        default => 'bg-light text-dark',
                    };
                @endphp
                <span class="badge {{ $badgeClass }}">
                    {{ \App\Models\ContactMessage::STATUS_LABELS[$contact->status] ?? $contact->status }}
                </span>
            </div>
            <p class="text-muted small mb-0">Mã tham chiếu: <strong class="text-dark">{{ $contact->reference }}</strong> &bull; Tiếp nhận lúc {{ $contact->created_at->format('H:i, d/m/Y') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.support.index') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-arrow-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column: Message Details & Reply Box --}}
        <div class="col-lg-8">
            {{-- Original Message Card --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header d-flex align-items-center justify-content-between">
                    <h3 class="admin-card-title">Nội dung yêu cầu từ khách hàng</h3>
                    <span class="small text-muted">{{ $contact->created_at->diffForHumans() }}</span>
                </div>
                <div class="p-4">
                    <div class="p-3 rounded-2 border bg-light-subtle mb-3" style="font-size: 0.95rem; line-height: 1.7; white-space: pre-wrap;">{{ $contact->message }}</div>

                    <div class="row g-3 small text-muted pt-2 border-top">
                        <div class="col-sm-4">
                            <strong>Khách hàng:</strong> {{ $contact->name }}
                        </div>
                        <div class="col-sm-4">
                            <strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </div>
                        <div class="col-sm-4">
                            <strong>Điện thoại:</strong> {{ $contact->phone ?? 'Chưa cung cấp' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Linked Order Card (If exists) --}}
            @if($contact->order)
                <div class="admin-card mb-4">
                    <div class="admin-card-header d-flex align-items-center justify-content-between">
                        <h3 class="admin-card-title">Đơn hàng liên quan: #{{ $contact->order->order_code }}</h3>
                        <a href="{{ route('admin.orders.show', $contact->order->order_code) }}" class="admin-btn admin-btn--secondary btn-sm" target="_blank">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Xem chi tiết đơn
                        </a>
                    </div>
                    <div class="p-4">
                        <div class="row g-3 mb-3">
                            <div class="col-sm-3">
                                <span class="d-block text-muted small">Tổng thanh toán:</span>
                                <strong class="text-dark">{{ number_format($contact->order->grand_total, 0, ',', '.') }}đ</strong>
                            </div>
                            <div class="col-sm-3">
                                <span class="d-block text-muted small">Trạng thái đơn:</span>
                                <span class="badge bg-light text-dark border">{{ \App\Models\Order::STATUS_LABELS[$contact->order->order_status] ?? $contact->order->order_status }}</span>
                            </div>
                            <div class="col-sm-3">
                                <span class="d-block text-muted small">Phương thức:</span>
                                <span>{{ strtoupper($contact->order->payment_method) }}</span>
                            </div>
                            <div class="col-sm-3">
                                <span class="d-block text-muted small">Ngày đặt:</span>
                                <span>{{ $contact->order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        @if($contact->order->items->isNotEmpty())
                            <div class="table-responsive border rounded-1">
                                <table class="table table-sm table-borderless mb-0">
                                    <thead class="bg-light text-muted small">
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-end">Đơn giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contact->order->items as $item)
                                            <tr class="border-top">
                                                <td class="small">{{ $item->product_name ?? $item->product?->name }}</td>
                                                <td class="text-center small">{{ $item->quantity }}</td>
                                                <td class="text-end small">{{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Email Reply Card --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Phản hồi khách hàng qua Email (Gmail SMTP)</h3>
                </div>
                <div class="p-4">
                    <p class="small text-muted mb-3">
                        Nội dung phản hồi dưới đây sẽ được gửi trực tiếp tới hòm thư <strong>{{ $contact->email }}</strong> của khách hàng với giao diện chuẩn Lunara Silver, đồng thời lưu vết vào lịch sử hỗ trợ.
                    </p>

                    <form action="{{ route('admin.support.reply', $contact->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reply_content" class="form-label small fw-medium text-dark">Nội dung phản hồi:</label>
                            <textarea name="reply_content" id="reply_content" class="form-control" rows="6" placeholder="Kính gửi quý khách {{ $contact->name }}, Lunara Silver xin phép phản hồi..." required>{{ old('reply_content') }}</textarea>
                            @error('reply_content')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="admin-btn admin-btn--primary">
                                <i class="bi bi-send me-1"></i> Gửi email phản hồi cho khách
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Column: Status, Assignment & Internal Notes --}}
        <div class="col-lg-4">
            {{-- Status Management Card --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Trạng thái xử lý</h3>
                </div>
                <div class="p-4">
                    <form action="{{ route('admin.support.status', $contact->id) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PATCH')
                        <label for="statusSelect" class="form-label small text-muted">Cập nhật trạng thái:</label>
                        <div class="input-group">
                            <select name="status" id="statusSelect" class="form-select form-select-sm">
                                @foreach(\App\Models\ContactMessage::STATUSES as $st)
                                    <option value="{{ $st }}" {{ $contact->status === $st ? 'selected' : '' }}>
                                        {{ \App\Models\ContactMessage::STATUS_LABELS[$st] }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="admin-btn admin-btn--primary btn-sm">Lưu</button>
                        </div>
                    </form>

                    <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                        @if($contact->status !== 'in_progress')
                            <form action="{{ route('admin.support.status', $contact->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="admin-btn admin-btn--secondary btn-sm py-1">Đang xử lý</button>
                            </form>
                        @endif

                        @if($contact->status !== 'resolved')
                            <form action="{{ route('admin.support.status', $contact->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit" class="admin-btn admin-btn--primary btn-sm py-1" style="background-color: #10b981; border-color: #10b981;">
                                    <i class="bi bi-check-lg"></i> Đã giải quyết
                                </button>
                            </form>
                        @endif

                        @if($contact->status !== 'closed')
                            <form action="{{ route('admin.support.status', $contact->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="closed">
                                <button type="submit" class="admin-btn admin-btn--secondary btn-sm py-1 text-muted">Đóng</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Assignment Card --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Phân công chuyên viên</h3>
                </div>
                <div class="p-4">
                    <form action="{{ route('admin.support.assign', $contact->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="assignedSelect" class="form-label small text-muted">Chuyên viên phụ trách:</label>
                            <select name="assigned_to" id="assignedSelect" class="form-select form-select-sm">
                                <option value="">-- Chưa phân công --</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ $contact->assigned_to == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            @if($contact->assigned_to !== auth()->id())
                                <button type="submit" name="assigned_to" value="{{ auth()->id() }}" class="admin-btn admin-btn--secondary btn-sm">
                                    Nhận xử lý
                                </button>
                            @else
                                <span class="badge bg-success-subtle text-success small">Bạn đang phụ trách</span>
                            @endif
                            <button type="submit" class="admin-btn admin-btn--primary btn-sm">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Internal Notes Card (Hidden from customer) --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Ghi chú nội bộ</h3>
                </div>
                <div class="p-4">
                    <p class="small text-muted mb-2">Ghi chú này chỉ hiển thị trong trang quản trị Admin, khách hàng không thể nhìn thấy.</p>
                    <form action="{{ route('admin.support.notes', $contact->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="internal_notes" class="form-control" rows="7" placeholder="Nhập ghi chú hoặc biên bản trao đổi với khách...">{{ old('internal_notes', $contact->internal_notes) }}</textarea>
                        </div>
                        <button type="submit" class="admin-btn admin-btn--primary btn-sm w-100">
                            Lưu ghi chú nội bộ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
