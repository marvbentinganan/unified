<article class="ui segment">
    <div class="ui huge header">{{ $lesson->title }}</div>
    <p>{!! $lesson->description !!}</p>
    @if($lesson->has('chapters'))
    <div class="ui relaxed divided items">
        @foreach($lesson->chapters->sortBy('created_at') as $key => $chapter)
        <div class="item">
            <div class="content">
                <div class="header">{{  $chapter->title }}</div>
                <div class="meta">
                    <span class="date"><i class="ion-calendar icon"></i> {{ $chapter->created_at->toFormattedDateString() }}</span>
                </div>
                <div class="description">
                    {!! $chapter->content !!}
                </div>
                <div class="extra">
                    <a href="{{ route('chapter.update', [$lesson->slug, $chapter->id]) }}" class="ui mini teal icon button"><i class="ion-compose icon"></i> Update</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</article>