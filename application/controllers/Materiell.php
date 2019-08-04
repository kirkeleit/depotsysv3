<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Materiell extends CI_Controller {

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
      redirect('materiell/materielliste');
    }

    public function materielliste() {
      $this->load->model('Materiell_model');
      $data['Materielliste'] = $this->Materiell_model->materielliste();
      $this->template->load('standard','materiell/materielliste',$data);
    }

    public function nyttmateriell() {
      $this->load->model('Materiell_model');
      $ID = $this->Materiell_model->nyttmateriellid($this->input->get('kode'));
      if ($this->input->get('forbruk') == 1) {
        $Materiell['MateriellID'] = $ID.'T';
      } else {
        $Materiell['MateriellID'] = $ID;
      }
      $Materiell['Beskrivelse'] = $this->input->get('navn');
      $data['Materiell'] = $this->Materiell_model->materiell_lagre(null,$Materiell);
      redirect('materiell/materiell/'.$data['Materiell']['MateriellID']);
    }

    public function materiell() {
      $this->load->model('Materiell_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $MateriellID = $this->input->post('MateriellID');
	$Materiell['Beskrivelse'] = $this->input->post('Beskrivelse');
	if ($this->input->post('Plassering')) {
          if ($this->input->post('Plassering') == '') {
            $Materiell['LokasjonID'] = '';
	    $Materiell['KasseID'] = '';
	  } else {
            if (substr($this->input->post('Plassering'),0,1) == '+') {
              $Materiell['KasseID'] = '';
	      $Materiell['LokasjonID'] = substr($this->input->post('Plassering'),1);
	    } elseif (substr($this->input->post('Plassering'),0,1) == '=') {
              $Materiell['LokasjonID'] = '';
	      $Materiell['KasseID'] = substr($this->input->post('Plassering'),1);
	    }
	  }
	}
	$Materiell['ProdusentID'] = $this->input->post('ProdusentID');
	$Materiell['BatteritypeID'] = $this->input->post('BatteritypeID');
	$Materiell['BatteriAntall'] = $this->input->post('BatteriAntall');
	$Materiell['Notater'] = $this->input->post('Notater');
	$Materiell['StatusID'] = $this->input->post('StatusID');
	if ($this->input->post('AntallMin')) {
          $Materiell['AntallMin'] = $this->input->post('AntallMin');
	}
	$this->Materiell_model->materiell_lagre($MateriellID,$Materiell);
	if ($this->input->post('SkjemaLagre')) {
          redirect('materiell/materiell/'.$MateriellID);
	} else {
          redirect('materiell/materielliste');
	}
      } else {
        $this->load->model('Vedlikehold_model');
	$data['Materiell'] = $this->Materiell_model->materiell_info($this->uri->segment(3));
        $data['Avviksliste'] = $this->Vedlikehold_model->avviksliste(array('FilterMateriellID' => $data['Materiell']['MateriellID']));
	$data['Produsenter'] = $this->Materiell_model->produsenter();
	$data['Lokasjoner'] = $this->Materiell_model->lokasjoner();
	$data['Batterityper'] = $this->Materiell_model->batterityper();
	$data['Kontroller'] = $this->Vedlikehold_model->kontroller($data['Materiell']['MateriellID']);
	$data['Lagerendringer'] = $this->Vedlikehold_model->lagerendringer($data['Materiell']['MateriellID']);
	$data['Kasser'] = $this->Materiell_model->kasser();
        $this->template->load('standard','materiell/materiell',$data);
      }
    }

    public function slettmateriell() {
      $this->load->model('Materiell_model');
      $this->Materiell_model->materiell_slett($this->input->get('materiellid'));
      redirect('materiell/materielliste');
    }


    public function materielltyper() {
      $this->load->model('Materiell_model');
      $data['Materielltyper'] = $this->Materiell_model->materielltyper();
      $this->template->load('standard','materiell/materielltyper',$data);
    }

    public function nymaterielltype() {
      $this->load->model('Brukere_model');
      $data['Materielltype'] = null;
      $data['Roller'] = $this->Brukere_model->roller();
      $this->template->load('standard','materiell/materielltype',$data);
    }

    public function materielltype() {
      $this->load->model('Materiell_model');
      $this->load->model('Brukere_model');
      if (($this->input->post('SkjemaLagre')) or ($this->input->post('SkjemaLagreLukk'))) {
        $MaterielltypeID = $this->input->post('MaterielltypeID');
        $data['Kode'] = $this->input->post('Kode');
	$data['Navn'] = $this->input->post('Navn');
        $data['AnsvarligRolleID'] = $this->input->post('AnsvarligRolleID');
	$data['KontrollDager'] = $this->input->post('KontrollDager');
	$data['KontrollPunkter'] = $this->input->post('KontrollPunkter');
	$data['Notater'] = $this->input->post('Notater');
	if (is_numeric($MaterielltypeID)) {
          $MaterielltypeID = $this->Materiell_model->materielltype_lagre($MaterielltypeID,$data);
          if ($MaterielltypeID != false) {
            $this->session->set_flashdata('Infomelding',"Materielltype '".$data['Navn']."' ble vellykket lagret.");
	  }
	} else {
          $MaterielltypeID = $this->Materiell_model->materielltype_opprett($data);
	  if ($ProdusentID != false) {
            $this->session->set_flashdata('Infomelding','Materielltype \''.$data['Navn'].'\' ble vellykktet opprettet.');
	  }
	}
        if ($this->input->post('SkjemaLagre')) {
          redirect('materiell/materielltype/'.$MaterielltypeID);
        } elseif ($this->input->post('SkjemaLagreLukk')) {
          redirect('materiell/materielltyper');
        }
      } else {
        $data['Roller'] = $this->Brukere_model->roller();
        $data['Materielltype'] = $this->Materiell_model->materielltype_info($this->uri->segment(3));
        $data['Materielliste'] = $this->Materiell_model->materielliste(array('FilterMaterielltype' => $data['Materielltype']['Kode']));
        $this->template->load('standard','materiell/materielltype',$data);
      }
    }

    public function slettmaterielltype() {
      $this->load->model('Materiell_model');
      $Materielltype = $this->Materiell_model->materielltype_info($this->input->get('materielltypeid'));
      if ($Materielltype != null) {
        $this->Materiell_model->materielltype_slett($this->input->get('materielltypeid'));
        $this->session->set_flashdata('Infomelding','Materielltype \''.$Materielltype['Kode'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Materielltypen eksisterer ikke. Kunne ikke slette materielltype.');
      }
      redirect('materiell/materielltyper');
    }

    public function produsenter() {
      $this->load->model('Materiell_model');
      $data['Produsenter'] = $this->Materiell_model->produsenter();
      $this->template->load('standard','materiell/produsenter',$data);
    }

    public function nyprodusent() {
      $data['Produsent'] = null;
      $this->template->load('standard','materiell/produsent',$data);
    }

    public function produsent() {
      $this->load->model('Materiell_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $ProdusentID = $this->input->post('ProdusentID');
        $data['Navn'] = $this->input->post('Navn');
        $data['Nettsted'] = $this->input->post('Nettsted');
	$data['Notater'] = $this->input->post('Notater');
	if (is_numeric($ProdusentID)) {
          $ProdusentID = $this->Materiell_model->produsent_lagre($ProdusentID,$data);
          if ($ProdusentID != false) {
            $this->session->set_flashdata('Infomelding','Produsenten \''.$data['Navn'].'\' ble vellykktet lagret.');
          }
	} else {
          $ProdusentID = $this->Materiell_model->produsent_opprett($data);
          if ($ProdusentID != false) {
            $this->session->set_flashdata('Infomelding','Produsenten \''.$data['Navn'].'\' ble vellykktet opprettet.');
          }
	}
	if ($this->input->post('SkjemaLagre')) {
          redirect('materiell/produsent/'.$ProdusentID);
	} elseif ($this->input->post('SkjemaLagreLukk')) {
          redirect('materiell/produsenter');
	}
      } else {
        $data['Produsent'] = $this->Materiell_model->produsent_info($this->uri->segment(3));
        $data['Materielliste'] = $this->Materiell_model->materielliste(array('FilterProdusentID' => $data['Produsent']['ProdusentID']));
        $this->template->load('standard','materiell/produsent',$data);
      }
    }

    public function slettprodusent() {
      $this->load->model('Materiell_model');
      $Produsent = $this->Materiell_model->produsent_info($this->input->get('produsentid'));
      if ($Produsent != null) {
        $this->Materiell_model->produsent_slett($this->input->get('produsentid'));
        $this->session->set_flashdata('Infomelding','Produsenten \''.$Produsent['Navn'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Produsenten eksisterer ikke. Kunne ikke slette produsent.');
      }
      redirect('materiell/produsenter');
    }


    public function lokasjoner() {
      $this->load->model('Materiell_model');
      $data['Lokasjoner'] = $this->Materiell_model->lokasjoner();
      $this->template->load('standard','materiell/lokasjoner',$data);
    }

    public function nylokasjon() {
      $data['Lokasjon'] = null;
      $this->template->load('standard','materiell/lokasjon',$data);
    }

    public function lokasjon() {
      $this->load->model('Materiell_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $LokasjonID = $this->input->post('LokasjonID');
        $data['Kode'] = str_replace('+','',$this->input->post('Kode'));
        $data['Navn'] = $this->input->post('Navn');
	$data['Notater'] = $this->input->post('Notater');
	if (is_numeric($LokasjonID)) {
          $LokasjonID = $this->Materiell_model->lokasjon_lagre($LokasjonID,$data);
          if ($LokasjonID != false) {
            $this->session->set_flashdata('Infomelding','Lokasjonen \'+'.$data['Kode'].'\' ble vellykket lagret.');
          }
	} else {
          $LokasjonID = $this->Materiell_model->lokasjon_opprett($data);
          if ($LokasjonID != false) {
            $this->session->set_flashdata('Infomelding','Lokasjonen \'+'.$data['Kode'].'\' ble vellykket opprettet.');
          }
	}
        if ($this->input->post('SkjemaLagre')) {
          redirect('materiell/lokasjon/'.$LokasjonID);
        } elseif ($this->input->post('SkjemaLagreLukk')) {
          redirect('materiell/lokasjoner');
        }
      } else {
        $data['Lokasjon'] = $this->Materiell_model->lokasjon_info($this->uri->segment(3));
        $data['Kasser'] = $this->Materiell_model->kasser(array('FilterLokasjonID' => $data['Lokasjon']['LokasjonID']));
        $data['Materielliste'] = $this->Materiell_model->materielliste(array('FilterLokasjonID' => $data['Lokasjon']['LokasjonID']));
        $this->template->load('standard','materiell/lokasjon',$data);
      }
    }

    public function slettlokasjon() {
      $this->load->model('Materiell_model');
      $Lokasjon = $this->Materiell_model->lokasjon_info($this->input->get('lokasjonid'));
      if ($Lokasjon != null) {
        $this->Materiell_model->lokasjon_slett($this->input->get('lokasjonid'));
        $this->session->set_flashdata('Infomelding','Lokasjon \'+'.$Lokasjon['Kode'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Lokasjon eksisterer ikke. Kunne ikke slette lokasjon.');
      }
      redirect('materiell/lokasjoner');
    }


    public function kasser() {
      $this->load->model('Materiell_model');
      $data['Kasser'] = $this->Materiell_model->kasser();
      $this->template->load('standard','materiell/kasser',$data);
    }

    public function nykasse() {
      $this->load->model('Materiell_model');
      $data['Kasse'] = null;
      $data['Lokasjoner'] = $this->Materiell_model->lokasjoner();
      $this->template->load('standard','materiell/kasse',$data);
    }

    public function kasse() {
      $this->load->model('Materiell_model');
      if ($this->input->post('SkjemaLagre') or $this->input->post('SkjemaLagreLukk')) {
        $KasseID = $this->input->post('KasseID');
        $data['Kode'] = $this->input->post('Kode');
	$data['Navn'] = $this->input->post('Navn');
	$data['LokasjonID'] = $this->input->post('LokasjonID');
	$data['Notater'] = $this->input->post('Notater');
	if (is_numeric($KasseID)) {
          $KasseID = $this->Materiell_model->kasse_lagre($KasseID,$data);
          if ($KasseID != false) {
            $this->session->set_flashdata('Infomelding','Kasse \''.str_pad($data['Kode'],2,'0',STR_PAD_LEFT).'\' ble vellykket lagret.');
          }
	} else {
          $KasseID = $this->Materiell_model->kasse_opprett($data);
          if ($KasseID != false) {
            $this->session->set_flashdata('Infomelding','Kasse \'='.str_pad($data['Kode'],2,'0',STR_PAD_LEFT).'\' ble vellykket opprettet.');
          }
	}
	if ($KasseID != false) {
          if ($this->input->post('SkjemaLagre')) {
            redirect('materiell/kasse/'.$KasseID);
          } else {
            redirect('materiell/kasser');
          }
	}
      } else {
        $data['Kasse'] = $this->Materiell_model->kasse_info($this->uri->segment(3));
        $data['Lokasjoner'] = $this->Materiell_model->lokasjoner();
        $data['Materielliste'] = $this->Materiell_model->materielliste(array('FilterKasseID' => $data['Kasse']['KasseID']));
        $this->template->load('standard','materiell/kasse',$data);
      }
    }

    public function slettkasse() {
      $this->load->model('Materiell_model');
      $Kasse = $this->Materiell_model->kasse_info($this->input->get('kasseid'));
      if ($Kasse != null) {
        $this->Materiell_model->kasse_slett($this->input->get('kasseid'));
        $this->session->set_flashdata('Infomelding','Kassen \'='.$Kasse['Kode'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Kassen eksisterer ikke. Kunne ikke slette kasse.');
      }
      redirect('materiell/kasser');
    }

    public function batterityper() {
      $this->load->model('Materiell_model');
      $data['Batterityper'] = $this->Materiell_model->batterityper();
      $this->template->load('standard','materiell/batterityper',$data);
    }

    public function nybatteritype() {
      $this->load->model('Materiell_model');
      $data['Batteritype'] = NULL;
      $this->template->load('standard','materiell/batteritype',$data);
    }

    public function batteritype() {
      $this->load->model('Materiell_model');
      $data['Batteritype'] = $this->Materiell_model->batteritype_info($this->uri->segment(3));
      $data['Materielliste'] = $this->Materiell_model->materielliste(array('FilterBatteritypeID' => $data['Batteritype']['BatteritypeID']));
      $this->template->load('standard','materiell/batteritype',$data);
    }

    public function slettbatteritype() {
      $this->load->model('Materiell_model');
      $Batteritype = $this->Materiell_model->batteritype_info($this->input->get('batteritypeid'));
      if ($Batteritype != null) {
        $this->Materiell_model->batteritype_slett($this->input->get('batteritypeid'));
        $this->session->set_flashdata('Infomelding','Batteritypen \''.$Batteritype['Type'].'\' ble vellykktet slettet.');
      } else {
        $this->session->set_flashdata('Feilmelding','Batteritypen eksisterer ikke. Kunne ikke slette batteritypen.');
      }
      redirect('materiell/batterityper');
    }

    public function innholdsliste() {
      $this->load->model('Materiell_model');
      if (is_numeric($this->input->get('kasseid'))) {
        $data['Kasse'] = $this->Materiell_model->kasse_info($this->input->get('kasseid'));
        $data['Materielliste'] = $this->Materiell_model->materielliste(array('FilterKasseID' => $this->input->get('kasseid')));
      } elseif ($this->input->get('lokasjonid')) {
        $data['Lokasjon'] = $this->Materiell_model->lokasjon_info($this->input->get('lokasjonid'));
        $data['Materielliste'] = $this->Materiell_model->materielliste(array('FilterLokasjonID' => $this->input->get('lokasjonid')));
      }
      $this->template->load('utskrift','materiell/innholdsliste',$data);
    }


    public function materiellssok() {
      $this->load->model('Materiell_model');
      $Keyword = $this->input->post('Sokestreng');
      $Keyword = str_replace('=','',$Keyword);
      $Keyword = str_replace('+','',$Keyword);
      $Keyword = str_replace('-','',$Keyword);
      echo $Keyword;
      $data['Materiell'] = $this->Materiell_model->materiell_info($Keyword);
      redirect('materiell/materiell/'.$data['Materiell']['MateriellID']);
    }

  }
