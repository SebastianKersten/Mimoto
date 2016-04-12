/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50711
 Source Host           : localhost
 Source Database       : maidoprojects

 Target Server Version : 50711
 File Encoding         : utf-8

 Date: 04/12/2016 18:09:12 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `☻ - mimoto_entityconfigs`
-- ----------------------------
DROP TABLE IF EXISTS `☻ - mimoto_entityconfigs`;
CREATE TABLE `☻ - mimoto_entityconfigs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `extends_entity_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `☻ - mimoto_entityconfigs`
-- ----------------------------
BEGIN;
INSERT INTO `☻ - mimoto_entityconfigs` VALUES ('1', 'client', '0', '2016-04-12 07:46:03'), ('2', 'agency', '0', '2016-04-12 08:00:54'), ('3', 'projectManager', '0', '2016-04-12 08:01:06'), ('4', 'subprojectState', '0', '2016-04-12 08:01:19'), ('5', 'project', '0', '2016-04-12 08:01:30');
COMMIT;

-- ----------------------------
--  Table structure for `☻ - mimoto_entityconfigs_properties`
-- ----------------------------
DROP TABLE IF EXISTS `☻ - mimoto_entityconfigs_properties`;
CREATE TABLE `☻ - mimoto_entityconfigs_properties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(10) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `type` varchar(255) CHARACTER SET latin1 NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `sortindex` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `☻ - mimoto_entityconfigs_properties`
-- ----------------------------
BEGIN;
INSERT INTO `☻ - mimoto_entityconfigs_properties` VALUES ('1', '1', 'name', 'value', '0', '0', '2016-04-12 07:46:46'), ('2', '2', 'name', 'value', '0', '0', '2016-04-12 08:02:25'), ('3', '3', 'name', 'value', '0', '0', '2016-04-12 08:02:38'), ('4', '4', 'name', 'value', '0', '0', '2016-04-12 08:02:52'), ('5', '5', 'name', 'value', '0', '0', '2016-04-12 08:03:14'), ('6', '5', 'description', 'value', '0', '1', '2016-04-12 08:03:29'), ('7', '5', 'client', 'entity', '0', '2', '2016-04-12 08:03:46'), ('8', '5', 'agency', 'entity', '0', '3', '2016-04-12 08:04:10'), ('9', '5', 'projectManager', 'entity', '0', '4', '2016-04-12 08:04:27');
COMMIT;

-- ----------------------------
--  Table structure for `☻ - mimoto_entityconfigs_properties_options`
-- ----------------------------
DROP TABLE IF EXISTS `☻ - mimoto_entityconfigs_properties_options`;
CREATE TABLE `☻ - mimoto_entityconfigs_properties_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned NOT NULL,
  `option` varchar(255) CHARACTER SET latin1 NOT NULL,
  `value` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `☻ - mimoto_entityconfigs_properties_options`
-- ----------------------------
BEGIN;
INSERT INTO `☻ - mimoto_entityconfigs_properties_options` VALUES ('1', '1', 'type', 'textline', '2016-04-12 07:47:47'), ('2', '2', 'type', 'textline', '2016-04-12 08:05:05'), ('3', '3', 'type', 'textline', '2016-04-12 08:05:19'), ('4', '4', 'type', 'textline', '2016-04-12 08:05:29'), ('5', '5', 'type', 'textline', '2016-04-12 08:05:40'), ('6', '6', 'type', 'textblock', '2016-04-12 08:05:53'), ('7', '7', 'entityType', '1', '2016-04-12 08:06:16'), ('8', '8', 'entityType', '2', '2016-04-12 08:06:41'), ('9', '9', 'entityType', '3', '2016-04-12 08:06:57');
COMMIT;

