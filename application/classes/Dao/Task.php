<?php
/**
 * 数据访问 - 任务
 * @author: phachon@163.com
 */
class Dao_Task extends Dao {

	protected $_db = 'sphinx';

	protected $_tableName = 'task';

	protected $_primaryKey = 'task_id';

	protected $_modelName = 'Model_Task';

	const EXEC_STATUS_DEFAULT = 0;
	const EXEC_STATUS_SUCCESS = 1;
	const EXEC_STATUS_FAILED = -1;

	const TYPE_DEFAULT = 0;
	const TYPE_START = 1;
	const TYPE_STOP = 2;
	const TYPE_REBUILD = 3;

	/**
	 * 插入一条任务
	 * @param array $values
	 * @return array
	 */
	public function insert(array $values) {
		return DB::insert($this->_tableName)
			->columns(array_keys($values))
			->values(array_values($values))
			->execute($this->_db);
	}

	/**
	 * 根据ip查找任务
	 * @param $ip
	 * @return object
	 */
	public function getTaskByIp($ip) {
		return DB::select('*')
			->from($this->_tableName)
			->where('ip', '=', $ip)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据ip查找任务
	 * @param $ip
	 * @param $status
	 * @return object
	 */
	public function getTaskByIpAndStatus($ip, $status) {
		return DB::select('*')
			->from($this->_tableName)
			->where('ip', '=', $ip)
			->and_where('exec_status', '=', $status)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据关键字获取任务数量
	 * @param string $keyword
	 * @return array
	 */
	public function countTasksByKeyword($keyword) {
		$select = DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_tableName);
		if($keyword) {
			$select->and_where_open()
				->or_where('ip', '=', $keyword)
				->or_where('service_id', '=', $keyword)
				->and_where_close();
		}
		return $select->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 根据关键字分页获取任务
	 * @param string $keyword
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getTasksByKeywordAndLimit($keyword, $offset, $number) {

		$select = DB::select('*')
			->from($this->_tableName);
		if($keyword) {
			$select->and_where_open()
				->or_where('ip', '=', $keyword)
				->or_where('service_id', '=', $keyword)
				->and_where_close();
		}
		if($offset) {
			$select->offset($offset);
		}
		if($number) {
			$select->limit($number);
		}

		$select->order_by($this->_primaryKey, 'DESC');

		return $select->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 获取任务总数
	 * @return array
	 */
	public function countTasks() {
		return DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_tableName)
			->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 分页获取任务信息
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getTasksByLimit($offset, $number) {

		$select = DB::select('*')
			->from($this->_tableName);
		if($offset) {
			$select->offset($offset);
		}
		if($number) {
			$select->limit($number);
		}

		$select->order_by($this->_primaryKey, 'DESC');

		return $select->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 task_id 来查找正常的任务
	 * @param integer $taskId
	 * @return array
	 */
	public function getTaskByTaskId($taskId) {
		return DB::select('*')
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $taskId)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 task_id 修改任务信息
	 * @param array $values
	 * @param integer $taskId
	 * @return integer
	 */
	public function updateByTaskId($values, $taskId) {
		return DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $taskId)
			->execute($this->_db);
	}

	/**
	 * 获取所有的任务
	 * @return array
	 */
	public function getTasks() {
		return DB::select('*')
			->from($this->_tableName)
			->as_object($this->_modelName)
			->execute();
	}

	/**
	 * 根据 service_id 和 type 查找任务
	 * @param $serviceId
	 * @param $type
	 * @param $status
	 * @return object
	 */
	public function getTaskByServiceIdAndTypeAndStatus($serviceId, $type, $status) {
		return DB::select('*')
			->from($this->_tableName)
			->where('service_id', '=', $serviceId)
			->and_where('type', '=', $type)
			->and_where('exec_status', '=', $status)
			->as_object($this->_modelName)
			->execute($this->_db);
	}
}