-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2020 a las 01:13:27
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `todolegal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actions_logs`
--

CREATE TABLE `actions_logs` (
  `actions_logs_id` int(11) NOT NULL,
  `email_login` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `actions` varchar(255) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actions_logs`
--

INSERT INTO `actions_logs` (`actions_logs_id`, `email_login`, `user_agent`, `ip_address`, `note`, `url`, `actions`, `timestamp_create`) VALUES
(1, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'save on [admin/plugin/article/addCatSave]', 'http://localhost/todolegal/admin/plugin/article/addCatSave', 'save', '2020-05-31 18:23:07'),
(2, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'save on [admin/plugin/article/addsave]', 'http://localhost/todolegal/admin/plugin/article/addsave', 'save', '2020-05-31 18:24:49'),
(3, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'save on [admin/widget/insert]', 'http://localhost/todolegal/admin/widget/insert', 'save', '2020-05-31 18:30:27'),
(4, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'delete on [admin/widget/delete/1]', 'http://localhost/todolegal/admin/widget/delete/1', 'delete', '2020-05-31 18:34:55'),
(5, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'save on [admin/widget/insert]', 'http://localhost/todolegal/admin/widget/insert', 'save', '2020-05-31 18:36:52'),
(6, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'save on [admin/pwidget/insert]', 'http://localhost/todolegal/admin/pwidget/insert', 'save', '2020-05-31 18:38:37'),
(7, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'save on [admin/pwidget/edited/1]', 'http://localhost/todolegal/admin/pwidget/edited/1', 'save', '2020-05-31 18:40:46'),
(8, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'save on [admin/navigation/insert]', 'http://localhost/todolegal/admin/navigation/insert', 'save', '2020-05-31 18:42:17'),
(9, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'save on [admin/navigation/save]', 'http://localhost/todolegal/admin/navigation/save', 'save', '2020-05-31 18:42:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `article_db`
--

CREATE TABLE `article_db` (
  `article_db_id` int(11) NOT NULL,
  `url_rewrite` varchar(255) DEFAULT NULL,
  `is_category` int(11) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `main_cat_id` int(11) DEFAULT NULL,
  `main_picture` varchar(255) DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `short_desc` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `user_admin_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `lang_iso` varchar(10) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `fb_comment_active` int(11) DEFAULT NULL,
  `fb_comment_limit` int(11) DEFAULT NULL,
  `fb_comment_sort` varchar(20) DEFAULT NULL,
  `arrange` int(11) DEFAULT NULL,
  `user_groups_idS` text DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `article_db`
--

INSERT INTO `article_db` (`article_db_id`, `url_rewrite`, `is_category`, `category_name`, `main_cat_id`, `main_picture`, `file_upload`, `title`, `keyword`, `short_desc`, `content`, `user_admin_id`, `cat_id`, `lang_iso`, `active`, `fb_comment_active`, `fb_comment_limit`, `fb_comment_sort`, `arrange`, `user_groups_idS`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'contratos', 1, 'Contratos', 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'en', 1, NULL, NULL, NULL, 1, NULL, '2020-05-31 18:23:07', '2020-05-31 18:23:07'),
(2, 'csz-cms-news-about-version-118', 0, NULL, NULL, '2020/1590963889_1-org.jpg', '', 'CSZ CMS NEWS: ABOUT VERSION 1.1.8', 'csz cms,open source cms,open source cms codeigniter bootstrap,open source cms codeigniter,open source cms bootstrap,free cms thai,open source content management,best cms software,free cms codeigniter,cms thai free', 'CSZ CMS upgrade news about version 1.1.8, Have many bug to fixed and add new feature. We improve the performance.', '<div class=\"row\">\r\n<div class=\"col-md-12\">\r\n<div class=\"row\">\r\n<div class=\"col-md-12\">\r\n<p>CSZ CMS upgrade news about version 1.1.8, Have many bug to fixed and add new feature. We improve the performance.</p>\r\n</div>\r\n</div>\r\n<p></p>\r\n</div>\r\n</div>\r\n<p><br><br></p>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: -379px; top: 36px;\">\r\n<div class=\"gtx-trans-icon\"></div>\r\n</div>', 1, 1, 'en', 1, 1, 5, 'reverse_time', NULL, '', '2020-05-31 18:24:49', '2020-05-31 18:24:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `article_db_downloadstat`
--

CREATE TABLE `article_db_downloadstat` (
  `article_db_downloadstat_id` int(11) NOT NULL,
  `article_db_id` int(11) DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL,
  `user_admin_id` int(11) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banner_mgt`
--

CREATE TABLE `banner_mgt` (
  `banner_mgt_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `width` int(5) DEFAULT NULL,
  `height` int(5) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `nofollow` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banner_statistic`
--

CREATE TABLE `banner_statistic` (
  `banner_statistic_id` int(11) NOT NULL,
  `banner_mgt_id` int(11) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blacklist_ip`
--

CREATE TABLE `blacklist_ip` (
  `blacklist_ip_id` int(11) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carousel_picture`
--

CREATE TABLE `carousel_picture` (
  `carousel_picture_id` int(11) NOT NULL,
  `carousel_widget_id` int(11) DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL,
  `photo_url` varchar(512) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `arrange` int(11) DEFAULT NULL,
  `carousel_type` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carousel_picture`
--

INSERT INTO `carousel_picture` (`carousel_picture_id`, `carousel_widget_id`, `file_upload`, `photo_url`, `caption`, `arrange`, `carousel_type`, `youtube_url`, `timestamp_create`, `timestamp_update`) VALUES
(1, 1, NULL, 'https://placehold.it/1900x540&text=Slide%20One', 'Caption One', 1, 'multiimages', NULL, '2020-05-31 18:13:47', '2020-05-31 18:13:47'),
(2, 1, NULL, 'https://placehold.it/1900x540&text=Slide%20Two', 'Caption Two', 2, 'multiimages', NULL, '2020-05-31 18:13:47', '2020-05-31 18:13:47'),
(3, 1, NULL, 'https://placehold.it/1900x540&text=Slide%20Three', 'Caption Three', 3, 'multiimages', NULL, '2020-05-31 18:13:47', '2020-05-31 18:13:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carousel_widget`
--

CREATE TABLE `carousel_widget` (
  `carousel_widget_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `custom_temp_active` int(11) DEFAULT NULL,
  `custom_template` text DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carousel_widget`
--

INSERT INTO `carousel_widget` (`carousel_widget_id`, `name`, `active`, `custom_temp_active`, `custom_template`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 1, 0, '', '2020-05-31 18:13:47', '2020-05-31 18:13:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `timestamp` int(10) UNSIGNED DEFAULT 0,
  `data` blob DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('325bf1mtl6mg5pr7tkiqi7a10tl4aoqr', '::1', 1590963736, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539303936333733363b63737a626c6f67696e5f63757275726c7c733a36313a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f696e6465782e7068702f61646d696e3f6e6f63616368653d31353930393633323237223b61646d696e5f6c6f676765645f696e7c623a313b757365725f61646d696e5f69647c733a313a2231223b61646d696e5f6e616d657c733a31303a2241646d696e2055736572223b61646d696e5f656d61696c7c733a32353a226272756e6f2e706f65686c6d616e6e40676d61696c2e636f6d223b61646d696e5f747970657c733a353a2261646d696e223b7077645f6368616e67657c733a313a2231223b73657373696f6e5f69647c733a33323a223332356266316d746c366d6735707237746b69716937613130746c34616f7172223b757365725f6167656e747c733a3131353a224d6f7a696c6c612f352e30202857696e646f7773204e542031302e303b2057696e36343b2078363429204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f38312e302e343034342e313338205361666172692f3533372e3336223b72656665727265645f696e6465787c733a35313a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e3f6e6f63616368653d31353930393633323237223b66726f6e6c616e675f69736f7c733a323a22656e223b63737a66726d5f63757275726c7c733a31303a22636f6e746163742d7573223b),
('pfqf6vki2v205p826c6l89896h3safmv', '::1', 1590963239, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539303936333233393b),
('7lm48v56508lheke3n0n248vrfs3ipie', '::1', 1590964054, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539303936343035343b63737a626c6f67696e5f63757275726c7c733a36313a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f696e6465782e7068702f61646d696e3f6e6f63616368653d31353930393633323237223b61646d696e5f6c6f676765645f696e7c623a313b757365725f61646d696e5f69647c733a313a2231223b61646d696e5f6e616d657c733a31303a2241646d696e2055736572223b61646d696e5f656d61696c7c733a32353a226272756e6f2e706f65686c6d616e6e40676d61696c2e636f6d223b61646d696e5f747970657c733a353a2261646d696e223b7077645f6368616e67657c733a313a2231223b73657373696f6e5f69647c733a33323a223332356266316d746c366d6735707237746b69716937613130746c34616f7172223b757365725f6167656e747c733a3131353a224d6f7a696c6c612f352e30202857696e646f7773204e542031302e303b2057696e36343b2078363429204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f38312e302e343034342e313338205361666172692f3533372e3336223b72656665727265645f696e6465787c733a35313a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e3f6e6f63616368653d31353930393633323237223b66726f6e6c616e675f69736f7c733a323a22656e223b63737a66726d5f63757275726c7c733a31303a22636f6e746163742d7573223b72656665727265645f61727469636c657c733a34373a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c65223b72656665727265645f61727469636c655f6361747c733a35363a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c652f63617465676f7279223b72656665727265645f61727469636c655f6172747c733a35353a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c652f61727469636c65223b),
('ee169sa5v1ukdcaa3mjrv30t0f49jcpu', '::1', 1590964420, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539303936343432303b63737a626c6f67696e5f63757275726c7c733a36313a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f696e6465782e7068702f61646d696e3f6e6f63616368653d31353930393633323237223b61646d696e5f6c6f676765645f696e7c623a313b757365725f61646d696e5f69647c733a313a2231223b61646d696e5f6e616d657c733a31303a2241646d696e2055736572223b61646d696e5f656d61696c7c733a32353a226272756e6f2e706f65686c6d616e6e40676d61696c2e636f6d223b61646d696e5f747970657c733a353a2261646d696e223b7077645f6368616e67657c733a313a2231223b73657373696f6e5f69647c733a33323a223332356266316d746c366d6735707237746b69716937613130746c34616f7172223b757365725f6167656e747c733a3131353a224d6f7a696c6c612f352e30202857696e646f7773204e542031302e303b2057696e36343b2078363429204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f38312e302e343034342e313338205361666172692f3533372e3336223b72656665727265645f696e6465787c733a33393a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f776964676574223b66726f6e6c616e675f69736f7c733a323a22656e223b63737a66726d5f63757275726c7c733a31303a22636f6e746163742d7573223b72656665727265645f61727469636c657c733a34373a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c65223b72656665727265645f61727469636c655f6361747c733a35363a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c652f63617465676f7279223b72656665727265645f61727469636c655f6172747c733a35353a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c652f61727469636c65223b),
('p7kjqm4q4id9rm8pk7r200c8of70tt2v', '::1', 1590964729, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539303936343732393b63737a626c6f67696e5f63757275726c7c733a36313a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f696e6465782e7068702f61646d696e3f6e6f63616368653d31353930393633323237223b61646d696e5f6c6f676765645f696e7c623a313b757365725f61646d696e5f69647c733a313a2231223b61646d696e5f6e616d657c733a31303a2241646d696e2055736572223b61646d696e5f656d61696c7c733a32353a226272756e6f2e706f65686c6d616e6e40676d61696c2e636f6d223b61646d696e5f747970657c733a353a2261646d696e223b7077645f6368616e67657c733a313a2231223b73657373696f6e5f69647c733a33323a223332356266316d746c366d6735707237746b69716937613130746c34616f7172223b757365725f6167656e747c733a3131353a224d6f7a696c6c612f352e30202857696e646f7773204e542031302e303b2057696e36343b2078363429204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f38312e302e343034342e313338205361666172692f3533372e3336223b72656665727265645f696e6465787c733a34303a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f70776964676574223b66726f6e6c616e675f69736f7c733a323a22656e223b63737a66726d5f63757275726c7c733a31303a22636f6e746163742d7573223b72656665727265645f61727469636c657c733a34373a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c65223b72656665727265645f61727469636c655f6361747c733a35363a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c652f63617465676f7279223b72656665727265645f61727469636c655f6172747c733a35353a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c652f61727469636c65223b6572726f725f6d6573736167657c733a36353a223c64697620636c6173733d22616c65727420616c6572742d737563636573732220726f6c653d22616c657274223e5375636365737366756c6c79213c2f6469763e223b5f5f63695f766172737c613a313a7b733a31333a226572726f725f6d657373616765223b733a333a226f6c64223b7d),
('evn3b6alc9ll4pcdni722j5q7d1bcem2', '::1', 1590965013, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539303936343732393b63737a626c6f67696e5f63757275726c7c733a36313a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f696e6465782e7068702f61646d696e3f6e6f63616368653d31353930393633323237223b61646d696e5f6c6f676765645f696e7c623a313b757365725f61646d696e5f69647c733a313a2231223b61646d696e5f6e616d657c733a31303a2241646d696e2055736572223b61646d696e5f656d61696c7c733a32353a226272756e6f2e706f65686c6d616e6e40676d61696c2e636f6d223b61646d696e5f747970657c733a353a2261646d696e223b7077645f6368616e67657c733a313a2231223b73657373696f6e5f69647c733a33323a223332356266316d746c366d6735707237746b69716937613130746c34616f7172223b757365725f6167656e747c733a3131353a224d6f7a696c6c612f352e30202857696e646f7773204e542031302e303b2057696e36343b2078363429204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f38312e302e343034342e313338205361666172692f3533372e3336223b72656665727265645f696e6465787c733a34333a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f6e617669676174696f6e223b66726f6e6c616e675f69736f7c733a323a22656e223b63737a66726d5f63757275726c7c733a31303a22636f6e746163742d7573223b72656665727265645f61727469636c657c733a34373a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c65223b72656665727265645f61727469636c655f6361747c733a35363a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c652f63617465676f7279223b72656665727265645f61727469636c655f6172747c733a35353a22687474703a2f2f6c6f63616c686f73742f746f646f6c6567616c2f61646d696e2f706c7567696e2f61727469636c652f61727469636c65223b);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_logs`
--

CREATE TABLE `email_logs` (
  `email_logs_id` int(11) NOT NULL,
  `to_email` varchar(255) DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `email_result` text DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `footer_social`
--

CREATE TABLE `footer_social` (
  `footer_social_id` int(11) NOT NULL,
  `social_name` varchar(255) DEFAULT NULL,
  `social_url` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `footer_social`
--

INSERT INTO `footer_social` (`footer_social_id`, `social_name`, `social_url`, `active`, `timestamp_update`) VALUES
(1, 'twitter', '', 0, '2016-05-06 15:50:59'),
(2, 'facebook', '', 0, '2016-05-06 15:50:59'),
(3, 'linkedin', '', 0, '2016-05-06 15:50:59'),
(4, 'youtube', '', 0, '2016-05-06 15:50:59'),
(5, 'google', '', 0, '2016-05-06 15:50:59'),
(6, 'pinterest', '', 0, '2016-05-06 15:50:59'),
(7, 'foursquare', '', 0, '2016-05-06 15:50:59'),
(8, 'myspace', '', 0, '2016-05-06 15:50:59'),
(9, 'soundcloud', '', 0, '2016-05-06 15:50:59'),
(10, 'spotify', '', 0, '2016-05-06 15:50:59'),
(11, 'lastfm', '', 0, '2016-05-06 15:50:59'),
(12, 'vimeo', '', 0, '2016-05-06 15:50:59'),
(13, 'dailymotion', '', 0, '2016-05-06 15:50:59'),
(14, 'vine', '', 0, '2016-05-06 15:50:59'),
(15, 'flickr', '', 0, '2016-05-06 15:50:59'),
(16, 'instagram', '', 0, '2016-05-06 15:50:59'),
(17, 'tumblr', '', 0, '2016-05-06 15:50:59'),
(18, 'reddit', '', 0, '2016-05-06 15:50:59'),
(19, 'envato', '', 0, '2016-05-06 15:50:59'),
(20, 'github', '', 0, '2016-05-06 15:50:59'),
(21, 'tripadvisor', '', 0, '2016-05-06 15:50:59'),
(22, 'stackoverflow', '', 0, '2016-05-06 15:50:59'),
(23, 'persona', '', 0, '2016-05-06 15:50:59'),
(24, 'odnoklassniki', '', 0, '2016-05-06 15:50:59'),
(25, 'vk', '', 0, '2016-05-06 15:50:59'),
(26, 'gitlab', '', 0, '2016-05-06 15:50:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form_contactus_en`
--

CREATE TABLE `form_contactus_en` (
  `form_contactus_en_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_type` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form_field`
--

CREATE TABLE `form_field` (
  `form_field_id` int(11) NOT NULL,
  `form_main_id` int(11) DEFAULT NULL,
  `field_type` varchar(100) DEFAULT NULL,
  `field_name` varchar(255) DEFAULT NULL,
  `field_id` varchar(255) DEFAULT NULL,
  `field_class` varchar(255) DEFAULT NULL,
  `field_placeholder` varchar(255) DEFAULT NULL,
  `field_value` varchar(255) DEFAULT NULL,
  `field_label` varchar(255) DEFAULT NULL,
  `sel_option_val` text DEFAULT NULL,
  `field_required` int(11) DEFAULT NULL,
  `field_div_class` varchar(255) DEFAULT NULL,
  `arrange` int(11) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `form_field`
--

INSERT INTO `form_field` (`form_field_id`, `form_main_id`, `field_type`, `field_name`, `field_id`, `field_class`, `field_placeholder`, `field_value`, `field_label`, `sel_option_val`, `field_required`, `field_div_class`, `arrange`, `timestamp_create`, `timestamp_update`) VALUES
(1, 1, 'text', 'name', 'name', 'form-control', '', '', 'Name', '', 1, NULL, 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(2, 1, 'email', 'email', 'email', 'form-control', '', '', 'Email Address', '', 1, NULL, 2, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(3, 1, 'selectbox', 'contact_type', 'contact_type', 'form-control', '-- Choose Type --', '', 'Contact Type', 'question=>Question, contact us=>Contact Us, service=>Service', 1, NULL, 3, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(4, 1, 'textarea', 'message', 'message', 'form-control', '', '', 'Message', '', 1, NULL, 4, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(5, 1, 'submit', 'submit', 'submit', 'btn btn-primary', '', 'Send now', '', '', 0, NULL, 5, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(6, 1, 'reset', 'reset', 'reset', 'btn btn-default', '', 'Reset', '', '', 0, NULL, 6, '2016-05-02 19:15:50', '2016-05-02 19:15:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form_main`
--

CREATE TABLE `form_main` (
  `form_main_id` int(11) NOT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `form_enctype` varchar(255) DEFAULT NULL,
  `form_method` varchar(255) DEFAULT NULL,
  `success_txt` varchar(255) DEFAULT NULL,
  `captchaerror_txt` varchar(255) DEFAULT NULL,
  `error_txt` varchar(255) DEFAULT NULL,
  `sendmail` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `send_to_visitor` int(11) DEFAULT NULL,
  `email_field_id` int(11) DEFAULT NULL,
  `visitor_subject` varchar(255) DEFAULT NULL,
  `visitor_body` text DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `captcha` int(11) DEFAULT NULL,
  `save_to_db` int(11) DEFAULT NULL,
  `dont_repeat_field` varchar(255) DEFAULT NULL,
  `repeat_txt` varchar(255) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `form_main`
--

INSERT INTO `form_main` (`form_main_id`, `form_name`, `form_enctype`, `form_method`, `success_txt`, `captchaerror_txt`, `error_txt`, `sendmail`, `email`, `subject`, `send_to_visitor`, `email_field_id`, `visitor_subject`, `visitor_body`, `active`, `captcha`, `save_to_db`, `dont_repeat_field`, `repeat_txt`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'contactus_en', '', 'post', 'Successfully!', 'The Security Check was not input correctly. Please try again.', 'Error! Please try again.', 1, '', 'Contact us from the CSZ-CMS website', 0, 0, '', '', 1, 1, 1, '', 'Your data is duplicated in the system.', '2020-05-31 18:13:45', '2020-05-31 18:13:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery_config`
--

CREATE TABLE `gallery_config` (
  `gallery_config_id` int(11) NOT NULL,
  `gallery_sort` varchar(255) DEFAULT NULL,
  `user_admin_id` int(11) DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gallery_config`
--

INSERT INTO `gallery_config` (`gallery_config_id`, `gallery_sort`, `user_admin_id`, `timestamp_update`) VALUES
(1, 'manually', 1, '2020-05-31 18:13:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery_db`
--

CREATE TABLE `gallery_db` (
  `gallery_db_id` int(11) NOT NULL,
  `album_name` varchar(255) DEFAULT NULL,
  `url_rewrite` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `short_desc` text DEFAULT NULL,
  `lang_iso` varchar(10) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `arrange` int(11) DEFAULT NULL,
  `user_groups_idS` text DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery_picture`
--

CREATE TABLE `gallery_picture` (
  `gallery_picture_id` int(11) NOT NULL,
  `gallery_db_id` int(11) DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `arrange` int(11) DEFAULT NULL,
  `gallery_type` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `general_label`
--

CREATE TABLE `general_label` (
  `general_label_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `lang_en` text DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `general_label`
--

INSERT INTO `general_label` (`general_label_id`, `name`, `remark`, `lang_en`, `timestamp_update`) VALUES
(1, 'login_heading', 'For member login Header text', 'Inicio de sesion', '2016-07-04 11:43:18'),
(2, 'login_incorrect', 'For member login incorrect', 'Email address/Password is incorrect', '2016-07-04 11:44:09'),
(3, 'captcha_wrong', 'For member login when wrong captcha', 'The Security Check was not input correctly. Please try again.', '2016-07-04 11:44:39'),
(4, 'login_email', 'For email address label', 'Email Address', '2016-06-23 23:34:45'),
(5, 'login_password', 'For password label', 'Your Password', '2016-06-23 23:35:22'),
(6, 'login_signin', 'For member login button', 'Log in', '2016-06-23 23:35:53'),
(7, 'login_forgetpwd', 'For member forget password button', 'Forgot Password', '2016-06-23 23:37:02'),
(8, 'login_register', 'For member register label', 'Register', '2016-06-24 16:41:07'),
(9, 'member_firstname', 'For member firstname label', 'First Name', '2016-06-24 16:58:09'),
(10, 'member_lastname', 'For member lastname label', 'Last Name', '2016-06-24 16:58:09'),
(11, 'member_address', 'For member address label', 'Address', '2016-06-24 16:58:09'),
(12, 'confirm_password', 'For confirm password label', 'Confirm Password', '2016-06-24 16:58:09'),
(13, 'member_forgot_complete', 'For forget password is successfully', 'Successfully! Your password has been reset', '2016-06-24 16:58:09'),
(14, 'member_reset_btn', 'For reset button', 'Reset', '2016-06-24 17:48:32'),
(15, 'member_forget_chkmail', 'For reset text email to inbox', 'Please check your email inbox and click the link to continue the process.', '2016-06-24 17:48:32'),
(16, 'email_reset_subject', 'For email subject when member forget password', 'Reset your member password', '2016-06-26 15:43:39'),
(17, 'email_reset_message', 'For email message when member forget password', 'Please click the link within 30 minutes to reset your password.', '2016-06-26 15:43:39'),
(18, 'email_dear', 'For email header', 'Dear ', '2016-06-26 15:43:39'),
(19, 'email_footer', 'For email footer', 'Regards,', '2016-06-26 15:43:39'),
(20, 'email_check', 'For email does not exist text', 'This email address does not exist', '2016-06-26 15:47:01'),
(21, 'btn_cancel', 'For cancel button', 'Cancel', '2016-06-26 15:52:28'),
(22, 'btn_back', 'For back button', 'Back', '2016-06-26 15:53:59'),
(23, 'email_already', 'For email has already', 'This email address has already', '2016-06-26 21:31:20'),
(24, 'email_confirm_subject', 'For email confirm subject text', 'Confirm your member register', '2016-06-27 18:00:10'),
(25, 'email_confirm_message', 'For email confirm message', 'Please click the link within 30 minutes to confirm your member.', '2016-06-28 10:28:20'),
(26, 'log_out', 'For log out text', 'Log out', '2016-07-01 16:25:24'),
(27, 'backend_system', 'For back-end system text', 'Admin System', '2016-07-01 16:25:24'),
(28, 'edit_profile', 'For edit profile text', 'Edit Profile', '2016-07-01 16:25:24'),
(29, 'member_dashboard_text', 'For member dashboard text', 'Welcome to Member Dashboard!', '2016-07-01 16:25:24'),
(30, 'your_profile', 'For your profile text', 'Your Profile', '2016-07-01 16:29:30'),
(31, 'member_menu', 'For member menu text', 'Member Menu', '2016-07-01 16:37:37'),
(32, 'display_name', 'For display name text', 'Display Name', '2016-07-01 16:45:41'),
(33, 'email_address', 'For email address text', 'Email Address', '2016-07-01 16:45:41'),
(34, 'user_type', 'For permission type text', 'Permission Type', '2016-07-01 16:45:41'),
(35, 'first_name', 'For first name text', 'First Name', '2016-07-01 16:45:41'),
(36, 'last_name', 'For last name text', 'Last Name', '2016-07-01 16:45:41'),
(37, 'birthday', 'For birthday text', 'Birth Day', '2016-07-01 16:45:41'),
(38, 'gender', 'For gender text', 'Gender', '2016-07-01 16:45:41'),
(39, 'phone', 'For phone text', 'Phone', '2016-07-01 16:45:41'),
(40, 'address', 'For address text', 'Address', '2016-07-01 16:45:41'),
(41, 'new_password', 'For new password text', 'New Password', '2016-07-02 18:01:57'),
(42, 'change_password', 'For change password text', 'Change Password', '2016-07-02 18:04:49'),
(43, 'picture', 'For picture text', 'Picture', '2016-07-02 18:18:58'),
(44, 'save_btn', 'For save button text', 'Save', '2016-07-02 18:35:11'),
(45, 'cancel_btn', 'For cancel button text', 'Cancel', '2016-07-02 18:35:11'),
(46, 'article_index_header', 'For article index page', 'List of Article', '2016-07-12 17:08:16'),
(47, 'article_category_menu', 'For category of article text', 'Category', '2016-07-12 17:23:40'),
(48, 'article_readmore_text', 'For read more button of article text', 'Read More', '2016-07-12 17:23:40'),
(49, 'article_not_found', 'For article not found text', 'Article not found!', '2016-07-12 17:33:20'),
(50, 'article_cat_not_found', 'For category of article not found text', 'Category not found!', '2016-07-12 17:54:29'),
(51, 'article_postdate', 'For date time of article text', 'Posted date', '2016-07-13 13:56:02'),
(52, 'article_postby', 'For post by text', 'Posted by', '2016-07-13 13:56:02'),
(53, 'gallery_header', 'For gallery header text', 'Gallery', '2016-07-15 13:47:17'),
(54, 'gallery_albumlist', 'For album list text', 'List of Album', '2016-07-15 13:47:17'),
(55, 'total_txt', 'For total text', 'Total:', '2016-07-15 15:24:11'),
(56, 'records_txt', 'For records text', 'Records', '2016-07-15 15:23:54'),
(57, 'gallery_not_found', 'for gallery not found text', 'Gallery not found!', '2016-07-15 15:33:35'),
(58, 'picture_not_found', 'For picture not found text', 'Picture not found!', '2016-07-15 15:35:40'),
(59, 'gellery_view_btn', 'For gallery view button', 'View Gallery', '2016-07-15 15:41:19'),
(60, 'article_archive', 'For article archive text', 'Archive', '2016-07-21 10:39:19'),
(61, 'article_updatedate', 'For article updatetime text', 'Updated date', '2016-07-21 10:39:19'),
(62, 'article_search_txt', 'For article search text', 'Article Search', '2016-09-26 10:53:09'),
(63, 'pm_txt', 'For private message header text', 'Private Message', '2017-02-27 10:53:09'),
(64, 'pm_to_txt', 'For private message (To) text', 'To', '2017-02-27 10:53:09'),
(65, 'pm_from_txt', 'For private message (From) text', 'From', '2017-02-27 10:53:09'),
(66, 'pm_subject_txt', 'For private message subject text', 'Subject', '2017-02-27 10:53:09'),
(67, 'pm_msg_txt', 'For private message text', 'Message', '2017-02-27 10:53:09'),
(68, 'pm_send_txt', 'For private message send text', 'Send', '2017-02-27 10:53:09'),
(69, 'pm_delete_txt', 'For private message delete text', 'Delete', '2017-02-27 10:53:09'),
(70, 'pm_inbox_txt', 'For private message inbox text', 'Inbox', '2017-02-27 10:53:09'),
(71, 'pm_newmsg_txt', 'For private message new message text', 'New Message', '2017-02-27 10:53:09'),
(72, 'users_list_txt', 'For users list text', 'Users List', '2017-02-28 10:53:09'),
(73, 'pm_datetime_txt', 'For date time text', 'Date/Time', '2017-02-28 10:53:09'),
(74, 'not_permission_txt', 'For not have permission text', 'You might not have permission to access this section!', '2017-02-28 10:53:09'),
(75, 'success_txt', 'For success text', 'Successfully!', '2017-03-02 10:53:09'),
(76, 'error_txt', 'For error text', 'Data not found! / Error! Please try again.', '2017-03-02 10:53:09'),
(77, 'plugin_member_menu', 'For plugin member menu text', 'Plugins Menu', '2017-03-02 10:53:09'),
(78, 'article_filedownload_text', 'For file download label', 'File Download', '2020-05-31 18:13:45'),
(79, 'article_download_link', 'For download label', 'Download', '2020-05-31 18:13:45'),
(80, 'form_doublesubmit_alert', 'For form double submit alert text', 'The form is being submitted, please wait a moment...', '2020-05-31 18:13:45'),
(81, 'form_submiting_btn', 'For form button been submitting text', 'Processing, Please wait...', '2020-05-31 18:13:45'),
(82, 'site_error_404_title', 'For page not found error 404 title', 'Error 404, The requested page not Found!', '2020-05-31 18:13:45'),
(83, 'site_error_404_text', 'For page not found error 404 text', 'Sorry! The page is broken or the page has been moved. Please back to home page.', '2020-05-31 18:13:45'),
(84, 'site_maintenance_title', 'For site maintenance title', 'Maintenance!', '2020-05-31 18:13:45'),
(85, 'site_maintenance_subtitle', 'For site maintenance sub title', 'We are undergoing a bit of scheduled maintenance.', '2020-05-31 18:13:45'),
(86, 'site_maintenance_text', 'For site maintenance body text', 'Sorry for the inconvenience and will be back online shortly. Please check back soon.', '2020-05-31 18:13:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lang_iso`
--

CREATE TABLE `lang_iso` (
  `lang_iso_id` int(11) NOT NULL,
  `lang_name` varchar(255) DEFAULT NULL,
  `lang_iso` varchar(10) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `country_iso` varchar(10) DEFAULT NULL,
  `active` int(2) DEFAULT NULL,
  `arrange` int(11) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Language ISO';

--
-- Volcado de datos para la tabla `lang_iso`
--

INSERT INTO `lang_iso` (`lang_iso_id`, `lang_name`, `lang_iso`, `country`, `country_iso`, `active`, `arrange`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'English', 'en', 'United Kingdom', 'gb', 1, 1, '2016-03-29 15:16:23', '2016-03-31 15:28:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link_statistic`
--

CREATE TABLE `link_statistic` (
  `link_statistic_id` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link_stat_mgt`
--

CREATE TABLE `link_stat_mgt` (
  `link_stat_mgt_id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_logs`
--

CREATE TABLE `login_logs` (
  `login_logs_id` int(11) NOT NULL,
  `email_login` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `login_logs`
--

INSERT INTO `login_logs` (`login_logs_id`, `email_login`, `user_agent`, `ip_address`, `note`, `result`, `timestamp_create`) VALUES
(1, 'bruno.poehlmann@gmail.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '::1', 'Backend Login Successful!', 'SUCCESS', '2020-05-31 18:14:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_security_config`
--

CREATE TABLE `login_security_config` (
  `login_security_config_id` int(11) NOT NULL,
  `bf_protect_period` int(11) DEFAULT NULL,
  `max_failure` int(11) DEFAULT NULL,
  `bf_private_key` varchar(255) DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `login_security_config`
--

INSERT INTO `login_security_config` (`login_security_config_id`, `bf_protect_period`, `max_failure`, `bf_private_key`, `timestamp_update`) VALUES
(1, 60, 20, '', '2020-05-31 18:13:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

CREATE TABLE `pages` (
  `pages_id` int(11) NOT NULL,
  `page_name` varchar(255) DEFAULT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `lang_iso` varchar(10) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_keywords` varchar(255) DEFAULT NULL,
  `page_desc` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `more_metatag` text DEFAULT NULL,
  `custom_css` text DEFAULT NULL,
  `custom_js` text DEFAULT NULL,
  `user_groups_idS` text DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pages`
--

INSERT INTO `pages` (`pages_id`, `page_name`, `page_url`, `lang_iso`, `page_title`, `page_keywords`, `page_desc`, `content`, `more_metatag`, `custom_css`, `custom_js`, `user_groups_idS`, `active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 'home', 'en', 'CSZ Home', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english, homepage', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<header>[?]{=carousel:1}[?]</header><!-- Start Jumbotron -->\r\n<div class=\"jumbotron\">\r\n<div class=\"container\">\r\n<h1>Hello, world!</h1>\r\n<p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>\r\n<p><a class=\"btn btn-primary btn-lg\" href=\"#\" role=\"button\">Learn more »</a></p>\r\n</div>\r\n</div>\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-4\">\r\n<h2>Heading</h2>\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n<p><a class=\"btn btn-default\" href=\"#\" role=\"button\">View details »</a></p>\r\n</div>\r\n<div class=\"col-md-4\">\r\n<h2>Heading</h2>\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n<p><a class=\"btn btn-default\" href=\"#\" role=\"button\">View details »</a></p>\r\n</div>\r\n<div class=\"col-md-4\">\r\n<h2>Heading</h2>\r\n<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\r\n<p><a class=\"btn btn-default\" href=\"#\" role=\"button\">View details »</a></p>\r\n</div>\r\n</div>\r\n</div>\r\n', NULL, '', '', NULL, 1, '2016-03-08 10:12:56', '2016-05-09 11:00:51'),
(2, 'Abouts Us', 'abouts-us', 'en', 'CSZ-CMS About Us', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, aboutus', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<div class=\"jumbotron\">\r\n<div class=\"container\">\r\n<h1>About Us!</h1>\r\n<p>CSKAZA Template for Bootstrap with CSZ-CMS. CSZ-CMS build by CSKAZA.</p>\r\n<p><a class=\"btn btn-primary btn-lg\" href=\"#\" role=\"button\">Learn more »</a></p>\r\n</div>\r\n</div>\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-6\">\r\n<div class=\"panel panel-default\">\r\n<div class=\"panel-heading\">Panel heading</div>\r\n<div class=\"panel-body\">\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"col-md-6\">\r\n<div class=\"panel panel-default\">\r\n<div class=\"panel-heading\">Panel heading</div>\r\n<div class=\"panel-body\">\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"container\"></div>\r\n<p></p>', NULL, '', '', NULL, 1, '2016-04-11 15:17:18', '2016-05-01 15:16:13'),
(3, 'Contact Us', 'contact-us', 'en', 'CSZ-CMS Contact us', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, contact us', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<div class=\"jumbotron\">\r\n<div class=\"container\">\r\n<h1>Contact us!</h1>\r\n<p>If you want to contact us please use this form below. Or send the email to <a href=\"mailto:info@cszcms.com\">info[at]cszcms.com</a></p>\r\n</div>\r\n</div>\r\n<div class=\"container\"></div>\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-6\">\r\n<h2>Google Map</h2>\r\n<p><iframe width=\"100%\" height=\"315\" src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.168282092751!2d98.37285931425068!3d7.877454308128998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2zN8KwNTInMzguOCJOIDk4wrAyMiczMC4yIkU!5e0!3m2!1sen!2sth!4v1462104596003\" frameborder=\"0\" allowfullscreen=\"allowfullscreen\"></iframe></p>\r\n</div>\r\n<div class=\"col-md-6\">\r\n<h2>Contact Form</h2>\r\n<p>If you have any question please send this from.</p>\r\n<p>[?]{=forms:contactus_en}[?]</p>\r\n</div>\r\n</div>\r\n</div>\r\n<p></p>\r\n<p></p>', NULL, '', '', NULL, 1, '2016-04-30 16:57:16', '2016-05-12 17:59:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page_menu`
--

CREATE TABLE `page_menu` (
  `page_menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `lang_iso` varchar(10) DEFAULT NULL,
  `pages_id` int(11) DEFAULT NULL,
  `other_link` varchar(512) DEFAULT NULL,
  `plugin_menu` varchar(255) DEFAULT NULL,
  `drop_menu` int(11) DEFAULT NULL,
  `drop_page_menu_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `new_windows` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `arrange` int(11) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `page_menu`
--

INSERT INTO `page_menu` (`page_menu_id`, `menu_name`, `lang_iso`, `pages_id`, `other_link`, `plugin_menu`, `drop_menu`, `drop_page_menu_id`, `position`, `new_windows`, `active`, `arrange`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 'en', 1, '', '', 0, 0, 0, 0, 1, 1, '2016-03-25 13:00:08', '2020-05-31 18:42:37'),
(2, 'Abouts Us', 'en', 2, '', '', 0, 0, 0, 0, 1, 3, '2016-04-11 15:01:03', '2020-05-31 18:42:37'),
(3, 'Contact Us', 'en', 3, '', '', 0, 0, 0, 0, 1, 4, '2016-04-30 16:58:02', '2020-05-31 18:42:37'),
(4, 'Drop Menu', 'en', 0, '', '', 1, 0, 0, 0, 1, 5, '2016-03-27 15:54:15', '2020-05-31 18:42:37'),
(5, 'CSZ CMS Website', 'en', 0, 'https://www.cszcms.com', '', 0, 4, 0, 1, 1, 1, '2016-03-28 15:22:12', '2020-05-31 18:42:37'),
(6, 'Article', 'en', 0, '', 'article', 0, 0, 0, 0, 1, 2, '2020-05-31 18:42:17', '2020-05-31 18:42:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plugin_manager`
--

CREATE TABLE `plugin_manager` (
  `plugin_manager_id` int(11) NOT NULL,
  `plugin_config_filename` varchar(255) DEFAULT NULL,
  `plugin_active` int(11) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `plugin_manager`
--

INSERT INTO `plugin_manager` (`plugin_manager_id`, `plugin_config_filename`, `plugin_active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'article', 1, '2020-05-31 18:13:45', '2020-05-31 18:13:45'),
(2, 'gallery', 1, '2020-05-31 18:13:45', '2020-05-31 18:13:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plugin_widget`
--

CREATE TABLE `plugin_widget` (
  `plugin_widget_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `plugin_filename` varchar(255) DEFAULT NULL,
  `sort_by` varchar(255) DEFAULT NULL,
  `order_by` varchar(10) DEFAULT NULL,
  `data_limit` int(11) DEFAULT NULL,
  `view_id` int(11) DEFAULT NULL,
  `template_code` text DEFAULT NULL,
  `lang_iso` varchar(10) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `plugin_widget`
--

INSERT INTO `plugin_widget` (`plugin_widget_id`, `name`, `plugin_filename`, `sort_by`, `order_by`, `data_limit`, `view_id`, `template_code`, `lang_iso`, `active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Article', 'article', 'timestamp_create', 'DESC', 10, 0, '<p>{loop}</p>\r\n<div class=\"row\">\r\n<div class=\"col-md-3\"><a href=\"{base_url_plugin}/view/{field=article_db_id}/{field=url_rewrite}\" title=\"{field=title}\"><img class=\"lazy img-responsive img-thumbnail\" data-src=\"{base_url_photo_plugin}/{field=main_picture}\" alt=\"{field=title}\"></a></div>\r\n<div class=\"col-md-9\"><a href=\"{base_url_plugin}/view/{field=article_db_id}/{field=url_rewrite}\" title=\"{field=title}\" class=\"h4\"><b>{field=title}</b></a> <br>\r\n<p>{field=short_desc}</p>\r\n</div>\r\n</div>\r\n<hr>\r\n<p>{endloop}</p>\r\n<div class=\"text-right\"><a href=\"{base_url_plugin}\" class=\"btn btn-primary btn-sm\">Read More</a></div>', '', 1, '2020-05-31 18:38:37', '2020-05-31 18:40:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `save_formdraft`
--

CREATE TABLE `save_formdraft` (
  `id` int(11) NOT NULL,
  `form_url` text DEFAULT NULL,
  `submit_array` text DEFAULT NULL,
  `user_admin_id` int(11) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `fbapp_id` varchar(255) DEFAULT NULL,
  `site_footer` text DEFAULT NULL,
  `default_email` varchar(255) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `themes_config` varchar(255) DEFAULT NULL,
  `admin_lang` varchar(255) DEFAULT NULL,
  `additional_js` text DEFAULT NULL,
  `additional_metatag` text DEFAULT NULL,
  `googlecapt_active` int(11) DEFAULT NULL,
  `googlecapt_sitekey` varchar(255) DEFAULT NULL,
  `googlecapt_secretkey` varchar(255) DEFAULT NULL,
  `pagecache_time` int(3) DEFAULT NULL,
  `email_protocal` varchar(20) DEFAULT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_user` varchar(255) DEFAULT NULL,
  `smtp_pass` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(5) DEFAULT NULL,
  `sendmail_path` varchar(255) DEFAULT NULL,
  `member_confirm_enable` int(11) DEFAULT NULL,
  `member_close_regist` int(11) DEFAULT NULL,
  `gmaps_key` varchar(255) DEFAULT NULL,
  `gmaps_lat` varchar(100) DEFAULT NULL,
  `gmaps_lng` varchar(100) DEFAULT NULL,
  `ga_client_id` varchar(255) DEFAULT NULL,
  `ga_view_id` varchar(255) DEFAULT NULL,
  `gsearch_active` int(11) DEFAULT NULL,
  `gsearch_cxid` varchar(255) DEFAULT NULL,
  `maintenance_active` int(11) DEFAULT NULL,
  `html_optimize_disable` int(11) DEFAULT NULL,
  `adobe_cc_apikey` varchar(255) DEFAULT NULL,
  `facebook_page_id` varchar(255) DEFAULT NULL,
  `assets_static_active` int(11) DEFAULT NULL,
  `assets_static_domain` varchar(255) DEFAULT NULL,
  `fb_messenger` int(11) DEFAULT NULL,
  `email_logs` int(11) DEFAULT NULL,
  `title_setting` int(11) DEFAULT NULL,
  `cookieinfo_active` int(11) DEFAULT NULL,
  `cookieinfo_bg` varchar(7) DEFAULT NULL,
  `cookieinfo_fg` varchar(7) DEFAULT NULL,
  `cookieinfo_link` varchar(7) DEFAULT NULL,
  `cookieinfo_msg` varchar(255) DEFAULT NULL,
  `cookieinfo_linkmsg` varchar(100) DEFAULT NULL,
  `cookieinfo_moreinfo` varchar(255) DEFAULT NULL,
  `cookieinfo_txtalign` varchar(30) DEFAULT NULL,
  `cookieinfo_close` varchar(100) DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`settings_id`, `site_name`, `site_logo`, `og_image`, `fbapp_id`, `site_footer`, `default_email`, `keywords`, `themes_config`, `admin_lang`, `additional_js`, `additional_metatag`, `googlecapt_active`, `googlecapt_sitekey`, `googlecapt_secretkey`, `pagecache_time`, `email_protocal`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `sendmail_path`, `member_confirm_enable`, `member_close_regist`, `gmaps_key`, `gmaps_lat`, `gmaps_lng`, `ga_client_id`, `ga_view_id`, `gsearch_active`, `gsearch_cxid`, `maintenance_active`, `html_optimize_disable`, `adobe_cc_apikey`, `facebook_page_id`, `assets_static_active`, `assets_static_domain`, `fb_messenger`, `email_logs`, `title_setting`, `cookieinfo_active`, `cookieinfo_bg`, `cookieinfo_fg`, `cookieinfo_link`, `cookieinfo_msg`, `cookieinfo_linkmsg`, `cookieinfo_moreinfo`, `cookieinfo_txtalign`, `cookieinfo_close`, `timestamp_update`) VALUES
(1, 'CSZ CMS Starter', '', '', '', '&copy; %Y% CSZ CMS Starter', 'bruno.poehlmann@gmail.com', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english', 'cszdefault', 'english', '', '', 0, '', '', 0, '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, '', 0, 1, NULL, NULL, NULL, NULL, NULL, 1, 2, 0, '#645862', '#FFFFFF', '#F1D600', 'This website uses cookies to improve your user experience. By continuing to browse our site you accepted and agreed on our ', 'Privacy Policy and terms.', 'https://www.cszcms.com/LICENSE.md', 'left', 'Got it!', '2020-05-31 18:13:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `upload_file`
--

CREATE TABLE `upload_file` (
  `upload_file_id` int(11) NOT NULL,
  `year` varchar(10) DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_admin`
--

CREATE TABLE `user_admin` (
  `user_admin_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `md5_hash` varchar(255) DEFAULT NULL,
  `md5_lasttime` datetime DEFAULT NULL,
  `pm_sendmail` int(11) DEFAULT NULL,
  `timestamp_login` datetime DEFAULT NULL,
  `pass_change` int(11) DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_admin`
--

INSERT INTO `user_admin` (`user_admin_id`, `name`, `email`, `password`, `user_type`, `first_name`, `last_name`, `birthday`, `gender`, `address`, `phone`, `picture`, `active`, `session_id`, `md5_hash`, `md5_lasttime`, `pm_sendmail`, `timestamp_login`, `pass_change`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Admin User', 'bruno.poehlmann@gmail.com', '$2y$12$hraAXt03ie/XW0GlQvlFBuOaXeIYIeDcQLlnTrX7ismlNjCAVOk1u', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '325bf1mtl6mg5pr7tkiqi7a10tl4aoqr', '35f2285134043deaa9bd8e7f2a87d22f', '2020-05-31 18:13:47', 1, '2020-05-31 18:14:12', 1, '2020-05-31 18:13:47', '2020-05-31 18:13:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

CREATE TABLE `user_groups` (
  `user_groups_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `definition` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_groups`
--

INSERT INTO `user_groups` (`user_groups_id`, `name`, `definition`) VALUES
(1, 'Admin', 'Super Admin Group'),
(2, 'Editor', 'Editor Access Group'),
(3, 'Public', 'Public Access Group'),
(4, 'Guest', 'Guest Access Group');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_perms`
--

CREATE TABLE `user_perms` (
  `user_perms_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `definition` text DEFAULT NULL,
  `permstype` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_perms`
--

INSERT INTO `user_perms` (`user_perms_id`, `name`, `definition`, `permstype`) VALUES
(1, 'save', 'For save permission on backend', 'backend'),
(2, 'delete', 'For delete permission on backend', 'backend'),
(3, 'analytics', 'For analytics access permission on backend', 'backend'),
(4, 'forms builder', 'For forms builder access permission', 'backend'),
(5, 'plugin widget', 'For plugin widget access permission on backend', 'backend'),
(6, 'file upload', 'For file upload access permission on backend', 'backend'),
(7, 'pages content', 'For pages content access permission on backend', 'backend'),
(8, 'navigation', 'For navigation access permission on backend', 'backend'),
(9, 'linkstats', 'For statistic for links access permission on backend', 'backend'),
(10, 'language', 'For language access permission on backend', 'backend'),
(11, 'general label', 'For general label access permission on backend', 'backend'),
(12, 'site settings', 'For site settings access permission on backend', 'backend'),
(13, 'maintenance', 'For maintenance system access permission on backend', 'backend'),
(14, 'plugin manager', 'For plugin manager access permission on backend', 'backend'),
(15, 'admin users', 'For admin users access permission on backend', 'backend'),
(16, 'member users', 'For member users access permission on backend', 'backend'),
(17, 'user groups', 'For user groups access permission on backend', 'backend'),
(18, 'email logs', 'For email logs access permission on backend', 'backend'),
(19, 'login logs', 'For login logs access permission on backend', 'backend'),
(20, 'protection settings', 'For protection settings access permission on backend', 'backend'),
(21, 'gallery', 'For gallery plugin access permission on backend', 'backend'),
(22, 'article', 'For article plugin access permission on backend', 'backend'),
(23, 'social', 'For social settings access permission on backend', 'backend'),
(24, 'profile save', 'For user profile save permission on frontend', 'frontend'),
(25, 'pm', 'For private message access permission on frontend', 'frontend'),
(26, 'banner', 'For banner manager access permission on backend', 'backend'),
(27, 'file manager', 'For file manager access permission on backend', 'backend'),
(28, 'pages cssjs additional', 'For pages content css js metatag additional access permission on backend', 'backend'),
(29, 'export', 'For Import Export CSV access permission on backend', 'backend'),
(30, 'pm', 'For PM access permission on backend', 'backend'),
(31, 'carousel', 'For carousel access permission on backend', 'backend'),
(32, 'old plugin widget', 'For old plugin widget access permission on backend', 'backend'),
(33, 'server info', 'For server information access permission on backend', 'backend');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_perm_to_group`
--

CREATE TABLE `user_perm_to_group` (
  `user_perms_id` int(11) NOT NULL,
  `user_groups_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_perm_to_group`
--

INSERT INTO `user_perm_to_group` (`user_perms_id`, `user_groups_id`) VALUES
(1, 2),
(3, 2),
(3, 4),
(4, 2),
(4, 4),
(5, 2),
(5, 4),
(6, 2),
(6, 4),
(7, 2),
(7, 4),
(8, 2),
(8, 4),
(9, 2),
(9, 4),
(10, 2),
(10, 4),
(11, 2),
(11, 4),
(12, 4),
(13, 2),
(13, 4),
(14, 4),
(21, 2),
(21, 4),
(22, 2),
(22, 4),
(23, 2),
(23, 4),
(24, 2),
(24, 3),
(25, 2),
(25, 3),
(25, 4),
(26, 2),
(26, 4),
(27, 2),
(30, 2),
(31, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_pms`
--

CREATE TABLE `user_pms` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `date_read` datetime DEFAULT NULL,
  `pm_deleted_sender` int(1) DEFAULT NULL,
  `pm_deleted_receiver` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_to_group`
--

CREATE TABLE `user_to_group` (
  `user_admin_id` int(11) NOT NULL,
  `user_groups_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_to_group`
--

INSERT INTO `user_to_group` (`user_admin_id`, `user_groups_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `whitelist_ip`
--

CREATE TABLE `whitelist_ip` (
  `whitelist_ip_id` int(11) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `widget_xml`
--

CREATE TABLE `widget_xml` (
  `widget_xml_id` int(11) NOT NULL,
  `widget_name` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL,
  `limit_view` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `widget_open` text DEFAULT NULL,
  `widget_content` text DEFAULT NULL,
  `widget_seemore` text DEFAULT NULL,
  `widget_close` text DEFAULT NULL,
  `timestamp_create` datetime DEFAULT NULL,
  `timestamp_update` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `widget_xml`
--

INSERT INTO `widget_xml` (`widget_xml_id`, `widget_name`, `xml_url`, `limit_view`, `active`, `widget_open`, `widget_content`, `widget_seemore`, `widget_close`, `timestamp_create`, `timestamp_update`) VALUES
(2, 'Article', 'http://localhost/todolegal/plugin/article/getWidget/en', 10, 1, '<div class=\"panel panel-default\"> <div class=\"panel-heading\"><b>{widget_header_name}</b></div> <div class=\"panel-body\">', '<div class=\"panel panel-default\"> <div class=\"panel-heading\"><b>{widget_header_name}</b></div> <div class=\"panel-body\">', '<div class=\"text-right\"><a href=\"{main_url}\" class=\"btn btn-primary btn-sm\">{readmore_text}</a></div>', '</div></div>', '2020-05-31 18:36:52', '2020-05-31 18:36:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actions_logs`
--
ALTER TABLE `actions_logs`
  ADD PRIMARY KEY (`actions_logs_id`);

--
-- Indices de la tabla `article_db`
--
ALTER TABLE `article_db`
  ADD PRIMARY KEY (`article_db_id`),
  ADD KEY `url_rewrite` (`url_rewrite`);

--
-- Indices de la tabla `article_db_downloadstat`
--
ALTER TABLE `article_db_downloadstat`
  ADD PRIMARY KEY (`article_db_downloadstat_id`),
  ADD KEY `article_db_id` (`article_db_id`);

--
-- Indices de la tabla `banner_mgt`
--
ALTER TABLE `banner_mgt`
  ADD PRIMARY KEY (`banner_mgt_id`),
  ADD KEY `link` (`link`);

--
-- Indices de la tabla `banner_statistic`
--
ALTER TABLE `banner_statistic`
  ADD PRIMARY KEY (`banner_statistic_id`),
  ADD KEY `banner_mgt_id` (`banner_mgt_id`);

--
-- Indices de la tabla `blacklist_ip`
--
ALTER TABLE `blacklist_ip`
  ADD PRIMARY KEY (`blacklist_ip_id`);

--
-- Indices de la tabla `carousel_picture`
--
ALTER TABLE `carousel_picture`
  ADD PRIMARY KEY (`carousel_picture_id`),
  ADD KEY `carousel_widget_id` (`carousel_widget_id`);

--
-- Indices de la tabla `carousel_widget`
--
ALTER TABLE `carousel_widget`
  ADD PRIMARY KEY (`carousel_widget_id`),
  ADD KEY `carousel_widget_id` (`carousel_widget_id`);

--
-- Indices de la tabla `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indices de la tabla `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`email_logs_id`);

--
-- Indices de la tabla `footer_social`
--
ALTER TABLE `footer_social`
  ADD PRIMARY KEY (`footer_social_id`);

--
-- Indices de la tabla `form_contactus_en`
--
ALTER TABLE `form_contactus_en`
  ADD PRIMARY KEY (`form_contactus_en_id`);

--
-- Indices de la tabla `form_field`
--
ALTER TABLE `form_field`
  ADD PRIMARY KEY (`form_field_id`);

--
-- Indices de la tabla `form_main`
--
ALTER TABLE `form_main`
  ADD PRIMARY KEY (`form_main_id`),
  ADD KEY `form_name` (`form_name`);

--
-- Indices de la tabla `gallery_config`
--
ALTER TABLE `gallery_config`
  ADD PRIMARY KEY (`gallery_config_id`);

--
-- Indices de la tabla `gallery_db`
--
ALTER TABLE `gallery_db`
  ADD PRIMARY KEY (`gallery_db_id`),
  ADD KEY `url_rewrite` (`url_rewrite`);

--
-- Indices de la tabla `gallery_picture`
--
ALTER TABLE `gallery_picture`
  ADD PRIMARY KEY (`gallery_picture_id`);

--
-- Indices de la tabla `general_label`
--
ALTER TABLE `general_label`
  ADD PRIMARY KEY (`general_label_id`),
  ADD KEY `name` (`name`);

--
-- Indices de la tabla `lang_iso`
--
ALTER TABLE `lang_iso`
  ADD PRIMARY KEY (`lang_iso_id`);

--
-- Indices de la tabla `link_statistic`
--
ALTER TABLE `link_statistic`
  ADD PRIMARY KEY (`link_statistic_id`),
  ADD KEY `link` (`link`);

--
-- Indices de la tabla `link_stat_mgt`
--
ALTER TABLE `link_stat_mgt`
  ADD PRIMARY KEY (`link_stat_mgt_id`),
  ADD KEY `url` (`url`);

--
-- Indices de la tabla `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`login_logs_id`);

--
-- Indices de la tabla `login_security_config`
--
ALTER TABLE `login_security_config`
  ADD PRIMARY KEY (`login_security_config_id`);

--
-- Indices de la tabla `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `page_url` (`page_url`);

--
-- Indices de la tabla `page_menu`
--
ALTER TABLE `page_menu`
  ADD PRIMARY KEY (`page_menu_id`);

--
-- Indices de la tabla `plugin_manager`
--
ALTER TABLE `plugin_manager`
  ADD PRIMARY KEY (`plugin_manager_id`);

--
-- Indices de la tabla `plugin_widget`
--
ALTER TABLE `plugin_widget`
  ADD PRIMARY KEY (`plugin_widget_id`),
  ADD KEY `plugin_widget_id` (`plugin_widget_id`);

--
-- Indices de la tabla `save_formdraft`
--
ALTER TABLE `save_formdraft`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indices de la tabla `upload_file`
--
ALTER TABLE `upload_file`
  ADD PRIMARY KEY (`upload_file_id`);

--
-- Indices de la tabla `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`user_admin_id`),
  ADD KEY `email` (`email`);

--
-- Indices de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`user_groups_id`);

--
-- Indices de la tabla `user_perms`
--
ALTER TABLE `user_perms`
  ADD PRIMARY KEY (`user_perms_id`);

--
-- Indices de la tabla `user_perm_to_group`
--
ALTER TABLE `user_perm_to_group`
  ADD PRIMARY KEY (`user_perms_id`,`user_groups_id`);

--
-- Indices de la tabla `user_pms`
--
ALTER TABLE `user_pms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `full_index` (`id`,`sender_id`,`receiver_id`,`date_read`);

--
-- Indices de la tabla `user_to_group`
--
ALTER TABLE `user_to_group`
  ADD PRIMARY KEY (`user_admin_id`,`user_groups_id`);

--
-- Indices de la tabla `whitelist_ip`
--
ALTER TABLE `whitelist_ip`
  ADD PRIMARY KEY (`whitelist_ip_id`);

--
-- Indices de la tabla `widget_xml`
--
ALTER TABLE `widget_xml`
  ADD PRIMARY KEY (`widget_xml_id`),
  ADD KEY `widget_name` (`widget_name`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actions_logs`
--
ALTER TABLE `actions_logs`
  MODIFY `actions_logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `article_db`
--
ALTER TABLE `article_db`
  MODIFY `article_db_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `article_db_downloadstat`
--
ALTER TABLE `article_db_downloadstat`
  MODIFY `article_db_downloadstat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `banner_mgt`
--
ALTER TABLE `banner_mgt`
  MODIFY `banner_mgt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `banner_statistic`
--
ALTER TABLE `banner_statistic`
  MODIFY `banner_statistic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `blacklist_ip`
--
ALTER TABLE `blacklist_ip`
  MODIFY `blacklist_ip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carousel_picture`
--
ALTER TABLE `carousel_picture`
  MODIFY `carousel_picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `carousel_widget`
--
ALTER TABLE `carousel_widget`
  MODIFY `carousel_widget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `email_logs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `footer_social`
--
ALTER TABLE `footer_social`
  MODIFY `footer_social_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `form_contactus_en`
--
ALTER TABLE `form_contactus_en`
  MODIFY `form_contactus_en_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `form_field`
--
ALTER TABLE `form_field`
  MODIFY `form_field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `form_main`
--
ALTER TABLE `form_main`
  MODIFY `form_main_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `gallery_config`
--
ALTER TABLE `gallery_config`
  MODIFY `gallery_config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `gallery_db`
--
ALTER TABLE `gallery_db`
  MODIFY `gallery_db_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gallery_picture`
--
ALTER TABLE `gallery_picture`
  MODIFY `gallery_picture_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `general_label`
--
ALTER TABLE `general_label`
  MODIFY `general_label_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `lang_iso`
--
ALTER TABLE `lang_iso`
  MODIFY `lang_iso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `link_statistic`
--
ALTER TABLE `link_statistic`
  MODIFY `link_statistic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `link_stat_mgt`
--
ALTER TABLE `link_stat_mgt`
  MODIFY `link_stat_mgt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `login_logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `login_security_config`
--
ALTER TABLE `login_security_config`
  MODIFY `login_security_config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pages`
--
ALTER TABLE `pages`
  MODIFY `pages_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `page_menu`
--
ALTER TABLE `page_menu`
  MODIFY `page_menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `plugin_manager`
--
ALTER TABLE `plugin_manager`
  MODIFY `plugin_manager_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `plugin_widget`
--
ALTER TABLE `plugin_widget`
  MODIFY `plugin_widget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `save_formdraft`
--
ALTER TABLE `save_formdraft`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `upload_file`
--
ALTER TABLE `upload_file`
  MODIFY `upload_file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `user_admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `user_groups_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `user_perms`
--
ALTER TABLE `user_perms`
  MODIFY `user_perms_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `user_pms`
--
ALTER TABLE `user_pms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `whitelist_ip`
--
ALTER TABLE `whitelist_ip`
  MODIFY `whitelist_ip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `widget_xml`
--
ALTER TABLE `widget_xml`
  MODIFY `widget_xml_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
