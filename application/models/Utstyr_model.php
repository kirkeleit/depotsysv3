<?php
  class Utstyr_model extends CI_Model {

    function utstyrsliste($filter = null) {
      $sql = "SELECT UtstyrID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,KasseID,Beskrivelse,ProdusentID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=u.ProdusentID)) AS ProdusentNavn,(SELECT DatoRegistrert FROM Kontrollogg l WHERE l.UtstyrID=u.UtstyrID ORDER BY DatoRegistrert DESC LIMIT 1) AS DatoKontrollert,Antall,(SELECT COUNT(*) FROM Avvik a WHERE (a.UtstyrID=u.UtstyrID) AND (StatusID<2) AND (DatoSlettet Is Null)) AS AntallAvvik FROM Utstyr u WHERE (DatoSlettet Is Null)";
      if (isset($filter['FilterUtstyrstypeID'])) {
        $sql .= " AND (UtstyrID Like '".$filter['FilterUtstyrstypeID']."%')";
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
      $sql .= " ORDER BY UtstyrID ASC";
      $rutstyrsliste = $this->db->query($sql);
      foreach ($rutstyrsliste->result_array() as $rutstyr) {
        $Utstyrsliste[] = $rutstyr;
        unset($rutstyr);
      }
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
      $rutstyrsliste = $this->db->query("SELECT UtstyrID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,KasseID,Beskrivelse,ProdusentID,Notater FROM Utstyr WHERE (UtstyrID='".$UtstyrID."') LIMIT 1");
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

    function utstyr_slett($UtstyrID) {
      $this->db->query("UPDATE Utstyr SET DatoSlettet=Now() WHERE UtstyrID='".$UtstyrID."' LIMIT 1");
    }


    function utstyrstyper() {
      $rutstyrstyper = $this->db->query("SELECT UtstyrstypeID,DatoRegistrert,DatoEndret,DatoSlettet,Beskrivelse,(SELECT COUNT(*) FROM Utstyr u WHERE (u.UtstyrID Like CONCAT(ut.UtstyrstypeID,'%'))) AS AntallUtstyr FROM Utstyrstyper ut WHERE (DatoSlettet Is Null) ORDER BY UtstyrstypeID ASC");
      foreach ($rutstyrstyper->result_array() as $rutstyrstype) {
        $Utstyrstyper[] = $rutstyrstype;
        unset($rutstyrstype);
      }
      unset($rutstyrstyper);
      if (isset($Utstyrstyper)) {
        return $Utstyrstyper;
      }
    }

    function utstyrstype_info($UtstyrstypeID = null) {
      $rutstyrstyper = $this->db->query("SELECT UtstyrstypeID,DatoRegistrert,DatoEndret,DatoSlettet,Beskrivelse,Notater FROM Utstyrstyper WHERE (UtstyrstypeID='".$UtstyrstypeID."') LIMIT 1");
      if ($rutstyrstype = $rutstyrstyper->row_array()) {
        return $rutstyrstype;
      }
    }

    function utstyrstype_lagre($UtstyrstypeID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($UtstyrstypeID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Utstyrstyper',$data));
        $data['UtstyrstypeID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Utstyrstyper',$data,"UtstyrstypeID='".$UtstyrstypeID."'"));
        $data['UtstyrstypeID'] = $UtstyrstypeID;
      }
      if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('Infomelding','Komponenttype '.$data['KomponenttypeID'].' ble lagret.');
      }
      return $data;
    }

    function utstyrstype_slett($UtstyrstypeID) {
      $this->db->query("UPDATE Utstyrstyper SET DatoSlettet=Now() WHERE UtstyrstypeID='".$UtstyrstypeID."' LIMIT 1");
    }


    function produsenter() {
      $rprodusenter = $this->db->query("SELECT ProdusentID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Nettsted,(SELECT COUNT(*) FROM Utstyr u WHERE (u.ProdusentID=p.ProdusentID)) AS UtstyrAntall FROM Produsenter p WHERE (DatoSlettet Is Null) ORDER BY Navn ASC");
      foreach ($rprodusenter->result_array() as $rprodusent) {
        $produsenter[] = $rprodusent;
        unset($rprodusent);
      }
      if (isset($produsenter)) {
        return $produsenter;
      }
    }

    function produsent_info($ProdusentID = null) {
      $rprodusenter = $this->db->query("SELECT ProdusentID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Nettsted,Notater FROM Produsenter WHERE (ProdusentID='".$ProdusentID."')");
      if ($rprodusent = $rprodusenter->row_array()) {
        return $rprodusent;
      }
    }

    function produsent_lagre($ProdusentID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ProdusentID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Produsenter',$data));
        $data['ProdusentID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Produsenter',$data,"ProdusentID='".$ProdusentID."'"));
        $data['ProdusentID'] = $ProdusentID;
      }
      if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('Infomelding','Produsent '.$data['Navn'].' ble lagret.');
      }
      return $data;
    }

    function produsent_slett($ProdusentID) {
      $this->db->query("UPDATE Produsenter SET DatoSlettet=Now() WHERE ProdusentID='".$ProdusentID."' LIMIT 1");
    }


    function lokasjoner() {
      $rlokasjoner = $this->db->query("SELECT LokasjonID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,(SELECT COUNT(*) FROM Kasser ka WHERE (ka.LokasjonID=l.LokasjonID)) AS KasserAntall,(SELECT COUNT(*) FROM Utstyr u WHERE (u.LokasjonID=l.LokasjonID)) AS UtstyrAntall FROM Lokasjoner l WHERE (DatoSlettet Is Null) ORDER BY LokasjonID ASC");
      foreach ($rlokasjoner->result_array() as $rlokasjon) {
        $lokasjoner[] = $rlokasjon;
        unset($rlokasjon);
      }
      if (isset($lokasjoner)) {
        return $lokasjoner;
      }
    }

    function lokasjon_info($LokasjonID = null) {
      $rlokasjoner = $this->db->query("SELECT LokasjonID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Notater FROM Lokasjoner WHERE (LokasjonID='".$LokasjonID."') LIMIT 1");
      if ($rlokasjon = $rlokasjoner->row_array()) {
        return $rlokasjon;
      }
    }

    function lokasjon_lagre($LokasjonID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($LokasjonID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Lokasjoner',$data));
      } else {
        $this->db->query($this->db->update_string('Lokasjoner',$data,"LokasjonID='".$LokasjonID."'"));
        $data['LokasjonID'] = $LokasjonID;
      }
      if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('Infomelding','Lokasjon +'.$data['LokasjonID'].' ble vellykket lagret.');
      } else {
        $this->session->set_flashdata('Feilmelding','En feil oppstod. Feilmelding: '.$this->db->error());
      }
      return $data;
    }

    function lokasjon_slett($LokasjonID) {
      $this->db->query("UPDATE Lokasjoner SET DatoSlettet=Now() WHERE LokasjonID='".$LokasjonID."' LIMIT 1");
    }


    function kasser() {
      $rkasser = $this->db->query("SELECT KasseID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,Navn,(SELECT COUNT(*) FROM Utstyr u WHERE (u.KasseID=ka.KasseID)) AS UtstyrAntall FROM Kasser ka WHERE (DatoSlettet Is Null) ORDER BY KasseID ASC");
      foreach ($rkasser->result_array() as $rkasse) {
        $kasser[] = $rkasse;
        unset($rkasse);
      }
      if (isset($kasser)) {
        return $kasser;
      }
    }

    function kasse_info($KasseID = null) {
      $rkasser = $this->db->query("SELECT KasseID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,Navn,Notater FROM Kasser WHERE (KasseID='".$KasseID."')");
      if ($rkasse = $rkasser->row_array()) {
        return $rkasse;
      }
    }

    function kasse_lagre($KasseID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($KasseID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Kasser',$data));
        //$data['KasseID'] = $data['NyKasseID'];
      } else {
        $this->db->query($this->db->update_string('Kasser',$data,"KasseID='".$KasseID."'"));
        $data['KasseID'] = $KasseID;
      }
      if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('Infomelding','Kasse ='.str_pad($data['KasseID'],2,'0',STR_PAD_LEFT).' ble vellykket lagret.');
      } else {
        $this->session->set_flashdata('Feilmelding','En feil oppstod. Feilmelding: '.$this->db->error());
      }
      return $data;
    }

    function kasse_slett($KasseID) {
      $this->db->query("UPDATE Kasser SET DatoSlettet=Now() WHERE KasseID='".$KasseID."' LIMIT 1");
    }


  }
?>

