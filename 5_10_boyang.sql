# Host: localhost  (Version: 5.5.53)
# Date: 2019-05-16 16:39:31
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "ddsc_admin"
#

DROP TABLE IF EXISTS `ddsc_admin`;
CREATE TABLE `ddsc_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `pretime` datetime DEFAULT NULL,
  `curtime` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL COMMENT '登录IP',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '管理员类型 0超级管理员 1普通管理员',
  `control` text COMMENT '控制器权限',
  `way` text COMMENT '方法',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "ddsc_admin"
#

INSERT INTO `ddsc_admin` VALUES (1,'admin','8a30ec6807f71bc69d096d8e4d501ade','2019-05-15 08:54:48','2019-05-16 09:14:36','0.0.0.0',0,NULL,NULL);

#
# Structure for table "ddsc_analog"
#

DROP TABLE IF EXISTS `ddsc_analog`;
CREATE TABLE `ddsc_analog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `expl` varchar(255) DEFAULT NULL COMMENT '说明',
  `start_time` varchar(255) DEFAULT NULL COMMENT '开始时间',
  `end_time` varchar(255) DEFAULT NULL COMMENT '结束时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态 0已过去 1进行中',
  `time` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `sort` int(11) NOT NULL DEFAULT '50',
  `times` varchar(255) DEFAULT NULL COMMENT '答题时长',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='模拟练习';

#
# Data for table "ddsc_analog"
#

INSERT INTO `ddsc_analog` VALUES (3,'加强和改进机关党的建设1','限时60分钟10道题','1557763200','1557145600',0,'1557823703',1,'60'),(4,'加强和改进机关党的建设','限时60分钟10道题','1557763200','1559145600',1,'1557823703',1,'60'),(5,'加强和改进机关党的建设','限时60分钟10道题','1557763200','1559145600',1,'1557823703',1,'60'),(6,'加强和改进机关党的建设','限时60分钟10道题','1557763200','1559145600',1,'1557823703',1,'60'),(7,'测试','限时60分钟10道题','1557849600','1559232000',1,'1557913693',50,'60');

#
# Structure for table "ddsc_analog_log"
#

DROP TABLE IF EXISTS `ddsc_analog_log`;
CREATE TABLE `ddsc_analog_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '模拟练习id',
  `grade` int(11) NOT NULL DEFAULT '0' COMMENT '分数',
  `time` varchar(255) DEFAULT NULL COMMENT '用时',
  `times` varchar(255) DEFAULT NULL COMMENT '剩余时长',
  `num` varchar(255) DEFAULT NULL COMMENT '答到了第几道题',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '练习状态 0未完成 1已完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模拟练习的答题状态';

#
# Data for table "ddsc_analog_log"
#

INSERT INTO `ddsc_analog_log` VALUES (1,4,6,100,'1500','3000','1',2),(2,9,6,40,'0','3595','1',1);

#
# Structure for table "ddsc_analog_topic"
#

DROP TABLE IF EXISTS `ddsc_analog_topic`;
CREATE TABLE `ddsc_analog_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '模板id',
  `title` text COMMENT '题目名称',
  `option` text COMMENT '选项',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '题目类型 0单选 1多选 2填空',
  `answer` varchar(255) DEFAULT NULL COMMENT '正确答案',
  `content` text COMMENT '答案解析',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='题库';

#
# Data for table "ddsc_analog_topic"
#

INSERT INTO `ddsc_analog_topic` VALUES (5,6,'这是题目啊11','选项1,选项2,选项3,选项4',0,'选项1','<p>这是解析啊</p>',50),(6,6,'这是题目啊222','选项1,选项2,选项3,选项4',1,'选项1','<p>这是解析啊</p>',50),(7,6,'这是题目啊11','选项1,选项2,选项3,选项4',0,'选项1','<p>这是解析啊</p>',50),(8,6,'这是题目啊222','选项1,选项2,选项3,选项4',1,'选项1','<p>这是解析啊</p>',50),(9,6,'这是题目啊11','选项1,选项2,选项3,选项4',0,'选项1','<p>这是解析啊</p>',50),(10,6,'这是题目啊222','选项1,选项2,选项3,选项4',1,'选项1','<p>这是解析啊</p>',50),(11,6,'这是题目啊11','选项1,选项2,选项3,选项4',0,'选项1','<p>这是解析啊</p>',50),(12,6,'这是题目啊222','选项1,选项2,选项3,选项4',1,'选项1','<p>这是解析啊</p>',50),(13,6,'这是题目啊11','选项1,选项2,选项3,选项4',0,'选项1','<p>这是解析啊</p>',50),(14,6,'这是题目啊222','选项1,选项2,选项3,选项4',1,'选项1','<p>这是解析啊</p>',50);

#
# Structure for table "ddsc_analog_topic_log"
#

