<?php 



class Nasabah_tidak_aktif_model extends CI_Model{


    public function queryAll()
    {      
        $tabel = 'nasabah';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where('nasabah.saldo_nasabah',0);
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
        return $query->result();
    }

   
    public function buatQuery($tabel,$select_column = [],$order_column = [])
    {
        $tabel = strtolower($tabel);
        $kol_induk = 'id_nasabah';
        
        
        $this->db->select($select_column);
        $this->db->from($tabel);        
        $this->db->where('nasabah.saldo_nasabah',0);
        if(isset($_POST['search']['value']))
        {
            $this->db->group_start();
            $this->db->like($kol_induk,$_POST['search']['value']);
            $this->db->or_like('nama_'.$tabel,$_POST['search']['value']);
            $this->db->group_end();
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
        $this->db->where('nasabah.saldo_nasabah',0);
        return $this->db->count_all_results();
    }


   

   
    
}