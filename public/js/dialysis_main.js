
$.jgrid.defaults.responsive = true;
$.jgrid.defaults.styleUI = 'Bootstrap';

$(document).ready(function () {

	var urlParam = {
		action: 'patmast_current_patient',
		url: './pat_mast/post_entry',
		curpat: 'true',
	}

	var curpage=null; // to prevent duplicate entry 
	$("#jqGrid").jqGrid({
		datatype: "local",
		colModel: [
			{ label: 'idno', name: 'idno',width: 2 , hidden: true, key:true},
			{ label: 'MRN', name: 'MRN', width: 9, classes: 'wrap', formatter: padzero, unformat: unpadzero },
			{ label: 'Episno', name: 'Episno', width: 5 ,align: 'left',classes: 'wrap' },
			// { label: 'Time', name: 'reg_time', width: 10 ,classes: 'wrap', formatter: timeFormatter, unformat: timeUNFormatter},
			{ label: 'Name', name: 'Name', width: 40 ,classes: 'wrap' },
			{ label: 'Payer', name: 'payer', width: 20 ,classes: 'wrap' },
			{ label: 'I/C', name: 'Newic', width: 15 ,classes: 'wrap' },
			{ label: 'DOB', name: 'DOB', width: 12 ,classes: 'wrap' ,formatter: dateFormatter, unformat: dateUNFormatter},
			{ label: 'HP', name: 'telhp', width: 13 ,classes: 'wrap' , hidden:true},
			{ label: 'Sex', name: 'Sex', width: 6 ,classes: 'wrap' },
			{ label: 'Arrival', name: 'arrival', width: 5. ,align: 'center', formatter:formatterstatus_tick},
			{ label: 'dob', name: 'dob', hidden: true },
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
			if(selrowData('#jqGrid').arrival != ""){
				button_state_dialysis('add');
				hide_tran_button(false);
			}else{
				button_state_dialysis('disableAll');
				hide_tran_button(true);
			}
			populatedialysis(selrowData('#jqGrid'),'');
			urlParam_trans.mrn = selrowData('#jqGrid').MRN;
			urlParam_trans.episno = selrowData('#jqGrid').Episno;
			addmore_onadd = false;
			curpage_tran = null;
			refreshGrid("#jqGrid_trans", urlParam_trans);

		},
		ondblClickRow: function (rowid, iRow, iCol, e) {
		},
		gridComplete: function () {
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
		if (cellvalue != null) {
			return '<span class="fa fa-check" ></span>';
		}else{
			return "";
		}
	}

});
