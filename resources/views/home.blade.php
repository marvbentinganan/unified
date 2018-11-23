@extends('layouts.app')
@section('breadcrumb')
<a href="{{ url('/home') }}" class="active section"><i class="home icon"></i>Home</a>
@endsection
@section('content')
<div class="ui stackable two column grid">
    <div class="three wide column">
        <div class="ui fluid small borderless vertical menu">
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
    </div>
    <div class="thirteen wide column">
        <div class="ui segment"></div>
    </div>
</div>
@endsection
