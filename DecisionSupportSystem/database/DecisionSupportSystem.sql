-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 30, 2018 at 06:50 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DecisionSupportSystem`
--
DROP DATABASE IF EXISTS `DecisionSupportSystem`;
CREATE DATABASE IF NOT EXISTS `DecisionSupportSystem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `DecisionSupportSystem`;

# Privileges for `DecisionSupportUser`@`localhost`

GRANT USAGE ON *.* TO 'DecisionSupportUser'@'localhost';

GRANT ALL PRIVILEGES ON `DecisionSupportSystem`.* TO 'DecisionSupportUser'@'localhost'
IDENTIFIED BY '5Aln8DLXRIFTJKUf'
WITH GRANT OPTION ;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `testMultipleCases`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `testMultipleCases` (IN `id1` INT, IN `id2` INT)  BEGIN
	drop table if exists results;
	CREATE TABLE results(case_id int, target varchar (60), result varchar(60));
    
	WHILE id1 <= id2 DO
    insert into results(case_id, target, result) values (id1, getTargetValue(id1), testSingleCase(id1));
    SET id1 = id1 +1 ;
    END while;
    
	SELECT a.*, b.accuracy
    FROM
    (select * from results) as a,
	(SELECT COUNT(*) AS accuracy from results t2 WHERE target=result) as b;

END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `getTargetValue`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getTargetValue` (`caseId` INT) RETURNS VARCHAR(60) CHARSET utf8 BEGIN
	DECLARE targetValue varchar(60);
    
	SELECT `target` from cases where id=caseId into targetValue;

RETURN targetValue;
END$$

DROP FUNCTION IF EXISTS `testSingleCase`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `testSingleCase` (`case_id` INT) RETURNS VARCHAR(50) CHARSET utf8 BEGIN
     DECLARE rule_blood INT;
     DECLARE rule_skin INT;
	 DECLARE rule_diastolic INT;
	 DECLARE rule_insulin INT;
	 DECLARE rule_bmi INT; 
     DECLARE case_blood INT;
     DECLARE case_skin INT;
     DECLARE case_diastolic INT;
     DECLARE case_insulin INT;
     DECLARE case_bmi INT;
     
     
	SELECT `Blood Glucose 2hrs after GTT` FROM cornerstones WHERE rule_id=1 into rule_blood;
    SELECT `SkinThickness` FROM cornerstones WHERE rule_id=2 into rule_skin;
	SELECT `Diastolic BloodPressure` FROM cornerstones WHERE rule_id=3 into rule_diastolic;
	SELECT `2 hr insulin level` FROM cornerstones WHERE rule_id=4 into rule_insulin;
	SELECT `BMI` FROM cornerstones WHERE rule_id=5 into rule_bmi;
    
	SELECT `Blood Glucose 2hrs after GTT` FROM cases WHERE id=case_id into case_blood;
    SELECT `SkinThickness` FROM cases WHERE id=case_id into case_skin;
	SELECT `Diastolic BloodPressure` FROM cases WHERE id=case_id into case_diastolic;
	SELECT `2 hr insulin level` FROM cases WHERE id=case_id into case_insulin;
	SELECT `BMI` FROM cases WHERE id=case_id into case_bmi;

		CASE 
			WHEN case_blood >= 120 
				THEN
					CASE
						WHEN case_skin >= 34
							THEN return ("Diabetic");
						ELSE return ("Diabetic");
					END CASE;
            ELSE CASE
				WHEN case_diastolic <= 96
					THEN CASE
						WHEN case_bmi >= 27
							THEN CASE
								WHEN case_insulin <= 295
									THEN return ("Not Diabetic");
								ELSE return ("Not Diabetic");
							END CASE;
						ELSE return ("Diabetic");
					END CASE;
				ELSE return ("Not Diabetic");
			END CASE;
		END CASE; 
	
					
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

DROP TABLE IF EXISTS `cases`;
CREATE TABLE IF NOT EXISTS `cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `No of Pregnancies` int(11) DEFAULT NULL,
  `Blood Glucose 2hrs after GTT` int(11) DEFAULT NULL,
  `Diastolic BloodPressure` int(11) DEFAULT NULL,
  `SkinThickness` int(11) DEFAULT NULL,
  `2 hr insulin level` int(11) DEFAULT NULL,
  `BMI` int(11) DEFAULT NULL,
  `DiabetesPedigreeFunction` double DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `target` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `No of Pregnancies`, `Blood Glucose 2hrs after GTT`, `Diastolic BloodPressure`, `SkinThickness`, `2 hr insulin level`, `BMI`, `DiabetesPedigreeFunction`, `Age`, `target`) VALUES
