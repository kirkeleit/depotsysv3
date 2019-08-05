<form method="POST" action="<?php echo site_url('materiell/materielltype/'.$Materielltype['MaterielltypeID']); ?>">
<input type="hidden" name="MaterielltypeID" value="<?php echo set_value('MaterielltypeID',$Materielltype['MaterielltypeID']); ?>" />
<div class="card">
  <h6 class="card-header bg-secondary text-white"><?php echo (!isset($Materielltype)?'Ny ':''); ?>Materielltype<?php echo (isset($Materielltype)?' '.$Materielltype['Kode']:''); ?></h6>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kode"><b>Kode:</b></label>
      <div class="col-sm-10">
<?php if (isset($Materielltype['MaterielltypeID'])) { ?>
        <input type="text" class="form-control-plaintext" id="Kode" name="Kode" value="<?php echo $Materielltype['Kode']; ?>" aria-describedby="KodeHjelp" readonly>
<?php } else { ?>
        <input type="text" class="form-control" id="Kode" name="Kode" maxlength="2" value="<?php echo set_value('Kode'); ?>" aria-describedby="KodeHjelp" required>
<?php } ?>
        <small id="KodeHjelp" class="form-text text-muted">Koden består av to bokstaver som blir lagt til først i identifikasjonsnummeret på alt materiell.</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn"><b>Navn:</b></label>
      <div class="col-sm-10">
	<input type="text" class="form-control" id="Navn" name="Navn" maxlength="128" value="<?php echo set_value('Navn',$Materielltype['Navn']); ?>" aria-describedby="NavnHjelp" required>
        <small id="NavnHjelp" class="form-text text-muted">Navn på materielltypen.</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AnsvarligRolleID"><b>Ansvarlig rolle:</b></label>
      <div class="col-sm-10">
        <select class="custom-select" id="AnsvarligRolleID" name="AnsvarligRolleID" aria-describedby="AnsvarligHjelp">
	  <option value="0"<?php echo set_select('AnsvarligRolleID',0,($Materielltype['AnsvarligRolleID']==0?TRUE:FALSE)); ?>>(ikke valgt)</option>
          <option disabled>──────</option>
<?php
  foreach ($Roller as $Rolle) {
?>
          <option value="<?php echo $Rolle['RolleID']; ?>"<?php echo set_select('AnsvarligRolleID',$Rolle['RolleID'],($Materielltype['AnsvarligRolleID']==$Rolle['RolleID']?TRUE:FALSE)); ?>><?php echo $Rolle['Navn']; ?></option>
<?php
  }
