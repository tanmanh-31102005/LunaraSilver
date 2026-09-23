@props(['href' => null, 'variant' => 'dark'])

@if($href)
    <a href="{{ $href }}" {{ $attributes->class(['lunara-button', 'lunara-button--'.$variant]) }}>{{ $slot }} <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
@else
    <button {{ $attributes->class(['lunara-button', 'lunara-button--'.$variant]) }}>{{ $slot }}</button>
@endif
