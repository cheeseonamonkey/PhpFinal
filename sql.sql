SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `finaldb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `finaldb`;

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `bio` text NOT NULL DEFAULT '(no bio)',
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `registerDate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `usernameUnique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `messageattachments`;
CREATE TABLE IF NOT EXISTS `messageattachments` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `messageId` mediumint(8) UNSIGNED NOT NULL,
  `dir` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `messageIdFK` (`messageId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fromId` smallint(5) UNSIGNED NOT NULL,
  `toId` smallint(5) UNSIGNED NOT NULL,
  `dateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `subject` varchar(50) NOT NULL DEFAULT '(no subject)',
  `body` text NOT NULL DEFAULT '(no body)',
  `hasAttachment` tinyint(1) NOT NULL DEFAULT 0,
  `viewed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `profilepictures`;
CREATE TABLE IF NOT EXISTS `profilepictures` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `dir` varchar(256) NOT NULL,
  `size` int(11) NOT NULL,
  `userId` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userIdPictureFK` (`userId`),
  KEY `userIdPicture` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;


ALTER TABLE `messageattachments`
  ADD CONSTRAINT `messageIdFK` FOREIGN KEY (`messageId`) REFERENCES `messages` (`id`);

ALTER TABLE `profilepictures`
  ADD CONSTRAINT `userIdPictureFK` FOREIGN KEY (`userId`) REFERENCES `accounts` (`id`);
