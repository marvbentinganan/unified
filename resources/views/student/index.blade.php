@extends('layouts.uikit') 
@push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>

@endpush 
@section('breadcrumb')

@endsection
 
@section('content')
<div class="uk-section">
    <div class="uk-container">
        <h1 class="uk-heading-divider">My Classes</h1>
        <div class="uk-child-width-1-3@m" uk-grid>
            @foreach($student->classes as $class)
            <div>
                <div class="uk-card uk-card-small uk-card-default uk-card-hover uk-animation-scale-up">
                    <a class="uk-card-media-top">
                        <img src="{{ asset('images/students.jpg') }}" alt="">
                    </a>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title">{{ $class->name }}</h3>
                        <p>
                            <span class="uk-label">{{ $class->code }}</span>
                            <span class="uk-label">{{ $class->program->code }}</span>
                            <span class="uk-label">{{ $class->subject->name }}</span>
                        </p>
                    </div>
                    {{-- <div class="uk-card-footer">
                        <a href="" class="uk-button uk-button-default uk-width-1-1">Open</a>
                    </div> --}}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection