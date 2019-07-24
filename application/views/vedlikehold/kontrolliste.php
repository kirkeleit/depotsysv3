<form method="POST" action="<?php echo site_url('utstyr/kontrolliste'); ?>">
<a class="btn btn-primary btn-sm" data-toggle="collapse" href="#ListeFilter" role="button" aria-expanded="false" aria-controls="ListeFilter">Filter</a></div>
<div class="card card-body collapse" id="ListeFilter">
  <div class="form-group">
    <label for="LokasjonID">Lokasjon:</label>
    <select class="form-control" id="FilterLokasjonID" name="FilterLokasjonID">
      <option value="">[ingen filter]</option>
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
      <option value="<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Lokasjon['LokasjonID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "+".$Lokasjon['LokasjonID']." ".$Lokasjon['Navn']; ?></option>

<?php
  }
?>
    </select>
  </div>
  <div class="form-group">
    <label for="KasseID">Kasse:</label>
    <select class="form-control" id="FilterKasseID" name="FilterKasseID">
      <option value="">[ingen filter]</option>
<?php
  foreach ($Kasser as $Kasse) {
?>
      <option value="<?php echo $Kasse['KasseID']; ?>"<?php if ($Kasse['KasseID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "=".$Kasse['KasseID']." ".$Kasse['Navn']; ?></option>
<?php
  }
?>
    </select>
    <input type="submit" class="btn btn-primary" name="FiltrerListe" value="Filtrer" />
  </div>
</div>
</form>
<br />
<form method="POST" action="<?php echo site_url('utstyr/kontrolliste'); ?>">
<?php if (isset($FilterKasseID)) { ?>
<input type="hidden" name="FilterKasseID" value="<?php echo $FilterKasseID; ?>">
<?php } ?>
<?php if (isset($FilterLokasjonID)) { ?>
<input type="hidden" name="FilterLokasjonID" value="<?php echo $FilterLokasjonID; ?>">
<?php } ?>
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>Utstyr ID</th>
        <th>Produsent</th>
	<th>Beskrivelse</th>
        <th>Plassering</th>
        <th>Kontrollert</th>
        <th>Tilstand</th>
	<th>Kommentar</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
      if (((((time()-strtotime($Utstyr['DatoKontrollert'])) / 60) / 60) / 24) >= $Utstyr['KontrollDager']) {
?>
        <tr>
	  <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>" target="_new"><?php echo "-".$Utstyr['UtstyrID']; ?></a><input type="hidden" name="UtstyrID[]" value="<?php echo $Utstyr['UtstyrID']; ?>"></th>
          <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
	  <td><?php echo $Utstyr['Beskrivelse']; ?></td>
          <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo "+".$Utstyr['LokasjonID']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo "=".$Utstyr['KasseID']; } else { echo "&nbsp;"; } ?></td>
          <td><?php if ($Utstyr['DatoKontrollert'] == '') { echo "&nbsp;"; } else { echo date('d.m.Y',strtotime($Utstyr['DatoKontrollert'])); } ?></td>
	  <td><select class="form-control form-control-sm" name="Tilstand[]" id="Tilstand">
            <option value=""></option>
	    <option value="0">Alt ok!</option>
	    <option value="1">Trenger vedlikehold</option>
	    <option value="2">Mangler</option>
            <option value="3">Ødelagt</option>
	  </select></td>
	  <td><input type="text" class="form-control form-control-sm" name="Kommentar[]" id="Kommentar" placeholder="Legg inn kommentar her."></td>
          <td><input type="submit" class="btn btn-sm btn-primary" name="KontrollLagre" value="Lagre"></td>
        </tr>
<?php
      }
    }
  }
?>
    </tbody>
  </table>
</div>
</form>
