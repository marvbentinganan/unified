@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('plugins/vuejs/vuejs-datepicker.min.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('users') }}" class="section">Users</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('employees') }}" class="active section">Employees</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable two column grid">
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
                    <table class="ui small compact celled table">
                        <thead>
                            <th class="center aligned">ID Number</th>
                            <th class="center aligned">Name</th>
                            <th class="center aligned">Designation</th>
                            <th class="center aligned">Actions</th>
                        </thead>
                        <tbody>
                            <tr v-for="employee in filteredEmployees">
                                <th class="center aligned">@{{ employee.id_number }}</th>
                                <td>@{{ employee.firstname }} @{{ employee.lastname }}</td>
                                <td class="center aligned">
                                    <span class="ui small teal label">Regular Employee</span>
                                    <span class="ui small green label" v-if="employee.is_faculty == true">Faculty</span>
                                    <span class="ui small purple label" v-if="employee.is_manager == true">Supervisor</span>
                                </td>
                                <td class="center aligned">
                                    <div class="ui mini buttons">
                                        <a :href="'show/' + employee.id" class="ui blue icon button"><i class="ion-eye icon"></i></a>
                                        <button class="ui teal icon button" @click="edit(employee.id)"><i class="ion-edit icon"></i></button>
                                        <button class="ui red icon button" @click="destroy(employee.id)"><i class="ion-trash-b icon"></i></button>
                                    </div>
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
                                <div class="ui checkbox">
                                    <input name="is_faculty" type="checkbox" v-model="employee.is_faculty">
                                    <label>Faculty</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui checkbox">
                                    <input name="is_manager" type="checkbox" v-model="employee.is_manager">
                                    <label>Manager</label>
                                </div>
                            </div>
                        </div>
                        <div class="field" v-show="employee.is_faculty == true">
                            <label for="">Programs</label>
                            <select name="programs[]" class="ui fluid search dropdown" v-model="employee.programs" multiple>
                                <option v-for="program in options.programs" v-bind:value="program.id" v-text="program.name"></option>
                            </select>
                        </div>
                        <div class="field">
                            <button type="submit" class="ui primary submit icon button"><i class="save icon"></i> @{{ label }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="ui section divider"></div>
            <div class="row">
                <div class="ui top attached header"><i class="ion-upload icon"></i> Upload Employees</div>
                <div class="ui attached segment">
                    <form action="{{ route('employees.upload') }}" method="POST" class="ui form" id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <div class="field">
                            <div class="ui input">
                                <input type="file" name="doc" id="file" placeholder="Select File...">
                            </div>
                        </div>
                        <div class="field">
                            <button type="submit" class="ui animated fade fluid primary icon button">
                                <div class="visible content">Upload</div>
                                <div class="hidden content"><i class="ion-upload icon"></i></div>
                            </button>
                        </div>
                    </form>
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
            keyword : undefined,
            employees : {},
            employee : {
                firstname : '',
                middlename : '',
                lastname : '',
                suffix : '',
                id_number : '',
                title : '',
                is_faculty : false,
                is_manager : false,
                roles : [],
                programs : [],
            },
            label : "Add",
            options : {
                roles : [],
                programs : [],
            },
            route : '{{ route('employee.add') }}',
        },
        computed : {
            filteredEmployees(){
                let employees = this.employees
                if (this.keyword && this.keyword != null) {
                    employees = employees.filter((employee) => {
                        let data = employee.id_number.indexOf(this.keyword) !== -1 || employee.firstname.indexOf(this.keyword) !== -1 || employee.lastname.indexOf(this.keyword) !== -1
                        return data
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

            resetForm(){
                this.employee.firstname = '',
                this.employee.middlename = '',
                this.employee.lastname = '',
                this.employee.suffix = '',
                this.employee.id_number = '',
                this.employee.title = '',
                this.employee.is_faculty = false,
                this.employee.is_manager = false,
                this.employee.roles = [],
                this.employee.programs = [],
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
                axios.post(this.route, this.$data.employee)
                .then(response => {
                    this.getEmployees(),
                    this.resetForm(),
                    this.route = '{{ route('employee.add') }}',
                    swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 });
                    
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
                    this.label = "Update",
                    this.route = '{{ url('users/employees/update') }}' + '/' + id;
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
