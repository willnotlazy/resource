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
  `experience` mediumint UNSIGNED COMMENT '当前经验',
  `couldLogin` tinyint NOT NULL DEFAULT 1 COMMENT '是否可以登录',
  `isLogin` tinyint NOT NULL DEFAULT 0 COMMENT '是否已经登录'
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

/*
  帖子表
 */
CREATE TABLE `res_user_post`(
  `postID` int UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '帖子id',
  `authorID` int UNSIGNED NOT NULL COMMENT '作者',
  `title` VARCHAR(256) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `postAddress` VARCHAR(256) COMMENT '帖子地址',
  `classify` VARCHAR(64) NOT NULL COMMENT '分类',
  `postTime` int NOT NULL COMMENT '发帖时间',
  `couldPost` tinyint NOT NULL DEFAULT 0 COMMENT '是否允许发布',
  `isEffective` tinyint NOT NULL DEFAULT 0 COMMENT '是否有效',
  `checked` VARCHAR(64) COMMENT '审核者',
  `checkStatus` VARCHAR(16) COMMENT '审核状态'
)ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;



/*
  分类表
 */


CREATE TABLE `res_user_resource_classify`(
  `classifyID`  tinyint UNSIGNED PRIMARY KEY NOT NULL COMMENT '分类id',
  `pid` tinyint UNSIGNED DEFAULT 0 COMMENT '父类id',
  `name` varchar(128) NOT NULL COMMENT '分类名'
)ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


insert into `res_user_resource_classify` values(1,0,'动漫动画');
insert into `res_user_resource_classify` values(2,0,'图片');
insert into `res_user_resource_classify` values(3,0,'电影');
insert into `res_user_resource_classify` values(4,0,'电视剧');
insert into `res_user_resource_classify` values(5,0,'漫画');
insert into `res_user_resource_classify` values(6,0,'小说');
insert into `res_user_resource_classify` values(8,0,'游戏');
insert into `res_user_resource_classify` values(10,0,'IT视频');
insert into `res_user_resource_classify` values(11,10,'android');
insert into `res_user_resource_classify` values(12,10,'c/c++');
insert into `res_user_resource_classify` values(13,10,'c#');
insert into `res_user_resource_classify` values(14,10,'go');
insert into `res_user_resource_classify` values(15,10,'html5');
insert into `res_user_resource_classify` values(16,10,'ios');
insert into `res_user_resource_classify` values(17,10,'javaweb');
insert into `res_user_resource_classify` values(18,10,'Linux');
insert into `res_user_resource_classify` values(19,10,'php');
insert into `res_user_resource_classify` values(20,10,'python');
insert into `res_user_resource_classify` values(21,10,'ruby');
insert into `res_user_resource_classify` values(22,10,'web前端');
insert into `res_user_resource_classify` values(23,10,'window phone8');
insert into `res_user_resource_classify` values(24,10,'wordpress');
insert into `res_user_resource_classify` values(25,10,'产品');
insert into `res_user_resource_classify` values(26,10,'人工智能');
insert into `res_user_resource_classify` values(27,10,'区块链');
insert into `res_user_resource_classify` values(28,10,'单片机');
insert into `res_user_resource_classify` values(29,10,'大数据与云计算');
insert into `res_user_resource_classify` values(30,10,'嵌入式');
insert into `res_user_resource_classify` values(31,10,'平面设计');
insert into `res_user_resource_classify` values(32,10,'微信公众号平台开发');
insert into `res_user_resource_classify` values(33,10,'微信小程序');
insert into `res_user_resource_classify` values(34,10,'必备软件');
insert into `res_user_resource_classify` values(35,10,'手机UI');
insert into `res_user_resource_classify` values(36,10,'数据库');
insert into `res_user_resource_classify` values(37,10,'数据结构与算法');
insert into `res_user_resource_classify` values(38,10,'易语言');
insert into `res_user_resource_classify` values(39,10,'服务器');
insert into `res_user_resource_classify` values(40,10,'汇编');
insert into `res_user_resource_classify` values(41,10,'游戏开发');
insert into `res_user_resource_classify` values(42,10,'物联网');
insert into `res_user_resource_classify` values(43,10,'网页设计');
insert into `res_user_resource_classify` values(44,10,'计算机基础');
insert into `res_user_resource_classify` values(45,10,'计算机网络');
insert into `res_user_resource_classify` values(46,10,'软件测试');
insert into `res_user_resource_classify` values(47,10,'软考');
insert into `res_user_resource_classify` values(48,10,'运维');
insert into `res_user_resource_classify` values(49,10,'运营');
insert into `res_user_resource_classify` values(50,10,'项目管理');
insert into `res_user_resource_classify` values(51,10,'骇客');

insert into `res_user_resource_classify` values(52,1,'国产');
insert into `res_user_resource_classify` values(53,1,'日本');
insert into `res_user_resource_classify` values(54,1,'美国');
insert into `res_user_resource_classify` values(55,1,'其它');

insert into `res_user_resource_classify` values(56,2,'动漫美图');
insert into `res_user_resource_classify` values(57,2,'壁纸');
insert into `res_user_resource_classify` values(58,2,'写真');

