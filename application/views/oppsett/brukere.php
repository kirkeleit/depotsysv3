<div class="card">
  <div class="card-header text-right"><a href="<?php echo site_url('oppsett/nybruker'); ?>" class="btn btn-success btn-sm" tabindex="-1" role="button">Ny bruker</a></div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>Navn</th>
          <th>E-post</th>
	  <th>Mobilnummer</th>
          <th>Rolle</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Brukere)) {
    foreach ($Brukere as $Bruker) {
?>
        <tr>
	  <th><a href="<?php echo site_url('oppsett/bruker/'.$Bruker['BrukerID']); ?>"><?php echo $Bruker['Fornavn'].' '.$Bruker['Etternavn']; ?></a></th>
          <td><?php echo $Bruker['Epostadresse']; ?></td>
	  <td><?php echo $Bruker['Mobilnummer']; ?></td>
          <td><?php if ($Bruker['RolleID'] > 0) { echo $Bruker['Rolle']; } else { echo "&nbsp;"; } ?></td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Brukere); ?> brukere</div>
</div>
