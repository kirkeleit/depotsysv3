<div class="card">
  <div class="card-header text-right"><a href="<?php echo site_url('komponenter/nykomponenttype'); ?>" class="btn btn-success btn-sm" tabindex="-1" role="button">Ny komponenttype</a></div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
	  <th>Beskrivelse</th>
          <th>Endret</th>
          <th>Komponenter</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Komponenttyper)) {
    foreach ($Komponenttyper as $Komponenttype) {
?>
        <tr>
	  <th><a href="<?php echo site_url('komponenter/komponenttype/'.$Komponenttype['KomponenttypeID']); ?>"><?php echo $Komponenttype['KomponenttypeID']; ?></a></th>
	  <td><?php echo $Komponenttype['Beskrivelse']; ?></td>
          <td><?php echo date('d.m.Y',strtotime($Komponenttype['DatoEndret'])); ?></td>
	  <td><?php echo $Komponenttype['AntallKomponenter']; ?> stk</td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Komponenttyper); ?> komponenttyper</div>
</div>
