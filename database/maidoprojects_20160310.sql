/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50711
 Source Host           : localhost
 Source Database       : maidoprojects

 Target Server Version : 50711
 File Encoding         : utf-8

 Date: 03/10/2016 12:00:37 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `agencies`
-- ----------------------------
DROP TABLE IF EXISTS `agencies`;
CREATE TABLE `agencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `clients`
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `notes`
-- ----------------------------
DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int(10) NOT NULL,
  `projectmanager_id` int(10) NOT NULL,
  `note` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `projectmanagers`
-- ----------------------------
DROP TABLE IF EXISTS `projectmanagers`;
CREATE TABLE `projectmanagers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `projects`
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `agency_id` int(10) unsigned NOT NULL,
  `projectmanager_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `projectmanager_id` (`projectmanager_id`),
  KEY `agency_id` (`agency_id`),
  KEY `client_id` (`client_id`),
  KEY `agency_id_2` (`agency_id`),
  KEY `client_id_2` (`client_id`),
  KEY `agency_id_3` (`agency_id`),
  KEY `client_id_3` (`client_id`),
  KEY `agency_id_4` (`agency_id`),
  KEY `client_id_4` (`client_id`),
  CONSTRAINT `client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `projectmanager_id` FOREIGN KEY (`projectmanager_id`) REFERENCES `projectmanagers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `subproject_states`
-- ----------------------------
DROP TABLE IF EXISTS `subproject_states`;
CREATE TABLE `subproject_states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `subprojects`
-- ----------------------------
DROP TABLE IF EXISTS `subprojects`;
CREATE TABLE `subprojects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `phase` enum('request','currentproject','archived') NOT NULL,
  `state_id` int(10) unsigned NOT NULL,
  `probability` enum('0.1','0.5','0.9') NOT NULL,
  `budget` int(10) unsigned NOT NULL,
  `payment_type` enum('time_material','fixed') NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
