<?php 



class Penarikan_saldo_model extends CI_Model{

    public function queryById($data = [])
    {
              
        $kol_id = 'id_penarikan_saldo';        
        $tabel = 'penarikan_saldo';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($tabel.'.'.$kol_id,$data['id_penarikan_saldo']);
        $this->db->join('pengguna', 'penarikan_saldo.id_pengguna = pengguna.id_pengguna', 'left');
        $query = $this->db->get();
       return $query->row_array();
    }

    public function queryByDateNow($data = [])
    {
              
        $kol_id = 'tanggal_transaksi_penarikan_saldo';        
        $tabel = 'penarikan_saldo';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($tabel.'.'.$kol_id,$data['tanggal_hari_ini']);
        $this->db->join('pengguna', 'penarikan_saldo.id_pengguna = pengguna.id_pengguna', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function queryAll()
    {
                   
        $tabel = 'penarikan_saldo';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->join('pengguna', 'penarikan_saldo.id_pengguna = pengguna.id_pengguna', 'left');
        $query = $this->db->get();
       return $query->result();
    }

    public function queryDueTo($data = [])
    {
        $mulai_tanggal = $data['mulai_tanggal'];
        $sampai_tanggal = $data['sampai_tanggal'];
        $tabel = 'penarikan_saldo';
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where('tanggal_transaksi_penarikan_saldo >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_penarikan_saldo <=', $sampai_tanggal);
        $this->db->join('pengguna', 'penarikan_saldo.id_pengguna = pengguna.id_pengguna', 'left');
        $query = $this->db->get();
       return $query->result();
    }



    public function buatQuery($tabel,$select_column = [],$order_column = [])
    {
        $tabel = strtolower($tabel);
        $kol_induk = 'id_penarikan_saldo';
        
        
        $this->db->select($select_column);
        $this->db->from($tabel);
        if(isset($_POST['search']['value']))
        {
            $this->db->like('penarikan_saldo.'.$kol_induk,$_POST['search']['value']);
            $this->db->or_like('penarikan_saldo.nama_penarik_saldo',$_POST['search']['value']);
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by($tabel.'.'.$kol_induk, 'DESC');
        }        

        $this->db->join('pengguna', 'penarikan_saldo.id_pengguna = pengguna.id_pengguna', 'left');
 
        
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
        $tabel = 'penarikan_saldo';
    
      //id otomatis     
        $kd_id = 'PNS';
        $kol_id = 'id_penarikan_saldo';
     
    
        
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

    public function cekSaldoSebelumnya(){
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
        $tarik = $result->row()->jumlah_penarikan_saldo;
        if ($tarik == null) {
            $tarik = 0;
        }
        $sisa_saldo = $saldo - $tarik;
        
        return $sisa_saldo;
    }

    public function totalPenarikanSaldoByDateTo($mulai_tanggal,$sampai_tanggal){
        $this->db->select_sum('jumlah_penarikan_saldo');
        $this->db->from('penarikan_saldo');
        $this->db->where('tanggal_transaksi_penarikan_saldo >=', $mulai_tanggal);
        $this->db->where('tanggal_transaksi_penarikan_saldo <=', $sampai_tanggal);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_saldo;
        return $saldo;
    }
    public function totalPenarikanSaldoByDate($date){
        $this->db->select_sum('jumlah_penarikan_saldo');
        $this->db->from('penarikan_saldo');
        $this->db->where('tanggal_transaksi_penarikan_saldo',$date);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_saldo;
        return $saldo;
    }

    public function totalPenarikanSaldoBulanIni($bulan,$tahun){
        $this->db->select_sum('jumlah_penarikan_saldo');
        $this->db->from('penarikan_saldo');
        $this->db->where('MONTH(tanggal_transaksi_penarikan_saldo)',$bulan);
        $this->db->where('YEAR(tanggal_transaksi_penarikan_saldo)',$tahun);
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_saldo;
        return $saldo;
    }

    public function totalPenarikanSaldo(){
        $this->db->select_sum('jumlah_penarikan_saldo');
        $this->db->from('penarikan_saldo');
        $result = $this->db->get();
        $saldo = $result->row()->jumlah_penarikan_saldo;
        return $saldo;
    }

    public function tambah($data = [])
    {

        $kodeIDSekarang = $this->cekId();
    
    
        $data['id_penarikan_saldo'] = $kodeIDSekarang;

        //insert ke tabel transaksi_bankmini
        $data2 = [
            'id_transaksi_bankmini'         => $data['id_penarikan_saldo'],
            'tanggal_transaksi_bankmini'    => $data['tanggal_transaksi_penarikan_saldo'],
            'jumlah_pembayaran_siswa'       => 0,
            'jumlah_penarikan_saldo'        => $data['jumlah_penarikan_saldo'],
            'id_nasabah'                    => '',
            'nama_penarik'                  => $data['nama_penarik_saldo']
        ];
        $this->db->insert('transaksi_bankmini',$data2);

        
        //insert data ke tabel penarikan_saldo
        $this->db->insert('penarikan_saldo',$data);
        $status = $this->db->affected_rows();


        if ($status > 0) {
            return 1;
        } else {
            return 0;
        }
       
    }


    public function ubah($data = [])
    {
       
      $tabel = 'penarikan_saldo'; 
      $kol_id = 'id_penarikan_saldo'; 
      
        //update ke tabel transaksi_bankmini
        $data2 = [
            'id_transaksi_bankmini'         => $data['id_penarikan_saldo'],
            'tanggal_transaksi_bankmini'    => $data['tanggal_transaksi_penarikan_saldo'],
            'jumlah_pembayaran_siswa'       => 0,
            'jumlah_penarikan_saldo'        => $data['jumlah_penarikan_saldo'],
            'id_nasabah'                    => '',
            'nama_penarik'                  => $data['nama_penarik_saldo']
        ];
        $this->db->where('id_transaksi_bankmini', $data[$kol_id]);
        $this->db->update('transaksi_bankmini', $data2);
         
        //update data ke tabel penarikan_saldo
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
        $tabel = 'penarikan_saldo';
        $kol_id = 'id_penarikan_saldo';

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