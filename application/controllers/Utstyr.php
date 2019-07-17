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
        $this->Utstyr_model->utstyr_lagre($UtstyrID,$Utstyr);
        redirect('utstyr/utstyrsliste');
      } elseif ($this->input->post('UtstyrSlett')) {
        $this->Utstyr_model->utstyr_slett($this->input->post('UtstyrID'));
        redirect('utstyr/utstyrsliste');
      } else {
        $data['Utstyr'] = $this->Utstyr_model->utstyr_info($this->uri->segment(3));
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
      $data['Utstyrstype'] = null;
      $this->template->load('standard','utstyr/utstyrstype',$data);
    }

    public function utstyrstype() {
      $this->load->model('Utstyr_model');
      if ($this->input->post('UtstyrstypeLagre')) {
        $UtstyrstypeID = $this->input->post('UtstyrstypeID');
        if ($this->input->post('NyUtstyrstypeID')) {
          $Utstyrstype['UtstyrstypeID'] = $this->input->post('NyUtstyrstypeID');
        }
        $Utstyrstype['Beskrivelse'] = $this->input->post('Beskrivelse');
        $Utstyrstype['Notater'] = $this->input->post('Notater');
        $this->Utstyr_model->utstyrstype_lagre($UtstyrstypeID,$Utstyrstype);
        redirect('utstyr/utstyrstyper');
      } elseif ($this->input->post('UtstyrstypeSlett')) {
        $this->Utstyr_model->utstyrstype_slett($this->input->post('UtstyrstypeID'));
        redirect('utstyr/utstyrstyper');
      } else {
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

    public function avvik() {
      $this->load->model('Vedlikehold_model');
      if ($this->input->post('AvvikLagre')) {
        $AvvikID = $this->input->post('AvvikID');
        $Avvik['Beskrivelse'] = $this->input->post('Beskrivelse');
        $Avvik['Notater'] = $this->input->post('Notater');
        $this->Vedlikehold_model->avvik_lagre($AvvikID,$Avvik);
        redirect('utstyr/avviksliste');
      } elseif ($this->input->post('AvvikSlett')) {
        $this->Vedlikehold_model->avvik_slett($this->input->post('AvvikID'));
        redirect('utstyr/avviksliste');
      } else {
        $this->load->model('Brukere_model');
        $data['Avvik'] = $this->Vedlikehold_model->avvik_info($this->uri->segment(3));
        $data['Brukere'] = $this->Brukere_model->brukere();
        $this->template->load('standard','vedlikehold/avvik',$data);
      }
    }

  }
