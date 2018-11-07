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
                <div class="ui top attached segment">
                    <form action="{{ route('digihub.logs') }}" method="POST" class="ui small form">
                        @csrf
                        <div class="fields">
                            <div class="fourteen wide field">
                                <div class="ui fluid selection dropdown">
                                    <input type="hidden" name="month">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Select Month...</div>
                                    <div class="menu">
                                        <div class="item" data-value="1">January</div>
                                        <div class="item" data-value="2">February</div>
                                        <div class="item" data-value="3">March</div>
                                        <div class="item" data-value="4">April</div>
                                        <div class="item" data-value="5">May</div>
                                        <div class="item" data-value="6">June</div>
                                        <div class="item" data-value="7">July</div>
                                        <div class="item" data-value="8">August</div>
                                        <div class="item" data-value="9">September</div>
                                        <div class="item" data-value="10">October</div>
                                        <div class="item" data-value="11">November</div>
                                        <div class="item" data-value="12">December</div>
                                    </div>
                                </div>
                            </div>
                            <div class="two wide field">
                                <button type="submit" class="ui primary fluid icon button"><i class="ion-funnel icon"></i> Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="ui attached segment">
                    {!! $chart->container() !!}
                </div>
                <div class="ui section divider"></div>
                <div class="ui raised segment">
                    {!! $alltime->container() !!}
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
{!! $alltime->script() !!}
@endpush