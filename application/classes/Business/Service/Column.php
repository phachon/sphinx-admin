<?php
/**
 * 实例字段 -- 业务逻辑
 * @author: panchao
 */
class Business_Service_Column extends Business {

	/**
	 * 创建一条数据源字段信息
	 * @param $values
	 * @return
	 * @throws Business_Exception
	 */
	public function create($values) {

		$fields = [
			'service_id' => 0,
			'column' => '',
			'column_attr' => '',
			'is_id_column' => Dao_Service_Column::IS_ID_COLUMN_FALSE,
			'sql_condition' => '',
			'create_time' => time(),
			'update_time' => time(),
		];

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		$serviceId = Arr::get($values, 'service_id', 0);
		$column = Arr::get($values, 'column', '');
		$columnAttr = Arr::get($values, 'column_attr', '');

		$errors = [];
		if(!$serviceId) {
			$errors[] = 'service_id 错误';
		}
		if(!$column) {
			$errors[] = '字段名不能为空';
		}
		if(!$columnAttr) {
			$errors[] = '字段属性不能为空';
		}

		//一个实例下的字段唯一
		$column = Dao::factory('Service_Column')->getColumnByColumn($column);
		if($column->count()) {
			throw new Business_Exception('字段名已经存在');
		}

		return Dao::factory('Service_Column')->insert($values);
	}

	/**
	 * 根据 service_id 来查找实例字段
	 * @param $serviceId
	 * @return object
	 */
	public function getServiceColumnsByServiceId($serviceId) {
		return Dao::factory('Service_Column')->getServiceColumnsByServiceId($serviceId);
	}

	/**
	 * 批量插入
	 * @param $values
	 */
	public function createBatch($values) {

		Dao::factory('Service_Column')->deleteByServiceId($values[0]['service_id']);

		return Dao::factory('Service_Column')->insertBatch($values);
	}

}