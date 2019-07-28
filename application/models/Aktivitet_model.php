<?php
  class Aktivitet_model extends CI_Model {

    var $PlukklisteStatus = array(0 => 'Åpen', 1 => 'Aktiv', 2 => 'Delvis returnert', 3 => 'Lukket');

    function plukklister($filter = null) {
      $sql = "SELECT PlukklisteID,DatoRegistrert,DatoEndret,DatoSlettet,Beskrivelse,AnsvarligBrukerID,(SELECT CONCAT(Fornavn,' ',Etternavn) FROM Brukere b WHERE (b.BrukerID=p.AnsvarligBrukerID) LIMIT 1) AS AnsvarligBrukerNavn,(SELECT COUNT(*) FROM PlukklisteXUtstyr x WHERE (x.PlukklisteID=p.PlukklisteID)) AS UtstyrAntall,StatusID FROM Plukklister p WHERE (DatoSlettet Is Null)";
      if (isset($filter['FilterLokasjonID'])) {
        $sql .= " AND (LokasjonID Like '".$filter['FilterLokasjonID']."%')";
      }
      if (isset($filter['FilterKasseID'])) {
        $sql .= " AND (KasseID='".$filter['FilterKasseID']."')";
      }
      $sql .= " ORDER BY PlukklisteID ASC";
      $rPlukklister = $this->db->query($sql);
      foreach ($rPlukklister->result_array() as $rPlukkliste) {
        $rPlukkliste['Status'] = $this->PlukklisteStatus[$rPlukkliste['StatusID']];
        $Plukklister[] = $rPlukkliste;
        unset($rPlukkliste);
      }
      unset($rPlukklister);
      if (isset($Plukklister)) {
        return $Plukklister;
      }
    }

    function plukkliste_info($PlukklisteID = null) {
      $rPlukklister = $this->db->query("SELECT PlukklisteID,DatoRegistrert,DatoEndret,DatoSlettet,Beskrivelse,AnsvarligBrukerID,StatusID FROM Plukklister WHERE (PlukklisteID='".$PlukklisteID."') LIMIT 1");
      if ($rPlukkliste = $rPlukklister->row_array()) {
        return $rPlukkliste;
      }
    }

    function plukkliste_opprett($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['DatoEndret'] = $data['DatoRegistrert'];
      if ($this->db->query($this->db->insert_string('Plukklister',$data))) {
        $PlukklisteID = $this->db->insert_id();
	return $PlukklisteID;
      } else {
        return false;
      }
    }

    function plukkliste_lagre($PlukklisteID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($this->db->query($this->db->update_string('Plukklister',$data,"PlukklisteID='".$PlukklisteID."'"))) {
        return $PlukklisteID;
      } else {
        return false;
      }
    }

    function plukkliste_leggtilutstyr($PlukklisteID,$UtstyrID) {
      $rUtstyrsliste = $this->db->query("SELECT UtstyrID FROM Utstyr WHERE (UtstyrID='".$UtstyrID."') LIMIT 1");
      if ($rUtstyr = $rUtstyrsliste->row_array()) {
        if (substr($rUtstyr['UtstyrID'],-1,1) != 'T') {
          $rXUtstyrsliste = $this->db->query("SELECT UtstyrID FROM PlukklisteXUtstyr WHERE (PlukklisteID=".$PlukklisteID.") AND (UtstyrID='".$rUtstyr['UtstyrID']."')");
	  if ($rXUtstyrsliste->num_rows() == 0) {
            $this->db->query("INSERT INTO PlukklisteXUtstyr (DatoRegistrert,UtstyrID,PlukklisteID,Antall) VALUES (Now(),'".$rUtstyr['UtstyrID']."',".$PlukklisteID.",1)");
	  }
	} else {
          $rXUtstyrsliste = $this->db->query("SELECT UtstyrID,Antall FROM PlukklisteXUtstyr WHERE (PlukklisteID=".$PlukklisteID.") AND (UtstyrID='".$rUtstyr['UtstyrID']."')");
          if ($rXUtstyrsliste->num_rows() == 0) {
            $this->db->query("INSERT INTO PlukklisteXUtstyr (DatoRegistrert,UtstyrID,PlukklisteID,Antall) VALUES (Now(),'".$rUtstyr['UtstyrID']."',".$PlukklisteID.",1)");
	  } else {
            $rXUtstyr = $rXUtstyrsliste->row_array();
            $this->db->query("UPDATE PlukklisteXUtstyr SET Antall=".($rXUtstyr['Antall']+1)." WHERE UtstyrID='".$rUtstyr['UtstyrID']."' AND PlukklisteID=".$PlukklisteID." LIMIT 1");
	  }
	}
      }
    }

    function plukkliste_slett($PlukklisteID) {
      $this->db->query("UPDATE Plukklister SET DatoSlettet=Now() WHERE PlukklisteID='".$PlukklisteID."' LIMIT 1");
    }

    function utstyrsliste($PlukklisteID) {
      $sql = "SELECT x.UtstyrID,u.Beskrivelse,x.Antall,(SELECT COUNT(*) FROM Avvik a WHERE (a.UtstyrID=u.UtstyrID) AND (DatoSlettet Is Null)) AS AntallAvvik,u.ProdusentID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=u.ProdusentID)) AS ProdusentNavn FROM PlukklisteXUtstyr x LEFT JOIN Utstyr u ON (u.UtstyrID=x.UtstyrID) WHERE (x.PlukklisteID=".$PlukklisteID.") ORDER BY x.DatoRegistrert ASC";
      $rUtstyrsliste = $this->db->query($sql);
      foreach ($rUtstyrsliste->result_array() as $rUtstyr) {
        $Utstyrsliste[] = $rUtstyr;
	unset($rUtstyr);
      }
      unset($rUtstyrsliste);
      if (isset($Utstyrsliste)) {
        return $Utstyrsliste;
      }
    }


  }
?>

