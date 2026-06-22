-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 22, 2026 at 05:29 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `literacy_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
CREATE TABLE IF NOT EXISTS `achievements` (
  `achievement_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `badge_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unlocked_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`achievement_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`achievement_id`, `user_id`, `badge_name`, `badge_type`, `unlocked_at`) VALUES
(43, 13, 'Top Supporter', 'badge', '2026-05-04 02:59:45'),
(41, 13, 'Book Explorer', 'badge', '2026-05-04 02:59:28'),
(42, 13, 'Community Voice', 'badge', '2026-05-04 02:59:39'),
(39, 27, 'Certificate', 'certificate', '2026-05-03 08:38:48'),
(40, 27, 'Top Supporter', 'badge', '2026-05-03 08:40:42'),
(37, 27, 'Community Voice', 'badge', '2026-05-03 08:37:06'),
(36, 27, 'Book Explorer', 'badge', '2026-05-03 08:32:52'),
(20, 14, 'Certificate', 'certificate', '2026-05-02 08:29:25'),
(19, 14, 'Community Voice', 'badge', '2026-05-02 08:29:17'),
(18, 14, 'Top Supporter', 'badge', '2026-05-02 08:27:59'),
(16, 14, 'Book Explorer', 'badge', '2026-05-02 07:28:49'),
(44, 13, 'Certificate', 'certificate', '2026-05-04 02:59:51'),
(45, 27, 'Published Author', 'badge', '2026-05-04 09:25:19'),
(56, 34, 'Trending Writer', 'badge', '2026-05-22 04:38:39'),
(54, 34, 'Book Explorer', 'badge', '2026-05-22 03:57:18'),
(55, 34, 'Published Author', 'badge', '2026-05-22 04:38:36'),
(57, 34, 'Reader Favorite', 'badge', '2026-05-22 04:38:43'),
(58, 34, 'Certificate', 'certificate', '2026-05-22 04:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Short stories'),
(2, 'Horror Stories'),
(3, 'Love Stories'),
(4, 'Food Recepie'),
(5, 'Travel'),
(6, 'Motivation'),
(7, 'Poetry'),
(8, 'Education'),
(9, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `comment_text`, `created_at`) VALUES
(13, 13, 14, 'nice', '2026-05-02 08:29:07'),
(8, 15, 13, 'hi', '2026-04-09 12:39:57'),
(10, 15, 13, '', '2026-04-14 05:43:56'),
(11, 17, 13, 'hi', '2026-04-20 05:26:59'),
(16, 13, 27, 'Short but beautiful', '2026-05-03 06:12:47'),
(17, 14, 32, 'i tried it came nice', '2026-05-21 17:36:16'),
(18, 12, 34, 'Thanku its inspiring', '2026-05-22 03:57:02'),
(19, 27, 34, 'nice', '2026-05-22 04:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('unread','read') COLLATE utf8mb4_unicode_ci DEFAULT 'unread',
  PRIMARY KEY (`notification_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message`, `is_read`, `created_at`, `status`) VALUES
(3, 27, '❌ Your writer request was rejected. Reason: not appropriate bio', 0, '2026-05-03 16:02:17', 'read'),
(4, 27, '❌ Your writer request was rejected. Reason: not good bio', 0, '2026-05-03 16:56:20', 'read'),
(5, 27, '🎉 Congratulations! Your request has been approved.', 0, '2026-05-03 16:58:30', 'read'),
(6, 27, '🎉 Congratulations! Your request has been approved.', 0, '2026-05-07 08:16:15', 'read'),
(7, 32, '❌ Your writer request was rejected. Reason: the reasons are not valid . please provide the appropriate reasons.', 0, '2026-05-21 17:39:30', 'read'),
(8, 32, '🎉 Congratulations! Your request has been approved.', 0, '2026-05-21 17:42:02', 'read'),
(9, 34, '❌ Your writer request was rejected. Reason: inappropriate', 0, '2026-05-22 04:16:58', 'read'),
(10, 34, '🎉 Congratulations! Your request has been approved.', 0, '2026-05-22 04:18:19', 'read'),
(11, 34, '🎉 Congratulations! Your request has been approved.', 0, '2026-05-22 04:41:36', 'read'),
(12, 34, '🎉 Congratulations! Your request has been approved.', 0, '2026-05-22 04:45:00', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `author_id`, `title`, `content`, `image`, `category_id`, `status`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(10, 18, 'The Last Leaf of Hope', 'Ravi had almost given up on life. Every day felt heavier than the last, and hope seemed like a distant memory. He spent most of his time staring out of his window at an old tree that stood silently in front of his house.\r\n\r\nAs autumn arrived, the leaves began to fall one by one. Ravi started believing that his life was just like those leaves—slowly fading away.\r\n\r\nOne evening, he whispered to himself, “When the last leaf falls, I will give up too.”\r\n\r\nDays passed. The wind grew stronger. Rain poured heavily. Leaves kept falling. But one leaf stayed.\r\n\r\nRavi woke up every morning just to check if that last leaf was still there. And it was.\r\n\r\nThrough storms, through cold nights, through heavy rain—it survived.\r\n\r\nSomething inside Ravi began to change.\r\n\r\n“If that leaf can survive everything, why can’t I?” he thought.\r\n\r\nThat small thought turned into strength. He started taking care of himself again. He began to believe again.\r\n\r\nWeeks later, Ravi stepped outside for the first time. He walked towards the tree and realized something surprising.\r\n\r\nThe last leaf was not real. It had been painted there by an old artist who lived nearby—just to give someone hope.\r\n\r\nRavi smiled.\r\n\r\nSometimes, hope doesn’t come naturally. Sometimes, it is created.\r\n\r\nAnd sometimes, that small hope is enough to change a life.', 'last hope .jpeg', 6, 'approved', '', '2026-04-03 17:26:38', NULL),
(11, 18, 'Shadows in the Dark', 'The village of Kaldur was known for its silence after sunset. People would shut their doors early, and no one dared to step outside at night.\r\n\r\nRohan, a traveler, arrived in the village one evening. He found the fear in people strange but ignored their warnings.\r\n\r\nThat night, he heard whispers.\r\n\r\nAt first, it sounded like the wind. But slowly, it turned into voices. Calling his name.\r\n\r\n“Rohan…”\r\n\r\nHe stepped outside. The street was empty, but shadows moved along the walls.\r\n\r\nHe followed them.\r\n\r\nThe deeper he went, the colder it became. The voices grew louder.\r\n\r\nSuddenly, everything stopped.\r\n\r\nSilence.\r\n\r\nThen, right behind him—\r\n\r\nA whisper.\r\n\r\n“You shouldn’t have come.”\r\n\r\nRohan turned back slowly, but there was no one. Only his own shadow.\r\n\r\nBut it wasn’t moving with him.\r\n\r\nIt moved on its own.\r\n\r\nTerrified, he ran back to his room and locked the door. The whispers continued all night.\r\n\r\nThe next morning, the villagers found his room open.\r\n\r\nBut Rohan was gone.\r\n\r\nOnly one thing remained—\r\n\r\nA shadow on the wall that didn’t belong to anyone.', 'shadows in the dark.jpeg', 2, 'approved', 'inakjb', '2026-04-03 17:31:56', NULL),
(12, 18, 'The Journey Begins', 'Arjun had always dreamed of traveling the world, but life kept giving him reasons to stay back. Responsibilities, work, and fear held him in place.\r\n\r\nOne day, he decided that waiting for the “perfect time” was pointless.\r\n\r\nHe packed his bag.\r\n\r\nNo big plan. No luxury. Just a simple decision—to begin.\r\n\r\nHis first destination was a small hill station. The air was fresh, the mountains stood tall, and for the first time in years, he felt free.\r\n\r\nHe met new people, heard new stories, and experienced life beyond his routine.\r\n\r\nTravel was not just about places. It was about discovering yourself.\r\n\r\nAs days passed, Arjun realized something important—\r\n\r\nHe wasn’t escaping life.\r\n\r\nHe was finally living it.\r\n\r\nEvery journey starts with a single step.\r\n\r\nAnd sometimes, that step is all it takes to change everything.', 'the journey begins.jpeg', 5, 'approved', '', '2026-04-03 17:34:19', NULL),
(13, 19, 'Love Beyond Words', 'Aarav and Meera had known each other for years, yet they rarely spoke about their feelings. Their bond was built on small gestures—sharing notes, waiting after class, and silent understanding.\r\n\r\nOne day, Meera had to leave the city for her studies. Neither of them confessed their feelings. There were no dramatic goodbyes, only a quiet smile and a promise to stay in touch.\r\n\r\nMonths passed. Life became busy. Messages became shorter. Calls became rare.\r\n\r\nBut one evening, Meera received a simple message from Aarav:\r\n“I saw something today that reminded me of you.”\r\n\r\nIt was just a picture of their favorite place.\r\n\r\nAt that moment, Meera realized something important. Love is not always about grand expressions or perfect words. Sometimes, it lives quietly in memories, in small actions, and in the effort to stay connected.\r\n\r\nWhen they met again after a long time, nothing felt awkward. It felt like home.\r\n\r\nBecause true love does not need words. It understands silence.', 'love beyond words.jpeg', 3, 'approved', '', '2026-04-03 17:37:12', NULL),
(14, 19, 'Chocalate Cake Recepie', 'Cooking is not just about food—it is about creating happiness. One of the simplest and most loved desserts is a classic chocolate cake.\r\n\r\nTo begin, gather the ingredients: flour, sugar, cocoa powder, eggs, milk, butter, and baking powder.\r\n\r\nFirst, mix the dry ingredients in a bowl. In another bowl, beat the eggs and sugar until smooth. Add milk and melted butter, and mix well.\r\n\r\nSlowly combine the dry mixture with the wet ingredients. Stir gently until you get a smooth batter.\r\n\r\nPour the batter into a greased baking tray and bake at 180°C for about 30–35 minutes.\r\n\r\nAs the cake bakes, the aroma fills the room, creating a warm and comforting feeling.\r\n\r\nOnce done, let it cool and add chocolate frosting if desired.\r\n\r\nThe result is a soft, rich, and delicious cake that brings smiles to everyone.\r\n\r\nSometimes, the sweetest moments in life are created in the kitchen.', 'chocalate cake recepie.jpg', 4, 'approved', '', '2026-04-03 17:39:22', NULL),
(15, 19, 'Silent Strength', 'Not all strength is visible. Sometimes, the strongest people are the ones who fight silent battles every day.\r\n\r\nNeha was known as a quiet person. She never complained, never argued, and rarely shared her problems. To others, her life seemed simple.\r\n\r\nBut behind that calm face was a story of struggles—family responsibilities, academic pressure, and personal challenges.\r\n\r\nInstead of giving up, she chose to stay strong. Not loudly, not dramatically—but quietly.\r\n\r\nShe woke up every day, completed her responsibilities, and kept moving forward.\r\n\r\nNo one noticed her efforts. No one praised her strength.\r\n\r\nBut she didn’t stop.\r\n\r\nBecause true strength does not depend on recognition. It comes from within.\r\n\r\nOne day, her hard work paid off. She achieved her goals, not with noise, but with consistency.\r\n\r\nPeople were surprised.\r\n\r\nBut she wasn’t.\r\n\r\nBecause she always knew her strength.\r\n\r\nSilent strength is still strength. And sometimes, it is the most powerful kind.', 'silent strength.jpg', 6, 'approved', '', '2026-04-03 17:41:51', NULL),
(19, 27, 'First work', 'first work writing', 'img3.jpeg', 9, 'pending', '', '2026-05-03 17:04:08', NULL),
(20, 27, 'First work', 'first work writing', 'img3.jpeg', 9, 'pending', '', '2026-05-03 17:05:13', NULL),
(21, 27, 'First work', 'first work writing', 'img3.jpeg', 9, 'pending', '', '2026-05-03 17:06:46', NULL),
(22, 27, 'my first work', 'jdseh gudhnbjfxnvx ', 'img3.jpeg', 9, 'rejected', 'The request form was not filled appropriately. The content in few fields is not understandable. Please try again once by appropriate ddetails.\r\n', '2026-05-03 17:13:13', NULL),
(23, 18, 'my life', 'cvbcbvb', '', 9, 'rejected', 'in appropriate content', '2026-05-08 17:29:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_reactions`
--

DROP TABLE IF EXISTS `post_reactions`;
CREATE TABLE IF NOT EXISTS `post_reactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `reaction` enum('like','dislike') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_post` (`user_id`,`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_reactions`
--

INSERT INTO `post_reactions` (`id`, `user_id`, `post_id`, `reaction`, `created_at`) VALUES
(1, 13, 17, 'like', '2026-04-09 07:14:15'),
(2, 13, 15, 'like', '2026-04-10 07:49:08'),
(3, 13, 13, 'dislike', '2026-04-10 07:51:45'),
(4, 13, 14, 'dislike', '2026-04-11 14:32:40'),
(5, 13, 10, 'like', '2026-04-14 05:45:10'),
(6, 18, 13, 'like', '2026-04-20 09:13:00'),
(7, 14, 12, 'like', '2026-05-02 02:29:19'),
(8, 27, 14, 'like', '2026-05-03 06:22:05'),
(9, 27, 13, 'like', '2026-05-03 06:22:06'),
(10, 28, 15, 'like', '2026-05-07 07:08:32'),
(11, 32, 14, 'like', '2026-05-21 17:35:46'),
(12, 34, 14, 'dislike', '2026-05-22 03:56:00'),
(13, 34, 12, 'like', '2026-05-22 03:56:07'),
(14, 34, 27, 'like', '2026-05-22 04:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `rating_id` int NOT NULL AUTO_INCREMENT,
  `post_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  PRIMARY KEY (`rating_id`)
) ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `post_id`, `user_id`, `rating`) VALUES
(2, 13, 23, 4),
(3, 13, 13, 2),
(4, 15, 13, 4),
(5, 15, 14, 2),
(6, 14, 13, 3),
(7, 13, 27, 3),
(8, 14, 27, 4),
(9, 14, 32, 2),
(10, 12, 34, 2),
(11, 27, 34, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `writer_request` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `status`, `writer_request`, `created_at`, `profile_image`, `mobile`, `gender`, `otp`, `otp_expiry`) VALUES
(17, 'Megha Patel', 'megha@gmail.com', '$2y$10$fbeFK0f/3KgvOMET3kPa8.7J/dgLh5WOz2HwYEF4WI9eHvoigTjmC', 'user', 'active', '', '2026-04-07 15:25:50', NULL, '9876543210', 'Female', NULL, NULL),
(16, 'Kiran Shetty', 'kiran@gmail.com', '$2y$10$XYNJVSM7AF9678nNfsdis.XNxnQDeXsq9/vBOJodxoNYRK2EIEb.6', 'user', 'active', '', '2026-04-07 15:25:50', NULL, '9123456789', 'Male', NULL, NULL),
(15, 'Priya Nair', 'priya@gmail.com', '$2y$10$bza0r82aGINI/1pVYXbxOO7CSf6vYsNow3yOmeDHowt66Li6qpoM.', 'user', 'active', '', '2026-04-07 15:25:50', NULL, '9988776655', 'Female', NULL, NULL),
(13, 'Ananya rao', 'ananya@gmail.com', '$2y$10$80d8e3jTYaRCFZIsEaarj.X.r02SzoWn5gqJtOBJjEp1q2UjV83Hi', 'user', 'active', 'none', '2026-04-07 15:25:50', '1776665901.jpeg', '8431465369', 'Female', NULL, NULL),
(14, 'Rahul Sharma', 'rahul@gmail.com', '$2y$10$lDyQ0x/DDOP94sC5sU2fgu0PACDiqhhasy.ustMsDHz5FAMqiwG/a', 'user', 'active', 'none', '2026-04-07 15:25:50', NULL, '9012345678', 'Male', NULL, NULL),
(18, 'Arjun Verma', 'arjun@gmail.com', '$2y$10$S5KVqWL5i3N2Q7LCPrACJeS2WV/O1kX4Nj.Tiplx/1/uLSPwf.E1m', 'writer', 'active', 'none', '2026-04-07 15:25:50', NULL, '9765432109', 'Male', NULL, NULL),
(19, 'Sneha Kulkarni', 'sneha@gmail.com', '$2y$10$RXxRu8M9R4wNaj3j4mzUVu/pAVW5dMR/P2WpaPak8wev/1WW1/90G', 'writer', 'active', '', '2026-04-07 15:25:50', NULL, '8899776655', 'Female', NULL, NULL),
(20, 'Rohan Das', 'rohan@gmail.com', '$2y$10$69VMsMe8TQMbVwWgKJM0be5MpE9xiz1KCInyCrt57HSYh6Vz.u832', 'writer', 'active', '', '2026-04-07 15:25:50', NULL, '9345678123', 'Male', NULL, NULL),
(21, 'Kavya Reddy', 'kavya@gmail.com', '$2y$10$UTp4u./BdHZdMfe27peSAefc0qZ8wJ5RGni2bhCZ5P/LEtZQAoH.G', 'writer', 'active', '', '2026-04-07 15:25:50', NULL, '9012340987', 'Female', NULL, NULL),
(22, 'Imran Khan', 'imran@gmail.com', '$2y$10$OMgawb1KCyBWEUi4VP//AO9UtZ2iYvzbWh/dXqA3Zze2kR.U.A6H.', 'writer', 'active', '', '2026-04-07 15:25:50', NULL, '9988001122', 'Male', NULL, NULL),
(23, 'admin', 'admin@gmail.com', '$2y$10$dx7V1RxumLATM4nSm2qZfOarBM59F5roodBV/daPVzGug697KU78.', 'admin', 'active', '', '2026-04-07 15:25:50', NULL, '9123450987', 'Male', NULL, NULL),
(31, 'souju', 'soujanyabetageri20@gmail.com', '$2y$10$KPpDA9m42vtRFcWClPBlV.tybLSm1Xb0T/CWrfwAaDjFMhnf6niCi', 'user', 'active', '', '2026-05-08 10:41:06', NULL, '8431465369', 'Female', NULL, NULL),
(27, 'kavana', 'kavana@gmail.com', '$2y$10$ot4jFG0vmMD2AcOshnEtj.dS/ZZ.UA0F8oQpDbuax18s2tKiW4Smu', 'user', 'active', 'none', '2026-05-03 04:34:13', NULL, '7568378745', 'Female', NULL, NULL),
(28, 'shrusti', 'shrusti12@gmail.com', '$2y$10$dLl91/545G/SsHDK4YBJ4efXbhhplwotpk0Dw2UjVpK83UfzG7X.G', 'user', 'active', '', '2026-05-07 00:02:41', NULL, '6789345674', 'Female', '245539', '2026-05-08 10:05:33'),
(30, 'abhinaya', 'abhinaya@gmail.com', '$2y$10$5K4.fS855KUulXJ9GdFBT.Gj.wmCg5iN8dKKz5wsvrKzPv4R.OeMK', 'user', 'active', 'none', '2026-05-07 08:54:20', NULL, '6789345674', 'Female', NULL, NULL),
(34, 'shraddha', 'shraddhabetageri143@gmail.com', '$2y$10$X4pz6lqKbLwR01ucTLKk7.hfHCCxrkQ4hZ/ma61qYRv.N0Ie94Xb.', 'user', 'active', 'none', '2026-05-22 03:37:08', NULL, '6789345674', 'Female', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

DROP TABLE IF EXISTS `user_activity`;
CREATE TABLE IF NOT EXISTS `user_activity` (
  `activity_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `activity_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `writer_profile`
--

DROP TABLE IF EXISTS `writer_profile`;
CREATE TABLE IF NOT EXISTS `writer_profile` (
  `writer_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`writer_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `writer_requests`
--

DROP TABLE IF EXISTS `writer_requests`;
CREATE TABLE IF NOT EXISTS `writer_requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `request_message` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`request_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `writer_requests`
--

INSERT INTO `writer_requests` (`request_id`, `user_id`, `request_message`, `status`, `rejection_reason`, `created_at`) VALUES
(26, 27, '\r\nFull Name: Kavana \r\n\r\nWriting Interest: Short stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\ninterested\r\n\r\nWriting Goals:\r\n100%\r\n', 'rejected', 'not appropriate bio', '2026-05-03 16:01:35'),
(27, 27, '\r\nFull Name: kavana\r\n\r\nWriting Interest: Short stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\ninterested\r\n\r\nWriting Goals:\r\n100%\r\n', 'rejected', 'not good bio', '2026-05-03 16:55:34'),
(28, 27, '\r\nFull Name: kavana\r\n\r\nWriting Interest: Short stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\ninterested\r\n\r\nWriting Goals:\r\n100%\r\n', 'approved', NULL, '2026-05-03 16:57:34'),
(29, 27, '\r\nFull Name: kavana\r\n\r\nWriting Interest: Short stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\ni am interested\r\n\r\nWriting Goals:\r\n100%\r\n', 'approved', NULL, '2026-05-07 08:15:38'),
(31, 32, '\r\nFull Name: shraddha\r\n\r\nWriting Interest: Short stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\nwjsxnvjnvjcnvvvb\r\n\r\nWriting Goals:\r\nnmnmmmm\r\n', 'rejected', 'the reasons are not valid . please provide the appropriate reasons.', '2026-05-21 17:38:14'),
(32, 32, '\r\nFull Name: shraddha\r\n\r\nWriting Interest: Short stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\nggunbnbn\r\n\r\nWriting Goals:\r\nhhghjh\r\n', 'approved', NULL, '2026-05-21 17:40:48'),
(38, 34, '\r\nFull Name: shraddha\r\n\r\nWriting Interest: Horror Stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\ndfcvc\r\n\r\nWriting Goals:\r\ncxvcv\r\n', 'rejected', 'inappropriate', '2026-05-22 04:15:50'),
(39, 34, '\r\nFull Name: shraddha\r\n\r\nWriting Interest: Horror Stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\ngdfgbffbcvgb\r\n\r\nWriting Goals:\r\nvfbfcbcvgv\r\n', 'approved', NULL, '2026-05-22 04:17:48'),
(40, 34, '\r\nFull Name: cxvxc\r\n\r\nWriting Interest: Love Stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\nxcvx\r\n\r\nWriting Goals:\r\ncxvx\r\n', 'approved', NULL, '2026-05-22 04:40:33'),
(41, 34, '\r\nFull Name: shraddha\r\n\r\nWriting Interest: Horror Stories\r\n\r\nExperience Level: Beginner\r\n\r\nReason:\r\nxzczxc\r\n\r\nWriting Goals:\r\nxczccx\r\n', 'approved', NULL, '2026-05-22 04:44:31');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
