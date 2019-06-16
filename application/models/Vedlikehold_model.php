<?php
  class Vedlikehold_model extends CI_Model {

    function kontrolliste($filter = null) {
      $sql = "SELECT KomponentID,Beskrivelse,LokasjonID,KasseID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=k.ProdusentID)) AS ProdusentNavn FROM Komponenter k WHERE 1";
      if (isset($filter['FilterLokasjonID'])) {
        $sql .= " AND (LokasjonID Like '".$filter['FilterLokasjonID']."%')";
      }
      if (isset($filter['FilterKasseID'])) {
        $sql .= " AND (KasseID='".$filter['FilterKasseID']."')";
      }
      $sql .= " ORDER BY KasseID,LokasjonID,KomponentID ASC";
      $rkomponenter = $this->db->query($sql);
      foreach ($rkomponenter->result_array() as $rkomponent) {
        $rkontroller = $this->db->query("SELECT * FROM KomponentKontrollogg WHERE (KomponentID='".$rkomponent['KomponentID']."') AND (DatoRegistrert > '".date('Y-m-d H:i:s', mktime(0, 0, 0, date("m"), date("d")-30, date("Y")))."')");
        if ($rkontroller->num_rows() == 0) {
          $komponent['KomponentID'] = $rkomponent['KomponentID'];
          $komponent['Beskrivelse'] = $rkomponent['Beskrivelse'];
	  $komponent['ProdusentNavn'] = $rkomponent['ProdusentNavn'];
          if ($rkomponent['KasseID'] == '') {
            $komponent['Plassering'] = '+'.$rkomponent['LokasjonID'];
	  } else {
            $komponent['Plassering'] = '='.$rkomponent['KasseID'];
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
      $this->db->query($this->db->insert_string('KomponentKontrollogg',$data));
    }


  }
?>

