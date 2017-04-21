/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : localhost
 Source Database       : mimoto.cms

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : utf-8

 Date: 04/18/2017 16:00:05 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `_Mimoto_action`
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
--  Table structure for `_Mimoto_component`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_component`;
CREATE TABLE `_Mimoto_component` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_component`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component` VALUES ('1', 'feed', 'publisher/Feed/Feed.twig', '2017-04-13 16:54:49'), ('2', 'feeditem', 'publisher/FeedItem/FeedItem.twig', '2017-04-13 16:55:00'), ('3', 'article', 'publisher/Article/Article.twig', '2017-04-13 16:57:33'), ('4', 'feeditem', 'publisher/FeedItem/FeedItemExplainer.twig', '2017-04-13 17:19:11'), ('5', 'comment', 'publisher/Comment/Comment.twig', '2017-04-13 17:23:38'), ('6', 'grid', 'grid/slides/Grid/Grid.twig', '2017-04-18 13:01:03'), ('7', 'courseOverview', 'grid/Overview/Overview.twig', '2017-04-18 13:56:43'), ('8', 'course', 'grid/Course/Course.twig', '2017-04-18 14:04:51'), ('9', 'slide', 'grid/slides/Text/Text.twig', '2017-04-18 14:37:27'), ('10', 'slide', 'grid/slides/Image/Image.twig', '2017-04-18 14:37:39'), ('11', 'slide', 'grid/slides/Video/Video.twig', '2017-04-18 14:37:48'), ('12', 'slide', 'grid/slides/Grid/Grid.twig', '2017-04-18 14:37:56');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_componentconditional`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_componentconditional`;
CREATE TABLE `_Mimoto_componentconditional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_componentconditional`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_componentconditional` VALUES ('1', 'propertyValue', 'regular', '2017-04-13 17:20:14'), ('2', 'propertyValue', 'explainer', '2017-04-13 17:20:40'), ('3', 'entityType', '', '2017-04-18 14:38:08'), ('4', 'entityType', '', '2017-04-18 14:38:25'), ('5', 'entityType', '', '2017-04-18 14:38:35'), ('6', 'entityType', '', '2017-04-18 14:38:49');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_connection`
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
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_connection`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_connection` VALUES ('3', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '1', '0'), ('4', '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '1', '0'), ('5', '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '2', '1'), ('6', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '2', '1'), ('7', '_Mimoto_entityproperty', '1', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '1', '0'), ('8', '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '1', '0'), ('9', '_Mimoto_entityproperty', '2', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '2', '0'), ('10', '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '2', '1'), ('11', '_Mimoto_entitypropertysetting', '3', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', '0'), ('12', '_Mimoto_entityproperty', '3', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '3', '0'), ('13', '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '3', '2'), ('14', '_Mimoto_entityproperty', '4', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '4', '0'), ('15', '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '4', '3'), ('16', '_Mimoto_entity', '2', '_Mimoto_entity--components', '_Mimoto_component', '3', '0'), ('17', '_Mimoto_form_input_textline', '1', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '1', '0'), ('18', '_Mimoto_form_input_textblock', '1', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '2', '0'), ('19', '_Mimoto_form_input_image', '1', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '3', '0'), ('20', '_Mimoto_form_input_textblock', '2', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '4', '0'), ('21', '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_output_title', '1', '0'), ('22', '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '1', '1'), ('23', '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '1', '2'), ('24', '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '1', '4'), ('25', '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_image', '1', '5'), ('26', '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '2', '6'), ('27', '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '1', '7'), ('28', '_Mimoto_entity', '2', '_Mimoto_entity--forms', '_Mimoto_form', '1', '0'), ('29', '_Mimoto_contentsection', '1', '_Mimoto_contentsection--form', '_Mimoto_form', '1', '0'), ('30', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '1', '0'), ('31', '2', '1', '3', '_Mimoto_file', '1', '0'), ('32', '_Mimoto_contentsection', '1', '_Mimoto_contentsection--contentItems', '2', '1', '0'), ('33', '2', '2', '3', '_Mimoto_file', '2', '0'), ('34', '_Mimoto_contentsection', '1', '_Mimoto_contentsection--contentItems', '2', '2', '1'), ('36', '_Mimoto_contentsection', '1', '_Mimoto_contentsection--contentItems', '2', '3', '2'), ('37', '2', '3', '3', '_Mimoto_file', '4', '0'), ('38', '_Mimoto_entityproperty', '5', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '5', '0'), ('39', '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '5', '4'), ('40', '_Mimoto_form_input_radiobutton', '1', '_Mimoto_form_input_radiobutton--value', '_Mimoto_entityproperty', '5', '0'), ('41', '_Mimoto_form', '1', '_Mimoto_form--fields', '_Mimoto_form_input_radiobutton', '1', '3'), ('42', '_Mimoto_form_input_radiobutton', '1', '_Mimoto_form_input_radiobutton--options', '_Mimoto_form_inputoption', '1', '0'), ('43', '_Mimoto_form_input_radiobutton', '1', '_Mimoto_form_input_radiobutton--options', '_Mimoto_form_inputoption', '2', '1'), ('44', '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '4', '2'), ('45', '_Mimoto_componentconditional', '1', '_Mimoto_componentconditional--entityProperty', '_Mimoto_entityproperty', '5', '0'), ('46', '_Mimoto_component', '2', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '1', '0'), ('47', '_Mimoto_componentconditional', '2', '_Mimoto_componentconditional--entityProperty', '_Mimoto_entityproperty', '5', '0'), ('48', '_Mimoto_component', '4', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '2', '0'), ('49', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '3', '2'), ('50', '_Mimoto_entityproperty', '6', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '6', '0'), ('51', '_Mimoto_entity', '3', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '6', '0'), ('52', '_Mimoto_entity', '3', '_Mimoto_entity--components', '_Mimoto_component', '5', '0'), ('53', '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '7', '0'), ('54', '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '8', '1'), ('55', '_Mimoto_entity', '2', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '7', '5'), ('56', '_Mimoto_entitypropertysetting', '7', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '3', '0'), ('58', '2', '1', '7', '3', '2', '1'), ('91', '_Mimoto_user', '3', '_Mimoto_user--avatar', '_Mimoto_file', '12', '0'), ('93', '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '6', '3'), ('94', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '4', '3'), ('95', '_Mimoto_entityproperty', '8', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '9', '0'), ('96', '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '8', '0'), ('97', '_Mimoto_entityproperty', '9', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '10', '0'), ('98', '_Mimoto_entityproperty', '9', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '11', '1'), ('99', '_Mimoto_entity', '4', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '9', '1'), ('100', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '5', '4'), ('101', '_Mimoto_entityproperty', '10', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '12', '0'), ('102', '_Mimoto_entity', '5', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '10', '0'), ('103', '_Mimoto_entityproperty', '11', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '13', '0'), ('104', '_Mimoto_entity', '5', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '11', '1'), ('105', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '6', '5'), ('106', '_Mimoto_entityproperty', '12', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '14', '0'), ('107', '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '12', '0'), ('108', '_Mimoto_entitypropertysetting', '15', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', '0'), ('109', '_Mimoto_entityproperty', '13', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '15', '0'), ('110', '_Mimoto_entity', '6', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '13', '1'), ('111', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '7', '6'), ('112', '_Mimoto_entityproperty', '14', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '16', '0'), ('113', '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '14', '0'), ('114', '_Mimoto_entitypropertysetting', '17', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', '0'), ('115', '_Mimoto_entityproperty', '15', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '17', '0'), ('116', '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '15', '1'), ('117', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '8', '7'), ('118', '_Mimoto_entityproperty', '16', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '18', '0'), ('119', '_Mimoto_entity', '8', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '16', '0'), ('120', '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '7', '4'), ('121', '_Mimoto_form_input_textline', '2', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '8', '0'), ('122', '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_output_title', '2', '0'), ('123', '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '2', '1'), ('124', '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '2', '2'), ('125', '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '2', '4'), ('126', '_Mimoto_entity', '4', '_Mimoto_entity--forms', '_Mimoto_form', '2', '0'), ('127', '_Mimoto_contentsection', '2', '_Mimoto_contentsection--form', '_Mimoto_form', '2', '0'), ('128', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '2', '1'), ('129', '_Mimoto_contentsection', '2', '_Mimoto_contentsection--contentItems', '4', '1', '0'), ('132', '_Mimoto_entity', '4', '_Mimoto_entity--components', '_Mimoto_component', '8', '0'), ('134', '_Mimoto_contentsection', '2', '_Mimoto_contentsection--contentItems', '4', '2', '1'), ('135', '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '9', '5'), ('136', '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '10', '6'), ('137', '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '11', '7'), ('138', '_Mimoto_entity', '1', '_Mimoto_entity--components', '_Mimoto_component', '12', '8'), ('139', '_Mimoto_componentconditional', '3', '_Mimoto_componentconditional--entityType', '_Mimoto_entity', '5', '0'), ('140', '_Mimoto_component', '9', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '3', '0'), ('141', '_Mimoto_componentconditional', '4', '_Mimoto_componentconditional--entityType', '_Mimoto_entity', '7', '0'), ('142', '_Mimoto_component', '10', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '4', '0'), ('143', '_Mimoto_componentconditional', '5', '_Mimoto_componentconditional--entityType', '_Mimoto_entity', '6', '0'), ('144', '_Mimoto_component', '11', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '5', '0'), ('145', '_Mimoto_componentconditional', '6', '_Mimoto_componentconditional--entityType', '_Mimoto_entity', '8', '0'), ('146', '_Mimoto_component', '12', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '6', '0'), ('147', '_Mimoto_form_input_textline', '3', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '10', '0'), ('148', '_Mimoto_form_input_textblock', '3', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '11', '0'), ('149', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_output_title', '3', '0'), ('150', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '3', '1'), ('151', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '3', '2'), ('152', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '3', '3'), ('153', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '3', '4'), ('154', '_Mimoto_entity', '5', '_Mimoto_entity--forms', '_Mimoto_form', '3', '0'), ('155', '_Mimoto_form_input_textline', '4', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '12', '0'), ('156', '_Mimoto_form_input_video', '1', '_Mimoto_form_input_video--value', '_Mimoto_entityproperty', '13', '0'), ('157', '_Mimoto_form', '4', '_Mimoto_form--fields', '_Mimoto_form_output_title', '4', '0'), ('158', '_Mimoto_form', '4', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '4', '1'), ('159', '_Mimoto_form', '4', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '4', '2'), ('160', '_Mimoto_form', '4', '_Mimoto_form--fields', '_Mimoto_form_input_video', '1', '3'), ('161', '_Mimoto_form', '4', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '4', '4'), ('162', '_Mimoto_entity', '6', '_Mimoto_entity--forms', '_Mimoto_form', '4', '0'), ('163', '_Mimoto_form_input_textline', '5', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '14', '0'), ('164', '_Mimoto_form_input_image', '2', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '15', '0'), ('165', '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_output_title', '5', '0'), ('166', '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '5', '1'), ('167', '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '5', '2'), ('168', '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_image', '2', '3'), ('169', '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '5', '4'), ('170', '_Mimoto_entity', '7', '_Mimoto_entity--forms', '_Mimoto_form', '5', '0'), ('171', '_Mimoto_form_input_textline', '6', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '16', '0'), ('172', '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_output_title', '6', '0'), ('173', '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '6', '1'), ('174', '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '6', '2'), ('175', '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '6', '3'), ('176', '_Mimoto_entity', '8', '_Mimoto_entity--forms', '_Mimoto_form', '6', '0'), ('177', '_Mimoto_entitypropertysetting', '10', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '5', '0'), ('178', '_Mimoto_entitypropertysetting', '10', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '6', '1'), ('179', '_Mimoto_entitypropertysetting', '10', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '7', '2'), ('180', '_Mimoto_entitypropertysetting', '10', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '8', '3'), ('181', '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--value', '_Mimoto_entityproperty', '9', '0'), ('182', '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_input_list', '1', '3'), ('183', '_Mimoto_form_inputoption', '3', '_Mimoto_form_inputoption--form', '_Mimoto_form', '3', '0'), ('184', '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--options', '_Mimoto_form_inputoption', '3', '0'), ('185', '_Mimoto_form_inputoption', '4', '_Mimoto_form_inputoption--form', '_Mimoto_form', '5', '0'), ('186', '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--options', '_Mimoto_form_inputoption', '4', '1'), ('187', '_Mimoto_form_inputoption', '5', '_Mimoto_form_inputoption--form', '_Mimoto_form', '4', '0'), ('188', '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--options', '_Mimoto_form_inputoption', '5', '2'), ('189', '_Mimoto_form_inputoption', '6', '_Mimoto_form_inputoption--form', '_Mimoto_form', '6', '0'), ('190', '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--options', '_Mimoto_form_inputoption', '6', '3'), ('191', '4', '1', '9', '5', '1', '0'), ('193', '4', '1', '9', '7', '1', '1'), ('194', '4', '1', '9', '6', '1', '2'), ('195', '4', '1', '9', '8', '1', '3'), ('196', '6', '1', '13', '_Mimoto_file', '14', '0'), ('197', '7', '1', '15', '_Mimoto_file', '15', '0');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_contentsection`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_contentsection`;
CREATE TABLE `_Mimoto_contentsection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `isHiddenFromMenu` enum('0','1') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_contentsection`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_contentsection` VALUES ('1', 'Articles', 'group', '0', '2017-04-13 17:03:44'), ('2', 'Courses', 'group', '0', '2017-04-18 14:03:34');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_entity`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entity`;
CREATE TABLE `_Mimoto_entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `isAbstract` enum('0','1') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_entity`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entity` VALUES ('1', 'components', null, '2017-04-13 16:54:27'), ('2', 'article', null, '2017-04-13 16:55:24'), ('3', 'comment', null, '2017-04-13 17:23:06'), ('4', 'course', null, '2017-04-18 13:43:07'), ('5', 'textSlide', null, '2017-04-18 13:43:45'), ('6', 'videoSlide', null, '2017-04-18 13:44:25'), ('7', 'imageSlide', null, '2017-04-18 13:46:00'), ('8', 'gridSlide', null, '2017-04-18 13:51:16');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_entityproperty`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entityproperty`;
CREATE TABLE `_Mimoto_entityproperty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_entityproperty`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entityproperty` VALUES ('1', 'title', 'value', null, '2017-04-13 16:56:04'), ('2', 'lede', 'value', null, '2017-04-13 16:56:21'), ('3', 'headerImage', 'entity', 'image', '2017-04-13 16:57:01'), ('4', 'body', 'value', null, '2017-04-13 16:57:07'), ('5', 'type', 'value', null, '2017-04-13 17:15:24'), ('6', 'message', 'value', null, '2017-04-13 17:23:16'), ('7', 'comments', 'collection', null, '2017-04-13 17:24:01'), ('8', 'name', 'value', null, '2017-04-18 13:43:30'), ('9', 'slides', 'collection', null, '2017-04-18 13:43:36'), ('10', 'title', 'value', null, '2017-04-18 13:44:07'), ('11', 'body', 'value', null, '2017-04-18 13:44:12'), ('12', 'title', 'value', null, '2017-04-18 13:44:38'), ('13', 'video', 'entity', 'video', '2017-04-18 13:45:50'), ('14', 'title', 'value', null, '2017-04-18 13:46:07'), ('15', 'image', 'entity', 'image', '2017-04-18 13:46:14'), ('16', 'title', 'value', null, '2017-04-18 13:51:24');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_entitypropertysetting`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_entitypropertysetting`;
CREATE TABLE `_Mimoto_entitypropertysetting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_entitypropertysetting`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entitypropertysetting` VALUES ('1', 'type', 'text', 'textline', '2017-04-13 16:56:04'), ('2', 'type', 'text', 'textblock', '2017-04-13 16:56:21'), ('3', 'allowedEntityType', null, null, '2017-04-13 16:57:01'), ('4', 'type', 'text', 'textblock', '2017-04-13 16:57:07'), ('5', 'type', 'text', 'textline', '2017-04-13 17:15:24'), ('6', 'type', 'text', 'textblock', '2017-04-13 17:23:16'), ('7', 'allowedEntityTypes', '', '', '2017-04-13 17:24:01'), ('8', 'allowDuplicates', 'boolean', '', '2017-04-13 17:24:01'), ('9', 'type', 'text', 'textline', '2017-04-18 13:43:30'), ('10', 'allowedEntityTypes', '', '', '2017-04-18 13:43:36'), ('11', 'allowDuplicates', 'boolean', '', '2017-04-18 13:43:36'), ('12', 'type', 'text', 'textline', '2017-04-18 13:44:07'), ('13', 'type', 'text', 'textblock', '2017-04-18 13:44:12'), ('14', 'type', 'text', 'textline', '2017-04-18 13:44:38'), ('15', 'allowedEntityType', null, null, '2017-04-18 13:45:50'), ('16', 'type', 'text', 'textline', '2017-04-18 13:46:07'), ('17', 'allowedEntityType', null, null, '2017-04-18 13:46:14'), ('18', 'type', 'text', 'textline', '2017-04-18 13:51:24');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_file`
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_file`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_file` VALUES ('1', '782471afb9ea94d623ec7d4c76f94da6.jpg', 'dynamic/', 'image/jpeg', '82786', '1920', '823', '2.33293', 'batterijen.jpg', '2017-04-13 17:05:28'), ('2', '16dca06bc8e1083c9de6ea07a7ae1002.jpg', 'dynamic/', 'image/jpeg', '325663', '1920', '1037', '1.85149', 'ghostintheshell.jpg', '2017-04-13 17:07:43'), ('3', 'ebb23e78e2d7987b1c9ee96676d410da.jpg', 'dynamic/', 'image/jpeg', '82786', '1920', '823', '2.33293', 'batterijen.jpg', '2017-04-13 17:08:47'), ('4', '027c14101c9acdcb1a07b74f1aa310ad.gif', 'dynamic/', 'image/gif', '5307379', '1920', '823', '2.33293', 'peilingen.gif', '2017-04-13 17:11:07'), ('5', 'ae276b6f4f9fca5fcf034fef7b357399.jpg', 'dynamic/', 'image/jpeg', '40876', '944', '958', '0.98539', 'profielfoto_sebastian.jpg', '2017-04-16 14:55:00'), ('6', '18a5c529d9eaea2b2d4ed3f0fa4f0f3e.jpeg', 'dynamic/', 'image/jpeg', '134734', '750', '1061', '0.70688', 'hilde.jpeg', '2017-04-16 15:08:48'), ('7', '9b40de284b768ccc42c94f76923c96cd.jpeg', 'dynamic/', 'image/jpeg', '134734', '750', '1061', '0.70688', 'hilde.jpeg', '2017-04-16 17:15:49'), ('8', 'd2091111dc85414ef808837afd18d34c.jpg', 'dynamic/', 'image/jpeg', '40876', '944', '958', '0.98539', 'profielfoto_sebastian.jpg', '2017-04-16 17:16:14'), ('10', '0ab40741e1bebf4828a672aef61c424f.jpg', 'dynamic/', 'image/jpeg', '382746', '1080', '1080', '1.00000', 'avatar_SK_01.jpg', '2017-04-16 17:35:42'), ('12', '3578ed41fdecefb71a99c1a330fe954c.jpg', 'dynamic/', 'image/jpeg', '40876', '944', '958', '0.98539', 'profielfoto_sebastian.jpg', '2017-04-17 15:59:15'), ('13', '959a8601ecb83da7e35d346771fbd205.jpg', 'dynamic/', 'image/jpeg', '382746', '1080', '1080', '1.00000', 'avatar_SK_01.jpg', '2017-04-18 15:11:57'), ('14', '00a5f37bf115b8d23f810e2a9e6fedb8.mp4', 'dynamic/', null, '55637693', null, null, null, 'knvb.mp4', '2017-04-18 15:39:58'), ('15', '45888ccebdb745f4fdf3b7f602e1937c.jpg', 'dynamic/', 'image/jpeg', '1552104', '4408', '2480', '1.77742', 'knvb.jpg', '2017-04-18 15:46:05');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form`
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form` VALUES ('1', 'article', null, null, null, null, null, null, '2017-04-13 17:02:09'), ('2', 'course', null, null, null, null, null, null, '2017-04-18 14:03:15'), ('3', 'textSlide', null, null, null, null, null, null, '2017-04-18 14:39:08'), ('4', 'videoSlide', null, null, null, null, null, null, '2017-04-18 14:39:18'), ('5', 'imageSlide', null, null, null, null, null, null, '2017-04-18 14:39:25'), ('6', 'gridSlide', null, null, null, null, null, null, '2017-04-18 14:39:29');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_fieldrules`
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
--  Table structure for `_Mimoto_form_input_checkbox`
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
--  Table structure for `_Mimoto_form_input_colorpicker`
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
--  Table structure for `_Mimoto_form_input_datepicker`
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
--  Table structure for `_Mimoto_form_input_dropdown`
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
--  Table structure for `_Mimoto_form_input_image`
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
--  Records of `_Mimoto_form_input_image`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_image` VALUES ('1', 'Header image', null, '2017-04-13 17:02:09'), ('2', 'Image', null, '2017-04-18 14:39:25');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_input_list`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_list`;
CREATE TABLE `_Mimoto_form_input_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_list`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_list` VALUES ('1', 'Slides', '', '2017-04-18 14:40:05');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_input_multiselect`
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
--  Table structure for `_Mimoto_form_input_radiobutton`
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
--  Records of `_Mimoto_form_input_radiobutton`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_radiobutton` VALUES ('1', 'Type', '', '2017-04-13 17:15:42');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_input_textblock`
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_textblock`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textblock` VALUES ('1', 'Lede', null, null, null, null, null, '2017-04-13 17:02:09'), ('2', 'Body', null, null, null, null, null, '2017-04-13 17:02:09'), ('3', 'Body', null, null, null, null, null, '2017-04-18 14:39:08');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_input_textline`
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_textline`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textline` VALUES ('1', 'Title', 'Doe het goed', '', '', '2017-04-13 17:02:09'), ('2', 'Name', null, null, null, '2017-04-18 14:03:15'), ('3', 'Title', null, null, null, '2017-04-18 14:39:08'), ('4', 'Title', null, null, null, '2017-04-18 14:39:18'), ('5', 'Title', null, null, null, '2017-04-18 14:39:25'), ('6', 'Title', null, null, null, '2017-04-18 14:39:29');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_input_textrtf`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_textrtf`;
CREATE TABLE `_Mimoto_form_input_textrtf` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `optional` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regexp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxchars` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_Mimoto_form_input_video`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_video`;
CREATE TABLE `_Mimoto_form_input_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_video`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_video` VALUES ('1', 'Video', null, '2017-04-18 14:39:18');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_inputoption`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_inputoption`;
CREATE TABLE `_Mimoto_form_inputoption` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_inputoption`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_inputoption` VALUES ('1', 'value', 'Verhaal van de dag', 'regular', '2017-04-13 17:16:10'), ('2', 'value', 'Explainer', 'explainer', '2017-04-13 17:16:25'), ('3', 'form', 'Text slide', '', '2017-04-18 14:40:27'), ('4', 'form', 'Image slide', '', '2017-04-18 14:40:42'), ('5', 'form', 'Video slide', '', '2017-04-18 14:40:53'), ('6', 'form', 'Grid slide', '', '2017-04-18 14:41:03');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_inputoption_map`
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
--  Table structure for `_Mimoto_form_inputvalidation`
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
--  Table structure for `_Mimoto_form_layout_divider`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_divider`;
CREATE TABLE `_Mimoto_form_layout_divider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_Mimoto_form_layout_groupend`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_groupend`;
CREATE TABLE `_Mimoto_form_layout_groupend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_layout_groupend`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupend` VALUES ('1', '2017-04-13 17:02:09'), ('2', '2017-04-18 14:03:15'), ('3', '2017-04-18 14:39:08'), ('4', '2017-04-18 14:39:18'), ('5', '2017-04-18 14:39:25'), ('6', '2017-04-18 14:39:29');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_layout_groupstart`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_layout_groupstart`;
CREATE TABLE `_Mimoto_form_layout_groupstart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_layout_groupstart`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES ('1', null, '2017-04-13 17:02:09'), ('2', null, '2017-04-18 14:03:15'), ('3', null, '2017-04-18 14:39:08'), ('4', null, '2017-04-18 14:39:18'), ('5', null, '2017-04-18 14:39:25'), ('6', null, '2017-04-18 14:39:29');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_form_output_title`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_output_title`;
CREATE TABLE `_Mimoto_form_output_title` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_output_title`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_output_title` VALUES ('1', 'Article', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 13 April 2017 17:02:09. Adjust, add, remove or change the fields as you feel fit!', '2017-04-13 17:02:09'), ('2', 'Course', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 18 April 2017 14:03:15. Adjust, add, remove or change the fields as you feel fit!', '2017-04-18 14:03:15'), ('3', 'Text slide', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 18 April 2017 14:39:08. Adjust, add, remove or change the fields as you feel fit!', '2017-04-18 14:39:08'), ('4', 'Video slide', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 18 April 2017 14:39:18. Adjust, add, remove or change the fields as you feel fit!', '2017-04-18 14:39:18'), ('5', 'Image slide', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 18 April 2017 14:39:25. Adjust, add, remove or change the fields as you feel fit!', '2017-04-18 14:39:25'), ('6', 'Grid slide', 'Auto-generated form', 'This form has been created by Mimoto\'s auto-generation feature based on the entity\'s properties on 18 April 2017 14:39:29. Adjust, add, remove or change the fields as you feel fit!', '2017-04-18 14:39:29');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_layout`
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
--  Table structure for `_Mimoto_layoutcontainer`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_layoutcontainer`;
CREATE TABLE `_Mimoto_layoutcontainer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `_Mimoto_notification`
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_Mimoto_selection`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selection`;
CREATE TABLE `_Mimoto_selection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `_Mimoto_selectionrule`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selectionrule`;
CREATE TABLE `_Mimoto_selectionrule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `_Mimoto_user`
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
--  Records of `_Mimoto_user`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_user` VALUES ('3', 'Sebastian Kersten', 'sebastian@decorrespondent.nl', 'test', null);
COMMIT;

