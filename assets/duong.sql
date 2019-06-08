-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 08, 2019 lúc 07:05 AM
-- Phiên bản máy phục vụ: 10.1.35-MariaDB
-- Phiên bản PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `duong`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_metadata`
--

CREATE TABLE `dong_metadata` (
  `metadata_id` int(11) NOT NULL,
  `metadata_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `metadata_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `metadata_des` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `metadata_sub` int(11) NOT NULL,
  `metadata_rule` text COLLATE utf8_unicode_ci NOT NULL,
  `metadata_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_metadata`
--

INSERT INTO `dong_metadata` (`metadata_id`, `metadata_type`, `metadata_name`, `metadata_des`, `metadata_sub`, `metadata_rule`, `metadata_time`) VALUES
(1, 'handbag', 'Trắng Sứ', '', 0, '', '2019-06-08 11:29:08'),
(2, 'handbag', 'Trắng Trong', '', 0, '', '2019-06-08 11:29:49'),
(3, 'handbag', 'Hồng', '', 0, '', '2019-06-08 11:30:05'),
(4, 'handbag', 'HĐ', '', 0, '', '2019-06-08 11:30:09'),
(5, 'handbag', 'Đen', '', 0, '', '2019-06-08 11:30:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_users`
--

CREATE TABLE `dong_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_fullname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_address` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `user_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_id_facebook` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_note` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_users`
--

INSERT INTO `dong_users` (`user_id`, `user_name`, `user_password`, `user_fullname`, `user_address`, `user_phone`, `user_id_facebook`, `user_note`, `user_time`) VALUES
(1, 'dongnv', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn văn Đông', 'Do Hạ', '0966624292', '100006754150548', '', '2019-06-07 15:27:32');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dong_metadata`
--
ALTER TABLE `dong_metadata`
  ADD PRIMARY KEY (`metadata_id`);

--
-- Chỉ mục cho bảng `dong_users`
--
ALTER TABLE `dong_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dong_metadata`
--
ALTER TABLE `dong_metadata`
  MODIFY `metadata_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `dong_users`
--
ALTER TABLE `dong_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
