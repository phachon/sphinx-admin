<?php
/**
 * 实例索引管理
 * @author: panchao
 */
class Controller_Service_Indexer extends Controller_Render {

	protected $_default = 'layouts/service';

	/**
	 * index
	 */
	public function action_index() {
		Controller::redirect('service/list');
	}

	/**
	 * 配置
	 */
	public function action_config() {
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
			Prompt::warningView('实例正在执行，不能配置', URL::site('service/list'));
		}

		//实例索引
		$serviceIndexer = Business::factory('Service_Indexer')->getServiceIndexerByServiceId($serviceId);

		$this->_default->content = View::factory('service/indexer/config')
			->set('serviceId', $serviceId)
			->set('serviceIndexer', $serviceIndexer);
	}

	/**
	 * 保存
	 */
	public function action_save() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$type = Arr::get($_POST, 'type', '');
		$name = Arr::get($_POST, 'name', '');
		$serviceId = Arr::get($_POST, 'service_id', 0);

		$values = [
			'type' => trim($type),
			'name' => trim($name),
			'service_id' => intval($serviceId),
		];

		try {
			Business::factory('Service_Indexer')->create($values);
		}catch (Exception $e) {
			return $this->failed($e->getMessage());
		}

		//添加重建任务
		Sphinx_Task::add($serviceId, Sphinx_Task::TYPE_REBUILD);

		$this->success('添加成功', URL::site('service_indexer/config?service_id='.$serviceId));
	}

	/**
	 * 修改
	 */
	public function action_edit() {
		$this->_headerRender = FALSE;

		$serviceIndexerId = Arr::get($_GET, 'service_indexer_id', 0);

		if(!$serviceIndexerId) {
			Prompt::warningView('service_indexer_id 不合法', URL::site('service/list'));
		}

		$serviceIndexers = Business::factory('Service_Indexer')->getServiceIndexerByServiceIndexerId($serviceIndexerId);
		if(!$serviceIndexers->count()) {
			Prompt::warningView('该实例索引不存在', URL::site('service/list'));
		}

		$serviceIndexer = $serviceIndexers->current();

		$this->_default->content = View::factory('service/indexer/edit')
			->set('serviceIndexer', $serviceIndexer);
	}

	/**
	 * 添加保存
	 */
	public function action_modify() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$serviceIndexerId = Arr::get($_POST, 'service_indexer_id', 0);
		$type = Arr::get($_POST, 'type', '');
		$name = Arr::get($_POST, 'name', '');
		$serviceId = Arr::get($_POST, 'service_id', '');

		$values = [
			'service_id' => intval($serviceId),
			'type' => trim($type),
			'name' => trim($name),
		];

		try {
			Business::factory('Service_Indexer')->updateByServiceIndexerId($values, $serviceIndexerId);
		}catch (Exception $e) {
			return $this->failed($e->getMessage());
		}

		//添加重建任务
		Sphinx_Task::add($serviceId, Sphinx_Task::TYPE_REBUILD);

		$this->success('修改成功', URL::site('service_indexer/config?service_id='.$serviceId));
	}
}