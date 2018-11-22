@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>


@endpush
@section('content')
<div class="sixteen wide column">
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="ui breadcrumb segment">
            <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="" class="section">Lesson Manager</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('lessons') }}" class="active section">My Lessons</a>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable very padded grid">
       <div class="column">
            <div class="ui top attached borderless menu">
                <div class="header item"><i class="ion-ios-browsers icon"></i>My Lessons</div>
                <div class="right menu">
                    <a href="{{ route('lesson.new') }}" class="item"><i class="ion-plus icon"></i>Add New</a>
                </div>
            </div>
            <div class="ui attached segment">
                <div class="ui stackable doubling three raised cards">
                    @foreach ($lessons as $lesson)
                    <div class="card">
                        <div class="image">
                            <img src="{{ asset('images/books.jpg') }}" alt="">
                            {{-- Approval --}}
                            @if($lesson->for_approval == true)
                            <a class="ui orange top right attached label">For Approval</a> @elseif($lesson->active == true)
                            <a class="ui green top right attached label">Approved</a> @else
                            <a class="ui top right attached label">Pending</a> @endif
                            {{-- Chapters --}}
                            @if($lesson->has('chapters'))
                            <a href="{{ route('chapter.add', $lesson->slug) }}" class="ui blue top left attached label">{{ $lesson->chapters->count() }} @if($lesson->chapters->count() > 1) Chapters @else
                                Chapter @endif
                            </a>
                            @else
                            <a href="{{ route('chapter.add', $lesson->slug) }}" class="ui blue top left attached label"><i class="ion-plus icon"></i> Add Chapter</a>
                            @endif
                        </div>
                        <div class="content">
                            <div class="header">{{ $lesson->title }}</div>
                            <div class="meta">
                                <span class="date"><i class="ion-ios-person icon"></i> {{ $lesson->created_by->firstname.' '.$lesson->created_by->lastname }}</span>
                                <span class="date"><i class="ion-calendar icon"></i> {{ $lesson->created_at->toFormattedDateString() }}</span>
                            </div>
                            <div class="description">
                                <div class="ui label">{{ $lesson->department->name }}</div>
                                <div class="ui label">{{ $lesson->program->code }}</div>
                                <div class="ui label">{{ $lesson->subject->code }}</div>
                                {{-- {!! $lesson->description !!} --}}
                            </div>
                        </div>
                        <div class="ui attached basic buttons">
                            <a href="{{ route('lesson.view', $lesson->slug) }}" class="ui icon button"><i class="blue ion-ios-browsers icon"></i></a>
                            <a href="{{ route('lesson.update', $lesson->slug) }}" class="ui icon button"><i class="teal ion-compose icon"></i></a>
                            <a href="" class="ui icon button"><i class="red ion-trash-a icon"></i></a>
                            @if(auth()->user()->hasRole('management') && $lesson->active == false)
                            <a href="" class="ui icon button"><i class="green check icon"></i></a>
                            @endif
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
       </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>

@endpush
