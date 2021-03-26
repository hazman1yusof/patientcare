$(document).ready(function () {
	var urlParam = {
		action: 'get_table_default',
	}

	$("#jqGrid_trans").jqGrid({
		datatype: "local",
		colModel: [
			{ label: 'idno', name: 'e_idno', width: 5, hidden: true },
			{ label: 'MRN', name: 'e_mrn', width: 12, classes: 'wrap', formatter: padzero, unformat: unpadzero, canSearch: true, checked: true,  },
			{ label: 'Epis. No', name: 'e_episno', width: 10 ,canSearch: true,classes: 'wrap' },
			{ label: 'Name', name: 'p_name', width: 30 ,canSearch: true,classes: 'wrap' },
			{ label: 'Action', name: 'action', width: 30 ,canSearch: true,classes: 'wrap'}
		],
		autowidth: true,
		viewrecords: true,
		width: 900,
		height: 365,
		rowNum: 30,
		// pager:'#jqGrid_transPager',
		onSelectRow:function(rowid, selected){

		},
		ondblClickRow: function (rowid, iRow, iCol, e) {
		},
		gridComplete: function () {

		},
	});

	$("#tab_trans").on("shown.bs.collapse", function(){
		$("#jqGrid_trans").jqGrid ('setGridWidth', Math.floor($("#jqGrid_trans_c")[0].offsetWidth-$("#jqGrid_trans_c")[0].offsetLeft-14));
	});


	// $("#jqGrid_trans").jqGrid('navGrid', '#jqGrid_transPager', {
	// 	view: false, edit: true, add: true, del: false, search: false,
	// 	beforeRefresh: function () {
	// 		refreshGrid("#jqGrid", urlParam);
	// 	},
	// });
});
