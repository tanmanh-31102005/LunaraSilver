@extends('layouts.account')

@section('title', 'Viết đánh giá sản phẩm | Lunara Silver')

@php
    $accountBreadcrumbs = [
        ['label' => 'Đánh giá của tôi', 'url' => route('account.reviews.index')],
        ['label' => 'Viết đánh giá']
    ];
    $prod = $item->product;
    $primaryImg = $prod?->images->firstWhere('image_role', 'primary') ?: $prod?->images->first();
@endphp

@section('account_content')
<div class="account-review-create">
    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
        <div class="d-flex align-items-center gap-3 pb-3 border-bottom mb-4">
            <div class="rounded border overflow-hidden bg-light flex-shrink-0" style="width: 72px; height: 72px;">
                @if($primaryImg)
                    <img src="{{ $primaryImg->displayUrl() }}" alt="{{ $item->product_name }}" class="w-100 h-100 object-fit-cover">
                @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-gem"></i></div>
                @endif
            </div>
            <div>
                <span class="text-uppercase text-muted fw-semibold small letter-spacing-1">Đánh giá sản phẩm đã mua</span>
                <h2 class="h5 font-serif text-dark mb-1">{{ $item->product_name }}</h2>
                <div class="text-muted small">Đơn hàng: <strong class="text-dark">#{{ $item->order->order_code }}</strong> · SKU: <span class="font-monospace">{{ $item->product_sku }}</span></div>
            </div>
        </div>

        <form action="{{ route('reviews.store', $prod->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_item_id" value="{{ $item->id }}">

            {{-- Star Rating Picker --}}
            <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">Mức độ hài lòng của bạn <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center gap-3">
                    @for($i = 1; $i <= 5; $i++)
                        <input type="radio" class="btn-check" name="rating" id="create-rating-{{ $i }}" value="{{ $i }}" {{ (int) old('rating', 5) === $i ? 'checked' : '' }} required>
                        <label class="btn btn-outline-warning border rounded px-3 py-2 text-dark d-flex align-items-center gap-1 shadow-xs" for="create-rating-{{ $i }}">
                            <span class="fw-bold">{{ $i }}</span> <i class="bi bi-star-fill text-warning"></i>
                        </label>
                    @endfor
                </div>
                @error('rating')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Title --}}
            <div class="mb-3">
                <label for="create-title" class="form-label fw-bold small text-dark mb-1">Tiêu đề đánh giá (Tùy chọn)</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="create-title" name="title" value="{{ old('title') }}" placeholder="Ví dụ: Trang sức rất sáng và tinh xảo, giao hàng nhanh..." maxlength="120">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Content --}}
            <div class="mb-3">
                <label for="create-content" class="form-label fw-bold small text-dark mb-1">Cảm nhận chi tiết <span class="text-danger">*</span></label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="create-content" name="content" rows="5" maxlength="2000" placeholder="Chia sẻ chi tiết về chất liệu bạc S925, cảm giác đeo, sự vừa vặn và đóng gói của Lunara..." required>{{ old('content') }}</textarea>
                <div class="d-flex justify-content-between mt-1 text-muted" style="font-size: 0.75rem;">
                    <span>Tối thiểu 5 ký tự</span>
                    <span>Tối đa 2000 ký tự</span>
                </div>
                @error('content')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Photo Upload --}}
            <div class="mb-4">
                <label class="form-label fw-bold small text-dark mb-1">
                    <i class="bi bi-camera me-1"></i> Đính kèm hình ảnh thực tế (Tối đa 3 ảnh, JPG/PNG/WEBP, tối đa 5MB/ảnh)
                </label>
                <input type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                <small class="text-muted d-block mt-1">Hình ảnh thực tế sẽ giúp cộng đồng nhìn nhận độ sáng bóng và chi tiết trang sức rõ ràng hơn.</small>
                @error('images')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <a href="{{ route('account.reviews.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="lunara-button lunara-button--dark py-2 px-4">
                    <i class="bi bi-send me-1"></i> Gửi đánh giá xác thực
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
