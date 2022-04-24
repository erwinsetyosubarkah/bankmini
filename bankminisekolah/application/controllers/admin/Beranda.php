<?php 


class Beranda extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('tgl_indo');
        $this->tanggal = date("Y-m-d");
        $this->bulan = date("m");
        $this->tahun = date("Y");
        $this->hari = date("l");
    }

    public function index(){
        
       if($this->session->userdata('user') == null){
           redirect(base_url().'login-user');
           die();
       }

       if($_SESSION['user']['level'] == 'Administrator' || $_SESSION['user']['level'] == 'Operator' || $_SESSION['user']['level'] == 'Teller'){

           
           $this->load->model('admin/Pengguna_model');
           
           $this->load->model('admin/Pengaturan_model');
           $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById();    
           $data['header_halaman'] = 'Dasbor';
           $data['icon_header_halaman'] = 'tachometer-alt';
           
           $tanggal_hari_ini = date('Y-m-d');
           $bulan_ini = date('m');
           $tahun_ini = date('Y');
           
           // data transaksi bank mini hari ini
           $this->load->model('admin/Setoran_masuk_model');
           $data['setoran_masuk_hari_ini'] = $this->Setoran_masuk_model->totalSetoranMasukByDate($tanggal_hari_ini);
           $this->load->model('admin/Penarikan_tabungan_model');
           $data['penarikan_tabungan_hari_ini'] = $this->Penarikan_tabungan_model->totalPenarikanTabunganByDate($tanggal_hari_ini);
           $this->load->model('admin/Pembayaran_siswa_model');
           $data['pembayaran_siswa_hari_ini'] = $this->Pembayaran_siswa_model->totalPembayaranSiswaByDate($tanggal_hari_ini);
           $this->load->model('admin/Penarikan_saldo_model');
           $data['penarikan_saldo_hari_ini'] = $this->Penarikan_saldo_model->totalPenarikanSaldoByDate($tanggal_hari_ini);
           
           // data transaksi bank mini bulan ini
           $this->load->model('admin/Setoran_masuk_model');
           $data['setoran_masuk_bulan_ini'] = $this->Setoran_masuk_model->totalSetoranMasukBulanIni($bulan_ini,$tahun_ini);
           $this->load->model('admin/Penarikan_tabungan_model');
           $data['penarikan_tabungan_bulan_ini'] = $this->Penarikan_tabungan_model->totalPenarikanTabunganBulanIni($bulan_ini,$tahun_ini);
           $this->load->model('admin/Pembayaran_siswa_model');
           $data['pembayaran_siswa_bulan_ini'] = $this->Pembayaran_siswa_model->totalPembayaranSiswaBulanIni($bulan_ini,$tahun_ini);
           $this->load->model('admin/Penarikan_saldo_model');
           $data['penarikan_saldo_bulan_ini'] = $this->Penarikan_saldo_model->totalPenarikanSaldoBulanIni($bulan_ini,$tahun_ini);
           
           //data nasabah
           $this->load->model('admin/Nasabah_model');
           $this->load->model('admin/Nasabah_tidak_aktif_model');
           $data['total_nasabah'] = $this->Nasabah_model->getAllData('nasabah');
           $data['total_nasabah_tidak_aktif'] = $this->Nasabah_tidak_aktif_model->getAllData('nasabah');
           
           $this->load->view('admin/templates/header',$data);
           $this->load->view('admin/beranda/index',$data); 
           $this->load->view('admin/templates/footer');    

        }else{
             redirect(base_url().'beranda-admin');
             die();
         }

    }
        
        
}