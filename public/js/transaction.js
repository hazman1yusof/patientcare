$(document).ready(function () {

	// var fdl = new faster_detail_load();
	$("#jqGrid_trans").jqGrid({
		datatype: "local",
		editurl: "./doctornote_transaction_save",
		colModel: [
			{ label: 'auditno', name: 'auditno', hidden: true,key:true },
			{ label: 'chg_code', name: 'chg_code', hidden: true },
			{ label: 'Code', name: 'chg_desc', width: 40, editable:true,
				editrules:{required: true, custom:true, classes: 'wrap', custom_func:cust_rules},
				edittype:'custom',	editoptions:
				    {  custom_element:chgcodeCustomEdit,
				       custom_value:galGridCustomValue 	
				    },
			},
			{ label: 'Qty', name: 'quantity', width: 15 , align: 'right', editable:true,
				editrules:{required: true, custom:true, custom_func:cust_rules},
				formatter: 'number',formatoptions:{decimalPlaces: 0, defaultValue: '1'}},
			{ label: 'Remarks', name: 'remarks', width: 100, editable:true,edittype:'textarea',editoptions: { rows: 4 }},
			{ label: 'ins_code', name: 'ins_code', hidden: true },
			{ label: 'Instruction', name: 'ins_desc', width: 40 , editable:true,
				editrules:{required: true, custom:true, classes: 'wrap', custom_func:cust_rules},
				edittype:'custom',	editoptions:
				    {  custom_element:instructionCustomEdit,
				       custom_value:galGridCustomValue 	
				    },},
			{ label: 'dos_code', name: 'dos_code', hidden: true },
			{ label: 'Dosage', name: 'dos_desc', width: 40 , editable:true,
				editrules:{required: true, custom:true, classes: 'wrap', custom_func:cust_rules},
				edittype:'custom',	editoptions:
				    {  custom_element:doscodeCustomEdit,
				       custom_value:galGridCustomValue 	
				    },},
			{ label: 'fre_code', name: 'fre_code', hidden: true },
			{ label: 'Frequency', name: 'fre_desc', width: 40 , editable:true,
				editrules:{required: true, custom:true, classes: 'wrap', custom_func:cust_rules},
				edittype:'custom',	editoptions:
				    {  custom_element:frequencyCustomEdit,
				       custom_value:galGridCustomValue 	
				    },},
			{ label: 'dru_code', name: 'dru_code', hidden: true },
			{ label: 'Indicator', name: 'dru_desc', width: 40 , editable:true,
				editrules:{required: true, custom:true, classes: 'wrap', custom_func:cust_rules},
				edittype:'custom',	editoptions:
				    {  custom_element:drugindicatorCustomEdit,
				       custom_value:galGridCustomValue 	
				    },},
		],
		autowidth: false,
		viewrecords: true,
		width: 900,
		height: 365,
		rowNum: 30,
		pager:'#jqGrid_transPager',
		viewrecords: true,
		loadonce:false,
		scroll: true,
		sortname: 'auditno',
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
		    "mrn": selrowData('#jqGrid').MRN,
		    "episno": selrowData('#jqGrid').Episno,
        },
        oneditfunc: function (rowid) {
        	addmore_onadd = true;
        	let selrow = selrowData('#jqGrid');
			// dialog_chgcode.on();
            onclick_itemselector();


			$("#jqGrid_trans").jqGrid("setRowData", rowid, {
					t_trxdate:$('#sel_date').val(),
					t_trxtime:moment().format("hh:mm A"),
					t_isudept:$('#user_dept').val()
				});

			// $("input[name='t_quantity']").keydown(function(e) {//when click tab, auto save
			// 	var code = e.keyCode || e.which;
			// 	if (code == '9')$('#jqGrid_trans_ilsave').click();
			// });
        },
        aftersavefunc: function (rowid, response, options) {
			refreshGrid("#jqGrid_trans", urlParam_trans);
        }, 
        errorfunc: function(rowid,response){
        	
        },
        beforeSaveRow: function(options, rowid) {
        	let selrow = selrowData('#jqGrid');
        	let selrow_trans = selrowData('#jqGrid_trans');

			let editurl = "./doctornote_transaction_save?"+
				$.param({
					mrn: selrow.MRN,
		    		episno: selrow.Episno,
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
		    "mrn": selrowData('#jqGrid').MRN,
		    "episno": selrowData('#jqGrid').Episno,
        },
        oneditfunc: function (rowid) {
        	let selrow = selrowData('#jqGrid');
			// dialog_chgcode.on();
			// $("input[name='t_quantity']").keydown(function(e) {//when click tab, auto save
			// 	var code = e.keyCode || e.which;
			// 	if (code == '9')$('#jqGrid_trans_ilsave').click();
			// });
        },
        aftersavefunc: function (rowid, response, options) {
			refreshGrid("#jqGrid_trans", urlParam_trans);
        }, 
        errorfunc: function(rowid,response){
        	
        },
        beforeSaveRow: function(options, rowid) {
        	let selrow = selrowData('#jqGrid');
        	let selrow_trans = selrowData('#jqGrid_trans');

			let editurl = "./doctornote_transaction_save?"+
				$.param({
					mrn: selrow.MRN,
		    		episno: selrow.Episno,
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
			case 'Code':temp=$('table#jqGrid_trans input[name=chgcode]');break;
			case 'Instruction':temp=$('table#jqGrid_trans input[name=instruction]');break;
			case 'Dosage':temp=$('table#jqGrid_trans input[name=doscode]');break;
			case 'Frequency':temp=$('table#jqGrid_trans input[name=frequency]');break;
			case 'Indicator':temp=$('table#jqGrid_trans input[name=drugindicator]');break;
			case 'Qty':
					let quan=$('table#jqGrid_trans input[name=quantity]').val();
					if(parseInt(quan) <= 0){
						return [false,"Quantity need to be greater than 0"];
					}else{
						return [true,''];
					}
			break;
		}
		return(temp.val() == '')?[false,"Please enter valid "+name+" value"]:[true,''];
	}

	function chgcodeCustomEdit(val,opt){
		console.log(opt)
		val = (val == "undefined") ? "" : val;
		return $(`<div class="input-group"><input jqgrid="jqGrid_trans" optid="`+opt.id+`" id="`+opt.id+`" name="chgcode" type="text" class="form-control input-sm" data-validation="required" value="`+val+`" style="z-index: 0" ><a class="input-group-addon btn btn-primary" onclick="pop_item_select('chgcode','`+opt.id+`','`+opt.rowId+`');"><span class="fa fa-ellipsis-h"></span></a></div><span class="help-block"></span>`);
	}

	function instructionCustomEdit(val,opt){  	
		val = (val == "undefined") ? "" : val;
		return $(`<div class="input-group"><input jqgrid="jqGrid_trans" optid="`+opt.id+`" id="`+opt.id+`" name="instruction" type="text" class="form-control input-sm" data-validation="required" value="`+val+`" style="z-index: 0" ><a class="input-group-addon btn btn-primary" onclick="pop_item_select('inscode','`+opt.id+`','`+opt.rowId+`');"><span class="fa fa-ellipsis-h"></span></a></div><span class="help-block"></span>`);
	}

	function doscodeCustomEdit(val,opt){  	
		val = (val == "undefined") ? "" : val;
		return $(`<div class="input-group"><input jqgrid="jqGrid_trans" optid="`+opt.id+`" id="`+opt.id+`" name="doscode" type="text" class="form-control input-sm" data-validation="required" value="`+val+`" style="z-index: 0" ><a class="input-group-addon btn btn-primary" onclick="pop_item_select('dosecode','`+opt.id+`','`+opt.rowId+`');"><span class="fa fa-ellipsis-h"></span></a></div><span class="help-block"></span>`);
	}

	function frequencyCustomEdit(val,opt){  	
		val = (val == "undefined") ? "" : val;
		return $(`<div class="input-group"><input jqgrid="jqGrid_trans" optid="`+opt.id+`" id="`+opt.id+`" name="frequency" type="text" class="form-control input-sm" data-validation="required" value="`+val+`" style="z-index: 0" ><a class="input-group-addon btn btn-primary" onclick="pop_item_select('freqcode','`+opt.id+`','`+opt.rowId+`');"><span class="fa fa-ellipsis-h"></span></a></div><span class="help-block"></span>`);
	}

	function drugindicatorCustomEdit(val,opt){  	
		val = (val == "undefined") ? "" : val;
		return $(`<div class="input-group"><input jqgrid="jqGrid_trans" optid="`+opt.id+`" id="`+opt.id+`" name="drugindicator" type="text" class="form-control input-sm" data-validation="required" value="`+val+`" style="z-index: 0" ><a class="input-group-addon btn btn-primary" onclick="pop_item_select('drugindcode','`+opt.id+`','`+opt.rowId+`');"><span class="fa fa-ellipsis-h"></span></a></div><span class="help-block"></span>`);
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

});

var addmore_onadd = false;
var urlParam_trans = {
	url:'./doctornote/table',
	action: 'get_transaction_table',
}

function hide_tran_button(hide=true){
	if(hide){
		$('#jqGrid_trans_iladd,#jqGrid_trans_iledit,#jqGrid_trans_ilsave,#jqGrid_trans_ilcancel').hide();
	}else{
		$('#jqGrid_trans_iladd,#jqGrid_trans_iledit,#jqGrid_trans_ilsave,#jqGrid_trans_ilcancel').show();
	}
}

function onclick_itemselector(){

}

function pop_item_select(type,id,rowid){ 
    var act = null;
    var id = id;
    var rowid = rowid;
    var selecter = null;
    var title="Item selector";
    var mdl = null;

    console.log(id);
        
    act = get_url(type);

	$('#mdl_item_selector').modal({
		'closable':false,
		onHidden : function(){
	        $('#tbl_item_select').html('');
	        selecter.destroy();
	    },
	}).modal('show');
	$('body,#mdl_item_selector').addClass('scrolling');
    
    selecter = $('#tbl_item_select').DataTable( {
            "ajax": "./doctornote/table?action=" + act,
            "ordering": false,
            "lengthChange": false,
            "info": true,
            "pagingType" : "numbers",
            "search": {
                        "smart": true,
                      },
            "columns": [
                        {'data': 'code'}, 
                        {'data': 'description'},
                       ],

            "columnDefs": [ {
            	"width": "20%",
                "targets": 0,
                "data": "code",
                "render": function ( data, type, row, meta ) {
                    return data;
                }
              } ],

            "fnInitComplete": function(oSettings, json) {
                // if(ontab==true){
                //     selecter.search( text_val ).draw();
                // }
                
                if(selecter.page.info().recordsDisplay == 1){
                    $('#tbl_item_select tbody tr:eq(0)').dblclick();
                }
            }
    });


    
    // dbl click will return the description in text box and code into hidden input, dialog will be closed automatically
    $('#tbl_item_select tbody').on('dblclick', 'tr', function () {
        // $('#txt_' + type).removeClass('error myerror').addClass('valid');
        // setTimeout(function(type){
        //     $('#txt_' + type).removeClass('error myerror').addClass('valid'); 
        // }, 1000,type);
        
        // $('#hid_' + type).val(item["code"]);
        // $('#txt_' + type).val(item["description"]);

        item = selecter.row( this ).data();
        $('input#'+id).val(item["code"]);
        $('span.help-block#'+id).html(item["description"]);
        $("#jqGrid_trans").jqGrid('setRowData', rowid ,{m_description:item["description"]});
            
        $('#mdl_item_selector').modal('hide');
    });
        
    $("#mdl_item_selector").on('hidden.bs.modal', function () {
        $('#tbl_item_select').html('');
        selecter.destroy();
        $('#add_new_adm,#adm_save,#new_occup_save,#new_title_save,#new_areacode_save').off('click');
        type = "";
        item = "";
        // obj.blurring = true;
    });
}

function get_url(type){
    let act = null;
    switch (type){
        case "chgcode":
            act = "get_chgcode";
            break;
        case "drugindcode":
            act = "get_drugindcode";
            break;
        case "freqcode":
            act = "get_freqcode";
            break;
        case "dosecode":
            act = "get_dosecode";
            break;
        case "inscode":
            act = "get_inscode";
            break;
    }
    return act;
}