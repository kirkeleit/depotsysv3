<form method="POST" action="<?php echo site_url('utstyr/kasse/'.$Kasse['KasseID']); ?>">
<?php if (isset($Kasse['KasseID'])) { ?>
<input type="hidden" name="KasseID" value="<?php echo set_value('KasseID',$Kasse['KasseID']); ?>" />
<?php } ?>

<div class="card">
  <div class="card-header"><b>Kasse =<?php echo $Kasse['KasseID']; ?></b></div>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="KasseID">ID:</label>
      <div class="col-sm-10">
<?php if (isset($Kasse['KasseID'])) { ?>
        <input type="text" class="form-control-plaintext" id="KasseID" value="<?php echo '='.$Kasse['KasseID']; ?>" readonly>
<?php } else { ?>
        <input type="text" class="form-control" id="KasseID" name="NyKasseID">
<?php } ?>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn">Navn:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Kasse['Navn']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="LokasjonID">Plassering:</label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="LokasjonID" name="LokasjonID">
          <option value="">[ingen]</option>
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
          <option value="<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Kasse['LokasjonID'] == $Lokasjon['LokasjonID']) { echo " selected"; } ?>><?php echo '+'.$Lokasjon['LokasjonID']." ".$Lokasjon['Navn']; ?></option>
<?php
  }
?>
	</select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater">Notater:</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Kasse['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="KasseLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="KasseSlett" />
  </div>
</div>
<br />

</form>

<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Utstyr ID</th>
        <th>Produsent</th>
	<th>Beskrivelse</th>
	<th>Antall</th>
	<th>Minimum antall</th>
        <th>Endret</th>
	<th>Kontrollert</th>
        <th>Avvik</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <tr<?php if ($Utstyr['AntallAvvik'] > 0) { echo ' class="bg-danger"'; } elseif ($Utstyr['Antall'] < $Utstyr['AntallMin']) { echo ' class="bg-warning"'; } ?>>
        <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo "-".$Utstyr['UtstyrID']; ?></a></th>
        <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
	<td><?php echo $Utstyr['Beskrivelse']; ?></td>
<?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { ?>
	<td><?php echo $Utstyr['Antall']." stk"; ?></td>
	<td><?php echo $Utstyr['AntallMin']." stk"; ?></td>
<?php } else { ?>
        <td colspan="2">&nbsp;</td>
<?php } ?>
        <td><?php echo date("d.m.Y",strtotime($Utstyr['DatoEndret'])); ?></td>
	<td><?php if ($Utstyr['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Utstyr['AntallAvvik']." stk"; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="8" class="text-center">Ingen utstyr registrert i denne kassen.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
