@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('plugins/vuejs/vuejs-datepicker.min.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('users') }}" class="section">Users</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('students') }}" class="active section">Students</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable two column grid">
        {{-- Students table --}}
        <div class="ten wide column">
            <div class="row">
                <div class="ui top attached segment">
                    <div class="ui fluid icon input">
                        <input type="text" name="keyword" v-model="keyword" id="" placeholder="Search for Student...">
                        <i class="inverted circular search icon"></i>
                    </div>
                </div>
                <div class="ui attached segment">
                    <table class="ui small unstackable compact celled striped table">
                        <thead>
                            <th class="center aligned">ID Number</th>
                            <th class="center aligned">Name</th>
                            <th class="center aligned">Department</th>
                            <th class="center aligned">Actions</th>
                        </thead>
                        <tbody>
                            <tr v-for="student in filteredStudents">
                                <th class="center aligned">@{{ student.id_number }}</th>
                                <td>@{{ student.fullname }}</td>
                                <td>@{{ student.department.name }}</td>
                                <td class="center aligned">
                                    <div class="ui mini buttons">
                                        <button class="ui mini teal icon button" @click="edit(student.id)"><i class="ion-edit icon"></i></button>
                                        <button class="ui mini red icon button" @click="destroy(student.id)"><i class="ion-trash-b icon"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--  Add Student Form  --}}
        <div class="six wide column">
            <div class="row">
                <div class="ui top attached header">
                    <i class="ion-ios-personadd icon"></i>@{{ label }} Student
                </div>
                <div class="ui attached segment">
                    <form action="" class="ui small form" id="student-form" @submit.prevent="addStudent()">
                        @csrf
                        <div class="field">
                            <label for="">Firstname</label>
                            <div class="ui left icon input">
                                <input type="text" name="firstname" v-model="student.firstname" placeholder="Firstname...">
                                <i class="ion-pricetag icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label for="">Lastname</label>
                            <div class="ui left icon input">
                                <input type="text" name="lastname" v-model="student.lastname" placeholder="Lastname...">
                                <i class="ion-pricetag icon"></i>
                            </div>
                        </div>
                        <div class="two fields">
                            <div class="field">
                                <label for="">Middlename</label>
                                <div class="ui left icon input">
                                    <input type="text" name="middlename" v-model="student.middlename" placeholder="Middlename...">
                                    <i class="ion-pricetag icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label for="">Suffix</label>
                                <div class="ui left icon input">
                                    <input type="text" name="suffix" v-model="student.suffix" placeholder="Suffix...">
                                    <i class="ion-pricetag icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="two fields">
                            <div class="field">
                                <label>Date of Birth</label>
                                <vuejs-datepicker v-model="student.date_of_birth" name="date_of_birth" typeable></vuejs-datepicker>
                            </div>
                            <div class="field">
                                <label for="">ID Number</label>
                                <div class="ui left icon input">
                                    <input type="text" name="middlename" v-model="student.id_number" placeholder="ID Number...">
                                    <i class="ion-ios-barcode icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <button type="submit" class="ui animated fade fluid primary submit icon button">
                                <div class="visible content">@{{ label }} Student</div>
                                <div class="hidden content"><i class="ion-plus icon"></i></div> 
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="ui section divider"></div>
            <div class="row">
                <div class="ui top attached header"><i class="ion-upload icon"></i> Upload Students</div>
                <div class="ui attached segment">
                    <form action="{{ route('students.upload') }}" method="POST" class="ui small form" id="uploadForm" enctype="multipart/form-data">
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
            <div class="ui section divider"></div>
            <div class="row">
                <div class="ui top attached header"><i class="ion-upload icon"></i> SHS Students Management</div>
                <div class="ui attached segment">
                    <div class="ui mini info icon message">
                        <i class="ion-alert icon"></i>
                        <div class="content">
                            <div class="header">Instruction</div>
                            <p>Create an Excel File with a list of Student ID Numbers of Enrolled Students.</p>
                        </div>
                    </div>
                    <form action="{{ route('users.audit') }}" method="POST" class="ui small form" id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <div class="field">
                            <div class="ui input">
                                <input type="file" name="doc" id="file" placeholder="Select File...">
                            </div>
                        </div>
                        <div class="field">
                            <button type="submit" class="ui animated fade fluid primary icon button">
                                <div class="visible content">Remove Inactive Users</div>
                                <div class="hidden content"><i class="ion-upload icon"></i></div>
                            </button>
                        </div>
                    </form>
                    <div class="ui section divider"></div>
                    <a href="{{ route('users.restore') }}" class="ui animated fade fluid primary icon button">
                        <div class="visible content">Restore Users</div>
                        <div class="hidden content"><i class="ion-loop icon"></i></div>
                    </a>
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
            students : {},
            student : {
                firstname : '',
                middlename : '',
                lastname : '',
                suffix : '',
                id_number : '',
                date_of_birth : '',
            },
            label : "Add",
            route : '{{ route('student.add') }}',
        },
        components: { vuejsDatepicker },
        computed : {
            filteredStudents(){
                let students = this.students
                if (this.keyword && this.keyword != null) {
                    students = students.filter((student) => {
                        let data = student.id_number.indexOf(this.keyword) !== -1 || student.firstname.indexOf(this.keyword) !== -1 || student.lastname.indexOf(this.keyword) !== -1
                        return data
                    })
                }
                return students
            }
        },
        methods: {
            init() {
                this.getStudents(),
                $('.dropdown').dropdown();
            },
            
            resetForm(){
                this.student.firstname = '', 
                this.student.middlename = '', 
                this.student.lastname = '', 
                this.student.suffix = '', 
                this.student.id_number = '', 
                this.student.date_of_birth = '',
                this.label = "Add", 
                this.route = '{{ route('student.add') }}';
            },
            
            getStudents(){
                axios.get('{{ route('student.get') }}')
                .then(response => {
                    this.students = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                })
            },
            
            addStudent(){
                axios.post(this.route, this.$data.student)
                .then(response => {
                    this.getStudents(),
                    this.resetForm(),
                    swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 });
                })
                .catch(error => {
                    console.log(error.response.data);
                    swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 });
                });
            },
            
            edit(id){
                var route = "get/" + id;
                axios.get(route)
                .then((response) => {
                    this.student = response.data,
                    this.label = "Update", 
                    this.route = '{{ url('users/students/update') }}' + '/' + id;
                })
                .catch(error => {
                    console.log(error.response.data)
                });
            },
            
            destroy(id){ 
                swal({ 
                    title: 'Are you sure?', 
                    text: "Student Account will be Deleted", 
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
                            toastr.error("Unable to Delete Student Account"); 
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
    