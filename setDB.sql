CREATE DATABASE IF NOT EXISTS `RD1_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `RD1_db`;

--------------^^^分開輸入vvv---------------

CREATE TABLE `cityCode` (
  `geoCode` int(11) NOT NULL,
  `cityName` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cityCode`
--

INSERT INTO `cityCode` (`geoCode`, `cityName`) VALUES
(63, '臺北市'),
(64, '高雄市'),
(65, '新北市'),
(66, '臺中市'),
(67, '臺南市'),
(68, '桃園市'),
(9007, '連江縣'),
(9020, '金門縣'),
(10002, '宜蘭縣'),
(10004, '新竹縣'),
(10005, '苗栗縣'),
(10007, '彰化縣'),
(10008, '南投縣'),
(10009, '雲林縣'),
(10010, '嘉義縣'),
(10013, '屏東縣'),
(10014, '臺東縣'),
(10015, '花蓮縣'),
(10016, '澎湖縣'),
(10017, '基隆市'),
(10018, '新竹市'),
(10020, '嘉義市');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cityCode`
--

CREATE TABLE `rain` (
 `stationId` varchar(8) NOT NULL,
 `location` varchar(10) NOT NULL,
 `city` varchar(4) NOT NULL,
 `town` varchar(8) NOT NULL,
 `obsTime` datetime NOT NULL,
 `rain1h` float NOT NULL,
 `rain24h` float NOT NULL,
 PRIMARY KEY (`stationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `record` (
 `rId` int(11) NOT NULL AUTO_INCREMENT,
 `lastUpdateTime` datetime NOT NULL,
 PRIMARY KEY (`rId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `weather` (
 `geocode` int(11) NOT NULL,
 `startTime` datetime NOT NULL,
 `endTime` datetime NOT NULL,
 `PoP12h` int(11) DEFAULT NULL,
 `perTemp` int(11) NOT NULL,
 `perWet` int(11) NOT NULL,
 `minTemp` int(11) NOT NULL,
 `maxTemp` int(11) NOT NULL,
 `minATemp` int(11) NOT NULL,
 `maxATemp` int(11) NOT NULL,
 `minCI` int(11) NOT NULL,
 `maxCI` int(11) NOT NULL,
 `UVI` int(11) DEFAULT NULL,
 `td` int(11) NOT NULL,
 `ws` int(11) NOT NULL,
 `wd` varchar(4) NOT NULL,
 `wx` varchar(12) NOT NULL,
 PRIMARY KEY (`geocode`,`startTime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
