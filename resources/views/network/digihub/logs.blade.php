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
            <a href="{{ route('digihub') }}" class="section">Digihub</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="#" class="active section">Statistics</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable grid">
        <div class="row">
            <div class="four wide column">
                <div class="ui raised segment">
                    <table class="ui padded compact striped table">
                        <thead>
                            <th class="center aligned">Station</th>
                            <th class="center aligned">Location</th>
                            <th class="center aligned">Usage</th>
                        </thead>
                        <tbody>
                            @foreach($stations as $station)
                            <tr>
                                <td>{{ $station->name }}</td>
                                <td>{{ $station->location }}</td>
                                <td class="right aligned">{{ $station->usages->count() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="twelve wide column">
                <div class="ui raised segment">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')
<script src="{{ asset('plugins/chartjs/Chart.min.js') }}" "></script>
<script src="{{ asset( 'js/semantic-ui/calendar.min.js') }} "></script>
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
@endpush