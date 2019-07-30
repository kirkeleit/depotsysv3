<h2>Brukere<?php if (!empty($Brukere)) { ?><small class="text-muted"> - Totalt <?php echo sizeof($Brukere); ?> brukere</small><?php } ?></h2>
<br />

<div class="card card-body">
<a href="<?php echo site_url('oppsett/nybruker'); ?>">Trykk her for å registrere ny bruker.</a>
</div>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
        <th>Navn</th>
        <th>E-post</th>
        <th>Mobilnummer</th>
	<th>Rolle</th>
        <th>Sist pålogget</th>
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
        <td><?php if ($Bruker['DatoSistInnlogget'] != '') { echo date('d.m.Y H:i:s',strtotime($Bruker['DatoSistInnlogget'])); } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="6" class="text-center">Ingen brukere er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
