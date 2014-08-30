<?php defined('SYSPATH') or die('No direct script access.');
return array(
    // General Page Settings
    'page_title'        => COMPANY_NAME,
    'meta_keywords'     => COMPANY_NAME,
    'meta_description'  => COMPANY_NAME,
    'google_analytics'  => COMPANY_NAME,
    'meta_copyright'    => COMPANY_NAME,
    'system_language'   => array('id'=>'Indonesia', 'en'=>'English'),
    // Label
	'size'				=> 'Size',
    'language'          => 'Language',
    'title'             => 'Title',
    'label'             => 'Label',
    'short_desc'        => 'Short Description',
    'full_desc'         => 'Full Description',
    'date'              => 'Date',
    'time'              => 'Time',
    'datetime'          => 'Date Time',
    'status'            => 'Status',
    'status_value'      => array(0=>'Unpublish',1=>'Publish'),
	'status_value_user' => array(0=>'Inactive',1=>'Active'),
	'default'           => 'Default',
	'default_value'     => array(0=>'No',1=>'Yes'),
	'delete_value'      => array(0=>'Undelete',1=>'Deleted'),
    'content_listing'   => '%type Listing',
    'content_detail'    => 'View %type Details',
    'content_edit'      => 'Edit %type Details',
    'content_translate' => 'Translate %type Details',
    'content_new'       => 'Add New %type',
	'detail'			=> 'Detail',
    'changed_status'    => 'Changed Status',
    'date_format'       => 'dd-mm-yyyy',
    'title_action'      => 'Click for %action this item',
    'page'              => 'Page',
    'image'             => 'Image',
	'icon'              => 'Icon',
    'url'               => 'Url',	
	'helpdesk'			=> 'Helpdesk Forum',
	'events&csr'		=> 'Events & CSR',
	'event'				=> 'Event',
	'upcoming_event'	=> 'Upcoming Events',
	'reseller'			=> 'Reseller',
	'principal'			=> 'Principal',
	'sitemap'			=> 'Sitemap',
    'more'              => 'Read More',	
	'learn_more'		=> 'Learn More',
	'view_more'			=> 'View More',
	'download'			=> 'Download',	
	'download_more'		=> 'Download More',
	'news'				=> 'News',
	'product' 			=> 'Product',
	'product_not_in' 	=> 'Products in %data not yet available',
	'promo' 			=> 'Promotion',	
	'price' 			=> 'Price',
	'channel' 			=> 'Channel',
	'distribution'		=> 'Distribution',
	'about' 			=> 'About',
	'latest'       		=> 'Latest %type',
	'back_to'      		=> 'Back to %type',
	'search'			=> 'Search',
	'search_keywords'	=> 'Search by Keywords',	
	'language'			=> 'Language',
	'no_detail'			=> 'No %type Detail', 
	'here'				=> 'You are here',
	'home'				=> 'Home', 
	'contact'			=> 'Contact', 
	'contact_us'		=> 'Contact Us', 
	'contact_personal'  => 'Personal Form', 	
	'contact_corporate' => 'Corporate Form', 		
	'support_division'	=> 'Support Division',
	'us'				=> 'Us',
	'or'				=> 'or',
	'send_email'		=> 'Send an email. All fields with an <span class="red">*</span> are required.',	
	'send_message'		=> 'Send Message',
	'no_content'		=> 'No Content', 
	'our'				=> 'Our %title',
	'check_form'		=> '*Check your form again',
	'company_overview'	=> 'Company Overview',
	'testimonials'		=> 'Testimonials',
	'download_source'	=> 'Download Source',
	'pick_category'		=> 'Pick your category',
	'category'			=> 'Category',	
	'type'				=> 'Type',		
	'email_address'		=> 'Email Address',
	'login_first'		=> 'Login first to download',
	'register_site'		=> 'Register on our website to have full access on our website and Download page.',
	'new_account'		=> 'New account	please <a href="'.URL::site('member/register').'" class="">Register</a>',
	'send'				=> 'Send',
	'already_register'	=> 'Already have an account ? <a href="'.URL::site('member/login').'">Login</a> to proceed',
	// Validation
	'not_empty'			=> 'Must not be empty',
	'not_valid'			=> 'Not valid',
	'unavailable'		=> '%data Not Available',
	'already_exists'	=> 'Already exists',
	'exact_length'		=> 'Must be exactly :param2 characters long',
	'min_length'		=> 'Must be at least :param2 characters long',
	'valid_url'			=> 'Must be a url',	
	'max_length'		=> 'Must not exceed :param2 characters long',
	'regex'				=> 'Does not match the required format',
	'matches'			=> 'Must be the same as :param3',
	// Email message
	'register_success'  => 'Please verify your email using the link we send to your email. If the email is not received, please check the spam / junk mail.',
	'register_verified' => 'Thank you for doing the verification, you can access the menu downloads for members.',
	// Member
	'login'				=> 'Login',
	'profile'			=> 'Profile',	
	'free'				=> 'Free',
	'register'			=> 'Register',
    'username'			=> 'Username',
	'fullname'			=> 'Full Name',	
	'password'			=> 'Password',
	'password2'			=> 'Confirm Password',
	'address'			=> 'Address',	
	'country'			=> 'Country',
	'church'			=> 'Church',
	'birthday'			=> 'Birthday',
	'about'				=> 'About',	
	'forgot'			=> 'Forgot',
	'forgot_password'	=> 'Please fill your email to continue',
	'gender'			=> 'Gender',	
	'confirm'			=> 'Confirm', 
	'captcha'			=> 'Captcha',
	'agree'				=> 'Agreement',
	'agreement'			=> 'I agree with the Terms and Conditions',
	'activating_acc'	=> 'Account Activation',
	'check_email'		=> 'Please check your email in %email',
	'update_profile'	=> 'Update Profile',
	'logout'			=> 'Logout',
	'message_password'	=> 'Wrong password',
	'message_email'		=> 'Email unregistered',
	'account_free'		=> 'To have an account at Offistarindo.com, you must complete the following data',
	'captcha_code'		=> 'Captcha',
	'captcha_reload'	=> 'Reload Captcha',
	'submit'			=> 'Submit',	
	'reset'				=> 'Reset',	
	'cancel'			=> 'Cancel',	
	'overview'			=> 'Overview',
	'features'			=> 'Features',
	'specification'		=> 'Specification',
	'combo_option'		=> 'Combination Option',
	'upcoming_event'	=> 'Upcoming Event',
	'no_upcoming_event' => 'No Upcoming Event',
	//Search 
	'search_empty'		=> 'Search result is empty',
	// Admin
	'admin'				=> 'Admin',
	'welcome_admin'		=> 'Welcome %admin',
	'error_login'		=> 'Authentication failed',
	// Error encountered
	'error_enc'			=> 'Some errors were encountered, please check the details you entered.',
	'added'				=> 'Added',
	'modified'			=> 'Modified',
	// Contact Form
	'admin_contact'		=> '<h2>Contact us form</h2>Dear Administrator, there is someone contacting from the web<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name : %name,<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone : %phone,<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email : %email,<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Message : %message<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Thank you for your attention.<br/>
							<!--span style="font-style: italic; color: lightgray; font-size: 11px; margin: 0px">
							<b>%site_name</b><br/>%address<br/>
							Phone : %phone Fax : %fax<br/>
							<span-->',
	
	'admin_contact_co'	=> '<h2>Contact us form</h2>Dear Administrator, there is someone contacting from the web<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name : %name<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile : %mobile<br/>							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone : %phone<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax : %fax<br/>							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email : %email<br/>							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Corporate Name : %corporate<br/>	
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Corporate Address : %address<br/>	
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Corporate Website : %website<br/>								
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Message : %message<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Thank you for your attention.<br/>
							<!--span style="font-style: italic; color: lightgray; font-size: 11px; margin: 0px">
							<b>%site_name</b><br/>%address<br/>
							Phone : %phone Fax : %fax<br/>
							<span-->',
	
	'public_contact'	=> '<h2>Contact us form</h2>
							Dear %name, thank you for contacting us.<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							We will reply to your messages as soon as posible.<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Thank you for your attention.<br/>
							<!--span style="font-style: italic; color: lightgray; font-size: 11px; margin: 0px">
							<b>%site_name</b><br/>%address<br/>
							Phone : %phone Fax : %fax<br/>
							<span-->',
	
	'public_contact_co'	=> '<h2>Contact us form</h2>
							Dear %name, thank you for contacting us.<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							We will reply to your messages as soon as posible.<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Thank you for your attention.<br/>
							<!--span style="font-style: italic; color: lightgray; font-size: 11px; margin: 0px">
							<b>%site_name</b><br/>%address<br/>
							Phone : %phone Fax : %fax<br/>
							<span-->',
	
	'thanks_email'		=> 'Thank you for contacting us. Your message has been sent successfully to our team. We will consider it in advance and will immediately contact you.',
	'contact_success'	=> 'Your message has been sent',
	'form_contact_us'	=> 'Form Contact Us',
	// Contact Us
	'name'				=> 'Name',
	'company'			=> 'Company',
	'message'			=> 'Message',
	'phone'				=> 'Phone',
	'fax'				=> 'Fax',		
	'email'				=> 'Email',	
	'mobile'			=> 'Mobile',		
	'corporatename'	=> 'Company Name',
	'corporateemail'	=> 'Company Email',	
	'corporateaddress'	=> 'Company Address',
	'corporatewebsite'	=> 'Company Website',
	'corporatemobile'	=> 'Company Mobile',	
	'corporatephone'	=> 'Company Phone',
	'corporatefax'		=> 'Company Fax',	
	'corporatemessage'	=> 'Company Message',
	// Career
	'career'			=> 'Career',
	'no_career'			=> 'No vacancies at this time.',
	// Pagination			
	'first'				=> 'First',
	'previous'       	=> 'Previous',
	'next'				=> 'Next',
	'last'       		=> 'Last',
    // Warning
    'warning_delete'    => 'Want to delete this item? Deleted Items can not be restored back',
    // Auth Error
	'blocked_id'			=> 'Your User ID has been blocked by Administrator',
	'inactive_id'			=> 'Your User ID has been inactive', 
	'id_level_disabled'		=> 'Your User Level has been disabled by Administrator',
	'id_default_warning'	=> 'Invalid User ID or Password',
    // Error
    'error_no_data'     => 'Error. No record found',
    'error_no_translate'        => 'Error. No available translate yet',
    'error_no_direct_access'    => 'Error, no direct script access allowed',
    'error_upload_file' => array (
                                '501' => 'Oops. System error, can not upload files',
                                '503' => 'Files that you choose not permitted',
                                '504' => 'The image size that you select are not permitted',
                            )
);