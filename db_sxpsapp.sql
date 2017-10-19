/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : db_sxpsapp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-10-19 15:40:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dy_cart`
-- ----------------------------
DROP TABLE IF EXISTS `dy_cart`;
CREATE TABLE `dy_cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车id',
  `buyer_id` int(11) NOT NULL COMMENT '买家id',
  `cart_info` text NOT NULL COMMENT '购物车商品信息',
  `bl_id` mediumint(9) NOT NULL COMMENT '组合套装ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_cart
-- ----------------------------
INSERT INTO `dy_cart` VALUES ('1', '1', '[]', '0');

-- ----------------------------
-- Table structure for `dy_config`
-- ----------------------------
DROP TABLE IF EXISTS `dy_config`;
CREATE TABLE `dy_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '网站基本信息配置',
  `oauth` varchar(250) NOT NULL COMMENT '授权登陆页面',
  `sitename` varchar(50) NOT NULL DEFAULT '' COMMENT '网站名称',
  `hotsearch` varchar(250) NOT NULL,
  `header` text NOT NULL COMMENT '全局代码',
  `logo1` varchar(50) NOT NULL COMMENT '网站logo',
  `logo2` varchar(50) NOT NULL DEFAULT '' COMMENT '网站底部logo',
  `img1` varchar(50) NOT NULL COMMENT '一般为二维码',
  `file` varchar(50) NOT NULL,
  `siteurl` varchar(100) NOT NULL DEFAULT '' COMMENT '网站地址',
  `siteurl_wap` varchar(100) NOT NULL,
  `webqq` varchar(255) NOT NULL DEFAULT '' COMMENT '网站qq',
  `link1` varchar(255) NOT NULL,
  `link2` varchar(255) NOT NULL,
  `link3` varchar(255) NOT NULL,
  `link4` varchar(255) NOT NULL,
  `link5` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL DEFAULT '',
  `tel` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `fax` varchar(50) NOT NULL COMMENT '传真',
  `address` varchar(500) NOT NULL,
  `filetype` varchar(50) NOT NULL DEFAULT '' COMMENT '上传文件类型',
  `filesize` mediumint(9) NOT NULL DEFAULT '0' COMMENT '上传文件大小',
  `pictype` varchar(50) NOT NULL DEFAULT '' COMMENT '上传图片类型',
  `picsize` mediumint(9) NOT NULL DEFAULT '0' COMMENT '上传图片大小',
  `seotitle` varchar(100) NOT NULL DEFAULT '' COMMENT '网站标题',
  `keywords` varchar(250) NOT NULL DEFAULT '' COMMENT '网站关键字',
  `description` text NOT NULL COMMENT '网站描述',
  `indexabout` varchar(250) NOT NULL DEFAULT '',
  `indexcontact` varchar(250) NOT NULL DEFAULT '',
  `copyright` text NOT NULL COMMENT '网站版权信息',
  `icpcode` varchar(50) NOT NULL COMMENT '备案号',
  `isStatic` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '纯静态',
  `isPseudoStatic` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启伪静态',
  `isstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '网站是否关闭状态',
  `showinfo` varchar(100) NOT NULL DEFAULT '' COMMENT '网站要显示的内容',
  `appid` varchar(200) NOT NULL COMMENT '公众号',
  `appsecret` varchar(200) NOT NULL COMMENT '公众号秘钥',
  `access_token` varchar(500) NOT NULL COMMENT '自定义token',
  `jsapi_ticket` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config` (`isstate`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_config
-- ----------------------------
INSERT INTO `dy_config` VALUES ('1', '', '生鲜配送', '', '统计代码', '2017083016004698.png', '2017052414011241.jpg', '2017083017355190.png', '2017083115390156.png', '', '', '1807873511', '商品未满200元无法下单', '', '', '', '', '1807873511', '', '', '200', '11', 'csv|zip|rar|7z|png', '20480', 'png|jpg|jpeg|gif', '2048', '', '', '', '', '', 'Copyright © 2013-2015 版权：厦门威虎科技有限公司 闽ICP备13018059号-3 网站地图|RSS订阅 微信互动游戏开发 站长统计', '', '0', '0', '0', '', '', '', '', '');

-- ----------------------------
-- Table structure for `dy_goods`
-- ----------------------------
DROP TABLE IF EXISTS `dy_goods`;
CREATE TABLE `dy_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id(SKU)',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_name_added` varchar(50) NOT NULL COMMENT '商品补充',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `category_id_1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类id',
  `category_id_2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级分类id',
  `category_id_3` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '三级分类id',
  `group_id_array` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺分类id 首尾用,隔开',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品原价格',
  `promotion_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品促销价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费 0为免运费',
  `shipping_fee_id` int(11) NOT NULL DEFAULT '0' COMMENT '售卖区域id 物流模板id  ns_order_shipping_fee 表id',
  `stock` int(10) NOT NULL DEFAULT '0' COMMENT '商品库存',
  `size` varchar(30) NOT NULL COMMENT '规格',
  `max_buy` int(11) NOT NULL DEFAULT '0' COMMENT '限购 0 不限购',
  `hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品点击数量',
  `min_stock_alarm` int(11) NOT NULL DEFAULT '0' COMMENT '库存预警值',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售数量',
  `collects` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `star` tinyint(3) unsigned NOT NULL DEFAULT '5' COMMENT '好评星级',
  `evaluates` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评价数',
  `shares` int(11) NOT NULL DEFAULT '0' COMMENT '分享数',
  `img1` varchar(40) NOT NULL DEFAULT '0' COMMENT '商品主图',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '商品关键词',
  `introduction` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简介',
  `content` text NOT NULL COMMENT '商品详情',
  `QRcode` varchar(255) NOT NULL DEFAULT '' COMMENT '商品二维码',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '商家编号',
  `is_stock_visible` int(1) NOT NULL DEFAULT '0' COMMENT '页面不显示库存',
  `is_hot` int(1) NOT NULL DEFAULT '0' COMMENT '是否热销商品',
  `is_recommend` int(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `is_new` int(1) NOT NULL DEFAULT '0' COMMENT '是否新品',
  `is_pre-sale` int(1) NOT NULL DEFAULT '0' COMMENT '是否预售',
  `is_bill` int(1) NOT NULL DEFAULT '0' COMMENT '是否开具增值税发票 1是，0否',
  `isstate` tinyint(3) NOT NULL DEFAULT '1' COMMENT '商品状态 0下架，1正常，10违规（禁售）',
  `sale_date` datetime NOT NULL COMMENT '上下架时间',
  `sendtime` int(11) NOT NULL COMMENT '商品添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '商品编辑时间',
  `disorder` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `real_sales` int(10) NOT NULL DEFAULT '0' COMMENT '实际销量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16554 COMMENT='商品表';

-- ----------------------------
-- Records of dy_goods
-- ----------------------------
INSERT INTO `dy_goods` VALUES ('1', '精品五花肉', '9.90/袋（10斤）', '0', '4', '4', '0', '', '19.90', '39.90', '0.00', '18.00', '0.00', '0', '15', '500g/包', '0', '77', '0', '15', '0', '5', '0', '0', '2017101609144382.png', '', '', '&lt;div&gt;\r\n	&lt;img src=&quot;/style/img/style/img/listxq_10.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_13.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_14.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_17.jpg&quot; /&gt; \r\n&lt;/div&gt;\r\n&lt;div style=&quot;margin-top:0.3rem;&quot;&gt;\r\n	&lt;img src=&quot;/style/img/listxq_20.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_22.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_23.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_24.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_25.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_27.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_29.jpg&quot; /&gt; &lt;img src=&quot;/style/img/listxq_36.jpg&quot; /&gt; \r\n&lt;/div&gt;', '', '', '0', '0', '0', '0', '0', '0', '1', '0000-00-00 00:00:00', '1507903467', '2017-10-16 09:18:06', '0', '0');
INSERT INTO `dy_goods` VALUES ('2', '精品五花肉', '9.90/袋（10斤）', '0', '4', '4', '0', '', '1.10', '2.30', '0.00', '0.50', '0.00', '0', '15', '500g/包', '0', '3', '0', '200', '20', '5', '0', '0', '2017101609250853.png', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0000-00-00 00:00:00', '1508117050', '2017-10-16 09:25:08', '0', '0');
INSERT INTO `dy_goods` VALUES ('3', '精品五花肉', '9.90/袋（10斤）', '0', '4', '4', '0', '', '1.10', '2.30', '0.00', '0.50', '0.00', '0', '15', '500g/包', '0', '1', '0', '200', '20', '5', '0', '0', '2017101609252271.png', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0000-00-00 00:00:00', '1508117050', '2017-10-16 09:25:22', '0', '0');
INSERT INTO `dy_goods` VALUES ('4', '精品五花肉', '9.90/袋（10斤）', '0', '4', '4', '0', '', '1.10', '2.30', '0.00', '0.50', '0.00', '0', '15', '500g/包', '0', '0', '0', '200', '20', '5', '0', '0', '2017101609254048.png', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0000-00-00 00:00:00', '1508117050', '2017-10-16 09:25:40', '0', '0');
INSERT INTO `dy_goods` VALUES ('5', '精品五花肉', '9.90/袋（10斤）', '0', '4', '4', '0', '', '1.10', '2.30', '0.00', '0.50', '0.00', '0', '15', '500g/包', '0', '0', '0', '200', '20', '5', '0', '0', '0', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0000-00-00 00:00:00', '1508117050', '2017-10-16 09:25:01', '0', '0');
INSERT INTO `dy_goods` VALUES ('6', '精品五花肉', '9.90/袋（10斤）', '0', '4', '4', '0', '', '1.10', '2.30', '0.00', '0.50', '0.00', '0', '15', '500g/包', '0', '0', '0', '200', '20', '5', '0', '0', '0', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0000-00-00 00:00:00', '1508117050', '2017-10-16 09:25:01', '0', '0');

-- ----------------------------
-- Table structure for `dy_login`
-- ----------------------------
DROP TABLE IF EXISTS `dy_login`;
CREATE TABLE `dy_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员登录记录表',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `isstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否成功状态',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `sendtime` varchar(10) NOT NULL DEFAULT '' COMMENT '登录时间',
  PRIMARY KEY (`id`),
  KEY `log` (`username`,`sendtime`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_login
-- ----------------------------
INSERT INTO `dy_login` VALUES ('1', 'Hidden', '', '0', '127.0.0.1', '1507598134');
INSERT INTO `dy_login` VALUES ('2', 'Hidden', '', '0', '127.0.0.1', '1507598460');
INSERT INTO `dy_login` VALUES ('3', 'Hidden', '', '0', '127.0.0.1', '1507708058');
INSERT INTO `dy_login` VALUES ('4', 'Hidden', '', '0', '127.0.0.1', '1507718061');
INSERT INTO `dy_login` VALUES ('5', 'Hidden', '', '0', '127.0.0.1', '1507778356');
INSERT INTO `dy_login` VALUES ('6', 'Hidden', '', '0', '127.0.0.1', '1507778357');
INSERT INTO `dy_login` VALUES ('7', 'Hidden', '', '0', '127.0.0.1', '1507778358');

-- ----------------------------
-- Table structure for `dy_logs`
-- ----------------------------
DROP TABLE IF EXISTS `dy_logs`;
CREATE TABLE `dy_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员操作日志表',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `content` varchar(100) NOT NULL DEFAULT '' COMMENT '操作内容',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `sendtime` varchar(10) NOT NULL DEFAULT '' COMMENT '操作时间',
  `order` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `logs` (`username`,`sendtime`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_logs
-- ----------------------------
INSERT INTO `dy_logs` VALUES ('1', 'Hidden', '添加信息: 菜叶类', '127.0.0.1', '1507872878', '0');
INSERT INTO `dy_logs` VALUES ('2', 'Hidden', '添加信息: 1', '127.0.0.1', '1507881571', '0');
INSERT INTO `dy_logs` VALUES ('3', 'Hidden', '添加信息: 1', '127.0.0.1', '1507881571', '0');
INSERT INTO `dy_logs` VALUES ('4', 'Hidden', '添加信息: 1', '127.0.0.1', '1507881572', '0');
INSERT INTO `dy_logs` VALUES ('5', 'Hidden', '添加信息: 1', '127.0.0.1', '1507881572', '0');
INSERT INTO `dy_logs` VALUES ('6', 'Hidden', '添加信息: 1', '127.0.0.1', '1507881918', '0');
INSERT INTO `dy_logs` VALUES ('7', 'Hidden', '更新信息: 2', '127.0.0.1', '1507882123', '0');
INSERT INTO `dy_logs` VALUES ('8', 'Hidden', '添加商品: ', '127.0.0.1', '1507901232', '0');
INSERT INTO `dy_logs` VALUES ('9', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507902706', '0');
INSERT INTO `dy_logs` VALUES ('10', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507902750', '0');
INSERT INTO `dy_logs` VALUES ('11', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507902773', '0');
INSERT INTO `dy_logs` VALUES ('12', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507902786', '0');
INSERT INTO `dy_logs` VALUES ('13', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507903226', '0');
INSERT INTO `dy_logs` VALUES ('14', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507904483', '0');
INSERT INTO `dy_logs` VALUES ('15', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507905597', '0');
INSERT INTO `dy_logs` VALUES ('16', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507906522', '0');
INSERT INTO `dy_logs` VALUES ('17', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507906689', '0');
INSERT INTO `dy_logs` VALUES ('18', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507907124', '0');
INSERT INTO `dy_logs` VALUES ('19', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507908385', '0');
INSERT INTO `dy_logs` VALUES ('20', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507908533', '0');
INSERT INTO `dy_logs` VALUES ('21', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1507908722', '0');
INSERT INTO `dy_logs` VALUES ('22', 'Hidden', '添加栏目分类常见问题', '127.0.0.1', '1507962863', '0');
INSERT INTO `dy_logs` VALUES ('23', 'Hidden', '添加信息: 如何购买商品？', '127.0.0.1', '1507963329', '0');
INSERT INTO `dy_logs` VALUES ('24', 'Hidden', '添加信息: 如何购买商品？', '127.0.0.1', '1507963339', '0');
INSERT INTO `dy_logs` VALUES ('25', 'Hidden', '添加信息: 如何购买商品？', '127.0.0.1', '1507963340', '0');
INSERT INTO `dy_logs` VALUES ('26', 'Hidden', '添加信息: 如何购买商品？', '127.0.0.1', '1507963340', '0');
INSERT INTO `dy_logs` VALUES ('27', 'Hidden', '添加信息: 如何购买商品？', '127.0.0.1', '1507963340', '0');
INSERT INTO `dy_logs` VALUES ('28', 'Hidden', '添加信息: 如何购买商品？', '127.0.0.1', '1507963340', '0');
INSERT INTO `dy_logs` VALUES ('29', 'Hidden', '添加信息: 如何购买商品？', '127.0.0.1', '1507963341', '0');
INSERT INTO `dy_logs` VALUES ('30', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1508116483', '0');
INSERT INTO `dy_logs` VALUES ('31', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1508116686', '0');
INSERT INTO `dy_logs` VALUES ('32', 'Hidden', '添加商品: 精品五花肉', '127.0.0.1', '1508117100', '0');
INSERT INTO `dy_logs` VALUES ('33', 'Hidden', '添加商品: 精品五花肉', '127.0.0.1', '1508117101', '0');
INSERT INTO `dy_logs` VALUES ('34', 'Hidden', '添加商品: 精品五花肉', '127.0.0.1', '1508117101', '0');
INSERT INTO `dy_logs` VALUES ('35', 'Hidden', '添加商品: 精品五花肉', '127.0.0.1', '1508117101', '0');
INSERT INTO `dy_logs` VALUES ('36', 'Hidden', '添加商品: 精品五花肉', '127.0.0.1', '1508117101', '0');
INSERT INTO `dy_logs` VALUES ('37', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1508117108', '0');
INSERT INTO `dy_logs` VALUES ('38', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1508117122', '0');
INSERT INTO `dy_logs` VALUES ('39', 'Hidden', '更新商品: 精品五花肉', '127.0.0.1', '1508117140', '0');
INSERT INTO `dy_logs` VALUES ('40', 'Hidden', '编辑系统信息', '127.0.0.1', '1508319010', '0');
INSERT INTO `dy_logs` VALUES ('41', 'Hidden', '编辑系统信息', '127.0.0.1', '1508330432', '0');
INSERT INTO `dy_logs` VALUES ('42', 'Hidden', '编辑系统信息', '127.0.0.1', '1508330437', '0');
INSERT INTO `dy_logs` VALUES ('43', 'Hidden', '编辑系统信息', '127.0.0.1', '1508330786', '0');
INSERT INTO `dy_logs` VALUES ('44', 'Hidden', '编辑系统信息', '127.0.0.1', '1508330833', '0');
INSERT INTO `dy_logs` VALUES ('45', 'Hidden', '编辑系统信息', '127.0.0.1', '1508342753', '0');

-- ----------------------------
-- Table structure for `dy_manager`
-- ----------------------------
DROP TABLE IF EXISTS `dy_manager`;
CREATE TABLE `dy_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员表',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `realname` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `bigmymenu` varchar(255) NOT NULL DEFAULT '' COMMENT '大栏目权限',
  `smallmymenu` varchar(255) NOT NULL DEFAULT '' COMMENT '小栏目权限',
  `login_num` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `uniques` int(10) NOT NULL DEFAULT '0',
  `isstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '帐号状态',
  `sendtime` varchar(10) NOT NULL DEFAULT '' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `manager` (`username`,`isstate`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_manager
-- ----------------------------
INSERT INTO `dy_manager` VALUES ('1', 'admin', '0192023a7bbd73250516f069df18b500', '超级管理员', 'super', 'super', '5', '0', '1', '1401328990');

-- ----------------------------
-- Table structure for `dy_message`
-- ----------------------------
DROP TABLE IF EXISTS `dy_message`;
CREATE TABLE `dy_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realname` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(20) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(50) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `type` tinyint(3) NOT NULL COMMENT '区分不同表单',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `isstate` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sendtime` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_message
-- ----------------------------

-- ----------------------------
-- Table structure for `dy_news`
-- ----------------------------
DROP TABLE IF EXISTS `dy_news`;
CREATE TABLE `dy_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新闻表',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类id',
  `ty` mediumint(8) NOT NULL DEFAULT '0' COMMENT '二级分类id',
  `tty` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '三级分类',
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '标题',
  `ftitle` varchar(250) NOT NULL DEFAULT '',
  `price` varchar(50) NOT NULL DEFAULT '',
  `dotlike` int(11) unsigned NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '作者',
  `relative` varchar(200) NOT NULL,
  `source` varchar(250) NOT NULL COMMENT '来源',
  `linkurl` varchar(250) NOT NULL DEFAULT '' COMMENT '跳链接',
  `introduce` text COMMENT '摘要',
  `content` longtext COMMENT '内容',
  `content2` text NOT NULL,
  `content3` text NOT NULL,
  `content4` text NOT NULL,
  `content5` text NOT NULL,
  `img1` varchar(100) NOT NULL COMMENT '标题图片',
  `img2` varchar(30) NOT NULL DEFAULT '',
  `img3` varchar(30) NOT NULL DEFAULT '',
  `img4` varchar(50) NOT NULL DEFAULT '',
  `img5` varchar(50) NOT NULL DEFAULT '',
  `img6` varchar(50) NOT NULL DEFAULT '',
  `file` varchar(50) NOT NULL COMMENT '附件',
  `hits` mediumint(9) NOT NULL DEFAULT '0' COMMENT '点击数',
  `seotitle` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` longtext,
  `isgood` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `istop` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `istop2` int(11) NOT NULL,
  `isstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示',
  `disorder` mediumint(9) NOT NULL DEFAULT '0' COMMENT '排序',
  `sendtime` varchar(30) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `news` (`pid`,`ty`,`title`,`isgood`,`isstate`,`disorder`,`sendtime`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_news
-- ----------------------------
INSERT INTO `dy_news` VALUES ('1', '3', '7', '0', '#', '', '', '0', '', '', '', '#', '', '', '', '', '', '', '2017101211191680.jpg', '', '', '', '', '', '', '3', '', '', '', '0', '0', '0', '1', '0', '1507778172');
INSERT INTO `dy_news` VALUES ('2', '3', '7', '0', '#', '', '', '0', '', '', '', '#', '', '', '', '', '', '', '2017101211191771.jpg', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507778172');
INSERT INTO `dy_news` VALUES ('3', '3', '7', '0', '#', '', '', '0', '', '', '', '#', '', '', '', '', '', '', '2017101211191840.jpg', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507778172');
INSERT INTO `dy_news` VALUES ('4', '1', '4', '0', '菜叶类', '', '', '0', '', '', '', '', '', '', '', '', '', '', 'nav1.jpg', '', '', '', '', '', '', '123', '', '', '', '0', '0', '0', '1', '0', '1507872845');
INSERT INTO `dy_news` VALUES ('5', '1', '4', '0', '根茎类', '', '', '0', '', '', '', '', '', '', '', '', '', '', 'nav2.jpg', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507881567');
INSERT INTO `dy_news` VALUES ('6', '1', '4', '0', '茄果类', '', '', '0', '', '', '', '', '', '', '', '', '', '', 'nav3.jpg', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507881567');
INSERT INTO `dy_news` VALUES ('7', '1', '4', '0', '豆类', '', '', '0', '', '', '', '', '', '', '', '', '', '', 'nav4.jpg', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507881567');
INSERT INTO `dy_news` VALUES ('8', '1', '4', '0', '菌类', '', '', '0', '', '', '', '', '', '', '', '', '', '', 'nav5.jpg', '', '', '', '', '', '', '3', '', '', '', '0', '0', '0', '1', '0', '1507881567');
INSERT INTO `dy_news` VALUES ('9', '1', '4', '0', '葱姜蒜', '', '', '0', '', '', '', '', '', '', '', '', '', '', 'nav6.jpg', '', '', '', '', '', '', '2', '', '', '', '0', '0', '0', '1', '0', '1507881916');
INSERT INTO `dy_news` VALUES ('10', '3', '17', '0', '如何购买商品？', '', '', '0', '', '', '', '', '', '&lt;h3&gt;\r\n	1)首先打开app，主要方式有：\r\n&lt;/h3&gt;\r\n&lt;p&gt;\r\n	(一)打开客户端；\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	(二)进入页面之后，选择地址，选购商品加入购物车；\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	(三)点击商品去结算\r\n&lt;/p&gt;', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507963298');
INSERT INTO `dy_news` VALUES ('11', '3', '17', '0', '如何购买商品？', '', '', '0', '', '', '', '', '', '&lt;h3&gt;1)首先打开app，主要方式有：&lt;/h3&gt;\r\n					&lt;p&gt;(一)打开客户端；&lt;/p&gt;\r\n					&lt;p&gt;(二)进入页面之后，选择地址，选购商品加入购物车；&lt;/p&gt;\r\n					&lt;p&gt;(三)点击商品去结算&lt;/p&gt;', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507963332');
INSERT INTO `dy_news` VALUES ('12', '3', '17', '0', '如何购买商品？', '', '', '0', '', '', '', '', '', '&lt;h3&gt;1)首先打开app，主要方式有：&lt;/h3&gt;\r\n					&lt;p&gt;(一)打开客户端；&lt;/p&gt;\r\n					&lt;p&gt;(二)进入页面之后，选择地址，选购商品加入购物车；&lt;/p&gt;\r\n					&lt;p&gt;(三)点击商品去结算&lt;/p&gt;', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507963332');
INSERT INTO `dy_news` VALUES ('13', '3', '17', '0', '如何购买商品？', '', '', '0', '', '', '', '', '', '&lt;h3&gt;1)首先打开app，主要方式有：&lt;/h3&gt;\r\n					&lt;p&gt;(一)打开客户端；&lt;/p&gt;\r\n					&lt;p&gt;(二)进入页面之后，选择地址，选购商品加入购物车；&lt;/p&gt;\r\n					&lt;p&gt;(三)点击商品去结算&lt;/p&gt;', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507963332');
INSERT INTO `dy_news` VALUES ('14', '3', '17', '0', '如何购买商品？', '', '', '0', '', '', '', '', '', '&lt;h3&gt;1)首先打开app，主要方式有：&lt;/h3&gt;\r\n					&lt;p&gt;(一)打开客户端；&lt;/p&gt;\r\n					&lt;p&gt;(二)进入页面之后，选择地址，选购商品加入购物车；&lt;/p&gt;\r\n					&lt;p&gt;(三)点击商品去结算&lt;/p&gt;', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507963332');
INSERT INTO `dy_news` VALUES ('15', '3', '17', '0', '如何购买商品？', '', '', '0', '', '', '', '', '', '&lt;h3&gt;1)首先打开app，主要方式有：&lt;/h3&gt;\r\n					&lt;p&gt;(一)打开客户端；&lt;/p&gt;\r\n					&lt;p&gt;(二)进入页面之后，选择地址，选购商品加入购物车；&lt;/p&gt;\r\n					&lt;p&gt;(三)点击商品去结算&lt;/p&gt;', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507963332');
INSERT INTO `dy_news` VALUES ('16', '3', '17', '0', '如何购买商品？', '', '', '0', '', '', '', '', '', '&lt;h3&gt;1)首先打开app，主要方式有：&lt;/h3&gt;\r\n					&lt;p&gt;(一)打开客户端；&lt;/p&gt;\r\n					&lt;p&gt;(二)进入页面之后，选择地址，选购商品加入购物车；&lt;/p&gt;\r\n					&lt;p&gt;(三)点击商品去结算&lt;/p&gt;', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '0', '0', '0', '1', '0', '1507963332');

-- ----------------------------
-- Table structure for `dy_news_cats`
-- ----------------------------
DROP TABLE IF EXISTS `dy_news_cats`;
CREATE TABLE `dy_news_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新闻分类表',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '一级Id',
  `catname` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `catname2` varchar(50) NOT NULL DEFAULT '',
  `contentTemplate` int(11) NOT NULL,
  `img1` varchar(50) NOT NULL DEFAULT '',
  `img2` varchar(50) NOT NULL,
  `img3` varchar(50) NOT NULL,
  `pagesize` tinyint(3) unsigned NOT NULL DEFAULT '8' COMMENT '分页数',
  `seotitle` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `keywords` varchar(150) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `linkurl` varchar(100) NOT NULL DEFAULT '',
  `weblinkurl` varchar(100) NOT NULL DEFAULT '',
  `htmlname` varchar(50) NOT NULL DEFAULT '' COMMENT '生成html名称',
  `path` varchar(100) NOT NULL COMMENT '路径',
  `dir` varchar(30) NOT NULL COMMENT '当前文件夹名称',
  `showtype` tinyint(1) NOT NULL DEFAULT '0',
  `ishtml` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否生成html',
  `imgsize` varchar(100) NOT NULL,
  `isgood` tinyint(1) NOT NULL DEFAULT '0',
  `iscats` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许分类',
  `ishidden` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `isstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分类状态',
  `disorder` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `sendtime` varchar(10) NOT NULL DEFAULT '' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `newscats` (`pid`,`catname`,`iscats`,`ishidden`,`isstate`,`sendtime`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_news_cats
-- ----------------------------
INSERT INTO `dy_news_cats` VALUES ('1', '0', '总类目', '', '0', '', '', '', '8', '', '', '', '', '', '', 'goods', '', '9', '0', '198*140', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('2', '0', '会员中心', '', '0', '', '', '', '8', '', '', '', '', '', '', '', '', '1', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('3', '0', '辅助栏目', '', '0', '', '', '', '8', '', '', '', '', '', '', '', '', '1', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('4', '1', '蔬菜', '', '0', 'menu1.jpg', '', '', '8', '', '', '', '', '', '', '', '', '10', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('5', '2', '会员中心', '', '0', '', '', '', '8', '', '', '', 'usr.php', '', '', '', '', '1', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('6', '3', '留言管理', '', '0', '', '', '', '8', '', '', '', 'message.php', '', '', '', '', '6', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('7', '3', '首页轮播', '', '0', '', '', '', '8', '', '', '', '', '', '', '', '', '6', '0', '640*383', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('8', '3', '内页banner', '', '0', '', '', '', '8', '', '', '', 'ban.php', '', '', '', '', '1', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('9', '1', '肉类', '', '0', 'menu2.jpg', '', '', '8', '', '', '', '', '', '', '', '', '9', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('10', '1', '肉禽蛋类', '', '0', 'menu3.jpg', '', '', '8', '', '', '', '', '', '', '', '', '9', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('11', '1', '水产冻货', '', '0', 'menu4.jpg', '', '', '8', '', '', '', '', '', '', '', '', '9', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('12', '1', '豆制品', '', '0', 'menu5.jpg', '', '', '8', '', '', '', '', '', '', '', '', '9', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('13', '1', '调味料', '', '0', 'menu6.jpg', '', '', '8', '', '', '', '', '', '', '', '', '9', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('14', '1', '粮油', '', '0', 'menu7.jpg', '', '', '8', '', '', '', '', '', '', '', '', '9', '0', '', '0', '0', '0', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('15', '6', '新品需求', '', '0', '', '', '', '8', '', '', '', 'need.php', '', '', '', '', '7', '0', '', '0', '0', '1', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('17', '3', '常见问题', '', '0', '', '', '', '8', '', '', '', '', '', '', '', '', '5', '0', '', '0', '0', '1', '1', '0', '');
INSERT INTO `dy_news_cats` VALUES ('16', '1', '节日特供', '', '0', 'menu8.jpg', '', '', '8', '', '', '', '', '', '', '', '', '9', '0', '', '0', '0', '0', '1', '0', '');

-- ----------------------------
-- Table structure for `dy_order`
-- ----------------------------
DROP TABLE IF EXISTS `dy_order`;
CREATE TABLE `dy_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_no` varchar(255) DEFAULT '' COMMENT '订单编号',
  `out_trade_no` varchar(100) NOT NULL DEFAULT '0' COMMENT '外部交易号',
  `order_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单类型',
  `payment_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付类型。取值范围：\r\nWEIXIN (微信自有支付)\r\nWEIXIN_DAIXIAO (微信代销支付)\r\nALIPAY (支付宝支付)',
  `shipping_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单配送方式',
  `order_from` varchar(255) NOT NULL DEFAULT '' COMMENT '订单来源',
  `buyer_id` int(11) NOT NULL COMMENT '买家id',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '买家会员名称',
  `pay_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单付款时间',
  `buyer_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '买家ip',
  `shipping_time` varchar(100) NOT NULL COMMENT '买家要求配送时间',
  `sign_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '买家签收时间',
  `receiver_mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '收货人的手机号码',
  `receiver_pcd` varchar(33) NOT NULL COMMENT '收货人所在省',
  `receiver_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人详细地址',
  `receiver_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `seller_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '卖家对订单的备注',
  `consign_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '卖家发货时间',
  `consign_time_adjust` int(11) NOT NULL DEFAULT '0' COMMENT '卖家延迟发货时间',
  `goods_money` decimal(19,2) NOT NULL COMMENT '商品总价',
  `order_money` decimal(10,2) NOT NULL COMMENT '订单总价',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单余额支付金额',
  `pay_money` decimal(10,2) NOT NULL COMMENT '订单实付金额',
  `order_status` tinyint(4) NOT NULL COMMENT '订单状态',
  `pay_status` tinyint(4) NOT NULL COMMENT '订单付款状态',
  `shipping_status` tinyint(4) NOT NULL COMMENT '订单配送状态',
  `review_status` tinyint(4) NOT NULL COMMENT '订单评价状态',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单创建时间',
  `finish_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单完成时间',
  `is_evaluate` smallint(6) NOT NULL DEFAULT '0' COMMENT '是否评价 0为未评价 1为已评价 2为已追评',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=440 COMMENT='订单表';

-- ----------------------------
-- Records of dy_order
-- ----------------------------
INSERT INTO `dy_order` VALUES ('7', '15083388599898', '0', '1', '0', '1', '', '1', 'made mad', '0000-00-00 00:00:00', '127.0.0.1', '下周一 12:00-14:00', '0000-00-00 00:00:00', '18856924272', '天津 河西区 全境', '天门湖花园203', '胡锐', '', '0000-00-00 00:00:00', '0', '331.50', '0.00', '0.00', '0.00', '0', '0', '0', '0', '2017-10-18 23:00:59', '0000-00-00 00:00:00', '0');
INSERT INTO `dy_order` VALUES ('8', '15083388599899', '0', '1', '0', '1', '', '1', '', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', '', '', '', '', '', '0000-00-00 00:00:00', '0', '0.00', '0.00', '0.00', '0.00', '0', '0', '0', '0', '2017-10-18 23:30:59', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for `dy_order_action`
-- ----------------------------
DROP TABLE IF EXISTS `dy_order_action`;
CREATE TABLE `dy_order_action` (
  `action_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '动作id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `action` varchar(255) NOT NULL DEFAULT '' COMMENT '动作内容',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人',
  `order_status` int(11) NOT NULL COMMENT '订单大状态',
  `order_status_text` varchar(255) NOT NULL DEFAULT '' COMMENT '订单状态名称',
  `action_time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`action_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1706 COMMENT='订单操作表';

-- ----------------------------
-- Records of dy_order_action
-- ----------------------------

-- ----------------------------
-- Table structure for `dy_order_goods`
-- ----------------------------
DROP TABLE IF EXISTS `dy_order_goods`;
CREATE TABLE `dy_order_goods` (
  `order_goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单项ID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `goods_name` varchar(50) NOT NULL COMMENT '商品名称',
  `goods_name_added` varchar(25) NOT NULL,
  `price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本价',
  `num` varchar(255) NOT NULL DEFAULT '0' COMMENT '购买数量',
  `adjust_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '调整金额',
  `goods_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `img1` varchar(50) NOT NULL DEFAULT '0' COMMENT '商品图片',
  `buyer_id` int(11) NOT NULL DEFAULT '0' COMMENT '购买人ID',
  `order_type` int(11) NOT NULL DEFAULT '1' COMMENT '订单类型',
  `order_status` int(11) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `is_evaluate` smallint(6) NOT NULL DEFAULT '0' COMMENT '是否评价 0为未评价 1为已评价 2为已追评',
  PRIMARY KEY (`order_goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=289 COMMENT='订单商品表';

-- ----------------------------
-- Records of dy_order_goods
-- ----------------------------
INSERT INTO `dy_order_goods` VALUES ('10', '7', '1', '精品五花肉', '9.90/袋（10斤）', '39.90', '18.00', '15', '0.00', '598.50', '2017101609144382.png', '1', '1', '0', '', '0');
INSERT INTO `dy_order_goods` VALUES ('11', '7', '2', '精品五花肉', '9.90/袋（10斤）', '2.30', '0.50', '15', '0.00', '34.50', '2017101609144382.png', '1', '1', '0', '', '0');
INSERT INTO `dy_order_goods` VALUES ('12', '7', '3', '精品五花肉', '9.90/袋（10斤）', '2.30', '0.50', '15', '0.00', '34.50', '2017101609144382.png', '1', '1', '0', '', '0');

-- ----------------------------
-- Table structure for `dy_pic`
-- ----------------------------
DROP TABLE IF EXISTS `dy_pic`;
CREATE TABLE `dy_pic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '新闻分类表',
  `ti` int(11) unsigned NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `img1` varchar(30) NOT NULL,
  `disorder` int(11) NOT NULL,
  `isstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分类状态',
  PRIMARY KEY (`id`),
  KEY `newscats` (`title`,`isstate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_pic
-- ----------------------------

-- ----------------------------
-- Table structure for `dy_usr`
-- ----------------------------
DROP TABLE IF EXISTS `dy_usr`;
CREATE TABLE `dy_usr` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL COMMENT '手机号码',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(10) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1男,2女',
  `headimg` varchar(64) NOT NULL,
  `bgimg` varchar(64) NOT NULL,
  `randcode` char(6) NOT NULL COMMENT '随机码',
  `lastloginip` varchar(15) NOT NULL,
  `lastlogintime` int(10) NOT NULL,
  `logtimes` smallint(6) NOT NULL DEFAULT '0',
  `regtime` int(10) NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_usr
-- ----------------------------
INSERT INTO `dy_usr` VALUES ('1', '18856924272', 'c6fa27d53d715100625cbba8ae4eb55e', 'made mad', '1', '786f2cc81ad1eeb3b8cd222ceb77d763.png', 'bg_cceb1161867ab91def7fac026ead455c.jpg', '815793', '127.0.0.1', '1508301990', '38', '1507689535');
INSERT INTO `dy_usr` VALUES ('2', '18856924277', '7a8bd24511cb5db023e9ba91e6e104c7', '', '0', '', '', '237tdn', '127.0.0.1', '1507946417', '1', '1507946417');
INSERT INTO `dy_usr` VALUES ('3', '18856924271', '5e1ac1b53060f0135641ac5864fe31cd', '', '0', '', '', 'mxkzgw', '127.0.0.1', '1507946542', '1', '1507946542');
INSERT INTO `dy_usr` VALUES ('4', '18856924273', '1db6af9d19d38d8f2a0025c918fedc23', '', '0', '', '', '355033', '127.0.0.1', '1507947254', '1', '1507947254');
INSERT INTO `dy_usr` VALUES ('5', '18256924272', '5276e9c75a7e3569b36187349173407c', '', '0', '', '', '166956', '127.0.0.1', '1508295753', '1', '1508295722');

-- ----------------------------
-- Table structure for `dy_usr_address`
-- ----------------------------
DROP TABLE IF EXISTS `dy_usr_address`;
CREATE TABLE `dy_usr_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员基本资料表ID',
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别 2男 1女',
  `consigner` varchar(255) NOT NULL DEFAULT '' COMMENT '收件人',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '固定电话',
  `province` varchar(11) NOT NULL DEFAULT '0' COMMENT '省',
  `city` varchar(11) NOT NULL DEFAULT '0' COMMENT '市',
  `district` varchar(11) NOT NULL DEFAULT '0' COMMENT '区县',
  `pcd` varchar(33) NOT NULL COMMENT 'province + city + district',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `zip_code` varchar(6) NOT NULL DEFAULT '' COMMENT '邮编',
  `alias` varchar(50) NOT NULL DEFAULT '' COMMENT '地址别名',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认收货地址',
  PRIMARY KEY (`id`),
  KEY `IDX_member_express_address_uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='会员收货地址管理';

-- ----------------------------
-- Records of dy_usr_address
-- ----------------------------
INSERT INTO `dy_usr_address` VALUES ('4', '1', '2', '胡锐', '18856924272', '', '天津', '河西区', '全境', '天津 河西区 全境', '天门湖花园203', '', '', '0');

-- ----------------------------
-- Table structure for `dy_usr_need`
-- ----------------------------
DROP TABLE IF EXISTS `dy_usr_need`;
CREATE TABLE `dy_usr_need` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '手机号码',
  `img` varchar(64) NOT NULL,
  `proposal` varchar(200) NOT NULL COMMENT '建议',
  `mobile` char(11) NOT NULL,
  `isstate` tinyint(4) NOT NULL DEFAULT '0',
  `sendtime` int(10) NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_usr_need
-- ----------------------------
INSERT INTO `dy_usr_need` VALUES ('8', '1', '2017101312382043.jpg', '需要很多', '', '0', '1507869500');
INSERT INTO `dy_usr_need` VALUES ('7', '1', '2017101118455751.jpg', '123213213', '1', '0', '1507718757');

-- ----------------------------
-- Table structure for `ns_express_company`
-- ----------------------------
DROP TABLE IF EXISTS `ns_express_company`;
CREATE TABLE `ns_express_company` (
  `co_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `shopId` int(11) NOT NULL COMMENT '商铺id',
  `company_name` varchar(50) NOT NULL DEFAULT '' COMMENT '物流公司名称',
  `express_no` varchar(20) NOT NULL DEFAULT '' COMMENT '物流编号',
  `is_enabled` int(11) NOT NULL DEFAULT '1' COMMENT '使用状态',
  `image` varchar(255) DEFAULT '' COMMENT '物流公司模版图片',
  `phone` varchar(50) NOT NULL DEFAULT '' COMMENT '联系电话',
  `orders` tinyint(4) DEFAULT NULL COMMENT '快递排列序号',
  PRIMARY KEY (`co_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=420 COMMENT='物流公司';

-- ----------------------------
-- Records of ns_express_company
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_gift_grant_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_gift_grant_records`;
CREATE TABLE `ns_gift_grant_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `gift_id` int(11) NOT NULL COMMENT '赠送活动ID',
  `goods_id` int(11) NOT NULL COMMENT '赠送商品ID',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '赠送商品名称',
  `goods_img` varchar(255) NOT NULL DEFAULT '' COMMENT '赠送商品图片',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '赠送数量',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '发放方式',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '发放相关ID',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '赠送时间',
  `memo` text NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='赠品发放记录';

-- ----------------------------
-- Records of ns_gift_grant_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods`;
CREATE TABLE `ns_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id(SKU)',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '店铺id',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `category_id_1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类id',
  `category_id_2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级分类id',
  `category_id_3` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '三级分类id',
  `brand_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `group_id_array` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺分类id 首尾用,隔开',
  `promotion_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '促销类型 0无促销，1团购，2限时折扣',
  `promote_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销活动ID',
  `goods_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '实物或虚拟商品标志 1实物商品 0 虚拟商品 2 F码商品',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品原价格',
  `promotion_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品促销价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `point_exchange_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '积分兑换类型 0 非积分兑换 1 只能积分兑换 ',
  `point_exchange` int(11) NOT NULL DEFAULT '0' COMMENT '积分兑换',
  `give_point` int(11) NOT NULL DEFAULT '0' COMMENT '购买商品赠送积分',
  `is_member_discount` int(1) NOT NULL DEFAULT '0' COMMENT '参与会员折扣',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费 0为免运费',
  `shipping_fee_id` int(11) NOT NULL DEFAULT '0' COMMENT '售卖区域id 物流模板id  ns_order_shipping_fee 表id',
  `stock` int(10) NOT NULL DEFAULT '0' COMMENT '商品库存',
  `max_buy` int(11) NOT NULL DEFAULT '0' COMMENT '限购 0 不限购',
  `clicks` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品点击数量',
  `min_stock_alarm` int(11) NOT NULL DEFAULT '0' COMMENT '库存预警值',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售数量',
  `collects` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `star` tinyint(3) unsigned NOT NULL DEFAULT '5' COMMENT '好评星级',
  `evaluates` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评价数',
  `shares` int(11) NOT NULL DEFAULT '0' COMMENT '分享数',
  `province_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级地区id',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级地区id',
  `picture` int(11) NOT NULL DEFAULT '0' COMMENT '商品主图',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '商品关键词',
  `introduction` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简介',
  `description` text NOT NULL COMMENT '商品详情',
  `QRcode` varchar(255) NOT NULL DEFAULT '' COMMENT '商品二维码',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '商家编号',
  `is_stock_visible` int(1) NOT NULL DEFAULT '0' COMMENT '页面不显示库存',
  `is_hot` int(1) NOT NULL DEFAULT '0' COMMENT '是否热销商品',
  `is_recommend` int(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `is_new` int(1) NOT NULL DEFAULT '0' COMMENT '是否新品',
  `is_pre-sale` int(1) NOT NULL DEFAULT '0' COMMENT '是否预售',
  `is_bill` int(1) NOT NULL DEFAULT '0' COMMENT '是否开具增值税发票 1是，0否',
  `state` tinyint(3) NOT NULL DEFAULT '1' COMMENT '商品状态 0下架，1正常，10违规（禁售）',
  `sale_date` datetime NOT NULL COMMENT '上下架时间',
  `create_time` datetime NOT NULL COMMENT '商品添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '商品编辑时间',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `img_id_array` varchar(1000) DEFAULT NULL COMMENT '商品图片序列',
  `sku_img_array` varchar(1000) DEFAULT NULL COMMENT '商品sku应用图片列表  属性,属性值，图片ID',
  `match_point` float(10,2) DEFAULT NULL COMMENT '实物与描述相符（根据评价计算）',
  `match_ratio` float(10,2) DEFAULT NULL COMMENT '实物与描述相符（根据评价计算）百分比',
  `real_sales` int(10) NOT NULL DEFAULT '0' COMMENT '实际销量',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16554 COMMENT='商品表';

-- ----------------------------
-- Records of ns_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_attribute`;
CREATE TABLE `ns_goods_attribute` (
  `attr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '属性ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `attr_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性名称',
  `is_visible` bit(1) NOT NULL DEFAULT b'1' COMMENT '是否可视',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` datetime NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`attr_id`),
  KEY `IDX_category_props_categoryId` (`shop_id`),
  KEY `IDX_category_props_orders` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=3276 COMMENT='商品属性（规格）表';

-- ----------------------------
-- Records of ns_goods_attribute
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_attribute_value`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_attribute_value`;
CREATE TABLE `ns_goods_attribute_value` (
  `attr_value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品属性值ID',
  `attr_id` int(11) NOT NULL COMMENT '商品属性ID',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '值名称',
  `is_visible` bit(1) NOT NULL DEFAULT b'1' COMMENT '是否可视',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`attr_value_id`),
  KEY `IDX_category_propvalues_c_pId` (`attr_id`),
  KEY `IDX_category_propvalues_orders` (`sort`),
  KEY `IDX_category_propvalues_value` (`attr_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1092 COMMENT='商品规格值模版表';

-- ----------------------------
-- Records of ns_goods_attribute_value
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_brand`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_brand`;
CREATE TABLE `ns_goods_brand` (
  `brand_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `brand_name` varchar(100) NOT NULL COMMENT '品牌名称',
  `brand_initial` varchar(1) NOT NULL COMMENT '品牌首字母',
  `brand_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `brand_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐，0为否，1为是，默认为0',
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `brand_category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名称',
  `category_id_array` varchar(1000) NOT NULL DEFAULT '' COMMENT '所属分类id组',
  `brand_ads` varchar(255) NOT NULL DEFAULT '' COMMENT '品牌推荐广告',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌所属分类名称',
  `category_id_1` int(11) NOT NULL DEFAULT '0' COMMENT '一级分类ID',
  `category_id_2` int(11) NOT NULL DEFAULT '0' COMMENT '二级分类ID',
  `category_id_3` int(11) NOT NULL DEFAULT '0' COMMENT '三级分类ID',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1024 COMMENT='品牌表';

-- ----------------------------
-- Records of ns_goods_brand
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_category`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_category`;
CREATE TABLE `ns_goods_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL DEFAULT '',
  `short_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类简称 ',
  `pid` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `is_visible` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示  1 显示 0 不显示',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `sort` tinyint(4) NOT NULL DEFAULT '0',
  `category_pic` varchar(255) NOT NULL DEFAULT '' COMMENT '商品分类图片',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=244 COMMENT='商品分类表';

-- ----------------------------
-- Records of ns_goods_category
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_evaluate`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_evaluate`;
CREATE TABLE `ns_goods_evaluate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评价ID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `order_no` bigint(20) unsigned NOT NULL COMMENT '订单编号',
  `order_goods_id` int(11) NOT NULL COMMENT '订单项ID',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_image` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `shop_name` varchar(100) NOT NULL COMMENT '店铺名称',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评价内容',
  `addtime` datetime DEFAULT NULL COMMENT '评价时间',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '评价图片',
  `explain_first` varchar(255) NOT NULL DEFAULT '' COMMENT '解释内容',
  `member_name` varchar(100) NOT NULL DEFAULT '' COMMENT '评价人名称',
  `uid` int(11) NOT NULL COMMENT '评价人编号',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0表示不是 1表示是匿名评价',
  `scores` tinyint(1) NOT NULL COMMENT '1-5分',
  `again_content` varchar(255) NOT NULL DEFAULT '' COMMENT '追加评价内容',
  `again_addtime` datetime DEFAULT NULL COMMENT '追加评价时间',
  `again_image` varchar(255) NOT NULL DEFAULT '' COMMENT '追加评价图片',
  `again_explain` varchar(255) NOT NULL DEFAULT '' COMMENT '追加解释内容',
  `explain_type` int(11) DEFAULT '0' COMMENT '1好评2中评3差评',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1489 COMMENT='商品评价表';

-- ----------------------------
-- Records of ns_goods_evaluate
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_group`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_group`;
CREATE TABLE `ns_goods_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id 最多2级',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '级别',
  `is_visible` int(1) NOT NULL DEFAULT '1' COMMENT '是否可视',
  `group_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=160 COMMENT='商品本店分类';

-- ----------------------------
-- Records of ns_goods_group
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_sku`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_sku`;
CREATE TABLE `ns_goods_sku` (
  `sku_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `sku_name` varchar(500) NOT NULL DEFAULT '' COMMENT 'SKU名称',
  `attr_value_items` varchar(255) NOT NULL DEFAULT '' COMMENT '属性和属性值 id串 attribute + attribute value 表ID分号分隔',
  `attr_value_items_format` varchar(500) NOT NULL DEFAULT '' COMMENT '属性和属性值id串组合json格式',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `picture` int(11) NOT NULL DEFAULT '0' COMMENT '如果是第一个sku编码, 可以加图片',
  `code` varchar(255) NOT NULL DEFAULT '' COMMENT '商家编码',
  `QRcode` varchar(255) NOT NULL DEFAULT '' COMMENT '商品二维码',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_date` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=481 COMMENT='商品skui规格价格库存信息表';

-- ----------------------------
-- Records of ns_goods_sku
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member`;
CREATE TABLE `ns_member` (
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `member_name` varchar(50) NOT NULL DEFAULT '' COMMENT '前台用户名',
  `member_level` int(11) NOT NULL DEFAULT '1' COMMENT '会员等级',
  `member_point` int(11) NOT NULL DEFAULT '0' COMMENT '会员积分',
  `member_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员余额',
  `reg_time` datetime NOT NULL COMMENT '注册时间',
  `memo` varchar(1000) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=147 COMMENT='前台用户表';

-- ----------------------------
-- Records of ns_member
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_account`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_account`;
CREATE TABLE `ns_member_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员uid',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '会员积分',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '购物币',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=3276 COMMENT='会员账户统计表';

-- ----------------------------
-- Records of ns_member_account
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_account_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_account_records`;
CREATE TABLE `ns_member_account_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `account_type` int(11) NOT NULL DEFAULT '1' COMMENT '账户类型1.积分2.余额3.购物币',
  `sign` smallint(6) NOT NULL DEFAULT '1' COMMENT '正负号',
  `number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '数量',
  `from_type` smallint(6) NOT NULL DEFAULT '0' COMMENT '产生方式1.商城订单2.订单退还3.兑换',
  `data_id` int(11) NOT NULL DEFAULT '0' COMMENT '相关表的数据ID',
  `text` varchar(255) NOT NULL DEFAULT '' COMMENT '数据相关内容描述文本',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=108 COMMENT='会员流水账表';

-- ----------------------------
-- Records of ns_member_account_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_express_address`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_express_address`;
CREATE TABLE `ns_member_express_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员基本资料表ID',
  `consigner` varchar(255) NOT NULL DEFAULT '' COMMENT '收件人',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '固定电话',
  `province` int(11) NOT NULL DEFAULT '0' COMMENT '省',
  `city` int(11) NOT NULL DEFAULT '0' COMMENT '市',
  `district` int(11) NOT NULL DEFAULT '0' COMMENT '区县',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `zip_code` varchar(6) NOT NULL DEFAULT '' COMMENT '邮编',
  `alias` varchar(50) NOT NULL DEFAULT '' COMMENT '地址别名',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '默认收货地址',
  PRIMARY KEY (`id`),
  KEY `IDX_member_express_address_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='会员收货地址管理';

-- ----------------------------
-- Records of ns_member_express_address
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_favorites`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_favorites`;
CREATE TABLE `ns_member_favorites` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `fav_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品或店铺ID',
  `fav_type` varchar(20) NOT NULL DEFAULT 'goods' COMMENT '类型:goods为商品,shop为店铺,默认为商品',
  `fav_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '收藏时间',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `shop_name` varchar(20) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `shop_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺logo',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_image` varchar(100) NOT NULL DEFAULT '' COMMENT '商品图片',
  `log_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品收藏时价格',
  `log_msg` varchar(1000) NOT NULL DEFAULT '' COMMENT '收藏备注',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='收藏表';

-- ----------------------------
-- Records of ns_member_favorites
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_gift`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_gift`;
CREATE TABLE `ns_member_gift` (
  `gift_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `promotion_gift_id` int(11) NOT NULL COMMENT '赠品活动ID',
  `goods_id` int(11) NOT NULL COMMENT '赠品ID',
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '赠品名称',
  `goods_picture` int(11) NOT NULL DEFAULT '0' COMMENT '赠品图片',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '赠品数量',
  `get_type` int(11) NOT NULL DEFAULT '1' COMMENT '获取方式',
  `get_type_id` int(11) NOT NULL COMMENT '获取方式对应ID',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `desc` text NOT NULL COMMENT '说明',
  PRIMARY KEY (`gift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员赠品表';

-- ----------------------------
-- Records of ns_member_gift
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_level`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_level`;
CREATE TABLE `ns_member_level` (
  `level_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '等级ID',
  `shop_id` int(11) NOT NULL DEFAULT '1' COMMENT '店铺ID',
  `level_name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名称',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='会员等级';

-- ----------------------------
-- Records of ns_member_level
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order`;
CREATE TABLE `ns_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_no` varchar(255) DEFAULT '' COMMENT '订单编号',
  `out_trade_no` varchar(100) NOT NULL DEFAULT '0' COMMENT '外部交易号',
  `order_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单类型',
  `payment_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付类型。取值范围：\r\nWEIXIN (微信自有支付)\r\nWEIXIN_DAIXIAO (微信代销支付)\r\nALIPAY (支付宝支付)',
  `shipping_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单配送方式',
  `order_from` varchar(255) NOT NULL DEFAULT '' COMMENT '订单来源',
  `buyer_id` int(11) NOT NULL COMMENT '买家id',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '买家会员名称',
  `pay_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单付款时间',
  `buyer_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '买家ip',
  `buyer_message` varchar(255) NOT NULL DEFAULT '' COMMENT '买家附言',
  `buyer_invoice` varchar(255) NOT NULL DEFAULT '' COMMENT '买家发票信息',
  `shipping_time` datetime NOT NULL COMMENT '买家要求配送时间',
  `sign_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '买家签收时间',
  `receiver_mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '收货人的手机号码',
  `receiver_province` int(11) NOT NULL COMMENT '收货人所在省',
  `receiver_city` int(11) NOT NULL COMMENT '收货人所在城市',
  `receiver_district` int(11) NOT NULL COMMENT '收货人所在街道',
  `receiver_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人详细地址',
  `receiver_zip` varchar(6) NOT NULL DEFAULT '' COMMENT '收货人邮编',
  `receiver_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `shop_id` int(11) NOT NULL COMMENT '卖家店铺id',
  `shop_name` varchar(100) NOT NULL DEFAULT '' COMMENT '卖家店铺名称',
  `seller_star` tinyint(4) NOT NULL DEFAULT '0' COMMENT '卖家对订单的标注星标',
  `seller_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '卖家对订单的备注',
  `consign_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '卖家发货时间',
  `consign_time_adjust` int(11) NOT NULL DEFAULT '0' COMMENT '卖家延迟发货时间',
  `goods_money` decimal(19,2) NOT NULL COMMENT '商品总价',
  `order_money` decimal(10,2) NOT NULL COMMENT '订单总价',
  `point` int(11) NOT NULL COMMENT '订单消耗积分',
  `point_money` decimal(10,2) NOT NULL COMMENT '订单消耗积分抵多少钱',
  `coupon_money` decimal(10,2) NOT NULL COMMENT '订单代金券支付金额',
  `coupon_id` int(11) NOT NULL COMMENT '订单代金券id',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单余额支付金额',
  `user_platform_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户平台余额支付',
  `promotion_money` decimal(10,2) NOT NULL COMMENT '订单优惠活动金额',
  `shipping_money` decimal(10,2) NOT NULL COMMENT '订单运费',
  `pay_money` decimal(10,2) NOT NULL COMMENT '订单实付金额',
  `refund_money` decimal(10,2) NOT NULL COMMENT '订单退款金额',
  `coin_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '购物币金额',
  `give_point` int(11) NOT NULL COMMENT '订单赠送积分',
  `give_coin` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单成功之后返购物币',
  `order_status` tinyint(4) NOT NULL COMMENT '订单状态',
  `pay_status` tinyint(4) NOT NULL COMMENT '订单付款状态',
  `shipping_status` tinyint(4) NOT NULL COMMENT '订单配送状态',
  `review_status` tinyint(4) NOT NULL COMMENT '订单评价状态',
  `feedback_status` tinyint(4) NOT NULL COMMENT '订单维权状态',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单创建时间',
  `finish_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单完成时间',
  `is_evaluate` smallint(6) NOT NULL DEFAULT '0' COMMENT '是否评价 0为未评价 1为已评价 2为已追评',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=440 COMMENT='订单表';

-- ----------------------------
-- Records of ns_order
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_action`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_action`;
CREATE TABLE `ns_order_action` (
  `action_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '动作id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `action` varchar(255) NOT NULL DEFAULT '' COMMENT '动作内容',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人',
  `order_status` int(11) NOT NULL COMMENT '订单大状态',
  `order_status_text` varchar(255) NOT NULL DEFAULT '' COMMENT '订单状态名称',
  `action_time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`action_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1706 COMMENT='订单操作表';

-- ----------------------------
-- Records of ns_order_action
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_goods`;
CREATE TABLE `ns_order_goods` (
  `order_goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单项ID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `goods_name` varchar(50) NOT NULL COMMENT '商品名称',
  `sku_id` int(11) NOT NULL COMMENT 'skuID',
  `sku_name` varchar(50) NOT NULL COMMENT 'sku名称',
  `price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本价',
  `num` varchar(255) NOT NULL DEFAULT '0' COMMENT '购买数量',
  `adjust_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '调整金额',
  `goods_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `goods_picture` int(11) NOT NULL DEFAULT '0' COMMENT '商品图片',
  `shop_id` int(11) NOT NULL DEFAULT '1' COMMENT '店铺ID',
  `buyer_id` int(11) NOT NULL DEFAULT '0' COMMENT '购买人ID',
  `point_exchange_type` int(11) NOT NULL DEFAULT '0' COMMENT '积分兑换类型0.非积分兑换1.积分兑换',
  `goods_type` varchar(255) NOT NULL DEFAULT '1' COMMENT '商品类型',
  `promotion_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销ID',
  `promotion_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销类型',
  `order_type` int(11) NOT NULL DEFAULT '1' COMMENT '订单类型',
  `order_status` int(11) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `give_point` int(11) NOT NULL DEFAULT '0' COMMENT '积分数量',
  `shipping_status` int(11) NOT NULL DEFAULT '0' COMMENT '物流状态',
  `refund_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '退款时间',
  `refund_type` int(11) NOT NULL DEFAULT '1' COMMENT '退款方式',
  `refund_require_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `refund_reason` varchar(255) NOT NULL DEFAULT '' COMMENT '退款原因',
  `refund_shipping_code` varchar(255) NOT NULL DEFAULT '' COMMENT '退款物流单号',
  `refund_shipping_company` varchar(255) NOT NULL DEFAULT '0' COMMENT '退款物流公司名称',
  `refund_real_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际退款金额',
  `refund_status` int(1) NOT NULL DEFAULT '0' COMMENT '退款状态',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `is_evaluate` smallint(6) NOT NULL DEFAULT '0' COMMENT '是否评价 0为未评价 1为已评价 2为已追评',
  PRIMARY KEY (`order_goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=289 COMMENT='订单商品表';

-- ----------------------------
-- Records of ns_order_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_goods_express`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_goods_express`;
CREATE TABLE `ns_order_goods_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `order_goods_id_array` varchar(255) NOT NULL COMMENT '订单项商品组合列表',
  `express_name` varchar(50) NOT NULL DEFAULT '' COMMENT '包裹名称  （包裹- 1 包裹 - 2）',
  `shipping_type` tinyint(4) NOT NULL COMMENT '发货方式1 需要物流 0无需物流',
  `express_company_id` int(11) NOT NULL COMMENT '快递公司id',
  `express_company` varchar(255) NOT NULL DEFAULT '' COMMENT '物流公司名称',
  `express_no` varchar(50) NOT NULL COMMENT '运单编号',
  `shipping_time` datetime NOT NULL COMMENT '发货时间',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=606 COMMENT='商品订单物流信息表（多次发货）';

-- ----------------------------
-- Records of ns_order_goods_express
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_goods_promotion_details`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_goods_promotion_details`;
CREATE TABLE `ns_order_goods_promotion_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `sku_id` int(11) NOT NULL COMMENT '商品skuid',
  `promotion_type` varbinary(255) NOT NULL COMMENT '优惠类型规则ID（满减对应规则）',
  `promotion_id` int(11) NOT NULL COMMENT '优惠ID',
  `discount_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠的金额，单位：元，精确到小数点后两位',
  `used_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '使用时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='订单商品优惠详情';

-- ----------------------------
-- Records of ns_order_goods_promotion_details
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_payment`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_payment`;
CREATE TABLE `ns_order_payment` (
  `out_trade_no` varchar(30) NOT NULL COMMENT '支付单编号',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '执行支付的相关店铺ID（0平台）',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '订单类型1.商城订单2.交易商支付',
  `type_alis_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单类型关联ID',
  `pay_body` varchar(255) NOT NULL DEFAULT '' COMMENT '订单支付简介',
  `pay_detail` varchar(1000) NOT NULL DEFAULT '' COMMENT '订单支付详情',
  `pay_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `pay_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '支付时间',
  `pay_type` int(11) NOT NULL DEFAULT '1' COMMENT '支付方式'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=963 COMMENT='订单支付表';

-- ----------------------------
-- Records of ns_order_payment
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_promotion_details`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_promotion_details`;
CREATE TABLE `ns_order_promotion_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `promotion_type_id` int(11) NOT NULL COMMENT '优惠类型规则ID（满减对应规则）',
  `promotion_id` int(11) NOT NULL COMMENT '优惠ID',
  `promotion_type` varchar(255) NOT NULL COMMENT '优惠类型',
  `promotion_name` varchar(50) NOT NULL COMMENT '该优惠活动的名称',
  `promotion_condition` varchar(255) NOT NULL DEFAULT '' COMMENT '优惠使用条件说明',
  `discount_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠的金额，单位：元，精确到小数点后两位',
  `used_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '使用时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=364 COMMENT='订单优惠详情';

-- ----------------------------
-- Records of ns_order_promotion_details
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_refund`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_refund`;
CREATE TABLE `ns_order_refund` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_goods_id` int(11) NOT NULL COMMENT '订单商品表id',
  `refund_status` varchar(255) NOT NULL COMMENT '操作状态\r\n\r\n流程状态(refund_status)	状态名称(refund_status_name)	操作时间\r\n1	买家申请	发起了退款申请,等待卖家处理\r\n2	等待买家退货	卖家已同意退款申请,等待买家退货\r\n3	等待卖家确认收货	买家已退货,等待卖家确认收货\r\n4	等待卖家确认退款	卖家同意退款\r\n0	退款已成功	卖家退款给买家，本次维权结束\r\n-1	退款已拒绝	卖家拒绝本次退款，本次维权结束\r\n-2	退款已关闭	主动撤销退款，退款关闭\r\n-3	退款申请不通过	拒绝了本次退款申请,等待买家修改\r\n',
  `action` varchar(255) NOT NULL COMMENT '退款操作内容描述',
  `action_way` tinyint(4) NOT NULL DEFAULT '0' COMMENT '操作方 1 买家 2 卖家',
  `action_userid` varchar(255) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `action_username` varchar(255) NOT NULL DEFAULT '' COMMENT '操作人姓名',
  `action_time` datetime DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=108 COMMENT='订单商品退货退款操作表';

-- ----------------------------
-- Records of ns_order_refund
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_shipping_fee`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_shipping_fee`;
CREATE TABLE `ns_order_shipping_fee` (
  `shipping_fee_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '售卖区域ID',
  `shipping_fee_name` varchar(30) NOT NULL COMMENT '售卖区域名称',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `create_time` datetime NOT NULL COMMENT '创建日期',
  `update_time` datetime DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`shipping_fee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461 COMMENT='售卖区域';

-- ----------------------------
-- Records of ns_order_shipping_fee
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_shipping_fee_extend`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_shipping_fee_extend`;
CREATE TABLE `ns_order_shipping_fee_extend` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '售卖区域扩展ID',
  `shipping_fee_id` int(11) NOT NULL COMMENT '售卖区域ID',
  `province_id` varchar(8000) NOT NULL DEFAULT '0' COMMENT '省级地区ID组成的串，以，隔开，两端也有，',
  `city_id` varchar(8000) NOT NULL DEFAULT '0' COMMENT '市级地区ID组成的串，以，隔开，两端也有，',
  `snum` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT '首件数量',
  `sprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首件运费',
  `xnum` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT '续件数量',
  `xprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '续件运费',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '是否默认 1 默认',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1820 COMMENT='售卖区域扩展表';

-- ----------------------------
-- Records of ns_order_shipping_fee_extend
-- ----------------------------
