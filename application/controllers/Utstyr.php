<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Utstyr extends CI_Controller {

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
      redirect('utstyr/materielliste');
    }

    public function materielliste() {
      $this->load->model('Utstyr_model');
      $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterForbruksmateriell' => 0));
      $this->template->load('standard','utstyr/liste',$data);
    }

    public function forbruksmaterielliste() {
      $this->load->model('Utstyr_model');
      $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterForbruksmateriell' => 1));
      $this->template->load('standard','utstyr/liste',$data);
    }

    public function nyttutstyr() {
      $this->load->model('Utstyr_model');
      $ID = $this->Utstyr_model->nyttutstyrid($this->input->get('kode'));
      if ($this->input->get('forbruk') == 1) {
        $Utstyr['UtstyrID'] = $ID.'T';
      } else {
        $Utstyr['UtstyrID'] = $ID;
      }
      $Utstyr['Beskrivelse'] = $this->input->get('navn');
      $data['Utstyr'] = $this->Utstyr_model->utstyr_lagre(null,$Utstyr);
      redirect('utstyr/utstyr/'.$data['Utstyr']['UtstyrID']);
    }

    public function utstyr() {
      $this->load->model('Utstyr_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $UtstyrID = $this->input->post('UtstyrID');
	$Utstyr['Beskrivelse'] = $this->input->post('Beskrivelse');
	if ($this->input->post('Plassering')) {
          if ($this->input->post('Plassering') == '') {
            $Utstyr['LokasjonID'] = '';
	    $Utstyr['KasseID'] = '';
	  } else {
            if (substr($this->input->post('Plassering'),0,1) == '+') {
              $Utstyr['KasseID'] = '';
	      $Utstyr['LokasjonID'] = substr($this->input->post('Plassering'),1);
	    } elseif (substr($this->input->post('Plassering'),0,1) == '=') {
              $Utstyr['LokasjonID'] = '';
	      $Utstyr['KasseID'] = substr($this->input->post('Plassering'),1);
	    }
	  }
	}
	$Utstyr['ProdusentID'] = $this->input->post('ProdusentID');
	$Utstyr['BatteritypeID'] = $this->input->post('BatteritypeID');
	$Utstyr['BatteriAntall'] = $this->input->post('BatteriAntall');
	$Utstyr['Notater'] = $this->input->post('Notater');
	$Utstyr['StatusID'] = $this->input->post('StatusID');
	if ($this->input->post('AntallMin')) {
          $Utstyr['AntallMin'] = $this->input->post('AntallMin');
	}
	$this->Utstyr_model->utstyr_lagre($UtstyrID,$Utstyr);
	if ($this->input->post('SkjemaLagre')) {
          redirect('utstyr/utstyr/'.$UtstyrID);
	} else {
          redirect('utstyr/utstyrsliste');
	}
      } else {
        $this->load->model('Vedlikehold_model');
	$data['Utstyr'] = $this->Utstyr_model->utstyr_info($this->uri->segment(3));
        $data['Avviksliste'] = $this->Vedlikehold_model->avviksliste(array('FilterUtstyrID' => $data['Utstyr']['UtstyrID']));
	$data['Produsenter'] = $this->Utstyr_model->produsenter();
	$data['Lokasjoner'] = $this->Utstyr_model->lokasjoner();
	$data['Batterityper'] = $this->Utstyr_model->batterityper();
	$data['Kontroller'] = $this->Vedlikehold_model->kontroller($data['Utstyr']['UtstyrID']);
	$data['Lagerendringer'] = $this->Vedlikehold_model->lagerendringer($data['Utstyr']['UtstyrID']);
	$data['Kasser'] = $this->Utstyr_model->kasser();
        $this->template->load('standard','utstyr/utstyr',$data);
      }
    }

    public function slettutstyr() {
      $this->load->model('Utstyr_model');
      $this->Utstyr_model->utstyr_slett($this->input->get('utstyrid'));
      redirect('utstyr/utstyrsliste');
    }


    public function utstyrstyper() {
      $this->load->model('Utstyr_model');
      $data['Utstyrstyper'] = $this->Utstyr_model->utstyrstyper();
      $this->template->load('standard','utstyr/utstyrstyper',$data);
    }

    public function nyutstyrstype() {
      $this->load->model('Brukere_model');
      $data['Utstyrstype'] = null;
      $data['Roller'] = $this->Brukere_model->roller();
      $this->template->load('standard','utstyr/utstyrstype',$data);
    }

    public function utstyrstype() {
      $this->load->model('Utstyr_model');
      $this->load->model('Brukere_model');
      if (($this->input->post('SkjemaLagre')) or ($this->input->post('SkjemaLagreLukk'))) {
        $UtstyrstypeID = $this->input->post('UtstyrstypeID');
        $data['Kode'] = $this->input->post('Kode');
	$data['Navn'] = $this->input->post('Navn');
        $data['AnsvarligRolleID'] = $this->input->post('AnsvarligRolleID');
	$data['KontrollDager'] = $this->input->post('KontrollDager');
	$data['KontrollPunkter'] = $this->input->post('KontrollPunkter');
	$data['Notater'] = $this->input->post('Notater');
	if (is_numeric($UtstyrstypeID)) {
          $UtstyrstypeID = $this->Utstyr_model->utstyrstype_lagre($UtstyrstypeID,$data);
          if ($UtstyrstypeID != false) {
            $this->session->set_flashdata('Infomelding',"Utstyrstype '".$data['Navn']."' ble vellykket lagret.");
	  }
	} else {
          $UtstyrstypeID = $this->Utstyr_model->utstyrstype_opprett($data);
	  if ($ProdusentID != false) {
            $this->session->set_flashdata('Infomelding','Produsenten \''.$data['Navn'].'\' ble vellykktet opprettet.');
	  }
	}
        if ($this->input->post('SkjemaLagre')) {
          redirect('utstyr/utstyrstype/'.$UtstyrstypeID);
        } elseif ($this->input->post('SkjemaLagreLukk')) {
          redirect('utstyr/utstyrstyper');
        }
      } else {
        $data['Roller'] = $this->Brukere_model->roller();
        $data['Utstyrstype'] = $this->Utstyr_model->utstyrstype_info($this->uri->segment(3));
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterUtstyrstype' => $data['Utstyrstype']['Kode']));
        $this->template->load('standard','utstyr/utstyrstype',$data);
      }
    }

    public function slettutstyrstype() {
      $this->load->model('Utstyr_model');
      $Utstyrstype = $this->Utstyr_model->utstyrstype_info($this->input->get('utstyrstypeid'));
      if ($Utstyrstype != null) {
        $this->Utstyr_model->utstyrstype_slett($this->input->get('utstyrstypeid'));
        $this->session->set_flashdata('Infomelding','Utstyrstype \''.$Utstyrstype['Kode'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Utstyrstypen eksisterer ikke. Kunne ikke slette utstyrstype.');
      }
      redirect('utstyr/utstyrstyper');
    }

    public function produsenter() {
      $this->load->model('Utstyr_model');
      $data['Produsenter'] = $this->Utstyr_model->produsenter();
      $this->template->load('standard','utstyr/produsenter',$data);
    }

    public function nyprodusent() {
      $data['Produsent'] = null;
      $this->template->load('standard','utstyr/produsent',$data);
    }

    public function produsent() {
      $this->load->model('Utstyr_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $ProdusentID = $this->input->post('ProdusentID');
        $data['Navn'] = $this->input->post('Navn');
        $data['Nettsted'] = $this->input->post('Nettsted');
	$data['Notater'] = $this->input->post('Notater');
	if (is_numeric($ProdusentID)) {
          $ProdusentID = $this->Utstyr_model->produsent_lagre($ProdusentID,$data);
          if ($ProdusentID != false) {
            $this->session->set_flashdata('Infomelding','Produsenten \''.$data['Navn'].'\' ble vellykktet lagret.');
          }
	} else {
          $ProdusentID = $this->Utstyr_model->produsent_opprett($data);
          if ($ProdusentID != false) {
            $this->session->set_flashdata('Infomelding','Produsenten \''.$data['Navn'].'\' ble vellykktet opprettet.');
          }
	}
	if ($this->input->post('SkjemaLagre')) {
          redirect('utstyr/produsent/'.$ProdusentID);
	} elseif ($this->input->post('SkjemaLagreLukk')) {
          redirect('utstyr/produsenter');
	}
      } else {
        $data['Produsent'] = $this->Utstyr_model->produsent_info($this->uri->segment(3));
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterProdusentID' => $data['Produsent']['ProdusentID']));
        $this->template->load('standard','utstyr/produsent',$data);
      }
    }

    public function slettprodusent() {
      $this->load->model('Utstyr_model');
      $Produsent = $this->Utstyr_model->produsent_info($this->input->get('produsentid'));
      if ($Produsent != null) {
        $this->Utstyr_model->produsent_slett($this->input->get('produsentid'));
        $this->session->set_flashdata('Infomelding','Produsenten \''.$Produsent['Navn'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Produsenten eksisterer ikke. Kunne ikke slette produsent.');
      }
      redirect('utstyr/produsenter');
    }


    public function lokasjoner() {
      $this->load->model('Utstyr_model');
      $data['Lokasjoner'] = $this->Utstyr_model->lokasjoner();
      $this->template->load('standard','utstyr/lokasjoner',$data);
    }

    public function nylokasjon() {
      $data['Lokasjon'] = null;
      $this->template->load('standard','utstyr/lokasjon',$data);
    }

    public function lokasjon() {
      $this->load->model('Utstyr_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $LokasjonID = $this->input->post('LokasjonID');
        $data['Kode'] = str_replace('+','',$this->input->post('Kode'));
        $data['Navn'] = $this->input->post('Navn');
	$data['Notater'] = $this->input->post('Notater');
	if (is_numeric($LokasjonID)) {
          $LokasjonID = $this->Utstyr_model->lokasjon_lagre($LokasjonID,$data);
          if ($LokasjonID != false) {
            $this->session->set_flashdata('Infomelding','Lokasjonen \'+'.$data['Kode'].'\' ble vellykket lagret.');
          }
	} else {
          $LokasjonID = $this->Utstyr_model->lokasjon_opprett($data);
          if ($LokasjonID != false) {
            $this->session->set_flashdata('Infomelding','Lokasjonen \'+'.$data['Kode'].'\' ble vellykket opprettet.');
          }
	}
        if ($this->input->post('SkjemaLagre')) {
          redirect('utstyr/lokasjon/'.$LokasjonID);
        } elseif ($this->input->post('SkjemaLagreLukk')) {
          redirect('utstyr/lokasjoner');
        }
      } else {
        $data['Lokasjon'] = $this->Utstyr_model->lokasjon_info($this->uri->segment(3));
        $data['Kasser'] = $this->Utstyr_model->kasser(array('FilterLokasjonID' => $data['Lokasjon']['LokasjonID']));
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterLokasjonID' => $data['Lokasjon']['LokasjonID']));
        $this->template->load('standard','utstyr/lokasjon',$data);
      }
    }

    public function slettlokasjon() {
      $this->load->model('Utstyr_model');
      $Lokasjon = $this->Utstyr_model->lokasjon_info($this->input->get('lokasjonid'));
      if ($Lokasjon != null) {
        $this->Utstyr_model->lokasjon_slett($this->input->get('lokasjonid'));
        $this->session->set_flashdata('Infomelding','Lokasjon \'+'.$Lokasjon['Kode'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Lokasjon eksisterer ikke. Kunne ikke slette lokasjon.');
      }
      redirect('utstyr/lokasjoner');
    }


    public function kasser() {
      $this->load->model('Utstyr_model');
      $data['Kasser'] = $this->Utstyr_model->kasser();
      $this->template->load('standard','utstyr/kasser',$data);
    }

    public function nykasse() {
      $this->load->model('Utstyr_model');
      $data['Kasse'] = null;
      $data['Lokasjoner'] = $this->Utstyr_model->lokasjoner();
      $this->template->load('standard','utstyr/kasse',$data);
    }

    public function kasse() {
      $this->load->model('Utstyr_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $KasseID = $this->input->post('KasseID');
        $data['Kode'] = $this->input->post('Kode');
	$data['Navn'] = $this->input->post('Navn');
	$data['LokasjonID'] = $this->input->post('LokasjonID');
	$data['Notater'] = $this->input->post('Notater');
	if (is_numeric($KasseID)) {
          $KasseID = $this->Utstyr_model->kasse_lagre($KasseID,$data);
          if ($KasseID != false) {
            $this->session->set_flashdata('Infomelding','Kasse \''.str_pad($data['Kode'],2,'0',STR_PAD_LEFT).'\' ble vellykket lagret.');
          }
	} else {
          $KasseID = $this->Utstyr_model->kasse_opprett($data);
          if ($KasseID != false) {
            $this->session->set_flashdata('Infomelding','Kasse \'='.str_pad($data['Kode'],2,'0',STR_PAD_LEFT).'\' ble vellykket opprettet.');
          }
	}
	if ($KasseID != false) {
          if ($this->input->post('SkjemaLagre')) {
            redirect('utstyr/kasse/'.$KasseID);
          } else {
            redirect('utstyr/kasser');
          }
	}
      } else {
        $data['Kasse'] = $this->Utstyr_model->kasse_info($this->uri->segment(3));
        $data['Lokasjoner'] = $this->Utstyr_model->lokasjoner();
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterKasseID' => $data['Kasse']['KasseID']));
        $this->template->load('standard','utstyr/kasse',$data);
      }
    }

    public function slettkasse() {
      $this->load->model('Utstyr_model');
      $Kasse = $this->Utstyr_model->kasse_info($this->input->get('kasseid'));
      if ($Kasse != null) {
        $this->Utstyr_model->kasse_slett($this->input->get('kasseid'));
        $this->session->set_flashdata('Infomelding','Kassen \'='.$Kasse['Kode'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Kassen eksisterer ikke. Kunne ikke slette kasse.');
      }
      redirect('utstyr/kasser');
    }

    public function batterityper() {
      $this->load->model('Utstyr_model');
      $data['Batterityper'] = $this->Utstyr_model->batterityper();
      $this->template->load('standard','utstyr/batterityper',$data);
    }

    public function nybatteritype() {
      $this->load->model('Utstyr_model');
      $data['Batteritype'] = NULL;
      $this->template->load('standard','utstyr/batteritype',$data);
    }

    public function batteritype() {
      $this->load->model('Utstyr_model');
      $data['Batteritype'] = $this->Utstyr_model->batteritype_info($this->uri->segment(3));
      $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterBatteritypeID' => $data['Batteritype']['BatteritypeID']));
      $this->template->load('standard','utstyr/batteritype',$data);
    }

    public function slettbatteritype() {
      $this->load->model('Utstyr_model');
      $Batteritype = $this->Utstyr_model->batteritype_info($this->input->get('batteritypeid'));
      if ($Batteritype != null) {
        $this->Utstyr_model->batteritype_slett($this->input->get('batteritypeid'));
        $this->session->set_flashdata('Infomelding','Batteritypen \''.$Batteritype['Type'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Batteritypen eksisterer ikke. Kunne ikke slette batteritypen.');
      }
      redirect('utstyr/batterityper');
    }

    public function innholdsliste() {
      $this->load->model('Utstyr_model');
      if (is_numeric($this->input->get('kasseid'))) {
        $data['Kasse'] = $this->Utstyr_model->kasse_info($this->input->get('kasseid'));
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterKasseID' => $this->input->get('kasseid')));
      } elseif ($this->input->get('lokasjonid')) {
        $data['Lokasjon'] = $this->Utstyr_model->lokasjon_info($this->input->get('lokasjonid'));
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterLokasjonID' => $this->input->get('lokasjonid')));
      }
      $this->template->load('utskrift','utstyr/innholdsliste',$data);
    }


    public function avviksliste() {
      $this->load->model('Vedlikehold_model');
      if ($this->input->get('filterutstyrid')) {
        $Filter['FilterUtstyrID'] = $this->input->get('filterutstyrid');
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
      $data['UtstyrID'] = $this->input->get('utstyrid');
      $data['Avvik'] = null;
      $data['Brukere'] = $this->Brukere_model->brukere();
      $this->template->load('standard','vedlikehold/avvik',$data);
    }

    public function avvik() {
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('AvvikLagre')) {
        $data['UtstyrID'] = $this->input->post('UtstyrID');
        $data['BrukerID'] = $this->input->post('BrukerID');
        $data['Beskrivelse'] = $this->input->post('Beskrivelse');
        $data['Kostnad'] = $this->input->post('Kostnad');
        $data['StatusID'] = $this->input->post('StatusID');
        if ($this->input->post('AvvikID')) {
	  $AvvikID = $this->Vedlikehold_model->avvik_lagre($this->input->post('AvvikID'),$data);
	  if ($AvvikID != false) {
            $this->session->set_flashdata('Infomelding','Avvik #'.$AvvikID.' på utstyr \'-'.$data['UtstyrID'].'\' er nå lagret.');
	  }
	} else {
	  $AvvikID = $this->Vedlikehold_model->avvik_opprett($data);
	  if ($AvvikID != false) {
            $this->session->set_flashdata('Infomelding','Avvik #'.$AvvikID.' på utstyr \'-'.$data['UtstyrID'].'\' er nå opprettet!');
            $this->slack->sendmessage("Avvik *#".$AvvikID."* på utstyret *'-".$data['UtstyrID']."'* er nå registrert med følgende beskrivelse:\n>".$data['Beskrivelse']."\n<".site_url('utstyr/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
	  }
	}
	redirect('utstyr/avvik/'.$AvvikID);
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
          $this->session->set_flashdata('Infomelding','Logg er lagt til på avvik #'.$AvvikID.'.');
          $this->slack->sendmessage("Følgende logg er nå lagt til på avvik *#".$AvvikID."*:\n>".$data['Tekst']."\n<".site_url('utstyr/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
          if ($this->input->post('AvvikLukk')) {
            $this->Vedlikehold_model->avvik_lagre($AvvikID,array('StatusID' => 3));
            $this->slack->sendmessage("Avvik *#".$AvvikID."* er nå lukket. <".site_url('utstyr/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
          } else {
            $this->Vedlikehold_model->avvik_lagre($AvvikID,array('StatusID' => 1));
          }
	}
        redirect('utstyr/avvik/'.$AvvikID);
      } elseif ($this->input->post('AvvikSlett')) {
        $AvvikID = $this->Vedlikehold_model->avvik_slett($this->input->post('AvvikID'));
        if ($AvvikID != false) {
          $this->session->set_flashdata('Infomelding','Avvik #'.$AvvikID.' ble vellykket slettet.');
          $this->slack->sendmessage("Avvik *#".$AvvikID."* ble vellykket slettet. <".site_url('utstyr/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
        }
        redirect('utstyr/avviksliste');
      } else {
	      $this->load->model('Brukere_model');
	      $this->load->model('Utstyr_model');
	$data['Avvik'] = $this->Vedlikehold_model->avvik_info($this->uri->segment(3));
	$data['Utstyr'] = $this->Utstyr_model->utstyr_info($data['Avvik']['UtstyrID']);
        $data['Brukere'] = $this->Brukere_model->brukere();
        $this->template->load('standard','vedlikehold/avvik',$data);
      }
    }

    public function utstyrtelling() {
      $this->load->model('Utstyr_model');
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('SkjemaLagre')){
        $data['UtstyrID'] = $this->input->post('UtstyrID');
	$data['Antall'] = ($this->input->post('NyttAntall')-$this->input->post('Antall'));
	$data['EndringTypeID'] = 1;
	if ($this->Vedlikehold_model->lagerendring_lagre($data)) {
          $this->session->set_flashdata('Infomelding','Lagerstatus for \''.$data['UtstyrID'].'\' er nå oppdatert.');
	  redirect('utstyr/utstyr/'.$data['UtstyrID']);
	}
      }
      $data['Utstyr'] = $this->Utstyr_model->utstyr_info($this->input->get('utstyrid'));
      $data['Lagerendringer'] = $this->Vedlikehold_model->lagerendringer($data['Utstyr']['UtstyrID']);
      $this->template->load('standard','vedlikehold/utstyrtelling',$data);
    }

    public function utstyrkontroll() {
      $this->load->model('Utstyr_model');
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('SkjemaLagre')){
        $data['UtstyrID'] = $this->input->post('UtstyrID');
        $data['TilstandID'] = $this->input->post('TilstandID');
        $data['Kommentar'] = $this->input->post('Kommentar');
        if ($this->Vedlikehold_model->kontroll_lagre($data)) {
          $this->session->set_flashdata('Infomelding','Kontroll av \''.$data['UtstyrID'].'\' er nå registrert.');
          if ($data['TilstandID'] > 0) {
            $data2['UtstyrID'] = $data['UtstyrID'];
	    $data2['Beskrivelse'] = $data['Kommentar'];
	    $data2['StatusID'] = 0;
	    $AvvikID = $this->Vedlikehold_model->avvik_registrere($data2);
	    if ($AvvikID != false) {
              $this->slack->sendmessage("Avvik *#".$AvvikID."* på utstyret *'-".$data2['UtstyrID']."'* er nå registrert med følgende beskrivelse:\n>".$data2['Beskrivelse']."\n<".site_url('utstyr/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
	    }
          }
          redirect('utstyr/utstyr/'.$data['UtstyrID']);
        }
      }
      $data['Utstyr'] = $this->Utstyr_model->utstyr_info($this->input->get('utstyrid'));
      $data['Utstyrstype'] = $this->Utstyr_model->utstyrstype_info(substr($data['Utstyr']['UtstyrID'],0,2));
      $data['Kontroller'] = $this->Vedlikehold_model->kontroller($data['Utstyr']['UtstyrID']);
      $data['Tilstander'] = $this->Vedlikehold_model->KontrollTilstand;
      $this->template->load('standard','vedlikehold/utstyrkontroll',$data);
    }

    public function telleliste() {
      $this->load->model('Utstyr_model');
      $Filter = array('FilterForbruksmateriell' => 1);
      if ($this->input->post('FilterKasseID')) {
        $Filter['FilterKasseID'] = $this->input->post('FilterKasseID');
        $data['FilterKasseID'] = $this->input->post('FilterKasseID');
      }
      if ($this->input->post('FilterLokasjonID')) {
        $Filter['FilterLokasjonID'] = $this->input->post('FilterLokasjonID');
        $data['FilterLokasjonID'] = $this->input->post('FilterLokasjonID');
      }
      $data['Kasser'] = $this->Utstyr_model->kasser();
      $data['Lokasjoner'] = $this->Utstyr_model->lokasjoner();
      $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste($Filter);
      $this->template->load('standard','vedlikehold/telleliste',$data);
    }

    public function kontrolliste() {
      $this->load->model('Utstyr_model');
      $data['Kasser'] = $this->Utstyr_model->kasser();
      $data['Lokasjoner'] = $this->Utstyr_model->lokasjoner();
      $Filter = array('FilterForbruksmateriell' => 0);
      if ($this->input->post('FilterKasseID')) {
        $Filter['FilterKasseID'] = $this->input->post('FilterKasseID');
        $data['FilterKasseID'] = $this->input->post('FilterKasseID');
      }
      if ($this->input->post('FilterLokasjonID')) {
        $Filter['FilterLokasjonID'] = $this->input->post('FilterLokasjonID');
        $data['FilterLokasjonID'] = $this->input->post('FilterLokasjonID');
      }
      $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste($Filter);
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
	$this->session->set_flashdata('Infomelding',$y.' stk utstyr er nå oppdatert med ny lagerstatus.');
      }
      $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterForbruksmateriell' => 1));
      $this->template->load('standard','vedlikehold/bestillingsliste',$data);
    }

    public function utstyrssok() {
      $this->load->model('Utstyr_model');
      $Keyword = $this->input->post('Sokestreng');
      $Keyword = str_replace('=','',$Keyword);
      $Keyword = str_replace('+','',$Keyword);
      $Keyword = str_replace('-','',$Keyword);
      echo $Keyword;
      $data['Utstyr'] = $this->Utstyr_model->utstyr_info($Keyword);
      redirect('utstyr/utstyr/'.$data['Utstyr']['UtstyrID']);
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
      if ($this->input->get('aktivitetid')) {
        $data['AktivitetID'] = $this->input->get('aktivitetid');
      }
      $data['Aktiviteter'] = $this->Aktivitet_model->aktiviteter();
      $data['Plukkliste'] = null;
      $data['Brukere'] = $this->Brukere_model->brukere();
      $this->template->load('standard','aktivitet/plukkliste',$data);
    }

    public function plukkliste() {
      $this->load->model('Aktivitet_model');
      $this->load->model('Brukere_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $PlukklisteID = $this->input->post('PlukklisteID');
	$data['Beskrivelse'] = $this->input->post('Beskrivelse');
	$data['AnsvarligBrukerID'] = $this->input->post('AnsvarligBrukerID');
        $data['AktivitetID'] = $this->input->post('AktivitetID');
	if (is_numeric($PlukklisteID)) {
          $PlukklisteID = $this->Aktivitet_model->plukkliste_lagre($PlukklisteID,$data);
          if ($PlukklisteID != false) {
            $this->session->set_flashdata('Infomelding','Plukkliste #'.$PlukklisteID.' ble vellykket lagret.');
          }
        } else {
          $PlukklisteID = $this->Aktivitet_model->plukkliste_opprett($data);
          if ($PlukklisteID != false) {
            $this->session->set_flashdata('Infomelding','Plukkliste #'.$PlukklisteID.' ble vellykket opprettet.');
          }
        }
        if ($PlukklisteID != false) {
          if ($this->input->post('SkjemaLagre')) {
            redirect('utstyr/plukkliste/'.$PlukklisteID);
          } else {
            redirect('utstyr/plukklister');
          }
	}
      } elseif ($this->input->post('PlukklisteUtlevert')) {
        $PlukklisteID = $this->input->post('PlukklisteID');
        $data['StatusID'] = 1;
	$this->Aktivitet_model->plukkliste_lagre($PlukklisteID,$data);
	redirect('utstyr/plukkliste/'.$PlukklisteID);
      } else {
        $data['Plukkliste'] = $this->Aktivitet_model->plukkliste_info($this->uri->segment(3));
	$data['Utstyrsliste'] = $this->Aktivitet_model->utstyrsliste($data['Plukkliste']['PlukklisteID']);
	$data['Aktiviteter'] = $this->Aktivitet_model->aktiviteter();
        $data['Brukere'] = $this->Brukere_model->brukere();
        $this->template->load('standard','aktivitet/plukkliste',$data);
      }
    }

    public function plukklistefjernutstyr() {
      $this->load->model('Aktivitet_model');
      $this->Aktivitet_model->plukkliste_fjernutstyr($this->input->get('plukklisteid'),$this->input->get('utstyrid'));
      redirect('utstyr/utregistrering/'.$this->input->get('plukklisteid'));
    }

    public function utregistrering() {
      $this->load->model('Aktivitet_model');
      if ($this->input->post('UtstyrID')) {
        $PlukklisteID = $this->input->post('PlukklisteID');
        $UtstyrID = $this->input->post('UtstyrID');
        $UtstyrID = str_replace('=','',$UtstyrID);
        $UtstyrID = str_replace('+','',$UtstyrID);
        $UtstyrID = str_replace('-','',$UtstyrID);
        $this->Aktivitet_model->plukkliste_leggtilutstyr($PlukklisteID,$UtstyrID);
      }
      $data['Plukkliste'] = $this->Aktivitet_model->plukkliste_info($this->uri->segment(3));
      $data['Utstyrsliste'] = $this->Aktivitet_model->utstyrsliste($data['Plukkliste']['PlukklisteID']);
      $this->template->load('standard','aktivitet/utregistrering',$data);
    }

    public function innregistrering() {
      $this->load->model('Utstyr_model');
      $this->load->model('Aktivitet_model');
      if ($this->input->post('UtstyrID')) {
	$data['Utstyr'] = $this->Utstyr_model->utstyr_info($this->input->post('UtstyrID'));
	$UtstyrX = $this->Aktivitet_model->utstyrx_info($data['Utstyr']['UtstyrID']);
	if ($UtstyrX != false) {
          $data['Plukkliste'] = $this->Aktivitet_model->plukkliste_info($UtstyrX['PlukklisteID']);
          $this->Aktivitet_model->plukkliste_sjekkinnutstyr($UtstyrX['PlukklisteID'],$UtstyrX['UtstyrID']);
		//$this->session->set_flashdata('Infomelding','Utstyr \'-'.$data['Utstyr']['UtstyrID'].'\' ble vellykktet registrert inn igjen.');
	}
	$this->template->load('standard','aktivitet/innregistrering',$data);
      } else {
        $this->template->load('standard','aktivitet/innregistrering');
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
            $this->session->set_flashdata('Infomelding','Aktivitet #'.$AktivitetID.' '.$data['Navn'].' ble vellykket lagret.');
          }
        } else {
          $AktivitetID = $this->Aktivitet_model->aktivitet_opprett($data);
          if ($AktivitetID != false) {
            $this->session->set_flashdata('Infomelding','Aktivitet #'.$AktivitetID.' '.$data['Navn'].' ble vellykket opprettet.');
          }
        }
        if ($AktivitetID != false) {
          if ($this->input->post('SkjemaLagre')) {
            redirect('utstyr/aktivitet/'.$AktivitetID);
          } else {
            redirect('utstyr/aktiviteter');
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
        $this->session->set_flashdata('Infomelding','Aktivitet #'.$Aktivitet['AktivitetID'].' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Aktiviteten eksisterer ikke. Kunne ikke slette aktiviteten.');
      }
      redirect('utstyr/aktiviteter');
    }

  }