DROP TABLE IF EXISTS `ddsc_analog_topic_log`;
CREATE TABLE `ddsc_analog_topic_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '题目id',
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '模拟练习id',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '答题类型 0错误 1正确',
  `time` varchar(255) DEFAULT NULL COMMENT '答题时间',
  `content` varchar(255) DEFAULT NULL COMMENT '用户答案',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='模拟练习答题记录';

#
# Data for table "ddsc_analog_topic_log"
#

INSERT INTO `ddsc_analog_topic_log` VALUES (1,4,5,6,1,'1557975313','选项1'),(2,9,5,6,1,'1557991781','选项1'),(3,9,6,6,0,'1557991768','选项1,选项2'),(4,9,7,6,1,'1557989317','选项1'),(5,9,8,6,0,'1557989320','选项1,选项2'),(6,9,9,6,1,'1557989323','选项1'),(7,9,10,6,0,'1557989328','选项1,选项2'),(8,9,11,6,0,'1557989332','选项2'),(9,9,12,6,0,'1557989336','选项1,选项2'),(10,9,13,6,1,'1557989340','选项1'),(11,9,14,6,0,'1557989344','选项1,选项2');

#
# Structure for table "ddsc_browse"
#

DROP TABLE IF EXISTS `ddsc_browse`;
CREATE TABLE `ddsc_browse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL DEFAULT '0' COMMENT '新闻id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='浏览历史';

#
# Data for table "ddsc_browse"
#

INSERT INTO `ddsc_browse` VALUES (57,12,9),(61,11,9),(62,16,9),(63,9,9),(64,19,9),(65,10,9),(66,17,9),(70,16,10),(71,11,10),(73,19,10),(74,21,10),(75,18,10),(77,17,10),(78,12,10);

#
# Structure for table "ddsc_carte"
#

DROP TABLE IF EXISTS `ddsc_carte`;
CREATE TABLE `ddsc_carte` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) DEFAULT NULL COMMENT '模块名称',
  `c_modul` varchar(255) DEFAULT NULL COMMENT '控制器',
  `c_icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `pid` int(11) DEFAULT NULL COMMENT '上级id',
  `c_sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "ddsc_carte"
#

INSERT INTO `ddsc_carte` VALUES (1,'网站设置','Sys','fa-desktop',0,1),(2,'基本信息','seting','',1,1),(3,'网站优化','seo','',1,50),(4,'广告图管理','Lb','fa-picture-o',0,2),(5,'图片列表','lister','',4,50),(6,'广告位','place','',4,50),(13,'菜单管理','Carte','fa-reorder',0,3),(14,'后台模板','lister','',13,50),(16,'管理员管理','User','fa-user',0,4),(17,'管理员列表','lister','',16,50),(19,'会员管理','Member','fa-address-book-o',0,5),(20,'会员列表','lister','',19,50),(34,'日志管理','Log','fa-book',0,50),(36,'后台登录日志','index','',34,50),(90,'微信配置','Payment','fa-paypal',0,49),(91,'微信支付','wxpay','',90,50),(113,'单位列表','company','',19,50),(114,'认证管理','ident','',19,50),(115,'新闻管理','News','fa-cube',0,6),(116,'新闻列表','lister','',115,50),(117,'分类列表','type','',115,50),(118,'积分管理','Integ','fa-line-chart',0,7),(119,'积分规则','lister','',118,50),(120,'题库管理','Topic','fa-file',0,8),(121,'题目列表','lister','',120,50),(122,'每日答题','everyday','',120,50),(123,'模拟练习','analog','',120,50),(124,'积分排名','index','',118,50);

#
# Structure for table "ddsc_company"
#

DROP TABLE IF EXISTS `ddsc_company`;
CREATE TABLE `ddsc_company` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL COMMENT '单位名称',
  `csort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `cstatus` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态 0关闭 1开启',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='单位列表';

#
# Data for table "ddsc_company"
#

INSERT INTO `ddsc_company` VALUES (3,'单位名称1',50,1),(4,'单位名称2',50,1),(5,'单位名称3',50,1);

#
# Structure for table "ddsc_integ"
#

DROP TABLE IF EXISTS `ddsc_integ`;
CREATE TABLE `ddsc_integ` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `integ` int(11) NOT NULL DEFAULT '0' COMMENT '赠送积分',
  `toplimit` int(11) NOT NULL DEFAULT '0' COMMENT '每日上限',
  `mins` int(11) NOT NULL DEFAULT '0' COMMENT '累计时长',
  `desc` varchar(255) DEFAULT NULL COMMENT '介绍',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='积分规则';

#
# Data for table "ddsc_integ"
#

INSERT INTO `ddsc_integ` VALUES (1,1,1,0,'1分/每日首次登陆'),(2,1,6,0,'1分/每有效阅读一个'),(3,1,6,0,'1分/每有效观看一个'),(4,1,6,2,'1分/有效阅读文章累计2分钟'),(5,1,6,2,'1分/有效观看视频累计3分钟'),(6,2,6,1,'每组答题非满分积1分、答题满分积2分');

#
# Structure for table "ddsc_integ_log"
#

DROP TABLE IF EXISTS `ddsc_integ_log`;
CREATE TABLE `ddsc_integ_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `integ` int(11) NOT NULL DEFAULT '0' COMMENT '积分数量',
  `content` varchar(255) DEFAULT NULL COMMENT '备注',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '类型 0减少 1增加',
  `time` varchar(255) DEFAULT NULL COMMENT '获取时间',
  `types` tinyint(3) NOT NULL DEFAULT '0' COMMENT '积分获取类型 1登录 2阅读 3观看视频 4累计阅读时长 5累计观看时长 6智能答题 7每日答题',
  `nid` int(11) NOT NULL DEFAULT '0' COMMENT '文章id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='积分日志';

