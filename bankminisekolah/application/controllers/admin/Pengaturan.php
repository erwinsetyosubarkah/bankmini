<?php 



class Pengaturan extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if($this->session->userdata('user') == null){
            redirect(base_url().'login-user');
            die();
        }

        if($_SESSION['user']['level'] == 'Administrator'){

            
            $this->load->model('admin/Pengaturan_model');
            $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 
            $data['header_halaman'] = 'Pengaturan';
            $data['icon_header_halaman'] = 'cog';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/pengaturan/pengaturan',$data); 
            $this->load->view('admin/templates/footer');

        }else{
             redirect(base_url().'beranda-admin');
             die();
         }
         
    }

    public function query(){
        $this->load->model('admin/Pengaturan_model');
        $result = $this->Pengaturan_model->query();  

        echo json_encode($result);
    }

    public function ubah(){
        $data = $_POST;
        
        $foto_kepsek_lama = $data['foto_kepsek_lama'];

        // upload foto kepsek
        if(!isset($data['foto_kepsek'])){
            if(!empty($_FILES['foto_kepsek']['name'])){
                $config = array();
                $config['upload_path']          =  './assets/img/foto/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 10000;        
                
                $this->load->library('upload', $config, 'foto_kepsek_upload'); // Create custom object for cover upload
                $this->foto_kepsek_upload->initialize($config);
                $this->foto_kepsek_upload->do_upload('foto_kepsek');
                $foto_kepsek = $this->foto_kepsek_upload->data('file_name');
                $data['foto_kepsek'] = $foto_kepsek;
                if($foto_kepsek_lama != '' || $foto_kepsek_lama != null){
                    if(file_exists('./assets/img/foto/'.$foto_kepsek_lama)){
                        unlink('./assets/img/foto/'.$foto_kepsek_lama);
                    }
                }
            }
        }else{
           $foto_kepsek = $foto_kepsek_lama;
        }


        $logo_lama = $data['logo_lama'];
        
        // upload logo
        if(!isset($data['logo'])){
            if(!empty($_FILES['logo']['name'])){
                $config = array();
                $config['upload_path']          =  './assets/img/icon/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 10000;        
                
                $this->load->library('upload', $config, 'logo_upload'); // Create custom object for cover upload
                $this->logo_upload->initialize($config);
                $this->logo_upload->do_upload('logo');
                $logo = $this->logo_upload->data('file_name');
                $data['logo'] = $logo;
                if($logo_lama != '' || $logo_lama != null){
                    if (file_exists('./assets/img/icon/'.$logo_lama)) {
                        unlink('./assets/img/icon/'.$logo_lama);
                    }
                }
            }
        }else{
           $logo = $logo_lama;
        }


        $kop_surat_image_lama = $data['kop_surat_image_lama'];

        // upload kop surat
        if(!isset($data['kop_surat_image'])){
            if(!empty($_FILES['kop_surat_image']['name'])){
                $config = array();
                $config['upload_path']          =  './assets/img/gambar/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 10000;        
                
                $this->load->library('upload', $config, 'kop_surat_image_upload'); // Create custom object for cover upload
                $this->kop_surat_image_upload->initialize($config);
                $this->kop_surat_image_upload->do_upload('kop_surat_image');
                $kop_surat_image = $this->kop_surat_image_upload->data('file_name');
                $data['kop_surat_image'] = $kop_surat_image;
                if($kop_surat_image_lama != '' || $kop_surat_image_lama != null){
                    if (file_exists('./assets/img/gambar/images'.$kop_surat_image_lama)) {
                        unlink('./assets/img/gambar/'.$kop_surat_image_lama);
                    }
                }
            }
        }else{
           $kop_surat_image = $kop_surat_image_lama;
        }
        
        
        $data['foto_kepsek'] = $foto_kepsek;
        $data['logo'] = $logo;
        $data['kop_surat_image'] = $kop_surat_image;
        unset ($data['foto_kepsek_lama']);
        unset ($data['logo_lama']);
        unset ($data['kop_surat_image_lama']);
        
        $this->load->model('admin/Pengaturan_model');
        $status = $this->Pengaturan_model->ubah($data);
          if($status == 1){         
              $data = [
                  'status' => 'success',
                  'title' => 'Berhasil',
                  'pesan' => 'Data berhasil Diubah'
              ];
          }else{
            $data = [
                'status' => 'error',
                'title'  => 'Gagal',
                'pesan' => 'Data gagal Diubah'
            ];
        }          

        echo json_encode($data);
    }

    
}