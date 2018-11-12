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
            <a href="" class="section">Class Management</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('my.classes') }}" class="section">My Classes</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('class.view', $class->code) }}" class="active section">{{ $class->name }}</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable very padded two column grid">
        <div class="eleven wide column">
            <div class="ui top attached header"><i class="ion-ios-list-outline icon"></i> Class List</div>
            <div class="ui attached placeholder segment"></div>
        </div>
        <div class="five wide column">
            <div class="ui top attached header"><i class="ion-ios-personadd icon"></i> Add Students</div>
            <div class="ui attached center aligned segment">
                <div class="ui left icon action fluid input">
                    <i class="search icon"></i>
                    <input placeholder="ID Number" type="text">
                    <div class="ui blue submit button">Search</div>
                </div>
                <div class="ui horizontal divider">
                    Or
                </div>
                <form action="" method="POST" class="ui form" id="uploadForm" enctype="multipart/form-data">
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
            <div class="ui top attached header"><i class="ion-ios-chatboxes-outline icon"></i> Class Logs</div>
            <div class="ui attached placeholder segment"></div>
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
@endpush