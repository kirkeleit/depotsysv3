<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Utstyr extends CI_Controller {

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

    public function __construct() {
      parent::__construct();
      if (!isset($_SESSION['BrukerID'])) {
        if ($this->uri->segment(2) != 'login') {
          redirect('utstyr/login');
        }
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
            $this->session->set_userdata('Fornavn', $result['fornavn']);
            redirect('utstyr');
          } else {
            $data['Brukernavn'] = $Brukernavn;
            $data['Feilmelding'] = "Feil brukernavn eller passord!";
            $this->load->view('login',$data);
          }
        }
      } else {
        $this->load->view('login');
      }
    }

    public function logout() {
      $this->session->sess_destroy();
      redirect('utstyr');
    }

    public function index() {
      redirect('utstyr/utstyrsliste');
    }

    public function utstyrsliste() {
      $this->load->model('Utstyr_model');
      $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste();
      $this->template->load('standard','utstyr/liste',$data);
    }

    public function nyttutstyr() {
      $this->load->model('Utstyr_model');
      $ID = $this->Utstyr_model->nyttutstyrid($this->uri->segment(3));
      $Utstyr['UtstyrID'] = $ID;
      $data['Utstyr'] = $this->Utstyr_model->utstyr_lagre(null,$Utstyr);
      redirect('utstyr/utstyr/'.$data['Utstyr']['UtstyrID']);
    }

    public function nyttforbruksmateriell() {
      $this->load->model('Utstyr_model');
      $ID = $this->Utstyr_model->nyttutstyrid($this->uri->segment(3));
      $Utstyr['UtstyrID'] = $ID.'T';
      $data['Utstyr'] = $this->Utstyr_model->utstyr_lagre(null,$Utstyr);
      redirect('utstyr/utstyr/'.$data['Utstyr']['UtstyrID']);
    }

    public function utstyr() {
      $this->load->model('Utstyr_model');
      if ($this->input->post('UtstyrLagre')) {
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
	$Utstyr['Notater'] = $this->input->post('Notater');
	if ($this->input->post('AntallMin')) {
          $Utstyr['AntallMin'] = $this->input->post('AntallMin');
	}
        $this->Utstyr_model->utstyr_lagre($UtstyrID,$Utstyr);
        redirect('utstyr/utstyrsliste');
      } elseif ($this->input->post('UtstyrSlett')) {
        $this->Utstyr_model->utstyr_slett($this->input->post('UtstyrID'));
        redirect('utstyr/utstyrsliste');
      } else {
        $this->load->model('Vedlikehold_model');
	$data['Utstyr'] = $this->Utstyr_model->utstyr_info($this->uri->segment(3));
        $data['Avviksliste'] = $this->Vedlikehold_model->avviksliste(array('FilterUtstyrID' => $data['Utstyr']['UtstyrID']));
	$data['Produsenter'] = $this->Utstyr_model->produsenter();
	$data['Lokasjoner'] = $this->Utstyr_model->lokasjoner();
	$data['Kasser'] = $this->Utstyr_model->kasser();
        $this->template->load('standard','utstyr/utstyr',$data);
      }
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
      if ($this->input->post('UtstyrstypeLagre')) {
        $UtstyrstypeID = $this->input->post('UtstyrstypeID');
        if ($this->input->post('NyUtstyrstypeID')) {
          $Utstyrstype['UtstyrstypeID'] = $this->input->post('NyUtstyrstypeID');
	}
	$Utstyrstype['AnsvarligRolleID'] = $this->input->post('AnsvarligRolleID');
        $Utstyrstype['Beskrivelse'] = $this->input->post('Beskrivelse');
        $Utstyrstype['Notater'] = $this->input->post('Notater');
        $this->Utstyr_model->utstyrstype_lagre($UtstyrstypeID,$Utstyrstype);
        redirect('utstyr/utstyrstyper');
      } elseif ($this->input->post('UtstyrstypeSlett')) {
        $this->Utstyr_model->utstyrstype_slett($this->input->post('UtstyrstypeID'));
        redirect('utstyr/utstyrstyper');
      } else {
        $data['Roller'] = $this->Brukere_model->roller();
        $data['Utstyrstype'] = $this->Utstyr_model->utstyrstype_info($this->uri->segment(3));
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterUtstyrstypeID' => $data['Utstyrstype']['UtstyrstypeID']));
        $this->template->load('standard','utstyr/utstyrstype',$data);
      }
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
      if ($this->input->post('ProdusentLagre')) {
        $ProdusentID = $this->input->post('ProdusentID');
        $Produsent['Navn'] = $this->input->post('Navn');
        $Produsent['Nettsted'] = $this->input->post('Nettsted');
        $Produsent['Notater'] = $this->input->post('Notater');
        $this->Utstyr_model->produsent_lagre($ProdusentID,$Produsent);
        redirect('utstyr/produsenter');
      } elseif ($this->input->post('ProdusentSlett')) {
        $this->Utstyr_model->produsent_slett($this->input->post('ProdusentID'));
        redirect('utstyr/produsenter');
      } else {
        $data['Produsent'] = $this->Utstyr_model->produsent_info($this->uri->segment(3));
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterProdusentID' => $data['Produsent']['ProdusentID']));
        $this->template->load('standard','utstyr/produsent',$data);
      }
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
      if ($this->input->post('LokasjonLagre')) {
        $LokasjonID = $this->input->post('LokasjonID');
        if ($this->input->post('NyLokasjonID')) {
          $Lokasjon['LokasjonID'] = str_replace('+','',$this->input->post('NyLokasjonID'));
        }
        $Lokasjon['Navn'] = $this->input->post('Navn');
        $Lokasjon['Notater'] = $this->input->post('Notater');
        $this->Utstyr_model->lokasjon_lagre($LokasjonID,$Lokasjon);
        redirect('utstyr/lokasjoner');
      } elseif ($this->input->post('LokasjonSlett')) {
        $this->Utstyr_model->lokasjon_slett($this->input->post('LokasjonID'));
        redirect('utstyr/lokasjoner');
      } else {
        $data['Lokasjon'] = $this->Utstyr_model->lokasjon_info($this->uri->segment(3));
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterLokasjonID' => $data['Lokasjon']['LokasjonID']));
        $this->template->load('standard','utstyr/lokasjon',$data);
      }
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
      if ($this->input->post('KasseLagre')) {
        $KasseID = $this->input->post('KasseID');
        if ($this->input->post('NyKasseID')) {
          $Kasse['KasseID'] = str_replace('=','',$this->input->post('NyKasseID'));
        }
	$Kasse['Navn'] = $this->input->post('Navn');
	$Kasse['LokasjonID'] = $this->input->post('LokasjonID');
        $Kasse['Notater'] = $this->input->post('Notater');
        $this->Utstyr_model->kasse_lagre($KasseID,$Kasse);
        redirect('utstyr/kasser');
      } elseif ($this->input->post('KasseSlett')) {
        $this->Utstyr_model->kasse_slett($this->input->post('KasseID'));
        redirect('utstyr/kasser');
      } else {
        $data['Kasse'] = $this->Utstyr_model->kasse_info($this->uri->segment(3));
        $data['Lokasjoner'] = $this->Utstyr_model->lokasjoner();
        $data['Utstyrsliste'] = $this->Utstyr_model->utstyrsliste(array('FilterKasseID' => $data['Kasse']['KasseID']));
        $this->template->load('standard','utstyr/kasse',$data);
      }
    }


    public function avviksliste() {
      $this->load->model('Vedlikehold_model');
      $data['Avviksliste'] = $this->Vedlikehold_model->avviksliste();
      $this->template->load('standard','vedlikehold/avviksliste',$data);
    }

    public function nyttavvik() {
      $this->load->model('Brukere_model');
      $data['UtstyrID'] = $this->input->get('uid');
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
        $data['Avvik'] = $this->Vedlikehold_model->avvik_info($this->uri->segment(3));
        $data['Brukere'] = $this->Brukere_model->brukere();
        $this->template->load('standard','vedlikehold/avvik',$data);
      }
    }

    public function telleliste() {
      $this->load->model('Utstyr_model');
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('TellingLagre')) {
        $y = 0;
        $UtstyrID = $this->input->post('UtstyrID');
	$Antall = $this->input->post('Antall');
	$NyttAntall = $this->input->post('NyttAntall');
	for ($x=0; $x<sizeof($UtstyrID); $x++) {
          if (is_numeric($NyttAntall[$x])) {
            $y++;
            $data['UtstyrID'] = $UtstyrID[$x];
            $data['Antall'] = ($NyttAntall[$x]-$Antall[$x]);
	    $data['Kommentar'] = 'Lageropptelling';
	    $this->Utstyr_model->utstyr_lagerlagre($data);
            unset($data);
	    $data['UtstyrID'] = $UtstyrID[$x];
	    $data['Tilstand'] = 0;
	    $data['Kommentar'] = 'Lageropptelling';
	    $this->Vedlikehold_model->kontroll_lagre($data);
	    unset($data);
          }
	}
	$this->session->set_flashdata('Infomelding',$y.' stk utstyr er nå registrert med ny opptelling.');
      }
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
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('KontrollLagre')) {
        $y1 = 0;
        $y2 = 0;
        $UtstyrID = $this->input->post('UtstyrID');
        $Tilstand = $this->input->post('Tilstand');
	$Kommentar = $this->input->post('Kommentar');
	for ($x=0; $x<sizeof($UtstyrID); $x++) {
          if (is_numeric($Tilstand[$x])) {
            $y1++;
            $data['UtstyrID'] = $UtstyrID[$x];
            $data['Tilstand'] = $Tilstand[$x];
            $data['Kommentar'] = $Kommentar[$x];
            $this->Vedlikehold_model->kontroll_lagre($data);
	    unset($data);
            if ($Tilstand[$x] > 0) {
              $data['UtstyrID'] = $UtstyrID[$x];
	      $data['StatusID'] = 0;
	      $data['Kostnad'] = 0;
	      $data['Beskrivelse'] = $this->Vedlikehold_model->UtstyrTilstand[$Tilstand[$x]].": ".$Kommentar[$x];
	      $AvvikID = $this->Vedlikehold_model->avvik_opprett($data);
	      if ($AvvikID != false) {
                $y2++;
                $this->slack->sendmessage("Avvik *#".$AvvikID."* på utstyret *'-".$data['UtstyrID']."'* er nå registrert med følgende beskrivelse:\n>".$data['Beskrivelse']."\n<".site_url('utstyr/avvik/'.$AvvikID)."|Trykk her> for å åpne avviket.");
	      }
	      unset($data);
            }
	  }
	}
	$this->session->set_flashdata('Infomelding',$y1.' stk utstyr er nå registrert som kontrollert. <b>'.$y2.'</b> avvik ble opprettet.');
      }
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

  }
