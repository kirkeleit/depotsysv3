<div class="card">
  <div class="card-header text-right"><a href="<?php echo site_url('oppsett/nyrolle'); ?>" class="btn btn-success btn-sm" tabindex="-1" role="button">Ny rolle</a></div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>Navn</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Roller)) {
    foreach ($Roller as $Rolle) {
?>
        <tr>
	  <th><a href="<?php echo site_url('oppsett/rolle/'.$Rolle['RolleID']); ?>"><?php echo $Rolle['Navn']; ?></a></th>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Roller); ?> roller</div>
</div>
