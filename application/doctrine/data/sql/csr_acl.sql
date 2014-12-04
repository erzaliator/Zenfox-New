--
-- Dumping data for table `csr`
--

DELETE FROM `csr`; ALTER TABLE `csr` AUTO_INCREMENT = 1;
DELETE FROM `csr_gms_group`; ALTER TABLE `csr_gms_group` AUTO_INCREMENT = 1;
DELETE FROM `gms_group`; ALTER TABLE `gms_group` AUTO_INCREMENT = 1;
DELETE FROM `gms_group_frontend`; ALTER TABLE `gms_group_frontend` AUTO_INCREMENT = 1;
DELETE FROM `gms_group_gms_menu`; ALTER TABLE `gms_group_gms_menu` AUTO_INCREMENT = 1;
DELETE FROM `gms_menu`; ALTER TABLE `gms_menu` AUTO_INCREMENT = 1;
DELETE FROM `gms_menu_link`; ALTER TABLE `gms_menu_link` AUTO_INCREMENT = 1;

INSERT INTO `csr` VALUES (1,'yaswanth','familyguy!@#','Yaswanth','ENABLED');
INSERT INTO `csr` VALUES (2,'praveen','praveen!@#','Praveen','ENABLED');
INSERT INTO `csr` VALUES (3,'vikranth','vikranth!@#','Vikranth','ENABLED');
INSERT INTO `csr` VALUES (4,'sarathy','sarathy!@#','Sarathy','ENABLED');
INSERT INTO `csr` VALUES (5,'sunil','sunil!@#','Sunil','ENABLED');
INSERT INTO `csr` VALUES (6,'rekha','rekha!@#','Rekha','ENABLED');
INSERT INTO `csr` VALUES (7,'intern','intern!@#','Intern','ENABLED');

--
-- Dumping data for table `csr_gms_group`
--

INSERT INTO `csr_gms_group` VALUES (1,2);
INSERT INTO `csr_gms_group` VALUES (2,2);
INSERT INTO `csr_gms_group` VALUES (3,2);
INSERT INTO `csr_gms_group` VALUES (4,2);
INSERT INTO `csr_gms_group` VALUES (5,2);
INSERT INTO `csr_gms_group` VALUES (6,2);
INSERT INTO `csr_gms_group` VALUES (7,4);

--
-- Dumping data for table `gms_group`
--

INSERT INTO `gms_group` VALUES (1,'visitor','Visitor Group');
INSERT INTO `gms_group` VALUES (2,'administrator','Administrator Group');
INSERT INTO `gms_group` VALUES (3,'account','Account Group');
INSERT INTO `gms_group` VALUES (4,'csr','CSR Group');
INSERT INTO `gms_group` VALUES (5,'csr-tl','CSR TL Group');

--
-- Dumping data for table `gms_group_frontend`
--

INSERT INTO `gms_group_frontend` VALUES (1,1);
INSERT INTO `gms_group_frontend` VALUES (2,1);
INSERT INTO `gms_group_frontend` VALUES (2,2);
INSERT INTO `gms_group_frontend` VALUES (2,3);
INSERT INTO `gms_group_frontend` VALUES (2,4);
INSERT INTO `gms_group_frontend` VALUES (2,5);
INSERT INTO `gms_group_frontend` VALUES (2,6);
INSERT INTO `gms_group_frontend` VALUES (3,1);
INSERT INTO `gms_group_frontend` VALUES (4,1);
INSERT INTO `gms_group_frontend` VALUES (5,1);

--
-- Dumping data for table `gms_group_gms_menu`
--

