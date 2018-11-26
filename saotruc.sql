-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 26, 2018 lúc 11:02 AM
-- Phiên bản máy phục vụ: 10.1.28-MariaDB
-- Phiên bản PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `saotruc`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1542959945),
('author', '2', 1542959945);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1542959944, 1542959944),
('author', 1, NULL, NULL, NULL, 1542959944, 1542959944),
('createPost', 2, 'Create a post', NULL, NULL, 1542959944, 1542959944),
('updateOwnPost', 2, 'Update own post', 'isAuthor', NULL, 1542959944, 1542959944),
('updatePost', 2, 'Update post', NULL, NULL, 1542959944, 1542959944);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'author'),
('admin', 'updatePost'),
('author', 'createPost'),
('author', 'updateOwnPost'),
('updateOwnPost', 'updatePost');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 0x4f3a31393a226170705c726261635c417574686f7252756c65223a333a7b733a343a226e616d65223b733a383a226973417574686f72223b733a393a22637265617465644174223b693a313534323935393934343b733a393a22757064617465644174223b693a313534323935393934343b7d, 1542959944, 1542959944);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cronjob`
--

CREATE TABLE `cronjob` (
  `id` int(10) NOT NULL,
  `cronjob_id` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL COMMENT 'Tên cron job',
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL COMMENT 'lớp thực hiện cron job',
  `module_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL COMMENT 'module chứa lớp thực hiện',
  `run_rules` blob NOT NULL COMMENT 'quy tắc lịch thực hiện',
  `last_run` int(10) DEFAULT NULL COMMENT 'thời gian chạy gần nhất',
  `next_run` int(10) DEFAULT NULL COMMENT 'thời gian của làn chạy tới',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'trạng thái active',
  `logging_f` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'log hay không?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `cronjob`
--

