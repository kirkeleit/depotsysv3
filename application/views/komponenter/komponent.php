<form method="POST" action="<?php echo site_url('komponenter/komponent/'.$Komponent['KomponentID']); ?>">
<input type="hidden" name="KomponentID" value="<?php echo set_value('KomponentID',$Komponent['KomponentID']); ?>" />

<div class="card">
  <div class="card-header">Komponent <?php echo $Komponent['KomponentID']; ?></div>
  <div class="card-body">
    <div class="form-group">
      <label>ID:</label>
      <input type="text" class="form-control" value="<?php echo $Komponent['KomponentID']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="Plassering">Plassering:</label>
      <select class="custom-select custom-select-sm" id="Plassering" name="Plassering">
	<option value="">[ukjent/ingen plass]</option>
        <optgroup label="Kasser">
<?php
  foreach ($Kasser as $Kasse) {
?>
          <option value="=<?php echo $Kasse['KasseID']; ?>"<?php if ($Komponent['KasseID'] == $Kasse['KasseID']) { echo " selected"; } ?>><?php echo '='.$Kasse['KasseID']." ".$Kasse['Navn']; ?></option>
<?php
  }
?>
	</optgroup>
        <optgroup label="Lokasjoner">
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
        <option value="+<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Komponent['LokasjonID'] == $Lokasjon['LokasjonID']) { echo " selected"; } ?>><?php echo '+'.$Lokasjon['LokasjonID']." ".$Lokasjon['Navn']; ?></option>
<?php
  }
?>

        </optgroup>
      </select>
    </div>
    <div class="form-group">
      <label>Beskrivelse:</label>
      <input type="text" class="form-control" id="Beskrivelse" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Komponent['Beskrivelse']); ?>">
    </div>
    <div class="form-group">
      <label for="ProdusentID">Produsent:</label>
      <select class="custom-select custom-select-sm" id="ProdusentID" name="ProdusentID">
        <option value="0">[ingen]</option>
<?php
  foreach ($Produsenter as $Produsent) {
?>
	<option value="<?php echo $Produsent['ProdusentID']; ?>"<?php if ($Komponent['ProdusentID'] == $Produsent['ProdusentID']) { echo " selected"; } ?>><?php echo $Produsent['Navn']; ?></option>
<?php
  }
?>
      </select>
    </div>
    <div class="form-group">
      <label for="Notater">Notater:</label>
      <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Komponent['Notater']); ?></textarea>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="KomponentLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="KomponentSlett" />
  </div>
</div>

</form>
