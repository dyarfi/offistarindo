<?php defined('SYSPATH') or die('No direct script access.');

$config['models']				= array('Language','LanguageFile'/*,'Translation','TranslationTable'*/);

$config['upload_path']		= DOCROOT.'uploads/languages/';
$config['upload_url']		= 'uploads/languages/';

$config['readable_mime']	= array('image/gif',
									'image/jpg',
									'image/jpeg',
									'image/png');

$config['mime_icon']		= array('image/gif'		=> 'picture.png',
									'image/jpg'		=> 'picture.png',
									'image/jpeg'	=> 'picture.png',
									'image/png'		=> 'picture.png');

$config['image']			= array('ratio'						=> 'auto',
									'thumbnails'				=> array('230x86',
																		 '16x11'//flag images
																		 )
									);

$config['language_fields']	= array('show_upload'	=> TRUE,
									'uploads'		=>
									array('image'=> 
											array('label'			=> 'Flag Image',
												  'caption'			=> FALSE,
												  'optional'		=> TRUE,
												  'file_type'		=> 'gif,jpg,png',
												  'max_file_size'	=> '2M',
												  'note'			=> 'Allowed file types are gif, jpg ,png. Best Resolution is '.$config['image']['thumbnails'][1].'px',
												  'image_manipulation'	=> $config['image'])
												)
									);

$config['module_menu']			= array(
										'language/index'				=> 'Language Listings',
										//'languagetranslate/index'		=> 'Language Translation Listings'
										);
										
$config['module_function']		= array('language/add'				=> 'Add New Language',
										'language/view'				=> 'View Language Details',
										'language/edit'				=> 'Edit Language Details',
										'language/delete'			=> 'Delete Language Details',
										'languagetranslate/add'		=> 'Add Translation',
										'languagetranslate/view'	=> 'View Translation',
										'languagetranslate/edit'	=> 'Edit Translation',
										'languagetranslate/delete'	=> 'Edit Translation',
										'language/language'			=> 'Language Active List',
										'language/aupdate_all'		=> 'Update Default'										);
										
$config['default']				= array ( 'view'=> 'language/default');

return array_merge_recursive (
	$config
);