INSERT INTO `cronjob` (`id`, `cronjob_id`, `name`, `class`, `module_id`, `run_rules`, `last_run`, `next_run`, `is_active`, `logging_f`) VALUES
(4, 'SendMail', 'SendMail', 'app\\modules\\email\\commands\\SendMail', 'email', 0x7b226d696e75746573223a5b222d31225d2c22686f757273223a5b222d31225d2c226461795f74797065223a22646f77222c22646f77223a5b222d31225d7d, 1542790302, 1542790362, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cronjob_log`
--

CREATE TABLE `cronjob_log` (
  `cronjob_id` char(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `execution_time` int(10) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `cronjob_log`
--

INSERT INTO `cronjob_log` (`cronjob_id`, `execution_time`, `status`) VALUES
('SendMail', 1542265767, 'Success.'),
('SendMail', 1542267693, 'Success.'),
('SendMail', 1542267889, 'Success.'),
('SendMail', 1542268035, 'Success.'),
('SendMail', 1542268917, 'Success.'),
('SendMail', 1542269315, 'Success.'),
('SendMail', 1542269415, 'Success.'),
('SendMail', 1542269511, 'Success.'),
('SendMail', 1542269747, 'Success.'),
('SendMail', 1542269999, 'Success.'),
('SendMail', 1542274107, 'Success.'),
('SendMail', 1542274378, 'Success.'),
('SendMail', 1542274530, 'Success.'),
('SendMail', 1542274656, 'Success.'),
('SendMail', 1542274760, 'Success.'),
('SendMail', 1542274826, 'Success.'),
('SendMail', 1542274927, 'Success.'),
('SendMail', 1542275450, 'Success.'),
('SendMail', 1542275820, 'Success.'),
('SendMail', 1542275894, 'Success.'),
('SendMail', 1542276228, 'Success.'),
('SendMail', 1542276328, 'Success.'),
('SendMail', 1542276608, 'Success.'),
('SendMail', 1542276679, 'Success.'),
('SendMail', 1542276951, 'Success.'),
('SendMail', 1542601855, 'Success.'),
('SendMail', 1542601914, 'Success.'),
('SendMail', 1542601979, 'Success.'),
('SendMail', 1542788057, 'Success.'),
('SendMail', 1542789582, 'Success.'),
('SendMail', 1542790197, 'Success.'),
('SendMail', 1542790302, 'Success.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `email_queue`
--

CREATE TABLE `email_queue` (
  `id` int(11) NOT NULL,
  `from` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'mailer component',
  `to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL COMMENT 'email người nhận',
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL COMMENT 'chủ đề mail',
  `module_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'module id để định vị đường dẫn email template',
  `content_id` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'content id để định vị đường dẫn email template',
  `extra_data` blob COMMENT 'dữ liệu đổ vào email template',
  `created_date` int(11) DEFAULT NULL COMMENT 'ngày tạo',
  `status` tinyint(4) DEFAULT '0' COMMENT 'trạng thái của mail'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `email_queue`
--

INSERT INTO `email_queue` (`id`, `from`, `to`, `subject`, `module_id`, `content_id`, `extra_data`, `created_date`, `status`) VALUES
(4, 'mailer_test', 'ngocdatbk@gmail.com', 'Order success', 'pub', 'order_invoice', 0x613a31353a7b733a323a226964223b693a33333b733a31353a22757365725f6f726465725f6e616d65223b733a333a22646174223b733a31363a22757365725f6f726465725f70686f6e65223b733a31313a223031363636303430363936223b733a31363a22757365725f6f726465725f656d61696c223b733a31393a226e676f63646174626b40676d61696c2e636f6d223b733a31373a22757365725f726563656976655f6e616d65223b733a303a22223b733a31383a22757365725f726563656976655f70686f6e65223b733a303a22223b733a31383a22757365725f726563656976655f656d61696c223b733a303a22223b733a32303a22757365725f726563656976655f61646472657373223b733a393a22746861692062696e68223b733a31303a226f726465725f74696d65223b693a313534323137393532333b733a393a22757365725f6e6f7465223b733a303a22223b733a353a22746f74616c223b693a3630303030303b733a363a22737461747573223b693a303b733a31303a2261646d696e5f6e6f7465223b4e3b733a393a2264656c657465645f66223b4e3b733a363a2264657461696c223b613a323a7b693a353b613a323a7b733a383a227175616e74697479223b693a313b733a363a2264657461696c223b613a383a7b733a323a226964223b693a353b733a343a22636f6465223b733a353a224dc4903031223b733a343a226e616d65223b733a32303a2253c3a16f204dc3a86f20c490656e204dc4903031223b733a343a22696e666f223b733a31343a2253c3a16f204dc3a86f20c490656e223b733a353a227072696365223b693a3430303030303b733a31303a22696d6167655f6d61696e223b733a31363a2275706c6f6164732f746175312e6a7067223b733a31313a2263617465676f72795f6964223b693a313b733a393a2264656c657465645f66223b693a303b7d7d693a393b613a323a7b733a383a227175616e74697479223b693a313b733a363a2264657461696c223b613a383a7b733a323a226964223b693a393b733a343a22636f6465223b733a353a224dc4903033223b733a343a226e616d65223b733a32303a2253c3a16f204dc3a86f20c490656e204dc4903033223b733a343a22696e666f223b733a31343a2253c3a16f204dc3a86f20c490656e223b733a353a227072696365223b693a3230303030303b733a31303a22696d6167655f6d61696e223b733a31373a2275706c6f6164732f74696575312e6a7067223b733a31313a2263617465676f72795f6964223b693a313b733a393a2264656c657465645f66223b693a303b7d7d7d7d, 1542179523, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_vietnamese_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1542957067),
('m140506_102106_rbac_init', 1542957072),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1542957072),
('m181123_072137_init_rbac', 1542957837);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migration_module`
--

CREATE TABLE `migration_module` (
  `version` varchar(180) COLLATE utf8_vietnamese_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  `module` varbinary(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `migration_module`
--

INSERT INTO `migration_module` (`version`, `apply_time`, `module`) VALUES
('m000000_000000_base', 1542620764, ''),
('m181119_080228_create_table_product_category', 1542621281, 0x61646d696e),
('m181119_080306_create_table_product', 1542621281, 0x61646d696e),
('m181119_080322_create_table_product_image', 1542621281, 0x61646d696e),
('m181119_080349_create_table_order', 1542621282, 0x61646d696e),
('m181119_080400_create_table_order_detail', 1542621282, 0x61646d696e),
('m181119_080531_create_table_email_queue', 1542621439, 0x656d61696c5175657565),
('m181119_080612_create_table_cronjob', 1542621395, 0x63726f6e6a6f62),
('m181119_080630_create_table_cronjob_log', 1542621395, 0x63726f6e6a6f62),
('m181119_093258_create_table_setting', 1542621470, 0x73657474696e67);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL COMMENT 'mã order',
  `user_order_name` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'tên người đặt hàng',
  `user_order_phone` char(20) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'sđt người đặt hàng',
  `user_order_email` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'email người đặt hàng',
  `user_receive_name` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'tên người nhận hàng',
  `user_receive_phone` char(20) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'sđt người nhận hàng',
  `user_receive_email` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'email người nhận hàng',
  `user_receive_address` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'địa chỉ nhận hàng',
  `order_time` int(11) NOT NULL DEFAULT '0' COMMENT 'thời gian đặt hàng',
  `user_note` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'ghi chú đặt hàng',
  `total` int(11) NOT NULL DEFAULT '0' COMMENT 'tổng tiền hóa đơn',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'trạng thái đơn hàng',
  `admin_note` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'ghi chú của admin',
  `deleted_f` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'xóa?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`id`, `user_order_name`, `user_order_phone`, `user_order_email`, `user_receive_name`, `user_receive_phone`, `user_receive_email`, `user_receive_address`, `order_time`, `user_note`, `total`, `status`, `admin_note`, `deleted_f`) VALUES
(30, 'dat', '01666040696', 'nhungnguyen@gmail.com', '', '', '', 'thai binh', 1542084305, '', 400000, 0, NULL, 0),
(31, 'dat', '01666040696', 'nhungnguyen@gmail.com', '', '', '', 'thai binh', 1542178091, 'note', 600000, 0, NULL, 0),
(32, 'nhung', '0973571696', 'nhungnguyen@gmail.com', '', '', '', 'thai binh', 1542179057, 'note', 600000, 0, NULL, 0),
(33, 'dat', '01666040696', 'ngocdatbk@gmail.com', '', '', '', 'thai binh', 1542179523, '', 600000, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT 'mã order',
  `product_id` int(11) NOT NULL COMMENT 'mã sản phẩm',
  `quantity` int(11) NOT NULL COMMENT 'số lượng sản phẩm',
  `deleted_f` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'xóa?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`, `deleted_f`) VALUES
(36, 30, 5, 1, 0),
(37, 31, 5, 1, 0),
(38, 31, 9, 1, 0),
(39, 32, 5, 1, 0),
(40, 32, 9, 1, 0),
(41, 33, 5, 1, 0),
(42, 33, 9, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `code` char(20) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'mã sản phẩm',
  `name` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'Tên sản phẩm',
  `info` longtext COLLATE utf8_vietnamese_ci COMMENT 'thông tin chi tiết sản phẩm',
  `price` int(11) DEFAULT '0' COMMENT 'giá',
  `image_main` char(100) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'ảnh chính của sản phẩm',
  `category_id` int(11) NOT NULL COMMENT 'danh mục sản phẩm',
  `deleted_f` tinyint(4) DEFAULT '0' COMMENT 'trạng thái xóa, nhận giá trị 0/1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `code`, `name`, `info`, `price`, `image_main`, `category_id`, `deleted_f`) VALUES
(2, 'BĐ01', 'Sáo Bầu Đen BĐ01', 'Sáo Bầu Đen', 100000, NULL, 2, 0),
(3, 'BĐ02', 'Sáo Bầu Đen BĐ02', 'Sáo Bầu Đen', 200000, NULL, 2, 0),
(4, 'BT01', 'Sáo Bầu Trắng BT01', 'Sáo Bầu Trắng', 200000, NULL, 2, 0),
(5, 'MĐ01', 'Sáo Mèo Đen MĐ01', 'Sáo Mèo Đen', 400000, 'uploads/tau1.jpg', 1, 0),
(6, 'MĐ02', 'Sáo Mèo Đen MĐ02', 'Sáo Mèo Đen', 300000, 'uploads/tau2.jpg', 1, 0),
(8, 'BT02', 'Sáo Bầu Trắng BT02', 'Sáo Bầu Trắng', 250000, NULL, 2, 0),
(9, 'MĐ03', 'Sáo Mèo Đen MĐ03', 'Sáo Mèo Đen', 200000, 'uploads/tieu1.jpg', 1, 0),
(10, 'MĐ04', 'Sáo Mèo Đen MĐ04', 'Sáo Mèo Đen', 300000, 'uploads/tieu2.jpg', 1, 0),
(11, 'MĐ05', 'Sáo Mèo Đen MĐ05', 'Sáo Mèo Đen', 500000, 'uploads/tieu3.jpg', 1, 0),
(12, 'MT01', 'Sáo Mèo Trắng MT01', 'Sáo Mèo Trắng', 400000, 'uploads/tieu2.jpg', 1, 0),
(13, 'MT02', 'Sáo Mèo Trắng MT02', 'Sáo Mèo Trắng', 350000, 'uploads/tieu4.jpg', 1, 0),
(14, 'MT03', 'Sáo Mèo Trắng MT03', 'Sáo Mèo Trắng', 300000, 'uploads/meo1.jpeg', 1, 0),
(15, 'MT04', 'Sáo Mèo Trắng MT04', 'Sáo Mèo Trắng', 250000, 'uploads/meo2.jpeg', 1, 0),
(16, 'MT05', 'Sáo Mèo Trắng MT05', 'Sáo Mèo Trắng', 300000, 'uploads/tau1.jpg', 1, 0),
(17, 'T01', 'Tiêu T01', 'Tiêu ', 500000, NULL, 4, 0),
(18, 'T02', 'Tiêu T02', 'Tiêu', 250000, NULL, 4, 0),
(19, 'T03', 'Tiêu T03', 'REWQRE', 250000, NULL, 4, 0),
(35, 'T04', 'Tiêu T04', 'ytrytry', 400000, 'uploads/tieu2.jpg', 4, 0),
(49, 'MĐ06', 'Sáo Mèo Đen MĐ06', 'Sáo Mèo Đen', 400000, 'uploads/meo1.jpeg', 1, 0),
(50, 'TE01', 'test 01', '<p>Cảm biến v&acirc;n tay dưới m&agrave;n h&igrave;nh, tổng 4 camera, cảm biến nhận diện khu&ocirc;n mặt, định dạng thẻ nhớ nanoSD, sạc kh&ocirc;ng d&acirc;y tương th&iacute;ch ngược...</p>\r\n\r\n<p><a href=\"http://genk.vn/da-co-video-test-cam-bien-van-tay-duoi-man-hinh-cua-huawei-mate-20-pro-20181016102326311.chn\">Đ&atilde; c&oacute; video test cảm biến v&acirc;n tay dưới m&agrave;n h&igrave;nh của Huawei Mate 20 Pro</a></p>\r\n\r\n<p><a href=\"http://genk.vn/mate-20-pro-can-phai-la-mot-sieu-pham-ve-ai-neu-khong-thi-nhung-loi-che-bai-huawei-danh-cho-apple-biet-de-cho-ai-20181014181950858.chn\">Mate 20 Pro cần phải l&agrave; một si&ecirc;u phẩm về AI, nếu kh&ocirc;ng th&igrave; những lời ch&ecirc; bai Huawei d&agrave;nh cho Apple biết để cho ai?</a></p>\r\n\r\n<p><a href=\"http://genk.vn/lo-poster-quang-cao-huawei-mate-20-khoe-ong-kinh-sieu-rong-kha-nang-chup-macro-sieu-dinh-sac-sieu-nhanh-40w-20181015160757342.chn\">Lộ poster quảng c&aacute;o Huawei Mate 20, khoe ống k&iacute;nh si&ecirc;u rộng, khả năng chụp macro si&ecirc;u đỉnh, sạc si&ecirc;u nhanh 40W</a></p>\r\n\r\n<p>Tối nay v&agrave;o l&uacute;c 7h30 (theo giờ Việt Nam), sự kiện ra mắt Mate 20 v&agrave; Mate 20 Pro của Huawei sẽ ch&iacute;nh thức diễn ra. Theo nhiều nguồn tin x&aacute;c nhận, một phi&ecirc;n bản Mate 20X cũng sẽ ra mắt tại sự kiện n&agrave;y. Đ&acirc;y l&agrave; chiếc smartphone chơi game với m&agrave;n h&igrave;nh rất lớn, đi k&egrave;m b&uacute;t stylus v&agrave; hứa hẹn hệ thống tản nhiệt si&ecirc;u khủng.</p>\r\n\r\n<p>Tuy nhi&ecirc;n bộ đ&ocirc;i smartphone Mate 20 v&agrave; Mate 20 Pro cũng sẽ rất đ&aacute;ng ch&uacute; &yacute;, bởi Huawei đ&atilde; t&iacute;ch hợp tất cả những c&ocirc;ng nghệ hiện đại nhất b&acirc;y giờ. Bất kỳ c&ocirc;ng nghệ n&agrave;o bạn thấy tr&ecirc;n những chiếc smartphone cao cấp nhất, cũng đều c&oacute; thể thấy tr&ecirc;n Mate 20 v&agrave; Mate 20 Pro.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"Huawei Mate 20 Pro sẽ là smartphone tổng hợp tất cả những công nghệ cao cấp nhất - Ảnh 1.\" src=\"http://genknews.genkcdn.vn/2018/10/16/photo-1-1539667491326498152482.jpg\" /></p>\r\n\r\n<p>&nbsp;Thậm ch&iacute; bộ đ&ocirc;i smartphone của Huawei c&ograve;n được trang bị những c&ocirc;ng nghệ mới chưa từng thấy trước đ&acirc;y. Như chuẩn thẻ nhớ nanoSD mới, hay c&ocirc;ng nghệ sạc kh&ocirc;ng d&acirc;y tương th&iacute;ch ngược.</p>\r\n\r\n<p>Dưới đ&acirc;y l&agrave; tổng hợp tất cả những t&iacute;nh năng đ&aacute;ng ch&uacute; &yacute; nhất, theo những nguồn tin r&ograve; rỉ được tổng hợp.</p>\r\n\r\n<p><strong>M&agrave;n h&igrave;nh OLED độ ph&acirc;n giải cực khủng, t&iacute;ch hợp cảm biến v&acirc;n tay</strong></p>\r\n\r\n<p>Mate 20 Pro sẽ l&agrave; phi&ecirc;n bản cao cấp hơn, do đ&oacute; cũng được trang bị nhiều c&ocirc;ng nghệ mới hơn. Đ&aacute;ng ch&uacute; &yacute;, Mate 20 Pro sở hữu m&agrave;n h&igrave;nh OLED 6,39 inch với thiết kế tai thỏ, độ ph&acirc;n giải l&ecirc;n tới 3.120 x 1.440 pixel.</p>\r\n\r\n<p>M&agrave;n h&igrave;nh của Mate 20 Pro cũng sẽ được t&iacute;ch hợp cảm biến v&acirc;n tay ngay b&ecirc;n dưới. C&ocirc;ng nghệ cảm biến v&acirc;n tay dưới m&agrave;n h&igrave;nh đ&atilde; được một số nh&agrave; sản xuất sử dụng, tuy nhi&ecirc;n những chiếc smartphone cao cấp nhất hiện nay như iPhone Xs Max hay Galaxy Note9 vẫn chưa hề c&oacute;.</p>\r\n\r\n<p><strong>3 camera sau 40 +20 + 8 MP, ống k&iacute;nh Leica cao cấp</strong></p>\r\n\r\n<p>Camera sau cũng l&agrave; ti&ecirc;u điểm đ&aacute;ng ch&uacute; &yacute; của Mate 20 Pro. Huawei đ&atilde; trang bị tới 3 camera ph&iacute;a sau, gồm một ống k&iacute;nh ch&iacute;nh 40MP f/1.8, ống k&iacute;nh tele 20MP f/2.2 v&agrave; ống k&iacute;nh g&oacute;c si&ecirc;u rộng 8MP f/2.4. Cả 3 ống k&iacute;nh n&agrave;y đều được Leica chứng nhận chất lượng, do đ&oacute; c&oacute; gắn logo của Leica ph&iacute;a tr&ecirc;n.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"Huawei Mate 20 Pro sẽ là smartphone tổng hợp tất cả những công nghệ cao cấp nhất - Ảnh 2.\" src=\"http://genknews.genkcdn.vn/2018/10/16/photo-1-1539667467320606612521.jpg\" /></p>\r\n\r\n<p>&nbsp;Kết hợp với nhau, bộ 3 cảm biến n&agrave;y cung cấp dải ti&ecirc;u cự 16-80 mm, vừa cho ph&eacute;p zoom quang 5x, vừa c&oacute; khả năng chụp macro từ khoảng c&aacute;ch rất gần vật thể. Huawei cho biết khoảng c&aacute;ch gần tối đa l&agrave; 2,5cm.</p>\r\n\r\n<p>Huawei cũng t&iacute;ch hợp c&ocirc;ng nghệ tr&iacute; tuệ nh&acirc;n tạo v&agrave;o camera sau. Sử dụng tới 2 con chip NPU, gi&uacute;p xử l&yacute; h&igrave;nh ảnh cũng như tự động thiết lập ứng dụng camera một c&aacute;ch tối ưu nhất.</p>\r\n\r\n<p><strong>Camera trước 24MP, cảm biến nhận diện khu&ocirc;n mặt</strong></p>\r\n\r\n<p>Camera selfie của Mate 20 Pro cũng khủng kh&ocirc;ng k&eacute;m cụm camera sau, với cảm biến 24MP v&agrave; g&oacute;c chụp si&ecirc;u rộng. B&ecirc;n cạnh đ&oacute;, Mate 20 Pro c&ograve;n được trang bị cảm biến nhận diện khu&ocirc;n mặt giống với Face ID của Apple.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"Huawei Mate 20 Pro sẽ là smartphone tổng hợp tất cả những công nghệ cao cấp nhất - Ảnh 3.\" src=\"http://genknews.genkcdn.vn/2018/10/16/photo-1-15396674583501712688584.jpg\" /></p>\r\n\r\n<p>C&oacute; thể thấy Mate 20 Pro c&oacute; thiết kế tai thỏ, trong khi Mate 20 c&oacute; thiết kế waterdrop. Đ&oacute; ch&iacute;nh l&agrave; do c&aacute;i r&atilde;nh tai thỏ của Mate 20 Pro kh&ocirc;ng chỉ đặt camera trước, m&agrave; c&ograve;n đặt cụm cảm biến khu&ocirc;n mặt rất phức tạp. Sẽ c&oacute; cả một cảm biến hồng ngoại, gi&uacute;p nhận diện khu&ocirc;n mặt trong b&oacute;ng tối.</p>\r\n\r\n<p><strong>Chip Kirin 980 hiệu năng mạnh mẽ</strong></p>\r\n\r\n<p>C&ugrave;ng với Mate 20 v&agrave; Mate 20 Pro, Huawei sẽ ra mắt con chip xử l&yacute; mới nhất của m&igrave;nh l&agrave; Kirin 980. Đ&acirc;y l&agrave; bộ vi xử l&yacute; đầu ti&ecirc;n của Huawei được sản xuất tr&ecirc;n tiến t&igrave;nh 7nm. Theo c&aacute;c kết quả benchmark r&ograve; rỉ, hiệu năng của Kirin 980 vượt xa cả Snapdragon 845 của Qualcomm.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"Huawei Mate 20 Pro sẽ là smartphone tổng hợp tất cả những công nghệ cao cấp nhất - Ảnh 4.\" src=\"http://genknews.genkcdn.vn/2018/10/16/photo-1-1539667475930699846130.jpg\" /></p>\r\n\r\n<p>&nbsp;Bộ vi xử l&yacute; Kirin 980 c&oacute; 8 l&otilde;i, trong đ&oacute; gồm 4 l&otilde;i Cortex-A55 tiết kiệm điện năng, 4 l&otilde;i Cortex-A76 hiệu năng cao (chạy ở tốc độ 1.9 GHz v&agrave; 2.6GHz). B&ecirc;n cạnh đ&oacute; l&agrave; chip đồ họa GPU Mali-G76, cũng l&agrave; GPU đầu ti&ecirc;n tr&ecirc;n tiến tr&igrave;nh 7nm của ARM.</p>\r\n\r\n<p>Bộ nhớ LPDDR4X-RAM c&oacute; thể l&agrave; 6GB hoặc 8GB. Dung lượng lưu trữ 128, 256 hoặc 512 GB, chuẩn UFS 2.1.</p>\r\n\r\n<p><strong>Định dạng thẻ nhớ mới của Huawei</strong></p>\r\n\r\n<p>Nhằm mang t&iacute;nh năng hỗ trợ thẻ nhớ ngo&agrave;i quay trở lại tr&ecirc;n Mate 20 v&agrave; Mate 20 Pro, nhưng đồng thời cũng cải tiến l&ecirc;n một tầm cao mới. Huawei sẽ giới thiệu định dạng thẻ nhớ mới c&oacute; t&ecirc;n nanoSD.&nbsp;</p>\r\n\r\n<p>Về cơ bản, đ&acirc;y sẽ l&agrave; một thẻ nhớ microSD c&oacute; k&iacute;ch thước tương đương một chiếc nanoSIM, với dung lượng c&oacute; thể l&ecirc;n đến 256GB. Tốc độ của chiếc thẻ nanoSD n&agrave;y l&agrave; tương đương với chuẩn microSD. Vấn đề duy nhất l&agrave; bạn sẽ kh&ocirc;ng thể mua thẻ nhớ của c&aacute;c h&atilde;ng thứ 3 với gi&aacute; b&aacute;n rẻ hơn.</p>\r\n\r\n<p><strong>Pin 4.200 mAh với sạc nhanh 40W</strong></p>\r\n\r\n<p>Huawei sẽ trang bị cho Mate 20 Pro vi&ecirc;n pin c&oacute; dung lượng 4.200 mAh, đ&oacute; l&agrave; một vi&ecirc;n pin rất lớn so với hầu hết smartphone cao cấp hiện nay. B&ecirc;n cạnh đ&oacute;, Mate 20 Pro sẽ được hỗ trợ bộ sạc 40W mạnh mẽ, v&agrave; c&ocirc;ng nghệ sạc nhanh chuẩn SuperCharge. Bạn sẽ c&oacute; thể sạc 70% của vi&ecirc;n pin 4.200mAh chỉ trong 30 ph&uacute;t.</p>\r\n\r\n<p><strong>Sạc kh&ocirc;ng d&acirc;y tương th&iacute;ch ngược với c&aacute;c thiết bị kh&aacute;c, c&oacute; thể sạc cho cả smartphone</strong></p>\r\n\r\n<p>Mate 20 Pro được t&iacute;ch hợp c&ocirc;ng nghệ sạc kh&ocirc;ng d&acirc;y. Tuy nhi&ecirc;n điều đ&oacute; kh&ocirc;ng c&oacute; g&igrave; đ&aacute;ng n&oacute;i, m&agrave; điều đặc biệt hơn ch&iacute;nh l&agrave; t&iacute;nh năng tương th&iacute;ch ngược với c&aacute;c thiết bị kh&aacute;c. Về cơ bản bạn c&oacute; thể sử dụng Mate 20 Pro như một chiếc đế sạc kh&ocirc;ng d&acirc;y.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"Huawei Mate 20 Pro sẽ là smartphone tổng hợp tất cả những công nghệ cao cấp nhất - Ảnh 5.\" src=\"http://genknews.genkcdn.vn/2018/10/16/photo-1-15396675027591234767590.jpg\" /></p>\r\n\r\n<p>Huawei t&iacute;ch hợp t&iacute;nh năng đặc biệt n&agrave;y cho Mate 20 Pro nhằm mục đ&iacute;ch l&agrave; để sạc pin cho chiếc tai nghe kh&ocirc;ng d&acirc;y Freebuds 2. Tuy nhi&ecirc;n một số nguồn tin tiết lộ rằng t&iacute;nh năng n&agrave;y c&oacute; thể được d&ugrave;ng để sạc pin cho những chiếc smartphone kh&aacute;c cũng hỗ trợ sạc kh&ocirc;ng d&acirc;y. V&iacute; dụ bạn c&oacute; thể &aacute;p lưng Mate 20 Pro v&agrave;o một chiếc iPhone Xs Max để sạc pin.</p>\r\n\r\n<p>Theo những th&ocirc;ng tin r&ograve; rỉ, Huawei Mate 20 Pro với 6GB RAM v&agrave; dung lượng 128GB c&oacute; gi&aacute; b&aacute;n 999 EUR (1.155 USD) tại Ch&acirc;u &Acirc;u.</p>\r\n', 400000, 'uploads/tieu2.jpg', 1, 0),
(51, 'MĐ07', 'Sáo Mèo Đen MĐ07', '<p>sfdsf</p>', 300000, 'uploads/meo1.jpeg', 1, 0),
(52, 'TEST001', 'Sáo mèo TEST001', '<p>DASDSA</p>', 400000, 'uploads/meo1.jpeg', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'Tên danh mục',
  `description` longtext COLLATE utf8_vietnamese_ci COMMENT 'Mô tả về danh mục sản phẩm',
  `deleted_f` tinyint(4) DEFAULT '0' COMMENT 'trạng thái của danh mục. nhận giá trị 0/1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `description`, `deleted_f`) VALUES
(1, 'Sáo mèo', '', 0),
(2, 'Sáo bầu', '', 0),
(4, 'Tiêu', '', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT 'id sản phẩm',
  `image` char(100) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'đường dẫn ảnh',
  `description` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'mô tả đi kèm',
  `is_main` tinyint(4) DEFAULT '0' COMMENT 'có phải là ảnh chính'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image`, `description`, `is_main`) VALUES
(8, 49, 'uploads/meo1.jpeg', '', 1),
(9, 49, 'uploads/meo2.jpeg', '', NULL),
(12, 50, 'uploads/tieu2.jpg', '', 1),
(13, 50, 'uploads/tieu3.jpg', '', NULL),
(14, 50, 'uploads/tieu4.jpg', '', NULL),
(15, 51, 'uploads/meo1.jpeg', '', 1),
(16, 5, 'uploads/tau1.jpg', '', 1),
(17, 6, 'uploads/tau2.jpg', '', 1),
(18, 9, 'uploads/tieu1.jpg', '', 1),
(19, 10, 'uploads/tieu2.jpg', '', 1),
(20, 11, 'uploads/tieu3.jpg', '', 1),
(21, 13, 'uploads/tieu4.jpg', '', 1),
(22, 12, 'uploads/tieu2.jpg', '', 1),
(23, 14, 'uploads/meo1.jpeg', '', 1),
(24, 15, 'uploads/meo2.jpeg', '', 1),
(25, 16, 'uploads/tau1.jpg', '', 1),
(28, 5, 'uploads/meo2.jpeg', '', NULL),
(33, 52, 'uploads/meo1.jpeg', '', 1),
(34, 52, 'uploads/meo2.jpeg', '', NULL),
(35, 52, 'uploads/tau1.jpg', '', NULL),
(36, 52, 'uploads/tau2.jpg', '', NULL),
(37, 52, 'uploads/tieu1.jpg', '', NULL),
(38, 52, 'uploads/tieu2.jpg', '', NULL),
(39, 52, 'uploads/tieu3.jpg', '', NULL),
(40, 52, 'uploads/tieu4.jpg', '', NULL),
(41, 52, 'uploads/sao01.jpg', '', NULL),
(42, 52, 'uploads/sao02.jpeg', '', NULL),
(43, 52, 'uploads/sao03.jpeg', '', NULL),
(44, 52, 'uploads/sao04.jpeg', '', NULL),
(45, 52, 'uploads/sao05.jpeg', '', NULL),
(46, 52, 'uploads/sao06.jpeg', '', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `setting`
--

CREATE TABLE `setting` (
  `key` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `modified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `setting`
--

INSERT INTO `setting` (`key`, `value`, `modified`) VALUES
('email', 'ngocdatbk@gmail.com', 1542771412),
('email_pass', 'ÆsÁäa>¦\'`Ó÷Î<ã&39533cf247dcc04a72ea4ac5275630ea95e563ce853e576fbcf5692ca816aecfFxÈ÷eÄV41¸ÚXÁ\r ,ç¬Þ0;Lî©¸è{', 1542773030),
('gender', '1', 1542786413),
('is_admin', '0', 1542787389),
('name', 'khuc ngoc dat', 1542771412),
('status', '1', 1542773038);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) NOT NULL,
  `gender` enum('Male','Female','Unspecified') DEFAULT 'Unspecified',
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) UNSIGNED DEFAULT '0',
  `last_login` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `username`, `gender`, `email`, `phone_number`, `fullname`, `is_active`, `is_admin`, `last_login`) VALUES
(1, 'datkhucngoc@admicro.vn', 'Male', 'datkhucngoc@admicro.vn', NULL, 'Khúc Ngọc Đạt', 1, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_auth`
--

CREATE TABLE `user_auth` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `user_auth`
--

INSERT INTO `user_auth` (`user_id`, `auth_key`, `password_hash`) VALUES
(1, 'nr2-PnAs9CpYIbJo3m-1HcsHzM9R-Bte', '$2y$13$QLOfCFsV5/tvYJg8CbjkUuhCOBSfU9Nx92PJzWaSfHSJ94UOCtmuu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_confirm`
--

CREATE TABLE `user_confirm` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `confirm_key` varbinary(32) NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_login_attempts`
--

CREATE TABLE `user_login_attempts` (
  `login` varchar(80) NOT NULL,
  `login_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Chỉ mục cho bảng `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Chỉ mục cho bảng `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Chỉ mục cho bảng `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Chỉ mục cho bảng `cronjob`
--
ALTER TABLE `cronjob`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `email_queue`
--
ALTER TABLE `email_queue`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Chỉ mục cho bảng `migration_module`
--
ALTER TABLE `migration_module`
  ADD PRIMARY KEY (`version`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `user_confirm`
--
ALTER TABLE `user_confirm`
  ADD PRIMARY KEY (`confirm_key`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cronjob`
--
ALTER TABLE `cronjob`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `email_queue`
--
ALTER TABLE `email_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'mã order', AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22831;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
