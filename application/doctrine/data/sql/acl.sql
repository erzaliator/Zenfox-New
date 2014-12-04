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

-- Deleting the data from the tables

DELETE FROM `roles`;ALTER TABLE `roles` AUTO_INCREMENT = 1;
DELETE FROM `resources`;ALTER TABLE `resources` AUTO_INCREMENT = 1;
DELETE FROM `privileges`;ALTER TABLE `privileges` AUTO_INCREMENT = 1;

SELECT "DELETED EVERYThING";

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` VALUES (1,'visitor','VISITOR',-1,'Visitor Role');
INSERT INTO `roles` VALUES (2,'player','PLAYER',1,'Player Role');
INSERT INTO `roles` VALUES (3,'affiliate','AFFILIATE',1,'Affiliate Role');
INSERT INTO `roles` VALUES (4,'csr','CSR',1,'Admin Role');
INSERT INTO `roles` VALUES (5,'supercsr','CSR',4,'Admin Technical Group Role');

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` VALUES (1,'player','REQUEST',-1,'Player Module');
INSERT INTO `resources` VALUES (2,'player-index','REQUEST',1,'Player Module Index Controller');
INSERT INTO `resources` VALUES (3,'player-index-index','REQUEST',2,'Player Module Index Controller Index Action');
INSERT INTO `resources` VALUES (4,'player-home','REQUEST',1,'Player Module Home Controller');
INSERT INTO `resources` VALUES (5,'player-home-index','REQUEST',4,'Player Module Home Controller Index Action');
INSERT INTO `resources` VALUES (6,'admin','REQUEST',-1,'Admin Module');
INSERT INTO `resources` VALUES (7,'admin-index','REQUEST',6,'Admin Module Index Controller');
INSERT INTO `resources` VALUES (8,'admin-index-index','REQUEST',7,'Admin Module Index Controller Index Action');
INSERT INTO `resources` VALUES (9,'admin-home','REQUEST',6,'Admin Module Home Controller');
INSERT INTO `resources` VALUES (10,'admin-home-index','REQUEST',9,'Admin Module Home Controller Index Action');
INSERT INTO `resources` VALUES (11,'admin-auth','REQUEST',6,'Admin Module Auth Controller');
INSERT INTO `resources` VALUES (12,'admin-auth-login','REQUEST',11,'Admin Module Auth Controller Login Action');
INSERT INTO `resources` VALUES (13,'admin-auth-logout','REQUEST',11,'Admin Module Auth Controller Logout Action');
INSERT INTO `resources` VALUES (14,'admin-auth-signup','REQUEST',11,'Admin Module Auth Controller Signup Action');
INSERT INTO `resources` VALUES (15,'player-auth','REQUEST',1,'Player Module Auth Controller');
INSERT INTO `resources` VALUES (16,'player-auth-login','REQUEST',15,'Player Module Auth Controller Login Action');
INSERT INTO `resources` VALUES (17,'player-auth-logout','REQUEST',15,'Player Module Auth Controller Logout Action');
INSERT INTO `resources` VALUES (18,'player-ticket','REQUEST',1,'Player Module Ticket Controller');
INSERT INTO `resources` VALUES (19,'player-ticket-create','REQUEST',18,'Player Module Ticket Controller Create Action');
INSERT INTO `resources` VALUES (20,'player-auth-signup','REQUEST',15,'Player Module Auth Controller SignUp Action');
INSERT INTO `resources` VALUES (21,'player-ticket-view','REQUEST',18,'Player Module Ticket Controller View Action');
INSERT INTO `resources` VALUES (22,'player-ticket-show','REQUEST',18,'Player Module Ticket Controller Show Action');
INSERT INTO `resources` VALUES (23,'player-ticket-reply','REQUEST',18,'Player Module Ticket Controller Reply Action');
INSERT INTO `resources` VALUES (24,'admin-ticket','REQUEST',6,'Admin Module Ticket Controller');
INSERT INTO `resources` VALUES (25,'admin-ticket-view','REQUEST',24,'Admin Module Ticket Controller View Action');
INSERT INTO `resources` VALUES (26,'admin-ticket-show','REQUEST',24,'Admin Module Ticket Controller Show Action');
INSERT INTO `resources` VALUES (27,'admin-ticket-conversation','REQUEST',24,'Admin Module Ticket Controller Conversation Action');
INSERT INTO `resources` VALUES (28,'admin-ticket-create','REQUEST',24,'Admin Module Ticket Controller Create Action');
INSERT INTO `resources` VALUES (29,'admin-ticket-reply','REQUEST',24,'Admin Module Ticket Controller Reply Action');
INSERT INTO `resources` VALUES (30,'player-roulette','REQUEST',1,'Player Module Roulette Controller');
INSERT INTO `resources` VALUES (31,'player-roulette-index','REQUEST',30,'Player Module Roulette Controller Index Action');
INSERT INTO `resources` VALUES (32,'player-reconciliation','REQUEST',1,'Player Module Reconciliation Controller');
INSERT INTO `resources` VALUES (33,'player-reconciliation-index','REQUEST',32,'Player Module Reconciliation Controller Index Action');
INSERT INTO `resources` VALUES (34,'admin-auth-registration','REQUEST',11,'Admin Module Auth Controller Registration Action');
INSERT INTO `resources` VALUES (35,'player-auth-registration','REQUEST',15,'Player Module Auth Controller Registration Action');
INSERT INTO `resources` VALUES (36,'player-gaming','REQUEST',1,'Player Module Gaming Controller');
INSERT INTO `resources` VALUES (37,'player-gaming-index','REQUEST',36,'Player Module Gaming Controller Index Action');
INSERT INTO `resources` VALUES (38,'admin-rouletteconfig','REQUEST',6,'Admin Module Rouletteconfig Controller');
INSERT INTO `resources` VALUES (39,'admin-rouletteconfig-view','REQUEST',38,'Admin Module Rouletteconfig Controller View Action');
INSERT INTO `resources` VALUES (40,'admin-rouletteconfig-edit','REQUEST',38,'Admin Module Rouletteconfig Controller Edit Action');
INSERT INTO `resources` VALUES (41,'admin-rouletteconfig-create','REQUEST',38,'Admin Module Rouletteconfig Controller Create Action');
INSERT INTO `resources` VALUES (42,'player-auth-edit','REQUEST',15,'Player Module Auth Controller Edit Action');
INSERT INTO `resources` VALUES (43,'player-auth-view','REQUEST',15,'Player Module Auth Controller View Action');
INSERT INTO `resources` VALUES (44,'player-auth-changepwd','REQUEST',15,'Player Module Auth Controller Change Password Action');
INSERT INTO `resources` VALUES (45,'admin-slotconfig','REQUEST',6,'Admin Module Slotconfig Controller');
INSERT INTO `resources` VALUES (46,'admin-slotconfig-view','REQUEST',45,'Admin Module Slotconfig Controller View Action');
INSERT INTO `resources` VALUES (47,'admin-slotconfig-edit','REQUEST',45,'Admin Module Slotconfig Controller Edit Action');
INSERT INTO `resources` VALUES (48,'admin-slotconfig-create','REQUEST',45,'Admin Module Slotconfig Controller Create Action');
INSERT INTO `resources` VALUES (49,'admin-bingo','REQUEST',6,'Admin Module Bingo Controller');
INSERT INTO `resources` VALUES (50,'admin-bingo-create','REQUEST',49,'Admin Module Bingo Controller Create Action');
INSERT INTO `resources` VALUES (51,'admin-bingo-edit','REQUEST',49,'Admin Module Bingo Controller Edit Action');
INSERT INTO `resources` VALUES (52,'admin-bingo-process','REQUEST',49,'Admin Module Bingo Controller Process Action');
INSERT INTO `resources` VALUES (53,'admin-bingo-view','REQUEST',49,'Admin Module Bingo Controller View Action');
INSERT INTO `resources` VALUES (54,'admin-searching','REQUEST',6,'Admin Module Searching Controller');
INSERT INTO `resources` VALUES (55,'admin-searching-index','REQUEST',54,'Admin Module Searching Controller Index Action');
INSERT INTO `resources` VALUES (56,'admin-bonus','REQUEST',6,'Admin Module Bonus Controller');
INSERT INTO `resources` VALUES (57,'admin-bonus-create','REQUEST',56,'Admin Module Bonus Controller Create Action');
INSERT INTO `resources` VALUES (58,'admin-bonus-view','REQUEST',56,'Admin Module Bonus Controller View Action');
INSERT INTO `resources` VALUES (59,'admin-bonus-edit','REQUEST',56,'Admin Module Bonus Controller Edit Action');
INSERT INTO `resources` VALUES (60,'admin-bonus-process','REQUEST',56,'Admin Module Bonus Controller Process Action');
INSERT INTO `resources` VALUES (61,'admin-error','REQUEST',6,'Admin Module Error Controller');
INSERT INTO `resources` VALUES (62,'admin-error-error','REQUEST',61,'Admin Module Error Controller Error Action');
INSERT INTO `resources` VALUES (63,'admin-frontend','REQUEST',6,'Admin Module Frontend Controller');
INSERT INTO `resources` VALUES (64,'admin-frontend-create','REQUEST',63,'Admin Module Frontend Controller Create Action');
INSERT INTO `resources` VALUES (65,'admin-frontend-view','REQUEST',63,'Admin Module Frontend Controller View Action');
INSERT INTO `resources` VALUES (66,'admin-frontend-edit','REQUEST',63,'Admin Module Frontend Controller Edit Action');
INSERT INTO `resources` VALUES (67,'admin-frontend-viewdetails','REQUEST',63,'Admin Module Frontend Controller Viewdetails Action');
INSERT INTO `resources` VALUES (68,'admin-keno','REQUEST',6,'Admin Module Keno Controller');
INSERT INTO `resources` VALUES (69,'admin-keno-create','REQUEST',68,'Admin Module Keno Controller Create Action');
INSERT INTO `resources` VALUES (70,'admin-keno-view','REQUEST',68,'Admin Module Keno Controller View Action');
INSERT INTO `resources` VALUES (71,'admin-keno-edit','REQUEST',68,'Admin Module Keno Controller Edit Action');
INSERT INTO `resources` VALUES (72,'admin-keno-viewdetails','REQUEST',68,'Admin Module Keno Controller Viewdetails Action');
INSERT INTO `resources` VALUES (73,'admin-keno-process','REQUEST',68,'Admin Module Keno Controller Process Action');
INSERT INTO `resources` VALUES (74,'admin-privilege','REQUEST',6,'Admin Module Privilege Controller');
INSERT INTO `resources` VALUES (75,'admin-privilege-create','REQUEST',73,'Admin Module Privilege Controller Create Action');
INSERT INTO `resources` VALUES (76,'admin-privilege-view','REQUEST',73,'Admin Module Privilege Controller View Action');
INSERT INTO `resources` VALUES (77,'admin-privilege-edit','REQUEST',73,'Admin Module Privilege Controller Edit Action');
INSERT INTO `resources` VALUES (78,'admin-privilege-viewdetails','REQUEST',73,'Admin Module Privilege Controller Viewdetails Action');
INSERT INTO `resources` VALUES (79,'admin-resource','REQUEST',6,'Admin Module Resource Controller');
INSERT INTO `resources` VALUES (80,'admin-resource-create','REQUEST',79,'Admin Module Resource Controller Create Action');
INSERT INTO `resources` VALUES (81,'admin-resource-view','REQUEST',79,'Admin Module Resource Controller View Action');
INSERT INTO `resources` VALUES (82,'admin-resource-edit','REQUEST',79,'Admin Module Resource Controller Edit Action');
INSERT INTO `resources` VALUES (83,'admin-resource-viewdetails','REQUEST',79,'Admin Module Resource Controller Viewdetails Action');
INSERT INTO `resources` VALUES (84,'admin-role','REQUEST',6,'Admin Module Role Controller');
INSERT INTO `resources` VALUES (85,'admin-role-create','REQUEST',84,'Admin Module Role Controller Create Action');
INSERT INTO `resources` VALUES (86,'admin-role-view','REQUEST',84,'Admin Module Role Controller View Action');
INSERT INTO `resources` VALUES (87,'admin-role-edit','REQUEST',84,'Admin Module Role Controller Edit Action');
INSERT INTO `resources` VALUES (88,'admin-role-viewdetails','REQUEST',84,'Admin Module Role Controller Viewdetails Action');
INSERT INTO `resources` VALUES (89,'admin-searching-edit','REQUEST',54,'Admin Module Searching Controller Edit Action');
INSERT INTO `resources` VALUES (90,'player-keno','REQUEST',1,'Player Module Keno Controller');
INSERT INTO `resources` VALUES (91,'player-keno-index','REQUEST',90,'Player Module Keno Controller Index Action');
INSERT INTO `resources` VALUES (92,'player-banking','REQUEST',1,'Player Module Banking Controller');
INSERT INTO `resources` VALUES (93,'player-banking-fundbonus','REQUEST',92,'Player Module Banking Controller Fundbonus Action');
INSERT INTO `resources` VALUES (94,'player-roulette-gamelog','REQUEST',30,'Player Module Roulette Controller Gamelog Action');
INSERT INTO `resources` VALUES (95,'player-keno-gamelog','REQUEST',90,'Player Module Keno Controller Gamelog Action');
INSERT INTO `resources` VALUES (96,'player-error','REQUEST',1,'Player Module Error Controller');
INSERT INTO `resources` VALUES (97,'player-error-error','REQUEST',96,'Player Module Error Controller Error Action');
INSERT INTO `resources` VALUES (98,'player-kenologdetails','REQUEST',1,'Player Module Kenologdetails Controller');
INSERT INTO `resources` VALUES (99,'player-kenologdetails-index','REQUEST',98,'Player Module Kenologdetails Controller Index Action');
INSERT INTO `resources` VALUES (100,'player-game','REQUEST',1,'Player Module Game Controller');
INSERT INTO `resources` VALUES (101,'player-game-index','REQUEST',100,'Player Module Game Controller Index Action');
INSERT INTO `resources` VALUES (102,'player-game-game','REQUEST',100,'Player Module Game Controller Game Action');
INSERT INTO `resources` VALUES (103,'player-facebook','REQUEST',1,'Player Module Facebook Controller');
INSERT INTO `resources` VALUES (104,'player-facebook-index','REQUEST',103,'Player Module Facebook Controller Index Action');
INSERT INTO `resources` VALUES (105,'player-banking-index','REQUEST',92,'Player Module Banking Controller Index Action');
INSERT INTO `resources` VALUES (106,'player-auth-confirm','REQUEST',15,'Player Module Auth Controller Confirm Action');
INSERT INTO `resources` VALUES (107,'player-auth-forgotpassword','REQUEST',15,'Player Module Auth Controller Forgotpassword Action');
INSERT INTO `resources` VALUES (108,'player-auth-resetpassword','REQUEST',15,'Player Module Auth Controller resetpassword Action');
INSERT INTO `resources` VALUES (109,'player-withdrawal','REQUEST',1,'Player Module Withdrawal Controller');
INSERT INTO `resources` VALUES (110,'player-withdrawal-index','REQUEST',106,'Player Module Withdrawal Controller Index Action');
INSERT INTO `resources` VALUES (111,'player-withdrawal-request','REQUEST',106,'Player Module Withdrawal Controller Request Action');
INSERT INTO `resources` VALUES (112,'admin-withdrawal','REQUEST',6,'Admin Module Withdrawal Controller');
INSERT INTO `resources` VALUES (113,'admin-withdrawal-index','REQUEST',109,'Admin Module Withdrawal Controller Index Action');
INSERT INTO `resources` VALUES (114,'admin-withdrawal-listall','REQUEST',109,'Admin Module Withdrawal Controller Listall Action');
INSERT INTO `resources` VALUES (115,'admin-withdrawal-listdetails','REQUEST',109,'Admin Module Withdrawal Controller Listdetails Action');
INSERT INTO `resources` VALUES (116,'player-withdrawal-listdetails','REQUEST',106,'Player Module Withdrawal Controller ListDetails Action');
INSERT INTO `resources` VALUES (117,'player-withdrawal-listall','REQUEST',106,'Player Module Withdrawal Controller Listall Action');
INSERT INTO `resources` VALUES (118,'player-withdrawal-listunprocessed','REQUEST',106,'Player Module Withdrawal Controller ListUnprocessed Action');
INSERT INTO `resources` VALUES (119,'player-withdrawal-insertflowback','REQUEST',106,'Player Module Withdrawal Controller InsertFlowback Action');
INSERT INTO `resources` VALUES (120,'admin-system','REQUEST',6,'Admin Module System Controller');
INSERT INTO `resources` VALUES (121,'admin-system-getreport','REQUEST',120,'Admin Module System Controller Getreport Action');
INSERT INTO `resources` VALUES (122,'admin-template','REQUEST',6,'Admin Module Template Controller');
INSERT INTO `resources` VALUES (123,'admin-template-listall','REQUEST',122,'Admin Module Template Controller Listall Action');
INSERT INTO `resources` VALUES (124,'admin-template-listalltags','REQUEST',122,'Admin Module Template Controller Listalltags Action');
INSERT INTO `resources` VALUES (125,'player-comments','REQUEST',1,'Player Module Comments Controller');
INSERT INTO `resources` VALUES (126,'player-comments-index','REQUEST',125,'Player Module Comments Controller Index Action');
INSERT INTO `resources` VALUES (127,'admin-comments','REQUEST',6,'Admin Module Comments Controller');
INSERT INTO `resources` VALUES (128,'admin-comments-showall','REQUEST',127,'Admin Module Comments Controller Showall Action');
INSERT INTO `resources` VALUES (129,'admin-comments-status','REQUEST',127,'Admin Module Comments Controller Delete Action');
INSERT INTO `resources` VALUES (130,'admin-comments-show','REQUEST',127,'Admin Module Comments Controller Show Action');
INSERT INTO `resources` VALUES (131,'player-comments-show','REQUEST',125,'Player Module Comments Controller Show Action');
INSERT INTO `resources` VALUES (132,'admin-system-download','REQUEST',120,'Admin Module System Controller Download Action');
INSERT INTO `resources` VALUES (133,'player-slot','REQUEST',1,'Player Module Slot Controller');
INSERT INTO `resources` VALUES (134,'player-slot-gamelog','REQUEST',133,'Player Module Slot Controller Gamelog Action');
INSERT INTO `resources` VALUES (135,'player-roulettelogdetails','REQUEST',1,'Player Module Roulettelogdetails Controller');
INSERT INTO `resources` VALUES (136,'player-roulettelogdetails-index','REQUEST',135,'Player Module Roulettelogdetails Controller Index Action');
INSERT INTO `resources` VALUES (137,'player-slotlogdetails','REQUEST',1,'Player Module Slotlogdetails Controller');
INSERT INTO `resources` VALUES (138,'player-slotlogdetails-index','REQUEST',137,'Player Module Slotlogdetails Controller Index Action');
INSERT INTO `resources` VALUES (139,'admin-admin','REQUEST',6,'Admin Module Admin Controller');
INSERT INTO `resources` VALUES (140,'admin-admin-listallcsrs','REQUEST',139,'Admin Module Admin Controller Listallcsrs Action');
INSERT INTO `resources` VALUES (141,'admin-bingosession','REQUEST',6,'Admin Module Bingosession Controller');
INSERT INTO `resources` VALUES (142,'admin-bingosession-create','REQUEST',141,'Admin Module Bingosession Controller Create Action');
INSERT INTO `resources` VALUES (143,'admin-bingosession-view','REQUEST',141,'Admin Module Bingosession Controller View Action');
INSERT INTO `resources` VALUES (144,'admin-bingosession-edit','REQUEST',141,'Admin Module Bingosession Controller Edit Action');
INSERT INTO `resources` VALUES (145,'admin-bingorooms','REQUEST',6,'Admin Module Bingorooms Controller');
INSERT INTO `resources` VALUES (146,'admin-bingorooms-create','REQUEST',145,'Admin Module Bingorooms Controller Create Action');
INSERT INTO `resources` VALUES (147,'admin-bingorooms-process','REQUEST',145,'Admin Module Bingorooms Controller Process Action');
INSERT INTO `resources` VALUES (148,'admin-bingorooms-view','REQUEST',145,'Admin Module Bingorooms Controller View Action');
INSERT INTO `resources` VALUES (149,'admin-bingorooms-edit','REQUEST',145,'Admin Module Bingorooms Controller Edit Action');
INSERT INTO `resources` VALUES (150,'affiliate','REQUEST',-1,'Affiliate Module');
INSERT INTO `resources` VALUES (151,'affiliate-auth','REQUEST',150,'Affiliate Module Auth Controller');
INSERT INTO `resources` VALUES (152,'affiliate-auth-signup','REQUEST',151,'Affiliate Module Auth Controller Signup Action');
INSERT INTO `resources` VALUES (153,'affiliate-auth-login','REQUEST',151,'Affiliate Module Auth Controller Login Action');
INSERT INTO `resources` VALUES (154,'affiliate-auth-logout','REQUEST',151,'Affiliate Module Auth Controller Logout Action');
INSERT INTO `resources` VALUES (155,'affiliate-home','REQUEST',150,'Affiliate Module Home Controller');
INSERT INTO `resources` VALUES (156,'affiliate-home-index','REQUEST',155,'Affiliate Module Home Controller Index Action');
INSERT INTO `resources` VALUES (157,'player-facebookauth','REQUEST',1,'Player Module Facebookauth Controller');
INSERT INTO `resources` VALUES (158,'player-facebookauth-auth','REQUEST',157,'Player Module Facebookauth Controller Auth Action');
INSERT INTO `resources` VALUES (159,'player-auth-facebooklogin','REQUEST',15,'Player Module Auth Controller Facebooklogin Action');
INSERT INTO `resources` VALUES (160,'player-game-json','REQUEST',100,'Player Module Game Controller Json Action');
INSERT INTO `resources` VALUES (161,'player-content','REQUEST',1,'Player Module Contents Controller');
INSERT INTO `resources` VALUES (162,'player-content-terms','REQUEST',161,'Player Module Contents Controller Termsncondition Action');
INSERT INTO `resources` VALUES (163,'player-content-privacypolicy','REQUEST',161,'Player Module Contents Controller Privacypolicy Action');
INSERT INTO `resources` VALUES (164,'player-index-winner','REQUEST',2,'Player Module Index Controller Winner Action');
INSERT INTO `resources` VALUES (165,'player-help','REQUEST',1,'Player Module Help Controller');
INSERT INTO `resources` VALUES (166,'player-help-index','REQUEST',165,'Player Module Help Controller Index Action');
INSERT INTO `resources` VALUES (167,'player-help-display','REQUEST',165,'Player Module Help Controller Display Action');
INSERT INTO `resources` VALUES (168,'player-coupon','REQUEST',1,'Player Module Coupon Controller');
INSERT INTO `resources` VALUES (169,'player-coupon-redeem','REQUEST',168,'Player Module Coupon Controller Index Action');
INSERT INTO `resources` VALUES (170,'affiliate-tracker','REQUEST',150,'Affiliate Module Tracker Controller');
INSERT INTO `resources` VALUES (171,'affiliate-tracker-create','REQUEST',170,'Affiliate Module Tracker Controller Create Action');
INSERT INTO `resources` VALUES (172,'affiliate-tracker-view','REQUEST',170,'Affiliate Module Tracker Controller View Action');
INSERT INTO `resources` VALUES (173,'affiliate-tracker-edit','REQUEST',170,'Affiliate Module Tracker Controller Edit Action');
INSERT INTO `resources` VALUES (174,'affiliate-tracker-trackerdetails','REQUEST',170,'Affiliate Module Tracker Controller Trackerdetails Action');
INSERT INTO `resources` VALUES (175,'affiliate-tracker-alltrackers','REQUEST',170,'Affiliate Module Tracker Controller Alltrackers Action');
INSERT INTO `resources` VALUES (176,'affiliate-transaction','REQUEST',150,'Affiliate Module Transaction Controller');
INSERT INTO `resources` VALUES (177,'affiliate-transaction-index','REQUEST',176,'Affiliate Module Transaction Controller Index Action');
INSERT INTO `resources` VALUES (178,'affiliate-auth-view','REQUEST',155,'Affiliate Module Home Controller View Action');
INSERT INTO `resources` VALUES (179,'affiliate-auth-edit','REQUEST',155,'Affiliate Module Home Controller Edit Action');
INSERT INTO `resources` VALUES (180,'affiliate-auth-changepassword','REQUEST',155,'Affiliate Module Home Controller Changepassword Action');
INSERT INTO `resources` VALUES (181,'affiliate-ticket','REQUEST',150,'Affiliate Module Ticket Controller');
INSERT INTO `resources` VALUES (182,'affiliate-ticket-create','REQUEST',181,'Affiliate Module Ticket Controller Create Action');
INSERT INTO `resources` VALUES (183,'affiliate-ticket-view','REQUEST',181,'Affiliate Module Ticket Controller View Action');
INSERT INTO `resources` VALUES (184,'affiliate-ticket-reply','REQUEST',181,'Affiliate Module Ticket Controller Reply Action');
INSERT INTO `resources` VALUES (185,'affiliate-earnings','REQUEST',150,'Affiliate Module Earnings Controller');
INSERT INTO `resources` VALUES (186,'affiliate-earnings-summary','REQUEST',185,'Affiliate Module Earnings Controller Summary Action');
INSERT INTO `resources` VALUES (187,'affiliate-index','REQUEST',150,'Affiliate Module Index Controller');
INSERT INTO `resources` VALUES (188,'affiliate-index-index','REQUEST',187,'Affiliate Module Index Controller Index Action');
INSERT INTO `resources` VALUES (189,'affiliate-banner','REQUEST',150,'Affiliate Module Banner Controller');
INSERT INTO `resources` VALUES (190,'affiliate-banner-index','REQUEST',189,'Affiliate Module Banner Controller Index Action');
INSERT INTO `resources` VALUES (191,'admin-reconciliation','REQUEST',6,'Admin Module Reconciliation Controller');
INSERT INTO `resources` VALUES (192,'admin-reconciliation-index','REQUEST',191,'Admin Module Reconciliation Controller Index Action');
INSERT INTO `resources` VALUES (193,'admin-player','REQUEST',6,'Admin Module Player Controller');
INSERT INTO `resources` VALUES (194,'admin-player-index','REQUEST',193,'Admin Module Player Controller Index Action');
INSERT INTO `resources` VALUES (195,'admin-player-view','REQUEST',193,'Admin Module Player Controller View Action');
INSERT INTO `resources` VALUES (196,'admin-player-adjustbalance','REQUEST',193,'Admin Module Player Controller Adjustbalance Action');
INSERT INTO `resources` VALUES (197,'admin-player-creditbonus','REQUEST',193,'Admin Module Player Controller Creditbonus Action');
INSERT INTO `resources` VALUES (198,'admin-player-confirmplayer','REQUEST',193,'Admin Module Player Controller Confirmplayer Action');
INSERT INTO `resources` VALUES (199,'admin-player-edit','REQUEST',193,'Admin Module Player Controller Edit Action');
INSERT INTO `resources` VALUES (200,'player-transaction','REQUEST',1,'Player Module Transaction Controller');
INSERT INTO `resources` VALUES (201,'player-transaction-index','REQUEST',200,'Player Module Transaction Controller Index Action');
INSERT INTO `resources` VALUES (202,'player-transaction-confirm','REQUEST',200,'Player Module Transaction Controller Confirm Action');
INSERT INTO `resources` VALUES (203,'player-transaction-process','REQUEST',200,'Player Module Transaction Controller Process Action');
INSERT INTO `resources` VALUES (204,'affiliate-error','REQUEST',150,'Affiliate Module Error Controller');
INSERT INTO `resources` VALUES (205,'affiliate-error-error','REQUEST',204,'Affiliate Module Error Controller Error Action');
INSERT INTO `resources` VALUES (206,'player-banking-faq','REQUEST',92,'Player Banking Controller');
INSERT INTO `resources` VALUES (207,'player-content-legal','REQUEST',161,'Legalities page');
INSERT INTO `resources` VALUES (208,'player-content-rules','REQUEST',161,'Rules of the game page');
INSERT INTO `resources` VALUES (209,'player-content-contact','REQUEST',161,'Contact Page');
INSERT INTO `resources` VALUES (210,'player-content-withdrawterms','REQUEST',161,'Withdrawal Terms');
INSERT INTO `resources` VALUES (211,'player-index-sitemap','REQUEST',2,'Player Site Map');
INSERT INTO `resources` VALUES (212,'player-promotions','REQUEST',1,'Player Promotions');
INSERT INTO `resources` VALUES (213,'player-promotions-index','REQUEST',212,'Player Promotions');
INSERT INTO `resources` VALUES (214,'affiliate-tracker-graph','REQUEST',170,'Affiliate Tracker Graph');
INSERT INTO `resources` VALUES (215,'player-game-getsfslogin','REQUEST',100,'Get SFS login');
INSERT INTO `resources` VALUES (216,'affiliate-visit','REQUEST',150,'Affiliate Visits');
INSERT INTO `resources` VALUES (217,'affiliate-visit-index','REQUEST',216,'Affiliate Visit Summary');
INSERT INTO `resources` VALUES (218,'affiliate-scheme','REQUEST',150,'Affiliate Scheme');
INSERT INTO `resources` VALUES (219,'affiliate-scheme-details','REQUEST',218,'Affiliate Scheme Details');
INSERT INTO `resources` VALUES (220,'player-language','REQUEST',1,'Player Language');
INSERT INTO `resources` VALUES (221,'player-language-index','REQUEST',220,'Player Language');
INSERT INTO `resources` VALUES (222,'player-facebook-facebooklogin','REQUEST',103,'Player Module Facebook Controller Facebooklogin Action');
INSERT INTO `resources` VALUES (223,'player-facebook-game','REQUEST',103,'Player Module Facebook Controller Game Action');
INSERT INTO `resources` VALUES (224,'player-facebook-gameindex','REQUEST',103,'Player Module Facebook Controller Gameindex Action');
INSERT INTO `resources` VALUES (225,'player-facebook-sorry','REQUEST',103,'Player Module Facebook Controller Sorry Action');
INSERT INTO `resources` VALUES (226,'player-help-howtoplay','REQUEST',165,'Player Module Help Controller How to play Action');
INSERT INTO `resources` VALUES (227,'player-index-invite','REQUEST',2,'Invite Friends');
INSERT INTO `resources` VALUES (228,'player-auth-image','REQUEST',15,'Upload User Image');
INSERT INTO `resources` VALUES (229,'player-twitter','REQUEST',1,'Twitter Application');
INSERT INTO `resources` VALUES (230,'player-twitter-index','REQUEST',230,'Twitter Authentication');
INSERT INTO `resources` VALUES (231,'player-twitter-callback','REQUEST',230,'Twitter Callback Action');
INSERT INTO `resources` VALUES (232,'player-testimonial','REQUEST',1,'Player Testimonials');
INSERT INTO `resources` VALUES (233,'player-testimonial-index','REQUEST',232,'Show Testimonials');
INSERT INTO `resources` VALUES (234,'player-testimonial-write','REQUEST',232,'Write Testimonials');
INSERT INTO `resources` VALUES (235,'player-testimonial-view','REQUEST',232,'Show All Testimonials');
INSERT INTO `resources` VALUES (236,'player-banking-deposit','REQUEST',92,'Deposit Money');
INSERT INTO `resources` VALUES (237,'player-oauth','REQUEST',1,'Oath Protocol');
INSERT INTO `resources` VALUES (238,'player-oauth-index','REQUEST',237,'Player Oath Request');
INSERT INTO `resources` VALUES (239,'player-oauth-callback','REQUEST',237,'Oath Callback');
INSERT INTO `resources` VALUES (240,'player-oauth-authorize','REQUEST',237,'Oath Request Authorization');
INSERT INTO `resources` VALUES (241,'player-oauth-access','REQUEST',237,'Player Oath Access');
INSERT INTO `resources` VALUES (242,'player-oauth-post','REQUEST',237,'Post Winner Data');
INSERT INTO `resources` VALUES (243,'player-index-unsubscribe','REQUEST',2,'Unsubscribe Friends');
INSERT INTO `resources` VALUES (244,'affiliate-tracker-uniquevisitors','REQUEST',170,'Unique Visitors');
INSERT INTO `resources` VALUES (245,'affiliate-tracker-visitors','REQUEST',170,'Unique Visitors');
INSERT INTO `resources` VALUES (246,'player-faq','REQUEST',1,'Frequently Asked Question');
INSERT INTO `resources` VALUES (247,'player-faq-index','REQUEST',246,'Frequently Asked Question');
INSERT INTO `resources` VALUES (248,'player-affiliate','REQUEST',1,'Affiliate Page');
INSERT INTO `resources` VALUES (249,'player-affiliate-program','REQUEST',248,'Frequently Asked Question');
INSERT INTO `resources` VALUES (250,'player-content-about','REQUEST',161,'About Us Page');
INSERT INTO `resources` VALUES (251,'player-market','REQUEST',1,'Player Module Market Controller');
INSERT INTO `resources` VALUES (252,'player-market-index','REQUEST',251,'Player Module Market Controller Index Action');
INSERT INTO `resources` VALUES (253,'player-content-awards','REQUEST',161,'Awards Page');
INSERT INTO `resources` VALUES (254,'player-content-blog','REQUEST',161,'Blog Page');
INSERT INTO `resources` VALUES (255,'player-market-sell','REQUEST',251,'Player Module Market Controller Sell Action');
INSERT INTO `resources` VALUES (256,'player-market-gift','REQUEST',251,'Player Module Market Controller Gift Action');
INSERT INTO `resources` VALUES (257,'player-market-item','REQUEST',251,'Player Module Market Controller Item Action');
INSERT INTO `resources` VALUES (258,'player-market-buy','REQUEST',251,'Player Module Market Controller Buy Action');
INSERT INTO `resources` VALUES (259,'player-rediff','REQUEST',1,'Rediff Controller');
INSERT INTO `resources` VALUES (260,'player-rediff-index','REQUEST',259,'Rediff Integration');
INSERT INTO `resources` VALUES (261,'player-ibibo','REQUEST',1,'Ibibo Controller');
INSERT INTO `resources` VALUES (262,'player-ibibo-index','REQUEST',261,'Rediff Integration');
INSERT INTO `resources` VALUES (263,'player-app','REQUEST',1,'App Controller');
INSERT INTO `resources` VALUES (264,'player-app-index','REQUEST',263,'Applications Integration');
INSERT INTO `resources` VALUES (265,'player-market-use','REQUEST',251,'Used Market Items Action');
INSERT INTO `resources` VALUES (266,'player-game-quickjoin','REQUEST',100,'Quick Join');
INSERT INTO `resources` VALUES (267,'player-rummylog','REQUEST',1,'Rummy Logs');
INSERT INTO `resources` VALUES (268,'player-rummylog-index','REQUEST',267,'Rummy Logs');
INSERT INTO `resources` VALUES (269,'player-rummygamelog','REQUEST',1,'Rummy Game Logs');
INSERT INTO `resources` VALUES (270,'player-rummygamelog-index','REQUEST',269,'Rummy Game Logs');
INSERT INTO `resources` VALUES (271,'player-rummylog-log','REQUEST',267,'Rummy Logs');
INSERT INTO `resources` VALUES (272,'player-promotions-survey','REQUEST',212,'Player Survey');
INSERT INTO `resources` VALUES (273,'player-app-balance','REQUEST',263,'Applications Payment Method Integration');
INSERT INTO `resources` VALUES (274,'player-app-credit','REQUEST',263,'Applications Credit Conins Integration');
INSERT INTO `resources` VALUES (275,'admin-transaction','REQUEST',6,'Player Transaction Report');
INSERT INTO `resources` VALUES (276,'admin-transaction-allplayertransaction','REQUEST',275,'All Players Transaction Report');
INSERT INTO `resources` VALUES (277,'player-mol','REQUEST',1,'Mol API');
INSERT INTO `resources` VALUES (278,'player-mol-index','REQUEST',277,'Mol API');
INSERT INTO `resources` VALUES (279,'player-mol-response','REQUEST',277,'Mol API');
INSERT INTO `resources` VALUES (280,'player-faq-gameplay','REQUEST',246,'Frequently Asked Question');
INSERT INTO `resources` VALUES (281,'player-faq-technical','REQUEST',246,'Frequently Asked Question');
INSERT INTO `resources` VALUES (282,'player-faq-security','REQUEST',246,'Frequently Asked Question');
INSERT INTO `resources` VALUES (283,'player-index-reportbug','REQUEST',2,'Player Module Index Controller Reportbug Action');
INSERT INTO `resources` VALUES (284,'affiliate-report','REQUEST',150,'Affiliate Module Report Controller');
INSERT INTO `resources` VALUES (285,'affiliate-report-registration','REQUEST',284,'Affiliate Module Report Controller Registraion Action');
INSERT INTO `resources` VALUES (286,'affiliate-report-transaction','REQUEST',284,'Affiliate Module Report Controller Transaction Action');
INSERT INTO `resources` VALUES (287,'player-promotions-referfriend','REQUEST',212,'Player Promotions Refer Friends');
INSERT INTO `resources` VALUES (288,'player-tournament','REQUEST',1,'Player Tournament Controller');
INSERT INTO `resources` VALUES (289,'player-tournament-index','REQUEST',288,'Player Tournament Controller Index Action');
INSERT INTO `resources` VALUES (290,'player-tournament-register','REQUEST',288,'Player Tournament Controller Register Action');
INSERT INTO `resources` VALUES (291,'player-tournament-current','REQUEST',288,'Player Tournament Controller Current Action');
INSERT INTO `resources` VALUES (292,'player-tournament-list','REQUEST',288,'Player Tournament Controller List Action');
INSERT INTO `resources` VALUES (293,'player-tournament-desc','REQUEST',288,'Player Tournament Controller Description Action');
INSERT INTO `resources` VALUES (294,'player-tournament-result','REQUEST',288,'Player Tournament Controller Result Action');
INSERT INTO `resources` VALUES (295,'player-download','REQUEST',1,'Player Module Download Controller');
INSERT INTO `resources` VALUES (296,'player-download-index','REQUEST',295,'Player Module Download Controller Index Action');
INSERT INTO `resources` VALUES (297,'player-bingo','REQUEST',1,'Player Module Bingo Controller');
INSERT INTO `resources` VALUES (298,'player-bingo-index','REQUEST',297,'Player Module Bingo Controller Index Action');
INSERT INTO `resources` VALUES (299,'player-auth-reconfirm','REQUEST',15,'Player Module Auth Controller Reconfirm Action');
INSERT INTO `resources` VALUES (300,'player-game-allgame','REQUEST',100,'Player Module Game Controller All Game Action');
INSERT INTO `resources` VALUES (301,'player-withdrawal-verification','REQUEST',109,'Player Module Withdrawal Controller Verification Action');
INSERT INTO `resources` VALUES (302,'player-withdrawal-modify','REQUEST',109,'Player Module Withdrawal Controller Modify Action');
INSERT INTO `resources` VALUES (303,'player-banking-funcoins','REQUEST',92,'Player Module Banking Controller Funcoins Action');
INSERT INTO `resources` VALUES (304,'player-gamereport','REQUEST',1,'Player Module Gamereport Controller');
INSERT INTO `resources` VALUES (305,'player-gamereport-gamesplayed','REQUEST',304,'Player Module Gamereport Controller Gamesplayed Action');
INSERT INTO `resources` VALUES (306,'player-ticket-delete','REQUEST',18,'Player Module Ticket Controller Delete Action');
INSERT INTO `resources` VALUES (307,'player-auth-level','REQUEST',15,'Player Module Auth Controller Level Action');
INSERT INTO `resources` VALUES (308,'player-banking-detail','REQUEST',92,'Player Module Banking Controller Detail Action');
INSERT INTO `resources` VALUES (309,'player-promotions-special','REQUEST',212,'Player Special Promotions');
INSERT INTO `resources` VALUES (310,'player-index-mailresponse','REQUEST',2,'Player Module Index Controller Invite Action');
INSERT INTO `resources` VALUES (311,'player-bingo-bingo','REQUEST',297,'Player Module Bingo Controller Bingo Action');
INSERT INTO `resources` VALUES (312,'player-banking-freetoreal','REQUEST',92,'Player Module Banking Controller Freetoreal Action');
INSERT INTO `resources` VALUES (313,'player-bingo-prebuy','REQUEST',297,'Player Module Bingo Controller Prebuy Action');
INSERT INTO `resources` VALUES (314,'player-facebook-payment','REQUEST',103,'Player Module Facebook Controller Payment Action');
INSERT INTO `resources` VALUES (315,'player-bingo-recentwinners','REQUEST',297,'Player Module Bingo Controller RecentWinners Action');
INSERT INTO `resources` VALUES (316,'player-report','REQUEST',1,'Player Module Report Controller');
INSERT INTO `resources` VALUES (317,'player-report-index','REQUEST',316,'Player Module Report Controller Index Action');
INSERT INTO `resources` VALUES (318,'player-gamelog','REQUEST',1,'Player Module Gamelog Controller');
INSERT INTO `resources` VALUES (319,'player-gamelog-index','REQUEST',318,'Player Module Gamelog Controller Index Action');
INSERT INTO `resources` VALUES (320,'player-gallery','REQUEST',1,'Player Module Gallery Controller');
INSERT INTO `resources` VALUES (321,'player-gallery-index','REQUEST',1,'Player Module Gallery Controller Index Action');
INSERT INTO `resources` VALUES (322,'player-bingo-gamelog','REQUEST',297,'Player Module Bingo Controller Gamelog Action');
INSERT INTO `resources` VALUES (323,'player-promotions-loyalty','REQUEST',212,'Player Module Promotions Controller Loyalty Action');
INSERT INTO `resources` VALUES (324,'player-prebuy','REQUEST',1,'Player Module Prebuy Controller');
INSERT INTO `resources` VALUES (325,'player-prebuy-index','REQUEST',324,'Player Module Prebuy Controller Index Action');
INSERT INTO `resources` VALUES (326,'player-prebuy-view','REQUEST',324,'Player Module Prebuy Controller view Action');
INSERT INTO `resources` VALUES (327,'player-content-article','REQUEST',161,'Player Module Contents Controller Article Action');
INSERT INTO `resources` VALUES (328,'player-slot-playerloyaltypoints','REQUEST',133,'Player Module Slot Controller Playerloyaltypoints Action');
INSERT INTO `resources` VALUES (329,'player-slot-claimbonus','REQUEST',133,'Player Module Slot Controller ClaimBonus Action');
INSERT INTO `resources` VALUES (330,'player-slot-lasttimebonusclaimed','REQUEST',133,'Player Module Slot Controller LastTimeBonusClaimed Action');
INSERT INTO `resources` VALUES (331,'player-leaderboard','REQUEST',1,'Player Module Leaderboard Controller');
INSERT INTO `resources` VALUES (332,'player-leaderboard-bingo','REQUEST',331,'Player Module Leaderboard Controller Bingo Action');
INSERT INTO `resources` VALUES (333,'player-banking-confirm','REQUEST',92,'Player Module Banking Controller Confirm Action');
INSERT INTO `resources` VALUES (334,'player-game-opponentslist','REQUEST',100,'Player Module Game Controller Opponentslist Action');
INSERT INTO `resources` VALUES (335,'player-bingo-showlog','REQUEST',297,'Player Module Bingo Controller Showlog Action');
INSERT INTO `resources` VALUES (336,'player-prebuy-prebaughtplayers','REQUEST',324,'Player Module Prebuy Controller PreBaughtPlayers Action');
INSERT INTO `resources` VALUES (337,'player-game-invite','REQUEST',100,'Player Module Game Controller Invite Action');
INSERT INTO `resources` VALUES (338,'player-leaderboard-rummy','REQUEST',331,'Player Module Leaderboard Controller Rummy Action');
INSERT INTO `resources` VALUES (339,'player-promotions-newsletter','REQUEST',212,'Promotions Newsletter');
INSERT INTO `resources` VALUES (340,'player-banking-convertlp','REQUEST',92,'Convert Loyalty Points To Bonus');
INSERT INTO `resources` VALUES (341,'player-promotions-gift','REQUEST',212,'Gift Shop');
INSERT INTO `resources` VALUES (342,'player-download-mobile','REQUEST',295,'Download Mobile Version Of Taashtime');
INSERT INTO `resources` VALUES (343,'affiliate-scheme-product','REQUEST',218,'Affiliate Scheme Product');
INSERT INTO `resources` VALUES (344,'affiliate-scheme-paymentplans','REQUEST',218,'Affiliate Scheme Paymentplans');
INSERT INTO `resources` VALUES (345,'affiliate-help','REQUEST',150,'Affiliate Help');
INSERT INTO `resources` VALUES (346,'affiliate-help-faq','REQUEST',345,'Affiliate Help Faq');
INSERT INTO `resources` VALUES (347,'affiliate-help-contact','REQUEST',345,'Affiliate Help Contact');
INSERT INTO `resources` VALUES (348,'player-leaderboard-rummyteams','REQUEST',331,'Player Module Leaderboard Controller RummyTeams Action');
INSERT INTO `resources` VALUES (349,'player-leaderboard-rummyteamdata','REQUEST',331,'Player Module Leaderboard Controller rummyTeamsData Action');
INSERT INTO `resources` VALUES (350,'player-coupon-generate','REQUEST',168,'Player Module Coupon Controller Generate Action');
INSERT INTO `resources` VALUES (351,'player-leaderboard-registerplayer','REQUEST',331,'Player Module Leaderboard Controller RegisterPlayer Action');
INSERT INTO `resources` VALUES (352,'player-leaderboard-insertplayer','REQUEST',331,'Player Module Leaderboard Controller InsertPlayer Action');
INSERT INTO `resources` VALUES (353,'player-mobile','REQUEST',1,'Player Mobile Controller');
INSERT INTO `resources` VALUES (354,'player-mobile-login','REQUEST',353,'Player Mobile Controller Login Action');
INSERT INTO `resources` VALUES (355,'player-mobile-getsfslogin','REQUEST',353,'Player Mobile Controller Getsfslogin Action');
INSERT INTO `resources` VALUES (356,'player-gamelog-log','REQUEST',318,'Player Module Gamelog Controller Log Action');
INSERT INTO `resources` VALUES (357,'player-newsletter','REQUEST',1,'Player Newsletter Controller');
INSERT INTO `resources` VALUES (358,'player-newsletter-subscribe','REQUEST',357,'Player Newsletter Controller Subscribe Action');
INSERT INTO `resources` VALUES (359,'player-mobile-bonus','REQUEST',353,'Player Mobile Controller Bonus Action');
INSERT INTO `resources` VALUES (360,'admin-gamification','REQUEST',6,'Admin Gamification Menu');
INSERT INTO `resources` VALUES (361,'admin-gamification-index','REQUEST',360,'Admin Gamification Index');
INSERT INTO `resources` VALUES (362,'admin-gamification-createvariable','REQUEST',360,'Admin Gamification Create Variables');
INSERT INTO `resources` VALUES (363,'admin-gamification-createbadge','REQUEST',360,'Admin Gamification Create Badges');

