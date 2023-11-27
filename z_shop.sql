-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 24 2023 г., 12:34
-- Версия сервера: 10.6.7-MariaDB
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `z_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `parent_id`, `title`, `slug`, `created_at`, `updated_at`, `deleted_at`, `editor`) VALUES
(1, 0, 'кат 1', 'kat-1', '2022-08-14 05:01:37', '2022-08-14 05:01:37', NULL, 13),
(2, 1, 'кат 2', 'kat-2', '2022-08-14 10:32:00', '2022-08-14 10:33:24', NULL, 13),
(3, 2, 'кат 3', 'kat-3', '2022-08-14 10:33:57', '2022-08-14 10:33:57', NULL, 13),
(4, 0, 'кат 1 - 2', 'kat-1-2', '2022-08-15 08:10:41', '2022-08-15 08:10:41', NULL, 13),
(5, 0, 'кат 1 - 3', 'kat-1-3', '2022-08-15 08:11:09', '2022-08-17 08:33:54', '2022-08-17 08:33:54', 13),
(6, 0, 'кат 1 - 3', 'kat-1-3_1', '2022-08-15 08:11:25', '2022-08-15 08:11:25', NULL, 13),
(7, 1, 'кат 2-2', 'kat-2-2', '2022-08-15 08:12:30', '2022-08-15 08:12:30', NULL, 13),
(8, 1, 'кат 2-3', 'kat-2-3', '2022-08-15 08:13:02', '2022-08-15 08:13:02', NULL, 13),
(9, 2, 'кат 3-2', 'kat-3-2', '2022-08-15 08:13:41', '2022-08-15 08:13:41', NULL, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `blog_reviews`
--

CREATE TABLE `blog_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mediables`
--

CREATE TABLE `mediables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `media_id` bigint(20) UNSIGNED NOT NULL,
  `mediable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mediable_id` bigint(20) UNSIGNED NOT NULL,
  `placement` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mediables`
--

INSERT INTO `mediables` (`id`, `media_id`, `mediable_type`, `mediable_id`, `placement`) VALUES
(2, 2, 'shopCategory', 1, 0),
(3, 3, 'shopCategory', 1, 0),
(4, 4, 'shopCategory', 1, 3),
(5, 5, 'shopCategory', 2, 2),
(8, 9, 'shopCategory', 1, 2),
(9, 10, 'shopCategory', 1, 2),
(10, 11, 'shopCategory', 1, 2),
(11, 12, 'shopCategory', 1, 1),
(12, 13, 'shopCategory', 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `medias`
--

CREATE TABLE `medias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subobject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `medias`
--

