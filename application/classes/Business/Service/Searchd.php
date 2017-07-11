<?php
/**
 * 实例进程
 * @author: phachon@163.com
 */
class Business_Service_Searchd extends Business {

	/**
	 * 创建一条实例进程信息
	 * @param $values
	 * @return
	 * @throws Business_Exception
	 */
	public function create($values) {

		$fields = [
			'service_id' => 0,
			'sphinx_listen' => 0,
			'mysql_listen' => 0,
			'read_timeout' => 0,
			'client_timeout' => 0,
			'status' => Dao_Service_Searchd::STATUS_NORMAL,
			'create_time' => time(),
			'update_time' => time(),
		];

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		$serviceId = Arr::get($values, 'service_id', 0);
		$sphinxListen = Arr::get($values, 'sphinx_listen', 0);
		$mysqlListen = Arr::get($values, 'mysql_listen', 0);
		$readTimeout = Arr::get($values, 'read_timeout', 0);
		$clientTimeout = Arr::get($values, 'client_timeout', 0);

		$errors = [];
		if(!$serviceId) {
			$errors[] = 'service_id 错误';
		}
		if(!$sphinxListen) {
			$errors[] = 'sphinx 监听端口不能为空';
		}
		if(!$mysqlListen) {
			$errors[] = 'mysql 监听端口不能为空';
		}
		if(!$readTimeout) {
			$errors[] = '客户端读超时时间不能为空';
		}
		if(!$clientTimeout) {
			$errors[] = '客户端连接超时时间不能为空';
		}
		if($errors) {
			throw new Business_Exception($errors[0]);
		}

		//该实例的机器
		$machines = Dao::factory('Service')->getServiceByServiceId($serviceId);
		if(!$machines->count()) {
			throw new Business_Exception('该实例下的机器不存在');
		}
		$machineId = $machines->current()->machine_id;
		// 该机器下的实例
		$machineServices = Dao::factory('Service')->getServiceByMachineId($machineId);
		$serviceIds = [];
		foreach ($machineServices as $machineService) {
			$serviceIds[] = $machineService->service_id;
		}
		//该机器下的实例进程
		$searchds = Dao::factory('Service_Searchd')->getServiceSearchdByServiceIds($serviceIds);
		$sphinxListens = [];
		$mysqlListens = [];
		foreach ($searchds as $searchd) {
			$sphinxListens[] = $searchd->sphinx_listen;
			$mysqlListens[] = $searchd->mysql_listen;
		}

		if(in_array($sphinxListen, $sphinxListens)) {
			throw new Business_Exception('该实例所在机器的sphinx端口已被占用');
		}
		if(in_array($mysqlListen, $sphinxListens)) {
			throw new Business_Exception('该实例所在机器的mysql端口已被占用');
		}

		return Dao::factory('Service_Searchd')->insert($values);
	}

	/**
	 * 根据 service_id 来查找进程
	 * @param $serviceId
	 */
	public function getServiceSearchdByServiceId($serviceId) {
		return Dao::factory('Service_Searchd')->getServiceSearchdByServiceId($serviceId);
	}

	/**
	 * 根据 service_searchd_id 来修改
	 * @param $values
	 * @param $serviceSearchdId
	 * @throws Business_Exception
	 */
	public function updateBySearchdId($values, $serviceSearchdId) {

		$fields = [
			'service_id' => 0,
			'read_timeout' => 0,
			'client_timeout' => 0,
			'update_time' => time(),
		];

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		$serviceId = Arr::get($values, 'service_id', 0);
		$readTimeout = Arr::get($values, 'read_timeout', 0);
		$clientTimeout = Arr::get($values, 'client_timeout', 0);

		$errors = [];
		if(!$serviceId) {
			$errors[] = 'service_id 错误';
		}
		if(!$readTimeout) {
			$errors[] = '客户端读超时时间不能为空';
		}
		if(!$clientTimeout) {
			$errors[] = '客户端连接超时时间不能为空';
		}
		if($errors) {
			throw new Business_Exception($errors[0]);
		}

		return Dao::factory('Service_Searchd')->updateBySearchdId($values, $serviceSearchdId);
	}
}