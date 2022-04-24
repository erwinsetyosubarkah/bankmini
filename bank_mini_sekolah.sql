-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Nov 2021 pada 17.16
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_mini_sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_setoran`
--

CREATE TABLE `jenis_setoran` (
  `id_jenis_setoran` varchar(255) NOT NULL,
  `jenis_setoran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_setoran`
--

INSERT INTO `jenis_setoran` (`id_jenis_setoran`, `jenis_setoran`) VALUES
('STR00001', 'Tabungan'),
('STR00002', 'Study Tour'),
('STR00003', 'SPP');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` varchar(255) NOT NULL,
  `jurusan` varchar(255) NOT NULL,
  `kode_jurusan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `jurusan`, `kode_jurusan`) VALUES
('JUR00001', 'Rekayasa Perangkat Lunak', 'RPL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` varchar(255) NOT NULL,
  `id_jurusan` varchar(255) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `rombel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `id_jurusan`, `tingkat`, `rombel`) VALUES
('KLS00001', 'JUR00001', 'X', '1'),
('KLS00002', 'JUR00001', 'X', '2'),
('KLS00003', 'JUR00001', 'XI', '1'),
('KLS00004', 'JUR00001', 'XI', '2'),
('KLS00005', 'JUR00001', 'XII', '1'),
('KLS00006', 'JUR00001', 'XII', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nasabah`
--