INSERT INTO `medias` (`id`, `title`, `object`, `subobject`, `link`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'sss', 'category', NULL, 'wy03E4gZjqPGppWc34cDuTk7UiNilq2rYv8FcUI2.jpg', NULL, '2022-10-18 06:29:00', '2022-10-18 06:29:00', NULL),
(2, 'sss2', 'category', NULL, 'p2dn1Hf5DghSVMdbB4QlKiI8wOD4PQxytwICC6S9.jpg', NULL, '2022-10-18 06:39:03', '2022-10-18 06:39:03', NULL),
(3, 'sss3 ewrfgwerg werg werg wergwherhwe werhwerhwe hh', 'category', NULL, 'iP5tNsQl2crE3hcjuMdq0G7W7pSCjhoMnxREwTA9.jpg', NULL, '2022-10-18 06:42:42', '2022-10-18 06:42:42', NULL),
(4, 'sss4', 'category', NULL, 'rrtID8kFtuQG2cwovzlnLQqsQVQk5cMNahZ5cMcf.jpg', NULL, '2022-10-18 06:57:36', '2022-10-18 06:57:36', NULL),
(5, 'ddd', 'category', NULL, 'CjqAO0dnxQINxz9dG3ia80VsYOc0U4NaBOJuidzJ.jpg', NULL, '2022-10-19 12:36:27', '2022-10-19 12:36:27', NULL),
(6, 'fff', 'category', NULL, 'hjTDUmqSC8JWzVhuLd8W4t7rbINNEQruhqRSR6kg.jpg', NULL, '2022-10-19 12:53:53', '2022-10-19 12:53:53', NULL),
(7, NULL, 'category', NULL, 'TCLHMH1UPpstHHRWlJFInu3WV0Vmc7OneUJpGV0v.jpg', NULL, '2022-10-19 12:56:03', '2022-10-19 12:56:03', NULL),
(8, 'fff', 'category', NULL, 'XSZNw3cp4WHx06kf1zQydof5a5ylf53Ba3uk3Wuo.jpg', NULL, '2022-10-19 12:56:39', '2022-10-19 12:56:39', NULL),
(9, 'ggg', 'category', NULL, 'VlRFpo114CNez4ygroKc3Qi8tE3iORF7FNHJbLG9.jpg', NULL, '2022-10-19 13:11:57', '2022-10-19 13:11:57', NULL),
(10, 'eee', 'category', NULL, 'O051o1pbqin34a2JUHI9iTBy0NyUYgCk3Gcg7v0o.jpg', NULL, '2022-10-19 13:23:33', '2022-10-19 13:23:33', NULL),
(11, 'aa', 'category', NULL, 'PpUS8X28Z6OTtH3pf6Wmg6IOYjUgXAXH7oeWQL0T.jpg', NULL, '2022-10-19 13:25:05', '2022-10-19 13:25:05', NULL),
(12, 'new', 'category', NULL, 'TypSOVqy3aR6NXC4R5w5kWkPPxBsdVSGKX03F2co.jpg', NULL, '2022-10-20 01:30:52', '2022-10-20 01:30:52', NULL),
(13, 'wwww', 'category', NULL, 'SxDcS86PB3lTEwbAEDijG8LQ1aUf6UXlBU7XEpZu.jpg', NULL, '2022-10-26 13:02:54', '2022-10-26 13:02:54', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_07_07_133810_add_user_role_table', 1),
(6, '2022_07_07_134104_create_settings_table', 1),
(7, '2022_07_07_134454_create_medias_table', 1),
(8, '2022_07_07_183228_create_pages_table', 1),
(9, '2022_07_09_091034_create_texts_table', 1),
(10, '2022_07_09_093105_create_blog_categories_table', 1),
(11, '2022_07_09_093442_create_blog_posts_table', 1),
(12, '2022_07_09_093659_create_blog_reviews_table', 1),
(13, '2022_07_10_043005_create_shop_categories_table', 1),
(14, '2022_07_10_045012_create_shop_products_table', 1),
(15, '2022_07_12_125449_create_shop_prices_table', 1),
(16, '2022_07_12_125637_create_shop_properties_table', 1),
(17, '2022_07_12_125913_create_shop_banners_table', 1),
(18, '2022_07_12_130236_create_shop_customers_table', 1),
(19, '2022_07_13_054450_create_shop_order_items_table', 1),
(20, '2022_07_13_192139_create_shop_orders_table', 1),
(21, '2022_07_13_192352_create_shop_brands_table', 1),
(22, '2022_07_13_193323_create_shop_reviews_table', 1),
(23, '2022_07_13_193502_create_shop_stats_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `slug`, `description`, `setting`, `created_at`, `updated_at`, `deleted_at`, `editor`) VALUES
(1, 'text-types', 'Тип текста в таблице текстов', '[{\"key\":\"1\",\"value\":\"\\u041e\\u0441\\u043d\\u043e\\u0432\\u043d\\u043e\\u0439\"},{\"key\":\"2\",\"value\":\"\\u0410\\u043d\\u043d\\u043e\\u0442\\u0430\\u0446\\u0438\\u044f\"},{\"key\":\"3\",\"value\":\"\\u0420\\u0435\\u043a\\u043b\\u0430\\u043c\\u0430\"}]', NULL, '2022-09-17 01:19:42', NULL, 13),
(2, 'media-placements', 'Типы медиа объектов', '[{\"key\":\"1\",\"value\":\"1-\\u044f \\u043a\\u0430\\u0440\\u0442\\u0438\\u043d\\u043a\\u0430\"},{\"key\":\"2\",\"value\":\"2-\\u044f \\u043a\\u0430\\u0440\\u0442\\u0438\\u043d\\u043a\\u0430\"},{\"key\":\"3\",\"value\":\"\\u0413\\u0430\\u043b\\u0435\\u0440\\u0435\\u044f\"},{\"key\":\"4\",\"value\":\"\\u0412\\u0438\\u0434\\u0435\\u043e\"}]', NULL, '2022-09-30 13:51:15', NULL, 13),
(3, 'set3', 'set3', NULL, NULL, NULL, NULL, 1),
(4, 'set4', 'set4', NULL, NULL, NULL, NULL, 1),
(5, 'set5', 'set5', NULL, NULL, NULL, NULL, 1),
(6, 'set6', 'set6', NULL, NULL, NULL, NULL, 1),
(7, 'set7', 'set7', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_banners`
--

CREATE TABLE `shop_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `placement` tinyint(3) UNSIGNED NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_brands`
--

CREATE TABLE `shop_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_categories`
--

CREATE TABLE `shop_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmpl_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmpl_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `shop_categories`
--

INSERT INTO `shop_categories` (`id`, `parent_id`, `title`, `slug`, `meta_title`, `meta_description`, `tmpl_title`, `tmpl_description`, `created_at`, `updated_at`, `deleted_at`, `editor`) VALUES
(1, 0, 'категория 1', 'cat1', NULL, NULL, NULL, NULL, NULL, '2022-09-14 13:03:17', NULL, 13),
(2, 0, 'kategory 2', 'cat2', NULL, NULL, NULL, NULL, NULL, '2022-09-19 02:11:37', NULL, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_customers`
--

CREATE TABLE `shop_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `name_company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bonuses` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_customer_addresses`
--

CREATE TABLE `shop_customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`full_address`)),
  `inn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_orders`
--

CREATE TABLE `shop_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_method` tinyint(3) UNSIGNED NOT NULL,
  `delivery_cost` decimal(8,2) DEFAULT NULL,
  `payment_method` tinyint(3) UNSIGNED NOT NULL,
  `payment_cost` decimal(8,2) DEFAULT NULL,
  `cost` decimal(8,2) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `volume` decimal(8,2) DEFAULT NULL,
  `bonuses_added` int(10) UNSIGNED DEFAULT NULL,
  `bonuses_deduct` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_order_items`
--

CREATE TABLE `shop_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` decimal(8,2) UNSIGNED NOT NULL,
  `product_quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_prices`
--

CREATE TABLE `shop_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `value` decimal(8,2) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_products`
--

CREATE TABLE `shop_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure` tinyint(3) UNSIGNED DEFAULT NULL,
  `quantity` bigint(20) UNSIGNED DEFAULT NULL,
  `reserved` bigint(20) UNSIGNED DEFAULT NULL,
  `dimensions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_properties`
--

CREATE TABLE `shop_properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `filter` tinyint(1) NOT NULL,
  `variants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`variants`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_property_values`
--

CREATE TABLE `shop_property_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_reviews`
--

CREATE TABLE `shop_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_stats`
--

CREATE TABLE `shop_stats` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `viewed` int(10) UNSIGNED NOT NULL,
  `purchased` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `textables`
--

CREATE TABLE `textables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text_id` bigint(20) UNSIGNED NOT NULL,
  `textable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `textable_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `textables`
--

INSERT INTO `textables` (`id`, `text_id`, `textable_type`, `textable_id`) VALUES
(3, 3, 'shopCategory', 1),
(4, 4, 'shopCategory', 1),
(5, 5, 'shopCategory', 1),
(8, 7, 'shopCategory', 2),
(9, 5, 'shopCategory', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `texts`
--

CREATE TABLE `texts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `editor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `texts`
--

INSERT INTO `texts` (`id`, `title`, `content`, `type`, `created_at`, `updated_at`, `deleted_at`, `editor`) VALUES
(1, 'text 1', '<p>text 1&nbsp;text 1&nbsp;text 1<br></p>', 1, '2022-09-14 13:00:24', '2022-09-14 13:00:24', NULL, 13),
(2, 'text 1', '<p>text 1&nbsp;text 1&nbsp;text 1<br></p>', 1, '2022-09-14 13:02:35', '2022-09-14 13:02:35', NULL, 13),
(3, 'text 1', '<p>text 1&nbsp;text 1&nbsp;text 1<br></p>', 1, '2022-09-14 13:03:17', '2022-09-14 13:03:17', NULL, 13),
(4, 'text 2', '<p>text 2&nbsp;<span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">text 2&nbsp;</span><br></p>', 2, '2022-09-14 13:04:18', '2022-09-14 13:04:18', NULL, 13),
(5, 'text 45678', '<p>sadvasdfvasd</p>', 3, '2022-09-19 02:09:04', '2022-09-19 02:09:04', NULL, 13),
(6, 'bez modeli', '<p>SDvSDvsdv</p>', 3, '2022-09-19 02:10:08', '2022-09-19 02:10:08', NULL, 13),
(7, 'text аннотация', '<p>ываипываптваптваа</p>', 2, '2022-09-19 02:12:55', '2022-09-19 02:12:55', NULL, 13),
(8, 'new', '<p>new</p>', 1, '2022-09-23 12:17:03', '2022-09-23 12:17:03', NULL, 13),
(9, 'new', '<p>new</p>', 1, '2022-09-23 12:19:27', '2022-09-23 12:19:27', NULL, 13),
(10, 'new', '<p>new</p>', 1, '2022-09-23 12:26:40', '2022-09-23 12:26:40', NULL, 13),
(11, 'new', '<p>new</p>', 1, '2022-09-23 12:26:52', '2022-09-23 12:26:52', NULL, 13),
(12, 'new', '<p>new</p>', 1, '2022-09-23 12:29:37', '2022-09-23 12:29:37', NULL, 13),
(13, 'dd', '<p>dd</p>', 1, '2022-09-23 12:29:58', '2022-09-23 12:29:58', NULL, 13),
(14, 'new', '<p>new</p>', 1, '2022-09-23 12:31:00', '2022-09-23 12:31:00', NULL, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(3) UNSIGNED DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(13, 'yurzig', 'ziganshin@bk.ru', NULL, '$2y$10$UnOaCzQCyVrtFJ2xS9/BHO2KQ.c5AiFyo.bHk9YNEDkdmccmn/uca', 1, NULL, '2022-07-20 11:35:56', '2022-07-20 11:35:56');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Индексы таблицы `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_category_id_foreign` (`category_id`),
  ADD KEY `blog_posts_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `blog_reviews`
--
ALTER TABLE `blog_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_reviews_user_id_foreign` (`user_id`),
  ADD KEY `blog_reviews_post_id_index` (`post_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `mediables`
--
ALTER TABLE `mediables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mediable_mediable_type_mediable_id_index` (`mediable_type`,`mediable_id`) USING BTREE,
  ADD KEY `mediable_media_id_index` (`media_id`) USING BTREE;

--
-- Индексы таблицы `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shop_banners`
--
ALTER TABLE `shop_banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_banners_product_id_index` (`product_id`);

--
-- Индексы таблицы `shop_brands`
--
ALTER TABLE `shop_brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shop_brands_slug_unique` (`slug`);

--
-- Индексы таблицы `shop_categories`
--
ALTER TABLE `shop_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shop_categories_slug_unique` (`slug`);

--
-- Индексы таблицы `shop_customers`
--
ALTER TABLE `shop_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_customers_user_id_index` (`user_id`);

--
-- Индексы таблицы `shop_customer_addresses`
--
ALTER TABLE `shop_customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_customer_addresses_customer_id_index` (`customer_id`);

--
-- Индексы таблицы `shop_orders`
--
ALTER TABLE `shop_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_orders_customer_id_index` (`customer_id`);

--
-- Индексы таблицы `shop_order_items`
--
ALTER TABLE `shop_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_order_items_product_id_foreign` (`product_id`),
  ADD KEY `shop_order_items_order_id_index` (`order_id`);

--
-- Индексы таблицы `shop_prices`
--
ALTER TABLE `shop_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_prices_product_id_foreign` (`product_id`),
  ADD KEY `shop_prices_type_index` (`type`),
  ADD KEY `shop_prices_value_index` (`value`);

--
-- Индексы таблицы `shop_products`
--
ALTER TABLE `shop_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shop_products_slug_unique` (`slug`),
  ADD KEY `shop_products_category_id_foreign` (`category_id`),
  ADD KEY `shop_products_rating_index` (`rating`);

--
-- Индексы таблицы `shop_properties`
--
ALTER TABLE `shop_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_properties_category_id_index` (`category_id`);

--
-- Индексы таблицы `shop_property_values`
--
ALTER TABLE `shop_property_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_property_values_product_id_index` (`product_id`),
  ADD KEY `shop_property_values_property_id_index` (`property_id`);

--
-- Индексы таблицы `shop_reviews`
--
ALTER TABLE `shop_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_reviews_user_id_foreign` (`user_id`),
  ADD KEY `shop_reviews_product_id_index` (`product_id`);

--
-- Индексы таблицы `shop_stats`
--
ALTER TABLE `shop_stats`
  ADD KEY `shop_stats_product_id_index` (`product_id`),
  ADD KEY `shop_stats_category_id_index` (`category_id`),
  ADD KEY `shop_stats_viewed_index` (`viewed`),
  ADD KEY `shop_stats_purchased_index` (`purchased`),
  ADD KEY `shop_stats_rating_index` (`rating`);

--
-- Индексы таблицы `textables`
--
ALTER TABLE `textables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `text_model_text_model_type_text_model_id_index` (`textable_type`,`textable_id`),
  ADD KEY `text_model_text_id_index` (`text_id`);

--
-- Индексы таблицы `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `blog_reviews`
--
ALTER TABLE `blog_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mediables`
--
ALTER TABLE `mediables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `medias`
--
ALTER TABLE `medias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `shop_banners`
--
ALTER TABLE `shop_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_brands`
--
ALTER TABLE `shop_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_categories`
--
ALTER TABLE `shop_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `shop_customers`
--
ALTER TABLE `shop_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_customer_addresses`
--
ALTER TABLE `shop_customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_orders`
--
ALTER TABLE `shop_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_order_items`
--
ALTER TABLE `shop_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_prices`
--
ALTER TABLE `shop_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_products`
--
ALTER TABLE `shop_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_properties`
--
ALTER TABLE `shop_properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_property_values`
--
ALTER TABLE `shop_property_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shop_reviews`
--
ALTER TABLE `shop_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `textables`
--
ALTER TABLE `textables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `texts`
--
ALTER TABLE `texts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `blog_reviews`
--
ALTER TABLE `blog_reviews`
  ADD CONSTRAINT `blog_reviews_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `shop_banners`
--
ALTER TABLE `shop_banners`
  ADD CONSTRAINT `shop_banners_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `shop_products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_customers`
--
ALTER TABLE `shop_customers`
  ADD CONSTRAINT `shop_customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_customer_addresses`
--
ALTER TABLE `shop_customer_addresses`
  ADD CONSTRAINT `shop_customer_addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `shop_customers` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_orders`
--
ALTER TABLE `shop_orders`
  ADD CONSTRAINT `shop_orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `shop_customers` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_order_items`
--
ALTER TABLE `shop_order_items`
  ADD CONSTRAINT `shop_order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `shop_products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_prices`
--
ALTER TABLE `shop_prices`
  ADD CONSTRAINT `shop_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `shop_products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_products`
--
ALTER TABLE `shop_products`
  ADD CONSTRAINT `shop_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `shop_categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `shop_properties`
--
ALTER TABLE `shop_properties`
  ADD CONSTRAINT `shop_properties_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `shop_categories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_property_values`
--
ALTER TABLE `shop_property_values`
  ADD CONSTRAINT `shop_property_values_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `shop_products` (`id`),
  ADD CONSTRAINT `shop_property_values_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `shop_properties` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `shop_reviews`
--
ALTER TABLE `shop_reviews`
  ADD CONSTRAINT `shop_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `shop_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shop_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `shop_stats`
--
ALTER TABLE `shop_stats`
  ADD CONSTRAINT `shop_stats_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `shop_categories` (`id`),
  ADD CONSTRAINT `shop_stats_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `shop_products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `textables`
--
ALTER TABLE `textables`
  ADD CONSTRAINT `text_model_text_id_foreign` FOREIGN KEY (`text_id`) REFERENCES `texts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
