/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 5.7.24 : Database - ticket
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ticket` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ticket`;

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `text` mediumtext COLLATE utf8mb4_unicode_ci,
  `message_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updflg` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `messages` */

insert  into `messages`(`id`,`ticket_id`,`created_at`,`updated_at`,`text`,`message_type`,`user_id`,`updflg`) values 
(1,'1','2019-06-14 10:53:13','2019-06-19 10:12:28','Boleh terangkan masalah dengan lebih terperinci.','patient','10','1'),
(2,'1','2019-06-16 16:36:44','2019-06-19 10:12:03','whatever that you say will be hold onto you','patient','10','1'),
(3,'1','2019-06-16 16:37:21','2019-06-16 16:37:21','<p>uyguhguyguy</p>','doctor','12','0'),
(4,'1','2019-06-19 10:35:43','2019-06-19 10:35:43','<p>please come to our clinic</p>','doctor','14','0'),
(5,'1','2019-06-19 10:37:15','2019-06-19 10:37:15','<p><img src=\"data:image/jpeg;base64,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\" data-filename=\"CustomLogo.JPG\" style=\"width: 167px;\"><br></p>','doctor','14','0'),
(6,'3','2019-10-03 11:27:56','2019-10-03 11:27:56','<p>ok</p>','doctor','12','0'),
(7,'3','2019-10-03 11:28:47','2019-10-03 11:28:47','edit','doctor','12','0'),
(8,'2','2020-02-28 12:36:35','2020-02-28 12:36:35','<p>Follow up</p>','patient','10','0'),
(9,'2','2020-02-28 12:38:07','2020-02-28 12:38:07','<p>Ok</p>','medicsoft','12','0');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `tickets` */

DROP TABLE IF EXISTS `tickets`;

CREATE TABLE `tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assign_to` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_by` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updflg` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tickets` */

insert  into `tickets`(`id`,`title`,`description`,`status`,`priority`,`category`,`assign_to`,`report_by`,`created_by`,`updflg`,`created_at`,`updated_at`) values 
(1,'question from aji','saya ada masalah pernafasan dan tulang belakang\r\n\r\nboleh saya dapatkan nasihat pakar?','Answered','Low','None','All',NULL,'aji','0','2019-06-14 10:49:14','2019-06-14 10:53:13'),
(2,'Neck problem','I have a neck problem, please doctor help me','Answered','Low','None','All',NULL,'padzul','0','2019-06-19 10:40:59','2020-02-28 12:36:35'),
(3,'Heart problem','Please preview my question','Answered','Low','None','All',NULL,'padzul','0','2019-06-19 10:54:15','2019-10-03 11:27:56');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
