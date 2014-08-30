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
			  <h3><?php echo $category_detail[0]->subject;?></h3>
			  <div><?php echo $category_detail[0]->text;?></div>			  
			  <?php
			  if (!empty($products_listings)) {
				  ?>
				 <ul id="list-reseller">
					<?php foreach ( $products_listings as  $product) { ?>
					<li>
						<a href="<?php echo URL::site('products/read/'.$product->title);?>" title="<?php echo Lib::_trim_strip($product->subject);?>">
							<?php if (!empty($product_files[$product->id])) {?>
							<img src="<?php echo URL::site($upload_url.str_replace('.', '_crop_169x151.', $product_files[$product->id]->file_name));?>" alt="<?php echo Lib::_trim_strip($product->subject);?>" class="img-responsive" />
							<!--span class="caption"><?php echo $product->subject;?></span-->
							<?php } else { ?>
							<img src="<?php echo IMG;?>themes/content/desc-product.png" width="169" height="151" alt="" class="img-responsive"/>						  
							<?php } ?>
							<div class="text-center row-fluid"><h6 class="head-product"><?php echo $product->subject;?></h6></div>
						</a>
					</li>
					<?php } ?>
				</ul>
				<div id="paging"><?php echo $pagination->render('pagination/site'); ?></div>	
				<?php
			  } else { ?>
				<div class="alert alert-warning" role="alert">
				  <?php echo __('product_not_in',array('%data'=>$category_detail[0]->subject));?>
				</div>
			  <?php } ?>	
		  </div>
		  </div>	
		  <div class="clear"></div>
	  </div>
  </div>
</div>