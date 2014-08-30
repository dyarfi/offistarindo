<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
<?php
if ($status == 'UPDATED'):
	usleep(1000000);
	?>
	self.setInterval(parent.location.reload(),2000);
	parent.$.fn.colorbox.close();
	<?php
endif;
?>
</script>
<div id="main-blank-content" class="form_table_slide">
	<?php echo Form::open(URL::site('member/profile?ref=profile'), array('id'=>'register_member'));?>
		<h3><?php echo __('update_profile'); ?><span class="loader"></span><span id="result_regs"></span></h3>
		<div id="RegisterErrors" style="display:block"></div>
		<table width="100%">	
			<tr>
				<td width="20%"><label for="name"><?php echo __('fullname'); ?></label></td>
				<td width="80%">
				<?php echo Form::input('name', $fields['name'], array('id'=>"name",'class'=>"input_form required inpLogin",'maxlength'=>"32")); ?>							
				<?php echo sprintf($errors['name'], 'Fullname'); ?>
				</td>
			</tr>
			<tr>
				<td><label for="email"><?php echo __('email'); ?></label></td>
				<td>
				<?php echo Form::input('email', $fields['email'], array('id'=>"email",'class'=>"input_form required inpLogin",'maxlength'=>"32")); ?>							
				<?php echo sprintf($errors['email'], 'Email'); ?>
				</td>
			</tr>
			<tr>
				<td><label for="phone"><?php echo __('phone'); ?></label></td>
				<td>
				<?php echo Form::input('phone', $fields['phone'], array('id'=>"phone",'class'=>"input_form required inpLogin",'maxlength'=>"32")); ?>							
				<?php echo sprintf($errors['phone'], 'Phone'); ?>
				</td>
			</tr>
			<tr>
				<td><label for="address"><?php echo __('address'); ?></label></td>
				<td>
				<?php echo Form::textarea('address', $fields['address'], array('id'=>"address",'class'=>"input_form required inpLogin",'cols'=>"17",'rows'=>"1")); ?>				
				<?php echo sprintf($errors['address'], 'Address'); ?>
				</td>
			</tr>
			<!--tr>
				<td><label for="country"><?php //echo __('country'); ?></label></td>
				<td>
				<?php //echo Form::input('country', $fields['country'], array('id'=>"country",'class'=>"input_form required inpLogin",'maxlength'=>"32")); ?>
				<?php //echo sprintf($errors['country'], 'Country'); ?>
				</td>
			</tr>	
			<tr>
				<td><label for="church"><?php //echo __('church'); ?></label></td>
				<td>
				<?php //echo Form::input('church',$fields['church'],array('class'=>'input_form required inpLogin','maxlength'=>'32'));?>
				<?php //echo sprintf($errors['church'], 'Church'); ?>
				</td>
			</tr>				
			<tr>
				<td><label for="birthday"><?php //echo __('birthday'); ?></label></td>
				<td>
				<?php //echo Form::input('birthday', $fields['birthday'], array('id'=>"birthday",'class'=>"input_form required inpLogin",'maxlength'=>"32")); ?>
				<?php //echo sprintf($errors['birthday'], 'Birthday'); ?>
				</td>
			</tr>
			<tr>
				<td><label for="about"><?php //echo __('about'); ?></label></td>
				<td>
				<?php //echo Form::input('about', $fields['about'], array('id'=>"about",'class'=>"input_form required inpLogin",'maxlength'=>"32")); ?>
				<?php //echo sprintf($errors['about'], 'About'); ?>
				</td>
			</tr-->	
			<tr>
				<td><label for="reload_captcha"><?php echo __('captcha_code'); ?></label></td>
				<td colspan="2">				
<?php echo Form::input('captcha', $fields['captcha'], array('id'=>"captcha",'class'=>"input_form captcha required inpLogin",'maxlength'=>"32")); ?>
				<?php //echo __('captcha_reload'); ?>
				<a href="<?php echo URL::site('member/captcha_reload'); ?>" id="reload_captcha" class="reload_captcha inpLogin" title="<?php echo __('captcha_reload'); ?>"><?php echo $captcha->render(); ?></a>
				<?php echo sprintf($errors['captcha'], 'Captcha'); ?>
				</td>
			</tr>									
			<tr>
				<td colspan="2" align="left">
					<div class="button_register">
						<input type="submit" class="btn btn-success" value="<?php echo __('submit'); ?>" />
						<input type="reset" class="btn btn-success" value="<?php echo __('cancel'); ?>" />
					</div>
				</td>
			</tr>
		</table>
	<?php echo Form::close(); ?>
</div><!-- end register_form -->