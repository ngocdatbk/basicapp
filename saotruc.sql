-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2018 at 03:57 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saotruc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_navigation`
--

CREATE TABLE `admin_navigation` (
  `navigation_id` varbinary(30) NOT NULL,
  `label` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `menu_group` varbinary(30) DEFAULT NULL,
  `parent_id` varbinary(30) DEFAULT '0',
  `level` int(11) UNSIGNED DEFAULT '0',
  `label_type` varbinary(30) DEFAULT NULL,
  `permission_type` varbinary(30) DEFAULT NULL,
  `permission` varchar(255) DEFAULT NULL,
  `debug_only` tinyint(1) DEFAULT '0',
  `display_order` int(11) UNSIGNED DEFAULT '0',
  `created_date` int(11) UNSIGNED DEFAULT '0',
  `created_by` int(11) UNSIGNED DEFAULT '0',
  `updated_date` int(11) UNSIGNED DEFAULT '0',
  `updated_by` int(11) UNSIGNED DEFAULT '0',
  `display_f` tinyint(1) DEFAULT '1',
  `module_id` varbinary(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_navigation`
--

INSERT INTO `admin_navigation` (`navigation_id`, `label`, `icon`, `url`, `menu_group`, `parent_id`, `level`, `label_type`, `permission_type`, `permission`, `debug_only`, `display_order`, `created_date`, `created_by`, `updated_date`, `updated_by`, `display_f`, `module_id`) VALUES
(0x566965776173, 'View as', '', '/permission/permission/view-as', 0x736964656261725f6d656e75, 0x6d616e616765725f75736572, 1, 0x74657874, 0x7065726d697373696f6e, 'viesAsPermisson', 0, 5, 1544901306, 5, 0, 0, 1, NULL),
(0x61646d696e5f6e617669676174696f6e, 'Admin navigation', '', '/core/admin-navigation', 0x736964656261725f6d656e75, 0x6d656e755f73657474696e67, 1, 0x74657874, '', '', 0, 4, 1544693362, 5, 0, 0, 1, NULL),
(0x63726f6e5f7461736b73, 'Cron tasks', '', '/cronjob', 0x736964656261725f6d656e75, 0x73797374656d5f746f6f6c73, 1, 0x74657874, '', '', 0, 0, 1544609992, 5, 0, 0, 1, NULL),
(0x64617368626f617264, 'Dashboard', 'fa-dashboard', '/dashboard/dashboard', 0x736964656261725f6d656e75, 0x30, 0, 0x74657874, '', '', 0, 1, 1544609517, 5, 1544695932, 5, 1, NULL),
(0x6d616e6167655f73657474696e67, 'Manage Setting', '', '/setting', 0x736964656261725f6d656e75, 0x6d656e755f73657474696e67, 1, 0x74657874, '', '', 0, 5, 1544610144, 5, 1544778019, 5, 1, NULL),
(0x6d616e616765725f7065726d697373696f6e73, 'Manager permissions', '', '/permission/permission', 0x736964656261725f6d656e75, 0x6d616e616765725f75736572, 1, 0x74657874, '', '', 0, 3, 1544610055, 5, 1544816623, 5, 1, NULL),
(0x6d616e616765725f726f6c6573, 'Manager roles', '', '/permission/role', 0x736964656261725f6d656e75, 0x6d616e616765725f75736572, 1, 0x74657874, '', '', 0, 2, 1544610081, 5, 1544816604, 5, 1, NULL),
(0x6d616e616765725f72756c6573, 'Manager rules', '', '/permission/rule', 0x736964656261725f6d656e75, 0x6d616e616765725f75736572, 1, 0x74657874, '', '', 0, 4, 1544610106, 5, 1544816615, 5, 1, NULL),
(0x6d616e616765725f75736572, 'Manager User', 'fa-users', '', 0x736964656261725f6d656e75, 0x30, 0, 0x74657874, 0x7065726d697373696f6e, 'MenuUser', 0, 7, 1544609634, 5, 1544817049, 5, 1, NULL),
(0x6d656e755f73657474696e67, 'Setting', 'fa-gear', '', 0x736964656261725f6d656e75, 0x30, 0, 0x74657874, 0x7065726d697373696f6e, 'MenuSetting', 0, 8, 1544609692, 5, 1544817070, 5, 1, NULL),
(0x6f726465725f6c697374, 'Order list', '', '/report/order', 0x736964656261725f6d656e75, 0x7265706f7274, 1, 0x74657874, '', '', 0, 0, 1544609964, 5, 0, 0, 1, NULL),
(0x70726f64756374, 'Product', '', '/admin/product', 0x736964656261725f6d656e75, 0x6d656e755f73657474696e67, 1, 0x74657874, '', '', 0, 2, 1544609933, 5, 1544816686, 5, 1, NULL),
(0x70726f647563745f63617465676f7279, 'Product Category', '', '/admin/product-category', 0x736964656261725f6d656e75, 0x6d656e755f73657474696e67, 1, 0x74657874, '', '', 0, 3, 1544609729, 5, 1544816695, 5, 1, NULL),
(0x7265706f7274, 'Report', 'fa-bar-chart', '', 0x736964656261725f6d656e75, 0x30, 0, 0x74657874, 0x7065726d697373696f6e, 'MenuReport', 0, 4, 1544609584, 5, 1544817004, 5, 1, NULL),
(0x73797374656d5f746f6f6c73, 'System tools', 'fa-magic', '', 0x736964656261725f6d656e75, 0x30, 0, 0x74657874, 0x7065726d697373696f6e, 'MenuSystemTool', 0, 5, 1544609608, 5, 1544817021, 5, 1, NULL),
(0x757365725f6c697374, 'User list', '', '/user/user', 0x736964656261725f6d656e75, 0x6d616e616765725f75736572, 1, 0x74657874, '', '', 0, 0, 1544610026, 5, 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Admin', '5', 1544436446),
('Modarator', '1', 1544518164),
('Sale', '8', 1544518175);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Admin', 1, 'Admin', NULL, NULL, 1542959944, 1544413393),
('CreateCronTask', 2, 'Create Cron Task', NULL, NULL, 1544516838, 1544516838),
('CreateOrder', 2, 'Create Order', NULL, NULL, 1544516696, 1544516696),
('CreatePermission', 2, 'Create Permission', NULL, NULL, 1544517120, 1544517120),
('CreateProduct', 2, 'Create product', NULL, NULL, 1544381778, 1544382919),
('CreateProductCategory', 2, 'Create Product Category', NULL, NULL, 1544516592, 1544516592),
('CreateRole', 2, 'Create Role', NULL, NULL, 1544517188, 1544517188),
('CreateRule', 2, 'Create Rule', NULL, NULL, 1544517246, 1544517246),
('CreateSetting', 2, 'Create Setting', NULL, NULL, 1544429235, 1544429235),
('CreateUser', 2, 'Create User', NULL, NULL, 1544412139, 1544412139),
('CronTask', 2, 'Cron Task', NULL, NULL, 1544516812, 1544516812),
('DeleteCronTask', 2, 'Delete Cron Task', NULL, NULL, 1544516882, 1544516882),
('DeleteOrder', 2, 'Delete Order', NULL, NULL, 1544516754, 1544516754),
('DeletePermission', 2, 'Delete Permission', NULL, NULL, 1544517164, 1544517164),
('DeleteProduct', 2, 'Delete Product', NULL, NULL, 1544382106, 1544382106),
('DeleteProductCategory', 2, 'Delete Product Category', NULL, NULL, 1544516636, 1544516636),
('DeleteRole', 2, 'Delete Role', NULL, NULL, 1544517226, 1544517226),
('DeleteRule', 2, 'Delete Rule', NULL, NULL, 1544517282, 1544517282),
('DeleteSetting', 2, 'Delete Setting', NULL, NULL, 1544429277, 1544429277),
('DeleteUser', 2, 'Delete User', NULL, NULL, 1544413200, 1544413200),
('MenuReport', 2, 'Menu Report', NULL, NULL, 1544433107, 1544516933),
('MenuSetting', 2, 'Menu Setting', NULL, NULL, 1544517010, 1544517010),
('MenuSystemTool', 2, 'Menu System Tool', NULL, NULL, 1544516781, 1544516952),
('MenuUser', 2, 'Menu User', NULL, NULL, 1544516972, 1544516972),
('Modarator', 1, 'Modarator', NULL, NULL, 1544433088, 1544433088),
('Order', 2, 'Order', NULL, NULL, 1544516673, 1544516673),
('Permission', 2, 'Permission', NULL, NULL, 1544517056, 1544816786),
('Product', 2, 'Product', NULL, NULL, 1544381567, 1544816847),
('ProductCategory', 2, 'Product Category', NULL, NULL, 1544516559, 1544816863),
('Role', 2, 'Role', NULL, NULL, 1544517073, 1544816809),
('Rule', 2, 'Rule', NULL, NULL, 1544517089, 1544816826),
('Sale', 1, 'Sale', NULL, NULL, 1542959944, 1544413370),
('Setting', 2, 'Setting', NULL, NULL, 1544429151, 1544517024),
('UpdateCronTask', 2, 'Update Cron Task', NULL, NULL, 1544516857, 1544516857),
('UpdateOrder', 2, 'Update Order', NULL, NULL, 1544516723, 1544516723),
('UpdatePermission', 2, 'Update Permission', NULL, NULL, 1544517137, 1544517137),
('UpdateProduct', 2, 'Update Product', NULL, NULL, 1544382073, 1544382073),
('UpdateProductCategory', 2, 'Update Product Category', NULL, NULL, 1544516614, 1544516614),
('UpdateRole', 2, 'Update Role', NULL, NULL, 1544517206, 1544517206),
('UpdateRule', 2, 'Update Rule', NULL, NULL, 1544517263, 1544517263),
('UpdateSetting', 2, 'Update Setting', NULL, NULL, 1544429261, 1544429261),
('UpdateUser', 2, 'Update User', NULL, NULL, 1544412159, 1544413165),
('User', 2, 'User', NULL, NULL, 1544412120, 1544516986),
('viesAsPermisson', 2, 'view As Permisson', NULL, NULL, 1544899092, 1544899092);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('Admin', 'MenuReport'),
('Admin', 'MenuSetting'),
('Admin', 'MenuSystemTool'),
('Admin', 'MenuUser'),
('CronTask', 'CreateCronTask'),
('CronTask', 'DeleteCronTask'),
('CronTask', 'UpdateCronTask'),
('MenuReport', 'Order'),
('MenuSetting', 'Product'),
('MenuSetting', 'ProductCategory'),
('MenuSetting', 'Setting'),
('MenuSystemTool', 'CronTask'),
('MenuUser', 'Permission'),
('MenuUser', 'Role'),
('MenuUser', 'Rule'),
('MenuUser', 'User'),
('Modarator', 'MenuReport'),
('Modarator', 'MenuSetting'),
('Modarator', 'MenuSystemTool'),
('Order', 'CreateOrder'),
('Order', 'DeleteOrder'),
('Order', 'UpdateOrder'),
('Permission', 'CreatePermission'),
('Permission', 'DeletePermission'),
('Permission', 'UpdatePermission'),
('Permission', 'viesAsPermisson'),
('Product', 'CreateProduct'),
('Product', 'DeleteProduct'),
('Product', 'UpdateProduct'),
('ProductCategory', 'CreateProductCategory'),
('ProductCategory', 'DeleteProductCategory'),
('ProductCategory', 'UpdateProductCategory'),
('Role', 'CreateRole'),
('Role', 'DeleteRole'),
('Role', 'UpdateRole'),
('Rule', 'CreateRule'),
('Rule', 'DeleteRule'),
('Rule', 'UpdateRule'),
('Sale', 'MenuReport'),
('Setting', 'CreateSetting'),
('Setting', 'DeleteSetting'),
('Setting', 'UpdateSetting'),
('User', 'CreateUser'),
('User', 'DeleteUser'),
('User', 'UpdateUser');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 0x4f3a31393a226170705c726261635c417574686f7252756c65223a333a7b733a343a226e616d65223b733a383a226973417574686f72223b733a393a22637265617465644174223b4e3b733a393a22757064617465644174223b693a313534343439393435383b7d, 1544499373, 1544499458);

