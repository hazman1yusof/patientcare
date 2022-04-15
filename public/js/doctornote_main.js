
$.jgrid.defaults.responsive = true;
$.jgrid.defaults.styleUI = 'Bootstrap';

$(document).ready(function () {

	$('#calendar').fullCalendar({
		// events: events,
  		defaultView: 'month',
  		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,listMonth'
		},
		buttonText:{
			today: "Today"
		},
		contentHeight:"auto",
		dayClick: function(date, allDay, jsEvent, view) {
			$( ".fc-bg td.fc-day" ).removeClass( "selected_day" );
			$(this).addClass( "selected_day" );

			urlParam.filterVal[0] = date.format('YYYY-MM-DD');

			$('#sel_date').val(date.format('YYYY-MM-DD'));
			refreshGrid("#jqGrid", urlParam);

		},
		eventRender: function(eventObj, $el) {
			$(".fc-today-button").html('<small class="mysmall">'+moment().format('ddd')+'</small><br/><b class="myb">'+moment().format('DD')+'</b>');
			// $('div.fc-right').append('<p>sdssd</p>').insertAfter
		},
		eventAfterRender: function(event, element, view){
			let d1 = new Date(event.start.format('YYYY-MM-DD'));
			let d2 = new Date($('#sel_date').val());
			if(d1.getTime() === d2.getTime()){
				$('#no_of_pat').text(event.title.split(" ")[0]);
			}
		},
		eventClick: function(event) {
			var view = $('#calendar').fullCalendar('getView');
			if(view.type == 'listMonth'){
				urlParam.filterVal[0] = event.start.format('YYYY-MM-DD');
				refreshGrid("#jqGrid", urlParam);
			}
		},
		eventSources: [
			{	
				id: 'doctornote_event',
				url: './doctornote/table',
				type: 'GET',
				data: {
					type: 'apptbook',
					action: 'doctornote_event'
				}
			},
	    ]


	});

	var urlParam = {
		action: 'get_table_doctornote',
		url: $('#doctornote_route').val(),
		filterVal : [moment().format("YYYY-MM-DD")]
	}

	var istablet = $(window).width() <= 1024;
	// istablet =  true;

	if(istablet){

		$('#calendar_div').hide();
		$('.if_tablet').show();

		$('#jqgrid_div').removeClass('eleven wide tablet eleven wide computer');
		$('#jqgrid_div').addClass('sixteen wide tablet sixteen wide computer');

		$('#button_calendar').calendar({
			type: 'date',
			today: true,
			onChange: function(date){
			},
			onSelect: function(date,mode){

				let new_date = date.toISOString().split('T')[0];

				urlParam.filterVal[0] = new_date;

				$('#sel_date').val(new_date);
				refreshGrid("#jqGrid", urlParam);
				$('#sel_date_span').text(new_date);
			}

		});
		

		$("#jqGrid").jqGrid({
			datatype: "local",
			colModel: [
				{ label: 'MRN', name: 'MRN', width: 9, classes: 'wrap', formatter: padzero, unformat: unpadzero, checked: true,  },
				{ label: ' ', name: 'Episno', width: 5 ,align: 'right',classes: 'wrap' , hidden:true},
				{ label: 'Time', name: 'reg_time', width: 10 ,classes: 'wrap', formatter: timeFormatter, unformat: timeUNFormatter},
				{ label: 'Name', name: 'Name', width: 15 ,classes: 'wrap' },
				{ label: 'Payer', name: 'payer', width: 15 ,classes: 'wrap' },
				{ label: 'I/C', name: 'Newic', width: 15 ,classes: 'wrap' },
				{ label: 'Rehab', name: 'reff_rehab', width: 8 ,classes: 'wrap',formatter: formatterstatus_tick2 },
				{ label: 'Physio', name: 'reff_physio', width: 8 ,classes: 'wrap',formatter: formatterstatus_tick2 },
				{ label: 'Diet', name: 'reff_diet', width: 8 ,classes: 'wrap',formatter: formatterstatus_tick2 },
				{ label: 'HP', name: 'telhp', width: 13 ,classes: 'wrap' , hidden:true},
				{ label: 'Sex', name: 'Sex', width: 6 ,classes: 'wrap' },
				{ label: 'Mode', name: 'pyrmode', width: 8 ,classes: 'wrap'},
				{ label: 'Seen', name: 'doctorstatus', width: 8 ,classes: 'wrap',formatter: formatterstatus_tick},
				{ label: 'idno', name: 'idno', hidden: true, key:true},
				{ label: 'DOB', name: 'DOB', hidden: true },
				{ label: 'RaceCode', name: 'RaceCode', hidden: true },
				{ label: 'religion', name: 'religion', hidden: true },
				{ label: 'OccupCode', name: 'OccupCode', hidden: true },
				{ label: 'Citizencode', name: 'Citizencode', hidden: true },
				{ label: 'AreaCode', name: 'AreaCode', hidden: true },
			],
			autowidth: true,
			viewrecords: true,
			width: 900,
			height: 365,
			rowNum: 30,
			onSelectRow:function(rowid, selected){
				
				empty_userfile();
				$('button#timer_stop').click();
				hide_tran_button(false);
				hide_tran_button_diet(false);
				urlParam_trans.mrn = selrowData('#jqGrid').MRN;
				urlParam_trans.episno = selrowData('#jqGrid').Episno;
				urlParam_trans_diet.mrn = selrowData('#jqGrid').MRN;
				urlParam_trans_diet.episno = selrowData('#jqGrid').Episno;
				addmore_onadd = false;
				refreshGrid("#jqGrid_trans", urlParam_trans);
				refreshGrid("#jqGrid_trans_diet", urlParam_trans_diet);
	            populate_currDoctorNote(selrowData('#jqGrid'));
	            populate_dieteticCareNotes_currpt(selrowData('#jqGrid'));
	            populate_userfile(selrowData('#jqGrid'));
	            populate_phys(selrowData('#jqGrid'));

				if(selrowData('#jqGrid').e_ordercomplete){ //kalau dah completed
					$('#checkbox_completed').prop('disabled',true);
					$('#checkbox_completed').prop('checked', true);
					hide_tran_button(true);
					hide_tran_button_diet(true);
				}else{//kalau belum completed
					$('#checkbox_completed').prop('disabled',false);
					$('#checkbox_completed').prop('checked', false);
					hide_tran_button(false);
					hide_tran_button_diet(false);
				}

			},
			ondblClickRow: function (rowid, iRow, iCol, e) {
			},
			gridComplete: function () {
				hide_tran_button(true);
				hide_tran_button_diet(true);
				$('#no_of_pat').text($("#jqGrid").getGridParam("reccount"));
				empty_currDoctorNote();
				empty_transaction();
				empty_dietcarenote();
				empty_transaction_diet();
				empty_userfile();
				empty_currphys();

				let discharge_btn_data = $('#discharge_btn').data('idno');
				if(discharge_btn_data == undefined || discharge_btn_data == 'none'){
					if(!$("button#timer_play").hasClass("disabled")){
						$("#jqGrid").setSelection($("#jqGrid").getDataIDs()[0]);
					}
				}else{
					$("#jqGrid").setSelection(discharge_btn_data);
				}
			},
		});
	}else{

		$("#jqGrid").jqGrid({
			datatype: "local",
			colModel: [
				{ label: 'MRN', name: 'MRN', width: 7, classes: 'wrap', formatter: padzero, unformat: unpadzero, checked: true,  },
				{ label: 'Epis. No', name: 'Episno', width: 5 ,align: 'right',classes: 'wrap' , hidden:true},
				{ label: 'Time', name: 'reg_time', width: 8 ,classes: 'wrap', formatter: timeFormatter, unformat: timeUNFormatter},
				{ label: 'Name', name: 'Name', width: 18 ,classes: 'wrap' },
				{ label: 'Payer', name: 'payer', width: 18 ,classes: 'wrap' },
				{ label: 'I/C', name: 'Newic', width: 12 ,classes: 'wrap' },
				{ label: 'Rehab', name: 'reff_rehab', width: 8 ,classes: 'wrap',formatter: formatterstatus_tick2 },
				{ label: 'Physio', name: 'reff_physio', width: 8 ,classes: 'wrap',formatter: formatterstatus_tick2 },
				{ label: 'Diet', name: 'reff_diet', width: 8 ,classes: 'wrap',formatter: formatterstatus_tick2 },
				{ label: 'HP', name: 'telhp', width: 10 ,classes: 'wrap' },
				{ label: 'Sex', name: 'Sex', width: 5 ,classes: 'wrap' },
				{ label: 'Mode', name: 'pyrmode', width: 10 ,classes: 'wrap'},
				{ label: 'Seen', name: 'doctorstatus', width: 5 ,classes: 'wrap',formatter: formatterstatus_tick},
				{ label: 'idno', name: 'idno', hidden: true, key:true},
				{ label: 'DOB', name: 'DOB', hidden: true },
				{ label: 'RaceCode', name: 'RaceCode', hidden: true },
				{ label: 'religion', name: 'religion', hidden: true },
				{ label: 'OccupCode', name: 'OccupCode', hidden: true },
				{ label: 'Citizencode', name: 'Citizencode', hidden: true },
				{ label: 'AreaCode', name: 'AreaCode', hidden: true },
			],
			autowidth: true,
			viewrecords: true,
			sortorder: "episode.reg_time",
			sortorder: "desc",
			width: 900,
			height: 365,
			rowNum: 30,
			onSelectRow:function(rowid, selected){
				empty_userfile();
				$('button#timer_stop').click();
				hide_tran_button(false);
				hide_tran_button_diet(false);
				urlParam_trans.mrn = selrowData('#jqGrid').MRN;
				urlParam_trans.episno = selrowData('#jqGrid').Episno;
				urlParam_trans_diet.mrn = selrowData('#jqGrid').MRN;
				urlParam_trans_diet.episno = selrowData('#jqGrid').Episno;
				addmore_onadd = false;
				refreshGrid("#jqGrid_trans", urlParam_trans);
				refreshGrid("#jqGrid_trans_diet", urlParam_trans_diet);
	            populate_currDoctorNote(selrowData('#jqGrid'));
	            populate_dieteticCareNotes_currpt(selrowData('#jqGrid'));
	            populate_userfile(selrowData('#jqGrid'));
	            populate_phys(selrowData('#jqGrid'));

				if(selrowData('#jqGrid').e_ordercomplete){ //kalau dah completed
					$('#checkbox_completed').prop('disabled',true);
					$('#checkbox_completed').prop('checked', true);
					hide_tran_button(true);
					hide_tran_button_diet(true);
				}else{//kalau belum completed
					$('#checkbox_completed').prop('disabled',false);
					$('#checkbox_completed').prop('checked', false);
					hide_tran_button(false);
					hide_tran_button_diet(false);
				}

			},
			ondblClickRow: function (rowid, iRow, iCol, e) {
			},
			gridComplete: function () {
				hide_tran_button(true);
				hide_tran_button_diet(true);
				$('#no_of_pat').text($("#jqGrid").getGridParam("reccount"));
				empty_currDoctorNote();
				empty_transaction();
				empty_dietcarenote();
				empty_transaction_diet();
				empty_userfile();
				empty_currphys();

				let discharge_btn_data = $('#discharge_btn').data('idno');
				if(discharge_btn_data == undefined || discharge_btn_data == 'none'){
					if(!$("button#timer_play").hasClass("disabled")){
						$("#jqGrid").setSelection($("#jqGrid").getDataIDs()[0]);
					}
				}else{
					$("#jqGrid").setSelection(discharge_btn_data);
				}

			},
		});

	}
	$("#jqGrid").jqGrid('setGroupHeaders', {
		useColSpanStyle: true, 
		groupHeaders:[
			{startColumnName: 'Rehab', numberOfColumns: 3, titleText: '<em>Referral</em>'},
		]
	});
	addParamField('#jqGrid',true,urlParam,['action']);
	/////////////////////////start grid pager/////////////////////////////////////////////////////////
	$("#jqGrid").jqGrid('navGrid', '#jqGridPager', {
		view: false, edit: false, add: false, del: false, search: false,
		beforeRefresh: function () {
			refreshGrid("#jqGrid", urlParam);
		},
	});

	function formatterstatus_tick(cellvalue, option, rowObject) {
		if (cellvalue == 'SEEN') {
			return '<span class="fa fa-check" ></span>';
		}else{
			return "";
		}
	}

	function formatterstatus_tick2(cellvalue, option, rowObject) {
		if (cellvalue != null && cellvalue.toUpperCase() == 'YES') {
			return '<span class="fa fa-check" ></span>';
		}else{
			return "";
		}
	}

	function ordercompleteFormatter(cellvalue, option, rowObject) {
		if (cellvalue == '1') {
			// return '<span class="fa fa-check"></span>';
			return `<input type="checkbox" class="checkbox_completed" data-rowid="`+option.rowId+`" checked onclick="return false;">`;
		}else if (cellvalue == '0') {
			return `<input type="checkbox" class="checkbox_completed" data-rowid="`+option.rowId+`" >`;
		}
	}

	function ordercompleteUNFormatter(cellvalue, option, rowObject) {
		return $(rowObject).children('input[type=checkbox]').is("[checked]");
	}

	function visiblecancel(){
		var editing = true;
		var cont = true;

		if($('td#jqGrid_trans_ilcancel').hasClass("ui-disabled")){
			editing = false;
		}

		let records = $("#jqGrid_trans").jqGrid('getGridParam', 'records');

		if(records==1 && editing ){
			cont = false;
		}else if(records==0){
			cont = false;
		}

		return cont

	}

	$('button#timer_play').click(function(){
		timer_start_tbl();
		$('button#timer_play').addClass('disabled');
		$('button#timer_stop').removeClass('disabled');
	});

	$('button#timer_stop').click(function(){
		timer_stop_tbl();
		$('button#timer_play').removeClass('disabled');
		$('button#timer_stop').addClass('disabled');
	});

	var fetch_tbl,fetch_evt;
	timer_start_tbl();
	timer_start_evt();

	function timer_start_tbl(){
		fetch_tbl = setInterval(function(){
			refreshGrid("#jqGrid", urlParam);
		}, 5000);
	}

	function timer_start_evt(){
		fetch_evt = setInterval(function(){
			$('#calendar').fullCalendar( 'refetchEventSources', 'doctornote_event' );
		}, 5000);
	}

	function timer_stop_tbl(){
	  	clearInterval(fetch_tbl);
	}

	function ordercompleteInit(){

		$('input[type=checkbox].checkbox_completed').on('change',function(e){
			let cont = visiblecancel();

			if(cont ==  false){
				$.alert({
				    title: 'Alert',
				    content: 'Please enter charges',
				});
				$(this).prop('checked', false);
			}else{
				let self = this;
				let rowid = $(this).data('rowid');
				let rowdata = $('#jqGrid').jqGrid ('getRowData', rowid);

				$.confirm({
				    title: 'Confirm',
				    content: 'Do you want to complete all entries?',
				    buttons: {
				        Yes:{
				        	btnClass: 'btn-blue',
				        	action: function () {
					        	var param = {
									_token: $("#_token").val(),
									action: 'change_status',
									mrn: rowdata.mrn,
									episno: rowdata.episno,
								}

								$.post( "./change_status?"+$.param(param),{}, function( data ){
									if(data.success == 'success'){
										toastr.success('Patient status completed',{timeOut: 1000})
										refreshGrid("#jqGrid", urlParam);
									}
								},'json');
					         }

				        },
				        No: {
				        	action: function () {
								$(self).prop('checked', false);
					        },
				        }
				    }

				});

			}
		});
		
	}

});
