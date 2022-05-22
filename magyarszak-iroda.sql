-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: magyarszak-iroda
-- ------------------------------------------------------
-- Server version	5.5.54-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `category_en` varchar(32) NOT NULL,
  `category_de` varchar(32) NOT NULL,
  `parent` int(8) NOT NULL DEFAULT '0',
  `hidden` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ceglista`
--

DROP TABLE IF EXISTS `ceglista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ceglista` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cegnev` varchar(255) NOT NULL DEFAULT '',
  `cim` varchar(255) NOT NULL DEFAULT '',
  `uzletkid` int(11) NOT NULL DEFAULT '0',
  `felvdat` date NOT NULL DEFAULT '0000-00-00',
  `moddat` date NOT NULL DEFAULT '0000-00-00',
  `allapot` int(11) NOT NULL DEFAULT '0',
  `megj` text NOT NULL,
  `telszam` varchar(255) NOT NULL DEFAULT '',
  `adstatdat` date NOT NULL DEFAULT '0000-00-00',
  `felvitte` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceglista`
--

LOCK TABLES `ceglista` WRITE;
/*!40000 ALTER TABLE `ceglista` DISABLE KEYS */;
INSERT INTO `ceglista` VALUES (1,'BatÃ¡ri Ã‰va','4517 GÃ©gÃ©ny, RÃ¡kÃ³czi u. 7.',1,'2018-03-05','2018-03-07',5,'KarkÃ¶tÅ‘ bruttÃ³ 9990+1490=11.480\r\n9990 (netto 7.866) FutÃ¡r: 03.06. FIZETVE!','06-45/463-166','2018-03-07',0),(2,'NÃ¡nÃ¡sinÃ© Koncz Ãgnes','2723 NyÃ¡regyhÃ¡za, JÃ³zsef Attila Ãºt 10. -- FutÃ¡r: 2723 NyÃ¡regyhÃ¡za, NyÃ¡ry PÃ¡l Ãºt 35 (Polg.Hiv. TitkÃ¡rsÃ¡g)',2,'2018-03-06','2018-03-13',5,'KarkÃ¶tÅ‘ bruttÃ³ 9990+1490=11.480 9990 (netto 7.866) FutÃ¡r: 03.08. FIZETVE!','06-70/361-8316','2018-03-13',0),(3,'HorvÃ¡th ZoltÃ¡nnÃ©','8512 NyÃ¡rÃ¡d, AlkotmÃ¡ny utca 7.',2,'2018-05-02','2018-05-07',5,'KarkÃ¶tÅ‘ bruttÃ³ 11.990+1.490=13.480 11.990 (netto 9.441) FutÃ¡r: 03.08. FIZETVE!','06-20/518-3569','2018-05-07',0),(4,'IllÃ©s KÃ¡lmÃ¡nnÃ©','5471 TiszakÃ¼rt, RÃ¡kÃ³czi Ãºt 4.',3,'2018-05-24','2018-05-29',5,'KarkÃ¶tÅ‘ bruttÃ³ 3x9990=11.480 29.970 (netto 3*7.866=23.598) FutÃ¡r: 05.24.  FIZETVE!','06-30/933-6296','2018-05-29',0),(5,'Szanyi GÃ¡bor','4400 NyÃ­regyhÃ¡za, Malom u. 30.',4,'2018-07-26','2018-07-26',6,'2xKarkÃ¶tÅ‘+1 tÃ¡ncprÃ³ba tea bruttÃ³ 20.000 (netto 15.748) FutÃ¡r: 07.30.','06-20/986-6717','2018-07-26',0),(6,'GÃ©mes IstvÃ¡nnÃ©','8105 PÃ©tfÃ¼rdÅ‘, Berhidai Ãºt 105.',4,'2018-08-28','2018-08-28',6,'1 db KarkÃ¶tÅ‘ \r\nbruttÃ³ 11.490 ft (netto 9047 ft) FutÃ¡r: 08.29.','06-20/250-2438','2018-08-28',0);
/*!40000 ALTER TABLE `ceglista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` text CHARACTER SET utf8 NOT NULL,
  `cname` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `email` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `region` int(2) NOT NULL DEFAULT '0',
  `city` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `tel` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `brands` text COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `description_en` text COLLATE utf8_bin NOT NULL,
  `description_de` text COLLATE utf8_bin NOT NULL,
  `places` text COLLATE utf8_bin NOT NULL,
  `pass` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ts` int(11) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  `advcat` text COLLATE utf8_bin NOT NULL,
  `advcat_en` text COLLATE utf8_bin NOT NULL,
  `advcat_de` text COLLATE utf8_bin NOT NULL,
  `fax` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `iso` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cname` (`cname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `felhasznalok`
--

DROP TABLE IF EXISTS `felhasznalok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `felhasznalok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(16) NOT NULL DEFAULT '',
  `pass` varchar(16) NOT NULL DEFAULT '',
  `who` enum('S','A') NOT NULL DEFAULT 'S',
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `felhasznalok`
--

