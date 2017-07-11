<?php
/**
 * 业务逻辑层 - 实例
 * @author: phachon@163.com
 */
class Business_Service extends Business {

	/**
	 * 创建实例
	 * @param array $values
	 * @return integer
	 * @throws Business_Exception
	 */
	public function create($values = []) {

		$fields = array (
			'machine_id' => 0,
			'name' => '',
			'source_name' => '',
			'source_type' => '',
			'sql_host' => '',
			'sql_port' => 3306,
			'sql_user' => '',
			'sql_pass' => '',
			'sql_db' => '',
			'sql_table' => '',
			'sql_charset' => '',
			'source_number' => 1,
			'status' => Dao_Service::STATUS_STOP,
			'create_time' => time(),
			'update_time' => time(),
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;
		$machineId = Arr::get($values, 'machine_id', 0);
		$name = Arr::get($values, 'name', '');
		$sourceName = Arr::get($values, 'source_name', '');
		$sourceType = Arr::get($values, 'source_type', 'mysql');
		$sqlHost = Arr::get($values, 'sql_host', '');
		$sqlPort = Arr::get($values, 'sql_port', 3306);
		$sqlUser = Arr::get($values, 'sql_user', '');
		$sqlPass = Arr::get($values, 'sql_pass', '');
		$sqlDb = Arr::get($values, 'sql_db', '');
		$sqlTable = Arr::get($values, 'sql_table', '');
		$sqlCharset = Arr::get($values, 'sql_charset', '');
		$sourceNumber = Arr::get($values, 'source_number', 1);

		$errors = [];
		if(!$machineId) {
			$errors[] = '没有选择机器';
		}
		if(!$name) {
			$errors[] = '实例名不能为空';
		}
		if(!preg_match("/^[A-Za-z0-9_]+$/", $name)){
			$errors[] = '实例名只能是字母数字下划线组成';
		}
		if(!$sourceName) {
			$errors[] = '数据源名称不能为空';
		}
		if(!preg_match("/^[A-Za-z0-9_]+$/", $sourceName)){
			$errors[] = '数据源名称只能是字母数字下划线组成';
		}
		if(!$sourceType) {
			$errors[] = '数据源类型不能为空';
		}
		if(!$sqlHost) {
			$errors[] = '数据库主机名不能为空';
		}
		if(!$sqlPort) {
			$errors[] = '数据库端口不能为空';
		}
		if(!is_numeric($sqlPort)) {
			$errors[] = '数据库端口必须为整数';
		}
		if(!$sqlUser) {
			$errors[] = '数据库用户名不能为空';
		}
		if(!$sqlPass) {
			$errors[] = '数据库密码不能为空';
		}
		if(!$sqlDb) {
			$errors[] = '数据库名不能为空';
		}
		if(!$sqlTable) {
			$errors[] = '数据库表前缀不能为空';
		}
		if(!$sqlCharset) {
			$errors[] = '数据库字符集不能为空';
		}
		if(!$sourceNumber) {
			$errors[] = '数据源个数不能为空';
		}
		if(!is_numeric($sourceNumber)) {
			$errors[] = '数据源个数必须为整数';
		}

		if($errors) {
			throw new Business_Exception(implode("\n", $errors));
		}

		//同一台机器下实例名唯一
		$services = Dao::factory('Service')->getServiceByMachineAndName($machineId, $name);
		if($services->count() > 0) {
			throw new Business_Exception('该机器下的实例名已存在');
		}
		//同一台机器下数据源名称唯一
		$services = Dao::factory('Service')->getServiceByMachineAndSourceName($machineId, $sourceName);
		if($services->count() > 0) {
			throw new Business_Exception('该机器下的数据源已添加');
		}
		//同一台机器下数据库host唯一
		$services = Dao::factory('Service')->getServiceByMachineAndSqlHost($machineId, $sqlHost);
		if($services->count() > 0) {
			throw new Business_Exception('该机器下的数据库主机已添加');
		}

		return Dao::factory('Service')->insert($values);
	}

	/**
	 * 根据 machine_id 查找实例
	 * @param $machineId
	 */
	public function getServiceByMachineId($machineId) {
		return Dao::factory('Service')->getServiceByMachineId($machineId);
	}

	/**
	 * 根据关键字获取实例的数量
	 * @param string $keyword
	 * @return array
	 */
	public function countServicesByKeyword($keyword) {
		return Dao::factory('Service')->countServicesByKeyword($keyword);
	}

	/**
	 * 根据关键字分页获取实例
	 * @param string $keyword
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getServicesByKeywordAndLimit($keyword, $offset, $number) {
		return Dao::factory('Service')->getServicesByKeywordAndLimit($keyword, $offset, $number);
	}

	/**
	 * 获取实例总数
	 * @return array
	 */
	public function countServices() {
		return Dao::factory('Service')->countServices();
	}

	/**
	 * 分页获取实例信息
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getServicesByLimit($offset, $number) {
		return Dao::factory('Service')->getServicesByLimit($offset, $number);
	}

	/**
	 * 根据 service_id 来查找实例
	 * @param integer $serviceId
	 * @return mixed
	 */
	public function getServiceByServiceId($serviceId = 0) {
		if(!$serviceId) {
			return FALSE;
		}
		return Dao::factory('Service')->getServiceByServiceId($serviceId);
	}

	/**
	 * 根据 service_id 来修改实例
	 * @param array $values
	 * @param integer $serviceId
	 * @return mixed
	 * @throws Business_Exception
	 */
	public function updateByServiceId($values, $serviceId) {
		if(!$serviceId) {
			return FALSE;
		}

		$fields = array (
			'machine_id' => '',
			'name' => '',
			'source_name' => '',
			'source_type' => '',
			'sql_host' => '',
			'sql_port' => 3306,
			'sql_user' => '',
			'sql_pass' => '',
			'sql_db' => '',
			'sql_table' => '',
			'sql_charset' => '',
			'source_number' => 1,
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;
		$machineId = Arr::get($values, 'machine_id', 0);
		$name = Arr::get($values, 'name', '');
		$sourceName = Arr::get($values, 'source_name', '');
		$sourceType = Arr::get($values, 'source_type', 'mysql');
		$sqlHost = Arr::get($values, 'sql_host', '');
		$sqlPort = Arr::get($values, 'sql_port', 3306);
		$sqlUser = Arr::get($values, 'sql_user', '');
		$sqlPass = Arr::get($values, 'sql_pass', '');
		$sqlDb = Arr::get($values, 'sql_db', '');
		$sqlTable = Arr::get($values, 'sql_table', '');
		$sqlCharset = Arr::get($values, 'sql_charset', '');
		$sourceNumber = Arr::get($values, 'source_number', 1);

		$errors = [];
		if(!$machineId) {
			$errors[] = '没有选择机器';
		}
		if(!$name) {
			$errors[] = '实例名不能为空';
		}
		if(!preg_match("/^[A-Za-z0-9_]+$/", $name)){
			$errors[] = '实例名只能是字母数字下划线组成';
		}
		if(!$sourceName) {
			$errors[] = '数据源名称不能为空';
		}
		if(!preg_match("/^[A-Za-z0-9_]+$/", $sourceName)){
			$errors[] = '数据源名称只能是字母数字下划线组成';
		}
		if(!$sourceType) {
			$errors[] = '数据源类型不能为空';
		}
		if(!$sqlHost) {
			$errors[] = '数据库主机名不能为空';
		}
		if(!$sqlPort) {
			$errors[] = '数据库端口不能为空';
		}
		if(!is_numeric($sqlPort)) {
			$errors[] = '数据库端口必须为整数';
		}
		if(!$sqlUser) {
			$errors[] = '数据库用户名不能为空';
		}
		if(!$sqlPass) {
			$errors[] = '数据库密码不能为空';
		}
		if(!$sqlDb) {
			$errors[] = '数据库名不能为空';
		}
		if(!$sqlTable) {
			$errors[] = '数据库表前缀不能为空';
		}
		if(!$sqlCharset) {
			$errors[] = '数据库字符集不能为空';
		}
		if(!$sourceNumber) {
			$errors[] = '数据源个数不能为空';
		}
		if(!is_numeric($sourceNumber)) {
			$errors[] = '数据源个数必须为整数';
		}

		if($errors) {
			throw new Business_Exception(implode(' ',$errors));
		}

		//同一台机器下实例名唯一
		$services = Dao::factory('Service')->getServiceByMachineAndName($machineId, $name);
		if($services->count() > 1 || (($services->count() == 1) && ($services->current()->getName() !== $name))) {
			throw new Business_Exception('该机器下的实例名已存在');
		}
		//同一台机器下数据源名称唯一
		$services = Dao::factory('Service')->getServiceByMachineAndSourceName($machineId, $sourceName);
		if($services->count() > 1 || (($services->count() == 1) && ($services->current()->getSourceName() !== $sourceName))) {
			throw new Business_Exception('该机器下的数据源已添加');
		}
		//同一台机器下数据库host唯一
		$services = Dao::factory('Service')->getServiceByMachineAndSqlHost($machineId, $sqlHost);
		if($services->count() > 1 || (($services->count() == 1) && ($services->current()->getSqlHost() !== $sqlHost))) {
			throw new Business_Exception('该机器下的数据库主机已添加');
		}

		$results = Dao::factory('Service')->updateByServiceId($values, $serviceId);
		
		return $results;
	}

	/**
	 * 获取所有的实例
	 */
	public function getServices() {
		return Dao::factory('Service')->getServices();
	}

	/**
	 * 根据 name 查找实例
	 * @param $name
	 * @return mixed
	 */
	public function getServiceByName($name) {
		return Dao::factory('Service')->getServiceByName($name);
	}

	/**
	 * 根据 service_id 来修改状态
	 * @param integer $status
	 * @param integer $serviceId
	 * @return mixed
	 */
	public function updateStatusByServiceId($status, $serviceId) {
		if(!$serviceId) {
			return FALSE;
		}

		$values = [
			'status' => $status,
			'update_time' => time()
		];

		return Dao::factory('Service')->updateByServiceId($values, $serviceId);
	}

	/**
	 * 根据 service_id 来获取数据源所有的字段
	 * @param $serviceId
	 * @return array
	 */
	public function getSourceColumnsByServiceId($serviceId) {
		$services = Dao::factory('Service')->getServiceByServiceId($serviceId);

		$service = $services->current();

		$username = $service->sql_user;
		$password = $service->sql_pass;
		$table = $service->sql_table."_0";
		$dsn = "{$service->source_type}:host={$service->sql_host};port={$service->sql_port};dbname={$service->sql_db};charset={$service->sql_charset}";

		$database = new PDO($dsn, $username, $password, array(PDO::ATTR_PERSISTENT => false));
		$query = "select COLUMN_NAME from information_schema.COLUMNS where table_name = '$table';";
		$result = $database->prepare($query);
		$result->execute();
		$columns = $result->fetchAll(PDO::FETCH_COLUMN);

		return $columns;
	}
}