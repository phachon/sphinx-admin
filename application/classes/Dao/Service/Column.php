<?php
/**
 * 实例字段 -- 数据访问
 * @author: phachon@163.com
 */
class Dao_Service_Column extends Dao {

	protected $_db = 'sphinx';

	protected $_tableName = 'service_column';

	protected $_primaryKey = 'service_column_id';

	protected $_modelName = 'Model_Service_Column';

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
	 * 根据字段名来查找字段
	 * @param $column
	 * @return object
	 */
	public function getColumnByColumn($column) {
		return DB::select('*')
			->from($this->_tableName)
			->and_where('column', '=', $column)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 service_id 来获取字段
	 * @param $serviceId
	 * @return object
	 */
	public function getServiceColumnsByServiceId($serviceId) {
		return DB::select('*')
			->from($this->_tableName)
			->and_where('service_id', '=', $serviceId)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 批量插入
	 * @param $values
	 * @return object
	 */
	public function insertBatch($values) {
		$insert = DB::insert($this->_tableName)
			->columns(array_keys($values[0]));
		foreach ($values as $value) {
			$insert->values(array_values($value));
		}
		return $insert->execute($this->_db);
	}

	/**
	 * 根据 service_id
	 * @param $serviceId
	 * @return object
	 */
	public function deleteByServiceId($serviceId) {
		return DB::delete($this->_tableName)
			->where('service_id', '=', $serviceId)
			->execute($this->_db);
	}
}