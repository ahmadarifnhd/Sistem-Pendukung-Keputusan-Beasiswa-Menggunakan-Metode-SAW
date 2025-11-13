-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Sep 2025 pada 02.16
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `espkrama`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_alternatif`
--

CREATE TABLE `data_alternatif` (
  `ID_Alternatif` int(20) NOT NULL,
  `Nama_Mahasiswa` varchar(50) NOT NULL,
  `Jenis_Beasiswa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_alternatif`
--

INSERT INTO `data_alternatif` (`ID_Alternatif`, `Nama_Mahasiswa`, `Jenis_Beasiswa`) VALUES
(1, 'Fauzi', 'Beasiswa Genbi'),
(2, 'Rama', 'Beasiswa Merdeka'),
(3, 'Riska', 'Beasiswa Genbi'),
(4, 'Doni', 'Beasiswa Genbi'),
(5, 'Hari', 'Beasiswa Genbi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_kriteria`
--

CREATE TABLE `data_kriteria` (
  `ID_Kriteria` int(20) NOT NULL,
  `AO` int(20) NOT NULL,
  `IPK` int(20) NOT NULL,
  `KKM` int(20) NOT NULL,
  `TMB` int(20) NOT NULL,
  `SMT` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_kriteria`
--

INSERT INTO `data_kriteria` (`ID_Kriteria`, `AO`, `IPK`, `KKM`, `TMB`, `SMT`) VALUES
(0, 1, 2, 3, 2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_penilaian`
--

CREATE TABLE `data_penilaian` (
  `ID_Penilaian` int(20) NOT NULL,
  `Alternatif` varchar(50) NOT NULL,
  `AO` int(20) NOT NULL,
  `IPK` int(20) NOT NULL,
  `KKM` int(20) NOT NULL,
  `TMB` int(20) NOT NULL,
  `SMT` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_penilaian`
--

INSERT INTO `data_penilaian` (`ID_Penilaian`, `Alternatif`, `AO`, `IPK`, `KKM`, `TMB`, `SMT`) VALUES
(1, 'Fauzi', 1, 1, 1, 1, 1),
(2, 'Rama', 3, 3, 3, 3, 3),
(3, 'Riska', 2, 2, 2, 2, 2),
(4, 'Doni', 1, 2, 1, 2, 1),
(5, 'Hari', 2, 1, 2, 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_user`
--

CREATE TABLE `data_user` (
  `id` int(20) NOT NULL,
  `npm` varchar(255) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_user`
--

INSERT INTO `data_user` (`id`, `npm`, `username`, `password`, `role`) VALUES
(5, '123', 'coba', '$2y$10$8QxEdDDLfgfvf7q8tPiZK.XXUeJ2qhTCf7IEBHL3I8zzRONN1uP.S', 'user'),
(6, '1', 'admin', '$2y$10$ee19Ya9l4iBB1SukBKnH4e63Od07sxNMWo0YtAMXoqpWslSlSHJze', 'admin'),
(7, '1234', 'aku', '$2y$10$1SwvSjzgED5p28vOELSvPOt3sev.3/HLDlsZYLjYyNi7PfjE1adA6', 'user'),
(8, '2222', 'a', '$2y$10$i.wa1fOm2LUvxgGSOAQnD.4Hyt1Fcq85xz4zMH2o1neeGMy6VAYxS', 'user'),
(9, '2024', 'rama', '$2y$10$yh8kFwwAY78cfg6R9T.Z/OC7Q03dAk6fBBfijcw7C50fOet3.5ov2', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_normalisasi`
--

CREATE TABLE `hasil_normalisasi` (
  `ID_Norm` int(20) NOT NULL,
  `C1` float NOT NULL,
  `C2` float NOT NULL,
  `C3` float NOT NULL,
  `C4` float NOT NULL,
  `C5` float NOT NULL,
  `ID_Alternatif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_normalisasi`
--

INSERT INTO `hasil_normalisasi` (`ID_Norm`, `C1`, `C2`, `C3`, `C4`, `C5`, `ID_Alternatif`) VALUES
(0, 0.333, 0.333, 0.333, 0.333, 0.333, NULL),
(0, 1, 1, 1, 1, 1, NULL),
(0, 0.667, 0.667, 0.667, 0.667, 0.667, NULL),
(0, 0.333, 0.667, 0.333, 0.667, 0.333, NULL),
(0, 0.667, 0.333, 0.667, 0.333, 0.667, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_preferensi`
--

CREATE TABLE `hasil_preferensi` (
  `ID_Pref` int(20) NOT NULL,
  `C1` float NOT NULL,
  `C2` float NOT NULL,
  `C3` float NOT NULL,
  `C4` float NOT NULL,
  `C5` float NOT NULL,
  `Total` float NOT NULL,
  `ID_Alternatif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_preferensi`
--

INSERT INTO `hasil_preferensi` (`ID_Pref`, `C1`, `C2`, `C3`, `C4`, `C5`, `Total`, `ID_Alternatif`) VALUES
(0, 0.333, 0.666, 0.999, 0.666, 0.666, 3.33, 1),
(0, 1, 2, 3, 2, 2, 10, 2),
(0, 0.667, 1.334, 2.001, 1.334, 1.334, 6.67, 3),
(0, 0.333, 1.334, 0.999, 1.334, 0.666, 4.666, 4),
(0, 0.667, 0.666, 2.001, 0.666, 1.334, 5.334, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_berkas`
--

CREATE TABLE `tbl_berkas` (
  `id` int(11) NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `npm` varchar(20) NOT NULL,
  `program_studi` varchar(50) NOT NULL,
  `file_aktif_organisasi` varchar(255) DEFAULT NULL,
  `file_tidak_beasiswa` varchar(255) DEFAULT NULL,
  `file_keluarga_tidak_mampu` varchar(255) DEFAULT NULL,
  `file_ipk` varchar(255) DEFAULT NULL,
  `jumlah_sks` int(11) DEFAULT 0,
  `status` enum('pending','diterima','ditolak') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_berkas`
--

INSERT INTO `tbl_berkas` (`id`, `nama_mahasiswa`, `npm`, `program_studi`, `file_aktif_organisasi`, `file_tidak_beasiswa`, `file_keluarga_tidak_mampu`, `file_ipk`, `jumlah_sks`, `status`, `created_at`) VALUES
(9, 'aku', '1234', 'aa', 'uploads/berkas/1756788111_surat izin 2.pdf', 'uploads/berkas/1756788111_surat izin.pdf', 'uploads/berkas/1756788111_surat izin 20 mei.pdf', 'uploads/berkas/1756788111_surat izin 3.pdf', 12, 'diterima', '2025-09-02 04:41:51'),
(10, 'coba', '123', 'sas', 'uploads/berkas/1756788598_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 'uploads/berkas/1756788598_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 'uploads/berkas/1756788598_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 'uploads/berkas/1756788598_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 22, 'pending', '2025-09-02 04:49:58'),
(11, 'a', '2222', 'a', 'uploads/berkas/1756789912_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 'uploads/berkas/1756789912_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 'uploads/berkas/1756789912_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 'uploads/berkas/1756789912_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 12, 'ditolak', '2025-09-02 05:11:52'),
(12, 'rama2', '2024', 'tekom', 'uploads/1756813835_684-73-3246-2-10-20190109.pdf', 'uploads/berkas/1756813418_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 'uploads/berkas/1756813418_Tugas metode numerik_Ridofas Tri Sandi Fantiantoro_20562020023.pdf', 'uploads/berkas/1756813418_tugas metnum.docx', 40, 'diterima', '2025-09-02 11:43:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_berkas`
--
ALTER TABLE `tbl_berkas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tbl_berkas`
--
ALTER TABLE `tbl_berkas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
