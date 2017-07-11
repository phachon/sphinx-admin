<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Dao 类
 * @author phachon@163.com
 */
class Dao {

	/**
	 * 库名
	 * @var string
	 */
	protected $_db = '';

	/**
	 * 表名
	 * @var string
	 */
	protected $_tableName = '';

	/**
	 * 主键
	 * @var string
	 */
	protected $_primaryKey = '';

	/**
	 * 库路由
	 * @var integer
	 */
	protected $_routeDB = Slice_DB::MODE_NONE;

	/**
	 * 表路由
	 * @var integer
	 */
	protected $_routeTable = Slice_Table::MODE_NONE;

	/**
	 * factory
	 * @param  string $className 
	 * @return object
	 */
	public static function factory($className) {
		if($className) {
			$class = "Dao_$className";
			return new $class();
		}
	}

	/**
	 * Dao constructor.
	 * @param null $db
	 */
	public function __construct($db = NULL) {
		if($db) {
			$this->_db = $db;
		}
		if(is_string($this->_db)) {
			$this->_db = Database::instance($this->_db);
		}
	}

	/**
	 * 得到分库库名
	 * @param $key
	 * @return string
	 */
	protected function _db($key) {
		if(!$this->_routeDB instanceof Slice_DB) {
			$this->_routeDB = Slice_DB::factory($this->_routeDB);
		}
		return $this->_routeDB->name($this->_db)->key($key)->route();
	}

	/**
	 * 得到分表表名
	 * @param $key
	 * @return mixed
	 */
	protected function _tableName($key) {
		if(!$this->_routeTable instanceof Slice_Table) {
			$this->_routeTable = Slice_Table::factory($this->_routeTable);
		}
		return $this->_routeTable->name($this->_tableName)->key($key)->route();
	}

	/**
	 * 根据多个 key 获取库名和表名
	 * @param array $keys
	 * @return array
	 */
	protected function _groupKeys(array $keys) {
		$keysGroups = array();
		foreach($keys as $key) {
			$groupKey = $this->_db($key).'.'.$this->_tableName($key);
			$keysGroups[$groupKey][] = $key;
		}
		return $keysGroups;
	}

}