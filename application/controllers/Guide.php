<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Guide extends CI_Controller {

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
      $this->template->load('standard','guide/materiell');
    }

  }
