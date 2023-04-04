-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 21. Juli 2017 jam 07:36
-- Versi Server: 5.5.16
-- Versi PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nadefa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `nm_perush`
--

CREATE TABLE IF NOT EXISTS `nm_perush` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `member` varchar(100) NOT NULL,
  `nm_perush` varchar(100) NOT NULL,
  `nm_perumh` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `brosur` varchar(200) NOT NULL,
  `siteplant` varchar(100) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data untuk tabel `nm_perush`
--

INSERT INTO `nm_perush` (`no`, `member`, `nm_perush`, `nm_perumh`, `lokasi`, `logo`, `brosur`, `siteplant`) VALUES
(3, 'Nadefa', 'PT. Nadefa Mitra Lestari', 'CAHAYA PELANGI', 'Jl. Bauntung Landasan Ulin Jl. A.Yani KM.21 Banjar Baru - Landasan Ulin', 'logoNML.jpg', 'cahayapelangi.jpg', 'CahayaProperti.jpg'),
(8, '', 'PT. NADEFA MITRA LESTARI', 'GRHA PELANGI', 'Jl. Caraka Jaya km 21 Landasan Ulin - Kalimantan Selatan', 'logoNML.jpg', 'rsz_1graha_pelangi.jpg', 'siteplantgrhapelangi.jpg'),
(24, '', 'PT. Nadefa Mitra Lestari', 'PELANGI RESIDENCE', 'Jl. Pandu Rt. 03 Rw. 06 kel. Guntung paikat kec. Banjarbaru Selatan', 'logoNML.jpg', 'Brosur Pelangi Residence 24 04 2014 Baru.jpg', 'Site Plan Pelangi R_1.jpg'),
(38, '', 'PT. Nadefa Mitra Lestari', 'CEMPAKA PERMAI', 'Jl. Tembus Bumi Berkat  Rt.30 Rw. 07 kel. Sungai Ulin Kec. Banjarbaru Selatan', 'logo_NML_2-01-02_-_Copy_2_-_Copy.ico', 'cempaka permai-2.jpg', 'Cempaka Permai.jpg'),
(26, '', 'PT. Nadefa Mitra Lestari', 'BANDARA RESIDENCE', 'Jl. Sempati Rt. 44 Rw.09 Tegal Arum  Kel. Syamsudin Noor kec. Landasan Ulin ', 'logoNML.jpg', 'brosur BANDARA RESIDENCE.jpg', 'brosur pelangi grup-01.jpg'),
(25, '', 'PT. Nadefa Mitra Lestari', 'PESONA BINCAU', 'Jl. Irigasi Rt. 11 Desa Bincau kec. Martapura Kab. Banjar', 'logoNML.jpg', 'brosur pesona bincau.jpg', 'Siteplan pesona bincau.jpg'),
(35, '', 'PT. Borneo Mitra Lestari', 'GRHA CAHAYA ABADI', 'Jl. Palm Abadi 3 Kel. Guntung Manggis Kec. Landasan Ulin - Banjarbaru ', 'LOGO BML-01.jpg', 'Fliyer Graha Cahaya Abadi Depan.jpg', 'GRHA CAHAYA ABADI.jpg'),
(29, '', 'PT. Nadefa Mitra Lestari', 'GREEN HUNIAN MANARAP 2', 'Jl. Manarap, Jl. handil I Kel. Manarap Baru Kec. Kertak Hanyar', 'logoNML.jpg', 'Brosur GHM II315.jpg', 'GHM TAHAP 2 DAN 3_1.jpg'),
(30, '', 'PT. Nadefa Mitra Lestari', 'GREEN HUNIAN MANARAP 1', 'Jl. Manarap, Jl. handil 3 Kel. Manarap Baru Kec. Kertak Hanyar', 'logoNML.jpg', 'BROSUR GHM I014.jpg', 'S MANARRAP REV.1(1)_1.jpg'),
(36, '', 'PT. Nadefa Mitra Lestari', 'TELAGA PADI PERMAI', 'Jl. Ir H Adenan Basri', 'logoNML.jpg', 'Brosur Rantau-1.jpg', 'telaga padi rantau.jpg'),
(39, '', 'PT. NADEFA MITRA LESTARI', 'GREEN HUNIAN MANARAP 3', 'Jl. Handil 3 kel. Manarap Baru Kec. Kertak Hanyar', 'logoNML.jpg', 'Brosur GHM II315.jpg', 'SITEPLAN GHM III.jpg'),
(33, '', 'PT. Nadefa Mitra Lestari', 'PELANGI TRADE CENTER', 'Jl. Jurusan Pelaihari Rt. 03 Rw. 01 kel. Landasan Ulin Selatan Kec. Liang Anggang. ', 'logoNML.jpg', 'brosur pelangi - depan small.jpg', 'siteplan PTC.jpg'),
(34, '', 'PT. Nadefa Mitra Lestari', 'NYIUR HIJAU RESIDENCE', 'Jl. Kasturi II Tambak langsat Kel. Syamsudin Noor Kec. Landasan Ulin ', 'logoNML.jpg', 'BROSUR NH.jpg', 'Site Plan NH.jpg'),
(37, '', 'PT. Nadefa Mitra Lestari', 'GREEN GOLF GARDENIA', 'Jl. Golf rt. 11 Rw. 03 Kel. Syamsudin Noor Kec. Liang Anggang', 'logoNML.jpg', 'GGG.jpg', 'Siteplan Green Golf Gardenia.jpg'),
(40, '', 'PT. Nadefa Mitra Lestari', 'Sungai tiung', 'Jl. Mistar CokroKusumo Kel. Sungai Tiung Kec. Cempaka', 'logoNML.jpg', 'New Brosur Dream depan.jpg', 'SITEPLAN sungai tiung.jpg'),
(45, '', 'PT. NADEFA MITRA LESTARI', 'CAHAYA PELANGI 2', 'Jl. Bauntung Jaya Rt. 07 Rw. 01 Kel. Landasan ulin utara Kec. Liang Anggang Kota Banjarbaru', 'logoNML.jpg', 'IMG-20160913-WA0004.jpg', 'siteplan (sesuai IPPT)_1.bmp'),
(43, '', 'PT. NADEFA MITRA LESTARI', 'GREEN HUNIAN MANARAP 2 NEW', 'Jl. Manarap, Jl. handil I RT.04 Kel. Manarap Baru Kec. Kertak Hanyar', 'logoNML.jpg', 'BROSUR GHM2 rev3.jpg', 'GHM 2_1.bmp'),
(46, '', 'PT. NADEFA MITRA LESTARI', 'GREEN HUNIAN MANARAP V', 'JL. Handil 3 Kel. Manarap Baru Kec. Kertak Hanyar Kab Banjar', 'logoNML.jpg', 'Brosur GHM II315.jpg', 'GHM V.png'),
(48, '', 'PT. NADEFA MITRA LESTARI', 'GREEN KEMILAU PELANGI', 'JL. Handil Bahalang RT/RW. 007/ -', 'logoNML.jpg', 'Brosur GHM II315.jpg', 'balang bagus.png'),
(50, '', 'PT. NADEFA MITRA LESTARI', 'GREEN HUNIAN MANARAP VI', 'JL. Handil 1 RT.04 Kel. Manarap Baru Kec. Kertak Hanyar Kab. Banjar ', 'logoNML.jpg', 'Brosur GHM II315.jpg', 'GHM VI.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
