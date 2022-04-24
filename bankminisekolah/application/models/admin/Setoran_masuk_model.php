<?php 



class Setoran_masuk_model extends CI_Model{

    public function queryById($data = [])
    {
              
        $kol_id = 'id_setoran_masuk';        
        $tabel = 'setoran_masuk';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($tabel.'.'.$kol_id,$data['id_setoran_masuk']);
        $this->db->join('jenis_setoran', 'setoran_masuk.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'setoran_masuk.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'setoran_masuk.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->row_array();
    }


    public function queryByDateNow($data = [])
    {
              
        $kol_id = 'tanggal_transaksi_setoran_masuk';        
        $tabel = 'setoran_masuk';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($tabel.'.'.$kol_id,$data['tanggal_hari_ini']);
        $this->db->join('jenis_setoran', 'setoran_masuk.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'setoran_masuk.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'setoran_masuk.id_nasabah = nasabah.id_nasabah', 'left');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->join('tanda_pengenal', 'nasabah.id_tanda_pengenal = tanda_pengenal.id_tanda_pengenal', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function queryAll()
    {
                   
        $tabel = 'setoran_masuk';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->join('jenis_setoran', 'setoran_masuk.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'setoran_masuk.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'setoran_masuk.id_nasabah = nasabah.id_nasabah', 'left');
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
        $tabel = 'setoran_masuk';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where('tanggal_transaksi_setoran_masuk >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_setoran_masuk <=', $sampai_tanggal);
        $this->db->join('jenis_setoran', 'setoran_masuk.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'setoran_masuk.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'setoran_masuk.id_nasabah = nasabah.id_nasabah', 'left');
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
        $kol_induk = 'id_setoran_masuk';
        
        
        $this->db->select($select_column);
        $this->db->from($tabel);
        if(isset($_POST['search']['value']))
        {
            $this->db->like('setoran_masuk.'.$kol_induk,$_POST['search']['value']);
            $this->db->or_like('nasabah.nama_nasabah',$_POST['search']['value']);
            $this->db->or_like('setoran_masuk.id_nasabah',$_POST['search']['value']);
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by($tabel.'.'.$kol_induk, 'DESC');
        }        

        $this->db->join('jenis_setoran', 'setoran_masuk.id_jenis_setoran = jenis_setoran.id_jenis_setoran', 'left');
        $this->db->join('pengguna', 'setoran_masuk.id_pengguna = pengguna.id_pengguna', 'left');
        $this->db->join('nasabah', 'setoran_masuk.id_nasabah = nasabah.id_nasabah', 'left');
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
        $tabel = 'setoran_masuk';
    
      //id otomatis     
        $kd_id = 'STM';
        $kol_id = 'id_setoran_masuk';
     
    
        
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

    public function totalSetoranMasukByDateTo($mulai_tanggal,$sampai_tanggal){
        $this->db->select_sum('jumlah_setoran_masuk');
        $this->db->from('setoran_masuk');
        $this->db->where('tanggal_transaksi_setoran_masuk >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_setoran_masuk <=', $sampai_tanggal);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_setoran_masuk;
        return $saldo;
    }
    public function totalSetoranMasukByDate($date){
        $this->db->select_sum('jumlah_setoran_masuk');
        $this->db->from('setoran_masuk');
        $this->db->where('tanggal_transaksi_setoran_masuk',$date);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_setoran_masuk;
        return $saldo;
    }
    public function totalSetoranMasukBulanIni($bulan,$tahun){
        $this->db->select_sum('jumlah_setoran_masuk');
        $this->db->from('setoran_masuk');
        $this->db->where('MONTH(tanggal_transaksi_setoran_masuk)',$bulan);
        $this->db->where('YEAR(tanggal_transaksi_setoran_masuk)',$tahun);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_setoran_masuk;
        return $saldo;
    }

    public function totalSetoranMasuk(){
        $this->db->select_sum('jumlah_setoran_masuk');
        $this->db->from('setoran_masuk');
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_setoran_masuk;
        return $saldo;
    }
    public function totalSetoranMasukByNasabah($id_nasabah){
        $this->db->select_sum('jumlah_setoran_masuk');
        $this->db->from('setoran_masuk');
        $this->db->where('id_nasabah',$id_nasabah);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_setoran_masuk;
        return $saldo;
    }

    public function tambah($data = [])
    {

        $kodeIDSekarang = $this->cekId();
    

        $data['id_setoran_masuk'] = $kodeIDSekarang;

        //insert ke tabel transaksi_tabungan
        $data2 = [
            'id_transaksi_tabungan'         => $data['id_setoran_masuk'],
            'tanggal_transaksi_tabungan'    => $data['tanggal_transaksi_setoran_masuk'],
            'jumlah_setoran_masuk'          => $data['jumlah_setoran_masuk'],
            'jumlah_penarikan_tabungan'     => 0,
            'id_nasabah'                    => $data['id_nasabah']
        ];
        $this->db->insert('transaksi_tabungan',$data2);

        //insert data ke tabel setoran_masuk
        $this->db->insert('setoran_masuk',$data);
        $status = $this->db->affected_rows();


        if ($status > 0) {
            return 1;
        } else {
            return 0;
        }
       
    }


    public function ubah($data = [])
    {
       
      $tabel = 'setoran_masuk'; 
      $kol_id = 'id_setoran_masuk';   
         
        //ubah ke tabel transaksi_tabungan
        $data2 = [
            'id_transaksi_tabungan'         => $data['id_setoran_masuk'],
            'tanggal_transaksi_tabungan'    => $data['tanggal_transaksi_setoran_masuk'],
            'jumlah_setoran_masuk'          => $data['jumlah_setoran_masuk'],
            'jumlah_penarikan_tabungan'     => 0,
            'id_nasabah'                    => $data['id_nasabah']
        ];
        $this->db->where('id_transaksi_tabungan', $data[$kol_id]);
        $this->db->update('transaksi_tabungan', $data2);

        //update data ke tabel setoran_masuk
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
        $tabel = 'setoran_masuk';
        $kol_id = 'id_setoran_masuk';

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