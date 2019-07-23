<div class="card">
  <div class="card-header">Avviksliste</div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
	  <th>Registrert den</th>
          <th>Registrert av</th>
	  <th>Utstyr ID</th>
	  <th>Beskrivelse</th>
          <th>Kostnad</th>
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
          <td><?php echo $Avvik['BrukerNavn']; ?></td>
	  <td><a href="<?php echo site_url('utstyr/utstyr/'.$Avvik['UtstyrID']); ?>"><?php echo "-".$Avvik['UtstyrID']; ?></a></td>
	  <td><?php echo $Avvik['Beskrivelse']; ?></td>
          <td><?php if ($Avvik['Kostnad'] > 0) { echo 'kr '.$Avvik['Kostnad']; } else { echo "&nbsp;"; } ?></td>
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