-- --------------------------------------------------------

--
-- Table structure for table `cronjob`
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
-- Dumping data for table `cronjob`
--

INSERT INTO `cronjob` (`id`, `cronjob_id`, `name`, `class`, `module_id`, `run_rules`, `last_run`, `next_run`, `is_active`, `logging_f`) VALUES
(4, 'SendMail', 'SendMail', 'app\\modules\\email\\commands\\SendMail', 'email', 0x7b226d696e75746573223a5b222d31225d2c22686f757273223a5b222d31225d2c226461795f74797065223a22646f77222c22646f77223a5b222d31225d7d, 1544783111, 1544783171, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cronjob_log`
--

CREATE TABLE `cronjob_log` (
  `cronjob_id` char(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `execution_time` int(10) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `cronjob_log`
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
('SendMail', 1542790302, 'Success.'),
('SendMail', 1543289369, 'Success.'),
('SendMail', 1543289531, 'Success.'),
('SendMail', 1543289896, 'Success.'),
('SendMail', 1543290426, 'Success.'),
('SendMail', 1543290426, 'Success.'),
('SendMail', 1543290495, 'Success.'),
('SendMail', 1543290526, 'Success.'),
('SendMail', 1543291467, 'Success.'),
('SendMail', 1543291758, 'Success.'),
('SendMail', 1543291821, 'Success.'),
('SendMail', 1543291967, 'Success.'),
('SendMail', 1543292110, 'Success.'),
('SendMail', 1543292410, 'Success.'),
('SendMail', 1543292710, 'Success.'),
('SendMail', 1543293011, 'Success.'),
('SendMail', 1543293311, 'Success.'),
('SendMail', 1543293611, 'Success.'),
('SendMail', 1543293911, 'Success.'),
('SendMail', 1543294211, 'Success.'),
('SendMail', 1543294511, 'Success.'),
('SendMail', 1543294811, 'Success.'),
('SendMail', 1543295111, 'Success.'),
('SendMail', 1543295411, 'Success.'),
('SendMail', 1543295711, 'Success.'),
('SendMail', 1543296011, 'Success.'),
('SendMail', 1543296311, 'Success.'),
('SendMail', 1543296611, 'Success.'),
('SendMail', 1543296911, 'Success.'),
('SendMail', 1543297211, 'Success.'),
('SendMail', 1543297511, 'Success.'),
('SendMail', 1543297811, 'Success.'),
('SendMail', 1543298111, 'Success.'),
('SendMail', 1543298411, 'Success.'),
('SendMail', 1543298711, 'Success.'),
('SendMail', 1543299011, 'Success.'),
('SendMail', 1543299311, 'Success.'),
('SendMail', 1543299611, 'Success.'),
('SendMail', 1543299911, 'Success.'),
('SendMail', 1543300211, 'Success.'),
('SendMail', 1543300511, 'Success.'),
('SendMail', 1543300811, 'Success.'),
('SendMail', 1543301111, 'Success.'),
('SendMail', 1543301411, 'Success.'),
('SendMail', 1543301711, 'Success.'),
('SendMail', 1543302011, 'Success.'),
('SendMail', 1543302311, 'Success.'),
('SendMail', 1543302611, 'Success.'),
('SendMail', 1543302911, 'Success.'),
('SendMail', 1543303211, 'Success.'),
('SendMail', 1543303511, 'Success.'),
('SendMail', 1543303811, 'Success.'),
('SendMail', 1543304111, 'Success.'),
('SendMail', 1543304411, 'Success.'),
('SendMail', 1543304711, 'Success.'),
('SendMail', 1543305011, 'Success.'),
('SendMail', 1543305311, 'Success.'),
('SendMail', 1543305611, 'Success.'),
('SendMail', 1543305911, 'Success.'),
('SendMail', 1543306211, 'Success.'),
('SendMail', 1543306511, 'Success.'),
('SendMail', 1543306811, 'Success.'),
('SendMail', 1543307111, 'Success.'),
('SendMail', 1543307411, 'Success.'),
('SendMail', 1543307711, 'Success.'),
('SendMail', 1543308011, 'Success.'),
('SendMail', 1543308311, 'Success.'),
('SendMail', 1543308611, 'Success.'),
('SendMail', 1543308911, 'Success.'),
('SendMail', 1543309211, 'Success.'),
('SendMail', 1543309511, 'Success.'),
('SendMail', 1543309811, 'Success.'),
('SendMail', 1543310111, 'Success.'),
('SendMail', 1543310411, 'Success.'),
('SendMail', 1543310711, 'Success.'),
('SendMail', 1543311011, 'Success.'),
('SendMail', 1543311311, 'Success.'),
('SendMail', 1543311611, 'Success.'),
('SendMail', 1543311911, 'Success.'),
('SendMail', 1543312211, 'Success.'),
('SendMail', 1543312511, 'Success.'),
('SendMail', 1543312811, 'Success.'),
('SendMail', 1543313111, 'Success.'),
('SendMail', 1543313411, 'Success.'),
('SendMail', 1543313711, 'Success.'),
('SendMail', 1543314011, 'Success.'),
('SendMail', 1543367711, 'Success.'),
('SendMail', 1543368013, 'Success.'),
('SendMail', 1543368311, 'Success.'),
('SendMail', 1543368611, 'Success.'),
('SendMail', 1543368911, 'Success.'),
('SendMail', 1543369211, 'Success.'),
('SendMail', 1543369511, 'Success.'),
('SendMail', 1543369811, 'Success.'),
('SendMail', 1543370111, 'Success.'),
('SendMail', 1543370411, 'Success.'),
('SendMail', 1543370711, 'Success.'),
('SendMail', 1543371011, 'Success.'),
('SendMail', 1543371311, 'Success.'),
('SendMail', 1543371611, 'Success.'),
('SendMail', 1543371911, 'Success.'),
('SendMail', 1543372211, 'Success.'),
('SendMail', 1543372511, 'Success.'),
('SendMail', 1543372811, 'Success.'),
('SendMail', 1543373111, 'Success.'),
('SendMail', 1543373411, 'Success.'),
('SendMail', 1543373711, 'Success.'),
('SendMail', 1543374011, 'Success.'),
('SendMail', 1543374311, 'Success.'),
('SendMail', 1543374611, 'Success.'),
('SendMail', 1543374911, 'Success.'),
('SendMail', 1543375211, 'Success.'),
('SendMail', 1543375511, 'Success.'),
('SendMail', 1543375811, 'Success.'),
('SendMail', 1543376111, 'Success.'),
('SendMail', 1543376411, 'Success.'),
('SendMail', 1543376711, 'Success.'),
('SendMail', 1543377011, 'Success.'),
('SendMail', 1543377311, 'Success.'),
('SendMail', 1543377611, 'Success.'),
('SendMail', 1543377911, 'Success.'),
('SendMail', 1543378211, 'Success.'),
('SendMail', 1543378511, 'Success.'),
('SendMail', 1543378810, 'Success.'),
('SendMail', 1543379111, 'Success.'),
('SendMail', 1543379411, 'Success.'),
('SendMail', 1543379711, 'Success.'),
('SendMail', 1543380011, 'Success.'),
('SendMail', 1543380311, 'Success.'),
('SendMail', 1543380611, 'Success.'),
('SendMail', 1543380911, 'Success.'),
('SendMail', 1543381211, 'Success.'),
('SendMail', 1543381511, 'Success.'),
('SendMail', 1543381811, 'Success.'),
('SendMail', 1543382111, 'Success.'),
('SendMail', 1543382411, 'Success.'),
('SendMail', 1543382711, 'Success.'),
('SendMail', 1543383011, 'Success.'),
('SendMail', 1543383311, 'Success.'),
('SendMail', 1543383611, 'Success.'),
('SendMail', 1543383911, 'Success.'),
('SendMail', 1543384211, 'Success.'),
('SendMail', 1543384511, 'Success.'),
('SendMail', 1543384811, 'Success.'),
('SendMail', 1543385111, 'Success.'),
('SendMail', 1543385411, 'Success.'),
('SendMail', 1543385711, 'Success.'),
('SendMail', 1543386011, 'Success.'),
('SendMail', 1543386311, 'Success.'),
('SendMail', 1543386611, 'Success.'),
('SendMail', 1543386911, 'Success.'),
('SendMail', 1543387211, 'Success.'),
('SendMail', 1543387511, 'Success.'),
('SendMail', 1543387811, 'Success.'),
('SendMail', 1543388111, 'Success.'),
('SendMail', 1543388411, 'Success.'),
('SendMail', 1543388711, 'Success.'),
('SendMail', 1543389011, 'Success.'),
('SendMail', 1543389311, 'Success.'),
('SendMail', 1543389611, 'Success.'),
('SendMail', 1543389911, 'Success.'),
('SendMail', 1543390211, 'Success.'),
('SendMail', 1543390511, 'Success.'),
('SendMail', 1543390811, 'Success.'),
('SendMail', 1543391111, 'Success.'),
('SendMail', 1543391411, 'Success.'),
('SendMail', 1543391711, 'Success.'),
('SendMail', 1543392011, 'Success.'),
('SendMail', 1543392311, 'Success.'),
('SendMail', 1543392611, 'Success.'),
('SendMail', 1543392911, 'Success.'),
('SendMail', 1544405412, 'Success.'),
('SendMail', 1544405710, 'Success.'),
('SendMail', 1544406010, 'Success.'),
('SendMail', 1544406310, 'Success.'),
('SendMail', 1544406610, 'Success.'),
('SendMail', 1544406910, 'Success.'),
('SendMail', 1544407210, 'Success.'),
('SendMail', 1544407510, 'Success.'),
('SendMail', 1544407810, 'Success.'),
('SendMail', 1544408110, 'Success.'),
('SendMail', 1544408410, 'Success.'),
('SendMail', 1544408710, 'Success.'),
('SendMail', 1544409010, 'Success.'),
('SendMail', 1544409310, 'Success.'),
('SendMail', 1544409610, 'Success.'),
('SendMail', 1544409910, 'Success.'),
('SendMail', 1544410210, 'Success.'),
('SendMail', 1544410510, 'Success.'),
('SendMail', 1544410810, 'Success.'),
('SendMail', 1544411110, 'Success.'),
('SendMail', 1544411410, 'Success.'),
('SendMail', 1544411710, 'Success.'),
('SendMail', 1544412010, 'Success.'),
('SendMail', 1544412310, 'Success.'),
('SendMail', 1544412610, 'Success.'),
('SendMail', 1544412910, 'Success.'),
('SendMail', 1544413210, 'Success.'),
('SendMail', 1544413510, 'Success.'),
('SendMail', 1544413810, 'Success.'),
('SendMail', 1544414110, 'Success.'),
('SendMail', 1544414410, 'Success.'),
('SendMail', 1544414710, 'Success.'),
('SendMail', 1544415010, 'Success.'),
('SendMail', 1544415310, 'Success.'),
('SendMail', 1544415610, 'Success.'),
('SendMail', 1544415910, 'Success.'),
('SendMail', 1544416210, 'Success.'),
('SendMail', 1544416510, 'Success.'),
('SendMail', 1544416810, 'Success.'),
('SendMail', 1544417110, 'Success.'),
('SendMail', 1544417410, 'Success.'),
('SendMail', 1544417710, 'Success.'),
('SendMail', 1544418010, 'Success.'),
('SendMail', 1544418310, 'Success.'),
('SendMail', 1544418610, 'Success.'),
('SendMail', 1544418910, 'Success.'),
('SendMail', 1544419210, 'Success.'),
('SendMail', 1544419510, 'Success.'),
('SendMail', 1544419810, 'Success.'),
('SendMail', 1544420110, 'Success.'),
('SendMail', 1544420410, 'Success.'),
('SendMail', 1544420710, 'Success.'),
('SendMail', 1544421010, 'Success.'),
('SendMail', 1544421310, 'Success.'),
('SendMail', 1544421610, 'Success.'),
('SendMail', 1544421910, 'Success.'),
('SendMail', 1544422210, 'Success.'),
('SendMail', 1544422510, 'Success.'),
('SendMail', 1544422810, 'Success.'),
('SendMail', 1544423110, 'Success.'),
('SendMail', 1544423410, 'Success.'),
('SendMail', 1544423710, 'Success.'),
('SendMail', 1544424010, 'Success.'),
('SendMail', 1544424310, 'Success.'),
('SendMail', 1544424610, 'Success.'),
('SendMail', 1544424910, 'Success.'),
('SendMail', 1544425210, 'Success.'),
('SendMail', 1544425510, 'Success.'),
('SendMail', 1544425810, 'Success.'),
('SendMail', 1544426110, 'Success.'),
('SendMail', 1544426410, 'Success.'),
('SendMail', 1544426710, 'Success.'),
('SendMail', 1544427010, 'Success.'),
('SendMail', 1544427310, 'Success.'),
('SendMail', 1544427610, 'Success.'),
('SendMail', 1544427910, 'Success.'),
('SendMail', 1544428210, 'Success.'),
('SendMail', 1544428510, 'Success.'),
('SendMail', 1544428810, 'Success.'),
('SendMail', 1544429110, 'Success.'),
('SendMail', 1544429410, 'Success.'),
('SendMail', 1544429710, 'Success.'),
('SendMail', 1544430010, 'Success.'),
('SendMail', 1544430310, 'Success.'),
('SendMail', 1544430610, 'Success.'),
('SendMail', 1544430910, 'Success.'),
('SendMail', 1544431210, 'Success.'),
('SendMail', 1544431510, 'Success.'),
('SendMail', 1544431810, 'Success.'),
('SendMail', 1544432110, 'Success.'),
('SendMail', 1544432410, 'Success.'),
('SendMail', 1544432710, 'Success.'),
('SendMail', 1544433010, 'Success.'),
('SendMail', 1544433310, 'Success.'),
('SendMail', 1544433610, 'Success.'),
('SendMail', 1544433910, 'Success.'),
('SendMail', 1544434210, 'Success.'),
('SendMail', 1544434510, 'Success.'),
('SendMail', 1544434810, 'Success.'),
('SendMail', 1544435110, 'Success.'),
('SendMail', 1544435410, 'Success.'),
('SendMail', 1544435710, 'Success.'),
('SendMail', 1544436010, 'Success.'),
('SendMail', 1544436310, 'Success.'),
('SendMail', 1544436610, 'Success.'),
('SendMail', 1544494210, 'Success.'),
('SendMail', 1544494510, 'Success.'),
('SendMail', 1544494810, 'Success.'),
('SendMail', 1544495110, 'Success.'),
('SendMail', 1544495410, 'Success.'),
('SendMail', 1544495710, 'Success.'),
('SendMail', 1544496010, 'Success.'),
('SendMail', 1544496310, 'Success.'),
('SendMail', 1544496610, 'Success.'),
('SendMail', 1544496910, 'Success.'),
('SendMail', 1544497210, 'Success.'),
('SendMail', 1544497510, 'Success.'),
('SendMail', 1544497810, 'Success.'),
('SendMail', 1544498110, 'Success.'),
('SendMail', 1544498410, 'Success.'),
('SendMail', 1544498710, 'Success.'),
('SendMail', 1544499010, 'Success.'),
('SendMail', 1544499310, 'Success.'),
('SendMail', 1544499610, 'Success.'),
('SendMail', 1544499910, 'Success.'),
('SendMail', 1544500210, 'Success.'),
('SendMail', 1544500510, 'Success.'),
('SendMail', 1544500810, 'Success.'),
('SendMail', 1544501110, 'Success.'),
('SendMail', 1544501410, 'Success.'),
('SendMail', 1544501710, 'Success.'),
('SendMail', 1544502010, 'Success.'),
('SendMail', 1544502310, 'Success.'),
('SendMail', 1544502610, 'Success.'),
('SendMail', 1544502910, 'Success.'),
('SendMail', 1544503210, 'Success.'),
('SendMail', 1544503510, 'Success.'),
('SendMail', 1544503810, 'Success.'),
('SendMail', 1544504110, 'Success.'),
('SendMail', 1544504410, 'Success.'),
('SendMail', 1544504710, 'Success.'),
('SendMail', 1544505010, 'Success.'),
('SendMail', 1544505310, 'Success.'),
('SendMail', 1544505610, 'Success.'),
('SendMail', 1544505910, 'Success.'),
('SendMail', 1544506210, 'Success.'),
('SendMail', 1544506510, 'Success.'),
('SendMail', 1544506810, 'Success.'),
('SendMail', 1544507110, 'Success.'),
('SendMail', 1544507410, 'Success.'),
('SendMail', 1544507710, 'Success.'),
('SendMail', 1544508010, 'Success.'),
('SendMail', 1544508310, 'Success.'),
('SendMail', 1544508610, 'Success.'),
('SendMail', 1544508910, 'Success.'),
('SendMail', 1544509211, 'Success.'),
('SendMail', 1544509511, 'Success.'),
('SendMail', 1544509811, 'Success.'),
('SendMail', 1544510111, 'Success.'),
('SendMail', 1544510411, 'Success.'),
('SendMail', 1544510711, 'Success.'),
('SendMail', 1544511011, 'Success.'),
('SendMail', 1544511311, 'Success.'),
('SendMail', 1544511611, 'Success.'),
('SendMail', 1544511911, 'Success.'),
('SendMail', 1544512211, 'Success.'),
('SendMail', 1544512511, 'Success.'),
('SendMail', 1544512811, 'Success.'),
('SendMail', 1544513111, 'Success.'),
('SendMail', 1544513411, 'Success.'),
('SendMail', 1544513711, 'Success.'),
('SendMail', 1544514011, 'Success.'),
('SendMail', 1544514311, 'Success.'),
('SendMail', 1544514611, 'Success.'),
('SendMail', 1544514911, 'Success.'),
('SendMail', 1544515211, 'Success.'),
('SendMail', 1544515511, 'Success.'),
('SendMail', 1544515811, 'Success.'),
('SendMail', 1544516111, 'Success.'),
('SendMail', 1544516411, 'Success.'),
('SendMail', 1544516711, 'Success.'),
('SendMail', 1544517011, 'Success.'),
('SendMail', 1544517311, 'Success.'),
('SendMail', 1544517611, 'Success.'),
('SendMail', 1544517911, 'Success.'),
('SendMail', 1544518211, 'Success.'),
('SendMail', 1544518511, 'Success.'),
('SendMail', 1544518811, 'Success.'),
('SendMail', 1544519111, 'Success.'),
('SendMail', 1544519411, 'Success.'),
('SendMail', 1544519711, 'Success.'),
('SendMail', 1544520011, 'Success.'),
('SendMail', 1544520311, 'Success.'),
('SendMail', 1544520611, 'Success.'),
('SendMail', 1544520911, 'Success.'),
('SendMail', 1544521211, 'Success.'),
('SendMail', 1544521511, 'Success.'),
('SendMail', 1544521811, 'Success.'),
('SendMail', 1544522111, 'Success.'),
('SendMail', 1544522411, 'Success.'),
('SendMail', 1544522711, 'Success.'),
('SendMail', 1544523011, 'Success.'),
('SendMail', 1544523311, 'Success.'),
('SendMail', 1544523611, 'Success.'),
('SendMail', 1544523911, 'Success.'),
('SendMail', 1544579116, 'Success.'),
('SendMail', 1544579411, 'Success.'),
('SendMail', 1544579712, 'Success.'),
('SendMail', 1544580011, 'Success.'),
('SendMail', 1544580311, 'Success.'),
('SendMail', 1544580611, 'Success.'),
('SendMail', 1544580911, 'Success.'),
('SendMail', 1544581211, 'Success.'),
('SendMail', 1544581511, 'Success.'),
('SendMail', 1544581811, 'Success.'),
('SendMail', 1544582111, 'Success.'),
('SendMail', 1544582411, 'Success.'),
('SendMail', 1544582711, 'Success.'),
('SendMail', 1544583011, 'Success.'),
('SendMail', 1544583311, 'Success.'),
('SendMail', 1544583611, 'Success.'),
('SendMail', 1544583911, 'Success.'),
('SendMail', 1544584211, 'Success.'),
('SendMail', 1544584511, 'Success.'),
('SendMail', 1544584811, 'Success.'),
('SendMail', 1544585111, 'Success.'),
('SendMail', 1544585411, 'Success.'),
('SendMail', 1544585711, 'Success.'),
('SendMail', 1544586011, 'Success.'),
('SendMail', 1544586311, 'Success.'),
('SendMail', 1544586611, 'Success.'),
('SendMail', 1544586911, 'Success.'),
('SendMail', 1544587211, 'Success.'),
('SendMail', 1544587511, 'Success.'),
('SendMail', 1544587811, 'Success.'),
('SendMail', 1544588111, 'Success.'),
('SendMail', 1544588410, 'Success.'),
('SendMail', 1544588711, 'Success.'),
('SendMail', 1544589011, 'Success.'),
('SendMail', 1544589311, 'Success.'),
('SendMail', 1544589611, 'Success.'),
('SendMail', 1544589911, 'Success.'),
('SendMail', 1544590211, 'Success.'),
('SendMail', 1544590511, 'Success.'),
('SendMail', 1544590811, 'Success.'),
('SendMail', 1544591111, 'Success.'),
('SendMail', 1544591411, 'Success.'),
('SendMail', 1544591711, 'Success.'),
('SendMail', 1544592011, 'Success.'),
('SendMail', 1544592311, 'Success.'),
('SendMail', 1544592611, 'Success.'),
('SendMail', 1544592911, 'Success.'),
('SendMail', 1544593211, 'Success.'),
('SendMail', 1544593510, 'Success.'),
('SendMail', 1544593811, 'Success.'),
('SendMail', 1544594111, 'Success.'),
('SendMail', 1544594411, 'Success.'),
('SendMail', 1544594711, 'Success.'),
('SendMail', 1544595011, 'Success.'),
('SendMail', 1544595311, 'Success.'),
('SendMail', 1544595611, 'Success.'),
('SendMail', 1544595911, 'Success.'),
('SendMail', 1544596211, 'Success.'),
('SendMail', 1544596511, 'Success.'),
('SendMail', 1544596811, 'Success.'),
('SendMail', 1544597111, 'Success.'),
('SendMail', 1544597411, 'Success.'),
('SendMail', 1544597711, 'Success.'),
('SendMail', 1544598011, 'Success.'),
('SendMail', 1544598311, 'Success.'),
('SendMail', 1544598611, 'Success.'),
('SendMail', 1544598911, 'Success.'),
('SendMail', 1544599211, 'Success.'),
('SendMail', 1544599511, 'Success.'),
('SendMail', 1544599811, 'Success.'),
('SendMail', 1544600111, 'Success.'),
('SendMail', 1544600411, 'Success.'),
('SendMail', 1544600711, 'Success.'),
('SendMail', 1544601011, 'Success.'),
('SendMail', 1544601311, 'Success.'),
('SendMail', 1544601611, 'Success.'),
('SendMail', 1544601911, 'Success.'),
('SendMail', 1544602211, 'Success.'),
('SendMail', 1544602511, 'Success.'),
('SendMail', 1544602811, 'Success.'),
('SendMail', 1544603111, 'Success.'),
('SendMail', 1544603411, 'Success.'),
('SendMail', 1544603711, 'Success.'),
('SendMail', 1544604011, 'Success.'),
('SendMail', 1544604311, 'Success.'),
('SendMail', 1544604611, 'Success.'),
('SendMail', 1544604911, 'Success.'),
('SendMail', 1544605211, 'Success.'),
('SendMail', 1544605511, 'Success.'),
('SendMail', 1544605811, 'Success.'),
('SendMail', 1544606111, 'Success.'),
('SendMail', 1544606411, 'Success.'),
('SendMail', 1544606711, 'Success.'),
('SendMail', 1544607011, 'Success.'),
('SendMail', 1544607311, 'Success.'),
('SendMail', 1544607611, 'Success.'),
('SendMail', 1544607911, 'Success.'),
('SendMail', 1544608211, 'Success.'),
('SendMail', 1544608511, 'Success.'),
('SendMail', 1544608811, 'Success.'),
('SendMail', 1544609111, 'Success.'),
('SendMail', 1544609411, 'Success.'),
('SendMail', 1544609711, 'Success.'),
('SendMail', 1544610011, 'Success.'),
('SendMail', 1544664315, 'Success.'),
('SendMail', 1544664611, 'Success.'),
('SendMail', 1544664911, 'Success.'),
('SendMail', 1544665211, 'Success.'),
('SendMail', 1544665511, 'Success.'),
('SendMail', 1544665811, 'Success.'),
('SendMail', 1544666111, 'Success.'),
('SendMail', 1544666411, 'Success.'),
('SendMail', 1544666711, 'Success.'),
('SendMail', 1544667011, 'Success.'),
('SendMail', 1544667311, 'Success.'),
('SendMail', 1544667611, 'Success.'),
('SendMail', 1544667912, 'Success.'),
('SendMail', 1544668211, 'Success.'),
('SendMail', 1544668511, 'Success.'),
('SendMail', 1544668811, 'Success.'),
('SendMail', 1544669111, 'Success.'),
('SendMail', 1544669411, 'Success.'),
('SendMail', 1544669711, 'Success.'),
('SendMail', 1544670011, 'Success.'),
('SendMail', 1544670311, 'Success.'),
('SendMail', 1544670611, 'Success.'),
('SendMail', 1544670911, 'Success.'),
('SendMail', 1544671211, 'Success.'),
('SendMail', 1544671511, 'Success.'),
('SendMail', 1544671811, 'Success.'),
('SendMail', 1544672111, 'Success.'),
('SendMail', 1544672411, 'Success.'),
('SendMail', 1544672711, 'Success.'),
('SendMail', 1544673011, 'Success.'),
('SendMail', 1544673311, 'Success.'),
('SendMail', 1544673611, 'Success.'),
('SendMail', 1544673911, 'Success.'),
('SendMail', 1544674211, 'Success.'),
('SendMail', 1544674511, 'Success.'),
('SendMail', 1544674810, 'Success.'),
('SendMail', 1544675111, 'Success.'),
('SendMail', 1544675411, 'Success.'),
('SendMail', 1544675711, 'Success.'),
('SendMail', 1544676011, 'Success.'),
('SendMail', 1544676311, 'Success.'),
('SendMail', 1544676611, 'Success.'),
('SendMail', 1544676911, 'Success.'),
('SendMail', 1544677211, 'Success.'),
('SendMail', 1544677511, 'Success.'),
('SendMail', 1544677811, 'Success.'),
('SendMail', 1544678111, 'Success.'),
('SendMail', 1544678411, 'Success.'),
('SendMail', 1544678711, 'Success.'),
('SendMail', 1544679011, 'Success.'),
('SendMail', 1544679311, 'Success.'),
('SendMail', 1544679611, 'Success.'),
('SendMail', 1544679911, 'Success.'),
('SendMail', 1544680211, 'Success.'),
('SendMail', 1544680511, 'Success.'),
('SendMail', 1544680811, 'Success.'),
('SendMail', 1544681111, 'Success.'),
('SendMail', 1544681411, 'Success.'),
('SendMail', 1544681711, 'Success.'),
('SendMail', 1544682011, 'Success.'),
('SendMail', 1544682311, 'Success.'),
('SendMail', 1544682611, 'Success.'),
('SendMail', 1544682911, 'Success.'),
('SendMail', 1544683211, 'Success.'),
('SendMail', 1544683511, 'Success.'),
('SendMail', 1544683811, 'Success.'),
('SendMail', 1544684111, 'Success.'),
('SendMail', 1544684411, 'Success.'),
('SendMail', 1544684711, 'Success.'),
('SendMail', 1544685011, 'Success.'),
('SendMail', 1544685311, 'Success.'),
('SendMail', 1544685611, 'Success.'),
('SendMail', 1544685911, 'Success.'),
('SendMail', 1544686211, 'Success.'),
('SendMail', 1544686511, 'Success.'),
('SendMail', 1544686811, 'Success.'),
('SendMail', 1544687111, 'Success.'),
('SendMail', 1544687411, 'Success.'),
('SendMail', 1544687711, 'Success.'),
('SendMail', 1544688011, 'Success.'),
('SendMail', 1544688311, 'Success.'),
('SendMail', 1544688611, 'Success.'),
('SendMail', 1544688911, 'Success.'),
('SendMail', 1544689211, 'Success.'),
('SendMail', 1544689511, 'Success.'),
('SendMail', 1544689811, 'Success.'),
('SendMail', 1544690111, 'Success.'),
('SendMail', 1544690411, 'Success.'),
('SendMail', 1544690711, 'Success.'),
('SendMail', 1544691011, 'Success.'),
('SendMail', 1544691311, 'Success.'),
('SendMail', 1544691611, 'Success.'),
('SendMail', 1544691911, 'Success.'),
('SendMail', 1544692211, 'Success.'),
('SendMail', 1544692511, 'Success.'),
('SendMail', 1544692811, 'Success.'),
('SendMail', 1544693111, 'Success.'),
('SendMail', 1544693411, 'Success.'),
('SendMail', 1544693711, 'Success.'),
('SendMail', 1544694011, 'Success.'),
('SendMail', 1544694311, 'Success.'),
('SendMail', 1544694611, 'Success.'),
('SendMail', 1544694911, 'Success.'),
('SendMail', 1544695211, 'Success.'),
('SendMail', 1544695511, 'Success.'),
('SendMail', 1544695811, 'Success.'),
('SendMail', 1544696111, 'Success.'),
('SendMail', 1544696411, 'Success.'),
('SendMail', 1544696711, 'Success.'),
('SendMail', 1544697011, 'Success.'),
('SendMail', 1544750712, 'Success.'),
('SendMail', 1544751011, 'Success.'),
('SendMail', 1544751311, 'Success.'),
('SendMail', 1544751611, 'Success.'),
('SendMail', 1544751911, 'Success.'),
('SendMail', 1544752211, 'Success.'),
('SendMail', 1544752511, 'Success.'),
('SendMail', 1544752811, 'Success.'),
('SendMail', 1544753111, 'Success.'),
('SendMail', 1544753411, 'Success.'),
('SendMail', 1544753711, 'Success.'),
('SendMail', 1544754011, 'Success.'),
('SendMail', 1544754311, 'Success.'),
('SendMail', 1544754611, 'Success.'),
('SendMail', 1544754911, 'Success.'),
('SendMail', 1544755211, 'Success.'),
('SendMail', 1544755510, 'Success.'),
('SendMail', 1544755811, 'Success.'),
('SendMail', 1544756111, 'Success.'),
('SendMail', 1544756411, 'Success.'),
('SendMail', 1544756711, 'Success.'),
('SendMail', 1544757011, 'Success.'),
('SendMail', 1544757311, 'Success.'),
('SendMail', 1544757611, 'Success.'),
('SendMail', 1544757911, 'Success.'),
('SendMail', 1544758211, 'Success.'),
('SendMail', 1544758511, 'Success.'),
('SendMail', 1544758811, 'Success.'),
('SendMail', 1544759111, 'Success.'),
('SendMail', 1544759411, 'Success.'),
('SendMail', 1544759711, 'Success.'),
('SendMail', 1544760011, 'Success.'),
('SendMail', 1544760311, 'Success.'),
('SendMail', 1544760611, 'Success.'),
('SendMail', 1544760911, 'Success.'),
('SendMail', 1544761210, 'Success.'),
('SendMail', 1544761511, 'Success.'),
('SendMail', 1544761811, 'Success.'),
('SendMail', 1544762111, 'Success.'),
('SendMail', 1544762411, 'Success.'),
('SendMail', 1544762711, 'Success.'),
('SendMail', 1544763011, 'Success.'),
('SendMail', 1544763311, 'Success.'),
('SendMail', 1544763611, 'Success.'),
('SendMail', 1544763911, 'Success.'),
('SendMail', 1544764211, 'Success.'),
('SendMail', 1544764511, 'Success.'),
('SendMail', 1544764811, 'Success.'),
('SendMail', 1544765111, 'Success.'),
('SendMail', 1544765411, 'Success.'),
('SendMail', 1544765711, 'Success.'),
('SendMail', 1544766011, 'Success.'),
('SendMail', 1544766311, 'Success.'),
('SendMail', 1544766611, 'Success.'),
('SendMail', 1544766911, 'Success.'),
('SendMail', 1544767211, 'Success.'),
('SendMail', 1544767511, 'Success.'),
('SendMail', 1544767811, 'Success.'),
('SendMail', 1544768111, 'Success.'),
('SendMail', 1544768411, 'Success.'),
('SendMail', 1544768711, 'Success.'),
('SendMail', 1544769011, 'Success.'),
('SendMail', 1544769311, 'Success.'),
('SendMail', 1544769611, 'Success.'),
('SendMail', 1544769911, 'Success.'),
('SendMail', 1544770211, 'Success.'),
('SendMail', 1544770511, 'Success.'),
('SendMail', 1544770811, 'Success.'),
('SendMail', 1544771111, 'Success.'),
('SendMail', 1544771411, 'Success.'),
('SendMail', 1544771711, 'Success.'),
('SendMail', 1544772011, 'Success.'),
('SendMail', 1544772311, 'Success.'),
('SendMail', 1544772611, 'Success.'),
('SendMail', 1544772911, 'Success.'),
('SendMail', 1544773211, 'Success.'),
('SendMail', 1544773511, 'Success.'),
('SendMail', 1544773811, 'Success.'),
('SendMail', 1544774111, 'Success.'),
('SendMail', 1544774411, 'Success.'),
('SendMail', 1544774711, 'Success.'),
('SendMail', 1544775011, 'Success.'),
('SendMail', 1544775311, 'Success.'),
('SendMail', 1544775611, 'Success.'),
('SendMail', 1544775911, 'Success.'),
('SendMail', 1544776211, 'Success.'),
('SendMail', 1544776511, 'Success.'),
('SendMail', 1544776811, 'Success.'),
('SendMail', 1544777111, 'Success.'),
('SendMail', 1544777411, 'Success.'),
('SendMail', 1544777711, 'Success.'),
('SendMail', 1544778011, 'Success.'),
('SendMail', 1544778311, 'Success.'),
('SendMail', 1544778611, 'Success.'),
('SendMail', 1544778911, 'Success.'),
('SendMail', 1544779211, 'Success.'),
('SendMail', 1544779511, 'Success.'),
('SendMail', 1544779811, 'Success.'),
('SendMail', 1544780111, 'Success.'),
('SendMail', 1544780411, 'Success.'),
('SendMail', 1544780711, 'Success.'),
('SendMail', 1544781011, 'Success.'),
('SendMail', 1544781311, 'Success.'),
('SendMail', 1544781611, 'Success.'),
('SendMail', 1544781911, 'Success.'),
('SendMail', 1544782211, 'Success.'),
('SendMail', 1544782511, 'Success.'),
('SendMail', 1544782811, 'Success.'),
('SendMail', 1544783111, 'Success.');

-- --------------------------------------------------------

--
-- Table structure for table `data_registry`
--

CREATE TABLE `data_registry` (
  `data_key` varbinary(25) NOT NULL,
  `data_value` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_queue`
--

CREATE TABLE `email_queue` (
  `id` int(11) NOT NULL,
  `from` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'mailer component',
  `to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL COMMENT 'email người nhận',
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL COMMENT 'chủ đề mail',
  `layout` varchar(100) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `module_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'module id để định vị đường dẫn email template',
  `content_id` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'content id để định vị đường dẫn email template',
  `extra_data` blob COMMENT 'dữ liệu đổ vào email template',
  `created_date` int(11) DEFAULT NULL COMMENT 'ngày tạo',
  `status` tinyint(4) DEFAULT '0' COMMENT 'trạng thái của mail'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_vietnamese_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1542957067),
('m140506_102106_rbac_init', 1542957072),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1542957072),
('m181123_072137_init_rbac', 1542957837);

