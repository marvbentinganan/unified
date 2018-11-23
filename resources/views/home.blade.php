@extends('layouts.app')
@section('breadcrumb')
<a href="{{ url('/home') }}" class="active section"><i class="home icon"></i>Home</a>
@endsection
@section('content')
<div class="ui stackable very padded grid">
    <div class="sixteen wide column">
        <div class="ui placeholder segment"></div>
    </div>
</div>
@endsection
