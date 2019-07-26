<?php
  class Utstyr_model extends CI_Model {

    function utstyrsliste($filter = null) {
      $sql = "SELECT UtstyrID,u.DatoRegistrert,u.DatoEndret,u.DatoSlettet,LokasjonID,(SELECT CONCAT('+',Kode,' ',Navn) FROM Lokasjoner l WHERE (l.LokasjonID=u.LokasjonID) LIMIT 1) AS Lokasjon,KasseID,(SELECT CONCAT('=',Kode,' ',Navn) FROM Kasser ka WHERE (ka.KasseID=u.KasseID) LIMIT 1) AS Kasse,u.Beskrivelse,AntallMin,ProdusentID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=u.ProdusentID)) AS ProdusentNavn,(SELECT DatoRegistrert FROM Kontrollogg l WHERE l.UtstyrID=u.UtstyrID ORDER BY DatoRegistrert DESC LIMIT 1) AS DatoKontrollert,(SELECT COUNT(*) FROM Avvik a WHERE (a.UtstyrID=u.UtstyrID) AND (StatusID<2) AND (DatoSlettet Is Null)) AS AntallAvvik,(SELECT SUM(Antall) FROM Utstyrslager l WHERE (l.UtstyrID=u.UtstyrID)) AS Antall FROM Utstyr u WHERE (u.DatoSlettet Is Null)";
      if (isset($filter['FilterUtstyrstype'])) {
        $sql .= " AND (UtstyrID Like '".$filter['FilterUtstyrstype']."%')";
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
      if (isset($filter['FilterForbruksmateriell'])) {
        if ($filter['FilterForbruksmateriell'] == 1) {
          $sql .= " AND (UtstyrID Like '%T')";
	} else {
          $sql .= " AND (UtstyrID Not Like '%T')";
	}
      }
      $sql .= " ORDER BY UtstyrID ASC";
      $rUtstyrsliste = $this->db->query($sql);
      foreach ($rUtstyrsliste->result_array() as $rUtstyr) {
        if (!is_numeric($rUtstyr['Antall'])) {
          $rUtstyr['Antall'] = 0;
	}
	$rUtstyrstyper = $this->db->query("SELECT KontrollDager,AnsvarligRolleID FROM Utstyrstyper WHERE (UtstyrstypeID='".substr($rUtstyr['UtstyrID'],0,2)."') LIMIT 1");
	if ($rUtstyrstype = $rUtstyrstyper->row_array()) {
          $rUtstyr['KontrollDager'] = $rUtstyrstype['KontrollDager'];
          $rUtstyr['AnsvarligRolleID'] = $rUtstyrstype['AnsvarligRolleID'];
	} else {
          $rUtstyr['KontrollDager'] = 0;
          $rUtstyr['AnsvarligRolleID'] = 0;
	}
        $Utstyrsliste[] = $rUtstyr;
        unset($rUtstyr);
      }
      unset($rUtstyrsliste);
      unset($rutstyrsliste);
      if (isset($Utstyrsliste)) {
        return $Utstyrsliste;
      }
    }

    function nyttutstyrid($UtstyrstypeID) {
      $rutstyrsliste = $this->db->query("SELECT * FROM Utstyr WHERE (UtstyrID Like CONCAT('".$UtstyrstypeID."','%')) ORDER BY UtstyrID DESC");
      if ($rutstyrsliste->num_rows() == 0) {
        return $UtstyrstypeID.'001';
      } else {
        $rutstyr = $rutstyrsliste->row_array();
        //return substr($rkomponent['KomponentID'],2);
        return $UtstyrstypeID.str_pad((substr($rutstyr['UtstyrID'],2)+1),3,'0',STR_PAD_LEFT);
      }
    }

    function utstyr_info($UtstyrID = null) {
      $rutstyrsliste = $this->db->query("SELECT UtstyrID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,KasseID,Beskrivelse,ProdusentID,Notater,AntallMin,BatteriType,BatteriAntall FROM Utstyr WHERE (UtstyrID='".$UtstyrID."') LIMIT 1");
      if ($rutstyr = $rutstyrsliste->row_array()) {
	return $rutstyr;
      }
    }

    function utstyr_lagre($UtstyrID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($UtstyrID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Utstyr',$data));
        //$data['KomponentID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Utstyr',$data,"UtstyrID='".$UtstyrID."'"));
        $data['UtstyrID'] = $UtstyrID;
      }
      if ($this->db->affected_rows() > 0) {
        //$this->session->set_flashdata('Infomelding','Lagerplassen "" ble vellykket oppdatert!');
      }
      return $data;
    }

    function utstyr_lagerlagre($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['BrukerID'] = $_SESSION['BrukerID'];
      $this->db->query($this->db->insert_string('Utstyrslager',$data));
      return true;
    }

    function utstyr_slett($UtstyrID) {
      $this->db->query("UPDATE Utstyr SET DatoSlettet=Now() WHERE UtstyrID='".$UtstyrID."' LIMIT 1");
    }


    function utstyrstyper() {
      $rUtstyrstyper = $this->db->query("SELECT UtstyrstypeID,DatoRegistrert,DatoEndret,DatoSlettet,Kode,Navn,(SELECT COUNT(*) FROM Utstyr u WHERE (u.UtstyrID Like CONCAT(ut.Kode,'%'))) AS AntallUtstyr,AnsvarligRolleID,(SELECT Navn FROM Roller r WHERE (r.RolleID=ut.AnsvarligRolleID) LIMIT 1) AS AnsvarligRolle,KontrollDager FROM Utstyrstyper ut WHERE (DatoSlettet Is Null) ORDER BY Kode ASC");
      foreach ($rUtstyrstyper->result_array() as $rUtstyrstype) {
        $Utstyrstyper[] = $rUtstyrstype;
        unset($rutstyrstype);
      }
      unset($rUtstyrstyper);
      if (isset($Utstyrstyper)) {
        return $Utstyrstyper;
      }
    }

    function utstyrstype_info($UtstyrstypeID = null) {
      $rUtstyrstyper = $this->db->query("SELECT UtstyrstypeID,DatoRegistrert,DatoEndret,DatoSlettet,Kode,Navn,AnsvarligRolleID,KontrollDager,Notater FROM Utstyrstyper WHERE (UtstyrstypeID='".$UtstyrstypeID."') LIMIT 1");
      if ($rUtstyrstype = $rUtstyrstyper->row_array()) {
        return $rUtstyrstype;
      } else {
        return false;
      }
    }

    function utstyrstype_opprett($data) {
      $data['DatoRegistrert'] = date('Y-m-d H:i:s');
      $data['DatoEndret'] = $data['DatoRegistrert'];
      if ($this->db->query($this->db->insert_string('Utstyrstyper',$data))) {
        $UtstyrstypeID = $this->db->insert_id();
        return $UtstyrstypeID;
      } else {
        return false;
      }
    }

    function utstyrstype_lagre($UtstyrstypeID = null,$data) {
      if ($UtstyrstypeID != null) {
        $data['DatoEndret'] = date('Y-m-d H:i:s');
	if ($this->db->query($this->db->update_string('Utstyrstyper',$data,'UtstyrstypeID='.$UtstyrstypeID))) {
          return $UtstyrstypeID;
	} else {
          return false;
	}
      }
    }

    function utstyrstype_slett($UtstyrstypeID = null) {
      if ($UtstyrstypeID != null) {
        $this->db->query("UPDATE Utstyrstyper SET DatoSlettet=Now() WHERE UtstyrstypeID='".$UtstyrstypeID."' LIMIT 1");
        if ($this->db->affected_rows() > 0) {
          return true;
        } else {
          return false;
        }
      }
    }


    function produsenter() {
      $rProdusenter = $this->db->query("SELECT ProdusentID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Nettsted,(SELECT COUNT(*) FROM Utstyr u WHERE (u.ProdusentID=p.ProdusentID)) AS UtstyrAntall FROM Produsenter p WHERE (DatoSlettet Is Null) ORDER BY Navn ASC");
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
        $this->db->query("UPDATE Utstyr SET ProdusentID=0 WHERE ProdusentID=".$ProdusentID);
        $this->db->query("UPDATE Produsenter SET DatoSlettet=Now() WHERE ProdusentID='".$ProdusentID."' LIMIT 1");
        if ($this->db->affected_rows() > 0) {
          return true;
        } else {
          return false;
        }
      }
    }


    function lokasjoner() {
      $rLokasjoner = $this->db->query("SELECT LokasjonID,DatoRegistrert,DatoEndret,DatoSlettet,Kode,Navn,(SELECT COUNT(*) FROM Kasser ka WHERE (ka.LokasjonID=l.LokasjonID)) AS KasserAntall,(SELECT COUNT(*) FROM Utstyr u WHERE (u.LokasjonID=l.LokasjonID)) AS UtstyrAntall FROM Lokasjoner l WHERE (DatoSlettet Is Null) ORDER BY Kode ASC");
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
      $sql = "SELECT KasseID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,(SELECT CONCAT('+',Kode,' ',Navn) FROM Lokasjoner l WHERE (l.LokasjonID=ka.LokasjonID) LIMIT 1) AS Lokasjon,Kode,Navn,(SELECT COUNT(*) FROM Utstyr u WHERE (u.KasseID=ka.KasseID)) AS UtstyrAntall FROM Kasser ka WHERE (DatoSlettet Is Null)";
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

  }
?>

