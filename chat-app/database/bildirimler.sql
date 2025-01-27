/*
 Navicat Premium Data Transfer

 Source Server         : Als Sunucu
 Source Server Type    : MySQL
 Source Server Version : 100148 (10.1.48-MariaDB-0ubuntu0.18.04.1)
 Source Host           : localhost:3306
 Source Schema         : alsDatabase

 Target Server Type    : MySQL
 Target Server Version : 100148 (10.1.48-MariaDB-0ubuntu0.18.04.1)
 File Encoding         : 65001

 Date: 07/10/2024 00:53:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bildirimler
-- ----------------------------
DROP TABLE IF EXISTS `bildirimler`;
CREATE TABLE `bildirimler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bildirim_baslik` varchar(255) NOT NULL,
  `bildirim_icerik` text NOT NULL,
  `bildirim_gonderen_id` int(11) NOT NULL,
  `bildirim_gonderilen_id` int(11) DEFAULT NULL,
  `bildirim_genel_durum` varchar(15) DEFAULT NULL,
  `bildirim_cevaplayabilir` varchar(10) NOT NULL,
  `bildirim_okunma_durumu` varchar(10) DEFAULT NULL,
  `bildirim_gorunme_durumu` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `prova_id` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
