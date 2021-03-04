-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 04 2021 г., 12:06
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
(00081, 0120, 'Взрослый', '003-4768'),
(00082, 0120, 'Групповой', '003-2524'),
(00083, 0120, 'Групповой', '003-9964'),
(00084, 0121, 'Взрослый', '002-8412'),
(00085, 0121, 'Детский', '002-4759'),
(00086, 0121, 'Детский', '002-9785'),
(00087, 0121, 'Льготный', '002-3214'),
(00088, 0121, 'Льготный', '002-7658'),
(00089, 0121, 'Льготный', '002-6113');

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
(0120, 4, 003, 3, 5900, '2021-03-04 11:37:49'),
(0121, 4, 002, 6, 4700, '2021-03-04 12:06:14');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `type_id` smallint(4) NOT NULL,
  `event_id` smallint(3) UNSIGNED ZEROFILL NOT NULL,
  `ticket_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_price` smallint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`type_id`, `event_id`, `ticket_type`, `ticket_price`) VALUES
(1, 001, 'Взрослый', 700),
(2, 001, 'Детский', 450),
(3, 002, 'Взрослый', 1000),
(4, 002, 'Детский', 800),
(5, 002, 'Льготный', 700),
(6, 003, 'Взрослый', 900),
(7, 003, 'Групповой', 2500),
(8, 004, 'Взрослый', 1150),
(9, 004, 'Детский', 750),
(10, 004, 'Групповой', 2950),
(11, 004, 'Льготный', 950);

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
(4, 'cerverus', 'e5d9dee0892c9f474a174d3bfffb7810', 'Соколов Пётр Сергеевич');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bought_tickets`
--
ALTER TABLE `bought_tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `event_id` (`event_id`);

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
  MODIFY `ticket_id` mediumint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `event_id` smallint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` smallint(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `type_id` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bought_tickets`
--
ALTER TABLE `bought_tickets`
  ADD CONSTRAINT `bought_tickets_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
