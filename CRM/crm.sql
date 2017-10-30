/*
SQLyog Ultimate v11.25 (64 bit)
MySQL - 10.1.8-MariaDB : Database - crm
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`crm` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `crm`;

/*Table structure for table `job_cascade_title` */

DROP TABLE IF EXISTS `job_cascade_title`;

CREATE TABLE `job_cascade_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `job_cascade_title` */

insert  into `job_cascade_title`(`id`,`name`) values (26,'行业领域'),(22,'公司融资情况'),(21,'公司人数情况'),(20,'期望月薪'),(19,'城市'),(25,'职位类型 / 专业'),(27,'工作经验'),(28,'学历要求'),(29,'语言能力'),(30,'个人工作经验'),(32,'公司发展阶段'),(33,'职位工作性质'),(34,'简历状态'),(35,'后台广告类型'),(36,'视频课程类型'),(37,'Apple商店价格'),(38,'出招分类'),(39,'mvp专业分类');

/*Table structure for table `job_system_child` */

DROP TABLE IF EXISTS `job_system_child`;

CREATE TABLE `job_system_child` (
  `child_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_no` varchar(20) DEFAULT '' COMMENT '客户编号',
  `client_id` int(11) NOT NULL COMMENT '客户id',
  `owner_id` int(11) DEFAULT '0' COMMENT '拥有人id',
  `child_name` varchar(20) NOT NULL DEFAULT '' COMMENT '小朋友姓名',
  `shot_name` varchar(10) DEFAULT '' COMMENT '姓名简写',
  `child_sex` varchar(5) DEFAULT '' COMMENT '性别',
  `nickname` varchar(20) DEFAULT '' COMMENT '昵称',
  `brithday` varchar(20) DEFAULT '' COMMENT '生日',
  `child_age` int(3) DEFAULT '0' COMMENT '年龄',
  `is_ban` int(2) DEFAULT '1' COMMENT '1-正常 2-挂起',
  PRIMARY KEY (`child_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `job_system_child` */

insert  into `job_system_child`(`child_id`,`client_no`,`client_id`,`owner_id`,`child_name`,`shot_name`,`child_sex`,`nickname`,`brithday`,`child_age`,`is_ban`) values (3,'1498981772',7,10,'订单11','000','女','000','000',0,2),(4,'1498981772',7,10,'2222','2222','男','222','222',222,1),(27,'1498967982',4,1,'111','111','男','2223','333',444,1);

/*Table structure for table `job_system_client` */

DROP TABLE IF EXISTS `job_system_client`;

CREATE TABLE `job_system_client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_no` varchar(20) NOT NULL COMMENT '客户编号',
  `writer_id` int(11) DEFAULT NULL COMMENT '关联填写人的id',
  `owner_id` int(11) NOT NULL COMMENT '关联持有人的id',
  `market_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联渠道id',
  `customer_from` varchar(10) DEFAULT '1' COMMENT '来源：1电话，2线下渠道,3转介绍，4市场活动',
  `customer_ratio` char(4) DEFAULT '0' COMMENT '成交率 ABCD',
  `customer_type` varchar(10) NOT NULL DEFAULT '' COMMENT '1潜在用户，2有效客户，3历史客户',
  `father_name` varchar(20) DEFAULT '' COMMENT '父亲姓名',
  `father_tel` varchar(20) DEFAULT '' COMMENT '父亲手机号',
  `mather_name` varchar(20) DEFAULT '' COMMENT '母亲姓名',
  `mather_tel` varchar(20) DEFAULT '' COMMENT '母亲手机号',
  `input_time` varchar(20) DEFAULT '' COMMENT '创建日期',
  `update_time` varchar(20) DEFAULT '' COMMENT '更新时间',
  `is_constract` int(2) DEFAULT '1' COMMENT '1-潜在客户 2-正式客户',
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `job_system_client` */

insert  into `job_system_client`(`client_id`,`client_no`,`writer_id`,`owner_id`,`market_id`,`customer_from`,`customer_ratio`,`customer_type`,`father_name`,`father_tel`,`mather_name`,`mather_tel`,`input_time`,`update_time`,`is_constract`) values (7,'1499001800',1,10,1,'市场活动','A','潜在用户','222','12121','22','33','11123213','',1),(4,'1498967982',1,1,2,'referral','C','有效客户','1','2','222','2222','2017-7-2','',1);

/*Table structure for table `job_system_connect` */

DROP TABLE IF EXISTS `job_system_connect`;

CREATE TABLE `job_system_connect` (
  `connect_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL COMMENT '关联的客户id',
  `owner_id` int(11) DEFAULT NULL COMMENT '关联的创建人id',
  `connect_name` varchar(20) NOT NULL DEFAULT '' COMMENT '联系人姓名',
  `connect_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `connect_info` varchar(200) DEFAULT '' COMMENT '联系内容',
  `connect_date` varchar(20) NOT NULL DEFAULT '' COMMENT '联系时间',
  `is_connect` int(2) NOT NULL DEFAULT '1' COMMENT '是否联系 1-未联系 2-已联系',
  `connect_result` varchar(200) NOT NULL DEFAULT '' COMMENT '联系结果',
  `input_time` varchar(20) NOT NULL DEFAULT '' COMMENT '插入时间',
  `update_time` varchar(20) DEFAULT '' COMMENT '修改时间',
  PRIMARY KEY (`connect_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `job_system_connect` */

