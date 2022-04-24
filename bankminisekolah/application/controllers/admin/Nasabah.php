<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Nasabah extends CI_Controller{
    
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
            $data['header_halaman'] = 'Data Nasabah';
            $data['icon_header_halaman'] = 'users';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/nasabah/nasabah',$data); 
            $this->load->view('admin/templates/footer');

        }else{
             redirect(base_url().'beranda-admin');
             die();
         }
         
    }

    public function queryAll()
    {
        $tabel = 'nasabah';
        $select_column = [
            'nasabah.id_nasabah',
            'nasabah.nama_nasabah',
            'nasabah.jenis_kelamin_nasabah',
            'nasabah.tempat_lahir_nasabah',
            'nasabah.tanggal_lahir_nasabah',
            'nasabah.no_telp_nasabah',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel',
            'nasabah.saldo_nasabah'
        ];

        $order_column = [
            null,
            'nasabah.id_nasabah',
            'nasabah.nama_nasabah',
            'nasabah.jenis_kelamin_nasabah',
            'nasabah.tempat_lahir_nasabah',
            'nasabah.tanggal_lahir_nasabah',
            'nasabah.no_telp_nasabah',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel',
            'nasabah.saldo_nasabah',
            null
        ];
      
        $this->load->model('admin/Nasabah_model');
        $fetch_data = $this->Nasabah_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = $_POST['start'] + 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_nasabah;
            $sub_array[] = $row->nama_nasabah;
            $sub_array[] = $row->jenis_kelamin_nasabah;
            if($row->tanggal_lahir_nasabah == "" || $row->tanggal_lahir_nasabah == null){
                $sub_array[] = $row->tempat_lahir_nasabah.", ";
            }else{
                $sub_array[] = $row->tempat_lahir_nasabah.", ".tanggal_indonesia($row->tanggal_lahir_nasabah);
            }
            $sub_array[] = $row->no_telp_nasabah;       
            $sub_array[] = $row->tingkat." ".$row->kode_jurusan." ".$row->rombel;
            $sub_array[] = "Rp. ".number_format($row->saldo_nasabah,0,",",".");       
            $sub_array[] = '
                            <button class="badge badge-primary badge-sm border-0" style="margin: 2px;" onclick="btnDetail(\''.$row->id_nasabah.'\')" title="Detail" data-toggle="modal" data-target="#modalDetailNasabah"><i class="fa fa-fw fa-info"></i></button>
                            
                            <button class="badge badge-warning badge-sm border-0" style="margin: 2px;" onclick="btnModalUbah(\''.$row->id_nasabah.'\')" title="Ubah" data-toggle="modal" data-target="#modalNasabah"><i class="fa fa-fw fa-edit"></i></button> 
                            
                            <button class="badge badge-danger badge-sm border-0" style="margin: 2px;" onclick="btnModalHapus(\''.$row->id_nasabah.'\')" title="Hapus"><i class="fa fa-fw fa-trash"></i></button> 
                            ';
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Nasabah_model->getAllData($tabel,$select_column,$order_column),
            'recordsFiltered'   =>  $this->Nasabah_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }



    public function queryById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Nasabah_model');
        $data = $this->Nasabah_model->queryById($data);     

        echo json_encode($data);
      
    }


    public function cekId(){
        $this->load->model('admin/Nasabah_model');
        $data = $this->Nasabah_model->cekID();

        echo json_encode($data);
    }

    public function getTandaPengenal(){
        
        $this->load->model('admin/Tanda_pengenal_model');
        $fetch_data = $this->Tanda_pengenal_model->getTandaPengenal();

        $output = '';

        foreach($fetch_data as $data){
            $output .= '<option value="'.$data['id_tanda_pengenal'].'">'.$data['jenis_tanda_pengenal'].'</option>';
        }

        echo json_encode($output);
    }

    public function getKelas(){
        
        $this->load->model('admin/Kelas_model');
        $fetch_data = $this->Kelas_model->getKelas();

        $output = '';

        foreach($fetch_data as $data){
            $output .= '<option value="'.$data['id_kelas'].'">'.$data['tingkat']." ".$data['kode_jurusan']." ".$data['rombel'].'</option>';
        }

        echo json_encode($output);
    }

    public function tambah()
    {
        $data = $_POST;       

        $this->load->model('admin/Nasabah_model');
        $status = $this->Nasabah_model->tambah($data);
       
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
        
        $this->load->model('admin/Nasabah_model');       
        $status = $this->Nasabah_model->ubah($data);
       
       
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

        echo json_encode($data);
        
    }

    public function hapus(){
        $data = $_POST;

        $this->load->model('admin/Nasabah_model');
        $status = $this->Nasabah_model->hapus($data);
     
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



    public function importData(){
        $this->load->model('admin/Nasabah_model');
        if(isset($_FILES['import_data']['name'])){            
             // get file extension
             $extension = pathinfo($_FILES['import_data']['name'], PATHINFO_EXTENSION);
 
             if($extension == 'csv'){
                 $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
             } elseif($extension == 'xlsx') {
                 $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
             } elseif($extension == 'xls') {
                 $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
             }else{
                $data = [
                    'status' => 'error',
                    'title'  => 'Gagal',
                    'pesan' => 'Pilih File Terlebih dahulu...!'
                ];

                echo json_encode($data);
                exit;
             }

             
             // file path
             $spreadsheet = $reader->load($_FILES['import_data']['tmp_name']);
             $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
             
             // array Count
             $arrayCount = count($allDataInSheet);
            
             $flag = 0;
             $createArray = array('No', 'Nama', 'Jenis Kelamin', 'Tempat Lahir','Tanggal Lahir','Alamat', 'No Telp', 'ID Tanda Pengenal','No Tanda Pengenal','ID Kelas');
             $makeArray = array(
                 'No'                           => 'No', 
                 'Nama'                         => 'Nama', 
                 'JenisKelamin'                 => 'Jenis Kelamin', 
                 'TempatLahir'                  => 'Tempat Lahir',
                 'TanggalLahir'                 => 'Tanggal Lahir',
                 'Alamat'                       => 'Alamat',
                 'NoTelp'                       => 'No Telp',
                 'IDTandaPengenal'              => 'ID Tanda Pengenal',
                 'NoTandaPengenal'              => 'No Tanda Pengenal',
                 'IDKelas'                      => 'ID Kelas'
                );
               
             $SheetDataKey = array();
             foreach ($allDataInSheet as $dataInSheet) {
                 foreach ($dataInSheet as $key => $value) {
                     if (in_array(trim($value), $createArray)) {
                         $value = preg_replace('/\s+/', '', $value);
                         $SheetDataKey[trim($value)] = $key;
                     } 
                 }
             }
             $dataDiff = array_diff_key($makeArray, $SheetDataKey);
           
             if (empty($dataDiff)) {
                 $flag = 1;
             }
             
             // match excel sheet column
            if ($flag == 1) {
                 for ($i = 2; $i <= $arrayCount; $i++) {
                    
                     $nama_nasabah = $SheetDataKey['Nama'];
                     $jenis_kelamin_nasabah = $SheetDataKey['JenisKelamin'];
                     $tempat_lahir_nasabah = $SheetDataKey['TempatLahir'];
                     $tanggal_lahir_nasabah = $SheetDataKey['TanggalLahir'];
                     $alamat_nasabah = $SheetDataKey['Alamat'];
                     $no_telp_nasabah = $SheetDataKey['NoTelp'];
                     $id_tanda_pengenal = $SheetDataKey['IDTandaPengenal'];
                     $no_tanda_pengenal_nasabah = $SheetDataKey['NoTandaPengenal'];
                     $id_kelas = $SheetDataKey['IDKelas'];

                     $nama_nasabah = filter_var(trim($allDataInSheet[$i][$nama_nasabah]), FILTER_SANITIZE_STRING);
                     $jenis_kelamin_nasabah = filter_var(trim($allDataInSheet[$i][$jenis_kelamin_nasabah]), FILTER_SANITIZE_STRING);
                     $tempat_lahir_nasabah = filter_var(trim($allDataInSheet[$i][$tempat_lahir_nasabah]), FILTER_SANITIZE_STRING);
                     $tanggal_lahir_nasabah = filter_var(trim($allDataInSheet[$i][$tanggal_lahir_nasabah]), FILTER_SANITIZE_STRING);
                     $alamat_nasabah = filter_var(trim($allDataInSheet[$i][$alamat_nasabah]), FILTER_SANITIZE_STRING);
                     $no_telp_nasabah = filter_var(trim($allDataInSheet[$i][$no_telp_nasabah]), FILTER_SANITIZE_STRING);
                     $id_tanda_pengenal = filter_var(trim($allDataInSheet[$i][$id_tanda_pengenal]), FILTER_SANITIZE_STRING);
                     $no_tanda_pengenal_nasabah = filter_var(trim($allDataInSheet[$i][$no_tanda_pengenal_nasabah]), FILTER_SANITIZE_STRING);
                     $id_kelas = filter_var(trim($allDataInSheet[$i][$id_kelas]), FILTER_SANITIZE_STRING);
                   
                     $fetchData = array(
                         'id_nasabah' => '', 
                         'nama_nasabah' => $nama_nasabah, 
                         'jenis_kelamin_nasabah' => $jenis_kelamin_nasabah, 
                         'tempat_lahir_nasabah' => $tempat_lahir_nasabah, 
                         'tanggal_lahir_nasabah' => $tanggal_lahir_nasabah, 
                         'alamat_nasabah' => $alamat_nasabah,
                         'no_telp_nasabah' => $no_telp_nasabah, 
                         'id_tanda_pengenal' => $id_tanda_pengenal, 
                         'no_tanda_pengenal_nasabah' => $no_tanda_pengenal_nasabah, 
                         'id_kelas' => $id_kelas 
                    );

                                    
                    $status = $this->Nasabah_model->tambah($fetchData);
                 }   
                 
            }

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
        }else{
            $data = [
                'status' => 'error',
                'title'  => 'Gagal',
                'pesan' => 'Pilih File Terlebih dahulu...!'
            ];
        }

        echo json_encode($data);
    }

    public function downloadFormat(){	
        $this->load->helper('download');				
		force_download('./assets/download/formatImportNasabah.xlsx',NULL);
	}

    public function cetak(){
        date_default_timezone_set('Asia/Jakarta');

        $data['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Nasabah_model');
        $data['data_nasabah'] = $this->Nasabah_model->queryAll();

        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/nasabah/cetak_nasabah',$data);
    }

    public function export(){
        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Nasabah_model');
        $data_nasabah = $this->Nasabah_model->queryAll();

        $tanggal_hari_ini= tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Data Nasabah');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','Tanggal '.$tanggal_hari_ini);

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Nasabah');
        $sheet->setCellValue('C5','Nama');
        $sheet->setCellValue('D5','Jenis Kelamin');
        $sheet->setCellValue('E5','Tempat Tanggal Lahir');
        $sheet->setCellValue('F5','No Telp');
        $sheet->setCellValue('G5','Kelas');
        $sheet->setCellValue('H5','Saldo');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_nasabah as $dtnsb): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtnsb->id_nasabah);
           $sheet->setCellValue('C'.$nocel,$dtnsb->nama_nasabah);
           $sheet->setCellValue('D'.$nocel,$dtnsb->jenis_kelamin_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtnsb->tempat_lahir_nasabah.", ".tanggal_indonesia($dtnsb->tanggal_lahir_nasabah));
           $sheet->setCellValue('F'.$nocel,$dtnsb->no_telp_nasabah);
           $sheet->setCellValue('G'.$nocel,$dtnsb->tingkat.' '.$dtnsb->kode_jurusan.' '.$dtnsb->rombel);
           $sheet->setCellValue('H'.$nocel,'Rp. '. number_format($dtnsb->saldo_nasabah,0,',','.'));
        
         $nourut++; 
         $nocel++; 
     endforeach; 


              // Mengatur style table        
              $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];
            
            $celaktif = $nocel-1;
            $sheet->getStyle('A5:H'.$celaktif)->applyFromArray($styleArray);
                                   
            $sheet->mergeCells('A1:H1');
            $sheet->mergeCells('A2:H2');
            $sheet->mergeCells('A3:H3');
            $styleArray = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'font' => [
                    'bold' => true,
                ],
            ];
            $sheet->getStyle('A1')->applyFromArray($styleArray);
            $sheet->getStyle('A2')->applyFromArray($styleArray);
            $sheet->getStyle('A3')->applyFromArray($styleArray);
            $sheet->getStyle('A5:H5')->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel.':H'.$nocel)->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(15.45, 'px');
            $sheet->getColumnDimension('C')->setWidth(23.15, 'px');
            $sheet->getColumnDimension('D')->setWidth(15.29, 'px');
            $sheet->getColumnDimension('E')->setWidth(23.71, 'px');
            $sheet->getColumnDimension('F')->setWidth(13.71, 'px');
            $sheet->getColumnDimension('G')->setWidth(16.55, 'px');
            $sheet->getColumnDimension('H')->setWidth(21.29, 'px');
            $sheet->getRowDimension('5')->setRowHeight(24, 'px');
            $sheet->getStyle('A5:H5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A5:H5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Data Nasabah-'.time().'.xlsx';
        // Redirect output to a client's web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

    }

}