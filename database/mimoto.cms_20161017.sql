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

 Date: 10/17/2016 23:42:11 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `_MimotoAimless__config__action`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__config__action`;
CREATE TABLE `_MimotoAimless__config__action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity` varchar(255) NOT NULL,
  `connectiontable` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `_MimotoAimless__connections__core`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__connections__core`;
CREATE TABLE `_MimotoAimless__connections__core` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_property_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `child_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9013 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__connections__core`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__connections__core` VALUES ('1', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1', '_MimotoAimless__core__entityproperty', '1', '0'), ('2', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1', '_MimotoAimless__core__entityproperty', '2', '1'), ('3', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--extends', '3', '_MimotoAimless__core__entity', '4', '2'), ('4', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entityproperty', '3', '0'), ('5', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entityproperty', '4', '1'), ('6', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entityproperty', '5', '2'), ('7', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entityproperty', '6', '3'), ('50', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '3', '_MimotoAimless__core__entityproperty', '50', '0'), ('51', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '50', '_MimotoAimless__core__entitypropertysetting', '50', '0'), ('60', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '4', '_MimotoAimless__core__entityproperty', '60', '0'), ('61', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '60', '_MimotoAimless__core__entitypropertysetting', '60', '0'), ('70', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--extends', '4', '_MimotoAimless__core__entity', '1', '0'), ('201', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1', '_MimotoAimless__core__entitypropertysetting', '1', '0'), ('202', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entitypropertysetting', '2', '1'), ('203', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '3', '_MimotoAimless__core__entitypropertysetting', '3', '0'), ('204', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '4', '_MimotoAimless__core__entitypropertysetting', '4', '1'), ('205', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '5', '_MimotoAimless__core__entitypropertysetting', '5', '2'), ('206', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '6', '_MimotoAimless__core__entitypropertysetting', '6', '3'), ('1001', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1001', '0'), ('1002', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1002', '1'), ('1003', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1003', '2'), ('1004', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1004', '3'), ('1005', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1005', '4'), ('1006', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1006', '5'), ('1101', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1101', '0'), ('1102', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1102', '1'), ('1103', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1103', '2'), ('1104', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1104', '3'), ('1105', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1105', '4'), ('1106', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1106', '5'), ('1107', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1107', '6'), ('1201', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1200', '_MimotoAimless__core__entityproperty', '1201', '0'), ('1301', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1300', '_MimotoAimless__core__entityproperty', '1301', '0'), ('1401', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1400', '_MimotoAimless__core__entityproperty', '1401', '0'), ('1501', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1500', '_MimotoAimless__core__entityproperty', '1501', '0'), ('1601', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1600', '_MimotoAimless__core__entityproperty', '1601', '0'), ('1602', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1600', '_MimotoAimless__core__entityproperty', '1602', '1'), ('1603', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1600', '_MimotoAimless__core__entityproperty', '1603', '2'), ('2001', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1001', '_MimotoAimless__core__entitypropertysetting', '1001', '0'), ('2002', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1002', '_MimotoAimless__core__entitypropertysetting', '1002', '0'), ('2003', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1003', '_MimotoAimless__core__entitypropertysetting', '1003', '0'), ('2004', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1004', '_MimotoAimless__core__entitypropertysetting', '1004', '0'), ('2005', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1005', '_MimotoAimless__core__entitypropertysetting', '1005', '0'), ('2006', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1006', '_MimotoAimless__core__entitypropertysetting', '1006', '0'), ('2007', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1006', '_MimotoAimless__core__entitypropertysetting', '1007', '1'), ('2010', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_image', '1', '9'), ('2011', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_video', '1', '10'), ('2101', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1101', '_MimotoAimless__core__entitypropertysetting', '1101', '0'), ('2102', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1102', '_MimotoAimless__core__entitypropertysetting', '1102', '0'), ('2103', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1103', '_MimotoAimless__core__entitypropertysetting', '1103', '0'), ('2104', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1104', '_MimotoAimless__core__entitypropertysetting', '1104', '0'), ('2105', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1105', '_MimotoAimless__core__entitypropertysetting', '1105', '0'), ('2106', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1106', '_MimotoAimless__core__entitypropertysetting', '1106', '0'), ('2107', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1107', '_MimotoAimless__core__entitypropertysetting', '1107', '0'), ('2201', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1201', '_MimotoAimless__core__entitypropertysetting', '1201', '0'), ('2301', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1301', '_MimotoAimless__core__entitypropertysetting', '1301', '0'), ('2401', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1401', '_MimotoAimless__core__entitypropertysetting', '1401', '0'), ('2501', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1501', '_MimotoAimless__core__entitypropertysetting', '1501', '0'), ('2601', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1601', '_MimotoAimless__core__entitypropertysetting', '1601', '0'), ('2602', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1602', '_MimotoAimless__core__entitypropertysetting', '1602', '0'), ('2603', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1603', '_MimotoAimless__core__entitypropertysetting', '1603', '0'), ('5001', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_output_title', '1', '0'), ('5002', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_layout_groupstart', '1', '1'), ('5003', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_textline', '1', '2'), ('5004', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_layout_divider', '1', '3'), ('5005', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_textline', '2', '4'), ('5006', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_checkbox', '1', '5'), ('5007', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_dropdown', '1', '6'), ('5008', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_radiobutton', '1', '7'), ('5009', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_list', '1', '8'), ('5012', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_layout_groupend', '1', '11'), ('5100', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '100', '_MimotoAimless__interaction__form_output_title', '100', '0'), ('5101', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '100', '_MimotoAimless__interaction__form_layout_groupstart', '100', '1'), ('5102', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '100', '_MimotoAimless__interaction__form_input_textline', '100', '2'), ('5103', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '100', '_MimotoAimless__interaction__form_layout_groupend', '100', '3'), ('5200', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '200', '_MimotoAimless__interaction__form_output_title', '200', '0'), ('5201', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '200', '_MimotoAimless__interaction__form_layout_groupstart', '200', '1'), ('5202', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '200', '_MimotoAimless__interaction__form_input_textline', '200', '2'), ('5203', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '200', '_MimotoAimless__interaction__form_layout_groupend', '200', '3'), ('6001', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_output_title', '3', '0'), ('6002', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_layout_groupstart', '3', '1'), ('6003', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_input_textline', '3', '2'), ('6004', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_input_textline', '4', '3'), ('6005', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_layout_groupend', '3', '4'), ('7000', '_MimotoAimless__interaction__form_input_textline', '_MimotoAimless__interaction__forminput--value', '3', '_MimotoAimless__interaction__forminputvalue', '1', '0'), ('7010', '_MimotoAimless__interaction__form_input_textline', '_MimotoAimless__interaction__forminput--value', '4', '_MimotoAimless__interaction__forminputvalue', '2', '0'), ('7011', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--entityproperty', '1', '_MimotoAimless__core__entityproperty', '1201', '0'), ('8000', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_output_title', '50', '0'), ('8001', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_layout_groupstart', '50', '1'), ('8002', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_input_textline', '50', '2'), ('8003', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_input_radiobutton', '50', '3'), ('8004', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_input_textline', '51', '4'), ('8005', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_layout_groupend', '50', '5'), ('8010', '_MimotoAimless__interaction__form_input_textline', '_MimotoAimless__interaction__forminput--value', '50', '_MimotoAimless__interaction__forminputvalue', '150', '0'), ('8011', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--entityproperty', '150', '_MimotoAimless__core__entityproperty', '1001', '0'), ('8020', '_MimotoAimless__interaction__form_input_radiobutton', '_MimotoAimless__interaction__forminput--value', '50', '_MimotoAimless__interaction__forminputvalue', '152', '0'), ('8021', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--entityproperty', '152', '_MimotoAimless__core__entityproperty', '1103', '0'), ('8030', '_MimotoAimless__interaction__form_input_textline', '_MimotoAimless__interaction__forminput--value', '51', '_MimotoAimless__interaction__forminputvalue', '151', '0'), ('8031', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--entityproperty', '151', '_MimotoAimless__core__entityproperty', '1002', '0'), ('9001', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--options', '152', '_MimotoAimless__interaction__forminputvaluesetting', '1', '0'), ('9002', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--options', '152', '_MimotoAimless__interaction__forminputvaluesetting', '2', '1'), ('9003', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--options', '152', '_MimotoAimless__interaction__forminputvaluesetting', '3', '2'), ('9011', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--validation', '152', '_MimotoAimless__interaction__forminputvaluevalidation', '1', '0'), ('9012', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--validation', '152', '_MimotoAimless__interaction__forminputvaluevalidation', '2', '1');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__connections__project`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__connections__project`;
CREATE TABLE `_MimotoAimless__connections__project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_entity_type_id` int(10) DEFAULT NULL,
  `parent_property_id` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `child_entity_type_id` int(10) unsigned DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1252 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__connections__project`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__connections__project` VALUES ('1', '1000', '1006', '3', '1100', '1', '0'), ('2', '1000', '1006', '3', '1100', '2', '1'), ('3', '1000', '1006', '3', '1100', '3', '2'), ('4', '1000', '1006', '2', '1100', '4', '0'), ('100', '1100', '1102', '1', '1600', '2', '0'), ('936', '1000', '1006', '2', '1100', '5', '2'), ('1192', '1000', '1005', '2', '1400', '1', '0'), ('1193', '1000', '1006', '2', '1100', '3', '2'), ('1230', '1000', '1005', '3', '1400', '2', '0'), ('1251', '1000', '1006', '3', '1100', '5', '3');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__core__entity`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__core__entity`;
CREATE TABLE `_MimotoAimless__core__entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1601 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_MimotoAimless__core__entity`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__core__entity` VALUES ('1', 'person', '2016-07-29 14:13:46'), ('2', 'article', '2016-08-17 11:16:09'), ('3', 'author', '2016-08-22 10:30:30'), ('4', 'member', '2016-09-05 13:21:11'), ('1000', 'project', '2016-08-24 13:46:00'), ('1100', 'subproject', '2016-08-24 13:49:31'), ('1200', 'client', '2016-08-24 13:49:16'), ('1300', 'agency', '2016-08-24 13:53:03'), ('1400', 'projectManager', '2016-08-24 13:53:13'), ('1500', 'subprojectState', '2016-08-24 13:53:54'), ('1600', 'contact', '2016-08-24 14:10:20');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__core__entityproperty`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__core__entityproperty`;
CREATE TABLE `_MimotoAimless__core__entityproperty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` enum('value','entity','collection') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1604 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__core__entityproperty`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__core__entityproperty` VALUES ('1', 'name', 'value', '2016-07-27 12:24:53'), ('2', 'role', 'value', '2016-07-27 16:45:01'), ('3', 'type', 'value', '2016-08-17 11:16:38'), ('4', 'title', 'value', '2016-08-17 11:16:49'), ('5', 'lede', 'value', '2016-08-17 11:16:57'), ('6', 'body', 'value', '2016-08-17 11:17:09'), ('50', 'biography', 'value', '2016-09-05 10:05:45'), ('60', 'email', 'value', '2016-09-05 13:22:07'), ('1001', 'name', 'value', '2016-08-24 13:46:39'), ('1002', 'description', 'value', '2016-08-24 13:46:51'), ('1003', 'client', 'entity', '2016-08-24 13:47:45'), ('1004', 'agency', 'entity', '2016-08-24 13:47:54'), ('1005', 'projectManager', 'entity', '2016-08-24 13:48:17'), ('1006', 'subprojects', 'collection', '2016-08-25 11:44:24'), ('1101', 'name', 'value', '2016-08-24 13:56:05'), ('1102', 'contact', 'entity', '2016-08-24 13:56:25'), ('1103', 'phase', 'value', '2016-08-24 13:57:06'), ('1104', 'state', 'value', '2016-08-24 13:57:16'), ('1105', 'probability', 'value', '2016-08-24 13:57:26'), ('1106', 'budget', 'value', '2016-08-24 13:57:40'), ('1107', 'paymentType', 'value', '2016-08-24 13:57:55'), ('1201', 'name', 'value', '2016-08-24 13:55:17'), ('1301', 'name', 'value', '2016-08-24 13:55:28'), ('1401', 'name', 'value', '2016-08-24 13:55:37'), ('1501', 'name', 'value', '2016-08-24 13:55:46'), ('1601', 'name', 'value', '2016-08-24 14:10:33'), ('1602', 'email', 'value', '2016-08-24 14:11:23'), ('1603', 'phoneNumber', 'value', '2016-08-24 14:11:36');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__core__entitypropertysetting`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__core__entitypropertysetting`;
CREATE TABLE `_MimotoAimless__core__entitypropertysetting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1604 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__core__entitypropertysetting`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__core__entitypropertysetting` VALUES ('1', 'type', 'value', 'textline', '2016-08-10 13:54:51'), ('2', 'type', 'value', 'textline', '2016-08-10 13:55:02'), ('3', 'type', 'value', 'textline', '2016-08-17 11:18:40'), ('4', 'type', 'value', 'textline', '2016-08-17 11:18:51'), ('5', 'type', 'value', 'textblock', '2016-08-17 11:19:32'), ('6', 'type', 'value', 'textblock', '2016-08-17 11:19:41'), ('50', 'type', 'value', 'textblock', '2016-09-05 10:06:01'), ('60', 'type', 'value', 'textline', '2016-09-05 13:22:24'), ('1001', 'type', 'value', 'textline', '2016-08-24 14:07:44'), ('1002', 'type', 'value', 'textblock', '2016-08-24 14:07:56'), ('1003', 'allowedEntityType', 'value', '1200', '2016-08-24 14:08:43'), ('1004', 'allowedEntityType', 'value', '1300', '2016-08-24 14:09:03'), ('1005', 'allowedEntityType', 'value', '1400', '2016-08-24 14:09:17'), ('1006', 'allowedEntityTypes', 'array', '[1100]', '2016-08-25 11:45:26'), ('1007', 'allowDuplicates', 'boolean', 'false', '2016-08-25 11:45:55'), ('1101', 'type', 'value', 'textline', '2016-08-24 14:09:39'), ('1102', 'allowedEntityType', 'value', '1600', '2016-08-24 14:10:03'), ('1103', 'type', 'value', 'textline', '2016-08-24 14:13:21'), ('1104', 'type', 'value', 'textline', '2016-08-24 14:13:17'), ('1105', 'type', 'value', 'textline', '2016-08-24 14:13:32'), ('1106', 'type', 'value', 'textline', '2016-08-24 14:13:42'), ('1107', 'type', 'value', 'textline', '2016-08-24 14:13:51'), ('1201', 'type', 'value', 'textline', '2016-08-24 14:14:01'), ('1301', 'type', 'value', 'textline', '2016-08-24 14:14:48'), ('1401', 'type', 'value', 'textline', '2016-08-24 14:14:51'), ('1501', 'type', 'value', 'textline', '2016-08-24 14:14:53'), ('1601', 'type', 'value', 'textline', '2016-08-24 14:14:55'), ('1602', 'type', 'value', 'textline', '2016-08-24 14:14:58'), ('1603', 'type', 'value', 'textline', '2016-08-24 14:15:00');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form`;
CREATE TABLE `_MimotoAimless__interaction__form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `customSubmit` enum('0','1') COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form` VALUES ('2', 'form_person', 'Test', null, null, null, null, '2016-08-10 14:29:42'), ('3', 'client', 'A simple form to add and edit clients', null, null, null, null, '2016-06-27 14:06:17'), ('50', 'project', 'Altering a form', null, null, null, null, '2016-10-09 16:51:40'), ('100', 'form_entity_create', 'Core form for creating entities', null, null, null, null, '2016-08-17 12:21:21'), ('200', 'form_entity_edit', 'Core form for changing existing entities', null, null, null, null, '2016-08-17 12:26:10');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_checkbox`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_checkbox`;
CREATE TABLE `_MimotoAimless__interaction__form_input_checkbox` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_checkbox`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_checkbox` VALUES ('1', 'State', 'Person is currently active on the project', '2016-08-15 13:47:47');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_dropdown`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_dropdown`;
CREATE TABLE `_MimotoAimless__interaction__form_input_dropdown` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `options` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_dropdown`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_dropdown` VALUES ('1', 'Number of hours', '[\"0-2\", \"0 - 2 hours per day\", \"2-4\", \"2 - 4 hours a day\", \"4-8\", \"4-8 hours a day\"]', '2016-08-15 13:49:42');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_image`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_image`;
CREATE TABLE `_MimotoAimless__interaction__form_input_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_image`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_image` VALUES ('1', 'Image', 'This is an image', '2016-08-15 13:47:47');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_list`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_list`;
CREATE TABLE `_MimotoAimless__interaction__form_input_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_list`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_list` VALUES ('1', 'List', 'Tis is a list', '2016-08-15 13:47:47');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_radiobutton`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_radiobutton`;
CREATE TABLE `_MimotoAimless__interaction__form_input_radiobutton` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_radiobutton`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_radiobutton` VALUES ('1', 'Number of hours', null, '2016-08-15 13:49:42'), ('50', 'Project phase', '', '2016-10-12 21:51:50');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_textblock`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_textblock`;
CREATE TABLE `_MimotoAimless__interaction__form_input_textblock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `optional` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regexp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxchars` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_textblock`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_textblock` VALUES ('1', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '10', '2016-08-10 16:13:50'), ('2', 'Role', null, null, 'false', null, null, '2016-08-12 10:24:05'), ('3', 'Name', 'This field is connected to an entity\'s property', 'Enter the client\'s name', 'true', '/[a-zA-Z09-]/', '10', '2016-10-02 13:08:25'), ('4', 'Custom var', 'Dit is een custom var', 'Enter the value of this custom var', 'false', null, null, '2016-10-09 15:25:54'), ('50', 'Name', 'The project\'s name', 'Enter a name', 'false', null, null, '2016-10-09 16:56:43'), ('51', 'Description', 'The project\'s desription', 'Enter a description', 'false', null, null, '2016-10-09 16:57:38'), ('100', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '20', '2016-08-17 13:18:21'), ('200', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '20', '2016-08-17 13:18:36');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_textline`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_textline`;
CREATE TABLE `_MimotoAimless__interaction__form_input_textline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `optional` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regexp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxchars` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_textline`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_textline` VALUES ('1', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '10', '2016-08-10 16:13:50'), ('2', 'Role', null, null, 'false', null, null, '2016-08-12 10:24:05'), ('3', 'Name', 'This field is connected to an entity\'s property', 'Enter the client\'s name', 'true', '/[a-zA-Z09-]/', '10', '2016-10-02 13:08:25'), ('4', 'Custom var', 'Dit is een custom var', 'Enter the value of this custom var', 'false', null, null, '2016-10-09 15:25:54'), ('50', 'Name', 'The project\'s name', 'Enter a name', 'false', null, null, '2016-10-09 16:56:43'), ('51', 'Description', 'The project\'s description', 'Enter a description', 'false', null, null, '2016-10-09 16:57:38'), ('100', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '20', '2016-08-17 13:18:21'), ('200', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '20', '2016-08-17 13:18:36');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_textrtf`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_textrtf`;
CREATE TABLE `_MimotoAimless__interaction__form_input_textrtf` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `optional` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regexp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxchars` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_textrtf`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_textrtf` VALUES ('1', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '10', '2016-08-10 16:13:50'), ('2', 'Role', null, null, 'false', null, null, '2016-08-12 10:24:05'), ('3', 'Name', 'This field is connected to an entity\'s property', 'Enter the client\'s name', 'true', '/[a-zA-Z09-]/', '10', '2016-10-02 13:08:25'), ('4', 'Custom var', 'Dit is een custom var', 'Enter the value of this custom var', 'false', null, null, '2016-10-09 15:25:54'), ('50', 'Name', 'The project\'s name', 'Enter a name', 'false', null, null, '2016-10-09 16:56:43'), ('51', 'Description', 'The project\'s desription', 'Enter a description', 'false', null, null, '2016-10-09 16:57:38'), ('100', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '20', '2016-08-17 13:18:21'), ('200', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '20', '2016-08-17 13:18:36');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_video`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_video`;
CREATE TABLE `_MimotoAimless__interaction__form_input_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_video`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_video` VALUES ('1', 'Video', 'This is a video', '2016-08-15 13:47:47');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_layout_divider`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_layout_divider`;
CREATE TABLE `_MimotoAimless__interaction__form_layout_divider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_layout_divider`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_layout_divider` VALUES ('1', '2016-08-17 10:40:01');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_layout_groupend`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_layout_groupend`;
CREATE TABLE `_MimotoAimless__interaction__form_layout_groupend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_layout_groupend`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_layout_groupend` VALUES ('1', '2016-08-04 08:38:28'), ('3', '2016-10-02 13:07:53'), ('50', '2016-10-09 16:55:25'), ('100', '2016-08-17 13:58:02'), ('200', '2016-08-17 13:58:07');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_layout_groupstart`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_layout_groupstart`;
CREATE TABLE `_MimotoAimless__interaction__form_layout_groupstart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_layout_groupstart`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_layout_groupstart` VALUES ('1', 'First group', '2016-08-04 08:38:28'), ('3', 'Client group', '2016-10-02 13:07:26'), ('50', null, '2016-10-09 16:55:16'), ('100', null, '2016-08-17 13:57:43'), ('200', null, '2016-08-17 13:57:53');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_output_title`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_output_title`;
CREATE TABLE `_MimotoAimless__interaction__form_output_title` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_output_title`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_output_title` VALUES ('1', 'Hello', 'First output field', 'This is the first output field connected to a genuine form config as port of the Mimoto FormGenerator. Yay!', '2016-08-04 08:38:28'), ('2', 'And welcome', 'Second output field', 'This is the description of the second output field that was connected to this first example form.', '2016-08-10 16:44:36'), ('3', 'Client', 'Edit the details of a client', 'Client names should be unique', '2016-10-02 13:04:37'), ('50', 'Project', 'Edit the details of this project', 'Bla bla bla, just some comment #todo', '2016-10-09 16:54:59'), ('100', 'Create entity', 'Add a new entity to your project', 'After creation the entity is ready for use in your code.', '2016-08-17 12:23:25'), ('200', 'Edit entity', 'Change an existing entity', 'Be careful - Changes made to this entity whould also be applied in your code!', '2016-08-17 12:25:47');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__forminput`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__forminput`;
CREATE TABLE `_MimotoAimless__interaction__forminput` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__forminputvalue`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__forminputvalue`;
CREATE TABLE `_MimotoAimless__interaction__forminputvalue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vartype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `varname` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `optional` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__forminputvalue`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__forminputvalue` VALUES ('1', 'entityproperty', '', null, '2016-10-07 10:27:06'), ('2', 'varname', 'xxxxxxx', null, '2016-10-09 15:26:17'), ('150', 'entityproperty', null, null, '2016-10-09 16:58:52'), ('151', 'entityproperty', null, null, '2016-10-09 16:59:01'), ('152', 'entityproperty', '', null, '2016-10-12 21:44:13');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__forminputvaluesetting`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__forminputvaluesetting`;
CREATE TABLE `_MimotoAimless__interaction__forminputvaluesetting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__forminputvaluesetting`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__forminputvaluesetting` VALUES ('1', 'request', 'Aanvraag', '2016-10-16 21:16:31'), ('2', 'currentproject', 'Lopend project', '2016-10-16 21:16:43'), ('3', 'archived', 'Archief', '2016-10-16 21:16:53');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__forminputvaluevalidation`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__forminputvaluevalidation`;
CREATE TABLE `_MimotoAimless__interaction__forminputvaluevalidation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__forminputvaluevalidation`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__forminputvaluevalidation` VALUES ('1', 'maxchars', '10', '2016-10-16 21:16:31'), ('2', 'regex_custom', '/^[a-zA-Z0-9]*$/', '2016-10-16 21:16:43');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__view__component`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__view__component`;
CREATE TABLE `_MimotoAimless__view__component` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_MimotoAimless__view__component`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__view__component` VALUES ('5', 'project_listitem', 'pages/projects/components/Project.twig', '2016-05-24 07:44:27'), ('6', 'subproject_listitem', 'pages/projects/components/Subproject.twig', '2016-05-24 07:44:51'), ('8', 'article', 'examples/components/Article.twig', '2016-05-25 16:54:30'), ('9', 'feed', 'examples/components/Feed.twig', '2016-05-29 15:57:53'), ('10', 'feeditem', 'examples/components/FeedItem1.twig', '2016-05-29 15:58:21'), ('11', 'article_type', 'examples/components/ArticleRegular.twig', '2016-05-29 16:03:28'), ('12', 'article_type', 'examples/components/ArticleExplainer.twig', '2016-05-29 16:03:56'), ('13', 'feeditem_type', 'examples/components/FeedItem1.twig', '2016-05-29 16:56:41'), ('14', 'feeditem_type', 'examples/components/FeedItem2.twig', '2016-05-29 16:57:07'), ('15', 'article_overview', 'examples/components/ArticleOverview.twig', '2016-05-29 17:20:28'), ('16', 'page_settings', 'pages/SettingsPage.twig', '2016-05-29 20:46:35'), ('17', 'page_settings_clients', 'pages/settings/ClientsPage.twig', '2016-05-29 20:47:20'), ('18', 'settings_listitem', 'pages/settings/components/ListItemComponent.twig', '2016-05-29 20:55:12'), ('19', 'page_settings_agencies', 'pages/settings/AgenciesPage.twig', '2016-05-29 21:23:04'), ('20', 'page_settings_projectmanagers', 'pages/settings/ProjectManagersPage.twig', '2016-05-29 21:24:27'), ('21', 'page_settings_subprojectstates', 'pages/settings/SubprojectStatesPage.twig', '2016-05-29 21:25:10'), ('22', 'page_forecast', 'pages/ForecastPage.twig', '2016-05-29 22:01:51'), ('23', 'page_result', 'pages/ResultPage.twig', '2016-05-29 22:02:18'), ('24', 'page_projects', 'pages/ProjectsPage.twig', '2016-05-29 22:05:17'), ('25', 'page_silent', 'pages/SilentPage.twig', '2016-05-29 22:12:52'), ('26', 'project_withsubprojects', 'examples/components/ProjectWithSubprojects.twig', '2016-05-31 21:48:05'), ('27', 'project_withsubprojects_phase', 'examples/components/ProjectWithSubprojectsPhase.twig', '2016-05-31 21:50:11'), ('28', 'project_withsubprojects_filter', 'examples/components/ProjectWithSubprojectsFilter.twig', '2016-05-31 21:53:49'), ('29', 'subproject', 'examples/components/Subproject.twig', '2016-05-31 22:10:10'), ('30', 'subproject_phase', 'examples/components/Subproject.twig', '2016-05-31 22:10:43'), ('31', 'subproject_phase', 'examples/components/SubprojectActive.twig', '2016-06-01 12:44:08'), ('32', 'subproject_phase', 'examples/components/SubprojectArchived.twig', '2016-06-01 12:45:44'), ('33', 'notificationcenter', 'notificationcenter/NotificationCenter.twig', '2016-06-07 09:51:20'), ('34', 'notification', 'notificationcenter/NotificationCenter.twig', '2016-06-07 09:53:50'), ('35', 'client_overview', 'examples/components/ClientOverview.twig', '2016-06-11 12:21:52'), ('36', 'client_listitem', 'examples/components/ListItemComponent.twig', '2016-06-11 12:22:54'), ('37', 'entity_overview', 'exampleadmin/EntityOverview.twig', '2016-06-13 10:42:03'), ('38', 'entity_listitem', 'exampleadmin/EntityListItem.twig', '2016-06-13 10:52:12'), ('39', 'subproject_overview', 'examples/components/SubprojectOverview.twig', '2016-06-13 11:46:46'), ('40', 'subproject_examplelistitem', 'examples/components/SubprojectListItem.twig', '2016-06-13 11:47:15'), ('41', 'form_client', 'forms/ClientForm.twig', '2016-06-27 14:38:36'), ('42', 'Mimoto.CMS_dashboard_Overview', 'MimotoCMS/components/pages/dashboard/Overview.twig', '2016-07-19 12:27:17'), ('43', 'Mimoto.CMS_entities_EntityOverview', 'MimotoCMS/components/pages/entities/EntityOverview/EntityOverview.twig', '2016-07-19 14:25:22'), ('44', 'Mimoto.CMS_entities_EntityListItem', 'MimotoCMS/components/pages/entities/EntityListItem/EntityListItem.twig', '2016-07-19 14:32:35'), ('45', 'Mimoto.CMS_entities_EntityDetail', 'MimotoCMS/components/pages/entities/EntityDetail/EntityDetail.twig', '2016-07-19 15:17:30'), ('46', 'Mimoto.CMS_entities_PropertyListItem', 'MimotoCMS/components/pages/entities/PropertyListItem/PropertyListItem.twig', '2016-07-19 17:12:38'), ('47', 'Mimoto.CMS_entities_FormEntity', 'MimotoCMS/components/pages/entities/FormEntity.twig', '2016-07-27 13:00:43'), ('48', 'Mimoto.CMS_entities_FormEntityProperty', 'MimotoCMS/components/pages/entities/FormEntityProperty.twig', '2016-07-27 16:40:35'), ('50', 'examplebase_form', 'examples/components/examplebase_form.twig', '2016-08-04 14:22:00'), ('51', '_MimotoAimless__interaction__form_output_title', 'MimotoCMS/components/forms/output/Title/Title.twig', '2016-08-10 16:29:20'), ('52', '_MimotoAimless__interaction__form_layout_groupstart', 'MimotoCMS/components/forms/layout/GroupStart/GroupStart.twig', '2016-08-10 17:37:30'), ('53', '_MimotoAimless__interaction__form_layout_groupend', 'MimotoCMS/components/forms/layout/GroupEnd/GroupEnd.twig', '2016-08-10 17:37:46'), ('54', '_MimotoAimless__interaction__form_input_textline', 'MimotoCMS/components/forms/input/Textline/Textline.twig', '2016-08-12 10:07:33'), ('55', '_MimotoAimless__interaction__form_input_checkbox', 'MimotoCMS/components/forms/input/Checkbox/Checkbox.twig', '2016-08-15 14:55:03'), ('56', '_MimotoAimless__interaction__form_input_radiobutton', 'MimotoCMS/components/forms/input/Radiobutton/Radiobutton.twig', '2016-08-15 14:55:26'), ('57', '_MimotoAimless__interaction__form_input_dropdown', 'MimotoCMS/components/forms/input/Dropdown/Dropdown.twig', '2016-08-15 15:00:10'), ('58', '_MimotoAimless__interaction__form_layout_divider', 'MimotoCMS/components/forms/layout/Divider/Divider.twig', '2016-08-15 18:16:16'), ('59', 'Mimoto.CMS_forms_Form', 'MimotoCMS/components/forms/Form.twig', '2016-08-17 12:33:35'), ('60', '_MimotoAimless__interaction__form_input_list', 'MimotoCMS/components/forms/input/List/List.twig', '2016-09-30 15:49:50'), ('61', '_MimotoAimless__interaction__form_input_image', 'MimotoCMS/components/forms/input/Image/Image.twig', '2016-09-30 15:50:53'), ('62', '_MimotoAimless__interaction__form_input_video', 'MimotoCMS/components/forms/input/Video/Video.twig', '2016-09-30 15:51:13'), ('100', 'faq_component', 'page/components/page_faq.html.twig', '2016-09-19 13:39:22'), ('101', 'page_faq', 'page/faq.html.twig', '2016-09-19 13:41:00'), ('102', 'projectManager', 'examples/components/ProjectManager/ProjectManager.twig', '2016-09-22 15:03:56'), ('103', 'Mimoto.CMS_forms_FormOverview', 'MimotoCMS/components/pages/forms/FormOverview/FormOverview.twig', '2016-10-15 12:42:57'), ('104', 'Mimoto.CMS_forms_FormListItem', 'MimotoCMS/components/pages/forms/FormListItem/FormListItem.twig', '2016-10-15 12:51:23'), ('105', 'Mimoto.CMS_forms_FormDetail', 'MimotoCMS/components/pages/forms/FormDetail/FormDetail.twig', '2016-10-15 14:00:34'), ('106', 'Mimoto.CMS_forms_FieldListItem', 'MimotoCMS/components/pages/forms/FieldListItem/FieldListItem.twig', '2016-10-15 14:02:14');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__view__componentconditional`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__view__componentconditional`;
CREATE TABLE `_MimotoAimless__view__componentconditional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `key` varchar(255) CHARACTER SET latin1 NOT NULL,
  `value` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__view__componentconditional`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__view__componentconditional` VALUES ('1', '11', 'type', 'regular', '2016-05-29 16:15:26'), ('2', '12', 'type', 'explainer', '2016-05-29 16:15:38'), ('3', '13', 'type', 'regular', '2016-05-29 16:57:43'), ('4', '14', 'type', 'explainer', '2016-05-29 16:58:00'), ('6', '30', 'phase', 'request', '2016-06-01 12:44:34'), ('7', '31', 'phase', 'currentproject', '2016-06-01 12:44:51'), ('8', '32', 'phase', 'archived', '2016-06-01 12:45:05');
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
--  Table structure for `author`
-- ----------------------------
DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `biography` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `author`
-- ----------------------------
BEGIN;
INSERT INTO `author` VALUES ('1', 'Sebastian', 'CTO', 'sebastian@decorrespondent.nl', 'Lorem ipsum', '2016-09-06 09:57:18');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `client`
-- ----------------------------
BEGIN;
INSERT INTO `client` VALUES ('1', 'VanMoof', '2016-02-17 09:57:06'), ('2', 'Bugaboo', '2016-02-22 17:54:20'), ('3', 'KNVB', '2016-02-22 17:54:29'), ('4', 'De Correspondent 17:32:26', '2016-03-04 22:41:00'), ('5', 'Respondens', '2016-03-04 22:41:11'), ('6', 'IDFA - Modified = 2016:08:31 12.07.38', '2016-08-25 16:01:53');
COMMIT;

-- ----------------------------
--  Table structure for `contact`
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `contact`
-- ----------------------------
BEGIN;
INSERT INTO `contact` VALUES ('1', 'Réne', 'rene@decorrespondent.nl', '06-12345678', '2016-08-25 12:50:38'), ('2', 'Gwen', 'gwen@decorrespondent.nl', '020-7654321', '2016-08-25 13:51:27');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `person`
-- ----------------------------
BEGIN;
INSERT INTO `person` VALUES ('1', 'Sebastian', 'Developer', '2016-08-10 13:54:04'), ('2', 'Bart', 'Developer (back-end)', '2016-08-10 14:04:01'), ('3', 'Alexander', 'DevOps', '2016-08-10 14:04:20'), ('4', 'Lode', 'Lead developer', '2016-08-22 14:11:44'), ('5', 'Heleen', 'Developer', '2016-08-22 14:11:53'), ('7', 'Jorrit', 'Developer (front-end)', '2016-08-22 14:12:37');
COMMIT;

-- ----------------------------
--  Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` text CHARACTER SET latin1,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `project`
-- ----------------------------
BEGIN;
INSERT INTO `project` VALUES ('1', 'Bugaboo.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2016-02-17 10:16:24'), ('2', 'VanMoof.com - 2016:09:06 15.10.38', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.', '2016-02-27 12:35:53'), ('3', 'Bugaboo GTS', 'Al ruim 15 jaar inspireert Bugaboo honderdduizenden ouders om eropuit te trekken en samen met hun kinderen de wereld te ontdekken. Tegenwoordig is het een vertrouwd straatbeeld: overal stoere, robuuste en tegelijk stijlvolle kinderwagens. Maar toen Max Barenbrug, nu Chief Design Officer bij Bugaboo, in 1994 zo\'n kinderwagen ontwierp voor zijn afstudeerproject aan de Design Academy in Eindhoven, was het de eerste in zijn soort. De modulaire, multifunctionele kinderwagen, die net zo makkelijk in de stad als in het bos of op het strand kon worden gebruikt, was destijds een compleet nieuw concept.', '2016-03-08 11:40:42');
COMMIT;

