<?php
/**
 * 实例进程 -- 数据访问
 * @author: panchao
 */
class Dao_Service_Searchd extends Dao {

	protected $_db = 'sphinx';

	protected $_tableName = 'service_searchd';

	protected $_primaryKey = 'service_searchd_id';

	protected $_modelName = 'Model_Service_Searchd';

	const STATUS_NORMAL = 0;
	const STATUS_DISABLE = -1;

	const IS_ID_COLUMN_TRUE = 1;
	const IS_ID_COLUMN_FALSE = 0;

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
	 * 根据 service_id 来查找进程信息
	 * @param $serviceId
	 * @return object
	 */
	public function getServiceSearchdByServiceId($serviceId) {
		return DB::select('*')
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL)
			->and_where('service_id', '=', $serviceId)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 service_ids 来查找进程信息
	 * @param $serviceIds
	 * @return object
	 */
	public function getServiceSearchdByServiceIds($serviceIds) {
		return DB::select('*')
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL)
			->and_where('service_id', 'IN', $serviceIds)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 service_searchd_id 来修改实例进程
	 * @param $values
	 * @param $serviceSearchdId
	 * @return object
	 */
	public function updateBySearchdId($values, $serviceSearchdId) {
		return DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $serviceSearchdId)
			->execute($this->_db);
	}
}