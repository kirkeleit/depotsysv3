<h2>Avviksliste<small class="text-muted"> - Totalt <?php echo sizeof($Avviksliste); ?> åpne avvik</small></h2>
<br />

<div class="card card-body">
Et avvik registreres på utstyr dersom det oppdages feil, problemer eller utstyr trenger vedlikehold. Avvik registreres direkte fra siden for selve utstyret.
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
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
  } else {
?>
      <tr>
        <td colspan="7" class="text-center">Ingen åpne avvik registrert.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
