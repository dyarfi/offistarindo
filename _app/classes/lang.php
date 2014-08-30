<?php
class Lang {
	
	// Get language list data with PUBLISH status
	public static function _get_lang () {
		// Load language model
		//$language_id = Model_Language::instance()->find(array('status'=>1,'default !='=>1));
		$_langid = Model_Language::instance()->find(array('status'=>1));				
		
		$buffers_id = array();
		if (!empty($_langid)) {
			foreach($_langid as $id){
				$buffers_id[$id->id] = $id->id;
			}
		}
		$language_id	= $buffers_id;
		// Return valid ids 
		return $language_id;
	}

	// This function is to check all in content for default given language	
	public static function _check_lang ($prefix = '') {
		if (!empty($prefix)) {			
			$languages = Model_Language::instance()->load_by_prefix($prefix);
			
			$lang_id = $languages->id;
						
			$maintenance = FALSE;
			if (!empty($languages)) {
				foreach($languages as $language) {

					$check[1][$languages->id] = Model_ContentMenu::instance()->find(array('lang_id'=> $lang_id));
					$check[2][$languages->id] = Model_ContentPage::instance()->find(array('lang_id'=> $lang_id));
			
					if (empty($check[1][$languages->id])) {
						$maintenance = TRUE;
					} elseif (empty($check[2][$languages->id])) {
						$maintenance = TRUE;
					} elseif (empty($check[3][$languages->id])) {
						$maintenance = TRUE;
					} elseif (empty($check[4][$languages->id])) {
						$maintenance = TRUE;
					} else {
						$maintenance = FALSE;
					}
				}
			}
			//print_r($maintenance); exit();
			return $maintenance;
		}
	}
	
	public static function _lang_id ($prefix = '') {
		if (!empty($prefix)) {			
			$languages = Model_Language::instance()->load_by_prefix($prefix);
			
			$lang_id = $languages->id;
									
			return $lang_id;
		}
	}
	
	// This function is to check all in content for default language translate
	public static function _lang_data ($model = '', $model_data = '', $title = "", $title_id = "", $limit = '') {
		
		$_class		  = 'Model_' . $model; 
		$_data		  = new $_class;
		
		$_class_data  = 'Model_' . $model_data; 
		$_data_model  = new $_class_data;
		
		$_lang_id	  = self::_check_valid_langid(I18n::$lang);
		
		$_where_cond  = array('status'=>'1');
		$_where_cond  = !empty($title) ? array_merge(array('title'=>$title),$_where_cond) : $_where_cond;
		$_where_cond  = !empty($title_id) ? array_merge($title_id,$_where_cond) : $_where_cond;			
		
		$objects = $_data->find($_where_cond);
		
		if (count($objects) > 1 && $limit !== 1) {
			$buffer = array();
			foreach ($objects as $var) {					
				$var->text		  = $_data_model->load_by_lang($var->id, $_lang_id);			
				$buffer[$var->id] = $var;
			}		
			return $objects;			
		} else {	
			if (!empty($objects[0])) {
				$objects[0]->text = $_data_model->load_by_lang($objects[0]->id, $_lang_id);
				return $objects[0];
			} else {
				return $objects;
			}
		}
		
	}

	public static function _default() {
		// Language list data within PUBLISH status
		$language_data = Model::factory('language')->find(array('status'=>1,'default' => 1));
		$buffers = array();
		if(count($language_data) == 1) {
			$id = $language_data[0]->id;
		}
		
		//print_r($language_data);
		return $id;
	}	
	
	public static function _get_language() {
		// Language list data within PUBLISH status
		$language_data = Model::factory('language')->find(array('status'=>1,'id IN' => self::_get_lang()));
		$buffers = array();
		foreach($language_data as $data){
			$buffers[$data->id] = $data;
		}
		$language_data	= $buffers;
		
		return $language_data;
	}	
	// This function is to check all in content for default given language	
	/*
	public static function _check_valid_lang ($prefix = '') {
		if (!empty($prefix)) {			
			$languages = Model_Language::instance()->load_by_prefix(I18n::lang());
			
			$lang_id = $languages->id;
			
			$maintenance = FALSE;
			if (!empty($languages)) {
				foreach($languages as $language) {

					$check[1][$languages->id] = Model_ContentMenu::instance()->find(array('lang_id'=> $lang_id));
					$check[2][$languages->id] = Model_ContentPage::instance()->find(array('lang_id'=> $lang_id));
					$check[4][$languages->id] = Model_News::instance()->find(array('lang_id'=> $lang_id));

					// print_r($check); exit();
					if (empty($check[1][$languages->id])) {
						$maintenance = TRUE;
					} elseif (empty($check[2][$languages->id])) {
						$maintenance = TRUE;
					} elseif (empty($check[3][$languages->id])) {
						$maintenance = TRUE;
					} elseif (empty($check[4][$languages->id])) {
						$maintenance = TRUE;
					} else {
						$maintenance = FALSE;
					}
				}
			}
			//print_r($maintenance); exit();
			return $maintenance;
		}
	}
	 * 
	 */
	
}
?>
