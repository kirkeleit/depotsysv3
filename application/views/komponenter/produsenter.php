<div class="card">
  <div class="card-header text-right"><a href="<?php echo site_url('komponenter/nyprodusent'); ?>" class="btn btn-success btn-sm" tabindex="-1" role="button">Ny produsent</a></div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
	  <th>Navn</th>
          <th>Endret</th>
          <th>Nettsted</th>
          <th>Komponenter</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Produsenter)) {
    foreach ($Produsenter as $Produsent) {
?>
        <tr>
	  <th><a href="<?php echo site_url('komponenter/produsent/'.$Produsent['ProdusentID']); ?>"><?php echo $Produsent['ProdusentID']; ?></a></th>
	  <td><?php echo $Produsent['Navn']; ?></td>
          <td><?php echo date('d.m.Y',strtotime($Produsent['DatoEndret'])); ?></td>
          <td><?php echo $Produsent['Nettsted']; ?></td>
	  <td><?php if ($Produsent['KomponenterAntall'] > 0) { echo $Produsent['KomponenterAntall']." stk"; } else { echo "&nbsp;"; } ?></td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Produsenter); ?> produsenter</div>
</div>
