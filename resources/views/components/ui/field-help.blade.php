@props(['text' => null])

<p {{ $attributes->merge(['class' => 'ln-field-help']) }}>
    {{ $text ?: $slot }}
</p>
