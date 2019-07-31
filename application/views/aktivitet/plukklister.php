<h2>Plukklister<?php if (!empty($Plukklister)) { ?><small class="text-muted"> - Totalt <?php echo sizeof($Plukklister); ?> plukklister</small><?php } ?></h2>
<br />

<div class="card card-body">
Ei plukkliste brukes for ut-/ og innregistrering av utstyr. Ved å bruke dette systematisk vil en til enhver tid ha oversikt over utstyr som medlemmer har hentet ut, hvor utstyret er og hvem som har ansvar for det. Det blir og enklere å forsikre seg om at utstyr kommer tilbake igjen.
<a href="<?php echo site_url('aktivitet/nyplukkliste'); ?>">Trykk her for å opprette ny plukkliste.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
	<th>Registrert</th>
	<th>Ansvarlig</th>
        <th>Beskrivelse</th>
	<th>Utstyr</th>
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
	<td><?php echo date('d.m.Y',strtotime($Plukkliste['DatoRegistrert'])); ?></td>
	<td><?php echo $Plukkliste['AnsvarligBrukerNavn']; ?></td>
        <td><?php echo $Plukkliste['Beskrivelse']; ?></td>
	<td><?php if ($Plukkliste['UtstyrAntall'] > 0) { echo $Plukkliste['UtstyrAntall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Plukkliste['Status']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="6" class="text-center">Ingen plukklister er registrert enda. Trykk <a href="<?php echo site_url('utstyr/nyplukkliste'); ?>">her</a> for å registrere ny plukkliste.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
