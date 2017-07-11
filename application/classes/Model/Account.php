<?php
/**
 * 数据模型 - 账号
 * @author: phachon@163.com
 */
class Model_Account extends Model_Base {

	const STATUS_NORMAL = 0;
	const STATUS_DISABLE = -1;

	/**
	 * 获取 role_name
	 * @return mixed
	 */
	public function getRoleName() {
		$role = Role::instance()->getRoleByRoleId($this->role_id);
		return Arr::get($role, 'name', '');
	}
}