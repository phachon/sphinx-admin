<?php
/**
 * 数据访问 - 机器
 * @author: panchao
 */
class Dao_Machine extends Dao {

	protected $_db = 'sphinx';

	protected $_tableName = 'machine';

	protected $_primaryKey = 'machine_id';

	protected $_modelName = 'Model_Machine';

	const STATUS_NORMAL = 0;
	const STATUS_DELETE = -1;

	/**
	 * 插入一条信息
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
	 * 根据ip查找机器
	 * @param $ip
	 * @return object
	 */
	public function getMachineByIp($ip) {
		return DB::select('*')
			->from($this->_tableName)
			->where('ip', '=', $ip)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据关键字获取机器数量
	 * @param string $keyword
	 * @return array
	 */
	public function countMachinesByKeyword($keyword) {
		$select = DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL);
		if($keyword) {
			$select->and_where_open()
				->or_where('domain', 'LIKE', '%'.$keyword.'%')
				->or_where('ip', '=', $keyword)
				->and_where_close();
		}
		return $select->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 根据关键字分页获取机器
	 * @param string $keyword
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getMachinesByKeywordAndLimit($keyword, $offset, $number) {

		$select = DB::select('*')
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL);
		if($keyword) {
			$select->and_where_open()
				->or_where('domain', 'LIKE', '%'.$keyword.'%')
				->or_where('ip', '=', $keyword)
				->and_where_close();
		}
		if($offset) {
			$select->offset($offset);
		}
		if($number) {
			$select->limit($number);
		}

		return $select->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 获取机器总数
	 * @return array
	 */
	public function countMachines() {
		return DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_tableName)
			->and_where('status', '=', self::STATUS_NORMAL)
			->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 分页获取机器信息
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getMachinesByLimit($offset, $number) {

		$select = DB::select('*')
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL);
		if($offset) {
			$select->offset($offset);
		}
		if($number) {
			$select->limit($number);
		}

		return $select->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 machine_id 来查找正常的机器
	 * @param integer $machineId
	 * @return array
	 */
	public function getMachineByMachineId($machineId) {
		return DB::select('*')
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $machineId)
			->and_where('status', '=', self::STATUS_NORMAL)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 machine_id 修改机器信息
	 * @param array $values
	 * @param integer $machineId
	 * @return integer
	 */
	public function updateByMachineId($values, $machineId) {
		return DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $machineId)
			->execute($this->_db);
	}

	/**
	 * 获取所有的机器
	 * @return array
	 */
	public function getMachines() {
		return DB::select('*')
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL)
			->as_object($this->_modelName)
			->execute();
	}
}