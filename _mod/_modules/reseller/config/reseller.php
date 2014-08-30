<?php defined('SYSPATH') OR die('No direct access allowed.');

$config['models']			= array('Reseller',
									'ResellerContent',
									'ResellerFile');

$config['upload_max_size']	= '2M';
$config['upload_path']		= DOCROOT.'uploads/reseller/';
$config['upload_url']		= 'uploads/reseller/';

$config['resellerfile_upload_max_size']	= '2M';
$config['resellerfile_upload_path']		= DOCROOT.'uploads/reseller_files/';
$config['resellerfile_upload_url']		= 'uploads/reseller_files/';

$config['readable_mime']	= array('image/gif',
									'image/jpg',
									'image/jpeg',
									'image/png',
									'video/x-flv',
									'video/flv',
									'audio/mpeg');

$config['mime_icon']		= array('image/gif'		=> 'picture.png',
									'image/jpg'		=> 'picture.png',
									'image/jpeg'	=> 'picture.png',
									'image/png'		=> 'picture.png',
									'video/x-flv'	=> 'film.png',
									'video/flv'		=> 'film.png',
									'audio/mpeg'	=> 'sound.png');

$config['image'] = array(
    'ratio' => 'auto',
    'thumbnails' => array(
		'186x126',
		'839x459'
    ),
	'crop'	=> array(
			array('186x126','839x359'),
				'center'
			)
);

$config['reseller_fields']		= array('show_owner'	=> FALSE,
										'show_order'	=> TRUE,
										'show_description' => TRUE,
										'show_category' => TRUE,
										'show_upload'	=> TRUE,
											'uploads' => array(
												'image_1' => array(
													'label' => 'Image',
													'caption' => FALSE,
													'description' => FALSE,
													'optional' => FALSE,
													'file_type' => 'gif,jpg,png',
													'max_file_size' => '1M',
													'note' => 'Allowed file types are gif, jpg ,png. Best Resolution is '.$config['image']['thumbnails'][1].'px',
													'image_manipulation' => $config['image'],
												)
											)
										);

$config['module_menu']		= array(
									'reseller/index'			=> 'Principal Listings',
									);

$config['module_function']	= array(
									'reseller/add'			=> 'Add New Principal',
									'reseller/view'			=> 'View Principal Details',
									'reseller/edit'			=> 'Edit Principal Details',
									'reseller/delete'		=> 'Delete Principal',
									'reseller/change'		=> 'Update Principal Status'
									);
									
return array_merge_recursive (
	$config
);									
