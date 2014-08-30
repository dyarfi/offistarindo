<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Author       : Daniel Simangunsong
 * Code Name    : Blugol
 * Copywrigth   : 2011
 * Module       : Event
 * Package      : View
**/ 
$arr_status = i18n::get('status_value');
?>
<h2><?= Helper_Common::label(i18n::get('content_edit'),'Email');?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
    
<?php if (!isset($var_listing)) : ?>
    <div class="warning3"><?= i18n::get('error_no_data'); ?></div>
<?php else: extract($var_listing[0]); ?>    
    <script>
        $(document).ready(function(){
           $("#short_description").counter({
                type: 'char',
                goal: 240,
                count: 'down'            
    
            });  
        });
    </script>
    <form id="edit-event" action="<?= Kohana::$base_url;?>admin-cp/email/update/<?= $email_id;?>" enctype="multipart/form-data" class="general autovalid" method="post">
    
        <span>Name</span>
        <div class="ls3"></div>
        <input type="text" name="name" class="required" value="<?= empty($_POST['name']) ? $name : $_POST['name']; ?>"/>
        
        <div class="ls6"></div>
        <span>Section</span>
        <div class="ls3"></div>
        <select name="section">
            <option value="career" <? if($section == 'career') echo 'selected="selected"'; ?>>Career</option>
            <option value="contact" <? if($section == 'contact') echo 'selected="selected"'; ?>>Contact</option>
            <option value="sales" <? if($section == 'sales') echo 'selected="selected"'; ?>>Sales</option>
            <option value="marketing" <? if($section == 'marketing') echo 'selected="selected"'; ?>>Marketing</option>
            <option value="operation" <? if($section == 'operation') echo 'selected="selected"'; ?>>Operation</option>
            <option value="support" <? if($section == 'support') echo 'selected="selected"'; ?>>Support</option>
        </select>
        
        <div class="ls6"></div>
        <span>Email</span>
        <div class="ls3"></div>
        <input type="text" name="email" class="required" value="<?= empty($_POST['email']) ? $email : $_POST['email']; ?>"/>
        
        <div class="ls6"></div>
        <span>CC</span>
        <div class="ls3"></div>
        <input type="text" name="cc" value="<?= empty($_POST['cc']) ? $cc : $_POST['cc']; ?>"/>
        
        <div class="ls6"></div>
        <span><?= i18n::get('status');?></span>
        <div class="ls3"></div>
        <select name="status">
            <?php $selected = empty($_POST['status']) ? $status : $_POST['status']; ?>
            <?php $arr_status = i18n::get('status_value');?> 
            <option value="1" <?= $selected== 1 ? 'selected' : '';?>><?= $arr_status[1];?></option> 
            <option value="0" <?= $selected== 0 ? 'selected' : '';?>><?= $arr_status[0];?></option>
        </select>
        
        <div class="ls12"></div>
        <input type="image" src="<?= IMG.'admin/save_button.png';?>"/>
    </form>
<?php endif; ?>

<div class="ls10"></div>
<div class="bar"></div>