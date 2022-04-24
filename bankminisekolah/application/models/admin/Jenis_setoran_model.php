<?php 



class Jenis_setoran_model extends CI_Model{

    public function queryById($data = [])
    {
        $this->db->select('*');
        $this->db->from('jenis_setoran');
        $this->db->where('id_jenis_setoran',$data['id_jenis_setoran']);
        $query = $this->db->get();
       return $query->row_array();
    }

    public function getJenisSetoran(){
        $this->db->select('*');
        $this->db->from('jenis_setoran');
        
        return $this->db->get()->result_array();
    }

    public function getIdJenisSetoran(){
        $this->db->select('*');
        $this->db->from('jenis_setoran');
        $this->db->where_not_in('id_jenis_setoran','STR00001');
        
        return $this->db->get()->result_array();
    }

    public function buatQuery($tabel,$select_column = [],$order_column = [])
    {
        $tabel = strtolower($tabel);

        $this->db->select($select_column);
        $this->db->from($tabel);
        $this->db->where_not_in('id_jenis_setoran','STR00001');
        if(isset($_POST['search']['value']))
        {
            $this->db->like('jenis_setoran',$_POST['search']['value']);
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by('id_jenis_setoran', 'DESC');
        }        
        
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
        $this->db->where_not_in('id_jenis_setoran','STR00001');
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
        $tabel = 'jenis_setoran';
    
      //id otomatis     
        $kd_id = 'STR';
        $kol_id = 'id_jenis_setoran';
     
    
        
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

    public function tambah($data = [],$tabel)
    {

        $kodeIDSekarang = $this->cekId();
    
    
        $data['id_jenis_setoran'] = $kodeIDSekarang;
        
    
          //insert data ke tabel jenis_setoran
          

         $this->db->insert($tabel,$data);
         $status = $this->db->affected_rows();


      if ($status > 0) {
            return 1;
        } else {
            return 0;
        }
       
    }

    public function ubah($data = [],$tabel)
    {
       
      $tabel = strtolower($tabel); 
     
        $this->db->where('id_jenis_setoran', $data['id_jenis_setoran']);
        $this->db->update($tabel, $data);
        $status = $this->db->affected_rows();        

        return $status;
       
    }

    public function hapus($data = []){
        $this->db->delete('jenis_setoran', $data);
        $status = $this->db->affected_rows();
        if ($status > 0) {
            return 1;
         } else {
            return 0;
         }
    }

}