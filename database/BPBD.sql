-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jun 2025 pada 03.00
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  `divisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `divisi`) VALUES
(0, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 0),
(1, 'Kepala BPBD', '25f43b1486ad95a1398e3eeb3d83bc4010015fcc9bedb35b432e00298d5021f7', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
(0, 'Admin'),
(1, 'Kepala BPBD');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `nama` varchar(64) COLLATE utf8_bin NOT NULL,
  `email` varchar(64) COLLATE utf8_bin NOT NULL,
  `telpon` varchar(12) COLLATE utf8_bin NOT NULL,
  `alamat` varchar(256) COLLATE utf8_bin NOT NULL,
  `tujuan` int(11) NOT NULL,
  `isi` varchar(2048) COLLATE utf8_bin NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(12) COLLATE utf8_bin NOT NULL,
  `foto` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `koordinat` varchar(50) COLLATE utf8_bin NOT NULL,
  `kategori` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `nama`, `email`, `telpon`, `alamat`, `tujuan`, `isi`, `tanggal`, `status`, `foto`, `koordinat`, `kategori`) VALUES
(100, 'Users1', 'Users1@yahoo.com', '081233356115', 'JL Sakura Blok C1 No C1 Kota Tangerang Selatan', 0, 'Tolong Rumah tetangga saya Ketiban Pohon', '2025-06-15 12:26:58', 'Ditanggapi', '1746062358_pohon tumbang.jpg', '-6.324426, 106.721635', 'Pohon Tumbang'),
(101, 'Users2', 'Users2@gmail.com', '089533180813', 'JL Raya Ciater Kelurahan Ciater Kecamatan Serpong Kota Tangerang Selatan', 0, 'Terjadi Pohon Tumbang', '2025-06-18 23:33:13', 'Menunggu', '1746063475_pohon tumbang.jpg', '-6.335604, 106.687256', 'Pohon Tumbang'),
(102, 'Users3', 'Users3@gmail.com', '089533180811', 'JL Raya Ciater Kelurahan Ciater Kecamatan Serpong Kota Tangerang Selatan', 0, 'Wabah berbahaya,saya dan tetangga saya terkena wabah Bipolar.', '2025-06-09 01:09:23', 'Ditanggapi', '1748671698_wabah.jpg', '-6.212813, 106.777805', 'Wabah'),
(103, 'Users4', 'Users4@gmail.com', '081355677191', 'Jl.Perum Kota Bumi Pinggir Jurang', 0, 'kekeringan', '2025-06-21 02:25:03', 'Menunggu', '1750472703_kekeringanjpg.jpg', '-6.197980, 106.792706', 'Kekeringan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanggapan`
--

CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL,
  `id_laporan` int(11) NOT NULL,
  `admin` varchar(64) COLLATE utf8_bin NOT NULL,
  `isi_tanggapan` varchar(2048) COLLATE utf8_bin NOT NULL,
  `tanggal_tanggapan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tanggapan`
--

INSERT INTO `tanggapan` (`id_tanggapan`, `id_laporan`, `admin`, `isi_tanggapan`, `tanggal_tanggapan`) VALUES
(20, 102, 'Admin', 'Baik pak', '2025-06-09 01:09:23'),
(24, 100, 'Admin', 'oke\r\n', '2025-06-15 12:26:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`) VALUES
(6, 'Users1', 'Users1@gmail.com', '$2y$10$mJETEufWFZheu423nA/D/uuWksIj6IQl8cUfx5DFDvIkd9.uTxqwK'),
(10, 'Users2', 'Users2@gmail.com', '$2y$10$f2PIo1/htTddgeStRjGN6eRF1pdBJbhYDtGBPH.msoLp9WTy2bhR2'),
(13, 'Users3', 'Users13@gmail.com', '$2y$10$SAn/sM1jnoa/M3cj3NSs9ujBmEl3SiTnSbXsluKiGa0x51idLueFm');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `divisi` (`divisi`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tujuan` (`tujuan`);

--
-- Indeks untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id_tanggapan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`divisi`) REFERENCES `divisi` (`id_divisi`);

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`tujuan`) REFERENCES `divisi` (`id_divisi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
