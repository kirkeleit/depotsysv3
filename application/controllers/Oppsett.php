<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Oppsett extends CI_Controller {

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
      $this->template->load('standard','oppsett/brukere');
    }

    public function brukere() {
      $this->load->model('Brukere_model');
      $data['Brukere'] = $this->Brukere_model->brukere();
      $this->template->load('standard','oppsett/brukere',$data);
    }

    public function nybruker() {
      $data['Bruker'] = null;
      $this->template->load('standard','oppsett/bruker',$data);
    }

    public function bruker() {
      $this->load->model('Brukere_model');
      if ($this->input->post('BrukerLagre')) {
        $BrukerID = $this->input->post('BrukerID');
        $Bruker['Fornavn'] = $this->input->post('Fornavn');
        $Bruker['Etternavn'] = $this->input->post('Etternavn');
        $Bruker['Epostadresse'] = $this->input->post('Epostadresse');
	$Bruker['Mobilnummer'] = $this->input->post('Mobilnummer');
	$Bruker['Notater'] = $this->input->post('Notater');
	if ($this->input->post('NyttPassord')) {
          $Bruker['Passord'] = hash('sha256',$this->input->post('NyttPassord'));
	}
        $Bruker['RolleID'] = $this->input->post('RolleID');
        $this->Brukere_model->bruker_lagre($BrukerID,$Bruker);
        redirect('oppsett/brukere');
      } elseif ($this->input->post('BrukerSlett')) {
        $this->Brukere_model->bruker_slett($this->input->post('BrukerID'));
        redirect('oppsett/brukere');
      } else {
        $this->load->model('Brukere_model');
	$data['Bruker'] = $this->Brukere_model->bruker_info($this->uri->segment(3));
	$data['Roller'] = $this->Brukere_model->roller();
        $this->template->load('standard','oppsett/bruker',$data);
      }
    }

    public function roller() {
      $this->load->model('Brukere_model');
      $data['Roller'] = $this->Brukere_model->roller();
      $this->template->load('standard','oppsett/roller',$data);
    }

    public function nyrolle() {
      $data['Rolle'] = null;
      $this->template->load('standard','oppsett/rolle',$data);
    }

    public function rolle() {
      $this->load->model('Brukere_model');
      if ($this->input->post('RolleLagre')) {
        $RolleID = $this->input->post('RolleID');
        $Rolle['Navn'] = $this->input->post('Navn');
        $Rolle['Notater'] = $this->input->post('Notater');
        $this->Brukere_model->rolle_lagre($RolleID,$Rolle);
        redirect('oppsett/roller');
      } elseif ($this->input->post('RolleSlett')) {
        $this->Brukere_model->rolle_slett($this->input->post('RolleID'));
        redirect('oppsett/roller');
      } else {
        $this->load->model('Brukere_model');
        $data['Rolle'] = $this->Brukere_model->rolle_info($this->uri->segment(3));
        $this->template->load('standard','oppsett/rolle',$data);
      }
    }


  }
