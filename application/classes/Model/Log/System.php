<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 系统日志 model
 * @author phachon@163.com
 */
class Model_Log_System extends Model_Base {

	/**
	 * 等级显示
	 */
	public function getLevel() {
		switch($this->level) {
			case LOG_EMERG:
				return '<span class="label label-danger">EMERGENCY</span>';
				break;
			case LOG_ALERT:
				return '<span class="label label-danger">ALERT</span>';
				break;
			case LOG_CRIT:
				return '<span class="label label-danger">CRITICAL</span>';
				break;
			case LOG_ERR:
				return '<span class="label label-warning">ERROR</span>';
				break;
			case LOG_WARNING:
				return '<span class="label label-warning">WARNING</span>';
				break;
			case LOG_NOTICE:
				return '<span class="label label-info">NOTICE</span>';
				break;
			case LOG_INFO:
				return '<span class="label label-info">INFO</span>';
				break;
			case LOG_DEBUG:
				return '<span class="label label-info">DEBUG</span>';
				break;
			default:
				return '';
		}
	}
}