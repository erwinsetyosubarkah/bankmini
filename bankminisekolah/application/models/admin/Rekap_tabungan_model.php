<?php 



class Rekap_tabungan_model extends CI_Model{


    public function buatQuery($tabel,$select_column = [],$order_column = [])
    {
        $tabel = strtolower($tabel);
        $kol_induk = 'id_transaksi_tabungan';
        
        
        $this->db->select($select_column);
        $this->db->from($tabel);
        if(isset($_POST['search']['value']))
        {
            $this->db->like('transaksi_tabungan.'.$kol_induk,$_POST['search']['value']);
            $this->db->or_like('nasabah.nama_nasabah',$_POST['search']['value']);
            $this->db->or_like('transaksi_tabungan.id_nasabah',$_POST['search']['value']);
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by($tabel.'.'.$kol_induk, 'DESC');
        }        

      
        $this->db->join('nasabah', 'transaksi_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');   
        
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

    public function buatQuery2($id_nasabah,$tabel,$select_column = [],$order_column = [])
    {
        $tabel = strtolower($tabel);
        $kol_induk = 'id_transaksi_tabungan';
        
        
        $this->db->select($select_column);
        $this->db->from($tabel);
        $this->db->where("transaksi_tabungan.id_nasabah",$id_nasabah);
        if(isset($_POST['search']['value']))
        {
            $this->db->group_start();
            $this->db->like('transaksi_tabungan.'.$kol_induk,$_POST['search']['value']);
            $this->db->or_like('nasabah.nama_nasabah',$_POST['search']['value']);
            $this->db->or_like('transaksi_tabungan.id_nasabah',$_POST['search']['value']);
            $this->db->group_end();
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by($tabel.'.'.$kol_induk, 'DESC');
        }        

      
        $this->db->join('nasabah', 'transaksi_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left'); 
    }

    public function buatDataTables2($id_nasabah,$tabel,$select_column=[],$order_column=[]){
        $this->buatQuery2($id_nasabah,$tabel,$select_column,$order_column);        
        if($_POST['length'] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getFilteredData2($id_nasabah,$tabel,$select_column=[],$order_column=[]){
        $this->buatQuery2($id_nasabah,$tabel,$select_column,$order_column);     
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAllData2($id_nasabah,$tabel){
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where("transaksi_tabungan.id_nasabah",$id_nasabah);
        return $this->db->count_all_results();
    }


    public function queryAll()
    {
                   
        $tabel = 'transaksi_tabungan';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->join('nasabah', 'transaksi_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function queryAllByNasabah($id_nasabah)
    {
                   
        $tabel = 'transaksi_tabungan';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->join('nasabah', 'transaksi_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $this->db->where("transaksi_tabungan.id_nasabah",$id_nasabah);
        $query = $this->db->get();
       return $query->result();
    }

    public function totalSetoranMasuk(){
        $this->db->select_sum('jumlah_setoran_masuk');
        $this->db->from('transaksi_tabungan');
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_setoran_masuk;
        return $saldo;
    }
    public function totalPenarikanTabungan(){
        $this->db->select_sum('jumlah_penarikan_tabungan');
        $this->db->from('transaksi_tabungan');
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_tabungan;
        return $saldo;
    }

    public function queryDueTo($data = [])
    {
        $mulai_tanggal = $data['mulai_tanggal'];
        $sampai_tanggal = $data['sampai_tanggal'];
        $tabel = 'transaksi_tabungan';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where('tanggal_transaksi_tabungan >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_tabungan <=', $sampai_tanggal);
        $this->db->join('nasabah', 'transaksi_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }


    public function totalSetoranMasukByDateTo($mulai_tanggal,$sampai_tanggal){
        $this->db->select_sum('jumlah_setoran_masuk');
        $this->db->from('transaksi_tabungan');
        $this->db->where('tanggal_transaksi_tabungan >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_tabungan <=', $sampai_tanggal);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_setoran_masuk;
        return $saldo;
    }

    public function totalPenarikanTabunganByDateTo($mulai_tanggal,$sampai_tanggal){
        $this->db->select_sum('jumlah_penarikan_tabungan');
        $this->db->from('transaksi_tabungan');
        $this->db->where('tanggal_transaksi_tabungan >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_tabungan <=', $sampai_tanggal);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_tabungan;
        return $saldo;
    }

}