LOCK TABLES `felhasznalok` WRITE;
/*!40000 ALTER TABLE `felhasznalok` DISABLE KEYS */;
/*!40000 ALTER TABLE `felhasznalok` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kepek`
--

DROP TABLE IF EXISTS `kepek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kepek` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ceg_id` int(5) NOT NULL,
  `url` varchar(40) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=766 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kepek`
--

LOCK TABLES `kepek` WRITE;
/*!40000 ALTER TABLE `kepek` DISABLE KEYS */;
INSERT INTO `kepek` VALUES (216,2926,'6c6ef324c598c44a78ef003f23744e10.jpg'),(217,2926,'78e60f509ca6dcce984176da53346137.jpg'),(223,2921,'51cd7b3d6cc373b74e081df0b7e4b974.jpg'),(224,2921,'4587595cbfaef5a763d8127eddaa0ae0.jpg'),(225,2921,'e4d67e8cf07231f88ac949b5e52f38aa.jpg'),(228,1948,'2c3490d3e8ad38e769560d7b08c3fa69.jpg'),(229,1948,'8b85e4d991da92306478bc6bd6ee9d53.jpg'),(230,1948,'1abd1608cbf94a56e04c43ba170fb624.jpg'),(231,1948,'57557a55e05ca8e7014720ff11288e49.jpg'),(232,1948,'050ee4e94b8fd27ab828c1bac68519e3.jpg'),(233,1948,'d36c9a30c51b1095561292165b18e18c.jpg'),(248,2936,'579884598b8fcfebad867bd81e4f109c.jpg'),(249,2936,'1cbbb363f9a45fbd495c1d686830417a.jpg'),(250,2936,'932e22eb5e52751268f992fe64e0d175.jpg'),(251,2940,'ae99cf1efe2caca7e5f505b070a9d3cc.jpg'),(252,2940,'627cfde0f47e2ef7237a68543f06d7bd.jpg'),(253,2940,'6f62b8b381a7a01033510fc1a8e925ad.jpg'),(254,2988,'f10bd601b60fc21bb0d99fb8f29df9d1.jpg'),(255,2988,'33703101a41476b1080c2480e4063204.jpg'),(256,2988,'e17bb685851c2caf111b6fd78c056133.jpg'),(257,3092,'d1658a84f1e8d2f9525f88909dcc2ccb.jpg'),(258,3092,'3415cd7e7196c8db8af7ecd65b969fd1.jpg'),(259,3092,'63b20a433a824404bd702879236173a4.jpg'),(260,3107,'e412a4a84d19a63c18b83ed528530151.jpg'),(261,3107,'1078f1a0bdc3e11fa532735baecab2f6.jpg'),(262,3107,'d97605d597bfcc50793a35f91fa68e59.JPG'),(263,1480,'0b0db5d9971fe56dcefa081e58fcc201.JPG'),(264,1480,'36793415038216b9d18ccb5d99602b16.JPG'),(266,3311,'d82791aa88dd55f9188e4bf4f9c8522d.jpg'),(268,3179,'fc9d0a1fc53fd39b99d316be98d9fb63.jpg'),(269,3179,'2c39cf2b5cfdd3c65f91a3ee7abf4d2d.jpg'),(270,3179,'981f54104f99cd13ad4e7eac21db8159.jpg'),(271,3329,'4d49a967b59b34edd08293b40b4a2e67.JPG'),(272,3329,'2db4a13eb861c770827089a89a5d1d3a.jpg'),(273,3329,'ee1e60f8a58c0122619b39517aa9387d.jpg'),(274,3519,'6b5afefadabc6134ef2163041e581d2c.jpg'),(275,3519,'5c6c90394ea531f0ea75c0fd3d6f0959.jpg'),(276,3519,'4aa584ac8934e1403cbfd5ea385cdfa5.jpg'),(277,3515,'cdda0a7ba1c91b136a75bf0f93ce2cd7.JPG'),(278,3515,'96019352dec9eec623d0a34edbc6e131.JPG'),(279,3515,'6f74201d0e07daeff646544abb661c26.JPG'),(280,3564,'06bfa938dfb12263a4a4f6ae0a8ec6cb.JPG'),(281,3564,'b08b3b7ae23cc0b10b112102db26c9ec.JPG'),(285,3612,'b91b72ac68904d1e2af0a88a5f388f6b.jpg'),(286,3612,'3561cae1e7005193e6afb3db7cb71f59.jpg'),(287,3612,'15540ceda69c054e6f4805f2b4d9335c.jpg'),(297,3279,'4cb1c823e9a4a984dbd10fa1671d2f9b.JPG'),(298,3886,'63f39090aa3582fd87628408a829aca4.JPG'),(299,3886,'ce30ad0c4bf2753f417df424c694a07c.JPG'),(300,3886,'dba4845c41fc5346e8a19c100eb7d53b.JPG'),(301,3967,'5be2ff4eaaaed79ab918b8efa1a33102.jpg'),(302,3967,'1e9d1b032d518c7b87503175a0fc85f0.jpg'),(306,1844,'870b19cf9f62183f13e47fb6ee7af118.jpg'),(307,1844,'a71daca34aa7668de92a70a11006e890.JPG'),(308,1844,'0fc584b4fb17ee88906c9945a2090769.JPG'),(309,4273,'e36968b835d435ccbcb979e3da8ee613.jpg'),(310,4273,'7712f135df891701db20a1aceb0a29f0.jpg'),(311,4334,'0bd41011d506fda130fc279d46676d37.jpg'),(312,4299,'48d4dcef4f8c558a8f7d088d49c813d7.JPG'),(313,4389,'a635dae7678cf458a5221def7b24001d.jpg'),(314,4389,'abcf998979ceeed803758fe129130e39.jpg'),(315,4389,'9904be91b5b4b0f3ffb7b03bbfa25567.jpg'),(316,2990,'fd13d7d35ec5b978c3d848dbe1c931cb.JPG'),(317,2990,'829553d7eafdafdeb1d922b65364711a.jpg'),(318,2990,'62fcd2dbe721f7516875b579b6409f36.jpg'),(320,4556,'34f642d6431dddaa5740c6e38a08ab45.jpg'),(321,4690,'ab7c1e143fe4be7a11979238ce620b36.jpeg'),(322,4690,'2cd73ba4af6acab578468833a986b32b.jpeg'),(324,4741,'d358110209234a1d0beed5e66d406079.jpg'),(325,4741,'2099c4b964d621dc0b45712b45d5bbb6.jpg'),(326,4741,'78fa623a26f1d39f2a5907529f5715b8.jpg'),(327,1475,'de84ba6bd2a8d144bde772fcc1fdd0b8.jpg'),(328,4989,'af157a19394d73af8efd7937ae0d5363.jpeg'),(331,4532,'9f846d3cb98cbec2ac7f093b8fb617bd.JPG'),(333,4953,'e16353b6a8ea82900f070b7d9c9e2cc0.JPG'),(334,5162,'563c89f6b776c0c79ec03dc9d7c63286.jpg'),(335,5162,'9db1d7a5ba4d3c29ea0decce89a0bace.jpg'),(336,5162,'7e5a3892aeba96844d1d966f31bafff3.jpg'),(337,5081,'3ad5fed03f0b00ace07a1fa43d8d85c3.jpg'),(357,2566,'e2ed46f6f8998c98a0157287cc416a5e.jpg'),(358,2566,'3d321ca3c75ed9749f3562fff9e94c67.jpg'),(359,2566,'01c762355bab19cf05c47b46466c9ac9.jpg'),(360,5182,'59dae438c6f2ee84770edaf5eafe9a9e.JPG'),(361,5182,'fb49213ab9bcfae4e60fa2ef3d260186.JPG'),(362,5182,'ffc3844130f7fc0525f0a6b793facafb.JPG'),(364,5302,'b7fc1525de0048323ad98b1317e1ccb3.jpg'),(365,5124,'0646f71f6715b604ca53f357d1fcc228.jpg'),(366,5124,'4666243636786890f07dae5f3a9d2281.jpg'),(367,5124,'6d1ce94698adcc0d9355ecc2e59e1590.JPG'),(371,5251,'55af1b5706db5bab181833969e416012.jpg'),(372,5430,'a1b3f593f90e7b4fb21fb1dd25c9c044.jpg'),(373,5443,'7226773d8344df921d1475af00b458dd.JPG'),(374,5251,'aeeef4c4e0fb09d71eb3a05b0870d484.JPG'),(375,1888,'f2546fa0990e1758e2642dc2ccd42063.JPG'),(376,5338,'44c5d1ccc57631338550875143d115d6.JPG'),(378,4966,'e0c5359ebb99df96b6e1a62078471847.jpg'),(379,4966,'1b64266dac7f60928ed30011a607e5da.jpg'),(380,4966,'23b0c2fb71827abb7c6a2089af61b87b.jpg'),(381,5475,'19f2a64ea5596cdf4e843f746896bf96.JPG'),(382,5512,'736855b9fd09493a8269081bb57226b5.jpg'),(383,5512,'066005bda25a59ef54b3e713cd91778a.jpg'),(384,5512,'00d412ed4e37b0eda90d56878a2b6882.jpg'),(388,5338,'b7935eaa5da2c0a149aaea706bef4017.JPG'),(398,1230,'98d293450c584c7d4fbba5711f1dee1e.jpg'),(399,1230,'b4a688fa5f01b7f469cdacecfc417f1a.jpg'),(400,1230,'f4b43637b284783ad56378defb3f0c95.jpg'),(401,5316,'357ceaf373fcefdabd44b4bf8a1235f9.JPG'),(402,4989,'3657c747b39c1e0f5b4d99150dd7b60b.jpg'),(403,4989,'20f6981123bb9f20434320e523fbbb53.jpg'),(404,5826,'e4be9cab4a4bee52a62a4f19e728300e.jpg'),(405,5826,'87ae1108599e12d6e4b773d429047174.jpg'),(406,5826,'d05828d9d13a740c28e54fe59850fc60.jpg'),(407,4306,'93cdc02b20a4345c955508e6a0f691cc.jpg'),(408,4306,'1d99e8180fad942ea59b56f4d2d9c788.jpg'),(409,4306,'b594e02a227f22ea901c8c2780775105.jpg'),(410,5874,'27ec462d4df9b6765599d108253c75b2.jpg'),(411,5892,'fcc811b53402c097d2c53707c2548bac.jpg'),(412,5892,'797efd99ae69eda69a7423f1dede2498.jpg'),(413,5892,'32afa6a44c6fe48cebf885093f216068.jpg'),(414,5916,'f0eac347c353cf14436faee5e566d4ae.jpg'),(415,5916,'2b1ef0f8333984c111ff47d9592e37ad.JPG'),(416,5916,'382dec86ce57693a68d01526939f66d4.jpg'),(417,4300,'0e78f18611a61ab82a077760be94f432.jpg'),(418,4300,'92944222ddf35f8b73a63bd0848ded00.jpg'),(419,4300,'d0f72bc4d8ad81798ff44ad1dcdc0acd.jpg'),(420,6153,'e155055a5c0b9dff3aca417f0ddf1dfc.jpeg'),(422,6126,'01684e42d71c2698b6a863b703e388e3.JPG'),(423,6151,'f268b92182770c93c23ef06d4b38a099.jpg'),(424,5707,'e843c736032a1e7be00aa29982de452d.jpg'),(425,6207,'283bc1a50dd7aed177f58d47ec0d349e.jpg'),(427,6375,'d263b39ee589de57cc337025762bddb4.jpg'),(428,6375,'2846c43b583877e5cad63d843997a507.jpg'),(429,6375,'bce4b09542bc18b15293adffacba078d.jpg'),(430,6041,'c7b420a0e56762c67ddfdd8e9cbe4c70.jpg'),(431,6041,'ff5ed9eaf4b7269d5f40e676302c955d.jpg'),(432,6041,'34705fc5bf31c3068b2492d4a63fc3e9.jpg'),(433,6469,'5ac2d9fb64a62874d883de186c61650e.jpg'),(434,6469,'021cda33ac51d7e98a0c58da3c573a2b.jpg'),(435,6469,'5bce19ea4f8e03e6373edff289b75c1b.jpg'),(436,6312,'d1bb4f6a05b65bae5f623e4f238d6e69.jpg'),(437,6312,'0db47d48e5677714e6c35241df2c2107.jpg'),(438,6312,'8a467502caad6301fd8d6ec19a688631.jpg'),(442,6442,'e90281601d2a573117c7c8ffae13d82f.JPG'),(443,6442,'67deca0f0d2a44e491c751b7e0b2ae3a.JPG'),(444,6442,'0ce8e6ab4c7a69a736ee0df0a1c579a4.JPG'),(449,5620,'5f6e235a4b75552acae964030aeea904.jpg'),(450,5620,'e459d739732d17884d362e637336c7e6.jpg'),(451,5620,'5fb23e2db051a27613f404df25aaf9aa.jpg'),(452,6804,'cfd512ab6b968eadf0abce59efd2f06c.JPG'),(453,6804,'82af2f83e09e76e8980e65e59980dda9.JPG'),(454,6804,'7b7dcc73c4e7f194fb985a09846b49be.JPG'),(455,6898,'ab884ef4c108360f19371f3c4749a833.jpg'),(456,6898,'2bcc81a0cc7c90917209f9e79bd2e0d4.jpg'),(457,6898,'f21b9d557ec3c71893f7f18ba977d076.jpg'),(458,6877,'62e4fd300471190930ca8dd73a5ba0cb.jpg'),(459,6877,'f0de9f20f46bc495ff62f5a882651c63.jpg'),(460,6444,'078d09021911f12701274a84fe5d28cb.jpg'),(461,6444,'816246d8a41201da122f2c7f21b7f350.JPG'),(462,6444,'a0033019ec364f48155d3dc60e05712c.JPG'),(463,6914,'82c26025ba6c9c52b3d91db7b5a8f4e2.jpg'),(464,6914,'2b0bdfd1dfc8b0d7bfae975c81a2b7c9.JPG'),(465,6914,'30d6419abad1dd21cfd9124ecb64d922.JPG'),(466,6901,'2da5802de97a09a614038b8e9d4e23ea.jpg'),(467,6901,'73e8836fde214e233adba1f575f8dbc6.jpg'),(468,6901,'3aab3d2e7e69c9ed004039660619d0c6.jpg'),(469,6875,'311222d02cf9f1be0b4adf7bf7628b2c.jpg'),(470,6875,'f383aeafbe5787855e2d701ffd5f8ed3.jpg'),(471,6875,'a0ea253f36849ed2dbfaf2b9f344ba77.jpg'),(472,7047,'1043326fcb34aaee6869116857171d50.JPG'),(473,7047,'f25f6620e26c93dae1ff1847dc523dff.JPG'),(474,7047,'64c89ba0d98166e2a98d64d3d14b021d.JPG'),(478,7133,'8252efae3cc334009187ca004ab25df9.jpg'),(480,7133,'da36839b3fdcc7b2953b2496e7ba6d49.jpg'),(481,7133,'30d47ec0514c4abbec3d1e5f467702c6.jpg'),(482,7192,'083331860efb384e3a8e25c0b7e6d708.JPG'),(483,7192,'7d40cfb48056a28e5c56667d357ab219.jpg'),(484,7192,'f3311d369c3ffb6cda66338466a57ae5.jpg'),(485,7080,'d1216ca88c97244f03ec31c82330541e.JPG'),(486,7080,'806546c0d3e6e0326dba1d8e5e5d4e0d.JPG'),(487,7080,'d1d42b1513dba84068c4320e80c22d86.JPG'),(488,7188,'9de71a624c4708dc592737d9c6c7e42f.jpg'),(489,7188,'511502ca0cb0525b2c0f60f8fb3d207b.jpg'),(490,7008,'855a4d5b84e2f01b1b13c85b789b0602.jpg'),(491,7008,'3cd4125661e1e9acf905e9497f4d41de.jpg'),(492,7008,'9f0da7f5cfae3ea21178f1d9652fe918.jpg'),(497,7272,'20f926aa73ce69d546035971ec8b23fd.JPG'),(498,7286,'a5dc260e09d8601cdaa2ad262f506d30.jpg'),(499,7286,'593eb71c1fc3b9ff6a031338d8d14d1f.jpg'),(500,7286,'459ec5fc86c687786796c3cf52ebd667.jpg'),(501,6897,'2c957c6c6fb4ea4c9d936dafb14820aa.jpg'),(502,6897,'38a49941e8e63b89374e973a39f51333.JPG'),(503,6897,'022188e19bc1b12c0c6ef23d0d3da40c.jpg'),(504,7263,'b03aa0027248772ab5157e06abbcf504.JPG'),(505,7537,'64ae4713ade375d6da7b47d7c3fffd1a.jpg'),(506,7537,'d708dc0e5bdf08db9206c0481360322d.jpg'),(507,7537,'ddd6c3bb234b16da61b757c34f3cf729.jpg'),(508,7500,'68158087e257dde37adb27c220224d43.jpg'),(509,7500,'1548f2c5633f6660a3cd1468849cfada.jpg'),(510,7500,'f57521cbf70cc99eab87ad67ccf905bf.jpg'),(511,7615,'d815fd4f91f4eed9a868e8bd0d064b82.jpg'),(512,7409,'98e1dcf54600eca470d722384c35085c.JPG'),(513,7409,'94a0faa7f61868df4f5a9a869fe1993a.JPG'),(514,7409,'8699eae4bfc9c802f88ac3460ffba830.JPG'),(516,7716,'668d7f10f961dbe8e0e637be11bb72a1.jpg'),(517,7716,'0ecc90e05a4e245db6cd6721359d10ab.jpg'),(518,7716,'244a80fbfd3a9c09c0321f54a7e1c59b.jpg'),(519,7592,'5942d3617f4c2ae87f3e3ab58e1dbc66.jpg'),(520,7592,'ec1cd505b4ccac012c8357865912b69e.jpg'),(521,7592,'5c6f26988aa57072ab67a0ae8e129756.jpg'),(522,7988,'d96d2d5b252e4146b6144142e4aa1e80.jpg'),(523,7988,'2b68b6172a8158ba70aab26256bcfbbf.jpg'),(524,7988,'bb48f41a8b4d1e494abebb1542ea432a.jpg'),(525,7988,'ffc766a1af975055b8809f6fdb1e1a37.jpg'),(526,7988,'43780f482dec2027a279931554aaccdb.jpg'),(527,7988,'da76bd27c24cdfabcabbd86825fbba00.jpg'),(528,4479,'86ec5ec8c3175aa29302d1675471218b.jpg'),(529,4479,'15ce016d3d73659962fbf4002a958328.jpg'),(530,4479,'fe356d2fdd2e13a1fb5340f75f551c40.jpg'),(531,4479,'5f925405dd8f458184df343c169ea3f3.jpg'),(532,4479,'5a844c65ce8c34ac59c3e41371cda09b.jpg'),(535,8056,'8816891df03c0cb63c4c0afda8f52da4.jpg'),(536,8056,'ea7262ad0de7eeaaae50cdc19a5c1f72.jpg'),(537,8056,'74635855194b62a609647b44a1d48b81.jpg'),(538,8056,'d507937d8de63ab28ae3743ae5d2da70.jpg'),(539,8056,'e10f9db48fc70685a9b7920a2846ce3f.jpg'),(540,8051,'643f7015ce6e1df32928a29a1c2b922c.jpg'),(541,8051,'1b53c8af40915ea5947c3ca95aa4ea31.jpg'),(542,8051,'2a9f01a94de0df8a2a6a55b5a3813b58.jpg'),(543,8051,'3b0bd46d757f083cfc41c305a9aa62c3.jpg'),(544,8051,'273ad0d033a4b19d3b4ea7219eceaf13.jpg'),(546,8275,'4d336f29396ab1a0abfe3571275f6aef.jpg'),(547,8275,'3453aaf4ef608fe9435ab0fc63fcc957.jpg'),(548,8275,'d30806f74b070a956175fdbbb654f7ec.jpg'),(549,8157,'17a525c8fe3c4d332dd81896ed7602d5.jpg'),(550,8157,'6f406273b9adf4850a3ee150289c134a.jpg'),(551,8157,'0a3366637c569acb7e90ec8482d1a454.jpg'),(552,8157,'2b74ccf7802f65acad1bf4b6331586ce.jpg'),(553,8157,'9709f108df1bb15467f4685a990a496f.jpg'),(554,8807,'e6190f30feb141cbc4bf6f68f4b6c2ac.JPG'),(555,8807,'89ed3604e6d8de9c2877798f8ab5c88b.jpg'),(556,8867,'a5558658ce35aef603825715b1246254.JPG'),(557,8867,'16a9696e1d78c82063fbd8ad04bbf3c2.jpg'),(558,8867,'8335d6572fc16ad0ebb66f401e358889.jpg'),(559,8990,'8b129aec14eec8a1950bea07005b3181.jpg'),(560,9000,'75d682e85fb3be0756d0cd5c731f8d52.jpg'),(561,9000,'bf8e1a7ee02b86d4bed6fe92e1cadc06.jpg'),(562,8971,'8245f224fa63eaa66238c98a531feee5.jpg'),(563,8971,'65b7aef685d73a72757736ea95742a21.jpg'),(564,8971,'df69222de9bfe5c6ef2c7fa9a1967e4b.jpg'),(565,7139,'9183d8a9d6ce47430c99536caabf6644.jpg'),(566,7139,'cafe619832c8a238a5286708c36e710a.jpg'),(567,9100,'66866d842006bff43005333b3201283f.JPG'),(568,9100,'80e73b92f70c10f2ec9dfe907dc9b027.JPG'),(569,9100,'f8c6d438ffc9658ec1ad2af61900651b.JPG'),(570,8025,'2d44fdac9bf75ffbd3722e1c695c3cc0.jpg'),(571,8025,'d560e72150c27bbcf579c9db06a41250.jpg'),(572,8025,'2c93a136b445485055decd2ddf919c34.JPG'),(573,9205,'1d4c49aa4d8d22db5c50fcdf66cfdeab.JPG'),(574,9205,'b0339b9c68e9ddc584b9bc358a1d8dc6.JPG'),(575,9205,'aa07fb7f853b9c4f738cba2c9815cdf6.JPG'),(576,9209,'11a76473627801c2c0591acb2d698c3a.jpg'),(577,9209,'69103a3e8c8a932582199142f4749a25.jpg'),(578,9209,'d95c40e654fcb3fec2edebfcbb79d55f.jpg'),(579,9038,'d670ddf69c10847d4a7c1aa081d85623.jpg'),(580,9038,'8d10ba13edc353faed81bd859b9fbf13.jpg'),(581,9038,'3d27be85c259159656f9633eb478b893.jpg'),(582,9099,'f996462ef1cce74ca76b2eba0edf4911.jpg'),(583,9099,'78406958692d32f3712ae6dabaf7fb59.jpg'),(584,9164,'b76ca96eb0f4e88f232df27d7df1274c.jpg'),(585,9263,'87b2af0a2df70d5aa4986965e2d668d2.jpg'),(586,9263,'042e938fc07917b57037c244078b722a.jpg'),(587,9263,'9426210f3b72fca5e8d8c6b03419d2e8.jpg'),(588,6668,'f411e2955499affbcd4c3db6b6b90531.jpg'),(590,9278,'17931d7471c15f80675a37d60dfab0f5.jpg'),(591,8958,'61e0288c922c1d4075a84852bb1d758a.jpg'),(592,8958,'f90dce2687797ad475ff1896ac284e84.jpg'),(593,8958,'06d77ce2c0aafd4e63744a871e50874f.jpg'),(594,9292,'b625bda636ace5deeccb915b384abf0a.JPG'),(595,9292,'a16037ef4d9cac8eeafbd9e69c3b04b0.jpg'),(596,9292,'d6ec58aedd9646a77478c03f10c5ef90.JPG'),(597,612,'35f78342a12efce0776a85d566ab8e1e.jpg'),(598,612,'1548f6b2fe4a75ea918c9cc90b1e16c8.jpg'),(599,612,'b23b9ab57820c686e55179446b23255f.jpg'),(600,9564,'3f30662979dd00d6939dff6be81cd2a5.jpg'),(601,9564,'4c639d9c058ae490adc02fcf3606c16c.jpg'),(602,9564,'2b0a3a52e93e7bcb28c93d29e0984418.jpg'),(603,9292,'c3c2a2d3ae816e81a1d8f8abbfa2983c.JPG'),(604,9292,'f9ae85bc0dfda76157f122cc7498fce9.JPG'),(605,8971,'169f1041be46415e09f8894f39c46e99.jpg'),(606,612,'0a441005eef8bae5420b8a54f7688250.jpg'),(607,9603,'71556d7c317f5d3dd8ec229f796e6158.jpg'),(608,9603,'b86fb51e9f5dba83ac6141cd8bb48be3.jpg'),(609,9603,'c7b3f0f04e2c1e6f0a57ba941122b5cd.jpg'),(613,9621,'17dc55cebc014d7583e80a4cc47633f5.JPG'),(614,9621,'cd404f57a5f6a90b8880e368568e0786.JPG'),(615,9621,'3dc6e65aac47e461e8246b3596ddc3af.jpg'),(616,9621,'40020de6cb6d651e59a14317b6a50cc3.jpg'),(617,9548,'db74890bcf9d814cdcb0b3f059ac105f.JPG'),(618,9548,'291bda47353a36c6107c3ba807d91e29.JPG'),(619,9548,'416025ef9408f74702a944415e7f827d.JPG'),(620,9548,'ffccdf18fa4559406567e28a075d3fbd.JPG'),(621,9548,'9b2869df3aed4cd7693a9942815e8f83.JPG'),(623,9681,'706bfe94fa88af77263d1895885fbf9d.jpeg'),(624,9681,'f76eb530af4c4de8d9d897c923528b0c.jpeg'),(627,9681,'62851892ede08c0d54b794c1ffa1f2f4.jpeg'),(629,9629,'2c5445b2b447a1cc31101fb160921c9c.JPG'),(630,9629,'1e2c2edaf6d9f45d413b5fd9af043f7d.JPG'),(633,9629,'a0260787ce93d008ed8252fa29c0e16d.JPG'),(634,9645,'171a1e60e2302676253ea6d9d0dd2b52.jpg'),(635,9645,'7ac09a08406758bbb8b105b6249453d8.jpg'),(636,9645,'5f86404efef540f530f055273af30c20.jpg'),(637,9645,'81fc38317bd58fc696ed8b90b5e97f61.jpg'),(638,9645,'9c4e28a03eff97caa1234819ab47a78d.jpg'),(639,9740,'5958e487a2ba977253487b935d5a6248.jpg'),(640,9740,'e6c8e53eb0d2dc88804106541f8b2aa5.jpg'),(644,9729,'d5d97a7629e93853370e59a26c9b9675.jpg'),(645,9729,'584d57e072df7f7844d4741c8d0c7b71.jpg'),(646,9729,'60ee18c31e09af18a9a8e399871ebcbe.JPG'),(647,9729,'4485bd6176d2e1e0e64cd82e387ebadd.JPG'),(648,9729,'c14682d93bb2e78878e64943fa3f47fd.JPG'),(649,9732,'0fe8271bd339988e9625f920f3240c81.jpg'),(650,9732,'486162674bca3a9c58032142a0c2c894.jpg'),(651,9732,'6cfed9bcf43a14e5e413c32f2a4f89aa.jpg'),(652,9732,'7281a473a692c52692aa8139944ce598.JPG'),(654,9780,'af4c1353a40b3b41afaadd1b8e13d8df.jpg'),(655,9780,'4f2dfa0ac475064f464d925cc0b0e0c4.jpg'),(656,9732,'8a167dbc156c8f96aabdae5d22d814c4.JPG'),(658,9807,'14ced568b1c51bf9af3b460e8d84ac7b.jpg'),(659,9788,'b3a417b8eae4f82cd0e54151efa4af5a.JPG'),(660,9788,'813d9dcd9c9a8ef06d298a836ee3ab6f.JPG'),(661,9788,'213f27a3e44536fe943cd6196f3adf2d.JPG'),(662,9788,'ff89da169bfc9f22efba130094eebd6e.JPG'),(663,9788,'06dce420dcee3d72da2fca40ace74866.jpg'),(664,9633,'b7c95273a806683eeb025349263a6026.jpg'),(665,9633,'b90c9e506cff49196403e70c6b28524a.JPG'),(666,9633,'7d6dcb4afb62011d261133dc5075a615.jpg'),(667,9633,'47f6b29be5f37719e836101916376dcd.jpg'),(668,9837,'6459f94f9ec45b4b43e692a73175796c.jpg'),(669,9837,'1e4ebfd2e606282d64a651b46590a775.jpg'),(670,9837,'80eb9ef569715b9e136fac2afbe2b314.jpg'),(671,9837,'734aab220c129fff51466f8ba251601e.jpg'),(672,9837,'90a4707b5f10aba89773363a2679fe87.jpg'),(673,9611,'b7c015bf0a68daa218a4b9fea41e30f7.JPG'),(674,9611,'f22ee1d4ffe28c5583415fd4ec3d11a2.JPG'),(675,9611,'37241b286723c3f9cb0bf133362c548e.jpg'),(676,9915,'aee75277a34e6f0ee3ae5514a268e03b.jpg'),(677,9915,'4095587ca3096570d910642114bbcf9a.jpg'),(678,9915,'b5f6565cc6e903b5d4bc6ea4708906fd.jpg'),(679,9915,'17f56ea784d79a6ca9bded583ff95306.jpg'),(680,9915,'8755218ad59d940b9f784eb1a8f98602.jpg'),(681,3617,'9b7b162bebf7934c761f998811dd1615.jpg'),(682,1348,'8f29b00fafa4fb0682cef4040d23757c.jpg'),(683,1348,'17ea638cc4348929458b453207a54854.jpg'),(684,1348,'0fe73e78c33b0dbfee291fe19a457f1f.jpg'),(685,1348,'150ef4d76be02ddfc179303258b36020.jpg'),(686,1348,'c57e62d018ea913789972b1e67f46865.jpg'),(687,10046,'04a853573b035a2af0c796a8166cc723.jpg'),(688,10046,'ffce4f779d019444b551821a0612c155.jpg'),(693,10242,'ddf23d6f02f5a12b64bef5c652fed818.jpg'),(694,10242,'37c6ca3e6b374ead1e84a325258b8092.jpg'),(695,10242,'2976c0de13c9f1c576cea2d7439f74bd.jpg'),(696,10242,'fdf59bf3979992efd53ecb3441032406.jpg'),(697,10242,'e14f47c64e2739f2d99f58604170964f.jpg'),(698,7818,'c2a9e88976650a8ee3cdc1e0f241381d.jpg'),(699,7818,'b7d0d6aa46d69f56fb132016c07cfebc.jpg'),(700,7818,'501c7b96323045241ec8e30c8c7f89d7.jpg'),(701,10253,'2e43bcf18fcaedb3c693e1b59ee85539.jpg'),(702,10253,'64e8e9f6783402d40199881a75c9fc2e.JPG'),(703,10253,'c2a5f03e0ae57965102424a3ecddf57d.jpg'),(704,10253,'3ed1c661e86e18417ccd9a57aaa84076.jpg'),(705,10209,'03fa35a18da14437abef9b43de5064ed.JPG'),(706,10209,'f76d26e28b4d0e5fa0accf53acf4b89b.jpg'),(707,10209,'3a383a49570965568256f9ca884d4d15.jpg'),(708,10424,'b8a87165839feea6d5d9b620fd219f22.jpg'),(709,10424,'b3d383f643f9c6ae791f33f48a3f1027.jpg'),(710,10902,'d10dde49a7a71d3b3933bfbf91b776d5.jpg'),(711,10902,'edc2a0ceb871292a8746e5227bcf9253.jpg'),(712,10902,'5f8c1f4421bb6ae20d0c3e02a491cf9d.JPG'),(713,10902,'70d824468bf7bfc6743677e79231ffbf.JPG'),(714,10902,'da396121b3b420d7e19bfe03d516c4aa.jpg'),(715,11019,'6aebdf5c04dd6b249e3b7f6eb34423c2.jpg'),(716,11019,'37be2718f53e9fcf35492364136936c0.jpg'),(717,11019,'2524c9edd951b3f517580b80e913c751.jpg'),(718,10899,'fac271ecef6ee91bd7fcdce5293d0c31.jpg'),(719,10899,'ecf8af183c938be5e11095d35363cb32.jpg'),(720,10899,'197b986604d362f6be2d5dda4313aa08.jpg'),(721,10899,'ca9f7ad33950c94b302959b50e3e2963.jpg'),(722,10899,'ae30fb3b2650825f349464d57d9a2584.jpg'),(723,11087,'168a621911de25355e660876d8f1121a.jpg'),(724,11087,'0a77fa9ba4ca71c8edc829f5890ae2fe.jpg'),(725,11080,'194d0b57a7b6be07daf056c30b8829be.jpg'),(726,11080,'d5ad05fa2e145df71196ef4166343e54.jpg'),(727,11080,'8e0c9166e1135b0329e22edf79a53dbb.JPG'),(728,11080,'94eab558065c2ae4ec57f1d344bb49fe.JPG'),(729,11080,'eebc5b2ef5c11444609b97b1c24f81c0.jpg'),(730,11315,'8b0374f251bc5fb377fd855d492c2e4e.jpg'),(731,11315,'20b2537b140d78adda1247bb79c5afdb.jpg'),(732,11315,'91f27094c97a0175293a61f447d354f8.jpg'),(733,11315,'040b67c7ca3f24a6ed2a9d292b309e27.jpg'),(734,11315,'aca0b8194582c902b817278c25cbde89.jpg'),(735,11294,'1fc408fc891bc730baf323b9543643c7.jpg'),(736,11294,'6ce0ec4b5f0a2cc1d6c9756dc8d6d01e.jpg'),(737,11294,'3dcd7816660ba9a0b82e29093de3c67d.jpg'),(738,11294,'e0ef1e8fc73bba4feda145bc3680f114.jpg'),(739,0,'16f82283ddc31eb6a0a759c932dcffe0.jpg'),(740,0,'41df218eba3729477fda05b09aa31055.jpg'),(741,11413,'5ed05be2ce3b90b67485f36c0cf2dacd.jpg'),(742,11413,'5f99b4d08ea9c654f4743f9c73d8d3c9.jpg'),(743,11414,'0800a5138fd01d0ffad2fbf5d8f4ee17.jpg'),(744,11414,'b399b9ec2b144f4fe9b6fc8e8e834925.jpg'),(745,11414,'32a594e1bf93e49cc62af7929b98c39c.jpg'),(746,11414,'334fb084c77e392a45cc6c781cab597c.jpg'),(747,11414,'5feef07e7a03c4a71fbe8af401471acc.jpg'),(748,11410,'48695e7fecae44f496b1e3e87337127e.JPG'),(749,11410,'3e6efa590da19675a21843936b3191e5.jpg'),(750,11410,'4fec07ff77cf3a2d89ddcbf4c70ecf3a.jpg'),(751,11583,'8dd53fe7ba62d2412355594d168153c7.jpg'),(752,11583,'48bc696cad50f87420c630de03502b7e.jpg'),(753,11583,'7d8e5a51fd47ddc99089cfdac78dc24e.jpg'),(754,11355,'e570fe6607ab3a0617862a2d1cd42bf1.jpg'),(755,11355,'cb0da81f2e710ac45a25164614167052.jpg'),(756,11355,'81da98711bb4a143ea1344ac7c7db2ae.jpg'),(757,11355,'187b4ced2709935e5cedbeb1cf771af1.jpg'),(758,11355,'09dbdcc49a85da6ba1b3ade15448de10.JPG'),(759,11691,'fa22dfdacb3a730010eaa1a7759f4bd3.JPG'),(760,11691,'8110de54c3ca06abf2e9c4f2d3e3af8d.JPG'),(761,11691,'a3618855a9d7975b0ab8b3678f6ff03f.JPG'),(764,11601,'054273dc158d77ecefc8a30d10800fa8.jpg'),(765,11962,'056e0ca31a36c816a36d0a6fa24e611b.jpg');
/*!40000 ALTER TABLE `kepek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fejlec` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `offer` text COLLATE utf8_bin NOT NULL,
  `cID` int(11) NOT NULL DEFAULT '0',
  `ts` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '',
  `type` enum('ker','kin') COLLATE utf8_bin NOT NULL DEFAULT 'ker',
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offers`
--

LOCK TABLES `offers` WRITE;
/*!40000 ALTER TABLE `offers` DISABLE KEYS */;
/*!40000 ALTER TABLE `offers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sorrend`
--

DROP TABLE IF EXISTS `sorrend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sorrend` (
  `cegID` int(5) NOT NULL DEFAULT '0',
  `catID` int(5) NOT NULL DEFAULT '0',
  `hely` int(3) NOT NULL DEFAULT '0',
  KEY `cegID` (`cegID`,`catID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sorrend`
--

LOCK TABLES `sorrend` WRITE;
/*!40000 ALTER TABLE `sorrend` DISABLE KEYS */;
/*!40000 ALTER TABLE `sorrend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `switch`
--

DROP TABLE IF EXISTS `switch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `switch` (
  `cID` int(11) NOT NULL DEFAULT '0',
  `catID` int(11) NOT NULL DEFAULT '0',
  `oID` int(11) NOT NULL DEFAULT '0',
  KEY `cID` (`cID`),
  KEY `catID` (`catID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `switch`
--

LOCK TABLES `switch` WRITE;
/*!40000 ALTER TABLE `switch` DISABLE KEYS */;
/*!40000 ALTER TABLE `switch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `usid` int(11) NOT NULL AUTO_INCREMENT,
  `usemail` varchar(255) NOT NULL DEFAULT '',
  `usname` varchar(255) NOT NULL DEFAULT '',
  `uspass` varchar(255) NOT NULL DEFAULT '',
  `uslim` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'dolgozo@uzleticegtudakozo.hu','MocsÃ¡r Ilona','196804',100),(2,'dolgozo@uzleticegtudakozo.hu','NÃ©gyesi Hajnalka','220830',100),(3,'dolgozo@uzleticegtudakozo.hu','Lantos MargÃ³','margoci',100),(4,'dolgozo@uzleticegtudakozo.hu','HorvÃ¡th ZsÃ³fia','123123',100);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-20 16:32:06
