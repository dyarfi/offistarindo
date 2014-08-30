<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Author       : Anggi Ridho Agustian
 * Code Name    : Agustian
 * Copywrigth   : 2012
 * Module       : Email
 * Package      : View
**/ 
$arr_status = i18n::get('status_value');
$arr_lang = i18n::get('system_language');
?>
<h2><?= Helper_Common::label(i18n::get('content_detail'),'Email');?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>

<?php if (!isset($var_listing)) : ?>
    <div class="warning3"><?= i18n::get('error_no_data'); ?></div>
<?php else: extract($var_listing[0]); ?>    
    <div class="cd_left">Name</div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?= $name; ?></div>
    <div class="clear ls4"></div>   
    
    <div class="cd_left">Section</div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?= $section; ?></div>
    <div class="clear ls4"></div>      
    
    <div class="cd_left">Email</div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?= $email; ?></div>
    <div class="clear ls4"></div>    
    
    <div class="cd_left">CC</div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?= $cc; ?></div>
    <div class="clear ls4"></div>
    
    <div class="cd_left"><?= i18n::get('status');?></div>
    <div class="cd_center">:</div>
    <div class="cd_right"><?= $arr_status[$status]; ?></div>
    <div class="clear ls10"></div>    
<?php endif; ?>

<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
    
<a href="<?= Kohana::$base_url;?>admin-cp/email/edit/<?= $email_id;?>">
    <img src="<?= IMG; ?>admin/edit_button.png"/>
</a>
