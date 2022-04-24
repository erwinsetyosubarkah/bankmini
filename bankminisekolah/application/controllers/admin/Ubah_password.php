<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Ubah_password extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function ubah()
    {
        $data = $_POST;
        if($data['password_baru'] != $data['confirm_password_baru']){
            $data = [
                'status' => 'error',
                'title' => 'Gagal',
                'pesan' => 'Password Baru dan Tulis Ulang Password Baru tidak sama....!'
            ];
        }else{

        $password = htmlspecialchars(password_hash($data['password_baru'],PASSWORD_DEFAULT));
        $id_pengguna = $_SESSION['user']['id_pengguna'];

        $tabel = 'pengguna';
        
        $this->load->model('admin/Pengguna_model');       
        $status = $this->Pengguna_model->ubahPassword($password,$tabel,$id_pengguna);
       
       
          if($status == 1 ){       
              
            $data = [
                'status' => 'success',
                'title' => 'Berhasil',
                'pesan' => 'Password berhasil Diubah....!'
            ];
          }else{
            $data = [
                'status' => 'error',
                'title'  => 'Gagal',
                'pesan' => 'Password gagal Diubah...!'
            ];
          } 

        }    

        echo json_encode($data);
        
    } 


}