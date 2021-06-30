-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 30 2021 г., 16:22
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `title` char(200) NOT NULL,
  `alias` char(255) NOT NULL,
  `dateadd` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `title`, `alias`, `dateadd`) VALUES
(1, 'Lexus', 'lexus', '2021-06-29 14:18:08'),
(2, 'Toyota', 'toyota', '2021-06-29 14:18:08');

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `engine_id` int(11) NOT NULL,
  `drive_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `model_id`, `engine_id`, `drive_id`) VALUES
(3, 5, 1, 1),
(4, 5, 1, 2),
(5, 5, 2, 1),
(6, 5, 2, 2),
(7, 5, 3, 1),
(8, 5, 3, 2),
(9, 6, 1, 1),
(10, 6, 1, 2),
(11, 6, 2, 1),
(12, 6, 2, 2),
(13, 6, 3, 1),
(14, 6, 3, 2),
(15, 3, 1, 1),
(16, 3, 1, 2),
(17, 3, 2, 1),
(18, 3, 2, 2),
(19, 3, 3, 1),
(20, 3, 3, 2),
(21, 4, 1, 1),
(22, 4, 1, 2),
(23, 4, 2, 1),
(24, 4, 2, 2),
(25, 4, 3, 1),
(26, 4, 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `drives`
--

CREATE TABLE `drives` (
  `id` int(11) NOT NULL,
  `title` char(200) NOT NULL,
  `alias` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `drives`
--

INSERT INTO `drives` (`id`, `title`, `alias`) VALUES
(1, 'Полный', 'polnyi'),
(2, 'Передний', 'perednii');

-- --------------------------------------------------------

--
-- Структура таблицы `engines`
--

CREATE TABLE `engines` (
  `id` int(11) NOT NULL,
  `title` char(200) NOT NULL,
  `alias` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `engines`
--

INSERT INTO `engines` (`id`, `title`, `alias`) VALUES
(1, 'Бензин', 'benzin'),
(2, 'Дизель', 'dizel'),
(3, 'Гибрид', 'gibrid');

-- --------------------------------------------------------

--
-- Структура таблицы `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT 0,
  `title` char(200) NOT NULL,
  `alias` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `models`
--

INSERT INTO `models` (`id`, `brand_id`, `title`, `alias`) VALUES
(3, 1, 'ES', 'es'),
(4, 1, 'GX', 'gx'),
(5, 2, 'Camry', 'camry'),
(6, 2, 'Corolla', 'corolla'),
(7, 1, 'Lexus', 'lexus'),
(8, 2, 'Toyota', 'toyota');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_engine` (`engine_id`),
  ADD KEY `car_drive` (`drive_id`),
  ADD KEY `car_model` (`model_id`);

--
-- Индексы таблицы `drives`
--
ALTER TABLE `drives`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `engines`
--
ALTER TABLE `engines`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_model` (`brand_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `drives`
--
ALTER TABLE `drives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `engines`
--
ALTER TABLE `engines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `car_drive` FOREIGN KEY (`drive_id`) REFERENCES `drives` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `car_engine` FOREIGN KEY (`engine_id`) REFERENCES `engines` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `car_model` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `brand_model` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
