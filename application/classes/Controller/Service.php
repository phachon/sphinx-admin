<?php
/**
 * 实例管理
 * @author: panchao
 */
class Controller_Service extends Controller_Render {

	protected $_default = 'layouts/service';

	/**
	 * index
	 */
	public function action_index() {
		Controller::redirect('service/list');
	}

	/**
	 * 实例列表
	 */
	public function action_list() {

		$keyword = trim(Arr::get($_GET, 'keyword', ''));
		if($keyword) {
			$total = Business::factory('Service')->countServicesBykeyword($keyword);
			$paginate = Paginate::factory($total);
			$services = Business::factory('Service')->getServicesByKeywordAndLimit($keyword, $paginate->offset(), $paginate->number());
		} else {
			$total = Business::factory('Service')->countServices();
			$paginate = Paginate::factory($total);
			$services = Business::factory('Service')->getServicesByLimit($paginate->offset(), $paginate->number());
		}

		$this->_default->content = View::factory('service/list')
			->set('services', $services)
			->set('paginate', $paginate);
	}

	/**
	 * 实例信息
	 */
	public function action_info() {
		$this->_headerRender = FALSE;

		$serviceId = Arr::get($_GET, 'service_id', 0);
		if(!$serviceId) {
			Prompt::warningView('service_id 不合法', URL::site('service/list'));
		}

		$services = Business::factory('Service')->getServiceByServiceId($serviceId);
		$service = $services->current();
		if(!$service) {
			Prompt::warningView('实例不存在', URL::site('service/list'));
		}

		$this->_default->content = View::factory('service/info')
			->set('service', $service);
	}

	/**
	 * 添加实例
	 */
	public function action_add() {
		
		$machines = Business::factory('Machine')->getMachines();
		$this->_default->content = View::factory('service/add')
			->set('machines', $machines);
	}

	/**
	 * 添加保存
	 */
	public function action_save() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$machineId = Arr::get($_POST, 'machine_id', 0);
		$name = Arr::get($_POST, 'name', '');
		$sourceName = Arr::get($_POST, 'source_name', '');
		$sourceType = Arr::get($_POST, 'source_type', 'mysql');
		$sqlHost = Arr::get($_POST, 'sql_host', '');
		$sqlPort = Arr::get($_POST, 'sql_port', 3306);
		$sqlUser = Arr::get($_POST, 'sql_user', '');
		$sqlPass = Arr::get($_POST, 'sql_pass', '');
		$sqlDb = Arr::get($_POST, 'sql_db', '');
		$sqlTable = Arr::get($_POST, 'sql_table', '');
		$sqlCharset = Arr::get($_POST, 'sql_charset', '');
		$sourceNumber = Arr::get($_POST, 'source_number', 1);

		$values = [
			'machine_id' => intval(trim($machineId)),
			'name' => trim($name),
			'source_name' => trim($sourceName),
			'source_type' => trim($sourceType),
			'sql_host' => trim($sqlHost),
			'sql_port' => intval(trim($sqlPort)),
			'sql_user' => trim($sqlUser),
			'sql_pass' => trim($sqlPass),
			'sql_db' => trim($sqlDb),
			'sql_table' => trim($sqlTable),
			'sql_charset' => trim($sqlCharset),
			'source_number' => intval(trim($sourceNumber)),
		];

		try {
			$service = Business::factory('Service')->create($values);
		} catch (Exception $e) {
			Logs::instance()->write('添加实例失败: '.$e->getMessage());
			return $this->failed($e->getMessage());
		}

