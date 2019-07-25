<h2>Kasser</h2>
<br />

<div class="card card-body">
En kasse er en fysisk kasse(eller sekk, boks etc) som en lagrer <u>og transporterer</u> utstyr i. Hver kasse må ha en egen uni ID som en setter selv. Dette kan være et eller flere tall, bokstaver eller en kombinasjon. Vær obs på at alle kasse ID'er vil listes opp med et = forran seg, så ikke bruk tegn i ID'en.
<a href="<?php echo site_url('utstyr/nykasse'); ?>">Trykk her for å registrere en ny kasse.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th>Navn</th>
        <th>Plassering</th>
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
	  <th><a href="<?php echo site_url('utstyr/kasse/'.$Kasse['KasseID']); ?>"><?php echo "=".str_pad($Kasse['KasseID'],2,'0',STR_PAD_LEFT); ?></a></th>
	  <td><?php echo $Kasse['Navn']; ?></td>
          <td><?php if (strlen($Kasse['LokasjonID']) > 0) { echo '+'.$Kasse['LokasjonID']; } ?></td>
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