#
# Data for table "ddsc_integ_log"
#

INSERT INTO `ddsc_integ_log` VALUES (1,3,1,'登陆',1,'1557714579',1,0),(2,9,1,'登陆',1,'1557729884',1,0),(15,3,1,'观看视频',1,'1557731364',3,11),(20,3,1,'观看视频',1,'1557731766',3,14),(21,3,1,'视频学习时长',1,'1557731766',5,14),(22,3,1,'阅读文章',1,'1557731808',2,12),(23,3,1,'阅读文章',1,'1557731813',2,13),(24,3,1,'文章学习时长',1,'1557731813',4,13),(25,9,1,'登陆',1,'1557803477',1,0),(26,10,1,'阅读文章',1,'1557804080',2,21),(27,10,1,'阅读文章',1,'1557804131',2,19),(28,9,1,'阅读文章',1,'1557805246',2,19),(29,10,1,'阅读文章',1,'1557813535',2,18),(30,10,1,'观看视频',1,'1557813552',3,14),(31,9,1,'阅读文章',1,'1557813674',2,17),(32,9,1,'阅读文章',1,'1557813679',2,12),(33,9,1,'观看视频',1,'1557813695',3,11),(34,9,1,'观看视频',1,'1557813699',3,14),(35,9,1,'阅读文章',1,'1557813723',2,16),(36,9,1,'阅读文章',1,'1557813731',2,9),(37,9,1,'阅读文章',1,'1557813740',2,10),(38,10,1,'阅读文章',1,'1557824400',2,16),(39,10,1,'观看视频',1,'1557824406',3,11),(40,10,1,'阅读文章',1,'1557826843',2,17),(41,10,1,'阅读文章',1,'1557826904',2,12),(42,9,1,'登陆',1,'1557887386',1,0),(43,4,1,'每日答题',1,'1557903800',7,0),(44,4,1,'每日答题',1,'1557903840',7,0),(45,4,1,'智能答题',1,'1557911310',6,0),(46,4,1,'智能答题',1,'1557911369',6,0),(47,4,1,'智能答题',1,'1557911383',6,0),(48,4,1,'智能答题',1,'1557911384',6,0),(49,4,1,'智能答题',1,'1557911385',6,0),(50,4,1,'智能答题',1,'1557911386',6,0),(51,9,1,'登陆',1,'1557971857',1,0),(52,9,1,'智能答题',1,'1557975833',6,0),(53,9,1,'智能答题',1,'1557976068',6,0),(54,9,1,'智能答题',1,'1557977846',6,0);

#
# Structure for table "ddsc_integ_time"
#

DROP TABLE IF EXISTS `ddsc_integ_time`;
CREATE TABLE `ddsc_integ_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `times` int(11) NOT NULL DEFAULT '0' COMMENT '累计时长',
  `time` varchar(255) DEFAULT NULL COMMENT '日期',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '类型 0文章 1视频',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='阅读时长';

#
# Data for table "ddsc_integ_time"
#

INSERT INTO `ddsc_integ_time` VALUES (1,3,0,'1557731364',1),(2,3,0,'1557731809',0),(3,10,0,'1557804080',0),(4,9,0,'1557805246',0),(5,10,0,'1557813552',1),(6,9,0,'1557813695',1);

#
# Structure for table "ddsc_lb"
#

DROP TABLE IF EXISTS `ddsc_lb`;
CREATE TABLE `ddsc_lb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT NULL COMMENT '父类id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态0关闭 1开启',
  `url` varchar(255) DEFAULT NULL,
  `desc` text COMMENT '简介',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告列表';

#
# Data for table "ddsc_lb"
#

INSERT INTO `ddsc_lb` VALUES (1,1,'注册协议',50,1,'','<p>用户注册协议用户注册协议用户注册协议用户注册协议用户注册协议用户注册协议用户注册协议用户注册协议用户注册协议用户注册协议用户注册协议用户注册协议用户注册协议</p>',NULL),(2,2,'实名认证未认证提示语',50,1,'','<p><span style=\"color: rgb(14, 23, 38); font-family: &quot;PingFang SC&quot;, -apple-system, BlinkMacSystemFont, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Hiragino Sans GB&quot;, &quot;Source Han Sans&quot;, &quot;Noto Sans CJK Sc&quot;, &quot;Microsoft YaHei&quot;, &quot;Microsoft Jhenghei&quot;, sans-serif; font-size: 14px; background-color: rgb(244, 247, 253);\">需填写实名认证信息，认证后才能参与答题\n积分。未认证学员不能参与答题积分。&nbsp;</span></p>',NULL),(3,3,'实名认证已提交提示语',50,1,'','<p>你的申请已提交,等待系统审核,如需修改请重新提交</p>',NULL),(4,4,'实名认证已驳回提示语',50,1,'','<p>认证驳回,请重新添加提交</p>',NULL),(5,5,'实名认证已成功提示语',50,1,'','<p>恭喜你认证成功</p>',NULL),(6,6,'制度设定',50,1,'','<p>&nbsp;学习积分是“伯洋商贸”学习平台对用户通过本平台进行学习的行为分析数据，也是兑换奖励的依据。本学习积分规则设计制定和技术开发的知识产权由“伯洋商贸”学习平台所有。<br/></p><p>&nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><br/></p>',NULL),(7,7,'4',50,1,'','',NULL);

