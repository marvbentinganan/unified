<article class="ui segment">
    <div class="ui huge header">{{ $lesson->title }}</div>
    <p>{!! $lesson->description !!}</p>
    @if($lesson->has('chapters'))
    <div class="ui relaxed divided items">
        @foreach($lesson->chapters as $key => $chapter)
        <div class="item">
            <div class="content">
                <div class="header">Chapter {{++$key.' - '.$chapter->title }}</div>
                <div class="meta">
                    <span class="date"><i class="ion-calendar icon"></i> {{ $chapter->created_at->toFormattedDateString() }}</span>
                </div>
                <div class="description">
                    {!! $chapter->content !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</article>