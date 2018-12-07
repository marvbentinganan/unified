@extends('layouts.uikit') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>

@endpush 
@section('breadcrumb')
@endsection
 
@section('content')
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-small">
        <div class="uk-width-1-1">
            <div class="uk-article">
                <h1 class="uk-article title">{{ $lesson->title }}</h1>
                <p class="uk-article-meta">Written by: {{ $lesson->created_by->firstname.' '.$lesson->created_by->lastname }}</p>
                <p class="uk-text-lead">{{ $lesson->description }}</p>
                <p class="uk-text-lead">{{ $lesson->objective }}</p>
            </div>
            @foreach ($chapters as $chapter)
            <h3>{{ $chapter->title }}</h3>
            <p>{!! $chapter->content !!}</p>
            @endforeach
            <ul class="uk-pagination uk-flex-center" uk-margin>
                <li><a href="{{ $chapters->previousPageUrl() }}"><span class="uk-margin-small-right" uk-pagination-previous></span> Previous</a></li>
                <li class="uk-margin-auto-left"><a href="{{ $chapters->nextPageUrl() }}">Next <span class="uk-margin-small-left" uk-pagination-next></span></a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script>
$("iframe").wrap("<div class='uk-flex uk-flex-center' />");
</script>
@endpush