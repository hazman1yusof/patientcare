@extends('layouts.main')

@section('content')

<div class="ui teal segment" style="padding-bottom: 30px;">
    <div class="ui stackable four column grid">
        <div class="column" id="colmd_outer">
            <div id="mydate" gldp-id="mydate"></div>
            <div gldp-el="mydate" id="mydate_glpd" style="position:static;top:30px;left:0px;z-index:0;font-size: 28px;"></div>
        </div>

        <div class="eleven wide right floated column">
            <table id="jqGrid" class="table table-striped"></table>
            <div id="jqGridPager"></div>
        </div>
    </div>
</div>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-3.3.5-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/glDatePicker/styles/glDatePicker.default.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/trirand/css/trirand/ui.jqgrid-bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css">
@endsection

@section('js')
    <script type="text/ecmascript" src="{{ asset('assets/trirand/i18n/grid.locale-en.js') }}"></script>
    <script type="text/ecmascript" src="{{ asset('assets/trirand/jquery.jqGrid.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/glDatePicker/glDatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/glDatePicker/glDatePicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/emergency.js') }}"></script>
@endsection


