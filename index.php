<?php
/**
 * The directory in which your application specific resources are located.
 * The application directory must contain the bootstrap.php file.
 *
 * @see  http://kohanaframework.org/guide/about.install#application
 */
$application = '_app';
/**
 * The directory in which your modules are located.
 *
 * @see  http://kohanaframework.org/guide/about.install#modules
 */
$modules = '_mod';
/**
 * The directory in which the Kohana resources are located. The system
 * directory must contain the classes/kohana.php file.
 *
 * @see  http://kohanaframework.org/guide/about.install#system
 */
$system = '_sys';
/**
 * The default extension of resource files. If you change this, all resources
 * must be renamed to use the new extension.
 *
 * @see  http://kohanaframework.org/guide/about.install#ext
 */
define('EXT', '.php');
/**
 * Set the PHP error reporting level. If you set this in php.ini, you remove this.
 * @see  http://php.net/error_reporting
 *
 * When developing your application, it is highly recommended to enable notices
 * and strict warnings. Enable them by using: E_ALL | E_STRICT
 *
 * In a production environment, it is safe to ignore notices and strict warnings.
 * Disable them by using: E_ALL ^ E_NOTICE
 *
 * When using a legacy application with PHP >= 5.3, it is recommended to disable
 * deprecated notices. Disable with: E_ALL & ~E_DEPRECATED
 */
//error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
error_reporting(E_ALL | E_STRICT);
/**
 * End of standard configuration! Changing any of the code below should only be
 * attempted by those with a working knowledge of Kohana internals.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 */
// Set the full path to the docroot
define('DS', DIRECTORY_SEPARATOR); // Do not change this into anything!!!
define('DOCROOT', realpath(dirname(__FILE__)).DS);
// Make the application relative to the docroot, for symlink'd index.php
if ( ! is_dir($application) AND is_dir(DOCROOT.$application))
	$application = DOCROOT.$application;
// Make the modules relative to the docroot, for symlink'd index.php
if ( ! is_dir($modules) AND is_dir(DOCROOT.$modules))
	$modules = DOCROOT.$modules;
// Make the system relative to the docroot, for symlink'd index.php
if ( ! is_dir($system) AND is_dir(DOCROOT.$system))
	$system = DOCROOT.$system;
// Define the absolute paths for configured directories
//define('IN_PRODUCTION', TRUE);
define('APPPATH', realpath($application).DS);
define('MODPATH', realpath($modules).DS);
define('SYSPATH', realpath($system).DS);
/**
 * Define your default Company Name, Site name as your modules directory. Change this if you changed the site.
 */
define('APPMOD','_modules'); // Modules directory
// Default Developer Name
define('DEVELOPER_NAME','WEBARQ');
// Default Url Developer Name
define('DEVELOPER_URL','http://www.webarq.com/');
// Default Company Name
define('COMPANY_NAME','www.offistarindo.com'); 
// Default Site Name
define('SITE_NAME',($_SERVER['SERVER_NAME'] != 'localhost') ? $_SERVER['SERVER_NAME'] : COMPANY_NAME); // 
/**** Production Settings *****/
/*
define('DB_HOST','localhost');
define('DB_NAME','offistar_offistarindo2014');
define('DB_USER','offistar_usr2014');
define('DB_PASS','Superse7en1234');					
*/
define('DB_HOST','localhost');
define('DB_NAME','wa_offistarindo2014');
define('DB_USER','root');
define('DB_PASS','');

define('BS_PAGE',''); // Determine whether use index.php/ or not.
define('BS_URL','http://'.$_SERVER['SERVER_NAME'].'/offistarindo/');
define('BS_ADDR',BS_URL.BS_PAGE);
define('ADMIN','admin-cp/'); // Default Administration URL
define('ASSETS',BS_URL.'assets/');
define('IMG',ASSETS.'images/');
define('CSS',ASSETS.'css/');
define('JS',ASSETS.'js/');
define('THM','themes/');
define('FV','frontend/');
define('CP','backend/');
define('LT','layout/');
define('SYSCHMOD',"0755");
// Clean up the configuration vars
unset($application, $modules, $system);
if (file_exists('install'.EXT))
{
	// Load the installation check
	return include 'install'.EXT;
}
/**
 * Define the start time of the application, used for profiling.
 */
if ( ! defined('KOHANA_START_TIME'))
{
	define('KOHANA_START_TIME', microtime(TRUE));
}
/**
 * Define the memory usage at the start of the application, used for profiling.
 */
if ( ! defined('KOHANA_START_MEMORY'))
{
	define('KOHANA_START_MEMORY', memory_get_usage());
}
// Bootstrap the application
require APPPATH.'bootstrap'.EXT;
/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
echo Request::factory()
	->execute()
	->send_headers()
	->body();
