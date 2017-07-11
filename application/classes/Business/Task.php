<?php
/**
 * 业务逻辑层 - 任务
 * @author: phachon@163.com
 */
class Business_Task extends Business {

	/**
	 * 创建任务
	 * @param array $values
	 * @return integer
	 * @throws Business_Exception
	 */
	public function create($values = []) {

		$fields = array (
			'service_id' => '',
			'ip' => '',
			'type' => Dao_Task::TYPE_DEFAULT,
			'exec_status' => Dao_Task::EXEC_STATUS_DEFAULT,
			'create_time' => time(),
			'update_time' => time(),
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;
		$serviceId = Arr::get($values, 'service_id', 0);
		$ip = Arr::get($values, 'ip', '');

		$errors = [];
		if(!$serviceId) {
			$errors[] = '实例id不能为0';
		}
		if(!is_numeric($serviceId)) {
			$errors[] = '实例id不合法';
		}
		if(!$ip) {
			$errors[] = 'ip不能为空';
		}
		if($errors) {
			throw new Business_Exception(implode("\n",$errors));
		}

		return Dao::factory('Task')->insert($values);
	}

	/**
	 * 根据 ip 查找任务
	 * @param $ip
	 */
	public function getTaskByIp($ip) {
		return Dao::factory('Task')->getTaskByIp($ip);
	}

	/**
	 * 根据 ip 来获取待执行的任务
	 * @param string $ip
	 * @return bool
	 */
	public function getDefaultTaskByIp($ip = '') {
		if(!$ip) {
			return FALSE;
		}
		return Dao::factory('Task')->getTaskByIpAndStatus($ip, Dao_Task::EXEC_STATUS_DEFAULT);
	}

	/**
	 * 根据关键字获取任务的数量
	 * @param string $keyword
	 * @return array
	 */
	public function countTasksByKeyword($keyword) {
		return Dao::factory('Task')->countTasksByKeyword($keyword);
	}

	/**
	 * 根据关键字分页获取任务
	 * @param string $keyword
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getTasksByKeywordAndLimit($keyword, $offset, $number) {
		return Dao::factory('Task')->getTasksByKeywordAndLimit($keyword, $offset, $number);
	}

	/**
	 * 获取任务总数
	 * @return array
	 */
	public function countTasks() {
		return Dao::factory('Task')->countTasks();
	}

	/**
	 * 分页获取任务信息
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getTasksByLimit($offset, $number) {
		return Dao::factory('Task')->getTasksByLimit($offset, $number);
	}

	/**
	 * 根据 task_id 来查找任务
	 * @param integer $taskId
	 * @return mixed
	 */
	public function getTaskByTaskId($taskId = 0) {
		if(!$taskId) {
			return FALSE;
		}
		return Dao::factory('Task')->getTaskByTaskId($taskId);
	}

	/**
	 * 获取所有的任务
	 */
	public function getTasks() {
		return Dao::factory('Task')->getTasks();
	}

	/**
	 * 根据 task_id 来修改状态
	 * @param integer $status
	 * @param string $results
	 * @param integer $taskId
	 * @return mixed
	 */
	public function updateStatusByTaskId($status, $results, $taskId) {
		if(!$taskId) {
			return FALSE;
		}

		$values = [
			'exec_status' => $status,
			'exec_results' => $results,
			'update_time' => time()
		];

		return Dao::factory('Task')->updateByTaskId($values, $taskId);
	}

	/**
	 * 根据 service_id 和 type查找任务
	 * @param $serviceId
	 * @param $type
	 * @param $status
	 * @return
	 */
	public function getTaskByServiceIdAndTypeAndStatus($serviceId, $type, $status) {
		return Dao::factory('Task')->getTaskByServiceIdAndTypeAndStatus($serviceId, $type, $status);
	}
}