(1, 6, 148, 72, 35, 100, 34, 0.627, 50, 'Diabetic'),
(2, 1, 85, 66, 29, 160, 27, 0.351, 31, 'Not Diabetic'),
(3, 8, 183, 64, 36, 90, 23, 0.672, 32, 'Diabetic'),
(4, 1, 89, 66, 23, 94, 28, 0.167, 21, 'Not Diabetic'),
(5, 0, 137, 40, 35, 168, 43, 2.288, 33, 'Diabetic'),
(6, 5, 116, 74, 28, 200, 26, 0.201, 30, 'Not Diabetic'),
(7, 3, 78, 50, 32, 88, 31, 0.248, 26, 'Diabetic'),
(8, 10, 115, 95, 32, 290, 35, 0.134, 29, 'Not Diabetic'),
(9, 2, 197, 70, 45, 543, 31, 0.158, 53, 'Diabetic'),
(10, 8, 125, 96, 42, 150, 25, 0.232, 54, 'Diabetic'),
(11, 4, 110, 92, 31, 565, 38, 0.191, 30, 'Not Diabetic'),
(12, 10, 168, 74, 44, 300, 38, 0.537, 34, 'Diabetic'),
(13, 10, 139, 80, 30, 232, 27, 1.441, 57, 'Not Diabetic'),
(14, 1, 189, 60, 23, 846, 30, 0.398, 59, 'Diabetic'),
(15, 5, 166, 72, 19, 175, 26, 0.587, 51, 'Diabetic'),
(16, 7, 100, 101, 36, 76, 30, 0.484, 32, 'Diabetic'),
(17, 0, 118, 84, 47, 230, 46, 0.551, 31, 'Diabetic'),
(18, 7, 107, 74, 37, 305, 30, 0.254, 31, 'Diabetic'),
(19, 1, 103, 30, 38, 83, 43, 0.183, 33, 'Not Diabetic'),
(20, 1, 115, 70, 30, 96, 35, 0.529, 32, 'Diabetic'),
(21, 3, 126, 88, 41, 235, 39, 0.704, 27, 'Not Diabetic'),
(22, 8, 99, 84, 32, 292, 35, 0.388, 50, 'Not Diabetic'),
(23, 7, 196, 90, 40, 150, 40, 0.451, 41, 'Diabetic'),
(24, 9, 119, 80, 35, 310, 29, 0.263, 29, 'Diabetic'),
(25, 11, 143, 94, 33, 146, 37, 0.254, 51, 'Diabetic'),
(26, 10, 125, 70, 26, 115, 31, 0.205, 41, 'Diabetic'),
(27, 7, 147, 76, 40, 232, 39, 0.257, 43, 'Diabetic'),
(28, 1, 97, 66, 15, 140, 23, 0.487, 22, 'Not Diabetic'),
(29, 13, 145, 82, 19, 110, 22, 0.245, 57, 'Not Diabetic'),
(30, 5, 117, 92, 29, 293, 34, 0.337, 38, 'Not Diabetic'),
(31, 5, 109, 75, 26, 290, 36, 0.546, 60, 'Not Diabetic'),
(32, 3, 158, 76, 36, 245, 32, 0.851, 28, 'Diabetic'),
(33, 3, 88, 58, 11, 54, 25, 0.267, 22, 'Not Diabetic'),
(34, 6, 92, 92, 30, 80, 20, 0.188, 28, 'Not Diabetic'),
(35, 10, 122, 78, 31, 342, 28, 0.512, 45, 'Not Diabetic'),
(36, 4, 103, 60, 33, 192, 24, 0.966, 33, 'Not Diabetic'),
(37, 11, 138, 76, 28, 150, 33, 0.42, 35, 'Not Diabetic'),
(38, 9, 102, 76, 37, 300, 33, 0.665, 46, 'Diabetic'),
(39, 2, 90, 68, 42, 298, 38, 0.503, 27, 'Diabetic'),
(40, 4, 111, 72, 47, 207, 37, 1.39, 56, 'Diabetic'),
(41, 3, 180, 64, 25, 70, 34, 0.271, 26, 'Not Diabetic'),
(42, 7, 133, 84, 29, 180, 40, 0.696, 37, 'Not Diabetic'),
(43, 7, 106, 92, 18, 128, 23, 0.235, 48, 'Not Diabetic'),
(44, 9, 171, 110, 24, 240, 45, 0.721, 54, 'Diabetic'),
(45, 7, 159, 64, 30, 234, 27, 0.294, 40, 'Not Diabetic'),
(46, 0, 180, 66, 39, 297, 42, 1.893, 25, 'Diabetic'),
(47, 1, 146, 56, 28, 291, 30, 0.564, 29, 'Not Diabetic'),
(48, 2, 71, 70, 27, 292, 28, 0.586, 22, 'Not Diabetic'),
(49, 7, 103, 66, 32, 303, 39, 0.344, 31, 'Diabetic'),
(50, 7, 105, 93, 27, 435, 24, 0.305, 24, 'Not Diabetic'),
(51, 1, 103, 80, 11, 82, 19, 0.491, 22, 'Not Diabetic'),
(52, 1, 101, 50, 15, 36, 24, 0.526, 26, 'Not Diabetic'),
(53, 5, 88, 66, 21, 23, 24, 0.342, 30, 'Not Diabetic'),
(54, 8, 176, 90, 34, 300, 34, 0.467, 58, 'Diabetic'),
(55, 7, 150, 66, 42, 342, 35, 0.718, 42, 'Not Diabetic'),
(56, 1, 73, 50, 10, 194, 23, 0.248, 21, 'Not Diabetic'),
(57, 7, 187, 68, 39, 304, 38, 0.254, 41, 'Diabetic'),
(58, 0, 100, 88, 60, 110, 47, 0.962, 31, 'Not Diabetic'),
(59, 0, 146, 82, 25, 194, 41, 1.781, 44, 'Not Diabetic'),
(60, 0, 105, 64, 41, 142, 42, 0.173, 22, 'Not Diabetic'),
(61, 2, 84, 88, 31, 163, 25, 0.304, 21, 'Not Diabetic'),
(62, 8, 133, 72, 38, 163, 33, 0.27, 39, 'Diabetic'),
(63, 5, 44, 62, 28, 123, 25, 0.587, 36, 'Not Diabetic'),
(64, 2, 141, 58, 34, 128, 25, 0.699, 24, 'Not Diabetic'),
(65, 7, 114, 66, 40, 299, 33, 0.258, 42, 'Diabetic'),
(66, 5, 99, 74, 27, 294, 29, 0.203, 32, 'Not Diabetic'),
(67, 0, 109, 88, 30, 300, 33, 0.855, 38, 'Diabetic'),
(68, 2, 109, 92, 39, 290, 43, 0.845, 54, 'Not Diabetic'),
(69, 1, 95, 66, 13, 38, 20, 0.334, 25, 'Not Diabetic'),
(70, 4, 146, 85, 27, 100, 29, 0.189, 27, 'Not Diabetic'),
(71, 2, 100, 66, 20, 90, 33, 0.867, 28, 'Diabetic'),
(72, 5, 139, 64, 35, 140, 29, 0.411, 26, 'Not Diabetic'),
(73, 13, 126, 90, 35, 297, 43, 0.583, 42, 'Diabetic'),
(74, 4, 129, 86, 20, 270, 35, 0.231, 23, 'Not Diabetic'),
(75, 1, 79, 75, 30, 286, 32, 0.396, 22, 'Not Diabetic'),
(76, 1, 0, 48, 20, 163, 25, 0.14, 22, 'Not Diabetic'),
(77, 7, 62, 78, 30, 292, 33, 0.391, 41, 'Not Diabetic'),
(78, 5, 95, 72, 33, 291, 38, 0.37, 27, 'Not Diabetic'),
(79, 0, 131, 98, 41, 356, 43, 0.27, 26, 'Diabetic'),
(80, 2, 112, 66, 22, 453, 25, 0.307, 24, 'Not Diabetic'),
(81, 3, 113, 44, 13, 135, 22, 0.14, 22, 'Not Diabetic'),
(82, 2, 74, 90, 26, 234, 22, 0.102, 22, 'Not Diabetic'),
(83, 7, 83, 78, 26, 71, 29, 0.767, 36, 'Not Diabetic'),
(84, 0, 101, 65, 28, 32, 25, 0.237, 22, 'Not Diabetic'),
(85, 5, 137, 108, 41, 109, 49, 0.227, 37, 'Diabetic'),
(86, 2, 110, 74, 29, 125, 32, 0.698, 27, 'Not Diabetic'),
(87, 13, 106, 72, 54, 285, 37, 0.178, 45, 'Not Diabetic'),
(88, 2, 100, 68, 25, 71, 39, 0.324, 26, 'Not Diabetic'),
(89, 15, 136, 70, 32, 110, 37, 0.153, 43, 'Diabetic'),
(90, 1, 107, 68, 19, 194, 27, 0.165, 24, 'Not Diabetic'),
(91, 1, 80, 55, 40, 24, 19, 0.258, 21, 'Not Diabetic'),
(92, 4, 123, 80, 15, 176, 32, 0.443, 34, 'Not Diabetic'),
(93, 7, 81, 78, 40, 48, 47, 0.261, 42, 'Not Diabetic'),
(94, 4, 134, 72, 47, 14, 24, 0.277, 60, 'Diabetic'),
(95, 2, 142, 82, 18, 64, 25, 0.761, 21, 'Not Diabetic'),
(96, 6, 144, 72, 27, 228, 34, 0.255, 40, 'Not Diabetic'),
(97, 2, 92, 62, 28, 289, 32, 0.13, 24, 'Not Diabetic'),
(98, 1, 71, 48, 18, 76, 20, 0.323, 22, 'Not Diabetic'),
(99, 6, 93, 50, 30, 64, 29, 0.356, 23, 'Not Diabetic'),
(100, 2, 120, 74, 35, 290, 30, 0.247, 59, 'Diabetic'),
(105, 2, 60, 120, 32, 64, 59, 0.025, 25, 'Diabetic');

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

DROP TABLE IF EXISTS `rules`;
CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `input` varchar(50) NOT NULL,
  `value` double NOT NULL,
  `operator` varchar(1) NOT NULL COMMENT '<, >, =',
  `conclusion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `input`, `value`, `operator`, `conclusion`) VALUES
(1, 'Blood Glucose 2hrs after GTT', 120, '>', 'Diabetic'),
(2, 'SkinThickness', 34, '>', 'Diabetic'),
(3, 'Diastolic BloodPressure', 96, '<', 'Not Diabetic'),
(4, 'BMI', 27, '>', 'Diabetic'),
(5, '2 hr insulin level', 295, '<', 'Not Diabetic');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
