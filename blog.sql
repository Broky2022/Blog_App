-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 12, 2025 lúc 12:26 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(15, 'Kinh Tế', 'chuyện kinh tế'),
(16, 'Chính Trị', 'Chính Trị'),
(17, 'Văn Hóa', 'Văn Hóa'),
(18, 'Thể Thao', 'Thể thao');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(2, 10, 20, 'oh', '2025-04-12 10:15:39'),
(3, 10, 22, 'OMG', '2025-04-12 10:16:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`, `created_at`) VALUES
(17, 6, 20, '2025-04-11 22:36:42'),
(18, 9, 22, '2025-04-11 22:52:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `author_id` int(11) UNSIGNED NOT NULL,
  `is_featured` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `thumbnail`, `date_time`, `category_id`, `author_id`, `is_featured`) VALUES
(6, 'Khẩn trương xây dựng phương án giá dịch vụ tại sân bay Long Thành', 'Cục Hàng không Việt Nam yêu cầu ACV khẩn trương xây dựng phương án giá dịch vụ tại Cảng hàng không quốc tế Long Thành, chuẩn bị cho khai thác từ tháng 6/2026. Trong đó, ưu tiên các dịch vụ chưa được định giá và dịch vụ phục vụ hành khách quốc tế…', '1744385627d785e8d21bd2a88cf1c3.jpg', '2025-04-11 15:33:47', 15, 20, 1),
(7, 'Hấp thụ hàng ngắn hạn, thanh khoản gần 40 ngàn tỷ, khối ngoại cũng đua giá', 'Chiều nay mặc dù có khối lượng cổ phiếu rất lớn tại đáy về tài khoản nhưng bên mua vẫn sẵn sàng đón đỡ. Giá càng về cuối phiên càng mạnh và VN-Index đóng cửa ở mức cao nhất ngày, thanh khoản khớp lệnh sàn HoSE lên trên 37.300 tỷ đồng và tính cả HNX tới gần 40.000 tỷ đồng....', '1744385836ed3dffc5-15eb-4ab8-b363-25446db47f04.png', '2025-04-11 15:37:16', 15, 20, 0),
(8, 'Cần đẩy nhanh tiến độ quy hoạch Di tích quốc gia đặc biệt chùa Đọi Sơn', 'VHO - Đó là yêu cầu của Thứ trưởng Hoàng Đạo Cương tại cuộc họp Hội đồng thẩm định Quy hoạch bảo quản, tu bổ, phục hồi Di tích quốc gia đặc biệt chùa Đọi Sơn (Long Đọi Sơn), thị xã Duy Tiên, tỉnh Hà Nam đến năm 2023, tầm nhìn 2050.', '1744385894thu_truong_2_axwg.jpg', '2025-04-11 15:38:14', 17, 20, 0),
(9, 'Ngắm lễ phục triều đình nhà Nguyễn qua tranh xưa', 'VHO - Bộ tranh “Đại Lễ phục triều đình An Nam” đang được giới thiệu đến công chúng tại không gian trưng bày ở điện Thái Hòa. Đây là những bức tranh được cố họa sĩ Nguyễn Văn Nhân vẽ từ năm 1902.', '1744386512le_phuc_dai_trieu_cybj.jpg', '2025-04-11 15:48:32', 17, 20, 0),
(10, 'Trung ương và Bộ Chính trị thảo luận về sắp xếp bộ máy, tổ chức chính quyền địa phương 2 cấp', 'Trung ương thảo luận nhóm vấn đề về tiếp tục sắp xếp tổ chức bộ máy của hệ thống chính trị, sắp xếp đơn vị hành chính và tổ chức chính quyền địa phương 2 cấp; làm việc tại Tổ, thảo luận nhóm vấn đề về công tác chuẩn bị Đại hội XIV và bầu cử Quốc hội khoá XVI, bầu cử Hội đồng nhân dân các cấp nhiệm kỳ 2026 - 2031.', '1744386692img4687_nvba.jpeg', '2025-04-11 15:51:32', 16, 22, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `two_factor_enabled` tinyint(1) DEFAULT 0,
  `two_factor_secret` varchar(32) DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `is_admin`, `two_factor_enabled`, `two_factor_secret`, `reset_token`, `reset_token_expires`) VALUES
(20, 'KY', 'NGUYEN HOANG', 'admin', 'nhktb2k3@gmail.com', '$2y$10$h/Di7Blj4HjFL2/vMh1ybOLFExmfaO0TNGdF8ZVqVRFVeSGowG7Dy', '1744385350c79ae9a41222df7c8633.jpg', 1, 0, NULL, NULL, NULL),
(21, 'Phuc', 'Khong Mean', 'Fuc', 'Ngong@lmao.com', '$2y$10$hqDnWSknMWm9/6bbnonZnOw93toVFqBbwJe4pFgQfcI6nzAhx5QNm', '1744385521z5024731033957_eea0ed43b7d0b99e810c0e22f8469eed.jpg', 0, 0, NULL, NULL, NULL),
(22, 'NGONG', 'LEE MEAN', 'ngong', 'ngoc@gmail.com', '$2y$10$RppJE8OnGMnr9etSA.Q/P.pWILcO6/6mcxs9Bn3G/8SaodpSxQyJK', '1744386642uiacat.jpg', 0, 0, NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_comment_post` (`post_id`),
  ADD KEY `FK_comment_user` (`user_id`);

--
-- Chỉ mục cho bảng `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_blog_category` (`category_id`),
  ADD KEY `FK_blog_author` (`author_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_comment_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_blog_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_blog_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
