<form method="POST" action="<?php echo site_url('utstyr/avvik/'.$Avvik['AvvikID']); ?>">
<?php if (isset($Avvik)) { ?>
<input type="hidden" name="AvvikID" value="<?php echo set_value('AvvikID',$Avvik['AvvikID']); ?>" />
<?php } ?>

<div class="card">
  <div class="card-header">Avvik <?php echo $Avvik['AvvikID']; ?></div>
  <div class="card-body">
    <div class="form-group">
      <label>Utstyr:</label>
      <input type="text" class="form-control" value="<?php echo '-'.$Avvik['UtstyrID']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="BrukerID">Bruker:</label>
      <select class="custom-select custom-select-sm" id="BrukerID" name="BrukerID">
        <option value="">[ingen]</option>
<?php
  foreach ($Brukere as $Bruker) {
?>
        <option value="<?php echo $Bruker['BrukerID']; ?>"<?php if ($Avvik['BrukerID'] == $Bruker['BrukerID']) { echo " selected"; } ?>><?php echo $Bruker['Fornavn']." ".$Bruker['Etternavn']; ?></option>
<?php
  }
?>
      </select>
    </div>
    <div class="form-group">
      <label for="Beskrivelse">Beskrivelse:</label>
      <textarea class="form-control" id="Beskrivelse" name="Beskrivelse" rows="4"><?php echo set_value('Beskrivelse',$Avvik['Beskrivelse']); ?></textarea>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="AvvikLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="AvvikSlett" />
  </div>
</div>
<br />

</form>
