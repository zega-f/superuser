-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 09, 2021 at 05:49 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bimbel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 2,
  `role_access` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_id`, `name`, `email`, `password`, `level`, `role_access`, `status`, `created_at`) VALUES
(1, 'SGWZyo', 'Zega', 'xegalol@gmail.com', '$2y$10$w4lCScSNYnH69HSPS290lerYRuzT6ifApbLUJZCa4huFrVAsWvZlC', 1, '', 1, '2021-02-20 06:29:51'),
(2, 'itTaLlwM', 'zega', 'admin1@email.com', '$2y$10$vyB7RKmpULiutba0CoBm8.KTeoUrD/pDMQHV92lUmA8dswYwJc4G2', 2, '[\"r_p\",\"k_p\",\"k_p\",\"k_p\",\"b_s\",\"b_a\"]', 1, '2021-05-10 09:32:27'),
(6, 'neIZ1h', 'adminTam99', 'admin@email.com', '$2y$10$voQtXB4hfLYy5L879WT/y.FDorsXr12F.LJZZqULKe.WYEt8wvAYa', 1, NULL, 1, '2021-08-09 06:33:14');

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `id_artikel` varchar(20) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `intro` text NOT NULL,
  `kategori` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `sorotan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `id_artikel`, `judul`, `intro`, `kategori`, `status`, `sorotan`, `created_at`) VALUES
