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
<?php echo Form::open(ADMIN.$class_name.'/add', array(
																'enctype' => 'multipart/form-data', 
																'method' => 'post', 
																'class' => 'general autovalid form_details',
																'id' => ''
																));
?>	
	<div class="form_wrapper">
		
		<fieldset>		
			<legend>File Title</legend>
			<div class="ls5 clear1"></div>						
			<div class="form_row">
				<?php echo Form::label('title','Title &nbsp; : <span class="gray">AlphaNumeric - [a-z/-/0-9]</span>'); ?>
				<?php echo Form::input('title', $fields['title'],array('id'=>'title', 'class'=>'title required','rel'=>$class_name)); ?>				  <?php echo sprintf($errors['title'], 'Title'); ?>
				<span class="red"></span>
			</div>			
			<?php echo sprintf($errors['type_id'], 'Download'); ?>
			<div class="form_row">
				<label>Download</label>
				<select name="type_id" id="type_id" class="required">
					<option value="" <?php echo ($fields['type_id'] == 0) ? 'selected="selected"' : ''; ?>>--- Type ---</option>
					<?php foreach ($downloads as $row) : ?>
					<option value="<?php echo $row->id; ?>" class="type_<?php echo $row->id; ?>" <?php echo ($fields['type_id'] == $row->id) ? 'selected="selected"' : ''; ?>>
					<?php 
						echo Text::limit_words(HTML::chars($row->subject, TRUE),8);
					?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php echo sprintf($errors['category_id'], 'Category'); ?>
			<div class="form_row">
				<label>Category</label>
				<select name="category_id" id="category_pid" class="required" data-url="<?php echo URL::site(ADMIN.$class_name.'/productlookup');?>">
					<option value="" <?php echo ($fields['category_id'] == 0) ? 'selected="selected"' : ''; ?>>--- Category ---</option>
					<?php foreach ($categories as $category) : ?>
					<option value="<?php echo $category->id; ?>" class="category_<?php echo $category->id; ?>" <?php echo ($fields['category_id'] == $category->id) ? 'selected="selected"' : ''; ?>>
					<?php 
						echo Text::limit_words(HTML::chars($category->subject, TRUE),8);
					?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php echo sprintf($errors['product_id'], 'Product'); ?>
			<div class="form_row">
				<label>Product</label>
				<select name="product_id" id="product_id" class="required">
					<option value="" <?php echo ($fields['product_id'] == 0) ? 'selected="selected"' : ''; ?>>--- Product ---</option>
					<?php foreach ($products as $product) : ?>
					<!--option value="<?php echo $product->id; ?>" class="category_<?php echo $product->id; ?>" <?php echo ($fields['product_id'] == $product->id) ? 'selected="selected"' : ''; ?>>
					<?php 
						echo Text::limit_words(HTML::chars($product->subject, TRUE),8);
					?>
					</option-->
					<?php endforeach; ?>
				</select>
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
		<legend>File Content</legend>
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
		
        <?php 
		//print_r($uploads);
		foreach ($uploads as $row_name => $row_params) :?>
            <fieldset style="clear:both;">
                <legend><strong><?php echo @$row_params['label']; ?></strong></legend>
				<?php echo sprintf($errors[$row_name], @$row_params['label']); ?>
                <div class="form_row">
                    <label><?php echo @$row_params['label']; ?></label>
                    <input type="file" class="required" name="<?php echo $row_name; ?>" id="<?php echo $row_name; ?>" />
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
    	</fieldset>
        <?php endforeach; ?>
        
		<?php if (isset($show_allow_comment) && $show_allow_comment) : ?>
		<?php echo sprintf($errors['allow_comment'], 'Allow Comment'); ?>
		<div class="form_row">
			<label for="allow_comment">Allow User to Comment?</label>
			<input type="checkbox" name="allow_comment" id="allow_comment" value="1" <?php echo ($fields['allow_comment'] == 1) ? 'checked="checked"' : ''; ?> /> <label for="allow_comment" class="sub_label">Yes, user can comment this content</label>
		</div>
		<?php endif; ?>
		<div class="form_row">
			<label>File</label>			
			<div class="input-append">
			<input type="text" value="<?php echo $fields['file_name'];?>" readonly id="fileName" name="file_name" class="required">
			<a type="button" class="btn iframe-btn" href="<?php echo Lib::config('admin')->filemanager_path.'&amp;type=2';?>">Select</a>
			</div>
		</div>
		<div class="form_row">
			<label>Status</label>
			<select name="status" id="status" class="required">
				<option value="">&nbsp;</option>
				<?php foreach ($statuses as $row) : ?>
				<option value="<?php echo $row; ?>" <?php echo ($fields['status'] == $row) ? 'selected="selected"' : ''; ?>><?php echo HTML::chars(ucfirst($row), TRUE); ?></option>
				<?php endforeach; ?>
			</select>
			<?php echo sprintf($errors['status'], 'Status'); ?>
		</div>
		<div class="form_row">
			<label>&nbsp;</label>
			<input type="checkbox" name="add_another" id="add_another" value="TRUE" /> <label for="add_another" class="sub_label">Add another <?php echo ucwords(str_replace('_', ' ', $class_name)); ?></label>
		</div>
		</div>
		<div class="form_row">
			<input type="submit" value="" class="btn_add" />
		</div>
<?php echo Form::close();?>
<?php if (isset($show_upload) && $show_upload) { ?>
<script type="text/javascript">
$(document).ready(function() {
	<?php 
	$i = 1;
	foreach ($uploads as $pref => $val) { 
		?>
		$('#<?php echo $pref;?>').on('change',function(){
			var ext<?php echo $i;?> = $(this).val().split('.').pop().toLowerCase();
			if($.inArray(ext<?php echo $i;?>, <?=json_encode((array)explode(',', @$val['file_type']));?>) === -1) {
				jAlert('Invalid file type (<?=@$val['file_type'];?>)', 'Error');
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