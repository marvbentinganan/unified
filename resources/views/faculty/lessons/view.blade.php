@extends('layouts.app') 
@push('header_scripts')

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
            <a href="{{ route('lessons') }}" class="section">My Lessons</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('lesson.view', $lesson->slug) }}" class="active section">{{ $lesson->title }}</a>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable very padded grid">
        <article class="ui raised relaxed divided items segment">
            <h1 class="ui header">{{ $lesson->title }}</h1>
            @foreach($lesson->chapters as $chapter)
            <section class="item">
                <div class="content">
                    <h3 class="header">{{ $chapter->title }}</h3>
                    <div class="description">
                        {!! $chapter->content !!}
                    </div>
                </div>
            </section>
            @endforeach
        </article>
    </div>
</div>
@endsection
@push('footer_scripts')

@endpush