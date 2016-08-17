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

 Date: 08/17/2016 12:06:36 PM
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
--  Table structure for `_mimoto_component`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_component`;
CREATE TABLE `_mimoto_component` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_mimoto_component`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_component` VALUES ('5', 'project_listitem', 'pages/projects/components/Project.twig', '2016-05-24 07:44:27'), ('6', 'subproject_listitem', 'pages/projects/components/Subproject.twig', '2016-05-24 07:44:51'), ('8', 'article', 'examples/Article.twig', '2016-05-25 16:54:30'), ('9', 'feed', 'examples/Feed.twig', '2016-05-29 15:57:53'), ('10', 'feeditem', 'examples/FeedItem1.twig', '2016-05-29 15:58:21'), ('11', 'article_type', 'examples/ArticleRegular.twig', '2016-05-29 16:03:28'), ('12', 'article_type', 'examples/ArticleExplainer.twig', '2016-05-29 16:03:56'), ('13', 'feeditem_type', 'examples/FeedItem1.twig', '2016-05-29 16:56:41'), ('14', 'feeditem_type', 'examples/FeedItem2.twig', '2016-05-29 16:57:07'), ('15', 'article_overview', 'examples/ArticleOverview.twig', '2016-05-29 17:20:28'), ('16', 'page_settings', 'pages/SettingsPage.twig', '2016-05-29 20:46:35'), ('17', 'page_settings_clients', 'pages/settings/ClientsPage.twig', '2016-05-29 20:47:20'), ('18', 'settings_listitem', 'pages/settings/components/ListItemComponent.twig', '2016-05-29 20:55:12'), ('19', 'page_settings_agencies', 'pages/settings/AgenciesPage.twig', '2016-05-29 21:23:04'), ('20', 'page_settings_projectmanagers', 'pages/settings/ProjectManagersPage.twig', '2016-05-29 21:24:27'), ('21', 'page_settings_subprojectstates', 'pages/settings/SubprojectStatesPage.twig', '2016-05-29 21:25:10'), ('22', 'page_forecast', 'pages/ForecastPage.twig', '2016-05-29 22:01:51'), ('23', 'page_result', 'pages/ResultPage.twig', '2016-05-29 22:02:18'), ('24', 'page_projects', 'pages/ProjectsPage.twig', '2016-05-29 22:05:17'), ('25', 'page_silent', 'pages/SilentPage.twig', '2016-05-29 22:12:52'), ('26', 'project_withsubprojects', 'examples/ProjectWithSubprojects.twig', '2016-05-31 21:48:05'), ('27', 'project_withsubprojects_phase', 'examples/ProjectWithSubprojectsPhase.twig', '2016-05-31 21:50:11'), ('28', 'project_withsubprojects_filter', 'examples/ProjectWithSubprojectsFilter.twig', '2016-05-31 21:53:49'), ('29', 'subproject', 'examples/Subproject.twig', '2016-05-31 22:10:10'), ('30', 'subproject_phase', 'examples/Subproject.twig', '2016-05-31 22:10:43'), ('31', 'subproject_phase', 'examples/SubprojectActive.twig', '2016-06-01 12:44:08'), ('32', 'subproject_phase', 'examples/SubprojectArchived.twig', '2016-06-01 12:45:44'), ('33', 'notificationcenter', 'notificationcenter/NotificationCenter.twig', '2016-06-07 09:51:20'), ('34', 'notification', 'notificationcenter/NotificationCenter.twig', '2016-06-07 09:53:50'), ('35', 'client_overview', 'examples/ClientOverview.twig', '2016-06-11 12:21:52'), ('36', 'client_listitem', 'examples/ListItemComponent.twig', '2016-06-11 12:22:54'), ('37', 'entity_overview', 'exampleadmin/EntityOverview.twig', '2016-06-13 10:42:03'), ('38', 'entity_listitem', 'exampleadmin/EntityListItem.twig', '2016-06-13 10:52:12'), ('39', 'subproject_overview', 'examples/SubprojectOverview.twig', '2016-06-13 11:46:46'), ('40', 'subproject_examplelistitem', 'examples/SubprojectListItem.twig', '2016-06-13 11:47:15'), ('41', 'form_client', 'forms/ClientForm.twig', '2016-06-27 14:38:36'), ('42', 'Mimoto.CMS_dashboard_Overview', 'Mimoto.CMS/pages/dashboard/Overview.twig', '2016-07-19 12:27:17'), ('43', 'Mimoto.CMS_entities_EntityOverview', 'Mimoto.CMS/pages/entities/EntityOverview/EntityOverview.twig', '2016-07-19 14:25:22'), ('44', 'Mimoto.CMS_entities_EntityListItem', 'Mimoto.CMS/pages/entities/EntityListItem/EntityListItem.twig', '2016-07-19 14:32:35'), ('45', 'Mimoto.CMS_entities_EntityDetail', 'Mimoto.CMS/pages/entities/EntityDetail/EntityDetail.twig', '2016-07-19 15:17:30'), ('46', 'Mimoto.CMS_entities_PropertyListItem', 'Mimoto.CMS/pages/entities/PropertyListItem/PropertyListItem.twig', '2016-07-19 17:12:38'), ('47', 'Mimoto.CMS_entities_FormEntity', 'Mimoto.CMS/pages/entities/FormEntity.twig', '2016-07-27 13:00:43'), ('48', 'Mimoto.CMS_entities_FormEntityProperty', 'Mimoto.CMS/pages/entities/FormEntityProperty.twig', '2016-07-27 16:40:35'), ('50', 'Mimoto.CMS_general_form_component', 'Mimoto.CMS/forms/form.twig', '2016-08-04 14:22:00'), ('51', '_mimoto_form_output_title', 'Mimoto.CMS/forms/output/Title/Title.twig', '2016-08-10 16:29:20'), ('52', '_mimoto_form_layout_groupstart', 'Mimoto.CMS/forms/layout/GroupStart/GroupStart.twig', '2016-08-10 17:37:30'), ('53', '_mimoto_form_layout_groupend', 'Mimoto.CMS/forms/layout/GroupEnd/GroupEnd.twig', '2016-08-10 17:37:46'), ('54', '_mimoto_form_input_textline', 'Mimoto.CMS/forms/input/Textline/Textline.twig', '2016-08-12 10:07:33'), ('55', '_mimoto_form_input_checkbox', 'Mimoto.CMS/forms/input/Checkbox/Checkbox.twig', '2016-08-15 14:55:03'), ('56', '_mimoto_form_input_radiobutton', 'Mimoto.CMS/forms/input/Radiobutton/Radiobutton.twig', '2016-08-15 14:55:26'), ('57', '_mimoto_form_input_dropdown', 'Mimoto.CMS/forms/input/Dropdown/Dropdown.twig', '2016-08-15 15:00:10'), ('58', '_mimoto_form_layout_divider', 'Mimoto.CMS/forms/layout/Divider/Divider.twig', '2016-08-15 18:16:16');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_componentconditional`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_componentconditional`;
CREATE TABLE `_mimoto_componentconditional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `key` varchar(255) CHARACTER SET latin1 NOT NULL,
  `value` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_componentconditional`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_componentconditional` VALUES ('1', '11', 'type', 'regular', '2016-05-29 16:15:26'), ('2', '12', 'type', 'explainer', '2016-05-29 16:15:38'), ('3', '13', 'type', 'regular', '2016-05-29 16:57:43'), ('4', '14', 'type', 'explainer', '2016-05-29 16:58:00'), ('6', '30', 'phase', 'request', '2016-06-01 12:44:34'), ('7', '31', 'phase', 'currentproject', '2016-06-01 12:44:51'), ('8', '32', 'phase', 'archived', '2016-06-01 12:45:05');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entity`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entity`;
