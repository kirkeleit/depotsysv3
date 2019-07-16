<form method="POST" action="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>">
<input type="hidden" name="UtstyrID" value="<?php echo set_value('UtstyrID',$Utstyr['UtstyrID']); ?>" />

<div class="card">
  <div class="card-header"><b>Utstyr -<?php echo $Utstyr['UtstyrID']; ?></b></div>
  <div class="card-body">
    <div class="form-group">
      <label>ID:</label>
      <input type="text" class="form-control" value="-<?php echo $Utstyr['UtstyrID']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="Plassering">Plassering:</label>
      <select class="custom-select custom-select-sm" id="Plassering" name="Plassering">
	<option value="">[ukjent/ingen plass]</option>
        <optgroup label="Kasser">
<?php
  foreach ($Kasser as $Kasse) {
?>
          <option value="=<?php echo $Kasse['KasseID']; ?>"<?php if ($Utstyr['KasseID'] == $Kasse['KasseID']) { echo " selected"; } ?>><?php echo '='.$Kasse['KasseID']." ".$Kasse['Navn']; ?></option>
<?php
  }
?>
	</optgroup>
        <optgroup label="Lokasjoner">
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
        <option value="+<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Utstyr['LokasjonID'] == $Lokasjon['LokasjonID']) { echo " selected"; } ?>><?php echo '+'.$Lokasjon['LokasjonID']." ".$Lokasjon['Navn']; ?></option>
<?php
  }
?>

        </optgroup>
      </select>
    </div>
    <div class="form-group">
      <label>Beskrivelse:</label>
      <input type="text" class="form-control" id="Beskrivelse" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Utstyr['Beskrivelse']); ?>">
    </div>
    <div class="form-group">
      <label for="ProdusentID">Produsent:</label>
      <select class="custom-select custom-select-sm" id="ProdusentID" name="ProdusentID">
        <option value="0">[ingen]</option>
<?php
  foreach ($Produsenter as $Produsent) {
?>
	<option value="<?php echo $Produsent['ProdusentID']; ?>"<?php if ($Utstyr['ProdusentID'] == $Produsent['ProdusentID']) { echo " selected"; } ?>><?php echo $Produsent['Navn']; ?></option>
<?php
  }
?>
      </select>
    </div>
    <div class="form-group">
      <label for="Notater">Notater:</label>
      <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Utstyr['Notater']); ?></textarea>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="UtstyrLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="UtstyrSlett" />
  </div>
</div>

</form>
