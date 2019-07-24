<?php
  $Plassering = "";
?>
<form method="GET" action="<?php echo site_url('utstyr/kontrolliste'); ?>">
<div class="card">
  <div class="card-header">Filter</div>
  <div class="card-body">
    <div class="form-group">
      <label for="Plassering">Plassering:</label>
      <select class="form-control" id="Plassering" name="filterplassering">
        <optgroup label="Lokasjoner">
<?php
  foreach ($Lokasjoner as $Lokasjon) {
    if ($Lokasjon['UtstyrAntall'] > 0) {
?>
	 <option value="+<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Lokasjon['LokasjonID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "+".$Lokasjon['LokasjonID']." ".$Lokasjon['Navn']; ?></option>
<?php
    }
  }
?>
	</optgroup>
        <optgroup label="Kasser">
<?php
  foreach ($Kasser as $Kasse) {
    if ($Kasse['UtstyrAntall'] > 0) {
?>
         <option value="=<?php echo $Kasse['KasseID']; ?>"<?php if ($Kasse['KasseID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "=".$Kasse['KasseID']." ".$Kasse['Navn']; ?></option>
<?php
    }
  }
?>
        </optgroup>
      </select>
      <input type="submit" class="btn btn-primary" value="Filtrer" />
    </div>
  </div>
</div>
</form>
<br />
<form method="POST" action="<?php echo site_url('utstyr/kontrolliste'); ?>">
<div class="card">
  <div class="card-header"><b>Utstyr som må kontrolleres</b></div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
          <th>Produsent</th>
	  <th>Beskrivelse</th>
          <th>&nbsp;</th>
	  <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
      if (((((time()-strtotime($Utstyr['DatoKontrollert'])) / 60) / 60) / 24) >= $Utstyr['KontrollDager']) {
        if ($Utstyr['Plassering'] != $Plassering) {
?>
        <tr class="table-active">
	  <td colspan="4"><?php echo $Utstyr['Plassering']; ?></td>
          <td class="text-right"><input type="submit" class="btn btn-primary btn-sm" value="Lagre" name="KontrollLagre" /></td>
        </tr>
<?php
          $Plassering = $Utstyr['Plassering'];
        }
?>
        <tr>
	  <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>" target="_new"><?php echo "-".$Utstyr['UtstyrID']; ?></a><input type="hidden" name="UtstyrID[]" value="<?php echo $Utstyr['UtstyrID']; ?>"></th>
          <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
	  <td><?php echo $Utstyr['Beskrivelse']; ?></td>
          <td><?php echo floor((((time()-strtotime($Utstyr['DatoKontrollert'])) / 60) / 60) / 24).' '.$Utstyr['KontrollDager']; ?></td>
	  <td><select class="form-control form-control-sm" name="Tilstand[]" id="Tilstand">
            <option value=""></option>
	    <option value="0">Alt ok!</option>
	    <option value="1">Trenger vedlikehold</option>
	    <option value="2">Mangler</option>
            <option value="3">Ødelagt</option>
	  </select></td>
	  <td><input type="text" class="form-control form-control-sm" name="Kommentar[]" id="Kommentar" placeholder="Legg inn kommentar her."></td>
        </tr>
<?php
      }
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Utstyrsliste); ?> deler som trenger kontroll</div>
</div>
</form>
