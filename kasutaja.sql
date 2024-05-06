-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: d123179.mysql.zonevs.eu
-- Время создания: Май 06 2024 г., 09:11
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
-- Структура таблицы `kasutaja`
--

CREATE TABLE `kasutaja` (
  `id` int(11) NOT NULL,
  `kasutaja` varchar(30) DEFAULT NULL,
  `parool` varchar(100) DEFAULT NULL,
  `onAdmin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `kasutaja`
--

INSERT INTO `kasutaja` (`id`, `kasutaja`, `parool`, `onAdmin`) VALUES
(1, 'admin', 'su6FF4/MgjUAk', 1),
(2, 'kasutaja', 'suOCEedRV0wCc', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `kasutaja`
--
ALTER TABLE `kasutaja`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kasutaja` (`kasutaja`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `kasutaja`
--
ALTER TABLE `kasutaja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
