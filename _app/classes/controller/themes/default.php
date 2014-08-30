<?php defined('SYSPATH') or die('No direct script access.');class Controller_Themes_Default extends Controller_Template {		public $auto_render = TRUE;	public $template = 'themes/default';	public $is_mobile = '';	public $setting;	public $member ='';	public $data;		/**		* Initialize properties before running the controller methods (actions),		* so they are available to our action.	**/		public function before() {				/** Load Session Class **/		$this->session		= Session::instance('native');						/** Set Initialize Variable **/		$maintenance_mode	= Model_Configuration::instance()->load('maintenance');				/** Load Setting Models **/		$this->setting		= Model_Setting::instance();							/** Get User Id Session **/		$member_id		= ($this->session->get('member_id') != '') ? $this->session->get('member_id') : '';					/** Set User Member Data **/		$this->member	= (!empty($member_id)) ? Lib::to_object(get_object_vars(Model_User::instance()->load($member_id))) : '';					/** Set language default **/		I18n::$lang = '';						// Check if robots is accessing the site 		if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['lang']) && Cookie::get('language') == '') {			// Set cookies for language			Cookie::set('language', $_GET['lang']);			I18n::$lang = Cookie::get('language');			$redirect = ($this->request->url()) ? $this->request->url() : URL::site();			$this->request->redirect($redirect);		} 		// Check the available language in data or set default is system language			// This is supposed to be mark with url or cookie based language system		if (I18n::$lang =='' && Cookie::get('language') == '') {			I18n::$lang = !empty(Model_Language::instance()->site_default()->prefix) 							? Model_Language::instance()->site_default()->prefix								: 'en';		} else if(I18n::$lang !== Cookie::get('language')){			// Default site language 			I18n::$lang = Cookie::get('language');				} else {			// Set language default again if not TRUE			I18n::$lang = 'en';		}				/** SET MAINTENANCE MODE template **/		if (!empty($maintenance_mode->value)) {			/** Set redirect for maintenance **/			Request::$current->redirect(URL::site('maintenance'));		}					/** Checking ajax requests **/		if ($this->request->is_ajax()) {			$this->auto_render	= FALSE;            $this->template		= 'ajaxdefault';		} else {			// Run anything that need ot run before this after checking ajax requested			parent::before();											// Set Site Counter			if (!Session_Cookie::instance()->get('session')) $this->setting->count_visitor();									$this->data['page_title']			= i18n::get('page_title') != 'page_title' ? i18n::get('page_title') : 'Welcome to Kohana';			$this->data['meta_keywords']		= '';			$this->data['meta_description']		= '';			$this->data['meta_copyright']		= i18n::get('meta_copyright') != 'meta_copyright' ? i18n::get('meta_copyright') : 'Kohana Developer Team';											// Get Email Info 			$emailadmin= $this->setting->load_by_parameter('email_info');			$this->data['email_info']	= Lib::_trim_strip(@$emailadmin->value);							// Get Site Counter 			$counter = $this->setting->load_by_parameter('counter');			$this->data['counter']	= Lib::_trim_strip(@$counter->value);							// Site Title Default			$titledefault = $this->setting->load_by_parameter('title_default');			$this->data['title_default']	= Lib::_trim_strip(@$titledefault->value);						// Site Title Name Default			$titlename = $this->setting->load_by_parameter('title_name');			$this->data['title_name']	= Lib::_trim_strip(@$titlename->value);									// Site Quote Default			$sitequote = $this->setting->load_by_parameter('site_quote');			$this->data['site_quote']	= Lib::_trim_strip(@$sitequote->value);						// Set Site Copyright			$copyright = $this->setting->load_by_parameter('copyright');			$this->data['copyright']	= Lib::_trim_strip(@$copyright->value);							// Set Site Registered			$registered = $this->setting->load_by_parameter('registered_mark');			$this->data['registered']	= Lib::_trim_strip(@$registered->value);						// Set Site Analytics						$analytics = $this->setting->load_by_parameter('google_analytics');			$this->data['analytics']	= Lib::_trim_strip(@$analytics->value);									// Get Page Category			$this->data['pageCategory']	= Model_PageCategory::instance()->find_detail(array('status'=>'publish','parent_id'=>0),array('order'=>'ASC'));								$_pageCategoryContent	= Model_PageCategoryContent::instance()->find(array('lang_id'=>Lang::_lang_id(I18n::lang())));					$_buffers = array();			foreach ($_pageCategoryContent as $val) {				$_buffers[$val->category_id] = $val;			}									// Get Page Category Content			$this->data['categoryContent'] = $_buffers;						//--- Member data for home ---//			$this->data['member']		= $this->member;						/** Default Languages that available **/			$this->data['languages']	= Model_Language::instance()->find(array('status'=>1),'',18);						// Set Page Category Child			$_page_category_child			= Model_PageCategory::instance()->find(array('status'=>'publish','parent_id !='=>0),array('id'=>'ASC'));			$buffers_child					= array();			foreach ($_page_category_child as $_category_child) {				$buffers_child[$_category_child->parent_id][] = $_category_child;			}			$page_category_child = $buffers_child;				$this->data['page_category_child']	= $page_category_child;					unset($buffers, $buffers_child);									// Set initialize site counter			$this->setting->counter();												//--- Set data (array) to be sent into view template ---//			// Social media data taken from setting table 			$where_cond   = array('status'=>'publish', 'parameter LIKE' => '%socmed_%');			$social_media =	$this->setting->find($where_cond);			$buffers = array();			foreach ($social_media as $socmed) {				$socmed->value = strip_tags($socmed->value);				$buffers[$socmed->parameter] = $socmed;			}						//--- Menu Social Media In Header home center ---//			$this->data						 = array_merge($this->data,$buffers);					// Define all css and js loads in site/config/site.php			$config = 'site';				// Define defaults css and js load			// Add defaults styles and scripts to template variables.			$this->data['styles']	= array_reverse(Lib::config($config.'.css'));			$this->data['scripts']	= array_reverse(Lib::config($config.'.js'));			//--- Set data (array) to be sent into view template ---//			foreach ($this->data as $var => $val) {				$this->template->$var	= $val;			}						$this->template->css				= array();			$this->template->js					= array();						unset($buffers);		}	}	/* 		* Fill in default values for our properties before rendering the output.	*/	public function after() {		if ($this->request->is_ajax()) {			// $this->template->content = $this->template->render();			//$this->template->render();		} else {			if($this->auto_render) :			endif;		}				// Run to clean sessions, anything that needs to run after this.				// Run anything that needs to run after this.		parent::after();	}}