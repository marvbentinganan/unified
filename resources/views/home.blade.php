@extends('layouts.app')
@section('content')
<div class="ui borderless pointing menu">
    @php 
        $role = auth()->user()->roles()->first();
    @endphp 
    @foreach($role->menus->where('is_primary', true)->sortBy('order')
    as $menu)
        @if($menu->has_children == true)
        <div href="" class="ui dropdown item">
            {{ $menu->name }}
            <i class="dropdown icon"></i>
            <div class="menu">
                @foreach($menu->children as $child)
                <a href="{{ route($child->link) }}" class="item"><i class="{{ $child->icon }} icon"></i> {{ $child->name }}</a> 
                @endforeach
            </div>
        </div>
        @else
        <a href="{{ route($menu->link) }}" class="item"><i class="{{ $menu->icon }} icon"></i>{{ $menu->name }}</a>
        @endif
    @endforeach
</div>
@endsection
