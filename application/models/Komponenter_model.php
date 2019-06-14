<?php
  class Komponenter_model extends CI_Model {

    function komponenter($filter = null) {
      $sql = "SELECT KomponentID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,KasseID,Beskrivelse,ProdusentID,(SELECT Navn FROM Produsenter p WHERE (p.ProdusentID=k.ProdusentID)) AS ProdusentNavn FROM Komponenter k WHERE (DatoSlettet Is Null)";
      if (isset($filter['FilterKomponenttypeID'])) {
        $sql .= " AND (KomponentID Like '".$filter['FilterKomponenttypeID']."%')";
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
      $sql .= " ORDER BY KomponentID ASC";
      $rkomponenter = $this->db->query($sql);
      foreach ($rkomponenter->result_array() as $rkomponent) {
        $komponenter[] = $rkomponent;
        unset($rkomponent);
      }
      if (isset($komponenter)) {
        return $komponenter;
      }
    }

    function nykomponentid($KomponenttypeID) {
      $rkomponenter = $this->db->query("SELECT * FROM Komponenter WHERE (KomponentID Like CONCAT('".$KomponenttypeID."','%')) ORDER BY KomponentID DESC");
      if ($rkomponenter->num_rows() == 0) {
        return $KomponenttypeID.'001';
      } else {
        $rkomponent = $rkomponenter->row_array();
        //return substr($rkomponent['KomponentID'],2);
        return $KomponenttypeID.str_pad((substr($rkomponent['KomponentID'],2)+1),3,'0',STR_PAD_LEFT);
      }
    }

    function komponent_info($KomponentID = null) {
      $rkomponenter = $this->db->query("SELECT KomponentID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,KasseID,Beskrivelse,ProdusentID,Notater FROM Komponenter WHERE (KomponentID='".$KomponentID."')");
      if ($rkomponent = $rkomponenter->row_array()) {
	return $rkomponent;
      }
    }

    function komponent_lagre($KomponentID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($KomponentID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Komponenter',$data));
        //$data['KomponentID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Komponenter',$data,"KomponentID='".$KomponentID."'"));
        $data['KomponentID'] = $KomponentID;
      }
      if ($this->db->affected_rows() > 0) {
        //$this->session->set_flashdata('Infomelding','Lagerplassen "" ble vellykket oppdatert!');
      }
      return $data;
    }

    function komponent_slett($KomponentID) {
      $this->db->query("UPDATE Komponenter SET DatoSlettet=Now() WHERE KomponentID='".$KomponentID."' LIMIT 1");
    }


    function komponenttyper() {
      $rkomponenttyper = $this->db->query("SELECT KomponenttypeID,DatoRegistrert,DatoEndret,DatoSlettet,Beskrivelse,(SELECT COUNT(*) FROM Komponenter WHERE (KomponentID Like CONCAT(kt.KomponenttypeID,'%'))) AS AntallKomponenter FROM Komponenttyper kt WHERE (DatoSlettet Is Null) ORDER BY KomponenttypeID ASC");
      foreach ($rkomponenttyper->result_array() as $rkomponenttype) {
        $komponenttyper[] = $rkomponenttype;
        unset($rkomponenttype);
      }
      if (isset($komponenttyper)) {
        return $komponenttyper;
      }
    }

    function komponenttype_info($KomponenttypeID = null) {
      $rkomponenttyper = $this->db->query("SELECT KomponenttypeID,DatoRegistrert,DatoEndret,DatoSlettet,Beskrivelse,Notater FROM Komponenttyper WHERE (KomponenttypeID='".$KomponenttypeID."')");
      if ($rkomponenttype = $rkomponenttyper->row_array()) {
        return $rkomponenttype;
      }
    }

    function komponenttype_lagre($KomponenttypeID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($KomponenttypeID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Komponenttyper',$data));
        $data['KomponenttypeID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Komponenttyper',$data,"KomponenttypeID='".$KomponenttypeID."'"));
        $data['KomponenttypeID'] = $KomponenttypeID;
      }
      if ($this->db->affected_rows() > 0) {
        //$this->session->set_flashdata('Infomelding','Lagerplassen "" ble vellykket oppdatert!');
      }
      return $data;
    }

    function komponenttype_slett($KomponenttypeID) {
      $this->db->query("UPDATE Komponenttyper SET DatoSlettet=Now() WHERE KomponenttypeID='".$KomponenttypeID."' LIMIT 1");
    }


    function produsenter() {
      $rprodusenter = $this->db->query("SELECT ProdusentID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Nettsted FROM Produsenter WHERE (DatoSlettet Is Null) ORDER BY Navn ASC");
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
        //$this->session->set_flashdata('Infomelding','Lagerplassen "" ble vellykket oppdatert!');
      }
      return $data;
    }

    function produsent_slett($ProdusentID) {
      $this->db->query("UPDATE Produsenter SET DatoSlettet=Now() WHERE ProdusentID='".$ProdusentID."' LIMIT 1");
    }


    function lokasjoner() {
      $rlokasjoner = $this->db->query("SELECT LokasjonID,DatoRegistrert,DatoEndret,DatoSlettet,Navn FROM Lokasjoner WHERE (DatoSlettet Is Null) ORDER BY LokasjonID ASC");
      foreach ($rlokasjoner->result_array() as $rlokasjon) {
        $lokasjoner[] = $rlokasjon;
        unset($rlokasjon);
      }
      if (isset($lokasjoner)) {
        return $lokasjoner;
      }
    }

    function lokasjon_info($LokasjonID = null) {
      $rlokasjoner = $this->db->query("SELECT LokasjonID,DatoRegistrert,DatoEndret,DatoSlettet,Navn,Notater FROM Lokasjoner WHERE (LokasjonID='".$LokasjonID."')");
      if ($rlokasjon = $rlokasjoner->row_array()) {
        return $rlokasjon;
      }
    }

    function lokasjon_lagre($LokasjonID = null,$data) {
      $data['DatoEndret'] = date('Y-m-d H:i:s');
      if ($LokasjonID == null) {
        $data['DatoRegistrert'] = $data['DatoEndret'];
        $this->db->query($this->db->insert_string('Lokasjoner',$data));
        //$data['ProdusentID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Lokasjoner',$data,"LokasjonID='".$LokasjonID."'"));
        $data['LokasjonID'] = $LokasjonID;
      }
      if ($this->db->affected_rows() > 0) {
        //$this->session->set_flashdata('Infomelding','Lagerplassen "" ble vellykket oppdatert!');
      }
      return $data;
    }

    function lokasjon_slett($LokasjonID) {
      $this->db->query("UPDATE Lokasjoner SET DatoSlettet=Now() WHERE LokasjonID='".$LokasjonID."' LIMIT 1");
    }


    function kasser() {
      $rkasser = $this->db->query("SELECT KasseID,DatoRegistrert,DatoEndret,DatoSlettet,LokasjonID,Navn FROM Kasser WHERE (DatoSlettet Is Null) ORDER BY KasseID ASC");
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
        $data['KasseID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Kasser',$data,"KasseID='".$KasseID."'"));
        $data['KasseID'] = $KasseID;
      }
      if ($this->db->affected_rows() > 0) {
        //$this->session->set_flashdata('Infomelding','Lagerplassen "" ble vellykket oppdatert!');
      }
      return $data;
    }

    function kasse_slett($KasseID) {
      $this->db->query("UPDATE Kasser SET DatoSlettet=Now() WHERE KasseID='".$KasseID."' LIMIT 1");
    }


  }
?>

