$(document).ready(function() {
//function content tabs
	$("#content-tab .tabs").hide();
	$("#content-tab .tabs:first").show();
	$("#content-tab .nav-tab a").removeClass("active");
	$("#content-tab .nav-tab a:first").addClass("active");
	$("#content-tab .nav-tab a").click(function (e) {
		var target = $(this).attr("href");
		$("#content-tab .nav-tab a").removeClass("active");
		$(this).addClass("active");
		$("#content-tab .tabs").hide();
		$(target).show();
		return false;
	});
	
	$('.acc_container').css('display', 'none');
	$('.acc_trigger:first').next().css('display', 'block');
	$('.acc_trigger:first').addClass('active')
	$('.acc_trigger').click(function () {
		if ($(this).next().is(':hidden')) {
			$('.acc_trigger').removeClass('active').next().slideUp(400);
			$(this).toggleClass('active').next().slideDown(400);
		}
		return false;
	});
	var galleries = $('.ad-gallery').adGallery({
		thumb_opacity: 1,
		update_window_hash: false, 
		display_next_and_prev: false, 
		});
    
		
});
		
