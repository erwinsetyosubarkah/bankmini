<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Kelas extends CI_Controller{
    
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
            $data['header_halaman'] = 'Kelas';
            $data['icon_header_halaman'] = 'cog';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/kelas/kelas',$data); 
            $this->load->view('admin/templates/footer');
            
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }

    }


    public function queryAll()
    {
        $tabel = 'kelas';
        $select_column = [
            'kelas.id_kelas',
            'jurusan.jurusan',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel'         
        ];

        $order_column = [
            null,
            'kelas.id_kelas',
            'jurusan.jurusan',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel',  
            null
        ];
      
        $this->load->model('admin/Kelas_model');
        $fetch_data = $this->Kelas_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_kelas; 
            $sub_array[] = $row->jurusan; 
            $sub_array[] = $row->tingkat; 
            $sub_array[] = $row->tingkat." ".$row->kode_jurusan." ".$row->rombel; 
            $sub_array[] = $row->rombel; 
         
            $sub_array[] = '
                            <button class="badge badge-warning badge-sm border-0" style="margin: 2px;" onclick="btnModalUbah(\''.$row->id_kelas.'\')" title="Ubah" data-toggle="modal" data-target="#modalKelas"><i class="fa fa-fw fa-edit"></i></button> 
                            
                            <button class="badge badge-danger badge-sm border-0" style="margin: 2px;" onclick="btnModalHapus(\''.$row->id_kelas.'\')" title="Hapus"><i class="fa fa-fw fa-trash"></i></button> 
                            ';
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Kelas_model->getAllData($tabel),
            'recordsFiltered'   =>  $this->Kelas_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }


    public function queryById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Kelas_model');
        $data = $this->Kelas_model->queryById($data);

        echo json_encode($data);
      
    }

    public function cekId(){
        $this->load->model('admin/Kelas_model');
        $data = $this->Kelas_model->cekID();

        echo json_encode($data);
    }

    public function getJurusan(){
        
        $this->load->model('admin/Jurusan_model');
        $fetch_data = $this->Jurusan_model->getJurusan();

        $output = '';

        foreach($fetch_data as $data){
            $output .= '<option value="'.$data['id_jurusan'].'">'.$data['jurusan'].'</option>';
        }

        echo json_encode($output);
    }

    public function tambah()
    {
        $data = $_POST;

        $tabel = 'kelas';

      

        $this->load->model('admin/Kelas_model');
        $status = $this->Kelas_model->tambah($data,$tabel);
       
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

        $tabel = 'kelas';
        
        $this->load->model('admin/Kelas_model');       
        $status = $this->Kelas_model->ubah($data,$tabel);
       
       
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

        $this->load->model('admin/Kelas_model');

        $status = $this->Kelas_model->hapus($data);
       

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