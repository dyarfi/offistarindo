<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Company extends Controller_Themes_Default {
	protected $page_category;
	protected $category_file;
	
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
		
        // Load necessary Model
		$this->page_category	= new Model_PageCategory;
		$this->category_files	= new Model_PageCategoryFile;
		
		$this->pages			= new Model_Page;
		$this->files			= new Model_PageFile;
		
		// Load Config
		$this->_config	= Lib::config('page');
		
		// Page Fields Config
		$this->page_category_fields	= $this->_config->page_category_fields;
		
		// Upload Path Config
		$this->category_upload_path	= $this->_config->category_upload_path;
		
		// Upload Url Config
		$this->category_upload_url	= $this->_config->category_upload_url;
		
		// Page Fields Config
		$this->page_fields	= $this->_config->page_fields;
		
		// Upload Path Config
		$this->upload_path	= $this->_config->upload_path;
		
		// Upload Url Config
		$this->upload_url	= $this->_config->upload_url;
		
				
	}
    
	public function action_index () {
		
		$page_category	= ($this->page_category->find_detail(array('id'=>15,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>15,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'company','status'=>'publish'));
		
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
		
		// About Page ID
		$about_page	= $this->pages->find_detail(array('id'=>1,'status'=>'publish'),'',1);
		$files		= $this->files->find();
		
		$buffers = array();
		foreach ($files as $file){
			$buffers[$file->page_id] = $file;
		}
		$files = $buffers;
		unset($buffers);
				
		// Company Us About Pages
		$about_pages	= $this->pages->find_detail(array('category_id'=>$page_category[0]->id,'status'=>'publish'),array('order'=>'asc'));		
		
		// Others page in this category = 2
		$where_cond = array('id !='=>$about_page[0]->id,'category_id'=> $page_category[0]->id,'status'=>'publish');
		$order_by	= array('order'=>'asc');
		$about_pages_others = $this->pages->find($where_cond,$order_by,12);

		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'upload_path' => $this->upload_path,
									'upload_url' => $this->upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,
									'about_pages_others' => $about_pages_others,
									'about_page' => $about_page,
									'about_pages' => $about_pages,	
									'files' => $files,
									);

		$content			= View::factory('site/about_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content		= $content; 
	}
	
	public function action_read () {
				
		$page_category	= ($this->page_category->find_detail(array('id'=>15,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>15,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'company','status'=>'publish'));
		
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
		
		// Company Us Page = $this->id1, Category_Id = 2
		$about_page	= $this->pages->find_detail(array('title'=>$this->id1,'status'=>'publish'));
		
		$files		= $this->files->find();
		
		$buffers = array();
		foreach ($files as $file){
			$buffers[$file->page_id] = $file;
		}
		$files = $buffers;
		unset($buffers);
		
		// Others page in this category = 2
		$where_cond = array('id !='=>$about_page[0]->id,'category_id'=> $page_category[0]->id,'status'=>'publish');
		$order_by	= array('order'=>'asc');
		$about_pages_others = $this->pages->find_detail($where_cond,$order_by,12);
		
		// Company Us Page = 'tentang-pemulihan-tuhan', Category_Id = 2
		$about_pages	= $this->pages->find_detail(array('category_id'=>$page_category[0]->id,'status'=>'publish'),array('order'=>'asc'));		
		
		/** Count Viewers **/

		$this->_count_viewers($about_page[0]->id);
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'upload_path' => $this->upload_path,
									'upload_url' => $this->upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,
									'about_pages_others' => $about_pages_others,
									'about_page' => $about_page,
									'about_pages' => $about_pages,
									'files' => $files,
									);

		$content			= View::factory('site/about_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content		= $content;
	}
	
	public function action_newsevent(){
		
		if($this->id1 == 'read' && $this->id1 != '') {
			// Read news function
			$this->_read_news($this->id2);			
			return;
		}
		// Load Page Category By ID = 15 : Company
		$page_category	= ($this->page_category->find_detail(array('id'=>15,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>15,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'company','status'=>'publish')); 
		
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
		
		// Company Us Page 
		$about_page	= $this->pages->find_detail(array('title'=>'about-us','status'=>'publish'));
		$files		= $this->files->find();
		
		$buffers = array();
		foreach ($files as $file){
			$buffers[$file->page_id] = $file;
		}
		$files = $buffers;
		unset($buffers);
				
		// Company Us Page
		$about_pages	= $this->pages->find_detail(array('category_id'=>$page_category[0]->id,'status'=>'publish'),array('order'=>'asc'));
		
		// Others page in this category = 2
		$where_cond = array('id !='=>$about_page[0]->id,'category_id'=> $page_category[0]->id,'status'=>'publish');
		$order_by	= array('added'=>'desc');
		$about_pages_others = $this->pages->find_detail($where_cond,$order_by,12);
				
		// Format 2014-03-25 
		$where_cond_date = array();
		if ($this->id1 == 'current') {
			$where_cond_date = array('news_date <=' => date('Y-m-d'));
		} else if ($this->id1 == 'upcoming') {
			$where_cond_date = array('news_date >' => date('Y-m-d'));
		}
		
		$where_cond_news	= Arr::merge($where_cond_date,array('status'=>'publish'));
		$total_rows			= Model_News::instance()->find_count($where_cond_news);
		$order_by			= array('news_date'=>'desc');
		
		// Pagination
		
		$page_index	= isset($_GET['page']) ? $_GET['page'] - 1: 0;
		$per_page	= Lib::config('site.item_per_page');
		$per_page	= 4;
		$page_url	= isset($_GET['page']) ? '?page='.$_GET['page'] : '';
		$offset		= ($page_index == 0) ? '' : $page_index * $per_page;
		
		$_newsevent	= Model_News::instance()->find_detail($where_cond_news, $order_by, $per_page, $offset);
						
		/** Initialize pagination **/
		$pagination = Pagination::factory(array(
				'total_items' 		=> $total_rows,
				'items_per_page' 	=> $per_page,
			 )
		);
		
		$buffers = array();
		foreach ($_newsevent as $key) {
			$buffers[$key->id] = $key;
			//$buffers[$key->id]->file_name = '';
			if (!empty(Model_NewsFile::instance()->load_by_group($key->id)->file_name)) {
				$buffers[$key->id]->file_name = Model_NewsFile::instance()->load_by_group($key->id)->file_name;
			}
		}
		$newsevent = $buffers;
		unset($buffers);

		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'upload_path' => Lib::config('news')->upload_path,
									'upload_url' => Lib::config('news')->upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,
									'about_pages_others' => $about_pages_others,
									'about_page' => $about_page,
									'about_pages' => $about_pages,	
									'newsevent'=>$newsevent,			
									'pagination'	=> $pagination,
									//'files' => $files,
									);

		$content			= View::factory('site/newsevent_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content		= $content; 
	}
	
	protected function _read_news ($id) {
		// Load Page Category By ID = 15 : Company
		$page_category	= ($this->page_category->find_detail(array('id'=>15,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>15,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'company','status'=>'publish'));
		
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
		// Company Us Page = $this->id1, Category_Id = 2
		$newsevent	= Model_News::instance()->find_detail(array('title'=>$id,'status'=>'publish'));
		
		//$files		= Model_NewsFile::instance()->load_by_group($newsevent->id);
		$filesFile	= Model_NewsFilesFile::instance()->find(array('news_id'=>$newsevent[0]->id));
		
		// Company Us Page 
		$about_page	= $this->pages->find_detail(array('title'=>'about-us'));
		$files		= $this->files->find();
		
		$buffers = array();
		foreach ($files as $file){
			$buffers[$file->page_id] = $file;
		}
		$files = $buffers;
		unset($buffers);
		
		// Company Us Page
		$about_pages	= $this->pages->find_detail(array('category_id'=>$page_category[0]->id,'status'=>'publish'),array('order'=>'asc'));
		
		// Others page in this category = 2
		$where_cond = array('id !='=>$about_page[0]->id,'category_id'=> $page_category[0]->id,'status'=>'publish');
		$order_by	= array('order'=>'asc');
		$about_pages_others = $this->pages->find_detail($where_cond,$order_by,12);
		
		/** Count Viewers **/

		$this->_count_news_viewers($newsevent[0]->id);
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'upload_path' => Lib::config('news')->upload_path.'files/',
									'upload_url' => Lib::config('news')->upload_url.'files/',
									'page_category' => $page_category,
									'category_files' => $category_files,
									'about_pages_others' => $about_pages_others,
									'about_page' => $about_page[0],
									'about_pages' => $about_pages,	
									'newsevent' => $newsevent[0],
									'files' => $files,
									'filesFile'	=> $filesFile		
									);

		$content			= View::factory('site/newsevent_detail_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
				
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content		= $content; 
	}

	public function action_principal(){
		
		// Load Page Category By ID = 15 : Company
		$page_category	= ($this->page_category->find_detail(array('id'=>15,'status'=>'publish'),'',1)) 
							? $this->page_category->find_detail(array('id'=>15,'status'=>'publish'),'',1) 
								: $this->page_category->load_by_name(array('title'=>'company','status'=>'publish'),'',1);
		
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
		
		// Company About Page
		$about_page	= $this->pages->find_detail(array('id'=>1,'status'=>'publish'));
		$files		= $this->files->find();
		
		$buffers = array();
		foreach ($files as $file){
			$buffers[$file->page_id] = $file;
		}
		$files = $buffers;
		unset($buffers);
				
		// Company Us Page 
		$about_pages	= $this->pages->find_detail(array('category_id'=>$page_category[0]->id,'status'=>'publish'),array('order'=>'asc'));				
		// Others page in this category 
		$where_cond = array('id !='=>$about_page[0]->id,'category_id'=> $page_category[0]->id,'status'=>'publish');
		$order_by	= array('order'=>'asc');
		
		$about_pages_others = $this->pages->find_detail($where_cond,$order_by,12);

		$where_cond_res		= array('status'=>'publish');
		$total_rows			= Model_Reseller::instance()->find_count($where_cond_res);
		$order_by			= array('order'=>'asc');
		
		// Pagination
		
		$page_index	= isset($_GET['page']) ? $_GET['page'] - 1: 0;
		$per_page	= Lib::config('site.item_per_page');
		//$per_page	= 2;
		$page_url	= isset($_GET['page']) ? '?page='.$_GET['page'] : '';
		$offset		= ($page_index == 0) ? '' : $page_index * $per_page;
		
		$_reseller	= Model_Reseller::instance()->find_detail($where_cond_res, $order_by, $per_page, $offset);
		
				
		/** Initialize pagination **/
		$pagination = Pagination::factory(array(
				'total_items' 		=> $total_rows,
				'items_per_page' 	=> $per_page,
			 )
		);
		
		$buffers = array();
		foreach ($_reseller as $key) {
			$buffers[$key->id] = $key;
			$buffers[$key->id]->file_name = (!empty(Model_ResellerFile::instance()->load_by_group($key->id)->file_name))
						? Model_ResellerFile::instance()->load_by_group($key->id)->file_name
							: 'reseller-blank.jpg' ;
		}
		$reseller = $buffers;
		unset($buffers);
				
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'upload_path' => Lib::config('reseller')->upload_path,
									'upload_url' => Lib::config('reseller')->upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,
									'about_pages_others' => $about_pages_others,
									'about_page' => $about_page,
									'about_pages' => $about_pages,	
									'files' => $files,
									'principal' => $reseller,
									'pagination' => $pagination,
									);

		$content			= View::factory('site/principal_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content		= $content; 
	}
	
	
	public function action_testimonial(){
		if($this->id1 == 'read' && $this->id1 != '') {
			// Read news function
			$this->_read_testimonial($this->id2);			
			return;
		}
		// Load Page Category By ID = 15 : Company
		$page_category	= ($this->page_category->find_detail(array('id'=>15,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>15,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'company','status'=>'publish'));
		
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
		
		// About Us Page
		$about_page	= $this->pages->find_detail(array('id'=>1,'status'=>'publish'));
		$files		= $this->files->find();
		
		$buffers = array();
		foreach ($files as $file){
			$buffers[$file->page_id] = $file;
		}
		$files = $buffers;
		unset($buffers);
		
		// Company Us Page
		$about_pages	= $this->pages->find_detail(array('category_id'=>$page_category[0]->id,'status'=>'publish'),array('order'=>'asc'));

		// Others page in this category 
		$where_cond = array('id !='=>$about_page[0]->id,'category_id'=> $page_category[0]->id,'status'=>'publish');
		$order_by	= array('order'=>'asc');
		$about_pages_others = $this->pages->find_detail($where_cond,$order_by,12);
		
		
		$total_rows	= Model_Testimonial::instance()->find_count(array('status'=>'publish'),array('order'=>'asc'));
		
		// Pagination		
		$page_index	= isset($_GET['page']) ? $_GET['page'] - 1: 0;
		$per_page	= Lib::config('site.item_per_page');
		$per_page	= 4;
		$page_url	= isset($_GET['page']) ? '?page='.$_GET['page'] : '';
		$offset		= ($page_index == 0) ? '' : $page_index * $per_page;
		
		$_testimonial = Model_Testimonial::instance()->find_detail(array('status'=>'publish'),array('added'=>'desc'),$per_page, $offset);
						
		/** Initialize pagination **/
		$pagination = Pagination::factory(array(
				'total_items' 		=> $total_rows,
				'items_per_page' 	=> $per_page,
			 )
		);		
		
		$buffers = array();
		foreach ($_testimonial as $key) {
			$buffers[$key->id] = $key;
			$buffers[$key->id]->file_name = !empty(Model_TestimonialFile::instance()->load_by_group($key->id)->file_name) 
					? Model_TestimonialFile::instance()->load_by_group($key->id)->file_name : '';
		}
		$testimonial = $buffers;
		unset($buffers);
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'upload_path' => Lib::config('testimonial')->upload_path,
									'upload_url' => Lib::config('testimonial')->upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,
									'about_pages_others' => $about_pages_others,
									'about_page' => $about_page,
									'about_pages' => $about_pages,	
									'files' => $files,
									'testimonial' => $testimonial,
									'pagination' => $pagination
									);

		$content			= View::factory('site/testimonial_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content		= $content; 
	}
	
	protected function _read_testimonial ($id) {
		// Load Page Category By ID = 15 : Company
		$page_category	= ($this->page_category->find_detail(array('id'=>15,'status'=>'publish'))) 
							? $this->page_category->find_detail(array('id'=>15,'status'=>'publish')) 
								: $this->page_category->find_detail(array('title'=>'company','status'=>'publish'));
		
		$category_files	= $this->category_files->find(array('category_id'=>$page_category[0]->id),'',1);
		
		$buffers = array();
		foreach ($category_files as $cfile){
			$buffers[$cfile->category_id] = $cfile;
		}
		$category_files = $buffers;
		
		// Company Us Page = $this->id1, Category_Id = 2
		$testimonial	= Model_Testimonial::instance()->find_detail(array('title'=>$id));
		
		// Company Us Page 
		$about_page	= $this->pages->find_detail(array('title'=>'about-us', 'status'=>'publish'));

		// Company Us Page
		$about_pages	= $this->pages->find_detail(array('category_id'=>$page_category[0]->id,'status'=>'publish'),array('order'=>'asc'));
		
		// Others page in this category = 2
		$where_cond = array('id !='=>$about_page[0]->id,'category_id'=> $page_category[0]->id,'status'=>'publish');
		$order_by	= array('order'=>'asc');
		$about_pages_others = $this->pages->find_detail($where_cond,$order_by,12);
				
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'upload_path' => Lib::config('testimonial')->upload_path,
									'upload_url' => Lib::config('testimonial')->upload_url,
									'page_category' => $page_category,
									'category_files' => $category_files,
									'about_pages_others' => $about_pages_others,
									'about_page' => $about_page,
									'about_pages' => $about_pages,	
									'testimonial' => $testimonial
									);

		$content			= View::factory('site/testimonial_detail_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		// Js and CSS for the specified controller		
		$this->template->css	= array('jPlayer/jplayer.blue.monday.css'=>'all');
		$this->template->js		= array('library/jPlayer/jquery.jplayer.min.js');		
				
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content		= $content; 
	}
	
	protected function _count_viewers($id = '') {	
		if (!$id)
			return;
		
		$page = $this->pages->load($id);
		$page->count = $page->count + 1;
		$page->update();
	}	
	
	protected function _count_news_viewers($id = '') {	
		if (!$id)
			return;
		
		$page = Model_News::instance()->load($id);
		$page->count = $page->count + 1;
		$page->update();
	}	
}
