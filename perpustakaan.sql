-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jun 2020 pada 14.54
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(5) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `prodi` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nim`, `nama`, `prodi`, `email`, `password`) VALUES
(2, '41518010147', 'Tengku Iqbal Nugraha', 'Informatika', 'iqbalnugraha347@gmail.com', '41518010147'),
(3, '4151701010', 'Mark Zuckeberg', 'Informatika', 'marckZuck12@gmail.com', '4151701010'),
(4, '41515101051', 'Hendra Pratik Aditama', 'Akuntansi', 'hendraPaditama30@gmail.com', '41518010065'),
(5, '41518010120', 'Aldy Muhammad Rahim', 'Hukum', 'aldyyyy@gmail.com', '41518010023'),
(6, '41518010066', 'Muhammad Iqbal', 'Informatika', 'mIqbal86@gmail.com', '41518010066'),
(7, '41518010072', 'Andreaa Ferdyansyah Solichin', 'Teknik Industri', 'AndreaaFS@gmail.com', '41518010072'),
(8, '41518010057', 'Tri Putra Adimas', 'Akuntansi', 'Adimastp120@gmail.com', '41518010057'),
(9, '41618010102', 'Denny Farazumar A K', 'Teknik Industri', 'Denny001@gmail.com', '41618010102');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(8) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `id_kategori` int(4) NOT NULL,
  `id_penerbit` int(4) NOT NULL,
  `stok_buku` double NOT NULL,
  `gambar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `id_kategori`, `id_penerbit`, `stok_buku`, `gambar`) VALUES
