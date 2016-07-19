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

 Date: 07/20/2016 00:51:27 AM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `_mimoto_action`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_action`;
CREATE TABLE `_mimoto_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity` varchar(255) NOT NULL,
  `connectiontable` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `_mimoto_entity`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entity`;
CREATE TABLE `_mimoto_entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `owner` enum('superuser','admin') COLLATE utf8_unicode_ci DEFAULT 'superuser',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entity`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entity` VALUES ('1', 'client', 'admin', '2016-04-12 07:46:03'), ('2', 'agency', 'admin', '2016-04-12 08:00:54'), ('3', 'projectmanager', 'admin', '2016-04-12 08:01:06'), ('4', 'subprojectstate', 'admin', '2016-04-12 08:01:19'), ('5', 'project', 'admin', '2016-04-12 08:01:30'), ('6', 'subproject', 'admin', '2016-04-13 13:15:25'), ('7', 'contact', 'admin', '2016-04-13 13:18:13'), ('8', 'article', 'admin', '2016-05-29 15:07:46'), ('10', 'notification', 'admin', '2016-06-07 09:37:43'), ('11', '_mimoto_entity', 'superuser', '2016-06-13 10:55:59'), ('12', '_mimoto_form', 'superuser', '2016-06-28 15:03:39'), ('13', '_mimoto_entity_property', 'superuser', '2016-07-19 15:32:15');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entity_connections`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entity_connections`;
CREATE TABLE `_mimoto_entity_connections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `parent_property_id` int(10) unsigned DEFAULT NULL,
  `child_entity_type` int(10) unsigned DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entity_connections`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entity_connections` VALUES ('1', '11', '32', '13', '25', '0'), ('2', '11', '32', '13', '28', '1'), ('3', '1', '32', '13', '1', '0'), ('4', '2', '32', '13', '2', '0'), ('5', '3', '32', '13', '3', '0'), ('6', '4', '32', '13', '4', '0'), ('7', '5', '32', '13', '5', '0'), ('8', '5', '32', '13', '6', '1'), ('9', '5', '32', '13', '7', '2'), ('10', '5', '32', '13', '8', '3'), ('11', '5', '32', '13', '9', '4'), ('12', '5', '32', '13', '10', '5'), ('13', '6', '32', '13', '11', '0'), ('14', '6', '32', '13', '12', '1'), ('15', '6', '32', '13', '22', '6'), ('16', '7', '32', '13', '13', '0'), ('17', '7', '32', '13', '14', '1'), ('18', '7', '32', '13', '15', '2'), ('19', '8', '32', '13', '18', '0'), ('20', '8', '32', '13', '21', '1'), ('21', '8', '32', '13', '19', '2'), ('22', '8', '32', '13', '20', '3'), ('23', '11', '32', '13', '32', '2'), ('24', '10', '32', '13', '23', '0'), ('25', '10', '32', '13', '24', '1'), ('26', '12', '32', '13', '29', '0'), ('27', '12', '32', '13', '30', '1'), ('28', '13', '32', '13', '33', '0'), ('29', '13', '32', '13', '34', '1');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entity_property`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entity_property`;
