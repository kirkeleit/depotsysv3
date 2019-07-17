<?php
  class Brukere_model extends CI_Model {

    function brukere($filter = null) {
      $sql = "SELECT BrukerID,Fornavn,Etternavn,Epostadresse,Mobilnummer FROM Brukere b WHERE (DatoSlettet Is Null)";
      if (isset($filter['FilterLokasjonID'])) {
        $sql .= " AND (LokasjonID Like '".$filter['FilterLokasjonID']."%')";
      }
      if (isset($filter['FilterKasseID'])) {
        $sql .= " AND (KasseID='".$filter['FilterKasseID']."')";
      }
      $sql .= " ORDER BY Fornavn ASC";
      $rBrukere = $this->db->query($sql);
      foreach ($rBrukere->result_array() as $rBruker) {
        $Brukere[] = $rBruker;
        unset($rBruker);
      }
      unset($rBrukere);
      if (isset($Brukere)) {
        return $Brukere;
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