(30, 'Clean Architecture', 10, 11, 119, 'Clean_Architecture232.jpg'),
(31, 'Clean Code', 10, 11, 49, 'Clean_Code13.jpg'),
(32, 'Cracking the Coding Interview', 10, 7, 34, 'Cracking_the_Coding_Interview53.jpg'),
(33, 'Cracking the Tech Career', 11, 12, 57, 'Cracking_the_Tech_Career3.jpg'),
(34, 'Kotlin Android Developer Expert', 13, 9, 99, 'KADE23.jpg'),
(35, 'The Mythical Man-Month', 12, 11, 118, 'The_Mythical_Man-Month23.jpg'),
(36, 'The Pragmatic Programmer', 10, 11, 39, 'The_Pragmatic_Programmer12.jpg'),
(37, 'On the Origin of Species', 15, 13, 33, 'On_the_Origin_of_Species1.jpg'),
(38, 'A Brief History of Time', 15, 14, 48, 'BriefHistoryTime2.jpg'),
(39, 'Membangun Progressif Web Apps', 10, 9, 98, 'ProgessifWebApps2.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `denda`
--

CREATE TABLE `denda` (
  `id_denda` int(5) NOT NULL,
  `Jumlah` varchar(50) NOT NULL,
  `id_jenis_denda` int(2) NOT NULL,
  `kd_kembali` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `denda`
--

INSERT INTO `denda` (`id_denda`, `Jumlah`, `id_jenis_denda`, `kd_kembali`) VALUES
(12, '1', 11, 36),
(13, '1', 9, 35),
(14, '2', 5, 35);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `Id_detail` int(5) NOT NULL,
  `Kd_Peminjaman` varchar(100) CHARACTER SET latin1 NOT NULL,
  `id_buku` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`Id_detail`, `Kd_Peminjaman`, `id_buku`) VALUES
(7, 'TR001', 36),
(8, 'TR001', 31),
(9, 'TR002', 32),
(10, 'TR002', 39),
(11, 'TR001', 39),
(13, 'TR003', 34),
(15, 'TR003', 37),
(16, 'TR003', 38),
(17, 'TR004', 30),
(18, 'TR004', 38);

--
-- Trigger `detail_peminjaman`
--
DELIMITER $$
CREATE TRIGGER `update_jumlah` AFTER INSERT ON `detail_peminjaman` FOR EACH ROW BEGIN
 UPDATE peminjaman
 SET Jumlah = Jumlah + 1
 WHERE
 kd_pinjam = NEW.kd_peminjaman;
 END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_jumlah_1` AFTER DELETE ON `detail_peminjaman` FOR EACH ROW BEGIN
 UPDATE peminjaman
 SET Jumlah = Jumlah - 1
 WHERE
 kd_pinjam = OLD.kd_peminjaman;
 END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok` AFTER INSERT ON `detail_peminjaman` FOR EACH ROW BEGIN
 UPDATE buku
 SET stok_buku = stok_buku - 1
 WHERE
 id_buku = NEW.id_buku;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_denda`
--

CREATE TABLE `jenis_denda` (
  `id_jenis_denda` int(10) NOT NULL,
  `jenis_denda` varchar(50) NOT NULL,
  `biaya` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_denda`
--

INSERT INTO `jenis_denda` (`id_jenis_denda`, `jenis_denda`, `biaya`) VALUES
(5, 'Buku Rusak', '30000'),
(9, 'Buku Hilang', '100000'),
(11, 'Pengembalian Telat', '10000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(4) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`) VALUES
(10, 'Programming'),
(11, 'Technology & Career'),
(12, 'Software Engineering'),
(13, 'Mobile Development'),
(14, 'Web Development'),
(15, 'Science');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `kd_pinjam` varchar(100) NOT NULL,
  `id_anggota` int(5) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `bts_pinjam` date NOT NULL,
  `Jumlah` int(5) NOT NULL,
  `status` enum('Pinjam','Kembali') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`kd_pinjam`, `id_anggota`, `tgl_pinjam`, `bts_pinjam`, `Jumlah`, `status`) VALUES
('TR001', 2, '2020-06-02', '2020-06-16', 3, 'Kembali'),
('TR002', 5, '2020-06-02', '2020-06-16', 2, 'Kembali'),
('TR003', 4, '2020-06-02', '2020-06-16', 3, 'Pinjam'),
('TR004', 6, '2020-06-02', '2020-06-16', 2, 'Pinjam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerbit`
--

CREATE TABLE `penerbit` (
  `id_penerbit` int(4) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penerbit`
--

INSERT INTO `penerbit` (`id_penerbit`, `penerbit`, `tahun_terbit`) VALUES
(7, 'CareerCup', 0),
(8, 'Prentice Hall', 0),
(9, 'Dicoding Indonesia', 0),
(10, 'David Thomas', 0),
(11, 'Addison Wesley', 0),
(12, 'Wiley', 0),
(13, 'Charles Darwin', 0),
(14, 'Stephen Hawking', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `kd_kembali` int(5) NOT NULL,
  `kd_pinjam` varchar(100) NOT NULL,
  `tgl_kembali` date NOT NULL,
  `jumlah` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`kd_kembali`, `kd_pinjam`, `tgl_kembali`, `jumlah`) VALUES
(35, 'TR001', '2020-06-02', 2),
(36, 'TR002', '2020-06-17', 2);

--
-- Trigger `pengembalian`
--
DELIMITER $$
CREATE TRIGGER `update_status` AFTER INSERT ON `pengembalian` FOR EACH ROW BEGIN
 UPDATE peminjaman
 SET status = 'Kembali'
 WHERE
 kd_pinjam = NEW.kd_pinjam;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `NIP` varchar(100) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`NIP`, `nama`, `jenis_kelamin`, `alamat`, `telp`, `password`) VALUES
('41518010147', 'Bejo', 'L', 'Jl Bojong Indah No 1', '08121231322', '827ccb0eea8a706c4c34a16891f84e7b');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `FK_Kategori_Buku` (`id_kategori`),
  ADD KEY `FK_Penerbit_Buku` (`id_penerbit`);

--
-- Indeks untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id_denda`),
  ADD KEY `FK_denda_kembali` (`kd_kembali`),
  ADD KEY `FK_Jenis_denda` (`id_jenis_denda`);

--
-- Indeks untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`Id_detail`),
  ADD KEY `FK_Detail_Peminjaman` (`Kd_Peminjaman`),
  ADD KEY `FK_Detail_Buku` (`id_buku`);

--
-- Indeks untuk tabel `jenis_denda`
--
ALTER TABLE `jenis_denda`
  ADD PRIMARY KEY (`id_jenis_denda`),
  ADD KEY `jenis_denda` (`jenis_denda`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`kd_pinjam`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- Indeks untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id_penerbit`),
  ADD UNIQUE KEY `penerbit` (`penerbit`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`kd_kembali`),
  ADD KEY `kd_pinjam` (`kd_pinjam`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`NIP`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `denda`
--
ALTER TABLE `denda`
  MODIFY `id_denda` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `Id_detail` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `jenis_denda`
--
ALTER TABLE `jenis_denda`
  MODIFY `id_jenis_denda` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `kd_kembali` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `FK_Kategori_Buku` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `FK_Penerbit_Buku` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id_penerbit`);

--
-- Ketidakleluasaan untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD CONSTRAINT `FK_Jenis_denda` FOREIGN KEY (`id_jenis_denda`) REFERENCES `jenis_denda` (`id_jenis_denda`),
  ADD CONSTRAINT `FK_denda_kembali` FOREIGN KEY (`kd_kembali`) REFERENCES `pengembalian` (`kd_kembali`);

--
-- Ketidakleluasaan untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `FK_Detail_Buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `FK_Detail_Peminjaman` FOREIGN KEY (`Kd_Peminjaman`) REFERENCES `peminjaman` (`kd_pinjam`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `FK_Peminjaman_Anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`);

--
-- Ketidakleluasaan untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `FK_Pinjam_kembali` FOREIGN KEY (`kd_pinjam`) REFERENCES `peminjaman` (`kd_pinjam`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
