-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 25 2023 г., 09:08
-- Версия сервера: 10.11.4-MariaDB-1:10.11.4+maria~ubu2004
-- Версия PHP: 8.1.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pankrushin_med`
--

-- --------------------------------------------------------

--
-- Структура таблицы `anam`
--

CREATE TABLE `anam` (
  `id_anamn` int(11) NOT NULL,
  `nurse_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `sympthoms` text DEFAULT NULL,
  `date_anamn` datetime DEFAULT current_timestamp(),
  `dop_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `anam`
--

INSERT INTO `anam` (`id_anamn`, `nurse_id`, `child_id`, `height`, `weight`, `sympthoms`, `date_anamn`, `dop_info`) VALUES
(4, 1, 1, 70, 6, 'Жалоб нет', '2023-12-23 22:12:03', 'Плановый осмотр');

--
-- Триггеры `anam`
--
DELIMITER $$
CREATE TRIGGER `last_anamn_input` AFTER INSERT ON `anam` FOR EACH ROW begin

	declare `ch_id` int; 
    
    select `child_id` into `ch_id` from `anam`
    where `id_anamn` = new.`id_anamn`;
    
    update `child` set `last_anamn` = new.`id_anamn`
    where `id_child` = `ch_id`;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `child`
--

CREATE TABLE `child` (
  `id_child` int(11) NOT NULL,
  `fio` varchar(64) NOT NULL,
  `photo` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `diag_ids` text DEFAULT NULL,
  `birth_date` date NOT NULL,
  `birth_passport` varchar(16) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `last_anamn` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `child`
--

INSERT INTO `child` (`id_child`, `fio`, `photo`, `parent_id`, `diag_ids`, `birth_date`, `birth_passport`, `address`, `last_anamn`) VALUES
(1, 'fio', 'photolink', 1, '123, 456', '2023-12-19', 'test123', 'address', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `diag`
--

CREATE TABLE `diag` (
  `id_diag` int(11) NOT NULL,
  `diag` varchar(128) DEFAULT NULL,
  `date_diag` datetime DEFAULT NULL,
  `recommends` varchar(256) DEFAULT NULL,
  `anamn_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `diag`
--

INSERT INTO `diag` (`id_diag`, `diag`, `date_diag`, `recommends`, `anamn_id`) VALUES
(1, 'Здоров', NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `nurse`
--

CREATE TABLE `nurse` (
  `id_nurse` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` text NOT NULL,
  `fio` varchar(64) NOT NULL,
  `post` varchar(64) NOT NULL,
  `passport` varchar(16) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `nurse`
--

INSERT INTO `nurse` (`id_nurse`, `login`, `password`, `fio`, `post`, `passport`, `phone`, `token`) VALUES
(1, 'test', '$2y$13$Q9P1rMJxZWlmNseSQ7MCvuehXIjnpi9ug3Rj11q91a4SaRrO5nvr6', 'test', 'test', '123', '123', 'qweRoikpxpZnAmtxLY2dDpjplsiNjqnL');

-- --------------------------------------------------------

--
-- Структура таблицы `par`
--

CREATE TABLE `par` (
  `id_parent` int(11) NOT NULL,
  `fio` varchar(64) NOT NULL,
  `passport` varchar(16) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `par`
--

INSERT INTO `par` (`id_parent`, `fio`, `passport`, `phone`) VALUES
(1, 'parentfio', 'passport', 'phone');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `anam`
--
ALTER TABLE `anam`
  ADD PRIMARY KEY (`id_anamn`),
  ADD KEY `child_id_FK` (`child_id`),
  ADD KEY `nurse_id_FK` (`nurse_id`);

--
-- Индексы таблицы `child`
--
ALTER TABLE `child`
  ADD PRIMARY KEY (`id_child`),
  ADD KEY `parent_id_FK` (`parent_id`);

--
-- Индексы таблицы `diag`
--
ALTER TABLE `diag`
  ADD PRIMARY KEY (`id_diag`),
  ADD KEY `anamn_id_FK` (`anamn_id`);

--
-- Индексы таблицы `nurse`
--
ALTER TABLE `nurse`
  ADD PRIMARY KEY (`id_nurse`);

--
-- Индексы таблицы `par`
--
ALTER TABLE `par`
  ADD PRIMARY KEY (`id_parent`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `anam`
--
ALTER TABLE `anam`
  MODIFY `id_anamn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `child`
--
ALTER TABLE `child`
  MODIFY `id_child` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `diag`
--
ALTER TABLE `diag`
  MODIFY `id_diag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `nurse`
--
ALTER TABLE `nurse`
  MODIFY `id_nurse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `par`
--
ALTER TABLE `par`
  MODIFY `id_parent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `anam`
--
ALTER TABLE `anam`
  ADD CONSTRAINT `child_id_FK` FOREIGN KEY (`child_id`) REFERENCES `child` (`id_child`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nurse_id_FK` FOREIGN KEY (`nurse_id`) REFERENCES `nurse` (`id_nurse`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `child`
--
ALTER TABLE `child`
  ADD CONSTRAINT `parent_id_FK` FOREIGN KEY (`parent_id`) REFERENCES `par` (`id_parent`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `diag`
--
ALTER TABLE `diag`
  ADD CONSTRAINT `anamn_id_FK` FOREIGN KEY (`anamn_id`) REFERENCES `anam` (`id_anamn`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