?>
	</select>
        <small id="AnsvarligHjelp" class="form-text text-muted">Her kan du definere hvem som har ansvar for materiell av denne typen.</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="KontrollDager"><b>Kontrollintervall:</b></label>
      <div class="col-sm-10">
	<input type="number" class="form-control" id="KontrollDager" name="KontrollDager" value="<?php echo set_value('KontrollDager',$Materielltype['KontrollDager']); ?>" aria-describedby="KontrollHjelp" required>
        <small id="KontrollHjelp" class="form-text text-muted">Her kan du sette intervall(i dager) hvor ofte du ønsker at denne typen materiell skal kontrolleres av noen. Sett til 0 om du ikke ønsker påminnelse om å kontrollere materiellet. Standard er 30 dager.</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="KontrollPunkter"><b>Kontrollpunkter:</b></label>
      <div class="col-sm-10">
	<textarea class="form-control" id="KontrollPunkter" name="KontrollPunkter" rows="5" aria-describedby="KontrollPunkterHjelp"><?php echo set_value('KontrollPunkter',$Materielltype['KontrollPunkter']); ?></textarea>
        <small id="KontrollPunkterHjelp" class="form-text text-muted">Legg inn spesielle punkter som må sjekkes på denne type materiell. Et kontrollpunkt pr linje.</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Materielltype['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
      <input type="submit" class="btn btn-success" value="<?php echo (isset($Materielltype)?'Lagre':'Opprett'); ?>" name="SkjemaLagre" />
      <input type="submit" class="btn btn-success" value=">>" name="SkjemaLagreLukk" />
    </div>
<?php if (isset($Materielltype)) { ?>
    <div class="btn-group" role="group">
      <button id="SkjemaAvansert" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Flere valg
      </button>
      <div class="dropdown-menu" aria-labelledby="SkjemaAvansert">
	<a href="<?php echo site_url('materiell/slettmaterielltype?materielltypeid='.$Materielltype['MaterielltypeID']); ?>" class="dropdown-item">Slett materielltypen</a>
	<a href="<?php echo site_url('materiell/nyttmateriell/?kode='.$Materielltype['Kode'].'&navn='.$Materielltype['Navn'].'&forbruk=0'); ?>" class="dropdown-item">Nytt materiell</a>
        <a href="<?php echo site_url('materiell/nyttmateriell/?kode='.$Materielltype['Kode'].'&navn='.$Materielltype['Navn'].'&forbruk=1'); ?>" class="dropdown-item">Nytt forbruksmateriell</a>
      </div>
    </div>
<?php } ?>
  </div>
</div>
</form>
<br />

<?php if (isset($Materielltype)) { ?>
<h5>Materielliste</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Materiell ID</th>
        <th>Produsent</th>
        <th>Beskrivelse</th>
        <th>Antall</th>
        <th>Minimum antall</th>
        <th>Plassering</th>
        <th>Kontrollert</th>
        <th>Avvik</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Materielliste)) {
    foreach ($Materielliste as $Materiell) {
?>
      <tr<?php if ($Materiell['StatusID'] == 0) { echo ' class="bg-danger text-white"'; } ?>>
        <th><a href="<?php echo site_url('materiell/materiell/'.$Materiell['MateriellID']); ?>"<?php if ($Materiell['StatusID'] == 0) { echo ' class="text-white"'; } ?>><?php echo "-".$Materiell['MateriellID']; ?></a></th>
        <td><?php if ($Materiell['ProdusentID'] > 0) { echo $Materiell['ProdusentNavn']; ?>&nbsp;<a href="<?php echo site_url('materiell/produsent/'.$Materiell['ProdusentID']); ?>" target="_new"><img src="/res/open_in_new_window.png" height="16" width="16"></a><?php } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Materiell['Beskrivelse']; ?></td>
        <td><?php if (substr($Materiell['MateriellID'],-1,1) == 'T') { echo $Materiell['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Materiell['AntallMin']; ?></td>
        <td><?php if ($Materiell['LokasjonID'] > 0) { echo $Materiell['Lokasjon'].' <a href="'.site_url('materiell/lokasjon/'.$Materiell['LokasjonID']).'" target="_new"><img src="/res/open_in_new_window.png" height="16" width="16"></a>'; } else { echo "&nbsp;"; } ?><?php if ($Materiell['KasseID'] > 0) { echo $Materiell['Kasse'].' <a href="'.site_url('materiell/kasse/'.$Materiell['KasseID']).'" target="_new"><img src="/res/open_in_new_window.png" height="16" width="16"></a>'; } else { echo "&nbsp;"; } ?></td>
        <td><?php if (substr($Materiell['MateriellID'],-1,1) == 'T') { if ($Materiell['DatoTelling'] != '') { echo date('d.m.Y',strtotime($Materiell['DatoTelling'])); } else { echo "&nbsp;"; } } else { if ($Materiell['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Materiell['DatoKontrollert'])); } else { echo "&nbsp;"; } } ?></td>
        <td<?php if ($Materiell['AntallAvvik'] > 0) { echo ' class="bg-danger text-white"'; } ?>><?php if ($Materiell['AntallAvvik'] > 0) { echo $Materiell['AntallAvvik'].' stk'; } else { echo '&nbsp;'; } ?></td>
        <td class="text-center<?php if ($Materiell['StatusID'] == 1) { echo ' bg-success text-white'; } elseif ($Materiell['StatusID'] == 2) { echo ' bg-warning'; } ?>"><?php if ($Materiell['StatusID'] == 0) { echo "IKKE OPERATIVT"; } elseif ($Materiell['StatusID'] == 2) { echo "UTREGISTRERT"; } else { echo "OPERATIVT"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="9" class="text-center">Ingen materiell registrert med denne utstyrstypen enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<?php } ?>
