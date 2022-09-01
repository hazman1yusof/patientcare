$(document).ready(function () {
	disableForm('form#daily_form');
	disableForm('form#daily_form_completed');

	$('#password_mdl').modal({centered: true,closable:false});

	$("form#daily_form").validate({
		ignore: [], //check jgk hidden
	  	invalidHandler: function(event, validator) {
	  		validator.errorList.forEach(function(e,i){
	  			if($(e.element).is("select")){
	  				$(e.element).parent().addClass('error');
	  			}
	  		});
	  	},
	  	errorPlacement: function(error, element) { }
	});

	$("form#daily_form_completed").validate({
		ignore: [], //check jgk hidden
	  	errorPlacement: function(error, element) { }
	});

	$("form#verify_form").validate({
		ignore: [], //check jgk hidden
	  	errorPlacement: function(error, element) { }
	});


    $('form#daily_form .ui.dropdown').dropdown({
    	onChange: function(value, text, $selectedItem) {
    		// console.log($selectedItem.parent());
	    	$selectedItem.parent().parent().removeClass('error')
	    }
	});
	
	button_state_dialysis('disableAll');
	$('#new_dialysis').click(function(){
		button_state_dialysis('wait');
		enableForm('form#daily_form');
		rdonly('form#daily_form');
		add_edit_mode();
		populate_other_data();
		$('#complete_dialysis').prop('disabled',false);
	});

	$('#edit_dialysis').click(function(){
		button_state_dialysis('wait');
		enableForm('form#daily_form');
		enableForm('form#daily_form_completed');
		rdonly('form#daily_form');
		add_edit_mode();
		$('#complete_dialysis').prop('disabled',false);
	});

	$('#cancel_dialysis').click(function(){
		button_state_dialysis($(this).data('oper'));
		$('#complete_dialysis').prop('disabled',true);
		off_edit_mode();
		if($(this).data('oper') == 'add'){
			disableForm('form#daily_form');
			disableForm('form#daily_form_completed');
			emptyFormdata([],'form#daily_form');
			emptyFormdata([],'form#daily_form_completed');
			$('form#daily_form .ui.dropdown').dropdown('restore defaults');
			$('form#daily_form input,form#daily_form div').removeClass('valid').removeClass('error');
		}else{
			autoinsert_rowdata_dialysis('form#daily_form',last_dialysis_data);
			autoinsert_rowdata_dialysis('form#daily_form_completed',last_dialysis_data);
			disableForm('form#daily_form');
			disableForm('form#daily_form_completed');
			$('form#daily_form input,form#daily_form div').removeClass('valid').removeClass('error');
		}
	});

	$('#save_dialysis').click(function(){
		if($("form#daily_form").valid()) {
			var param = {
				_token: $("#_token").val(),
				action: 'save_dialysis',
				oper: $('#cancel_dialysis').data('oper'),
				arrivalno: $('#dialysis_episode_idno').val(),
				mrn:$("#mrn").val(),
				episno:$("#episno").val(),
				visit_date:$("#visit_date").val()
			}

			var values = $("form#daily_form").serializeArray();

			$.post( "./save_dialysis?"+$.param(param),$.param(values), function( data ){
				$('#cancel_dialysis').data('oper','edit');
				button_state_dialysis('edit');
				$('#complete_dialysis').prop('disabled',true);
				disableForm('form#daily_form');
				disableForm('form#daily_form_completed');
			},'json');
		}
	});

	$('#complete_dialysis').click(function(){
		if($("form#daily_form_completed").valid()) {
			var param = {
				_token: $("#_token").val(),
				action: 'save_dialysis_completed',
				arrivalno: $('#dialysis_episode_idno').val(),
				mrn:$("#mrn").val(),
				episno:$("#episno").val(),
				visit_date:$("#visit_date").val()
			}

			var values = $("form#daily_form_completed").serializeArray();

			$.post( "./save_dialysis_completed?"+$.param(param),$.param(values), function( data ){
				$('#cancel_dialysis').data('oper','edit');
				button_state_dialysis('edit');
				$('#complete_dialysis').prop('disabled',true);
				disableForm('form#daily_form');
				disableForm('form#daily_form_completed');
			},'json');
		}
	});

	$("#tab_daily").on("show.bs.collapse", function(){
		closealltab("#tab_daily");
		button_state_dialysis('disableAll');
		check_pt_mode();
	});

	$("#tab_daily").on("hide.bs.collapse", function(){
		$('#cancel_dialysis').click();
		$('select#dialysisbefore').dropdown('restore defaults');
	});

	$("#tab_daily").on("shown.bs.collapse", function(){
		SmoothScrollTo('#tab_daily', 300,undefined,90);
	});

	$("#tab_weekly").on("show.bs.collapse", function(){
		closealltab("#tab_weekly");
	});

	$("#tab_weekly").on("shown.bs.collapse", function(){
		closealltab("#tab_weekly");
		SmoothScrollTo('#tab_weekly', 300,undefined,90);
	});

	$("#tab_monthly").on("show.bs.collapse", function(){
		closealltab("#tab_monthly");
	});

	$("#tab_monthly").on("shown.bs.collapse", function(){
		closealltab("#tab_monthly");
		SmoothScrollTo('#tab_monthly', 300,undefined,90);
	});

	$('#submit').click(function(){

		if($('form#daily_form').form('validate form')) {
			var param = {
				_token: $("#_token").val(),
				action: 'save_dialysis',
				oper: $(this).data('oper'),
				mrn:$("#mrn").val(),
				episno:$("#episno").val(),
				seldate:$("#seldate").val()
			}

			var values = $("form#daily_form").serializeArray();

			$.post( "./save_dialysis?"+$.param(param),$.param(values), function( data ){
				if(data.success == 'success'){
					$('#addnew_dia').prop('disabled',true);
					$('#edit_dia').prop('disabled',false);
					disableForm('form#daily_form');
					$('#toTop').click();
					toastr.success('Dialysis data saved!',{timeOut: 1000});
					SmoothScrollTo('#tab_daily', 300,undefined,90);
				}
			},'json');
		}

	});

	$('#rec_monthly_but').click(function(){
		cleartabledata('monthly');
		var param = {
			action: 'get_dia_monthly',
			date:$("#selectmonth").val(),
			mrn:$("#mrn").val(),
			episno:$("#episno").val()
		}

		$.get("./get_data_dialysis?"+$.param(param), function(data) {
			populate_data('monthly',data.data);
		},'json');

	});

	$('#selectweek_from').change(function(){
		let value =  $(this).val();
		let valueto = moment(value).add(7, 'days').format("YYYY-MM-DD");
		$('#selectweek_to').val(valueto);
	})

	$('#weeklyDatePicker').on('dp.change', function (e) {
    	value = $("#weeklyDatePicker").val();
	    firstDate = moment(value, "MM-DD-YYYY").day(0).format("MM-DD-YYYY");
	    lastDate =  moment(value, "MM-DD-YYYY").day(6).format("MM-DD-YYYY");
	    $("#weeklyDatePicker").val(firstDate + "   -   " + lastDate);
	});

	$('#rec_weekly_but').click(function(){
		cleartabledata('weekly');
		var param = {
			action: 'get_dia_weekly',
			datefrom:$("#selectweek_from").val(),
			dateto:$("#selectweek_to").val(),
			mrn:$("#mrn").val(),
			episno:$("#episno").val()
		}

		$.get("./get_data_dialysis?"+$.param(param), function(data) {
			populate_data('weekly',data.data);
		},'json');

	});	

  	$('#verified_btn').click(function(){
  		if(!$('#save_dialysis').is("[disabled]")){
	  		emptyFormdata([],'form#verify_form');
	  		$('#verify_btn').off();
	  		$('#verify_btn').on('click',function(){
				if($("form#verify_form").valid()) {
	  				verifyuser();
				}
	  		});
	  		$('#password_mdl').modal('show');
	  		$('body,#password_mdl').addClass('scrolling');
	  		$('#verify_error').hide();
  		}
  	});


});

