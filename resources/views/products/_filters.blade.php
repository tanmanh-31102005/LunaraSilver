<div class="listing-categories">
    <h2>Danh mục trang sức bạc</h2>
    <a href="{{ route('products.index') }}" @if(! $category) aria-current="page" @endif>Tất cả sản phẩm bạc</a>
    @foreach($categories as $item)
        <a href="{{ route('products.category', $item->slug) }}" @if($category?->id === $item->id) aria-current="page" @endif>{{ $item->seo_display_name ?? $item->name }}</a>
    @endforeach

    <div class="listing-keywords-cloud mt-3 pt-2 border-top">
        <span class="d-block small text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Từ khóa tìm kiếm nổi bật</span>
        <div class="d-flex flex-wrap gap-1">
            <a href="{{ route('products.category', 'day-chuyen') }}" class="badge rounded-pill bg-light text-dark border text-decoration-none py-1 px-2" style="font-size: 0.75rem; font-weight: normal;">#dây chuyền bạc nữ</a>
            <a href="{{ route('products.category', 'nhan') }}" class="badge rounded-pill bg-light text-dark border text-decoration-none py-1 px-2" style="font-size: 0.75rem; font-weight: normal;">#nhẫn bạc 925</a>
            <a href="{{ route('products.category', 'nhan') }}" class="badge rounded-pill bg-light text-dark border text-decoration-none py-1 px-2" style="font-size: 0.75rem; font-weight: normal;">#nhẫn bạc đôi</a>
            <a href="{{ route('products.category', 'vong-tay') }}" class="badge rounded-pill bg-light text-dark border text-decoration-none py-1 px-2" style="font-size: 0.75rem; font-weight: normal;">#vòng tay bạc nữ đẹp</a>
            <a href="{{ route('products.category', 'vong-tay') }}" class="badge rounded-pill bg-light text-dark border text-decoration-none py-1 px-2" style="font-size: 0.75rem; font-weight: normal;">#lắc tay bạc</a>
            <a href="{{ route('products.index', ['q' => 'lắc chân bạc nữ']) }}" class="badge rounded-pill bg-light text-dark border text-decoration-none py-1 px-2" style="font-size: 0.75rem; font-weight: normal;">#lắc chân bạc nữ</a>
            <a href="{{ route('products.index', ['q' => 'trang sức bạc nam']) }}" class="badge rounded-pill bg-light text-dark border text-decoration-none py-1 px-2" style="font-size: 0.75rem; font-weight: normal;">#trang sức bạc nam</a>
        </div>
    </div>
</div>
<form action="{{ $baseRoute }}" method="get" class="listing-filter-form">
    <h2>Bộ lọc</h2>
    <div>
        <label for="{{ $prefix }}-q">Tìm kiếm</label>
        <input id="{{ $prefix }}-q" class="form-control" type="search" name="q" value="{{ $filters['q'] }}" placeholder="Tên, SKU, mô tả">
    </div>
    <div class="listing-price-fields">
        <div><label for="{{ $prefix }}-min">Giá từ</label><input id="{{ $prefix }}-min" class="form-control" type="number" min="0" step="1" name="min_price" value="{{ $filters['min_price'] }}" placeholder="₫"></div>
        <div><label for="{{ $prefix }}-max">Đến</label><input id="{{ $prefix }}-max" class="form-control" type="number" min="0" step="1" name="max_price" value="{{ $filters['max_price'] }}" placeholder="₫"></div>
    </div>
    <div>
        <label for="{{ $prefix }}-material">Chất liệu</label>
        <select id="{{ $prefix }}-material" class="form-select" name="material">
            <option value="">Tất cả</option>
            @foreach($materials as $material)<option value="{{ $material }}" @selected($filters['material'] === $material)>{{ $material }}</option>@endforeach
        </select>
    </div>
    <div>
        <label for="{{ $prefix }}-stone">Đá</label>
        <select id="{{ $prefix }}-stone" class="form-select" name="stone">
            <option value="">Tất cả</option>
            @foreach($stones as $stone)<option value="{{ $stone }}" @selected($filters['stone'] === $stone)>{{ $stone }}</option>@endforeach
        </select>
    </div>
    <div>
        <label for="{{ $prefix }}-type">Loại sản phẩm</label>
        <select id="{{ $prefix }}-type" class="form-select" name="type">
            <option value="">Tất cả</option>
            <option value="single" @selected($filters['type'] === 'single')>Sản phẩm lẻ</option>
            <option value="collection" @selected($filters['type'] === 'collection')>Bộ trang sức</option>
            <option value="gift" @selected($filters['type'] === 'gift')>Set quà tặng</option>
        </select>
    </div>
    <input type="hidden" name="sort" value="{{ $sort }}">
    <button class="btn btn-dark w-100" type="submit">Áp dụng bộ lọc</button>
    <a class="listing-clear" href="{{ route('products.index') }}">Xóa bộ lọc</a>
</form>
