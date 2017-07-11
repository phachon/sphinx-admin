<?php
/**
 * Sphinx start
 * @author: phachon@163.com
 */
class Sphinx_Start extends Sphinx {

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
		$serviceName = isset($service['name']) ? $service['name'] : '';
		$sphinxPath = isset($machine['sphinx_path']) ? $machine['sphinx_path'] : '';

		$etcFile = ETC_PATH .$serviceName.".conf";
		if(!file_exists($etcFile)) {
			throw new Sphinx_Exception("Start failed etc file not found!");
		}
		$indexerCmd = $sphinxPath . "/bin/indexer --config ". $etcFile ." --all";
		$searchdCmd = $sphinxPath . "/bin/searchd --config ". $etcFile;

		//check process is already running
		$checkCmd = "ps aux|grep {$sphinxPath}/bin/searchd | grep {$etcFile}";

		$results = explode("\n", trim(shell_exec($checkCmd)));
		if(count($results) > 1) {
			throw new Sphinx_Exception('Process already running!');
		}

		//start process
		try {
			shell_exec($indexerCmd);
			shell_exec($searchdCmd);
		}catch (Sphinx_Exception $e) {
			throw new Sphinx_Exception('Shell exec start error: '.$e->getMessage());
		}

		return TRUE;
	}
}