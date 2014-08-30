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
		<div id="main-content" class="right">
			<div class="text-left">
				<h3><?php echo __('testimonials');?></h3>
				<?php if (!empty($testimonial)) { ?>
				<ul id="list-testi">
					<?php foreach ($testimonial as $testimoni) { ?>
					<li>
					<?php 
					if (file_exists($upload_path.$testimoni->file_name) && !empty($testimoni->file_name)) { ?>
						<img width="195" src="<?php echo URL::site($upload_url.str_replace('.', '_resize_195x170.', $testimoni->file_name));?>" alt="<?php echo Lib::_trim_strip(ucfirst($testimoni->person));?>" />
					<?php } ?>
						<p><?php echo Text::limit_words(strip_tags($testimoni->text),30);?></p>
						<div class="info">
						<p class="left">
							<strong><?php echo Text::limit_words(ucfirst($testimoni->person),12);?></strong>
						</p>
							<a href="<?php echo URL::site('company/testimonial/read/'.$testimoni->title);?>"><?php echo __('detail');?></a>
						</div> 
					</li>
					<?php } ?>				  
				</ul>
				<?php } else { ?>
					<div class="alert alert-warning" role="alert">
						<?php echo __('unavailable',array('%data'=>__('testimonials')));?>
					</div>
				<?php } ?>
				<div id="paging"><?php echo $pagination->render('pagination/site'); ?></div><div class="clear"></div></div>	
			</div>
        </div>
    </div>
  </div>
</div>	