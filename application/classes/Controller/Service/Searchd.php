<?php
/**
 * 实例进程管理
 * @author: panchao
 */
class Controller_Service_Searchd extends Controller_Render {

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

		//实例进程
		$serviceSearchd = Business::factory('Service_Searchd')->getServiceSearchdByServiceId($serviceId);
		$serviceSearchd = $serviceSearchd->current();

		$this->_default->content = View::factory('service/searchd/config')
			->set('serviceId', $serviceId)
			->set('serviceSearchd', $serviceSearchd);
	}

	/**
	 * 保存
	 */
	public function action_save() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$serviceSearchdId = Arr::get($_POST, 'service_searchd_id', 0);
		$serviceId = Arr::get($_POST, 'service_id', 0);
		$sphinxListen = Arr::get($_POST, 'sphinx_listen', 0);
		$mysqlListen = Arr::get($_POST, 'mysql_listen', '');
		$readTimeout = Arr::get($_POST, 'read_timeout', '');
		$clientTimeout = Arr::get($_POST, 'client_timeout', '');

		$values = [
			'service_id' => $serviceId,
			'sphinx_listen' => $sphinxListen,
			'mysql_listen' => $mysqlListen,
			'read_timeout' => $readTimeout,
			'client_timeout' => $clientTimeout
		];

		if(!$serviceSearchdId) {
			//创建
			try {
				Business::factory('Service_Searchd')->create($values);
			}catch (Exception $e) {
				return $this->failed($e->getMessage());
			}
		}else {
			//修改
			try {
				Business::factory('Service_Searchd')->updateBySearchdId($values, $serviceSearchdId);
			}catch (Exception $e) {
				return $this->failed($e->getMessage());
			}
		}

		//添加重建任务
		Sphinx_Task::add($serviceId, Sphinx_Task::TYPE_REBUILD);

		$this->success('保存成功', URL::site('service/list'));
	}
}