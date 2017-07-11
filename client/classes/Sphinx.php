<?php
/**
 * Sphinx 类
 * @author: phachon@163.com
 */
abstract class Sphinx {

	/**
	 * 实例id
	 * @var string
	 */
	protected $_serviceId = '';

	/**
	 * 实例执行 action (start, stop, rebuild)
	 * @var string
	 */
	protected $_action = '';

	/**
	 * 配置文件
	 * @var array
	 */
	protected $_config = [];

	/**
	 * @param $action
	 * @return Sphinx
	 * @throws Sphinx_Exception
	 */
	public static function factory($action) {
		$action = ucfirst(strtolower($action));
		$className = "Sphinx_".$action;
		if(!class_exists($className)) {
			throw new Sphinx_Exception('class '.$className.' not found');
		}

		return new $className();
	}

	public function __construct() {
		$this->_config = Config::load();
	}

	/**
	 * @param $serviceId
	 * @return $this
	 */
	public function serviceId($serviceId) {
		$this->_serviceId = $serviceId;
		return $this;
	}

	abstract public function execute();
}