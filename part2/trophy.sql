-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.33 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных trophy
CREATE DATABASE IF NOT EXISTS `trophy` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `trophy`;

-- Дамп структуры для таблица trophy.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) DEFAULT '0',
  `record_time` time DEFAULT '00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы trophy.sessions: ~0 rows (приблизительно)
INSERT INTO `sessions` (`id`, `session_id`, `record_time`) VALUES
	(1, '6jt52ddivp3ubc7u8o233ukpc8ukmrfl', '00:00:02'),
	(2, '6jt52ddivp3ubc7u8o233ukpc8ukmrfl', '00:00:04'),
	(3, '6jt52ddivp3ubc7u8o233ukpc8ukmrfl', '00:00:08'),
	(4, '6jt52ddivp3ubc7u8o233ukpc8ukmrfl', '00:00:05'),
	(5, '6jt52ddivp3ubc7u8o233ukpc8ukmrfl', '00:00:10'),
	(6, '6jt52ddivp3ubc7u8o233ukpc8ukmrfl', '00:00:04'),
	(7, '6jt52ddivp3ubc7u8o233ukpc8ukmrfl', '00:00:05'),
	(8, '6jt52ddivp3ubc7u8o233ukpc8ukmrfl', '00:00:08');

-- Дамп структуры для таблица trophy.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы trophy.settings: ~0 rows (приблизительно)
INSERT INTO `settings` (`id`, `name`, `content`) VALUES
	(1, 'test_mode', 'true'),
	(2, 'normal_speed', '500'),
	(3, 'turbo_speed', '1000');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
