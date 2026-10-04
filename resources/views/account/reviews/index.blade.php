@extends('layouts.account')

@section('title', 'Đánh giá của tôi | Lunara Silver')

@php
    $accountBreadcrumbs = [['label' => 'Đánh giá của tôi']];
@endphp

@section('account_content')
<div class="account-reviews">
    {{-- Header --}}
    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="text-uppercase text-muted fw-semibold small letter-spacing-1">Trung tâm đánh giá</span>
                <h2 class="h4 font-serif text-dark mb-1">Đánh giá sản phẩm đã mua</h2>
                <p class="text-muted small mb-0">Chia sẻ cảm nhận về trang sức Lunara để tích lũy đặc quyền và giúp đỡ cộng đồng mua sắm.</p>
            </div>
        </div>

        {{-- Nav Tabs (Phase 20.11) --}}
        <ul class="nav nav-pills mt-4 border-bottom pb-2 gap-2" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('account.reviews.index', ['tab' => 'pending']) }}" class="nav-link {{ $tab === 'pending' ? 'active bg-dark text-white' : 'text-dark bg-light' }} rounded-pill px-3 py-1-5 fw-medium small">
                    <i class="bi bi-clock me-1"></i> Chờ đánh giá ({{ $pendingItems->count() }})
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('account.reviews.index', ['tab' => 'reviewed']) }}" class="nav-link {{ $tab === 'reviewed' ? 'active bg-dark text-white' : 'text-dark bg-light' }} rounded-pill px-3 py-1-5 fw-medium small">
                    <i class="bi bi-check2-circle me-1"></i> Đã đánh giá ({{ $userReviews->total() }})
                </a>
            </li>
        </ul>
    </div>

    {{-- Tab 1: Chờ đánh giá --}}
    @if($tab === 'pending')
        @if($pendingItems->isNotEmpty())
            <div class="d-flex flex-column gap-3">
                @foreach($pendingItems as $item)
                    @php
                        $prod = $item->product;
                        $primaryImg = $prod?->images->firstWhere('image_role', 'primary') ?: $prod?->images->first();
                    @endphp
                    <div class="card border-0 shadow-sm rounded-3 p-3 p-md-4 bg-white">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded border overflow-hidden bg-light flex-shrink-0" style="width: 72px; height: 72px;">
                                    @if($primaryImg)
                                        <img src="{{ $primaryImg->displayUrl() }}" alt="{{ $item->product_name }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-gem"></i></div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="h6 mb-1 text-dark fw-bold">
                                        @if($prod && $prod->is_active)
                                            <a href="{{ route('products.show', $prod->slug) }}" class="text-dark text-decoration-none hover-underline">{{ $item->product_name }}</a>
                                        @else
                                            {{ $item->product_name }}
                                        @endif
                                    </h3>
                                    <div class="text-muted small">Mã đơn: <strong class="text-dark">#{{ $item->order->order_code }}</strong> · Đặt ngày {{ $item->order->created_at->format('d/m/Y') }}</div>
                                    <div class="text-muted small">SKU: <span class="font-monospace">{{ $item->product_sku }}</span> · Số lượng: {{ $item->quantity }}</div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                @if($prod && $prod->is_active)
                                    <a href="{{ route('account.reviews.create', $item->id) }}" class="lunara-button lunara-button--dark btn-sm py-2 px-3 text-nowrap">
                                        <i class="bi bi-pencil-square me-1"></i> Viết đánh giá
                                    </a>
                                @else
                                    <span class="badge bg-light text-muted border">Sản phẩm ngừng bán</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-3 p-5 text-center bg-white">
                <i class="bi bi-patch-check text-muted fs-1 mb-2"></i>
                <h3 class="h5 font-serif text-dark mb-1">Bạn không có sản phẩm nào chờ đánh giá</h3>
                <p class="text-muted small mb-3">Tất cả sản phẩm trong các đơn hàng hoàn tất đã được bạn đánh giá hoặc bạn chưa hoàn thành đơn hàng nào gần đây.</p>
                <div>
                    <a href="{{ route('products.index') }}" class="lunara-button lunara-button--outline btn-sm">
                        <i class="bi bi-gem me-1"></i> Khám phá bộ sưu tập mới
                    </a>
                </div>
            </div>
        @endif
    @else
    {{-- Tab 2: Đã đánh giá --}}
        @if($userReviews->isNotEmpty())
            <div class="d-flex flex-column gap-3">
                @foreach($userReviews as $review)
                    @php
                        $prod = $review->product;
                        $primaryImg = $prod?->images->firstWhere('image_role', 'primary') ?: $prod?->images->first();
                    @endphp
                    <div class="card border-0 shadow-sm rounded-3 p-3 p-md-4 bg-white">
                        <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded border overflow-hidden bg-light flex-shrink-0" style="width: 56px; height: 56px;">
                                    @if($primaryImg)
                                        <img src="{{ $primaryImg->displayUrl() }}" alt="{{ $prod?->name }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-gem"></i></div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="h6 mb-1 text-dark fw-bold">
                                        @if($prod && $prod->is_active)
                                            <a href="{{ route('products.show', $prod->slug) }}" class="text-dark text-decoration-none hover-underline">{{ $prod->name }}</a>
                                        @else
                                            {{ $prod?->name ?? 'Sản phẩm Lunara' }}
                                        @endif
                                    </h3>
                                    <div class="review-stars text-warning small">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $review->rating >= $i ? '-fill' : '' }}"></i>
                                        @endfor
                                        <span class="text-muted ms-1 font-monospace">{{ $review->rating }}/5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                @if($review->status === 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 small">
                                        <i class="bi bi-check2-circle me-1"></i> Đã duyệt
                                    </span>
                                @elseif($review->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-1 small">
                                        <i class="bi bi-clock me-1"></i> Chờ kiểm duyệt
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1 small">
                                        <i class="bi bi-x-circle me-1"></i> Từ chối
                                    </span>
                                @endif
                                <div class="text-muted small mt-1">{{ $review->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>

                        @if($review->title)
                            <h4 class="h6 fw-bold text-dark mb-1">{{ $review->title }}</h4>
                        @endif

                        <p class="text-secondary small mb-2" style="line-height: 1.6;">{{ $review->effective_content }}</p>

                        @if($review->media->isNotEmpty())
                            <div class="d-flex gap-2 mb-2">
                                @foreach($review->media as $m)
                                    <a href="{{ $m->image_url }}" target="_blank" class="rounded overflow-hidden border shadow-2xs" style="width: 60px; height: 60px;">
                                        <img src="{{ $m->image_url }}" alt="Ảnh đánh giá" class="w-100 h-100 object-fit-cover" loading="lazy">
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @if($review->admin_reply)
                            <div class="merchant-reply mt-2 p-3 rounded bg-light border-start border-3 border-dark" style="font-size: 0.8125rem;">
                                <div class="d-flex align-items-center gap-1 fw-bold text-dark mb-1">
                                    <i class="bi bi-shield-check text-champagne"></i>
                                    <span class="text-uppercase tracking-wider" style="font-size: 0.75rem;">Phản hồi từ Lunara Silver</span>
                                    <span class="text-muted ms-auto fw-normal" style="font-size: 0.72rem;">{{ $review->admin_replied_at?->format('d/m/Y') }}</span>
                                </div>
                                <div class="text-secondary fst-italic ps-1">
                                    “{{ $review->admin_reply }}”
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="d-flex justify-content-center mt-3">
                    {{ $userReviews->appends(['tab' => 'reviewed'])->links() }}
                </div>
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-3 p-5 text-center bg-white">
                <i class="bi bi-chat-square-heart text-muted fs-1 mb-2"></i>
                <h3 class="h5 font-serif text-dark mb-1">Bạn chưa có đánh giá nào</h3>
                <p class="text-muted small mb-3">Những đánh giá của bạn sẽ được lưu giữ tại đây sau khi bạn gửi nhận xét.</p>
                <div>
                    <a href="{{ route('account.reviews.index', ['tab' => 'pending']) }}" class="lunara-button lunara-button--outline btn-sm">
                        <i class="bi bi-pencil-square me-1"></i> Xem sản phẩm chờ đánh giá
                    </a>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
