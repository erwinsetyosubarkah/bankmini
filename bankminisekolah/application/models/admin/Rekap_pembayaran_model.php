<?php 



class Rekap_pembayaran_model extends CI_Model{


    public function buatQuery($tabel,$select_column = [],$order_column = [])
    {
        $tabel = strtolower($tabel);
        $kol_induk = 'id_transaksi_bankmini';
        
        
        $this->db->select($select_column);
        $this->db->from($tabel);
        if(isset($_POST['search']['value']))
        {
            $this->db->like('transaksi_bankmini.'.$kol_induk,$_POST['search']['value']);
            $this->db->or_like('nasabah.nama_nasabah',$_POST['search']['value']);
            $this->db->or_like('transaksi_bankmini.id_nasabah',$_POST['search']['value']);
            $this->db->or_like('transaksi_bankmini.nama_penarik',$_POST['search']['value']);
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by($tabel.'.'.$kol_induk, 'DESC');
        }        

      
        $this->db->join('nasabah', 'transaksi_bankmini.id_nasabah = nasabah.id_nasabah', 'left');
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


    public function queryAll()
    {
                   
        $tabel = 'transaksi_bankmini';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->join('nasabah', 'transaksi_bankmini.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function totalPembayaranSiswa(){
        $this->db->select_sum('jumlah_pembayaran_siswa');
        $this->db->from('transaksi_bankmini');
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_pembayaran_siswa;
        return $saldo;
    }
    public function totalPenarikanSaldo(){
        $this->db->select_sum('jumlah_penarikan_saldo');
        $this->db->from('transaksi_bankmini');
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_saldo;
        return $saldo;
    }

    public function queryDueTo($data = [])
    {
        $mulai_tanggal = $data['mulai_tanggal'];
        $sampai_tanggal = $data['sampai_tanggal'];
        $tabel = 'transaksi_bankmini';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where('tanggal_transaksi_bankmini >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_bankmini <=', $sampai_tanggal);
        $this->db->join('nasabah', 'transaksi_bankmini.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }


    public function totalPembayaranSiswaByDateTo($mulai_tanggal,$sampai_tanggal){
        $this->db->select_sum('jumlah_pembayaran_siswa');
        $this->db->from('transaksi_bankmini');
        $this->db->where('tanggal_transaksi_bankmini >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_bankmini <=', $sampai_tanggal);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_pembayaran_siswa;
        return $saldo;
    }

    public function totalPenarikanSaldoByDateTo($mulai_tanggal,$sampai_tanggal){
        $this->db->select_sum('jumlah_penarikan_saldo');
        $this->db->from('transaksi_bankmini');
        $this->db->where('tanggal_transaksi_bankmini >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_bankmini <=', $sampai_tanggal);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_saldo;
        return $saldo;
    }

}