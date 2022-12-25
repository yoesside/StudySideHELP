<?php

class Request_model extends CI_Model{

  public $table = 'request';
  public $table1 = 'administrator';
  public $table2 = 'schools';
  public $table3 = 'offer';
  public $table4 = 'volunteer';
  public $id    = 'request_id';

  public function tampil_data_byId($where1){
    $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->table1, 'request.staffID = administrator.staffID');
		$this->db->join($this->table2, 'administrator.schoolID = schools.schoolID');
    $this->db->where($where1);
    $this->db->order_by('request.request_id', 'DESC');
    return $this->db->get();
  }

  public function tampil_data_offers($where){
    $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->table3, 'request.request_id = offer.request_id');
		$this->db->join($this->table4, 'offer.id_volunteer = volunteer.id_volunteer');
    $this->db->where($where);
    $this->db->order_by('volunteer.id_volunteer', 'ASC');
    return $this->db->get();
  }

  public function tampil_approval($where){
    $this->db->select('*');
		$this->db->from($this->table);
    $this->db->join($this->table3, 'request.request_id = offer.request_id');
		$this->db->join($this->table4, 'offer.id_volunteer = volunteer.id_volunteer');
    $this->db->where($where);
    return $this->db->get();
  }

  public function tampil_data(){
    $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->table1, 'request.staffID = administrator.staffID');
		$this->db->join($this->table2, 'administrator.schoolID = schools.schoolID');
    $this->db->order_by('schools.schoolName', 'ASC');
    return $this->db->get();
  }

  public function tampil_data_city(){
    $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->table1, 'request.staffID = administrator.staffID');
		$this->db->join($this->table2, 'administrator.schoolID = schools.schoolID');
    $this->db->order_by('schools.city', 'ASC');
    return $this->db->get();
  }
  public function tampil_data_date(){
    $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->table1, 'request.staffID = administrator.staffID');
		$this->db->join($this->table2, 'administrator.schoolID = schools.schoolID');
    $this->db->order_by('request.date', 'ASC');
    return $this->db->get();
  }

  public function insert($data){
    $this->db->insert_batch($this->table, $data);
  }

  public function insert_offer($data, $table3){
    $this->db->insert($table3, $data);
  }

  public function insert_sks($datasks){
    $this->db->insert('jumlah_sks', $datasks);
  }

  public function get_by_id($where){
    $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->table1, 'request.staffID = administrator.staffID');
		$this->db->join($this->table2, 'administrator.schoolID = schools.schoolID');
    $this->db->where($where);
    return $this->db->get();
  }

  public function get_request_id(){
    $this->db->select('*');
		$this->db->from($this->table);
  
    return $this->db->get();
  }

  public function update($id, $data){
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

  public function hapus_data($where, $table){
    $this->db->where($where);
    $this->db->delete($table);
  }
}