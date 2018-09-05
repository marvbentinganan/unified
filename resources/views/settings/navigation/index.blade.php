@extends('layouts.app') @push('header_scripts')
@endpush
@section('content') {{-- Breadcrumb --}}
<div class="row">
    <div class="ui breadcrumb">
        <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        <a href="" class="section">Settings</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        <a href="{{ route('navigation') }}" class="section">Navigation</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    </div>
</div>
<div class="ui section divider"></div>
<div class="row">
    <div class="ui top attached icon menu">
        <a class="item" onclick="addMenu()">
            <i class="large ion-plus-circled icon"></i>
        </a>
        <div class="header item">
            Navigation Menus
        </div>
    </div>
    <div class="ui attached segment">
        <table class="ui unstackable compact celled striped small table">
            <thead>
                <th class="center aligned">Name</th>
                <th class="center aligned">Route</th>
                <th class="center aligned">Icon</th>
                <th class="center aligned">Order</th>
                <th class="center aligned">Primary</th>
                <th class="center aligned">Has Children</th>
                <th class="center aligned">Parent</th>
                <th class="center aligned">Roles</th>
                <th class="center aligned">Actions</th>
            </thead>
            <tbody>
                @if($menus != null) @foreach($menus as $menu)
                <tr>
                    <td>
                        {{ $menu->name }}
                    </td>
                    <td>
                        {{ $menu->link }}
                    </td>
                    <td class="center aligned">
                        <i class="large {{ $menu->icon }} icon"></i>
                    </td>
                    <td class="center aligned">
                        {{ $menu->order }}
                    </td>
                    <td class="center aligned">
                        @if($menu->is_primary == true)
                        <i class="green check icon"></i> @else
                        <i class="red remove icon"></i> @endif
                    </td>
                    <td class="center aligned">
                        @if($menu->has_children == true)
                        <i class="green check icon"></i> @else
                        <i class="red remove icon"></i> @endif
                    </td>
                    <td>
                        {{ $menu->parent['name'] }}
                    </td>
                    <td>
                        <div class="ui list">
                            @foreach($menu->roles as $role)
                            <div class="item">{{ $role->display_name }}</div>
                            @endforeach
                        </div>
                    </td>
                    <td class="two wide center aligned">
                        @permission(['update-navigation|delete-navigation'])
                        <button class="ui mini teal icon button"><i class="ion-edit icon"></i></button>
                        <button class="ui mini red icon button"><i class="ion-trash-a icon"></i></button>
                        @endpermission
                    </td>
                </tr>
                @endforeach @endif
            </tbody>
        </table>
    </div>
    <div class="ui modal">
        <div class="header">Add New Menu</div>
        <div class="content">
            <form action="{{ route('navigation.add') }}" method="POST" class="ui form">
                @csrf
                <div class="two fields">
                    <div class="field">
                        <label for="">Name</label>
                        <div class="ui left icon input">
                            <input type="text" name="name" placeholder="Name...">
                            <i class="ion-ios-pricetag icon"></i>
                        </div>
                    </div>
                    <div class="field">
                        <label for="">Route</label>
                        <div class="ui left icon input">
                            <input type="text" name="link" placeholder="Link...">
                            <i class="ion-link icon"></i>
                        </div>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label for="">Order</label>
                        <div class="ui left icon input">
                            <input type="number" name="order" placeholder="Order...">
                            <i class="ion-shuffle icon"></i>
                        </div>
                    </div>
                    <div class="field">
                        <label for="">Icon</label>
                        <div class="ui left icon input">
                            <input type="text" name="icon" placeholder="Icon...">
                            <i class="ion-ionic icon"></i>
                        </div>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label for="">Parent Menu</label> {!! SemanticForm::select('menu_id', $parents)->placeholder('Parent
                        Menu')->attribute('v-model', "menu_id") !!}
                    </div>
                    <div class="field">
                        <label for="">Roles</label> {!! SemanticForm::selectMultiple('roles[]', $roles)->placeholder('Roles')
                        !!}
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        {!! SemanticForm::checkbox('has_children', true, false)->label('Has Children') !!}
                    </div>
                    <div class="field">
                        {!! SemanticForm::checkbox('is_primary', true, false)->label('Is Primary') !!}
                    </div>
                </div>
                <div class="field">
                    @permission(['add-navigation'])
                    <button type="submit" class="ui primary submit icon button"><i class="save icon"></i> Add</button>
                    @else
                    <button class="ui disabled primary submit icon button"><i class="save icon"></i> Add</button>
                    @endpermission
                </div>
            </form>
        </div>
    </div>
</div>    
@endsection
@push('footer_scripts')
<script>
    function addMenu(){
        $('.ui.modal')
        .modal({centered:true})
        .modal('setting', 'transition', 'fade up')
        .modal('show');
    }
</script>
@endpush
