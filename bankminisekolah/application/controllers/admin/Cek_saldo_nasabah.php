<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Cek_saldo_nasabah extends CI_Controller{
    
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
            $data['header_halaman'] = 'Cek Saldo Nasabah';
            $data['icon_header_halaman'] = 'dollar-sign';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/cek_saldo_nasabah/cek_saldo_nasabah',$data); 
            $this->load->view('admin/templates/footer');
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }

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

    public function getNasabahById()
    {
        $data = $_POST;
        
        $this->load->model('admin/Nasabah_model');
        $data = $this->Nasabah_model->queryById($data);     

        echo json_encode($data);
      
    }

    public function getSaldoNasabah()
    {
        $data = $_POST;
        $id_nasabah = $data['id_nasabah'];
        
        $this->load->model('admin/Setoran_masuk_model');
        $data = $this->Setoran_masuk_model->cekSaldoSebelumnya($id_nasabah);

        echo json_encode($data);
    }


    public function cetak(){
        $id_nasabah = $this->uri->segment(4);

        date_default_timezone_set('Asia/Jakarta');

        $data['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Rekap_tabungan_model');
        $this->load->model('admin/Nasabah_model');
        $data['data_transaksi_tabungan'] = $this->Rekap_tabungan_model->queryAllByNasabah($id_nasabah);        
        $data['data_nasabah'] = $this->Nasabah_model->queryById(["id_nasabah" => $id_nasabah]);        

        $this->load->model('admin/Pengaturan_model');
        $data['pengaturan'] = $this->Pengaturan_model->getPengaturanById(); 

        $this->load->view('admin/cek_saldo_nasabah/cetak_transaksi_tabungan',$data);
    }


    public function export(){
        $id_nasabah = $this->uri->segment(4);

        date_default_timezone_set('Asia/Jakarta');

        $data1['tanggal_hari_ini'] = date('Y-m-d');

        $this->load->model('admin/Rekap_tabungan_model');
        $this->load->model('admin/Nasabah_model');
        $data_transaksi_tabungan = $this->Rekap_tabungan_model->queryAllByNasabah($id_nasabah);
        $data_nasabah = $this->Nasabah_model->queryById(["id_nasabah" => $id_nasabah]);

        $tanggal_hari_ini= tanggal_indonesia($data1['tanggal_hari_ini']);
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // input data ke table
        $sheet->setCellValue('A1','Rekening Koran Nasabah');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','Tanggal '.$tanggal_hari_ini);
        $sheet->setCellValue('A5','ID        : '.$data_nasabah['id_nasabah']);
        $sheet->setCellValue('A6','Nama : '.$data_nasabah['nama_nasabah']);
        $sheet->setCellValue('D5','Kelas : '.$data_nasabah['tingkat'].' '.$data_nasabah['kode_jurusan'].' '.$data_nasabah['rombel']);
        $sheet->setCellValue('D6','Saldo : '.$data_nasabah['saldo_nasabah']);

        $sheet->setCellValue('A7','No');
        $sheet->setCellValue('B7','Tanggal Transaksi');
        $sheet->setCellValue('C7','Jumlah Setoran');
        $sheet->setCellValue('D7','Jumlah Penarikan');

     $nourut = 1; 
     $nocel = 8; 
     foreach($data_transaksi_tabungan as $dttt): 
      
           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,tanggal_indonesia($dttt->tanggal_transaksi_tabungan));
           $sheet->setCellValue('C'.$nocel,'Rp. '. number_format($dttt->jumlah_setoran_masuk,0,',','.'));
           $sheet->setCellValue('D'.$nocel,'Rp. '. number_format($dttt->jumlah_penarikan_tabungan,0,',','.'));
        
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
            $sheet->getStyle('A7:D'.$celaktif)->applyFromArray($styleArray);
                                   
            $sheet->mergeCells('A1:D1');
            $sheet->mergeCells('A2:D2');
            $sheet->mergeCells('A3:D3');
            $sheet->mergeCells('A5:B5');
            $sheet->mergeCells('A6:B6');
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
            $sheet->getStyle('A7:D7')->applyFromArray($styleArray);
            $sheet->getStyle('A'.$nocel.':D'.$nocel)->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(17.71, 'px');
            $sheet->getColumnDimension('C')->setWidth(23.15, 'px');
            $sheet->getColumnDimension('D')->setWidth(23.15, 'px');
            $sheet->getRowDimension('7')->setRowHeight(24, 'px');
            $sheet->getStyle('A7:D7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A7:D7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A7:D7')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Rekening Koran Nasabah- '.$data_nasabah['id_nasabah'].' -'.time().'.xlsx';
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