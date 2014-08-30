<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo $module_menu;?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
<?php echo Form::open(ADMIN.'user/edit/'.$user->id, array(
																'enctype' => 'multipart/form-data', 
																'method' => 'post', 
																'class' => 'general autovalid form_details',
																'id' => 'edit-users'
																));	
	?>
	<?php echo Form::hidden('id',$user->id,array('id'=>'id')); ?>
	<div class="ls10"></div>
	<fieldset>		
		<legend>User Information</legend>
		<div class="ls5"></div>
		<?php echo Form::label('name','Full Name'); ?>
		<div class="ls5"></div>
		<?php echo Form::input('name',!empty($user->name) ? $user->name : $fields['name'],array('id'=>'name', 'class'=>'required')); ?>
		<?php echo !empty($errors['name']) ? ucfirst($errors['name']) : ''; ?>		
		<div class="ls5"></div>
		<?php echo Form::label('email','Email'); ?>
		<div class="ls5"></div>
		<?php echo Form::input('email',!empty($user->email) ? $user->email : $fields['email'],array('id'=>'email', 'class'=>'required')); ?>
		<?php echo !empty($errors['email']) ? ucfirst($errors['email']) : ''; ?>			
		<div class="ls5"></div>
		<?php echo Form::label('password','New Password'); ?>
		<div class="ls5"></div>
		<?php echo Form::password('password',!empty($fields['password']) ? $fields['password'] : '',array('id'=>'password', 'class'=>'')); ?>
		<?php echo !empty($errors['password']) ? ucfirst($errors['password']) : ''; ?>			
		<div class="ls5"></div>
		<?php echo Form::label('password2','Confirm Password'); ?>
		<div class="ls5"></div>
		<?php echo Form::password('confirm_password',!empty($fields['confirm_password']) ? $fields['confirm_password'] : '',array('id'=>'confirm_password', 'class'=>'')); ?>
		<?php echo !empty($errors['confirm_password']) ? ucfirst($errors['confirm_password']) : ''; ?>			
		<div class="ls5"></div>
		<?php echo Form::label('user_level','User Level'); ?>
		<div class="ls5"></div>
		<?php 
			$arr_levels = $levels;
			echo Form::select('level_id', $arr_levels, empty($fields['level_id']) ? $user->level_id : $fields['level_id']); 
		?>
		<div class="ls5"></div>  		
		<?php echo i18n::get('status');?>
		<div class="ls2"></div>
		<?php 
			foreach ($statuses as $status) {
				$arr_status[$status] = ucfirst($status);
			}			
			echo Form::select('status', $arr_status, empty($fields['status']) ? $user->status : $fields['status']); 
		?>
		<div class="ls10"></div>  
	</fieldset>
<fieldset>
			<legend>User Profile Information</legend>
			<!--div class="form_row">
				<label>Photo</label>
				<div class="form_field">
					<?php
					if (is_file(Lib::config('member.upload_path').@$profile->file_name)) :
						$file_data	= pathinfo(Lib::config('member.upload_path').@$profile->file_name);
						$file_name	= url::base().Lib::config('member.upload_url').$file_data['filename'].'_crop_'.Lib::config('member.image.crop.0.0').'.'.$file_data['extension'];
					else :
						$file_name	= url::base().'images/profile-no-image.png';
					endif;
					?>
					<img src="<?php echo $file_name; ?>" alt="Photo" />
				</div>
			</div-->
			<?php if (@$profile->file_name != '') : ?>
			<?php //echo sprintf($errors['photo'], 'Uploaded Photo'); ?>
			<!--div class="form_row">
				<label>Delete Photo</label>
				<input type="checkbox" name="delete_photo" id="delete_photo" value="1" />
			</div-->
			<?php endif; ?>
			<?php //echo sprintf($errors['photo'], 'Uploaded Photo'); ?>
			<!--div class="form_row">
				<label>Upload Photo</label>
				<input type="file" name="photo" id="photo" />
			</div-->
			<?php echo sprintf($errors['gender'], 'Gender'); ?>
			<div class="form_row">
				<?php echo Form::label('gender','Gender'); ?>
				<?php echo Form::select('gender', $genders, empty($fields['gender']) ? $fields['gender'] : $fields['gender']); ?>
			</div>
			<?php echo sprintf($errors['about'], 'About'); ?>
			<div class="form_row">
				<?php echo Form::label('about','About'); ?>
				<?php echo Form::textarea('about', $fields['about'], array('class'=>'','id'=>'about'),TRUE);?>	
			</div>
			<?php echo sprintf($errors['country'], 'Country'); ?>
			<div class="form_row">
				<?php echo Form::label('country','Country'); ?>
				<?php echo Form::input('country', $fields['country'], array('class'=>'','id'=>'country'));?>	
			</div>
			<?php echo sprintf($errors['state'], 'State'); ?>
			<div class="form_row">
				<?php echo Form::label('state','State'); ?>					
				<?php echo Form::input('state', $fields['state'], array('class'=>'','id'=>'state'));?>				
			</div>
			<?php echo sprintf($errors['city'], 'City'); ?>
			<div class="form_row">
				<?php echo Form::label('city','City'); ?>	
				<?php echo Form::input('city', $fields['city'], array('class'=>'','id'=>'city'));?>						
			</div>
			<?php echo sprintf($errors['address'], 'Address'); ?>
			<div class="form_row">
				<?php echo Form::label('address','Address'); ?>
				<?php echo Form::input('address', $fields['address'], array('class'=>'','id'=>'address'));?>
			</div>
			<?php echo sprintf($errors['postal_code'], 'Postal Code'); ?>
			<div class="form_row">
				<?php echo Form::label('postal_code','Postal Code'); ?>
				<?php echo Form::input('postal_code', $fields['postal_code'], array('class'=>'','id'=>'postal_code'));?>
			</div>
			<?php echo sprintf($errors['birthday'], 'Birthday'); ?>
			<div class="form_row">
				<?php echo Form::label('birthday','Birthday'); ?>
				<?php echo Form::input('birthday', $fields['birthday'], array('class'=>'required simpledate','id'=>'birthday'));?>				
			</div>
			<?php echo sprintf($errors['phone'], 'Phone'); ?>
			<div class="form_row">
				<?php echo Form::label('phone','Phone'); ?>	
				<?php echo Form::input('phone', $fields['phone'], array('class'=>'required','id'=>'phone'));?>						
			</div>
			<?php echo sprintf($errors['fax'], 'Fax'); ?>
			<div class="form_row">
				<?php echo Form::label('fax','Fax'); ?>	
				<?php echo Form::input('fax', $fields['fax'], array('class'=>'','id'=>'fax'));?>
			</div>
			<?php echo sprintf($errors['website'], 'Website'); ?>
			<div class="form_row">
				<?php echo Form::label('website','Website'); ?>						
				<?php echo Form::input('website', $fields['website'], array('class'=>'','id'=>'website'));?>
			</div>
			<div class="ls15"></div>
		</fieldset>
	<div class="ls9 clearfix" style="clear:both"></div>
	<div class="ls10"></div>
	<div class="bar"></div>
	<div class="ls10"></div>
   <?php echo Form::image(NULL, NULL, array('src' => IMG.'admin/save_button.png')); ?>
<?php echo Form::close();?>
