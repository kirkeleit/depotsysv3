<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Oppsett extends CI_Controller {

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
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $BrukerID = $this->input->post('BrukerID');
        $data['Fornavn'] = $this->input->post('Fornavn');
        $data['Etternavn'] = $this->input->post('Etternavn');
        $data['Epostadresse'] = $this->input->post('Epostadresse');
	$data['Mobilnummer'] = $this->input->post('Mobilnummer');
	$data['Notater'] = $this->input->post('Notater');
	if ($this->input->post('NyttPassord')) {
          $data['Passord'] = hash('sha256',$this->input->post('NyttPassord'));
	}
	$data['RolleID'] = $this->input->post('RolleID');
	if (!is_numeric($BrukerID)) {
          $BrukerID = $this->Brukere_model->bruker_opprett($data);
          if ($BrukerID != false) {
            $this->depot->NyGUIMelding(0, 'Ny bruker \''.$data['Fornavn'].'\' ble vellykket registrert.');
          }
	} else {
          $BrukerID = $this->Brukere_model->bruker_lagre($BrukerID,$data);
          if ($BrukerID != false) {
            $this->depot->NyGUIMelding(0, 'Bruker \''.$data['Fornavn'].'\' ble vellykket oppdatert.');
          }
	}
	if ($this->input->post('SkjemaLagreLukk')) {
          redirect('oppsett/brukere');
	} else {
          redirect('oppsett/bruker/'.$BrukerID);
	}
      } else {
        $this->load->model('Brukere_model');
	$data['Bruker'] = $this->Brukere_model->bruker_info($this->uri->segment(3));
	$data['Roller'] = $this->Brukere_model->roller();
        $this->template->load('standard','oppsett/bruker',$data);
      }
    }

    public function slettbruker() {
      $this->load->model('Brukere_model');
      $Bruker = $this->Brukere_model->bruker_info($this->input->get('brukerid'));
      if ($this->Brukere_model->bruker_slett($Bruker['BrukerID'])) {
        $this->depot->NyGUIMelding(0, 'Brukeren \''.$Bruker['Fornavn'].'\' er nå vellykket slettet.');
      }
      redirect('oppsett/brukere');
    }

    public function minprofil() {
      $this->load->model('Brukere_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $BrukerID = $this->session->userdata('BrukerID');
        $Bruker['Fornavn'] = $this->input->post('Fornavn');
        $Bruker['Etternavn'] = $this->input->post('Etternavn');
        $Bruker['Epostadresse'] = $this->input->post('Epostadresse');
	$Bruker['Mobilnummer'] = $this->input->post('Mobilnummer');
	if ($this->Brukere_model->bruker_lagre($BrukerID,$Bruker) != false) {
          $this->depot->NyGUIMelding(0, 'Din profil er nå oppdatert!');
	}
	if ($this->input->post('NyttPassord')) {
          if ($this->Brukere_model->sjekkpassord($this->input->post('Epostadresse'),hash('sha256',$this->input->post('Passord')))) {
            $Bruker['Passord'] = hash('sha256',$this->input->post('NyttPassord'));
	    $Bruker['DatoPassordEndret'] = date('Y-m-d H:i:s');
	    if ($this->Brukere_model->bruker_lagre($BrukerID,$Bruker) != false) {
              $this->depot->NyGUIMelding(0, 'Passordet ditt er blitt endret - du må nå logge inn igjen!');
              $this->session->set_userdata('ForceLogout', 1);
	    }
	  } else {
            $this->depot->NyGUIMelding(1, 'Kunne ikke endre passordet. Skriv inn nåværende passord først.');
	  }
        }
	if ($this->input->post('SkjemaLagreLukk')) {
          redirect('utstyr/utstyrsliste');
	} else {
          redirect('oppsett/minprofil');
	}
      } else {
        $this->load->model('Brukere_model');
        $data['Bruker'] = $this->Brukere_model->bruker_info($this->session->userdata('BrukerID'));
        $this->template->load('standard','oppsett/minprofil',$data);
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
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $RolleID = $this->input->post('RolleID');
        $data['Navn'] = $this->input->post('Navn');
	$data['Notater'] = $this->input->post('Notater');
	if (!is_numeric($RolleID)) {
          $RolleID = $this->Brukere_model->rolle_opprett($data);
          if ($RolleID != false) {
            $this->depot->NyGUIMelding(0, 'Ny rolle \''.$data['Navn'].'\' ble vellykket registrert.');
          }
	} else {
          $RolleID = $this->Brukere_model->rolle_lagre($RolleID,$data);
          if ($RolleID != false) {
            $this->depot->NyGUIMelding(0, 'Rolle \''.$data['Navn'].'\' ble vellykket oppdatert.');
          }
	}
	if ($this->input->post('SkjemaLagreLukk')) {
          redirect('oppsett/roller');
	} else {
          redirect('oppsett/rolle/'.$RolleID);
	}
      } else {
        $this->load->model('Brukere_model');
        $data['Rolle'] = $this->Brukere_model->rolle_info($this->uri->segment(3));
        $this->template->load('standard','oppsett/rolle',$data);
      }
    }

    public function slettrolle() {
      $this->load->model('Brukere_model');
      if ($this->Brukere_model->rolle_slett($this->input->get('rolleid'))) {
        $this->depot->NyGUIMelding(0, 'Rollen ble vellykket slettet.');
      }
      redirect('oppsett/roller');
    }


  }
