<?php defined('SYSPATH') or die('No direct script access.');

/** Frontend Configs **/
$config['css'] = array(
		'style.css'	=> 'all',	
		'reset.min.css' => 'all',
		'helper.min.css' => 'all',					
		'jquery.alerts.css' => 'all',
		'colorbox.css' => 'all',
		//'bootstrap/css/carousel.css' => 'all',
		'bootstrap/css/bootstrap.min.css' => 'all',
		);
$config['js'] = array(
				'library.js',
				'jquery.alerts.js',
				'bootstrap/bootstrap-tooltip.js',
				'bootstrap/bootstrap.min.js',				
				'jquery.colorbox.js',
				'jquery-1.8.2.min.js'
				);	

 return array_merge_recursive  (
	$config
 );
