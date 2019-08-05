<form method="POST" action="<?php echo site_url('oppsett/rolle/'.$Rolle['RolleID']); ?>">
<input type="hidden" name="RolleID" value="<?php echo set_value('RolleID',$Rolle['RolleID']); ?>" />
<div class="card">
  <h6 class="card-header bg-secondary text-white"><?php echo (!isset($Rolle)?'Ny ':''); ?>Rolle<?php echo (isset($Rolle)?' #'.$Rolle['RolleID']:''); ?></h6>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn"><b>Navn:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Rolle['Navn']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Epostadresse"><b>E-postadresse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Epostadresse" name="Epostadresse" value="<?php echo set_value('Epostadresse',$Rolle['Epostadresse']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Rolle['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
      <input type="submit" class="btn btn-success" value="<?php echo (isset($Rolle)?'Lagre':'Opprett'); ?>" name="SkjemaLagre" />
      <input type="submit" class="btn btn-success" value=">>" name="SkjemaLagreLukk" />
    </div>
<?php if (isset($Rolle)) { ?>
    <div class="btn-group" role="group">
      <button id="SkjemaAvansert" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Flere valg
      </button>
      <div class="dropdown-menu" aria-labelledby="SkjemaAvansert">
        <a href="<?php echo site_url('oppsett/slettrolle?rolleid='.$Rolle['RolleID']); ?>" class="dropdown-item">Slett rolle</a>
      </div>
    </div>
<?php } ?>
  </div>
</div>
</form>
