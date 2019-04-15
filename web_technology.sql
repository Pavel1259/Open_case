-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 15 2019 г., 09:33
-- Версия сервера: 5.6.41
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `web_technology`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cases`
--

CREATE TABLE `cases` (
  `id` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(5) NOT NULL,
  `table_id_skins` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `game` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cases`
--

INSERT INTO `cases` (`id`, `name`, `price`, `table_id_skins`, `img`, `game`) VALUES
(1, 'Перчаточный кейс', 170, '10,11,19,12,13,14,15,16,10,11,17,12,13,14,15,16,10,19,11,12,13,14,15,16,18,10,11,12,13,14,15,22,16,10,11,12,13,14,19,15,16,10,11,23,12,13,14,15,16,20,10,11,12,13,14,18,15,16,10,20,11,12,13,14,15,16,21,10,11,12,13,14,22,15,16,10,11,12,18,13,14,24,15,16,10,11,12,13,21,14,15,16,19,10,11,12,13,14,15,16,10,11,12,13,17,14,15,16,10,23,11,12,13,14,19,15,16,10,18,11,12,13,14,15,16,14,10,11,12,13,20,14,15,16,10,23,11,12,13,14,18,15,16,10,11,12,13,14,15,16,21,10,11,12,13,21,14,15,16,10,17,11,12,13,14,22,15,16,21,10,11,12,13,14,15,16,20,10,11,25,12,13,14,15,16,10,17,11,12,13,14,15,16,10,11,12,18,13,14,15,16,10,11,12,20,13,14,15,16,10,22,11,12,13,14,15,20,16,10,11,12,13,14,23,15,16,10,11,12,17,13,14,15,16,10,11,12,19,13,14,15,16,10,11,12,13,20,14,15,16,10,11,12,13,14,15,16,21,10,11,12,13,14,15,16,21,10,11,12,23,13,14,15,16,10,11,19,12,13,14,15,16,10,11,12,13,17,14,15,16,10,11,12,13,26,14,15,16,15,16', 'img/cases/Gloves_case.png', ''),
(2, 'Гамма кейс', 200, '27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42', 'img/cases/Gamma_case.png', '');

-- --------------------------------------------------------

--
-- Структура таблицы `person`
--

