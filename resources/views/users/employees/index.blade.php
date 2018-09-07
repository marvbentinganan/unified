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
            <a href="" class="section">Users</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('employees') }}" class="section">Employees</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        </div>
    </div>
    <div class="ui stackable two column padded grid">
        <div class="ten wide column">
            {{-- Employees table --}}
            <div class="row">
                <div class="ui top attached segment">
                    <div class="ui fluid icon input">
                        <input type="text" name="keyword" v-model="keyword" id="" placeholder="Search for Employee...">
                        <i class="inverted circular search icon"></i>
                    </div>
                </div>
                <div class="ui attached segment">
                    <table class="ui compact celled table">
                        <thead>
                            <th class="center aligned">ID Number</th>
                            <th class="center aligned">Name</th>
                            <th class="center aligned">Actions</th>
                        </thead>
                        <tbody>
                            <tr v-for="employee in filteredEmployees">
                                <th class="center aligned">@{{ employee.id_number }}</th>
                                <td>@{{ employee.fullname }}</td>
                                <td class="center aligned">
                                    <button class="ui mini teal icon button" @click="edit(employee.id)"><i class="ion-edit icon"></i></button>
                                    <button class="ui mini red icon button" @click="destroy(employee.id)"><i class="ion-trash-b icon"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="six wide column">
            <div class="row">
                <div class="ui top attached header">
                    <i class="ion-ios-personadd icon"></i>@{{ label }} Employee
                </div>
                <div class="ui attached segment">
                    <form action="" class="ui form" id="employee-form" @submit.prevent="addEmployee()">
                        @csrf
                        <div class="field">
                            <label for="">Firstname</label>
                            <div class="ui left icon input">
                                <input type="text" name="firstname" v-model="employee.firstname" placeholder="Firstname...">
                                <i class="ion-pricetag icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label for="">Lastname</label>
                            <div class="ui left icon input">
                                <input type="text" name="lastname" v-model="employee.lastname" placeholder="Lastname...">
                                <i class="ion-pricetag icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label for="">Middlename</label>
                            <div class="ui left icon input">
                                <input type="text" name="middlename" v-model="employee.middlename" placeholder="Middlename...">
                                <i class="ion-pricetag icon"></i>
                            </div>
                        </div>
                        <div class="two fields">
                            <div class="field">
                                <label for="">ID Number</label>
                                <div class="ui left icon input">
                                    <input type="text" name="middlename" v-model="employee.id_number" placeholder="ID Number...">
                                    <i class="ion-ios-barcode icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label for="">Suffix</label>
                                <div class="ui left icon input">
                                    <input type="text" name="suffix" v-model="employee.suffix" placeholder="Suffix...">
                                    <i class="ion-pricetag icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="two fields">
                            <div class="field">
                                 <label for="">Title</label>
                                <div class="ui left icon input">
                                    <input type="text" name="middlename" v-model="employee.title" placeholder="Title...">
                                    <i class="ion-ios-barcode icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label for="">Roles</label>
                                <select name="roles[]" class="ui fluid search dropdown" v-model="employee.roles" multiple>
                                    <option v-for="role in options.roles" v-bind:value="role.id" v-text="role.display_name"></option>
                                </select>
                            </div>
                        </div>
                        <div class="two fields">
                            <div class="field">
                                <label for="">Designations</label>
                                <select name="designations[]" class="ui fluid search dropdown" v-model="employee.designations" multiple>
                                    <option v-for="designation in options.designations" v-bind:value="designation.id" v-text="designation.name"></option>
                                </select>
                            </div>
                            <div class="field">
                                <label for="">Programs</label>
                                <select name="programs[]" class="ui fluid search dropdown" v-model="employee.programs" multiple>
                                    <option v-for="program in options.programs" v-bind:value="program.id" v-text="program.name"></option>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <button type="submit" class="ui primary submit icon button"><i class="save icon"></i> @{{ label }}</button>
                        </div>
                    </form>
                </div>
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
            keyword : undefined,
            employees : {},
            employee : {
                firstname : '',
                middlename : '',
                lastname : '',
                suffix : '',
                id_number : '',
                title : '',
                roles : [],
                designations : [],
                programs : [],
            },
            label : "Add",
            options : {
                roles : [],
                designations : [],
                programs : [],
            },
        },
        computed : {
            filteredEmployees(){
                let employees = this.employees
                if (this.keyword && this.keyword != null) {
                    employees = employees.filter((employee) => {
                        return employee.id_number.indexOf(this.keyword) !== -1
                    })
                }
                return employees
            }
        },
        methods: {
            init() {
                this.getEmployees(),
                this.getOptions(),
                $('.dropdown').dropdown();
            },

            getEmployees(){
                axios.get('{{ route('employee.get') }}')
                .then(response => {
                    this.employees = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                })
            },

            getOptions(){
                axios.get('{{ route('employee.options') }}') 
                .then(response => { 
                    this.options = response.data; 
                }) 
                .catch(error => { 
                    console.log(error.response.data);
                })
            },

            addEmployee(){
                axios.post('{{ route('employee.add') }}', this.$data.employee)
                .then(response => {
                    $('form').form('clear'),
                    this.employee = null,
                    this.getEmployees(),
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
            		this.employee = response.data,
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
