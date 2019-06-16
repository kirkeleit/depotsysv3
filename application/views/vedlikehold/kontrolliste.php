<?php
  $Plassering = "";
?>
<form method="GET" action="<?php echo site_url('vedlikehold/kontrolliste'); ?>">
<div class="card">
  <div class="card-header">Filter</div>
  <div class="card-body">
    <div class="form-group">
      <label for="Plassering">Plassering:</label>
      <select class="form-control" id="Plassering" name="filterplassering">
        <optgroup label="Lokasjoner">
<?php
  foreach ($Lokasjoner as $Lokasjon) {
    if ($Lokasjon['KomponenterAntall'] > 0) {
?>
         <option value="+<?php echo $Lokasjon['LokasjonID']; ?>"><?php echo "+".$Lokasjon['LokasjonID']." ".$Lokasjon['Navn']; ?></option>
<?php
    }
  }
?>
	</optgroup>
        <optgroup label="Kasser">
<?php
  foreach ($Kasser as $Kasse) {
    if ($Kasse['KomponenterAntall'] > 0) {
?>
         <option value="=<?php echo $Kasse['KasseID']; ?>"><?php echo "=".$Kasse['KasseID']." ".$Kasse['Navn']; ?></option>
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
<form method="POST" action="<?php echo site_url('vedlikehold/kontrolliste'); ?>">
<div class="card">
  <div class="card-header">Komponenter</div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
          <th>Produsent</th>
	  <th>Beskrivelse</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Komponenter)) {
    foreach ($Komponenter as $Komponent) {
      if ($Komponent['Plassering'] != $Plassering) {
?>
        <tr class="table-active">
	  <td colspan="3"><?php echo $Komponent['Plassering']; ?></td>
          <td class="text-right"><input type="submit" class="btn btn-primary btn-sm" value="Lagre" name="Lagre" /></td>
        </tr>
<?php
        $Plassering = $Komponent['Plassering'];
      }
?>
        <tr>
	<th><a href="<?php echo site_url('komponenter/komponent/'.$Komponent['KomponentID']); ?>" target="_new"><?php echo "-".$Komponent['KomponentID']; ?></a><input type="hidden" name="KomponentID[]" value="<?php echo $Komponent['KomponentID']; ?>"></th>
          <td><?php echo $Komponent['ProdusentNavn']; ?></td>
	  <td><?php echo $Komponent['Beskrivelse']; ?></td>
	  <td><select class="form-control form-control-sm" name="Tilstand[]" id="Tilstand">
            <option value=""></option>
	    <option value="0">Alt ok!</option>
	    <option value="1">Trenger vedlikehold</option>
            <option value="2">Mangler</option>
          </select><input type="text" class="form-control form-control-sm" name="Kommentar[]" id="Kommentar" placeholder="Legg inn kommentar her."></td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Komponenter); ?> komponenter</div>
</div>
</form>