-- --------------------------------------------------------

--
-- Table structure for table `migration_module`
--

CREATE TABLE `migration_module` (
  `version` varchar(180) COLLATE utf8_vietnamese_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  `module` varbinary(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `migration_module`
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
-- Table structure for table `order`
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
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user_order_name`, `user_order_phone`, `user_order_email`, `user_receive_name`, `user_receive_phone`, `user_receive_email`, `user_receive_address`, `order_time`, `user_note`, `total`, `status`, `admin_note`, `deleted_f`) VALUES
(30, 'dat', '01666040696', 'nhungnguyen@gmail.com', '', '', '', 'thai binh', 1542084305, '', 400000, 0, NULL, 0),
(31, 'dat', '01666040696', 'nhungnguyen@gmail.com', '', '', '', 'thai binh', 1542178091, 'note', 600000, 0, NULL, 0),
(32, 'nhung', '0973571696', 'nhungnguyen@gmail.com', '', '', '', 'thai binh', 1542179057, 'note', 600000, 0, NULL, 0),
(33, 'dat', '01666040696', 'ngocdatbk@gmail.com', '', '', '', 'thai binh', 1542179523, '', 600000, 0, NULL, 0),
(34, 'nhung', '0973571696', 'ngocdatbk@gmail.com', '', '', '', 'thai binh', 1543289440, '', 200000, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT 'mã order',
  `product_id` int(11) NOT NULL COMMENT 'mã sản phẩm',
  `quantity` int(11) NOT NULL COMMENT 'số lượng sản phẩm',
  `deleted_f` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'xóa?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`, `deleted_f`) VALUES
(36, 30, 5, 1, 0),
(37, 31, 5, 1, 0),
(38, 31, 9, 1, 0),
(39, 32, 5, 1, 0),
(40, 32, 9, 1, 0),
(41, 33, 5, 1, 0),
(42, 33, 9, 1, 0),
(43, 34, 9, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
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
-- Dumping data for table `product`
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
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'Tên danh mục',
  `description` longtext COLLATE utf8_vietnamese_ci COMMENT 'Mô tả về danh mục sản phẩm',
  `deleted_f` tinyint(4) DEFAULT '0' COMMENT 'trạng thái của danh mục. nhận giá trị 0/1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `description`, `deleted_f`) VALUES
(1, 'Sáo mèo', '', 0),
(2, 'Sáo bầu', '', 0),
(4, 'Tiêu', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT 'id sản phẩm',
  `image` char(100) COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'đường dẫn ảnh',
  `description` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT 'mô tả đi kèm',
  `is_main` tinyint(4) DEFAULT '0' COMMENT 'có phải là ảnh chính'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `product_image`
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
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `key` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `modified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting`
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
-- Table structure for table `user`
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
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `gender`, `email`, `phone_number`, `fullname`, `is_active`, `is_admin`, `last_login`) VALUES
(1, 'datkhucngoc@admicro.vn', 'Male', 'datkhucngoc@admicro.vn', '', 'Khúc Ngọc Đạt', 1, 0, 1544818649),
(5, 'ngocdatbk@gmail.com', 'Male', 'ngocdatbk@gmail.com', '', 'khuc dat', 1, 0, 1544893381),
(6, 'khucngocdat1989', '', 'khucngocdat1989@gmail.com', '03666040696', 'khuc dat', 1, 0, 1543388229),
(8, 'khucphutue', 'Male', 'khucphutue@gmail.com', '03666040696', 'Phú Tuệ', 1, 0, 1544817937);

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE `user_auth` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`user_id`, `auth_key`, `password_hash`) VALUES
(1, 'nr2-PnAs9CpYIbJo3m-1HcsHzM9R-Bte', '$2y$13$U3gen9rZFvrOoh39lDNfO.4GYeU4KGTxEv27JuDg2i7PULZWraXKK'),
(5, 'alsdm8kJ1FXg62Fi-hAeNnuL_3wXwOQo', '$2y$13$nLGbFp.ykqJCJcEId0NDqulkZkNEcIiK.ymFAIJIpXA9SVte5IjoO'),
(6, '9i5e9bYVmnP6H6mPfNDXw8ko7CfWFNWx', '$2y$13$oSHSaNDYmmGb73lMNj.Ql.0qlkTIGEGfXfCWoph1x1KySsbsIIIbq'),
(8, 'ECVM8FVob1yx3e3JEi7lrbe3jNKayjJG', '$2y$13$i1DrBuSq/.tcatqZIRUs8eU/yfE5GP9T4RZ4ULe5QDkIvpPIyNvxK');

-- --------------------------------------------------------

--
-- Table structure for table `user_confirm`
--

CREATE TABLE `user_confirm` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `confirm_key` varbinary(32) NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_attempts`
--

CREATE TABLE `user_login_attempts` (
  `login` varchar(80) NOT NULL,
  `login_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_navigation`
--
ALTER TABLE `admin_navigation`
  ADD PRIMARY KEY (`navigation_id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `cronjob`
--
ALTER TABLE `cronjob`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_registry`
--
ALTER TABLE `data_registry`
  ADD PRIMARY KEY (`data_key`);

--
-- Indexes for table `email_queue`
--
ALTER TABLE `email_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `migration_module`
--
ALTER TABLE `migration_module`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_confirm`
--
ALTER TABLE `user_confirm`
  ADD PRIMARY KEY (`confirm_key`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cronjob`
--
ALTER TABLE `cronjob`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_queue`
--
ALTER TABLE `email_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'mã order', AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
