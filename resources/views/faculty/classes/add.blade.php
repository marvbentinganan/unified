@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="" class="section">Class Manager</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('class.add') }}" class="active section">Add New Class</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable two column grid">
        <div class="ten wide column">
            <div class="ui top attached header"><i class="ion-plus icon"></i> Add New Class</div>
            <div class="ui attached segment">
                <form action="" class="ui form" @submit.prevent="add()">
                    @csrf
                    <div class="field">
                        <label for="">Section</label>
                        <div class="ui left icon input">
                            <input type="text" name="section" v-model="myclass.section" placeholder="Section...">
                            <i class="ion-ios-pricetag icon"></i>
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="field">
                            <label for="">Department</label>
                            <select name="department_id" class="ui fluid search dropdown" v-model="myclass.department_id" placeholder="Select Department...">
                                <option v-for="department in options.departments" v-bind:value="department.id" v-text="department.name"></option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="">Course / Strand</label>
                            <select name="program_id" class="ui fluid search dropdown" v-model="myclass.program_id" placeholder="Select Course / Strand...">
                                <option v-for="program in filteredPrograms" v-bind:value="program.id" v-text="program.code"></option>
                            </select>
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="field">
                            <label for="">Year Level</label>
                            <select name="year_level_id" class="ui fluid search dropdown" v-model="myclass.year_level_id" placeholder="Select Year Level...">
                                <option v-for="year_level in filteredYearLevels" v-bind:value="year_level.id" v-text="year_level.name"></option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="">Subject</label>
                            <select name="subject_id" class="ui fluid search dropdown" v-model="myclass.subject_id" placeholder="Select Subject...">
                                <option v-for="subject in options.subjects" v-bind:value="subject.id" v-text="subject.code + ' - ' + subject.name"></option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <button type="submit" class="ui animated fade primary submit icon button">
                            <div class="visible content"><i class="ion-ios-plus icon"></i>Add New Class</div>
                            <div class="hidden content"><i class="ion-plus icon"></i></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="six wide column">
            <div class="ui top attached header"><i class="ion flask icon"></i> My Classes</div>
            <div class="ui attached segment">
                <div class="ui relaxed divided items" >
                    <div class="item" v-for="classlist in classes">
                        <div class="image">
                            <img src="{{ asset('images/students.jpg') }}" alt="">
                        </div>
                        <div class="content">
                            <div class="header">@{{ classlist.name }}</div>
                            <div class="meta">
                                <span class="date"><i class="ion-cube icon"></i> @{{ classlist.section }}</span>
                                <span class="date"><i class="ion-erlenmeyer-flask icon"></i> @{{ classlist.subject.name }}</span>
                            </div>
                            <div class="extra content">
                                <div class="ui two mini buttons">
                                    <a :href="'view/' + classlist.code" class="ui blue icon button"><i class="ion-share icon"></i></a>
                                    <a href="" class="ui red icon button"><i class="ion-trash-a icon"></i></a>
                                </div>
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
            classes : {},
            myclass : {
                section : '',
                department_id : '',
                program_id : '',
                year_level_id : '',
                subject_id : '',
            },

            options : {
                subjects : {},
                departments : {},
                programs : {},
                year_levels : {},
            }
        },

        computed : {
            filteredPrograms(){
                let programs = this.options.programs
                if (this.myclass.department_id && this.myclass.department_id != null) {
                    programs = programs.filter((program) => {
                        return program.department_id == this.myclass.department_id
                    })
                }
                return programs
            },

            filteredYearLevels(){
                let year_levels = this.options.year_levels
                if (this.myclass.department_id && this.myclass.department_id != null) {
                    year_levels = year_levels.filter((year_level) => {
                        return year_level.department_id == this.myclass.department_id
                    })
                }
                return year_levels
            }
        },
        
        methods: {
            init() {
                this.list();
                this.classlist();
                $('.dropdown').dropdown();
            },

            resetForm() {
                this.myclass.section = '',
                this.myclass.department_id = '',
                this.myclass.program_id = '',
                this.myclass.subject_id = '',
                this.myclass.year_level_id = '';
            },

            list(){
                axios.get('{{ route('class.options') }}')
                .then(response => {
                    this.options = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },
            
            classlist(){
                axios.get('{{ route('class.list') }}')
                .then(response => {
                    this.classes = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },

            add(){
                axios.post('{{ route('class.add') }}', this.$data.myclass)
                .then(response => {
                    this.list(),
                    this.classlist(),
                    this.resetForm(), 
                    swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 });
                })
                .catch(error => {
                    console.log(error.response.data),
                    swal({ type: 'error', title: error.response.data, showConfirmButton: false, timer: 1500 });
                });
            },

        },
        mounted() {
            this.init();
        }
    });
</script>
@endpush