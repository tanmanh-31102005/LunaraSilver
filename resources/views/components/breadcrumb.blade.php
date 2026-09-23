@props(['items' => []])

<nav aria-label="Đường dẫn trang" {{ $attributes }}>
    <ol class="lunara-breadcrumb">
        <li><a href="{{ route('home') }}">Trang chủ</a></li>
        @foreach($items as $item)
            <li>
                @if(! $loop->last && isset($item['url']))<a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                @else<span @if($loop->last) aria-current="page" @endif>{{ $item['label'] }}</span>@endif
            </li>
        @endforeach
    </ol>
</nav>
