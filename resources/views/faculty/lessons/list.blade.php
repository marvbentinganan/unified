<div class="ui relaxed divided items segment">
    @foreach($lessons as $lesson)
    <div class="item">
        <div class="content">
            <div class="header">{{ $lesson->title }}</div>
            <div class="meta">
                <span class="date"><i class="ion-clock icon"></i> {{ $lesson->created_at->diffForHumans() }}</span>
            </div>
            <div class="description">
                {!! $lesson->description !!}
            </div>
        </div>
    </div>
    @endforeach
</div>