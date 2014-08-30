<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Xhr extends Controller_Themes_DefaultBlank {

	protected $id1;
	protected $id2;
	protected $id3;
	protected $id4;
	public $template = 'themes/defaultblank';

	public function before () {
		parent::before();

        $this->id1 = Request::$current->param('id1');
        $this->id2 = Request::$current->param('id2');
        $this->id3 = Request::$current->param('id3');
		$this->id4 = Request::$current->param('id4');
				
	}
    
	public function action_index () {
		//usleep(900000);
		
		if ($_POST) {
			if ($_FILES) 
				$post	= Validation::factory(array_merge($_POST,$_FILES));
			else
				$post	= Validation::factory($_POST);
			
			/*
				$post->rule('subject', 'not_empty');
                $post->rule('subject', 'min_length', array(':value', 4));
                $post->rule('name', 'not_empty');
                $post->rule('name', 'min_length', array(':value', 4));
                $post->rule('news_date', 'not_empty');
                $post->rule('text', 'not_empty');
                $post->rule('text', 'min_length', array(':value', 4));
                $post->rule('status', 'not_empty');                
                $post->rule('name', array($this, '_unique_name'), array(':validation', 'name'));
			*/	
				
			if ($post->check()) {
				
				$fields	= $post->as_array();
				
				//print_r($fields);
				//exit;
				
			} else {
				$fields		= Arr::overwrite($fields, $post->as_array());
				$errors 	= Arr::overwrite($errors, $post->errors('validation'));
				$buffers	= $errors;
				foreach ($errors as $row_key => $row_val) {
					if ($row_val != '') {
						$buffers[$row_key]	= Lib::config('admin.error_field_open').ucfirst($row_val).Lib::config('admin.error_field_close');
					} else {
						$buffers[$row_key]	= $row_val;
					}
				}
				$errors		= $buffers;
			}
			
		}	
		//echo $send['message'] = 1;
		print_r($_FILES);
		exit;
		
	}
	
	public function action_language () {
		if ($this->request->is_ajax()) {
			// Set cookies for language
			Cookie::set('language', $this->id1);
			I18n::$lang = $this->id1;
			$redirect = Request::$current->referrer() ? Request::$current->referrer() : URL::site();
			echo $redirect;	
			exit;		
		}
	}
	
	public function action_forgot_password_form() {
		
		$content_vars		= array(''	=> '');

		$content			= View::factory('site/forgot_password_page');

		//$this->template		= 'defaultblank';
		
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		//$this->template->content = $content;
		echo $content;
	}
	
	public function action_register_form() {
		
		$content_vars		= array(''	=> '');

		$content			= View::factory('site/register_page');

		//$this->template		= 'defaultblank';
		
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		//$this->template->content = $content;
		echo $content;
	}
	
	public function action_register() {
		
		$content_vars		= array(''	=> '');

		$content			= View::factory('site/register_page');		
				
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->content = $content;
		//echo $content;
		
	}
	
	
	public function after() {
		parent::after();
		
	}
}
