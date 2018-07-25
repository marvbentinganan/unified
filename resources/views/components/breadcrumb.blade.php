<div class="ui {{ $modifiers }} breadcrumb">
    @foreach($links as $link)
    <a href="{{ $link->url }}" class="section">{{ $link->title }}</a>
    <div class="divider">{{ $separator }}</div>
    @endforeach
</div>
