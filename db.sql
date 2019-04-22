-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 31 2019 г., 17:23
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bots`
--

CREATE TABLE IF NOT EXISTS `bots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `skill` int(11) NOT NULL,
  `health` int(11) NOT NULL,
  `attacked` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `bots_crystal`
--

CREATE TABLE IF NOT EXISTS `bots_crystal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `skill` int(11) NOT NULL,
  `health` int(11) NOT NULL,
  `attacked` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `bots_gold`
--

CREATE TABLE IF NOT EXISTS `bots_gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `skill` int(11) NOT NULL,
  `health` int(11) NOT NULL,
  `attacked` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `gameset`
--

CREATE TABLE IF NOT EXISTS `gameset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `training_cost` int(32) NOT NULL,
  `bot_silver` int(11) NOT NULL,
  `bot_crystal_silver` int(11) NOT NULL,
  `bot_crystal_crystal` int(11) NOT NULL,
  `bot_gold_silver` int(11) NOT NULL,
  `bot_gold_gold` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `gameset`
--

INSERT INTO `gameset` (`id`, `training_cost`, `bot_silver`, `bot_crystal_silver`, `bot_crystal_crystal`, `bot_gold_silver`, `bot_gold_gold`) VALUES
(1, 100, 200, 400, 1, 800, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `journal`
--

CREATE TABLE IF NOT EXISTS `journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  `read` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `key` text NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `date_reg` int(11) NOT NULL,
  `date_last_entry` int(11) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `status` varchar(9) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `lvl` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `needexp` int(11) NOT NULL,
  `silver` int(11) NOT NULL,
  `silverplus` int(11) NOT NULL,
  `allsilver` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `crystal` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  `hpregen` int(11) NOT NULL,
  `hpregen_time` int(11) NOT NULL,
  `allhp` int(11) NOT NULL,
  `battles` int(11) NOT NULL,
  `allbattles` int(11) NOT NULL,
  `battle_regen_time` int(11) NOT NULL,
  `battle_cost` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `skill` int(11) NOT NULL,
  `health` int(11) NOT NULL,
  `power_bonus` int(11) NOT NULL,
  `defense_bonus` int(11) NOT NULL,
  `speed_bonus` int(11) NOT NULL,
  `skill_bonus` int(11) NOT NULL,
  `health_bonus` int(11) NOT NULL,
  `fame` int(11) NOT NULL,
  `wins` int(11) NOT NULL,
  `loses` int(11) NOT NULL,
  `silverstole` int(11) NOT NULL,
  `silverlost` int(11) NOT NULL,
  `crystalstole` int(11) NOT NULL,
  `crystallost` int(11) NOT NULL,
  `clan` varchar(100) NOT NULL,
  `walk_minutes` int(11) NOT NULL,
  `karma` int(11) NOT NULL,
  `onoff` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
