<form method="POST" action="<?php echo site_url('utstyr/lokasjon/'.$Lokasjon['LokasjonID']); ?>">
<input type="hidden" name="LokasjonID" value="<?php echo set_value('LokasjonID',$Lokasjon['LokasjonID']); ?>" />

<div class="card">
  <h5 class="card-header">Lokasjon</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kode"><b>Kode:</b></label>
      <div class="col-sm-10">
<?php if (isset($Lokasjon)) { ?>
        <input type="text" class="form-control-plaintext" id="Kode" name="Kode" value="<?php echo $Lokasjon['Kode']; ?>" readonly>
<?php } else { ?>
        <input type="text" class="form-control" id="LokasjonID" name="Kode" required>
<?php } ?>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn"><b>Navn:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Lokasjon['Navn']); ?>" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Lokasjon['Notater']); ?></textarea>
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
	<a href="<?php echo site_url('utstyr/slettlokasjon?lokasjonid='.$Lokasjon['LokasjonID']); ?>" class="dropdown-item">Slett lokasjon</a>
        <a href="<?php echo site_url('utstyr/innholdsliste?lokasjonid='.$Lokasjon['LokasjonID']); ?>" target="_new" class="dropdown-item">Innholdsliste</a>
      </div>
    </div>
  </div>
</div>
</form>
<br />

<h5>Kasser</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Kode</th>
        <th>Navn</th>
        <th>Endret</th>
        <th>Utstyr</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Kasser)) {
    foreach ($Kasser as $Kasse) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/kasse/'.$Kasse['KasseID']); ?>"><?php echo "=".$Kasse['Kode']; ?></a></th>
        <td><?php echo $Kasse['Navn']; ?></td>
        <td><?php echo date("d.m.Y",strtotime($Kasse['DatoEndret'])); ?></td>
        <td><?php if ($Kasse['UtstyrAntall'] > 0) { echo $Kasse['UtstyrAntall'].' stk'; } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="4" class="text-center">Ingen kasser er registrert på lokasjonen enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
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
