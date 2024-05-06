-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: d123179.mysql.zonevs.eu
-- Время создания: Май 06 2024 г., 09:14
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
-- Структура таблицы `ostukorv`
--

CREATE TABLE `ostukorv` (
  `ostukorv_id` int(11) NOT NULL,
  `vebipood_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ostukorv`
--
ALTER TABLE `ostukorv`
  ADD PRIMARY KEY (`ostukorv_id`),
  ADD KEY `vebipood_id` (`vebipood_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ostukorv`
--
ALTER TABLE `ostukorv`
  MODIFY `ostukorv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ostukorv`
--
ALTER TABLE `ostukorv`
  ADD CONSTRAINT `ostukorv_ibfk_1` FOREIGN KEY (`vebipood_id`) REFERENCES `veebipood` (`vebipood_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
