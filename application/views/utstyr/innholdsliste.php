<?php if (isset($Kasse)) { ?>
<div class="card">
  <div class="card-body text-center"><h1><?php echo 'KASSE ='.$Kasse['Kode']; ?></h1></div>
  <div class="card-body">
    <img src="https://chart.googleapis.com/chart?cht=qr&chl=<?php echo urlencode(site_url('utstyr/kasse/'.$Kasse['KasseID'])); ?>&chs=240x240" height="240" width="240">
  </div>
</div>
<?php } ?>

<div class="card card-body" style="page-break-before: always;">
<div class="table-responsive">
  <table class="table table-bordered table-sm">
    <thead>
      <tr>
        <th>Utstyr ID</th>
	<th>Beskrivelse</th>
        <th>Antall</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <tr>
        <td><?php echo $Utstyr['UtstyrID']; ?></td>
        <td><?php echo $Utstyr['Beskrivelse']; ?></td>
        <td><?php echo $Utstyr['Antall']." stk"; ?></td>
      </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
</div>
