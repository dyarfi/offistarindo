<?php defined('SYSPATH') or die('No direct script access.');

class Model_News extends Model_Database {
	protected $table = 'news'; 
	protected $tbl_name;
	protected $_model_vars;
	protected $db; 
    protected $prefix;
	protected static $_instance;

	public function __construct () {
		parent::__construct();

		$this->_model_vars	= array('id'	=> 0,
									'title'	=> '',
									'type'		=> '',
									'news_date' => '',
									'user_id'	=> 0,
									'count'		=> 0,	
									'status'	=> '',
									'added'		=> 0,
									'modified'	=> 0);

		$this->db		= Database::instance();
		$this->tbl_name	= $this->table;
		$this->prefix   = $this->db->table_prefix() ? $this->db->table_prefix() : ''; 
        $this->table	= (!empty($this->prefix)) ? $this->prefix . $this->table : $this->table;
	}

	public static function instance () {
		if (self::$_instance === NULL)
			self::$_instance	= new self();

		return self::$_instance;
	}

	public function install () {
		$insert_data	= FALSE;

		if (!$this->db->list_tables($this->table)) 
               $insert_data	= TRUE;
                
        $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->table.'` ('
            .'`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
            .'`title` VARCHAR(255) NULL, '	            
			.'`type` TINYINT(1) NULL, '	
            .'`news_date` DATE NULL, '
			.'`user_id` TINYINT(3) NULL , '
			.'`count` INT(11) NULL , '
            .'`status` ENUM(\'publish\', \'unpublish\', \'deleted\') NULL DEFAULT \'publish\', '
            .'`added` INT(11) NULL, '
            .'`modified` INT(11) NULL, '
            .'INDEX (`title`, `status`), '
			. 'UNIQUE (`title`)'
            .') ENGINE=MYISAM';

		$this->db->query('CREATE', $sql);
		/*
		if ($insert_data) {
			$sql	= 'INSERT INTO `'.$this->table.'` (`id`,`name`,`subject`,`type`,`synopsis`,`text`,`news_date`,`user_id`,`count`,`status`,`added`,`modified`)'
				    . ' VALUES '
				    . '(\'11\',\'subject-test-news-sample-one\',\'Subject Test News Sample One\',NULL,\'Synopsis Test News Sample One\',\'Description Test News Sample One\',NULL,1,0,\'publish\',NULL,NULL), '
				    . '(\'12\',\'subject-test-news-sample-two\',\'Subject Test News Sample Two\',NULL,\'Synopsis Test News Sample Two\',\'Description Test News Sample Two\',NULL,1,0,\'publish\',NULL,NULL);';

			$this->db->query('INSERT',$sql);
		}
		*/
		
		return $this->db->list_tables($this->table);
	}

	public function load ($id = '') {
		$return_object	= TRUE;

		if ($id == '') {
			$return_object	= FALSE;
			$id				= $this->id;
		}

		$objects	= $this->find(array('id' => $id), '', 1);

		if (count($objects) == 1) {
			if ($return_object) {
				return $objects[0];
			} else {
				$vars	= array_keys($this->_model_vars);

				foreach ($vars as $var) {
					$this->$var	= $objects[0]->$var;
				}

				return TRUE;
			}
		}

		return FALSE;
	}

	public function load_by_name ($name) {
		$where_cond	= array('name'			=> $name,
							'status !='		=> 'deleted');

		if ($this->find_count($where_cond) == 0)
			unset($where_cond['status !=']);

		$objects		= $this->find($where_cond, '', 1);

		return (isset($objects[0])) ? $objects[0] : FALSE;
	}

	public function add ($params = '') {
		if (!is_array($params)) return;

		$params['added']	= time();

		unset($this->_model_vars['id']);

		$params	= array_merge($this->_model_vars, $params);
		
		$query = DB::insert($this->tbl_name, array_keys($params))->values(array_values($params))->execute();

		if (count($query) !== FALSE)
			$insert_id	= mysql_insert_id();
		else
			return FALSE;

		return $insert_id;
	}

	public function update () {
		$this->modified	= time();
		
		$object_vars	= get_object_vars($this);
		
		unset($object_vars['_model_vars'], $object_vars['db']);
		
		$object_vars = Arr::overwrite($this->_model_vars,$object_vars);
		
		$result = DB::update($this->tbl_name)->set($object_vars)->where('id', '=', $this->id)->execute();
		
		return $result;
	}

	public function delete ($id = '') {
		if ($id == '')
			$id	= $this->id;
		$result		= DB::delete($this->tbl_name)->where('id', '=', $id)->execute();
		
		$delete		= DB::delete('news_content')->where('news_id', '=', $id)->execute();
		
		return $result;
	}

