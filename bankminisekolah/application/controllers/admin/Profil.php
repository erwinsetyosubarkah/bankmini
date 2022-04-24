<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Profil extends CI_Controller{
    
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
            $data['header_halaman'] = 'Profil';
            $data['icon_header_halaman'] = 'user-secret';
                  
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/profil/profil',$data); 
            $this->load->view('admin/templates/footer');
            
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }

    }

   
}