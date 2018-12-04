@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('plugins/vuejs/vuejs-datepicker.min.js') }}"></script>


@endpush 
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="" class="section">Resources</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('school_years') }}" class="active section">School Years</a>
@endsection

@section('content')
<div class="sixteen wide column">
    <div class="ui stackable grid">
        <div class="column">
            <div class="ui top attached segment">
                <form action="" class="ui small form" @submit.prevent="add()">
                    @csrf
                    <div class="ui left icon action fluid input">
                        <i class="search icon"></i>
                        <input placeholder="Name" type="text" v-model="school_year.name">
                        <button type="submit" class="ui animated fade primary submit icon button">
                            <div class="visible content">@{{ label }}</div>
                            <div class="hidden content"><i class="ion-android-send icon"></i></div>
                        </button>
                    </div>
                </form>
            </div>
            <div class="ui attached segment">
                <table class="ui compact table">
                    <thead>
                        <th class="center aligned">Name</th>
                        <th class="center aligned">Status</th>
                        <th class="four wide center aligned">Actions</th>
                    </thead>
                    <tbody>
                        <tr v-for="syear in school_years">
                            <td>@{{ syear.name }}</td>
                            <td class="center aligned">
                                <span class="ui green label" v-if="syear.deleted_at == null">Active</span>
                                <span class="ui red label" v-else>Deleted</span>
                            </td>
                            <td class="center aligned">
                                <div class="ui mini buttons" v-if="syear.deleted_at == null">
                                    <button class="ui mini teal icon button" @click="get(syear.id)"><i class="ion-edit icon"></i></button>
                                    <button class="ui mini red icon button" @click="destroy(syear.id)"><i class="ion-trash-b icon"></i></button>
                                </div>
                                <div class="ui mini buttons" v-else>
                                    <button class="ui mini yellow icon button" @click="restore(syear.id)"><i class="ion-loop icon"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
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
            school_year : {
                name : ''
            },
            school_years : {},
            
            route : '{{ route('school_year.add') }}',
            label : 'Add School Year'
        },
        
        methods: {
            init() {
                this.list();
                $('.dropdown').dropdown();
            },
            
            list(){
                axios.get('{{ route('school_year.list') }}') 
                .then(response => { 
                    this.school_years = response.data; 
                }) 
                .catch(error => { 
                    console.log(error.response.data);
                })
            },
            
            add(){
                axios.post(this.route, this.$data.school_year)
                .then(response => {
                    this.list(),
                    this.school_year.name = '',
                    swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 }),
                    this.route = '{{ route('school_year.add') }}';
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },
            
            get(id){
                var route = "school_years/get/" + id;
                axios.get(route)
                .then((response) => {
                    this.school_year = response.data,
                    this.label = 'Update'
                    this.route = '{{ url('build/school_years/update') }}' + '/' + id;
                })
                .catch(error => {
                    console.log(error.response.data)
                });
            },
            
            destroy(id){ 
                swal({ 
                    title: 'Are you sure?', 
                    text: "This School Year will be Deleted", 
                    type: 'question', 
                    showCancelButton: true, 
                    confirmButtonColor: '#3085d6', 
                    cancelButtonColor: '#d33', 
                    confirmButtonText: 'Yes' 
                })
                .then((result) => { 
                    if (result.value) { 
                        var route = 'school_years/delete/' + id; 
                        axios.get(route) 
                        .then(response => { 
                            this.list(), 
                            swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 });
                        })
                        .catch(response => { 
                            toastr.error("Unable to Delete Department"); 
                        }); 
                    } }) 
                },
                
                restore(id){ 
                    swal({ 
                        title: 'Are you sure?', 
                        text: "This School Year will be Restored", 
                        type: 'question', 
                        showCancelButton: true, 
                        confirmButtonColor: '#3085d6', 
                        cancelButtonColor: '#d33', 
                        confirmButtonText: 'Yes' 
                    })
                    .then((result) => { 
                        if (result.value) { 
                            var route = 'school_years/restore/' + id; 
                            axios.get(route) 
                            .then(response => { 
                                this.list(), 
                                swal({ type: 'success', title: response.data, showConfirmButton: false, timer: 1500 });
                            })
                            .catch(response => { 
                                toastr.error("Unable to Restore School Year"); 
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