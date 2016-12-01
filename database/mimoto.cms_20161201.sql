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

 Date: 12/01/2016 13:54:43 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=20042 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__connections__core`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__connections__core` VALUES ('1', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1', '_MimotoAimless__core__entityproperty', '1', '0'), ('2', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1', '_MimotoAimless__core__entityproperty', '2', '1'), ('3', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--extends', '3', '_MimotoAimless__core__entity', '4', '2'), ('4', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entityproperty', '3', '0'), ('5', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entityproperty', '4', '1'), ('6', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entityproperty', '5', '2'), ('7', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entityproperty', '6', '3'), ('50', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '3', '_MimotoAimless__core__entityproperty', '50', '0'), ('51', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '50', '_MimotoAimless__core__entitypropertysetting', '50', '0'), ('60', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '4', '_MimotoAimless__core__entityproperty', '60', '0'), ('61', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '60', '_MimotoAimless__core__entitypropertysetting', '60', '0'), ('70', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--extends', '4', '_MimotoAimless__core__entity', '1', '0'), ('201', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1', '_MimotoAimless__core__entitypropertysetting', '1', '0'), ('202', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '2', '_MimotoAimless__core__entitypropertysetting', '2', '1'), ('203', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '3', '_MimotoAimless__core__entitypropertysetting', '3', '0'), ('204', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '4', '_MimotoAimless__core__entitypropertysetting', '4', '1'), ('205', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '5', '_MimotoAimless__core__entitypropertysetting', '5', '2'), ('206', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '6', '_MimotoAimless__core__entitypropertysetting', '6', '3'), ('1001', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1001', '0'), ('1002', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1002', '1'), ('1003', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1003', '2'), ('1004', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1004', '3'), ('1005', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1005', '4'), ('1006', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1000', '_MimotoAimless__core__entityproperty', '1006', '5'), ('1101', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1101', '0'), ('1102', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1102', '1'), ('1103', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1103', '2'), ('1104', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1104', '3'), ('1105', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1105', '4'), ('1106', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1106', '5'), ('1107', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1100', '_MimotoAimless__core__entityproperty', '1107', '6'), ('1201', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1200', '_MimotoAimless__core__entityproperty', '1201', '0'), ('1301', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1300', '_MimotoAimless__core__entityproperty', '1301', '0'), ('1401', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1400', '_MimotoAimless__core__entityproperty', '1401', '0'), ('1501', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1500', '_MimotoAimless__core__entityproperty', '1501', '0'), ('1601', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1600', '_MimotoAimless__core__entityproperty', '1601', '0'), ('1602', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1600', '_MimotoAimless__core__entityproperty', '1602', '1'), ('1603', '_MimotoAimless__core__entity', '_MimotoAimless__core__entity--properties', '1600', '_MimotoAimless__core__entityproperty', '1603', '2'), ('2001', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1001', '_MimotoAimless__core__entitypropertysetting', '1001', '0'), ('2002', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1002', '_MimotoAimless__core__entitypropertysetting', '1002', '0'), ('2003', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1003', '_MimotoAimless__core__entitypropertysetting', '1003', '0'), ('2004', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1004', '_MimotoAimless__core__entitypropertysetting', '1004', '0'), ('2005', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1005', '_MimotoAimless__core__entitypropertysetting', '1005', '0'), ('2006', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1006', '_MimotoAimless__core__entitypropertysetting', '1006', '0'), ('2007', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1006', '_MimotoAimless__core__entitypropertysetting', '1007', '1'), ('2010', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_image', '1', '9'), ('2011', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_video', '1', '10'), ('2101', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1101', '_MimotoAimless__core__entitypropertysetting', '1101', '0'), ('2102', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1102', '_MimotoAimless__core__entitypropertysetting', '1102', '0'), ('2103', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1103', '_MimotoAimless__core__entitypropertysetting', '1103', '0'), ('2104', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1104', '_MimotoAimless__core__entitypropertysetting', '1104', '0'), ('2105', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1105', '_MimotoAimless__core__entitypropertysetting', '1105', '0'), ('2106', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1106', '_MimotoAimless__core__entitypropertysetting', '1106', '0'), ('2107', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1107', '_MimotoAimless__core__entitypropertysetting', '1107', '0'), ('2201', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1201', '_MimotoAimless__core__entitypropertysetting', '1201', '0'), ('2301', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1301', '_MimotoAimless__core__entitypropertysetting', '1301', '0'), ('2401', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1401', '_MimotoAimless__core__entitypropertysetting', '1401', '0'), ('2501', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1501', '_MimotoAimless__core__entitypropertysetting', '1501', '0'), ('2601', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1601', '_MimotoAimless__core__entitypropertysetting', '1601', '0'), ('2602', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1602', '_MimotoAimless__core__entitypropertysetting', '1602', '0'), ('2603', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entity--properties', '1603', '_MimotoAimless__core__entitypropertysetting', '1603', '0'), ('5001', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_output_title', '1', '0'), ('5002', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_layout_groupstart', '1', '1'), ('5003', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_textline', '1', '2'), ('5004', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_layout_divider', '1', '3'), ('5005', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_textline', '2', '4'), ('5006', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_checkbox', '1', '5'), ('5007', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_dropdown', '1', '6'), ('5008', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_radiobutton', '1', '7'), ('5009', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_input_list', '1', '8'), ('5012', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '2', '_MimotoAimless__interaction__form_layout_groupend', '1', '11'), ('6001', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_output_title', '3', '0'), ('6002', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_layout_groupstart', '3', '1'), ('6003', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_input_textline', '3', '2'), ('6004', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_input_textline', '4', '3'), ('6005', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '3', '_MimotoAimless__interaction__form_layout_groupend', '3', '4'), ('7000', '_MimotoAimless__interaction__form_input_textline', '_MimotoAimless__interaction__forminput--value', '3', '_MimotoAimless__interaction__forminputvalue', '1', '0'), ('7010', '_MimotoAimless__interaction__form_input_textline', '_MimotoAimless__interaction__forminput--value', '4', '_MimotoAimless__interaction__forminputvalue', '2', '0'), ('7011', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--entityproperty', '1', '_MimotoAimless__core__entityproperty', '1201', '0'), ('8000', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_output_title', '50', '0'), ('8001', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_layout_groupstart', '50', '1'), ('8002', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_input_textline', '50', '2'), ('8003', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_input_radiobutton', '50', '3'), ('8004', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_input_dropdown', '50', '4'), ('8005', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_input_textline', '51', '5'), ('8006', '_MimotoAimless__interaction__form', '_MimotoAimless__interaction__form--fields', '50', '_MimotoAimless__interaction__form_layout_groupend', '50', '6'), ('8010', '_MimotoAimless__interaction__form_input_textline', '_MimotoAimless__interaction__forminput--value', '50', '_MimotoAimless__interaction__forminputvalue', '150', '0'), ('8011', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--entityproperty', '150', '_MimotoAimless__core__entityproperty', '1001', '0'), ('8020', '_MimotoAimless__interaction__form_input_radiobutton', '_MimotoAimless__interaction__forminput--value', '50', '_MimotoAimless__interaction__forminputvalue', '152', '0'), ('8021', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--entityproperty', '152', '_MimotoAimless__core__entityproperty', '1103', '0'), ('8030', '_MimotoAimless__interaction__form_input_textline', '_MimotoAimless__interaction__forminput--value', '51', '_MimotoAimless__interaction__forminputvalue', '151', '0'), ('8031', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--entityproperty', '151', '_MimotoAimless__core__entityproperty', '1002', '0'), ('8040', '_MimotoAimless__interaction__form_input_dropdown', '_MimotoAimless__interaction__forminput--value', '50', '_MimotoAimless__interaction__forminputvalue', '153', '0'), ('8041', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--entityproperty', '153', '_MimotoAimless__core__entityproperty', '1107', '0'), ('9001', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--options', '152', '_MimotoAimless__interaction__forminputvaluesetting', '1', '0'), ('9002', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--options', '152', '_MimotoAimless__interaction__forminputvaluesetting', '2', '1'), ('9003', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--options', '152', '_MimotoAimless__interaction__forminputvaluesetting', '3', '2'), ('9011', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--validation', '152', '_MimotoAimless__interaction__forminputvaluevalidation', '1', '0'), ('9012', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--validation', '152', '_MimotoAimless__interaction__forminputvaluevalidation', '2', '1'), ('9040', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--options', '153', '_MimotoAimless__interaction__forminputvaluesetting', '10', '0'), ('9041', '_MimotoAimless__interaction__forminputvalue', '_MimotoAimless__interaction__forminputvalue--options', '153', '_MimotoAimless__interaction__forminputvaluesetting', '11', '1'), ('10000', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1', '_MimotoAimless__core__entitypropertysetting', '1', '0'), ('10001', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '2', '_MimotoAimless__core__entitypropertysetting', '2', '0'), ('10002', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '3', '_MimotoAimless__core__entitypropertysetting', '3', '0'), ('10003', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '4', '_MimotoAimless__core__entitypropertysetting', '4', '0'), ('10004', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '5', '_MimotoAimless__core__entitypropertysetting', '5', '0'), ('10005', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '6', '_MimotoAimless__core__entitypropertysetting', '6', '0'), ('10006', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '50', '_MimotoAimless__core__entitypropertysetting', '50', '0'), ('10007', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '60', '_MimotoAimless__core__entitypropertysetting', '60', '0'), ('10008', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1001', '_MimotoAimless__core__entitypropertysetting', '1001', '0'), ('10009', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1002', '_MimotoAimless__core__entitypropertysetting', '1002', '0'), ('10010', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1003', '_MimotoAimless__core__entitypropertysetting', '1003', '0'), ('10011', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1004', '_MimotoAimless__core__entitypropertysetting', '1004', '0'), ('10012', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1005', '_MimotoAimless__core__entitypropertysetting', '1005', '0'), ('10013', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1006', '_MimotoAimless__core__entitypropertysetting', '1006', '0'), ('10014', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1006', '_MimotoAimless__core__entitypropertysetting', '1007', '1'), ('10015', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1101', '_MimotoAimless__core__entitypropertysetting', '1101', '0'), ('10016', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1102', '_MimotoAimless__core__entitypropertysetting', '1102', '0'), ('10017', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1103', '_MimotoAimless__core__entitypropertysetting', '1103', '0'), ('10018', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1104', '_MimotoAimless__core__entitypropertysetting', '1104', '0'), ('10019', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1105', '_MimotoAimless__core__entitypropertysetting', '1105', '0'), ('10020', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1106', '_MimotoAimless__core__entitypropertysetting', '1106', '0'), ('10021', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1107', '_MimotoAimless__core__entitypropertysetting', '1107', '0'), ('10022', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1201', '_MimotoAimless__core__entitypropertysetting', '1201', '0'), ('10023', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1301', '_MimotoAimless__core__entitypropertysetting', '1301', '0'), ('10024', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1401', '_MimotoAimless__core__entitypropertysetting', '1401', '0'), ('10025', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1501', '_MimotoAimless__core__entitypropertysetting', '1501', '0'), ('10026', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1601', '_MimotoAimless__core__entitypropertysetting', '1601', '0'), ('10027', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1602', '_MimotoAimless__core__entitypropertysetting', '1602', '0'), ('10028', '_MimotoAimless__core__entityproperty', '_MimotoAimless__core__entityproperty--settings', '1603', '_MimotoAimless__core__entitypropertysetting', '1603', '0'), ('20000', '_MimotoAimless__core__entitypropertysetting', '_MimotoAimless__core__entitypropertysetting--allowedEntityType', '1003', '_MimotoAimless__core__entity', '1200', '0'), ('20001', '_MimotoAimless__core__entitypropertysetting', '_MimotoAimless__core__entitypropertysetting--allowedEntityType', '1004', '_MimotoAimless__core__entity', '1300', '0'), ('20002', '_MimotoAimless__core__entitypropertysetting', '_MimotoAimless__core__entitypropertysetting--allowedEntityType', '1005', '_MimotoAimless__core__entity', '1400', '0'), ('20003', '_MimotoAimless__core__entitypropertysetting', '_MimotoAimless__core__entitypropertysetting--allowedEntityTypes', '1006', '_MimotoAimless__core__entity', '1100', '0'), ('20004', '_MimotoAimless__core__entitypropertysetting', '_MimotoAimless__core__entitypropertysetting--allowedEntityType', '1102', '_MimotoAimless__core__entity', '1600', '0');
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
) ENGINE=InnoDB AUTO_INCREMENT=1416 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__connections__project`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__connections__project` VALUES ('1', '1000', '1006', '3', '1100', '1', '0'), ('2', '1000', '1006', '3', '1100', '2', '1'), ('3', '1000', '1006', '3', '1100', '3', '2'), ('4', '1000', '1006', '2', '1100', '4', '0'), ('100', '1100', '1102', '1', '1600', '2', '0'), ('1414', '1000', '1005', '2', '1400', '2', null);
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__core__entity`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__core__entity`;
CREATE TABLE `_MimotoAimless__core__entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `isAbstract` enum('0','1') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1619 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_MimotoAimless__core__entity`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__core__entity` VALUES ('1', 'person', null, '2016-07-29 14:13:46'), ('2', 'article', null, '2016-08-17 11:16:09'), ('3', 'author', null, '2016-08-22 10:30:30'), ('4', 'member', '1', '2016-09-05 13:21:11'), ('1000', 'project', null, '2016-08-24 13:46:00'), ('1100', 'subproject', null, '2016-08-24 13:49:31'), ('1200', 'client', null, '2016-08-24 13:49:16'), ('1300', 'agency', null, '2016-08-24 13:53:03'), ('1400', 'projectManager', null, '2016-08-24 13:53:13'), ('1500', 'subprojectState', null, '2016-08-24 13:53:54'), ('1600', 'contact', null, '2016-08-24 14:10:20'), ('1601', 'test', null, '2016-11-15 14:44:42'), ('1616', 'test567', null, '2016-11-20 13:33:20'), ('1617', 'test432', null, '2016-11-20 13:34:04'), ('1618', 'test80', null, '2016-11-20 13:36:01');
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
) ENGINE=InnoDB AUTO_INCREMENT=1607 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__core__entityproperty`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__core__entityproperty` VALUES ('1', 'name', 'value', '2016-07-27 12:24:53'), ('2', 'role', 'value', '2016-07-27 16:45:01'), ('3', 'type', 'value', '2016-08-17 11:16:38'), ('4', 'title', 'value', '2016-08-17 11:16:49'), ('5', 'lede', 'value', '2016-08-17 11:16:57'), ('6', 'body', 'value', '2016-08-17 11:17:09'), ('50', 'biography', 'value', '2016-09-05 10:05:45'), ('60', 'email', 'value', '2016-09-05 13:22:07'), ('1001', 'name', 'value', '2016-08-24 13:46:39'), ('1002', 'description', 'value', '2016-08-24 13:46:51'), ('1003', 'client', 'entity', '2016-08-24 13:47:45'), ('1004', 'agency', 'entity', '2016-08-24 13:47:54'), ('1005', 'projectManager', 'entity', '2016-08-24 13:48:17'), ('1006', 'subprojects', 'collection', '2016-08-25 11:44:24'), ('1101', 'name', 'value', '2016-08-24 13:56:05'), ('1102', 'contact', 'entity', '2016-08-24 13:56:25'), ('1103', 'phase', 'value', '2016-08-24 13:57:06'), ('1104', 'state', 'value', '2016-08-24 13:57:16'), ('1105', 'probability', 'value', '2016-08-24 13:57:26'), ('1106', 'budget', 'value', '2016-08-24 13:57:40'), ('1107', 'paymentType', 'value', '2016-08-24 13:57:55'), ('1201', 'name', 'value', '2016-08-24 13:55:17'), ('1301', 'name', 'value', '2016-08-24 13:55:28'), ('1401', 'name', 'value', '2016-08-24 13:55:37'), ('1501', 'name', 'value', '2016-08-24 13:55:46'), ('1601', 'name', 'value', '2016-08-24 14:10:33'), ('1602', 'email', 'value', '2016-08-24 14:11:23'), ('1603', 'phoneNumber', 'value', '2016-08-24 14:11:36'), ('1604', '', null, '2016-11-16 17:39:29'), ('1605', '', null, '2016-11-16 17:43:17'), ('1606', null, 'collection', '2016-11-20 13:27:36');
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
INSERT INTO `_MimotoAimless__core__entitypropertysetting` VALUES ('1', 'type', 'text', 'textline', '2016-08-10 13:54:51'), ('2', 'type', 'text', 'textline', '2016-08-10 13:55:02'), ('3', 'type', 'text', 'textline', '2016-08-17 11:18:40'), ('4', 'type', 'text', 'textline', '2016-08-17 11:18:51'), ('5', 'type', 'text', 'textblock', '2016-08-17 11:19:32'), ('6', 'type', 'text', 'textblock', '2016-08-17 11:19:41'), ('50', 'type', 'text', 'textblock', '2016-09-05 10:06:01'), ('60', 'type', 'text', 'textline', '2016-09-05 13:22:24'), ('1001', 'type', 'text', 'textline', '2016-08-24 14:07:44'), ('1002', 'type', 'text', 'textblock', '2016-08-24 14:07:56'), ('1003', 'allowedEntityType', '', '', '2016-08-24 14:08:43'), ('1004', 'allowedEntityType', '', '', '2016-08-24 14:09:03'), ('1005', 'allowedEntityType', '', '', '2016-08-24 14:09:17'), ('1006', 'allowedEntityTypes', '', '', '2016-08-25 11:45:26'), ('1007', 'allowDuplicates', 'boolean', 'false', '2016-08-25 11:45:55'), ('1101', 'type', 'text', 'textline', '2016-08-24 14:09:39'), ('1102', 'allowedEntityType', '', '', '2016-08-24 14:10:03'), ('1103', 'type', 'text', 'textline', '2016-08-24 14:13:21'), ('1104', 'type', 'text', 'textline', '2016-08-24 14:13:17'), ('1105', 'type', 'text', 'textline', '2016-08-24 14:13:32'), ('1106', 'type', 'text', 'textline', '2016-08-24 14:13:42'), ('1107', 'type', 'text', 'textline', '2016-08-24 14:13:51'), ('1201', 'type', 'text', 'textline', '2016-08-24 14:14:01'), ('1301', 'type', 'text', 'textline', '2016-08-24 14:14:48'), ('1401', 'type', 'text', 'textline', '2016-08-24 14:14:51'), ('1501', 'type', 'text', 'textline', '2016-08-24 14:14:53'), ('1601', 'type', 'text', 'textline', '2016-08-24 14:14:55'), ('1602', 'type', 'text', 'textline', '2016-08-24 14:14:58'), ('1603', 'type', 'text', 'textline', '2016-08-24 14:15:00');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__devtools__notification`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__devtools__notification`;
CREATE TABLE `_MimotoAimless__devtools__notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispatcher` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__devtools__notification`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__devtools__notification` VALUES ('1', 'Rendering an entity with a component', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:21:50'), ('2', 'Rendering an entity with a component', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:29:13'), ('3', 'Rendering an entity with a component', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:29:24'), ('4', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:32:22'), ('5', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:32:27'), ('6', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:32:38'), ('7', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:32:40'), ('8', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:40:04'), ('9', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:40:11'), ('10', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:40:18'), ('11', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:40:46'), ('12', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:41:39'), ('13', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:41:44'), ('14', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:43:02'), ('15', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:43:16'), ('16', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:54:24'), ('17', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:54:32'), ('18', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 11:54:35'), ('19', 'Missing component while rendering entity-property', 'The property <b>projectManager</b> you are trying to render doens\'t have a component connected to it.', 'silent', 'Mimoto\\Aimless\\AimlessComponent::renderEntityProperty (called from line #199)', 'closed', '2016-11-29 20:06:29'), ('20', 'Incorrect value', 'The property subprojects only allows \'1100\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #194)', 'closed', '2016-11-29 20:31:09'), ('21', 'Incorrect value', 'The property projectManager only allows \'projectManager\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #80)', 'closed', '2016-11-29 20:38:32'), ('22', 'Incorrect value', 'The property projectManager only allows \'projectManager\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #80)', 'closed', '2016-11-29 20:39:25'), ('23', 'Incorrect value', 'The property subprojects only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #102)', 'closed', '2016-11-29 20:39:40'), ('24', 'Incorrect value', 'The property subprojects only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #102)', 'closed', '2016-11-29 20:40:35'), ('25', 'Incorrect value', 'The property subprojects only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #102)', 'closed', '2016-11-29 20:40:55'), ('26', 'Incorrect value', 'The property subprojects only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #102)', 'closed', '2016-11-29 20:40:57'), ('27', 'Incorrect value', 'The property subprojects only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #102)', 'closed', '2016-11-29 20:42:48'), ('28', 'Incorrect value', 'The property subprojects only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #102)', 'closed', '2016-11-29 20:42:49'), ('29', 'Incorrect value', 'The property subprojects only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #102)', 'closed', '2016-11-29 20:43:14'), ('30', 'Incorrect value', 'The property subprojects only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #188)', 'closed', '2016-11-29 20:44:43'), ('31', 'Incorrect value', 'The property subprojects only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #188)', 'closed', '2016-11-29 20:44:48'), ('32', 'Incorrect value', 'The property subprojects only allows \'subproject\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #185)', 'closed', '2016-11-29 20:46:34'), ('33', 'Incorrect value', 'The property subprojects only allows \'subproject\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #185)', 'closed', '2016-11-29 20:46:41'), ('34', 'Incorrect value', 'The property subprojects only allows \'subproject\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #185)', 'closed', '2016-11-29 22:21:54'), ('35', 'Incorrect value', 'The property fields only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #99)', 'closed', '2016-11-29 22:50:24'), ('36', 'No such property', 'The property <b>projectManager</b> you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #211)', 'closed', '2016-11-30 12:49:37'), ('37', 'No such property', 'The property <b>projectManager</b> you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #211)', 'closed', '2016-11-30 12:57:46'), ('38', 'No such property', 'The property <b>projectManager</b> you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #211)', 'closed', '2016-11-30 13:02:04'), ('39', 'No such property', 'The property <b>projectManager</b> you are looking for doesn\'t seem to be here', 'error', 'Mimoto\\Data\\MimotoEntity::getProperty (called from line #211)', 'closed', '2016-11-30 13:03:52'), ('40', 'Incorrect value', 'The property fields only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #117)', 'closed', '2016-11-30 13:21:59'), ('41', 'Incorrect value', 'Please set a child id for the connection you are trying to set for property projectManager', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #109)', 'closed', '2016-11-30 13:26:27'), ('42', 'Incorrect value', 'Please set a child id for the connection you are trying to set for property projectManager', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #109)', 'closed', '2016-11-30 13:29:28'), ('43', 'Incorrect value', 'Please set a child id for the connection you are trying to set for property projectManager', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #109)', 'closed', '2016-11-30 13:30:09'), ('44', 'Silent notice', 'The configuration is missing a paramater, but we\'ll do without for now', 'silent', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm4', 'closed', '2016-11-30 18:21:52'), ('45', 'Silent notice', 'The configuration is missing a paramater, but we\'ll do without for now', 'silent', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm4', 'closed', '2016-11-30 18:22:02'), ('46', 'Silent notice', 'The configuration is missing a paramater, but we\'ll do without for now', 'silent', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm4', 'closed', '2016-11-30 18:22:03'), ('47', 'Silent notice', 'The configuration is missing a paramater, but we\'ll do without for now', 'silent', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm4', 'closed', '2016-11-30 18:22:04'), ('48', 'Incorrect value', 'The property properties only allows \'_MimotoAimless__core__entity\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #117)', 'closed', '2016-12-01 12:46:08'), ('49', 'Incorrect value', 'The property properties only allows \'_MimotoAimless__core__entity\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #117)', 'closed', '2016-12-01 12:47:09'), ('50', 'Incorrect value', 'The property \'properties\' only allows \'_MimotoAimless__core__entity\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #117)', 'closed', '2016-12-01 12:52:05'), ('51', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:52'), ('52', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:52'), ('53', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:52'), ('54', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:52'), ('55', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:52'), ('56', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:52'), ('57', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:52'), ('58', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:52'), ('59', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:53'), ('60', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:53'), ('61', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:53'), ('62', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:53'), ('63', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:53'), ('64', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:53'), ('65', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:52:53'), ('66', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('67', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('68', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('69', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('70', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('71', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('72', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('73', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('74', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('75', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('76', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('77', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('78', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('79', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('80', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:24'), ('81', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('82', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('83', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('84', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('85', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('86', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('87', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('88', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('89', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('90', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('91', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('92', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('93', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('94', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('95', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:27'), ('96', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('97', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('98', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('99', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('100', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('101', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('102', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('103', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('104', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('105', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('106', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('107', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('108', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('109', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('110', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:49'), ('111', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:53:54'), ('112', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:54:01'), ('113', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:54:01'), ('114', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:54:01'), ('115', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:54:01'), ('116', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 12:54:01'), ('117', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:19'), ('118', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:20'), ('119', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:20'), ('120', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:20'), ('121', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:20'), ('122', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:35'), ('123', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:35'), ('124', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:35'), ('125', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:35'), ('126', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:35'), ('127', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:37'), ('128', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:38'), ('129', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:38'), ('130', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:38'), ('131', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:04:38'), ('132', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:05:58'), ('133', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:05:59'), ('134', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:05:59'), ('135', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:05:59'), ('136', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:05:59'), ('137', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:07:01'), ('138', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:07:01'), ('139', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:07:01'), ('140', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:07:01'), ('141', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:07:01'), ('142', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:49'), ('143', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:49'), ('144', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('145', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('146', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('147', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('148', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('149', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('150', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('151', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('152', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('153', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('154', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('155', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('156', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:10:50'), ('157', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('158', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('159', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('160', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('161', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('162', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('163', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('164', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('165', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('166', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('167', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('168', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('169', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('170', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('171', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:11:40'), ('172', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('173', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('174', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('175', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('176', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('177', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('178', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('179', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('180', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('181', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('182', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:15'), ('183', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:16'), ('184', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:16'), ('185', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:16'), ('186', 'Incorrect value', 'The property <b>isAbstract</b> only allows values of type boolean', 'warning', 'Mimoto\\Data\\MimotoEntityProperty_Value::setValue (called from line #263)', 'closed', '2016-12-01 13:12:16'), ('187', 'Silent notice', 'The configuration is missing a paramater, but we\'ll do without for now', 'silent', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm4', 'closed', '2016-12-01 13:50:48'), ('188', 'Incorrect value', 'The property \'fields\' only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #160)', 'closed', '2016-12-01 13:50:48'), ('189', 'Incorrect value', 'The property \'fields\' only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #160)', 'closed', '2016-12-01 13:53:09'), ('190', 'Incorrect value', 'The property \'fields\' only allows \'\'', 'error', 'Mimoto\\Data\\MimotoDataUtils::createConnection (called from line #160)', 'closed', '2016-12-01 13:53:23');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form`;
CREATE TABLE `_MimotoAimless__interaction__form` (
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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form` VALUES ('2', 'form_person', 'Test', null, null, null, null, null, '2016-08-10 14:29:42'), ('3', 'client', 'A simple form to add and edit clients', null, null, null, null, null, '2016-06-27 14:06:17'), ('50', 'project', 'Altering a form', null, null, null, null, null, '2016-10-09 16:51:40');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_checkbox`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_checkbox`;
CREATE TABLE `_MimotoAimless__interaction__form_input_checkbox` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `option` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_checkbox`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_checkbox` VALUES ('1', 'State', null, 'Person is currently active on the project', '2016-08-15 13:47:47');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_dropdown`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_dropdown`;
CREATE TABLE `_MimotoAimless__interaction__form_input_dropdown` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_dropdown`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_dropdown` VALUES ('50', 'Project type', 'What type of invoicing', '2016-08-15 13:49:42');
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__form_input_textline`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__form_input_textline` VALUES ('1', 'Name', null, null, 'false', '/[a-zA-Z09-]/', '10', '2016-08-10 16:13:50'), ('2', 'Role', null, null, 'false', null, null, '2016-08-12 10:24:05'), ('3', 'Name', 'This field is connected to an entity\'s property', 'Enter the client\'s name', 'true', '/[a-zA-Z09-]/', '10', '2016-10-02 13:08:25'), ('4', 'Custom var', 'Dit is een custom var', 'Enter the value of this custom var', 'false', null, null, '2016-10-09 15:25:54'), ('50', 'Name', 'The project\'s name', 'Enter a name', 'false', null, null, '2016-10-09 16:56:43'), ('51', 'Description', 'The project\'s description', 'Enter a description', 'false', null, null, '2016-10-09 16:57:38');
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
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__forminputvalue`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__forminputvalue` VALUES ('1', 'entityproperty', '', null, '2016-10-07 10:27:06'), ('2', 'varname', 'xxxxxxx', null, '2016-10-09 15:26:17'), ('150', 'entityproperty', null, null, '2016-10-09 16:58:52'), ('151', 'entityproperty', null, null, '2016-10-09 16:59:01'), ('152', 'entityproperty', '', null, '2016-10-12 21:44:13'), ('153', 'entityproperty', null, null, '2016-10-18 00:12:06');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__forminputvaluerules`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__forminputvaluerules`;
CREATE TABLE `_MimotoAimless__interaction__forminputvaluerules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__forminputvaluerules`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__forminputvaluerules` VALUES ('1', 'request', 'Aanvraag', '2016-10-16 21:16:31'), ('2', 'currentproject', 'Lopend project', '2016-10-16 21:16:43'), ('3', 'archived', 'Archief', '2016-10-16 21:16:53'), ('10', 'time_material', 'Time & material', '2016-10-18 00:12:25'), ('11', 'fixed', 'Fixed price', '2016-10-18 00:12:49');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__forminputvaluesetting`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__forminputvaluesetting` VALUES ('1', 'request', 'Aanvraag', '2016-10-16 21:16:31'), ('2', 'currentproject', 'Lopend project', '2016-10-16 21:16:43'), ('3', 'archived', 'Archief', '2016-10-16 21:16:53'), ('10', 'time_material', 'Time & material', '2016-10-18 00:12:25'), ('11', 'fixed', 'Fixed price', '2016-10-18 00:12:49');
COMMIT;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__forminputvaluevalidation`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__forminputvaluevalidation`;
CREATE TABLE `_MimotoAimless__interaction__forminputvaluevalidation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `errorMessage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `_MimotoAimless__interaction__forminputvaluevalidation`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__interaction__forminputvaluevalidation` VALUES ('1', 'maxchars', '10', null, '2016-10-16 21:16:31'), ('2', 'regex_custom', '/^[a-zA-Z0-9]*$/', null, '2016-10-16 21:16:43');
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
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `_MimotoAimless__view__component`
-- ----------------------------
BEGIN;
INSERT INTO `_MimotoAimless__view__component` VALUES ('8', 'article', 'examples/components/Article.twig', '2016-05-25 16:54:30'), ('9', 'feed', 'examples/components/Feed.twig', '2016-05-29 15:57:53'), ('10', 'feeditem', 'examples/components/FeedItem1.twig', '2016-05-29 15:58:21'), ('11', 'article_type', 'examples/components/ArticleRegular.twig', '2016-05-29 16:03:28'), ('12', 'article_type', 'examples/components/ArticleExplainer.twig', '2016-05-29 16:03:56'), ('13', 'feeditem_type', 'examples/components/FeedItem1.twig', '2016-05-29 16:56:41'), ('14', 'feeditem_type', 'examples/components/FeedItem2.twig', '2016-05-29 16:57:07'), ('15', 'article_overview', 'examples/components/ArticleOverview.twig', '2016-05-29 17:20:28'), ('26', 'project_withsubprojects', 'examples/components/ProjectWithSubprojects.twig', '2016-05-31 21:48:05'), ('27', 'project_withsubprojects_phase', 'examples/components/ProjectWithSubprojectsPhase.twig', '2016-05-31 21:50:11'), ('28', 'project_withsubprojects_filter', 'examples/components/ProjectWithSubprojectsFilter.twig', '2016-05-31 21:53:49'), ('29', 'subproject', 'examples/components/Subproject.twig', '2016-05-31 22:10:10'), ('30', 'subproject_phase', 'examples/components/Subproject.twig', '2016-05-31 22:10:43'), ('31', 'subproject_phase', 'examples/components/SubprojectActive.twig', '2016-06-01 12:44:08'), ('32', 'subproject_phase', 'examples/components/SubprojectArchived.twig', '2016-06-01 12:45:44'), ('39', 'subproject_overview', 'examples/components/SubprojectOverview.twig', '2016-06-13 11:46:46'), ('40', 'subproject_examplelistitem', 'examples/components/SubprojectListItem.twig', '2016-06-13 11:47:15'), ('50', 'examplebase_form', 'examples/components/examplebase_form.twig', '2016-08-04 14:22:00'), ('102', 'projectManager', 'examples/components/ProjectManager/ProjectManager.twig', '2016-09-22 15:03:56'), ('103', 'client_overview', 'examples/components/ClientOverview.twig', '2016-11-26 10:21:06'), ('104', 'client_listitem', 'examples/components/ListItemComponent.twig', '2016-11-26 10:22:29'), ('105', 'examples_overview', 'examples/components/ExamplesOverview/ExamplesOverview.twig', '2016-11-28 16:52:56');
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `client`
-- ----------------------------
BEGIN;
INSERT INTO `client` VALUES ('1', 'VanMoof', '2016-02-17 09:57:06'), ('2', 'Bugaboo', '2016-02-22 17:54:20'), ('3', 'KNVB', '2016-02-22 17:54:29'), ('4', 'De Correspondent 17:32:26', '2016-03-04 22:41:00'), ('5', 'Respondens', '2016-03-04 22:41:11'), ('6', 'IDFA - Modified = 2016:12:01 13.50.57', '2016-08-25 16:01:53'), ('15', 'New client', '2016-11-29 22:25:21'), ('16', 'New client', '2016-11-30 13:21:44'), ('17', 'New client', '2016-12-01 13:50:58');
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
INSERT INTO `project` VALUES ('1', 'Bugaboo.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2016-02-17 10:16:24'), ('2', 'VanMoof.com - 2016:12:01 13.50.59', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.', '2016-02-27 12:35:53'), ('3', 'Bugaboo GTS', 'Al ruim 15 jaar inspireert Bugaboo honderdduizenden ouders om eropuit te trekken en samen met hun kinderen de wereld te ontdekken. Tegenwoordig is het een vertrouwd straatbeeld: overal stoere, robuuste en tegelijk stijlvolle kinderwagens. Maar toen Max Barenbrug, nu Chief Design Officer bij Bugaboo, in 1994 zo\'n kinderwagen ontwierp voor zijn afstudeerproject aan de Design Academy in Eindhoven, was het de eerste in zijn soort. De modulaire, multifunctionele kinderwagen, die net zo makkelijk in de stad als in het bos of op het strand kon worden gebruikt, was destijds een compleet nieuw concept.', '2016-03-08 11:40:42');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `subproject`
-- ----------------------------
BEGIN;
INSERT INTO `subproject` VALUES ('1', 'Specificatiefase', 'request', 'prospect', '0.1', '57850', 'time_material', '2016-02-27 18:02:19'), ('2', 'In-store visuals', 'archived', 'prospect', '0.9', '15000', 'fixed', '2016-02-27 18:03:11'), ('3', 'Concept design', 'currentproject', 'active', '0.9', '25000', 'time_material', '2016-02-27 18:04:57'), ('4', 'Concept phase', 'request', 'archived', '0.5', '43000', 'time_material', '2016-03-02 14:53:37'), ('5', 'Technical realisation', 'archived', 'active', '0.1', '60000', 'fixed', '2016-06-01 12:55:01'), ('6', 'Partnership', 'currentproject', 'active', '0.9', '100000', 'time_material', '2016-11-29 10:43:20');
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
