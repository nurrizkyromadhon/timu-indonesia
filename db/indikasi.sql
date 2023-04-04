-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 22. Juli 2017 jam 02:23
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
-- Struktur dari tabel `indikasi`
--

CREATE TABLE IF NOT EXISTS `indikasi` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `indikasi` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data untuk tabel `indikasi`
--

INSERT INTO `indikasi` (`no`, `indikasi`, `gambar`) VALUES
(1, 'Rumah Terjual', 'jual.png'),
(2, 'Pengurusan Bank', 'legalitas.png'),
(3, 'Serah Terima', 'serahterima.png'),
(5, 'Spek Blok Kavling', 'data.png'),
(6, 'Akad', 'akad.png'),
(7, 'Rumah Siap Jual', 'rumahsiapjual.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