function populate_data(type,data){
	if(type == 'monthly'){
		data.forEach(function(e,i){
			$('table#dia_monthly tr#visit_date_m').children('td').eq(i).text(e.start_date);
			$('table#dia_monthly tr#start_time_m').children('td').eq(i+1).text(e.start_time);
			$('table#dia_monthly tr#dialyser_m').children('td').eq(i+1).text(e.dialyser);
			$('table#dia_monthly tr#no_of_use_m').children('td').eq(i+1).text(e.no_of_use);
			$('table#dia_monthly tr#target_uf_m').children('td').eq(i+1).text(e.target_uf);
			$('table#dia_monthly tr#heparin_bolus_m').children('td').eq(i+1).text(e.heparin_bolus);
			$('table#dia_monthly tr#heparin_maintainance_m').children('td').eq(i+1).text(e.heparin_maintainance);
			$('table#dia_monthly tr#dialysate_ca_m').children('td').eq(i+1).text(e.dialysate_ca);
			$('table#dia_monthly tr#pre_weight_m').children('td').eq(i+1).text(e.pre_weight);
			$('table#dia_monthly tr#idwg_m').children('td').eq(i+1).text(e.idwg);
			$('table#dia_monthly tr#prehd_tmp_m').children('td').eq(i+1).text( e.prehd_temperature+' / '+e.prehd_pulse+' / '+e.prehd_respiratory);
			$('table#dia_monthly tr#prehd_bp_m').children('td').eq(i+1).text(e.prehd_systolic+' / '+e.prehd_diastolic);
			$('table#dia_monthly tr#pulse_pre_m').children('td').eq(i+1).text(e.prehd_pulse);
			$('table#dia_monthly tr#prehd_bfr_m').children('td').eq(i+1).text(e.prehd_bfr);
			$('table#dia_monthly tr#prehd_dfr_m').children('td').eq(i+1).text(e.prehd_dfr);
			$('table#dia_monthly tr#prehd_vp_m').children('td').eq(i+1).text(e.prehd_vp);
			$('table#dia_monthly tr#rec_2_m').children('td').eq(i+1).text(e.rec_2);
			$('table#dia_monthly tr#1_bp_m').children('td').eq(i+1).text(e['1_bp']);
			$('table#dia_monthly tr#1_pulse_m').children('td').eq(i+1).text(e['1_pulse']);
			$('table#dia_monthly tr#1_dh_m').children('td').eq(i+1).text(e['1_dh']);
			$('table#dia_monthly tr#1_bfr_m').children('td').eq(i+1).text(e['1_bfr']);
			$('table#dia_monthly tr#1_vp_m').children('td').eq(i+1).text(e['1_vp']);
			$('table#dia_monthly tr#1_tmp_m').children('td').eq(i+1).text(e['1_tmp']);
			$('table#dia_monthly tr#1_uv_m').children('td').eq(i+1).text(e['1_uv']);
			$('table#dia_monthly tr#1_f_m').children('td').eq(i+1).text(e['1_f']);
			$('table#dia_monthly tr#posthd_bp_m').children('td').eq(i+1).text(e.posthd_bp);
			$('table#dia_monthly tr#posthd_temperatue_m').children('td').eq(i+1).text(e.posthd_temperatue);
			$('table#dia_monthly tr#posthd_pulse_m').children('td').eq(i+1).text(e.posthd_pulse);
			$('table#dia_monthly tr#posthd_respiratory_m').children('td').eq(i+1).text(e.posthd_respiratory);
			$('table#dia_monthly tr#post_weight_m').children('td').eq(i+1).text(e.post_weight);
			$('table#dia_monthly tr#weight_loss_m').children('td').eq(i+1).text(e.weight_loss);
			$('table#dia_monthly tr#time_complete_m').children('td').eq(i+1).text(e.time_complete);
			$('table#dia_monthly tr#hd_adequancy_m').children('td').eq(i+1).text(e.hd_adequancy);
			$('table#dia_monthly tr#ktv_m').children('td').eq(i+1).text(e.ktv);
			$('table#dia_monthly tr#medication_m').children('td').eq(i+1).text(e.medication);
		});

	}else if(type == 'weekly'){
		data.forEach(function(e,i){
			$('table#dia_weekly tr#visit_date_w').children('td').eq(i).text(e.start_date);
			$('table#dia_weekly tr#start_time_w').children('td').eq(i+1).text(e.start_time);
			$('table#dia_weekly tr#dialyser_w').children('td').eq(i+1).text(e.dialyser);
			$('table#dia_weekly tr#no_of_use_w').children('td').eq(i+1).text(e.no_of_use);
			$('table#dia_weekly tr#target_uf_w').children('td').eq(i+1).text(e.target_uf);
			$('table#dia_weekly tr#heparin_bolus_w').children('td').eq(i+1).text(e.heparin_bolus);
			$('table#dia_weekly tr#heparin_maintainance_w').children('td').eq(i+1).text(e.heparin_maintainance);
			$('table#dia_weekly tr#dialysate_ca_w').children('td').eq(i+1).text(e.dialysate_ca);
			$('table#dia_weekly tr#pre_weight_w').children('td').eq(i+1).text(e.pre_weight);
			$('table#dia_weekly tr#idwg_w').children('td').eq(i+1).text(e.idwg);
			$('table#dia_weekly tr#prehd_tmp_w').children('td').eq(i+1).text( e.prehd_temperature+' / '+e.prehd_pulse+' / '+e.prehd_respiratory);
			$('table#dia_weekly tr#prehd_bp_w').children('td').eq(i+1).text(e.prehd_systolic+' / '+e.prehd_diastolic);
			$('table#dia_weekly tr#pulse_pre_w').children('td').eq(i+1).text(e.prehd_pulse);
			$('table#dia_weekly tr#prehd_bfr_w').children('td').eq(i+1).text(e.prehd_bfr);
			$('table#dia_weekly tr#prehd_dfr_w').children('td').eq(i+1).text(e.prehd_dfr);
			$('table#dia_weekly tr#prehd_vp_w').children('td').eq(i+1).text(e.prehd_vp);
			$('table#dia_weekly tr#rec_2_w').children('td').eq(i+1).text(e.rec_2);
			$('table#dia_weekly tr#1_bp_w').children('td').eq(i+1).text(e['1_bp']);
			$('table#dia_weekly tr#1_pulse_w').children('td').eq(i+1).text(e['1_pulse']);
			$('table#dia_weekly tr#1_dh_w').children('td').eq(i+1).text(e['1_dh']);
			$('table#dia_weekly tr#1_bfr_w').children('td').eq(i+1).text(e['1_bfr']);
			$('table#dia_weekly tr#1_vp_w').children('td').eq(i+1).text(e['1_vp']);
			$('table#dia_weekly tr#1_tmp_w').children('td').eq(i+1).text(e['1_tmp']);
			$('table#dia_weekly tr#1_uv_w').children('td').eq(i+1).text(e['1_uv']);
			$('table#dia_weekly tr#1_f_w').children('td').eq(i+1).text(e['1_f']);
			$('table#dia_weekly tr#posthd_bp_w').children('td').eq(i+1).text(e.posthd_bp);
			$('table#dia_weekly tr#posthd_temperatue_w').children('td').eq(i+1).text(e.posthd_temperatue);
			$('table#dia_weekly tr#posthd_pulse_w').children('td').eq(i+1).text(e.posthd_pulse);
			$('table#dia_weekly tr#posthd_respiratory_w').children('td').eq(i+1).text(e.posthd_respiratory);
			$('table#dia_weekly tr#post_weight_w').children('td').eq(i+1).text(e.post_weight);
			$('table#dia_weekly tr#weight_loss_w').children('td').eq(i+1).text(e.weight_loss);
			$('table#dia_weekly tr#time_complete_w').children('td').eq(i+1).text(e.time_complete);
			$('table#dia_weekly tr#hd_adequancy_w').children('td').eq(i+1).text(e.hd_adequancy);
			$('table#dia_weekly tr#ktv_w').children('td').eq(i+1).text(e.ktv);
			$('table#dia_weekly tr#medication_w').children('td').eq(i+1).text(e.medication);
		});
	}
}

