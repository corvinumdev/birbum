<div class="breadcrumbs mb-6">
    <ul>
        @foreach ($links as $link)
            @if (isset($link['url']))
                <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
            @else
                <li class="text-primary">{{ $link['label'] }}</li>
            @endif
        @endforeach
    </ul>
</div>
