<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 开发环境数据库配置
 */
return array
(
	'default' => array
	(
		'type'       => 'PDO',
		'connection' => array(
			'dsn'        => 'mysql:host=bj05-ops-mys03.dev.gomeplus.com;port=3306;dbname=sphinx_admin;charset=utf8',
			'username'   => 'tester',
			'password'   => 'Test_usEr',
			'persistent' => FALSE,
		),
		'table_prefix' => 'sphinx_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),

	'sphinx' => array
	(
		'type'       => 'PDO',
		'connection' => array(
			'dsn'        => 'mysql:host=bj05-ops-mys03.dev.gomeplus.com;port=3306;dbname=sphinx_admin;charset=utf8',
			'username'   => 'tester',
			'password'   => 'Test_usEr',
			'persistent' => FALSE,
		),
		'table_prefix' => 'sphinx_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
);
