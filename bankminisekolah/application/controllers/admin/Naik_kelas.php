<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Naik_kelas extends CI_Controller{
    
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

        if($_SESSION['user']['level'] == 'Administrator' || $_SESSION['user']['level'] == 'Operator'){

            
            $this->load->model('admin/Pengaturan_model');
            $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 
            $data['header_halaman'] = 'Pengaturan Kenaikan Kelas';
            $data['icon_header_halaman'] = 'users';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/naik_kelas/naik_kelas',$data); 
            $this->load->view('admin/templates/footer');

        }else{
             redirect(base_url().'beranda-admin');
             die();
         }
         
    }


    public function naik(){

        $this->load->model('admin/Naik_kelas_model');
        $status = $this->Naik_kelas_model->naik();
     

        echo json_encode($status);


    }

}