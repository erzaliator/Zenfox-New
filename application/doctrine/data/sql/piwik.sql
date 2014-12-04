-- MySQL dump 10.13  Distrib 5.1.37, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: nikhil
-- ------------------------------------------------------
-- Server version	5.1.37-1ubuntu5
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `piwik_access`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_access` (
  `login` varchar(100) NOT NULL,
  `idsite` int(10) unsigned NOT NULL,
  `access` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`login`,`idsite`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_access`
--


--
-- Table structure for table `piwik_goal`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_goal` (
  `idsite` int(11) NOT NULL,
  `idgoal` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `match_attribute` varchar(20) NOT NULL,
  `pattern` varchar(255) NOT NULL,
  `pattern_type` varchar(10) NOT NULL,
  `case_sensitive` tinyint(4) NOT NULL,
  `revenue` float NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idsite`,`idgoal`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_goal`
--


--
-- Table structure for table `piwik_log_action`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_log_action` (
  `idaction` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `hash` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`idaction`),
  KEY `index_type_hash` (`type`,`hash`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_log_action`
--


--
-- Table structure for table `piwik_log_conversion`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_log_conversion` (
  `idvisit` int(10) unsigned NOT NULL,
  `idsite` int(10) unsigned NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `server_time` datetime NOT NULL,
  `idaction_url` int(11) DEFAULT NULL,
  `idlink_va` int(11) DEFAULT NULL,
  `referer_visit_server_date` date DEFAULT NULL,
  `referer_type` int(10) unsigned DEFAULT NULL,
  `referer_name` varchar(70) DEFAULT NULL,
  `referer_keyword` varchar(255) DEFAULT NULL,
  `visitor_returning` tinyint(1) NOT NULL,
  `visitor_count_visits` smallint(5) unsigned NOT NULL,
  `visitor_days_since_first` smallint(5) unsigned NOT NULL,
  `location_country` char(3) NOT NULL,
  `location_continent` char(3) NOT NULL,
  `url` text NOT NULL,
  `idgoal` int(10) unsigned NOT NULL,
  `revenue` float DEFAULT NULL,
  `custom_var_k1` varchar(50) DEFAULT NULL,
  `custom_var_v1` varchar(50) DEFAULT NULL,
  `custom_var_k2` varchar(50) DEFAULT NULL,
  `custom_var_v2` varchar(50) DEFAULT NULL,
  `custom_var_k3` varchar(50) DEFAULT NULL,
  `custom_var_v3` varchar(50) DEFAULT NULL,
  `custom_var_k4` varchar(50) DEFAULT NULL,
  `custom_var_v4` varchar(50) DEFAULT NULL,
  `custom_var_k5` varchar(50) DEFAULT NULL,
  `custom_var_v5` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idvisit`,`idgoal`),
  KEY `index_idsite_datetime` (`idsite`,`server_time`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_log_conversion`
--


--
-- Table structure for table `piwik_log_link_visit_action`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_log_link_visit_action` (
  `idlink_va` int(11) NOT NULL AUTO_INCREMENT,
  `idsite` int(10) unsigned NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `server_time` datetime NOT NULL,
  `idvisit` int(10) unsigned NOT NULL,
  `idaction_url` int(10) unsigned NOT NULL,
  `idaction_url_ref` int(10) unsigned NOT NULL,
  `idaction_name` int(10) unsigned DEFAULT NULL,
  `idaction_name_ref` int(10) unsigned NOT NULL,
  `time_spent_ref_action` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idlink_va`),
  KEY `index_idvisit` (`idvisit`),
  KEY `index_idsite_servertime` (`idsite`,`server_time`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_log_link_visit_action`
--


--
-- Table structure for table `piwik_log_profiling`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_log_profiling` (
  `query` text NOT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `sum_time_ms` float DEFAULT NULL,
  UNIQUE KEY `query` (`query`(100))
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_log_profiling`
--


--
-- Table structure for table `piwik_log_visit`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_log_visit` (
  `idvisit` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idsite` int(10) unsigned NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `visitor_localtime` time NOT NULL,
  `visitor_returning` tinyint(1) NOT NULL,
  `visitor_count_visits` smallint(5) unsigned NOT NULL,
  `visitor_days_since_last` smallint(5) unsigned NOT NULL,
  `visitor_days_since_first` smallint(5) unsigned NOT NULL,
  `visit_first_action_time` datetime NOT NULL,
  `visit_last_action_time` datetime NOT NULL,
  `visit_exit_idaction_url` int(11) unsigned NOT NULL,
  `visit_exit_idaction_name` int(11) unsigned NOT NULL,
  `visit_entry_idaction_url` int(11) unsigned NOT NULL,
  `visit_entry_idaction_name` int(11) unsigned NOT NULL,
  `visit_total_actions` smallint(5) unsigned NOT NULL,
  `visit_total_time` smallint(5) unsigned NOT NULL,
  `visit_goal_converted` tinyint(1) NOT NULL,
  `referer_type` tinyint(1) unsigned DEFAULT NULL,
  `referer_name` varchar(70) DEFAULT NULL,
  `referer_url` text NOT NULL,
  `referer_keyword` varchar(255) DEFAULT NULL,
  `config_id` binary(8) NOT NULL,
  `config_os` char(3) NOT NULL,
  `config_browser_name` varchar(10) NOT NULL,
  `config_browser_version` varchar(20) NOT NULL,
  `config_resolution` varchar(9) NOT NULL,
  `config_pdf` tinyint(1) NOT NULL,
  `config_flash` tinyint(1) NOT NULL,
  `config_java` tinyint(1) NOT NULL,
  `config_director` tinyint(1) NOT NULL,
  `config_quicktime` tinyint(1) NOT NULL,
  `config_realplayer` tinyint(1) NOT NULL,
  `config_windowsmedia` tinyint(1) NOT NULL,
  `config_gears` tinyint(1) NOT NULL,
  `config_silverlight` tinyint(1) NOT NULL,
  `config_cookie` tinyint(1) NOT NULL,
  `location_ip` int(10) unsigned NOT NULL,
  `location_browser_lang` varchar(20) NOT NULL,
  `location_country` char(3) NOT NULL,
  `location_continent` char(3) NOT NULL,
  `custom_var_k1` varchar(50) DEFAULT NULL,
  `custom_var_v1` varchar(50) DEFAULT NULL,
  `custom_var_k2` varchar(50) DEFAULT NULL,
  `custom_var_v2` varchar(50) DEFAULT NULL,
  `custom_var_k3` varchar(50) DEFAULT NULL,
  `custom_var_v3` varchar(50) DEFAULT NULL,
  `custom_var_k4` varchar(50) DEFAULT NULL,
  `custom_var_v4` varchar(50) DEFAULT NULL,
  `custom_var_k5` varchar(50) DEFAULT NULL,
  `custom_var_v5` varchar(50) DEFAULT NULL,
  `location_provider` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idvisit`),
  KEY `index_idsite_idvisit` (`idsite`,`idvisit`),
  KEY `index_idsite_datetime_config` (`idsite`,`visit_last_action_time`,`config_id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_log_visit`
--


--
-- Table structure for table `piwik_logger_api_call`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_logger_api_call` (
  `idlogger_api_call` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) DEFAULT NULL,
  `method_name` varchar(255) DEFAULT NULL,
  `parameter_names_default_values` text,
  `parameter_values` text,
  `execution_time` float DEFAULT NULL,
  `caller_ip` int(10) unsigned DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `returned_value` text,
  PRIMARY KEY (`idlogger_api_call`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_logger_api_call`
--


--
-- Table structure for table `piwik_logger_error`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_logger_error` (
  `idlogger_error` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT NULL,
  `message` text,
  `errno` int(10) unsigned DEFAULT NULL,
  `errline` int(10) unsigned DEFAULT NULL,
  `errfile` varchar(255) DEFAULT NULL,
  `backtrace` text,
  PRIMARY KEY (`idlogger_error`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_logger_error`
--


--
-- Table structure for table `piwik_logger_exception`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_logger_exception` (
  `idlogger_exception` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT NULL,
  `message` text,
  `errno` int(10) unsigned DEFAULT NULL,
  `errline` int(10) unsigned DEFAULT NULL,
  `errfile` varchar(255) DEFAULT NULL,
  `backtrace` text,
  PRIMARY KEY (`idlogger_exception`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_logger_exception`
--


--
-- Table structure for table `piwik_logger_message`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_logger_message` (
  `idlogger_message` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`idlogger_message`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_logger_message`
--


--
-- Table structure for table `piwik_option`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_option` (
  `option_name` varchar(255) NOT NULL,
  `option_value` longtext NOT NULL,
  `autoload` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option_name`),
  KEY `autoload` (`autoload`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_option`
--

INSERT INTO `piwik_option` VALUES ('version_core','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('SitesManager_DefaultTimezone','Asia/Calcutta',0);
INSERT INTO `piwik_option` VALUES ('version_CorePluginsAdmin','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_CoreAdminHome','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_CoreHome','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Proxy','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_API','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Widgetize','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_LanguagesManager','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Actions','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Dashboard','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_MultiSites','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Referers','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_UserSettings','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Goals','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_SEO','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_UserCountry','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_VisitsSummary','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_VisitFrequency','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_VisitTime','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_VisitorInterest','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_ExampleAPI','0.1',1);
INSERT INTO `piwik_option` VALUES ('version_ExamplePlugin','0.1',1);
INSERT INTO `piwik_option` VALUES ('version_ExampleRssWidget','0.1',1);
INSERT INTO `piwik_option` VALUES ('version_ExampleFeedburner','0.1',1);
INSERT INTO `piwik_option` VALUES ('version_Provider','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Feedback','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Login','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_UsersManager','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_SitesManager','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Installation','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_CoreUpdater','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_PDFReports','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_UserCountryMap','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_Live','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('version_CustomVariables','1.2.1',1);
INSERT INTO `piwik_option` VALUES ('UpdateCheck_LastTimeChecked','1301302400',1);
INSERT INTO `piwik_option` VALUES ('UpdateCheck_LatestVersion','1.2.1',0);

--
-- Table structure for table `piwik_pdf`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_pdf` (
  `idreport` int(11) NOT NULL AUTO_INCREMENT,
  `idsite` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `period` varchar(10) DEFAULT NULL,
  `email_me` tinyint(4) DEFAULT NULL,
  `additional_emails` text,
  `reports` text NOT NULL,
  `ts_created` timestamp NULL DEFAULT NULL,
  `ts_last_sent` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idreport`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_pdf`
--


--
-- Table structure for table `piwik_site`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_site` (
  `idsite` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `main_url` varchar(255) NOT NULL,
  `ts_created` timestamp NULL DEFAULT NULL,
  `timezone` varchar(50) NOT NULL,
  `currency` char(3) NOT NULL,
  `excluded_ips` text NOT NULL,
  `excluded_parameters` varchar(255) NOT NULL,
  `group` varchar(250) NOT NULL,
  `feedburnerName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idsite`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_site`
--

INSERT INTO `piwik_site` VALUES (1,'Playdorm','http://taashtime.com',NOW(),'Asia/Calcutta','INR','','','',NULL);

--
-- Table structure for table `piwik_site_url`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_site_url` (
  `idsite` int(10) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`idsite`,`url`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_site_url`
--


--
-- Table structure for table `piwik_user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_user` (
  `login` varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  `alias` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token_auth` char(32) NOT NULL,
  `date_registered` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `uniq_keytoken` (`token_auth`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_user`
--

INSERT INTO `piwik_user` VALUES ('anonymous','','anonymous','noreply@taashtime.com','anonymous',NOW());

--
-- Table structure for table `piwik_user_dashboard`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_user_dashboard` (
  `login` varchar(100) NOT NULL,
  `iddashboard` int(11) NOT NULL,
  `layout` text NOT NULL,
  PRIMARY KEY (`login`,`iddashboard`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_user_dashboard`
--


--
-- Table structure for table `piwik_user_language`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piwik_user_language` (
  `login` varchar(100) NOT NULL,
  `language` varchar(10) NOT NULL,
  PRIMARY KEY (`login`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piwik_user_language`
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-03-28 14:23:30