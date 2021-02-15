-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 15 2021 г., 16:36
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `nevatrip_base`
--

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `event_id` smallint(3) UNSIGNED ZEROFILL NOT NULL,
  `event_date` datetime NOT NULL,
  `event_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tickets_regular_available` tinyint(1) NOT NULL,
  `tickets_regular_price` smallint(10) NOT NULL,
  `tickets_kid_available` tinyint(1) NOT NULL,
  `tickets_kid_price` smallint(10) NOT NULL,
  `tickets_group_available` tinyint(1) NOT NULL,
  `tickets_group_price` smallint(10) NOT NULL,
  `tickets_soft_available` tinyint(1) NOT NULL,
  `tickets_soft_price` smallint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`event_id`, `event_date`, `event_name`, `tickets_regular_available`, `tickets_regular_price`, `tickets_kid_available`, `tickets_kid_price`, `tickets_group_available`, `tickets_group_price`, `tickets_soft_available`, `tickets_soft_price`) VALUES
(001, '2021-08-21 13:00:00', 'Событие ААА', 1, 700, 1, 450, 0, 0, 0, 0),
(002, '2021-07-29 18:00:00', 'Событие BBB', 1, 1000, 1, 800, 0, 0, 1, 700),
(003, '2021-08-15 17:00:00', 'Событие CCC', 1, 900, 0, 0, 1, 2500, 0, 0),
(004, '2021-08-29 19:00:00', 'Событие DDD', 1, 1150, 1, 750, 1, 2950, 1, 950);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` smallint(4) UNSIGNED ZEROFILL NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` smallint(3) UNSIGNED ZEROFILL NOT NULL,
  `tickets_regular_amount` tinyint(3) DEFAULT NULL,
  `tickets_kids_amount` tinyint(3) DEFAULT NULL,
  `tickets_group_amount` tinyint(3) DEFAULT NULL,
  `tickets_soft_amount` tinyint(3) DEFAULT NULL,
  `sum` mediumint(8) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` mediumint(5) UNSIGNED ZEROFILL NOT NULL,
  `order_id` smallint(4) UNSIGNED ZEROFILL NOT NULL,
  `ticket_type` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` smallint(6) NOT NULL,
  `barcode` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `event_id` smallint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` smallint(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` mediumint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
