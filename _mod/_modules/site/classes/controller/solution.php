<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Solution extends Controller_Themes_Default {
	protected $page_category;
	protected $category_file;
	protected $id1;
	protected $id2;
	protected $id3;
	protected $id4;

	public function before () {
		parent::before();
        
        $this->id1 = $this->request->param('id1');
        $this->id2 = $this->request->param('id2');
        $this->id3 = $this->request->param('id3');
		$this->id4 = $this->request->param('id4');
        
		// Load necessary Model
		$this->page_category	= new Model_PageCategory;
		$this->category_files	= new Model_PageCategoryFile;
		
		$this->pages			= new Model_Page;
		$this->files			= new Model_PageFile;
		
		$this->solution_category	= new Model_SolutionCategory;
		$this->solution				= new Model_Solution;
		
		$this->solution_category_file	= new Model_SolutionCategoryFile;
		$this->solution_file			= new Model_SolutionFile;		
		
		// Load Config
		$this->_config	= Lib::config('solution');
		
		// Page Fields Config
		$this->category_fields	= $this->_config->solution_fields;
		
		// Upload Path Config
		$this->category_upload_path	= $this->_config->category_upload_path;
		
		// Upload Url Config
		$this->category_upload_url	= $this->_config->category_upload_url;
		
		// Page Fields Config
		$this->solution_fields	= $this->_config->solution_fields;
		
		// Upload Path Config
		$this->upload_path	= $this->_config->upload_path;
		
		// Upload Url Config
		$this->upload_url	= $this->_config->upload_url;
		
				
	}
    
	public function action_index () {
		
		// Solution Us Page Category -name || -category_id = about-us | 2
		$page_category	= ($this->page_category->find_detail(array('id'=>12,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>12,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'solution-package','status'=>'publish'));
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
		
		// Find all solution category in database
		$where_cond = array('status'=>'publish','parent_id'=>0);
		$order_by	= array('order'=>'desc');
		$solution_categories = $this->solution_category->find_detail($where_cond,$order_by);
		// Set Product Category Child
		$_child_category	= $this->solution_category->find_detail(array('status'=>'publish','parent_id !='=>0),array('order'=>'asc','added'=>'desc'));
		$buffers_child					= array();
		foreach ($_child_category as $_category_child) {
			$buffers_child[$_category_child->parent_id][] = $_category_child;
		}
		$child_category = $buffers_child;		
		unset ($buffers_child);		
		
		// Find all solutions in database
		$solutions		 = $this->solution->find_detail(array('status'=>'publish'));
		$_solution_files = $this->solution_file->find(); 
		
		$buffers = array();
		foreach ($_solution_files as $_files) {
			$buffers[$_files->solution_id] = $_files;
		}
		$solution_files = $buffers;
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'upload_path' => Lib::config('solution')->upload_path,
									'upload_url' => Lib::config('solution')->upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,
									'solution_categories' => $solution_categories,
									'solutions' => $solutions,
									'solution_files' => $solution_files,
									);

		$content			= View::factory('site/solution_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content		= $content; 
	}
	
	public function action_read () {
		
		// Load Page Category By ID = 12 : Solution Package
		$page_category	= ($this->page_category->find_detail(array('id'=>12,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>12,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'solution-package','status'=>'publish'));
	
		$category_files	= $this->category_files->find(array('category_id'=>!empty($page_category[0]->id) ? $page_category[0]->id : $page_category->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
				
		// Find all solution category in database
		$where_cond = array('status'=>'publish');
		$order_by	= array('order'=>'desc');
		$solution_categories = $this->solution_category->find_detail($where_cond,$order_by);
		
		// Find all solutions in database
		$solution		 = $this->solution->find_detail(array('title'=>$this->id1));
		//echo '<!--';
		//print_r($this->id1);
		//print_r($solution);
		//echo '-->';
		//exit;
		
		$_solution_files = $this->solution_file->find(array('solution_id'=>!empty($solution[0]->id) ? $solution[0]->id : $solution->id)); 
		
		$buffers = array();
		foreach ($_solution_files as $_files) {
			$buffers[$_files->solution_id] = $_files;
		}
		$solution_files = $buffers;
		
		$solution_category = $this->solution_category->find_detail(array('id'=>!empty($solution[0]->category_id) ? $solution[0]->category_id : $solution->category_id));
		
		/** Count Viewers **/

		$this->_count_viewers(!empty($solution[0]->id) ? $solution[0]->id : $solution->id);
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'upload_path' => Lib::config('solution')->upload_path,
									'upload_url' => Lib::config('solution')->upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,
									'solution_categories' => $solution_categories,
									'solution_category' => $solution_category,
									'solution' => $solution,
									'solution_files' => $solution_files,
									);

		$content			= View::factory('site/solution_detail_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		$this->template->content		= $content; 
	}
	
	public function action_category() { 
		
		// Load Page Category By ID = 12 : Solution Package
		$page_category	= ($this->page_category->find_detail(array('id'=>12,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>12,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'solution-package','status'=>'publish'));
		
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
				
		$solution_category = $this->solution_category->find_detail(array('title'=>$this->id1));		
		
		// Find all solution category in database
		$where_cond = array('status'=>'publish');
		$order_by	= array('order'=>'desc');
		$solution_categories = $this->solution_category->find_detail($where_cond,$order_by);		
		
		// Find all solutions in database
		$solutions		 = $this->solution->find_detail(array('category_id'=>$solution_category[0]->id,'status'=>'publish'));
		$_solution_files = $this->solution_file->find(); 
		
		$buffers = array();
		foreach ($_solution_files as $_files) {
			$buffers[$_files->solution_id] = $_files;
		}
		$solution_files = $buffers;
		
		/** Count Viewers **/

		//$this->_count_viewers($solution_category[0]->id);
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'upload_path' => Lib::config('solution')->upload_path,
									'upload_url' => Lib::config('solution')->upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,
									'solution_categories' => $solution_categories,
									'solution_category' => $solution_category,
									'solutions' => $solutions,
									'solution_files' => $solution_files,
									);

		$content			= View::factory('site/solution_category_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content		= $content; 		
	}
	
	protected function _count_viewers($id = '') {	
		if (!$id)
			return;
		
		$count = $this->solution->load($id);
		$count->count = $count->count + 1;
		$count->update();
	}	
}