(9, 'qYTLrK72', 'HADAPI TRANSFORMASI DIGITAL', '', 5, 0, 1, '2021-11-17 23:50:59'),
(11, 'hDcVjEUR', 'BELAJAR JARAK JAUH TETAP MENYENANGKAN', '', 4, 0, 0, '2021-11-17 09:39:00'),
(12, 'FK1QN2jQ', 'ini coba coba', 'ini coba coba broo', 1, 0, 1, '2021-11-17 09:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `atur_jam`
--

CREATE TABLE `atur_jam` (
  `id` int(11) NOT NULL,
  `nama` int(11) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `atur_jam`
--

INSERT INTO `atur_jam` (`id`, `nama`, `start`, `end`, `update`) VALUES
(1, 1, '13:00:00', '13:45:00', '2021-12-02 07:14:50'),
(2, 2, '13:45:00', '14:30:00', '2021-12-02 07:14:50'),
(3, 3, '14:30:00', '15:15:00', '2021-12-02 07:14:50'),
(4, 4, '15:15:00', '16:00:00', '2021-12-02 07:14:50'),
(5, 5, '16:00:00', '16:45:00', '2021-12-02 07:14:50'),
(6, 6, '16:45:00', '17:30:00', '2021-12-02 07:14:50'),
(7, 7, '17:30:00', '18:15:00', '2021-12-02 07:14:50'),
(8, 8, '18:15:00', '19:00:00', '2021-12-02 07:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `a_jam`
--

CREATE TABLE `a_jam` (
  `id` int(11) NOT NULL,
  `start` time NOT NULL,
  `durasi` int(11) NOT NULL,
  `jam` int(11) NOT NULL,
  `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `a_jam`
--

INSERT INTO `a_jam` (`id`, `start`, `durasi`, `jam`, `update`) VALUES
(1, '13:00:00', 45, 8, '2021-12-02 07:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `bab`
--

CREATE TABLE `bab` (
  `id` int(11) NOT NULL,
  `id_bab` int(11) NOT NULL,
  `bab_name` varchar(255) NOT NULL,
  `urutan` int(11) DEFAULT NULL,
  `room_id` varchar(55) NOT NULL,
  `mapel` int(11) DEFAULT NULL,
  `type` enum('kelas','kursus') NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bab`
--

INSERT INTO `bab` (`id`, `id_bab`, `bab_name`, `urutan`, `room_id`, `mapel`, `type`, `status`, `created_at`) VALUES
(1, 1, 'Kursus Pengenalan', NULL, 'Hb1TGu', NULL, 'kursus', 1, '2021-10-20 06:43:10'),
(2, 2, 'Bab 1', NULL, '9', 1, 'kelas', 1, '2021-10-28 05:20:34'),
(4, 3, 'Pendahuluan', NULL, '9', 2, 'kelas', 1, '2021-11-01 06:23:30'),
(5, 5, 'coba', NULL, '9', 4, 'kelas', 1, '2021-11-13 06:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'info',
  `footer_alamat` varchar(100) DEFAULT NULL,
  `footer_whatsapp` int(15) DEFAULT NULL,
  `footer_email` varchar(50) DEFAULT NULL,
  `footer_youtube` varchar(50) DEFAULT NULL,
  `footer_website` varchar(50) DEFAULT NULL,
  `rekening` varchar(30) DEFAULT NULL,
  `an` varchar(55) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `logo`, `name`, `type`, `footer_alamat`, `footer_whatsapp`, `footer_email`, `footer_youtube`, `footer_website`, `rekening`, `an`, `deskripsi`, `link`) VALUES
(1, '20210915054507.png', 'Astar Bimbel', 'info', 'JL. Warujayeng - Kediri, RT. 18/RW 08, Bancar, Singkalanyar, Kec. Prambon, Kabupaten Nganjuk, Jawa T', 2147483647, 'admin@jayabayabimbel.co.id', 'youtube.com/jayabayabimbel', 'jayabayabimbel.co.id', '1234567890', 'Astar', '<p>Bimbingan belajar Jayabaya atau yang dikenal dengan Jayabaya Bimbel berdiri sejak tahun 1999. Menyediakan jasa bimbingan belajar yang mampu memenuhi kebutuhan belajar dan terus berkembang menyesuaikan alur pendidikan di Indonesia.</p>', ''),
(2, 'test.jpg', 'Bahasa Inggris', 'progam', '', 0, '', '', '', '', '', 'bala bla bla bla bla', '1234567'),
(3, '20210916054021.jpg', 'Kursus1', 'progam', NULL, NULL, NULL, NULL, NULL, NULL, '', 'BBABABAB', 'BBBBB'),
(6, '20210916081707.jpg', 'promo 10', 'promosi', NULL, NULL, NULL, NULL, NULL, NULL, '', 'blablablabla', 'https://hhhhhh.com'),
(7, '20210916081904.jpg', 'Promo 2', 'promosi', NULL, NULL, NULL, NULL, NULL, NULL, '', 'blblalalla', 'https://hhhhhh.com'),
(8, '20210916081943.jpg', 'promosi 3', 'promosi', NULL, NULL, NULL, NULL, NULL, NULL, '', 'ggggggggg', 'https://hhhhhh.com'),
(9, '20211117042228.jpg', 'Kursus', 'progam', NULL, NULL, NULL, NULL, NULL, NULL, '', 'kursus', 'https://');

-- --------------------------------------------------------

--
-- Table structure for table `coba`
--

CREATE TABLE `coba` (
  `id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coba`
--

INSERT INTO `coba` (`id`, `image`, `title`, `content`) VALUES
(2, 'kWBwug7yHQRBkmdNwptCJVfTy2EflnkvnxpQqYmm.jpg', 'asdf', '<p>asdfghjkl</p>'),
(3, 'i0wT2IpGM8TNwgPmPhQHGjtbfmyaD8iUBBLuE0T0.jpg', 'asdf', '<p>vvvvvvv</p>'),
(4, 'b1AFMeVHAQFrgiG5VrF3JNV78A9v3QSOn8cq6NVS.jpg', 'Judul Kedua', '<p>vvvvvvvvvv</p>'),
(5, 'H5VniIT7J7ETYJUc5Gy53w13VpBhK8OJo9X2iKpb.jpg', 'asdf', '<p>vvvvvvvvvvvv</p>'),
(6, '20210914012401.jpg', 'Klik Tumbas', '<p>bbbbb</p>'),
(7, '20210914012435.jpg', 'Judul Kedua', '<p>ggg</p>');

-- --------------------------------------------------------

--
-- Table structure for table `coba_materi`
--

CREATE TABLE `coba_materi` (
  `id` int(11) NOT NULL,
  `id_materi` varchar(55) NOT NULL,
  `id_kelas` varchar(11) NOT NULL,
  `mapel` int(11) DEFAULT NULL,
  `judul` text DEFAULT NULL,
  `video` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_history` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coba_materi`
--

INSERT INTO `coba_materi` (`id`, `id_materi`, `id_kelas`, `mapel`, `judul`, `video`, `created_at`, `update_history`) VALUES
(1, 'GJ1povMh', '9', 1, 'Materi 1', 'Ahg6qcgoay4', '2021-10-28 05:57:38', NULL),
(6, '3j2FfXz4', 'Hb1TGu', NULL, 'Belajar Algoritma khusus', 'Iem5xcwuz6s', '2021-11-23 09:10:49', NULL),
(22, 'pd85r0r5', '9', 2, 'Belajar Algoritma khusus', 'Iem5xcwuz6s', '2021-12-04 05:15:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coba_materi_history`
--

CREATE TABLE `coba_materi_history` (
  `id` int(11) NOT NULL,
  `materi_id` varchar(255) NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coba_materi_history`
--

INSERT INTO `coba_materi_history` (`id`, `materi_id`, `updated_by`, `updated_at`) VALUES
(1, 'AR6zEUTf', 'user', '2021-11-05 05:30:53'),
(2, 'AR6zEUTf', 'user', '2021-11-05 05:32:32'),
(3, 'kVprqqwq', 'user', '2021-11-05 05:42:12'),
(4, 'kVprqqwq', 'user', '2021-11-05 05:45:14'),
(5, 'AR6zEUTf', 'user', '2021-11-15 06:39:51'),
(6, 'AR6zEUTf', 'user', '2021-11-15 06:40:55'),
(7, 'E1dJrCPk', 'user', '2021-11-15 07:56:29'),
(8, '3j2FfXz4', 'user', '2021-11-23 09:14:10'),
(9, '3j2FfXz4', 'user', '2021-11-23 09:15:13'),
(10, '3j2FfXz4', 'user', '2021-11-23 09:17:14'),
(11, '3j2FfXz4', 'user', '2021-11-23 09:18:47'),
(12, '3j2FfXz4', 'user', '2021-11-23 09:21:21'),
(13, '3j2FfXz4', 'user', '2021-11-23 09:24:54'),
(14, 'AR6zEUTf', 'user', '2021-11-23 09:26:28'),
(15, 'Vd14glhH', 'user', '2021-11-29 07:55:45'),
(16, '3j2FfXz4', 'user', '2021-11-29 07:56:13'),
(17, '3j2FfXz4', 'user', '2021-11-29 07:57:01'),
(18, '3j2FfXz4', 'user', '2021-11-29 08:00:02'),
(19, 'AR6zEUTf', 'user', '2021-11-29 08:02:13'),
(20, '3j2FfXz4', 'user', '2021-11-29 08:02:47'),
(21, '3j2FfXz4', 'user', '2021-11-29 08:05:25'),
(22, '3j2FfXz4', 'user', '2021-11-29 08:17:58'),
(23, 'AR6zEUTf', 'user', '2021-11-29 08:18:30'),
(24, 'AR6zEUTf', 'user', '2021-12-01 08:52:57'),
(25, 'AR6zEUTf', 'user', '2021-12-01 08:53:13'),
(26, 'AR6zEUTf', 'user', '2021-12-03 09:02:29'),
(27, 'AR6zEUTf', 'user', '2021-12-04 06:06:38');

-- --------------------------------------------------------

--
-- Table structure for table `coba_materi_lampiran`
--

CREATE TABLE `coba_materi_lampiran` (
  `id` int(11) NOT NULL,
  `materi_id` varchar(55) NOT NULL,
  `attachment_name` text NOT NULL,
  `attachment_original_name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coba_materi_lampiran`
--

INSERT INTO `coba_materi_lampiran` (`id`, `materi_id`, `attachment_name`, `attachment_original_name`, `created_at`) VALUES
(1, 'pd85r0r5', 'nnr6YOux2DfOuncq4jm0ALOk97hG7AJwpass.txt', 'pass.txt', '2021-12-04 05:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `coba_quiz_question`
--

CREATE TABLE `coba_quiz_question` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `coba_tugas`
--

CREATE TABLE `coba_tugas` (
  `id` int(11) NOT NULL,
  `id_tugas` varchar(55) NOT NULL,
  `judul` text NOT NULL,
  `id_kelas` varchar(55) NOT NULL,
  `mapel` int(11) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coba_tugas`
--

INSERT INTO `coba_tugas` (`id`, `id_tugas`, `judul`, `id_kelas`, `mapel`, `waktu`, `created_at`) VALUES
(12, '61icTZ7T', 'cobalah', 'Hb1TGu', NULL, '2021-12-22 22:25:00', '2021-12-03 09:19:31'),
(13, 'F1CR2lEJ', 'cobalah', '9', 2, '2021-12-30 22:27:00', '2021-12-03 09:22:00'),
(15, 'kt36KCXj', 'mencoba ini', '9', 2, '2021-12-11 18:29:00', '2021-12-04 06:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `coba_tugas_lampiran`
--

CREATE TABLE `coba_tugas_lampiran` (
  `id` int(11) NOT NULL,
  `tugas_id` varchar(55) NOT NULL,
  `attachment_name` text NOT NULL,
  `attachment_original_name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coba_tugas_lampiran`
--

INSERT INTO `coba_tugas_lampiran` (`id`, `tugas_id`, `attachment_name`, `attachment_original_name`, `created_at`) VALUES
(1, 'kt36KCXj', 'BaMj6gqkZBfOkxw0DK6FOBI0T4LdqHdBpass.txt', 'pass.txt', '2021-12-04 06:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `konten_id` varchar(55) NOT NULL,
  `user_id` varchar(55) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 2,
  `body` text DEFAULT NULL,
  `attachmentOriginalName` text DEFAULT NULL,
  `attachmentName` text DEFAULT NULL,
  `attachment_ext` varchar(55) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `konten_id`, `user_id`, `user_type`, `body`, `attachmentOriginalName`, `attachmentName`, `attachment_ext`, `date`, `time`) VALUES
(4, 'gSbfW2qj', 'ZPmNU34HMGmFKVka', 2, 'test', NULL, NULL, NULL, '2021-09-02', '15:50:24'),
(6, 'gSbfW2qj', 'ZovrKpzeljwa5Z6j', 2, 'm', NULL, NULL, NULL, '2021-09-02', '15:50:24'),
(7, 'gSbfW2qj', 'ZPmNU34HMGmFKVka', 2, 'k', NULL, NULL, NULL, '2021-09-02', '15:50:24'),
(8, 'gSbfW2qj', 'ZovrKpzeljwa5Z6j', 2, 'I have a div which I have attached an onclick event to. in this div there is a tag with a link. When I click the link the onclick event from the div is also triggered. How can i disable this so that if the link is clicked on the div onclick is not fired?', NULL, NULL, NULL, '2021-09-02', '15:50:24'),
(9, 'gSbfW2qj', 'ZPmNU34HMGmFKVka', 2, 'coba', NULL, NULL, NULL, '2021-09-02', '15:59:13'),
(10, 'gSbfW2qj', 'ZovrKpzeljwa5Z6j', 2, 'lll', NULL, NULL, NULL, '2021-09-02', '16:00:11'),
(11, 'gSbfW2qj', 'ZPmNU34HMGmFKVka', 2, 'I believe I have found a solution to this, the key is the DATE() function in mysql, which converts a DateTime into just Date:', NULL, NULL, NULL, '2021-09-02', '16:21:28'),
(15, 'gSbfW2qj', 'ZovrKpzeljwa5Z6j', 2, 'testing 1', NULL, NULL, NULL, '2021-09-03', '13:00:32'),
(18, 'gSbfW2qj', 'ZovrKpzeljwa5Z6j', 2, '<script>alert(\'surprise!\');</script>', NULL, NULL, NULL, '2021-09-03', '14:38:17'),
(22, '61', 'ZPmNU34HMGmFKVka', 2, 'p', NULL, NULL, NULL, '2021-09-03', '15:01:03'),
(23, '61', 'ZPmNU34HMGmFKVka', 2, 'halo guys', NULL, NULL, NULL, '2021-09-03', '15:01:10'),
(31, '63', 'ZovrKpzeljwa5Z6j', 2, 'a', NULL, NULL, NULL, '2021-09-03', '17:03:41'),
(32, '63', 'ZovrKpzeljwa5Z6j', 2, 'ini adalah hasil saya', 'zega febrianto - hasil.pdf', 'Dcw1Bx7xQdHm5HaiOZALrh3L5Ibi7pUbzega febrianto - hasil.pdf', 'pdf', '2021-09-03', '17:04:01'),
(34, '61', 'ZPmNU34HMGmFKVka', 2, 'hey', NULL, NULL, NULL, '2021-09-04', '13:23:47'),
(35, '61', 'ZPmNU34HMGmFKVka', 2, 'jude', NULL, NULL, NULL, '2021-09-04', '13:24:32'),
(36, '61', 'ZovrKpzeljwa5Z6j', 2, 'sa', NULL, NULL, NULL, '2021-09-04', '13:24:45'),
(43, '61', 'ZovrKpzeljwa5Z6j', 2, 'Place one add-on or button on either side of an input. You may also place one on both sides of an input. We do not support multiple form-controls in a single input group and <label>s must come outside the input group.', NULL, NULL, NULL, '2021-09-04', '16:44:45'),
(44, '61', 'ZPmNU34HMGmFKVka', 2, 'Hello', NULL, NULL, NULL, '2021-09-04', '16:48:43'),
(45, '66', 'ZPmNU34HMGmFKVka', 2, NULL, 'IMG-20210902-WA0030.jpg', 'CctN5YQO9ujT4XCapOPmDZZE1FtfupwFIMG-20210902-WA0030.jpg', 'jpg', '2021-09-04', '16:49:26'),
(46, '66', 'ZPmNU34HMGmFKVka', 2, 'P', 'FB_IMG_16304121330345305.jpg', 'mzAarBxsJ98eWZxM2vwY1GF29Qd9UPxnFB_IMG_16304121330345305.jpg', 'jpg', '2021-09-04', '16:50:34'),
(54, 'gSbfW2qj', 'ZovrKpzeljwa5Z6j', 2, 'test', NULL, NULL, NULL, '2021-09-06', '11:42:46'),
(55, '61', 'ulZI5INb', 1, 'halo', NULL, NULL, NULL, '2021-09-06', '12:49:23'),
(61, 'NiubIcx4', 'ulZI5INb', 1, 'e learning?', NULL, NULL, NULL, '2021-09-06', '13:21:24'),
(62, '111', 'ulZI5INb', 1, 'p', NULL, NULL, NULL, '2021-09-06', '13:22:36'),
(89, 'gSbfW2qj', 'ulZI5INb', 1, 'a', NULL, NULL, NULL, '2021-09-06', '15:29:46'),
(90, 'gSbfW2qj', 'ulZI5INb', 1, 'Test', NULL, NULL, NULL, '2021-09-06', '16:48:59'),
(91, 'gSbfW2qj', 'ZovrKpzeljwa5Z6j', 2, 'hallo', NULL, NULL, NULL, '2021-09-06', '16:49:08'),
(100, '61', 'ulZI5INb', 2, NULL, 'IMG-20210904-WA0019.jpg', '1un7kcTCR7Ud9Nmw7hvWYuJIFxdo10N7IMG-20210904-WA0019.jpg', 'jpg', '2021-09-06', '16:56:30'),
(102, '101', 'ZPmNU34HMGmFKVka', 2, 'p', NULL, NULL, NULL, '2021-09-09', '13:51:12'),
(103, 'qbw2N9', 'Lkt4RvJtmwHk0I4P', 2, 'p', NULL, NULL, NULL, '2021-09-09', '14:36:02'),
(104, '1_qbw2N9', 'ZPmNU34HMGmFKVka', 2, 'a', NULL, NULL, NULL, '2021-09-09', '14:42:29'),
(105, '2_qbw2N9', 'ZPmNU34HMGmFKVka', 2, 'c', NULL, NULL, NULL, '2021-09-09', '14:42:40'),
(106, 'qbw2N9_1_10', 'ZPmNU34HMGmFKVka', 2, 'a', NULL, NULL, NULL, '2021-09-09', '14:58:57'),
(107, 'nCHe25a4', 'Lkt4RvJtmwHk0I4P', 2, 'a', NULL, NULL, NULL, '2021-09-09', '15:04:45'),
(108, 'nCHe25a4', 'ZPmNU34HMGmFKVka', 2, 'b', NULL, NULL, NULL, '2021-09-09', '15:05:08'),
(109, 'nCHe25a4', 'ZPmNU34HMGmFKVka', 2, 'a', NULL, NULL, NULL, '2021-09-09', '15:07:13'),
(110, 'nCHe25a4', 'ZPmNU34HMGmFKVka', 2, 'c', NULL, NULL, NULL, '2021-09-09', '15:07:19'),
(111, 'nCHe25a4_qbw2N9', 'ZPmNU34HMGmFKVka', 2, 'a', NULL, NULL, NULL, '2021-09-09', '15:07:48'),
(112, 'nCHe25a4_qbw2N9', 'Lkt4RvJtmwHk0I4P', 2, 'b', NULL, NULL, NULL, '2021-09-09', '15:07:54'),
(113, 'qbw2N9_1_10', 'Lkt4RvJtmwHk0I4P', 2, 'stream kelas', NULL, NULL, NULL, '2021-09-09', '15:09:58'),
(115, 'qbw2N95', 'ulZI5INb', 1, 'p', NULL, NULL, NULL, '2021-09-13', '11:24:55'),
(116, 'qbw2N93', 'ulZI5INb', 1, 'p', NULL, NULL, NULL, '2021-09-13', '11:38:48'),
(117, 'qbw2N91', 'ulZI5INb', 1, 'halo', NULL, NULL, NULL, '2021-09-14', '11:39:16'),
(118, 'qbw2N95', 'ulZI5INb', 1, 'p', NULL, NULL, NULL, '2021-09-14', '11:50:05'),
(119, 'nCHe25a4', 'ulZI5INb', 1, 'halo', NULL, NULL, NULL, '2021-09-14', '11:54:12'),
(120, 'nCHe25a4', 'ulZI5INb', 1, 'anak anak', NULL, NULL, NULL, '2021-09-14', '11:58:16'),
(121, 'nCHe25a4', 'ulZI5INb', 1, 'a', NULL, NULL, NULL, '2021-09-14', '11:58:50'),
(123, 'qbw2N9_2', 'ulZI5INb', 1, 'halo', NULL, NULL, NULL, '2021-09-14', '12:14:15'),
(125, 'qbw2N9_2', 'ulZI5INb', 1, 'Selamat pagi anak - anak. Mohon maaf, bapak hari ini ingin menginformasikan bahwasanya saya tidak bisa mengajar untuk hari ini dikarenakan sakit. Terima kasih.', NULL, NULL, NULL, '2021-09-14', '12:23:37'),
(126, 'qbw2N9_2', 'ZPmNU34HMGmFKVka', 2, 'Siap pak', NULL, NULL, NULL, '2021-09-14', '12:24:36'),
(127, 'nCHe25a4_qbw2N9', 'ulZI5INb', 1, 'halo anak - anak', NULL, NULL, NULL, '2021-09-14', '13:26:54'),
(128, 'jrXOCz2x_YVuoE6', 'WI6cWjT7WOj67gwQ', 2, 'test', NULL, NULL, NULL, '2021-09-29', '15:27:59'),
(129, 'YVuoE6_2_9', 'WI6cWjT7WOj67gwQ', 2, 'p', NULL, NULL, NULL, '2021-09-29', '15:42:39'),
(130, 'YVuoE6_2_9', 'WI6cWjT7WOj67gwQ', 2, NULL, 'PJOK.png', 'sao4az0UEc1FCNhyW69PbghrHpztK2bWPJOK.png', 'png', '2021-09-29', '15:42:48'),
(131, 'YVuoE6_1', 'WI6cWjT7WOj67gwQ', 2, 'p', NULL, NULL, NULL, '2021-09-29', '15:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `db_jenjang`
--

CREATE TABLE `db_jenjang` (
  `id` int(11) NOT NULL,
  `jenjang` int(11) NOT NULL,
  `tingkat` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `registrasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `db_jenjang`
--

INSERT INTO `db_jenjang` (`id`, `jenjang`, `tingkat`, `nama`, `status`, `registrasi`) VALUES
(1, 1, 1, 'SD Kelas 1', '0', 0),
(2, 1, 2, 'SD Kelas 2', '0', 0),
(3, 1, 3, 'SD Kelas 3', '0', 0),
(4, 1, 4, 'SD Kelas 4', '0', 0),
(5, 1, 5, 'SD Kelas 5', '0', 0),
(6, 1, 6, 'SD Kelas 6', '0', 0),
(7, 2, 7, 'SMP Kelas 7', '0', 0),
(8, 2, 8, 'SMP Kelas 8', '0', 0),
(9, 2, 9, 'SMP Kelas 9', '0', 250000),
(10, 3, 10, 'SMA Kelas 10', '0', 0),
(11, 3, 11, 'SMA Kelas 11', '0', 0),
(12, 3, 12, 'SMA Kelas 12', '0', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pengajar`
--

CREATE TABLE `detail_pengajar` (
  `id` int(11) NOT NULL,
  `pengajar` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `pendidikan` varchar(50) NOT NULL,
  `universitas` varchar(50) NOT NULL,
  `tentor_progam` int(11) DEFAULT NULL,
  `tlp` int(15) NOT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_pengajar`
--

INSERT INTO `detail_pengajar` (`id`, `pengajar`, `jenis_kelamin`, `tempat_lahir`, `tgl_lahir`, `alamat`, `pendidikan`, `universitas`, `tentor_progam`, `tlp`, `foto`) VALUES
(1, 'ulZI5INb', 'L', 'Blitar', '1999-08-17', 'Jln. Raya Blitar No 190', 'S1', 'Blitar', NULL, 1234567889, ''),
(2, 'AsmF7LKC', 'P', 'Kediri', '1997-05-07', 'Jln. Kediri Blitar No 125', 'S1', 'UNP Kediri', NULL, 85345678, ''),
(4, 'p1rlKK09', 'L', 'kediri', '2021-09-01', 'kediri', 'Strata 1', 'hh', NULL, 888, NULL),
(5, 'dZjipXnL', 'L', 'kediri', '2021-09-01', 'kediri', 'Strata 1', 'bbb', NULL, 123, NULL),
(6, 'VJc4T5Eh', 'L', 'kediri', '2021-09-01', 'kediri', 'Strata 1', 'bbb', NULL, 777, NULL),
(7, 'iVwgCh3Z', 'L', 'kediri', '2021-09-01', 'kediri', 'Strata 1', 'bbb', NULL, 777, NULL),
(15, 'tAZFSZNl', 'L', 'kediri', '2021-12-30', 'kediri', 'Strata 1', 'kok', NULL, 8288, NULL),
(16, '6Ue6z5Rr', 'L', 'Blitar', '1997-05-04', 'Jln. Kediri Blitar No 126', 'S2', 'UNP Kediri1', NULL, 85345678, '20211207050136.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_category`
--

CREATE TABLE `faq_category` (
  `id` int(11) NOT NULL,
  `category_id` varchar(55) NOT NULL,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faq_category`
--

INSERT INTO `faq_category` (`id`, `category_id`, `category`, `created_at`) VALUES
(1, 'JZaL88pE', 'Teknis Pendaftaran', '2021-06-19 09:30:53'),
(2, 'VaaWGkas', 'Teknis Pembayaran', '2021-06-19 09:44:37'),
(3, 'iNbSY5dd', 'Dokumen yang dibutuhkan', '2021-06-19 09:44:45'),
(4, 'gDEjEIJd', 'Fasilitas yang didapatkan', '2021-06-19 09:44:59'),
(5, 'JwozOUxq', 'Nomor Costumer Service', '2021-06-19 09:45:08'),
(11, 'SBgBtEwb', 'tanya', '2021-09-15 05:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `faq_question`
--

CREATE TABLE `faq_question` (
  `id` int(11) NOT NULL,
  `faq_category` varchar(255) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faq_question`
--

INSERT INTO `faq_question` (`id`, `faq_category`, `question`, `answer`, `created_at`) VALUES
(1, 'JZaL88pE', 'Apa saja syarat yang diperlukan untuk pendaftaran?', '<ol>\r\n	<li>E-mail aktif</li>\r\n	<li>No handphone aktif</li>\r\n	<li>Kartu Tanda Pelajar</li>\r\n</ol>', '2021-06-26 08:56:59'),
(3, 'VaaWGkas', 'Berapa nomor rekening yang dapat menerima pembayaran untuk program ini?', '<p>Rekening BRI atas nama astartekno 111.222.333.4444</p>', '2021-06-26 09:17:05'),
(4, 'VaaWGkas', 'Bagaimana cara menyetor bukti pembayaran?', '<p>Unggah di astartekno.com/partnership/unggah_bukti_pembayaran lalu masukkan id pembayaran anda&nbsp;</p>', '2021-06-26 09:18:46'),
(5, '9BLQKgWt', 'coba', '<ul>\r\n	<li>Coba 1</li>\r\n	<li>Coba 2</li>\r\n	<li>Coba 3</li>\r\n</ul>', '2021-09-14 08:30:18'),
(6, '9BLQKgWt', 'coba 2', '<ol>\r\n	<li>test</li>\r\n	<li>tost</li>\r\n	<li>tist</li>\r\n	<li>tast</li>\r\n</ol>', '2021-09-14 08:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `index_html`
--

CREATE TABLE `index_html` (
  `id` int(11) NOT NULL,
  `comp_id` varchar(55) NOT NULL,
  `comp_url` text NOT NULL,
  `header` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `index_html`
--

INSERT INTO `index_html` (`id`, `comp_id`, `comp_url`, `header`, `description`, `url`) VALUES
(1, 'slideshow', 'public/1st.jpg', 'Lomba Desain Logo', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', ''),
(2, 'slideshow', 'public/2nd.jpg', 'Program Guru', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', NULL),
(3, 'slideshow', 'public/3rd.jpg', 'Magang', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kelas`
--

CREATE TABLE `jadwal_kelas` (
  `id` int(11) NOT NULL,
  `id_jadwal` varchar(20) NOT NULL,
  `meet_id` text NOT NULL,
  `url` text DEFAULT NULL,
  `kelas` varchar(11) NOT NULL,
  `tingkat` int(11) DEFAULT NULL,
  `mapel` int(11) DEFAULT NULL,
  `pengajar` varchar(50) NOT NULL,
  `hari` int(11) NOT NULL,
  `jam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_kelas`
--

INSERT INTO `jadwal_kelas` (`id`, `id_jadwal`, `meet_id`, `url`, `kelas`, `tingkat`, `mapel`, `pengajar`, `hari`, `jam`) VALUES
(11, 'qIMWe7', '86825206131', 'https://us05web.zoom.us/j/86825206131?pwd=N3J6c0Fyb0tnTHU4b3BJak1kUytoUT09', 'YVuoE6', 9, 2, 'ulZI5INb', 1, 1),
(18, 'esH1gJ', '89720509507', 'https://us05web.zoom.us/j/89720509507?pwd=bEpXaWJudjZWRksyNk5lL1owUUdBQT09', 'YVuoE6', 9, 3, 'SHob4PyA', 2, 5),
(19, 'R6uz4M', '84704785482', 'https://us05web.zoom.us/j/84704785482?pwd=OS9aNzM2T0w0MkhpdzFCODZjSHhlZz09', 'YVuoE6', 9, 1, 'AsmF7LKC', 5, 1),
(20, 'PVRuSi', '88193535354', 'https://us05web.zoom.us/j/88193535354?pwd=YTZKQjlFdlE4bGRydi93NnQ1QzhXQT09', 'YVuoE6', 9, 2, 'ulZI5INb', 1, 2),
(21, 'TgMhOd', '84921671498', 'https://us05web.zoom.us/j/84921671498?pwd=UzJsdFVHd3V1QkxURUtCa3FWN2t2dz09', 'YVuoE6', 9, 2, '6Ue6z5Rr', 2, 1),
(22, 'Koygrd', '84911433808', 'https://us05web.zoom.us/j/84911433808?pwd=WXdMdDF5R3BsQnJwSUp3YXE3OC9nZz09', 'YVuoE6', 9, 0, '6Ue6z5Rr', 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_artikel`
--

INSERT INTO `kategori_artikel` (`id`, `name`) VALUES
(1, 'berita'),
(2, 'pendidikan'),
(3, 'Sejarah'),
(4, 'Up to date'),
(5, 'Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `id_kelas` varchar(10) NOT NULL,
  `room_name` varchar(30) NOT NULL,
  `jenjang` varchar(20) NOT NULL,
  `tingkat` varchar(20) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `info` varchar(100) DEFAULT NULL,
  `registrasi` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `id_kelas`, `room_name`, `jenjang`, `tingkat`, `status`, `info`, `registrasi`, `created_at`) VALUES
(1, 'YVuoE6', 'A', '2', '9', '1', NULL, NULL, '2021-12-02 04:27:28'),
(2, '3MTxfd', 'A', '3', '12', '1', NULL, NULL, '2021-11-29 06:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `kursus_spv`
--

CREATE TABLE `kursus_spv` (
  `id` int(11) NOT NULL,
  `id_spv` varchar(55) NOT NULL,
  `room_id` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kursus_spv`
--

INSERT INTO `kursus_spv` (`id`, `id_spv`, `room_id`) VALUES
(1, 'ulZI5INb', '5CHMjJ'),
(2, 'ulZI5INb', 'Hb1TGu'),
(3, 'SHob4PyA', 'iwyqzh'),
(4, 'AsmF7LKC', 'ghP0Cq');

-- --------------------------------------------------------

--
-- Table structure for table `mapel_kelas`
--

CREATE TABLE `mapel_kelas` (
  `id` int(11) NOT NULL,
  `id_mapel_kelas` varchar(20) NOT NULL,
  `id_kelas` varchar(11) DEFAULT NULL,
  `jenjang` int(11) NOT NULL,
  `tingkat` int(11) NOT NULL,
  `mapel` int(11) NOT NULL,
  `harga` int(10) DEFAULT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mapel_kelas`
--

INSERT INTO `mapel_kelas` (`id`, `id_mapel_kelas`, `id_kelas`, `jenjang`, `tingkat`, `mapel`, `harga`, `deskripsi`) VALUES
(1, '1', NULL, 2, 9, 3, 180000, ''),
(2, '2', NULL, 2, 9, 1, 200000, 'Mata Pelajaran Matematika ini diperutukan untuk SMP/Sederajat Kelas 9'),
(4, '4', NULL, 2, 9, 2, 150000, 'Bahasa Indonesia untuk tingkat SMP/Sederajat Kelas 9'),
(22, 'FIS-9-5', NULL, 2, 9, 6, 250000, 'Fisika khusus untuk menghadapi ujian akhir semsester smp kelas');

-- --------------------------------------------------------

--
-- Table structure for table `mapel_pengajar`
--

CREATE TABLE `mapel_pengajar` (
  `id` int(11) NOT NULL,
  `id_mapel_pengajar` varchar(11) NOT NULL,
  `id_pengajar` varchar(11) NOT NULL,
  `id_mapel` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mapel_pengajar`
--

INSERT INTO `mapel_pengajar` (`id`, `id_mapel_pengajar`, `id_pengajar`, `id_mapel`) VALUES
(1, '1', 'ulZI5INb', '1'),
(2, '2', 'AsmF7LKC', '3'),
(3, '3', 'E8FqKdRB', '2'),
(4, '4', 'SHob4PyA', '6'),
(5, '5', '6Ue6z5Rr', '1'),
(9, '6', 'ulZI5INb', '2'),
(10, '10', 'SHob4PyA', '7'),
(13, '13', 'p1rlKK09', '7'),
(14, '14', 'p1rlKK09', '2'),
(17, '17', 'dZjipXnL', '3'),
(19, '19', 'VJc4T5Eh', '4'),
(20, '20', 'iVwgCh3Z', '5'),
(32, '21', 'tAZFSZNl', '2'),
(33, '33', 'tAZFSZNl', '1'),
(34, '34', '6Ue6z5Rr', '6');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `materi_id` varchar(55) NOT NULL,
  `materi_name` text NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `konten` longtext NOT NULL,
  `video_url` text DEFAULT NULL,
  `video_duration` int(11) DEFAULT NULL,
  `lampiran` text DEFAULT NULL,
  `meet_url` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `materi_id`, `materi_name`, `user_id`, `konten`, `video_url`, `video_duration`, `lampiran`, `meet_url`, `created_at`, `del_status`) VALUES
(1, '3ksdIG', 'How to auto change position of <li> in Jquery', 'Q10pwu6Z', '<p>jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API that works across a multitude of browsers. With a combination of versatility and extensibility, jQuery has changed the way that millions of people write JavaScript.</p>', 'XercfCyjL-c', 38, 'q4ygbpdb_class_client (2).sql', NULL, '2021-04-07 09:35:57', 0),
(2, 'oSOETh', 'MySQL database', 'Q10pwu6Z', '<p>s</p>', 'XercfCyjL-c', 38, NULL, NULL, '2021-04-07 09:36:21', 0),
(3, 'g2oSbG', 'a', 'Q10pwu6Z', '<p>a</p>', 'XercfCyjL-c', 38, NULL, NULL, '2021-04-07 09:42:39', 0),
(4, 'QqY0Tr', 'c', 'Q10pwu6Z', '<p>c</p>', 'XercfCyjL-c', 38, NULL, NULL, '2021-04-07 09:43:35', 0),
(5, 'wOlT9w', 'coba 1', 'Q10pwu6Z', '<p>c</p>', 'XercfCyjL-c', 38, NULL, NULL, '2021-04-07 09:44:19', 1),
(6, 'QEFsRP', 'Bahasa inggris', 'Q10pwu6Z', '<p>c</p>', 'XercfCyjL-c', 38, 'VxFrX7dist.zip', NULL, '2021-04-07 09:53:18', 0),
(8, 'AdcCpo', 'materi 1', 'Q10pwu6Z', 'c', 'XercfCyjL-c', 38, NULL, NULL, '2021-04-13 09:32:33', 0),
(12, 'qyGjxe', 'percobaan lampiran', 'Q10pwu6Z', '<p>coba</p>', 'XercfCyjL-c', 38, 'qyGjxejcpicker (1).txt', NULL, '2021-04-15 06:45:39', 0),
(13, 'rnai8c', 'c', 'Q10pwu6Z', '<p>c</p>', 'XercfCyjL-c', 38, 'rnai8cjcpicker (1).txt', NULL, '2021-04-15 06:48:50', 0),
(14, 'tIRTFO', 'ccc', 'Q10pwu6Z', '<p>cc</p>', 'XercfCyjL-c', 38, 'tIRTFOjcpicker (1).txt', NULL, '2021-04-15 06:49:58', 0),
(15, 'CJVuRK', 'd', 'Q10pwu6Z', '<p>c</p>', 'XercfCyjL-c', 38, 'CJVuRKjcpicker (1).txt', NULL, '2021-04-15 06:51:14', 0),
(16, 'R4HibO', 'c', 'Q10pwu6Z', '<p>c</p>', 'XercfCyjL-c', 38, 'R4HibOjcpicker (1).txt', NULL, '2021-04-15 06:51:55', 0),
(17, '0oTis9', 'c', 'Q10pwu6Z', '<p>c</p>', 'XercfCyjL-c', 38, '0oTis9jcpicker (1).txt', NULL, '2021-04-15 06:53:10', 1),
(18, 'GYf10f', 'tugas 1', 'Q10pwu6Z', '<p>tugas</p>', NULL, NULL, NULL, NULL, '2021-04-27 07:01:00', 1),
(19, 'cIlNFa', 'materi pertama', 'ulZI5INb', '<p>coba</p>', 'XercfCyjL-c', 38, NULL, NULL, '2021-05-22 08:37:36', 0),
(20, 'W1sGy6', 'pendahuluan', 'ulZI5INb', '<p>xss</p>', 'XercfCyjL-c', 38, NULL, NULL, '2021-05-22 09:17:09', 0),
(21, '8MieIJ', 'Database Migration', 'ulZI5INb', '<p>Migrations are like version control for your database, allowing your team to define and share the application&#39;s database schema definition. If you have ever had to tell a teammate to manually add a column to their local database schema after pulling in your changes from source control, you&#39;ve faced the problem that database migrations solve.</p>\r\n\r\n<p>The Laravel&nbsp;<code>Schema</code>&nbsp;<a href=\"https://laravel.com/docs/8.x/facades\">facade</a>&nbsp;provides database agnostic support for creating and manipulating tables across all of Laravel&#39;s supported database systems. Typically, migrations will use this facade to create and modify database tables and columns.</p>', 'XercfCyjL-c', 38, NULL, NULL, '2021-05-24 09:45:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `materi_room`
--

CREATE TABLE `materi_room` (
  `id` int(11) NOT NULL,
  `materi_id` varchar(55) NOT NULL,
  `room_id` varchar(55) NOT NULL,
  `owner_id` varchar(55) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materi_room`
--

INSERT INTO `materi_room` (`id`, `materi_id`, `room_id`, `owner_id`, `created_at`) VALUES
(2, 'pYuEpZ', 'IN7Ezf', 'Q10pwu6Z', '2021-04-03 07:26:03'),
(4, 'lzvMUa', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 06:11:22'),
(5, 'ojWmVe', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 07:02:10'),
(6, 'rjQnmE', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 08:23:48'),
(7, 'fhiy86', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 08:54:46'),
(8, 'Z7GEhm', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:14:40'),
(9, 'NkmdAn', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:18:48'),
(10, 'oKI8XT', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:30:10'),
(11, 'TrPGIb', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:32:55'),
(12, 'XgNvmy', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:33:29'),
(13, '3ksdIG', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:35:56'),
(14, 'oSOETh', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:36:21'),
(15, 'g2oSbG', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:42:39'),
(16, 'QqY0Tr', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:43:35'),
(17, 'wOlT9w', 'IN7Ezf', 'Q10pwu6Z', '2021-04-07 09:44:19'),
(18, 'QEFsRP', 'QiE8JD', 'Q10pwu6Z', '2021-04-07 09:53:18'),
(19, 'rk05tF', 'IN7Ezf', 'Q10pwu6Z', '2021-04-13 08:45:13'),
(20, 'AdcCpo', 'vBYGKo', 'Q10pwu6Z', '2021-04-13 09:32:33'),
(21, 'AdcCpo', 'vBYGKo', 'Q10pwu6Z', '2021-04-13 09:45:22'),
(22, '4Wjs9L', 'IN7Ezf', 'Q10pwu6Z', '2021-04-14 09:43:18'),
(23, 'cPMg6p', 'IN7Ezf', 'Q10pwu6Z', '2021-04-14 09:44:06'),
(24, 'Jbw7HO', 'IN7Ezf', 'Q10pwu6Z', '2021-04-14 09:44:35'),
(25, 'ER0UGu', 'IN7Ezf', 'Q10pwu6Z', '2021-04-14 09:45:23'),
(26, 'bazwb5', 'IN7Ezf', 'Q10pwu6Z', '2021-04-14 09:50:47'),
(27, 'qyGjxe', 'IN7Ezf', 'Q10pwu6Z', '2021-04-15 06:45:39'),
(28, 'rnai8c', 'IN7Ezf', 'Q10pwu6Z', '2021-04-15 06:48:49'),
(29, 'tIRTFO', 'IN7Ezf', 'Q10pwu6Z', '2021-04-15 06:49:57'),
(30, 'CJVuRK', 'IN7Ezf', 'Q10pwu6Z', '2021-04-15 06:51:14'),
(31, 'R4HibO', 'IN7Ezf', 'Q10pwu6Z', '2021-04-15 06:51:55'),
(32, '0oTis9', 'IN7Ezf', 'Q10pwu6Z', '2021-04-15 06:53:10'),
(33, 'GYf10f', 'IN7Ezf', 'Q10pwu6Z', '2021-04-27 07:01:00'),
(34, 'cIlNFa', '8DtGaf', 'ulZI5INb', '2021-05-22 08:37:35'),
(35, 'W1sGy6', 'vBYGKo', 'ulZI5INb', '2021-05-22 09:17:09'),
(36, '8MieIJ', 'vBYGKo', 'ulZI5INb', '2021-05-24 09:45:46');

-- --------------------------------------------------------

--
-- Table structure for table `materi_user`
--

CREATE TABLE `materi_user` (
  `id` int(11) NOT NULL,
  `user_id` varchar(55) NOT NULL,
  `materi_id` varchar(55) NOT NULL,
  `on_screen_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materi_user`
--

INSERT INTO `materi_user` (`id`, `user_id`, `materi_id`, `on_screen_time`, `created_at`) VALUES
(1, 'gewbjo12', '3ksdIG', 0, '2021-04-08 06:13:02'),
(2, 'gewbjo12', 'oSOETh', 0, '2021-04-10 07:27:34'),
(3, 'gewbjo12', 'QqY0Tr', 0, '2021-04-10 07:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `partner`
--

CREATE TABLE `partner` (
  `id` int(11) NOT NULL,
  `partner_type` int(11) DEFAULT NULL,
  `partner_id` varchar(255) NOT NULL,
  `partner_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_instansi` varchar(255) DEFAULT NULL,
  `user_kuota` int(11) NOT NULL DEFAULT 50,
  `verify` int(11) NOT NULL DEFAULT 0,
  `otp` varchar(255) NOT NULL,
  `instansi` text DEFAULT NULL,
  `penanggung_jawab` varchar(255) DEFAULT NULL,
  `surat_izin` text DEFAULT NULL,
  `ktp_penanggung_jawab` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partner`
--

INSERT INTO `partner` (`id`, `partner_type`, `partner_id`, `partner_name`, `email`, `nama_instansi`, `user_kuota`, `verify`, `otp`, `instansi`, `penanggung_jawab`, `surat_izin`, `ktp_penanggung_jawab`, `phone`, `password`, `created_at`) VALUES
(1, 2, 'gewbjo12', 'zega', 'randombox38@gmail.com', 'Bimbingan Skripsi', 100, 1, 'gewbjo12', NULL, 'saya sendiri', '2344-6564-1-PB.pdf', '14-IJCSE-04947.pdf', '+6281252867991', '$2y$10$6y4TKlM185DmLuQq/fEiCu6uYxUlx4P3ZbAU9jVHCZcKfFs.xXQ..', '2021-02-20 09:06:08'),
(2, 1, '59GcRdfT', 'zegas', 'randombox38@gmail.coms', NULL, 50, 1, '59GcRdfT', NULL, NULL, NULL, NULL, '', '$2y$10$uGqC0Qm2bLzQceZxKF7x0uRA03V2ZoQ1X0yussLN4jdRpa3Hb791a', '2021-02-20 10:10:02'),
(4, 1, 'NovdUhMF', 'zega3', 'randombox382@gmail.com', NULL, 50, 0, 'NovdUhMF', NULL, NULL, NULL, NULL, '', '$2y$10$pyvdtFXHOp5JKETE2Se.1.auD8qadrGw9vJfUUtVVI7fLXBcu26Cy', '2021-02-22 07:29:49'),
(5, NULL, '8UaMJij7', 'zega34', 'randombox3856@gmail.com', NULL, 50, 0, '8UaMJij7', NULL, NULL, NULL, NULL, '', '$2y$10$2NSiJLDWH6h8/jQtFmhRS.nDJHkJv.irUXduDCwC3yxScR0MfcWR6', '2021-02-22 07:45:26'),
(6, NULL, 'AHACeHpQ', 's', 'zega@gmail.com', NULL, 50, 1, 'AHACeHpQ', NULL, NULL, NULL, NULL, '', '$2y$10$vjfx0pCWcbW1T5x5B83VLe/YZkZeAb8SQDUQ11SPn9U9TmUF5s36q', '2021-03-08 07:47:10'),
(7, 1, 'Q10pwu6Z', 'Joseph', 'coba@gmail.com', 'Bimbingan Skripsi', 720, 1, 'Q10pwu6Z', NULL, 'saya sendiri', '2344-6564-1-PB.pdf', 'jcpicker (1).txt', '+6281252867991', '$2y$10$6y4TKlM185DmLuQq/fEiCu6uYxUlx4P3ZbAU9jVHCZcKfFs.xXQ..', '2021-03-08 07:52:45'),
(9, 2, 'khQEPY1v', 'a', 'a@gmail.com', NULL, 50, 1, 'khQEPY1v', NULL, NULL, NULL, NULL, NULL, '$2y$10$QaNnwDClqeUA4XnS3VmvJu048HdiE2A7rkOBS9bnPJan.u.J35hni', '2021-03-26 10:27:05'),
(11, NULL, 'Eena5YGT', 'zega_feb', 'xegalol@gmail.com', NULL, 50, 0, 'Eena5YGT', NULL, NULL, NULL, NULL, NULL, '$2y$10$IBfhGPlhewKVdCpFjtgtGOwcAIHJ2K0W8IGiFs0uv9jTJvc3a/7zC', '2021-04-15 07:25:33'),
(12, 1, 'Blv9nJ0U', 'zega_feb', 'xegalol@gmail.com', 'PT SAYASENDIRI', 40, 1, 'Blv9nJ0U', NULL, 'saya sendiri', NULL, NULL, '081252867991', '$2y$10$L.EbCaOY/e6iLkPlOHLThuAVvYbYWZaNkyTzELFwrbNH9jxlV4FAO', '2021-04-15 07:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `partnership`
--

CREATE TABLE `partnership` (
  `id` int(11) NOT NULL,
  `email` varchar(55) NOT NULL,
  `nama` text NOT NULL,
  `instansi` text NOT NULL,
  `alamat` text DEFAULT NULL,
  `telpon` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partnership`
--

INSERT INTO `partnership` (`id`, `email`, `nama`, `instansi`, `alamat`, `telpon`, `created_at`) VALUES
(1, '', 'saya', 'jayabaya', 'blitar', '081222333444', '2021-07-03 08:40:12'),
(2, '', 'saya', 'jayabaya', 'blitar', '081222333444', '2021-07-03 08:40:36'),
(3, '', 'saya', 'jayabaya 2', 'blitar', '081222333444', '2021-07-03 08:41:56'),
(4, '', 'saya', 'jayabaya 2', 'blitar', '081222333444', '2021-07-03 08:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `bab_id` int(11) NOT NULL,
  `mapel_id` int(11) DEFAULT NULL,
  `room_id` varchar(55) NOT NULL,
  `quiz_id` varchar(55) NOT NULL,
  `quiz_name` text DEFAULT NULL,
  `kkm` int(11) DEFAULT NULL,
  `time` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `bab_id`, `mapel_id`, `room_id`, `quiz_id`, `quiz_name`, `kkm`, `time`, `status`, `created_at`, `del_status`) VALUES
(6, 4, 2, '9', 'mjW1BDXL', 'Bahasa Jepang', 50, 20, 0, '2021-12-02 08:59:05', 0),
(8, 4, 2, '9', 'RYYNV1Km', 'Belajar', 50, 20, 0, '2021-12-03 09:38:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_option`
--

CREATE TABLE `quiz_option` (
  `id` int(11) NOT NULL,
  `quiz_id` varchar(55) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `attachment` varchar(100) NOT NULL,
  `benar` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_option`
--

INSERT INTO `quiz_option` (`id`, `quiz_id`, `quiz_question_id`, `option_text`, `attachment`, `benar`) VALUES
(10, 'RYYNV1Km', 1, '<p>Ayam</p>', '', 0),
(11, 'RYYNV1Km', 1, '<p>Ikan</p>', '', 0),
(12, 'RYYNV1Km', 1, '<p>Sapi</p>', '', 1),
(13, 'RYYNV1Km', 1, '<p>Hiu</p>', '', 0),
(14, 'RYYNV1Km', 2, '<p>pitek</p>', '', 1),
(15, 'RYYNV1Km', 2, '<p>wedus</p>', '', 0),
(16, 'RYYNV1Km', 3, '<p>sya</p>', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `quiz_id` varchar(55) NOT NULL,
  `question` text NOT NULL,
  `attachment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_question`
--

INSERT INTO `quiz_question` (`id`, `question_id`, `quiz_id`, `question`, `attachment`) VALUES
(21, 1, 'RYYNV1Km', '<p>Dibawah ini merupakan hewan berkaki 4, yaitu?</p>', NULL),
(22, 2, 'RYYNV1Km', '<p>Dibawah ini merupakan hewan berkaki 2, yaitu?</p>', NULL),
(23, 3, 'RYYNV1Km', '<p>/saya adalah?</p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question_attachment`
--

CREATE TABLE `quiz_question_attachment` (
  `id` int(11) NOT NULL,
  `quiz_id` varchar(55) NOT NULL,
  `question_id` varchar(55) NOT NULL,
  `filename` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_question_attachment`
--

INSERT INTO `quiz_question_attachment` (`id`, `quiz_id`, `question_id`, `filename`, `created_at`) VALUES
(1, 'p0qlZb6L', '1', 'p03qObCu8EQ7jHIRJellyfish.jpg', '2021-10-20 13:54:14');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_user`
--

CREATE TABLE `quiz_user` (
  `id` int(11) NOT NULL,
  `user_id` varchar(55) NOT NULL,
  `quiz_id` varchar(55) NOT NULL,
  `nilai` int(11) NOT NULL,
  `lulus` int(11) NOT NULL,
  `user_answer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`user_answer`)),
  `right_answer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`right_answer`)),
  `user_right_answer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`user_right_answer`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_user`
--

INSERT INTO `quiz_user` (`id`, `user_id`, `quiz_id`, `nilai`, `lulus`, `user_answer`, `right_answer`, `user_right_answer`, `created_at`) VALUES
(6, 'E8FqKdRB', 'mqL9UWHpRV', 75, 0, '[{\"question_id\":18,\"answer\":\"33\"},{\"question_id\":19,\"answer\":\"37\"},{\"question_id\":20,\"answer\":\"39\"},{\"question_id\":21,\"answer\":\"42\"}]', '[{\"question_id\":18,\"answer\":33},{\"question_id\":19,\"answer\":37},{\"question_id\":20,\"answer\":39},{\"question_id\":21,\"answer\":41}]', '[{\"question_id\":18,\"answer\":\"33\"},{\"question_id\":19,\"answer\":\"37\"},{\"question_id\":20,\"answer\":\"39\"}]', '2021-07-28 07:34:56'),
(7, 'E8FqKdRB', '1BNfDmVJmg', 83, 1, '[{\"question_id\":1,\"answer\":\"15\"},{\"question_id\":2,\"answer\":\"3\"},{\"question_id\":3,\"answer\":\"8\"},{\"question_id\":4,\"answer\":\"10\"},{\"question_id\":5,\"answer\":\"14\"},{\"question_id\":7,\"answer\":\"18\"}]', '[{\"question_id\":1,\"answer\":15},{\"question_id\":2,\"answer\":3},{\"question_id\":3,\"answer\":8},{\"question_id\":4,\"answer\":9},{\"question_id\":5,\"answer\":14},{\"question_id\":7,\"answer\":18}]', '[{\"question_id\":1,\"answer\":\"15\"},{\"question_id\":2,\"answer\":\"3\"},{\"question_id\":3,\"answer\":\"8\"},{\"question_id\":5,\"answer\":\"14\"},{\"question_id\":7,\"answer\":\"18\"}]', '2021-07-28 08:27:38'),
(8, 'ZovrKpzeljwa5Z6j', '1BNfDmVJmg', 83, 1, '[{\"question_id\":1,\"answer\":\"15\"},{\"question_id\":2,\"answer\":\"3\"},{\"question_id\":3,\"answer\":\"8\"},{\"question_id\":4,\"answer\":\"10\"},{\"question_id\":5,\"answer\":\"14\"},{\"question_id\":7,\"answer\":\"18\"}]', '[{\"question_id\":1,\"answer\":15},{\"question_id\":2,\"answer\":3},{\"question_id\":3,\"answer\":8},{\"question_id\":4,\"answer\":9},{\"question_id\":5,\"answer\":14},{\"question_id\":7,\"answer\":18}]', '[{\"question_id\":1,\"answer\":\"15\"},{\"question_id\":2,\"answer\":\"3\"},{\"question_id\":3,\"answer\":\"8\"},{\"question_id\":5,\"answer\":\"14\"},{\"question_id\":7,\"answer\":\"18\"}]', '2021-08-03 08:49:33'),
(9, 'WI6cWjT7WOj67gwQ', 'ZhtZ8CJb', 100, 1, '[{\"question_id\":2,\"answer\":\"2\"},{\"question_id\":3,\"answer\":\"4\"}]', '[{\"question_id\":2,\"answer\":2},{\"question_id\":3,\"answer\":4}]', '[{\"question_id\":2,\"answer\":\"2\"},{\"question_id\":3,\"answer\":\"4\"}]', '2021-09-29 09:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_id` varchar(55) NOT NULL,
  `role_name` varchar(55) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_id`, `role_name`, `url`) VALUES
(1, 'k_a', 'Kelola Admin', 'all_admin'),
(2, 'k_p', 'Kelola Partner', 'all_partner'),
(3, 'k_u', 'Kelola User', 'all_user'),
(4, 'k_r', 'Kelola Ruangan', 'all_room'),
(5, 'k_s', 'Kelola Slideshow', ''),
(6, 'b_u', 'Buat Artikel', '');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `room_id` varchar(255) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(55) NOT NULL,
  `locked` int(11) NOT NULL DEFAULT 0,
  `biaya` int(10) NOT NULL,
  `kursus_spv` varchar(55) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `room_id`, `room_name`, `description`, `icon`, `locked`, `biaya`, `kursus_spv`, `created_at`) VALUES
(2, 'Hb1TGu', 'Progaming Web', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ENG.png', 0, 450000, 'ulZI5INb', '2021-10-01 07:22:15'),
(4, 'ghP0Cq', 'Bahasa', 'jj', 'PAI.png', 0, 20, 'AsmF7LKC', '2021-12-03 07:19:26');

-- --------------------------------------------------------

--
-- Table structure for table `room_user`
--

CREATE TABLE `room_user` (
  `id` int(11) NOT NULL,
  `register_id` varchar(55) NOT NULL,
  `type` int(11) NOT NULL,
  `room_id` varchar(255) DEFAULT NULL,
  `jenjang` int(11) DEFAULT NULL,
  `tingkat` int(11) DEFAULT NULL,
  `school_name` varchar(100) DEFAULT NULL,
  `user_id` varchar(255) NOT NULL,
  `bukti_pembayaran` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_user`
--

INSERT INTO `room_user` (`id`, `register_id`, `type`, `room_id`, `jenjang`, `tingkat`, `school_name`, `user_id`, `bukti_pembayaran`, `status`, `created_at`) VALUES
(1, 'OCqzRgN9', 0, 'YVuoE6', 2, 9, 'sman 3 blitar', 'WI6cWjT7WOj67gwQ', 'JZeWI6cWjT7WOj67gwQENG.jpg', 1, '2021-09-29 08:05:44'),
(2, '1W0irs6v', 1, 'Hb1TGu', NULL, NULL, NULL, 'WI6cWjT7WOj67gwQ', 'DJWN7YDeRIDlMa3VSEJARAH.png', 0, '2021-09-29 08:48:32'),
(3, 'PDrsQhM8', 0, 'YVuoE6', 2, 9, 'sman 3 blitar', 'WI6cWjT7WOj67gwQ', 'JZeWI6cWjT7WOj67gwQENG.png', 0, '2021-09-29 08:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `room_user_mapel`
--

CREATE TABLE `room_user_mapel` (
  `id` int(11) NOT NULL,
  `register_id` varchar(55) DEFAULT NULL,
  `room_id` varchar(55) DEFAULT NULL,
  `tingkat` int(11) DEFAULT NULL,
  `user_id` varchar(55) NOT NULL,
  `mapel` int(11) NOT NULL,
  `verify` int(11) NOT NULL DEFAULT 0,
  `register_type` int(11) NOT NULL DEFAULT 0,
  `harga` int(11) NOT NULL,
  `bukti_pembayaran` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_user_mapel`
--

INSERT INTO `room_user_mapel` (`id`, `register_id`, `room_id`, `tingkat`, `user_id`, `mapel`, `verify`, `register_type`, `harga`, `bukti_pembayaran`, `created_at`) VALUES
(1, 'OCqzRgN9', 'YVuoE6', 9, 'WI6cWjT7WOj67gwQ', 1, 1, 0, 150000, 'JZeWI6cWjT7WOj67gwQENG.jpg', '2021-12-01 07:30:09'),
(2, 'OCqzRgN9', 'YVuoE6', 9, 'WI6cWjT7WOj67gwQ', 2, 1, 0, 200000, 'JZeWI6cWjT7WOj67gwQENG.jpg', '2021-12-01 07:30:09'),
(3, 'uYFEDPQ2', 'YVuoE6', 9, 'WI6cWjT7WOj67gwQ', 3, 1, 1, 100000, NULL, '2021-12-01 07:30:02'),
(4, 'PDrsQhM8', 'YVuoE6', 9, 'WI6cWjT7WOj67gwQ', 3, 0, 0, 100000, NULL, '2021-12-01 07:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `sub_bab`
--

CREATE TABLE `sub_bab` (
  `id` int(11) NOT NULL,
  `room_id` varchar(55) NOT NULL,
  `bab_id` int(11) NOT NULL,
  `mapel` int(11) DEFAULT NULL,
  `sub_id` int(11) NOT NULL,
  `type` varchar(55) NOT NULL,
  `type_id` varchar(55) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_bab`
--

INSERT INTO `sub_bab` (`id`, `room_id`, `bab_id`, `mapel`, `sub_id`, `type`, `type_id`, `created_at`) VALUES
(2, '9', 2, 1, 1, 'materi', 'GJ1povMh', '2021-10-28 05:57:38'),
(7, 'Hb1TGu', 1, NULL, 3, 'materi', '3j2FfXz4', '2021-11-23 09:10:49'),
(35, '9', 4, 2, 1, 'quiz', 'mjW1BDXL', '2021-12-02 08:59:05'),
(40, 'Hb1TGu', 1, NULL, 4, 'tugas', '61icTZ7T', '2021-12-03 09:19:31'),
(41, '9', 4, 2, 2, 'tugas', 'F1CR2lEJ', '2021-12-03 09:22:00'),
(43, '9', 4, 2, 3, 'quiz', 'RYYNV1Km', '2021-12-03 09:38:56'),
(44, '9', 4, 2, 4, 'materi', 'pd85r0r5', '2021-12-04 05:15:16'),
(45, '9', 4, 2, 6, 'tugas', 'kt36KCXj', '2021-12-04 06:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `sub_bab_user`
--

CREATE TABLE `sub_bab_user` (
  `id` int(11) NOT NULL,
  `user_id` varchar(55) NOT NULL,
  `room_id` varchar(55) NOT NULL,
  `type` varchar(55) NOT NULL,
  `type_id` varchar(55) NOT NULL,
  `bab_id` int(11) NOT NULL,
  `sub_bab_id` int(11) NOT NULL,
  `mapel_id` int(11) DEFAULT NULL,
  `passed` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_bab_user`
--

INSERT INTO `sub_bab_user` (`id`, `user_id`, `room_id`, `type`, `type_id`, `bab_id`, `sub_bab_id`, `mapel_id`, `passed`, `created_at`) VALUES
(1, 'WI6cWjT7WOj67gwQ', '9', 'Materi', 'jrXOCz2x', 1, 1, 2, 0, '2021-09-29 08:26:55'),
(2, 'WI6cWjT7WOj67gwQ', '9', 'materi', '3rzbzxl5', 1, 2, 2, 0, '2021-09-29 08:32:36'),
(3, 'WI6cWjT7WOj67gwQ', 'YVuoE6', 'tugas', 'wQPuwTZa', 1, 3, 2, 1, '2021-09-29 08:41:04'),
(4, 'WI6cWjT7WOj67gwQ', '9', 'quiz', 'ZhtZ8CJb', 1, 4, 2, 0, '2021-09-29 09:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `tblhari`
--

CREATE TABLE `tblhari` (
  `id` int(11) NOT NULL,
  `namahari` varchar(255) NOT NULL,
  `days` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblhari`
--

INSERT INTO `tblhari` (`id`, `namahari`, `days`) VALUES
(1, 'senin', 'monday'),
(2, 'selasa', 'tuesday'),
(3, 'rabu', 'wednesday'),
(4, 'kamis', 'thursday'),
(5, 'jumat', 'friday'),
(6, 'sabtu', 'saturday'),
(7, 'minggu', 'sunday');

-- --------------------------------------------------------

--
-- Table structure for table `tblmapel`
--

CREATE TABLE `tblmapel` (
  `id` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `inisial` varchar(50) DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = ya, 0 = tidak'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmapel`
--

INSERT INTO `tblmapel` (`id`, `id_mapel`, `nama`, `inisial`, `aktif`) VALUES
(1, 1, 'Matematika', 'MTK', 1),
(2, 2, 'Bahasa Indonesia', 'BIN', 1),
(3, 3, 'Bahasa Inggris', 'BING', 1),
(4, 4, 'Kewarganegaraan', 'PKN', 1),
(5, 5, 'Bahasa Jawa', 'BJW', 1),
(6, 6, 'Fisika', 'FIS', 1),
(7, 7, 'Biologi', 'BIO', 1),
(10, 8, 'Seni Budaya', 'SBD', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblmapel22`
--

CREATE TABLE `tblmapel22` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL DEFAULT 30000,
  `info` text DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = ya, 0 = tidak'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmapel22`
--

INSERT INTO `tblmapel22` (`id`, `nama`, `harga`, `info`, `aktif`) VALUES
(1, 'Matematika', 30000, NULL, 1),
(2, 'Bahasa Indonesia', 30000, NULL, 1),
(3, 'Bahasa Inggris', 30000, NULL, 1),
(4, 'Kewarganegaraan', 30000, NULL, 1),
(5, 'Bahasa Jawa', 30000, NULL, 1),
(6, 'Fisika', 30000, NULL, 1),
(7, 'Biologi', 30000, NULL, 1),
(8, 'Seni Budaya', 30000, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `a` int(11) NOT NULL,
  `b` time NOT NULL,
  `c` time NOT NULL,
  `0` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `a`, `b`, `c`, `0`) VALUES
(1, 1, '13:00:00', '13:45:00', NULL),
(2, 2, '13:45:00', '14:30:00', NULL),
(3, 3, '14:30:00', '15:15:00', NULL),
(4, 4, '15:15:00', '16:00:00', NULL),
(5, 5, '16:00:00', '16:45:00', NULL),
(6, 6, '16:45:00', '17:30:00', NULL),
(7, 7, '17:30:00', '18:15:00', NULL),
(8, 8, '18:15:00', '19:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE `testimoni` (
  `id` int(11) NOT NULL,
  `feedback_id` varchar(55) NOT NULL,
  `user_id` varchar(55) NOT NULL,
  `testimoni` text NOT NULL,
  `room_id` varchar(55) NOT NULL,
  `star` varchar(55) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0:kelas, 1:kursus',
  `publish_status` enum('0','1') NOT NULL,
  `anonymous` varchar(50) DEFAULT '0',
  `image` varchar(100) DEFAULT NULL,
  `read_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimoni`
--

INSERT INTO `testimoni` (`id`, `feedback_id`, `user_id`, `testimoni`, `room_id`, `star`, `type`, `publish_status`, `anonymous`, `image`, `read_status`, `created_at`) VALUES
(2, 'oistc03K', 'WI6cWjT7WOj67gwQ', 'sangat menyenangkan', 'YVuoE6', '4', 0, '1', NULL, NULL, 0, '2021-10-04 06:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni_lampiran`
--

CREATE TABLE `testimoni_lampiran` (
  `id` int(11) NOT NULL,
  `feedback_id` varchar(55) NOT NULL,
  `lampiran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test_register`
--

CREATE TABLE `test_register` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `verification_hash` text DEFAULT NULL,
  `verify` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_register`
--

INSERT INTO `test_register` (`id`, `email`, `password`, `verification_hash`, `verify`) VALUES
(1, 'randombox38@gmail.com', '$2y$10$9Lw.F177qasyc9NA9w4JWuPTMlCd0ZN93eLfOyySC9f62szzNuWwW', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id` int(11) NOT NULL,
  `tugas_id` varchar(55) NOT NULL,
  `tugas_name` text NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `tugas_konten` longtext NOT NULL,
  `deadline` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `del_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id`, `tugas_id`, `tugas_name`, `user_id`, `tugas_konten`, `deadline`, `del_status`, `created_at`, `update_at`) VALUES
(1, 'LikxgSRX', 'tugas untuk semuanya', 'Q10pwu6Z', '<h1 itemprop=\"name\"><a href=\"https://stackoverflow.com/questions/16452699/how-to-reset-a-form-using-jquery-with-reset-method\">How to reset a form using jQuery with .reset() method</a>?</h1>', '2021-04-27 07:05:52', 0, '2021-04-27 07:03:51', '2021-04-27 07:03:51'),
(2, 'ysKgH5E6', 'Starter Kits', 'Q10pwu6Z', '<p>To give you a head start building your new Laravel application, we are happy to offer authentication and application starter kits. These kits automatically scaffold your application with the routes, controllers, and views you need to register and authenticate your application&#39;s users.</p>', '2021-06-01 15:51:00', 0, '2021-05-08 09:51:49', '2021-05-08 09:51:49'),
(3, 'bRZG58EZ', 'How can I pause setInterval() functions?', 'Q10pwu6Z', '<p>How do I pause and resume the setInterval() function using Javascript?</p>\r\n\r\n<p>For example, maybe I have a stopwatch to tell you the number of seconds that you have been looking at the webpage. There is a &#39;Pause&#39; and &#39;Resume&#39; button. The reason why&nbsp;<strong>clearInterval() would not work here</strong>&nbsp;is because if the user clicks on the &#39;Pause&#39; button at the 40th second and 800th millisecond, when he clicks on the &#39;Resume&#39; button, the number of seconds elapsed must increase by 1 after 200 milliseconds. If I use the clearInterval() function on the timer variable (when the pause button is clicked) and then using the setInterval() function on the timer variable again (when the resume button is clicked), the number of seconds elapsed will increase by 1 only after 1000 milliseconds, which destroys the accuracy of the stopwatch.</p>', '2021-06-05 15:52:00', 0, '2021-05-08 09:52:57', '2021-05-08 09:52:57'),
(4, '0lOZenyD', 'tugas pertama 1', 'ulZI5INb', '<p>Laravel will use the name of the migration to attempt to guess the name of the table and whether or not the migration will be creating a new table. If Laravel is able to determine the table name from the migration name, Laravel will pre-fill the generated migration file with the specified table. Otherwise, you may simply specify the table in the migration file manually.</p>', '2021-05-25 07:00:00', 0, '2021-05-24 06:01:03', '2021-05-24 06:01:03'),
(5, '20pqtiVl', 'Tugas untuk database migration', 'ulZI5INb', '<p>Buat database migration lalu upload&nbsp;</p>', '2021-05-26 09:46:00', 0, '2021-05-24 09:46:14', '2021-05-24 09:46:14'),
(6, 'ZpjnsWXo', 'Tugas untuk database migration', 'ulZI5INb', '<p>Buat database migration lalu upload&nbsp;</p>', '2021-08-26 01:00:18', 1, '2021-05-24 09:46:14', '2021-05-24 09:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_submit`
--

CREATE TABLE `tugas_submit` (
  `id` int(11) NOT NULL,
  `submit_id` varchar(55) NOT NULL,
  `tugas_id` varchar(55) NOT NULL,
  `room_id` varchar(55) NOT NULL,
  `user_id` varchar(55) NOT NULL,
  `comments` text DEFAULT NULL,
  `submission_status` int(11) NOT NULL DEFAULT 1,
  `nilai` int(11) DEFAULT NULL,
  `t_comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tugas_submit`
--

INSERT INTO `tugas_submit` (`id`, `submit_id`, `tugas_id`, `room_id`, `user_id`, `comments`, `submission_status`, `nilai`, `t_comment`, `created_at`) VALUES
(1, 'gObc7pI1Nrg5ltMa', 'DXWvzSqT', '1mt5nn', 'AlLwVCmEgC9xBPhP', 'tugas saya', 1, 80, '<p>Harap diberikan komentar yang relevan dengan gambar yang kamu kirimkan</p>', '2021-09-21 08:31:53'),
(2, 'HZSD7U2Xz3OeArZa', 'xl880PgB', '1mt5nn', 'AlLwVCmEgC9xBPhP', 'awokawok', 1, 90, NULL, '2021-09-22 05:42:05'),
(3, 'O9fE3Opoz1zc1Wz5', 'ILsirmll', 'i8344c', 'AlLwVCmEgC9xBPhP', NULL, 1, NULL, NULL, '2021-09-25 08:43:44'),
(4, '4QLBKsihMDs0AjdO', 'wQPuwTZa', 'YVuoE6', 'WI6cWjT7WOj67gwQ', NULL, 1, NULL, NULL, '2021-09-29 08:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_submit_attachment`
--

CREATE TABLE `tugas_submit_attachment` (
  `id` int(11) NOT NULL,
  `submit_id` varchar(55) NOT NULL,
  `user_id` varchar(55) NOT NULL,
  `tugas_id` varchar(55) NOT NULL,
  `attachment_name` text NOT NULL,
  `attachmentOriginalName` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tugas_submit_attachment`
--

INSERT INTO `tugas_submit_attachment` (`id`, `submit_id`, `user_id`, `tugas_id`, `attachment_name`, `attachmentOriginalName`, `created_at`) VALUES
(1, 'gObc7pI1Nrg5ltMa', 'AlLwVCmEgC9xBPhP', 'DXWvzSqT', 'cuHP9ridJWlduIcrtbBIOLOGI.png', 'BIOLOGI.png', '2021-09-21 08:31:53'),
(2, 'HZSD7U2Xz3OeArZa', 'AlLwVCmEgC9xBPhP', 'xl880PgB', 'UzYwXg7zyE3qQnqnnAEKONOMI.png', 'EKONOMI.png', '2021-09-22 05:42:05'),
(3, 'O9fE3Opoz1zc1Wz5', 'AlLwVCmEgC9xBPhP', 'ILsirmll', 'GI00mBMPCmk2mwDAEqPJOK.png', 'PJOK.png', '2021-09-25 08:43:44'),
(4, '4QLBKsihMDs0AjdO', 'WI6cWjT7WOj67gwQ', 'wQPuwTZa', '0cuGTPCfcRgE4AdgINRjkWI6cWjT7WOj67gwQBIOLOGI.png', 'RjkWI6cWjT7WOj67gwQBIOLOGI.png', '2021-09-29 08:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `partner_type` int(11) NOT NULL,
  `partner_id` varchar(55) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `partner_type` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verify` int(11) NOT NULL DEFAULT 0,
  `verification_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `user_kuota` int(11) NOT NULL DEFAULT 50,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `partner_id`, `partner_type`, `name`, `email`, `verify`, `verification_token`, `email_verified_at`, `user_kuota`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'ulZI5INb', 1, 'zega', 'guru@email.com', 1, '', NULL, 20, '$2y$10$tmlo.wpms17XZ6DfGg4HjuPRw.C/fH4gZ7kgZwXt//Rh1sz5V8VLO', NULL, '2021-05-22 00:06:50', '2021-05-22 00:06:50'),
(5, 'AsmF7LKC', 1, 'ayu', 'ayuridhani66@gmail.com', 1, '', NULL, 50, '$2y$10$FL2bIOLXn6uDvImyE12A9.0RHXp8NTx.JXG/dp.hDXC0cx1J.w2Le', NULL, '2021-07-02 02:49:50', '2021-07-02 02:49:50'),
(6, 'SHob4PyA', 1, 'andi', 'andi@email.com', 0, '', NULL, 50, '$2y$10$BszXicmVUg3kYPuoiQmrUOcS/qV58kCa8E/wEjp1EZx4sOO0tb3OO', NULL, NULL, NULL),
(7, '6Ue6z5Rr', 1, 'Agus Kotak', 'rinorinounp@gmail.com', 1, '', NULL, 50, '$2y$10$zt7.eH4svrW7dv2KCEvwEOD9Lkq/NmPfaARyLEYuCzIYhL/iUIt8G', NULL, NULL, NULL),
(9, 'WI6cWjT7WOj67gwQ', 2, 'jega', 'xegalol@gmail.com', 1, NULL, NULL, 50, '$2y$10$h2FS6GBbxNBUjPcr/Isp1Ohl0fhJIyK9VvI7YPQSgkcQjHRKU3LmS', NULL, '2021-07-28 02:48:48', '2021-07-28 02:48:48'),
(10, 'E8FqKdRB', 1, 'Rafli', 'rafli.student@gmail.com', 1, NULL, NULL, 50, '$2y$10$1x3xSCbmbVcE.iVvpz2LHu4LTKan5RYngm5VFyBcxGLwg375xWSVy', NULL, '2021-07-28 02:54:20', '2021-07-28 02:54:20'),
(11, 'ZovrKpzeljwa5Z6j', 2, 'budi', 'budi@astar.com', 1, '$2y$10$uhB5ifTZ4p.GVDQC2ceU2ud32HoTuQwgphPWGVfFqpaaBrpsAE1hO', NULL, 50, '$2y$10$qNcqXOuvfw.mYN3XppI/3O2gJWlZ3ULCvnFzeoI81JEzt5b7nUlDi', NULL, '2021-07-31 02:01:20', '2021-07-31 02:01:20'),
(12, 'eVPOqrgqZYhIbTpa', 2, 'adi', 'rinorinounp@mail.com', 1, '$2y$10$ZGE24LT1VUyHTW8NsWMlaOlOroFknBxKS1Mlit.idTDkNoyCbOP8C', NULL, 50, '$2y$10$tmlo.wpms17XZ6DfGg4HjuPRw.C/fH4gZ7kgZwXt//Rh1sz5V8VLO', NULL, '2021-08-02 01:19:32', '2021-08-02 01:19:32'),
(13, '0e4mbFZA', 2, 'Toni', 'tam@gmail.com', 1, NULL, NULL, 50, '$2y$10$UkR2HMMvErRvmruk2pKaq.Fig.MU8790iWpKM7l7G1zityPt7DUgq', NULL, NULL, NULL),
(16, 'M63STrx1', 2, 'Joni', 'fauzytamimkdr@gmail.com', 1, NULL, NULL, 50, '$2y$10$PpdjO/RRRXAU2Zsf70hTre4uHepZ/N/HznrKW1Kt29pjHlCiqV9BK', NULL, NULL, NULL),
(25, '4TPVDZ4K', 2, 'Burhan', 'efef@gmail.com', 1, NULL, NULL, 50, '$2y$10$EtkobQisgL27kMiqZI0PiuSmhoAzY/zuiwAXQvG6H5Q3ijiDzs.pO', NULL, NULL, NULL),
(39, 'tAZFSZNl', 1, 'aa', 'admin@gmail.com', 1, NULL, NULL, 50, '$2y$10$z/4.jTXLqLK9nKwvRtDvnuTAJTdP/7fwfmjdftxFRvWmPhPYsMyza', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `id` int(11) NOT NULL,
  `user_id` varchar(55) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `first_name` varchar(55) DEFAULT NULL,
  `last_name` varchar(55) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `b_date` date DEFAULT NULL,
  `b_place` varchar(55) DEFAULT NULL,
  `parent_name` varchar(50) NOT NULL,
  `parent_phone` varchar(50) NOT NULL,
  `parent_job` varchar(50) NOT NULL,
  `f_profile` varchar(255) DEFAULT 'public/image/profile/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_detail`
--

INSERT INTO `user_detail` (`id`, `user_id`, `status`, `jenis_kelamin`, `username`, `phone`, `first_name`, `last_name`, `address`, `b_date`, `b_place`, `parent_name`, `parent_phone`, `parent_job`, `f_profile`) VALUES
(2, 'gewbjo12', 0, 'L', 'budi', '081252867991', 'Budi', 'anak ibu budi', 'blitar', '2021-08-01', 'blitar', '', '', '', 'public/image/profile/ZovrKpzeljwa5Z6j.png'),
(3, 'Q10pwu6Z', 0, 'L', 'budi', '081252867991', 'Budi', 'anak ibu budi', 'blitar', '2021-08-01', 'blitar', '', '', '', 'public/image/profile/ZovrKpzeljwa5Z6j.png'),
(4, '0e4mbFZA', 0, 'L', 'budi', '081252867991', 'Budi', 'anak ibu budi', 'blitar', '2021-08-01', 'blitar', '', '', '', 'public/image/profile/ZovrKpzeljwa5Z6j.png'),
(5, 'M63STrx1', 0, 'L', 'budi', '081252867991', 'Budi', 'anak ibu budi', 'blitar', '2021-08-01', 'blitar', '', '', '', 'public/image/profile/ZovrKpzeljwa5Z6j.png'),
(6, '4TPVDZ4K', 0, 'L', 'budi', '081252867991', 'Budi', 'anak ibu budi', 'blitar', '2021-08-01', 'blitar', '', '', '', 'public/image/profile/ZovrKpzeljwa5Z6j.png'),
(7, 'WI6cWjT7WOj67gwQ', 0, 'L', 'budi', '081252867991', 'Budi', 'anak ibu budi', 'blitar', '2021-08-01', 'blitar', 'Suwito', '081222333444', 'Pedagang', 'public/image/profile/qVKu98iBWI6cWjT7WOj67gwQSEJARAH.png'),
(8, 'eVPOqrgqZYhIbTpa', 0, 'L', 'budi', '081252867991', 'Budi', 'anak ibu budi', 'blitar', '2021-08-01', 'blitar', 'Joko', '012345678', 'Petani', 'public/image/profile/ZovrKpzeljwa5Z6j.png'),
(14, 'ZovrKpzeljwa5Z6j', 0, 'L', 'budi', '081252867991', 'Budi', 'anak ibu budi', 'blitar', '2021-08-01', 'blitar', 'Komari', '0855544777', 'Tukang', 'public/image/profile/ZovrKpzeljwa5Z6j.png');

-- --------------------------------------------------------

--
-- Table structure for table `video_conference`
--

CREATE TABLE `video_conference` (
  `id` int(11) NOT NULL,
  `meet_id` varchar(16) NOT NULL,
  `title` text NOT NULL,
  `url` text NOT NULL,
  `tanggal` date NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `room_id` varchar(55) NOT NULL,
  `jam` int(11) NOT NULL,
  `owner_id` varchar(55) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `passed` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `video_conference`
--

INSERT INTO `video_conference` (`id`, `meet_id`, `title`, `url`, `tanggal`, `schedule_id`, `room_id`, `jam`, `owner_id`, `status`, `passed`, `created_at`) VALUES
(1, 'iPEfeMh2VxqROFFm', '', '', '0000-00-00', 5, 'qbw2N9', 2, 'ulZI5INb', 0, 0, '2021-09-11 06:17:37'),
(2, 'AZ5AeJiDrJgWIqyR', 'tatap muka ke-12', 'https://stackoverflow.com/questions/12137033/load-external-url-into-modal-jquery-ui-dialog', '2021-09-16', 5, 'qbw2N9', 0, 'ulZI5INb', 0, 0, '2021-09-11 06:47:18'),
(12, 'QrSNG4ftK2K0ztJe', 'tatap muka pertamax', 'https://laravel.com/docs/8.x/urls#generating-urls', '2021-09-11', 3, 'qbw2N9', 0, 'ulZI5INb', 0, 0, '2021-09-11 07:42:43'),
(13, 'DoKBCvhIKgIitGQI', 'Perkenalan', 'https://getbootstrap.com/docs/4.0/components/tooltips/', '2021-09-11', 1, 'qbw2N9', 0, 'ulZI5INb', 0, 0, '2021-09-11 09:30:20'),
(16, 'atpLszAnu2maBXli', 'tatap muka ke-1', 'https://spark.bootlab.io/dashboard-default.html?theme=dark#', '2021-09-15', 2, 'qbw2N9', 0, 'ulZI5INb', 0, 0, '2021-09-14 05:25:11'),
(17, 'mmJpm9Lqxp9dbpQW', 'tatap muka ke-2', 'https://spark.bootlab.io/dashboard-default.html?theme=dark#', '2021-09-23', 3, 'qbw2N9', 0, 'ulZI5INb', 0, 0, '2021-09-14 08:58:04'),
(22, 'bdrd6VmMTweEdvA2', 'perkenalan', 'https://www.youtube.com/', '2021-09-22', 1, '1mt5nn', 0, 'AsmF7LKC', 0, 0, '2021-09-22 04:47:36'),
(23, 'Tcx8hxqbQogCbcr7', 'tatap muka pertamax', 'https://apps.google.com/meet/', '2021-09-25', NULL, 'gWcBbu', 1, 'ulZI5INb', 0, 0, '2021-09-23 07:04:08'),
(25, 'R9IGqnwxB8uXxbxq', 'Judul Pertama boy', 'https://apps.google.com/meet/', '2021-09-24', NULL, 'gWcBbu', 4, 'SHob4PyA', 0, 0, '2021-09-23 07:42:39'),
(44, '84125422308', 'Mencoba oioi', 'https://us05web.zoom.us/j/84125422308?pwd=dDRRckxnWERndWtvYTlQR09QZE43Zz09', '2021-11-24', NULL, 'Hb1TGu', 3, 'AsmF7LKC', 0, 0, '2021-11-23 07:38:08'),
(45, '82392050569', 'Testing', 'https://us05web.zoom.us/j/82392050569?pwd=cFB6cGVObDl4T0xZRXpkVi9hemRKUT09', '2021-11-27', NULL, 'Hb1TGu', 1, 'SHob4PyA', 0, 0, '2021-11-26 07:46:52'),
(47, '82608369077', 'Belajarar Algoritma', 'https://us05web.zoom.us/j/82608369077?pwd=NmhseFQ0ZlAvcjBFMU1Ia3NHb0lRdz09', '2021-12-08', NULL, 'Hb1TGu', 5, '6Ue6z5Rr', 0, 0, '2021-12-08 07:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `video_conference_presensi`
--

CREATE TABLE `video_conference_presensi` (
  `id` int(11) NOT NULL,
  `v_conf_id` varchar(55) NOT NULL,
  `participant` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`participant`)),
  `status` int(11) NOT NULL DEFAULT 1,
  `ss` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `video_conference_presensi`
--

INSERT INTO `video_conference_presensi` (`id`, `v_conf_id`, `participant`, `status`, `ss`, `created_at`) VALUES
(1, 'ECF7ouLcTD1tSHpm', '[{\"name\":\"E8FqKdRB\"},{\"name\":\"gewbjo12\"}]', 0, NULL, '2021-05-08 06:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `zoom_video`
--

CREATE TABLE `zoom_video` (
  `id` int(11) NOT NULL,
  `pertemuan` int(11) NOT NULL,
  `meet_id` text DEFAULT NULL,
  `occurrence_id` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `duration` varchar(11) NOT NULL,
  `id_jadwal` varchar(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zoom_video`
--

INSERT INTO `zoom_video` (`id`, `pertemuan`, `meet_id`, `occurrence_id`, `url`, `start_time`, `duration`, `id_jadwal`, `status`) VALUES
(23, 1, '86825206131', '1638684000000', 'https://us05web.zoom.us/j/86825206131?pwd=N3J6c0Fyb0tnTHU4b3BJak1kUytoUT09', '2021-12-05 13:00:00', '45', 'qIMWe7', 0),
(24, 2, '86825206131', '1639288800000', 'https://us05web.zoom.us/j/86825206131?pwd=N3J6c0Fyb0tnTHU4b3BJak1kUytoUT09', '2021-12-12 13:00:00', '45', 'qIMWe7', 0),
(25, 3, '86825206131', '1639893600000', 'https://us05web.zoom.us/j/86825206131?pwd=N3J6c0Fyb0tnTHU4b3BJak1kUytoUT09', '2021-12-19 13:00:00', '45', 'qIMWe7', 0),
(39, 1, '89720509507', '1638781200000', 'https://us05web.zoom.us/j/89720509507?pwd=bEpXaWJudjZWRksyNk5lL1owUUdBQT09', '2021-12-06 16:00:00', '45', 'esH1gJ', 0),
(40, 2, '89720509507', '1639386000000', 'https://us05web.zoom.us/j/89720509507?pwd=bEpXaWJudjZWRksyNk5lL1owUUdBQT09', '2021-12-13 16:00:00', '45', 'esH1gJ', 0),
(42, 1, '84704785482', '1639029600000', 'https://us05web.zoom.us/j/84704785482?pwd=OS9aNzM2T0w0MkhpdzFCODZjSHhlZz09', '2021-12-09 13:00:00', '45', 'R6uz4M', 0),
(43, 2, '84704785482', '1639634400000', 'https://us05web.zoom.us/j/84704785482?pwd=OS9aNzM2T0w0MkhpdzFCODZjSHhlZz09', '2021-12-16 13:00:00', '45', 'R6uz4M', 0),
(44, 1, '88193535354', '1639285020000', 'https://us05web.zoom.us/j/88193535354?pwd=YTZKQjlFdlE4bGRydi93NnQ1QzhXQT09', '2021-12-12 11:57:00', '45', 'PVRuSi', 0),
(45, 2, '88193535354', '1639889820000', 'https://us05web.zoom.us/j/88193535354?pwd=YTZKQjlFdlE4bGRydi93NnQ1QzhXQT09', '2021-12-19 11:57:00', '45', 'PVRuSi', 0),
(46, 3, '88193535354', '1640494620000', 'https://us05web.zoom.us/j/88193535354?pwd=YTZKQjlFdlE4bGRydi93NnQ1QzhXQT09', '2021-12-26 11:57:00', '45', 'PVRuSi', 0),
(47, 1, '84921671498', '1638766980000', 'https://us05web.zoom.us/j/84921671498?pwd=UzJsdFVHd3V1QkxURUtCa3FWN2t2dz09', '2021-12-08 13:00:00', '45', 'TgMhOd', 0),
(48, 2, '84921671498', '1639371780000', 'https://us05web.zoom.us/j/84921671498?pwd=UzJsdFVHd3V1QkxURUtCa3FWN2t2dz09', '2021-12-13 13:00:00', '45', 'TgMhOd', 0),
(49, 3, '84921671498', '1639976580000', 'https://us05web.zoom.us/j/84921671498?pwd=UzJsdFVHd3V1QkxURUtCa3FWN2t2dz09', '2021-12-20 13:00:00', '45', 'TgMhOd', 0),
(50, 1, '84911433808', '1639469700000', 'https://us05web.zoom.us/j/84911433808?pwd=WXdMdDF5R3BsQnJwSUp3YXE3OC9nZz09', '2021-12-14 15:15:00', '45', 'Koygrd', 0),
(51, 2, '84911433808', '1640074500000', 'https://us05web.zoom.us/j/84911433808?pwd=WXdMdDF5R3BsQnJwSUp3YXE3OC9nZz09', '2021-12-21 15:15:00', '45', 'Koygrd', 0),
(52, 3, '84911433808', '1640679300000', 'https://us05web.zoom.us/j/84911433808?pwd=WXdMdDF5R3BsQnJwSUp3YXE3OC9nZz09', '2021-12-28 15:15:00', '45', 'Koygrd', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atur_jam`
--
ALTER TABLE `atur_jam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_jam`
--
ALTER TABLE `a_jam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bab`
--
ALTER TABLE `bab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coba`
--
ALTER TABLE `coba`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coba_materi`
--
ALTER TABLE `coba_materi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coba_materi_history`
--
ALTER TABLE `coba_materi_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coba_materi_lampiran`
--
ALTER TABLE `coba_materi_lampiran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coba_quiz_question`
--
ALTER TABLE `coba_quiz_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coba_tugas`
--
ALTER TABLE `coba_tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coba_tugas_lampiran`
--
ALTER TABLE `coba_tugas_lampiran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_jenjang`
--
ALTER TABLE `db_jenjang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_pengajar`
--
ALTER TABLE `detail_pengajar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faq_category`
--
ALTER TABLE `faq_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_question`
--
ALTER TABLE `faq_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `index_html`
--
ALTER TABLE `index_html`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kursus_spv`
--
ALTER TABLE `kursus_spv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapel_kelas`
--
ALTER TABLE `mapel_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapel_pengajar`
--
ALTER TABLE `mapel_pengajar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi_room`
--
ALTER TABLE `materi_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi_user`
--
ALTER TABLE `materi_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partnership`
--
ALTER TABLE `partnership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_option`
--
ALTER TABLE `quiz_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_question_attachment`
--
ALTER TABLE `quiz_question_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_user`
--
ALTER TABLE `quiz_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_user`
--
ALTER TABLE `room_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_user_mapel`
--
ALTER TABLE `room_user_mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_bab`
--
ALTER TABLE `sub_bab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_bab_user`
--
ALTER TABLE `sub_bab_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblhari`
--
ALTER TABLE `tblhari`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmapel`
--
ALTER TABLE `tblmapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmapel22`
--
ALTER TABLE `tblmapel22`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimoni_lampiran`
--
ALTER TABLE `testimoni_lampiran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_register`
--
ALTER TABLE `test_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas_submit`
--
ALTER TABLE `tugas_submit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas_submit_attachment`
--
ALTER TABLE `tugas_submit_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_conference`
--
ALTER TABLE `video_conference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_conference_presensi`
--
ALTER TABLE `video_conference_presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zoom_video`
--
ALTER TABLE `zoom_video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `atur_jam`
--
ALTER TABLE `atur_jam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `a_jam`
--
ALTER TABLE `a_jam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bab`
--
ALTER TABLE `bab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `coba`
--
ALTER TABLE `coba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `coba_materi`
--
ALTER TABLE `coba_materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `coba_materi_history`
--
ALTER TABLE `coba_materi_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `coba_materi_lampiran`
--
ALTER TABLE `coba_materi_lampiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coba_quiz_question`
--
ALTER TABLE `coba_quiz_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coba_tugas`
--
ALTER TABLE `coba_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `coba_tugas_lampiran`
--
ALTER TABLE `coba_tugas_lampiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `db_jenjang`
--
ALTER TABLE `db_jenjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `detail_pengajar`
--
ALTER TABLE `detail_pengajar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_category`
--
ALTER TABLE `faq_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `faq_question`
--
ALTER TABLE `faq_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `index_html`
--
ALTER TABLE `index_html`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `kursus_spv`
--
ALTER TABLE `kursus_spv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mapel_kelas`
--
ALTER TABLE `mapel_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `mapel_pengajar`
--
ALTER TABLE `mapel_pengajar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `materi_room`
--
ALTER TABLE `materi_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `materi_user`
--
ALTER TABLE `materi_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `partner`
--
ALTER TABLE `partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `partnership`
--
ALTER TABLE `partnership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quiz_option`
--
ALTER TABLE `quiz_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `quiz_question_attachment`
--
ALTER TABLE `quiz_question_attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_user`
--
ALTER TABLE `quiz_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_user`
--
ALTER TABLE `room_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `room_user_mapel`
--
ALTER TABLE `room_user_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_bab`
--
ALTER TABLE `sub_bab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `sub_bab_user`
--
ALTER TABLE `sub_bab_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblhari`
--
ALTER TABLE `tblhari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblmapel`
--
ALTER TABLE `tblmapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblmapel22`
--
ALTER TABLE `tblmapel22`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testimoni_lampiran`
--
ALTER TABLE `testimoni_lampiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_register`
--
ALTER TABLE `test_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tugas_submit`
--
ALTER TABLE `tugas_submit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tugas_submit_attachment`
--
ALTER TABLE `tugas_submit_attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user_detail`
--
ALTER TABLE `user_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `video_conference`
--
ALTER TABLE `video_conference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `video_conference_presensi`
--
ALTER TABLE `video_conference_presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zoom_video`
--
ALTER TABLE `zoom_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
