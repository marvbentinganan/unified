@extends('layouts.app')
@push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('content') 
{{-- Breadcrumb --}}
<div class="row">
    <div class="ui breadcrumb segment">
        <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        <a href="{{ route('users') }}" class="section">Users</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        <a href="{{ route('roles') }}" class="active section">Roles</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    </div>
</div>
<div class="ui section divider"></div>
<div class="ui stackable two column padded grid">
    <div class="four wide column">
        <div class="ui top attached header">@{{ label }} Role</div>
        <div class="ui attached segment">
            <form action="" method="POST" class="ui form" @submit.prevent="add()">
                @csrf
                <div class="field">
                    <div class="ui left icon input">
                        <input type="text" name="name" v-model="role.name" placeholder="Name...">
                        <i class="ion-pricetag icon"></i>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <input type="text" name="display_name" v-model="role.display_name" placeholder="Display Name...">
                        <i class="ion-pricetag icon"></i>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <input type="text" name="description" v-model="role.description" placeholder="Description...">
                        <i class="ion-pricetag icon"></i>
                    </div>
                </div>
                <div class="field">
                    <label for="">Attach Permissions</label>
                    <select name="permissions[]" class="ui fluid search dropdown" v-model="role.permissions" multiple>
                        <option v-for="permission in options.permissions" v-bind:value="permission.id" v-text="permission.display_name"></option>
                    </select>
                </div>
                <div class="field">
                    <button class="ui primary submit icon button"><i class="ion-plus-circled icon"></i> @{{ label }}</button>
                </div>
            </form>
        </div>
        <div class="ui section divider"></div>
        <a href="{{ route('role.permissions') }}" class="ui fluid primary icon button">Role - Permission Control</a>
    </div>
    <div class="twelve wide column">
        <div class="ui top attached header">List of Roles</div>
        <div class="ui attached segment">
            <table class="ui unstackable compact celled striped table">
                <thead>
                    <th class="center aligned">Name</th>
                    <th class="center aligned">Display Name</th>
                    <th class="center aligned">Description</th>
                    <th class="center aligned">Actions</th>
                </thead>
                <tbody>
                    <tr v-for="role in options.roles">
                        <td>@{{ role.name }}</td>
                        <td>@{{ role.display_name }}</td>
                        <td>@{{ role.description }}</td>
                        <td class="center aligned">
                            <button class="ui mini teal icon button" @click="edit(role.id)"><i class="ion-edit icon"></i> Edit</button>
                            <button class="ui mini red icon button" @click="destroy(role.id)"><i class="ion-trash-a icon"></i> Delete</button>
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
            role: {
                name : '',
                display_name : '',
                description : '',
                permissions : [],
            },
            options : {
                permissions : [],
                roles : [],
            },
            label : "Add",
            route : '{{ route('role.add') }}',
        },

        methods: {
            init() {
                this.getOptions(),
                $('.dropdown').dropdown();
            },

            add(){
                axios.post(this.route, this.$data.role)
                .then(response => {
                    $('form').form('clear'),
                    this.role = null,
                    toastr.success(response.data),
                    this.getOptions(),
                    this.route = '{{ route('role.add') }}';
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },

            getOptions(){
                axios.get('{{ route('user.options') }}')
                .then(response => {
                    this.options = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                })
            },

            edit(id){
                var route = "get/" + id;
            	axios.get(route)
            	.then((response) => {
            		this.role = response.data,
                    this.route = '{{ url('users/roles/update') }}' + '/' + id,
                    this.label = "Update";
            	})
            	.catch(error => {
            		console.log(error.response.data)
            	});
            },

            destroy(id){
            	swal({
            		title: 'Are you sure?',
            		text: "This Role will be Deleted",
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
            				this.getOptions(),
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
