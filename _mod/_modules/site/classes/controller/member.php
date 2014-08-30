<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Member extends Controller_Themes_DefaultBlank {	
	protected $_member;
	protected $_genders;
	protected $id1;
	protected $id2;
	protected $id3;
	protected $id4;
	protected $email_admin;

	public function before () {
		parent::before();
			
		$this->email_admin  = Model_Setting::instance()->load_by_parameter('email_administrator');
		
        $this->id1 = Request::$current->param('id1');
        $this->id2 = Request::$current->param('id2');
        $this->id3 = Request::$current->param('id3');
		$this->id4 = Request::$current->param('id4');
		
		// Data settings for website
		$settings = Model_Setting::instance()->find(array('status' => 'publish'));
		$buffers  = array();
		foreach ($settings as $setting){
			$buffers[$setting->parameter] = trim(strip_tags($setting->value));
		}
		$settings = $buffers;

		//-- Object that accesed from within all inheritance
		$this->settings = $settings;
		//-- Object that accesed from within all inheritance
		
		$this->_member = new Model_User;
		
		// Get genders
		$this->_genders	= (Lib::config('member.genders') !== NULL) ? Lib::config('member.genders') : array();
		unset($buffers);
		
	}
    
	public function action_index () {
	
		$this->request->redirect(URL::site());
		
		$content_vars		= array('' => '' ,'' => '');

		$content			= View::factory('site/member_login_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->page_title		= Lib::config('site.title');
		$this->template->content		= $content; 
	}
	
	public function action_login () {
		
		$fields	= array(
				'email'		=> '',
				'password'	=> '',
				);
		
		$errors	= $fields;	
		$status = '';
		
		if ($_POST) {
			$post	= new Validation($_POST);
			
                $post->rule('email', 'not_empty');
                $post->rule('email', 'min_length', array(':value', 4));
				$post->rule('email', 'Valid::email');
                $post->rule('password', 'not_empty');
				$post->rule('password', 'min_length', array(':value', 4));
				
				if ($post->check()) {
						$fields	= $post->as_array();

						$params	= array(
								'email'		=> $fields['email'],
								'password'	=> $fields['password']);
						
						// Authenticate User Accounts and return User ID
						$user       = new Model_User;
						$return		= $user->authenticate_user($fields['email'], sha1($fields['password']), '99');
						
						// Check User Level from User ID given
						$user_level	= $user->get_user_level($return);				
						
						// Check for Enable Level from User Level given
						$where_cond		= array('status'=>'enable','id'=>$user_level);
						$level_enable	= Model_UserLevel::instance()->find($where_cond,'',1);
						
						// Check for Disabled or Deleted Level and return message
						if (intval($return) && !$level_enable) {
							// Change return value
							$return = 'level_disable';
						}
						
						if (intval($return) != 0 && !empty($level_enable)) {
							// Set User Session Id
							$this->session->set('member_id', $return);
							
							//$this->request->redirect(str_replace('{user_id}', base64_encode($return), Lib::config('site.default_page')));
							
							// Set status to logged
							$status = 'LOGGED'; 
							
							// Set User Session Id
							$this->session->set('result', 'You are logged');
							
							//return;
						} else {
							switch ($return) {
								case 'blocked':
									$this->session->set('auth_error', __('blocked_id'));
									break;
								case 'inactive':
									$this->session->set('auth_error', __('inactive_id'));
									break;							
								case 'level_disable':
									$this->session->set('auth_error', __('id_level_disabled'));
									break;							
								default:
									$this->session->set('auth_error', __('id_default_warning'));
							}
							//$this->template->page_title = i18n::get('error_login');
							$status = $this->session->get('auth_error');	
							
							// Set auth_error Session to Empty
							$this->session->delete('auth_error');
						}
						//return;
				} else {
						$fields		= Arr::overwrite($fields, $post->as_array());
						$errors 	= Arr::overwrite($errors, $post->errors('validation'));
						$buffers	= $errors;
						foreach ($errors as $row_key => $row_val) {
							if ($row_val != '') {
								$buffers[$row_key]	= Lib::config('site.error_field_open').ucfirst($row_val).Lib::config('site.error_field_close');
							} else {
								$buffers[$row_key]	= $row_val;
							}
						}
						$errors		= $buffers;
						
						// Set auth_error Session to Empty
						$this->session->delete('auth_error');
									
				}
		}
		
		$content_vars		= array(
									'status'	=> $status,
									'errors'	=> $errors,
									'fields'	=> $fields,
									);

		$content			= View::factory('site/member_login_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->page_title		= Lib::config('site.title');
		$this->template->content		= $content; 
	}
	
	public function action_logout() {
		if ($this->session->get('member_id') == '') {
			return $this->request->redirect(URL::site());
		}	
		$this->session->delete('member_id');
				
		// Set User Session Id
		$this->session->set('result', 'You are Log Out');
		
		return $this->request->redirect(URL::site());
	}
	
	public function action_register () {
		// Clear all member session
		$this->session->delete('member_id');
		
		// Home Page Categories --- id = 1		
		
		//print_r($this->session->set('captcha_invalid_count',0));

		// Load Captcha library, you can supply the name of the config group you would like to use.
		//$captcha = Captcha::instance();
		$captcha = Captcha::instance();
		
		//print_r($captcha->render(TRUE));
		
		// Don't show Captcha anymore after the user has given enough valid
		// responses. The "enough" count is set in the captcha config.
		// Ban bots (that accept session cookies) after 90 invalid responses.
		// Be careful not to ban real people though! Set the threshold high enough.
		
		if ($captcha->invalid_count() > 89)
			exit('Bye! your a bot.');

		$fields	= array(//'name'				=> '',
						'password'			=> '',
						'password2'			=> '',
						'email'				=> '',
						'phone'				=> '',
						//'church'			=> '',			
						//'gender'			=> '',
						'birthday'			=> '',
						'phone'				=> '',
						'address'			=> '',
						'country'			=> '',
						'member_type'		=> '',
						'agree'				=> '',
						'captcha'	=> '');

		$errors	= $fields;
		$status = '';

		if ($_POST) {
			$post	= Validation::factory($_POST);

			/** Adding validation **/
			
			// Fullname
			$post->rule('name', 'not_empty');
			$post->rule('name', 'regex', array(':value', '/^[a-z0-9_.\s\-]++$/iD'));
			$post->rule('name', array($this, '_valid_name'), array(':validation','name'));
			
			// Email
			$post->rule('email', 'min_length', array(':value', 4));
			$post->rule('email', 'not_empty');
			$post->rule('email', 'Valid::email', array(':value'));
			$post->rule('email', array($this, '_valid_email'), array(':validation','email'));
			// Phone
			//$post->rule('phone', 'min_length', array(':value', 4));
			//$post->rule('phone', 'regex', array(':value', '/^[0-9]++$/iD'));
			// Church
			//$post->rule('church', 'regex', array(':value', '/^[a-z0-9_.\s\-]++$/iD'));			
			// Gender
			//$post->rule('gender', 'not_empty');
			// Password
			$post->rule('password', 'not_empty');
			// Confirm Password
			$post->rule('password2', 'not_empty');
			$post->rule('password2', 'matches', array(':validation','password2','password'));
			// Password 
			$post->rule('captcha', 'not_empty');
			$post->rule('captcha', 'Captcha::valid', array(':value'));
			
			//$post->rule('agree', 'not_empty');
		
			if ($post->check() && Captcha::valid($post['captcha'])) {
                            
				$fields	= $post->as_array();
				
				$hash_password = md5($fields['name'].$fields['email'].$fields['password']);
				
				$params = array('name' 		=> $fields['name'],
								'email'     => $fields['email'],
								'password'	=> $fields['password'].'-:|:-'.$hash_password,
								'level_id'	=> '99',
								'status'	=> 'inactive');

				$where_cond	= array('email'		=> $fields['email'],
									'status'	=> 'deleted');

				$users		= Model_User::instance()->find($where_cond, '', '', 1);

				if (!isset($users[0]))  {
					$user_id	= '';

					if (!$user_id = Model_User::instance()->add($params))
						return;

					$params= array( 'user_id'	=> $user_id,
									//'phone'		=> @$fields['phone'],
									//'church'	=> @$fields['church'],
									//'gender'	=> @$this->_genders[$fields['gender']],
									'status'	=> 'unverified',
									/*'name'		=> $fields['name'],*/
									/*'country'	=> @$fields['country'],*/
									/*'address'	=> @$fields['address'],*/
									/*'birthday'	=> @$fields['birthday'],*/
									/*'phone'		=> @$fields['phone']*/);

					Model_UserProfile::instance()->add($params);
					
				} else {
					$user_id			= $users[0]->id;

					$users[0]->name		= $fields['username'];
					$users[0]->email	= $fields['email'];
					//$users[0]->phone	= $fields['phone'];					
					//$users[0]->gender	= $this->_genders[$fields['gender']];
					//$users[0]->church	= $fields['church'];					
					$users[0]->level_id	= $this->level->id;
					$users[0]->status	= 'unverified';
					$users[0]->update();
					//$users[0]->reset_password(md5($fields['password']));
					$users[0]->reset_password($fields['password']);

					$profile			= Model_UserProfile::instance()->load($user_id);

					$params= array( 'user_id'	=> $user_id,
									'gender'	=> $this->_genders[$fields['gender']],
									//'phone'		=> $fields['phone'],
									//'church'	=> $fields['church'],
									'status'	=> 'unverified',
									/*'name'		=> $fields['name'],*/
									/*'country'	=> $fields['country'],*/
									/*'address'	=> $fields['address'],*/
									/*'birthday'	=> $fields['birthday'],*/
									/*'phone'		=> $fields['phone']*/);

					foreach ($params as $var => $val) {
						$profile->$var	= $val;
					}

					$profile->update();
				}

				// build code validation
				
				//$content_vars	= array('code_activation'	=> md5($user_id.$fields['username'].$fields['email']."inactive".mktime()));
				$activate_link	= HTML::anchor(URL::site('member/activation_by_mail/'.$hash_password),
									'Verifikasi Akun',array('title'=>'Verifikasi Akun')
									);
				$content_vars	= array(
								'activate_link'		=> $activate_link,
								'site_name'			=> $this->settings['title_name'],
								'registered_mark'	=> $this->settings['registered_mark'],
								);

				$email_view		= View::factory('email/member_registration');

				foreach ($content_vars as $var => $val) {
					$email_view->$var	= $val;
				}

				$to			= trim(strip_tags($fields['email']));  // Address can also be array('to@example.com', 'Name')
				$from		= Lib::config('site.email_address');
				$subject	= Lib::config('site.email_verification_subject');
                
				$message	= $email_view->render();

				// Create a message
				/*
				$message = Swift_Message::newInstance('Wonderful Subject')
				  ->setFrom(array('john@doe.com' => 'John Doe'))
				  ->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'))
				  ->setBody('Here is the message itself')
				  ;

				$to      = 'to@example.com';  // Address can also be array('to@example.com', 'Name')
				$from    = 'from@example.com';
				$subject = 'This is an example subject';
				$message = 'This is an <strong>example</strong> message';

				email::send($to, $from, $subject, $message, TRUE);
				*/

				Email::send($to, $from, $subject, $message, TRUE);
				
				// send message to client
				$status = 'REGISTERED';
				
				// set flash session data
				$this->session->set('register_info',__('register_success'));

				//$this->request->redirect(URL::site());

			} else {
				$fields		= Arr::overwrite($fields, $post->as_array());
				$errors 	= Arr::overwrite($errors, $post->errors('validation'));
				$buffers	= $errors;
				foreach ($errors as $row_key => $row_val) {
					if ($row_val != '') {
						$buffers[$row_key]	= Lib::config('site.error_field_open').ucfirst($row_val).Lib::config('site.error_field_close');
					} else {
						$buffers[$row_key]	= $row_val;
					}
				}
				$errors		= $buffers;
				
				$this->session->set('result','');
				
				// set flash session data
				//$this->session->set('register_info','Your registration has failed.');
				
				$errors		= $buffers;
			}

			unset($_POST);
		}

		$flash = $this->session->get('register_info') ? $this->session->get('register_info') : '';
		
        $content_vars		= array(
									'status'	 => $status,
									'errors'	 => $errors,
                                    'fields'	 => $fields,
									'captcha'	 => $captcha,
									'flash_info' => $flash,
									'genders'	 => $this->_genders,
									);

		$content			= View::factory('site/member_register_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->page_title		= Lib::config('site.title');
		$this->template->content		= $content; 
	}
	
	public function action_activation_by_mail() {
		//print_r($this->id1); exit();
		//print_r($activate_code); exit();
		
		$status = '';
		$activate_code = $this->id1;
		$obj_data = $this->_member->find(array('level_id'=>99,'status !='=>'inactive','status !='=>'blocked'));
		
		$check_code = '';
		$check_pass = '';
		$buffers[] = array();
		foreach ($obj_data as $val){
			// Explode code to match code data
			$buffers = explode('-:|:-', $val->password);
			
			//print_r($buffers);
		
			// Checking if code exists or not
			if (isset($buffers[0]) && isset($buffers[1])) { 
				// Checking between parameter given and code data exploded
				if ($buffers[1] === $activate_code) {
					// Thrown to variable if data match
					$check_code = $buffers[0].'-:|:-'.$activate_code;
					$check_pass = $buffers[0];
				}
			}
		}
		
		//print_r($obj_data);
		//print_r($check_code); 
		//print_r($check_pass); exit();
		
		if (!empty($check_code) && isset($check_pass)) {
			// Code matching with params thrown and existing user data
			$where_cond = array(
								'password' => $check_code,
								'level_id' => 99
								);
			
			$user					= new Model_User;
			$user_profile			= new Model_UserProfile;
			$user_id				= $user->find($where_cond);
			
			$user->id				= $user_id[0]->id;
			$user->load();
						
			// Code matching with params thrown and existing user_profile data
			$user_profile->user_id	= $user->id;
			$user_profile->load();

			//print_r(sha1($check_pass)); exit();
			
			// Setting params for update user data, set active and convert code to password
			$params1 = array( 
							'id' => $user->id,
							'password' => sha1($check_pass),
							'status' => 'verified'
							);

			// Setting params for update user_profile data and set active
			$params2 = array( 
							'user_id' => $user->id,
							'status' => 'verified'
							);

			//print_r($params1); exit();
			// Matching params to existing user data 
			foreach ($params1 as $var1 => $val1) {
				$user->$var1	= $val1;
			}
			
			// Update existing user data
			$user->reset_password($check_pass);
			$user->update();

			// Matching params to existing user profile data 
			foreach ($params2 as $var2 => $val2) {
				$user_profile->$var2	= $val2;
			}
			
			// Update existing user profile data
			$user_profile->update();
			
			/*** Send an email message to member for verified accounts ***/
			
			$content_vars	= array(
									'username'	=> $user->name, 
									'password'	=> $check_pass,
									'site_name'		=> !empty($this->settings['title_name']) ? $this->settings['title_name'] : '',
									'default_title' => !empty($this->settings['title_default']) ? $this->settings['title_default'] : '',
									'registered_mark'	=> !empty($this->settings['registered_mark']) ? $this->settings['registered_mark'] : '',
									);
			
			$email_view		= View::factory('email/member_approval');

			foreach ($content_vars as $var3 => $val3) {
				$email_view->$var3	= $val3;
			}
			//print_r($email_view); exit();
			$to			= $user->email;  // Address can also be array('to@example.com', 'Name')
			$from		= Lib::config('site.email_address');
			$subject	= Lib::config('site.email_verification_subject');

			// Render email html view
			$message	= $email_view->render();			
			
			// Send email to member
			Email::send($to, $from, $subject, $message, TRUE);

			// Unset all the email variable
			unset($email_view,$content_vars,$to,$from,$subject,$message);
			
			/*** Send email to admin for activated member status via admin-cp ***/
			$activating_link	= HTML::anchor(URL::site('admin-cp/member/index'),
										'Akun '.ucfirst(strip_tags($user->name)),
										array('title'=>'Verifikasi Akun '.ucfirst(strip_tags($user->name)))
									);
							
			$email_message = 'New member is verified : '. $activating_link;
						
			// Create an email message
			$content_vars	= array(
									'username'	=> $user->name, 
									'email_message'	=> $email_message,
									'site_name'		=> $this->settings['title_name'],
									'default_title' => $this->settings['title_default'],
									'registered_mark'	=> $this->settings['registered_mark'],
									);
			
			$email_view		= View::factory('email/admin_member_approval');

			foreach ($content_vars as $var4 => $val4) {
				$email_view->$var4	= $val4;
			}

			// Send email to administrator 
			$to		= trim(strip_tags($this->email_admin->value));  // Address can also be array('to@example.com', 'Name')
			$from	= Lib::config('site.email_address');
			$subject = 'New Member Registration '.trim(ucfirst(strip_tags($user->name)));
			
			// Render email html view
			$message	= $email_view->render();			

			// Send email to member
			Email::send($to, $from, $subject, $message, TRUE);
			
			// Set true id member login
			$this->session->set('member_id', $user->id);
			
			// Set true flash message
			$this->session->set('register_info', __('register_verified'));
			
			// send message to client
			$status = 'ACTIVATED';
			
			// Redirect to login
			//url::redirect ('members/login');
			
			$this->request->redirect(URL::site());
			
		} else {
			
			// Set false flash message
			$this->session->set('register_info', 'Sorry, your account is not registered.');
			
			// Redirect to register
			$this->request->redirect(URL::site());
		}
		unset($buffers, $check_code, $check_pass);
	}
	
	public function action_account_forgotten_mail($activate_code='') {
		if (empty($activate_code)) {
			echo 'Sorry wrong code';
		} else {
			echo $activate_code;
		}
	}
	
	public function action_forgot_password () {
	    //$this->template                 = new View($this->templates);
		
		$fields	= array('email'				=> '');

		$errors	= $fields;

		if ($_POST) {
			$post	= new Validation($_POST);

			// Adding pre_filter
			$post->pre_filter('trim', 'email');

			// Adding validation
			$post->add_rules('email', 'required'); 
			$post->add_callbacks('email', array($this, '_valid_email'));
      
			if ($post->validate()) {
                            
				$fields	= $post->as_array();
				
				$params = array('email'          => $fields['email']);
				
				$where_cond	= array('email'		=> $fields['email'],
									'level_id'	=> '99');

				$users		= Model_User::instance()->find($where_cond, '', '', 1);

				if (!isset($users[0]))  {
					$user_id	= '';

					if (!$user_id = Model_User::instance()->add($params))
						return;

					$params= array( 'user_id'	=> $user_id,
									'name'		=> $fields['name'],
									'country'	=> @$fields['country'],
									'address'	=> @$fields['address'],
									'birthday'	=> @$fields['birthday'],
									'phone'		=> @$fields['phone']);

					Model_UserProfile::instance()->add($params);
				} else {
					$user_id			= $users[0]->id;

					$users[0]->name		= $fields['username'];
					$users[0]->email	= $fields['email'];
					$users[0]->level_id	= $this->level->id;
					$users[0]->status	= 'inactive';

					$users[0]->update();

					//$users[0]->reset_password(md5($fields['password']));
					$users[0]->reset_password($fields['password']);

					$profile			= Model_UserProfile::instance()->load($user_id);

					$params= array( 'user_id'	=> $user_id,
									'name'		=> $fields['name'],
									'country'	=> $fields['country'],
									'address'	=> $fields['address'],
									'birthday'	=> $fields['birthday'],
									'phone'		=> $fields['phone']);

					foreach ($params as $var => $val) {
						$profile->$var	= $val;
					}

					$profile->update();
				}

				// build code validation
				
				//$content_vars	= array('code_activation'	=> md5($user_id.$fields['username'].$fields['email']."inactive".mktime()));
				$content_vars	= array('code_activation'	=> md5($fields['username'].$fields['email'].$fields['password']),
										'site_name'			=> $this->settings['site_title'],
										'default_title'		=> $this->settings['default_title']
										);

				$email_view		= View::factory('email/member_registration');

				foreach ($content_vars as $var => $val) {
					$email_view->$var	= $val;
				}

				// Create a message
				$to			= $fields['email'];  // Address can also be array('to@example.com', 'Name')
				$from		= 'noreply@'.$_SERVER['SERVER_NAME'];
				$subject	= Lib::config('site.email_activation_subject');
                
				$message	= $email_view->render();
				
				Email::send($to, $from, $subject, $message, TRUE);

				// set flash session data
				$this->session->set('flash','Congratulation your account password is changed');

				$this->request->redirect('member');
				//url::redirect(str_replace('{member}', $this->session->get('member_list.member_id'), Lib::config('member.default_page')));
				return;
			} else {
				$fields		= Arr::overwrite($fields, $post->as_array());
				$errors 	= Arr::overwrite($errors, $post->errors('validation'));
				$buffers	= $errors;
				foreach ($errors as $row_key => $row_val) {
					if ($row_val != '') {
						$buffers[$row_key]	= Lib::config('site.error_field_open').ucfirst($row_val).Lib::config('site.error_field_close');
					} else {
						$buffers[$row_key]	= $row_val;
					}
				}
				$errors		= $buffers;
			}
		}
		
		$flash = $this->session->get('register_info') ? $this->session->get('register_info') : '';

		$content_vars		= array('errors'	 => $errors,
									'fields'	 => $fields,
									'flash_info' => $flash
									);

		$content			= View::factory('site/member_forgot_password');

		//print_r($content);
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}

        $this->template->page_title = Lib::config('site.title').' - Member Forgot Password';
		$this->template->content	= $content;
	
	}	
	
	public function action_profile() {

		//print_r($this->member);
		
		$profile	= new Model_UserProfile;
		$profile->user_id = isset($this->member->id) ? $this->member->id : 0;
		$profile->load();
		
		// Load Captcha library, you can supply the name of the config group you would like to use.
		//$captcha = Captcha::instance();
		$captcha = Captcha::instance();
		
		//print_r($captcha->render(TRUE));
		
		// Don't show Captcha anymore after the user has given enough valid
		// responses. The "enough" count is set in the captcha config.
		// Ban bots (that accept session cookies) after 90 invalid responses.
		// Be careful not to ban real people though! Set the threshold high enough.
		
		if ($captcha->invalid_count() > 89)
			exit('Bye! your a bot.');

		$fields	= array('name'				=> '',
						'email'				=> '',
						'gender'			=> '',
						'birthday'			=> '',
						'phone'				=> '',
						'church'			=> '',
						'about'				=> '',		
						'address'			=> '',
						'country'			=> '',
						'captcha'			=> '');

		$errors	= $fields;
		$status = '';
		
		if ($_POST) {
			$post	= Validation::factory($_POST);

			//$post->pre_filter('trim', 'name');

			/** Adding validation **/
			
			// Fullname
			$post->rule('name', 'not_empty');
			$post->rule('name', 'regex', array(':value', '/^[a-z0-9_.\s\-]++$/iD'));
			//$post->rule('name', array($this, '_valid_name'), array(':validation','name'));
			
			// Email
			$post->rule('email', 'min_length', array(':value', 4));
			$post->rule('email', 'not_empty');
			$post->rule('email', 'Valid::email', array(':value'));
			
			//$post->rule('gender', 'not_empty');
			$post->rule('phone', 'not_empty');
			$post->rule('birthday', 'not_empty');
			
			//$post->rule('email', array($this, '_valid_email'), array(':validation','email'));
			// Password
			//$post->rule('password', 'not_empty');
			// Confirm Password
			//$post->rule('password2', 'not_empty');
			//$post->rule('password2', 'matches', array(':validation','password2','password'));
			
			// Password 
			$post->rule('captcha', 'not_empty');
			$post->rule('captcha', 'Captcha::valid', array(':value'));
			
			//$post->rule('agree', 'not_empty');
			//print_r($post); exit();
			if ($post->check()) {
                            
				$fields	= $post->as_array();
				
				if (!empty($this->member->id))  {

					$user				= Model_User::instance()->load($this->member->id);
					
					$params				= array(
											'id'	=> $this->member->id,
											'name'		=> isset($fields['name']) ? $fields['name']: '',
											'email'		=> isset($fields['email']) ? $fields['email'] : '',
										 );
					foreach ($params as $var => $val) {
						$user->$var	= $val;
					}

					$user->update();
					unset($params);
					
					$profile			= Model_UserProfile::instance()->load($this->member->id);

					$params= array(
							'user_id'	=> $this->member->id,
							//'gender'	=> isset($fields['gender']) ? $fields['gender'] : '',
							'birthday'	=> isset($fields['birthday']) ? $fields['birthday'] : '',
							'phone'		=> isset($fields['phone']) ? $fields['phone'] : '',
							'church'	=> isset($fields['church']) ? $fields['church'] : '',
							'about'		=> isset($fields['about']) ? $fields['about'] : '',		
							'address'	=> isset($fields['address']) ? $fields['address'] : '',	
							'country'	=> isset($fields['country']) ? $fields['country'] : '',
							);

					foreach ($params as $var => $val) {
						$profile->$var	= $val;
					}

					$profile->update();
					unset($params);
				}

				// set flash session data
				$this->session->set('result','Your profile is updated.');
				
				// set status to client
				$status = 'UPDATED';
				unset ($params);
				//$this->request->redirect(URL::site());
				//url::redirect(str_replace('{member}', $this->session->get('member_list.member_id'), Lib::config('member.default_page')));
				//return;
				
			} else {
				$fields		= Arr::overwrite($fields, $post->as_array());
				$errors 	= Arr::overwrite($errors, $post->errors('validation'));
				$buffers	= $errors;
				foreach ($errors as $row_key => $row_val) {
					if ($row_val != '') {
						$buffers[$row_key]	= Lib::config('site.error_field_open').ucfirst($row_val).Lib::config('site.error_field_close');
					} else {
						$buffers[$row_key]	= $row_val;
					}
				}
				$errors		= $buffers;
				
				// set flash session data
				$this->session->set('result','Your profile is failed to update.');
				
				$errors		= $buffers;
			}

			unset($_POST);
			
		} else {
			$fields	= array('name'				=> isset($this->member->name) ? $this->member->name : '',
							'email'				=> isset($this->member->email) ? $this->member->email : '',
							//'gender'			=> isset($this->member->gender) ? $this->member->gender : '',
							'birthday'			=> isset($profile->birthday) ? $profile->birthday : '',
							'phone'				=> isset($profile->phone) ? $profile->phone : '',
							'church'			=> isset($profile->church) ? $profile->church : '',
							'about'				=> isset($profile->about) ? $profile->about : '',		
							'address'			=> isset($profile->address) ? $profile->address : '',	
							'country'			=> isset($profile->country) ? $profile->country : '',
							'captcha'			=> '');
			
		}

		$flash = $this->session->get('register_info') ? $this->session->get('register_info') : '';
		
        $content_vars		= array('errors'	 => $errors,
                                    'fields'	 => $fields,
									'captcha'	 => $captcha,
									'flash_info' => $flash,
									'status'	 => $status,
									'genders'	 => $this->_genders,
									);
		
		$content			= View::factory('site/member_profile_page');

		//print_r($content);
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}

        $this->template->page_title = Lib::config('site.title').' - Member Update Profile';
		$this->template->content	= $content;
		
	}
	
	public function action_captcha_reload() {
		
		$captcha = Captcha::instance();
		//$captcha->render();
		echo $captcha->render(TRUE);
		exit();
	}
	
	/** CALLBACKS **/
	
	public function _valid_email(Validation $array, $field) {
		if (empty($array[$field]))
			return;
		
		$where_cond = array('level_id'=>99,'email'=>$array[$field]);
		$result = ! Model_User::instance()->find($where_cond,'',1);
		
		if (!$result)
			$array->error($field, 'email_exists');
	}
	
	public function _valid_name(Validation $array, $field) {
		if (empty($array[$field]))
			return;
		
		$where_cond = array('level_id'=>99,'name'=>$array[$field]);
		$result = ! Model_User::instance()->find($where_cond,'',1);
		
		if (!$result)
			$array->error($field, 'name_exists');
	}
	
}
