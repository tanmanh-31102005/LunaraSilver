@extends('layouts.app')

@section('title', 'Liên Hệ Với Chúng Tôi — Lunara Silver')
@section('meta_description', 'Liên hệ với Lunara Silver tại 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Ho Chi Minh City. Hotline: 0971 124 922, email: lunaraslivertrangsuc@gmail.com. Hỗ trợ khách hàng chu đáo và tận tâm.')
@section('canonical', route('contact'))
@section('main_class', 'contact-main')

@section('content')
<div class="lunara-contact-page">
    <div class="lunara-container" style="max-width: 1200px;">
        {{-- Hero Header --}}
        <div class="contact-hero">
            <span class="contact-eyebrow">✦ CONCIERGE &amp; CUSTOMER CARE ✦</span>
            <h1 class="contact-title">Liên Hệ Với Lunara</h1>
            <p class="contact-desc">
                Chúng tôi trân trọng mọi chia sẻ, thắc mắc và đóng góp của quý khách. Xin vui lòng gửi thông tin qua biểu mẫu dưới đây, chuyên viên tư vấn sẽ phản hồi trong vòng 24 giờ làm việc.
            </p>
        </div>

        <div class="row g-4 g-lg-5 justify-content-center align-items-stretch">
            {{-- Contact Form (Left) --}}
            <div class="col-lg-7 order-lg-1">
                <div class="contact-form-card">
                    @if(session('success'))
                        <div class="alert alert-success rounded-3 border-0 mb-4 py-3" role="alert" style="background: var(--ln-success-soft); color: var(--ln-success); border-left: 4px solid var(--ln-success) !important;">
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-check-circle-fill fs-5"></i>
                                <div>
                                    <strong>Gửi yêu cầu thành công!</strong>
                                    <div class="small">{{ session('success') }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($errors->has('rate_limit'))
                        <div class="alert alert-warning rounded-3 border-0 mb-4 py-3" role="alert" style="background: var(--ln-warning-soft); color: var(--ln-warning); border-left: 4px solid var(--ln-warning) !important;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                                <div>{{ $errors->first('rate_limit') }}</div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf

                        {{-- Honeypot hidden field for anti-spam --}}
                        <div style="display: none !important;">
                            <label for="_hp_website">Website</label>
                            <input type="text" name="_hp_website" id="_hp_website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-4">
                            {{-- Full Name --}}
                            <div class="col-md-6">
                                <label for="contact_name" class="contact-label">
                                    Họ và tên <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="contact-input @error('name') is-invalid @enderror"
                                       id="contact_name"
                                       name="name"
                                       value="{{ old('name', $user?->name) }}"
                                       required
                                       placeholder="Ví dụ: Nguyễn Thị Mai">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="contact_email" class="contact-label">
                                    Email liên hệ <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       class="contact-input @error('email') is-invalid @enderror"
                                       id="contact_email"
                                       name="email"
                                       value="{{ old('email', $user?->email) }}"
                                       required
                                       placeholder="example@domain.com">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <label for="contact_phone" class="contact-label">
                                    Số điện thoại
                                </label>
                                <input type="tel"
                                       class="contact-input @error('phone') is-invalid @enderror"
                                       id="contact_phone"
                                       name="phone"
                                       value="{{ old('phone', $user?->phone) }}"
                                       placeholder="0912 345 678">
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Linked Order (Only for Auth User, or Optional Info) --}}
                            <div class="col-md-6">
                                <label for="contact_order" class="contact-label">
                                    Mã đơn hàng (nếu có)
                                </label>
                                @if(auth()->check())
                                    <select class="contact-select @error('order_id') is-invalid @enderror" id="contact_order" name="order_id">
                                        <option value="">-- Không liên kết đơn hàng --</option>
                                        @foreach($userOrders as $userOrder)
                                            <option value="{{ $userOrder->id }}" {{ (string)old('order_id', $selectedOrder?->id) === (string)$userOrder->id ? 'selected' : '' }}>
                                                #{{ $userOrder->order_code }} ({{ number_format($userOrder->grand_total, 0, ',', '.') }}đ — {{ $userOrder->created_at->format('d/m/Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                @else
                                    <input type="text" class="contact-input text-muted" placeholder="Ghi mã đơn hàng trong nội dung nếu có" disabled>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">Đăng nhập để tự động liên kết nhanh đơn hàng.</small>
                                @endif
                            </div>

                            {{-- Subject --}}
                            <div class="col-12">
                                <label for="contact_subject" class="contact-label">
                                    Chủ đề yêu cầu <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="contact-input @error('subject') is-invalid @enderror"
                                       id="contact_subject"
                                       name="subject"
                                       value="{{ old('subject') }}"
                                       required
                                       placeholder="Ví dụ: Tư vấn kích thước nhẫn / Hỗ trợ thanh toán VNPay">
                                @error('subject')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Message --}}
                            <div class="col-12">
                                <label for="contact_message" class="contact-label">
                                    Nội dung chi tiết <span class="text-danger">*</span>
                                </label>
                                <textarea class="contact-textarea @error('message') is-invalid @enderror"
                                          id="contact_message"
                                          name="message"
                                          rows="5"
                                          required
                                          placeholder="Vui lòng chia sẻ chi tiết nội dung để chuyên viên Lunara có thể hỗ trợ quý khách chu đáo nhất...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12 pt-2">
                                <button type="submit" class="contact-submit-btn w-100 w-sm-auto">
                                    <span>Gửi yêu cầu hỗ trợ</span>
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Contact Information Sidebar (Right) --}}
            <div class="col-lg-5 order-lg-2">
                <div class="contact-concierge-card">
                    <span class="contact-concierge-card__eyebrow">✦ CHĂM SÓC KHÁCH HÀNG ✦</span>
                    <h2 class="contact-concierge-card__title">Thông Tin Hỗ Trợ</h2>
                    <p class="contact-concierge-card__desc">
                        Đội ngũ tư vấn viên kim hoàn Lunara luôn sẵn sàng đồng hành và giải đáp mọi băn khoăn của quý khách.
                    </p>

                    <div class="contact-info-list">
                        {{-- Address --}}
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="contact-info-content">
                                <span class="contact-info-label">Địa chỉ showroom</span>
                                <p class="contact-info-value">140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, TP. Hồ Chí Minh</p>
                            </div>
                        </div>

                        {{-- Phone / Hotline --}}
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="contact-info-content">
                                <span class="contact-info-label">Hotline CSKH / Đặt hàng</span>
                                <p class="contact-info-value">
                                    <a href="tel:0971124922">0971 124 922</a>
                                </p>
                                <span class="contact-info-sub">Thứ Hai — Thứ Bảy: 08:30 - 20:30 (Chủ Nhật: 09:00 - 18:00)</span>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="contact-info-content">
                                <span class="contact-info-label">Thư điện tử (Email)</span>
                                <p class="contact-info-value">
                                    <a href="mailto:lunaraslivertrangsuc@gmail.com">lunaraslivertrangsuc@gmail.com</a>
                                </p>
                            </div>
                        </div>

                        {{-- Commitment --}}
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="contact-info-content">
                                <span class="contact-info-label">Cam kết dịch vụ</span>
                                <p class="contact-info-value" style="font-size: 0.85rem; color: var(--lunara-muted); font-weight: 400;">
                                    Phản hồi trong vòng 24 giờ làm việc. Bảo mật thông tin khách hàng tuyệt đối.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Quick FAQ Box --}}
                    <div class="contact-quick-faq">
                        <span class="contact-quick-faq__title">
                            <i class="bi bi-question-circle text-muted"></i>
                            <span>Hỗ trợ nhanh chóng</span>
                        </span>
                        <p class="contact-quick-faq__desc">
                            Tìm kiếm câu trả lời nhanh chóng cho các thắc mắc thường gặp về kích thước nhẫn, bảo quản bạc 925, giao hàng và đổi trả.
                        </p>
                        <a href="{{ route('support.faq') }}" class="contact-quick-faq__btn">
                            <span>Xem Câu Hỏi Thường Gặp (FAQ)</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
