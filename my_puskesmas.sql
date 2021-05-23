-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 23 Bulan Mei 2021 pada 12.29
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
(5, 5, 'tisya', '2021-05-22 20:56:27', 'Diare', 'Minum Obat Yo'),
(6, 7, 'jero', '2021-05-23 12:29:06', 'Sakit Perut Biasa Aja Itu', 'Minum obat nya ye');

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
(6, 2, 5, '12 botol sehari', 7, 10000),
(7, 7, 7, '4 kali sehari', 3, 3000),
(8, 2, 7, '50 kali sehari', 5, 10000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `id_visithistory` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembali` int(11) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `id_visithistory`, `total`, `bayar`, `kembali`, `tanggal`) VALUES
(5, 5, 120000, 120000, 0, '2021-05-23 20:02:28'),
(6, 1, 24000, 25000, 1000, '2021-05-23 20:03:56'),
(7, 7, 59000, 60000, 1000, '2021-05-23 20:06:06'),
(8, 3, 840000, 1000000, 160000, '2021-05-23 20:06:44');

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
(14, 'dokter', 'dokter@gmail.com', '$2y$10$rPrmc9pf6G8OCLmeX.K/oecfKpkZqHcVdxZxlEO4aZCTFbf4rLJUm', 'Dr.Tirta', 1, '2020-12-11', 'Jl. Jakarta', 'Jakarta', 'Arab', 71241, 'dawdadawd'),
(15, 'elsa', 'elsa@gmail.com', '$2y$10$eTdF7uHCWoIjxKjITRQdfeR1UkhrsSoenQaGeSTkkcCUrosXzLHSS', 'Elsa Mardhiyah', 0, '2001-01-17', 'Jl. Jalan', 'Balikpapan', 'Irak', 12345, 'Cwk'),
(16, 'jero', 'jero@gmail.com', '$2y$10$fMm.ZzTOaIYx0cr.tfMAXu3egs4sZvMiQE.POIlqWfDKc8PSg0Z7.', 'Jeroline Betsy Angela', 0, '2019-06-20', 'Jl. Mantab', 'Gaza', 'Iran', 54321, 'Jero ubah');

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
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `riwayat_kunjungan`
--
ALTER TABLE `riwayat_kunjungan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `riwayat_obat`
--
ALTER TABLE `riwayat_obat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
