<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Pembayaran_siswa extends CI_Controller{
    
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
            $data['header_halaman'] = 'Pembayaran Siswa';
            $data['icon_header_halaman'] = 'dollar-sign';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/pembayaran_siswa/pembayaran_siswa',$data); 
            $this->load->view('admin/templates/footer');

        }else{
             redirect(base_url().'beranda-admin');
             die();
         }
         
    }

    public function queryAll()
    {
        $tabel = 'pembayaran_siswa';
        $select_column = [
            'pembayaran_siswa.id_pembayaran_siswa',
            'pembayaran_siswa.id_nasabah',
            'nasabah.nama_nasabah',
            'pembayaran_siswa.id_jenis_setoran',
            'jenis_setoran.jenis_setoran',
            'pembayaran_siswa.tanggal_transaksi_pembayaran_siswa',
            'pembayaran_siswa.jumlah_pembayaran_siswa',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel'
        ];

        $order_column = [
            null,
            'pembayaran_siswa.id_pembayaran_siswa',
            'pembayaran_siswa.id_nasabah',
            'nasabah.nama_nasabah',
            'pembayaran_siswa.id_jenis_setoran',
            'jenis_setoran.jenis_setoran',
            'pembayaran_siswa.tanggal_transaksi_pembayaran_siswa',
            'pembayaran_siswa.jumlah_pembayaran_siswa',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel',
            null
        ];
      
        $this->load->model('admin/Pembayaran_siswa_model');
        $fetch_data = $this->Pembayaran_siswa_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = $_POST['start'] + 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_pembayaran_siswa;
            $sub_array[] = $row->nama_nasabah;
            $sub_array[] = $row->id_nasabah;
            $sub_array[] = $row->tingkat." ".$row->kode_jurusan." ".$row->rombel;
            $sub_array[] = $row->jenis_setoran;            
            $sub_array[] = tanggal_indonesia($row->tanggal_transaksi_pembayaran_siswa);            
            $sub_array[] = "Rp. ".number_format($row->jumlah_pembayaran_siswa,0,",",".");       
            
            $sub_array[] = '
                            <button class="badge badge-primary badge-sm border-0" style="margin: 2px;" onclick="btnDetail(\''.$row->id_pembayaran_siswa.'\')" title="Detail" data-toggle="modal" data-target="#modalDetailPembayaranSiswa"><i class="fa fa-fw fa-info"></i></button>
                            
                            <button class="badge badge-warning badge-sm border-0" style="margin: 2px;" onclick="btnModalUbah(\''.$row->id_pembayaran_siswa.'\')" title="Ubah" data-toggle="modal" data-target="#modalPembayaranSiswa"><i class="fa fa-fw fa-edit"></i></button> 
                            
                            <button class="badge badge-danger badge-sm border-0" style="margin: 2px;" onclick="btnModalHapus(\''.$row->id_pembayaran_siswa.'\')" title="Hapus"><i class="fa fa-fw fa-trash"></i></button> 
                            ';
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Pembayaran_siswa_model->getAllData($tabel,$select_column,$order_column),
            'recordsFiltered'   =>  $this->Pembayaran_siswa_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }



    public function queryById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Pembayaran_siswa_model');
        $data = $this->Pembayaran_siswa_model->queryById($data);     

        echo json_encode($data);
      
    }

    public function getNasabahById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Nasabah_model');
        $data = $this->Nasabah_model->queryById($data);     

        echo json_encode($data);
      
    }

    public function cekId(){
        $this->load->model('admin/Pembayaran_siswa_model');
        $data = $this->Pembayaran_siswa_model->cekID();

        echo json_encode($data);
    }


    public function getIdNasabah(){
        
        $this->load->model('admin/Nasabah_model');
        $fetch_data = $this->Nasabah_model->getIdNasabah();

        $output = '';
        $output .= '<option value="">-- Pilih ID Nasabah --</option>';

        foreach($fetch_data as $data){            
            $output .= '<option value="'.$data['id_nasabah'].'">'.$data['id_nasabah'].'</option>';
        }

        echo json_encode($output);
    }

    public function getIdJenisSetoran(){
        
        $this->load->model('admin/Jenis_setoran_model');
        $fetch_data = $this->Jenis_setoran_model->getIdJenisSetoran();

        $output = '';
        $output .= '<option value="">-- Pilih Jenis Setoran --</option>';

        foreach($fetch_data as $data){            
            $output .= '<option value="'.$data['id_jenis_setoran'].'">'.$data['jenis_setoran'].'</option>';
        }

        echo json_encode($output);
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

        $this->load->model('admin/Pembayaran_siswa_model');
        $status = $this->Pembayaran_siswa_model->tambah($data);
       
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
        
        $this->load->model('admin/Pembayaran_siswa_model');  
        $this->load->model('admin/Penarikan_saldo_model');  
        //hitung total pembayaran siswa - jml penarikan saldo
        $jml_pembayaran_siswa = $this->Pembayaran_siswa_model->totalPembayaranSiswa();
        $jml_pem = $this->Pembayaran_siswa_model->queryById($data);
        $jml_pem_sekarang = $jml_pembayaran_siswa - $jml_pem['jumlah_pembayaran_siswa'] + $data['jumlah_pembayaran_siswa'];    
        $jml_penarikan_saldo = $this->Penarikan_saldo_model->totalPenarikanSaldo();
        
        if($jml_pem_sekarang >= $jml_penarikan_saldo){
            $status = $this->Pembayaran_siswa_model->ubah($data);
        
        
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
        }else{
            $data = [
                'status' => 'error',
                'title'  => 'Gagal',
                'pesan' => 'Saldo kurang dari jumlah penarikan...! Masukan Jumlah pembayaran yang lebih besar dari itu...!!'
            ];
        }

        echo json_encode($data);
        
    }

    public function hapus(){
        $data = $_POST;

        $this->load->model('admin/Pembayaran_siswa_model');  
        $this->load->model('admin/Penarikan_saldo_model');  
        //hitung total pembayaran siswa - jml penarikan saldo
        $jml_pembayaran_siswa = $this->Pembayaran_siswa_model->totalPembayaranSiswa();
        $jml_pem = $this->Pembayaran_siswa_model->queryById($data);
        $jml_pem_sekarang = $jml_pembayaran_siswa - $jml_pem['jumlah_pembayaran_siswa'];
        $jml_penarikan_saldo = $this->Penarikan_saldo_model->totalPenarikanSaldo();
        
        if($jml_pem_sekarang >= $jml_penarikan_saldo){

            $this->load->model('admin/Pembayaran_siswa_model');
            $status = $this->Pembayaran_siswa_model->hapus($data);
        
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
        }else{
            $data = [
                'status' => 'error',
                'title'  => 'Gagal',
                'pesan' => 'Data Gagal di Hapus....! Pembayaran ini sudah ditarik...!'
            ];
        }    

        echo json_encode($data);


    }

    public function cetakBuktiPembayaranSiswa(){
        $data1 = $_POST;
        $this->load->model('admin/Pembayaran_siswa_model');
        $data['data_pembayaran_siswa'] = $this->Pembayaran_siswa_model->queryById($data1);  
        $tgl_transaksi = $data['data_pembayaran_siswa']['tanggal_transaksi_pembayaran_siswa'];
        $data['data_pembayaran_siswa']['tanggal_transaksi_pembayaran_siswa'] = tanggal_indonesia($tgl_transaksi);

        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/pembayaran_siswa/cetak_bukti_pembayaran_siswa',$data);
    }

    public function cetakPembayaranSiswaHariIni(){
        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Pembayaran_siswa_model');
        $data['data_pembayaran_siswa'] = $this->Pembayaran_siswa_model->queryByDateNow($data1);
        $data['total_pembayaran_siswa'] = $this->Pembayaran_siswa_model->totalPembayaranSiswaByDate($data1['tanggal_hari_ini']);   

        $data['tanggal_hari_ini'] = tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/pembayaran_siswa/cetak_chi_pembayaran_siswa',$data);
    }

    public function exportPembayaranSiswaHariIni(){
        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Pembayaran_siswa_model');
        $data_pembayaran_siswa = $this->Pembayaran_siswa_model->queryByDateNow($data1);  
        $total_pembayaran_siswa = $this->Pembayaran_siswa_model->totalPembayaranSiswaByDate($data1['tanggal_hari_ini']);   

        $tanggal_hari_ini= tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Laporan Pembayaran Siswa Hari Ini');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','Tanggal '.$tanggal_hari_ini);

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Pembayaran');
        $sheet->setCellValue('C5','Tanggal Transaksi');
        $sheet->setCellValue('D5','ID Nasabah');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Jenis Setoran');
        $sheet->setCellValue('G5','Jumlah Pembayaran');
        $sheet->setCellValue('H5','Kelas');
        $sheet->setCellValue('I5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_pembayaran_siswa as $dtps): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtps->id_pembayaran_siswa);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtps->tanggal_transaksi_pembayaran_siswa));
           $sheet->setCellValue('D'.$nocel,$dtps->id_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtps->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$dtps->jenis_setoran);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dtps->jumlah_pembayaran_siswa,0,',','.'));
           $sheet->setCellValue('H'.$nocel,$dtps->tingkat.' '.$dtps->kode_jurusan.' '.$dtps->rombel);
           $sheet->setCellValue('I'.$nocel,$dtps->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':F'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Pembayaran Siswa Hari Ini');
            $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_pembayaran_siswa,0,',','.'));

              // Mengatur style table        
              $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];
            
            $celaktif = $nocel;
            $sheet->getStyle('A5:I'.$celaktif)->applyFromArray($styleArray);
                                   
            $sheet->mergeCells('A1:I1');
            $sheet->mergeCells('A2:I2');
            $sheet->mergeCells('A3:I3');
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
            $sheet->getStyle('A5:I5')->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel.':I'.$nocel)->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(15.45, 'px');
            $sheet->getColumnDimension('C')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('D')->setWidth(10.45, 'px');
            $sheet->getColumnDimension('E')->setWidth(16, 'px');
            $sheet->getColumnDimension('F')->setWidth(12.64, 'px');
            $sheet->getColumnDimension('G')->setWidth(16.55, 'px');
            $sheet->getColumnDimension('H')->setWidth(8.73, 'px');
            $sheet->getColumnDimension('I')->setWidth(12.73, 'px');
            $sheet->getRowDimension('5')->setRowHeight(24, 'px');
            $sheet->getStyle('A5:I5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:I5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A5:I5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Laporan_Pembayaran_Siswa_Hari_ini-'.time().'.xlsx';
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

    public function cetakSemuaPembayaranSiswa(){
       
        $this->load->model('admin/Pembayaran_siswa_model');
        $data['data_pembayaran_siswa'] = $this->Pembayaran_siswa_model->queryAll();  
        $data['total_pembayaran_siswa'] = $this->Pembayaran_siswa_model->totalPembayaranSiswa(); 
        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/pembayaran_siswa/cetak_css_pembayaran_siswa',$data);
    }

    public function exportSemuaPembayaranSiswa(){

        $this->load->model('admin/Pembayaran_siswa_model');
        $data_pembayaran_siswa = $this->Pembayaran_siswa_model->queryAll();
        $total_pembayaran_siswa = $this->Pembayaran_siswa_model->totalPembayaranSiswa(); 
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Input data ke table
        $sheet->setCellValue('A1','Laporan Semua Pembayaran Siswa');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','');

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Pembayaran');
        $sheet->setCellValue('C5','Tanggal Transaksi');
        $sheet->setCellValue('D5','ID Nasabah');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Jenis Setoran');
        $sheet->setCellValue('G5','Jumlah Pembayaran');
        $sheet->setCellValue('H5','Kelas');
        $sheet->setCellValue('I5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_pembayaran_siswa as $dtps): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtps->id_pembayaran_siswa);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtps->tanggal_transaksi_pembayaran_siswa));
           $sheet->setCellValue('D'.$nocel,$dtps->id_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtps->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$dtps->jenis_setoran);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dtps->jumlah_pembayaran_siswa,0,',','.'));
           $sheet->setCellValue('H'.$nocel,$dtps->tingkat.' '.$dtps->kode_jurusan.' '.$dtps->rombel);
           $sheet->setCellValue('I'.$nocel,$dtps->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':F'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Semua Pembayaran Siswa');
            $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_pembayaran_siswa,0,',','.'));
              // Mengatur style table        
              $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];
            
            $celaktif = $nocel;
            $sheet->getStyle('A5:I'.$celaktif)->applyFromArray($styleArray);
                                   
            $sheet->mergeCells('A1:I1');
            $sheet->mergeCells('A2:I2');
            $sheet->mergeCells('A3:I3');
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
            $sheet->getStyle('A5:I5')->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel.':I'.$nocel)->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(15.45, 'px');
            $sheet->getColumnDimension('C')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('D')->setWidth(10.45, 'px');
            $sheet->getColumnDimension('E')->setWidth(16, 'px');
            $sheet->getColumnDimension('F')->setWidth(12.64, 'px');
            $sheet->getColumnDimension('G')->setWidth(16.55, 'px');
            $sheet->getColumnDimension('H')->setWidth(8.73, 'px');
            $sheet->getColumnDimension('I')->setWidth(12.73, 'px');
            $sheet->getRowDimension('5')->setRowHeight(24, 'px');
            $sheet->getStyle('A5:I5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:I5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A5:I5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Laporan_Semua_Pembayaran_Siswa-'.time().'.xlsx';
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


    public function exportPembayaranSiswaPerTanggal(){
        $data1 = $_POST;

        $mulai_tanggal = tanggal_indonesia($data1['mulai_tanggal']);
        $sampai_tanggal = tanggal_indonesia($data1['sampai_tanggal']);
        $this->load->model('admin/Pembayaran_siswa_model');
        $data_pembayaran_siswa = $this->Pembayaran_siswa_model->queryDueTo($data1);
        $total_pembayaran_siswa = $this->Pembayaran_siswa_model->totalPembayaranSiswaByDateTo($data1['mulai_tanggal'],$data1['sampai_tanggal']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Laporan Pembayaran Siswa');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3',$mulai_tanggal.' Sampai '.$sampai_tanggal );

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Pembayaran');
        $sheet->setCellValue('C5','Tanggal Transaksi');
        $sheet->setCellValue('D5','ID Nasabah');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Jenis Setoran');
        $sheet->setCellValue('G5','Jumlah Pembayaran');
        $sheet->setCellValue('H5','Kelas');
        $sheet->setCellValue('I5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_pembayaran_siswa as $dtps): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtps->id_pembayaran_siswa);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtps->tanggal_transaksi_pembayaran_siswa));
           $sheet->setCellValue('D'.$nocel,$dtps->id_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtps->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$dtps->jenis_setoran);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dtps->jumlah_pembayaran_siswa,0,',','.'));
           $sheet->setCellValue('H'.$nocel,$dtps->tingkat.' '.$dtps->kode_jurusan.' '.$dtps->rombel);
           $sheet->setCellValue('I'.$nocel,$dtps->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':F'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Pembayaran Siswa dari tanggal '.$mulai_tanggal.' sampai '.$sampai_tanggal);
            $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_pembayaran_siswa,0,',','.'));

             // Mengatur style table        
             $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];
            
            $celaktif = $nocel;
            $sheet->getStyle('A5:I'.$celaktif)->applyFromArray($styleArray);
                                   
            $sheet->mergeCells('A1:I1');
            $sheet->mergeCells('A2:I2');
            $sheet->mergeCells('A3:I3');
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
            $sheet->getStyle('A5:I5')->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel.':I'.$nocel)->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(15.45, 'px');
            $sheet->getColumnDimension('C')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('D')->setWidth(10.45, 'px');
            $sheet->getColumnDimension('E')->setWidth(16, 'px');
            $sheet->getColumnDimension('F')->setWidth(12.64, 'px');
            $sheet->getColumnDimension('G')->setWidth(16.55, 'px');
            $sheet->getColumnDimension('H')->setWidth(8.73, 'px');
            $sheet->getColumnDimension('I')->setWidth(12.73, 'px');
            $sheet->getRowDimension('5')->setRowHeight(24, 'px');
            $sheet->getStyle('A5:I5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:I5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A5:I5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Laporan_Per_Tanggal_Pembayaran_Siswa-'.time().'.xlsx';
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