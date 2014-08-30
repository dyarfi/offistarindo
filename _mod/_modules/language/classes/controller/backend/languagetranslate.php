<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_LanguageTranslate extends Controller_Themes_DefaultAdminBlank {
    
    protected $id1; 
	protected $id2; 
	protected $id3;
    protected $id4;
	
	public function before () {
		// Get parent before method
        parent::before();

		$this->user			= new Model_User;
		
        $this->id1 = Request::$current->param('id1');
        $this->id2 = Request::$current->param('id2');
        $this->id3 = Request::$current->param('id3');
		$this->id4 = Request::$current->param('id4');
		$this->id5 = Request::$current->param('id5');
		
		$this->_class_name		= Request::$current->controller();
		$this->_module_name		= 'language';	
		$this->_module_menu		= $this->acl->module_menu;
		
		$this->_prefs			= (Lib::config($this->_class_name.'.'.$this->_class_name.'_fields') !== NULL) ? Lib::config($this->_class_name.'.'.$this->_class_name.'_fields') : array();
		
		$this->language		    = new Model_Language;
		$this->translation		= new Model_Translation;

		$this->statuses			= array(1=>'publish',0=>'unpublish');
		
		$this->_search_keys		= array('name' => 'Name', 'prefix' => 'Prefix');		
    }
	
	public function action_index() { }
	
	public function action_add() {
		
		//print_r($_POST);
		
		$table = Model_TranslationTable::instance()->load($_POST['table_id'])->table_translate;
		
		//print_r($table);
		
		$table_fields	= Lib::config($table)->translate;		
		$_translate_fields = array_keys(Lib::config($table)->translate);
		
			foreach ($_POST['detail'] as $details) {
				$i = 0;
				foreach ($_translate_fields as $_fields) {			
					$params[$i] = array(
									'language_id'=>$details['language_id'],
									'table_id'=>$_POST['table_id'],						
									'field_id'=>$_POST['field_id'],
									'field'=>$_fields,
									'content'=>$details[$_fields]
								);
					$id[$i]	= $this->translation->add($params[$i]);
				$i++;
				}
				//print_r($params);
			}
			
		/*
		$params			= array('banner_id'	=> $id,
								'field_name'	=> $row_name,
								'file_name'		=> $file_data['basename'],
								'file_type'		=> $file_mime,
								'caption'		=> isset($fields[$row_name.'_caption']) ? $fields[$row_name.'_caption'] : '',
								'description'	=> isset($fields[$row_name.'_description']) ? $fields[$row_name.'_description'] : '');
		//$this->file->add($params);
		*/
		
		
		exit;
		
	}
	
	public function action_translate() {
		
		// Return if false if params not exists
		if (empty($this->id1) && empty($this->id2)) {
			return false;
		}
		
		// language_data
		$language_data = $this->language->find(array('status'=>'1','default !='=>'1'));
		
		// Model to translate
		$model	= $this->id1;		
		
		// Field Id to translate		
		$field_id	= $this->id2;
		
		// Get Class Name from String
		$class	= "Model_".$model;
		$object = new $class;
		$object->id = $field_id;

		if(!$object->load()) {
			$this->session->set('result','No content to translate');
			return false;
		}

		$table = Model_TranslationTable::instance()->load_by_table_translate($model);
		
		if(empty($table)) {
			$this->session->set('result','No content to translate');
			return false;
		}
		
		$table_fields		= Lib::config($model)->translate;				
		$_translate_fields = array_keys(Lib::config($model)->translate);

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST) {

			// Translation Update
			$translation = new Model_Translation;

			// Set data to compile
			$params = array();

			if (!empty($_POST['detail'])) {
				foreach($_POST['detail'] as $detail) {	
					$s = 0;	
					foreach ($_translate_fields as $_fields) {				
						if (!empty($detail[$s]['id'])) {
							$translation->id = $detail[$s]['id'];
							$translation->load();
							$translation->field = $_fields;
							$translation->content = $detail[$s][$_fields];
							$translation->update();
						} else {							
							$params = array(
								//'id'			=> $col['id'],
								'language_id'	=> $detail[$s]['language_id'],
								'table_id'		=> $_POST['table_id'],						
								'field_id'		=> $_POST['field_id'],
								'field'			=> $_fields,
								'content'		=> $detail[$s][$_fields]
							);
							$translate = $translation->add($params);							
						}
						$s++;							
					}					
				}					
				//$this->session->set('result','Success');
			}
			//$this->request->redirect($this->request->current()->uri());


			/*
			if ($post->check()) {
				$fields	= $post->as_array();

				$params	= array('name'		=> $fields['prefix'],
								'prefix'	=> Inflector::underscore($fields['prefix']),
								'status'	=> $fields['status']);

				$id		= $this->language->add($params);

				if (isset($fields['add_another'])) {
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
			* 
			*/
		} 

		// Content detail for language based on category id within language ids
		$_detail_data		= $this->translation->find(array('table_id' => $table->id, 'field_id'=>$field_id, 'language_id IN' => Lang::_get_lang()));
		$buffers = array();
		$params = array();

		foreach($_detail_data as $data){	
			$k=0;
			foreach ($_translate_fields as $_fields) {			
				if ($_fields == $data->field) {
					$params[$data->language_id][$k] = array(
						'id'=>$data->id ? $data->id : '',
						'language_id'=>$data->language_id,
						'table_id'=>$data->table_id,						
						'field_id'=>$data->field_id,
						'field'=>$_fields,
						'content'=>$data->content
					);
				}
				$k++;
			}
			$buffers = $params;

		}

		$detail_data = $buffers;

		//exit;

		
		/** Views **/

		$content_vars		= array(//'errors'	=> $errors,
									//'fields'	=> $fields,
									//'statuses'	=> $this->statuses,
									'object'		=> $object,
									'detail_data'	=> $detail_data,
									'table_fields'	=> $table_fields,
									'table_id'		=> $table->id,
									'field_id'		=> $field_id,
									'language_data'	=> $language_data,
									'class_name' 	=> $this->_class_name,
									'module_name' 	=> $this->_module_name,
									'module_menu'	=> $this->_module_menu);
		
		$content_vars		= array_merge($content_vars, $this->_prefs);
		
		$content			= View::factory($this->_module_name.'/backend/'.$this->_class_name.'_form');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->content		= $content; 
		
		// Set layout auto render to true
		// $this->auto_render = true;
	}
	    
} // End Language
