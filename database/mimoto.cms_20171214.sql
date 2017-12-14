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

 Date: 14/12/2017 12:06:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for |Mimoto_component|_displaycomponentG
-- ----------------------------
DROP TABLE IF EXISTS `|Mimoto_component|_displaycomponentG`;
CREATE TABLE `|Mimoto_component|_displaycomponentG` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_action
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_action`;
CREATE TABLE `_Mimoto_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_action
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_action` VALUES (108, 'Send Slack message when title changes', 'updated', '2017-11-28 13:27:06');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_action_conditional
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_action_conditional`;
CREATE TABLE `_Mimoto_action_conditional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `value1` varchar(255) DEFAULT NULL,
  `value2` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_action_conditional
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_action_conditional` VALUES (43, 'changedInto', NULL, NULL, '2017-11-26 15:41:05');
INSERT INTO `_Mimoto_action_conditional` VALUES (44, 'notEquals', 'hallo', NULL, '2017-11-26 15:49:31');
INSERT INTO `_Mimoto_action_conditional` VALUES (45, 'didNotChange', NULL, NULL, '2017-11-26 15:53:59');
INSERT INTO `_Mimoto_action_conditional` VALUES (46, NULL, NULL, NULL, '2017-11-26 16:56:09');
INSERT INTO `_Mimoto_action_conditional` VALUES (47, NULL, NULL, NULL, '2017-11-26 16:57:25');
INSERT INTO `_Mimoto_action_conditional` VALUES (48, NULL, NULL, NULL, '2017-11-26 17:05:16');
INSERT INTO `_Mimoto_action_conditional` VALUES (49, 'changedFrom', NULL, NULL, '2017-11-26 17:08:24');
INSERT INTO `_Mimoto_action_conditional` VALUES (50, 'changedFromInto', 'test1', 'test2', '2017-11-26 17:09:17');
INSERT INTO `_Mimoto_action_conditional` VALUES (52, 'changedInto', '...', NULL, '2017-11-26 17:47:34');
INSERT INTO `_Mimoto_action_conditional` VALUES (53, NULL, NULL, NULL, '2017-11-26 23:16:00');
INSERT INTO `_Mimoto_action_conditional` VALUES (54, 'contains', '\\040sh\\040it\\040', NULL, '2017-11-26 23:16:05');
INSERT INTO `_Mimoto_action_conditional` VALUES (55, NULL, NULL, NULL, '2017-11-27 01:32:35');
INSERT INTO `_Mimoto_action_conditional` VALUES (56, 'changedInto', 'xxx', NULL, '2017-11-27 11:48:48');
INSERT INTO `_Mimoto_action_conditional` VALUES (57, 'contains', '\\040shit\\040', NULL, '2017-11-27 11:55:03');
INSERT INTO `_Mimoto_action_conditional` VALUES (58, 'changedInto', 'xxx', NULL, '2017-11-27 12:12:57');
INSERT INTO `_Mimoto_action_conditional` VALUES (59, 'changedFromInto', 'xxx', 'yyy', '2017-11-27 13:00:50');
INSERT INTO `_Mimoto_action_conditional` VALUES (60, 'contains', '\\040shit\\040', NULL, '2017-11-27 18:40:34');
INSERT INTO `_Mimoto_action_conditional` VALUES (61, 'changedFromInto', NULL, NULL, '2017-11-27 18:48:28');
INSERT INTO `_Mimoto_action_conditional` VALUES (62, 'contains', '\\040shit\\040', NULL, '2017-11-28 13:27:25');
INSERT INTO `_Mimoto_action_conditional` VALUES (63, 'changed', NULL, NULL, '2017-11-28 13:39:02');
INSERT INTO `_Mimoto_action_conditional` VALUES (64, 'changedFromInto', 'xxx', 'yyy', '2017-11-29 12:25:38');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_action_setting
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_action_setting`;
CREATE TABLE `_Mimoto_action_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_action_setting
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_action_setting` VALUES (3, 'channel', 'mimoto_notifications', '2017-11-25 18:00:01');
INSERT INTO `_Mimoto_action_setting` VALUES (8, 'channel', 'mimoto_notifications', '2017-11-26 15:49:51');
INSERT INTO `_Mimoto_action_setting` VALUES (9, 'message', 'Hallo from `{{title}}`', '2017-11-26 15:50:08');
INSERT INTO `_Mimoto_action_setting` VALUES (10, 'channel', 'mimoto_notifications', '2017-11-26 17:48:17');
INSERT INTO `_Mimoto_action_setting` VALUES (11, 'message', 'This is an easter egg triggered by the article with title = ```{{title}}```', '2017-11-26 17:48:57');
INSERT INTO `_Mimoto_action_setting` VALUES (12, 'channel', 'mimoto_notifications', '2017-11-27 11:49:11');
INSERT INTO `_Mimoto_action_setting` VALUES (13, 'message', 'New title is {{title}}', '2017-11-27 11:49:25');
INSERT INTO `_Mimoto_action_setting` VALUES (14, 'channel', 'mimoto_notifications', '2017-11-27 11:55:33');
INSERT INTO `_Mimoto_action_setting` VALUES (15, 'message', 'Artikel title veranderd in {{title}}', '2017-11-27 11:55:54');
INSERT INTO `_Mimoto_action_setting` VALUES (16, 'channel', 'mimoto_notifications', '2017-11-27 12:13:18');
INSERT INTO `_Mimoto_action_setting` VALUES (17, 'message', 'Artikel aangepast in {{title}}', '2017-11-27 12:13:33');
INSERT INTO `_Mimoto_action_setting` VALUES (18, 'channel', 'mimoto_notifications', '2017-11-27 13:01:40');
INSERT INTO `_Mimoto_action_setting` VALUES (19, 'message', 'Title is aangepast in ```{{title}}```', '2017-11-27 13:01:59');
INSERT INTO `_Mimoto_action_setting` VALUES (20, 'channel', 'mimoto_notifications', '2017-11-27 18:41:23');
INSERT INTO `_Mimoto_action_setting` VALUES (21, 'message', 'Artikel `{{title}}` is aangepast', '2017-11-27 18:42:51');
INSERT INTO `_Mimoto_action_setting` VALUES (22, 'channel', 'mimoto_notifications', '2017-11-28 13:28:08');
INSERT INTO `_Mimoto_action_setting` VALUES (23, 'message', 'Article with title = ```{{title}}``` changed! ```{{lede}}```', '2017-11-28 13:28:41');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_component
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component`;
CREATE TABLE `_Mimoto_component` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_component
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component` VALUES (1, 'Article', 'layout', '2017-09-20 18:39:56');
INSERT INTO `_Mimoto_component` VALUES (2, 'Feed', 'layout', '2017-09-20 18:40:21');
INSERT INTO `_Mimoto_component` VALUES (3, 'FeedItem', 'component', '2017-09-20 18:58:27');
INSERT INTO `_Mimoto_component` VALUES (4, 'Conversation', 'component', '2017-09-20 19:06:26');
INSERT INTO `_Mimoto_component` VALUES (5, 'Comment', 'component', '2017-09-20 19:06:34');
INSERT INTO `_Mimoto_component` VALUES (6, 'displaycomponentG', 'component', '2017-11-20 13:58:44');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_component_conditional
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component_conditional`;
CREATE TABLE `_Mimoto_component_conditional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_component_container
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component_container`;
CREATE TABLE `_Mimoto_component_container` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_component_container
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component_container` VALUES (1, 'feed', '2017-09-20 18:40:37');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_component_template
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component_template`;
CREATE TABLE `_Mimoto_component_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_component_template
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component_template` VALUES (1, 'publisher/Article/Article.twig', '2017-09-20 18:39:59');
INSERT INTO `_Mimoto_component_template` VALUES (2, 'publisher/Feed/Feed.twig', '2017-09-20 18:40:24');
INSERT INTO `_Mimoto_component_template` VALUES (3, 'publisher/FeedItem/FeedItem.twig', '2017-09-20 18:58:34');
INSERT INTO `_Mimoto_component_template` VALUES (4, 'publisher/Conversation/Conversation.twig', '2017-09-20 19:06:36');
INSERT INTO `_Mimoto_component_template` VALUES (5, 'publisher/Conversation/Message/Message.twig', '2017-09-20 19:06:53');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_connection
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_connection`;
CREATE TABLE `_Mimoto_connection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_entity_type_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_property_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_entity_type_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2155 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_connection
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_connection` VALUES (3, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--users', '_Mimoto_user', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (15, '_Mimoto_user', '1', '_Mimoto_user--avatar', '_Mimoto_file', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (16, '_Mimoto_user', '1', '_Mimoto_user--roles', '_Mimoto_user_role', '_Mimoto_user_role-contenteditor', 1);
INSERT INTO `_Mimoto_connection` VALUES (20, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--userRoles', '_Mimoto_user_role', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (21, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (22, '_Mimoto_component', '1', '_Mimoto_component--templates', '_Mimoto_component_template', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (23, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (24, '_Mimoto_component', '2', '_Mimoto_component--templates', '_Mimoto_component_template', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (25, '_Mimoto_component', '2', '_Mimoto_component--containers', '_Mimoto_component_container', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (26, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (27, '_Mimoto_entityproperty', '1', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (28, '_Mimoto_entityproperty', '1', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (29, '_Mimoto_entityproperty', '1', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (30, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (31, '_Mimoto_entityproperty', '2', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (32, '_Mimoto_entityproperty', '2', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '5', 1);
INSERT INTO `_Mimoto_connection` VALUES (33, '_Mimoto_entityproperty', '2', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '6', 2);
INSERT INTO `_Mimoto_connection` VALUES (34, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '2', 2);
INSERT INTO `_Mimoto_connection` VALUES (35, '_Mimoto_entitypropertysetting', '7', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', 0);
INSERT INTO `_Mimoto_connection` VALUES (36, '_Mimoto_entityproperty', '3', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (37, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '3', 3);
INSERT INTO `_Mimoto_connection` VALUES (38, '_Mimoto_entityproperty', '4', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (39, '_Mimoto_entityproperty', '4', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '9', 1);
INSERT INTO `_Mimoto_connection` VALUES (40, '_Mimoto_entityproperty', '4', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '10', 2);
INSERT INTO `_Mimoto_connection` VALUES (41, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '4', 4);
INSERT INTO `_Mimoto_connection` VALUES (46, '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-bold', 0);
INSERT INTO `_Mimoto_connection` VALUES (47, '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-italic', 1);
INSERT INTO `_Mimoto_connection` VALUES (48, '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-underline', 2);
INSERT INTO `_Mimoto_connection` VALUES (49, '_Mimoto_entityproperty', '6', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '14', 0);
INSERT INTO `_Mimoto_connection` VALUES (50, '_Mimoto_entityproperty', '6', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '15', 1);
INSERT INTO `_Mimoto_connection` VALUES (51, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '6', 5);
INSERT INTO `_Mimoto_connection` VALUES (67, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (68, '_Mimoto_dataset', '1', '_Mimoto_dataset--data', '1', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (69, '1', '1', '3', '_Mimoto_file', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (113, '_Mimoto_form_input_textline', '10', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (115, '_Mimoto_form_input_textblock', '8', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (116, '_Mimoto_form_input_image', '5', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (117, '_Mimoto_form_input_textblock', '9', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (118, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_output_title', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (119, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '5', 1);
INSERT INTO `_Mimoto_connection` VALUES (120, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '10', 2);
INSERT INTO `_Mimoto_connection` VALUES (122, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '8', 4);
INSERT INTO `_Mimoto_connection` VALUES (123, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_image', '5', 5);
INSERT INTO `_Mimoto_connection` VALUES (124, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '9', 6);
INSERT INTO `_Mimoto_connection` VALUES (125, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '5', 7);
INSERT INTO `_Mimoto_connection` VALUES (126, '_Mimoto_entity', '1', '_Mimoto_entity--forms', '_Mimoto_form', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (127, '_Mimoto_dataset', '1', '_Mimoto_dataset--form', '_Mimoto_form', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (128, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--pages', '_Mimoto_route', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (129, '_Mimoto_route', '1', '_Mimoto_route--path', '_Mimoto_route_path_element', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (130, '_Mimoto_route', '1', '_Mimoto_route--output', '_Mimoto_output', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (134, '_Mimoto_output', '1', '_Mimoto_entity--component', '_Mimoto_component', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (135, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (136, '_Mimoto_selection', '1', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (141, '_Mimoto_output', '1', '_Mimoto_output--containers', '_Mimoto_output_container', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (142, '_Mimoto_output_container', '1', '_Mimoto_output_container--selection', '_Mimoto_selection', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (143, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (144, '_Mimoto_component', '3', '_Mimoto_component--templates', '_Mimoto_component_template', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (145, '_Mimoto_output_container', '1', '_Mimoto_output_container--component', '_Mimoto_component', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (148, '_Mimoto_route', '2', '_Mimoto_route--path', '_Mimoto_route_path_element', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (149, '_Mimoto_route', '2', '_Mimoto_route--path', '_Mimoto_route_path_element', '3', 1);
INSERT INTO `_Mimoto_connection` VALUES (150, '_Mimoto_route', '2', '_Mimoto_route--path', '_Mimoto_route_path_element', '4', 2);
INSERT INTO `_Mimoto_connection` VALUES (151, '_Mimoto_route', '2', '_Mimoto_route--path', '_Mimoto_route_path_element', '5', 3);
INSERT INTO `_Mimoto_connection` VALUES (152, '_Mimoto_route', '2', '_Mimoto_route--path', '_Mimoto_route_path_element', '6', 4);
INSERT INTO `_Mimoto_connection` VALUES (153, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--pages', '_Mimoto_route', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (154, '_Mimoto_route', '2', '_Mimoto_route--output', '_Mimoto_output', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (155, '_Mimoto_output', '2', '_Mimoto_entity--component', '_Mimoto_component', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (161, '_Mimoto_user', '1', '_Mimoto_user--roles', '_Mimoto_user_role', '1', 2);
INSERT INTO `_Mimoto_connection` VALUES (163, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '4', 3);
INSERT INTO `_Mimoto_connection` VALUES (164, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (165, '_Mimoto_component', '4', '_Mimoto_component--templates', '_Mimoto_component_template', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (166, '_Mimoto_component', '5', '_Mimoto_component--templates', '_Mimoto_component_template', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (167, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (168, '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '16', 0);
INSERT INTO `_Mimoto_connection` VALUES (169, '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '17', 1);
INSERT INTO `_Mimoto_connection` VALUES (170, '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '18', 2);
INSERT INTO `_Mimoto_connection` VALUES (171, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (172, '_Mimoto_entityproperty', '8', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '19', 0);
INSERT INTO `_Mimoto_connection` VALUES (173, '_Mimoto_entityproperty', '8', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '20', 1);
INSERT INTO `_Mimoto_connection` VALUES (174, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '8', 1);
INSERT INTO `_Mimoto_connection` VALUES (180, '_Mimoto_route', '1', '_Mimoto_route--allowedUserRoles', '_Mimoto_user_role', '_Mimoto_user_role-owner', 0);
INSERT INTO `_Mimoto_connection` VALUES (181, '_Mimoto_route', '1', '_Mimoto_route--allowedUserRoles', '_Mimoto_user_role', '_Mimoto_user_role-superuser', 1);
INSERT INTO `_Mimoto_connection` VALUES (182, '_Mimoto_route', '1', '_Mimoto_route--allowedUserRoles', '_Mimoto_user_role', '1', 3);
INSERT INTO `_Mimoto_connection` VALUES (183, '_Mimoto_route', '1', '_Mimoto_route--allowedUserRoles', '_Mimoto_user_role', '_Mimoto_user_role-admin', 2);
INSERT INTO `_Mimoto_connection` VALUES (190, '_Mimoto_entityproperty', '10', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '24', 0);
INSERT INTO `_Mimoto_connection` VALUES (191, '_Mimoto_entityproperty', '10', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '25', 1);
INSERT INTO `_Mimoto_connection` VALUES (192, '_Mimoto_entityproperty', '10', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '26', 2);
INSERT INTO `_Mimoto_connection` VALUES (194, '_Mimoto_entityproperty', '11', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '27', 0);
INSERT INTO `_Mimoto_connection` VALUES (195, '_Mimoto_entityproperty', '11', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '28', 1);
INSERT INTO `_Mimoto_connection` VALUES (196, '_Mimoto_entityproperty', '11', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '29', 2);
INSERT INTO `_Mimoto_connection` VALUES (198, '_Mimoto_entityproperty', '12', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '30', 0);
INSERT INTO `_Mimoto_connection` VALUES (199, '_Mimoto_entityproperty', '12', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '31', 1);
INSERT INTO `_Mimoto_connection` VALUES (200, '_Mimoto_entityproperty', '12', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '32', 2);
INSERT INTO `_Mimoto_connection` VALUES (202, '_Mimoto_entityproperty', '13', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '33', 0);
INSERT INTO `_Mimoto_connection` VALUES (203, '_Mimoto_entityproperty', '13', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '34', 1);
INSERT INTO `_Mimoto_connection` VALUES (204, '_Mimoto_entityproperty', '13', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '35', 2);
INSERT INTO `_Mimoto_connection` VALUES (206, '_Mimoto_entityproperty', '14', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '36', 0);
INSERT INTO `_Mimoto_connection` VALUES (207, '_Mimoto_entityproperty', '14', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '37', 1);
INSERT INTO `_Mimoto_connection` VALUES (208, '_Mimoto_entityproperty', '14', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '38', 2);
INSERT INTO `_Mimoto_connection` VALUES (210, '_Mimoto_entityproperty', '15', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '39', 0);
INSERT INTO `_Mimoto_connection` VALUES (211, '_Mimoto_entityproperty', '15', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '40', 1);
INSERT INTO `_Mimoto_connection` VALUES (212, '_Mimoto_entityproperty', '15', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '41', 2);
INSERT INTO `_Mimoto_connection` VALUES (215, '_Mimoto_entityproperty', '16', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '43', 1);
INSERT INTO `_Mimoto_connection` VALUES (216, '_Mimoto_entityproperty', '16', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '44', 2);
INSERT INTO `_Mimoto_connection` VALUES (227, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (228, '_Mimoto_entityproperty', '19', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '51', 0);
INSERT INTO `_Mimoto_connection` VALUES (229, '_Mimoto_entityproperty', '19', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '52', 1);
INSERT INTO `_Mimoto_connection` VALUES (230, '_Mimoto_entityproperty', '19', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '53', 2);
INSERT INTO `_Mimoto_connection` VALUES (231, '_Mimoto_entity', '3', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '19', 0);
INSERT INTO `_Mimoto_connection` VALUES (232, '_Mimoto_entityproperty', '20', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '54', 0);
INSERT INTO `_Mimoto_connection` VALUES (233, '_Mimoto_entityproperty', '20', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '55', 1);
INSERT INTO `_Mimoto_connection` VALUES (234, '_Mimoto_entity', '3', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '20', 1);
INSERT INTO `_Mimoto_connection` VALUES (235, '_Mimoto_form_input_textline', '12', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '19', 0);
INSERT INTO `_Mimoto_connection` VALUES (236, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_output_title', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (237, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '6', 1);
INSERT INTO `_Mimoto_connection` VALUES (238, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '12', 2);
INSERT INTO `_Mimoto_connection` VALUES (239, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '6', 4);
INSERT INTO `_Mimoto_connection` VALUES (240, '_Mimoto_entity', '3', '_Mimoto_entity--forms', '_Mimoto_form', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (241, '_Mimoto_dataset', '2', '_Mimoto_dataset--form', '_Mimoto_form', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (242, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (243, '_Mimoto_dataset', '2', '_Mimoto_dataset--data', '3', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (244, '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_input_list', '1', 3);
INSERT INTO `_Mimoto_connection` VALUES (245, '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--value', '_Mimoto_entityproperty', '20', 0);
INSERT INTO `_Mimoto_connection` VALUES (246, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '4', 3);
INSERT INTO `_Mimoto_connection` VALUES (247, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (248, '_Mimoto_entityproperty', '21', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '56', 0);
INSERT INTO `_Mimoto_connection` VALUES (249, '_Mimoto_entityproperty', '21', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '57', 1);
INSERT INTO `_Mimoto_connection` VALUES (250, '_Mimoto_entityproperty', '21', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '58', 2);
INSERT INTO `_Mimoto_connection` VALUES (251, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '21', 0);
INSERT INTO `_Mimoto_connection` VALUES (252, '_Mimoto_form_input_textline', '13', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '21', 0);
INSERT INTO `_Mimoto_connection` VALUES (253, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_output_title', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (254, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '7', 1);
INSERT INTO `_Mimoto_connection` VALUES (255, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '13', 2);
INSERT INTO `_Mimoto_connection` VALUES (256, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '7', 5);
INSERT INTO `_Mimoto_connection` VALUES (257, '_Mimoto_entity', '4', '_Mimoto_entity--forms', '_Mimoto_form', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (258, '_Mimoto_entityproperty', '22', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '59', 0);
INSERT INTO `_Mimoto_connection` VALUES (259, '_Mimoto_entityproperty', '22', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '60', 1);
INSERT INTO `_Mimoto_connection` VALUES (260, '_Mimoto_entityproperty', '22', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '61', 2);
INSERT INTO `_Mimoto_connection` VALUES (261, '_Mimoto_entity', '5', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '22', 0);
INSERT INTO `_Mimoto_connection` VALUES (262, '_Mimoto_form_input_textline', '14', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '22', 0);
INSERT INTO `_Mimoto_connection` VALUES (263, '_Mimoto_form', '8', '_Mimoto_form--fields', '_Mimoto_form_output_title', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (264, '_Mimoto_form', '8', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '8', 1);
INSERT INTO `_Mimoto_connection` VALUES (265, '_Mimoto_form', '8', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '14', 2);
INSERT INTO `_Mimoto_connection` VALUES (266, '_Mimoto_form', '8', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '8', 3);
INSERT INTO `_Mimoto_connection` VALUES (267, '_Mimoto_entity', '5', '_Mimoto_entity--forms', '_Mimoto_form', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (268, '_Mimoto_form_field_option', '1', '_Mimoto_form_field_option--form', '_Mimoto_form', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (269, '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--options', '_Mimoto_form_field_option', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (270, '_Mimoto_form_field_option', '2', '_Mimoto_form_field_option--form', '_Mimoto_form', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (271, '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--options', '_Mimoto_form_field_option', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (273, '3', '1', '20', '4', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (274, '3', '1', '20', '5', '1', 1);
INSERT INTO `_Mimoto_connection` VALUES (275, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (276, '_Mimoto_selection', '3', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (277, '_Mimoto_selection_rule', '3', '_Mimoto_selection_rule--type', '_Mimoto_entity', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (286, '_Mimoto_user', '2', '_Mimoto_user--roles', '_Mimoto_user_role', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (287, '_Mimoto_user', '2', '_Mimoto_user--roles', '_Mimoto_user_role', '_Mimoto_user_role-contenteditor', 1);
INSERT INTO `_Mimoto_connection` VALUES (288, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--users', '_Mimoto_user', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (293, '_Mimoto_form_input_textblock', '10', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (294, '_Mimoto_form', '9', '_Mimoto_form--fields', '_Mimoto_form_output_title', '9', 0);
INSERT INTO `_Mimoto_connection` VALUES (295, '_Mimoto_form', '9', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '9', 1);
INSERT INTO `_Mimoto_connection` VALUES (296, '_Mimoto_form', '9', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '10', 2);
INSERT INTO `_Mimoto_connection` VALUES (297, '_Mimoto_form', '9', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '9', 3);
INSERT INTO `_Mimoto_connection` VALUES (298, '_Mimoto_entity', '2', '_Mimoto_entity--forms', '_Mimoto_form', '9', 0);
INSERT INTO `_Mimoto_connection` VALUES (314, '2', '12', '8', '_Mimoto_user', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (315, '1', '1', '6', '2', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (316, '2', '13', '8', '_Mimoto_user', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (317, '1', '1', '6', '2', '13', 1);
INSERT INTO `_Mimoto_connection` VALUES (318, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '6', 5);
INSERT INTO `_Mimoto_connection` VALUES (319, '_Mimoto_entityproperty', '23', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '62', 0);
INSERT INTO `_Mimoto_connection` VALUES (320, '_Mimoto_entityproperty', '23', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '63', 1);
INSERT INTO `_Mimoto_connection` VALUES (321, '_Mimoto_entityproperty', '23', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '64', 2);
INSERT INTO `_Mimoto_connection` VALUES (322, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '23', 2);
INSERT INTO `_Mimoto_connection` VALUES (323, '_Mimoto_entityproperty', '24', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '65', 0);
INSERT INTO `_Mimoto_connection` VALUES (324, '_Mimoto_entityproperty', '24', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '66', 1);
INSERT INTO `_Mimoto_connection` VALUES (325, '_Mimoto_entityproperty', '24', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '67', 2);
INSERT INTO `_Mimoto_connection` VALUES (326, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '24', 1);
INSERT INTO `_Mimoto_connection` VALUES (327, '_Mimoto_entityproperty', '25', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '68', 0);
INSERT INTO `_Mimoto_connection` VALUES (328, '_Mimoto_entityproperty', '25', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '69', 1);
INSERT INTO `_Mimoto_connection` VALUES (329, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '25', 3);
INSERT INTO `_Mimoto_connection` VALUES (330, '_Mimoto_entitypropertysetting', '68', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (346, '_Mimoto_output', '5', '_Mimoto_entity--component', '_Mimoto_component', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (350, '_Mimoto_output', '1', '_Mimoto_output--component', '_Mimoto_component', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (359, '_Mimoto_dataset', '1', '_Mimoto_dataset--data', '1', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (365, '_Mimoto_dataset', '2', '_Mimoto_dataset--data', '3', '3', 1);
INSERT INTO `_Mimoto_connection` VALUES (366, '3', '3', '20', '5', '2', 2);
INSERT INTO `_Mimoto_connection` VALUES (380, '_Mimoto_output', '1', '_Mimoto_output--dataset', '_Mimoto_dataset', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (525, '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-header', 7);
INSERT INTO `_Mimoto_connection` VALUES (528, '_Mimoto_output', '2', '_Mimoto_output--component', '_Mimoto_component', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (529, '_Mimoto_form_input_textline', '15', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '24', 0);
INSERT INTO `_Mimoto_connection` VALUES (530, '_Mimoto_form_input_textblock', '11', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '23', 0);
INSERT INTO `_Mimoto_connection` VALUES (531, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_output_title', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (532, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '10', 1);
INSERT INTO `_Mimoto_connection` VALUES (533, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '15', 3);
INSERT INTO `_Mimoto_connection` VALUES (534, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '11', 4);
INSERT INTO `_Mimoto_connection` VALUES (535, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '10', 5);
INSERT INTO `_Mimoto_connection` VALUES (536, '_Mimoto_entity', '6', '_Mimoto_entity--forms', '_Mimoto_form', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (537, '_Mimoto_dataset', '3', '_Mimoto_dataset--form', '_Mimoto_form', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (538, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (539, '_Mimoto_entityproperty', '27', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '71', 0);
INSERT INTO `_Mimoto_connection` VALUES (540, '_Mimoto_entityproperty', '27', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '72', 1);
INSERT INTO `_Mimoto_connection` VALUES (541, '_Mimoto_entityproperty', '27', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '73', 2);
INSERT INTO `_Mimoto_connection` VALUES (542, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '27', 4);
INSERT INTO `_Mimoto_connection` VALUES (543, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '7', 6);
INSERT INTO `_Mimoto_connection` VALUES (544, '_Mimoto_entityproperty', '28', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '74', 0);
INSERT INTO `_Mimoto_connection` VALUES (545, '_Mimoto_entityproperty', '28', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '75', 1);
INSERT INTO `_Mimoto_connection` VALUES (546, '_Mimoto_entityproperty', '28', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '76', 2);
INSERT INTO `_Mimoto_connection` VALUES (547, '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '28', 1);
INSERT INTO `_Mimoto_connection` VALUES (560, '_Mimoto_form_input_textline', '18', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '28', 0);
INSERT INTO `_Mimoto_connection` VALUES (561, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_output_title', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (562, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '12', 1);
INSERT INTO `_Mimoto_connection` VALUES (563, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '18', 3);
INSERT INTO `_Mimoto_connection` VALUES (564, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '12', 4);
INSERT INTO `_Mimoto_connection` VALUES (565, '_Mimoto_entity', '7', '_Mimoto_entity--forms', '_Mimoto_form', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (566, '_Mimoto_dataset', '4', '_Mimoto_dataset--form', '_Mimoto_form', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (567, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '4', 3);
INSERT INTO `_Mimoto_connection` VALUES (568, '_Mimoto_dataset', '4', '_Mimoto_dataset--data', '7', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (569, '_Mimoto_dataset', '4', '_Mimoto_dataset--data', '7', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (570, '_Mimoto_dataset', '4', '_Mimoto_dataset--data', '7', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (572, '_Mimoto_dataset', '3', '_Mimoto_dataset--data', '6', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (573, '_Mimoto_entityproperty', '30', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '80', 0);
INSERT INTO `_Mimoto_connection` VALUES (574, '_Mimoto_entityproperty', '30', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '81', 1);
INSERT INTO `_Mimoto_connection` VALUES (575, '_Mimoto_entityproperty', '30', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '82', 2);
INSERT INTO `_Mimoto_connection` VALUES (576, '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '30', 0);
INSERT INTO `_Mimoto_connection` VALUES (577, '_Mimoto_form', '10', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '19', 2);
INSERT INTO `_Mimoto_connection` VALUES (578, '_Mimoto_form_input_textline', '19', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '30', 0);
INSERT INTO `_Mimoto_connection` VALUES (580, '_Mimoto_entityproperty', '32', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '83', 0);
INSERT INTO `_Mimoto_connection` VALUES (581, '_Mimoto_entityproperty', '32', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '84', 1);
INSERT INTO `_Mimoto_connection` VALUES (582, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '32', 6);
INSERT INTO `_Mimoto_connection` VALUES (585, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '5', 3);
INSERT INTO `_Mimoto_connection` VALUES (590, '_Mimoto_selection', '5', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (591, '_Mimoto_selection_rule', '4', '_Mimoto_selection_rule--type', '_Mimoto_entity', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (592, '_Mimoto_entityproperty', '33', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '85', 0);
INSERT INTO `_Mimoto_connection` VALUES (593, '_Mimoto_entityproperty', '33', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '86', 1);
INSERT INTO `_Mimoto_connection` VALUES (594, '_Mimoto_entityproperty', '33', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '87', 2);
INSERT INTO `_Mimoto_connection` VALUES (595, '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '33', 0);
INSERT INTO `_Mimoto_connection` VALUES (596, '_Mimoto_form', '12', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '20', 2);
INSERT INTO `_Mimoto_connection` VALUES (597, '_Mimoto_form_input_textline', '20', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '33', 0);
INSERT INTO `_Mimoto_connection` VALUES (599, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '8', 7);
INSERT INTO `_Mimoto_connection` VALUES (600, '_Mimoto_entityproperty', '34', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '88', 0);
INSERT INTO `_Mimoto_connection` VALUES (601, '_Mimoto_entityproperty', '34', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '89', 1);
INSERT INTO `_Mimoto_connection` VALUES (602, '_Mimoto_entityproperty', '34', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '90', 2);
INSERT INTO `_Mimoto_connection` VALUES (603, '_Mimoto_entity', '8', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '34', 0);
INSERT INTO `_Mimoto_connection` VALUES (604, '_Mimoto_entityproperty', '35', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '91', 0);
INSERT INTO `_Mimoto_connection` VALUES (605, '_Mimoto_entityproperty', '35', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '92', 1);
INSERT INTO `_Mimoto_connection` VALUES (606, '_Mimoto_entityproperty', '35', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '93', 2);
INSERT INTO `_Mimoto_connection` VALUES (607, '_Mimoto_entity', '8', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '35', 1);
INSERT INTO `_Mimoto_connection` VALUES (608, '_Mimoto_form_input_textline', '21', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '34', 0);
INSERT INTO `_Mimoto_connection` VALUES (609, '_Mimoto_form_input_textline', '22', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '35', 0);
INSERT INTO `_Mimoto_connection` VALUES (610, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_output_title', '13', 0);
INSERT INTO `_Mimoto_connection` VALUES (611, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '13', 1);
INSERT INTO `_Mimoto_connection` VALUES (612, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '21', 2);
INSERT INTO `_Mimoto_connection` VALUES (613, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '22', 3);
INSERT INTO `_Mimoto_connection` VALUES (614, '_Mimoto_form', '13', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '13', 4);
INSERT INTO `_Mimoto_connection` VALUES (615, '_Mimoto_entity', '8', '_Mimoto_entity--forms', '_Mimoto_form', '13', 0);
INSERT INTO `_Mimoto_connection` VALUES (616, '_Mimoto_dataset', '5', '_Mimoto_dataset--form', '_Mimoto_form', '13', 0);
INSERT INTO `_Mimoto_connection` VALUES (617, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--datasets', '_Mimoto_dataset', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (618, '_Mimoto_dataset', '5', '_Mimoto_dataset--data', '8', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (619, '_Mimoto_dataset', '5', '_Mimoto_dataset--data', '8', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (620, '_Mimoto_dataset', '5', '_Mimoto_dataset--data', '8', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (622, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '6', 4);
INSERT INTO `_Mimoto_connection` VALUES (623, '_Mimoto_selection', '6', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (624, '_Mimoto_selection_rule', '5', '_Mimoto_selection_rule--type', '_Mimoto_entity', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (627, '1', '2', '3', '_Mimoto_file', '16', 0);
INSERT INTO `_Mimoto_connection` VALUES (630, '_Mimoto_entityproperty', '36', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '94', 0);
INSERT INTO `_Mimoto_connection` VALUES (631, '_Mimoto_entityproperty', '36', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '95', 1);
INSERT INTO `_Mimoto_connection` VALUES (632, '_Mimoto_entity', '1', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '36', 1);
INSERT INTO `_Mimoto_connection` VALUES (675, '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_dropdown', '2', 3);
INSERT INTO `_Mimoto_connection` VALUES (676, '_Mimoto_form_input_dropdown', '2', '_Mimoto_form_input_dropdown--value', '_Mimoto_entityproperty', '36', 0);
INSERT INTO `_Mimoto_connection` VALUES (677, '_Mimoto_form_field_option', '7', '_Mimoto_form_field_option--selection', '_Mimoto_selection', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (678, '_Mimoto_form_input_dropdown', '2', '_Mimoto_form_input_dropdown--options', '_Mimoto_form_field_option', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (690, '2', '15', '8', '_Mimoto_user', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (691, '1', '1', '6', '2', '15', 2);
INSERT INTO `_Mimoto_connection` VALUES (694, '1', '2', '36', '8', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (696, '_Mimoto_user', '2', '_Mimoto_user--avatar', '_Mimoto_file', '18', 0);
INSERT INTO `_Mimoto_connection` VALUES (715, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--services', '_Mimoto_service', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (716, '_Mimoto_service', '3', '_Mimoto_service--functions', '_Mimoto_service_function', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (852, '3', '3', '20', '5', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (853, '3', '3', '20', '4', '3', 1);
INSERT INTO `_Mimoto_connection` VALUES (854, '_Mimoto_entityproperty', '37', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '96', 0);
INSERT INTO `_Mimoto_connection` VALUES (855, '_Mimoto_entityproperty', '37', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '97', 1);
INSERT INTO `_Mimoto_connection` VALUES (856, '_Mimoto_entityproperty', '37', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '98', 2);
INSERT INTO `_Mimoto_connection` VALUES (857, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '37', 1);
INSERT INTO `_Mimoto_connection` VALUES (858, '_Mimoto_entitypropertysetting', '99', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', 0);
INSERT INTO `_Mimoto_connection` VALUES (859, '_Mimoto_entityproperty', '38', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '99', 0);
INSERT INTO `_Mimoto_connection` VALUES (860, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '38', 2);
INSERT INTO `_Mimoto_connection` VALUES (871, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '13', 3);
INSERT INTO `_Mimoto_connection` VALUES (872, '_Mimoto_form_input_textblock', '13', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '37', 0);
INSERT INTO `_Mimoto_connection` VALUES (873, '_Mimoto_form', '7', '_Mimoto_form--fields', '_Mimoto_form_input_image', '8', 4);
INSERT INTO `_Mimoto_connection` VALUES (874, '_Mimoto_form_input_image', '8', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '38', 0);
INSERT INTO `_Mimoto_connection` VALUES (875, '4', '3', '38', '_Mimoto_file', '19', 0);
INSERT INTO `_Mimoto_connection` VALUES (884, '_Mimoto_user', '1', '_Mimoto_user--roles', '_Mimoto_user_role', '_Mimoto_user_role-owner', 1);
INSERT INTO `_Mimoto_connection` VALUES (1523, '_Mimoto_entityproperty', '39', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '100', 0);
INSERT INTO `_Mimoto_connection` VALUES (1524, '_Mimoto_entityproperty', '39', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '101', 1);
INSERT INTO `_Mimoto_connection` VALUES (1525, '_Mimoto_entityproperty', '39', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '102', 2);
INSERT INTO `_Mimoto_connection` VALUES (1526, '_Mimoto_component', '3', '_Mimoto_component--properties', '_Mimoto_entityproperty', '39', 0);
INSERT INTO `_Mimoto_connection` VALUES (1529, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--components', '_Mimoto_component', '6', 5);
INSERT INTO `_Mimoto_connection` VALUES (1530, '_Mimoto_entityproperty', '40', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '103', 0);
INSERT INTO `_Mimoto_connection` VALUES (1531, '_Mimoto_entityproperty', '40', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '104', 1);
INSERT INTO `_Mimoto_connection` VALUES (1532, '_Mimoto_entityproperty', '40', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '105', 2);
INSERT INTO `_Mimoto_connection` VALUES (1533, '_Mimoto_entityproperty', '41', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '106', 0);
INSERT INTO `_Mimoto_connection` VALUES (1534, '_Mimoto_entityproperty', '41', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '107', 1);
INSERT INTO `_Mimoto_connection` VALUES (1535, '_Mimoto_entityproperty', '41', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '108', 2);
INSERT INTO `_Mimoto_connection` VALUES (1536, '_Mimoto_entityproperty', '43', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '109', 0);
INSERT INTO `_Mimoto_connection` VALUES (1537, '_Mimoto_entityproperty', '43', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '110', 1);
INSERT INTO `_Mimoto_connection` VALUES (1538, '_Mimoto_entityproperty', '43', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '111', 2);
INSERT INTO `_Mimoto_connection` VALUES (1545, '_Mimoto_entityproperty', '45', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '115', 0);
INSERT INTO `_Mimoto_connection` VALUES (1546, '_Mimoto_entityproperty', '45', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '116', 1);
INSERT INTO `_Mimoto_connection` VALUES (1547, '_Mimoto_entityproperty', '45', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '117', 2);
INSERT INTO `_Mimoto_connection` VALUES (1548, '_Mimoto_entityproperty', '46', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '118', 0);
INSERT INTO `_Mimoto_connection` VALUES (1549, '_Mimoto_entityproperty', '46', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '119', 1);
INSERT INTO `_Mimoto_connection` VALUES (1550, '_Mimoto_entityproperty', '46', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '120', 2);
INSERT INTO `_Mimoto_connection` VALUES (1551, '_Mimoto_component', '6', '_Mimoto_component--properties', '_Mimoto_entityproperty', '46', 0);
INSERT INTO `_Mimoto_connection` VALUES (1553, '_Mimoto_entityproperty', '47', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '121', 0);
INSERT INTO `_Mimoto_connection` VALUES (1554, '_Mimoto_entityproperty', '47', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '122', 1);
INSERT INTO `_Mimoto_connection` VALUES (1555, '_Mimoto_entityproperty', '47', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '123', 2);
INSERT INTO `_Mimoto_connection` VALUES (1556, '_Mimoto_component', '6', '_Mimoto_component--properties', '_Mimoto_entityproperty', '47', 1);
INSERT INTO `_Mimoto_connection` VALUES (1558, '_Mimoto_entityproperty', '48', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '124', 0);
INSERT INTO `_Mimoto_connection` VALUES (1559, '_Mimoto_entityproperty', '48', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '125', 1);
INSERT INTO `_Mimoto_connection` VALUES (1560, '_Mimoto_entityproperty', '48', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '126', 2);
INSERT INTO `_Mimoto_connection` VALUES (1561, '_Mimoto_component', '6', '_Mimoto_component--properties', '_Mimoto_entityproperty', '48', 2);
INSERT INTO `_Mimoto_connection` VALUES (1562, '_Mimoto_entityproperty', '49', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '127', 0);
INSERT INTO `_Mimoto_connection` VALUES (1563, '_Mimoto_entityproperty', '49', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '128', 1);
INSERT INTO `_Mimoto_connection` VALUES (1564, '_Mimoto_entityproperty', '49', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '129', 2);
INSERT INTO `_Mimoto_connection` VALUES (1565, '_Mimoto_component', '6', '_Mimoto_component--properties', '_Mimoto_entityproperty', '49', 3);
INSERT INTO `_Mimoto_connection` VALUES (1753, '1', '1', '36', '8', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (1788, '_Mimoto_action', '39', '_Mimoto_action--entity', '_Mimoto_entity', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (1795, '_Mimoto_action', '43', '_Mimoto_action--entity', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1797, '_Mimoto_action', '44', '_Mimoto_action--entity', '_Mimoto_entity', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (1800, '_Mimoto_action', '46', '_Mimoto_action--entity', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1909, '_Mimoto_action_conditional', '44', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1915, '_Mimoto_action_conditional', '45', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1936, '_Mimoto_action_conditional', '49', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (1941, '_Mimoto_action_conditional', '50', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1949, '_Mimoto_action_conditional', '52', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (1995, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '8', 5);
INSERT INTO `_Mimoto_connection` VALUES (1997, '_Mimoto_selection', '8', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '7', 2);
INSERT INTO `_Mimoto_connection` VALUES (1998, '_Mimoto_selection', '8', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '8', 0);
INSERT INTO `_Mimoto_connection` VALUES (1999, '_Mimoto_selection', '8', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '9', 1);
INSERT INTO `_Mimoto_connection` VALUES (2035, '_Mimoto_action_conditional', '60', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2045, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--actions', '_Mimoto_action', '108', 0);
INSERT INTO `_Mimoto_connection` VALUES (2049, '_Mimoto_action', '108', '_Mimoto_action--service', '_Mimoto_service', '_Mimoto_service-Slack', 0);
INSERT INTO `_Mimoto_connection` VALUES (2050, '_Mimoto_action', '108', '_Mimoto_action--function', '_Mimoto_service_function', '_Mimoto_service_function-Slack-sendMessage', 0);
INSERT INTO `_Mimoto_connection` VALUES (2051, '_Mimoto_action', '108', '_Mimoto_action--settings', '_Mimoto_action_setting', '22', 0);
INSERT INTO `_Mimoto_connection` VALUES (2052, '_Mimoto_action', '108', '_Mimoto_action--settings', '_Mimoto_action_setting', '23', 1);
INSERT INTO `_Mimoto_connection` VALUES (2054, '_Mimoto_action_conditional', '62', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (2059, '_Mimoto_action_conditional', '63', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (2060, '_Mimoto_selection_rule', '8', '_Mimoto_selection_rule--type', '_Mimoto_entity', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (2063, '_Mimoto_selection_rule', '9', '_Mimoto_selection_rule--type', '_Mimoto_entity', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (2065, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '10', 5);
INSERT INTO `_Mimoto_connection` VALUES (2066, '_Mimoto_output', '2', '_Mimoto_output--selection', '_Mimoto_selection', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (2067, '_Mimoto_action', '108', '_Mimoto_action--entity', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2068, '_Mimoto_action', '108', '_Mimoto_action--conditionals', '_Mimoto_action_conditional', '64', 0);
INSERT INTO `_Mimoto_connection` VALUES (2069, '_Mimoto_action_conditional', '64', '_Mimoto_action_conditional--entityProperty', '_Mimoto_entityproperty', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2077, '_Mimoto_selection_rule', '3', '_Mimoto_selection_rule--instance', '3', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (2078, '_Mimoto_selection', '10', '_Mimoto_selection--rules', '_Mimoto_selection_rule', '10', 0);
INSERT INTO `_Mimoto_connection` VALUES (2090, '_Mimoto_selection_rule', '10', '_Mimoto_selection_rule--type', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (2129, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '42', 8);
INSERT INTO `_Mimoto_connection` VALUES (2134, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '1', 0);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_dataset
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_dataset`;
CREATE TABLE `_Mimoto_dataset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_dataset
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_dataset` VALUES (1, 'Articles', '2017-09-20 18:45:34');
INSERT INTO `_Mimoto_dataset` VALUES (2, 'Pages', '2017-09-21 09:11:38');
INSERT INTO `_Mimoto_dataset` VALUES (3, 'Members', '2017-09-30 13:40:01');
INSERT INTO `_Mimoto_dataset` VALUES (4, 'Member types', '2017-09-30 13:44:21');
INSERT INTO `_Mimoto_dataset` VALUES (5, 'Article types', '2017-10-01 17:30:24');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_entity
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entity`;
CREATE TABLE `_Mimoto_entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `isUserExtension` enum('0','1') DEFAULT NULL,
  `isAbstract` enum('0','1') CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_entity
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entity` VALUES (1, 'article', NULL, NULL, '2017-09-20 18:41:29');
INSERT INTO `_Mimoto_entity` VALUES (2, 'comment', NULL, NULL, '2017-09-20 19:07:46');
INSERT INTO `_Mimoto_entity` VALUES (3, 'page', NULL, NULL, '2017-09-21 09:09:58');
INSERT INTO `_Mimoto_entity` VALUES (4, 'element1', NULL, NULL, '2017-09-21 09:24:25');
INSERT INTO `_Mimoto_entity` VALUES (5, 'element2', NULL, NULL, '2017-09-21 09:24:31');
INSERT INTO `_Mimoto_entity` VALUES (6, 'author', '1', NULL, NULL);
INSERT INTO `_Mimoto_entity` VALUES (7, 'memberType', NULL, NULL, '2017-09-30 13:40:39');
INSERT INTO `_Mimoto_entity` VALUES (8, 'articleType', NULL, NULL, '2017-10-01 17:29:50');
INSERT INTO `_Mimoto_entity` VALUES (20, 'zzz', NULL, NULL, '2017-12-03 14:33:18');
INSERT INTO `_Mimoto_entity` VALUES (21, 'bbb', NULL, NULL, '2017-12-03 15:38:00');
INSERT INTO `_Mimoto_entity` VALUES (22, 'fff', NULL, NULL, '2017-12-03 15:42:08');
INSERT INTO `_Mimoto_entity` VALUES (23, 'fff', NULL, NULL, '2017-12-03 15:43:31');
INSERT INTO `_Mimoto_entity` VALUES (24, 'fff', NULL, NULL, '2017-12-03 15:43:47');
INSERT INTO `_Mimoto_entity` VALUES (25, 'fff', NULL, NULL, '2017-12-03 15:44:21');
INSERT INTO `_Mimoto_entity` VALUES (26, 'fff', NULL, NULL, '2017-12-03 15:44:51');
INSERT INTO `_Mimoto_entity` VALUES (28, 'aaa', NULL, NULL, '2017-12-03 15:46:25');
INSERT INTO `_Mimoto_entity` VALUES (30, 'hhh', NULL, NULL, '2017-12-03 15:48:31');
INSERT INTO `_Mimoto_entity` VALUES (33, 'aa2', NULL, NULL, '2017-12-03 15:49:31');
INSERT INTO `_Mimoto_entity` VALUES (34, 'aa3', NULL, NULL, '2017-12-03 15:52:50');
INSERT INTO `_Mimoto_entity` VALUES (35, 'aa4', NULL, NULL, '2017-12-03 16:00:06');
INSERT INTO `_Mimoto_entity` VALUES (36, 'aa5', NULL, NULL, '2017-12-03 16:00:23');
INSERT INTO `_Mimoto_entity` VALUES (42, 'xxx', NULL, NULL, '2017-12-03 18:05:08');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_entityproperty
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entityproperty`;
CREATE TABLE `_Mimoto_entityproperty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtype` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_entityproperty
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entityproperty` VALUES (1, 'title', 'value', NULL, '2017-09-20 18:41:37');
INSERT INTO `_Mimoto_entityproperty` VALUES (2, 'lede', 'value', NULL, '2017-09-20 18:42:13');
INSERT INTO `_Mimoto_entityproperty` VALUES (3, 'headerImage', 'entity', 'image', '2017-09-20 18:42:26');
INSERT INTO `_Mimoto_entityproperty` VALUES (4, 'body', 'value', NULL, '2017-09-20 18:42:35');
INSERT INTO `_Mimoto_entityproperty` VALUES (6, 'comments', 'collection', NULL, '2017-09-20 18:44:38');
INSERT INTO `_Mimoto_entityproperty` VALUES (7, 'message', 'value', NULL, '2017-09-20 19:07:54');
INSERT INTO `_Mimoto_entityproperty` VALUES (8, 'owner', 'entity', NULL, '2017-09-20 19:08:03');
INSERT INTO `_Mimoto_entityproperty` VALUES (10, 'aaa', 'value', NULL, '2017-09-21 07:42:48');
INSERT INTO `_Mimoto_entityproperty` VALUES (11, 'title', 'value', NULL, '2017-09-21 07:44:03');
INSERT INTO `_Mimoto_entityproperty` VALUES (12, 'aaa1', 'value', NULL, '2017-09-21 07:45:44');
INSERT INTO `_Mimoto_entityproperty` VALUES (13, 'aaa2', 'value', NULL, '2017-09-21 07:56:49');
INSERT INTO `_Mimoto_entityproperty` VALUES (14, 'aaa3', 'value', NULL, '2017-09-21 07:57:23');
INSERT INTO `_Mimoto_entityproperty` VALUES (15, 'aaa4', 'value', NULL, '2017-09-21 07:59:15');
INSERT INTO `_Mimoto_entityproperty` VALUES (16, 'aaa5', 'value', NULL, '2017-09-21 08:01:56');
INSERT INTO `_Mimoto_entityproperty` VALUES (19, 'title', 'value', NULL, '2017-09-21 09:10:09');
INSERT INTO `_Mimoto_entityproperty` VALUES (20, 'elements', 'collection', NULL, '2017-09-21 09:10:16');
INSERT INTO `_Mimoto_entityproperty` VALUES (21, 'title', 'value', NULL, '2017-09-21 09:24:40');
INSERT INTO `_Mimoto_entityproperty` VALUES (22, 'element2', 'value', NULL, '2017-09-21 09:24:56');
INSERT INTO `_Mimoto_entityproperty` VALUES (23, 'biography', 'value', NULL, '2017-09-22 10:27:44');
INSERT INTO `_Mimoto_entityproperty` VALUES (24, 'topic', 'value', NULL, '2017-09-22 10:28:04');
INSERT INTO `_Mimoto_entityproperty` VALUES (25, 'articles', 'collection', NULL, '2017-09-22 10:28:15');
INSERT INTO `_Mimoto_entityproperty` VALUES (27, 'type', 'value', NULL, '2017-09-30 13:40:18');
INSERT INTO `_Mimoto_entityproperty` VALUES (28, 'value', 'value', NULL, '2017-09-30 13:42:47');
INSERT INTO `_Mimoto_entityproperty` VALUES (30, 'name', 'value', NULL, '2017-09-30 14:16:09');
INSERT INTO `_Mimoto_entityproperty` VALUES (32, 'author', 'entity', NULL, '2017-09-30 14:19:18');
INSERT INTO `_Mimoto_entityproperty` VALUES (33, 'label', 'value', NULL, '2017-10-01 16:43:53');
INSERT INTO `_Mimoto_entityproperty` VALUES (34, 'label', 'value', NULL, '2017-10-01 17:29:59');
INSERT INTO `_Mimoto_entityproperty` VALUES (35, 'value', 'value', NULL, '2017-10-01 17:30:04');
INSERT INTO `_Mimoto_entityproperty` VALUES (36, 'type', 'entity', NULL, '2017-10-01 18:10:51');
INSERT INTO `_Mimoto_entityproperty` VALUES (37, 'body', 'value', NULL, '2017-10-25 17:57:48');
INSERT INTO `_Mimoto_entityproperty` VALUES (38, 'image', 'entity', 'image', '2017-10-25 17:58:03');
INSERT INTO `_Mimoto_entityproperty` VALUES (39, 'xxx', 'value', NULL, '2017-11-20 11:12:03');
INSERT INTO `_Mimoto_entityproperty` VALUES (40, 'aaa', 'value', NULL, '2017-11-20 15:17:31');
INSERT INTO `_Mimoto_entityproperty` VALUES (41, 'aaa', 'value', NULL, '2017-11-20 15:17:43');
INSERT INTO `_Mimoto_entityproperty` VALUES (42, 'dddd', 'value', NULL, '2017-11-20 15:41:50');
INSERT INTO `_Mimoto_entityproperty` VALUES (43, 'dddd', 'value', NULL, '2017-11-20 15:42:05');
INSERT INTO `_Mimoto_entityproperty` VALUES (45, 'xxx', 'value', NULL, '2017-11-20 15:47:16');
INSERT INTO `_Mimoto_entityproperty` VALUES (46, 'aaa', 'value', NULL, '2017-11-20 15:48:12');
INSERT INTO `_Mimoto_entityproperty` VALUES (47, 'bbb', 'value', NULL, '2017-11-21 11:38:44');
INSERT INTO `_Mimoto_entityproperty` VALUES (48, 'bbb', 'value', NULL, '2017-11-21 11:40:03');
INSERT INTO `_Mimoto_entityproperty` VALUES (49, 'nnnn', 'value', NULL, '2017-11-21 11:40:15');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_entitypropertysetting
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entitypropertysetting`;
CREATE TABLE `_Mimoto_entitypropertysetting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_entitypropertysetting
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (1, 'type', 'text', 'textline', '2017-09-20 18:41:37');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (2, 'formattingOptions', '', '', '2017-09-20 18:41:37');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (3, 'defaultValue', '', '', '2017-09-20 18:41:37');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (4, 'type', 'text', 'textblock', '2017-09-20 18:42:13');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (5, 'formattingOptions', '', '', '2017-09-20 18:42:13');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (6, 'defaultValue', '', '', '2017-09-20 18:42:13');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (7, 'allowedEntityType', NULL, NULL, '2017-09-20 18:42:26');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (8, 'type', 'text', 'textblock', '2017-09-20 18:42:35');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (9, 'formattingOptions', '', '', '2017-09-20 18:42:35');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (10, 'defaultValue', '', '', '2017-09-20 18:42:35');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (14, 'allowedEntityTypes', '', '', '2017-09-20 18:44:38');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (15, 'allowDuplicates', 'boolean', '', '2017-09-20 18:44:38');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (16, 'type', 'text', 'textblock', '2017-09-20 19:07:54');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (17, 'formattingOptions', '', '', '2017-09-20 19:07:54');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (18, 'defaultValue', '', '', '2017-09-20 19:07:54');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (19, 'allowedEntityType', '', '', '2017-09-20 19:08:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (20, 'defaultValue', 'currentUser', '', '2017-09-20 19:08:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (24, 'type', 'text', 'textline', '2017-09-21 07:42:48');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (25, 'formattingOptions', '', '', '2017-09-21 07:42:48');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (26, 'defaultValue', '', '', '2017-09-21 07:42:48');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (27, 'type', 'text', 'textline', '2017-09-21 07:44:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (28, 'formattingOptions', '', '', '2017-09-21 07:44:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (29, 'defaultValue', '', '', '2017-09-21 07:44:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (30, 'type', 'text', 'textline', '2017-09-21 07:45:44');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (31, 'formattingOptions', '', '', '2017-09-21 07:45:44');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (32, 'defaultValue', '', '', '2017-09-21 07:45:44');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (33, 'type', 'text', 'textline', '2017-09-21 07:56:49');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (34, 'formattingOptions', '', '', '2017-09-21 07:56:49');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (35, 'defaultValue', '', '', '2017-09-21 07:56:49');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (36, 'type', 'text', 'textline', '2017-09-21 07:57:23');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (37, 'formattingOptions', '', '', '2017-09-21 07:57:23');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (38, 'defaultValue', '', '', '2017-09-21 07:57:23');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (39, 'type', 'text', 'textline', '2017-09-21 07:59:15');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (40, 'formattingOptions', '', '', '2017-09-21 07:59:15');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (41, 'defaultValue', '', '', '2017-09-21 07:59:15');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (43, 'formattingOptions', '', '', '2017-09-21 08:01:56');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (44, 'defaultValue', '', '', '2017-09-21 08:01:56');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (51, 'type', 'text', 'textline', '2017-09-21 09:10:09');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (52, 'formattingOptions', '', '', '2017-09-21 09:10:09');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (53, 'defaultValue', '', '', '2017-09-21 09:10:09');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (54, 'allowedEntityTypes', '', '', '2017-09-21 09:10:16');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (55, 'allowDuplicates', 'boolean', '', '2017-09-21 09:10:16');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (56, 'type', 'text', 'textline', '2017-09-21 09:24:40');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (57, 'formattingOptions', '', '', '2017-09-21 09:24:40');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (58, 'defaultValue', '', '', '2017-09-21 09:24:40');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (59, 'type', 'text', 'textline', '2017-09-21 09:24:56');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (60, 'formattingOptions', '', '', '2017-09-21 09:24:56');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (61, 'defaultValue', '', '', '2017-09-21 09:24:56');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (62, 'type', 'text', 'textblock', '2017-09-22 10:27:44');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (63, 'formattingOptions', '', '', '2017-09-22 10:27:44');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (64, 'defaultValue', '', '', '2017-09-22 10:27:44');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (65, 'type', 'text', 'textline', '2017-09-22 10:28:04');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (66, 'formattingOptions', '', '', '2017-09-22 10:28:04');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (67, 'defaultValue', '', '', '2017-09-22 10:28:04');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (68, 'allowedEntityTypes', '', '', '2017-09-22 10:28:15');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (69, 'allowDuplicates', 'boolean', '', '2017-09-22 10:28:15');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (71, 'type', 'text', 'textline', '2017-09-30 13:40:18');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (72, 'formattingOptions', '', '', '2017-09-30 13:40:18');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (73, 'defaultValue', '', '', '2017-09-30 13:40:18');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (74, 'type', 'text', 'textline', '2017-09-30 13:42:47');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (75, 'formattingOptions', '', '', '2017-09-30 13:42:47');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (76, 'defaultValue', '', '', '2017-09-30 13:42:47');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (80, 'type', 'text', 'textline', '2017-09-30 14:16:09');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (81, 'formattingOptions', '', '', '2017-09-30 14:16:09');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (82, 'defaultValue', '', '', '2017-09-30 14:16:09');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (83, 'allowedEntityType', '', '', '2017-09-30 14:19:18');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (84, 'defaultValue', '', '', '2017-09-30 14:19:18');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (85, 'type', 'text', 'textline', '2017-10-01 16:43:53');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (86, 'formattingOptions', '', '', '2017-10-01 16:43:53');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (87, 'defaultValue', '', '', '2017-10-01 16:43:53');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (88, 'type', 'text', 'textline', '2017-10-01 17:29:59');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (89, 'formattingOptions', '', '', '2017-10-01 17:29:59');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (90, 'defaultValue', '', '', '2017-10-01 17:29:59');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (91, 'type', 'text', 'textline', '2017-10-01 17:30:04');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (92, 'formattingOptions', '', '', '2017-10-01 17:30:04');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (93, 'defaultValue', '', '', '2017-10-01 17:30:04');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (94, 'allowedEntityType', '', '', '2017-10-01 18:10:51');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (95, 'defaultValue', '', '', '2017-10-01 18:10:51');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (96, 'type', 'text', 'textblock', '2017-10-25 17:57:48');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (97, 'formattingOptions', '', '', '2017-10-25 17:57:48');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (98, 'defaultValue', '', '', '2017-10-25 17:57:48');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (99, 'allowedEntityType', NULL, NULL, '2017-10-25 17:58:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (100, 'type', 'text', 'textline', '2017-11-20 11:12:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (101, 'formattingOptions', '', '', '2017-11-20 11:12:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (102, 'defaultValue', '', '', '2017-11-20 11:12:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (103, 'type', 'text', 'textline', '2017-11-20 15:17:31');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (104, 'formattingOptions', '', '', '2017-11-20 15:17:31');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (105, 'defaultValue', '', '', '2017-11-20 15:17:31');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (106, 'type', 'text', 'textline', '2017-11-20 15:17:43');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (107, 'formattingOptions', '', '', '2017-11-20 15:17:43');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (108, 'defaultValue', '', '', '2017-11-20 15:17:43');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (109, 'type', 'text', 'textline', '2017-11-20 15:42:05');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (110, 'formattingOptions', '', '', '2017-11-20 15:42:05');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (111, 'defaultValue', '', '', '2017-11-20 15:42:05');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (115, 'type', 'text', 'textline', '2017-11-20 15:47:16');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (116, 'formattingOptions', '', '', '2017-11-20 15:47:16');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (117, 'defaultValue', '', '', '2017-11-20 15:47:16');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (118, 'type', 'text', 'textline', '2017-11-20 15:48:12');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (119, 'formattingOptions', '', '', '2017-11-20 15:48:12');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (120, 'defaultValue', '', '', '2017-11-20 15:48:12');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (121, 'type', 'text', 'textline', '2017-11-21 11:38:44');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (122, 'formattingOptions', '', '', '2017-11-21 11:38:44');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (123, 'defaultValue', '', '', '2017-11-21 11:38:44');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (124, 'type', 'text', 'textline', '2017-11-21 11:40:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (125, 'formattingOptions', '', '', '2017-11-21 11:40:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (126, 'defaultValue', '', '', '2017-11-21 11:40:03');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (127, 'type', 'text', 'textline', '2017-11-21 11:40:15');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (128, 'formattingOptions', '', '', '2017-11-21 11:40:15');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (129, 'defaultValue', '', '', '2017-11-21 11:40:15');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (130, 'type', 'text', 'textline', '2017-12-04 06:41:43');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (131, 'formattingOptions', '', '', '2017-12-04 06:41:43');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (132, 'defaultValue', '', '', '2017-12-04 06:41:43');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (133, 'type', 'text', 'textline', '2017-12-04 06:42:10');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (134, 'formattingOptions', '', '', '2017-12-04 06:42:10');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (135, 'defaultValue', '', '', '2017-12-04 06:42:10');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (136, 'type', 'text', 'textline', '2017-12-04 06:42:22');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (137, 'formattingOptions', '', '', '2017-12-04 06:42:22');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (138, 'defaultValue', '', '', '2017-12-04 06:42:22');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (139, 'allowedEntityType', '', '', '2017-12-04 06:44:15');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (140, 'defaultValue', '', '', '2017-12-04 06:44:15');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_file
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_file`;
CREATE TABLE `_Mimoto_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `path` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `mime` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `size` int(10) unsigned DEFAULT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `aspectRatio` float(10,5) DEFAULT NULL,
  `originalName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_file
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_file` VALUES (1, '7ed2f3279e444065298dda124923f2b2.png', 'dynamic/', 'image/png', 452629, 800, 800, 1.00000, 'profielfoto_sebastian_square.png', '2017-09-20 18:36:09');
INSERT INTO `_Mimoto_file` VALUES (2, 'aae0fc5579a253893659cfecf2035ed8.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-09-20 18:46:35');
INSERT INTO `_Mimoto_file` VALUES (16, 'f2a40c0a01c0e9d77507784b736a7c85.jpg', 'dynamic/', 'image/jpeg', 143998, 1920, 823, 2.33293, 'peilingen_hoe.jpg', '2017-10-01 17:34:56');
INSERT INTO `_Mimoto_file` VALUES (18, '369c3b9c84324ced5be8e7daf2b6b187.jpeg', 'dynamic/', 'image/jpeg', 134734, 750, 1061, 0.70688, 'hilde.jpeg', '2017-10-09 21:28:06');
INSERT INTO `_Mimoto_file` VALUES (19, 'b15a1e49a7ae5c895b89455382e5dafc.png', 'dynamic/', 'image/png', 24970, 126, 126, 1.00000, 'sebastian.png', '2017-10-25 17:59:21');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form`;
CREATE TABLE `_Mimoto_form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `manualSave` enum('0','1') DEFAULT NULL,
  `realtimeCollaborationMode` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customSubmit` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `method` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `target` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form` VALUES (5, 'article', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 18:48:28');
INSERT INTO `_Mimoto_form` VALUES (6, 'page', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-21 09:11:25');
INSERT INTO `_Mimoto_form` VALUES (7, 'element1', NULL, '0', NULL, NULL, NULL, NULL, NULL, '2017-09-21 09:24:44');
INSERT INTO `_Mimoto_form` VALUES (8, 'element2', NULL, '0', NULL, NULL, NULL, NULL, NULL, '2017-09-21 09:24:59');
INSERT INTO `_Mimoto_form` VALUES (9, 'comment', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-21 12:13:19');
INSERT INTO `_Mimoto_form` VALUES (10, 'member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-30 13:39:50');
INSERT INTO `_Mimoto_form` VALUES (12, 'memberType', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-30 13:44:10');
INSERT INTO `_Mimoto_form` VALUES (13, 'articleType', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-01 17:30:06');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_field_option
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_field_option`;
CREATE TABLE `_Mimoto_form_field_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `mappingLabel` varchar(255) DEFAULT NULL,
  `mappingValue` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_field_option
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_field_option` VALUES (1, 'form', 'Element 1', NULL, NULL, NULL, '2017-09-21 09:25:22');
INSERT INTO `_Mimoto_form_field_option` VALUES (2, 'form', 'Element 2', NULL, NULL, NULL, '2017-09-21 09:25:32');
INSERT INTO `_Mimoto_form_field_option` VALUES (7, 'selection', 'Article types', NULL, 'label', 'value', '2017-10-02 10:21:31');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_field_rules
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_field_rules`;
CREATE TABLE `_Mimoto_form_field_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_field_validation
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_field_validation`;
CREATE TABLE `_Mimoto_form_field_validation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `errorMessage` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `trigger` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_checkbox
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_checkbox`;
CREATE TABLE `_Mimoto_form_input_checkbox` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `option` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_colorpicker
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_colorpicker`;
CREATE TABLE `_Mimoto_form_input_colorpicker` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_datepicker
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_datepicker`;
CREATE TABLE `_Mimoto_form_input_datepicker` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `enableTime` enum('0','1') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_dropdown
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_dropdown`;
CREATE TABLE `_Mimoto_form_input_dropdown` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_dropdown
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_dropdown` VALUES (2, 'Type', NULL, '2017-10-02 10:21:03');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_entity
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_entity`;
CREATE TABLE `_Mimoto_form_input_entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_entity
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_entity` VALUES (2, 'Case preview', NULL, '2017-11-01 11:56:52');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_image
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_image`;
CREATE TABLE `_Mimoto_form_input_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_image
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_image` VALUES (5, 'Main image', NULL, '2017-09-20 18:48:28');
INSERT INTO `_Mimoto_form_input_image` VALUES (8, 'Image', NULL, '2017-10-25 17:58:36');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_list
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_list`;
CREATE TABLE `_Mimoto_form_input_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_list
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_list` VALUES (1, 'Elements', NULL, '2017-09-21 09:20:45');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_multiselect
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_multiselect`;
CREATE TABLE `_Mimoto_form_input_multiselect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `option` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_password
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_password`;
CREATE TABLE `_Mimoto_form_input_password` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_radiobutton
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_radiobutton`;
CREATE TABLE `_Mimoto_form_input_radiobutton` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_input_textblock
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_textblock`;
CREATE TABLE `_Mimoto_form_input_textblock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `optional` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `regexp` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxchars` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_textblock
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textblock` VALUES (8, 'Lede', NULL, NULL, NULL, NULL, NULL, '2017-09-20 18:48:28');
INSERT INTO `_Mimoto_form_input_textblock` VALUES (9, 'Body', NULL, NULL, NULL, NULL, NULL, '2017-09-20 18:48:28');
INSERT INTO `_Mimoto_form_input_textblock` VALUES (10, 'Message', NULL, NULL, NULL, NULL, NULL, '2017-09-21 12:13:19');
INSERT INTO `_Mimoto_form_input_textblock` VALUES (11, 'Biography', NULL, NULL, NULL, NULL, NULL, '2017-09-30 13:39:50');
INSERT INTO `_Mimoto_form_input_textblock` VALUES (13, 'Body', NULL, NULL, NULL, NULL, NULL, '2017-10-25 17:58:25');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_textline
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_textline`;
CREATE TABLE `_Mimoto_form_input_textline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_input_textline
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textline` VALUES (10, 'Title', NULL, NULL, NULL, '2017-09-20 18:48:28');
INSERT INTO `_Mimoto_form_input_textline` VALUES (12, 'Title', NULL, NULL, NULL, '2017-09-21 09:11:25');
INSERT INTO `_Mimoto_form_input_textline` VALUES (13, 'Title', NULL, NULL, NULL, '2017-09-21 09:24:44');
INSERT INTO `_Mimoto_form_input_textline` VALUES (14, 'Element2', NULL, NULL, NULL, '2017-09-21 09:24:59');
INSERT INTO `_Mimoto_form_input_textline` VALUES (15, 'Topic', NULL, NULL, NULL, '2017-09-30 13:39:50');
INSERT INTO `_Mimoto_form_input_textline` VALUES (18, 'Value', NULL, NULL, NULL, '2017-09-30 13:44:10');
INSERT INTO `_Mimoto_form_input_textline` VALUES (19, 'Name', NULL, NULL, NULL, '2017-09-30 14:16:19');
INSERT INTO `_Mimoto_form_input_textline` VALUES (20, 'Label', NULL, NULL, NULL, '2017-10-01 16:44:04');
INSERT INTO `_Mimoto_form_input_textline` VALUES (21, 'Label', NULL, NULL, NULL, '2017-10-01 17:30:06');
INSERT INTO `_Mimoto_form_input_textline` VALUES (22, 'Value', NULL, NULL, NULL, '2017-10-01 17:30:06');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_video
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_video`;
CREATE TABLE `_Mimoto_form_input_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_layout_divider
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_divider`;
CREATE TABLE `_Mimoto_form_layout_divider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_form_layout_groupend
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_groupend`;
CREATE TABLE `_Mimoto_form_layout_groupend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_layout_groupend
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (5, '2017-09-20 18:48:28');
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (6, '2017-09-21 09:11:25');
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (7, '2017-09-21 09:24:44');
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (8, '2017-09-21 09:24:59');
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (9, '2017-09-21 12:13:19');
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (10, '2017-09-30 13:39:50');
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (12, '2017-09-30 13:44:10');
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (13, '2017-10-01 17:30:06');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_layout_groupstart
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_groupstart`;
CREATE TABLE `_Mimoto_form_layout_groupstart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_layout_groupstart
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (5, NULL, '2017-09-20 18:48:28');
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (6, NULL, '2017-09-21 09:11:25');
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (7, NULL, '2017-09-21 09:24:44');
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (8, NULL, '2017-09-21 09:24:59');
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (9, NULL, '2017-09-21 12:13:19');
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (10, NULL, '2017-09-30 13:39:50');
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (12, NULL, '2017-09-30 13:44:10');
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (13, NULL, '2017-10-01 17:30:06');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_output_title
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_output_title`;
CREATE TABLE `_Mimoto_form_output_title` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_form_output_title
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_output_title` VALUES (5, 'Article', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 20 September 2017 18:48:28. Adjust, add, remove or change the fields as you feel fit!', '2017-09-20 18:48:28');
INSERT INTO `_Mimoto_form_output_title` VALUES (6, 'Page', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 21 September 2017 09:11:25. Adjust, add, remove or change the fields as you feel fit!', '2017-09-21 09:11:25');
INSERT INTO `_Mimoto_form_output_title` VALUES (7, 'Element1', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 21 September 2017 09:24:44. Adjust, add, remove or change the fields as you feel fit!', '2017-09-21 09:24:44');
INSERT INTO `_Mimoto_form_output_title` VALUES (8, 'Element2', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 21 September 2017 09:24:59. Adjust, add, remove or change the fields as you feel fit!', '2017-09-21 09:24:59');
INSERT INTO `_Mimoto_form_output_title` VALUES (9, 'Comment', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 21 September 2017 12:13:19. Adjust, add, remove or change the fields as you feel fit!', '2017-09-21 12:13:19');
INSERT INTO `_Mimoto_form_output_title` VALUES (10, 'Member', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 30 September 2017 13:39:50. Adjust, add, remove or change the fields as you feel fit!', '2017-09-30 13:39:50');
INSERT INTO `_Mimoto_form_output_title` VALUES (12, 'Member type', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 30 September 2017 13:44:10. Adjust, add, remove or change the fields as you feel fit!', '2017-09-30 13:44:10');
INSERT INTO `_Mimoto_form_output_title` VALUES (13, 'Article type', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 01 October 2017 17:30:06. Adjust, add, remove or change the fields as you feel fit!', '2017-10-01 17:30:06');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_formattingoption
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_formattingoption`;
CREATE TABLE `_Mimoto_formattingoption` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `tagName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `toolbar` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `jsOnAdd` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `jsOnEdit` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_formattingoption_attribute
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_formattingoption_attribute`;
CREATE TABLE `_Mimoto_formattingoption_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `size` int(10) unsigned DEFAULT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `aspectRatio` float(10,5) DEFAULT NULL,
  `originalName` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_notification
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_notification`;
CREATE TABLE `_Mimoto_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `category` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispatcher` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_notification
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_notification` VALUES (1, 'Unknow mysql table property specs', 'An entity table got the request to add an unknown property-column type', 'error', 'Mimoto\\EntityConfig\\EntityConfigTableUtils::getColumnDataType (called from line #96)', 'open', '2017-12-03 18:59:34');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_output
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_output`;
CREATE TABLE `_Mimoto_output` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isRoot` enum('0','1') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_output
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_output` VALUES (1, NULL, '2017-09-20 18:50:17');
INSERT INTO `_Mimoto_output` VALUES (2, NULL, '2017-09-20 19:00:51');
INSERT INTO `_Mimoto_output` VALUES (4, '0', '2017-09-22 18:39:15');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_output_container
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_output_container`;
CREATE TABLE `_Mimoto_output_container` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_output_container
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_output_container` VALUES (1, 'feed', '2017-09-20 18:58:06');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_route
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_route`;
CREATE TABLE `_Mimoto_route` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_route
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_route` VALUES (1, 'Feed', '2017-09-20 18:49:32');
INSERT INTO `_Mimoto_route` VALUES (2, 'Article', '2017-09-20 19:00:27');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_route_path_element
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_route_path_element`;
CREATE TABLE `_Mimoto_route_path_element` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `staticValue` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `varName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_route_path_element
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_route_path_element` VALUES (1, 'static', 'publisher', NULL, '2017-09-20 18:50:15');
INSERT INTO `_Mimoto_route_path_element` VALUES (2, 'static', 'publisher', NULL, '2017-09-20 19:00:27');
INSERT INTO `_Mimoto_route_path_element` VALUES (3, 'slash', NULL, NULL, '2017-09-20 19:00:27');
INSERT INTO `_Mimoto_route_path_element` VALUES (4, 'static', 'article', NULL, '2017-09-20 19:00:27');
INSERT INTO `_Mimoto_route_path_element` VALUES (5, 'slash', NULL, NULL, '2017-09-20 19:00:27');
INSERT INTO `_Mimoto_route_path_element` VALUES (6, 'var', '', 'nArticleId', '2017-09-20 19:00:27');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_selection
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selection`;
CREATE TABLE `_Mimoto_selection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_selection
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_selection` VALUES (1, 'allArticles', '2017-09-20 18:52:38');
INSERT INTO `_Mimoto_selection` VALUES (3, 'potentialPage', '2017-09-21 09:55:26');
INSERT INTO `_Mimoto_selection` VALUES (5, 'allMemberTypes', '2017-09-30 17:31:59');
INSERT INTO `_Mimoto_selection` VALUES (6, 'allArticleTypes', '2017-10-01 17:31:35');
INSERT INTO `_Mimoto_selection` VALUES (8, NULL, '2017-11-27 01:28:25');
INSERT INTO `_Mimoto_selection` VALUES (10, 'article', '2017-11-29 10:54:41');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_selection_rule
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selection_rule`;
CREATE TABLE `_Mimoto_selection_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeAsVar` int(1) DEFAULT NULL,
  `typeVarName` varchar(255) DEFAULT NULL,
  `idAsVar` int(1) DEFAULT NULL,
  `idVarName` varchar(255) DEFAULT NULL,
  `propertyAsVar` int(1) DEFAULT NULL,
  `propertyVarName` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_selection_rule
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_selection_rule` VALUES (1, 0, 'dgdfgdgdf', NULL, NULL, NULL, NULL, '2017-09-20 18:53:10');
INSERT INTO `_Mimoto_selection_rule` VALUES (2, NULL, NULL, 1, 'nArticleId', NULL, NULL, '2017-09-20 19:01:37');
INSERT INTO `_Mimoto_selection_rule` VALUES (3, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-21 09:55:38');
INSERT INTO `_Mimoto_selection_rule` VALUES (4, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-01 15:32:24');
INSERT INTO `_Mimoto_selection_rule` VALUES (5, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-01 17:31:50');
INSERT INTO `_Mimoto_selection_rule` VALUES (6, NULL, NULL, NULL, NULL, NULL, NULL, '2017-11-27 01:14:11');
INSERT INTO `_Mimoto_selection_rule` VALUES (7, NULL, NULL, NULL, NULL, NULL, NULL, '2017-11-27 01:33:46');
INSERT INTO `_Mimoto_selection_rule` VALUES (8, NULL, NULL, NULL, NULL, NULL, NULL, '2017-11-27 01:33:48');
INSERT INTO `_Mimoto_selection_rule` VALUES (9, NULL, NULL, NULL, NULL, NULL, NULL, '2017-11-27 01:33:51');
INSERT INTO `_Mimoto_selection_rule` VALUES (10, 0, NULL, NULL, NULL, NULL, NULL, '2017-11-29 23:07:14');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_service
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_service`;
CREATE TABLE `_Mimoto_service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_service
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_service` VALUES (3, 'SuperSimpleMail', 'SuperSimpleMail/SuperSimpleMail.php', NULL, '2017-10-18 17:32:27');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_service_function
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_service_function`;
CREATE TABLE `_Mimoto_service_function` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_service_function
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_service_function` VALUES (1, 'SuperSimpleMail', '2017-10-18 16:18:51');
INSERT INTO `_Mimoto_service_function` VALUES (5, 'sendMail', '2017-10-18 17:32:44');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_user
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_user`;
CREATE TABLE `_Mimoto_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_user
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_user` VALUES (1, 'Sebastian', 'Kersten', 'sebastian@momkai.com', '{\"salt\":\"d2329282b91630f540cecd2af121a8b67b1d12d84f2766f8bb11f331b957e4f9\",\"iterations\":50000,\"hash\":\"5e2b2ca87196fd3e16bad6e2e663a9b66b0808d93ee97cb3bdeeeb7e4c34f79a\"}', NULL);
INSERT INTO `_Mimoto_user` VALUES (2, 'Maaike', 'Goslinga', 'maaike@decorrespondent.nl', '{\"salt\":\"25b0d9b27d7eddf0736fbfe8bb4fe7be37d4e144bea7d2c0d4a0f21329323d46\",\"iterations\":50000,\"hash\":\"41d7beb60f6b900369b95ea1f21ce94ed4d5949bda126d78b4edcd3102e21425\"}', '2017-09-21 12:11:17');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_user_role
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_user_role`;
CREATE TABLE `_Mimoto_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of _Mimoto_user_role
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_user_role` VALUES (1, 'member', '2017-09-20 18:36:42');
COMMIT;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `lede` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of article
-- ----------------------------
BEGIN;
INSERT INTO `article` VALUES (1, 'yyy', '<p>De caissière in de supermarkt vraagt op een dag wat ik eigenlijk voor werk doe. Ik schrijf, zeg ik. Waarover? Over batterijen.</p><p>Ze trekt een vies gezicht. ‘Mijn zoontje zat laatst twee batterijen hard tegen elkaar aan te wrijven. Ze werden warm en ik was bang dat ze zouden ontploffen. Ik ben met ze naar buiten gerend en heb ze in de tuin gegooid.’</p><p>Ik antwoord, bijna automatisch: ‘In de tuin? Je kunt ze toch hier inleveren, in de bak bij de voordeur?’ Maar de batterijen leken haar te gevaarlijk om nog aan te raken.</p><h3>dsfsdfsdfsd</h3><p>En ze is niet de enige. We zien batterijen als een noodzakelijk kwaad dat inmiddels overal in huis te vinden is - in telefoons en laptops, accuboren en afstandsbedieningen, babyfoons en gehoorapparaten. We kunnen niet zonder, maar blij worden we er niet van.</p><p>Dit verhaal is voor mijn caissière en voor iedereen die bij het woord batterijen een ongemakkelijk gevoel krijgt. Ik begon ze zelf pas te begrijpen toen ik me serieus in batterijen verdiepte&nbsp;en ben pas echt overtuigd geraakt toen ik voor dit verhaal bij een Belgische batterijenrecyclingfabriek op bezoek ging.</p><p><em>Hier vind je mijn eerdere verhalen over batterijen.</em></p><p>Maar nu weet ik het zeker. Batterijen zijn de beste technologische oplossing die we nu hebben voor het echte giftige en explosieve probleem op deze wereld: olie.</p><p><br></p>', 'Batterijen zijn schadelijk voor het milieu, vertelt de overheid ons al jaren. Het is een achterhaalde en verkeerde boodschap. Batterijen maken niet alleen schone auto’s mogelijk, ze vormen ook een herbruikbare grondstoffenbron die steeds planeetvriendelijker wordt.3', '2017-09-20 18:45:38');
INSERT INTO `article` VALUES (2, 'Kijken: Hoe peil je een peiling? Ik geef 3 tips', '<p>dfgsdgfdgsdfgsd</p>', '<p>Brexit, Donald Trump, keer op keer zaten de peilingen ernaast. Toch vliegen ze je ook nu weer om de oren. Daarom: 3 tips waardoor je beter weet wat je aan peilingen hebt in de aankomende Tweede Kamerverkiezingen.</p>', '2017-09-24 12:07:20');
COMMIT;

-- ----------------------------
-- Table structure for articleType
-- ----------------------------
DROP TABLE IF EXISTS `articleType`;
CREATE TABLE `articleType` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of articleType
-- ----------------------------
BEGIN;
INSERT INTO `articleType` VALUES (1, 'Verhaal van de dag', 'storyoftheday', '2017-10-01 17:30:28');
INSERT INTO `articleType` VALUES (2, 'Explainer', 'explainer', '2017-10-01 17:30:45');
INSERT INTO `articleType` VALUES (3, 'Column', 'column', '2017-10-01 17:30:52');
COMMIT;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of comment
-- ----------------------------
BEGIN;
INSERT INTO `comment` VALUES (12, 'Hoi Maaike', '2017-09-21 13:39:05');
INSERT INTO `comment` VALUES (13, 'Hoi Sebastian', '2017-09-21 13:39:11');
INSERT INTO `comment` VALUES (15, 'sdhfsjkfhjksfsdf', '2017-10-04 10:12:03');
COMMIT;

-- ----------------------------
-- Table structure for displaycomponentGH
-- ----------------------------
DROP TABLE IF EXISTS `displaycomponentGH`;
CREATE TABLE `displaycomponentGH` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `biography` text COLLATE utf8_unicode_ci,
  `topic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of displaycomponentGH
-- ----------------------------
BEGIN;
INSERT INTO `displaycomponentGH` VALUES (1, '<p>Thalia Verkade (1979) studeerde Slavische Talen en Culturen in Groningen en Moskou en Mediawetenschappen in Berlijn. Ze was eerder redacteur bij nrc.next en correspondent in Moskou voor NRC Handelsblad.</p>', 'Mobiliteit', 'Thalia', NULL, '2017-09-30 14:06:38');
COMMIT;

-- ----------------------------
-- Table structure for element1
-- ----------------------------
DROP TABLE IF EXISTS `element1`;
CREATE TABLE `element1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of element1
-- ----------------------------
BEGIN;
INSERT INTO `element1` VALUES (2, 'aaa', NULL, '2017-09-21 09:47:37');
INSERT INTO `element1` VALUES (3, 'dshfkjadshfkjashkdfasdf sadfas dfsad f', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>', '2017-10-25 17:56:50');
COMMIT;

-- ----------------------------
-- Table structure for element2
-- ----------------------------
DROP TABLE IF EXISTS `element2`;
CREATE TABLE `element2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `element2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of element2
-- ----------------------------
BEGIN;
INSERT INTO `element2` VALUES (1, 'bbb', '2017-09-21 09:47:42');
INSERT INTO `element2` VALUES (2, 'xxx', '2017-09-24 14:55:31');
INSERT INTO `element2` VALUES (3, 'fdgdgdgdfgdfg', '2017-10-25 17:45:14');
COMMIT;

-- ----------------------------
-- Table structure for memberType
-- ----------------------------
DROP TABLE IF EXISTS `memberType`;
CREATE TABLE `memberType` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of memberType
-- ----------------------------
BEGIN;
INSERT INTO `memberType` VALUES (1, 'author', 'Author', '2017-09-30 13:45:16');
INSERT INTO `memberType` VALUES (2, 'reader', 'Reader', '2017-09-30 13:45:22');
INSERT INTO `memberType` VALUES (3, 'editor', 'Editor', '2017-09-30 13:46:12');
COMMIT;

-- ----------------------------
-- Table structure for page
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of page
-- ----------------------------
BEGIN;
INSERT INTO `page` VALUES (1, 'Potential', '2017-09-21 09:11:43');
INSERT INTO `page` VALUES (3, 'aaaaa', '2017-09-24 14:55:18');
COMMIT;

-- ----------------------------
-- Table structure for xxx
-- ----------------------------
DROP TABLE IF EXISTS `xxx`;
CREATE TABLE `xxx` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for xxxxxr
-- ----------------------------
DROP TABLE IF EXISTS `xxxxxr`;
CREATE TABLE `xxxxxr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
