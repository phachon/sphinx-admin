<?php
/**
 * 数据访问 - 实例
 * @author: phachon@163.com
 */
class Dao_Service extends Dao {

	protected $_db = 'sphinx';

	protected $_tableName = 'service';

	protected $_primaryKey = 'service_id';

	protected $_modelName = 'Model_Service';

	const STATUS_DELETE = -1;
	const STATUS_STOP = 0;
	const STATUS_START = 1;
	const STATUS_WAIT = 2;

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
	 * 根据 machine_id 查找实例
	 * @param $machineId
	 * @return object
	 */
	public function getServiceByMachineId($machineId) {
		return DB::select('*')
			->from($this->_tableName)
			->where('machine_id', '=', $machineId)
			->and_where('status', '!=', self::STATUS_DELETE)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 name 查找实例
	 * @param $name
	 * @return object
	 */
	public function getServiceByName($name) {
		return DB::select('*')
			->from($this->_tableName)
			->where('name', '=', $name)
			->and_where('status', '!=', self::STATUS_DELETE)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据关键字获取实例数量
	 * @param string $keyword
	 * @return array
	 */
	public function countServicesByKeyword($keyword) {
		$select = DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_tableName)
			->and_where('status', '!=', self::STATUS_DELETE);
		if($keyword) {
			$select->and_where_open()
				->or_where('name', 'LIKE', '%'.$keyword.'%')
				->or_where('source_name', 'LIKE', '%'.$keyword.'%')
				->or_where('machine_id', '=', $keyword)
				->and_where_close();
		}
		return $select->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 根据关键字分页获取实例
	 * @param string $keyword
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getServicesByKeywordAndLimit($keyword, $offset, $number) {

		$select = DB::select('*')
			->from($this->_tableName)
			->and_where('status', '!=', self::STATUS_DELETE);
		if($keyword) {
			$select->and_where_open()
				->or_where('name', 'LIKE', '%'.$keyword.'%')
				->or_where('source_name', 'LIKE', '%'.$keyword.'%')
				->or_where('machine_id', '=', $keyword)
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
	 * 获取实例总数
	 * @return array
	 */
	public function countServices() {
		return DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_tableName)
			->and_where('status', '!=', self::STATUS_DELETE)
			->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 分页获取实例信息
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getServicesByLimit($offset, $number) {

		$select = DB::select('*')
			->from($this->_tableName)
			->and_where('status', '!=', self::STATUS_DELETE);
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
	 * 根据 service_id 来查找正常的实例
	 * @param integer $serviceId
	 * @return array
	 */
	public function getServiceByServiceId($serviceId) {
		return DB::select('*')
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $serviceId)
			->and_where('status', '!=', self::STATUS_DELETE)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 service_id 修改实例信息
	 * @param array $values
	 * @param integer $serviceId
	 * @return integer
	 */
	public function updateByServiceId($values, $serviceId) {
		return DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $serviceId)
			->execute($this->_db);
	}

	/**
	 * 获取所有的实例
	 * @return array
	 */
	public function getServices() {
		return DB::select('*')
			->from($this->_tableName)
			->and_where('status', '!=', self::STATUS_DELETE)
			->as_object($this->_modelName)
			->execute();
	}

	/**
	 * 根据 machine_id 和 name 查找实例
	 * @param $machineId
	 * @param $name
	 * @return object
	 */
	public function getServiceByMachineAndName($machineId, $name) {
		return DB::select('*')
			->from($this->_tableName)
			->and_where('status', '!=', self::STATUS_DELETE)
			->and_where('machine_id', '=', $machineId)
			->and_where('name', '=', $name)
			->as_object($this->_modelName)
			->execute();
	}

	/**
	 * 根据 machine_id 和 source_name 查找实例
	 * @param $machineId
	 * @param $sourceName
	 * @return object
	 */
	public function getServiceByMachineAndSourceName($machineId, $sourceName) {
		return DB::select('*')
			->from($this->_tableName)
			->and_where('status', '!=', self::STATUS_DELETE)
			->and_where('machine_id', '=', $machineId)
			->and_where('source_name', '=', $sourceName)
			->as_object($this->_modelName)
			->execute();
	}

	/**
	 * 根据 machine_id 和 sql_host 来查找实例
	 * @param $machineId
	 * @param $sqlHost
	 * @return object
	 */
	public function getServiceByMachineAndSqlHost($machineId, $sqlHost) {
		return DB::select('*')
			->from($this->_tableName)
			->and_where('status', '!=', self::STATUS_DELETE)
			->and_where('machine_id', '=', $machineId)
			->and_where('sql_host', '=', $sqlHost)
			->as_object($this->_modelName)
			->execute();
	}
}