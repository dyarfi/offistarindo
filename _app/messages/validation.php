<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'alpha'         => ':field must contain only letters',
	'alpha_dash'    => ':field must contain only numbers, letters and dashes',
	'alpha_numeric' => ':field must contain only letters and numbers',
	'color'         => ':field must be a color',
	'credit_card'   => ':field must be a credit card number',
	'date'          => ':field must be a date',
	'decimal'       => ':field must be a decimal with :param2 places',
	'digit'         => ':field must be a digit',
	'email'         => ':field must be a email address',
	'email_domain'  => ':field must contain a valid email domain',
	'equals'        => ':field must equal :param2',
	'exact_length'  => ':field '. __('exact_length'),
	'in_array'      => ':field must be one of the available options',
	'ip'            => ':field must be an ip address',
	//'matches'       => ':field must be the same as :param2',
	'matches'       => ':field must be the same as :param3',
	'min_length'    => ':field '. __('min_length'),
	'max_length'    => ':field '. __('max_length'),
	'not_empty'     => ':field '. __('not_empty'),
	'numeric'       => ':field must be numeric',
	'phone'         => ':field must be a phone number',
	'password2'		=> array(
						'matches'	=> ':field '.__('matches'),
						'not_empty'	=> ':field '. __('not_empty'),	
						),
	'range'         => ':field must be within the range of :param2 to :param3',
	'regex'         => ':field '.__('regex'),
	'url'           => ':field must be a url',
	'url'           => array(
						'Valid::url'=> ':field '.__('valid_url')
						),	
	'website'		=> array(
						'Valid::url'=> ':field '.__('valid_url')
						),	
	'corporatewebsite'	=> array(
						'Valid::url'=> ':field '.__('valid_url')
						),
	'corporateemail' => array(
						'email_exists'=> ':field '. __('already_exists'),
						'Valid::email'=> ':field '.__('not_valid'),
						'not_empty'	  => ':field '. __('not_empty'),
						),
	'corporatemobile' => array(
						'not_empty' => ':field '. __('not_empty'),	
						),	
	'corporatephone' => array(
						'not_empty' => ':field '. __('not_empty'),	
						),	
	'corporatefax' => array(
						'not_empty' => ':field '. __('not_empty'),	
						),	
	'corporatename' => array(
						'not_empty' => ':field '. __('not_empty'),	
						),
	'corporatemessage' => array(
						'not_empty' => ':field '. __('not_empty'),	
						),
	'title'          => array(
						'unique_title' => ':field '. __('already_exists'),
						'title_exists' => ':field '. __('already_exists'),
						),	
	'order'			=>  array(
						'unique_order' => ':field '. __('already_exists'),
						'order_exists' => ':field '. __('already_exists'),						
						), 		
	'name'          => array(
						'unique_name' => ':field '. __('already_exists'),
						'name_exists' => ':field '. __('already_exists'),
						'Valid::url'  => ":field is must a valid url",
						),
	'email'			=> array(
						'email_exists'=> ':field '. __('already_exists'),
						'Valid::email'=> ':field '. __('not_valid')
						),	
	'captcha'		=> array(
						'Captcha::valid' => ':field '.__('not_valid'),
						),	
	'file_1'	=> array(
						'Upload::not_empty' => ':field not allowed to be empty',
						'Upload::size' => ':field size is not allowed',
						'Upload::type' => ':field is not valid',
						'unique_filename' => ':field name is not available to upload or delete the original file',
						),
	'file_2'	=> array(
						'Upload::not_empty' => ':field not allowed to be empty',
						'Upload::size' => ':field size is not allowed',
						'Upload::type' => ':field is not valid',
						'unique_filename' => ':field name is not available to upload or delete the original file',
						),		
	'image_1'	=> array(
						'Upload::not_empty' => ':field not allowed to be empty',
						'Upload::size' => ':field size is not allowed',
						'Upload::type' => ':field is not valid',
						'unique_filename' => ':field name is not available to upload or delete the original file',
						),

	'image_2'	=> array(
						'Upload::not_empty' => ':field not allowed to be empty',
						'Upload::size' => ':field size is not allowed',
						'Upload::type' => ':field is not valid',
						'unique_filename' => ':field name is not available to upload or delete the original file',
						),
);
