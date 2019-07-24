<form method="POST" action="<?php echo site_url('utstyr/bestillingsliste'); ?>">
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>Utstyr ID</th>
        <th>Produsent</th>
        <th>Beskrivelse</th>
        <th>Plassering</th>
        <th>Kontrollert dato</th>
        <th>Minimum</th>
        <th>Antall</th>
        <th>Mottatt</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
      if ($Utstyr['Antall'] < $Utstyr['AntallMin']) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo '-'.$Utstyr['UtstyrID']; ?></a><input type="hidden" name="UtstyrID[]" value="<?php echo $Utstyr['UtstyrID']; ?>"></th>
        <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
        <td><?php echo $Utstyr['Beskrivelse']; ?></td>
        <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo "+".$Utstyr['LokasjonID']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo "=".$Utstyr['KasseID']; } else { echo "&nbsp;"; } ?></td>
        <td><?php if ($Utstyr['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Utstyr['AntallMin']; ?></td>
        <td><?php echo $Utstyr['Antall']; ?></td>
        <td><input type="number" class="form-control" name="MottattAntall[]" size="6"></td>
      </tr>
<?php
      }
    }
  }
?>
    </tbody>
  </table>
</div>
<input type="submit" class="btn btn-sm btn-primary" name="MottakLagre" value="Registrert mottak">
</form>
