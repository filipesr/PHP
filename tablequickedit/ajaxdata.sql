-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08 Des 2016 pada 01.44
-- Versi Server: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ajaxdata`
--
CREATE DATABASE IF NOT EXISTS `ajaxdata` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ajaxdata`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabledit`
--

CREATE TABLE IF NOT EXISTS `tabledit` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `gender` enum('Laki-laki','Perempuan','Waria') NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tabledit`
--

INSERT INTO `tabledit` (`id`, `name`, `gender`, `email`, `phone`, `address`, `deleted`) VALUES
(1, 'Ghazali', 'Laki-laki', 'ghazali.samudra@hotmail.com', '086756654677', 'Palabuhanratu, sukabumi', 0),
(2, 'Nurjannah', 'Perempuan', 'nur@gmail.com', '08675566', 'Pidie', 0),
(3, 'Boyhaki', 'Laki-laki', 'boyhaki@gmail.com', '086765443534', 'Pijay', 0),
(4, 'Bukhari', 'Laki-laki', 'bukhari@gmail.com', '0897767544', 'Blangpidie', 0),
(5, 'Budis', 'Perempuan', 'budi@gmail.com', '09767667556777', 'Pidie', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabledit`
--
ALTER TABLE `tabledit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabledit`
--
ALTER TABLE `tabledit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
