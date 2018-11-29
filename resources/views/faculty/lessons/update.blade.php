@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="" class="section">Lesson Manager</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('lessons') }}" class="section">Lessons</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('lesson.view', $lesson->code) }}" class="section">{{ $lesson->title }}</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('lesson.update', $lesson->code) }}" class="active section">Update</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable two column grid">
        <div class="ten wide column">
            <div class="ui gray inverted top attached header"><i class="ion-plus icon"></i> Update {{ $lesson->title }}</div>
            <div class="ui attached segment">
                <form action="{{ route('lesson.update', $lesson->code) }}" method="POST" id="lesson-form" class="ui form">
                    @csrf
                    <div class="field">
                        <label for="">Title</label>
                        <div class="ui left icon input">
                            <input type="text" name="title" id="" placeholder="Title..." value="{{ $lesson->title }}">
                            <i class="ion-pricetag icon"></i>
                        </div>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label for="">Department</label> {!! SemanticForm::select('department_id', $departments, $lesson->department_id)->placeholder('Select
                            Department...') !!}
                        </div>
                        <div class="field">
                            <label for="">Course / Strand</label> {!! SemanticForm::select('program_id', $programs, $lesson->program_id)->placeholder('Select
                            Course / Strand...') !!}
                        </div>
                        <div class="field">
                            <label for="">Subject</label> {!! SemanticForm::select('subject_id', $subjects, $lesson->subject_id)->placeholder('Select
                            Subject...') !!}
                        </div>
                    </div>
                    <div class="field">
                        <label for="">Description</label>
                        <textarea name="description">
                            {{ $lesson->description }}
                        </textarea>
                    </div>
                    <div class="field">
                        <label for="">Objective</label>
                        <textarea name="objective">
                            {{ $lesson->objective }}
                        </textarea>
                    </div>
                    <div class="field">
                        <button class="ui animated fade primary icon button">
                            <div class="visible content">Update Lesson</div>
                            <div class="hidden content"><i class="loading ion-loop icon"></i></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="six wide column">
            <div class="ui gray inverted top attached header"><i class="ion-ios-browsers icon"></i> Chapters</div>
            <div class="ui attached relaxed divided items segment">
                @if($lesson->chapters->count() != 0)
                @foreach($lesson->chapters as $chapter)
                <div class="item">
                    <div class="content">
                        <div class="header">{{ $chapter->title }}</div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="item">
                    <div class="content">
                        <div class="header">No Chapters Available</div>
                        <div class="extra">
                            <a href="{{ route('chapter.add', $lesson->code) }}" class="ui fade fluid primary animated icon button">
                                <div class="visible content">Add Chapter</div>
                                <div class="hidden content"><i class="ion-plus icon"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')
<script>
    $('#lesson-form').submit(function(event){
		event.preventDefault();
		var route = '{{ route('lesson.update', $lesson->code) }}';
		var data = $('#lesson-form').serialize();
		axios.post(route, data)
		.then(response => {
			swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
            }, 1500);
		})
		.catch(response => {
            console.log(response.data);
            swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
            }, 1500);
		});
	});
</script>
@endpush
