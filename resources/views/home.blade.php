@extends('layouts.app')
@section('breadcrumb')
<a href="{{ url('/home') }}" class="active section"><i class="home icon"></i>Home</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable very padded two column grid">
        <div class="twelve wide column">
            <div class="ui segment">
                <div class="ui horizontal header">
                    <i class="ion-compose icon"></i> Build Files
                </div>
                <div class="ui horizontal header">
                    <i class="ion-code-working icon"></i> Network Services
                </div>
                <div class="ui horizontal header">
                    <i class="ion-ios-people icon"></i> User Management
                </div>
            </div>
        </div>
        <div class="four wide column">
            <div class="row">
                <div class="ui segment">
                    <div class="ui horizontal divided header">
                        <i class="ion-link icon"></i> Other Links
                    </div>
                    <div class="ui relaxed list">
                        <a href="https://192.168.255.73:10000/" target="_blank" class="item"><i class="server icon"></i> Web Server</a>
                        <a href="https://172.18.1.1:8443" target="_blank" class="item"><i class="wifi icon"></i> UniFi Controller</a>
                        <a href="https://172.16.16.16:4444" target="_blank" class="item"><i class="lock icon"></i> Sophos Firewall</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
