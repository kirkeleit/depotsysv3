<?php
  class Vedlikehold_model extends CI_Model {

    var $AvvikStatus = array(0 => 'Registrert', 1 => 'Under arbeid', 2 => 'På vent', 3 => 'Lukket');

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
      $sql = "SELECT AvvikID,DatoRegistrert,UtstyrID,Beskrivelse,BrukerID,StatusID,Kostnad,(SELECT CONCAT(Fornavn,' ',Etternavn) AS Navn FROM Brukere b WHERE (b.BrukerID=a.BrukerID)) AS BrukerNavn FROM Avvik a WHERE (DatoSlettet Is Null)";
      if (isset($filter['FilterUtstyrID'])) {
        $sql .= " AND (UtstyrID='".$filter['FilterUtstyrID']."')";
      } else {
        $sql .= " AND (StatusID < 3)";
      }
      $sql .= " ORDER BY UtstyrID,DatoRegistrert ASC";
      $rAvviksliste = $this->db->query($sql);
      foreach ($rAvviksliste->result_array() as $rAvvik) {
        $rAvvik['Status'] = $this->AvvikStatus[$rAvvik['StatusID']];
        $Avviksliste[] = $rAvvik;
        unset($rAvvik);
      }
      unset($rAvviksliste);
      if (isset($Avviksliste)) {
        return $Avviksliste;
      }
    }

    function avvik_info($AvvikID = null) {
      $rAvviksliste = $this->db->query("SELECT AvvikID,DatoRegistrert,DatoEndret,DatoSlettet,Kostnad,Beskrivelse,BrukerID,StatusID,UtstyrID,(SELECT CONCAT(Fornavn,' ',Etternavn) AS Navn FROM Brukere b WHERE (b.BrukerID=a.BrukerID)) AS BrukerNavn FROM Avvik a WHERE (AvvikID='".$AvvikID."')");
      if ($rAvvik = $rAvviksliste->row_array()) {
        $rLogglinjer = $this->db->query("SELECT AvvikID,BrukerID,DatoRegistrert,Tekst,LoggtypeID,(SELECT CONCAT(Fornavn,' ',Etternavn) AS Navn FROM Brukere b WHERE (b.BrukerID=a.BrukerID)) AS BrukerNavn FROM Avvikslogg a WHERE (AvvikID='".$rAvvik['AvvikID']."') ORDER BY DatoRegistrert ASC");
	foreach ($rLogglinjer->result_array() as $rLogglinje) {
          $Logglinjer[] = $rLogglinje;
	}
	if (isset($Logglinjer)) {
          $rAvvik['Logglinjer'] = $Logglinjer;
        }
        $rAvvik['Status'] = $this->AvvikStatus[$rAvvik['StatusID']];
        return $rAvvik;
      }
    }

    function avvik_lagre($AvvikID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($AvvikID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Avvik',$data));
        $data['AvvikID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Avvik',$data,"AvvikID='".$AvvikID."'"));
        $data['AvvikID'] = $AvvikID;
      }
      if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('Infomelding','Avvik '.$data['AvvikID'].' ble lagret.');
      }
      return $data;
    }

    function avvik_slett($AvvikID) {
      $this->db->query("UPDATE Avvik SET DatoSlettet=Now() WHERE AvvikID='".$AvvikID."' LIMIT 1");
    }

    function avvik_lagrelogg($AvvikID,$data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['AvvikID'] = $AvvikID;
      $this->db->query($this->db->insert_string('Avvikslogg',$data));
    }

  }
?>

