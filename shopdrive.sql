-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.25 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных shopdrive
CREATE DATABASE IF NOT EXISTS `shopdrive` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `shopdrive`;


-- Дамп структуры для таблица shopdrive.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shopdrive.category: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'bicycle'),
	(2, 'roller skates'),
	(3, 'ckate board'),
	(4, 'skates'),
	(5, 'ski'),
	(6, 'snow board');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- Дамп структуры для таблица shopdrive.order
CREATE TABLE IF NOT EXISTS `order` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint(5) unsigned NOT NULL DEFAULT '202',
  `date` date NOT NULL,
  `amount` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `FK_order_user` (`user_id`),
  CONSTRAINT `FK_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shopdrive.order: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` (`id`, `user_id`, `date`, `amount`) VALUES
	(4, 13, '2011-11-01', 198.00),
	(6, 1, '2011-11-02', 1200.00),
	(8, 17, '2011-11-03', 5000.00),
	(9, 1, '2011-11-02', 1200.00),
	(12, 202, '2015-09-07', 1650.00),
	(21, 204, '2015-09-14', 4770.00),
	(22, 202, '2015-09-14', 2253.00),
	(23, 202, '2015-09-14', 16129.00);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;


-- Дамп структуры для таблица shopdrive.order_item
CREATE TABLE IF NOT EXISTS `order_item` (
  `order_id` smallint(6) unsigned NOT NULL,
  `product_id` smallint(6) unsigned NOT NULL,
  `quantity` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `FK_order_item_product` (`product_id`),
  CONSTRAINT `FK_order_item_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_order_item_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shopdrive.order_item: ~11 rows (приблизительно)
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` (`order_id`, `product_id`, `quantity`) VALUES
	(4, 16, 3),
	(4, 24, 1),
	(6, 5, 4),
	(8, 1, 1),
	(8, 2, 2),
	(12, 20, 1),
	(21, 4, 1),
	(21, 24, 1),
	(22, 6, 1),
	(23, 24, 1),
	(23, 29, 2);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;


-- Дамп структуры для таблица shopdrive.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(250) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `img` char(100) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` smallint(6) NOT NULL DEFAULT '0',
  `category` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `FK_product_category` (`category`),
  CONSTRAINT `FK_product_category` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shopdrive.product: ~22 rows (приблизительно)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `name`, `description`, `img`, `price`, `total`, `category`) VALUES
	(1, 'Avanti Force 18', 'Велосипед 26" Avanti Force 18" (2015) черный матовый', '12.jpg', 6575.00, 6, 1),
	(2, 'Intenzo Spike', 'Велосипед Intenzo Spike 2014 белый', '13.jpg', 2952.00, 2, 1),
	(3, 'Avanti Crusier', 'Велосипед 26" Avanti Crusier Lady 17" (2015) бирюзовый', '14.jpg', 4555.00, 8, 1),
	(4, 'Crossride Flash', 'Велосипед Crossride Flash MTB 26"', '15.jpg', 3215.00, 5, 1),
	(5, 'Spelli City Nexus', 'Велосипед 24" Spelli City Nexus 15" (2015 ) Белый', '16.jpg', 6363.00, 7, 1),
	(6, 'Ardis Fold CK 20', 'Велосипед Ardis Fold CK 20" с освещением (08081)', '17.jpg', 2253.00, 3, 1),
	(7, 'Ardis Лыбидь 28Д', 'Велосипед Ardis Лыбидь 28Д с корзиной', '18.jpg', 2198.00, 3, 1),
	(8, 'Ardis Fold CK 24', 'Велосипед Ardis Fold CK 24" с освещением (08071)', '19.jpg', 2363.00, 6, 1),
	(10, 'Explore Music', 'Роликовые коньки Explore Music – это воплощение мечты для ценителей музыки и быстрой езды.', '21.png', 1090.00, 5, 2),
	(15, 'Explore А-4100', 'Ролики Explore А-4100 поразят качеством своего исполнения и уникальных разработок, которые сочетают в себе. Они идеально подходят для взрослых, а именно, для тех людей, которые на 100% знают, что им нужно.', '22.jpg', 1365.00, 5, 2),
	(16, 'Explore Mondial', 'Роликовые коньки раздвижные Explore Mondial - модель роликовых коньков предназначена для любительского катания.', '23.jpg', 990.00, 4, 2),
	(20, 'Matrix', ' Matrix - раздижные ролики с мягким ботинком для начинающих и детей.', '24.jpg', 1650.00, 4, 2),
	(21, 'Hello Kitty', 'Скейт Bambi Hello Kitty HK 0053', '31.jpg', 247.00, 33, 3),
	(22, 'Tempish CRAZY', 'Лонгборд Tempish CRAZY Long board', '32.jpg', 2490.00, 3, 3),
	(23, 'Скейт детский', 'Скейт детский', '33.jpg', 500.00, 6, 3),
	(24, 'Tempish RENTAL', 'Прокатные коньки Tempish RENTAL PLUS LADY\r\nот Спортмаркет "СКАУТ"', '41.jpg', 1555.00, 4, 4),
	(25, 'ULTIMATE SH', 'Коньки ULTIMATE SH 35 36-45 Tempish 13000001010\r\n', '42.jpg', 1700.00, 2, 4),
	(26, 'Tisa Sport', 'Лыжи беговые Tisa Sport Step Jr\r\nПроизводитель: Tisa (Украина).\r\nПрогулочные беговые лыжи с насечками, широким профилем, облегченной конструкцией и синтетической поверхностью для юниоров. ', '51.jpg', 555.00, 11, 5),
	(27, 'Fischer Snowstar', 'Лыжи беговые Fischer Snowstar NIS MTD\r\nПроизводитель: Fischer (Австрия).\r\nСтильные детские беговые лыжи с насечками и предустановленной платформой NIS. Взрослые технологии адаптированы для потребностей маленьких лыжников. Крепление для ботинок в комплекте.', '52.jpg', 1513.00, 3, 5),
	(28, 'Fischer E109', 'Лыжи беговые Fischer E109 Crown Extralite\r\nПроизводитель: Fischer (Австрия).\r\nОсобо облегченные туристические беговые лыжи для путешествий по дикой заснеженной природе. ', '53.jpg', 4335.00, 3, 5),
	(29, 'URTON RATION\'13', 'СНОУБОРД BURTON , RATION\'13 \r\nОставь блеск и глэм для райдеров выходного дня. Грубый и необрезанный, Ration предлагает чистое...', '61.jpg', 7287.00, 3, 6),
	(30, 'ROSSIGNOL', 'СНОУБОРД ROSSIGNOL , ДОСКА JIBSAW MAGTEK + КРЕПЛЕНИЯ CUDA V2\'13 Наличие и цены\r\nуточняйте на\r\nмомент покупки\r\nДоска для парка и пайпа для настоящих фанатов. Истинный твин-тип', '62.jpg', 7990.00, 5, 6);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- Дамп структуры для таблица shopdrive.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `description` char(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Индекс 2` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shopdrive.role: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `name`, `description`) VALUES
	(1, 'Admin', 'Admin'),
	(3, 'AdvancedUser', 'Discount 5%'),
	(4, 'SuperUser', 'Discount 10%'),
	(5, 'SimpleUser', 'without discount');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;


