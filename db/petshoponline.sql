-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2024 pada 15.57
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petshoponline`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `aid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`aid`, `username`, `address`, `email`, `password`) VALUES
(2, 'Pawpaw', 'Jl. Mangga Kompleks 99', 'pawpawpikpik0@gmail.com', '$2a$12$RakH8jZq5eu43sVP/6BRyeXiKEBwAsBYFQZ9wpF0BJn/3vqr0Qx02'),
(4, 'Admin', 'Jl. Kemangi', 'admin@gmail.com', 'admin'),
(8, 'Kunang', 'Jl. Mimpi Laam', 'kunang@gmail.com', '$2y$10$G328fpy///zFIhzOKbrsNe4Vd3q8S5onhUuY5ub/Q2XQ4oEkCMtj6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`cid`, `uid`) VALUES
(48, 3),
(50, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cartdetail`
--

CREATE TABLE `cartdetail` (
  `cdid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cartdetail`
--

INSERT INTO `cartdetail` (`cdid`, `cid`, `pid`, `qty`) VALUES
(72, 48, 10, 1),
(75, 50, 16, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `cid` int(11) NOT NULL,
  `categoryname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`cid`, `categoryname`) VALUES
(4, 'Obat Luka'),
(5, 'Obat Jamur'),
(6, 'Obat Kutu'),
(7, 'Obat Cacing'),
(8, 'Makanan Kucing'),
(9, 'Mainan'),
(10, 'Makanan Anjing');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order`
--

CREATE TABLE `order` (
  `oid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `price` float NOT NULL,
  `acc_number` varchar(255) DEFAULT NULL,
  `payment_method` enum('Prepaid','Postpaid') DEFAULT NULL,
  `address` varchar(250) NOT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `valid` varchar(10) NOT NULL DEFAULT 'No',
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `order`
--

INSERT INTO `order` (`oid`, `time`, `price`, `acc_number`, `payment_method`, `address`, `bank`, `valid`, `uid`) VALUES
(1, '2024-10-08 14:34:11', 20000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(2, '2024-10-08 14:46:47', 20000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(3, '2024-10-08 14:50:46', 20000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(4, '2024-10-08 14:52:59', 40000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(5, '2024-10-08 15:05:44', 20000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(6, '2024-10-08 15:16:26', 40000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(7, '2024-10-08 15:18:52', 40000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(8, '2024-10-08 15:23:10', 20000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(9, '2024-10-08 15:24:43', 20000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(10, '2024-10-08 15:26:53', 20000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(11, '2024-10-08 18:14:32', 20000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(12, '2024-10-08 19:13:54', 170000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'No', 3),
(13, '2024-10-08 19:44:37', 20000, '089374', 'Prepaid', 'Jl. Kemangi', 'BNI', 'Yes', 3),
(14, '2024-10-08 20:05:46', 170000, '0009000', 'Prepaid', 'Jl. Nagasari', 'BNI', 'No', 4),
(15, '2024-12-11 16:34:22', 50000, '085156549426', 'Prepaid', 'perumahan', 'DANA', 'Yes', 5),
(16, '2024-12-12 01:13:23', 100000, '085156549426', 'Prepaid', 'perumahan', 'DANA', 'Yes', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orderitem`
--

CREATE TABLE `orderitem` (
  `oiid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `item_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `orderitem`
--

INSERT INTO `orderitem` (`oiid`, `pid`, `oid`, `uid`, `qty`, `item_price`) VALUES
(1, 11, 1, 3, 1, 20000),
(2, 10, 2, 3, 1, 20000),
(3, 10, 3, 3, 1, 20000),
(4, 11, 4, 3, 1, 20000),
(5, 10, 4, 3, 1, 20000),
(6, 11, 5, 3, 1, 20000),
(7, 11, 6, 3, 1, 20000),
(8, 10, 6, 3, 1, 20000),
(9, 11, 7, 3, 1, 20000),
(10, 10, 7, 3, 1, 20000),
(11, 11, 8, 3, 1, 20000),
(12, 11, 9, 3, 1, 20000),
(13, 11, 10, 3, 1, 20000),
(14, 11, 11, 3, 1, 20000),
(15, 15, 12, 3, 1, 150000),
(16, 11, 12, 3, 1, 20000),
(17, 11, 13, 3, 1, 20000),
(18, 15, 14, 4, 1, 150000),
(19, 11, 14, 4, 1, 20000),
(20, 16, 15, 5, 1, 50000),
(21, 16, 16, 5, 2, 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `pid` int(11) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `imgurl` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`pid`, `productname`, `description`, `imgurl`, `price`, `category_id`) VALUES
(10, 'Scadix Spray Obat Luka 60ml', 'Scadix adalah produk obat spray pada kucing paling ampuh karena menggunakan wedang jahe', 'image/products/scadix.jpg', 20000, 4),
(11, 'Miconazole Nitrate 2%', 'Miconazole Nitrate 2% adalah obat antijamur topikal yang dirancang khusus untuk mengobati infeksi kulit pada kucing, termasuk infeksi yang disebabkan oleh jamur seperti tinea, dermatofitosis, dan infeksi kulit akibat Candida. Obat ini bekerja dengan', 'image/products/Miconazole.jpg', 20000, 5),
(15, 'Revolution Obat Kutu Kucing', 'Revolution for Cats adalah obat kutu kucing tetes yang cara kerjanya langsung menyerap ke dalam pembuluh darah kucing1. Obat ini mengandung Selamectin dan berfungsi sebagai obat pembunuh kutu, dan mencegah telur kutu dari menetas hingga berusia satu ', 'image/products/revolution.jpg', 150000, 6),
(16, 'Drontal untuk Kucing dan Anjing', 'rontal Cat Tablet adalah obat cacing spektrum luas untuk kucing yang mencegah dan mengobati infeksi cacing saluran cerna. Obat ini mengandung pyrantel embonate dan praziquantel', 'image/products/Drontal.jpg', 50000, 7),
(17, 'Felibite Mother and Kitten 500 g', 'Makanan ini memiliki kandungan omega 3 dan 6 yang baik untuk menjaga kesehatan bulu, taurine untuk kesehatan mata, dan yucca extract untuk mengurangi bau pada kotoran.', 'image/products/Felibite-Mother-and-Kitten.jpg', 29400, 8),
(18, 'Royal Canin Kitten Makanan Anak Kucing Dry 10 kg', 'Royal Canin Kitten dapat kamu berikan pada anak kucing berusia 12 bulan. Makanan ini mampu meningkatkan kinerja pencernaan karena kandungan LIP. Kandungan ini merupakan zat protein dengan tingkat daya cerna yang mencapai 90 persen.', 'image/products/Royal-Canin-Kitten-Makanan-Anak-Kucing-Dry.jpg', 1227500, 8),
(19, 'cat tree', 'Kucing punya kebiasaan mencakar. Oleh karena itu, kamu bisa menyediakan mainan pohon (cat tree) sebagai tempatnya bermain. Cat tree juga bisa melatih kucing untuk tidak mencakar di tempat yang tidak seharusnya, misalnya kasur atau sofa di rumahmu. Ma', 'image/products/Luxury.jpg', 559000, 9),
(20, 'Nature Bridge Lohas Dog ALS with Goat Milk', 'Nature Bridge Lohas Dog ALS with Goat Milk adalah salah satu produk makanan anjing terbaik yang cocok untuk anjing peliharaan dari segala tahapan usia maupun ras.\\r\\n\\r\\nSesuai dengan namanya, dry food ini mengandung daging ayam dan susu kambing yang', 'image/products/fda1cacf-nature-.jpg', 215000, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`uid`, `username`, `address`, `email`, `password`, `date_of_birth`, `gender`, `city`, `contact_no`) VALUES
(3, 'admin', 'Jl. Kemangi', 'pawpawpikpik747@gmail.com', '3a2e378df3e264ce468013b275102223', '1998-10-20', 'male', 'Bandung', '099999'),
(4, 'Koala', 'Jl. Nagasari', 'pawpawpikpik91@gmail.com', 'c4cf192ff255dddf4cc2018dc622f834', '2005-02-11', 'male', 'Yogyakarta', '05677777'),
(5, 'fihrisaldama', 'perumahan', 'fihrisaldama015@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2003-05-13', 'male', 'Surabaya', '085156549426');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`);

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cid`);

--
-- Indeks untuk tabel `cartdetail`
--
ALTER TABLE `cartdetail`
  ADD PRIMARY KEY (`cdid`),
  ADD KEY `cid` (`cid`),
  ADD KEY `pid` (`pid`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`cid`);

--
-- Indeks untuk tabel `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`oid`);

--
-- Indeks untuk tabel `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`oiid`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `cartdetail`
--
ALTER TABLE `cartdetail`
  MODIFY `cdid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `order`
--
ALTER TABLE `order`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `orderitem`
--
ALTER TABLE `orderitem`
  MODIFY `oiid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cartdetail`
--
ALTER TABLE `cartdetail`
  ADD CONSTRAINT `cartdetail_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `cart` (`cid`) ON DELETE CASCADE,
  ADD CONSTRAINT `cartdetail_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `kategori` (`cid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