function populate_other_data(data=last_other_data){
	if(data != null){
		$('#duration_of_hd').val(data.duration_hd);
		$('#dry_weight').val(data.dry_weight);
		$('#prev_post_weight').val(data.prev_post_weight);
		$('#initiated_by').val(data.initiated_by);
		if(data.last_visit != ''){
			$('#last_visit').val(data.last_visit);
		}
	}
}

function cleartabledata(type){
	if(type == 'monthly'){
		$('table#dia_monthly td[align=center]').html('&nbsp;');
	}else if(type == 'weekly'){
		$('table#dia_weekly td[align=center]').html('&nbsp;');
	}
}

function populatedialysis(data){
	last_other_data=null;
	last_dialysis_data=null;
    emptied_dialysisb4();
	emptyFormdata([],'form#daily_form');
	disableForm('form#daily_form');
	$('span.metal').text(data.Name+' - MRN:'+data.MRN);
	$('#mrn').val(data.MRN);
	$('#episno').val(data.Episno);
}

function empty_dialysis(){
	$('#edit_dia,#addnew_dia').prop('disabled',true);
	disableForm('form#daily_form');
	$('#seldate').val('');
	$('span.metal').text('');
	$('#mrn').val('');
	$('#episno').val('');
	emptyFormdata([],'form#daily_form');
}

