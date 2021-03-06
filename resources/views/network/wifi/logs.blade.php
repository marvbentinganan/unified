@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('plugins/vuejs/vuejs-datepicker.min.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('network') }}" class="section">Network Services</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('wifi') }}" class="section">RCI-WIFI</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('wifi.active') }}" class="active section">Logs</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable two column grid">
        <div class="row">
            <div class="ui top attached segment">
                <div class="ui fluid icon input">
                    <input type="text" name="keyword" v-model="keyword" id="" placeholder="Filter Logs...">
                    <i class="inverted circular search icon"></i>
                </div>
            </div>
            <div class="ui attached segment">
                <table class="ui compact celled table">
                    <thead>
                        <th class="center aligned">User</th>
                        <th class="center aligned">Role</th>
                        <th class="center aligned">IP</th>
                        <th class="center aligned">MAC</th>
                        <th class="center aligned">Time of Login</th>
                        <th class="center aligned">Expiry</th>
                    </thead>
                    <tbody>
                        <tr v-for="log in filteredLogs">
                            <td>
                                <a :href="'usage/' + log.user.id"><i class="address card icon"></i> @{{ log.user.firstname }} @{{ log.user.lastname }}</a>
                            </td>
                            <td>
                                <span class="ui green label" v-for="role in log.user.roles">@{{ role.display_name }}</span>
                            </td>
                            <td class="center aligned">@{{ log.ip }}</td>
                            <td class="center aligned">@{{ log.device }}</td>
                            <td class="right aligned">@{{ log.login }}</td>
                            <td class="right aligned">@{{ log.expires_in }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')
<script>
    new Vue({
		el: '#app',
		data: {
            keyword : undefined,
            logs : ''
        },

        computed : {
            filteredLogs(){
                let logs = this.logs
                if (this.keyword && this.keyword != null) {
                    logs = logs.filter((log) => {
                        let data = log.device.indexOf(this.keyword) !== -1 || log.ip.indexOf(this.keyword) !== -1 || log.user.lastname.indexOf(this.keyword) !== -1 || log.user.firstname.indexOf(this.keyword) !== -1
                        return data
                    })
                }
                return logs
            }
        },
        
        methods: {
            init() {
                this.list();
                $('.dropdown').dropdown();
            },

            list(){
                axios.get('{{ route('wifi.active') }}') 
                .then(response => { 
                    this.logs = response.data; 
                }) 
                .catch(error => { 
                    console.log(error.response.data);
                })
            },
        },
        mounted() {
            this.init();

            setInterval(function (){
				this.list();
			}.bind(this), 30000);
        }
    });

</script>
@endpush