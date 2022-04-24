<?php 

//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Nasabah_tidak_aktif extends CI_Controller{
    
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
            $data['header_halaman'] = 'Nasabah Tidak Aktif';
            $data['icon_header_halaman'] = 'exclamation';
            
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/nasabah_tidak_aktif/nasabah_tidak_aktif',$data); 
            $this->load->view('admin/templates/footer');
            
        }else{
             redirect(base_url().'beranda-admin');
             die();
         }


    }

    public function getNasabahTidakAktif(){
        $tabel = 'nasabah';
        $select_column = [
            'nasabah.id_nasabah',
            'nasabah.no_tanda_pengenal_nasabah',
            'nasabah.nama_nasabah',
            'nasabah.jenis_kelamin_nasabah',
            'nasabah.tempat_lahir_nasabah',
            'nasabah.tanggal_lahir_nasabah',
            'nasabah.no_telp_nasabah',
            'nasabah.saldo_nasabah',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel'
        ];

        $order_column = [
            null,
            'nasabah.id_nasabah',
            'nasabah.no_tanda_pengenal_nasabah',
            'nasabah.nama_nasabah',
            'nasabah.jenis_kelamin_nasabah',
            'nasabah.tempat_lahir_nasabah',
            'nasabah.tanggal_lahir_nasabah',
            'nasabah.no_telp_nasabah',
            'nasabah.saldo_nasabah',
            'kelas.tingkat',
            'jurusan.kode_jurusan',
            'kelas.rombel',
            null
        ];
      
        $this->load->model('admin/Nasabah_tidak_aktif_model');
        $fetch_data = $this->Nasabah_tidak_aktif_model->buatDataTables($tabel,$select_column,$order_column);
        $data = [];
        $nourut = $_POST['start'] + 1;
        foreach($fetch_data as $row)
        {
        
            $sub_array = [];
            $sub_array[] = $nourut;
            $sub_array[] = $row->id_nasabah;
            $sub_array[] = $row->no_tanda_pengenal_nasabah;
            $sub_array[] = $row->nama_nasabah;
            $sub_array[] = $row->tingkat." ".$row->kode_jurusan." ".$row->rombel;           
            $sub_array[] = $row->jenis_kelamin_nasabah;  
               
            $sub_array[] = 'Rp. '.number_format($row->saldo_nasabah,0,',','.');       
            $data[] = $sub_array;

            $nourut++;
        }

        $output = [
            'draw'              =>  intval($_POST['draw']),
            'recordsTotal'      =>  $this->Nasabah_tidak_aktif_model->getAllData($tabel,$select_column,$order_column),
            'recordsFiltered'   =>  $this->Nasabah_tidak_aktif_model->getFilteredData($tabel,$select_column,$order_column),
            'data'              =>  $data
        ];

        echo json_encode($output);
    }

    public function exportNasabahTidakAktif(){

        $this->load->model('admin/Nasabah_tidak_aktif_model');        
        $data_nasabah = $this->Nasabah_tidak_aktif_model->queryAll();
        $this->load->model('admin/Pengaturan_model');
        $pengaturan = $this->Pengaturan_model->getPengaturanById(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Input data ke table
        $sheet->setCellValue('A1','Laporan Nasabah Tidak Aktif');
        $sheet->setCellValue('A2','Bank Mini '.$pengaturan['nama_sekolah']);
        $sheet->setCellValue('A3','');

        $sheet->setCellValue('A5','No');
        $sheet->setCellValue('B5','ID Nasabah');
        $sheet->setCellValue('C5','No Pengenal/NIS');
        $sheet->setCellValue('D5','Nama Nasabah');
        $sheet->setCellValue('E5','Kelas');
        $sheet->setCellValue('F5','Jenis Kelamin');
        $sheet->setCellValue('G5','Saldo');

     $nourut = 1; 
     $nocel = 6; 
     foreach($data_nasabah as $dn): 
            

           $sheet->setCellValue('A'.$nocel,$nourut);
           $sheet->setCellValue('B'.$nocel,$dn->id_nasabah);
           $sheet->setCellValue('C'.$nocel,$dn->no_tanda_pengenal_nasabah);
           $sheet->setCellValue('D'.$nocel,$dn->nama_nasabah);
           $sheet->setCellValue('E'.$nocel,$dn->tingkat.' '.$dn->kode_jurusan.' '.$dn->rombel);
           $sheet->setCellValue('F'.$nocel,$dn->jenis_kelamin_nasabah);
           $sheet->setCellValue('G'.$nocel,'Rp. '. number_format($dn->saldo_nasabah,0,',','.'));
        
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
            
            $celaktif = $nocel - 1;
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
            $sheet->getColumnDimension('A')->setWidth(4, 'px');
            $sheet->getColumnDimension('B')->setWidth(15.45, 'px');
            $sheet->getColumnDimension('C')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('D')->setWidth(15.55, 'px');
            $sheet->getColumnDimension('E')->setWidth(16, 'px');
            $sheet->getColumnDimension('F')->setWidth(12.64, 'px');
            $sheet->getColumnDimension('G')->setWidth(16.55, 'px');
            $sheet->getRowDimension('5')->setRowHeight(24, 'px');
            $sheet->getStyle('A5:G5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A5:G5')->getFill()->getStartColor()->setRGB('33CC33');

        $filename = 'Laporan_Nasabah_Tidak_Aktif-'.time().'.xlsx';
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