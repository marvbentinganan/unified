@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('plugins/vuejs/vuejs-datepicker.min.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('users') }}" class="active section">Users</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable grid">
        <div class="sixteen wide column">
            <div class="ui four doubling raised cards">
                <a href="{{ route('employees') }}" class="card">
                    <div class="image">
                        <img src="{{ asset('images/teachers.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">Employees</div>
                        <div class="description">
                            Manage Faculty and Staff Accounts
                        </div>
                    </div>
                </a>
                <a href="{{ route('students') }}" class="card">
                    <div class="image">
                        <img src="{{ asset('images/students.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">Students</div>
                        <div class="description">
                            Manage Student Accounts
                        </div>
                    </div>
                </a>
                <a href="{{ route('active.directory') }}" class="card">
                    <div class="image">
                        <img src="{{ asset('images/active.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">Active Directory</div>
                        <div class="description">
                            Manage Active Users
                        </div>
                    </div>
                </a>
                <a href="" class="card">
                    <div class="image">
                        <img src="{{ asset('images/admin.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">Administrators</div>
                        <div class="description">
                            Manage Administrator Accounts
                        </div>
                    </div>
                </a>
                <a href="{{ route('roles') }}" class="card">
                    <div class="image">
                        <img src="{{ asset('images/roles.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">Roles</div>
                        <div class="description">
                            Manage User Roles
                        </div>
                    </div>
                </a>
                <a href="{{ route('permissions') }}" class="card">
                    <div class="image">
                        <img src="{{ asset('images/permissions.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">Permissions</div>
                        <div class="description">
                            Manage User Permissions
                        </div>
                    </div>
                </a>
            </div>
            <div class="ui section divider"></div>
            <div class="ui stackable two column grid">
                <div class="column">
                    <div class="ui top attached header"><i class="ion-upload icon"></i> Remove Inactive SHS Students</div>
                    <div class="ui attached segment">
                        <div class="ui small info icon message">
                            <i class="ion-alert icon"></i>
                            <div class="content">
                                <div class="header">Instruction</div>
                                <p>Create and Excel File with a list of Student ID Numbers of Enrolled Students.</p>
                            </div>
                        </div>
                        <form action="{{ route('users.audit') }}" method="POST" class="ui small form" id="uploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="field">
                                <div class="ui input">
                                    <input type="file" name="doc" id="file" placeholder="Select File...">
                                </div>
                            </div>
                            <div class="field">
                                <button type="submit" class="ui animated fade fluid primary icon button">
                                    <div class="visible content"><i class="ion-upload icon"></i> Upload</div>
                                    <div class="hidden content"><i class="ion-upload icon"></i></div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="column"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts')

@endpush
