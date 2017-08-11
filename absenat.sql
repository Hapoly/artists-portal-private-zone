-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 03, 2017 at 11:44 PM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absenat`
--

-- --------------------------------------------------------

--
-- Table structure for table `age_bounds`
--

CREATE TABLE `age_bounds` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `age_bounds`
--

INSERT INTO `age_bounds` (`id`, `title`) VALUES
(1, '۱۶ - ۱۸'),
(2, '۱۹ - ۲۵'),
(3, '۲۶ - ۳۵'),
(4, '۳۶ - ۵۰'),
(5, '۵۱ - ۷۵'),
(6, 'بالاتر از ۷۵');

-- --------------------------------------------------------

--
-- Table structure for table `business_license_sources`
--

CREATE TABLE `business_license_sources` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `business_license_sources`
--

INSERT INTO `business_license_sources` (`id`, `title`) VALUES
(1, 'غیره'),
(2, 'اصناف');

-- --------------------------------------------------------

--
-- Table structure for table `certificate_types`
--

CREATE TABLE `certificate_types` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `certificate_types`
--

INSERT INTO `certificate_types` (`id`, `title`) VALUES
(1, 'مشخص نشده'),
(2, 'اداری'),
(3, 'تجاری'),
(4, 'خدماتی'),
(5, 'خرده فروشی'),
(6, 'صنعتی');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `title`) VALUES
(1, 'غیره'),
(2, 'آستانه'),
(3, 'انزلی'),
(4, 'رشت'),
(5, 'لاهیجان');

-- --------------------------------------------------------

--
-- Table structure for table `degrees`
--

CREATE TABLE `degrees` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `degrees`
--

INSERT INTO `degrees` (`id`, `title`) VALUES
(1, 'زیر دیپلم'),
(2, 'دکتری'),
(3, 'دیپلم'),
(4, 'کاردانی'),
(5, 'کارشناسی'),
(6, 'کارشناسی ارشد');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `unit_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `id_number` varchar(40) COLLATE utf8_persian_ci NOT NULL,
  `gender` int(11) NOT NULL,
  `father_name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `birth_date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `birth_place` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `habitate` int(11) NOT NULL,
  `habitate_years` int(11) NOT NULL,
  `degree` int(11) NOT NULL,
  `field` int(11) NOT NULL,
  `job` int(11) NOT NULL,
  `marrige` int(11) NOT NULL,
  `dependents` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user`, `unit_id`, `first_name`, `last_name`, `id_number`, `gender`, `father_name`, `birth_date`, `birth_place`, `habitate`, `habitate_years`, `degree`, `field`, `job`, `marrige`, `dependents`, `experience`, `address`, `created_at`, `updated_at`) VALUES
(1, 'admin', 12, 'علیرضا', 'حیدری', '2610105533', 2, 'اکبر', '1395-4-5', 'رشت', 4, 4, 2, 4, 11, 2, 4, 2, '2', NULL, NULL),
(2, 'admin', 1, 'محسن', 'صراف', '۹۳۸۴۷۲۸۳۴۵', 2, 'بهرام', '1300-4-4', 'رشت', 3, 4, 1, 2, 8, 2, 2, 2, 'آستانه اشرفیه - خیابان شهید محلاتی - خیابان امام - نرسیده به سه راه رشت خلخال - کوچه نقوی - پلاک ۱۸', NULL, NULL),
(3, 'admin', 7, 'علیرضا', 'darbandi', '۹۳۸۴۷۲۸۳۴۵', 3, 'اکبر', '1393-4-5', 'رشت', 4, 4, 4, 3, 1, 3, 4, 2, '2', NULL, NULL),
(4, 'admin', 3, 'امیر', 'عقوی', '2547473822', 2, 'شهرام', '1300-4-2', 'رشت', 4, 4, 3, 3, 14, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(5, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 2, 'اکبر', '1390-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(6, 'admin', 3, 'امیر', 'عقوی', '2547473822', 3, 'شهرام', '1300-4-2', 'رشت', 4, 4, 3, 3, 9, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(7, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 2, 'اکبر', '1390-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(8, 'admin', 3, 'امیر', 'عقوی', '2547473822', 2, 'شهرام', '1395-4-2', 'رشت', 4, 4, 3, 3, 1, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(9, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 2, 'اکبر', '1300-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(10, 'admin', 13, 'امیر', 'عقوی', '2547473822', 2, 'شهرام', '1300-4-2', 'رشت', 4, 4, 3, 3, 13, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(11, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 3, 'اکبر', '1390-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(12, 'admin', 3, 'امیر', 'عقوی', '2547473822', 2, 'شهرام', '1395-4-2', 'رشت', 4, 4, 3, 3, 1, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(13, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 2, 'اکبر', '1390-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(14, 'admin', 3, 'امیر', 'عقوی', '2547473822', 2, 'شهرام', '1395-4-2', 'رشت', 4, 4, 3, 3, 1, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(15, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 2, 'اکبر', '1390-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(16, 'admin', 3, 'امیر', 'عقوی', '2547473822', 2, 'شهرام', '1395-4-2', 'رشت', 4, 4, 3, 3, 1, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(17, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 3, 'اکبر', '1390-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(18, 'admin', 3, 'امیر', 'عقوی', '2547473822', 2, 'شهرام', '1395-4-2', 'رشت', 4, 4, 3, 3, 1, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(19, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 2, 'اکبر', '1390-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(20, 'admin', 3, 'امیر', 'عقوی', '2547473822', 2, 'شهرام', '1395-4-2', 'رشت', 4, 4, 3, 3, 1, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(21, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 3, 'اکبر', '1390-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(22, 'admin', 3, 'امیر', 'عقوی', '2547473822', 2, 'شهرام', '1395-4-2', 'رشت', 4, 4, 3, 3, 1, 1, 1, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(23, 'admin', 3, 'علیرضا', 'دربندی', '2610105533', 2, 'اکبر', '1390-1-3', 'رشت', 2, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(24, 'amir96', 18, 'امیر', 'نقوی', '4958374728', 3, 'سعید', '1396-5-3', 'رشت', 3, 4, 2, 2, 1, 2, 4, 2, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(25, 'admin', 19, 'جواد', 'براری', '2405968423', 2, 'مجید', '1364-3-2', 'رشت', 4, 4, 2, 3, 3, 3, 4, 19, 'رشت - معلم - خیابان فلاحتی', NULL, NULL),
(26, 'amir96', 1, 'نگار', 'طالعی', '2610105533', 3, 'اکبر', '1372-4-3', 'رشت', 3, 4, 3, 3, 2, 3, 4, 19, 'رشت - معلم - خیابان فلاحتی', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `title`) VALUES
(1, 'نامشخص'),
(2, 'مرد'),
(3, 'زن');

-- --------------------------------------------------------

--
-- Table structure for table `job_fields`
--

CREATE TABLE `job_fields` (
  `id` int(11) NOT NULL,
  `title` varchar(120) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `job_fields`
--

INSERT INTO `job_fields` (`id`, `title`) VALUES
(1, 'مشخص نشده'),
(2, 'آب رسانی؛ مدیریت پسماند، فاضلاب و فعالیتهاي تصفیه'),
(3, 'آموزش'),
(4, 'اداره امور عمومی و دفاع؛ تامین اجتماعی اجباري'),
(5, 'استخراج معدن'),
(6, 'اطلاعات و ارتباطات'),
(7, 'تأمین برق، گاز، بخار و تهویه هوا'),
(8, 'تولید صنعتی (ساخت)'),
(9, 'حمل و نقل و انبارداري'),
(10, 'ساختمان'),
(11, 'سایر فعالیتهاي خدماتی'),
(12, 'عمده فروشی و خرده فروشی؛ تعمیر وسایل نقلیه موتوري و موتور سیکلت'),
(13, 'فعالیت هاي خدماتی مربوط به تامین جا و غذا'),
(14, 'فعالیتهاي اداري و خدمات پشتیبانی'),
(15, 'فعالیتهاي املاك و مستغلات'),
(16, 'فعالیتهاي حرفهاي، علمی و فنی'),
(17, 'فعالیتهاي خانوارها به عنوان کارفرما، فعالیتهاي تفکیک ناپذیر تولید کالاها و خدمات\r\nتوسط خانوارهاي معمولی براي خود مصرفی'),
(18, 'فعالیتهاي سازمانها و هیئتهاي برونمرزي'),
(19, 'فعالیتهاي مالی و بیمه'),
(20, 'فعالیتهاي مربوط به سلامت انسان و مددکاري اجتماعی'),
(21, 'کشاورزي، جنگلداري و ماهیگیري'),
(22, 'هنر، سرگرمی و تفریح');

-- --------------------------------------------------------

--
-- Table structure for table `merrige_types`
--

CREATE TABLE `merrige_types` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `merrige_types`
--

INSERT INTO `merrige_types` (`id`, `title`) VALUES
(1, 'مجرد'),
(2, 'متاهل'),
(3, 'مطلقه');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_05_22_070532_uints_table', 1),
(4, '2017_05_23_020055_employees_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `title` varchar(64) COLLATE utf8_persian_ci NOT NULL,
  `type` int(11) NOT NULL,
  `properties` text COLLATE utf8_persian_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `title`, `type`, `properties`, `status`) VALUES
(9, 'تعداد شاغلین آستانه به تفکیک مدرک تحصیلی', 1, '{\r\n  "columns": [\r\n    {\r\n      "title": "مدرک تحصیلی",\r\n      "name": "degree",\r\n      "values": {\r\n        "type": "refrenced",\r\n        "table": "degrees"\r\n      }\r\n    },\r\n    {\r\n      "title": "جنسیت",\r\n      "name": "gender",\r\n      "values": {\r\n        "type": "refrenced",\r\n        "table": "genders"\r\n      }\r\n    }\r\n  ],\r\n  "fields": [\r\n    {\r\n      "title": "مدرک تحصیلی",\r\n      "name": "degree",\r\n      "input": "select",\r\n      "values": {\r\n        "type": "refrenced",\r\n        "table": "degrees"\r\n      },\r\n      "dems": {\r\n        "md": 6,\r\n        "lg": 6,\r\n        "sm": 12,\r\n        "title_md": 4,\r\n        "title_lg": 4\r\n      }\r\n    },\r\n    {\r\n      "title": "رشته تحصیلی",\r\n      "name": "field",\r\n      "input": "autocomplete",\r\n      "values": {\r\n        "query": "study_fields",\r\n        "table": "study_fields"\r\n      },\r\n      "dems": {\r\n        "md": 6,\r\n        "lg": 6,\r\n        "sm": 12,\r\n        "title_md": 4,\r\n        "title_lg": 4\r\n      }\r\n    },\r\n    {\r\n      "title": "جنسیت",\r\n      "name": "gender",\r\n      "input": "select",\r\n      "values": {\r\n        "type": "refrenced",\r\n        "table": "genders"\r\n      },\r\n      "dems": {\r\n        "md": 6,\r\n        "lg": 6,\r\n        "sm": 12,\r\n        "title_md": 4,\r\n        "title_lg": 4\r\n      }\r\n    }\r\n  ],\r\n  "limits": [\r\n    {\r\n      "field": "habitate",\r\n      "operator": "=",\r\n      "value": "2"\r\n    }\r\n  ]\r\n}', 1),
(10, 'لیست شاغلین آستانه به تفکیک مدرک تحصیلی', 2, '{\n  "columns": [\n    {\n      "title": "مدرک تحصیلی",\n      "name": "degree",\n      "values": {\n        "type": "refrenced",\n        "table": "degrees"\n      }\n    },\n    {\n      "title": "جنسیت",\n      "name": "gender",\n      "values": {\n        "type": "refrenced",\n        "table": "genders"\n      }\n    },\n    {\n      "title": "نام",\n      "name": "first_name",\n      "values": {\n        "type": "direct"\n      }\n    },\n    {\n      "title": "نام خانوادگی",\n      "name": "last_name",\n      "values": {\n        "type": "direct"\n      }\n    }\n  ],\n  "fields": [\n    {\n      "title": "مدرک تحصیلی",\n      "name": "degree",\n      "input": "select",\n      "values": {\n        "type": "refrenced",\n        "table": "degrees"\n      },\n      "dems": {\n        "md": 6,\n        "lg": 6,\n        "sm": 12,\n        "title_md": 4,\n        "title_lg": 4\n      }\n    },\n    {\n      "title": "رشته تحصیلی",\n      "name": "field",\n      "input": "autocomplete",\n      "values": {\n        "query": "study_fields",\n        "table": "study_fields"\n      },\n      "dems": {\n        "md": 6,\n        "lg": 6,\n        "sm": 12,\n        "title_md": 4,\n        "title_lg": 4\n      }\n    },\n    {\n      "title": "جنسیت",\n      "name": "gender",\n      "input": "select",\n      "values": {\n        "type": "refrenced",\n        "table": "genders"\n      },\n      "dems": {\n        "md": 6,\n        "lg": 6,\n        "sm": 12,\n        "title_md": 4,\n        "title_lg": 4\n      }\n    }\n  ],\n  "limits": [\n    {\n      "field": "habitate",\n      "operator": "=",\n      "value": "2"\n    }\n  ]\n}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `study_fields`
--

CREATE TABLE `study_fields` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `study_fields`
--

INSERT INTO `study_fields` (`id`, `title`) VALUES
(1, 'کامپیوتر'),
(2, 'حسابداری'),
(3, 'حقوق'),
(4, 'ریاضی'),
(5, 'سینما'),
(6, 'عکاسی'),
(7, 'عمران'),
(8, 'فناوری اطلاعات و IT'),
(9, 'گرافیک'),
(10, 'مدیریت'),
(11, 'معارف'),
(12, 'مکانیک'),
(13, 'موسیقی'),
(14, 'مهندسی شیمی'),
(15, 'هنر‌های تجسمی');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `product` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `manager_title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `manager_gender` int(1) NOT NULL,
  `manager_id_number` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `city` int(11) NOT NULL DEFAULT '0',
  `address` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `cell_phone` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `has_certificate` int(1) NOT NULL,
  `certificate_id` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `certificate_date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `certificate_type` int(11) NOT NULL,
  `has_licence` int(1) NOT NULL,
  `licence_id` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `licence_date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `licence_source` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `user`, `title`, `product`, `manager_title`, `manager_gender`, `manager_id_number`, `city`, `address`, `zip_code`, `phone`, `cell_phone`, `has_certificate`, `certificate_id`, `certificate_date`, `certificate_type`, `has_licence`, `licence_id`, `licence_date`, `licence_source`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'دفتر فروش گلرنگ', 'محصولات بهداشتی', 'محسن یاحقی', 2, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 1, '124738', '1397-11-5', 4, 1, '543422', '1398-10-12', 1, NULL, NULL),