#
# Structure for table "ddsc_lb_place"
#

DROP TABLE IF EXISTS `ddsc_lb_place`;
CREATE TABLE `ddsc_lb_place` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '轮播id',
  `pl_name` varchar(255) DEFAULT NULL COMMENT '位置名称',
  PRIMARY KEY (`pl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告位';

#
# Data for table "ddsc_lb_place"
#

INSERT INTO `ddsc_lb_place` VALUES (1,'用户注册协议'),(2,'未认证提示语'),(3,'已提交提示语'),(4,'已驳回提示语'),(5,'审核成功提示语'),(6,'积分制度'),(7,'正确题数');

#
# Structure for table "ddsc_news"
#

DROP TABLE IF EXISTS `ddsc_news`;
CREATE TABLE `ddsc_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `title` varchar(255) DEFAULT NULL COMMENT '新闻标题',
  `source` varchar(255) DEFAULT NULL COMMENT '新闻来源',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `content` longtext COMMENT '新闻详情',
  `time` varchar(255) DEFAULT NULL COMMENT '发布时间',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '推荐 0否 1是',
  `banner` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'banner图推荐 0否 1是',
  `is_delete` tinyint(3) NOT NULL DEFAULT '0',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '布局类型 0无图 1小图 2大图',
  `news_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '新闻类型 0文字新闻 2视频新闻',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='新闻列表';

#
# Data for table "ddsc_news"
#

INSERT INTO `ddsc_news` VALUES (9,4,'习近平：一个国家、一个民族不能没有灵魂','新华网11','/uploads/20190511/07833f3734f5b2d46a5ada6ddb9d2e43.png','<p>&nbsp; &nbsp; &nbsp; 2019年3月4日下午，中共中央总书记、国家主席、中央军委主席习近平看望参加全国政协十三届二次会议的文化艺术界、社会科学界委员，并参加联组会，听取意见和建议。 新华社记者 姚大伟/摄</p>','1557541184',50,1,0,0,0,0),(10,5,'习近平回信勉励云南贡山独龙族群众','人民日报','/uploads/20190511/768dbfed1ce564aa02e20d213b2ae86f.png','<p>习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众</p>','1557541184',1,0,1,0,0,0),(11,6,'习近平：一个国家、一个民族不能没有灵魂','新华网11','/uploads/20190511/07833f3734f5b2d46a5ada6ddb9d2e43.png','<p>&nbsp; &nbsp; &nbsp; 2019年3月4日下午，中共中央总书记、国家主席、中央军委主席习近平看望参加全国政协十三届二次会议的文化艺术界、社会科学界委员，并参加联组会，听取意见和建议。 新华社记者 姚大伟/摄</p>','1557541184',50,1,0,0,0,1),(12,7,'习近平回信勉励云南贡山独龙族群众','人民日报','/uploads/20190511/768dbfed1ce564aa02e20d213b2ae86f.png','<p>习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众</p>','1557541184',1,0,1,0,0,0),(13,8,'习近平回信勉励云南贡山独龙族群众','人民日报','/uploads/20190511/768dbfed1ce564aa02e20d213b2ae86f.png','<p>习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众</p>','1557541184',1,0,1,0,0,0),(14,4,'习近平：一个国家、一个民族不能没有灵魂','新华网11','/uploads/20190511/07833f3734f5b2d46a5ada6ddb9d2e43.png','<p>&nbsp; &nbsp; &nbsp; 2019年3月4日下午，中共中央总书记、国家主席、中央军委主席习近平看望参加全国政协十三届二次会议的文化艺术界、社会科学界委员，并参加联组会，听取意见和建议。 新华社记者 姚大伟/摄</p>','1557541184',50,1,0,0,0,1),(15,5,'习近平回信勉励云南贡山独龙族群众','人民日报','/uploads/20190511/768dbfed1ce564aa02e20d213b2ae86f.png','<p>习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众</p>','1557541184',1,0,1,0,0,0),(16,6,'习近平：一个国家、一个民族不能没有灵魂','新华网11','/uploads/20190511/07833f3734f5b2d46a5ada6ddb9d2e43.png','<p>&nbsp; &nbsp; &nbsp; 2019年3月4日下午，中共中央总书记、国家主席、中央军委主席习近平看望参加全国政协十三届二次会议的文化艺术界、社会科学界委员，并参加联组会，听取意见和建议。 新华社记者 姚大伟/摄</p>','1557541184',50,1,0,0,2,0),(17,7,'习近平回信勉励云南贡山独龙族群众','人民日报','/uploads/20190511/768dbfed1ce564aa02e20d213b2ae86f.png','<p>习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众</p>','1557541184',1,0,1,0,0,0),(18,8,'习近平回信勉励云南贡山独龙族群众','人民日报','/uploads/20190511/768dbfed1ce564aa02e20d213b2ae86f.png','<p>习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众</p>','1557541184',1,0,1,0,0,0),(19,4,'习近平：一个国家、一个民族不能没有灵魂','新华网11','/uploads/20190511/07833f3734f5b2d46a5ada6ddb9d2e43.png','<p>&nbsp; &nbsp; &nbsp; 2019年3月4日下午，中共中央总书记、国家主席、中央军委主席习近平看望参加全国政协十三届二次会议的文化艺术界、社会科学界委员，并参加联组会，听取意见和建议。 新华社记者 姚大伟/摄</p>','1557541184',50,1,0,0,1,0),(20,5,'习近平回信勉励云南贡山独龙族群众','人民日报','/uploads/20190511/768dbfed1ce564aa02e20d213b2ae86f.png','<p>习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众</p>','1557541184',1,0,1,-1,0,0),(21,6,'习近平：一个国家、一个民族不能没有灵魂','新华网11','/uploads/20190511/07833f3734f5b2d46a5ada6ddb9d2e43.png','<p>&nbsp; &nbsp; &nbsp; 2019年3月4日下午，中共中央总书记、国家主席、中央军委主席习近平看望参加全国政协十三届二次会议的文化艺术界、社会科学界委员，并参加联组会，听取意见和建议。 新华社记者 姚大伟/摄</p>','1557541184',50,1,0,0,0,0),(22,7,'习近平回信勉励云南贡山独龙族群众','人民日报','/uploads/20190511/768dbfed1ce564aa02e20d213b2ae86f.png','<p>习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众</p>','1557541184',1,0,1,-1,0,0),(23,8,'习近平回信勉励云南贡山独龙族群众','人民日报','/uploads/20190511/768dbfed1ce564aa02e20d213b2ae86f.png','<p>习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众习近平回信勉励云南贡山独龙族群众</p>','1557541184',1,0,1,-1,0,0);

#
# Structure for table "ddsc_news_type"
#

DROP TABLE IF EXISTS `ddsc_news_type`;
CREATE TABLE `ddsc_news_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) DEFAULT NULL,
  `type_sort` int(11) NOT NULL DEFAULT '50',
  `type_is_delete` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='新闻分类';

