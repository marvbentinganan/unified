@extends('layouts.app')
@push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('content') {{-- Breadcrumb --}}
<div class="row">
    <div class="ui breadcrumb segment">
        <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        <a href="{{ route('users') }}" class="section">Users</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        <a href="{{ route('permissions') }}" class="active section">Permissions</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    </div>
</div>
<div class="ui section divider"></div>
<div class="ui stackable two column padded grid">
    <div class="four wide column">
        <div class="ui top attached header">@{{ label }} Permission</div>
        <div class="ui attached segment">
            <form action="" method="POST" class="ui form" @submit.prevent="addPermission()">
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
                    <button class="ui primary submit icon button"><i class="ion-plus-circled icon"></i> @{{ label }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="twelve wide column">
        <div class="ui top attached header">List of Permissions</div>
        <div class="ui attached segment">
            <table class="ui unstackable compact celled striped table">
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
    </div>
</div>
@endsection
@push('footer_scripts')
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
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
            label : "Add",
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
                    console.log(error.response.data);
                })
            },

            addPermission(){
                axios.post('{{ route('permission.add') }}', this.$data.permission)
                .then(response => {
                    $('form').form('clear'),
                    this.getPermissions(),
                    this.permission = null,
                    toastr.success(response.data);
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },

            edit(id){
                var route = "get/" + id;
            	axios.get(route)
            	.then((response) => {
            		this.permission = response.data,
                    this.label = "Update";
            	})
            	.catch(error => {
            		console.log(error.response.data)
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
            				toastr.info(response.data);
            			})
            			.catch(response => {
            				toastr.error("Unable to Delete Role");
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
