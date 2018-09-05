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
            <a href="{{ route('students') }}" class="section">Students</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
        </div>
    </div>
    <div class="ui stackable two column padded grid">
        <div class="ten wide column">
            {{-- Students table --}}
            <div class="row">
                <div class="ui top attached segment">
                    <div class="ui fluid icon input">
                        <input type="text" name="keyword" v-model="keyword" id="" placeholder="Search for Student...">
                        <i class="inverted circular search icon"></i>
                    </div>
                </div>
                <div class="ui attached segment">
                    <table class="ui compact celled table">
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
                                    <button class="ui mini teal icon button" @click="edit(student.id)"><i class="ion-edit icon"></i></button>
                                    <button class="ui mini red icon button" @click="destroy(student.id)"><i class="ion-trash-b icon"></i></button>
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
                    <i class="ion-ios-personadd icon"></i>@{{ label }} Student
                </div>
                <div class="ui attached segment">
                    <form action="" class="ui form" id="student-form" @submit.prevent="addStudent()">
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
                            <button type="submit" class="ui primary submit icon button"><i class="save icon"></i> @{{ label }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="ui section divider"></div>
            <div class="row">
                <div class="ui top attached header"><i class="ion-upload icon"></i> Upload Students</div>
                <div class="ui attached segment">
                    <form action="{{ route('students.upload') }}" method="POST" class="ui form" id="uploadForm" enctype="multipart/form-data">
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
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
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
        },
        components: { vuejsDatepicker },
        computed : {
            filteredStudents(){
                let students = this.students
                if (this.keyword && this.keyword != null) {
                    students = students.filter((student) => {
                        return student.fullname.indexOf(this.keyword) !== -1
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
                axios.post('{{ route('student.add') }}', this.$data.student)
                .then(response => {
                    $('form').form('clear'),
                    this.student = null,
                    this.getStudents(),
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
            		this.student = response.data,
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
