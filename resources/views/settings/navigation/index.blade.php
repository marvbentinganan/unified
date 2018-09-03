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
<div class="ui two column padded grid">
    <div class="six wide column">
        <div class="ui top attached header">Add New Navigation</div>
        <div class="ui attached stacked segment">
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
                            <i class="ion-ios-pricetag icon"></i>
                        </div>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label for="">Order</label>
                        <div class="ui left icon input">
                            <input type="number" name="order" placeholder="Order...">
                            <i class="ion-ios-pricetag icon"></i>
                        </div>
                    </div>
                    <div class="field">
                        <label for="">Icon</label>
                        <div class="ui left icon input">
                            <input type="text" name="icon" placeholder="Icon...">
                            <i class="ion-ios-pricetag icon"></i>
                        </div>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label for="">Parent Menu</label> {!! SemanticForm::select('menu_id', $parents)->placeholder('Parent
                        Menu') !!}
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
                    <button type="submit" class="ui primary submit icon button"><i class="save icon"></i> Add</button>
                </div>
            </form>
        </div>
    </div>
    <div class="ten wide column">
        <div class="ui top attached header">Navigation Menus</div>
        <div class="ui attached segment">
            <table class="ui unstackable compact celled striped small table">
                <thead>
                    <th class="center aligned">Name</th>
                    <th class="center aligned">Route</th>
                    <th class="center aligned">Icon</th>
                    <th class="center aligned">Order</th>
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
                        <td>
                            <i class="large {{ $menu->icon }} icon"></i>
                        </td>
                        <td class="center aligned">
                            {{ $menu->order }}
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
                            <button class="ui mini teal icon button"><i class="ion-edit icon"></i></button>
                            <button class="ui mini red icon button"><i class="ion-trash-a icon"></i></button>
                        </td>
                    </tr>
                    @endforeach @endif
                </tbody>
            </table>
            <div class="ui large left vertical accordion secondary menu">
                @php $role = auth()->user()->roles()->first();
@endphp @foreach($role->menus->where('is_primary', true)->sortBy('order')
                as $menu) @if($menu->has_children == true)
                <div class="item">
                    <div class="title">
                        {{ $menu->name }}
                        <i class="{{ $menu->icon }} icon"></i>
                    </div>
                    <div class="content">
                        <div class="menu">
                            @foreach($menu->children as $child)
                            <a href="{{ route($child->link) }}" class="item">
                                {{ $child->name }}
                                <i class="{{ $child->icon }} icon"></i>
                            </a> @endforeach
                        </div>
                    </div>
                </div>
                @else
                <a href="{{ route($menu->link) }}" class="item">
                        {{ $menu->name }}
                        <i class="{{ $menu->icon }} icon"></i>
                    </a> @endif @endforeach
                <a class="item" onclick="confirm()">
                    Sign Out
                    <i class="ion-log-out icon"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')
@endpush
