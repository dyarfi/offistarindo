<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Author       : Daniel Simangunsong
 * Code Name    : Blugol
 * Copywrigth   : 2011
 * Module       : event
 * Package      : Factory Fabric
**/ 


 defined('SYSPATH') or die('No direct script access.');

 class Kohana_Email {
    protected $config = array (
            'view'      => 'email/default',
            
            'model'     => array ('email','global'),
            'perpage'   => 10,
        );   
    
    /**
     * Let's produce our event, starting from here.
    **/
    
    public function get($config=array(),$paging=false){
        $config['limit'] = empty($config['limit']) ? $this->perpage : $config['limit'];
        $config['table'] = empty($config['table']) ? 'email' : $config['table'];
        $tpl_var = array();
        if ($paging): 
            if (empty($config['where'])) $config['where'] = '';
            $total_raw = $this->modelglobal->globalTotal($config['table'],array('where'=>$config['where']));
            $pagination =  Pagination::factory(array(   	
                'total_items'=>$total_raw,
                'items_per_page'=>$config['limit'],
            ));
            
            $config['offset']       = $pagination->offset;
            $tpl_var['var_paging']  = $pagination->render('pagination/cke');
            $tpl_var['total_record']= $total_raw;
        endif;
        
        $get_raw = $this->modelglobal->globalSelect($config);
        
        if (count($get_raw) <= 0) return null;
        
        if (!empty($config['return']) && count($get_raw) > 0) return $get_raw[0][$config['return']];
        
        $tpl_var['var_listing'] = $get_raw;
        
        return empty($config['tpl']) 
            ? $tpl_var
            : $this->render($config['tpl'],$tpl_var);
            
    } 
    
    /**
	 * Create an object of event
	 *
	 * @param   Array  configuration
	 * @return  event object
    **/    
	public static function factory(array $config = array()) 	{
		return new Email($config);
	}

	/**
	 * creates a new new object.
	 *
	 * @param   array  configuration
	 * @return  void
    **/
	public function __construct(array $config = array()) {
		// Pagination setup
        $this->config = $this->config_group() + $this->config;
		$this->setup($config);
        
        foreach ($this->model as $k=>$model):
            $modelname  = "model$model";
            $modelClass = "Model_".ucfirst($model);
            $this->$modelname = new $modelClass;
        endforeach;
        
        // Current Viewer Session ID
        $this->sid = Session::instance()->id();
	}

	/**
	 * Enabled you for using config file and retrieves a event config group from it. One config group can
	 * refer to another as its parent, which will be recursively loaded.
	 *
	 * @param   string  user config group; "default" if none given
	 * @return  array   config settings
	 */
	public function config_group($group = 'default')
	{
		// Load the user config file
		$config_file = Kohana::config('email');

		// Initialize the $config array
		$config['group'] = (string) $group;

		// Recursively load requested config groups
		while (isset($config['group']) AND isset($config_file->$config['group']))
		{
			// Temporarily store config group name
			$group = $config['group'];
			unset($config['group']);

			// Add config group values, not overwriting existing keys
			$config += $config_file->$group;
		}

		// Get rid of possible stray config group names
		unset($config['group']);

		// Return the merged config group settings
		return $config;
	}
    
	/**
	 * Here we go to setup our modul
     * @Param   Array Config
     * @Return  Object event
	 */
	public function setup(array $config = array())
	{
        
		// Overwrite the current config settings
		$this->config = $config + $this->config;
        
        // Recursively set each config to be property.
        foreach ($this->config as $key=>$value):
            $this->$key = $value;
        endforeach;
        
		return $this;
	}
    
    /** 
     * This is the machine who give back all module property, simple but powerfull.
     * @param 'Key' 
     * @return 'Property' or 'NULL' if not found
    **/
        
	public function __get($key) {
		return isset($this->$key) ? $this->$key : NULL;
	}
    
    
	/** 
     * Wow wow wow .. there is something more. We can set up our config as much as you want
     * Using this ofcourse
     * @param 'Key'
     * @param 'Value'
    **/ 
     
	public function __set($key, $value) {
		$this->setup(array($key => $value));
	}
    
    /**
     * Need a render, just call this
     * @param 'File'
     * @param 'array of variable'
     * @return 'A bunch of HTML'
    **/
    public function render($view=null,$params=array()){
        if($view === NULL):
           $view = $this->config['view']; // Get Default View
        endif;  
        
        $view = 'email/'.$view;
        if(!$view instanceof Kohana_View):
            $view = View::factory($view,$params); // Load View File  
        endif;
        
        return $view->render();   
    }
    
    public function get_all_email($return = null) {
        $email = $this->get(array(
                'where'=>array('status'=>1)
            ));
        return $email;
    }
    
    public function get_email_by_name($name, $return = null) {
        $email = $this->get(array(
                'where'=>array('name'=>$name,'status'=>1)
            ));
        return $email;
    }
 }
?>