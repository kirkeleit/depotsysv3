<div class="card">
  <div class="card-header"><b>Utstyrsliste</b></div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>ID</th>
          <th>Produsent</th>
	  <th>Beskrivelse</th>
          <th>Antall</th>
          <th>Plassering</th>
	  <th>Endret</th>
          <th>Kontrollert</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
        <tr>
          <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo "-".$Utstyr['UtstyrID']; ?></a></th>
          <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
	  <td><?php echo $Utstyr['Beskrivelse']; ?></td>
          <td><?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { echo $Utstyr['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
          <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo "+".$Utstyr['LokasjonID']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo "=".$Utstyr['KasseID']; } else { echo "&nbsp;"; } ?></td>
	  <td><?php echo date("d.m.Y",strtotime($Utstyr['DatoEndret'])); ?></td>
	  <td><?php if ($Utstyr['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Utstyrsliste); ?> stk</div>
</div>