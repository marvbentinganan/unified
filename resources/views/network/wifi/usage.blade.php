@extends('layouts.app') @push('header_scripts') 
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('network') }}" class="section">Network Services</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('wifi') }}" class="section">RCI-WIFI</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('wifi.usage', $user->id) }}" class="active section">{{ $user->firstname.' '.$user->lastname }}</a>
@endsection
@section('content')
<div class="sixteen wide column">
	<div class="ui stackable two column grid">
		<div class="four wide column">
			<div class="ui fluid card">
				<div class="image">
					<img src="{{ asset('images/avatar.jpg') }}" alt="">
				</div>
				<div class="content">
					<div class="header">{{ $user->firstname.' '.$user->lastname }}</div>
					<div class="meta">
						<span class="date"><i class="address card icon"></i> {{ $user->username }}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="twelve wide column">
			<div class="ui top attached borderless menu">
				<div class="header item">Usage History</div>
				<div class="right menu">
					<a href="{{ route('wifi.logs') }}" class="item"><i class="blue server icon"></i>Active Logs</a>
					<a href="{{ route('wifi') }}" class="item"><i class="blue wifi icon"></i>RCI-WIFI</a>
				</div>
			</div>
			<div class="ui attached segment">
				<table class="ui small compact unstackable table">
					<thead>
						<th class="center aligned">Device</th>
						<th class="center aligned">IP</th>
						<th class="center aligned">Logged In</th>
						<th class="center aligned">Remaining Time</th>
						<th class="center aligned">Status</th>
					</thead>
					<tbody>
						@foreach($user->access_logs->sortByDesc('created_at')->take(15) as $key => $log)
						<tr>
							<td class="center aligned">{{ $log->device }}</td>
							<td class="center aligned">{{ $log->ip }}</td>
							<td class="right aligned">{{ $log->created_at->toDayDateTimeString() }}</td>
							<td class="right aligned">{{ $log->time_remaining() }}</td>
							<td class="center aligned">
								@if( now()
								< $log->expires_on)
								<span class="ui green label">Authorized</span> @else
								<span class="ui red label">Expired</span> @endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@push('footer_scripts')
<script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>
@endpush