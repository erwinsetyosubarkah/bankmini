<?php 



class Naik_kelas_model extends CI_Model{

    public function naik()
    {
        //cek ketersediaan kelas berikutnya
        $kelas_tidak_ada = [];
        
        //cek kelas X naik ke kelas XI
        $kelasx = $this->getKelasX();
        
        foreach ($kelasx as $x) {
            $cek = $this->cekNaikKelas('XI',$x['kode_jurusan'],$x['rombel']);
            if($cek < 1){
                $kelas_tidak_ada []= 
                    'XI '.$x['kode_jurusan'].' '.$x['rombel']
                ;
            }
        }

        //cek kelas XI naik ke kelas XII

        $kelasxi = $this->getKelasXI();
        
        foreach ($kelasxi as $xi) {
            $cek = $this->cekNaikKelas('XII',$xi['kode_jurusan'],$xi['rombel']);
            if($cek < 1){
                $kelas_tidak_ada []= 
                    'XII '.$xi['kode_jurusan'].' '.$xi['rombel']
                ;
            }
        }


        $jml_kelas_tidak_ada = count($kelas_tidak_ada);

        if($jml_kelas_tidak_ada == 0){    
                //hapus siswa kelas xii yang lulus
                $kelasxii = $this->getKelasXII();
        
                foreach ($kelasxii as $xii) {
                    $hapus = $this->hapusSiswaLulus($xii['id_nasabah']);                    
                }
                //naikan dari kelas x ke xi
                foreach ($kelasx as $x) {
                    $datax = $this->cariKelas('X',$x['kode_jurusan'],$x['rombel']);
                    $dataxi = $this->cariKelas('XI',$x['kode_jurusan'],$x['rombel']);
                    $id_kelas = $datax['id_kelas'];
                    $id_kelas_next = $dataxi['id_kelas'];
                    $hasil = $this->naikKeKelasSelanjutnya($id_kelas,$id_kelas_next);
                }

                //naikan dari kelas xi ke xii
                foreach ($kelasxi as $xi) {
                    $dataxi = $this->cariKelas('XI',$x['kode_jurusan'],$x['rombel']);
                    $dataxii = $this->cariKelas('XII',$x['kode_jurusan'],$x['rombel']);
                    $id_kelas = $dataxi['id_kelas'];
                    $id_kelas_next = $dataxii['id_kelas'];
                    $hasil = $this->naikKeKelasSelanjutnya($id_kelas,$id_kelas_next);
                }

                    $data = [
                        'status' => 'success',
                        'title' => 'Berhasil',
                        'pesan' => 'Data Kelas Siswa Berhasil di Naikan....!'
                    ];
        }else{

                $txt = "";
                for ($i = 0; $i < $jml_kelas_tidak_ada; $i++) {
                    $txt .=  $kelas_tidak_ada[$i].', ';
                }
                $data = [
                    'status' => 'error',
                    'title'  => 'Gagal',
                    'pesan' => 'Kelas '.$txt.'tidak ada. Silahkan Buat terlebih dahulu'
                ];
        }     

    
        return $data;
    }

    public function cariKelas($tingkat,$kode_jurusan,$rombel){
        $this->db->select('*');
        $this->db->from('kelas');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->where('kelas.tingkat',$tingkat);
        $this->db->where('jurusan.kode_jurusan',$kode_jurusan);
        $this->db->where('kelas.rombel',$rombel);
        return $this->db->get()->row_array();
    }

    public function getKelasX(){
        //ambil data kelas X
        $this->db->select('*');
        $this->db->from('kelas');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->where('kelas.tingkat','X');
        return $this->db->get()->result_array();
    }

    public function getKelasXI(){
        //ambil data kelas XI
        $this->db->select('*');
        $this->db->from('kelas');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->where('kelas.tingkat','XI');
        return $this->db->get()->result_array();
    }

    public function getKelasXII(){
        //ambil data kelas XII
        $this->db->select('*');
        $this->db->from('nasabah');
        $this->db->join('kelas', 'nasabah.id_kelas = kelas.id_kelas', 'left');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->where('kelas.tingkat','XII');
        return $this->db->get()->result_array();
    }

   public function cekNaikKelas($tingkat,$kode_jurusan,$rombel){
        $this->db->select('*');
        $this->db->from('kelas');
        $this->db->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan', 'left');
        $this->db->where('kelas.tingkat',$tingkat);
        $this->db->where('jurusan.kode_jurusan',$kode_jurusan);
        $this->db->where('kelas.rombel',$rombel);
        return $this->db->count_all_results();
   }

   public function hapusSiswaLulus($id_nasabah){
        $this->db->delete('nasabah', ['id_nasabah'=> $id_nasabah]);
        $this->db->delete('pembayaran_siswa', ['id_nasabah'=> $id_nasabah]);
        $this->db->delete('penarikan_tabungan', ['id_nasabah'=> $id_nasabah]);
        $this->db->delete('setoran_masuk', ['id_nasabah'=> $id_nasabah]);
        $this->db->delete('transaksi_bankmini', ['id_nasabah'=> $id_nasabah]);
       return $this->db->delete('transaksi_tabungan', ['id_nasabah'=> $id_nasabah]);
   }

   public function naikKeKelasSelanjutnya($id_kelas,$id_kelas_next){
        $this->db->where('id_kelas', $id_kelas);
        $this->db->update('nasabah', ['id_kelas' => $id_kelas_next]);     
        $status = $this->db->affected_rows();  
        return $status; 
   }

   

   
    
}