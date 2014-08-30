<?php defined('SYSPATH') or die('No direct script access.');?>

<h2><?php echo $module_menu; ?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
<?php 
	echo Form::open(ADMIN.$class_name.'/add/', array(
															'enctype' => 'multipart/form-data', 
															'method' => 'post', 
															'class' => 'general autovalid',
															'id' => 'create-language'
															));
?>

	<div class="ls6"></div>
	<span>Prefix</span>
	<div class="ls3"></div>
	<?php echo Form::input('prefix', $fields['prefix'], array('class'=>'required', 'id' => 'prefix')); ?>

	<div class="ls6"></div>
	<span>Name</span>
	<div class="ls3"></div>
	<?php echo Form::input('name', $fields['name'],  array('class'=>'required', 'id' => 'name')); ?>

	<div class="ls6"></div>
	<span><?php echo i18n::get('status');?></span>
	<div class="ls3"></div>
	<?php 
		foreach ($statuses as $key => $status) { 
			$arr_status[$key] = ucfirst($status); 
		}
		echo Form::select('status', $arr_status, $fields['status']);
	?>

	<div class="clear ls20"></div>
	<div class="bar"></div>

	<div class="ls10"></div>	
	<div class="ls10"></div>  
	
	<?php echo Form::submit(NULL, '', array('class' => 'btn_save btn-primary span2')); ?>
<?php echo Form::close();?>

