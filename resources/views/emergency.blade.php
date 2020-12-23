@extends('layouts.main')

@section('style')
    
.fc-toolbar .fc-center h2{
    color:#f2711c;
    margin-top:15px;
}

.fc-toolbar .fc-right {
    float: right;
    margin-left: 100px;
}

.fc-unthemed td.fc-today {
    background: rgb(251 189 8 / 0.2);
}

.selected_day {
    background: rgb(251 189 8 / 1) !important;
}

.h2 {
    text-align: center;
    color: #00b5ad !important;
}

.fc-event {
    position: relative;
    display: block;
    font-size: .85em;
    line-height: 1!important;
    border-radius: 50px !important;
    text-align: center !important;
    border: 1px solid #3a87ad;
    width: 10px;
}

@endsection

@section('content')

    <script>    
        var events = {!! json_encode($events) !!};
    </script>

    <div class="ui stackable two column grid">
        <!-- <div class="column" id="colmd_outer">
            <div id="mydate" gldp-id="mydate"></div>
            <div gldp-el="mydate" id="mydate_glpd" style="position:static;top:30px;left:0px;z-index:0;font-size: 28px;"></div>
        </div> -->


        <div class="five wide column"><div class="ui orange segment">
            <div id="calendar"></div>
        </div></div>

        <div class="eleven wide right floated column" style="margin:0px;">
            <div class="ui teal segment">
                <h2 class="h2">Patient List</h2>
            <table id="jqGrid" class="table table-striped"></table>
            <div id="jqGridPager"></div></div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-3.3.5-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/glDatePicker/styles/glDatePicker.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fullcalendar-3.7.0/fullcalendar.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/trirand/css/trirand/ui.jqgrid-bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css">
@endsection

@section('js')
    <script type="text/ecmascript" src="{{ asset('assets/trirand/i18n/grid.locale-en.js') }}"></script>
    <script type="text/ecmascript" src="{{ asset('assets/trirand/jquery.jqGrid.min.js') }}"></script>
    <script type="text/ecmascript" src="{{ asset('assets/fullcalendar-3.7.0/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/glDatePicker/glDatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/glDatePicker/glDatePicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/emergency.js') }}"></script>
@endsection


