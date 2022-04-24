<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'beranda';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* Routing halaman admin */
$route['beranda-admin'] = 'admin/beranda/index';
$route['login-user'] = 'admin/login/index';
$route['logout-user'] = 'admin/login/logout';

// routing group pengaturan
$route['pengaturan-admin'] = 'admin/pengaturan/index';
$route['data-pengguna'] = 'admin/pengguna/index';
$route['pengaturan-jurusan'] = 'admin/jurusan/index';
$route['pengaturan-kelas'] = 'admin/kelas/index';
$route['pengaturan-tanda_pengenal'] = 'admin/tanda_pengenal/index';
$route['pengaturan-jenis_setoran'] = 'admin/jenis_setoran/index';
$route['pengaturan-naik_kelas'] = 'admin/naik_kelas/index';

// routing group nasabah
$route['nasabah'] = 'admin/nasabah/index';
$route['cek-saldo-nasabah'] = 'admin/cek_saldo_nasabah/index';
$route['nasabah-tidak-aktif'] = 'admin/nasabah_tidak_aktif/index';
$route['export-nasabah-tidak-aktif'] = 'admin/nasabah_tidak_aktif/exportnasabahtidakaktif';

// routing group tabungan nasabah
$route['setoran-masuk'] = 'admin/setoran_masuk/index';
$route['cetak-bukti-setoran-masuk'] = 'admin/setoran_masuk/cetakbuktisetoranmasuk';
$route['cetak-chi-setoran-masuk'] = 'admin/setoran_masuk/cetaksetoranmasukhariini';
$route['export-chi-setoran-masuk'] = 'admin/setoran_masuk/exportsetoranmasukhariini';
$route['cetak-css-setoran-masuk'] = 'admin/setoran_masuk/cetaksemuasetoranmasuk';
$route['export-css-setoran-masuk'] = 'admin/setoran_masuk/exportsemuasetoranmasuk';
$route['export-setoran-masuk-per-tanggal'] = 'admin/setoran_masuk/exportsetoranmasukpertanggal';

$route['penarikan-tabungan'] = 'admin/penarikan_tabungan/index';
$route['cetak-bukti-penarikan-tabungan'] = 'admin/penarikan_tabungan/cetakbuktipenarikantabungan';
$route['cetak-chi-penarikan-tabungan'] = 'admin/penarikan_tabungan/cetakpenarikantabunganhariini';
$route['export-chi-penarikan-tabungan'] = 'admin/penarikan_tabungan/exportpenarikantabunganhariini';
$route['cetak-css-penarikan-tabungan'] = 'admin/penarikan_tabungan/cetaksemuapenarikantabungan';
$route['export-css-penarikan-tabungan'] = 'admin/penarikan_tabungan/exportsemuapenarikantabungan';
$route['export-penarikan-tabungan-per-tanggal'] = 'admin/penarikan_tabungan/exportpenarikantabunganpertanggal';


// routing group transaksi pembayaran
$route['pembayaran-siswa'] = 'admin/pembayaran_siswa/index';
$route['cetak-bukti-pembayaran-siswa'] = 'admin/pembayaran_siswa/cetakbuktipembayaransiswa';
$route['cetak-chi-pembayaran-siswa'] = 'admin/pembayaran_siswa/cetakpembayaransiswahariini';
$route['export-chi-pembayaran-siswa'] = 'admin/pembayaran_siswa/exportpembayaransiswahariini';
$route['cetak-css-pembayaran-siswa'] = 'admin/pembayaran_siswa/cetaksemuapembayaransiswa';
$route['export-css-pembayaran-siswa'] = 'admin/pembayaran_siswa/exportsemuapembayaransiswa';
$route['export-pembayaran-siswa-per-tanggal'] = 'admin/pembayaran_siswa/exportpembayaransiswapertanggal';

$route['penarikan-saldo'] = 'admin/penarikan_saldo/index';
$route['cetak-bukti-penarikan-saldo'] = 'admin/penarikan_saldo/cetakbuktipenarikansaldo';
$route['cetak-chi-penarikan-saldo'] = 'admin/penarikan_saldo/cetakpenarikansaldohariini';
$route['export-chi-penarikan-saldo'] = 'admin/penarikan_saldo/exportpenarikansaldohariini';
$route['cetak-css-penarikan-saldo'] = 'admin/penarikan_saldo/cetaksemuapenarikansaldo';
$route['export-css-penarikan-saldo'] = 'admin/penarikan_saldo/exportsemuapenarikansaldo';
$route['export-penarikan-saldo-per-tanggal'] = 'admin/penarikan_saldo/exportpenarikansaldopertanggal';

/* Akhir routing halaman transaksi semua */
$route['rekap-tabungan'] = 'admin/rekap_tabungan/index';
$route['cetak-css-rekap-tabungan'] = 'admin/rekap_tabungan/cetaksemuarekaptabungan';
$route['export-css-rekap-tabungan'] = 'admin/rekap_tabungan/exportsemuarekaptabungan';
$route['export-rekap-tabungan-per-tanggal'] = 'admin/rekap_tabungan/exportrekaptabunganpertanggal';

$route['rekap-pembayaran'] = 'admin/rekap_pembayaran/index';
$route['cetak-css-rekap-pembayaran'] = 'admin/rekap_pembayaran/cetaksemuarekappembayaran';
$route['export-css-rekap-pembayaran'] = 'admin/rekap_pembayaran/exportsemuarekappembayaran';
$route['export-rekap-pembayaran-per-tanggal'] = 'admin/rekap_pembayaran/exportrekappembayaranpertanggal';

$route['cek-saldo-tabungan'] = 'admin/cek_saldo_tabungan/index';
$route['cek-saldo-bankmini'] = 'admin/cek_saldo_bankmini/index';


$route['profil'] = 'admin/profil/index';



/* Akhir routing halaman admin */