#
# Data for table "ddsc_news_type"
#

INSERT INTO `ddsc_news_type` VALUES (4,'要闻',1,0),(5,'新思想',2,0),(6,'综合',3,0),(7,'快闪',4,0),(8,'发布',5,0);

#
# Structure for table "ddsc_payment"
#

DROP TABLE IF EXISTS `ddsc_payment`;
CREATE TABLE `ddsc_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(255) DEFAULT NULL,
  `mchid` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `appsecret` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='支付配置';

#
# Data for table "ddsc_payment"
#

INSERT INTO `ddsc_payment` VALUES (1,'wxe7b1e50fa5dec3b3','','','097e861dc7dee1e0313a05230993444d');

#
# Structure for table "ddsc_power"
#

DROP TABLE IF EXISTS `ddsc_power`;
CREATE TABLE `ddsc_power` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `tid` text COMMENT '题库id',
  `time` varchar(255) DEFAULT NULL COMMENT '时间',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='智能答题';

#
# Data for table "ddsc_power"
#

INSERT INTO `ddsc_power` VALUES (2,'2019年05月15日智能答题','4,5,9,12,21','1557909002',4),(21,'2019年05月16日智能答题','6,17,19,20,22','1557977808',9);

#
# Structure for table "ddsc_power_log"
#

DROP TABLE IF EXISTS `ddsc_power_log`;
CREATE TABLE `ddsc_power_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '题目id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '智能答题id',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '答题类型 0错误 1正确',
  `time` varchar(255) DEFAULT NULL COMMENT '答题时间',
  `content` varchar(255) DEFAULT NULL COMMENT '用户答案',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='智能答题记录';

#
# Data for table "ddsc_power_log"
#

INSERT INTO `ddsc_power_log` VALUES (1,4,4,2,0,'1557910319','生产安全,政治安全'),(2,4,5,2,0,'1557910323','生产安全,政治安全'),(3,4,9,2,0,'1557910327','生产安全,政治安全'),(4,4,12,2,1,'1557910427','政治安全'),(5,4,21,2,0,'1557910457','政治安全'),(20,9,6,21,0,'1557977816','政治安全'),(21,9,17,21,0,'1557977824','选项1,选项2'),(22,9,19,21,0,'1557977832','选项1,选项2'),(23,9,20,21,1,'1557977837','选项1'),(24,9,22,21,1,'1557977840','选项1');

#
# Structure for table "ddsc_seo"
#

DROP TABLE IF EXISTS `ddsc_seo`;
CREATE TABLE `ddsc_seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '首页标题',
  `keywords` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `description` text COMMENT 'seo描述',
  `copy` text COMMENT '版权信息',
  `code` text COMMENT '统计代码',
  `support` varchar(255) DEFAULT NULL COMMENT '技术支持',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站优化';

#
# Data for table "ddsc_seo"
#

INSERT INTO `ddsc_seo` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL);

#
# Structure for table "ddsc_sms_code"
#

DROP TABLE IF EXISTS `ddsc_sms_code`;
CREATE TABLE `ddsc_sms_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `code` varchar(255) DEFAULT NULL COMMENT '验证码',
  `time` varchar(255) DEFAULT NULL COMMENT '发送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='手机验证码';

#
# Data for table "ddsc_sms_code"
#

INSERT INTO `ddsc_sms_code` VALUES (1,'13140185716','329765','1557735891');

#
# Structure for table "ddsc_sys"
#

