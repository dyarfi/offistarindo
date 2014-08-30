<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Api_Api extends Controller_Themes_DefaultApi {
	protected $id1;
	protected $id2;
	protected $id3;
	protected $id4;

	public function before () {
		parent::before();
        
        $this->id1 = Request::$current->param('id1');
        $this->id2 = Request::$current->param('id2');
        $this->id3 = Request::$current->param('id3');
		$this->id4 = Request::$current->param('id4');
        		
	}
    
	public function action_index () {

		$content_vars		= array();
		$content			= View::factory('themes/defaultapi');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}

		$this->template->content		= $content; 
	}
	
	public function action_productlookup () {
		$id = Request::$current->post('id');
		
		if ($id == '') {
			$this->request->redirect(URL::site());
			return;
		}
		
		// This is used for only Ajax Request		
		if ($this->request->is_ajax()) {
			
			// This setting is used for deleting all file included
			$products = Model_Product::instance()->find_detail(array('category_id'=>$id,'status'=>'publish'));
			if (!empty($products)) {
				$return = array();
				$i=0;
				foreach ($products as $product) {
					$return['products'][$i]['id']		= $product->id;
					$return['products'][$i]['subject']	= $product->subject;
					$i++;
				}
				echo json_encode($return);
			} else {
				echo 0;
			}	
			
		} else {
			$this->request->redirect(URL::site());
		}
		exit;				
	}	

}
