<?php
  class Brukere_model extends CI_Model {


    function brukere($filter = null) {
      $sql = "SELECT BrukerID,Fornavn,Etternavn,Epostadresse,Mobilnummer,RolleID,(SELECT Navn FROM Roller r WHERE (r.RolleID=b.RolleID) LIMIT 1) AS Rolle FROM Brukere b WHERE (DatoSlettet Is Null)";
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

    function bruker_info($BrukerID = null) {
      $rBrukere = $this->db->query("SELECT BrukerID,Fornavn,Etternavn,Epostadresse,Mobilnummer,RolleID,Notater FROM Brukere b WHERE (BrukerID='".$BrukerID."') LIMIT 1");
      if ($rBruker = $rBrukere->row_array()) {
        return $rBruker;
      }
    }

    function bruker_lagre($BrukerID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($BrukerID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Brukere',$data));
        $data['BrukerID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Brukere',$data,"BrukerID='".$BrukerID."'"));
        $data['BrukerID'] = $BrukerID;
      }
      if ($this->db->affected_rows() > 0) {
        //$this->session->set_flashdata('Infomelding','Avvik '.$data['AvvikID'].' ble lagret.');
      }
      return $data;
    }

    function bruker_slett($BrukerID) {
      $this->db->query("UPDATE Brukere SET DatoSlettet=Now() WHERE BrukerID='".$BrukerID."' LIMIT 1");
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

    function roller() {
      $sql = "SELECT RolleID,Navn,Notater FROM Roller WHERE (DatoSlettet Is Null)";
      $sql .= " ORDER BY RolleID ASC";
      $rRoller = $this->db->query($sql);
      foreach ($rRoller->result_array() as $rRolle) {
        $Roller[] = $rRolle;
        unset($rRolle);
      }
      unset($rRoller);
      if (isset($Roller)) {
        return $Roller;
      }
    }

    function rolle_info($RolleID = null) {
      $rRoller = $this->db->query("SELECT RolleID,Navn,Notater FROM Roller WHERE (RolleID='".$RolleID."') LIMIT 1");
      if ($rRolle = $rRoller->row_array()) {
        return $rRolle;
      }
    }

    function rolle_lagre($RolleID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($RolleID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Roller',$data));
        $data['RolleID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Roller',$data,"RolleID='".$RolleID."'"));
        $data['RolleID'] = $RolleID;
      }
      if ($this->db->affected_rows() > 0) {
        //$this->session->set_flashdata('Infomelding','Avvik '.$data['AvvikID'].' ble lagret.');
      }
      return $data;
    }

    function rolle_slett($RolleID) {
      $this->db->query("UPDATE Roller SET DatoSlettet=Now() WHERE RolleID='".$RolleID."' LIMIT 1");
    }

  }
?>

