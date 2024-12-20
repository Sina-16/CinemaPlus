-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 12:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinema_plus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--
-- Error reading structure for table cinema_plus.admins: #1932 - Table 'cinema_plus.admins' doesn't exist in engine
-- Error reading data for table cinema_plus.admins: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `cinema_plus`.`admins`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `app_user`
--
-- Error reading structure for table cinema_plus.app_user: #1932 - Table 'cinema_plus.app_user' doesn't exist in engine
-- Error reading data for table cinema_plus.app_user: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `cinema_plus`.`app_user`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `cinema_movies`
--
-- Error reading structure for table cinema_plus.cinema_movies: #1932 - Table 'cinema_plus.cinema_movies' doesn't exist in engine
-- Error reading data for table cinema_plus.cinema_movies: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `cinema_plus`.`cinema_movies`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `cinema_show_times`
--
-- Error reading structure for table cinema_plus.cinema_show_times: #1932 - Table 'cinema_plus.cinema_show_times' doesn't exist in engine
-- Error reading data for table cinema_plus.cinema_show_times: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `cinema_plus`.`cinema_show_times`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `rating` float NOT NULL,
  `actors` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `genre`, `rating`, `actors`, `release_date`, `description`, `duration`, `image_path`) VALUES
(17, 'movie', 'abcd abcd abcd abcd abcd abcd abcd abcd abcd abcd abcd abcd', 9, 'Bat man Bat man Bat man Bat man', '1999-12-02', 'moview moview moview moview moview moview moview moview moview moview moview moview moview moview moview moview moview', 788, '0');

-- --------------------------------------------------------

--
-- Table structure for table `movie_cast`
--
-- Error reading structure for table cinema_plus.movie_cast: #1932 - Table 'cinema_plus.movie_cast' doesn't exist in engine
-- Error reading data for table cinema_plus.movie_cast: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `cinema_plus`.`movie_cast`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Error reading structure for table cinema_plus.users: #1932 - Table 'cinema_plus.users' doesn't exist in engine
-- Error reading data for table cinema_plus.users: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `cinema_plus`.`users`' at line 1

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
