<div class="card">
  <div class="card-header text-right"><a href="<?php echo site_url('utstyr/nyutstyrstype'); ?>" class="btn btn-success btn-sm" tabindex="-1" role="button">Ny utstyrstype</a></div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
	  <th>Beskrivelse</th>
          <th>Endret</th>
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
          <td>&nbsp;</td>
        </tr>
<?php
      } else {
?>
        <tr>
	  <th><a href="<?php echo site_url('utstyr/utstyrstype/'.$Utstyrstype['UtstyrstypeID']); ?>"><?php echo $Utstyrstype['UtstyrstypeID']; ?></a></th>
	  <td><?php echo $Utstyrstype['Beskrivelse']; ?></td>
          <td><?php echo date('d.m.Y',strtotime($Utstyrstype['DatoEndret'])); ?></td>
	  <td><?php if ($Utstyrstype['AntallUtstyr'] > 0) { echo $Utstyrstype['AntallUtstyr']." stk"; } else { echo "&nbsp;"; } ?></td>
        </tr>
<?php
      }
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Utstyrstyper); ?> utstyrstyper</div>
</div>
