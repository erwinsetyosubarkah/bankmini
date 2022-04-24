<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Penarikan_tabungan extends CI_Controller{
    
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
            $data['header_halaman'] = 'Penarikan Tabungan';
            $data['icon_header_halaman'] = 'cart-arrow-down';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/penarikan_tabungan/penarikan_tabungan',$data); 
            $this->load->view('admin/templates/footer');
            
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }

    }

    public function queryAll()
    {
        $tabel = 'penarikan_tabungan';
        $select_column = [
            'penarikan_tabungan.id_penarikan_tabungan',
            'penarikan_tabungan.id_nasabah',
            'nasabah.nama_nasabah',
            'penarikan_tabungan.keterangan_penarikan_tabungan',
            'penarikan_tabungan.tanggal_transaksi_penarikan_tabungan',
            'penarikan_tabungan.jumlah_penarikan_tabungan',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel'
        ];

        $order_column = [
            null,
            'penarikan_tabungan.id_penarikan_tabungan',
            'penarikan_tabungan.id_nasabah',
            'nasabah.nama_nasabah',
            'penarikan_tabungan.keterangan_penarikan_tabungan',
            'penarikan_tabungan.tanggal_transaksi_penarikan_tabungan',
            'penarikan_tabungan.jumlah_penarikan_tabungan',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel',
            null
        ];
      
        $this->load->model('admin/Penarikan_tabungan_model');
        $fetch_data = $this->Penarikan_tabungan_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = $_POST['start'] + 1;
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_penarikan_tabungan;
            $sub_array[] = $row->nama_nasabah;
            $sub_array[] = $row->id_nasabah;
            $sub_array[] = $row->tingkat." ".$row->kode_jurusan." ".$row->rombel;
            $sub_array[] = $row->keterangan_penarikan_tabungan;            
            $sub_array[] = tanggal_indonesia($row->tanggal_transaksi_penarikan_tabungan);            
            $sub_array[] = "Rp. ".number_format($row->jumlah_penarikan_tabungan,0,",",".");       
            
            $sub_array[] = '
                            <button class="badge badge-primary badge-sm border-0" style="margin: 2px;" onclick="btnDetail(\''.$row->id_penarikan_tabungan.'\')" title="Detail" data-toggle="modal" data-target="#modalDetailPenarikanTabungan"><i class="fa fa-fw fa-info"></i></button>
                            
                            <button class="badge badge-warning badge-sm border-0" style="margin: 2px;" onclick="btnModalUbah(\''.$row->id_penarikan_tabungan.'\')" title="Ubah" data-toggle="modal" data-target="#modalPenarikanTabungan"><i class="fa fa-fw fa-edit"></i></button> 
                            
                            <button class="badge badge-danger badge-sm border-0" style="margin: 2px;" onclick="btnModalHapus(\''.$row->id_penarikan_tabungan.'\')" title="Hapus"><i class="fa fa-fw fa-trash"></i></button> 
                            ';
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Penarikan_tabungan_model->getAllData($tabel,$select_column,$order_column),
            'recordsFiltered'   =>  $this->Penarikan_tabungan_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
      
    }



    public function queryById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Penarikan_tabungan_model');
        $data = $this->Penarikan_tabungan_model->queryById($data);     

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
        $this->load->model('admin/Penarikan_tabungan_model');
        $data = $this->Penarikan_tabungan_model->cekID();

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
        $saldo_sebelumnya = $this->Setoran_masuk_model->cekSaldoSebelumnya($id_nasabah);

        if($saldo_sebelumnya >= $data['jumlah_penarikan_tabungan']){
            $this->load->model('admin/Penarikan_tabungan_model');
            $status = $this->Penarikan_tabungan_model->tambah($data);
        
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

        $id_nasabah = $data['id_nasabah'];
        $this->load->model('admin/Setoran_masuk_model');
        $this->load->model('admin/Penarikan_tabungan_model'); 
        $data2 = $this->Penarikan_tabungan_model->queryById($data);
        $id_nasabah = $data2['id_nasabah'];
        $jml_yg_diubah = $data2['jumlah_penarikan_tabungan'];
        $saldo_sebelumnya = $this->Setoran_masuk_model->cekSaldoSebelumnya($id_nasabah);
        $saldo_sebelumnya1 = $saldo_sebelumnya + $jml_yg_diubah;
        
        if($saldo_sebelumnya1 >= $data['jumlah_penarikan_tabungan']){
                  
            $status = $this->Penarikan_tabungan_model->ubah($data);
        
        
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
                'pesan' => 'Saldo kurang dari jumlah penarikan...!'
            ];
        }

        echo json_encode($data);
        
    }

    public function hapus(){
        $data = $_POST;

        $this->load->model('admin/Penarikan_tabungan_model'); 
        $data2 = $this->Penarikan_tabungan_model->queryById($data);
        $id_nasabah = $data2['id_nasabah'];
        $status = $this->Penarikan_tabungan_model->hapus($data);
     
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

        echo json_encode($data);


    }

    public function cetakBuktiPenarikanTabungan(){
        $data1 = $_POST;
        $this->load->model('admin/Penarikan_tabungan_model');
        $data['data_penarikan_tabungan'] = $this->Penarikan_tabungan_model->queryById($data1);
        $tgl_transaksi = $data['data_penarikan_tabungan']['tanggal_transaksi_penarikan_tabungan'];
        $data['data_penarikan_tabungan']['tanggal_transaksi_penarikan_tabungan'] = tanggal_indonesia($tgl_transaksi);  

        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/penarikan_tabungan/cetak_bukti_penarikan_tabungan',$data);
    }

    public function cetakPenarikanTabunganHariIni(){
        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Penarikan_tabungan_model');
        $data['data_penarikan_tabungan'] = $this->Penarikan_tabungan_model->queryByDateNow($data1);
        $data['total_penarikan_tabungan'] = $this->Penarikan_tabungan_model->totalPenarikanTabunganByDate($data1['tanggal_hari_ini']);  

        $data['tanggal_hari_ini'] = tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/penarikan_tabungan/cetak_chi_penarikan_tabungan',$data);
    }

    public function exportPenarikanTabunganHariIni(){
        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Penarikan_tabungan_model');
        $data_penarikan_tabungan = $this->Penarikan_tabungan_model->queryByDateNow($data1); 
        $total_penarikan_tabungan = $this->Penarikan_tabungan_model->totalPenarikanTabunganByDate($data1['tanggal_hari_ini']);   

        $tanggal_hari_ini= tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Laporan Penarikan Tabungan Hari Ini');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','Tanggal '.$tanggal_hari_ini);

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Penarikan');
        $sheet->setCellValue('C5','Tanggal Penarikan');
        $sheet->setCellValue('D5','ID Nasabah');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Keterangan');
        $sheet->setCellValue('G5','Jumlah Penarikan');
        $sheet->setCellValue('H5','Kelas');
        $sheet->setCellValue('I5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_penarikan_tabungan as $dtpt): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtpt->id_penarikan_tabungan);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtpt->tanggal_transaksi_penarikan_tabungan));
           $sheet->setCellValue('D'.$nocel,$dtpt->id_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtpt->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$dtpt->keterangan_penarikan_tabungan);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dtpt->jumlah_penarikan_tabungan,0,',','.'));
           $sheet->setCellValue('H'.$nocel,$dtpt->tingkat.' '.$dtpt->kode_jurusan.' '.$dtpt->rombel);
           $sheet->setCellValue('I'.$nocel,$dtpt->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':F'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Penarikan Tabungan Hari Ini');
            $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_penarikan_tabungan,0,',','.'));

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

        $filename = 'Laporan_Penarikan_Tabungan_Hari_ini-'.time().'.xlsx';
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

    public function cetakSemuaPenarikanTabungan(){
       
        $this->load->model('admin/Penarikan_tabungan_model');
        $data['data_penarikan_tabungan'] = $this->Penarikan_tabungan_model->queryAll(); 
        $data['total_penarikan_tabungan'] = $this->Penarikan_tabungan_model->totalPenarikanTabungan();   
        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/penarikan_tabungan/cetak_css_penarikan_tabungan',$data);
    }

    public function exportSemuaPenarikanTabungan(){

        $this->load->model('admin/Penarikan_tabungan_model');
        $data_penarikan_tabungan = $this->Penarikan_tabungan_model->queryAll();
        $total_penarikan_tabungan = $this->Penarikan_tabungan_model->totalPenarikanTabungan(); 
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Input data ke table
        $sheet->setCellValue('A1','Laporan Semua Penarikan Tabungan');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','');

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Penarikan');
        $sheet->setCellValue('C5','Tanggal Penarikan');
        $sheet->setCellValue('D5','ID Nasabah');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Keterangan');
        $sheet->setCellValue('G5','Jumlah Penarikan');
        $sheet->setCellValue('H5','Kelas');
        $sheet->setCellValue('I5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_penarikan_tabungan as $dtpt): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtpt->id_penarikan_tabungan);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtpt->tanggal_transaksi_penarikan_tabungan));
           $sheet->setCellValue('D'.$nocel,$dtpt->id_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtpt->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$dtpt->keterangan_penarikan_tabungan);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dtpt->jumlah_penarikan_tabungan,0,',','.'));
           $sheet->setCellValue('H'.$nocel,$dtpt->tingkat.' '.$dtpt->kode_jurusan.' '.$dtpt->rombel);
           $sheet->setCellValue('I'.$nocel,$dtpt->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':F'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Semua Penarikan Tabungan');
            $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_penarikan_tabungan,0,',','.'));
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

        $filename = 'Laporan_Semua_Penarikan_Tabungan-'.time().'.xlsx';
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


    public function exportPenarikanTabunganPerTanggal(){
        $data1 = $_POST;

        $mulai_tanggal = tanggal_indonesia($data1['mulai_tanggal']);
        $sampai_tanggal = tanggal_indonesia($data1['sampai_tanggal']);
        $this->load->model('admin/Penarikan_tabungan_model');
        $data_penarikan_tabungan = $this->Penarikan_tabungan_model->queryDueTo($data1);
        $total_penarikan_tabungan = $this->Penarikan_tabungan_model->totalPenarikanTabunganByDateTo($data1['mulai_tanggal'],$data1['sampai_tanggal']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Laporan Penarikan Tabungan');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3',$mulai_tanggal.' Sampai '.$sampai_tanggal );

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Penarikan');
        $sheet->setCellValue('C5','Tanggal Penarikan');
        $sheet->setCellValue('D5','ID Nasabah');
        $sheet->setCellValue('E5','Nama Nasabah');
        $sheet->setCellValue('F5','Keterangan');
        $sheet->setCellValue('G5','Jumlah Penarikan');
        $sheet->setCellValue('H5','Kelas');
        $sheet->setCellValue('I5','Petugas');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_penarikan_tabungan as $dtpt): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dtpt->id_penarikan_tabungan);
           $sheet->setCellValue('C'.$nocel,tanggal_indonesia($dtpt->tanggal_transaksi_penarikan_tabungan));
           $sheet->setCellValue('D'.$nocel,$dtpt->id_nasabah);
           $sheet->setCellValue('E'.$nocel,$dtpt->nama_nasabah);
           $sheet->setCellValue('F'.$nocel,$dtpt->keterangan_penarikan_tabungan);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dtpt->jumlah_penarikan_tabungan,0,',','.'));
           $sheet->setCellValue('H'.$nocel,$dtpt->tingkat.' '.$dtpt->kode_jurusan.' '.$dtpt->rombel);
           $sheet->setCellValue('I'.$nocel,$dtpt->nama_pengguna);
        
         $nourut++; 
         $nocel++; 
     endforeach; 

            $sheet->mergeCells('A'.$nocel.':F'.$nocel);
            $sheet->setCellValue('A'.$nocel,'Total Penarikan Tabungan dari tanggal '.$mulai_tanggal.' sampai '.$sampai_tanggal);
            $sheet->setCellValue('G'.$nocel,'Rp. '.number_format($total_penarikan_tabungan,0,',','.'));

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

        $filename = 'Laporan_Per_Tanggal_Penarikan_Tabungan-'.time().'.xlsx';
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