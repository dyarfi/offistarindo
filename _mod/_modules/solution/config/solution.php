<?php defined('SYSPATH') OR die('No direct access allowed.');
$config['models']			= array('Solution','SolutionContent',
									'SolutionFile',
									'SolutionCategory','SolutionCategoryContent',
									'SolutionCategoryFile');
$config['upload_max_size']	= '2M';
$config['upload_path']		= DOCROOT.'uploads/solutions/';
$config['upload_url']		= 'uploads/solutions/';
$config['solutionfile_upload_max_size']	= '2M';
$config['solutionfile_upload_path']		= DOCROOT.'uploads/solution_files/';
$config['solutionfile_upload_url']		= 'uploads/solution_files/';
$config['category_upload_max_size']		= '2M';
$config['category_upload_path']			= DOCROOT.'uploads/solutioncategory_files/';
$config['category_upload_url']			= 'uploads/solutioncategory_files/';
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
		'169x151',
        '640x384'// New Size
    ),
	'crop'	=> array(
			array(
				'169x151',
				'640x384'),
				'center'
			)
);
$config['solutionfile_fields']	= array('show_album'				=> TRUE,
										'show_allow_comment'		=> FALSE,
										'show_tags'					=> FALSE,
										'show_title'				=> TRUE,
										'show_description'			=> TRUE,
										'show_upload' 				=> TRUE,
										'show_order'				=> TRUE,
										'show_filename' 			=> TRUE,
										'uploads'					=> array('image_1' => array(
																				'label' => 'Image',
																				'caption' => TRUE,
																				'optional' => TRUE,
																				'file_type' => 'gif,jpg,png',
																				'max_file_size' => '1M',
																				'note' => 'Allowed file types are gif, jpg ,png. Best Resolution is up to '.$config['image']['thumbnails'][1].'px',
																				'image_manipulation' => $config['image']
																			)
																		)	
																	);
$config['solution_fields']		= array('show_owner'	=> FALSE,
										'show_order'	=> FALSE,
										'show_description' => TRUE,
										'show_category' => TRUE,
										'show_upload'	=> TRUE,
											'uploads' => array(
												'image_1' => array(
													'label' => 'Image',
													'caption' => FALSE,
													'optional' => TRUE,
													'file_type' => 'gif,jpg,png',
													'max_file_size' => '1M',
													'note' => 'Allowed file types are gif, jpg ,png. Best Resolution is up to '.$config['image']['thumbnails'][1].'px',
													'image_manipulation' => $config['image'],
												),
											)
										);
$config['category_fields'] = array(
    'show_position' => FALSE,
	'show_order' => FALSE,	
	'show_description' => TRUE,
	'show_enable_edit' => FALSE,
	'show_enable_delete' => TRUE,
	'show_enable_add' => TRUE,
    'show_category_upload' => FALSE,
    'uploads' => array(
        'image_1' => array(
            'label' => 'Image',
            'caption' => FALSE,
            'optional' => TRUE,
            'file_type' => 'gif,jpg,png',
            'max_file_size' => '1M',
            'note' => 'Allowed file types are gif, jpg ,png. Best Resolution is '.$config['image']['thumbnails'][1].'px',
            'image_manipulation' => $config['image'],
        ),
    )
);
/**
 * Check gallery uploads field just have one field
 * and remove the other field if uploads field more than one
 ***/
//if (count($config['gallery_file_fields']['uploads']) > 1) {
	//$keys	= array_keys($config['gallery_file_fields']['uploads']);
	//$config['gallery_file_fields']['uploads']	= array($keys[0]	=> $config['gallery_file_fields']['uploads'][$keys[0]]);
//}
// Module name initialize
$config['module_name']		= 'solution';
$config['module_menu']		= array(
									'solutioncategory/index'	=> 'Solution Package Category Listings',
									'solution/index'			=> 'Solution Package Listings',
									/*'solutionfile/index'		=> 'File Listings',*/
									);
$config['module_function']	= array(/*
									'solutionfile/add'			=> 'Add New File',
									'solutionfile/view'			=> 'View File Details',
									'solutionfile/edit'			=> 'Edit File Details',
									'solutionfile/delete'		=> 'Delete File',
									'solutionfile/change'		=> 'Update File Status',
									*/
									'solution/add'			=> 'Add New Solution',
									'solution/view'			=> 'View Solution Details',
									'solution/edit'			=> 'Edit Solution Detauls',
									'solution/delete'		=> 'Delete Solution',
									'solution/change'		=> 'Update Solution Status',
									'solutioncategory/add'			=> 'Add New Solution Category',
									'solutioncategory/view'			=> 'View Solution Category',
									'solutioncategory/edit'			=> 'Edit Solution Category',
									'solutioncategory/delete'		=> 'Delete Solution Category',
									'solutioncategory/change'		=> 'Update Category Status',
									);
return array_merge_recursive (
	$config
);									