-- Дамп структуры для таблица shopdrive.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `login` char(40) DEFAULT NULL,
  `email` char(40) NOT NULL,
  `password` char(40) NOT NULL,
  `photo` char(100) NOT NULL,
  `role_id` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `is_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `login` (`login`),
  KEY `FK_user_role` (`role_id`),
  CONSTRAINT `FK_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shopdrive.user: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `login`, `email`, `password`, `photo`, `role_id`, `is_active`) VALUES
	(1, 'Ivanov Ivan', 'ivan@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1.gif', 1, '1'),
	(2, 'Sidorov Sidor', 'new@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2.gif', 5, '1'),
	(13, 'Andreev Andrey', 'andrey@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '3.gif', 5, '1'),
	(14, 'Borisov Boris', 'boris@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '4.gif', 5, '1'),
	(16, 'Olegov Oleg', 'oleg@gmail.ua', '7c4a8d09ca3762af61e59520943dc26494f8941b', '6.gif', 5, '1'),
	(17, 'Denisov Denis', 'denis@gmail.ru', '7c4a8d09ca3762af61e59520943dc26494f8941b', '7.gif', 5, '1'),
	(202, 'guest', 'guest', '', '', 5, '1'),
	(204, 'admin', 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', '10.jpg', 1, '1');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
