@extends('layouts.app')
@push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('users') }}" class="section">Users</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('permissions') }}" class="active section">Permissions</a>
@endsection
@section('content')
<div class="ui stackable two column grid">
    <div class="twelve wide column">
        <div class="ui top attached header">List of Permissions</div>
        <table class="ui attached small unstackable compact celled striped table">
            <thead>
                <th class="center aligned">Name</th>
                <th class="center aligned">Display Name</th>
                <th class="center aligned">Description</th>
                <th class="center aligned">Actions</th>
            </thead>
            <tbody>
                <tr v-for="permission in permissions">
                    <td>@{{ permission.name }}</td>
                    <td>@{{ permission.display_name }}</td>
                    <td>@{{ permission.description }}</td>
                    <td class="center aligned">
                        <button class="ui mini teal icon button" @click="edit(permission.id)"><i class="ion-edit icon"></i> Edit</button>
                        <button class="ui mini red icon button" @click="deletePermission(permission.id)"><i class="ion-trash-a icon"></i> Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="four wide column">
        <div class="ui top attached header">@{{ label }} Permission</div>
        <div class="ui attached segment">
            <form action="" method="POST" class="ui small form" @submit.prevent="addPermission()">
                @csrf
                <div class="field">
                    <div class="ui left icon input">
                        <input type="text" name="name" v-model="permission.name" placeholder="Name...">
                        <i class="ion-pricetag icon"></i>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <input type="text" name="display_name" v-model="permission.display_name" placeholder="Display Name...">
                        <i class="ion-pricetag icon"></i>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <input type="text" name="description" v-model="permission.description" placeholder="Description...">
                        <i class="ion-pricetag icon"></i>
                    </div>
                </div>
                <div class="field">
                    <button class="ui primary submit icon button"><i class="ion-plus-circled icon"></i> Add Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script>
     new Vue({
		el: '#app',
		data: {
            permissions : {},
            permission: {
                name : '',
                display_name : '',
                description : '',
            },
            route : '{{ route('permission.add') }}',
        },
        methods: {
            init() {
                this.getPermissions(),
                $('.dropdown').dropdown();
            },

            getPermissions(){
                axios.get('{{ route('permission.get') }}')
                .then(response => {
                    this.permissions = response.data;
                })
                .catch(error => {
                    swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 });
                })
            },

            addPermission(){
                axios.post(this.route, this.$data.permission)
                .then(response => {
                    this.getPermissions(),
                    this.route = '{{ route('permission.add') }}',
                    swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 });
                })
                .catch(error => {
                    console.log(error.response.data),
                    swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 });
                });
            },

            edit(id){
                var route = "get/" + id;
            	axios.get(route)
            	.then((response) => {
            		this.permission = response.data,
                    this.route = '{{ url('permission/update') }}' + '/' + id;
            	})
            	.catch(error => {
            		swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 });
            	});
            },

            deletePermission(id){
            	swal({
            		title: 'Are you sure?',
            		text: "This Permission will be Deleted",
            		type: 'question',
            		showCancelButton: true,
            		confirmButtonColor: '#3085d6',
            		cancelButtonColor: '#d33',
            		confirmButtonText: 'Yes'
            	}).then((result) => {
            		if (result.value) {
            			var route = 'delete/' + id;
            			axios.get(route)
            			.then(response => {
            				this.getPermissions(),
            				swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 });
            			})
            			.catch(response => {
            				swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 });
            			});
            		}
            	})
            },
        },
        mounted() {
            this.init();
        }
    });
</script>
@endpush
