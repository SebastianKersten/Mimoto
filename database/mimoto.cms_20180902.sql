/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50720
 Source Host           : localhost:3306
 Source Schema         : mimoto.cms

 Target Server Type    : MySQL
 Target Server Version : 50720
 File Encoding         : 65001

 Date: 02/09/2018 10:23:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for _MimotoComponent_displaycomponentG
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoComponent_displaycomponentG`;
CREATE TABLE `_MimotoComponent_displaycomponentG` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _MimotoComponent_element
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoComponent_element`;
CREATE TABLE `_MimotoComponent_element` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _MimotoComponent_page
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoComponent_page`;
CREATE TABLE `_MimotoComponent_page` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_action
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_action`;
CREATE TABLE `_Mimoto_action` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `async` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_action
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_action` VALUES (108, '2017-11-28 13:27:06', NULL, 'Send Slack message when title changes', 'updated', '1');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_action_conditional
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_action_conditional`;
CREATE TABLE `_Mimoto_action_conditional` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(255) DEFAULT NULL,
  `value1` varchar(255) DEFAULT NULL,
  `value2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_action_conditional
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_action_conditional` VALUES (43, '2017-11-26 15:41:05', NULL, 'changedInto', NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (44, '2017-11-26 15:49:31', NULL, 'notEquals', 'hallo', NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (45, '2017-11-26 15:53:59', NULL, 'didNotChange', NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (46, '2017-11-26 16:56:09', NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (47, '2017-11-26 16:57:25', NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (48, '2017-11-26 17:05:16', NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (49, '2017-11-26 17:08:24', NULL, 'changedFrom', NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (50, '2017-11-26 17:09:17', NULL, 'changedFromInto', 'test1', 'test2');
INSERT INTO `_Mimoto_action_conditional` VALUES (52, '2017-11-26 17:47:34', NULL, 'changedInto', '...', NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (53, '2017-11-26 23:16:00', NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (54, '2017-11-26 23:16:05', NULL, 'contains', '\\040sh\\040it\\040', NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (55, '2017-11-27 01:32:35', NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (56, '2017-11-27 11:48:48', NULL, 'changedInto', 'xxx', NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (57, '2017-11-27 11:55:03', NULL, 'contains', '\\040shit\\040', NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (58, '2017-11-27 12:12:57', NULL, 'changedInto', 'xxx', NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (59, '2017-11-27 13:00:50', NULL, 'changedFromInto', 'xxx', 'yyy');
INSERT INTO `_Mimoto_action_conditional` VALUES (60, '2017-11-27 18:40:34', NULL, 'contains', '\\040shit\\040', NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (61, '2017-11-27 18:48:28', NULL, 'changedFromInto', NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (62, '2017-11-28 13:27:25', NULL, 'contains', '\\040shit\\040', NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (63, '2017-11-28 13:39:02', NULL, 'changed', NULL, NULL);
INSERT INTO `_Mimoto_action_conditional` VALUES (64, '2017-11-29 12:25:38', NULL, 'changed', 'xxxdfsdfsfdsfsdf', 'yyyfdsdfsdfsfsdfsdf');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_action_setting
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_action_setting`;
CREATE TABLE `_Mimoto_action_setting` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_action_setting
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_action_setting` VALUES (3, '2017-11-25 18:00:01', NULL, 'channel', 'mimoto_notifications');
INSERT INTO `_Mimoto_action_setting` VALUES (8, '2017-11-26 15:49:51', NULL, 'channel', 'mimoto_notifications');
INSERT INTO `_Mimoto_action_setting` VALUES (9, '2017-11-26 15:50:08', NULL, 'message', 'Hallo from `{{title}}`');
INSERT INTO `_Mimoto_action_setting` VALUES (10, '2017-11-26 17:48:17', NULL, 'channel', 'mimoto_notifications');
INSERT INTO `_Mimoto_action_setting` VALUES (11, '2017-11-26 17:48:57', NULL, 'message', 'This is an easter egg triggered by the article with title = ```{{title}}```');
INSERT INTO `_Mimoto_action_setting` VALUES (12, '2017-11-27 11:49:11', NULL, 'channel', 'mimoto_notifications');
INSERT INTO `_Mimoto_action_setting` VALUES (13, '2017-11-27 11:49:25', NULL, 'message', 'New title is {{title}}');
INSERT INTO `_Mimoto_action_setting` VALUES (14, '2017-11-27 11:55:33', NULL, 'channel', 'mimoto_notifications');
INSERT INTO `_Mimoto_action_setting` VALUES (15, '2017-11-27 11:55:54', NULL, 'message', 'Artikel title veranderd in {{title}}');
INSERT INTO `_Mimoto_action_setting` VALUES (16, '2017-11-27 12:13:18', NULL, 'channel', 'mimoto_notifications');
INSERT INTO `_Mimoto_action_setting` VALUES (17, '2017-11-27 12:13:33', NULL, 'message', 'Artikel aangepast in {{title}}');
INSERT INTO `_Mimoto_action_setting` VALUES (18, '2017-11-27 13:01:40', NULL, 'channel', 'mimoto_notifications');
INSERT INTO `_Mimoto_action_setting` VALUES (19, '2017-11-27 13:01:59', NULL, 'message', 'Title is aangepast in ```{{title}}```');
INSERT INTO `_Mimoto_action_setting` VALUES (20, '2017-11-27 18:41:23', NULL, 'channel', 'mimoto_notifications');
INSERT INTO `_Mimoto_action_setting` VALUES (21, '2017-11-27 18:42:51', NULL, 'message', 'Artikel `{{title}}` is aangepast');
INSERT INTO `_Mimoto_action_setting` VALUES (22, '2017-11-28 13:28:08', NULL, 'channel', 'mimoto_notifications');
INSERT INTO `_Mimoto_action_setting` VALUES (23, '2017-11-28 13:28:41', NULL, 'message', 'Article with title = ```{{title}}``` changed! ```{{lede}}```');
INSERT INTO `_Mimoto_action_setting` VALUES (24, '2018-09-01 15:44:27', NULL, 'bla', '{{nId}}');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_api
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_api`;
CREATE TABLE `_Mimoto_api` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_api
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_api` VALUES (2, '2018-08-27 16:37:02', NULL, 'Highlight comment');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_component
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component`;
CREATE TABLE `_Mimoto_component` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_component
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component` VALUES (1, '2017-09-20 18:39:56', NULL, 'Article', 'layout');
INSERT INTO `_Mimoto_component` VALUES (2, '2017-09-20 18:40:21', NULL, 'Feed', 'layout');
INSERT INTO `_Mimoto_component` VALUES (3, '2017-09-20 18:58:27', NULL, 'FeedItem', 'component');
INSERT INTO `_Mimoto_component` VALUES (4, '2017-09-20 19:06:26', NULL, 'Conversation', 'component');
INSERT INTO `_Mimoto_component` VALUES (5, '2017-09-20 19:06:34', NULL, 'Comment', 'component');
INSERT INTO `_Mimoto_component` VALUES (6, '2017-11-20 13:58:44', NULL, 'displaycomponentG', 'component');
INSERT INTO `_Mimoto_component` VALUES (7, '2018-03-05 16:46:40', NULL, 'element', 'component');
INSERT INTO `_Mimoto_component` VALUES (8, '2018-03-06 13:04:11', NULL, 'page', 'component');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_component_conditional
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component_conditional`;
CREATE TABLE `_Mimoto_component_conditional` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_component_conditional
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component_conditional` VALUES (1, '2018-03-05 16:52:13', NULL, 'entityType', NULL);
INSERT INTO `_Mimoto_component_conditional` VALUES (2, '2018-03-05 16:52:28', NULL, 'entityType', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_component_container
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component_container`;
CREATE TABLE `_Mimoto_component_container` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_component_container
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component_container` VALUES (1, '2017-09-20 18:40:37', NULL, 'feed');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_component_template
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component_template`;
CREATE TABLE `_Mimoto_component_template` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `file` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_component_template
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component_template` VALUES (1, '2017-09-20 18:39:59', NULL, 'publisher/Article/Article.twig');
INSERT INTO `_Mimoto_component_template` VALUES (2, '2017-09-20 18:40:24', NULL, 'publisher/Feed/Feed.twig');
INSERT INTO `_Mimoto_component_template` VALUES (3, '2017-09-20 18:58:34', NULL, 'publisher/FeedItem/FeedItem.twig');
INSERT INTO `_Mimoto_component_template` VALUES (4, '2017-09-20 19:06:36', NULL, 'publisher/Conversation/Conversation.twig');
INSERT INTO `_Mimoto_component_template` VALUES (5, '2017-09-20 19:06:53', NULL, 'publisher/Conversation/Message/Message.twig');
INSERT INTO `_Mimoto_component_template` VALUES (6, '2018-03-05 16:49:52', NULL, 'publisher/Element1/Element1.twig');
INSERT INTO `_Mimoto_component_template` VALUES (7, '2018-03-05 16:52:27', NULL, 'publisher/Element2/Element2.twig');
INSERT INTO `_Mimoto_component_template` VALUES (8, '2018-03-06 13:04:30', NULL, 'publisher/Page/Page.twig');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_connection
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_connection`;
CREATE TABLE `_Mimoto_connection` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `parent_entity_type_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_property_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_entity_type_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE,
  KEY `parent_entity_type_id` (`parent_entity_type_id`),
  KEY `parent_property_id` (`parent_property_id`),
  KEY `child_entity_type_id` (`child_entity_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2489 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_connection
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_connection` VALUES (3, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--users', '_Mimoto_user', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (15, NULL, NULL, '_Mimoto_user', '1', '_Mimoto_user--avatar', '_Mimoto_file', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (16, NULL, NULL, '_Mimoto_user', '1', '_Mimoto_user--roles', '_Mimoto_user_role', '_Mimoto_user_role-contenteditor', 1);
INSERT INTO `_Mimoto_connection` VALUES (20, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--userRoles', '_Mimoto_user_role', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (21, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (22, NULL, NULL, '_Mimoto_component', '1', '_Mimoto_component--templates', '_Mimoto_component_template', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (23, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (24, NULL, NULL, '_Mimoto_component', '2', '_Mimoto_component--templates', '_Mimoto_component_template', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (25, NULL, NULL, '_Mimoto_component', '2', '_Mimoto_component--containers', '_Mimoto_component_container', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (26, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (27, NULL, NULL, '_Mimoto_entityproperty', '1', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (28, NULL, NULL, '_Mimoto_entityproperty', '1', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (29, NULL, NULL, '_Mimoto_entityproperty', '1', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (30, NULL, NULL, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (31, NULL, NULL, '_Mimoto_entityproperty', '2', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (32, NULL, NULL, '_Mimoto_entityproperty', '2', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '5', 1);
INSERT INTO `_Mimoto_connection` VALUES (33, NULL, NULL, '_Mimoto_entityproperty', '2', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '6', 2);
INSERT INTO `_Mimoto_connection` VALUES (34, NULL, NULL, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '2', 2);
INSERT INTO `_Mimoto_connection` VALUES (35, NULL, NULL, '_Mimoto_entitypropertysetting', '7', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', 0);
INSERT INTO `_Mimoto_connection` VALUES (36, NULL, NULL, '_Mimoto_entityproperty', '3', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (37, NULL, NULL, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '3', 3);
INSERT INTO `_Mimoto_connection` VALUES (38, NULL, NULL, '_Mimoto_entityproperty', '4', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (39, NULL, NULL, '_Mimoto_entityproperty', '4', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '9', 1);
INSERT INTO `_Mimoto_connection` VALUES (40, NULL, NULL, '_Mimoto_entityproperty', '4', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '10', 2);
INSERT INTO `_Mimoto_connection` VALUES (41, NULL, NULL, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '4', 4);
INSERT INTO `_Mimoto_connection` VALUES (46, NULL, NULL, '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-bold', 0);
INSERT INTO `_Mimoto_connection` VALUES (47, NULL, NULL, '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-italic', 1);
INSERT INTO `_Mimoto_connection` VALUES (48, NULL, NULL, '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-underline', 2);
INSERT INTO `_Mimoto_connection` VALUES (49, NULL, NULL, '_Mimoto_entityproperty', '6', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '14', 0);
INSERT INTO `_Mimoto_connection` VALUES (50, NULL, NULL, '_Mimoto_entityproperty', '6', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '15', 1);
INSERT INTO `_Mimoto_connection` VALUES (51, NULL, NULL, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '6', 5);
INSERT INTO `_Mimoto_connection` VALUES (67, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (68, NULL, NULL, '_Mimoto_dataset', '1', '_Mimoto_dataset--data', '1', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (69, NULL, NULL, '1', '1', '3', '_Mimoto_file', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (113, NULL, NULL, '_Mimoto_form_input_textline', '10', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (115, NULL, NULL, '_Mimoto_form_input_textblock', '8', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (116, NULL, NULL, '_Mimoto_form_input_image', '5', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (117, NULL, NULL, '_Mimoto_form_input_textblock', '9', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (118, NULL, NULL, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_output_title', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (119, NULL, NULL, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '5', 1);
INSERT INTO `_Mimoto_connection` VALUES (120, NULL, NULL, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '10', 2);
INSERT INTO `_Mimoto_connection` VALUES (122, NULL, NULL, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '8', 4);
INSERT INTO `_Mimoto_connection` VALUES (123, NULL, NULL, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_image', '5', 5);
INSERT INTO `_Mimoto_connection` VALUES (124, NULL, NULL, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '9', 6);
INSERT INTO `_Mimoto_connection` VALUES (125, NULL, NULL, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '5', 7);
INSERT INTO `_Mimoto_connection` VALUES (126, NULL, NULL, '_Mimoto_entity', '1', '_Mimoto_entity--forms', '_Mimoto_form', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (127, NULL, NULL, '_Mimoto_dataset', '1', '_Mimoto_dataset--form', '_Mimoto_form', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (134, NULL, NULL, '_Mimoto_output', '1', '_Mimoto_entity--component', '_Mimoto_component', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (135, NULL, '2018-03-15 19:17:29', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '1', 1);
INSERT INTO `_Mimoto_connection` VALUES (136, NULL, NULL, '_Mimoto_selection', '1', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (143, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (144, NULL, NULL, '_Mimoto_component', '3', '_Mimoto_component--templates', '_Mimoto_component_template', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (148, NULL, '2018-08-27 15:13:37', '_Mimoto_page', '2', '_Mimoto_page--path', '_Mimoto_path_element', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (149, NULL, '2018-08-27 15:13:38', '_Mimoto_page', '2', '_Mimoto_page--path', '_Mimoto_path_element', '3', 1);
INSERT INTO `_Mimoto_connection` VALUES (150, NULL, '2018-08-27 15:13:38', '_Mimoto_page', '2', '_Mimoto_page--path', '_Mimoto_path_element', '4', 2);
INSERT INTO `_Mimoto_connection` VALUES (151, NULL, '2018-08-27 15:13:39', '_Mimoto_page', '2', '_Mimoto_page--path', '_Mimoto_path_element', '5', 3);
INSERT INTO `_Mimoto_connection` VALUES (152, NULL, '2018-08-27 15:13:39', '_Mimoto_page', '2', '_Mimoto_page--path', '_Mimoto_path_element', '6', 4);
INSERT INTO `_Mimoto_connection` VALUES (153, NULL, '2018-08-27 15:13:31', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--pages', '_Mimoto_page', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (154, NULL, '2018-08-27 15:12:12', '_Mimoto_page', '2', '_Mimoto_page--output', '_Mimoto_output', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (155, NULL, NULL, '_Mimoto_output', '2', '_Mimoto_entity--component', '_Mimoto_component', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (161, NULL, NULL, '_Mimoto_user', '1', '_Mimoto_user--roles', '_Mimoto_user_role', '1', 2);
INSERT INTO `_Mimoto_connection` VALUES (163, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '4', 3);
INSERT INTO `_Mimoto_connection` VALUES (164, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (165, NULL, NULL, '_Mimoto_component', '4', '_Mimoto_component--templates', '_Mimoto_component_template', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (166, NULL, NULL, '_Mimoto_component', '5', '_Mimoto_component--templates', '_Mimoto_component_template', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (167, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (168, NULL, NULL, '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '16', 0);
INSERT INTO `_Mimoto_connection` VALUES (169, NULL, NULL, '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '17', 1);
INSERT INTO `_Mimoto_connection` VALUES (170, NULL, NULL, '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '18', 2);
INSERT INTO `_Mimoto_connection` VALUES (171, NULL, NULL, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (172, NULL, NULL, '_Mimoto_entityproperty', '8', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '19', 0);
INSERT INTO `_Mimoto_connection` VALUES (173, NULL, NULL, '_Mimoto_entityproperty', '8', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '20', 1);
INSERT INTO `_Mimoto_connection` VALUES (174, NULL, NULL, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '8', 1);
INSERT INTO `_Mimoto_connection` VALUES (190, NULL, NULL, '_Mimoto_entityproperty', '10', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '24', 0);
INSERT INTO `_Mimoto_connection` VALUES (191, NULL, NULL, '_Mimoto_entityproperty', '10', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '25', 1);
INSERT INTO `_Mimoto_connection` VALUES (192, NULL, NULL, '_Mimoto_entityproperty', '10', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '26', 2);
INSERT INTO `_Mimoto_connection` VALUES (194, NULL, NULL, '_Mimoto_entityproperty', '11', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '27', 0);
INSERT INTO `_Mimoto_connection` VALUES (195, NULL, NULL, '_Mimoto_entityproperty', '11', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '28', 1);
INSERT INTO `_Mimoto_connection` VALUES (196, NULL, NULL, '_Mimoto_entityproperty', '11', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '29', 2);
INSERT INTO `_Mimoto_connection` VALUES (198, NULL, NULL, '_Mimoto_entityproperty', '12', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '30', 0);
INSERT INTO `_Mimoto_connection` VALUES (199, NULL, NULL, '_Mimoto_entityproperty', '12', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '31', 1);
INSERT INTO `_Mimoto_connection` VALUES (200, NULL, NULL, '_Mimoto_entityproperty', '12', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '32', 2);
INSERT INTO `_Mimoto_connection` VALUES (202, NULL, NULL, '_Mimoto_entityproperty', '13', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '33', 0);
INSERT INTO `_Mimoto_connection` VALUES (203, NULL, NULL, '_Mimoto_entityproperty', '13', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '34', 1);
INSERT INTO `_Mimoto_connection` VALUES (204, NULL, NULL, '_Mimoto_entityproperty', '13', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '35', 2);
INSERT INTO `_Mimoto_connection` VALUES (206, NULL, NULL, '_Mimoto_entityproperty', '14', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '36', 0);
INSERT INTO `_Mimoto_connection` VALUES (207, NULL, NULL, '_Mimoto_entityproperty', '14', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '37', 1);
INSERT INTO `_Mimoto_connection` VALUES (208, NULL, NULL, '_Mimoto_entityproperty', '14', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '38', 2);
INSERT INTO `_Mimoto_connection` VALUES (210, NULL, NULL, '_Mimoto_entityproperty', '15', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '39', 0);
INSERT INTO `_Mimoto_connection` VALUES (211, NULL, NULL, '_Mimoto_entityproperty', '15', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '40', 1);
INSERT INTO `_Mimoto_connection` VALUES (212, NULL, NULL, '_Mimoto_entityproperty', '15', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '41', 2);
INSERT INTO `_Mimoto_connection` VALUES (215, NULL, NULL, '_Mimoto_entityproperty', '16', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '43', 1);
INSERT INTO `_Mimoto_connection` VALUES (216, NULL, NULL, '_Mimoto_entityproperty', '16', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '44', 2);
INSERT INTO `_Mimoto_connection` VALUES (227, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (228, NULL, NULL, '_Mimoto_entityproperty', '19', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '51', 0);
INSERT INTO `_Mimoto_connection` VALUES (229, NULL, NULL, '_Mimoto_entityproperty', '19', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '52', 1);
INSERT INTO `_Mimoto_connection` VALUES (230, NULL, NULL, '_Mimoto_entityproperty', '19', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '53', 2);
INSERT INTO `_Mimoto_connection` VALUES (231, NULL, NULL, '_Mimoto_entity', '3', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '19', 0);
INSERT INTO `_Mimoto_connection` VALUES (232, NULL, NULL, '_Mimoto_entityproperty', '20', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '54', 0);
INSERT INTO `_Mimoto_connection` VALUES (233, NULL, NULL, '_Mimoto_entityproperty', '20', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '55', 1);
INSERT INTO `_Mimoto_connection` VALUES (234, NULL, NULL, '_Mimoto_entity', '3', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '20', 1);
INSERT INTO `_Mimoto_connection` VALUES (235, NULL, NULL, '_Mimoto_form_input_textline', '12', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '19', 0);
INSERT INTO `_Mimoto_connection` VALUES (236, NULL, NULL, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_output_title', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (237, NULL, NULL, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '6', 1);
INSERT INTO `_Mimoto_connection` VALUES (238, NULL, NULL, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '12', 2);
INSERT INTO `_Mimoto_connection` VALUES (239, NULL, NULL, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '6', 4);
INSERT INTO `_Mimoto_connection` VALUES (240, NULL, NULL, '_Mimoto_entity', '3', '_Mimoto_entity--forms', '_Mimoto_form', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (241, NULL, NULL, '_Mimoto_dataset', '2', '_Mimoto_dataset--form', '_Mimoto_form', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (242, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (243, NULL, NULL, '_Mimoto_dataset', '2', '_Mimoto_dataset--data', '3', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (244, NULL, NULL, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_input_list', '1', 3);
INSERT INTO `_Mimoto_connection` VALUES (245, NULL, NULL, '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--value', '_Mimoto_entityproperty', '20', 0);
INSERT INTO `_Mimoto_connection` VALUES (246, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '4', 3);
INSERT INTO `_Mimoto_connection` VALUES (247, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (248, NULL, NULL, '_Mimoto_entityproperty', '21', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '56', 0);
INSERT INTO `_Mimoto_connection` VALUES (249, NULL, NULL, '_Mimoto_entityproperty', '21', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '57', 1);
INSERT INTO `_Mimoto_connection` VALUES (250, NULL, NULL, '_Mimoto_entityproperty', '21', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '58', 2);
INSERT INTO `_Mimoto_connection` VALUES (251, NULL, NULL, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '21', 0);
INSERT INTO `_Mimoto_connection` VALUES (252, NULL, NULL, '_Mimoto_form_input_textline', '13', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '21', 0);
INSERT INTO `_Mimoto_connection` VALUES (253, NULL, NULL, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_output_title', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (254, NULL, NULL, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '7', 1);
INSERT INTO `_Mimoto_connection` VALUES (255, NULL, NULL, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '13', 2);
INSERT INTO `_Mimoto_connection` VALUES (256, NULL, NULL, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '7', 5);
INSERT INTO `_Mimoto_connection` VALUES (257, NULL, NULL, '_Mimoto_entity', '4', '_Mimoto_entity--forms', '_Mimoto_form', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (258, NULL, NULL, '_Mimoto_entityproperty', '22', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '59', 0);
INSERT INTO `_Mimoto_connection` VALUES (259, NULL, NULL, '_Mimoto_entityproperty', '22', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '60', 1);
INSERT INTO `_Mimoto_connection` VALUES (260, NULL, NULL, '_Mimoto_entityproperty', '22', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '61', 2);
INSERT INTO `_Mimoto_connection` VALUES (261, NULL, NULL, '_Mimoto_entity', '5', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '22', 0);
INSERT INTO `_Mimoto_connection` VALUES (262, NULL, NULL, '_Mimoto_form_input_textline', '14', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '22', 0);
INSERT INTO `_Mimoto_connection` VALUES (263, NULL, NULL, '_Mimoto_form', '8', '_Mimoto_form--fields', '_Mimoto_form_output_title', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (264, NULL, NULL, '_Mimoto_form', '8', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '8', 1);
INSERT INTO `_Mimoto_connection` VALUES (265, NULL, NULL, '_Mimoto_form', '8', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '14', 2);
INSERT INTO `_Mimoto_connection` VALUES (266, NULL, NULL, '_Mimoto_form', '8', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '8', 3);
INSERT INTO `_Mimoto_connection` VALUES (267, NULL, NULL, '_Mimoto_entity', '5', '_Mimoto_entity--forms', '_Mimoto_form', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (268, NULL, NULL, '_Mimoto_form_field_option', '1', '_Mimoto_form_field_option--form', '_Mimoto_form', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (269, NULL, NULL, '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--options', '_Mimoto_form_field_option', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (270, NULL, NULL, '_Mimoto_form_field_option', '2', '_Mimoto_form_field_option--form', '_Mimoto_form', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (271, NULL, NULL, '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--options', '_Mimoto_form_field_option', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (273, NULL, NULL, '3', '1', '20', '4', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (275, NULL, '2018-03-15 19:17:29', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '3', 3);
INSERT INTO `_Mimoto_connection` VALUES (276, NULL, NULL, '_Mimoto_selection', '3', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (277, NULL, NULL, '_Mimoto_selection_rule', '3', '_Mimoto_selection_rule--type', '_Mimoto_entity', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (286, NULL, NULL, '_Mimoto_user', '2', '_Mimoto_user--roles', '_Mimoto_user_role', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (287, NULL, NULL, '_Mimoto_user', '2', '_Mimoto_user--roles', '_Mimoto_user_role', '_Mimoto_user_role-contenteditor', 1);
INSERT INTO `_Mimoto_connection` VALUES (288, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--users', '_Mimoto_user', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (293, NULL, NULL, '_Mimoto_form_input_textblock', '10', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (294, NULL, NULL, '_Mimoto_form', '9', '_Mimoto_form--fields', '_Mimoto_form_output_title', '9', 0);
INSERT INTO `_Mimoto_connection` VALUES (295, NULL, NULL, '_Mimoto_form', '9', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '9', 1);
INSERT INTO `_Mimoto_connection` VALUES (296, NULL, NULL, '_Mimoto_form', '9', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '10', 2);
INSERT INTO `_Mimoto_connection` VALUES (297, NULL, NULL, '_Mimoto_form', '9', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '9', 3);
INSERT INTO `_Mimoto_connection` VALUES (298, NULL, NULL, '_Mimoto_entity', '2', '_Mimoto_entity--forms', '_Mimoto_form', '9', 0);
INSERT INTO `_Mimoto_connection` VALUES (314, NULL, NULL, '2', '12', '8', '_Mimoto_user', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (315, NULL, NULL, '1', '1', '6', '2', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (316, NULL, NULL, '2', '13', '8', '_Mimoto_user', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (317, NULL, NULL, '1', '1', '6', '2', '13', 1);
INSERT INTO `_Mimoto_connection` VALUES (318, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '6', 5);
INSERT INTO `_Mimoto_connection` VALUES (319, NULL, NULL, '_Mimoto_entityproperty', '23', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '62', 0);
INSERT INTO `_Mimoto_connection` VALUES (320, NULL, NULL, '_Mimoto_entityproperty', '23', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '63', 1);
INSERT INTO `_Mimoto_connection` VALUES (321, NULL, NULL, '_Mimoto_entityproperty', '23', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '64', 2);
INSERT INTO `_Mimoto_connection` VALUES (322, NULL, NULL, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '23', 2);
INSERT INTO `_Mimoto_connection` VALUES (323, NULL, NULL, '_Mimoto_entityproperty', '24', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '65', 0);
INSERT INTO `_Mimoto_connection` VALUES (324, NULL, NULL, '_Mimoto_entityproperty', '24', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '66', 1);
INSERT INTO `_Mimoto_connection` VALUES (325, NULL, NULL, '_Mimoto_entityproperty', '24', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '67', 2);
INSERT INTO `_Mimoto_connection` VALUES (326, NULL, NULL, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '24', 1);
INSERT INTO `_Mimoto_connection` VALUES (327, NULL, NULL, '_Mimoto_entityproperty', '25', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '68', 0);
INSERT INTO `_Mimoto_connection` VALUES (328, NULL, NULL, '_Mimoto_entityproperty', '25', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '69', 1);
INSERT INTO `_Mimoto_connection` VALUES (329, NULL, NULL, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '25', 3);
INSERT INTO `_Mimoto_connection` VALUES (330, NULL, NULL, '_Mimoto_entitypropertysetting', '68', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (346, NULL, NULL, '_Mimoto_output', '5', '_Mimoto_entity--component', '_Mimoto_component', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (359, NULL, NULL, '_Mimoto_dataset', '1', '_Mimoto_dataset--data', '1', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (365, NULL, NULL, '_Mimoto_dataset', '2', '_Mimoto_dataset--data', '3', '3', 1);
INSERT INTO `_Mimoto_connection` VALUES (366, NULL, NULL, '3', '3', '20', '5', '2', 2);
INSERT INTO `_Mimoto_connection` VALUES (525, NULL, NULL, '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-header', 7);
INSERT INTO `_Mimoto_connection` VALUES (528, NULL, NULL, '_Mimoto_output', '2', '_Mimoto_output--component', '_Mimoto_component', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (529, NULL, NULL, '_Mimoto_form_input_textline', '15', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '24', 0);
INSERT INTO `_Mimoto_connection` VALUES (530, NULL, NULL, '_Mimoto_form_input_textblock', '11', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '23', 0);
INSERT INTO `_Mimoto_connection` VALUES (531, NULL, NULL, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_output_title', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (532, NULL, NULL, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '10', 1);
INSERT INTO `_Mimoto_connection` VALUES (533, NULL, NULL, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '15', 3);
INSERT INTO `_Mimoto_connection` VALUES (534, NULL, NULL, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '11', 4);
INSERT INTO `_Mimoto_connection` VALUES (535, NULL, NULL, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '10', 5);
INSERT INTO `_Mimoto_connection` VALUES (536, NULL, NULL, '_Mimoto_entity', '6', '_Mimoto_entity--forms', '_Mimoto_form', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (537, NULL, NULL, '_Mimoto_dataset', '3', '_Mimoto_dataset--form', '_Mimoto_form', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (538, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (539, NULL, NULL, '_Mimoto_entityproperty', '27', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '71', 0);
INSERT INTO `_Mimoto_connection` VALUES (540, NULL, NULL, '_Mimoto_entityproperty', '27', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '72', 1);
INSERT INTO `_Mimoto_connection` VALUES (541, NULL, NULL, '_Mimoto_entityproperty', '27', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '73', 2);
INSERT INTO `_Mimoto_connection` VALUES (542, NULL, NULL, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '27', 4);
INSERT INTO `_Mimoto_connection` VALUES (543, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '7', 6);
INSERT INTO `_Mimoto_connection` VALUES (544, NULL, NULL, '_Mimoto_entityproperty', '28', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '74', 0);
INSERT INTO `_Mimoto_connection` VALUES (545, NULL, NULL, '_Mimoto_entityproperty', '28', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '75', 1);
INSERT INTO `_Mimoto_connection` VALUES (546, NULL, NULL, '_Mimoto_entityproperty', '28', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '76', 2);
INSERT INTO `_Mimoto_connection` VALUES (547, NULL, NULL, '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '28', 1);
INSERT INTO `_Mimoto_connection` VALUES (560, NULL, NULL, '_Mimoto_form_input_textline', '18', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '28', 0);
INSERT INTO `_Mimoto_connection` VALUES (561, NULL, NULL, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_output_title', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (562, NULL, NULL, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '12', 1);
INSERT INTO `_Mimoto_connection` VALUES (563, NULL, NULL, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '18', 3);
INSERT INTO `_Mimoto_connection` VALUES (564, NULL, NULL, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '12', 4);
INSERT INTO `_Mimoto_connection` VALUES (565, NULL, NULL, '_Mimoto_entity', '7', '_Mimoto_entity--forms', '_Mimoto_form', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (566, NULL, NULL, '_Mimoto_dataset', '4', '_Mimoto_dataset--form', '_Mimoto_form', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (567, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '4', 3);
INSERT INTO `_Mimoto_connection` VALUES (568, NULL, NULL, '_Mimoto_dataset', '4', '_Mimoto_dataset--data', '7', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (569, NULL, NULL, '_Mimoto_dataset', '4', '_Mimoto_dataset--data', '7', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (570, NULL, NULL, '_Mimoto_dataset', '4', '_Mimoto_dataset--data', '7', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (573, NULL, NULL, '_Mimoto_entityproperty', '30', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '80', 0);
INSERT INTO `_Mimoto_connection` VALUES (574, NULL, NULL, '_Mimoto_entityproperty', '30', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '81', 1);
INSERT INTO `_Mimoto_connection` VALUES (575, NULL, NULL, '_Mimoto_entityproperty', '30', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '82', 2);
INSERT INTO `_Mimoto_connection` VALUES (576, NULL, NULL, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '30', 0);
INSERT INTO `_Mimoto_connection` VALUES (577, NULL, NULL, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '19', 2);
INSERT INTO `_Mimoto_connection` VALUES (578, NULL, NULL, '_Mimoto_form_input_textline', '19', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '30', 0);
INSERT INTO `_Mimoto_connection` VALUES (580, NULL, NULL, '_Mimoto_entityproperty', '32', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '83', 0);
INSERT INTO `_Mimoto_connection` VALUES (581, NULL, NULL, '_Mimoto_entityproperty', '32', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '84', 1);
INSERT INTO `_Mimoto_connection` VALUES (582, NULL, NULL, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '32', 6);
INSERT INTO `_Mimoto_connection` VALUES (585, NULL, '2018-03-15 19:17:29', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (590, NULL, NULL, '_Mimoto_selection', '5', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (591, NULL, NULL, '_Mimoto_selection_rule', '4', '_Mimoto_selection_rule--type', '_Mimoto_entity', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (592, NULL, NULL, '_Mimoto_entityproperty', '33', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '85', 0);
INSERT INTO `_Mimoto_connection` VALUES (593, NULL, NULL, '_Mimoto_entityproperty', '33', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '86', 1);
INSERT INTO `_Mimoto_connection` VALUES (594, NULL, NULL, '_Mimoto_entityproperty', '33', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '87', 2);
INSERT INTO `_Mimoto_connection` VALUES (595, NULL, NULL, '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '33', 0);
INSERT INTO `_Mimoto_connection` VALUES (596, NULL, NULL, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '20', 2);
INSERT INTO `_Mimoto_connection` VALUES (597, NULL, NULL, '_Mimoto_form_input_textline', '20', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '33', 0);
INSERT INTO `_Mimoto_connection` VALUES (599, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '8', 7);
INSERT INTO `_Mimoto_connection` VALUES (600, NULL, NULL, '_Mimoto_entityproperty', '34', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '88', 0);
INSERT INTO `_Mimoto_connection` VALUES (601, NULL, NULL, '_Mimoto_entityproperty', '34', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '89', 1);
INSERT INTO `_Mimoto_connection` VALUES (602, NULL, NULL, '_Mimoto_entityproperty', '34', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '90', 2);
INSERT INTO `_Mimoto_connection` VALUES (603, NULL, NULL, '_Mimoto_entity', '8', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '34', 0);
INSERT INTO `_Mimoto_connection` VALUES (604, NULL, NULL, '_Mimoto_entityproperty', '35', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '91', 0);
INSERT INTO `_Mimoto_connection` VALUES (605, NULL, NULL, '_Mimoto_entityproperty', '35', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '92', 1);
INSERT INTO `_Mimoto_connection` VALUES (606, NULL, NULL, '_Mimoto_entityproperty', '35', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '93', 2);
INSERT INTO `_Mimoto_connection` VALUES (607, NULL, NULL, '_Mimoto_entity', '8', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '35', 1);
INSERT INTO `_Mimoto_connection` VALUES (608, NULL, NULL, '_Mimoto_form_input_textline', '21', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '34', 0);
INSERT INTO `_Mimoto_connection` VALUES (609, NULL, NULL, '_Mimoto_form_input_textline', '22', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '35', 0);
INSERT INTO `_Mimoto_connection` VALUES (610, NULL, NULL, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_output_title', '13', 0);
INSERT INTO `_Mimoto_connection` VALUES (611, NULL, NULL, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '13', 1);
INSERT INTO `_Mimoto_connection` VALUES (612, NULL, NULL, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '21', 2);
INSERT INTO `_Mimoto_connection` VALUES (613, NULL, NULL, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '22', 3);
INSERT INTO `_Mimoto_connection` VALUES (614, NULL, NULL, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '13', 4);
INSERT INTO `_Mimoto_connection` VALUES (615, NULL, NULL, '_Mimoto_entity', '8', '_Mimoto_entity--forms', '_Mimoto_form', '13', 0);
INSERT INTO `_Mimoto_connection` VALUES (616, NULL, NULL, '_Mimoto_dataset', '5', '_Mimoto_dataset--form', '_Mimoto_form', '13', 0);
INSERT INTO `_Mimoto_connection` VALUES (617, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (618, NULL, NULL, '_Mimoto_dataset', '5', '_Mimoto_dataset--data', '8', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (619, NULL, NULL, '_Mimoto_dataset', '5', '_Mimoto_dataset--data', '8', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (620, NULL, NULL, '_Mimoto_dataset', '5', '_Mimoto_dataset--data', '8', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (622, NULL, '2018-03-15 19:17:29', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '6', 5);
INSERT INTO `_Mimoto_connection` VALUES (623, NULL, NULL, '_Mimoto_selection', '6', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (624, NULL, NULL, '_Mimoto_selection_rule', '5', '_Mimoto_selection_rule--type', '_Mimoto_entity', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (627, NULL, NULL, '1', '2', '3', '_Mimoto_file', '16', 0);
INSERT INTO `_Mimoto_connection` VALUES (630, NULL, NULL, '_Mimoto_entityproperty', '36', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '94', 0);
INSERT INTO `_Mimoto_connection` VALUES (631, NULL, NULL, '_Mimoto_entityproperty', '36', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '95', 1);
INSERT INTO `_Mimoto_connection` VALUES (632, NULL, NULL, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '36', 1);
INSERT INTO `_Mimoto_connection` VALUES (675, NULL, NULL, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_dropdown', '2', 3);
INSERT INTO `_Mimoto_connection` VALUES (676, NULL, NULL, '_Mimoto_form_input_dropdown', '2', '_Mimoto_form_input_dropdown--value', '_Mimoto_entityproperty', '36', 0);
INSERT INTO `_Mimoto_connection` VALUES (677, NULL, NULL, '_Mimoto_form_field_option', '7', '_Mimoto_form_field_option--selection', '_Mimoto_selection', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (678, NULL, NULL, '_Mimoto_form_input_dropdown', '2', '_Mimoto_form_input_dropdown--options', '_Mimoto_form_field_option', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (690, NULL, NULL, '2', '15', '8', '_Mimoto_user', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (691, NULL, NULL, '1', '1', '6', '2', '15', 2);
INSERT INTO `_Mimoto_connection` VALUES (694, NULL, NULL, '1', '2', '36', '8', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (696, NULL, NULL, '_Mimoto_user', '2', '_Mimoto_user--avatar', '_Mimoto_file', '18', 0);
INSERT INTO `_Mimoto_connection` VALUES (715, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--services', '_Mimoto_service', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (716, NULL, NULL, '_Mimoto_service', '3', '_Mimoto_service--functions', '_Mimoto_service_function', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (852, NULL, NULL, '3', '3', '20', '5', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (853, NULL, NULL, '3', '3', '20', '4', '3', 1);
INSERT INTO `_Mimoto_connection` VALUES (854, NULL, NULL, '_Mimoto_entityproperty', '37', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '96', 0);
INSERT INTO `_Mimoto_connection` VALUES (855, NULL, NULL, '_Mimoto_entityproperty', '37', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '97', 1);
INSERT INTO `_Mimoto_connection` VALUES (856, NULL, NULL, '_Mimoto_entityproperty', '37', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '98', 2);
INSERT INTO `_Mimoto_connection` VALUES (857, NULL, NULL, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '37', 1);
INSERT INTO `_Mimoto_connection` VALUES (858, NULL, NULL, '_Mimoto_entitypropertysetting', '99', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', 0);
INSERT INTO `_Mimoto_connection` VALUES (859, NULL, NULL, '_Mimoto_entityproperty', '38', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '99', 0);
INSERT INTO `_Mimoto_connection` VALUES (860, NULL, NULL, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '38', 2);
INSERT INTO `_Mimoto_connection` VALUES (871, NULL, NULL, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '13', 3);
INSERT INTO `_Mimoto_connection` VALUES (872, NULL, NULL, '_Mimoto_form_input_textblock', '13', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '37', 0);
INSERT INTO `_Mimoto_connection` VALUES (873, NULL, NULL, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_input_image', '8', 4);
INSERT INTO `_Mimoto_connection` VALUES (874, NULL, NULL, '_Mimoto_form_input_image', '8', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '38', 0);
INSERT INTO `_Mimoto_connection` VALUES (875, NULL, NULL, '4', '3', '38', '_Mimoto_file', '19', 0);
INSERT INTO `_Mimoto_connection` VALUES (884, NULL, NULL, '_Mimoto_user', '1', '_Mimoto_user--roles', '_Mimoto_user_role', '_Mimoto_user_role-owner', 1);
INSERT INTO `_Mimoto_connection` VALUES (1523, NULL, NULL, '_Mimoto_entityproperty', '39', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '100', 0);
INSERT INTO `_Mimoto_connection` VALUES (1524, NULL, NULL, '_Mimoto_entityproperty', '39', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '101', 1);
INSERT INTO `_Mimoto_connection` VALUES (1525, NULL, NULL, '_Mimoto_entityproperty', '39', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '102', 2);
INSERT INTO `_Mimoto_connection` VALUES (1526, NULL, NULL, '_Mimoto_component', '3', '_Mimoto_component--properties', '_Mimoto_entityproperty', '39', 0);
INSERT INTO `_Mimoto_connection` VALUES (1529, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '6', 5);
INSERT INTO `_Mimoto_connection` VALUES (1530, NULL, NULL, '_Mimoto_entityproperty', '40', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '103', 0);
INSERT INTO `_Mimoto_connection` VALUES (1531, NULL, NULL, '_Mimoto_entityproperty', '40', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '104', 1);
INSERT INTO `_Mimoto_connection` VALUES (1532, NULL, NULL, '_Mimoto_entityproperty', '40', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '105', 2);
INSERT INTO `_Mimoto_connection` VALUES (1533, NULL, NULL, '_Mimoto_entityproperty', '41', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '106', 0);
INSERT INTO `_Mimoto_connection` VALUES (1534, NULL, NULL, '_Mimoto_entityproperty', '41', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '107', 1);
INSERT INTO `_Mimoto_connection` VALUES (1535, NULL, NULL, '_Mimoto_entityproperty', '41', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '108', 2);
INSERT INTO `_Mimoto_connection` VALUES (1536, NULL, NULL, '_Mimoto_entityproperty', '43', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '109', 0);
INSERT INTO `_Mimoto_connection` VALUES (1537, NULL, NULL, '_Mimoto_entityproperty', '43', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '110', 1);
INSERT INTO `_Mimoto_connection` VALUES (1538, NULL, NULL, '_Mimoto_entityproperty', '43', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '111', 2);
INSERT INTO `_Mimoto_connection` VALUES (1545, NULL, NULL, '_Mimoto_entityproperty', '45', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '115', 0);
INSERT INTO `_Mimoto_connection` VALUES (1546, NULL, NULL, '_Mimoto_entityproperty', '45', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '116', 1);
INSERT INTO `_Mimoto_connection` VALUES (1547, NULL, NULL, '_Mimoto_entityproperty', '45', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '117', 2);
INSERT INTO `_Mimoto_connection` VALUES (1548, NULL, NULL, '_Mimoto_entityproperty', '46', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '118', 0);
INSERT INTO `_Mimoto_connection` VALUES (1549, NULL, NULL, '_Mimoto_entityproperty', '46', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '119', 1);
INSERT INTO `_Mimoto_connection` VALUES (1550, NULL, NULL, '_Mimoto_entityproperty', '46', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '120', 2);
INSERT INTO `_Mimoto_connection` VALUES (1551, NULL, NULL, '_Mimoto_component', '6', '_Mimoto_component--properties', '_Mimoto_entityproperty', '46', 0);
INSERT INTO `_Mimoto_connection` VALUES (1553, NULL, NULL, '_Mimoto_entityproperty', '47', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '121', 0);
INSERT INTO `_Mimoto_connection` VALUES (1554, NULL, NULL, '_Mimoto_entityproperty', '47', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '122', 1);
INSERT INTO `_Mimoto_connection` VALUES (1555, NULL, NULL, '_Mimoto_entityproperty', '47', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '123', 2);
INSERT INTO `_Mimoto_connection` VALUES (1556, NULL, NULL, '_Mimoto_component', '6', '_Mimoto_component--properties', '_Mimoto_entityproperty', '47', 1);
INSERT INTO `_Mimoto_connection` VALUES (1558, NULL, NULL, '_Mimoto_entityproperty', '48', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '124', 0);
INSERT INTO `_Mimoto_connection` VALUES (1559, NULL, NULL, '_Mimoto_entityproperty', '48', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '125', 1);
INSERT INTO `_Mimoto_connection` VALUES (1560, NULL, NULL, '_Mimoto_entityproperty', '48', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '126', 2);
INSERT INTO `_Mimoto_connection` VALUES (1561, NULL, NULL, '_Mimoto_component', '6', '_Mimoto_component--properties', '_Mimoto_entityproperty', '48', 2);
INSERT INTO `_Mimoto_connection` VALUES (1562, NULL, NULL, '_Mimoto_entityproperty', '49', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '127', 0);
INSERT INTO `_Mimoto_connection` VALUES (1563, NULL, NULL, '_Mimoto_entityproperty', '49', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '128', 1);
INSERT INTO `_Mimoto_connection` VALUES (1564, NULL, NULL, '_Mimoto_entityproperty', '49', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '129', 2);
INSERT INTO `_Mimoto_connection` VALUES (1565, NULL, NULL, '_Mimoto_component', '6', '_Mimoto_component--properties', '_Mimoto_entityproperty', '49', 3);
INSERT INTO `_Mimoto_connection` VALUES (1753, NULL, NULL, '1', '1', '36', '8', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (1788, NULL, NULL, '_Mimoto_action', '39', '_Mimoto_action--entity', '_Mimoto_entity', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (1795, NULL, NULL, '_Mimoto_action', '43', '_Mimoto_action--entity', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1797, NULL, NULL, '_Mimoto_action', '44', '_Mimoto_action--entity', '_Mimoto_entity', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (1800, NULL, NULL, '_Mimoto_action', '46', '_Mimoto_action--entity', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1909, NULL, NULL, '_Mimoto_action_conditional', '44', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1915, NULL, NULL, '_Mimoto_action_conditional', '45', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1936, NULL, NULL, '_Mimoto_action_conditional', '49', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (1941, NULL, NULL, '_Mimoto_action_conditional', '50', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1949, NULL, NULL, '_Mimoto_action_conditional', '52', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1995, NULL, '2018-03-15 19:17:29', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '8', 7);
INSERT INTO `_Mimoto_connection` VALUES (2035, NULL, NULL, '_Mimoto_action_conditional', '60', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2045, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--actions', '_Mimoto_action', '108', 0);
INSERT INTO `_Mimoto_connection` VALUES (2049, NULL, NULL, '_Mimoto_action', '108', '_Mimoto_action--service', '_Mimoto_service', '_Mimoto_service-Slack', 0);
INSERT INTO `_Mimoto_connection` VALUES (2050, NULL, NULL, '_Mimoto_action', '108', '_Mimoto_action--function', '_Mimoto_service_function', '_Mimoto_service_function-Slack-sendMessage', 0);
INSERT INTO `_Mimoto_connection` VALUES (2051, NULL, NULL, '_Mimoto_action', '108', '_Mimoto_action--settings', '_Mimoto_action_setting', '22', 0);
INSERT INTO `_Mimoto_connection` VALUES (2052, NULL, NULL, '_Mimoto_action', '108', '_Mimoto_action--settings', '_Mimoto_action_setting', '23', 1);
INSERT INTO `_Mimoto_connection` VALUES (2054, NULL, NULL, '_Mimoto_action_conditional', '62', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (2059, NULL, NULL, '_Mimoto_action_conditional', '63', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (2065, NULL, '2018-03-15 19:17:29', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '10', 6);
INSERT INTO `_Mimoto_connection` VALUES (2066, NULL, NULL, '_Mimoto_output', '2', '_Mimoto_output--selection', '_Mimoto_selection', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (2067, NULL, NULL, '_Mimoto_action', '108', '_Mimoto_action--entity', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2068, NULL, NULL, '_Mimoto_action', '108', '_Mimoto_action--conditionals', '_Mimoto_action_conditional', '64', 0);
INSERT INTO `_Mimoto_connection` VALUES (2069, NULL, NULL, '_Mimoto_action_conditional', '64', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2077, NULL, NULL, '_Mimoto_selection_rule', '3', '_Mimoto_selection_rule--instance', '3', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (2078, NULL, NULL, '_Mimoto_selection', '10', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (2090, NULL, NULL, '_Mimoto_selection_rule', '10', '_Mimoto_selection_rule--type', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2129, NULL, NULL, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '42', 8);
INSERT INTO `_Mimoto_connection` VALUES (2135, '2018-02-06 19:38:36', '2018-08-27 15:11:51', '_Mimoto_page', '3', '_Mimoto_page--output', '_Mimoto_output', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (2136, '2018-02-06 19:38:36', '2018-08-27 15:13:20', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--pages', '_Mimoto_page', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (2139, '2018-02-06 19:39:50', '2018-08-27 15:11:54', '_Mimoto_page', '4', '_Mimoto_page--output', '_Mimoto_output', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (2140, '2018-02-06 19:39:50', '2018-08-27 15:13:28', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--pages', '_Mimoto_page', '4', 2);
INSERT INTO `_Mimoto_connection` VALUES (2141, '2018-02-06 19:40:09', '2018-02-06 19:40:09', '_Mimoto_dataset', '2', '_Mimoto_dataset--data', '3', '4', 2);
INSERT INTO `_Mimoto_connection` VALUES (2142, '2018-02-06 19:40:28', '2018-02-06 19:40:28', '_Mimoto_dataset', '5', '_Mimoto_dataset--data', '8', '4', 3);
INSERT INTO `_Mimoto_connection` VALUES (2281, '2018-02-11 13:14:01', '2018-02-11 13:14:01', '_Mimoto_dataset', '2', '_Mimoto_dataset--data', '3', '6', 4);
INSERT INTO `_Mimoto_connection` VALUES (2283, '2018-02-11 13:16:29', '2018-02-11 13:16:29', '_Mimoto_dataset', '2', '_Mimoto_dataset--data', '3', '8', 4);
INSERT INTO `_Mimoto_connection` VALUES (2284, '2018-02-11 13:16:37', '2018-02-11 13:16:37', '_Mimoto_dataset', '2', '_Mimoto_dataset--data', '3', '9', 4);
INSERT INTO `_Mimoto_connection` VALUES (2285, '2018-03-01 09:56:52', '2018-03-01 09:56:52', '_Mimoto_selection_rule', '1', '_Mimoto_selection_rule--type', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2303, '2018-03-01 11:11:07', '2018-08-27 15:13:42', '_Mimoto_page', '3', '_Mimoto_page--path', '_Mimoto_path_element', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (2305, '2018-03-01 11:11:18', '2018-03-01 11:11:18', '_Mimoto_output', '6', '_Mimoto_output--component', '_Mimoto_component', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (2306, '2018-03-01 11:11:38', '2018-03-15 19:17:29', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '11', 2);
INSERT INTO `_Mimoto_connection` VALUES (2307, '2018-03-01 11:12:01', '2018-03-01 11:12:01', '_Mimoto_selection', '11', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '11', 0);
INSERT INTO `_Mimoto_connection` VALUES (2308, '2018-03-01 11:12:03', '2018-03-01 11:12:03', '_Mimoto_selection_rule', '11', '_Mimoto_selection_rule--type', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2309, '2018-03-01 11:12:05', '2018-03-01 11:12:05', '_Mimoto_selection_rule', '11', '_Mimoto_selection_rule--values', '_Mimoto_selection_rule_value', '13', 0);
INSERT INTO `_Mimoto_connection` VALUES (2311, '2018-03-05 16:46:40', '2018-03-05 16:46:40', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '7', 6);
INSERT INTO `_Mimoto_connection` VALUES (2312, '2018-03-05 16:49:52', '2018-03-05 16:49:52', '_Mimoto_component', '7', '_Mimoto_component--templates', '_Mimoto_component_template', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (2313, '2018-03-05 16:52:13', '2018-03-05 16:52:13', '_Mimoto_component_template', '6', '_Mimoto_component_template--conditionals', '_Mimoto_component_conditional', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2314, '2018-03-05 16:52:19', '2018-03-05 16:52:19', '_Mimoto_component_conditional', '1', '_Mimoto_component_conditional--entityType', '_Mimoto_entity', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (2315, '2018-03-05 16:52:27', '2018-03-05 16:52:27', '_Mimoto_component', '7', '_Mimoto_component--templates', '_Mimoto_component_template', '7', 1);
INSERT INTO `_Mimoto_connection` VALUES (2316, '2018-03-05 16:52:28', '2018-03-05 16:52:28', '_Mimoto_component_template', '7', '_Mimoto_component_template--conditionals', '_Mimoto_component_conditional', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (2317, '2018-03-05 16:52:34', '2018-03-05 16:52:34', '_Mimoto_component_conditional', '2', '_Mimoto_component_conditional--entityType', '_Mimoto_entity', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (2319, '2018-03-06 13:04:11', '2018-03-06 13:04:11', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '8', 7);
INSERT INTO `_Mimoto_connection` VALUES (2320, '2018-03-06 13:04:30', '2018-03-06 13:04:30', '_Mimoto_component', '8', '_Mimoto_component--templates', '_Mimoto_component_template', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (2358, '2018-03-09 09:39:11', '2018-03-09 09:39:11', '_Mimoto_entitypropertysetting', '54', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (2359, '2018-03-09 09:39:13', '2018-03-09 09:39:13', '_Mimoto_entitypropertysetting', '54', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '5', 1);
INSERT INTO `_Mimoto_connection` VALUES (2377, '2018-03-10 16:53:43', '2018-03-10 16:53:43', '3', '1', '20', '5', '21', 1);
INSERT INTO `_Mimoto_connection` VALUES (2380, '2018-03-10 17:11:13', '2018-03-10 17:11:13', '3', '1', '20', '5', '24', 2);
INSERT INTO `_Mimoto_connection` VALUES (2381, '2018-03-15 18:51:20', '2018-03-15 19:17:29', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (2382, '2018-03-15 18:51:34', '2018-03-15 18:51:34', '_Mimoto_selection', '12', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (2383, '2018-03-15 18:53:36', '2018-03-15 18:53:36', '_Mimoto_selection_rule', '12', '_Mimoto_selection_rule--type', '_Mimoto_entity', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (2387, '2018-03-15 18:55:35', '2018-03-15 18:55:35', '_Mimoto_selection', '8', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '14', 2);
INSERT INTO `_Mimoto_connection` VALUES (2388, '2018-03-15 18:55:43', '2018-03-15 18:55:43', '_Mimoto_selection_rule', '14', '_Mimoto_selection_rule--type', '_Mimoto_entity', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (2400, '2018-03-15 19:36:45', '2018-03-15 19:36:45', '_Mimoto_selection_rule', '12', '_Mimoto_selection_rule--instance', '3', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (2405, '2018-03-15 20:45:05', '2018-03-15 20:45:05', '_Mimoto_selection_rule', '12', '_Mimoto_selection_rule--property', '_Mimoto_entityproperty', '20', 0);
INSERT INTO `_Mimoto_connection` VALUES (2406, '2018-07-05 13:01:24', '2018-07-05 13:01:24', '_Mimoto_output', '6', '_Mimoto_output--selection', '_Mimoto_selection', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2407, '2018-07-14 16:07:49', '2018-07-14 16:10:29', '_Mimoto_dataset', '3', '_Mimoto_dataset--data', '6', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (2408, NULL, '2018-07-14 16:10:29', '_Mimoto_dataset', '3', '_Mimoto_dataset--data', '6', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2409, '2018-07-21 15:05:55', '2018-07-21 15:05:55', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--userRoles', '_Mimoto_user_role', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (2410, '2018-07-21 15:08:08', '2018-07-21 15:08:08', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--userRoles', '_Mimoto_user_role', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (2411, '2018-07-21 15:09:45', '2018-07-21 15:09:45', '_Mimoto_user', '2', '_Mimoto_user--roles', '_Mimoto_user_role', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (2429, '2018-08-27 16:37:02', '2018-08-27 16:37:02', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--api', '_Mimoto_api', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (2436, '2018-08-31 14:09:50', '2018-08-31 14:09:50', '_Mimoto_page', '2', '_Mimoto_page--allowedUserRoles', '_Mimoto_user_role', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (2437, '2018-08-31 14:10:08', '2018-08-31 14:10:08', '_Mimoto_api', '2', '_Mimoto_api--allowedUserRoles', '_Mimoto_user_role', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (2438, '2018-08-31 14:10:21', '2018-08-31 14:10:21', '_Mimoto_api', '2', '_Mimoto_api--path', '_Mimoto_path_element', '14', 0);
INSERT INTO `_Mimoto_connection` VALUES (2439, '2018-08-31 14:10:25', '2018-08-31 14:10:25', '_Mimoto_api', '2', '_Mimoto_api--path', '_Mimoto_path_element', '15', 1);
INSERT INTO `_Mimoto_connection` VALUES (2440, '2018-08-31 14:13:39', '2018-08-31 14:13:39', '_Mimoto_api', '2', '_Mimoto_api--path', '_Mimoto_path_element', '16', 2);
INSERT INTO `_Mimoto_connection` VALUES (2441, '2018-08-31 14:13:45', '2018-08-31 14:13:45', '_Mimoto_api', '2', '_Mimoto_api--path', '_Mimoto_path_element', '17', 3);
INSERT INTO `_Mimoto_connection` VALUES (2442, '2018-08-31 14:14:04', '2018-08-31 14:14:04', '_Mimoto_api', '2', '_Mimoto_api--path', '_Mimoto_path_element', '18', 4);
INSERT INTO `_Mimoto_connection` VALUES (2445, '2018-08-31 14:18:48', '2018-08-31 14:18:48', '_Mimoto_api', '2', '_Mimoto_api--path', '_Mimoto_path_element', '21', 5);
INSERT INTO `_Mimoto_connection` VALUES (2446, '2018-08-31 14:18:58', '2018-08-31 14:18:58', '_Mimoto_api', '2', '_Mimoto_api--path', '_Mimoto_path_element', '22', 6);
INSERT INTO `_Mimoto_connection` VALUES (2449, '2018-09-01 12:52:18', '2018-09-01 12:52:18', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--services', '_Mimoto_service', '4', 1);
INSERT INTO `_Mimoto_connection` VALUES (2450, '2018-09-01 12:52:34', '2018-09-01 12:52:34', '_Mimoto_service', '4', '_Mimoto_service--functions', '_Mimoto_service_function', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (2455, '2018-09-01 12:56:17', '2018-09-01 12:56:17', '_Mimoto_api', '2', '_Mimoto_api--service', '_Mimoto_service', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (2456, '2018-09-01 12:56:22', '2018-09-01 12:56:22', '_Mimoto_api', '2', '_Mimoto_api--function', '_Mimoto_service_function', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (2457, '2018-09-01 12:58:13', '2018-09-01 12:58:13', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2458, '2018-09-01 12:58:31', '2018-09-01 12:58:31', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (2459, '2018-09-01 13:37:15', '2018-09-01 13:37:15', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (2460, '2018-09-01 13:38:33', '2018-09-01 13:38:33', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '4', 3);
INSERT INTO `_Mimoto_connection` VALUES (2461, '2018-09-01 13:40:10', '2018-09-01 13:40:10', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (2462, '2018-09-01 13:40:21', '2018-09-01 13:40:21', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '6', 5);
INSERT INTO `_Mimoto_connection` VALUES (2463, '2018-09-01 13:53:10', '2018-09-01 13:53:10', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '7', 6);
INSERT INTO `_Mimoto_connection` VALUES (2464, '2018-09-01 13:53:45', '2018-09-01 13:53:45', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '8', 7);
INSERT INTO `_Mimoto_connection` VALUES (2465, '2018-09-01 13:54:16', '2018-09-01 13:54:16', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '9', 8);
INSERT INTO `_Mimoto_connection` VALUES (2466, '2018-09-01 13:54:18', '2018-09-01 13:54:18', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '10', 9);
INSERT INTO `_Mimoto_connection` VALUES (2467, '2018-09-01 13:54:31', '2018-09-01 13:54:31', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '11', 10);
INSERT INTO `_Mimoto_connection` VALUES (2468, '2018-09-01 13:54:40', '2018-09-01 13:54:40', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '12', 11);
INSERT INTO `_Mimoto_connection` VALUES (2469, '2018-09-01 14:08:33', '2018-09-01 14:08:33', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '13', 12);
INSERT INTO `_Mimoto_connection` VALUES (2470, '2018-09-01 14:08:58', '2018-09-01 14:08:58', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '14', 13);
INSERT INTO `_Mimoto_connection` VALUES (2471, '2018-09-01 14:08:59', '2018-09-01 14:08:59', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '15', 14);
INSERT INTO `_Mimoto_connection` VALUES (2472, '2018-09-01 14:15:18', '2018-09-01 14:15:18', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '16', 15);
INSERT INTO `_Mimoto_connection` VALUES (2474, '2018-09-01 14:16:43', '2018-09-01 14:16:43', '_Mimoto_api', '2', '_Mimoto_api--selections', '_Mimoto_selection', '17', 0);
INSERT INTO `_Mimoto_connection` VALUES (2475, '2018-09-01 14:17:13', '2018-09-01 14:17:13', '_Mimoto_selection', '17', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '15', 0);
INSERT INTO `_Mimoto_connection` VALUES (2478, '2018-09-01 14:32:58', '2018-09-01 14:32:58', '_Mimoto_selection_rule', '15', '_Mimoto_selection_rule--type', '_Mimoto_entity', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (2480, '2018-09-01 15:44:27', '2018-09-01 15:44:27', '_Mimoto_api', '2', '_Mimoto_api--settings', '_Mimoto_action_setting', '24', 0);
INSERT INTO `_Mimoto_connection` VALUES (2481, '2018-09-01 17:45:53', '2018-09-01 17:45:53', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '17', 16);
INSERT INTO `_Mimoto_connection` VALUES (2482, '2018-09-01 17:47:44', '2018-09-01 17:47:44', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '18', 17);
INSERT INTO `_Mimoto_connection` VALUES (2483, '2018-09-01 18:10:29', '2018-09-01 18:10:29', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '19', 18);
INSERT INTO `_Mimoto_connection` VALUES (2484, '2018-09-01 18:12:09', '2018-09-01 18:12:09', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '20', 19);
INSERT INTO `_Mimoto_connection` VALUES (2485, '2018-09-01 18:16:39', '2018-09-01 18:16:39', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '21', 20);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_dataset
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_dataset`;
CREATE TABLE `_Mimoto_dataset` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_dataset
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_dataset` VALUES (1, 'Articles', '2017-09-20 18:45:34', NULL);
INSERT INTO `_Mimoto_dataset` VALUES (2, 'Pages', '2017-09-21 09:11:38', NULL);
INSERT INTO `_Mimoto_dataset` VALUES (3, 'Members', '2017-09-30 13:40:01', NULL);
INSERT INTO `_Mimoto_dataset` VALUES (4, 'Member types', '2017-09-30 13:44:21', NULL);
INSERT INTO `_Mimoto_dataset` VALUES (5, 'Article types', '2017-10-01 17:30:24', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_entity
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entity`;
CREATE TABLE `_Mimoto_entity` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `isUserExtension` enum('0','1') DEFAULT NULL,
  `isAbstract` enum('0','1') CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_entity
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entity` VALUES (1, '2017-09-20 18:41:29', NULL, 'article', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (2, '2017-09-20 19:07:46', NULL, 'comment', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (3, '2017-09-21 09:09:58', NULL, 'page', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (4, '2017-09-21 09:24:25', NULL, 'element1', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (5, '2017-09-21 09:24:31', NULL, 'element2', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (6, NULL, NULL, 'member', '1', NULL);
INSERT INTO `_Mimoto_entity` VALUES (7, '2017-09-30 13:40:39', NULL, 'memberType', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (8, '2017-10-01 17:29:50', NULL, 'articleType', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (20, '2017-12-03 14:33:18', NULL, 'zzz', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (21, '2017-12-03 15:38:00', NULL, 'bbb', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (22, '2017-12-03 15:42:08', NULL, 'fff', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (23, '2017-12-03 15:43:31', NULL, 'fff', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (24, '2017-12-03 15:43:47', NULL, 'fff', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (25, '2017-12-03 15:44:21', NULL, 'fff', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (26, '2017-12-03 15:44:51', NULL, 'fff', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (28, '2017-12-03 15:46:25', NULL, 'aaa', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (30, '2017-12-03 15:48:31', NULL, 'hhh', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (33, '2017-12-03 15:49:31', NULL, 'aa2', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (34, '2017-12-03 15:52:50', NULL, 'aa3', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (35, '2017-12-03 16:00:06', NULL, 'aa4', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (36, '2017-12-03 16:00:23', NULL, 'aa5', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (42, '2017-12-03 18:05:08', NULL, 'xxx', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_entityproperty
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entityproperty`;
CREATE TABLE `_Mimoto_entityproperty` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtype` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_entityproperty
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entityproperty` VALUES (1, '2017-09-20 18:41:37', NULL, 'title', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (2, '2017-09-20 18:42:13', NULL, 'lede', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (3, '2017-09-20 18:42:26', NULL, 'headerImage', 'entity', 'image');
INSERT INTO `_Mimoto_entityproperty` VALUES (4, '2017-09-20 18:42:35', NULL, 'body', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (6, '2017-09-20 18:44:38', NULL, 'comments', 'collection', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (7, '2017-09-20 19:07:54', NULL, 'message', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (8, '2017-09-20 19:08:03', NULL, 'owner', 'entity', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (10, '2017-09-21 07:42:48', NULL, 'aaa', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (11, '2017-09-21 07:44:03', NULL, 'title', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (12, '2017-09-21 07:45:44', NULL, 'aaa1', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (13, '2017-09-21 07:56:49', NULL, 'aaa2', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (14, '2017-09-21 07:57:23', NULL, 'aaa3', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (15, '2017-09-21 07:59:15', NULL, 'aaa4', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (16, '2017-09-21 08:01:56', NULL, 'aaa5', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (19, '2017-09-21 09:10:09', NULL, 'title', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (20, '2017-09-21 09:10:16', NULL, 'elements', 'collection', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (21, '2017-09-21 09:24:40', NULL, 'title', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (22, '2017-09-21 09:24:56', NULL, 'label', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (23, '2017-09-22 10:27:44', NULL, 'biography', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (24, '2017-09-22 10:28:04', NULL, 'topic', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (25, '2017-09-22 10:28:15', NULL, 'articles', 'collection', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (27, '2017-09-30 13:40:18', NULL, 'type', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (28, '2017-09-30 13:42:47', NULL, 'value', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (30, '2017-09-30 14:16:09', NULL, 'name', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (32, '2017-09-30 14:19:18', NULL, 'author', 'entity', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (33, '2017-10-01 16:43:53', NULL, 'label', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (34, '2017-10-01 17:29:59', NULL, 'label', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (35, '2017-10-01 17:30:04', NULL, 'value', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (36, '2017-10-01 18:10:51', NULL, 'type', 'entity', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (37, '2017-10-25 17:57:48', NULL, 'body', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (38, '2017-10-25 17:58:03', NULL, 'image', 'entity', 'image');
INSERT INTO `_Mimoto_entityproperty` VALUES (39, '2017-11-20 11:12:03', NULL, 'xxx', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (40, '2017-11-20 15:17:31', NULL, 'aaa', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (41, '2017-11-20 15:17:43', NULL, 'aaa', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (42, '2017-11-20 15:41:50', NULL, 'dddd', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (43, '2017-11-20 15:42:05', NULL, 'dddd', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (45, '2017-11-20 15:47:16', NULL, 'xxx', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (46, '2017-11-20 15:48:12', NULL, 'aaa', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (47, '2017-11-21 11:38:44', NULL, 'bbb', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (48, '2017-11-21 11:40:03', NULL, 'bbb', 'value', NULL);
INSERT INTO `_Mimoto_entityproperty` VALUES (49, '2017-11-21 11:40:15', NULL, 'nnnn', 'value', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_entitypropertysetting
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entitypropertysetting`;
CREATE TABLE `_Mimoto_entitypropertysetting` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_entitypropertysetting
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (1, '2017-09-20 18:41:37', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (2, '2017-09-20 18:41:37', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (3, '2017-09-20 18:41:37', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (4, '2017-09-20 18:42:13', NULL, 'type', 'text', 'textblock');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (5, '2017-09-20 18:42:13', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (6, '2017-09-20 18:42:13', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (7, '2017-09-20 18:42:26', NULL, 'allowedEntityType', NULL, NULL);
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (8, '2017-09-20 18:42:35', NULL, 'type', 'text', 'textblock');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (9, '2017-09-20 18:42:35', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (10, '2017-09-20 18:42:35', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (14, '2017-09-20 18:44:38', NULL, 'allowedEntityTypes', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (15, '2017-09-20 18:44:38', NULL, 'allowDuplicates', 'boolean', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (16, '2017-09-20 19:07:54', NULL, 'type', 'text', 'textblock');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (17, '2017-09-20 19:07:54', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (18, '2017-09-20 19:07:54', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (19, '2017-09-20 19:08:03', NULL, 'allowedEntityType', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (20, '2017-09-20 19:08:03', NULL, 'defaultValue', 'currentUser', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (24, '2017-09-21 07:42:48', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (25, '2017-09-21 07:42:48', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (26, '2017-09-21 07:42:48', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (27, '2017-09-21 07:44:03', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (28, '2017-09-21 07:44:03', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (29, '2017-09-21 07:44:03', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (30, '2017-09-21 07:45:44', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (31, '2017-09-21 07:45:44', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (32, '2017-09-21 07:45:44', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (33, '2017-09-21 07:56:49', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (34, '2017-09-21 07:56:49', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (35, '2017-09-21 07:56:49', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (36, '2017-09-21 07:57:23', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (37, '2017-09-21 07:57:23', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (38, '2017-09-21 07:57:23', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (39, '2017-09-21 07:59:15', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (40, '2017-09-21 07:59:15', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (41, '2017-09-21 07:59:15', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (43, '2017-09-21 08:01:56', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (44, '2017-09-21 08:01:56', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (51, '2017-09-21 09:10:09', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (52, '2017-09-21 09:10:09', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (53, '2017-09-21 09:10:09', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (54, '2017-09-21 09:10:16', NULL, 'allowedEntityTypes', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (55, '2017-09-21 09:10:16', NULL, 'allowDuplicates', 'boolean', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (56, '2017-09-21 09:24:40', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (57, '2017-09-21 09:24:40', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (58, '2017-09-21 09:24:40', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (59, '2017-09-21 09:24:56', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (60, '2017-09-21 09:24:56', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (61, '2017-09-21 09:24:56', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (62, '2017-09-22 10:27:44', NULL, 'type', 'text', 'textblock');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (63, '2017-09-22 10:27:44', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (64, '2017-09-22 10:27:44', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (65, '2017-09-22 10:28:04', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (66, '2017-09-22 10:28:04', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (67, '2017-09-22 10:28:04', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (68, '2017-09-22 10:28:15', NULL, 'allowedEntityTypes', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (69, '2017-09-22 10:28:15', NULL, 'allowDuplicates', 'boolean', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (71, '2017-09-30 13:40:18', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (72, '2017-09-30 13:40:18', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (73, '2017-09-30 13:40:18', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (74, '2017-09-30 13:42:47', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (75, '2017-09-30 13:42:47', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (76, '2017-09-30 13:42:47', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (80, '2017-09-30 14:16:09', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (81, '2017-09-30 14:16:09', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (82, '2017-09-30 14:16:09', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (83, '2017-09-30 14:19:18', NULL, 'allowedEntityType', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (84, '2017-09-30 14:19:18', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (85, '2017-10-01 16:43:53', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (86, '2017-10-01 16:43:53', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (87, '2017-10-01 16:43:53', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (88, '2017-10-01 17:29:59', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (89, '2017-10-01 17:29:59', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (90, '2017-10-01 17:29:59', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (91, '2017-10-01 17:30:04', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (92, '2017-10-01 17:30:04', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (93, '2017-10-01 17:30:04', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (94, '2017-10-01 18:10:51', NULL, 'allowedEntityType', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (95, '2017-10-01 18:10:51', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (96, '2017-10-25 17:57:48', NULL, 'type', 'text', 'textblock');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (97, '2017-10-25 17:57:48', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (98, '2017-10-25 17:57:48', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (99, '2017-10-25 17:58:03', NULL, 'allowedEntityType', NULL, NULL);
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (100, '2017-11-20 11:12:03', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (101, '2017-11-20 11:12:03', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (102, '2017-11-20 11:12:03', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (103, '2017-11-20 15:17:31', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (104, '2017-11-20 15:17:31', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (105, '2017-11-20 15:17:31', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (106, '2017-11-20 15:17:43', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (107, '2017-11-20 15:17:43', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (108, '2017-11-20 15:17:43', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (109, '2017-11-20 15:42:05', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (110, '2017-11-20 15:42:05', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (111, '2017-11-20 15:42:05', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (115, '2017-11-20 15:47:16', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (116, '2017-11-20 15:47:16', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (117, '2017-11-20 15:47:16', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (118, '2017-11-20 15:48:12', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (119, '2017-11-20 15:48:12', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (120, '2017-11-20 15:48:12', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (121, '2017-11-21 11:38:44', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (122, '2017-11-21 11:38:44', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (123, '2017-11-21 11:38:44', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (124, '2017-11-21 11:40:03', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (125, '2017-11-21 11:40:03', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (126, '2017-11-21 11:40:03', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (127, '2017-11-21 11:40:15', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (128, '2017-11-21 11:40:15', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (129, '2017-11-21 11:40:15', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (130, '2017-12-04 06:41:43', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (131, '2017-12-04 06:41:43', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (132, '2017-12-04 06:41:43', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (133, '2017-12-04 06:42:10', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (134, '2017-12-04 06:42:10', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (135, '2017-12-04 06:42:10', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (136, '2017-12-04 06:42:22', NULL, 'type', 'text', 'textline');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (137, '2017-12-04 06:42:22', NULL, 'formattingOptions', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (138, '2017-12-04 06:42:22', NULL, 'defaultValue', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (139, '2017-12-04 06:44:15', NULL, 'allowedEntityType', '', '');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (140, '2017-12-04 06:44:15', NULL, 'defaultValue', '', '');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_file
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_file`;
CREATE TABLE `_Mimoto_file` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `path` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `mime` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `size` int(10) unsigned DEFAULT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `aspectRatio` float(10,5) DEFAULT NULL,
  `originalName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_file
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_file` VALUES (1, '2017-09-20 18:36:09', NULL, '7ed2f3279e444065298dda124923f2b2.png', 'dynamic/', 'image/png', 452629, 800, 800, 1.00000, 'profielfoto_sebastian_square.png');
INSERT INTO `_Mimoto_file` VALUES (2, '2017-09-20 18:46:35', NULL, 'aae0fc5579a253893659cfecf2035ed8.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg');
INSERT INTO `_Mimoto_file` VALUES (16, '2017-10-01 17:34:56', NULL, 'f2a40c0a01c0e9d77507784b736a7c85.jpg', 'dynamic/', 'image/jpeg', 143998, 1920, 823, 2.33293, 'peilingen_hoe.jpg');
INSERT INTO `_Mimoto_file` VALUES (18, '2017-10-09 21:28:06', NULL, '369c3b9c84324ced5be8e7daf2b6b187.jpeg', 'dynamic/', 'image/jpeg', 134734, 750, 1061, 0.70688, 'hilde.jpeg');
INSERT INTO `_Mimoto_file` VALUES (19, '2017-10-25 17:59:21', NULL, 'b15a1e49a7ae5c895b89455382e5dafc.png', 'dynamic/', 'image/png', 24970, 126, 126, 1.00000, 'sebastian.png');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form`;
CREATE TABLE `_Mimoto_form` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `manualSave` enum('0','1') DEFAULT NULL,
  `realtimeCollaborationMode` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customSubmit` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `method` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `target` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form` VALUES (5, '2017-09-20 18:48:28', NULL, 'article', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form` VALUES (6, '2017-09-21 09:11:25', NULL, 'page', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form` VALUES (7, '2017-09-21 09:24:44', NULL, 'element1', NULL, '0', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form` VALUES (8, '2017-09-21 09:24:59', NULL, 'element2', NULL, '0', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form` VALUES (9, '2017-09-21 12:13:19', NULL, 'comment', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form` VALUES (10, '2017-09-30 13:39:50', NULL, 'member', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form` VALUES (12, '2017-09-30 13:44:10', NULL, 'memberType', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form` VALUES (13, '2017-10-01 17:30:06', NULL, 'articleType', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_field_option
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_field_option`;
CREATE TABLE `_Mimoto_form_field_option` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `mappingLabel` varchar(255) DEFAULT NULL,
  `mappingValue` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_field_option
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_field_option` VALUES (1, '2017-09-21 09:25:22', NULL, 'form', 'Element 1', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_field_option` VALUES (2, '2017-09-21 09:25:32', NULL, 'form', 'Element 2', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_field_option` VALUES (7, '2017-10-02 10:21:31', NULL, 'selection', 'Article types', NULL, 'label', 'value');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_field_rules
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_field_rules`;
CREATE TABLE `_Mimoto_form_field_rules` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_field_validation
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_field_validation`;
CREATE TABLE `_Mimoto_form_field_validation` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `errorMessage` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `trigger` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_checkbox
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_checkbox`;
CREATE TABLE `_Mimoto_form_input_checkbox` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `option` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_colorpicker
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_colorpicker`;
CREATE TABLE `_Mimoto_form_input_colorpicker` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_datepicker
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_datepicker`;
CREATE TABLE `_Mimoto_form_input_datepicker` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `enableTime` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_dropdown
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_dropdown`;
CREATE TABLE `_Mimoto_form_input_dropdown` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_dropdown
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_dropdown` VALUES (2, '2017-10-02 10:21:03', NULL, 'Type', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_entity
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_entity`;
CREATE TABLE `_Mimoto_form_input_entity` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_entity
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_entity` VALUES (2, '2017-11-01 11:56:52', NULL, 'Case preview', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_image
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_image`;
CREATE TABLE `_Mimoto_form_input_image` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_image
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_image` VALUES (5, '2017-09-20 18:48:28', NULL, 'Main image', NULL);
INSERT INTO `_Mimoto_form_input_image` VALUES (8, '2017-10-25 17:58:36', NULL, 'Image', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_list
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_list`;
CREATE TABLE `_Mimoto_form_input_list` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_list
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_list` VALUES (1, '2017-09-21 09:20:45', NULL, 'Elements', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_multiselect
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_multiselect`;
CREATE TABLE `_Mimoto_form_input_multiselect` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `option` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_password
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_password`;
CREATE TABLE `_Mimoto_form_input_password` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_radiobutton
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_radiobutton`;
CREATE TABLE `_Mimoto_form_input_radiobutton` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_textblock
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_textblock`;
CREATE TABLE `_Mimoto_form_input_textblock` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `optional` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `regexp` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxchars` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_textblock
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textblock` VALUES (8, '2017-09-20 18:48:28', NULL, 'Lede', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textblock` VALUES (9, '2017-09-20 18:48:28', NULL, 'Body', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textblock` VALUES (10, '2017-09-21 12:13:19', NULL, 'Message', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textblock` VALUES (11, '2017-09-30 13:39:50', NULL, 'Biography', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textblock` VALUES (13, '2017-10-25 17:58:25', NULL, 'Body', NULL, NULL, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_textline
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_textline`;
CREATE TABLE `_Mimoto_form_input_textline` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_textline
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textline` VALUES (10, '2017-09-20 18:48:28', NULL, 'Title', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textline` VALUES (12, '2017-09-21 09:11:25', NULL, 'Title', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textline` VALUES (13, '2017-09-21 09:24:44', NULL, 'Title', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textline` VALUES (14, '2017-09-21 09:24:59', NULL, 'Label', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textline` VALUES (15, '2017-09-30 13:39:50', NULL, 'Topic', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textline` VALUES (18, '2017-09-30 13:44:10', NULL, 'Value', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textline` VALUES (19, '2017-09-30 14:16:19', NULL, 'Name', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textline` VALUES (20, '2017-10-01 16:44:04', NULL, 'Label', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textline` VALUES (21, '2017-10-01 17:30:06', NULL, 'Label', NULL, NULL, NULL);
INSERT INTO `_Mimoto_form_input_textline` VALUES (22, '2017-10-01 17:30:06', NULL, 'Value', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_video
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_video`;
CREATE TABLE `_Mimoto_form_input_video` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_layout_divider
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_divider`;
CREATE TABLE `_Mimoto_form_layout_divider` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_layout_groupend
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_groupend`;
CREATE TABLE `_Mimoto_form_layout_groupend` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_layout_groupend
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (5, '2017-09-20 18:48:28', NULL);
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (6, '2017-09-21 09:11:25', NULL);
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (7, '2017-09-21 09:24:44', NULL);
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (8, '2017-09-21 09:24:59', NULL);
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (9, '2017-09-21 12:13:19', NULL);
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (10, '2017-09-30 13:39:50', NULL);
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (12, '2017-09-30 13:44:10', NULL);
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (13, '2017-10-01 17:30:06', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_layout_groupstart
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_groupstart`;
CREATE TABLE `_Mimoto_form_layout_groupstart` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_layout_groupstart
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (5, '2017-09-20 18:48:28', NULL, NULL);
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (6, '2017-09-21 09:11:25', NULL, NULL);
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (7, '2017-09-21 09:24:44', NULL, NULL);
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (8, '2017-09-21 09:24:59', NULL, NULL);
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (9, '2017-09-21 12:13:19', NULL, NULL);
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (10, '2017-09-30 13:39:50', NULL, NULL);
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (12, '2017-09-30 13:44:10', NULL, NULL);
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (13, '2017-10-01 17:30:06', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_output_title
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_output_title`;
CREATE TABLE `_Mimoto_form_output_title` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_output_title
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_output_title` VALUES (5, '2017-09-20 18:48:28', NULL, 'Article', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 20 September 2017 18:48:28. Adjust, add, remove or change the fields as you feel fit!');
INSERT INTO `_Mimoto_form_output_title` VALUES (6, '2017-09-21 09:11:25', NULL, 'Page', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 21 September 2017 09:11:25. Adjust, add, remove or change the fields as you feel fit!');
INSERT INTO `_Mimoto_form_output_title` VALUES (7, '2017-09-21 09:24:44', NULL, 'Element1', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 21 September 2017 09:24:44. Adjust, add, remove or change the fields as you feel fit!');
INSERT INTO `_Mimoto_form_output_title` VALUES (8, '2017-09-21 09:24:59', NULL, 'Element2', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 21 September 2017 09:24:59. Adjust, add, remove or change the fields as you feel fit!');
INSERT INTO `_Mimoto_form_output_title` VALUES (9, '2017-09-21 12:13:19', NULL, 'Comment', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 21 September 2017 12:13:19. Adjust, add, remove or change the fields as you feel fit!');
INSERT INTO `_Mimoto_form_output_title` VALUES (10, '2017-09-30 13:39:50', NULL, 'Member', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 30 September 2017 13:39:50. Adjust, add, remove or change the fields as you feel fit!');
INSERT INTO `_Mimoto_form_output_title` VALUES (12, '2017-09-30 13:44:10', NULL, 'Member type', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 30 September 2017 13:44:10. Adjust, add, remove or change the fields as you feel fit!');
INSERT INTO `_Mimoto_form_output_title` VALUES (13, '2017-10-01 17:30:06', NULL, 'Article type', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 01 October 2017 17:30:06. Adjust, add, remove or change the fields as you feel fit!');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_formattingoption
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_formattingoption`;
CREATE TABLE `_Mimoto_formattingoption` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `tagName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `toolbar` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `jsOnAdd` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `jsOnEdit` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_formattingoption_attribute
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_formattingoption_attribute`;
CREATE TABLE `_Mimoto_formattingoption_attribute` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `size` int(10) unsigned DEFAULT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `aspectRatio` float(10,5) DEFAULT NULL,
  `originalName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_notification
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_notification`;
CREATE TABLE `_Mimoto_notification` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `category` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispatcher` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_notification
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_notification` VALUES (1, '2018-09-01 12:58:13', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.method</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #288)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (2, '2018-09-01 12:58:31', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.method</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #288)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (3, '2018-09-01 13:37:15', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.selection</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (4, '2018-09-01 13:38:33', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.dataset</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (5, '2018-09-01 13:40:10', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.dataset</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (6, '2018-09-01 13:40:21', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.instance</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (7, '2018-09-01 13:53:10', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.selections</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (8, '2018-09-01 13:53:45', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.selections</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (9, '2018-09-01 13:54:16', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.selections</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (10, '2018-09-01 13:54:18', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.selections</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (11, '2018-09-01 13:54:31', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.selections</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (12, '2018-09-01 13:54:40', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.selections</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (13, '2018-09-01 14:08:33', NULL, 'No such property', 'The property `<b>_Mimoto_api.2.selections</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #229)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (14, '2018-09-01 14:08:58', NULL, 'Incorrect value', 'The property \'_Mimoto_api.selections\' only allows \'_Mimoto_entityproperty\' (and not `_Mimoto_selection`)', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #183)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (15, '2018-09-01 14:08:59', NULL, 'Incorrect value', 'The property \'_Mimoto_api.selections\' only allows \'_Mimoto_entityproperty\' (and not `_Mimoto_selection`)', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #183)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (16, '2018-09-01 14:15:18', NULL, 'Incorrect value', 'The property \'_Mimoto_api.selections\' only allows \'_Mimoto_entityproperty\' (and not `_Mimoto_selection`)', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #183)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (17, '2018-09-01 17:45:53', NULL, 'Template `MimotoCMS_modules_UserRolePermissions` not found', 'I can\'t find the template you are looking for', 'error', 'Mimoto\\Aimless\\OutputService::getComponentFile (called from line #1093)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (18, '2018-09-01 17:47:44', NULL, 'Template `MimotoCMS_modules_UserRolePermissions` not found', 'I can\'t find the template you are looking for', 'error', 'Mimoto\\Aimless\\OutputService::getComponentFile (called from line #1093)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (19, '2018-09-01 18:10:29', NULL, 'Template `MimotoCMS_modules_UserRolePermissions-AllowedUserRole` not found', 'I can\'t find the template you are looking for', 'error', 'Mimoto\\Aimless\\OutputService::getComponentFile (called from line #1059)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (20, '2018-09-01 18:12:09', NULL, 'Template `MimotoCMS_modules_UserRolePermissions-AllowedUserRole` not found', 'I can\'t find the template you are looking for', 'error', 'Mimoto\\Aimless\\OutputService::getComponentFile (called from line #1059)', 'open');
INSERT INTO `_Mimoto_notification` VALUES (21, '2018-09-01 18:16:39', NULL, 'Template `MimotoCMS_pages_pages_Detail-AllowedUserRole` not found', 'I can\'t find the template you are looking for', 'error', 'Mimoto\\Aimless\\OutputService::getComponentFile (called from line #1059)', 'open');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_output
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_output`;
CREATE TABLE `_Mimoto_output` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `isRoot` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_output
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_output` VALUES (1, '2017-09-20 18:50:17', NULL, NULL);
INSERT INTO `_Mimoto_output` VALUES (2, '2017-09-20 19:00:51', NULL, NULL);
INSERT INTO `_Mimoto_output` VALUES (4, '2017-09-22 18:39:15', NULL, '0');
INSERT INTO `_Mimoto_output` VALUES (5, '2018-02-06 19:38:30', NULL, '0');
INSERT INTO `_Mimoto_output` VALUES (6, '2018-02-06 19:38:36', NULL, '0');
INSERT INTO `_Mimoto_output` VALUES (7, '2018-02-06 19:39:46', NULL, '0');
INSERT INTO `_Mimoto_output` VALUES (8, '2018-02-06 19:39:50', NULL, '0');
INSERT INTO `_Mimoto_output` VALUES (9, '2018-03-06 13:20:28', NULL, '0');
INSERT INTO `_Mimoto_output` VALUES (10, '2018-08-26 11:59:48', NULL, '0');
INSERT INTO `_Mimoto_output` VALUES (11, '2018-08-27 15:58:51', NULL, '0');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_output_container
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_output_container`;
CREATE TABLE `_Mimoto_output_container` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_output_container
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_output_container` VALUES (1, '2017-09-20 18:58:06', NULL, 'feed');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_page
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_page`;
CREATE TABLE `_Mimoto_page` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_page
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_page` VALUES (2, '2017-09-20 19:00:27', NULL, 'Article');
INSERT INTO `_Mimoto_page` VALUES (3, '2018-02-06 19:38:36', NULL, 'sdfsfsdfsfds');
INSERT INTO `_Mimoto_page` VALUES (4, '2018-02-06 19:39:50', NULL, 'sdfsdfsdfsdf');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_path_element
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_path_element`;
CREATE TABLE `_Mimoto_path_element` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `staticValue` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `varName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_path_element
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_path_element` VALUES (1, '2017-09-20 18:50:15', NULL, 'static', 'publisher', NULL);
INSERT INTO `_Mimoto_path_element` VALUES (2, '2017-09-20 19:00:27', NULL, 'static', 'publisher', NULL);
INSERT INTO `_Mimoto_path_element` VALUES (3, '2017-09-20 19:00:27', NULL, 'slash', NULL, NULL);
INSERT INTO `_Mimoto_path_element` VALUES (4, '2017-09-20 19:00:27', NULL, 'static', 'article', NULL);
INSERT INTO `_Mimoto_path_element` VALUES (5, '2017-09-20 19:00:27', NULL, 'slash', NULL, NULL);
INSERT INTO `_Mimoto_path_element` VALUES (6, '2017-09-20 19:00:27', NULL, 'var', '', 'nArticleId');
INSERT INTO `_Mimoto_path_element` VALUES (7, '2018-03-01 11:11:07', NULL, 'static', 'publisher', NULL);
INSERT INTO `_Mimoto_path_element` VALUES (8, '2018-03-06 13:20:28', NULL, 'static', 'publisher', NULL);
INSERT INTO `_Mimoto_path_element` VALUES (9, '2018-03-06 13:20:28', NULL, 'slash', NULL, NULL);
INSERT INTO `_Mimoto_path_element` VALUES (10, '2018-03-06 13:20:28', NULL, 'static', 'page', NULL);
INSERT INTO `_Mimoto_path_element` VALUES (11, '2018-03-06 13:20:28', NULL, 'slash', NULL, NULL);
INSERT INTO `_Mimoto_path_element` VALUES (13, '2018-03-06 13:20:42', NULL, 'var', NULL, 'nPageId');
INSERT INTO `_Mimoto_path_element` VALUES (14, '2018-08-31 14:10:21', NULL, 'static', 'api', NULL);
INSERT INTO `_Mimoto_path_element` VALUES (15, '2018-08-31 14:10:25', NULL, 'slash', NULL, NULL);
INSERT INTO `_Mimoto_path_element` VALUES (16, '2018-08-31 14:13:39', '2018-08-31 14:18:25', 'static', 'comment', NULL);
INSERT INTO `_Mimoto_path_element` VALUES (17, '2018-08-31 14:13:45', NULL, 'slash', NULL, NULL);
INSERT INTO `_Mimoto_path_element` VALUES (18, '2018-08-31 14:14:04', NULL, 'var', NULL, 'nId');
INSERT INTO `_Mimoto_path_element` VALUES (21, '2018-08-31 14:18:48', NULL, 'slash', NULL, NULL);
INSERT INTO `_Mimoto_path_element` VALUES (22, '2018-08-31 14:18:58', NULL, 'static', 'highlight', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_selection
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selection`;
CREATE TABLE `_Mimoto_selection` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_selection
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_selection` VALUES (1, '2017-09-20 18:52:38', NULL, 'allArticles', 'Choose an article');
INSERT INTO `_Mimoto_selection` VALUES (3, '2017-09-21 09:55:26', NULL, 'potentialPage', NULL);
INSERT INTO `_Mimoto_selection` VALUES (5, '2017-09-30 17:31:59', NULL, 'allMemberTypes', NULL);
INSERT INTO `_Mimoto_selection` VALUES (6, '2017-10-01 17:31:35', NULL, 'allArticleTypes', NULL);
INSERT INTO `_Mimoto_selection` VALUES (8, '2017-11-27 01:28:25', NULL, 'somePage', NULL);
INSERT INTO `_Mimoto_selection` VALUES (10, '2017-11-29 10:54:41', NULL, 'article', NULL);
INSERT INTO `_Mimoto_selection` VALUES (11, '2018-03-01 11:11:38', NULL, 'allRegularArticles', 'All regular articles');
INSERT INTO `_Mimoto_selection` VALUES (12, '2018-03-15 18:51:20', NULL, 'allElementsOfPage3', NULL);
INSERT INTO `_Mimoto_selection` VALUES (13, '2018-09-01 14:08:58', NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection` VALUES (14, '2018-09-01 14:08:59', NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection` VALUES (15, '2018-09-01 14:15:18', NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection` VALUES (17, '2018-09-01 14:16:43', '2018-09-01 14:33:03', 'Comment', 'xxx');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_selection_rule
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selection_rule`;
CREATE TABLE `_Mimoto_selection_rule` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `typeAsVar` int(1) DEFAULT NULL,
  `typeVarName` varchar(255) DEFAULT NULL,
  `idAsVar` int(1) DEFAULT NULL,
  `idVarName` varchar(255) DEFAULT NULL,
  `propertyAsVar` int(1) DEFAULT NULL,
  `propertyVarName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_selection_rule
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_selection_rule` VALUES (1, '2017-09-20 18:53:10', NULL, 0, 'dgdfgdgdf', NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (2, '2017-09-20 19:01:37', NULL, NULL, NULL, 1, 'nArticleId', NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (3, '2017-09-21 09:55:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (4, '2017-10-01 15:32:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (5, '2017-10-01 17:31:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (6, '2017-11-27 01:14:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (10, '2017-11-29 23:07:14', NULL, 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (11, '2018-03-01 11:12:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (12, '2018-03-15 18:51:34', NULL, 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (14, '2018-03-15 18:55:35', NULL, 1, '', NULL, NULL, NULL, NULL);
INSERT INTO `_Mimoto_selection_rule` VALUES (15, '2018-09-01 14:17:13', '2018-09-02 10:07:58', 0, NULL, 1, 'nId', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_selection_rule_value
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selection_rule_value`;
CREATE TABLE `_Mimoto_selection_rule_value` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `propertyName` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_selection_rule_value
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_selection_rule_value` VALUES (13, '2018-03-01 11:12:05', NULL, 'type', 'storyoftheday');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_service
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_service`;
CREATE TABLE `_Mimoto_service` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_service
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_service` VALUES (3, '2017-10-18 17:32:27', NULL, 'SuperSimpleMail', 'SuperSimpleMail/SuperSimpleMail.php', NULL);
INSERT INTO `_Mimoto_service` VALUES (4, '2018-09-01 12:52:18', NULL, 'Article', 'Article/Article.php', NULL);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_service_function
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_service_function`;
CREATE TABLE `_Mimoto_service_function` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_service_function
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_service_function` VALUES (1, '2017-10-18 16:18:51', NULL, 'SuperSimpleMail');
INSERT INTO `_Mimoto_service_function` VALUES (5, '2017-10-18 17:32:44', NULL, 'sendMail');
INSERT INTO `_Mimoto_service_function` VALUES (6, '2018-09-01 12:52:34', NULL, 'highlightComment');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_user
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_user`;
CREATE TABLE `_Mimoto_user` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `firstName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_user
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_user` VALUES (1, NULL, NULL, 'Sebastian', 'Kersten', 'sebastian@momkai.com', '{\"salt\":\"d2329282b91630f540cecd2af121a8b67b1d12d84f2766f8bb11f331b957e4f9\",\"iterations\":50000,\"hash\":\"5e2b2ca87196fd3e16bad6e2e663a9b66b0808d93ee97cb3bdeeeb7e4c34f79a\"}');
INSERT INTO `_Mimoto_user` VALUES (2, '2017-09-21 12:11:17', '2018-07-21 15:09:23', 'Hilde', 'Atalanta', 'hildeatalanta@gmail.com', '{\"salt\":\"25b0d9b27d7eddf0736fbfe8bb4fe7be37d4e144bea7d2c0d4a0f21329323d46\",\"iterations\":50000,\"hash\":\"41d7beb60f6b900369b95ea1f21ce94ed4d5949bda126d78b4edcd3102e21425\"}');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_user_role
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_user_role`;
CREATE TABLE `_Mimoto_user_role` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_user_role
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_user_role` VALUES (1, '2017-09-20 18:36:42', NULL, 'member');
INSERT INTO `_Mimoto_user_role` VALUES (2, '2018-07-21 15:05:55', NULL, 'teacher');
INSERT INTO `_Mimoto_user_role` VALUES (3, '2018-07-21 15:08:08', NULL, 'author');
COMMIT;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `lede` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of article
-- ----------------------------
BEGIN;
INSERT INTO `article` VALUES (1, '2017-09-20 18:45:38', '2018-08-27 15:58:38', 'Batterijen', '<p>De caissière in de supermarkt vraagt op een dag wat ik eigenlijk voor werk doe. Ik schrijf, zeg ik. Waarover? Over batterijen.</p><p>Ze trekt een vies gezicht. ‘Mijn zoontje zat laatst twee batterijen hard tegen elkaar aan te wrijven. Ze werden warm en ik was bang dat ze zouden ontploffen. Ik ben met ze naar buiten gerend en heb ze in de tuin gegooid.’</p><p>Ik antwoord, bijna automatisch: ‘In de tuin? Je kunt ze toch hier inleveren, in de bak bij de voordeur?’ Maar de batterijen leken haar te gevaarlijk om nog aan te raken.</p><h3>dsfsdfsdfsd</h3><p>En ze is niet de enige. We zien batterijen als een noodzakelijk kwaad dat inmiddels overal in huis te vinden is - in telefoons en laptops, accuboren en afstandsbedieningen, babyfoons en gehoorapparaten. We kunnen niet zonder, maar blij worden we er niet van.</p><p>Dit verhaal is voor mijn caissière en voor iedereen die bij het woord batterijen een ongemakkelijk gevoel krijgt. Ik begon ze zelf pas te begrijpen toen ik me serieus in batterijen verdiepte&nbsp;en ben pas echt overtuigd geraakt toen ik voor dit verhaal bij een Belgische batterijenrecyclingfabriek op bezoek ging.</p><p><em>Hier vind je mijn eerdere verhalen over batterijen.</em></p><p>Maar nu weet ik het zeker. Batterijen zijn de beste technologische oplossing die we nu hebben voor het echte giftige en explosieve probleem op deze wereld: olie.</p><p><br></p>', 'Batterijen zijn schadelijk voor het milieu, vertelt de overheid ons al jaren. Het is een achterhaalde en verkeerde boodschap. Batterijen maken niet alleen schone auto’s mogelijk, ze vormen ook een herbruikbare grondstoffenbron die steeds planeetvriendelijker wordt.3sdfsfsdfsdfsdfsfsdfsdf sdfsdfs df');
INSERT INTO `article` VALUES (2, '2017-09-24 12:07:20', NULL, 'Kijken: Hoe peil je een peiling? Ik geef 3 tips', '<p>dfgsdgfdgsdfgsd</p>', '<p>Brexit, Donald Trump, keer op keer zaten de peilingen ernaast. Toch vliegen ze je ook nu weer om de oren. Daarom: 3 tips waardoor je beter weet wat je aan peilingen hebt in de aankomende Tweede Kamerverkiezingen.</p>');
COMMIT;

-- ----------------------------
-- Table structure for articleType
-- ----------------------------
DROP TABLE IF EXISTS `articleType`;
CREATE TABLE `articleType` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of articleType
-- ----------------------------
BEGIN;
INSERT INTO `articleType` VALUES (1, '2017-10-01 17:30:28', NULL, 'Verhaal van de dag', 'storyoftheday');
INSERT INTO `articleType` VALUES (2, '2017-10-01 17:30:45', NULL, 'Explainer', 'explainer');
INSERT INTO `articleType` VALUES (3, '2017-10-01 17:30:52', NULL, 'Column', 'column');
INSERT INTO `articleType` VALUES (4, '2018-02-06 19:40:28', NULL, 'sdfsfdsdf', NULL);
COMMIT;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `message` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of comment
-- ----------------------------
BEGIN;
INSERT INTO `comment` VALUES (12, '2017-09-21 13:39:05', NULL, 'Hoi Maaike');
INSERT INTO `comment` VALUES (13, '2017-09-21 13:39:11', NULL, 'Hoi Sebastian');
INSERT INTO `comment` VALUES (15, '2017-10-04 10:12:03', NULL, 'sdhfsjkfhjksfsdf');
COMMIT;

-- ----------------------------
-- Table structure for element1
-- ----------------------------
DROP TABLE IF EXISTS `element1`;
CREATE TABLE `element1` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of element1
-- ----------------------------
BEGIN;
INSERT INTO `element1` VALUES (2, '2017-09-21 09:47:37', NULL, 'aaa', NULL);
INSERT INTO `element1` VALUES (3, '2017-10-25 17:56:50', NULL, 'dshfkjadshfkjashkdfasdf sadfas dfsad f', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>');
COMMIT;

-- ----------------------------
-- Table structure for element2
-- ----------------------------
DROP TABLE IF EXISTS `element2`;
CREATE TABLE `element2` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of element2
-- ----------------------------
BEGIN;
INSERT INTO `element2` VALUES (2, '2017-09-24 14:55:31', NULL, 'xxx');
INSERT INTO `element2` VALUES (3, '2017-10-25 17:45:14', NULL, 'fdgdgdgdfgdfg');
INSERT INTO `element2` VALUES (21, '2018-03-10 16:53:43', NULL, 'ggg');
INSERT INTO `element2` VALUES (24, '2018-03-10 17:11:13', NULL, 'd');
COMMIT;

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `mimoto_userid` int(10) DEFAULT NULL,
  `biography` text COLLATE utf8_unicode_ci,
  `topic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of member
-- ----------------------------
BEGIN;
INSERT INTO `member` VALUES (1, '2017-09-30 14:06:38', NULL, NULL, '<p>Thalia Verkade (1979) studeerde Slavische Talen en Culturen in Groningen en Moskou en Mediawetenschappen in Berlijn. Ze was eerder redacteur bij nrc.next en correspondent in Moskou voor NRC Handelsblad.</p>', 'Mobiliteit', 'Thalia', NULL);
INSERT INTO `member` VALUES (2, '2018-07-14 16:07:49', NULL, NULL, '<p>Something</p>', 'Equal oppertunity', 'Supertaboo', NULL);
COMMIT;

-- ----------------------------
-- Table structure for memberType
-- ----------------------------
DROP TABLE IF EXISTS `memberType`;
CREATE TABLE `memberType` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of memberType
-- ----------------------------
BEGIN;
INSERT INTO `memberType` VALUES (1, '2017-09-30 13:45:16', NULL, 'author', 'Author');
INSERT INTO `memberType` VALUES (2, '2017-09-30 13:45:22', NULL, 'reader', 'Reader');
INSERT INTO `memberType` VALUES (3, '2017-09-30 13:46:12', NULL, 'editor', 'Editor');
COMMIT;

-- ----------------------------
-- Table structure for page
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of page
-- ----------------------------
BEGIN;
INSERT INTO `page` VALUES (1, '2017-09-21 09:11:43', NULL, 'Potential');
INSERT INTO `page` VALUES (3, '2017-09-24 14:55:18', NULL, 'aaaaa');
INSERT INTO `page` VALUES (4, '2018-02-06 19:40:09', NULL, 'sdfsdfsafsdf');
INSERT INTO `page` VALUES (6, '2018-02-11 13:14:01', NULL, 'sdfsfdsdfsdf');
INSERT INTO `page` VALUES (8, '2018-02-11 13:16:29', NULL, 'sfsdfsd');
INSERT INTO `page` VALUES (9, '2018-02-11 13:16:37', NULL, 'sdfsdfsdf');
COMMIT;

-- ----------------------------
-- Table structure for xxx
-- ----------------------------
DROP TABLE IF EXISTS `xxx`;
CREATE TABLE `xxx` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for xxxxxr
-- ----------------------------
DROP TABLE IF EXISTS `xxxxxr`;
CREATE TABLE `xxxxxr` (
  `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mimoto_created` datetime DEFAULT NULL,
  `mimoto_modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mimoto_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
