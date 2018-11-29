@extends('layouts.app') 
@push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="" class="section">Class Manager</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('my.classes') }}" class="active section">My Classes</a>
@endsection
@section('content')
<div class="sixteen wide column">
    <div class="ui stackable padded column grid">
        @role('faculty|management')
        <div class="row">
            <div class="ui top attached borderless menu">
                <div class="header item"><i class="flask icon"></i>My Classes</div>
                <div class="right menu">
                    <a href="{{ route('class.add') }}" class="item"><i class="ion-plus icon"></i>Add New</a>
                </div>
            </div>
            <div class="ui attached segment" v-if="classes.mine.length > 0">
                <div class="ui three doubling raised cards">
                    <div class="card" v-for="classlist in classes.mine">
                        <div class="image">
                            <img src="{{ asset('images/students.jpg') }}" alt="">
                        </div>
                        <div class="content">
                            <div class="header">@{{ classlist.name }}</div>
                            <div class="meta">
                                <span class="date"><i class="ion-cube icon"></i> @{{ classlist.section }}</span>
                                <span class="date"><i class="ion-erlenmeyer-flask icon"></i> @{{ classlist.subject.name }}</span>
                            </div>
                        </div>
                        <div class="extra content">
                            <div class="ui two mini buttons">
                                <a :href="'view/' + classlist.code" class="ui primary icon button"><i class="ion-share icon"></i></a>
                                <a href="" class="ui red icon button"><i class="ion-trash-a icon"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui attached secondary placeholder center aligned segment" v-else>
                <div class="ui icon header">
                    <i class="orange ion-alert-circled icon"></i> It looks like you have not created any classes yet.
                </div>
                <div class="ui section divider"></div>
                <a href="{{ route('class.add') }}" class="ui large primary button">Add Class</a>
            </div>
        </div>
        @endrole
        @role('administrator|management')
        <div class="row">
            <div class="ui top attached borderless menu">
                <div class="header item"><i class="flask icon"></i>All Classes</div>
            </div>
            <div class="ui attached segment" v-if="classes.all != null">
                <table class="ui small table">
                    <thead>
                        <th class="center aligned">Name</th>
                        <th class="center aligned">Code</th>
                        <th class="center aligned">Section</th>
                        <th class="center aligned">Department</th>
                        <th class="center aligned">Program</th>
                        <th class="center aligned">Subject</th>
                        <th class="center aligned">Actions</th>
                    </thead>
                    <tbody>
                        <tr v-for="list in classes.all">
                            <td>@{{ list.name }}</td>
                            <td class="center aligned">@{{ list.code }}</td>
                            <td class="center aligned">@{{ list.section }}</td>
                            <td>@{{ list.department.name }}</td>
                            <td>@{{ list.program.name }}</td>
                            <td>@{{ list.subject.name }}</td>
                            <td class="center aligned">
                                <div class="ui mini rounded buttons">
                                    <a :href="'view/' + list.code" class="ui primary icon button"><i class="ion-share icon"></i></a>
                                    <a href="" class="ui red icon button"><i class="ion-trash-a icon"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="ui attached secondary placeholder center aligned segment" v-else>
                <div class="ui sub header">No Classes Found</div>
            </div>
        </div>
        @endrole
    </div>
</div>
@endsection
@push('footer_scripts')
<script>
    new Vue({
		el: '#app',
		data: {
            classes : {
                mine : {},
                all : {},
            },
        },
        
        methods: {
            init() {
                this.classlist();
                $('.dropdown').dropdown();
            },
            
            classlist(){
                axios.get('{{ route('class.list') }}')
                .then(response => {
                    console.log(response.data),
                    this.classes = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },
        },
        mounted() {
            this.init();
        }
    });
    
</script>
@endpush