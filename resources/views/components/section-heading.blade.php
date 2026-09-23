@props(['eyebrow' => null, 'title', 'description' => null])

<div {{ $attributes->except('id')->class(['section-heading']) }}>
    @if($eyebrow)<p class="eyebrow">{{ $eyebrow }}</p>@endif
    <h2 @if($attributes->get('id')) id="{{ $attributes->get('id') }}" @endif>{{ $title }}</h2>
    @if($description)<p class="section-heading__description">{{ $description }}</p>@endif
</div>
