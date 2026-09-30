@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'iconPosition' => 'left',
])

@php
    $variantClass = match($variant) {
        'secondary' => 'ln-btn--secondary',
        'ghost' => 'ln-btn--ghost',
        'danger' => 'ln-btn--danger',
        'icon' => 'ln-btn--icon',
        default => 'ln-btn--primary',
    };

    $sizeClass = match($size) {
        'sm' => 'ln-btn--sm',
        'lg' => 'ln-btn--lg',
        default => 'ln-btn--md',
    };

    $classes = "ln-btn {$variantClass} {$sizeClass}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <i class="bi {{ $icon }} ln-btn__icon ln-btn__icon--left" aria-hidden="true"></i>
        @endif
        <span class="ln-btn__text">{{ $slot }}</span>
        @if($icon && $iconPosition === 'right')
            <i class="bi {{ $icon }} ln-btn__icon ln-btn__icon--right" aria-hidden="true"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <i class="bi {{ $icon }} ln-btn__icon ln-btn__icon--left" aria-hidden="true"></i>
        @endif
        @if(trim($slot))
            <span class="ln-btn__text">{{ $slot }}</span>
        @endif
        @if($icon && $iconPosition === 'right')
            <i class="bi {{ $icon }} ln-btn__icon ln-btn__icon--right" aria-hidden="true"></i>
        @endif
    </button>
@endif
