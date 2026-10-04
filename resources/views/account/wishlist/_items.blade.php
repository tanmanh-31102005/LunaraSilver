<div class="wishlist-container">
    @if($products->isEmpty())
        <div class="card border-0 shadow-sm rounded-3 p-5 text-center bg-white my-3">
            <div class="mb-3">
                <i class="bi bi-heart text-muted" style="font-size: 3rem;"></i>
            </div>
            <h2 class="h5 font-serif text-dark mb-2">Danh sách yêu thích đang trống</h2>
            <p class="text-muted small mb-4 mx-auto" style="max-width: 420px;">
                Lưu lại những thiết kế bạn muốn xem sau bằng cách nhấn vào biểu tượng trái tim trên từng sản phẩm.
            </p>
            <div>
                <a href="{{ route('products.index') }}" class="lunara-button lunara-button--dark px-4 py-2">
                    <i class="bi bi-gem me-1"></i> Khám phá sản phẩm
                </a>
            </div>
        </div>
    @else
        <div class="row g-3 g-md-4" id="wishlistGrid">
            @foreach($products as $product)
                @php
                    $primary = $product->images->firstWhere('image_role', 'primary') ?: $product->images->first();
                    $inStock = $product->isInStock();
                @endphp
                <div class="col-12 col-sm-6 col-md-4 col-xl-4 wishlist-item-col" id="wishlist-card-{{ $product->id }}">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden wishlist-card">
                        <div class="position-relative bg-light text-center ratio ratio-1x1">
                            @if($primary)
                                <img src="{{ $primary->displayUrl() }}" alt="{{ $product->name }}" class="object-fit-cover w-100 h-100" loading="lazy">
                            @else
                                <div class="d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image" style="font-size: 2rem;"></i></div>
                            @endif
                            <button type="button"
                                    class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm wishlist-remove-btn"
                                    data-wishlist-remove="{{ $product->id }}"
                                    title="Xóa khỏi yêu thích"
                                    aria-label="Xóa {{ $product->name }} khỏi yêu thích"
                                    style="width: 32px; height: 32px; padding: 0; line-height: 1;">
                                <i class="bi bi-x-lg text-danger"></i>
                            </button>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <span class="text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.05em;">{{ $product->category?->name ?? 'Trang sức' }}</span>
                            <h3 class="h6 font-serif mb-1 text-truncate" title="{{ $product->name }}">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                            </h3>
                            <div class="mb-2">
                                <x-price :product="$product" />
                            </div>
                            <div class="mb-3">
                                @if(! $product->is_active)
                                    <span class="badge bg-secondary-subtle text-secondary small">Sản phẩm không còn kinh doanh</span>
                                @elseif($inStock)
                                    <span class="badge bg-success-subtle text-success small"><i class="bi bi-check2 me-1"></i>Còn hàng</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger small"><i class="bi bi-clock me-1"></i>Tạm hết hàng</span>
                                @endif
                            </div>
                            <div class="mt-auto d-grid gap-2">
                                @if($product->is_active && $inStock)
                                    <button type="button" class="btn btn-sm btn-dark" data-quick-add="{{ $product->id }}">
                                        <i class="bi bi-bag-plus me-1"></i> Thêm vào giỏ
                                    </button>
                                @endif
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-secondary">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
