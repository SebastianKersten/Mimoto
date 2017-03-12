/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50711
 Source Host           : localhost
 Source Database       : mimoto.cms

 Target Server Type    : MySQL
 Target Server Version : 50711
 File Encoding         : utf-8

 Date: 03/12/2017 08:28:12 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_component`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_component` VALUES ('6', 'sfsdfsd', 'sdfsdfsdfs', '2017-03-10 16:25:42'), ('7', 'test', 'sdfsdfsdf', '2017-03-10 17:01:37'), ('8', 'author', 'publisher/Author/Author.twig', '2017-03-11 16:00:22'), ('9', 'feed', 'publisher/Feed/Feed.twig', '2017-03-11 20:16:17'), ('10', 'feeditem', 'publisher/FeedItem/FeedItem.twig', '2017-03-11 20:23:28'), ('11', 'article', 'publisher/Article/Article.twig', '2017-03-11 21:42:12'), ('12', 'feeditem', 'publisher/FeedItem/FeedItemExplainer.twig', '2017-03-11 21:45:26'), ('13', 'comment', 'publisher/Comment/Comment.twig', '2017-03-12 08:12:05');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_componentconditional`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_componentconditional` VALUES ('8', 'entityType', '', '2017-03-10 17:01:51'), ('9', 'propertyValue', 'sdfsdfsdf', '2017-03-10 17:05:53'), ('10', 'propertyValue', 'explainer', '2017-03-11 22:42:58'), ('11', 'propertyValue', 'regular', '2017-03-11 22:43:13');
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
) ENGINE=InnoDB AUTO_INCREMENT=942 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_connection`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_connection` VALUES ('62', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '1', '0'), ('64', '_Mimoto_selection', '1', '_Mimoto_selection--rules', '_Mimoto_selectionrule', '2', '1'), ('85', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '2', '6'), ('86', '_Mimoto_contentsection', '2', '_Mimoto_contentsection--contentItem', '3', '5', '0'), ('95', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '2', '1'), ('96', '_Mimoto_selection', '2', '_Mimoto_selection--rules', '_Mimoto_selectionrule', '4', '0'), ('97', '_Mimoto_selection', '2', '_Mimoto_selection--rules', '_Mimoto_selectionrule', '5', '1'), ('98', '_Mimoto_selection', '2', '_Mimoto_selection--rules', '_Mimoto_selectionrule', '6', '2'), ('110', '_Mimoto_entityproperty', '7', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '8', '0'), ('116', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '7', '4'), ('117', '_Mimoto_entityproperty', '8', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '9', '0'), ('118', '_Mimoto_entityproperty', '8', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '10', '1'), ('119', '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '8', '0'), ('122', '_Mimoto_entityproperty', '10', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '12', '0'), ('124', '_Mimoto_entityproperty', '11', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '13', '0'), ('126', '_Mimoto_entityproperty', '12', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '14', '0'), ('128', '_Mimoto_entityproperty', '13', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '15', '0'), ('130', '_Mimoto_entityproperty', '14', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '16', '0'), ('131', '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '14', '1'), ('186', '_Mimoto_entitypropertysetting', '21', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', '0'), ('187', '_Mimoto_entityproperty', '19', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '21', '0'), ('188', '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '19', '2'), ('189', '_Mimoto_entityproperty', '20', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '22', '0'), ('190', '_Mimoto_entity', '7', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '20', '3'), ('230', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '8', '3'), ('231', '_Mimoto_entityproperty', '25', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '27', '0'), ('232', '_Mimoto_entity', '8', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '25', '0'), ('234', '_Mimoto_entity', '7', '_Mimoto_entity--forms', '_Mimoto_form', '2', '0'), ('235', '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--value', '_Mimoto_entityproperty', '8', '0'), ('236', '_Mimoto_form', '2', '_Mimoto_form--fields', '_Mimoto_form_input_list', '1', '0'), ('237', '_Mimoto_form_input_list', '1', '_Mimoto_form_input_list--options', '_Mimoto_form_inputoption', '9', '0'), ('249', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '9', '2'), ('254', '_Mimoto_entity', '9', '_Mimoto_entity--forms', '_Mimoto_form', '3', '0'), ('255', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_output_title', '1', '0'), ('256', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '1', '1'), ('263', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '6', '2'), ('272', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '12', '3'), ('273', '_Mimoto_form', '3', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '1', '4'), ('274', '_Mimoto_contentsection', '3', '_Mimoto_contentsection--form', '_Mimoto_form', '3', '0'), ('275', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '3', '1'), ('276', '_Mimoto_contentsection', '3', '_Mimoto_contentsection--contentItems', '9', '1', '1'), ('277', '_Mimoto_contentsection', '3', '_Mimoto_contentsection--contentItems', '9', '2', '3'), ('278', '_Mimoto_contentsection', '3', '_Mimoto_contentsection--contentItems', '9', '3', '2'), ('279', '_Mimoto_contentsection', '3', '_Mimoto_contentsection--contentItems', '9', '4', '0'), ('280', '_Mimoto_contentsection', '3', '_Mimoto_contentsection--contentItems', '9', '5', '4'), ('281', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '10', '1'), ('282', '_Mimoto_entityproperty', '28', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '30', '0'), ('283', '_Mimoto_entity', '10', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '28', '0'), ('284', '_Mimoto_entityproperty', '29', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '31', '0'), ('285', '_Mimoto_entity', '10', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '29', '1'), ('289', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--selections', '_Mimoto_selection', '3', '2'), ('290', '_Mimoto_selection', '3', '_Mimoto_selection--rules', '_Mimoto_selectionrule', '7', '0'), ('291', '_Mimoto_entityproperty', '31', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '33', '0'), ('292', '_Mimoto_entity', '9', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '31', '0'), ('293', '_Mimoto_entityproperty', '32', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '34', '0'), ('294', '_Mimoto_entity', '9', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '32', '1'), ('298', '_Mimoto_form_input_textline', '6', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '31', '0'), ('299', '_Mimoto_form_input_textline', '12', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '32', '0'), ('311', '_Mimoto_form_inputoption', '0', '_Mimoto_form_inputoption--selection', '_Mimoto_selection', '3', '0'), ('312', '_Mimoto_form_inputoption', '0', '_Mimoto_form_inputoption--selection', '_Mimoto_selection', '3', '0'), ('314', '_Mimoto_form_inputoption', '0', '_Mimoto_form_inputoption--form', '_Mimoto_form', '3', '0'), ('315', '_Mimoto_form_inputoption', '0', '_Mimoto_form_inputoption--selection', '_Mimoto_selection', '3', '0'), ('337', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '11', '6'), ('338', '_Mimoto_entityproperty', '34', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '36', '0'), ('339', '_Mimoto_entity', '11', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '34', '0'), ('340', '_Mimoto_entityproperty', '35', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '37', '0'), ('341', '_Mimoto_entityproperty', '35', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '38', '1'), ('342', '_Mimoto_entity', '11', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '35', '1'), ('343', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '12', '5'), ('344', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '13', '7'), ('345', '_Mimoto_entityproperty', '36', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '39', '0'), ('346', '_Mimoto_entity', '13', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '36', '0'), ('347', '_Mimoto_entityproperty', '37', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '40', '0'), ('348', '_Mimoto_entity', '13', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '37', '1'), ('349', '_Mimoto_entity', '13', '_Mimoto_entity--forms', '_Mimoto_form', '4', '0'), ('354', '_Mimoto_entityproperty', '38', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '41', '0'), ('355', '_Mimoto_entity', '12', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '38', '0'), ('356', '_Mimoto_entityproperty', '39', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '42', '0'), ('357', '_Mimoto_entity', '12', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '39', '1'), ('360', '_Mimoto_entity', '12', '_Mimoto_entity--forms', '_Mimoto_form', '5', '0'), ('361', '_Mimoto_form_input_textline', '16', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '38', '0'), ('362', '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '16', '0'), ('363', '_Mimoto_form_input_textblock', '4', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '39', '0'), ('364', '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '4', '1'), ('365', '_Mimoto_entitypropertysetting', '37', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '12', '0'), ('366', '_Mimoto_entitypropertysetting', '37', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '13', '1'), ('367', '_Mimoto_entity', '11', '_Mimoto_entity--forms', '_Mimoto_form', '6', '0'), ('368', '_Mimoto_form_input_textline', '17', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '34', '0'), ('369', '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '17', '1'), ('370', '_Mimoto_form_input_list', '2', '_Mimoto_form_input_list--value', '_Mimoto_entityproperty', '35', '0'), ('371', '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_input_list', '2', '0'), ('372', '_Mimoto_form_inputoption', '13', '_Mimoto_form_inputoption--form', '_Mimoto_form', '5', '0'), ('373', '_Mimoto_form_input_list', '2', '_Mimoto_form_input_list--options', '_Mimoto_form_inputoption', '13', '0'), ('374', '_Mimoto_form_inputoption', '14', '_Mimoto_form_inputoption--form', '_Mimoto_form', '4', '0'), ('375', '_Mimoto_form_input_list', '2', '_Mimoto_form_input_list--options', '_Mimoto_form_inputoption', '14', '1'), ('376', '_Mimoto_contentsection', '4', '_Mimoto_contentsection--form', '_Mimoto_form', '6', '0'), ('377', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '4', '4'), ('386', '_Mimoto_contentsection', '4', '_Mimoto_contentsection--contentItems', '11', '1', '0'), ('412', '11', '1', '35', '12', '11', '2'), ('414', '_Mimoto_contentsection', '4', '_Mimoto_contentsection--contentItems', '11', '3', '2'), ('419', '_Mimoto_contentsection', '4', '_Mimoto_contentsection--contentItems', '11', '4', '1'), ('489', '_Mimoto_form_input_textblock', '5', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '36', '0'), ('490', '_Mimoto_form', '4', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '5', '1'), ('491', '_Mimoto_form_input_textline', '23', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '37', '0'), ('492', '_Mimoto_form', '4', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '23', '1'), ('493', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '14', '8'), ('494', '_Mimoto_entityproperty', '46', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '49', '0'), ('495', '_Mimoto_entity', '14', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '46', '1'), ('496', '_Mimoto_entityproperty', '47', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '50', '0'), ('497', '_Mimoto_entity', '14', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '47', '3'), ('522', '_Mimoto_form_input_textline', '27', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '46', '0'), ('524', '_Mimoto_form', '20', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '27', '0'), ('526', '_Mimoto_entity', '14', '_Mimoto_entity--forms', '_Mimoto_form', '20', '0'), ('527', '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '7', '1'), ('529', '_Mimoto_entitypropertysetting', '51', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', '0'), ('530', '_Mimoto_entityproperty', '48', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '51', '0'), ('531', '_Mimoto_entity', '14', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '48', '2'), ('532', '_Mimoto_form_input_video', '1', '_Mimoto_form_input_video--value', '_Mimoto_entityproperty', '48', '0'), ('533', '_Mimoto_form', '20', '_Mimoto_form--fields', '_Mimoto_form_input_video', '1', '1'), ('535', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '5', '3'), ('536', '_Mimoto_entityproperty', '49', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '52', '0'), ('537', '_Mimoto_entity', '14', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '49', '0'), ('538', '_Mimoto_form_input_checkbox', '1', '_Mimoto_form_input_checkbox--value', '_Mimoto_entityproperty', '49', '0'), ('539', '_Mimoto_form', '20', '_Mimoto_form--fields', '_Mimoto_form_input_checkbox', '1', '2'), ('540', '_Mimoto_contentsection', '5', '_Mimoto_contentsection--contentItem', '14', '1', '0'), ('543', '14', '1', '48', '_Mimoto_file', '26', '0'), ('544', '_Mimoto_entitypropertysetting', '53', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', '0'), ('545', '_Mimoto_entityproperty', '50', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '53', '0'), ('546', '_Mimoto_entity', '12', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '50', '2'), ('547', '_Mimoto_form_input_image', '1', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '50', '0'), ('548', '_Mimoto_form', '5', '_Mimoto_form--fields', '_Mimoto_form_input_image', '1', '2'), ('551', '12', '15', '50', '_Mimoto_file', '30', '0'), ('554', '_Mimoto_entitypropertysetting', '9', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '8', '2'), ('556', '_Mimoto_form_input_textblock', '10', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '14', '0'), ('557', '_Mimoto_form', '21', '_Mimoto_form--fields', '_Mimoto_form_output_title', '2', '0'), ('558', '_Mimoto_form', '21', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '2', '1'), ('559', '_Mimoto_form', '21', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '10', '2'), ('560', '_Mimoto_form', '21', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '2', '3'), ('561', '_Mimoto_entity', '7', '_Mimoto_entity--forms', '_Mimoto_form', '21', '1'), ('562', '_Mimoto_form_input_textblock', '11', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '14', '0'), ('563', '_Mimoto_form', '22', '_Mimoto_form--fields', '_Mimoto_form_output_title', '3', '0'), ('564', '_Mimoto_form', '22', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '3', '1'), ('565', '_Mimoto_form', '22', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '11', '2'), ('566', '_Mimoto_form', '22', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '3', '3'), ('567', '_Mimoto_entity', '7', '_Mimoto_entity--forms', '_Mimoto_form', '22', '2'), ('568', '_Mimoto_form_input_textblock', '12', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '14', '0'), ('569', '_Mimoto_form_input_image', '2', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '19', '0'), ('570', '_Mimoto_form', '23', '_Mimoto_form--fields', '_Mimoto_form_output_title', '4', '0'), ('571', '_Mimoto_form', '23', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '4', '1'), ('572', '_Mimoto_form', '23', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '12', '2'), ('573', '_Mimoto_form', '23', '_Mimoto_form--fields', '_Mimoto_form_input_image', '2', '3'), ('574', '_Mimoto_form', '23', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '4', '4'), ('575', '_Mimoto_entity', '7', '_Mimoto_entity--forms', '_Mimoto_form', '23', '3'), ('576', '_Mimoto_form_input_textblock', '13', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '14', '0'), ('577', '_Mimoto_form_input_image', '3', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '19', '0'), ('578', '_Mimoto_form', '24', '_Mimoto_form--fields', '_Mimoto_form_output_title', '5', '0'), ('579', '_Mimoto_form', '24', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '5', '1'), ('580', '_Mimoto_form', '24', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '13', '2'), ('581', '_Mimoto_form', '24', '_Mimoto_form--fields', '_Mimoto_form_input_image', '3', '3'), ('582', '_Mimoto_form', '24', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '5', '4'), ('583', '_Mimoto_entity', '7', '_Mimoto_entity--forms', '_Mimoto_form', '24', '4'), ('594', '_Mimoto_contentsection', '5', '_Mimoto_contentsection--form', '_Mimoto_form', '20', '0'), ('595', '_Mimoto_contentsection', '6', '_Mimoto_contentsection--form', '_Mimoto_form', '24', '0'), ('596', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '6', '5'), ('598', '7', '2', '19', '_Mimoto_file', '31', '0'), ('599', '_Mimoto_contentsection', '6', '_Mimoto_contentsection--contentItems', '7', '2', '0'), ('614', '11', '3', '35', '13', '32', '1'), ('624', '11', '3', '35', '13', '33', '2'), ('634', '11', '3', '35', '13', '34', '0'), ('746', '_Mimoto_entity', '11', '_Mimoto_entity--components', '_Mimoto_component', '6', '0'), ('747', '_Mimoto_entity', '9', '_Mimoto_entity--components', '_Mimoto_component', '7', '0'), ('748', '_Mimoto_componentconditional', '8', '_Mimoto_componentconditional--entityType', '_Mimoto_entity', '8', '0'), ('749', '_Mimoto_component', '7', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '8', '0'), ('751', '_Mimoto_component', '7', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '9', '1'), ('752', '_Mimoto_entitypropertysetting', '54', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', '0'), ('753', '_Mimoto_entityproperty', '51', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '54', '0'), ('754', '_Mimoto_entity', '10', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '51', '2'), ('755', '_Mimoto_form_input_textline', '28', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '28', '0'), ('756', '_Mimoto_form_input_textline', '29', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '29', '0'), ('757', '_Mimoto_form_input_image', '4', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '51', '0'), ('758', '_Mimoto_form', '25', '_Mimoto_form--fields', '_Mimoto_form_output_title', '6', '0'), ('759', '_Mimoto_form', '25', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '6', '1'), ('760', '_Mimoto_form', '25', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '28', '2'), ('761', '_Mimoto_form', '25', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '29', '3'), ('762', '_Mimoto_form', '25', '_Mimoto_form--fields', '_Mimoto_form_input_image', '4', '4'), ('763', '_Mimoto_form', '25', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '6', '5'), ('764', '_Mimoto_entity', '10', '_Mimoto_entity--forms', '_Mimoto_form', '25', '0'), ('765', '_Mimoto_contentsection', '7', '_Mimoto_contentsection--form', '_Mimoto_form', '25', '0'), ('766', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '7', '2'), ('791', '_Mimoto_contentsection', '7', '_Mimoto_contentsection--contentItems', '10', '1', '0'), ('792', '_Mimoto_entity', '10', '_Mimoto_entity--components', '_Mimoto_component', '8', '0'), ('810', '10', '1', '51', '_Mimoto_file', '53', '0'), ('823', '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '7', '2'), ('824', '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '7', '3'), ('826', '_Mimoto_form', '6', '_Mimoto_form--fields', '_Mimoto_form_output_title', '7', '4'), ('842', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '18', '9'), ('844', '_Mimoto_entityproperty', '52', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '56', '1'), ('847', '_Mimoto_entity', '18', '_Mimoto_entity--components', '_Mimoto_component', '9', '0'), ('848', '_Mimoto_entity', '18', '_Mimoto_entity--components', '_Mimoto_component', '10', '1'), ('855', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '19', '0'), ('856', '_Mimoto_entityproperty', '53', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '57', '0'), ('857', '_Mimoto_entity', '19', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '53', '0'), ('858', '_Mimoto_entityproperty', '54', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '58', '0'), ('859', '_Mimoto_entity', '19', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '54', '1'), ('860', '_Mimoto_entitypropertysetting', '59', '_Mimoto_entitypropertysetting--allowedEntityType', '_Mimoto_file', '_Mimoto_file', '0'), ('861', '_Mimoto_entityproperty', '55', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '59', '0'), ('862', '_Mimoto_entity', '19', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '55', '2'), ('863', '_Mimoto_entityproperty', '56', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '60', '0'), ('864', '_Mimoto_entity', '19', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '56', '3'), ('865', '_Mimoto_entityproperty', '57', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '61', '0'), ('866', '_Mimoto_entityproperty', '57', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '62', '1'), ('867', '_Mimoto_entity', '19', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '57', '4'), ('868', '_Mimoto_entitypropertysetting', '61', '_Mimoto_entitypropertysetting--allowedEntityTypes', '_Mimoto_entity', '10', '0'), ('869', '_Mimoto_form_input_textline', '30', '_Mimoto_form_input_textline--value', '_Mimoto_entityproperty', '53', '0'), ('870', '_Mimoto_form_input_textblock', '14', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '54', '0'), ('871', '_Mimoto_form_input_image', '5', '_Mimoto_form_input_image--value', '_Mimoto_entityproperty', '55', '0'), ('872', '_Mimoto_form_input_textblock', '15', '_Mimoto_form_input_textblock--value', '_Mimoto_entityproperty', '56', '0'), ('873', '_Mimoto_form', '26', '_Mimoto_form--fields', '_Mimoto_form_output_title', '8', '0'), ('874', '_Mimoto_form', '26', '_Mimoto_form--fields', '_Mimoto_form_layout_groupstart', '8', '1'), ('875', '_Mimoto_form', '26', '_Mimoto_form--fields', '_Mimoto_form_input_textline', '30', '2'), ('876', '_Mimoto_form', '26', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '14', '3'), ('877', '_Mimoto_form', '26', '_Mimoto_form--fields', '_Mimoto_form_input_image', '5', '5'), ('878', '_Mimoto_form', '26', '_Mimoto_form--fields', '_Mimoto_form_input_textblock', '15', '6'), ('879', '_Mimoto_form', '26', '_Mimoto_form--fields', '_Mimoto_form_layout_groupend', '9', '7'), ('880', '_Mimoto_entity', '19', '_Mimoto_entity--forms', '_Mimoto_form', '26', '0'), ('881', '_Mimoto_contentsection', '8', '_Mimoto_contentsection--form', '_Mimoto_form', '26', '0'), ('882', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--contentSections', '_Mimoto_contentsection', '8', '0'), ('885', '_Mimoto_contentsection', '8', '_Mimoto_contentsection--contentItems', '19', '1', '0'), ('886', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '57', '0'), ('887', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '58', '1'), ('888', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '59', '2'), ('889', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '60', '3'), ('890', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '61', '4'), ('891', '19', '2', '55', '_Mimoto_file', '55', '0'), ('892', '_Mimoto_contentsection', '8', '_Mimoto_contentsection--contentItems', '19', '2', '3'), ('894', '19', '1', '55', '_Mimoto_file', '57', '0'), ('895', '_Mimoto_entityproperty', '58', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '63', '0'), ('896', '_Mimoto_entityproperty', '58', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '64', '1'), ('897', '_Mimoto_entity', '19', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '58', '5'), ('898', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--entities', '_Mimoto_entity', '20', '10'), ('899', '_Mimoto_entityproperty', '59', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '65', '0'), ('900', '_Mimoto_entity', '20', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '59', '0'), ('901', '_Mimoto_entity', '19', '_Mimoto_entity--components', '_Mimoto_component', '11', '0'), ('902', '_Mimoto_entity', '18', '_Mimoto_entity--components', '_Mimoto_component', '12', '2'), ('903', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '62', '5'), ('904', '19', '3', '55', '_Mimoto_file', '58', '0'), ('905', '_Mimoto_contentsection', '8', '_Mimoto_contentsection--contentItems', '19', '3', '4'), ('906', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '63', '6'), ('907', '19', '4', '55', '_Mimoto_file', '59', '0'), ('908', '_Mimoto_contentsection', '8', '_Mimoto_contentsection--contentItems', '19', '4', '1'), ('909', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '64', '7'), ('910', '19', '5', '55', '_Mimoto_file', '60', '0'), ('911', '_Mimoto_contentsection', '8', '_Mimoto_contentsection--contentItems', '19', '5', '2'), ('912', '_Mimoto_root', '_Mimoto_root', '_Mimoto_root--notifications', '_Mimoto_notification', '65', '8'), ('913', '_Mimoto_entityproperty', '60', '_Mimoto_entityproperty--settings', '_Mimoto_entitypropertysetting', '66', '0'), ('914', '_Mimoto_entity', '19', '_Mimoto_entity--properties', '_Mimoto_entityproperty', '60', '6'), ('915', '_Mimoto_form_input_radiobutton', '3', '_Mimoto_form_input_radiobutton--value', '_Mimoto_entityproperty', '60', '0'), ('916', '_Mimoto_form', '26', '_Mimoto_form--fields', '_Mimoto_form_input_radiobutton', '3', '4'), ('917', '_Mimoto_form_input_radiobutton', '3', '_Mimoto_form_input_radiobutton--options', '_Mimoto_form_inputoption', '15', '0'), ('918', '_Mimoto_form_input_radiobutton', '3', '_Mimoto_form_input_radiobutton--options', '_Mimoto_form_inputoption', '16', '1'), ('919', '_Mimoto_componentconditional', '10', '_Mimoto_componentconditional--entityProperty', '_Mimoto_entityproperty', '60', '0'), ('920', '_Mimoto_component', '12', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '10', '0'), ('921', '_Mimoto_componentconditional', '11', '_Mimoto_componentconditional--entityProperty', '_Mimoto_entityproperty', '60', '0'), ('922', '_Mimoto_component', '10', '_Mimoto_component--conditionals', '_Mimoto_componentconditional', '11', '0'), ('924', '_Mimoto_entity', '20', '_Mimoto_entity--components', '_Mimoto_component', '13', '0');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_contentsection`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_contentsection` VALUES ('2', 'Work', 'item', '0', '2017-03-02 12:18:26'), ('3', 'Article types', 'group', '0', '2017-03-06 14:06:20'), ('4', 'Cases', 'group', '0', '2017-03-07 09:33:43'), ('5', 'Dev now', 'item', '0', '2017-03-09 11:13:12'), ('6', 'Projects', 'group', '0', '2017-03-09 18:19:04'), ('7', 'Authors', 'group', '0', '2017-03-11 14:23:28'), ('8', 'Articles', 'group', '0', '2017-03-11 20:27:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_entity`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entity` VALUES ('7', 'project', null, '2017-03-02 16:14:32'), ('8', 'subproject', null, '2017-03-05 14:09:26'), ('9', 'articleType', null, '2017-03-06 13:51:27'), ('10', 'author', null, '2017-03-06 14:11:36'), ('11', 'case', null, '2017-03-07 09:28:25'), ('12', 'textMedia', null, '2017-03-07 09:29:04'), ('13', 'quote', null, '2017-03-07 09:29:11'), ('14', 'autoForm', null, '2017-03-08 14:48:24'), ('18', 'feed', null, '2017-03-11 20:13:59'), ('19', 'article', null, '2017-03-11 20:25:51'), ('20', 'comment', null, '2017-03-11 21:37:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_entityproperty`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entityproperty` VALUES ('7', 'title', 'value', null, '2017-03-02 15:39:20'), ('8', 'subprojects', 'collection', null, '2017-03-02 16:14:46'), ('10', 'title', 'value', null, '2017-03-02 16:15:59'), ('11', 'title', 'value', null, '2017-03-02 16:16:57'), ('12', 'title', 'value', null, '2017-03-02 16:17:28'), ('13', 'title', 'value', null, '2017-03-02 16:18:08'), ('14', 'name', 'value', null, '2017-03-02 16:18:33'), ('15', 'avatar', 'entity', 'image', '2017-03-02 18:14:55'), ('16', 'avatar', 'entity', 'image', '2017-03-04 14:49:43'), ('17', 'avatar', 'entity', 'image', '2017-03-04 15:53:14'), ('18', 'avatar', 'entity', 'image', '2017-03-04 16:22:16'), ('19', 'avatar', 'entity', 'image', '2017-03-04 16:22:30'), ('20', 'contact', 'entity', null, '2017-03-04 16:23:42'), ('25', 'name', 'value', null, '2017-03-05 14:09:32'), ('28', 'name', 'value', null, '2017-03-06 14:11:43'), ('29', 'expertise', 'value', null, '2017-03-06 14:11:59'), ('30', 'author', 'entity', null, '2017-03-06 14:13:23'), ('31', 'label', 'value', null, '2017-03-06 14:20:39'), ('32', 'value', 'value', null, '2017-03-06 14:20:47'), ('34', 'title', 'value', null, '2017-03-07 09:28:38'), ('35', 'caseSections', 'collection', null, '2017-03-07 09:28:47'), ('36', 'quote', 'value', null, '2017-03-07 09:29:19'), ('37', 'name', 'value', null, '2017-03-07 09:29:29'), ('38', 'title', 'value', null, '2017-03-07 09:30:26'), ('39', 'body', 'value', null, '2017-03-07 09:30:33'), ('46', 'title', 'value', null, '2017-03-08 14:49:15'), ('47', 'description', 'value', null, '2017-03-08 14:49:46'), ('48', 'mainVideo', 'entity', 'video', '2017-03-09 11:09:29'), ('49', 'aanuit', 'value', null, '2017-03-09 13:09:31'), ('50', 'photo', 'entity', 'image', '2017-03-09 14:40:09'), ('51', 'avatar', 'entity', 'image', '2017-03-11 14:22:33'), ('52', 'articles', 'collection', null, '2017-03-11 20:14:20'), ('53', 'title', 'value', null, '2017-03-11 20:26:00'), ('54', 'lede', 'value', null, '2017-03-11 20:26:05'), ('55', 'headerImage', 'entity', 'image', '2017-03-11 20:26:29'), ('56', 'body', 'value', null, '2017-03-11 20:26:34'), ('57', 'authors', 'collection', null, '2017-03-11 20:26:42'), ('58', 'comments', 'collection', null, '2017-03-11 21:36:55'), ('59', 'message', 'value', null, '2017-03-11 21:37:38'), ('60', 'type', 'value', null, '2017-03-11 22:36:43');
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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_entitypropertysetting`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_entitypropertysetting` VALUES ('8', 'type', 'text', 'textline', '2017-03-02 15:39:20'), ('9', 'allowedEntityTypes', '', '', '2017-03-02 16:14:46'), ('10', 'allowDuplicates', 'boolean', '', '2017-03-02 16:14:46'), ('12', 'type', 'text', 'textline', '2017-03-02 16:15:59'), ('13', 'type', 'text', 'textline', '2017-03-02 16:16:57'), ('14', 'type', 'text', 'textline', '2017-03-02 16:17:28'), ('15', 'type', 'text', 'textline', '2017-03-02 16:18:08'), ('16', 'type', 'text', 'textblock', '2017-03-02 16:18:33'), ('17', 'allowedEntityType', null, null, '2017-03-02 18:14:55'), ('18', 'allowedEntityType', null, null, '2017-03-04 14:49:43'), ('19', 'allowedEntityType', null, null, '2017-03-04 15:53:14'), ('20', 'allowedEntityType', null, null, '2017-03-04 16:22:16'), ('21', 'allowedEntityType', null, null, '2017-03-04 16:22:30'), ('22', 'allowedEntityType', '', '', '2017-03-04 16:23:42'), ('27', 'type', 'text', 'textline', '2017-03-05 14:09:32'), ('30', 'type', 'text', 'textline', '2017-03-06 14:11:43'), ('31', 'type', 'text', 'textline', '2017-03-06 14:11:59'), ('32', 'allowedEntityType', '', '', '2017-03-06 14:13:23'), ('33', 'type', 'text', 'textline', '2017-03-06 14:20:39'), ('34', 'type', 'text', 'textline', '2017-03-06 14:20:47'), ('36', 'type', 'text', 'textline', '2017-03-07 09:28:38'), ('37', 'allowedEntityTypes', '', '', '2017-03-07 09:28:47'), ('38', 'allowDuplicates', 'boolean', '', '2017-03-07 09:28:47'), ('39', 'type', 'text', 'textblock', '2017-03-07 09:29:19'), ('40', 'type', 'text', 'textline', '2017-03-07 09:29:29'), ('41', 'type', 'text', 'textline', '2017-03-07 09:30:26'), ('42', 'type', 'text', 'textblock', '2017-03-07 09:30:33'), ('49', 'type', 'text', 'textline', '2017-03-08 14:49:15'), ('50', 'type', 'text', 'textblock', '2017-03-08 14:49:46'), ('51', 'allowedEntityType', null, null, '2017-03-09 11:09:29'), ('52', 'type', 'text', 'boolean', '2017-03-09 13:09:31'), ('53', 'allowedEntityType', null, null, '2017-03-09 14:40:09'), ('54', 'allowedEntityType', null, null, '2017-03-11 14:22:33'), ('55', 'allowedEntityTypes', '', '', '2017-03-11 20:14:20'), ('56', 'allowDuplicates', 'boolean', '', '2017-03-11 20:14:20'), ('57', 'type', 'text', 'textline', '2017-03-11 20:26:00'), ('58', 'type', 'text', 'textblock', '2017-03-11 20:26:05'), ('59', 'allowedEntityType', null, null, '2017-03-11 20:26:29'), ('60', 'type', 'text', 'textblock', '2017-03-11 20:26:34'), ('61', 'allowedEntityTypes', '', '', '2017-03-11 20:26:42'), ('62', 'allowDuplicates', 'boolean', '', '2017-03-11 20:26:42'), ('63', 'allowedEntityTypes', '', '', '2017-03-11 21:36:55'), ('64', 'allowDuplicates', 'boolean', '', '2017-03-11 21:36:55'), ('65', 'type', 'text', 'textblock', '2017-03-11 21:37:38'), ('66', 'type', 'text', 'textline', '2017-03-11 22:36:43');
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_file`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_file` VALUES ('1', 'a', 'b', 'c', '3', '3', '3', '3.00000', 'd', null), ('2', 'f3b7f97f9ab929f8fe531777027ccefa.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 11:45:35'), ('3', '91e19d1c2a5b2859ae067f9fb28cef1e.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 11:46:27'), ('4', 'dd55d8d02c1bc408fa77733ce687ce95.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 11:47:17'), ('5', 'c0ee43626b0965772121e8bf5de86ca2.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 11:56:29'), ('6', 'd520119bf2b5928b8ea4d2f337f92db5.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 11:57:49'), ('7', '511d39f89322c22788043d83666ab9db.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 11:57:57'), ('8', 'c92c8b4e079dbef4a5eb84b498d8765a.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 11:59:34'), ('9', 'a57ca3ec0cf8b87cfb58c7d6ab5075a2.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:00:23'), ('10', 'a520420e3007d4fec4e3a616bbc94afe.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:01:25'), ('11', '07b3ce4e491b385f64fd038e5cf8a233.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:06:25'), ('12', 'ac756f74ec1cf5c423da66af1b03faa1.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:08:34'), ('13', 'ef7cf04ce0d1778facee00bcbec8245b.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:09:01'), ('14', '52ae07413a6ee782e8914e53049728ac.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:10:14'), ('15', '770bf99b488a81968ec67748c8beeb9a.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:10:32'), ('16', '443f42f49410508dbde56cd1875c6ad5.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:10:49'), ('17', 'c69e39eb2c037a20628e5d85c325d075.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:11:38'), ('18', 'fef7db06c8b914dadac316438f827c87.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:13:19'), ('19', 'f15d59d9622a635bf8e8c6a879d7d04e.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:13:53'), ('20', '020c9537e3848f9a368999db07b5af79.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:25:21'), ('21', '2b73419e64241640631517f8deb7d712.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:27:52'), ('22', '98a848a7a223d2ed07f6395956dfcf3a.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:38:56'), ('23', '89956b6d6d395e38ebfc023d6f398c63.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:40:51'), ('24', '688c9476f48e4d32cfe5e2d64bfa704d.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 12:43:55'), ('25', '73cf33f6e568e666ac39b368b4f5b3c2.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 14:23:13'), ('26', 'ab98923586d5d7ba20128f7e64157fce.mp4', 'dynamic/', null, '27587222', null, null, null, 'vanmoof.mp4', '2017-03-09 14:24:01'), ('27', '3884fbd24bd37492f5825f82ee65f69f.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-09 14:40:57'), ('28', '3639e49a5114f552b06d547d51852fd0.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-09 15:26:15'), ('29', '450a427c264126bded21c722b4ebe5a8.png', 'dynamic/', 'image/png', '754453', '629', '764', '0.82330', 'festival02.png', '2017-03-09 15:47:41'), ('30', 'bad40f64a516db789205e9be7c5f213d.png', 'dynamic/', 'image/png', '1054457', '717', '806', '0.88958', 'festival04.png', '2017-03-09 15:54:17'), ('31', '9cf31304bb2f9da75b14d14345a44afb.png', 'dynamic/', 'image/png', '418408', '1260', '708', '1.77966', 'festival03.png', '2017-03-09 18:19:13'), ('32', '0807930ac05a04ff9a3a350971bf3128.png', 'dynamic/', 'image/png', '418408', '1260', '708', '1.77966', 'festival03.png', '2017-03-11 15:42:07'), ('33', '04275a35c7b5ba1e50c87492c2cc9d8a.jpg', 'dynamic/', 'image/jpeg', '101277', '924', '1200', '0.77000', 'profielfoto1.jpg', '2017-03-11 16:01:38'), ('34', 'a004db894d7b103dc9e18156dd88fb26.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:04:44'), ('35', 'c01b99fcca78689ccf94d38b0bebea5e.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-11 16:06:36'), ('36', '66e2d28666349fad170e9137998937d8.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:10:34'), ('37', '535717ca3db174818ae031bfd8526e6e.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-11 16:12:37'), ('38', null, 'dynamic/', null, null, null, null, null, 'vanmoof.mp4', '2017-03-11 16:22:57'), ('39', '89466065d76d3ba5f7b756d931baf9f5.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:23:02'), ('40', '1463508660c5cb819d6332e454f29248.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:23:07'), ('41', 'ba86e15bad08e27410f91983f8bb2545.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:23:13'), ('42', '056fcd78f40061a0632f98c5d7574756.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-11 16:25:02'), ('43', 'c933ac85c0ad808e4572dd393c1f649c.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:29:49'), ('44', '522860a2d0009256e61a5c0b7d96d08e.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-11 16:31:08'), ('45', '36f914d39103d8c73182bc64c895e1da.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:32:55'), ('46', '11a8fe23f7491953760bca8b1c1afd1d.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-11 16:33:18'), ('47', 'fca246e9ee8c9a27326209d7a7664b28.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:52:02'), ('48', 'ddc99231ef1d2f6450a8cfd8b077323c.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:52:37'), ('49', '9c90d8a0c6f9704d41057fa4a4458ef3.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-11 16:54:29'), ('50', '64d04a13c534ecc8b8d1a2471254fe27.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-11 16:54:56'), ('51', 'cd6f7f8ce88c9e7c6ce9e81d6faddab6.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:55:04'), ('52', '447e876f90eba6dfed68381a79d0aa85.jpg', 'dynamic/', 'image/jpeg', '106104', '962', '497', '1.93561', 'cristina_animals.jpg', '2017-03-11 16:55:14'), ('53', '4ea508ea45a17939ea1e7760ec467ead.png', 'dynamic/', 'image/png', '62629', '200', '200', '1.00000', 'sebastian.png', '2017-03-11 16:57:41'), ('54', 'e1be2b8e39bfe18798e86643b13aa2c1.png', 'dynamic/', 'image/png', '1578878', '1920', '1080', '1.77778', 'vluchtelingen.png', '2017-03-11 20:28:21'), ('55', 'c92c7b9767bc8a44fd2cb32b10992909.jpg', 'dynamic/', 'image/jpeg', '64902', '1920', '776', '2.47423', 'vvd-misleiding.jpg', '2017-03-11 20:50:29'), ('56', '71ab9bb8c5dbe7aabd70ed578729d117.jpg', 'dynamic/', 'image/jpeg', '64902', '1920', '776', '2.47423', 'vvd-misleiding.jpg', '2017-03-11 21:36:10'), ('57', 'ed336332ed888e44e0ff066445a024f9.png', 'dynamic/', 'image/png', '1578878', '1920', '1080', '1.77778', 'vluchtelingen.png', '2017-03-11 21:36:27'), ('58', 'd5eb83be4b699dda24a53e9478839226.jpg', 'dynamic/', 'image/jpeg', '82786', '1920', '823', '2.33293', 'batterijen.jpg', '2017-03-11 21:57:09'), ('59', '715b0fc77282ccb531aba1baf1561f6d.gif', 'dynamic/', 'image/gif', '5307379', '1920', '823', '2.33293', 'peilingen.gif', '2017-03-11 21:58:02'), ('60', 'ecb276403c878643d34993a906fc40f5.jpg', 'dynamic/', 'image/jpeg', '272159', '1920', '1000', '1.92000', 'intersekse.jpg', '2017-03-11 21:59:04');
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form` VALUES ('2', 'project', null, null, null, null, null, null, '2017-03-05 14:09:55'), ('3', 'articleType', null, null, null, null, null, null, '2017-03-06 13:51:55'), ('4', 'quote', null, null, null, null, null, null, '2017-03-07 09:29:36'), ('5', 'textMedia', null, null, null, null, null, null, '2017-03-07 09:30:56'), ('6', 'case', null, null, null, null, null, null, '2017-03-07 09:32:27'), ('20', 'autoForm', null, null, null, null, null, null, '2017-03-08 18:28:02'), ('21', 'project (1)', null, null, null, null, null, null, '2017-03-09 18:05:01'), ('22', 'project (2)', null, null, null, null, null, null, '2017-03-09 18:10:58'), ('23', 'project (3)', null, null, null, null, null, null, '2017-03-09 18:14:17'), ('24', 'project (4)', null, null, null, null, null, null, '2017-03-09 18:14:47'), ('25', 'author', null, null, null, null, null, null, '2017-03-11 14:22:58'), ('26', 'article', null, null, null, null, null, null, '2017-03-11 20:26:49');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_checkbox`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_checkbox` VALUES ('1', 'Aanuit', '', '', '2017-03-09 13:09:52');
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_image`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_image` VALUES ('1', 'Photo', '', '2017-03-09 14:40:44'), ('2', 'avatar', null, '2017-03-09 18:14:17'), ('3', 'avatar', null, '2017-03-09 18:14:47'), ('4', 'avatar', null, '2017-03-11 14:22:58'), ('5', 'headerImage', null, '2017-03-11 20:26:49');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_list`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_list` VALUES ('1', 'Subprojects', 'Add subprojects to this project', '2017-03-05 14:10:37'), ('2', 'Case sections', '', '2017-03-07 09:32:55');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_radiobutton`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_radiobutton` VALUES ('3', 'Type', '', '2017-03-11 22:38:40');
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_textblock`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textblock` VALUES ('1', 'Body', '', '', null, null, null, '2017-03-01 10:40:45'), ('2', 'Body', '', '', null, null, null, '2017-03-01 10:40:52'), ('4', 'Body', '', '', null, null, null, '2017-03-07 09:32:01'), ('5', 'Quote', '', '', null, null, null, '2017-03-08 13:21:26'), ('10', 'name', null, null, null, null, null, '2017-03-09 18:05:01'), ('11', 'name', null, null, null, null, null, '2017-03-09 18:10:58'), ('12', 'name', null, null, null, null, null, '2017-03-09 18:14:17'), ('13', 'name', null, null, null, null, null, '2017-03-09 18:14:47'), ('14', 'lede', null, null, null, null, null, '2017-03-11 20:26:49'), ('15', 'body', null, null, null, null, null, '2017-03-11 20:26:49');
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_input_textline`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_input_textline` VALUES ('1', 'Title', '', '', '', '2017-03-01 10:40:03'), ('6', 'Label', '', '', '', '2017-03-06 13:53:32'), ('12', 'Value', '', '', '', '2017-03-06 14:05:50'), ('16', 'Title', '', '', '', '2017-03-07 09:31:53'), ('17', 'Title', '', '', '', '2017-03-07 09:32:40'), ('23', 'Name', '', '', '', '2017-03-08 13:22:59'), ('27', 'Title', '', '', '', '2017-03-08 18:28:02'), ('28', 'name', null, null, null, '2017-03-11 14:22:58'), ('29', 'expertise', null, null, null, '2017-03-11 14:22:58'), ('30', 'title', null, null, null, '2017-03-11 20:26:49');
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
INSERT INTO `_Mimoto_form_input_video` VALUES ('1', 'Main video', '', '2017-03-09 11:12:45');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_inputoption`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_inputoption` VALUES ('2', null, 'Explainer', 'explainer', '2017-03-01 10:38:56'), ('3', null, 'Regular', 'regular', '2017-03-01 10:39:38'), ('4', null, 'Explainer', 'explainer', '2017-03-01 10:39:46'), ('9', null, 'xxx', 'ccc', '2017-03-05 16:43:53'), ('13', 'form', 'textMedia', '', '2017-03-07 09:33:13'), ('14', 'form', 'Quote', '', '2017-03-07 09:33:28'), ('15', 'value', 'Verhaal van de dag', 'regular', '2017-03-11 22:39:06'), ('16', 'value', 'Explainer', 'explainer', '2017-03-11 22:39:24');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_layout_groupend`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupend` VALUES ('1', '2017-03-06 14:05:55'), ('2', '2017-03-09 18:05:01'), ('3', '2017-03-09 18:10:58'), ('4', '2017-03-09 18:14:17'), ('5', '2017-03-09 18:14:47'), ('6', '2017-03-11 14:22:58'), ('7', '2017-03-11 17:02:06'), ('9', '2017-03-11 20:26:49');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_layout_groupstart`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_layout_groupstart` VALUES ('1', '', '2017-03-06 13:52:15'), ('2', null, '2017-03-09 18:05:01'), ('3', null, '2017-03-09 18:10:58'), ('4', null, '2017-03-09 18:14:17'), ('5', null, '2017-03-09 18:14:47'), ('6', null, '2017-03-11 14:22:58'), ('7', '', '2017-03-11 17:01:59'), ('8', null, '2017-03-11 20:26:49');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_form_output_title`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_form_output_title` VALUES ('1', 'Article type', '', '', '2017-03-06 13:52:10'), ('2', 'project', 'Auto-generated form', 'This form has been created by Mimoto\'s auto auto-generation feature based on the entity\'s properties on 09 March 2017 pm31 18:05:01. Adjust, add, remove or change the fields as you feel fit!', '2017-03-09 18:05:01'), ('3', 'project', 'Auto-generated form', 'This form has been created by Mimoto\'s auto auto-generation feature based on the entity\'s properties on 09 March 2017 pm31 18:10:58. Adjust, add, remove or change the fields as you feel fit!', '2017-03-09 18:10:58'), ('4', 'project', 'Auto-generated form', 'This form has been created by Mimoto\'s auto auto-generation feature based on the entity\'s properties on 09 March 2017 pm31 18:14:17. Adjust, add, remove or change the fields as you feel fit!', '2017-03-09 18:14:17'), ('5', 'project', 'Auto-generated form', 'This form has been created by Mimoto\'s auto auto-generation feature based on the entity\'s properties on 09 March 2017 pm31 18:14:47. Adjust, add, remove or change the fields as you feel fit!', '2017-03-09 18:14:47'), ('6', 'Author', 'Auto-generated form', 'This form has been created by Mimoto\'s auto auto-generation feature based on the entity\'s properties on 11 March 2017 14:22:58. Adjust, add, remove or change the fields as you feel fit!', '2017-03-11 14:22:58'), ('7', 'Case', '', '', '2017-03-11 17:04:21'), ('8', 'article', 'Auto-generated form', 'This form has been created by Mimoto\'s auto auto-generation feature based on the entity\'s properties on 11 March 2017 20:26:48. Adjust, add, remove or change the fields as you feel fit!', '2017-03-11 20:26:48');
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_Mimoto_notification`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_notification` VALUES ('57', 'No such property', 'The property <b>title</b> you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #212)', 'open', '2017-03-11 20:28:54'), ('58', 'No such property', 'The property <b>title</b> you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #212)', 'open', '2017-03-11 20:30:08'), ('59', 'Property or selection no found', 'The property or selection with name <b>avatar</b> doens\'t seem to be available.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::data (called from line #52)', 'open', '2017-03-11 20:32:40'), ('60', 'No such property', 'The property <b>avatar</b> you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #212)', 'open', '2017-03-11 20:32:40'), ('61', 'Entity not found', 'Sorry, I can\'t find the the \'article\' entity with id=\'TheCakeIsALie\'', 'silent', 'Mimoto\\Data\\EntityRepository::get (called from line #150)', 'open', '2017-03-11 20:48:51'), ('62', 'Entity not found', 'Sorry, I can\'t find the the \'article\' entity with id=\'TheCakeIsALie\'', 'silent', 'Mimoto\\Data\\EntityRepository::get (called from line #150)', 'open', '2017-03-11 21:56:47'), ('63', 'Entity not found', 'Sorry, I can\'t find the the \'article\' entity with id=\'TheCakeIsALie\'', 'silent', 'Mimoto\\Data\\EntityRepository::get (called from line #150)', 'open', '2017-03-11 21:57:31'), ('64', 'Entity not found', 'Sorry, I can\'t find the the \'article\' entity with id=\'TheCakeIsALie\'', 'silent', 'Mimoto\\Data\\EntityRepository::get (called from line #150)', 'open', '2017-03-11 21:58:29'), ('65', 'No such property', 'The property <b>type</b> you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #260)', 'open', '2017-03-11 22:36:28');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_selection`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selection`;
CREATE TABLE `_Mimoto_selection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_selection`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_selection` VALUES ('1', 'all_articles', '2017-03-01 14:36:51'), ('2', 'selection_of_articles', '2017-03-02 14:17:26'), ('3', 'articleTypes', '2017-03-06 14:15:20');
COMMIT;

-- ----------------------------
--  Table structure for `_Mimoto_selectionrule`
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selectionrule`;
CREATE TABLE `_Mimoto_selectionrule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `entity_type_id` varchar(255) DEFAULT NULL,
  `instance_id` varchar(255) DEFAULT NULL,
  `property_id` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_Mimoto_selectionrule`
-- ----------------------------
BEGIN;
INSERT INTO `_Mimoto_selectionrule` VALUES ('2', 'type', '3', null, null, '2017-03-01 14:37:00'), ('4', 'type', '_Mimoto_contentsection', '1', 'contentItems', '2017-03-02 14:17:46'), ('5', 'instance', null, '1', null, '2017-03-02 14:17:48'), ('6', 'childOf', null, null, 'contentItems', '2017-03-02 14:17:52'), ('7', 'type', '9', null, null, '2017-03-06 14:15:36');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `article`
-- ----------------------------
BEGIN;
INSERT INTO `article` VALUES ('1', 'Kijken: Vijf vluchtelingen met een belangrijke boodschap aan alle Nederlanders', 'regular', 'Dat â€‹ze hier niet voor â€‹hun plezier â€‹zijn. Dat ze niet uit een onderontwikkeld land komâ€‹en. Dat ze mensen zijn en meer contact willen met Nederlanders.\n\nâ€‹Hoe vergaat het nieuwkomers bij het opbouwen van een nieuw bestaan? Al een halfjaar lang brengen we in kaart hoe het vluchtelingen vergaat â€‹in Nederland. Honderden Correspondentleden spreken maandelijks nieuwkomers over hun ervaringen, wij maken verhalen van hun belangrijkste bevindingen. â€‹\n\nWe stellen ze nu ook graag aan jullie voor. Daarom vertellâ€‹en vijf deelnemers in dit filmpje wat Ã©lke Nederlander over vluchtelingen moet weten.', 'Wat moeten Nederlanders weten om te begrijpen hoe vluchtelingen zich voelen in hun land? Vijf nieuwkomers hebben een persoonlijke boodschap voor jou.', '2017-03-11 20:28:34'), ('2', 'De VVD misleidt de kiezer met een filmpje vol klimaatbeleid waar ze zelf tegen stemde', 'regular', 'Vijdag publiceerde de VVD een filmpje met actiepunten om \'Ã©cht iets te doen tegen klimaatverandering.â€™ Bijvoorbeeld schone technologie ontwikkelen en de afspraken uit het klimaatakkoord van Parijs nakomen.\n\nMaar de punten die de VVD in het filmpje maakt, staan lijnrecht tegenover het stemgedrag van de VVD in de Tweede Kamer.\n\nIk heb het stemgedrag en de programmaâ€™s van alle partijen geanalyseerd en concludeer in een artikel dat maandag verschijnt dat juist de VVD weinig aan klimaatactie doet. Ik was dan ook zeer verbaasd toen ik het VVD-filmpje zag. De beloftes die de partij in het filmpje doet, staan haaks op het eigen stemgedrag van de afgelopen kabinetsperiode.', 'De VVD heeft een campagnefilmpje gemaakt over haar klimaatvoornemens. Ik analyseerde het stemgedrag en ontdekte: de VVD belooft nu klimaatbeleid waar ze de afgelopen vier jaar stelselmatig tegen stemde.', '2017-03-11 20:50:50'), ('3', 'Batterijen schadelijk voor het milieu? Ze gaan het redden!', 'explainer', 'D caissiÃ¨re in de supermarkt vraagt op een dag wat ik eigenlijk voor werk doe. Ik schrijf, zeg ik. Waarover? Over batterijen.\n\nZe trekt een vies gezicht. â€˜Mijn zoontje zat laatst twee batterijen hard tegen elkaar aan te wrijven. Ze werden warm en ik was bang dat ze zouden ontploffen. Ik ben met ze naar buiten gerend en heb ze in de tuin gegooid.â€™\n\nIk antwoord, bijna automatisch: â€˜In de tuin? Je kunt ze toch hier inleveren, in de bak bij de voordeur?â€™ Maar de batterijen leken haar te gevaarlijk om nog aan te raken.\n\nEn ze is niet de enige. We zien batterijen als een noodzakelijk kwaad dat inmiddels overal in huis te vinden is - in telefoons en laptops, accuboren en afstandsbedieningen, babyfoons en gehoorapparaten. We kunnen niet zonder, maar blij worden we er niet van.\n\nDit verhaal is voor mijn caissiÃ¨re en voor iedereen die bij het woord batterijen een ongemakkelijk gevoel krijgt. Ik begon ze zelf pas te begrijpen toen ik me serieus in batterijen verdiepte  en ben pas echt overtuigd geraakt toen ik voor dit verhaal bij een Belgische batterijenrecyclingfabriek op bezoek ging.\n\nMaar nu weet ik het zeker. Batterijen zijn de beste technologische oplossing die we nu hebben voor het echte giftige en explosieve probleem op deze wereld: olie.', 'Batterijen zijn schadelijk voor het milieu, vertelt de overheid ons al jaren. Het is een achterhaalde en verkeerde boodschap. Batterijen maken niet alleen schone autoâ€™s mogelijk, ze vormen ook een herbruikbare grondstoffenbron die steeds planeetvriendelijker wordt.', '2017-03-11 21:57:23'), ('4', 'Peilingen domineren het politieke debat. Maar Ã©Ã©n cruciaal cijfer ontbreekt', 'explainer', 'Is het mogelijk dat we dit bericht over een paar dagen in de krant lezen? Volgens de peilingen  niet. Daarin gaan PVV en VVD gelijk op, is DENK nog piepklein en zien we nog altijd geen Asscher-effect.\n\nMaar na Brexit en Trump vraag je je misschien ook af: kunnen we de peilingen nog wel vertrouwen? Om dat uit te zoeken, neem ik vandaag een duik in de Nederlandse peilingbureaus. \n\nGaan de peilingen er in Nederland ook zo naast zitten?\n\nAllereerst goed om te zeggen: het â€˜falenâ€™ van de peilingen wordt nog weleens overdreven. Zo ging het in de Verenigde Staten vooral bij een aantal peilingen op staatniveau verkeerd. En in Nederland was het â€˜neeâ€™ op het OekraÃ¯nereferendum te verwachten als je naar de peilingen had gekeken. \n\nMaar er gaat iets fundamentelers mis bij het beantwoorden van de vraag of de peilingen er weer naast gaan zitten. Want met â€˜ernaast zittenâ€™ wordt bijna altijd bedoeld: de peilingen voorspelden de uitslag niet goed. Dat terwijl peilingen geen voorspellingen zijn. Het zijn momentopnames, die een zo goed mogelijk beeld proberen te geven van de situatie op dat moment.\n\nEr gebeurt tussen peiling en verkiezing nog veel dat de uitslag kan beÃ¯nvloeden. Debatten, schandaaltjes, interviews met de LINDA. En natuurlijk de peilingen zelf, want ook die kunnen je in een bepaalde richting duwen. ', 'Hoe dichter we bij de verkiezingen komen, hoe belangrijker de peilingen lijken te worden. Maar hoe betrouwbaar zijn de peilingen waarop we onze stem baseren?', '2017-03-11 21:58:26'), ('5', '85.000 Nederlanders hebben een intersekseconditie. Tijd om hen te leren kennen', 'regular', 'Eind jaren veertig wonen Mina, haar man en hun vier dochters in een kleine arbeiderswoning in een Nederlandse stad. Bij de jongste dochter is een bobbeltje in een schaamlip voelbaar, waarna de vier zusjes worden onderzocht in een stadsziekenhuis. De conclusie? Drie van de vier meisjes zijn â€˜eigenlijk jongens.â€™ Op hun geboorteakten worden naam en geslacht aangepast, maar voor jongenskleding is geen geld. Om hun genitaliÃ«n mannelijker te laten lijken, ondergaan zij wel hun hele jeugd operaties. Er wordt hun op het hart gedrukt alles geheim te houden. Desondanks worden de drie hun hele jeugd gepest.\n\nEind jaren tachtig blijft bij Tania de menstruatie uit. Een genetische test volgt. Pas nadat ze drie keer opnieuw is getest, blijkt de uitslag â€˜XY-geslachtschromosomenâ€™  niet het gevolg van verwisselde samples, maar van een interseksevariatie. Jarenlang zocht ze naar vrouwen zoals zij, maar steeds kreeg ze te horen dat zij de enige was.\n\nBegin jaren negentig krijgt de dertigjarige Amerikaanse Bo Laurent haar medisch dossier te zien. Er staat â€˜Echt Hermafroditisme.â€™ Ook ziet ze dat ze een broertje had, Brian, met dezelfde verjaardag. De geheimzinnigheid van artsen en ouders en het pijnlijke litteken op de plek waar andere vrouwen een clitoris hebben, het valt allemaal op zijn plaats. Zij was dat broertje. Omdat artsen haar penis niet groot genoeg vonden, moest zij als meisje verder, waarop clitorectomie  volgde.', 'Je kunt geboren worden met kenmerken van mannen Ã©n vrouwen. Lange tijd was het gewoon die mensen te opereren, zodat ze â€˜gewoonâ€™ man of vrouw werden. In de westerse wereld is die tijd voorbij, maar nog steeds valt er een wereld te winnen.', '2017-03-11 21:59:31');
COMMIT;

-- ----------------------------
--  Table structure for `articleType`
-- ----------------------------
DROP TABLE IF EXISTS `articleType`;
CREATE TABLE `articleType` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `articleType`
-- ----------------------------
BEGIN;
INSERT INTO `articleType` VALUES ('1', 'Regular', 'regular', '2017-03-06 14:06:30'), ('2', 'Explainer', 'explainer', '2017-03-06 14:06:44'), ('3', 'Column', 'column', '2017-03-06 14:06:52'), ('4', 'Documentary', 'documentary', '2017-03-06 14:07:06'), ('5', 'Interview', 'interview', '2017-03-06 14:07:19');
COMMIT;

-- ----------------------------
--  Table structure for `author`
-- ----------------------------
DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expertise` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `author`
-- ----------------------------
BEGIN;
INSERT INTO `author` VALUES ('1', 'Sebastian Kersten', 'CTO', '2017-03-11 15:42:09');
COMMIT;

-- ----------------------------
--  Table structure for `autoForm`
-- ----------------------------
DROP TABLE IF EXISTS `autoForm`;
CREATE TABLE `autoForm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aanuit` enum('0','1') COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `autoForm`
-- ----------------------------
BEGIN;
INSERT INTO `autoForm` VALUES ('1', 'Test', '1', null, '2017-03-09 13:10:51');
COMMIT;

-- ----------------------------
--  Table structure for `case`
-- ----------------------------
DROP TABLE IF EXISTS `case`;
CREATE TABLE `case` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `case`
-- ----------------------------
BEGIN;
INSERT INTO `case` VALUES ('1', 'xxx', '2017-03-07 09:44:44'), ('3', 'Sebastian test', '2017-03-07 16:29:01'), ('4', 'heleenTest', '2017-03-07 16:31:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `comment`
-- ----------------------------
BEGIN;
INSERT INTO `comment` VALUES ('1', null, '2017-03-12 08:00:10');
COMMIT;

-- ----------------------------
--  Table structure for `feed`
-- ----------------------------
DROP TABLE IF EXISTS `feed`;
CREATE TABLE `feed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `project`
-- ----------------------------
BEGIN;
INSERT INTO `project` VALUES ('1', '1', null), ('2', 'sdfdfsdfsd', '2017-03-09 18:19:17');
COMMIT;

-- ----------------------------
--  Table structure for `quote`
-- ----------------------------
DROP TABLE IF EXISTS `quote`;
CREATE TABLE `quote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quote` text COLLATE utf8_unicode_ci,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `quote`
-- ----------------------------
BEGIN;
INSERT INTO `quote` VALUES ('1', 'quote 1', 'dsfsdfsdfsdf', '2017-03-07 10:53:04'), ('15', 'hoi', 'test', '2017-03-07 16:31:31'), ('16', 'hoi', 'test', '2017-03-07 16:31:38'), ('30', 'Number 3', 'The test', '2017-03-10 13:47:43'), ('32', '#1 - Heleen', '614', '2017-03-10 14:33:46'), ('33', '#2 - Jorrit', '624', '2017-03-10 14:34:01'), ('34', '#3 - Sebastian', '634', '2017-03-10 14:35:54');
COMMIT;

-- ----------------------------
--  Table structure for `subproject`
-- ----------------------------
DROP TABLE IF EXISTS `subproject`;
CREATE TABLE `subproject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `textMedia`
-- ----------------------------
DROP TABLE IF EXISTS `textMedia`;
CREATE TABLE `textMedia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `textMedia`
-- ----------------------------
BEGIN;
INSERT INTO `textMedia` VALUES ('11', 'sdfsdfsd', 'fsdfsdfsdfsdf', '2017-03-07 16:14:23'), ('15', 'Number 1', 'hgjhgjgh', '2017-03-08 11:18:09');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