function button_state_dialysis(state){
	switch(state){
		case 'empty':
			$('#cancel_dialysis').data('oper','add');
			$('#new_dialysis,#save_dialysis,#cancel_dialysis,#edit_dialysis').attr('disabled',true);
			break;
		case 'add':
			$('select#dialysisbefore').parent().removeClass('disabled');
			$('#cancel_dialysis').data('oper','add');
			$("#new_dialysis,#current,#past").attr('disabled',false);
			$('#save_dialysis,#cancel_dialysis,#edit_dialysis').attr('disabled',true);
			break;
		case 'edit':
			$('select#dialysisbefore').parent().removeClass('disabled');
			$('#cancel_dialysis').data('oper','edit');
			$("#edit_dialysis").attr('disabled',false);
			$('#save_dialysis,#cancel_dialysis,#new_dialysis').attr('disabled',true);
			break;
		case 'wait':
			$('select#dialysisbefore').parent().addClass('disabled');
			$("#save_dialysis,#cancel_dialysis").attr('disabled',false);
			$('#edit_dialysis,#new_dialysis').attr('disabled',true);
			break;
		case 'disableAll':
			$('#new_dialysis,#edit_dialysis,#save_dialysis,#cancel_dialysis').attr('disabled',true);
			break;
	}

}

