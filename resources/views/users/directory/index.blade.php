@extends('layouts.app') 
@push('header_scripts')
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/dataTables.semanticui.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('plugins/datatables/css/buttons.dataTables.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/buttons.semanticui.min.css') }}">
<style>
    #dataTableBuilder{
        width: 100% !Important;
    }
    
    div.dt-buttons { 
        float: right; 
    }
    
    .sorting:after, .sorting_desc:after, .sorting_asc:after {
        bottom: 2px !important;
    }
</style>
@endpush
@section('breadcrumb')
<a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('users') }}" class="section">Users</a>
<div class="divider"><i class="blue ion-chevron-right icon"></i></div>
<a href="{{ route('active.directory') }}" class="active section">Active Directory</a>
@endsection
@section('content')
<div class="row">
    <div class="ui padded grid">
        <div class="sixteen wide column">
            <div>
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/dataTables.semanticui.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/buttons.semanticui.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}
<script>
    $('#dataTableBuilder').addClass('ui compact small responsive celled table');
</script>
@endpush