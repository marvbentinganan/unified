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
    <div class="ui stackable very padded two column grid">
        <div class="eleven wide column">
            <div class="ui top attached gray inverted header">
                <i class="ion-ios-list icon"></i> Class List
            </div>
            <table class="ui attached small unstackable celled table">
                <thead>
                    <th class="one wide center aligned">#</th>
                    <th class="center aligned">ID Number</th>
                    <th class="center aligned">Firstname</th>
                    <th class="center aligned">Middlename</th>
                    <th class="center aligned">Lastname</th>
                    <th class="center aligned">Action</th>
                </thead>
                <tbody>
                    @if($class->has('students'))
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
                </tbody>
            </table>
            
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
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
@endpush