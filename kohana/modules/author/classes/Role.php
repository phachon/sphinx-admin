<?php
/**
 * 角色
 * @author: phachon@163.com
 */
class Role {

	/**
	 * 角色配置
	 * @var array
	 */
	protected $_config = [];

	/**
	 * instance
	 * @var null
	 */
	protected static $_instance = NULL;

	//系统管理员
	const ROLE_SYSTEM_MANAGER = 1;
	//管理员
	const ROLE_MANAGER = 2;
	//普通账号
	const ROLE_NORMAL = 3;

	/**
	 * @return null|Role
	 */
	public static function instance() {
		if(self::$_instance === NULL) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Role constructor.
	 */
	public function __construct() {
		$this->_config = Kohana::$config->load('role')->as_array();
	}

	/**
	 * 获取所有的角色
	 * @return array
	 */
	public function getRoles() {
		return $this->_config;
	}

	/**
	 * 根据 role_id 获取角色
	 * @param int $roleId
	 * @return mixed
	 */
	public function getRoleByRoleId($roleId = 0) {
		return Arr::get($this->_config, $roleId, []);
	}
}