<h2>Utstyrsliste</h2>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>Utstyr ID</th>
        <th>Produsent</th>
        <th>Beskrivelse</th>
        <th>Antall</th>
        <th>Plassering</th>
        <th>Endret</th>
        <th>Kontrollert</th>
	<th>Åpne avvik</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <tr<?php if ($Utstyr['StatusID'] == 0) { ?> class="table-danger"<?php } ?>>
        <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo "-".$Utstyr['UtstyrID']; ?></a></th>
        <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
        <td><?php echo $Utstyr['Beskrivelse']; ?></td>
        <td><?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { echo $Utstyr['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo $Utstyr['Lokasjon']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo $Utstyr['Kasse']; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo date("d.m.Y",strtotime($Utstyr['DatoEndret'])); ?></td>
        <td><?php if ($Utstyr['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
	<td class="text-center<?php if ($Utstyr['AntallAvvik'] > 0) { echo ' bg-danger text-white'; } ?>"><?php if ($Utstyr['AntallAvvik'] > 0) { ?><a href="<?php echo site_url('utstyr/avviksliste?filterutstyrid='.$Utstyr['UtstyrID']); ?>"><?php echo $Utstyr['AntallAvvik'].' stk'; ?></a><?php } else { echo '&nbsp;'; } ?></td>
	<td class="text-center<?php if($Utstyr['StatusID'] == 1) { echo ' bg-success text-white'; } ?>"><?php if ($Utstyr['StatusID'] == 0) { echo "Ikke operativt"; } else { echo "Operativt"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="9" class="text-center">Ingen utstyr er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
