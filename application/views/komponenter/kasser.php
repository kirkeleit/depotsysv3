<div class="card">
  <div class="card-header text-right"><a href="<?php echo site_url('komponenter/nykasse'); ?>" class="btn btn-success btn-sm" tabindex="-1" role="button">Ny kasse</a></div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
	  <th>Navn</th>
          <th>Lokasjon</th>
          <th>Endret</th>
          <th>Komponenter</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Kasser)) {
    foreach ($Kasser as $Kasse) {
?>
        <tr>
	  <th><a href="<?php echo site_url('komponenter/kasse/'.$Kasse['KasseID']); ?>"><?php echo "=".str_pad($Kasse['KasseID'],2,'0',STR_PAD_LEFT); ?></a></th>
	  <td><?php echo $Kasse['Navn']; ?></td>
          <td><?php if (strlen($Kasse['LokasjonID']) > 0) { echo '+'.$Kasse['LokasjonID']; } ?></td>
          <td><?php echo date('d.m.Y',strtotime($Kasse['DatoEndret'])); ?></td>
          <td>0 stk</td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Kasser); ?> kasser</div>
</div>
