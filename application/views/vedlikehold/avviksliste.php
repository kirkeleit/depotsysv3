<form method="POST" action="<?php echo site_url('vedlikehold/avviksliste'); ?>">
<div class="card">
  <div class="card-header">Avviksliste</div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
          <th>Registrert</td>
	  <th>Komponent</th>
	  <th>Beskrivelse</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Avviksliste)) {
    foreach ($Avviksliste as $Avvik) {
?>
        <tr>
	  <th><a href="<?php echo site_url('utstyr/avvik/'.$Avvik['AvvikID']); ?>"><?php echo $Avvik['AvvikID']; ?></a></th>
          <td><?php echo date("d.m.Y",strtotime($Avvik['DatoRegistrert'])); ?></td>
	  <td><a href="<?php echo site_url('utstyr/utstyr/'.$Avvik['UtstyrID']); ?>"><?php echo "-".$Avvik['UtstyrID']; ?></a></td>
	  <td><?php echo $Avvik['Beskrivelse']; ?></td>
          <td><?php echo $Avvik['Status']; ?></td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Avviksliste); ?> avvik registrert</div>
</div>
</form>
