<form method="POST" action="<?php echo site_url('oppsett/bruker/'.$Bruker['BrukerID']); ?>">
<input type="hidden" name="BrukerID" value="<?php echo set_value('BrukerID',$Bruker['BrukerID']); ?>" />
<div class="card">
  <h6 class="card-header bg-secondary text-white"><?php echo (!isset($Bruker)?'Ny ':''); ?>Bruker<?php echo (isset($Bruker)?' #'.$Bruker['BrukerID']:''); ?></h6>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Fornavn"><b>Fornavn:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Fornavn" name="Fornavn" value="<?php echo set_value('Fornavn',$Bruker['Fornavn']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Etternavn"><b>Etternavn:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Etternavn" name="Etternavn" value="<?php echo set_value('Etternavn',$Bruker['Etternavn']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Mobilnummer"><b>Mobilnummer:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Mobilnummer" name="Mobilnummer" value="<?php echo set_value('Mobilnummer',$Bruker['Mobilnummer']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Epostadresse"><b>E-postadresse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Epostadresse" name="Epostadresse" value="<?php echo set_value('Epostadresse',$Bruker['Epostadresse']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="NyttPassord"><b>Nytt passord:</b></label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="NyttPassord" name="NyttPassord">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="RolleID"><b>Rolle:</b></label>
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
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Bruker['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
      <input type="submit" class="btn btn-success" value="<?php echo (isset($Bruker)?'Lagre':'Opprett'); ?>" name="SkjemaLagre" />
      <input type="submit" class="btn btn-success" value=">>" name="SkjemaLagreLukk" />
    </div>
<?php if (isset($Bruker)) { ?>
    <div class="btn-group" role="group">
      <button id="SkjemaAvansert" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Flere valg
      </button>
      <div class="dropdown-menu" aria-labelledby="SkjemaAvansert">
        <a href="<?php echo site_url('oppsett/slettbruker?brukerid='.$Bruker['BrukerID']); ?>" class="dropdown-item">Slett bruker</a>
      </div>
    </div>
<?php } ?>
  </div>
</div>
</form>
