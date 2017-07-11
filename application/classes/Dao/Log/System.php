<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 系统日志 dao 层
 * @author phachon@163.com
 */
class Dao_Log_System extends Dao {

	protected $_db = 'sphinx';

	protected $_table = 'log_system';

	protected $_primaryKey = 'log_system_id';

	protected $_modelName = 'Model_Log_System';

	/**
	 * 获取总数
	 * @return integer
	 */
	public function countLogs() {
		return DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_table)
			->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 分页获取日志
	 * @param  integer $offset
	 * @param  integer $number
	 * @return array
	 */
	public function getLogsByLimit($offset, $number) {

		$select = DB::select('*')
			->from($this->_table);
		if($offset) {
			$select->offset($offset);
		}
		if($number) {
			$select->limit($number);
		}
		return $select->order_by($this->_primaryKey, 'DESC')
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 获取总数
	 * @param  string $keyword
	 * @return integer
	 */
	public function countLogsByKeyword($keyword) {

		$select = DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_table);
		if($keyword) {
			$select->where('account_name', '=', $keyword);
			$select->or_where('message', 'LIKE', '%'.$keyword.'%');
		}
		return $select->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 分页获取日志
	 * @param  integer $offset
	 * @param  integer $number
	 * @return array
	 */
	public function getLogsByLimitAndKeyword($keyword, $offset, $number) {

		$select = DB::select('*')
			->from($this->_table);
		if($keyword) {
			$select->where('account_name', '=', $keyword);
			$select->or_where('message', 'LIKE', '%'.$keyword.'%');
		}
		if($offset) {
			$select->offset($offset);
		}
		if($number) {
			$select->limit($number);
		}
		return $select->order_by($this->_primaryKey, 'DESC')
			->as_object($this->_modelName)
			->execute($this->_db);
	}
}