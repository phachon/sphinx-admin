<?php
/**
 * 实例字段管理
 * @author: panchao
 */
class Controller_Service_Column extends Controller_Render {

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

		//数据源所有字段
		$sourceColumns = Business::factory('Service')->getSourceColumnsByServiceId($serviceId);
		//实例字段
		$serviceColumns = Business::factory('Service_Column')->getServiceColumnsByServiceId($serviceId)->as_array();

		$this->_default->content = View::factory('service/column/config')
			->set('serviceId', $serviceId)
			->set('sourceColumns', $sourceColumns)
			->set('serviceColumns', json_encode($serviceColumns));
	}

	/**
	 * 保存
	 */
	public function action_save() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$columnsData = Arr::get($_POST, 'columns_data', []);
		$sqlCondition = Arr::get($_POST, 'sql_condition', '');
		$serviceId = Arr::get($_POST, 'service_id', '');

		if(!count($columnsData)) {
			return $this->failed('没有选择字段');
		}

		$isIdColumn = FALSE;
		$columnsValues = [];
		foreach ($columnsData as $columnItem) {
			$errors = [];
			if(!$columnItem['column']) {
				$errors[] = '字段名不能为空';
			}
			if(!$columnItem['column_attr']) {
				$errors[] = $columnItem['column'].' 字段没有选择属性';
			}
			if($columnItem['is_id_column']) {
				$isIdColumn = TRUE;
			}
			if($errors) {
				return $this->failed($errors[0]);
			}
			$columnsValues[] = [
				'service_id' => $serviceId,
				'`column`' => trim($columnItem['column']),
				'column_attr' => $columnItem['column_attr'],
				'is_id_column' => intval($columnItem['is_id_column']),
				'sql_condition' => trim($sqlCondition),
				'create_time' => time(),
			];
		}
		if(!$isIdColumn) {
			return $this->failed('没有选择文档id字段');
		}

		try {
			Business::factory('Service_Column')->createBatch($columnsValues);
		}catch (Exception $e) {
			return $this->failed($e->getMessage());
		}

		//添加重建任务
		Sphinx_Task::add($serviceId, Sphinx_Task::TYPE_REBUILD);
		
		return $this->success('保存成功', URL::site('service_indexer/config?service_id='.$serviceId));
	}
}