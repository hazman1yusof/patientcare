$(document).ready(function () {

	disableForm('form#daily_form');

	$('#submit').click(function(){

		if($('form#daily_form').form('validate form')) {
			var param = {
				_token: $("#_token").val(),
				action: 'save_dialysis',
				mrn:$("#mrn").val(),
				episno:$("#episno").val()
			}

			var values = $("form#daily_form").serializeArray();

			$.post( "/save_dialysis?"+$.param(param),$.param(values), function( data ){
				if(data.success == 'success'){
					$('#addnew_dia').prop('disabled',true);
					$('#edit_dia').prop('disabled',false);
					disableForm('form#daily_form');
					$('#toTop').click();
				}
			},'json');
		}

	});

	$('#daily_form')
	  .form({
	    fields: {
	      start_time     : 'empty',
	      prehd_weight   : 'empty',
	      hep_loading : 'empty'
	    },
	    onFailure: function (event, fields) {
	        let elem = $('.field.error input[type=text]:first');
	        $('html, body').animate({scrollTop: $(elem).offset().top -100 }, 'slow', function () {
	          $(elem).focus();
	        });
	    },

	 });

	  $('#addnew_dia').click(function(){
		enableForm('form#daily_form');
		$('form#daily_form #start_time').focus();
	  });

	  $('#edit_dia').click(function(){
		enableForm('form#daily_form');
	  });

	  $('#rec_monthly_but').click(function(){
	  	var param = {
			action: 'get_dia_monthly',
			date:$("#selectmonth").val()
		}

	  	$.get("/get_data_dialysis?"+$.param(param), function(data) {
			populate_data('monthly',data.data);
		},'json');

	  });

});

