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
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
<?php echo Form::open(ADMIN . $class_name.'/add', array(
																'enctype' => 'multipart/form-data', 
																'method' => 'post', 
																'class' => 'general autovalid form_details',
																'id' => ''
																));
?>
		
		<fieldset>		
			<legend>Testimonial Title</legend>
			<div class="ls5 clear1"></div>						
			<div class="form_row">
				<?php echo Form::label('title','Title &nbsp; : <span class="gray">AlphaNumeric - [a-z/-/0-9]</span>'); ?>
				<?php echo Form::input('title', $fields['title'],array('id'=>'title', 'class'=>'title required','rel'=>$class_name)); ?>				  <?php echo sprintf($errors['title'], 'Title'); ?>
				<span class="red"></span>
			</div>			
			<?php echo sprintf($errors['person'], 'Person'); ?>
			<div class="form_row">
				<label>Person</label>
				<input type="text" name="person" id="person" class="required" value="<?php echo $fields['person']; ?>" />
			</div>
					
		<?php if (isset($show_media) && $show_media) : ?>
		<?php echo sprintf($errors['media'], 'Media'); ?>
		<div class="form_row topBotDiv5 media_upload">
			<div class="hidden_input"><strong>Media</strong> :
				<span><?php echo htmlspecialchars($fields['media']); ?></span>
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
					<input type="text" class="input_media" name="_media" id="fileName" readonly="" value="" />
					<a href="<?php echo Lib::config('admin')->filemanager_path.'&amp;type=3&amp;fldr=/videos/';?>" class="btn iframe-btn">Select</a>
				</div>
			</div>	
		</div>
		<br/><br/>
		<?php endif; ?>


			<?php echo sprintf($errors['show_cover'], 'Show Cover in Home'); ?>
			<div class="form_row">
				<label>Show Cover in Home</label>
				<input type="checkbox" name="show_cover" value="1" id="show_cover" <?php echo ($fields['show_cover']) ? 'checked' :''; ?> class="" />&nbsp;&nbsp;Show
			</div>
			<div class="ls5 clear"></div>	
						
		</fieldset>
		
		<div style="margin:10px;">
			<label>Change Language</label>
			<div class="ls5 clear1"></div>
			<select name="language_select" id="language_select" class="required">
				<?php 
				foreach($language_data as $flag):
					$img		= IMG.'languages/'.$flag->file_name;
					?>
					<option value="<?php echo $flag->id;?>" <?php echo ($flag->id == 1) ? 'selected="selected"' : ''; ?>><?php echo $flag->name; ?></option>
				<?php 
				endforeach; 
				?>
			</select>
			<div class="flag_holder"></div>
			<span class="lang_field_err red" style="display:none">Please check other language data before submitting</span>
		</div>
		
		<fieldset class="lang_content">		
		<legend>Testimonial Content</legend>
		<div class="ls5 clear1"></div>
		<?php 
		$i=0;
		foreach($language_data as $language):
			$img		= IMG.'languages/'.$language->file_name;
			if (!empty($language->id)):
			?>
			<div id="lang_<?php echo $prefix[$language->id]; ?>">
				<div class="form_row">
					<div class="lang_desc_row"><a class="right_float" href="javascript:void(0);" title="<?php echo  $language->name; ?>">&nbsp;<img src="<?php echo $img; ?>" alt="<?php echo $language->name;?>"/>&nbsp;<?php echo $language->name; ?></a></div>
					<label>Subject</label>
					<div class="ls2"></div>
					<input type="text" name="detail[<?php echo $language->id;?>][subject]" id="subject_<?php echo $language->id; ?>" class="required" value="" />
					<input type="hidden" name="detail[<?php echo $language->id;?>][lang_id]" id="language_id_<?php echo $language->id; ?>" value="<?php echo $language->id; ?>" />					
				</div>				
				<?php //echo sprintf($errors['text'], 'Text'); ?>
				<div class="form_row">
					<label>Text</label>
					<textarea name="detail[<?php echo $language->id;?>][text]" id="text_<?php echo $language->id; ?>" class="required ckeditor"></textarea>
				</div>	
			</div>
			<?php
			endif;
			$i++;
		endforeach;
		?>	
		</fieldset>

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
			</select>
		</div>
		<?php endif; ?>
		
		<?php 
		if (isset($show_upload) && $show_upload) : ?>
        <?php foreach ($uploads as $row_name => $row_params) : ?>
            <fieldset style="clear:both;">
                <legend><strong><?php echo $row_params['label']; ?></strong></legend>
				<?php echo sprintf($errors[$row_name], $row_params['label']); ?>
                <div class="form_row">
                    <label><?php echo $row_params['label']; ?></label>
                    <input type="file" name="<?php echo $row_name; ?>" id="<?php echo $row_name; ?>" />
                    <?php if (isset($row_params['note']) && $row_params['note'] != '') : ?>
                        <div class="form_row">
                            <label>&nbsp;</label>
                            <?php echo HTMl::chars($row_params['note'], TRUE); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (isset($row_params['caption']) && $row_params['caption']) : ?>
                <div class="form_row">
                    <label>Caption</label>
                    <input type="text" name="<?php echo $row_name.'_caption'; ?>" id="<?php echo $row_name.'_caption'; ?>" value="<?php echo $fields[$row_name.'_caption']; ?>" />
                </div>
                <?php endif; ?>
				<?php if (isset($row_params['description']) && $row_params['description']) : ?>
                <div class="form_row">
                    <label>Description</label>
                    <input type="text" name="<?php echo $row_name.'_description'; ?>" id="<?php echo $row_name.'_description'; ?>" value="<?php echo $fields[$row_name.'_description']; ?>" />
                </div>
                <?php endif; ?>
    	</fieldset>
        <?php endforeach; ?>
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
			<label>&nbsp;</label>
			<input type="checkbox" name="add_another" id="add_another" value="TRUE" /> <label for="add_another" class="sub_label">Add another <?php echo ucwords($module_menu); ?></label>
		</div>

		<div class="ls12 clear"></div>
		<div class="bar"></div>
        <div class="ls12"></div>
		<?php echo Form::submit(NULL, '', array('class' => 'btn_add')); ?>
<?php echo Form::close(); ?>
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