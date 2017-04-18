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
-- 表的结构 `order_content`
--

CREATE TABLE IF NOT EXISTS `order_content` (
  `contentid` int(11) NOT NULL,
  `orderid` varchar(15) NOT NULL,
  `bookid` varchar(8) NOT NULL,
  `booknum` int(11) NOT NULL,
  PRIMARY KEY (`contentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- 转存表中的数据 `order_content`
--

INSERT INTO `order_content` (`contentid`, `orderid`, `bookid`, `booknum`) VALUES
(1, 'O1492157350', 'book0001', 2),
(2, 'O1492157350', 'book0008', 1),
(3, 'O1492157350', 'book0005', 1),
(4, 'O1492157350', 'book0002', 1),
(5, 'O1492157350', 'book0010', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
