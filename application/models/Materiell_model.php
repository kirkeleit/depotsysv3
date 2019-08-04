<?php
  class Materiell_model extends CI_Model {

    function materielliste($filter = null) {
      $sql = "SELECT MateriellID,m.DatoRegistrert,StatusID,m.DatoEndret,m.DatoSlettet,LokasjonID,(SELECT CONCAT('+',Kode,' ',Navn) FROM Lokasjoner l WHERE (l.LokasjonID=m.LokasjonID) LIMIT 1) AS Lokasjon,KasseID,(SELECT CONCAT('=',Kode,' ',Navn) FROM Kasser ka WHERE (ka.KasseID=m.KasseID) LIMIT 1) AS Kasse,m.Beskrivelse,AntallMin,ProdusentID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=m.ProdusentID)) AS ProdusentNavn,(SELECT DatoRegistrert FROM Kontroller l WHERE l.MateriellID=m.MateriellID ORDER BY DatoRegistrert DESC LIMIT 1) AS DatoKontrollert,(SELECT DatoRegistrert FROM Lagerendringer l WHERE (l.MateriellID=m.MateriellID) AND (EndringTypeID=1) ORDER BY DatoRegistrert DESC LIMIT 1) AS DatoTelling,(SELECT COUNT(*) FROM Avvik a WHERE (a.MateriellID=m.MateriellID) AND (StatusID<2) AND (DatoSlettet Is Null)) AS AntallAvvik,(SELECT SUM(Antall) FROM Lagerendringer l WHERE (l.MateriellID=m.MateriellID)) AS Antall FROM Materiell m WHERE (m.DatoSlettet Is Null)";
      if (isset($filter['FilterMaterielltype'])) {
        $sql .= " AND (MateriellID Like '".$filter['FilterMaterielltype']."%')";
      }
      if (isset($filter['FilterProdusentID'])) {
        $sql .= " AND (ProdusentID='".$filter['FilterProdusentID']."')";
      }
      if (isset($filter['FilterLokasjonID'])) {
        $sql .= " AND (LokasjonID='".$filter['FilterLokasjonID']."')";
      }
      if (isset($filter['FilterKasseID'])) {
        $sql .= " AND (KasseID='".$filter['FilterKasseID']."')";
      }
      if (isset($filter['FilterBatteritypeID'])) {
        $sql .= " AND (BatteritypeID='".$filter['FilterBatteritypeID']."')";
      }
      if (isset($filter['FilterStatusID'])) {
        $sql .= " AND (StatusID=".$filter['FilterStatusID'].")";
      }
      if (isset($filter['FilterForbruksmateriell'])) {
        if ($filter['FilterForbruksmateriell'] == 1) {
          $sql .= " AND (MateriellID Like '%T')";
	} else {
          $sql .= " AND (MateriellID Not Like '%T')";
	}
      }
      $sql .= " ORDER BY MateriellID ASC";
      $rMaterielliste = $this->db->query($sql);
      foreach ($rMaterielliste->result_array() as $rMateriell) {
        $rPlukklister = $this->db->query("SELECT * FROM PlukklisteXMateriell u LEFT JOIN Plukklister p ON (u.PlukklisteID=p.PlukklisteID) WHERE (u.MateriellID='".$rMateriell['MateriellID']."') AND (u.UtAntall > u.InnAntall) AND (p.StatusID>0)");
        if ($rPlukklister->num_rows() > 0) {
          $rMateriell['StatusID'] = 2;
        }
        if (!is_numeric($rMateriell['Antall'])) {
          $rMateriell['Antall'] = 0;
	}
	$rMaterielltyper = $this->db->query("SELECT KontrollDager,AnsvarligRolleID FROM Materielltyper WHERE (Kode='".substr($rMateriell['MateriellID'],0,2)."') LIMIT 1");
	if ($rMaterielltype = $rMaterielltyper->row_array()) {
          $rMateriell['KontrollDager'] = $rMaterielltype['KontrollDager'];
          $rMateriell['AnsvarligRolleID'] = $rMaterielltype['AnsvarligRolleID'];
	} else {
          $rMateriell['KontrollDager'] = 0;
          $rMateriell['AnsvarligRolleID'] = 0;
	}
        $Materielliste[] = $rMateriell;
        unset($rMateriell);
      }
      unset($rMaterielliste);
      if (isset($Materielliste)) {
        return $Materielliste;
      }
    }

    function nyttmateriellid($MaterielltypeID) {
      $rMaterielliste = $this->db->query("SELECT * FROM Materiell WHERE (MateriellID Like CONCAT('".$MaterielltypeID."','%')) ORDER BY MateriellID DESC");
      if ($rMaterielliste->num_rows() == 0) {
        return $MaterielltypeID.'001';
      } else {
        $rMateriell = $rMaterielliste->row_array();
        //return substr($rkomponent['KomponentID'],2);
        return $MaterielltypeID.str_pad((substr($rMateriell['MateriellID'],2)+1),3,'0',STR_PAD_LEFT);
      }
    }

    function materiell_info($MateriellID = null) {
      $rMaterielliste = $this->db->query("SELECT MateriellID,DatoRegistrert,DatoEndret,DatoSlettet,StatusID,LokasjonID,(SELECT CONCAT('+',Kode,' ',Navn) FROM Lokasjoner l WHERE (l.LokasjonID=m.LokasjonID) LIMIT 1) AS Lokasjon,KasseID,(SELECT CONCAT('=',Kode,' ',Navn) FROM Kasser k WHERE (k.KasseID=m.KasseID) LIMIT 1) AS Kasse,Beskrivelse,ProdusentID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=m.ProdusentID) LIMIT 1) AS ProdusentNavn,Notater,(SELECT SUM(Antall) FROM Lagerendringer le WHERE (le.MateriellID=m.MateriellID)) AS Antall,AntallMin,BatteritypeID,BatteriAntall FROM Materiell m WHERE (MateriellID='".$MateriellID."') LIMIT 1");
      if ($rMateriell = $rMaterielliste->row_array()) {
	return $rMateriell;
      }
    }

    function materiell_lagre($MateriellID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($MateriellID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Materiell',$data));
        //$data['KomponentID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Materiell',$data,"MateriellID='".$MateriellID."'"));
        $data['MateriellID'] = $MateriellID;
      }
      return $data;
    }

    function materiell_lagerlagre($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['BrukerID'] = $_SESSION['BrukerID'];
      $this->db->query($this->db->insert_string('Utstyrslager',$data));
      return true;
    }

    function materiell_slett($MateriellID) {
      $this->db->query("UPDATE Materiell SET DatoSlettet=Now() WHERE MateriellID='".$MateriellID."' LIMIT 1");
    }


    function materielltyper() {
      $rMaterielltyper = $this->db->query("SELECT MaterielltypeID,DatoRegistrert,DatoEndret,DatoSlettet,Kode,Navn,(SELECT COUNT(*) FROM Materiell m WHERE (m.MateriellID Like CONCAT(mt.Kode,'%'))) AS AntallMateriell,AnsvarligRolleID,(SELECT Navn FROM Roller r WHERE (r.RolleID=mt.AnsvarligRolleID) LIMIT 1) AS AnsvarligRolle,KontrollDager FROM Materielltyper mt WHERE (DatoSlettet Is Null) ORDER BY Kode ASC");
      foreach ($rMaterielltyper->result_array() as $rMaterielltype) {
        $Materielltyper[] = $rMaterielltype;
        unset($rMaterielltype);
      }
      unset($rMaterielltyper);
      if (isset($Materielltyper)) {
        return $Materielltyper;
      }
    }

    function materielltype_info($MaterielltypeID = null) {
      if (is_numeric($MaterielltypeID)) {
        $rMaterielltyper = $this->db->query("SELECT MaterielltypeID,DatoRegistrert,DatoEndret,DatoSlettet,Kode,Navn,AnsvarligRolleID,KontrollDager,KontrollPunkter,Notater FROM Materielltyper WHERE (MaterielltypeID='".$MaterielltypeID."') LIMIT 1");
      } else {
        $rMaterielltyper = $this->db->query("SELECT MaterielltypeID,DatoRegistrert,DatoEndret,DatoSlettet,Kode,Navn,AnsvarligRolleID,KontrollDager,KontrollPunkter,Notater FROM Materielltyper WHERE (Kode='".$MaterielltypeID."') LIMIT 1");
      }
      if ($rMaterielltype = $rMaterielltyper->row_array()) {
        return $rMaterielltype;
      } else {
        return false;
      }
    }

    function materielltype_opprett($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['DatoEndret'] = $data['DatoRegistrert'];
      if ($this->db->query($this->db->insert_string('Materielltyper',$data))) {
        $MaterielltypeID = $this->db->insert_id();
        return $MaterielltypeID;
      } else {
        return false;
      }
    }

    function materielltype_lagre($MaterielltypeID = null,$data) {
      if ($MaterielltypeID != null) {
        $data['DatoEndret'] = date('Y-m-d H:i:s');
	if ($this->db->query($this->db->update_string('Materielltyper',$data,'MaterielltypeID='.$MaterielltypeID))) {
          return $MaterielltypeID;
	} else {
          return false;
	}
      }
    }

    function materielltype_slett($MaterielltypeID = null) {
      if ($MaterielltypeID != null) {
        $this->db->query("UPDATE Materielltyper SET DatoSlettet=Now() WHERE MaterielltypeID='".$MaterielltypeID."' LIMIT 1");
        if ($this->db->affected_rows() > 0) {
          return true;
        } else {
          return false;
        }
      }
    }


    function produsenter() {
      $rProdusenter = $this->db->query("SELECT ProdusentID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Nettsted,(SELECT COUNT(*) FROM Materiell m WHERE (m.ProdusentID=p.ProdusentID)) AS MateriellAntall FROM Produsenter p WHERE (DatoSlettet Is Null) ORDER BY Navn ASC");
      foreach ($rProdusenter->result_array() as $rProdusent) {
        $Produsenter[] = $rProdusent;
        unset($rProdusent);
      }
      unset($rProdusenter);
      if (isset($Produsenter)) {
        return $Produsenter;
      }
    }

    function produsent_info($ProdusentID = null) {
      $rProdusenter = $this->db->query("SELECT ProdusentID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Nettsted,Notater FROM Produsenter WHERE (ProdusentID='".$ProdusentID."') LIMIT 1");
      if ($rProdusent = $rProdusenter->row_array()) {
        return $rProdusent;
      }
    }

    function produsent_opprett($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['DatoEndret'] = $data['DatoRegistrert'];
      if ($this->db->query($this->db->insert_string('Produsenter',$data))) {
        $ProdusentID = $this->db->insert_id();
        return $ProdusentID;
      } else {
        return false;
      }
    }

    function produsent_lagre($ProdusentID = null,$data) {
      if ($ProdusentID != null) {
        $data['DatoEndret'] = date('Y-m-d H:i:s');
	if ($this->db->query($this->db->update_string('Produsenter',$data,'ProdusentID='.$ProdusentID))) {
          return $ProdusentID;
	} else {
          return false;
	}
      }
    }

    function produsent_slett($ProdusentID = null) {
      if ($ProdusentID != null) {
        $this->db->query("UPDATE Materiell SET ProdusentID=0 WHERE ProdusentID=".$ProdusentID);
        $this->db->query("UPDATE Produsenter SET DatoSlettet=Now() WHERE ProdusentID='".$ProdusentID."' LIMIT 1");
        if ($this->db->affected_rows() > 0) {
          return true;
        } else {
          return false;
        }
      }
    }


    function lokasjoner() {
      $rLokasjoner = $this->db->query("SELECT LokasjonID,DatoRegistrert,DatoEndret,DatoSlettet,Kode,Navn,(SELECT COUNT(*) FROM Kasser ka WHERE (ka.LokasjonID=l.LokasjonID)) AS KasserAntall,(SELECT COUNT(*) FROM Materiell m WHERE (m.LokasjonID=l.LokasjonID)) AS MateriellAntall FROM Lokasjoner l WHERE (DatoSlettet Is Null) ORDER BY Kode ASC");
      foreach ($rLokasjoner->result_array() as $rLokasjon) {
        $Lokasjoner[] = $rLokasjon;
        unset($rLokasjon);
      }
      unset($rLokasjoner);
      if (isset($Lokasjoner)) {
        return $Lokasjoner;
      }
    }

    function lokasjon_info($LokasjonID = null) {
      $rLokasjoner = $this->db->query("SELECT LokasjonID,DatoRegistrert,DatoEndret,DatoSlettet,Kode,Navn,Notater FROM Lokasjoner WHERE (LokasjonID='".$LokasjonID."') LIMIT 1");
      if ($rLokasjon = $rLokasjoner->row_array()) {
        return $rLokasjon;
      }
    }

    function lokasjon_opprett($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['DatoEndret'] = $data['DatoRegistrert'];
      if ($this->db->query($this->db->insert_string('Lokasjoner',$data))) {
        $LokasjonID = $this->db->insert_id();
        return $LokasjonID;
      } else {
        return false;
      }
    }

    function lokasjon_lagre($LokasjonID = null,$data) {
      if ($LokasjonID != null) {
        $data['DatoEndret'] = date('Y-m-d H:i:s');
        unset($data['Kode']);
        if ($this->db->query($this->db->update_string('Lokasjoner',$data,'LokasjonID='.$LokasjonID))) {
          return $LokasjonID;
        } else {
          return false;
        }
      }
    }

    function lokasjon_slett($LokasjonID = null) {
      if ($LokasjonID != null) {
        $this->db->query("UPDATE Utstyr SET LokasjonID=0 WHERE LokasjonID=".$LokasjonID);
        $this->db->query("UPDATE Kasser SET LokasjonID=0 WHERE LokasjonID=".$LokasjonID);
        $this->db->query("UPDATE Lokasjoner SET DatoSlettet=Now() WHERE LokasjonID='".$LokasjonID."' LIMIT 1");
        if ($this->db->affected_rows() > 0) {
          return true;
	} else {
          return false;
        }
      }
    }


    function kasser($filter = null) {
      $sql = "SELECT KasseID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,(SELECT CONCAT('+',Kode,' ',Navn) FROM Lokasjoner l WHERE (l.LokasjonID=ka.LokasjonID) LIMIT 1) AS Lokasjon,Kode,Navn,(SELECT COUNT(*) FROM Materiell m WHERE (m.KasseID=ka.KasseID)) AS MateriellAntall FROM Kasser ka WHERE (DatoSlettet Is Null)";
      if (isset($filter['FilterLokasjonID'])) {
        $sql .= " AND (LokasjonID='".$filter['FilterLokasjonID']."')";
      }
      $sql .= " ORDER BY Kode ASC";
      $rKasser = $this->db->query($sql);
      foreach ($rKasser->result_array() as $rKasse) {
        $Kasser[] = $rKasse;
        unset($rKasse);
      }
      unset($rKasser);
      if (isset($Kasser)) {
        return $Kasser;
      }
    }

    function kasse_info($KasseID = null) {
      $rKasser = $this->db->query("SELECT KasseID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,Kode,Navn,Notater FROM Kasser WHERE (KasseID='".$KasseID."') LIMIT 1");
      if ($rKasse = $rKasser->row_array()) {
        return $rKasse;
      }
    }

    function kasse_opprett($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['DatoEndret'] = $data['DatoRegistrert'];
      if ($this->db->query($this->db->insert_string('Kasser',$data))) {
        $KasseID = $this->db->insert_id();
	return $KasseID;
      } else {
        return false;
      }
    }

    function kasse_lagre($KasseID = null,$data) {
      if ($KasseID != null) {
        $data['DatoEndret'] = date('Y-m-d H:i:s');
        unset($data['Kode']);
        if ($this->db->query($this->db->update_string('Kasser',$data,'KasseID='.$KasseID))) {
          return $KasseID;
	} else {
          return false;
	}
      }
    }

    function kasse_slett($KasseID = null) {
      if ($KasseID != null) {
        $this->db->query("UPDATE Utstyr SET KasseID=0 WHERE KasseID=".$KasseID);
        $this->db->query("UPDATE Kasser SET DatoSlettet=Now() WHERE KasseID='".$KasseID."' LIMIT 1");
        if ($this->db->affected_rows() > 0) {
          return true;
        } else {
          return false;
        }
      }
    }

    function batterityper() {
      $rBatterityper = $this->db->query("SELECT BatteritypeID,Type,Navn,(SELECT COUNT(*) FROM Materiell m WHERE (m.BatteritypeID=b.BatteritypeID)) AS MateriellAntall,(SELECT SUM(BatteriAntall) FROM Materiell m WHERE (m.BatteritypeID=b.BatteritypeID)) AS BehovAntall FROM Batterityper b ORDER BY Type ASC");
      foreach ($rBatterityper->result_array() as $rBatteritype) {
        $Batterityper[] = $rBatteritype;
        unset($rBatteritype);
      }
      unset($rBatterityper);
      if (isset($Batterityper)) {
        return $Batterityper;
      }
    }

    function batteritype_info($BatteritypeID = null) {
      $rBatterityper = $this->db->query("SELECT BatteritypeID,Type,Navn,Notater FROM Batterityper b WHERE (BatteritypeID='".$BatteritypeID."') LIMIT 1");
      if ($rBatteritype = $rBatterityper->row_array()) {
        return $rBatteritype;
      }
    }

    function batteritype_slett($BatteritypeID = null) {
      if ($BatteritypeID != null) {
        $this->db->query("UPDATE Utstyr SET BatteritypeID=0 WHERE BatteritypeID=".$BatteritypeID);
        $this->db->query("DELETE FROM Batterityper WHERE BatteritypeID=".$BatteritypeID." LIMIT 1");
        if ($this->db->affected_rows() > 0) {
          return true;
        } else {
          return false;
        }
      }
    }

  }
?>

