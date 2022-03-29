@extends('layouts.main')

@section('style')

.wrap{
    word-wrap: break-word;
    white-space: pre-line !important;
    vertical-align: top !important;
}
    
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

.ui-jqgrid .inline-edit-cell {
    height: 46 px;
    padding: 10 px 16 px;
    font-size: 13px;
    line-height: 1.3333333;
    border-radius: 6 px;
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

.panel-heading#toggle_doctornote, .panel-heading#toggle_trans, .panel-heading#toggle_diet{
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
    position: fixed !important;
    top: 130px;
    left: 19px;
}

table#medication_tbl tbody td {
    font-size:12px;
}

table#medication_tbl {
  position: relative;
}

table#medication_tbl th {
  background: white;
  position: sticky;
  top: 0; /* Don't forget this, required for the stickiness */
  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
}

.form-control[disabled] {
    background-color: #fff !important;
    color: #1a1a1a;
}
<!-- 
.input-lg{
    font-size: 16px !important;
}
 -->
@endsection

@section('content')

    <input type="hidden" id="curr_user" value="{{ Auth::user()->username }}">
    <input type="hidden" id="doctornote_route" value="{{route('doctornote_route')}}">

    

    <div class="ui stackable two column grid">
        <div class="five wide tablet five wide computer column" id="calendar_div">
            <div class="ui orange segment" style="z-index:100">
                <div id="calendar"></div>
            </div>
        </div>

        <div class="eleven wide tablet eleven wide computer right floated column" style="margin:0px;"  id="jqgrid_div">
            <div class="ui teal segment" style="padding-bottom: 40px;">
                
                <div class="if_tablet left floated" style="display:none;">
                    <div class="ui calendar" id="button_calendar">
                        <button class="ui teal mini icon button">
                            <i class="calendar alternate outline icon"></i> Select date
                        </button><span id="sel_date_span" style="margin-left: 10px;color: teal;font-weight: 700;">{{Carbon\Carbon::now("Asia/Kuala_Lumpur")->format('d/m/Y')}}</span>
                    </div>
                </div>

                <h2 class="h2">Patient List</h2>
                <table id="jqGrid" class="table table-striped"></table>
                <div id="jqGridPager"></div>
                <a class="ui grey label left floated" style="margin-top: 8px;">
                    <i class="user icon"></i>
                    Patient : <span id="no_of_pat">0</span>
                </a>

                <div style="float: right;padding: 5px 4px 10px 10px;">

                    <div class="mini basic ui buttons">
                      <button id="timer_play" class="ui disabled icon button">
                        <i class="left play icon"></i>
                        Play
                      </button>
                      <button id="timer_stop" class="ui icon button">
                        <i class="right stop icon"></i>
                        Stop
                      </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input id="user_dept" name="user_dept" value="{{ Auth::user()->dept }}" type="hidden">
    <input id="sel_date" name="sel_date" value="{{ \Carbon\Carbon::now()->toDateString() }}" type="hidden">
    <input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">

    <div class="panel panel-default" style="position: relative;margin: 10px 0px 10px 0px" id="doctornote_panel">
        <div class="panel-heading clearfix collapsed" id="toggle_doctornote" >

        <div class="col-md-3" id="docnote_date_tbl_sticky" style="display: none;position: absolute;
            padding: 0 0 0 0;
            top: 98px;
            left: 5px;">
            <div class="panel panel-info">
                <div class="panel-body" style="max-height: 300px;overflow-y: scroll;">
                    <table id="docnote_date_tbl" class="ui celled table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="scope">mrn</th>
                                <th class="scope">episno</th>
                                <th class="scope">Date</th>
                                <th class="scope">adduser</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>

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
            <div class="panel-body" style="overflow-y: auto;height: 550px;" id="tab_doctornote_sticky">
                @include('doctornote_div')
            </div>
        </div>
    </div>

    <div class="panel panel-default" style="z-index: 100;position: relative;margin: 10px 0px 10px 0px" id="diet_panel">
        <div class="panel-heading clearfix collapsed" id="toggle_diet" data-toggle="collapse" data-target="#tab_diet">

        <b>NAME: <span id="name_show_dieteticCareNotes"></span></b><br>
        MRN: <span id="mrn_show_dieteticCareNotes"></span>
        SEX: <span id="sex_show_dieteticCareNotes"></span>
        DOB: <span id="dob_show_dieteticCareNotes"></span>
        AGE: <span id="age_show_dieteticCareNotes"></span>
        RACE: <span id="race_show_dieteticCareNotes"></span>
        RELIGION: <span id="religion_show_dieteticCareNotes"></span><br>
        OCCUPATION: <span id="occupation_show_dieteticCareNotes"></span>
        CITIZENSHIP: <span id="citizenship_show_dieteticCareNotes"></span>
        AREA: <span id="area_show_dieteticCareNotes"></span> 

        <i class="glyphicon glyphicon-chevron-up" style="font-size:24px;margin: 0 0 0 12px"></i>
        <i class="glyphicon glyphicon-chevron-down" style="font-size:24px;margin: 0 0 0 12px"></i >
        <div style="position: absolute;
                        padding: 0 0 0 0;
                        right: 50px;
                        top: 48px;">
            <h5><strong>Dietetic Care Notes</strong>&nbsp;&nbsp;
                <span class="metal"></span></h5>
        </div> 
        </div>

        <div id="tab_diet" class="panel-collapse collapse">
            <div class="panel-body">
                @include('dieteticCareNotes')
            </div>
        </div>
    </div>

    <div class="panel panel-default" style="z-index: 100;position: relative;margin: 10px 0px 10px 0px" id="transaction_panel">
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/se/dt-1.11.3/datatables.min.css"/>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css"> -->
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
    <script type="text/javascript" src="https://cdn.datatables.net/v/se/dt-1.11.3/datatables.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/ecmascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script type="text/ecmascript" src="{{ asset('assets/waypoints/lib/jquery.waypoints.min.js') }}/"></script>
    <script type="text/ecmascript" src="{{ asset('assets/form-validator/jquery.form-validator.min.js') }}/"></script>
	<script type="text/javascript" src="{{ asset('js/doctornote_main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/doctornote.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/transaction.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dieteticCareNotes.js') }}"></script>
@endsection