DROP TABLE IF EXISTS `ddsc_sys`;
CREATE TABLE `ddsc_sys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `username` varchar(255) DEFAULT NULL COMMENT '负责人',
  `url` varchar(255) DEFAULT NULL COMMENT '网站域名',
  `qq` char(20) DEFAULT NULL COMMENT '客服QQ',
  `icp` varchar(255) DEFAULT NULL COMMENT 'icp备案号',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `tel` varchar(255) DEFAULT NULL COMMENT '固定电话',
  `phone` char(11) DEFAULT NULL COMMENT '手机号码',
  `longs` varchar(255) DEFAULT NULL COMMENT '经度',
  `lats` varchar(255) DEFAULT NULL COMMENT '纬度',
  `addr` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `content` text COMMENT '公司简介',
  `pclogo` varchar(255) DEFAULT NULL COMMENT '电脑端logo',
  `waplogo` varchar(255) DEFAULT NULL COMMENT '手机端logo',
  `qrcode` varchar(255) DEFAULT NULL COMMENT '微信二维码',
  `wx` varchar(255) DEFAULT NULL COMMENT '微信公众号',
  `fax` varchar(255) DEFAULT NULL COMMENT '公司传真',
  `telphone` varchar(255) DEFAULT NULL COMMENT '400电话',
  `follow` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站基本信息';

#
# Data for table "ddsc_sys"
#

INSERT INTO `ddsc_sys` VALUES (1,'河南伯洋商贸有限公司','','','','','','','','','','','<p>关于我们关于我们</p>','/uploads/20190511/2e8cf609feb5b03a23e3afed2ad5b8eb.png',NULL,NULL,NULL,'','',0);

#
# Structure for table "ddsc_sys_log"
#

DROP TABLE IF EXISTS `ddsc_sys_log`;
CREATE TABLE `ddsc_sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL COMMENT '类型',
  `time` datetime DEFAULT NULL COMMENT '操作时间',
  `admin` varchar(255) DEFAULT NULL COMMENT '操作账号',
  `ip` varchar(255) DEFAULT NULL COMMENT 'IP地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统日志';

#
# Data for table "ddsc_sys_log"
#

INSERT INTO `ddsc_sys_log` VALUES (1,'后台登录','2019-05-10 09:42:36','admin','0.0.0.0'),(2,'后台登录','2019-05-11 09:05:30','admin','0.0.0.0'),(3,'后台登录','2019-05-13 08:49:09','admin','0.0.0.0'),(4,'后台登录','2019-05-14 09:10:35','admin','0.0.0.0'),(5,'后台登录','2019-05-15 08:54:48','admin','0.0.0.0'),(6,'后台登录','2019-05-16 09:14:36','admin','0.0.0.0');

#
# Structure for table "ddsc_topic"
#

