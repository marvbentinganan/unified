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
    <div class="ui stackable two column grid">
        <div class="twelve wide column">
            <div class="ui top attached borderless menu">
                <div class="header item"><i class="flask icon"></i>My Classes</div>
                <div class="right menu">
                    <a href="{{ route('class.add') }}" class="item"><i class="ion-plus icon"></i>Add New</a>
                </div>
            </div>
            <div class="ui attached segment" v-if="classes.length > 0">
                <div class="ui two doubling raised cards">
                    <div class="card" v-for="classlist in classes">
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
                    <i class="orange ion-alert-circled icon"></i> 
                    It looks like You have not created any classes yet.
                </div>
                <div class="ui section divider"></div>
                <a href="{{ route('class.add') }}" class="ui large primary button">Add Class</a>
            </div>
        </div>
        <div class="four wide column">
            
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