<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Pengguna extends CI_Controller{
    
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
            $data['header_halaman'] = 'Data Pengguna';
            $data['icon_header_halaman'] = 'cog';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/pengguna/pengguna',$data); 
            $this->load->view('admin/templates/footer');

        }else{
             redirect(base_url().'beranda-admin');
             die();
         }

    }

    public function queryAll()
    {
        $tabel = "pengguna";
        $select_column = [
            'pengguna.id_pengguna',
            'pengguna.nama_pengguna',
            'pengguna.username',
            'pengguna.status_pengguna',
            'pengguna.level',
            'pengguna.foto_pengguna',
            'pengguna.tgl_login'
        ];

        $order_column = [
            null,
            'pengguna.id_pengguna',
            'pengguna.nama_pengguna',
            'pengguna.username',
            'pengguna.status_pengguna',
            'pengguna.level',
            null,
            'pengguna.tgl_login',
            null
        ];
      
        $this->load->model('admin/Pengguna_model');
        $fetch_data = $this->Pengguna_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_pengguna;
            $sub_array[] = $row->nama_pengguna;
            $sub_array[] = $row->username;
            $sub_array[] = $row->status_pengguna;
            $sub_array[] = $row->level;
            if($row->foto_pengguna == '' || $row->foto_pengguna == null || !file_exists('./assets/img/foto/'.$row->foto_pengguna)){
                $sub_array[] = '<img src="'.base_url().'assets/img/foto/noimage.png" width="50">';
            }else{
                $sub_array[] = '<img src="'.base_url().'assets/img/foto/'.$row->foto_pengguna.'" width="50">';
            }
            $sub_array[] = $row->tgl_login;
            $sub_array[] = '
                            <button class="badge badge-primary badge-sm border-0" style="margin: 2px;" onclick="btnDetail(\''.$row->id_pengguna.'\')" title="Detail" data-toggle="modal" data-target="#modalDetailPengguna"><i class="fa fa-fw fa-info"></i></button> 
                            
                            <button class="badge badge-success badge-sm border-0" style="margin: 2px;" onclick="btnResetPassword(\''.$row->id_pengguna.'\')" title="Reset Password"><i class="fa fa-fw fa-key"></i></button> 
                            
                            <button class="badge badge-warning badge-sm border-0" style="margin: 2px;" onclick="btnModalUbah(\''.$row->id_pengguna.'\')" title="Ubah" data-toggle="modal" data-target="#modalPengguna"><i class="fa fa-fw fa-edit"></i></button> 
                            
                            <button class="badge badge-danger badge-sm border-0" style="margin: 2px;" onclick="btnModalHapus(\''.$row->id_pengguna.'\')" title="Hapus"><i class="fa fa-fw fa-trash"></i></button> 
                            ';
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Pengguna_model->getAllData($tabel,$select_column,$order_column),
            'recordsFiltered'   =>  $this->Pengguna_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }



    public function queryById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Pengguna_model');
        $data = $this->Pengguna_model->queryById($data);

        //jika foto tidak ada
        if($data['foto_pengguna'] == '' || $data['foto_pengguna'] == null || !file_exists('./assets/img/foto/'.$data['foto_pengguna'])){
            $data['foto_pengguna'] = 'noimage.png';
        }

        echo json_encode($data);
      
    }

    public function cekId(){
        $this->load->model('admin/Pengguna_model');
        $data = $this->Pengguna_model->cekID();

        echo json_encode($data);
    }

    public function tambah()
    {
        $data = $_POST;
        $this->load->model('admin/Pengguna_model');

        $avilableUsername = $this->Pengguna_model->cekUsername($data['username']);
        if($avilableUsername == 1){

                   
            $data = [
                'status' => 'error',
                'title' => 'Gagal',
                'pesan' => 'Data Gagal Ditambah....! Username Sudah Digunakan, Coba gunakan Username lain'
            ];
        }else{

             //jika user upload foto
             if(!isset($data['foto_pengguna'])){
                if(!empty($_FILES['foto_pengguna']['name'])){
                    $config = array();
                    $config['upload_path']          =  './assets/img/foto/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['max_size']             = 10000;        
                
                    $this->load->library('upload', $config, 'foto_penggunaupload'); // Create custom object for cover upload
                    $this->foto_penggunaupload->initialize($config);
                    $this->foto_penggunaupload->do_upload('foto_pengguna');
                    $foto_pengguna = $this->foto_penggunaupload->data('file_name');
                    $data['foto_pengguna'] = $foto_pengguna;
                }
            }
            $status = $this->Pengguna_model->tambah($data);
        
            if($status == 1){         
                $data = [
                    'status' => 'success',
                    'title' => 'Berhasil',
                    'pesan' => 'Data berhasil Ditambah....! Password sama dengan nomor ID'
                ];
            }else{
                $data = [
                    'status' => 'error',
                    'title'  => 'Gagal',
                    'pesan' => 'Data gagal Ditambah...!'
                ];
            }     
        }

        echo json_encode($data);
        
    }


    public function ubah()
    {
        $data = $_POST;
        $this->load->model('admin/Pengguna_model');

        $avilableUsername = $this->Pengguna_model->cekUsername($data['username']);
        $username_lama = $data['username_lama'];
        if($avilableUsername == 1 && $username_lama != $data['username']){

                   
            $data = [
                'status' => 'error',
                'title' => 'Gagal',
                'pesan' => 'Data Gagal Diubah....! Username Sudah Digunakan, Coba gunakan Username lain'
            ];
        }else{

            $foto_pengguna_lama = $data['foto_pengguna_lama'];
            
            //jika user upload foto
            if(!isset($data['foto_pengguna'])){
                if(!empty($_FILES['foto_pengguna']['name'])){
                    $config = array();
                    $config['upload_path']          =  './assets/img/foto/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['max_size']             = 10000;        
                
                    $this->load->library('upload', $config, 'foto_penggunaupload'); // Create custom object for cover upload
                    $this->foto_penggunaupload->initialize($config);
                    $this->foto_penggunaupload->do_upload('foto_pengguna');
                    $foto_pengguna = $this->foto_penggunaupload->data('file_name');
                    $data['foto_pengguna'] = $foto_pengguna;
                    if($foto_pengguna_lama != '' || $foto_pengguna_lama != null){
                        if (file_exists('./assets/img/foto/'.$foto_pengguna_lama)) {                
                            unlink('./assets/img/foto/'.$foto_pengguna_lama);
                        }
                    }
                }
            }else{                 
                $data['foto_pengguna'] = $foto_pengguna_lama;
            }

            
            unset($data['foto_pengguna_lama']);
            unset($data['username_lama']);
       
            $status = $this->Pengguna_model->ubah($data);

            $data_user = [
                'id_pengguna' => $data['id_pengguna']
            ];
            $this->load->model('admin/Pengguna_model');        
            $user = $this->Pengguna_model->queryById($data_user);
            $userdata = [
                'user' => $user
            ];                
            $this->session->set_userdata($userdata);
        
            if($status == 1){         
                $data = [
                    'status' => 'success',
                    'title' => 'Berhasil',
                    'pesan' => 'Data berhasil Diubah....!'
                ];
            }else{
                $data = [
                    'status' => 'error',
                    'title'  => 'Gagal',
                    'pesan' => 'Data gagal Diubah...!'
                ];
            }     
        }

        echo json_encode($data);
        
    }

    public function hapus(){
        $data = $_POST;

        $this->load->model('admin/Pengguna_model');
        $data = $this->Pengguna_model->queryById($data);

        $status = $this->Pengguna_model->hapus($data);
        if($data['foto_pengguna'] != '' || $data['foto_pengguna'] != null){
            if (file_exists('./assets/img/foto/'.$data['foto_pengguna'])) {  
                unlink('./assets/img/foto/'.$data['foto_pengguna']);
            }
        }

          if($status == 1){         
              $data = [
                  'status' => 'success',
                  'title' => 'Berhasil',
                  'pesan' => 'Data Berhasil di Hapus....!'
              ];
          }else{
            $data = [
                'status' => 'error',
                'title'  => 'Gagal',
                'pesan' => 'Data Gagal di Hapus....!'
            ];
        }     

        echo json_encode($data);


    }

    public function resetPassword(){  
        $data = $_POST;      

        $this->load->model('admin/Pengguna_model');
        $status = $this->Pengguna_model->resetPassword($data);
       
          if($status == 1){         
              $data = [
                  'status' => 'success',
                  'title' => 'Berhasil',
                  'pesan' => 'Password Berhasil di Reset....! Password sama dengan nomor ID'
              ];
          }else{
            $data = [
                'status' => 'error',
                'title'  => 'Gagal',
                'pesan' => 'Password Gagal di Reset....!'
            ];
        }     

        echo json_encode($data);
    }




}