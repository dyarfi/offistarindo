<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Home extends Controller_Themes_Default {
	protected $page_category;
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
        
		$this->page			= new Model_Page;
		$this->pagecontent	= new Model_PageContent;
		
		$this->banner		 = new Model_Banner;		
		$this->bannercontent = new Model_BannerContent;
		
		$this->testimonial	 = new Model_Testimonial;		
						
	}
    
	public function action_index () {
				
		// Js and CSS for the specified controller		
		$this->template->css	= array('jPlayer/jplayer.blue.monday.css'=>'all');
		$this->template->js		= array('library/jPlayer/jquery.jplayer.min.js');
		
		$_about			= $this->page->find_detail(array('id'=>1,'status'=>'publish'));
		$_banners		= $this->banner->find_detail(array('status'=>'publish'),array('order'=>'asc'),6);
		$_testimonial	= $this->testimonial->find_detail(array('default'=>1),array('added'=>'desc'),1);

		$buffers = array();
		foreach ($_banners as $key1) {
			$buffers[$key1->id] = $key1;
			$buffers[$key1->id]->file_name = Model_BannerFile::instance()->load_by_group($key1->id)->file_name;
		}
		$banners = $buffers;
		unset($buffers);				
				
		$qry_category		= Model_ProductCategory::instance()->find_detail(array('status'=>'publish'));
		//$qry_product		= Model_Product::instance()->find_detail(array('status'=>'publish'));	
		$qry_downloadtype	= Model_DownloadType::instance()->find_detail(array('status'=>'publish'));		  
		// Page detail for language based on content id within language ids
		$_banner_content	= $this->bannercontent->find(array('lang_id'=>Lang::_lang_id(I18n::lang())));
		$buffers = array();
		foreach($_banner_content as $data2){
			$buffers[$data2->banner_id] = $data2;
		}
		$banner_content = $buffers;	
		unset($buffers);
		//print_r($_about);
		$content_vars		= array(
									'banners'			=> $banners,
									'banner_content'	=> $banner_content,
									'about'			=> Arr::get($_about,0),
									'testimonial'	=> Arr::get($_testimonial,0),
									'qry_category'	=> $qry_category,
									//'qry_product'	=> $qry_product,
									'qry_downloadtype' => $qry_downloadtype,
									'upload_path'	=> Lib::config('banner')->upload_path,
									'upload_url'	=> Lib::config('banner')->upload_url,
									'page_upload_url'		 => Lib::config('page')->upload_url,
									'page_upload_path'		 => Lib::config('page')->upload_path,									
									'testimonial_upload_url'	=> Lib::config('testimonial')->upload_url,
									'testimonial_upload_path'	=> Lib::config('testimonial')->upload_path,									
									);

		$content			= View::factory('site/home_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords	  = Lib::_trim_strip($this->data['categoryContent'][$this->data['pageCategory'][0]->id]->meta_keyword);
		$this->template->meta_description = Lib::_trim_strip($this->data['categoryContent'][$this->data['pageCategory'][0]->id]->meta_description);
		$this->template->page_title		= Lib::_trim_strip($this->data['categoryContent'][$this->data['pageCategory'][0]->id]->meta_title);
		$this->template->content		= $content; 
	}
	
	public function after() {
		parent::after();
		
	}

}
