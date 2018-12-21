/*
  等级信息表，存储每个等级用户的权限和升级所需经验
 */
CREATE TABLE `res_user_level`(
  `level` tinyint COMMENT '等级',
  `replyNums` tinyint COMMENT '每小时回复数',
  `postNums` tinyint COMMENT '每小时发帖数',
  `experience` mediumint UNSIGNED COMMENT '经验'
)ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*
  用户表
 */
CREATE TABLE `res_user`(
  `id` int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '用户id',
  `userName` VARCHAR(128) NOT NULL COMMENT '用户名',
  `password` VARCHAR(64) NOT NULL COMMENT '密码',
  `salt` VARCHAR(64) NOT NULL COMMENT '盐值',
  `email` VARCHAR(64) NOT NULL COMMENT '邮箱',
  `join` DATE NOT NULL COMMENT '注册日期',
  `level` tinyint DEFAULT 1 COMMENT '用户等级',
  `accumulatedLoginDays` mediumint UNSIGNED DEFAULT 0 COMMENT '累计登录天数',
  `consecutiveLoginDays` mediumint UNSIGNED DEFAULT 0 COMMENT '连续登录天数',
  `experience` mediumint UNSIGNED COMMENT '当前经验'
)ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*
  登录日志表
 */
CREATE TABLE `res_user_login_log`(
  `id` int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '日志id',
  `uid` int UNSIGNED NOT NULL COMMENT '用户id',
  `signIn` DATETIME NOT NULL COMMENT '登录时间'
)ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*
  用户操作表
 */
CREATE TABLE `res_user_action`(
  `actionID` int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '操作id',
  `id` int UNSIGNED NOT NULL COMMENT '用户id',
  `actionTime` DATETIME NOT NULL COMMENT '操作时间',
  `actionType` VARCHAR(32) NOT NULL COMMENT '操作类型'
)ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*
  用户token表
 */
CREATE TABLE `res_user_token`(
  `userID` int UNSIGNED NOT NULL COMMENT '用户id',
  `token` VARCHAR(256) NOT NULL COMMENT '用户token',
  `limit` DATETIME NOT NULL COMMENT 'token过期时间',
  `clientIp` VARCHAR(256) NOT NULL COMMENT '客户端ip'
)ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
