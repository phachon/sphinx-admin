<?php
/**
 * 实例接口
 * @author: phachon@163.com
 */
class Controller_Interface_Service extends Controller_Api {

	/**
	 * 根据 service_id 获取实例信息
	 */
	public function action_getServiceByServiceId() {

		$serviceId = Arr::get($_GET, 'service_id', 0);
		if(!$serviceId || !is_numeric($serviceId)) {
			return $this->failed('service_id error');
		}

		$serviceValues = [
			'service' => [],
			'machine' => [],
			'column' => [],
			'indexer' => [],
			'searchd' => [],
		];

		$services = Business::factory('Service')->getServiceByServiceId($serviceId)->as_array();
		if(!$services) {
			return $this->failed('service 不存在');
		}
		$service = get_object_vars($services[0]);
		$serviceValues['service'] = $service;
		$machineId = $service['machine_id'];
		$machines = Business::factory('Machine')->getMachineByMachineId($machineId)->as_array();
		if($machines) {
			$serviceValues['machine'] = $machines[0];
		}

		//实例字段配置
		$columns = Business::factory('Service_Column')->getServiceColumnsByServiceId($serviceId)->as_array();
		if($columns) {
			$serviceValues['column'] = $columns;
		}

		//实例索引配置
		$indexers = Business::factory('Service_Indexer')->getServiceIndexerByServiceId($serviceId)->as_array();
		if($indexers) {
			$serviceValues['indexer'] = $indexers;
		}

		//实例进程配置
		$searchd = Business::factory('Service_Searchd')->getServiceSearchdByServiceId($serviceId)->as_array();
		if($searchd) {
			$serviceValues['searchd'] = $searchd[0];
		}
	
		$this->_data = $serviceValues;
	}
}