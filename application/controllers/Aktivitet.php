<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Aktivitet extends CI_Controller {

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
      redirect('aktivitet/plukklister');
    }

    public function plukklister() {
      $this->load->model('Aktivitet_model');
      $data['Plukklister'] = $this->Aktivitet_model->plukklister();
      $this->template->load('standard','aktivitet/plukklister',$data);
    }

    public function mineplukklister() {
      $this->load->model('Aktivitet_model');
      $data['Plukklister'] = $this->Aktivitet_model->plukklister(array('FilterAnsvarligBrukerID' => $this->session->userdata('BrukerID')));
      $this->template->load('standard','aktivitet/plukklister',$data);
    }

    public function nyplukkliste() {
      $this->load->model('Brukere_model');
      $this->load->model('Aktivitet_model');
      $data['Aktiviteter'] = $this->Aktivitet_model->aktiviteter();
      $data['Plukkliste'] = array('PlukklisteID' => '',
                                  'AktivitetID' => 0,
				  'AnsvarligBrukerID' => $this->session->userdata('BrukerID'),
				  'Navn' => 'Plukkliste '.date('d.m.Y'),
				  'Notater' => '',
				  'StatusID' => 0,
				  'Status' => '<ny>');
      if ($this->input->get('aktivitetid')) {
        $data['Plukkliste']['AktivitetID'] = $this->input->get('aktivitetid');
      }
      $data['Brukere'] = $this->Brukere_model->brukere();
      $this->template->load('standard','aktivitet/plukkliste',$data);
    }

    public function plukkliste() {
      $this->load->model('Aktivitet_model');
      $this->load->model('Brukere_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $PlukklisteID = $this->input->post('PlukklisteID');
	$data['Navn'] = $this->input->post('Navn');
	$data['AnsvarligBrukerID'] = $this->input->post('AnsvarligBrukerID');
	$data['AktivitetID'] = $this->input->post('AktivitetID');
	$data['PlukklisteTypeID'] = $this->input->post('PlukklisteTypeID');
	if (is_numeric($PlukklisteID)) {
          $PlukklisteID = $this->Aktivitet_model->plukkliste_lagre($PlukklisteID,$data);
          if ($PlukklisteID != false) {
            $this->depot->NyGUIMelding(0,'Plukkliste #'.$PlukklisteID.' ble vellykket lagret.');
          }
        } else {
          $PlukklisteID = $this->Aktivitet_model->plukkliste_opprett($data);
          if ($PlukklisteID != false) {
            $this->depot->NyGUIMelding(0, 'Plukkliste #'.$PlukklisteID.' ble vellykket opprettet.');
          }
        }
        if ($PlukklisteID != false) {
          if ($this->input->post('SkjemaLagre')) {
            redirect('aktivitet/plukkliste/'.$PlukklisteID);
          } else {
            redirect('aktivitet/plukklister');
          }
	}
      } elseif ($this->input->post('PlukklisteUtlevert')) {
        $data['StatusID'] = 1;
	$PlukklisteID = $this->input->post('PlukklisteID');
	if ($this->Aktivitet_model->plukkliste_lagre($PlukklisteID,$data) != false) {
          $this->depot->NyGUIMelding(0, 'Plukkliste #'.$PlukklisteID.' er nå satt til utlevert.');
	}
	$this->depot->SendPlukklisteEpost($this->Aktivitet_model->plukkliste_info($PlukklisteID),$this->Aktivitet_model->materielliste($PlukklisteID));
	redirect('aktivitet/plukkliste/'.$PlukklisteID);
      } elseif ($this->input->post('FjernMateriell')) {
        $MateriellID = $this->input->post('FjernMateriell');
        $PlukklisteID = $this->input->post('PlukklisteID');
        $this->Aktivitet_model->plukkliste_fjernmateriell($PlukklisteID,$MateriellID);
        redirect('aktivitet/plukkliste/'.$PlukklisteID);
      } elseif ($this->input->post('RegistrerInnMateriell')) {
        $MateriellID = $this->input->post('RegistrerInnMateriell');
        $PlukklisteID = $this->input->post('PlukklisteID');
        $this->Aktivitet_model->plukkliste_sjekkinnmateriell($PlukklisteID,$MateriellID);
        redirect('aktivitet/plukkliste/'.$PlukklisteID);
      } else {
        $data['Plukkliste'] = $this->Aktivitet_model->plukkliste_info($this->uri->segment(3));
	$data['Materielliste'] = $this->Aktivitet_model->materielliste($data['Plukkliste']['PlukklisteID']);
	$data['Aktiviteter'] = $this->Aktivitet_model->aktiviteter();
        $data['Brukere'] = $this->Brukere_model->brukere();
        $this->template->load('standard','aktivitet/plukkliste',$data);
      }
    }

    public function plukkliste_leggtilmateriell() {
	    $this->load->model('Aktivitet_model');
      if ($this->input->post('MateriellID')) {
        $PlukklisteID = $this->input->post('PlukklisteID');
        $MateriellID = $this->input->post('MateriellID');
        $MateriellID = str_replace('=','',$MateriellID);
        $MateriellID = str_replace('+','',$MateriellID);
        $MateriellID = str_replace('-','',$MateriellID);
        if ($this->Aktivitet_model->plukkliste_leggtilmateriell($PlukklisteID,$MateriellID)) {
          $this->depot->NyGUIMelding(0, 'Materiell \'-'.$MateriellID.'\' ble vellykket lagt til plukklisten.');
        } else {
          $this->depot->NyGUIMelding(1, 'En feil oppstod med å legge til materiell \''.$MateriellID.'\' til på plukklisten, eller materiellet er ikke registrert.');
        }
	redirect('aktivitet/plukkliste/'.$PlukklisteID);
      }
    }

    public function aktiviteter() {
      $this->load->model('Aktivitet_model');
      $data['Aktiviteter'] = $this->Aktivitet_model->aktiviteter();
      $this->template->load('standard','aktivitet/aktiviteter',$data);
    }

    public function nyaktivitet() {
      $data['Aktivitet'] = null;
      $this->template->load('standard','aktivitet/aktivitet',$data);
    }

    public function aktivitet() {
      $this->load->model('Aktivitet_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $AktivitetID = $this->input->post('AktivitetID');
        $data['Navn'] = $this->input->post('Navn');
        $data['Notater'] = $this->input->post('Notater');
        if (is_numeric($AktivitetID)) {
          $AktivitetID = $this->Aktivitet_model->aktivitet_lagre($AktivitetID,$data);
          if ($AktivitetID != false) {
            $this->depot->NyGUIMelding(0,'Aktivitet #'.$AktivitetID.' '.$data['Navn'].' ble vellykket lagret.');
          }
        } else {
          $AktivitetID = $this->Aktivitet_model->aktivitet_opprett($data);
          if ($AktivitetID != false) {
            $this->depot->NyGUIMelding(0,'Aktivitet #'.$AktivitetID.' '.$data['Navn'].' ble vellykket opprettet.');
          }
        }
        if ($AktivitetID != false) {
          if ($this->input->post('SkjemaLagre')) {
            redirect('aktivitet/aktivitet/'.$AktivitetID);
          } else {
            redirect('aktivitet/aktiviteter');
          }
        }
      } else {
        $data['Aktivitet'] = $this->Aktivitet_model->aktivitet_info($this->uri->segment(3));
        $data['Plukklister'] = $this->Aktivitet_model->plukklister(array('FilterAktivitetID' => $data['Aktivitet']['AktivitetID']));
        $this->template->load('standard','aktivitet/aktivitet',$data);
      }
    }

    public function slettaktivitet() {
      $this->load->model('Aktivitet_model');
      $Aktivitet = $this->Aktivitet_model->aktivitet_info($this->input->get('aktivitetid'));
      if ($Aktivitet != null) {
        $this->Aktivitet_model->aktivitet_slett($Aktivitet['AktivitetID']);
        $this->depot->NyGUIMelding(0,'Aktivitet #'.$Aktivitet['AktivitetID'].' ble vellykktet slettet.');
      } else {
        $this->depot->NyGUIMelding(0,'Aktiviteten eksisterer ikke. Kunne ikke slette aktiviteten.');
      }
      redirect('aktivitet/aktiviteter');
    }

  }
