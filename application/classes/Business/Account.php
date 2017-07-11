<?php
/**
 * 业务逻辑层 - 账号
 * @author: phachon@163.com
 */
class Business_Account extends Business {

	/**
	 * 创建
	 * @param array $values
	 * @return integer
	 * @throws Business_Exception
	 */
	public function create($values = []) {

		$fields = array (
			'name' => '',
			'email' => '',
			'mobile' => '',
			'role_id' => 0,
			'password' => '',
			'status' => Dao_Account::STATUS_NORMAL,
			'create_time' => time(),
			'update_time' => time(),
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;
		$name = Arr::get($values, 'name', '');
		$email = Arr::get($values, 'email', '');
		$password = Arr::get($values, 'password', '');
		$roleId = Arr::get($values, 'role_id', 0);

		$errors = [];
		if(!$name) {
			$errors[] = '用户名不能为空';
		}
		if(!$email) {
			$errors[] = '邮箱不能为空';
		}else {
			$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
			if(!preg_match($pattern, $email)) {
				$errors[] = '邮箱不合法';
			}
		}
		if(!$password) {
			$errors[] = '密码不能为空';
		}
		if(!$roleId) {
			$errors[] = '没有选择角色';
		}

		if($errors) {
			throw new Business_Exception(implode("\n",$errors));
		}

		$accounts = Dao::factory('Account')->getAccountByName($name);
		if($accounts->count() > 0) {
			throw new Business_Exception('用户名已存在');
		}

		$values['password'] = md5($values['password']);

		return Dao::factory('Account')->insert($values);
	}

	/**
	 * 根据 name 查找账号
	 * @param $name
	 */
	public function getAccountByName($name) {
		return Dao::factory('Account')->getAccountByName($name);
	}

	/**
	 * 根据关键字获取账号数量
	 * @param string $keyword
	 * @return array
	 */
	public function countAccountsByKeyword($keyword) {
		return Dao::factory('Account')->countAccountsByKeyword($keyword);
	}

	/**
	 * 根据关键字分页获取账号
	 * @param string $keyword
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getAccountsByKeywordAndLimit($keyword, $offset, $number) {
		return Dao::factory('Account')->getAccountsByKeywordAndLimit($keyword, $offset, $number);
	}

	/**
	 * 获取账号总数
	 * @return array
	 */
	public function countAccounts() {
		return Dao::factory('Account')->countAccounts();
	}

	/**
	 * 分页获取账号信息
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getAccountsByLimit($offset, $number) {
		return Dao::factory('Account')->getAccountsByLimit($offset, $number);
	}

	/**
	 * 根据 account_id 来查找账号
	 * @param integer $accountId
	 * @return mixed
	 */
	public function getAccountByAccountId($accountId = 0) {
		if(!$accountId) {
			return FALSE;
		}
		return Dao::factory('Account')->getAccountByAccountId($accountId);
	}

	/**
	 * 根据 account_id 来查找所有账号
	 * @param integer $accountId
	 * @return mixed
	 */
	public function getAllAccountByAccountId($accountId = 0) {
		if(!$accountId) {
			return FALSE;
		}
		return Dao::factory('Account')->getAllAccountByAccountId($accountId);
	}

	/**
	 * 根据 accountId 来修改账号
	 * @param array $values
	 * @param integer $accountId
	 * @return mixed
	 * @throws Business_Exception
	 */
	public function updateByAccountId($values, $accountId) {
		if(!$accountId) {
			return FALSE;
		}

		$fields = array (
			'name' => '',
			'email' => '',
			'mobile' => '',
			'role_id' => 0,
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;
		$email = Arr::get($values, 'email', '');
		$name = Arr::get($values, 'name', '');
		$roleId = Arr::get($values, 'role_id', '');
		$values['update_time'] = time();

		$errors = [];
		if(!$name) {
			$errors[] = '用户名不能为空';
		}
		if(!$email) {
			$errors[] = '邮箱不能为空';
		} else {
			$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
			if(!preg_match($pattern, $email)) {
				$errors[] = '邮箱不合法';
			}
		}
		if(!$roleId) {
			$errors[] = '没有选择角色';
		}
		if($errors) {
			throw new Business_Exception(implode("\n",$errors));
		}

		return Dao::factory('Account')->updateByAccountId($values, $accountId);
	}

	/**
	 * 获取所有的账号
	 */
	public function getAccounts() {
		return Dao::factory('Account')->getAccounts();
	}

	/**
	 * 根据 account_id 来修改状态
	 * @param integer $status
	 * @param integer $accountId
	 * @return mixed
	 */
	public function updateStatusByAccountId($status, $accountId) {
		if(!$accountId) {
			return FALSE;
		}

		$values = [
			'status' => $status,
			'update_time' => time()
		];
		return Dao::factory('Account')->updateByAccountId($values, $accountId);
	}

	/**
	 * 根据 account_id 来修改密码
	 * @param $password
	 * @param $accountId
	 * @return integer
	 */
	public function updatePasswordByAccountId($password, $accountId) {
		if(!$accountId) {
			return FALSE;
		}

		$values = [
			'password' => md5($password),
			'update_time' => time()
		];
		return Dao::factory('Account')->updateByAccountId($values, $accountId);
	}
}