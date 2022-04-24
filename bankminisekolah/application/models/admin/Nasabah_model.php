<?php 



class Nasabah_model extends CI_Model{

    public function queryById($data = [])
    {
              
        $kol_id = 'id_nasabah';        
        $tabel = 'nasabah';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($kol_id,$data['id_nasabah']);
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->row_array();
    }

    public function queryAll()
    {      
        $tabel = 'nasabah';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    
    public function jmlNasabahByKelas($id_kelas){
        $this->db->select('*');
        $this->db->from('nasabah');
        $this->db->where('id_kelas',$id_kelas);
        $result = $this->db->count_all_results();
            if($result != null){
                $output = $result;
            }else{
                $output = 0;
            }
        return $output;
    }

    public function getIdNasabah(){
        $this->db->select('*');
        $this->db->from('nasabah');
        return $this->db->get()->result_array();
    }



    public function buatQuery($tabel,$select_column = [],$order_column = [])
    {
        $tabel = strtolower($tabel);
        $kol_induk = 'id_nasabah';
        
        
        $this->db->select($select_column);
        $this->db->from($tabel);
        if(isset($_POST['search']['value']))
        {
            $this->db->like($kol_induk,$_POST['search']['value']);
            $this->db->or_like('nama_'.$tabel,$_POST['search']['value']);
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by($tabel.'.'.$kol_induk, 'DESC');
        }        

        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');    
        
    }

    public function buatDataTables($tabel,$select_column=[],$order_column=[]){
        $this->buatQuery($tabel,$select_column,$order_column);
        if($_POST['length'] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getFilteredData($tabel,$select_column=[],$order_column=[]){
        $this->buatQuery($tabel,$select_column,$order_column);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAllData($tabel){
        $this->db->select('*');
        $this->db->from($tabel);
        return $this->db->count_all_results();
    }


    public function queryCountModular($tabel)
    {
       return $this->db->get($tabel)->num_rows();
       
    }

    public function cekKodeModular($tabel,$kol_id)
    {
        $this->db->select_max($kol_id);
        $query = $this->db->get($tabel); 
       return $query->row_array();
    }

    public function cekId(){
        $tabel = 'nasabah';
    
      //id otomatis     
        $kd_id = 'NSB';
        $kol_id = 'id_nasabah';
     
    
        
        $jumlah_baris = $this->queryCountModular($tabel);        
        
        //jika jumlah baris = 0
        if($jumlah_baris == 0){
            $kodeIDSekarang = $kd_id.'00001';
        }else{
            //cek kode id terakhir
            $hasil = $this->cekKodeModular($tabel,$kol_id);        
            $hasilKode = $hasil[$kol_id];
            
            $urutan = (int) substr($hasilKode, 3, 5);
    
            // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
            $urutan++;

            // membentuk kode barang baru
            // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
            // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
            // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
            
            $kodeIDSekarang = $kd_id . sprintf("%05s", $urutan);        
            
        }

        return $kodeIDSekarang;
    }

    public function tambah($data = [])
    {

        $kodeIDSekarang = $this->cekId();
    

        $data['id_nasabah'] = $kodeIDSekarang;

        
        //insert data ke tabel nasabah
        $this->db->insert('nasabah',$data);
        $status = $this->db->affected_rows();


        if ($status > 0) {
            return 1;
        } else {
            return 0;
        }
       
    }


    public function ubah($data = [])
    {
       
      $tabel = 'nasabah'; 
      $kol_id = 'id_nasabah';   
         
        //update data ke tabel nasabah
        $this->db->where($kol_id, $data[$kol_id]);
        $this->db->update($tabel, $data);     
        $status = $this->db->affected_rows();   

      if ($status > 0) {
            return 1;
        } else {
            return 0;
        }
        
    }

    public function hapus($data = []){
        $tabel = 'nasabah';
        $kol_id = 'id_nasabah';

        $this->db->delete($tabel, [$kol_id => $data[$kol_id]]);
        $status = $this->db->affected_rows();
        if ($status > 0) {
            return 1;
         } else {
            return 0;
         }
    }

   

   
    
}