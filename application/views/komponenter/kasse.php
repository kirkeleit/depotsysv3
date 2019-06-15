<form method="POST" action="<?php echo site_url('komponenter/kasse/'.$Kasse['KasseID']); ?>">
<?php if (isset($Kasse['KasseID'])) { ?>
<input type="hidden" name="KasseID" value="<?php echo set_value('KasseID',$Kasse['KasseID']); ?>" />
<?php } ?>

<div class="card">
  <div class="card-header">Kasse</div>
  <div class="card-body">
    <div class="form-group">
      <label>ID:</label>
<?php if (isset($Kasse['KasseID'])) { ?>
      <input type="text" class="form-control" value="<?php echo '='.$Kasse['KasseID']; ?>" readonly>
<?php } else { ?>
      <input type="text" class="form-control" id="NyKasseID" name="NyKasseID">
<?php } ?>
    </div>
    <div class="form-group">
      <label for="Navn">Navn:</label>
      <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Kasse['Navn']); ?>">
    </div>
    <div class="form-group">
      <label for="LokasjonID">Plassering:</label>
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
    <div class="form-group">
      <label for="Notater">Notater:</label>
      <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Kasse['Notater']); ?></textarea>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="KasseLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="KasseSlett" />
  </div>
</div>

</form>

<?php if (isset($Komponenter)) { ?>
<div class="card">
  <div class="card-header">Komponenter</div>
  <div class="table-responsive">
    <table class="table table-sm table-striped table-hover">
      <tbody>
<?php foreach ($Komponenter as $Komponent) { ?>
        <tr>
          <th><a href="<?php echo site_url('komponenter/komponent/'.$Komponent['KomponentID']); ?>"><?php echo $Komponent['KomponentID']; ?></a></th>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>

