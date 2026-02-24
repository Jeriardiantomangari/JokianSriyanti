-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 24 Feb 2026 pada 17.32
-- Versi server: 8.4.3
-- Versi PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `db_sistempakar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `foto`) VALUES
(1, 'okedang', 'admin', 'admin123', '1767587929_a-desktop-inspired-by-undertale-yvx1xu3y1ern16e1.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aturan`
--

CREATE TABLE `aturan` (
  `id_aturan` int NOT NULL,
  `id_gangguan` int NOT NULL,
  `id_gejala` int NOT NULL,
  `nilai_mb` float NOT NULL,
  `nilai_md` float NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `aturan`
--

INSERT INTO `aturan` (`id_aturan`, `id_gangguan`, `id_gejala`, `nilai_mb`, `nilai_md`, `bobot`) VALUES
(4, 11, 6, 0.4, 0.1, 0.3),
(5, 11, 7, 0.4, 0.2, 0.2),
(6, 11, 8, 0.5, 0.2, 0.3),
(7, 11, 9, 0.5, 0.1, 0.4),
(8, 11, 10, 0.5, 0.3, 0.2),
(9, 11, 11, 1, 0, 1),
(10, 11, 12, 0.8, 0, 0.8),
(11, 11, 13, 0.9, 0, 0.9),
(12, 11, 14, 0.5, 0.1, 0.4),
(13, 11, 15, 1, 0, 1),
(14, 11, 21, 0.5, 0.1, 0.4),
(15, 11, 40, 0.6, 0.1, 0.5),
(16, 11, 41, 0.4, 0.1, 0.3),
(17, 11, 47, 0.3, 0.1, 0.2),
(18, 11, 50, 0.5, 0.2, 0.3),
(19, 12, 8, 0.4, 0.2, 0.2),
(20, 12, 10, 0.4, 0.1, 0.3),
(21, 12, 16, 0.4, 0.1, 0.3),
(22, 12, 17, 0.6, 0.1, 0.5),
(23, 12, 18, 0.3, 0.1, 0.2),
(24, 12, 19, 0.8, 0, 0.8),
(25, 12, 20, 0.6, 0.1, 0.5),
(26, 12, 21, 0.6, 0.1, 0.5),
(27, 12, 22, 0.5, 0.1, 0.4),
(28, 12, 23, 0.7, 0, 0.7),
(29, 12, 24, 1, 0, 1),
(30, 12, 30, 0.6, 0.3, 0.3),
(31, 12, 36, 0.7, 0, 0.7),
(32, 13, 26, 0.6, 0.1, 0.5),
(33, 13, 27, 0.3, 0.1, 0.2),
(34, 13, 28, 0.3, 0.1, 0.2),
(35, 13, 29, 0.5, 0.1, 0.4),
(36, 13, 30, 0.4, 0.2, 0.2),
(37, 13, 31, 0.5, 0.1, 0.4),
(38, 13, 32, 0.3, 0.1, 0.2),
(39, 13, 33, 0.3, 0.1, 0.2),
(40, 13, 34, 0.8, 0, 0.8),
(41, 13, 35, 1, 0, 1),
(42, 14, 8, 0.4, 0.2, 0.2),
(43, 14, 12, 0.6, 0.2, 0.4),
(44, 14, 14, 0.6, 0.2, 0.4),
(45, 14, 19, 0.5, 0.2, 0.3),
(46, 14, 21, 0.6, 0.2, 0.4),
(47, 14, 22, 0.6, 0.1, 0.5),
(48, 14, 24, 0.8, 0, 0.8),
(49, 14, 36, 0.4, 0.2, 0.2),
(50, 14, 37, 0.7, 0, 0.7),
(51, 14, 38, 0.4, 0.1, 0.3),
(52, 14, 39, 0.7, 0, 0.7),
(53, 14, 40, 0.5, 0.2, 0.3),
(54, 14, 41, 0.5, 0.2, 0.3),
(55, 14, 42, 0.9, 0, 0.9),
(56, 14, 43, 1, 0, 1),
(57, 15, 7, 0.5, 0.2, 0.3),
(58, 15, 44, 0.7, 0, 0.7),
(59, 15, 45, 0.6, 0.1, 0.5),
(60, 15, 46, 0.4, 0.1, 0.3),
(61, 15, 47, 0.4, 0.1, 0.3),
(62, 15, 48, 0.7, 0, 0.7),
(63, 15, 49, 0.3, 0.1, 0.2),
(64, 15, 50, 0.6, 0.1, 0.5),
(65, 15, 51, 1, 0, 1),
(66, 16, 10, 0.6, 0.1, 0.5),
(67, 16, 18, 0.4, 0.2, 0.2),
(68, 16, 52, 0.5, 0.2, 0.3),
(69, 16, 53, 0.3, 0.1, 0.2),
(70, 16, 54, 0.4, 0.1, 0.3),
(71, 16, 55, 0.7, 0, 0.7),
(72, 16, 56, 0.8, 0, 0.8),
(73, 16, 57, 0.6, 0.1, 0.5),
(74, 17, 8, 0.5, 0.1, 0.4),
(75, 17, 10, 0.5, 0.2, 0.3),
(76, 17, 27, 0.3, 0.1, 0.2),
(77, 17, 28, 0.3, 0.1, 0.2),
(78, 17, 30, 0.4, 0.2, 0.2),
(79, 17, 41, 0.4, 0.1, 0.3),
(80, 17, 52, 0.4, 0.1, 0.3),
(81, 17, 58, 0.8, 0, 0.8),
(82, 17, 59, 0.5, 0.1, 0.4),
(83, 17, 60, 0.7, 0, 0.7),
(84, 17, 61, 0.4, 0.2, 0.2),
(85, 17, 62, 1, 0, 1),
(86, 17, 63, 0.8, 0, 0.8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cf_gangguan`
--

CREATE TABLE `cf_gangguan` (
  `id_cf_gangguan` int NOT NULL,
  `id_konsultasi` int NOT NULL,
  `id_gangguan` int NOT NULL,
  `nilai_cf_total` decimal(8,6) NOT NULL,
  `persentase` decimal(6,2) NOT NULL,
  `kategori` enum('Ringan','Sedang','Berat') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `cf_gangguan`
--

INSERT INTO `cf_gangguan` (`id_cf_gangguan`, `id_konsultasi`, `id_gangguan`, `nilai_cf_total`, `persentase`, `kategori`) VALUES
(196, 51, 12, 0.535799, 53.58, 'Sedang'),
(197, 51, 17, 0.530415, 53.04, 'Sedang'),
(198, 51, 14, 0.524511, 52.45, 'Sedang'),
(199, 51, 15, 0.448850, 44.89, 'Sedang'),
(200, 51, 11, 0.440066, 44.01, 'Sedang'),
(201, 51, 13, 0.321702, 32.17, 'Ringan'),
(202, 51, 16, 0.223936, 22.39, 'Ringan'),
(203, 52, 14, 0.632969, 63.30, 'Sedang'),
(204, 52, 11, 0.591829, 59.18, 'Sedang'),
(205, 52, 12, 0.563652, 56.37, 'Sedang'),
(206, 52, 15, 0.343450, 34.34, 'Ringan'),
(207, 52, 13, 0.316276, 31.63, 'Ringan'),
(208, 52, 17, 0.296090, 29.61, 'Ringan'),
(209, 52, 16, 0.151744, 15.17, 'Ringan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_konsultasi`
--

CREATE TABLE `detail_konsultasi` (
  `id_detail` int NOT NULL,
  `id_konsultasi` int NOT NULL,
  `id_gejala` int NOT NULL,
  `cf_user` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `detail_konsultasi`
--

INSERT INTO `detail_konsultasi` (`id_detail`, `id_konsultasi`, `id_gejala`, `cf_user`) VALUES
(1642, 51, 6, 0.00),
(1643, 51, 7, 0.00),
(1644, 51, 8, 0.20),
(1645, 51, 9, 0.20),
(1646, 51, 10, 0.00),
(1647, 51, 11, 0.00),
(1648, 51, 12, 0.20),
(1649, 51, 13, 0.20),
(1650, 51, 14, 0.00),
(1651, 51, 15, 0.00),
(1652, 51, 16, 0.20),
(1653, 51, 17, 0.00),
(1654, 51, 18, 0.00),
(1655, 51, 19, 0.20),
(1656, 51, 20, 0.20),
(1657, 51, 21, 0.00),
(1658, 51, 22, 0.20),
(1659, 51, 23, 0.20),
(1660, 51, 24, 0.00),
(1661, 51, 26, 0.00),
(1662, 51, 27, 0.00),
(1663, 51, 28, 0.20),
(1664, 51, 29, 0.20),
(1665, 51, 30, 0.00),
(1666, 51, 31, 0.00),
(1667, 51, 32, 0.20),
(1668, 51, 33, 0.00),
(1669, 51, 34, 0.00),
(1670, 51, 35, 0.20),
(1671, 51, 36, 0.20),
(1672, 51, 37, 0.00),
(1673, 51, 38, 0.20),
(1674, 51, 39, 0.20),
(1675, 51, 40, 0.00),
(1676, 51, 41, 0.00),
(1677, 51, 42, 0.20),
(1678, 51, 43, 0.00),
(1679, 51, 44, 0.20),
(1680, 51, 45, 0.20),
(1681, 51, 46, 0.00),
(1682, 51, 47, 0.00),
(1683, 51, 48, 0.20),
(1684, 51, 49, 0.40),
(1685, 51, 50, 0.20),
(1686, 51, 51, 0.00),
(1687, 51, 52, 0.00),
(1688, 51, 53, 0.20),
(1689, 51, 54, 0.20),
(1690, 51, 55, 0.20),
(1691, 51, 56, 0.00),
(1692, 51, 57, 0.00),
(1693, 51, 58, 0.20),
(1694, 51, 59, 0.20),
(1695, 51, 60, 0.20),
(1696, 51, 61, 0.00),
(1697, 51, 62, 0.20),
(1698, 51, 63, 0.00),
(1699, 52, 6, 0.20),
(1700, 52, 7, 0.00),
(1701, 52, 8, 0.20),
(1702, 52, 9, 0.20),
(1703, 52, 10, 0.00),
(1704, 52, 11, 0.00),
(1705, 52, 12, 0.20),
(1706, 52, 13, 0.00),
(1707, 52, 14, 0.20),
(1708, 52, 15, 0.20),
(1709, 52, 16, 0.20),
(1710, 52, 17, 0.00),
(1711, 52, 18, 0.00),
(1712, 52, 19, 0.20),
(1713, 52, 20, 0.20),
(1714, 52, 21, 0.00),
(1715, 52, 22, 0.20),
(1716, 52, 23, 0.20),
(1717, 52, 24, 0.00),
(1718, 52, 26, 0.00),
(1719, 52, 27, 0.20),
(1720, 52, 28, 0.00),
(1721, 52, 29, 0.20),
(1722, 52, 30, 0.20),
(1723, 52, 31, 0.00),
(1724, 52, 32, 0.00),
(1725, 52, 33, 0.20),
(1726, 52, 34, 0.20),
(1727, 52, 35, 0.00),
(1728, 52, 36, 0.20),
(1729, 52, 37, 0.20),
(1730, 52, 38, 0.00),
(1731, 52, 39, 0.20),
(1732, 52, 40, 0.20),
(1733, 52, 41, 0.00),
(1734, 52, 42, 0.00),
(1735, 52, 43, 0.20),
(1736, 52, 44, 0.20),
(1737, 52, 45, 0.00),
(1738, 52, 46, 0.20),
(1739, 52, 47, 0.20),
(1740, 52, 48, 0.00),
(1741, 52, 49, 0.20),
(1742, 52, 50, 0.20),
(1743, 52, 51, 0.00),
(1744, 52, 52, 0.20),
(1745, 52, 53, 0.20),
(1746, 52, 54, 0.20),
(1747, 52, 55, 0.00),
(1748, 52, 56, 0.00),
(1749, 52, 57, 0.00),
(1750, 52, 58, 0.00),
(1751, 52, 59, 0.20),
(1752, 52, 60, 0.00),
(1753, 52, 61, 0.20),
(1754, 52, 62, 0.00),
(1755, 52, 63, 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int NOT NULL,
  `kode_gejala` varchar(5) NOT NULL,
  `nama_gejala` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `kode_gejala`, `nama_gejala`) VALUES
(6, 'G001', 'Nafsu makan menurun '),
(7, 'G002', 'Perubahan berat badan secara signifikan'),
(8, 'G003', 'Gangguan Tidur (Insomnia)'),
(9, 'G004', 'Mudah lelah atau kehilangan energi'),
(10, 'G005', 'Sulit Berkonsentrasi'),
(11, 'G006', 'Perasaan sedih berkepanjangan'),
(12, 'G007', 'Kehilangan minat atau semangat pada aktivitas sehari-hari'),
(13, 'G008', 'Merasa tidak berharga atau bersalah berlebihan'),
(14, 'G009', 'Menarik diri dari teman dan keluarga'),
(15, 'G010', 'Pikiran ingin bunuh diri atau ide mengakhiri hidup'),
(16, 'G011', 'Keringat Berlebihan'),
(17, 'G012', 'Sulit Bernapas'),
(18, 'G013', 'Gelisah atau sulit diam'),
(19, 'G014', 'Rasa cemas berlebihan'),
(20, 'G015', 'Jantung berdebar cepat (Palpitasi)'),
(21, 'G016', 'Perubahan emosi secara tiba-tiba'),
(22, 'G017', 'Ketegangan terus-menerus atau waspada berlebihan'),
(23, 'G018', 'Takut berada di tempat umum atau bertemu orang'),
(24, 'G019', 'Serangan Panik (Tiba-tiba muncul rasa takut sangat kuat)'),
(26, 'G020', 'Sering berkelahi atau bertengkar'),
(27, 'G021', 'Melanggar aturan dengan sengaja'),
(28, 'G022', 'Sering berbohong'),
(29, 'G023', 'Tidak peduli pada perasaan orang lain'),
(30, 'G024', 'Menghindari tanggung jawab'),
(31, 'G025', 'Merusak barang dengan sengaja'),
(32, 'G026', 'Suka mencuri barang orang lain'),
(33, 'G027', 'Sering membolos atau kabur dari rumah'),
(34, 'G028', 'Menunjukkan perilaku agresif terhadap otoritas (guru atau orang tua)'),
(35, 'G029', 'Mengancam atau menyakiti orang lain'),
(36, 'G030', 'Mudah terkejut'),
(37, 'G031', 'Mimpi buruk berulang tentang peristiwa traumatis'),
(38, 'G032', 'Perasaan bersalah setelah peristiwa traumatis'),
(39, 'G033', 'Flashback atau kembali merasakan kejadian traumatis'),
(40, 'G034', 'Mudah tersinggung atau sensitif'),
(41, 'G035', 'Mudah marah atau emosi berlebihan'),
(42, 'G036', 'Menghindari tempat atau orang yang mengingatkan pada trauma'),
(43, 'G037', 'Perasaan mati rasa secara emosional'),
(44, 'G038', 'Takut berlebihan terhadap kegemukan'),
(45, 'G039', 'Rasa bersalah setelah makan banyak'),
(46, 'G040', 'Terobsesi menghitung kalori'),
(47, 'G041', 'Makan berlebihan (binge eating) dalam waktu singkat'),
(48, 'G042', 'Membatasi makan secara ekstrem'),
(49, 'G043', 'Menyembunyikan kebiasaan makan dari orang lain'),
(50, 'G044', 'Berat badan turun drastis secara tidak normal'),
(51, 'G045', 'Menggunakan obat diet untuk menurunkan berat badan'),
(52, 'G046', 'Sulit mengatur waktu'),
(53, 'G047', 'Sering kehilangan barang'),
(54, 'G048', 'Sering berbicara tanpa berpikir'),
(55, 'G049', 'Sulit diam dalam situasi yang menuntut tenang'),
(56, 'G050', 'Bertindak tanpa berpikir panjang'),
(57, 'G051', 'Mudah teralihkan oleh hal sepele'),
(58, 'G052', 'Merasa gelisah atau cemas jika tidak bermain atau online'),
(59, 'G053', 'Terus memikirkan game atau media sosial saat sedang beraktivitas lain'),
(60, 'G054', 'Menghabiskan waktu berlebihan untuk bermain atau menggunakan media sosial'),
(61, 'G055', 'Prestasi belajar menurun akibat kecanduan'),
(62, 'G056', 'Sulit mengontrol waktu bermain meskipun sadar dampaknya'),
(63, 'G057', 'Kehilangan kendali terhadap penggunaan media digital');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_gangguan`
--

CREATE TABLE `jenis_gangguan` (
  `id_gangguan` int NOT NULL,
  `kode_gangguan` varchar(5) NOT NULL,
  `nama_gangguan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jenis_gangguan`
--

INSERT INTO `jenis_gangguan` (`id_gangguan`, `kode_gangguan`, `nama_gangguan`, `deskripsi`) VALUES
(11, 'J001', 'Gangguan Depresi', 'Depresi adalah gangguan suasana hati yang ditandai dengan perasaan sedih mendalam dan kehilangan minat pada aktivitas yang biasa menyenangkan. Penyebabnya dapat berupa faktor biologis seperti ketidakseimbangan zat kimia otak, faktor psikologis seperti rendah diri dan stres, serta faktor sosial seperti tekanan lingkungan atau masalah keluarga. Lama depresi bervariasi, mulai dari dua minggu hingga bertahun-tahun tergantung tingkat keparahan dan penanganannya. '),
(12, 'J002', 'Gangguan Kecemasan (Anxiety)', 'Kondisi ini ditandai dengan rasa cemas, tegang, atau takut yang berlebihan tanpa alasan yang jelas. Bentuknya bisa berupa generalized anxiety disorder, fobia sosial, atau panic disorder. Pada remaja, kecemasan sering muncul dalam bentuk takut gagal, kesulitan berbicara di depan umum, atau kekhawatiran berlebihan terhadap masa depan sehingga dapat menghambat aktivitas sosial dan prestasi belajar. Pada kasus ringan, kecemasan dapat berlangsung selama beberapa hari hingga minggu, sedangkan pada gangguan kecemasan yang lebih berat seperti generalized anxiety disorder dapat berlangsung selama berbulan-bulan bahkan bertahun-tahun jika tidak ditangani dengan baik'),
(13, 'J003', 'Gangguan Perilaku', 'Gangguan perilaku ditandai dengan pola tindakan yang melanggar norma sosial atau aturan yang berlaku, berlangsung dalam jangka waktu lama (lebih dari tiga bulan). Remaja dengan gangguan ini sering menunjukkan perilaku agresif, menentang otoritas, atau melakukan tindakan yang merugikan orang lain. Penyebabnya bisa berasal dari pola asuh yang tidak konsisten, lingkungan sosial negatif, maupun masalah emosional yang tidak tertangani. '),
(14, 'J004', 'Gangguan Trauma (PTSD)', 'PTSD dialami oleh remaja yang pernah mengalami peristiwa traumatis, seperti kekerasan, bencana alam, atau kecelakaan. Kondisi ini biasanya dirasakan lebih dari satu bulan setelah kejadian traumatis. '),
(15, 'J005', 'Gangguan Makan', 'Gangguan makan adalah kondisi ketika seseorang memiliki pola makan yang tidak sehat akibat obsesi terhadap berat badan atau bentuk tubuh. Remaja yang mengalami gangguan ini sering kali merasa tidak puas terhadap tubuhnya dan melakukan cara ekstrem untuk menurunkan berat badan. Gangguan makan dapat menyebabkan kekurangan gizi, gangguan hormonal, bahkan komplikasi serius pada kesehatan fisik dan mental. Jangka waktu gangguan makan bervariasi, bisa berlangsung selama beberapa bulan hingga bertahun-tahun tergantung seberapa cepat penderita mendapatkan penanganan yang tepat.'),
(16, 'J006', 'Gangguan Konsentrasi (ADHD)', 'ADHD adalah gangguan perkembangan yang menyebabkan kesulitan dalam memusatkan perhatian, mengendalikan impuls, dan mengatur perilaku. Pada remaja, ADHD dapat berdampak pada prestasi belajar, hubungan sosial, serta kemampuan mengatur waktu dan emosi. Kondisi ini biasanya berlangsung lebih dari enam bulan dan memerlukan pendekatan pendidikan serta terapi perilaku.'),
(17, 'J007', 'Gangguan Ketergantungan', 'Gangguan ketergantungan adalah kondisi ketika seseorang tidak mampu mengontrol keinginan untuk terus melakukan suatu aktivitas atau menggunakan sesuatu secara berlebihan, seperti bermain game, menggunakan media sosial, atau internet. Kondisi ini membuat penderitanya mengabaikan kewajiban, mengalami gangguan tidur, dan kehilangan keseimbangan dalam kehidupan sehari-hari. Pada remaja, gangguan ini sering berdampak pada penurunan prestasi belajar, gangguan sosial, serta munculnya rasa gelisah atau marah jika tidak dapat mengakses aktivitas yang membuatnya kecanduan. Jangka waktu untuk gangguan ini dirasakan sekurang-kurangnya 2 bulan secara berturut-turut. ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsultasi`
--

CREATE TABLE `konsultasi` (
  `id_konsultasi` int NOT NULL,
  `id_pengguna` varchar(5) NOT NULL,
  `tanggal_konsultasi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_gangguan` int DEFAULT NULL,
  `nilai_cf_tertinggi` decimal(8,6) DEFAULT NULL,
  `persentase_tertinggi` decimal(6,2) DEFAULT NULL,
  `kategori` enum('Ringan','Sedang','Berat') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `konsultasi`
--

INSERT INTO `konsultasi` (`id_konsultasi`, `id_pengguna`, `tanggal_konsultasi`, `id_gangguan`, `nilai_cf_tertinggi`, `persentase_tertinggi`, `kategori`) VALUES
(51, 'P0001', '2026-02-25 01:25:49', 12, 0.535799, 53.58, 'Sedang'),
(52, 'P0002', '2026-02-25 01:31:22', 14, 0.632969, 63.30, 'Sedang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` varchar(5) NOT NULL,
  `nama_pengguna` varchar(30) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `usia` int NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `tanggal_daftar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `jenis_kelamin`, `no_telp`, `usia`, `alamat`, `tanggal_daftar`) VALUES
('P0001', 'kaneji', 'Laki-laki', '081240288596', 23, 'abe', '2026-02-25'),
('P0002', 'sriyanti', 'Perempuan', '082132592880', 22, 'sentani', '2026-02-25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `solusi`
--

CREATE TABLE `solusi` (
  `id_solusi` varchar(5) NOT NULL,
  `id_gangguan` int NOT NULL,
  `kategori` enum('Ringan','Sedang','Berat') NOT NULL,
  `deskripsi_solusi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `solusi`
--

INSERT INTO `solusi` (`id_solusi`, `id_gangguan`, `kategori`, `deskripsi_solusi`) VALUES
('S001', 11, 'Ringan', 'Lakukan relaksasi ringan seperti mendengarkan musik santai.'),
('S002', 11, 'Ringan', 'Tidur cukup dan jaga pola makan yang sehat.'),
('S003', 11, 'Ringan', 'Habiskan waktu di luar ruangan seperti berjalan pagi atau menikmati alam.'),
('S004', 11, 'Ringan', 'Hindari penggunaan gadget berlebihan sebelum tidur.'),
('S005', 11, 'Sedang', 'Konsultasi dengan konselor sekolah untuk membicarakan perasaan.'),
('S006', 11, 'Sedang', 'Luangkan waktu untuk kegiatan yang menyenangkan dan produktif.'),
('S007', 11, 'Sedang', 'Coba menulis jurnal harian untuk mengekspresikan emosi.'),
('S008', 11, 'Sedang', 'Berbagi cerita dengan teman dekat yang dipercaya.'),
('S009', 11, 'Sedang', 'Rutin lakukan olahraga ringan untuk membantu stabilkan emosi.'),
('S010', 11, 'Berat', 'Segera temui psikolog profesional untuk penanganan lebih lanjut.'),
('S011', 11, 'Berat', 'Hindari isolasi diri dan tetap jaga komunikasi dengan keluarga.'),
('S012', 12, 'Ringan', 'Lakukan pernapasan dalam secara rutin untuk mengurangi kecemasan.'),
('S013', 12, 'Ringan', 'Lakukan olahraga ringan seperti jalan santai atau yoga.'),
('S014', 12, 'Ringan', 'Kurangi konsumsi kafein dan batasi waktu di media sosial.'),
('S015', 12, 'Ringan', 'Dengarkan musik tenang atau lakukan meditasi ringan.'),
('S016', 12, 'Sedang', 'Batasi stres dengan teknik mindfulness atau meditasi.'),
('S017', 12, 'Sedang', 'Buat jadwal harian agar pikiran lebih teratur dan fokus.'),
('S018', 12, 'Sedang', 'Diskusikan kecemasan dengan orang yang dipercaya.'),
('S019', 12, 'Sedang', 'Kurangi beban dengan menuliskan hal-hal yang mengganggu pikiran.'),
('S020', 12, 'Sedang', 'Lakukan kegiatan relaksasi seperti berendam air hangat atau membaca.'),
('S021', 12, 'Berat', 'Hubungi tenaga kesehatan mental untuk konsultasi lebih lanjut.'),
('S022', 12, 'Berat', 'Istirahat cukup dan hindari konsumsi kafein berlebihan.'),
('S023', 13, 'Ringan', 'Hindari lingkungan yang dapat memicu perilaku negatif.'),
('S024', 13, 'Ringan', 'Lakukan aktivitas positif seperti menulis atau menggambar.'),
('S025', 13, 'Ringan', 'Habiskan waktu dengan keluarga atau teman untuk dukungan emosional.'),
('S026', 13, 'Ringan', 'Atur rutinitas harian agar tetap produktif dan terarah.'),
('S027', 13, 'Sedang', 'Ikuti kegiatan sosial atau kelompok dukungan sebaya.'),
('S028', 13, 'Sedang', 'Konsultasikan masalah perilaku pada guru BK atau konselor.'),
('S029', 13, 'Sedang', 'Belajar mengelola emosi melalui latihan pernapasan dan refleksi diri.'),
('S030', 13, 'Sedang', 'Lakukan aktivitas fisik rutin seperti olahraga ringan.'),
('S031', 13, 'Sedang', 'Hindari lingkungan atau teman yang memperkuat perilaku negatif.'),
('S032', 13, 'Berat', 'Lakukan terapi perilaku dengan psikolog anak/remaja.'),
('S033', 13, 'Berat', 'Libatkan keluarga dalam proses pendampingan dan dukungan.'),
('S034', 14, 'Ringan', 'Atur waktu tidur dan hindari hal yang memicu stres malam hari.'),
('S035', 14, 'Ringan', 'Coba teknik grounding untuk menenangkan diri saat teringat trauma.'),
('S036', 14, 'Ringan', 'Lakukan kegiatan positif seperti menulis atau menggambar.'),
('S037', 14, 'Ringan', 'Jaga rutinitas harian agar tetap stabil dan terkontrol.'),
('S038', 14, 'Sedang', 'Konsultasikan perasaan dan pengalaman kepada konselor atau guru.'),
('S039', 14, 'Sedang', 'Lakukan kegiatan relaksasi seperti menggambar atau membaca.'),
('S040', 14, 'Sedang', 'Coba teknik relaksasi otot progresif untuk menurunkan ketegangan.'),
('S041', 14, 'Sedang', 'Bicarakan perasaan dengan teman atau orang yang dipercaya.'),
('S042', 14, 'Sedang', 'Ikuti kegiatan sosial atau kelompok yang mendukung pemulihan.'),
('S043', 14, 'Berat', 'Dapatkan bantuan psikoterapi dari tenaga profesional.'),
('S044', 14, 'Berat', 'Jangan menghadapi trauma sendiri, libatkan orang terpercaya.'),
('S045', 15, 'Ringan', 'Jaga pola makan seimbang dan tidak melewatkan waktu makan.'),
('S046', 15, 'Ringan', 'Hindari membandingkan bentuk tubuh dengan orang lain.'),
('S047', 15, 'Ringan', 'Lakukan aktivitas positif yang meningkatkan rasa percaya diri.'),
('S048', 15, 'Ringan', 'Berbagi perasaan dengan orang yang dipercaya untuk dukungan emosional.'),
('S049', 15, 'Sedang', 'Konsultasikan pola makan dengan ahli gizi atau konselor sekolah.'),
('S050', 15, 'Sedang', 'Catat kebiasaan makan harian untuk memahami pemicunya.'),
('S051', 15, 'Sedang', 'Latih diri untuk makan secara sadar (mindful eating).'),
('S052', 15, 'Sedang', 'Batasi paparan media sosial yang menampilkan standar tubuh tidak realistis.'),
('S053', 15, 'Sedang', 'Ikuti kelompok dukungan remaja yang memiliki pengalaman serupa.'),
('S054', 15, 'Berat', 'Segera konsultasikan ke psikolog atau psikiater untuk terapi khusus.'),
('S055', 15, 'Berat', 'Libatkan keluarga untuk membantu dalam proses pemulihan.'),
('S056', 16, 'Ringan', 'Buat jadwal harian yang teratur untuk membantu fokus.'),
('S057', 16, 'Ringan', 'Sediakan lingkungan belajar yang minim gangguan.'),
('S058', 16, 'Ringan', 'Gunakan pengingat visual seperti catatan tempel atau alarm.'),
('S059', 16, 'Ringan', 'Berikan penghargaan kecil pada diri sendiri saat berhasil fokus.'),
('S060', 16, 'Sedang', 'Konsultasikan dengan guru atau konselor untuk strategi belajar yang sesuai.'),
('S061', 16, 'Sedang', 'Lakukan aktivitas fisik rutin untuk menyalurkan energi berlebih.'),
('S062', 16, 'Sedang', 'Gunakan teknik manajemen waktu.'),
('S063', 16, 'Sedang', 'Bagi tugas besar menjadi langkah-langkah kecil yang mudah dicapai.'),
('S064', 16, 'Sedang', 'Dapatkan dukungan teman atau keluarga untuk membantu tetap fokus.'),
('S065', 16, 'Berat', 'Dapatkan terapi perilaku dari profesional (misalnya CBT).'),
('S066', 16, 'Berat', 'Konsultasi dengan psikiater jika diperlukan pengobatan medis.'),
('S067', 17, 'Ringan', 'Batasi penggunaan gawai atau hal yang memicu ketergantungan.'),
('S068', 17, 'Ringan', 'Ganti kebiasaan buruk dengan kegiatan produktif seperti olahraga atau membaca.'),
('S069', 17, 'Ringan', 'Tentukan waktu khusus untuk istirahat dari aktivitas adiktif.'),
('S070', 17, 'Ringan', 'Cari dukungan teman atau keluarga yang bisa membantu mengontrol perilaku.'),
('S071', 17, 'Sedang', 'Buat rencana pengurangan penggunaan secara bertahap (detoks digital/aktivitas).'),
('S072', 17, 'Sedang', 'Identifikasi pemicu perilaku ketergantungan dan hindari situasi tersebut.'),
('S073', 17, 'Sedang', 'Ikuti kelompok dukungan atau bimbingan konselor.'),
('S074', 17, 'Sedang', 'Isi waktu luang dengan kegiatan sosial yang positif.'),
('S075', 17, 'Sedang', 'Gunakan aplikasi atau catatan untuk memantau kebiasaan sehari-hari.'),
('S076', 17, 'Berat', 'Dapatkan bantuan dari profesional kesehatan mental atau rehabilitasi.'),
('S077', 17, 'Berat', 'Jaga komunikasi intens dengan keluarga selama masa pemulihan.'),
('S078', 17, 'Berat', 'Hindari lingkungan yang memicu perilaku ketergantungan kembali.');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aturan`
--
ALTER TABLE `aturan`
  ADD PRIMARY KEY (`id_aturan`),
  ADD KEY `aturan_ibfk_1` (`id_gangguan`),
  ADD KEY `aturan_ibfk_2` (`id_gejala`);

--
-- Indeks untuk tabel `cf_gangguan`
--
ALTER TABLE `cf_gangguan`
  ADD PRIMARY KEY (`id_cf_gangguan`),
  ADD UNIQUE KEY `uq_konsultasi_gangguan` (`id_konsultasi`,`id_gangguan`),
  ADD KEY `id_gangguan` (`id_gangguan`);

--
-- Indeks untuk tabel `detail_konsultasi`
--
ALTER TABLE `detail_konsultasi`
  ADD PRIMARY KEY (`id_detail`),
  ADD UNIQUE KEY `uq_konsultasi_gejala` (`id_konsultasi`,`id_gejala`),
  ADD KEY `id_gejala` (`id_gejala`);

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indeks untuk tabel `jenis_gangguan`
--
ALTER TABLE `jenis_gangguan`
  ADD PRIMARY KEY (`id_gangguan`);

--
-- Indeks untuk tabel `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`id_konsultasi`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_gangguan_tertinggi` (`id_gangguan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD PRIMARY KEY (`id_solusi`),
  ADD KEY `id_gangguan` (`id_gangguan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `aturan`
--
ALTER TABLE `aturan`
  MODIFY `id_aturan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT untuk tabel `cf_gangguan`
--
ALTER TABLE `cf_gangguan`
  MODIFY `id_cf_gangguan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT untuk tabel `detail_konsultasi`
--
ALTER TABLE `detail_konsultasi`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1756;

--
-- AUTO_INCREMENT untuk tabel `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `jenis_gangguan`
--
ALTER TABLE `jenis_gangguan`
  MODIFY `id_gangguan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `id_konsultasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aturan`
--
ALTER TABLE `aturan`
  ADD CONSTRAINT `aturan_ibfk_1` FOREIGN KEY (`id_gangguan`) REFERENCES `jenis_gangguan` (`id_gangguan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aturan_ibfk_2` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cf_gangguan`
--
ALTER TABLE `cf_gangguan`
  ADD CONSTRAINT `fk_cfgangguan_gangguan` FOREIGN KEY (`id_gangguan`) REFERENCES `jenis_gangguan` (`id_gangguan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cfgangguan_konsultasi` FOREIGN KEY (`id_konsultasi`) REFERENCES `konsultasi` (`id_konsultasi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_konsultasi`
--
ALTER TABLE `detail_konsultasi`
  ADD CONSTRAINT `fk_detail_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_konsultasi` FOREIGN KEY (`id_konsultasi`) REFERENCES `konsultasi` (`id_konsultasi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD CONSTRAINT `fk_konsultasi_gangguan` FOREIGN KEY (`id_gangguan`) REFERENCES `jenis_gangguan` (`id_gangguan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_konsultasi_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD CONSTRAINT `solusi_ibfk_1` FOREIGN KEY (`id_gangguan`) REFERENCES `jenis_gangguan` (`id_gangguan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
