<?php

class School extends CI_Controller{

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
    $data['kelas'] = $this->school_model->tampil_data('kelas')->result();
    $this->load->view('templates_administrator/header');
    $this->load->view('templates_administrator/sidebar');
    $this->load->view('administrator/kelas',$data);
    $this->load->view('templates_administrator/footer');
  }

  public function tambah_school(){
    $this->load->view('administrator/school_form');
  }
  public function submit_request(){
    $userID = $this->session->userdata('userID'); 
    $where = 'user.userID ='.'"'.$userID.'"';
    
    $data['adm'] =  $this->user_model->getUserAdministrator($where)->result();
    
    $this->load->view('administrator/submit_request',$data);
  }

  public function tambah_school_aksi(){
    $this->_rules();

    if($this->form_validation->run() == FALSE){
      $this->tambah_school();
    }
    else{
      $schoolName = $this->input->post('schoolName');
      $address = $this->input->post('address');
      $city = $this->input->post('city');

      $data = array(
        'schoolName' => $schoolName,
        'address' => $address,
        'city' => $city
      );

      $this->school_model->insert_data($data, 'schools');
      $this->session->set_flashdata(
        'pesan',
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
          The School Data successfully added
          To return to the main page please click <a href="'.base_url().'" class="stretched-link">Home</a>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>'
      );
      redirect('school/tambah_school');
    }
  }
  public function request_aksi(){
    
      $staffID = $this->input->post('staffID');
      $description = $this->input->post('description');
      $date = $this->input->post('date');
      $time = $this->input->post('time');
      $studentLevel = $this->input->post('studentLevel');
      $numStudents = $this->input->post('numStudents');
      $pc = $this->input->post('pc');
      $mobileDevice = $this->input->post('mobileDevice');
      $network = $this->input->post('network');

      $data = array(
        'description' => $description,
        'date' => $date,
        'time' => $time,
        'studentLevel' => $studentLevel,
        'numStudents' => $numStudents,
        'pc' => $pc,
        'mobileDevice' => $mobileDevice,
        'network' => $network,
        'staffID' => $staffID,
        'status' => 'Pending'
      );

      $this->school_model->insert_data_request($data, 'request');
      $this->session->set_flashdata(
        'pesan',
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
          The Offer Request successfully sent
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>'
      );
      redirect('dashboard_adm/submit_request');
  }

  public function accepted_offer(){
    
      $offer_id = $this->input->post('offer_id');
      $request_id = $this->input->post('request_id');

      $data = array(
        'offerStatus' => 'Finish',
      );
      
      $data_req = array(
        'status' => 'Finish',
      );
  
      $where = array(
        'offer_id' => $offer_id
      );

      $where_req = array(
        'request_id' => $request_id
      );

      $this->school_model->update_statusOffer($where, $data, 'offer');
      $this->school_model->update_statusRequest($where_req, $data_req, 'request');
      $this->session->set_flashdata(
        'pesan',
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
          The offer has accepted.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
      );
      redirect('dashboard_adm/offer_approval/'.$offer_id);
  }
  public function closed_offer(){
      $request_id = $this->input->post('request_id');

      $data = array(
        'status' => 'Closed',
      );
  
      $where = array(
        'request_id' => $request_id
      );

      $this->school_model->closed_offer($where, $data, 'request');
      $this->session->set_flashdata(
        'pesan',
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
          The offer successfully closed
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
      );
      redirect('dashboard_adm/riview_offers');
  }

  public function _rules(){
    $this->form_validation->set_rules('schoolName', 'schoolName', 'required', [
      'required' => 'Nama Sekolah wajib diisi!'
    ]);
    $this->form_validation->set_rules('address', 'address', 'required', [
      'required' => 'Address wajib diisi'
    ]);
    $this->form_validation->set_rules('city', 'city', 'required', [
      'required' => 'City wajib diisi'
    ]);
  }

  public function detail($kode){
    $data['detail'] = $this->matakuliah_model->matkuldetail($kode)->result();
    $this->load->view('templates_administrator/header');
    $this->load->view('templates_administrator/sidebar');
    $this->load->view('administrator/matakuliah_detail',$data);
    $this->load->view('templates_administrator/footer');
  }

  public function update($id){
    $data['kelas'] = $this->school_model->ambil_id_kelas($id);

    $this->load->view('templates_administrator/header');
    $this->load->view('templates_administrator/sidebar');
    $this->load->view('administrator/kelas_update',$data);
    $this->load->view('templates_administrator/footer');
  }

  public function delete($id){
    $where = array('id_kelas' => $id);
    $this->school_model->hapus_data($where, 'kelas');
    $this->session->set_flashdata(
      'pesan',
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Data matakuliah berhasil dihapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>'
    );
    redirect('kelas');
  }
}