@extends('layouts.app')

@section('title', 'Thanh toán | Lunara Silver')
@section('main_class', 'checkout-main')

@section('content')
    <div class="lunara-container checkout-page">
        <x-breadcrumb :items="[['label' => 'Giỏ hàng', 'url' => route('cart.index')], ['label' => 'Thanh toán']]" />

        <h1>Thanh toán đơn hàng</h1>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <p class="mb-2"><strong>Không thể hoàn tất đặt hàng. Vui lòng kiểm tra lại:</strong></p>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="checkout-layout">
            <div class="checkout-form-container">
                <form class="checkout-form" action="{{ route('checkout.store') }}" method="post" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="checkout_token" value="{{ $checkoutToken }}">

                    <section class="checkout-section" aria-labelledby="shipping-heading">
                        <h2 id="shipping-heading"><span class="checkout-step-badge">1</span> Thông tin giao hàng</h2>

                        @if(isset($savedAddresses) && $savedAddresses->isNotEmpty())
                            <div class="saved-address-picker mb-4 p-3 bg-light rounded-3 border">
                                <label class="form-label fw-bold mb-2 d-flex align-items-center" for="savedAddressSelect">
                                    <i class="bi bi-geo-alt me-2 text-primary"></i> Chọn từ sổ địa chỉ đã lưu
                                </label>
                                <select class="form-select bg-white" id="savedAddressSelect">
                                    <option value="">-- Chọn địa chỉ hoặc nhập mới bên dưới --</option>
                                    @foreach($savedAddresses as $addr)
                                        @php
                                            $formattedFullAddress = trim($addr->address_line . ($addr->ward ? ', ' . $addr->ward : '') . ($addr->district ? ', ' . $addr->district : ''));
                                        @endphp
                                        <option value="{{ $addr->id }}"
                                            data-name="{{ $addr->recipient_name }}"
                                            data-phone="{{ $addr->phone }}"
                                            data-address="{{ $formattedFullAddress }}"
                                            data-city="{{ $addr->city }}"
                                            {{ $defaultAddress && $defaultAddress->id === $addr->id ? 'selected' : '' }}>
                                            {{ $addr->recipient_name }} | {{ $addr->phone }} — {{ $addr->address_line }}, {{ $addr->city }} {{ $addr->is_default ? '(Mặc định)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @php
                            $defaultFullAddress = $defaultAddress ? trim($defaultAddress->address_line . ($defaultAddress->ward ? ', ' . $defaultAddress->ward : '') . ($defaultAddress->district ? ', ' . $defaultAddress->district : '')) : '';
                        @endphp

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="customer_name">Họ và tên người nhận <span class="text-danger">*</span></label>
                                <input class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" type="text" name="customer_name" value="{{ old('customer_name', $defaultAddress?->recipient_name ?? auth()->user()?->name) }}" required autocomplete="name">
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="customer_phone">Số điện thoại nhận hàng <span class="text-danger">*</span></label>
                                <input class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" type="tel" name="customer_phone" value="{{ old('customer_phone', $defaultAddress?->phone) }}" required autocomplete="tel" placeholder="Ví dụ: 0901234567">
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="customer_email">Địa chỉ Email <span class="text-danger">*</span></label>
                                <input class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" required autocomplete="email">
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-8">
                                <label class="form-label" for="shipping_address">Địa chỉ chi tiết (số nhà, đường) <span class="text-danger">*</span></label>
                                <input class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" type="text" name="shipping_address" value="{{ old('shipping_address', $defaultFullAddress) }}" required autocomplete="street-address" placeholder="Ví dụ: 123 Lê Lợi, Phường Bến Nghé">
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label" for="shipping_city">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                <input class="form-control @error('shipping_city') is-invalid @enderror" id="shipping_city" type="text" name="shipping_city" value="{{ old('shipping_city', $defaultAddress?->city ?? 'Hồ Chí Minh') }}" required autocomplete="address-level1">
                                @error('shipping_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="shipping_note">Ghi chú giao hàng (tùy chọn)</label>
                                <textarea class="form-control" id="shipping_note" name="shipping_note" rows="2" placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi giao...">{{ old('shipping_note') }}</textarea>
                            </div>
                        </div>
                    </section>

                    <section class="checkout-section mt-4" aria-labelledby="delivery-heading">
                        <h2 id="delivery-heading"><span class="checkout-step-badge">2</span> Phương thức vận chuyển</h2>
                        <div class="shipping-option selected">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="shipping_method_display" id="shipping_standard" value="standard" checked disabled>
                                <label class="form-check-label w-100 d-flex justify-content-between align-items-center" for="shipping_standard">
                                    <span><strong>Giao hàng tiêu chuẩn</strong><br><small class="text-muted">Giao tận nơi toàn quốc (2 - 4 ngày làm việc)</small></span>
                                    <span>Phí vận chuyển hiện tại: 0 ₫</span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <section class="checkout-section mt-4" aria-labelledby="payment-heading">
                        <h2 id="payment-heading"><span class="checkout-step-badge">3</span> Phương thức thanh toán</h2>
                        <div class="payment-option selected">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod" checked required>
                                <label class="form-check-label w-100" for="payment_cod">
                                    <strong>Thanh toán khi nhận hàng (COD)</strong>
                                    <p class="text-muted small mb-0 mt-1">Quý khách nhận hàng, kiểm tra sản phẩm và thanh toán tiền mặt trực tiếp cho nhân viên vận chuyển.</p>
                                </label>
                            </div>
                        </div>
                    </section>

                    <section class="checkout-section mt-4" aria-labelledby="note-heading">
                        <h2 id="note-heading"><span class="checkout-step-badge">4</span> Ghi chú đơn hàng (tùy chọn)</h2>
                        <textarea class="form-control" id="customer_note" name="customer_note" rows="2" placeholder="Ghi chú thêm cho Lunara Silver (nếu có)...">{{ old('customer_note') }}</textarea>
                    </section>

                    <div class="checkout-actions mt-4">
                        <button class="lunara-button lunara-button--dark w-100 py-3" type="submit" id="submitOrderBtn">
                            Đặt hàng ngay
                        </button>
                        <p class="text-center mt-2 mb-0">
                            <a class="text-muted small text-decoration-underline" href="{{ route('cart.index') }}">← Quay lại giỏ hàng</a>
                        </p>
                    </div>
                </form>
            </div>

            <aside class="checkout-summary" aria-label="Tóm tắt đơn hàng">
                <h2>Đơn hàng ({{ $cartSummary['cart_count'] }} sản phẩm)</h2>

                <div class="checkout-summary__items">
                    @foreach($cartSummary['items'] as $item)
                        <div class="checkout-summary__item">
                            <div class="checkout-summary__media">
                                @if($item['image_url'])
                                    <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" width="60" height="75" loading="lazy">
                                @else
                                    <span role="img" aria-label="Chưa có ảnh"><i class="bi bi-image"></i></span>
                                @endif
                                <span class="checkout-summary__qty">{{ $item['quantity'] }}</span>
                            </div>
                            <div class="checkout-summary__info">
                                <h3>{{ $item['name'] }}</h3>
                                <p class="text-muted small mb-0">SKU: {{ $item['sku'] }}</p>
                                @if($item['type'] !== 'single')
                                    <small class="badge bg-light text-dark border">{{ $item['type'] === 'gift' ? 'Set quà tặng' : 'Bộ trang sức' }}</small>
                                @endif
                            </div>
                            <div class="checkout-summary__price">
                                <strong>{{ $item['line_subtotal_display'] }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="checkout-summary__totals">
                    <div class="d-flex justify-content-between py-2 border-top">
                        <span>Tạm tính</span>
                        <strong>{{ $cartSummary['subtotal_display'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-top">
                        <span>Phí vận chuyển</span>
                        <span>0 ₫</span>
                    </div>
                    <div class="d-flex justify-content-between py-3 border-top border-bottom">
                        <span class="h5 mb-0">Tổng thanh toán</span>
                        <strong class="h5 mb-0 text-dark">{{ $cartSummary['subtotal_display'] }}</strong>
                    </div>
                </div>

                <div class="checkout-summary__guarantee mt-3">
                    <p class="small text-muted mb-1"><i class="bi bi-shield-check me-1 text-success"></i> Đảm bảo chất lượng bạc 925 cao cấp</p>
                    <p class="small text-muted mb-0"><i class="bi bi-arrow-counterclockwise me-1 text-primary"></i> Đổi trả dễ dàng trong vòng 7 ngày</p>
                </div>
            </aside>
        </div>
    </div>
@endsection
