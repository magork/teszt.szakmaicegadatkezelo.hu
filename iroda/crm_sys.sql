-- MySQL dump 9.11
--
-- Host: localhost    Database: crm_sys
-- ------------------------------------------------------
-- Server version	4.0.24_Debian-10ubuntu2.3-log

--
-- Table structure for table `ceglista`
--

CREATE TABLE `ceglista` (
  `cid` int(11) NOT NULL auto_increment,
  `cegnev` varchar(255) NOT NULL default '',
  `cim` varchar(255) NOT NULL default '',
  `uzletkid` int(11) NOT NULL default '0',
  `felvdat` date NOT NULL default '0000-00-00',
  `moddat` date NOT NULL default '0000-00-00',
  `allapot` int(11) NOT NULL default '0',
  `megj` text NOT NULL,
  PRIMARY KEY  (`cid`)
) TYPE=MyISAM;

--
-- Dumping data for table `ceglista`
--

INSERT INTO `ceglista` VALUES (5,'fghgfh','fgh',63,'2007-12-01','2007-12-02',2,'Blablablaaa bla bla\r\nIze blabla \r\nwww.valami.hu');
INSERT INTO `ceglista` VALUES (6,'Izéke','Budapest',36,'2007-12-01','2007-12-02',7,'');
INSERT INTO `ceglista` VALUES (2,'Innapress Bt.1','Hatvan, Dózsa György utca 9',36,'2007-12-01','2007-12-02',5,'dfgdfg\r\ndfgdfgdfg');
INSERT INTO `ceglista` VALUES (7,'Valami','izéke',63,'2007-12-01','2007-12-02',2,'Gergo ledobta és visszavette');
INSERT INTO `ceglista` VALUES (33,'0002','hbjhkhj',63,'2007-12-01','2007-12-02',5,'ddd');
INSERT INTO `ceglista` VALUES (32,'b12345s','1234',36,'2007-12-02','2007-12-02',6,'Admin átírta\r\nGergo0 nak átadta');
INSERT INTO `ceglista` VALUES (31,'a12345','12345',63,'2007-12-02','2007-12-02',0,'');
INSERT INTO `ceglista` VALUES (25,'Innapress Bt.12','12345 Hatvan',63,'2007-12-02','2007-12-02',6,'Admin regalattra tette');
INSERT INTO `ceglista` VALUES (24,'Mutatom','Nincs seholse',36,'2007-12-02','2007-12-02',1,'hát nem jegyzek meg semmit');
INSERT INTO `ceglista` VALUES (44,'fghf000','hbjhkhj',36,'2007-12-01','2007-12-02',4,'ddd');
INSERT INTO `ceglista` VALUES (46,'000tt','hbjhkhj',63,'2007-12-01','2007-12-02',5,'ddd');

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `usid` int(11) NOT NULL auto_increment,
  `usemail` varchar(255) NOT NULL default '',
  `usname` varchar(255) NOT NULL default '',
  `uspass` varchar(255) NOT NULL default '',
  `uslim` int(11) NOT NULL default '0',
  PRIMARY KEY  (`usid`)
) TYPE=MyISAM;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES (36,'ize@ize.hu54','Gergo0','123454',44);
INSERT INTO `user` VALUES (63,'1222@eee','Gergo','12345',4);

