-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 22 2020 г., 15:22
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `distancelearning`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_course_ops` (IN `op` CHAR(1), IN `c_id` INT, IN `c_name` VARCHAR(30), IN `c_note` VARCHAR(100), IN `c_date` DATE, IN `l_id` INT)  begin
if op = 'i' then
insert into course(course_name, course_note, course_date, lecturer_id) values (c_name, c_note, c_date, l_id);
elseif op = 'u' then
update course set course_name = c_name, course_note = c_note, course_date = c_date, lecturer_id = l_id
where course_id = c_id;
else
delete from course where course_id = c_id;
end if;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `course_note` varchar(100) NOT NULL,
  `course_date` date NOT NULL,
  `lecturer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_note`, `course_date`, `lecturer_id`) VALUES
(1, 'Programming', 'Study programming', '2020-06-23', 1),
(2, 'Math', 'Study math', '2020-07-19', 3),
(3, 'Geography', 'Study geo', '2020-07-04', 2),
(5, 'Fundamentals of Databases', 'Introsuction to DB', '2020-08-11', 1),
(6, 'Artifitial Intelligence', 'This is the course to tell everyone about AI', '2020-07-30', 4);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `course_lecturer`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `course_lecturer` (
`course_id` int(11)
,`course_date` date
,`course_name` varchar(50)
,`course_note` varchar(100)
,`Lecturer` varchar(51)
);

-- --------------------------------------------------------

--
-- Структура таблицы `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` int(11) NOT NULL,
  `lecturer_name` varchar(20) NOT NULL,
  `lecturer_surname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `lecturer`
--

INSERT INTO `lecturer` (`lecturer_id`, `lecturer_name`, `lecturer_surname`) VALUES
(1, 'Ivan', 'Ivanov'),
(2, 'John', 'Wick'),
(3, 'Alex', 'Sus'),
(4, 'Bill', 'Gates');

-- --------------------------------------------------------

--
-- Структура таблицы `participants`
--

CREATE TABLE `participants` (
  `participant_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `participant_name` varchar(15) NOT NULL,
  `participant_surname` varchar(20) NOT NULL,
  `participant_age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `participants`
--

INSERT INTO `participants` (`participant_id`, `course_id`, `participant_name`, `participant_surname`, `participant_age`) VALUES
(1, 1, 'Alex', 'Boyko', 18),
(2, 1, 'Morty', 'Lil', 19),
(3, 2, 'Slava', 'Gubarev', 20),
(4, 3, 'Dmitriy', 'Malikov', 45),
(5, 5, 'Dmitriy', 'Gordon', 50),
(6, 5, 'George', 'Floyd', 31),
(7, 2, 'Ricky', 'Martin', 28),
(8, 6, 'Mike', 'Vazovski', 25);

-- --------------------------------------------------------

--
-- Структура для представления `course_lecturer`
--
DROP TABLE IF EXISTS `course_lecturer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `course_lecturer`  AS  select `course`.`course_id` AS `course_id`,`course`.`course_date` AS `course_date`,`course`.`course_name` AS `course_name`,`course`.`course_note` AS `course_note`,concat(`lecturer`.`lecturer_name`,' ',`lecturer`.`lecturer_surname`) AS `Lecturer` from (`course` join `lecturer` on(`course`.`lecturer_id` = `lecturer`.`lecturer_id`)) order by `course`.`course_id` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Индексы таблицы `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Индексы таблицы `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`participant_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `lecturer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `participants`
--
ALTER TABLE `participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`);

--
-- Ограничения внешнего ключа таблицы `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
