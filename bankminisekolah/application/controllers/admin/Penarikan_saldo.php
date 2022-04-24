<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Penarikan_saldo extends CI_Controller{
    
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
            $data['header_halaman'] = 'Penarikan Saldo';
            $data['icon_header_halaman'] = 'university';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/penarikan_saldo/penarikan_saldo',$data); 
            $this->load->view('admin/templates/footer');

        }else{
             redirect(base_url().'beranda-admin');
             die();
         }
         
    }

    public function queryAll()
    {
        $tabel = 'penarikan_saldo';
        $select_column = [
            'penarikan_saldo.id_penarikan_saldo',
            'penarikan_saldo.nama_penarik_saldo',
            'penarikan_saldo.keterangan_penarikan_saldo',
            'penarikan_saldo.tanggal_transaksi_penarikan_saldo',
            'penarikan_saldo.jumlah_penarikan_saldo'
        ];

        $order_column = [
            null,
            'penarikan_saldo.id_penarikan_saldo',
            'penarikan_saldo.nama_penarik_saldo',
            'penarikan_saldo.keterangan_penarikan_saldo',
            'penarikan_saldo.tanggal_transaksi_penarikan_saldo',
            'penarikan_saldo.jumlah_penarikan_saldo',
            null
        ];
      
        $this->load->model('admin/Penarikan_saldo_model');
        $fetch_data = $this->Penarikan_saldo_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = $_POST['start'] + 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_penarikan_saldo;
            $sub_array[] = $row->nama_penarik_saldo;
            $sub_array[] = tanggal_indonesia($row->tanggal_transaksi_penarikan_saldo);            
            $sub_array[] = $row->keterangan_penarikan_saldo;            
            $sub_array[] = "Rp. ".number_format($row->jumlah_penarikan_saldo,0,",",".");       
            
            $sub_array[] = '
                            <button class="badge badge-primary badge-sm border-0" style="margin: 2px;" onclick="btnDetail(\''.$row->id_penarikan_saldo.'\')" title="Detail" data-toggle="modal" data-target="#modalDetailPenarikanSaldo"><i class="fa fa-fw fa-info"></i></button>
                            
                            <button class="badge badge-warning badge-sm border-0" style="margin: 2px;" onclick="btnModalUbah(\''.$row->id_penarikan_saldo.'\')" title="Ubah" data-toggle="modal" data-target="#modalPenarikanSaldo"><i class="fa fa-fw fa-edit"></i></button> 
                            
                            <button class="badge badge-danger badge-sm border-0" style="margin: 2px;" onclick="btnModalHapus(\''.$row->id_penarikan_saldo.'\')" title="Hapus"><i class="fa fa-fw fa-trash"></i></button> 
                            ';
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Penarikan_saldo_model->getAllData($tabel,$select_column,$order_column),
            'recordsFiltered'   =>  $this->Penarikan_saldo_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }



    public function queryById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Penarikan_saldo_model');
        $data = $this->Penarikan_saldo_model->queryById($data);     

        echo json_encode($data);
      
    }


    public function cekId(){
        $this->load->model('admin/Penarikan_saldo_model');
        $data = $this->Penarikan_saldo_model->cekID();

        echo json_encode($data);
    }

    public function cekSaldoBankmini(){

        $this->load->model('admin/Pembayaran_siswa_model');
        $data = $this->Pembayaran_siswa_model->cekSaldoBankmini();

        echo json_encode($data);
    }


    public function tambah()
    {
        $data = $_POST;      
        
        $this->load->model('admin/Pembayaran_siswa_model');
        $saldo_sebelumnya = $this->Pembayaran_siswa_model->cekSaldoBankmini();

        if($saldo_sebelumnya >= $data['jumlah_penarikan_saldo']){
            $this->load->model('admin/Penarikan_saldo_model');
            $status = $this->Penarikan_saldo_model->tambah($data);
        
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
                'pesan' => 'Saldo kurang dari jumlah penarikan...!'
            ];
        }

        echo json_encode($data);
        
    }


    public function ubah()
    {
        $data = $_POST;
        $this->load->model('admin/Pembayaran_siswa_model');
        $this->load->model('admin/Penarikan_saldo_model'); 
        $data2 = $this->Penarikan_saldo_model->queryById($data);
        $jml_yg_diubah = $data2['jumlah_penarikan_saldo'];
        $saldo_sebelumnya = $this->Pembayaran_siswa_model->cekSaldoBankmini();
        $saldo_sebelumnya1 = $saldo_sebelumnya + $jml_yg_diubah;
        
        if($saldo_sebelumnya1 >= $data['jumlah_penarikan_saldo']){
                  
            $status = $this->Penarikan_saldo_model->ubah($data);
        
        
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
                'pesan' => 'Saldo kurang dari jumlah penarikan...!'
            ];
        }

        echo json_encode($data);
        
    }

    public function hapus(){
        $data = $_POST;

        $this->load->model('admin/Penarikan_saldo_model');
        $status = $this->Penarikan_saldo_model->hapus($data);
     
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

    public function cetakBuktiPenarikanSaldo(){
        $data1 = $_POST;
        $this->load->model('admin/Penarikan_saldo_model');
        $data['data_penarikan_saldo'] = $this->Penarikan_saldo_model->queryById($data1);
        $tgl_transaksi = $data['data_penarikan_saldo']['tanggal_transaksi_penarikan_saldo'];
        $data['data_penarikan_saldo']['tanggal_transaksi_penarikan_saldo'] = tanggal_indonesia($tgl_transaksi);  

        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/penarikan_saldo/cetak_bukti_penarikan_saldo',$data);
    }

    public function cetakPenarikanSaldoHariIni(){
        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Penarikan_saldo_model');
        $data['data_penarikan_saldo'] = $this->Penarikan_saldo_model->queryByDateNow($data1);
        $data['total_penarikan_saldo'] = $this->Penarikan_saldo_model->totalPenarikanSaldoByDate($data1['tanggal_hari_ini']);  

        $data['tanggal_hari_ini'] = tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/penarikan_saldo/cetak_chi_penarikan_saldo',$data);
    }

    public function exportPenarikanSaldoHariIni(){
        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Penarikan_saldo_model');
        $data_penarikan_saldo = $this->Penarikan_saldo_model->queryByDateNow($data1); 
        $total_penarikan_saldo = $this->Penarikan_saldo_model->totalPenarikanSaldoByDate($data1['tanggal_hari_ini']);   

        $tanggal_hari_ini= tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Laporan Penarikan Saldo Hari Ini');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','Tanggal '.$tanggal_hari_ini);

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Penarikan');
        $sheet->setCellValue('C5','Tanggal Penarikan');
        $sheet->setCellValue('D5','Nama Penarik');
        $sheet->setCellValue('E5','Keterangan');
        $sheet->setCellValue('F5','Jumlah Penarikan');
        $sheet->setCellValue('G5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_penarikan_saldo as $dtps): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtps->id_penarikan_saldo);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtps->tanggal_transaksi_penarikan_saldo));
           $sheet->setCellValue('D'.$nocel,$dtps->nama_penarik_saldo);
           $sheet->setCellValue('E'.$nocel,$dtps->keterangan_penarikan_saldo);
           $sheet->setCellValue('F'.$nocel,'Rp. '. number_format($dtps->jumlah_penarikan_saldo,0,',','.'));
           $sheet->setCellValue('G'.$nocel,$dtps->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':E'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Penarikan Saldo Hari Ini');
            $sheet->setCellValue('F'.$nocel,'Rp. '.number_format($total_penarikan_saldo,0,',','.'));

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
            $sheet->getStyle('A5:G'.$celaktif)->applyFromArray($styleArray);
                                   
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:G2');
            $sheet->mergeCells('A3:G3');
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
            $sheet->getStyle('A5:G5')->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel.':G'.$nocel)->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('C')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('D')->setWidth(16, 'px');
            $sheet->getColumnDimension('E')->setWidth(12.64, 'px');
            $sheet->getColumnDimension('F')->setWidth(16.55, 'px');
            $sheet->getColumnDimension('G')->setWidth(12.73, 'px');
            $sheet->getRowDimension('5')->setRowHeight(24, 'px');
            $sheet->getStyle('A5:G5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A5:G5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Laporan_Penarikan_Saldo_Hari_ini-'.time().'.xlsx';
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

    public function cetakSemuaPenarikanSaldo(){
       
        $this->load->model('admin/Penarikan_saldo_model');
        $data['data_penarikan_saldo'] = $this->Penarikan_saldo_model->queryAll(); 
        $data['total_penarikan_saldo'] = $this->Penarikan_saldo_model->totalPenarikanSaldo();   
        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/penarikan_saldo/cetak_css_penarikan_saldo',$data);
    }

    public function exportSemuaPenarikanSaldo(){

        $this->load->model('admin/Penarikan_saldo_model');
        $data_penarikan_saldo = $this->Penarikan_saldo_model->queryAll();
        $total_penarikan_saldo = $this->Penarikan_saldo_model->totalPenarikanSaldo(); 
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Laporan Semua Penarikan Saldo');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Penarikan');
        $sheet->setCellValue('C5','Tanggal Penarikan');
        $sheet->setCellValue('D5','Nama Penarik');
        $sheet->setCellValue('E5','Keterangan');
        $sheet->setCellValue('F5','Jumlah Penarikan');
        $sheet->setCellValue('G5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_penarikan_saldo as $dtps): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtps->id_penarikan_saldo);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtps->tanggal_transaksi_penarikan_saldo));
           $sheet->setCellValue('D'.$nocel,$dtps->nama_penarik_saldo);
           $sheet->setCellValue('E'.$nocel,$dtps->keterangan_penarikan_saldo);
           $sheet->setCellValue('F'.$nocel,'Rp. '. number_format($dtps->jumlah_penarikan_saldo,0,',','.'));
           $sheet->setCellValue('G'.$nocel,$dtps->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':E'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Semua Penarikan Saldo');
            $sheet->setCellValue('F'.$nocel,'Rp. '.number_format($total_penarikan_saldo,0,',','.'));

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
            $sheet->getStyle('A5:G'.$celaktif)->applyFromArray($styleArray);
                                   
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:G2');
            $sheet->mergeCells('A3:G3');
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
            $sheet->getStyle('A5:G5')->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel.':G'.$nocel)->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('C')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('D')->setWidth(16, 'px');
            $sheet->getColumnDimension('E')->setWidth(12.64, 'px');
            $sheet->getColumnDimension('F')->setWidth(16.55, 'px');
            $sheet->getColumnDimension('G')->setWidth(12.73, 'px');
            $sheet->getRowDimension('5')->setRowHeight(24, 'px');
            $sheet->getStyle('A5:G5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A5:G5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Laporan_Semua_Penarikan_Saldo-'.time().'.xlsx';
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


    public function exportPenarikanSaldoPerTanggal(){
        $data1 = $_POST;

        $mulai_tanggal = tanggal_indonesia($data1['mulai_tanggal']);
        $sampai_tanggal = tanggal_indonesia($data1['sampai_tanggal']);
        $this->load->model('admin/Penarikan_saldo_model');
        $data_penarikan_saldo = $this->Penarikan_saldo_model->queryDueTo($data1);
        $total_penarikan_saldo = $this->Penarikan_saldo_model->totalPenarikanSaldoByDateTo($data1['mulai_tanggal'],$data1['sampai_tanggal']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Laporan Penarikan Saldo Hari Ini');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','Tanggal '.$mulai_tanggal.' Sampai '.$sampai_tanggal);

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Penarikan');
        $sheet->setCellValue('C5','Tanggal Penarikan');
        $sheet->setCellValue('D5','Nama Penarik');
        $sheet->setCellValue('E5','Keterangan');
        $sheet->setCellValue('F5','Jumlah Penarikan');
        $sheet->setCellValue('G5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_penarikan_saldo as $dtps): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtps->id_penarikan_saldo);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtps->tanggal_transaksi_penarikan_saldo));
           $sheet->setCellValue('D'.$nocel,$dtps->nama_penarik_saldo);
           $sheet->setCellValue('E'.$nocel,$dtps->keterangan_penarikan_saldo);
           $sheet->setCellValue('F'.$nocel,'Rp. '. number_format($dtps->jumlah_penarikan_saldo,0,',','.'));
           $sheet->setCellValue('G'.$nocel,$dtps->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':E'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Penarikan Saldo Tanggal '.$mulai_tanggal.' sampai '.$sampai_tanggal);
            $sheet->setCellValue('F'.$nocel,'Rp. '.number_format($total_penarikan_saldo,0,',','.'));

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
            $sheet->getStyle('A5:G'.$celaktif)->applyFromArray($styleArray);
                                   
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:G2');
            $sheet->mergeCells('A3:G3');
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
            $sheet->getStyle('A5:G5')->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel.':G'.$nocel)->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('C')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('D')->setWidth(16, 'px');
            $sheet->getColumnDimension('E')->setWidth(12.64, 'px');
            $sheet->getColumnDimension('F')->setWidth(16.55, 'px');
            $sheet->getColumnDimension('G')->setWidth(12.73, 'px');
            $sheet->getRowDimension('5')->setRowHeight(24, 'px');
            $sheet->getStyle('A5:G5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A5:G5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Laporan_Per_Tanggal_Penarikan_Saldo-'.time().'.xlsx';
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