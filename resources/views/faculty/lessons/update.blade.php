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
            <a href="{{ route('lessons') }}" class="section">Lessons</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('lesson.view', $lesson->slug) }}" class="section">{{ $lesson->title }}</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('lesson.update', $lesson->slug) }}" class="active section">Update</a>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable very padded two column grid">
        <div class="ten wide column">
            <div class="ui gray inverted top attached header"><i class="ion-plus icon"></i> Update {{ $lesson->title }}</div>
            <div class="ui attached segment">
                <form action="{{ route('lesson.update', $lesson->slug) }}" method="POST" id="lesson-form" class="ui form">
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
                            {!! $lesson->description !!}
                        </textarea>
                    </div>
                    <div class="field">
                        <label for="">Objective</label>
                        <textarea name="objective">
                            {!! $lesson->objective !!}
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
            <div class="ui gray inverted top attached header"><i class="ion-ios-browsers icon"></i> My Lessons</div>
            <div id="lesson-container"></div>
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')
<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script>
    getLessons();
    $('#lesson-form').submit(function(event){
		event.preventDefault();
		tinyMCE.triggerSave();
		var route = '{{ route('lesson.add') }}';
		var data = $('#lesson-form').serialize();
		axios.post(route, data)
		.then(response => {
			toastr.success(response.data),
            getLessons();
		})
		.catch(response => {
			console.log(response.data);
		});
	});

    var editor_config = {
		path_absolute : "{{ url('/') }}" + '/',
		selector: "textarea",
		plugins: [
		"advlist autolink lists link image charmap print preview hr anchor pagebreak",
		"searchreplace wordcount visualblocks visualchars code fullscreen",
		"insertdatetime media nonbreaking save table contextmenu directionality",
		"emoticons template paste textcolor colorpicker textpattern"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
		relative_urls: false,
		file_browser_callback : function(field_name, url, type, win) {
			var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
			var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

			var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
			if (type == 'image') {
				cmsURL = cmsURL + "&type=Images";
			} else {
				cmsURL = cmsURL + "&type=Files";
			}

			tinyMCE.activeEditor.windowManager.open({
				file : cmsURL,
				title : 'Website Filemanager',
				width : x * 0.9,
				height : y * 0.9,
				resizable : "yes",
				close_previous : "no"
			});
		}
	};

	tinymce.init(editor_config);

    function getLessons(){
        axios.get('{{ route('lessons.list') }}')
		.then(response => {
			$('#lesson-container').html(response.data);
		});
	};

</script>

@endpush
