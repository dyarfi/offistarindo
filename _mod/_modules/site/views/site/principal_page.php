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
            <li><a href="<?php echo URL::site('company/principal');?>" class="active"><?php echo __('principal');?></a></li>
            <li><a href="<?php echo URL::site('company/testimonial');?>"><?php echo __('testimonials');?></a></li>
          </ul>
        </div>
		<div id="main-content" class="right">
			<div class="text-left">
				<h3><?php echo __('principal');?></h3>
				<?php if (!empty($principal)) { ?>
				<ul id="list-reseller">
					<?php foreach ( $principal as $val) { ?>
					<li>
						<?php if (file_exists($upload_path.$val->file_name) && is_file($upload_path.$val->file_name)) { ?>
						<a href="<?php echo URL::site($upload_url.$val->file_name);?>" class="colorbox" rel="groupbox" title="<?php echo Text::limit_chars(Lib::_trim_strip($val->text),78,'');?>">
							<img src="<?php echo URL::site($upload_url.str_replace('.', '_crop_186x126.', $val->file_name));?>" alt="<?php echo Lib::_trim_strip($val->text);?>" />
							<span class="caption"><?php echo $val->subject;?></span>
						</a>
						<?php } else { ?>
						<a href="#" title="<?php echo Lib::_trim_strip($val->text);?>">
							<img src="<?php echo IMG .'themes/content/'. $val->file_name;?>" alt="<?php echo Lib::_trim_strip($val->text);?>" />		  <span class="caption"><?php echo $val->subject;?></span>
						</a>	
						<?php }?>
					</li>
					<?php } ?>
				</ul>
				<?php } else { ?>
					<div class="alert alert-warning" role="alert">
						<?php echo __('unavailable',array('%data'=>__('reseller')));?>
					</div>
				<?php } ?>
				<div id="paging"><?php echo $pagination->render('pagination/site'); ?></div>	
			</div>
        </div>
    </div>
  </div>
</div>	