	public function find ($where_cond = '', $order_by = '', $limit = '', $offset = '') {
		/** Build where query **/

		if ($where_cond != '') {
			if (is_array($where_cond) && count($where_cond) != 0) {
				$buffers	= array();

				$operators	= array('LIKE',
									'IN',
									'!=',
									'>=',
									'<=',
									'>',
									'<',
									'=');
                                
				foreach ($where_cond as $field => $value) {
					$operator	= '=';

					if (strpos($field, ' ') != 0)
						list($field, $operator)	= explode(' ', $field);

					if (in_array($operator, $operators)) {
						$field		= '`'.$field.'`';

						if ($operator == 'IN' && is_array($value))
							$buffers[]	= $field.' '.$operator.' (\''.implode('\', \'', $value).'\')';
						else
							$buffers[]	= $field.' '.$operator.' \''.$value.'\'';
					} else if (is_numeric($field)) {
						$buffers[]	= $value;
					} else {
						$buffers[]	= $field.' '.$operator.' \''.$value.'\'';
					}
				}                
				$where_cond	= implode(' AND ', $buffers);                   
			}
		}

		$sql_order = ''; 
		if ($order_by != '') {
			$sql_order = ' ORDER BY '; 
			$i 	   = 1;
			foreach ($order_by as $order => $val) {
				$split = ($i > 1) ? ', ' : ''; 
				$sql_order .= ' '. $split .' `'. $order.'` '.$val.' ';
				$i++;
			}
			$order_by  = $sql_order;
		}
		
		$sql_limit = ''; 
		if ($limit != '' && $offset != '') {
			$offset    = $offset . ','; 
			$sql_limit = 'LIMIT '. $offset . $limit; 
		}
		else if ($limit != '') {
			$sql_limit = 'LIMIT '. $limit; 
		}
		$limit = $sql_limit;
		
		if ($where_cond != '') {
			$rows = $this->db->query(Database::SELECT, 'SELECT * FROM `'.$this->table.'` WHERE '. $where_cond . $order_by . $limit, TRUE)->as_array();
		}
		else {
			$rows = $this->db->query(Database::SELECT, 'SELECT * FROM `'.$this->table.'`' . $order_by . $limit, TRUE)->as_array();
		}

		$returns	= array();
                
		foreach ($rows as $row) {
			$object			= new Model_News;

			$object_vars	= get_object_vars($row);

			unset($object_vars['_model_vars'], $object_vars['db']);

			foreach ($object_vars as $var => $val) {
				$object->$var	= $val;
			}

			$returns[]		= $object;

			unset($object, $vars);
		}

		return $returns;
	}
			
	public function find_detail($where_cond = '', $order_by = '', $limit = '', $offset = '') {		
		$detail		 = $this->find($where_cond,$order_by,$limit,$offset);		
		$return		 = array();		
			
		$i=0;	
		foreach ($detail as $data) {			
			$_data_vars[$i]	= get_object_vars($data);			
			unset($_data_vars[$i]['_model_vars'],
				  $_data_vars[$i]['table'],
				  $_data_vars[$i]['prefix'],
				  $_data_vars[$i]['tbl_name'],
				  $_data_vars[$i]['db'],
				  $_data_vars[$i]['_db']);			
			// Get Language Detail			
			$detail_data = Model::factory('NewsContent')->find(array('news_id'=>$data->id,'lang_id'=>Lang::_lang_id(I18n::lang())));
			foreach ($detail_data as $detail) {
				$_detail_vars = get_object_vars($detail);			
				unset($_detail_vars['_model_vars'],
					  $_detail_vars['table'],
					  $_detail_vars['prefix'],
					  $_detail_vars['tbl_name'],
					  $_detail_vars['db'],
					  $_detail_vars['_db'],		
					  $_detail_vars['id']);			
				$return[$i] = (object) array_merge($_data_vars[$i],$_detail_vars);
			}
			$i++;				
			unset($_detail_vars);
		}
		unset($_data_vars);		

		return count($return) === 1 ? $return : $return;
	}
	
	public function find_count ($where_cond = '') {
		/** Build where query **/

		if ($where_cond != '') {
			if (is_array($where_cond) && count($where_cond) != 0) {
				$buffers	= array();

				$operators	= array('LIKE',
									'IN',
									'!=',
									'>=',
									'<=',
									'>',
									'<',
									'=');

				foreach ($where_cond as $field => $value) {
					$operator	= '=';

					if (strpos($field, ' ') != 0)
						list($field, $operator)	= explode(' ', $field);

					if (in_array($operator, $operators)) {
						$field		= '`'.$field.'`';

						if ($operator == 'IN' && is_array($value))
							$buffers[]	= $field.' '.$operator.' (\''.implode('\', \'', $value).'\')';
						else
							$buffers[]	= $field.' '.$operator.' \''.$value.'\'';
					} else if (is_numeric($field)) {
						$buffers[]	= $value;
					} else {
						$buffers[]	= $field.' '.$operator.' \''.$value.'\'';
					}
				}

				$where_cond	= implode(' AND ', $buffers);
			}
			$rows = $this->db->query(Database::SELECT, 'SELECT * FROM `'.$this->table.'` WHERE '. $where_cond, TRUE)->count();
		} else {
			$rows = sizeof($this->find());
		}
		return $rows;
	}
	
	public function query ($query = '',$object=FALSE) {
		if($query == '')
			return FALSE;
		$query = $this->db->query(Database::SELECT, $query, $object);
		if($query !== FALSE)
			return $query;
		else
			return FALSE;	
	}
}
