@extends('layouts.app') 
@push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('content') {{-- Breadcrumb --}}
<div class="row">
    <div class="ui breadcrumb">
        <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        <a href="" class="section">Users</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        <a href="{{ route('roles') }}" class="section">Roles</a>
        <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    </div>
</div>
<div class="ui section divider"></div>
<div class="ui stackable two column padded grid">
    <div class="four wide column">
        <div class="ui top attached header">@{{ label }} Role</div>
        <div class="ui attached segment">
            <form action="" method="POST" class="ui form" @submit.prevent="addRole()">
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
                    <button class="ui primary submit icon button"><i class="ion-plus-circled icon"></i> @{{ label }}</button>
                </div>
            </form>
        </div>
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
                    <tr v-for="role in roles">
                        <td>@{{ role.name }}</td>
                        <td>@{{ role.display_name }}</td>
                        <td>@{{ role.description }}</td>
                        <td class="two wide center aligned">
                            <button class="ui mini teal icon button" @click="edit(role.id)"><i class="ion-edit icon"></i></button>
                            <button class="ui mini red icon button"><i class="ion-trash-a icon"></i></button>
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
            roles : {},
            role: {
                name : '',
                display_name : '',
                description : '',
            },
            label : "Add",
        },
        methods: {
            init() {
                this.getRoles(),
                $('.dropdown').dropdown();
            },

            getRoles(){
                axios.get('{{ route('role.get') }}')
                .then(response => {
                    this.roles = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                })
            },

            addRole(){
                axios.post('{{ route('role.add') }}', this.$data.role)
                .then(response => {
                    $('form').form('clear'),
                    this.role = null,
                    this.getRoles(),
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
            		this.role = response.data,
                    this.label = "Update";
            	})
            	.catch(error => {
            		console.log(error.response.data)
            	});
            }
        },
        mounted() {
            this.init();
        }
    });
</script>
@endpush