CREATE TABLE `nasabah` (
  `id_nasabah` varchar(255) NOT NULL,
  `nama_nasabah` varchar(255) NOT NULL,
  `jenis_kelamin_nasabah` varchar(15) NOT NULL,
  `tempat_lahir_nasabah` varchar(255) NOT NULL,
  `tanggal_lahir_nasabah` date NOT NULL,
  `alamat_nasabah` text NOT NULL,
  `no_telp_nasabah` varchar(255) NOT NULL,
  `id_tanda_pengenal` varchar(255) NOT NULL,
  `no_tanda_pengenal_nasabah` varchar(255) NOT NULL,
  `id_kelas` varchar(255) NOT NULL,
  `saldo_nasabah` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `nasabah`
--

INSERT INTO `nasabah` (`id_nasabah`, `nama_nasabah`, `jenis_kelamin_nasabah`, `tempat_lahir_nasabah`, `tanggal_lahir_nasabah`, `alamat_nasabah`, `no_telp_nasabah`, `id_tanda_pengenal`, `no_tanda_pengenal_nasabah`, `id_kelas`, `saldo_nasabah`) VALUES
('NSB00001', 'Lukman', 'Laki-laki', 'Bekasi', '2000-02-15', 'Bekasi', '0854672654', 'TPG00001', '546468946', 'KLS00003', 320000),
('NSB00002', 'Andi', 'Laki-laki', 'Bekasi', '1998-02-25', 'Bekasi', '08255645265', 'TPG00001', '565487944', 'KLS00003', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran_siswa`
--

CREATE TABLE `pembayaran_siswa` (
  `id_pembayaran_siswa` varchar(255) NOT NULL,
  `id_nasabah` varchar(255) NOT NULL,
  `id_jenis_setoran` varchar(255) NOT NULL,
  `tanggal_transaksi_pembayaran_siswa` date NOT NULL,
  `jumlah_pembayaran_siswa` bigint(255) NOT NULL,
  `id_pengguna` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran_siswa`
--

INSERT INTO `pembayaran_siswa` (`id_pembayaran_siswa`, `id_nasabah`, `id_jenis_setoran`, `tanggal_transaksi_pembayaran_siswa`, `jumlah_pembayaran_siswa`, `id_pengguna`) VALUES
('PMS00000001', 'NSB00001', 'STR00002', '2021-07-30', 250000, 'USR00001'),
('PMS00000002', 'NSB00001', 'STR00003', '2021-07-30', 200000, 'USR00001'),
('PMS00000003', 'NSB00002', 'STR00002', '2021-07-30', 250000, 'USR00001'),
('PMS00000004', 'NSB00002', 'STR00003', '2021-07-30', 300000, 'USR00001'),
('PMS00000005', 'NSB00002', 'STR00002', '2021-07-31', 200000, 'USR00001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penarikan_saldo`
--

CREATE TABLE `penarikan_saldo` (
  `id_penarikan_saldo` varchar(255) NOT NULL,
  `tanggal_transaksi_penarikan_saldo` date NOT NULL,
  `nama_penarik_saldo` varchar(255) NOT NULL,
  `jumlah_penarikan_saldo` bigint(255) NOT NULL,
  `keterangan_penarikan_saldo` varchar(255) NOT NULL,
  `id_pengguna` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penarikan_saldo`
--

INSERT INTO `penarikan_saldo` (`id_penarikan_saldo`, `tanggal_transaksi_penarikan_saldo`, `nama_penarik_saldo`, `jumlah_penarikan_saldo`, `keterangan_penarikan_saldo`, `id_pengguna`) VALUES
('PNS00000001', '2021-07-30', 'Pak Hadi', 800000, 'Bayar Study Tour', 'USR00001'),
('PNS00000002', '2021-07-31', 'Pak Hadi', 100000, 'Testing', 'USR00001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penarikan_tabungan`
--

CREATE TABLE `penarikan_tabungan` (
  `id_penarikan_tabungan` varchar(255) NOT NULL,
  `id_nasabah` varchar(255) NOT NULL,
  `tanggal_transaksi_penarikan_tabungan` date NOT NULL,
  `jumlah_penarikan_tabungan` bigint(255) NOT NULL,
  `keterangan_penarikan_tabungan` text NOT NULL,
  `id_pengguna` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penarikan_tabungan`
--

INSERT INTO `penarikan_tabungan` (`id_penarikan_tabungan`, `id_nasabah`, `tanggal_transaksi_penarikan_tabungan`, `jumlah_penarikan_tabungan`, `keterangan_penarikan_tabungan`, `id_pengguna`) VALUES
('PNR00000002', 'NSB00002', '2021-07-30', 100000, 'Kebutuhan Mendadak', 'USR00001'),
('PNR00000003', 'NSB00002', '2021-07-30', 10000, 'fhgfh', 'USR00001'),
('PNR00000004', 'NSB00001', '2021-07-31', 100000, 'Testing', 'USR00001'),
('PNR00000005', 'NSB00002', '2021-07-31', 40000, 'Testing', 'USR00001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `nspn` int(11) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `jalan` varchar(255) NOT NULL,
  `rt` varchar(255) NOT NULL,
  `rw` varchar(255) NOT NULL,
  `kelurahan` varchar(255) NOT NULL,
  `kecamatan` varchar(255) NOT NULL,
  `kabupaten_kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `website` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `nama_kepsek` varchar(255) NOT NULL,
  `sambutan_kepala_sekolah` text NOT NULL,
  `foto_kepsek` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `kop_surat_image` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `motto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nspn`, `nama_sekolah`, `jalan`, `rt`, `rw`, `kelurahan`, `kecamatan`, `kabupaten_kota`, `provinsi`, `kode_pos`, `website`, `email`, `telp`, `nama_kepsek`, `sambutan_kepala_sekolah`, `foto_kepsek`, `logo`, `kop_surat_image`, `facebook`, `twitter`, `youtube`, `instagram`, `motto`) VALUES
(1, 12345, 'SMK Mandalahayu', 'Jl. Margahayu Jaya No.304-312', '007', '017', 'Margahayu', 'Bekasi Timur', 'Kota Bekasi', 'Jawa Barat', '17113', 'http://ppdb.smkmandalahayu1.sch.id/', '-', '021-8223143', 'Dra. Sulistyawati', '', 'noimage1.png', 'logo1.png', '200px-No_image_3x4_svg2.png', '', '', '', '', 'Coming together is beginning, Keeping together is progress, Working together is success');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_pengguna` enum('Guru','Staf','Siswa') NOT NULL,
  `level` enum('Administrator','Operator','Teller') NOT NULL,
  `foto_pengguna` varchar(255) NOT NULL,
  `tgl_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `username`, `password`, `status_pengguna`, `level`, `foto_pengguna`, `tgl_login`) VALUES
('USR00001', 'Administrator', 'admin', '$2y$10$.G9F9I8RmufM55kw/7oAUes6m4pn9Vbe7qh9H39ZX/EzHbfdZY1m2', 'Guru', 'Administrator', 'Pemrograman_Dasar_Pada_Java_Cover.jpg', '2021-11-05 21:25:59'),
('USR00002', 'Operator', 'operator', '$2y$10$1kvD7yYIIkm1cD9JnY/nCeUCunWibAY.EBP6AnSYkSpN6Zj0qoV4C', 'Guru', 'Operator', 'download.png', '2021-08-01 15:26:40'),
('USR00003', 'Teller', 'teller', '$2y$10$it1cJnhqM0S/Plx/lNmP2OM.kyqL25TZPsjzIjnsgVygCt/bHHmPu', 'Siswa', 'Teller', 'logo-mandalahayu.png', '2021-08-01 15:28:13'),
('USR00004', 'Administrator2', 'admin2', '$2y$10$..R0NcGpZtvdu0EWR.oAYuBS/GpiyBd1cy2iFLz5huCOH3GJqBX2a', 'Guru', 'Administrator', 'logo-mandalahayu1.png', '2021-07-31 10:06:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setoran_masuk`
--

CREATE TABLE `setoran_masuk` (
  `id_setoran_masuk` varchar(255) NOT NULL,
  `id_nasabah` varchar(255) NOT NULL,
  `id_jenis_setoran` varchar(255) NOT NULL,
  `tanggal_transaksi_setoran_masuk` date NOT NULL,
  `jumlah_setoran_masuk` bigint(255) NOT NULL,
  `id_pengguna` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `setoran_masuk`
--

INSERT INTO `setoran_masuk` (`id_setoran_masuk`, `id_nasabah`, `id_jenis_setoran`, `tanggal_transaksi_setoran_masuk`, `jumlah_setoran_masuk`, `id_pengguna`) VALUES
('STM00000003', 'NSB00002', 'STR00001', '2021-07-30', 150000, 'USR00001'),
('STM00000004', 'NSB00001', 'STR00001', '2021-07-31', 200000, 'USR00001'),
('STM00000005', 'NSB00001', 'STR00001', '2021-08-01', 100000, 'USR00001'),
('STM00000006', 'NSB00001', 'STR00001', '2021-08-01', 120000, 'USR00001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanda_pengenal`
--

CREATE TABLE `tanda_pengenal` (
  `id_tanda_pengenal` varchar(255) NOT NULL,
  `jenis_tanda_pengenal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tanda_pengenal`
--

INSERT INTO `tanda_pengenal` (`id_tanda_pengenal`, `jenis_tanda_pengenal`) VALUES
('TPG00001', 'Kartu Pelajar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_bankmini`
--

CREATE TABLE `transaksi_bankmini` (
  `id` int(11) NOT NULL,
  `id_transaksi_bankmini` varchar(255) NOT NULL,
  `tanggal_transaksi_bankmini` date NOT NULL,
  `jumlah_pembayaran_siswa` bigint(255) NOT NULL,
  `jumlah_penarikan_saldo` bigint(255) NOT NULL,
  `id_nasabah` varchar(255) NOT NULL,
  `nama_penarik` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_bankmini`
--

INSERT INTO `transaksi_bankmini` (`id`, `id_transaksi_bankmini`, `tanggal_transaksi_bankmini`, `jumlah_pembayaran_siswa`, `jumlah_penarikan_saldo`, `id_nasabah`, `nama_penarik`) VALUES
(3, 'PMS00000001', '2021-07-30', 250000, 0, 'NSB00001', ''),
(4, 'PMS00000002', '2021-07-30', 200000, 0, 'NSB00001', ''),
(5, 'PMS00000003', '2021-07-30', 250000, 0, 'NSB00002', ''),
(6, 'PMS00000004', '2021-07-30', 300000, 0, 'NSB00002', ''),
(9, 'PNS00000001', '2021-07-30', 0, 800000, '', 'Pak Hadi'),
(10, 'PMS00000005', '2021-07-31', 200000, 0, 'NSB00002', ''),
(11, 'PNS00000002', '2021-07-31', 0, 100000, '', 'Pak Hadi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_tabungan`
--

CREATE TABLE `transaksi_tabungan` (
  `id` int(11) NOT NULL,
  `id_transaksi_tabungan` varchar(255) NOT NULL,
  `tanggal_transaksi_tabungan` date NOT NULL,
  `jumlah_setoran_masuk` bigint(255) NOT NULL,
  `jumlah_penarikan_tabungan` bigint(255) NOT NULL,
  `id_nasabah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_tabungan`
--

INSERT INTO `transaksi_tabungan` (`id`, `id_transaksi_tabungan`, `tanggal_transaksi_tabungan`, `jumlah_setoran_masuk`, `jumlah_penarikan_tabungan`, `id_nasabah`) VALUES
(3, 'STM00000003', '2021-07-30', 150000, 0, 'NSB00002'),
(7, 'PNR00000002', '2021-07-30', 0, 100000, 'NSB00002'),
(8, 'PNR00000003', '2021-07-30', 0, 10000, 'NSB00002'),
(9, 'STM00000004', '2021-07-31', 200000, 0, 'NSB00001'),
(10, 'PNR00000004', '2021-07-31', 0, 100000, 'NSB00001'),
(11, 'PNR00000005', '2021-07-31', 0, 40000, 'NSB00002'),
(12, 'STM00000005', '2021-08-01', 100000, 0, 'NSB00001'),
(13, 'STM00000006', '2021-08-01', 120000, 0, 'NSB00001');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jenis_setoran`
--
ALTER TABLE `jenis_setoran`
  ADD PRIMARY KEY (`id_jenis_setoran`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id_nasabah`);

--
-- Indeks untuk tabel `pembayaran_siswa`
--
ALTER TABLE `pembayaran_siswa`
  ADD PRIMARY KEY (`id_pembayaran_siswa`);

--
-- Indeks untuk tabel `penarikan_saldo`
--
ALTER TABLE `penarikan_saldo`
  ADD PRIMARY KEY (`id_penarikan_saldo`);

--
-- Indeks untuk tabel `penarikan_tabungan`
--
ALTER TABLE `penarikan_tabungan`
  ADD PRIMARY KEY (`id_penarikan_tabungan`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `id_grup_pengguna` (`nama_pengguna`);

--
-- Indeks untuk tabel `setoran_masuk`
--
ALTER TABLE `setoran_masuk`
  ADD PRIMARY KEY (`id_setoran_masuk`);

--
-- Indeks untuk tabel `tanda_pengenal`
--
ALTER TABLE `tanda_pengenal`
  ADD PRIMARY KEY (`id_tanda_pengenal`);

--
-- Indeks untuk tabel `transaksi_bankmini`
--
ALTER TABLE `transaksi_bankmini`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi_tabungan`
--
ALTER TABLE `transaksi_tabungan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksi_bankmini`
--
ALTER TABLE `transaksi_bankmini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `transaksi_tabungan`
--
ALTER TABLE `transaksi_tabungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
