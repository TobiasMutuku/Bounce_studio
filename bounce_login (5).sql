-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 20, 2023 at 12:49 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bounce_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` longtext NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `email`, `subject`, `message`, `time`, `user_id`) VALUES
(1, 'timmy_bounce@gmail.com', 'Recording', 'Can you do a song recording for me tomorrow', '2023-03-31 19:59:52', 10),
(2, 'dishonpolycap@gmail.com', 'shooting', 'testing', '2023-04-20 10:34:02', 11);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE IF NOT EXISTS `equipment` (
  `equipment_id` int NOT NULL AUTO_INCREMENT,
  `equipment_name` varchar(30) NOT NULL,
  `description` mediumtext NOT NULL,
  `availability` varchar(3) NOT NULL,
  `equipment_image` longblob NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`equipment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `equipment_name`, `description`, `availability`, `equipment_image`, `time`) VALUES
(1, 'DAW Software', 'For our Digital Audio Workstation we use Pro Tools ,great for all sounds at all levels', 'Yes', 0x6461772e6a7067, '2023-03-31 22:22:53'),
(2, 'Mic &amp; popfilter', 'Shure SM57 Dynamic Mic with Stedman Proscreen XL pop filter', 'Yes', 0x6d69632d706f7066696c7465722e6a7067, '2023-03-31 22:24:59'),
(3, 'Sequencer', 'For sequensers we have Digitakt &amp; MPC X', 'Yes', 0x73657175656e6365722e6a7067, '2023-03-31 22:25:57'),
(4, 'Sound mixer', 'We use Mackie Profx8v2 8-Channel Compact Mixer', 'Yes', 0x6d697865722e6a7067, '2023-03-31 22:27:03'),
(5, 'Studio monitors', 'We use KRK Rokit5 G3', 'Yes', 0x73747564696f206d6f6e69746f722e6a7067, '2023-03-31 22:27:57'),
(6, 'Studio Rack Mounts', 'Middle Atlantic RK Series Rack Mounts', 'Yes', 0x7261636b2e77656270, '2023-03-31 22:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` bigint NOT NULL AUTO_INCREMENT,
  `review` text NOT NULL,
  `rating` int NOT NULL,
  `user_id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `review`, `rating`, `user_id`, `date`) VALUES
(1, 'i really enjoyed working with Bounce', 5, 1, '2023-03-31 20:04:17'),
(2, 'i really enjoyed working there', 5, 1, '2023-03-31 20:04:17'),
(3, 'Bounce studio is a five star studio which assures quality', 5, 11, '2023-04-01 06:33:04');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(30) NOT NULL,
  `description` mediumtext NOT NULL,
  `rate` bigint NOT NULL,
  `service_image` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `description`, `rate`, `service_image`, `time`) VALUES
(1, 'Recording', 'Our qualified recording engineers know exactly how to find the sound that you want. We have the recording expertise to give your project a premium sound', 8000, 'recording.jpg', '2023-03-31 21:11:59'),
(2, 'Mixing', 'We balance the elements in your song to elevate the emotions and vibe it conveys. Our goal is to help you achieve your vision for how you want each song to move your audience', 7000, 'mixing.jpg', '2023-03-31 21:13:26'),
(3, 'Mastering', 'The final stage of quality control where we make sure your song translates on everything from earbuds to cars to hi-fi stereos to club systems ,all while bringing out details and making sure your songs are cohesive and competitive', 7000, 'mastering.jpg', '2023-04-02 20:00:57');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

DROP TABLE IF EXISTS `songs`;
CREATE TABLE IF NOT EXISTS `songs` (
  `song_id` int NOT NULL AUTO_INCREMENT,
  `song_title` varchar(250) NOT NULL,
  `song_genre` varchar(250) NOT NULL,
  `release_date` date NOT NULL DEFAULT (curdate()),
  `artist_id` int NOT NULL,
  PRIMARY KEY (`song_id`),
  KEY `artist_id` (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_id`, `song_title`, `song_genre`, `release_date`, `artist_id`) VALUES
(1, 'hayawi cover', 'reggae', '2023-04-02', 1),
(2, 'I\'m coming babe', 'RnB', '2023-04-02', 1),
(3, 'Crazy world', 'Reggae', '1998-01-14', 11),
(4, 'Motorsport', 'Hip-hop', '2017-12-06', 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_no` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_image` varchar(100) NOT NULL,
  `verify_token` varchar(200) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `phone_no`, `password`, `account_type`, `date`, `user_image`, `verify_token`) VALUES
(1, 'cavine', 'cavinekotieno@gmail.com', '0720689740', 'admin', '', '2023-04-08 10:21:10', 'rafat.png', ''),
(2, 'max', 'tt@gmail.com', '0722689740', '1234', '', '2023-03-31 06:11:48', '', ''),
(3, 'kasuku', 'kasuku@gmail.com', '0724689740', 'kasuku254', '', '2023-03-31 06:12:01', '', ''),
(4, 'admin', 'admin@gmail.com', '', 'admin1234', '', '2023-03-31 09:57:02', '', ''),
(5, 'admin', 'user1@gmail.com', '+254742723948', '2023@bounce', '', '2023-04-20 12:41:12', '', 'f200ec5623661593854d20ce7d1f009e'),
(10, 'timmy', 'timmy_bounce@gmail.com', '+254742723968', 'user@bounce', '', '2023-03-31 09:41:42', '', ''),
(11, 'User', 'user2@gmail.com', '+254708910911', 'user2@2023', '', '2023-04-20 12:42:57', 'IMG-642c67996b0b24.61241418', '18ebd16294e82cd158dd87fa9505bf81'),
(12, 'Otieno', 'boncestudios@gmail.com', '+25437089140', 'bouncestudio@2023', '', '2023-04-02 20:46:56', 'rafat.png', ''),
(13, 'Amstrong', 'star@gmail.com', '+254702404068', 'star@bounce', '', '2023-04-04 18:08:25', 'IMG-642c67996b0b24.61241418.jpg', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_fk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_fk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_fk_1` FOREIGN KEY (`artist_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
