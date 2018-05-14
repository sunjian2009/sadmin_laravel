# Host: 127.0.0.1  (Version 5.5.54-log)
# Date: 2018-05-15 05:40:47
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "admin_access"
#

DROP TABLE IF EXISTS `admin_access`;
CREATE TABLE `admin_access` (
  `role_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `node_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

#
# Data for table "admin_access"
#

INSERT INTO `admin_access` VALUES (2,1,1,0),(2,4,2,1),(2,38,3,4),(2,39,3,4),(2,40,3,4),(2,41,3,4),(2,42,3,4),(2,43,3,4),(2,44,3,4);

#
# Structure for table "admin_group"
#

DROP TABLE IF EXISTS `admin_group`;
CREATE TABLE `admin_group` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `icon` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'icon小图标',
  `sort` int(11) unsigned NOT NULL DEFAULT '50',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remark` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

#
# Data for table "admin_group"
#

INSERT INTO `admin_group` VALUES (1,'系统管理','&#xe61d;',2,1,'',0,'2015-05-18 16:28:07',NULL),(2,'文章管理','&#xe616;',3,1,'',0,'2015-05-18 16:28:07',NULL);

#
# Structure for table "admin_login_log"
#

DROP TABLE IF EXISTS `admin_login_log`;
CREATE TABLE `admin_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `login_ip` char(15) COLLATE utf8_bin NOT NULL DEFAULT '',
  `login_location` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `login_browser` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `login_os` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

#
# Data for table "admin_login_log"
#

INSERT INTO `admin_login_log` VALUES (1,1,'0.0.0.0','保留地址 保留地址  ','Firefox(56.0)','Windows 10','2017-11-14 01:41:09'),(2,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2017-12-01 18:26:43'),(3,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2017-12-11 03:00:35'),(4,1,'171.214.159.130','中国 四川 成都 ','Firefox(57.0)','Windows 10','2017-12-11 03:00:51'),(5,1,'171.214.159.130','中国 四川 成都 ','Firefox(57.0)','Windows 10','2017-12-11 12:58:18'),(6,1,'115.238.229.35','中国 浙江 湖州 ','IE(11.0)','Windows 10','2017-12-11 13:00:06'),(7,1,'115.238.229.35','中国 浙江 湖州 ','IE(11.0)','Windows 7','2017-12-11 19:11:47'),(8,1,'115.238.229.35','中国 浙江 湖州 ','IE(11.0)','Windows 7','2017-12-11 21:05:52'),(9,1,'115.238.229.35','中国 浙江 湖州 ','Chrome(63.0.3239.84)','Windows 7','2017-12-11 21:13:01'),(10,1,'171.214.159.60','中国 四川 成都 ','Firefox(57.0)','Windows 10','2017-12-13 23:35:57'),(11,1,'115.238.229.35','中国 浙江 湖州 ','IE(11.0)','Windows 10','2017-12-25 14:05:14'),(12,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2017-12-30 15:39:59'),(13,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2017-12-30 18:14:12'),(14,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2017-12-30 20:18:53'),(15,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2018-01-04 21:42:21'),(16,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2018-01-05 12:28:55'),(17,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2018-01-05 15:10:17'),(18,1,'0.0.0.0','保留地址 保留地址  ','Chrome(63.0.3239.84)','Windows 10','2018-01-05 17:05:39'),(19,1,'0.0.0.0','保留地址 保留地址  ','Chrome(63.0.3239.84)','Windows 10','2018-01-06 12:56:19'),(20,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2018-01-08 21:53:20'),(21,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2018-01-09 11:53:40'),(22,1,'171.214.158.205','中国 四川 成都 ','Chrome(63.0.3239.84)','Windows 10','2018-01-09 15:44:25'),(23,1,'0.0.0.0','保留地址 保留地址  ','Chrome(63.0.3239.84)','Windows 10','2018-01-09 15:45:56'),(24,1,'0.0.0.0','保留地址 保留地址  ','Chrome(63.0.3239.84)','Windows 10','2018-01-11 14:45:31'),(25,1,'0.0.0.0','保留地址 保留地址  ','Chrome(63.0.3239.84)','Windows 10','2018-01-14 13:16:17'),(26,1,'0.0.0.0','保留地址 保留地址  ','Firefox(57.0)','Windows 10','2018-01-14 17:00:43'),(27,1,'0.0.0.0','保留地址 保留地址  ','Chrome(63.0.3239.84)','Windows 10','2018-01-17 11:43:05'),(28,1,'171.214.154.233','中国 四川 成都 ','Chrome(63.0.3239.84)','Windows 10','2018-01-23 18:41:47'),(29,1,'171.214.154.233','中国 四川 成都 ','Chrome(63.0.3239.84)','Windows 10','2018-01-24 00:54:23'),(30,1,'::1','','','','2018-02-02 15:28:00'),(31,1,'::1','','','','2018-02-02 15:29:39'),(32,1,'::1','','','','2018-02-02 15:30:03'),(33,1,'::1','','','','2018-02-02 15:30:22'),(34,1,'::1','','','','2018-02-02 15:48:48'),(35,1,'::1','','','','2018-02-02 15:57:31'),(36,1,'::1','','','','2018-02-02 15:59:08'),(37,1,'::1','','','','2018-02-02 16:09:44'),(38,1,'::1','','','','2018-02-02 16:17:31'),(39,1,'::1','','','','2018-02-02 16:18:01'),(40,1,'::1','','','','2018-02-02 16:18:48'),(41,1,'::1','','','','2018-02-02 17:32:10'),(42,1,'::1','N/A','Firefox','Windows','2018-02-02 19:22:34'),(43,1,'::1','N/A','Firefox','Windows','2018-02-03 01:23:26'),(44,1,'::1','N/A','Firefox','Windows','2018-02-03 02:00:25'),(45,1,'::1','N/A','Chrome','Windows','2018-02-04 14:42:37'),(46,1,'::1','N/A','Firefox','Windows','2018-02-06 23:21:40'),(47,1,'::1','N/A','Firefox','Windows','2018-02-08 02:18:39'),(48,1,'::1','N/A','Firefox','Windows','2018-02-08 14:30:32'),(49,1,'::1','N/A','Firefox','Windows','2018-02-08 18:34:12'),(50,1,'::1','N/A','Firefox','Windows','2018-02-08 20:39:43'),(51,1,'::1','N/A','Firefox','Windows','2018-02-09 01:23:08');

#
# Structure for table "admin_node"
#

DROP TABLE IF EXISTS `admin_node`;
CREATE TABLE `admin_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `title` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `remark` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '节点类型，1-控制器 | 0-方法',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '50',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `isdelete` (`is_delete`),
  KEY `level` (`level`),
  KEY `name` (`name`),
  KEY `pid` (`pid`),
  KEY `sort` (`sort`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

#
# Data for table "admin_node"
#

INSERT INTO `admin_node` VALUES (1,0,1,'admin','后台管理','后台管理，不可更改',1,1,1,1,0,NULL,NULL),(2,1,1,'group','分组管理',' ',2,1,1,1,0,NULL,NULL),(3,1,1,'node','节点管理',' ',2,1,2,1,0,NULL,NULL),(4,1,1,'role','角色管理',' ',2,1,3,1,0,NULL,NULL),(5,1,1,'user','管理员管理','',2,1,4,1,0,NULL,NULL),(6,1,0,'index','首页','',2,1,50,1,0,NULL,NULL),(7,6,0,'welcome','欢迎页','',3,0,50,1,0,NULL,NULL),(8,6,0,'index','未定义','',3,0,50,1,0,NULL,NULL),(9,1,2,'article','文章管理','',2,1,50,1,0,NULL,NULL),(17,1,2,'articleType','文章分类管理','',2,0,9,1,0,NULL,NULL),(22,1,1,'webLog','操作日志','',2,1,6,0,0,NULL,NULL),(23,1,1,'loginLog','登录日志','',2,1,7,1,0,NULL,NULL),(24,23,0,'index','首页','',3,0,50,1,0,NULL,NULL),(25,22,0,'index','列表','',3,0,50,1,0,NULL,NULL),(26,22,0,'detail','详情','',3,0,50,1,0,NULL,NULL),(27,21,0,'load','自动导入','',3,0,50,1,0,NULL,NULL),(28,21,0,'index','首页','',3,0,50,1,0,NULL,NULL),(29,5,0,'add','添加','',3,0,51,1,0,NULL,NULL),(30,21,0,'edit','编辑','',3,0,50,1,0,NULL,NULL),(31,21,0,'deleteForever','永久删除','',3,0,50,1,0,NULL,NULL),(32,9,0,'index','首页','',3,0,50,1,0,NULL,NULL),(33,9,0,'generate','生成方法','',3,0,50,1,0,NULL,NULL),(34,5,0,'password','修改密码','',3,0,50,1,0,NULL,NULL),(35,5,0,'index','首页','',3,0,50,1,0,NULL,NULL),(36,5,0,'add','添加','',3,0,50,1,0,NULL,NULL),(37,5,0,'edit','编辑','',3,0,50,1,0,NULL,NULL),(38,4,0,'user','用户列表','',3,0,50,1,0,NULL,NULL),(39,4,0,'access','授权','',3,0,50,1,0,NULL,NULL),(40,4,0,'index','首页','',3,0,50,1,0,NULL,NULL),(41,4,0,'add','添加','',3,0,50,1,0,NULL,NULL),(42,4,0,'edit','编辑','',3,0,50,1,0,NULL,NULL),(43,4,0,'forbid','默认禁用操作','',3,0,50,1,0,NULL,NULL),(44,4,0,'resume','默认恢复操作','',3,0,50,1,0,NULL,NULL),(46,3,0,'index','首页','',3,0,50,1,0,NULL,NULL),(47,3,0,'add','添加','',3,0,50,1,0,NULL,NULL),(48,3,0,'edit','编辑','',3,0,50,1,0,NULL,NULL),(49,3,0,'forbid','默认禁用操作','',3,0,50,1,0,NULL,NULL),(50,3,0,'resume','默认恢复操作','',3,0,50,1,0,NULL,NULL),(51,2,0,'index','首页','',3,0,50,1,0,NULL,NULL),(52,2,0,'add','添加','',3,0,50,1,0,NULL,'2018-05-14 11:59:02'),(53,2,0,'edit','编辑','',3,0,50,1,0,NULL,'2018-05-14 11:56:19'),(54,2,0,'forbid','默认禁用操作','',3,0,51,1,0,NULL,NULL),(55,2,0,'resume','默认恢复操作','',3,0,50,1,0,NULL,NULL);

#
# Structure for table "admin_role"
#

DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '名称',
  `remark` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `isdelete` (`is_delete`),
  KEY `parentId` (`pid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

#
# Data for table "admin_role"
#

INSERT INTO `admin_role` VALUES (1,0,'管理员',' ',1,0,'2015-05-18 16:28:07',NULL),(2,0,'图片管理员',' ',0,0,'2015-05-18 16:28:07',NULL);

#
# Structure for table "admin_role_user"
#

DROP TABLE IF EXISTS `admin_role_user`;
CREATE TABLE `admin_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) COLLATE utf8_bin DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

#
# Data for table "admin_role_user"
#

INSERT INTO `admin_role_user` VALUES (1,'2'),(2,'2'),(2,'3');

#
# Structure for table "admin_user"
#

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(32) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '账号',
  `realname` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` char(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `last_login_ip` char(15) COLLATE utf8_bin NOT NULL DEFAULT '',
  `login_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `email` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `mobile` char(11) COLLATE utf8_bin NOT NULL DEFAULT '',
  `remark` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '50',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accountpassword` (`account`,`password`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

#
# Data for table "admin_user"
#

INSERT INTO `admin_user` VALUES (1,'admin','超级管理员','e10adc3949ba59abbe56e057f20f883e','::1',1,'71401790@qq.com','18030843434','fdfdfd',1,0,'2015-05-18 16:28:07','2018-05-14 20:06:38','2018-05-14 20:09:44'),(2,'demo','测试','e10adc3949ba59abbe56e057f20f883e','127.0.0.1',5,'71401790@qq.com','18030833333','fdfdf',1,0,'2015-05-18 16:28:07','2018-05-14 19:52:51',NULL),(3,'111111','11111','96e79218965eb72c92a549dd5a330112','',0,'71401790@qq.com','18030843434','dsfd',1,0,'2018-05-14 19:55:51','2018-05-14 20:07:37',NULL);

#
# Structure for table "file"
#

DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '文件类型，1-image | 2-file',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '文件名',
  `original` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '原文件名',
  `domain` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '域名',
  `type` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

#
# Data for table "file"
#

