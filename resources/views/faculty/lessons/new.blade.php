@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush 
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="" class="section">Lesson Manager</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('lessons') }}" class="section">Lessons</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('lesson.new') }}" class="active section">New Lesson</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable two column grid">
        <div class="eleven wide column">
            <div class="ui gray top attached inverted header"><i class="ion-plus icon"></i>Add New Lesson</div>
            <div class="ui attached segment">
                <form action="" class="ui form" @submit.prevent="add()">
                    @csrf
                    <div class="field">
                        <div class="ui left icon input">
                            <input type="text" name="title" v-model="lesson.title" id="" placeholder="Enter Title of Lesson...">
                            <i class="ion-compose icon"></i>
                        </div>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label for="">Department</label>
                            <select name="department_id" class="ui fluid search dropdown" v-model="lesson.department_id" placeholder="Select Department...">
                                <option v-for="department in options.departments" v-bind:value="department.id" v-text="department.name"></option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="">Course / Strand</label>
                            <select name="program_id" class="ui fluid search dropdown" v-model="lesson.program_id" placeholder="Select Course / Strand...">
                                <option v-for="program in filteredPrograms" v-bind:value="program.id" v-text="program.code"></option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="">Subject</label>
                            <select name="subject_id" class="ui fluid search dropdown" v-model="lesson.subject_id" placeholder="Select Subject...">
                                <option v-for="subject in options.subjects" v-bind:value="subject.id" v-text="subject.code + ' - ' + subject.name"></option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label for="">Description</label>
                        <textarea name="description" v-model="lesson.description" id="" cols="15" rows="10"></textarea>
                    </div>
                    <div class="field">
                        <label for="">Objective</label>
                        <textarea name="objective" v-model="lesson.objective" id="" cols="15" rows="10"></textarea>
                    </div>
                    <div class="field">
                        <button type="submit" class="ui fade fluid animated primary submit icon button">
                            <div class="visible content">Add Lesson</div>
                            <div class="hidden content"><i class="ion-plus icon"></i></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="five wide column">
            <div class="ui gray inverted top attached header"><i class="ion-ios-browsers icon"></i> My Lessons</div>
            <div class="ui attached segment">
                <div class="ui relaxed list items" v-for="lesson in lessons">
                    <div class="item">
                        <div class="content">
                            <div class="header">@{{ lesson.title }}</div>
                            <div class="meta">
                                <span class="ui label"><i class="ion-cube icon"></i> @{{ lesson.department.name }}</span>
                                <span class="ui label"><i class="ion-briefcase icon"></i> @{{ lesson.program.code }}</span>
                                <span class="ui label"><i class="ion-beaker icon"></i> @{{ lesson.subject.code }}</span>
                            </div>
                            <div class="description">
                                @{{ lesson.description }}
                            </div>
                            <div class="extra">
                                <a :href="'chapters/' + lesson.code + '/add'" class="ui small right floated primary icon button"><i class="ion-plus icon"></i> Add Chapter</a>
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
            lessons : {},
            lesson : {
                title : '',
                department_id : '',
                program_id : '',
                subject_id : '',
                objective : '',
                description : '',
            },
            
            options : {
                subjects : {},
                departments : {},
                programs : {},
            }
        },
        
        computed : {
            filteredPrograms(){
                let programs = this.options.programs
                if (this.lesson.department_id && this.lesson.department_id != null) {
                    programs = programs.filter((program) => {
                        return program.department_id == this.lesson.department_id
                    })
                }
                return programs
            },
        },
        
        methods: {
            init() {
                this.list();
                this.lessonslist();
                $('.dropdown').dropdown();
            },
            
            resetForm(){
                this.lesson.title = '',
                this.lesson.department_id = '',
                this.lesson.program_id = '',
                this.lesson.subject_id = '',
                this.lesson.description = '',
                this.lesson.objective = '';
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
            
            lessonslist(){
                axios.get('{{ route('lessons.list') }}')
                .then(response => {
                    console.log(response.data),
                    this.lessons = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },
            
            add(){
                // console.log(this.$data.lesson);
                axios.post('{{ route('lesson.add') }}', this.$data.lesson)
                .then(response => {
                    this.list(),
                    this.lessonslist(),
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