@props(['product'])

@php
    $formatVnd = static function ($value): string {
        [$whole, $fraction] = array_pad(explode('.', (string) $value, 2), 2, '00');
        return number_format((int) $whole, 0, ',', '.').($fraction !== '00' ? ','.$fraction : '').' ₫';
    };
@endphp

<span {{ $attributes->class(['product-price']) }}>
    @if($product->hasValidSalePrice())
        <span class="product-price__current">{{ $formatVnd($product->sale_price) }}</span>
        <del class="product-price__regular">{{ $formatVnd($product->regular_price) }}</del>
    @else
        <span class="product-price__current">{{ $formatVnd($product->regular_price) }}</span>
    @endif
</span>