-- ----------------------------
--  Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `lede` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `article`
-- ----------------------------
BEGIN;
INSERT INTO `article` VALUES ('1', 'Vogels schadelijk voor het milieu? Ze gaan het redden!', 'regular', 'De caissière in de supermarkt vraagt op een dag wat ik eigenlijk voor werk doe. Ik schrijf, zeg ik. Waarover? Over batterijen.\n\nZe trekt een vies gezicht. ‘Mijn zoontje zat laatst twee batterijen hard tegen elkaar aan te wrijven. Ze werden warm en ik was bang dat ze zouden ontploffen. Ik ben met ze naar buiten gerend en heb ze in de tuin gegooid.’\n\nIk antwoord, bijna automatisch: ‘In de tuin? Je kunt ze toch hier inleveren, in de bak bij de voordeur?’ Maar de batterijen leken haar te gevaarlijk om nog aan te raken.\n\nEn ze is niet de enige. We zien batterijen als een noodzakelijk kwaad dat inmiddels overal in huis te vinden is - in telefoons en laptops, accuboren en afstandsbedieningen, babyfoons en gehoorapparaten. We kunnen niet zonder, maar blij worden we er niet van.\n\nDit verhaal is voor mijn caissière en voor iedereen die bij het woord batterijen een ongemakkelijk gevoel krijgt. Ik begon ze zelf pas te begrijpen toen ik me serieus in batterijen verdiepte  en ben pas echt overtuigd geraakt toen ik voor dit verhaal bij een Belgische batterijenrecyclingfabriek op bezoek ging.\n\nMaar nu weet ik het zeker. Batterijen zijn de beste technologische oplossing die we nu hebben voor het echte giftige en explosieve probleem op deze wereld: olie.\n\n', 'Batterijen zijn schadelijk voor het milieu, vertelt de overheid ons al jaren. Het is een achterhaalde en verkeerde boodschap. Batterijen maken niet alleen schone auto’s mogelijk, ze vormen ook een herbruikbare grondstoffenbron die steeds planeetvriendelijker wordt.', '2017-04-13 17:05:51'), ('2', 'Hoe Hollywood een film over wat ons mens maakt totaal doodsloeg', 'regular', 'De tijden waarin wij leven. Bill Gates waarschuwt voor bioterrorisme,  Stephen Hawking vreest voor de menslievendheid der artificiële intelligentie en Elon Musk roept op  om toch vooral cyborg te worden – om te versmelten met ‘the machine’ – wil de mens niet achterblijven als irrelevant natuurhistorisch relikwie.\n\nOndertussen is de wetenschap bezig met mens-varken-hybrides,  worden er embryo’s uit huidcellen geklust en staan er projecten op touw om uitgestorven beestjes terug te brengen uit de dood.  Soorten, seks, extinctie: grote begrippen imploderen waar je bij staat.\n\nDe levenswetenschappen bieden kortom genoeg stof tot nadenken. Waar moet dat allemaal heen? Gelukkig is er de sciencefictionfilm. Geen medium dat zich beter leent voor het doordenken van toekomstscenario’s dan dit.\n\nMijn verwachtingen van regisseur Rupert Sanders’ sciencefiction Ghost in the Shell (2017) – nu in de bioscoop – waren dan ook hoog. Zeker daar het een verfilming is van de gelijknamige Japanse animeklassieker uit 1995, geregisseerd door Mamoru Oshii.', 'Nu mens en machine gestaag vergroeien ligt er een uitgelezen kans voor Hollywoodfilm Ghost in the Shell om te verkennen wat dat is: menszijn in cyborgtijden. Maar de film verzaakt. Dus kijk vooral het briljante anime-origineel uit 1995.', '2017-04-13 17:07:46'), ('3', 'Peilingen domineren het politieke debat. Maar één cruciaal cijfer ontbreekt', 'explainer', 'Is het mogelijk dat we dit bericht over een paar dagen in de krant lezen? Volgens de peilingen  niet. Daarin gaan PVV en VVD gelijk op, is DENK nog piepklein en zien we nog altijd geen Asscher-effect.\n\nMaar na Brexit en Trump vraag je je misschien ook af: kunnen we de peilingen nog wel vertrouwen? Om dat uit te zoeken, neem ik vandaag een duik in de Nederlandse peilingbureaus. \n\nGaan de peilingen er in Nederland ook zo naast zitten?\n\nAllereerst goed om te zeggen: het ‘falen’ van de peilingen wordt nog weleens overdreven. Zo ging het in de Verenigde Staten vooral bij een aantal peilingen op staatniveau verkeerd. En in Nederland was het ‘nee’ op het Oekraïnereferendum te verwachten als je naar de peilingen had gekeken. ', 'Hoe dichter we bij de verkiezingen komen, hoe belangrijker de peilingen lijken te worden. Maar hoe betrouwbaar zijn de peilingen waarop we onze stem baseren?', '2017-04-13 17:08:48');
COMMIT;

