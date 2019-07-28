<h2>Produsenter<small class="text-muted"> - Totalt <?php echo sizeof($Produsenter); ?> produsenter</small></h2>
<br />

<div class="card card-body">
En produsent brukes for å samle sammen alt utstyr en har fra et og samme merke/produsent. Dette viser seg å kunne være en grei måte når en for eks skal sammenligne utstyr en har i forhold til vedlikehold, spredning eller tilgjengelighet. Vær obs på at å bruke produsent er helt valgfritt. Alle ID'er knyttet til produsenter opprettes automatisk, og er ett løpenummer.
<a href="<?php echo site_url('utstyr/nyprodusent'); ?>">Trykk her for å opprette ny produsent.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>Navn</th>
        <th>Endret</th>
        <th>Nettsted</th>
        <th>Utstyr</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Produsenter)) {
    foreach ($Produsenter as $Produsent) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/produsent/'.$Produsent['ProdusentID']); ?>"><?php echo $Produsent['Navn']; ?></a></th>
        <td><?php echo date('d.m.Y',strtotime($Produsent['DatoEndret'])); ?></td>
        <td><?php echo $Produsent['Nettsted']; ?></td>
        <td><?php if ($Produsent['UtstyrAntall'] > 0) { echo $Produsent['UtstyrAntall']." stk"; } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="5" class="text-center">Ingen produsenter er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
