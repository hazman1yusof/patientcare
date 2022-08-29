
$.jgrid.defaults.responsive = true;
$.jgrid.defaults.styleUI = 'Bootstrap';

$(document).ready(function () {

	var urlParam = {
		action: 'patmast_current_patient',
		url: './pat_mast/post_entry',
		curpat: 'true',
		showall:false,
		showcomplete:false,
	}

	var curpage=null; // to prevent duplicate entry curpage kena falsekan blk setiap kali nak refresh dari awal 
	$("#jqGrid").jqGrid({
		datatype: "local",
		colModel: [
			{ label: 'idno', name: 'idno',hidden: true, key:true},
			{ label: 'MRN', name: 'MRN', width: 5, classes: 'wrap', formatter: padzero, unformat: unpadzero },
			{ label: 'Episode', name: 'Episno', width: 5 ,align: 'left',classes: 'wrap' },
			// { label: 'Time', name: 'reg_time', width: 10 ,classes: 'wrap', formatter: timeFormatter, unformat: timeUNFormatter},
			{ label: 'Name', name: 'Name', width: 30 ,classes: 'wrap' },
			{ label: 'Payer', name: 'payer', width: 20 ,classes: 'wrap' },
			{ label: 'I/C', name: 'Newic', width: 15 ,classes: 'wrap' },
			{ label: 'DOB', name: 'DOB', hidden: true},
			{ label: 'HP', name: 'telhp', hidden:true},
			{ label: 'Sex', name: 'Sex', width: 5 ,classes: 'wrap' },
			{ label: 'Arrival Date', name: 'arrival_date', width: 7. ,align: 'center', formatter:dateFormatter, unformat:dateUNFormatter},
			{ label: 'Arrival', name: 'arrival', width: 5. ,align: 'center', formatter:formatterstatus_tick, unformat:UNformatterstatus_tick},
			{ label: 'Complete', name: 'complete', width: 6. ,align: 'center', formatter:formatterstatus_tick, unformat:UNformatterstatus_tick},
			{ label: 'Order', name: 'order', hidden: true},
			{ label: 'RaceCode', name: 'RaceCode', hidden: true },
			{ label: 'religion', name: 'religion', hidden: true },
			{ label: 'OccupCode', name: 'OccupCode', hidden: true },
			{ label: 'Citizencode', name: 'Citizencode', hidden: true },
			{ label: 'AreaCode', name: 'AreaCode', hidden: true },
		],
		autowidth: true,
		viewrecords: false,
		width: 900,
		height: 300,
		rowNum: 50,
		loadonce:false,
		scroll: true,
		sortname: 'idno',
		sortorder: "desc",
		onSelectRow:function(rowid, selected){
			closealltab();
			button_state_dialysis('disableAll');

			if(selrowData('#jqGrid').arrival != 0){
				$('#dialysis_episode_idno').val(selrowData('#jqGrid').arrival);
				hide_tran_button(false);
			}else{
				$('#dialysis_episode_idno').val(0);
				hide_tran_button(true);
			}
			
			populatedialysis(selrowData('#jqGrid'));
			urlParam_trans.mrn = selrowData('#jqGrid').MRN;
			urlParam_trans.episno = selrowData('#jqGrid').Episno;
			addmore_onadd = false;
			curpage_tran = null;

		},
		ondblClickRow: function (rowid, iRow, iCol, e) {
		},
		gridComplete: function () {
			urlParam_trans.mrn = "";
			urlParam_trans.episno =  "";
			empty_dialysis();
			empty_transaction();
			// $("#jqGrid").setSelection($("#jqGrid").getDataIDs()[0]);

		},
		beforeProcessing: function(data, status, xhr){
			if(curpage == data.current){
				return false;
			}else{
				curpage = data.current;
			}
		}
	});
	addParamField('#jqGrid',true,urlParam,['action']);
	/////////////////////////start grid pager/////////////////////////////////////////////////////////
	$("#jqGrid").jqGrid('navGrid', '#jqGridPager', {
		view: false, edit: false, add: false, del: false, search: false,
		beforeRefresh: function () {
			refreshGrid("#jqGrid", urlParam);
		},
	});

	searchClick_scroll("#jqGrid","#SearchForm",urlParam);


	$('.ui.checkbox.myslider.showall').checkbox({
		onChecked: function() {
			urlParam.showall = true;
			curpage = null;
			refreshGrid("#jqGrid", urlParam);
	    },
	    onUnchecked: function() {
			urlParam.showall = false;
			curpage = null;
			refreshGrid("#jqGrid", urlParam);
	    },
	});

	$('.ui.checkbox.myslider.showcomplete').checkbox({
		onChecked: function() {
			urlParam.showcomplete = true;
			curpage = null;
			refreshGrid("#jqGrid", urlParam);
	    },
	    onUnchecked: function() {
			urlParam.showcomplete = false;
			curpage = null;
			refreshGrid("#jqGrid", urlParam);
	    },
	});

	stop_scroll_on();

});

function closealltab(except){
	var tab_arr = ["#tab_trans","#tab_daily","#tab_weekly","#tab_monthly"];
	tab_arr.forEach(function(e,i){
		if(e != except){
			$(e).collapse('hide');
		}
	});
}

function searchClick_scroll(grid,form,urlParam){
	$(form+' [name=Stext]').on( "keyup", function() {
		curpage = null;
		delay(function(){
			search(grid,$(form+' [name=Stext]').val(),$(form+' [name=Scol] option:selected').val(),urlParam);
		}, 500 );
	});

	$(form+' [name=Scol]').on( "change", function() {
		curpage = null;
		search(grid,$(form+' [name=Stext]').val(),$(form+' [name=Scol] option:selected').val(),urlParam);
	});
}

function formatterstatus_tick(cellvalue, option, rowObject) {
	if (cellvalue != null && cellvalue != 0) {
		return '<span class="fa fa-check" data-value="'+cellvalue+'"></span>';
	}else{
		return "";//if value is zero will capture as "" when unformat
	}
}

function UNformatterstatus_tick(cellvalue, option, cell) {
	if($('span.fa', cell).data('value') == undefined){
		return 0;
	}else{
		return $('span.fa', cell).data('value');
	}
}

function stop_scroll_on(){
	$('div.paneldiv').on('mouseenter',function(){
		$('body').addClass('stop-scrolling');
	});

	$('div.paneldiv').on('mouseleave',function(){
		$('body').removeClass('stop-scrolling')
	});
}


