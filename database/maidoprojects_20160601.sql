/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50711
 Source Host           : localhost
 Source Database       : maidoprojects

 Target Server Type    : MySQL
 Target Server Version : 50711
 File Encoding         : utf-8

 Date: 06/01/2016 00:05:35 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `_mimoto_entities`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entities`;
CREATE TABLE `_mimoto_entities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `hasdraft` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `extends_id` int(10) unsigned NOT NULL,
  `owner` enum('superuser','admin') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'superuser',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entities`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entities` VALUES ('1', 'client', '0', '0', 'admin', '2016-04-12 07:46:03'), ('2', 'agency', '0', '0', 'admin', '2016-04-12 08:00:54'), ('3', 'projectmanager', '0', '0', 'admin', '2016-04-12 08:01:06'), ('4', 'subprojectstate', '0', '0', 'admin', '2016-04-12 08:01:19'), ('5', 'project', '0', '0', 'admin', '2016-04-12 08:01:30'), ('6', 'subproject', '0', '0', 'admin', '2016-04-13 13:15:25'), ('7', 'contact', '0', '0', 'admin', '2016-04-13 13:18:13'), ('8', 'article', '1', '0', 'admin', '2016-05-29 15:07:46');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entities_properties`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entities_properties`;
CREATE TABLE `_mimoto_entities_properties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(10) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `part_of_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `sortindex` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entities_properties`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entities_properties` VALUES ('1', '1', 'name', '', 'value', '0', '0', '2016-04-12 07:46:46'), ('2', '2', 'name', '', 'value', '0', '0', '2016-04-12 08:02:25'), ('3', '3', 'name', '', 'value', '0', '0', '2016-04-12 08:02:38'), ('4', '4', 'name', '', 'value', '0', '0', '2016-04-12 08:02:52'), ('5', '5', 'name', '', 'value', '0', '0', '2016-04-12 08:03:14'), ('6', '5', 'description', '', 'value', '0', '1', '2016-04-12 08:03:29'), ('7', '5', 'client', '', 'entity', '0', '2', '2016-04-12 08:03:46'), ('8', '5', 'agency', '', 'entity', '0', '3', '2016-04-12 08:04:10'), ('9', '5', 'projectManager', '', 'entity', '0', '4', '2016-04-12 08:04:27'), ('10', '5', 'subprojects', '', 'collection', '0', '5', '2016-04-13 13:14:04'), ('11', '6', 'name', '', 'value', '0', '0', '2016-04-13 13:15:50'), ('12', '6', 'contact', '', 'entity', '0', '1', '2016-04-13 13:16:38'), ('13', '7', 'name', '', 'value', '0', '0', '2016-04-13 13:18:48'), ('14', '7', 'email', '', 'value', '0', '1', '2016-04-13 13:19:27'), ('15', '7', 'phonenumber', '', 'value', '0', '2', '2016-04-13 13:19:56'), ('18', '8', 'title', null, 'value', '0', '0', '2016-05-29 15:08:19'), ('19', '8', 'lede', null, 'value', '0', '2', '2016-05-29 15:08:49'), ('20', '8', 'body', null, 'value', '0', '3', '2016-05-29 15:09:18'), ('21', '8', 'type', null, 'value', '0', '1', '2016-05-29 15:35:07');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entities_properties_options`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entities_properties_options`;
CREATE TABLE `_mimoto_entities_properties_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `value` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entities_properties_options`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entities_properties_options` VALUES ('1', '1', 'type', 'textline', '2016-04-12 07:47:47'), ('2', '2', 'type', 'textline', '2016-04-12 08:05:05'), ('3', '3', 'type', 'textline', '2016-04-12 08:05:19'), ('4', '4', 'type', 'textline', '2016-04-12 08:05:29'), ('5', '5', 'type', 'textline', '2016-04-12 08:05:40'), ('6', '6', 'type', 'textblock', '2016-04-12 08:05:53'), ('7', '7', 'entityType', '1', '2016-04-12 08:06:16'), ('8', '8', 'entityType', '2', '2016-04-12 08:06:41'), ('9', '9', 'entityType', '3', '2016-04-12 08:06:57'), ('10', '10', 'allowedEntityType', '6', '2016-04-13 13:20:24'), ('11', '11', 'type', 'textline', '2016-04-13 13:20:49'), ('12', '12', 'entityType', '7', '2016-04-13 13:21:15'), ('13', '13', 'type', 'textline', '2016-04-13 13:21:33'), ('14', '14', 'type', 'textline', '2016-04-13 13:21:44'), ('15', '15', 'type', 'textline', '2016-04-13 13:21:56'), ('16', '10', 'allowDuplicates', 'true', '2016-04-17 11:59:16'), ('19', '18', 'type', 'textline', '2016-05-29 15:09:46'), ('20', '19', 'type', 'textline', '2016-05-29 15:10:06'), ('21', '20', 'type', 'textblock', '2016-05-29 15:10:22'), ('22', '21', 'type', 'textline', '2016-05-29 15:35:54');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_formconfigs`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_formconfigs`;
CREATE TABLE `_mimoto_formconfigs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `extends_entity_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_mimoto_formconfigs_inputfields`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_formconfigs_inputfields`;
CREATE TABLE `_mimoto_formconfigs_inputfields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `extends_entity_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_mimoto_formconfigs_inputfields_options`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_formconfigs_inputfields_options`;
CREATE TABLE `_mimoto_formconfigs_inputfields_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `extends_entity_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_mimoto_templates`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_templates`;
CREATE TABLE `_mimoto_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `owner` enum('superuser','admin') DEFAULT 'admin',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_mimoto_templates`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_templates` VALUES ('5', 'project_listitem', 'pages/projects/components/Project.twig', 'admin', '2016-05-24 07:44:27'), ('6', 'subproject_listitem', 'pages/projects/components/Subproject.twig', 'admin', '2016-05-24 07:44:51'), ('8', 'article', 'examples/Article.twig', 'admin', '2016-05-25 16:54:30'), ('9', 'feed', 'examples/Feed.twig', 'admin', '2016-05-29 15:57:53'), ('10', 'feeditem', 'examples/FeedItem1.twig', 'admin', '2016-05-29 15:58:21'), ('11', 'article_type', 'examples/ArticleRegular.twig', 'admin', '2016-05-29 16:03:28'), ('12', 'article_type', 'examples/ArticleExplainer.twig', 'admin', '2016-05-29 16:03:56'), ('13', 'feeditem_type', 'examples/FeedItem1.twig', 'admin', '2016-05-29 16:56:41'), ('14', 'feeditem_type', 'examples/FeedItem2.twig', 'admin', '2016-05-29 16:57:07'), ('15', 'article_overview', 'examples/ArticleOverview.twig', 'admin', '2016-05-29 17:20:28'), ('16', 'page_settings', 'pages/SettingsPage.twig', 'admin', '2016-05-29 20:46:35'), ('17', 'page_settings_clients', 'pages/settings/ClientsPage.twig', 'admin', '2016-05-29 20:47:20'), ('18', 'settings_listitem', 'pages/settings/components/ListItemComponent.twig', 'admin', '2016-05-29 20:55:12'), ('19', 'page_settings_agencies', 'pages/settings/AgenciesPage.twig', 'admin', '2016-05-29 21:23:04'), ('20', 'page_settings_projectmanagers', 'pages/settings/ProjectManagersPage.twig', 'admin', '2016-05-29 21:24:27'), ('21', 'page_settings_subprojectstates', 'pages/settings/SubprojectStatesPage.twig', 'admin', '2016-05-29 21:25:10'), ('22', 'page_forecast', 'pages/ForecastPage.twig', 'admin', '2016-05-29 22:01:51'), ('23', 'page_result', 'pages/ResultPage.twig', 'admin', '2016-05-29 22:02:18'), ('24', 'page_projects', 'pages/ProjectsPage.twig', 'admin', '2016-05-29 22:05:17'), ('25', 'page_silent', 'pages/SilentPage.twig', 'admin', '2016-05-29 22:12:52'), ('26', 'project_withsubprojects', 'examples/ProjectWithSubprojects.twig', 'admin', '2016-05-31 21:48:05'), ('27', 'project_withsubprojects_state', 'examples/ProjectWithSubprojectsState.twig', 'admin', '2016-05-31 21:50:11'), ('28', 'project_withsubprojects_filter', 'examples/ProjectWithSubprojectsFilter.twig', 'admin', '2016-05-31 21:53:49'), ('29', 'subproject', 'examples/Subproject.twig', 'admin', '2016-05-31 22:10:10'), ('30', 'subproject_state', 'examples/SubprojectArchived.twig', 'admin', '2016-05-31 22:10:43');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_templates_conditionals`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_templates_conditionals`;
CREATE TABLE `_mimoto_templates_conditionals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `key` varchar(255) CHARACTER SET latin1 NOT NULL,
  `value` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_templates_conditionals`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_templates_conditionals` VALUES ('1', '11', 'type', 'regular', '2016-05-29 16:15:26'), ('2', '12', 'type', 'explainer', '2016-05-29 16:15:38'), ('3', '13', 'type', 'regular', '2016-05-29 16:57:43'), ('4', '14', 'type', 'explainer', '2016-05-29 16:58:00');
COMMIT;

-- ----------------------------
--  Table structure for `agency`
-- ----------------------------
DROP TABLE IF EXISTS `agency`;
CREATE TABLE `agency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `agency`
-- ----------------------------
BEGIN;
INSERT INTO `agency` VALUES ('1', 'Buutvrij', '2016-03-05 17:08:38'), ('2', 'Staat', '2016-03-10 10:57:45');
COMMIT;

