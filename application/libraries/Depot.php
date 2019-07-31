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

    function SendPlukklisteEpost($Plukkliste, $Utstyrsliste) {
      $this->CI =& get_instance();
      $this->CI->email->from('depot@bomlork.no', 'DepotSYS | Bømlo Røde Kors Hjelpekorps');
      $this->CI->email->to('thorbjorn@kirkeleit.net');
      $this->CI->email->subject('Utlevering av utstyr');
      $Tekst = "Hei!\r\n\r\n";
      $Tekst .= "Plukkliste: ".$Plukkliste['Beskrivelse']."\r\n";
      $Tekst .= "Ansvarlig: ".$Plukkliste['AnsvarligBrukerNavn']."\r\n\r\n";
      $Tekst .= "Dette er ei liste over alt utstyr som er registrert utlevert på denne plukklisten. Den som står som ansvarlig har ansvar for at utstyret blir tatt vare på og levert tilbake i samme tilstand og mengde som ved utleveirng. Dersom noe skulle skje med utstyret har en ansvar for å registrere avvik og beskrive hva som har skjedd. Sørg for at utstyret blir levert tilbake så snart det er praktisk mulig.\r\n\r\n";
      $Tekst .= "Liste over utstyr:\r\n";
      foreach ($Utstyrsliste as $Utstyr) {
        $Tekst .= "-".$Utstyr['UtstyrID']." ".$Utstyr['Beskrivelse']."(".$Utstyr['UtAntall']." stk)\r\n";
      }
      $Tekst .= "\r\n";
      $Tekst .= "Mvh,\r\n\r\n";
      $Tekst .= "DepotSYS\r\n";
      $Tekst .= "Bømlo Røde Kors Hjelpekorps\r\n";
      $Tekst .= "depot@bomlork.no";
      $this->CI->email->message($Tekst);
      $this->CI->email->send();
    }

  }
/* End of file Depot.php */
/* Location: ./system/application/libraries/Depot.php */