		Logs::instance()->write('添加实例' .$service[0]. '成功');
		return $this->success('添加实例成功', URL::site('service/list'));
	}

	/**
	 * 实例修改
	 */
	public function action_edit() {
		$this->_headerRender = FALSE;

		$serviceId = Arr::get($_GET, 'service_id', 0);
		if(!$serviceId) {
			Prompt::warningView('service_id 不合法', URL::site('service/list'));
		}

		$services = Business::factory('Service')->getServiceByServiceId($serviceId);
		$service = $services->current();
		if(!$service) {
			Prompt::warningView('实例不存在', URL::site('service/list'));
		}
		if($service->status == Model_Service::STATUS_WAIT) {
			Prompt::warningView('实例正在执行，不能修改', URL::site('service/list'));
		}

		$machines = Business::factory('Machine')->getMachines();

		$this->_default->content = View::factory('service/edit')
			->set('service', $service)
			->set('machines', $machines);
	}

	/**
	 * 修改保存
	 */
	public function action_modify() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$serviceId = Arr::get($_POST, 'service_id', 0);
		$machineId = Arr::get($_POST, 'machine_id', 0);
		$name = Arr::get($_POST, 'name', '');
		$sourceName = Arr::get($_POST, 'source_name', '');
		$sourceType = Arr::get($_POST, 'source_type', 'mysql');
		$sqlHost = Arr::get($_POST, 'sql_host', '');
		$sqlPort = Arr::get($_POST, 'sql_port', 3306);
		$sqlUser = Arr::get($_POST, 'sql_user', '');
		$sqlPass = Arr::get($_POST, 'sql_pass', '');
		$sqlDb = Arr::get($_POST, 'sql_db', '');
		$sqlTable = Arr::get($_POST, 'sql_table', '');
		$sqlCharset = Arr::get($_POST, 'sql_charset', '');
		$sourceNumber = Arr::get($_POST, 'source_number', 1);

		$values = [
			'machine_id' => intval(trim($machineId)),
			'name' => trim($name),
			'source_name' => trim($sourceName),
			'source_type' => trim($sourceType),
			'sql_host' => trim($sqlHost),
			'sql_port' => intval(trim($sqlPort)),
			'sql_user' => trim($sqlUser),
			'sql_pass' => trim($sqlPass),
			'sql_db' => trim($sqlDb),
			'sql_table' => trim($sqlTable),
			'sql_charset' => trim($sqlCharset),
			'source_number' => intval(trim($sourceNumber)),
		];

		try {
			Business::factory('Service')->updateByServiceId($values, $serviceId);
		} catch (Exception $e) {
			Logs::instance()->write('修改实例 '.$serviceId.' 失败: '.$e->getMessage());
			return $this->failed($e->getMessage());
		}

		//添加重建任务
		Sphinx_Task::add($serviceId, Sphinx_Task::TYPE_REBUILD);

		Logs::instance()->write('修改实例' .$serviceId. '成功');
		return $this->success('修改实例成功', URL::site('service/list'));
	}

	/**
	 * 实例启动
	 */
	public function action_start() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$serviceId = Arr::get($_GET, 'service_id', 0);
		if(!$serviceId) {
			Prompt::warningView('service_id 不合法', URL::site('service/list'));
		}
		$service = Business::factory('Service')->getServiceByServiceId($serviceId);
		$service = $service->current();
		if(!$service) {
			Prompt::warningView('实例不存在', URL::site('service/list'));
		}
		if($service->status == Model_Service::STATUS_WAIT) {
			return $this->failed('实例正在执行，不能启动');
		}

		//添加启动任务
		Sphinx_Task::add($serviceId, Sphinx_Task::TYPE_START);

		Logs::instance()->write('实例' .$serviceId. '添加启动任务成功');

		return $this->success('添加启动任务成功', URL::site('service/list'));
	}

	/**
	 * 实例停止
	 */
	public function action_stop() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$serviceId = Arr::get($_GET, 'service_id', 0);
		if(!$serviceId) {
			Prompt::warningView('service_id 不合法', URL::site('service/list'));
		}
		$service = Business::factory('Service')->getServiceByServiceId($serviceId);
		$service = $service->current();
		if(!$service) {
			Prompt::warningView('实例不存在', URL::site('service/list'));
		}
		if($service->status == Model_Service::STATUS_WAIT) {
			return $this->failed('实例正在执行，不能停止');
		}

		//添加停止任务
		Sphinx_Task::add($serviceId, Sphinx_Task::TYPE_STOP);

		Logs::instance()->write('实例' .$serviceId. '添加停止任务');

		return $this->success('添加停止任务成功', URL::site('service/list'));
	}

	/**
	 * 删除
	 */
	public function action_delete() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$serviceId = Arr::get($_GET, 'service_id', 0);
		if(!$serviceId) {
			Prompt::warningView('service_id 不合法', URL::site('service/list'));
		}
		$service = Business::factory('Service')->getServiceByServiceId($serviceId);
		$service = $service->current();
		if(!$service) {
			Prompt::warningView('实例不存在', URL::site('service/list'));
		}

		if($service->status == Model_Service::STATUS_START) {
			return $this->failed('实例未停止，不能删除');
		}
		if($service->status == Model_Service::STATUS_WAIT) {
			return $this->failed('实例正在执行，不能删除');
		}

		$status = Model_Service::STATUS_DELETE;

		try {
			Business::factory('service')->updateStatusByServiceId($status, $serviceId);
		} catch (Exception $e) {
			Logs::instance()->write('删除实例' .$serviceId. '失败: '.$e->getMessage());
			return $this->failed($e->getMessage());
		}

		Logs::instance()->write('删除实例' .$serviceId. '成功');
		return $this->success('删除实例成功', URL::site('service/list'));
	}
}