insert  into `job_system_connect`(`connect_id`,`client_id`,`owner_id`,`connect_name`,`connect_tel`,`connect_info`,`connect_date`,`is_connect`,`connect_result`,`input_time`,`update_time`) values (1,7,1,'去去去','1232131231223','去去去无群','123123123123',1,'','',''),(2,7,1,'去去去','1232131231223','去去去无群','123123123124',1,'','',''),(3,7,1,'老王','2','哈哈哈','2017-6-5',1,'','1499055191',''),(4,7,1,'大锤','121','1111','12321',2,'哈哈哈','1499055252','1499056348');

/*Table structure for table `job_system_constract` */

DROP TABLE IF EXISTS `job_system_constract`;

CREATE TABLE `job_system_constract` (
  `constract_id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_no` varchar(20) NOT NULL COMMENT '合同编号',
  `client_no` varchar(20) NOT NULL COMMENT '客户编号',
  `client_id` int(11) NOT NULL COMMENT '关联潜在客户id',
  `owner_id` int(11) NOT NULL DEFAULT '0' COMMENT '销售id',
  `owner_name` varchar(20) NOT NULL DEFAULT '' COMMENT '销售姓名',
  `contract_money` varchar(20) NOT NULL DEFAULT '0' COMMENT '合同金额',
  `sign_date` varchar(20) DEFAULT '' COMMENT '签约日期',
  `contract_limit` varchar(20) DEFAULT '' COMMENT '合同期限',
  `contract_status` varchar(10) DEFAULT '1' COMMENT '合同状态 1良好2异常',
  `contract_condition` varchar(10) DEFAULT '1' COMMENT '合同情况1已生效2已过期3历史客户',
  `contract_type` int(2) NOT NULL DEFAULT '1' COMMENT '合同类型1新约2续约',
  `class_num` int(10) DEFAULT '0' COMMENT '有效课时数',
  `input_time` varchar(20) NOT NULL DEFAULT '' COMMENT '创建时间',
  `update_time` varchar(20) DEFAULT '' COMMENT '更新时间',
  PRIMARY KEY (`constract_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `job_system_constract` */

insert  into `job_system_constract`(`constract_id`,`contract_no`,`client_no`,`client_id`,`owner_id`,`owner_name`,`contract_money`,`sign_date`,`contract_limit`,`contract_status`,`contract_condition`,`contract_type`,`class_num`,`input_time`,`update_time`) values (10,'2','1498967982',4,1,'大黄','3','4','5','2','2',2,6,'1499073555',''),(9,'1','1499001800',7,10,'大黄','1','1','2','1','1',1,3,'1499073535',''),(8,'2','1498967982',4,1,'大黄','3','4','5','2','2',2,6,'1499073555',''),(7,'2','1498967982',4,1,'大黄','3','4','5','2','2',2,6,'1499073555',''),(6,'1','1499001800',7,10,'大黄','1','1','2','1','1',1,3,'1499073535',''),(18,'2','1498967982',4,10,'大黄','3','4','5','2','2',2,6,'1499073555','');

/*Table structure for table `job_system_market` */

DROP TABLE IF EXISTS `job_system_market`;

CREATE TABLE `job_system_market` (
  `market_id` int(255) NOT NULL AUTO_INCREMENT,
  `market_name` varchar(100) NOT NULL DEFAULT '' COMMENT '渠道名称',
  `insert_time` varchar(20) DEFAULT '' COMMENT '创建时间',
  `is_del` int(2) DEFAULT '0' COMMENT '是否删除 1-删除',
  PRIMARY KEY (`market_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `job_system_market` */

insert  into `job_system_market`(`market_id`,`market_name`,`insert_time`,`is_del`) values (1,'海淀','1498802967',0),(2,'高碑店','1498629951',0);

/*Table structure for table `job_system_user` */

DROP TABLE IF EXISTS `job_system_user`;

CREATE TABLE `job_system_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(4000) DEFAULT NULL,
  `PASSWORD` varchar(4000) DEFAULT NULL,
  `authority` int(11) DEFAULT NULL,
  `u_group_id` smallint(6) NOT NULL COMMENT '用户组id',
  `last_log_time` int(10) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_log_ip` varchar(30) NOT NULL DEFAULT '0' COMMENT '最后登录ip',
  `is_ban` int(1) NOT NULL DEFAULT '0',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '账户使用者姓名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `job_system_user` */

insert  into `job_system_user`(`id`,`account`,`PASSWORD`,`authority`,`u_group_id`,`last_log_time`,`last_log_ip`,`is_ban`,`user_name`) values (1,'admin','3e374910235c11731d923930d306f5ff',NULL,1,1499079143,'127.0.0.1',1,'大黄'),(10,'huangbin','19366f0b65105dbaed239a234506282d',NULL,3,1499078957,'127.0.0.1',1,'你好');

/*Table structure for table `job_system_useracl` */

DROP TABLE IF EXISTS `job_system_useracl`;

CREATE TABLE `job_system_useracl` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
  `intro` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `controller` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `job_system_useracl` */

insert  into `job_system_useracl`(`id`,`name`,`intro`,`controller`) values (1,'超级管理员','系统最高权限用户，应该拥有所有功能权限','a:8:{s:8:\"sysadmin\";a:1:{i:0;s:3:\"br1\";}s:7:\"sysuser\";a:4:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";}s:6:\"sysacl\";a:4:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";}s:9:\"sysmarket\";a:4:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";}s:9:\"sysclient\";a:6:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";}s:10:\"sysconnect\";a:5:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";}s:12:\"sysconstract\";a:5:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";}s:8:\"syschild\";a:4:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";}}'),(2,'市场部','拥有分配潜在客户，查看成交客户的权限','a:25:{s:8:\"sysadmin\";a:6:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br9\";i:3;s:3:\"br3\";i:4;s:3:\"br4\";i:5;s:3:\"br5\";}s:8:\"sysCount\";a:6:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";}s:6:\"Sysapp\";a:19:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";i:9;s:4:\"br10\";i:10;s:4:\"br10\";i:11;s:4:\"br11\";i:12;s:4:\"br12\";i:13;s:4:\"br12\";i:14;s:4:\"br12\";i:15;s:4:\"br12\";i:16;s:4:\"br13\";i:17;s:4:\"br14\";i:18;s:4:\"br15\";}s:7:\"cascade\";a:11:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";i:9;s:4:\"br10\";i:10;s:4:\"br11\";}s:9:\"sysadvert\";a:9:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";}s:4:\"find\";a:11:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";i:9;s:4:\"br10\";i:10;s:4:\"br11\";}s:7:\"sysnews\";a:10:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";i:9;s:4:\"br10\";}s:14:\"sysVideoCourse\";a:15:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";i:9;s:4:\"br10\";i:10;s:4:\"br11\";i:11;s:4:\"br12\";i:12;s:4:\"br13\";i:13;s:4:\"br14\";i:14;s:4:\"br15\";}s:7:\"sysuser\";a:4:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";}s:6:\"sysacl\";a:4:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";}s:13:\"sysenterprise\";a:19:{i:0;s:3:\"br3\";i:1;s:3:\"br5\";i:2;s:3:\"br6\";i:3;s:3:\"br7\";i:4;s:3:\"br8\";i:5;s:3:\"br9\";i:6;s:4:\"br10\";i:7;s:4:\"br11\";i:8;s:4:\"br12\";i:9;s:4:\"br13\";i:10;s:4:\"br14\";i:11;s:4:\"br15\";i:12;s:4:\"br16\";i:13;s:4:\"br17\";i:14;s:4:\"br18\";i:15;s:4:\"br19\";i:16;s:4:\"br20\";i:17;s:4:\"br21\";i:18;s:4:\"br22\";}s:6:\"sysmvp\";a:11:{i:0;s:3:\"br3\";i:1;s:3:\"br5\";i:2;s:3:\"br6\";i:3;s:3:\"br7\";i:4;s:3:\"br8\";i:5;s:3:\"br9\";i:6;s:4:\"br10\";i:7;s:4:\"br11\";i:8;s:4:\"br12\";i:9;s:4:\"br13\";i:10;s:4:\"br14\";}s:6:\"sysmem\";a:9:{i:0;s:3:\"br1\";i:1;s:3:\"br3\";i:2;s:3:\"br4\";i:3;s:3:\"br2\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";}s:11:\"syscomplain\";a:2:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";}s:17:\"sysClientUserInfo\";a:2:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";}s:13:\"SysRedeemCode\";a:3:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";}s:6:\"SysVip\";a:3:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";}s:8:\"SysOrder\";a:3:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";}s:10:\"Sysmvpidea\";a:8:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";}s:10:\"Sysmvpinfo\";a:9:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";}s:13:\"Sysmvpservice\";a:9:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";}s:10:\"Sysmvpprod\";a:10:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";i:9;s:4:\"br10\";}s:13:\"Sysmvpdeposit\";a:10:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";i:6;s:3:\"br7\";i:7;s:3:\"br8\";i:8;s:3:\"br9\";i:9;s:4:\"br10\";}s:7:\"Sysmemb\";a:5:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br8\";}s:13:\"SysDemandList\";a:5:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";}}'),(3,'销售顾问','可拥有操作客户信息的权限','a:6:{s:8:\"sysadmin\";a:1:{i:0;s:3:\"br1\";}s:9:\"sysmarket\";a:4:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";}s:9:\"sysclient\";a:6:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";i:5;s:3:\"br6\";}s:10:\"sysconnect\";a:5:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";}s:12:\"sysconstract\";a:5:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";i:4;s:3:\"br5\";}s:8:\"syschild\";a:4:{i:0;s:3:\"br1\";i:1;s:3:\"br2\";i:2;s:3:\"br3\";i:3;s:3:\"br4\";}}');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
