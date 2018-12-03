@extends('layouts.app') 
@push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="" class="section">Lesson Manager</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('lessons') }}" class="active section">Lessons</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable grid">
       <div class="column">
            @role('management|faculty')
            <div class="row">
                <div class="ui top attached borderless menu">
                    <div class="header item"><i class="ion-ios-browsers icon"></i>My Lessons</div>
                    <div class="right menu">
                        <a href="{{ route('lesson.new') }}" class="item"><i class="ion-plus icon"></i>Add New</a>
                    </div>
                </div>
                @if($mine != null)
                <div class="ui attached segment">
                    <div class="ui stackable doubling three raised cards">
                        @foreach ($mine as $lesson)
                        <div class="card">
                            <div class="image">
                                <img src="{{ asset('images/books.jpg') }}" alt="">
                                @if($lesson->deleted_at)
                                    <a class="ui red top right attached label">Deleted</a>
                                @else
                                    {{-- Approval --}}
                                    @if($lesson->approved == false)
                                    <a class="ui orange top right attached label">For Approval</a> @else
                                    <a class="ui green top right attached label">Approved</a>@endif
                                    {{-- Chapters --}}
                                    @if($lesson->has('chapters'))
                                    <a href="{{ route('chapter.add', $lesson->code) }}" class="ui blue top left attached label">{{ $lesson->chapters->count() }} @if($lesson->chapters->count() > 1) Chapters @else
                                        Chapter @endif
                                    </a>
                                    @else
                                    <a href="{{ route('chapter.add', $lesson->code) }}" class="ui blue top left attached label"><i class="ion-plus icon"></i> Add Chapter</a>
                                    @endif
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
                                {{-- Show restore Button if Lesson is Deleted --}}
                                @if($lesson->deleted_at)
                                <button class="ui icon button" onclick="restore({{ $lesson->id }})"><i class="yellow ion-refresh icon"></i></button>
                                @else
                                <a href="{{ route('lesson.view', $lesson->code) }}" class="ui icon button"><i class="blue ion-eye icon"></i></a>
                                {{-- Hide Update Button if Lesson is Published --}}
                                @if($lesson->approved == false)
                                <a href="{{ route('lesson.update', $lesson->code) }}" class="ui icon button"><i class="teal ion-compose icon"></i></a>
                                @endif
                                <button class="ui icon button" onclick="destroy({{ $lesson->id }})"><i class="red ion-trash-a icon"></i></button>
                                {{-- Show Publish Button if User is Manager/Area Head --}}
                                @role('management')
                                @if($lesson->approved == false)
                                <button class="ui icon button" onclick="publish({{ $lesson->id }})"><i class="green check icon"></i></button>
                                @elseif($lesson->approved == true)
                                <button class="ui icon button" onclick="unpublish({{ $lesson->id }})"><i class="orange close icon"></i></button>
                                @endif
                                @endrole
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="ui attached secondary placeholder center aligned segment">
                    <div class="ui icon header">
                        <i class="orange ion-alert-circled icon"></i> It looks like you have not created any lessons yet.
                    </div>
                    <div class="ui section divider"></div>
                    <a href="{{ route('lesson.new') }}" class="ui large primary button">Add Lesson</a>
                </div>
                @endif
            </div>
            <div class="ui hidden divider"></div>
            @endrole
            @role('administrator|management')
            <div class="row">
                <div class="ui top attached borderless menu">
                    <div class="header item"><i class="flask icon"></i>All Lessons</div>
                </div>
                @if($all != null)
                <div class="ui attached segment">
                    <div class="ui small divided items">
                        @foreach ($all as $item)
                            <div class="item">
                                <div class="image">
                                    <img src="{{ asset('images/books.jpg') }}" alt="">
                                </div>
                                <div class="content">
                                    <div class="header">{{ $item->title }}</div>
                                    <div class="meta">
                                        <span class="date"><i class="ion-ios-person icon"></i> {{ $item->created_by->firstname.' '.$item->created_by->lastname }}</span>
                                        <span class="date"><i class="ion-calendar icon"></i> {{ $item->created_at->toFormattedDateString() }}</span>
                                        <span class="date"><i class="ion-cube icon"></i> {{ $item->department->name }}</span>
                                        <span class="date"><i class="ion-briefcase icon"></i> {{ $item->program->code }}</span>
                                        <span class="date"><i class="ion-beaker icon"></i>{{ $item->subject->code }}</span>
                                    </div>
                                    <div class="description">
                                        {!! $item->description !!}
                                    </div>
                                    <div class="extra">
                                        {{-- Show restore Button if Lesson is Deleted --}} @if($item->deleted_at)
                                        <button class="ui icon button" onclick="restore({{ $item->id }})"><i class="yellow ion-refresh icon"></i></button>    @else
                                        <a href="{{ route('lesson.view', $item->code) }}" class="ui icon button"><i class="blue ion-eye icon"></i></a>    {{-- Hide Update Button if item is Published --}} @if($item->approved == false)
                                        <a href="{{ route('lesson.update', $item->code) }}" class="ui icon button"><i class="teal ion-compose icon"></i></a>    @endif
                                        <button class="ui icon button" onclick="destroy({{ $item->id }})"><i class="red ion-trash-a icon"></i></button> {{--
                                        Show Publish Button if User is Manager/Area Head --}} @role('management') @if($item->approved == false)
                                        <button class="ui icon button" onclick="publish({{ $item->id }})"><i class="green check icon"></i></button> @elseif($item->approved
                                        == true)
                                        <button class="ui icon button" onclick="unpublish({{ $item->id }})"><i class="orange close icon"></i></button> @endif
                                        @endrole @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="ui attached secondary placeholder center aligned segment">
                    <div class="ui icon header">
                        <i class="orange ion-alert-circled icon"></i> It looks like you have not created any lessons yet.
                    </div>
                    <div class="ui section divider"></div>
                    <a href="{{ route('lesson.new') }}" class="ui large primary button">Add Lesson</a>
                </div>
                @endif
            </div>
            @endrole
       </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script>
    function destroy(lesson){
        swal({ 
            title: 'Are you sure?', 
            text: "This Lesson will be Deleted", 
            type: 'question', 
            showCancelButton: true, 
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33', 
            confirmButtonText: 'Yes' 
            })
            .then((result) => { 
                if (result.value) { 
                    var route = '{{ url('lessons/delete') }}' + '/' + lesson; 
                    axios.get(route) 
                    .then(response => { 
                        swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
                        }, 1500);
                    })
            .catch(response => { 
                swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
                }, 1500);
            }); 
        } }) 
    }

    function restore(lesson){
        swal({ 
            title: 'Are you sure?', 
            text: "This Lesson will be Restored", 
            type: 'question', 
            showCancelButton: true, 
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33', 
            confirmButtonText: 'Yes' 
            })
            .then((result) => { 
                if (result.value) { 
                    var route = '{{ url('lessons/restore') }}' + '/' + lesson; 
                    axios.get(route) 
                    .then(response => { 
                        swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
                        }, 1500);
                    })
            .catch(response => { 
                swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
                }, 1500);
            }); 
        } }) 
    }

    function publish(lesson){
        swal({ 
            title: 'Are you sure?', 
            text: "This Lesson will be Published", 
            type: 'question', 
            showCancelButton: true, 
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33', 
            confirmButtonText: 'Yes' 
            })
            .then((result) => { 
                if (result.value) { 
                    var route = '{{ url('lessons/approve') }}' + '/' + lesson; 
                    axios.get(route) 
                    .then(response => { 
                        swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
                        }, 1500);
                    })
            .catch(response => { 
                swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
                }, 1500);
            }); 
        } }) 
    }

    function unpublish(lesson){
        swal({ 
            title: 'Are you sure?', 
            text: "This Lesson will be Unpublished", 
            type: 'question', 
            showCancelButton: true, 
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33', 
            confirmButtonText: 'Yes' 
            })
            .then((result) => { 
                if (result.value) { 
                    var route = '{{ url('lessons/disapprove') }}' + '/' + lesson; 
                    axios.get(route) 
                    .then(response => { 
                        swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
                        }, 1500);
                    })
            .catch(response => { 
                swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 }), setTimeout(function(){ location.reload();
                }, 1500);
            }); 
        } }) 
    }
</script>
@endpush
