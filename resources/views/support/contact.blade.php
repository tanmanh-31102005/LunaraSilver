@extends('layouts.app')

@section('title', 'Liên Hệ Với Chúng Tôi — Lunara Silver')
@section('meta_description', 'Liên hệ với Lunara Silver tại 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Ho Chi Minh City. Hotline: 0971 124 922, email: lunaraslivertrangsuc@gmail.com. Hỗ trợ khách hàng 24/7.')
@section('canonical', route('contact'))

@section('content')
<div class="lunara-contact-page py-5">
    <div class="lunara-container">
        {{-- Header --}}
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-uppercase tracking-widest small text-muted d-block mb-2">Concierge & Customer Care</span>
            <h1 class="display-6 font-serif fw-normal mb-3">Liên Hệ Với Lunara</h1>
            <p class="text-muted leading-relaxed">
                Chúng tôi trân trọng mọi chia sẻ, thắc mắc và đóng góp của quý khách. Xin vui lòng gửi thông tin qua biểu mẫu dưới đây, chuyên viên tư vấn sẽ phản hồi trong vòng 24 giờ làm việc.
            </p>
        </div>

        <div class="row g-5 justify-content-center">
            {{-- Contact Information Sidebar --}}
            <div class="col-lg-4 order-lg-2">
                <div class="p-4 p-md-5 border rounded-3 h-100 shadow-sm" style="background-color: var(--ln-color-ivory);">
                    <h3 class="font-serif fs-5 mb-4 text-dark">Thông Tin Hỗ Trợ</h3>

                    <div class="mb-4">
                        <span class="d-block text-muted small text-uppercase tracking-wider mb-1">Địa chỉ cửa hàng</span>
                        <p class="mb-0 text-dark">140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Ho Chi Minh City</p>
                    </div>

                    <div class="mb-4">
                        <span class="d-block text-muted small text-uppercase tracking-wider mb-1">Hotline CSKH / Đặt hàng</span>
                        <p class="mb-0 text-dark fw-medium"><a href="tel:0971124922" class="text-dark text-decoration-none">0971 124 922</a></p>
                        <small class="text-muted">Thứ Hai — Thứ Bảy: 08:30 - 20:30 (Chủ Nhật: 09:00 - 18:00)</small>
                    </div>

                    <div class="mb-4">
                        <span class="d-block text-muted small text-uppercase tracking-wider mb-1">Thư điện tử (Email)</span>
                        <p class="mb-0 text-dark"><a href="mailto:lunaraslivertrangsuc@gmail.com" class="text-dark text-decoration-none">lunaraslivertrangsuc@gmail.com</a></p>
                    </div>

                    <hr class="my-4 border-secondary-subtle">

                    <div class="mb-3">
                        <span class="d-block text-muted small text-uppercase tracking-wider mb-2">Hỗ trợ nhanh</span>
                        <p class="small text-secondary mb-3">Tìm kiếm câu trả lời nhanh chóng cho các câu hỏi thường gặp về thanh toán, giao vận và bảo dưỡng.</p>
                        <x-ui.button variant="secondary" size="sm" :href="route('support.faq')" class="w-100 py-2">
                            Xem Câu Hỏi Thường Gặp (FAQ)
                        </x-ui.button>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="col-lg-7 order-lg-1">
                <div class="p-4 p-md-5 border rounded-3 bg-white shadow-sm">
                    @if(session('success'))
                        <div class="alert alert-success rounded-3 border-0 mb-4 py-3" role="alert">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                                <div>
                                    <strong>Gửi yêu cầu thành công!</strong>
                                    <div class="small">{{ session('success') }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($errors->has('rate_limit'))
                        <div class="alert alert-warning rounded-0 border-0 mb-4 py-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ $errors->first('rate_limit') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf

                        {{-- Honeypot hidden field for anti-spam --}}
                        <div style="display: none !important;">
                            <label for="_hp_website">Website</label>
                            <input type="text" name="_hp_website" id="_hp_website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-3">
                            {{-- Full Name --}}
                            <div class="col-md-6">
                                <label for="contact_name" class="form-label small text-uppercase tracking-wider fw-medium">
                                    Họ và tên <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control rounded-0 py-2 @error('name') is-invalid @enderror"
                                       id="contact_name"
                                       name="name"
                                       value="{{ old('name', $user?->name) }}"
                                       required
                                       placeholder="Nguyễn Văn A">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="contact_email" class="form-label small text-uppercase tracking-wider fw-medium">
                                    Email liên hệ <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       class="form-control rounded-0 py-2 @error('email') is-invalid @enderror"
                                       id="contact_email"
                                       name="email"
                                       value="{{ old('email', $user?->email) }}"
                                       required
                                       placeholder="example@domain.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <label for="contact_phone" class="form-label small text-uppercase tracking-wider fw-medium">
                                    Số điện thoại
                                </label>
                                <input type="tel"
                                       class="form-control rounded-0 py-2 @error('phone') is-invalid @enderror"
                                       id="contact_phone"
                                       name="phone"
                                       value="{{ old('phone', $user?->phone) }}"
                                       placeholder="0912 345 678">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Linked Order (Only for Auth User, or Optional Info) --}}
                            <div class="col-md-6">
                                <label for="contact_order" class="form-label small text-uppercase tracking-wider fw-medium">
                                    Mã đơn hàng (nếu có)
                                </label>
                                @if(auth()->check())
                                    <select class="form-select rounded-0 py-2 @error('order_id') is-invalid @enderror" id="contact_order" name="order_id">
                                        <option value="">-- Không liên kết đơn hàng --</option>
                                        @foreach($userOrders as $userOrder)
                                            <option value="{{ $userOrder->id }}" {{ (string)old('order_id', $selectedOrder?->id) === (string)$userOrder->id ? 'selected' : '' }}>
                                                #{{ $userOrder->order_code }} ({{ number_format($userOrder->grand_total, 0, ',', '.') }}đ — {{ $userOrder->created_at->format('d/m/Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @else
                                    <input type="text" class="form-control rounded-0 py-2" placeholder="Ghi mã đơn hàng trong phần nội dung" disabled>
                                    <small class="text-muted d-block mt-1">Đăng nhập để liên kết tự động với đơn hàng của bạn.</small>
                                @endif
                            </div>

                            {{-- Subject --}}
                            <div class="col-12">
                                <label for="contact_subject" class="form-label small text-uppercase tracking-wider fw-medium">
                                    Chủ đề yêu cầu <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control rounded-0 py-2 @error('subject') is-invalid @enderror"
                                       id="contact_subject"
                                       name="subject"
                                       value="{{ old('subject') }}"
                                       required
                                       placeholder="Ví dụ: Tư vấn kích thước nhẫn / Hỗ trợ thanh toán VNPay">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Message --}}
                            <div class="col-12">
                                <label for="contact_message" class="form-label small text-uppercase tracking-wider fw-medium">
                                    Nội dung chi tiết <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control rounded-0 @error('message') is-invalid @enderror"
                                          id="contact_message"
                                          name="message"
                                          rows="6"
                                          required
                                          placeholder="Vui lòng mô tả chi tiết yêu cầu để chúng tôi hỗ trợ quý khách tốt nhất...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12 mt-4">
                                <x-ui.button variant="primary" size="lg" type="submit" class="px-5 py-3 text-uppercase tracking-wider fs-7 w-100 w-md-auto">
                                    Gửi yêu cầu hỗ trợ
                                </x-ui.button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
