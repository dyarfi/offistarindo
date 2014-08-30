<?php defined('SYSPATH') or die('No direct script access.');?>
<script>
    $(document).ready(function(){
       $("#value,#alias").counter({
            type: 'char',
            goal: 512,
            count: 'down'            
        });  
    });
</script>
<h2><?php echo $module_menu;?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
		<?php 
			echo Form::open(ADMIN.$module_name.'/add', array(
																	'enctype' => 'multipart/form-data', 
																	'method' => 'post', 
																	'class' => 'general autovalid',
																	'id' => 'create-setting'
																	));
		?>
        <div class="ls6"></div>
        <span><label for="alias">Alias</label></span>
        <div class="ls3"></div>
		<?php echo Form::input('alias', !empty($fields['alias']) ? $fields['alias'] : '', array('class'=>'required', 'id' => 'alias')); ?>
		<?php echo !empty($errors['alias']) ? ucfirst($errors['alias']) : ''; ?>
        <div class="ls6"></div>
        <span><label for="parameter">Parameter</label></span>
        <div class="ls3"></div>
		<?php echo Form::input('parameter', !empty($fields['parameter']) ? $fields['parameter'] : '', array('class'=>'required', 'id' => 'parameter')); ?>
		<?php echo !empty($errors['parameter']) ? ucfirst($errors['parameter']) : ''; ?>
		<div class="ls6"></div>
        <span><label for="value">Value</label></span>
        <div class="ls3"></div>
		<?php echo Form::textarea('value', !empty($fields['value']) ? $fields['value'] : '', array('class'=>'required ckeditorsmall', 'id' => 'value')); ?>
        <?php echo !empty($errors['value']) ? ucfirst($errors['value']) : ''; ?>
		<div class="ls6"></div>
        <span><label for="is_system">System</label></span>
        <div class="ls3"></div>
		<?php 			 
		$is_system = $fields['is_system'];
		$modes = Lib::config('setting.is_system');
		foreach ($modes as $mode => $value) {
			echo Form::radio('is_system',$mode,($is_system == $mode) ? TRUE : FALSE,array('class'=>"is_system_mode"));
			echo '&nbsp;&nbsp;';
			echo $value;
			echo '&nbsp;&nbsp;';
		}
		?>
        <div class="ls6"></div>
        <!--span><label for="status"><?php echo i18n::get('status');?></label></span>
        <div class="ls3"></div>
		<?php 
			$arr_status = i18n::get('status_value');
			echo Form::select('status', $arr_status, !empty($fields['status']) ? $fields['status'] : 1); 
		?>
		<?php echo !empty($errors['status']) ? ucfirst($errors['status']) : ''; ?>
        <div class="clear ls20"></div-->		
		<input type="hidden" name="status" value="publish"/>
		<div class="bar"></div>
		<div class="ls10"></div>	
		<div class="ls10"></div>  
       <?php echo Form::image(NULL, NULL, array('src' => IMG.'admin/add_button.png')); ?>
    <?php echo Form::close();?>
<?php //endif; ?>
