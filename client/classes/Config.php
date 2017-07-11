<?php
/**
 * configuration
 * @author: phachon@163.com
 */
class Config {

	protected static $_configs = [];

	/**
	 * 加载配置文件信息
	 * @param $key
	 * @return mixed
	 * @throws Exception
	 * @internal param $path
	 */
	public static function load($key = null) {
		$configFile = CONF_PATH . Bootstrap::$env . '.php';

		if(!is_file($configFile)) {
			throw new Exception('config file '.$configFile.' not found');
		}

		if(!self::$_configs) {
			self::$_configs = include_once $configFile;
		}

		return $key ? self::$_configs[$key] : self::$_configs;
	}
}