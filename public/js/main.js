 $(document).ready(function() {
    $('#showSidebar').click(function(){
        $('.ui.sidebar').sidebar('toggle');
    });

    $('.ui.dropdown').dropdown()

    $('.ui.left.fixed.vertical.icon.menu a').popup({position:'right center'});

    /* Back to top fade */
	$(window).scroll(function (event) {
		var scroll = $(window).scrollTop();
	    $('#toTop').hide();
	    if (scroll > 200) {
	    	$('#toTop').show();
	    } else {
	    	$('#toTop').hide();
	    }

	    if (scroll == 0) {
	    	$('.fixed.top.menu').removeClass('slide up');
	    }
	});

	/* Scroll Event*/
    $('a[data-slide="slide"]').on('click', function(e) {
        e.preventDefault();

        var target = this.hash;
        var $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top - 90
        }, 900, 'swing');
    });

});