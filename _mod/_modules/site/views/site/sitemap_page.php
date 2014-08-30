<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div id="middle">
	<div class="outerwrapper">
	  <div class="wrapper">        
	   <div id="sitemap"><h3><?php echo __('sitemap');?></h3>
	   <ul>
		<?php 
		   $i=1;
		   foreach ($pageCategory as $category) { 
				$category->title = ($category->title == 'home') ? '' : $category->title;
				$category->title = (strpos($category->title, 'http') === FALSE) ? URL::site($category->title) : $category->title;
		   ?>
		   <li class="<?php echo $i == 1 ? 'full' :'' ?>">
				<a href="<?php echo $category->title;?>" class="<?php echo 'parent';?>"><?php echo $categoryContent[$category->id]->subject;?></a>
				<?php 
				// Home
				if ($category->id == 10) { 
					echo Html::anchor('company/read/'.$about->title, $about->subject, array('title'=>$about->subject));
					echo Html::anchor('company/testimonial/', $testimonial->subject, array('title'=>$testimonial->subject));
					echo Html::anchor('download/', __('download'), array('title'=>__('download')));					
				} else 
				// Product				
				if ($category->id == 11) {
					foreach ($products as $product) {
						echo Html::anchor($category->title.'/read/'.$product->title, $product->subject, array('title'=>$product->subject));
					}
				} else
				// Solution Package
				if ($category->id == 12) {
					foreach ($solutionCategory as $solution) {
						echo Html::anchor($category->title.'/category/'.$solution->title, $solution->subject, array('title'=>$solution->subject));
					}
				} else
				// Support
				if ($category->id == 13) {
					echo Html::anchor($category->title,  __('helpdesk'), array('title'=> __('helpdesk')));
				} else
				// Download
				if ($category->id == 14) {
					foreach ($downloadType as $type) {
						echo Html::anchor($category->title.'/type/'.$type->title, $type->subject, array('title'=>$type->subject));
					}
				} else
				// Company
				if ($category->id == 15) { 
					foreach ($pages as $page) { 
						echo Html::anchor($category->title.'/read/'.$page->title, $page->subject, array('title'=>$page->subject));
					} 
					echo Html::anchor($category->title.'/newsevent/', __('events&csr'), array('title'=>__('events&csr')));
					echo Html::anchor($category->title.'/principal/', __('principal'), array('title'=>__('principal')));
					echo Html::anchor($category->title.'/testimonial/', __('testimonials'), array('title'=>__('testimonials')));
				} else 
				// Contact
				if ($category->id == 16){
					echo Html::anchor($category->title, __('contact_personal'), array('title'=>__('contact_personal')));
					echo Html::anchor($category->title, __('contact_corporate'), array('title'=>__('contact_corporate')));
				} 				
				?>	
				<?php /*if (!empty($page_category_child[$category->id])) { ?>	
					<ul class="hidden">
						<?php foreach ($page_category_child[$category->id] as $category_child => $child) { ?>
						<li>
							<a href="<?php echo URL::site($child->name);?>" title="<?php echo $child->title;?>">
								<?php echo HTML::chars($child->title, TRUE);?>
							</a>
						</li>
						<?php } ?>
					</ul>								
				<?php } */?>		
		   </li>
		<?php
		$i++;
		} 
		?> 
	   </ul>
	   <div class="clear"></div>
	   </div>
	  </div>
	</div>
</div>