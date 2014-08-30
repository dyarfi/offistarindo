<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="middle">
    <div class="outerwrapper">
		<div class="wrapper">
		  <div id="side-menu">
			<?php if (!empty($page_category)) { ?><h3><?php echo $page_category[0]->subject;?></h3><?php } ?>
			<!--
			<ul>
			<?php foreach ($product_category as $category) { ?>
			<li>
				<a href="javascript:;" title="<?php echo $category->subject;?>" class="">
					<?php echo HTML::chars($category->subject ,TRUE);?>
				</a>
				<?php if (!empty($products[$category->id])) { ?>
				<ul class="product">
					<?php foreach ($products[$category->id] as $product => $val) { 
						$active = (Request::$current->param('id1') == $val->title) ? 'active' : '';
						?>
						<li><a href="<?php echo URL::site('products/read/'.$val->title);?>" class="<?php echo $active;?>">
							<?php echo $val->subject;?></a>
						</li>
					<?php } ?>
				</ul>
				<?php } ?>
				<?php 
				if (!empty($child_category[$category->id])) { ?>	
					<ul>
						<?php foreach ($child_category[$category->id] as $category_child => $child) { ?>
						<li>
							<a href="javascript:;" title="<?php echo $child->subject;?>">
								<?php echo HTML::chars($child->subject, TRUE);?>					
							</a>
							<?php if (!empty($products[$child->id])) { ?>
							<ul class="product">
								<?php foreach ($products[$child->id] as $product => $val1) { 
									$active = (Request::$current->param('id1') == $val1->title) ? 'active' : '';
									?>
									<li><a href="<?php echo URL::site('products/read/'.$val1->title);?>" class="<?php echo $active;?>">
										<?php echo $val1->subject;?></a>
									</li>
								<?php } ?>
							</ul>
							<?php } ?>
							<?php 
								if (!empty($child_category[$child->id])) { ?>	
									<ul>
										<?php foreach ($child_category[$child->id] as $category_child => $childs) { ?>
										<li>
											<a href="javascript:;" title="<?php echo $childs->subject;?>">
												<?php echo HTML::chars($childs->subject, TRUE);?>
											</a>
											<?php if (!empty($products[$childs->id])) { ?>
											<ul>
												<?php foreach ($products[$childs->id] as $product => $val2) { 
													$active = (Request::$current->param('id1') == $val2->title) ? 'active' : '';
													?>
													<li><a href="<?php echo URL::site('products/read/'.$val2->title);?>" class="<?php echo $active;?>">
														<?php echo $val2->subject;?></a>
													</li>
												<?php } ?>
											</ul>
											<?php } ?>
										</li>
										<?php } ?>
									</ul>								
								<?php }?>
						</li>
						<?php } ?>
					</ul>								
				<?php }?>							
			</li>
			<?php } ?>
			</ul>
			-->
			<script type="text/javascript">
			/*	
			$(document).ready(function(){
				$('ul.product li').each(function(){
					$(this).click(function (){
						//if($(this).next('li').hasClass('hidden') === true){
							$(this).nextUntil('li.active').toggleClass('hidden');
						//}
						return false;
					});
				}).eq(0).delay(5000).click();
			});
			*/
			</script>
			<?php echo Lib::traverse('',URL::site('products/browse'),'0',$product_category);?>
		  </div>
		  <div id="main-content" class="right">
			  <div class="text-left">
			  <h3><?php echo $page_category[0]->subject;?></h3>
			  <div><?php echo $page_category[0]->text;?></div>			  
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
							<div class="text-center row-fluid"><h6 class="head-product"><?php echo $product->subject;?><h6></div>
						</a>
					</li>
					<?php } ?>
				</ul>
				<div id="paging"><?php echo $pagination->render('pagination/site'); ?></div>	
				<?php
			  } ?>
		  </div>
		  </div>	
		  <div class="clear"></div>
	  </div>
  </div>
</div>