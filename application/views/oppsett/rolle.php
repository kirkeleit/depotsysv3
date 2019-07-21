<form method="POST" action="<?php echo site_url('oppsett/rolle/'.$Rolle['RolleID']); ?>">
<input type="hidden" name="RolleID" value="<?php echo set_value('RolleID',$Rolle['RolleID']); ?>" />

<div class="card">
  <div class="card-header">Rolle</div>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="RolleID">Rolle ID:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="RolleID" value="<?php echo $Rolle['RolleID']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn">Navn:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Rolle['Navn']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater">Notater:</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Rolle['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="RolleLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="RolleSlett" />
  </div>
</div>
<br />

</form>
