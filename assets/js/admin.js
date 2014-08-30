var cur_order = 0, order_buffer = new Array(), top_menu = new Array(), top_menu_w = 0, cur_menu_pos = 0, is_animated = false;

$(document).ready(function() {
		
	if ($.getUrlVar('current')) {
		current_tr = $.getUrlVar('current');
		if (typeof($('.listing_data').find('#'+'row_' + current_tr)) === 'object') {
			$('.listing_data')
			.find('#'+'row_' + current_tr)
			.removeClass("listing_odd listing_even")
			.hide('fast')
			.show('fast')
			.addClass("green_row");
		}
	}
	
	$('.iframe-btn').colorbox({	
	'width'		: 900,
	'height'	: 600,
	'iframe'	: 'true'
    });
	//$(".colorbox").colorbox({rel:"groupbox", transition:"fade",width:"65%", height:"75%"});		
	//$('.sortable tr:odd').addClass('even_row');
	$('.colorbox').live('click',function(e){
		// prevent default behaviour
		e.preventDefault();		
		$.colorbox({href:$(this).attr('href'), rel:"groupbox", transition:"fade" ,width:"65%", height:"75%",'innerWidth':400,'innerHeight':300,'initialWidth':200,'initialHeight':200});		
		return false;
	});
	/*
	$("#sortable").sortable({
		scroll: true,
		axis: "y",
		delay: 260,
		handle: "td",
		opacity:0.5,
		create: function(event, ui) {},
		start: function(event, ui) {},
		sort: function (event,ui) {},		
		change: function(event, ui) { },
		update: function(event, ui) {},
		stop: function(event, ui) { 		
			$(this).sortable("refresh");
			var info = $(this).sortable("toArray");			
			var baseURI = ui.item.context.baseURI;
			var order = [];
			var i = info.length;
			$.each(info, function(index,inf){ order[index] = '{"order":'+i--+',"id":"'+inf.replace('row_','')+'"}'; });			
			var oriTopPos   = ui.originalPosition.top;
			var oriPos		= ui.position.top;
			if (oriPos >= oriTopPos) {
				var reorder = ui.item.find('.td_show').attr('data-url').replace('/action/','/down/');
				$.ajax({url:reorder,type:'POST',data:{content:order},success:function(msg){ window.location = baseURI;}});
			} else {
				var reorder = ui.item.find('.td_show').attr('data-url').replace('/action/','/up/');
				$.ajax({url:reorder,type:'POST',data:{content:order},success:function(msg){ window.location = baseURI;}});
			}
		}		
	});
	$( "#sortable" ).disableSelection();
	*/
	
	/*
	$(".img-thumbnail").live(
        'hover',
        function (ev) {
            if (ev.type == 'mouseover') {
                $(this).find('.label-function').fadeIn();
            }

            if (ev.type == 'mouseout') {
                $(this).find('.label-function').fadeOut();
            }
        });
	*/	
   
	/*
	$('.img-thumbnail').hover(function(){
		$(this).find('.label-function').fadeIn();
	},function(){
		$(this).find('.label-function').fadeOut();
	});
	*/
   $('td.td_show').hover(function(){
		$(this).find('.show_order').show();
   },function(){
		$(this).find('.show_order').hide();   
   });
   
	var tabContainers = $('div#library_tab > div');
	tabContainers.hide().filter(':first').show();
	
	$('div#library_tab ul.add_media li a').click(function () {
		tabContainers.hide();
		//alert(tabContainers.parent().find('input[type="hidden"]').attr('value'));
		//if (tabContainers.find('input') !== '') {
			//tabContainers.find('input').attr("disabled", true);	
		//}
		//if (tabContainers.parent().find('input[type="hidden"]').attr('value') !=='') {
			//tabContainers.parent().find('input[type="hidden"]')
					//.attr('value',tabContainers.filter(this.hash).find('input').attr('value'));
		//};
		
		tabContainers.find('input').attr("disabled", true).attr("value", '');	
		tabContainers.filter(this.hash).find('input').attr("disabled", false);
		
		tabContainers.filter(this.hash).show();
		//tabContainers.filter(this.hash).find('input').attr('disable','');
		$('div#library_tab ul.add_media li a').removeClass('active');
		$(this).addClass('active');
		return false;
	}).filter(':first').click();
	
	//$('div#library_tab > div > input.input_media').live('each',function(){
		//if ($(this).val() > 0) {
		//var inputs = $(this);
		//$(this).change(function() {
			//alert(inputs.val());
			//$('.hidden_input input').val(inputs.val());
		//});
		//}
	//});
	//
	//alert($('div#library_tab input'));
	
	//$('.add_media_library').click(function() {
		//alert('asdf');
		//return false;
	//});
	
	$(".img-thumbnail").live({
        mouseenter: function(e) { e.preventDefault(); $(this).find('.label-function').fadeIn(); },
        mouseleave: function(e) { e.preventDefault(); $(this).find('.label-function').fadeOut(); }
       }
    );
   
	$('#fileupload').fileupload({
		url: $(this).attr('data-url'),
		dataType: 'json',
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
		sequentialUploads: true,
        done: function (e, data) {
			e.preventDefault();
			$.each(data.result.files, function (index, file) {	
				//alert(file.error);
				$('.clear .topBotDiv10').html('<h2>Success</h2>').show();
				$('<div class="pull-left img-thumbnail"/>')				
				.html('<a class="colorbox" rel="groupbox" href="'+base_URL + file.url+'">'
					 +'<img src="'+base_URL + file.thumbnailUrl+'"//></a>'
					 +'<div class="label-function hidden">'
					 +'<a href="'+file.deleteUrl+'" title="Delete" class="label label-default delete_function" onclick="javascript:void(0);">DELETE</a>'
					//+'<a href="'+base_ADM+'news/filechange/'+file.file_id+'" title="Change" class="label label-default change_function ajax" onclick="javascript:void(0);">CHANGE</a>'
					 +'</div>')
				.appendTo('.img_holder_xhr');
            });			
			$('.clear .topBotDiv10').html('<h2>Success</h2>').hide();
			$('#progress').hide();			
        },
        progressall: function (e, data) {
			e.preventDefault();			
            var progress = parseInt(data.loaded / data.total * 100, 10);
			$('#progress').show();
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            ).html(progress+'% Uploading, please be patient..');
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
	
	
	
	$('.listing_data tr').hover(
		function() {$(this).css('background','#a1dbff');},
		function() {$(this).css('background','');}
	);
		
	$('.listing_data tr').click( function() {	
		 //$(this).css('background','#a1dbff');
	});
	
	$(".listing_data tr").mouseup(function(){
      $(this).css('background','#d5ffd5');
    }).mousedown(function(){
      $(this).css('background','#a1dbff');
    });
	
	//************************************** Text Editor *******************************************//
	//************************************** Ajax Requests *****************************************//
		$('.general').submit(function() {
		//---- Language content detection with jQuery -- start --
		$('.lang_content').find('.required').each(function (){
			if ( $(this).parents().find('input[type="hidden"]').val() !== '') {
				if($(this).val() === '') {			
					var hid = $(this).parent().find('input[type="hidden"]').val();
					$.ajax({
						type: "GET",
						url: base_ADM + "language/language/" + hid
						}).done(function( msg ) { 
							var data = jQuery.parseJSON(msg);
							//alert(base_URL + base_ADM);
							if (typeof data.name !== 'undefined') {
								jAlert('Data input is incomplete for ' + data.name, 'Language');
							}
							if (typeof data.subject !== 'undefined') {
								jAlert('Data input is incomplete for ' + data.subject, 'Language');
							}
					});							
					return false;
				}
			}
		});
		//---- Language content detection with jQuery -- end --
		
		//---- CKEDITOR initialize -- start --
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
        }
		//---- CKEDITOR initialize -- end --
    });
	$('input[type="radio"].default_listing_one_click').change(function(){
        var val  = $(this).attr('checked') ? 1 : 0;
        var link = $(this).attr('urlto');
		//alert(window.location);
        if (link){
                var pid = $(this).attr('pid');
                var hash = $(this).attr('hash');
                $.ajax({
                    type: 'GET',
                    url:base_ADM+link+'/',
                    data: 'ajax=true&field=default&pid='+pid+'&value='+val,
                    datatype: "JSON",
                    async: false,
                    success: function(msg){
                        if (msg) {
                            alert('Please wait while updating data');    
                        }                        
                    },
                    error: function (request,setting){
                    }
                });
		  window.location = window.location;
        }
    });
	$('input[type="radio"].default_testimonial_one_click').change(function(){
        var val  = $(this).attr('checked') ? 1 : 0;
        var link = $(this).attr('urlto');
		//alert(window.location);
        if (link){
                var pid = $(this).attr('pid');
                var hash = $(this).attr('hash');
                $.ajax({
                    type: 'GET',
                    url:base_ADM+link+'/',
                    data: 'ajax=true&field=default&pid='+pid+'&value='+val,
                    datatype: "JSON",
                    async: false,
                    success: function(msg){
                        if (msg) {
                            alert('Please wait while updating data');    
                        }                        
                    },
                    error: function (request,setting){
                    }
                });
		 window.location = window.location;
          //window.location.reload();
        }
    });
	
	//$('.top_brand').change(function(){
		//alert($(this).val());
	//});
	
	$('.top_brand').on('change', function() {
		var val = this.checked ? this.value : '';
		$.ajax({
			url:$(this).attr('data-url'),
			data:{value:val,id:$(this).attr('data-id')},
			type:'POST',
			datatype: "JSON",
			success:function(result){ 
				console.log(result); 
			}});
	});
	
	// =========== Input Type Lookup Function =============	
	$('.title').blur(function() { 
		var title = $(this).val();
		var link = $(this).attr('rel');
		$.ajax({
			type: 'GET',
			url: base_ADM+link+'/check_title/'+title,
			data: 'ajax=true&field=title&hash='+title,
			datatype: "JSON",
			async: false,
			success: function(msg){
				//alert(msg);
				if (msg == 1) {
					$('.title').next('span.alert').remove();
					$('<span class="red alert">Title Not Available!</span>').insertAfter('.title');
					$('.title').parent().parent().find('input:image, input:submit').attr("disabled", true);
					//return false;
				} 
				if (msg == 0) {
					$('.title').next('span.alert').remove();
					$('.title').parent().parent().find('input:image, input:submit').removeAttr("disabled");
					//return false;
				} 
			},
			error: function (request,setting){
			}
		});
	});		
	$('.odr_up, .odr_down').click(function(){
		rel = $(this).attr('rel');
		url = $(this).attr('href');		
		$.ajax({
			//url: base_URL+'admin-cp/'+link+'/'+pid+'/'+val,
			type: 'GET',
			url:url,
			datatype: "JSON",
			async: false,
			success: function(msg){
				if (msg !== '') {
					//jAlert("Please wait while updating data " + msg);
					url = base_ADM + rel + '?current=' + msg;
					window.location = url;
				}                        
			},
			error: function (request,setting){
				jAlert('Failed to update..');    
			}
		});
		return false;
	});


	// Object File statistical hover
	$('.object_title').hover(function() {
		ttl = $(this).attr('alt');
		obj = $(this).attr('class');
		rel = $(this).attr('rel');
		$(this).stop().show('slow').append('<div class="floating_box"><img src="'+base_URL+'assets/images/system/ajax-loader.gif" /><div>');
		$.ajax({
			type: 'GET',
			url:rel,
			datatype: "JSON",
			async: false,
			cache: true,
			beforeSend: function() {
				// $('.object_title').closest("td a").find('.floating_box').stop().hide('fast'); 
				$('.floating_box').css('margin','-132px -200px 0 0 !important').empty();
			},
			success: function(result){
				if (result !== '') {
					file = jQuery.parseJSON(result); 
					//alert(file.file_name);
					i = 1;
					$.each(file, function(i,file) {
						var div_data =
						"<div>"+file.file_name+ " | Hits : "+file.count+"</div>";
						$(div_data).appendTo(".floating_box");
						//$(div_data).appendTo.closest(".draggable");
					});
				}                        
			},
			error: function (request,setting){
				//alert('Failed to update..');    
			}
		});
		//$(this).append('<div class="floating_box"> File Name : '+file.file_name+'</div>');
	},function(){
		$(this).closest("td").find('.floating_box').stop().hide('fast');
		$(this).find('.floating_box').stop().hide('fast');
	});
	
	$('.ckeditor').ckeditor({ 
		// apply_source_formatting : true, //verify_html : true
	});
	
	$('.ckeditor400').ckeditor({
		width:800
		// apply_source_formatting : true,
		// verify_html : true
	});
	
	$('.ckeditorsmall').ckeditor({
		toolbar : 'Basic', 
		toolbar_Basic : [['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-','Source']]
//		apply_source_formatting : true,
//		verify_html : true
	});
	
	$('.zoom,a.zoom').each(function () {
		$(this).fancyZoom({directory: base_URL + 'assets/images/fancy_zoom/', scaleImg: true});
	});
	
    var currentYear = (parseInt)((new Date).getFullYear());
	
	//Shadowbox.init({handleOversize: "drag", modal: true});
	
	// Function Listings
	/********* Tipsy Hover - start ********/
	$('.view, .edit, .delete, .list').tipsy({
		title: 'title', 
		gravity: 's',
		fade: true,
		offset: 2,
		opacity: 1
		//trigger: 'hover'
	});
	$('.odr_up, .odr_down').tipsy({
		title: 'title', 
		gravity: 'e',
		fade: true,
		offset: 2,
		opacity: 1
		//trigger: 'hover'
	});	
	$('.download').tipsy({
		title: 'title', 
		gravity: 'w',
		fade: true,
		offset: 2,
		opacity: 1
		//trigger: 'hover'
	});	
	/********* Tipsy Hover - end ********/
   
	$('.autovalid').validate(/*{
		invalidHandler: function(form, validator) {
		  //var errors = validator.numberOfInvalids();
		  //if (errors) {
		  //if (validator.numberOfInvalids()) {
			//$(".lang_field_err").show();
		  //} else {
			//$(".lang_field_err").hide();
		  //}
		}
	 }*/);
	
	// --------------------- start --- Used in Module Listing
	$('.mod_func').each(function() {
		if ($(this).find('input[type="checkbox"]:checked').length == 0) {
			$(this).parent('.select_holder').find('.module_menu').prop('checked','');
		} 
	});	

	$('.module_menu').change( function () {		
		var selected = $(this).parent().find('table tr td input[class="check_hidden_mplr"]');
		if ($(this).attr('checked') === 'checked') { selected.prop('checked','checked'); } 
		if ($(this).attr('checked') !== 'checked') { selected.prop('checked',''); }	
	});
	
	$('input[class^="check_hidden_mplr"]').change( function () {
		if ($(this).prop('checked') == true) {
			$(this).closest("table").parent("td").find('input[name^="module_menu[level_id]"]').prop('checked','checked');	
		} else {
			$(this).closest("table").parent("td").find('input[name^="module_menu[level_id]"]').prop('checked','');
		}
	});	
	$('.fadeOut').fadeOut(3000);
	// --------------------- end --- Used in Module Listing
   
    //$('form.auto_valid').validate(); 
	// Validate Your Form;
	//getErrorMessages
	//if ($('.error') == 'object') { alert($('.error')); }
	
    $('input.disactive').focus(function(){$(this).removeClass('disactive');});    
    /* Drop Down Helper */ /* */
	
    $('ul.main_navi li.dd').click(function(e){
        var id = $(this).attr('id');
        var options = {};
        if (id === 'nexthide'){
            $('ul.main_navi li#nexthide ul').hide();
            $(this).removeAttr('id');
        }else{
            $('ul.main_navi li#nexthide ul').hide();
            $('ul.main_navi li#nexthide').removeAttr('id');
            $('ul.main_navi li:hover ul').slideDown('normal');
            $(this).attr('id','nexthide');
        }
    });
	
    $('ul.main_navi li.dl').mouseover(function(){$(this).css('color','#fff') ;});
	
    $('ul.main_navi li.dl').mouseout(function(){$(this).css('color','#000') ;});
	
    $('img.close_flying').click(function(){
        var target = $(this).attr('target');
        $('.'+target).fadeOut(300);
    });
	
	// Emptied history data 
	$('.trash').click(function () {
		var uri		= $(this).attr('href');
		var ttl		= $(this).attr('rel');
		//var ttl		= $(this).attr('title');
		
		//return confirm('Are you sure want to delete this item?');
		
		jConfirm('Are you sure want to '+ttl+'?', 'Confirmation', function(r) {
			if(r) {
				$.ajax({
					type:'POST',
					url: uri,
					datatype: "JSON",
					async: false,
					error: function() {
						jAlert('Error while '+ttl+' data', 'Error');
					},
					success: function(result){
						//alert(result);
						if(result == 1) {
							jAlert('Data Emptied', 'Result');
							//jAlert("Please wait while updating data " + msg);
							url = uri.replace(/empty/gi, "");
							window.location = url;
						} else if(result == 0) {

							jAlert('Error while '+ttl+' data', 'Error');
							
						} else {
							jAlert(result, 'Error');

						}
					}
				});				
			} else {
				//if($(id).hasClass('red_row')) {
					//$(id).removeClass('red_row').fadeTo('fast', 1);
				//}
			}
			//jAlert('Confirmed: ' + r, 'Confirmation Results');
		});
		return false;
	});
	
    $('input[type="checkbox"]#ipt_checkall').click(function(){
        var value = $(this).attr('checked');
        if (value===true){
            $('input[type="checkbox"].ipt_tocheck').each(function(){
               $(this).attr('checked','true').addClass('activecheck'); 
            });
        }else{
            $('input[type="checkbox"].ipt_tocheck').each(function(){
               $(this).removeAttr('checked').removeClass('activecheck');
            });
        }
    });
	
    $('input[type="checkbox"].ipt_tocheck').click(function(){
        var value = $(this).attr('checked');
        if (value===true){
            $(this).attr('checked','true').addClass('activecheck');     
        }else{
            $(this).removeAttr('checked').removeClass('activecheck');
        }
    });
	
    $('select[name="status_listing_one_click"]').change(function(){
        var val  = $(this).val();
        var link = $(this).attr('url');
        var lastpid = $(this).attr('lastpid');
        if (val !== 'select'){
            var starter = 0;
            var lengthtoupdate = parseInt($('input[type="checkbox"].ipt_tocheck.activecheck').length);
            $('input[type="checkbox"].ipt_tocheck.activecheck').each(function(){
                var pid = $(this).attr('pid');
                var hash = $(this).attr('hash');
                $.ajax({
                    type: 'GET',
                    url:base_URL+'admin-cp/'+link+'/'+pid+'/'+val,
                    data: 'ajax=true&field=status&hash='+hash,
                    datatype: "JSON",
                    async: false,
                    success: function(msg){
                        if (starter === 0) {
                            alert('Please wait while updating data');    
                        }                        
                    },
                    error: function (request,setting){
                    }
                });
                starter++; 
            });        
            if(starter===lengthtoupdate){
                //window.location.reload();
				window.location = window.location;
            };                      
        }
    });
	

	
	$('select[class="default_status_one_click"]').change(function(){
		   var pid = $(this).attr('pid');
           var val = $(this).val();
           var hash = $(this).attr('hash');
		   var link = $(this).attr('url');
           $.ajax({
                type: 'GET',
                url:base_ADM+'admin-cp/'+link+'/'+pid+'/'+val,
                data: 'ajax=true&field=status&hash='+hash+'&id='+val,
                datatype: "html",
                success: function(msg){
					window.location = window.location;
                },
                error: function (request,setting){
                    alert(request+ ' ' + setting);
                }
            });
    });
	
	$('select[class="default_status_one_click_activated"]').change(function(){
		   var pid = $(this).attr('pid');
           var val = $(this).val();
           var hash = $(this).attr('hash');
		   var link = $(this).attr('url');
           $.ajax({
                type: 'GET',
                url:base_URL+'admin-cp/'+link+'/'+pid+'/'+val,
                data: 'ajax=true&field=activated&hash='+hash+'&id='+val,
                datatype: "html",
                success: function(msg){
					window.location = window.location;
                },
                error: function (request,setting){
                    alert(request+ ' ' + setting);
                }
            });
    });
	
	$('select[class="default_delete_one_click"]').change(function(){
		   var pid = $(this).attr('pid');
           var val = $(this).val();
           var hash = $(this).attr('hash');
		   var link = $(this).attr('url');
           $.ajax({
                type: 'GET',
                url:base_URL+'admin-cp/'+link+'/'+pid+'/'+val,
                data: 'ajax=true&field=is_deleted&hash='+hash+'&id='+val,
                datatype: "html",
                success: function(msg){
					window.location = window.location;
                },
                error: function (request,setting){
                    alert(request+ ' ' + setting);
                }
            });
    });
	
    $('.title').alphanumeric({allow:'-.,! '});
	
	if(typeof $('#title') === 'object' && $('#title').length !== 0) {
		 if(typeof $('#subject') === 'object' && $('#subject').length !== 0) {
			 $('#name').parent('div').hide();
			 $('#subject').blur(function() {
				 var value = $(this).val();
				 $('#name').val($.replace_permalink(value));
			 });
		 }
		 if(typeof $('#title') === 'object' && $('#title').length !== 0) {
			 $('#name').parent('div').hide();
			 $('#title').blur(function() {
				 var value = $(this).val();
				 $('#name').val($.replace_permalink(value));
			 });
		 }
		 $('#title').blur(function() {
			 var value = $('#title').val();
			 $('#title').val($.replace_permalink(value));
		 });
	 }	
	
	if(typeof $('#title_edit') === 'object' && $('#title_edit').length !== 0) {
		 $('#title_edit').blur(function() {
			 var value = $(this).val();
			 $('#title_edit').val($.replace_permalink(value));
		 });
	 }	
	 
	 if(typeof $('#title_url') === 'object' && $('#title_url').length !== 0) {
		 $('#title_url').blur(function() {
			 var value = $(this).val();
			 $('#title_url').val($.replace_permalink_url(value));
		 });
	 }
			 
    $('textarea[name="description_model"]').counter({
            type: 'char',
            goal: 250,
            count: 'down'   
        }); 
	// if(typeof $('#title') == 'object' && $('#title').length != 0) {
		// if(typeof $('#subject') == 'object' && $('#subject').length != 0) {
			// //$('#name').parent('div').hide();
			// $('#subject').blur(function() {
				// var value = $(this).val();
				// //$('#name').val(replace_permalink(value));
			// });
		// }
		// if(typeof $('#title') == 'object' && $('#title').length != 0) {
			// //$('#name').parent('div').hide();
			// $('#title').blur(function() {
				// var value = $(this).val();
				// //$('#name').val(replace_permalink(value));
			// });
		// }			
		// $('#title').blur(function() {
			// var value = $('#title').val();
			// $('#title').val(replace_permalink_dash(value));
		// });
	// }	
	// --------------------- imported from kohana 2
	$('.simpledate').datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: '1900:+0'});
	
	$('#validAfterDatepicker,#validBeforeDatepicker').datepicker({
		duration: '',
		showTime: false,
		constrainInput: true,
		stepMinutes: 1,
		stepHours: 1,
		dateFormat: 'yy-mm-dd',
		altTimeField: '',
		time24h: false
	});

	$('#validateFormDate').validate({ 
		errorPlacement: $.datepicker.errorPlacement, 
		rules: { 
				start_date: { 
					required: true,
					dpCompareDate: ['before', '#validAfterDatepicker'] 
				}, 
				end_date: { 
					required: true,
					dpCompareDate: {after: '#validBeforeDatepicker'} 
				}
			}, 
			messages: { 
				validFormatDatepicker: 'Please enter a valid date (yyyy-mm-dd)', 
				validRangeDatepicker: 'Please enter a valid date range', 
				validAfterDatepicker: 'Please enter a date after the previous value' 
			}
		}	
	);

	$('.parent_menu a.parent').each(function() {
		$(this).click(function() {
			if(!$(this).hasClass('active')) {
				$(this).addClass('active');
				$(this).parent().children('ul').slideDown('normal');
			} else {
				$(this).removeClass('active');
				$(this).parent().children('ul').slideUp('normal');
			}
			return false;
		});
		if($(this).hasClass('active')) {
			$(this).parent().children('ul').css('display', 'block');
		}
	});
   
	/** EOF **/
	if(typeof $('#name') === 'object' && $('#name').length != 0) {
		if(typeof $('#subject') === 'object' && $('#subject').length !== 0) {
			//$('#name').parent('div').hide();
			$('#subject').blur(function() {
				var value = $(this).val();
				$('#name').val($.replace_permalink(value));
			});
		}
		if(typeof $('#title') === 'object' && $('#title').length !== 0) {
			//$('#name').parent('div').hide();
			$('#title').blur(function() {
				var value = $(this).val();
				$('#name').val($.replace_permalink(value));
			});
		}
	}
	
	//================== Checking names lookup in server 
   
		//====== Maintenance mode in setting listing
	$('form#maintenance_form').submit(function(){
		//$(":checked").val()
		var val  = $(this).find('input:checked').val();
        var link = $(this).attr('action');
		//alert(window.location);
		//alert(val);
        if (link){
                var pid = $(this).attr('pid');
                var hash = $(this).attr('hash');
                $.ajax({
                    type: 'POST',
                    url: link,
					data: 'ajax=true&field=default&mode='+val,
                    datatype: "JSON",
                    async: false,
                    success: function(msg){
                        if (msg == 1) {
                            alert('Please wait while updating data');    
                        }                        
                    },
                    error: function (request,setting){
                    }
                });
		  window.location = window.location;
          //window.location.reload();
        }	
		return false;
	});
	

	
	$('.maintenance_mode').change(function(){
		if ($(this).val() === 1) 
			jAlert("The site will be temporary off in maintenance mode. Click Save to continue ", "Alert!");
	});
	
	$('#check_all').click(function () {
		var $checkboxes = $(this).parents('table').find('tbody').find(':checkbox');
		$checkboxes.attr('checked', this.checked);
	});
	
	$('#select_action').change(
		function () {
			$(this).parents('form').submit();
		}
	);
		
	$('.open_table').toggle(
		function () {
			//alert('foobar');
			$(this).closest('fieldset').find('table').fadeIn('fast');
		},
		function () {
			$(this).closest('fieldset').find('table').fadeOut('fast');
		}
	);
	
	
	if (typeof $('.form_details') == 'object' && $('.form_details').length != 0) {
		if (typeof $('.required') == 'object') {
			$('.required').each(function() {
				$(this).prev('label').append(' <span style="color:#f00">*</span>');
			});
		}
		var validate = $('.form_details').validate({
			rules: {
				confirm_password: {
					equalTo: "#password"
				}
			},
			messages: {
				confirm_password: {
					equalTo: "Please enter the same password as above"
				}
			}
		});
		if( typeof(accepted_type) != 'undefined' ) {
			accepted_type = accepted_type.replace(/,/gi, "|");
			$('#' + file_fields).rules("add", {
				accept: accepted_type,
				messages: {
					accept: jQuery.format("Please enter a value with {0} extension. ")
				}
 			});
		}
		if( typeof(audio_accepted_type) != 'undefined' ) {
			audio_accepted_type = audio_accepted_type.replace(/,/gi, "|");
			$('#' + audio_file_fields).rules("add", {
				accept: audio_file_fields,
				messages: {
					accept: jQuery.format("Please enter a value with {0} extension. ")
				}
 			});
		}
	}
	
	$('.delete, .delete_function').live('click',function () {
		var id		= jQuery($(this).parent().parent());
		var ttl		= $(this).attr('title') ? $(this).attr('title') : $(this).text();
		var uri		= $(this).attr('href');
		$(id).addClass('red_row').fadeTo('fast', 0.5);
//		return confirm('Are you sure want to delete this item?');
		jConfirm('Are you sure want to '+ttl+' this item?', 'Confirmation', function(r) {
			if(r) {
				$.ajax({
					type:'POST',
					url: uri,
					datatype: "JSON",
					async: false,
					error: function() {
						jAlert('Error while '+ttl+' data', 'Error');
						if($(id).hasClass('red_row')) {
							$(id).removeClass('red_row').fadeTo('fast', 1);
						}
					},
					success: function(result){
						//alert(result);
						if(result == 1) {
							$(id).remove();
							window.location.reload();
						} else if(result == 0) {
							//jAlert('Error while deleting data', 'Error');
							jAlert('Error while '+ttl+' data', 'Error');
							if($(id).hasClass('red_row')) {
								$(id).removeClass('red_row').fadeTo('fast', 1);
							}
						} else {
							jAlert(result, 'Error');
							if($(id).hasClass('red_row')) {
								$(id).removeClass('red_row').fadeTo('fast', 1);
							}
							//return false;
						}
					}
				});				
			} else {
				if($(id).hasClass('red_row')) {
					$(id).removeClass('red_row').fadeTo('fast', 1);
				}
			}
			//jAlert('Confirmed: ' + r, 'Confirmation Results');
		});
		return false;
	});
	
	$('.change_function').live('click',function (e) {
		// prevent default behaviour
		e.preventDefault();
		
		$.colorbox({
				//iframe:true,
				//ajax:false,
				href:$(this).attr('href'),
				width:"75%",height:"75%"
            });
		return false;			
	});
	
	$('#cboxLoadedContent a[class="change_function"]').on('click', function(e){
		// prevent default behaviour
		e.preventDefault();

		var url = $(this).attr('href'); 

		$.ajax({
			type: 'GET',
			url: url,
			dataType: 'html',
			//cache: false,
			//async: false,
			beforeSend: function() {
				$('#cboxLoadedContent').empty();
				$('#cboxLoadingGraphic').show();
			},
			complete: function() {
				$('#cboxLoadingGraphic').hide();
			},
			success: function(data) {                  
				$('#cboxLoadedContent').append(data);
			}
		});

	});
	
	$('#filechange').live('submit',function(e){
		// Prevent form from submitting normally
		e.preventDefault();
		
		// Set preloader image
		$('#loader').html('<img width="28" height="28" src="'+base_URL+'assets/images/themes/loader.gif"/>Submitting...');

		// Empty result callback 
		$('#result_callback').removeClass('result_text').stop().html('').fadeIn('fast');
		
		// Set ajax post handler
		$.ajax({
			type: "POST",
			url: $(this).attr('action'),
			data: 			{ 
				name		: $('#name').val(),
				description	: $('#description').val(),			
				status		: $('#status').val()
			},
			//cache: true,
			//async: true,
			timeout: 8000,
			dataType: "HTML",
			success: function(message) {
				// Parse JSON result
				var data   = jQuery.parseJSON(message);
				//alert(message);
				if (data.errors !== '') {
					$('.div_row').empty();
					$.each(data.errors, function (index, error) {	
						if (data.errors[index] !=='') {							
							$('<span class="error"/><br/><br/>')				
							.html(error)
							.appendTo('.div_row');
						} else if (data.result !=='') {
							self.setInterval(parent.location.reload(),1000);
							parent.$.fn.colorbox.close();
						};
					});
					
					
				}
				
				// Empty loader
				$('#result_callback').empty();
				 
				// Empty loader image
				$('#loader').html('');
				
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
		
		// Return false 
		return false;
	});
	
	if (typeof $('.datepicker') == 'object' && $('.datepicker').attr('class') != null && $('.datepicker').length != 0) {
//		$('.datepicker').attr('readonly', true);
		$('.datepicker').datepicker({
			refresh: true,
			showTime: false,
			constrainInput: true,
			dateFormat: 'yy-mm-dd'
		 });
		 //$('.datepicker').datepicker();
	}
	
	if (typeof $('.timepicker') === 'object' && $('.timepicker').attr('class') !== null && $('.timepicker').length !== 0) {
		$('.timepicker').attr('readonly', true);
		$('.timepicker').datepicker({
			duration: '',
			showTime: true,
			constrainInput: false,
			stepMinutes: 1,
			stepHours: 1,
			dateFormat: 'yy-mm-dd',
			altTimeField: '',
			time24h: true
		 });
	}
	
	$('a.zoom').each(function () {
		$(this).fancyZoom({
			directory: base_URL + 'images/fancy_zoom/',
			scaleImg: true
		});
	});
	
	$('a.expand_fields_link').toggle(function () {
		var warper	= $(this).parent().parent().parent().find('.expand_fields');
		warper.slideDown('slow');
		$(this).html('Less');
	}, function () {
		var warper	= $(this).parent().parent().parent().find('.expand_fields');
		warper.slideUp('slow');
		$(this).html('More');
	});
	
	// print
	$('#print').click(function(e) {e.preventDefault();$("div#printArea").printArea();});
	
	if (typeof $('#order') === 'object' && $('#order').attr('id') !== null) {
		var temp = $('#order').val();			
		$('#order').on('change',function() {
			var order = new RegExp('^[1-9]');			
			if(!order.test($(this).val())) {
				$(this).val(temp);
			}	
		});		
	}
		
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
					////var data   = jQuery.parseJSON(message);
					//alert(message.products);
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
								.html('Add Product First')
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
		
	$('#category_id').change(
		function () {
			$.ajax({
				url:$(this).attr('data-url'),
				type:'POST',
				data:{pid:$('#id').val(),cid:$(this).val(),order:$('#order').val(),current_cid:$('#current_cid').val()},
				success:function(result){
					$('#order').val(result).removeClass('error').next('label.error').hide();
				}
			});
		}
	);
		
	// --------------------- end imported from kohana 2
}) ;

$.extend({
	// Replace unwanted character 1	
	replace_permalink: function(value) {
		var re 	= /[^a-z0-9]+/gi;
		var re2 = /^-*|-*$/g;
		value	= value.replace(re2, '').toLowerCase();
		value 	= value.replace(re, '-');
		return value;
	},
	// Replace unwanted character 2
	replace_permalink_dash: function (value) {
		var re 	= /[^a-z0-9]+/gi;
		var re2 = /^-*|-*$/g;
		value	= value.replace(re2, '').toLowerCase();
		value 	= value.replace(re, '_');
		return value;
	},
	// Replace unwanted character 2
	replace_permalink_url: function (value) {
		var re 	= /[^a-z0-9\:\/\.]+/gi;
		var re2 = /^-*|-*$/g;
		value	= value.replace(re2, '').toLowerCase();
		value 	= value.replace(re, '-');
		return value;
	},
	// Getting with javascript url
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
	// Getting with javascript url
	getUrlVar: function(name){
		return $.getUrlVars()[name];
	}
});