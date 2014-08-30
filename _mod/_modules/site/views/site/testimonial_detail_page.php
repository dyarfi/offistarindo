<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="middle">
    <div class="outerwrapper">
      <div class="wrapper clearfix">
        <div id="side-menu" class="clearfix">
          <?php if (!empty($page_category)) { ?><h3><?php echo $page_category[0]->subject;?></h3><?php } ?>
          <ul>
            <?php 
				foreach ($about_pages as $pages) { 
				$active = (Request::$current->param('id1') == $pages->title) ? 'active' : '';
				?>
				<li><a href="<?php echo URL::site('company/read/'.$pages->title); ?>" class="<?php echo $active; ?>"><?php echo $pages->subject; ?></a></li>
			<?php } ?>			
				<li><a href="<?php echo URL::site('company/newsevent');?>"><?php echo __('events&csr');?></a>
              <ul>
                <li><a href="<?php echo URL::site('company/newsevent/current');?>"><?php echo __('event');?></a></li>
                <li><a href="<?php echo URL::site('company/newsevent/upcoming');?>"><?php echo __('upcoming_event');?></a></li>
              </ul>
            </li>
            <li><a href="<?php echo URL::site('company/principal');?>"><?php echo __('principal');?></a></li>
            <li><a href="<?php echo URL::site('company/testimonial');?>" class="active"><?php echo __('testimonials');?></a></li>
          </ul>
        </div>
    		<div id="main-content" class="text-left pull-right">
          <?php /*if (!empty($page_category)) { ?><h3><?php echo $page_category[0]->subject;?></h3><?php } */ ?>
			<h3><?php echo __('testimonials');?></h3>
		  <?php if (Model_TestimonialFile::instance()->load_by_group($testimonial[0]->id) != '') { ?>
				<div class="text-center center-block">	
				<a class="colorbox cboxElement" title="<?php echo $testimonial[0]->person;?>" href="<?php echo URL::site($upload_url.Model_TestimonialFile::instance()->load_by_group($testimonial[0]->id)->file_name);?>">
				<img src="<?php echo URL::site($upload_url.str_replace('.', '_resize_300x183.', 
					@Model_TestimonialFile::instance()->load_by_group($testimonial[0]->id)->file_name));?>" alt="<?php echo $about_page[0]->subject;?>" />
				</a>
				</div>
		  <?php } ?>		 
		<div class="content-page"><?php echo $testimonial[0]->text;?></div>
		  <?php if ($testimonial[0]->media) { ?>
			<div id="entry-listing">
				<div class="row-fluid format-video"><div id="player" class="player">
				  <?php 					
				  if (strpos($testimonial[0]->media,'/videos/') === 0) {
					  ?>
					  <script type="text/javascript">
					  //<![CDATA[
					  $(document).ready(function(){
						  $("#jquery_jplayer_1").jPlayer({
							  ready: function () {
								  $(this).jPlayer("setMedia", {
									  title: "<?php echo $testimonial[0]->media;?>",
									  <?php echo (substr(strrchr($testimonial[0]->media,'.'),1) == 'mp4')
												  ? 'm4v'
													  : substr(strrchr($testimonial[0]->media,'.'),1);?>: "<?php echo URL::site('uploads/download_files'.$testimonial[0]->media);?>"
								  });
							  },
							  swfPath: base_URL+"assets/js/library/jPlayer/",
							  supplied: "<?php echo (substr(strrchr($testimonial[0]->media,'.'),1) == 'mp4')
												  ? 'm4v'
													  : substr(strrchr($testimonial[0]->media,'.'),1);?>",
							  errorAlerts: true,
							  size: {
								  width: "640px",height: "360px",cssClass: "jp-video-360p"
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
								  <div class="jp-video-play"><a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a></div>
								  <div class="jp-interface">
									  <div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div>
									  <div class="jp-current-time"></div>
									  <div class="jp-duration"></div>
									  <div class="jp-details"><ul><li><span class="jp-title"></span></li></ul></div>
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
				  if(preg_match('/iframe/',$testimonial[0]->media) == '') {

					  $search = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i';

					  $replace = '<iframe width="560" height="315" src="http://www.youtube.com/embed/\\1" frameborder="0" allowfullscreen></iframe>';
					  $videoid = preg_replace($search, $replace, $testimonial[0]->media );
					  if (!empty($videoid)) { 
						  echo $videoid;
					  }
				  } else {
					  echo $testimonial[0]->media;
				  }
				  ?>
				  </div>
				</div>
			  </div>
			  <?php } ?>			
        </div>
        <div class="ls20 clear"></div>
    </div>
  </div>
</div>	