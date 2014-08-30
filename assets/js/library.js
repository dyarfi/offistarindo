$(document).ready(function(){	
	// ======================== Ajax requests
	$('.language_select').click(function(){
		var data	= $(this).attr('rel');
		$.ajax({
			type: "POST",
			url: base_URL + 'xhr/language/' + data,
			data: data,
			cache: true,
			async: true,
			success: function(msg){
				// Redirect after request language
				$(location).attr('href', msg);
			},
			complete: function(msg) {},
			error: function(msg) {}
		});
		return false;	
	});		
	$(".iframe, .member_only").colorbox({
		iframe:true, 
		width:"55%", 
		height:560,
		innerWidth:682, 
		innerHeight:560,
		fixed:true, 
		title:true, 
		//onClosed:function(){ if ($.getUrlVar('ref') != 'nav'); parent.location.reload(); },
		returnFocus:true
	});
	// Send data to count hits 
	$('.download_file').click(function(){
		url = $(this).attr('href');
		rel = $(this).attr('rel');
		$.ajax({
			type: "POST",
			url: url,
			data: 'file='+rel,
			async: false,			
			success: function(msg){
				// Do nothing
			}
		});
	});	
	$("a.btn-form").click(function() {
		var button = $(this);
		var rel = button.attr('rel');
		var href = button.attr('href');
		
		var title = document.title;
		var desc_div = $(document).attr('title');

		if (title.indexOf($(this).text())) {
			$.address.title($(this).text() + ' - ' + desc_div);
		} else {

		}

		//Jquery Ajax SEO Crawller
		//$('a:not([href^=http])').address();
		$.address.value(href.replace(/^#!/, ''));
		$.address.update();
				
		//$.address.change(function(event){
			//alert(event.toString());
			//button.click();
		//});
		
		$(".form-control-button li a").removeClass('active');
		$(this).addClass('active');
		$('#main-content').find('section').hide();
		$('#main-content').find('section[id="'+rel+'"]').show();
		
	});


    // when the tab is selected update the url with the hash
    //$("#main_tabs").bind("tabsselect", function(event, ui) { 
        //window.location.hash = ui.tab.hash;
    //});
	
	$(".form-control-button li a").each(function() { 
		//var button = $(this);
		 // For forward and back
		//$.address.change(function(event){
			//button.click();
		//});
	}).eq(0).click();	
	
	$('.tooltips').tooltip({delay: { show: 500, hide: 100 }});
	$('#corporate-form').on('submit',function(e) {
		e.preventDefault();		
		// Set preloader
		var loader = $(this).find('.loader');
		loader.show();		
		// Set callback
		var callback = $(this).find('.callback');
		callback.empty().show();		
		// Set callback alert
		var alerts = $(this).find('.label-danger');
		alerts.empty();		
		// Set ajax post handler
		var url = $(this).attr('action');
		//alert(url);
		//return false;
		$.ajax({
			type: "POST",
			url: url,
			data: $(this).serialize(),
			//timeout: 8000,
			dataType: "JSON",
			cache: true,
			async: true,
			success: function(message) {
				if (message.result === 'sent') {
					window.location = base_URL + 'contact-us';
				}
				if (message.errors !== '') {
					$.each(message.errors, function (index, msg) {	
						$(msg).appendTo(callback);
					});										
					alerts.html(message.result);
				}  
				// Empty loader
				//callback.empty().hide();
				// Empty loader image
				loader.hide();
			},
			complete: function(message) { },
			error: function(x,message,t) { 
				if(message==="timeout") {
					//alert("got timeout");
				} else {
					//alert(message);
				}	
			}
		});		
		return false;
	});	
	$('#personal-form').on('submit',function(e) {
		e.preventDefault();		
		// Set preloader
		var loader = $(this).find('.loader');
		loader.show();		
		// Set callback
		var callback = $(this).find('.callback');
		callback.empty().show();		
		// Set callback alert
		var alerts = $(this).find('.label-danger');
		alerts.empty();		
		// Set ajax post handler
		var url = $(this).attr('action');
		//alert(url);
		//false;
		$.ajax({
			type: "POST",
			url: url,
			data: $(this).serialize(),
			//timeout: 8000,
			dataType: "JSON",
			cache: true,
			async: true,
			success: function(message) {
				if (message.result === 'sent') {
					window.location = base_URL + 'contact-us';
				}
				if (message.errors !== '') {
					$.each(message.errors, function (index, msg) {	
						$(msg).appendTo(callback);
					});										
					alerts.html(message.result);
				} 
				//alert(message);
				// Empty loader
				//callback.empty().hide();
				// Empty loader image
				loader.hide();
			},
			complete: function(message) { },
			error: function(x,message,t) { 
				if(message==="timeout") {
					//alert("got timeout");
				} else {
					//alert(message);
				}	
			}
		});		
		return false;
	});				   
   $('#category_pid').change( function () {		
			// Set ajax post handler
			var data = $(this).val();
			var url = $(this).attr('data-url');
			$.ajax({
				type: "POST",
				url: url,
				data: { 
					id : data
				},
				//cache: true,
				//async: true,
				timeout: 8000,
				dataType: "JSON",
				success: function(message) {
					// Parse JSON result
					//var data   = jQuery.parseJSON(message);
					if (message.products !== '') {
						$('#product_id').empty();
						$('<option value="0" name="product_id"/>').html('--- Product ---').appendTo('#product_id');
						if (message.products !== undefined) {
							$.each(message.products, function (index, product) {	
								if (product !=='') {							
									$('<option value="'+product.id+'" name="product_id"/>')
									.html(product.subject)
									.appendTo('#product_id');
								} 
							});
						} else {
								$('<option value="" name="product_id"/>')
								.html('No Product Available')
								.appendTo('#product_id');
						};
					}
					// Empty loader
					//$('#result_callback').empty();
					// Empty loader image
					//$('#loader').html('');
				},
				complete: function(message) { 

				},
				error: function(x,message,t) { 
					if(message==="timeout") {
						//alert("got timeout");
					} else {
						//alert(message);
					}	
				}
			});
		}
	);		
    $(".carousel").on({
		mouseenter: function(){$(this).find('.carousel-caption').animate({bottom:0});},
		mouseleave: function(){ $(this).find('.carousel-caption').animate({bottom:-200}); }
	});	
   	$(".colorbox").colorbox({rel:"groupbox", transition:"fade",width:"65%", height:"75%",
	'innerWidth':400,
	'innerHeight':300,
	'initialWidth':200,
	'initialHeight':200});
	$(".cboxinline").colorbox({inline:true, width:"55%",height:"80%"});
	$('#list-reseller li a').hover(function(){
		$(this).find('.caption').fadeIn(200);
	},function(){
		$(this).find('.caption').fadeOut(200);
	});
   $('.reload_captcha').click(function() {
		var url	= $(this).attr('href');		
		$.ajax({
			type: "POST",
			url: url,
			data: 'file=true',
			cache: false,
			async: false,	
			success: function(msg){
				$('.reload_captcha').empty().html(msg);
				// Need random for browser recache
				img		= $('.reload_captcha').find('.captcha');
				src		= img.attr('src');
				ran		= img.fadeOut(10).fadeIn(220).attr('src', src + '?=' + Math.random());
			},
			complete: function(msg) {},
			error: function(msg) {}
		});
		return false;	
	});	
	$('#carousel_home').carousel({interval: 6000});	
	$('#carousel_home').on('slide.bs.carousel', function () {$(this).fadeOut(350).fadeIn(350);});
	$('img.image1').data('ad-desc', 'Whoa! This description is set through elm.data("ad-desc") instead of using the longdesc attribute.<br>And it contains <strong>H</strong>ow <strong>T</strong>o <strong>M</strong>eet <strong>L</strong>adies... <em>What?</em> That aint what HTML stands for? Man...');	
    $('img.image1').data('ad-title', 'Title through $.data');
    $('img.image4').data('ad-desc', 'This image is wider than the wrapper, so it has been scaled down');
    $('img.image5').data('ad-desc', 'This image is higher than the wrapper, so it has been scaled down');
    var galleries = $('.ad-gallery').adGallery();
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
    $('#toggle-description').click(
      function() {
        if(!galleries[0].settings.description_wrapper) {
          galleries[0].settings.description_wrapper = $('#descriptions');
        } else {
          galleries[0].settings.description_wrapper = false;
        }
        return false;
      }
    );
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
	$('.acc_trigger:first').addClass('active');
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
		display_next_and_prev: false
		});
});

// Getting with javascript url from
$.extend({
  getUrlVars: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
});