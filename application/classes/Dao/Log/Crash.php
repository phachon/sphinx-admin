<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 异常日志 dao 层 
 * @author phachon@163.com
 */
class Dao_Log_Crash extends Dao {

	protected $_db = 'sphinx';
	
	protected $_table = 'log_crash';
	
	protected $_primaryKey = 'log_crash_id';

	protected $_modelName = 'Model_Log_Crash';

	/**
	 * 获取异日志常总数
	 * @return integer
	 */
	public function countCrashLogs() {
		return DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_table)
			->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 分页获取异常日志
	 * @param  integer $offset
	 * @param  integer $number
	 * @return array
	 */
	public function getCrashLogsByLimit($offset, $number) {

		$select = DB::select('*')
			->from($this->_table);
		if($offset) {
			$select->offset($offset);
		}
		if($number) {
			$select->limit($number);
		}
		return $select->order_by('log_crash_id', 'DESC')
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据关键字获取异日志常总数
	 * @param  string $keyword
	 * @return integer
	 */
	public function countCrashLogsByKeyword($keyword) {
		$select = DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_table);
		if($keyword) {
			$select->where('file', 'LIKE', '%'.$keyword.'%');
			$select->or_where('message', 'LIKE', '%'.$keyword.'%');
			$select->or_where('ip', 'LIKE', '%'.$keyword.'%');
			$select->or_where('hostname', 'LIKE', '%'.$keyword.'%');
		}
		return $select->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 根据关键字分页获取异常日志
	 * @param  string $keyword
	 * @param  integer $offset
	 * @param  integer $number
	 * @return array
	 */
	public function getCrashLogsByLimitAndKeyword($keyword, $offset, $number) {

		$select = DB::select('*')
			->from($this->_table)
			->order_by($this->_primaryKey, 'DESC');
		if($keyword) {
			$select->where('file', 'LIKE', '%'.$keyword.'%');
			$select->or_where('message', 'LIKE', '%'.$keyword.'%');
			$select->or_where('ip', 'LIKE', '%'.$keyword.'%');
			$select->or_where('hostname', 'LIKE', '%'.$keyword.'%');
		}
		if($number) {
			$select->limit($number);
		}
		if($offset) {
			$select->offset($offset);
		}
		return $select->as_object($this->_modelName)
			->execute($this->_db);
	}
}