-- ----------------------------
--  Table structure for `projectManager`
-- ----------------------------
DROP TABLE IF EXISTS `projectManager`;
CREATE TABLE `projectManager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `projectManager`
-- ----------------------------
BEGIN;
INSERT INTO `projectManager` VALUES ('1', 'Ruben', '2016-02-25 13:40:24'), ('2', 'David', '2016-02-27 12:35:03'), ('3', 'Marloes', '2016-02-25 13:40:39'), ('4', 'RenÃ©', '2016-02-25 13:40:27');
COMMIT;

-- ----------------------------
--  Table structure for `subproject`
-- ----------------------------
DROP TABLE IF EXISTS `subproject`;
CREATE TABLE `subproject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `phase` enum('request','currentproject','archived') COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` enum('prospect','active','archived') COLLATE utf8_unicode_ci DEFAULT NULL,
  `probability` enum('0.1','0.5','0.9') COLLATE utf8_unicode_ci DEFAULT NULL,
  `budget` int(10) unsigned DEFAULT NULL,
  `paymentType` enum('time_material','fixed') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `subproject`
-- ----------------------------
BEGIN;
INSERT INTO `subproject` VALUES ('1', 'Specificatiefase', 'request', 'prospect', '0.1', '57850', 'time_material', '2016-02-27 18:02:19'), ('2', 'In-store visuals', 'archived', 'prospect', '0.9', '15000', 'fixed', '2016-02-27 18:03:11'), ('3', 'Concept design', 'currentproject', 'active', '0.9', '25000', 'time_material', '2016-02-27 18:04:57'), ('4', 'Concept phase', 'request', 'archived', '0.5', '43000', 'time_material', '2016-03-02 14:53:37'), ('5', 'Technical realisation', 'currentproject', 'active', '0.1', '60000', 'time_material', '2016-06-01 12:55:01');
COMMIT;

-- ----------------------------
--  Table structure for `subprojectState`
-- ----------------------------
DROP TABLE IF EXISTS `subprojectState`;
CREATE TABLE `subprojectState` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
