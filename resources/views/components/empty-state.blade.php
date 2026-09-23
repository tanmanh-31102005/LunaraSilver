@props(['title' => 'Chưa có sản phẩm', 'message' => null])

<div {{ $attributes->class(['empty-state']) }}>
    <i class="bi bi-stars" aria-hidden="true"></i>
    <h3>{{ $title }}</h3>
    @if($message)<p>{{ $message }}</p>@endif
</div>
