    -- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: d123179.mysql.zonevs.eu
-- Время создания: Май 06 2024 г., 09:13
-- Версия сервера: 10.4.32-MariaDB-log
-- Версия PHP: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `d123179_andmebaas`
--

-- --------------------------------------------------------

--
-- Структура таблицы `veebipood`
--

CREATE TABLE `veebipood` (
  `vebipood_id` int(11) NOT NULL,
  `veebipoodi_toote_nimetus` varchar(30) DEFAULT NULL,
  `veebipoodi_toote_hind` text DEFAULT NULL,
  `veebipoodi_toote_kogus` int(11) DEFAULT NULL,
  `veebipoodi_toote_kategooria` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `veebipood`
--

INSERT INTO `veebipood` (`vebipood_id`, `veebipoodi_toote_nimetus`, `veebipoodi_toote_hind`, `veebipoodi_toote_kogus`, `veebipoodi_toote_kategooria`) VALUES
(1, 'Fanta', '1', 54, 'Joogid'),
(2, 'Kana', '2', 25, 'Lihatooted'),
(5, 'Leib', '1', 123, 'Teraviljatooted');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `veebipood`
--
ALTER TABLE `veebipood`
  ADD PRIMARY KEY (`vebipood_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `veebipood`
--
ALTER TABLE `veebipood`
  MODIFY `vebipood_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
