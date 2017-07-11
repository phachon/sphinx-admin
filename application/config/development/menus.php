<?php
/**
 * 菜单配置
 */
return [

	//首页
	'index' => [
		'name' => '首页',
		'url' => '/',
		'icon' => 'glyphicon glyphicon-home',
	],

	//账号管理
	'account' => [
		'name' => '账号管理',
		'url' => '/account/list',
		'icon' => 'glyphicon glyphicon-user',
	],

	//机器管理
	'machine' => [
		'name' => '机器管理',
		'url' => '/machine/list',
		'icon' => 'glyphicon glyphicon-expand',
	],

	//实例管理
	'service' => [
		'name' => '实例管理',
		'url' => '/service/list',
		'icon' => 'glyphicon glyphicon-align-justify',
	],

	//任务管理
	'task' => [
		'name' => '任务管理',
		'url' => '/task/list',
		'icon' => 'glyphicon glyphicon-tasks',
	],

	//日志管理
	'log' => [
		'name' => '日志管理',
		'url' => '/log/list',
		'icon' => 'glyphicon glyphicon-list-alt',
	],

	//wiki
	'wiki' => [
		'name' => '使用文档',
		'url' => '/wiki/index',
		'icon' => 'glyphicon glyphicon-book',
	],
];