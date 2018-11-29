@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="" class="section">Class Manager</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('my.classes') }}" class="section">My Classes</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('class.view', $class->code) }}" class="active section">{{ $class->name }}</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable two column grid">
        <div class="eleven wide column">
            <div class="ui top attached gray inverted header">
                <i class="ion-ios-list icon"></i> Class List
            </div>
            <table class="ui attached small unstackable table">
                <thead>
                    <th class="one wide center aligned">#</th>
                    <th class="center aligned">ID Number</th>
                    <th class="center aligned">Firstname</th>
                    <th class="center aligned">Middlename</th>
                    <th class="center aligned">Lastname</th>
                    <th class="center aligned">Action</th>
                </thead>
                <tbody>
                    @if($class->students->count() != null)
                    @foreach($class->students as $key => $student)
                    <tr>
                        <td class="one wide center aligned">{{ ++$key }}</td>
                        <td class="center aligned">{{ $student->id_number }}</td>
                        <td>{{ $student->firstname.' '.$student->suffix }}</td>
                        <td>{{ $student->middlename }}</td>
                        <td>{{ $student->lastname }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="center aligned" colspan="6">No Students Enrolled</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="five wide column">
            <div class="ui top attached gray inverted header"><i class="ion-information-circled icon"></i> Class Information</div>
            <table class="ui attached small definition table">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{ $class->name }}</td>
                    </tr>
                    <tr>
                        <td>Code</td>
                        <td>{{ $class->code }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>{{ $class->department->name }}</td>
                    </tr>
                    <tr>
                        @if($class->department->id == 1)
                        <td>Strand</td>
                        @else
                        <td>Course</td>
                        @endif
                        <td>{{ $class->program->name }}</td>
                    </tr>
                    <tr>
                        <td>Year Level</td>
                        <td>{{ $class->year_level->name }}</td>
                    </tr>
                    <tr>
                        <td>Section</td>
                        <td>{{ $class->section }}</td>
                    </tr>
                    <tr>
                        <td>Subject</td>
                        <td>{{ $class->subject->name }}</td>
                    </tr>
                    <tr>
                        <td>No. of Students</td>
                        <td>{{ $class->students->count() }}</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="ui section divider"></div>

            <div class="ui top attached gray inverted header"><i class="ion-ios-chatboxes-outline icon"></i> Related Lessons</div>
            <div class="ui attached segment">
                <div class="ui stackable raised cards">
                    @foreach ($lessons as $lesson)
                    <div class="card">
                        <div class="image">
                            <img src="{{ asset('images/books.jpg') }}" alt=""> 
                            @if($lesson->has('chapters'))
                            <a href="" class="ui blue top left attached label">{{ $lesson->chapters->count() }} 
                                @if($lesson->chapters->count() > 1) 
                                Chapters 
                                @else
                                Chapter 
                                @endif
                            </a> 
                            @else
                            <a href="{{ route('chapter.add', $lesson->code) }}" class="ui blue top left attached label"><i class="ion-plus icon"></i> Add Chapter</a>        
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
                        <div class="ui attached two basic buttons">
                            @if($class->lessons->count() == null)
                                <a href="{{ route('lesson.view', $lesson->code) }}" target="_blank" class="ui icon button">
                                    <i class="blue ion-ios-redo icon"></i> Preview Lesson
                                </a>
                                <button class="ui icon button" onclick="attach('{{ $class->code }}', {{ $lesson->id }})">
                                    <i class="purple ion-plus icon"></i> Add to Class
                                </button>
                            @else
                                <a href="{{ route('lesson.view', $lesson->code) }}" target="_blank" class="ui icon button">
                                    <i class="blue ion-ios-redo icon"></i> View Lesson
                                </a>
                                <button class="ui icon button" onclick="detach('{{ $class->code }}', {{ $lesson->id }})">
                                    <i class="red ion-minus icon"></i> Remove
                                </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="ui section divider"></div>

            <div class="ui top attached gray inverted header"><i class="ion-ios-personadd icon"></i> Add Students</div>
            <div class="ui attached center aligned segment">
                <div class="ui left icon action fluid input">
                    <i class="search icon"></i>
                    <input placeholder="ID Number" type="text">
                    <div class="ui blue submit button">Search</div>
                </div>
                <div class="ui horizontal divider">
                    Or
                </div>
                <form action="{{ route('class.upload', $class->code) }}" method="POST" class="ui form" id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="fields">
                        <div class="twelve wide field">
                            <div class="ui input">
                                <input type="file" name="doc" id="file" placeholder="Select File...">
                            </div>
                        </div>
                        <div class="four wide field">
                            <button type="submit" class="ui animated fade fluid primary icon button">
                                <div class="visible content">Upload</div>
                                <div class="hidden content"><i class="ion-upload icon"></i></div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="ui section divider"></div>

            <div class="ui top attached gray inverted header"><i class="ion-ios-chatboxes-outline icon"></i> Class Logs</div>
            <div class="ui attached placeholder segment"></div>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script>
    function attach(class_id, lesson){
        swal({ 
            title: 'Are you sure?', 
            text: "This Lesson will be added to your Class", 
            type: 'question', 
            showCancelButton: true, 
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33', 
            confirmButtonText: 'Yes' 
            })
            .then((result) => { 
                if (result.value) { 
                    var route = '{{ url('classes/attach') }}' + '/' + class_id + '/' + lesson; 
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
    function detach(class_id, lesson){
        swal({ 
            title: 'Are you sure?', 
            text: "This Lesson will be removed from your Class", 
            type: 'question', 
            showCancelButton: true, 
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33', 
            confirmButtonText: 'Yes' 
            })
            .then((result) => { 
                if (result.value) { 
                    var route = '{{ url('classes/detach') }}' + '/' + class_id + '/' + lesson; 
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