<?php defined('SYSPATH') OR die('No direct access allowed.'); ?><script type="text/javascript">$(document).ready(function () {	$('#language_select').change(function() {	<?php	$prefix = array();	foreach($language_data as $row):		$img		= IMG.'languages/'.$row->file_name;		$prefix[$row->id] = $row->prefix;		?>		if($(this).val() == <?php echo $row->id; ?> && $(this).val() != 0) {			$("<?php echo '#lang_' . $row->prefix; ?>").fadeIn();			$(".flag_holder").html('<img src="<?php echo $img;?>" alt="<?php echo $row->name; ?>"/>');			} else {			$("<?php echo '#lang_' . $row->prefix; ?>").fadeOut();		}		<?php	endforeach;	?>	}).eq(0).change();});</script><h2><?php echo $module_menu; ?></h2><div class="ls10"></div><div class="bar"></div><div class="ls10"></div><?php echo Form::open(ADMIN.$class_name.'/add', array(													'enctype' => 'multipart/form-data', 													'method' => 'post', 													'class' => 'general autovalid form_details',													'id' => ''													));?>	<div class="">		<fieldset>					<legend>Category Title</legend>			<div class="ls5 clear1"></div>									<div class="form_row">				<?php echo Form::label('title','Title &nbsp; : <span class="gray">AlphaNumeric - [a-z/-/0-9]</span>'); ?>				<?php echo Form::input('title', $fields['title'],array('id'=>'title', 'class'=>'title required','rel'=>$class_name)); ?>				  <?php echo sprintf($errors['title'], 'Title'); ?>				<span class="red"></span>			</div>						<?php echo sprintf($errors['parent_id'], 'Parent'); ?>			<div class="form_row">				<label>Parent</label>				<select name="parent_id" id="parent_id" class="required">					<option value="" class="">&nbsp;</option>					<option value="0" class="">This <?php echo str_replace('_', ' ', $class_name); ?> is parent</option>					<?php foreach ($categories as $row) : ?>					<option value="<?php echo ($row->status == 'publish') ? $row->id : 0;?>" <?php echo ($row->status != 'publish') ? 'disabled="disabled"' : '';?> class="parent_<?php echo $row->parent_id; ?>" <?php echo ($fields['parent_id'] == $row->id) ? 'selected="selected"' : '';?>>						<?php echo str_repeat('&nbsp;', ($row->sub_level + 1) * 5).HTML::chars(ucfirst(@$row->subject), TRUE); ?>						<?php echo !empty($row->title) ? ' ('.@$row->title.')' : '';?>					</option>					<?php endforeach; ?>				</select>			</div>			<div class="ls5 clear"></div>			</fieldset>				<div style="margin:10px;">			<label>Change Language</label>			<div class="ls5 clear1"></div>			<select name="language_select" id="language_select" class="required">				<?php 				foreach($language_data as $flag):					$img		= IMG.'languages/'.$flag->file_name;					?>					<option value="<?php echo $flag->id;?>" <?php echo ($flag->id == 1) ? 'selected="selected"' : ''; ?>><?php echo $flag->name; ?></option>				<?php 				endforeach; 				?>			</select>			<div class="flag_holder"></div>			<span class="lang_field_err red" style="display:none">Please check other language data before submitting</span>		</div>				<fieldset class="lang_content">				<legend>Category Content</legend>		<div class="ls5 clear1"></div>		<?php 		$i=0;		foreach($language_data as $language):			$img		= IMG.'languages/'.$language->file_name;			if (!empty($language->id)):			?>			<div id="lang_<?php echo $prefix[$language->id]; ?>">				<div class="form_row">					<div class="lang_desc_row"><a class="right_float" href="javascript:void(0);" title="<?php echo  $language->name; ?>">&nbsp;<img src="<?php echo $img; ?>" alt="<?php echo $language->name;?>"/>&nbsp;<?php echo $language->name; ?></a></div>					<label>Subject</label>					<div class="ls2"></div>					<input type="text" name="detail[<?php echo $language->id;?>][subject]" id="subject_<?php echo $language->id; ?>" class="required" value="" />					<input type="hidden" name="detail[<?php echo $language->id;?>][lang_id]" id="language_id_<?php echo $language->id; ?>" value="<?php echo $language->id; ?>" />									</div>								<?php //echo sprintf($errors['text'], 'Text'); ?>				<div class="form_row">					<label>Text</label>					<textarea name="detail[<?php echo $language->id;?>][text]" id="text_<?php echo $language->id; ?>" class="required ckeditor"></textarea>				</div>				</div>			<?php			endif;			$i++;		endforeach;		?>			</fieldset>		<?php 		if (isset($show_category_upload) && $show_category_upload) : ?>        <?php foreach ($uploads as $row_name => $row_params) : ?>            <fieldset style="clear:both;">                <legend><strong><?php echo $row_params['label']; ?></strong></legend>				<?php echo sprintf($errors[$row_name], $row_params['label']); ?>                <div class="form_row">                    <label><?php echo $row_params['label']; ?></label>                    <input type="file" name="<?php echo $row_name; ?>" id="<?php echo $row_name; ?>" />                    <?php if (isset($row_params['note']) && $row_params['note'] != '') : ?>                        <div class="form_row">                            <label>&nbsp;</label>                            <?php echo HTML::chars($row_params['note'], TRUE); ?>                        </div>                    <?php endif; ?>                </div>                <?php if (isset($row_params['caption']) && $row_params['caption']) : ?>                <div class="form_row">                    <label>Caption</label>                    <input type="text" name="<?php echo $row_name.'_caption'; ?>" id="<?php echo $row_name.'_caption'; ?>" value="<?php //echo $fields[$row_name.'_caption']; ?>" />                </div>                <?php endif; ?>    	</fieldset>        <?php endforeach; ?>        <?php endif; ?>        <?php if (isset($show_position) && $show_position) : ?>        <?php echo sprintf($errors['position'], 'Position'); ?>        <div class="form_row">            <label>Position</label>            <select name="position" id="position" class="required">                <option value="0">&nbsp;</option>                <?php foreach ($position as $row => $value) : ?>                <option value="<?php echo $row; ?>" <?php echo ($fields['position'] == $row) ? 'selected="selected"' : ''; ?>><?php echo HTML::chars(ucfirst($value), TRUE); ?></option>                <?php endforeach; ?>            </select>        </div>    	<?php endif; ?>		<?php if (isset($show_order) && $show_order) : ?>		<?php echo sprintf($errors['order'], 'Order'); ?>		<div class="form_row">			<label>Order</label>			<input type="text" style="width:18px;" name="order" id="order" value="<?php echo $fields['order'];?>"/>						</div>		<?php endif; ?>        <?php echo sprintf($errors['status'], 'Status'); ?>        <div class="form_row">            <label>Status</label>            <select name="status" id="status" class="required">                <option value="">&nbsp;</option>                <?php foreach ($statuses as $row) : ?>                <option value="<?php echo $row; ?>" <?php echo ($fields['status'] == $row) ? 'selected="selected"' : ''; ?>><?php echo HTML::chars(ucfirst($row), TRUE); ?></option>                <?php endforeach; ?>            </select>        </div>        <div class="form_row">            <label>&nbsp;</label>            <input type="checkbox" name="add_another" id="add_another" value="TRUE" /> <label for="add_another" class="sub_label">Add another <?php echo ucwords(str_replace('_', ' ', $class_name)); ?></label>        </div>	</div>	<div class="form_row">		<label>&nbsp;</label>		<?php echo Form::submit(NULL, '', array('class' => 'btn_add')); ?>	</div><?php echo Form::close();?>