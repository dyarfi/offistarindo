<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_News extends Controller_Backend_BaseAdmin {
    
	protected $_module_name;
	protected $_class_name;
	protected $_search_keys;
	protected $_prefs;
	
	protected $_upload_path;
	protected $_upload_url;

	protected $news;
    protected $_users;
	protected $_uid;
    
	public function before () {
		// Get parent before method
        parent::before();
        
		$this->news			= new Model_News;
		$this->newscontent	= new Model_NewsContent;
		$this->file			= new Model_NewsFile;
		
		$this->news_files	= new Model_NewsFilesFile;
		$this->user			= new Model_User;
        
		$this->_class_name		= $this->controller;	
		$this->_module_menu		= $this->acl->module_menu;
				
		$this->_prefs			= (Lib::config($this->_class_name.'.'.$this->_class_name.'_fields') !== NULL) ? Lib::config($this->_class_name.'.'.$this->_class_name.'_fields') : array();
		
		$this->_upload_path		= (Lib::config($this->_class_name.'.upload_path') !== NULL) ? Lib::config($this->_class_name.'.upload_path') : array();
		
		$this->_upload_url		= (Lib::config($this->_class_name.'.upload_url') !== NULL) ? Lib::config($this->_class_name.'.upload_url') : array();
		
		$this->_files_upload_path	= (Lib::config($this->_class_name.'.files_upload_path') !== NULL) ? Lib::config($this->_class_name.'.files_upload_path') : array();
		
		$this->_files_upload_url	= (Lib::config($this->_class_name.'.files_upload_url') !== NULL) ? Lib::config($this->_class_name.'.files_upload_url') : array();

		$this->_search_keys		= array('title'			=> 'Title',
                                        'status'		=> 'Status');
	
		$users					= $this->user->find();
		
		$buffers				= array();
		foreach ($users as $user){
			$buffers[$user->id] = $user;
		}
		$this->_users			= $buffers;		
		unset($buffers);
		
		//-- User id from user login session 'user_id'
		$this->_uid				= $this->session->get('user_id');
		
		//-- Default news statuses
		$this->statuses			= array('publish','unpublish');
		
		//print_r(dirname($this->_upload_path));
		
    }
    
    public function action_index() {       
		
		/** Find & Multiple change status **/

		if ($_POST) {
			$post	= new Validation($_POST);

			if (isset($post['field']) || isset($post['keyword'])) {
				$post->rule('field', array($this, '_valid_search_key'), array(':validation', 'field'));
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

		/** Table sorting **/

		$params		= Request::$current->param();
		$sorts		= array('asc', 'desc');

		$sort		= isset($params['id2']) ? $this->id2 : 'title';
		$order		= isset($params['id4']) ? $this->id4 : $sorts[0];
		$order_by	= array($sort 	=> $order);

		$page_index	= isset($_GET['page']) ? $_GET['page'] - 1: 0;
		$per_page	= Lib::config('admin.item_per_page');
		//$per_page	= 10;
		$page_url	= isset($_GET['page']) ? '?page='.$_GET['page'] : '';
		$base_url	= ADMIN.$this->_class_name;
		$offset		= ($page_index == 0) ? '' : $page_index * $per_page;

		$table_headers	= array('title'				=> 'Title',
								'news_date'			=> 'News Date',
								'status'			=> 'Status',
								'added'				=> 'Added',
								'modified'			=> 'Modified');

		if (isset($params['sort']) && isset($params['order'])) {
			$headers	= array_keys($table_headers);

			$sort		= (isset($params['sort']) && in_array(strtolower($params['sort']), $headers)) ? strtolower($params['sort']) : $headers[0];
			$order		= (isset($params['order']) && in_array(strtolower($params['order']), $sorts)) ? strtolower($params['order']) : $sorts[0];

			$order_by	= array($sort	=> $order);

			$base_url	= ADMIN.$this->_class_name.'/index/sort/' . $params['sort'] . '/order/' . $params['order'] . '/page/';
		}

		/** Execute list query **/

		$field		= isset($filters['f']) ? $filters['f'] : '';
		$keyword	= isset($filters['q']) ? $filters['q'] : '';
		$where_cond	= isset($where_cond) ? $where_cond : '';
		$total_rows		= $this->news->find_count($where_cond);
		$total_record 	= $total_rows;
		
		$listings	= $this->news->find($where_cond, $order_by, $per_page, $offset);		
		
		// List News Detail collection
		$detail_data = $this->newscontent->find(array('lang_id' => Lang::_default()));
		$buffers = array();
		foreach($detail_data as $data){
			$buffers[$data->news_id] = $data;
		}
		$detail_data = $buffers;
		
		/** Initialize pagination **/

		$pagination = Pagination::factory(array(
				'total_items' 		=> $total_rows,
				'items_per_page' 	=> $per_page,
			 )
		);
		
		/** Views **/

		$content_vars		= array('listings'		=> $listings,
									'detail_data'	=> $detail_data,
									'table_headers'	=> $table_headers,
									'statuses'		=> $this->statuses,
									'total_record'	=> $total_record,
									'module_menu'	=> $this->_module_menu,
									'class_name'	=> $this->_class_name,
									'search_keys'	=> $this->_search_keys,
									'field'			=> $field,
									'keyword'		=> $keyword,
									'order'			=> $order,
									'sort'			=> $sort,
									'page_url'		=> $page_url,
									'page_index'	=> $offset,
									//'params'		=> $params,
									'total_record'	=> $total_record,
									'pagination'	=> $pagination);

		$content_vars		= array_merge($content_vars, $this->_prefs);
		
		//$content			= array();
		$content			= View::factory($this->_class_name.'/backend/'.$this->_class_name.'_index');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->content		= $content; 
    }
    
    public function action_add() {

		$fields	= array(
						'title'		=> '',
						'news_date'	=> '',
						'end_date'	=> '',
						'status'	=> '');

		if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
			foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
				$fields[$row_name]	= '';

				if (isset($row_params['caption']) && $row_params['caption'])
					$fields[$row_name.'_caption']	= '';
			}
		}

		$errors	= $fields;

		if ($_POST) {
			if ($_FILES) 
				$post	= Validation::factory(array_merge($_POST,$_FILES));
			else
				$post	= Validation::factory($_POST);
			
                $post->rule('title', 'not_empty');
                $post->rule('title', 'min_length', array(':value', 4));
                $post->rule('news_date', 'not_empty');
                $post->rule('status', 'not_empty');
                
                $post->rule('title', array($this, '_unique_title'), array(':validation', 'title'));
            
			if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
				foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
					if (isset($row_params['optional']) && !$row_params['optional']) {
						//$post->add_rules($row_name, 'upload::required');
						//$post->rule($row_name, 'upload::valid');
					}
					
					if (Upload::type($post[$row_name],explode(',',$row_params['file_type'])) !== 1)
						continue;				

					//print_r($post); exit();
					//$post->rule(substr($post[$row_name]['type'], strpos($post[$row_name]['type'], '/') + 1), 'upload::type['.$row_params['file_type'].']');

					//if (isset($row_params['max_file_size']))
						//$post->rule(round($post[$row_name]['size'] / 1024, 2).'KB', 'upload::size['.$row_params['max_file_size'].']');
				}
			}

			if ($post->check()) {
				$fields	= $post->as_array();

				$params	= array(
						'title'			=> $fields['title'],
						'news_date'		=> $fields['news_date'],
						'user_id'		=> (isset($this->acl->user->id)) ? $this->acl->user->id : 0,
						'status'		=> $fields['status']);

				$id		= $this->news->add($params);
				
				$params2 = array();
				
				foreach($post['detail'] as $detail) {					
					$params2[]	= array(
											'news_id'	=> !empty($id) ? $id : 0,
											'lang_id'	=> $detail['lang_id'],
											'subject'	=> $detail['subject'],
											'synopsis'	=> $detail['synopsis'],
											'text'		=> $detail['text'],
								);
				}
				
				foreach ($params2 as $row => $val) {
					$this->newscontent->add($val);
				}
				
				if ($id !== FALSE && isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
					foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
						//if (!upload::required($_FILES[$row_name]) || !File::mime_by_ext($_FILES[$row_name]))
							//continue;

						
						//print_r(!Upload::type($_FILES[$row_name],explode(',',$row_name['file_type']))); exit();
						if (!File::exts_by_mime($post[$row_name]['type']))
							continue;
						
						$file_hash	= md5(time() + rand(100, 999));
						$file_data	= pathinfo($post[$row_name]['name']);
						
						$file_name	= Lib::_upload_to($post[$row_name], $file_hash.'.'.$file_data['extension'], $this->_upload_path,0777);
								
						$file_data	= pathinfo($file_name);
						$file_mime	= $post[$row_name]['type'];

						if ($file_name != '' && isset($this->_prefs['uploads'][$row_name]['image_manipulation'])) {
							$params = array('news_id'	 => $id,
											'field_name' => $row_name,
											'file_name'	 => $file_data['basename'],
											'file_type'	 => $file_mime,
											'caption'	 => isset($fields[$row_name.'_caption']) ? $fields[$row_name.'_caption'] : '');

							$this->file->add($params);
						}
					}
				}
				
				$this->session->set('function_add', 'success');

				if (isset($post['add_another'])) {
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

		$content_vars		= array(
									'language_data' => $this->language_data,
									'errors'	=> $errors,
									'fields'	=> $fields,
									'statuses'	=> $this->statuses,
									'class_name' 	=> $this->_class_name,
									'module_menu'	=> $this->_module_menu);
		
		$content_vars		= array_merge($content_vars, $this->_prefs);
		
		$content			= View::factory($this->_class_name.'/backend/'.$this->_class_name.'_add');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->content		= $content;  
    }
    
	public function action_edit () {
		$this->news->id	= $this->id1;

		if (!$this->news->load()) {
			$this->request->redirect(ADMIN.$this->_class_name.'/error/invalid_request');
			return;
		}

		$fields	= array(
						'title'				=> '',
						'status'			=> '',
						'news_date'			=> '');

		if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
			foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
				$fields[$row_name]	= '';

				if (isset($row_params['caption']) && $row_params['caption'])
					$fields[$row_name.'_caption']	= '';
			}
		}

		$errors	= $fields;

		if ($_POST) {
			if ($_FILES)
				$post	= new Validation(array_merge($_POST, $_FILES));
			else
				$post	= new Validation($_POST);

			$post->rule('title', 'not_empty');
			$post->rule('title', 'min_length', array(':value', 4));
            $post->rule('news_date', 'not_empty');
			$post->rule('status', 'not_empty');
			
			//$post->rule('title', array($this, '_unique_title'), array(':validation', 'title'));

			if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
				foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
					// if (isset($row_params['file_type']))
						// $post->add_rules(substr($post[$row_name]['type'], strpos($post[$row_name]['type'], '/') + 1), 'upload::type['.$row_params['file_type'].']');

					// if (isset($row_params['max_file_size']))
						// $post->add_rules(round($post[$row_name]['size'] / 1024, 2).'KB', 'upload::size['.$row_params['max_file_size'].']');
						
					if (!File::exts_by_mime($post[$row_name]['type']))
						continue;
				}
			}

			if ($post->check()) {
				$fields	= $post->as_array();
	
				$params	= array(
								'title'		=> $fields['title'],
								'news_date'	=> $fields['news_date'],
								'status'	=> $fields['status'],
								'user_id'	=> !empty($fields['user_id']) ? $fields['user_id'] : $this->_uid
						);

				foreach ($params as $var => $val) {
					$this->news->$var	= $val;
				}

				$this->news->update();
				
				$params2 = array();
				foreach($fields['detail'] as $detail) {					
					$params2[$detail['lang_id']]	= array(
										'id'			=> !empty($detail['id']) ? $detail['id'] : '',
										'news_id'		=> $this->news->id,						
										'lang_id'		=> $detail['lang_id'],
										'subject'		=> $detail['subject'],
										'synopsis'		=> $detail['synopsis'],
										'text'			=> $detail['text']
									);
				}
				foreach ($params2 as $row => $val) {
					if (!empty($row) && !empty($val['subject']) && !empty($val['id'])) {
						$this->newscontent->id			= $val['id'];
						$this->newscontent->news_id		= $val['news_id'];
						$this->newscontent->lang_id		= $val['lang_id'];
						$this->newscontent->subject		= $val['subject'];
						$this->newscontent->synopsis	= $val['synopsis'];
						$this->newscontent->text		= $val['text'];
						$this->newscontent->update();
					} else {
						$this->newscontent->add($val);
					}
				}				
				if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
					$where_cond			= array('news_id'	=> $this->news->id);
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
						
						if($row_params['caption'] == true && empty($_FILES[$row_name]['size']) && !empty($files[$row_name]->id)) {
							$this->file->id	= $files[$row_name]->id;
							$this->file->load();
							$this->file->caption = ($this->file->caption == $fields[$row_name.'_caption']) ? $this->file->caption : $fields[$row_name.'_caption']; 								
							$this->file->update();
						}
						
						//! Upload::valid($image) OR
						//! Upload::not_empty($image) OR
						//! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif')))
			
						/*
						if (!isset($_FILES[$row_name]) || (isset($_FILES[$row_name]) && !Upload::type($_FILES[$row_name],explode(',',$row_params['file_type'])) || !Upload::valid($_FILES[$row_name])))
							continue;
						*/
						
						if (!Upload::not_empty($post[$row_name]) || !Upload::type($post[$row_name],explode(',',$row_params['file_type'])) || !Upload::valid($post[$row_name]))
							continue;
						
						$file_hash	= md5(time() + rand(100, 999));
						$file_data	= pathinfo($post[$row_name]['name']);
						
						$file_name	= Lib::_upload_to($post[$row_name], $file_hash.'.'.$file_data['extension'], $this->_upload_path,0777);
						$file_data	= pathinfo($file_name);
						$file_mime	= $post[$row_name]['type'];
						
						if (!isset($files[$row_name])) {
							$params			= array('news_id'		=> $this->news->id,
													'field_name'	=> $row_name,
													'file_name'		=> $file_data['basename'],
													'file_type'		=> $file_mime,
													'caption'		=> isset($fields[$row_name.'_caption']) ? $fields[$row_name.'_caption'] : '');
							
							$this->file->add($params);
						} else {
						
							$this->file->id	= $files[$row_name]->id;
							$this->file->load();

							$params			= array('news_id'		=> $this->news->id,
													'field_name'	=> $row_name,
													'file_name'		=> $file_data['basename'],
													'file_type'		=> $file_mime,
													'caption'		=> isset($fields[$row_name.'_caption']) ? $fields[$row_name.'_caption'] : '');
							
							foreach ($params as $var => $val) {
								$this->file->$var	= $val;
							}

							$this->file->update();
						}

					}
				}

				$this->request->redirect(ADMIN.$this->_class_name.'/view/'.$this->news->id);
				return;
			} else {
				$fields		= Arr::overwrite($fields, $post->as_array());
				$errors 	= Arr::overwrite($errors, $post->errors('validation'));
				$buffers	= $errors;

				foreach ($errors as $row_key => $row_val) {
					if ($row_val != '')
						$buffers[$row_key]	= Lib::config('admin.error_field_open').ucfirst($row_val).Lib::config('admin.error_field_close');
					else
						$buffers[$row_key]	= $row_val;
				}

				$errors		= $buffers;
			}
		} else {
			$fields	= array(
							'title'				=> $this->news->title,
							'news_date'			=> $this->news->news_date,
							'status'			=> $this->news->status);

			$where_cond			= array('news_id'	=> $this->news->id);
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
				}
			}
		}
		
		// News detail for language based on content id within language ids
		$detail_data	= $this->newscontent->find(array('id !='=>'0','news_id' => $this->news->id,'lang_id IN'=>Lang::_get_lang()));
		$buffers = array();
		foreach($detail_data as $data){
			$buffers[$data->lang_id] = $data;
		}
		$detail_data = $buffers;
		
		$_news_files	= $this->news_files->find(array('news_id'=> $this->news->id),array('added'=>'asc'));	
		
		/** Generate Thumbnails **/
		
		Lib::_auto_image_manipulation($this->_upload_path, $this->file, $this->_prefs);
		
		/** Views **/

		$content_vars		= array(
									'language_data'	=> $this->language_data,
									'detail_data'	=> $detail_data,
									'errors'		=> $errors,
									'fields'		=> $fields,
									'class_name'	=> $this->_class_name,
									'module_menu'	=> $this->_module_menu,
									'users'			=> $this->_users,
									'news'			=> $this->news,			
									'news_files'	=> $_news_files,
									'upload_path'	=> $this->_upload_path,
									'upload_url'	=> $this->_upload_url,
									
									'files_upload_path' => $this->_files_upload_path,
									'files_upload_url'  => $this->_files_upload_url,
			
									'files'			=> !empty($files) ? $files : '' ,
									'events'		=> $this->news->find(array('status !=' => 'deleted', 'type' => 'event')),
									'statuses'		=> $this->statuses,
									'readable_mime'	=> Lib::config($this->_class_name.'.readable_mime'));

		$content_vars		= array_merge($content_vars, $this->_prefs);

		$content			= View::factory($this->_class_name.'/backend/'.$this->_class_name.'_edit');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->content		= $content;
	}
    
	public function action_download() {
		$files		= $this->id1;
		$where_cond	= array('file_name'	=> $files);
		$files		= $this->file->find($where_cond);
		foreach ($files as $row) {
			Lib::_download(Lib::config($this->_class_name.'.upload_url').$row->file_name);
		}
	}
	
    public function action_view() {

		$this->news->id	= $this->id1;
		
		if (!$this->news->load()) {
			$this->session->set('acl_error', 'Content not existing');			
			$this->request->redirect(ADMIN.$this->_class_name.'/index');
			return;
		}
		
		// List News Detail collection
		$detail_data = $this->newscontent->find(array('lang_id IN' => Lang::_get_lang(),'news_id'=>$this->news->id));
		$buffers = array();
		foreach($detail_data as $data){
			$buffers[$data->lang_id] = $data;
		}
		$detail_data = $buffers;
		
		$where_cond			= array('news_id'	=> $this->news->id);
		$files				= $this->file->find($where_cond);
		$buffers			= array();

		foreach ($files as $row) {
			$buffers[$row->field_name]	= $row;
		}

		$files				= $buffers;
				
		$_news_files		= $this->news_files->find(array('news_id'=> $this->news->id),array('added'=>'asc'));	
		
		/** Generate Thumbnails **/
		
		Lib::_auto_image_manipulation($this->_upload_path, $this->file, $this->_prefs);
		
		/** Views **/
		$content_vars		= array(
									'language_data' => $this->language_data,
									'detail_data' => $detail_data,
									'files'	  => $files,
									'news'	  => $this->news,
									'news_files'	=> $_news_files,
									'class_name'	=> $this->_class_name,
									'module_menu'	=> $this->_module_menu,
									'upload_path'	=> $this->_upload_path,
									'upload_url'	=> $this->_upload_url,	
									'files_upload_path' => $this->_files_upload_path,
									'files_upload_url'  => $this->_files_upload_url,
									'readable_mime'	=> Lib::config($this->_class_name.'.readable_mime')
									);
		
		$content_vars		= array_merge($content_vars, $this->_prefs);

		$content			= View::factory($this->_class_name.'/backend/'.$this->_class_name.'_view');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->content		= $content; 
    }
    
	public function action_fileupload (){
	
		if ($this->request->is_ajax()) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				
				if($_FILES) {
					
					$file_hash	= md5(time() + rand(100, 999));
					$file_data	= pathinfo($_FILES['files']['name']);

					$file_name	= Lib::_upload_to($_FILES['files'], $file_hash.'.'.$file_data['extension'], $this->_files_upload_path,0777);

					$file_data	= pathinfo($file_name);
					$file_mime	= $_FILES['files']['type'];

					if ($file_name != '' && isset($this->_prefs['uploads']['image_1']['image_manipulation'])) {
						$params = array('news_id'	 => $this->id1,
										'name'		 => $file_data['basename'],
										'field_name' => 'image_1',
										'file_name'	 => $file_data['basename'],
										'file_type'	 => $file_mime,
										'caption'	 => $file_data['basename'],							
										'status'	 => 'publish');

						$file_id = $this->news_files->add($params);
					}
					
					/*
					 * {"files":[{"name":"3_cottage_lane_s2_by_vinzdelacalzada.jpg","size":69668,"type":"image\/jpeg","url":"uploads\/news\/3_cottage_lane_s2_by_vinzdelacalzada.jpg","thumbnailUrl":"uploads\/news\/thumbnail\/3_cottage_lane_s2_by_vinzdelacalzada.jpg","deleteUrl":"http:\/\/localhost\/offistarindo\/admin-cp\/news\/filedelete?file=3_cottage_lane_s2_by_vinzdelacalzada.jpg","deleteType":"DELETE"}]}{"request":null,"response":null}
					 */
					
					/** Generate Thumbnails **/
					Lib::_auto_image_manipulation($this->_files_upload_path, $this->news_files, $this->_prefs);
					
					$return['files'][] = array(
											'name'	=>$file_data['basename'],
											'size'	=>$_FILES['files']['size'],
											'type'	=>$_FILES['files']['type'],
											'url'	=>$this->_files_upload_url . $file_data['basename'],
											'file_id'		=> $file_id,
											'thumbnailUrl'	=>$this->_files_upload_url . str_replace('.', '_crop_80x80.', $file_data['basename']),
											'deleteUrl'		=>URL::site(ADMIN).'/news/filedelete/'.$file_id,
											'deleteType'	=>'DELETE'
											);
					
					echo json_encode($return);
				}
				/*			
				$options = array(
							 'script_url' => URL::site(ADMIN . $this->_class_name.'/filedelete/'),
							 'upload_dir' => $this->_upload_path,	
							 'upload_url' => $this->_upload_url,
							 'thumbnail'  => array(
												'upload_dir' => $this->_upload_path.'thumbnail/',	
												'upload_url' => $this->_upload_url.'thumbnail/',
												'max_width' => 287, 
												'max_height' => 315
											),
							 'mkdir_mode' => 0777);
				*/
				//$upload_handler = new UploadHandler($options);				
			} 
			exit;
		}
	}
	
	public function action_filedelete () {
		$this->news_files->id	= $this->id1;
		
		if (!$this->news_files->load()) {
			$this->session->set('acl_error', 'Content not existing');
			$this->request->redirect(ADMIN.$this->_class_name.'/index');
			return;
		}
		
		// This is used for only Ajax Request		
		if ($this->request->is_ajax() && $this->id1 != '') {			
			// This setting is used for deleting all file included
			$files = $this->news_files->load($this->id1);
			if (!empty($files)) {
				if (is_readable($this->_upload_path.$files->file_name)) {
					@unlink($this->_upload_path.$files->file_name);
					@unlink($this->_upload_path.'thumbnail/'.$files->file_name);					
					$this->news_files->delete($this->id1);
				} else {
					$this->news_files->delete($this->id1);
				}				
				echo 1;
			} else {
				echo 0;
			}
			exit;
		} 
		exit;
	}
	
	public function action_filechange () {

		// Set auto render false
		$this->auto_render  = false;		
		
		// Set news files id
		$this->news_files->id	= $this->id1;
		
		// Set notification
		if (!$this->news_files->load()) {
			$this->session->set('acl_error', 'Content not existing');
			$this->request->redirect(ADMIN.$this->_class_name.'/index');
			return;
		}
		
				
		$fields	= array(
				'name'			=> '',				
				'description'	=> '',
				'text'			=> '',
				'status'		=> '');
		
		$errors	= $fields;
		
		$result = '';		
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->request->is_ajax()) {

				$post	= Validation::factory($_POST);
			
                $post->rule('name', 'not_empty');
                $post->rule('name', 'min_length', array(':value', 4));
                $post->rule('description', 'not_empty');
                $post->rule('description', 'min_length', array(':value', 4));
                $post->rule('status', 'not_empty');
				
			if ($post->check()) {
				$fields	= $post->as_array();

				$params	= array(
						'name'			=> $fields['name'],
                        'description'   => $fields['description'],
						'user_id'		=> (isset($this->acl->user->id)) ? $this->acl->user->id : 0,
						'status'		=> $fields['status']);

				foreach ($params as $var => $val) {
					$this->news_files->$var	= $val;
				}

				$result = $this->news_files->update();
				
				//$this->request->redirect(ADMIN.$this->_class_name.'/view/'.$id);
				//return;
			} else {
				$fields		= Arr::overwrite($fields, $post->as_array());
				$errors 	= Arr::overwrite($errors, $post->errors('validation'));
				$buffers	= $errors;
				/*
				foreach ($errors as $row_key => $row_val) {
					if ($row_val != '') {
						$buffers[$row_key]	= Lib::config('admin.error_field_open').ucfirst($row_val).Lib::config('admin.error_field_close');
					} else {
						$buffers[$row_key]	= $row_val;
					}
				}
				$errors		= $buffers;
				 * 
				 */
			}
			
			$return = array('errors' => $errors,
							'fields' => $fields,
							'result' => $result);
			
			echo json_encode($return);
			exit;
			
		} else {
			$fields	= array(
							'name'				=> $this->news_files->name,
							'description'		=> $this->news_files->description,
							'status'			=> $this->news_files->status);
		}       	

		/** Views **/
		$content_vars		= array(	
									'errors'		=> $errors,
									'fields'		=> $fields,
									'news_files'	=> $this->news_files,
									'class_name'	=> $this->_class_name,
									'module_menu'	=> $this->_module_menu,
									'upload_path'	=> $this->_upload_path,
									'upload_url'	=> $this->_upload_url,				
									'statuses'		=> $this->statuses,
									'readable_mime'	=> Lib::config($this->_class_name.'.readable_mime')
									);
		
		$content_vars		= array_merge($content_vars, $this->_prefs);
		
		$content			= View::factory($this->_class_name.'/backend/'.$this->_class_name.'_edit_file',$content_vars);


		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template		= $content;
		
		echo $this->template->render();
		

	}
	
    public function action_delete() {
	
		$this->news->id	= $this->id1;

		if (!$this->news->load()) {
			$this->request->redirect(ADMIN.$this->_class_name.'/index');
			return;
		}
		
		// Set is_deleted / status to TRUE
		// $this->news->status	= 'deleted';
		
		// if($this->news->update())
			// echo 1;
		// else
			// echo 0;
			
		
		// This is used for only Ajax Request		
		if ($this->request->is_ajax()) {
		
			// Set is_deleted / status to TRUE
			//$this->news->status	= 'deleted';
			//if($this->news->update()) {
			
			//$this->file			= new Model_NewsFile;
		
			//$this->news_files	= new Model_NewsFilesFile;
		
			if($this->news->delete($this->id1)) {
				/*
				$newsfiles		= $this->file->load($this->id1);
				$newsfilefiles	= $this->news_files->load($this->id1);
				if (!empty($newsfiles) && !empty($newsfilefiles)) {
					if (is_readable($this->_upload_path.$newsfiles->file_name)) {
						@unlink($this->_upload_path.$newsfiles->file_name);
						$this->file->delete($newsfiles->id);
					}
					if (is_readable($this->_upload_path.$newsfilefiles->file_name)) {
						@unlink($this->_upload_path.$newsfilefiles->file_name);
						$this->news_files->delete($newsfilefiles->id);
					}
					
				} 
				*/
				//$this->news_files->delete($this->id1);
				//$this->file->delete($this->id1);
				
				echo 1;
			}	
			else {
				echo 0;	
			}					
			
		} else {
			$this->request->redirect(ADMIN.$this->request->controller());
			//die();
		}

		exit();
    }
    
	
	/*** Function Access ***/
	
	// Action for update item status
	public function action_change() {
		
		if ($this->request->post('check') !='') {
			$rows	= $this->request->post('check');

			foreach ($rows as $row) {
				$this->news->id	= $row;

				if (!$this->news->load())
					continue;

				$this->news->status	= $this->request->post('select_action');
				$this->news->update();
			}

			$redirect_url	= (strstr($this->acl->previous_url,ADMIN)) ? $this->acl->previous_url : ADMIN.$this->_class_name.'/index';

			$this->request->redirect($redirect_url);
			
		} else {
			
			$this->request->redirect(ADMIN.$this->_class_name);
			
		}
		
	}
	
	public function action_check_name() {
		
		$name_check =  $this->news->load_by_name($_POST['name']);
		
		$result = !empty($name_check) ? 1 : 0;
		
		echo $result;
		
		exit;
	}
	
	public function action_check_title(){
		$title = $_GET['hash'];
		$where_cond = array('title'=>$title);
		$title_check = $this->news->find($where_cond);
		$title_check = !empty($title_check) ? 1 : 0;
		echo $title_check;
		exit;
	}
	
	public function _valid_search_key (Validation $array, $field) {
		if (!isset($this->_search_keys)) {
			$array->error($field, 'invalid_search_key');
			return;
		}

		$keys = array_keys($this->_search_keys);

		if (!in_array($array[$field], $keys))
			$array->error($field, 'invalid_search_key');
	}
  
	/** CALLBACKS **/  
    
    public function _unique_title (Validation $array, $field) {
		if (!isset($array[$field]))
			return;
		
		$title = Model_News::instance()->find_count(array('title' => $array[$field]));
		
		if ($title)
			return $array->error($field, 'unique_title');
	}

	//public function after() {
		//parent::after();
	//}
} // End Event
