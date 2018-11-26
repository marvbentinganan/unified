<div class="ui attached relaxed divided items segment">
    @foreach($lessons as $lesson)
    <div class="item">
        <div class="content">
            <div class="header">{{ $lesson->title }}</div>
            <div class="meta">
                <span class="date">
                    <i class="ion-calendar icon"></i> {{ $lesson->created_at->toFormattedDateString() }}
                </span>
                <span class="date">
                    <i class="ion-clock icon"></i> {{ $lesson->created_at->diffForHumans() }}
                </span>
            </div>
            <div class="description">
                {!! $lesson->description !!}
            </div>
            <div class="extra">
                <a href="{{ route('chapter.add', $lesson->slug) }}" class="ui right floated primary icon button"><i class="ion-plus icon"></i> Add Chapter</a>
                <div class="ui label"><i class="ion-cube icon"></i>{{ $lesson->department->name }}</div>
                <div class="ui label"><i class="ion-briefcase icon"></i>{{ $lesson->program->name }}</div>
                <div class="ui label"><i class="ion-beaker icon"></i>{{ $lesson->subject->code }}</div>
                @if($lesson->has('chapters'))
                <div class="ui label"><i class="ion-ios-browsers icon"></i>
                    {{ $lesson->chapters->count() }}
                    @if($lesson->chapters->count() > 1)
                    Chapters
                    @else
                    Chapter
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>