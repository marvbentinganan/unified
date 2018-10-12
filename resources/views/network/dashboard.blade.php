@extends('layouts.app') 
@push('header_scripts')
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
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui padded grid">
        <div class="sixteen wide column">
            <div class="ui four doubling raised cards">
                <a href="{{ route('wifi') }}" class="card">
                    <div class="image">
                        <img src="{{ asset('images/wifi.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">RCI - Wifi</div>
                        <div class="description">
                            Manage RCI - Wifi
                        </div>
                    </div>
                </a>
                <a href="{{ route('digihub') }}" class="card">
                    <div class="image">
                        <img src="{{ asset('images/desktop.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">Digihub</div>
                        <div class="description">
                            Manage Digihub Stations
                        </div>
                    </div>
                </a>
                <a href="https://192.168.255.73:10000/" target="_blank" class="card">
                    <div class="image">
                        <img src="{{ asset('images/dashboard.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">Web Server</div>
                        <div class="description">
                            Manage Linux Web Server
                        </div>
                    </div>
                </a>
                <a href="https://172.18.1.1:8443" target="_blank" class="card">
                    <div class="image">
                        <img src="{{ asset('images/unifi.jpg') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="header">UnifiController</div>
                        <div class="description">
                            Manage UnifiController
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