function populate_data(type,data){
	if(type == 'monthly'){
		data.forEach(function(e,i){
			$('table#dia_monthly tr#monthly_date').children('td').eq(i).text(e.start_date);
			$('table#dia_monthly tr#start_time').children('td').eq(i).text(e.start_time);
			$('table#dia_monthly tr#end_time').children('td').eq(i).text(e.end_time);
			$('table#dia_monthly tr#type_dialyser').children('td').eq(i).text(e.type_dialyser);
			$('table#dia_monthly tr#noofuse').children('td').eq(i).text(e.noofuse);
			$('table#dia_monthly tr#total_uf').children('td').eq(i).text(e.total_uf);
			$('table#dia_monthly tr#hep_loading').children('td').eq(i).text(e.hep_loading);
			$('table#dia_monthly tr#hep_infusion').children('td').eq(i).text(e.hep_infusion);
			$('table#dia_monthly tr#dialysate_calcium').children('td').eq(i).text(e.dialysate_calcium);
			$('table#dia_monthly tr#prehd_weight').children('td').eq(i).text(e.prehd_weight);
			$('table#dia_monthly tr#dialytic_weight').children('td').eq(i).text(e.dialytic_weight);
			$('table#dia_monthly tr#bp_pre').children('td').eq(i).text(e.bp_pre);
			$('table#dia_monthly tr#pulse_pre').children('td').eq(i).text(e.pulse_pre);
			$('table#dia_monthly tr#rec_2').children('td').eq(i).text(e.rec_2);
			$('table#dia_monthly tr#tmp_2').children('td').eq(i).text(e.tmp_2);
			$('table#dia_monthly tr#bp_2').children('td').eq(i).text(e.bp_2);
			$('table#dia_monthly tr#pulse_2').children('td').eq(i).text(e.pulse_2);
			$('table#dia_monthly tr#hepn_1').children('td').eq(i).text(e.hepn_1);
			$('table#dia_monthly tr#bf_2').children('td').eq(i).text(e.bf_2);
			$('table#dia_monthly tr#uf_rate_1').children('td').eq(i).text(e.uf_rate_1);
			$('table#dia_monthly tr#df_2').children('td').eq(i).text(e.df_2);
			$('table#dia_monthly tr#vp_2').children('td').eq(i).text(e.vp_2);
			$('table#dia_monthly tr#rec_3').children('td').eq(i).text(e.rec_3);
			$('table#dia_monthly tr#tmp_3').children('td').eq(i).text(e.tmp_3);
			$('table#dia_monthly tr#bp_3').children('td').eq(i).text(e.bp_3);
			$('table#dia_monthly tr#pulse_3').children('td').eq(i).text(e.pulse_3);
			$('table#dia_monthly tr#hepn_2').children('td').eq(i).text(e.hepn_2);
			$('table#dia_monthly tr#uf_rate_2').children('td').eq(i).text(e.uf_rate_2);
			$('table#dia_monthly tr#df_3').children('td').eq(i).text(e.df_3);
			$('table#dia_monthly tr#vp_3').children('td').eq(i).text(e.vp_3);
			$('table#dia_monthly tr#rec_4').children('td').eq(i).text(e.rec_4);
			$('table#dia_monthly tr#tmp_4').children('td').eq(i).text(e.tmp_4);
			$('table#dia_monthly tr#bp_4').children('td').eq(i).text(e.bp_4);
			$('table#dia_monthly tr#pulse_4').children('td').eq(i).text(e.pulse_4);
			$('table#dia_monthly tr#hepn_3').children('td').eq(i).text(e.hepn_3);
			$('table#dia_monthly tr#bf_4').children('td').eq(i).text(e.bf_4);
			$('table#dia_monthly tr#uf_rate_3').children('td').eq(i).text(e.uf_rate_3);
			$('table#dia_monthly tr#df_4').children('td').eq(i).text(e.df_4);
			$('table#dia_monthly tr#vp_4').children('td').eq(i).text(e.vp_4);
			$('table#dia_monthly tr#rec_post').children('td').eq(i).text(e.rec_post);
			$('table#dia_monthly tr#tmp_post').children('td').eq(i).text(e.tmp_post);
			$('table#dia_monthly tr#bp_post').children('td').eq(i).text(e.bp_post);
			$('table#dia_monthly tr#pulse_post').children('td').eq(i).text(e.pulse_post);
			$('table#dia_monthly tr#hepn_4').children('td').eq(i).text(e.hepn_4);
			$('table#dia_monthly tr#bf_post').children('td').eq(i).text(e.bf_post);
			$('table#dia_monthly tr#uf_rate_4').children('td').eq(i).text(e.uf_rate_4);
			$('table#dia_monthly tr#df_post').children('td').eq(i).text(e.df_post);
			$('table#dia_monthly tr#vp_post').children('td').eq(i).text(e.vp_post);
			$('table#dia_monthly tr#bp_sit').children('td').eq(i).text(e.bp_sit);
			$('table#dia_monthly tr#pulse_stand').children('td').eq(i).text(e.pulse_stand);
			$('table#dia_monthly tr#hd_weight').children('td').eq(i).text(e.hd_weight);
			$('table#dia_monthly tr#ultra').children('td').eq(i).text(e.ultra);
			$('table#dia_monthly tr#kt_v').children('td').eq(i).text(e.kt_v);
			$('table#dia_monthly tr#pre_verifier_name').children('td').eq(i).text(e.pre_verifier_name);
			$('table#dia_monthly tr#verifier_by').children('td').eq(i).text(e.verifier_by);
			$('table#dia_monthly tr#epo_type').children('td').eq(i).text(e.epo_type);
			$('table#dia_monthly tr#dose_type').children('td').eq(i).text(e.dose_type);
		});

	}
}

function populatedialysis(data,seldate){
	$('#addnew_dia').prop('disabled',false);
	disableForm('form#daily_form');
	$('#start_datexx').val(seldate);
	$('span.metal').text(data.p_name+' - MRN:'+data.e_mrn);
	$('#mrn').val(data.e_mrn);
	$('#episno').val(data.e_episno);
}

