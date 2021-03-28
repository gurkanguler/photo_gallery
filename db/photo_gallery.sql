-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 28, 2021 at 08:37 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photo_gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `username` text COLLATE utf8_turkish_ci NOT NULL,
  `photos` blob NOT NULL,
  `date` datetime NOT NULL,
  `begeni_sayisi` int(11) DEFAULT NULL,
  `begenenler` text COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `username`, `photos`, `date`, `begeni_sayisi`, `begenenler`) VALUES
(5, 'test4', 0x75736572732f55706c6f6164732f616e6f6e796d6f75732e6a7067, '2021-03-28 09:03:48', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `takipci`
--

CREATE TABLE `takipci` (
  `id` int(11) NOT NULL,
  `takip_edilen` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `takip_eden` text COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_turkish_ci NOT NULL,
  `surname` text COLLATE utf8_turkish_ci NOT NULL,
  `email` text COLLATE utf8_turkish_ci NOT NULL,
  `username` text COLLATE utf8_turkish_ci NOT NULL,
  `password` text COLLATE utf8_turkish_ci NOT NULL,
  `profil_photo` blob DEFAULT NULL,
  `birthday` datetime NOT NULL,
  `photos` blob DEFAULT NULL,
  `followers` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `following` text COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `username`, `password`, `profil_photo`, `birthday`, `photos`, `followers`, `following`) VALUES
(18, 'test', 'test', 'test@gmail.com', 'test', 'cc03e747a6afbbcbf8be7668acfebee5', 0x75736572732f55706c6f6164732f6861636b65722e6a7067, '2021-03-01 00:00:00', NULL, NULL, NULL),
(21, 'test3', 'test3', 'test3@gmail.com', 'test3', 'd18a4ce47e0f5fa8d7a75ec8bc2cf8c9', 0x75736572732f55706c6f6164732f36303961333465333062343263336434663563613838396336626666343231622e6a7067, '2021-03-10 00:00:00', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `takipci`
--
ALTER TABLE `takipci`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `takipci`
--
ALTER TABLE `takipci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
