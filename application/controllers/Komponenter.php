<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Komponenter extends CI_Controller {

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
          redirect('komponenter/login');
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
            redirect('komponenter');
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
      redirect('komponenter');
    }

    public function index() {
      redirect('komponenter/liste');
    }

    public function liste() {
      $this->load->model('Komponenter_model');
      $data['Komponenter'] = $this->Komponenter_model->komponenter();
      $this->template->load('standard','komponenter/liste',$data);
    }

    public function nykomponent() {
      $this->load->model('Komponenter_model');
      $ID = $this->Komponenter_model->nykomponentid($this->uri->segment(3));
      $Komponent['KomponentID'] = $ID;
      $data['Komponent'] = $this->Komponenter_model->komponent_lagre(null,$Komponent);
      redirect('komponenter/komponent/'.$data['Komponent']['KomponentID']);
    }

    public function komponent() {
      $this->load->model('Komponenter_model');
      if ($this->input->post('KomponentLagre')) {
        $KomponentID = $this->input->post('KomponentID');
	$Komponent['Beskrivelse'] = $this->input->post('Beskrivelse');
	if ($this->input->post('Plassering')) {
          if ($this->input->post('Plassering') == '') {
            $Komponent['LokasjonID'] = '';
	    $Komponent['KasseID'] = '';
	  } else {
            if (substr($this->input->post('Plassering'),0,1) == '+') {
              $Komponent['KasseID'] = '';
	      $Komponent['LokasjonID'] = substr($this->input->post('Plassering'),1);
	    } elseif (substr($this->input->post('Plassering'),0,1) == '=') {
              $Komponent['LokasjonID'] = '';
	      $Komponent['KasseID'] = substr($this->input->post('Plassering'),1);
	    }
	  }
	}
        $Komponent['ProdusentID'] = $this->input->post('ProdusentID');
        $Komponent['Notater'] = $this->input->post('Notater');
        $this->Komponenter_model->komponent_lagre($KomponentID,$Komponent);
        redirect('komponenter/liste');
      } elseif ($this->input->post('KomponentSlett')) {
        $this->Komponent_model->komponent_slett($this->input->post('KomponentID'));
        redirect('komponenter/liste');
      } else {
        $data['Komponent'] = $this->Komponenter_model->komponent_info($this->uri->segment(3));
	$data['Produsenter'] = $this->Komponenter_model->produsenter();
	$data['Lokasjoner'] = $this->Komponenter_model->lokasjoner();
	$data['Kasser'] = $this->Komponenter_model->kasser();
        $this->template->load('standard','komponenter/komponent',$data);
      }
    }


    public function komponenttyper() {
      $this->load->model('Komponenter_model');
      $data['Komponenttyper'] = $this->Komponenter_model->komponenttyper();
      $this->template->load('standard','komponenter/komponenttyper',$data);
    }

    public function nykomponenttype() {
      $data['Komponenttype'] = null;
      $this->template->load('standard','komponenter/komponenttype',$data);
    }

    public function komponenttype() {
      $this->load->model('Komponenter_model');
      if ($this->input->post('KomponenttypeLagre')) {
        $KomponenttypeID = $this->input->post('KomponenttypeID');
        $Komponenttype['Beskrivelse'] = $this->input->post('Beskrivelse');
        $Komponenttype['Notater'] = $this->input->post('Notater');
        $this->Komponenter_model->komponenttype_lagre($KomponenttypeID,$Komponenttype);
        redirect('komponenter/komponenttyper');
      } elseif ($this->input->post('KomponenttypeSlett')) {
        $this->Komponenter_model->komponenttype_slett($this->input->post('KomponenttypeID'));
        redirect('komponenter/komponenttyper');
      } else {
        $data['Komponenttype'] = $this->Komponenter_model->komponenttype_info($this->uri->segment(3));
        $data['Komponenter'] = $this->Komponenter_model->komponenter(array('FilterKomponenttypeID' => $data['Komponenttype']['KomponenttypeID']));
        $this->template->load('standard','komponenter/komponenttype',$data);
      }
    }


    public function produsenter() {
      $this->load->model('Komponenter_model');
      $data['Produsenter'] = $this->Komponenter_model->produsenter();
      $this->template->load('standard','komponenter/produsenter',$data);
    }

    public function nyprodusent() {
      $data['Produsent'] = null;
      $this->template->load('standard','komponenter/produsent',$data);
    }

    public function produsent() {
      $this->load->model('Komponenter_model');
      if ($this->input->post('ProdusentLagre')) {
        $ProdusentID = $this->input->post('ProdusentID');
        $Produsent['Navn'] = $this->input->post('Navn');
        $Produsent['Nettsted'] = $this->input->post('Nettsted');
        $Produsent['Notater'] = $this->input->post('Notater');
        $this->Komponenter_model->produsent_lagre($ProdusentID,$Produsent);
        redirect('komponenter/produsenter');
      } elseif ($this->input->post('ProdusentSlett')) {
        $this->Komponent_model->produsent_slett($this->input->post('ProdusentID'));
        redirect('komponenter/produsenter');
      } else {
        $data['Produsent'] = $this->Komponenter_model->produsent_info($this->uri->segment(3));
        $data['Komponenter'] = $this->Komponenter_model->komponenter(array('FilterProdusentID' => $data['Produsent']['ProdusentID']));
        $this->template->load('standard','komponenter/produsent',$data);
      }
    }


    public function lokasjoner() {
      $this->load->model('Komponenter_model');
      $data['Lokasjoner'] = $this->Komponenter_model->lokasjoner();
      $this->template->load('standard','komponenter/lokasjoner',$data);
    }

    public function nylokasjon() {
      $data['Lokasjon'] = null;
      $this->template->load('standard','komponenter/lokasjon',$data);
    }

    public function lokasjon() {
      $this->load->model('Komponenter_model');
      if ($this->input->post('LokasjonLagre')) {
        $LokasjonID = $this->input->post('LokasjonID');
        if ($this->input->post('NyLokasjonID')) {
          $Lokasjon['LokasjonID'] = $this->input->post('NyLokasjonID');
        }
        $Lokasjon['Navn'] = $this->input->post('Navn');
        $Lokasjon['Notater'] = $this->input->post('Notater');
        $this->Komponenter_model->lokasjon_lagre($LokasjonID,$Lokasjon);
        redirect('komponenter/lokasjoner');
      } elseif ($this->input->post('LokasjonSlett')) {
        $this->Komponent_model->lokasjon_slett($this->input->post('LokasjonID'));
        redirect('komponenter/lokasjoner');
      } else {
        $data['Lokasjon'] = $this->Komponenter_model->lokasjon_info($this->uri->segment(3));
        $data['Komponenter'] = $this->Komponenter_model->komponenter(array('FilterLokasjonID' => $data['Lokasjon']['LokasjonID']));
        $this->template->load('standard','komponenter/lokasjon',$data);
      }
    }


    public function kasser() {
      $this->load->model('Komponenter_model');
      $data['Kasser'] = $this->Komponenter_model->kasser();
      $this->template->load('standard','komponenter/kasser',$data);
    }

    public function nykasse() {
      $this->load->model('Komponenter_model');
      $data['Kasse'] = null;
      $data['Lokasjoner'] = $this->Komponenter_model->lokasjoner();
      $this->template->load('standard','komponenter/kasse',$data);
    }

    public function kasse() {
      $this->load->model('Komponenter_model');
      if ($this->input->post('KasseLagre')) {
        $KasseID = $this->input->post('KasseID');
        if ($this->input->post('NyKasseID')) {
          $Kasse['KasseID'] = $this->input->post('NyKasseID');
        }
	$Kasse['Navn'] = $this->input->post('Navn');
	$Kasse['LokasjonID'] = $this->input->post('LokasjonID');
        $Kasse['Notater'] = $this->input->post('Notater');
        $this->Komponenter_model->kasse_lagre($KasseID,$Kasse);
        redirect('komponenter/kasser');
      } elseif ($this->input->post('KasseSlett')) {
        $this->Komponenter_model->kasse_slett($this->input->post('KasseID'));
        redirect('komponenter/kasser');
      } else {
        $data['Kasse'] = $this->Komponenter_model->kasse_info($this->uri->segment(3));
        $data['Lokasjoner'] = $this->Komponenter_model->lokasjoner();
        $data['Komponenter'] = $this->Komponenter_model->komponenter(array('FilterKasseID' => $data['Kasse']['KasseID']));
        $this->template->load('standard','komponenter/kasse',$data);
      }
    }

  }
