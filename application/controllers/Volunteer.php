<?php

class Volunteer extends CI_Controller{

  public function index(){
    $this->load->view('volunteer/volunteer_form');
  }

  public function tambah_volunteer(){
    $this->load->view('volunteer/volunteer_form');
  }

  public function tambah_volunteer_aksi(){
    $this->_rules();

    if($this->form_validation->run() == FALSE){
      $this->tambah_volunteer();
    }
    else{
      $data_a = array(
        'username'    => $this->input->post('username'),
        'name'        => $this->input->post('name'),
        'email'       => $this->input->post('email'),
        'phone'       => $this->input->post('phone'),
        'occupation'  => $this->input->post('occupation'),
        'birthDate'   => $this->input->post('birthDate')
      );

      $data_u = array(
        'username'   => $this->input->post('username'),
        'password'   => $this->input->post('password'),
        'level'      => 'volunteer'
      );

      $this->user_model->insert_data_volunteer($data_a, 'volunteer');
      $this->user_model->insert_data($data_u, 'user');
      $this->session->set_flashdata(
        'pesan',
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>The Volunteer user</strong> successfully Sign Up
          To return to the main page please click <a href="'.base_url().'" class="stretched-link">Home</a>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
      );
      redirect('volunteer');
    }
  }

  public function update_volunteer_aksi(){
    $id  = $this->input->post('id_volunteer');
    $userID  = $this->input->post('userID');

    $data_a = array(
        'name'          => $this->input->post('name'),
        'email'         => $this->input->post('email'),
        'phone'         => $this->input->post('phone'),
        'occupation'    => $this->input->post('occupation'),
        'birthDate'     => $this->input->post('birthDate'),
    );
    $data = array(
        'password'      => $this->input->post('password')
    );

    $where = array('id_volunteer'=>$id);
    $where1 = array('userID'=>$userID);

    $this->user_model->update_data($where1, $data, 'user');
    $this->user_model->update_data_vltr($where, $data_a, 'volunteer');
    $this->session->set_flashdata(
      'pesan',
      '<div class="alert alert-success alert-dismissible fade show" role="alert">
        The profile has been updated
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>'
    );
    redirect('dashboard_vltr/profile');
  
  }

  public function kirim_offer(){

      $data = array(
        'request_id'    => $this->input->post('request_id'),
        'remarks'        => $this->input->post('remarks'),
        'id_volunteer'        => $this->input->post('id_volunteer'),
        'offerDate'        => date('Y-m-d'),
        'offerStatus'        => 'Pending'
        
      );

      $this->request_model->insert_offer($data, 'offer');
      $this->session->set_flashdata(
        'pesan',
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>The offer</strong> successfully sent
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
      );
      redirect('dashboard_vltr/submit_offers');
    
  }

  public function _rules(){
    $this->form_validation->set_rules('username', 'username', 'required|is_unique[user.username]', [
      'required' => 'Username is required!',
      'is_unique'     => 'Username already exists'
    ]);
    $this->form_validation->set_rules('password', 'password', 'required', [
      'required' => 'Password is required!'
    ]);
    $this->form_validation->set_rules('name', 'name', 'required', [
      'required' => 'Name is required!'
    ]);
    $this->form_validation->set_rules('phone', 'phone', 'required', [
      'required' => 'Phone number is required!'
    ]);
    $this->form_validation->set_rules('occupation', 'occupation', 'required', [
      'required' => 'Occupation is required!'
    ]);
    $this->form_validation->set_rules('email', 'email', 'required', [
      'required' => 'Email is required!'
    ]);
    $this->form_validation->set_rules('birthDate', 'birthDate', 'required', [
      'required' => 'Date of Birth is required!'
    ]);
  }


}

?>