(2, 'admin', 'پخش و تولید آذربایجان', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 1, '1453', '1390-9-2', 4, 0, '###', '###', 0, NULL, NULL),
(3, 'admin', 'گروه صنعتی بادران', 'محصولات بهداشتی', 'محسن سلامت', 2, '۲۶۴۸۴۸۵۵۷۴', 1, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 1, '128594', '1390-1-1', 1, 1, '18374', '1396-5-3', 2, NULL, NULL),
(4, 'admin', 'دفتر فروش گلرنگ', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(5, 'admin', 'آرایشی بهداشتی سلامت', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(6, 'admin', 'ترابری محسن', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(7, 'admin', 'ترابری امینی', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(8, 'admin', 'دفتر فروش گلرنگ', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(12, 'admin', 'صرافی ملکی', 'محصولات بهداشتی', 'امیر عباسی', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(13, 'admin', 'گروه بازرگانی زهره', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(14, 'admin', 'دفتر فروش گلرنگ', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(15, 'admin', 'دفتر فروش گلرنگ', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(16, 'admin', 'دفتر فروش گلرنگ', 'محصولات بهداشتی', 'محسن سلامت', 3, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(17, 'admin', 'دفتر فروش گلرنگ', 'محصولات بهداشتی', 'محسن سلامت', 2, '۲۶۴۸۴۸۵۵۷۴', 0, 'رشت - معلم - خیابان فلاحتی', '۵۳۱۶۵۸۹۳۸۴', '09216720496', '۰۱۳۳۳۲۵۰۲۸۶', 1, '18293', '1390-1-1', 4, 0, '###', '###', 0, NULL, NULL),
(18, 'amir96', 'دفتر بازرگانی حمیدی', 'پوشاک', 'سید علی حمیدی', 2, '2519194857', 0, 'انزلی - خیابان امام - خیابان شهید نبوی - کوچه رامین فر - پلاک ۱۸', '4539498374', '01238477593', '09214857434', 1, '1289283', '1391-4-8', 3, 0, '###', '###', 0, NULL, NULL),
(19, 'admin', 'خانه سبز', 'محصولات خوراکی با سبزیجات و مواد غذایی سبز', 'امیر طوافی', 2, '4529485723', 3, 'خیابان علوی - نرسیده به پاساژ مطهری', '1818532385', '09216720496', '09214857434', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL),
(20, 'admin', 'نمایندگی سونی احسان بخش', 'محصولات خانگی دیجیتالی', 'هانیه شناور', 3, '2519194857', 2, 'انزلی - خیابان امام - خیابان شهید نبوی - کوچه رامین فر - پلاک ۱۸', '4539498374', '09216720496', '09214857434', 0, '###', '###', 1, 0, '###', '###', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `first_name` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `group_code` int(1) NOT NULL,
  `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `cellphone` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `email`, `group_code`, `password`, `phone`, `cellphone`, `remember_token`, `created_at`, `updated_at`) VALUES
(11, 'admin', 'علیرضا', 'دربندی', 'darbandi1996@gmail.com', 1, '$2y$10$kPxae2Tu4uOETxBFbQEDp./Xtqoq8xmdUaecFC5M750IkbcsuyZAq', '01333250286', '09216720496', 'JIRN4EqNRVSybglMwlCmmVIWzO5Zb4MU1SN2Ea85KTKEJ6mjr7zCU7j3maPZ', '2017-06-01 11:20:10', NULL),
(12, 'amir96', 'امیر رضا', 'مرادی', 'amir@gmail.com', 0, '$2y$10$55h6ubA/cdQKE9v2izZDJeuCG0veDJrlwe/fxiYDGuqPyoowJshO6', '092158475847', '01233827475', 'nk53MPHzrrdBAaPHycK99svzrQ0ck02gcExZgmr5Lz0PdiZCo2cNllyTW3ac', '2017-06-01 16:04:12', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `age_bounds`
--
ALTER TABLE `age_bounds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_license_sources`
--
ALTER TABLE `business_license_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificate_types`
--
ALTER TABLE `certificate_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `degrees`
--
ALTER TABLE `degrees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_fields`
--
ALTER TABLE `job_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merrige_types`
--
ALTER TABLE `merrige_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `study_fields`
--
ALTER TABLE `study_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `age_bounds`
--
ALTER TABLE `age_bounds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `business_license_sources`
--
ALTER TABLE `business_license_sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `certificate_types`
--
ALTER TABLE `certificate_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `degrees`
--
ALTER TABLE `degrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `job_fields`
--
ALTER TABLE `job_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `merrige_types`
--
ALTER TABLE `merrige_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `study_fields`
--
ALTER TABLE `study_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
