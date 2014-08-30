<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="middle">
	<div class="outerwrapper">
	  <div class="wrapper">
		<div id="side-menu">
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
			<li><a href="<?php echo URL::site('company/testimonial');?>"><?php echo __('testimonials');?></a></li>
		  </ul>
		</div>
		<div id="main-content" class="right">
			<div class="text-left">
			  <?php
			  if (!empty($about_page)): ?>
				  <h3><?php echo $about_page[0]->subject; ?></h3>
				 <?php if (is_file($upload_path . @Model_PageFile::instance()->load_by_group($about_page[0]->id)->file_name) && $about_page[0]->show_image) {?>
					<br/>
					<div class="img-thumbnail">	
						<a class="colorbox cboxElement" title="<?php echo $about_page[0]->subject;?>" href="<?php echo URL::site($upload_url.@Model_PageFile::instance()->load_by_group($about_page[0]->id)->file_name);?>">
					<img src="<?php echo URL::site($upload_url.str_replace('.', '_crop_640x421.', 
						@Model_PageFile::instance()->load_by_group($about_page[0]->id)->file_name));?>" alt="<?php echo $about_page[0]->subject;?>" />
					</a>
					</div>				 
				 <br/><br/>
				 <?php } ?>
				<div class="content-page"><?php echo $about_page[0]->text; ?></div>
				<?php
			  endif;
			  ?>
			  </div>
			</div>	  
		</div>
		<div class="clear"></div>
	  </div>
	</div>