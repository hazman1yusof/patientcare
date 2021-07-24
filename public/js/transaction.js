$(document).ready(function () {

	// var fdl = new faster_detail_load();
	$("#jqGrid_trans").jqGrid({
		datatype: "local",
		editurl: "./transaction_save",
		colModel: [
			{ label: 'Date', name: 't_trxdate', width: 30 ,formatter: dateFormatter, unformat: dateUNFormatter},
			{ label: 'Time', name: 't_trxtime', width: 30 ,formatter: timeFormatter, unformat: timeUNFormatter},
			{ label: 'Charge Code', name: 't_chgcode', width: 30, editable:true,
				editrules:{required: true, custom:true, classes: 'wrap', custom_func:cust_rules},
				edittype:'custom',	editoptions:
				    {  custom_element:chgcodeCustomEdit,
				       custom_value:galGridCustomValue 	
				    },
			},
			{ label: 'Description', name: 'm_description', width: 80 },
			{ label: 'Department', name: 't_isudept', width: 30 },
			{ label: 'Quantity', name: 't_quantity', width: 30 , align: 'right', editable:true,
				editrules:{required: true, custom:true, custom_func:cust_rules},
				formatter: 'number',formatoptions:{decimalPlaces: 0, defaultValue: '1'}},
			{ label: 'auditno', name: 't_auditno', hidden: true,key:true },
		],
		autowidth: true,
		viewrecords: true,
		width: 900,
		height: 365,
		rowNum: 30,
		pager:'#jqGrid_transPager',
		viewrecords: true,
		loadonce:false,
		scroll: true,
		sortname: 't_auditno',
		sortorder: "desc",
		onSelectRow:function(rowid, selected){

		},
		ondblClickRow: function (rowid, iRow, iCol, e) {
			if($('td#jqGrid_trans_iledit').is(':visible')){
				$('td#jqGrid_trans_iledit').click();
			}
		},
		loadComplete: function () {
			if(addmore_onadd == true){
				$('#jqGrid_trans_iladd').click();
			}
			// fdl.set_array().reset();
		},
	});
	addParamField('#jqGrid_trans',false,urlParam_trans,[]);
	jqgrid_label_align_right('#jqGrid_trans');

	$("#tab_trans").on("shown.bs.collapse", function(){
		$("#jqGrid_trans").jqGrid ('setGridWidth', Math.floor($("#jqGrid_trans_c")[0].offsetWidth-$("#jqGrid_trans_c")[0].offsetLeft-14));
	});


	// $("#jqGrid_trans").jqGrid('navGrid', '#jqGrid_transPager', {
	// 	view: false, edit: true, add: true, del: false, search: false,
	// 	beforeRefresh: function () {
	// 		refreshGrid("#jqGrid", urlParam);
	// 	},
	// });

	var myEditOptions_add = {
        keys: true,
        extraparam:{
		    "_token": $("#_token").val(),
		    "mrn": selrowData('#jqGrid').e_mrn,
		    "episno": selrowData('#jqGrid').e_episno,
        },
        oneditfunc: function (rowid) {
        	addmore_onadd = true;
        	let selrow = selrowData('#jqGrid');
			dialog_chgcode.on();
			$("#jqGrid_trans").jqGrid("setRowData", rowid, {
					t_trxdate:$('#sel_date').val(),
					t_trxtime:moment().format("hh:mm A"),
					t_isudept:$('#user_dept').val()
				});

			$("input[name='t_quantity']").keydown(function(e) {//when click tab, auto save
				var code = e.keyCode || e.which;
				if (code == '9')$('#jqGrid_trans_ilsave').click();
			});
        },
        aftersavefunc: function (rowid, response, options) {
			refreshGrid("#jqGrid_trans", urlParam_trans);
        }, 
        errorfunc: function(rowid,response){
        	
        },
        beforeSaveRow: function(options, rowid) {
        	let selrow = selrowData('#jqGrid');
        	let selrow_trans = selrowData('#jqGrid_trans');

			let editurl = "./transaction_save?"+
				$.param({
					mrn: selrow.e_mrn,
		    		episno: selrow.e_episno,
		    		auditno: selrow_trans.auditno,
		    		isudept: $('#user_dept').val(),
		    		trxdate: $('#sel_date').val(),
				});


			$("#jqGrid_trans").jqGrid('setGridParam', { editurl: editurl });
        },
        afterrestorefunc : function( response ) {
			
	    }
    };

    var myEditOptions_edit = {
        keys: true,
        extraparam:{
		    "_token": $("#_token").val(),
		    "mrn": selrowData('#jqGrid').e_mrn,
		    "episno": selrowData('#jqGrid').e_episno,
        },
        oneditfunc: function (rowid) {
        	let selrow = selrowData('#jqGrid');
			dialog_chgcode.on();
			$("input[name='t_quantity']").keydown(function(e) {//when click tab, auto save
				var code = e.keyCode || e.which;
				if (code == '9')$('#jqGrid_trans_ilsave').click();
			});
        },
        aftersavefunc: function (rowid, response, options) {
			refreshGrid("#jqGrid_trans", urlParam_trans);
        }, 
        errorfunc: function(rowid,response){
        	
        },
        beforeSaveRow: function(options, rowid) {
        	let selrow = selrowData('#jqGrid');
        	let selrow_trans = selrowData('#jqGrid_trans');

			let editurl = "./transaction_save?"+
				$.param({
					mrn: selrow.e_mrn,
		    		episno: selrow.e_episno,
		    		auditno: selrow_trans.auditno,
		    		isudept: $('#user_dept').val(),
		    		trxdate: $('#sel_date').val(),
				});


			$("#jqGrid_trans").jqGrid('setGridParam', { editurl: editurl });
        },
        afterrestorefunc : function( response ) {
			
	    }
    };

	$("#jqGrid_trans").inlineNav('#jqGrid_transPager',{	
		add:true,
		edit:true,
		cancel: true,
		//to prevent the row being edited/added from being automatically cancelled once the user clicks another row
		restoreAfterSelect: false,
		addParams: { 
			addRowParams: myEditOptions_add
		},
		editParams: myEditOptions_edit
	});

	hide_tran_button(true);

 //    function showdetail(cellvalue, options, rowObject){
	// 	var field,table,case_;
	// 	switch(options.colModel.name){
	// 		case 't_chgcode':field=['chgcode','description'];table="chgmast";case_='chgcode';break;
	// 	}
	// 	var param={action:'input_check',url:'./util/get_value_default',table_name:table,field:field,value:cellvalue,filterCol:[field[0]],filterVal:[cellvalue]};

	// 	fdl.get_array('deliveryOrder',options,param,case_,cellvalue);
	// 	// faster_detail_array.push(faster_detail_load('deliveryOrder',options,param,case_,cellvalue));
		
	// 	return cellvalue;
	// }

    function cust_rules(value,name){
		var temp;
		switch(name){
			case 'Charge Code':temp=$('table#jqGrid_trans input[name=chgcode]');break;
			case 'Quantity':
					let quan=$('table#jqGrid_trans input[name=t_quantity]').val();
					if(parseInt(quan) <= 0){
						return [false,"Quantity need to be greater than 0"];
					}else{
						return [true,''];
					}
			break;
		}
		return(temp.hasClass("error"))?[false,"Please enter valid "+name+" value"]:[true,''];
	}

	function chgcodeCustomEdit(val,opt){  	
		val = (val == "undefined") ? "" : val;
		return $('<div class="input-group"><input jqgrid="jqGrid_trans" optid="'+opt.id+'" id="'+opt.id+'" name="chgcode" type="text" class="form-control input-sm" data-validation="required" value="'+val+'" style="z-index: 0"><a class="input-group-addon btn btn-primary"><span class="fa fa-ellipsis-h"></span></a></div><span class="help-block"></span>');
	}

    function galGridCustomValue (elem, operation, value){
		if(operation == 'get') {
			return $(elem).find("input").val();
		} 
		else if(operation == 'set') {
			$('input',elem).val(value);
		}
	}
	var errorField = [];

	var dialog_chgcode = new ordialog(
		'chgcode',['chgmast'],"#jqGrid_trans input[name='chgcode']",errorField,
		{	colModel:
			[
				{label:'Charge code',name:'chgcode',width:200,classes:'pointer',canSearch:true,or_search:true},
				{label:'Description',name:'description',width:400,classes:'pointer',canSearch:true,checked:true,or_search:true},
			],
			urlParam: {
						filterCol:['recstatus'],
						filterVal:['A']
					},
			ondblClickRow:function(event){
				if(event.type == 'keydown'){
					var optid = $(event.currentTarget).get(0).getAttribute("optid");
					var id_optid = optid.substring(0,optid.search("_"));
				}else{
					var optid = $(event.currentTarget).siblings("input[type='text']").get(0).getAttribute("optid");
					var id_optid = optid.substring(0,optid.search("_"));
				}
				$(event.currentTarget).parent().next().html('');
				let data=selrowData('#'+dialog_chgcode.gridname);
				$("#jqGrid_trans").jqGrid("setRowData", id_optid, {m_description:data.description});
				$(dialog_chgcode.textfield).closest('td').next().next().next().children("input[type=text]").eq(0).focus();
			},
			gridComplete: function(obj){
				var gridname = '#'+obj.gridname;
				if($(gridname).jqGrid('getDataIDs').length == 1){
					$(gridname+' tr#1').click();
					$(gridname+' tr#1').dblclick();
					// $(obj.textfield).closest('td').next().next().find("input[type=text]").focus();
				}
			}
		},{
			title:"Select Charge Code Item",
			open: function(){
				dialog_chgcode.urlParam.filterCol=['recstatus'];
				dialog_chgcode.urlParam.filterVal=['A'];
			},
			close: function(){
				// if($('#jqGridPager2SaveAll').css("display") == "none"){
				// 	$(dialog_taxcode.textfield)			//lepas close dialog focus on next textfield 
				// 	.closest('td')						//utk dialog dalam jqgrid jer
				// 	.next()
				// 	.find("input[type=text]").focus();
				// }
				
			},
			after_check(obj){
				$(obj.textfield).parent().next().html('');
			},
		},'urlParam','radio','tab'
	);
	dialog_chgcode.makedialog(false);

});

var addmore_onadd = false;
var urlParam_trans = {
	url:'./util/get_table_default',
	action: 'get_table_default',
	fixPost:'true',
	table_name: ['chargetrx as t','chgmast as m'],
	join_type:['LEFT JOIN'],
	join_onCol:['t.chgcode'],
	join_onVal:['m.chgcode'],
	filterCol: ['t.mrn', 't.episno'],
	filterVal: ['', '']
}

function hide_tran_button(hide=true){
	if(hide){
		$('#jqGrid_trans_iladd,#jqGrid_trans_iledit,#jqGrid_trans_ilsave,#jqGrid_trans_ilcancel').hide();
	}else{
		$('#jqGrid_trans_iladd,#jqGrid_trans_iledit,#jqGrid_trans_ilsave,#jqGrid_trans_ilcancel').show();
	}
}
