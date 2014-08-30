$(document).ready(function(){	
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
	$('#simpledate, #birthday').datepicker({dateFormat: 'yy-mm-dd'});
	$('.result_apply').fadeOut(5000);
	// Sample for url get from javascript
	//alert($.getUrlVar());
	if ($.getUrlVar('ref')) {
		current_url = $.getUrlVar('ref');
		//alert(current_url);
		if (typeof($('.listing_data').find('#'+'row_' + current_url)) == 'object') {
			$('.listing_data')
			.find('#'+'row_' + current_url)
			.removeClass("listing_odd listing_even")
			.hide('fast')
			.show('fast')
			.addClass("green_row");
		}
	}
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