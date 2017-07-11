<?php
/**
 * 脚本执行入口
 * @author: phachon@163.com
 */

/**
 * 目录
 */
define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('CLASS_PATH', realpath(ROOT_PATH.'classes') . DIRECTORY_SEPARATOR);
define('LOG_PATH', realpath(ROOT_PATH.'logs') . DIRECTORY_SEPARATOR);
define('CONF_PATH', realpath(ROOT_PATH.'config') . DIRECTORY_SEPARATOR);
define('ETC_PATH', realpath(ROOT_PATH.'etc') . DIRECTORY_SEPARATOR);
define('ERROR_LOG', realpath(LOG_PATH) . DIRECTORY_SEPARATOR. 'error.log');
define('SUCCESS_LOG', realpath(LOG_PATH) . DIRECTORY_SEPARATOR . 'success.log');

/**
 * date
 */
date_default_timezone_set('Asia/Shanghai');

/**
 * 启动
 */
require_once CLASS_PATH.'Bootstrap.php';


$bootstrap = Bootstrap::init()
	->modules([
		'classes' => CLASS_PATH
	]);

$bootstrap->run();
