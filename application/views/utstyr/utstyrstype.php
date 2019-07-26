<form method="POST" action="<?php echo site_url('utstyr/utstyrstype/'.$Utstyrstype['UtstyrstypeID']); ?>">
<input type="hidden" name="UtstyrstypeID" value="<?php echo set_value('UtstyrstypeID',$Utstyrstype['UtstyrstypeID']); ?>" />

<?php echo validation_errors('<div class="alert alert-danger" role="alert">','</div>'); ?>

<div class="card">
  <h5 class="card-header">Utstyrstype</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kode"><b>Kode:</b></label>
      <div class="col-sm-10">
<?php if (isset($Utstyrstype['UtstyrstypeID'])) { ?>
        <input type="text" class="form-control-plaintext" id="Kode" name="Kode" value="<?php echo $Utstyrstype['Kode']; ?>" aria-describedby="KodeHjelp" readonly>
<?php } else { ?>
        <input type="text" class="form-control" id="Kode" name="Kode" maxlength="2" value="<?php echo set_value('Kode'); ?>" aria-describedby="KodeHjelp" required>
<?php } ?>
        <small id="KodeHjelp" class="form-text text-muted">Koden består av to bokstaver som blir lagt til først i identifikasjonsnummeret på alt utstyr.</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn"><b>Navn:</b></label>
      <div class="col-sm-10">
	<input type="text" class="form-control" id="Navn" name="Navn" maxlength="128" value="<?php echo set_value('Navn',$Utstyrstype['Navn']); ?>" aria-describedby="NavnHjelp" required>
        <small id="NavnHjelp" class="form-text text-muted">Navn på utstyrstypen.</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AnsvarligRolleID"><b>Ansvarlig rolle:</b></label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="AnsvarligRolleID" name="AnsvarligRolleID" aria-describedby="AnsvarligHjelp">
	  <option value="0"<?php echo set_select('AnsvarligRolleID',0,($Utstyrstype['AnsvarligRolleID']==0?TRUE:FALSE)); ?>>(ikke valgt)</option>
          <option disabled>──────</option>
<?php
  foreach ($Roller as $Rolle) {
?>
          <option value="<?php echo $Rolle['RolleID']; ?>"<?php echo set_select('AnsvarligRolleID',$Rolle['RolleID'],($Utstyrstype['AnsvarligRolleID']==$Rolle['RolleID']?TRUE:FALSE)); ?>><?php echo $Rolle['Navn']; ?></option>
<?php
  }
?>
	</select>
        <small id="AnsvarligHjelp" class="form-text text-muted">Her kan du definere hvem som har ansvar for utstyret av denne typen.</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="KontrollDager"><b>Kontrollintervall:</b></label>
      <div class="col-sm-10">
	<input type="number" class="form-control" id="KontrollDager" name="KontrollDager" value="<?php echo set_value('KontrollDager',$Utstyrstype['KontrollDager']); ?>" aria-describedby="KontrollHjelp" required>
        <small id="KontrollHjelp" class="form-text text-muted">Her kan du sette intervall(i dager) hvor ofte du ønsker at denne typen utstyr skal kontrolleres av noen. Sett til 0 om du ikke ønsker påminnelse om å kontrollere utstyret. Standard er 30 dager.</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Utstyrstype['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
      <input type="submit" class="btn btn-primary" value="Lagre" name="SkjemaLagre" />
      <input type="submit" class="btn btn-primary" value=">>" name="SkjemaLagreLukk" />
    </div>
    <div class="btn-group" role="group">
      <button id="SkjemaAvansert" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Flere valg
      </button>
      <div class="dropdown-menu" aria-labelledby="SkjemaAvansert">
	<a href="<?php echo site_url('utstyr/slettutstyrstype?utstyrstypeid='.$Utstyrstype['UtstyrstypeID']); ?>" class="dropdown-item">Slett utstyrstypen</a>
        <a href="<?php echo site_url('utstyr/nyttutstyr/?kode='.$Utstyrstype['Kode'].'&navn='.$Utstyrstype['Navn'].'&forbruk=0'); ?>" class="dropdown-item">Nytt utstyr</a>
        <a href="<?php echo site_url('utstyr/nyttutstyr/?kode='.$Utstyrstype['Kode'].'&navn='.$Utstyrstype['Navn'].'&forbruk=1'); ?>" class="dropdown-item">Nytt forbruksmateriell</a>
      </div>
    </div>
  </div>
</div>
</form>
<br />

<h5>Utstyrsliste</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Utstyr ID</th>
        <th>Produsent</th>
        <th>Beskrivelse</th>
        <th>Antall</th>
        <th>Plassering</th>
        <th>Endret</th>
        <th>Kontrollert</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo "-".$Utstyr['UtstyrID']; ?></a></th>
	<td><?php echo $Utstyr['ProdusentNavn']; ?>&nbsp;<a href="<?php echo site_url('utstyr/produsent/'.$Utstyr['ProdusentID']); ?>" target="_new"><img src="/res/open_in_new_window.png" height="16" width="16"></a></td>
        <td><?php echo $Utstyr['Beskrivelse']; ?></td>
        <td><?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { echo $Utstyr['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo $Utstyr['Lokasjon']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo $Utstyr['Kasse']; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo date("d.m.Y",strtotime($Utstyr['DatoEndret'])); ?></td>
        <td><?php if ($Utstyr['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="7" class="text-center">Ingen utstyr registrert med denne utstyrstypen enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
