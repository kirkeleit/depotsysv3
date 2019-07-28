<h2>Bestillingsliste</h2>
<br />

<div class="card card-body">Liste over forbruksmateriell som det er mindre av enn satt minsteantall. Denne listen er kun ment som et verktøy for å vise hva som mangler, og for å raskt kunne registrere inn nytt antall når en mottar varer. Det vil kunne være behov for annet utstyr i tillegg til denne listen.</div>
<br />

<form method="POST" action="<?php echo site_url('utstyr/bestillingsliste'); ?>">
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>Utstyr ID</th>
        <th>Produsent</th>
        <th>Beskrivelse</th>
        <th>Plassering</th>
        <th>Telt dato</th>
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
        <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo $Utstyr['Lokasjon']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo $Utstyr['Kasse']; } else { echo "&nbsp;"; } ?></td>
        <td><?php if ($Utstyr['DatoTelling'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoTelling'])); } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Utstyr['AntallMin']; ?></td>
        <td><?php echo $Utstyr['Antall']; ?></td>
        <td><input type="number" class="form-control" name="MottattAntall[]" size="6"></td>
      </tr>
<?php
      }
    }
  } else {
?>
      <tr>
        <td colspan="8" class="text-center">Ingen forbruksmateriell på bestillingslisten.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<input type="submit" class="btn btn-sm btn-primary" name="MottakLagre" value="Registrert mottak">
</form>
