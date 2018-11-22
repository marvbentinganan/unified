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
            <a href="{{ route('lessons') }}" class="section">My Lessons</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="" class="section">{{ $lesson->title }}</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('chapter.add', $lesson->slug) }}" class="active section">New Chapter</a>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable very padded grid">
        <div class="sixteen wide column">
            <div class="ui secondary pointing two item tabular menu">
                <a class="item active" data-tab="add"><i class="ion-plus icon"></i> Form</a>
                <a class="item" data-tab="preview"><i class="eye icon"></i> Preview</a>
            </div>

            <div class="ui bottom attached tab active" data-tab="add">
                    {{-- Add Chapter Form --}}
                <div class="ui gray inverted top attached header"><i class="ion-plus icon"></i> Add New Chapter</div>
                <div class="ui attached segment">
                    <form action="{{ route('chapter.add', $lesson->slug) }}" method="POST" id="chapter-form" class="ui form">
                        @csrf
                        <div class="field">
                            <label for="">Title</label>
                            <div class="ui left icon input">
                                <input type="text" name="title" id="" placeholder="Title..." value="{{ old('title') }}">
                                <i class="ion-pricetag icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <textarea name="content" rows="30">
                                {!! old('content') !!}
                            </textarea>
                        </div>
                        <div class="field">
                            <button class="ui animated fade primary icon button">
                                <div class="visible content">Add Chapter</div>
                                <div class="hidden content"><i class="ion-plus icon"></i></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Preview --}}
            <div class="ui bottom attached tab" data-tab="preview">
               <div id="chapters-container"></div>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/jquery.address.js') }}"></script>
<script>
    getChapters();

    $('#chapter-form').submit(function(event){
		event.preventDefault();
		tinyMCE.triggerSave();
		var route = '{{ route('chapter.add', $lesson->slug) }}';
		var data = $('#chapter-form').serialize();
		axios.post(route, data)
		.then(response => {
			toastr.success(response.data),
			$('form').form('clear'),
            tinyMCE.get('content').setContent(''),
            getChapters({{ $lesson->slug }});
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
				title : '{{ config('app.name') }}',
				width : x * 0.9,
				height : y * 0.9,
				resizable : "yes",
				close_previous : "no"
			});
		}
	};
	
	tinymce.init(editor_config);

    function getChapters(lesson){
        axios.get('{{ route('chapters.list', $lesson->slug) }}')
		.then(response => {
			$('#chapters-container').html(response.data);
		});
	};

    $('.tabular.menu .item').tab({history:true, alwaysRefresh:false});
</script>

@endpush