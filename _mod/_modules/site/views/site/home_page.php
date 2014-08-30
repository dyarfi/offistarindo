<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="middle">
  <div class="outerwrapper row">
  <?php if (!empty($banners)) { ?>	
	<div id="banner">		  
	  <div id="carousel_home" class="carousel carousel-fade slide">
		  <?php if (count($banners) > 1) {?>
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
			<?php
			$n = 0;
			foreach ($banners as $indicator) {
				$active = ($n == 0) ? 'active' : ''; ?>
				<li data-target="#carousel_home" data-slide-to="<?php echo $n;?>" class="<?php echo $active;?>"></li>				
			<?php 
			$n++;
			} ?>
		  </ol>
		  <?php } ?>
		  <div class="carousel-inner">
			<?php
				$o = 0;
				foreach ($banners as $banner) {
				$active = ($o == 0) ? 'active' : '';
			?>
			<div class="item <?php echo $active;?>">
				<img class="img-responsive" src="<?php echo URL::site($upload_url.str_replace('.', '_crop_1024x406.', $banner->file_name));?>" alt="<?php echo @$banner_content[$banner->id]->subject;?>"/>
				<?php if (!empty($banner_content[$banner->id]->text)) { ?>
				<div class="carousel-caption">
					<h4><?php echo Text::limit_words($banner_content[$banner->id]->text,16);?></h4>
				</div>
				<?php } ?>
			</div>
			<?php 
				$o++;
			} ?>			  
		  </div>
		  <?php if (count($banners) > 1) {?>
		  <a class="left carousel-control" href="#carousel_home" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		  <a class="right carousel-control" href="#carousel_home" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
		  <?php } ?>
	  </div>
	</div>
  <?php } ?>	
	<div class="wrapper">
	  <div id="widget">
		<div class="column fx_fbot">
		  <h3><?php echo __('company_overview');?></h3>
		  <div class="text-justify">
		  <?php 
		  $limit = 360;
		  if (!empty($about->show_cover) && is_file($page_upload_path . @Model_PageFile::instance()->load_by_group($about->id)->file_name)) { ?>
		  <img src="<?php echo URL::site($page_upload_url.str_replace('.', '_crop_300x183.', 
				  @Model_PageFile::instance()->load_by_group($about->id)->file_name));?>" alt="<?php echo $about->subject;?>" />
		  <?php } else { $limit = 770; } ?>
		  <p><?php echo Text::limit_chars(strip_tags($about->text,''), $limit);?></p>
		  </div>
		  <a class="fx_fbota" href="<?php echo URL::site('company/read/about-us');?>" title="<?php echo $about->subject;?>"><?php echo __('learn_more');?></a></div>
		<div class="column fx_fbot">
		<h3><?php echo __('testimonials');?></h3>
		<div class="text-justify">
		<?php 
		$media ='';
		$image = '';
		$limit = 360;
			// Check if media not empty
			if(!empty($testimonial->media) && !is_file($testimonial_upload_path.$testimonial->media)) { ?>
			<?php 					
				if (strpos($testimonial->media,'/videos/') === 0 && !empty($testimonial->show_cover)) {
					$limit = 260;
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
								width: "300px",
								height: "183px",
								cssClass: "jp-video-270p"
							},
							smoothPlayBar: true,
							keyEnabled: true,
							remainingDuration: true,
							toggleDuration: true
						});
					});
					//]]>
					</script>
					<div id="jp_container_1" class="jp-video jp-video-300p">
						<div class="jp-type-single">
							<div id="jquery_jplayer_1" class="jp-jplayer"></div>
							<div class="jp-gui">
								<div class="jp-video-play"><a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a></div>
								<div class="jp-interface">
									<!--div class="jp-progress">
										<div class="jp-seek-bar"><div class="jp-play-bar"></div></div>
									</div>
									<div class="jp-current-time"></div>
									<div class="jp-duration"></div>
									<div class="jp-details"><ul><li><span class="jp-title"></span></li></ul></div-->
									<div class="jp-controls-holder">
										<ul class="jp-controls">
											<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
											<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
											<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
											<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
											<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
											<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
										</ul>
										<div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div>
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
				} else
				// Match if only URL search
				if(preg_match('/iframe/',$testimonial->media) == '' && !empty($testimonial->show_cover)) {

					$search = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i';

					$replace = '<iframe width="300" height="215" src="http://www.youtube.com/embed/\\1" frameborder="0" allowfullscreen></iframe>';
					$videoid = preg_replace($search, $replace, $testimonial->media );
					if (!empty($videoid)) { 
						echo $videoid;
					}
				} 
			} else {
				$_image = @Model::factory('TestimonialFile')->load_by_group($testimonial->id)->file_name;
				$limit = 400;	
				$image = is_file($testimonial_upload_path.$_image) ? '<img src="'.URL::site($testimonial_upload_url.str_replace('.', '_crop_300x183.',$_image)).'" alt="'.@$testimonial->subject.'" />' :'';				
			  }
			// Display Media 
			if (!empty($testimonial->show_cover)) { 
				echo $media;
			} else if (empty($testimonial->show_cover) && empty($testimonial->media) && !empty($image)) {
				echo $image;
			}
	?>
	<p><?php if (!empty($testimonial->text)) { echo Text::limit_chars(strip_tags($testimonial->text),$limit); }?></p>						  
	</div>	
	<a class="fx_fbota" href="<?php echo URL::site('company/testimonial/');?>"><?php echo __('view_more');?></a></div>
		<div class="column fx_fbot">
		  <div id="download">
			<h3><?php echo __('download_source');?></h3>
			<h6><?php echo __('pick_category');?></h6>
			  <form action="<?php echo URL::site('download');?>" name="download-form" id="1">
				<select name="category" id="category_pid" data-url="<?php echo URL::site('api/productlookup');?>">
					<option>--- <?php echo __('category');?> ---</option>	
				<?php foreach ($qry_category as $category) { ?>
					<option value="<?php echo $category->id;?>">
						<?php echo $category->subject;?>
					</option>
				<?php } ?>
				 </select>						
				<select name="product" id="product_id">
					<option>--- <?php echo __('product');?> ---</option>
				</select>					
				<select name="type" id="type_id">
					<option>--- <?php echo __('type');?> ---</option>
					<?php foreach ($qry_downloadtype as $downloadtype) { ?>
						<option value="<?php echo $downloadtype->id;?>">
							<?php echo $downloadtype->subject;?>
						</option>
					<?php } ?>
				</select>
				<button type="submit" class="btn btn-danger btn-block btn-sm"><?php echo __('search');?></button>
			  </form>
			  <div class="center-block center"><?php echo __('or');?></div>
			  <form action="<?php echo URL::site('download/');?>" method="get" name="search-form" id="2">
				<input name="search" type="text" placeholder="<?php echo __('search_keywords');?>"/>
				<button type="submit" class="btn btn-danger btn-block btn-sm"><?php echo __('search');?></button>
			  </form>
		  </div>
		<a class="fx_fbota" href="<?php echo URL::site('download');?>"><?php echo __('download_more');?></a> </div>
	  </div>
	  <div class="clear"></div>
	</div>
  </div>
</div>
