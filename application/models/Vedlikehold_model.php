<?php
  class Vedlikehold_model extends CI_Model {

    function kontrolliste($filter = null) {
      $sql = "SELECT KomponentID,Beskrivelse,LokasjonID,KasseID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=k.ProdusentID)) AS ProdusentNavn,Antall FROM Komponenter k WHERE 1";
      if (isset($filter['FilterLokasjonID'])) {
        $sql .= " AND (LokasjonID Like '".$filter['FilterLokasjonID']."%')";
      }
      if (isset($filter['FilterKasseID'])) {
        $sql .= " AND (KasseID='".$filter['FilterKasseID']."')";
      }
      $sql .= " ORDER BY KasseID,LokasjonID,KomponentID ASC";
      $rkomponenter = $this->db->query($sql);
      foreach ($rkomponenter->result_array() as $rkomponent) {
        $rkontroller = $this->db->query("SELECT * FROM Kontrollogg WHERE (KomponentID='".$rkomponent['KomponentID']."') AND (DatoRegistrert > '".date('Y-m-d H:i:s', mktime(0, 0, 0, date("m"), date("d")-30, date("Y")))."')");
        if ($rkontroller->num_rows() == 0) {
          $komponent['KomponentID'] = $rkomponent['KomponentID'];
	  $komponent['Beskrivelse'] = $rkomponent['Beskrivelse'];
	  $komponent['Antall'] = $rkomponent['Antall'];
	  $komponent['ProdusentNavn'] = $rkomponent['ProdusentNavn'];
          if ($rkomponent['KasseID'] == '') {
            $komponent['Plassering'] = '+'.$rkomponent['LokasjonID'];
            $rlokasjoner = $this->db->query("SELECT Navn FROM Lokasjoner WHERE (LokasjonID='".$rkomponent['LokasjonID']."') LIMIT 1");
            if ($rlokasjon = $rlokasjoner->row_array()) {
              $komponent['Plassering'] .= " ".$rlokasjon['Navn'];
            }
	  } else {
            $komponent['Plassering'] = '='.$rkomponent['KasseID'];
            $rkasser = $this->db->query("SELECT Navn FROM Kasser WHERE (KasseID='".$rkomponent['KasseID']."') LIMIT 1");
            if ($rkasse = $rkasser->row_array()) {
              $komponent['Plassering'] .= " ".$rkasse['Navn'];
            }
          }
          $komponenter[] = $komponent;
        }
        unset($rkomponent);
      }
      if (isset($komponenter)) {
        return $komponenter;
      }
    }

    function kontroll_lagre($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['DatoEndret'] = $data['DatoRegistrert'];
      $this->db->query($this->db->insert_string('Kontrollogg',$data));
      if ($data['Tilstand'] != 0) {
        $avvik['DatoRegistrert'] = $data['DatoRegistrert'];
        $avvik['DatoEndret'] = $data['DatoRegistrert'];
	$avvik['KomponentID'] = $data['KomponentID'];
	switch ($data['Tilstand']) {
          case 1:
            $data['Beskrivelse'] = "Trenger vedlikehold. ";
            break;
          case 2:
            $data['Beskrivelse'] = "Utstyret mangler. ";
            break;
          case 3:
            $data['Beskrivelse'] = "Utstyret er ødelagt. ";
            break;
	}
        $avvik['Beskrivelse'] .= $data['Kommentar'];
        $this->avvik_registrere($avvik);
      }
    }

    function avvik_registrere($data) {
      $this->db->query($this->db->insert_string('Avvik',$data));
      define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
      $message = array('payload' => json_encode(array('channel' => '#depottest', 'text' => "Nytt avvik registrert på '-".$data['KomponentID']."': ".$data['Beskrivelse'])));
      $c = curl_init(SLACK_WEBHOOK);
      curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($c, CURLOPT_POST, true);
      curl_setopt($c, CURLOPT_POSTFIELDS, $message);
      curl_exec($c);
      curl_close($c);
    }

    function avviksliste($filter = null) {
      $sql = "SELECT AvvikID,DatoRegistrert,KomponentID,Beskrivelse FROM Avvik a WHERE 1";
      if (isset($filter['FilterLokasjonID'])) {
        $sql .= " AND (LokasjonID Like '".$filter['FilterLokasjonID']."%')";
      }
      if (isset($filter['FilterKasseID'])) {
        $sql .= " AND (KasseID='".$filter['FilterKasseID']."')";
      }
      $sql .= " ORDER BY KomponentID,DatoRegistrert ASC";
      $ravviksliste = $this->db->query($sql);
      foreach ($ravviksliste->result_array() as $ravvik) {
        $avviksliste[] = $ravvik;
        unset($ravvik);
      }
      if (isset($avviksliste)) {
        return $avviksliste;
      }
    }

  }
?>
