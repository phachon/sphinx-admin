<?php
/**
 * 实例索引 -- 业务逻辑
 * @author: panchao
 */
class Business_Service_Indexer extends Business {

	/**
	 * 创建一条数据源索引信息
	 * @param $values
	 * @return
	 * @throws Business_Exception
	 */
	public function create($values) {

		$fields = [
			'service_id' => 0,
			'name' => '',
			'type' => '',
			'status' => Dao_Service_Indexer::STATUS_NORMAL,
			'create_time' => time(),
			'update_time' => time(),
		];

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		$serviceId = Arr::get($values, 'service_id', 0);
		$name = Arr::get($values, 'name', '');
		$type = Arr::get($values, 'type', '');

		$errors = [];
		if(!$serviceId) {
			$errors[] = 'service_id 错误';
		}
		if(!$name) {
			$errors[] = '索引名不能为空';
		}
		if(!$type) {
			$errors[] = '没有选择索引类型';
		}
		if($errors) {
			throw new Business_Exception($errors[0]);
		}

		//一个实例下的索引名唯一
		$indexers = Dao::factory('Service_Indexer')->getIndexerByNameAndServiceId($name, $serviceId);
		if($indexers->count()) {
			throw new Business_Exception('该实例下索引名已经存在');
		}

		return Dao::factory('Service_Indexer')->insert($values);
	}

	/**
	 * 根据 service_id 来获取索引信息
	 * @param $serviceId
	 */
	public function getServiceIndexerByServiceId($serviceId) {
		return Dao::factory('Service_Indexer')->getServiceIndexerByServiceId($serviceId);
	}

	/**
	 * 根据主键查找索引
	 * @param $serviceIndexerId
	 * @return mixed
	 */
	public function getServiceIndexerByServiceIndexerId($serviceIndexerId) {
		return Dao::factory('Service_Indexer')->getServiceIndexerByServiceIndexerId($serviceIndexerId);
	}

	/**
	 * 根据主键修改
	 * @param $values
	 * @param $serviceIndexerId
	 * @throws Business_Exception
	 */
	public function updateByServiceIndexerId($values, $serviceIndexerId) {

		$fields = [
			'service_id' => 0,
			'name' => '',
			'type' => '',
		];

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		$serviceId = Arr::get($values, 'service_id', 0);
		$name = Arr::get($values, 'name', '');
		$type = Arr::get($values, 'type', '');

		$errors = [];
		if(!$serviceId) {
			$errors[] = 'service_id 错误';
		}
		if(!$name) {
			$errors[] = '索引名不能为空';
		}
		if(!$type) {
			$errors[] = '没有选择索引类型';
		}
		if($errors) {
			throw new Business_Exception($errors[0]);
		}

		//一个实例下的索引名唯一
		$indexers = Dao::factory('Service_Indexer')->getIndexerByNameAndServiceId($name, $serviceId);
		if($indexers->count() > 2 || ($indexers->count() == 1 && $indexers->current()->service_indexer_id != $serviceIndexerId)) {
			throw new Business_Exception('该实例下索引名已经存在');
		}

		return Dao::factory('Service_Indexer')->updateByServiceIndexerId($values, $serviceIndexerId);
	}
}