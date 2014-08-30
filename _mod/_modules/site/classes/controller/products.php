<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Products extends Controller_Themes_Default {
	protected $product;
	protected $product_file;
	protected $product_category;
	protected $category_file;
	protected $id1;
	protected $id2;
	protected $id3;
	protected $id4;

	public function before () {
		parent::before();
        
		$this->_class_name		= Request::$current->controller();
		
        $this->id1 = Request::$current->param('id1');
        $this->id2 = Request::$current->param('id2');
        $this->id3 = Request::$current->param('id3');
		$this->id4 = Request::$current->param('id4');
        
		// Load necessary Model
		$this->page_category	= new Model_PageCategory;
		$this->category_files	= new Model_PageCategoryFile;
		
		$this->product_category	= new Model_ProductCategory;
		
		$this->product			= new Model_Product;
		$this->product_file		= new Model_ProductFile;
		$this->acategory		= new Model_ProductCategory;
		$this->acategory_file 	= new Model_ProductCategoryFile;
		
		// Load Config
		//--------------------------- Pages - Start ---------------------------//
		$this->_config	= Lib::config('product');
		
		// Page Fields Config
		$this->category_fields	= $this->_config->category_fields;
		
		// Upload Path Config
		$this->category_upload_path	= $this->_config->category_upload_path;
		
		// Upload Url Config
		$this->category_upload_url	= $this->_config->category_upload_url;
		
		// Page Fields Config
		$this->product_fields	= $this->_config->product_fields;
		
		// Upload Path Config
		$this->upload_path	= $this->_config->upload_path;
		
		// Upload Url Config
		$this->upload_url	= $this->_config->upload_url;
		//--------------------------- Pages - End ---------------------------//
		
		//--------------------------- Product - Start ---------------------------//
		$this->_config_product	= Lib::config('product');
		
		// Product Fields Config
		$this->category_fields	= $this->_config_product->category_fields;
		
		// Upload Path Config
		$this->acategory_upload_path = $this->_config_product->category_upload_path;
		
		// Upload Url Config
		$this->acategory_upload_url	= $this->_config_product->category_upload_url;
		
		// Page Fields Config
		$this->product_fields	= $this->_config_product->product_fields;
		
		// Upload Path Config
		$this->aupload_path	= $this->_config_product->upload_path;
		
		// Upload Url Config
		$this->aupload_url	= $this->_config_product->upload_url;
		//--------------------------- Product - End ---------------------------//
		
		// Js and CSS for the specified controller		
		$this->template->css	= array('jPlayer/jplayer.blue.monday.css'=>'all');
		$this->template->js		= array('library/jPlayer/jquery.jplayer.min.js');
		
	}
    
	public function action_index () {
		
		// Load Page Category By ID = 11 : Products
		$page_category	= ($this->page_category->find_detail(array('id'=>11))) 
						? $this->page_category->find_detail(array('id'=>11)) 
								: $this->page_category->load_by_name('products');

		/** Execute list query **/
		
		// Default Conditions
		$where_cond = array('status'=>'publish','top_brand'=>1);
		$order_by	= array('modified'=>'DESC');
		
		$product_index	= isset($_GET['page']) ? $_GET['page'] - 1: 0;
		
		$per_page	= Lib::config('site.item_per_page');
		//$per_page	= 4;
		$product_url	= isset($_GET['page']) ? '?page='.$_GET['page'] : '';
		$offset		= ($product_index == 0) ? '' : $product_index * $per_page;

		$total_rows				= $this->product->find_count($where_cond);
		
		$products_listings		= $this->product->find_detail($where_cond, $order_by, $per_page, $offset);
		$product_files			= $this->product_file->find();
		
		$buffers_files	= array();
		foreach($product_files as $files) {
			$buffers_files[$files->product_id] = $files;
		}
		$product_files = $buffers_files;
		unset($buffers_files);		
		
		/** Execute list query **/
		
		$product_category	= Model_ProductCategory::instance()->find_detail(array('status'=>'publish'),array('order'=>'ASC'));							
		/** Initialize pagination **/

		$pagination = Pagination::factory(array(
				'total_items' 		=> $total_rows,
				'items_per_page' 	=> $per_page,
				'view'              => 'pagination/default'
			 )
		);
		
		/** Views Vars **/
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'page_category' => $page_category,
									'upload_path' => $this->upload_path,
									'upload_url' => $this->upload_url,
									'acategory_upload_path' => $this->acategory_upload_path,
									'acategory_upload_url' => $this->acategory_upload_url,
									'product_category' => $product_category,
									'product_files' => $product_files,
									'products_listings' => $products_listings,
									'aupload_path' => $this->aupload_path,
									'aupload_url' => $this->aupload_url,
									'pagination' => $pagination,
									);

		$content			= View::factory('site/products_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content	= $content; 
	}
	
	public function action_read () {
						
		// Load Page Category By ID = 11 : Products
		$page_category	= ($this->page_category->find_detail(array('id'=>11))) 
							? $this->page_category->find_detail(array('id'=>11)) 
								: $this->page_category->load_by_name('products');
		
		// Default Conditions
		$where_cond = array('status'=>'publish');
		$order_by	= array('order'=>'ASC');

		/** Execute list query **/				
				
		$product_category	= $this->product_category->find_detail(array('status'=>'publish'),array('order'=>'ASC'));	
		
		// Set Product Category Child
		$_child_category	= Model_ProductCategory::instance()->find_detail(array('status'=>'publish'),array('order'=>'ASC'));
		$buffers_child					= array();
		foreach ($_child_category as $_category_child) {
			$buffers_child[$_category_child->parent_id][] = $_category_child;
		}
		$child_category = $buffers_child;		
		unset ($buffers_child);		
		
		$product_detail = $this->product->find_detail(array('title'=>$this->id1,'status'=>'publish'));
		$_product_detail_files = $this->product_file->find(array('product_id'=>$product_detail[0]->id));
		
		$bufferspf = array();
		foreach ($_product_detail_files as $_files) {
			$bufferspf[$_files->product_id] = $_files;			
		}
		$product_files = $bufferspf;
						
		/** Count Viewers **/

		$this->_count_viewers($product_detail[0]->id);
		
		/** Views Vars **/
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'page_category' => $page_category,
									'upload_path' => $this->upload_path,
									'upload_url' => $this->upload_url,
									'acategory_upload_path' => $this->acategory_upload_path,
									'acategory_upload_url' => $this->acategory_upload_url,
									'product_category' => $product_category,
									'product_files' => $product_files,
									'product_detail' => $product_detail,
									'aupload_path' => $this->aupload_path,
									'aupload_url' => $this->aupload_url
									);

		$content			= View::factory('site/products_detail_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content	= $content; 
	}

	public function action_browse () {
		
		// Load Page Category By ID = 11 : Products
		$page_category	= ($this->page_category->find_detail(array('id'=>11))) 
							? $this->page_category->find_detail(array('id'=>11)) 
								: $this->page_category->load_by_name('products');
		
		$product_category	= $this->product_category->find_detail(array('status'=>'publish'),array('order'=>'ASC'));	
		
		$_category_detail	= $this->product_category->find(array('title'=>$this->id1),'',1);
		
		$category_parents	= $this->product_category->find(array('parent_id'=>$_category_detail[0]->id,'status'=>'publish'),array('order'=>'ASC'));	
		
		$buffers = array();
		$i=0;
		foreach ($_category_detail as $detail) {
			$buffers[$i] = $detail;
			$buffers[$i]->subject = Model::factory('ProductCategoryContent')->load_by_group($detail->id)->subject;
			$buffers[$i]->text = Model::factory('ProductCategoryContent')->load_by_group($detail->id)->text;
			$i++;
		}		
		$category_detail = $buffers;
				
		$buffer_ids = array(@$category_detail[0]->id); 
		foreach ($category_parents as $parents) {			
			$buffer_ids[] = $parents->id; 
		}
		$category_ids = $buffer_ids;
		
		// Default Conditions
		$where_cond = array('status'=>'publish');
		$where_cond = !empty($category_detail) ? array_merge($where_cond,array('category_id IN'=>$category_ids)) : $where_cond;
		$order_by	= array('order'=>'ASC');
		
		$product_index	= isset($_GET['page']) ? $_GET['page'] - 1: 0;
		
		$per_page	 = Lib::config('site.item_per_page');
		//$per_page	 = 4;
		$product_url = isset($_GET['page']) ? '?page='.$_GET['page'] : '';
		$offset		= ($product_index == 0) ? '' : $product_index * $per_page;

		$total_rows				= $this->product->find_count($where_cond);
		
		$products_listings		= $this->product->find_detail($where_cond, $order_by, $per_page, $offset);
		$product_files			= $this->product_file->find();
		
		$buffers_files	= array();
		foreach($product_files as $files) {
			$buffers_files[$files->product_id] = $files;
		}
		$product_files = $buffers_files;
		unset($buffers_files);		
				
		/** Initialize pagination **/

		$pagination = Pagination::factory(array(
				'total_items' 		=> $total_rows,
				'items_per_page' 	=> $per_page,
				'view'              => 'pagination/default'
			 )
		);
		
		/** Views Vars **/
		
		$content_vars		= array(
									'category_upload_path' => $this->category_upload_path,
									'category_upload_url' => $this->category_upload_url,
									'page_category' => $page_category,
									'upload_path' => $this->upload_path,
									'upload_url' => $this->upload_url,
									'acategory_upload_path' => $this->acategory_upload_path,
									'acategory_upload_url' => $this->acategory_upload_url,
									'product_category' => $product_category,
									'category_detail' => $category_detail,
									'products_listings' => $products_listings,
									'product_files' => $product_files,
									'aupload_path' => $this->aupload_path,
									'aupload_url' => $this->aupload_url,
									'pagination' => $pagination,
									);

		$content			= View::factory('site/products_browse_page');

		foreach ($content_vars as $var => $val) {
			$content->$var	= $val;
		}
		
		$this->template->meta_keywords		= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_keyword) : '';
		
		$this->template->meta_description	= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_description) : '';
		
		$this->template->page_title			= (!empty($page_category[0])) ? Lib::_trim_strip($page_category[0]->meta_title) : '';
		
		$this->template->content			= $content; 	
	}
	
	protected function _count_viewers($id = '') {	
		if (!$id)
			return;
		
		$product = $this->product->load($id);
		$product->count = $product->count + 1;
		$product->update();
	}
	
}
