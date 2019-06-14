<div class="card">
  <div class="card-header text-right"><a href="<?php echo site_url('komponenter/nylokasjon'); ?>" class="btn btn-success btn-sm" tabindex="-1" role="button">Ny lokasjon</a></div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
	  <th>Navn</th>
          <th>Endret</th>
          <th>Komponenter</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Lokasjoner)) {
    foreach ($Lokasjoner as $Lokasjon) {
?>
        <tr>
	  <th><a href="<?php echo site_url('komponenter/lokasjon/'.$Lokasjon['LokasjonID']); ?>"><?php echo '+'.$Lokasjon['LokasjonID']; ?></a></th>
	  <td><?php echo $Lokasjon['Navn']; ?></td>
          <td><?php echo date('d.m.Y',strtotime($Lokasjon['DatoEndret'])); ?></td>
          <td>0 stk</td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Lokasjoner); ?> lokasjoner</div>
</div>