var last_dialysis_data=null;
var last_other_data=null;
function check_pt_mode(){
	var param={
        action:'check_pt_mode',
		mrn:$("#mrn").val(),
		episno:$("#episno").val(),
        dialysis_episode_idno:$('#dialysis_episode_idno').val()
    };

    $.get( "./check_pt_mode?"+$.param(param), function( data ) {

    },'json').done(function(data) {

    	if(data.datab4 != undefined || data.datab4 != null){
			dropdown_dialysisb4(data.datab4);
    	}

        if(data.mode == 'edit'){
			button_state_dialysis('edit');
			autoinsert_rowdata_dialysis('form#daily_form',data.data);
			autoinsert_rowdata_dialysis('form#daily_form_completed',data.data);
			last_dialysis_data = data.data;
        }else if(data.mode == 'add'){
			button_state_dialysis('add');
			last_other_data = data.other_data;
			populate_other_data(data.other_data);
        }else if(data.mode == 'disableAll'){
			button_state_dialysis('disableAll');
        }
    }).fail(function(data){
        alert('error in checking this patient mode..');
    });
}

function add_edit_mode(){
	$('#no_of_use').parent().addClass('disabled');
	$('#dialyser').on('change',function(){
		if($(this).val() == 'REUSE'){
			$('#no_of_use').attr('required','').parent().removeClass('disabled');

		}else{
			$('#no_of_use').val('');
			$('#no_of_use').dropdown('set text', '');
			$('#no_of_use').removeAttr('required').parent().addClass('disabled').removeClass('error');
		}
	});

	$('#pre_weight').on('blur',function(){
		let prev_post_weight = $('#prev_post_weight').val();
		let pre_weight = $('#pre_weight').val();
		let dry_weight = $('#dry_weight').val();

		if(pre_weight.trim() != '' && prev_post_weight.trim() != ''){
			let idwg = parseFloat(pre_weight) - parseFloat(prev_post_weight);
			$('#idwg').val(idwg.toFixed(2));
		}

		if(pre_weight.trim() != '' && dry_weight.trim() != '' ){
			let target_weight = parseFloat(pre_weight) - parseFloat(dry_weight);
			$('#target_weight').val(target_weight.toFixed(2));
		}
	});
}

