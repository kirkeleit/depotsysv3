<form method="POST" action="<?php echo site_url('oppsett/minprofil/'.$Bruker['BrukerID']); ?>">
<input type="hidden" name="BrukerID" value="<?php echo set_value('BrukerID',$Bruker['BrukerID']); ?>" />

<div class="card">
  <h5 class="card-header bg-info text-white">Min profil</h5>
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
        <input type="number" class="form-control" id="Mobilnummer" name="Mobilnummer" value="<?php echo set_value('Mobilnummer',$Bruker['Mobilnummer']); ?>" maxlength="8">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Epostadresse"><b>E-postadresse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Epostadresse" name="Epostadresse" value="<?php echo set_value('Epostadresse',$Bruker['Epostadresse']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Passord"><b>Gjeldende passord:</b></label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="Passord" name="Passord">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="NyttPassord"><b>Nytt passord:</b></label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="NyttPassord" name="NyttPassord">
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
      <input type="submit" class="btn btn-primary" value="Lagre" name="SkjemaLagre" />
      <input type="submit" class="btn btn-primary" value=">>" name="SkjemaLagreLukk" />
    </div>
  </div>
</div>
<br />

</form>
