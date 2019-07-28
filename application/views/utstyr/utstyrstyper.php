<h2>Utstyrstyper</h2>
<br />

<div class="card card-body">
En utstyrstype definerer en type/kategori med utstyr, for eks lommelykter, redningsvester osv. Hver type utstyr defineres av to valgfrie bokstaver, og disse vil alltid plasseres først i ID'en til utstyret. ID til hver enkelt utstyrstype bestemmer en selv når en registrerer den, men den må bestå av to bokstaver og være unik.
<a href="<?php echo site_url('utstyr/nyutstyrstype'); ?>">Trykk her for å registrere ny utstyrstype.</a>
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
        <th>Utstyr</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrstyper)) {
    foreach ($Utstyrstyper as $Utstyrstype) {
      if (strlen($Utstyrstype['Kode']) == 1) {
?>
        <tr class="table-info">
          <th colspan="2" class="text-uppercase"><a href="<?php echo site_url('utstyr/utstyrstype/'.$Utstyrstype['UtstyrstypeID']); ?>"><?php echo $Utstyrstype['Kode'].' '.$Utstyrstype['Navn']; ?></a></th>
          <td colspan="4">&nbsp;</td>
        </tr>
<?php
      } else {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/utstyrstype/'.$Utstyrstype['UtstyrstypeID']); ?>"><?php echo $Utstyrstype['Kode']; ?></a></th>
	<td><?php echo $Utstyrstype['Navn']; ?></td>
        <td><?php echo date('d.m.Y',strtotime($Utstyrstype['DatoEndret'])); ?></td>
	<td><?php echo $Utstyrstype['AnsvarligRolle']; ?></td>
        <td><?php if ($Utstyrstype['KontrollDager'] > 0) { echo $Utstyrstype['KontrollDager'].' dager'; } else { echo "&nbsp;"; } ?></td>
        <td><?php if ($Utstyrstype['AntallUtstyr'] > 0) { echo $Utstyrstype['AntallUtstyr']." stk"; } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
      }
    }
  } else {
?>
      <tr>
        <td colspan="6" class="text-center">Ingen utstyrstyper er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
