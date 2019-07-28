<h2>Kasser<small class="text-muted"> - Totalt <?php echo sizeof($Kasser); ?> kasser</small></h2>
<br />

<div class="card card-body">
En kasse er en fysisk kasse(eller sekk, boks etc) som en lagrer og transporterer utstyr i. Hver kasse må ha en egen uni ID som en setter selv. Dette kan være et eller flere tall, bokstaver eller en kombinasjon. Vær obs på at alle kasse ID'er vil listes opp med et = forran seg, så ikke bruk tegn i ID'en.
<a href="<?php echo site_url('utstyr/nykasse'); ?>">Trykk her for å registrere en ny kasse.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>Kode</th>
        <th>Navn</th>
        <th>Lokasjon</th>
        <th>Endret</th>
        <th>Utstyr</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Kasser)) {
    foreach ($Kasser as $Kasse) {
?>
        <tr>
	  <th><a href="<?php echo site_url('utstyr/kasse/'.$Kasse['KasseID']); ?>"><?php echo "=".str_pad($Kasse['Kode'],2,'0',STR_PAD_LEFT); ?></a></th>
	  <td><?php echo $Kasse['Navn']; ?></td>
          <td><?php if ($Kasse['LokasjonID'] > 0) { echo $Kasse['Lokasjon']; } ?></td>
	  <td><?php echo date('d.m.Y',strtotime($Kasse['DatoEndret'])); ?></td>
	  <td><?php if ($Kasse['UtstyrAntall'] > 0) { echo $Kasse['UtstyrAntall']." stk"; } else { echo "&nbsp;"; } ?></td>
        </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="5" class="text-center">Ingen kasser er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