CREATE TABLE `_mimoto_entity_property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entity_property`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entity_property` VALUES ('1', '1', 'name', 'value', '0', '2016-04-12 07:46:46'), ('2', '2', 'name', 'value', '0', '2016-04-12 08:02:25'), ('3', '3', 'name', 'value', '0', '2016-04-12 08:02:38'), ('4', '4', 'name', 'value', '0', '2016-04-12 08:02:52'), ('5', '5', 'name', 'value', '0', '2016-04-12 08:03:14'), ('6', '5', 'description', 'value', '1', '2016-04-12 08:03:29'), ('7', '5', 'client', 'entity', '2', '2016-04-12 08:03:46'), ('8', '5', 'agency', 'entity', '3', '2016-04-12 08:04:10'), ('9', '5', 'projectmanager', 'entity', '4', '2016-04-12 08:04:27'), ('10', '5', 'subprojects', 'collection', '5', '2016-04-13 13:14:04'), ('11', '6', 'name', 'value', '0', '2016-04-13 13:15:50'), ('12', '6', 'contact', 'entity', '1', '2016-04-13 13:16:38'), ('13', '7', 'name', 'value', '0', '2016-04-13 13:18:48'), ('14', '7', 'email', 'value', '1', '2016-04-13 13:19:27'), ('15', '7', 'phonenumber', 'value', '2', '2016-04-13 13:19:56'), ('18', '8', 'title', 'value', '0', '2016-05-29 15:08:19'), ('19', '8', 'lede', 'value', '2', '2016-05-29 15:08:49'), ('20', '8', 'body', 'value', '3', '2016-05-29 15:09:18'), ('21', '8', 'type', 'value', '1', '2016-05-29 15:35:07'), ('22', '6', 'phase', 'value', '2', '2016-06-01 12:51:41'), ('23', '10', 'category', 'value', '0', '2016-06-07 09:38:16'), ('24', '10', 'message', 'value', '1', '2016-06-07 09:38:39'), ('25', '11', 'name', 'value', '0', '2016-06-13 10:56:47'), ('28', '11', 'owner', 'value', '3', '2016-06-13 10:57:14'), ('29', '12', 'name', 'value', '0', '2016-07-17 17:50:21'), ('30', '12', 'description', 'value', '1', '2016-07-17 17:53:06'), ('31', '12', 'fields', 'collection', '2', '2016-07-17 17:53:23'), ('32', '11', 'properties', 'collection', '4', '2016-07-19 15:28:56'), ('33', '13', 'name', 'value', '0', '2016-07-19 15:33:57'), ('34', '13', 'type', 'value', '1', '2016-07-19 15:34:14');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entity_property_settings`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entity_property_settings`;
CREATE TABLE `_mimoto_entity_property_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `value` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entity_property_settings`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entity_property_settings` VALUES ('1', '1', 'type', 'textline', '2016-04-12 07:47:47'), ('2', '2', 'type', 'textline', '2016-04-12 08:05:05'), ('3', '3', 'type', 'textline', '2016-04-12 08:05:19'), ('4', '4', 'type', 'textline', '2016-04-12 08:05:29'), ('5', '5', 'type', 'textline', '2016-04-12 08:05:40'), ('6', '6', 'type', 'textblock', '2016-04-12 08:05:53'), ('7', '7', 'entityType', '1', '2016-04-12 08:06:16'), ('8', '8', 'entityType', '2', '2016-04-12 08:06:41'), ('9', '9', 'entityType', '3', '2016-04-12 08:06:57'), ('10', '10', 'allowedEntityTypes', '[6]', '2016-04-13 13:20:24'), ('11', '11', 'type', 'textline', '2016-04-13 13:20:49'), ('12', '12', 'entityType', '7', '2016-04-13 13:21:15'), ('13', '13', 'type', 'textline', '2016-04-13 13:21:33'), ('14', '14', 'type', 'textline', '2016-04-13 13:21:44'), ('15', '15', 'type', 'textline', '2016-04-13 13:21:56'), ('16', '10', 'allowDuplicates', 'false', '2016-04-17 11:59:16'), ('19', '18', 'type', 'textline', '2016-05-29 15:09:46'), ('20', '19', 'type', 'textline', '2016-05-29 15:10:06'), ('21', '20', 'type', 'textblock', '2016-05-29 15:10:22'), ('22', '21', 'type', 'textline', '2016-05-29 15:35:54'), ('23', '22', 'type', 'textline', '2016-06-01 12:53:45'), ('24', '23', 'type', 'textline', '2016-06-07 09:38:56'), ('25', '24', 'type', 'textline', '2016-06-07 09:39:13'), ('26', '25', 'type', 'textline', '2016-06-13 10:57:33'), ('27', '26', 'type', 'textline', '2016-06-13 10:57:45'), ('28', '27', 'entityType', '11', '2016-06-13 11:00:12'), ('29', '28', 'type', 'textline', '2016-06-13 10:57:55'), ('30', '29', 'type', 'textline', '2016-07-17 17:52:38'), ('31', '30', 'type', 'textline', '2016-07-17 17:54:43'), ('32', '31', 'allowedEntityTypes', '[x]', '2016-07-17 18:28:45'), ('33', '25', 'type', 'textline', '2016-07-19 15:52:32'), ('34', '28', 'type', 'textline', '2016-07-19 15:53:05'), ('35', '32', 'allowedEntityTypes', '[13]', '2016-07-19 15:53:33'), ('36', '33', 'type', 'textline', '2016-07-19 15:56:38'), ('37', '34', 'type', 'textline', '2016-07-19 15:56:48'), ('38', '32', 'allowDuplicates', 'false', '2016-07-19 15:58:45');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form`;
CREATE TABLE `_mimoto_form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form` VALUES ('1', 'client', 'A simple form to add and edit clients', '2016-06-27 14:06:17');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_connections`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_connections`;
CREATE TABLE `_mimoto_form_connections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `parent_property_id` int(10) unsigned DEFAULT NULL,
  `child_entity_type` int(10) unsigned DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_mimoto_templates`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_templates` VALUES ('5', 'project_listitem', 'pages/projects/components/Project.twig', 'admin', '2016-05-24 07:44:27'), ('6', 'subproject_listitem', 'pages/projects/components/Subproject.twig', 'admin', '2016-05-24 07:44:51'), ('8', 'article', 'examples/Article.twig', 'admin', '2016-05-25 16:54:30'), ('9', 'feed', 'examples/Feed.twig', 'admin', '2016-05-29 15:57:53'), ('10', 'feeditem', 'examples/FeedItem1.twig', 'admin', '2016-05-29 15:58:21'), ('11', 'article_type', 'examples/ArticleRegular.twig', 'admin', '2016-05-29 16:03:28'), ('12', 'article_type', 'examples/ArticleExplainer.twig', 'admin', '2016-05-29 16:03:56'), ('13', 'feeditem_type', 'examples/FeedItem1.twig', 'admin', '2016-05-29 16:56:41'), ('14', 'feeditem_type', 'examples/FeedItem2.twig', 'admin', '2016-05-29 16:57:07'), ('15', 'article_overview', 'examples/ArticleOverview.twig', 'admin', '2016-05-29 17:20:28'), ('16', 'page_settings', 'pages/SettingsPage.twig', 'admin', '2016-05-29 20:46:35'), ('17', 'page_settings_clients', 'pages/settings/ClientsPage.twig', 'admin', '2016-05-29 20:47:20'), ('18', 'settings_listitem', 'pages/settings/components/ListItemComponent.twig', 'admin', '2016-05-29 20:55:12'), ('19', 'page_settings_agencies', 'pages/settings/AgenciesPage.twig', 'admin', '2016-05-29 21:23:04'), ('20', 'page_settings_projectmanagers', 'pages/settings/ProjectManagersPage.twig', 'admin', '2016-05-29 21:24:27'), ('21', 'page_settings_subprojectstates', 'pages/settings/SubprojectStatesPage.twig', 'admin', '2016-05-29 21:25:10'), ('22', 'page_forecast', 'pages/ForecastPage.twig', 'admin', '2016-05-29 22:01:51'), ('23', 'page_result', 'pages/ResultPage.twig', 'admin', '2016-05-29 22:02:18'), ('24', 'page_projects', 'pages/ProjectsPage.twig', 'admin', '2016-05-29 22:05:17'), ('25', 'page_silent', 'pages/SilentPage.twig', 'admin', '2016-05-29 22:12:52'), ('26', 'project_withsubprojects', 'examples/ProjectWithSubprojects.twig', 'admin', '2016-05-31 21:48:05'), ('27', 'project_withsubprojects_phase', 'examples/ProjectWithSubprojectsPhase.twig', 'admin', '2016-05-31 21:50:11'), ('28', 'project_withsubprojects_filter', 'examples/ProjectWithSubprojectsFilter.twig', 'admin', '2016-05-31 21:53:49'), ('29', 'subproject', 'examples/Subproject.twig', 'admin', '2016-05-31 22:10:10'), ('30', 'subproject_phase', 'examples/Subproject.twig', 'admin', '2016-05-31 22:10:43'), ('31', 'subproject_phase', 'examples/SubprojectActive.twig', 'admin', '2016-06-01 12:44:08'), ('32', 'subproject_phase', 'examples/SubprojectArchived.twig', 'admin', '2016-06-01 12:45:44'), ('33', 'notificationcenter', 'notificationcenter/NotificationCenter.twig', 'admin', '2016-06-07 09:51:20'), ('34', 'notification', 'notificationcenter/NotificationCenter.twig', 'admin', '2016-06-07 09:53:50'), ('35', 'client_overview', 'examples/ClientOverview.twig', 'admin', '2016-06-11 12:21:52'), ('36', 'client_listitem', 'examples/ListItemComponent.twig', 'admin', '2016-06-11 12:22:54'), ('37', 'entity_overview', 'exampleadmin/EntityOverview.twig', 'admin', '2016-06-13 10:42:03'), ('38', 'entity_listitem', 'exampleadmin/EntityListItem.twig', 'admin', '2016-06-13 10:52:12'), ('39', 'subproject_overview', 'examples/SubprojectOverview.twig', 'admin', '2016-06-13 11:46:46'), ('40', 'subproject_examplelistitem', 'examples/SubprojectListItem.twig', 'admin', '2016-06-13 11:47:15'), ('41', 'form_client', 'forms/ClientForm.twig', 'admin', '2016-06-27 14:38:36'), ('42', 'Mimoto.CMS/dashboard/Overview', 'Mimoto.CMS/pages/dashboard/Overview.twig', 'superuser', '2016-07-19 12:27:17'), ('43', 'Mimoto.CMS/entities/Overview', 'Mimoto.CMS/pages/entities/Overview.twig', 'superuser', '2016-07-19 14:25:22'), ('44', 'Mimoto.CMS/entities/EntityListItem', 'Mimoto.CMS/pages/entities/EntityListItem.twig', 'superuser', '2016-07-19 14:32:35'), ('45', 'Mimoto.CMS/entities/Detail', 'Mimoto.CMS/pages/entities/Detail.twig', 'superuser', '2016-07-19 15:17:30'), ('46', 'Mimoto.CMS/entities/PropertyListItem', 'Mimoto.CMS/pages/entities/PropertyListItem.twig', 'superuser', '2016-07-19 17:12:38');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_templates_conditionals`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_templates_conditionals` VALUES ('1', '11', 'type', 'regular', '2016-05-29 16:15:26'), ('2', '12', 'type', 'explainer', '2016-05-29 16:15:38'), ('3', '13', 'type', 'regular', '2016-05-29 16:57:43'), ('4', '14', 'type', 'explainer', '2016-05-29 16:58:00'), ('6', '30', 'phase', 'request', '2016-06-01 12:44:34'), ('7', '31', 'phase', 'currentproject', '2016-06-01 12:44:51'), ('8', '32', 'phase', 'archived', '2016-06-01 12:45:05');