DROP TABLE IF EXISTS `ddsc_topic`;
CREATE TABLE `ddsc_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COMMENT '题目名称',
  `option` text COMMENT '选项',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '题目类型 0单选 1多选 2填空',
  `answer` varchar(255) DEFAULT NULL COMMENT '正确答案',
  `content` text COMMENT '答案解析',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='题库';

#
# Data for table "ddsc_topic"
#

INSERT INTO `ddsc_topic` VALUES (4,'      习近平总书记枪呆，要从维护国家[ ]、[ ]、[ ]的高度，加强网络内容建设，使全媒体传播在法治轨道上运行。要全面提升技术知网能力和水平，规范数据资源利用，防范大数据等新技术带来的风险。','政治安全 ,生产安全 , 文化安全 ,社会安全',1,'政治安全 ,生产安全','<p><br/></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;习近平在重庆主持召开解决“两不愁三保障”突出问题座谈会。座谈会上，广西、重庆、四川、贵州、云南、陕西、甘肃、新疆等地党委书记作书面汇报，重庆市石柱土家族自治县县委书记蹇泽西，奉节县平安乡党委书记邹远珍，城口县周溪乡凉风村党支部书记伍东，</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><br/></p>',50),(5,'这道题目的111正确答案是();','政治安全 ,生产安全 , 文化安全 ,社会安全',0,'政治安全 ','<p>&nbsp;习近平在重庆主持召开解决“两不愁三保障”突出问题座谈会。座谈会上，广西、重庆、四川、贵州、云南、陕西、甘肃、新疆等地党委书记作书面汇报，重庆市石柱土家族自治县县委书记蹇泽西，奉节县平安乡党委书记邹远珍，城口县周溪乡凉风村党支部书记伍东，<br/></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><br/></p>',50),(6,'填空题的正确答案是()','',2,'政治安全 ','<p>填空题的正确答案是()</p>',50),(7,'      习近平总书记枪呆，要从维护国家[ ]、[ ]、[ ]的高度，加强网络内容建设，使全媒体传播在法治轨道上运行。要全面提升技术知网能力和水平，规范数据资源利用，防范大数据等新技术带来的风险。','政治安全 ,生产安全 , 文化安全 ,社会安全',1,'政治安全,生产安全','<p><br/></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;习近平在重庆主持召开解决“两不愁三保障”突出问题座谈会。座谈会上，广西、重庆、四川、贵州、云南、陕西、甘肃、新疆等地党委书记作书面汇报，重庆市石柱土家族自治县县委书记蹇泽西，奉节县平安乡党委书记邹远珍，城口县周溪乡凉风村党支部书记伍东，</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><br/></p>',50),(8,'这道题目的111正确答案是();','政治安全 ,生产安全 , 文化安全 ,社会安全',0,'政治安全 ','<p>&nbsp;习近平在重庆主持召开解决“两不愁三保障”突出问题座谈会。座谈会上，广西、重庆、四川、贵州、云南、陕西、甘肃、新疆等地党委书记作书面汇报，重庆市石柱土家族自治县县委书记蹇泽西，奉节县平安乡党委书记邹远珍，城口县周溪乡凉风村党支部书记伍东，<br/></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><br/></p>',50),(9,'填空题的正确答案是()','',2,'政治安全 ','<p>填空题的正确答案是()</p>',50),(10,'      习近平总书记枪呆，要从维护国家[ ]、[ ]、[ ]的高度，加强网络内容建设，使全媒体传播在法治轨道上运行。要全面提升技术知网能力和水平，规范数据资源利用，防范大数据等新技术带来的风险。','政治安全 ,生产安全 , 文化安全 ,社会安全',1,'政治安全 ,生产安全','<p><br/></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;习近平在重庆主持召开解决“两不愁三保障”突出问题座谈会。座谈会上，广西、重庆、四川、贵州、云南、陕西、甘肃、新疆等地党委书记作书面汇报，重庆市石柱土家族自治县县委书记蹇泽西，奉节县平安乡党委书记邹远珍，城口县周溪乡凉风村党支部书记伍东，</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><br/></p>',50),(11,'这道题目的111正确答案是();','政治安全 ,生产安全 , 文化安全 ,社会安全',0,'政治安全 ','<p>&nbsp;习近平在重庆主持召开解决“两不愁三保障”突出问题座谈会。座谈会上，广西、重庆、四川、贵州、云南、陕西、甘肃、新疆等地党委书记作书面汇报，重庆市石柱土家族自治县县委书记蹇泽西，奉节县平安乡党委书记邹远珍，城口县周溪乡凉风村党支部书记伍东，<br/></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><br/></p>',50),(12,'填空题的正确答案是()','',2,'政治安全','<p>填空题的正确答案是()</p>',50),(17,'这是题目啊','选项1,选项2,选项3,选项4',1,'选项1','这是解析啊',50),(18,'这是题目啊','选项1,选项2,选项3,选项4',0,'选项1','这是解析啊',50),(19,'这是题目啊','选项1,选项2,选项3,选项4',1,'选项1','这是解析啊',50),(20,'这是题目啊','选项1,选项2,选项3,选项4',0,'选项1','这是解析啊',50),(21,'这是题目啊','选项1,选项2,选项3,选项4',1,'选项1','这是解析啊',50),(22,'这是题目啊','选项1,选项2,选项3,选项4',0,'选项1','这是解析啊',50),(23,'这是题目啊','选项1,选项2,选项3,选项4',1,'选项1','这是解析啊',50);

#
# Structure for table "ddsc_topic_day"
#

DROP TABLE IF EXISTS `ddsc_topic_day`;
CREATE TABLE `ddsc_topic_day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `tid` text COMMENT '题库id',
  `time` varchar(255) DEFAULT NULL COMMENT '时间',
  `statu` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否过期 0否 1是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='每日答题';

#
# Data for table "ddsc_topic_day"
#

INSERT INTO `ddsc_topic_day` VALUES (3,'2019年05月12日答题','4,5,7,8,10,12,18,19,21,23','1557814918',1),(4,'2019年05月13日答题','4,5,7,8,10,12,18,19,21,23,17,20,9,6','1557814918',1),(5,'2019年05月14日答题','4,5,7,8,10,12,18,19,21,23,11','1557814918',1),(6,'2019年05月15日答题','7,9,10,11,12,17,18,19,22,23','1557883895',1),(7,'2019年05月16日答题','4,6,7,9,11,12,18,19,20,23','1557992361',0);

#
# Structure for table "ddsc_topic_day_log"
#

DROP TABLE IF EXISTS `ddsc_topic_day_log`;
CREATE TABLE `ddsc_topic_day_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `did` int(11) NOT NULL DEFAULT '0' COMMENT '每天id',
  `integ` int(11) NOT NULL DEFAULT '0' COMMENT '所得积分',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '几星',
  `times` varchar(255) DEFAULT NULL COMMENT '答题时长',
  `time` varchar(255) DEFAULT NULL COMMENT '时间',
  `acc` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '正确率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='每日答题记录';

#
# Data for table "ddsc_topic_day_log"
#

INSERT INTO `ddsc_topic_day_log` VALUES (3,4,5,1,2,'60','1557903800',50.00),(4,4,6,1,2,'60','1557903800',50.00),(5,9,6,0,2,'57','1557913592',40.00),(6,9,7,0,2,'79','1557992720',40.00);

#
# Structure for table "ddsc_topic_log"
#

DROP TABLE IF EXISTS `ddsc_topic_log`;
CREATE TABLE `ddsc_topic_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '题目id',
  `did` int(11) NOT NULL DEFAULT '0' COMMENT '每日答题id',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '答题类型 0错误 1正确',
  `time` varchar(255) DEFAULT NULL COMMENT '答题时间',
  `content` varchar(255) DEFAULT NULL COMMENT '用户答案',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='每日答题记录';

