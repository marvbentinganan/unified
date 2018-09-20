@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('plugins/vuejs/vuejs-datepicker.min.js') }}"></script>

@endpush 
@section('content')
<div class="sixteen wide column">
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="ui breadcrumb">
            <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="" class="section">Network Services</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('digihub') }}" class="section">Digihub</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        </div>
    </div>
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
        </div>
        <div class="twelve wide column">
            <div class="ui top attached header">List of Digihub Stations</div>
            <div class="ui attached segment">
                <table class="ui unstackable celled table">
                    <thead>
                        <th class="center aligned">Name</th>
                        <th class="center aligned">IP Address</th>
                        <th class="center aligned">Location</th>
                        <th class="five wide center aligned">Actions</th>
                    </thead>
                    <tbody>
                        <tr v-for="station in digihubs">
                            <td>@{{ station.name }}</td>
                            <td class="center aligned">@{{ station.ip }}</td>
                            <td>@{{ station.location }}</td>
                            <td class="center aligned">
                                <button class="ui mini teal icon button" @click="get(station.id)"><i class="ion-edit icon"></i> Update</button>
                                <button class="ui mini red icon button" @click="destroy(station.id)"><i class="ion-trash-b icon"></i> Delete</button>
                                <a :href="'logs/' + station.id + '/single'" class="ui mini blue icon button"><i class="ion-share icon"></i> View Logs</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
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