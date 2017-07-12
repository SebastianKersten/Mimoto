/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : localhost:3306
 Source Schema         : mimoto.cms

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 12/07/2017 19:02:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for _Mimoto_action
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_action`;
CREATE TABLE `_Mimoto_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity` varchar(255) NOT NULL,
  `connectiontable` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for _Mimoto_component
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component`;
CREATE TABLE `_Mimoto_component` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_component
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component` VALUES (1, 'feed', 'publisher/Feed/Feed.twig', '2017-04-21 14:14:16');
INSERT INTO `_Mimoto_component` VALUES (2, 'feeditem', 'publisher/FeedItem/FeedItem.twig', '2017-04-21 14:14:33');
INSERT INTO `_Mimoto_component` VALUES (3, 'article', 'publisher/Article/Article.twig', '2017-04-21 14:17:45');
INSERT INTO `_Mimoto_component` VALUES (4, 'feeditem', 'publisher/FeedItem/FeedItemExplainer.twig', '2017-04-21 14:34:21');
INSERT INTO `_Mimoto_component` VALUES (5, 'comment', 'publisher/Comment/Comment.twig', '2017-04-21 14:37:51');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_componentconditional
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_componentconditional`;
CREATE TABLE `_Mimoto_componentconditional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_componentconditional
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_componentconditional` VALUES (1, 'propertyValue', 'regular', '2017-04-21 14:34:50');
INSERT INTO `_Mimoto_componentconditional` VALUES (2, 'propertyValue', 'explainer', '2017-04-21 14:35:06');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_connection
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_connection`;
CREATE TABLE `_Mimoto_connection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_property_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=501 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_connection
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_connection` VALUES (6, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (7, '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (8, '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (9, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (14, '_Mimoto_entitypropertysetting', '3', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', 0);
INSERT INTO `_Mimoto_connection` VALUES (15, '_Mimoto_entityproperty', '3', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (16, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '3', 3);
INSERT INTO `_Mimoto_connection` VALUES (19, '_Mimoto_entity', '2', '_Mimoto_entity--components', '_Mimoto_component', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (22, '_Mimoto_form_input_image', '1', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (24, '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_output_title', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (25, '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '1', 1);
INSERT INTO `_Mimoto_connection` VALUES (26, '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '1', 2);
INSERT INTO `_Mimoto_connection` VALUES (27, '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '1', 4);
INSERT INTO `_Mimoto_connection` VALUES (28, '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_image', '1', 5);
INSERT INTO `_Mimoto_connection` VALUES (29, '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '2', 6);
INSERT INTO `_Mimoto_connection` VALUES (30, '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '1', 7);
INSERT INTO `_Mimoto_connection` VALUES (31, '_Mimoto_entity', '2', '_Mimoto_entity--forms', '_Mimoto_form', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (32, '_Mimoto_contentsection', '1', '_Mimoto_contentsection--form', '_Mimoto_form', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (33, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (35, '_Mimoto_contentsection', '1', '_Mimoto_contentsection--contentItems', '2', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (37, '_Mimoto_contentsection', '1', '_Mimoto_contentsection--contentItems', '2', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (38, '2', '3', '3', '_Mimoto_file', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (39, '_Mimoto_contentsection', '1', '_Mimoto_contentsection--contentItems', '2', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (40, '2', '2', '3', '_Mimoto_file', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (41, '_Mimoto_entityproperty', '5', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (42, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (43, '_Mimoto_form_input_radiobutton', '1', '_Mimoto_form_input_radiobutton--value', '_Mimoto_entityproperty', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (44, '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_radiobutton', '1', 3);
INSERT INTO `_Mimoto_connection` VALUES (45, '_Mimoto_form_input_radiobutton', '1', '_Mimoto_form_input_radiobutton--options', '_Mimoto_form_inputoption', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (46, '_Mimoto_form_input_radiobutton', '1', '_Mimoto_form_input_radiobutton--options', '_Mimoto_form_inputoption', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (47, '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '4', 2);
INSERT INTO `_Mimoto_connection` VALUES (48, '_Mimoto_componentconditional', '1', '_Mimoto_componentconditional--entityProperty', '_Mimoto_entityproperty', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (49, '_Mimoto_component', '2', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (50, '_Mimoto_componentconditional', '2', '_Mimoto_componentconditional--entityProperty', '_Mimoto_entityproperty', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (51, '_Mimoto_component', '4', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (52, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (53, '_Mimoto_entityproperty', '6', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (54, '_Mimoto_entity', '3', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (55, '_Mimoto_entity', '3', '_Mimoto_entity--components', '_Mimoto_component', '5', 0);
INSERT INTO `_Mimoto_connection` VALUES (56, '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '7', 0);
INSERT INTO `_Mimoto_connection` VALUES (57, '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '8', 1);
INSERT INTO `_Mimoto_connection` VALUES (58, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '7', 5);
INSERT INTO `_Mimoto_connection` VALUES (59, '_Mimoto_entitypropertysetting', '7', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (60, '2', '1', '7', '3', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (61, '2', '1', '7', '3', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (62, '2', '1', '7', '3', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (64, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--users', '_Mimoto_user', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (65, '_Mimoto_user', '2', '_Mimoto_user--avatar', '_Mimoto_file', '6', 0);
INSERT INTO `_Mimoto_connection` VALUES (66, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--users', '_Mimoto_user', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (100, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '4', 3);
INSERT INTO `_Mimoto_connection` VALUES (105, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--users', '_Mimoto_user', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (108, '_Mimoto_entitypropertysetting', '12', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', 0);
INSERT INTO `_Mimoto_connection` VALUES (109, '_Mimoto_entityproperty', '11', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '12', 0);
INSERT INTO `_Mimoto_connection` VALUES (110, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '11', 2);
INSERT INTO `_Mimoto_connection` VALUES (114, '_Mimoto_form_input_image', '2', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '11', 0);
INSERT INTO `_Mimoto_connection` VALUES (115, '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_output_title', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (116, '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (117, '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '2', 2);
INSERT INTO `_Mimoto_connection` VALUES (118, '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '3', 3);
INSERT INTO `_Mimoto_connection` VALUES (119, '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '3', 4);
INSERT INTO `_Mimoto_connection` VALUES (120, '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_input_image', '2', 5);
INSERT INTO `_Mimoto_connection` VALUES (121, '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '2', 6);
INSERT INTO `_Mimoto_connection` VALUES (122, '_Mimoto_entity', '4', '_Mimoto_entity--forms', '_Mimoto_form', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (142, '_Mimoto_entityproperty', '17', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '23', 0);
INSERT INTO `_Mimoto_connection` VALUES (143, '_Mimoto_entityproperty', '17', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '24', 1);
INSERT INTO `_Mimoto_connection` VALUES (144, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '17', 1);
INSERT INTO `_Mimoto_connection` VALUES (148, '_Mimoto_entityproperty', '19', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '27', 0);
INSERT INTO `_Mimoto_connection` VALUES (149, '_Mimoto_entityproperty', '19', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '28', 1);
INSERT INTO `_Mimoto_connection` VALUES (150, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '19', 3);
INSERT INTO `_Mimoto_connection` VALUES (188, '_Mimoto_entityproperty', '20', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '29', 0);
INSERT INTO `_Mimoto_connection` VALUES (189, '_Mimoto_entityproperty', '20', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '30', 1);
INSERT INTO `_Mimoto_connection` VALUES (190, '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '20', 0);
INSERT INTO `_Mimoto_connection` VALUES (192, '_Mimoto_entitypropertysetting', '30', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_coreform_formattingoption-bold', 1);
INSERT INTO `_Mimoto_connection` VALUES (193, '_Mimoto_entitypropertysetting', '30', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_coreform_formattingoption-code', 2);
INSERT INTO `_Mimoto_connection` VALUES (198, '_Mimoto_form_input_textline', '2', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '20', 0);
INSERT INTO `_Mimoto_connection` VALUES (199, '_Mimoto_form_input_textblock', '3', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '17', 0);
INSERT INTO `_Mimoto_connection` VALUES (200, '_Mimoto_form_input_textline', '3', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '19', 0);
INSERT INTO `_Mimoto_connection` VALUES (201, '_Mimoto_entityproperty', '21', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '31', 0);
INSERT INTO `_Mimoto_connection` VALUES (202, '_Mimoto_entityproperty', '21', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '32', 1);
INSERT INTO `_Mimoto_connection` VALUES (203, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '21', 2);
INSERT INTO `_Mimoto_connection` VALUES (206, '_Mimoto_form_input_textblock', '2', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '21', 0);
INSERT INTO `_Mimoto_connection` VALUES (224, '_Mimoto_entityproperty', '22', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '33', 0);
INSERT INTO `_Mimoto_connection` VALUES (225, '_Mimoto_entityproperty', '22', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '34', 1);
INSERT INTO `_Mimoto_connection` VALUES (226, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '22', 1);
INSERT INTO `_Mimoto_connection` VALUES (227, '_Mimoto_entityproperty', '23', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '35', 0);
INSERT INTO `_Mimoto_connection` VALUES (228, '_Mimoto_entityproperty', '23', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '36', 1);
INSERT INTO `_Mimoto_connection` VALUES (229, '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '23', 0);
INSERT INTO `_Mimoto_connection` VALUES (230, '_Mimoto_form_input_textline', '1', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '23', 0);
INSERT INTO `_Mimoto_connection` VALUES (231, '_Mimoto_form_input_textblock', '1', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '22', 0);
INSERT INTO `_Mimoto_connection` VALUES (269, '_Mimoto_entity', '2', '_Mimoto_entity--forms', '_Mimoto_form', '3', 1);
INSERT INTO `_Mimoto_connection` VALUES (270, '_Mimoto_form_input_textblock', '4', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '21', 0);
INSERT INTO `_Mimoto_connection` VALUES (271, '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (275, '_Mimoto_contentsection', '3', '_Mimoto_contentsection--form', '_Mimoto_form', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (276, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '3', 1);
INSERT INTO `_Mimoto_connection` VALUES (282, '_Mimoto_contentsection', '3', '_Mimoto_contentsection--contentItem', '2', '4', 0);
INSERT INTO `_Mimoto_connection` VALUES (300, '2', '1', '3', '_Mimoto_file', '27', 0);
INSERT INTO `_Mimoto_connection` VALUES (312, '_Mimoto_entitypropertysetting', '32', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-italic', 2);
INSERT INTO `_Mimoto_connection` VALUES (313, '_Mimoto_entitypropertysetting', '32', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-header', 0);
INSERT INTO `_Mimoto_connection` VALUES (316, '_Mimoto_entitypropertysetting', '32', '_Mimoto_entitypropertysetting--formattingOptions', '_Mimoto_formattingoption', '_Mimoto_formattingoption-bold', 3);
INSERT INTO `_Mimoto_connection` VALUES (317, '_Mimoto_user', '1', '_Mimoto_user--avatar', '_Mimoto_file', '28', 0);
INSERT INTO `_Mimoto_connection` VALUES (325, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--userRoles', '_Mimoto_user_role', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (326, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--userRoles', '_Mimoto_user_role', '4', 2);
INSERT INTO `_Mimoto_connection` VALUES (351, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--formattingOptions', '_Mimoto_formattingoption', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (356, '_Mimoto_page', '1', '_Mimoto_page--roles', '_Mimoto_user_role', '_Mimoto_user_role-superuser', 0);
INSERT INTO `_Mimoto_connection` VALUES (357, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--pages', '_Mimoto_route', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (366, '_Mimoto_route', '1', '_Mimoto_page--allowedUserRoles', '_Mimoto_user_role', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (367, '_Mimoto_route', '1', '_Mimoto_page--allowedUserRoles', '_Mimoto_user_role', '_Mimoto_user_role-superuser', 1);
INSERT INTO `_Mimoto_connection` VALUES (374, '_Mimoto_user', '1', '_Mimoto_user--roles', '_Mimoto_user_role', '3', 1);
INSERT INTO `_Mimoto_connection` VALUES (380, '_Mimoto_user', '1', '_Mimoto_user--roles', '_Mimoto_user_role', '_Mimoto_user_role-superuser', 1);
INSERT INTO `_Mimoto_connection` VALUES (381, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (382, '_Mimoto_selectionrule', '1', '_Mimoto_selectionrule--entity', '_Mimoto_entity', '2', 0);
INSERT INTO `_Mimoto_connection` VALUES (383, '_Mimoto_selection', '2', '_Mimoto_selection--rules', '_Mimoto_selectionrule', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (384, '_Mimoto_route', '1', '_Mimoto_route--allowedUserRoles', '_Mimoto_user_role', '_Mimoto_user_role-superuser', 0);
INSERT INTO `_Mimoto_connection` VALUES (385, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '1', 0);
INSERT INTO `_Mimoto_connection` VALUES (386, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '2', 1);
INSERT INTO `_Mimoto_connection` VALUES (387, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '3', 2);
INSERT INTO `_Mimoto_connection` VALUES (388, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '4', 2);
INSERT INTO `_Mimoto_connection` VALUES (389, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '5', 4);
INSERT INTO `_Mimoto_connection` VALUES (390, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '6', 4);
INSERT INTO `_Mimoto_connection` VALUES (391, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '7', 6);
INSERT INTO `_Mimoto_connection` VALUES (392, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '8', 7);
INSERT INTO `_Mimoto_connection` VALUES (393, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '9', 8);
INSERT INTO `_Mimoto_connection` VALUES (394, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '10', 9);
INSERT INTO `_Mimoto_connection` VALUES (395, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '11', 10);
INSERT INTO `_Mimoto_connection` VALUES (396, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '12', 11);
INSERT INTO `_Mimoto_connection` VALUES (397, '_Mimoto_route', '1', '_Mimoto_route--path', '_Mimoto_route_path', '13', 0);
INSERT INTO `_Mimoto_connection` VALUES (398, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '13', 12);
INSERT INTO `_Mimoto_connection` VALUES (399, '_Mimoto_route_path', '13', '_Mimoto_route_path--elements', '_Mimoto_route_path_element', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (400, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '14', 13);
INSERT INTO `_Mimoto_connection` VALUES (401, '_Mimoto_route_path', '13', '_Mimoto_route_path--elements', '_Mimoto_route_path_element', '4', 1);
INSERT INTO `_Mimoto_connection` VALUES (402, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '15', 14);
INSERT INTO `_Mimoto_connection` VALUES (404, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '16', 15);
INSERT INTO `_Mimoto_connection` VALUES (406, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '17', 16);
INSERT INTO `_Mimoto_connection` VALUES (408, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '18', 17);
INSERT INTO `_Mimoto_connection` VALUES (410, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '19', 18);
INSERT INTO `_Mimoto_connection` VALUES (412, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '20', 19);
INSERT INTO `_Mimoto_connection` VALUES (414, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '21', 20);
INSERT INTO `_Mimoto_connection` VALUES (416, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '22', 21);
INSERT INTO `_Mimoto_connection` VALUES (418, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '23', 22);
INSERT INTO `_Mimoto_connection` VALUES (420, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '24', 23);
INSERT INTO `_Mimoto_connection` VALUES (422, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '25', 24);
INSERT INTO `_Mimoto_connection` VALUES (424, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '26', 25);
INSERT INTO `_Mimoto_connection` VALUES (426, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '27', 26);
INSERT INTO `_Mimoto_connection` VALUES (428, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '28', 27);
INSERT INTO `_Mimoto_connection` VALUES (430, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '29', 28);
INSERT INTO `_Mimoto_connection` VALUES (432, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '30', 29);
INSERT INTO `_Mimoto_connection` VALUES (434, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '31', 30);
INSERT INTO `_Mimoto_connection` VALUES (436, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '32', 31);
INSERT INTO `_Mimoto_connection` VALUES (438, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '33', 32);
INSERT INTO `_Mimoto_connection` VALUES (440, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '34', 33);
INSERT INTO `_Mimoto_connection` VALUES (442, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '35', 34);
INSERT INTO `_Mimoto_connection` VALUES (444, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '36', 35);
INSERT INTO `_Mimoto_connection` VALUES (446, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '37', 36);
INSERT INTO `_Mimoto_connection` VALUES (448, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '38', 37);
INSERT INTO `_Mimoto_connection` VALUES (450, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '39', 38);
INSERT INTO `_Mimoto_connection` VALUES (452, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '40', 39);
INSERT INTO `_Mimoto_connection` VALUES (454, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '41', 40);
INSERT INTO `_Mimoto_connection` VALUES (456, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '42', 41);
INSERT INTO `_Mimoto_connection` VALUES (458, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '43', 42);
INSERT INTO `_Mimoto_connection` VALUES (460, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '44', 43);
INSERT INTO `_Mimoto_connection` VALUES (462, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '45', 44);
INSERT INTO `_Mimoto_connection` VALUES (464, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '46', 45);
INSERT INTO `_Mimoto_connection` VALUES (466, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '47', 46);
INSERT INTO `_Mimoto_connection` VALUES (468, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '48', 47);
INSERT INTO `_Mimoto_connection` VALUES (470, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '49', 48);
INSERT INTO `_Mimoto_connection` VALUES (472, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '50', 49);
INSERT INTO `_Mimoto_connection` VALUES (474, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '51', 50);
INSERT INTO `_Mimoto_connection` VALUES (476, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '52', 51);
INSERT INTO `_Mimoto_connection` VALUES (478, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '53', 52);
INSERT INTO `_Mimoto_connection` VALUES (480, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '54', 53);
INSERT INTO `_Mimoto_connection` VALUES (482, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '55', 54);
INSERT INTO `_Mimoto_connection` VALUES (484, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '56', 55);
INSERT INTO `_Mimoto_connection` VALUES (486, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '57', 56);
INSERT INTO `_Mimoto_connection` VALUES (488, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '58', 57);
INSERT INTO `_Mimoto_connection` VALUES (490, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '59', 58);
INSERT INTO `_Mimoto_connection` VALUES (492, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '60', 59);
INSERT INTO `_Mimoto_connection` VALUES (494, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '61', 60);
INSERT INTO `_Mimoto_connection` VALUES (495, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '62', 61);
INSERT INTO `_Mimoto_connection` VALUES (496, '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '63', 62);
INSERT INTO `_Mimoto_connection` VALUES (498, '_Mimoto_route', '1', '_Mimoto_route--output', '_Mimoto_output', '56', 0);
INSERT INTO `_Mimoto_connection` VALUES (499, '_Mimoto_output', '56', '_Mimoto_entity--component', '_Mimoto_component', '3', 0);
INSERT INTO `_Mimoto_connection` VALUES (500, '_Mimoto_output', '56', '_Mimoto_output--selection', '_Mimoto_selection', '2', 0);
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_contentsection
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_contentsection`;
CREATE TABLE `_Mimoto_contentsection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `isHiddenFromMenu` enum('0','1') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_contentsection
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_contentsection` VALUES (1, 'Articles', 'group', '0', '2017-04-21 14:19:41');
INSERT INTO `_Mimoto_contentsection` VALUES (3, 'Textblock test', 'item', '0', '2017-05-12 09:54:08');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_entity
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entity`;
CREATE TABLE `_Mimoto_entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `isAbstract` enum('0','1') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_entity
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entity` VALUES (1, 'components', NULL, '2017-04-21 14:13:24');
INSERT INTO `_Mimoto_entity` VALUES (2, 'article', NULL, '2017-04-21 14:14:54');
INSERT INTO `_Mimoto_entity` VALUES (3, 'comment', NULL, '2017-04-21 14:37:26');
INSERT INTO `_Mimoto_entity` VALUES (4, 'infocard', NULL, '2017-04-30 17:58:07');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_entityproperty
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entityproperty`;
CREATE TABLE `_Mimoto_entityproperty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_entityproperty
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entityproperty` VALUES (3, 'headerImage', 'entity', 'image', '2017-04-21 14:16:42');
INSERT INTO `_Mimoto_entityproperty` VALUES (5, 'type', 'value', NULL, '2017-04-21 14:31:11');
INSERT INTO `_Mimoto_entityproperty` VALUES (6, 'message', 'value', NULL, '2017-04-21 14:37:35');
INSERT INTO `_Mimoto_entityproperty` VALUES (7, 'comments', 'collection', NULL, '2017-04-21 14:38:34');
INSERT INTO `_Mimoto_entityproperty` VALUES (11, 'image', 'entity', 'image', '2017-05-01 10:39:36');
INSERT INTO `_Mimoto_entityproperty` VALUES (14, 'title', 'value', NULL, '2017-05-02 10:46:13');
INSERT INTO `_Mimoto_entityproperty` VALUES (17, 'summary', 'value', NULL, '2017-05-02 11:12:26');
INSERT INTO `_Mimoto_entityproperty` VALUES (19, 'link', 'value', NULL, '2017-05-02 11:13:37');
INSERT INTO `_Mimoto_entityproperty` VALUES (20, 'title', 'value', NULL, '2017-05-02 16:11:02');
INSERT INTO `_Mimoto_entityproperty` VALUES (21, 'body', 'value', NULL, '2017-05-02 16:40:45');
INSERT INTO `_Mimoto_entityproperty` VALUES (22, 'lede', 'value', NULL, '2017-05-03 12:27:05');
INSERT INTO `_Mimoto_entityproperty` VALUES (23, 'title', 'value', NULL, '2017-05-03 12:27:21');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_entitypropertysetting
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entitypropertysetting`;
CREATE TABLE `_Mimoto_entitypropertysetting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `markup` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_entitypropertysetting
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (3, 'allowedEntityType', NULL, NULL, NULL, '2017-04-21 14:16:42');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (5, 'type', 'text', 'textline', NULL, '2017-04-21 14:31:11');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (6, 'type', 'text', 'textblock', NULL, '2017-04-21 14:37:35');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (7, 'allowedEntityTypes', '', '', NULL, '2017-04-21 14:38:34');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (8, 'allowDuplicates', 'boolean', '', NULL, '2017-04-21 14:38:34');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (12, 'allowedEntityType', NULL, NULL, NULL, '2017-05-01 10:39:36');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (13, 'type', 'text', 'textline', NULL, '2017-05-02 10:41:58');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (14, 'formattingOption', '', '', NULL, '2017-05-02 10:41:58');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (15, 'type', 'text', 'textline', NULL, '2017-05-02 10:42:11');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (17, 'type', 'text', 'textline', NULL, '2017-05-02 10:46:13');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (23, 'type', 'text', 'textline', NULL, '2017-05-02 11:12:26');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (24, 'formattingOptions', '', '', NULL, '2017-05-02 11:12:26');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (27, 'type', 'text', 'textline', NULL, '2017-05-02 11:13:37');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (28, 'formattingOptions', '', '', NULL, '2017-05-02 11:13:37');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (29, 'type', 'text', 'textline', NULL, '2017-05-02 16:11:02');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (30, 'formattingOptions', '', '', NULL, '2017-05-02 16:11:02');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (31, 'type', 'text', 'textblock', NULL, '2017-05-02 16:40:45');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (32, 'formattingOptions', '', '', NULL, '2017-05-02 16:40:45');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (33, 'type', 'text', 'textblock', NULL, '2017-05-03 12:27:05');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (34, 'formattingOptions', '', '', NULL, '2017-05-03 12:27:05');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (35, 'type', 'text', 'textline', NULL, '2017-05-03 12:27:21');
INSERT INTO `_Mimoto_entitypropertysetting` VALUES (36, 'formattingOptions', '', '', NULL, '2017-05-03 12:27:21');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_file
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_file`;
CREATE TABLE `_Mimoto_file` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_file
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_file` VALUES (1, '782471afb9ea94d623ec7d4c76f94da6.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-04-21 14:20:44');
INSERT INTO `_Mimoto_file` VALUES (2, 'e8e975b227c89f8f8745c0b90fa43f57.jpg', 'dynamic/', 'image/jpeg', 1552104, 4408, 2480, 1.77742, 'knvb.jpg', '2017-04-21 14:23:09');
INSERT INTO `_Mimoto_file` VALUES (3, '0019edef2f8afe34ddde3273ee66824d.jpg', 'dynamic/', 'image/jpeg', 325663, 1920, 1037, 1.85149, 'ghostintheshell.jpg', '2017-04-21 14:24:05');
INSERT INTO `_Mimoto_file` VALUES (4, '027c14101c9acdcb1a07b74f1aa310ad.gif', 'dynamic/', 'image/gif', 5307379, 1920, 823, 2.33293, 'peilingen.gif', '2017-04-21 14:26:12');
INSERT INTO `_Mimoto_file` VALUES (5, '32a70c60a83e8928d9f19a7e026f46c1.png', 'dynamic/', 'image/png', 24970, 126, 126, 1.00000, 'sebastian.png', '2017-04-22 12:19:12');
INSERT INTO `_Mimoto_file` VALUES (6, '18a5c529d9eaea2b2d4ed3f0fa4f0f3e.jpeg', 'dynamic/', 'image/jpeg', 134734, 750, 1061, 0.70688, 'hilde.jpeg', '2017-04-22 12:20:01');
INSERT INTO `_Mimoto_file` VALUES (7, '9b40de284b768ccc42c94f76923c96cd.jpeg', 'dynamic/', 'image/jpeg', 134734, 750, 1061, 0.70688, 'hilde.jpeg', '2017-04-24 10:53:07');
INSERT INTO `_Mimoto_file` VALUES (8, '22b0131cfe7e650e0984b9597af953ff.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-04-24 10:53:24');
INSERT INTO `_Mimoto_file` VALUES (9, 'bcc9ea1b3a4e41d68e3eb82a3a79544c.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-04-24 10:53:46');
INSERT INTO `_Mimoto_file` VALUES (10, '2b1cfa07b20d84f45e0273f019a53ce5.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-04-24 10:57:39');
INSERT INTO `_Mimoto_file` VALUES (11, '494dbc0c63b2601fbf3ed5611914ba76.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-04-24 10:58:29');
INSERT INTO `_Mimoto_file` VALUES (12, NULL, 'dynamic/', NULL, NULL, NULL, NULL, NULL, '2017.04.20 - ABN Amro - Wijzigingformulier meegroeiverzekering.pdf', '2017-04-24 10:58:47');
INSERT INTO `_Mimoto_file` VALUES (13, 'bc9a67face04da39e7a192161c0221bb.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-04-24 11:03:07');
INSERT INTO `_Mimoto_file` VALUES (14, '1b777694932a51fa43557dc9feb7d7d7.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-04-24 11:03:22');
INSERT INTO `_Mimoto_file` VALUES (15, '45888ccebdb745f4fdf3b7f602e1937c.jpg', 'dynamic/', 'image/jpeg', 1552104, 4408, 2480, 1.77742, 'knvb.jpg', '2017-04-24 11:04:53');
INSERT INTO `_Mimoto_file` VALUES (16, '59fa25738b41b8ed95a93137c548a9cc.jpg', 'dynamic/', 'image/jpeg', 325663, 1920, 1037, 1.85149, 'ghostintheshell.jpg', '2017-04-24 11:05:07');
INSERT INTO `_Mimoto_file` VALUES (17, 'd975ef609a7356013b9642584a779040.jpg', 'dynamic/', 'image/jpeg', 325663, 1920, 1037, 1.85149, 'ghostintheshell.jpg', '2017-05-14 16:37:43');
INSERT INTO `_Mimoto_file` VALUES (18, '0339fc0b4e6af7844ffea3621f98249f.jpg', 'dynamic/', 'image/jpeg', 325663, 1920, 1037, 1.85149, 'ghostintheshell.jpg', '2017-05-14 16:38:28');
INSERT INTO `_Mimoto_file` VALUES (19, '30e1ac03d3dde54ca5dbb3ed5e0f024d.jpg', 'dynamic/', 'image/jpeg', 325663, 1920, 1037, 1.85149, 'ghostintheshell.jpg', '2017-05-14 16:39:17');
INSERT INTO `_Mimoto_file` VALUES (20, 'f7b579a42664d9a8b72f909d17c17341.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-05-14 16:41:23');
INSERT INTO `_Mimoto_file` VALUES (21, '660f46489a5ba53ef327689828ac80f1.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-05-14 16:41:29');
INSERT INTO `_Mimoto_file` VALUES (22, 'c7a4027e9b6755b7f57fbe9ddc0feccc.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-05-14 16:42:55');
INSERT INTO `_Mimoto_file` VALUES (23, '26797640451e024d33775c30e163506a.jpg', 'dynamic/', 'image/jpeg', 325663, 1920, 1037, 1.85149, 'ghostintheshell.jpg', '2017-05-14 16:43:08');
INSERT INTO `_Mimoto_file` VALUES (24, '7ce2eed65595d38d04c060dd6a71cb55.jpg', 'dynamic/', 'image/jpeg', 325663, 1920, 1037, 1.85149, 'ghostintheshell.jpg', '2017-05-14 16:45:10');
INSERT INTO `_Mimoto_file` VALUES (25, 'aeb76da6340336e6fbca77778d654902.jpg', 'dynamic/', 'image/jpeg', 325663, 1920, 1037, 1.85149, 'ghostintheshell.jpg', '2017-05-14 16:45:37');
INSERT INTO `_Mimoto_file` VALUES (26, 'b31abf0dc0547968ff857d0778f69ffe.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-05-14 16:45:48');
INSERT INTO `_Mimoto_file` VALUES (27, 'c8a9839c6f91834281ce413a4f4f541b.jpg', 'dynamic/', 'image/jpeg', 82786, 1920, 823, 2.33293, 'batterijen.jpg', '2017-05-14 16:47:09');
INSERT INTO `_Mimoto_file` VALUES (28, '597444fe143992b0eca09ab2a0e96981.png', 'dynamic/', 'image/png', 24970, 126, 126, 1.00000, 'sebastian.png', '2017-05-25 14:06:08');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form`;
CREATE TABLE `_Mimoto_form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `realtimeCollaborationMode` enum('0','1') COLLATE utf8_unicode_ci DEFAULT NULL,
  `customSubmit` enum('0','1') COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_form
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form` VALUES (1, 'article', NULL, NULL, NULL, NULL, NULL, NULL, '2017-04-21 14:17:57');
INSERT INTO `_Mimoto_form` VALUES (2, 'infocard', NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-01 10:39:52');
INSERT INTO `_Mimoto_form` VALUES (3, 'testformtextblock', NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-12 09:51:30');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_fieldrules
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_fieldrules`;
CREATE TABLE `_Mimoto_form_fieldrules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_input_checkbox
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_checkbox`;
CREATE TABLE `_Mimoto_form_input_checkbox` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `option` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_input_colorpicker
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_colorpicker`;
CREATE TABLE `_Mimoto_form_input_colorpicker` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_input_datepicker
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_datepicker`;
CREATE TABLE `_Mimoto_form_input_datepicker` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_input_dropdown
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_dropdown`;
CREATE TABLE `_Mimoto_form_input_dropdown` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_input_image
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_image`;
CREATE TABLE `_Mimoto_form_input_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_form_input_image
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_image` VALUES (1, 'Header image', NULL, '2017-04-21 14:17:57');
INSERT INTO `_Mimoto_form_input_image` VALUES (2, 'Image', NULL, '2017-05-01 10:39:52');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_list
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_list`;
CREATE TABLE `_Mimoto_form_input_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_input_multiselect
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_multiselect`;
CREATE TABLE `_Mimoto_form_input_multiselect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `option` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_input_radiobutton
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_radiobutton`;
CREATE TABLE `_Mimoto_form_input_radiobutton` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_form_input_radiobutton
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_radiobutton` VALUES (1, 'Type', '', '2017-04-21 14:31:33');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_textblock
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_textblock`;
CREATE TABLE `_Mimoto_form_input_textblock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `optional` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regexp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxchars` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_form_input_textblock
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textblock` VALUES (1, 'Lede', '', '', NULL, NULL, NULL, '2017-04-21 14:17:57');
INSERT INTO `_Mimoto_form_input_textblock` VALUES (2, 'Body', '', '', NULL, NULL, NULL, '2017-04-21 14:17:57');
INSERT INTO `_Mimoto_form_input_textblock` VALUES (3, 'Summary', '', '', NULL, NULL, NULL, '2017-05-01 10:39:52');
INSERT INTO `_Mimoto_form_input_textblock` VALUES (4, 'Textblock test', '', '', NULL, NULL, NULL, '2017-05-12 09:52:28');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_textline
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_textline`;
CREATE TABLE `_Mimoto_form_input_textline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_form_input_textline
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textline` VALUES (1, 'Title', 'Maak een goede titel', '', '', '2017-04-21 14:17:57');
INSERT INTO `_Mimoto_form_input_textline` VALUES (2, 'Title', '', '', '', '2017-05-01 10:39:52');
INSERT INTO `_Mimoto_form_input_textline` VALUES (3, 'Link', '', '', '', '2017-05-01 10:39:52');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_input_video
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_video`;
CREATE TABLE `_Mimoto_form_input_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_inputoption
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_inputoption`;
CREATE TABLE `_Mimoto_form_inputoption` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_form_inputoption
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_inputoption` VALUES (1, 'value', 'Verhaal van de dag', 'regular', '2017-04-21 14:31:59');
INSERT INTO `_Mimoto_form_inputoption` VALUES (2, 'value', 'Explainer', 'explainer', '2017-04-21 14:32:10');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_inputoption_map
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_inputoption_map`;
CREATE TABLE `_Mimoto_form_inputoption_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `targetKey` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `originKey` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_inputvalidation
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_inputvalidation`;
CREATE TABLE `_Mimoto_form_inputvalidation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `errorMessage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trigger` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_layout_divider
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_divider`;
CREATE TABLE `_Mimoto_form_layout_divider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for _Mimoto_form_layout_groupend
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_groupend`;
CREATE TABLE `_Mimoto_form_layout_groupend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_form_layout_groupend
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (1, '2017-04-21 14:17:57');
INSERT INTO `_Mimoto_form_layout_groupend` VALUES (2, '2017-05-01 10:39:52');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_layout_groupstart
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_groupstart`;
CREATE TABLE `_Mimoto_form_layout_groupstart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_form_layout_groupstart
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (1, NULL, '2017-04-21 14:17:57');
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES (2, NULL, '2017-05-01 10:39:52');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_form_output_title
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_output_title`;
CREATE TABLE `_Mimoto_form_output_title` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_form_output_title
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_output_title` VALUES (1, 'Article', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 21 April 2017 14:17:57. Adjust, add, remove or change the fields as you feel fit!', '2017-04-21 14:17:57');
INSERT INTO `_Mimoto_form_output_title` VALUES (2, 'Infocard', 'In-page editing with Mimoto', 'Add context to your text by inserting infocards to bridge a possible knowledge gap or to elaborate on a specific detail.', '2017-05-01 10:39:52');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_formattingoption
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_formattingoption`;
CREATE TABLE `_Mimoto_formattingoption` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `tagName` varchar(255) DEFAULT NULL,
  `toolbar` varchar(255) DEFAULT NULL,
  `jsOnAdd` varchar(255) DEFAULT NULL,
  `jsOnEdit` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_formattingoption
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_formattingoption` VALUES (1, 'infocard', 'inline', 'span', NULL, 'Publisher.onInfocardAdd', 'Publisher.onInfocardEdit', '2017-05-28 13:28:28');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_formattingoptionattribute
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_formattingoptionattribute`;
CREATE TABLE `_Mimoto_formattingoptionattribute` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for _Mimoto_layout
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_layout`;
CREATE TABLE `_Mimoto_layout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for _Mimoto_layoutcontainer
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_layoutcontainer`;
CREATE TABLE `_Mimoto_layoutcontainer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for _Mimoto_notification
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_notification`;
CREATE TABLE `_Mimoto_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispatcher` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of _Mimoto_notification
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_notification` VALUES (1, 'No such property', 'The property `<b>_Mimoto_route.1.path</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #290)', 'open', '2017-07-12 12:02:37');
INSERT INTO `_Mimoto_notification` VALUES (2, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:03:19');
INSERT INTO `_Mimoto_notification` VALUES (3, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:03:59');
INSERT INTO `_Mimoto_notification` VALUES (4, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:03:59');
INSERT INTO `_Mimoto_notification` VALUES (5, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:07:59');
INSERT INTO `_Mimoto_notification` VALUES (6, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:07:59');
INSERT INTO `_Mimoto_notification` VALUES (7, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:08:17');
INSERT INTO `_Mimoto_notification` VALUES (8, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:08:17');
INSERT INTO `_Mimoto_notification` VALUES (9, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:12:41');
INSERT INTO `_Mimoto_notification` VALUES (10, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:12:41');
INSERT INTO `_Mimoto_notification` VALUES (11, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:15:57');
INSERT INTO `_Mimoto_notification` VALUES (12, 'Adding value to a non-collection', 'Unable to add a value to an entity property <b>path</b>', 'silent', 'Mimoto\\Data\\MimotoEntityProperty_Entity::addValue (called from line #294)', 'open', '2017-07-12 12:16:35');
INSERT INTO `_Mimoto_notification` VALUES (13, 'No such property', 'The property `<b>_Mimoto_route_path.13.elements</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #290)', 'open', '2017-07-12 12:20:35');
INSERT INTO `_Mimoto_notification` VALUES (14, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 12:20:52');
INSERT INTO `_Mimoto_notification` VALUES (15, 'Entity not found', 'Sorry, I can\'t find the \'article\' entity with id=\'x\'', 'silent', 'Mimoto\\Data\\EntityRepository::get (called from line #151)', 'open', '2017-07-12 12:49:34');
INSERT INTO `_Mimoto_notification` VALUES (16, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:08');
INSERT INTO `_Mimoto_notification` VALUES (17, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:38');
INSERT INTO `_Mimoto_notification` VALUES (18, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_notification` VALUES (19, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_notification` VALUES (20, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_notification` VALUES (21, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_notification` VALUES (22, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_notification` VALUES (23, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_notification` VALUES (24, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_notification` VALUES (25, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_notification` VALUES (26, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_notification` VALUES (27, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_notification` VALUES (28, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_notification` VALUES (29, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_notification` VALUES (30, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_notification` VALUES (31, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:39:29');
INSERT INTO `_Mimoto_notification` VALUES (32, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:20');
INSERT INTO `_Mimoto_notification` VALUES (33, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:25');
INSERT INTO `_Mimoto_notification` VALUES (34, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:25');
INSERT INTO `_Mimoto_notification` VALUES (35, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:25');
INSERT INTO `_Mimoto_notification` VALUES (36, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_notification` VALUES (37, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_notification` VALUES (38, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_notification` VALUES (39, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_notification` VALUES (40, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_notification` VALUES (41, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_notification` VALUES (42, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_notification` VALUES (43, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:27');
INSERT INTO `_Mimoto_notification` VALUES (44, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:27');
INSERT INTO `_Mimoto_notification` VALUES (45, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:27');
INSERT INTO `_Mimoto_notification` VALUES (46, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_notification` VALUES (47, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_notification` VALUES (48, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_notification` VALUES (49, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_notification` VALUES (50, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_notification` VALUES (51, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:36');
INSERT INTO `_Mimoto_notification` VALUES (52, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:36');
INSERT INTO `_Mimoto_notification` VALUES (53, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:36');
INSERT INTO `_Mimoto_notification` VALUES (54, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:43:36');
INSERT INTO `_Mimoto_notification` VALUES (55, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:51:31');
INSERT INTO `_Mimoto_notification` VALUES (56, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:51:33');
INSERT INTO `_Mimoto_notification` VALUES (57, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:51:41');
INSERT INTO `_Mimoto_notification` VALUES (58, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:51:43');
INSERT INTO `_Mimoto_notification` VALUES (59, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:51:46');
INSERT INTO `_Mimoto_notification` VALUES (60, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:52:21');
INSERT INTO `_Mimoto_notification` VALUES (61, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:55:37');
INSERT INTO `_Mimoto_notification` VALUES (62, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:55:59');
INSERT INTO `_Mimoto_notification` VALUES (63, 'No such property', 'The property `<b>_Mimoto_route_path.13.</b>` you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-07-12 17:56:01');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_output
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_output`;
CREATE TABLE `_Mimoto_output` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_output
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_output` VALUES (1, '2017-07-12 17:37:08');
INSERT INTO `_Mimoto_output` VALUES (2, '2017-07-12 17:37:38');
INSERT INTO `_Mimoto_output` VALUES (3, '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_output` VALUES (4, '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_output` VALUES (5, '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_output` VALUES (6, '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_output` VALUES (7, '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_output` VALUES (8, '2017-07-12 17:37:39');
INSERT INTO `_Mimoto_output` VALUES (9, '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_output` VALUES (10, '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_output` VALUES (11, '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_output` VALUES (12, '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_output` VALUES (13, '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_output` VALUES (14, '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_output` VALUES (15, '2017-07-12 17:37:40');
INSERT INTO `_Mimoto_output` VALUES (16, '2017-07-12 17:39:29');
INSERT INTO `_Mimoto_output` VALUES (17, '2017-07-12 17:43:20');
INSERT INTO `_Mimoto_output` VALUES (18, '2017-07-12 17:43:25');
INSERT INTO `_Mimoto_output` VALUES (19, '2017-07-12 17:43:25');
INSERT INTO `_Mimoto_output` VALUES (20, '2017-07-12 17:43:25');
INSERT INTO `_Mimoto_output` VALUES (21, '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_output` VALUES (22, '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_output` VALUES (23, '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_output` VALUES (24, '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_output` VALUES (25, '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_output` VALUES (26, '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_output` VALUES (27, '2017-07-12 17:43:26');
INSERT INTO `_Mimoto_output` VALUES (28, '2017-07-12 17:43:27');
INSERT INTO `_Mimoto_output` VALUES (29, '2017-07-12 17:43:27');
INSERT INTO `_Mimoto_output` VALUES (30, '2017-07-12 17:43:27');
INSERT INTO `_Mimoto_output` VALUES (31, '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_output` VALUES (32, '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_output` VALUES (33, '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_output` VALUES (34, '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_output` VALUES (35, '2017-07-12 17:43:35');
INSERT INTO `_Mimoto_output` VALUES (36, '2017-07-12 17:43:36');
INSERT INTO `_Mimoto_output` VALUES (37, '2017-07-12 17:43:36');
INSERT INTO `_Mimoto_output` VALUES (38, '2017-07-12 17:43:36');
INSERT INTO `_Mimoto_output` VALUES (39, '2017-07-12 17:43:36');
INSERT INTO `_Mimoto_output` VALUES (40, '2017-07-12 17:51:31');
INSERT INTO `_Mimoto_output` VALUES (41, '2017-07-12 17:51:33');
INSERT INTO `_Mimoto_output` VALUES (42, '2017-07-12 17:51:41');
INSERT INTO `_Mimoto_output` VALUES (43, '2017-07-12 17:51:43');
INSERT INTO `_Mimoto_output` VALUES (44, '2017-07-12 17:51:46');
INSERT INTO `_Mimoto_output` VALUES (45, '2017-07-12 17:52:21');
INSERT INTO `_Mimoto_output` VALUES (46, '2017-07-12 17:53:01');
INSERT INTO `_Mimoto_output` VALUES (47, '2017-07-12 17:53:31');
INSERT INTO `_Mimoto_output` VALUES (48, '2017-07-12 17:53:45');
INSERT INTO `_Mimoto_output` VALUES (49, '2017-07-12 17:54:01');
INSERT INTO `_Mimoto_output` VALUES (50, '2017-07-12 17:54:25');
INSERT INTO `_Mimoto_output` VALUES (51, '2017-07-12 17:54:28');
INSERT INTO `_Mimoto_output` VALUES (52, '2017-07-12 17:54:30');
INSERT INTO `_Mimoto_output` VALUES (53, '2017-07-12 17:54:35');
INSERT INTO `_Mimoto_output` VALUES (54, '2017-07-12 17:55:37');
INSERT INTO `_Mimoto_output` VALUES (55, '2017-07-12 17:56:40');
INSERT INTO `_Mimoto_output` VALUES (56, '2017-07-12 17:56:55');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_output_container
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_output_container`;
CREATE TABLE `_Mimoto_output_container` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for _Mimoto_route
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_route`;
CREATE TABLE `_Mimoto_route` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_route
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_route` VALUES (1, 'Articles', '2017-05-28 14:59:08');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_route_path
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_route_path`;
CREATE TABLE `_Mimoto_route_path` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_route_path
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_route_path` VALUES (1, '2017-07-12 12:02:37');
INSERT INTO `_Mimoto_route_path` VALUES (2, '2017-07-12 12:03:19');
INSERT INTO `_Mimoto_route_path` VALUES (3, '2017-07-12 12:03:59');
INSERT INTO `_Mimoto_route_path` VALUES (4, '2017-07-12 12:03:59');
INSERT INTO `_Mimoto_route_path` VALUES (5, '2017-07-12 12:07:59');
INSERT INTO `_Mimoto_route_path` VALUES (6, '2017-07-12 12:07:59');
INSERT INTO `_Mimoto_route_path` VALUES (7, '2017-07-12 12:08:17');
INSERT INTO `_Mimoto_route_path` VALUES (8, '2017-07-12 12:08:17');
INSERT INTO `_Mimoto_route_path` VALUES (9, '2017-07-12 12:12:41');
INSERT INTO `_Mimoto_route_path` VALUES (10, '2017-07-12 12:12:41');
INSERT INTO `_Mimoto_route_path` VALUES (11, '2017-07-12 12:15:57');
INSERT INTO `_Mimoto_route_path` VALUES (12, '2017-07-12 12:16:35');
INSERT INTO `_Mimoto_route_path` VALUES (13, '2017-07-12 12:16:49');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_route_path_element
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_route_path_element`;
CREATE TABLE `_Mimoto_route_path_element` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_route_path_element
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_route_path_element` VALUES (3, 'static', 'article/', '2017-07-12 12:20:52');
INSERT INTO `_Mimoto_route_path_element` VALUES (4, 'variable', 'nArticleId', '2017-07-12 12:22:30');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_selection
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selection`;
CREATE TABLE `_Mimoto_selection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_selection
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_selection` VALUES (2, 'articles', '2017-06-03 17:54:03');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_selectionrule
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selectionrule`;
CREATE TABLE `_Mimoto_selectionrule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_selectionrule
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_selectionrule` VALUES (1, 'type', '2017-06-03 17:54:12');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_user
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_user`;
CREATE TABLE `_Mimoto_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_user
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_user` VALUES (1, 'Sebastian', 'sebastian@decorrespondent.nl', 'test', '2017-04-22 12:19:22');
INSERT INTO `_Mimoto_user` VALUES (2, 'Hilde', 'hildeatalanta@gmail.com', 'test', '2017-04-22 12:20:02');
INSERT INTO `_Mimoto_user` VALUES (3, 'Jorrit', 'jorrit@decorrespondent.nl', 'test', '2017-05-01 09:48:06');
COMMIT;

-- ----------------------------
-- Table structure for _Mimoto_user_role
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_user_role`;
CREATE TABLE `_Mimoto_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of _Mimoto_user_role
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_user_role` VALUES (3, 'author', '2017-05-27 13:11:10');
INSERT INTO `_Mimoto_user_role` VALUES (4, 'editor', '2017-05-27 13:11:14');
COMMIT;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lede` text COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of article
-- ----------------------------
BEGIN;
INSERT INTO `article` VALUES (1, '<p>Batterijen zijn schadelijk voor het milieu, vertelt de overheid ons al jaren. Het is een achterhaalde en verkeerde boodschap. Batterijen maken niet alleen schone auto’s mogelijk, ze vormen ook een herbruikbare grondstoffenbron die steeds planeetvriendelijker wordt.</p>', 'Batterijen schadelijk voor het milieu? Ze gaan het redden!', '<p>De caissière in de supermarkt vraagt op een dag wat ik eigenlijk voor werk doe. Ik schrijf, zeg ik. Waarover? Over batterijen. Ze trekt een vies gezicht. ‘Mijn zoontje zat laatst <strong>twee batterijen</strong> hard tegen elkaar aan te wrijven. Ze werden warm en ik was bang dat ze zouden ontploffen. Ik ben met ze naar buiten gerend en heb ze in de tuin gegooid.’ Ik antwoord, bijna automatisch: ‘In de tuin? Je kunt ze toch hier inleveren, in de bak bij de voordeur?’ Maar de batterijen leken haar te gevaarlijk om nog aan te raken. En ze is niet de enige. We zien batterijen als een noodzakelijk kwaad dat inmiddels overal in huis te vinden is - in telefoons en laptops, accuboren en afstandsbedieningen, babyfoons en gehoorapparaten. We kunnen niet zonder, maar blij worden we er niet van.</p>', 'regular', '2017-04-21 14:20:58');
INSERT INTO `article` VALUES (2, 'Hoe dichter we bij de verkiezingen komen, hoe belangrijker de peilingen lijken te worden. Maar hoe betrouwbaar zijn de peilingen waarop we onze stem baseren?', 'Peilingen domineren het politieke debat. Maar één cruciaal cijfer ontbreekt', 'Is het mogelijk dat we dit bericht over een paar dagen in de krant lezen? Volgens de peilingen  niet. Daarin gaan PVV en VVD gelijk op, is DENK nog piepklein en zien we nog altijd geen Asscher-effect.\n\nMaar na Brexit en Trump vraag je je misschien ook af: kunnen we de peilingen nog wel vertrouwen? Om dat uit te zoeken, neem ik vandaag een duik in de Nederlandse peilingbureaus. \n\nGaan de peilingen er in Nederland ook zo naast zitten?\n\nAllereerst goed om te zeggen: het ‘falen’ van de peilingen wordt nog weleens overdreven. Zo ging het in de Verenigde Staten vooral bij een aantal peilingen op staatniveau verkeerd. En in Nederland was het ‘nee’ op het Oekraïnereferendum te verwachten als je naar de peilingen had gekeken. \n\n\nMaar er gaat iets fundamentelers mis bij het beantwoorden van de vraag of de peilingen er weer naast gaan zitten. Want met ‘ernaast zitten’ wordt bijna altijd bedoeld: de peilingen voorspelden de uitslag niet goed. Dat terwijl peilingen geen voorspellingen zijn. Het zijn momentopnames, die een zo goed mogelijk beeld proberen te geven van de situatie op dat moment.\n\nEr gebeurt tussen peiling en verkiezing nog veel dat de uitslag kan beïnvloeden. Debatten, schandaaltjes, interviews met de LINDA. En natuurlijk de peilingen zelf, want ook die kunnen je in een bepaalde richting duwen. ', 'explainer', '2017-04-21 14:23:24');
INSERT INTO `article` VALUES (3, 'Nu mens en machine gestaag vergroeien ligt er een uitgelezen kans voor Hollywoodfilm Ghost in the Shell om te verkennen wat dat is: menszijn in cyborgtijden. Maar de film verzaakt. Dus kijk vooral het briljante anime-origineel uit 1995.', 'Hoe Hollywood een film over wat ons mens maakt totaal doodsloeg Correspondent Niet-mens', 'Oh, de tijden waarin wij leven. Bill Gates waarschuwt voor bioterrorisme,  Stephen Hawking vreest voor de menslievendheid der artificiële intelligentie en Elon Musk roept op  om toch vooral cyborg te worden – om te versmelten met ‘the machine’ – wil de mens niet achterblijven als irrelevant natuurhistorisch relikwie.\n\nOndertussen is de wetenschap bezig met mens-varken-hybrides,  worden er embryo’s uit huidcellen geklust en staan er projecten op touw om uitgestorven beestjes terug te brengen uit de dood.  Diersoort, seks, extinctie: grote begrippen imploderen waar je bij staat.\n\nDe levenswetenschappen bieden kortom genoeg stof tot nadenken. Waar moet dat allemaal heen? Gelukkig is er de sciencefictionfilm. Geen medium dat zich beter leent voor het doordenken van toekomstscenario’s dan dit.\n\nMijn verwachtingen van regisseur Rupert Sanders’ sciencefiction Ghost in the Shell (2017) – nu in de bioscoop – waren dan ook hoog. Zeker daar het een verfilming is van de gelijknamige Japanse animeklassieker uit 1995, geregisseerd door Mamoru Oshii.', 'regular', '2017-04-21 14:24:35');
INSERT INTO `article` VALUES (4, NULL, NULL, '<p>This is an introduction into what to expect as an intern at Momkai. After reading this you’ll know what colleagues expect from you, as well as useful tips and tricks to help your everyday life here in the studio.</p><h2><strong>When you start</strong></h2><ul><li>Read through the onboarding book to get a better understanding of culture that lives throughout the Momkai studio. Gain better understanding in the team by learning about the philosophy we employ, the work we have created and clients we have worked for.</li><li>Get to know your colleagues. At Momkai, everyone is very friendly and approachable. Make the most out of this, introduce yourself to colleagues and make some new friends!</li><li>Get acquainted with the standard studio tools, both software and hardware.</li><li>Explore the studio.</li></ul><h2><strong>Responsibilities</strong></h2><p>As an intern, you will have some responsibilities in taking care of the studio. Luckily, you are not alone in this — other interns and the office manager will help you carry this burden. Below, you can see a list of the tasks you’re expected to do.</p><ul><li>Track the publications regarding Momkai and related projects. Browse through <a href=\"http://more.momkai.com/studio/24\" target=\"_blank\">this guideline</a> to learn about the guidelines for archiving publications.</li><li>Run small errands for the studio. This could mean diving into desk research on an unexplored topic, stopping by a partner’s office to take care of a some business or other small favours.</li><li>Take care of the dishwasher. Check the schedule in the leftmost cupboard to see who’s responsible for the day.</li><li>Tidy up the gaming room after lunch.</li><li>Grocery shopping on Wednesdays. Get some fresh air and visit the Albert Heijn and the Marqt to stock up on some of Momkai’s favourite products.</li></ul><h2><strong>If you run into stuff you don’t know</strong></h2><ul><li>Feel free to ask questions to your colleagues! Ask them in person, or send them a message through <em>Slack </em>if they are busy with something.</li><li>Flip through the onboarding book or browse this site. These two are gold mines for everything Momkai.</li></ul><h2><strong>Pro-tips during your internship</strong></h2><ul><li>If you need to make a report for your university/school, start early. Keep a weekly log where you provide brief documentation of what you did and what your key learnings are. You can also link to documents/designs you have made to support your documentation.</li><li>Make it a habit to log your hours in Maido as soon as you complete a task. This will save a lot of hassle and guesstimating how long it took you to do all those things you completely forgot about.</li></ul><p><br></p><p><strong>Advice and experiences shared by your predecessors</strong></p><blockquote>“Don’t be afraid to <strong>show initiative</strong>. The main reason you are doing your internship is to learn, so take a chance, step outside of your comfort zone and try to do things you haven’t tried before. Although it may sound like a cliche, the magic really does happen outside of your comfort zone. Never suppress your instincts because you think you aren’t good enough.”</blockquote><p><strong>—&nbsp;Arthur Geel, </strong>Interaction Design Intern, 2017</p><blockquote>“Being surrounded by such talented individuals can have a hugely positive impact on your development as a creative. Make the most out of this by <strong>keeping an open mind</strong> and exploring all areas of work. Embrace every piece of support and advice you get when interacting with your colleagues, as this will make your experience here as rich as possible. As well as equipping you with a wealth of knowledge to apply to your future career.”</blockquote><p><strong>—&nbsp;Joel Williams, </strong>Visual Design Intern, 2016 / 2017</p>', NULL, '2017-05-12 10:37:46');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of comment
-- ----------------------------
BEGIN;
INSERT INTO `comment` VALUES (1, 'Hallo', '2017-04-21 14:40:58');
INSERT INTO `comment` VALUES (2, 'Nog', '2017-04-21 14:41:05');
INSERT INTO `comment` VALUES (3, 'Fryfhffh', '2017-04-21 14:41:10');
COMMIT;

-- ----------------------------
-- Table structure for components
-- ----------------------------
DROP TABLE IF EXISTS `components`;
CREATE TABLE `components` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for infocard
-- ----------------------------
DROP TABLE IF EXISTS `infocard`;
CREATE TABLE `infocard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of infocard
-- ----------------------------
BEGIN;
INSERT INTO `infocard` VALUES (1, NULL, NULL, NULL, '2017-05-01 17:47:37');
INSERT INTO `infocard` VALUES (2, NULL, NULL, NULL, '2017-05-01 17:51:04');
INSERT INTO `infocard` VALUES (3, NULL, NULL, NULL, '2017-05-01 17:51:11');
INSERT INTO `infocard` VALUES (4, NULL, NULL, NULL, '2017-05-02 16:14:50');
INSERT INTO `infocard` VALUES (5, NULL, NULL, NULL, '2017-05-02 16:15:44');
INSERT INTO `infocard` VALUES (6, NULL, NULL, NULL, '2017-05-02 17:43:34');
INSERT INTO `infocard` VALUES (7, NULL, NULL, NULL, '2017-05-02 17:43:58');
INSERT INTO `infocard` VALUES (8, NULL, NULL, NULL, '2017-05-03 10:39:24');
INSERT INTO `infocard` VALUES (9, NULL, NULL, NULL, '2017-05-03 10:41:01');
INSERT INTO `infocard` VALUES (10, NULL, NULL, NULL, '2017-05-03 10:41:09');
INSERT INTO `infocard` VALUES (11, NULL, NULL, NULL, '2017-05-03 10:58:13');
INSERT INTO `infocard` VALUES (12, NULL, NULL, NULL, '2017-05-03 11:12:54');
INSERT INTO `infocard` VALUES (13, NULL, NULL, NULL, '2017-05-03 11:13:13');
INSERT INTO `infocard` VALUES (14, NULL, NULL, NULL, '2017-05-03 14:51:14');
INSERT INTO `infocard` VALUES (15, NULL, NULL, NULL, '2017-05-03 14:53:22');
INSERT INTO `infocard` VALUES (16, NULL, NULL, NULL, '2017-05-03 14:55:03');
INSERT INTO `infocard` VALUES (17, NULL, NULL, NULL, '2017-05-03 14:56:37');
INSERT INTO `infocard` VALUES (18, NULL, NULL, NULL, '2017-05-03 14:58:10');
INSERT INTO `infocard` VALUES (19, NULL, NULL, NULL, '2017-05-04 18:56:59');
INSERT INTO `infocard` VALUES (20, NULL, NULL, NULL, '2017-05-04 18:56:59');
INSERT INTO `infocard` VALUES (21, NULL, NULL, NULL, '2017-05-04 18:57:02');
INSERT INTO `infocard` VALUES (22, NULL, NULL, NULL, '2017-05-04 18:57:05');
INSERT INTO `infocard` VALUES (23, NULL, NULL, NULL, '2017-05-04 18:57:07');
INSERT INTO `infocard` VALUES (24, NULL, NULL, NULL, '2017-05-04 18:57:09');
INSERT INTO `infocard` VALUES (25, NULL, NULL, NULL, '2017-05-04 18:57:51');
INSERT INTO `infocard` VALUES (26, NULL, NULL, NULL, '2017-05-04 18:57:53');
INSERT INTO `infocard` VALUES (27, NULL, NULL, NULL, '2017-05-04 19:04:10');
INSERT INTO `infocard` VALUES (28, NULL, NULL, NULL, '2017-05-04 19:04:13');
INSERT INTO `infocard` VALUES (29, NULL, NULL, NULL, '2017-05-04 19:48:24');
INSERT INTO `infocard` VALUES (30, NULL, NULL, NULL, '2017-05-04 19:48:27');
INSERT INTO `infocard` VALUES (31, NULL, NULL, NULL, '2017-05-04 19:49:14');
INSERT INTO `infocard` VALUES (32, NULL, NULL, NULL, '2017-05-04 19:49:27');
INSERT INTO `infocard` VALUES (33, NULL, NULL, NULL, '2017-05-05 11:25:01');
INSERT INTO `infocard` VALUES (34, NULL, NULL, NULL, '2017-05-05 11:25:04');
INSERT INTO `infocard` VALUES (35, NULL, NULL, NULL, '2017-05-09 09:23:59');
INSERT INTO `infocard` VALUES (36, NULL, NULL, NULL, '2017-05-14 19:39:54');
INSERT INTO `infocard` VALUES (37, NULL, NULL, NULL, '2017-05-14 19:39:58');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
