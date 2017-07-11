<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 记录后台日志
 * @author phachon@163.com
 */
class Logs {

	protected static $_instance = NULL;

	public static function instance() {

		if(self::$_instance == NULL) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {

	}

	/**
	 * 写入日志
	 * @param  string $message
	 */
	public function write($message) {
		$accountId = Author::instance()->getAccountId();
		$name = Author::instance()->getName();

		$data = array (
			'message' => $message,
			'account_id' => $accountId,
			'account_name' => $name,
		);
		
		try {
			Logger::factory('log_system')->write($data)->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}
		
	}
}