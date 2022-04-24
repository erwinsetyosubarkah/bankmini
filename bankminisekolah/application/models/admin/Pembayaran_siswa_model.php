<?php 



class Pembayaran_siswa_model extends CI_Model{

    public function queryById($data = [])
    {
              
        $kol_id = 'id_pembayaran_siswa';        
        $tabel = 'pembayaran_siswa';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($tabel.'.'.$kol_id,$data['id_pembayaran_siswa']);
        $this->db->join('jenis_setoran', 'pembayaran_siswa.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'pembayaran_siswa.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'pembayaran_siswa.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->row_array();
    }

    public function queryByDateNow($data = [])
    {
              
        $kol_id = 'tanggal_transaksi_pembayaran_siswa';        
        $tabel = 'pembayaran_siswa';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($tabel.'.'.$kol_id,$data['tanggal_hari_ini']);
        $this->db->join('jenis_setoran', 'pembayaran_siswa.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'pembayaran_siswa.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'pembayaran_siswa.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function queryAll()
    {
                   
        $tabel = 'pembayaran_siswa';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->join('jenis_setoran', 'pembayaran_siswa.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'pembayaran_siswa.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'pembayaran_siswa.id_nasabah = nasabah.id_nasabah', 'left');
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
        $tabel = 'pembayaran_siswa';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where('tanggal_transaksi_pembayaran_siswa >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_pembayaran_siswa <=', $sampai_tanggal);
        $this->db->join('jenis_setoran', 'pembayaran_siswa.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'pembayaran_siswa.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'pembayaran_siswa.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function jmlPembayaranSiswaByNasabah($id_nasabah){
        $this->db->select('*');
        $this->db->from('pembayaran_siswa');
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
        $kol_induk = 'id_pembayaran_siswa';
        
        
        $this->db->select($select_column);
        $this->db->from($tabel);
        if(isset($_POST['search']['value']))
        {
            $this->db->like('pembayaran_siswa.'.$kol_induk,$_POST['search']['value']);
            $this->db->or_like('nasabah.nama_nasabah',$_POST['search']['value']);
            $this->db->or_like('pembayaran_siswa.id_nasabah',$_POST['search']['value']);
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by($tabel.'.'.$kol_induk, 'DESC');
        }        

        $this->db->join('jenis_setoran', 'pembayaran_siswa.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'pembayaran_siswa.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'pembayaran_siswa.id_nasabah = nasabah.id_nasabah', 'left');
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
        $tabel = 'pembayaran_siswa';
    
      //id otomatis     
        $kd_id = 'PMS';
        $kol_id = 'id_pembayaran_siswa';
     
    
        
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

    public function cekSaldoBankmini(){
        $this->db->select_sum('jumlah_pembayaran_siswa');
        $this->db->from('pembayaran_siswa');
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_pembayaran_siswa;
        if ($saldo == null) {
            $saldo = 0;
        }

        $this->db->select_sum('jumlah_penarikan_saldo');
        $this->db->from('penarikan_saldo');
        $result = $this->db->get();
        $penarikan = $result->row()->jumlah_penarikan_saldo;
        if ($penarikan == null) {
            $penarikan = 0;
        }
        
        $sisa_saldo = $saldo - $penarikan;
        return $sisa_saldo;
    }

    public function totalPembayaranSiswaByDateTo($mulai_tanggal,$sampai_tanggal){
        $this->db->select_sum('jumlah_pembayaran_siswa');
        $this->db->from('pembayaran_siswa');
        $this->db->where('tanggal_transaksi_pembayaran_siswa >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_pembayaran_siswa <=', $sampai_tanggal);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_pembayaran_siswa;
        return $saldo;
    }
    public function totalPembayaranSiswaByDate($date){
        $this->db->select_sum('jumlah_pembayaran_siswa');
        $this->db->from('pembayaran_siswa');
        $this->db->where('tanggal_transaksi_pembayaran_siswa',$date);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_pembayaran_siswa;
        return $saldo;
    }

    public function totalPembayaranSiswaBulanIni($bulan,$tahun){
        $this->db->select_sum('jumlah_pembayaran_siswa');
        $this->db->from('pembayaran_siswa');
        $this->db->where('MONTH(tanggal_transaksi_pembayaran_siswa)',$bulan);
        $this->db->where('YEAR(tanggal_transaksi_pembayaran_siswa)',$tahun);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_pembayaran_siswa;
        return $saldo;
    }

    public function totalPembayaranSiswa(){
        $this->db->select_sum('jumlah_pembayaran_siswa');
        $this->db->from('pembayaran_siswa');
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_pembayaran_siswa;
        return $saldo;
    }

    public function tambah($data = [])
    {

        $kodeIDSekarang = $this->cekId();
    

        $data['id_pembayaran_siswa'] = $kodeIDSekarang;

        //insert ke tabel transaksi_bankmini
        $data2 = [
            'id_transaksi_bankmini'         => $data['id_pembayaran_siswa'],
            'tanggal_transaksi_bankmini'    => $data['tanggal_transaksi_pembayaran_siswa'],
            'jumlah_pembayaran_siswa'       => $data['jumlah_pembayaran_siswa'],
            'jumlah_penarikan_saldo'        => 0,
            'id_nasabah'                    => $data['id_nasabah'],
            'nama_penarik'                  => ''
        ];
        $this->db->insert('transaksi_bankmini',$data2);
        
        //insert data ke tabel pembayaran_siswa
        $this->db->insert('pembayaran_siswa',$data);
        $status = $this->db->affected_rows();


        if ($status > 0) {
            return 1;
        } else {
            return 0;
        }
       
    }


    public function ubah($data = [])
    {
       
      $tabel = 'pembayaran_siswa'; 
      $kol_id = 'id_pembayaran_siswa';   

        //ubah ke tabel transaksi_bankmini
        $data2 = [
            'id_transaksi_bankmini'         => $data['id_pembayaran_siswa'],
            'tanggal_transaksi_bankmini'    => $data['tanggal_transaksi_pembayaran_siswa'],
            'jumlah_pembayaran_siswa'       => $data['jumlah_pembayaran_siswa'],
            'jumlah_penarikan_saldo'        => 0,
            'id_nasabah'                    => $data['id_nasabah'],
            'nama_penarik'                  => ''
        ];
        $this->db->where('id_transaksi_bankmini', $data[$kol_id]);
        $this->db->update('transaksi_bankmini', $data2);
         
        //update data ke tabel pembayaran_siswa
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
        $tabel = 'pembayaran_siswa';
        $kol_id = 'id_pembayaran_siswa';

        $this->db->delete('transaksi_bankmini', ['id_transaksi_bankmini' => $data[$kol_id]]);

        $this->db->delete($tabel, [$kol_id => $data[$kol_id]]);
        $status = $this->db->affected_rows();
        if ($status > 0) {
            return 1;
         } else {
            return 0;
         }
    }

   

   
    
}