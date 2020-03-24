/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.3.14-MariaDB : Database - rentcar
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rentcar` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `rentcar`;

/*Table structure for table `car_data` */

DROP TABLE IF EXISTS `car_data`;

CREATE TABLE `car_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_name` varchar(150) NOT NULL,
  `production_year` year(4) NOT NULL,
  `price_per_day` double NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `car_data` */

insert  into `car_data`(`id`,`car_name`,`production_year`,`price_per_day`,`created_at`,`updated_at`,`deleted_at`) values (1,'Honda Mobilio',2015,524000,'2020-03-24 00:15:47','2020-03-24 15:26:52',NULL),(2,'Toyota New Yaris',2017,400000,'2020-03-24 06:57:56','2020-03-24 15:26:56',NULL),(3,'Kijang Innova',2009,515000,'2020-03-24 06:58:23','2020-03-24 15:27:15',NULL),(4,'Toyota Avanza',2020,460000,'2020-03-24 07:23:42','2020-03-24 13:09:28',NULL),(5,'Honda Brio',2014,375000,'2020-03-24 08:12:37','2020-03-24 15:27:04',NULL),(6,'Daihatsu Xenia',2015,305000,'2020-03-24 16:39:54','2020-03-24 20:02:40',NULL);

/*Table structure for table `car_rental` */

DROP TABLE IF EXISTS `car_rental`;

CREATE TABLE `car_rental` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(30) NOT NULL,
  `id_car_data` int(11) NOT NULL,
  `rent_begin` date NOT NULL,
  `rent_end` date NOT NULL,
  `cost` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `car_rental` */

insert  into `car_rental`(`id`,`order_number`,`id_car_data`,`rent_begin`,`rent_end`,`cost`,`discount`,`created_at`,`updated_at`,`deleted_at`) values (1,'2403193947t0VMhgG',1,'2020-03-03','2020-03-06',1572000,78600,'2020-03-24 19:40:19',NULL,'2020-03-24 20:03:10'),(2,'24031940240ycUYqL',2,'2020-03-10','2020-03-13',1200000,66000,'2020-03-24 19:41:03',NULL,'2020-03-24 19:43:04'),(3,'24031940240ycUYqL',3,'2020-03-10','2020-03-13',1545000,85515.75,'2020-03-24 19:41:03',NULL,'2020-03-24 19:43:07'),(4,'2403194158Bzafsld',2,'2020-03-10','2020-03-13',1200000,66000,'2020-03-24 19:42:36',NULL,'2020-03-24 20:03:13'),(5,'2403194158Bzafsld',3,'2020-03-10','2020-03-13',1545000,85515,'2020-03-24 19:42:36',NULL,'2020-03-24 20:03:16'),(6,'2403200319DyWiKUG',1,'2020-03-03','2020-03-06',1572000,86460,'2020-03-24 20:03:50',NULL,NULL),(7,'2403200319DyWiKUG',3,'2020-03-03','2020-03-06',1545000,85515,'2020-03-24 20:03:50',NULL,NULL),(8,'2403200503mHuDrbA',4,'2020-03-24','2020-03-27',1380000,69000,'2020-03-24 20:05:29',NULL,NULL);

/*Table structure for table `level` */

DROP TABLE IF EXISTS `level`;

CREATE TABLE `level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `level` */

insert  into `level`(`id`,`title`,`created_at`,`updated_at`,`deleted_at`) values (1,'Administrator','2016-04-24 13:01:27','2016-04-24 13:01:39',NULL),(2,'Member','2016-04-25 23:06:42',NULL,NULL);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(60) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '0:nonactive; 1:active',
  `id_level` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`email`,`password`,`photo`,`status`,`id_level`,`created_at`,`updated_at`,`deleted_at`) values (1,'admin','admin@gmail.com','356a192b7913b04c54574d18c28d46e6395428ab',NULL,1,1,'2016-04-08 19:08:10','2020-01-14 14:47:52',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
