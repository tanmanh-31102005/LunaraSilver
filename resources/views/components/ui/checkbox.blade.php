@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'help' => null,
])

@php
    $checkboxId = $id ?? $name;
    $hasError = $errors->has($name);
    $isChecked = old($name) !== null ? (bool) old($name) : $checked;
@endphp

<div class="ln-check-group">
    <label class="ln-checkbox-container" for="{{ $checkboxId }}">
        <input
            type="checkbox"
            name="{{ $name }}"
            id="{{ $checkboxId }}"
            value="{{ $value }}"
            @if($isChecked) checked @endif
            @if($disabled) disabled @endif
            {{ $attributes->merge(['class' => 'ln-checkbox' . ($hasError ? ' is-invalid' : '')]) }}
        >
        <span class="ln-checkbox-custom" aria-hidden="true">
            <i class="bi bi-check ln-checkbox-check-icon"></i>
        </span>
        <span class="ln-checkbox-label">
            {{ $label ?: $slot }}
        </span>
    </label>

    @if($help && !$hasError)
        <x-ui.field-help :text="$help" />
    @endif

    <x-ui.field-error :name="$name" />
</div>
