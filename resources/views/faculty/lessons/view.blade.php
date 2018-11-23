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
            <a href="{{ route('lessons') }}" class="section">Lessons</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('lesson.view', $lesson->slug) }}" class="active section">{{ $lesson->title }}</a>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable very padded grid">
        <article class="ui raised relaxed divided items piled very padded segment">
            <h1 class="ui header">{{ $lesson->title }}</h1>
            <span><i class="ion-ios-person icon"></i>{{ $lesson->created_by->firstname.' '.$lesson->created_by->lastname }}</span>
            <span><i class="ion-calendar icon"></i>{{ $lesson->created_at->toFormattedDateString() }}</span>
            {{-- Approval --}}
            @if($lesson->for_approval == true)
            <a class="ui orange top right attached label">For Approval</a> 
            @elseif($lesson->active == true)
            <a class="ui green top right attached label">Approved</a> 
            @else
            <a class="ui top right attached label">Pending</a> 
            @endif
            <div class="ui small message">
                <div class="header">
                    Description
                </div>
                <p>{!! $lesson->description !!}</p>
            </div>
            @if($lesson->objective)
            <div class="ui small message">
                <div class="header">
                    Objective
                </div>
                <p>{!! $lesson->objective !!}</p>
            </div>
            @endif
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
            @if(auth()->user()->hasRole('management') && $lesson->active == false)
            <button class="ui green icon button" onclick="publish({{ $lesson->id }})"><i class="check icon"></i> Approve for Publication</button>
            @else
            <button class="ui red icon button" onclick="unpublish({{ $lesson->id }})"><i class="ion-reply icon"></i> Rescind Approval</button>
            @endif
        </article>
    </div>
</div>
@endsection
@push('footer_scripts')
<script>
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