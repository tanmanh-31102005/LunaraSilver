@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => null,
    'rows' => 3,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'help' => null,
])

@php
    $textareaId = $id ?? $name;
    $hasError = $errors->has($name);
    $textareaValue = old($name, $value ?? $slot);
@endphp

<div class="ln-form-group">
    @if($label)
        <label for="{{ $textareaId }}" class="ln-label">
            {{ $label }}
            @if($required)
                <span class="ln-label__required" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <div class="ln-textarea-wrapper {{ $hasError ? 'ln-textarea-wrapper--error' : '' }}">
        <textarea
            name="{{ $name }}"
            id="{{ $textareaId }}"
            rows="{{ $rows }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes->merge(['class' => 'ln-textarea' . ($hasError ? ' is-invalid' : '')]) }}
        >{{ $textareaValue }}</textarea>
    </div>

    @if($help && !$hasError)
        <x-ui.field-help :text="$help" />
    @endif

    <x-ui.field-error :name="$name" />
</div>
