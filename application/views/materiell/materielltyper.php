<h2>Materielltyper</h2>
<br />

<div class="card card-body">
En materielltype definerer en type/kategori med materiell, for eks lommelykter, redningsvester osv. Hver type materiell defineres av to valgfrie bokstaver, og disse vil alltid plasseres først i ID'en til materiellet. ID til hver enkelt materielltype bestemmer en selv når en registrerer den, men den må bestå av to bokstaver og være unik.
<a href="<?php echo site_url('materiell/nymaterielltype'); ?>">Trykk her for å registrere ny materielltype.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>Kode</th>
	<th>Navn</th>
        <th>Endret</th>
        <th>Ansvarlig</th>
	<th>Kontroll</th>
        <th>Materiell</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Materielltyper)) {
    foreach ($Materielltyper as $Materielltype) {
      if (strlen($Materielltype['Kode']) == 1) {
?>
        <tr class="table-info">
          <th colspan="2" class="text-uppercase"><a href="<?php echo site_url('materiell/materielltype/'.$Materielltype['MaterielltypeID']); ?>"><?php echo $Materielltype['Kode'].' '.$Materielltype['Navn']; ?></a></th>
          <td colspan="4">&nbsp;</td>
        </tr>
<?php
      } else {
?>
      <tr>
        <th><a href="<?php echo site_url('materiell/materielltype/'.$Materielltype['MaterielltypeID']); ?>"><?php echo $Materielltype['Kode']; ?></a></th>
	<td><?php echo $Materielltype['Navn']; ?></td>
        <td><?php echo date('d.m.Y',strtotime($Materielltype['DatoEndret'])); ?></td>
	<td><?php echo $Materielltype['AnsvarligRolle']; ?></td>
        <td><?php if ($Materielltype['KontrollDager'] > 0) { echo $Materielltype['KontrollDager'].' dager'; } else { echo "&nbsp;"; } ?></td>
        <td><?php if ($Materielltype['AntallMateriell'] > 0) { echo $Materielltype['AntallMateriell']." stk"; } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
      }
    }
  } else {
?>
      <tr>
        <td colspan="6" class="text-center">Ingen materielltyper er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
