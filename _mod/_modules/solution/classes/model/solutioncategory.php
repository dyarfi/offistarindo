<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_SolutionCategory extends Model_Database {
	protected $table = 'solution_categories'; 
	protected $tbl_name;
	protected $_model_vars;
	protected $db; 
    protected $prefix;
	protected static $_instance;

	public function __construct () {
		parent::__construct();

		$this->_model_vars	= array('id'			=> 0,
									'parent_id'		=> 0,
									'title'			=> '',
									'sub_level'		=> 0,
									'is_system'		=> 0,
									'user_id'		=> 0,
									'order'			=> 0,
									'count'			=> 0,
									'status'		=> '',
									'added'			=> 0,
									'modified'		=> 0);

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
		$sql	= 'CREATE TABLE IF NOT EXISTS `'.$this->table.'` ('
				. '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
				. '`parent_id` INT(11) NULL , '	
				. '`title` VARCHAR(255) NULL , '
				. '`sub_level` TINYINT(3) NULL , '
				. '`is_system` ENUM(\'1\', \'0\') NULL DEFAULT \'0\', '
				. '`user_id` TINYINT(3) NULL , '
				. '`order` TINYINT(5) NULL , '	
				. '`count` INT(11) NULL , '	
				. '`status` ENUM(\'publish\', \'unpublish\', \'deleted\') NULL DEFAULT \'publish\', '
				. '`added` INT(11) NULL, '
				. '`modified` INT(11) NULL, '
				. 'INDEX (`order`, `status`) '
				. ') ENGINE=MYISAM';

		$this->db->query('CREATE', $sql);

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
	
	public function load_by_name ($name, $category_id = '') {
		if ($category_id != '') {
			$where_cond	= array('name'			=> $name,
								'category_id'	=> $category_id,
								'status !='		=> 'deleted');
		} else {
			$where_cond	= array('name'			=> $name,
								'status !='		=> 'deleted');
		}

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
		$delete		= DB::delete('solution_category_content')->where('category_id', '=', $id)->execute();
		
		return $result;
	}

	public function find ($where_cond = '', $order_by = '', $limit = '', $offset = '') {
		/** set default order **/
		if ($order_by == '') {
			$default_order	= array('order' => 'ASC','sub_level' => 'ASC');
		} else {
			$default_order = $order_by;
		}
		
		if ($order_by != '' && is_array($order_by))
			$order_by	= array_merge($default_order, $order_by);
		else if ($order_by != '' && !is_array($order_by))
			$order_by	= array_merge($default_order, array($order_by => 'ASC'));
		else
			$order_by	= $default_order;
		
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
			$sql_order = ' ORDER BY'; 
			$i 	   = 1;
			foreach ($order_by as $order => $val) {
				$split = ($i > 1) ? ', ' : ''; 
				$sql_order .= ''. $split .' `'. $order.'` '.$val.' ';
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
		$buffers	= array();
		$parent_id	= 0;
		$first_row	= TRUE;
		$single		= FALSE;
		foreach ($rows as $row) {
			$object			= new Model_SolutionCategory;
			$object_vars	= get_object_vars($row);
			foreach ($object_vars as $var => $val) {
				$object->$var	= $val;
			}
			if ($limit == 1) {
				$buffers[] = (object) $object_vars;
				$single = TRUE;
			}
			else {
				$buffers[]	= $object;
			}
			if ($first_row) {
				$parent_id		= $object->parent_id;
				$first_row		= FALSE;
			}
			unset($object, $vars);
		}
		$buffers	= ($single == FALSE) ? $this->_child_traversal($parent_id, $buffers) : $buffers;
		$offset		= intval($offset);
		$limit		= (intval($limit) == 0) ? count($buffers) : intval($limit);
		$returns	= ($single == FALSE) ? array_slice($buffers, $offset, $limit) : $buffers;
		return $returns;
	}
	
		public function find_cp ($where_cond = '', $order_by = '', $limit = '', $offset = '') {
		/** set default order **/
		/*
		$default_order	= array('order'		=> 'ASC',
								'sub_level'	=> 'ASC');
		if ($order_by != '' && is_array($order_by))
			$order_by	= array_merge($default_order, $order_by);
		else if ($order_by != '' && !is_array($order_by))
			$order_by	= array_merge($default_order, array($order_by => 'ASC'));
		else
			$order_by	= $default_order;
		* 
		*/
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
			$sql_order = ' ORDER BY'; 
			$i 	   = 1;
			foreach ($order_by as $order => $val) {
				$split = ($i > 1) ? ', ' : ''; 
				$sql_order .= ''. $split .' `'. $order.'` '.$val.' ';
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
		$buffers	= array();
		$parent_id	= 0;
		$first_row	= TRUE;
		$single		= FALSE;
		foreach ($rows as $row) {
			$object			= new Model_SolutionCategory;
			$object_vars	= get_object_vars($row);
			foreach ($object_vars as $var => $val) {
				$object->$var	= $val;
			}
			if ($limit == 1) {
				$buffers = (object) $object_vars;
				$single = TRUE;
			}
			else {
				$buffers[]	= $object;
			}
			if ($first_row) {
				$parent_id		= $object->parent_id;
				$first_row		= FALSE;
			}
			unset($object, $vars);
		}
		$buffers	= $this->_child_traversal($parent_id, $buffers);
		$offset		= intval($offset);
		$limit		= (intval($limit) == 0) ? count($buffers) : intval($limit);

		$returns	= array_slice($buffers, $offset, $limit);

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
			$detail_data = Model::factory('SolutionCategoryContent')->find(array('category_id'=>$data->id,'lang_id'=>Lang::_lang_id(I18n::lang())));
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
	
	public function set_order($parent_id = '', $group = '', $action='') {
		$type = '';
		$action = strtolower($action);
		if (!empty($parent_id)) {
			$type = 'WHERE `parent_id` = '. $parent_id .'';
		} 
		// query to find default data 
		$sql = 'SELECT '.$action.'(`order`) as `'.$action.'_order` FROM `'.$this->table.'` '.$type.';';
		$order	= $this->query($sql,TRUE);
		$return = $action.'_order';
		if (!empty($order[0]->$return))
			return $order[0]->$return;
	}
	
	private function _child_traversal ($parent_id, $childrens) {
		if (!is_array($childrens))
			return array();
		$returns	= array();
		foreach ($childrens as $child) {
			if ($child->parent_id == $parent_id) {
				$returns[]	= $child;
				$returns	= array_merge_recursive($returns, $this->_child_traversal($child->id, $childrens));
			}
		}
		return $returns;
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

