<section id="reviews" class="detail-section detail-reviews my-5 pt-3" aria-labelledby="reviews-heading">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 border-bottom pb-3">
        <div>
            <span class="text-uppercase tracking-widest small text-muted d-block mb-1">Trải nghiệm thực tế</span>
            <h2 id="reviews-heading" class="h3 font-serif mb-0">Đánh Giá Từ Khách Hàng</h2>
        </div>
        @if($eligibleOrderItem)
            <a href="#write-review-card" class="lunara-button lunara-button--dark btn-sm mt-3 mt-md-0" data-bs-toggle="collapse" data-bs-target="#write-review-card" role="button" aria-expanded="false" aria-controls="write-review-card">
                <i class="bi bi-pencil-square me-1"></i> Viết đánh giá sản phẩm
            </a>
        @endif
    </div>

    {{-- Rating Summary & Stars Breakdown (Phase 20.12 - 20.13) --}}
    <div class="reviews-overview-card p-4 rounded border bg-light mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-md-4 text-center border-md-end">
                @if($ratingSummary['total'] > 0)
                    <div class="display-4 fw-serif text-dark mb-1">{{ number_format($ratingSummary['average'], 1) }}</div>
                    <div class="reviews-stars-row text-warning fs-5 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($ratingSummary['average'] >= $i)
                                <i class="bi bi-star-fill"></i>
                            @elseif($ratingSummary['average'] >= $i - 0.5)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="text-muted small mb-0">Dựa trên <strong>{{ $ratingSummary['total'] }}</strong> đánh giá thực tế</p>
                @else
                    <div class="reviews-stars-row text-muted fs-4 mb-2">
                        <i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i>
                    </div>
                    <p class="fw-medium text-dark mb-1">Chưa có đánh giá</p>
                    <p class="text-muted small mb-0">Hãy là người đầu tiên chia sẻ cảm nhận sau khi mua hàng!</p>
                @endif
            </div>

            <div class="col-md-8">
                <div class="star-breakdown-list">
                    @foreach([5, 4, 3, 2, 1] as $star)
                        @php
                            $row = $ratingSummary['breakdown'][$star] ?? ['count' => 0, 'percentage' => 0];
                            $isActiveStar = ($ratingFilter === $star);
                        @endphp
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <a href="{{ request()->fullUrlWithQuery(['rating' => $isActiveStar ? null : $star]) }}#reviews" class="text-decoration-none text-dark small fw-medium d-flex align-items-center gap-1" style="width: 50px;">
                                <span>{{ $star }}</span> <i class="bi bi-star-fill text-warning" style="font-size: 0.75rem;"></i>
                            </a>
                            <div class="progress flex-grow-1" style="height: 8px; background: rgba(0,0,0,0.06);">
                                <div class="progress-bar bg-dark" role="progressbar" style="width: {{ $row['percentage'] }}%;" aria-valuenow="{{ $row['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-muted small text-end" style="width: 45px;">{{ $row['percentage'] }}%</span>
                            <span class="text-muted small text-end font-monospace" style="width: 35px;">({{ $row['count'] }})</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Review Submission Form for Verified Buyer (Phase 20.3, 20.10) --}}
    @if($eligibleOrderItem)
        <div class="collapse mb-4 @if($errors->any()) show @endif" id="write-review-card">
            <div class="card border p-4 shadow-sm" style="border-color: rgba(184, 150, 107, 0.4) !important;">
                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                    <i class="bi bi-patch-check-fill text-accent fs-4"></i>
                    <div>
                        <h4 class="h6 mb-0 fw-bold text-dark">Viết đánh giá cho sản phẩm đã mua</h4>
                        <small class="text-muted">Đơn hàng <strong>#{{ $eligibleOrderItem->order->order_code }}</strong> (Giao dịch xác thực)</small>
                    </div>
                </div>

                <form action="{{ route('reviews.store', $product->slug) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_item_id" value="{{ $eligibleOrderItem->id }}">

                    {{-- Star Rating Picker --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark mb-1">Mức độ hài lòng của bạn <span class="text-danger">*</span></label>
                        <div class="rating-star-picker d-flex align-items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" class="btn-check" name="rating" id="rating-star-{{ $i }}" value="{{ $i }}" {{ (int) old('rating', 5) === $i ? 'checked' : '' }} required>
                                <label class="btn btn-outline-warning border rounded px-3 py-1 text-dark d-flex align-items-center gap-1" for="rating-star-{{ $i }}">
                                    <span>{{ $i }}</span> <i class="bi bi-star-fill text-warning"></i>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Review Title --}}
                    <div class="mb-3">
                        <label for="review-title" class="form-label fw-semibold small text-dark mb-1">Tiêu đề đánh giá (Tùy chọn)</label>
                        <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror" id="review-title" name="title" value="{{ old('title') }}" placeholder="Ví dụ: Thiết kế tinh xảo, bạc sáng bóng rất đẹp..." maxlength="120">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Review Content --}}
                    <div class="mb-3">
                        <label for="review-content" class="form-label fw-semibold small text-dark mb-1">Cảm nhận chi tiết của bạn <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm @error('content') is-invalid @enderror" id="review-content" name="content" rows="4" maxlength="2000" placeholder="Chia sẻ về độ hoàn thiện, kích cỡ, trải nghiệm đeo trang sức thực tế..." required>{{ old('content') }}</textarea>
                        <div class="d-flex justify-content-between mt-1 text-muted" style="font-size: 0.72rem;">
                            <span>Tối thiểu 5 ký tự</span>
                            <span>Tối đa 2000 ký tự</span>
                        </div>
                        @error('content')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Photo Upload (Max 3) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark mb-1">
                            <i class="bi bi-camera me-1"></i> Đính kèm hình ảnh thực tế (Tối đa 3 ảnh, định dạng JPG/PNG/WEBP, tối đa 5MB/ảnh)
                        </label>
                        <input type="file" class="form-control form-control-sm @error('images') is-invalid @enderror" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                        @error('images')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#write-review-card">Hủy bỏ</button>
                        <button type="submit" class="lunara-button lunara-button--dark btn-sm">
                            <i class="bi bi-send me-1"></i> Gửi đánh giá xác thực
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @elseif($hasReviewed)
        <div class="alert alert-light border rounded mb-4 d-flex align-items-center gap-2 text-muted" style="font-size: 0.85rem;">
            <i class="bi bi-check-circle text-success fs-5"></i>
            <span>Bạn đã đánh giá sản phẩm này. Cảm ơn bạn đã đồng hành và chia sẻ trải nghiệm cùng Lunara Silver!</span>
        </div>
    @endif

    {{-- Customer Photo Gallery (Phase 20.25) --}}
    @if($customerGallery->isNotEmpty())
        <div class="customer-photo-gallery mb-4 p-3 rounded border bg-white">
            <h4 class="small text-uppercase tracking-wider fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-images text-accent"></i>
                <span>Hình ảnh từ khách hàng ({{ $customerGallery->count() }})</span>
            </h4>
            <div class="row g-2">
                @foreach($customerGallery as $photo)
                    <div class="col-3 col-md-2 col-lg-1-5">
                        <a href="{{ $photo->image_url }}" target="_blank" class="d-block ratio ratio-1x1 rounded overflow-hidden border shadow-sm" title="Ảnh chụp thực tế từ khách hàng">
                            <img src="{{ $photo->image_url }}" alt="Hình ảnh đánh giá sản phẩm" class="w-100 h-100 object-fit-cover hover-zoom" loading="lazy">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Review Filter and Sorting Bar (Phase 20.18 - 20.19) --}}
    @if($ratingSummary['total'] > 0)
        <div class="review-toolbar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 p-3 bg-light rounded border mb-4">
            <div class="filter-chips d-flex flex-wrap align-items-center gap-2">
                <span class="small text-muted me-1">Lọc sao:</span>
                <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}#reviews" class="btn btn-sm {{ $ratingFilter === null ? 'btn-dark' : 'btn-outline-secondary bg-white' }} rounded-pill px-3">
                    Tất cả ({{ $ratingSummary['total'] }})
                </a>
                @foreach([5, 4, 3, 2, 1] as $star)
                    @if(($ratingSummary['breakdown'][$star]['count'] ?? 0) > 0)
                        <a href="{{ request()->fullUrlWithQuery(['rating' => $star]) }}#reviews" class="btn btn-sm {{ $ratingFilter === $star ? 'btn-dark' : 'btn-outline-secondary bg-white' }} rounded-pill px-2-5">
                            {{ $star }} ★ ({{ $ratingSummary['breakdown'][$star]['count'] }})
                        </a>
                    @endif
                @endforeach
            </div>

            <div class="sort-selector d-flex align-items-center gap-2">
                <label for="review-sort" class="small text-muted text-nowrap mb-0">Sắp xếp:</label>
                <select id="review-sort" class="form-select form-select-sm bg-white" style="width: auto;" onchange="location = this.value;">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}#reviews" {{ $sort === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'highest']) }}#reviews" {{ $sort === 'highest' ? 'selected' : '' }}>Đánh giá cao nhất</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'lowest']) }}#reviews" {{ $sort === 'lowest' ? 'selected' : '' }}>Đánh giá thấp nhất</option>
                </select>
            </div>
        </div>
    @endif

    {{-- Review Cards List (Phase 20.15 - 20.17) --}}
    @if($reviews->isNotEmpty())
        <div class="review-cards-list d-flex flex-column gap-3 mb-4">
            @foreach($reviews as $review)
                <article class="review-card p-3 p-md-4 rounded border bg-white shadow-xs">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="review-card__stars text-warning fs-6 mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $review->rating >= $i ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <strong class="text-dark small">{{ $review->masked_user_name }}</strong>
                                @if($review->verified_purchase)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0-5" style="font-size: 0.7rem;">
                                        <i class="bi bi-patch-check-fill me-1"></i> Đã mua hàng
                                    </span>
                                @endif
                            </div>
                        </div>
                        <time class="text-muted small" datetime="{{ $review->created_at->toIso8601String() }}">
                            {{ $review->created_at->format('d/m/Y') }}
                        </time>
                    </div>

                    @if($review->title)
                        <h4 class="h6 fw-bold text-dark mt-2 mb-1">{{ $review->title }}</h4>
                    @endif

                    <div class="review-card__body text-secondary small" style="line-height: 1.6;">
                        {{ $review->effective_content }}
                    </div>

                    {{-- Review Attached Photos --}}
                    @if($review->media->isNotEmpty())
                        <div class="review-card__media d-flex gap-2 mt-3">
                            @foreach($review->media as $media)
                                <a href="{{ $media->image_url }}" target="_blank" class="rounded overflow-hidden border shadow-2xs" style="width: 72px; height: 72px;">
                                    <img src="{{ $media->image_url }}" alt="Ảnh đánh giá của khách hàng" class="w-100 h-100 object-fit-cover" loading="lazy">
                                </a>
                            @endforeach
                        </div>
                    @endif

                    {{-- Lunara Merchant Reply (Phase 20.32 - 20.33) --}}
                    @if($review->admin_reply)
                        <div class="merchant-reply mt-3 p-3 rounded bg-light border-start border-3 border-dark" style="font-size: 0.8125rem;">
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
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $reviews->fragment('reviews')->links() }}
        </div>
    @elseif($ratingSummary['total'] > 0 && $ratingFilter !== null)
        <div class="text-center py-5 border rounded bg-light my-4">
            <i class="bi bi-filter text-muted fs-2 d-block mb-2"></i>
            <p class="text-muted mb-2">Không tìm thấy đánh giá nào với bộ lọc <strong>{{ $ratingFilter }} sao</strong>.</p>
            <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}#reviews" class="btn btn-outline-dark btn-sm">Xem tất cả đánh giá</a>
        </div>
    @endif
</section>
