<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="middle">
    <div class="outerwrapper">
      <div class="wrapper">
        <div id="side-menu">
          <?php if (!empty($page_category)) { ?><h3><?php echo $page_category[0]->subject;?></h3><?php } ?>
          <ul>
            <?php
			if (count($solution_categories) > 1) {
				foreach ($solution_categories as $categories) { 
				$active = (Request::$current->param('id1') == $categories->title) ? 'active' : '';
				//$active = '';
				?>
				<li><a href="<?php echo URL::site('solution-package/category/'.$categories->title); ?>" class="<?php echo $active; ?>"><?php echo $categories->subject; ?></a></li>
			<?php }
			} else {
			?>
			<li><a href="<?php echo URL::site('solution-package/category/'.$solution_categories[0]->title); ?>" class="<?php echo 'active'; ?>"><?php echo $solution_categories[0]->subject; ?></a></li>
			<?php }?>
          </ul>
        </div>
        <div id="main-content" class="right">
			<div class="text-left">
				<h3><?php echo $solution_categories[0]->subject; ?></h3>
			  <?php
			  if (!empty($solution)) :
			  ?>
				<h4 class=""><?php echo $solution[0]->subject;?></h4>
				<?php
				if (file_exists($upload_path.@$solution_files[$solution[0]->id]->file_name) && !empty($solution_files[$solution[0]->id])) {
				  $img_url = $upload_url.@$solution_files[$solution[0]->id]->file_name;
				?>
				<div class="img-thumbnail">
				<a class="colorbox cboxElement" title="<?php echo $solution[0]->subject;?>" href="<?php echo URL::site(str_replace('.', '_resize_640x384.',$img_url));?>">
					<img src="<?php echo URL::site(str_replace('.', '_crop_640x384.',$img_url));?>" alt="<?php echo $solution[0]->subject;?>" />
				</a>
				</div>	
				<?php
				}
				?>
				<div class="desc">
					<div class="content-page"><?php echo $solution[0]->text;?></div>					
				</div>	
					<?php if (!empty($solution[0]->combination1)) { ?>
					<h4 class="acc_trigger active"><?php echo __('combo_option');?> 1</h4>
					<div class="acc_container" style="display: block;">
						<p><?php echo $solution[0]->combination1;?></p>
					</div>
					<?php } ?>
					<?php if (!empty($solution[0]->combination2)) { ?>					
					<h4 class="acc_trigger"><?php echo __('combo_option');?> 2</h4>
					<div class="acc_container" style="display: none;">
						<p><?php echo $solution[0]->combination2;?></p>
					</div>
					<?php } ?>					
					<?php if (!empty($solution[0]->combination3)) { ?>						
					<h4 class="acc_trigger"><?php echo __('combo_option');?> 3</h4>
					<div class="acc_container" style="display: none;">
						<p><?php echo $solution[0]->combination3;?></p>
					</div>
					<?php } ?>						
			  <?php
			  endif;
			  ?>	
			</div>	  
        </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>