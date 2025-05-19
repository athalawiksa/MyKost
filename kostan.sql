-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Bulan Mei 2025 pada 05.40
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
-- Database: `kostan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_kamar`
--

CREATE TABLE `data_kamar` (
  `id` int(11) NOT NULL,
  `nama_kost` enum('Athala Kost','Griya Tara 2','Griya Tara 1') NOT NULL,
  `no_kamar` varchar(10) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `status` enum('Tersedia','Terisi','Dalam Perbaikan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_kamar`
--

INSERT INTO `data_kamar` (`id`, `nama_kost`, `no_kamar`, `harga`, `status`) VALUES
(1, 'Griya Tara 1', '8', 725000, 'Tersedia'),
(2, 'Griya Tara 1', '7', 725000, 'Tersedia'),
(3, 'Griya Tara 1', '6', 725000, 'Tersedia'),
(4, 'Griya Tara 1', '5', 725000, 'Tersedia'),
(5, 'Griya Tara 1', '4', 725000, 'Tersedia'),
(6, 'Griya Tara 1', '3', 725000, 'Tersedia'),
(7, 'Griya Tara 1', '2', 725000, 'Tersedia'),
(8, 'Griya Tara 1', '1', 725000, 'Tersedia'),
(9, 'Griya Tara 2', '17', 700000, 'Tersedia'),
(10, 'Griya Tara 2', '16', 580000, 'Tersedia'),
(11, 'Griya Tara 2', '15', 425000, 'Tersedia'),
(12, 'Griya Tara 2', '14', 450000, 'Tersedia'),
(13, 'Griya Tara 2', '13', 425000, 'Tersedia'),
(14, 'Griya Tara 2', '12', 425000, 'Tersedia'),
(15, 'Griya Tara 2', '11', 500000, 'Tersedia'),
(16, 'Griya Tara 2', '10', 350000, 'Tersedia'),
(17, 'Griya Tara 2', '9', 700000, 'Tersedia'),
(18, 'Griya Tara 2', '8', 800000, 'Tersedia'),
(19, 'Griya Tara 2', '7', 800000, 'Tersedia'),
(20, 'Griya Tara 2', '6', 800000, 'Tersedia'),
(21, 'Griya Tara 2', '5', 600000, 'Tersedia'),
(22, 'Griya Tara 2', '4B', 375000, 'Tersedia'),
(23, 'Griya Tara 2', '4A', 400000, 'Tersedia'),
(24, 'Griya Tara 2', '3B', 375000, 'Tersedia'),
(25, 'Griya Tara 2', '3A', 400000, 'Tersedia'),
(26, 'Griya Tara 2', '2B', 375000, 'Tersedia'),
(27, 'Griya Tara 2', '2A', 375000, 'Tersedia'),
(28, 'Griya Tara 2', '1B', 350000, 'Tersedia'),
(29, 'Griya Tara 2', '1A', 375000, 'Tersedia'),
(30, 'Athala Kost', '12', 450000, 'Tersedia'),
(31, 'Athala Kost', '11', 425000, 'Tersedia'),
(32, 'Athala Kost', '10', 380000, 'Tersedia'),
(33, 'Athala Kost', '9', 450000, 'Tersedia'),
(34, 'Athala Kost', '8', 450000, 'Tersedia'),
(35, 'Athala Kost', '7', 400000, 'Tersedia'),
(36, 'Athala Kost', '6', 350000, 'Tersedia'),
(37, 'Athala Kost', '5', 350000, 'Tersedia'),
(38, 'Athala Kost', '4', 350000, 'Tersedia'),
(39, 'Athala Kost', '3', 400000, 'Tersedia'),
(40, 'Athala Kost', '2', 400000, 'Terisi'),
(41, 'Athala Kost', '1', 400000, 'Terisi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_kost`
--

CREATE TABLE `data_kost` (
  `id` int(11) NOT NULL,
  `nama_kost` enum('Athala Kost','Griya Tara 2','Griya Tara 1') NOT NULL,
  `foto_penghuni` varchar(255) NOT NULL,
  `jumlah_penghuni` int(100) NOT NULL,
  `nama_penghuni` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `no_kamar` varchar(10) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_pembayaran` enum('Lunas','Belum Dibayar','Nunggak','DP') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_kost`
--

INSERT INTO `data_kost` (`id`, `nama_kost`, `foto_penghuni`, `jumlah_penghuni`, `nama_penghuni`, `no_hp`, `no_kamar`, `tanggal_masuk`, `tanggal_bayar`, `keterangan`, `status_pembayaran`) VALUES
(47, 'Athala Kost', 'uploads/kost/682a96fb55598.jpg', 2, 'Riko', '12345678', '1', '2025-05-14', NULL, NULL, 'Belum Dibayar'),
(48, 'Athala Kost', 'uploads/kost/682a971d5d7d3.jpg', 1, 'Athala', '87654321', '2', '2025-05-19', '2025-05-19', NULL, 'Lunas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_penghuni`
--

CREATE TABLE `data_penghuni` (
  `id` int(11) NOT NULL,
  `foto_penghuni` varchar(255) NOT NULL,
  `jumlah_penghuni` int(100) NOT NULL,
  `nama_kost` enum('Athala Kost','Griya Tara 2','Griya Tara Pavilion') NOT NULL,
  `nama_penghuni` varchar(255) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `no_kamar` int(100) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `status_pembayaran` enum('Lunas','Belum Dibayar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `nama_kost` varchar(255) NOT NULL,
  `nama_penghuni` varchar(255) NOT NULL,
  `no_kamar` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_reminders`
--

CREATE TABLE `payment_reminders` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `nama_kost` varchar(255) NOT NULL,
  `nama_penghuni` varchar(255) NOT NULL,
  `no_kamar` int(11) NOT NULL,
  `reminder_type` enum('whatsapp','phone','visit') NOT NULL,
  `sent_date` datetime NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sewa_kamar`
--

CREATE TABLE `sewa_kamar` (
  `id` int(11) NOT NULL,
  `nama_kost` enum('Athala Kost','Griya Tara 2','Griya Tara Pavilion') NOT NULL,
  `nama_penghuni` varchar(255) NOT NULL,
  `jumlah_penghuni` int(100) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `status` enum('Lunas','Belum Dibayar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`) VALUES
(1, 'admin@gmail.com', 'Admin', '$2y$10$Ggm7vr7UX/VnynfJMmBV5u27TkZPM2PzwwVgHJ8M8RyUrVrflgwXe'),
(2, 'atha@gmail.com', 'Atha', '$2y$10$nqeWyFNecAOjuSXPZgv79O7P1sr.ZzC4KzbfphGx5hmQhMtW3b4C.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiry` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_kamar`
--
ALTER TABLE `data_kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_kost`
--
ALTER TABLE `data_kost`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_penghuni`
--
ALTER TABLE `data_penghuni`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payment_reminders`
--
ALTER TABLE `payment_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sewa_kamar`
--
ALTER TABLE `sewa_kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_kamar`
--
ALTER TABLE `data_kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `data_kost`
--
ALTER TABLE `data_kost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `data_penghuni`
--
ALTER TABLE `data_penghuni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payment_reminders`
--
ALTER TABLE `payment_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sewa_kamar`
--
ALTER TABLE `sewa_kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
