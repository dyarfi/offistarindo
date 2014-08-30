<?php defined('SYSPATH') or die('No direct script access.'); ?>
<h2><?php echo $module_menu;?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>

<?php if (!isset($listings)) : ?>
    <div class="warning3"><?php echo i18n::get('error_no_data'); ?></div>
<?php else: ?>        
    
    <div class="cd_left">Name</div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?php echo $listings->name; ?></div>
    <div class="clear ls4"></div>
    
    <div class="cd_left"><?php echo i18n::get('Added');?></div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?php echo date("d F Y",$listings->added); ?></div>
    <div class="clear ls4"></div>   

    <div class="cd_left"><?php echo i18n::get('Modified');?></div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?php echo date("d F Y",$listings->modified); ?></div>
    <div class="clear ls4"></div>   
    
    <div class="cd_left"><?php echo i18n::get('status');?></div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?php echo $listings->status; ?></div>
    <div class="clear ls10"></div> 
	
	<div class="cd_left"><?php echo i18n::get('Is System');?></div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?php echo (!$listings->is_system) ? 'No' : 'Yes'; ?></div>
    <div class="clear ls10"></div> 
	
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
	<?php if (empty($is_system) && Session::instance()->get('user_id') == 1): ?>
	<a href="<?php echo URL::site() . ADMIN;?>language/edit/<?php echo $lang_id;?>">
		<img src="<?php echo IMG; ?>admin/edit_button.png"/>
	</a>
	<?php endif; ?>
<?php endif; ?>