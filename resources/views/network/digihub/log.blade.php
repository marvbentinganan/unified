@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('plugins/vuejs/vuejs-datepicker.min.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('network') }}" class="section">Network Services</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('digihub') }}" class="section">Digihub</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('digihub.log', $digihub->id) }}" class="section">{{ $digihub->name }}</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="#" class="active section">Logs</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable two column grid">
        <div class="ten wide column">
            <div class="ui fluid card">
                <div class="image">
                    <img src="{{ asset('images/digihub/'.$digihub->ip.'.jpg') }}" alt="">
                </div>
                <div class="content">
                    <div class="header">{{ $digihub->name }}</div>
                    <div class="meta">
                        <span class="date"><i class="ion-ios-world icon"></i>{{ $digihub->ip }}</span>
                        <span class="date"><i class="ion-ios-location icon"></i>{{ $digihub->location }}</span>
                    </div>
                </div>
            </div>
            <div class="ui section divider"></div>
            <div class="ui stackable two column grid">
                <div class="column">
                    <div class="ui segment">
                        {!! $monthly->container() !!}
                    </div>
                </div>
                <div class="column">
                    <div class="ui segment">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="six wide column">
            <div class="ui top attached segment">
                <form action="{{ route('digihub.log', $digihub->id) }}" method="POST" class="ui form">
                    @csrf
                    <div class="ui three fields">
                        <div class="seven wide field">
                            <div class="ui calendar" id="from">
                                <div class="ui input left icon">
                                    <i class="calendar icon"></i>
                                    <input type="text" name="from" placeholder="Start Date">
                                </div>
                            </div>
                        </div>
                        <div class="seven wide field">
                            <div class="ui calendar" id="to">
                                <div class="ui input left icon">
                                    <i class="calendar icon"></i>
                                    <input type="text" name="to" placeholder="End Date">
                                </div>
                            </div>
                        </div>
                        <div class="two wide field">
                            <button type="submit" class="ui primary fluid icon button"><i class="ion-funnel icon"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="ui attached segment">
                <div class="ui sub header">Total Records: {{ $logs->total() }}</div>
                <table class="ui unstackable small compact celled table">
                    <thead>
                        <th class="center aligned">#</th>
                        <th class="center aligned">Name</th>
                        <th class="center aligned">IP Address</th>
                        <th class="center aligned">Date</th>
                    </thead>
                    <tbody>
                        @foreach($logs as $key => $log)
                        <tr>
                            <td class="center aligned">{{ ++$key }}</td>
                            <td class="center aligned">{{ $digihub->name }}</td>
                            <td class="center aligned">{{ $digihub->ip }}</td>
                            <td class="right aligned">{{ $log->created_at->toDayDateTimeString() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="ui attached segment">
                @if ($logs->lastPage() > 1)
                <div class="ui stackable pagination menu">
                    <a href="{{ $logs->previousPageUrl() }}" class="{{ ($logs->currentPage() == 1) ? ' disabled' : '' }} item">
                        <i class="ion-arrow-left-b icon"></i>
                    </a> @for ($i = 1; $i
                    <=$logs->lastPage(); $i++)
                    <a href="{{ $logs->url($i) }}" class="{{ ($logs->currentPage() == $i) ? ' active' : '' }} item">
                        {{ $i }}
                    </a> @endfor
                    <a href="{{ $logs->nextPageUrl() }}" class="{{ ($logs->currentPage() == $logs->lastPage()) ? ' disabled' : '' }} item">
                        <i class="ion-arrow-right-b icon"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
@push('footer_scripts')
<script src="{{ asset('plugins/chartjs/Chart.min.js') }}""></script>
<script src="{{ asset('js/semantic-ui/calendar.min.js') }}"></script>
<script>
    $('#from').calendar({ 
        type: 'date', 
        endCalendar: $('#to'), 
    }); 
    
    $('#to').calendar({ 
        type: 'date', 
        startCalendar: $('#from') 
    });
</script>
{!! $chart->script() !!}
{!! $monthly->script() !!}
@endpush