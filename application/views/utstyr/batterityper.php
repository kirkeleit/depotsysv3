<h2>Batterityper</h2>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>Type</th>
	<th>Navn</th>
	<th>Utstyr</th>
        <th>Totalt behov</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Batterityper)) {
    foreach ($Batterityper as $Batteritype) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/batteritype/'.$Batteritype['BatteritypeID']); ?>"><?php echo $Batteritype['Type']; ?></a></th>
	<td><?php echo $Batteritype['Navn']; ?></td>
	<td><?php if ($Batteritype['UtstyrAntall'] > 0) { echo $Batteritype['UtstyrAntall'].' stk'; } else { echo "&nbsp;"; } ?></td>
        <td><?php if ($Batteritype['BehovAntall'] > 0) { echo $Batteritype['BehovAntall'].' stk'; } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="4" class="text-center">Ingen batterityper er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
