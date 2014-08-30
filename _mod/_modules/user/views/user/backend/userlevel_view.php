<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo $module_menu;?></h2>
<form class="form_details" action="<?php echo url::site(ADMIN.$module_name.'/edit/'.$levels->id); ?>" method="get">
	<div class="form_wrapper">
        <div class="form_row">
            <label>Name</label>
            <div class="form_field"><?php echo $levels->name; ?></div>
        </div>
        <div class="form_row">
            <label>Backend Access</label>
            <div class="form_field"><?php echo ($levels->backend_access) ? 'Yes' : 'No'; ?></div>
        </div>
		<?php if(Acl::instance()->user->level_id == 1) { ?>
        <div class="form_row">
            <label>Full Backend Access</label>
            <div class="form_field"><?php echo ($levels->full_backend_access) ? 'Yes' : 'No'; ?></div>
        </div>
		<?php } ?>
        <div class="form_row">
            <label>Status</label>
            <div class="form_field"><?php echo ucwords($levels->status); ?></div>
        </div>
        <div class="form_row">
            <label>Created</label>
            <div class="form_field"><?php echo ($levels->added != 0) ? date(Lib::config('admin.date_format'), $levels->added) : '-'; ?></div>
        </div>
        <div class="form_row">
            <label>Last Modified</label>
            <div class="form_field"><?php echo ($levels->modified != 0) ? date(Lib::config('admin.date_format'), $levels->modified) : '-'; ?></div>
        </div>
    </div>
	<div class="form_row">
		<label>&nbsp;</label>
		<!--input type="button" class="btn_back" value="" onclick="location.href='<?php echo url::site(ADMIN.$module_name.'/index'); ?>'" /><div class="button_space">&nbsp;</div-->
		<input type="submit" class="btn_edit" value="" />
	</div>
</form>
