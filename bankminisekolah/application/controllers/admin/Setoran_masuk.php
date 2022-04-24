<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Setoran_masuk extends CI_Controller{
    
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
            $data['header_halaman'] = 'Setoran Masuk';
            $data['icon_header_halaman'] = 'shopping-cart';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/setoran_masuk/setoran_masuk',$data); 
            $this->load->view('admin/templates/footer');
            
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }

    }

    public function queryAll()
    {
        $tabel = 'setoran_masuk';
        $select_column = [
            'setoran_masuk.id_setoran_masuk',
            'setoran_masuk.id_nasabah',
            'nasabah.nama_nasabah',
            'setoran_masuk.id_jenis_setoran',
            'jenis_setoran.jenis_setoran',
            'setoran_masuk.tanggal_transaksi_setoran_masuk',
            'setoran_masuk.jumlah_setoran_masuk',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel'
        ];

        $order_column = [
            null,
            'setoran_masuk.id_setoran_masuk',
            'setoran_masuk.id_nasabah',
            'nasabah.nama_nasabah',
            'setoran_masuk.id_jenis_setoran',
            'jenis_setoran.jenis_setoran',
            'setoran_masuk.tanggal_transaksi_setoran_masuk',
            'setoran_masuk.jumlah_setoran_masuk',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel',
            null
        ];
      
        $this->load->model('admin/Setoran_masuk_model');
        $fetch_data = $this->Setoran_masuk_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = $_POST['start'] + 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_setoran_masuk;
            $sub_array[] = $row->nama_nasabah;
            $sub_array[] = $row->id_nasabah;
            $sub_array[] = $row->tingkat." ".$row->kode_jurusan." ".$row->rombel;
            $sub_array[] = $row->jenis_setoran;            
            $sub_array[] = tanggal_indonesia($row->tanggal_transaksi_setoran_masuk);            
            $sub_array[] = "Rp. ".number_format($row->jumlah_setoran_masuk,0,",",".");       
            
            $sub_array[] = '
                            <button class="badge badge-primary badge-sm border-0" style="margin: 2px;" onclick="btnDetail(\''.$row->id_setoran_masuk.'\')" title="Detail" data-toggle="modal" data-target="#modalDetailSetoranMasuk"><i class="fa fa-fw fa-info"></i></button>
                            
                            <button class="badge badge-warning badge-sm border-0" style="margin: 2px;" onclick="btnModalUbah(\''.$row->id_setoran_masuk.'\')" title="Ubah" data-toggle="modal" data-target="#modalSetoranMasuk"><i class="fa fa-fw fa-edit"></i></button> 
                            
                            <button class="badge badge-danger badge-sm border-0" style="margin: 2px;" onclick="btnModalHapus(\''.$row->id_setoran_masuk.'\')" title="Hapus"><i class="fa fa-fw fa-trash"></i></button> 
                            ';
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Setoran_masuk_model->getAllData($tabel,$select_column,$order_column),
            'recordsFiltered'   =>  $this->Setoran_masuk_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }



    public function queryById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Setoran_masuk_model');
        $data = $this->Setoran_masuk_model->queryById($data);     

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
        $this->load->model('admin/Setoran_masuk_model');
        $data = $this->Setoran_masuk_model->cekID();

        echo json_encode($data);
    }

    public function cekSaldoSebelumnya(){
        $data = $_POST;
        $id_nasabah = $data['id_nasabah'];
        $this->load->model('admin/Setoran_masuk_model');
        $data = $this->Setoran_masuk_model->cekSaldoSebelumnya($id_nasabah);

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
        $id_nasabah = $data['id_nasabah'];  

        $this->load->model('admin/Setoran_masuk_model');
        $status = $this->Setoran_masuk_model->tambah($data);
       
        if($status == 1){         
            $data = [
                  'status' => 'success',
                  'title' => 'Berhasil',
                  'pesan' => 'Data berhasil Ditambah....!'
              ];

                $this->load->model('admin/Setoran_masuk_model');
                $saldo_sekarang = $this->Setoran_masuk_model->cekSaldoSebelumnya($id_nasabah);

                $data_saldo = [
                    'id_nasabah' => $id_nasabah,
                    'saldo_nasabah' => $saldo_sekarang
                ];
                $this->load->model('admin/Nasabah_model');
                $status = $this->Nasabah_model->ubah($data_saldo);
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
        $id_nasabah = $data['id_nasabah'];
        
        $this->load->model('admin/Setoran_masuk_model');  
        $this->load->model('admin/Penarikan_tabungan_model');  
        //hitung total setoran masuk - jml setoran ini sebelumya
        $jml_setoran_masuk = $this->Setoran_masuk_model->totalSetoranMasukByNasabah($id_nasabah);
        $data2 = $this->Setoran_masuk_model->queryById($data);
        $setoran_masuk_nasabah_sebelumnya = $data2['jumlah_setoran_masuk'];
        $setoran_masuk = $jml_setoran_masuk - $setoran_masuk_nasabah_sebelumnya;
        $setoran_masuk_baru = $setoran_masuk + $data['jumlah_setoran_masuk'];
        $jml_penarikan_tabungan = $this->Penarikan_tabungan_model->totalPenarikanTabunganByNasabah($id_nasabah);
        
        if($setoran_masuk_baru >= $jml_penarikan_tabungan){
            $status = $this->Setoran_masuk_model->ubah($data);
        
        
            if($status == 1){
                $data = [
                    'status' => 'success',
                    'title' => 'Berhasil',
                    'pesan' => 'Data berhasil Diubah....!'
                ];

                $this->load->model('admin/Setoran_masuk_model');
                $saldo_sekarang = $this->Setoran_masuk_model->cekSaldoSebelumnya($id_nasabah);

                $data_saldo = [
                    'id_nasabah' => $id_nasabah,
                    'saldo_nasabah' => $saldo_sekarang
                ];
                $this->load->model('admin/Nasabah_model');
                $status = $this->Nasabah_model->ubah($data_saldo);
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
                'pesan' => 'Saldo kurang dari jumlah penarikan...! Masukan Jumlah setoran yang lebih besar dari itu...!!'
            ];
        }

        echo json_encode($data);
        
    }

    public function hapus(){
        $data = $_POST;

               
        $this->load->model('admin/Setoran_masuk_model');  
        $this->load->model('admin/Penarikan_tabungan_model'); 
        $data2 = $this->Setoran_masuk_model->queryById($data);
        $id_nasabah = $data2['id_nasabah']; 
        //hitung total setoran masuk - jml setoran ini sebelumya
        $jml_setoran_masuk = $this->Setoran_masuk_model->totalSetoranMasukByNasabah($id_nasabah);
        $setoran_masuk_nasabah_sebelumnya = $data2['jumlah_setoran_masuk'];
        $setoran_masuk = $jml_setoran_masuk - $setoran_masuk_nasabah_sebelumnya;
        $jml_penarikan_tabungan = $this->Penarikan_tabungan_model->totalPenarikanTabunganByNasabah($id_nasabah);
        
        if($setoran_masuk >= $jml_penarikan_tabungan){

            $this->load->model('admin/Setoran_masuk_model');
            $status = $this->Setoran_masuk_model->hapus($data);
        
            if($status == 1){         
                $data = [
                    'status' => 'success',
                    'title' => 'Berhasil',
                    'pesan' => 'Data Berhasil di Hapus....!'
                ];

                $this->load->model('admin/Setoran_masuk_model');
                $saldo_sekarang = $this->Setoran_masuk_model->cekSaldoSebelumnya($id_nasabah);

                $data_saldo = [
                    'id_nasabah' => $id_nasabah,
                    'saldo_nasabah' => $saldo_sekarang
                ];
                $this->load->model('admin/Nasabah_model');
                $status = $this->Nasabah_model->ubah($data_saldo);
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
                'pesan' => 'Data Gagal di Hapus....! Setoran ini sudah ditarik nasabah...!'
            ];
        }    

        echo json_encode($data);


    }

    public function cetakBuktiSetoranMasuk(){
        $data1 = $_POST;
        $this->load->model('admin/Setoran_masuk_model');
        $data['data_setoran_masuk'] = $this->Setoran_masuk_model->queryById($data1);  
        $tgl_transaksi = $data['data_setoran_masuk']['tanggal_transaksi_setoran_masuk'];
        $data['data_setoran_masuk']['tanggal_transaksi_setoran_masuk'] = tanggal_indonesia($tgl_transaksi);

        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/setoran_masuk/cetak_bukti_setoran_masuk',$data);
    }

    public function cetakSetoranMasukHariIni(){
        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Setoran_masuk_model');
        $data['data_setoran_masuk'] = $this->Setoran_masuk_model->queryByDateNow($data1);
        $data['total_setoran_masuk'] = $this->Setoran_masuk_model->totalSetoranMasukByDate($data1['tanggal_hari_ini']);

        $data['tanggal_hari_ini'] = tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/setoran_masuk/cetak_chi_setoran_masuk',$data);
    }

    public function exportSetoranMasukHariIni(){
        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Setoran_masuk_model');
        $data_setoran_masuk = $this->Setoran_masuk_model->queryByDateNow($data1);  
        $total_setoran_masuk = $this->Setoran_masuk_model->totalSetoranMasukByDate($data1['tanggal_hari_ini']);

        $tanggal_hari_ini= tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Laporan Setoran Masuk Hari Ini');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','Tanggal '.$tanggal_hari_ini);

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Setoran Masuk');
        $sheet->setCellValue('C5','Tanggal Transaksi');
        $sheet->setCellValue('D5','ID Nasabah');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Jenis Setoran');
        $sheet->setCellValue('G5','Jumlah Setoran');
        $sheet->setCellValue('H5','Kelas');
        $sheet->setCellValue('I5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_setoran_masuk as $dtsm): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtsm->id_setoran_masuk);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtsm->tanggal_transaksi_setoran_masuk));
           $sheet->setCellValue('D'.$nocel,$dtsm->id_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtsm->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$dtsm->jenis_setoran);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dtsm->jumlah_setoran_masuk,0,',','.'));
           $sheet->setCellValue('H'.$nocel,$dtsm->tingkat.' '.$dtsm->kode_jurusan.' '.$dtsm->rombel);
           $sheet->setCellValue('I'.$nocel,$dtsm->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

     $sheet->mergeCells('A'.$nocel.':F'.$nocel);
     $sheet->setCellValue('A'.$nocel,'Total Setoran Masuk Hari Ini');
     $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_setoran_masuk,0,',','.'));
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

        $filename = 'Laporan_Setoran_Masuk_Hari_ini-'.time().'.xlsx';
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

    public function cetakSemuaSetoranMasuk(){
       
        $this->load->model('admin/Setoran_masuk_model');
        $data['data_setoran_masuk'] = $this->Setoran_masuk_model->queryAll();  
        $data['total_setoran_masuk'] = $this->Setoran_masuk_model->totalSetoranMasuk();
        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/setoran_masuk/cetak_css_setoran_masuk',$data);
    }

    public function exportSemuaSetoranMasuk(){

        $this->load->model('admin/Setoran_masuk_model');
        $data_setoran_masuk = $this->Setoran_masuk_model->queryAll();
        $total_setoran_masuk = $this->Setoran_masuk_model->totalSetoranMasuk();
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Input data ke table
        $sheet->setCellValue('A1','Laporan Semua Setoran Masuk');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','');

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Setoran Masuk');
        $sheet->setCellValue('C5','Tanggal Transaksi');
        $sheet->setCellValue('D5','ID Nasabah');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Jenis Setoran');
        $sheet->setCellValue('G5','Jumlah Setoran');
        $sheet->setCellValue('H5','Kelas');
        $sheet->setCellValue('I5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_setoran_masuk as $dtsm): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtsm->id_setoran_masuk);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtsm->tanggal_transaksi_setoran_masuk));
           $sheet->setCellValue('D'.$nocel,$dtsm->id_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtsm->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$dtsm->jenis_setoran);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dtsm->jumlah_setoran_masuk,0,',','.'));
           $sheet->setCellValue('H'.$nocel,$dtsm->tingkat.' '.$dtsm->kode_jurusan.' '.$dtsm->rombel);
           $sheet->setCellValue('I'.$nocel,$dtsm->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':F'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Semua Setoran Masuk');
            $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_setoran_masuk,0,',','.'));

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

        $filename = 'Laporan_Semua_Setoran_Masuk-'.time().'.xlsx';
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


    public function exportSetoranMasukPerTanggal(){
        $data1 = $_POST;

        $mulai_tanggal = tanggal_indonesia($data1['mulai_tanggal']);
        $sampai_tanggal = tanggal_indonesia($data1['sampai_tanggal']);
        $this->load->model('admin/Setoran_masuk_model');
        $data_setoran_masuk = $this->Setoran_masuk_model->queryDueTo($data1);
        $total_setoran_masuk = $this->Setoran_masuk_model->totalSetoranMasukByDateTo($data1['mulai_tanggal'],$data1['sampai_tanggal']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Laporan Setoran Masuk');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3',$mulai_tanggal.' Sampai '.$sampai_tanggal );

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Setoran Masuk');
        $sheet->setCellValue('C5','Tanggal Transaksi');
        $sheet->setCellValue('D5','ID Nasabah');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Jenis Setoran');
        $sheet->setCellValue('G5','Jumlah Setoran');
        $sheet->setCellValue('H5','Kelas');
        $sheet->setCellValue('I5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_setoran_masuk as $dtsm): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtsm->id_setoran_masuk);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtsm->tanggal_transaksi_setoran_masuk));
           $sheet->setCellValue('D'.$nocel,$dtsm->id_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtsm->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$dtsm->jenis_setoran);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dtsm->jumlah_setoran_masuk,0,',','.'));
           $sheet->setCellValue('H'.$nocel,$dtsm->tingkat.' '.$dtsm->kode_jurusan.' '.$dtsm->rombel);
           $sheet->setCellValue('I'.$nocel,$dtsm->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 
            $sheet->mergeCells('A'.$nocel.':F'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Setoran Masuk dari tanggal '.$mulai_tanggal.' sampai '.$sampai_tanggal);
            $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_setoran_masuk,0,',','.'));

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

        $filename = 'Laporan_Per_Tanggal_Setoran_Masuk-'.time().'.xlsx';
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