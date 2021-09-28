@extends('layouts.main')

@section('style')
    
.fc-toolbar .fc-center h2{
    color:#f2711c;
    margin-top:15px;
}

.fc-toolbar .fc-right {
    float: right;
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
    font-size: large !important;
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

.fc-listMonth-button:before{
    font-family: "FontAwesome";  
    content: "\f03a";
    padding-right: 5px;
}

.fc-month-button:before{
    font-family: "FontAwesome";
    content: "\f073";
    padding-right: 5px;
}

.fc-button{
    height: 2.8em !important;
}

.myb{
    font-size: large;
}

.mysmall{
    font-weight: 900;
    color:#f2711c;
}

.glyphicon-chevron-up,.glyphicon-chevron-down{
    float:right;
}

.panel-heading.collapsed .glyphicon-chevron-up,
.panel-heading .glyphicon-chevron-down {
    display: none;
}

.panel-heading.collapsed .glyphicon-chevron-down,
.panel-heading .glyphicon-chevron-up {
    display: inline-block;
}

.table.diatbl{
    font-size: 11px;
    width: 85% !important;
    margin: auto;
}

.table.diatbl td{
    padding: 4px !important;
}

.ui.form.diaform {
    font-size: smaller;
    width: 85% !important;
    margin: auto;
}

.ui.form.diaform div.field{
    padding: 0px 8px !important;
}

.panel-heading#toggle_doctornote, .panel-heading#toggle_trans{
    position: sticky;
    top: 40px;
    z-index: 3;
}

#showSidebar{
    background: rgb(255 255 255 / 0%) !mportant;
}

.metal{
    font-size: 0.8em;
    color: rgba(0,0,0,.4);
}
table#jqGrid, table#jqGrid_trans{
    font-size: 11px;
}
.help-block {
    display: block;
    margin-top: 0px !important;
    margin-bottom: 0px !important;
    color: #737373;
}
.ui.checkbox.completed{
    position: absolute;
    top: 10px;
    right: 20px;
}
.sticky_div{
    position: fixed;
    top: 100px;
    left: 16px;
}


@endsection

