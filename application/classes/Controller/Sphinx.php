<?php
/**
 * Sphinx 操作相关接口
 * @author: phachon@163.com
 */
class Controller_Sphinx extends Controller_Api {

	/**
	 * 查询数据接口
	 */
	public function action_select() {

		$params = isset($_REQUEST['params']) ? $_REQUEST['params'] : '';
		$params = json_decode($params, true);
		$index = isset($params['index']) ? $params['index'] : [];
		$matches = isset($params['matches']) ? $params['matches'] : [];
		$filters = isset($params['filters']) ? $params['filters'] : [];
		$orders = isset($params['orders']) ? $params['orders'] : [];
		$limit = isset($params['limit']) ? $params['limit'] : 20;
		$offset = isset($params['offset']) ? $params['offset'] : 0;
		$group = isset($params['group']) ? $params['group'] : '';
		$options = isset($params['options']) ? $params['options'] : [];

		$serviceName = Arr::get($_GET, 'service_name', '');
		if(!$serviceName) {
			return $this->failed('实例不合法!');
		}

		$services = Business::factory('Service')->getServiceByName($serviceName);
		if(!$services->count()) {
			return $this->failed('实例不存在!');
		}
		$service = $services->current();
		$serviceId = $service->service_id;
		$machineId = $service->machine_id;

		$machines = Business::factory('Machine')->getMachineByMachineId($machineId);
		if(!$machines->count()) {
			return $this->failed('该实例下机器不存在!');
		}
		$host = $machines->current()->ip;

		//实例索引配置
		$indexers = Business::factory('Service_Indexer')->getServiceIndexerByServiceId($serviceId);
		$defaultIndexers = [];
		foreach ($indexers as $indexer) {
			$defaultIndexers[] = $indexer->name;
		}
		$index = $index ? $index : $defaultIndexers;

		//实例进程配置
		$searchd = Business::factory('Service_Searchd')->getServiceSearchdByServiceId($serviceId)->current();
		$port = $searchd->mysql_listen;

		if(!is_array($matches)) {
			$matches = array($matches);
		}
		if(!is_array($filters)) {
			$filters = array($filters);
		}
		if(empty($options)) {
			$options = array (
				array (
					'name' => 'reverse_scan',
					'value' => 1,
				),
			);
		}
		if(empty($orders)) {
			$orders = array (
				array (
					'column' => 'id',
					'direction' => 'DESC',
				),
			);
		}
		try {
			$connection = new Connection();
			$connection->setParams(['host' => $host, 'port' => $port]);

			$select = SphinxQL::create($connection)
				->select('*')
				->from($index);
			foreach($matches as $match) {
				$column = isset($match['column']) ? $match['column'] : '';
				$value = isset($match['value']) ? (string)$match['value'] : '';
				$half = isset($match['half']) ? (boolean)$match['half'] : FALSE;

				if(!$column || $value === '') {
					continue;
				}
				$select->match($column, $value, $half);
			}

			foreach($filters as $filter) {
				$column = isset($filter['column']) ? (string)$filter['column'] : '';
				$operator = isset($filter['operator']) ? (string)$filter['operator'] : '=';
				if(isset($filter['value']) && is_array($filter['value'])) {
					$value = $filter['value'];
				} else {
					$value = isset($filter['value']) ? (int)$filter['value'] : '';
				}
				if(!$column || !$operator || $value === '') {
					continue;
				}
				$select->where($column, $operator, $value);
			}

			foreach($options as $option) {
				$name = isset($option['name']) ? $option['name'] : '';
				$value = isset($option['value']) ? $option['value'] : '';
				if(!$name || !$value) {
					continue;
				}
				$select->option($name, $value);
			}

			foreach($orders as $order) {
				$column = isset($order['column']) ? (string)$order['column'] : '';
				$direction = isset($order['direction']) ? (string)$order['direction'] : '';
				if(!$column || !$direction) {
					continue;
				}
				$select->orderBy($column, $direction);
			}

			if($group) {
				$select->groupBy($group);
			}

			$data = $select->where('is_delete', '=', 0)
				->limit($offset, $limit)
				->enqueue(SphinxQL::create($connection)->query('SHOW META'))
				->executeBatch();
		} catch(Exception $e) {
			return $this->failed($e->getMessage());
		}

		$this->success('ok', $data);
	}

	/**
	 * 更新数据接口
	 */
	public function action_update() {

	}
}