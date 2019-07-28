<?php if (isset($Kasse)) { ?>
<div class="card">
  <div class="card-body text-center"><h1><?php echo 'KASSE ='.$Kasse['Kode']; ?></h1></div>
  <div class="card-body">
    <img src="https://chart.googleapis.com/chart?cht=qr&chl=<?php echo urlencode(site_url('utstyr/kasse/'.$Kasse['KasseID'])); ?>&chs=240x240" height="240" width="240">
  </div>
</div>
<?php } ?>

<div class="card" style="page-break-before: always; font-size: 1.5em; margin-top: 25px;">
  <div class="card-body text-center">
<?php if (isset($Lokasjon)) { ?>
    <h2><?php echo '+'.$Lokasjon['Kode'].' '.$Lokasjon['Navn']; ?></h2>
<?php } ?>
<?php if (isset($Kasse)) { ?>
    <h2><?php echo '='.$Kasse['Kode'].' '.$Kasse['Navn']; ?></h2>
<?php } ?>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-sm">
      <thead>
        <tr>
          <th>Utstyr ID</th>
          <th>Beskrivelse</th>
          <th>Produsent</th>
          <th>Antall</th>
        </tr>
      </thead>
      <tbody>
<?php
  $x = 0;
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
      $x++;
?>
        <tr>
          <th><?php echo '-'.$Utstyr['UtstyrID']; ?></th>
          <td><?php echo $Utstyr['Beskrivelse']; ?></td>
          <td><?php if ($Utstyr['ProdusentID'] > 0) { echo $Utstyr['ProdusentNavn']; } else { echo "&nbsp;"; } ?></td>
          <td><?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { echo $Utstyr['AntallMin']." stk (minimum)"; } else { echo '1 stk'; } ?></td>
        </tr>
<?php
    }
  }
  if ($x < 25) {
    for ($y=$x; $y<=25; $y++) {
?>
        <tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
</div>
