-- MySQL dump 10.13  Distrib 5.1.37, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: zenfox
-- ------------------------------------------------------
-- Server version	5.1.37-1ubuntu5-log
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `gms_menu`
--

INSERT INTO `gms_menu` VALUES (-1,'Root','Root Node','ENABLED','NOLINK','root','INVISIBLE');
INSERT INTO `gms_menu` VALUES (1,'Login','Admin Module Auth Controller Login Action','ENABLED','LINK','admin-auth-login','VISIBLE');
INSERT INTO `gms_menu` VALUES (2,'Home','Admin Module Home Controller Index Action','ENABLED','LINK','admin-home-index','VISIBLE');
INSERT INTO `gms_menu` VALUES (3,'Logout','Admin Module Auth Controller Logout Action','ENABLED','LINK','admin-auth-logout','VISIBLE');
INSERT INTO `gms_menu` VALUES (4,'Games','Game Node','ENABLED','NOLINK','admin','VISIBLE');
INSERT INTO `gms_menu` VALUES (5,'Bingo','Bingo Game Node','ENABLED','NOLINK','admin-bingo','VISIBLE');
INSERT INTO `gms_menu` VALUES (6,'Create','Admin Module Bingo Controller Create Action','ENABLED','LINK','admin-bingo-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (7,'View','Admin Module Bingo Controller View Action','ENABLED','LINK','admin-bingo-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (8,'Edit','Admin Module Bingo Controller Edit Action','ENABLED','LINK','admin-bingo-edit','VISIBLE');
INSERT INTO `gms_menu` VALUES (9,'Keno','Keno Game Node','ENABLED','NOLINK','admin-keno','VISIBLE');
INSERT INTO `gms_menu` VALUES (10,'Create','Admin Module Keno Controller Create Action','ENABLED','LINK','admin-keno-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (11,'View','Admin Module Keno Controller View Action','ENABLED','LINK','admin-keno-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (12,'Edit','Admin Module Keno Controller Edit Action','ENABLED','LINK','admin-keno-edit','VISIBLE');
INSERT INTO `gms_menu` VALUES (13,'Roulette','Roulette Game Node','ENABLED','NOLINK','admin-rouletteconfig','VISIBLE');
INSERT INTO `gms_menu` VALUES (14,'Create','Admin Module Rouletteconfig Controller Create Action','ENABLED','LINK','admin-rouletteconfig-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (15,'View','Admin Module Rouletteconfig Controller View Action','ENABLED','LINK','admin-rouletteconfig-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (16,'Edit','Admin Module Rouletteconfig Controller Edit Action','ENABLED','LINK','admin-rouletteconfig-edit','VISIBLE');
INSERT INTO `gms_menu` VALUES (17,'Slot','Slot Game Node','ENABLED','NOLINK','admin-slotconfig','VISIBLE');
INSERT INTO `gms_menu` VALUES (18,'Create','Admin Module Slotconfig Controller Create Action','ENABLED','LINK','admin-slotconfig-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (19,'View','Admin Module Slotconfig Controller View Action','ENABLED','LINK','admin-slotconfig-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (20,'Edit','Admin Module Slotconfig Controller Edit Action','ENABLED','LINK','admin-slotconfig-edit','VISIBLE');
INSERT INTO `gms_menu` VALUES (21,'Search Player','Admin Module Searching Controller Index Action','ENABLED','LINK','admin-searching-index','VISIBLE');

--
-- Dumping data for table `gms_menu_link`
--

INSERT INTO `gms_menu_link` VALUES (1,-1,-1);
INSERT INTO `gms_menu_link` VALUES (2,1,-1);
INSERT INTO `gms_menu_link` VALUES (3,2,-1);
INSERT INTO `gms_menu_link` VALUES (4,3,-1);
INSERT INTO `gms_menu_link` VALUES (5,4,-1);
INSERT INTO `gms_menu_link` VALUES (6,5,4);
INSERT INTO `gms_menu_link` VALUES (7,6,5);
INSERT INTO `gms_menu_link` VALUES (8,7,5);
INSERT INTO `gms_menu_link` VALUES (9,8,5);
INSERT INTO `gms_menu_link` VALUES (10,9,4);
INSERT INTO `gms_menu_link` VALUES (11,10,9);
INSERT INTO `gms_menu_link` VALUES (12,11,9);
INSERT INTO `gms_menu_link` VALUES (13,12,9);
INSERT INTO `gms_menu_link` VALUES (14,13,4);
INSERT INTO `gms_menu_link` VALUES (15,14,13);
INSERT INTO `gms_menu_link` VALUES (16,15,13);
INSERT INTO `gms_menu_link` VALUES (17,16,13);
INSERT INTO `gms_menu_link` VALUES (18,17,4);
INSERT INTO `gms_menu_link` VALUES (19,18,17);
INSERT INTO `gms_menu_link` VALUES (20,19,17);
INSERT INTO `gms_menu_link` VALUES (21,20,17);
INSERT INTO `gms_menu_link` VALUES (22,21,-1);
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-05-18 16:46:02
