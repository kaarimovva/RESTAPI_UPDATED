-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 16, 2022 at 02:18 PM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ele_`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

DROP TABLE IF EXISTS `auth`;
CREATE TABLE IF NOT EXISTS `auth` (
  `id` varchar(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`id`, `name`, `password`) VALUES
('456321', 'Jimmy', '$2y$10$3bYxvRMvzdI3wxY8WYf2Y.K3VI.YGmDbSw1q3Bm6Ossr/DmqnKsZO'),
('14', 'Gulare', '$2y$10$fM5F8M/nYk4aRONPQ0uooeuxyfTnYjZn8H67QbCjQ3gZnx/KEIc2a'),
('055', 'Fatima Karimova', '$2y$10$bf9mXe56jfH.IpmwE9CnYOotNdpKRtGo.oQ8yMJiGzEg7vbQ7qmXi');

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

DROP TABLE IF EXISTS `facility`;
CREATE TABLE IF NOT EXISTS `facility` (
  `FacID` int NOT NULL AUTO_INCREMENT,
  `FacName` varchar(255) NOT NULL,
  `CreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`FacID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`FacID`, `FacName`, `CreateDate`) VALUES
(24, 'Dinner', '2022-01-12 13:21:26'),
(25, 'Breakfast AGAIN', '2022-01-12 13:21:38'),
(26, 'Brunch', '2022-01-12 13:21:50'),
(27, 'Bakery', '2022-01-12 13:21:59'),
(28, 'Plant Based', '2022-01-12 13:22:18');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `LocID` int NOT NULL AUTO_INCREMENT,
  `FacID` int DEFAULT NULL,
  `LocAddress` varchar(255) DEFAULT NULL,
  `LocCity` varchar(255) DEFAULT NULL,
  `ZipCode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `CountCode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `PhoneNum` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`LocID`),
  KEY `FacID` (`FacID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LocID`, `FacID`, `LocAddress`, `LocCity`, `ZipCode`, `CountCode`, `PhoneNum`) VALUES
(23, 24, 'Boulevard Anspach', 'Brussels', '1012', '+32', '654321'),
(24, 25, 'Adele-Sandrock-Straße', 'Berlin', '10245', '+30', '452146'),
(25, 26, '96\r\nAchim András utca további házszámok', '\r\nBudaPest', '1194', '+36', '5698745'),
(26, 27, 'Elverhoy Way, Solvang CA 93463', 'Cophenhagen', '1624', '+45', '951753'),
(27, 28, 'Valhallavägen 117N', 'Stockholm', '115', '+46', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `TagID` int NOT NULL AUTO_INCREMENT,
  `FacID` int DEFAULT NULL,
  `TagName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`TagID`),
  KEY `facility` (`FacID`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`TagID`, `FacID`, `TagName`) VALUES
(62, 24, 'Beef Salad'),
(63, 24, 'Steak'),
(64, 24, 'Stew'),
(65, 24, 'Pasta'),
(66, 24, 'Kroket'),
(67, 24, ' Patat'),
(68, 24, 'Rookworst'),
(69, 24, 'Kibbeling'),
(70, 24, 'Chesse'),
(71, 24, ' Nieuwe'),
(72, 25, 'Stroopwafel'),
(73, 25, 'Poffertjes'),
(74, 25, 'OatMeal'),
(75, 25, 'Egg New'),
(76, 25, 'Honey'),
(77, 25, 'Bread'),
(78, 25, 'Oliebollen'),
(79, 25, 'Butter'),
(80, 25, 'Chesse'),
(81, 25, 'Milk'),
(82, 26, 'Stamppot'),
(83, 26, 'Sandwitch'),
(84, 26, 'Bruchetta'),
(85, 26, 'Csesar Salad'),
(86, 26, 'Chicken Breast'),
(87, 26, 'Warm Beef Salad'),
(88, 26, 'Blueberry Muffins'),
(89, 26, ' Casserole'),
(90, 26, 'French Toast'),
(91, 26, 'Old-Fashioned Pancakes'),
(92, 27, 'Russian Kulich'),
(93, 27, 'Pretzel Rolls'),
(94, 27, 'garlic Bread'),
(95, 27, 'English Muffin Bread'),
(96, 27, 'Jam Tarts'),
(97, 27, 'Apple Cider Pound Cake'),
(98, 27, 'Honey Cake'),
(99, 27, 'Cinnamon Biscuits'),
(100, 27, 'Chocolate Banana Bundles'),
(101, 27, 'Chocolate Toffee Biscuits'),
(114, 26, 'Scrambled Eggs with Vegetables'),
(115, 26, 'Coconut Smoothie Bowl'),
(116, 26, 'Egg Panini'),
(117, 27, 'Ricotta-Raisin Coffee Cake'),
(118, 27, 'Pumpkin Scones'),
(119, 27, 'Nutella Hand Pies'),
(120, 27, 'Banana Macadamia Muffins'),
(124, 27, 'Cranberry Banana Cake'),
(125, 27, 'Cappuccino Muffins'),
(126, 27, 'Monkey Bread'),
(127, 28, 'TEX-MEX PITA PIZZAS'),
(128, 28, 'LENTIL VEGETABLE SOUP'),
(129, 28, 'VEGAN CORN CHOWDER'),
(130, 28, 'CREAMY WILD RICE SOUP'),
(131, 28, 'VEGAN MACARONI AND CHEESE'),
(132, 28, '\"NO-TUNA\" SALAD SANDWICH'),
(133, 28, 'WHITE BEAN SALAD WRAPS'),
(134, 28, 'BURRITO'),
(135, 28, 'BLACK BEAN BURGERS'),
(136, 28, 'SWEET POTATO QUESADILLAS');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`FacID`) REFERENCES `facility` (`FacID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`FacID`) REFERENCES `facility` (`FacID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
