/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50721
Source Host           : localhost:3306
Source Database       : resource

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2019-01-16 19:16:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `res_session`
-- ----------------------------
DROP TABLE IF EXISTS `res_session`;
CREATE TABLE `res_session` (
  `session_id` varchar(255) NOT NULL,
  `session_expire` int(11) unsigned NOT NULL,
  `session_data` text,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of res_session
-- ----------------------------
INSERT INTO `res_session` VALUES ('think_1mo0ck0lgnmblbhi1pe8evoirp', '1547640891', '__token__|s:32:\"44602aae095217300f6493dc925d5bb6\";id|i:9;name|s:9:\"金刚狼\";');

-- ----------------------------
-- Table structure for `res_user`
-- ----------------------------
DROP TABLE IF EXISTS `res_user`;
CREATE TABLE `res_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(128) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `email` varchar(64) NOT NULL COMMENT '邮箱',
  `join` date NOT NULL COMMENT '注册日期',
  `level` tinyint(4) DEFAULT '1' COMMENT '用户等级',
  `experience` mediumint(8) unsigned DEFAULT NULL COMMENT '当前经验',
  `accumulatedLoginDays` mediumint(8) unsigned DEFAULT '0' COMMENT '累计登录天数',
  `consecutiveLoginDays` mediumint(8) unsigned DEFAULT '0' COMMENT '连续登录天数',
  `salt` varchar(64) NOT NULL COMMENT '盐值',
  `couldLogin` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否可登录',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username_2` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of res_user
-- ----------------------------
INSERT INTO `res_user` VALUES ('1', 'luojiangyuan', 'a155d2d70f670b484bf2232739c86ae7', '519478450@qq.com', '2018-12-18', '2', '182', '23', '3', '0a94a924c35e0c65df79b64a6bafa687', '1');
INSERT INTO `res_user` VALUES ('2', '初雪', '3005a2ceae69caeaa275f99f3ad5cfc1', 'luo519@163.com', '2018-12-24', '1', '57', '5', '1', '1718380d1517f2c47775fb2d295865f1', '1');
INSERT INTO `res_user` VALUES ('3', '天地鸥', '3b95cfa9b1f8c04a212460af458c1419', 'CWJHN@outlook.com', '2018-12-24', '1', '51', '5', '1', 'fa983890a1806d4efbba54ddcea5b6a0', '1');
INSERT INTO `res_user` VALUES ('4', '晴夏', '16d0bcf414cae1dddedafd95ff1ebdff', 'luo519478@163.com', '2018-12-24', '1', '51', '5', '1', 'bae22e7e87acc3f759ffe662bd45cedf', '1');
INSERT INTO `res_user` VALUES ('5', '月江流', '49e8f302c9e865b4e6324ee62e2d78c8', '1014740030@qq.com', '2018-12-24', '1', '51', '5', '1', '39a875e6c0e968b3689e3b304efb113a', '1');
INSERT INTO `res_user` VALUES ('6', '新春', '2eab5da69d67c5a84cf2f24f7adbe020', 'luo519478450@gmail.com', '2018-12-24', '1', '41', '4', '1', '38e77e8a57d517283f8392ad7d9bf222', '1');
INSERT INTO `res_user` VALUES ('7', '云沾衣', 'c5344a2d1506565351b872ef3ca2e06e', 'a1014740030@gmail.com', '2018-12-24', '1', '51', '5', '1', '84eae47b2e1cd5fe534bd9f37c0aec3b', '1');
INSERT INTO `res_user` VALUES ('8', '晚秋', '3bfa42e7d173e53feae756a34f625c46', 'luo519478@gmail.com', '2018-12-24', '1', '51', '5', '1', '46d1750f4e153d3727ab0c9ae735f6c2', '1');
INSERT INTO `res_user` VALUES ('9', '金刚狼', '638cefff83c3ccd9973cceeb32be3f15', 'luo519478450@163.com', '2018-12-24', '2', '52', '12', '1', '32cae3e1c0ecde563eae20ee589a19af', '1');
INSERT INTO `res_user` VALUES ('10', '', 'd19203ec2a3df61aa19f121af1178937', '', '2018-12-24', '1', '10', '1', '1', '914f1a353323b0974e098b4bf7755e8f', '1');
INSERT INTO `res_user` VALUES ('11', '天地一沙鸥', 'b6c69c816fdb2168532acb250aa4f6a1', 'luojiangyuan@kaiyuan.net', '2019-01-03', '1', '31', '3', '1', '065d78796709dac9ac52421022c68918', '1');

-- ----------------------------
-- Table structure for `res_user_action`
-- ----------------------------
DROP TABLE IF EXISTS `res_user_action`;
CREATE TABLE `res_user_action` (
  `actionID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '操作id',
  `id` int(10) unsigned NOT NULL COMMENT '用户id',
  `actionTime` int(11) NOT NULL COMMENT '操作时间',
  `actionType` varchar(32) NOT NULL COMMENT '操作类型',
  PRIMARY KEY (`actionID`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of res_user_action
-- ----------------------------
INSERT INTO `res_user_action` VALUES ('1', '9', '1545704125', 'pwdError');
INSERT INTO `res_user_action` VALUES ('2', '9', '1545704150', 'pwdError');
INSERT INTO `res_user_action` VALUES ('3', '9', '1545704196', 'pwdError');
INSERT INTO `res_user_action` VALUES ('4', '9', '1545887787', 'pwdError');
INSERT INTO `res_user_action` VALUES ('5', '1', '1545887939', 'pwdError');
INSERT INTO `res_user_action` VALUES ('6', '1', '1545887981', 'pwdError');
INSERT INTO `res_user_action` VALUES ('7', '1', '1545888953', 'pwdError');
INSERT INTO `res_user_action` VALUES ('8', '1', '1545888957', 'pwdError');
INSERT INTO `res_user_action` VALUES ('9', '1', '1545888959', 'pwdError');
INSERT INTO `res_user_action` VALUES ('10', '1', '1545888969', 'pwdError');
INSERT INTO `res_user_action` VALUES ('11', '1', '1545889018', 'pwdError');
INSERT INTO `res_user_action` VALUES ('12', '1', '1545889122', 'pwdError');
INSERT INTO `res_user_action` VALUES ('13', '9', '1545889632', 'pwdError');
INSERT INTO `res_user_action` VALUES ('14', '9', '1545889637', 'pwdError');
INSERT INTO `res_user_action` VALUES ('15', '9', '1545889639', 'pwdError');
INSERT INTO `res_user_action` VALUES ('16', '9', '1545889641', 'pwdError');
INSERT INTO `res_user_action` VALUES ('17', '2', '1545896220', 'pwdError');
INSERT INTO `res_user_action` VALUES ('18', '1', '1545897199', 'pwdError');
INSERT INTO `res_user_action` VALUES ('19', '9', '1545897415', 'pwdError');
INSERT INTO `res_user_action` VALUES ('20', '9', '1545897463', 'pwdError');
INSERT INTO `res_user_action` VALUES ('21', '9', '1545897516', 'pwdError');
INSERT INTO `res_user_action` VALUES ('22', '9', '1545897527', 'pwdError');
INSERT INTO `res_user_action` VALUES ('23', '9', '1545897533', 'pwdError');
INSERT INTO `res_user_action` VALUES ('24', '2', '1545897594', 'pwdError');
INSERT INTO `res_user_action` VALUES ('25', '2', '1545897599', 'pwdError');
INSERT INTO `res_user_action` VALUES ('26', '2', '1545897602', 'pwdError');
INSERT INTO `res_user_action` VALUES ('27', '2', '1545897606', 'pwdError');
INSERT INTO `res_user_action` VALUES ('28', '6', '1545897919', 'pwdError');
INSERT INTO `res_user_action` VALUES ('29', '6', '1545897931', 'pwdError');
INSERT INTO `res_user_action` VALUES ('30', '6', '1545897938', 'pwdError');
INSERT INTO `res_user_action` VALUES ('31', '6', '1545897946', 'pwdError');
INSERT INTO `res_user_action` VALUES ('32', '6', '1545897979', 'pwdError');
INSERT INTO `res_user_action` VALUES ('33', '4', '1545897998', 'pwdError');
INSERT INTO `res_user_action` VALUES ('34', '4', '1545898006', 'pwdError');
INSERT INTO `res_user_action` VALUES ('35', '4', '1545898011', 'pwdError');
INSERT INTO `res_user_action` VALUES ('36', '1', '1545968041', 'pwdError');
INSERT INTO `res_user_action` VALUES ('37', '1', '1545968080', 'pwdError');
INSERT INTO `res_user_action` VALUES ('38', '1', '1545968087', 'pwdError');
INSERT INTO `res_user_action` VALUES ('39', '1', '1545968094', 'pwdError');
INSERT INTO `res_user_action` VALUES ('40', '1', '1545968101', 'pwdError');
INSERT INTO `res_user_action` VALUES ('41', '10', '1546050453', 'pwdError');
INSERT INTO `res_user_action` VALUES ('42', '10', '1546050464', 'pwdError');
INSERT INTO `res_user_action` VALUES ('43', '10', '1546050468', 'pwdError');
INSERT INTO `res_user_action` VALUES ('44', '10', '1546050471', 'pwdError');
INSERT INTO `res_user_action` VALUES ('45', '10', '1546050474', 'pwdError');
INSERT INTO `res_user_action` VALUES ('46', '9', '1546414398', 'pwdError');
INSERT INTO `res_user_action` VALUES ('47', '1', '1546414972', 'pwdError');
INSERT INTO `res_user_action` VALUES ('48', '9', '1546416103', 'pwdError');
INSERT INTO `res_user_action` VALUES ('49', '9', '1546416230', 'pwdError');
INSERT INTO `res_user_action` VALUES ('50', '1', '1546416235', 'pwdError');
INSERT INTO `res_user_action` VALUES ('51', '9', '1546497940', 'pwdError');
INSERT INTO `res_user_action` VALUES ('52', '9', '1546497957', 'pwdError');
INSERT INTO `res_user_action` VALUES ('53', '9', '1546497964', 'pwdError');
INSERT INTO `res_user_action` VALUES ('54', '9', '1546497968', 'pwdError');
INSERT INTO `res_user_action` VALUES ('55', '9', '1546497970', 'pwdError');
INSERT INTO `res_user_action` VALUES ('56', '9', '1546499379', 'pwdError');
INSERT INTO `res_user_action` VALUES ('57', '2', '1546581821', 'pwdError');
INSERT INTO `res_user_action` VALUES ('58', '2', '1546581828', 'pwdError');
INSERT INTO `res_user_action` VALUES ('59', '2', '1546581836', 'pwdError');
INSERT INTO `res_user_action` VALUES ('60', '6', '1546581905', 'pwdError');
INSERT INTO `res_user_action` VALUES ('61', '6', '1546581917', 'pwdError');
INSERT INTO `res_user_action` VALUES ('62', '6', '1546581923', 'pwdError');
INSERT INTO `res_user_action` VALUES ('63', '6', '1546581928', 'pwdError');
INSERT INTO `res_user_action` VALUES ('64', '6', '1546581943', 'pwdError');
INSERT INTO `res_user_action` VALUES ('65', '6', '1546581996', 'pwdError');
INSERT INTO `res_user_action` VALUES ('66', '6', '1546582009', 'pwdError');
INSERT INTO `res_user_action` VALUES ('67', '6', '1546582022', 'pwdError');
INSERT INTO `res_user_action` VALUES ('68', '6', '1546582035', 'pwdError');
INSERT INTO `res_user_action` VALUES ('69', '10', '1546588988', 'pwdError');
INSERT INTO `res_user_action` VALUES ('70', '10', '1547102288', 'pwdError');
INSERT INTO `res_user_action` VALUES ('71', '9', '1547431408', 'pwdError');
INSERT INTO `res_user_action` VALUES ('72', '9', '1547431773', 'pwdError');
INSERT INTO `res_user_action` VALUES ('73', '9', '1547431962', 'pwdError');
INSERT INTO `res_user_action` VALUES ('74', '9', '1547431974', 'pwdError');
INSERT INTO `res_user_action` VALUES ('75', '1', '1547432192', 'pwdError');
INSERT INTO `res_user_action` VALUES ('76', '2', '1547432287', 'pwdError');
INSERT INTO `res_user_action` VALUES ('77', '3', '1547432351', 'pwdError');
INSERT INTO `res_user_action` VALUES ('78', '5', '1547432409', 'pwdError');
INSERT INTO `res_user_action` VALUES ('79', '7', '1547432476', 'pwdError');
INSERT INTO `res_user_action` VALUES ('80', '8', '1547432542', 'pwdError');
INSERT INTO `res_user_action` VALUES ('81', '6', '1547432619', 'pwdError');
INSERT INTO `res_user_action` VALUES ('82', '4', '1547432685', 'pwdError');
INSERT INTO `res_user_action` VALUES ('83', '11', '1547432754', 'pwdError');
INSERT INTO `res_user_action` VALUES ('84', '10', '1547432850', 'pwdError');
INSERT INTO `res_user_action` VALUES ('85', '1', '1547445455', 'pwdError');

-- ----------------------------
-- Table structure for `res_user_level`
-- ----------------------------
DROP TABLE IF EXISTS `res_user_level`;
CREATE TABLE `res_user_level` (
  `level` tinyint(4) DEFAULT NULL COMMENT '等级',
  `replyNums` tinyint(4) DEFAULT NULL COMMENT '每小时回复数',
  `postNums` tinyint(4) DEFAULT NULL COMMENT '每小时发帖数',
  `experience` mediumint(8) unsigned DEFAULT NULL COMMENT '经验'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of res_user_level
-- ----------------------------
INSERT INTO `res_user_level` VALUES ('1', '5', '1', '100');
INSERT INTO `res_user_level` VALUES ('2', '5', '1', '200');
INSERT INTO `res_user_level` VALUES ('3', '6', '2', '300');
INSERT INTO `res_user_level` VALUES ('4', '6', '2', '400');
INSERT INTO `res_user_level` VALUES ('5', '7', '3', '500');
INSERT INTO `res_user_level` VALUES ('6', '7', '3', '600');
INSERT INTO `res_user_level` VALUES ('7', '8', '4', '700');
INSERT INTO `res_user_level` VALUES ('8', '8', '4', '800');
INSERT INTO `res_user_level` VALUES ('9', '9', '5', '900');
INSERT INTO `res_user_level` VALUES ('10', '9', '5', '1000');
INSERT INTO `res_user_level` VALUES ('11', '10', '6', '1100');
INSERT INTO `res_user_level` VALUES ('12', '10', '6', '1200');
INSERT INTO `res_user_level` VALUES ('13', '11', '7', '1300');
INSERT INTO `res_user_level` VALUES ('14', '11', '7', '1400');
INSERT INTO `res_user_level` VALUES ('15', '12', '8', '1500');
INSERT INTO `res_user_level` VALUES ('16', '12', '8', '1600');
INSERT INTO `res_user_level` VALUES ('17', '13', '9', '1700');
INSERT INTO `res_user_level` VALUES ('18', '13', '9', '1800');
INSERT INTO `res_user_level` VALUES ('19', '14', '10', '1900');
INSERT INTO `res_user_level` VALUES ('20', '14', '10', '2000');
INSERT INTO `res_user_level` VALUES ('21', '15', '11', '2100');
INSERT INTO `res_user_level` VALUES ('22', '15', '11', '2200');
INSERT INTO `res_user_level` VALUES ('23', '16', '12', '2300');
INSERT INTO `res_user_level` VALUES ('24', '16', '12', '2400');
INSERT INTO `res_user_level` VALUES ('25', '17', '13', '2500');
INSERT INTO `res_user_level` VALUES ('26', '17', '13', '2600');
INSERT INTO `res_user_level` VALUES ('27', '18', '14', '2700');
INSERT INTO `res_user_level` VALUES ('28', '18', '14', '2800');
INSERT INTO `res_user_level` VALUES ('29', '19', '15', '2900');
INSERT INTO `res_user_level` VALUES ('30', '19', '15', '3000');
INSERT INTO `res_user_level` VALUES ('31', '20', '16', '3100');
INSERT INTO `res_user_level` VALUES ('32', '20', '16', '3200');
INSERT INTO `res_user_level` VALUES ('33', '21', '17', '3300');
INSERT INTO `res_user_level` VALUES ('34', '21', '17', '3400');
INSERT INTO `res_user_level` VALUES ('35', '22', '18', '3500');
INSERT INTO `res_user_level` VALUES ('36', '22', '18', '3600');
INSERT INTO `res_user_level` VALUES ('37', '23', '19', '3700');
INSERT INTO `res_user_level` VALUES ('38', '23', '19', '3800');
INSERT INTO `res_user_level` VALUES ('39', '24', '20', '3900');
INSERT INTO `res_user_level` VALUES ('40', '24', '20', '4000');
INSERT INTO `res_user_level` VALUES ('41', '25', '21', '4100');
INSERT INTO `res_user_level` VALUES ('42', '25', '21', '4200');
INSERT INTO `res_user_level` VALUES ('43', '26', '22', '4300');
INSERT INTO `res_user_level` VALUES ('44', '26', '22', '4400');
INSERT INTO `res_user_level` VALUES ('45', '27', '23', '4500');
INSERT INTO `res_user_level` VALUES ('46', '27', '23', '4600');
INSERT INTO `res_user_level` VALUES ('47', '28', '24', '4700');
INSERT INTO `res_user_level` VALUES ('48', '28', '24', '4800');
INSERT INTO `res_user_level` VALUES ('49', '29', '25', '4900');
INSERT INTO `res_user_level` VALUES ('50', '29', '25', '5000');
INSERT INTO `res_user_level` VALUES ('51', '30', '26', '5100');
INSERT INTO `res_user_level` VALUES ('52', '30', '26', '5200');
INSERT INTO `res_user_level` VALUES ('53', '31', '27', '5300');
INSERT INTO `res_user_level` VALUES ('54', '31', '27', '5400');
INSERT INTO `res_user_level` VALUES ('55', '32', '28', '5500');
INSERT INTO `res_user_level` VALUES ('56', '32', '28', '5600');
INSERT INTO `res_user_level` VALUES ('57', '33', '29', '5700');
INSERT INTO `res_user_level` VALUES ('58', '33', '29', '5800');
INSERT INTO `res_user_level` VALUES ('59', '34', '30', '5900');
INSERT INTO `res_user_level` VALUES ('60', '34', '30', '6000');
INSERT INTO `res_user_level` VALUES ('61', '35', '31', '6100');
INSERT INTO `res_user_level` VALUES ('62', '35', '31', '6200');
INSERT INTO `res_user_level` VALUES ('63', '36', '32', '6300');
INSERT INTO `res_user_level` VALUES ('64', '36', '32', '6400');
INSERT INTO `res_user_level` VALUES ('65', '37', '33', '6500');
INSERT INTO `res_user_level` VALUES ('66', '37', '33', '6600');
INSERT INTO `res_user_level` VALUES ('67', '38', '34', '6700');
INSERT INTO `res_user_level` VALUES ('68', '38', '34', '6800');
INSERT INTO `res_user_level` VALUES ('69', '39', '35', '6900');
INSERT INTO `res_user_level` VALUES ('70', '39', '35', '7000');
INSERT INTO `res_user_level` VALUES ('71', '40', '36', '7100');
INSERT INTO `res_user_level` VALUES ('72', '40', '36', '7200');
INSERT INTO `res_user_level` VALUES ('73', '41', '37', '7300');
INSERT INTO `res_user_level` VALUES ('74', '41', '37', '7400');
INSERT INTO `res_user_level` VALUES ('75', '42', '38', '7500');
INSERT INTO `res_user_level` VALUES ('76', '42', '38', '7600');
INSERT INTO `res_user_level` VALUES ('77', '43', '39', '7700');
INSERT INTO `res_user_level` VALUES ('78', '43', '39', '7800');
INSERT INTO `res_user_level` VALUES ('79', '44', '40', '7900');
INSERT INTO `res_user_level` VALUES ('80', '44', '40', '8000');
INSERT INTO `res_user_level` VALUES ('81', '45', '41', '8100');
INSERT INTO `res_user_level` VALUES ('82', '45', '41', '8200');
INSERT INTO `res_user_level` VALUES ('83', '46', '42', '8300');
INSERT INTO `res_user_level` VALUES ('84', '46', '42', '8400');
INSERT INTO `res_user_level` VALUES ('85', '47', '43', '8500');
INSERT INTO `res_user_level` VALUES ('86', '47', '43', '8600');
INSERT INTO `res_user_level` VALUES ('87', '48', '44', '8700');
INSERT INTO `res_user_level` VALUES ('88', '48', '44', '8800');
INSERT INTO `res_user_level` VALUES ('89', '49', '45', '8900');
INSERT INTO `res_user_level` VALUES ('90', '49', '45', '9000');
INSERT INTO `res_user_level` VALUES ('91', '50', '46', '9100');
INSERT INTO `res_user_level` VALUES ('92', '50', '46', '9200');
INSERT INTO `res_user_level` VALUES ('93', '51', '47', '9300');
INSERT INTO `res_user_level` VALUES ('94', '51', '47', '9400');
INSERT INTO `res_user_level` VALUES ('95', '52', '48', '9500');
INSERT INTO `res_user_level` VALUES ('96', '52', '48', '9600');
INSERT INTO `res_user_level` VALUES ('97', '53', '49', '9700');
INSERT INTO `res_user_level` VALUES ('98', '53', '49', '9800');
INSERT INTO `res_user_level` VALUES ('99', '54', '50', '9900');
INSERT INTO `res_user_level` VALUES ('100', '54', '50', '10000');

-- ----------------------------
-- Table structure for `res_user_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `res_user_login_log`;
CREATE TABLE `res_user_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `signIn` datetime NOT NULL COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=231 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of res_user_login_log
-- ----------------------------
INSERT INTO `res_user_login_log` VALUES ('1', '1', '2018-12-18 17:00:46');
INSERT INTO `res_user_login_log` VALUES ('2', '1', '2018-12-18 17:07:50');
INSERT INTO `res_user_login_log` VALUES ('3', '1', '2018-12-18 17:08:52');
INSERT INTO `res_user_login_log` VALUES ('4', '1', '2018-12-18 17:14:02');
INSERT INTO `res_user_login_log` VALUES ('5', '1', '2018-12-18 17:14:18');
INSERT INTO `res_user_login_log` VALUES ('6', '1', '2018-12-18 17:22:12');
INSERT INTO `res_user_login_log` VALUES ('7', '1', '2018-12-18 17:23:45');
INSERT INTO `res_user_login_log` VALUES ('8', '1', '2018-12-19 10:18:29');
INSERT INTO `res_user_login_log` VALUES ('9', '1', '2018-12-19 10:20:36');
INSERT INTO `res_user_login_log` VALUES ('10', '1', '2018-12-19 11:28:51');
INSERT INTO `res_user_login_log` VALUES ('11', '1', '2018-12-19 13:20:46');
INSERT INTO `res_user_login_log` VALUES ('12', '1', '2018-12-19 13:22:52');
INSERT INTO `res_user_login_log` VALUES ('13', '1', '2018-12-19 13:23:58');
INSERT INTO `res_user_login_log` VALUES ('14', '1', '2018-12-19 13:38:03');
INSERT INTO `res_user_login_log` VALUES ('15', '1', '2018-12-19 13:40:24');
INSERT INTO `res_user_login_log` VALUES ('16', '1', '2018-12-19 13:41:17');
INSERT INTO `res_user_login_log` VALUES ('17', '1', '2018-12-19 13:42:07');
INSERT INTO `res_user_login_log` VALUES ('18', '1', '2018-12-19 13:42:16');
INSERT INTO `res_user_login_log` VALUES ('19', '1', '2018-12-19 13:44:58');
INSERT INTO `res_user_login_log` VALUES ('20', '1', '2018-12-19 14:14:36');
INSERT INTO `res_user_login_log` VALUES ('21', '1', '2018-12-19 14:15:28');
INSERT INTO `res_user_login_log` VALUES ('22', '1', '2018-12-19 14:18:52');
INSERT INTO `res_user_login_log` VALUES ('23', '1', '2018-12-19 14:22:11');
INSERT INTO `res_user_login_log` VALUES ('24', '1', '2018-12-19 14:38:32');
INSERT INTO `res_user_login_log` VALUES ('25', '1', '2018-12-19 14:38:45');
INSERT INTO `res_user_login_log` VALUES ('26', '1', '2018-12-19 16:23:22');
INSERT INTO `res_user_login_log` VALUES ('27', '1', '2018-12-20 09:16:01');
INSERT INTO `res_user_login_log` VALUES ('28', '1', '2018-12-20 09:17:02');
INSERT INTO `res_user_login_log` VALUES ('29', '1', '2018-12-20 09:17:04');
INSERT INTO `res_user_login_log` VALUES ('30', '1', '2018-12-20 09:17:07');
INSERT INTO `res_user_login_log` VALUES ('31', '1', '2018-12-20 09:17:08');
INSERT INTO `res_user_login_log` VALUES ('32', '1', '2018-12-20 09:17:10');
INSERT INTO `res_user_login_log` VALUES ('33', '1', '2018-12-20 09:17:10');
INSERT INTO `res_user_login_log` VALUES ('34', '1', '2018-12-20 09:17:11');
INSERT INTO `res_user_login_log` VALUES ('35', '1', '2018-12-20 09:20:40');
INSERT INTO `res_user_login_log` VALUES ('36', '1', '2018-12-20 11:35:08');
INSERT INTO `res_user_login_log` VALUES ('37', '1', '2018-12-20 13:37:45');
INSERT INTO `res_user_login_log` VALUES ('38', '1', '2018-12-20 13:39:26');
INSERT INTO `res_user_login_log` VALUES ('39', '1', '2018-12-20 13:44:07');
INSERT INTO `res_user_login_log` VALUES ('40', '1', '2018-12-20 13:44:10');
INSERT INTO `res_user_login_log` VALUES ('41', '1', '2018-12-20 13:44:12');
INSERT INTO `res_user_login_log` VALUES ('42', '1', '2018-12-20 13:44:14');
INSERT INTO `res_user_login_log` VALUES ('43', '1', '2018-12-20 13:44:14');
INSERT INTO `res_user_login_log` VALUES ('44', '1', '2018-12-20 13:44:15');
INSERT INTO `res_user_login_log` VALUES ('45', '1', '2018-12-20 14:05:24');
INSERT INTO `res_user_login_log` VALUES ('46', '1', '2018-12-20 14:05:39');
INSERT INTO `res_user_login_log` VALUES ('47', '1', '2018-12-20 14:05:44');
INSERT INTO `res_user_login_log` VALUES ('48', '1', '2018-12-20 14:10:38');
INSERT INTO `res_user_login_log` VALUES ('49', '1', '2018-12-20 14:10:43');
INSERT INTO `res_user_login_log` VALUES ('50', '1', '2018-12-20 14:15:03');
INSERT INTO `res_user_login_log` VALUES ('51', '1', '2018-12-20 14:16:03');
INSERT INTO `res_user_login_log` VALUES ('52', '1', '2018-12-20 16:57:36');
INSERT INTO `res_user_login_log` VALUES ('53', '1', '2018-12-20 17:40:30');
INSERT INTO `res_user_login_log` VALUES ('54', '1', '2018-12-24 14:21:20');
INSERT INTO `res_user_login_log` VALUES ('55', '4', '2018-12-24 15:08:41');
INSERT INTO `res_user_login_log` VALUES ('56', '7', '2018-12-24 15:21:15');
INSERT INTO `res_user_login_log` VALUES ('57', '1', '2018-12-24 15:24:49');
INSERT INTO `res_user_login_log` VALUES ('58', '7', '2018-12-24 15:25:13');
INSERT INTO `res_user_login_log` VALUES ('59', '7', '2018-12-24 15:36:08');
INSERT INTO `res_user_login_log` VALUES ('60', '8', '2018-12-24 15:38:02');
INSERT INTO `res_user_login_log` VALUES ('61', '9', '2018-12-24 15:40:34');
INSERT INTO `res_user_login_log` VALUES ('62', '2', '2018-12-24 16:05:53');
INSERT INTO `res_user_login_log` VALUES ('63', '2', '2018-12-24 16:06:06');
INSERT INTO `res_user_login_log` VALUES ('64', '3', '2018-12-24 16:07:56');
INSERT INTO `res_user_login_log` VALUES ('65', '5', '2018-12-24 16:09:26');
INSERT INTO `res_user_login_log` VALUES ('66', '6', '2018-12-24 16:09:57');
INSERT INTO `res_user_login_log` VALUES ('67', '10', '2018-12-24 16:38:00');
INSERT INTO `res_user_login_log` VALUES ('68', '10', '2018-12-24 16:41:07');
INSERT INTO `res_user_login_log` VALUES ('69', '1', '2018-12-24 17:30:05');
INSERT INTO `res_user_login_log` VALUES ('70', '1', '2018-12-24 17:51:07');
INSERT INTO `res_user_login_log` VALUES ('71', '1', '2018-12-25 09:09:16');
INSERT INTO `res_user_login_log` VALUES ('72', '2', '2018-12-25 09:12:17');
INSERT INTO `res_user_login_log` VALUES ('73', '3', '2018-12-25 09:13:30');
INSERT INTO `res_user_login_log` VALUES ('74', '4', '2018-12-25 09:14:58');
INSERT INTO `res_user_login_log` VALUES ('75', '5', '2018-12-25 09:15:37');
INSERT INTO `res_user_login_log` VALUES ('76', '6', '2018-12-25 09:17:19');
INSERT INTO `res_user_login_log` VALUES ('77', '7', '2018-12-25 09:18:04');
INSERT INTO `res_user_login_log` VALUES ('78', '8', '2018-12-25 09:18:33');
INSERT INTO `res_user_login_log` VALUES ('79', '9', '2018-12-25 09:19:51');
INSERT INTO `res_user_login_log` VALUES ('80', '9', '2018-12-27 13:16:27');
INSERT INTO `res_user_login_log` VALUES ('81', '1', '2018-12-27 13:18:59');
INSERT INTO `res_user_login_log` VALUES ('82', '1', '2018-12-27 13:19:41');
INSERT INTO `res_user_login_log` VALUES ('83', '1', '2018-12-27 15:55:49');
INSERT INTO `res_user_login_log` VALUES ('84', '9', '2018-12-27 15:56:39');
INSERT INTO `res_user_login_log` VALUES ('85', '1', '2018-12-27 16:01:56');
INSERT INTO `res_user_login_log` VALUES ('86', '8', '2018-12-27 16:04:43');
INSERT INTO `res_user_login_log` VALUES ('87', '4', '2018-12-27 16:06:59');
INSERT INTO `res_user_login_log` VALUES ('88', '1', '2018-12-27 16:14:29');
INSERT INTO `res_user_login_log` VALUES ('89', '3', '2018-12-27 16:14:51');
INSERT INTO `res_user_login_log` VALUES ('90', '5', '2018-12-27 16:15:31');
INSERT INTO `res_user_login_log` VALUES ('91', '7', '2018-12-27 16:15:54');
INSERT INTO `res_user_login_log` VALUES ('92', '7', '2018-12-27 16:16:19');
INSERT INTO `res_user_login_log` VALUES ('93', '7', '2018-12-27 16:43:13');
INSERT INTO `res_user_login_log` VALUES ('94', '1', '2018-12-27 17:14:41');
INSERT INTO `res_user_login_log` VALUES ('95', '1', '2018-12-27 17:17:41');
INSERT INTO `res_user_login_log` VALUES ('96', '1', '2018-12-27 17:35:09');
INSERT INTO `res_user_login_log` VALUES ('97', '1', '2018-12-27 18:21:12');
INSERT INTO `res_user_login_log` VALUES ('98', '1', '2018-12-27 18:57:03');
INSERT INTO `res_user_login_log` VALUES ('99', '1', '2018-12-28 09:09:09');
INSERT INTO `res_user_login_log` VALUES ('100', '9', '2018-12-28 11:35:26');
INSERT INTO `res_user_login_log` VALUES ('101', '1', '2018-12-28 13:39:07');
INSERT INTO `res_user_login_log` VALUES ('102', '1', '2018-12-28 14:21:45');
INSERT INTO `res_user_login_log` VALUES ('103', '1', '2018-12-29 16:37:06');
INSERT INTO `res_user_login_log` VALUES ('104', '9', '2018-12-29 16:43:12');
INSERT INTO `res_user_login_log` VALUES ('105', '9', '2018-12-29 16:47:15');
INSERT INTO `res_user_login_log` VALUES ('106', '9', '2018-12-29 16:49:07');
INSERT INTO `res_user_login_log` VALUES ('107', '1', '2018-12-29 17:00:22');
INSERT INTO `res_user_login_log` VALUES ('108', '1', '2018-12-29 17:13:36');
INSERT INTO `res_user_login_log` VALUES ('109', '1', '2018-12-29 17:15:38');
INSERT INTO `res_user_login_log` VALUES ('110', '1', '2018-12-29 17:16:29');
INSERT INTO `res_user_login_log` VALUES ('111', '1', '2018-12-29 18:05:33');
INSERT INTO `res_user_login_log` VALUES ('112', '9', '2018-12-29 18:14:18');
INSERT INTO `res_user_login_log` VALUES ('113', '9', '2018-12-29 18:24:18');
INSERT INTO `res_user_login_log` VALUES ('114', '9', '2019-01-02 15:30:32');
INSERT INTO `res_user_login_log` VALUES ('115', '9', '2019-01-02 16:06:20');
INSERT INTO `res_user_login_log` VALUES ('116', '9', '2019-01-02 16:09:59');
INSERT INTO `res_user_login_log` VALUES ('117', '9', '2019-01-02 16:28:58');
INSERT INTO `res_user_login_log` VALUES ('118', '9', '2019-01-02 16:29:45');
INSERT INTO `res_user_login_log` VALUES ('119', '9', '2019-01-02 16:37:18');
INSERT INTO `res_user_login_log` VALUES ('120', '9', '2019-01-02 16:40:35');
INSERT INTO `res_user_login_log` VALUES ('121', '9', '2019-01-02 16:41:40');
INSERT INTO `res_user_login_log` VALUES ('122', '9', '2019-01-02 16:43:31');
INSERT INTO `res_user_login_log` VALUES ('123', '9', '2019-01-02 17:31:36');
INSERT INTO `res_user_login_log` VALUES ('124', '9', '2019-01-02 17:33:48');
INSERT INTO `res_user_login_log` VALUES ('125', '9', '2019-01-02 19:06:45');
INSERT INTO `res_user_login_log` VALUES ('126', '9', '2019-01-02 19:09:41');
INSERT INTO `res_user_login_log` VALUES ('127', '9', '2019-01-02 19:10:55');
INSERT INTO `res_user_login_log` VALUES ('128', '9', '2019-01-02 19:13:04');
INSERT INTO `res_user_login_log` VALUES ('129', '9', '2019-01-02 19:14:07');
INSERT INTO `res_user_login_log` VALUES ('130', '9', '2019-01-02 19:14:54');
INSERT INTO `res_user_login_log` VALUES ('131', '9', '2019-01-02 19:15:56');
INSERT INTO `res_user_login_log` VALUES ('132', '9', '2019-01-02 19:19:48');
INSERT INTO `res_user_login_log` VALUES ('133', '9', '2019-01-02 19:21:27');
INSERT INTO `res_user_login_log` VALUES ('134', '9', '2019-01-03 09:07:53');
INSERT INTO `res_user_login_log` VALUES ('135', '9', '2019-01-03 09:20:23');
INSERT INTO `res_user_login_log` VALUES ('136', '9', '2019-01-03 09:23:48');
INSERT INTO `res_user_login_log` VALUES ('137', '9', '2019-01-03 09:24:22');
INSERT INTO `res_user_login_log` VALUES ('138', '9', '2019-01-03 09:26:38');
INSERT INTO `res_user_login_log` VALUES ('139', '9', '2019-01-03 09:27:17');
INSERT INTO `res_user_login_log` VALUES ('140', '9', '2019-01-03 09:27:55');
INSERT INTO `res_user_login_log` VALUES ('141', '9', '2019-01-03 09:30:30');
INSERT INTO `res_user_login_log` VALUES ('142', '9', '2019-01-03 09:50:45');
INSERT INTO `res_user_login_log` VALUES ('143', '9', '2019-01-03 09:51:01');
INSERT INTO `res_user_login_log` VALUES ('144', '9', '2019-01-03 09:51:46');
INSERT INTO `res_user_login_log` VALUES ('145', '9', '2019-01-03 10:55:58');
INSERT INTO `res_user_login_log` VALUES ('146', '9', '2019-01-03 11:07:39');
INSERT INTO `res_user_login_log` VALUES ('147', '9', '2019-01-03 11:14:52');
INSERT INTO `res_user_login_log` VALUES ('148', '9', '2019-01-03 13:24:34');
INSERT INTO `res_user_login_log` VALUES ('149', '9', '2019-01-03 13:44:24');
INSERT INTO `res_user_login_log` VALUES ('150', '9', '2019-01-03 13:48:10');
INSERT INTO `res_user_login_log` VALUES ('151', '9', '2019-01-03 13:50:47');
INSERT INTO `res_user_login_log` VALUES ('152', '9', '2019-01-03 13:51:38');
INSERT INTO `res_user_login_log` VALUES ('153', '9', '2019-01-03 13:57:16');
INSERT INTO `res_user_login_log` VALUES ('154', '9', '2019-01-03 13:59:13');
INSERT INTO `res_user_login_log` VALUES ('155', '9', '2019-01-03 13:59:27');
INSERT INTO `res_user_login_log` VALUES ('156', '9', '2019-01-03 14:01:34');
INSERT INTO `res_user_login_log` VALUES ('157', '9', '2019-01-03 14:02:14');
INSERT INTO `res_user_login_log` VALUES ('158', '9', '2019-01-03 14:12:20');
INSERT INTO `res_user_login_log` VALUES ('159', '9', '2019-01-03 14:15:47');
INSERT INTO `res_user_login_log` VALUES ('160', '9', '2019-01-03 14:16:23');
INSERT INTO `res_user_login_log` VALUES ('161', '9', '2019-01-03 14:18:40');
INSERT INTO `res_user_login_log` VALUES ('162', '9', '2019-01-03 14:19:36');
INSERT INTO `res_user_login_log` VALUES ('163', '9', '2019-01-03 14:19:55');
INSERT INTO `res_user_login_log` VALUES ('164', '9', '2019-01-03 14:20:54');
INSERT INTO `res_user_login_log` VALUES ('165', '1', '2019-01-03 14:24:48');
INSERT INTO `res_user_login_log` VALUES ('166', '9', '2019-01-03 14:30:00');
INSERT INTO `res_user_login_log` VALUES ('167', '1', '2019-01-03 14:46:54');
INSERT INTO `res_user_login_log` VALUES ('168', '9', '2019-01-03 14:53:52');
INSERT INTO `res_user_login_log` VALUES ('169', '11', '2019-01-03 15:10:04');
INSERT INTO `res_user_login_log` VALUES ('170', '9', '2019-01-04 14:01:32');
INSERT INTO `res_user_login_log` VALUES ('171', '1', '2019-01-04 14:02:05');
INSERT INTO `res_user_login_log` VALUES ('172', '2', '2019-01-04 14:04:06');
INSERT INTO `res_user_login_log` VALUES ('173', '2', '2019-01-04 14:04:41');
INSERT INTO `res_user_login_log` VALUES ('174', '6', '2019-01-04 14:07:25');
INSERT INTO `res_user_login_log` VALUES ('175', '3', '2019-01-04 14:52:01');
INSERT INTO `res_user_login_log` VALUES ('176', '5', '2019-01-04 14:52:22');
INSERT INTO `res_user_login_log` VALUES ('177', '7', '2019-01-04 14:52:36');
INSERT INTO `res_user_login_log` VALUES ('178', '8', '2019-01-04 14:52:53');
INSERT INTO `res_user_login_log` VALUES ('179', '4', '2019-01-04 14:53:11');
INSERT INTO `res_user_login_log` VALUES ('180', '11', '2019-01-04 14:53:24');
INSERT INTO `res_user_login_log` VALUES ('181', '1', '2019-01-04 14:56:48');
INSERT INTO `res_user_login_log` VALUES ('182', '1', '2019-01-04 15:06:57');
INSERT INTO `res_user_login_log` VALUES ('183', '1', '2019-01-04 15:13:45');
INSERT INTO `res_user_login_log` VALUES ('184', '1', '2019-01-10 09:12:46');
INSERT INTO `res_user_login_log` VALUES ('185', '1', '2019-01-10 09:45:16');
INSERT INTO `res_user_login_log` VALUES ('186', '1', '2019-01-10 09:47:20');
INSERT INTO `res_user_login_log` VALUES ('187', '1', '2019-01-10 09:47:57');
INSERT INTO `res_user_login_log` VALUES ('188', '1', '2019-01-10 09:48:56');
INSERT INTO `res_user_login_log` VALUES ('189', '1', '2019-01-10 10:01:40');
INSERT INTO `res_user_login_log` VALUES ('190', '1', '2019-01-10 10:07:40');
INSERT INTO `res_user_login_log` VALUES ('191', '1', '2019-01-10 10:12:16');
INSERT INTO `res_user_login_log` VALUES ('192', '1', '2019-01-10 10:13:38');
INSERT INTO `res_user_login_log` VALUES ('193', '1', '2019-01-10 10:13:52');
INSERT INTO `res_user_login_log` VALUES ('194', '1', '2019-01-10 10:15:05');
INSERT INTO `res_user_login_log` VALUES ('195', '1', '2019-01-10 11:13:48');
INSERT INTO `res_user_login_log` VALUES ('196', '1', '2019-01-10 13:37:37');
INSERT INTO `res_user_login_log` VALUES ('197', '1', '2019-01-10 13:53:16');
INSERT INTO `res_user_login_log` VALUES ('198', '9', '2019-01-10 13:55:32');
INSERT INTO `res_user_login_log` VALUES ('199', '9', '2019-01-10 14:19:18');
INSERT INTO `res_user_login_log` VALUES ('200', '9', '2019-01-10 14:19:37');
INSERT INTO `res_user_login_log` VALUES ('201', '9', '2019-01-10 15:30:04');
INSERT INTO `res_user_login_log` VALUES ('202', '9', '2019-01-10 15:41:56');
INSERT INTO `res_user_login_log` VALUES ('203', '9', '2019-01-10 15:43:35');
INSERT INTO `res_user_login_log` VALUES ('204', '9', '2019-01-10 15:45:33');
INSERT INTO `res_user_login_log` VALUES ('205', '9', '2019-01-10 15:51:12');
INSERT INTO `res_user_login_log` VALUES ('206', '9', '2019-01-10 16:23:11');
INSERT INTO `res_user_login_log` VALUES ('207', '9', '2019-01-10 16:25:26');
INSERT INTO `res_user_login_log` VALUES ('208', '2', '2019-01-10 16:36:04');
INSERT INTO `res_user_login_log` VALUES ('209', '9', '2019-01-11 09:54:30');
INSERT INTO `res_user_login_log` VALUES ('210', '9', '2019-01-14 10:14:14');
INSERT INTO `res_user_login_log` VALUES ('211', '1', '2019-01-14 10:17:46');
INSERT INTO `res_user_login_log` VALUES ('212', '2', '2019-01-14 10:18:51');
INSERT INTO `res_user_login_log` VALUES ('213', '3', '2019-01-14 10:19:52');
INSERT INTO `res_user_login_log` VALUES ('214', '5', '2019-01-14 10:20:51');
INSERT INTO `res_user_login_log` VALUES ('215', '7', '2019-01-14 10:22:03');
INSERT INTO `res_user_login_log` VALUES ('216', '8', '2019-01-14 10:23:17');
INSERT INTO `res_user_login_log` VALUES ('217', '6', '2019-01-14 10:24:30');
INSERT INTO `res_user_login_log` VALUES ('218', '4', '2019-01-14 10:25:38');
INSERT INTO `res_user_login_log` VALUES ('219', '11', '2019-01-14 10:27:09');
INSERT INTO `res_user_login_log` VALUES ('220', '9', '2019-01-14 10:54:42');
INSERT INTO `res_user_login_log` VALUES ('221', '1', '2019-01-14 13:56:57');
INSERT INTO `res_user_login_log` VALUES ('222', '1', '2019-01-14 13:57:44');
INSERT INTO `res_user_login_log` VALUES ('223', '1', '2019-01-14 13:58:42');
INSERT INTO `res_user_login_log` VALUES ('224', '9', '2019-01-14 14:29:51');
INSERT INTO `res_user_login_log` VALUES ('225', '1', '2019-01-14 15:15:00');
INSERT INTO `res_user_login_log` VALUES ('226', '1', '2019-01-14 17:58:19');
INSERT INTO `res_user_login_log` VALUES ('227', '1', '2019-01-15 10:48:18');
INSERT INTO `res_user_login_log` VALUES ('228', '1', '2019-01-16 09:10:15');
INSERT INTO `res_user_login_log` VALUES ('229', '1', '2019-01-16 13:10:24');
INSERT INTO `res_user_login_log` VALUES ('230', '9', '2019-01-16 14:13:58');

-- ----------------------------
-- Table structure for `res_user_post`
-- ----------------------------
DROP TABLE IF EXISTS `res_user_post`;
CREATE TABLE `res_user_post` (
  `postID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '帖子id',
  `authorID` int(10) unsigned NOT NULL COMMENT '作者',
  `title` varchar(256) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `postAddress` varchar(256) DEFAULT NULL COMMENT '帖子地址',
  `classify` varchar(64) NOT NULL COMMENT '分类',
  `postTime` int(11) NOT NULL COMMENT '发帖时间',
  `couldPost` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否允许发布',
  `isEffective` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否有效',
  `checked` varchar(64) DEFAULT NULL COMMENT '审核者',
  `checkStatus` varchar(16) DEFAULT NULL COMMENT '审核状态',
  `transpond` text,
  `second_classify` tinyint(3) unsigned DEFAULT NULL,
  `cover` varchar(256) NOT NULL DEFAULT '/static/common/images/default.jpg',
  PRIMARY KEY (`postID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of res_user_post
-- ----------------------------
INSERT INTO `res_user_post` VALUES ('1', '1', '新人帖', '大家好，我是罗江元', 'https://github.com/willnotlazy/resource', '新人报到', '1545646528', '0', '0', 'admin', 'doing', null, null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('2', '1', '100张和服美图', '图片来源百度', 'https://github.com/willnotlazy/', '美图', '1545646667', '0', '0', 'admin', 'doing', null, null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('3', '1', '漫威10部电影', '1-10部名字', 'https://github.com/willnotlazy/', '影视', '1545646952', '0', '0', 'admin', 'doing', null, null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('4', '1', '柯南1-700级合集', '中文字母1080p豪华版', 'https://github.com/willnotlazy/', '动漫动画', '1545647018', '0', '0', 'admin', 'doing', null, null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('5', '1', '海贼王1-800级', '中文字幕2700p贵族版', 'https://github.com/willnotlazy/', '动漫动画', '1545647057', '0', '0', 'admin', 'doing', null, null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('6', '1', '火影1-800级', '中文字幕720p小灵通版', 'https://github.com/willnotlazy/', '动漫动画', '1545647089', '0', '0', 'admin', 'doing', null, null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('7', '2', 'CLANNAD', 'CLANNAD全两季', 'www.baidu.com', '动漫动画', '1547110938', '0', '0', null, 'doing', null, null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('8', '2', '明朝那些事', '明朝那些事.equb版阅读', 'www.baidu.com', '小说', '1547111143', '0', '0', null, 'doing', null, null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('9', '2', '斗破苍穹', '斗破苍穹校对典藏版，无删节', 'www.baidu.com', '小说', '1547111194', '0', '0', null, 'doing', null, null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('10', '1', '一拳超人1080p', '<p>这里是测试内容&nbsp; &nbsp; &nbsp; &nbsp;</p>', '链接：https://pan.baidu.com/s/1dGKddIT、\n密码：dwxk', '1', '1547619055', '0', '0', null, null, '', null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('11', '9', '阿童木！童年回忆！！！', '<p>童年会议阿童木，一起回顾过往神番！！！</p>', '链接: https://pan.baidu.com/s/1dGKddIT 密码: dwxk', '1', '1547619343', '0', '0', null, null, '', null, '/static/common/images/default.jpg');
INSERT INTO `res_user_post` VALUES ('12', '9', '大鸟壁纸，不要错过！', '', '', '2', '1547625716', '0', '0', null, null, '', null, 'uploads/20190116/0c62d8194f13a75df90cbcf81310e0d0.jpg');
INSERT INTO `res_user_post` VALUES ('13', '9', '给你们一张好看的图片', '<p><img src=\"/ueditor/php/upload/image/20190116/1547636643239723.jpg\" title=\"1547636643239723.jpg\" alt=\"11030a548-0.jpg\"/></p>', '', '2', '1547636857', '0', '0', null, null, '', '57', 'uploads/20190116/0c62d8194f13a75df90cbcf81310e0d0.jpg');
INSERT INTO `res_user_post` VALUES ('14', '9', '有来了一张惊世壁纸', '<p><img src=\"/ueditor/php/upload/image/20190116/1547637273746274.jpg\" title=\"1547637273746274.jpg\" alt=\"110Z1J07-0.jpg\"/></p>', '', '2', '1547637285', '0', '0', null, null, '', '57', 'uploads/20190116/cfd406dcd6374a69b997efbdc9b23acf.jpg');

-- ----------------------------
-- Table structure for `res_user_resource_classify`
-- ----------------------------
DROP TABLE IF EXISTS `res_user_resource_classify`;
CREATE TABLE `res_user_resource_classify` (
  `classifyID` tinyint(3) unsigned NOT NULL COMMENT '分类id',
  `pid` tinyint(3) unsigned DEFAULT '0' COMMENT '父类id',
  `name` varchar(128) NOT NULL COMMENT '分类名',
  PRIMARY KEY (`classifyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of res_user_resource_classify
-- ----------------------------
INSERT INTO `res_user_resource_classify` VALUES ('1', '0', '动漫动画');
INSERT INTO `res_user_resource_classify` VALUES ('2', '0', '图片');
INSERT INTO `res_user_resource_classify` VALUES ('3', '0', '电影');
INSERT INTO `res_user_resource_classify` VALUES ('4', '0', '电视剧');
INSERT INTO `res_user_resource_classify` VALUES ('5', '0', '漫画');
INSERT INTO `res_user_resource_classify` VALUES ('6', '0', '小说');
INSERT INTO `res_user_resource_classify` VALUES ('8', '0', '游戏');
INSERT INTO `res_user_resource_classify` VALUES ('10', '0', 'IT视频');
INSERT INTO `res_user_resource_classify` VALUES ('11', '10', 'android');
INSERT INTO `res_user_resource_classify` VALUES ('12', '10', 'c/c++');
INSERT INTO `res_user_resource_classify` VALUES ('13', '10', 'c#');
INSERT INTO `res_user_resource_classify` VALUES ('14', '10', 'go');
INSERT INTO `res_user_resource_classify` VALUES ('15', '10', 'html5');
INSERT INTO `res_user_resource_classify` VALUES ('16', '10', 'ios');
INSERT INTO `res_user_resource_classify` VALUES ('17', '10', 'javaweb');
INSERT INTO `res_user_resource_classify` VALUES ('18', '10', 'Linux');
INSERT INTO `res_user_resource_classify` VALUES ('19', '10', 'php');
INSERT INTO `res_user_resource_classify` VALUES ('20', '10', 'python');
INSERT INTO `res_user_resource_classify` VALUES ('21', '10', 'ruby');
INSERT INTO `res_user_resource_classify` VALUES ('22', '10', 'web前端');
INSERT INTO `res_user_resource_classify` VALUES ('23', '10', 'window phone8');
INSERT INTO `res_user_resource_classify` VALUES ('24', '10', 'wordpress');
INSERT INTO `res_user_resource_classify` VALUES ('25', '10', '产品');
INSERT INTO `res_user_resource_classify` VALUES ('26', '10', '人工智能');
INSERT INTO `res_user_resource_classify` VALUES ('27', '10', '区块链');
INSERT INTO `res_user_resource_classify` VALUES ('28', '10', '单片机');
INSERT INTO `res_user_resource_classify` VALUES ('29', '10', '大数据与云计算');
INSERT INTO `res_user_resource_classify` VALUES ('30', '10', '嵌入式');
INSERT INTO `res_user_resource_classify` VALUES ('31', '10', '平面设计');
INSERT INTO `res_user_resource_classify` VALUES ('32', '10', '微信公众号平台开发');
INSERT INTO `res_user_resource_classify` VALUES ('33', '10', '微信小程序');
INSERT INTO `res_user_resource_classify` VALUES ('34', '10', '必备软件');
INSERT INTO `res_user_resource_classify` VALUES ('35', '10', '手机UI');
INSERT INTO `res_user_resource_classify` VALUES ('36', '10', '数据库');
INSERT INTO `res_user_resource_classify` VALUES ('37', '10', '数据结构与算法');
INSERT INTO `res_user_resource_classify` VALUES ('38', '10', '易语言');
INSERT INTO `res_user_resource_classify` VALUES ('39', '10', '服务器');
INSERT INTO `res_user_resource_classify` VALUES ('40', '10', '汇编');
INSERT INTO `res_user_resource_classify` VALUES ('41', '10', '游戏开发');
INSERT INTO `res_user_resource_classify` VALUES ('42', '10', '物联网');
INSERT INTO `res_user_resource_classify` VALUES ('43', '10', '网页设计');
INSERT INTO `res_user_resource_classify` VALUES ('44', '10', '计算机基础');
INSERT INTO `res_user_resource_classify` VALUES ('45', '10', '计算机网络');
INSERT INTO `res_user_resource_classify` VALUES ('46', '10', '软件测试');
INSERT INTO `res_user_resource_classify` VALUES ('47', '10', '软考');
INSERT INTO `res_user_resource_classify` VALUES ('48', '10', '运维');
INSERT INTO `res_user_resource_classify` VALUES ('49', '10', '运营');
INSERT INTO `res_user_resource_classify` VALUES ('50', '10', '项目管理');
INSERT INTO `res_user_resource_classify` VALUES ('51', '10', '骇客');
INSERT INTO `res_user_resource_classify` VALUES ('52', '1', '国产');
INSERT INTO `res_user_resource_classify` VALUES ('53', '1', '日本');
INSERT INTO `res_user_resource_classify` VALUES ('54', '1', '美国');
INSERT INTO `res_user_resource_classify` VALUES ('55', '1', '其它');
INSERT INTO `res_user_resource_classify` VALUES ('56', '2', '动漫美图');
INSERT INTO `res_user_resource_classify` VALUES ('57', '2', '壁纸');
INSERT INTO `res_user_resource_classify` VALUES ('58', '2', '写真');
INSERT INTO `res_user_resource_classify` VALUES ('59', '3', '故事片/剧情片');
INSERT INTO `res_user_resource_classify` VALUES ('60', '3', '纪录片');
INSERT INTO `res_user_resource_classify` VALUES ('61', '3', '动画片/卡通片');
INSERT INTO `res_user_resource_classify` VALUES ('62', '3', '音乐歌舞片');
INSERT INTO `res_user_resource_classify` VALUES ('63', '3', '戏曲片');
INSERT INTO `res_user_resource_classify` VALUES ('64', '3', '舞台艺术片');
INSERT INTO `res_user_resource_classify` VALUES ('65', '3', '杂糅片');
INSERT INTO `res_user_resource_classify` VALUES ('66', '3', '短片');
INSERT INTO `res_user_resource_classify` VALUES ('67', '3', '动作片/武打片');
INSERT INTO `res_user_resource_classify` VALUES ('68', '3', '警匪片');
INSERT INTO `res_user_resource_classify` VALUES ('69', '3', '武侠片');
INSERT INTO `res_user_resource_classify` VALUES ('70', '3', '古装剧');
INSERT INTO `res_user_resource_classify` VALUES ('71', '3', '功夫片');
INSERT INTO `res_user_resource_classify` VALUES ('72', '3', '运动片');
INSERT INTO `res_user_resource_classify` VALUES ('73', '3', '战争片');
INSERT INTO `res_user_resource_classify` VALUES ('74', '3', '历史片');
INSERT INTO `res_user_resource_classify` VALUES ('75', '3', '灾难片');
INSERT INTO `res_user_resource_classify` VALUES ('76', '3', '冒险片');
INSERT INTO `res_user_resource_classify` VALUES ('77', '3', '西部片');
INSERT INTO `res_user_resource_classify` VALUES ('78', '3', '奇幻片');
INSERT INTO `res_user_resource_classify` VALUES ('79', '3', '科幻片');
INSERT INTO `res_user_resource_classify` VALUES ('80', '3', '公路片');
INSERT INTO `res_user_resource_classify` VALUES ('81', '3', '贺岁片');
INSERT INTO `res_user_resource_classify` VALUES ('82', '3', '喜剧片');
INSERT INTO `res_user_resource_classify` VALUES ('83', '3', '爱情片');
INSERT INTO `res_user_resource_classify` VALUES ('84', '3', '恐怖片');
INSERT INTO `res_user_resource_classify` VALUES ('85', '3', '悬疑片');
INSERT INTO `res_user_resource_classify` VALUES ('86', '3', '邪典片');
INSERT INTO `res_user_resource_classify` VALUES ('87', '3', '情色片/风月片');
INSERT INTO `res_user_resource_classify` VALUES ('88', '3', '色情片');
INSERT INTO `res_user_resource_classify` VALUES ('89', '3', '华语片');
INSERT INTO `res_user_resource_classify` VALUES ('90', '3', '美国片');
INSERT INTO `res_user_resource_classify` VALUES ('91', '3', '日本片');
INSERT INTO `res_user_resource_classify` VALUES ('92', '4', '古装');
INSERT INTO `res_user_resource_classify` VALUES ('93', '4', '都市');
INSERT INTO `res_user_resource_classify` VALUES ('94', '4', '言情');
INSERT INTO `res_user_resource_classify` VALUES ('95', '4', '武侠');
INSERT INTO `res_user_resource_classify` VALUES ('96', '4', '战争');
INSERT INTO `res_user_resource_classify` VALUES ('97', '4', '青春');
INSERT INTO `res_user_resource_classify` VALUES ('98', '4', '喜剧');
INSERT INTO `res_user_resource_classify` VALUES ('99', '4', '家庭');
INSERT INTO `res_user_resource_classify` VALUES ('100', '4', '伦理');
INSERT INTO `res_user_resource_classify` VALUES ('101', '4', '谍战');
INSERT INTO `res_user_resource_classify` VALUES ('102', '4', '军旅');
INSERT INTO `res_user_resource_classify` VALUES ('103', '4', '犯罪');
INSERT INTO `res_user_resource_classify` VALUES ('104', '4', '动作');
INSERT INTO `res_user_resource_classify` VALUES ('105', '4', '奇幻');
INSERT INTO `res_user_resource_classify` VALUES ('106', '4', '神话');
INSERT INTO `res_user_resource_classify` VALUES ('107', '4', '剧情');
INSERT INTO `res_user_resource_classify` VALUES ('108', '4', '历史');
INSERT INTO `res_user_resource_classify` VALUES ('109', '4', '经典');
INSERT INTO `res_user_resource_classify` VALUES ('110', '4', '乡村');
INSERT INTO `res_user_resource_classify` VALUES ('111', '4', '情景');
INSERT INTO `res_user_resource_classify` VALUES ('112', '4', '商战');
INSERT INTO `res_user_resource_classify` VALUES ('113', '4', '网剧');
INSERT INTO `res_user_resource_classify` VALUES ('114', '4', '其他');
INSERT INTO `res_user_resource_classify` VALUES ('115', '5', '国产');
INSERT INTO `res_user_resource_classify` VALUES ('116', '5', '日本');
INSERT INTO `res_user_resource_classify` VALUES ('117', '5', '美国');
INSERT INTO `res_user_resource_classify` VALUES ('118', '5', '其他');
INSERT INTO `res_user_resource_classify` VALUES ('119', '6', '玄幻');
INSERT INTO `res_user_resource_classify` VALUES ('120', '6', '奇幻');
INSERT INTO `res_user_resource_classify` VALUES ('121', '6', '武侠');
INSERT INTO `res_user_resource_classify` VALUES ('122', '6', '仙侠');
INSERT INTO `res_user_resource_classify` VALUES ('123', '6', '都市');
INSERT INTO `res_user_resource_classify` VALUES ('124', '6', '现实');
INSERT INTO `res_user_resource_classify` VALUES ('125', '6', '军事');
INSERT INTO `res_user_resource_classify` VALUES ('126', '6', '历史');
INSERT INTO `res_user_resource_classify` VALUES ('127', '6', '游戏');
INSERT INTO `res_user_resource_classify` VALUES ('128', '6', '体育');
INSERT INTO `res_user_resource_classify` VALUES ('129', '6', '科幻');
INSERT INTO `res_user_resource_classify` VALUES ('130', '6', '悬疑灵异');
INSERT INTO `res_user_resource_classify` VALUES ('131', '6', '二次元');
INSERT INTO `res_user_resource_classify` VALUES ('132', '6', '轻小说');
INSERT INTO `res_user_resource_classify` VALUES ('133', '8', '单机');
INSERT INTO `res_user_resource_classify` VALUES ('134', '8', '主机');
INSERT INTO `res_user_resource_classify` VALUES ('135', '8', '手游');
INSERT INTO `res_user_resource_classify` VALUES ('136', '8', '端游');
INSERT INTO `res_user_resource_classify` VALUES ('137', '6', 'gal');

-- ----------------------------
-- Table structure for `res_user_token`
-- ----------------------------
DROP TABLE IF EXISTS `res_user_token`;
CREATE TABLE `res_user_token` (
  `userID` int(10) unsigned NOT NULL COMMENT '用户id',
  `token` varchar(512) NOT NULL COMMENT '用户token',
  `limit` int(11) NOT NULL COMMENT 'token过期时间',
  `clientIp` varchar(256) NOT NULL COMMENT '客户端ip',
  UNIQUE KEY `userID` (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of res_user_token
-- ----------------------------
INSERT INTO `res_user_token` VALUES ('1', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9kZXYtcmVzb3VyY2UuY29tIiwiYXVkIjoiaHR0cDpcL1wvZGV2LXJlc291cmNlLmNvbVwvbG9naW4iLCJkYXRhIjoxfQ.tOBrBTYQBhlF6Lm6wO4BRYWhuo1LdKde-xZeq7sgqUw8yHi7eDQEcdSp4ev8EmA8ZqxYo-Och7puVC5Va4JwGW0OCESk-lOeSvccAH-FINRzd-kNmkKDJfH_CmuIP72Rz6Y0XsdZqjrtGgzzVZ630bQJlTBtB_FKSDK-07-DGAw', '1547100108', '127.0.0.1');
