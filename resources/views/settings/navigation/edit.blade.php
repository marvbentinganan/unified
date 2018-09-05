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
        <a href="{{ route('navigation.edit', $menu->id) }}" class="section">{{ $menu->name }}</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    </div>
</div>
<div class="ui section divider"></div>
<div class="ui stackable vey padded two column grid">
    <div class="four wide column">
        <div class="ui top attached header"><i class="blue ion-information-circled icon"></i>Menu Item Details</div>
        <div class="ui attached segment">
            <table class="ui compact celled striped table">
                <thead>
                    <th class="center aligned">Label</th>
                    <th class="center aligned">Value</th>
                </thead>
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $menu->name }}</td>
                    </tr>
                    <tr>
                        <th>Route</th>
                        <td>{{ $menu->link }}</td>
                    </tr>
                    <tr>
                        <th>Icon</th>
                        <td><i class="{{ $menu->icon }} icon"></i>{{ $menu->icon }}</td>
                    </tr>
                    <tr>
                        <th>Order</th>
                        <td>{{ $menu->order }}</td>
                    </tr>
                    <tr>
                        <th>Is Primary</th>
                        <td>
                            @if($menu->is_primary == true)
                            <i class="green check icon"></i> @else
                            <i class="red remove icon"></i> @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Has Children</th>
                        <td>
                            @if($menu->has_children == true)
                            <i class="green check icon"></i> @else
                            <i class="red remove icon"></i> @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Roles</th>
                        <td>
                           <div class="ui list">
                               @foreach($menu->roles as $role)
                               <div class="item">{{ $role->display_name }}</div>
                               @endforeach
                           </div>
                        </td>
                    </tr>
                    @if($menu->children->count() > 0 )
                    <tr>
                        <th>Sub Menus</th>
                        <td>
                            <div class="ui list">
                               @foreach($menu->children as $child)
                               <div class="item">{{ $child->name }}</div>
                               @endforeach
                           </div>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <th>Sub Menus</th>
                        <td>
                            No Sub-menus
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="twelve wide column">
        <div class="ui top attached header"><i class="blue ion-edit icon"></i>Update Menu Item</div>
        <div class="ui attached segment">
            <form action="{{ route('navigation.update', $menu->id) }}" method="POST" class="ui form">
                @csrf
                <div class="two fields">
                    <div class="field">
                        <label for="">Name</label>
                        <div class="ui left icon input">
                            <input type="text" name="name" placeholder="Name..." value="{{ $menu->name }}">
                            <i class="ion-ios-pricetag icon"></i>
                        </div>
                    </div>
                    <div class="field">
                        <label for="">Route</label>
                        <div class="ui left icon input">
                            <input type="text" name="link" placeholder="Link..." value="{{ $menu->link }}">
                            <i class="ion-link icon"></i>
                        </div>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label for="">Order</label>
                        <div class="ui left icon input">
                            <input type="number" name="order" placeholder="Order..." value="{{ $menu->order }}">
                            <i class="ion-shuffle icon"></i>
                        </div>
                    </div>
                    <div class="field">
                        <label for="">Icon</label>
                        <div class="ui left icon input">
                            <input type="text" name="icon" placeholder="Icon..." value="{{ $menu->icon }}">
                            <i class="ion-ionic icon"></i>
                        </div>
                    </div>
                </div>
                <div class="two fields">
                        {!! SemanticForm::select('menu_id', $parents, $menu->menu_id)->label('Parent
                        Menu') !!}
                        {!! SemanticForm::selectMultiple('roles[]', $roles, $menu->roles->pluck('id')->toArray())->addClass('multiple')->label('Roles')
                        !!}
                </div>
                <div class="two fields">
                    <div class="field">
                        {!! SemanticForm::checkbox('has_children', true, $menu->has_children)->label('Has Children') !!}
                    </div>
                    <div class="field">
                        {!! SemanticForm::checkbox('is_primary', true, $menu->is_primary)->label('Is Primary') !!}
                    </div>
                </div>
                <div class="field">
                    @permission(['update-navigation'])
                    <button type="submit" class="ui primary submit icon button"><i class="save icon"></i> Update</button>
                    @else
                    <button class="ui disabled primary submit icon button"><i class="save icon"></i> Update</button>
                    @endpermission
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts')

@endpush
