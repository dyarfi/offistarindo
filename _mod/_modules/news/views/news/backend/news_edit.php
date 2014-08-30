<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
$(document).ready(function () {
	$('#language_select').change(function() {
	<?php
	$prefix = array();
	foreach($language_data as $row):
		$img		= IMG.'languages/'.$row->file_name;
		$prefix[$row->id] = $row->prefix;
		?>
		if($(this).val() == <?php echo $row->id; ?> && $(this).val() != 0) {
			$("<?php echo '#lang_' . $row->prefix; ?>").fadeIn();
			$(".flag_holder").html('<img src="<?php echo $img;?>" alt="<?php echo $row->name; ?>"/>');	
		} else {
			$("<?php echo '#lang_' . $row->prefix; ?>").fadeOut();
		}
		<?php
	endforeach;
	?>
	}).eq(0).change();
});
</script>
<h2><?php echo $module_menu;?></h2>
<?php 
echo Form::open(URL::site(ADMIN.$class_name.'/edit/'.$news->id), array(
															'enctype' => 'multipart/form-data', 
															'method' => 'post', 
															'class' => 'general autovalid form_details',
															'id' => ''
														));
?>
	<div class="form_wrapper">	
		<fieldset>		
			<legend>News Title</legend>
			<div class="ls5 clear1"></div>						
			<div class="form_row">
				<?php echo Form::label('title','Title &nbsp; : <span class="gray">AlphaNumeric - [a-z/-/0-9]</span>'); ?>
				<?php echo Form::input('title', $fields['title'],array('id'=>'title_edit', 'class'=>'title_edit required','rel'=>$class_name)); ?>				  <?php echo sprintf($errors['title'], 'Title'); ?>
				<span class="red"></span>
			</div>			
			<div class="form_row">
				<?php echo Form::label('news_date','Date &nbsp; : <span class="gray">'.i18n::get('date').' - '.i18n::get('date_format').'</span>'); ?>
				<?php echo Form::input('news_date',$fields['news_date'],array('id'=>'news_date', 'class'=>'required simpledate')); ?>
				<?php echo sprintf($errors['news_date'], 'News Date'); ?>
			</div>			
		</fieldset>
				
		<div style="margin:10px">
				<label>Change Language&nbsp;&nbsp;</label>
				<select name="language_select" id="language_select" class="">
					<?php 
					foreach($language_data as $flag):						
						$img		= IMG.'languages/'.$flag->file_name;
					?>
					<option value="<?php echo $flag->id;?>" <?php echo ($flag->id == 1) ? 'selected="selected"' : ''; ?>>
						<?php echo $flag->name; ?>
					</option>
					<?php 
					endforeach; 
					?>
				</select>
				<div class="flag_holder"></div>
				<span class="lang_field_err red" style="display:none">Please check other language data before submitting</span>
		</div>
		
		<fieldset class="lang_content">		
        <legend>News Content</legend>
		<div class="ls5 clear1"></div>
		<?php 
			$i=0;
			foreach($language_data as $language) :
				$img = IMG.'languages/'.$language->file_name;
				if (!empty($detail_data[$language->id]->id) && $detail_data[$language->id]->lang_id == $language->id):
				?>	
				<div id="lang_<?php echo $prefix[$language->id]; ?>">
					<?php //echo sprintf($errors['title'], 'Title'); ?>
					<div class="form_row">
						<label>Subject</label>
						<div class="ls2"></div>
						<div class="lang_desc_row"><a class="right_float" href="javascript:void(0);" title="<?php echo $language->name; ?>">&nbsp;<img src="<?php echo $img; ?>" alt="<?php echo $language->name;?>"/>&nbsp;<?php echo $language->name; ?></a></div>
						<input type="text" name="detail[<?php echo $language->id;?>][subject]" id="subject_<?php echo $detail_data[$language->id]->lang_id; ?>_<?php echo $detail_data[$language->id]->lang_id; ?>" class="required" value="<?php echo $detail_data[$language->id]->subject; ?>" />
						<input type="hidden" name="detail[<?php echo $language->id;?>][id]" id="detail_id_<?php echo $detail_data[$language->id]->id; ?>" value="<?php echo $detail_data[$language->id]->id; ?>" />
						<input type="hidden" name="detail[<?php echo $language->id;?>][lang_id]" id="language_id_<?php echo $language->id; ?>" value="<?php echo $language->id; ?>" />
					</div>
					<?php //echo sprintf($errors['description'], 'Text'); ?>
					<div class="form_row">
						<label>Synopsis</label>
						<div class="ls2 clear1"></div>
						<textarea style="vertical-align: middle; height:100px" name="detail[<?php echo $language->id;?>][synopsis]" id="synopsis_<?php echo $detail_data[$language->id]->lang_id; ?>_<?php echo $detail_data[$language->id]->lang_id; ?>" class="" rows="3"><?php echo trim($detail_data[$language->id]->synopsis); ?></textarea>
					</div>						
					<?php //echo sprintf($errors['description'], 'Text'); ?>
					<div class="form_row">
						<label>Text</label>
						<textarea name="detail[<?php echo $language->id;?>][text]" id="description_<?php echo $detail_data[$language->id]->lang_id; ?>_<?php echo $detail_data[$language->id]->lang_id; ?>" class="required ckeditor"><?php echo $detail_data[$language->id]->text; ?></textarea>
					</div>	
				</div>	
				<?php 
					else:
				?>
				<div id="lang_<?php echo $prefix[$language->id]; ?>">
					<div class="form_row">
						<label>Subject</label>
						<div class="ls2"></div>
						<div class="lang_desc_row"><a class="right_float" href="javascript:void(0);" title="<?php echo $language->name; ?>">&nbsp;<img src="<?php echo $img; ?>" alt="<?php echo $language->name;?>"/>&nbsp;<?php echo $language->name; ?></a></div>
						<input type="text" name="detail[<?php echo $language->id;?>][subject]" id="subject_<?php echo $language->id; ?>" class="required" value="" />
						<input type="hidden" name="detail[<?php echo $language->id;?>][id]" id="detail_id_<?php echo $language->id; ?>" value="<?php echo isset($detail_data[$language->id]->id) ? $detail_data[$language->id]->id : ''; ?>" />
						<input type="hidden" name="detail[<?php echo $language->id;?>][lang_id]" id="language_id_<?php echo $language->id; ?>" value="<?php echo $language->id; ?>" />
					</div>
					<?php //echo sprintf($errors->synopsis, 'Synopsis'); ?>
					<div class="form_row">
						<label>Synopsis</label>
						<div class="ls2 clear1"></div>
						<textarea style="vertical-align: middle; height:100px" rows="3" name="detail[<?php echo $language->id;?>][synopsis]" id="synopsis_<?php echo $language->id; ?>" class=""></textarea>
					</div>						
					<?php //echo sprintf($errors['description'], 'Text'); ?>
					<div class="form_row">
						<label>Text</label>
						<textarea name="detail[<?php echo $language->id;?>][text]" id="description_<?php echo $language->id; ?>" class="required ckeditor"></textarea>
					</div>	
				</div>
			<?php
				//endif;
			endif;
			$i++;
		endforeach;
		?>
		</fieldset>
				
        <?php if (isset($show_upload) && $show_upload) : ?>
        <?php foreach ($uploads as $row_name => $row_params) : ?>
            <fieldset style="clear:both;">
                <legend><strong><?php echo $row_params['label']; ?></strong></legend>
                <?php if (isset($files[$row_name])) : ?>
                <div class="form_row">
                    <label><?php echo $row_params['label']; ?></label>
                    <div class="form_fields">
                        <?php if (is_file($upload_path.$files[$row_name]->file_name) && in_array($files[$row_name]->file_type, $readable_mime)) : ?>
                        <div id="file_<?php echo $files[$row_name]->id; ?>">
                            <?php if (substr($files[$row_name]->file_type, 0, strlen('image/')) == 'image/') : ?>
                            <?php
                                $file_data	= pathinfo(URL::base().$upload_url.$files[$row_name]->file_name);
                                $thumb_ext	= isset($row_params['image_manipulation']['thumbnails'][0]) ? '_resize_'.$row_params['image_manipulation']['thumbnails'][0] : '';
                            ?>
                            <img src="<?php echo URL::base().$upload_url.$file_data['filename'].$thumb_ext.'.'.$file_data['extension']; ?>" alt="<?php echo URL::base().$upload_url.$files[$row_name]->file_name; ?>" />
                            <?php elseif (substr($files[$row_name]->file_type, 0, strlen('audio/')) == 'audio/') : ?>
                            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="20" id="FLVPlayer">
                                <param name="movie" value="<?php echo URL::base(); ?>flash/singlemp3player.swf" />
            
                                <param name="quality" value="high" />
                                <param name="wmode" value="opaque" />
                                <param name="scale" value="noscale" />
                                <param name="salign" value="lt" />
                                <param name="FlashVars" value="file=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;backColor=c2c2c2&amp;frontColor=666666&amp;showDownload=false&amp;repeatPlay=false&songVolume=100" />
                                <param name="swfversion" value="8,0,0,0" />
                                <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don�t want users to see the prompt. -->
                                <param name="expressinstall" value="Scripts/expressInstall.swf" />
                                <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
            
                                <!--[if !IE]>-->
                                <object type="application/x-shockwave-flash" data="<?php echo URL::base(); ?>flash/singlemp3player.swf" width="320" height="20">
                                <!--<![endif]-->
                                    <param name="quality" value="high" />
                                    <param name="wmode" value="opaque" />
                                    <param name="scale" value="noscale" />
                                    <param name="salign" value="lt" />
                                    <param name="FlashVars" value="file=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;backColor=c2c2c2&amp;frontColor=666666&amp;showDownload=false&amp;repeatPlay=false&songVolume=100" />
                                    <param name="swfversion" value="8,0,0,0" />
            
                                    <param name="expressinstall" value="Scripts/expressInstall.swf" />
                                    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
                                    <div>
                                    <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                                    <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                                    </div>
                                <!--[if !IE]>-->
                                </object>
            
                                <!--<![endif]-->
                            </object>
                            <?php else : ?>
                            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="240" id="FLVPlayer">
                                <param name="movie" value="<?php echo URL::base(); ?>flash/FLVPlayer_Progressive.swf" />
            
                                <param name="quality" value="high" />
                                <param name="wmode" value="opaque" />
                                <param name="scale" value="noscale" />
                                <param name="salign" value="lt" />
                                <param name="FlashVars" value="skinName=<?php echo URL::base(); ?>flash/Corona_Skin_2&amp;streamName=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;autoPlay=false&amp;autoRewind=false" />
                                <param name="swfversion" value="8,0,0,0" />
                                <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don�t want users to see the prompt. -->
                                <param name="expressinstall" value="Scripts/expressInstall.swf" />
                                <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
            
                                <!--[if !IE]>-->
                                <object type="application/x-shockwave-flash" data="<?php echo URL::base(); ?>flash/FLVPlayer_Progressive.swf" width="320" height="240">
                                <!--<![endif]-->
                                    <param name="quality" value="high" />
                                    <param name="wmode" value="opaque" />
                                    <param name="scale" value="noscale" />
                                    <param name="salign" value="lt" />
                                    <param name="FlashVars" value="skinName=<?php echo URL::base(); ?>flash/Corona_Skin_2&amp;streamName=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;autoPlay=false&amp;autoRewind=false" />
                                    <param name="swfversion" value="8,0,0,0" />
            
                                    <param name="expressinstall" value="Scripts/expressInstall.swf" />
                                    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
                                    <div>
                                    <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                                    <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                                    </div>
                                <!--[if !IE]>-->
                                </object>
            
                                <!--<![endif]-->
                            </object>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        Cannot preview this file
                        <?php endif; ?>
                    </div>
                </div>
            
                <div class="form_row">
                    <!--label class="no_border">&nbsp;</label-->
                    <div class="form_field"><a href="<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>"><img src="<?php echo IMG; ?>admin/disk.png" alt="<?php echo $files[$row_name]->file_name; ?>" /></a></div>
                </div>
            
                <?php echo sprintf($errors[$row_name], $row_params['label']); ?>
                <div class="form_row">
                    <label>Replace <?php echo $row_params['label']; ?></label>
                    <input type="file" name="<?php echo $row_name; ?>" id="<?php echo $row_name; ?>" />
                    <?php if (isset($row_params['note']) && $row_params['note'] != '') : ?>
                        <div class="form_row">
                            <!--label>&nbsp;</label-->
                            <?php echo HTML::chars($row_params['note'], TRUE); ?>
                        </div>
                    <?php endif; ?>
                </div>
            
                <?php if (isset($row_params['caption']) && $row_params['caption']) : ?>
                <div class="form_row">
                    <label>Caption</label>
                    <input type="text" name="<?php echo $row_name.'_caption'; ?>" id="<?php echo $row_name.'_caption'; ?>" value="<?php echo $fields[$row_name.'_caption']; ?>" />
                </div>
                <?php endif; ?>
            
                <?php if (isset($row_params['optional']) && $row_params['optional']) : ?>
                <div class="form_row">
                    <label>Delete <?php echo $row_params['label']; ?>?</label>
                    <input type="checkbox" name="delete_<?php echo $row_name; ?>" id="delete_<?php echo $row_name; ?>" value="1" />
                    <label for="delete_<?php echo $row_name; ?>" class="sub_label">Yes, delete this <?php echo $row_params['label']; ?></label>
                </div>
                <?php endif; ?>
            
                <?php else : ?>
            
                <?php echo sprintf($errors[$row_name], $row_params['label']); ?>
                <div class="form_row">
                    <label><?php echo $row_params['label']; ?></label>
                    <input type="file" name="<?php echo $row_name; ?>" id="<?php echo $row_name; ?>" />
                    <?php if (isset($row_params['note']) && $row_params['note'] != '') : ?>
                        <div class="form_row">
                            <label>&nbsp;</label>
                            <?php echo HTML::chars($row_params['note'], TRUE); ?>
                        </div>
                    <?php endif; ?>
                </div>
            
                <?php if (isset($row_params['caption']) && $row_params['caption']) : ?>
                <div class="form_row">
                    <label>Caption</label>
                    <input type="text" name="<?php echo $row_name.'_caption'; ?>" id="<?php echo $row_name.'_caption'; ?>" value="<?php echo $fields[$row_name.'_caption']; ?>" />
                </div>
                <?php endif; ?>
            
                <?php endif; ?>
        	</fieldset>    
        <?php endforeach; ?>
        <?php endif; ?>
		
		
    	<?php if (!empty($news_files)) : ?>
		<fieldset>
			<legend><strong>Image Files</strong></legend>
			<div class="img_holder_xhr">				
			<?php foreach ($news_files as $files): ?>
			<div class="pull-left img-thumbnail">
				<a class="colorbox" rel="groupbox" href="<?php echo URL::site($files_upload_url . $files->file_name);?>">
					<img class="img-rounded" src="<?php echo URL::site($files_upload_url . str_replace('.', '_crop_80x80.', $files->file_name));?>"/>
				</a>	
				<div class="label-function hidden">
				<a href="<?php echo URL::site(ADMIN.$class_name.'/filedelete/' . $files->id); ?>" title="Delete" class="label label-default delete_function" onclick="javascript:void(0);">DELETE</a>
				<!--a href="<?php echo URL::site(ADMIN.$class_name.'/filechange/' . $files->id); ?>" title="Change" class="label label-default change_function ajax" onclick="javascript:void(0);">CHANGE</a-->
				</div>
			</div>
			<?php endforeach; ?>	
			</div> 
			<div class="clear topBotDiv10"></div>
			<input id="fileupload" class="file" type="file" name="files" rel="<?php echo $news->id;?>" data-url="<?php echo URL::site(ADMIN.$class_name.'/fileupload/'.$news->id)?>" multiple/>				
			<div class="clear"></div>				
		</fieldset>		
		<?php else : ?>		
		<fieldset>
			<legend><strong>Files</strong></legend>						
			<div class="img_holder_xhr"></div>
			<div class="clear topBotDiv10"></div>
			<input id="fileupload" class="input-sm" type="file" name="files" rel="<?php echo $news->id;?>" data-url="<?php echo URL::site(ADMIN.$class_name.'/fileupload/'.$news->id)?>" multiple/>
			<div class="clear"></div>			
		</fieldset>	
		<?php endif; ?>	
		<!-- The global progress bar -->
		<div id="progress" class="progress" style="display:none">
			<div class="progress-bar progress-bar-success"></div>
		</div>	
		
		
        <?php echo sprintf($errors['status'], 'Status'); ?>
        <div class="form_row">
            <label>Status</label>
            <select name="status" id="status" class="required">
                <option value="">&nbsp;</option>
                <?php foreach ($statuses as $row) : ?>
                <option value="<?php echo $row; ?>" <?php echo ($fields['status'] == $row) ? 'selected="selected"' : ''; ?>><?php echo HTML::chars(ucfirst($row), TRUE); ?></option>
                <?php endforeach; ?>
            </select>
        </div>    
        <div class="form_row">
            <label>Created</label>
            <div class="form_field"><?php echo ($news->added != 0) ? date(Lib::config('admin.date_format'), $news->added) : '-'; ?></div>
        </div>
        <div class="form_row">
            <label>Last Modified</label>
            <div class="form_field"><?php echo ($news->modified != 0) ? date(Lib::config('admin.date_format'), $news->modified) : '-'; ?></div>
        </div>
	</div>
	<div class="form_row">
		<?php echo Form::submit(NULL, '', array('class' => 'btn_save')); ?>
	</div>
<?php echo Form::close();?>
<?php if ($show_upload) { ?>
<script type="text/javascript">
$(document).ready(function() {
	<?php 
	$i = 1;
	foreach ($uploads as $pref => $val) { ?>
		$('#<?php echo $pref;?>').on('change',function(){
			var ext<?php echo $i;?> = $(this).val().split('.').pop().toLowerCase();
			if($.inArray(ext<?php echo $i;?>, <?=json_encode((array)explode(',', $val['file_type']));?>) === -1) {
				jAlert('Invalid file type (<?=$val['file_type'];?>)', 'Error');
				$(this).val('');
			}
		});		
	<?php 
	$i++;
	} 
	?>
});
</script>
<?php } ?>