-- ----------------------------
--  Table structure for `☻ - mimoto_formconfigs`
-- ----------------------------
DROP TABLE IF EXISTS `☻ - mimoto_formconfigs`;
CREATE TABLE `☻ - mimoto_formconfigs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `extends_entity_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `☻ - mimoto_formconfigs_inputfields`
-- ----------------------------
DROP TABLE IF EXISTS `☻ - mimoto_formconfigs_inputfields`;
CREATE TABLE `☻ - mimoto_formconfigs_inputfields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `extends_entity_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `☻ - mimoto_formconfigs_inputfields_options`
-- ----------------------------
DROP TABLE IF EXISTS `☻ - mimoto_formconfigs_inputfields_options`;
CREATE TABLE `☻ - mimoto_formconfigs_inputfields_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `extends_entity_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `agencies`
-- ----------------------------
DROP TABLE IF EXISTS `agencies`;
CREATE TABLE `agencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `agencies`
-- ----------------------------
BEGIN;
INSERT INTO `agencies` VALUES ('1', 'Buutvrij', '2016-03-05 17:08:38'), ('2', 'Staat', '2016-03-10 10:57:45');
COMMIT;

-- ----------------------------
--  Table structure for `clients`
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `clients`
-- ----------------------------
BEGIN;
INSERT INTO `clients` VALUES ('1', 'VanMoof', '2016-02-17 09:57:06'), ('2', 'Bugaboo', '2016-02-22 17:54:20'), ('3', 'KNVB', '2016-02-22 17:54:29'), ('4', 'De Correspondent', '2016-03-04 22:41:00'), ('5', 'Respondens', '2016-03-04 22:41:11');
COMMIT;

-- ----------------------------
--  Table structure for `notes`
-- ----------------------------
DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int(10) NOT NULL,
  `projectmanager_id` int(10) NOT NULL,
  `note` text CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `projectmanagers`
-- ----------------------------
DROP TABLE IF EXISTS `projectmanagers`;
CREATE TABLE `projectmanagers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `projectmanagers`
-- ----------------------------
BEGIN;
INSERT INTO `projectmanagers` VALUES ('1', 'Ruben', '2016-02-25 13:40:24'), ('2', 'David', '2016-02-27 12:35:03'), ('3', 'Marloes', '2016-02-25 13:40:39'), ('4', 'RenÃ©', '2016-02-25 13:40:27');
COMMIT;

-- ----------------------------
--  Table structure for `projects`
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
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
  KEY `client_id_4` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `projects`
-- ----------------------------
BEGIN;
INSERT INTO `projects` VALUES ('1', 'Bugaboo.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2', '1', '4', '2016-02-17 10:16:24'), ('2', 'VanMoof.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.', '1', '0', '2', '2016-02-27 12:35:53'), ('3', 'Bugaboo GTS', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '4', '2', '3', '2016-03-08 11:40:42');
COMMIT;

-- ----------------------------
--  Table structure for `projects_subprojects`
-- ----------------------------
DROP TABLE IF EXISTS `projects_subprojects`;
CREATE TABLE `projects_subprojects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `child_id` int(10) unsigned NOT NULL,
  `sortindex` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `projects_subprojects`
-- ----------------------------
BEGIN;
INSERT INTO `projects_subprojects` VALUES ('1', '3', '1', '0'), ('2', '3', '2', '1');
COMMIT;

-- ----------------------------
--  Table structure for `subproject_states`
-- ----------------------------
DROP TABLE IF EXISTS `subproject_states`;
CREATE TABLE `subproject_states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `subproject_states`
-- ----------------------------
BEGIN;
INSERT INTO `subproject_states` VALUES ('1', 'Onbehandeld', '2016-02-23 10:03:22'), ('2', 'Wacht op vervolg', '2016-02-23 10:02:02'), ('3', 'Offerte gestuurd', '0000-00-00 00:00:00'), ('4', 'In uitvoering', '0000-00-00 00:00:00'), ('5', 'Vervallen', '0000-00-00 00:00:00'), ('6', 'Afgerond', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `subprojects`
-- ----------------------------
DROP TABLE IF EXISTS `subprojects`;
CREATE TABLE `subprojects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `contact_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `phase` enum('request','currentproject','archived') CHARACTER SET latin1 NOT NULL,
  `state_id` int(10) unsigned NOT NULL,
  `probability` enum('0.1','0.5','0.9') CHARACTER SET latin1 NOT NULL,
  `budget` int(10) unsigned NOT NULL,
  `payment_type` enum('time_material','fixed') CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `subprojects`
-- ----------------------------
BEGIN;
INSERT INTO `subprojects` VALUES ('1', '1', 'Specificatiefase', 'Hans van der Vorst', 'request', '1', '0.1', '57850', 'time_material', '2016-02-27 18:02:19'), ('2', '1', 'In-store visuals', 'Hans van der Vorst', 'request', '2', '0.9', '15000', 'fixed', '2016-02-27 18:03:11'), ('3', '1', 'Concept design', 'Hans van der Vorst', 'currentproject', '4', '0.9', '25000', 'time_material', '2016-02-27 18:04:57'), ('4', '2', 'Concept phase', 'Dave Shoemack', 'request', '3', '0.5', '43000', 'time_material', '2016-03-02 14:53:37');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
