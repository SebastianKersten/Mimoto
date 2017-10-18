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

 Date: 18/10/2017 17:34:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for _Mimoto_action
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_action`;
CREATE TABLE `_Mimoto_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=717 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
-- Table structure for _Mimoto_form_input_image
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_form_input_image`;
CREATE TABLE `_Mimoto_form_input_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_output
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_output`;
CREATE TABLE `_Mimoto_output` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isRoot` enum('0','1') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

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
-- Table structure for _Mimoto_route
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_route`;
CREATE TABLE `_Mimoto_route` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
-- Table structure for _Mimoto_selection
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_selection`;
CREATE TABLE `_Mimoto_selection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for _Mimoto_service
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_service`;
CREATE TABLE `_Mimoto_service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
-- Table structure for _Mimoto_user_role
-- ----------------------------
DROP TABLE IF EXISTS `_Mimoto_user_role`;
CREATE TABLE `_Mimoto_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
