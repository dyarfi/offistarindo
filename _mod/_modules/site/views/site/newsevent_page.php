<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="middle">
    <div class="outerwrapper">
      <div class="wrapper clearfix">
        <div id="side-menu" class="clearfix">
          <?php if (!empty($page_category)) { ?><h3><?php echo $page_category[0]->subject;?></h3><?php } ?>
          <ul>
            <?php 
				foreach ($about_pages as $pages) { 
				$active = (Request::$current->param('id1') == $pages->title) ? 'active' : ''; ?>
				<li><a href="<?php echo URL::site('company/read/'.$pages->title); ?>" class="<?php echo $active; ?>"><?php echo $pages->subject; ?></a></li>
			<?php } ?>			
				<li><a href="<?php echo URL::site('company/newsevent');?>" class="active"><?php echo __('events&csr');?></a>
              <ul>
				  <li><a href="<?php echo URL::site('company/newsevent/current');?>" class="<?php echo (Request::$current->param('id1') == 'current') ? 'active' : '';?>"><?php echo __('event');?></a></li>
                <li><a href="<?php echo URL::site('company/newsevent/upcoming');?>" class="<?php echo (Request::$current->param('id1') == 'upcoming') ? 'active' : '';?>"><?php echo __('upcoming_event');?></a></li>
              </ul>
            </li>
            <li><a href="<?php echo URL::site('company/principal');?>"><?php echo __('principal');?></a></li>
            <li><a href="<?php echo URL::site('company/testimonial');?>"><?php echo __('testimonials');?></a></li>
          </ul>
        </div>
		<div id="main-content" class="right">
			<div class="text-left">
			<h3>EVENT</h3>
			<ul id="list-event">
			<?php if (!empty($newsevent)) {
				foreach ($newsevent as $news) { ?>
				<li><?php 
						if (!empty($news->file_name)) {
						if (is_file($upload_path . $news->file_name) == 1)
						$filename = URL::site($upload_url . str_replace('.', '_crop_248x158.', $news->file_name));
						{ ?>
							<img class="img-responsive" src="<?php echo $filename;?>" width="248" height="158" alt="" />
						<?php } 
						}?>
						<div>
							<span><?php echo date('d F Y',  strtotime($news->news_date));?></span>
							<h6><?php echo $news->subject;?></h6>
							<div class="news_desc">
							<?php echo Text::limit_words(Lib::_trim_strip($news->text),12,'');?>
							</div>	
							<a href="<?php echo URL::site('company/newsevent/read/'.$news->title);?>">
							<div class="glyphicon glyphicon-hand-right"></div> <?php echo __('view_more');?></a>
						</div>
					</li>
				<?php } 
			} else { 					
			?>
			<li>
				<?php echo __('no_upcoming_event'); ?>
			</li>
			<?php } ?>		
			</ul>
			<div id="paging"><?php echo $pagination->render('pagination/site'); ?></div><div class="clear"></div></div>	
      </div>
    </div>
  </div>
</div>	