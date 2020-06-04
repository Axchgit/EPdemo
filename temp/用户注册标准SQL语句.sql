
truncate table 你的表名   
CREATE TABLE staff (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL default '0' COMMENT '用户id',
  `username` varchar(45) NOT NULL default '' COMMENT '真实姓名',
  `email` varchar(30) NOT NULL default '' COMMENT '用户邮箱',
  `nickname` varchar(45) NOT NULL default '' COMMENT '昵称',
  `avatar` int(11) NOT NULL default '0' COMMENT '头像',
  `birthday` date NOT NULL default '0000-00-00' COMMENT '生日',
  `sex` tinyint(4) not null DEFAULT '0' COMMENT '性别',
  `short_introduce` varchar(150) not null DEFAULT '' COMMENT '一句话介绍自己，最多50个汉字',
  `user_resume` varchar(200) NOT NULL default '' COMMENT '用户提交的简历存放地址',
  `user_register_ip` int NOT NULL COMMENT '用户注册时的源ip',
  `create_time` datetime NOT NULL default current_timestamp COMMENT '用户记录创建的时间',
  `update_time` datetime default current_timestamp on update current_timestamp NOT NULL COMMENT '用户资料修改的时间',
  `user_review_status` tinyint NOT NULL default '1' COMMENT '用户资料审核状态，1为通过，2为审核中，3为未通过，4为还未提交审核',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_id` (`user_id`),
  KEY `idx_username`(`username`),
  KEY `idx_create_time`(`create_time`,`user_review_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站用户基本信息';



CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键Id',
  `gmt_create` datetime NOT NULL COMMENT '创建时间',
   `gmt_modified` datetime NOT NULL COMMENT '修改时间',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `age` int(11) DEFAULT NULL COMMENT '年龄',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  PRIMARY KEY (`id`),
  KEY `idx_com1` (`name`,`age`,`address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';


CREATE TABLE staff (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `work_num` bigint(20) NOT NULL default '0' COMMENT '用户id',
  `username` varchar(45) NOT NULL default '' COMMENT '真实姓名',
  `email` varchar(30) NOT NULL default '' COMMENT '用户邮箱',
  `nickname` varchar(45) NOT NULL default '' COMMENT '昵称',
  `avatar` varchar(200) NOT NULL default '0' COMMENT '头像图片存放地址',
  `birthday` date NOT NULL COMMENT '生日',
  `sex` tinyint(4) not null DEFAULT '0' COMMENT '性别',
  `create_time` datetime NOT NULL default current_timestamp COMMENT '用户记录创建的时间',
  `update_time` datetime default current_timestamp on update current_timestamp NOT NULL COMMENT '用户资料修改的时间',
  `user_review_status` tinyint NOT NULL default '1' COMMENT '用户资料审核状态，1为通过，2为审核中，3为未通过，4为还未提交审核',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_work_num` (`work_num`),
  KEY `idx_staff_name`(`staff_name`),
  KEY `idx_create_time`(`create_time`,`user_review_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='员工信息表';


CREATE TABLE goods (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) NOT NULL default '0' COMMENT '商品id',
  `goods_name` varchar(200) NOT NULL default '' COMMENT '商品名称',
  `order_number` varchar(50) NOT NULL default '' COMMENT '订单号',
  `payment_time` varchar(50) NOT NULL default '' COMMENT '支付时间',  
  `shop_id` bigint(20) NOT NULL default '0' COMMENT '店铺id',
  `leader_nickname` varchar(45) NOT NULL default '' COMMENT '招商团长昵称',
  `leader_duoid` bigint(20) NOT NULL default '0' COMMENT '招商duoid',
  `salesman_nickname` varchar(45) NOT NULL default '' COMMENT '推手昵称',
  `salesman_duoid` bigint(20) NOT NULL default '0' COMMENT '推手duoid',
  `order_status` varchar(20) NOT NULL default '' COMMENT '订单状态',
  `order_amount` bigint(20) NOT NULL default '0' COMMENT '订单金额',
  `salesman_commission` int(5) NOT NULL default '0' COMMENT '推手佣金',
  `leader_commission` int(5) NOT NULL default '0' COMMENT '招商佣金',
  `leader_income` int(10) NOT NULL default '0' COMMENT '招商收入',
  `create_time` datetime NOT NULL default current_timestamp COMMENT '记录创建的时间',
  `update_time` datetime default current_timestamp on update current_timestamp NOT NULL COMMENT '修改的时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_goods_id` (`goods_id`),
  KEY `idx_goods_id`(`goods_id`),
  KEY `idx_create_time`(`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='推广商品明细';


CREATE TABLE staff (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `work_num` varchar(5) NOT NULL default '0' COMMENT '工号',
  `order_number` varchar(50) NOT NULL default '' COMMENT '订单号',
  `create_time` datetime NOT NULL default current_timestamp COMMENT '记录创建的时间',
  `update_time` datetime default current_timestamp on update current_timestamp NOT NULL COMMENT '修改的时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_order_number` (`order_number`),
  KEY `idx_work_num`(`work_num`),
  KEY `idx_order_number`(`order_number`),
  KEY `idx_create_time`(`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='员工业绩表';

