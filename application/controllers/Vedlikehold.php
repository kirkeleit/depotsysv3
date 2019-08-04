<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Vedlikehold extends CI_Controller {

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
      redirect('vedlikehold/avviksliste');
    }

    public function avviksliste() {
      $this->load->model('Vedlikehold_model');
      if ($this->input->get('filtermateriellid')) {
        $Filter['FilterMateriellID'] = $this->input->get('filtermateriellid');
      }
      if (isset($Filter)) {
        $data['Avviksliste'] = $this->Vedlikehold_model->avviksliste($Filter);
      } else {
        $data['Avviksliste'] = $this->Vedlikehold_model->avviksliste();
      }
      if (sizeof($data['Avviksliste']) == 1) {
        redirect('utstyr/avvik/'.$data['Avviksliste'][0]['AvvikID']);
      } else {
        $this->template->load('standard','vedlikehold/avviksliste',$data);
      }
    }

    public function nyttavvik() {
      $this->load->model('Brukere_model');
      $data['MateriellID'] = $this->input->get('materiellid');
      $data['Avvik'] = null;
      $data['Materiell'] = null;
      $data['Brukere'] = $this->Brukere_model->brukere();
      $this->template->load('standard','vedlikehold/avvik',$data);
    }

    public function avvik() {
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $data['MateriellID'] = $this->input->post('MateriellID');
        $data['BrukerID'] = $this->input->post('BrukerID');
        $data['Beskrivelse'] = $this->input->post('Beskrivelse');
        $data['Kostnad'] = $this->input->post('Kostnad');
        $data['StatusID'] = $this->input->post('StatusID');
        if ($this->input->post('AvvikID')) {
	  $AvvikID = $this->Vedlikehold_model->avvik_lagre($this->input->post('AvvikID'),$data);
	  if ($AvvikID != false) {
            $this->depot->NyGUIMelding(0,'Avvik #'.$AvvikID.' på materiell \'-'.$data['MateriellID'].'\' er nå lagret.');
	  }
	} else {
	  $AvvikID = $this->Vedlikehold_model->avvik_opprett($data);
	  if ($AvvikID != false) {
            $this->depot->NyGUIMelding(0,'Avvik #'.$AvvikID.' på materiell \'-'.$data['MateriellID'].'\' er nå opprettet!');
            $this->slack->sendmessage("Avvik *#".$AvvikID."* på materiellet *'-".$data['MateriellID']."'* er nå registrert med følgende beskrivelse:\n>".$data['Beskrivelse']."\n<".site_url('vedlikehold/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
	  }
	}
	if ($this->input->post('SkjemaLagreLukk')) {
          redirect('vedlikehold/avviksliste');
	} else {
          redirect('vedlikehold/avvik/'.$AvvikID);
	}
      } elseif ($this->input->post('AvvikLagrelogg')) {
        $data['BrukerID'] = $_SESSION['BrukerID'];
        $data['Tekst'] = $this->input->post('Loggtekst');
        if ($this->input->post('AvvikLukk')) {
          $data['LoggtypeID'] = 1;
	} else {
          $data['LoggtypeID'] = 0;
	}
	$AvvikID = $this->Vedlikehold_model->avvik_logg($this->input->post('AvvikID'),$data);
	if ($AvvikID != false) {
          $this->depot->NyGUIMelding(0,'Logg er lagt til på avvik #'.$AvvikID.'.');
          $this->slack->sendmessage("Følgende logg er nå lagt til på avvik *#".$AvvikID."*:\n>".$data['Tekst']."\n<".site_url('vedlikehold/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
          if ($this->input->post('AvvikLukk')) {
            $this->Vedlikehold_model->avvik_lagre($AvvikID,array('StatusID' => 3));
            $this->slack->sendmessage("Avvik *#".$AvvikID."* er nå lukket. <".site_url('vedlikehold/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
          } else {
            $this->Vedlikehold_model->avvik_lagre($AvvikID,array('StatusID' => 1));
          }
	}
        redirect('vedlikehold/avvik/'.$AvvikID);
      } elseif ($this->input->post('AvvikSlett')) {
        $AvvikID = $this->Vedlikehold_model->avvik_slett($this->input->post('AvvikID'));
        if ($AvvikID != false) {
          $this->depot->NyGUIMelding(0,'Avvik #'.$AvvikID.' ble vellykket slettet.');
          $this->slack->sendmessage("Avvik *#".$AvvikID."* ble vellykket slettet. <".site_url('vedlikehold/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
        }
        redirect('vedlikehold/avviksliste');
      } else {
        $this->load->model('Brukere_model');
        $this->load->model('Materiell_model');
	$data['Avvik'] = $this->Vedlikehold_model->avvik_info($this->uri->segment(3));
	$data['Materiell'] = $this->Materiell_model->materiell_info($data['Avvik']['MateriellID']);
        $data['Brukere'] = $this->Brukere_model->brukere();
        $this->template->load('standard','vedlikehold/avvik',$data);
      }
    }

    public function materielltelling() {
      $this->load->model('Materiell_model');
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('SkjemaLagre')){
        $data['MateriellID'] = $this->input->post('MateriellID');
	$data['Antall'] = ($this->input->post('NyttAntall')-$this->input->post('Antall'));
	$data['EndringTypeID'] = 1;
	if ($this->Vedlikehold_model->lagerendring_lagre($data)) {
          $this->depot->NyGUIMelding(0,'Lagerstatus for \''.$data['MateriellID'].'\' er nå oppdatert.');
	  redirect('materiell/materiell/'.$data['MateriellID']);
	}
      }
      $data['Materiell'] = $this->Materiell_model->materiell_info($this->input->get('materiellid'));
      $data['Lagerendringer'] = $this->Vedlikehold_model->lagerendringer($data['Materiell']['MateriellID']);
      $this->template->load('standard','vedlikehold/materielltelling',$data);
    }

    public function materiellkontroll() {
      $this->load->model('Materiell_model');
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('SkjemaLagre')){
        $data['MateriellID'] = $this->input->post('MateriellID');
        $data['TilstandID'] = $this->input->post('TilstandID');
        $data['Kommentar'] = $this->input->post('Kommentar');
        if ($this->Vedlikehold_model->kontroll_lagre($data)) {
          $this->depot->NyGUIMelding(0,'Kontroll av \''.$data['MateriellID'].'\' er nå registrert.');
          if ($data['TilstandID'] > 0) {
            $data2['MateriellID'] = $data['MateriellID'];
	    $data2['Beskrivelse'] = $data['Kommentar'];
	    $data2['StatusID'] = 0;
	    $AvvikID = $this->Vedlikehold_model->avvik_registrere($data2);
	    if ($AvvikID != false) {
              $this->slack->sendmessage("Avvik *#".$AvvikID."* på utstyret *'-".$data2['MateriellID']."'* er nå registrert med følgende beskrivelse:\n>".$data2['Beskrivelse']."\n<".site_url('vedlikehold/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
	    }
          }
          redirect('materiell/materiell/'.$data['MateriellID']);
        }
      }
      $data['Materiell'] = $this->Materiell_model->materiell_info($this->input->get('materiellid'));
      $data['Materielltype'] = $this->Materiell_model->materielltype_info(substr($data['Materiell']['MateriellID'],0,2));
      $data['Kontroller'] = $this->Vedlikehold_model->kontroller($data['Materiell']['MateriellID']);
      $data['Tilstander'] = $this->Vedlikehold_model->KontrollTilstand;
      $this->template->load('standard','vedlikehold/materiellkontroll',$data);
    }

    public function telleliste() {
      $this->load->model('Materiell_model');
      $Filter = array('FilterForbruksmateriell' => 1);
      if ($this->input->post('FilterKasseID')) {
        $Filter['FilterKasseID'] = $this->input->post('FilterKasseID');
        $data['FilterKasseID'] = $this->input->post('FilterKasseID');
      }
      if ($this->input->post('FilterLokasjonID')) {
        $Filter['FilterLokasjonID'] = $this->input->post('FilterLokasjonID');
        $data['FilterLokasjonID'] = $this->input->post('FilterLokasjonID');
      }
      $data['Kasser'] = $this->Materiell_model->kasser();
      $data['Lokasjoner'] = $this->Materiell_model->lokasjoner();
      $data['Materielliste'] = $this->Materiell_model->materielliste($Filter);
      $this->template->load('standard','vedlikehold/telleliste',$data);
    }

    public function kontrolliste() {
      $this->load->model('Materiell_model');
      $data['Kasser'] = $this->Materiell_model->kasser();
      $data['Lokasjoner'] = $this->Materiell_model->lokasjoner();
      $Filter = array('FilterForbruksmateriell' => 0);
      if ($this->input->post('FilterKasseID')) {
        $Filter['FilterKasseID'] = $this->input->post('FilterKasseID');
        $data['FilterKasseID'] = $this->input->post('FilterKasseID');
      }
      if ($this->input->post('FilterLokasjonID')) {
        $Filter['FilterLokasjonID'] = $this->input->post('FilterLokasjonID');
        $data['FilterLokasjonID'] = $this->input->post('FilterLokasjonID');
      }
      $data['Materielliste'] = $this->Materiell_model->materielliste($Filter);
      $this->template->load('standard','vedlikehold/kontrolliste',$data);
    }

    public function bestillingsliste() {
      $this->load->model('Utstyr_model');
      if ($this->input->post('MottakLagre')) {
        $y = 0;
        $UtstyrID = $this->input->post('UtstyrID');
        $MottattAntall = $this->input->post('MottattAntall');
        for ($x=0; $x<sizeof($UtstyrID); $x++) {
          if (is_numeric($MottattAntall[$x])) {
            $y++;
            $data['UtstyrID'] = $UtstyrID[$x];
            $data['Antall'] = ($MottattAntall[$x]);
            $data['Kommentar'] = 'Varemottak';
            $this->Utstyr_model->utstyr_lagerlagre($data);
	    unset($data);
	  }
	}
	$this->depot->NyGUIMelding(0,$y.' stk utstyr er nå oppdatert med ny lagerstatus.');
      }
      $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterForbruksmateriell' => 1));
      $this->template->load('standard','vedlikehold/bestillingsliste',$data);
    }

  }
