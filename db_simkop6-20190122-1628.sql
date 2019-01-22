-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 22, 2019 at 10:27 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simkop6`
--

-- --------------------------------------------------------

--
-- Table structure for table `t0101_koperasi`
--

CREATE TABLE `t0101_koperasi` (
  `id` int(11) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Alamat` varchar(100) NOT NULL DEFAULT '-',
  `NoTelpHP` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0102_marketing`
--

CREATE TABLE `t0102_marketing` (
  `id` int(11) NOT NULL,
  `Nama` varchar(25) NOT NULL,
  `Alamat` varchar(100) NOT NULL,
  `NoHP` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0201_nasabah`
--

CREATE TABLE `t0201_nasabah` (
  `id` int(11) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Alamat` text NOT NULL,
  `NoTelpHp` varchar(100) NOT NULL,
  `Pekerjaan` varchar(50) NOT NULL,
  `PekerjaanAlamat` text NOT NULL,
  `PekerjaanNoTelpHp` varchar(100) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT '0',
  `Keterangan` varchar(100) DEFAULT NULL,
  `koperasi_id` int(11) NOT NULL,
  `marketing_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0202_jaminan`
--

CREATE TABLE `t0202_jaminan` (
  `id` int(11) NOT NULL,
  `nasabah_id` int(11) NOT NULL,
  `MerkType` varchar(25) NOT NULL,
  `NoRangka` varchar(50) DEFAULT NULL,
  `NoMesin` varchar(50) DEFAULT NULL,
  `Warna` varchar(15) DEFAULT NULL,
  `NoPol` varchar(15) DEFAULT NULL,
  `Keterangan` text,
  `AtasNama` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0301_pinjaman`
--

CREATE TABLE `t0301_pinjaman` (
  `id` int(11) NOT NULL,
  `Kontrak_No` varchar(25) NOT NULL,
  `Kontrak_Tgl` date NOT NULL,
  `nasabah_id` int(11) NOT NULL,
  `jaminan_id` varchar(100) NOT NULL,
  `Pinjaman` float(14,2) NOT NULL,
  `Angsuran_Lama` tinyint(4) NOT NULL,
  `Angsuran_Bunga_Prosen` decimal(5,2) NOT NULL DEFAULT '2.25',
  `Angsuran_Denda` decimal(5,2) NOT NULL DEFAULT '0.40',
  `Dispensasi_Denda` tinyint(4) NOT NULL DEFAULT '3',
  `Angsuran_Pokok` float(14,2) NOT NULL,
  `Angsuran_Bunga` float(14,2) NOT NULL,
  `Angsuran_Total` float(14,2) NOT NULL,
  `No_Ref` varchar(25) DEFAULT NULL,
  `Biaya_Administrasi` float(14,2) NOT NULL DEFAULT '0.00',
  `Biaya_Materai` float(14,2) NOT NULL DEFAULT '0.00',
  `marketing_id` int(11) NOT NULL,
  `Periode` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0302_angsuran`
--

CREATE TABLE `t0302_angsuran` (
  `id` int(11) NOT NULL,
  `pinjaman_id` int(11) NOT NULL,
  `Angsuran_Ke` tinyint(4) NOT NULL,
  `Angsuran_Tanggal` date NOT NULL,
  `Angsuran_Pokok` float(14,2) NOT NULL,
  `Angsuran_Bunga` float(14,2) NOT NULL,
  `Angsuran_Total` float(14,2) NOT NULL,
  `Sisa_Hutang` float(14,2) NOT NULL,
  `Tanggal_Bayar` date DEFAULT NULL,
  `Terlambat` smallint(6) DEFAULT NULL,
  `Total_Denda` float(14,2) DEFAULT NULL,
  `Bayar_Titipan` float(14,2) DEFAULT NULL,
  `Bayar_Non_Titipan` float(14,2) DEFAULT NULL,
  `Bayar_Total` float(14,2) DEFAULT NULL,
  `Keterangan` text,
  `Periode` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0303_titipan`
--

CREATE TABLE `t0303_titipan` (
  `id` int(11) NOT NULL,
  `pinjaman_id` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `Keterangan` text,
  `Masuk` float(14,2) NOT NULL DEFAULT '0.00',
  `Keluar` float(14,2) NOT NULL DEFAULT '0.00',
  `Sisa` float(14,2) NOT NULL DEFAULT '0.00',
  `Angsuran_Ke` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0304_potongan`
--

CREATE TABLE `t0304_potongan` (
  `id` int(11) NOT NULL,
  `pinjaman_id` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `Keterangan` text,
  `Jumlah` float(14,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0401_periode`
--

CREATE TABLE `t0401_periode` (
  `id` int(11) NOT NULL,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `Tahun_Bulan` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0402_rekening`
--

CREATE TABLE `t0402_rekening` (
  `group` bigint(20) DEFAULT '0',
  `id` varchar(35) NOT NULL DEFAULT '',
  `rekening` varchar(90) DEFAULT '',
  `tipe` varchar(35) DEFAULT '',
  `posisi` varchar(35) DEFAULT '',
  `laporan` varchar(35) DEFAULT '',
  `status` varchar(35) DEFAULT '',
  `parent` varchar(35) DEFAULT '',
  `keterangan` tinytext,
  `active` enum('yes','no') DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t0402_rekening`
--

INSERT INTO `t0402_rekening` (`group`, `id`, `rekening`, `tipe`, `posisi`, `laporan`, `status`, `parent`, `keterangan`, `active`) VALUES
(1, '1', 'AKTIVA', 'GROUP', 'DEBET', 'NERACA', '', '', '', 'yes'),
(1, '1.1000', 'KAS', 'HEADER', 'DEBET', 'NERACA', NULL, '1', NULL, 'yes'),
(1, '1.1001', 'KAS BANK - BCA', 'DETAIL', 'DEBET', 'NERACA', 'KAS/BANK', '1.1000', NULL, 'yes'),
(1, '1.1002', 'KAS BANK - MANDIRI', 'DETAIL', 'DEBET', 'NERACA', 'KAS/BANK', '1.1000', NULL, 'yes'),
(1, '1.1003', 'KAS BANK - BCA SURABAYA', 'DETAIL', 'DEBET', 'NERACA', 'KAS/BANK', '1.1000', NULL, 'yes'),
(1, '1.1004', 'KAS BESAR', 'DETAIL', 'DEBET', 'NERACA', 'KAS/BANK', '1.1000', NULL, 'yes'),
(1, '1.1005', 'KAS KECIL HARIAN', 'DETAIL', 'DEBET', 'NERACA', 'KAS/BANK', '1.1000', NULL, 'yes'),
(1, '1.2000', 'PIUTANG', 'HEADER', 'DEBET', 'NERACA', '', '1', '', 'yes'),
(1, '1.2001', 'PIUTANG KURANG BAYAR NASABAH', 'DETAIL', 'DEBET', 'NERACA', '', '1.2000', '', 'yes'),
(1, '1.2002', 'NASABAH MACET > 12 BULAN', 'DETAIL', 'DEBET', 'NERACA', '', '1.2000', '', 'yes'),
(1, '1.2003', 'PINJAMAN BERJANGKA & ANGSURAN', 'DETAIL', 'DEBET', 'NERACA', '', '1.2000', '', 'yes'),
(1, '1.2004', 'PIUTANG SIDOARJO', 'DETAIL', 'DEBET', 'NERACA', NULL, '1.2000', NULL, 'yes'),
(1, '1.2005', 'PIUTANG KPL 5', 'DETAIL', 'DEBET', 'NERACA', '', '1.2000', '', 'yes'),
(1, '1.2006', 'PIUTANG TROSOBO', 'DETAIL', 'DEBET', 'NERACA', '', '1.2000', '', 'yes'),
(1, '1.2007', 'PIUTANG DANIEL', 'DETAIL', 'DEBET', 'NERACA', '', '1.2000', '', 'yes'),
(1, '1.2008', 'PIUTANG ANDIK', 'DETAIL', 'DEBET', 'NERACA', '', '1.2000', '', 'yes'),
(1, '1.3000', 'PERSEDIAAN KANTOR', 'DETAIL', 'DEBET', 'NERACA', NULL, '1', NULL, 'yes'),
(1, '1.4000', 'AKUMULASI PENYUSUTAN', 'DETAIL', 'DEBET', 'NERACA', '', '1', '', 'yes'),
(2, '2', 'PASSIVA', 'GROUP', 'CREDIT', 'NERACA', '', '', '', 'yes'),
(2, '2.1000', 'HUTANG PAJAJARAN', 'DETAIL', 'CREDIT', 'NERACA', NULL, '2', NULL, 'yes'),
(2, '2.2000', 'HUTANG DANIEL', 'DETAIL', 'CREDIT', 'NERACA', '', '2', '', 'yes'),
(2, '2.3000', 'TITIPAN NASABAH', 'DETAIL', 'CREDIT', 'NERACA', '', '2', '', 'yes'),
(2, '2.4000', 'MODAL DISETOR', 'DETAIL', 'CREDIT', 'NERACA', '', '2', '', 'yes'),
(2, '2.5000', 'SHU TAHUN LALU', 'DETAIL', 'CREDIT', 'NERACA', '', '2', '', 'yes'),
(2, '2.6000', 'SHU TAHUN', 'DETAIL', 'CREDIT', 'NERACA', '', '2', '', 'yes'),
(2, '2.7000', 'PEMBAGIAN SHU TAHUN', 'DETAIL', 'CREDIT', 'NERACA', '', '2', '', 'yes'),
(2, '2.8000', 'SHU TAHUN BERJALAN', 'DETAIL', 'CREDIT', 'NERACA', '', '2', '', 'yes'),
(2, '2.9000', 'SHU BULAN BERJALAN', 'DETAIL', 'CREDIT', 'NERACA', '', '2', '', 'yes'),
(3, '3', 'PENDAPATAN', 'GROUP', 'CREDIT', 'RUGI LABA', '', '', '', 'yes'),
(3, '3.1000', 'PENDAPATAN BUNGA PINJAMAN', 'DETAIL', 'CREDIT', 'RUGI LABA', '', '3', '', 'yes'),
(4, '4', 'BIAYA', 'GROUP', 'DEBET', 'RUGI LABA', '', '', '', 'yes'),
(4, '4.1000', 'BIAYA KARYAWAN', 'DETAIL', 'DEBET', 'RUGI LABA', '', '4', '', 'yes'),
(4, '4.2000', 'BIAYA PERKANTORAN & UMUM', 'DETAIL', 'DEBET', 'RUGI LABA', '', '4', '', 'yes'),
(4, '4.3000', 'BIAYA KOMISI MAKELAR / FEE', 'DETAIL', 'DEBET', 'RUGI LABA', '', '4', '', 'yes'),
(4, '4.4000', 'BIAYA ADMINISTRASI BANK', 'DETAIL', 'DEBET', 'RUGI LABA', '', '4', '', 'yes'),
(4, '4.5000', 'BIAYA PENYUSUTAN', 'DETAIL', 'DEBET', 'RUGI LABA', '', '4', '', 'yes'),
(4, '4.6000', 'BIAYA IKLAN', 'DETAIL', 'DEBET', 'RUGI LABA', '', '4', '', 'yes'),
(4, '4.7000', 'POTONGAN', 'DETAIL', 'DEBET', 'RUGI LABA', '', '4', '', 'yes'),
(5, '5', 'PENDAPATAN LAIN', 'GROUP', 'CREDIT', 'RUGI LABA', '', '', '', 'yes'),
(5, '5.1000', 'PENDAPATAN ADMINISTRASI PINJAMAN', 'DETAIL', 'CREDIT', 'RUGI LABA', '', '5', '', 'yes'),
(5, '5.2000', 'PENDAPATAN BUNGA BANK', 'DETAIL', 'CREDIT', 'RUGI LABA', '', '5', '', 'yes'),
(5, '5.3000', 'PENDAPATAN DENDA', 'DETAIL', 'CREDIT', 'RUGI LABA', '', '5', '', 'yes'),
(6, '6', 'BIAYA LAIN', 'GROUP', 'DEBET', 'RUGI LABA', '', '', '', 'yes'),
(6, '6.1000', 'BIAYA LAIN-LAIN', 'DETAIL', 'DEBET', 'RUGI LABA', '', '6', '', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `t0403_rektran`
--

CREATE TABLE `t0403_rektran` (
  `id` int(11) NOT NULL,
  `KodeTransaksi` varchar(35) NOT NULL,
  `NamaTransaksi` varchar(100) NOT NULL,
  `KodeRekening` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t0403_rektran`
--

INSERT INTO `t0403_rektran` (`id`, `KodeTransaksi`, `NamaTransaksi`, `KodeRekening`) VALUES
(1, '01', 'Pembayaran Angsuran', '1.2003'),
(2, '02', 'Pendapatan Bunga', '3.1000'),
(3, '03', 'Pendapatan Denda', '5.3000'),
(4, '04', 'Titipan Keluar', '2.3000'),
(5, '05', 'Titipan Masuk', '2.3000'),
(6, '06', 'Pendapatan Administrasi', '5.1000'),
(7, '07', 'Pendapatan Asuransi', '5.1000'),
(8, '08', 'Pendapatan Notaris', '5.1000'),
(9, '09', 'Pendapatan Materai', '5.1000'),
(10, '10', 'Pinjaman Angsuran & Berjangka', '1.2003'),
(11, '11', 'SHU Bulan Berjalan', '2.9000'),
(12, '12', 'SHU Tahun Berjalan', '2.8000'),
(13, '00', 'Kas', '1.1001');

-- --------------------------------------------------------

--
-- Table structure for table `t0404_jurnal`
--

CREATE TABLE `t0404_jurnal` (
  `id` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `Periode` varchar(6) NOT NULL,
  `NomorTransaksi` varchar(25) NOT NULL,
  `Rekening` varchar(35) NOT NULL,
  `Debet` float(14,2) NOT NULL,
  `Kredit` float(14,2) NOT NULL,
  `Keterangan` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0405_neraca`
--

CREATE TABLE `t0405_neraca` (
  `field01` varchar(35) DEFAULT NULL,
  `field02` varchar(90) DEFAULT NULL,
  `field03` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t0406_labarugi`
--

CREATE TABLE `t0406_labarugi` (
  `field01` varchar(35) DEFAULT NULL,
  `field02` varchar(90) DEFAULT NULL,
  `field03` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t9901_employees`
--

CREATE TABLE `t9901_employees` (
  `EmployeeID` int(11) NOT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `FirstName` varchar(10) DEFAULT NULL,
  `Title` varchar(30) DEFAULT NULL,
  `TitleOfCourtesy` varchar(25) DEFAULT NULL,
  `BirthDate` datetime DEFAULT NULL,
  `HireDate` datetime DEFAULT NULL,
  `Address` varchar(60) DEFAULT NULL,
  `City` varchar(15) DEFAULT NULL,
  `Region` varchar(15) DEFAULT NULL,
  `PostalCode` varchar(10) DEFAULT NULL,
  `Country` varchar(15) DEFAULT NULL,
  `HomePhone` varchar(24) DEFAULT NULL,
  `Extension` varchar(4) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Notes` longtext,
  `ReportsTo` int(11) DEFAULT NULL,
  `Password` varchar(50) NOT NULL DEFAULT '',
  `UserLevel` int(11) DEFAULT NULL,
  `Username` varchar(20) NOT NULL DEFAULT '',
  `Activated` enum('Y','N') NOT NULL DEFAULT 'N',
  `Profile` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t9901_employees`
--

INSERT INTO `t9901_employees` (`EmployeeID`, `LastName`, `FirstName`, `Title`, `TitleOfCourtesy`, `BirthDate`, `HireDate`, `Address`, `City`, `Region`, `PostalCode`, `Country`, `HomePhone`, `Extension`, `Email`, `Photo`, `Notes`, `ReportsTo`, `Password`, `UserLevel`, `Username`, `Activated`, `Profile`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', -1, 'admin', 'N', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t9902_userlevels`
--

CREATE TABLE `t9902_userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t9902_userlevels`
--

INSERT INTO `t9902_userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `t9903_userlevelpermissions`
--

CREATE TABLE `t9903_userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t9903_userlevelpermissions`
--

INSERT INTO `t9903_userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}cf01_home.php', 8),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t01_nasabah', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t02_jaminan', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t03_pinjaman', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t04_pinjamanangsuran', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t05_pinjamanjaminan', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t06_pinjamantitipan', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t94_log', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t95_logdesc', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t96_employees', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t97_userlevels', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t98_userlevelpermissions', 0),
(-2, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t99_audittrail', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}cf01_home.php', 8),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0101_koperasi', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0102_marketing', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0201_nasabah', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0202_jaminan', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0301_pinjaman', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0302_angsuran', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0303_titipan', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0304_potongan', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0401_periode', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0402_rekening', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0403_rektran', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0404_jurnal', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0405_neraca', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0406_labarugi', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9901_employees', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9902_userlevels', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9903_userlevelpermissions', 0),
(-2, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9904_audittrail', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}cf01_home.php', 8),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}cf02_tutupbuku.php', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t01_nasabah', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t02_jaminan', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t03_pinjaman', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t04_pinjamanangsuran', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t04_pinjamanangsurantemp', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t05_pinjamanjaminan', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t06_pinjamantitipan', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t07_marketing', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t08_pinjamanpotongan', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t92_periodeold', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t93_periode', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t94_log', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t95_logdesc', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t96_employees', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t97_userlevels', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t98_userlevelpermissions', 0),
(-2, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t99_audittrail', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0101_koperasi', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0102_marketing', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0201_nasabah', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0202_jaminan', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0301_pinjaman', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0302_angsuran', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0303_titipan', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0304_potongan', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0401_periode', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0402_rekening', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0403_rektran', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0404_jurnal', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0405_neraca', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t0406_labarugi', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t9901_employees', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t9902_userlevels', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t9903_userlevelpermissions', 0),
(-2, '{eaf50425-cc33-46cf-b663-218852e2416e}t9904_audittrail', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}cf01_home.php', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t01_nasabah', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t02_jaminan', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t03_pinjaman', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t04_pinjamanangsuran', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t05_pinjamanjaminan', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t06_pinjamantitipan', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t94_log', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t95_logdesc', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t96_employees', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t97_userlevels', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t98_userlevelpermissions', 0),
(0, '{1F4EE816-E057-4A7E-9024-5EA4446B7598}t99_audittrail', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}cf01_home.php', 8),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0101_koperasi', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0102_marketing', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0201_nasabah', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0202_jaminan', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0301_pinjaman', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0302_angsuran', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0303_titipan', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0304_potongan', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0401_periode', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0402_rekening', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0403_rektran', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0404_jurnal', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0405_neraca', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0406_labarugi', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9901_employees', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9902_userlevels', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9903_userlevelpermissions', 0),
(0, '{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9904_audittrail', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}cf01_home.php', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}cf02_tutupbuku.php', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t01_nasabah', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t02_jaminan', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t03_pinjaman', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t04_pinjamanangsuran', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t04_pinjamanangsurantemp', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t05_pinjamanjaminan', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t06_pinjamantitipan', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t07_marketing', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t08_pinjamanpotongan', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t92_periodeold', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t93_periode', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t94_log', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t95_logdesc', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t96_employees', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t97_userlevels', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t98_userlevelpermissions', 0),
(0, '{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}t99_audittrail', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0101_koperasi', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0102_marketing', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0201_nasabah', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0202_jaminan', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0301_pinjaman', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0302_angsuran', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0303_titipan', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0304_potongan', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0401_periode', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0402_rekening', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0403_rektran', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0404_jurnal', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0405_neraca', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t0406_labarugi', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t9901_employees', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t9902_userlevels', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t9903_userlevelpermissions', 0),
(0, '{eaf50425-cc33-46cf-b663-218852e2416e}t9904_audittrail', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t9904_audittrail`
--

CREATE TABLE `t9904_audittrail` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t9904_audittrail`
--

INSERT INTO `t9904_audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1, '2019-01-22 09:35:27', '/simkop6/login.php', 'admin', 'login', '::1', '', '', '', ''),
(2, '2019-01-22 09:36:37', '/simkop6/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(3, '2019-01-22 09:37:02', '/simkop6/login.php', 'admin', 'login', '::1', '', '', '', ''),
(4, '2019-01-22 15:45:11', '/simkop6/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(5, '2019-01-22 15:45:41', '/simkop6/login.php', 'admin', 'login', '::1', '', '', '', ''),
(6, '2019-01-22 15:56:28', '/simkop6/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(7, '2019-01-22 15:57:05', '/simkop6/login.php', 'admin', 'login', '::1', '', '', '', ''),
(8, '2019-01-22 15:57:22', '/simkop6/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(9, '2019-01-22 16:01:52', '/simkop6/login.php', 'admin', 'login', '::1', '', '', '', ''),
(10, '2019-01-22 16:02:05', '/simkop6/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(11, '2019-01-22 16:02:21', '/simkop6/login.php', 'admin', 'login', '::1', '', '', '', ''),
(12, '2019-01-22 16:02:31', '/simkop6/logout.php', 'admin', 'logout', '::1', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t0101_koperasi`
--
ALTER TABLE `t0101_koperasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0102_marketing`
--
ALTER TABLE `t0102_marketing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0201_nasabah`
--
ALTER TABLE `t0201_nasabah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0202_jaminan`
--
ALTER TABLE `t0202_jaminan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0301_pinjaman`
--
ALTER TABLE `t0301_pinjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0302_angsuran`
--
ALTER TABLE `t0302_angsuran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0303_titipan`
--
ALTER TABLE `t0303_titipan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0304_potongan`
--
ALTER TABLE `t0304_potongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0401_periode`
--
ALTER TABLE `t0401_periode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0402_rekening`
--
ALTER TABLE `t0402_rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0403_rektran`
--
ALTER TABLE `t0403_rektran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t0404_jurnal`
--
ALTER TABLE `t0404_jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t9901_employees`
--
ALTER TABLE `t9901_employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `t9902_userlevels`
--
ALTER TABLE `t9902_userlevels`
  ADD PRIMARY KEY (`userlevelid`);

--
-- Indexes for table `t9903_userlevelpermissions`
--
ALTER TABLE `t9903_userlevelpermissions`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- Indexes for table `t9904_audittrail`
--
ALTER TABLE `t9904_audittrail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t0101_koperasi`
--
ALTER TABLE `t0101_koperasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t0102_marketing`
--
ALTER TABLE `t0102_marketing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t0201_nasabah`
--
ALTER TABLE `t0201_nasabah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t0202_jaminan`
--
ALTER TABLE `t0202_jaminan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t0301_pinjaman`
--
ALTER TABLE `t0301_pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t0302_angsuran`
--
ALTER TABLE `t0302_angsuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t0303_titipan`
--
ALTER TABLE `t0303_titipan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t0304_potongan`
--
ALTER TABLE `t0304_potongan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t0401_periode`
--
ALTER TABLE `t0401_periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t0403_rektran`
--
ALTER TABLE `t0403_rektran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `t0404_jurnal`
--
ALTER TABLE `t0404_jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t9901_employees`
--
ALTER TABLE `t9901_employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t9904_audittrail`
--
ALTER TABLE `t9904_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
