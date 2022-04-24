<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Cek_saldo_bankmini extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('tgl_indo');
        $this->tanggal = date("Y-m-d");
        $this->bulan = date("m");
        $this->tahun = date("Y");
        $this->hari = date("l");
    }

    public function index()
    {
        if($this->session->userdata('user') == null){
            redirect(base_url().'login-user');
            die();
        }

        if($_SESSION['user']['level'] == 'Administrator' || $_SESSION['user']['level'] == 'Operator' || $_SESSION['user']['level'] == 'Teller'){

            $this->load->model('admin/Pengaturan_model');
            $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 
            $data['header_halaman'] = 'Cek Saldo Bank Mini';
            $data['icon_header_halaman'] = 'dollar-sign';
            
            $data['tanggal_sekarang'] = tanggal_indonesia(date('Y-m-d'));
            $this->load->model('admin/Rekap_pembayaran_model');
            $data['total_pembayaran_siswa'] = $this->Rekap_pembayaran_model->totalPembayaranSiswa(); 
            $data['total_penarikan_saldo'] = $this->Rekap_pembayaran_model->totalPenarikanSaldo(); 
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/cek_saldo_bankmini/cek_saldo_bankmini',$data); 
            $this->load->view('admin/templates/footer');
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }
         
    }

   
}