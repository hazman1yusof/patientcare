
$.jgrid.defaults.responsive = true;
$.jgrid.defaults.styleUI = 'Bootstrap';

$(document).ready(function () {
	$('#calendar').fullCalendar({
		events: events,
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
			{ label: 'Time', name: 'e_reg_time', width: 12, hidden: true },
			{ label: 'MRN', name: 'e_mrn', width: 8, classes: 'wrap', formatter: padzero, unformat: unpadzero, canSearch: true, checked: true,  },
			{ label: 'Epis. No', name: 'e_episno', width: 5 ,canSearch: true,classes: 'wrap' },
			{ label: 'Name', name: 'p_name', width: 40 ,canSearch: true,classes: 'wrap' },
			{ label: 'I/C', name: 'p_Newic', width: 15 ,canSearch: true,classes: 'wrap' },
			{ label: 'DOB', name: 'p_DOB', width: 12 ,canSearch: true,classes: 'wrap' },
			{ label: 'Sex', name: 'p_Sex', width: 5 ,canSearch: true,classes: 'wrap' },
			{ label: 'Action', name: 'action', width: 15 ,canSearch: true,classes: 'wrap', formatter: formatterRemarks,unformat: unformatRemarks},
			{ label: 'idno', name: 'e_idno', width: 5, hidden: true },
		],
		autowidth: true,
		viewrecords: true,
		width: 900,
		height: 365,
		rowNum: 30,
		onSelectRow:function(rowid, selected){
			//kalau dialysis
			populatedialysis(selrowData('#jqGrid'),urlParam.filterVal[0]);
			hide_tran_button(false);
			urlParam_trans.filterVal[0] = selrowData('#jqGrid').e_mrn;
			urlParam_trans.filterVal[1] = selrowData('#jqGrid').e_episno;
			refreshGrid("#jqGrid_trans", urlParam_trans);
			//habis kalau dialysis

		},
		ondblClickRow: function (rowid, iRow, iCol, e) {
		},
		gridComplete: function () {

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

	function formatterRemarks(cellvalue, options, rowObject){
		return "<a class='remarks_button btn btn-success btn-xs' target='_blank' href='./upload?mrn="+rowObject.e_mrn+"&episno="+rowObject.e_episno+"' > upload </a>";
	}

	function unformatRemarks(cellvalue, options, rowObject){
		return null;
	}

});