COMMIT;

-- ----------------------------
--  Table structure for `agency`
-- ----------------------------
DROP TABLE IF EXISTS `agency`;
CREATE TABLE `agency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `lede` text COLLATE utf8_unicode_ci,
  `body` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `article`
-- ----------------------------
BEGIN;
INSERT INTO `article` VALUES ('1', 'explainer', 'Article 1', 'The standard Lorem Ipsum passage, used since the 1500s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2016-05-29 15:32:07'), ('2', 'regular', 'Article 2', 'Section 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29 15:32:47'), ('3', 'explainer', 'Article 3', '1914 translation by H. Rackham', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?', '2016-05-29 15:33:22');
COMMIT;

-- ----------------------------
--  Table structure for `client`
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `client`
-- ----------------------------
BEGIN;
INSERT INTO `client` VALUES ('1', 'VanMoof', '2016-02-17 09:57:06'), ('2', 'Bugaboo', '2016-02-22 17:54:20'), ('3', 'KNVB', '2016-02-22 17:54:29'), ('4', 'De Correspondent', '2016-03-04 22:41:00'), ('5', 'Respondens', '2016-03-04 22:41:11');
COMMIT;

-- ----------------------------
--  Table structure for `contact`
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phonenumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `contact`
-- ----------------------------
BEGIN;
INSERT INTO `contact` VALUES ('1', 'Hans van der Vorst', '', '', '0000-00-00 00:00:00'), ('2', 'Dave Shoemack', '', '', '2016-06-01 12:23:31');
COMMIT;

-- ----------------------------
--  Table structure for `note`
-- ----------------------------
DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `projectmanager_id` int(10) DEFAULT NULL,
  `note` text CHARACTER SET latin1,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `notification`
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `notification`
-- ----------------------------
BEGIN;
INSERT INTO `notification` VALUES ('1', 'templates', 'Template \'client\' missing on page \'client overview\'', '2016-06-07 09:41:46');
COMMIT;

-- ----------------------------
--  Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` text CHARACTER SET latin1,
  `client_id` int(10) unsigned DEFAULT NULL,
  `agency_id` int(10) unsigned DEFAULT NULL,
  `projectmanager_id` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
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
INSERT INTO `project` VALUES ('1', 'Bugaboo.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2', '1', '4', '2016-02-17 10:16:24'), ('2', 'VanMoof.com - 2016:06:26 14.14.10', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.', '1', '0', '3', '2016-02-27 12:35:53'), ('3', 'Bugaboo GTS', 'Al ruim 15 jaar inspireert Bugaboo honderdduizenden ouders om eropuit te trekken en samen met hun kinderen de wereld te ontdekken. Tegenwoordig is het een vertrouwd straatbeeld: overal stoere, robuuste en tegelijk stijlvolle kinderwagens. Maar toen Max Barenbrug, nu Chief Design Officer bij Bugaboo, in 1994 zo\'n kinderwagen ontwierp voor zijn afstudeerproject aan de Design Academy in Eindhoven, was het de eerste in zijn soort. De modulaire, multifunctionele kinderwagen, die net zo makkelijk in de stad als in het bos of op het strand kon worden gebruikt, was destijds een compleet nieuw concept.', '4', '2', '3', '2016-03-08 11:40:42');
COMMIT;

