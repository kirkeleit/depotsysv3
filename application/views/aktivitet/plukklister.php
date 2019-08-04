<h2>Plukklister<?php if (!empty($Plukklister)) { ?><small class="text-muted"> - Totalt <?php echo sizeof($Plukklister); ?> plukklister</small><?php } ?></h2>
<br />

<div class="card card-body">
Ei plukkliste brukes for ut-/ og innregistrering av materiell. Ved å bruke dette systematisk vil en til enhver tid ha oversikt over materiell som medlemmer har hentet ut, hvor materiellet er og hvem som har ansvar for det. Det blir og enklere å forsikre seg om at utlevert materiell kommer tilbake igjen.
<a href="<?php echo site_url('aktivitet/nyplukkliste'); ?>">Trykk her for å opprette ny plukkliste.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
	<th>Navn</th>
	<th>Ansvarlig</th>
        <th>Dato</th>
	<th>Materiell</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Plukklister)) {
    foreach ($Plukklister as $Plukkliste) {
?>
      <tr>
        <th><a href="<?php echo site_url('aktivitet/plukkliste/'.$Plukkliste['PlukklisteID']); ?>"><?php echo $Plukkliste['PlukklisteID']; ?></a></th>
        <td><?php echo $Plukkliste['Navn']; ?></td>
        <td><?php echo $Plukkliste['AnsvarligBrukerNavn']; ?></td>
        <td><?php echo date('d.m.Y',strtotime($Plukkliste['DatoRegistrert'])); ?></td>
        <td><?php if ($Plukkliste['MateriellAntall'] > 0) { echo $Plukkliste['MateriellAntall']." stk"; } else { echo "0 stk"; } ?></td>
        <td><?php echo $Plukkliste['Status']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="6" class="text-center">Ingen plukklister er registrert enda. Trykk <a href="<?php echo site_url('aktivitet/nyplukkliste'); ?>">her</a> for å registrere ny plukkliste.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