-- ----------------------------
--  Table structure for `comment`
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `comment`
-- ----------------------------
BEGIN;
INSERT INTO `comment` VALUES ('2', 'Hoi', '2017-04-13 17:26:40');
COMMIT;

-- ----------------------------
--  Table structure for `components`
-- ----------------------------
DROP TABLE IF EXISTS `components`;
CREATE TABLE `components` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `course`
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `course`
-- ----------------------------
BEGIN;
INSERT INTO `course` VALUES ('1', 'Basic planning', '2017-04-18 14:03:49'), ('2', 'Advanced planning for super pro people', '2017-04-18 14:17:45');
COMMIT;

-- ----------------------------
--  Table structure for `gridSlide`
-- ----------------------------
DROP TABLE IF EXISTS `gridSlide`;
CREATE TABLE `gridSlide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `gridSlide`
-- ----------------------------
BEGIN;
INSERT INTO `gridSlide` VALUES ('1', 'Probeer het nu zelf', '2017-04-18 15:28:15');
COMMIT;

-- ----------------------------
--  Table structure for `imageSlide`
-- ----------------------------
DROP TABLE IF EXISTS `imageSlide`;
CREATE TABLE `imageSlide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `imageSlide`
-- ----------------------------
BEGIN;
INSERT INTO `imageSlide` VALUES ('1', 'Planning terwijl je onderweg bent', '2017-04-18 15:11:58');
COMMIT;

-- ----------------------------
--  Table structure for `textSlide`
-- ----------------------------
DROP TABLE IF EXISTS `textSlide`;
CREATE TABLE `textSlide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `textSlide`
-- ----------------------------
BEGIN;
INSERT INTO `textSlide` VALUES ('1', 'Introductie', 'The holistic design utilizes dynamic slanted lines and strong visual storytelling to create a sportive look and feel. A style that unites the sites, while enabling them to distinct themselves. Their characters are amplified by the colour scheme: business blue for the association’s empowering knowledge, grass green for the amateur footballer’s personal dashboard and powerful orange to proudly represent our national teams.', '2017-04-18 14:41:16');
COMMIT;

-- ----------------------------
--  Table structure for `videoSlide`
-- ----------------------------
DROP TABLE IF EXISTS `videoSlide`;
CREATE TABLE `videoSlide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `videoSlide`
-- ----------------------------
BEGIN;
INSERT INTO `videoSlide` VALUES ('1', 'Een video', '2017-04-18 15:28:03');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
