<?php defined('SYSPATH') or die('No direct script access.');?>
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
<h2><?php //echo $module_menu; ?>Translation for : <?php echo @$object->subject;?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>

	<div class="ls6"></div>
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
	<span class="lang_field_err red" style="display:none">
		Please check other language data before submitting
	</span>	
	<?php 		
		
		// Translate form for table fields in module config.php
		echo Form::open(Request::$current->uri(), array(
															'enctype' => 'multipart/form-data', 
															'method' => 'post', 
															'class' => 'general autovalid',
															'id' => 'create-language'
														));
			echo Form::hidden('table_id',$table_id);
			echo Form::hidden('field_id',$field_id);
			echo '<fieldset class="lang_content">';																
			echo '<legend>Content</legend><div class="ls5 clear1"></div>';
			
			foreach($language_data as $language) {
				$img = IMG.'languages/'.$language->file_name;

					//echo Form::hidden('detail['.$language->id.'][language_id]',$language->id);
					
					echo '<div id="lang_'.$prefix[$language->id].'">';
					
							$k=0;	
							foreach ($table_fields as $fields => $field) {									
								
									//if (!empty($detail_data[$language->id][$k])) {
									
										// Debugging Mode
										// print_r($detail_data[$language->id][$k]['content']);
									
									//} 
									echo Form::hidden('detail['.$language->id.']['.$k.'][language_id]',$language->id);
									echo Form::hidden('detail['.$language->id.']['.$k.'][id]',
											isset($detail_data[$language->id][$k]['id'])
												? $detail_data[$language->id][$k]['id'] 
													: '');

									$fields_form = '';
									$class		 = '';

									if (isset($field['type'])) {
										$map = array(
											'string'  => 'input',
											'text'    => 'textarea'
										);
										if (isset($map[$field['type']])) {						
											$_field['type'] = $map[$field['type']];
										}
										if($_field['type']=='textarea'){
											$class = 'ckeditor';
										}
										$fields_form = array_merge($field,$_field);
									}
									echo '<div class="form_row">';
									echo Form::label($fields);
									echo '<div class="ls2"></div>';
									echo Form::$fields_form['type']('detail['.$language->id.']['.$k.']['.$fields.']', 
											isset($detail_data[$language->id][$k]['content'])
												? $detail_data[$language->id][$k]['content'] 
													: '',
											array(
												'size'=>$fields_form['length'],'class'=>$class,
												'id'=>$fields.'_'.$language->id)
											);
									echo '</div>';

							$k++;
							} 								
					echo '</div>';	
			}
			echo '</fieldset>';
	?>	
	<div class="ls10"></div>	
	<div class="ls10"></div>  
	<?php echo Form::submit(NULL, '', array('class' => 'btn_save btn-primary span2')); ?>
<?php echo Form::close();?>

