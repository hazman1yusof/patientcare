/*
SQLyog Enterprise v13.1.1 (64 bit)
MySQL - 5.7.24 : Database - hisdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hisdb` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `hisdb`;

/*Table structure for table `addcode` */

DROP TABLE IF EXISTS `addcode`;

CREATE TABLE `addcode` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(5) DEFAULT NULL,
  `addtype` varchar(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `lastuser` varchar(122) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `admissrc` */

DROP TABLE IF EXISTS `admissrc`;

CREATE TABLE `admissrc` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `admsrccode` varchar(4) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `admflag` tinyint(4) DEFAULT NULL,
  `regflag` tinyint(4) DEFAULT NULL,
  `regfees` tinyint(4) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `addr1` varchar(40) DEFAULT NULL,
  `addr2` varchar(40) DEFAULT NULL,
  `addr3` varchar(40) DEFAULT NULL,
  `addr4` varchar(40) DEFAULT NULL,
  `telno` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL COMMENT 'GP, DOCTOR, HOSPITAL, OTHERS',
  `name` varchar(30) DEFAULT NULL,
  `units` varchar(30) DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `admissrc_admissrcndx` (`compcode`,`admsrccode`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Table structure for table `agent` */

DROP TABLE IF EXISTS `agent`;

CREATE TABLE `agent` (
  `sysno` int(5) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(10) DEFAULT NULL,
  `AgentCode` varchar(20) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `incentiveCode` varchar(10) DEFAULT NULL,
  `AddDate` datetime DEFAULT NULL,
  `AddUser` varchar(10) DEFAULT NULL,
  `UpdDate` datetime DEFAULT NULL,
  `UpdUser` varchar(10) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`sysno`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `agentalloc` */

DROP TABLE IF EXISTS `agentalloc`;

CREATE TABLE `agentalloc` (
  `compcode` varchar(2) DEFAULT NULL,
  `source` varchar(10) DEFAULT NULL,
  `trantype` varchar(30) DEFAULT NULL,
  `auditno` int(11) NOT NULL AUTO_INCREMENT,
  `lineno` int(11) DEFAULT NULL,
  `billno` int(11) DEFAULT NULL,
  `AgentCode` varchar(15) DEFAULT NULL,
  `allocdate` datetime DEFAULT NULL,
  `allocamt` decimal(10,4) DEFAULT NULL,
  `approcess` date DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `paymode` varchar(30) DEFAULT NULL,
  `memberno` varchar(11) DEFAULT NULL,
  `mrn` varchar(11) DEFAULT NULL,
  `updateStat` int(1) DEFAULT '0',
  `payno` varchar(20) DEFAULT NULL,
  `recptno` varchar(11) DEFAULT NULL,
  `nett` decimal(10,4) DEFAULT NULL,
  PRIMARY KEY (`auditno`),
  UNIQUE KEY `drallockey` (`compcode`,`source`,`trantype`,`auditno`,`lineno`,`billno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `agentcomm` */

DROP TABLE IF EXISTS `agentcomm`;

CREATE TABLE `agentcomm` (
  `sysno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `agentcode` varchar(7) DEFAULT NULL,
  `curr_eff_date` datetime DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `effectDate` date DEFAULT NULL,
  `percent` int(3) DEFAULT NULL,
  `ceilingamt` int(10) DEFAULT NULL,
  PRIMARY KEY (`sysno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `agentpay` */

DROP TABLE IF EXISTS `agentpay`;

CREATE TABLE `agentpay` (
  `compcode` varchar(2) NOT NULL DEFAULT '',
  `source` varchar(4) DEFAULT NULL,
  `trantype` varchar(4) DEFAULT NULL,
  `auditno` int(11) NOT NULL AUTO_INCREMENT,
  `payno` int(11) DEFAULT NULL,
  `paydate` date DEFAULT NULL,
  `payAmount` float DEFAULT NULL,
  `agentcode` varchar(11) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` date DEFAULT NULL,
  `processdate` date DEFAULT NULL,
  PRIMARY KEY (`auditno`,`compcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `agenttran` */

DROP TABLE IF EXISTS `agenttran`;

CREATE TABLE `agenttran` (
  `compcode` varchar(2) DEFAULT NULL,
  `source` varchar(10) DEFAULT NULL,
  `trantype` varchar(30) DEFAULT NULL,
  `AuditNo` int(11) NOT NULL AUTO_INCREMENT,
  `lineNo` int(11) DEFAULT NULL,
  `BillNo` int(11) DEFAULT NULL,
  `mrn` varchar(11) DEFAULT NULL,
  `AgentCode` varchar(15) DEFAULT NULL,
  `MemberNo` varchar(20) DEFAULT NULL,
  `invamount` decimal(14,4) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `Lastuser` varchar(10) DEFAULT NULL,
  `Billdate` datetime DEFAULT NULL,
  `ProcessDate` datetime DEFAULT NULL,
  `AgreementID` int(11) DEFAULT NULL,
  `percent` int(2) DEFAULT NULL,
  `updatestat` int(1) DEFAULT '0',
  PRIMARY KEY (`AuditNo`),
  UNIQUE KEY `drtrankey` (`compcode`,`source`,`trantype`,`mrn`,`lineNo`,`BillNo`),
  KEY `charge_trandate` (`compcode`,`AgentCode`,`MemberNo`),
  KEY `drcodetrandate` (`compcode`,`AgentCode`,`MemberNo`),
  KEY `trandate` (`compcode`,`MemberNo`,`AgentCode`),
  KEY `fullypaid` (`compcode`,`MemberNo`),
  KEY `mrn` (`compcode`,`AuditNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `agreement` */

DROP TABLE IF EXISTS `agreement`;

CREATE TABLE `agreement` (
  `compcode` varchar(8) DEFAULT NULL,
  `AgreementID` int(11) NOT NULL AUTO_INCREMENT,
  `AgreementNo` varchar(20) DEFAULT NULL COMMENT 'Open,Issued,Cancel',
  `Status` varchar(1) DEFAULT NULL,
  `AgreementDate` date DEFAULT NULL,
  `JoinDate` date DEFAULT NULL,
  `expdate` date DEFAULT NULL,
  `pkgcode` varchar(7) DEFAULT NULL,
  `adddate` date DEFAULT NULL,
  `adduser` varchar(12) DEFAULT NULL,
  `upddate` date DEFAULT NULL,
  `upduser` varchar(12) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `deluser` varchar(30) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`AgreementID`)
) ENGINE=InnoDB AUTO_INCREMENT=3758 DEFAULT CHARSET=latin1;

/*Table structure for table `agreementtest` */

DROP TABLE IF EXISTS `agreementtest`;

CREATE TABLE `agreementtest` (
  `CompCode` varchar(8) DEFAULT NULL,
  `AgreementID` int(11) NOT NULL AUTO_INCREMENT,
  `AgreementNo` varchar(20) DEFAULT NULL COMMENT 'Open,Issued,Cancel',
  `Status` varchar(1) DEFAULT NULL,
  `AgreementDate` date DEFAULT NULL,
  `JoinDate` date DEFAULT NULL,
  `expdate` date DEFAULT NULL,
  `pkgcode` varchar(7) DEFAULT NULL,
  `adddate` date DEFAULT NULL,
  `adduser` varchar(12) DEFAULT NULL,
  `upddate` date DEFAULT NULL,
  `upduser` varchar(12) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`AgreementID`)
) ENGINE=InnoDB AUTO_INCREMENT=3843 DEFAULT CHARSET=latin1;

/*Table structure for table `apptbook` */

DROP TABLE IF EXISTS `apptbook`;

CREATE TABLE `apptbook` (
  `idno` int(10) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(3) DEFAULT NULL,
  `memberno` varchar(12) DEFAULT NULL,
  `icnum` varchar(20) DEFAULT NULL,
  `apptdatefr` datetime DEFAULT NULL,
  `apptdateto` datetime DEFAULT NULL,
  `mrn` int(11) DEFAULT NULL,
  `pat_name` varchar(30) DEFAULT NULL,
  `location` varchar(40) DEFAULT NULL,
  `loccode` varchar(40) DEFAULT NULL COMMENT 'Doctor / Resource',
  `apptstatus` varchar(15) DEFAULT NULL,
  `apptno` int(11) DEFAULT NULL,
  `prov_id` varchar(30) DEFAULT NULL,
  `fac_id` varchar(30) DEFAULT NULL,
  `remarks` text,
  `adduser` varchar(15) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `lastuser` varchar(15) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `deluser` varchar(15) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `timereq` varchar(30) DEFAULT NULL,
  `timeupdate` varchar(30) DEFAULT NULL,
  `srctype` varchar(30) DEFAULT NULL,
  `telno` varchar(20) DEFAULT NULL,
  `faxno` varchar(20) DEFAULT NULL,
  `telhp` varchar(20) DEFAULT NULL,
  `admsrccode` varchar(4) DEFAULT NULL,
  `case_code` varchar(4) DEFAULT NULL,
  `time24hr` varchar(30) DEFAULT NULL,
  `fees` double(11,2) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `Type` varchar(30) DEFAULT NULL COMMENT 'DOC/RSC/ED',
  `episno` int(11) DEFAULT NULL,
  `episstatus` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  KEY `recstatus` (`recstatus`),
  KEY `TYPE` (`compcode`,`Type`,`apptdatefr`)
) ENGINE=InnoDB AUTO_INCREMENT=131138 DEFAULT CHARSET=latin1;

/*Table structure for table `apptbook_keep` */

DROP TABLE IF EXISTS `apptbook_keep`;

CREATE TABLE `apptbook_keep` (
  `sysno` int(10) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(3) DEFAULT NULL,
  `memberno` varchar(12) DEFAULT NULL,
  `icnum` varchar(20) DEFAULT NULL,
  `apptdate` date DEFAULT NULL,
  `appttime` time DEFAULT NULL,
  `mrn` int(11) DEFAULT NULL,
  `pat_name` varchar(30) DEFAULT NULL,
  `location` varchar(40) DEFAULT NULL,
  `loccode` varchar(40) DEFAULT NULL,
  `apptstatus` varchar(15) DEFAULT NULL,
  `apptno` int(11) DEFAULT NULL,
  `prov_id` varchar(30) DEFAULT NULL,
  `fac_id` varchar(30) DEFAULT NULL,
  `remarks` text,
  `adduser` varchar(15) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `lastuser` varchar(15) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `timereq` varchar(30) DEFAULT NULL,
  `timeupdate` varchar(30) DEFAULT NULL,
  `srctype` varchar(30) DEFAULT NULL,
  `telno` varchar(20) DEFAULT NULL,
  `faxno` varchar(20) DEFAULT NULL,
  `telhp` varchar(20) DEFAULT NULL,
  `admsrccode` varchar(4) DEFAULT NULL,
  `case_code` varchar(4) DEFAULT NULL,
  `time24hr` varchar(30) DEFAULT NULL,
  `fees` double(11,2) DEFAULT NULL,
  PRIMARY KEY (`sysno`)
) ENGINE=InnoDB AUTO_INCREMENT=92468 DEFAULT CHARSET=latin1;

/*Table structure for table `apptbreak` */

DROP TABLE IF EXISTS `apptbreak`;

CREATE TABLE `apptbreak` (
  `startdate` date NOT NULL,
  `doctorcode` varchar(30) DEFAULT NULL,
  `remarks` varchar(80) DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `compcode` varchar(2) DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `ADDDATE` datetime DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `LENGTH` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `apptleave` */

DROP TABLE IF EXISTS `apptleave`;

CREATE TABLE `apptleave` (
  `compcode` varchar(30) DEFAULT NULL,
  `resourcecode` varchar(30) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `datefr` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `ADDDATE` datetime DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `idno` int(30) NOT NULL AUTO_INCREMENT,
  `recstatus` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `apptph` */

DROP TABLE IF EXISTS `apptph`;

CREATE TABLE `apptph` (
  `compcode` varchar(30) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `datefr` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `ADDDATE` datetime DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `idno` int(30) NOT NULL AUTO_INCREMENT,
  `recstatus` varchar(10) DEFAULT NULL,
  `backgroundcolor` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

/*Table structure for table `apptphcolor` */

DROP TABLE IF EXISTS `apptphcolor`;

CREATE TABLE `apptphcolor` (
  `compcode` varchar(15) DEFAULT NULL,
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(20) DEFAULT NULL,
  `phidno` int(11) DEFAULT NULL COMMENT 'appth.idno',
  `userid` varchar(20) DEFAULT NULL COMMENT 'user.username',
  `adduser` varchar(15) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `recstatus` varchar(15) DEFAULT NULL,
  `upduser` varchar(15) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(15) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `apptresrc` */

DROP TABLE IF EXISTS `apptresrc`;

CREATE TABLE `apptresrc` (
  `compcode` varchar(30) DEFAULT NULL,
  `resourcecode` varchar(30) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `ADDDATE` datetime DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `lastuser` varchar(30) DEFAULT NULL,
  `comment_` varchar(40) DEFAULT NULL,
  `TYPE` varchar(30) DEFAULT NULL,
  `idno` int(30) NOT NULL AUTO_INCREMENT,
  `upduser` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Table structure for table `apptresrchdr` */

DROP TABLE IF EXISTS `apptresrchdr`;

CREATE TABLE `apptresrchdr` (
  `compcode` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `lastuser` varchar(30) DEFAULT NULL,
  `comment_` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`compcode`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `apptsession` */

DROP TABLE IF EXISTS `apptsession`;

CREATE TABLE `apptsession` (
  `compcode` varchar(30) DEFAULT NULL,
  `doctorcode` varchar(30) NOT NULL,
  `days` varchar(15) DEFAULT NULL,
  `timefr1` time DEFAULT NULL,
  `timeto1` time DEFAULT NULL,
  `timefr2` time DEFAULT NULL,
  `timeto2` time DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `ADDDATE` datetime DEFAULT NULL,
  `lastuser` varchar(30) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `idno` int(30) NOT NULL AUTO_INCREMENT,
  `recstatus` varchar(20) DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Table structure for table `apptstatus` */

DROP TABLE IF EXISTS `apptstatus`;

CREATE TABLE `apptstatus` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `areacode` */

DROP TABLE IF EXISTS `areacode`;

CREATE TABLE `areacode` (
  `idno` int(5) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `areacode` varchar(4) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `areagroup` int(11) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `adduser` varchar(12) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `deluser` varchar(30) DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `citizen` varchar(30) DEFAULT NULL COMMENT 'MAL; Others;',
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `area` (`areacode`)
) ENGINE=InnoDB AUTO_INCREMENT=500 DEFAULT CHARSET=latin1;

/*Table structure for table `bed` */

DROP TABLE IF EXISTS `bed`;

CREATE TABLE `bed` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `ward` varchar(20) DEFAULT NULL,
  `room` varchar(8) DEFAULT NULL,
  `bednum` varchar(15) DEFAULT NULL,
  `bedtype` varchar(20) DEFAULT NULL,
  `tel_ext` varchar(15) DEFAULT NULL,
  `statistic` tinyint(4) DEFAULT NULL,
  `occup` varchar(30) DEFAULT NULL COMMENT 'vacant, occupied, isolated, maintenance, housekeeping',
  `isolate` tinyint(4) DEFAULT NULL,
  `baby` tinyint(4) DEFAULT NULL,
  `bedstatus` varchar(1) DEFAULT NULL,
  `bedchgcode` varchar(12) DEFAULT NULL,
  `lodchgcode` varchar(12) DEFAULT NULL,
  `mealschgcode` varchar(30) DEFAULT NULL,
  `otherchgcode` varchar(30) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `f1` varchar(30) DEFAULT NULL,
  `f2` varchar(30) DEFAULT NULL,
  `f3` varchar(30) DEFAULT NULL,
  `f4` varchar(30) DEFAULT NULL,
  `f5` varchar(30) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `recstatus` varchar(20) DEFAULT NULL COMMENT 'vacant, occupied, isolated, maintenance, housekeeping',
  `mrn` int(11) DEFAULT NULL,
  `episno` int(11) DEFAULT NULL,
  `name` text COMMENT 'patient name or notes',
  `admdoctor` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `bed_bedkey` (`compcode`,`bednum`),
  KEY `bed_bedtype` (`compcode`,`bedtype`,`bednum`),
  KEY `bed_roomkey` (`compcode`,`room`,`bednum`),
  KEY `bed_wardkey` (`compcode`,`ward`,`bednum`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

/*Table structure for table `bedalloc` */

DROP TABLE IF EXISTS `bedalloc`;

CREATE TABLE `bedalloc` (
  `compcode` varchar(2) DEFAULT NULL,
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `mrn` int(11) NOT NULL,
  `episno` int(11) NOT NULL,
  `anum` int(11) DEFAULT NULL,
  `epistycode` varchar(4) DEFAULT NULL,
  `acode` varchar(4) DEFAULT NULL,
  `atype` varchar(4) DEFAULT NULL,
  `asdate` date DEFAULT NULL,
  `astime` time DEFAULT NULL,
  `aedate` date DEFAULT NULL,
  `aetime` time DEFAULT NULL,
  `aprovide` varchar(4) DEFAULT NULL,
  `astatus` varchar(15) DEFAULT NULL,
  `areason` varchar(256) DEFAULT NULL,
  `servicecode` varchar(4) DEFAULT NULL,
  `ward` varchar(4) DEFAULT NULL,
  `room` varchar(4) DEFAULT NULL,
  `bednum` varchar(7) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `name` varchar(40) NOT NULL,
  `isolate` varchar(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lodgerno` varchar(25) DEFAULT NULL,
  `baby` tinyint(4) DEFAULT NULL,
  `bed2` varchar(30) DEFAULT NULL,
  `bed3` varchar(30) DEFAULT NULL,
  `bed4` varchar(30) DEFAULT NULL,
  `bed5` varchar(30) DEFAULT NULL,
  `bed6` varchar(30) DEFAULT NULL,
  `bed7` varchar(30) DEFAULT NULL,
  `bed8` varchar(30) DEFAULT NULL,
  `bed9` varchar(30) DEFAULT NULL,
  `bed10` varchar(30) DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `bedalloc_allocbedndx` (`compcode`,`mrn`,`episno`,`anum`),
  KEY `bedalloc_bedndx` (`compcode`,`bednum`,`asdate`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Table structure for table `bedtype` */

DROP TABLE IF EXISTS `bedtype`;

CREATE TABLE `bedtype` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `bedtype` varchar(20) NOT NULL,
  `description` varchar(80) DEFAULT NULL,
  `bedchgcode` varchar(12) DEFAULT NULL,
  `lodchgcode` varchar(12) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `grpbedtype` varchar(30) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `bedtype_bedtypendx` (`compcode`,`bedtype`),
  KEY `bedtype_descriptionndx` (`compcode`,`description`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `billhdr` */

DROP TABLE IF EXISTS `billhdr`;

CREATE TABLE `billhdr` (
  `billno` int(10) NOT NULL DEFAULT '0',
  `mrn` varchar(15) NOT NULL DEFAULT '',
  `episno` int(3) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(5) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`billno`,`mrn`,`episno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `billtyitem` */

DROP TABLE IF EXISTS `billtyitem`;

CREATE TABLE `billtyitem` (
  `compcode` varchar(2) DEFAULT NULL,
  `billtype` varchar(5) DEFAULT NULL,
  `chggroup` varchar(4) NOT NULL,
  `chgcode` varchar(12) DEFAULT NULL,
  `price` varchar(22) DEFAULT NULL,
  `percent_` int(3) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `amount` decimal(7,2) DEFAULT NULL,
  `discrate` decimal(7,2) DEFAULT NULL,
  `adduser` varchar(12) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `upduser` varchar(12) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(12) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `idno` int(12) NOT NULL AUTO_INCREMENT,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=2521 DEFAULT CHARSET=latin1;

/*Table structure for table `billtymst` */

DROP TABLE IF EXISTS `billtymst`;

CREATE TABLE `billtymst` (
  `idno` int(12) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `billtype` varchar(5) NOT NULL,
  `opprice` tinyint(4) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `price` varchar(10) DEFAULT NULL,
  `amount` decimal(7,2) DEFAULT NULL,
  `percent_` int(11) DEFAULT NULL,
  `service` tinyint(4) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `discchgcode` varchar(12) DEFAULT NULL,
  `ttacode` varchar(30) DEFAULT NULL,
  `discrate` decimal(7,2) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT 'ACTIVE',
  `adduser` varchar(12) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(12) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

/*Table structure for table `billtype` */

DROP TABLE IF EXISTS `billtype`;

CREATE TABLE `billtype` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `pkgcode` varchar(20) DEFAULT NULL,
  `CompCode` varchar(8) DEFAULT NULL,
  `TypeCode` varchar(15) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `pkgflag` tinyint(1) DEFAULT '0',
  `Addby` varchar(15) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `updateuser` varchar(15) DEFAULT NULL,
  `updateby` date DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `billtype` (`pkgcode`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `billtysvc` */

DROP TABLE IF EXISTS `billtysvc`;

CREATE TABLE `billtysvc` (
  `idno` int(13) NOT NULL AUTO_INCREMENT,
  `compcode` char(2) DEFAULT NULL,
  `billtype` char(5) DEFAULT NULL,
  `chggroup` varchar(4) DEFAULT NULL,
  `price` varchar(10) DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `percent_` decimal(10,0) DEFAULT NULL,
  `allitem` tinyint(4) DEFAULT NULL,
  `alltype` tinyint(4) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` char(13) DEFAULT NULL,
  `discchgcode` char(12) DEFAULT NULL,
  `discrate` decimal(10,0) DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(13) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=300 DEFAULT CHARSET=latin1;

/*Table structure for table `billtytype` */

DROP TABLE IF EXISTS `billtytype`;

CREATE TABLE `billtytype` (
  `idno` int(12) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `billtype` varchar(5) DEFAULT NULL,
  `chggroup` varchar(30) DEFAULT NULL,
  `chgtype` varchar(30) NOT NULL,
  `price` varchar(22) DEFAULT NULL,
  `amount` decimal(7,2) DEFAULT NULL,
  `percent_` decimal(5,2) DEFAULT NULL,
  `allitem` tinyint(4) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `discchgcode` varchar(12) DEFAULT NULL,
  `discrate` decimal(7,2) DEFAULT NULL,
  `adduser` varchar(12) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(12) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(12) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `recstatus` varchar(12) DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `billtytype_tytype1` (`compcode`,`billtype`,`chgtype`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `bloodgroup` */

DROP TABLE IF EXISTS `bloodgroup`;

CREATE TABLE `bloodgroup` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `bloodcode` varchar(11) DEFAULT NULL,
  `Description` varchar(33) DEFAULT NULL,
  `adduser` varchar(22) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `upduser` varchar(13) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `deluser` varchar(30) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `bloodgroup` (`bloodcode`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `casetype` */

DROP TABLE IF EXISTS `casetype`;

CREATE TABLE `casetype` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `case_code` varchar(4) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `grpcasetype` varchar(30) DEFAULT NULL COMMENT 'DELIVERY, REGISTER',
  `actstatus` tinyint(4) DEFAULT NULL,
  `units` varchar(30) DEFAULT NULL,
  `recstatus` varchar(11) DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `casendx` (`compcode`,`case_code`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Table structure for table `chargetrx` */

DROP TABLE IF EXISTS `chargetrx`;

CREATE TABLE `chargetrx` (
  `compcode` varchar(2) DEFAULT NULL,
  `mrn` varchar(15) DEFAULT NULL,
  `episno` int(11) DEFAULT NULL,
  `epistype` varchar(2) DEFAULT NULL,
  `trxtype` varchar(2) DEFAULT NULL COMMENT 'OE, PD, PK',
  `docref` varchar(30) DEFAULT NULL,
  `trxdate` datetime DEFAULT NULL,
  `chgcode` varchar(12) DEFAULT NULL,
  `billcode` int(11) DEFAULT NULL,
  `costcd` varchar(4) DEFAULT NULL,
  `revcd` varchar(4) DEFAULT NULL,
  `mmacode` varchar(30) DEFAULT NULL,
  `billflag` int(4) DEFAULT NULL,
  `billdate` datetime DEFAULT NULL,
  `billtype` varchar(4) DEFAULT NULL,
  `doctorcode` varchar(15) DEFAULT NULL,
  `chg_class` varchar(1) DEFAULT NULL,
  `unitprce` decimal(10,4) DEFAULT NULL,
  `quantity` decimal(8,2) DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `trxtime` time DEFAULT NULL,
  `chggroup` varchar(4) DEFAULT NULL,
  `qstat` varchar(1) DEFAULT NULL,
  `dracccode` varchar(30) DEFAULT NULL,
  `cracccode` varchar(30) DEFAULT NULL,
  `arprocess` int(4) DEFAULT NULL,
  `taxamount` decimal(10,4) DEFAULT NULL,
  `billno` int(11) DEFAULT NULL,
  `auditno` int(11) NOT NULL AUTO_INCREMENT,
  `uom` varchar(4) DEFAULT NULL,
  `billtime` varchar(5) DEFAULT NULL,
  `invgroup` varchar(2) DEFAULT NULL,
  `reqdept` varchar(4) DEFAULT NULL,
  `isudept` varchar(4) DEFAULT NULL,
  `invcode` varchar(30) DEFAULT NULL,
  `resulttype` varchar(4) DEFAULT NULL,
  `resultstatus` int(4) DEFAULT NULL,
  `inventory` int(4) DEFAULT NULL,
  `updinv` int(4) DEFAULT NULL,
  `invbatch` int(11) DEFAULT NULL,
  `doscode` varchar(5) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `instruction` varchar(30) DEFAULT NULL,
  `discamt` decimal(9,4) DEFAULT NULL,
  `disccode` varchar(30) DEFAULT NULL,
  `pkgcode` varchar(12) DEFAULT NULL,
  `remarks` varchar(30) DEFAULT NULL,
  `frequency` varchar(30) DEFAULT NULL,
  `ftxtdosage` varchar(30) DEFAULT NULL,
  `addinstruction` varchar(30) DEFAULT NULL,
  `qtyorder` decimal(7,2) DEFAULT NULL,
  `ipqueueno` int(11) DEFAULT NULL,
  `itemseqno` int(11) DEFAULT NULL,
  `doseqty` decimal(6,2) DEFAULT NULL,
  `freqqty` decimal(5,2) DEFAULT NULL,
  `qtyissue` decimal(7,2) DEFAULT NULL,
  `durationcode` varchar(30) DEFAULT NULL,
  `reqdoctor` varchar(30) DEFAULT NULL,
  `units` varchar(30) DEFAULT NULL,
  `agreementid` varchar(11) DEFAULT NULL,
  `chgtype` varchar(50) DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `daytaken` varchar(15) DEFAULT NULL,
  `qtydispense` decimal(10,2) DEFAULT NULL,
  `takehomeentry` int(11) DEFAULT NULL COMMENT '1 = TRUE, 0 = FALSE',
  `latechargesentry` int(11) DEFAULT NULL COMMENT '1 = TRUE, 0 = FALSE',
  `taxcode` varchar(15) DEFAULT NULL COMMENT 'GSTCODE',
  `recstatus` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`auditno`),
  UNIQUE KEY `mrnepisaud` (`compcode`,`mrn`,`episno`,`auditno`),
  KEY `billdate` (`compcode`,`arprocess`,`billdate`),
  KEY `billno` (`compcode`,`billno`,`chgcode`),
  KEY `chargetrxndx` (`compcode`,`isudept`,`trxdate`),
  KEY `chgcodedate` (`compcode`,`chgcode`,`trxdate`),
  KEY `chginvcode` (`compcode`,`trxdate`,`invcode`),
  KEY `datechgcode` (`compcode`,`trxdate`,`chgcode`),
  KEY `datechggroup` (`compcode`,`trxdate`,`chggroup`),
  KEY `dateepistype` (`compcode`,`trxdate`,`epistype`),
  KEY `drdate` (`compcode`,`doctorcode`,`trxdate`),
  KEY `groupdate` (`compcode`,`chggroup`,`trxdate`),
  KEY `inventory` (`compcode`,`inventory`,`updinv`),
  KEY `ipqueueno` (`compcode`,`ipqueueno`),
  KEY `mrn` (`compcode`,`mrn`,`episno`,`chg_class`,`chggroup`,`chgcode`),
  KEY `mrnepisauddes` (`compcode`,`mrn`,`episno`,`auditno`),
  KEY `mrnepisbil` (`compcode`,`mrn`,`episno`,`billno`),
  KEY `mrnepisgrp` (`compcode`,`mrn`,`episno`,`chggroup`),
  KEY `mrnepisqstat` (`compcode`,`mrn`,`episno`,`qstat`,`amount`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `checked` */

DROP TABLE IF EXISTS `checked`;

CREATE TABLE `checked` (
  `NAME` varchar(80) DEFAULT NULL,
  `IC` varchar(50) DEFAULT NULL,
  `RACE` varchar(2) DEFAULT NULL,
  `SEX` varchar(2) DEFAULT NULL,
  `MRN` varchar(10) DEFAULT NULL,
  `PKGCODE` varchar(10) DEFAULT NULL,
  `DATEJOIN` date DEFAULT NULL,
  `PRICE` decimal(10,2) DEFAULT NULL,
  `OUTSTANDING` decimal(10,2) DEFAULT NULL,
  `agreemenno` varchar(30) DEFAULT NULL,
  `agreementdate` date DEFAULT NULL,
  `expdate` date DEFAULT NULL,
  `mrntype` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `chgclass` */

DROP TABLE IF EXISTS `chgclass`;

CREATE TABLE `chgclass` (
  `idno` int(10) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `classcode` varchar(4) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `classlevel` int(11) DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `computerid` varchar(100) DEFAULT NULL,
  `ipaddress` varchar(100) DEFAULT NULL,
  `lastcomputerid` varchar(100) DEFAULT NULL,
  `lastipaddress` varchar(100) DEFAULT NULL,
  `adduser` varchar(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(11) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(11) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `recstatus` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `chgclass_chgclassndx` (`compcode`,`classcode`,`classlevel`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `chggroup` */

DROP TABLE IF EXISTS `chggroup`;

CREATE TABLE `chggroup` (
  `idno` int(10) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `grpcode` varchar(4) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `qflag` tinyint(4) DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `seqno` int(11) DEFAULT NULL,
  `computerid` varchar(100) DEFAULT NULL,
  `ipaddress` varchar(100) DEFAULT NULL,
  `lastcomputerid` varchar(100) DEFAULT NULL,
  `lastipaddress` varchar(100) DEFAULT NULL,
  `adduser` varchar(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(11) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(11) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `recstatus` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `chggroup` (`compcode`,`grpcode`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

/*Table structure for table `chgmast` */

DROP TABLE IF EXISTS `chgmast`;

CREATE TABLE `chgmast` (
  `idno` int(10) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `chgcode` varchar(12) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `brandname` varchar(30) DEFAULT NULL,
  `revcode` varchar(10) DEFAULT NULL,
  `uom` varchar(4) DEFAULT NULL,
  `packqty` int(11) DEFAULT NULL,
  `invflag` int(4) DEFAULT NULL,
  `overwrite` int(4) DEFAULT NULL,
  `buom` varchar(4) DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `upduser` varchar(13) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `lastfield` varchar(20) DEFAULT NULL,
  `doctorstat` int(4) DEFAULT NULL,
  `chgtype` varchar(8) DEFAULT NULL,
  `chggroup` varchar(8) NOT NULL,
  `qflag` int(4) DEFAULT NULL,
  `costcode` varchar(10) DEFAULT NULL,
  `chgflag` int(4) DEFAULT NULL,
  `ipacccode` varchar(30) DEFAULT NULL,
  `opacccode` varchar(30) DEFAULT NULL,
  `revdept` int(4) DEFAULT NULL,
  `chgclass` varchar(4) DEFAULT NULL,
  `costdept` int(4) DEFAULT NULL,
  `invgroup` varchar(15) DEFAULT NULL,
  `apprccode` varchar(3) DEFAULT NULL,
  `appracct` varchar(30) DEFAULT NULL,
  `active` int(4) DEFAULT NULL,
  `constype` varchar(1) DEFAULT NULL,
  `dosage` tinyint(4) DEFAULT NULL,
  `druggrcode` varchar(30) DEFAULT NULL,
  `subgroup` varchar(30) DEFAULT NULL,
  `stockcode` varchar(30) DEFAULT NULL,
  `seqno` int(11) DEFAULT NULL,
  `instruction` varchar(40) DEFAULT NULL,
  `freqcode` varchar(30) DEFAULT NULL,
  `durationcode` varchar(30) DEFAULT NULL,
  `strength` varchar(30) DEFAULT NULL,
  `units` varchar(30) DEFAULT NULL,
  `durqty` decimal(7,2) DEFAULT NULL,
  `freqqty` decimal(7,2) DEFAULT NULL,
  `doseqty` decimal(7,2) DEFAULT NULL,
  `dosecode` varchar(20) DEFAULT NULL,
  `barcode` varchar(30) DEFAULT NULL,
  `computerid` varchar(100) DEFAULT NULL,
  `ipaddress` varchar(100) DEFAULT NULL,
  `lastcomputerid` varchar(100) DEFAULT NULL,
  `lastipaddress` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  KEY `chgcodeact` (`compcode`,`chgcode`,`active`),
  KEY `chggroup` (`compcode`,`chggroup`),
  KEY `chgtype` (`compcode`,`chgtype`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=4153 DEFAULT CHARSET=latin1;

/*Table structure for table `chgprice` */

DROP TABLE IF EXISTS `chgprice`;

CREATE TABLE `chgprice` (
  `idno` int(10) NOT NULL AUTO_INCREMENT,
  `lineno_` int(11) DEFAULT NULL,
  `compcode` varchar(2) DEFAULT NULL,
  `chgcode` varchar(12) DEFAULT NULL,
  `effdate` date DEFAULT NULL,
  `minamt` decimal(9,2) DEFAULT NULL,
  `amt1` decimal(11,4) DEFAULT '0.0000',
  `amt2` decimal(11,4) DEFAULT '0.0000',
  `amt3` decimal(11,4) DEFAULT '0.0000',
  `iptax` varchar(4) DEFAULT NULL,
  `optax` varchar(4) DEFAULT NULL,
  `maxamt` decimal(9,2) DEFAULT NULL,
  `costprice` decimal(9,2) DEFAULT '0.00',
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastfield` varchar(20) DEFAULT NULL,
  `units` varchar(30) DEFAULT NULL,
  `uom` varchar(30) DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `autopull` tinyint(4) DEFAULT NULL,
  `addchg` tinyint(4) DEFAULT NULL,
  `pkgstatus` varchar(4) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL COMMENT 'ACTIVE / DEACTIVE',
  `deluser` varchar(13) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(100) DEFAULT NULL,
  `lastipaddress` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  KEY `effectdate` (`compcode`,`chgcode`,`effdate`,`uom`)
) ENGINE=InnoDB AUTO_INCREMENT=5820 DEFAULT CHARSET=latin1;

/*Table structure for table `chgtype` */

DROP TABLE IF EXISTS `chgtype`;

CREATE TABLE `chgtype` (
  `idno` int(10) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `chgtype` varchar(4) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `seqno` int(11) DEFAULT NULL,
  `chggroup` varchar(30) DEFAULT NULL,
  `docnoflag` tinyint(4) DEFAULT NULL,
  `mmaflag` tinyint(4) DEFAULT NULL,
  `ipdept` varchar(30) DEFAULT NULL,
  `opdept` varchar(30) DEFAULT NULL,
  `ipacccode` varchar(20) DEFAULT NULL,
  `opacccode` varchar(20) DEFAULT NULL,
  `otcacccode` varchar(30) DEFAULT NULL,
  `invcategory` varchar(30) DEFAULT NULL,
  `computerid` varchar(100) DEFAULT NULL,
  `ipaddress` varchar(100) DEFAULT NULL,
  `lastcomputerid` varchar(100) DEFAULT NULL,
  `lastipaddress` varchar(100) DEFAULT NULL,
  `adduser` varchar(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(11) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(11) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `recstatus` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `chgtype_chgtypendx` (`compcode`,`chgtype`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;

/*Table structure for table `citizen` */

DROP TABLE IF EXISTS `citizen`;

CREATE TABLE `citizen` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `Code` varchar(10) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `deluser` varchar(30) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `religion` (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `compcode` varchar(2) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `costcode` int(11) DEFAULT NULL,
  `password` varchar(10) DEFAULT NULL,
  `appltype` tinyint(4) DEFAULT NULL,
  `serialno` int(11) DEFAULT NULL,
  `expirydate` datetime DEFAULT NULL,
  `baltouse` int(11) DEFAULT NULL,
  `address1` varchar(35) DEFAULT NULL,
  `address2` varchar(35) DEFAULT NULL,
  `address3` varchar(35) DEFAULT NULL,
  `address4` varchar(35) DEFAULT NULL,
  `bmppath1` varchar(40) DEFAULT NULL,
  `bmppath2` varchar(40) DEFAULT NULL,
  `policyno` int(11) DEFAULT NULL,
  `sysdate_` datetime DEFAULT NULL,
  `apinpostdate` varchar(15) DEFAULT NULL,
  `name2` varchar(50) DEFAULT NULL,
  `telno` varchar(30) DEFAULT NULL,
  `faxno` varchar(30) DEFAULT NULL,
  `regno` varchar(10) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `domain` varchar(20) DEFAULT NULL,
  `bgpic` varchar(50) NOT NULL,
  `logo1` varchar(50) NOT NULL,
  `logo1width` varchar(5) NOT NULL,
  `logo2` varchar(50) NOT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `recstatus` varchar(3) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `companylama` */

DROP TABLE IF EXISTS `companylama`;

CREATE TABLE `companylama` (
  `sysno` int(11) NOT NULL AUTO_INCREMENT,
  `compid` varchar(10) NOT NULL,
  `compname` varchar(22) NOT NULL,
  PRIMARY KEY (`sysno`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `corpstaff` */

DROP TABLE IF EXISTS `corpstaff`;

CREATE TABLE `corpstaff` (
  `compcode` varchar(2) DEFAULT NULL,
  `debtorcode` varchar(17) DEFAULT NULL,
  `staffid` varchar(30) DEFAULT NULL,
  `childno` varchar(4) DEFAULT NULL,
  `relatecode` varchar(30) DEFAULT NULL,
  `name` varchar(40) NOT NULL,
  `newic` varchar(12) DEFAULT NULL,
  `oldic` varchar(30) DEFAULT NULL,
  `designcode` varchar(30) DEFAULT NULL,
  `entitlement` varchar(30) DEFAULT NULL,
  `recstatus` tinyint(10) DEFAULT NULL,
  `gltype` varchar(15) DEFAULT NULL,
  `remark` varchar(40) DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `mrn` int(11) DEFAULT NULL,
  `deptcode` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `Code` varchar(12) DEFAULT NULL,
  `Description` varchar(35) DEFAULT NULL,
  `createdBy` varchar(22) DEFAULT NULL,
  `createdDate` date DEFAULT NULL,
  `lastupdate` date DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `recstatus` varchar(12) DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `dbacthdrtest` */

DROP TABLE IF EXISTS `dbacthdrtest`;

CREATE TABLE `dbacthdrtest` (
  `compcode` varchar(2) NOT NULL DEFAULT '',
  `source` varchar(2) NOT NULL,
  `trantype` varchar(2) NOT NULL,
  `auditno` int(11) NOT NULL AUTO_INCREMENT,
  `lineno` int(11) DEFAULT NULL,
  `amount` decimal(9,2) DEFAULT NULL,
  `outamount` decimal(9,2) DEFAULT NULL,
  `hdrsts` varchar(1) DEFAULT NULL,
  `entrydate` date DEFAULT NULL,
  `entrytime` varchar(5) DEFAULT NULL,
  `entryuser` varchar(30) DEFAULT NULL,
  `reference` varchar(40) DEFAULT NULL,
  `recptno` varchar(17) DEFAULT NULL,
  `paymode` varchar(30) DEFAULT NULL,
  `tillcode` varchar(30) DEFAULT NULL,
  `tillno` int(11) DEFAULT NULL,
  `debtortype` varchar(30) DEFAULT NULL,
  `debtorcode` varchar(17) DEFAULT NULL,
  `payercode` varchar(17) DEFAULT NULL,
  `billdebtor` varchar(17) DEFAULT NULL,
  `remark` varchar(40) DEFAULT NULL,
  `mrn` varchar(15) DEFAULT NULL,
  `episno` int(11) DEFAULT NULL,
  `authno` varchar(10) DEFAULT NULL,
  `expdate` date DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `upduser` varchar(10) DEFAULT NULL,
  `epistype` varchar(2) DEFAULT NULL,
  `cbflag` tinyint(4) DEFAULT NULL,
  `conversion` tinyint(4) DEFAULT NULL,
  `payername` varchar(40) DEFAULT NULL,
  `hdrtype` varchar(30) DEFAULT NULL,
  `currency` varchar(30) DEFAULT NULL,
  `rate` decimal(9,4) DEFAULT NULL,
  `units` varchar(30) DEFAULT NULL,
  `docno` varchar(30) DEFAULT NULL,
  `balanceamt` decimal(7,2) DEFAULT NULL,
  `AgentCode` varchar(20) DEFAULT NULL,
  `MemberNo` varchar(20) DEFAULT NULL,
  `pkgcode` varchar(20) DEFAULT NULL,
  `AgreementDate` date DEFAULT NULL,
  `AgreementID` int(11) DEFAULT NULL,
  `JoinDate` date DEFAULT NULL,
  `manualDate` date DEFAULT NULL,
  `manualReceipt` varchar(17) DEFAULT NULL,
  `UpdateStat` tinyint(1) DEFAULT '0',
  `incentivePercent` int(2) DEFAULT NULL,
  PRIMARY KEY (`auditno`),
  KEY `DocNo` (`compcode`,`source`,`trantype`,`docno`),
  KEY `AgreementDate` (`compcode`,`source`,`trantype`,`AgreementDate`),
  KEY `JoinDate` (`compcode`,`source`,`trantype`,`JoinDate`),
  KEY `EntryDate` (`compcode`,`source`,`trantype`,`entrydate`),
  KEY `MRNDate` (`compcode`,`mrn`,`source`,`trantype`,`AgreementDate`)
) ENGINE=InnoDB AUTO_INCREMENT=4459 DEFAULT CHARSET=latin1;

/*Table structure for table `dballoc` */

DROP TABLE IF EXISTS `dballoc`;

CREATE TABLE `dballoc` (
  `compcode` varchar(2) DEFAULT NULL,
  `source` varchar(2) DEFAULT NULL,
  `trantype` varchar(2) DEFAULT NULL,
  `auditno` int(11) NOT NULL AUTO_INCREMENT,
  `lineno` int(11) DEFAULT NULL,
  `docsource` varchar(4) DEFAULT NULL,
  `doctrantype` varchar(2) DEFAULT NULL,
  `docauditno` int(11) DEFAULT NULL,
  `refsource` varchar(2) DEFAULT NULL,
  `reftrantype` varchar(2) DEFAULT NULL,
  `refauditno` int(11) DEFAULT NULL,
  `refamount` decimal(8,2) DEFAULT NULL,
  `reflineno` int(11) DEFAULT NULL,
  `recptno` varchar(17) DEFAULT NULL,
  `mrn` varchar(11) DEFAULT NULL,
  `episno` int(11) DEFAULT NULL,
  `allocsts` varchar(1) DEFAULT NULL,
  `amount` decimal(9,2) DEFAULT NULL,
  `tillcode` varchar(30) DEFAULT NULL,
  `debtortype` varchar(30) DEFAULT NULL,
  `debtorcode` varchar(17) DEFAULT NULL,
  `payercode` varchar(17) DEFAULT NULL,
  `paymode` varchar(30) NOT NULL,
  `paybank` varchar(30) DEFAULT NULL,
  `allocdate` date DEFAULT NULL,
  `remark` varchar(40) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `balance` decimal(7,2) DEFAULT NULL,
  `returnstat` tinyint(4) DEFAULT NULL,
  `docno` varchar(4) DEFAULT NULL,
  `UpdateStat` tinyint(1) DEFAULT '0',
  `agentcode` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`auditno`),
  KEY `returnstat` (`compcode`,`doctrantype`,`returnstat`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;

/*Table structure for table `diagtab` */

DROP TABLE IF EXISTS `diagtab`;

CREATE TABLE `diagtab` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `icdcode` varchar(30) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `description` text,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `crossref` varchar(6) DEFAULT NULL,
  `activatedate` datetime DEFAULT NULL,
  `lowage` int(11) DEFAULT NULL,
  `highage` int(11) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `coderest` int(11) DEFAULT NULL,
  `ageflag` int(11) DEFAULT NULL,
  `extra` varchar(10) DEFAULT NULL,
  `deactivedate` datetime DEFAULT NULL,
  `icdgroup` varchar(30) DEFAULT NULL,
  `lastcomputerid` varchar(100) DEFAULT NULL,
  `lastipaddress` varchar(100) DEFAULT NULL,
  `computerid` varchar(109) DEFAULT NULL,
  `ipaddress` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `diagtab` (`icdcode`,`activatedate`),
  UNIQUE KEY `diagtab2` (`icdcode`,`crossref`,`activatedate`),
  KEY `mainkey` (`type`,`icdcode`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=47805 DEFAULT CHARSET=latin1;

/*Table structure for table `discharge` */

DROP TABLE IF EXISTS `discharge`;

CREATE TABLE `discharge` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `code` varchar(4) DEFAULT NULL,
  `discharge` varchar(30) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `discharge_dischargendx` (`compcode`,`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `discipline` */

DROP TABLE IF EXISTS `discipline`;

CREATE TABLE `discipline` (
  `compcode` varchar(2) DEFAULT NULL,
  `code` varchar(4) DEFAULT NULL,
  `description` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `upduser` varchar(13) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `discplinendx` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Table structure for table `docalloc` */

DROP TABLE IF EXISTS `docalloc`;

CREATE TABLE `docalloc` (
  `compcode` varchar(2) DEFAULT NULL,
  `mrn` int(11) NOT NULL,
  `episno` int(11) NOT NULL,
  `AllocNo` int(11) NOT NULL AUTO_INCREMENT,
  `DoctorCode` varchar(22) NOT NULL,
  `asdate` datetime DEFAULT NULL,
  `astime` time DEFAULT NULL,
  `aedate` datetime DEFAULT NULL,
  `aetime` varchar(5) DEFAULT NULL,
  `aprovide` varchar(4) DEFAULT NULL,
  `astatus` varchar(15) DEFAULT NULL,
  `areason` varchar(256) DEFAULT NULL,
  `servicecode` varchar(4) DEFAULT NULL,
  `doctype` varchar(25) DEFAULT NULL,
  `epistycode` varchar(4) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`AllocNo`),
  UNIQUE KEY `allocdocndx` (`compcode`,`mrn`,`episno`,`AllocNo`),
  KEY `doctorndx` (`compcode`,`mrn`,`episno`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `docstatus` */

DROP TABLE IF EXISTS `docstatus`;

CREATE TABLE `docstatus` (
  `compcode` varchar(2) DEFAULT NULL,
  `statuscode` varchar(4) DEFAULT NULL,
  `Description` varchar(20) DEFAULT NULL,
  `grpdoctype` varchar(30) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `upduser` varchar(13) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `docstatusndx` (`statuscode`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `doctor` */

DROP TABLE IF EXISTS `doctor`;

CREATE TABLE `doctor` (
  `compcode` varchar(2) DEFAULT NULL,
  `doctorcode` varchar(15) DEFAULT NULL,
  `doctorname` varchar(100) NOT NULL,
  `department` varchar(40) DEFAULT NULL,
  `company` varchar(40) DEFAULT NULL,
  `address1` varchar(30) DEFAULT NULL,
  `address2` varchar(30) DEFAULT NULL,
  `address3` varchar(30) DEFAULT NULL,
  `postcode` int(11) DEFAULT NULL,
  `statecode` varchar(20) DEFAULT NULL,
  `countrycode` varchar(20) DEFAULT NULL,
  `res_tel` varchar(9) DEFAULT NULL,
  `tel_hp` varchar(10) DEFAULT NULL,
  `off_tel` varchar(9) DEFAULT NULL,
  `tel_o_ext` varchar(4) DEFAULT NULL,
  `specialitycode` varchar(20) DEFAULT NULL,
  `disciplinecode` varchar(4) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `doctype` varchar(25) DEFAULT NULL,
  `statuscode` varchar(4) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `upduser` varchar(13) DEFAULT NULL,
  `chgcode` varchar(30) DEFAULT NULL,
  `creditorcode` varchar(12) DEFAULT NULL,
  `debtorcode` varchar(30) DEFAULT NULL,
  `contraflag` tinyint(4) DEFAULT NULL,
  `admright` varchar(15) DEFAULT NULL,
  `resigndate` date DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `deptcode` varchar(30) DEFAULT NULL,
  `costcode` varchar(30) DEFAULT NULL,
  `appointment` tinyint(4) DEFAULT NULL,
  `classcode` varchar(30) DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `gstno` int(10) DEFAULT NULL,
  `operationtheatre` varchar(4) DEFAULT NULL,
  `intervaltime` varchar(30) DEFAULT NULL,
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `doctor_doctorndx` (`compcode`,`doctorcode`),
  UNIQUE KEY `doctorndx` (`compcode`,`doctorcode`),
  KEY `doctor_docccidx` (`compcode`,`doctorcode`,`deptcode`,`costcode`),
  KEY `docccidx` (`compcode`,`doctorcode`,`deptcode`,`costcode`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `drugcat` */

DROP TABLE IF EXISTS `drugcat`;

CREATE TABLE `drugcat` (
  `drugcatcode` varchar(30) DEFAULT NULL,
  `drugcatdesc` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `addtime` varchar(30) DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `updtime` varchar(30) DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `compcode` varchar(30) DEFAULT NULL,
  KEY `drugcat_idx1` (`compcode`,`drugcatcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `druggroup` */

DROP TABLE IF EXISTS `druggroup`;

CREATE TABLE `druggroup` (
  `compcode` varchar(2) DEFAULT NULL,
  `druggrcode` varchar(30) DEFAULT NULL,
  `description` varchar(40) DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  UNIQUE KEY `druggroup_key1` (`compcode`,`druggrcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `dummy` */

DROP TABLE IF EXISTS `dummy`;

CREATE TABLE `dummy` (
  `a` varchar(100) DEFAULT NULL,
  `b` varchar(100) DEFAULT NULL,
  `c` varchar(100) DEFAULT NULL,
  `d` varchar(100) DEFAULT NULL,
  `e` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `dummy1` */

DROP TABLE IF EXISTS `dummy1`;

CREATE TABLE `dummy1` (
  `A` varchar(100) DEFAULT NULL,
  `B` varchar(111) DEFAULT NULL,
  `C` varchar(111) DEFAULT NULL,
  `D` varchar(100) DEFAULT NULL,
  `E` varchar(100) DEFAULT NULL,
  `aid` varchar(111) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `dummy2` */

DROP TABLE IF EXISTS `dummy2`;

CREATE TABLE `dummy2` (
  `A` varchar(100) DEFAULT NULL,
  `B` varchar(111) DEFAULT NULL,
  `C` varchar(111) DEFAULT NULL,
  `D` varchar(100) DEFAULT NULL,
  `E` varchar(100) DEFAULT NULL,
  `aid` varchar(111) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `episdiag` */

DROP TABLE IF EXISTS `episdiag`;

CREATE TABLE `episdiag` (
  `compcode` varchar(2) DEFAULT NULL,
  `mrn` int(11) NOT NULL,
  `episno` int(11) DEFAULT NULL,
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `icdcode` varchar(6) DEFAULT NULL,
  `diagstatus` varchar(1) DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `icdcodeno` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `suppcode` varchar(30) DEFAULT NULL,
  `ripdate` datetime DEFAULT NULL,
  `f1` varchar(30) DEFAULT NULL,
  `f2` varchar(30) DEFAULT NULL,
  `f3` varchar(30) DEFAULT NULL,
  `f4` varchar(30) DEFAULT NULL,
  `f5` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`seq`),
  KEY `episdiag_key1` (`compcode`,`mrn`,`episno`,`icdcodeno`,`type`,`icdcode`),
  KEY `episdiag_key2` (`compcode`,`mrn`,`episno`,`icdcodeno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `episode` */

DROP TABLE IF EXISTS `episode`;

CREATE TABLE `episode` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `mrn` varchar(15) NOT NULL,
  `episno` int(11) NOT NULL,
  `admsrccode` varchar(4) DEFAULT NULL,
  `epistycode` varchar(4) DEFAULT NULL,
  `case_code` varchar(4) DEFAULT NULL,
  `ward` varchar(30) DEFAULT NULL,
  `bedtype` varchar(4) DEFAULT NULL,
  `room` varchar(4) DEFAULT NULL,
  `bed` varchar(15) DEFAULT NULL,
  `admdoctor` varchar(15) DEFAULT NULL,
  `attndoctor` varchar(15) DEFAULT NULL,
  `refdoctor` varchar(30) DEFAULT NULL,
  `prescribedays` varchar(15) DEFAULT NULL,
  `pay_type` varchar(11) DEFAULT NULL,
  `pyrmode` varchar(11) DEFAULT NULL,
  `climitauthid` varchar(4) DEFAULT NULL,
  `crnumber` varchar(20) DEFAULT NULL,
  `depositreq` decimal(9,2) DEFAULT NULL,
  `deposit` decimal(9,2) DEFAULT NULL,
  `pkgcode` varchar(30) DEFAULT NULL,
  `billtype` varchar(5) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `episstatus` varchar(5) DEFAULT NULL COMMENT 'D=DISCHARGE C=CANCEL BLANK=CURRENT,B=BILL',
  `episactive` varchar(6) DEFAULT NULL COMMENT '0=false,1=true',
  `adddate` date DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `reg_time` time DEFAULT NULL,
  `dischargedate` date DEFAULT NULL,
  `dischargeuser` varchar(13) DEFAULT NULL,
  `dischargetime` varchar(5) DEFAULT NULL,
  `dischargedest` varchar(30) DEFAULT NULL,
  `allocdoc` int(11) DEFAULT NULL,
  `allocbed` int(11) DEFAULT NULL,
  `allocnok` int(11) DEFAULT NULL,
  `allocpayer` int(11) DEFAULT NULL,
  `allocicd` int(11) DEFAULT NULL,
  `lastupdate` date DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lasttime` varchar(5) DEFAULT NULL,
  `procedure` text,
  `dischargediag` varchar(30) DEFAULT NULL,
  `lodgerno` varchar(4) DEFAULT NULL,
  `regdept` varchar(30) DEFAULT NULL,
  `diet1` varchar(30) DEFAULT NULL,
  `diet2` varchar(30) DEFAULT NULL,
  `diet3` varchar(30) DEFAULT NULL,
  `diet4` varchar(30) DEFAULT NULL,
  `diet5` varchar(30) DEFAULT NULL,
  `glauthid` varchar(30) DEFAULT NULL,
  `treatment` text,
  `diagcode` varchar(30) DEFAULT NULL,
  `complain` varchar(255) DEFAULT NULL,
  `diagfinal` text,
  `clinicalnote` varchar(255) DEFAULT NULL,
  `conversion` int(4) DEFAULT NULL,
  `newcaseP` int(4) DEFAULT NULL,
  `newcaseNP` int(4) DEFAULT NULL,
  `followupP` int(4) DEFAULT NULL,
  `followupNP` int(4) DEFAULT NULL,
  `bed2` varchar(30) DEFAULT NULL,
  `bed3` varchar(30) DEFAULT NULL,
  `bed4` varchar(30) DEFAULT NULL,
  `bed5` varchar(30) DEFAULT NULL,
  `bed6` varchar(30) DEFAULT NULL,
  `bed7` varchar(30) DEFAULT NULL,
  `bed8` varchar(30) DEFAULT NULL,
  `bed9` varchar(30) DEFAULT NULL,
  `bed10` varchar(30) DEFAULT NULL,
  `diagprov` text,
  `visitcase` varchar(30) DEFAULT NULL,
  `PkgAutoNo` int(11) DEFAULT NULL,
  `AgreementID` varchar(11) DEFAULT NULL,
  `AdminFees` int(2) DEFAULT NULL COMMENT '1 - True, 0 False      ',
  `EDDept` varchar(5) DEFAULT NULL,
  `dischargestatus` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `episodendx` (`compcode`,`mrn`,`episno`),
  KEY `admdate` (`compcode`,`reg_date`),
  KEY `bedndx` (`compcode`,`bed`,`episactive`),
  KEY `discdate` (`compcode`,`dischargedate`),
  KEY `episstatus` (`compcode`,`episstatus`,`mrn`,`episno`),
  KEY `followup` (`compcode`,`followupP`,`reg_date`),
  KEY `lodgerndx` (`compcode`,`episactive`,`lodgerno`),
  KEY `newcase` (`compcode`,`newcaseP`,`reg_date`),
  KEY `paytype` (`compcode`,`pay_type`,`reg_date`),
  KEY `pregnant` (`compcode`,`newcaseNP`,`reg_date`),
  KEY `regdept` (`compcode`,`regdept`),
  KEY `typedate` (`compcode`,`epistycode`,`reg_date`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `epispayer` */

DROP TABLE IF EXISTS `epispayer`;

CREATE TABLE `epispayer` (
  `compcode` varchar(2) DEFAULT NULL,
  `mrn` varchar(15) NOT NULL,
  `episno` int(11) DEFAULT NULL,
  `payercode` varchar(12) NOT NULL,
  `lineno` int(11) NOT NULL,
  `epistycode` varchar(4) DEFAULT NULL,
  `pay_type` varchar(11) DEFAULT NULL,
  `pyrmode` varchar(11) DEFAULT NULL,
  `pyrcharge` tinyint(4) DEFAULT '0',
  `pyrcrdtlmt` tinyint(4) DEFAULT '0',
  `pyrlmtamt` decimal(9,2) DEFAULT '9999999.99',
  `totbal` decimal(9,2) DEFAULT '9999999.99',
  `allgroup` tinyint(4) DEFAULT '0',
  `alldept` tinyint(4) DEFAULT '0',
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `billtype` varchar(5) DEFAULT NULL,
  `refno` varchar(20) DEFAULT NULL,
  `chgrate` decimal(5,2) DEFAULT NULL,
  KEY `payerndx` (`compcode`,`payercode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `epistype` */

DROP TABLE IF EXISTS `epistype`;

CREATE TABLE `epistype` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `epistycode` varchar(4) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `firstchgcode` varchar(12) DEFAULT NULL,
  `subschgcode` varchar(12) DEFAULT NULL,
  `activatedate` datetime DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `epistype_epistypendx` (`compcode`,`epistycode`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `guarantee` */

DROP TABLE IF EXISTS `guarantee`;

CREATE TABLE `guarantee` (
  `compcode` varchar(2) DEFAULT NULL,
  `debtorcode` varchar(12) NOT NULL,
  `staffid` varchar(30) DEFAULT NULL,
  `relatecode` varchar(30) DEFAULT NULL,
  `childno` varchar(4) DEFAULT NULL,
  `refno` varchar(20) DEFAULT NULL,
  `gltype` varchar(15) DEFAULT NULL COMMENT 'MULTIPLE VOLUME,MULTIPLE DATE,OPEN,SINGLE USE',
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `visitno` int(11) DEFAULT NULL,
  `visitbal` int(11) DEFAULT NULL,
  `medcase` varchar(40) DEFAULT NULL,
  `remark` varchar(40) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `ourrefno` varchar(20) DEFAULT NULL,
  `mrn` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `episno` int(11) DEFAULT NULL,
  `lineno_` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `incentive` */

DROP TABLE IF EXISTS `incentive`;

CREATE TABLE `incentive` (
  `sysno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `incentivecode` varchar(7) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `curr_eff_date` datetime DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `effectDate` date DEFAULT NULL,
  `percent` int(3) DEFAULT NULL,
  `amount` int(10) DEFAULT NULL,
  PRIMARY KEY (`sysno`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Table structure for table `incentivepercent` */

DROP TABLE IF EXISTS `incentivepercent`;

CREATE TABLE `incentivepercent` (
  `compcode` varchar(2) DEFAULT NULL,
  `amount` int(10) DEFAULT NULL,
  `percent` int(4) DEFAULT NULL,
  `effectivedate` date DEFAULT NULL,
  `createby` varchar(15) DEFAULT NULL,
  `createdate` date DEFAULT NULL,
  `updateby` varchar(15) DEFAULT NULL,
  `updatedate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `languagecode` */

DROP TABLE IF EXISTS `languagecode`;

CREATE TABLE `languagecode` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) NOT NULL,
  `Code` varchar(10) NOT NULL,
  `Description` varchar(30) NOT NULL,
  `recstatus` varchar(10) NOT NULL,
  `deluser` varchar(30) DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `language` (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

/*Table structure for table `marital` */

DROP TABLE IF EXISTS `marital`;

CREATE TABLE `marital` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `code` varchar(4) DEFAULT NULL,
  `Description` varchar(30) DEFAULT NULL,
  `adduser` varchar(22) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `recstatus` varchar(8) DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `marital` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `membership` */

DROP TABLE IF EXISTS `membership`;

CREATE TABLE `membership` (
  `sysno` int(11) NOT NULL AUTO_INCREMENT,
  `CompCode` varchar(6) DEFAULT NULL,
  `MemberNo` int(20) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `MRN` varchar(15) DEFAULT NULL,
  `Episno` varchar(11) DEFAULT '0',
  `Name` varchar(120) DEFAULT NULL,
  `Call-Name` varchar(90) DEFAULT NULL,
  `addtype` varchar(12) DEFAULT NULL,
  `Address1` varchar(765) DEFAULT NULL,
  `Address2` varchar(765) DEFAULT NULL,
  `Address3` varchar(765) DEFAULT NULL,
  `Postcode` varchar(8) DEFAULT NULL,
  `citycode` varchar(60) DEFAULT NULL,
  `AreaCode` varchar(12) DEFAULT NULL,
  `StateCode` varchar(12) DEFAULT NULL,
  `CountryCode` varchar(12) DEFAULT NULL,
  `telh` varchar(30) NOT NULL,
  `telhp` varchar(30) DEFAULT NULL,
  `telo` varchar(30) DEFAULT NULL,
  `Tel-O-Ext` varchar(12) DEFAULT NULL,
  `ID-Type` varchar(12) DEFAULT NULL,
  `idnumber` varchar(45) DEFAULT NULL,
  `Newic` varchar(42) DEFAULT NULL,
  `Oldic` varchar(24) DEFAULT NULL,
  `icolor` varchar(24) DEFAULT NULL,
  `Sex` varchar(3) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Religion` varchar(12) DEFAULT NULL,
  `AllergyCode1` varchar(12) DEFAULT NULL,
  `AllergyCode2` varchar(12) DEFAULT NULL,
  `Century` varchar(5) DEFAULT NULL,
  `Citizencode` varchar(12) DEFAULT NULL,
  `OccupCode` varchar(12) DEFAULT NULL,
  `Staffid` varchar(24) DEFAULT NULL,
  `MaritalCode` varchar(12) DEFAULT NULL,
  `LanguageCode` varchar(12) DEFAULT NULL,
  `TitleCode` varchar(30) DEFAULT NULL,
  `RaceCode` varchar(12) DEFAULT NULL,
  `bloodgrp` varchar(6) DEFAULT NULL,
  `Accum-chg` varchar(5) DEFAULT NULL,
  `Accum-Paid` varchar(5) DEFAULT NULL,
  `first-visit-date` date DEFAULT NULL,
  `Reg-Date` date DEFAULT NULL,
  `last-visit-date` date DEFAULT NULL,
  `last-episno` varchar(8) DEFAULT NULL,
  `PatStatus` varchar(1) DEFAULT NULL,
  `Confidential` varchar(1) DEFAULT NULL,
  `Active` varchar(1) DEFAULT '1',
  `FirstIpEpisNo` varchar(5) DEFAULT NULL,
  `FirstOpEpisNo` varchar(5) DEFAULT NULL,
  `AddUser` varchar(39) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `Lastupdate` date DEFAULT NULL,
  `LastUser` varchar(39) DEFAULT NULL,
  `OffAdd1` varchar(105) DEFAULT NULL,
  `OffAdd2` varchar(105) DEFAULT NULL,
  `OffAdd3` varchar(105) DEFAULT NULL,
  `OffAdd4` varchar(105) DEFAULT NULL,
  `MRFolder` varchar(1) DEFAULT NULL,
  `MRLoc` varchar(24) DEFAULT NULL,
  `MRActive` varchar(24) DEFAULT NULL,
  `OldMrn` varchar(30) DEFAULT NULL,
  `NewMrn` varchar(5) DEFAULT NULL,
  `Remarks` varchar(1000) DEFAULT NULL,
  `RelateCode` varchar(24) DEFAULT NULL,
  `ChildNo` varchar(12) DEFAULT NULL,
  `CorpComp` varchar(24) DEFAULT NULL,
  `Email` varchar(60) DEFAULT NULL,
  `CurrentEpis` varchar(24) DEFAULT NULL,
  `NameSndx` varchar(60) DEFAULT NULL,
  `BirthPlace` varchar(24) DEFAULT NULL,
  `TngID` varchar(24) DEFAULT NULL,
  `PatientImage` varchar(24) DEFAULT NULL,
  `pAdd1` varchar(120) DEFAULT NULL,
  `pAdd2` varchar(120) DEFAULT NULL,
  `pAdd3` varchar(120) DEFAULT NULL,
  `pPostCode` varchar(8) DEFAULT NULL,
  `DeptCode` varchar(24) DEFAULT NULL,
  `DeceasedDate` date DEFAULT NULL,
  `PkgCode` varchar(24) DEFAULT NULL,
  `AgentCode` varchar(20) DEFAULT NULL,
  `Agreementid` int(11) DEFAULT NULL,
  `TelFax` varchar(30) DEFAULT NULL,
  `MRNType` varchar(1) DEFAULT NULL,
  `wkitstat` varchar(5) DEFAULT NULL,
  `spname` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`sysno`,`telh`),
  KEY `NewIndex1` (`Agreementid`)
) ENGINE=InnoDB AUTO_INCREMENT=4884 DEFAULT CHARSET=latin1;

/*Table structure for table `membershipcopy` */

DROP TABLE IF EXISTS `membershipcopy`;

CREATE TABLE `membershipcopy` (
  `sysno` int(11) NOT NULL AUTO_INCREMENT,
  `CompCode` varchar(6) DEFAULT NULL,
  `MemberNo` int(20) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `MRN` varchar(15) DEFAULT NULL,
  `Episno` varchar(11) DEFAULT '0',
  `Name` varchar(120) DEFAULT NULL,
  `Call-Name` varchar(90) DEFAULT NULL,
  `addtype` varchar(12) DEFAULT NULL,
  `Address1` varchar(765) DEFAULT NULL,
  `Address2` varchar(765) DEFAULT NULL,
  `Address3` varchar(765) DEFAULT NULL,
  `Postcode` varchar(8) DEFAULT NULL,
  `citycode` varchar(60) DEFAULT NULL,
  `AreaCode` varchar(12) DEFAULT NULL,
  `StateCode` varchar(12) DEFAULT NULL,
  `CountryCode` varchar(12) DEFAULT NULL,
  `telh` varchar(30) NOT NULL,
  `telhp` varchar(30) DEFAULT NULL,
  `telo` varchar(30) DEFAULT NULL,
  `Tel-O-Ext` varchar(12) DEFAULT NULL,
  `ID-Type` varchar(12) DEFAULT NULL,
  `idnumber` varchar(45) DEFAULT NULL,
  `Newic` varchar(42) DEFAULT NULL,
  `Oldic` varchar(24) DEFAULT NULL,
  `icolor` varchar(24) DEFAULT NULL,
  `Sex` varchar(3) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Religion` varchar(12) DEFAULT NULL,
  `AllergyCode1` varchar(12) DEFAULT NULL,
  `AllergyCode2` varchar(12) DEFAULT NULL,
  `Century` varchar(5) DEFAULT NULL,
  `Citizencode` varchar(12) DEFAULT NULL,
  `OccupCode` varchar(12) DEFAULT NULL,
  `Staffid` varchar(24) DEFAULT NULL,
  `MaritalCode` varchar(12) DEFAULT NULL,
  `LanguageCode` varchar(12) DEFAULT NULL,
  `TitleCode` varchar(30) DEFAULT NULL,
  `RaceCode` varchar(12) DEFAULT NULL,
  `bloodgrp` varchar(6) DEFAULT NULL,
  `Accum-chg` varchar(5) DEFAULT NULL,
  `Accum-Paid` varchar(5) DEFAULT NULL,
  `first-visit-date` date DEFAULT NULL,
  `Reg-Date` date DEFAULT NULL,
  `last-visit-date` date DEFAULT NULL,
  `last-episno` varchar(8) DEFAULT NULL,
  `PatStatus` varchar(1) DEFAULT NULL,
  `Confidential` varchar(1) DEFAULT NULL,
  `Active` varchar(1) DEFAULT NULL,
  `FirstIpEpisNo` varchar(5) DEFAULT NULL,
  `FirstOpEpisNo` varchar(5) DEFAULT NULL,
  `AddUser` varchar(39) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `Lastupdate` date DEFAULT NULL,
  `LastUser` varchar(39) DEFAULT NULL,
  `OffAdd1` varchar(105) DEFAULT NULL,
  `OffAdd2` varchar(105) DEFAULT NULL,
  `OffAdd3` varchar(105) DEFAULT NULL,
  `OffAdd4` varchar(105) DEFAULT NULL,
  `MRFolder` varchar(1) DEFAULT NULL,
  `MRLoc` varchar(24) DEFAULT NULL,
  `MRActive` varchar(24) DEFAULT NULL,
  `OldMrn` varchar(30) DEFAULT NULL,
  `NewMrn` varchar(5) DEFAULT NULL,
  `Remarks` varchar(1000) DEFAULT NULL,
  `RelateCode` varchar(24) DEFAULT NULL,
  `ChildNo` varchar(12) DEFAULT NULL,
  `CorpComp` varchar(24) DEFAULT NULL,
  `Email` varchar(60) DEFAULT NULL,
  `CurrentEpis` varchar(24) DEFAULT NULL,
  `NameSndx` varchar(60) DEFAULT NULL,
  `BirthPlace` varchar(24) DEFAULT NULL,
  `TngID` varchar(24) DEFAULT NULL,
  `PatientImage` varchar(24) DEFAULT NULL,
  `pAdd1` varchar(120) DEFAULT NULL,
  `pAdd2` varchar(120) DEFAULT NULL,
  `pAdd3` varchar(120) DEFAULT NULL,
  `pPostCode` varchar(8) DEFAULT NULL,
  `DeptCode` varchar(24) DEFAULT NULL,
  `DeceasedDate` date DEFAULT NULL,
  `PkgCode` varchar(24) DEFAULT NULL,
  `AgentCode` varchar(20) DEFAULT NULL,
  `Agreementid` int(11) DEFAULT NULL,
  `TelFax` varchar(30) DEFAULT NULL,
  `MRNType` varchar(1) DEFAULT NULL,
  `wkitstat` varchar(5) DEFAULT NULL,
  `spname` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`sysno`,`telh`)
) ENGINE=InnoDB AUTO_INCREMENT=4544 DEFAULT CHARSET=latin1;

/*Table structure for table `membershiptest` */

DROP TABLE IF EXISTS `membershiptest`;

CREATE TABLE `membershiptest` (
  `sysno` double NOT NULL AUTO_INCREMENT,
  `CompCode` int(6) DEFAULT NULL,
  `MemberNo` varchar(20) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `MRN` varchar(15) DEFAULT NULL,
  `Episno` int(11) DEFAULT '0',
  `Name` varchar(120) DEFAULT NULL,
  `Call-Name` varchar(90) DEFAULT NULL,
  `addtype` varchar(12) DEFAULT NULL,
  `Address1` varchar(765) DEFAULT NULL,
  `Address2` varchar(765) DEFAULT NULL,
  `Address3` varchar(765) DEFAULT NULL,
  `Postcode` double DEFAULT NULL,
  `citycode` varchar(60) DEFAULT NULL,
  `AreaCode` varchar(12) DEFAULT NULL,
  `StateCode` varchar(12) DEFAULT NULL,
  `CountryCode` varchar(12) DEFAULT NULL,
  `telh` varchar(30) DEFAULT NULL,
  `telhp` varchar(30) DEFAULT NULL,
  `telo` varchar(30) DEFAULT NULL,
  `Tel-O-Ext` varchar(12) DEFAULT NULL,
  `ID-Type` varchar(12) DEFAULT NULL,
  `idnumber` varchar(45) DEFAULT NULL,
  `Newic` varchar(42) DEFAULT NULL,
  `Oldic` varchar(24) DEFAULT NULL,
  `icolor` varchar(24) DEFAULT NULL,
  `Sex` varchar(3) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Religion` varchar(12) DEFAULT NULL,
  `AllergyCode1` varchar(12) DEFAULT NULL,
  `AllergyCode2` varchar(12) DEFAULT NULL,
  `Century` double DEFAULT NULL,
  `Citizencode` varchar(12) DEFAULT NULL,
  `OccupCode` varchar(12) DEFAULT NULL,
  `Staffid` varchar(24) DEFAULT NULL,
  `MaritalCode` varchar(12) DEFAULT NULL,
  `LanguageCode` varchar(12) DEFAULT NULL,
  `TitleCode` varchar(30) DEFAULT NULL,
  `RaceCode` varchar(12) DEFAULT NULL,
  `bloodgrp` varchar(6) DEFAULT NULL,
  `Accum-chg` float DEFAULT NULL,
  `Accum-Paid` float DEFAULT NULL,
  `first-visit-date` date DEFAULT NULL,
  `Reg-Date` date DEFAULT NULL,
  `last-visit-date` date DEFAULT NULL,
  `last-episno` double DEFAULT NULL,
  `PatStatus` tinyint(1) DEFAULT NULL,
  `Confidential` tinyint(1) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT NULL,
  `FirstIpEpisNo` double DEFAULT NULL,
  `FirstOpEpisNo` double DEFAULT NULL,
  `AddUser` varchar(39) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `Lastupdate` date DEFAULT NULL,
  `LastUser` varchar(39) DEFAULT NULL,
  `OffAdd1` varchar(105) DEFAULT NULL,
  `OffAdd2` varchar(105) DEFAULT NULL,
  `OffAdd3` varchar(105) DEFAULT NULL,
  `OffAdd4` varchar(105) DEFAULT NULL,
  `MRFolder` tinyint(1) DEFAULT NULL,
  `MRLoc` varchar(24) DEFAULT NULL,
  `MRActive` varchar(24) DEFAULT NULL,
  `OldMrn` varchar(30) DEFAULT NULL,
  `NewMrn` double DEFAULT NULL,
  `Remarks` varchar(1000) DEFAULT NULL,
  `RelateCode` varchar(24) DEFAULT NULL,
  `ChildNo` varchar(12) DEFAULT NULL,
  `CorpComp` varchar(24) DEFAULT NULL,
  `Email` varchar(60) DEFAULT NULL,
  `CurrentEpis` varchar(24) DEFAULT NULL,
  `NameSndx` varchar(60) DEFAULT NULL,
  `BirthPlace` varchar(24) DEFAULT NULL,
  `TngID` varchar(24) DEFAULT NULL,
  `PatientImage` varchar(24) DEFAULT NULL,
  `pAdd1` varchar(120) DEFAULT NULL,
  `pAdd2` varchar(120) DEFAULT NULL,
  `pAdd3` varchar(120) DEFAULT NULL,
  `pPostCode` double DEFAULT NULL,
  `DeptCode` varchar(24) DEFAULT NULL,
  `DeceasedDate` date DEFAULT NULL,
  `PkgCode` varchar(24) DEFAULT NULL,
  `AgentCode` varchar(20) DEFAULT NULL,
  `Agreementid` int(11) DEFAULT NULL,
  `TelFax` varchar(30) DEFAULT NULL,
  `MRNType` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`sysno`)
) ENGINE=InnoDB AUTO_INCREMENT=5066 DEFAULT CHARSET=latin1;

/*Table structure for table `mmamaster` */

DROP TABLE IF EXISTS `mmamaster`;

CREATE TABLE `mmamaster` (
  `idno` int(11) DEFAULT NULL,
  `compcode` varchar(2) DEFAULT NULL,
  `mmacode` varchar(5) DEFAULT NULL,
  `description` text,
  `version` varchar(30) DEFAULT NULL,
  `category` varchar(7) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `effdate` datetime DEFAULT NULL,
  `mmaclass` varchar(30) DEFAULT NULL,
  `mmagroup` varchar(30) DEFAULT NULL,
  `mmasubgrp` varchar(30) DEFAULT NULL,
  `code1` varchar(30) DEFAULT NULL,
  `code2` varchar(30) DEFAULT NULL,
  `recstatus` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  UNIQUE KEY `mmamasterndx` (`compcode`,`mmacode`,`version`),
  KEY `mmaclass` (`compcode`,`mmaclass`,`mmagroup`,`mmasubgrp`),
  KEY `mmagroup` (`compcode`,`mmagroup`,`mmasubgrp`),
  KEY `mmasubgrp` (`compcode`,`mmagroup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mmaprice` */

DROP TABLE IF EXISTS `mmaprice`;

CREATE TABLE `mmaprice` (
  `compcode` varchar(2) DEFAULT NULL,
  `mmacode` varchar(5) DEFAULT NULL,
  `effectdate` datetime DEFAULT NULL,
  `version` varchar(30) DEFAULT NULL,
  `mmaconsult` decimal(7,2) DEFAULT NULL,
  `mmasurgeon` decimal(7,2) DEFAULT NULL,
  `mmaanaes` decimal(7,2) DEFAULT NULL,
  `feesconsult` decimal(7,2) DEFAULT NULL,
  `feessurgeon` decimal(7,2) DEFAULT NULL,
  `feesanaes` decimal(7,2) DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  UNIQUE KEY `mmapricendx` (`compcode`,`mmacode`,`version`,`effectdate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `nok_ec` */

DROP TABLE IF EXISTS `nok_ec`;

CREATE TABLE `nok_ec` (
  `idno` bigint(10) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) NOT NULL,
  `mrn` int(11) NOT NULL,
  `episno` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `address1` varchar(35) DEFAULT NULL,
  `address2` varchar(35) DEFAULT NULL,
  `address3` varchar(35) DEFAULT NULL,
  `postcode` int(11) DEFAULT NULL,
  `relationshipcode` varchar(4) DEFAULT NULL,
  `occupcode` varchar(4) DEFAULT NULL,
  `tel_h` varchar(9) DEFAULT NULL,
  `tel_hp` varchar(10) DEFAULT NULL,
  `tel_o_ext` varchar(4) DEFAULT NULL,
  `tel_o` varchar(9) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `offadd1` varchar(35) DEFAULT NULL,
  `offadd2` varchar(35) DEFAULT NULL,
  `offadd3` varchar(35) DEFAULT NULL,
  `offadd4` varchar(35) DEFAULT NULL,
  `newic` varchar(12) DEFAULT NULL,
  `status` varchar(12) DEFAULT NULL COMMENT 'value = active / inactive',
  PRIMARY KEY (`idno`,`compcode`,`mrn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `occupation` */

DROP TABLE IF EXISTS `occupation`;

CREATE TABLE `occupation` (
  `idno` int(5) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `occupcode` varchar(4) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `adduser` varchar(50) DEFAULT NULL,
  `adddate` date DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `upduser` varchar(12) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `occupationUnique` (`occupcode`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Table structure for table `pat_emergency` */

DROP TABLE IF EXISTS `pat_emergency`;

CREATE TABLE `pat_emergency` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `mrn` int(20) DEFAULT NULL,
  `compcode` varchar(20) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `telh` varchar(100) DEFAULT NULL,
  `telhp` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  KEY `mrn` (`mrn`,`compcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pat_mast` */

DROP TABLE IF EXISTS `pat_mast`;

CREATE TABLE `pat_mast` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `CompCode` varchar(5) DEFAULT NULL,
  `MRN` int(10) DEFAULT NULL,
  `Episno` int(10) DEFAULT '0',
  `Name` varchar(250) DEFAULT NULL,
  `Call_Name` varchar(30) DEFAULT NULL,
  `addtype` varchar(20) DEFAULT NULL,
  `Address1` varchar(250) DEFAULT NULL,
  `Address2` varchar(250) DEFAULT NULL,
  `Address3` varchar(250) DEFAULT NULL,
  `Postcode` int(10) DEFAULT NULL,
  `citycode` varchar(20) DEFAULT NULL,
  `AreaCode` varchar(20) DEFAULT NULL,
  `StateCode` varchar(20) DEFAULT NULL,
  `CountryCode` varchar(20) DEFAULT NULL,
  `telh` varchar(22) DEFAULT NULL,
  `telhp` varchar(22) DEFAULT NULL,
  `telo` varchar(22) DEFAULT NULL,
  `Tel_O_Ext` varchar(20) DEFAULT NULL,
  `ptel` varchar(10) DEFAULT NULL,
  `ptel_hp` varchar(11) DEFAULT NULL,
  `ID_Type` varchar(20) DEFAULT NULL COMMENT 'Father,Mother,Relative,Passport,Police,Army,None',
  `idnumber` varchar(100) DEFAULT NULL,
  `Newic` varchar(100) DEFAULT NULL,
  `Oldic` varchar(100) DEFAULT NULL,
  `icolor` varchar(20) DEFAULT NULL,
  `Sex` varchar(20) DEFAULT NULL,
  `DOB` varchar(10) DEFAULT NULL,
  `Religion` varchar(11) DEFAULT NULL,
  `AllergyCode1` varchar(20) DEFAULT NULL,
  `AllergyCode2` varchar(20) DEFAULT NULL,
  `Century` int(2) DEFAULT NULL,
  `Citizencode` varchar(20) DEFAULT NULL,
  `OccupCode` varchar(20) DEFAULT NULL,
  `Staffid` varchar(20) DEFAULT NULL,
  `MaritalCode` varchar(20) DEFAULT NULL,
  `LanguageCode` varchar(20) DEFAULT NULL,
  `TitleCode` varchar(20) DEFAULT NULL,
  `RaceCode` varchar(20) DEFAULT NULL,
  `bloodgrp` varchar(20) DEFAULT NULL,
  `Accum_chg` float DEFAULT NULL,
  `Accum_Paid` float DEFAULT NULL,
  `first_visit_date` date DEFAULT NULL,
  `Reg_Date` date DEFAULT NULL,
  `last_visit_date` date DEFAULT NULL,
  `last_episno` int(4) DEFAULT NULL,
  `PatStatus` varchar(5) DEFAULT NULL COMMENT '0=FALSE,1=TRUE',
  `Confidential` varchar(5) DEFAULT NULL,
  `Active` int(5) DEFAULT NULL COMMENT '0=FALSE,1=TRUE',
  `FirstIpEpisNo` int(10) DEFAULT NULL,
  `FirstOpEpisNo` int(10) DEFAULT NULL,
  `AddUser` varchar(13) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `Lastupdate` date DEFAULT NULL,
  `LastUser` varchar(13) DEFAULT NULL,
  `OffAdd1` varchar(250) DEFAULT NULL,
  `OffAdd2` varchar(250) DEFAULT NULL,
  `OffAdd3` varchar(250) DEFAULT NULL,
  `OffPostcode` varchar(50) DEFAULT NULL,
  `MRFolder` varchar(5) DEFAULT NULL,
  `MRLoc` varchar(8) DEFAULT NULL,
  `MRActive` varchar(8) DEFAULT NULL,
  `OldMrn` varchar(10) DEFAULT NULL,
  `NewMrn` int(10) DEFAULT NULL,
  `Remarks` varchar(30) DEFAULT NULL,
  `RelateCode` varchar(20) DEFAULT NULL,
  `ChildNo` varchar(20) DEFAULT NULL,
  `CorpComp` varchar(20) DEFAULT NULL,
  `Email` varchar(250) DEFAULT NULL,
  `Email_official` varchar(250) DEFAULT NULL,
  `CurrentEpis` varchar(8) DEFAULT NULL,
  `NameSndx` varchar(20) DEFAULT NULL,
  `BirthPlace` varchar(8) DEFAULT NULL,
  `TngID` varchar(8) DEFAULT NULL,
  `PatientImage` varchar(8) DEFAULT NULL,
  `pAdd1` varchar(40) DEFAULT NULL,
  `pAdd2` varchar(40) DEFAULT NULL,
  `pAdd3` varchar(40) DEFAULT NULL,
  `pPostCode` int(5) DEFAULT NULL,
  `DeptCode` varchar(20) DEFAULT NULL,
  `DeceasedDate` date DEFAULT NULL,
  `PatientCat` varchar(20) DEFAULT NULL,
  `PatType` varchar(20) DEFAULT NULL,
  `upduser` varchar(22) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `recstatus` varchar(5) DEFAULT NULL,
  `loginid` varchar(20) DEFAULT NULL,
  `pat_category` varchar(200) DEFAULT 'local' COMMENT 'expatriate, tourist, local',
  `idnumber_exp` date DEFAULT NULL,
  PRIMARY KEY (`idno`),
  KEY `citycode` (`citycode`),
  KEY `INDEXDOB` (`DOB`,`Sex`,`Citizencode`),
  KEY `Date` (`AddDate`),
  KEY `MRN` (`MRN`),
  KEY `idnumber` (`idnumber`),
  KEY `NewIC` (`Newic`),
  FULLTEXT KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=62854 DEFAULT CHARSET=latin1;

/*Table structure for table `patexam` */

DROP TABLE IF EXISTS `patexam`;

CREATE TABLE `patexam` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `mrn` int(11) DEFAULT NULL,
  `episno` int(11) DEFAULT NULL,
  `recorddate` datetime DEFAULT NULL,
  `recordtime` varchar(30) DEFAULT NULL,
  `examination` varchar(255) DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `lastuser` varchar(30) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  KEY `patexam_examidx` (`compcode`,`mrn`,`episno`,`recorddate`,`recordtime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `pathealth` */

DROP TABLE IF EXISTS `pathealth`;

CREATE TABLE `pathealth` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(30) DEFAULT NULL,
  `mrn` int(11) DEFAULT NULL,
  `episno` int(11) DEFAULT NULL,
  `height` decimal(7,2) DEFAULT NULL,
  `weight` decimal(7,2) DEFAULT NULL,
  `temperature` decimal(7,2) DEFAULT NULL,
  `pulse` decimal(7,2) DEFAULT NULL,
  `bp_sys1` varchar(30) DEFAULT NULL,
  `bp_dias2` varchar(30) DEFAULT NULL,
  `respiration` varchar(30) DEFAULT NULL,
  `clinicnote` text,
  `adduser` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `complain` text,
  `recordtime` varchar(30) DEFAULT NULL,
  `visionl` varchar(30) DEFAULT NULL,
  `visionr` varchar(30) DEFAULT NULL,
  `colorblind` varchar(30) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `plan_` text,
  `allergyh` text,
  `fmh` text,
  `pmh` text,
  `socialh` text,
  `drugh` text,
  `vas` varchar(255) DEFAULT NULL,
  `aggr` varchar(255) DEFAULT NULL,
  `easing` varchar(255) DEFAULT NULL,
  `pain` varchar(255) DEFAULT NULL,
  `behaviour` varchar(255) DEFAULT NULL,
  `irritability` varchar(255) DEFAULT NULL,
  `severity` varchar(255) DEFAULT NULL,
  `lastuser` varchar(30) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `followupdate` date DEFAULT NULL,
  `followuptime` time DEFAULT NULL,
  PRIMARY KEY (`idno`),
  KEY `pathealth_recorddatetime` (`compcode`,`mrn`,`episno`,`adddate`,`recordtime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `pathistory` */

DROP TABLE IF EXISTS `pathistory`;

CREATE TABLE `pathistory` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `mrn` int(11) DEFAULT NULL,
  `recorddate` datetime DEFAULT NULL,
  `recordtime` varchar(30) DEFAULT NULL,
  `alllergyh` text,
  `adduser` varchar(30) DEFAULT NULL,
  `lastuser` varchar(30) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `pathname` varchar(30) DEFAULT NULL,
  `filename` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `drugh` text,
  `pmh` text,
  `fmh` text,
  `socialh` text,
  PRIMARY KEY (`idno`),
  KEY `pathistory_historyidx` (`compcode`,`mrn`),
  KEY `pathistory_recorddatetime2` (`compcode`,`mrn`,`recorddate`,`recordtime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `patresult` */

DROP TABLE IF EXISTS `patresult`;

CREATE TABLE `patresult` (
  `compcode` varchar(2) DEFAULT NULL,
  `auditno` int(11) NOT NULL AUTO_INCREMENT,
  `resulttext` varchar(256) DEFAULT NULL,
  `attachmentfile` varchar(30) DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `mrn` int(11) DEFAULT NULL,
  `trxdate` datetime DEFAULT NULL,
  `chggroup` varchar(30) DEFAULT NULL,
  `itemseqno` int(11) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`auditno`),
  KEY `patresult_auditno` (`compcode`,`auditno`),
  KEY `patresult_chggroup` (`compcode`,`mrn`,`chggroup`,`trxdate`),
  KEY `patresult_mrn` (`compcode`,`mrn`,`trxdate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `paybank` */

DROP TABLE IF EXISTS `paybank`;

CREATE TABLE `paybank` (
  `sysno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `source` varchar(2) DEFAULT NULL,
  `paybank` varchar(30) NOT NULL DEFAULT '',
  `description` varchar(40) DEFAULT NULL,
  `ccode` varchar(3) DEFAULT NULL,
  `glaccno` varchar(30) DEFAULT NULL,
  `paytype` varchar(15) DEFAULT NULL,
  `cardflag` tinyint(1) DEFAULT NULL,
  `recstatus` tinyint(10) DEFAULT NULL,
  `valexpdate` tinyint(4) DEFAULT NULL,
  `comrate` decimal(4,2) DEFAULT NULL,
  `lastupdate` date DEFAULT NULL,
  `lastuser` varchar(30) DEFAULT NULL,
  `drcommrate` decimal(7,2) DEFAULT NULL,
  `drpayment` tinyint(4) DEFAULT NULL,
  `cardcent` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`sysno`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `paytype` */

DROP TABLE IF EXISTS `paytype`;

CREATE TABLE `paytype` (
  `sysno` int(11) NOT NULL AUTO_INCREMENT,
  `CompCode` varchar(2) NOT NULL,
  `Code` varchar(12) NOT NULL,
  `Description` varchar(35) NOT NULL,
  `createdBy` varchar(22) NOT NULL,
  `createdDate` date NOT NULL,
  `Lastupdate` date NOT NULL,
  `LastUser` varchar(13) NOT NULL,
  `RecStatus` varchar(10) NOT NULL,
  PRIMARY KEY (`sysno`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `pkgbenefit` */

DROP TABLE IF EXISTS `pkgbenefit`;

CREATE TABLE `pkgbenefit` (
  `compcode` varchar(2) DEFAULT NULL,
  `pkgcode` varchar(7) DEFAULT NULL,
  `chgcode` varchar(12) DEFAULT NULL,
  `quantity` decimal(8,2) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `price` decimal(9,2) DEFAULT NULL,
  `actprice` decimal(9,2) DEFAULT NULL,
  `totprice` decimal(9,2) DEFAULT NULL,
  `revcode` varchar(4) DEFAULT NULL,
  `uom` varchar(4) DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `chgtype` varchar(4) DEFAULT NULL,
  `chggroup` varchar(4) DEFAULT NULL,
  `qflag` tinyint(4) DEFAULT NULL,
  `costcode` varchar(4) DEFAULT NULL,
  `chgflag` tinyint(4) DEFAULT NULL,
  `ipacccode` varchar(30) DEFAULT NULL,
  `opacccode` varchar(30) DEFAULT NULL,
  `revdept` tinyint(4) DEFAULT NULL,
  `chgclass` varchar(4) DEFAULT NULL,
  `costdept` tinyint(4) DEFAULT NULL,
  `doctorcode` varchar(4) DEFAULT NULL,
  `changedate` datetime DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `freqqty` int(1) DEFAULT NULL,
  `intervl` int(1) DEFAULT NULL,
  `maxqty` int(2) DEFAULT NULL,
  `benefitflag` tinyint(1) DEFAULT '0',
  `remark` varchar(1000) DEFAULT NULL,
  `effectdate` date DEFAULT NULL,
  `expirydate` date DEFAULT NULL,
  UNIQUE KEY `pkgchgndx` (`compcode`,`pkgcode`,`chgcode`,`effectdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `pkgdet` */

DROP TABLE IF EXISTS `pkgdet`;

CREATE TABLE `pkgdet` (
  `idno` int(10) NOT NULL AUTO_INCREMENT,
  `lineno_` int(11) DEFAULT NULL,
  `compcode` varchar(2) DEFAULT NULL,
  `pkgcode` varchar(33) DEFAULT NULL,
  `effectdate` date DEFAULT NULL,
  `chgcode` varchar(33) DEFAULT NULL,
  `quantity` decimal(8,2) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `pkgprice1` decimal(9,2) DEFAULT NULL,
  `pkgprice2` decimal(9,2) DEFAULT NULL,
  `pkgprice3` decimal(9,2) DEFAULT NULL,
  `actprice1` decimal(9,2) DEFAULT NULL,
  `actprice2` decimal(9,2) DEFAULT NULL,
  `actprice3` decimal(9,2) DEFAULT NULL,
  `totprice1` decimal(9,2) DEFAULT NULL,
  `totprice2` decimal(9,2) DEFAULT NULL,
  `totprice3` decimal(9,2) DEFAULT NULL,
  `revcode` varchar(4) DEFAULT NULL,
  `uom` varchar(4) DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `chgtype` varchar(4) DEFAULT NULL,
  `chggroup` varchar(4) DEFAULT NULL,
  `qflag` tinyint(4) DEFAULT NULL,
  `costcode` varchar(4) DEFAULT NULL,
  `chgflag` tinyint(4) DEFAULT NULL,
  `ipacccode` varchar(30) DEFAULT NULL,
  `opacccode` varchar(30) DEFAULT NULL,
  `revdept` tinyint(4) DEFAULT NULL,
  `chgclass` varchar(4) DEFAULT NULL,
  `costdept` tinyint(4) DEFAULT NULL,
  `doctorcode` varchar(4) DEFAULT NULL,
  `changedate` datetime DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `freqqty` int(1) DEFAULT NULL,
  `intervl` int(1) DEFAULT NULL,
  `maxqty` int(2) DEFAULT NULL,
  `benefitflag` tinyint(1) DEFAULT '0',
  `remark` varchar(1000) DEFAULT NULL,
  `expirydate` date DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `lastcomputerid` varchar(100) DEFAULT NULL,
  `lastipaddress` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `pkgchgndx` (`compcode`,`pkgcode`,`chgcode`,`effectdate`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `pkgmast` */

DROP TABLE IF EXISTS `pkgmast`;

CREATE TABLE `pkgmast` (
  `compcode` varchar(2) DEFAULT NULL,
  `pkgcode` varchar(7) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `cur_amt` decimal(9,2) DEFAULT NULL,
  `prevamt` decimal(8,2) DEFAULT NULL,
  `newamt` decimal(8,2) DEFAULT NULL,
  `curr_eff_date` datetime DEFAULT NULL,
  `new_eff_date` datetime DEFAULT NULL,
  `addchg` tinyint(4) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `autopull` tinyint(4) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `term` int(2) DEFAULT NULL,
  `effectDate` date DEFAULT NULL,
  `expirydate` date DEFAULT NULL,
  `price` float(8,2) DEFAULT NULL,
  `SubScriberNo` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  UNIQUE KEY `pkgidx1` (`compcode`,`pkgcode`,`curr_eff_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `pkgpat` */

DROP TABLE IF EXISTS `pkgpat`;

CREATE TABLE `pkgpat` (
  `compcode` varchar(2) DEFAULT NULL,
  `mrn` varchar(15) DEFAULT NULL,
  `episno` int(11) DEFAULT '0',
  `pkgcode` varchar(20) DEFAULT NULL,
  `pkgqty` int(8) DEFAULT NULL,
  `pkgprice` decimal(7,2) DEFAULT NULL,
  `pkgtotprice` decimal(7,2) DEFAULT NULL,
  `chgcode` varchar(30) DEFAULT NULL,
  `doctorcode` varchar(4) DEFAULT NULL,
  `ipacccode` varchar(30) DEFAULT NULL,
  `opacccode` varchar(30) DEFAULT NULL,
  `qtyused` int(8) DEFAULT '0',
  `qtybal` decimal(7,2) DEFAULT NULL,
  `amtbal` decimal(7,2) DEFAULT NULL,
  `updategl` tinyint(4) DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `costcd` varchar(4) DEFAULT NULL,
  `memberno` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `agreementdate` date DEFAULT NULL,
  `expirydate` date DEFAULT NULL,
  `AgreementID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `postcode` */

DROP TABLE IF EXISTS `postcode`;

CREATE TABLE `postcode` (
  `compcode` varchar(8) DEFAULT NULL,
  `idno` int(20) NOT NULL AUTO_INCREMENT,
  `postcode` varchar(8) DEFAULT NULL,
  `place_name` varchar(100) DEFAULT NULL,
  `countrycode` varchar(100) DEFAULT NULL,
  `statecode` varchar(100) DEFAULT NULL,
  `effectivedate` datetime DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(20) DEFAULT NULL,
  `upduser` varchar(20) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(20) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `recstatus` varchar(20) DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=1382 DEFAULT CHARSET=latin1;

/*Table structure for table `pre_episode` */

DROP TABLE IF EXISTS `pre_episode`;

CREATE TABLE `pre_episode` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `mrn` varchar(15) NOT NULL,
  `episno` int(5) DEFAULT '0' COMMENT 'berubah apabila pindah ke episode table',
  `admsrccode` varchar(4) DEFAULT NULL,
  `epistycode` varchar(4) DEFAULT NULL,
  `case_code` varchar(4) DEFAULT NULL,
  `ward` varchar(30) DEFAULT NULL,
  `bedtype` varchar(4) DEFAULT NULL,
  `room` varchar(4) DEFAULT NULL,
  `bed` varchar(15) DEFAULT NULL,
  `admdoctor` varchar(15) DEFAULT NULL,
  `attndoctor` varchar(15) DEFAULT NULL,
  `refdoctor` varchar(30) DEFAULT NULL,
  `prescribedays` varchar(15) DEFAULT NULL,
  `pay_type` varchar(11) DEFAULT NULL,
  `pyrmode` varchar(11) DEFAULT NULL,
  `climitauthid` varchar(4) DEFAULT NULL,
  `crnumber` varchar(20) DEFAULT NULL,
  `depositreq` decimal(9,2) DEFAULT NULL,
  `deposit` decimal(9,2) DEFAULT NULL,
  `pkgcode` varchar(30) DEFAULT NULL,
  `billtype` varchar(5) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `episstatus` varchar(5) DEFAULT NULL COMMENT 'D=DISCHARGE C=CANCEL BLANK=CURRENT,B=BILL',
  `episactive` varchar(6) DEFAULT '0' COMMENT '0=false,1=true',
  `adddate` date DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `reg_time` time DEFAULT NULL,
  `dischargedate` date DEFAULT NULL,
  `dischargeuser` varchar(13) DEFAULT NULL,
  `dischargetime` varchar(5) DEFAULT NULL,
  `dischargedest` varchar(30) DEFAULT NULL,
  `allocdoc` int(11) DEFAULT NULL,
  `allocbed` int(11) DEFAULT NULL,
  `allocnok` int(11) DEFAULT NULL,
  `allocpayer` int(11) DEFAULT NULL,
  `allocicd` int(11) DEFAULT NULL,
  `lastupdate` date DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lasttime` varchar(5) DEFAULT NULL,
  `procode` varchar(30) DEFAULT NULL,
  `dischargediag` varchar(30) DEFAULT NULL,
  `lodgerno` varchar(4) DEFAULT NULL,
  `regdept` varchar(30) DEFAULT NULL,
  `diet1` varchar(30) DEFAULT NULL,
  `diet2` varchar(30) DEFAULT NULL,
  `diet3` varchar(30) DEFAULT NULL,
  `diet4` varchar(30) DEFAULT NULL,
  `diet5` varchar(30) DEFAULT NULL,
  `glauthid` varchar(30) DEFAULT NULL,
  `treatcode` varchar(30) DEFAULT NULL,
  `diagcode` varchar(30) DEFAULT NULL,
  `complain` varchar(255) DEFAULT NULL,
  `diagfinal` varchar(255) DEFAULT NULL,
  `clinicalnote` varchar(255) DEFAULT NULL,
  `conversion` int(4) DEFAULT NULL,
  `newcaseP` int(4) DEFAULT NULL,
  `newcaseNP` int(4) DEFAULT NULL,
  `followupP` int(4) DEFAULT NULL,
  `followupNP` int(4) DEFAULT NULL,
  `bed2` varchar(30) DEFAULT NULL,
  `bed3` varchar(30) DEFAULT NULL,
  `bed4` varchar(30) DEFAULT NULL,
  `bed5` varchar(30) DEFAULT NULL,
  `bed6` varchar(30) DEFAULT NULL,
  `bed7` varchar(30) DEFAULT NULL,
  `bed8` varchar(30) DEFAULT NULL,
  `bed9` varchar(30) DEFAULT NULL,
  `bed10` varchar(30) DEFAULT NULL,
  `diagprov` varchar(256) DEFAULT NULL,
  `visitcase` varchar(30) DEFAULT NULL,
  `PkgAutoNo` int(11) DEFAULT NULL,
  `AgreementID` varchar(11) DEFAULT NULL,
  `AdminFees` int(2) DEFAULT NULL COMMENT '1 - True, 0 False      ',
  `EDDept` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `queue` */

DROP TABLE IF EXISTS `queue`;

CREATE TABLE `queue` (
  `compcode` varchar(2) DEFAULT NULL,
  `queueno` int(11) DEFAULT NULL,
  `mrn` int(11) NOT NULL,
  `episno` int(11) NOT NULL,
  `memberno` varchar(9) DEFAULT NULL,
  `chggroup` varchar(11) NOT NULL,
  `epistycode` varchar(10) DEFAULT NULL,
  `episqueue` varchar(10) DEFAULT NULL COMMENT 'ip = ip or dp, op=op or otc',
  `counter` int(11) DEFAULT NULL,
  `bedtype` varchar(50) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL,
  `bed` varchar(50) DEFAULT NULL,
  `admdoctor` varchar(15) DEFAULT NULL,
  `adddate` date DEFAULT NULL,
  `adduser` varchar(50) DEFAULT NULL,
  `newic` varchar(50) DEFAULT NULL,
  `oldic` varchar(50) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `religion` varchar(4) DEFAULT NULL,
  `racecode` varchar(4) DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `ageyy` int(11) DEFAULT NULL,
  `case_code` varchar(4) DEFAULT NULL,
  `episstatus` varchar(1) DEFAULT NULL,
  `reg_time` time DEFAULT NULL,
  `lastupdate` date DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lasttime` time DEFAULT NULL,
  `deptcode` varchar(30) DEFAULT NULL,
  `seqno` int(11) DEFAULT NULL,
  `name` varchar(300) NOT NULL,
  `agemm` int(11) DEFAULT NULL,
  `qdate` date DEFAULT NULL,
  `qtime` varchar(30) DEFAULT NULL,
  `attndoctor` varchar(15) DEFAULT NULL,
  `deposit` decimal(9,2) DEFAULT NULL,
  `sounddex` varchar(30) DEFAULT NULL,
  `queuecode` varchar(30) DEFAULT NULL,
  `ward` varchar(30) DEFAULT NULL,
  `qtyorder` decimal(7,2) DEFAULT NULL,
  `qtyissue` decimal(7,2) DEFAULT NULL,
  `ipqueueno` decimal(7,2) DEFAULT NULL,
  `bed2` varchar(30) DEFAULT NULL,
  `bed3` varchar(30) DEFAULT NULL,
  `bed4` varchar(30) DEFAULT NULL,
  `bed5` varchar(30) DEFAULT NULL,
  `bed6` varchar(30) DEFAULT NULL,
  `bed7` varchar(30) DEFAULT NULL,
  `bed8` varchar(30) DEFAULT NULL,
  `bed9` varchar(30) DEFAULT NULL,
  `bed10` varchar(30) DEFAULT NULL,
  `idno` int(30) NOT NULL AUTO_INCREMENT,
  `telhp` int(30) DEFAULT NULL,
  `telh` int(11) DEFAULT NULL,
  UNIQUE KEY `idno` (`idno`),
  KEY `bedsort` (`compcode`,`epistycode`,`bed`),
  KEY `cntgrpndx` (`compcode`,`counter`,`chggroup`),
  KEY `datesort` (`compcode`,`epistycode`,`reg_date`),
  KEY `depttime` (`compcode`,`epistycode`,`deptcode`,`reg_time`),
  KEY `dob` (`compcode`,`epistycode`,`dob`),
  KEY `doctorsort` (`compcode`,`epistycode`,`admdoctor`),
  KEY `episodetype` (`compcode`,`epistycode`,`mrn`),
  KEY `epistime` (`compcode`,`epistycode`,`reg_time`),
  KEY `ipqueueno` (`compcode`,`ipqueueno`),
  KEY `mrnepisdeptndx` (`compcode`,`mrn`,`episno`,`deptcode`,`seqno`),
  KEY `mrnepisgrpndx` (`compcode`,`mrn`,`episno`,`chggroup`),
  KEY `namesort` (`compcode`,`epistycode`,`name`),
  KEY `newic` (`compcode`,`newic`),
  KEY `oldic` (`compcode`,`oldic`),
  KEY `queuecode` (`compcode`,`queuecode`,`mrn`,`episno`),
  KEY `race` (`racecode`),
  KEY `religion` (`religion`),
  KEY `roomsort` (`compcode`,`epistycode`,`room`),
  KEY `sex` (`compcode`,`epistycode`,`sex`),
  KEY `wardsort` (`compcode`,`epistycode`,`ward`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `racecode` */

DROP TABLE IF EXISTS `racecode`;

CREATE TABLE `racecode` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) NOT NULL,
  `Code` varchar(10) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `adduser` varchar(33) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `upduser` varchar(12) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `religion` (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `relationship` */

DROP TABLE IF EXISTS `relationship`;

CREATE TABLE `relationship` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(8) DEFAULT NULL,
  `RelationShipCode` varchar(20) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `recstatus` varchar(8) DEFAULT NULL,
  `adduser` varchar(12) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(12) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `deluser` varchar(8) DEFAULT NULL,
  `deldate` date DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `relationship` (`RelationShipCode`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Table structure for table `religion` */

DROP TABLE IF EXISTS `religion`;

CREATE TABLE `religion` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `Code` varchar(4) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `adduser` varchar(33) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `recstatus` varchar(8) DEFAULT NULL,
  `upduser` varchar(12) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  `lastuser` varchar(20) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `religion` (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `sex` */

DROP TABLE IF EXISTS `sex`;

CREATE TABLE `sex` (
  `sysno` int(7) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `description` varchar(10) NOT NULL,
  PRIMARY KEY (`sysno`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `speciality` */

DROP TABLE IF EXISTS `speciality`;

CREATE TABLE `speciality` (
  `compcode` varchar(2) DEFAULT NULL,
  `specialitycode` varchar(15) DEFAULT NULL,
  `description` varchar(40) DEFAULT NULL,
  `disciplinecode` varchar(4) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `upduser` varchar(13) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(13) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` varchar(13) DEFAULT NULL,
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `computerid` varchar(20) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `lastcomputerid` varchar(20) DEFAULT NULL,
  `lastipaddress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `specialityndx` (`specialitycode`),
  KEY `descriptionndx` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `state` */

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(2) DEFAULT NULL,
  `countryCode` varchar(4) DEFAULT NULL,
  `StateCode` varchar(4) DEFAULT NULL,
  `Description` varchar(30) DEFAULT NULL,
  `createdBy` varchar(22) DEFAULT NULL,
  `createdDate` date DEFAULT NULL,
  `Lastupdate` date DEFAULT NULL,
  `LastUser` varchar(13) DEFAULT NULL,
  `recstatus` varchar(10) DEFAULT NULL,
  `upduser` varchar(30) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `adduser` varchar(30) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `deluser` varchar(30) DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `computerid` varchar(30) DEFAULT NULL,
  `ipaddress` varchar(30) DEFAULT NULL,
  `lastcomputerid` varchar(30) DEFAULT NULL,
  `lastipaddress` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `taxmast` */

DROP TABLE IF EXISTS `taxmast`;

CREATE TABLE `taxmast` (
  `compcode` varchar(2) DEFAULT NULL,
  `taxcode` varchar(4) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `rate` decimal(5,2) DEFAULT NULL,
  `lastuser` varchar(13) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `claimable` varchar(30) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `taxtype` varchar(30) DEFAULT NULL,
  `idno` int(12) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idno`),
  KEY `taxmastndx` (`compcode`,`taxcode`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Table structure for table `test` */

DROP TABLE IF EXISTS `test`;

CREATE TABLE `test` (
  `a` varchar(20) DEFAULT NULL,
  `b` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `title` */

DROP TABLE IF EXISTS `title`;

CREATE TABLE `title` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `compcode` varchar(11) DEFAULT NULL,
  `Code` varchar(55) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `adduser` varchar(33) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `deldate` datetime DEFAULT NULL,
  `deluser` varchar(33) DEFAULT NULL,
  `recstatus` varchar(11) DEFAULT NULL,
  `upduser` varchar(33) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `computerid` varchar(55) DEFAULT NULL,
  `ipaddress` varchar(55) DEFAULT NULL,
  `lastcomputerid` varchar(55) DEFAULT NULL,
  `lastipaddress` varchar(55) DEFAULT NULL,
  `lastuser` varchar(55) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`),
  UNIQUE KEY `religion` (`compcode`,`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Table structure for table `userlama` */

DROP TABLE IF EXISTS `userlama`;

CREATE TABLE `userlama` (
  `userid` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(22) NOT NULL,
  `password` varchar(22) NOT NULL,
  `compid` varchar(10) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `compcode` varchar(2) DEFAULT NULL,
  `username` varchar(10) DEFAULT NULL,
  `password` varchar(10) DEFAULT NULL,
  `name` varchar(35) DEFAULT NULL,
  `designation` varchar(25) DEFAULT NULL,
  `groupid` varchar(30) DEFAULT NULL,
  `cashier` int(4) DEFAULT NULL,
  `programmenu` varchar(20) DEFAULT NULL,
  `lastuser` varchar(30) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `priceview` int(4) DEFAULT NULL,
  `editpkgpat` int(1) DEFAULT '0',
  `deptcode` varchar(30) DEFAULT NULL,
  `recstatus` varchar(30) DEFAULT NULL,
  `wallpapper` varchar(80) DEFAULT NULL,
  `wppath` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
