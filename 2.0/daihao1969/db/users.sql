-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 04 月 14 日 08:29
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
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `openid` varchar(100) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `password` varchar(16) DEFAULT NULL,
  `nickname` text CHARACTER SET utf8 NOT NULL,
  `subscribe` tinyint(1) NOT NULL,
  `sex` int(11) NOT NULL DEFAULT '0',
  `city` text CHARACTER SET utf8,
  `country` text CHARACTER SET utf8,
  `province` text CHARACTER SET utf8,
  `language` text NOT NULL,
  `headimgurl` varchar(200) DEFAULT NULL,
  `subscribe_time` int(11) NOT NULL,
  PRIMARY KEY (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`openid`, `phone`, `password`, `nickname`, `subscribe`, `sex`, `city`, `country`, `province`, `language`, `headimgurl`, `subscribe_time`) VALUES
('oOEo4wdha12cmoJ2WFSAWBZ2vPpA', '18202751223', '18202751223', 'MGary', 1, 2, '宜春', '中国', '江西', 'zh_CN', 'http://wx.qlogo.cn/mmopen/fhicotyX5dAfklStTehxynKUgnzjgu1P31eygZicB4jU8L4JI0vrD3Mv79C5D0BrFWZ05QaOialGH75uhqibrGmdxeMShWl82B5J/0', 1489992330);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
