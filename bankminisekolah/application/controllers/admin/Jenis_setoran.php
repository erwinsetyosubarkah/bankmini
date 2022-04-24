<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Jenis_setoran extends CI_Controller{
    
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
            $data['header_halaman'] = 'Jenis Setoran';
            $data['icon_header_halaman'] = 'cog';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/jenis_setoran/jenis_setoran',$data); 
            $this->load->view('admin/templates/footer');
            
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }

    }
        

    public function queryAll()
    {
        $tabel = 'jenis_setoran';
        $select_column = [
            'id_jenis_setoran',
            'jenis_setoran'         
        ];

        $order_column = [
            null,
            'id_jenis_setoran',
            'jenis_setoran',
            null
        ];
      
        $this->load->model('admin/Jenis_setoran_model');
        $fetch_data = $this->Jenis_setoran_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_jenis_setoran; 
            $sub_array[] = $row->jenis_setoran; 
         
            $sub_array[] = '
                            <button class="badge badge-warning badge-sm border-0" style="margin: 2px;" onclick="btnModalUbah(\''.$row->id_jenis_setoran.'\')" title="Ubah" data-toggle="modal" data-target="#modalJenisSetoran"><i class="fa fa-fw fa-edit"></i></button> 
                            
                            <button class="badge badge-danger badge-sm border-0" style="margin: 2px;" onclick="btnModalHapus(\''.$row->id_jenis_setoran.'\')" title="Hapus"><i class="fa fa-fw fa-trash"></i></button> 
                            ';
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Jenis_setoran_model->getAllData($tabel),
            'recordsFiltered'   =>  $this->Jenis_setoran_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }


    public function queryById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Jenis_setoran_model');
        $data = $this->Jenis_setoran_model->queryById($data);

        echo json_encode($data);
      
    }

    public function cekId(){
        $this->load->model('admin/Jenis_setoran_model');
        $data = $this->Jenis_setoran_model->cekID();

        echo json_encode($data);
    }

    public function tambah()
    {
        $data = $_POST;

        $tabel = 'jenis_setoran';

      

        $this->load->model('admin/Jenis_setoran_model');
        $status = $this->Jenis_setoran_model->tambah($data,$tabel);
       
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

        $tabel = 'jenis_setoran';
        
        $this->load->model('admin/Jenis_setoran_model');       
        $status = $this->Jenis_setoran_model->ubah($data,$tabel);
       
       
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

        $this->load->model('admin/Jenis_setoran_model');

        $status = $this->Jenis_setoran_model->hapus($data);
       

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