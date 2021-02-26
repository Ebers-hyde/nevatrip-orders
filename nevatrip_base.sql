-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 26 2021 г., 12:14
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
CREATE DATABASE IF NOT EXISTS `nevatrip_base` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nevatrip_base`;

-- --------------------------------------------------------

--
-- Структура таблицы `bought_tickets`
--

CREATE TABLE `bought_tickets` (
  `ticket_id` mediumint(5) UNSIGNED ZEROFILL NOT NULL,
  `order_id` smallint(4) UNSIGNED ZEROFILL NOT NULL,
  `ticket_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bought_tickets`
--

INSERT INTO `bought_tickets` (`ticket_id`, `order_id`, `ticket_type`, `barcode`) VALUES
(00022, 0108, 'Взрослый', '004-6000'),
(00023, 0108, 'Взрослый', '004-4909'),
(00024, 0108, 'Детский', '004-1953'),
(00025, 0108, 'Детский', '004-6983'),
(00026, 0108, 'Детский', '004-5360'),
(00027, 0108, 'Групповой', '004-6305'),
(00028, 0108, 'Льготный', '004-2110'),
(00029, 0108, 'Льготный', '004-6592'),
(00030, 0108, 'Льготный', '004-6967');

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `event_id` smallint(3) UNSIGNED ZEROFILL NOT NULL,
  `event_date` datetime NOT NULL,
  `event_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`event_id`, `event_date`, `event_name`) VALUES
(001, '2021-08-21 13:00:00', 'Событие ААА'),
(002, '2021-07-29 18:00:00', 'Событие BBB'),
(003, '2021-08-15 17:00:00', 'Событие CCC'),
(004, '2021-08-29 19:00:00', 'Событие DDD');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` smallint(4) UNSIGNED ZEROFILL NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` smallint(3) UNSIGNED ZEROFILL NOT NULL,
  `tickets_amount` tinyint(3) NOT NULL,
  `sum` mediumint(8) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `event_id`, `tickets_amount`, `sum`, `created`) VALUES
(0108, 4, 004, 9, 10350, '2021-02-26 00:09:21');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `event_id` smallint(3) UNSIGNED ZEROFILL NOT NULL,
  `ticket_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_price` smallint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`event_id`, `ticket_type`, `ticket_price`) VALUES
(001, 'Взрослый', 700),
(001, 'Детский', 450),
(002, 'Взрослый', 1000),
(002, 'Детский', 800),
(002, 'Льготный', 700),
(003, 'Взрослый', 900),
(003, 'Групповой', 2500),
(004, 'Взрослый', 1150),
(004, 'Детский', 750),
(004, 'Групповой', 2950),
(004, 'Льготный', 950);

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
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`, `full_name`) VALUES
(4, 'cerverus', 'e5d9dee0892c9f474a174d3bfffb7810', 'Соколов Пётр Сергеевич'),
(5, 'verbalizer', '9b70d6dbfb1457d05e4e2c2fbb42d7db', 'Васильев Иван Сергеевич');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bought_tickets`
--
ALTER TABLE `bought_tickets`
  ADD PRIMARY KEY (`ticket_id`);

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
  ADD KEY `IX_EventID` (`event_id`),
  ADD KEY `IX_TicketType` (`ticket_type`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bought_tickets`
--
ALTER TABLE `bought_tickets`
  MODIFY `ticket_id` mediumint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `event_id` smallint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` smallint(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
