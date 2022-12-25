<?php

class Dashboard_adm extends CI_Controller{

  function __construct(){
    parent::__construct();

    if(!isset($this->session->userdata['username'])){
      $this->session->set_flashdata(
        'pesan',
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Anda belum login!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>'
      );
      redirect('auth');
    }
  }

  public function index(){
    $userID = $this->session->userdata('userID'); 
    $where = 'user.userID ='.'"'.$userID.'"';
    
    $data['adm'] =  $this->user_model->getUserAdministrator($where)->result();
    
    $this->load->view('administrator/dashboard_adm',$data);
  }

  public function profile(){
    $userID = $this->session->userdata('userID'); 
    $where = 'user.userID ='.'"'.$userID.'"';
    
    $data['adm'] =  $this->user_model->getUserAdministrator($where)->result();
    
    $this->load->view('administrator/profile_adm',$data);
  }

  public function submit_request(){
    $userID = $this->session->userdata('userID'); 
    $where = 'user.userID ='.'"'.$userID.'"';
    
    $data['adm'] =  $this->user_model->getUserAdministrator($where)->result();
    
    $this->load->view('administrator/submit_request',$data);
  }

  public function riview_offers(){
    $userID = $this->session->userdata('userID'); 
    $where = 'user.userID ='.'"'.$userID.'"';
    $data['adm'] =  $this->user_model->getUserAdministrator($where)->result();
    foreach($data['adm'] as $rowadm){
      $staffID = $rowadm->staffID ;
    }
    $where1 = 'request.staffID ='.'"'.$staffID.'"';
    $data['request'] =  $this->request_model->tampil_data_byId($where1)->result();
    $this->load->view('administrator/view_request', $data);
  }

  public function offers_detail($id){
    $where = array('request.request_id' => $id);
    $data['request'] =  $this->request_model->get_by_id($where)->result();
    $data['offers'] =  $this->request_model->tampil_data_offers($where)->result();
    $this->load->view('administrator/view_request_detail', $data);
  }

  public function offer_approval($id){
    $where = array('offer.offer_id' => $id);
    $data['offers'] =  $this->request_model->tampil_approval($where)->result();
    $this->load->view('administrator/offer_approval', $data);
  }
}