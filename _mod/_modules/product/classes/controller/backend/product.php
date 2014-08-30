<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Backend_Product extends Controller_Backend_BaseAdmin {
	protected $_module_name;
	protected $_class_name;
	protected $_search_keys;
	protected $_prefs;
	protected $_upload_path;
	protected $page;
	protected $category;
	protected $categories;
	protected $file;
	protected $statuses;
	
	public function before () {
		parent::before();
		$category				= new Model_ProductCategory;
		$file					= new Model_ProductFile;
		$categories				= $category->find_detail();
		$buffers				= array();
		
		$this->_module_name		= 'product';
		$this->_class_name		= strtolower(Request::$current->controller());

		$this->_module_menu		= $this->acl->module_menu;
		$this->_search_keys		= array('title'			=> 'Title',
										'category_id'	=> 'Category',
										'status'		=> 'Status');
		$this->_prefilter_keys	= array('category_id');
		$this->_prefs			= (Lib::config($this->_module_name.'.'.$this->_class_name.'_fields') !== NULL) ? Lib::config($this->_module_name.'.'.$this->_class_name.'_fields') : array();
		$this->_upload_path		= (Lib::config($this->_module_name.'.upload_path') !== NULL) ? Lib::config($this->_module_name.'.upload_path') : array();
		$this->_upload_url		= (Lib::config($this->_module_name.'.upload_url') !== NULL) ? Lib::config($this->_module_name.'.upload_url') : array();
		$this->product			= new Model_Product;
		$this->productcontent	= new Model_ProductContent;
		$this->category			= new Model_ProductCategory;
		$this->file				= new Model_ProductFile;
		$this->user				= new Model_User;
		foreach ($categories as $row) {
			$buffers[$row->id]	= $row;
		}
		$this->categories		= $buffers;
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
		$this->statuses			= array('publish',
										'unpublish');

		unset($category, $categories, $buffers);
	}
	
	public function action_index () {
		$category_id		= !empty($this->id1) ? $this->id1 : '';
		$this->category->id	= $category_id;
		if ($category_id != '' && !$this->category->load())
			$category_id	= '';
		$where_cond	= array('status !='	=> 'deleted');
		if ($category_id != '')
			$where_cond['category_id']	= $category_id;
		/** Find & Multiple change status **/
		if ($_POST) {
			$post	= new Validation($_POST);
			if (isset($post['field']) || isset($post['keyword'])) {
				$post->rule('keyword', 'regex', array(':value', '/^[a-z_.\-]++$/iD'));
				if ($post->check()) {
					if (!in_array($post['field'], $this->_prefilter_keys))
						$where_cond[$post['field'] . ' LIKE']	= $post['keyword'].'%';
					else
						$where_cond[$post['field'] . ' IN']	= call_user_func(array($this, '_'.$post['field']), $post['keyword']);
					$filters	= array('f'	=> $post['field'],
										'q'	=> $post['keyword']);
					$this->session->set($this->_class_name.'_filter', serialize($filters));
				} else if (isset($post['find'])) {
					$this->session->delete($this->_class_name.'_filter');
				}
			}
			if ($this->session->get($this->_class_name.'_filter') !== FALSE) {
				$filters	= unserialize($this->session->get($this->_class_name.'_filter'));
				if (in_array($filters['f'], array_keys($this->_search_keys)) && $filters['q'] != '') {
					if (!in_array($filters['f'], $this->_prefilter_keys))
						$where_cond[$filters['f'] . ' LIKE']	= $filters['q'].'%';
					else
						$where_cond[$filters['f'] . ' IN']	= call_user_func(array($this, '_'.$filters['f']), $filters['q']);
				}
			}
		}
		/** Table sorting **/
		$params		= Request::$current->param();		
		$sorts		= array('asc', 'desc');		
		$sort		= isset($params['id2']) ? $this->id2 : 'order';
		$order		= isset($params['id4']) ? $this->id4 : $sorts[0];
		$order_by	= array('category_id'=>'desc',$sort => $order);
		$page_index	= isset($_GET['page']) ? $_GET['page'] - 1: 0;
		$per_page	= Lib::config('admin.item_per_page');	
		//$per_page	= 10;
		$page_url	= isset($_GET['page']) ? '?page='.$_GET['page'] : '';
		$offset		= ($page_index == 0) ? '' : $page_index * $per_page;
		$table_headers	= array('title'		=> 'Title',
								'top_brand'		=> 'Top Brand',
								'order'			=> 'Order',								
								'category_id'	=> 'Category',
								'status'		=> 'Status',
								'added'			=> 'Added',
								'modified'		=> 'Modified');
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
		$field		= isset($filters['f']) ? $filters['f'] : '';
		$keyword	= isset($filters['q']) ? $filters['q'] : '';
		$where_cond	= isset($where_cond) ? $where_cond : '';
		$total_rows	= count($this->product->find($where_cond));
		$total_record 	= $total_rows;
		$listings	= $this->product->find($where_cond, $order_by, $per_page, $offset);
		$pagination	= Pagination::factory(array(
				'total_items' 		=> $total_rows,
				'items_per_page' 	=> $per_page,
			 ));		
		// List Product Detail collection
		$detail_data = $this->productcontent->find(array('lang_id' => Lang::_default()));
		$buffers = array();
		foreach($detail_data as $data){
			$buffers[$data->product_id] = $data;
		}
		$detail_data = $buffers;				
		/** Views **/
		$content_vars		= array('detail_data'	=> $detail_data,
									'language_data' => $this->language_data,
									'listings'		=> $listings,
									'table_headers'	=> $table_headers,
									'statuses'		=> $this->statuses,
									'search_keys'	=> $this->_search_keys,
									'module_name'	=> $this->_module_name,
									'class_name'	=> $this->_class_name,
									'module_menu'	=> $this->_module_menu,
									'total_record'	=> $total_record,			
									'field'			=> $field,
									'keyword'		=> $keyword,
									'order'			=> $order,
									'set_order'		=> $this->product,
									'sort'			=> $sort,
									'page_url'		=> $page_url,
									'page_index'	=> $offset,
									'params'		=> $params,
									'pagination'	=> $pagination,
									'categories'	=> $this->categories,
									'category_id'	=> $category_id);
		$content			= View::factory($this->_module_name.'/backend/'.$this->_module_name.'_index');
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		$this->template->content		= $content; 
	}
	
	public function action_add () {
		$category_id = $this->id1;
		$fields	= array('title'				=> '',
						'category_id'		=> '',
						'top_brand'			=> '',						
						'media'				=> '',
						'order'				=> '',
						'status'			=> '');
		if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
			foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
				$fields[$row_name]	= '';
				if (isset($row_params['caption']) && $row_params['caption'])
					$fields[$row_name.'_caption']	= '';
			}
		}
		$errors	= $fields;
		$fields['category_id']	= $category_id;
		if ($_POST) {			
			$_POST['media'] = !empty($_POST['_media']) ? $_POST['_media'] : $_POST['media'];
			if ($_FILES)
				$post	= new Validation(array_merge($_POST, $_FILES));
			else
				$post	= new Validation($_POST);
			
			$post->rule('title', 'not_empty');			
			$post->rule('title', array($this, '_unique_title'), array(':validation', ':field', 'title'));
			$post->rule('order', 'regex', array(':value','/^[1-9]/'));
			
			if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
				foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
					//if (isset($row_params['optional']) && !$row_params['optional']) {
						/*$post->add_rules($row_name, 'upload::required');*/
						//$post->add_rules($row_name, 'upload::valid');
					//}
					//if (isset($row_params['file_type']))
						//$post->add_rules($row_name, 'upload::type['.$row_params['file_type'].']');
					//if (isset($row_params['max_file_size']))
						//$post->add_rules($row_name, 'upload::size['.$row_params['max_file_size'].']');
				}
			}
			if ($post->check()) {
				$fields	= $post->as_array();				
				$params	= array('title'		=> $fields['title'],
								'category_id'	=> $fields['category_id'],
								'top_brand'		=>  !empty($fields['top_brand']) ? $fields['top_brand'] : '',								
								'media'		=> htmlentities($fields['media']),
								'order'		=> !empty($fields['order']) ? $this->_checking_order($fields['order'],'',$fields['category_id']) : $this->product->set_order($fields['category_id'],'','MAX') + 1,
								'user_id'	=> (isset($this->acl->user->id)) ? $this->acl->user->id : 0,
								'status'	=> $fields['status']);
			
				$id		= $this->product->add($params);
				
				$params2 = array();				
				foreach($post['detail'] as $detail) {					
					$params2[]	= array(
										'product_id'	=> !empty($id) ? $id : 0,
										'lang_id'	=> $detail['lang_id'],
										'subject'	=> $detail['subject'],
										'text'		=> $detail['text'],
										'overview'		=> $detail['overview'],
										'features'		=> $detail['features'],
										'specification'	=> $detail['specification'],
								
								);
				}				
				foreach ($params2 as $row => $val) {
					$this->productcontent->add($val);
				}
				
				if ($id !== FALSE && isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
					foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
						//if (!upload::required($_FILES[$row_name]) || !upload::valid($_FILES[$row_name]))
							//continue;
						if (!Upload::not_empty($_FILES[$row_name]) || !Upload::type($_FILES[$row_name],explode(',',$row_params['file_type'])) || !Upload::valid($_FILES[$row_name]))
							continue;
						if (!File::exts_by_mime($post[$row_name]['type']))
							continue;
						$file_hash	= md5(time() + rand(100, 999));
						$file_data	= pathinfo($_FILES[$row_name]['name']);
						$file_name	= Lib::_upload_to($post[$row_name], $file_hash.'.'.$file_data['extension'], $this->_upload_path, 0755);
						$file_data	= pathinfo($file_name);
						$file_mime	= $_FILES[$row_name]['type'];
						if ($file_name != '' && isset($this->_prefs['uploads'][$row_name]['image_manipulation'])) {
							$params			= array('product_id'	=> $id,
													'field_name'	=> $row_name,
													'file_name'		=> $file_data['basename'],
													'file_type'		=> $file_mime,
													'caption'		=> isset($fields[$row_name.'_caption']) ? $fields[$row_name.'_caption'] : '');
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
		$orders				= $this->product->find_count();
		$content_vars		= array('language_data' => $this->language_data,
									'errors'		=> $errors,
									'fields'		=> $fields,
									'categories'	=> $this->categories,
									'orders'		=> $orders,
									'statuses'		=> $this->statuses,
									'class_name'	=> $this->_class_name,
									'module_name' 	=> $this->_module_name,
									'module_menu'	=> $this->_module_menu);
		$content_vars		= array_merge($content_vars, $this->_prefs);
		$content			= View::factory($this->_module_name.'/backend/'.$this->_module_name.'_add');
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		$this->template->content		= $content; 
	}
	
	public function action_view () {
			
		$this->template->css	= array('jPlayer/jplayer.blue.monday.css'=>'all');
		$this->template->js		= array('library/jPlayer/jquery.jplayer.min.js');
			
		$id = $this->id1;
		$category_id = $this->id2;
		$this->product->id	= $id;
		if (!$this->product->load()) {
			$this->request->redirect(ADMIN.$this->_class_name.'/error/invalid_request');
			return;
		}
		/** Views **/
		if ($this->product->category_id != 0) {
			$category		= $this->category->load($this->product->category_id);
			$category		= HTML::chars(@$category->title, TRUE);
		} else {
			$category		= 'This page doesn\'t have category';
		}
		if ($this->product->order == 0) {
			$order			= '-';
		} else if ($this->product->order != 1) {
			$where_cond		= array('category_id'	=> $this->product->category_id,
									'order'			=> ($this->product->order - 1));
			$pages		= $this->product->find_detail($where_cond, '', 1);
			if (isset($pages[0]))
				$order		= 'After category '.HTML::chars(@$pages[0]->subject, TRUE);
			else
				$order		= '';
		} else {
			$order			= 'At the beginning';
		}
		$where_cond			= array('product_id'	=> $this->product->id);
		$files				= $this->file->find($where_cond);
		$buffers			= array();
		foreach ($files as $row) {
			$buffers[$row->field_name]	= $row;
		}
		$files				= $buffers;
		unset($buffers);
		
		// List Product Detail collection
		$detail_data = $this->productcontent->find(array('lang_id IN' => Lang::_get_lang(),'product_id'=>$this->product->id));
		$buffers = array();
		foreach($detail_data as $data){
			$buffers[$data->lang_id] = $data;
		}
		$detail_data = $buffers;
				
		/** Generate Thumbnails **/
		Lib::_auto_image_manipulation($this->_upload_path, $this->file, $this->_prefs);
		/** Views **/
		$content_vars		= array('language_data'	=> $this->language_data,
									'detail_data'	=> $detail_data,
									'product'		=> $this->product,
									'category'		=> $category,
									'files'			=> $files,
									'order'			=> $order,
									'category_id'	=> $category_id,			
									'upload_path'	=> $this->_upload_path,
									'upload_url'	=> $this->_upload_url,	
									'module_name'	=> $this->_module_name,			
									'class_name'	=> $this->_class_name,
									'module_menu'	=> $this->_module_menu,
									'readable_mime'	=> Lib::config($this->_module_name.'.readable_mime'),
									);
		
		$content_vars		= array_merge($content_vars, $this->_prefs);
		$content			= View::factory($this->_module_name.'/backend/'.$this->_module_name.'_view');
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		$this->template->content		= $content; 
	}
	
	public function action_edit () {
		$id = $this->id1;
		$category_id = $this->id2;
		$this->product->id	= $id;
		if (!$this->product->load()) {
			$this->request->redirect(ADMIN.$this->_class_name.'/error/invalid_request');
			return;
		}
		$fields	= array('title'			=> '',
						'category_id'	=> '',
						'top_brand'		=> '',						
						'media'			=> '',					
						'order'			=> '',
						'status'		=> '');
		if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
			foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
				$fields[$row_name]	= '';
				if (isset($row_params['caption']) && $row_params['caption'])
					$fields[$row_name.'_caption']	= '';
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
			$post->rule('title', 'min_length', array(':value', 2));			
			$post->rule('order', 'regex', array(':value','/^[1-9]/'));
			
			if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
				foreach ($this->_prefs['uploads'] as $row_name => $row_params) {
					if (!File::exts_by_mime($post[$row_name]['type']))
						continue;	
				}
			}
			$fields['category_id'] = (empty($fields['category_id'])) ? '0' : $fields['category_id'];
			$fields['order'] = (empty($fields['category_id'])) ? '0' : $fields['order'];
			
			if ($post->check()) {
				$fields	= $post->as_array();				
				$params	= array('title'			=> $fields['title'],
								'category_id'	=> $fields['category_id'],								
								'top_brand'		=> !empty($fields['top_brand']) ? $fields['top_brand'] : '',
								'media'			=> $fields['media'],
								'order'			=> ($post['current_cid'] != $fields['category_id']) 
														? $this->product->set_order($fields['category_id'],'','MAX') + 1
															: $this->_checking_order($fields['order'],$id,$fields['category_id']),
								'status'		=> $fields['status']);
				foreach ($params as $var => $val) {
					$this->product->$var	= $val;
				}
				$this->product->update();
				$params2 = array();
				foreach($fields['detail'] as $detail) {					
					$params2[$detail['lang_id']]	= array(
										'id'			=> !empty($detail['id']) ? $detail['id'] : '',
										'product_id'	=> $this->product->id,						
										'lang_id'		=> $detail['lang_id'],
										'subject'		=> $detail['subject'],
										'text'			=> $detail['text'],
										'overview'		=> $detail['overview'],
										'features'		=> $detail['features'],
										'specification' => $detail['specification']
									);
				}
				foreach ($params2 as $row => $val) {
					if (!empty($row) && !empty($val['subject']) && !empty($val['id'])) {
						$this->productcontent->id			= $val['id'];
						$this->productcontent->product_id	= $val['product_id'];
						$this->productcontent->lang_id		= $val['lang_id'];
						$this->productcontent->subject		= $val['subject'];
						$this->productcontent->text			= $val['text'];
						$this->productcontent->overview			= $val['overview'];												
						$this->productcontent->features			= $val['features'];												
						$this->productcontent->specification	= $val['specification'];						
						$this->productcontent->update();
					} else {
						$this->productcontent->add($val);
					}
				}	
				if (isset($this->_prefs['show_upload']) && $this->_prefs['show_upload'] && isset($this->_prefs['uploads'])) {
					$where_cond			= array('product_id'	=> $this->product->id);
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
						$file_hash	= md5(time() + rand(100, 999));
						$file_data	= pathinfo($post[$row_name]['name']);
						$file_name	= Lib::_upload_to($post[$row_name], $file_hash.'.'.$file_data['extension'], $this->_upload_path, 0755);
						$file_data	= pathinfo($file_name);
						$file_mime	= $post[$row_name]['type'];
						if (!isset($files[$row_name])) {
							$params			= array('product_id'	=> $id,
													'field_name'	=> $row_name,
													'file_name'		=> $file_data['basename'],
													'file_type'		=> $file_mime,
													'caption'		=> isset($fields[$row_name.'_caption']) ? $fields[$row_name.'_caption'] : '');
							$this->file->add($params);
						} else {
							$this->file->id	= $files[$row_name]->id;
							$this->file->load();
							$params			= array('product_id'	=> $id,
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
				if ($category_id != '')
					$this->request->redirect(ADMIN.$this->_class_name.'/view/'.$this->product->id.'/'.$category_id);
				else
					$this->request->redirect(ADMIN.$this->_class_name.'/view/'.$this->product->id);
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
			$fields	= array('title'			=> $this->product->title,
							'category_id'	=> $this->product->category_id,							
							'top_brand'		=> $this->product->top_brand,	
							'media'			=> $this->product->media,							
							'order'			=> $this->product->order,
							'status'		=> $this->product->status);			
		}
		
		$where_cond			= array('product_id'	=> $this->product->id);
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
				
		// Product detail for language based on content id within language ids
		$detail_data	= $this->productcontent->find(array('id !='=>'0','product_id' => $this->product->id,'lang_id IN'=>Lang::_get_lang()));
		$buffers = array();
		foreach($detail_data as $data){
			$buffers[$data->lang_id] = $data;
		}
		$detail_data = $buffers;
		
		/** Views **/
		$orders				= $this->product->find_count();
		$content_vars		= array('language_data'	=> $this->language_data,
									'detail_data'	=> $detail_data,
									'errors'		=> $errors,
									'fields'		=> $fields,			
									'class_name'	=> $this->_class_name,
									'module_name'	=> $this->_module_name,
									'module_menu'	=> $this->_module_menu,
									'product'		=> $this->product,
									'categories'	=> $this->categories,
									'upload_path'	=> $this->_upload_path,
									'upload_url'	=> $this->_upload_url,	
									'files'			=> $files,
									'orders'		=> $orders,
									'statuses'		=> $this->statuses,
									'readable_mime'	=> Lib::config($this->_module_name.'.readable_mime'),
									'category_id'	=> $category_id);
		$content_vars		= array_merge($content_vars, $this->_prefs);
		$content			= View::factory($this->_module_name.'/backend/'.$this->_module_name.'_edit');
		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		$this->template->content		= $content;
	}
	
	// Action for ordering item list
	public function action_order() {
		if (empty($this->id2) && empty($this->id3))
			continue;
			
		if ($this->request->is_ajax()) {
			if ($this->id1 == 'down' && $this->id2 && $this->id3) {

				$where_cond = ($this->id4) ? array('order'=>$this->id3 + 1,'category_id'=>$this->id4) : array('order'=>$this->id3 + 1,'category_id'=>$this->id4);
				$order_by   = array('order'=>'asc');

				$order_default = $this->product->find($where_cond,$order_by,1);

				if (!empty($order_default)) {
					foreach ($order_default as $default) {
						$default->order  = ($default->order != $this->product->set_order($default->category_id,'','MIN')) ? $default->order - 1 : 0;
						$default->update();
					}				
					$this->product->id = $this->id2;
					$this->product->load();
					$this->product->order = $this->id3 + 1;
					$this->product->update();
				}
			} else
			if ($this->id1 == 'up' && $this->id2 && $this->id3) {
				$where_cond = array('order'=>$this->id3-1, 'category_id'=>$this->id4);
				$order_by	= array('order'=>'asc');

				$order_default = $this->product->find($where_cond,$order_by);

				if (!empty($order_default)) {
					foreach ($order_default as $default) {
						$default->order  = ($default->order != $this->product->set_order($default->category_id,'','MAX')) ? $default->order + 1 : 1;
						$default->update();
					}				
					$this->product->id = $this->id2;
					$this->product->load();
					$this->product->order = $this->id3 - 1;
					$this->product->update();				
				}
			}
		}
		if ($this->request->is_ajax()) {
			echo $this->id2;
			exit();
		}
	
		$this->request->redirect(ADMIN.$this->_class_name);		
	}

	public function action_delete () {
		// This is used for only Ajax Request		
		if ($this->request->is_ajax()) {
			$this->product->id	= $this->id1;
			if (!$this->product->load()) {
				$this->request->redirect(ADMIN.$this->_class_name.'/error/invalid_request');
				return;
			}

			$id = $this->product->id;		
			$category_id = $this->product->category_id;
			if($this->product->delete($this->id1)) {
				// This is to reset all order
				$update_order = $this->product->find(array('id !='=>$id,'category_id'=>$category_id),array('order'=>'asc'));
				$i=1;
				foreach ($update_order as $order) {
					$order->order = $i;
					$order->update();
					$i++;
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
	
	public function action_download() {
		$files		= $this->id1;
		$where_cond	= array('file_name'	=> $files);
		$files		= $this->file->find($where_cond);
		foreach ($files as $row) {
			Lib::_download(Lib::config($this->_module_name.'.upload_url').$row->file_name);
		}
	}
	
	/*** Function Access ***/
	// Action for update item status
	public function action_change() {
		if ($this->request->post() && $this->request->post('check') !='') {
			$rows	= $this->request->post('check');
			foreach ($rows as $row) {
				$this->product->id	= $row;
				if (!$this->product->load())
					continue;
				$this->product->status	= $this->request->post('select_action');
				$this->product->update();
			}
			$redirect_url	= (strstr($this->acl->previous_url,ADMIN)) ? $this->acl->previous_url : ADMIN.$this->_class_name.'/index';
			$this->request->redirect($redirect_url);
		} else {
			$this->request->redirect(ADMIN.$this->_class_name);
		}
	}
	
	// Get order from category id
	public function action_cid_order() {
		if ($this->request->is_ajax() && $_SERVER['REQUEST_METHOD'] === 'POST'){
			
			$max_order = $this->product->set_order($_POST['cid'],'','MAX');
			if (!empty($_POST['order']) 
					&& empty($_POST['current_cid'])
						&& empty($_POST['cid'])) {
				echo $max_order;
			} else if (!empty($_POST['pid']) && !empty($_POST['current_cid']) 
						&& !empty($_POST['order']) && $_POST['current_cid'] == $_POST['cid']) {
				echo $this->product->load($_POST['pid'])->order;
			}
			else {
				echo $max_order + 1;
			}
				
		}
		exit;
	}
	
	// Set top brand product
	public function action_top_brand() {
		if ($this->request->is_ajax() && $_SERVER['REQUEST_METHOD'] === 'POST'){		
			$this->product->id = $_POST['id'];		
			$this->product->load();
			$this->product->top_brand = $_POST['value'];			
			echo $this->product->update() ? 1 : 0;
		}	
		exit;
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
	
	public function _unique_title (Validation $array, $field) {
		if (isset($this->product->title) && $this->product->title == $array[$field])
			return;
		$where_cond		= array('title'	=> $array[$field]);
		$title_exists	= ($this->product->find_count($where_cond) != 0);
		if ($title_exists)
			$array->error($field, 'title_exists');
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
		$where_cond	= array('title LIKE'	=> '%'.$value.'%',
							'status !='	=> 'deleted');
		$buffers	= $this->category->find($where_cond);
		$ids		= array();
		foreach ($buffers as $row) {
			$ids[]	= $row->id;
		}
		return $ids;
	}
	
	public function _checking_order($order='',$id='', $cid='') {
		if (empty($order)) return;
			
		$max = $this->product->set_order($cid,'','MAX');
		if (empty($id)) {

			$db_orders = $this->product->find(array('order'=>$order,'category_id'=>$cid));

			if (!empty($db_orders) && count($db_orders) == 1) {
				$db_altered = $this->product->load($db_orders[0]->id);
				$db_altered->order = $max + 1;
				$db_altered->update();
			}	
			return $order >= $max ? $max + 1 : $order;			

		} else {
			$db_orders = $this->product->find(array('order'=>$order,'category_id'=>$cid));
			$db_default	= $this->product->load($id);
			$_temp = $db_default->order;
						
			if (!empty($db_orders) && count($db_orders) == 1) {				
				$db_altered = $this->product->load($db_orders[0]->id);
				$db_altered->order = $_temp;
				$db_altered->update();
			}	
			
			return $order >= $max ? $db_default->order : $order;	

		}
	}
}
