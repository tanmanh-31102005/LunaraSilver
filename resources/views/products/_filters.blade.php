<div class="listing-categories">
    <h2>Danh mục</h2>
    <a href="{{ route('products.index') }}" @if(! $category) aria-current="page" @endif>Tất cả sản phẩm</a>
    @foreach($categories as $item)
        <a href="{{ route('products.category', $item->slug) }}" @if($category?->id === $item->id) aria-current="page" @endif>{{ $item->name }}</a>
    @endforeach
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
