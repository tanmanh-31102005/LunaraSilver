@props([
    'name',
    'id' => null,
    'label' => null,
    'required' => false,
    'disabled' => false,
    'help' => null,
])

@php
    $selectId = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<div class="ln-form-group">
    @if($label)
        <label for="{{ $selectId }}" class="ln-label">
            {{ $label }}
            @if($required)
                <span class="ln-label__required" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <div class="ln-select-wrapper {{ $hasError ? 'ln-select-wrapper--error' : '' }}">
        <select
            name="{{ $name }}"
            id="{{ $selectId }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            {{ $attributes->merge(['class' => 'ln-select' . ($hasError ? ' is-invalid' : '')]) }}
        >
            {{ $slot }}
        </select>
        <i class="bi bi-chevron-down ln-select-chevron" aria-hidden="true"></i>
    </div>

    @if($help && !$hasError)
        <x-ui.field-help :text="$help" />
    @endif

    <x-ui.field-error :name="$name" />
</div>