CREATE TABLE `person` (
  `id` int(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `currency` int(7) NOT NULL,
  `inventory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person`
--

INSERT INTO `person` (`id`, `name`, `password`, `currency`, `inventory`) VALUES
(1, 'qwerty', '123', 21771, '3,1,7,9,3,9,9,3,6,9,3,6,6,6,9,1,5,9,15,14,10,20,16,12,10,26,16,23,13,25,17,16,18,21,16,25,14,25,35,16,16,11,16,23,15,26,22,15,12,11,11,14,15,13,16,12,15,10,19,11,14,13,10,13,15,40,30,33'),
(2, 'qwe', '123', 12345, '2,3,1,4,5,1');

-- --------------------------------------------------------

--
-- Структура таблицы `predmety`
--

CREATE TABLE `predmety` (
  `id` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(5) NOT NULL,
  `id_case` int(2) NOT NULL,
  `img` varchar(255) NOT NULL,
  `redkost` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `predmety`
--

INSERT INTO `predmety` (`id`, `name`, `price`, `id_case`, `img`, `redkost`) VALUES
(1, 'AWP | Пиксельный камуфляж', 2700, 3, 'img/skins/AWP/AWP_PixelKamyflyaj.png', 4),
(2, 'USP-S | Ночные операции', 51, 3, 'img/skins/USP/usp-nochnye-operacii.png', 2),
(3, 'AUG | Янтарный шквал', 17, 3, 'img/skins/AUG/AUG_jantarnyi_shkval.png', 1),
(4, 'CZ75-Auto | Тигр', 130, 3, 'img/skins/CZ75-Auto/cz75-auto-tigr.png', 4),
(5, 'P90 | Модуль', 47, 3, 'img/skins/P90/p90-modul.png', 2),
(6, 'SCAR-20 | Сайрекс', 410, 3, 'img/skins/SCAR-20/scar-20-saireks.png', 5),
(7, 'Galil AR | Смешанный камуфляж', 5, 3, 'img/skins/Galil_AR/galil-ar-smeshnnyi-kamyflaj.png', 3),
(8, 'AWP | История о драконе', 124597, 3, 'img/skins/AWP/awp_istorya_o_drakone.png', 6),
(9, 'AK-47 | Ягуар', 2843, 3, 'img/skins/AK-47/ak-47-jaguar.png', 6),
(10, 'CZ75-Auto | Полимер', 14, 1, 'img/skins/CZ75-Auto/cz75-auto-polimer.png', 2),
(11, 'Glock-18 | Литьё', 32, 1, 'img/skins/Glock-18/glock-18-lite.png', 2),
(12, 'MP7 | Перистое облако', 33, 1, 'img/skins/MP7/mp7-peristoe-jabloko.png', 2),
(13, 'Galil AR | Чёрный песок', 24, 1, 'img/skins/Galil_AR/galil-ar-cherny-pesok.png', 2),
(14, 'MP9 | Пыльный осадок', 16, 1, 'img/skins/MP9/mp9-pylny-osadok.png', 2),
(15, 'MAG-7 | Эхолот', 13, 1, 'img/skins/MAG-7/mag-7-echolot.png', 2),
(16, 'P2000 | Дерн', 26, 1, 'img/skins/P2000/p2000-dern.png', 2),
(17, 'Dual Berettas | Королевская чета', 79, 1, 'img/skins/Dual_Berettas/dual-berettas-korolevskaya-cheta.png', 4),
(18, 'G3SG1 | Жало', 52, 1, 'img/skins/G3SG1/s3sg1-jalo.png', 4),
(19, 'M4A1-S | Взгляд в прошлое', 260, 1, 'img/skins/M4A1-S/m4a1-s-vzglyad-b-v-proshloe.png', 4),
(20, 'Nova | Ядозуб', 48, 1, 'img/skins/Nova/nova-jadozub.png', 4),
(21, 'USP-S | Сайрекс', 274, 1, 'img/skins/USP/usp-saireks.png', 4),
(22, 'FAMAS | Механо-пушка', 327, 1, 'img/skins/FAMAS/famas-mechano-pushka.png', 5),
(23, 'Sawed-Off | Принцесса пустошей', 336, 1, 'img/skins/Sawed-Off/sawed-off-princessa-pustoshei.png', 5),
(24, 'SSG 08 | Пламя дракона', 1386, 1, 'img/skins/SSG_08/ssg-08-plamya-drakona.png', 6),
(25, 'M4A4 | Облом', 1883, 1, 'img/skins/M4A4/m4a4-oblom.png', 6),
(26, 'Мотоциклетные перчатки | Полигон', 18260, 1, 'img/skins/Gloves/gloves-poligon.png', 6),
(27, 'CZ75-Auto | Штамп', 19, 2, 'img/skins/CZ75-Auto/cz75-auto-shtamp.png', 2),
(28, 'Five-SeveN | Скумбрия', 17, 2, 'img/skins/Five-SeveN/five-seven-skumbriya.png', 2),
(29, 'Negev | Конфуз', 15, 2, 'img/skins/Negev/negev-konfuz.png', 2),
(30, 'P90 | Мрак', 66, 2, 'img/skins/P90/p90-mrak.png', 2),
(31, 'UMP-45 | Брифинг', 30, 2, 'img/skins/UMP-45/ump-45-brifing.png', 2),
(32, 'XM1014 | Поток', 15, 2, 'img/skins/XM1014/xm1014-potok.png', 2),
(33, 'Desert Eagle | Директива', 512, 2, 'img/skins/Desert_Eagle/desert-eagle-direktiva.png', 4),
(34, 'Glock-18 | Ласка', 213, 2, 'img/skins/Glock-18/glock-18-laska.png', 4),
(35, 'MAG-7 | Петроглиф', 56, 2, 'img/skins/MAG-7/mag-7-petroglif.png', 4),
(36, 'SCAR-20 | Генератор', 70, 2, 'img/skins/SCAR-20/scar-20-generator.png', 4),
(37, 'SG 553 | Триарх', 118, 2, 'img/skins/SG_553/sg553-triarch.png', 4),
(38, 'AUG | Сид Мид', 845, 2, 'img/skins/AUG/AUG_Sid_Mid.png', 5),
(39, 'MP9 | Воздушный шлюз', 374, 2, 'img/skins/MP9/mp9-vozdushny-shlyz.png', 5),
(40, 'Tec-9 | Топливный инжектор', 383, 2, 'img/skins/Tec-9/tec-9-toplivny-injector.png', 5),
(41, 'AK-47 | Неоновая революция', 3155, 2, 'img/skins/AK-47/ak-47-neonovaja-revoluciya.png', 6),
(42, 'FAMAS | Защитный каркас', 1383, 2, 'img/skins/FAMAS/famas-zashitny-karkas.png', 6);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `predmety`
--
ALTER TABLE `predmety`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `person`
--
ALTER TABLE `person`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `predmety`
--
ALTER TABLE `predmety`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
