<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Backend_Testimonial extends Controller_Backend_BaseAdmin {
	
	protected $_module_name;
	protected $_class_name;
	protected $_search_keys;
	protected $_prefs;

	protected $_upload_path;
	protected $_upload_url;

	protected $testimonial;
	protected $testimonials;
	protected $user;
	protected $users;
	protected $statuses;

	private $_parent_testimonial;

	public function before () {
		// Get parent before method
        parent::before();
		
		$this->_class_name	= $this->request->controller();
		$this->_module_name	= 'testimonial';	
		$this->_module_menu	= $this->acl->module_menu;
		
		$this->_search_keys	= array('title'		=> 'Title',
									'person'	=> 'Person',
									'status'	=> 'Status');

		$this->_prefs			= (Lib::config($this->_module_name.'.'.$this->_class_name.'_fields') !== NULL) ? Lib::config($this->_module_name.'.'.$this->_class_name.'_fields') : array();
		$this->_upload_path		= (Lib::config($this->_module_name.'.upload_path') !== NULL) ? Lib::config($this->_module_name.'.upload_path') : array();
		$this->_upload_url		= (Lib::config($this->_module_name.'.upload_url') !== NULL) ? Lib::config($this->_module_name.'.upload_url') : array();

		$this->testimonial	= new Model_Testimonial;
		$this->testimonialcontent	= new Model_TestimonialContent;
		
		$this->user			= new Model_User;

		$where_cond			= array('status'	=> 'publish');
		$this->testimonials		= $this->testimonial->find($where_cond);

		$this->file			= new Model_TestimonialFile();
		$this->user			= new Model_User();
		
		$where_cond			= array('status'	=> 'active');
		$this->users		= $this->user->find($where_cond);

		$this->statuses		= array('publish',
									'unpublish');
		
	}

	function action_index () {
	
		$where_cond	= array('status !='	=> 'deleted');

		/** Find & Multiple change status **/

		if ($_POST) {
			$post	= new Validation($_POST);

			if (isset($post['field']) || isset($post['keyword'])) {
				$post->rule('keyword', 'regex', array(':value', '/^[a-z0-9_.\s\-]++$/iD'));
				if ($post->check()) {
					$where_cond[$post['field'] . ' LIKE']	= $post['keyword'] . '%';

					$filters	= array('f'	=> $post['field'],
										'q'	=> $post['keyword']);

					$this->session->set($this->_class_name.'_filter', serialize($filters));
				} else if (isset($post['find'])) {
					$this->session->delete($this->_class_name.'_filter');
				}
			}

			if ($this->session->get($this->_class_name.'_filter') !== FALSE) {
				$filters	= unserialize($this->session->get($this->_class_name.'_filter'));

				if (in_array($filters['f'], array_keys($this->_search_keys)) && $filters['q'] != '')
					$where_cond[$filters['f'] . ' LIKE']	= '%' . $filters['q'] . '%';
			}
		}
		
		$_files  = $this->file->find();
		$buffers = array();
		foreach ($_files as $_file){
			$buffers[$_file->testimonial_id] = $_file;
		}
		$files = $buffers;

		/** Table sorting **/
		$params		= Request::$current->param();		
		$sorts		= array('asc', 'desc');		
		$sort		= isset($params['id2']) ? $this->id2 : 'added';
		$order		= isset($params['id4']) ? $this->id4 : $sorts[1];
		$order_by	= array($sort => $order);
		$page_index	= isset($_GET['page']) ? $_GET['page'] - 1: 0;
		$per_page	= Lib::config('admin.item_per_page');	
		//$per_page	= 10;
		$page_url	= isset($_GET['page']) ? '?page='.$_GET['page'] : '';
		$offset		= ($page_index == 0) ? '' : $page_index * $per_page;

		$table_headers	= array('title'		=> 'Title',
								'person'	=> 'Person',
								'show_cover'=> 'Show Cover',								
								'default'	=> 'Default Cover',								
								'status'	=> 'Status',
								'added'		=> 'Added',
								'modified'	=> 'Modified');
		
		if (isset($params['id2']) && isset($params['id4'])) {
			$headers	= array_keys($table_headers);
			$sort		= (isset($params['id2']) && in_array(strtolower($params['id2']), $headers)) ? strtolower($params['id2']) : $headers[0];
			$order		= (isset($params['id4']) && in_array(strtolower($params['id4']), $sorts)) ? strtolower($params['id4']) : $sorts[0];
			$order_by	= array($sort=> $order);
		}
		if (isset($params['id3']) && isset($params['id5'])) {
			$headers	= array_keys($table_headers);
			$sort		= (isset($params['id3']) && in_array(strtolower($params['id3']), $headers)) ? strtolower($params['id3']) : $headers[0];
			$order		= (isset($params['id5']) && in_array(strtolower($params['id5']), $sorts)) ? strtolower($params['id5']) : $sorts[0];
			$order_by	= array($sort=> $order);
		}
		/** Execute list query **/
		$field			= isset($filters['f']) ? $filters['f'] : '';
		$keyword		= isset($filters['q']) ? $filters['q'] : '';
		$where_cond		= isset($where_cond) ? $where_cond : '';
		$total_rows		= count($this->testimonial->find($where_cond));
		$total_record	= $total_rows;
		$listings		= $this->testimonial->find($where_cond, $order_by, $per_page, $offset);
		
		$pagination		= Pagination::factory(array(
				'total_items' 		=> $total_rows,
				'items_per_page' 	=> $per_page,
			 ));
		
		// List Page Detail collection
		$detail_data = $this->testimonialcontent->find(array('lang_id' => Lang::_default()));
		$buffers = array();
		foreach($detail_data as $data){
			$buffers[$data->testimonial_id] = $data;
		}
		$detail_data = $buffers;		
		
		/** Views **/

		$content_vars		= array(
									'language_data' => $this->language_data,
									'detail_data'	=> $detail_data,
									'listings'		=> $listings,
									'files'			=> $files,
									'total_record'	=> $total_record,
									'table_headers'	=> $table_headers,
									'statuses'		=> $this->statuses,
									'module_menu'	=> $this->_module_menu,
									'class_name'	=> $this->_class_name,
									'class_name'	=> $this->_class_name,	
									'search_keys'	=> $this->_search_keys,
									'upload_path'	=> $this->_upload_path,
									'upload_url'	=> $this->_upload_url,
									'field'			=> $field,
									'keyword'		=> $keyword,
									'order'			=> $order,
									'sort'			=> $sort,
									'page_url'		=> $page_url,
									'page_index'	=> $page_index,
									'params'		=> $params,
									'pagination'	=> $pagination);

		$content			= View::factory($this->_class_name.'/backend/'.$this->_class_name.'_index');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->content		= $content; 
	}

	public function action_add () {
		$fields	= array('title'			=> '',
						'person'		=> '',		
						'media'			=> '',
						'show_cover'	=> '',
						'default'		=> '',
						'status'		=> '');
		if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
			foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
				$fields[$row_name]	= '';
				if (isset($row_params['caption']) && $row_params['caption'])
					$fields[$row_name.'_caption']	= '';
				if (isset($row_params['description']) && $row_params['description'])
					$fields[$row_name.'_description']	= '';
			}
		}
		$errors	= $fields;
		if ($_POST) {
			$_POST['media'] = !empty($_POST['_media']) ? $_POST['_media'] : $_POST['media'];			
			if ($_FILES)
				$post	= new Validation(array_merge($_POST, $_FILES));
			else
				$post	= new Validation($_POST);
			$post->rule('title', 'not_empty');					
			$post->rule('title', array($this, '_safe_html_title'), array(':validation', ':field', 'title'));
			$post->rule('person', 'not_empty');
			//$post->rule('media','regex',array(':value','~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i'));
			$post->rule('show_cover', 'numeric');
			$post->rule('default', 'numeric');
			$post->rule('order','numeric');
			if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
				foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
					// Set if this is optional or not, return true
					if (isset($row_params['optional'])) {
						$post->rule($row_name, 'Upload::not_empty');
					}
					
					// Set if this is not the right file type, return true
					if (isset($row_params['file_type'])) {
						$post->rule($row_name, 'Upload::type', array(':value', explode(",", $row_params['file_type'])));
					} 

					// Set if this is not the right max file size, return true
					if (isset($row_params['max_file_size'])) {
						$post->rule($row_name, 'Upload::size', array(':value', $row_params['max_file_size']));
					} 
					
					// Set if this file has valid name in database, return true
					//if (isset($post[$row_name]['name'])) {
						//$post->rule($row_name, array($this, '_unique_filename'), array(':validation', $row_name));
					//}
				}
			}
			$post->rule('title', array($this, '_unique_title'), array(':validation', ':field', 'title'));
			if ($post->check()) {
				$fields	= $post->as_array();				
				$params	= array('title'			=> $fields['title'],
								'person'		=> $fields['person'],
								'media'			=> $fields['media'],					
								'show_cover'	=> !empty($fields['show_cover']) ? $fields['show_cover'] : 0,
								'default'		=> !empty($fields['show_cover']) ? $fields['show_cover'] : 0,
								'user_id'		=> (isset($this->acl->user->id)) ? $this->acl->user->id : 0,
								'status'		=> $fields['status']);
				$id		= $this->testimonial->add($params);
				$params2 = array();				
				foreach($post['detail'] as $detail) {					
					$params2[]	= array(
										'testimonial_id' => !empty($id) ? $id : 0,
										'lang_id'	=> $detail['lang_id'],
										'subject'	=> $detail['subject'],
										'text'		=> $detail['text'],								
								);
				}				
				foreach ($params2 as $row => $val) {
					$this->testimonialcontent->add($val);
				}
				if ($id !== FALSE && isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
					foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
						if (!Upload::not_empty($_FILES[$row_name]) || !Upload::type($_FILES[$row_name],explode(',',$row_params['file_type'])) || !Upload::valid($_FILES[$row_name]))
							continue;
						if (!File::exts_by_mime($post[$row_name]['type']))
							continue;
						$file_hash	= md5(time() + rand(100, 999));
						$file_data	= pathinfo($_FILES[$row_name]['name']);
						$file_name	= Upload::save($post[$row_name], $file_hash.'.'.$file_data['extension'], $this->_upload_path,0755);
						$file_data	= pathinfo($file_name);
						$file_mime	= $_FILES[$row_name]['type'];
						if ($file_name != '' && isset($this->_prefs['uploads'][$row_name]['image_manipulation'])) {
							$params			= array('testimonial_id'	=> $id,
													'field_name'	=> $row_name,
													'file_name'		=> $file_data['basename'],
													'file_type'		=> $file_mime,
													'caption'		=> isset($fields[$row_name.'_caption']) ? $fields[$row_name.'_caption'] : '',
													'description'	=> isset($fields[$row_name.'_description']) ? $fields[$row_name.'_description'] : '');
							$this->file->add($params);
						}
					}
				}
				if (isset($_POST['add_another'])) {
					$this->request->redirect(ADMIN.$this->_class_name.'/add');
					return;
				}
				$this->request->redirect(ADMIN.$this->_class_name.'/view/'.$id);
				return;
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
		/** Generate Thumbnails **/
		Lib::_auto_image_manipulation($this->_upload_path, $this->file, $this->_prefs);
		/** Views **/
		$where_cond			= array('status !='		=> 'deleted');
		$order_by			= array('order'			=> 'ASC');
		$orders				= $this->testimonial->find($where_cond, $order_by);
		$content_vars		= array('language_data'		=> $this->language_data,
									'errors'		=> $errors,
									'fields'		=> $fields,
									'statuses'		=> $this->statuses,
									'class_name'	=> $this->_class_name,
									'class_name' 	=> $this->_class_name,
									'module_menu'	=> $this->_module_menu);
		$content_vars		= array_merge($content_vars, $this->_prefs);
		$content			= View::factory($this->_class_name.'/backend/'.$this->_class_name.'_add');
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		$this->template->content		= $content; 
	}

	public function action_view () {
		
		// Js and CSS for specified controller	
		$this->template->css	= array('jPlayer/jplayer.blue.monday.css'=>'all');
		$this->template->js		= array('library/jPlayer/jquery.jplayer.min.js');
		
		$id = $this->id1;
		$this->testimonial->id	= $id;
		if (!$this->testimonial->load()) {
			$this->request->redirect(ADMIN.$this->_class_name.'/error/invalid_request');
			return;
		}
		/** Views **/
		
		$where_cond			= array('testimonial_id'	=> $this->testimonial->id);
		$files				= $this->file->find($where_cond);
		$buffers			= array();
		
		foreach ($files as $row) {
			$buffers[$row->field_name]	= $row;
		}
		
		$files				= $buffers;
		unset($buffers);
		
		// List News Detail collection
		$detail_data = $this->testimonialcontent->find(array('lang_id IN' => Lang::_get_lang(),'testimonial_id'=>$this->testimonial->id));
		$buffers = array();
		foreach($detail_data as $data){
			$buffers[$data->lang_id] = $data;
		}
		$detail_data = $buffers;
		
		/** Generate Thumbnails **/
		Lib::_auto_image_manipulation($this->_upload_path, $this->file, $this->_prefs);
		/** Views **/
		$content_vars		= array('language_data' => $this->language_data,
									'detail_data'	=> $detail_data,		
									'testimonial'		=> $this->testimonial,
									'files'			=> $files,
									'readable_mime'	=> Lib::config($this->_class_name.'.readable_mime'),
									'upload_path'	=> $this->_upload_path,	
									'upload_url'	=> $this->_upload_url,	
									'class_name'	=> $this->_class_name,
									'module_menu'	=> $this->_module_menu,
									'class_name'	=> $this->_class_name);
		$content_vars		= array_merge($content_vars, $this->_prefs);
		$content			= View::factory($this->_class_name.'/backend/'.$this->_class_name.'_view');
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		$this->template->content		= $content; 
	}

	public function action_edit () {
		$id = $this->id1;
		$category_id = $this->id2;
		$this->testimonial->id	= $id;
		if (!$this->testimonial->load()) {
			$this->request->redirect(ADMIN.$this->_class_name.'/error/invalid_request');
			return;
		}
		$fields	= array('title'				=> '',
						'person'			=> '',
						'media'				=> '',
						'show_cover'		=> '',
						'order'				=> '',
						'status'			=> '');
		if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
			foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
				$fields[$row_name]	= '';
				if (isset($row_params['caption']) && $row_params['caption'])
					$fields[$row_name.'_caption']	= '';
				if (isset($row_params['description']) && $row_params['description'])
					$fields[$row_name.'_description']	= '';
			}
		}
		$errors	= $fields;
		if ($_POST) {
			$_POST['media'] = !empty($_POST['_media']) ? $_POST['_media'] : $_POST['media'];
			$_POST['media'] = !empty($_POST['media_clear']) ? '' : $_POST['media'];						
			if ($_FILES)
				$post	= new Validation(array_merge($_POST, $_FILES));
			else
				$post	= new Validation($_POST);
			$post->rule('title', 'not_empty');					
			$post->rule('title', array($this, '_safe_html_title'), array(':validation', ':field', 'title'));
			$post->rule('person', 'not_empty');
			//$post->rule('media','regex',array(':value','~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i'));
			$post->rule('order','numeric');
			$post->rule('show_cover','numeric');
			if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
				foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
					// if (isset($row_params['file_type']))
						// $post->add_rules($row_name, 'upload::type['.$row_params['file_type'].']');
					// if (isset($row_params['max_file_size']))
						// $post->add_rules($row_name, 'upload::size['.$row_params['max_file_size'].']');
					if (!File::exts_by_mime($post[$row_name]['type']))
						continue;	
				}
			}
			if ($post->check()) {
				$fields	= $post->as_array();
				$params	= array('title'				=> $fields['title'],
								'person'			=> $fields['person'],
								'media'				=> $fields['media'],
								'show_cover'		=> isset($fields['show_cover']) ? $fields['show_cover'] : '',
								'status'			=> $fields['status']);
				foreach ($params as $var => $val) {
					$this->testimonial->$var	= $val;
				}
				$this->testimonial->update();
				$params2 = array();
				foreach($fields['detail'] as $detail) {					
					$params2[$detail['lang_id']]	= array(
										'id'			=> !empty($detail['id']) ? $detail['id'] : '',
										'testimonial_id'		=> $this->testimonial->id,						
										'lang_id'		=> $detail['lang_id'],
										'subject'		=> $detail['subject'],
										'text'			=> $detail['text']
									);
				}
				foreach ($params2 as $row => $val) {
					if (!empty($row) && !empty($val['subject']) && !empty($val['id'])) {
						$this->testimonialcontent->id			= $val['id'];
						$this->testimonialcontent->testimonial_id		= $val['testimonial_id'];
						$this->testimonialcontent->lang_id		= $val['lang_id'];
						$this->testimonialcontent->subject		= $val['subject'];
						$this->testimonialcontent->text			= $val['text'];
						$this->testimonialcontent->update();
					} else {
						$this->testimonialcontent->add($val);
					}
				}	
				if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
					$where_cond			= array('testimonial_id'	=> $this->testimonial->id);
					$files				= $this->file->find($where_cond);
					$buffers			= array();
					foreach ($files as $row) {
						$buffers[$row->field_name]	= $row;
					}
					$files				= $buffers;
					unset($buffers);
					foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
						if (isset($fields['delete_'.$row_name]) && $fields['delete_'.$row_name] == 1 && isset($files[$row_name])) {
							$this->file->id	= $files[$row_name]->id;
							$this->file->load();
							$this->file->delete();
						}
						
						if (!Upload::not_empty($post[$row_name]) || !Upload::type($post[$row_name],explode(',',$row_params['file_type'])) || !Upload::valid($post[$row_name]))
							continue;
						
						//print_r($fields[$row_name.'_description']); exit();
						//print_r(Upload::not_empty($post[$row_name])); exit();
						//print_r($post[$row_name]['name']); exit();
						
						$file_hash	= md5(time() + rand(100, 999));
						$file_data	= pathinfo($post[$row_name]['name']);
						
						$file_name	= Lib::_upload_to($post[$row_name], $file_hash.'.'.$file_data['extension'], $this->_upload_path,0755);
						$file_data	= pathinfo($file_name);
						$file_mime	= $post[$row_name]['type'];
						
						if (!isset($files[$row_name])) {	
							$params			= array('testimonial_id'	=> $id,
													'field_name'	=> $row_name,
													'file_name'		=> isset($file_data['basename']) ? $file_data['basename'] : '',
													'file_type'		=> isset($file_mime) ? $file_mime : '',
													'caption'		=> isset($fields[$row_name.'_caption']) ? $fields[$row_name.'_caption'] : '',
													'description'	=> isset($fields[$row_name.'_description']) ? $fields[$row_name.'_description'] : '');
							$this->file->add($params);
						} else {
							$this->file->id	= $files[$row_name]->id;
							$this->file->load();
							$params			= array('testimonial_id'	=> $id,
													'field_name'	=> $row_name,
													'file_name'		=> isset($file_data['basename']) ? $file_data['basename'] : $files[$row_name]->file_name,
													'file_type'		=> isset($file_mime) ? $file_mime : '',
													'caption'		=> isset($fields[$row_name.'_caption']) ? $fields[$row_name.'_caption'] : '',
													'description'	=> isset($fields[$row_name.'_description']) ? $fields[$row_name.'_description'] : '');		
							foreach ($params as $var => $val) {
								$this->file->$var	= $val;
							}
							$this->file->update();
						}
					}
				}
				
				$this->request->redirect(ADMIN.$this->_class_name.'/view/'.$this->testimonial->id);
				return;
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
		} else {
			$fields	= array('title'				=> $this->testimonial->title,
							'person'			=> $this->testimonial->person,
							'media'				=> $this->testimonial->media,
							'show_cover'		=> $this->testimonial->show_cover,
							'order'				=> $this->testimonial->order,
							'status'			=> $this->testimonial->status);			
		}
		$where_cond			= array('testimonial_id'	=> $this->testimonial->id);
		$files				= $this->file->find($where_cond);
		$buffers			= array();
		foreach ($files as $row) {
			$buffers[$row->field_name]	= $row;
		}
		$files				= $buffers;
		unset($buffers);
		if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
			foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
				$fields[$row_name]	= '';
				if (isset($row_params['caption']) && $row_params['caption'])
					$fields[$row_name.'_caption']	= (isset($files[$row_name])) ? $files[$row_name]->caption : '';
				if (isset($row_params['description']) && $row_params['description'])
					$fields[$row_name.'_description']	= (isset($files[$row_name])) ? $files[$row_name]->description : '';					
			}
		}
		// Banner detail for language based on content id within language ids
		$detail_data	= $this->testimonialcontent->find(array('id !='=>'0','testimonial_id' => $this->testimonial->id,'lang_id IN'=>Lang::_get_lang()));
		$buffers = array();
		foreach($detail_data as $data){
			$buffers[$data->lang_id] = $data;
		}
		$detail_data = $buffers;
		/** Views **/
		$where_cond			= array('status !='		=> 'deleted');
		$order_by			= array('order'			=> 'ASC');
		$orders				= $this->testimonial->find($where_cond, $order_by);
		$content_vars		= array(									
									'language_data'	=> $this->language_data,
									'detail_data'	=> $detail_data,
									'errors'		=> $errors,
									'fields'		=> $fields,
									'class_name'	=> $this->_class_name,
									'upload_path'	=> $this->_upload_path,	
									'upload_url'	=> $this->_upload_url,	
									'class_name'	=> $this->_class_name,
									'module_menu'	=> $this->_module_menu,
									'testimonial'		=> $this->testimonial,
									'files'			=> $files,
									'orders'		=> $orders,
									'statuses'		=> $this->statuses,
									'readable_mime'	=> Lib::config($this->_class_name.'.readable_mime'));
		$content_vars		= array_merge($content_vars, $this->_prefs);
		$content			= View::factory($this->_class_name.'/backend/'.$this->_class_name.'_edit');
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		$this->template->content		= $content;
	}

	public function action_aupdate_all($id = null,$val = null){
        if ($this->request->is_ajax()) {
			$id = $_GET['pid'];
			// Change all fields that not have default value
			$testimonials = $this->testimonial->find();
			foreach ($testimonials as $testimonial) {
				$testimonial->default = 0;
				$testimonial->update();
			}
			$this->testimonial->id = $id;
			$this->testimonial->load();
			$this->testimonial->default = 1;
			$this->testimonial->update();
		}
		exit;
    }
	
    public function action_delete() {
		$this->testimonial->id	= $this->id1;
		if (!$this->testimonial->load()) {
			$this->request->redirect(ADMIN.$this->_class_name.'/index');
			return;
		}
		// This is used for only Ajax Request		
		if ($this->request->is_ajax()) {
			// This setting is used for deleting all file included
			if ($this->testimonial->delete($this->id1)) {
				$where_cond = array('testimonial_id'=>$this->id1);
				$mediafiles = $this->file->find($where_cond);
				foreach ($mediafiles as $files){
					if (is_readable($this->_upload_path.$files->file_name)) {
						@unlink($this->_upload_path.$files->file_name);
						 $this->file->delete($files->id);
					}
				}
				echo 1;
			} else {
				echo 0;
			}	
		} else {
			$this->request->redirect(ADMIN.$this->request->controller());
		}
		exit();
    }
	
	// Action for download item status	
	public function action_download() {
		$files		= $this->id1;
		$where_cond	= array('file_name'	=> $files);
		$files		= $this->file->find($where_cond);
		foreach ($files as $row) {
			Lib::_download(Lib::config($this->_class_name.'.upload_url').$row->file_name);
		}
	}
	
	// Action for update item status
	public function action_change() {
		
		if ($this->request->post('check') !='') {
			$rows	= $this->request->post('check');

			foreach ($rows as $row) {
				$this->testimonial->id	= $row;

				if (!$this->testimonial->load())
					continue;

				$this->testimonial->status	= $this->request->post('select_action');
				$this->testimonial->update();
			}

			$redirect_url	= (strstr($this->acl->previous_url,ADMIN)) ? $this->acl->previous_url : ADMIN.$this->_class_name.'/index';

			$this->request->redirect($redirect_url);
			
		} else {
			
			$this->request->redirect(ADMIN.$this->_class_name);
			
		}
		
	}
	
	public function action_check_title(){
		$title = $_GET['hash'];
		$where_cond = array('title'=>$title);
		$title_check = !empty($title_check) ? 1 : 0;
		echo $title_check;
		exit;
	}
	
	/** CALLBACKS **/

	public function _unique_title (Validation $array, $field) {
		if (isset($this->testimonial->title) && $this->testimonial->title == $array[$field])
			return;

		$where_cond		= array('title'	=> $array[$field]);
		$name_exists	= ($this->testimonial->find_count($where_cond) != 0);

		if ($name_exists)
			$array->error($field, 'name_exists');
	}

	public function _valid_user_id (Validation $array, $field) {
		if ($array[$field] == 0)
			return TRUE;

		$where_cond		= array('id'	=> $array[$field]);
		$parent_exists	= ($this->user->find_count($where_cond) != 0);

		if (!$parent_exists)
			$array->error($field, 'invalid_user_id');
	}

	public function _valid_status (Validation $array, $field) {
		if (!in_array($array[$field], $this->statuses))
			$array->error($field, 'invalid_status');
	}
	
	/** CALLBACKS **/
	public function _valid_category_id (Validation $array, $field) {
		if ($array[$field] == 0)
			return TRUE;
		$where_cond		= array('id'	=> $array[$field]);
		$parent_exists	= ($this->category->find_count($where_cond) != 0);
		if (!$parent_exists)
			$array->error($field, 'invalid_category_id');
	}
	
	public function _valid_search_key ($value = '') {
		return mysql_real_escape_string($value);
	}
	
	/** PRE FILTER **/
	public function _safe_html_title ($value = '') {
		//return htmlentities($value);
		return $value;
	}
	
	public function _reverse_date ($value = '') {
		if (strpos($value, '/') != 0)
			return (implode('-', array_reverse(explode('/', $value))));
		else
			return (implode('/', array_reverse(explode('-', $value))));
	}
	
	public function _category_id ($value = '') {
		$where_cond	= array('name LIKE'	=> '%'.$value.'%',
							'status !='	=> 'deleted');
		$buffers	= $this->category->find($where_cond);
		$ids		= array();
		foreach ($buffers as $row) {
			$ids[]	= $row->id;
		}
		return $ids;
	}
}
