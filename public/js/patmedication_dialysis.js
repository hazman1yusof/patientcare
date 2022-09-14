
$(document).ready(function () {

	

});

var patmedication_trx_tbl = $('#patmedication_trx_tbl').DataTable({
	"ordering": false,
	"ajax": "",
	"sDom": "",
	"paging":false,
    "columns": [
        {'data': 'id'},
        {'data': 'mrn'},
        {'data': 'episno'},
        {'data': 'chg_desc', 'width': '100%'},
        {'data': 'chg_code'},
        {'data': 'quantity'},
        {'data': 'ins_code'},
        {'data': 'dos_code'},
        {'data': 'fre_code'},
        {'data': 'ins_desc'},
        {'data': 'dos_desc'},
        {'data': 'fre_desc'}
    ],
    columnDefs: [
        { targets: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11], visible: false},
    ],
    "drawCallback": function( settings ) {

    }
});

$('#patmedication_trx_tbl tbody').on('click', 'tr', function () {
	var data = patmedication_trx_tbl.row( this ).data();
    if(data != undefined && $('#patmedication_tbl').data('addmode') == false && !$('#save_dialysis').is("[disabled]") ){
	    $('#patmedication_trx_tbl tbody tr').removeClass('blue');
	    $(this).addClass('blue');
		$('#patmedication_trx_tbl_idno').val(data.id);
		$('#patmedication_tbl').data('addmode',true);
	    patmedication_tbl.row.add({
	        idno : 99999999999,
			chg_code : data.chg_code,
			chg_desc : data.chg_desc,
			dos_desc : data.dos_desc,
			fre_desc : data.fre_desc,
			quantity : data.quantity,
			enteredby : '',
			verifiedby : '',
			status : ''
	    }).draw(true);
    }
});

var patmedication_tbl = $('#patmedication_tbl').DataTable({
	"ordering": true,
	"ajax": "",
	"sDom": "",
	"paging":false,
    "columns": [
        {'data': 'idno'},
        {'data': 'chg_code','width': '30%'},
        {'data': 'chg_desc'},
        {'data': 'dos_desc'},
        {'data': 'fre_desc'},
        {'data': 'quantity'},
        {'data': 'enteredby','width': '20%'},
        {'data': 'verifiedby','width': '20%'},
        {'data': 'status'}
    ],
    order: [[0, 'desc']],
    columnDefs: [
    	// {targets: [8], className: 'text-center' },
    	{targets: [1,2,3,4,5,6,7,8], orderable: false },
        {targets: [0,1], visible: false},
        {targets: 6,
        	createdCell: function (td, cellData, rowData, row, col) {
				if (cellData == '' ) {
					$(td).append(`<input type="text" name="patmedication_enteredby" id="patmedication_enteredby" value="`+$('#user_name').val()+`" class="purplebg" style="max-width:150px;width:-webkit-fill-available;" readonly>`);
				}
   			}
   		},
        {targets: 7,
        	createdCell: function (td, cellData, rowData, row, col) {
				if (cellData == '' ) {
					$(td).append(`<div class="ui action input tiny" style="width: -webkit-fill-available;">
						  <input type="text" class='small' name="patmedication_verifiedby" id="patmedication_verifiedby" style="max-width:80px;width: -webkit-fill-available;" class="purplebg" readonly>
						  <button class="ui button tiny" type="button" id="verified_btn_patmedication">Verifiy</button>
						</div>`
					);

					$('#patmedication_tbl').off('click','button#verified_btn_patmedication');
					$('#patmedication_tbl').on('click','button#verified_btn_patmedication', function(){
						emptyFormdata([],'form#verify_form');
				  		$('#verify_btn').off();
				  		$('#verify_btn').on('click',function(){
							if($("form#verify_form").valid()) {
				  				verifyuser_medication();
							}
				  		});
				  		$('#password_mdl').modal('show');
				  		$('body,#password_mdl').addClass('scrolling');
				  		$('#verify_error').hide();
					});
				}
   			}
   		},
        {targets: 8,
        	createdCell: function (td, cellData, rowData, row, col) {
				if(cellData == '') {
					$(td).append(`<button class="ui tiny primary button" id="patmedication_save" type="button" >Save</button>
								  <button class="ui tiny red button" id="patmedication_cancel" type="button" >Cancel</button>
									`);

					$('#patmedication_tbl').off('click','button#patmedication_save');
					$('#patmedication_tbl').on('click','button#patmedication_save', function(){
						if($('#patmedication_enteredby').val().trim() == '' || $('#patmedication_verifiedby').val().trim() == ''){
							alert('Entered all field before click save');
						}else{
    						$('#patmedication_trx_tbl tbody tr').removeClass('blue');
							$('#patmedication_tbl').data('addmode',false);

							var param = {
								action: 'patmedication_save',
								oper: 'add',
								mrn:$("#mrn").val(),
								episno:$("#episno").val(),
								date:$("#visit_date").val()
							}

							var obj = {
								_token: $("#_token").val(),
								chgtrx_idno: $('#patmedication_trx_tbl_idno').val(),
								verifiedby: $('#patmedication_verifiedby').val().trim()
							}

							$.post( "./dialysis/form?"+$.param(param),obj, function( data ){
								if(data.success == 'success'){
									load_patmedication($("#mrn").val(),$("#episno").val(),$("#visit_date").val());
									load_patmedication_trx($("#mrn").val(),$("#episno").val(),$("#visit_date").val());
								}
							},'json');
						}
					});

					$('#patmedication_tbl').off('click','button#patmedication_cancel');
					$('#patmedication_tbl').on('click','button#patmedication_cancel', function(){
						$('#patmedication_tbl').data('addmode',false);
						load_patmedication($("#mrn").val(),$("#episno").val(),$("#visit_date").val());
						load_patmedication_trx($("#mrn").val(),$("#episno").val(),$("#visit_date").val());
					});
				}else{
					$(td).html(`<i class="check icon green"></i>`);
				}
   			}
   		},
    ],
    drawCallback: function( settings ) {

    }
});

function load_patmedication_trx(mrn,episno,date){
	patmedicationParam={
		action:'get_table_patmedication_trx',
		mrn:mrn,
		episno:episno,
		date:date
	}

	$('#patmedication_tbl').data('addmode',false);
	patmedication_trx_tbl.ajax.url( "./dialysis/table?"+$.param(patmedicationParam) ).load();
} 

function load_patmedication(mrn,episno,date){
	patmedicationParam={
		action:'get_table_patmedication',
		mrn:mrn,
		episno:episno,
		date:date
	}

	patmedication_tbl.ajax.url( "./dialysis/table?"+$.param(patmedicationParam) ).load();
} 

function verifyuser_medication(){
	var param={
		action:'verifyuser',
		username:$('#username_verify').val(),
		password:$('#password_verify').val(),
    };

    $.get( "./verifyuser_dialysis?"+$.param(param), function( data ) {

    },'json').done(function(data) {
    	if(data.success == 'fail'){
  			$('#verify_error').show();
    	}else{
    		$('#patmedication_verifiedby').val($('#username_verify').val());
  			$('#verify_error').hide();
  			$('#password_mdl').modal('hide');
    	}
    }).fail(function(data){
        alert('error verify');
    });
}