insert into `res_user_resource_classify` values(59,3,'故事片/剧情片');
insert into `res_user_resource_classify` values(60,3,'纪录片');
insert into `res_user_resource_classify` values(61,3,'动画片/卡通片');
insert into `res_user_resource_classify` values(62,3,'音乐歌舞片');
insert into `res_user_resource_classify` values(63,3,'戏曲片');
insert into `res_user_resource_classify` values(64,3,'舞台艺术片');
insert into `res_user_resource_classify` values(65,3,'杂糅片');
insert into `res_user_resource_classify` values(66,3,'短片');
insert into `res_user_resource_classify` values(67,3,'动作片/武打片');
insert into `res_user_resource_classify` values(68,3,'警匪片');
insert into `res_user_resource_classify` values(69,3,'武侠片');
insert into `res_user_resource_classify` values(70,3,'古装剧');
insert into `res_user_resource_classify` values(71,3,'功夫片');
insert into `res_user_resource_classify` values(72,3,'运动片');
insert into `res_user_resource_classify` values(73,3,'战争片');
insert into `res_user_resource_classify` values(74,3,'历史片');
insert into `res_user_resource_classify` values(75,3,'灾难片');
insert into `res_user_resource_classify` values(76,3,'冒险片');
insert into `res_user_resource_classify` values(77,3,'西部片');
insert into `res_user_resource_classify` values(78,3,'奇幻片');
insert into `res_user_resource_classify` values(79,3,'科幻片');
insert into `res_user_resource_classify` values(80,3,'公路片');
insert into `res_user_resource_classify` values(81,3,'贺岁片');
insert into `res_user_resource_classify` values(82,3,'喜剧片');
insert into `res_user_resource_classify` values(83,3,'爱情片');
insert into `res_user_resource_classify` values(84,3,'恐怖片');
insert into `res_user_resource_classify` values(85,3,'悬疑片');
insert into `res_user_resource_classify` values(86,3,'邪典片');
insert into `res_user_resource_classify` values(87,3,'情色片/风月片');
insert into `res_user_resource_classify` values(88,3,'色情片');
insert into `res_user_resource_classify` values(89,3,'华语片');
insert into `res_user_resource_classify` values(90,3,'美国片');
insert into `res_user_resource_classify` values(91,3,'日本片');


insert into `res_user_resource_classify` values(92,4,'古装');
insert into `res_user_resource_classify` values(93,4,'都市');
insert into `res_user_resource_classify` values(94,4,'言情');
insert into `res_user_resource_classify` values(95,4,'武侠');
insert into `res_user_resource_classify` values(96,4,'战争');
insert into `res_user_resource_classify` values(97,4,'青春');
insert into `res_user_resource_classify` values(98,4,'喜剧');
insert into `res_user_resource_classify` values(99,4,'家庭');
insert into `res_user_resource_classify` values(100,4,'伦理');
insert into `res_user_resource_classify` values(101,4,'谍战');
insert into `res_user_resource_classify` values(102,4,'军旅');
insert into `res_user_resource_classify` values(103,4,'犯罪');
insert into `res_user_resource_classify` values(104,4,'动作');
insert into `res_user_resource_classify` values(105,4,'奇幻');
insert into `res_user_resource_classify` values(106,4,'神话');
insert into `res_user_resource_classify` values(107,4,'剧情');
insert into `res_user_resource_classify` values(108,4,'历史');
insert into `res_user_resource_classify` values(109,4,'经典');
insert into `res_user_resource_classify` values(110,4,'乡村');
insert into `res_user_resource_classify` values(111,4,'情景');
insert into `res_user_resource_classify` values(112,4,'商战');
insert into `res_user_resource_classify` values(113,4,'网剧');
insert into `res_user_resource_classify` values(114,4,'其他');

insert into `res_user_resource_classify` values(115,5,'国产');
insert into `res_user_resource_classify` values(116,5,'日本');
insert into `res_user_resource_classify` values(117,5,'美国');
insert into `res_user_resource_classify` values(118,5,'其他');


insert into `res_user_resource_classify` values(119,6,'玄幻');
insert into `res_user_resource_classify` values(120,6,'奇幻');
insert into `res_user_resource_classify` values(121,6,'武侠');
insert into `res_user_resource_classify` values(122,6,'仙侠');
insert into `res_user_resource_classify` values(123,6,'都市');
insert into `res_user_resource_classify` values(124,6,'现实');
insert into `res_user_resource_classify` values(125,6,'军事');
insert into `res_user_resource_classify` values(126,6,'历史');
insert into `res_user_resource_classify` values(127,6,'游戏');
insert into `res_user_resource_classify` values(128,6,'体育');
insert into `res_user_resource_classify` values(129,6,'科幻');
insert into `res_user_resource_classify` values(130,6,'悬疑灵异');
insert into `res_user_resource_classify` values(131,6,'二次元');
insert into `res_user_resource_classify` values(132,6,'轻小说');

insert into `res_user_resource_classify` values(133,8,'单机');
insert into `res_user_resource_classify` values(134,8,'主机');
insert into `res_user_resource_classify` values(135,8,'手游');
insert into `res_user_resource_classify` values(136,8,'端游');
insert into `res_user_resource_classify` values(137,6,'gal');



CREATE TABLE `res_view_history`(
  `uid` int UNSIGNED DEFAULT 0,
  `clientIP` varchar(256) DEFAULT NULL,
  `postid` int UNSIGNED NOT NULL,
  `viewtime` int UNSIGNED NOT NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;