<?php
/**
 * 任务接口
 * @author: phachon@163.com
 */
class Controller_Interface_Task extends Controller_Api {

	/**
	 * 通过 ip 来取任务
	 */
	public function action_getTaskByIp() {

		$ip = trim(Arr::get($_GET, 'ip', ''));
		if(!$ip) {
			return $this->failed('ip error');
		}

		//判断ip是否合法
		$machines = Business::factory('Machine')->getMachineByIp($ip);
		if(!$machines->count()) {
			return $this->failed('ip 不存在');
		}

		$tasks = Business::factory('Task')->getDefaultTaskByIp($ip)->as_array();

		$this->_data = $tasks;
	}

	/**
	 * 任务执行完成回调
	 */
	public function action_callback() {

		$taskId = trim(Arr::get($_POST, 'task_id', ''));
		$execStatus = intval(trim(Arr::get($_POST, 'exec_status', 0)));
		$execResults = trim(Arr::get($_POST, 'exec_results', ''));

		if(!$taskId) {
			return $this->failed('task_id error');
		}

		//任务是否存在
		$tasks = Business::factory('Task')->getTaskByTaskId($taskId);
		if(!$tasks->count()) {
			return $this->failed('任务不存在');
		}

		$task = $tasks->current();
		if($task->exec_status != Model_Task::EXEC_STATUS_DEFAULT) {
			return $this->success();
		}

		try {
			Business::factory('Task')->updateStatusByTaskId($execStatus, $execResults, $taskId);
		}catch (Exception $e) {
			return $this->failed($e->getMessage());
		}

		//修改实例的状态
		$type = $task->type;
		$serviceId = $task->service_id;
		$serviceStatus = Model_Service::STATUS_WAIT;
		if($type == Model_Task::TYPE_START) {
			$serviceStatus = Model_Service::STATUS_START;
		}
		if($type == Model_Task::TYPE_STOP) {
			$serviceStatus = Model_Service::STATUS_STOP;
		}
		if($type == Model_Task::TYPE_REBUILD) {
			$serviceStatus = Model_Service::STATUS_START;
		}

		try {
			Business::factory('Service')->updateStatusByServiceId($serviceStatus, $serviceId);
		}catch (Exception $e) {
			return $this->failed($e->getMessage());
		}

		$this->success();
	}

}