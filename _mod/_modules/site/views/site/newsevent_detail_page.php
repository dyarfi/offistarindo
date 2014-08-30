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
				<li><a href="<?php echo URL::site('company/newsevent');?>" class="active"><?php echo __('events&csr');?></a>
              <ul>
                <li><a href="<?php echo URL::site('company/newsevent/current');?>" class="active"><?php echo __('event');?></a></li>
                <li><a href="<?php echo URL::site('company/newsevent/upcoming');?>"><?php echo __('upcoming_event');?></a></li>
              </ul>
            </li>
            <li><a href="<?php echo URL::site('company/principal');?>"><?php echo __('principal');?></a></li>
            <li><a href="<?php echo URL::site('company/testimonial');?>"><?php echo __('testimonials');?></a></li>
          </ul>
        </div>
    		<div id="main-content" class="text-left pull-right">
          <h3>EVENT</h3>
		  <?php if (!empty($filesFile)) { ?>
          <div id="gallery" class="ad-gallery ">
			<div class="ad-image-wrapper"></div>
			<div class="ad-controls"></div>
			<div class="ad-nav">
			  <div class="ad-thumbs">
				<ul class="ad-thumb-list">
					<?php
					$file = Model_NewsFile::instance()->load_by_group($newsevent->id);					
					if (!empty($file)) { ?>
						<li>
							<a title="<?php echo $newsevent->subject;?>" href="<?php echo URL::site(Lib::config('news.upload_url').str_replace('.', '_crop_632x384.', @Model_NewsFile::instance()->load_by_group($newsevent->id)->file_name));?>">
							<img src="<?php echo URL::site(Lib::config('news.upload_url').str_replace('.', '_crop_80x80.', 
								@Model_NewsFile::instance()->load_by_group($newsevent->id)->file_name));?>" alt="<?php echo $about_page->subject;?>" />
							</a>
						</li>
					<?php } ?>
					<?php $i= 0 ;foreach ($filesFile as $files) { ?>
					<li>
						<a href="<?php echo URL::site($upload_url . str_replace('.', '_crop_632x384.', $files->file_name));?>" title="<?php echo $files->name;?>">
						  <img src="<?php echo URL::site($upload_url . str_replace('.', '_crop_80x80.', $files->file_name));?>" class="image0" alt="<?php echo $files->name;?>">
						</a>
					</li>
					<?php $i++; } ?>
				</ul>
			  </div>
			</div>
		  </div>
		  <?php } ?>
          <div class="content-page"><?php echo $newsevent->text;?></div>
        </div>
        <div class="clear"></div>
    </div>
  </div>
</div>	