@section('content')

    <input type="hidden" id="curr_user" value="{{ Auth::user()->username }}">
    <input type="hidden" id="doctornote_route" value="{{route('doctornote_route')}}">
    <div class="ui stackable two column grid">
        <div class="eight wide tablet five wide computer column"><div class="ui orange segment">
            <div id="calendar"></div>
        </div></div>

        <div class="eight wide tablet eleven wide computer right floated column" style="margin:0px;">
            <div class="ui teal segment" style="padding-bottom: 30px;">
                <h2 class="h2">Patient List</h2>
                <table id="jqGrid" class="table table-striped"></table>
                <div id="jqGridPager"></div>
                <div style="float: right;">
                    <i class="btn play icon" id="timer_play" style="position: inherit;color: black; padding: 5px 50px 10px 10px;"><small>Play</small></i>
                    <i class="btn stop icon" id="timer_stop" style="position: inherit;color: black; padding: 5px 50px 10px 10px;"><small>Stop</small></i>
                </div>
            </div>
        </div>
    </div>

    <input id="user_dept" name="user_dept" value="{{ Auth::user()->dept }}" type="hidden">
    <input id="sel_date" name="sel_date" value="{{ \Carbon\Carbon::now()->toDateString() }}" type="hidden">
    <input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">

    <div class="panel panel-default" style="position: relative;margin: 10px 0px 10px 0px" id="doctornote_panel">
        <div class="panel-heading clearfix collapsed" id="toggle_doctornote" >

        <b>NAME: <span id="name_show_doctorNote"></span></b><br>
        MRN: <span id="mrn_show_doctorNote"></span>
        SEX: <span id="sex_show_doctorNote"></span>
        DOB: <span id="dob_show_doctorNote"></span>
        AGE: <span id="age_show_doctorNote"></span>
        RACE: <span id="race_show_doctorNote"></span>
        RELIGION: <span id="religion_show_doctorNote"></span><br>
        OCCUPATION: <span id="occupation_show_doctorNote"></span>
        CITIZENSHIP: <span id="citizenship_show_doctorNote"></span>
        AREA: <span id="area_show_doctorNote"></span> 

        <i class="glyphicon glyphicon-chevron-up" style="font-size:24px;margin: 0 0 0 12px" data-toggle="collapse" data-target="#tab_doctornote"></i>
        <i class="glyphicon glyphicon-chevron-down" style="font-size:24px;margin: 0 0 0 12px" data-toggle="collapse" data-target="#tab_doctornote"></i >
        <div style="position: absolute;
                        padding: 0 0 0 0;
                        right: 320px;
                        top: 48px;">
            <h5><strong>Doctor Note</strong>&nbsp;&nbsp;
                <span class="metal"></span></h5>
        </div> 

            <div class="btn-group btn-group-sm pull-right" role="group" aria-label="..." 
                id="btn_grp_edit_doctorNote"
                style="position: absolute;
                        padding: 0 0 0 0;
                        right: 60px;
                        top: 40px;" 

            >
                <button type="button" class="btn btn-default" id="new_doctorNote">
                    <span class="fa fa-plus-square-o"></span> New
                </button>
                <button type="button" class="btn btn-default" id="edit_doctorNote">
                    <span class="fa fa-edit fa-lg"></span> Edit
                </button>
                <button type="button" class="btn btn-default" data-oper='add' id="save_doctorNote">
                    <span class="fa fa-save fa-lg"></span> Save
                </button>
                <button type="button" class="btn btn-default" id="cancel_doctorNote">
                    <span class="fa fa-ban fa-lg" aria-hidden="true"> </span> Cancel
                </button>
            </div>
        </div>

        <div id="tab_doctornote" class="panel-collapse collapse">
            <div class="panel-body">
                @include('doctornote_div')
            </div>
        </div>
    </div>

    <div class="panel panel-default" style="position: relative;margin: 10px 0px 10px 0px" id="transaction_panel">
        <div class="panel-heading clearfix collapsed" id="toggle_trans" data-toggle="collapse" data-target="#tab_trans">

        <i class="glyphicon glyphicon-chevron-up" style="font-size:24px;margin: 0 0 0 12px"></i>
        <i class="glyphicon glyphicon-chevron-down" style="font-size:24px;margin: 0 0 0 12px"></i >
        <div>
            <h5><strong>Order Entry</strong>&nbsp;&nbsp;
                <span class="metal"></span></h5>
        </div> 
        </div>

        <div id="tab_trans" class="panel-collapse collapse">
            <div class="panel-body">
                @include('transaction_charges')
            </div>
        </div>
    </div>

    <!-- <div class="eight wide tablet eleven wide computer column" style="margin:0px;">
        <div class="ui teal segment" id="jqGrid_trans_c">
            <h2 class="h2">Patient List</h2>
            <table id="jqGrid_trans" class="table table-striped"></table>
            <div id="jqGrid_transPager"></div>
        </div>
    </div> -->

@include('itemselector')
@endsection

@section('css')
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" crossorigin="anonymous">
<!-- 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fullcalendar-3.7.0/fullcalendar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/trirand/css/trirand/ui.jqgrid-bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@300;500&family=Open+Sans:wght@300;700&family=Syncopate&display=swap" rel="stylesheet">
@endsection

@section('js')
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <script type="text/ecmascript" src="{{ asset('assets/trirand/i18n/grid.locale-en.js') }}"></script>
    <script type="text/ecmascript" src="{{ asset('assets/trirand/jquery.jqGrid.min.js') }}"></script>
    <script type="text/ecmascript" src="{{ asset('assets/fullcalendar-3.7.0/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/ecmascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script type="text/ecmascript" src="{{ asset('assets/waypoints/lib/jquery.waypoints.min.js') }}/"></script>
    <script type="text/ecmascript" src="{{ asset('assets/form-validator/jquery.form-validator.min.js') }}/"></script>
	<script type="text/javascript" src="{{ asset('js/doctornote_main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/doctornote.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/transaction.js') }}"></script>
@endsection


