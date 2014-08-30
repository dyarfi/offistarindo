<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Asia/Jakarta');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */

Kohana::init(array(
    'base_url'   => BS_URL,
    'index_file' => '',
	/* @see .htaccess for $_SERVER['KOHANA_ENV'] */
    //'errors' => FALSE,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
 
Kohana::modules(array(
	//'auth'				=> MODPATH . 'auth',		// Basic authentication
	
	'database'			=> MODPATH . 'database',		// Database access
	'email'				=> MODPATH . 'email',			// Email System

	//'orm'				=> MODPATH . 'orm',			// Object Relationship Mapping
	//'cache'				=> MODPATH . 'cache',			// Caching with multiple backends
	//'codebench'			=> MODPATH . 'codebench',		// Benchmarking tool
	//'unittest'			=> MODPATH . 'unittest',		// Unit testing
	//'userguide'			=> MODPATH . 'userguide',		// User guide and API documentation
	//'phpexcel'			=> MODPATH . 'phpexcel',		// Php for Excel 
	//'profilertoolbar'		=> MODPATH . 'profilertoolbar', 	// Profiler toolbar
	
	'error'			=> MODPATH . 'error',			// Error handling files @see .htaccess for $_SERVER['KOHANA_ENV']
	'image'			=> MODPATH . 'image',			// Image manipulation 
	'pagination'	=> MODPATH . 'pagination',		// Paging of results
	'security'		=> MODPATH . 'security',		// For web security using HTML Purifier      
	'captcha'		=> MODPATH . 'captcha',			// For Captcha in form
	
	//'compress'		=> MODPATH . 'compress',			// Assets Compress Module for Css and Javascript
	
	// ========== [start] == Modules App bootstraping WebArq ======= 
	'user'			=> MODPATH . APPMOD . DS . 'user',		// User Administrator, Levels, Dashboard account
	'member'		=> MODPATH . APPMOD . DS . 'member',	// Member
	'page'          => MODPATH . APPMOD . DS . 'page',		// News
	'solution'		=> MODPATH . APPMOD . DS . 'solution',	// Solution	
	'download'		=> MODPATH . APPMOD . DS . 'download',  // Download
	'product'		=> MODPATH . APPMOD . DS . 'product',	// Product
	'banner'		=> MODPATH . APPMOD . DS . 'banner',	// Banner	
	'news'			=> MODPATH . APPMOD . DS . 'news',		// News	    
	'reseller'		=> MODPATH . APPMOD . DS . 'reseller',	// Reseller and Partners
	'testimonial'	=> MODPATH . APPMOD . DS . 'testimonial',// Testimonial	
	'language'		=> MODPATH . APPMOD . DS . 'language',	// Language Setting
	'setting'		=> MODPATH . APPMOD . DS . 'setting',	// WebApp Setting
	'site'			=> MODPATH . APPMOD . DS . 'site'
    // ========== [end] == Modules App bootstraping WebArq ======= 
));

// Set Cookies salt
Cookie::$salt = 'Your-Salt-Goes-Here'.date('m-y-d');

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
/*** ADMIN-CP ***/

// Replace slash with space see @index.php in root for setting
$admin = str_replace('/', '', ADMIN);

Route::set($admin, $admin . '(/<controller>(/<action>(/<id1>(/<id2>(/<id3>(/<id4>(/<id5>)))))))',
		array(
			//'directory'  => 'backend',
			//'controller' => 'Baseadmin',
			//'action'     => 'index',
			'id1' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			'id2' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			'id3' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			'id4' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',		
			'id5' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			))
	->defaults(array(      
		'directory'  => 'backend',
        'controller' => 'baseadmin',
        'action'     => 'index',
	));

/*** ADMIN-CP ***/

/*** MAINTENANCE MODE ***/

Route::set('maintenance', 'maintenance(/<controller>(/<action>(/<id1>(/<id2>(/<id3>(/<id4>))))))',
		array(
			'id1' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			'id2' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			'id3' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			'id4' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			))
	->defaults(array(
        'directory'  => 'backend',
        'controller' => 'maintenance',
        'action'     => 'index',
	));
	
// =============== API Classes Directory Route === start
Route::set('api', 'api(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))',
    array(
		//'directory'		=> 'api',
		//'action'		=> 'index',		
		'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
    ))
    ->defaults(array(
	  'directory'  => 'api',		
      'controller' => 'api',
      'action'     => 'index'
    ));
// =============== API Classes Directory Route === end

/*** SEARCH ***/
Route::set('search', 'search/<id1>',
		array(
			'controller' => 'search', 
			'action' => 'index', 
			'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			)
		)
	->defaults(array(
		'controller' => 'search',
		'action'     => 'index',
		'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
	));
/*** SOLUTION ***/
Route::set('solution-package', 'solution-package(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))',
		array(
				'controller' => 'solution', 
				'action'     => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			)
		)
	->defaults(array(
		'controller' => 'solution',
		'action'     => 'index',
		'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
	));

/*** DOWNLOAD ***/
Route::set('download', 'download(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))',
		array(
				'controller' => 'download', 
				'action'     => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
				'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			)
		)
	->defaults(array(
		'controller' => 'download',
		'action'     => 'index',
		'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
	));

/*** CONTACT ***/
Route::set('contact-us|contact', 'contact-us(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))',
		array(
				'controller' => 'contact', 
				'action'     => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
				'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			)
		)
	->defaults(array(
		'controller' => 'contact',
		'action'     => 'index',
		'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
	));
Route::set('xhr_contact', 'xhr_contact(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))',
		array(
				'controller' => 'contact', 
				'action'     => 'xhr_contact',
				'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			)
		)
	->defaults(array(
		'controller' => 'contact',
		'action'     => 'xhr_contact',
		'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
	));
// Controller 
Route::set('xhr', 'xhr(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))',
		array(
			'controller' => 'xhr',
			'action' => '[a-zA-Z0-9\-\_\@\&\.]++',
			'id1' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
			'id2' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
			'id3' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
			'id4' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
			))
	->defaults(array(
        'controller' => 'xhr',
		'action' => '[a-zA-Z0-9\-\_\@\&\.]++',
		'id1' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
		'id2' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
		'id3' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
		'id4' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',			
	));
/*** COMPANY ***/
Route::set('company', 'company(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))',
		array(
				'controller' => 'company', 
				'action'     => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.]++',
				'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			)
		)
	->defaults(array(
		'controller' => 'company',
		'action'     => 'index',
		'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
	));

/*** COMPANY > NEWS ***/
Route::set('newsevent', 'newsevent(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))',
		array(
				'controller' => 'company', 
				'action'     => 'newsevent',
				'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
				'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			)
		)
	->defaults(array(
		'controller' => 'company',
		'action'     => 'newsevent',
		'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id2'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id3'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
		'id4'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
	));

/*** COMPANY > RESELLER & PARTNER ***/
Route::set('reseller', 'reseller(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))',
		array(
				'controller' => 'company', 
				'action'     => 'reseller',
				'id1'	=> '[a-zA-Z0-9\-\_\.]++',
				'id2'	=> '[a-zA-Z0-9\-\_\.]++',
				'id3'	=> '[a-zA-Z0-9\-\_\.]++',
				'id4'	=> '[a-zA-Z0-9\-\_\.]++',
			)
		)
	->defaults(array(
		'controller' => 'company',
		'action'     => 'reseller',
		'id1'	=> '[a-zA-Z0-9\-\_\.]++',
		'id2'	=> '[a-zA-Z0-9\-\_\.]++',
		'id3'	=> '[a-zA-Z0-9\-\_\.]++',
		'id4'	=> '[a-zA-Z0-9\-\_\.]++',
	));

 // Controller Specific for members
Route::set('member/<action>/<id1>', 'member(/<action>(/<id1>))', 
		array(
			'controller' => 'member', 
			'action' => '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			'id1'	=> '[A-Za-z0-9\-\s\:\@\$\+\=\_\.\(\)]++',
			)
		)
	->defaults(array(
		'controller' => 'member', 
		));

// Controller
Route::set('<controller>', '<controller>(/<action>(/<id1>(/<id2>(/<id3>(/<id4>)))))', 
		array(
			'controller' => '[a-zA-Z0-9\-\_\.]++', 
			'action' => 'index',
			'id1'	=> '[a-zA-Z0-9\-\_\.]++',
			'id2'	=> '[a-zA-Z0-9\-\_\.]++',
			'id3'	=> '[a-zA-Z0-9\-\_\.]++',
			'id4'	=> '[a-zA-Z0-9\-\_\.]++',
			)
		)
	->defaults(array(
		'controller' => '[a-zA-Z0-9\-\_\.]++',
		'action' => 'index', 
		'id1'	=> '[a-zA-Z0-9\-\_\.]++',
		'id2'	=> '[a-zA-Z0-9\-\_\.]++',
		'id3'	=> '[a-zA-Z0-9\-\_\.]++',
		'id4'	=> '[a-zA-Z0-9\-\_\.]++',
		));

// Controller Categories
Route::set('<controller>/<id1>', '<controller>/<id1>', 
		array(
			'controller' => '[a-zA-Z0-9\-\_\.]++', 
			'action' => 'category', 
			'id1'	=> '[a-zA-Z0-9\-\_\.]++',
			)
		)
	->defaults(array(
		'controller' => '[a-zA-Z0-9\-\_\.]++', 
		'action' => 'category', 
		'id1'	=> '[a-zA-Z0-9\-\_\.]++',
		));

// Controller detail
Route::set('<controller>/read/<id1>', '<controller>/<action>/<id1>', 
		array(
			'controller' => '[a-zA-Z0-9\-\_\.]++', 
			'action' => 'read', 
			'id1'	=> '[a-zA-Z0-9\-\_\.]++',
			'id2'	=> '[a-zA-Z0-9\-\_\.]++',
			'id3'	=> '[a-zA-Z0-9\-\_\.]++',
			'id4'	=> '[a-zA-Z0-9\-\_\.]++',
			)
		)
	->defaults(array(
		'controller' => '[a-zA-Z0-9\-\_\.]++',
		'action' => 'read', 
		'id1'	=> '[a-zA-Z0-9\-\_\.]++',
		'id2'	=> '[a-zA-Z0-9\-\_\.]++',
		'id3'	=> '[a-zA-Z0-9\-\_\.]++',
		'id4'	=> '[a-zA-Z0-9\-\_\.]++',
		));

// Default
Route::set('default', '(<controller>(/<action>(/<id1>(/<id2>(/<id3>(/<id4>))))))')
	->defaults(array(
		'controller' => 'home',
		'action'     => 'index',
	));
