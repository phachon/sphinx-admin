<?php
/**
 * 业务逻辑层 - 机器
 * @author: phachon@163.com
 */
class Business_Machine extends Business {

	/**
	 * 创建机器
	 * @param array $values
	 * @return integer
	 * @throws Business_Exception
	 */
	public function create($values = []) {

		$fields = array (
			'domain' => '',
			'ip' => '',
			'sphinx_path' => '',
			'comment' => '',
			'status' => Dao_Machine::STATUS_NORMAL,
			'create_time' => time(),
			'update_time' => time(),
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;
		$domain = Arr::get($values, 'domain', '');
		$ip = Arr::get($values, 'ip', '');
		$sphinxPath = Arr::get($values, 'sphinx_path', '');

		$errors = [];
		if(!$domain && !$ip) {
			$errors[] = '域名和ip不能都为空';
		}
		if(!$sphinxPath) {
			$errors[] = 'sphinx安装目录不能为空';
		}

		if($errors) {
			throw new Business_Exception(implode("\n",$errors));
		}

		$machines = Dao::factory('Machine')->getMachineByIp($ip);
		if($machines->count() > 0) {
			throw new Business_Exception('机器ip已存在');
		}

		return Dao::factory('Machine')->insert($values);
	}

	/**
	 * 根据 ip 查找机器
	 * @param $ip
	 */
	public function getMachineByIp($ip) {
		return Dao::factory('Machine')->getMachineByIp($ip);
	}

	/**
	 * 根据关键字获取机器的数量
	 * @param string $keyword
	 * @return array
	 */
	public function countMachinesByKeyword($keyword) {
		return Dao::factory('Machine')->countMachinesByKeyword($keyword);
	}

	/**
	 * 根据关键字分页获取机器
	 * @param string $keyword
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getMachinesByKeywordAndLimit($keyword, $offset, $number) {
		return Dao::factory('Machine')->getMachinesByKeywordAndLimit($keyword, $offset, $number);
	}

	/**
	 * 获取机器总数
	 * @return array
	 */
	public function countMachines() {
		return Dao::factory('Machine')->countMachines();
	}

	/**
	 * 分页获取机器信息
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getMachinesByLimit($offset, $number) {
		return Dao::factory('Machine')->getMachinesByLimit($offset, $number);
	}

	/**
	 * 根据 machine_id 来查找机器
	 * @param integer $machineId
	 * @return mixed
	 */
	public function getMachineByMachineId($machineId = 0) {
		if(!$machineId) {
			return FALSE;
		}
		return Dao::factory('Machine')->getMachineByMachineId($machineId);
	}

	/**
	 * 根据 machine_id 来修改机器
	 * @param array $values
	 * @param integer $machineId
	 * @return mixed
	 * @throws Business_Exception
	 */
	public function updateByMachineId($values, $machineId) {
		if(!$machineId) {
			return FALSE;
		}

		$fields = array (
			'domain' => '',
			'ip' => '',
			'sphinx_path' => '',
			'comment' => '',
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;
		$domain = Arr::get($values, 'domain', '');
		$ip = Arr::get($values, 'ip', '');
		$sphinxPath = Arr::get($values, 'sphinx_path', '');
		$values['update_time'] = time();

		$errors = [];
		if(!$domain && !$ip) {
			$errors[] = '域名和ip不能都为空';
		}
		if(!$sphinxPath) {
			$errors[] = 'sphinx 安装路径不能为空';
		}
		if($errors) {
			throw new Business_Exception(implode("\n", $errors));
		}

		return Dao::factory('Machine')->updateByMachineId($values, $machineId);
	}

	/**
	 * 获取所有的机器
	 */
	public function getMachines() {
		return Dao::factory('Machine')->getMachines();
	}

	/**
	 * 根据 machine_id 来修改状态
	 * @param integer $status
	 * @param integer $machineId
	 * @return mixed
	 */
	public function updateStatusByMachineId($status, $machineId) {
		if(!$machineId) {
			return FALSE;
		}

		$values = [
			'status' => $status,
			'update_time' => time()
		];

		return Dao::factory('Machine')->updateByMachineId($values, $machineId);
	}
}