-- ----------------------------
--  Table structure for `project_connections`
-- ----------------------------
DROP TABLE IF EXISTS `project_connections`;
CREATE TABLE `project_connections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `parent_property_id` int(10) unsigned DEFAULT NULL,
  `child_entity_type` int(10) unsigned DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `project_connections`
-- ----------------------------
BEGIN;
INSERT INTO `project_connections` VALUES ('1', '3', '10', '6', '1', '0'), ('2', '3', '10', '6', '2', '1'), ('3', '3', '10', '6', '3', '2'), ('4', '2', '10', '6', '4', '0'), ('164', '2', '10', '6', '5', '2'), ('190', '2', '10', '6', '3', '2'), ('202', '3', '10', '6', '5', '3');
COMMIT;

-- ----------------------------
--  Table structure for `projectmanager`
-- ----------------------------
DROP TABLE IF EXISTS `projectmanager`;
CREATE TABLE `projectmanager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `contact_id` int(10) unsigned DEFAULT NULL,
  `phase` enum('request','currentproject','archived') COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` enum('prospect','active','archived') COLLATE utf8_unicode_ci DEFAULT NULL,
  `probability` enum('0.1','0.5','0.9') COLLATE utf8_unicode_ci DEFAULT NULL,
  `budget` int(10) unsigned DEFAULT NULL,
  `payment_type` enum('time_material','fixed') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `subproject`
-- ----------------------------
BEGIN;
INSERT INTO `subproject` VALUES ('1', 'Specificatiefase', '1', 'request', 'prospect', '0.1', '57850', 'time_material', '2016-02-27 18:02:19'), ('2', 'In-store visuals', '1', 'archived', 'prospect', '0.9', '15000', 'fixed', '2016-02-27 18:03:11'), ('3', 'Concept design', '1', 'currentproject', 'active', '0.9', '25000', 'time_material', '2016-02-27 18:04:57'), ('4', 'Concept phase', '2', 'request', 'archived', '0.5', '43000', 'time_material', '2016-03-02 14:53:37'), ('5', 'Technical realisation', '1', 'request', 'active', '0.1', '60000', 'time_material', '2016-06-01 12:55:01');
COMMIT;

-- ----------------------------
--  Table structure for `subprojectstate`
-- ----------------------------
DROP TABLE IF EXISTS `subprojectstate`;
CREATE TABLE `subprojectstate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `subprojectstate`
-- ----------------------------
BEGIN;
INSERT INTO `subprojectstate` VALUES ('1', 'Onbehandeld', '2016-02-23 10:03:22'), ('2', 'Wacht op vervolg', '2016-02-23 10:02:02'), ('3', 'Offerte gestuurd', '0000-00-00 00:00:00'), ('4', 'In uitvoering', '0000-00-00 00:00:00'), ('5', 'Vervallen', '0000-00-00 00:00:00'), ('6', 'Afgerond', '0000-00-00 00:00:00');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
