<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Contact extends Controller_Themes_Default {
	protected $page_category;
	protected $category_file;
	public $id1;
	public $id2;
	public $id3;
	public $id4;
	public $setting;

	public function before () {
		parent::before();
		
		$this->id1 = Request::$current->param('id1');
		$this->id2 = Request::$current->param('id2');
		$this->id3 = Request::$current->param('id3');
		$this->id4 = Request::$current->param('id4');
				
		// Load necessary Model
		$this->page_category	= new Model_PageCategory;
		$this->category_files	= new Model_PageCategoryFile;
				
		// Load Config
		$this->_config			= Lib::config('page');
		
		// Page Fields Config
		$this->page_category_fields	= $this->_config->page_category_fields;
		
		// Upload Path Config
		$this->category_upload_path	= $this->_config->category_upload_path;
		
		// Upload Url Config
		$this->category_upload_url	= $this->_config->category_upload_url;
						
	}
    
	public function action_index () {
		
		// Load Page Category By ID = 16 : Contact Us
		$page_category	= ($this->page_category->find_detail(array('id'=>16,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>16,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'contact-us','status'=>'publish'));
		
		// Load Captcha library, you can supply the name of the config group you would like to use.
		$captcha = Captcha::instance();
		
		// Set Contact address with email
		$where_cond		= array('parameter LIKE' => '%email_%','status'=>'publish');
		$email_contact	= $this->setting->find($where_cond);
		
		// Set Phone and fax	
		$where_cond		= array('parameter LIKE' => '%no_support_%','status'=>'publish');
		$no_contact		= $this->setting->find($where_cond);
		
		// Set Sales email	
		$sales_email	= $this->setting->load_by_parameter('email_sales');
		
		// Contact Page Category -name || -category_id = contact | 8
		$page_category	= $this->page_category->find_detail(array('id'=>16,'status'=>'publish'));
		//print_r($page_category);	
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;				
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,			
									'email_contact' => $email_contact,
									'no_contact'	=> $no_contact,	
									'sales_email'	=> $sales_email,
									'captcha'	 => $captcha,
									'address'		=> $this->setting->load_by_parameter('contactus_address')->value);

		$content			= View::factory('site/contact_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		
		$this->template->js				= array('jquery.address-1.5.min.js');
		$this->template->content		= $content; 
	}
				
	public function action_xhr_contact() {
		
		$this->setting	= Model_Setting::instance();
				
		// Load Captcha library, you can supply the name of the config group you would like to use.
		$captcha = Captcha::instance();
		
		// Don't show Captcha anymore after the user has given enough valid
		// responses. The "enough" count is set in the captcha config.
		// Ban bots (that accept session cookies) after 90 invalid responses.
		// Be careful not to ban real people though! Set the threshold high enough.
		
		if ($captcha->invalid_count() > 89)
			exit('Bye! your a bot.');
		
		// Set Contact address with email
		$email_contact	= $this->setting->load_by_parameter('email_info');
		$email_support	= $this->setting->load_by_parameter('email_support');
		$name_to		= '';
		$send_to		= '';
		
		$fields	= array(
					// Personal Form
					'name'		=> '',
					'email'		=> '',
					'phone'		=> '',
					'message'	=> '',
			
					// Corporate Form
					'corporatemobile' => '',			
					'corporatephone' => '',											
					'corporatefax' => '',	
					'corporateemail' => '',		
					'corporatename' => '',					
					'corporateaddress' => '',			
					'corporatewebsite' => '',
					'corporatemessage' => '',					
					'captcha'	=> ''
				);
		
		$errors	= $fields;		

		if ($_POST) {
			$post	= new Validation($_POST);
						
			if($post['contact'] == 'personal') {
				
				$post->rule('name', 'not_empty');
                $post->rule('name', 'min_length', array(':value', 4));				
				$post->rule('name', 'regex', array(':value', '/^[0-9a-z_.\s\-]++$/iD'));
				
                $post->rule('message', 'not_empty');
				$post->rule('message', 'min_length', array(':value', 4));
				$post->rule('message', 'regex', array(':value', '/^[0-9a-z_.\s\-]++$/iD'));
				
				$post->rule('email', 'Valid::email');
				$post->rule('email', 'not_empty');
                $post->rule('email', 'min_length', array(':value', 4));
				
				$post->rule('phone', 'not_empty');
				$post->rule('phone', 'regex', array(':value', '/^\d/'));
								
				$name_to = trim(strip_tags(ucfirst($email_contact->alias))); 
				$send_to = trim(strip_tags($email_contact->value));
						
			} else
			if($post['contact'] == 'corporate') {
				
				$post->rule('name', 'not_empty');
                $post->rule('name', 'min_length', array(':value', 4));
				$post->rule('name', 'regex', array(':value', '/^[0-9a-z_.\s\-]++$/iD'));
												
				$post->rule('corporatemobile', 'not_empty');
				$post->rule('corporatemobile', 'regex', array(':value', '/^\d/'));				
				
				$post->rule('corporatephone', 'not_empty');				
				$post->rule('corporatephone', 'regex', array(':value', '/^\d/'));
				
				$post->rule('corporatefax', 'regex', array(':value', '/^\d/'));				
																				
				$post->rule('corporateemail', 'Valid::email');
				$post->rule('corporateemail', 'not_empty');
                $post->rule('corporateemail', 'min_length', array(':value', 4));
				
				$post->rule('corporatewebsite', 'Valid::url');
				
				$post->rule('corporatename', 'regex', array(':value', '/^[0-9a-z_.\s\-]++$/iD'));
				$post->rule('corporatename', 'not_empty');
                $post->rule('corporatename', 'min_length', array(':value', 4));
				
				$post->rule('corporatemessage', 'not_empty');
				$post->rule('corporatemessage', 'min_length', array(':value', 4));
				$post->rule('corporatemessage', 'regex', array(':value', '/^[0-9a-z_.\s\-]++$/iD'));
				$post->rule('corporateaddress', 'regex', array(':value', '/^[0-9a-z_.\s\-]++$/iD'));
				
				$name_to = trim(strip_tags(ucfirst($email_support->alias))); 
				$send_to = trim(strip_tags($email_support->value));
			}

			// Captcha
			$post->rule('captcha', 'not_empty');
			$post->rule('captcha', 'Captcha::valid', array(':value'));
			
			// Posts checking				
			if ($post->check() && Captcha::valid($post['captcha'])) {
					$fields	= $post->as_array();

					
					if ($post['contact'] == 'personal') {					
						$content_vars	= array(
										'contact'	 => $fields['contact'],
										'name'		 => $fields['name'],
										'email'		 => $fields['email'],
										'phone'		 => $fields['phone'],
										'message'	 => $fields['message'],
										'site_name'  => $this->data['title_name'],
										'registered_mark' => $this->data['registered'],
										);
					} else
					if ($post['contact'] == 'corporate') {
												
						$content_vars	= array(
										'contact'	=> $fields['contact'],
										'name'		=> $fields['name'] .' | '.$fields['corporatename'],
										'corporate' => $fields['corporatename'],
										'email'		=> $fields['corporateemail'],
										'message'	=> $fields['corporatemessage'],
										'phone'		=> $fields['corporatephone'],
										'mobile'	=> $fields['corporatemobile'],
										'website'	=> !empty($fields['corporatewebsite']) ? $fields['corporatewebsite'] : '',
										'fax'		=> !empty($fields['corporatefax']) ? $fields['corporatefax'] : '',
										'address'	=> !empty($fields['corporateaddress']) ? $fields['corporateaddress'] : '',	
										'site_name'			=> $this->data['title_name'],
										'registered_mark'	=> $this->data['registered'],
										);
					}
					
					//----------- Admin data email template -----------
					$email_view		= View::factory('email/contact_form_admin');					
					
					foreach ($content_vars as $var => $val) {
						$email_view->$var	= $val;
					}		

					$_name	= $name_to; 
					$_mail	= $send_to;

					$to			= array($_mail, $_name);  // Address can also be array('to@example.com', 'Name')
					//$to		= $_mail;  // Address can also be array('to@example.com', 'Name')
					$from		= Lib::config('site.email_address');
					$subject	= Lib::config('site.email_contact_subject');

					$message	= $email_view->render();	
					
					// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

					// Additional headers
					$headers .= 'To: '.$_name.' <'.$_mail.'>' . "\r\n";
					$headers .= 'From: '.$subject.' <'.$from.'>' . "\r\n";
					$headers .= 'Bcc: defrian.yafi@gmail.com' . "\r\n";
					
					// Mail it
					if(mail($_mail, $subject, $message, $headers)) {
					//if(Email::send('default', $subject, $message, $from, $to, TRUE)) {						
					//if (Helper_Common::sending_email($to, $from, $subject, $message)) {	

						//----------- Public data email template -----------
						$email_view		= View::factory('email/contact_form_public');

						foreach ($content_vars as $var => $val) {
							$email_view->$var	= $val;
						}

						//$to		= $fields['email'];  // Address can also be array('to@example.com', 'Name')
						//$to		= array($fields['email'], $fields['name']);  // Address can also be array('to@example.com', 'Name')
						$to			= (!empty($fields['email'])) ? strip_tags($fields['email']) : strip_tags($fields['corporateemail']);
						$from		= Lib::config('site.email_address');
						$subject	= Lib::config('site.email_contact_subject');

						$message	= $email_view->render();

						/*** Using Email library with headers manipulation ***/
						
						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

						// Additional headers
						$headers .= 'To: '.$to.' <'.$to.'>' . "\r\n";
						$headers .= 'From: '.$subject.' <'.$from.'>' . "\r\n";
						$headers .= 'Bcc: defrian.yafi@gmail.com' . "\r\n";
										
						// Helper_Common::sending_email($recepient_email,$subject,$message_public,$from);
						// Helper_Common::sending_email($recepient_email,$subject,$message_admin,$from);

						// Helper_Common::sending_email($to, $from, $subject, $message);

						// The real email function
						//Email::send('default', $subject, $message, $from, $to, TRUE);
						mail($to, $subject, $message, $headers);					
					}

					// set flash session data
					$this->session->set('result', __('thanks_email'));

					//$this->request->redirect('contact-us');
					//url::redirect(str_replace('{member}', $this->session->get('member_list.member_id'), Kohana::config('member.default_page')));
					
					//echo json_encode('1');
					//Request::$current->redirect('contact-us');
					//return;
					$result['result']	= 'sent'; 
					//echo json_encode($result);
					//return;
			} else {
					//print_r($post);
					//exit;
					$errors 	= Arr::overwrite($errors, $post->errors('validation'));
					$buffers	= $errors;
					
					foreach ($errors as $row_key => $row_val) {
						if ($row_val != '') {
							$buffers[$row_key]	= Lib::config('site.error_field_open').ucfirst($row_val).Lib::config('site.error_field_close');
						} else {
							$buffers[$row_key]	= $row_val;
						}
					}
					$result['errors']		= $buffers;
					$result['result']		= __('check_form');
			}
		}
		//usleep('200000');
		echo json_encode($result);
		
	}
	
	public function action_captcha_reload() {
		
		$captcha = Captcha::instance();
		//$captcha->render();
		echo $captcha->render(TRUE);
		exit();
	}
}
