<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class Depot {

    function NyGUIMelding($Type, $Tekst) {
      $this->CI =& get_instance();
      if ($this->CI->session->flashdata('GUIMeldinger')) {
        $Meldinger = $this->CI->session->flashdata('GUIMeldinger');
      }
      $Meldinger[] = array('Type' => $Type, 'Tekst' => $Tekst);
      $this->CI->session->set_flashdata('GUIMeldinger',$Meldinger);
    }

  }
/* End of file Depot.php */
/* Location: ./system/application/libraries/Depot.php */
