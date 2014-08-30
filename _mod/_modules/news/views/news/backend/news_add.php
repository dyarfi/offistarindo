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
<?php echo Form::open(ADMIN.$class_name.'/add', array(
																'enctype' => 'multipart/form-data', 
																'method' => 'post', 
																'class' => 'general autovalid form_details',
																'id' => ''
																));
?>
	<div class="form_details">
        
        <fieldset>		
			<legend>News Title</legend>
			<div class="ls5 clear1"></div>						
			<div class="form_row">
				<?php echo Form::label('title','Title &nbsp; : <span class="gray">AlphaNumeric - [a-z/-/0-9]</span>'); ?>
				<?php echo Form::input('title', $fields['title'],array('id'=>'title', 'class'=>'title required','rel'=>$class_name)); ?>				  <?php echo sprintf($errors['title'], 'Title'); ?>
				<span class="red"></span>
			</div>			
			<div class="form_row">
				<?php echo Form::label('news_date','Date &nbsp; : <span class="gray">'.i18n::get('date_format').'</span>'); ?>
				<?php echo Form::input('news_date',$fields['news_date'],array('id'=>'news_date', 'class'=>'required simpledate')); ?>
				<?php echo sprintf($errors['news_date'], 'News Date'); ?>
			</div>			
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
		<legend>News Content</legend>
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
				<?php //echo sprintf($errors['synopsis'], 'Short Text'); ?>
				<div class="form_row">
					<label>Synopsis</label>
					<div class="ls2 clear1"></div>
					<textarea style="vertical-align: middle; height:100px" name="detail[<?php echo $language->id;?>][synopsis]" id="synopsis<?php echo $language->id; ?>" class=""></textarea>
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
		
        <?php if (isset($show_upload) && $show_upload) : ?>
		<?php 
		foreach ($uploads as $row_name => $row_params) : 
			//print_r($row_params['label']); exit();
			?>
            <fieldset style="clear:both;">
                <legend><strong><?php echo $row_params['label']; ?></strong></legend>
				<?php //echo sprintf($errors[$row_name], $row_params['label']); ?>
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
    		</fieldset>
        <?php 
		//$i++;
		endforeach; 
		?>
        <?php endif; ?>
    
        <?php echo sprintf($errors['status'], 'Status'); ?>
        <div class="form_row">
			<?php echo Form::label('status','Status'); ?>
            <select name="status" id="status" class="required">
                <option value="">&nbsp;</option>
                <?php foreach ($statuses as $row) : ?>
                <option value="<?php echo $row; ?>" <?php echo ($fields['status'] == $row) ? 'selected="selected"' : ''; ?>><?php echo HTML::chars(ucfirst($row), TRUE); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
	</div>    
	<div class="ls10 clear"></div>
	<div class="bar"></div>
	<div class="ls10 clear"></div>	
	<div class="form_row">
		<?php echo Form::submit(NULL, '', array('class' => 'btn_add')); ?>
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