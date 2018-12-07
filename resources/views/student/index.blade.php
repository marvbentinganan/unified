@extends('layouts.uikit') 
@push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush 
@section('breadcrumb')

@endsection
 
@section('content')
<div class="uk-section">
    <div class="uk-container">
        {{-- <h1 class="uk-heading-divider">My Classes</h1> --}}
        <nav class="uk-navbar-container uk-margin" uk-navbar="boundary-align: true; align: center;">
            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <li>
                        <h3>
                            <span class="uk-icon uk-margin-small-right" uk-icon="icon: thumbnails; ratio: 1.5;"></span>
                            My Classes
                        </h3>
                    </li>
                </ul>
            </div>
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav">
                    <li>
                        <div class="uk-navbar-item">
                            <button uk-toggle="target: #addclass" type="button" class="uk-button uk-button-primary uk-button-small" uk-toggle>Join Class</button>
                        </div>
                        
                    </li>
                </ul>
            </div>
        </nav>
        <div class="uk-child-width-1-3@m" uk-grid>
            <div v-for="list in lists">
                <div class="uk-card uk-card-small uk-card-default uk-card-hover uk-animation-scale-up">
                    <a :href="'student/lms/class/show/' + list.code" class="uk-card-media-top">
                        <img src="{{ asset('images/students.jpg') }}" alt="">
                    </a>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title">@{{ list.name }}</h3>
                        <p>
                            <span class="uk-label">@{{ list.code }}</span>
                            <span class="uk-label">@{{ list.program.code }}</span>
                            <span class="uk-label">@{{ list.subject.name }}</span>
                        </p>
                    </div>
                    {{-- <div class="uk-card-footer">
                        <a href="" class="uk-button uk-button-default uk-width-1-1">Open</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div id="addclass" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Join a Class</h2>
        </div>
        <div class="uk-modal-body">
            <form class="uk-grid-small" action="" method="POST" uk-grid @submit.prevent="join()">
                @csrf
                <div class="uk-width-2-3@s">
                    <input class="uk-input" name="code" v-model="myclass.code" type="text" placeholder="Class Code...">
                </div>
                <div class="uk-width-1-3@s">
                    <button type="submit" class="uk-button uk-button-primary uk-width-1-1">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('footer_scripts')
<script>
    new Vue({
		el: '#app',
		data: {
            myclass : {
                code : ''
            },
            lists : {},

        },
        
        methods: {
            init() {
                this.list();
            },

            list(){
                axios.get('{{ route('student.list.class') }}') 
                .then(response => { 
                    this.lists = response.data; 
                }) 
                .catch(error => { 
                    console.log(error.response.data);
                })
            },

            join(){
                axios.post('{{ route('student.join.class') }}', this.$data.myclass)
                .then(response => {
                    this.list(),
                    this.myclass.code = '',
                    swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 });
                })
                .catch(error => {
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