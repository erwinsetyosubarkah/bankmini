<?php 



class Penarikan_tabungan_model extends CI_Model{

    public function queryById($data = [])
    {
              
        $kol_id = 'id_penarikan_tabungan';        
        $tabel = 'penarikan_tabungan';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($tabel.'.'.$kol_id,$data['id_penarikan_tabungan']);
        $this->db->join('pengguna', 'penarikan_tabungan.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'penarikan_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->row_array();
    }

    public function queryByDateNow($data = [])
    {
              
        $kol_id = 'tanggal_transaksi_penarikan_tabungan';        
        $tabel = 'penarikan_tabungan';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($tabel.'.'.$kol_id,$data['tanggal_hari_ini']);
        $this->db->join('pengguna', 'penarikan_tabungan.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'penarikan_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function queryAll()
    {
                   
        $tabel = 'penarikan_tabungan';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->join('pengguna', 'penarikan_tabungan.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'penarikan_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function queryDueTo($data = [])
    {
        $mulai_tanggal = $data['mulai_tanggal'];
        $sampai_tanggal = $data['sampai_tanggal'];
        $tabel = 'penarikan_tabungan';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where('tanggal_transaksi_penarikan_tabungan >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_penarikan_tabungan <=', $sampai_tanggal);
        $this->db->join('pengguna', 'penarikan_tabungan.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'penarikan_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function jmlSetoranMasukByNasabah($id_nasabah){
        $this->db->select('*');
        $this->db->from('setoran_masuk');
        $this->db->where('id_nasabah',$id_nasabah);
        $result = $this->db->count_all_results();
            if($result != null){
                $output = $result;
            }else{
                $output = 0;
            }
        return $output;
    }


    public function buatQuery($tabel,$select_column = [],$order_column = [])
    {
        $tabel = strtolower($tabel);
        $kol_induk = 'id_penarikan_tabungan';
        
        
        $this->db->select($select_column);
        $this->db->from($tabel);
        if(isset($_POST['search']['value']))
        {
            $this->db->like('penarikan_tabungan.'.$kol_induk,$_POST['search']['value']);
            $this->db->or_like('nasabah.nama_nasabah',$_POST['search']['value']);
            $this->db->or_like('penarikan_tabungan.id_nasabah',$_POST['search']['value']);
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by($tabel.'.'.$kol_induk, 'DESC');
        }        

        $this->db->join('pengguna', 'penarikan_tabungan.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'penarikan_tabungan.id_nasabah = nasabah.id_nasabah', 'left');
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
        $tabel = 'penarikan_tabungan';
    
      //id otomatis     
        $kd_id = 'PNR';
        $kol_id = 'id_penarikan_tabungan';
     
    
        
        $jumlah_baris = $this->queryCountModular($tabel);        
        
        //jika jumlah baris = 0
        if($jumlah_baris == 0){
            $kodeIDSekarang = $kd_id.'00000001';
        }else{
            //cek kode id terakhir
            $hasil = $this->cekKodeModular($tabel,$kol_id);        
            $hasilKode = $hasil[$kol_id];
            
            $urutan = (int) substr($hasilKode, 3, 8);
    
            // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
            $urutan++;

            // membentuk kode barang baru
            // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
            // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
            // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
            
            $kodeIDSekarang = $kd_id . sprintf("%08s", $urutan);        
            
        }

        return $kodeIDSekarang;
    }

    public function cekSaldoSebelumnya($id_nasabah = ""){
        $this->db->select_sum('jumlah_setoran_masuk');
        $this->db->from('setoran_masuk');
        $this->db->where('id_nasabah',$id_nasabah);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_setoran_masuk;
        if ($saldo == null) {
            $saldo = 0;
        }

        $this->db->select_sum('jumlah_penarikan_tabungan');
        $this->db->from('penarikan_tabungan');
        $this->db->where('id_nasabah',$id_nasabah);
        $result = $this->db->get();
        $tarik = $result->row()->jumlah_penarikan_tabungan;
        if ($tarik == null) {
            $tarik = 0;
        }
        $sisa_saldo = $saldo - $tarik;
        
        return $sisa_saldo;
    }

    public function totalPenarikanTabunganByDateTo($mulai_tanggal,$sampai_tanggal){
        $this->db->select_sum('jumlah_penarikan_tabungan');
        $this->db->from('penarikan_tabungan');
        $this->db->where('tanggal_transaksi_penarikan_tabungan >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_penarikan_tabungan <=', $sampai_tanggal);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_tabungan;
        return $saldo;
    }
    public function totalPenarikanTabunganByDate($date){
        $this->db->select_sum('jumlah_penarikan_tabungan');
        $this->db->from('penarikan_tabungan');
        $this->db->where('tanggal_transaksi_penarikan_tabungan',$date);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_tabungan;
        return $saldo;
    }
    public function totalPenarikanTabunganBulanIni($bulan,$tahun){
        $this->db->select_sum('jumlah_penarikan_tabungan');
        $this->db->from('penarikan_tabungan');
        $this->db->where('MONTH(tanggal_transaksi_penarikan_tabungan)',$bulan);
        $this->db->where('YEAR(tanggal_transaksi_penarikan_tabungan)',$tahun);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_tabungan;
        return $saldo;
    }

    public function totalPenarikanTabungan(){
        $this->db->select_sum('jumlah_penarikan_tabungan');
        $this->db->from('penarikan_tabungan');
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_tabungan;
        return $saldo;
    }
    public function totalPenarikanTabunganByNasabah($id_nasabah){
        $this->db->select_sum('jumlah_penarikan_tabungan');
        $this->db->from('penarikan_tabungan');
        $this->db->where('id_nasabah',$id_nasabah);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_tabungan;
        return $saldo;
    }

    public function tambah($data = [])
    {

        $kodeIDSekarang = $this->cekId();
    

        $data['id_penarikan_tabungan'] = $kodeIDSekarang;

        //insert ke tabel transaksi_tabungan
        $data2 = [
            'id_transaksi_tabungan'         => $data['id_penarikan_tabungan'],
            'tanggal_transaksi_tabungan'    => $data['tanggal_transaksi_penarikan_tabungan'],
            'jumlah_setoran_masuk'          => 0,
            'jumlah_penarikan_tabungan'     => $data['jumlah_penarikan_tabungan'],
            'id_nasabah'                    => $data['id_nasabah']
        ];
        $this->db->insert('transaksi_tabungan',$data2);

        
        //insert data ke tabel penarikan_tabungan
        $this->db->insert('penarikan_tabungan',$data);
        $status = $this->db->affected_rows();


        if ($status > 0) {
            return 1;
        } else {
            return 0;
        }
       
    }


    public function ubah($data = [])
    {
       
      $tabel = 'penarikan_tabungan'; 
      $kol_id = 'id_penarikan_tabungan';  
      
        //update ke tabel transaksi_tabungan
        $data2 = [
            'id_transaksi_tabungan'         => $data['id_penarikan_tabungan'],
            'tanggal_transaksi_tabungan'    => $data['tanggal_transaksi_penarikan_tabungan'],
            'jumlah_setoran_masuk'          => 0,
            'jumlah_penarikan_tabungan'     => $data['jumlah_penarikan_tabungan'],
            'id_nasabah'                    => $data['id_nasabah']
        ];
        $this->db->where('id_transaksi_tabungan', $data[$kol_id]);
        $this->db->update('transaksi_tabungan', $data2);
         
        //update data ke tabel penarikan_tabungan
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
        $tabel = 'penarikan_tabungan';
        $kol_id = 'id_penarikan_tabungan';

        $this->db->delete('transaksi_tabungan', ['id_transaksi_tabungan' => $data[$kol_id]]);

        $this->db->delete($tabel, [$kol_id => $data[$kol_id]]);
        $status = $this->db->affected_rows();
        if ($status > 0) {
            return 1;
         } else {
            return 0;
         }
    }

   

   
    
}