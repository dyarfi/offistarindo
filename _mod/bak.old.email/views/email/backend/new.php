<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Author       : Anggi Ridho Agustian
 * Code Name    : Agustian
 * Copywrigth   : 2012
 * Module       : Email
 * Package      : View
**/ 

$arr_status = i18n::get('status_value');
$var_lang = i18n::get('system_language');

?>
<script>
    $(document).ready(function(){
       $("#short_description").counter({
            type: 'char',
            goal: 240,
            count: 'down'   
        });  
    });
</script>

<h2><?= Helper_Common::label(i18n::get('content_new'),'Email');?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
    

<form id="create-event" action="<?= Kohana::$base_url;?>admin-cp/email/save" enctype="multipart/form-data" class="general autovalid" method="post">

    <span>Name</span>
    <div class="ls3"></div>
    <input type="text" name="name" class="required"/>
    
    <div class="ls6"></div>
    <span>Section</span>
    <div class="ls3"></div>
    <select name="section">
        <option value="career">Career</option>
            <option value="contact">Contact</option>
            <option value="sales">Sales</option>
            <option value="marketing">Marketing</option>
            <option value="operation">Operation</option>
            <option value="support">Support</option>
    </select>
    
    <div class="ls6"></div>
    <span>Email</span>
    <div class="ls3"></div>
    <input type="text" name="email" class="required"/>
    
    <div class="ls6"></div>
    <span>CC</span>
    <div class="ls3"></div>
    <input type="text" name="cc"/>
    
    <div class="ls6"></div>
    <span><?= i18n::get('status');?></span>
    <div class="ls3"></div>
    <select name="status">
        <option value="1"><?= $arr_status[1];?></option> 
        <option value="0"><?= $arr_status[0];?></option>
    </select>
    
    <div class="ls12"></div>
    <input type="image" src="<?= IMG.'admin/save_button.png';?>"/>
</form>

<div class="ls10"></div>
<div class="bar"></div>