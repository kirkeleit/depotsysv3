<form method="POST" action="<?php echo site_url('utstyr/kasse/'.$Kasse['KasseID']); ?>">
<input type="hidden" name="KasseID" value="<?php echo set_value('KasseID',$Kasse['KasseID']); ?>" />

<div class="card">
  <h5 class="card-header">Kasse</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kode"><b>Kode:</b></label>
      <div class="col-sm-10">
<?php if (isset($Kasse['KasseID'])) { ?>
        <input type="text" class="form-control-plaintext" id="Kode" name="Kode" value="<?php echo '='.$Kasse['Kode']; ?>" readonly>
<?php } else { ?>
        <input type="text" class="form-control" id="Kode" name="Kode" required>
<?php } ?>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn"><b>Navn:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Kasse['Navn']); ?>" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="LokasjonID"><b>Lokasjon:</b></label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="LokasjonID" name="LokasjonID">
	  <option value="">(ikke valgt)</option>
          <option disabled>──────</option>
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
          <option value="<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Kasse['LokasjonID'] == $Lokasjon['LokasjonID']) { echo " selected"; } ?>><?php echo '+'.$Lokasjon['Kode']." ".$Lokasjon['Navn']; ?></option>
<?php
  }
?>
	</select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Kasse['Notater']); ?></textarea>
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
	<a href="<?php echo site_url('utstyr/slettkasse?kasseid='.$Kasse['KasseID']); ?>" class="dropdown-item">Slett kasse</a>
        <a href="<?php echo site_url('utstyr/innholdsliste?kasseid='.$Kasse['KasseID']); ?>" target="_new" class="dropdown-item">Innholdsliste</a>
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
        <th>Minimum antall</th>
        <th>Kontrollert</th>
        <th>Avvik</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <tr<?php if ($Utstyr['StatusID'] == 0) { echo ' class="bg-danger text-white"'; } ?>>
        <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"<?php if ($Utstyr['StatusID'] == 0) { echo ' class="text-white"'; } ?>><?php echo "-".$Utstyr['UtstyrID']; ?></a></th>
        <td><?php if ($Utstyr['ProdusentID'] > 0) { echo $Utstyr['ProdusentNavn']; ?>&nbsp;<a href="<?php echo site_url('utstyr/produsent/'.$Utstyr['ProdusentID']); ?>" target="_new"><img src="/res/open_in_new_window.png" height="16" width="16"></a><?php } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Utstyr['Beskrivelse']; ?></td>
        <td><?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { echo $Utstyr['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Utstyr['AntallMin']; ?></td>
        <td><?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { if ($Utstyr['DatoTelling'] != '') { echo date('d.m.Y',strtotime($Utstyr['DatoTelling'])); } else { echo "&nbsp;"; } } else { if ($Utstyr['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoKontrollert'])); } else { echo "&nbsp;"; } } ?></td>
        <td<?php if ($Utstyr['AntallAvvik'] > 0) { echo ' class="bg-danger text-white"'; } ?>><?php if ($Utstyr['AntallAvvik'] > 0) { echo $Utstyr['AntallAvvik'].' stk'; } else { echo '&nbsp;'; } ?></td>
        <td<?php if ($Utstyr['StatusID'] == 1) { echo ' class="bg-success text-white"'; } ?>><?php if ($Utstyr['StatusID'] == 1) { echo "Operativt"; } else { echo "IKKE operativt"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="8" class="text-center">Ingen utstyr registrert med denne utstyrstypen enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
