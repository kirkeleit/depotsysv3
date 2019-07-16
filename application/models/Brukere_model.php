<?php
  class Brukere_model extends CI_Model {

    function brukere($filter = null) {
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

    function login($Brukernavn,$Passord) {
      $sql = 'SELECT BrukerID,Fornavn,Epostadresse FROM Brukere WHERE (Epostadresse=\''.$Brukernavn.'\') AND (Passord=\''.$Passord.'\') LIMIT 1';
      $rBrukere = $this->db->query($sql);
      if($rBrukere->num_rows() == 1) {
        $rBruker = $rBrukere->row_array();
        $this->db->query("UPDATE Brukere SET DatoLastLogin=Now() WHERE BrukerID=".$rBruker['BrukerID']." LIMIT 1");
        return $rBruker;
      } else {
        return false;
      }
    }

  }
?>

