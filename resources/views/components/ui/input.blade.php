@props([
    'name',
    'id' => null,
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'icon' => null,
    'help' => null,
])

@php
    $inputId = $id ?? $name;
    $hasError = $errors->has($name);
    $inputValue = old($name, $value);
@endphp

<div class="ln-form-group">
    @if($label)
        <label for="{{ $inputId }}" class="ln-label">
            {{ $label }}
            @if($required)
                <span class="ln-label__required" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <div class="ln-input-wrapper {{ $icon ? 'ln-input-wrapper--has-icon' : '' }} {{ $hasError ? 'ln-input-wrapper--error' : '' }}">
        @if($icon)
            <i class="bi {{ $icon }} ln-input-icon" aria-hidden="true"></i>
        @endif
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ $inputValue }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes->merge(['class' => 'ln-input' . ($hasError ? ' is-invalid' : '')]) }}
        >
    </div>

    @if($help && !$hasError)
        <x-ui.field-help :text="$help" />
    @endif

    <x-ui.field-error :name="$name" />
</div>
