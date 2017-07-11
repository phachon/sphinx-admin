<?php
/**
 * 实例索引 -- 数据访问
 * @author: phachon@163.com
 */
class Dao_Service_Indexer extends Dao {

	protected $_db = 'sphinx';

	protected $_tableName = 'service_indexer';

	protected $_primaryKey = 'service_indexer_id';

	protected $_modelName = 'Model_Service_Indexer';

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
	 * 根据 service_id 和 name 查找索引
	 * @param $name
	 * @param $serviceId
	 * @return object
	 */
	public function getIndexerByNameAndServiceId($name, $serviceId) {
		return DB::select('*')
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL)
			->and_where('service_id', '=', $serviceId)
			->and_where('name', '=', $name)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 service_id 来查找索引
	 * @param $serviceId
	 * @return object
	 */
	public function getServiceIndexerByServiceId($serviceId) {
		return DB::select('*')
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL)
			->and_where('service_id', '=', $serviceId)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据主键查找索引
	 * @param $serviceIndexerId
	 * @return object
	 */
	public function getServiceIndexerByServiceIndexerId($serviceIndexerId) {
		return DB::select('*')
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL)
			->and_where($this->_primaryKey, '=', $serviceIndexerId)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 service_indexer_id 来修改实例索引
	 * @param $values
	 * @param $serviceIndexerId
	 * @return object
	 */
	public function updateByServiceIndexerId($values, $serviceIndexerId) {
		return DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $serviceIndexerId)
			->execute($this->_db);
	}
}