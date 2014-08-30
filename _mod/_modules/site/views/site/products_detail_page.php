<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="middle">
    <div class="outerwrapper">
		<div class="wrapper">
		  <div id="side-menu">
			<?php if (!empty($page_category)) { ?><h3><?php echo $page_category[0]->subject;?></h3><?php } ?>
			<?php echo Lib::traverse('',URL::site('products/browse'),'0',$product_category);?>
		  </div>
		  <div id="main-content" class="right">
			  <div class="text-left">
			  <h3><?php echo $product_detail[0]->subject;?></h3>
			  <div class="desc_product container-fluid">
				 <?php if (!empty($product_files[$product_detail[0]->id])) { ?>
				  <a href="<?php echo URL::site($upload_url.$product_files[$product_detail[0]->id]->file_name);?>" class="colorbox">
					<img class="left img_prod" src="<?php echo URL::site($upload_url.str_replace('.', '_crop_169x151.', 
							$product_files[$product_detail[0]->id]->file_name));?>" alt="<?php echo $product_detail[0]->subject;?>" />
					</a>	
				  <?php } else { ?>
				  <img src="<?php echo IMG;?>themes/content/desc-product.png" width="169" height="151" alt=""  class="left img_prod"/>
				  <?php } ?>
				<div class="desc">					
					<div class="content-page"><?php echo $product_detail[0]->text;?></div>
				</div>
			  </div>
			  <?php if ($product_detail[0]->media) { ?>
				<div id="entry-listing">
					  <div class="row-fluid format-video"><div id="player" class="player">
				  <?php 					
				  if (strpos($product_detail[0]->media,'/videos/') === 0) {
					  ?>
					  <script type="text/javascript">
					  //<![CDATA[
					  $(document).ready(function(){
						  $("#jquery_jplayer_1").jPlayer({
							  ready: function () {
								  $(this).jPlayer("setMedia", {
									  title: "<?php echo $product_detail[0]->media;?>",
									  <?php echo (substr(strrchr($product_detail[0]->media,'.'),1) == 'mp4')
												  ? 'm4v'
													  : substr(strrchr($product_detail[0]->media,'.'),1);?>: "<?php echo URL::site('uploads/download_files'.$product_detail[0]->media);?>"
								  });
							  },
							  swfPath: base_URL+"assets/js/library/jPlayer/",
							  supplied: "<?php echo (substr(strrchr($product_detail[0]->media,'.'),1) == 'mp4')
												  ? 'm4v'
													  : substr(strrchr($product_detail[0]->media,'.'),1);?>",
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
										  <div class="jp-seek-bar"><div class="jp-play-bar"></div></div>
									  </div>
									  <div class="jp-current-time"></div>
									  <div class="jp-duration"></div>
									  <div class="jp-details">
										  <ul><li><span class="jp-title"></span></li></ul>
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
				  if(preg_match('/iframe/',$product_detail[0]->media) == '') {

					  $search = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i';

					  $replace = '<iframe width="560" height="315" src="http://www.youtube.com/embed/\\1" frameborder="0" allowfullscreen></iframe>';
					  $videoid = preg_replace($search, $replace, $product_detail[0]->media );
					  if (!empty($videoid)) { 
						  echo $videoid;
					  }
				  } else {
					  echo $product_detail[0]->media;
				  }
				  ?>
				  </div>
				</div>
			  </div>
			  <?php } ?>
			<?php if (!empty($product_detail[0]->overview) 
					|| !empty($product_detail[0]->features) 
						|| !empty($product_detail[0]->specification)) { ?>
			  <div id="content-tab">
				<div class="nav-tab">
					<?php if ($product_detail[0]->overview) { ?>
						<a href="#tab-01" class="active"><?php echo __('overview');?></a>
					<?php } ?>		
					<?php if ($product_detail[0]->features) { ?>					
						<a href="#tab-02"><?php echo __('features');?></a>
					<?php } ?>							
					<?php if ($product_detail[0]->specification) { ?>					
						<a href="#tab-03"><?php echo __('specification');?></a></a>
					<?php } ?>							
				</div>
				<?php if ($product_detail[0]->overview) { ?>  
				<div class="tabs" id="tab-01">
					<?php echo $product_detail[0]->overview;?>
				</div>
				<?php } ?>	  
				<?php if ($product_detail[0]->features) { ?>    
				<div class="tabs" id="tab-02">
					<?php echo $product_detail[0]->features;?>
				</div>
				<?php } ?>	    
				<?php if ($product_detail[0]->specification) { ?>      
				<div class="tabs" id="tab-03">
					<?php echo $product_detail[0]->specification;?>
				</div>
				<?php } ?>	  
			  </div>
			  <?php } ?>
		  </div>
	  </div>	
		  <div class="clear"></div>
	  </div>
  </div>
</div>