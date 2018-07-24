<div class="ui {{ $modifiers }} divider">
    @foreach($links as $link)
    <a href="{{ $link->url }}" class="section">{{ $link->title }}</a>
    <div class="divider">{{ $separator }}</div>
    @endforeach
</div>
