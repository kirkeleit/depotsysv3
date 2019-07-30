<h2>Roller<?php if (!empty($Roller)) { ?><small class="text-muted"> - Totalt <?php echo sizeof($Roller); ?> roller</small><?php } ?></h2>
<br />

<div class="card card-body">
<a href="<?php echo site_url('oppsett/nyrolle'); ?>">Trykk her for å registrere ny rolle.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
        <th>Navn</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Roller)) {
    foreach ($Roller as $Rolle) {
?>
      <tr>
	<th><a href="<?php echo site_url('oppsett/rolle/'.$Rolle['RolleID']); ?>"><?php echo $Rolle['RolleID']; ?></a></th>
        <td><?php echo $Rolle['Navn']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="2" class="text-center">Ingen roller er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
