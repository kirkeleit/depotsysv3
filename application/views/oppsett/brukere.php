<h2>Brukere</h2>
<br />

<div class="card card-body">
<a href="<?php echo site_url('oppsett/nybruker'); ?>">Trykk her for å registrere ny bruker.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>#</th>
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
        <th><a href="<?php echo site_url('oppsett/bruker/'.$Bruker['BrukerID']); ?>"><?php echo $Bruker['BrukerID']; ?></a></th>
        <td><?php echo $Bruker['Fornavn'].' '.$Bruker['Etternavn']; ?></td>
        <td><?php echo $Bruker['Epostadresse']; ?></td>
        <td><?php echo $Bruker['Mobilnummer']; ?></td>
        <td><?php if ($Bruker['RolleID'] > 0) { echo $Bruker['Rolle']; } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="5" class="text-center">Ingen brukere er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
