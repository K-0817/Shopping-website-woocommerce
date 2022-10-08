jQuery(window).scroll(function(){
	if (jQuery(window).scrollTop() > 65) {
        jQuery('.header-main').addClass('scroll');
    }
    else {
        jQuery('.header-main').removeClass('scroll');
    }
});