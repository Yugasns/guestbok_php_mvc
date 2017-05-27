-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 02 2017 г., 15:55
-- Версия сервера: 5.5.53-0ubuntu0.12.04.1
-- Версия PHP: 5.4.45-4+deprecated+dontuse+deb.sury.org~precise+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dshtolin_sitetest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `gb_comments`
--

CREATE TABLE IF NOT EXISTS `gb_comments` (
  `id` int(11) NOT NULL,
  `messid` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `gb_comments`
--

INSERT INTO `gb_comments` (`id`, `messid`, `name`, `comment`, `date`) VALUES
(29, 118, 'eee', 'ee', '2017-01-10 11:34:39'),
(30, 118, 'eee', 'ee', '2017-01-10 11:34:45');

-- --------------------------------------------------------

--
-- Структура таблицы `gb_message`
--

CREATE TABLE IF NOT EXISTS `gb_message` (
  `id` int(11) NOT NULL,
  `name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `gb_comments`
--
ALTER TABLE `gb_comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gb_message`
--
ALTER TABLE `gb_message`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `gb_comments`
--
ALTER TABLE `gb_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT для таблицы `gb_message`
--
ALTER TABLE `gb_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=133;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
