<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Sitemap extends Controller_Themes_Default {
	protected $page_category;
	protected $category_file;
	protected $id1;
	protected $id2;
	protected $id3;
	protected $id4;
	public $setting;

	public function before () {
		parent::before();
		
		// Load necessary Model
		$this->page_category	= new Model_PageCategory;
		$this->category_files	= new Model_PageCategoryFile;
				
		// Load Config
		$this->_config	= Lib::config('page');
		
		// Page Fields Config
		$this->page_category_fields	= $this->_config->page_category_fields;
		
		// Upload Path Config
		$this->category_upload_path	= $this->_config->category_upload_path;
		
		// Upload Url Config
		$this->category_upload_url	= $this->_config->category_upload_url;
	}
    
	public function action_index () {
		
		// Home
		$_about			= Model::factory('Page')->find_detail(array('id'=>1,'status'=>'publish'),'',1);
		$_testimonial	= Model::factory('Testimonial')->find_detail(array('status'=>'publish'),array('added'=>'DESC'),1);
		
		// Company News and Event
		$_pages			= Model::factory('Page')->find_detail(array('category_id'=>15,'status'=>'publish'));
		
		// Download Page
		$_downloadType	= Model::factory('DownloadType')->find_detail(array('status'=>'publish'));
		
		// Products
		$_products		= Model::factory('Product')->find_detail(array('status'=>'publish'),array('order'=>'desc'));
		
		// Solution Category
		$_solution		= Model::factory('SolutionCategory')->find_detail(array('status'=>'publish'),array('order'=>'desc'));
		
		
		$content_vars		= array(
									'pages' => $_pages,
									'about' => Arr::get($_about, 0),
									'testimonial' => Arr::get($_testimonial, 0),
									'downloadType' => $_downloadType,
									'products' => $_products,	
									'solutionCategory' => $_solution,
									'pageCategory'=>$this->data['pageCategory'],
									'categoryContent'=>$this->data['categoryContent'],
									'page_category_child' => $this->data['page_category_child']
									);

		$content			= View::factory('site/sitemap_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= trim(str_replace(' ',', ',strip_tags('Sitemap Us Message')),"\n\r\x00..\x1F");
		
		$this->template->meta_description	= __('sitemap').' | ' . strip_tags('Sitemap Us');		
		
		$this->template->page_title		= __('sitemap').' - ' . Lib::config('site.title');
		
		$this->template->content		= $content; 
	}
	
	public function action_captcha_reload() {
		
		$captcha = Captcha::instance();
		//$captcha->render();
		echo $captcha->render(TRUE);
		exit();
	}
	
}
