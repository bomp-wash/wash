-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-06-17 03:05:02
-- 伺服器版本： 10.4.19-MariaDB
-- PHP 版本： 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `laundry`
--

-- --------------------------------------------------------

--
-- 資料表結構 `add_money`
--

CREATE TABLE `add_money` (
  `id` int(11) NOT NULL,
  `m_id` varchar(11) NOT NULL COMMENT '會員ID',
  `a_id` varchar(11) NOT NULL COMMENT '員工ID',
  `discount` int(11) DEFAULT NULL COMMENT '2=0.9 3=0.8',
  `money` int(11) NOT NULL COMMENT '儲值金額',
  `time` date NOT NULL COMMENT '到期日',
  `now_time` datetime NOT NULL COMMENT '現在時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `add_money`
--

INSERT INTO `add_money` (`id`, `m_id`, `a_id`, `discount`, `money`, `time`, `now_time`) VALUES
(1, '12345678', 'A0001', 2, 2000, '2024-12-02', '2024-06-12 14:52:14'),
(2, '12345678', 'A0001', 3, 3000, '2024-04-10', '2024-06-12 14:53:50'),
(3, '12345678', 'A0002', 1, 20, '0000-00-00', '2024-06-12 15:09:23'),
(4, '22222222', 'A0002', 1, 10, '2025-12-02', '2024-06-12 15:17:41'),
(5, '22222222', 'A0002', 1, 10, '2024-12-12', '2024-06-12 15:41:26'),
(6, '22222222', 'A0002', 1, 20, '2025-06-12', '2024-06-12 16:11:24'),
(7, '111111111\n', 'A0002', 1, 60, '2024-10-10', '2024-06-12 16:12:34'),
(8, '111111111\n', 'A0001', 1, 30, '2024-12-13', '2024-06-13 14:47:50'),
(9, '111111111\n', 'A0001', 1, 10, '2024-12-13', '2024-06-13 14:56:44'),
(10, '111111111', 'A0001', 1, 10, '2024-12-13', '2024-06-13 15:09:51'),
(11, '22222222', 'A0001', 1, 80, '2024-12-13', '2024-06-13 15:12:00'),
(12, '12345678', 'A0001', 2, 2000, '2024-12-13', '2024-06-13 16:42:44'),
(13, '12345678', 'A0001', 1, 20, '2024-12-13', '2024-06-13 16:48:36'),
(14, '12345678', 'A0001', 2, 2000, '2024-12-13', '2024-06-13 17:49:30'),
(15, '12345678', 'A0001', 2, 2000, '2024-12-14', '2024-06-14 10:36:24'),
(16, '12345678', 'A0001', 1, 20, '2024-12-14', '2024-06-14 16:25:01'),
(17, '12345678', 'A0001', 1, 10, '2024-12-14', '2024-06-14 17:16:00');

-- --------------------------------------------------------

--
-- 資料表結構 `a_user`
--

CREATE TABLE `a_user` (
  `id` int(11) NOT NULL,
  `a_id` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `type` varchar(2) DEFAULT 'u',
  `into_day` date NOT NULL,
  `out_day` date DEFAULT NULL,
  `state` varchar(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `a_user`
--

INSERT INTO `a_user` (`id`, `a_id`, `password`, `name`, `type`, `into_day`, `out_day`, `state`) VALUES
(1, 'admin', '1234', '管理員', 'a', '0000-00-00', '0000-00-00', '0'),
(2, 'A0001', '1234', '員工1', 'u', '2024-06-01', '2024-06-04', '0'),
(3, 'A0002', '1234', '員工2', 'u', '2024-06-04', NULL, '1'),
(4, 'A0003', '1234', '員工3', 'u', '2024-06-04', NULL, '1'),
(5, 'A0004', '1234', '員工4', 'u', '2024-06-04', NULL, '1'),
(6, 'A0005', '1234', '員工5', 'u', '2024-06-04', NULL, '1');

-- --------------------------------------------------------

--
-- 資料表結構 `commodity`
--

CREATE TABLE `commodity` (
  `id` int(11) NOT NULL,
  `c_id` varchar(10) NOT NULL COMMENT '商品變號',
  `c_name` varchar(20) NOT NULL COMMENT '商品名稱',
  `dry` int(11) NOT NULL COMMENT '乾洗',
  `water` int(11) NOT NULL COMMENT '水洗',
  `iro` int(11) NOT NULL COMMENT '熨燙'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `commodity`
--

INSERT INTO `commodity` (`id`, `c_id`, `c_name`, `dry`, `water`, `iro`) VALUES
(1, 'C0001', '襯衫', 95, 60, 50),
(2, 'C0002', 'T桖', 90, 60, 50),
(3, 'C0003', '裙子', 90, 60, 50),
(4, 'C0004', '褲子', 90, 60, 48),
(6, 'C0005', '毛衣', 120, 120, 50);

-- --------------------------------------------------------

--
-- 資料表結構 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `line_name` varchar(20) NOT NULL COMMENT '賴名字',
  `real_name` varchar(20) NOT NULL COMMENT '真名',
  `phone` int(10) NOT NULL COMMENT '電話',
  `money` int(11) NOT NULL,
  `join_day` date NOT NULL COMMENT '註冊日期',
  `birthday` date NOT NULL,
  `email` varchar(30) NOT NULL,
  `address` varchar(50) NOT NULL,
  `discount` int(11) NOT NULL COMMENT '折扣 2=0.8 3=0.9',
  `period` date DEFAULT NULL COMMENT '優惠期間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `members`
--

INSERT INTO `members` (`id`, `line_name`, `real_name`, `phone`, `money`, `join_day`, `birthday`, `email`, `address`, `discount`, `period`) VALUES
(1, 'AA', 'AAA', 12345678, 3556, '2024-06-04', '2014-06-10', '123@12.12', '123456', 2, '2024-12-14'),
(3, 'CC', 'CCC', 22222222, 1000, '2024-06-04', '2024-06-10', '123@12.12', '123456', 2, '2024-06-01'),
(2, 'BB', 'BBB', 111111111, 0, '2024-06-02', '2002-02-05', '123@12.12', '123456', 3, '2024-12-13');

-- --------------------------------------------------------

--
-- 資料表結構 `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL COMMENT '顧客ID(電話)',
  `a_id` varchar(10) NOT NULL COMMENT '員工編號',
  `c_name` varchar(100) NOT NULL COMMENT '商品名稱/項目/數量/價格',
  `all_money` int(10) NOT NULL COMMENT '總金額',
  `add_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `order_details`
--

INSERT INTO `order_details` (`id`, `m_id`, `a_id`, `c_name`, `all_money`, `add_time`) VALUES
(1, 111111111, 'A0001', '襯衫/乾洗/1', 48, '2024-06-02 09:10:41'),
(2, 111111111, 'A0001', 'T桖/乾洗/1', 40, '2024-06-01 11:04:51'),
(3, 111111111, 'A0001', '襯衫/乾洗/1', 80, '2024-06-10 07:19:37'),
(4, 111111111, 'A0001', 'T桖/乾洗/1、襯衫/水洗/1', 120, '2024-06-10 17:05:03'),
(5, 22222222, 'A0001', '襯衫/水洗/1、襯衫/乾洗/1', 140, '2024-06-12 11:05:11'),
(6, 22222222, 'A0001', '襯衫/水洗/1、襯衫/乾洗/1', 140, '2024-06-12 00:00:00'),
(7, 12345678, 'A0001', 'T桖/熨燙/1、T桖/水洗/1、T桖/乾洗/1、襯衫/乾洗/1、T桖/熨T桖/熨燙/1、T桖/水洗/1、T桖/乾洗/1、襯衫/乾洗/1、襯衫/水洗/1、襯衫/熨燙/1燙/1、T桖/水洗/1、T桖/乾洗', 405, '2024-06-12 00:00:00'),
(8, 12345678, 'A0001', '襯衫/乾洗/1、襯衫/水洗/1、襯衫/熨燙/1、T桖/熨燙/1、T桖/水洗/1', 315, '2024-06-12 05:52:35'),
(9, 12345678, 'A0001', '襯衫/水洗/1', 60, '2024-06-12 11:58:49'),
(10, 12345678, 'A0001', 'T桖/水洗/1', 48, '2024-06-13 08:34:29'),
(11, 12345678, 'A0001', 'T桖/乾洗/1', 72, '2024-06-13 08:34:29'),
(12, 12345678, 'A0001', '襯衫/水洗/1', 48, '2024-06-13 08:39:37'),
(13, 12345678, 'A0001', '襯衫/乾洗/1', 76, '2024-06-13 08:39:37'),
(14, 12345678, 'A0001', 'T桖/乾洗/1、襯衫/水洗/1', 120, '2024-06-13 14:42:00'),
(15, 12345678, 'A0001', '襯衫/乾洗/1、T桖/乾洗/1、T桖/水洗/1', 196, '2024-06-13 14:42:25'),
(16, 12345678, 'A0001', '襯衫/乾洗/1、襯衫/水洗/1、襯衫/熨燙/2、T桖/熨燙/1、T桖/水洗/1、T桖/乾洗/3', 635, '2024-06-13 16:49:04'),
(17, 12345678, 'A0001', '襯衫/水洗/4、襯衫/乾洗/5、T桖/熨燙/8、T桖/乾洗/6', 1655, '2024-06-13 16:49:24'),
(18, 12345678, 'A0001', '襯衫/水洗/2、襯衫/乾洗/2', 280, '2024-06-13 17:49:46'),
(19, 12345678, 'A0001', '襯衫/水洗/1', 54, '2024-06-14 10:31:07'),
(20, 12345678, 'A0001', '襯衫/水洗/1、襯衫/乾洗/1', 140, '2024-06-14 10:35:06');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `add_money`
--
ALTER TABLE `add_money`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `a_user`
--
ALTER TABLE `a_user`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `commodity`
--
ALTER TABLE `commodity`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`phone`);

--
-- 資料表索引 `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `add_money`
--
ALTER TABLE `add_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `a_user`
--
ALTER TABLE `a_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `commodity`
--
ALTER TABLE `commodity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `members`
--
ALTER TABLE `members`
  MODIFY `phone` int(10) NOT NULL AUTO_INCREMENT COMMENT '電話', AUTO_INCREMENT=222222223;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
