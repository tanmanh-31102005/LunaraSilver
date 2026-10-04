@extends('admin.layouts.app')

@section('title', "Chi tiết đánh giá #{$review->id} | Lunara Admin")
@section('page_title', "Chi tiết đánh giá #{$review->id}")

@section('breadcrumb')
    <li><a href="{{ route('admin.reviews.index') }}">Đánh giá sản phẩm</a></li>
    <li class="active">Chi tiết #{{ $review->id }}</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Chi tiết đánh giá #{{ $review->id }}</h2>
            <p class="text-muted small mb-0">Xem toàn bộ thông tin đánh giá, ảnh đính kèm và lịch sử kiểm duyệt.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.reviews.index') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            @if($review->status !== 'approved')
                <form action="{{ route('admin.reviews.approve', $review) }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <i class="bi bi-check-lg"></i> Duyệt đánh giá này
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column: Review Content & Media --}}
        <div class="col-lg-8">
            <div class="admin-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <div class="review-stars text-warning fs-5 mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $review->rating >= $i ? '-fill' : '' }}"></i>
                            @endfor
                            <span class="text-dark fw-bold ms-2">{{ $review->rating }} / 5 sao</span>
                        </div>
                        <div class="text-muted small">Đăng ngày {{ $review->created_at->format('d/m/Y H:i') }} ({{ $review->created_at->diffForHumans() }})</div>
                    </div>
                    <div>
                        @if($review->status === 'approved')
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1-5">
                                <i class="bi bi-check-circle-fill me-1"></i> Đã phê duyệt
                            </span>
                        @elseif($review->status === 'pending')
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-1-5">
                                <i class="bi bi-clock-fill me-1"></i> Chờ kiểm duyệt
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1-5">
                                <i class="bi bi-x-circle-fill me-1"></i> Bị từ chối
                            </span>
                        @endif
                    </div>
                </div>

                @if($review->title)
                    <h3 class="h5 fw-bold text-dark mb-2">{{ $review->title }}</h3>
                @endif

                <div class="review-content-box p-3 rounded bg-light border text-dark mb-4" style="line-height: 1.7;">
                    {{ $review->effective_content }}
                </div>

                {{-- Attached Images --}}
                @if($review->media->isNotEmpty())
                    <div class="mb-4">
                        <h4 class="h6 fw-bold text-dark mb-2">Hình ảnh khách hàng đính kèm ({{ $review->media->count() }} ảnh)</h4>
                        <div class="row g-3">
                            @foreach($review->media as $media)
                                <div class="col-4 col-sm-3">
                                    <a href="{{ $media->image_url }}" target="_blank" class="d-block ratio ratio-1x1 rounded border overflow-hidden shadow-xs hover-zoom">
                                        <img src="{{ $media->image_url }}" alt="Ảnh đánh giá" class="w-100 h-100 object-fit-cover">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Rejection Reason --}}
                @if($review->status === 'rejected' && $review->rejection_reason)
                    <div class="alert alert-danger mb-4">
                        <strong class="d-block mb-1"><i class="bi bi-exclamation-octagon me-1"></i> Lý do từ chối:</strong>
                        <span>{{ $review->rejection_reason }}</span>
                    </div>
                @endif

                {{-- Merchant Reply Form (20.32 - 20.33) --}}
                <div class="border-top pt-4">
                    <h4 class="h6 fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-reply-all-fill text-primary"></i>
                        <span>Phản hồi chính thức từ Lunara Silver</span>
                    </h4>

                    @if($review->admin_reply)
                        <div class="p-3 rounded bg-light border-start border-3 border-dark mb-3">
                            <div class="d-flex justify-content-between text-muted small mb-1">
                                <span>Người trả lời: <strong>{{ $review->repliedBy?->name ?? 'Admin' }}</strong></span>
                                <span>{{ $review->admin_replied_at?->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="mb-0 text-dark fst-italic">“{{ $review->admin_reply }}”</p>
                        </div>
                    @endif

                    <form action="{{ route('admin.reviews.reply', $review) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="admin_reply" class="form-label small text-muted">Cập nhật phản hồi đại diện:</label>
                            <textarea id="admin_reply" name="admin_reply" class="form-control form-control-sm" rows="3" placeholder="Nhập câu trả lời lịch sự, chuyên nghiệp từ thương hiệu Lunara..." required>{{ old('admin_reply', $review->admin_reply) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="admin-btn admin-btn--primary btn-sm">
                                <i class="bi bi-send me-1"></i> {{ $review->admin_reply ? 'Cập nhật phản hồi' : 'Gửi phản hồi' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Column: Product & Customer & Order Info --}}
        <div class="col-lg-4">
            {{-- Product Card --}}
            @php
                $prod = $review->product;
                $primaryImg = $prod?->images->firstWhere('image_role', 'primary') ?: $prod?->images->first();
            @endphp
            <div class="admin-card p-3 mb-4">
                <h4 class="h6 fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
                    <i class="bi bi-gem text-muted"></i>
                    <span>Sản phẩm được đánh giá</span>
                </h4>
                <div class="d-flex gap-3 align-items-center mb-3">
                    <div class="rounded border overflow-hidden flex-shrink-0" style="width: 56px; height: 56px;">
                        @if($primaryImg)
                            <img src="{{ $primaryImg->displayUrl() }}" alt="" class="w-100 h-100 object-fit-cover">
                        @else
                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted"><i class="bi bi-gem"></i></div>
                        @endif
                    </div>
                    <div>
                        <div class="fw-semibold text-dark small">{{ $prod?->name ?? 'Sản phẩm đã xóa' }}</div>
                        <div class="font-monospace text-muted small">SKU: {{ $prod?->sku }}</div>
                    </div>
                </div>
                @if($prod && $prod->is_active)
                    <a href="{{ route('products.show', $prod->slug) }}" target="_blank" class="admin-btn admin-btn--secondary btn-sm w-100">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Xem trên storefront
                    </a>
                @endif
            </div>

            {{-- Customer Card --}}
            <div class="admin-card p-3 mb-4">
                <h4 class="h6 fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
                    <i class="bi bi-person text-muted"></i>
                    <span>Khách hàng đánh giá</span>
                </h4>
                <div class="mb-2">
                    <span class="text-muted small d-block">Họ và tên:</span>
                    <strong class="text-dark">{{ $review->user?->name ?? 'Không xác định' }}</strong>
                </div>
                <div class="mb-2">
                    <span class="text-muted small d-block">Email:</span>
                    <span class="text-dark small">{{ $review->user?->email }}</span>
                </div>
                <div>
                    <span class="text-muted small d-block">Tên hiển thị công khai (Bảo mật):</span>
                    <span class="badge bg-light text-dark border">{{ $review->masked_user_name }}</span>
                </div>
            </div>

            {{-- Verified Order Card --}}
            @if($review->orderItem && $review->orderItem->order)
                <div class="admin-card p-3">
                    <h4 class="h6 fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
                        <i class="bi bi-bag-check text-muted"></i>
                        <span>Đơn hàng liên kết</span>
                    </h4>
                    <div class="mb-2">
                        <span class="text-muted small d-block">Mã đơn hàng:</span>
                        <a href="{{ route('admin.orders.show', $review->orderItem->order->order_code) }}" class="fw-bold font-monospace text-primary text-decoration-none hover-underline">
                            #{{ $review->orderItem->order->order_code }}
                        </a>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small d-block">Trạng thái đơn:</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            {{ $review->orderItem->order->order_status }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small d-block">Ngày đặt hàng:</span>
                        <span class="text-dark small">{{ $review->orderItem->order->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <span class="badge bg-success text-white py-1 px-2 small">
                            <i class="bi bi-shield-check me-1"></i> Verified Purchase (Đã mua thật)
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
