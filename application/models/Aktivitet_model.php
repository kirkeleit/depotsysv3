<?php
  class Aktivitet_model extends CI_Model {

    var $PlukklisteStatus = array(0 => 'Åpen', 1 => 'Låst/Utlevert', 2 => 'Låst/Delvis innlevert', 3 => 'Ferdig');
    var $PlukklisteTypeID = array(0 => 'Personlig', 1 => 'Standard');

    function aktiviteter($filter = null) {
      $sql = "SELECT AktivitetID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Notater,(SELECT COUNT(*) FROM Plukklister p WHERE (p.AktivitetID=a.AktivitetID)) AS PlukklisterAntall FROM Aktiviteter a WHERE (DatoSlettet Is Null)";
      if (isset($filter['FilterID'])) {
        $sql .= " AND (LokasjonID Like '".$filter['FilterLokasjonID']."%')";
      }
      if (isset($filter['FilterKasseID'])) {
        $sql .= " AND (KasseID='".$filter['FilterKasseID']."')";
      }
      $sql .= " ORDER BY AktivitetID ASC";
      $rAktiviteter = $this->db->query($sql);
      foreach ($rAktiviteter->result_array() as $rAktivitet) {
        $Aktiviteter[] = $rAktivitet;
        unset($rAktivitet);
      }
      unset($rAktiviteter);
      if (isset($Aktiviteter)) {
        return $Aktiviteter;
      }
    }

    function aktivitet_info($AktivitetID = null) {
      $rAktiviteter = $this->db->query("SELECT AktivitetID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Notater FROM Aktiviteter WHERE (AktivitetID='".$AktivitetID."') LIMIT 1");
      if ($rAktivitet = $rAktiviteter->row_array()) {
        return $rAktivitet;
      }
    }

    function aktivitet_opprett($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['DatoEndret'] = $data['DatoRegistrert'];
      if ($this->db->query($this->db->insert_string('Aktiviteter',$data))) {
        $AktivitetID = $this->db->insert_id();
        return $AktivitetID;
      } else {
        return false;
      }
    }

    function aktivitet_lagre($AktivitetID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($this->db->query($this->db->update_string('Aktiviteter',$data,"AktivitetID='".$AktivitetID."'"))) {
        return $AktivitetID;
      } else {
        return false;
      }
    }

    function aktivitet_slett($AktivitetID = null) {
      $this->db->query("UPDATE Plukklister SET AktivitetID=0 WHERE AktivitetID='".$AktivitetID."' LIMIT 1");
      $this->db->query("UPDATE Aktiviteter SET DatoSlettet=Now() WHERE AktivitetID='".$AktivitetID."' LIMIT 1");
    }

    function plukklister($filter = null) {
      $sql = "SELECT PlukklisteID,DatoRegistrert,DatoEndret,DatoSlettet,PlukklisteTypeID,Beskrivelse,AktivitetID,AnsvarligBrukerID,(SELECT CONCAT(Fornavn,' ',Etternavn) FROM Brukere b WHERE (b.BrukerID=p.AnsvarligBrukerID) LIMIT 1) AS AnsvarligBrukerNavn,(SELECT COUNT(*) FROM PlukklisteXUtstyr x WHERE (x.PlukklisteID=p.PlukklisteID)) AS UtstyrAntall,StatusID FROM Plukklister p WHERE (DatoSlettet Is Null)";
      if (isset($filter['FilterAktivitetID'])) {
        $sql .= " AND (AktivitetID Like '".$filter['FilterAktivitetID']."%')";
      }
      if (isset($filter['FilterPlukklisteTypeID'])) {
        $sql .= " AND (PlukklisteTypeID=".$filter['FilterPlukklisteTypeID'].")";
      } else {
        $sql .= " AND (PlukklisteTypeID=1)";
      }
      if (isset($filter['FilterAnsvarligBrukerID'])) {
        $sql .= " AND (AnsvarligBrukerID=".$filter['FilterAnsvarligBrukerID'].")";
      }
      $sql .= " ORDER BY PlukklisteID ASC";
      $rPlukklister = $this->db->query($sql);
      foreach ($rPlukklister->result_array() as $rPlukkliste) {
        $rPlukkliste['PlukklisteType'] = $this->PlukklisteTypeID[$rPlukkliste['PlukklisteTypeID']];
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
      $rPlukklister = $this->db->query("SELECT PlukklisteID,DatoRegistrert,DatoEndret,DatoSlettet,PlukklisteTypeID,Beskrivelse,AktivitetID,AnsvarligBrukerID,(SELECT CONCAT(Fornavn,' ',Etternavn) FROM Brukere b WHERE (b.BrukerID=p.AnsvarligBrukerID) LIMIT 1) AS AnsvarligBrukerNavn,StatusID FROM Plukklister p WHERE (PlukklisteID='".$PlukklisteID."') LIMIT 1");
      if ($rPlukkliste = $rPlukklister->row_array()) {
        $rPlukkliste['Status'] = $this->PlukklisteStatus[$rPlukkliste['StatusID']];
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
            $this->db->query("INSERT INTO PlukklisteXUtstyr (DatoRegistrert,UtstyrID,PlukklisteID,UtAntall) VALUES (Now(),'".$rUtstyr['UtstyrID']."',".$PlukklisteID.",1)");
	  }
	} else {
          $rXUtstyrsliste = $this->db->query("SELECT UtstyrID,UtAntall FROM PlukklisteXUtstyr WHERE (PlukklisteID=".$PlukklisteID.") AND (UtstyrID='".$rUtstyr['UtstyrID']."')");
          if ($rXUtstyrsliste->num_rows() == 0) {
            $this->db->query("INSERT INTO PlukklisteXUtstyr (DatoRegistrert,UtstyrID,PlukklisteID,UtAntall) VALUES (Now(),'".$rUtstyr['UtstyrID']."',".$PlukklisteID.",1)");
	  } else {
            $rXUtstyr = $rXUtstyrsliste->row_array();
            $this->db->query("UPDATE PlukklisteXUtstyr SET UtAntall=".($rXUtstyr['UtAntall']+1)." WHERE UtstyrID='".$rUtstyr['UtstyrID']."' AND PlukklisteID=".$PlukklisteID." LIMIT 1");
	  }
	}
	return true;
      } else {
        return false;
      }
    }

    function plukkliste_sjekkinnutstyr($PlukklisteID,$UtstyrID) {
      $rPlukklister = $this->db->query("SELECT PlukklisteID FROM Plukklister WHERE (PlukklisteID=".$PlukklisteID.") LIMIT 1");
      if ($rPlukkliste = $rPlukklister->row_array()) {
        $rXUtstyrsliste = $this->db->query("SELECT PlukklisteID,UtAntall,UtstyrID FROM PlukklisteXUtstyr WHERE (UtstyrID='".$UtstyrID."')");
	foreach ($rXUtstyrsliste->result_array() as $rXUtstyr) {
          $this->db->query("UPDATE PlukklisteXUtstyr SET InnAntall=".$rXUtstyr['UtAntall'].",DatoEndret=Now() WHERE PlukklisteID=".$rXUtstyr['PlukklisteID']." AND UtstyrID='".$rXUtstyr['UtstyrID']."' LIMIT 1");
	}
	$rPlukklisteUtstyr = $this->db->query("SELECT * FROM PlukklisteXUtstyr WHERE (PlukklisteID=".$rPlukkliste['PlukklisteID'].") AND (InnAntall != UtAntall)");
	if ($rPlukklisteUtstyr->num_rows() == 0) {
          $this->db->query("UPDATE Plukklister SET StatusID=3,DatoEndret=Now() WHERE PlukklisteID=".$rPlukkliste['PlukklisteID']." LIMIT 1");
	} else {
          $this->db->query("UPDATE Plukklister SET StatusID=2,DatoEndret=Now() WHERE PlukklisteID=".$rPlukkliste['PlukklisteID']." LIMIT 1");
	}
      }
    }

    function plukkliste_fjernutstyr($PlukklisteID,$UtstyrID) {
      $this->db->query("DELETE FROM PlukklisteXUtstyr WHERE UtstyrID='".$UtstyrID."' AND PlukklisteID=".$PlukklisteID);
    }

    function plukkliste_slett($PlukklisteID) {
      $this->db->query("UPDATE Plukklister SET DatoSlettet=Now() WHERE PlukklisteID='".$PlukklisteID."' LIMIT 1");
    }

    function utstyrsliste($PlukklisteID) {
      $sql = "SELECT x.UtstyrID,u.Beskrivelse,x.UtAntall,x.InnAntall,(SELECT COUNT(*) FROM Avvik a WHERE (a.UtstyrID=u.UtstyrID) AND (DatoSlettet Is Null)) AS AntallAvvik,u.ProdusentID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=u.ProdusentID)) AS ProdusentNavn FROM PlukklisteXUtstyr x LEFT JOIN Utstyr u ON (u.UtstyrID=x.UtstyrID) WHERE (x.PlukklisteID=".$PlukklisteID.") ORDER BY x.DatoRegistrert ASC";
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

    function utstyrx_info($UtstyrID) {
      $rUtstyrsliste = $this->db->query("SELECT UtstyrID,UtAntall,InnAntall,PlukklisteID FROM PlukklisteXUtstyr WHERE (UtstyrID='".$UtstyrID."') ORDER BY DatoRegistrert DESC LIMIT 1");
      if ($rUtstyr = $rUtstyrsliste->row_array()) {
       return $rUtstyr;
      } else {
        return false;
      }
    }


  }
?>

