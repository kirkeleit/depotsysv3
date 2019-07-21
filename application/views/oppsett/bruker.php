<form method="POST" action="<?php echo site_url('oppsett/bruker/'.$Bruker['BrukerID']); ?>">
<input type="hidden" name="BrukerID" value="<?php echo set_value('BrukerID',$Bruker['BrukerID']); ?>" />

<div class="card">
  <div class="card-header">Bruker</div>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="BrukerID">Bruker ID:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="BrukerID" value="<?php echo $Bruker['BrukerID']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Fornavn">Fornavn:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Fornavn" name="Fornavn" value="<?php echo set_value('Fornavn',$Bruker['Fornavn']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Etternavn">Etternavn:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Etternavn" name="Etternavn" value="<?php echo set_value('Etternavn',$Bruker['Etternavn']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Mobilnummer">Mobilnummer:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Mobilnummer" name="Mobilnummer" value="<?php echo set_value('Mobilnummer',$Bruker['Mobilnummer']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Epostadresse">E-postadresse:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Epostadresse" name="Epostadresse" value="<?php echo set_value('Epostadresse',$Bruker['Epostadresse']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="NyttPassord">Nytt passord:</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="NyttPassord" name="NyttPassord">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="RolleID">Rolle:</label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="RolleID" name="RolleID">
	  <option value="0"<?php if ($Bruker['RolleID'] == 0) { echo " selected"; } ?>>Ingen rolle</option>
<?php
  foreach ($Roller as $Rolle) {
?>
          <option value="<?php echo $Rolle['RolleID']; ?>"<?php if ($Rolle['RolleID'] == $Bruker['RolleID']) { echo " selected"; } ?>><?php echo $Rolle['Navn']; ?></option>
<?php
  }
?>
	</select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater">Notater:</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Bruker['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="BrukerLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="BrukerSlett" />
  </div>
</div>
<br />

</form>
