-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 09, 2024 lúc 09:07 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `phptt`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `total` decimal(30,0) NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bill`
--

INSERT INTO `bill` (`id`, `full_name`, `email`, `phone`, `address`, `order_id`, `product_name`, `size`, `total`, `status`, `user_id`, `created_at`) VALUES
(94, 'Hoàng Đặng', 'hoangdang3210@gmail.com', '0827249248', '106 Hoàng Tăng Bí', 238, 'Dortmund Home (2024-2025)', '', 410000, '2', 23, '2024-10-03 07:29:44'),
(95, 'Hoàng Đặng', 'hoangdang3210@gmail.com', '0827249248', '106 Hoàng Tăng Bí', 240, 'Arsenal Home (1992/1994) Màu đỏ', '', 1925000, '1', 23, '2024-10-02 04:29:44'),
(96, 'Đặng Đình Hoàng', 'hoangdang3210@gmail.com', '827249248', '106 Hoàng Tăng Bí', 245, 'BĐN Home (2024 - 2025) (x4)', 'X', 1374000, '2', 23, '2024-10-08 07:29:44'),
(97, 'Hoàng Đặng', 'hoangdang3210@gmail.com', '827249248', '106 Hoàng Tăng Bí, Hoà An, Cẩm Lệ', 247, 'Cốc Giữ Nhiệt Logo MU Đỏ (x2)', '', 490000, '2', 25, '2024-09-09 04:29:44'),
(98, 'Hoàng Đặng', 'hoangdang3210@gmail.com', '0827249248', '106 Hoàng Tăng Bí', 249, 'BĐN Home (2024 - 2025)', '', 1018000, '2', 26, '2024-10-08 08:26:55'),
(99, 'Hoàng Đặng', 'hoangdang3210@gmail.com', '0827249248', '106 Hoàng Tăng Bí', 251, 'Đức Home (2024 - 2025)', 'M', 771000, '1', 26, '2024-10-08 08:28:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(20,0) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `coupon` decimal(20,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `image`, `name`, `price`, `size`, `coupon`) VALUES
(228, 26, 16, 3, 'photo-2024-07-01-20-38-04-3_1721637312_669e19c059118.jpg', 'Đức Home (2024 - 2025)', 257000, '', NULL),
(229, 23, 14, 2, 'photo-2024-06-26-13-23-57-2_1721636815_669e17cff121f.jpg', 'Anh Home (2024 - 2025)', 180000, 'M', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `image`) VALUES
(3, 'Áo tuyển quốc gia', 'photo-2024-07-01-20-38-03_1721636615_669e1707e5925.jpg'),
(4, 'Áo CLB', 'photo-2024-07-25-20-26-21-copy-1_1722848042_66b0932a36891.jpg'),
(5, 'Phụ kiện', '397acf31-c5cb-4de7-995b-36c000ea_1721654708_669e5db4ce6b5.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `user_id`, `username`, `text`, `date`) VALUES
(38, 21, 23, 'Hoàng', 'Áo đẹp', '2024-10-05 06:45:15'),
(39, 23, 23, 'Hoà', 'Áo màu đẹp, sáng da', '2024-09-28 03:45:35'),
(40, 14, 23, 'Hải', 'Màu đẹp', '2024-10-05 05:45:54'),
(41, 15, 23, 'Thanh', 'Đội tôi rất thích', '2024-10-08 06:46:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `max_uses` int(11) DEFAULT 1,
  `uses` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_amount`, `max_uses`, `uses`, `created_at`, `end_date`) VALUES
