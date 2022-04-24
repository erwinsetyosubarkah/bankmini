<?php 



class Pengaturan_model extends CI_Model{
    public function getPengaturanById()
    {
       return $this->db->get_where('pengaturan',['id' => 1])->row_array();
    }

    public function query()
    {
       return $this->db->get_where('pengaturan',['id' => 1])->row_array();
    }

    public function ubah($data = [])
    {
      $this->db->where('id', 1);
      $this->db->update('pengaturan', $data);
      $status = $this->db->affected_rows();

      if ($status > 0) {
         return 1;
      } else {
         return 0;
      }
    }
}