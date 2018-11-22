@extends('layouts.app') @push('header_scripts') 
@endpush 
@section('content')
<div class="sixteen wide column">
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="ui breadcrumb segment">
            <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('users') }}" class="section">Users</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('roles') }}" class="section">Roles</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('role.permissions') }}" class="active section">Role Permissions</a>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable grid">
        <div class="ui sixteen wide column">
            <section class="ui segment">
                <h3 class="ui header">Attach Permissions</h3>
                <form action="{{ route('role.sync') }}" method="POST" class="ui form">
                    @csrf
                    <table class="ui unstackable compact striped celled table">
                        <thead>
                            <th class="two wide center aligned">Legend</th>
                            @foreach($roles as $role)
                            <th class="center aligned">{{ $role->display_name }}</th>
                            @endforeach
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <th>{{ $permission->display_name }}</th>
                                @foreach($roles as $role)
                                <td class="one wide center aligned">
                                    <input type="hidden" name="{{ $role->name }}" value="{{ $role->id }}">
                                    @if($role->hasPermission($permission->name))
                                    {{-- <i class="green check icon"></i> --}}
                                    {!! SemanticForm::checkbox($role->name.'.permissions[]', $permission->id, $permission->id)->label(null) !!}
                                    @else
                                    {{-- <i class="red remove icon"></i> --}}
                                    {!! SemanticForm::checkbox($role->name.'.permissions[]', $permission->id, false)->label(null) !!}
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="field">
                        <button type="submit" class="ui small animated primary fade submit icon button">
                            <div class="visible content">Update Permissions</div>
                            <div class="hidden content"><i class="sync icon"></i></div>
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts') 
@endpush