(6, '10thang10', 50000.00, 7, 0, '2024-10-07 21:02:06', '2024-10-11 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(30,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `created_at`, `updated_at`, `status`) VALUES
(237, 23, 410000, '2024-10-07 20:50:22', '2024-10-07 20:50:22', '1'),
(238, 23, 410000, '2024-10-07 20:50:51', '2024-10-07 20:50:51', '1'),
(239, 23, 1925000, '2024-10-07 20:57:53', '2024-10-07 20:57:53', '1'),
(240, 23, 1925000, '2024-10-07 20:58:08', '2024-10-07 20:58:08', '1'),
(241, 23, 1424000, '2024-10-08 06:51:23', '2024-10-08 06:51:23', '1'),
(242, 23, 1424000, '2024-10-08 06:51:37', '2024-10-08 06:51:37', '1'),
(243, 23, 1424000, '2024-10-08 06:51:45', '2024-10-08 06:52:40', '2'),
(244, 23, 1424000, '2024-10-08 06:53:55', '2024-10-08 06:53:55', '1'),
(245, 23, 1424000, '2024-10-08 06:54:06', '2024-10-08 06:58:48', '2'),
(246, 25, 540000, '2024-10-08 07:08:33', '2024-10-08 07:08:33', '1'),
(247, 25, 540000, '2024-10-08 07:09:07', '2024-10-08 07:09:29', '2'),
(248, 26, 1068000, '2024-10-08 08:26:43', '2024-10-08 08:26:43', '1'),
(249, 26, 1068000, '2024-10-08 08:26:55', '2024-10-08 08:26:55', '1'),
(250, 26, 771000, '2024-10-08 08:28:06', '2024-10-08 08:28:06', '1'),
(251, 26, 771000, '2024-10-08 08:28:11', '2024-10-08 08:28:11', '1'),
(252, 26, 771000, '2024-10-08 08:29:18', '2024-10-08 08:29:18', '1'),
(253, 26, 771000, '2024-10-08 08:29:21', '2024-10-08 08:29:52', 'thất bại'),
(254, 26, 771000, '2024-10-08 08:30:07', '2024-10-08 08:31:07', '2'),
(255, 26, 771000, '2024-10-08 08:31:45', '2024-10-08 08:31:45', '1'),
(256, 26, 771000, '2024-10-08 08:31:52', '2024-10-08 08:32:43', '2'),
(257, 26, 771000, '2024-10-08 08:33:10', '2024-10-08 08:34:01', '2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `coupon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `size`, `quantity`, `price`, `coupon`, `created_at`, `updated_at`) VALUES
(286, 237, 19, '', 1, 410000.00, NULL, '2024-10-07 20:50:22', '2024-10-07 20:50:22'),
(287, 238, 19, '', 1, 410000.00, NULL, '2024-10-07 20:50:51', '2024-10-07 20:50:51'),
(288, 239, 25, '', 5, 385000.00, NULL, '2024-10-07 20:57:53', '2024-10-07 20:57:53'),
(289, 240, 25, '', 5, 385000.00, NULL, '2024-10-07 20:58:08', '2024-10-07 20:58:08'),
(290, 241, 15, 'X', 4, 356000.00, NULL, '2024-10-08 06:51:23', '2024-10-08 06:51:23'),
(291, 242, 15, 'X', 4, 356000.00, NULL, '2024-10-08 06:51:37', '2024-10-08 06:51:37'),
(292, 243, 15, 'X', 4, 356000.00, NULL, '2024-10-08 06:51:45', '2024-10-08 06:51:45'),
(293, 244, 15, 'X', 4, 356000.00, NULL, '2024-10-08 06:53:55', '2024-10-08 06:53:55'),
(294, 245, 15, 'X', 4, 356000.00, NULL, '2024-10-08 06:54:06', '2024-10-08 06:54:06'),
(295, 246, 20, '', 2, 270000.00, NULL, '2024-10-08 07:08:33', '2024-10-08 07:08:33'),
(296, 247, 20, '', 2, 270000.00, NULL, '2024-10-08 07:09:07', '2024-10-08 07:09:07'),
(297, 248, 15, '', 3, 356000.00, NULL, '2024-10-08 08:26:43', '2024-10-08 08:26:43'),
(298, 249, 15, '', 3, 356000.00, NULL, '2024-10-08 08:26:55', '2024-10-08 08:26:55'),
(299, 250, 16, 'M', 3, 257000.00, NULL, '2024-10-08 08:28:06', '2024-10-08 08:28:06'),
(300, 251, 16, 'M', 3, 257000.00, NULL, '2024-10-08 08:28:11', '2024-10-08 08:28:11'),
(301, 252, 16, '', 3, 257000.00, NULL, '2024-10-08 08:29:18', '2024-10-08 08:29:18'),
(302, 253, 16, '', 3, 257000.00, NULL, '2024-10-08 08:29:21', '2024-10-08 08:29:21'),
(303, 254, 16, '', 3, 257000.00, NULL, '2024-10-08 08:30:07', '2024-10-08 08:30:07'),
(304, 255, 16, '', 3, 257000.00, NULL, '2024-10-08 08:31:45', '2024-10-08 08:31:45'),
(305, 256, 16, '', 3, 257000.00, NULL, '2024-10-08 08:31:52', '2024-10-08 08:31:52'),
(306, 257, 16, '', 3, 257000.00, NULL, '2024-10-08 08:33:10', '2024-10-08 08:33:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `product_name`, `image`, `price`, `quantity`, `size`, `description`, `category_id`) VALUES
(14, 'Anh Home (2024 - 2025)', 'photo-2024-06-26-13-23-57-2_1721636815_669e17cff121f.jpg', 180000, 9, 'S,M,X,XL,XXL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 3),
(15, 'BĐN Home (2024 - 2025)', 'photo-2024-07-01-20-38-03-3_1721637277_669e199d42170.jpg', 356000, 0, 'S,M,X,XL,XXL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 3),
(16, 'Đức Home (2024 - 2025)', 'photo-2024-07-01-20-38-04-3_1721637312_669e19c059118.jpg', 257000, 8, 'S,M,X,XL,XXL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 3),
(17, 'Pháp Home (2024 - 2025)', 'photo-2024-07-04-14-40-07_1721637373_669e19fd84ae0.jpg', 236000, 9, 'S,M,X,XL,XXL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 3),
(18, 'TBN Home (2024 - 2025)', 'photo-2024-07-04-14-22-26_1721637418_669e1a2ae054d.jpg', 156000, 10, 'S,M,X,XL,XXL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 3),
(20, 'Cốc Giữ Nhiệt Logo MU Đỏ', 'photo-2024-05-27-09-27-59-2-1-1_1721658222_669e6b6e3e734.jpg', 270000, 15, '300ml,500ml', 'Thông tin sản phẩm đang được cập nhật', 5),
(21, 'Juventus Home (2024-2025)', 'photo-2024-06-26-13-22-53_1722092487_66a50bc760a38.jpg', 320000, 31, 'S,M,X,XL,XXL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 4),
(23, 'MU Away (2024-2025)', 'photo-2024-07-25-20-26-21-copy-1_1722848042_66b0932a36891.jpg', 310000, 10, 'X, S, M, XL, XXL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 4),
(30, 'CABJ Home (2023-2024', 'Áo-CABJ_1728373377_6704e28119ec7.jpg', 200000, 20, 'X, XL, S,M', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 4),
(31, 'ASENAL Away (2023-2024)', 'z2559805305470_613248066b291e829bfaed2d0b6d3574_1728373471_6704e2df3e6b2.jpg', 350000, 15, 'X,S,M,L,XL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 4),
(32, 'Việt Nam Home (2023-2024)', '0020625_bo-quan-ao-bong-da-doi-t_1720506835_668cd9d34aa1f_1728373540_6704e324b9263.jpg', 250000, 25, 'X,S,M,L,XL,XXL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 3),
(33, 'Real Mandrid (2023-2024)', '61d536c4076ac034997b_7ea46338c4f54d93bd49ddefd18feeab_1024x1024_1728373882_6704e47a2f768.jpg', 300000, 10, 'X, XL, S,M', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 4),
(34, 'Man City Home (2023-2024)', 'c0efbc5f4e282d7baad12b78d155cd94_1728373929_6704e4a9b7dee.jpg', 270000, 10, 'X,S,M,L,XL', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 4),
(35, 'Cờ lưu niệm', 'In-Co-Luu-Niem-Bong-Da-2_1728374253_6704e5edba881.jpg', 50000, 50, 'Nhỏ,Vừa,To', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 5),
(36, 'Huy chương', 'Huy-chuong_1728374286_6704e60ea2fa1.jpg', 5000, 100, 'Đồng, Bạc, Vàng', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 5),
(37, 'Bóng đá', '20240307_Lj5GK4dzMZ_1728374315_6704e62b03369.jpeg', 240000, 60, '4,5', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 5),
(38, 'Cúp vô địch', 'Cup-co-huy-chuong-the-thao_1728374367_6704e65f805eb.jpg', 200000, 100, 'Nhỏ, Vừa, To', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 5),
(39, 'Tất trống trơn', 'tat-chong-tron-da-bong-loai-2-scaled_1728374471_6704e6c7cdb3b.jpg', 30000, 100, 'Lửng, Cao', 'Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'user',
  `google_id` varchar(255) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `full_name`, `address`, `role`, `google_id`, `otp`, `created_at`) VALUES
(23, 'admin', 'hoangdang3210@gmail.com', '$2y$10$vCRE27IDxa6fEbqqqA15le3UL5NDcA9bd9ibj/lt4huVJlgo8U6kq', 827249248, 'Đặng Đình Hoàng', NULL, 'admin', NULL, '744818', '2024-10-08 08:10:31'),
(25, 'GoogleUser1086', 'hoangdang3210@gmail.com', NULL, 827249248, 'Hoàng Đặng', '106 Hoàng Tăng Bí, Hoà An, Cẩm Lệ', 'user', '104970082627618590223', '744818', '2024-10-08 08:10:31'),
(26, 'thinh01', 'hoangdang3210@gmail.com', '$2y$10$rD8AbpYNRRAalSnHxwQfW.HedsMODyeCmfnm9Df.5psG22p8f55.e', 827249248, 'Hoàng Đặng', '106 Hoàng Tăng Bí', 'user', NULL, NULL, '2024-10-08 08:06:50'),
(30, '', '', '$2y$10$6pQm5Wrl.81z2gKHmq36ues97omOXBBAz9GYrbQL8CV7S4yoUFqbW', 0, NULL, NULL, 'user', NULL, NULL, '2024-10-08 10:29:02'),
(31, 'dihxrid', 'hoangdang3210@gmail.com', '$2y$10$tX9F0dzGFEp8uH5jppiYZuamESfN3WxCJKe8Kq.KpH5AZtG1hWMRG', 827249248, NULL, NULL, 'user', NULL, NULL, '2024-10-08 10:38:38');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bill_order` (`order_id`),
  ADD KEY `fk_bill_user` (`user_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_users` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order` (`order_id`),
  ADD KEY `fk_order_details_product` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `fk_bill_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_bill_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
