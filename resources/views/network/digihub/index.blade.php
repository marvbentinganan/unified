@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('plugins/vuejs/vuejs-datepicker.min.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('network') }}" class="section">Network Services</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('digihub') }}" class="active section">Digihub</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable two column padded grid">
        <div class="four wide column">
            <div class="ui top attached header">Add Digihub Station</div>
            <div class="ui attached segment">
                <form action="" class="ui form" @submit.prevent="add()">
                    @csrf
                    <div class="field">
                        <div class="ui labeled input">
                            <div class="ui blue label">
                                <i class="ion-pricetag icon"></i>
                            </div>
                            <input type="text" name="name" v-model="digihub.name" placeholder="Name of e-Kiosk Station">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui labeled input">
                            <div class="ui blue label">
                                <i class="ion-ios-world icon"></i>
                            </div>
                            <input type="text" name="ip" v-model="digihub.ip" placeholder="Static IP Address">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui labeled input">
                            <div class="ui blue label">
                                <i class="ion-ios-location icon"></i>
                            </div>
                            <input type="text" name="location" v-model="digihub.location" placeholder="Location">
                        </div>
                    </div>
                    <div class="field">
                        <button type="submit" class="ui animated fade fluid primary submit icon button">
                            <div class="visible content"><i class="ion-ios-plus icon"></i>Add</div>
                            <div class="hidden content">Add Digihub Station</div>
                        </button>
                    </div>
                </form>
            </div>
            <div class="ui section divider"></div>
            <table class="ui padded compact celled striped table">
                <thead>
                    <th class="center aligned">Name</th>
                    <th class="center aligned">Location</th>
                    <th class="center aligned">Total Usage</th> 
                </thead>
                <tbody>
                    <tr v-for="stat in digihubs">
                        <th>@{{ stat.name }}</th>
                        <td>@{{ stat.location }}</td>
                        <td class="two wide right aligned">@{{ stat.usages.length }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="twelve wide column">
            <div class="ui top attached borderless menu">
                <div class="header item">Digihub Stations</div>
                <div class="right menu">
                    <a href="{{ route('digihub.logs') }}" class="item"><i class="ion-podium icon"></i>View Statistics</a>
                </div>
            </div>
            <div class="ui attached segment">
                <div class="ui four doubling raised cards">
                        <div class="card" v-for="station in digihubs">
                            <div class="image">
                                <img v-bind:src="station.thumb" alt="">
                            </div>
                            <div class="content">
                                <div class="header">@{{ station.name }}</div>
                                <div class="meta">
                                    <span class="date"><i class="ion-ios-world icon"></i> @{{ station.ip }}</span>
                                </div>
                                <div class="description">
                                    @{{ station.location }}
                                </div>
                            </div>
                            <div class="extra content">
                                <div class="ui three mini buttons">
                                    <button class="ui mini teal icon button" @click="get(station.id)"><i class="ion-edit icon"></i></button>
                                    <button class="ui mini red icon button" @click="destroy(station.id)"><i class="ion-trash-b icon"></i></button>
                                    <a :href="'logs/' + station.id + '/single'" class="ui mini blue icon button"><i class="ion-share icon"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
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
            digihubs : {},
            digihub : {
                name : '',
                ip : '',
                location : ''
            },
            route : '{{ route('digihub.add') }}',
        },
        
        methods: {
            init() {
                this.list();
                $('.dropdown').dropdown();
            },

            list(){
                axios.get('{{ route('digihub.list') }}') 
                .then(response => { 
                    this.digihubs = response.data; 
                }) 
                .catch(error => { 
                    console.log(error.response.data);
                })
            },

            add(){
                axios.post(this.route, this.$data.digihub)
                .then(response => {
                    this.list(),
                    toastr.success(response.data),
                    $('form').form('reset'),
                    this.route = '{{ route('digihub.add') }}';
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },

            get(id){
                var route = "get/" + id;
            	axios.get(route)
            	.then((response) => {
            		this.digihub = response.data,
                    this.route = '{{ url('digihub/update') }}' + '/' + id;
            	})
            	.catch(error => {
            		console.log(error.response.data)
            	});
            },

            destroy(id){ 
                swal({ 
                    title: 'Are you sure?', 
                    text: "This Digihub will be Deleted", 
                    type: 'question', 
                    showCancelButton: true, 
                    confirmButtonColor: '#3085d6', 
                    cancelButtonColor: '#d33', 
                    confirmButtonText: 'Yes' 
                    })
                    .then((result) => { 
                        if (result.value) { 
                            var route = 'delete/' + id; 
                            axios.get(route) 
                            .then(response => { 
                                this.list(), 
                                toastr.info(response.data); 
                            })
                    .catch(response => { 
                        toastr.error("Unable to Delete Digihub"); 
                    }); 
                } }) 
            },
        },
        mounted() {
            this.init();
        }
    });
</script>
@endpush