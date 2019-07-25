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
        <th>#</th>
        <th>Beskrivelse</th>
        <th>Endret</th>
        <th>Ansvarlig</th>
        <th>Utstyr</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrstyper)) {
    foreach ($Utstyrstyper as $Utstyrstype) {
      if (strlen($Utstyrstype['UtstyrstypeID']) == 1) {
?>
        <tr class="table-dark">
          <th><a href="<?php echo site_url('utstyr/utstyrstype/'.$Utstyrstype['UtstyrstypeID']); ?>"><?php echo $Utstyrstype['UtstyrstypeID']; ?></a></th>
          <td><b><?php echo strtoupper($Utstyrstype['Beskrivelse']); ?></b></td>
	  <td><?php echo date('d.m.Y',strtotime($Utstyrstype['DatoEndret'])); ?></td>
          <td colspan="2">&nbsp;</td>
        </tr>
<?php
      } else {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/utstyrstype/'.$Utstyrstype['UtstyrstypeID']); ?>"><?php echo $Utstyrstype['UtstyrstypeID']; ?></a></th>
        <td><?php echo $Utstyrstype['Beskrivelse']; ?></td>
        <td><?php echo date('d.m.Y',strtotime($Utstyrstype['DatoEndret'])); ?></td>
        <td><?php echo $Utstyrstype['AnsvarligRolle']; ?></td>
        <td><?php if ($Utstyrstype['AntallUtstyr'] > 0) { echo $Utstyrstype['AntallUtstyr']." stk"; } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
      }
    }
  } else {
?>
      <tr>
        <td colspan="5" class="text-center">Ingen utstyrstyper er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
