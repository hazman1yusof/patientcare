
$(document).ready(function () {

	disableForm('#formphys_ncase');
	$('.ui.radio.checkbox').checkbox();

	$("#new_phys_ncase").click(function(){
		button_state_phys_ncase('wait');
		enableForm('#formphys_ncase');
		rdonly('#formphys_ncase');

	});

	$("#edit_phys_ncase").click(function(){
		button_state_phys_ncase('wait');
		enableForm('#formphys_ncase');
		rdonly('#formphys_ncase');
	});

	$(".ui.toggle.button").click(function(){
		$('.ui.toggle.button').removeClass('active');
		$(this).addClass('active');
		$('#risk_phys_ncase').val($(this).data('risk'));
	});


	$("#save_phys_ncase").click(function(){
		// disableForm('#formphys_ncase');

		if($('#category_phys_ncase').val().trim() == "" ){
			alert('Please select either Rehabilitation or Physioteraphy');
		}else if( $('#formphys_ncase').isValid({requiredFields: ''}, conf, true) ) {
			saveForm_phys_ncase(function(){
				$("#cancel_phys_ncase").data('oper','edit');
				$("#cancel_phys_ncase").click();
				button_state_phys_ncase('edit');
			});
		}else{
			enableForm('#formphys_ncase');
			rdonly('#formphys_ncase');
		}

	});

	$("#cancel_phys_ncase").click(function(){
		disableForm('#formphys_ncase');
		button_state_phys_ncase($(this).data('oper'));
		// dialog_mrn_edit.off();

	});

	button_state_phys_ncase('empty');

	$('a.ui.card.bodydia_ncase').click(function(){
		let mrn = $('#mrn_phys').val();
		let type = $(this).data('type');
		let istablet = $(window).width() <= 1024;

		if(mrn.trim() == '' || type.trim() == ''){
			alert('Please choose Patient First');
		}else if($('#save_phys_ncase').prop('disabled')){
			alert('Edit this patient first');
		}else{
			if(istablet){
				let filename = type+'_'+mrn+'_.pdf';
				let url = $('#urltodiagram').val() + filename;
				var win = window.open(url, '_blank');
			}else{
				var win = window.open('http://foxitweb.test/pdf?mrn='+mrn+'&episno=&type='+type, '_blank');
			}

			if (win) {
			    win.focus();
			} else {
			    alert('Please allow popups for this website');
			}
		}
		
	});
	
});

function saveForm_phys_ncase(callback){
	var saveParam={
        action:'save_table_phys_ncase',
        oper:$("#cancel_phys_ncase").data('oper')
    }

    var postobj={
    	mrn:$('#mrn_phys').val(),
    	episno:$('#episno_phys').val(),
    	_token : $('#_token').val(),
    };

	values = $("#formphys_ncase").serializeArray();

	values = values.concat(
        $('#formphys_ncase input[type=radio]:checked').map(
        function() {
            return {"name": this.name, "value": this.value}
        }).get()
    );

    $.post( "./phys/form?"+$.param(saveParam), $.param(postobj)+'&'+$.param(values) , function( data ) {
        
    },'json').fail(function(data) {
        // alert('there is an error');
        callback();
    }).done(function(data){
        callback();
    });
}

function button_state_phys_ncase(state){
	switch(state){
		case 'empty':
			// $("#toggle_phys_ncase").removeAttr('data-toggle');
			$('#cancel_phys_ncase').data('oper','add');
			$('#new_phys_ncase,#save_phys_ncase,#cancel_phys_ncase,#edit_phys_ncase').attr('disabled',true);
			break;
		case 'add':
			// $("#toggle_phys_ncase").attr('data-toggle','collapse');
			$('#cancel_phys_ncase').data('oper','add');
			$("#new_phys_ncase").attr('disabled',false);
			$('#save_phys_ncase,#cancel_phys_ncase,#edit_phys_ncase').attr('disabled',true);
			break;
		case 'edit':
			// $("#toggle_phys_ncase").attr('data-toggle','collapse');
			$('#cancel_phys_ncase').data('oper','edit');
			$("#edit_phys_ncase").attr('disabled',false);
			$('#save_phys_ncase,#cancel_phys_ncase,#new_phys_ncase').attr('disabled',true);
			break;
		case 'wait':
			// $("#toggle_phys_ncase").attr('data-toggle','collapse');
			$("#save_phys_ncase,#cancel_phys_ncase").attr('disabled',false);
			$('#edit_phys_ncase,#new_phys_ncase').attr('disabled',true);
			break;
	}

}

function empty_currphys_ncase(){
	button_state_phys_ncase('empty');
	$("#formphys_ncase input[type=radio][value=no]").prop("checked", true); 
	emptyFormdata_div("#formphys_ncase");
	$('.ui.toggle.button').removeClass('active');
}

function populate_phys_ncase(obj){
	curr_obj=obj;
	
	$("#formphys_ncase input[type=radio][value=no]").prop("checked", true); 
	emptyFormdata_div("#formphys_ncase");

	if(obj.reff_rehab=='YES'){
		$('.ui.checkbox.rehab').checkbox('set checked');
		$('#category_phys').val('Rehabilitation');
		$('#category_phys_ncase').val('Rehabilitation');
	}else if(obj.reff_physio=='YES'){
		$('.ui.checkbox.phys').checkbox('set checked');
		$('#category_phys').val('Physioteraphy');
		$('#category_phys_ncase').val('Physioteraphy');
	}else if(obj.reff_diet=='YES'){
		$('.ui.checkbox.referdiet').checkbox('set checked');
		$('#referdiet_phys').val('yes');
		$('#referdiet_ncase').val('yes');
	}


	var phys_ncase_urlparam={
		action:'get_table_phys_ncase'
	};
    var postobj={
    	_token : $('#_token').val(),
		mrn:obj.MRN,
    };

	$.post( "./phys/form?"+$.param(phys_ncase_urlparam), $.param(postobj), function( data ) {
        
    },'json').fail(function(data) {
        alert('there is an error');
    }).done(function(data){
    	if(!$.isEmptyObject(data)){
			autoinsert_rowdata_phys_ncase("#formphys_ncase",data.patrehab_ncase);
			button_state_phys_ncase('edit');
        }else{
			button_state_phys_ncase('add');
        }

	});

}

function autoinsert_rowdata_phys_ncase(form,rowData){
	$.each(rowData, function( index, value ) {

		if(index == 'category'){
			if(value=='Rehabilitation'){
				$('.ui.checkbox.rehab').checkbox('set checked');
			}else if(value=='Physioteraphy'){
				$('.ui.checkbox.phys').checkbox('set checked');
			}
		}

		if(index == 'risk'){
			if(value=='low'){
				$('.ui.toggle.button.low').addClass('active');
			}else if(value=='moderate'){
				$('.ui.toggle.button.moderate').addClass('active');
			}else if(value=='high'){
				$('.ui.toggle.button.high').addClass('active');
			}
		}

		var input=$(form+" [name='"+index+"']");
		if(input.is("[type=radio]")){
			$(form+" [name='"+index+"'][value='"+value+"']").prop('checked', true);
		}else if(input.is("[type=checkbox]")){
			if(value==1){
				$(form+" [name='"+index+"']").prop('checked', true);
			}
		}else{
			input.val(value);
		}
	});
}