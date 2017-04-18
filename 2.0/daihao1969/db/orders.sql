-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 04 月 14 日 08:28
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `info_of_user`
--

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `openid` varchar(100) NOT NULL,
  `orderid` varchar(15) NOT NULL,
  `addressid` int(11) NOT NULL,
  `state` int(11) NOT NULL COMMENT '0->待付款 1->待发货 2->运输中 3->已完成 4->已取消',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `paytime` int(11) DEFAULT NULL COMMENT '支付时间',
  `freight` decimal(10,2) DEFAULT NULL COMMENT '运费',
  `amount` decimal(10,2) DEFAULT NULL,
  `express` text,
  `enumber` varchar(20) DEFAULT NULL COMMENT '运单号',
  PRIMARY KEY (`orderid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`openid`, `orderid`, `addressid`, `state`, `createtime`, `paytime`, `freight`, `amount`, `express`, `enumber`) VALUES
('oOEo4wdha12cmoJ2WFSAWBZ2vPpA', 'O1492157350', 1492157329, 0, 1492157350, NULL, '0.00', '395.60', '韵达速递', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
