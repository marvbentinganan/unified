@extends('layouts.uikit') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>

@endpush 
@section('breadcrumb')
@endsection

@section('content')
<div class="uk-container uk-padding uk-flex-center" uk-grid>
    <div class="uk-grid-medium uk-child-width-expand@s" uk-grid="masonry: true">
        <div class="uk-width-3-4@m">
            <h3 class="uk-heading-divider">Available Lessons</h3>
            <div class="uk-container">
                @foreach ($myclass->lessons as $lesson)
                <div>
                <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@m uk-margin" uk-grid>
                    <a class="uk-card-media-left uk-cover-container">
                        <img src="{{ asset('images/books.jpg') }}" alt="" uk-cover>
                        <canvas width="200" height="400"></canvas>
                    </a>
                    <div>
                        <div class="uk-card-body">
                            <div class="uk-article">
                                <h4 class="uk-article-title"><a href="{{ route('student.lesson.read', $lesson->code) }}">{{ $lesson->title }}</a></h4>
                                <p class="uk-article-meta">Written by: {{ $lesson->created_by->firstname.' '.$lesson->created_by->lastname }}</p>
                                <p class="uk-text-lead">{{ $lesson->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                @endforeach
                
            </div>
        </div>
        <div class="uk-width-1-4@m">
            <h3 class="uk-heading-divider">Quizzes</h3>
            
            <h3 class="uk-heading-divider">Homework</h3>

            <h3 class="uk-heading-divider">Projects</h3>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts')


@endpush