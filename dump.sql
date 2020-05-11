-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 11 2020 г., 09:57
-- Версия сервера: 5.7.29-0ubuntu0.18.04.1
-- Версия PHP: 7.1.33-14+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `qatl-test-php.local`
--

-- --------------------------------------------------------

--
-- Структура таблицы `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL COMMENT 'Author ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Author Full name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `author`
--

INSERT INTO `author` (`id`, `name`) VALUES
(1, 'Сьюзан Герберт'),
(2, 'Дорж Бату'),
(3, 'Максим Беспалов');

-- --------------------------------------------------------

--
-- Структура таблицы `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL COMMENT 'Book ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Book Name',
  `publisher_id` int(11) NOT NULL COMMENT 'Publisher ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Books table';

--
-- Дамп данных таблицы `book`
--

INSERT INTO `book` (`id`, `name`, `publisher_id`) VALUES
(1, 'Галерея котів', 1),
(2, 'Моцарт 2.0', 3),
(3, 'Амадока', 1),
(4, 'Українська ікона XI-XVIII століть (Подарунковий Альбом)', 2),
(5, 'Східний вал', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `link_book_author`
--

CREATE TABLE `link_book_author` (
  `book_id` int(11) NOT NULL COMMENT 'Book ID',
  `author_id` int(11) NOT NULL COMMENT 'Author ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Link book to publisher';

--
-- Дамп данных таблицы `link_book_author`
--

INSERT INTO `link_book_author` (`book_id`, `author_id`) VALUES
(1, 1),
(3, 1),
(4, 1),
(2, 2),
(3, 2),
(5, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `publisher`
--

CREATE TABLE `publisher` (
  `id` int(11) NOT NULL COMMENT 'Publisher ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Publisher Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `publisher`
--

INSERT INTO `publisher` (`id`, `name`) VALUES
(1, 'А-БА-БА-ГА-ЛА-МА-ГА'),
(2, 'А.С.К.'),
(3, 'Майстерня Білецьких'),
(4, 'Майстерня знань'),
(5, 'Book Sales, Inc'),
(6, 'Bounty Books');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX___book__publisher_id` (`publisher_id`) USING BTREE;

--
-- Индексы таблицы `link_book_author`
--
ALTER TABLE `link_book_author`
  ADD UNIQUE KEY `IDX___link_BA__book_id__author_id` (`book_id`,`author_id`) USING BTREE,
  ADD KEY `IDX___link_BA__author_id` (`author_id`) USING BTREE,
  ADD KEY `IDX___link_BA__book_id` (`book_id`) USING BTREE;

--
-- Индексы таблицы `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Author ID', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Book ID', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Publisher ID', AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`);

--
-- Ограничения внешнего ключа таблицы `link_book_author`
--
ALTER TABLE `link_book_author`
  ADD CONSTRAINT `link_book_author_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `link_book_author_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
