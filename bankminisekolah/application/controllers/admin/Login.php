<?php

class Login extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if($this->session->userdata('user') != null){
            redirect(base_url().'beranda-admin');
            die();
        }

        // $this->form_validation->set_rules('username','Username','trim|required');
        // $this->form_validation->set_rules('password','Password','trim|required');

        // if($this->form_validation->run() == false){

            $this->load->model('admin/Pengaturan_model');
            $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 
    
            $this->load->view('admin/templates/header_login',$data);
            $this->load->view('admin/login/login',$data); 
            $this->load->view('admin/templates/footer_login');
        // }else{
        //     cek_user();
        // }
        
    }

    public function cek_user(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->load->model('admin/Pengguna_model');        
        $user = $this->Pengguna_model->cekUser($username);

        if($user){
            if(password_verify($password,$user['password'])){
                $level = strtolower($user['level']);
                
                $insert = $this->Pengguna_model->setWaktuLogin($user);
                $userdata = [
                    'user' => $user
                ];                
                $this->session->set_userdata($userdata);
                $data = [
                    'status' => 'success',
                    'title' => 'Berhasil',
                    'pesan' => 'Anda berhasil login...!'
                ];

 
            }else{
                $data = [
                    'status' => 'error',
                    'title'  => 'Gagal',
                    'pesan' => 'Password salah...!'
                ];
            }
        }else{
            $data = [
                'status' => 'error',
                'title'  => 'Gagal',
                'pesan' => 'Username tidak ditemukan...!'
            ];
        }

        echo json_encode($data);
    }


    public function logout(){
        if($this->session->userdata('user') == null){
            redirect(base_url().'login-user');
            die();
        }

        if($_SESSION['user']['level'] == 'Administrator' || $_SESSION['user']['level'] == 'Operator' || $_SESSION['user']['level'] == 'Teller'){

            
            $this->session->unset_userdata('user');        
            redirect('login-user');
            
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }
    }


}