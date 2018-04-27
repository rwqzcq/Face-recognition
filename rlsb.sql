/*
Navicat MySQL Data Transfer

Source Server         : locahost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : rlsb

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-04-27 09:45:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `adminname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '123456');
INSERT INTO `admin` VALUES ('0', 'admin2', '123456');

-- ----------------------------
-- Table structure for `signin`
-- ----------------------------
DROP TABLE IF EXISTS `signin`;
CREATE TABLE `signin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(10) NOT NULL,
  `yes` text NOT NULL COMMENT '已签到人数',
  `late` text NOT NULL,
  `kuangke` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of signin
-- ----------------------------
INSERT INTO `signin` VALUES ('8', '1524787480', 'a:19:{i:0;i:211706702;i:1;i:211706704;i:2;i:211706705;i:3;i:211706709;i:4;i:211706713;i:5;i:211706714;i:6;i:211706715;i:7;i:211706716;i:8;i:211706717;i:9;i:211706719;i:10;i:211706720;i:11;i:211706721;i:12;i:211706722;i:13;i:211706723;i:14;i:211706725;i:15;i:211706727;i:16;i:211706728;i:17;i:211706729;i:18;i:211706730;}', 'a:0:{}', 'a:8:{i:0;i:211706706;i:1;i:211706707;i:2;i:211706708;i:3;i:211706710;i:4;i:211706711;i:5;i:211706712;i:6;i:211706718;i:7;i:211706726;}');
INSERT INTO `signin` VALUES ('9', '1524792984', 'a:1:{i:0;i:211706712;}', 'a:0:{}', 'a:26:{i:0;i:211706702;i:1;i:211706704;i:2;i:211706705;i:3;i:211706706;i:4;i:211706707;i:5;i:211706708;i:6;i:211706709;i:7;i:211706711;i:8;i:211706713;i:9;i:211706714;i:10;i:211706715;i:11;i:211706716;i:12;i:211706717;i:13;i:211706718;i:14;i:211706719;i:15;i:211706720;i:16;i:211706721;i:17;i:211706722;i:18;i:211706723;i:19;i:211706725;i:20;i:211706726;i:21;i:211706727;i:22;i:211706728;i:23;i:211706729;i:24;i:211706730;i:25;i:2015214531;}');
INSERT INTO `signin` VALUES ('10', '1524793305', 'a:1:{i:0;i:211706709;}', 'a:0:{}', 'a:26:{i:0;i:211706702;i:1;i:211706704;i:2;i:211706705;i:3;i:211706706;i:4;i:211706707;i:5;i:211706708;i:6;i:211706711;i:7;i:211706712;i:8;i:211706713;i:9;i:211706714;i:10;i:211706715;i:11;i:211706716;i:12;i:211706717;i:13;i:211706718;i:14;i:211706719;i:15;i:211706720;i:16;i:211706721;i:17;i:211706722;i:18;i:211706723;i:19;i:211706725;i:20;i:211706726;i:21;i:211706727;i:22;i:211706728;i:23;i:211706729;i:24;i:211706730;i:25;i:2015214531;}');

-- ----------------------------
-- Table structure for `student`
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `img` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('211706702', '陈煌毅', '211706702.jpg');
INSERT INTO `student` VALUES ('211706704', '陈柳杰', '211706704.jpg');
INSERT INTO `student` VALUES ('211706705', '陈思超', '211706705.jpg');
INSERT INTO `student` VALUES ('211706706', '高成茁', '211706706.jpg');
INSERT INTO `student` VALUES ('211706707', '黄天春', '211706707.jpg');
INSERT INTO `student` VALUES ('211706708', '纪泽斌', '211706708.jpg');
INSERT INTO `student` VALUES ('211706709', '江瑞洁', '211706709.jpg');
INSERT INTO `student` VALUES ('211706711', '李惠强', '211706711.jpg');
INSERT INTO `student` VALUES ('211706712', '李秋菊', '211706712.jpg');
INSERT INTO `student` VALUES ('211706713', '林凯亮', '211706713.jpg');
INSERT INTO `student` VALUES ('211706714', '林锐旸', '211706714.jpg');
INSERT INTO `student` VALUES ('211706715', '林伟', '211706715.jpg');
INSERT INTO `student` VALUES ('211706716', '林泽', '211706716.jpg');
INSERT INTO `student` VALUES ('211706717', '卢翔骏', '211706717.jpg');
INSERT INTO `student` VALUES ('211706718', '麦熠熠', '211706718.jpg');
INSERT INTO `student` VALUES ('211706719', '商天成', '211706719.jpg');
INSERT INTO `student` VALUES ('211706720', '宋恒杰', '211706720.jpg');
INSERT INTO `student` VALUES ('211706721', '王志斌', '211706721.jpg');
INSERT INTO `student` VALUES ('211706722', '魏婕', '211706722.jpg');
INSERT INTO `student` VALUES ('211706723', '吴敬隆', '211706723.jpg');
INSERT INTO `student` VALUES ('211706725', '吴志翔', '211706725.jpg');
INSERT INTO `student` VALUES ('211706726', '肖嘉敏', '211706726.jpg');
INSERT INTO `student` VALUES ('211706727', '曾坚煌', '211706727.jpg');
INSERT INTO `student` VALUES ('211706728', '曾译新', '211706728.jpg');
INSERT INTO `student` VALUES ('211706729', '张璟胜', '211706729.jpg');
INSERT INTO `student` VALUES ('211706730', '张舒媛', '211706730.jpg');
INSERT INTO `student` VALUES ('2015214531', '账上划水', '20180427\\483adaf7a8adfe70560bd76f52e5859e.jpg');
