<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Themes_DefaultRESTFul extends Controller_Template {
	
	public $auto_render = TRUE;
	public $template = 'themes/defaultapi';
	public $is_mobile = '';
	public $member;
	public $data;
	
	/**
		* Initialize properties before running the controller methods (actions),
		* so they are available to our action.
	**/
	
	public function before() {
		
		/** Load Session Class **/
		$this->session		= Session::instance();
			
		/** Set language default **/
		I18n::$lang = '';		
		
		// Check the available language in data or set default is system language	
		// This is supposed to be mark with url or cookie based language system
		if(I18n::$lang != Cookie::get('language')){
			// Default site language 
			I18n::$lang = Cookie::get('language');		
		} else {
			// Set language default again if not TRUE
			I18n::$lang = !empty(Model_Language::instance()->site_default()->prefix) 
							? Model_Language::instance()->site_default()->prefix
								: 'en';
		}
		
		// Checking ajax requests
		if ($this->request->is_ajax()) {
			$this->auto_render = FALSE;
			$this->response->headers(
				array(
					'Content-Type' => 'application/json; charset=utf-8',
					'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT',
					'Access-Control-Max-Age'=> '3628800',
					'Access-Control-Allow-Methods'=>' GET, POST, PUT, DELETE',
					'Pragma' => 'no-cache',
					'Cache-Control' => 'no-cache'
				)
			);
			$this->template    = 'ajaxdefault';
		}
		// If this is a normal http request
		else {
			$this->auto_render = FALSE;			
			$this->response->headers(
				array(
					'Content-Type' => 'application/json; charset=utf-8',
					'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT',
					'Access-Control-Max-Age'=> '3628800',
					'Access-Control-Allow-Methods'=>' GET, POST, PUT, DELETE',
					'Pragma' => 'no-cache',
					'Cache-Control' => 'no-cache'
				)
			);
			$this->template    = 'ajaxdefault';
			// Run anything that need ot run before this after checking ajax requested
			parent::before();

		}
	}
	/**
		* Fill in default values for our properties before rendering the output.
	**/
	public function after() {
		if ($this->request->is_ajax()) {
			$this->template->render();
			exit;
		} else {
		if($this->auto_render) :
			// Blank page
		endif;
		}
		
		// Run anything that needs to run after this.
		parent::after();
	}
}
