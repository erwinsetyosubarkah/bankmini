<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Jurusan extends CI_Controller{
    
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
            $data['header_halaman'] = 'Jurusan';
            $data['icon_header_halaman'] = 'cog';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/jurusan/jurusan',$data); 
            $this->load->view('admin/templates/footer');
            
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }

    }


    public function queryAll()
    {
        $tabel = 'jurusan';
        $select_column = [
            'id_jurusan',
            'jurusan',
            'kode_jurusan'         
        ];

        $order_column = [
            null,
            'id_jurusan',
            'jurusan',
            'kode_jurusan',
            null
        ];
      
        $this->load->model('admin/Jurusan_model');
        $fetch_data = $this->Jurusan_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_jurusan; 
            $sub_array[] = $row->jurusan; 
            $sub_array[] = $row->kode_jurusan; 
         
            $sub_array[] = '
                            <button class="badge badge-warning badge-sm border-0" style="margin: 2px;" onclick="btnModalUbah(\''.$row->id_jurusan.'\')" title="Ubah" data-toggle="modal" data-target="#modalJurusan"><i class="fa fa-fw fa-edit"></i></button> 
                            
                            <button class="badge badge-danger badge-sm border-0" style="margin: 2px;" onclick="btnModalHapus(\''.$row->id_jurusan.'\')" title="Hapus"><i class="fa fa-fw fa-trash"></i></button> 
                            ';
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Jurusan_model->getAllData($tabel),
            'recordsFiltered'   =>  $this->Jurusan_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }


    public function queryById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Jurusan_model');
        $data = $this->Jurusan_model->queryById($data);

        echo json_encode($data);
      
    }

    public function cekId(){
        $this->load->model('admin/Jurusan_model');
        $data = $this->Jurusan_model->cekID();

        echo json_encode($data);
    }

    public function tambah()
    {
        $data = $_POST;

        $tabel = 'jurusan';

      

        $this->load->model('admin/Jurusan_model');
        $status = $this->Jurusan_model->tambah($data,$tabel);
       
        if($status == 1){         
            $data = [
                  'status' => 'success',
                  'title' => 'Berhasil',
                  'pesan' => 'Data berhasil Ditambah....!'
              ];
        }else{
            $data = [
                'status' => 'error',
                'title'  => 'Gagal',
                'pesan' => 'Data gagal Ditambah...!'
            ];
        }     

        echo json_encode($data);
        
    }


    public function ubah()
    {
        $data = $_POST;

        $tabel = 'jurusan';
        
        $this->load->model('admin/Jurusan_model');       
        $status = $this->Jurusan_model->ubah($data,$tabel);
       
       
          if($status == 1 ){       
              
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

        echo json_encode($data);
        
    }

    public function hapus(){
        $data = $_POST;

        $this->load->model('admin/Jurusan_model');

        $status = $this->Jurusan_model->hapus($data);
       

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

}