<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 日志业务逻辑
 * @author phachon@163.com
 */
class Business_Log extends Business {
	
	/**
	 * 获取总数
	 * @return integer
	 */
	public function countLogs() {

		return Dao::factory('Log_System')->countLogs();
	}

	/**
	 * 根据关键字获取日志总数
	 * @param  string $keyword
	 * @return integer
	 */
	public function countLogsByKeyword($keyword) {

		return Dao::factory('Log_System')->countLogsByKeyword($keyword);
	}

	/**
	 * 分页获取日志
	 * @param  integer $offset
	 * @param  integer $number
	 * @return array
	 */
	public function getLogsByLimit($offset = 0, $number = 0) {

		return Dao::factory('Log_System')->getLogsByLimit($offset, $number);
	}

	/**
	 * 根据关键字分页获取日志
	 * @param  integer $offset
	 * @param  integer $number
	 * @return array
	 */
	public function getLogsByLimitAndKeyword($keyword, $offset = 0, $number = 0) {

		return Dao::factory('Log_System')->getLogsByLimitAndKeyword($keyword, $offset, $number);
	}

	/**
	 * 获取异常日志总数
	 * @return integer
	 */
	public function countCrashLogs() {

		return Dao::factory('Log_Crash')->countCrashLogs();
	}

	/**
	 * 根据关键字获取异常日志总数
	 * @param  string $keyword
	 * @return integer
	 */
	public function countCrashLogsByKeyword($keyword) {

		return Dao::factory('Log_Crash')->countCrashLogsByKeyword($keyword);
	}

	/**
	 * 分页获取异常日志
	 * @param  integer $offset
	 * @param  integer $number
	 * @return array
	 */
	public function getCrashLogsByLimit($offset = 0, $number = 0) {

		return Dao::factory('Log_Crash')->getCrashLogsByLimit($offset, $number);
	}

	/**
	 * 根据关键字分页获取异常日志
	 * @param  string $keyword
	 * @param  integer $offset
	 * @param  integer $number
	 * @return array
	 */
	public function getCrashLogsByLimitAndKeyword($keyword, $offset = 0, $number = 0) {

		return Dao::factory('Log_Crash')->getCrashLogsByLimitAndKeyword($keyword, $offset, $number);
	}


}