INSERT INTO `gms_group_gms_menu` VALUES (1,1,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (2,1,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,1,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,1,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,1,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (1,2,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,3,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,3,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,3,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,3,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,4,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,4,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,4,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,4,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,5,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,6,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,7,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,8,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,9,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,10,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,11,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,12,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,13,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,13,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,13,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,13,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,14,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,14,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,14,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,14,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,15,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,15,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,15,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,15,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,16,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,16,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,16,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,16,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,18,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,18,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,18,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,18,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,19,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,19,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,20,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,20,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,20,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,21,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,21,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,21,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,21,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,22,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,22,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,22,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,22,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,23,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,23,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,23,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,23,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,24,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,24,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,24,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,26,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,26,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,26,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,27,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,27,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,27,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,28,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,28,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,28,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,30,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,30,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,30,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,30,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,31,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,31,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,31,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,31,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,32,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,32,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,32,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,33,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,34,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,34,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,34,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,35,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,35,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,35,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,36,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,36,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,36,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,36,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,37,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,37,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,37,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,38,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,38,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,38,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,39,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,39,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,39,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,40,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,40,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,40,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,40,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,41,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,41,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,41,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,41,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,42,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,42,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,42,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,43,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,43,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,43,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,43,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,44,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,44,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,44,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,45,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,45,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,45,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,46,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,46,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,47,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,47,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,47,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,48,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,48,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,48,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,49,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,49,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,49,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,50,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,50,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,50,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,51,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,51,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,51,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,51,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,52,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,52,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,52,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,53,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,53,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,54,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,54,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,54,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,54,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,55,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,55,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,55,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,55,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,56,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,56,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,57,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,57,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,57,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,57,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,58,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,58,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,59,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,59,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,59,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,59,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,60,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,60,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,60,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,61,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,61,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,61,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,61,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,62,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,62,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,62,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,63,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,63,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,63,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,63,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,64,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,64,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,64,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,64,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,65,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,65,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,65,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,65,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,66,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,66,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,66,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,66,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,67,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,67,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,67,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,68,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,68,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,69,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,69,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,69,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,69,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,70,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,70,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,70,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,71,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,71,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,72,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,72,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,73,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,73,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,73,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,74,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,74,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,74,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,75,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,75,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,75,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,76,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,76,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,76,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,76,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,77,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,77,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,77,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,77,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,78,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,78,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,78,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,78,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,81,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,81,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,81,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,81,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,82,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,82,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,82,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,82,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,83,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,83,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,83,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,84,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,84,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,85,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,85,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,85,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,86,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,87,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,87,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,87,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,88,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,88,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,89,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,89,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,90,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,90,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,90,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,91,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,91,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,92,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,93,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,93,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,94,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,94,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,95,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,95,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,96,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,96,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,97,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,97,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,98,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,98,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,99,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,99,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,100,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,100,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,101,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,101,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,101,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,102,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,102,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,102,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,103,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,103,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,103,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,104,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,104,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,105,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,105,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,106,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,106,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,106,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,106,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,107,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,107,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,107,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,107,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,108,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,108,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,108,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,108,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,110,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,110,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,110,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,110,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,111,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,111,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,111,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,112,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,112,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,112,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,113,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,113,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,113,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,114,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,114,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,114,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,115,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,115,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,115,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,116,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,116,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,116,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,117,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,117,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,117,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,118,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,118,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,118,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,119,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,119,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,119,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,120,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,120,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,120,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,121,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,121,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,121,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,122,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,122,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,122,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,123,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,123,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,123,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,124,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,124,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,124,'allow');



INSERT INTO `gms_group_gms_menu` VALUES (2,125,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,125,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,125,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,126,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,126,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,126,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,127,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,127,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,128,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,128,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,128,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,128,'allow');


INSERT INTO `gms_group_gms_menu` VALUES (2,129,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,129,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,129,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,129,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,130,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,130,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,130,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,130,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,131,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,131,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,131,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,131,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,132,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,132,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,132,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,132,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,133,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,133,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,133,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,133,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,134,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,134,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,134,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,134,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,135,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,135,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,135,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,135,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,136,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,136,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,136,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,136,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,137,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,137,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,137,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,137,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,138,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,138,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,138,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,138,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,139,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,139,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,139,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,139,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,140,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,140,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,140,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,141,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,141,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,141,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,142,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,142,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,142,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,143,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,143,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,143,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,144,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,144,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,144,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,144,'allow');


INSERT INTO `gms_group_gms_menu` VALUES (2,145,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,145,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,145,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,145,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,146,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (3,146,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,146,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,146,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,147,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,147,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,147,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,148,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,148,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,148,'allow');

INSERT INTO `gms_group_gms_menu` VALUES (2,149,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (4,149,'allow');
INSERT INTO `gms_group_gms_menu` VALUES (5,149,'allow');
--
-- Dumping data for table `gms_menu`
--

INSERT INTO `gms_menu` VALUES (1,'Main','Main Page','ENABLED','LINK','admin-index-index','VISIBLE');
INSERT INTO `gms_menu` VALUES (2,'Login','CSR Login','ENABLED','LINK','admin-auth-login','VISIBLE');
INSERT INTO `gms_menu` VALUES (3,'Home','Admin Home','ENABLED','LINK','admin-home-index','VISIBLE');
INSERT INTO `gms_menu` VALUES (4,'Logout','CSR Logout','ENABLED','LINK','admin-auth-logout','VISIBLE');
INSERT INTO `gms_menu` VALUES (5,'Group','Group Configuration','ENABLED','NOLINK','admin','VISIBLE');
INSERT INTO `gms_menu` VALUES (6,'Csr','CSR Configuration','ENABLED','NOLINK','admin-admin','VISIBLE');
INSERT INTO `gms_menu` VALUES (7,'Create','Create CSR','ENABLED','LINK','admin-admin-createcsr','VISIBLE');
INSERT INTO `gms_menu` VALUES (8,'View','View CSR','ENABLED','LINK','admin-admin-listallcsrs','VISIBLE');
INSERT INTO `gms_menu` VALUES (9,'Edit','Edit CSR','ENABLED','LINK','admin-admin-editcsr','VISIBLE');
INSERT INTO `gms_menu` VALUES (10,'Create','Create Group','ENABLED','LINK','admin-admin-creategroup','VISIBLE');
INSERT INTO `gms_menu` VALUES (11,'View','View Group','ENABLED','LINK','admin-admin-listallgroups','VISIBLE');
INSERT INTO `gms_menu` VALUES (12,'Edit','Edit Group','ENABLED','LINK','admin-admin-editgroup','VISIBLE');
INSERT INTO `gms_menu` VALUES (13,'Ticket','Ticket System','ENABLED','NOLINK','admin-ticket','VISIBLE');
INSERT INTO `gms_menu` VALUES (14,'Create','Create Ticket','ENABLED','LINK','admin-ticket-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (15,'View','View Ticket','ENABLED','LINK','admin-ticket-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (16,'Player Search','Player Search System','ENABLED','LINK','admin-searching-index','VISIBLE');
INSERT INTO `gms_menu` VALUES (17,'Player Transaction','All Player Transaction','ENABLED','LINK','admin-transaction-allplayertransaction','INVISIBLE');
INSERT INTO `gms_menu` VALUES (18,'Player View','View Player Profile','ENABLED','NOLINK','admin-player-view','INVISIBLE');
INSERT INTO `gms_menu` VALUES (19,'Adjust Balance','Adjust Player Balance','ENABLED','NOLINK','admin-player-adjustbalance','INVISIBLE');
INSERT INTO `gms_menu` VALUES (20,'Credit Bonus','Credit Bonus To Player','ENABLED','NOLINK','admin-player-creditbonus','INVISIBLE');
INSERT INTO `gms_menu` VALUES (21,'Reconciliation Report','Player Reconciliation Report','ENABLED','LINK','admin-reconciliation-index','VISIBLE');
INSERT INTO `gms_menu` VALUES (22,'Reply','Ticket Reply','ENABLED','NOLINK','admin-ticket-reply','INVISIBLE');
INSERT INTO `gms_menu` VALUES (23,'Rummy Report','Common Rummy Report','ENABLED','NOLINK','admin-rummyreport','INVISIBLE');
INSERT INTO `gms_menu` VALUES (24,'Registration','Rummy Registration Report','ENABLED','LINK','admin-rummyreport-registration','INVISIBLE');
INSERT INTO `gms_menu` VALUES (25,'Winners','Rummy Winners Report','ENABLED','LINK','admin-rummyreport-winner','INVISIBLE');
INSERT INTO `gms_menu` VALUES (26,'Rummy Config','Rummy Room Configuration','ENABLED','NOLINK','admin-rummyconfig','INVISIBLE');
INSERT INTO `gms_menu` VALUES (27,'Config','Rummy Configuration','ENABLED','NOLINK','admin-rummyconfig-process','INVISIBLE');
INSERT INTO `gms_menu` VALUES (28,'Testimonial','Testimonial Configuration','ENABLED','LINK','admin-testimonial','VISIBLE');
INSERT INTO `gms_menu` VALUES (29,'Consolidated Report','Player Consolidated Report','ENABLED','LINK','admin-rummyreport-consolidate','INVISIBLE');
INSERT INTO `gms_menu` VALUES (30,'Download','Download All Reports','ENABLED','LINK','admin-download-index','INVISIBLE');
INSERT INTO `gms_menu` VALUES (31,'Game History','Rummy Game History','ENABLED','LINK','admin-rummyreport-gamehistory','INVISIBLE');
INSERT INTO `gms_menu` VALUES (32,'Depositors','Rummy Depositors Report','ENABLED','LINK','admin-rummyreport-depositor','INVISIBLE');
INSERT INTO `gms_menu` VALUES (33,'Create','Create Rummy Configuration','ENABLED','LINK','admin-rummyconfig-create','INVISIBLE');
INSERT INTO `gms_menu` VALUES (34,'View','View Rummy Configuration','ENABLED','LINK','admin-rummyconfig-view','INVISIBLE');
INSERT INTO `gms_menu` VALUES (35,'Edit','Edit Rummy Configuration','ENABLED','LINK','admin-rummyconfig-edit','INVISIBLE');
INSERT INTO `gms_menu` VALUES (36,'Withdrawal','Withdrawal Requests','ENABLED','NOLINK','admin-withdrawal','VISIBLE');
INSERT INTO `gms_menu` VALUES (37,'All Requests','All Withdrawal Requests','ENABLED','LINK','admin-withdrawal-listall','VISIBLE');
INSERT INTO `gms_menu` VALUES (38,'Player Withdrawal Requests','Player All Withdrawal Requests','ENABLED','LINK','admin-withdrawal-request','VISIBLE');
INSERT INTO `gms_menu` VALUES (39,'Player Request','Player Withdrawal Requests','ENABLED','NOLINK','admin-withdrawal-listdetails','INVISIBLE');
INSERT INTO `gms_menu` VALUES (40,'Failed Transactions','All Rummy Transaction  Report','ENABLED','LINK','admin-rummyreport-transaction','INVISIBLE');
INSERT INTO `gms_menu` VALUES (41,'Bonus Scheme','Bonus Schemes Handler','ENABLED','NOLINK','admin-bonus','VISIBLE');
INSERT INTO `gms_menu` VALUES (42,'Add','Create New Bonus Schemes','ENABLED','LINK','admin-bonus-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (43,'View','View All Bonus Schemes','ENABLED','LINK','admin-bonus-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (44,'Edit','Edit Bonus Schemes','ENABLED','NOLINK','admin-bonus-edit','INVISIBLE');
INSERT INTO `gms_menu` VALUES (45,'Process','Process Bonus Schemes','ENABLED','NOLINK','admin-bonus-process','INVISIBLE');
INSERT INTO `gms_menu` VALUES (46,'Player Edit','Edit Player Profile','ENABLED','NOLINK','admin-player-edit','INVISIBLE');
INSERT INTO `gms_menu` VALUES (47,'Game Logs','Rummy Game Logs','ENABLED','LINK','admin-rummyreport-gamelog','INVISIBLE');
INSERT INTO `gms_menu` VALUES (48,'Log Display','Rummy Game Log Display','ENABLED','NOLINK','admin-rummyreport-log','INVISIBLE');
INSERT INTO `gms_menu` VALUES (49,'Rummy Log','Rummy Game Log','ENABLED','NOLINK','admin-rummygamelog-index','INVISIBLE');
INSERT INTO `gms_menu` VALUES (50,'Regular Players','Regular Players Report','ENABLED','LINK','admin-rummyreport-regular','INVISIBLE');
INSERT INTO `gms_menu` VALUES (51,'Tournament','Tournament','ENABLED','NOLINK','admin-tournamentscheduling','VISIBLE');
INSERT INTO `gms_menu` VALUES (52,'View Configs','Tournament Scheduling','ENABLED','LINK','admin-tournamentscheduling-viewconfigs','VISIBLE');
INSERT INTO `gms_menu` VALUES (53,'Create','Tournament Creation','ENABLED','LINK','admin-tournamentscheduling-createtournament','VISIBLE');
INSERT INTO `gms_menu` VALUES (54,'Player List','Regular Players Report','ENABLED','LINK','admin-tournamentscheduling-playersregistered','VISIBLE');
INSERT INTO `gms_menu` VALUES (55,'Health','Health Values List','ENABLED','LINK','admin-health-systemhealth','VISIBLE');
INSERT INTO `gms_menu` VALUES (56,'System Health','System Health Values List','ENABLED','LINK','admin-health-systemhealth','INVISIBLE');
INSERT INTO `gms_menu` VALUES (57,'Player Health','Player Health Values List','ENABLED','LINK','admin-health-playerhealth','INVISIBLE');
INSERT INTO `gms_menu` VALUES (58,'Tracker Health','Tracker Health Values List','ENABLED','LINK','admin-health-trackerhealth','INVISIBLE');
INSERT INTO `gms_menu` VALUES (59,'Analytics','Tag reports List','ENABLED','LINK','admin-analytics','VISIBLE');
INSERT INTO `gms_menu` VALUES (60,'Conversion Report','Conversion reports List','ENABLED','LINK','admin-analytics-conversion','VISIBLE');
INSERT INTO `gms_menu` VALUES (61,'Transacting Players','Transacting Player reports List','ENABLED','LINK','admin-analytics-transactingplayers','VISIBLE');
INSERT INTO `gms_menu` VALUES (62,'Registration Summary','Registrations Summary List','ENABLED','LINK','admin-analytics-registrations','VISIBLE');
INSERT INTO `gms_menu` VALUES (63,'Transactions Report','Transactions Report List','ENABLED','LINK','admin-analytics-transactions','VISIBLE');
INSERT INTO `gms_menu` VALUES (64,'Network Transactions Summary','Network Transactions Summary List','ENABLED','LINK','admin-analytics-networktransactionsummary','VISIBLE');
INSERT INTO `gms_menu` VALUES (65,'Amount Details','Tournament Level Wise Amount Details','ENABLED','LINK','admin-tournamentscheduling-amountdetails','VISIBLE');
INSERT INTO `gms_menu` VALUES (66,'Verify Proofs','Verifying ID and Address Proofs','ENABLED','LINK','admin-withdrawal-checkwithdrawal','VISIBLE');
INSERT INTO `gms_menu` VALUES (67,'Tracker wise Details','Tracker Wise Players  Details','ENABLED','LINK','admin-analytics-trackerplayers','VISIBLE');
INSERT INTO `gms_menu` VALUES (68,'Campaign','Group Emails','ENABLED','LINK','admin-campaign','VISIBLE');
INSERT INTO `gms_menu` VALUES (69,'Individual Mail','Send Individual Emails','ENABLED','LINK','admin-email-individualmails','VISIBLE');
INSERT INTO `gms_menu` VALUES (70,'Template Handler','Add Or Modify Templates','ENABLED','LINK','admin-template','VISIBLE');
INSERT INTO `gms_menu` VALUES (71,'Start A Campaign','Send Group Emails','ENABLED','LINK','admin-campaign-startcampaign','VISIBLE');
INSERT INTO `gms_menu` VALUES (72,'Track Campaigns','track Group Emails','ENABLED','LINK','admin-campaign-trackcampaign','VISIBLE');
INSERT INTO `gms_menu` VALUES (73,'Add Template','Adding A new Template','ENABLED','LINK','admin-template-createtemplate','VISIBLE');
INSERT INTO `gms_menu` VALUES (74,'Modify Template','Modify Old Templates','ENABLED','LINK','admin-template-listall','VISIBLE');
INSERT INTO `gms_menu` VALUES (75,'Edit Template','Modify Old Templates','ENABLED','NOLINK','admin-template-edittemplate','INVISIBLE');
INSERT INTO `gms_menu` VALUES (76,'Add Verified Players ','Adding ID and Address Proofs','ENABLED','NOLINK','admin-withdrawal-addverified','INVISIBLE');
INSERT INTO `gms_menu` VALUES (77,'Fraud Check','Checking Player fraud','ENABLED','NOLINK','admin-fraudcheck','INVISIBLE');
INSERT INTO `gms_menu` VALUES (78,'Fraud Check','Checking Player fraud','ENABLED','NOLINK','admin-fraudcheck-checking','VISIBLE');
INSERT INTO `gms_menu` VALUES (79,'Game Cancellation','Cancelling a Game','ENABLED','NOLINK','admin-Gamecancellation','INVISIBLE');
INSERT INTO `gms_menu` VALUES (80,'Game Cancellation','Cancelling a Game','ENABLED','LINK','admin-Gamecancellation-cancellation','VISIBLE');
INSERT INTO `gms_menu` VALUES (81,'Proofs','Checking and Updating proofs','ENABLED','LINK','admin-withdrawal','VISIBLE');
INSERT INTO `gms_menu` VALUES (82,'Check Id','Checking id numbers','ENABLED','LINK','admin-withdrawal-checkids','VISIBLE');
INSERT INTO `gms_menu` VALUES (83,'View','View Testimonials','ENABLED','LINK','admin-testimonial-index','VISIBLE');
INSERT INTO `gms_menu` VALUES (84,'Edit','Edit Testimonial','ENABLED','LINK','admin-testimonial-modify','VISIBLE');
INSERT INTO `gms_menu` VALUES (85,'Keno','Keno Configuration','ENABLED','NOLINK','admin-keno','VISIBLE');
INSERT INTO `gms_menu` VALUES (86,'Create','Create Keno Game','ENABLED','LINK','admin-keno-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (87,'View','View Keno Games','ENABLED','LINK','admin-keno-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (88,'Process','Process Keno Configuration','ENABLED','NOLINK','admin-keno-process','INVISIBLE');
INSERT INTO `gms_menu` VALUES (89,'Edit','Edit Keno Games','ENABLED','NOLINK','admin-keno-edit','INVISIBLE');
INSERT INTO `gms_menu` VALUES (90,'View Detail','View Details Of Keno Game','ENABLED','NOLINK','admin-keno-viewdetails','INVISIBLE');
INSERT INTO `gms_menu` VALUES (91,'Slot','Slot Configuration','ENABLED','NOLINK','admin-slot','VISIBLE');
INSERT INTO `gms_menu` VALUES (92,'Create','Create Slot Game','ENABLED','LINK','admin-slot-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (93,'View','View Slot Games','ENABLED','LINK','admin-slot-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (94,'Process','Process Slot Configuration','ENABLED','NOLINK','admin-slot-process','INVISIBLE');
INSERT INTO `gms_menu` VALUES (95,'Edit','Edit Slot Games','ENABLED','NOLINK','admin-slot-edit','INVISIBLE');
INSERT INTO `gms_menu` VALUES (96,'Roulette','Roulette Configuration','ENABLED','NOLINK','admin-roulette','VISIBLE');
INSERT INTO `gms_menu` VALUES (97,'Create','Create Roulette Game','ENABLED','LINK','admin-roulette-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (98,'View','View Roulette Games','ENABLED','LINK','admin-roulette-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (99,'Process','Process Roulette Configuration','ENABLED','NOLINK','admin-roulette-process','INVISIBLE');
INSERT INTO `gms_menu` VALUES (100,'Edit','Edit Roulette Games','ENABLED','NOLINK','admin-roulette-edit','INVISIBLE');
INSERT INTO `gms_menu` VALUES (101,'Bingo','Bingo Configuration','ENABLED','NOLINK','admin-bingo','VISIBLE');
INSERT INTO `gms_menu` VALUES (102,'Create','Create Bingo Game','ENABLED','LINK','admin-bingo-create','VISIBLE');
INSERT INTO `gms_menu` VALUES (103,'View','View Bingo Games','ENABLED','LINK','admin-bingo-view','VISIBLE');
INSERT INTO `gms_menu` VALUES (104,'Process','Process Bingo Configuration','ENABLED','NOLINK','admin-bingo-process','INVISIBLE');
INSERT INTO `gms_menu` VALUES (105,'Edit','Edit Bingo Games','ENABLED','NOLINK','admin-bingo-edit','INVISIBLE');
INSERT INTO `gms_menu` VALUES (106,'Gamelog','Keno Gamelog','ENABLED','LINK','admin-gamelog-keno','VISIBLE');
INSERT INTO `gms_menu` VALUES (107,'Gamelog','Slot Gamelog','ENABLED','LINK','admin-gamelog-slot','VISIBLE');
INSERT INTO `gms_menu` VALUES (108,'Gamelog','Roulette Gamelog','ENABLED','LINK','admin-gamelog-roulette','VISIBLE');
INSERT INTO `gms_menu` VALUES (109,'Bank Details Search','search playerid with bank details','ENABLED','LINK','admin-bankdetailssearch-index','VISIBLE');
INSERT INTO `gms_menu` VALUES (110,'Network Wagering Report','network wagering reports List','ENABLED','LINK','admin-analytics-networkwagering','VISIBLE');
INSERT INTO `gms_menu` VALUES (111,'Bingo Room','Modify Bingo Rooms','ENABLED','LINK','admin-bingo-rooms','VISIBLE');
INSERT INTO `gms_menu` VALUES (112,'Bingo Room status','Bingo Room Status','ENABLED','NOLINK','admin-bingo-roomstatus','VISIBLE');
INSERT INTO `gms_menu` VALUES (113,'Bingo Active Pre-Buys',' Bingo Active Pre-Buys list','ENABLED','LINK','admin-bingo-viewactiveprebuys','VISIBLE');
INSERT INTO `gms_menu` VALUES (114,'Bingo Game Categories','Bingo Game Categories','ENABLED','LINK','admin-bingo-viewcategories','VISIBLE');
INSERT INTO `gms_menu` VALUES (115,'Bingo Sessions','Bingo Game Sessions','ENABLED','LINK','admin-bingo-viewsessions','VISIBLE');
INSERT INTO `gms_menu` VALUES (116,'Bingo PJP','Bingo Progressive Jackpot','ENABLED','LINK','admin-bingo-viewpjp','VISIBLE');
INSERT INTO `gms_menu` VALUES (117,'Create Patterns','Bingo Create Pattern','ENABLED','LINK','admin-bingo-patterns','VISIBLE');
INSERT INTO `gms_menu` VALUES (118,'Bingo Edit Active Pre-buys','Bingo Edit Active Pre-Buys','ENABLED','NOLINK','admin-bingo-activeprebuys','INVISIBLE');
INSERT INTO `gms_menu` VALUES (119,'Bingo Edit Categories','Bingo Edit Categories','ENABLED','NOLINK','admin-bingo-categories','INVISIBLE');
INSERT INTO `gms_menu` VALUES (120,'Bingo Edit Sessions','Bingo Edit Sessions','ENABLED','NOLINK','admin-bingo-sessions','INVISIBLE');
INSERT INTO `gms_menu` VALUES (121,'Bingo Edit PJP','Bingo Edit PJP','ENABLED','NOLINK','admin-bingo-pjp','INVISIBLE');
INSERT INTO `gms_menu` VALUES (122,'Bingo Recent Winners','Bingo Recent Winners List','ENABLED','LINK','admin-bingo-recentwinners','VISIBLE');
INSERT INTO `gms_menu` VALUES (123,'Bingo Room Sessions','Bingo Room Sessions','ENABLED','NOLINK','admin-bingo-roomsessions','VISIBLE');
INSERT INTO `gms_menu` VALUES (124,'View Campaign','View Campaigns','ENABLED','LINK','admin-campaign-viewcampaign','VISIBLE');
INSERT INTO `gms_menu` VALUES (125,'Promotion','Promotion','ENABLED','NOLINK','admin-promotion','VISIBLE');
INSERT INTO `gms_menu` VALUES (126,'Winners List','Promotion Winner','ENABLED','NOLINK','admin-promotion-winner','VISIBLE');
INSERT INTO `gms_menu` VALUES (127,'Edit Campaign','Edit Campaign','ENABLED','NOLINK','admin-campaign-editcampaign','INVISIBLE');
INSERT INTO `gms_menu` VALUES (128,'Elo Rating','Calculate Elo rating','ENABLED','NOLINK','admin-fraudcheck-elorating','VISIBLE');
INSERT INTO `gms_menu` VALUES (129,'Reports','Display All Reports','ENABLED','NOLINK','admin-report','VISIBLE');
INSERT INTO `gms_menu` VALUES (130,'Registration','Registration Report','ENABLED','LINK','admin-report-registration','VISIBLE');
INSERT INTO `gms_menu` VALUES (131,'Winners','Winners Report','ENABLED','LINK','admin-report-winner','INVISIBLE');
INSERT INTO `gms_menu` VALUES (132,'Consolidated Report','Player Consolidated Report','ENABLED','LINK','admin-report-consolidate','INVISIBLE');
INSERT INTO `gms_menu` VALUES (133,'Game History','Game History','ENABLED','LINK','admin-report-gamehistory','VISIBLE');
INSERT INTO `gms_menu` VALUES (134,'Depositors','Depositors Report','ENABLED','LINK','admin-report-depositor','VISIBLE');
INSERT INTO `gms_menu` VALUES (135,'Failed Transactions','All Failed Transaction Report','ENABLED','LINK','admin-report-transaction','VISIBLE');
INSERT INTO `gms_menu` VALUES (136,'Game Logs','All Game Logs','ENABLED','LINK','admin-report-gamelog','VISIBLE');
INSERT INTO `gms_menu` VALUES (137,'Log Display','Game Log Display','ENABLED','NOLINK','admin-report-log','INVISIBLE');
INSERT INTO `gms_menu` VALUES (138,'Regular Players','Regular Players Report','ENABLED','LINK','admin-report-regular','VISIBLE');
INSERT INTO `gms_menu` VALUES (139,'Online Players','Online Players Report','ENABLED','LINK','admin-report-online','VISIBLE');
INSERT INTO `gms_menu` VALUES (140,'Leaderboard','Leader Board Starting','ENABLED','NOLINK','admin-leaderboard','VISIBLE');
INSERT INTO `gms_menu` VALUES (141,'start Leaderboard','starting  Leaderboard','ENABLED','LINK','admin-leaderboard-start','VISIBLE');
INSERT INTO `gms_menu` VALUES (142,'Online Players','Frontend Wise online Players','ENABLED','LINK','admin-rummyreport-online','VISIBLE');
INSERT INTO `gms_menu` VALUES (143,'Player Cards','Player Cards Detail','ENABLED','LINK','admin-player-cardsdetail','VISIBLE');
INSERT INTO `gms_menu` VALUES (144,'Birthday','Players Birthday Report','ENABLED','LINK','admin-report-birthday','VISIBLE');
INSERT INTO `gms_menu` VALUES (145,'Top Players','Top Players Report','ENABLED','LINK','admin-report-topplayers','VISIBLE');
INSERT INTO `gms_menu` VALUES (146,'Overview','Players Report Overview','ENABLED','LINK','admin-report-overview','VISIBLE');
INSERT INTO `gms_menu` VALUES (147,'Activate Login Bonus','Activate Login Bonus','ENABLED','NOLINK','admin-promotion-loginbonus','VISIBLE');
INSERT INTO `gms_menu` VALUES (148,'Team Rummy Leaderboard','Leaderboard  List','ENABLED','LINK','admin-leaderboard-teamrummyleaderboards','VISIBLE');
INSERT INTO `gms_menu` VALUES (149,'Team Rummy winners','Leaderboard Winners List','ENABLED','LINK','admin-leaderboard-teamrummywinners','VISIBLE');

--
-- Dumping data for table `gms_menu_link`
--

INSERT INTO `gms_menu_link` VALUES (1,1,-1);
INSERT INTO `gms_menu_link` VALUES (2,2,-1);
INSERT INTO `gms_menu_link` VALUES (3,3,-1);
INSERT INTO `gms_menu_link` VALUES (4,4,-1);
INSERT INTO `gms_menu_link` VALUES (5,5,-1);
INSERT INTO `gms_menu_link` VALUES (6,6,-1);
INSERT INTO `gms_menu_link` VALUES (7,7,6);
INSERT INTO `gms_menu_link` VALUES (8,8,6);
INSERT INTO `gms_menu_link` VALUES (9,9,6);
INSERT INTO `gms_menu_link` VALUES (10,10,5);
INSERT INTO `gms_menu_link` VALUES (11,11,5);
INSERT INTO `gms_menu_link` VALUES (12,12,5);
INSERT INTO `gms_menu_link` VALUES (13,13,-1);
INSERT INTO `gms_menu_link` VALUES (14,14,13);
INSERT INTO `gms_menu_link` VALUES (15,15,13);
INSERT INTO `gms_menu_link` VALUES (16,16,-1);
INSERT INTO `gms_menu_link` VALUES (17,17,-1);
INSERT INTO `gms_menu_link` VALUES (18,21,-1);
INSERT INTO `gms_menu_link` VALUES (19,23,-1);
INSERT INTO `gms_menu_link` VALUES (20,24,23);
INSERT INTO `gms_menu_link` VALUES (21,25,23);
INSERT INTO `gms_menu_link` VALUES (22,26,-1);
INSERT INTO `gms_menu_link` VALUES (23,28,-1);
INSERT INTO `gms_menu_link` VALUES (24,29,-1);
INSERT INTO `gms_menu_link` VALUES (25,31,23);
INSERT INTO `gms_menu_link` VALUES (26,32,23);
INSERT INTO `gms_menu_link` VALUES (27,33,26);
INSERT INTO `gms_menu_link` VALUES (28,34,26);
INSERT INTO `gms_menu_link` VALUES (29,35,26);
INSERT INTO `gms_menu_link` VALUES (30,36,-1);
INSERT INTO `gms_menu_link` VALUES (31,37,36);
INSERT INTO `gms_menu_link` VALUES (32,38,36);
INSERT INTO `gms_menu_link` VALUES (33,40,23);
INSERT INTO `gms_menu_link` VALUES (34,41,-1);
INSERT INTO `gms_menu_link` VALUES (35,42,41);
INSERT INTO `gms_menu_link` VALUES (36,43,41);
INSERT INTO `gms_menu_link` VALUES (37,47,23);
INSERT INTO `gms_menu_link` VALUES (38,50,23);
INSERT INTO `gms_menu_link` VALUES (39,51,-1);
INSERT INTO `gms_menu_link` VALUES (40,52,51);
INSERT INTO `gms_menu_link` VALUES (41,53,51);
INSERT INTO `gms_menu_link` VALUES (42,54,51);
INSERT INTO `gms_menu_link` VALUES (43,55,-1);
INSERT INTO `gms_menu_link` VALUES (47,59,-1);
INSERT INTO `gms_menu_link` VALUES (48,60,59);
INSERT INTO `gms_menu_link` VALUES (49,61,59);
INSERT INTO `gms_menu_link` VALUES (50,62,59);
INSERT INTO `gms_menu_link` VALUES (51,63,59);
INSERT INTO `gms_menu_link` VALUES (52,64,59);
INSERT INTO `gms_menu_link` VALUES (53,65,51);
INSERT INTO `gms_menu_link` VALUES (54,66,81);
INSERT INTO `gms_menu_link` VALUES (55,67,59);
INSERT INTO `gms_menu_link` VALUES (56,68,-1);
INSERT INTO `gms_menu_link` VALUES (57,69,68);
INSERT INTO `gms_menu_link` VALUES (58,70,-1);
INSERT INTO `gms_menu_link` VALUES (59,71,68);
INSERT INTO `gms_menu_link` VALUES (60,72,68);
INSERT INTO `gms_menu_link` VALUES (61,73,70);
INSERT INTO `gms_menu_link` VALUES (62,74,70);
INSERT INTO `gms_menu_link` VALUES (63,75,70);
INSERT INTO `gms_menu_link` VALUES (64,80,-1);
INSERT INTO `gms_menu_link` VALUES (65,81,-1);
INSERT INTO `gms_menu_link` VALUES (66,82,81);
INSERT INTO `gms_menu_link` VALUES (67,83,28);
INSERT INTO `gms_menu_link` VALUES (68,84,28);
INSERT INTO `gms_menu_link` VALUES (69,85,-1);
INSERT INTO `gms_menu_link` VALUES (70,86,85);
INSERT INTO `gms_menu_link` VALUES (71,87,85);
INSERT INTO `gms_menu_link` VALUES (72,91,-1);
INSERT INTO `gms_menu_link` VALUES (73,92,91);
INSERT INTO `gms_menu_link` VALUES (74,93,91);
INSERT INTO `gms_menu_link` VALUES (75,101,-1);
INSERT INTO `gms_menu_link` VALUES (76,102,101);
INSERT INTO `gms_menu_link` VALUES (77,103,101);
INSERT INTO `gms_menu_link` VALUES (78,106,85);
INSERT INTO `gms_menu_link` VALUES (79,107,91);
INSERT INTO `gms_menu_link` VALUES (80,96,-1);
INSERT INTO `gms_menu_link` VALUES (81,97,96);
INSERT INTO `gms_menu_link` VALUES (82,98,96);
INSERT INTO `gms_menu_link` VALUES (83,108,96);
INSERT INTO `gms_menu_link` VALUES (84,109,-1);
INSERT INTO `gms_menu_link` VALUES (85,110,59);
INSERT INTO `gms_menu_link` VALUES (86,111,101);
INSERT INTO `gms_menu_link` VALUES (87,113,101);
INSERT INTO `gms_menu_link` VALUES (88,114,101);
INSERT INTO `gms_menu_link` VALUES (89,115,101);
INSERT INTO `gms_menu_link` VALUES (90,116,101);
INSERT INTO `gms_menu_link` VALUES (91,117,101);
INSERT INTO `gms_menu_link` VALUES (92,122,101);
INSERT INTO `gms_menu_link` VALUES (93,124,68);
INSERT INTO `gms_menu_link` VALUES (95,125,-1);
INSERT INTO `gms_menu_link` VALUES (96,126,125);
INSERT INTO `gms_menu_link` VALUES (97,129,-1);
INSERT INTO `gms_menu_link` VALUES (98,130,129);
INSERT INTO `gms_menu_link` VALUES (99,133,129);
INSERT INTO `gms_menu_link` VALUES (100,134,129);
INSERT INTO `gms_menu_link` VALUES (101,135,129);
INSERT INTO `gms_menu_link` VALUES (102,136,129);
INSERT INTO `gms_menu_link` VALUES (103,138,129);
INSERT INTO `gms_menu_link` VALUES (104,139,129);
INSERT INTO `gms_menu_link` VALUES (105,141,-1);
INSERT INTO `gms_menu_link` VALUES (106,142,-1);
INSERT INTO `gms_menu_link` VALUES (107,143,-1);
INSERT INTO `gms_menu_link` VALUES (108,144,129);
INSERT INTO `gms_menu_link` VALUES (109,145,129);
INSERT INTO `gms_menu_link` VALUES (110,146,129);
INSERT INTO `gms_menu_link` VALUES (111,147,125);
INSERT INTO `gms_menu_link` VALUES (112,148,-1);

