-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 22 Bulan Mei 2021 pada 14.41
-- Versi server: 10.2.6-MariaDB-log
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_puskesmas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian_pasien`
--

CREATE TABLE `antrian_pasien` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` text NOT NULL,
  `name` text NOT NULL,
  `poliklinik` text NOT NULL,
  `age` int(10) UNSIGNED NOT NULL,
  `symptom` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `antrian_pasien`
--

INSERT INTO `antrian_pasien` (`id`, `username`, `name`, `poliklinik`, `age`, `symptom`, `date`) VALUES
(4, 'tisya', 'Metisya Darwi', 'KIA', 4, 'Pusing', '2021-05-22 20:52:04'),
(6, 'tisya', 'Metisya Darwi', 'Lansia', 20, 'Keselop', '2021-05-22 21:21:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `name`, `price`) VALUES
(1, 'Paracetamol', 5000),
(2, 'Neuralgin', 10000),
(3, 'Miconazole Nitrate', 9000),
(5, 'Amoxcillin', 8000),
(6, 'Gentamicin', 10000),
(7, 'Ampicillin', 3000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_kunjungan`
--

CREATE TABLE `riwayat_kunjungan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_visithistory` int(10) UNSIGNED NOT NULL,
  `username` text NOT NULL,
  `visit_date` datetime NOT NULL,
  `disease` text NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `riwayat_kunjungan`
--

INSERT INTO `riwayat_kunjungan` (`id`, `id_visithistory`, `username`, `visit_date`, `disease`, `note`) VALUES
(1, 1, 'tisya', '2021-05-22 20:35:24', 'Sakit biasa aja ini mah', 'Kurangi begadang'),
(2, 1, 'tisya', '2021-05-22 20:35:24', 'Sakit biasa aja ini mah', 'Kurangi begadang'),
(4, 3, 'tisya', '2021-05-22 20:50:50', 'Batuk', 'Minum Obat'),
(5, 5, 'tisya', '2021-05-22 20:56:27', 'Diare', 'Minum Obat Yo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_obat`
--

CREATE TABLE `riwayat_obat` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_medicine` int(11) UNSIGNED NOT NULL,
  `id_visithistory` int(10) UNSIGNED NOT NULL,
  `dose` text NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `riwayat_obat`
--

INSERT INTO `riwayat_obat` (`id`, `id_medicine`, `id_visithistory`, `dose`, `qty`, `price`) VALUES
(1, 5, 1, '3 x sehari', 3, 8000),
(3, 3, 3, '7 x sehari', 90, 9000),
(4, 7, 3, '10 x sehari', 10, 3000),
(5, 6, 5, '10 x sehari', 5, 10000),
(6, 2, 5, '12 botol sehari', 7, 10000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `full_name` text NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 1,
  `birth_date` date DEFAULT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `country` text NOT NULL DEFAULT 'Indonesia',
  `postal_code` int(11) NOT NULL,
  `bio` text NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `full_name`, `user_type`, `birth_date`, `address`, `city`, `country`, `postal_code`, `bio`) VALUES
(5, 'admin', 'admin@gmail.com', '$2y$10$BvtCxWqky8KbW0He9OjM/eOdIgdqZEi07UwNT9fkHtcTLzc7Iavkq', 'Admin Puskesmas', 2, '1997-05-06', 'Jl. Jalan jalan', 'Samarinda', 'Indonesia', 75571, 'Just Do It!'),
(13, 'tisya', 'tisya@gmail.com', '$2y$10$TtCjXGhsMR0SFBNnL2/R9uzFnOeYZO1ki8Ui6/Lgxg.FJLw.DXYra', 'Metisya Darwi', 0, '2001-02-21', 'Loa Janan', 'Balikpapan', 'Indonesia', 14022, 'Cwk'),
(14, 'dokter', 'dokter@gmail.com', '$2y$10$rPrmc9pf6G8OCLmeX.K/oecfKpkZqHcVdxZxlEO4aZCTFbf4rLJUm', 'Dr.Tirta', 1, '2020-12-11', 'Jl. Jakarta', 'Jakarta', 'Arab', 71241, 'dawdadawd');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `antrian_pasien`
--
ALTER TABLE `antrian_pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_kunjungan`
--
ALTER TABLE `riwayat_kunjungan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_obat`
--
ALTER TABLE `riwayat_obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `antrian_pasien`
--
ALTER TABLE `antrian_pasien`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `riwayat_kunjungan`
--
ALTER TABLE `riwayat_kunjungan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `riwayat_obat`
--
ALTER TABLE `riwayat_obat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
