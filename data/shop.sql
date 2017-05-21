CREATE DATABASE IF NOT EXISTS `shop`;
USE `shop`;

--管理员表
DROP TABLE IF NOT EXISTS `admin`;
CREATE TABLE `admin`(
	`id` tinyint unsigned auto_increment key,
	`username` varchar(20) not null unique,
	`password` char(32) not null,
	`email` varchar(50) not null
);

--分类表
DROP TABLE IF EXISTS `cate`;
CREATE TABLE `cate`(
	`id` smallint unsigned auto_increment key,
	`cName` varchar(50) unique
);

--商品表
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`(
	`id` int unsigned auto_increment key,
	`pName` varchar(50) not null unique,
	`pSn` varchar(50) not null,
	`PNum` int unsigned default 1,
	`mPrice` decimal(10, 2) not null,
	`iPrice` decimal(10, 2) not null,
	`pImg` varchar(50) not null,
	`pubTime` int unsigned not null,
	`isShow` tinyint(1) default 1,
	`isHot` tinyint(1) default 0,
	`cId` smallint unsigned not null 
);

-- 用户表
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `sex` enum('男','女','保密') NOT NULL DEFAULT '保密',
  `email` varchar(50) NOT NULL,
  `face` varchar(50) NOT NULL,
  `regTime` int(10) unsigned NOT NULL,
  `activeFlag` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- 相册表
DROP TABLE IF EXISTS `album`;
CREATE TABLE `album`(
	`id` int unsigned auto_increment key,
	`Pid` int unsigned not null,
	`albumPath` varchar(50) not null
);
