-- -----------------------------------
-- sphinx admin database
-- author phachon@163.com
-- time 2017-03-27
-- -----------------------------------

-- -----------------------------------
-- 创建数据库
-- -----------------------------------
CREATE DATABASE sphinx_admin CHARSET utf8;

-- -----------------------------------
-- use
-- -----------------------------------
use sphinx_admin;

-- -----------------------------------
-- session 表
-- -----------------------------------
DROP TABLE IF EXISTS `sphinx_session`;
CREATE TABLE `sphinx_session` (
  `session_id` varchar(24) NOT NULL DEFAULT '' COMMENT 'Session id',
  `last_active` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Last active time',
  `contents` varchar(1000) NOT NULL DEFAULT '' COMMENT 'Session data',
  PRIMARY KEY (`session_id`),
  KEY `last_active` (`last_active`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='会话信息表';

-- -------------------------------------
-- 账号表
-- -------------------------------------
DROP TABLE IF EXISTS `sphinx_account`;
CREATE TABLE `sphinx_account` (
  `account_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '账号id',
  `name` char(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `role_id` int(10) NOT NULL DEFAULT '0' COMMENT '角色 1 admin 2 普通',
  `mobile` char(18) NOT NULL DEFAULT '0' COMMENT '手机',
  `email` char(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 正常 -1 删除',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 COMMENT='账号信息表';

INSERT INTO sphinx_admin.sphinx_account (name, password, role_id, mobile, email, status, create_time, update_time) VALUES ('root', '96e79218965eb72c92a549dd5a330112', 1, '15201203612', 'phachon@163.com', 0, 1471512945, 1471593345);

-- -------------------------------------
-- 角色表
-- -------------------------------------
DROP TABLE IF EXISTS `sphinx_role`;
CREATE TABLE `sphinx_role` (
  `role_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'role id',
  `name` char(100) NOT NULL DEFAULT '' COMMENT '角色名',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 正常 -1 删除',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `privilege_menu` char(200) NOT NULL DEFAULT 'profile',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 COMMENT='用户角色表';

INSERT INTO sphinx_admin.sphinx_role (name, status, create_time, update_time) VALUES ('超级管理员', 0, 1471503644, 1471603059);

-- -------------------------------------
-- sphinx 机器表
-- -------------------------------------
DROP TABLE IF EXISTS `sphinx_machine`;
CREATE TABLE `sphinx_machine` (
  `machine_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'machine id',
  `domain` char(100) NOT NULL DEFAULT '' COMMENT '域名',
  `ip` char(30) NOT NULL DEFAULT '' COMMENT '机器IP地址',
  `sphinx_path` varchar(200) NOT NULL DEFAULT '' COMMENT 'sphinx 安装路径',
  `comment` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态，-1删除，0正常',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`machine_id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 COMMENT='sphinx 机器表';

-- -------------------------------------
-- sphinx 实例信息表
-- -------------------------------------
DROP TABLE IF EXISTS `sphinx_service`;
CREATE TABLE `sphinx_service` (
  `service_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'service id',
  `machine_id` int(10) NOT NULL DEFAULT '0' COMMENT '机器 id',
  `name` char(50) NOT NULL DEFAULT '' COMMENT '实例名称',
  `source_name` char(100) NOT NULL DEFAULT '' COMMENT '数据源名称',
  `source_type` char(100) NOT NULL DEFAULT 'mysql' COMMENT '数据源类型 mysql，pgsql，mssql',
  `sql_host` char(100) NOT NULL DEFAULT '' COMMENT 'sql 主机',
  `sql_port` int(10) NOT NULL DEFAULT '3306' COMMENT 'sql 端口',
  `sql_user` char(200) NOT NULL DEFAULT '' COMMENT 'sql 用户名',
  `sql_pass` char(100) NOT NULL DEFAULT '' COMMENT 'sql 密码',
  `sql_db` char(100) NOT NULL DEFAULT '' COMMENT 'sql 数据库',
  `sql_table` char(100) NOT NULL DEFAULT '' COMMENT 'sql 表',
  `sql_charset` char(100) NOT NULL DEFAULT 'utf8' COMMENT 'sql 字符集',
  `source_number` int(10) NOT NULL DEFAULT '1' COMMENT '数据源个数，分表数',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 停止 1 启动 2 执行中 -1删除',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`service_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 COMMENT='sphinx 服务信息表';

-- -------------------------------------
-- sphinx 数据源字段信息表
-- -------------------------------------
DROP TABLE IF EXISTS `sphinx_service_column`;
CREATE TABLE `sphinx_service_column` (
  `service_column_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'column id',
  `service_id` int(10) NOT NULL DEFAULT '0' COMMENT 'sphinx 实例id',
  `column` char(100) NOT NULL DEFAULT '' COMMENT '字段名',
  `column_attr` char(100) NOT NULL DEFAULT '' COMMENT '字段属性',
  `is_id_column` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是文档id字段 0 不是 1 是',
  `sql_condition` varchar(200) NOT NULL DEFAULT '' COMMENT 'sql 条件语句',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`service_column_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sphinx 实例字段信息表';

-- -------------------------------------
-- sphinx 索引信息表
-- -------------------------------------
DROP TABLE IF EXISTS `sphinx_service_indexer`;
CREATE TABLE `sphinx_service_indexer` (
  `service_indexer_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'service source id',
  `name` char(50) NOT NULL DEFAULT '' COMMENT '索引名',
  `type` char(50) NOT NULL DEFAULT '' COMMENT '索引类型 plain, distributed, rt',
  `service_id` int(10) NOT NULL DEFAULT '0' COMMENT 'sphinx 实例id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 正常 -1 删除',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`service_indexer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sphinx 实例索引信息表';

-- -------------------------------------
-- sphinx searchd信息表
-- -------------------------------------
DROP TABLE IF EXISTS `sphinx_service_searchd`;
CREATE TABLE `sphinx_service_searchd` (
  `service_searchd_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'service searchd id',
  `service_id` int(10) NOT NULL DEFAULT '0' COMMENT 'sphinx 实例id',
  `sphinx_listen` int(10) NOT NULL DEFAULT '9312' COMMENT 'sphinx searchd 进程监听端口',
  `mysql_listen` int(10) NOT NULL DEFAULT '9301' COMMENT 'sphinx mysql 进程监听端口',
  `read_timeout` int(4) NOT NULL DEFAULT '5' COMMENT '客户端读超时时间',
  `client_timeout` int(5) NOT NULL DEFAULT '300' COMMENT '客户端超时时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 正常 -1 删除',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`service_searchd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sphinx 实例searchd信息表'

-- -------------------------------------
-- sphinx 系统日志信息表
-- -------------------------------------
DROP TABLE IF EXISTS `sphinx_log_system`;
CREATE TABLE `sphinx_log_system` (
  `log_system_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '系统日志 id',
  `message` varchar(255) NOT NULL DEFAULT '' COMMENT '信息',
  `ip` char(100) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `user_agent` char(200) NOT NULL DEFAULT '' COMMENT '用户代理',
  `referer` char(100) NOT NULL DEFAULT '' COMMENT 'referer',
  `account_id` int(10) NOT NULL DEFAULT '0' COMMENT '帐号id',
  `account_name` char(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`log_system_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sphinx 系统日志信息表';

-- ----------------------------------------------------------
-- sphinx 异常日志表
-- ----------------------------------------------------------
DROP TABLE IF EXISTS `sphinx_log_crash`;
CREATE TABLE `sphinx_log_crash` (
  `log_crash_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '异常日志id',
  `ip` varchar(20) NOT NULL DEFAULT '' COMMENT 'IP',
  `hostname` varchar(100) NOT NULL DEFAULT '' COMMENT '服务器名',
  `level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '级别',
  `file` varchar(256) NOT NULL DEFAULT '' COMMENT '文件',
  `line` int(10) NOT NULL DEFAULT '0' COMMENT '行数',
  `message` text NOT NULL COMMENT '信息',
  `uri` varchar(100) NOT NULL DEFAULT '' COMMENT '请求url',
  `get` text NOT NULL COMMENT 'get参数',
  `post` text NOT NULL COMMENT 'post参数',
  `server` text NOT NULL COMMENT 'request参数',
  `cookie` text NOT NULL COMMENT 'cookie参数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`log_crash_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sphinx 异常日志表';

-- -------------------------------------
-- sphinx 执行任务表
-- -------------------------------------
DROP TABLE IF EXISTS `sphinx_task`;
CREATE TABLE `sphinx_task`(
  `task_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'task id',
  `service_id` int(10) NOT NULL DEFAULT '0' COMMENT 'sphinx 服务id',
  `type` int(3) NOT NULL DEFAULT '0' COMMENT '执行的任务类型 0 无 1 启动 2 关闭 3 重启 4 重建索引 5 合并索引',
  `ip` char(30) NOT NULL DEFAULT '' COMMENT '机器IP地址',
  `exec_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '执行状态 0 待执行 -1 执行失败 1执行成功',
  `retry_count` tinyint(2) NOT NULL DEFAULT '0' COMMENT '重试次数',
  `exec_results` text NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`task_id`)
)ENGINE=InnoDB DEFAULT CHARSET=UTF8 COMMENT='sphinx 执行任务表';
