@extends('layouts.app') 
@push('header_scripts')
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('users') }}" class="section">Users</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('employees') }}" class="section">Employees</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('employee.show', $employee->id) }}" class="active section">{{ $employee->fullname }}</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable grid">
        <div class="sixteen wide column">
            <div class="row">
                {{-- User Profile --}}
                <div class="ui top attached header"><i class="id card icon"></i>User Profile</div>
                <div class="ui attached segment">
                    <form action="" method="POST" class="ui small form">
                        @csrf
                        <div class="three fields">
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="text" name="firstname" id="" placeholder="First Name" value="{{ $employee->firstname }}">
                                    <i class="address card icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="text" name="middlename" id="" placeholder="Middle Name" value="{{ $employee->middlename }}">
                                    <i class="address card icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="text" name="lastname" id="" placeholder="Last Name" value="{{ $employee->lastname }}">
                                    <i class="address card icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="text" name="username" id="" readonly value="{{ $employee->user->username }}">
                                    <i class="tag icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="email" name="email" id="" placeholder="Email Address" value="{{ $employee->user->email }}">
                                    <i class="envelope icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                {!! SemanticForm::selectMultiple('roles[]', $roles, $employee->user->roles->pluck('display_name', 'id')->toArray())->placeholder('Roles')->addClass('multiple')
                                !!}
                            </div>
                        </div>
                        <div class="four fields">
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="text" name="title" id="" placeholder="Title (i.e. Dr.)" value="{{ $employee->title }}">
                                    <i class="tag icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="text" name="suffix" id="" placeholder="Suffix (i.e. Jr., IV)" value="{{ $employee->suffix }}">
                                    <i class="tag icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="text" name="id_number" id="" placeholder="ID Number" value="{{ $employee->id_number }}">
                                    <i class="id badge icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="text" name="barcode" id="" placeholder="Barcode" value="{{ $employee->barcode }}">
                                    <i class="barcode icon"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            {!! SemanticForm::checkbox('is_faculty', true, $employee->is_faculty)->label('Faculty') !!}
                        </div>
                        <div class="field">
                            {!! SemanticForm::checkbox('is_manager', true, $employee->is_manager)->label('Manager') !!}
                        </div>
                        @if(auth()->user()->can(['update-user']))
                       <div class="field">
                           <button type="submit" class="ui small animated primary fade submit icon button">
                               <div class="visible content">Update</div>
                               <div class="hidden content"><i class="sync icon"></i></div>
                           </button>
                       </div>
                       @endif
                    </form>
                </div>
            </div>
            <div class="ui section divider"></div>
            <div class="row">
                {{-- User Permissions --}}
                <div class="ui top attached header"><i class="lock icon"></i> User Permissions</div>
                <form action="{{ route('active.update.permission', $employee->user->id) }}" method="POST" class="ui attached form segment">
                    @csrf
                    <table class="ui unstackable small compact celled table">
                        <thead>
                            <th class="center aligned">Access</th>
                            <th class="center aligned">Name</th>
                            <th class="center aligned">Description</th>
                        </thead>
                        <tbody>
                            @foreach($employee->user->allPermissions()->sortBy('id') as $access)
                            <tr>
                                <td>
                                    {!! SemanticForm::checkbox('permissions[]', $access->id, $access->id)->label($access->display_name) !!}
                                    {{-- <div class="field">
                                        <div class="ui toggle checkbox">
                                            <input type="checkbox" name="permissions[]" value="{{ $access->id }}" checked>
                                            <label>{{ $access->display_name }}</label>
                                        </div>
                                    </div> --}}
                                </td>
                                <td>{{ $access->name }}</td>
                                <td>{{ $access->description }}</td>
                            </tr>
                            @endforeach
                            @foreach($permissions as $permission)
                            <tr>
                                <td>
                                    {!! SemanticForm::checkbox('permissions[]', $permission->id, null)->label($permission->display_name) !!}
                                    {{-- <div class="field">
                                        <div class="ui toggle checkbox">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                            <label>{{ $permission->display_name }}</label>
                                        </div>
                                    </div> --}}
                                </td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    @if(auth()->user()->can(['update-user']))
                                    <div class="field">
                                        <button type="submit" class="ui small animated primary fade submit icon button">
                                            <div class="visible content">Update</div>
                                            <div class="hidden content"><i class="sync icon"></i></div>
                                        </button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts')

@endpush