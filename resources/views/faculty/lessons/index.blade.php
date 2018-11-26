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
                            @if($lesson->deleted_at)
                                <a class="ui red top right attached label">Deleted</a>
                            @else
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
                            @if($lesson->deleted_at)
                            <button class="ui icon button" onclick="restore({{ $lesson->id }})"><i class="yellow ion-refresh icon"></i></button>
                            @else
                            <a href="{{ route('lesson.view', $lesson->slug) }}" class="ui icon button"><i class="blue ion-ios-browsers icon"></i></a>
                            <a href="{{ route('lesson.update', $lesson->slug) }}" class="ui icon button"><i class="teal ion-compose icon"></i></a>
                            <button class="ui icon button" onclick="destroy({{ $lesson->id }})"><i class="red ion-trash-a icon"></i></button>
                            @if(auth()->user()->hasRole('management') && $lesson->active == false)
                            <button class="ui icon button" onclick="publish({{ $lesson->id }})"><i class="green check icon"></i></button>
                            @endif
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
</script>
@endpush
