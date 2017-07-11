<?php
/**
 * sphinx 任务操作封装
 * @author: panchao
 */
class Sphinx_Task {

	const TYPE_DEFAULT = 0;
	const TYPE_START = 1;
	const TYPE_STOP = 2;
	const TYPE_REBUILD = 3;

	const EXEC_STATUS_FAILED = -1;
	const EXEC_STATUS_SUCCESS = 1;
	const EXEC_STATUS_DEFAULT = 0;

	/**
	 * 添加任务
	 * @param $serviceId
	 * @param int $type
	 * @return bool
	 */
	public static function add($serviceId, $type = 0) {

		//service_id 是否存在
		$services = Business::factory('Service')->getServiceByServiceId($serviceId);
		if(!$services || !$services->count()) {
			return FALSE;
		}
		//machine 是否存在
		$machineId = $services->current()->machine_id;
		$machines = Business::factory('Machine')->getMachineByMachineId($machineId);
		if(!$machines->count()) {
			return FALSE;
		}
		$ip = $machines->current()->ip;
		//实例字段配置
		$columns = Business::factory('Service_Column')->getServiceColumnsByServiceId($serviceId);
		if(!$columns->count()) {
			return FALSE;
		}
		//实例索引配置
		$indexers = Business::factory('Service_Indexer')->getServiceIndexerByServiceId($serviceId);
		if(!$indexers->count()) {
			return FALSE;
		}
		//实例进程配置
		$searchd = Business::factory('Service_Searchd')->getServiceSearchdByServiceId($serviceId);
		if(!$searchd->count()) {
			return FALSE;
		}

		$values = [
			'service_id' => intval($serviceId),
			'ip' => $ip,
			'type' => intval($type),
			'create_time' => time(),
			'update_time' => time(),
		];

		//判断任务是否已存在
		$tasks = Business::factory('task')->getTaskByServiceIdAndTypeAndStatus($serviceId, $type, self::EXEC_STATUS_DEFAULT);
		if($tasks->count()) {
			return FALSE;
		}

		//修改实例状态为 wait
		Business::factory('Service')->updateStatusByServiceId(Model_Service::STATUS_WAIT, $serviceId);

		//插入任务
		$results = Business::factory('Task')->create($values);

//		Logs::instance()->write($serviceId." 添加 $type 任务");
		return $results;
	}

}