@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $radioId = $id ?? ($name . '_' . preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$value));
    $isChecked = old($name, $checked ? $value : null) == $value;
@endphp

<label class="ln-radio-container" for="{{ $radioId }}">
    <input
        type="radio"
        name="{{ $name }}"
        id="{{ $radioId }}"
        value="{{ $value }}"
        @if($isChecked) checked @endif
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => 'ln-radio']) }}
    >
    <span class="ln-radio-custom" aria-hidden="true"></span>
    <span class="ln-radio-label">
        {{ $label ?: $slot }}
    </span>
</label>
