/**
 * @author Michel Lampo
 */
$(document).ready(function(){
	$('.no-js').hide();
	resizeWindow();
	fixer('#menu_fixer a', '#menu', 'fixed');
	fixer('#extrabar_fixer a', '#extrabar', 'fixed');
});


$(window).bind('resize', function() {
	resizeWindow();
});

resizeWindow = function() {
	var width = $(window).width();
	// not wider than 1300px in total, otherwise text would be to wide to be able to read it easealy
	width = width > 1300 ? 1300 : width;
	$('#main').width(width - 450);
	$('.fixer').css('position', 'relative');
	$('#menu').css('left', width - 400);
	$('#extrabar').css('left', width - 300);
	$('.fixer').css('position', 'fixed');
	
	$('#pagetext').height($('#window form').height() - 305);
}

fixer = function(link, target, fixed_class) {
	$(link).click(function() {
		$(target).toggleClass(fixed_class);
		$(this).html($(this).html() == 'Unfix'? 'Fix' : 'Unfix');
		return false;
	});
}