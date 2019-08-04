<h2>Utstyrsliste<?php if (!empty($Materielliste)) { ?><small class="text-muted"> - Totalt <?php echo sizeof($Materielliste); ?> stk materiell</small><?php } ?></h2>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>Materiell ID</th>
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
  if (isset($Materielliste)) {
    foreach ($Materielliste as $Materiell) {
?>
      <tr<?php if ($Materiell['StatusID'] == 0) { ?> class="table-danger"<?php } ?>>
        <th><a href="<?php echo site_url('materiell/materiell/'.$Materiell['MateriellID']); ?>" class="text-nowrap"><?php echo "-".$Materiell['MateriellID']; ?></a></th>
        <td><?php echo $Materiell['ProdusentNavn']; ?></td>
        <td><?php echo $Materiell['Beskrivelse']; ?></td>
        <td><?php if (substr($Materiell['MateriellID'],-1,1) == 'T') { echo $Materiell['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php if (strlen($Materiell['LokasjonID']) > 0) { echo $Materiell['Lokasjon']; } else { echo "&nbsp;"; } ?><?php if (strlen($Materiell['KasseID']) > 0) { echo $Materiell['Kasse']; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo date("d.m.Y",strtotime($Materiell['DatoEndret'])); ?></td>
        <td><?php if ($Materiell['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Materiell['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
	<td class="text-center<?php if ($Materiell['AntallAvvik'] > 0) { echo ' bg-danger text-white'; } ?>"><?php if ($Materiell['AntallAvvik'] > 0) { ?><a href="<?php echo site_url('vedlikehold/avviksliste?filtermateriellid='.$Materiell['MateriellID']); ?>" class="text-white"><?php echo $Materiell['AntallAvvik'].' stk'; ?></a><?php } else { echo '&nbsp;'; } ?></td>
	<td class="text-center<?php if ($Materiell['StatusID'] == 1) { echo ' bg-success text-white'; } elseif ($Materiell['StatusID'] == 2) { echo ' bg-warning'; } ?>"><?php if ($Materiell['StatusID'] == 0) { echo "IKKE OPERATIVT"; } elseif ($Materiell['StatusID'] == 2) { echo "UTREGISTRERT"; } else { echo "OPERATIVT"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="9" class="text-center">Ingen materiell er registrert enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
