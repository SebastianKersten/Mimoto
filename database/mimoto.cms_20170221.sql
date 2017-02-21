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

 Date: 02/21/2017 17:56:51 PM
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
  `parent_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_property_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__connections__project`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__connections__project`;
CREATE TABLE `_MimotoAimless__connections__project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `parent_property_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_entity_type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `sortindex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__core__contentsection`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__core__contentsection`;
CREATE TABLE `_MimotoAimless__core__contentsection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `isHiddenFromMenu` enum('0','1') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `_MimotoAimless__core__entityproperty`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__core__entityproperty`;
CREATE TABLE `_MimotoAimless__core__entityproperty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__core__entitypropertysetting`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__core__entitypropertysetting`;
CREATE TABLE `_MimotoAimless__core__entitypropertysetting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__core__file`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__core__file`;
CREATE TABLE `_MimotoAimless__core__file` (
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_fieldrules`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_fieldrules`;
CREATE TABLE `_MimotoAimless__interaction__form_fieldrules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
--  Table structure for `_MimotoAimless__interaction__form_input_list`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_list`;
CREATE TABLE `_MimotoAimless__interaction__form_input_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_multiselect`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_multiselect`;
CREATE TABLE `_MimotoAimless__interaction__form_input_multiselect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `option` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_input_textline`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_input_textline`;
CREATE TABLE `_MimotoAimless__interaction__form_input_textline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_inputoption`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_inputoption`;
CREATE TABLE `_MimotoAimless__interaction__form_inputoption` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_inputoption_listitem`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_inputoption_listitem`;
CREATE TABLE `_MimotoAimless__interaction__form_inputoption_listitem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_inputoption_map`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_inputoption_map`;
CREATE TABLE `_MimotoAimless__interaction__form_inputoption_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `targetKey` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `originKey` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_inputvalidation`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_inputvalidation`;
CREATE TABLE `_MimotoAimless__interaction__form_inputvalidation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `errorMessage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trigger` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_layout_divider`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_layout_divider`;
CREATE TABLE `_MimotoAimless__interaction__form_layout_divider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_layout_groupend`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_layout_groupend`;
CREATE TABLE `_MimotoAimless__interaction__form_layout_groupend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `_MimotoAimless__interaction__form_layout_groupstart`
-- ----------------------------
DROP TABLE IF EXISTS `_MimotoAimless__interaction__form_layout_groupstart`;
CREATE TABLE `_MimotoAimless__interaction__form_layout_groupstart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
