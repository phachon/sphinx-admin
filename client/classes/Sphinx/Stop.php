<?php
/**
 * Sphinx stop
 * @author: phachon@163.com
 */
class Sphinx_Stop extends Sphinx {

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

		$etcFile = ETC_PATH.$serviceName.".conf";

		$searchdCmd = $sphinxPath . "/bin/searchd --config ". $etcFile;
		//check process is already running
		$checkCmd = "ps aux|grep {$sphinxPath}/bin/searchd | grep {$etcFile}";

		$results = explode("\n", trim(shell_exec($checkCmd)));
		if(count($results) <= 1) {
			return FALSE;
		}

//		$processResults = [];
//		foreach ($results as $result) {
//			$result = array_filter(explode(' ', $result));
//			$processResult = [];
//			foreach ($result as $value) {
//				$processResult[] = $value;
//			}
//			$processResults[] = $processResult;
//		}
//
//		$pId = [];
//		foreach ($processResults as $processResult) {
//			if($processResult[10] == $sphinxPath . "/bin/searchd") {
//				$pId[] = $processResult[1];
//			}
//		}
//		$pIds = implode(" ", $pId);
//
//		//kill process
//		try {
//			shell_exec("kill -9 {$pIds}");
//		}catch (Sphinx_Exception $e) {
//			throw new Sphinx_Exception('Shell exec kill pid error: '.$e->getMessage());
//		}

		shell_exec($searchdCmd. " --stop");

		return TRUE;
	}
}