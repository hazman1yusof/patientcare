
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
		eventClick: function(event) {
			var view = $('#calendar').fullCalendar('getView');
			if(view.type == 'listMonth'){
				urlParam.filterVal[0] = event.start.format('YYYY-MM-DD');
				refreshGrid("#jqGrid", urlParam);
			}
		},
		eventSources: [
			{	
				id:'appt_main',
				url:'./dialysis_event',
				type:'GET'
			},
	    ]


	});

	var urlParam = {
		action: 'get_table_default',
		url: $('#util_tab').val(),
		field: '',
		fixPost:'true',
		table_name:['episode as e','pat_mast as p'],
		join_type:['LEFT JOIN'],
		join_onCol:['e.mrn'],
		join_onVal:['p.mrn'],
		filterCol:['e.reg_date'],
		filterVal:[moment().format('YYYY-MM-DD')],
	}

	$("#jqGrid").jqGrid({
		datatype: "local",
		colModel: [
			{ label: 'MRN', name: 'e_mrn', width: 7, classes: 'wrap', formatter: padzero, unformat: unpadzero, checked: true,  },
			{ label: 'Epis. No', name: 'e_episno', width: 5 ,align: 'right',classes: 'wrap' },
			{ label: 'Time', name: 'e_reg_time', width: 8 ,classes: 'wrap', formatter: timeFormatter, unformat: timeUNFormatter},
			{ label: 'Name', name: 'p_name', width: 18 ,classes: 'wrap' },
			{ label: 'Payer', name: 'e_payer', width: 18 ,classes: 'wrap' },
			{ label: 'I/C', name: 'p_Newic', width: 12 ,classes: 'wrap' },
			{ label: 'DOB', name: 'p_DOB', width: 10 ,classes: 'wrap' ,formatter: dateFormatter, unformat: dateUNFormatter},
			{ label: 'Handphone', name: 'p_telhp', width: 10 ,classes: 'wrap' },
			{ label: 'Sex', name: 'p_Sex', width: 5 ,classes: 'wrap' },
			{ label: 'Pay Mode', name: 'e_pyrmode', width: 10 ,classes: 'wrap'},
			{ label: 'Completed', name: 'e_ordercomplete', width: 11,formatter: ordercompleteFormatter, unformat: ordercompleteUNFormatter },
			{ label: 'idno', name: 'e_idno', hidden: true, key:true},
			{ label: 'Time', name: 'e_reg_time', hidden: true },
		],
		autowidth: true,
		viewrecords: true,
		width: 900,
		height: 365,
		rowNum: 30,
		sortname: 'e_idno',
		sortorder: "desc",
		onSelectRow:function(rowid, selected){

			populatedialysis(selrowData('#jqGrid'),urlParam.filterVal[0]);
			hide_tran_button(false);
			urlParam_trans.filterVal[0] = selrowData('#jqGrid').e_mrn;
			urlParam_trans.filterVal[1] = selrowData('#jqGrid').e_episno;
			addmore_onadd = false;
			refreshGrid("#jqGrid_trans", urlParam_trans);

			if(selrowData('#jqGrid').e_ordercomplete){ //kalau dah completed
				$('#checkbox_completed').prop('disabled',true);
				$('#checkbox_completed').prop('checked', true);
				hide_tran_button(true);
			}else{//kalau belum completed
				$('#checkbox_completed').prop('disabled',false);
				$('#checkbox_completed').prop('checked', false);
				hide_tran_button(false);
			}

		},
		ondblClickRow: function (rowid, iRow, iCol, e) {
		},
		gridComplete: function () {
			$('#checkbox_completed').prop('disabled',true);
			$("#jqGrid").setSelection($("#jqGrid").getDataIDs()[0]);
			ordercompleteInit();

		},
	});
	addParamField('#jqGrid',true,urlParam,['action']);
	/////////////////////////start grid pager/////////////////////////////////////////////////////////
	$("#jqGrid").jqGrid('navGrid', '#jqGridPager', {
		view: false, edit: false, add: false, del: false, search: false,
		beforeRefresh: function () {
			refreshGrid("#jqGrid", urlParam);
		},
	});

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
									mrn: rowdata.e_mrn,
									episno: rowdata.e_episno,
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