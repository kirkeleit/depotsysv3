<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Start extends CI_Controller {

    public function __construct() {
      parent::__construct();
      if (!isset($_SESSION['BrukerID'])) {
        if ($this->uri->segment(2) != 'login') {
          redirect('start/login');
        }
      } elseif (isset($_SESSION['ForceLogout'])) {
        redirect('start/logout');
      }
    }

    public function login() {
      if ($this->input->post('DoLogin')) {
        $this->form_validation->set_rules('Brukernavn', 'Brukernavn', 'trim|required');
        $this->form_validation->set_rules('Passord', 'Passord', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('Brukere_model');
          $Brukernavn = $this->input->post('Brukernavn');
          $Passord = hash('SHA256',$this->input->post('Passord'));
          $result = $this->Brukere_model->login($Brukernavn,$Passord);
          if($result) {
            $this->session->set_userdata('BrukerID', $result['BrukerID']);
            $this->session->set_userdata('Fornavn', $result['Fornavn']);
            redirect('start');
          } else {
            $data['Brukernavn'] = $Brukernavn;
            $data['Feilmelding'] = "Feil brukernavn eller passord!";
            $this->load->view('start/login',$data);
          }
        }
      } else {
        $this->load->view('start/login');
      }
    }

    public function logout() {
      $this->session->sess_destroy();
      redirect('start');
    }

    public function index() {
      redirect('start/dashboard');
    }

    public function dashboard() {
      $this->load->model('Utstyr_model');
      $this->load->model('Aktivitet_model');
      $this->load->model('Vedlikehold_model');
      $data['Avviksliste'] = $this->Vedlikehold_model->avviksliste();
      $data['Plukklister'] = $this->Aktivitet_model->plukklister();
      $data['UtstyrslisteIkkeOperativt'] = $this->Utstyr_model->utstyrsliste(array('FilterStatusID' => 0));
      $data['UtstyrslisteKomplett'] = $this->Utstyr_model->utstyrsliste();
      $this->template->load('standard','start/dashboard',$data);
    }

  }
