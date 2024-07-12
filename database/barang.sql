-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 05:43 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangcancel`
--

CREATE TABLE `barangcancel` (
  `id_cancel` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(25) NOT NULL,
  `pengirim` varchar(25) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangcancel`
--

INSERT INTO `barangcancel` (`id_cancel`, `id_barang`, `nama_barang`, `tanggal`, `penerima`, `pengirim`, `jumlah`, `status`) VALUES
(2, 4, 'DUTRON Lampu LED GIANT 50', '2024-07-12 02:42:09', '-', 'CV Industrial Ocho', 10, 'Ditolak'),
(4, 4, 'DUTRON Lampu LED GIANT 50', '2024-07-12 02:51:29', 'Yolo Industries', '-', 5, 'Retur'),
(5, 15, 'Lamborghini Aventador', '2024-07-12 02:52:34', 'CV Tunggal Abadi', '-', 2, 'Retur');

-- --------------------------------------------------------

--
-- Table structure for table `barangkeluar`
--

CREATE TABLE `barangkeluar` (
  `id_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(25) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangkeluar`
--

INSERT INTO `barangkeluar` (`id_keluar`, `id_barang`, `nama_barang`, `tanggal`, `penerima`, `jumlah`, `status`) VALUES
(21, 4, 'DUTRON Lampu LE', '2024-07-11 05:36:22', 'CV Tunggal Abadi', 12, 'Barang Keluar');

-- --------------------------------------------------------

--
-- Table structure for table `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `id_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `pengirim` varchar(25) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangmasuk`
--

INSERT INTO `barangmasuk` (`id_masuk`, `id_barang`, `nama_barang`, `tanggal`, `pengirim`, `jumlah`, `status`) VALUES
(32, 15, 'Lamborghini Ave', '2024-07-11 05:14:23', 'CV Industrial Ocho', 15, 'Barang Masuk');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_user`, `nama`, `alamat`, `email`, `password`, `level`) VALUES
(13, 'admin', 'Tebet', 'admin@gmail.com', '123987', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_barang` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id_barang`, `nama`, `deskripsi`, `harga`, `stock`, `barcode`, `foto`) VALUES
(3, 'Zyo Roger Working Desk', '• Material Keseluruhan : Particle Board, MDF, dan Metal.• Material Lainnya : Metal drawer runner• Finishing: Oak - Black Paper Foil', '500000454', 16, '487046', '668b38006ad42.jpg'),
(4, 'DUTRON Lampu LED GIANT 50', 'BOLA LAMPU LED 50 WATT', '500000', 128, '945066', '668b3736ea887.jpg'),
(15, 'Lamborghini Aventador', 'The Aventador was launched', '8000000000', 16, '827262', '66881ce109549.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangcancel`
--
ALTER TABLE `barangcancel`
  ADD PRIMARY KEY (`id_cancel`);

--
-- Indexes for table `barangkeluar`
--
ALTER TABLE `barangkeluar`
  ADD PRIMARY KEY (`id_keluar`);

--
-- Indexes for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`id_masuk`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangcancel`
--
ALTER TABLE `barangcancel`
  MODIFY `id_cancel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `barangkeluar`
--
ALTER TABLE `barangkeluar`
  MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