--
-- Dumping data for table `privileges`
--

-- 
-- Player Module ACLs
--

-- player module
-- INSERT INTO `privileges` VALUES ('',1,'player','REQUEST',1,'visitor','VISITOR','allow'); -- FIXME:: Check this rule
INSERT INTO `privileges` VALUES (NULL,1,'player','REQUEST',2,'player','PLAYER','allow');

-- player-index
INSERT INTO `privileges` VALUES (NULL,2,'player-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,3,'player-index-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,164,'player-index-winner','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,211,'player-index-sitemap','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,227,'player-index-invite','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,243,'player-index-unsubscribe','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,283,'player-index-reportbug','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,283,'player-index-reportbug','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,310,'player-index-mailresponse','REQUEST',1,'visitor','VISITOR','allow');

-- player-home
INSERT INTO `privileges` VALUES (NULL,4,'player-home','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,5,'player-home-index','REQUEST',2,'player','PLAYER','allow');

-- player-auth
INSERT INTO `privileges` VALUES (NULL,15,'player-auth','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,16,'player-auth-login','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,17,'player-auth-logout','REQUEST',1,'visitor','VISITOR','deny');
INSERT INTO `privileges` VALUES (NULL,20,'player-auth-signup','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,35,'player-auth-registration','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,106,'player-auth-confirm','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,107,'player-auth-forgotpassword','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,108,'player-auth-resetpassword','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,159,'player-auth-facebooklogin','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,299,'player-auth-reconfirm','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,307,'player-auth-level','REQUEST',1,'visitor','VISITOR','allow');

INSERT INTO `privileges` VALUES (NULL,42,'player-auth-edit','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,43,'player-auth-view','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,44,'player-auth-changepwd','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,17,'player-auth-logout','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,16,'player-auth-login','REQUEST',2,'player','PLAYER','deny');
INSERT INTO `privileges` VALUES (NULL,20,'player-auth-signup','REQUEST',2,'player','PLAYER','deny');
INSERT INTO `privileges` VALUES (NULL,35,'player-auth-registration','REQUEST',2,'player','PLAYER','deny');
INSERT INTO `privileges` VALUES (NULL,228,'player-auth-image','REQUEST',2,'player','PLAYER','allow');

-- player-ticket
INSERT INTO `privileges` VALUES (NULL,18,'player-ticket','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,19,'player-ticket-create','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,21,'player-ticket-view','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,22,'player-ticket-show','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,23,'player-ticket-reply','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,306,'player-ticket-delete','REQUEST',2,'player','PLAYER','allow');

-- player-roulette
INSERT INTO `privileges` VALUES (NULL,30,'player-roulette','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,31,'player-roulette-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,94,'player-roulette-gamelog','REQUEST',2,'player','PLAYER','allow');

-- player-reconciliation
INSERT INTO `privileges` VALUES (NULL,32,'player-reconciliation','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,33,'player-reconciliation-index','REQUEST',2,'player','PLAYER','allow');

-- player-gaming
INSERT INTO `privileges` VALUES (NULL,36,'player-gaming','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,37,'player-gaming-index','REQUEST',2,'player','PLAYER','allow');

-- player-keno
INSERT INTO `privileges` VALUES (NULL,90,'player-keno','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,91,'player-keno-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,95,'player-keno-gamelog','REQUEST',2,'player','PLAYER','allow');

-- player-banking
INSERT INTO `privileges` VALUES (NULL,92,'player-banking','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,105,'player-banking-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,105,'player-banking-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,93,'player-banking-fundbonus','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,206,'player-banking-faq','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,236,'player-banking-deposit','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,303,'player-banking-funcoins','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,308,'player-banking-detail','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,312,'player-banking-freetoreal','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,333,'player-banking-confirm','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,340,'player-banking-convertlp','REQUEST',2,'player','PLAYER','allow');

-- player-error
INSERT INTO `privileges` VALUES (NULL,96,'player-error','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,97,'player-error-error','REQUEST',1,'visitor','VISITOR','allow');

-- player-kenologdetails
INSERT INTO `privileges` VALUES (NULL,98,'player-kenologdetails','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,99,'player-kenologdetails-index','REQUEST',2,'player','PLAYER','allow');

-- player-game
INSERT INTO `privileges` VALUES (NULL,100,'player-game','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,101,'player-game-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,102,'player-game-game','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,102,'player-game-game','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,160,'player-game-json','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,101,'player-game-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,215,'player-game-getsfslogin','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,266,'player-game-quickjoin','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,266,'player-game-quickjoin','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,300,'player-game-allgame','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,334,'player-game-opponentslist','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,337,'player-game-invite','REQUEST',2,'player','PLAYER','allow');

-- player-facebook
INSERT INTO `privileges` VALUES (NULL,103,'player-facebook','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,104,'player-facebook-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,222,'player-facebook-facebooklogin','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,223,'player-facebook-game','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,224,'player-facebook-gameindex','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,225,'player-facebook-sorry','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,314,'player-facebook-payment','REQUEST',1,'visitor','VISITOR','allow');



-- player-withdrawal
INSERT INTO `privileges` VALUES (NULL,109,'player-withdrawal','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,110,'player-withdrawal-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,111,'player-withdrawal-request','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,116,'player-withdrawal-listdetails','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,117,'player-withdrawal-listall','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,118,'player-withdrawal-listunprocessed','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,119,'player-withdrawal-insertflowback','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,301,'player-withdrawal-verification','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,302,'player-withdrawal-modify','REQUEST',2,'player','PLAYER','allow');

-- player-comments
INSERT INTO `privileges` VALUES (NULL,125,'player-comments','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,126,'player-comments-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,131,'player-comments-show','REQUEST',1,'visitor','VISITOR','allow');

-- player-slot
INSERT INTO `privileges` VALUES (NULL,133,'player-slot','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,134,'player-slot-gamelog','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,328,'player-slot-playerloyaltypoints','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,329,'player-slot-claimbonus','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,330,'player-slot-lasttimebonusclaimed','REQUEST',2,'player','PLAYER','allow');

-- player-slotlogdetails
INSERT INTO `privileges` VALUES (NULL,137,'player-slotlogdetails','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,138,'player-slotlogdetails-index','REQUEST',2,'player','PLAYER','allow');

-- player-leaderboard
INSERT INTO `privileges` VALUES (NULL,331,'player-leaderboard','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,332,'player-leaderboard-bingo','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,338,'player-leaderboard-rummy','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,348,'player-leaderboard-rummyteams','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,349,'player-leaderboard-rummyteamdata','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,351,'player-leaderboard-registerplayer','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,352,'player-leaderboard-insertplayer','REQUEST',2,'player','PLAYER','allow');


-- player-roulettelogdetails
INSERT INTO `privileges` VALUES (NULL,135,'player-roulettelogdetails','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,136,'player-roulettelogdetails-index','REQUEST',2,'player','PLAYER','allow');

-- player-facebookauth
INSERT INTO `privileges` VALUES (NULL,157,'player-facebookauth','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,158,'player-facebookauth-auth','REQUEST',1,'visitor','VISITOR','allow');

-- player-content
INSERT INTO `privileges` VALUES (NULL,161,'player-content','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,162,'player-content-terms','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,163,'player-content-privacypolicy','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,207,'player-content-legal','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,208,'player-content-rules','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,209,'player-content-contact','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,210,'player-content-withdrawterms','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,250,'player-content-about','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,253,'player-content-awards','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,254,'player-content-blog','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,327,'player-content-article','REQUEST',1,'visitor','VISITOR','allow');

-- player-help
INSERT INTO `privileges` VALUES (NULL,165,'player-help','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,166,'player-help-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,167,'player-help-display','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,226,'player-help-howtoplay','REQUEST',1,'visitor','VISITOR','allow');

-- player-coupon
INSERT INTO `privileges` VALUES (NULL,168,'player-coupon','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,169,'player-coupon-redeem','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,350,'player-coupon-generate','REQUEST',2,'player','PLAYER','allow');

-- player-transaction
INSERT INTO `privileges` VALUES (NULL,200,'player-transaction','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,201,'player-transaction-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,202,'player-transaction-confirm','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,202,'player-transaction-confirm','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,203,'player-transaction-process','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,203,'player-transaction-process','REQUEST',1,'visitor','VISITOR','allow');


-- player-promotions
INSERT INTO `privileges` VALUES (NULL,212,'player-promotions','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,213,'player-promotions-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,272,'player-promotions-survey','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,287,'player-promotions-referfriend','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,287,'player-promotions-referfriend','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,309,'player-promotions-special','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,323,'player-promotions-loyalty','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,339,'player-promotions-newsletter','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,341,'player-promotions-gift','REQUEST',1,'visitor','VISITOR','allow');


-- player-language
INSERT INTO `privileges` VALUES (NULL,220,'player-language','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,221,'player-language-index','REQUEST',1,'visitor','VISITOR','allow');

-- player-twitter
INSERT INTO `privileges` VALUES (NULL,229,'player-twitter','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,230,'player-twitter-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,231,'player-twitter-callback','REQUEST',1,'visitor','VISITOR','allow');

-- player-testimonial
INSERT INTO `privileges` VALUES (NULL,232,'player-testimonial','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,233,'player-testimonial-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,234,'player-testimonial-write','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,235,'player-testimonial-view','REQUEST',1,'visitor','VISITOR','allow');

-- player-oauth
INSERT INTO `privileges` VALUES (NULL,237,'player-oauth','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,238,'player-oauth-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,239,'player-oauth-callback','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,240,'player-oauth-authorize','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,241,'player-oauth-access','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,242,'player-oauth-post','REQUEST',1,'visitor','VISITOR','allow');

-- player-faq
INSERT INTO `privileges` VALUES (NULL,246,'player-faq','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,247,'player-faq-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,280,'player-faq-gameplay','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,281,'player-faq-technical','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,282,'player-faq-security','REQUEST',1,'visitor','VISITOR','allow');

-- player-affiliate
INSERT INTO `privileges` VALUES (NULL,248,'player-affiliate','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,249,'player-affiliate-program','REQUEST',1,'visitor','VISITOR','allow');

-- player-market
INSERT INTO `privileges` VALUES (NULL,251,'player-market','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,252,'player-market-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,255,'player-market-sell','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,256,'player-market-gift','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,257,'player-market-item','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,258,'player-market-buy','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,265,'player-market-use','REQUEST',2,'player','PLAYER','allow');

-- player-rediff
INSERT INTO `privileges` VALUES (NULL,259,'player-rediff','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,260,'player-rediff-index','REQUEST',1,'visitor','VISITOR','allow');

-- player-ibibo
INSERT INTO `privileges` VALUES (NULL,261,'player-ibibo','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,262,'player-ibibo-index','REQUEST',1,'visitor','VISITOR','allow');

-- player-app
INSERT INTO `privileges` VALUES (NULL,263,'player-app','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,264,'player-app-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,273,'player-app-balance','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,274,'player-app-credit','REQUEST',2,'player','PLAYER','allow');

-- player-rummmylog
INSERT INTO `privileges` VALUES (NULL,267,'player-rummylog','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,268,'player-rummylog-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,271,'player-rummylog-log','REQUEST',2,'player','PLAYER','allow');

-- player-rummmygamelog
INSERT INTO `privileges` VALUES (NULL,269,'player-rummygamelog','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,270,'player-rummygamelog-index','REQUEST',2,'player','PLAYER','allow');

-- player-mol
INSERT INTO `privileges` VALUES (NULL,277,'player-mol','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,278,'player-mol-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,279,'player-mol-response','REQUEST',2,'player','PLAYER','allow');

-- player-download
INSERT INTO `privileges` VALUES (NULL,295,'player-download','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,296,'player-download-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,342,'player-download-mobile','REQUEST',1,'visitor','VISITOR','allow');

-- player-bingo
INSERT INTO `privileges` VALUES (NULL,297,'player-bingo','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,298,'player-bingo-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,311,'player-bingo-bingo','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,313,'player-bingo-prebuy','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,315,'player-bingo-recentwinners','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,322,'player-bingo-gamelog','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,335,'player-bingo-showlog','REQUEST',2,'player','PLAYER','allow');

-- player-tournament
INSERT INTO `privileges` VALUES (NULL,288,'player-tournament','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,289,'player-tournament-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,290,'player-tournament-register','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,291,'player-tournament-current','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,292,'player-tournament-list','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,293,'player-tournament-desc','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,294,'player-tournament-result','REQUEST',1,'visitor','VISITOR','allow');

-- player-gamereport
INSERT INTO `privileges` VALUES (NULL,304,'player-gamereport','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,305,'player-gamereport-gamesplayed','REQUEST',2,'player','PLAYER','allow');

-- player-report
INSERT INTO `privileges` VALUES (NULL,316,'player-report','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,317,'player-report-index','REQUEST',2,'player','PLAYER','allow');

-- player-gamelog
INSERT INTO `privileges` VALUES (NULL,318,'player-gamelog','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,319,'player-gamelog-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,356,'player-gamelog-log','REQUEST',2,'player','PLAYER','allow');

-- player-gallery
INSERT INTO `privileges` VALUES (NULL,320,'player-gallery','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,321,'player-gallery-index','REQUEST',1,'visitor','VISITOR','allow');

-- player-prebuy
INSERT INTO `privileges` VALUES (NULL,324,'player-prebuy','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,325,'player-prebuy-index','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,326,'player-prebuy-view','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,336,'player-prebuy-prebaughtplayers','REQUEST',2,'player','PLAYER','allow');

-- player-mobile
INSERT INTO `privileges` VALUES (NULL,353,'player-mobile','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,354,'player-mobile-login','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,355,'player-mobile-getsfslogin','REQUEST',2,'player','PLAYER','allow');
INSERT INTO `privileges` VALUES (NULL,359,'player-mobile-bonus','REQUEST',2,'player','PLAYER','allow');

-- player-newsletter
INSERT INTO `privileges` VALUES (NULL,357,'player-newsletter','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,358,'player-newsletter-subscribe','REQUEST',1,'visitor','VISITOR','allow');

-- 
-- Affiliate Module ACLs
--

-- affiliate
-- INSERT INTO `privileges` VALUES (NULL,150,'affiliate','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,150,'affiliate','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-auth
-- INSERT INTO `privileges` VALUES (NULL,151,'affiliate-auth','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,151,'affiliate-auth','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,152,'affiliate-auth-signup','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,153,'affiliate-auth-login','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,178,'affiliate-auth-view','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,179,'affiliate-auth-edit','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,180,'affiliate-auth-changepassword','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,154,'affiliate-auth-logout','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,153,'affiliate-auth-login','REQUEST',3,'affiliate','AFFILIATE','deny');
INSERT INTO `privileges` VALUES (NULL,152,'affiliate-auth-signup','REQUEST',3,'affiliate','AFFILIATE','deny');

-- affiliate-home
INSERT INTO `privileges` VALUES (NULL,155,'affiliate-home','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,156,'affiliate-home-index','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-tracker
INSERT INTO `privileges` VALUES (NULL,170,'affiliate-tracker','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,171,'affiliate-tracker-create','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,172,'affiliate-tracker-view','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,173,'affiliate-tracker-edit','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,174,'affiliate-tracker-trackerdetails','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,175,'affiliate-tracker-alltrackers','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,214,'affiliate-tracker-graph','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,244,'affiliate-tracker-uniquevisitors','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,245,'affiliate-tracker-visitors','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-transaction
INSERT INTO `privileges` VALUES (NULL,176,'affiliate-transaction','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,177,'affiliate-transaction-index','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-ticket
INSERT INTO `privileges` VALUES (NULL,181,'affiliate-ticket','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,182,'affiliate-ticket-create','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,183,'affiliate-ticket-view','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,184,'affiliate-ticket-reply','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-earnings
INSERT INTO `privileges` VALUES (NULL,185,'affiliate-earnings','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,186,'affiliate-earnings-summary','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-index
-- INSERT INTO `privileges` VALUES (NULL,187,'affiliate-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,187,'affiliate-index','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,188,'affiliate-index-index','REQUEST',1,'visitor','VISITOR','allow');

-- affiliate-banner
INSERT INTO `privileges` VALUES (NULL,189,'affiliate-banner','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,190,'affiliate-banner-index','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-error
INSERT INTO `privileges` VALUES (NULL,204,'affiliate-error','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,205,'affiliate-error-error','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,204,'affiliate-error','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,205,'affiliate-error-error','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-visit
INSERT INTO `privileges` VALUES (NULL,216,'affiliate-visit','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,217,'affiliate-visit-index','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-scheme
INSERT INTO `privileges` VALUES (NULL,218,'affiliate-scheme','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,219,'affiliate-scheme-details','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,343,'affiliate-scheme-product','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,344,'affiliate-scheme-paymentplans','REQUEST',1,'visitor','VISITOR','allow');

-- affiliate-report
INSERT INTO `privileges` VALUES (NULL,284,'affiliate-report','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,285,'affiliate-report-registration','REQUEST',3,'affiliate','AFFILIATE','allow');
INSERT INTO `privileges` VALUES (NULL,286,'affiliate-report-transaction','REQUEST',3,'affiliate','AFFILIATE','allow');

-- affiliate-help
INSERT INTO `privileges` VALUES (NULL,345,'affiliate-help','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,346,'affiliate-help-faq','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,347,'affiliate-help-contact','REQUEST',1,'visitor','VISITOR','allow');

-- 
-- Admin Module ACLs
--

-- INSERT INTO `privileges` VALUES (NULL,6,'admin','REQUEST',1,'visitor','VISITOR','allow'); -- FIXME:: Check how this works
INSERT INTO `privileges` VALUES (NULL,6,'admin','REQUEST',4,'csr','CSR','allow');

INSERT INTO `privileges` VALUES (NULL,7,'admin-index','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,8,'admin-index-index','REQUEST',1,'visitor','VISITOR','allow');

INSERT INTO `privileges` VALUES (NULL,9,'admin-home','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,10,'admin-home-index','REQUEST',4,'csr','CSR','allow');

INSERT INTO `privileges` VALUES (NULL,11,'admin-auth','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,12,'admin-auth-login','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,12,'admin-auth-login','REQUEST',4,'csr','CSR','deny');
INSERT INTO `privileges` VALUES (NULL,13,'admin-auth-logout','REQUEST',1,'visitor','VISITOR','deny');
INSERT INTO `privileges` VALUES (NULL,13,'admin-auth-logout','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,14,'admin-auth-signup','REQUEST',1,'visitor','VISITOR','allow');
INSERT INTO `privileges` VALUES (NULL,14,'admin-auth-signup','REQUEST',4,'csr','CSR','deny');

INSERT INTO `privileges` VALUES (NULL,24,'admin-ticket','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,25,'admin-ticket-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,26,'admin-ticket-show','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,27,'admin-ticket-conversation','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,28,'admin-ticket-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,29,'admin-ticket-reply','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,34,'admin-auth-registration','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,38,'admin-rouletteconfig','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,39,'admin-rouletteconfig-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,40,'admin-rouletteconfig-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,41,'admin-rouletteconfig-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,45,'admin-slotconfig','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,46,'admin-slotconfig-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,47,'admin-slotconfig-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,48,'admin-slotconfig-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,49,'admin-bingo','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,50,'admin-bingo-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,51,'admin-bingo-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,52,'admin-bingo-process','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,53,'admin-bingo-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,54,'admin-searching','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,55,'admin-searching-index','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,56,'admin-bonus','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,57,'admin-bonus-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,58,'admin-bonus-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,59,'admin-bonus-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,60,'admin-bonus-process','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,61,'admin-error','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,62,'admin-error-error','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,63,'admin-frontend','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,64,'admin-frontend-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,65,'admin-frontend-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,66,'admin-frontend-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,67,'admin-frontend-viewdetails','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,68,'admin-keno','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,69,'admin-keno-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,70,'admin-keno-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,71,'admin-keno-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,72,'admin-keno-viewdetails','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,73,'admin-keno-process','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,74,'admin-privilege','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,75,'admin-privilege-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,76,'admin-privilege-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,77,'admin-privilege-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,78,'admin-privilege-viewdetails','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,79,'admin-resource','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,80,'admin-resource-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,81,'admin-resource-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,82,'admin-resource-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,83,'admin-resource-viewdetails','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,84,'admin-role','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,85,'admin-role-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,86,'admin-role-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,87,'admin-role-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,88,'admin-role-viewdetails','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,89,'admin-searching-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,112,'admin-withdrawal','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,113,'admin-withdrawal-index','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,114,'admin-withdrawal-listall','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,115,'admin-withdrawal-listdetails','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,120,'admin-system','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,121,'admin-system-getreport','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,122,'admin-template','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,123,'admin-template-listall','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,124,'admin-template-listalltags','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,127,'admin-comments','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,128,'admin-comments-showall','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,129,'admin-comments-status','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,130,'admin-comments-show','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,132,'admin-system-download','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,139,'admin-admin','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,140,'admin-admin-listallcsrs','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,141,'admin-bingosession','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,142,'admin-bingosession-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,143,'admin-bingosession-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,144,'admin-bingosession-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,145,'admin-bingorooms','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,146,'admin-bingorooms-create','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,147,'admin-bingorooms-process','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,148,'admin-bingorooms-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,149,'admin-bingorooms-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,191,'admin-reconciliation','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,192,'admin-reconciliation-index','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,193,'admin-player','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,194,'admin-player-index','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,195,'admin-player-view','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,196,'admin-player-adjustbalance','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,197,'admin-player-creditbonus','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,198,'admin-player-confirmplayer','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,199,'admin-player-edit','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,275,'admin-transaction','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,276,'admin-transaction-allplayertransaction','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,360,'admin-gamification','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,361,'admin-gamification-index','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,362,'admin-gamification-createvariable','REQUEST',4,'csr','CSR','allow');
INSERT INTO `privileges` VALUES (NULL,363,'admin-gamification-createbadge','REQUEST',4,'csr','CSR','allow');

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

