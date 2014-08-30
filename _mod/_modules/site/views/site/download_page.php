<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="middle">
    <div class="outerwrapper">
      <div class="wrapper">
        <div id="side-menu">
          <?php if (!empty($page_category)) { ?><h3><?php echo $page_category[0]->subject;?></h3><?php } ?>
          <ul>
			  <?php foreach ($downloadtypes as $downloadtype){ ?>
			  <li>
				  <a href="<?php echo URL::site('download/type/'.$downloadtype->title);?>" class="<?php echo ($downloadtype->title == Request::$current->param('id1')) ? 'active' : '';?>"><?php echo $downloadtype->subject;?></a>
			  </li>
			  <?php } ?>
          </ul>
        </div>
        <div id="main-content" class="right">
		<div class="text-left">	
          <h3><?php echo isset($type[0]->subject) ? $type[0]->subject : __('download');?></h3>
		  <ul id="brochure">
			<?php if (!empty($downloadfiles)) {
			  foreach ($downloadfiles as $file) { ?>				
			    <li>
					<?php if (!empty($downloadfilesfile->load_by_group($file->id)->file_name)) { ?>
						<img src="<?php echo URL::site($downloadfile_upload_url. str_replace('.', '_crop_88x98.', $downloadfilesfile->load_by_group($file->id)->file_name));?>" width="88" height="98" alt="" class="img-thumbnail" />
					<?php } else { ?>
						<img src="<?php echo IMG;?>themes/content/brochure.jpg" width="88" height="98" alt="" />
					<?php } ?>					
					<h6><?php echo Text::limit_words($file->subject,50); ?></h6>
					<p><?php echo Text::limit_words(strip_tags($file->text),40); ?></p>
					<?php if (file_exists($downloadfile_upload_path . $file->file_name)) {?>
					<a title="<?php echo __('size');?> | <?php echo Text::bytes(@filesize(@$downloadfile_upload_path . $file->file_name));?>" class="tooltips download_file <?php echo ($member) ? '' : 'iframe';?>" href="<?php echo ($member) ? URL::site('download/file/'.  base64_encode($downloadfile_upload_url . $file->file_name)) : URL::site('member/login');?>" rel="<?php echo base64_encode($file->id);?>"><?php echo $page_category[0]->subject;?><span><?php echo Text::bytes(@filesize(@$downloadfile_upload_path . $file->file_name));?></span></a>
					<?php } ?>
				</li>			
			  <?php } 
				} else { ?>
				<div class="alert alert-warning" role="alert">
					<?php echo __('unavailable',array('%data'=>@$type[0]->subject));?>
				</div>	
			<?php } ?>	
          </ul>  
         <div id="paging"><?php echo $pagination->render('pagination/site'); ?></div>		         
        </div>
		</div>	
        <div class="clear"></div>
      </div>
    </div>
  </div>