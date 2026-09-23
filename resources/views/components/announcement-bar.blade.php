@props(['message' => null])

@if(filled($message))
    <div class="announcement-bar" role="status">{{ $message }}</div>
@endif
