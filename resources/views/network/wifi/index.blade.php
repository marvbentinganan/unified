@extends('layouts.app') @push('header_scripts') 
@endpush 
@section('content')
<div class="sixteen wide column">
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="ui breadcrumb segment">
            <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('network') }}" class="section">Network Services</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('wifi') }}" class="active section">RCI-WIFI</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable grid">
        <div class="row">
            <div class="ten wide column">
                <div class="ui top attached header"><i class="chart bar icon"></i>Logins for the Past 7 days</div>
                <div class="ui attached segment">
                    {!! $weekly->container() !!}
                </div>
            </div>
            <div class="six wide column">
                <div class="ui top attached borderless menu">
                    <div class="header item">Recent Logs</div>
                    <div class="right menu">
                        <a href="{{ route('wifi.logs') }}" class="item"><i class="server icon"></i>View Active Logs</a>
                    </div>
                </div>
                <div class="ui attached segment">
                    <div class="ui small feed">
                        @foreach($recents as $recent)
                        <div class="event">
                            <div class="label">
                                <img src="{{ asset('images/avatar.jpg') }}" alt="">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="" class="user">{{ $recent->user->firstname.' '.$recent->user->lastname }}</a>
                                    <div class="date">{{ $recent->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="meta">
                                    <a href="" class="like">
                                        @foreach ($recent->user->roles as $role)
                                            <span class="ui label">{{ $role->display_name }}</span>
                                        @endforeach
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>

{!! $weekly->script() !!}
@endpush