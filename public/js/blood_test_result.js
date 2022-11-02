$(document).ready(function () {

	$("#tab_bloodres").on("show.bs.collapse", function(){
		closealltab("#tab_bloodres");
	});

	$("#tab_bloodres").on("shown.bs.collapse", function(){
		closealltab("#tab_bloodres");
		SmoothScrollTo('#tab_bloodres', 300,undefined,90);
	});

	$('#month_year_br').calendar({
    	initialDate: new Date(),
   		type: 'month'
 	});

 	$('#rec_but_br').click(function(){
 		get_pagination_br();
 	});

	function clear_bloodres(type){
		$('table#bloodres td[align=center],table#bloodres td.med_td').html('&nbsp;');
	}

	$('#print_rec_br').click(function(){
		$('table#bloodres').printThis();
	});

	function get_pagination_br(){
		var param={
	        mrn:$('#mrn').val(),
	        episno:$('#episno').val(),
			action:'get_pagination_br',
			rows:10
	    };

	    $.get( "./bloodtest/table?"+$.param(param), function( data ) {

	    },'json').done(function(data) {
	    	make_pagintaion_br(data);
	    }).fail(function(data){
	    });
	}
});

function make_pagintaion_br(data){
		
	var curpage = parseInt(data.page);
	var lastpage = parseInt(data.total);

	$('div#paging_br').html('');
	for (var i = 0; i < data.total; i++) {
		if(i == parseInt(curpage-1)){
			$('div#paging_br').append(`<a class="active item">`+parseInt(i+1)+`</a>`);
		}else{
			$('div#paging_br').append(`<a class="item">`+parseInt(i+1)+`</a>`);
		}
	}

	data.rows.forEach(function(e,i){
		const entries = Object.entries(e);
		entries.forEach(function(e2,i2){
			if(e2[0] == 'sampledate'){
				$('table#bloodres tr#br_'+e2[0]).children('td').eq(i).text(e2[1]);
			}else{
				$('table#bloodres tr#br_'+e2[0]).children('td').eq(i+1).text(e2[1]);
			}
		});
	});
}