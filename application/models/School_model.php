<?php

class School_model extends CI_Model{
  public $table = 'schools';
  public $table1 = 'request';
  public $schoolID    = 'schoolID';
  public $order = 'DESC';

  public function tampil_data($table){
    $this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('schoolID ', $this->order);
		return $this->db->get();
  }

  public function insert_data($data, $table){
    $this->db->insert($table, $data);
  }

  public function insert_data_request($data, $table1){
    $this->db->insert($table1, $data);
  }
  
  public function ambil_id_kelas($id){
    $result = $this->db->where('id_kelas', $id)->get($this->table);

    if($result->num_rows() > 0){
      return $result->result();
    }
    else{
      return false;
    }
  }

  public function update_data($where, $data, $table){
    $this->db->where($where);
    $this->db->update($table, $data);
  }

  public function hapus_data($where, $table){
    $this->db->where($where);
    $this->db->delete($table);
  }

  public function get_by_id($id){
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }
}