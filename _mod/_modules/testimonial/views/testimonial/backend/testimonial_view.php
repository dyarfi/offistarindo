<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
$(document).ready(function () {
	$('#language_select').change(function() {
	<?php
	$prefix = array();
	foreach($language_data as $row):
		//$file_data	= pathinfo($language_file[$row['lang_id']]->file_name);
		//$thumb		=(Kohana::config('language.image'));
		//$img		= url::base().Kohana::config('language.upload_url').$file_data['filename']."_resize_".$thumb['thumbnails'][1].".".$file_data['extension'];
		$img		= IMG.'languages/'.$row->file_name;
		$prefix[$row->id] = $row->prefix;
		?>
		if($(this).val() == <?php echo $row->id; ?> && $(this).val() != 0) {
			$("<?php echo '#lang_' . $row->prefix; ?>").fadeIn();
			$(".flag_holder").html('<img src="<?php echo $img;?>" alt="<?php echo $row->name; ?>"/>');	
		} else {
			$("<?php echo '#lang_' . $row->prefix; ?>").fadeOut();
		}
		<?php
	endforeach;
	?>
		//alert($(this).find('option').text());		
		//if ($(this).text() == $(".flag_holder").find('img').attr('alt')) {
			//alert($(".flag_holder").find('img').attr('alt'));
		//}
	}).eq(0).change();
});
</script>
<h2><?php echo $module_menu; ?></h2>

