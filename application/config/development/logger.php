<?php
/**
 * 日志信息配置
 * @author panchao
 */
return array(
	/**
	 * 系统日志（数据库）
	 */
	'log_system' => array(
		'type' => 'database',
		'parameters' => array (
			'group' 	 => 'sphinx',
			'table'      => 'log_system',
			'slice'		 => '',
		),
		'columns' => array(
			'message' => '',
			'ip' => Misc::getClientIp(),
			'referer' => Request::current()->referrer() ? Request::current()->referrer() : '',
			'user_agent' => Request::$user_agent,
			'account_id' => '',
			'account_name' => '',
			'create_time' => time(),
		),
	),
);