-- ----------------------------
--  Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('regular','explainer') COLLATE utf8_unicode_ci DEFAULT 'regular',
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `lede` text COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `article`
-- ----------------------------
BEGIN;
INSERT INTO `article` VALUES ('1', 'regular', 'Article 1', 'The standard Lorem Ipsum passage, used since the 1500s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2016-05-29 15:32:07'), ('2', 'regular', 'Article 2', 'Section 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29 15:32:47'), ('3', 'explainer', 'Article 3', '1914 translation by H. Rackham', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?', '2016-05-29 15:33:22');
COMMIT;

-- ----------------------------
--  Table structure for `client`
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `client`
-- ----------------------------
BEGIN;
INSERT INTO `client` VALUES ('1', 'VanMoof', '2016-02-17 09:57:06'), ('2', 'Bugaboo', '2016-02-22 17:54:20'), ('3', 'KNVB', '2016-02-22 17:54:29'), ('4', 'De Correspondent', '2016-03-04 22:41:00'), ('5', 'Respondens', '2016-03-04 22:41:11');
COMMIT;

-- ----------------------------
--  Table structure for `note`
-- ----------------------------
DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
  `id` int(10) NOT NULL,
  `projectmanager_id` int(10) NOT NULL,
  `note` text CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
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
--  Records of `project`
-- ----------------------------
BEGIN;
INSERT INTO `project` VALUES ('1', 'Bugaboo.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2', '1', '4', '2016-02-17 10:16:24'), ('2', 'VanMoof.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.', '1', '0', '2', '2016-02-27 12:35:53'), ('3', 'Bugaboo GTS', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '4', '2', '3', '2016-03-08 11:40:42');
COMMIT;

-- ----------------------------
--  Table structure for `project_subproject`
-- ----------------------------
DROP TABLE IF EXISTS `project_subproject`;
CREATE TABLE `project_subproject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `child_id` int(10) unsigned NOT NULL,
  `sortindex` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `project_subproject`
-- ----------------------------
BEGIN;
INSERT INTO `project_subproject` VALUES ('1', '3', '1', '0'), ('2', '3', '2', '1');
COMMIT;

-- ----------------------------
--  Table structure for `projectmanager`
-- ----------------------------
DROP TABLE IF EXISTS `projectmanager`;
CREATE TABLE `projectmanager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `projectmanager`
-- ----------------------------
BEGIN;
INSERT INTO `projectmanager` VALUES ('1', 'Ruben', '2016-02-25 13:40:24'), ('2', 'David', '2016-02-27 12:35:03'), ('3', 'Marloes', '2016-02-25 13:40:39'), ('4', 'RenÃ©', '2016-02-25 13:40:27');
COMMIT;

-- ----------------------------
--  Table structure for `subproject`
-- ----------------------------
DROP TABLE IF EXISTS `subproject`;
CREATE TABLE `subproject` (
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
--  Records of `subproject`
-- ----------------------------
BEGIN;
INSERT INTO `subproject` VALUES ('1', '1', 'Specificatiefase', 'Hans van der Vorst', 'request', '1', '0.1', '57850', 'time_material', '2016-02-27 18:02:19'), ('2', '1', 'In-store visuals', 'Hans van der Vorst', 'request', '2', '0.9', '15000', 'fixed', '2016-02-27 18:03:11'), ('3', '1', 'Concept design', 'Hans van der Vorst', 'currentproject', '4', '0.9', '25000', 'time_material', '2016-02-27 18:04:57'), ('4', '2', 'Concept phase', 'Dave Shoemack', 'request', '3', '0.5', '43000', 'time_material', '2016-03-02 14:53:37');
COMMIT;

-- ----------------------------
--  Table structure for `subprojectstate`
-- ----------------------------
DROP TABLE IF EXISTS `subprojectstate`;
CREATE TABLE `subprojectstate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `subprojectstate`
-- ----------------------------
BEGIN;
INSERT INTO `subprojectstate` VALUES ('1', 'Onbehandeld', '2016-02-23 10:03:22'), ('2', 'Wacht op vervolg', '2016-02-23 10:02:02'), ('3', 'Offerte gestuurd', '0000-00-00 00:00:00'), ('4', 'In uitvoering', '0000-00-00 00:00:00'), ('5', 'Vervallen', '0000-00-00 00:00:00'), ('6', 'Afgerond', '0000-00-00 00:00:00');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
