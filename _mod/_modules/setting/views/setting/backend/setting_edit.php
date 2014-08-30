<?php defined('SYSPATH') or die('No direct script access.');?>
<script>
    $(document).ready(function(){
       $("#alias").counter({
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
<?php if (!isset($setting)) : ?>
    <div class="warning3"><?php echo i18n::get('error_no_data'); ?></div>
<?php else: ?>    
		<?php 
			echo Form::open(ADMIN.$module_name.'/edit/'.$setting->id, array(
																	'enctype' => 'multipart/form-data', 
																	'method' => 'post', 
																	'class' => 'general autovalid',
																	'id' => 'create-news'
																	));
			echo Form::hidden('id',$setting->id);
		?>
        <div class="ls6"></div>
        <span>Alias</span>
        <div class="ls3"></div>
		<?php echo Form::input('alias', !empty($fields['alias']) ? $fields['alias'] : $setting->alias, array('class'=>'required', 'id' => 'alias')); ?>
		<div class="ls6"></div>
        <span>Parameter</span>
        <div class="ls3"></div>
		<?php echo Form::input('parameter', !empty($fields['parameter']) ? $fields['parameter'] : $setting->parameter, array('class'=>'required', 'id' => 'value','readonly'=>'readonly')); ?>
        <div class="ls6"></div>
        <span>Value</span>
        <div class="ls3"></div>
		<?php echo Form::textarea('value', !empty($fields['value']) ? $fields['value'] : $setting->value, array('class'=>'required ckeditorsmall', 'id' => 'value')); ?>
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
        <!--span><?php echo i18n::get('status');?></span>
        <div class="ls3"></div>
		<?php 
			foreach ($statuses as $status) {
				$arr_status[$status] = ucfirst($status);
			}			
			echo Form::select('status', $arr_status, empty($fields['status']) ? $setting->status : $fields['status']); 
		?>
		<div class="clear ls20"></div-->
		<input type="hidden" name="status" value="publish"/>
		<div class="bar"></div>
		<div class="ls10"></div>	
		<div class="ls10"></div>  
       <?php echo Form::image(NULL, NULL, array('src' => IMG.'admin/save_button.png')); ?>
    <?php echo Form::close();?>
<?php endif; ?>
