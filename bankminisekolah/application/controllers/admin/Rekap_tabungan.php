<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Rekap_tabungan extends CI_Controller{
    
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
            $data['header_halaman'] = 'Rekap Tabungan';
            $data['icon_header_halaman'] = 'folder-open';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/rekap_tabungan/rekap_tabungan',$data); 
            $this->load->view('admin/templates/footer');

        }else{
             redirect(base_url().'beranda-admin');
             die();
         }
         
    }

    public function queryAll()
    {
        $tabel = 'transaksi_tabungan';
        $select_column = [
            'nasabah.id_nasabah',
            'nasabah.nama_nasabah',
            'nasabah.no_tanda_pengenal_nasabah',
            'transaksi_tabungan.tanggal_transaksi_tabungan',
            'transaksi_tabungan.jumlah_setoran_masuk',
            'transaksi_tabungan.jumlah_penarikan_tabungan',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel'
        ];

        $order_column = [
            null,
            'nasabah.id_nasabah',
            'nasabah.nama_nasabah',
            'nasabah.no_tanda_pengenal_nasabah',
            'transaksi_tabungan.tanggal_transaksi_tabungan',
            'transaksi_tabungan.jumlah_setoran_masuk',
            'transaksi_tabungan.jumlah_penarikan_tabungan',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel',
            null
        ];
      
        $this->load->model('admin/Rekap_tabungan_model');
        $fetch_data = $this->Rekap_tabungan_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = $_POST['start'] + 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = tanggal_indonesia($row->tanggal_transaksi_tabungan);
          
            $sub_array[] = $row->id_nasabah;
            $sub_array[] = $row->no_tanda_pengenal_nasabah;            
            $sub_array[] = $row->nama_nasabah;
            $sub_array[] = $row->tingkat." ".$row->kode_jurusan." ".$row->rombel;
                  
            $sub_array[] = "Rp. ".number_format($row->jumlah_setoran_masuk,0,",",".");       
            $sub_array[] = "Rp. ".number_format($row->jumlah_penarikan_tabungan,0,",",".");       
         
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Rekap_tabungan_model->getAllData($tabel,$select_column,$order_column),
            'recordsFiltered'   =>  $this->Rekap_tabungan_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }

    public function queryAllByNasabah()
    {
        
        $id_nasabah = $_POST["id_nasabah"];
        $tabel = 'transaksi_tabungan';
        $select_column = [
            'nasabah.id_nasabah',
            'nasabah.nama_nasabah',
            'nasabah.no_tanda_pengenal_nasabah',
            'transaksi_tabungan.tanggal_transaksi_tabungan',
            'transaksi_tabungan.jumlah_setoran_masuk',
            'transaksi_tabungan.jumlah_penarikan_tabungan',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel'
        ];

        $order_column = [
            null,
            'nasabah.id_nasabah',
            'nasabah.nama_nasabah',
            'nasabah.no_tanda_pengenal_nasabah',
            'transaksi_tabungan.tanggal_transaksi_tabungan',
            'transaksi_tabungan.jumlah_setoran_masuk',
            'transaksi_tabungan.jumlah_penarikan_tabungan',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel',
            null
        ];
      
        $this->load->model('admin/Rekap_tabungan_model');
        $fetch_data = $this->Rekap_tabungan_model->buatDataTables2($id_nasabah,$tabel,$select_column,$order_column);
        $data = [];
        $nourut = $_POST['start'] + 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = tanggal_indonesia($row->tanggal_transaksi_tabungan);
          
            $sub_array[] = $row->id_nasabah;
            $sub_array[] = $row->no_tanda_pengenal_nasabah;            
            $sub_array[] = $row->nama_nasabah;
            $sub_array[] = $row->tingkat." ".$row->kode_jurusan." ".$row->rombel;
                  
            $sub_array[] = "Rp. ".number_format($row->jumlah_setoran_masuk,0,",",".");       
            $sub_array[] = "Rp. ".number_format($row->jumlah_penarikan_tabungan,0,",",".");       
         
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Rekap_tabungan_model->getAllData2($id_nasabah,$tabel,$select_column,$order_column),
            'recordsFiltered'   =>  $this->Rekap_tabungan_model->getFilteredData2($id_nasabah,$tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }



    public function cetakSemuaRekapTabungan(){
       
        $this->load->model('admin/Rekap_tabungan_model');
        $data['data_rekap_tabungan'] = $this->Rekap_tabungan_model->queryAll();  
        $data['total_setoran_masuk'] = $this->Rekap_tabungan_model->totalSetoranMasuk();
        $data['total_penarikan_tabungan'] = $this->Rekap_tabungan_model->totalPenarikanTabungan();
        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/rekap_tabungan/cetak_css_rekap_tabungan',$data);
    }

    public function exportSemuaRekapTabungan(){

        $this->load->model('admin/Rekap_tabungan_model');
        $data_rekap_tabungan = $this->Rekap_tabungan_model->queryAll();
        $total_setoran_masuk = $this->Rekap_tabungan_model->totalSetoranMasuk();
        $total_penarikan_tabungan = $this->Rekap_tabungan_model->totalPenarikanTabungan();
        $sisa_saldo = $total_setoran_masuk - $total_penarikan_tabungan;
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Input data ke table
        $sheet->setCellValue('A1','Laporan Semua Rekap Tabungan');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','');

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','Tanggal Transaksi');
        $sheet->setCellValue('C5','ID Nasabah');
        $sheet->setCellValue('D5','No Pengenal/NIS');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Kelas');
        $sheet->setCellValue('G5','Jumlah Setoran');
        $sheet->setCellValue('H5','Jumlah Penarikan');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_rekap_tabungan as $drt): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($drt->tanggal_transaksi_tabungan));
           $sheet->setCellValue('B'.$nocel,$drt->id_nasabah);
           $sheet->setCellValue('D'.$nocel,$drt->no_tanda_pengenal_nasabah);
           $sheet->setCellValue('E'.$nocel,$drt->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$drt->tingkat.' '.$drt->kode_jurusan.' '.$drt->rombel);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($drt->jumlah_setoran_masuk,0,',','.'));
           $sheet->setCellValue('H'.$nocel,'Rp. '. number_format($drt->jumlah_penarikan_tabungan,0,',','.'));
        
         $nourut++; 
         $nocel++; 
     endforeach; 
            $nocel1 = $nocel + 1;
            $nocel2 = $nocel + 2;
            $sheet->mergeCells('A'.$nocel.':F'.$nocel);
            $sheet->mergeCells('G'.$nocel.':H'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Setoran Masuk');
            $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_setoran_masuk,0,',','.'));
            $sheet->mergeCells('A'.$nocel1.':F'.$nocel1);
            $sheet->mergeCells('G'.$nocel1.':H'.$nocel1);
            $sheet->setCellValue('A'.$nocel1,'Total Penarikan Tabungan');
            $sheet->setCellValue('G'.$nocel1,'Rp. '.number_format($total_penarikan_tabungan,0,',','.'));
            $sheet->mergeCells('A'.$nocel2.':F'.$nocel2);
            $sheet->mergeCells('G'.$nocel2.':H'.$nocel2);
            $sheet->setCellValue('A'.$nocel2,'Sisa Saldo Tabungan');
            $sheet->setCellValue('G'.$nocel2,'Rp. '.number_format($sisa_saldo,0,',','.'));

              // Mengatur style table        
              $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];
            
            $celaktif = $nocel + 2;
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
            $sheet->getStyle('A'.$nocel.':I'.$nocel)->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel1.':I'.$nocel1)->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel2.':I'.$nocel2)->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(15.45, 'px');
            $sheet->getColumnDimension('C')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('D')->setWidth(10.45, 'px');
            $sheet->getColumnDimension('E')->setWidth(16, 'px');
            $sheet->getColumnDimension('F')->setWidth(12.64, 'px');
            $sheet->getColumnDimension('G')->setWidth(16.55, 'px');
            $sheet->getColumnDimension('H')->setWidth(16.55, 'px');
            $sheet->getRowDimension('5')->setRowHeight(24, 'px');
            $sheet->getStyle('A5:H5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A5:H5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Laporan_Semua_Rekap_Tabungan-'.time().'.xlsx';
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


    public function exportRekapTabunganPerTanggal(){
        $data1 = $_POST;

        $mulai_tanggal = tanggal_indonesia($data1['mulai_tanggal']);
        $sampai_tanggal = tanggal_indonesia($data1['sampai_tanggal']);
        $this->load->model('admin/Rekap_tabungan_model');
        $data_rekap_tabungan = $this->Rekap_tabungan_model->queryDueTo($data1);
        $total_setoran_masuk = $this->Rekap_tabungan_model->totalSetoranMasukByDateTo($data1['mulai_tanggal'],$data1['sampai_tanggal']);
        $total_penarikan_tabungan = $this->Rekap_tabungan_model->totalPenarikanTabunganByDateTo($data1['mulai_tanggal'],$data1['sampai_tanggal']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        
        $sheet = $spreadsheet->getActiveSheet();

       // Input data ke table
       $sheet->setCellValue('A1','Laporan Rekap Tabungan');
       $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
       $sheet->setCellValue('A3','Tanggal '.$mulai_tanggal.' sampai '.$sampai_tanggal);

       $sheet->setCellValue('A5','No');
       $sheet->setCellValue('B5','Tanggal Transaksi');
       $sheet->setCellValue('C5','ID Nasabah');
       $sheet->setCellValue('D5','No Pengenal/NIS');
       $sheet->setCellValue('E5','Nama Nasabah');
       $sheet->setCellValue('F5','Kelas');
       $sheet->setCellValue('G5','Jumlah Setoran');
       $sheet->setCellValue('H5','Jumlah Penarikan');

    $nourut = 1; 
    $nocel = 6; 
    foreach($data_rekap_tabungan as $drt): 
     
          $sheet->setCellValue('A'.$nocel,$nourut);
          $sheet->setCellValue('C'.$nocel,tanggal_indonesia($drt->tanggal_transaksi_tabungan));
          $sheet->setCellValue('B'.$nocel,$drt->id_nasabah);
          $sheet->setCellValue('D'.$nocel,$drt->no_tanda_pengenal_nasabah);
          $sheet->setCellValue('E'.$nocel,$drt->nama_nasabah);
          $sheet->setCellValue('F'.$nocel,$drt->tingkat.' '.$drt->kode_jurusan.' '.$drt->rombel);
          $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($drt->jumlah_setoran_masuk,0,',','.'));
          $sheet->setCellValue('H'.$nocel,'Rp. '. number_format($drt->jumlah_penarikan_tabungan,0,',','.'));
       
        $nourut++; 
        $nocel++; 
    endforeach; 
           $nocel1 = $nocel + 1;
           $sheet->mergeCells('A'.$nocel.':F'.$nocel);
           $sheet->mergeCells('G'.$nocel.':H'.$nocel);
           $sheet->setCellValue('A'.$nocel,'Total Setoran Masuk');
           $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_setoran_masuk,0,',','.'));
           $sheet->mergeCells('A'.$nocel1.':F'.$nocel1);
           $sheet->mergeCells('G'.$nocel1.':H'.$nocel1);
           $sheet->setCellValue('A'.$nocel1,'Total Penarikan Tabungan');
           $sheet->setCellValue('G'.$nocel1,'Rp. '.number_format($total_penarikan_tabungan,0,',','.'));


             // Mengatur style table        
             $styleArray = [
               'borders' => [
                   'allBorders' => [
                       'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                       'color' => ['rgb' => '000000'],
                   ],
               ],
           ];
           
           $celaktif = $nocel + 1;
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
           $sheet->getStyle('A'.$nocel.':I'.$nocel)->applyFromArray($styleArray);
           $sheet->getStyle('A'.$nocel1.':I'.$nocel1)->applyFromArray($styleArray);
           $sheet->getColumnDimension('A')->setWidth(4, 'px');
           $sheet->getColumnDimension('B')->setWidth(15.45, 'px');
           $sheet->getColumnDimension('C')->setWidth(15.55, 'px');
           $sheet->getColumnDimension('D')->setWidth(10.45, 'px');
           $sheet->getColumnDimension('E')->setWidth(16, 'px');
           $sheet->getColumnDimension('F')->setWidth(12.64, 'px');
           $sheet->getColumnDimension('G')->setWidth(16.55, 'px');
           $sheet->getColumnDimension('H')->setWidth(16.55, 'px');
           $sheet->getRowDimension('5')->setRowHeight(24, 'px');
           $sheet->getStyle('A5:H5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
           $sheet->getStyle('A5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
           $sheet->getStyle('A5:H5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Laporan_Per_Tanggal_Rekap_Tabungan-'.time().'.xlsx';
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