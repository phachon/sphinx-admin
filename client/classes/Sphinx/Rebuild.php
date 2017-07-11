<?php
/**
 * Sphinx rebuild indexer
 * @author: phachon@163.com
 */
class Sphinx_Rebuild extends Sphinx {

	/**
	 * @return bool
	 * @throws Sphinx_Exception
	 */
	public function execute() {

		$uriConf = isset($this->_config['uri']) ? $this->_config['uri'] : [];
		$machineConf = isset($this->_config['machine']) ? $this->_config['machine'] : [];
		$ip = isset($machineConf['ip']) ? $machineConf['ip'] : '';

		$data = [
			'service_id' => $this->_serviceId,
		];

		$response = Curl::instance()
			->timeout('10')
			->url($uriConf['serviceByServiceId'])
			->get($data);
		$serviceValues = $response->getData();

		if(!$serviceValues) {
			throw new Sphinx_Exception('Request service uri:'.$response->getMessage());
		}

		$service = isset($serviceValues['service']) ? $serviceValues['service'] : [];
		$machine = isset($serviceValues['machine']) ? $serviceValues['machine'] : [];
		if($machine['ip'] !== $ip) {
			throw new Sphinx_Exception('Service ip does not match the native ip');
		}
		$column = isset($serviceValues['column']) ? $serviceValues['column'] : [];
		$indexers = isset($serviceValues['indexer']) ? $serviceValues['indexer'] : [];
		$searchd = isset($serviceValues['searchd']) ? $serviceValues['searchd'] : [];

		$sphinxPath = isset($machine['sphinx_path']) ? $machine['sphinx_path'] : '';

		//创建 etc 文件
		$conf = new Sphinx_Conf($service, $machine, $column, $indexers, $searchd);
		$conf->make();

		$dataPath = $sphinxPath . "/var/data/".$service['name'];
		if(!is_dir($dataPath)) {
			mkdir($dataPath, 0777);
		}

		//删除 data 数据
		shell_exec("rm -f {$dataPath}/*");

		//stop
		Sphinx::factory('stop')->serviceId($this->_serviceId)->execute();
		//start
		Sphinx::factory('start')->serviceId($this->_serviceId)->execute();

		return TRUE;
	}
}