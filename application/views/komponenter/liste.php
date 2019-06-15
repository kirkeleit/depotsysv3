<div class="card">
  <div class="card-header">Komponenter</div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
          <th>Beskrivelse</th>
	  <th>Produsent</th>
          <th>Lokasjon</th>
          <th>Kasse</th>
          <th>Endret</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Komponenter)) {
    foreach ($Komponenter as $Komponent) {
?>
        <tr>
	  <th><a href="<?php echo site_url('komponenter/komponent/'.$Komponent['KomponentID']); ?>"><?php echo "-".$Komponent['KomponentID']; ?></a></th>
          <td><?php echo $Komponent['Beskrivelse']; ?></td>
	  <td><?php echo $Komponent['ProdusentNavn']; ?></td>
          <td><?php if (strlen($Komponent['LokasjonID']) > 0) { echo "+".$Komponent['LokasjonID']; } else { echo "&nbsp;"; } ?></td>
          <td><?php if (strlen($Komponent['KasseID']) > 0) { echo "=".$Komponent['KasseID']; } else { echo "&nbsp;"; } ?></td>
          <td><?php echo date("d.m.Y",strtotime($Komponent['DatoEndret'])); ?></td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Komponenter); ?> komponenter</div>
</div>
