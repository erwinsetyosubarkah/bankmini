<?php 



class Pengguna_model extends CI_Model{

    public function queryById($data = [])
    {
        $id = $data['id_pengguna'];
      
        
        $this->db->select('*');
        $this->db->from('pengguna');
        $this->db->where('id_pengguna',$id);
       
        $query = $this->db->get();
       return $query->row_array();
    }

    public function jmlSiswaByKelas($id_kelas){
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->where('id_kelas',$id_kelas);
        $result = $this->db->count_all_results();
            if($result != null){
                $output = $result;
            }else{
                $output = 0;
            }
        return $output;
    }

    public function getGuru(){
        $this->db->select('*');
        $this->db->from('guru');
        
        return $this->db->get()->result_array();
    }

    public function cekUser($username=''){
        return $this->db->get_where('pengguna',['username' => $username])->row_array();
    }

    public function setWaktuLogin($data = []){
        date_default_timezone_set('Asia/Jakarta');
        $tgl=date('Y-m-d H:i:s'); 
                       
        $tgl_login = [
                        'tgl_login' => $tgl
                    ];

        $this->db->where('id_pengguna', $data['id_pengguna']);
        $this->db->update('pengguna', $tgl_login); 
        return $this->db->affected_rows();;
    }

    public function buatQuery($tabel,$select_column = [],$order_column = [])
    {
        $tabel = strtolower($tabel);
        $kol_induk = 'id_pengguna';
        
        $this->db->select($select_column);
        $this->db->from($tabel);
        if(isset($_POST['search']['value']))
        {
            $this->db->like($kol_induk,$_POST['search']['value']);
            $this->db->or_like('nama_pengguna',$_POST['search']['value']);
            $this->db->or_like('username',$_POST['search']['value']);
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by($tabel.'.'.$kol_induk, 'DESC');
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
        return $this->db->count_all_results();
    }

    public function cekUsername($username){
        $this->db->select('*');
        $this->db->from('pengguna');
        $this->db->where('username',$username);
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
        $tabel = 'pengguna';
    
      //id otomatis     
        $kd_id = 'USR';
        $kol_id = 'id_pengguna';
     
    
        
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
    
    
    $data['id_pengguna'] = $kodeIDSekarang;
    

      //insert data ke tabel pengguna
      
        $username = $data['username'];
        $password = htmlspecialchars(password_hash($data['id_pengguna'],PASSWORD_DEFAULT));
      

      $data_pengguna = [
            'id_pengguna' => $kodeIDSekarang,
            'nama_pengguna' => $data['nama_pengguna'],
            'username' => $username,
            'password' => $password,
            'status_pengguna' => $data['status_pengguna'],
            'foto_pengguna' => $data['foto_pengguna'],
            'level' => $data['level']
      ];

     //insert data ke tabel pengguna
     $this->db->insert('pengguna',$data_pengguna);
     $status = $this->db->affected_rows();


      if ($status > 0) {
            return 1;
        } else {
            return 0;
        }
       
    }

    public function ubahPassword($password,$tabel,$id_pengguna){
        $data = [
                'password'  => $password
        ];

        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->update($tabel, $data);
        $status = $this->db->affected_rows();
        if ($status > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function ubah($data = [])
    {
       
      $tabel = 'pengguna'; 
      $kol_id = 'id_'.$tabel;  
      

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
        $tabel = 'pengguna';
        $kol_id = 'id_pengguna';

        $this->db->delete($tabel, [$kol_id => $data[$kol_id]]);
        $status = $this->db->affected_rows();
        if ($status > 0) {
            return 1;
         } else {
            return 0;
         }
    }

    public function resetPassword($data = []){
       
      
            $id = $data['id_pengguna'];
  
        //enkripsi password
        $password_baru = password_hash($id,PASSWORD_DEFAULT);
        
            $data1 = [
                'password' => $password_baru
            ];
            
        $this->db->where('id_pengguna', $id);
        $this->db->update('pengguna', $data1);
        $status = $this->db->affected_rows();

      if ($status > 0) {
         return 1;
      } else {
         return 0;
      }
        
    }

   
    
}