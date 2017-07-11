<?php
/**
 * 任务
 * @author: phachon@163.com
 */
class Task {

	const EXEC_STATUS_FAILED = -1;
	const EXEC_STATUS_SUCCESS = 1;
	const EXEC_STATUS_DEFAULT = 0;

	/**
	 * @var null
	 */
	protected static $_instance = null;

	/**
	 * ip
	 * @var string
	 */
	protected $_ip = '';

	/**
	 * uri
	 * @var string
	 */
	protected $_uri = [];

	/**
	 * @return null|Task
	 */
	public static function instance() {
		if(self::$_instance === null) {
			$ip = Config::load('machine')['ip'];
			$uri = Config::load('uri');
			self::$_instance = new self($ip, $uri);
		}

		return self::$_instance;
	}

	/**
	 * Task constructor.
	 * @param $ip
	 * @param $uri
	 */
	private function __construct($ip = '', $uri = []) {
		$this->_ip = $ip ? $ip : '';
		$this->_uri = $uri ? $uri : [];
	}

	/**
	 * 根据 ip 获取任务
	 * @throws Exception
	 * @throws Sphinx_Exception
	 */
	public function getTasksByIp() {

		if(!$this->_ip) {
			throw new Exception('ip must not empty!');
		}
		if(!$this->_uri['getTaskByIp']) {
			throw new Exception('uri must not empty!');
		}

		$data = [
			'ip' => $this->_ip,
		];

		$response = Curl::instance()
			->timeout('10')
			->url($this->_uri['getTaskByIp'])
			->get($data);
		$taskValues = $response->getData();

		return $taskValues;
	}

	/**
	 * 成功上报
	 * @param $taskId
	 * @param $message
	 * @throws Exception
	 */
	public function successTask($taskId, $message) {
		$this->_taskCallback(self::EXEC_STATUS_SUCCESS, $message, $taskId);
	}

	/**
	 * 失败上报
	 * @param $taskId
	 * @param $message
	 * @throws Exception
	 */
	public function failedTask($taskId, $message) {
		$this->_taskCallback(self::EXEC_STATUS_FAILED, $message, $taskId);
	}

	/**
	 * 上报任务执行结果
	 * @param $status
	 * @param $message
	 * @param $taskId
	 * @return bool
	 * @throws Exception
	 */
	protected function _taskCallback($status, $message, $taskId) {

		if(!$this->_uri['taskCallback']) {
			throw new Exception('uri must not empty!');
		}

		$data = [
			'task_id' => $taskId,
			'exec_status' => $status,
			'exec_results' => $message
		];

		$response = Curl::instance()
			->timeout('10')
			->url($this->_uri['taskCallback'])
			->post($data);

		if($response->httpCode() != 200) {
			throw new Exception('Request task callback uri failed: '.$response->getMessage());
		}

		return TRUE;
	}

}