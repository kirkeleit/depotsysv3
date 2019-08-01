<h2>Aktiviteter<?php if (!empty($Aktiviteter)) { ?><small class="text-muted"> - Totalt <?php echo sizeof($Aktiviteter); ?> aktiviteter</small><?php } ?></h2>
<br />

<div class="card card-body">
En aktivitet brukes for å knytte sammen flere plukklister som hører naturlig sammen. For eksempel til ei sanitetsvakt kan det være flere lag som tar ut forskjellig utstyr, eller flere personer i løpet av vakta. Da kan hver enkelt person/ansvarlig lage sine plukklister, og så kan dette samtidig eller senere knytte disse sammen i en aktivitet. Bruk av aktivitet er valgfritt, og plukklister kan fint brukes uten å knytte de til en aktivitet.
<a href="<?php echo site_url('utstyr/nyaktivitet'); ?>">Trykk her for å opprette ny aktivitet.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
	<th>Navn</th>
        <th>Registrert</th>
	<th>Plukklister</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Aktiviteter)) {
    foreach ($Aktiviteter as $Aktivitet) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/aktivitet/'.$Aktivitet['AktivitetID']); ?>"><?php echo $Aktivitet['AktivitetID']; ?></a></th>
	<td><?php echo $Aktivitet['Navn']; ?></td>
        <td><?php echo date('d.m.Y',strtotime($Aktivitet['DatoRegistrert'])); ?></td>
	<td><?php if ($Aktivitet['PlukklisterAntall'] > 0) { echo $Aktivitet['PlukklisterAntall']." stk"; } else { echo "0 stk"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="4" class="text-center">Ingen aktiviteter er registrert enda. Trykk <a href="<?php echo site_url('utstyr/nyaktivitet'); ?>">her</a> for å opprette ny aktivitet.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