CREATE TABLE `_mimoto_entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_mimoto_entity`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entity` VALUES ('1', 'person', '', '2016-07-29 14:13:46'), ('2', 'article', null, '2016-08-17 11:16:09');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entity_connections`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entity_connections`;
CREATE TABLE `_mimoto_entity_connections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `parent_property_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entity_connections`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entity_connections` VALUES ('1', '1', 'epid2', 'eid2', '1', '0'), ('2', '1', 'epid2', 'eid2', '2', '1'), ('3', '2', 'epid2', 'eid2', '3', '0'), ('4', '2', 'epid2', 'eid2', '4', '1'), ('5', '2', 'epid2', 'eid2', '5', '2'), ('6', '2', 'epid2', 'eid2', '6', '3');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entityproperty`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entityproperty`;
CREATE TABLE `_mimoto_entityproperty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` enum('value','entity','collection') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entityproperty`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entityproperty` VALUES ('1', 'name', 'value', '2016-07-27 12:24:53'), ('2', 'role', 'value', '2016-07-27 16:45:01'), ('3', 'type', 'value', '2016-08-17 11:16:38'), ('4', 'title', 'value', '2016-08-17 11:16:49'), ('5', 'lede', 'value', '2016-08-17 11:16:57'), ('6', 'body', 'value', '2016-08-17 11:17:09');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entityproperty_connections`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entityproperty_connections`;
CREATE TABLE `_mimoto_entityproperty_connections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `parent_property_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entityproperty_connections`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entityproperty_connections` VALUES ('1', '1', 'epid2', 'eid2', '1', '0'), ('2', '2', 'epid2', 'eid2', '2', '1'), ('3', '3', 'epid2', 'eid2', '3', '0'), ('4', '4', 'epid2', 'eid2', '4', '1'), ('5', '5', 'epid2', 'eid2', '5', '2'), ('6', '6', 'epid2', 'eid2', '6', '3');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_entitypropertysetting`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_entitypropertysetting`;
CREATE TABLE `_mimoto_entitypropertysetting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_entitypropertysetting`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_entitypropertysetting` VALUES ('1', 'type', 'value', 'textline', '2016-08-10 13:54:51'), ('2', 'type', 'value', 'textline', '2016-08-10 13:55:02'), ('3', 'type', 'value', 'textline', '2016-08-17 11:18:40'), ('4', 'type', 'value', 'textline', '2016-08-17 11:18:51'), ('5', 'type', 'value', 'textblock', '2016-08-17 11:19:32'), ('6', 'type', 'value', 'textbloxk', '2016-08-17 11:19:41');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form` VALUES ('1', 'client', 'A simple form to add and edit clients', '2016-06-27 14:06:17'), ('2', 'form_person', 'Test', '2016-08-10 14:29:42');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_connections`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_connections`;
CREATE TABLE `_mimoto_form_connections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `parent_property_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form_connections`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form_connections` VALUES ('1', '2', 'epid_fields', 'eid100', '1', '0'), ('2', '2', 'epid_fields', 'eid101', '1', '1'), ('3', '2', 'epid_fields', 'eid200', '1', '2'), ('4', '2', 'epid_fields', 'eid103', '1', '3'), ('5', '2', 'epid_fields', 'eid200', '2', '4'), ('6', '2', 'epid_fields', 'eid201', '1', '5'), ('7', '2', 'epid_fields', 'eid102', '1', '6');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_input_checkbox`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_input_checkbox`;
CREATE TABLE `_mimoto_form_input_checkbox` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form_input_checkbox`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form_input_checkbox` VALUES ('1', 'State', 'Person is currently active on the project', '2016-08-15 13:47:47');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_input_dropdown`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_input_dropdown`;
CREATE TABLE `_mimoto_form_input_dropdown` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `options` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form_input_dropdown`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form_input_dropdown` VALUES ('1', 'Number of hours', '[\"0-2\", \"0 - 2 hours per day\", \"2-4\", \"2 - 4 hours a day\", \"4-8\", \"4-8 hours a day\"]', '2016-08-15 13:49:42');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_input_radiobutton`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_input_radiobutton`;
CREATE TABLE `_mimoto_form_input_radiobutton` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `options` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form_input_radiobutton`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form_input_radiobutton` VALUES ('1', 'Number of hours', '[\"0-2\", \"0 - 2 hours per day\", \"2-4\", \"2 - 4 hours a day\", \"4-8\", \"4-8 hours a day\"]', '2016-08-15 13:49:42');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_input_textline`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_input_textline`;
CREATE TABLE `_mimoto_form_input_textline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `regexp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxchars` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form_input_textline`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form_input_textline` VALUES ('1', 'Name', '/[a-zA-Z09-]/', '10', '2016-08-10 16:13:50'), ('2', 'Role', null, null, '2016-08-12 10:24:05');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_layout_divider`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_layout_divider`;
CREATE TABLE `_mimoto_form_layout_divider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form_layout_divider`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form_layout_divider` VALUES ('1', '2016-08-17 10:40:01');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_layout_groupend`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_layout_groupend`;
CREATE TABLE `_mimoto_form_layout_groupend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form_layout_groupend`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form_layout_groupend` VALUES ('1', '2016-08-04 08:38:28');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_layout_groupstart`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_layout_groupstart`;
CREATE TABLE `_mimoto_form_layout_groupstart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form_layout_groupstart`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form_layout_groupstart` VALUES ('1', 'First group', '2016-08-04 08:38:28');
COMMIT;

-- ----------------------------
--  Table structure for `_mimoto_form_output_title`
-- ----------------------------
DROP TABLE IF EXISTS `_mimoto_form_output_title`;
CREATE TABLE `_mimoto_form_output_title` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_mimoto_form_output_title`
-- ----------------------------
BEGIN;
INSERT INTO `_mimoto_form_output_title` VALUES ('1', 'Hello', 'First output field', 'This is the first output field connected to a genuine form config as port of the Mimoto FormGenerator. Yay!', '2016-08-04 08:38:28'), ('2', 'And welcome', 'Second output field', 'This is the description of the second output field that was connected to this first example form.', '2016-08-10 16:44:36');
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
--  Table structure for `person`
-- ----------------------------
DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `person`
-- ----------------------------
BEGIN;
INSERT INTO `person` VALUES ('1', 'Sebastian', 'Developer', '2016-08-10 13:54:04'), ('2', 'Bart', 'Developer', '2016-08-10 14:04:01'), ('3', 'Alexander', 'DevOps', '2016-08-10 14:04:20');
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