<form class="form_details" action="<?php echo url::site(ADMIN.$class_name.'/edit/'.$testimonial->id); ?>" method="get">
		<div class="form_wrapper">
		
		<fieldset class="wrapper_fs"><legend>Title Banner</legend>
			<div class="form_row">
				<label><?php echo i18n::get('title');?></label>
				<div class="form_fields"><?php echo ($testimonial->title) ? $testimonial->title : '-'; ?></div>
			</div>
			<div class="form_row">
				<label><?php echo i18n::get('status');?></label>
				<div class="form_fields"><?php echo ucfirst($testimonial->status);?></div>
			</div>	
			<div class="form_row">
				<label>Show Image Cover in Home</label>
				<div class="form_field"><?php echo ($testimonial->show_cover) ? 'Show' : 'No'; ?></div>
			</div>			
		</fieldset>
			
		<fieldset class="wrapper_fs"><legend>Detail Language</legend>
			<div class="ls10"></div>
			<div class="va-mid-inline">
			<label>Change Language &nbsp;&nbsp;</label>
			<select name="language_select" id="language_select" class="">
				<?php 
				foreach($language_data as $language):
					$img		= IMG.'languages/'.$language->file_name;
				?>
				<option value="<?php echo $language->id;?>" <?php echo ($language->id == 1) ? 'selected="selected"' : ''; ?>>
					<?php echo $language->name; ?>
				</option>
				<?php 
				endforeach; 
				?>
			</select>
			<div class="flag_holder"></div>
			</div>
			<div class="ls10"></div>
			<?php 
				$i=0;
				foreach($language_data as $language):						
					$img		= IMG.'languages/'.$language->file_name;
					if (!empty($detail_data[$language->id]->lang_id) && $detail_data[$language->id]->lang_id == $language->id):
					?>	
					<div id="lang_<?php echo $prefix[$language->id]; ?>">
						<div class="form_row">
							<div class="cd_left gray">Subject</div>
							<div class="cd_center">:</div>
							<div class="cd_right"><?php echo $detail_data[$language->id]->subject; ?></div>
							<div class="clear ls4"></div> 							
						</div>	
						<div class="clear ls4"></div> 
						<?php //echo sprintf($errors['description'], 'Text'); ?>
						<div class="form_row">
							<div class="cd_left gray">Text</div>
							<div class="cd_center">:</div>
							<div class="clear ls4"></div> 
							<div class="form_field"><?php echo $detail_data[$language->id]->text; ?></div>
						</div>	
					</div>	
				<?php
					endif;
				?>
			<?php 
				$i++;
			endforeach;
			?>
			<div class="ls10"></div>
		</fieldset>	

			<?php if (isset($show_upload) && $show_upload) : ?>
			<?php foreach ($uploads as $row_name => $row_params) : ?>
				<fieldset style="clear:both;">
					<legend><strong><?php echo $row_params['label']; ?></strong></legend>
					<?php if (isset($files[$row_name])) : ?>
					<div class="form_row">
						<label><?php echo $row_params['label']; ?></label>
						<div class="form_fields">
							<?php if (is_file($upload_path.$files[$row_name]->file_name) && in_array($files[$row_name]->file_type, $readable_mime)) : ?>
							<div id="file_<?php echo $files[$row_name]->id; ?>">
								<?php if (substr($files[$row_name]->file_type, 0, strlen('image/')) == 'image/') : ?>
								<?php
									$file_data	= pathinfo(URL::site().$upload_url.$files[$row_name]->file_name);
									$thumb_ext	= isset($row_params['image_manipulation']['thumbnails'][0]) ? '_resize_'.$row_params['image_manipulation']['thumbnails'][0] : '';
								?>
								<img src="<?php echo URL::site().$upload_url.$file_data['filename'].$thumb_ext.'.'.$file_data['extension']; ?>" alt="<?php echo URL::site().$upload_url.$files[$row_name]->file_name; ?>" />
								<?php elseif (substr($files[$row_name]->file_type, 0, strlen('application/')) == 'application/') : ?>
									<object type="application/x-shockwave-flash" data="<?php echo URL::site().$upload_url.$files[$row_name]->file_name; ?>" width="564" height="300">
										<param name="allowScriptAccess" value="sameDomain" />
										<param name="allowFullScreen" value="false" />
										<param name="wmode" value="transparent" />
										<param name="quality" value="high" />
										<param name="bgcolor" value="#ffffff" />
										<param name="movie" value="<?php echo URL::site().$upload_url.$files[$row_name]->file_name; ?>" />
									</object>
								<?php elseif (substr($files[$row_name]->file_type, 0, strlen('audio/')) == 'audio/') : ?>
								<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="20" id="FLVPlayer">
									<param name="movie" value="<?php echo ASSETS; ?>flash/singlemp3player.swf" />
									<param name="quality" value="high" />
									<param name="wmode" value="opaque" />
									<param name="scale" value="noscale" />
									<param name="salign" value="lt" />
									<param name="FlashVars" value="file=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;backColor=c2c2c2&amp;frontColor=666666&amp;showDownload=false&amp;repeatPlay=false&songVolume=100" />
									<param name="swfversion" value="8,0,0,0" />
									<!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don�t want users to see the prompt. -->
									<param name="expressinstall" value="Scripts/expressInstall.swf" />
									<!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
									<!--[if !IE]>-->
									<object type="application/x-shockwave-flash" data="<?php echo ASSETS; ?>flash/singlemp3player.swf" width="320" height="20">
									<!--<![endif]-->
										<param name="quality" value="high" />
										<param name="wmode" value="opaque" />
										<param name="scale" value="noscale" />
										<param name="salign" value="lt" />
										<param name="FlashVars" value="file=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;backColor=c2c2c2&amp;frontColor=666666&amp;showDownload=false&amp;repeatPlay=false&songVolume=100" />
										<param name="swfversion" value="8,0,0,0" />
										<param name="expressinstall" value="Scripts/expressInstall.swf" />
										<!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
										<div>
										<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
										<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
										</div>
									<!--[if !IE]>-->
									</object>
									<!--<![endif]-->
								</object>
								<?php else : ?>
								<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="240" id="FLVPlayer">
									<param name="movie" value="<?php echo ASSETS; ?>flash/FLVPlayer_Progressive.swf" />
									<param name="quality" value="high" />
									<param name="wmode" value="opaque" />
									<param name="scale" value="noscale" />
									<param name="salign" value="lt" />
									<param name="FlashVars" value="skinName=<?php echo ASSETS; ?>flash/Corona_Skin_2&amp;streamName=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;autoPlay=false&amp;autoRewind=false" />
									<param name="swfversion" value="8,0,0,0" />
									<!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don�t want users to see the prompt. -->
									<param name="expressinstall" value="Scripts/expressInstall.swf" />
									<!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
									<!--[if !IE]>-->
									<object type="application/x-shockwave-flash" data="<?php echo ASSETS; ?>flash/FLVPlayer_Progressive.swf" width="320" height="240">
									<!--<![endif]-->
										<param name="quality" value="high" />
										<param name="wmode" value="opaque" />
										<param name="scale" value="noscale" />
										<param name="salign" value="lt" />
										<param name="FlashVars" value="skinName=<?php echo ASSETS; ?>flash/Corona_Skin_2&amp;streamName=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;autoPlay=false&amp;autoRewind=false" />
										<param name="swfversion" value="8,0,0,0" />
										<param name="expressinstall" value="Scripts/expressInstall.swf" />
										<!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
										<div>
										<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
										<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
										</div>
									<!--[if !IE]>-->
									</object>
									<!--<![endif]-->
								</object>
								<?php endif; ?>
							</div>
							<?php else: ?>
							Cannot preview this file
							<?php endif; ?>
						</div>
					</div>
					<div class="form_row">
						<label class="no_border">&nbsp;</label>
						<div class="form_field"><a href="<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>"><img src="<?php echo IMG ?>admin/disk.png" alt="<?php echo $files[$row_name]->file_name; ?>" /></a></div>
					</div>
					<?php if (isset($row_params['caption']) && $row_params['caption']) : ?>
					<div class="form_row">
						<label>Caption</label>
						<div class="form_field"><?php echo HTML::chars($files[$row_name]->caption, TRUE); ?></div>
					</div>
					<?php endif; ?>
					
					<?php if (isset($row_params['description']) && $row_params['description']) : ?>
					<div class="form_row">
						<label>Description</label>
						<div class="form_field"><?php echo HTML::chars($files[$row_name]->description, TRUE); ?></div>
					</div>
					<?php endif; ?>
					
					<?php endif; ?>
			</fieldset>
			<?php endforeach; ?>
			<?php endif; ?>
			<?php if (isset($show_order) && $show_order) : ?>
			<div class="form_row">
				<label>Order</label>
				<div class="form_field"><?php echo $order; ?></div>
			</div>
			<?php endif; ?>
			

			<?php if (isset($show_media) && $show_media) : ?>
			<div class="form_row topBotDiv10">
				<label>Media</label>
				<div class="form_field gray">
				<?php 					
				if (strpos($testimonial->media,'/videos/') === 0) {
					?>
					<script type="text/javascript">
					//<![CDATA[
					$(document).ready(function(){
						$("#jquery_jplayer_1").jPlayer({
							ready: function () {
								$(this).jPlayer("setMedia", {
									title: "<?php echo $testimonial->media;?>",
									<?php echo (substr(strrchr($testimonial->media,'.'),1) == 'mp4')
												? 'm4v'
													: substr(strrchr($testimonial->media,'.'),1);?>: "<?php echo URL::site('uploads/download_files'.$testimonial->media);?>"
								});
							},
							swfPath: base_URL+"assets/js/library/jPlayer/",
							supplied: "<?php echo (substr(strrchr($testimonial->media,'.'),1) == 'mp4')
												? 'm4v'
													: substr(strrchr($testimonial->media,'.'),1);?>",
							errorAlerts: true,
							size: {
								width: "640px",
								height: "360px",
								cssClass: "jp-video-360p"
							},
							smoothPlayBar: true,
							keyEnabled: true,
							remainingDuration: true,
							toggleDuration: true
						});
						//$("#jplayer_inspector").jPlayerInspector({jPlayer:$("#jquery_jplayer_1")});
					});
					//]]>
					</script>
					<div id="jp_container_1" class="jp-video jp-video-360p">
						<div class="jp-type-single">
							<div id="jquery_jplayer_1" class="jp-jplayer"></div>
							<div class="jp-gui">
								<div class="jp-video-play">
									<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
								</div>
								<div class="jp-interface">
									<div class="jp-progress">
										<div class="jp-seek-bar">
											<div class="jp-play-bar"></div>
										</div>
									</div>
									<div class="jp-current-time"></div>
									<div class="jp-duration"></div>
									<div class="jp-details">
										<ul>
											<li><span class="jp-title"></span></li>
										</ul>
									</div>
									<div class="jp-controls-holder">
										<ul class="jp-controls">
											<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
											<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
											<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
											<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
											<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
											<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
										</ul>
										<div class="jp-volume-bar">
											<div class="jp-volume-bar-value"></div>
										</div>

										<ul class="jp-toggles">
											<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
											<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
											<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
											<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="jp-no-solution">
								<span>Update Required</span>
								To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
							</div>
						</div>
					</div>
					<div id="jplayer_inspector"></div>
					<?php
					//echo 'asdasd----------';
					//echo $testimonial->media;
					//exit;
				} else
				// Match if only URL search
				if(preg_match('/iframe/',$testimonial->media) == '') {
				
					$search = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i';
					
					$replace = '<iframe width="560" height="315" src="http://www.youtube.com/embed/\\1" frameborder="0" allowfullscreen></iframe>';
					$videoid = preg_replace($search, $replace, $testimonial->media );
					if (!empty($videoid)) { 
						echo $videoid;
					}
				} else {
					echo $testimonial->media;
				}
				?>
				</div>
			</div>
			<?php endif; ?>
					
			<div class="form_row">
				<label>Status</label>
				<div class="form_field"><?php echo ucfirst($testimonial->status); ?></div>
			</div>
			<div class="form_row">
				<label>Created</label>
				<div class="form_field"><?php echo ($testimonial->added != 0) ? date(Lib::config('site.date_format'), $testimonial->added) : '-'; ?></div>
			</div>
			<div class="form_row">
				<label>Last Modified</label>
				<div class="form_field"><?php echo ($testimonial->modified != 0) ? date(Lib::config('site.date_format'), $testimonial->modified) : '-'; ?></div>
			</div>
		</div>
		<div class="form_row">
			<?php echo Form::submit(NULL, '', array('class' => 'btn_edit btn-primary span2')); ?>
		</div>
<?php echo Form::close();?>