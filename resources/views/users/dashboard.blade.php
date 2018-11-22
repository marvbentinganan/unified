@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('plugins/vuejs/vuejs-datepicker.min.js') }}"></script>

@endpush
@section('content')
<div class="sixteen wide column">
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="ui breadcrumb segment">
            <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('users') }}" class="active section">Users</a>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui padded grid">
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
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')

@endpush
