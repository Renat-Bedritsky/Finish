-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 18 2021 г., 13:34
-- Версия сервера: 10.4.17-MariaDB
-- Версия PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `marketv1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- ССЫЛКИ ТАБЛИЦЫ `categories`:
--

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `code`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Мобильные телефоны', 'mobile', 'В это разделе вы найдёте самые популярные мобильные телефоны по отличным ценам!', '/public/images/foto_products/mobile.jpg', '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(2, 'Портативная техника', 'portable', 'Раздел с портативной техникой', '/public/images/foto_products/portable.jpg', '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(3, 'Бытовая техника', 'appliances', 'Раздел с бытовой техникой', '/public/images/foto_products/appliance.jpg', '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(4, 'Другое', 'other', 'Разная техника', '/public/images/foto_products/other.jpg', '2021-06-24 14:25:00', '2021-06-24 14:25:00');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `product_code` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ССЫЛКИ ТАБЛИЦЫ `comments`:
--

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `author_id`, `product_code`, `content`, `date`) VALUES
(1, 5, 'iphone_12_pro_max_128gb', 'Нормальный телефон!', '2021-07-03 05:23:55'),
(6, 1, 'gopro', 'Эй. Это моя камера.', '2021-07-23 16:43:24'),
(9, 1, 'bosch', 'gchggh', '2021-08-28 15:07:54'),
(12, 1, 'iphone_x_64', 'Hi, bro!', '2021-11-15 15:28:27'),
(13, 1, 'iphone_x_64', 'Hii', '2021-11-15 16:01:44'),
(14, 1, 'iphone_12_pro_max_128gb', 'Hello', '2021-11-16 16:06:43');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  `email` text NOT NULL,
  `operator` text NOT NULL,
  `products` longtext NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ССЫЛКИ ТАБЛИЦЫ `orders`:
--

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `phone`, `email`, `operator`, `products`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Ivan', '+375291234567', 'Ival@gmail.com', 'secret', '{\"iphone_12_pro_max_128gb\":1}', 'done', '2021-11-16 23:10:41', '2021-11-17 03:48:14'),
(2, 2, 'Sasha', '+375291234567', 'Ivan@mail.com', 'secret', '{\"iphone_12_pro_max_128gb\":1}', 'canceled', '2021-11-16 23:17:50', '2021-11-17 03:50:30'),
(3, 5, 'Roman', '+375293657893', 'runa@tin.by', '', '{\"iphone_12_pro_max_128gb\":2,\"samsung_galaxy_j6\":1,\"bosch\":1,\"moulinex\":1,\"haider\":1,\"delongi\":2}', 'get', '2021-11-17 03:10:52', '2021-11-17 03:10:52');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_code` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- ССЫЛКИ ТАБЛИЦЫ `products`:
--

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_code`, `author_id`, `name`, `code`, `description`, `image`, `price`, `created_at`, `updated_at`) VALUES
(1, 'mobile', 1, 'iPhone X 64GB', 'iphone_x_64', 'Отличный продвинутый телефон с памятью на 64 gb', 'iphone_x.jpg', 2400, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(2, 'mobile', 1, 'iPhone X 256GB', 'iphone_x_256', 'Отличный продвинутый телефон с памятью на 256 gb', 'iphone_x_silver.jpg', 3000, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(3, 'mobile', 1, 'HTC One S', 'htc_one_s', 'Зачем платить за лишнее? Легендарный HTC One S', 'htc_one_s.png', 410, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(5, 'portable', 1, 'Наушники Beats Audio', 'beats_audio', 'Отличный звук от Dr. Dre', 'beats.jpg', 670, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(6, 'portable', 1, 'Камера GoPro', 'gopro', 'Снимай самые яркие моменты с помощью этой камеры', 'gopro.jpg', 400, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(7, 'portable', 1, 'Камера Panasonic HC-V770', 'panasonic_hc-v770', 'Для серьёзной видео съемки нужна серьёзная камера. Panasonic HC-V770 для этих целей лучший выбор!', 'video_panasonic.jpg', 930, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(8, 'appliances', 1, 'Кофемашина DeLongi', 'delongi', 'Хорошее утро начинается с хорошего кофе!', 'delongi.jpg', 840, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(9, 'appliances', 1, 'Холодильник Haier', 'haider', 'Для большой семьи большой холодильник!', 'haier.jpg', 1340, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(10, 'appliances', 1, 'Блендер Moulinex', 'moulinex', 'Для самых смелых идей', 'moulinex.jpg', 140, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(11, 'appliances', 1, 'Мясорубка Bosch', 'bosch', 'Любите домашние котлеты? Вам определенно стоит посмотреть на эту мясорубку!', 'bosch.jpg', 310, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(12, 'mobile', 1, 'Samsung Galaxy J6', 'samsung_galaxy_j6', 'Современный телефон начального уровня', 'samsung_j6.jpg', 400, '2021-06-24 14:25:00', '2021-06-24 14:25:00'),
(13, 'mobile', 1, 'iPhone 12 Pro Max 128GB', 'iphone_12_pro_max_128gb', 'графитовый', 'iphone_12.jpeg', 3340, '2021-07-01 18:00:06', '2021-07-01 18:00:06');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL,
  `basket` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`basket`)),
  `position` char(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ССЫЛКИ ТАБЛИЦЫ `users`:
--

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `foto`, `basket`, `position`, `date`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Desert.jpg', '{\"beats_audio\":5,\"moulinex\":3,\"iphone_x_256\":1,\"gopro\":3,\"iphone_x_64\":2}', 'administrator', '2021-06-05 00:00:00'),
(2, 'Alex', 'e10adc3949ba59abbe56e057f20f883e', 'start-foto.png', '{\"iphone_12_pro_max_128gb\":1}', 'moderator', '2021-06-05 01:00:00'),
(3, 'Peter', 'a8698009bce6d1b8c2128eddefc25aad', 'start-foto.png', '{\"iphone_12_pro_max_128gb\":1,\"panasonic_hc-v770\":2,\"delongi\":2,\"haider\":2}', 'moderator', '2021-06-26 18:08:53'),
(4, 'Test', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'start-foto.png', '{\"iphone_12_pro_max_128gb\":5}', 'user', '2021-06-27 22:04:24'),
(5, 'secret', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'start-foto.png', '{\"iphone_12_pro_max_128gb\":2,\"samsung_galaxy_j6\":1,\"bosch\":1,\"moulinex\":1,\"haider\":1,\"delongi\":2}', 'operator', '2021-06-27 22:25:56'),
(6, 'Вася', 'a8698009bce6d1b8c2128eddefc25aad', 'start-foto.png', '[]', 'user', '2021-07-03 07:43:08'),
(7, 'Elis', 'e10adc3949ba59abbe56e057f20f883e', 'start-foto.png', '{\"beats_audio\":2,\"iphone_12_pro_max_128gb\":1}', 'banned', '2021-11-15 20:17:52');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