function off_edit_mode(){
	$('#dialyser').off('change');
	$('#pre_weight').off('blur');
}

function autoinsert_rowdata_dialysis(form,rowData){
	$.each(rowData, function( index, value ) {
		var input=$(form+" [name='"+index+"']");
		if(input.is("[type=radio]")){
			$(form+" [name='"+index+"'][value='"+value+"']").prop('checked', true);
		}else if(input.is("[type=checkbox]")){
			if(value==1){
				$(form+" [name='"+index+"']").prop('checked', true);
			}
		}else if(input.is("textarea")){
			if(value !== null){
				let newval = value.replaceAll("</br>",'\n');
				input.val(newval);
			}
		}else if(input.is("select")){
			if(value !== null){
				input.dropdown('set selected', value);
			}
		}else{
			input.val(value);
		}
	});
}

function emptied_dialysisb4(){
	$('select#dialysisbefore').dropdown('setup menu', {values: [
		{value:0,text:'No dialysis Record',name:'No dialysis Record'}
	]});
}

function dropdown_dialysisb4(datab4){
	let arrayb4 =  [{
			value:0,text:'Today',name:'Today'
		}];

	datab4.forEach(function(e,i){
		arrayb4.push({
			value:e.idno,text:e.visit_date,name:e.visit_date
		});
	});

	$('select#dialysisbefore').dropdown('setup menu', {values: arrayb4});

	$('select#dialysisbefore').dropdown('setting', 'onChange', function(value, text, $selectedItem){
		if(parseInt(value)>0){
			button_state_dialysis('disableAll');
			get_dialysis_daily(value);
		}else{
			if(last_dialysis_data!=null){
				button_state_dialysis('edit');
				autoinsert_rowdata_dialysis('form#daily_form',last_dialysis_data);
				autoinsert_rowdata_dialysis('form#daily_form_completed',last_dialysis_data);
				$('#visit_date').val(last_dialysis_data.visit_date);
			}else{
				button_state_dialysis('add');
				emptyFormdata([],'form#daily_form');
				emptyFormdata([],'form#daily_form_completed');
				$('form#daily_form .ui.dropdown').dropdown('restore defaults');
				$('#visit_date').val($('#sel_date').val());
			}
		}
	});
}

function get_dialysis_daily(idno){
	var param={
        idno:idno,
		action:'get_dia_daily'
    };

    $.get( "./get_data_dialysis?"+$.param(param), function( data ) {

    },'json').done(function(data) {
		autoinsert_rowdata_dialysis('form#daily_form',data.data);
		autoinsert_rowdata_dialysis('form#daily_form_completed',data.data);
		$('#visit_date').val(data.data.visit_date);
    }).fail(function(data){
        alert('error in get data');
    });
}

function verifyuser(){
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
    		$('#verified_by').val($('#username_verify').val());
  			$('#verify_error').hide();
  			$('#password_mdl').modal('hide');
    	}
    }).fail(function(data){
        alert('error verify');
    });
}