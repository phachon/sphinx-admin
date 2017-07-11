<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Class Business
 * @author phachon@163.com
 */
abstract class Business {

	/**
	 * Business对象容器
	 * @var array
	 */
	protected static $_businessContainer = [];

	/**
	 * Business factory
	 * @param string $name
	 * @return mixed
	 */
	public static function factory($name) {
		$name = ucfirst($name);
		$className = "Business_$name";
		if(!isset(self::$_businessContainer[$className])) {
			self::$_businessContainer[$className] = new $className();
		}
		return self::$_businessContainer[$className];
	}
} 
