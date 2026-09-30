@props(['name'])

@error($name)
    <p {{ $attributes->merge(['class' => 'ln-field-error']) }} role="alert">
        <i class="bi bi-exclamation-circle-fill" aria-hidden="true"></i>
        <span>{{ $message }}</span>
    </p>
@enderror
