<h2>Lokasjoner</h2>
<br />

<div class="card card-body">
En lokasjon er et fysisk sted hvor en oppbevarer utstyr. En velger selv hvor detaljert en ønsker å være, fra "Depot Andeby" til "Hylleplate 2, reol 2, depot". Hver lokasjon må ha en egen unik ID som en setter selv. Dette kan være et eller flere tall, bokstaver eller en kombinasjon. Vær obs på at alle lokasjons ID'er vil listes opp med et plusstegn forran seg, så ikke bruk tegn i ID'en.
<a href="<?php echo site_url('utstyr/nylokasjon'); ?>">Trykk her for å registrere en ny lokasjon.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th>Navn</th>
        <th>Endret</th>
        <th>Kasser</th>
        <th>Utstyr</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Lokasjoner)) {
    foreach ($Lokasjoner as $Lokasjon) {
?>
        <tr>
	  <th><a href="<?php echo site_url('utstyr/lokasjon/'.$Lokasjon['LokasjonID']); ?>"><?php echo '+'.$Lokasjon['LokasjonID']; ?></a></th>
	  <td><?php echo $Lokasjon['Navn']; ?></td>
	  <td><?php echo date('d.m.Y',strtotime($Lokasjon['DatoEndret'])); ?></td>
	  <td><?php if ($Lokasjon['KasserAntall'] > 0) { echo $Lokasjon['KasserAntall']." stk"; } else { echo "&nbsp;"; } ?></td>
	  <td><?php if ($Lokasjon['UtstyrAntall'] > 0) { echo $Lokasjon['UtstyrAntall']." stk"; } else { echo "&nbsp;"; } ?></td>
        </tr>
<?php
    }
  } else {
?>
        <tr>
          <td colspan="5" class="text-center">Ingen lokasjoner registrert enda.</td>
        </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
