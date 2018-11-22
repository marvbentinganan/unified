@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>

@endpush 
@section('content')
<div class="sixteen wide column">
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="ui breadcrumb segment">
            <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="" class="section">Class Manager</a>
            <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
            <a href="{{ route('my.classes') }}" class="active section">My Classes</a>
        </div>
    </div>
    <div class="ui section divider"></div>
    <div class="ui stackable very padded two column grid">
        <div class="ten wide column">
            <div class="ui top attached header"><i class="ion flask icon"></i> My Classes</div>
            <div class="ui attached segment">
                <div class="ui three doubling raised cards">
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
                                <a :href="'view/' + classlist.code" class="ui blue icon button"><i class="ion-share icon"></i></a>
                                <a href="" class="ui red icon button"><i class="ion-trash-a icon"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="six wide column">
            
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