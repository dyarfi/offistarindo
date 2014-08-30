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
<h2><?php echo $module_menu; ?></h2>
<?php 
echo Form::open(URL::site(ADMIN.$class_name.'/edit/'.$solution->id), array(
													'enctype' => 'multipart/form-data', 
													'method' => 'post', 
													'class' => 'general autovalid form_details',
													'id' => 'edit-gallery'
												));	
echo Form::hidden('order', $solution->order);
?>	
	<div class="form_wrapper">	
		
						
		<fieldset>		
			<legend>Solution Title</legend>
			<div class="ls5 clear1"></div>
			<?php echo sprintf($errors['title'], 'Title'); ?>
			<div class="form_row">
				<label>Title</label>
				<input type="text" name="title" id="title" class="required" value="<?php echo $fields['title']; ?>" />
			</div>
		
		<?php if (isset($show_category) && $show_category) : ?>
        <?php echo sprintf($errors['category_id'], 'Category');
		?>
        <div class="form_row">
			<input type="hidden" name="current_cid" id="current_cid" value="<?php echo $fields['category_id'];?>"/>
            <label>Category</label>
            <select name="category_id" id="category_id" class="required">
                <option value="">&nbsp;</option>
                <?php foreach ($categories as $row) : ?>
                <option value="<?php echo ($row->status == 'publish') ? $row->id : '0';?>" <?php echo ($fields['category_id'] == $row->id) ? 'selected="selected"' : ''; ?>><?php echo str_repeat('&nbsp;', $row->sub_level * 5).HTML::chars(Text::limit_chars(@$row->title,20), TRUE); ?> <?php echo ($row->status != 'publish') ? '('.$row->status.')' : ''; ?>
					<?php
					$subject = Model::factory('SolutionCategory')->find_detail($row->id);
					echo ($subject[0]->subject) ? ' ('.$subject[0]->subject.')' : '';
					?>
					</option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php else : ?>
        <input type="hidden" name="category_id" id="category_id" value="<?php echo $fields['category_id']; ?>" />
		<?php endif;?>
				
		<?php if (isset($show_media) && $show_media) : ?>
		<?php echo sprintf($errors['media'], 'Media'); ?>
		<div class="form_row topBotDiv5 media_upload">
			<div class="hidden_input form_row"><strong>Media</strong> :
				<span><?php echo htmlspecialchars($fields['media']); ?></span>
				<?php if (!empty($fields['media'])) { ?>
				<label for="media_clear">Delete 
					<input type="checkbox" name="media_clear" id="media_clear" class="media_clear" value="1" />
				</label>
				<?php } ?>
				<input type="hidden" name="media" id="media" class="input_media" value="<?php echo htmlspecialchars($fields['media']); ?>" />
				
			</div>					

			<div id="library_tab">		
				<ul class="list-inline add_media">
					<li><a href="#media_youtube" rel="add_media_youtube" title="Add from Youtube URL">Add from YouTube URL</a></li>
					<li><a href="#media_library" rel="add_media_library" title="Add from Library">Add from Library</a></li>
				</ul>
				<div id="media_youtube">
					<input type="text" class="input_media" placeholder="http://youtube.com" name="_media" id="fileYoutube" value="" />		
				</div>
				<div id="media_library" class="input-append">
					<input type="text" class="input_media" name="_media" id="fileName" readonly="" value="">
					<a href="<?php echo Lib::config('admin')->filemanager_path.'&amp;type=3&amp;fldr=/videos/';?>" class="btn iframe-btn " type="button">Select</a>
				</div>
			</div>	
		</div>
		<?php endif; ?>
			<div class="ls10 clear"></div>
		</fieldset>
		
		<div class="ls1 clear"></div>		
		
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
        <legend>Solution Content</legend>
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
						<label>Text</label>
						<textarea name="detail[<?php echo $language->id;?>][text]" id="description_<?php echo $detail_data[$language->id]->lang_id; ?>_<?php echo $detail_data[$language->id]->lang_id; ?>" class="required ckeditor"><?php echo $detail_data[$language->id]->text; ?></textarea>
					</div>
					<div class="form_row">
						<label>Combination 1</label>
						<textarea name="detail[<?php echo $language->id;?>][overview]" id="overview_<?php echo $detail_data[$language->id]->lang_id; ?>_<?php echo $detail_data[$language->id]->lang_id; ?>" class="ckeditor"><?php echo $detail_data[$language->id]->combination1; ?></textarea>
					</div>
					<div class="form_row">
						<label>Combination 2</label>
						<textarea name="detail[<?php echo $language->id;?>][features]" id="features_<?php echo $detail_data[$language->id]->lang_id; ?>_<?php echo $detail_data[$language->id]->lang_id; ?>" class="ckeditor"><?php echo $detail_data[$language->id]->combination2; ?></textarea>
					</div>
					<div class="form_row">
						<label>Combination 3</label>
						<textarea name="detail[<?php echo $language->id;?>][specification]" id="specification_<?php echo $detail_data[$language->id]->lang_id; ?>_<?php echo $detail_data[$language->id]->lang_id; ?>" class="ckeditor"><?php echo $detail_data[$language->id]->combination3; ?></textarea>
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
					<?php //echo sprintf($errors['description'], 'Text'); ?>
					<div class="form_row">
						<label>Text</label>
						<textarea name="detail[<?php echo $language->id;?>][text]" id="description_<?php echo $language->id; ?>" class="required ckeditor"></textarea>
					</div>
					<div class="form_row">
						<label>Combination 1</label>
						<textarea name="detail[<?php echo $language->id;?>][combination1]" id="combination1_<?php echo $language->id; ?>" class="ckeditor"></textarea>
					</div>
					<div class="form_row">
						<label>Combination 2</label>
						<textarea name="detail[<?php echo $language->id;?>][combination2]" id="combination2_<?php echo $language->id; ?>" class="ckeditor"></textarea>
					</div>
					<div class="form_row">
						<label>Combination 3</label>
						<textarea name="detail[<?php echo $language->id;?>][combination3]" id="combination3_<?php echo $language->id; ?>" class="ckeditor"></textarea>
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
                                $file_data	= pathinfo(URL::site().$upload_url.$files[$row_name]->file_name);
                                $thumb_ext	= isset($row_params['image_manipulation']['thumbnails'][0]) ? '_resize_'.$row_params['image_manipulation']['thumbnails'][0] : '';
                            ?>
                            <img src="<?php echo URL::site().$upload_url.$file_data['filename'].$thumb_ext.'.'.$file_data['extension']; ?>" alt="<?php echo URL::site().$upload_url.$files[$row_name]->file_name; ?>" />
                            <?php elseif (substr($files[$row_name]->file_type, 0, strlen('application/')) == 'application/') : ?>
                                <object type="application/x-shockwave-flash" data="<?php echo URL::site().$upload_url.$files[$row_name]->file_name; ?>" width="564" height="300">
                                    <param name="allowScriptAccess" value="sameDomain" />
                                    <param name="allowFullScreen" value="false" />
                                    <param name="wmode" value="transparent" />
                                    <param name="quality" value="high" />
                                    <param name="bgcolor" value="#ffffff" />
                                    <param name="movie" value="<?php echo URL::site().$upload_url.$files[$row_name]->file_name; ?>" />
                                </object>
                            <?php elseif (substr($files[$row_name]->file_type, 0, strlen('audio/')) == 'audio/') : ?>
                            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="20" id="FLVPlayer">
                                <param name="movie" value="<?php echo ASSETS; ?>flash/singlemp3player.swf" />
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
                                <object type="application/x-shockwave-flash" data="<?php echo ASSETS; ?>flash/singlemp3player.swf" width="320" height="20">
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
                                <param name="movie" value="<?php echo ASSETS; ?>flash/FLVPlayer_Progressive.swf" />
                                <param name="quality" value="high" />
                                <param name="wmode" value="opaque" />
                                <param name="scale" value="noscale" />
                                <param name="salign" value="lt" />
                                <param name="FlashVars" value="skinName=<?php echo ASSETS; ?>flash/Corona_Skin_2&amp;streamName=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;autoPlay=false&amp;autoRewind=false" />
                                <param name="swfversion" value="8,0,0,0" />
                                <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don�t want users to see the prompt. -->
                                <param name="expressinstall" value="Scripts/expressInstall.swf" />
                                <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
                                <!--[if !IE]>-->
                                <object type="application/x-shockwave-flash" data="<?php echo ASSETS; ?>flash/FLVPlayer_Progressive.swf" width="320" height="240">
                                <!--<![endif]-->
                                    <param name="quality" value="high" />
                                    <param name="wmode" value="opaque" />
                                    <param name="scale" value="noscale" />
                                    <param name="salign" value="lt" />
                                    <param name="FlashVars" value="skinName=<?php echo ASSETS; ?>flash/Corona_Skin_2&amp;streamName=<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>&amp;autoPlay=false&amp;autoRewind=false" />
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
                    <div class="form_field"><a href="<?php echo URL::site(ADMIN.$class_name.'/download/'.$files[$row_name]->file_name); ?>"><img src="<?php echo IMG; ?>admin/disk.png" alt="<?php echo $files[$row_name]->file_name; ?>" /></a></div>
                </div>
                <?php echo sprintf($errors[$row_name], $row_params['label']); ?>
                <div class="form_row">
                    <label>Replace <?php echo $row_params['label']; ?></label>
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
		<?php if (isset($show_owner) && $show_owner) : ?>
		<?php echo sprintf($errors['user_id'], 'Owner'); ?>
		<div class="form_row">
			<label>Owner</label>
			<select name="user_id" id="user_id">
				<option value="">&nbsp;</option>
				<option value="0" <?php echo ($fields['user_id'] == 0) ? 'selected="selected"' : ''; ?>>System</option>
				<?php foreach ($users as $row) : ?>
				<option value="<?php echo $row->id; ?>" class="user_<?php echo $row->id; ?>" <?php echo ($fields['user_id'] == $row->id) ? 'selected="selected"' : ''; ?>><?php echo HTML::chars($row->name.' ('.$row->email.')', TRUE); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php endif; ?>
		<?php if (isset($show_order) && $show_order) : ?>
		<?php echo sprintf($errors['order'], 'Order'); ?>
			<div class="form_row">
				<label>Order</label>
				<select name="order" id="order">
					<option value="">&nbsp;</option>
					<option value="1" <?php echo ($fields['order'] == 1) ? 'selected="selected"' : ''; ?>>At the beginning</option>
					<?php if (count($solutions) != 0) : ?>
					<optgroup label="After ...">
						<?php foreach ($orders as $row) : ?>
						<option value="<?php echo ($row->order + 1); ?>" <?php echo ($fields['order'] == ($row->order + 1)) ? 'selected="selected"' : ''; echo ($row->id == $solution->id) ? ' disabled="disabled"' : ''; ?>><?php echo HTML::chars($row->title, TRUE); ?></option>
						<?php endforeach; ?>
					</optgroup>
					<?php endif; ?>
				</select>
			</div>
		<?php endif; ?>
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
			<div class="form_field"><?php echo ($solution->added != 0) ? date(Lib::config('site.date_format'), $solution->added) : '-'; ?></div>
		</div>
		<div class="form_row">
			<label>Last Modified</label>
			<div class="form_field"><?php echo ($solution->modified != 0) ? date(Lib::config('site.date_format'), $solution->modified) : '-'; ?></div>
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