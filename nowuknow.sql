-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2025 at 01:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nowuknow`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `followID` int(11) NOT NULL,
  `followedID` int(11) NOT NULL,
  `followerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `dateUploaded` datetime NOT NULL,
  `attachment` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  `tagID` int(11) DEFAULT NULL,
  `ratingID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `title`, `description`, `dateUploaded`, `attachment`, `userID`, `tagID`, `ratingID`) VALUES
(1, 'Life Update.', 'I had fun tonight.', '0000-00-00 00:00:00', 'maloi.JPG', 4, 3, NULL),
(2, 'I bought X', 'X is now under my control.', '2025-01-20 11:34:55', 'elonMusk.jpg', 1, 1, NULL),
(3, 'SQL injection prevention', 'SQL injection prevention involves using prepared statements with parameterized queries to ensure user inputs are treated as data rather than executable code. Additionally, input validation and sanitization should be employed to filter out harmful characters or unexpected input. Using an ORM (Object-Relational Mapping) framework can further protect against SQL injection by automatically handling query construction securely.', '2025-01-20 11:36:33', 'johnDoe.jpg', 9, 1, NULL),
(4, 'Adobo Recipe', 'I will teach you how to cook Adobo.......See more', '2025-01-20 11:42:35', 'adobo.jpg', 12, 4, NULL),
(5, 'Sharing my artwork.', 'This is my artwork in my class.', '2025-01-20 11:49:20', 'trees.jpg', 15, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `ratingID` int(11) NOT NULL,
  `ratingValue` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `savedbookmarks`
--

CREATE TABLE `savedbookmarks` (
  `bookmarkID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savedbookmarks`
--

INSERT INTO `savedbookmarks` (`bookmarkID`, `postID`, `userID`) VALUES
(3, 5, 1),
(4, 4, 1),
(5, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tagID` int(11) NOT NULL,
  `tags` varchar(50) NOT NULL,
  `tagImg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tagID`, `tags`, `tagImg`) VALUES
(1, 'Technology', 'assets/imgs/Technology.jpg'),
(2, 'Education', 'assets/imgs/Technology.jpg'),
(3, 'Lifestyle', 'assets/imgs/Lifestyle.jpg'),
(4, 'Cooking', 'assets/imgs/Cooking.jpg'),
(5, 'Art', 'assets/imgs/Art.jpg'),
(6, 'Health', 'assets/imgs/Health.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `profilePicture` varchar(100) DEFAULT NULL,
  `coverPhoto` varchar(100) DEFAULT NULL,
  `userType` varchar(5) NOT NULL DEFAULT 'user',
  `phoneNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `userName`, `email`, `password`, `birthday`, `profilePicture`, `coverPhoto`, `userType`, `phoneNumber`) VALUES
(1, 'Elon', 'Musk', 'elonmusk', 'elonmusk@gmail.com', 'elon123', '1971-06-28', NULL, NULL, 'user', 2147483647),
(2, 'Sophia', 'Harrison', 'adminSophie', 'sophie.harrison@example.com', 'sophie123', '1995-08-14', NULL, NULL, 'admin', 2147483647),
(3, 'Olivia', 'Smith', 'livSmith', 'olivia.smith@example.com', 'olivia123', '1992-03-22', NULL, NULL, 'user', 2147483647),
(4, 'Emma', 'Johnson', 'emmaJ', 'emma.johnson@example.com', 'emma123', '1990-10-05', NULL, NULL, 'user', 2147483647),
(5, 'Ava', 'Williams', 'avaWill', 'ava.williams@example.com', 'ava123', '1993-02-11', NULL, NULL, 'user', 2147483647),
(6, 'Isabella', 'Brown', 'isabellaB', 'isabella.brown@example.com', 'isabella123', '1994-07-18', NULL, NULL, 'user', 2147483647),
(7, 'Mia', 'Davis', 'miaDavis', 'mia.davis@example.com', 'mia123', '1996-01-25', NULL, NULL, 'user', 2147483647),
(8, 'Amelia', 'Martinez', 'ameliaMart', 'amelia.martinez@example.com', 'amelia123', '1991-05-12', NULL, NULL, 'user', 2147483647),
(9, 'John', 'Doe', 'johnDoe', 'john.doe@example.com', 'john123', '1985-07-12', NULL, NULL, 'user', 2147483647),
(10, 'Michael', 'Smith', 'michaelSmith', 'michael.smith@example.com', 'michael123', '1992-04-25', NULL, NULL, 'user', 2147483647),
(11, 'David', 'Johnson', 'davidJohnson', 'david.johnson@example.com', 'david123', '1988-11-30', NULL, NULL, 'user', 2147483647),
(12, 'James', 'Brown', 'jamesBrown', 'james.brown@example.com', 'james123', '1995-02-14', NULL, NULL, 'user', 2147483647),
(13, 'William', 'Taylor', 'williamTaylor', 'william.taylor@example.com', 'william123', '1990-06-18', NULL, NULL, 'user', 2147483647),
(14, 'Robert', 'Williams', 'robertWilliams', 'robert.williams@example.com', 'robert123', '1993-12-07', NULL, NULL, 'user', 2147483647),
(15, 'Charles', 'Davis', 'charlesDavis', 'charles.davis@example.com', 'charles123', '1986-01-22', NULL, NULL, 'user', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `visitID` int(6) NOT NULL,
  `page` varchar(50) NOT NULL,
  `dateTime` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`followID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`ratingID`);

--
-- Indexes for table `savedbookmarks`
--
ALTER TABLE `savedbookmarks`
  ADD PRIMARY KEY (`bookmarkID`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tagID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`visitID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `followID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `ratingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savedbookmarks`
--
ALTER TABLE `savedbookmarks`
  MODIFY `bookmarkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `visitID` int(6) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
