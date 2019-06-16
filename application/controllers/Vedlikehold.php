<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Vedlikehold extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    public function index() {
      $this->template->load('standard','depot/oversikt');
    }

    public function kontrolliste() {
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('Lagre')) {
        $Komponenter = $this->input->post('KomponentID');
	$Tilstand = $this->input->post('Tilstand');
        $Kommentar = $this->input->post('Kommentar');
	for ($x=0; $x<sizeof($Komponenter); $x++) {
          if ($Tilstand[$x] != '') {
            $data['KomponentID'] = $Komponenter[$x];
            $data['Tilstand'] = $Tilstand[$x];
	    $data['Kommentar'] = $Kommentar[$x];
	    $this->Vedlikehold_model->kontroll_lagre($data);
            unset($data);
          }
	}
	redirect('vedlikehold/kontrolliste');
      } else {
        if ($this->input->get('filterplassering')) {
          if (substr($this->input->get('filterplassering'),0,1) == '=') {
            $data['Komponenter'] = $this->Vedlikehold_model->kontrolliste(array('FilterKasseID' => substr($this->input->get('filterplassering'),1)));
          } elseif (substr($this->input->get('filterplassering'),0,1) == '+') {
            $data['Komponenter'] = $this->Vedlikehold_model->kontrolliste(array('FilterLokasjonID' => substr($this->input->get('filterplassering'),1)));
          }
	} else {
          $data['Komponenter'] = $this->Vedlikehold_model->kontrolliste();
	}
	$this->load->model('Komponenter_model');
	$data['Lokasjoner'] = $this->Komponenter_model->lokasjoner();
        $data['Kasser'] = $this->Komponenter_model->kasser();
        $this->template->load('standard','vedlikehold/kontrolliste',$data);
      }
    }

  }
