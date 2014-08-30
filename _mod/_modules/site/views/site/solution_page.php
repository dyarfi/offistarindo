<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="middle">
    <div class="outerwrapper">
      <div class="wrapper">
        <div id="side-menu">
		  <?php if (!empty($page_category)) { ?><h3><?php echo $page_category[0]->subject;?></h3><?php } ?>
          <ul>
            <?php
			if (!empty($solution_categories) && count($solution_categories) > 1) {
				foreach ($solution_categories as $categories) { 
				$active = (Request::$current->param('id1') == $categories->title) ? 'active' : '';
				?>
				<li><a href="<?php echo URL::site('solution-package/category/'.$categories->title); ?>" class="<?php echo $active; ?>"><?php echo $categories->subject; ?></a></li>
			<?php }
			} else {
				?>
				<li><a href="<?php echo URL::site('solution-package/category/'.$solution_categories[0]->title); ?>" class="<?php echo 'active'; ?>"><?php echo $solution_categories[0]->subject; ?></a></li>
				<?php
			}
			?>
          </ul>
        </div>
        <div id="main-content" class="right">
			<div class="text-left">
				<?php if (!empty($page_category)) { ?><h3>
				<?php echo __('our', array('%title'=>$page_category[0]->subject));?> <?php //echo $page_category[0]->subject;?></h3>
				<?php } ?>
				<?php
				 if (!empty($solutions)) :
				 ?>
				   <ul id="list-reseller">
					   <?php
						if (!empty($solutions) && count($solutions) > 1) {
					   foreach ($solutions as $solution) {?>
					   <li>
						   <a href="<?php echo URL::site('solution-package/read/'.$solution->title);?>">
							   <?php if (!empty($solution_files[$solution->id])) {?>
								   <img src="<?php echo Url::site($upload_url.str_replace('.', '_crop_169x151.', $solution_files[$solution->id]->file_name));?>"/>
							   <?php } else { ?>
							   <img src="<?php echo IMG;?>themes/content/desc-product.png" width="169" height="151" alt="" class="img-responsive"/>						  
							   <?php } ?>
							   <div class="text-center row-fluid"><h6 class="head-product"><?php echo $solution->subject;?><h6></div>
						   </a>	
					   </li>	
					   <?php } 
						} else {							
							?>
					   <li>
						   <a href="<?php echo URL::site('solution-package/read/'.$solutions[0]->title);?>">
							   <?php if (!empty($solution_files[$solutions[0]->id]->file_name)) {?>
								   <img src="<?php echo Url::site($upload_url.str_replace('.', '_crop_169x151.', $solution_files[$solutions[0]->id]->file_name));?>"/>
							   <?php } else { ?>
							   <img src="<?php echo IMG;?>themes/content/desc-product.png" width="169" height="151" alt="" class="img-responsive"/>						  
							   <?php } ?>
							   <div class="text-center row-fluid"><h6 class="head-product"><?php echo $solutions[0]->subject;?><h6></div>
						   </a>	
					   </li>	
					   <?php
						}
						?>			
				   </ul>
				 <?php
				 endif;
				 ?>
			</div>	  
        </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>