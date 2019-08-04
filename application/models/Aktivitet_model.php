<?php
  class Aktivitet_model extends CI_Model {

    var $PlukklisteStatus = array(0 => 'Åpen', 1 => 'Låst/Utlevert', 2 => 'Låst/Delvis innlevert', 3 => 'Ferdig');
    var $PlukklisteTypeID = array(0 => 'Personlig', 1 => 'Standard');

    function aktiviteter($filter = null) {
      $sql = "SELECT AktivitetID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Notater,(SELECT COUNT(*) FROM Plukklister p WHERE (p.AktivitetID=a.AktivitetID) AND (StatusID<3)) AS PlukklisterAntall FROM Aktiviteter a WHERE (DatoSlettet Is Null)";
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
      $sql = "SELECT PlukklisteID,DatoRegistrert,DatoEndret,DatoSlettet,PlukklisteTypeID,Navn,AktivitetID,AnsvarligBrukerID,(SELECT Fornavn FROM Brukere b WHERE (b.BrukerID=p.AnsvarligBrukerID) LIMIT 1) AS AnsvarligBrukerNavn,(SELECT COUNT(*) FROM PlukklisteXMateriell x WHERE (x.PlukklisteID=p.PlukklisteID)) AS MateriellAntall,StatusID FROM Plukklister p WHERE (DatoSlettet Is Null)";
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
      $rPlukklister = $this->db->query("SELECT PlukklisteID,DatoRegistrert,DatoEndret,DatoSlettet,PlukklisteTypeID,Navn,AktivitetID,AnsvarligBrukerID,(SELECT CONCAT(Fornavn,' ',Etternavn) FROM Brukere b WHERE (b.BrukerID=p.AnsvarligBrukerID) LIMIT 1) AS AnsvarligBrukerNavn,StatusID FROM Plukklister p WHERE (PlukklisteID='".$PlukklisteID."') LIMIT 1");
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

    function plukkliste_leggtilmateriell($PlukklisteID,$MateriellID) {
      $rMaterielliste = $this->db->query("SELECT MateriellID FROM Materiell WHERE (MateriellID='".$MateriellID."') LIMIT 1");
      if ($rMateriell = $rMaterielliste->row_array()) {
        if (substr($rMateriell['MateriellID'],-1,1) != 'T') {
          $rXMaterielliste = $this->db->query("SELECT MateriellID FROM PlukklisteXMateriell WHERE (PlukklisteID=".$PlukklisteID.") AND (MateriellID='".$rMateriell['MateriellID']."')");
	  if ($rXMaterielliste->num_rows() == 0) {
            $this->db->query("INSERT INTO PlukklisteXMateriell (DatoRegistrert,MateriellID,PlukklisteID,UtAntall) VALUES (Now(),'".$rMateriell['MateriellID']."',".$PlukklisteID.",1)");
	  }
	} else {
          $rXMaterielliste = $this->db->query("SELECT MateriellID,UtAntall FROM PlukklisteXMateriell WHERE (PlukklisteID=".$PlukklisteID.") AND (MateriellID='".$rMateriell['MateriellID']."')");
          if ($rXMaterielliste->num_rows() == 0) {
            $this->db->query("INSERT INTO PlukklisteXMateriell (DatoRegistrert,MateriellID,PlukklisteID,UtAntall) VALUES (Now(),'".$rMateriell['MateriellID']."',".$PlukklisteID.",1)");
	  } else {
            $rXMateriell = $rXMaterielliste->row_array();
            $this->db->query("UPDATE PlukklisteXMateriell SET UtAntall=".($rXMateriell['UtAntall']+1)." WHERE MateriellID='".$rMateriell['MateriellID']."' AND PlukklisteID=".$PlukklisteID." LIMIT 1");
	  }
	}
	return true;
      } else {
        return false;
      }
    }

    function plukkliste_sjekkinnmateriell($PlukklisteID,$MateriellID) {
      $rPlukklister = $this->db->query("SELECT PlukklisteID FROM Plukklister WHERE (PlukklisteID=".$PlukklisteID.") LIMIT 1");
      if ($rPlukkliste = $rPlukklister->row_array()) {
        $rXMaterielliste = $this->db->query("SELECT PlukklisteID,UtAntall,MateriellID FROM PlukklisteXMateriell WHERE (MateriellID='".$MateriellID."')");
	foreach ($rXMaterielliste->result_array() as $rXMateriell) {
          $this->db->query("UPDATE PlukklisteXMateriell SET InnAntall=".$rXMateriell['UtAntall'].",DatoEndret=Now() WHERE PlukklisteID=".$rXMateriell['PlukklisteID']." AND MateriellID='".$rXMateriell['MateriellID']."' LIMIT 1");
	}
	$rPlukklisteMateriell = $this->db->query("SELECT * FROM PlukklisteXMateriell WHERE (PlukklisteID=".$rPlukkliste['PlukklisteID'].") AND (InnAntall != UtAntall)");
	if ($rPlukklisteMateriell->num_rows() == 0) {
          $this->db->query("UPDATE Plukklister SET StatusID=3,DatoEndret=Now() WHERE PlukklisteID=".$rPlukkliste['PlukklisteID']." LIMIT 1");
	} else {
          $this->db->query("UPDATE Plukklister SET StatusID=2,DatoEndret=Now() WHERE PlukklisteID=".$rPlukkliste['PlukklisteID']." LIMIT 1");
	}
      }
    }

    function plukkliste_fjernmateriell($PlukklisteID,$MateriellID) {
      $this->db->query("DELETE FROM PlukklisteXMateriell WHERE MateriellID='".$MateriellID."' AND PlukklisteID=".$PlukklisteID);
    }

    function plukkliste_slett($PlukklisteID) {
      $this->db->query("UPDATE Plukklister SET DatoSlettet=Now() WHERE PlukklisteID='".$PlukklisteID."' LIMIT 1");
    }

    function materielliste($PlukklisteID) {
      $sql = "SELECT x.MateriellID,m.Beskrivelse,x.UtAntall,x.InnAntall,(SELECT COUNT(*) FROM Avvik a WHERE (a.MateriellID=m.MateriellID) AND (DatoSlettet Is Null)) AS AntallAvvik,m.ProdusentID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=m.ProdusentID)) AS ProdusentNavn FROM PlukklisteXMateriell x LEFT JOIN Materiell m ON (m.MateriellID=x.MateriellID) WHERE (x.PlukklisteID=".$PlukklisteID.") ORDER BY x.DatoRegistrert ASC";
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