#
# Data for table "ddsc_topic_log"
#

INSERT INTO `ddsc_topic_log` VALUES (1,4,7,6,1,'1557900594','生产安全,政治安全'),(2,4,9,6,0,'1557900752','生产安全,政治安全'),(3,4,10,6,0,'1557900762','生产安全,政治安全'),(4,4,11,6,1,'1557900767','生产安全,政治安全'),(5,4,12,6,1,'1557900783','生产安全,政治安全'),(6,4,17,6,1,'1557900793','生产安全,政治安全'),(7,4,18,6,1,'1557900820','选项1'),(8,4,19,6,1,'1557900824','选项1'),(9,4,22,6,1,'1557900833','选项1'),(10,4,23,6,1,'1557900837','选项1'),(11,9,7,6,0,'1557986296','选项1'),(12,9,9,6,0,'1557986304','选项1'),(13,9,10,6,0,'1557986308','选项1,选项2'),(14,9,11,6,0,'1557986313','选项1'),(15,9,12,6,0,'1557986321','选项1,选项2'),(16,9,17,6,0,'1557913572','选项1,选项2'),(17,9,18,6,1,'1557913576','选项1'),(18,9,19,6,0,'1557913580','选项1,选项2'),(19,9,22,6,1,'1557913583','选项1'),(20,9,23,6,0,'1557913588','选项1,选项2'),(21,9,5,6,0,'1557986280','选项1'),(22,9,6,6,0,'1557986289','选项1,选项2'),(23,9,8,6,0,'1557986301','选项1,选项2'),(24,9,4,7,0,'1557992648','政治安全,生产安全'),(25,9,6,7,0,'1557992664','政治安全'),(26,9,7,7,1,'1557992670','政治安全,生产安全'),(27,9,9,7,0,'1557992677','政治安全'),(28,9,11,7,0,'1557992682','政治安全'),(29,9,12,7,1,'1557992692','政治安全'),(30,9,18,7,1,'1557992696','选项1'),(31,9,19,7,0,'1557992705','选项1,选项2'),(32,9,20,7,1,'1557992711','选项1'),(33,9,23,7,0,'1557992716','选项1,选项2');

#
# Structure for table "ddsc_user"
#

DROP TABLE IF EXISTS `ddsc_user`;
CREATE TABLE `ddsc_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称',
  `time` varchar(255) DEFAULT NULL COMMENT '注册时间',
  `image` text COMMENT '头像',
  `openid` varchar(255) DEFAULT NULL COMMENT '用户的openID',
  `phone` char(11) DEFAULT NULL COMMENT '手机号码',
  `pwd` varchar(255) DEFAULT NULL COMMENT '登录密码',
  `company_id` int(11) NOT NULL DEFAULT '0' COMMENT '单位id',
  `company` varchar(255) DEFAULT NULL COMMENT '单位名称',
  `job` varchar(255) DEFAULT NULL COMMENT '职务',
  `username` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `idcode` varchar(255) DEFAULT NULL COMMENT '身份证号码',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态 0未认证 1认证审核中 2认证成功 3认证驳回',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '账号类型 0微信用户 1手机号注册',
  `integ` int(11) NOT NULL DEFAULT '0' COMMENT '学习积分',
  `apply_time` varchar(255) DEFAULT NULL COMMENT '认证时间',
  `oper_time` varchar(255) DEFAULT NULL COMMENT '审核通过/驳回时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户列表';

#
# Data for table "ddsc_user"
#

INSERT INTO `ddsc_user` VALUES (3,'','1557459388','','','15939590207','123456',3,'单位名称2','经理','张三','412824199303203918',1,1,24,'1557486385','1557476030'),(4,'','1557459388','','','15939590207','123456',5,'单位名称3','PHP程序员','王鹏飞','412824199303203918',3,1,8,'','1557476033'),(5,'','1557459388','','','15939590207','123456',5,'单位名称3','PHP程序员','王鹏飞','412824199303203918',3,1,0,'','1557476038'),(6,'','1557459388','','','15939590207','123456',5,'单位名称3','PHP程序员','王鹏飞','412824199303203918',1,1,0,'','1557475718'),(7,'','1557459388','','','15939590207','123456',5,'单位名称3','PHP程序员','王鹏飞','412824199303203918',1,1,0,'','1557475787'),(8,NULL,'1557477363',NULL,NULL,'16603829557','123456',4,'单位名称2','PHP程序员','admin','412824199303203918',2,0,0,'1557477363','1557477363'),(9,NULL,'1557557470',NULL,NULL,'18614956315','123',3,'单位名称1','职务','测试','412825199707181827',1,1,15,'1557822605',NULL),(10,'LMX','1557971825','https://wx.qlogo.cn/mmopen/vi_32/R3hqLVBsbjXfqRzyBx3e3ebmHPHibiaJiauN10GQzicicvdB021RhoL5AXR4Zy0Kxtuy0P5F6sYl9Qaia0nFY720ib0sQ/132','oZXvX5RhdNXkap3M7IF-_-jtno3A',NULL,NULL,4,'单位名称1','经理','张三','411428199701086424',2,0,8,'1557716486','1557987540');
