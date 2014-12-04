-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: zenfox
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.12.04.2
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `partner_frontends`
--

INSERT INTO `partner_frontends` (`partner_frontend_id`, `name`, `description`, `allowed_frontend_ids`, `default_currency`, `timezone`, `url`) VALUES (1,'Ace2Jak','This frontend is for Ace2Jak','7','INR','Asia/Calcutta','http://www.ace2jak.com');

--
-- Dumping data for table `partner_groups`
--

INSERT INTO `partner_groups` (`partner_group_id`, `name`, `allowed_frontend_ids`, `description`) VALUES (1,'Basic Group','1,7','All partners have access to this group.');

--
-- Dumping data for table `partner_privileges`
--

INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (1,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (3,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (5,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (6,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (7,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (8,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (9,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (10,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (11,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (12,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (13,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (14,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (15,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (16,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (17,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (18,1);
INSERT INTO `partner_privileges` (`partner_resource_id`, `partner_group_id`) VALUES (19,1);

--
-- Dumping data for table `partner_resources`
--

INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (1,'partner-index-index','Main page of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (2,'partner-auth-login','Login page of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (3,'partner-auth-logout','Logout page of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (4,'partner-auth-register','Registeration page of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (5,'partner-home-index','Home page of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (6,'partner-player-search','Player search page of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (7,'partner-player-reconcile','Player reconciliation report page of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (8,'partner-player-withdrawal','Player withdrawal report page of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (9,'partner-player-profile','Player profile page of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (10,'partner-report-registrations','Registrations report of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (11,'partner-report-gamehistory','Gamehistory report of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (12,'partner-report-depositors','Depositors report of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (13,'partner-report-transactions','Transactions report of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (14,'partner-report-gamelogs','Gamelogs report of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (15,'partner-bonus-view','View bonus schemes of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (16,'partner-bonus-edit','Edit bonus level of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (17,'partner-analytics-registrations','Analytics for registrations of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (18,'partner-analytics-transactions','Analytics for transactions of partner module');
INSERT INTO `partner_resources` (`partner_resource_id`, `resource_name`, `description`) VALUES (19,'partner-analytics-transacting-players','Analytics for transacting players of partner module');

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`partner_id`, `alias`, `password`, `email`, `partner_frontend_id`, `first_name`, `last_name`, `address`, `city`, `state`, `pin`, `country_id`, `phone_no`, `created`, `language`, `allowed_group_ids`) VALUES (1,'ace2jak','1aaf0a6241e4197e75dd8e8af2b68c57','support@ace2jak.com',1,'Ace','Jak','Banjara Hills','Hyderabad','AP','500034',1,'888888888','2013-12-10 10:57:13','en_GB','1');
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-26 14:53:09
