<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php 
echo Form::open(URL::site(ADMIN.$class_name.'/filechange/'.$news_files->id), array(
															'enctype' => 'multipart/form-data', 
															'method' => 'post', 
															'class' => 'general autovalid form_details',
															'id' => 'filechange'
														));

?>
	<h2><?php echo $module_menu;?></h2>
	
	<div class="form_wrapper">

		<div class="div_row"></div>
        <div class="form_row">
            <?php echo Form::label('name','Name'); ?>
			<?php echo Form::input('name',$fields['name'],array('id'=>'name', 'class'=>'required')); ?>
			<?php echo sprintf($errors['name'], 'Name'); ?>
        </div>
        <div class="form_row">
			<?php echo Form::label('description','Description'); ?>
			<?php echo Form::textarea('description',$fields['description'],array('id'=>'description', 'class'=>'required ckeditor')); ?>
			<?php echo sprintf($errors['description'], 'Description'); ?>
        </div>        
        <?php echo sprintf($errors['status'], 'Status'); ?>
        <div class="form_row">
            <label>Status</label>
            <select name="status" id="status" class="required">
                <option value="">&nbsp;</option>
                <?php foreach ($statuses as $row) : ?>
                <option value="<?php echo $row; ?>" <?php echo ($fields['status'] == $row) ? 'selected="selected"' : ''; ?>><?php echo HTML::chars(ucfirst($row), TRUE); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    
        <div class="form_row">
            <label>Created</label>
            <div class="form_field"><?php echo ($news_files->added != 0) ? date(Lib::config('admin.date_format'), $news_files->added) : '-'; ?></div>
        </div>
        <div class="form_row">
            <label>Last Modified</label>
            <div class="form_field"><?php echo ($news_files->modified != 0) ? date(Lib::config('admin.date_format'), $news_files->modified) : '-'; ?></div>
        </div>
		<div class="form_row">	
		<img width="400" style="float: left" src="<?php echo URL::site($upload_url .'files/'. $news_files->file_name);?>" alt="<?php echo $fields['name'];?>"/>
		</div>
	</div>
	<div id="loader"></div><div id="result_callback"></div></div>
	<div class="form_row">
		<?php echo Form::submit(NULL, 'Save', array('class' => 'btn btn-primary span2')); ?>
	</div>
<?php echo Form::close();?>
