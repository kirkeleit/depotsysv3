<?php if ($Avvik['DatoSlettet'] != '') { ?>
<div class="card card-body bg-danger text-white">Dette avviket ble slettet den <?php echo date('d.m.Y',strtotime($Avvik['DatoSlettet'])); ?>. Endringer vil ikke bli lagret.</div>
<br />
<?php } ?>
<form method="POST" action="<?php echo site_url('utstyr/avvik/'.$Avvik['AvvikID']); ?>">
<?php if (isset($Avvik)) { ?>
<input type="hidden" name="AvvikID" value="<?php echo $Avvik['AvvikID']; ?>" />
<input type="hidden" name="UtstyrID" value="<?php echo $Avvik['UtstyrID']; ?>" />
<?php } ?>
<?php if (isset($UtstyrID)) { ?>
<input type="hidden" name="UtstyrID" value="<?php echo set_value('UtstyrID',$UtstyrID); ?>" />
<?php } ?>

<div class="card">
  <div class="card-header"><b>Avviksskjema</b></div>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AvvikID"><b>Avvik ID:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="AvvikID" value="<?php if (isset($Avvik['AvvikID'])) { echo $Avvik['AvvikID']; } else { echo "<ny>"; } ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="UtstyrID"><b>Utstyr ID</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="UtstyrID" value="<?php if (isset($Avvik['UtstyrID'])) { echo '-'.$Avvik['UtstyrID']; } else { echo '-'.$UtstyrID; } ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="BrukerID"><b>Rapportert av</b></label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="BrukerID" name="BrukerID" required>
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
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="StatusID"><b>Status</b></label>
<?php if (isset($Avvik)) { ?>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="StatusID" name="StatusID">
	  <option value="0"<?php if ($Avvik['StatusID'] == 0) { echo " selected"; } ?> disabled>Registrert</option>
	  <option value="1"<?php if ($Avvik['StatusID'] == 1) { echo " selected"; } ?>>Under arbeid</option>
          <option value="2"<?php if ($Avvik['StatusID'] == 2) { echo " selected"; } ?>>På vent</option>
          <option value="3"<?php if ($Avvik['StatusID'] == 3) { echo " selected"; } ?>>Lukket</option>
	</select>
      </div>
<?php } else { ?>
      <div class="col-sm-10">
	<input type="text" class="form-control-plaintext" id="StatusID" value="Registrert" readonly>
        <input type="hidden" name="StatusID" value="0">
      </div>
<?php } ?>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kostnad"><b>Kostnad</b></label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="Kostnad" name="Kostnad" value="<?php echo $Avvik['Kostnad']; ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Beskrivelse"><b>Beskrivelse</b></label>
      <div class="col-sm-10">
	<textarea class="form-control" id="Beskrivelse" name="Beskrivelse" rows="4" required><?php echo set_value('Beskrivelse',$Avvik['Beskrivelse']); ?></textarea>
      </div>
    </div>
  </div>
<?php if ($Avvik['DatoSlettet'] == '') { ?>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="AvvikLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="AvvikSlett" />
  </div>
<?php } ?>
</div>
<br />

<?php if (isset($Avvik)) { ?>
<div class="card">
  <div class="card-header"><b>Avvikslogg</b></div>
<?php if (isset($Avvik['Logglinjer'])) { ?>
  <div class="card-body">
<?php
  foreach ($Avvik['Logglinjer'] as $Logglinje) {
?>
    <div class="card<?php if ($Logglinje['LoggtypeID'] == 1) { echo ' text-white bg-success'; } ?>">
      <div class="card-header"><?php echo date('d.m.Y',strtotime($Logglinje['DatoRegistrert'])).', av '.$Logglinje['BrukerNavn']; ?></div>
      <div class="card-body"><?php echo $Logglinje['Tekst']; ?></div>
    </div>
    <br />
<?php
  }
?>
  </div>
<?php } ?>
<?php if ($Avvik['StatusID'] < 3) { ?>
  <div class="card-footer">
    <textarea class="form-control" id="Loggtekst" name="Loggtekst" rows="4"></textarea>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="true" id="AvvikLukk" name="AvvikLukk">
      <label class="form-check-label" for="AvvikLukk">Fullfør avvik og sett status til lukket</label>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre logg" name="AvvikLagrelogg" />
  </div>
<?php } ?>
</div>
<?php } ?>

</form>
