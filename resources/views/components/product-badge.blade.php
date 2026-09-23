@props(['product'])

@if($product->hasValidSalePrice())
    <span {{ $attributes->class(['product-badge']) }}>Sale</span>
@elseif($product->product_type === 'collection')
    <span {{ $attributes->class(['product-badge']) }}>Bộ trang sức</span>
@elseif($product->product_type === 'gift')
    <span {{ $attributes->class(['product-badge']) }}>Quà tặng</span>
@endif
